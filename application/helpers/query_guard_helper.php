<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('query_guard_check_sql')) {
    function query_guard_check_sql($sql)
    {
        // Load config if possible
        $cfg = [
            'query_guard_enabled' => true,
            'query_guard_block_ddl' => true,
            'query_guard_block_delete_no_where' => true,
            'query_guard_block_update_no_where' => true,
            'query_guard_block_where_true' => true,
            'query_guard_block_all_delete' => true,
            'query_guard_block_stacked' => true,
            'query_guard_block_broad_predicates' => true,
            'query_guard_allow_regex' => null,
            'query_guard_allow_delete_tables' => ['ci_sessions','rejected_remark','allowed_landclass_code', 'allowed_landclass_master', 'apcancel_dag_details', 'apcancel_petition_pattadar', 'application_permissions', 'basundhar_application', 'cert_dag_details', 'chitha', 'chitha_basic_entry', 'chitha_dag_flag', 'chitha_dag_pattadar_entry', 'chitha_fruit', 'Chitha_MCrop', 'chitha_noncrop', 'chitha_pattadar_entry', 'chitha_pattadar_view', 'chitha_rmk_other_opp_party', 'ci_sessions', 'current_doul_approve', 'current_doul_demand', 'current_dp_doul_approve', 'current_dp_doul_demand', 'c_land_bank_details', 'c_land_bank_encroacher_details', 'dagwise_zone_info', 'dlc_copy_to', 'ekhajana_demand_satisfy_year', 'Field_Mut_Basama_dag', 'jama_patta, jama_pattadar', 'lac_transactions', 'landclass_adc_mapping', 'landclass_code', 'landclass_mapping_cases', 'land_bank_details', 'land_bank_encroacher_details', 'land_share_details', 'land_share_indivisual_details', 'mapping_of_industrial_corridor_dags', 'master_gender', 'minister_visit_details', 'minute_meeting_copy_to', 'nok_tmp', 'Patta', 'patta_code_mapping_cases', 'property_details', 'reclass_dag_eligibility', 'settlement_additional_property', 'settlement_applicant', 'settlement_approval_transaction', 'settlement_circle_cluster_cases', 'settlement_dag_details', 'Field_Mut_dag_details', 'Field_Mut_objection', 'settlement_deleted_data', 'settlement_land_bank_details', 'settlement_nominee', 'settlement_nominee_transaction', 'settlement_notice', 'settlement_proposal_cases', 'settlement_proposal_list', 'settlement_reservation', 'settlement_tenent_beneficiary', 'settlement_vgr_pgr_reservation', 'settlement_vgr_pgr_revert_cases', 'teagrant_is_mutated', 'temp_khatian', 'temp_tenant', 'transaction', 't_property_house', 't_property_pattadar', 'user_attached_mapping', 'villagewise_zone_info'],
            'query_guard_update_exempt_tables' => ['ci_sessions'],
        ];
        if (function_exists('get_instance')) {
            $CI = get_instance();
            if ($CI && isset($CI->config)) {
                // Load without namespacing so item() can read values directly
                $CI->config->load('query_guard');
                $keys = array(
                    'query_guard_enabled',
                    'query_guard_block_ddl',
                    'query_guard_block_delete_no_where',
                    'query_guard_block_update_no_where',
                    'query_guard_block_where_true',
                    'query_guard_block_all_delete',
                    'query_guard_block_stacked',
                    'query_guard_block_broad_predicates',
                    'query_guard_allow_regex',
                    'query_guard_allow_delete_tables',
                    'query_guard_json_error',
                    'query_guard_log_only',
                );
                foreach ($keys as $k) {
                    $v = $CI->config->item($k);
                    if ($v === NULL) { $v = $CI->config->item($k, 'query_guard'); }
                    if ($v !== NULL) { $cfg[$k] = $v; }
                }
            }
        }
        if (empty($cfg['query_guard_enabled'])) return true;

        // Normalize SQL (final string, binds already applied by driver)
        $s = trim(preg_replace(['#\/\*.*?\*\/#s','/--.*?(\r?\n|$)/','/#.*?(\r?\n|$)/'], ' ', $sql));

        // Optional allow regex
        if (!empty($cfg['query_guard_allow_regex']) && @preg_match($cfg['query_guard_allow_regex'], $s)) {
            return true;
        }

        // Mask string literals before looking for semicolons
        $masked = _qg_mask_strings($s);
        $is_stacked = strpos($masked, ';') !== false;

        // Special-case: ignore semicolons ONLY for ci_sessions UPDATE to avoid false positives
        $exempt_semicolon_for_update = false;
        if (preg_match('/^\s*update\s+([^\s;]+)\s+set\b/i', $s, $um)) {
            $updTableForSemicolon = _qg_unquote_ident_sql($um[1]);
            $exemptList = isset($cfg['query_guard_update_exempt_tables']) ? (array)$cfg['query_guard_update_exempt_tables'] : array('ci_sessions','ci_session');
            foreach ($exemptList as $ex) {
                if ($ex !== '' && strcasecmp($updTableForSemicolon, $ex) === 0) { $exempt_semicolon_for_update = true; break; }
            }
        }

        // Block any stacked multi-statement query (after masking string literals),
        // except when explicitly exempted (e.g., ci_sessions UPDATE)
        if ($is_stacked && !empty($cfg['query_guard_block_stacked']) && !$exempt_semicolon_for_update) {
            return false;
        }

        // Do not split on semicolons in unmasked SQL to avoid breaking inside literals
        $stmts = [$s];

        foreach ($stmts as $stmt) {
            $t = trim($stmt);
            if ($t === '') continue;
            // DDL
            if (!empty($cfg['query_guard_block_ddl']) && preg_match('/^\s*(drop|truncate|alter)\b/i', $t)) return false;
            // DELETE (also catch when preceded by CTE: WITH ... DELETE FROM ...)
            if (preg_match('/\bdelete\s+from\b/i', $t)) {
                // Allowlist: skip all delete-block rules if table is allowlisted
                $delTable = _qg_extract_table_from_delete_sql($t);
                if (!empty($cfg['query_guard_allow_delete_tables']) && $delTable !== '') {
                    foreach ((array)$cfg['query_guard_allow_delete_tables'] as $pat) {
                        if ($pat === '' || $pat === NULL) continue;
                        if ($pat[0] === '/') { if (@preg_match($pat, $delTable)) { continue 2; } }
                        else { if (strcasecmp($pat, $delTable) === 0) { continue 2; } }
                    }
                }
                if (!empty($cfg['query_guard_block_all_delete'])) return false;
                if (!empty($cfg['query_guard_block_delete_no_where']) && !preg_match('/\bwhere\b/i', $t)) return false;
                if (!empty($cfg['query_guard_block_where_true'])) {
                    // 1) Tautology immediately after WHERE (legacy pattern)
                    if (preg_match('/\bwhere\s*(?:\(|\s)*(?:true|1\s*=\s*1|0\s*<\s*1|\'\'\s*=\s*\'\'|""\s*=\s*"")/i', $t)) return false;
                    // 2) Tautology appearing later in the WHERE via OR (e.g., id=0 OR TRUE, OR 1=1)
                    if (preg_match('/\bwhere\b(.*)$/i', $t, $wm)) {
                        $where = $wm[1];
                        $whereMasked = _qg_mask_strings($where);
                        if (preg_match('/\bor\s*(?:\(|\s)*(?:true|1\s*=\s*1|0\s*<\s*1|\'\'\s*=\s*\'\'|""\s*=\s*"")/i', $whereMasked)) return false;
                    }
                }
                // 3) Broad predicate heuristics (optional)
                if (!empty($cfg['query_guard_block_broad_predicates']) && preg_match('/\bwhere\b(.*)$/i', $t, $wm2)) {
                    $whereB = _qg_mask_strings($wm2[1]);
                    // id >= 0 or id IS NOT NULL — support optional alias (t.id), quotes, and parentheses around identifier
                    if (preg_match('/\b(?:\(+\s*)?(?:[a-zA-Z_][\w]*\.)?"?id"?\s*\)?\s*>=\s*0\b/i', $whereB)) return false;
                    if (preg_match('/\b(?:\(+\s*)?(?:[a-zA-Z_][\w]*\.)?"?id"?\s*\)?\s+is\s+not\s+null\b/i', $whereB)) return false;
                    // created_at < NOW() + INTERVAL '1 year' (broad time window)
                    if (preg_match('/\b(created(_at)?|updated(_at)?|modified(_at)?)\b\s*<\s*now\s*\(\)\s*\+\s*interval\b/i', $whereB)) return false;
                    // Self IN subselect: DELETE FROM t WHERE id IN (SELECT id FROM t)
                    $delTable = _qg_extract_table_from_delete_sql($t);
                    if ($delTable && preg_match('/\bin\s*\(\s*select\s+\w+\s+from\s+([\w\.]+)/i', $whereB, $mIn)) {
                        $innerFrom = _qg_unquote_ident_sql($mIn[1]);
                        if (strcasecmp($innerFrom, $delTable) === 0) return false;
                    }
                }
            }
            // UPDATE
            if (preg_match('/^\s*update\s+\S+\s+set\b/i', $t)) {
                // Exempt specific tables (e.g., ci_sessions) from update guards
                $updTable = _qg_extract_table_from_update_sql($t);
                $exempt = isset($cfg['query_guard_update_exempt_tables']) ? (array)$cfg['query_guard_update_exempt_tables'] : array('ci_sessions','ci_session');
                foreach ($exempt as $ex) {
                    if ($ex !== '' && strcasecmp($updTable, $ex) === 0) {
                        // Skip update-related blocking for exempted tables
                        continue 2; // next statement
                    }
                }
                if (!empty($cfg['query_guard_block_update_no_where'])) {
                    if (!preg_match('/\bwhere\b/i', $t)) return false;
                    if (!empty($cfg['query_guard_block_where_true']) && preg_match('/\bwhere\s*(?:\(|\s)*(?:true|1\s*=\s*1|0\s*<\s*1|\'\'\s*=\s*\'\'|""\s*=\s*"")/i', $t)) return false;
                }
            }
        }
        return true;
    }

function _qg_mask_strings($s)
    {
        $s = preg_replace("/'(?:''|[^'])*'/s", "''", $s);
        $s = preg_replace('/"(?:\\"|[^"])*"/s', '""', $s);
        $s = preg_replace('/\$[^$]*\$.*?\$[^$]*\$/s', '$$ $$', $s);
        return $s;
    }
}

