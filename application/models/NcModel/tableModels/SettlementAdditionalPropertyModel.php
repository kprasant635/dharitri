<?php
class SettlementAdditionalPropertyModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function insert($data){
        return $this->db->insert('settlement_additional_property', $data);
    }

    public function update($ref_id, $id, $data){
        //***findout if the case_id is application_no or case_no */
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0912079', 'Case ID not found!');
        }

        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('id', $id);
        return $this->db->update('settlement_additional_property', $data);
    }

    public function delete($ref_id, $id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0812079', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('id', $id);
        return $this->db->delete('settlement_additional_property');
    }

    public function get($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0112079', 'Case ID not found!');
        }

        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->from('settlement_additional_property');
        return $this->db->get();
    }




}