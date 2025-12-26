<?php

class PetitionProceedingModel extends CI_Model {

    protected $table = "petition_proceeding";
    
    public function get_rows_array($conditions, $connection = NULL){
        $db = $this->db;
        if(!empty($connection)){
            $db = $connection;
        }

        return $db->where($conditions)->get($this->table)->result_array();
    }

    public function getAutoIncrementalProceedingNo($case_no){
        $count = $this->db->where('case_no', $case_no)->get($this->table)->num_rows();

        return ($count + 1);
    }

    public function store_legacy_logs($data): array
    {
        $response = [
            'success' => true,
            'message' => 'Successfully logged this case'
        ];

        $this->db->insert('petition_proceeding', $data);

        if($this->db->affected_rows() == 0){
            log_message('error', '#ERRLDULOGCS001: Something went wrong for case no => ' . $data['case_no'] . ' Last Query => ' . $this->db->last_query());

            $response['success'] = false;
            $response['message'] = '#ERRLDULOGCS001: Something went wrong. Please try again later.';
        }

        return $response;
    }
    
}
