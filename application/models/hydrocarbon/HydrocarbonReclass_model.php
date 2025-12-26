<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HydrocarbonReclass_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Count pending
    public function count_pending_cases()
    {
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'F'); // Pending
        return $this->db->count_all_results();
    }

    
    public function count_pending_cases_co($dist_code,$subdiv_code,$cir_code)
    {
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'F'); // Pending
        $this->db->where('b.dist_code', $dist_code);
        $this->db->where('b.subdiv_code', $subdiv_code);
        $this->db->where('b.cir_code', $cir_code);
        return $this->db->count_all_results();
    }

    // Fetch pending with applicant name
    public function get_pending_cases($limit, $offset,$dist_code,$subdiv_code,$cir_code)
    {
       
        $this->db->select('b.case_no, b.date_entry, b.status, MIN(a.pdar_name) as applicant_name', false);
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'F');
        $this->db->where('b.dist_code', $dist_code);
        $this->db->where('b.subdiv_code', $subdiv_code);
        $this->db->where('b.cir_code', $cir_code);
        $this->db->group_by(array('b.case_no', 'b.date_entry', 'b.status'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query->result_array();
    }


    // Single case
    public function get_case_by_no($case_no)
    {
        $this->db->select('b.*, a.pdar_name as applicant_name, a.pdar_guardian, a.pdar_gender, a.pdar_mobile');
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.case_no', $case_no);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getHydroReclassBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('hydro_reclass_suite_basic');
        return $basic->row_array();
    }

     // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->order_by('is_applicant', 'desc')
            ->get('hydro_reclass_applicant');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('hydro_reclass_applicant');
        return $applicants->result();
    }

     public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('hydro_reclass_dag_details');

        return $dags->result();
    }

    public function getApplidFromCaseNoReclass($case_no) {
        $applid = $this->db->query("select applid from hydro_reclass_suite_basic where case_no ='$case_no'");
        return $applid->row()->applid;
    }

    // get all settlement proceeding
    public function getSettlementProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getDocuments($case)
    {
        $applicaiton_no = $this->getApplidFromCaseNoReclass($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }

     // Fetch pending with applicant name
    public function get_pending_cases_dc($limit, $offset,$dist_code)
    {
       
        $this->db->select('b.case_no, b.date_entry, b.status, MIN(a.pdar_name) as applicant_name', false);
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'F');
        $this->db->where('b.dist_code', $dist_code);
        $this->db->group_by(array('b.case_no', 'b.date_entry', 'b.status'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function count_pending_cases_co_partition($dist_code,$subdiv_code,$cir_code)
    {
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'P'); // Pending
        $this->db->where('b.dist_code', $dist_code);
        $this->db->where('b.subdiv_code', $subdiv_code);
        $this->db->where('b.cir_code', $cir_code);
        return $this->db->count_all_results();
    }

     // Fetch pending with applicant name
    public function get_pending_cases_part($limit, $offset,$dist_code,$subdiv_code,$cir_code)
    {
       
        $this->db->select('b.case_no, b.date_entry, b.status, MIN(a.pdar_name) as applicant_name', false);
        $this->db->from('hydro_reclass_suite_basic b');
        $this->db->join('hydro_reclass_applicant a', 'a.case_no = b.case_no', 'left');
        $this->db->where('b.status', 'P');
        $this->db->where('b.dist_code', $dist_code);
        $this->db->where('b.subdiv_code', $subdiv_code);
        $this->db->where('b.cir_code', $cir_code);
        $this->db->group_by(array('b.case_no', 'b.date_entry', 'b.status'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query->result_array();
    }

}
