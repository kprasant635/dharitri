<?php
class SettlementBasicModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function insert($data){
        return $this->db->insert('settlement_basic', $data);
    }

    public function update($ref_id, $data){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS12079', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        return $this->db->update('settlement_basic', $data);
    }

    public function delete($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS212079', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        return $this->db->delete('settlement_basic');
    }

    public function get($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS6212079', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->from('settlement_basic');
        return $this->db->get();
    }




}