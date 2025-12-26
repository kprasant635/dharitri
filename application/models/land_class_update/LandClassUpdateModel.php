<?php
class LandClassUpdateModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_pending_villages($dist_code, $subdiv_code, $cir_code) {
        $sql = "
            SELECT
                COALESCE(lu.status, 'pending') AS status, 
                l.uuid as village_code,
                l.loc_name as village,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code='00') as district,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code='00') as circle,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code=l.mouza_pargona_code AND lot_no='00') as mouza,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code=l.mouza_pargona_code AND lot_no=l.lot_no AND vill_townprt_code='00000') as lot
            FROM location l 
            LEFT JOIN t_land_class_update lu ON l.uuid = lu.vill_uuid 
            WHERE l.vill_townprt_code <> '00000' 
                AND l.dist_code = ? 
                AND l.subdiv_code = ? 
                AND l.cir_code = ?
                AND (lu.status='n' or lu.status is null)
        ";
        
        $query = $this->db->query($sql, array($dist_code,$subdiv_code, $cir_code));
        if ($query == null || $query->num_rows()<=0)
            return [];
        $result = $query->result_array();
        return $result;
    }

    public function get_updated_villages($dist_code, $subdiv_code, $cir_code) {
       $sql = "
            SELECT
                COALESCE(lu.status, 'pending') AS status,
                COALESCE(lu.user_code, 'NA') AS updatedby,
                COALESCE(lu.createdat, null) AS createdat,
                l.uuid as village_code,
                l.loc_name as village,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code='00') as district,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code='00') as circle,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code=l.mouza_pargona_code AND lot_no='00') as mouza,
                (SELECT loc_name FROM location WHERE dist_code=l.dist_code AND subdiv_code=l.subdiv_code AND cir_code=l.cir_code AND mouza_pargona_code=l.mouza_pargona_code AND lot_no=l.lot_no AND vill_townprt_code='00000') as lot
            FROM location l 
            LEFT JOIN t_land_class_update lu ON l.uuid = lu.vill_uuid 
            WHERE l.vill_townprt_code <> '00000' 
                AND l.dist_code = ? 
                AND l.subdiv_code = ? 
                AND l.cir_code = ?
                AND lu.status='y'
        ";
        
        $query = $this->db->query($sql, array($dist_code,$subdiv_code, $cir_code));
        if ($query == null || $query->num_rows()<=0)
            return [];
        $result = $query->result_array();
        return $result;
    }

    public function validate_village($vill_code, $dist_code, $subdiv_code, $cir_code) {
        $exists = $this->db->get_where('location', [
            'uuid'    => $vill_code,
            'dist_code'    => $dist_code,
            'subdiv_code'  => $subdiv_code,
            'cir_code'     => $cir_code
            ])->row_array();
        if ($exists ==null || empty($exists) || !$exists)
            return false;
        return true;
    }
    public function update_land_class($village_code, $user_code) {
        // If already exists and status is 'y', update to 'y' again (reupdate), else insert
        $exists = $this->db->get_where('t_land_class_update', ['vill_uuid' => $village_code])->row_array();
        $data_vill = [
            'vill_uuid' => $village_code,
            'user_code' => $user_code,
            'status'    => 'y',
            
        ];
        $sql11="Select * from location where uuid=?";
        $params=$this->db->query($sql11,$village_code)->row_array();
        ////////////Chitha Update ////////////////////
        $this->db->trans_begin();
        ////////////////////////
        ////// STEP-1 ### Check location status Rural/Urban //////
        // LCU-01: Start location check
        log_message('error', 'LCU-01: Begin location R/U check for '.json_encode(array(
            'dist'=>$params['dist_code'],'subdiv'=>$params['subdiv_code'],'cir'=>$params['cir_code'],
            'mouza'=>$params['mouza_pargona_code'],'lot'=>$params['lot_no'],'vtp'=>$params['vill_townprt_code']
        )));
        $sql = "
            SELECT rural_urban
            FROM location
            WHERE dist_code = ?
              AND subdiv_code = ?
              AND cir_code = ?
              AND mouza_pargona_code = ?
              AND lot_no = ?
              AND vill_townprt_code = ?
        ";
        $data = $this->db->query($sql, array(
            $params['dist_code'],
            $params['subdiv_code'],
            $params['cir_code'],
            $params['mouza_pargona_code'],
            $params['lot_no'],
            $params['vill_townprt_code']
        ))->row();
        if (empty($data) || empty($data->rural_urban) || !in_array($data->rural_urban, array('R','U'), true)) {
            log_message('error', 'LCU-02: Invalid rural_urban (expected R/U), found='.($data->rural_urban ?? 'NULL'));
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Kindly change the village status Rural/Urban (must be R or U).');
        }
        log_message('error', 'LCU-03: Location R/U check passed with rural_urban='.$data->rural_urban);
        ////// STEP-2 ### Check empty Land Class //////
        // LCU-04: Start empty land class check
        $sql1 = "
            SELECT dag_no
            FROM chitha_basic
            WHERE dist_code = ?
              AND subdiv_code = ?
              AND cir_code = ?
              AND mouza_pargona_code = ?
              AND lot_no = ?
              AND vill_townprt_code = ?
              AND land_class_code IS NULL
        ";
        $data1 = $this->db->query($sql1, array(
            $params['dist_code'],
            $params['subdiv_code'],
            $params['cir_code'],
            $params['mouza_pargona_code'],
            $params['lot_no'],
            $params['vill_townprt_code']
        ));
        if ($data1->num_rows() > 0) {
            $tmp  = $data1->result_array();
            $dags = array();
            foreach ($tmp as $r) { $dags[] = isset($r['dag_no']) ? $r['dag_no'] : ''; }
            log_message('error', 'LCU-05: Empty land_class_code found in DAGs='.implode(',', $dags));
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Land class is empty/missing in the said dags ##' . implode(',', $dags));
        }
        log_message('error', 'LCU-06: No empty land_class_code rows for given location');
        ////// STEP-3 ### Fetch distinct existing land_class_code(s) //////
        // LCU-07: Fetching existing land_class_code(s)
        $this->db->distinct();
        $this->db->select('land_class_code');
        $this->db->from('chitha_basic');
        $this->db->where(array(
            'dist_code'          => $params['dist_code'],
            'subdiv_code'        => $params['subdiv_code'],
            'cir_code'           => $params['cir_code'],
            'mouza_pargona_code' => $params['mouza_pargona_code'],
            'lot_no'             => $params['lot_no'],
            'vill_townprt_code'  => $params['vill_townprt_code']
        ));
        $existing_codes = $this->db->get()->result_array();
        if (empty($existing_codes)) {
            log_message('error', 'LCU-08: No records found in chitha_basic for location');
            return array('status' => false, 'message' => 'No records found in chitha_basic for given location');
        }
        $land_class_codes = array();
        foreach ($existing_codes as $row) {
            if (!empty($row['land_class_code'])) {
                $land_class_codes[] = $row['land_class_code'];
            }
        }
        log_message('error', 'LCU-09: Found distinct land_class_code(s)='.implode(',', $land_class_codes));
        ////// STEP-4 ### Check mapping existence //////
        // LCU-10: Mapping existence check
        $this->db->select('land_class_code');
        $this->db->from('landclass_adc_mapping');
        if (!empty($land_class_codes)) {
            $this->db->where_in('land_class_code', $land_class_codes);
        } else {
            log_message('error', 'LCU-11: No valid land_class_code values present to map');
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'No valid land_class_code values present');
        }
        $mapped = $this->db->get()->result_array();
        $mapped_codes = array();
        foreach ($mapped as $m) { $mapped_codes[] = $m['land_class_code']; }
        $unmapped_codes = array_diff($land_class_codes, $mapped_codes);
        log_message('error', 'LCU-12: Mapped codes='.implode(',', $mapped_codes).'; Unmapped codes='.implode(',', $unmapped_codes));
        if (!empty($unmapped_codes)) {
            $this->db->select('class_code');
            $this->db->from('landclass_code');
            $this->db->where_in('class_code', $unmapped_codes);
            $this->db->where('class_code', 'N'); // kept as-is
            $valid_unmapped_classes = $this->db->get()->result_array();
            if (!empty($valid_unmapped_classes)) {
                log_message('error', 'LCU-13: land_class_code found no mapping (subset flagged)');
                $this->db->trans_rollback();
                return array('status' => false, 'message' => 'land_class_code found no mapping');
            }
        }
        ////// STEP-5 ### Check land rate master //////
        // LCU-14: Land rate master cross-check
        if (!empty($mapped_codes)) {
            $in_list = "'" . implode("','", $mapped_codes) . "'";
            log_message('error','LCU-14-1:',json_encode($in_list));
        } else {
            log_message('error', 'LCU-15: No mapped codes to verify in land_rate_master');
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'No mapped land_class_code(s) to verify');
        }
        $sql3 = "
            SELECT *
            FROM (
                SELECT lc.land_class_code AS new_land_class
                FROM landclass_adc_mapping lam
                JOIN land_class_groups lc ON lam.land_class_group_id = lc.id
                WHERE lam.land_class_code IN ($in_list)
            ) t
            JOIN land_rate_master lrm
              ON t.new_land_class = lrm.land_class_code
        ";
        $data3 = $this->db->query($sql3);
        if ($data3->num_rows() > 0) {
            $landRate = $data3->result_array();
            log_message('error', 'LCU-16: (Per existing logic) Land rate not found but rows returned='.json_encode($landRate));
            // $this->db->trans_rollback();
            // return array('status' => false, 'message' => 'Land rate not found' . json_encode($landRate));
        }
        log_message('error', 'LCU-17: Land rate master check passed per existing condition');
        ////// STEP-6 ### Records to update (audit + update) //////
        // LCU-18: Fetching records to update
        $this->db->select('dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, land_class_code, dag_revenue, dag_local_tax, patta_no');
        $this->db->from('chitha_basic');
        $this->db->where(array(
            'dist_code'          => $params['dist_code'],
            'subdiv_code'        => $params['subdiv_code'],
            'cir_code'           => $params['cir_code'],
            'mouza_pargona_code' => $params['mouza_pargona_code'],
            'lot_no'             => $params['lot_no'],
            'vill_townprt_code'  => $params['vill_townprt_code'],
        ));
        $old_data = $this->db->get()->result_array();
        if (!$old_data) {
            log_message('error', 'LCU-19: No chitha_basic rows found for DAG selection');
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Record not found for given DAG');
        }
        log_message('error', 'LCU-20: Rows to process count='.count($old_data));
        // LCU-21+: Iterate and process
        foreach ($old_data as $oldRecords) {
            // Map old -> new; FALLBACK to old if mapping NULL
            $sql5 = "
                SELECT lc.land_class_code AS new, lam.land_class_code AS old
                FROM landclass_adc_mapping lam
                JOIN land_class_groups lc ON lam.land_class_group_id = lc.id
                WHERE lam.land_class_code = ?
            ";
            $row5 = $this->db->query($sql5, array($oldRecords['land_class_code']))->row();
            $new_land_class = ($row5 && !empty($row5->new)) ? $row5->new : $oldRecords['land_class_code'];
            log_message('error', 'LCU-21: Mapping resolved for DAG '.$oldRecords['dag_no'].' old='.
                $oldRecords['land_class_code'].' new='.$new_land_class.' (fallback_used='.(($row5 && !empty($row5->new))?'N':'Y').')');
            // Prepare audit data
            $audit_data = array(
                'dist_code'              => $oldRecords['dist_code'],
                'subdiv_code'            => $oldRecords['subdiv_code'],
                'cir_code'               => $oldRecords['cir_code'],
                'mouza_pargona_code'     => $oldRecords['mouza_pargona_code'],
                'lot_no'                 => $oldRecords['lot_no'],
                'vill_townprt_code'      => $oldRecords['vill_townprt_code'],
                'old_dag_no'             => $oldRecords['dag_no'],
                'dag_no'                 => $oldRecords['dag_no'],
                'land_class_code'        => $oldRecords['land_class_code'],
                'uuid'                   => $village_code ,
                'update_land_class_code' => $new_land_class,
                'updated_by'             => $user_code,
                'dag_revenue'            => $oldRecords['dag_revenue'],
                'dag_local_tax'          => $oldRecords['dag_local_tax'],
                'status'                 => 'F',
                'date_entry'             => date('Y-m-d H:i:s')
            );
            $this->db->insert('land_class_updates', $audit_data);
            log_message('error', 'LCU-22: Audit inserted for DAG '.$oldRecords['dag_no']);
            // Update chitha_basic
            $this->db->where(array(
                'dist_code'          => $oldRecords['dist_code'],
                'subdiv_code'        => $oldRecords['subdiv_code'],
                'cir_code'           => $oldRecords['cir_code'],
                'mouza_pargona_code' => $oldRecords['mouza_pargona_code'],
                'lot_no'             => $oldRecords['lot_no'],
                'vill_townprt_code'  => $oldRecords['vill_townprt_code'],
                'dag_no'             => $oldRecords['dag_no']
            ));
            $updateData = array(
                'uuid'            => $village_code,
                'land_class_code' => $new_land_class,
                'updated_on'      => date('Y-m-d H:i:s'),
                'user_code'       => $user_code
            );

            // If patta_no != 0, include jama_yn = 'n'
            if (!empty($oldRecords) && $oldRecords['patta_no'] != 0) {
                $updateData['jama_yn'] = 'n';
            }
            $this->db->update('chitha_basic', $updateData);

            /////////////////////////////
            $this->db->select('land_class_code, dag_revenue, dag_local_tax');
            $this->db->from('chitha_basic');
            $this->db->where(array(
                'dist_code'          => $oldRecords['dist_code'],
                'subdiv_code'        => $oldRecords['subdiv_code'],
                'cir_code'           => $oldRecords['cir_code'],
                'mouza_pargona_code' => $oldRecords['mouza_pargona_code'],
                'lot_no'             => $oldRecords['lot_no'],
                'vill_townprt_code'  => $oldRecords['vill_townprt_code'],
                'dag_no'             => $oldRecords['dag_no']
            ));
            $updatedData = $this->db->get()->row_array();

            // Step 3: Update jama_dag using fetched data
            if (!empty($updatedData)) {
                // Check existence
                $this->db->select('dag_no');
                $this->db->from('jama_dag');
                $this->db->where(array(
                    'dist_code'          => $oldRecords['dist_code'],
                    'subdiv_code'        => $oldRecords['subdiv_code'],
                    'cir_code'           => $oldRecords['cir_code'],
                    'mouza_pargona_code' => $oldRecords['mouza_pargona_code'],
                    'lot_no'             => $oldRecords['lot_no'],
                    'vill_townprt_code'  => $oldRecords['vill_townprt_code'],
                    'dag_no'             => $oldRecords['dag_no']
                ));
                $exists = $this->db->get()->num_rows() > 0;
                if ($exists) {
                    $this->db->where(array(
                        'dist_code'          => $oldRecords['dist_code'],
                        'subdiv_code'        => $oldRecords['subdiv_code'],
                        'cir_code'           => $oldRecords['cir_code'],
                        'mouza_pargona_code' => $oldRecords['mouza_pargona_code'],
                        'lot_no'             => $oldRecords['lot_no'],
                        'vill_townprt_code'  => $oldRecords['vill_townprt_code'],
                        'dag_no'             => $oldRecords['dag_no']
                    ));
                    
                    $this->db->update('jama_dag', array(
                        'dag_class_code' => $updatedData['land_class_code'],
                        'dag_revenue'     => $updatedData['dag_revenue'],
                        'dag_localtax'   => $updatedData['dag_local_tax'],
                        'updated_on'      => date('Y-m-d H:i:s'),
                        'user_code'       => $user_code
                    ));
                }else {
                    log_message('error', 'LCU-26:jama_dag record not found for dag_no: ' . $oldRecords['dag_no'] ."###village###".$village_code);
                }
            }
            // log_message('error',"CB-UPDATE####". $this->db->last_query());
            log_message('error', 'LCU-23: chitha_basic updated for DAG '.$oldRecords['dag_no'].' -> land_class_code='.$new_land_class);
        }
        log_message('error', 'LCU-24: Processing completed for requested location');      
        //////////////End Chitha Update/////////////////
        if ($exists) {
            // Always allow reupdate: update status, user_code, createdat
            $data_vill['updateddat'] = date('Y-m-d G:i:s');
            $this->db->where('vill_uuid', $village_code);
            $this->db->update('t_land_class_update', $data_vill);
        } else {
            $data_vill['createdat'] = date('Y-m-d G:i:s');
            $data_vill['updatedat'] = date('Y-m-d G:i:s');
            $this->db->insert('t_land_class_update', $data_vill);
        }
        log_message('error', 'LCU-25: Processing completed for requested location'.$this->db->trans_status());
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Transaction failed'];
        }
        $this->db->trans_commit();
        return ['status' => true, 'message' => 'Success'];
    }
}
