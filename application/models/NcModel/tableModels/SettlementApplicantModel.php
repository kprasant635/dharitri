<?php
class SettlementApplicantModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function insert($data){
        return $this->db->insert('settlement_applicant', $data);
    }

    public function updateIsApplicant($ref_id, $data){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0323416', 'Case ID not found!');
        }
        $this->db->where('is_applicant', 1);
        $this->db->where('case_no', $ref_id['case_no']);
        return $this->db->update('settlement_applicant', $data);
    }

    public function updateApplicantById($ref_id, $id, $data){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0223416', 'Case ID not found!');
        }
        $this->db->where('id', $id);
        $this->db->where('case_no', $ref_id['case_no']);
        return $this->db->update('settlement_applicant', $data);
    }

    public function deleteIsApplicant($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS8023416', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('is_applicant', 1);
        return $this->db->delete('settlement_applicant');
    }

    public function getIsApplicant($ref_id)
    {
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS02834160', 'Case ID not found!');
        }
        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('is_applicant', 1);
        $this->db->where('pdar_type', 'B');
        $this->db->from('settlement_applicant');
        return $this->db->get();
    }

    public function get($ref_id)
    {
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0023416', 'Case ID not found!');
        }

        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->from('settlement_applicant');
        return $this->db->get();
    }

    public function getJointApplicants($ref_id)
    {
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS0283416', 'Case ID not found!');
        }
        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('pdar_type', 'B');
        $this->db->where('is_applicant != 1');
        $this->db->from('settlement_applicant');
        return $this->db->get();
    }

    public function getEncroachers($ref_id)
    {
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS02834161', 'Case ID not found!');
        }
        $this->db->select();
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->where('pdar_type', 'EN');
        $this->db->where('is_applicant != 1');
        $this->db->from('settlement_applicant');
        return $this->db->get();
    }



    public function getEncroachersWithDagDetails($ref_id)
    {
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS02834161', 'Case ID not found!');
        }

        $this->db->select('d.*, a.dag_no as app_dag_no, a.pdar_name,a.pdar_guardian,a.id as app_dag_id,a.is_applicant,a.pdar_type');
        $this->db->from('settlement_applicant a');
        $this->db->join('settlement_dag_details d', 'a.dag_no = d.dag_no');
        $this->db->where('a.case_no', $ref_id['case_no']);
        $this->db->where('d.case_no', $ref_id['case_no']);
        $this->db->where('a.pdar_type', 'EN');
        $this->db->where('a.is_applicant != 1');

        return $this->db->get();
    }



    // applicant details with applicant id
    public function applicantDetailsWithAppId($dist_code,$dagId)
    {
        $this->db->select('*');
        $this->db->from('settlement_applicant');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('id', $dagId);
        $data = $this->db->get();
        return $data;

    }




}