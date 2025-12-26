<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Query Guard configuration
// Global, low-touch safety net to block obviously dangerous SQL.

$config['query_guard_enabled'] = true;                 // master switchcons
$config['query_guard_block_ddl'] = true;               // DROP/TRUNCATE/ALTER
$config['query_guard_block_delete_no_where'] = true;   // DELETE without WHERE
$config['query_guard_block_update_no_where'] = true;  // UPDATE without WHERE (set true to enforce)
$config['query_guard_block_where_true'] = true;        // Block WHERE true / 1=1 on DELETE/UPDATE
$config['query_guard_block_all_delete'] = true;       // Block ALL DELETE statements unless table allowlisted
$config['query_guard_block_stacked'] = true;           // Block stacked/multi-statements (e.g., '...; DELETE ...')
$config['query_guard_json_error'] = true;              // When blocked, respond with JSON error (testing/dev)
$config['query_guard_block_broad_predicates'] = true;  // Block broad DELETE predicates like id>=0, id IS NOT NULL
$config['query_guard_log_only'] = false;               // If true, only logs; doesn’t block

// Optional allowlist regex (case-insensitive) — statements matching won’t be blocked.
// Example: allow maintenance table cleanup by name
$config['query_guard_allow_regex'] = null; // e.g. '/^truncate\s+temp_/'

// Optional allowlist of tables where mass DELETE is allowed (no WHERE / tautology allowed)
// Accepts exact table names or regex patterns (case-insensitive). Schema-qualified names supported.
// Examples: [ 'temp_cleanup', '/^queue_/' ]
$config['query_guard_allow_delete_tables'] = ['ci_sessions','rejected_remark','allowed_landclass_code', 'allowed_landclass_master', 'apcancel_dag_details', 'apcancel_petition_pattadar', 'application_permissions', 'basundhar_application', 'cert_dag_details', 'chitha', 'chitha_basic_entry', 'chitha_dag_flag', 'chitha_dag_pattadar_entry', 'chitha_fruit', 'Chitha_MCrop', 'chitha_noncrop', 'chitha_pattadar_entry', 'chitha_pattadar_view', 'chitha_rmk_other_opp_party', 'ci_sessions', 'current_doul_approve', 'current_doul_demand', 'current_dp_doul_approve', 'current_dp_doul_demand', 'c_land_bank_details', 'c_land_bank_encroacher_details', 'dagwise_zone_info', 'dlc_copy_to', 'ekhajana_demand_satisfy_year', 'Field_Mut_Basama_dag', 'jama_patta, jama_pattadar', 'lac_transactions', 'landclass_adc_mapping', 'landclass_code', 'landclass_mapping_cases', 'land_bank_details', 'land_bank_encroacher_details', 'land_share_details', 'land_share_indivisual_details', 'mapping_of_industrial_corridor_dags', 'master_gender', 'minister_visit_details', 'minute_meeting_copy_to', 'nok_tmp', 'Patta', 'patta_code_mapping_cases', 'property_details', 'reclass_dag_eligibility', 'settlement_additional_property', 'settlement_applicant', 'settlement_approval_transaction', 'settlement_circle_cluster_cases', 'settlement_dag_details', 'Field_Mut_dag_details', 'Field_Mut_objection', 'settlement_deleted_data', 'settlement_land_bank_details', 'settlement_nominee', 'settlement_nominee_transaction', 'settlement_notice', 'settlement_proposal_cases', 'settlement_proposal_list', 'settlement_reservation', 'settlement_tenent_beneficiary', 'settlement_vgr_pgr_reservation', 'settlement_vgr_pgr_revert_cases', 'teagrant_is_mutated', 'temp_khatian', 'temp_tenant', 'transaction', 't_property_house', 't_property_pattadar', 'user_attached_mapping', 'villagewise_zone_info']; // e.g., ['temp_cleanup', '/^queue_/']

// Exempt tables for UPDATE guards (skip UPDATE-without-WHERE/tautology checks)
// Defaults to ['ci_sessions'] inside helper if not set
$config['query_guard_update_exempt_tables'] = ['ci_sessions'];
