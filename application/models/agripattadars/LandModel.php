<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LandModel extends CI_Model {

    public function get_all_village_uuids($db, $loc_arr=[])
    {
        $append = "(select * 
                   from location ".$this->getLocWhere($db, $loc_arr).")";

        $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code,lot_no,vill_townprt_code,uuid,
                   (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code 
                    and l.cir_code=loc.cir_code and l.mouza_pargona_code='00') circle,
                 (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code and l.cir_code=loc.cir_code 
                    and l.mouza_pargona_code=loc.mouza_pargona_code and l.lot_no='00') mouza,
                 (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code and l.cir_code=loc.cir_code 
                    and l.mouza_pargona_code=loc.mouza_pargona_code and l.lot_no=loc.lot_no and l.vill_townprt_code='00000') lot,
                   loc_name AS village_name_asm,
                   locname_eng AS village_name_eng,
                   uuid AS village_uuid
                FROM $append loc
                WHERE 
                  loc.vill_townprt_code <> '00000'
                  AND (loc.nc_btad IS NULL OR loc.nc_btad = 'k')
                  ";

        $result = $db->query($sql);
        if ($result->num_rows()<=0) return null;
        return $result->result_array();
    }

    public function get_village_name($db, $village_uuid) {
        $sql =  "select dist_code, subdiv_code, cir_code, mouza_pargona_code,lot_no,vill_townprt_code,uuid,
                   (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code='00') district, 
                   (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code 
                    and l.cir_code=loc.cir_code and l.mouza_pargona_code='00') circle,
                 (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code and l.cir_code=loc.cir_code 
                    and l.mouza_pargona_code=loc.mouza_pargona_code and l.lot_no='00') mouza,
                 (select loc_name from location l where l.dist_code=loc.dist_code and l.subdiv_code=loc.subdiv_code and l.cir_code=loc.cir_code 
                    and l.mouza_pargona_code=loc.mouza_pargona_code and l.lot_no=loc.lot_no and l.vill_townprt_code='00000') lot,
                   loc_name AS village_name_asm,
                   locname_eng AS village_name_eng,
                   uuid AS village_uuid
                FROM location loc where uuid=?";
        return $db->query($sql,array($village_uuid))->row_array();
    }

    public function get_patta_records_by_village($db, $agridb, $village_uuid)
    {
        // $loc = $db->get_where('location', ['uuid' => $village_uuid])->row_array();
        // if (!$loc) return [];

        // Step 1: Get valid dags from chitha_basic
        $chitha_dags = $db
            ->select('dag_no, patta_type_code, patta_no')
            ->from('agri_stack_view')
            ->where([
                'uuid' => $village_uuid,
            ])
            ->get()->result_array();

        $valid_dags = [];
        foreach ($chitha_dags as $row) {
            $key = "{$row['patta_type_code']}_{$row['patta_no']}_{$row['dag_no']}";
            $valid_dags[$key] = true;
        }

        // Step 2: Get excluded patta_type_codes
        $excluded_types = $this->get_excluded_patta_types($db);

        // Step 3: Get mapping of dag_no → farm_plot_id
        $dag_farm_data = $agridb
            ->select('plot_no as dag_no, farm_id as farm_plot_id')
            ->from('farmid')
            ->where([
                'uuid' => $village_uuid,
                'status' => 1
            ])
            ->get()->result_array();
        $dagMap = [];
        foreach ($dag_farm_data as $d) {
            $dagMap[$d['dag_no']] = $d['farm_plot_id'];
        }
        // Step 4: Fetch active pattadars
        $db->select('
            (SELECT patta_type FROM patta_code WHERE type_code=dp.patta_type_code) as patta_type,
            dp.patta_type_code, dp.patta_no, dp.dag_no, dp.pdar_id,
            dp.pdar_name, dp.pdar_father
        ');
        $db->from('agri_stack_view dp');
        
        $db->where([
            'dp.uuid' => $village_uuid,
        ]);
        $pattadars = $db->get()->result_array();
        // Step 5: Final data with farm_plot_id
        $final = [];
        foreach ($pattadars as $row) {
            $key = "{$row['patta_type_code']}_{$row['patta_no']}_{$row['dag_no']}";
            if (isset($valid_dags[$key])) {
                $row['farm_plot_id'] = $dagMap[$row['dag_no']] ?? null;
                $final[] = $row;
            }
        }

        return $final;
    }

    public function get_excluded_patta_types($db)
    {
        $db->select('type_code');
        $db->from('patta_code');
        $db->where('jamabandi !=', 'y');
        $rows = $db->get()->result_array();
        return array_column($rows, 'type_code');
    }
   
    private function getLocWhere($db,$loc_arr)
    {
        $where = [];
        if (empty($loc_arr)) return '';

        foreach ($loc_arr as $key => $value) {
            if (!empty($value)) {
                // Properly escape the value to prevent SQL injection
                $where[] = "$key = " . $db->escape($value);
            }
        }
        $where_clause = '';
        if (!empty($where)) {
            $where_clause = ' WHERE ' . implode(' AND ', $where);
        }
        return $where_clause;
    }
}
