<?php
class SettlementTribalModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no){
        $get_riotees = $this->db->select()
            ->where('dist_code',$d)
            ->where('subdiv_code',$s)
            ->where('cir_code',$c)
            ->where('mouza_pargona_code',$m)
            ->where('lot_no',$l)
            ->where('vill_townprt_code',$v)
            ->where('dag_no',$dag)
            ->where('khatian_no',$khatian_no)

            ->get('chitha_tenant');

        return $get_riotees->result();
    }

    // get all settlement basic
    public function getSettlementBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_basic');
        return $basic->row_array();
    }

    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }
    // get all applicant encroacher
    public function getAllApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // get all applicant riotee nok
    public function getAllApplicantRioteeNok($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where_in('pdar_type', ['GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get all settlement tenant lm note
    public function getSettlementTenantLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_ap_lmnote');

        return $lmnotes->result();
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
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_additional_property');

        return $property->result();
    }
    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }

}