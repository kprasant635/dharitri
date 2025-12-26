<?php
class SettlementNomineeModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function insert($data){
        return $this->db->insert('settlement_nominee', $data);
    }

    public function update($ref_id, $id, $data){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0312079', 'Case ID not found!');
        }

        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('id', $id);
        return $this->db->update('settlement_nominee', $data);
    }

    public function delete($ref_id, $id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0512079', 'Case ID not found!');
        }

        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('id', $id);
        return $this->db->delete('settlement_nominee');
    }

    public function get($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0712079', 'Case ID not found!');
        }

        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->from('settlement_nominee');
        return $this->db->get();
    }




}