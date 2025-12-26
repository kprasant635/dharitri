<?php

class LAC_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLAC($dist_code = null)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query(
            "
        SELECT 
            l.*, 
            d.loc_name as district_name
        FROM lac_master l
        LEFT JOIN location d ON l.dist_id = d.dist_code 
            AND d.subdiv_code = '00' 
            AND d.cir_code = '00' 
            AND d.mouza_pargona_code = '00' 
            AND d.vill_townprt_code = '00000' 
            AND d.lot_no = '00'
        " . ($dist_code ? " WHERE l.dist_id = '$dist_code'" : "")
        );
        return $query->result_array();
    }

    public function getDistricts()
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT dist_code, loc_name as district_name 
                                FROM location 
                                WHERE subdiv_code = '00' 
                                AND cir_code = '00' 
                                AND mouza_pargona_code = '00' 
                                AND vill_townprt_code = '00000' 
                                AND lot_no = '00'");
        return $query->result_array();
    }

    public function getSubdivisionsByDistrict($dist_code)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT subdiv_code, loc_name as subdivision_name 
                                FROM location 
                                WHERE dist_code = ? 
                                AND subdiv_code != '00' 
                                AND cir_code = '00' 
                                AND mouza_pargona_code = '00' 
                                AND vill_townprt_code = '00000' 
                                AND lot_no = '00'", array($dist_code));
        return $query->result_array();
    }

    public function getSubdivisionName($dist_code, $subdiv_code)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT subdiv_code, loc_name as subdivision_name 
                                FROM location 
                                WHERE dist_code = ? 
                                AND subdiv_code = ? 
                                AND cir_code = '00' 
                                AND mouza_pargona_code = '00' 
                                AND vill_townprt_code = '00000' 
                                AND lot_no = '00'", array($dist_code, $subdiv_code));
        return $query->result_array();
    }

    public function getVillagesBySubdivision($dist_code, $subdiv_code)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("
            SELECT DISTINCT 
                uuid, 
                vill_townprt_code, 
                dist_code, 
                subdiv_code, 
                cir_code, 
                mouza_pargona_code, 
                lot_no, 
                loc_name as village_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = '00' AND vill_townprt_code = '00000') as mouza_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = l.lot_no AND vill_townprt_code = '00000') as lot_name
            FROM location l
            WHERE dist_code = ? 
            AND subdiv_code = ? 
            AND cir_code != '00' 
            AND mouza_pargona_code != '00' 
            AND lot_no != '00'
            AND vill_townprt_code != '00000'
            ORDER BY dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no", array($dist_code, $subdiv_code));

        $result = $query->result_array();

        // Format the results to include lot and mouza information in the village name
        foreach ($result as &$row) {
            $row['village_name'] = $row['village_name'] . " (Mouza: " . $row['mouza_name'] . ", Lot: " . $row['lot_name'] . ")";
        }


        return $result;
    }

    public function getAllVillagesByDistrict($dist_code)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("
            SELECT DISTINCT 
                uuid, 
                vill_townprt_code, 
                dist_code, 
                subdiv_code, 
                cir_code, 
                mouza_pargona_code, 
                lot_no, 
                loc_name as village_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = '00' AND vill_townprt_code = '00000') as mouza_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = l.lot_no AND vill_townprt_code = '00000') as lot_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as circle_name
            FROM location l
            WHERE dist_code = ? 
            AND subdiv_code != '00' 
            AND cir_code != '00' 
            AND mouza_pargona_code != '00' 
            AND lot_no != '00'
            AND vill_townprt_code != '00000'
            ORDER BY dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no", array($dist_code));

        $result = $query->result_array();

        // Format the results to include circle, lot and mouza information in the village name
        foreach ($result as &$row) {
            $row['village_name'] = $row['village_name'] . " (Unique ID: " . $row['uuid'] . ", Circle: " . $row['circle_name'] . ", Mouza: " . $row['mouza_name'] . ", Lot: " . $row['lot_name'] . ")";
        }

        return $result;
    }

    public function getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_townprt_code)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT uuid, vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, loc_name as village_name 
                            FROM location 
                            WHERE dist_code = ? 
                            AND subdiv_code = ? 
                            AND cir_code = ? 
                            AND mouza_pargona_code = ? 
                            AND lot_no = ? 
                            AND vill_townprt_code = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_townprt_code));
        return $query->result_array();
    }

    public function getVillageNamesBulk($village_codes)
    {
        if (empty($village_codes)) {
            return array();
        }

        $db = $this->load->database('auth', TRUE);

        // Build the WHERE conditions
        $where_conditions = array();
        $params = array();
        $code_mapping = array(); // To store the mapping between code components and ID

        foreach ($village_codes as $index => $code) {
            $key = implode('_', [
                $code['dist_code'],
                $code['subdiv_code'],
                $code['cir_code'],
                $code['mouza_code'],
                $code['lot_no'],
                $code['vill_townprt_code']
            ]);
            $code_mapping[$key] = $code['id'];

            $where_conditions[] = "(
                dist_code = ? AND 
                subdiv_code = ? AND 
                cir_code = ? AND 
                mouza_pargona_code = ? AND 
                lot_no = ? AND 
                vill_townprt_code = ?
            )";
            $params = array_merge($params, [
                $code['dist_code'],
                $code['subdiv_code'],
                $code['cir_code'],
                $code['mouza_code'],
                $code['lot_no'],
                $code['vill_townprt_code']
            ]);
        }


        $where_clause = implode(' OR ', $where_conditions);

        $query = $db->query(
            "SELECT 
                vill_townprt_code,
                dist_code,
                subdiv_code,
                cir_code,
                mouza_pargona_code,
                lot_no,
                loc_name as village_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = '00' AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as district_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as subdivision_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as circle_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = '00' AND vill_townprt_code = '00000') as mouza_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = l.lot_no AND vill_townprt_code = '00000') as lot_name
            FROM location l
            WHERE " . $where_clause,
            $params
        );

        if (!$query) {
            log_message('error', 'DB error: ' . $db->last_query());
            return array();
        }

        $result = $query->result_array();

        // Format the results to include lot and mouza information in the village name and add the ID
        foreach ($result as &$row) {
            $key = implode('_', [
                $row['dist_code'],
                $row['subdiv_code'],
                $row['cir_code'],
                $row['mouza_pargona_code'],
                $row['lot_no'],
                $row['vill_townprt_code']
            ]);


            $row['id'] = $code_mapping[$key];


            $row['village_name'] = $row['village_name'] . " (Mouza: " . $row['mouza_name'] . ", Lot: " . $row['lot_name'] . ")";
        }

        return $result;
    }

    public function saveLACMapping($data)
    {
        $db = $this->load->database('auth', TRUE);
        $success = false;
        $message = '';
        $existing_records = [];
        $inserted_records = [];
        $existing_records_with_ids = [];

        try {
            // Start transaction
            $db->trans_begin();

            $lac_id = $data['lac_id'];
            $adc_id = $data['adc_id'] . '_' . $this->session->userdata('dist_code');
            $selected_villages = $data['selected_villages'];

            foreach ($selected_villages as $full_code) {
                // Split the concatenated code
                list($uuid, $dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_townprt_code) = explode('_', $full_code);

                // Check if record exists and get its ID
                $existing_record = $db->select('id')
                    ->where(array(
                        'lac_id' => $lac_id,
                        'loc_uuid' => $uuid,
                        'adc_id' => $adc_id,
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code
                    ))
                    ->get('lac_transactions')
                    ->row();

                if ($existing_record) {
                    $existing_records[] = $full_code;
                    $existing_records_with_ids[$full_code] = $existing_record->id;
                    continue;
                }


                $insert_data = array(
                    'lac_id' => $lac_id,
                    'loc_uuid' => $uuid,
                    'adc_id' => $adc_id,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code
                );

                $inserted = $db->insert('lac_transactions', $insert_data);

                if (!$inserted) {
                    throw new Exception('Failed to insert record for village: ' . $full_code);
                }
                
                $inserted_records[] = $full_code;
            }


            // If we reach here, all inserts were successful
            if ($db->trans_status() === FALSE) {
                $db->trans_rollback();
                $message = 'Transaction failed';
            } else {
                $db->trans_commit();
                $success = true;
                
                // Build appropriate message
                $total = count($selected_villages);
                $inserted_count = count($inserted_records);
                $existing_count = count($existing_records);
                
                // Prepare existing records message with database IDs
                $existing_records_message = [];
                foreach ($existing_records as $record) {
                    $db_id = $existing_records_with_ids[$record] ?? 'N/A';
                    $existing_records_message[] = "$record (DB ID: $db_id)";
                }
                
                if ($inserted_count > 0 && $existing_count > 0) {
                    $message = "$inserted_count records inserted successfully. $existing_count records already existed.";
                    if (!empty($existing_records_message)) {
                        $message .= " Existing records: " . implode(', ', $existing_records_message);
                    }
                } elseif ($inserted_count > 0) {
                    $message = "All $inserted_count records inserted successfully.";
                } elseif ($existing_count > 0) {
                    $message = "All $existing_count records already exist. No new records were added.";
                    if (!empty($existing_records_message)) {
                        $message .= " Existing records: " . implode(', ', $existing_records_message);
                    }
                } else {
                    $message = 'No records were processed.';
                }
            }
        } catch (Exception $e) {
            $db->trans_rollback();
            $message = 'Error: ' . $e->getMessage();
            log_message('error', $message);
        }

        return [
            'success' => $success,
            'message' => $message,
            'inserted_count' => count($inserted_records),
            'existing_count' => count($existing_records),
            'existing_records' => $existing_records,
            'existing_records_with_ids' => $existing_records_with_ids
        ];
    }

    public function getTempData($adc_id, $lac_id = null)
    {
        $db = $this->load->database('auth', TRUE);
        $dist_code = $this->session->userdata('dist_code');
        $adc_id = $adc_id . '_' . $dist_code;
        $query = $db->query("SELECT 
                                ltm.id,
                                ltm.lac_id,
                                lm.name as lac_name,
                                ltm.dist_code,
                                ltm.subdiv_code,
                                ltm.cir_code,
                                ltm.mouza_pargona_code as mouza_code,
                                ltm.lot_no,
                                ltm.vill_townprt_code
                            FROM lac_transactions ltm
                            JOIN lac_master lm ON ltm.lac_id = lm.id
                            WHERE ltm.adc_id = ?
                            AND ltm.status = 't'" . ($lac_id ? " AND ltm.lac_id = ? " : ""), array($adc_id, $lac_id ?? null));

        log_message('debug', $db->last_query());
        return $query->result_array();
    }

    public function getLacList($dist_code = null)
    {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT id as lac_id, name as lac_name FROM lac_master" . ($dist_code ? " WHERE dist_id = '$dist_code'" : ""));

        return $query->result_array();
    }

    public function getFinalizeDataByLacId($lac_id, $status = null)
    {
        $designation = $this->session->userdata('user_desig_code');
        $db = $this->load->database('auth', TRUE);
        $dist_code = $this->session->userdata('dist_code');
        $adc_id = $this->session->userdata('user_code');
        $adc_id = $adc_id . '_' . $dist_code;

        $query = $db->query("
        SELECT 
            ltm.id,
            ltm.lac_id,
            ltm.status,
            lm.name as lac_name,
            ltm.dist_code,
            ltm.subdiv_code,
            ltm.cir_code,
            ltm.mouza_pargona_code as mouza_code,
            ltm.lot_no,
            ltm.vill_townprt_code
        FROM lac_transactions ltm
        JOIN lac_master lm ON ltm.lac_id = lm.id
        WHERE  ltm.lac_id = ?
        AND status = ? 
        " . ($designation == 'DC' ? '' : "AND ltm.adc_id = ?") . "
        
        ", array(
            $lac_id,
            $status,
            $designation == 'DC' ? null : $adc_id,
        ));

        return $query->result_array();
    }

    public function finalizeLACMapping($adc_id, $remarks, $lac_id = null)
    {
        $dist_code = $this->session->userdata('dist_code');
        $db = $this->load->database('auth', TRUE);
        $adc_id = $adc_id . '_' . $dist_code;
        $db->where('adc_id', $adc_id);
        $db->where('status', 't');
        if ($lac_id) {
            $db->where('lac_id', $lac_id);
        }
        $db->update('lac_transactions', array('status' => 'f', 'adc_remarks' => $remarks));


        return $db->affected_rows() > 0;
    }


    public function approveLAC($lac_id)
    {
        $dc_id = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        $dc_id = $dc_id . '_' . $dist_code;

        $db = $this->load->database('auth', TRUE);
        $db->where('lac_id', $lac_id);
        $db->where('status', 'f');
        $db->update('lac_transactions', array('status' => 'a', 'dc_id' => $dc_id));
        return $db->affected_rows() > 0;
    }

    public function deleteTransaction($id)
    {
        $db = $this->load->database('auth', TRUE);

        try {
            $db->trans_start();

            $db->where('id', $id);
            $db->where('status', 't');
            $db->delete('lac_transactions');

            $db->trans_complete();

            if ($db->trans_status() === FALSE) {
                log_message('error', 'Failed to delete transaction with ID: ' . $id);
                return false;
            }

            return $db->affected_rows() > 0;
        } catch (Exception $e) {
            $db->trans_rollback();
            log_message('error', 'Error in deleteTransaction: ' . $e->getMessage());
            return false;
        }
    }

    public function getVillageNamesBulkFinalize($village_codes)
    {
        if (empty($village_codes)) {
            return array();
        }

        // die;

        $db = $this->load->database('auth', TRUE);

        // Build the WHERE conditions
        $where_conditions = array();
        $params = array();
        $code_mapping = array(); // To store the mapping between code components and ID as

        foreach ($village_codes as $index => $code) {
            $key = implode('_', [
                $code['dist_code'],
                $code['subdiv_code'],
                $code['cir_code'],
                $code['mouza_code'],
                $code['lot_no'],
                $code['vill_townprt_code']
            ]);

            $where_conditions[] = "(
                dist_code = ? AND 
                subdiv_code = ? AND 
                cir_code = ? AND 
                mouza_pargona_code = ? AND 
                lot_no = ? AND 
                vill_townprt_code = ?
            )";
            $params = array_merge($params, [
                $code['dist_code'],
                $code['subdiv_code'],
                $code['cir_code'],
                $code['mouza_code'],
                $code['lot_no'],
                $code['vill_townprt_code']
            ]);
        }


        $where_clause = implode(' OR ', $where_conditions);

        $query = $db->query(
            "SELECT 
                vill_townprt_code,
                dist_code,
                subdiv_code,
                cir_code,
                mouza_pargona_code,
                lot_no,
                loc_name as village_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = '00' AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as district_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as subdivision_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000') as circle_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = '00' AND vill_townprt_code = '00000') as mouza_name,
                (SELECT loc_name FROM location WHERE dist_code = l.dist_code AND subdiv_code = l.subdiv_code AND cir_code = l.cir_code AND mouza_pargona_code = l.mouza_pargona_code AND lot_no = l.lot_no AND vill_townprt_code = '00000') as lot_name
            FROM location l
            WHERE " . $where_clause,
            $params
        );

        if (!$query) {
            log_message('error', 'DB error: ' . $db->last_query());
            return array();
        }

        $result = $query->result_array();

        // Format the results to include lot and mouza information in the village name and add the ID
        foreach ($result as &$row) {
            $key = implode('_', [
                $row['dist_code'],
                $row['subdiv_code'],
                $row['cir_code'],
                $row['mouza_pargona_code'],
                $row['lot_no'],
                $row['vill_townprt_code']
            ]);


            $row['village_name'] = $row['village_name'] . " (Mouza: " . $row['mouza_name'] . ", Lot: " . $row['lot_name'] . ")";
        }

        // var_dump($result);
        // die;

        return $result;
    }
}
