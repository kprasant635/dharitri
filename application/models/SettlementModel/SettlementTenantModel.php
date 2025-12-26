<?php
class SettlementTenantModel extends CI_Model {
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
            ->where_in('pdar_type', ['P','GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->row_array();
    }

    public function getSettlementDagResult($case)
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

    public function getIndividualCases($ex_id)
    {
        $sql = $this->db->query("SELECT * FROM settlement_beneficiary_excel A INNER JOIN settlement_basic B ON A.case_no = B.case_no WHERE A.exl_id = ?", array($ex_id));
        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }

    public function getRiotee($case){
        $owners = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $owners->result();
    }

    public function getBuyersTenant($case){
        $buyers = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'B')
            ->where('is_applicant', 1)
            ->get('settlement_applicant');
        return $buyers->result();
    }

}