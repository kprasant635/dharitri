<?php 
    class LandClassModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('LocationModel');
    }

    public function list($connection = NULL){
        if($connection){
            return $connection->order_by('class_code', 'asc')->get('landclass_code')->result();
        }

        return $this->db->order_by('class_code', 'asc')->get('landclass_code')->result();
    }
    
    public function notMappedList(){
        return $this->db->where('land_class_group_id IS NULL', null, false)->order_by('class_code', 'asc')->get('landclass_code')->result();
    }

    public function get_by_class_code($class_code){
        return $this->db->where('class_code', $class_code)->get('landclass_code')->row();
    }
    
    public function is_landclass_deletable($class_code){
        $connection = $this->db;
        $chitha_records = $connection->where('land_class_code', $class_code)->get('chitha_basic')->result_array();
        if(count($chitha_records) > 0){
            $data = $this->prepare_error_data($chitha_records);
            $message = "#ERRCHBLNDCLS0001: You cannot delete this land class as it has been used in some services";
            throw new Exception(json_encode(['success' => false, 'message' => $message, 'data' => $data]));
        }
        
        $jama_records = $connection->where('dag_class_code', $class_code)->get('jama_dag')->result_array();
        if(count($jama_records) > 0){
            $data = $this->prepare_error_data($jama_records);
            $message = "#ERRJMDGLNDCLS0001: You cannot delete this lpand class as it has been used in some services";
            throw new Exception(json_encode(['success' => false, 'message' => $message, 'data' => $data]));
        }

        $mapping_cases = $connection->where('land_class_code', $class_code)->where('is_freezed', 1)->get('landclass_mapping_cases')->result_array();
        if(count($mapping_cases) > 0 && !isset($_POST['is_confirmed'])){
            $circles_arr = [];
            foreach($mapping_cases as $mapping_case){
                $circle = $this->LocationModel->get_circle($mapping_case['dist_code'], $mapping_case['subdiv_code'], $mapping_case['cir_code']);
                array_push($circles_arr, '"' . $circle->loc_name . '"');
            }
            $message = "#ERRMPPLNDCLS0001: Need another confirmation";
            $confirmation_message = "This class has already been mapped and freezed in ". implode(', ', $circles_arr) .". Do you still want to delete!";
            throw new Exception(json_encode(['success' => false, 'message' => $message, 'data' => [], 'need_another_confirmation' => true, 'confirmation_message' => $confirmation_message]));
        }
        
    }
    
    public function delete_landclass($class_code){
        $connection = $this->db;
        
        $landclass = $this->get_by_class_code($class_code);
        $status = $connection->where('class_code', $class_code)->delete('landclass_code');
        $map_case_status = $connection->where('land_class_code', $class_code)->delete('landclass_mapping_cases');
        $adc_map_case_status = $connection->where('land_class_code', $class_code)->delete('landclass_adc_mapping');
        
        if($status && $map_case_status && $adc_map_case_status){
            $data = [
                'case_no' => 'DELETED_LANDCLASS',
                'date' => date('Y-m-d H:i:s'),
                'table_name' => 'landclass_code',
                'data' => json_encode($landclass)
            ];

            $archieve_status = $connection->insert('archive_data', $data);

            if($archieve_status){
                return true;
            }
        }

        return false;
        
    }

    private function prepare_error_data(array $records){
        // Location and dag
        $raw_datas = $datas = [];
        if(count($records) > 0){
            foreach($records as $record){
                $location = $record['dist_code'] . '_' . $record['subdiv_code'] . '_' . $record['cir_code'] . '_' . $record['mouza_pargona_code'] . '_' . $record['lot_no'] . '_' . $record['vill_townprt_code'];
                
                if(!isset($raw_datas[$location])){
                    $village_row = $this->LocationModel->get_village($record['dist_code'], $record['subdiv_code'], $record['cir_code'], $record['mouza_pargona_code'], $record['lot_no'], $record['vill_townprt_code']);
                    $village = $village_row->loc_name;
                    $raw_datas[$location] = [
                        'village' => $village_row->loc_name,
                        'village_eng' => $village_row->locname_eng,
                        'dag_nos' => []
                    ];
                }
                $dag_nos = $raw_datas[$location]['dag_nos'];
                array_push($dag_nos, $record['dag_no']);
                $raw_datas[$location]['dag_nos'] = $dag_nos;
            }

            foreach($raw_datas as $raw_data){
                $village_row = $this->LocationModel->get_village($record['dist_code'], $record['subdiv_code'], $record['cir_code'], $record['mouza_pargona_code'], $record['lot_no'], $record['vill_townprt_code']);
                $village = $village_row->loc_name;
                $data = [
                    'village' => $raw_data['village'],
                    'village_eng' => $raw_data['village_eng'],
                    'dag_no' => implode(', ', $raw_data['dag_nos'])
                ];
                array_push($datas, $data);
            }
        }

        return $datas;
    }
}