if (!function_exists('_qg_extract_table_from_delete_sql')) {
    function _qg_extract_table_from_delete_sql($sql)
    {
        if (preg_match('/\bdelete\s+from\s+([^\s;]+)/i', $sql, $m)) {
            return _qg_unquote_ident_sql($m[1]);
        }
        return '';
    }
}

if (!function_exists('_qg_extract_table_from_update_sql')) {
    function _qg_extract_table_from_update_sql($sql)
    {
        if (preg_match('/^\s*update\s+([^\s;]+)\s+set\b/i', $sql, $m)) {
            return _qg_unquote_ident_sql($m[1]);
        }
        return '';
    }
}

if (!function_exists('_qg_unquote_ident_sql')) {
    function _qg_unquote_ident_sql($ident)
    {
        $id = trim($ident);
        $id = preg_replace('/^\"(.+)\"$/', '$1', $id);
        if (strpos($id, '.') !== false) { $parts = explode('.', $id); $id = end($parts); }
        return trim($id, '"');
    }
}
if (!function_exists('query_guard_block')) {
    function query_guard_block($sql)
    {
        if (function_exists('log_message')) {
            log_message('error', 'QueryGuard blocked in driver: '.$sql);
        }
        // Prefer JSON error if configured
        $use_json = false;
        if (function_exists('get_instance')) {
            $CI = get_instance();
            if ($CI && isset($CI->config)) {
                $CI->config->load('query_guard', true);
                $qg = $CI->config->item('query_guard');
                if (is_array($qg) && !empty($qg['query_guard_json_error'])) { $use_json = true; }
            }
        }
        if ($use_json) {
            if (!headers_sent()) {
                http_response_code(403);
                header('Content-Type: application/json');
            }
            echo json_encode(array(
                'status' => 'error',
                'code' => 403,
                'message' => 'Query blocked',
                'sql' => $sql,
            ));
            exit;
        }
        if (function_exists('show_error')) { show_error('Operation not allowed', 403, 'Query blocked'); }
        return FALSE;
    }
}
