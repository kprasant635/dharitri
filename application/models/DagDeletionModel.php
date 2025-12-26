<?php
class DagDeletionModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->dbswitch();
    }

    public function dbswitch(){
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        }
    }



    public function getPendingCountOfVillageLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        $sql = "Select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from  dag_deleted_record_details  
					where dist_code=? and subdiv_code=? and  cir_code=? and  mouza_pargona_code = ? and lot_no = ? and status=? group by dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $district = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));
        return $district->result();
    }

    public function getApprovedCountOfVillageLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        $sql = "Select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from  dag_deleted_record_details  
					where dist_code=? and subdiv_code=? and  cir_code=? and  mouza_pargona_code = ? and lot_no = ? and status=? group by dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $district = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));
        return $district->result();
    }

    public function getRejectedCountOfVillageLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        $sql = "Select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from  dag_deleted_record_details  
					where dist_code=? and subdiv_code=? and  cir_code=? and  mouza_pargona_code = ? and lot_no = ? and status=? group by dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $district = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));
        return $district->result();
    }


    public function getDagPendingDeletionRequest($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$start,$length,$order,$searchByCol_0,$searchByCol_1,$status)
    {
        $this->dbswitch();

        if(isset($searchByCol_0) && $searchByCol_0 != null)
        {
            $cons = " and (dag_no like '%$searchByCol_0%') ";
        }
        else
        {
            $cons = '';
        }

        if(isset($searchByCol_1) && $searchByCol_1 != null)
        {
            $cons1 = " and (case_no like '%$searchByCol_1%') ";
        }
        else
        {
            $cons1 = '';
        }


        $q = "select dag_deleted_record_details.* from  dag_deleted_record_details where Dist_code=? and Subdiv_code=? and  cir_code=? 
			and Mouza_Pargona_code=? and Lot_No=? and status = ? $cons $cons1 limit $length offset $start ";

        $district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));

        return $district->result();
    }

    public function getDagPendingDeletionRequestCount($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$order,$searchByCol_0,$searchByCol_1,$status)
    {

        if(isset($searchByCol_0) && $searchByCol_0 != null)
        {
            $cons = " and (dag_no like '%$searchByCol_0%') ";
        }
        else
        {
            $cons = '';
        }

        if(isset($searchByCol_1) && $searchByCol_1 != null)
        {
            $cons1 = " and (case_no like '%$searchByCol_1%') ";
        }
        else
        {
            $cons1 = '';
        }


        $q = "select dag_deleted_record_details.* from  dag_deleted_record_details where Dist_code=? and Subdiv_code=? and  cir_code=? 
			and Mouza_Pargona_code=? and Lot_No=? and status = ? $cons $cons1";

        $district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));

        return $district->result();
    }

    public function getDagApproveDeletionRequest($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$start,$length,$order,$searchByCol_0,$searchByCol_1,$status)
    {
        $this->dbswitch();

        if(isset($searchByCol_0) && $searchByCol_0 != null){
            $cons = " and (dag_no like '%$searchByCol_0%') ";
        }else{
            $cons = '';
        }

        if(isset($searchByCol_1) && $searchByCol_1 != null){
            $cons1 = " and (case_no like '%$searchByCol_1%') ";
        }else{
            $cons1 = '';
        }

        $q = "select dag_deleted_record_details.* from  dag_deleted_record_details where Dist_code=? and Subdiv_code=? and  cir_code=? 
			and Mouza_Pargona_code=? and Lot_No=? and status = ? $cons $cons1 limit $length offset $start ";

        $district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));

        return $district->result();
    }

    public function getDagApproveDeletionRequestCount($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$order,$searchByCol_0,$searchByCol_1,$status)
    {

        if(isset($searchByCol_0) && $searchByCol_0 != null){
            $cons = " and (dag_no like '%$searchByCol_0%') ";
        }else{
            $cons = '';
        }

        if(isset($searchByCol_1) && $searchByCol_1 != null){
            $cons1 = " and (case_no like '%$searchByCol_1%') ";
        }else{
            $cons1 = '';
        }

        $q = "select dag_deleted_record_details.* from  dag_deleted_record_details where Dist_code=? and Subdiv_code=? and  cir_code=? 
			and Mouza_Pargona_code=? and Lot_No=? and status = ? ";

        $district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status));

        return $district->result();
    }



    //////////// Masud Reza //////

    // forwarding officer
    public function headquarterCheckDagDel($dist_code, $subdiv_code)
    {
        $sqlDistHeadQtr = $this->db->query("SELECT district_headquater FROM location WHERE dist_code = ?  AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND vill_townprt_code = '00000' AND lot_no = '00'", array($dist_code, $subdiv_code));

        if($sqlDistHeadQtr->num_rows() > 0){
            return $sqlDistHeadQtr->row()->district_headquater;
        }
        else
        {
            return false;
        }

    }

    // pending count for co
    public function getPendingCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('mouza_pargona_code',$mouza_pargona_code)
            ->where('lot_no',$lot_no)
            ->where('status',$status)
            ->where('lm_code',$this->session->userdata('user_code'))
            ->get('dag_deleted_record_details')
            ->num_rows();

    }

    // Approve count for co
    public function getApprovedCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('mouza_pargona_code',$mouza_pargona_code)
            ->where('lot_no',$lot_no)
            ->where('status',$status)
            ->where('lm_code',$this->session->userdata('user_code'))
            ->get('dag_deleted_record_details')
            ->num_rows();

    }

    // Rejected count for co
    public function getRejectedCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$status)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('mouza_pargona_code',$mouza_pargona_code)
            ->where('lot_no',$lot_no)
            ->where('status',$status)
            ->where('lm_code',$this->session->userdata('user_code'))
            ->get('dag_deleted_record_details')
            ->num_rows();

    }


    // pending count for co
    public function getPendingCountOfVillageCO($dist_code,$subdiv_code,$cir_code,$status,$pen)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('status',$status)
            ->where('pending_office',$pen)
            ->get('dag_deleted_record_details')
            ->num_rows();

    }

    // pending count for SDO
    public function getPendingCountOfVillageSDO($dist_code,$subdiv_code,$status,$pen)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('status',$status)
            ->where('pending_office',$pen)
            ->get('dag_deleted_record_details')
            ->num_rows();
    }

    // pending count for ADC/DC
    public function getPendingCountOfVillageAdcDc($dist_code,$status,$pen)
    {
        return  $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('status',$status)
            ->where('pending_office',$pen)
            ->get('dag_deleted_record_details')
            ->num_rows();
    }


    // get dag details
    public function getAreaDetail($dist,$sub,$circle,$mza,$lot,$village_code,$dag_no)
    {

        $data = $this->db->select('dag_no,patta_no,patta_type_code,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,land_class_code')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where('vill_townprt_code',$village_code)
            ->where('dag_no_int',$dag_no)
            ->get('chitha_basic');

        return $data->row();

    }

    // dag deletion app details
    public function countDagDeletionWithCaseNo($dist_code,$case_no)
    {
        return $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('case_no', $case_no)
            ->get('dag_deleted_record_details');
    }

    // get land type
    public function getLandTypeName($landCode)
    {
        return $this->db->select('land_type')
            ->where('class_code', $landCode)
            ->get('landclass_code')
            ->row();

    }

    // get Patta type
    public function getPattaTypeName($typeCode)
    {
        return $this->db->select('patta_type')
            ->where('type_code', $typeCode)
            ->get('patta_code')
            ->row();

    }

    // get supportive document
    public function getAllSupportiveDocuments($typeCode)
    {
        $data =  $this->db->select('*')
            ->where('case_no', $typeCode)
            ->get('supportive_document');

        return $data->result();

    }

    // get all proceeding
    public function getAllProceedingDagDel($case_no)
    {
        $data = $this->db->select('*')
            ->where('case_no', $case_no)
            ->order_by('proceeding_id', 'asc')
            ->get('petition_proceeding');

        return $data->result();
    }


    // cases Dc/Adc
    public function getPendingDagDelCasesAdcDc($dist_code,$pen)
    {
        $data =  $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('pending_office', $pen)
            ->get('dag_deleted_record_details');

        return $data->result();
    }


    // cases Sdo
    public function getPendingDagDelCasesSdo($dist_code,$subdiv_code,$pen)
    {
        $data =  $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('pending_office', $pen)
            ->get('dag_deleted_record_details');

        return $data->result();
    }


    // cases Co
    public function getPendingDagDelCasesCo($dist_code,$subdiv_code,$cir_code,$pen)
    {
        $data =  $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('pending_office', $pen)
            ->get('dag_deleted_record_details');

        return $data->result();
    }



    public function checkingForDagDeleteAllow($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number)
    {
        $tables=[
            'settlement_dag_details','apcancel_dag_details','apcancel_petition_pattadar','apt_chitha_rmk_ordbasic','apt_chitha_rmk_other',
            'field_mut_dag_details','field_mut_pattadar','field_part_petitioner','t_chitha_col8_order','chitha_col8_order',
            't_chitha_col8_inplace','chitha_col8_inplace','t_chitha_col8_occup','chitha_col8_occup','chitha_col8_tenant',
            'chitha_dag_all_flag_details','chitha_dag_all_flag_details_final','chitha_fruit','chitha_mcrop','chitha_noncrop',
            't_chitha_rmk_allottee','chitha_rmk_allottee','t_chitha_rmk_alongwith','chitha_rmk_alongwith','t_chitha_rmk_convorder',
            'chitha_rmk_convorder','chitha_rmk_encro','t_chitha_rmk_infavor_of','chitha_rmk_infavor_of','t_chitha_rmk_inplace_of',
            'chitha_rmk_inplace_of','chitha_rmk_lmnote','t_chitha_rmk_onbehalf','chitha_rmk_onbehalf','petition_dag_details',
            'petition_lm_note','petition_pattadar','petitioner_part','t_chitha_rmk_ordbasic','chitha_rmk_ordbasic',
            't_chitha_rmk_other_opp_party','chitha_rmk_other_opp_party','t_reclassification','chitha_rmk_reclassification',
            'chitha_rmk_sknote','chitha_settlement_allottee','chitha_subtenant','chitha_tenant'
        ];
        $tables_alias=[
            'settlement_dag_details'            => 'Settlement Process',
            'apcancel_dag_details'              => 'NR Process',
            'apcancel_petition_pattadar'        => 'NR Process Applicant',
            'apt_chitha_rmk_ordbasic'           => 'NR Chitha Transaction-1',
            'apt_chitha_rmk_other'              => 'NR Chitha Process',
            'field_mut_dag_details'             => 'Field Mutation Dag',
            'field_mut_pattadar'                => 'Field Mutation Pattadar',
            'field_part_petitioner'             => 'Field Partition',
            't_chitha_col8_order'               => 'Field Case Transaction-c8',
            'chitha_col8_order'                 => 'Field Case Chitha',
            't_chitha_col8_inplace'             => 'Field Case Transaction-ii',
            'chitha_col8_inplace'               => 'Field Case Chitha-Inplace',
            't_chitha_col8_occup'               => 'Field Case Transaction-oc',
            'chitha_col8_occup'                 => 'Field Case Chitha-Occupant',
            'chitha_col8_tenant'                => 'Field Case Chitha-Tenant',
            'chitha_dag_all_flag_details'       => 'Dag Flagged',
            'chitha_dag_all_flag_details_final' => 'Dag Flagged-Final',
            'chitha_fruit'                      => 'Fruit Details',
            'chitha_mcrop'                      => 'Crop Details',
            'chitha_noncrop'                    => 'Non Crop Details',
            't_chitha_rmk_allottee'             => 'Allottee',
            'chitha_rmk_allottee'               => 'Allottee-Main',
            't_chitha_rmk_alongwith'            => 'Office-Transaction-al',
            'chitha_rmk_alongwith'              => 'Office-Chitha-1',
            't_chitha_rmk_convorder'            => 'Office-Transaction-con',
            'chitha_rmk_convorder'              => 'Office-Chitha-2',
            'chitha_rmk_encro'                  => 'Encroacher',
            't_chitha_rmk_infavor_of'           => 'Office-Transaction-inf',
            'chitha_rmk_infavor_of'             => 'Office-Chitha-2',
            't_chitha_rmk_inplace_of'           => 'Office-Transaction-inp',
            'chitha_rmk_inplace_of'             => 'Office-Chitha-2',
            'chitha_rmk_lmnote'                 => 'LM-Note',
            't_chitha_rmk_onbehalf'             => 'Office-Transaction-onb',
            'chitha_rmk_onbehalf'               => 'Office-Chitha-2',
            'petition_dag_details'              => 'Office Dag',
            'petition_lm_note'                  => 'LM Note-Office',
            'petition_pattadar'                 => 'Petition Pattadar',
            'petitioner_part'                   => 'Office Partition',
            't_chitha_rmk_ordbasic'             => 'Office-Transaction-ord',
            'chitha_rmk_ordbasic'               => 'Office-Chitha-4',
            't_chitha_rmk_other_opp_party'      => 'Office-Transaction-opp',
            'chitha_rmk_other_opp_party'        => 'Office-Chitha-Other-Party-5',
            't_reclassification'                => 'Reclassification',
            'chitha_rmk_reclassification'       => 'Office-Reclassification-1',
            'chitha_rmk_sknote'                 => 'SK Note',
            'chitha_settlement_allottee'        => 'Settlement-Allottee',
            'chitha_subtenant'                  => 'Sub Tenant Details',
            'chitha_tenant'                     => 'Tenant Details',
        ];
        foreach($tables as $table)
        {
            $q2 = "select * from ".$table." where
            dist_code=? and subdiv_code=? and cir_code=? and
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
            $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,$circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
            if($q2_result->num_rows()>0){
                log_message('error',"DataFoundDagDeletion TableName ".$table." query001 ".$this->db->last_query());
                return array('response'=>2,'msg'=>$tables_alias[$table]);
            }
        }
        return array('response'=>1,'msg'=>'Allowed');
    }





    ////////  Bhrigu da //////////////

    // dag delete code by Bhrigu da (19/12/2023)
    public function isDeletionAllowed($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number,$case_no,$patta_type,$patta_number)
    {
        $response = array('responseType' => 1, 'msg' => 'Not Allowed', 'status'=>'n');
        $allowed  = $this->dagDeleteQuery($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number);
        if($allowed['response'] == 2  )
        {
            $response['responseType'] = 1;
            $response['msg'] = ' You cannot delete this dag as its reference is found in  '. $allowed['msg'] .". Please check chitha copy.";
            $response['status'] = 'n';
        }
        else
        {
            $success=$this->removeDagInformation($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number,$case_no,$patta_type,$patta_number);
            if($success==true)
            {
                $response['responseType'] = 2;
                $response['msg'] = 'allowed';
                $response['status'] = 'y';
            }
            else
            {
                $response['responseType'] = 1;
                $response['msg'] = 'There is some problem ! Kindly contact system administrator';
                $response['status'] = 'n';
            }
        }
        return $response;
    }

    // check for allowing dag deletion
    public function dagDeleteQuery($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number)
    {
        $tables=[
            'settlement_dag_details','apcancel_dag_details','apcancel_petition_pattadar','apt_chitha_rmk_ordbasic','apt_chitha_rmk_other',
            'field_mut_dag_details','field_mut_pattadar','field_part_petitioner','t_chitha_col8_order','chitha_col8_order',
            't_chitha_col8_inplace','chitha_col8_inplace','t_chitha_col8_occup','chitha_col8_occup','chitha_col8_tenant',
            'chitha_dag_all_flag_details','chitha_dag_all_flag_details_final','chitha_fruit','chitha_mcrop','chitha_noncrop',
            't_chitha_rmk_allottee','chitha_rmk_allottee','t_chitha_rmk_alongwith','chitha_rmk_alongwith','t_chitha_rmk_convorder',
            'chitha_rmk_convorder','chitha_rmk_encro','t_chitha_rmk_infavor_of','chitha_rmk_infavor_of','t_chitha_rmk_inplace_of',
            'chitha_rmk_inplace_of','chitha_rmk_lmnote','t_chitha_rmk_onbehalf','chitha_rmk_onbehalf','petition_dag_details',
            'petition_lm_note','petition_pattadar','petitioner_part','t_chitha_rmk_ordbasic','chitha_rmk_ordbasic',
            't_chitha_rmk_other_opp_party','chitha_rmk_other_opp_party','t_reclassification','chitha_rmk_reclassification',
            'chitha_rmk_sknote','chitha_settlement_allottee','chitha_subtenant','chitha_tenant'
        ];
        $tables_alias=[
            'settlement_dag_details'            => 'Settlement Process',
            'apcancel_dag_details'              => 'NR Process',
            'apcancel_petition_pattadar'        => 'NR Process Applicant',
            'apt_chitha_rmk_ordbasic'           => 'NR Chitha Transaction-1',
            'apt_chitha_rmk_other'              => 'NR Chitha Process',
            'field_mut_dag_details'             => 'Field Mutation Dag',
            'field_mut_pattadar'                => 'Field Mutation Pattadar',
            'field_part_petitioner'             => 'Field Partition',
            't_chitha_col8_order'               => 'Field Case Transaction-c8',
            'chitha_col8_order'                 => 'Field Case Chitha',
            't_chitha_col8_inplace'             => 'Field Case Transaction-ii',
            'chitha_col8_inplace'               => 'Field Case Chitha-Inplace',
            't_chitha_col8_occup'               => 'Field Case Transaction-oc',
            'chitha_col8_occup'                 => 'Field Case Chitha-Occupant',
            'chitha_col8_tenant'                => 'Field Case Chitha-Tenant',
            'chitha_dag_all_flag_details'       => 'Dag Flagged',
            'chitha_dag_all_flag_details_final' => 'Dag Flagged-Final',
            'chitha_fruit'                      => 'Fruit Details',
            'chitha_mcrop'                      => 'Crop Details',
            'chitha_noncrop'                    => 'Non Crop Details',
            't_chitha_rmk_allottee'             => 'Allottee',
            'chitha_rmk_allottee'               => 'Allottee-Main',
            't_chitha_rmk_alongwith'            => 'Office-Transaction-al',
            'chitha_rmk_alongwith'              => 'Office-Chitha-1',
            't_chitha_rmk_convorder'            => 'Office-Transaction-con',
            'chitha_rmk_convorder'              => 'Office-Chitha-2',
            'chitha_rmk_encro'                  => 'Encroacher',
            't_chitha_rmk_infavor_of'           => 'Office-Transaction-inf',
            'chitha_rmk_infavor_of'             => 'Office-Chitha-2',
            't_chitha_rmk_inplace_of'           => 'Office-Transaction-inp',
            'chitha_rmk_inplace_of'             => 'Office-Chitha-2',
            'chitha_rmk_lmnote'                 => 'LM-Note',
            't_chitha_rmk_onbehalf'             => 'Office-Transaction-onb',
            'chitha_rmk_onbehalf'               => 'Office-Chitha-2',
            'petition_dag_details'              => 'Office Dag',
            'petition_lm_note'                  => 'LM Note-Office',
            'petition_pattadar'                 => 'Petition Pattadar',
            'petitioner_part'                   => 'Office Partition',
            't_chitha_rmk_ordbasic'             => 'Office-Transaction-ord',
            'chitha_rmk_ordbasic'               => 'Office-Chitha-4',
            't_chitha_rmk_other_opp_party'      => 'Office-Transaction-opp',
            'chitha_rmk_other_opp_party'        => 'Office-Chitha-Other-Party-5',
            't_reclassification'                => 'Reclassification',
            'chitha_rmk_reclassification'       => 'Office-Reclassification-1',
            'chitha_rmk_sknote'                 => 'SK Note',
            'chitha_settlement_allottee'        => 'Settlement-Allottee',
            'chitha_subtenant'                  => 'Sub Tenant Details',
            'chitha_tenant'                     => 'Tenant Details',
        ];
        foreach($tables as $table)
        {
            $q2 = "select * from ".$table." where
            dist_code=? and subdiv_code=? and cir_code=? and
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
            $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,$circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
            if($q2_result->num_rows()>0){
                log_message('error',"DataFoundDagDeletion TableName ".$table." query001 ".$this->db->last_query());
                return array('response'=>2,'msg'=>$tables_alias[$table]);
            }
        }
        return array('response'=>1,'msg'=>'Allowed');
    }


    public function removeDagInformation($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number,$case_no,$patta_type,$patta_number)
    {
        return false;
        $q49 = "select * from jama_dag where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q49_result = $this->db->query($q49, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q49_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q49_result->result_array()),$case_no,'jama_dag');
            if($returndata!=1){
                log_message('error',"jama_dagInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('jama_dag',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q49_result->num_rows())
            {
                log_message("error", "#jama_dag Delete failed case no: " . $case_no."jama_dag001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }

            //////////check multiple dag////////
            $q34 = "select count(*) as c from jama_dag where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and dag_no !=? and patta_no=? and patta_type_code=?";
            $q34_result = $this->db->query($q34, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
            if ($q34_result->row()->c == 0) {
                ///////Delete jama_patta///////////
                $q35 = "select * from jama_patta where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q35_result = $this->db->query($q35, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code,
                    $patta_number,$patta_type));
                if ($q35_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q35_result->result_array()),$case_no,'jama_patta');
                    if($returndata!=1){
                        log_message('error',"jama_pattaInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_patta',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q35_result->num_rows()) {
                        log_message("error", "#jama_patta Delete failed case no: " . $case_no."jama_patta001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                ///////Delete jama_pattadar///////////
                $q36 = "select * from jama_pattadar where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q36_result = $this->db->query($q36, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
                if ($q36_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q36_result->result_array()),$case_no,'jama_pattadar');
                    if($returndata!=1){
                        log_message('error',"jama_pattadarInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_pattadar',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q36_result->num_rows()) {
                        log_message("error", "#jama_patta Delete failed case no: " . $case_no."jama_patta001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                ///////Delete jama_remark///////////
                $q37 = "select * from jama_remark where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q37_result = $this->db->query($q37, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
                if ($q37_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q37_result->result_array()),$case_no,'jama_remark');
                    if($returndata!=1){
                        log_message('error',"jama_remarkInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_remark',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q37_result->num_rows()) {
                        $this->db->trans_rollback();
                        log_message("error", "#jama_remark Delete failed case no: " . $case_no."jama_remark001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }
            }
        }
        /////////chitha_dag_pattadar//////////
        $q1 = "select * from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));

        log_message('error',"q1_result".$this->db->last_query());

        if ($q1_result->num_rows() > 0)
        {
            $returndata = $this->archieve_table_insert(json_encode($q1_result->result_array()),$case_no,'chitha_dag_pattadar');
            if($returndata!=1){
                log_message('error',"chitha_dag_pattadarInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_dag_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));

            if($this->db->affected_rows() != $q1_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_dag_pattadar Delete failed case no: " . $case_no."chitha_dag_pattadar001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }

        ///////chitha_pattadar/////////////
        $q55 = "select count(*) as c from chitha_basic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and dag_no !=? and patta_no=? and patta_type_code=?";
        $q55_result = $this->db->query($q55, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
        if ($q55_result->row()->c == 0) {
            $q2 = "select * from chitha_pattadar where 
                        dist_code=? and subdiv_code=? and cir_code=? 
                        and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
                . "and patta_no=? and patta_type_code=? ";
            $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
            if ($q2_result->num_rows() > 0) {
                $returndata=$this->archieve_table_insert(json_encode($q2_result->result_array()),$case_no,'chitha_pattadar');
                if($returndata!=1){
                    log_message('error',"chitha_pattadarInsert002".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                $this->db->delete('chitha_pattadar',
                    array('dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'patta_no' => $patta_number,
                        'patta_type_code' => $patta_type));
                if($this->db->affected_rows() != $q2_result->num_rows())
                {
                    $this->db->trans_rollback();
                    log_message("error", "#chitha_pattadar Delete failed case no: " . $case_no."chitha_pattadar001".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }
        /////////chitha_basic//////////
        $q21 = "select * from chitha_basic where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q21_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q21_result->result_array()),$case_no,'chitha_basic');
            if($returndata!=1){
                log_message('error',"chitha_basicInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_basic',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));

            if($this->db->affected_rows() != $q21_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_basic Delete failed case no: " . $case_no."chitha_basic001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        } else {
            $this->db->trans_rollback();
            log_message("error", "#chitha_basic Delete failed case no Data not found in Chitha ");
            $this->db->trans_rollback();
            return false;
        }

        if ($this->db->trans_status() === FALSE || $this->db->trans_status()==false) {
            $this->db->trans_rollback();
            return false;
        } else {
            return true;
        }
    }


    public function finalConfirmRemoval($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_number,$case_no,$patta_type,$patta_number)
    {
        /////////Status to be checked////////
        $sql1="Select * from dag_deleted_record_details where case_no=?";
        $case=$this->db->query($sql1,array($case_no));
        if($case->num_rows()==0){
            return false;
        }
        $case_no=$case->row()->case_no;
        ////////////apcancel_dag_details////////
        $q1 = "select * from apcancel_dag_details where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $apcancel_dag_details = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($apcancel_dag_details->num_rows() > 0) {
            ////////multiple rows check/////////////
            foreach($apcancel_dag_details->result() as $apcases){
                $petition_no=$apcases->petition_no;
                $q1_1="Select * from apcancel_petition_basic where dist_code=? and subdiv_code=? and cir_code=? and 
	            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=? and status='P' ";
                $apcancelResult = $this->db->query($q1_1, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $petition_no));
                if($apcancelResult->num_rows()>0){
                    log_message('error',"apcancel_petition_basicError".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                /////////Insert before arcive data////////////
                $returndata=$this->archieve_table_insert(json_encode($apcancelResult->result_array()),$case_no,'apcancel_petition_basic');
                if($returndata!=1){
                    log_message('error',"apcancel_petition_basic_insert002".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                /////////////////////
                $q1_2="delete from apcancel_petition_basic where dist_code=? and subdiv_code=? and cir_code=? and 
	            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=? and status='P' ";
                $apcancelResult = $this->db->query($q1_2, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $petition_no));
                if($this->db->affected_rows() != $apcancelResult->num_rows()){
                    log_message('error',"apcancel_petition_basicDeleteError".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }
            /////////Insert before arcive data////////////
            $returndata=$this->archieve_table_insert(json_encode($apcancel_dag_details->result_array()),$case_no,'apcancel_dag_details');
            if($returndata!=1){
                log_message('error',"apcancel_dag_detailsInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            /////////////////////
            $this->db->delete('apcancel_dag_details',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $apcancel_dag_details->num_rows())
            {
                log_message("error", "#apcancel_dag_details001 Delete failed case no: " . $case_no."apcancel_dag_details001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////apcancel_petition_pattadar////////
        $q2 = "select * from apcancel_petition_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q2_result->num_rows() > 0) {
            /////////Insert before arcive data////////////
            $returndata=$this->archieve_table_insert(json_encode($q2_result->result_array()),$case_no,'apcancel_petition_pattadar');
            if($returndata!=1){
                log_message('error',"apcancel_petition_pattadarInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('apcancel_petition_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q2_result->num_rows())
            {
                log_message("error", "#apcancel_petition_pattadar001 case no: " . $case_no ."apcancel_petition_pattadar001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////apt_chitha_rmk_ordbasic////////
        $q3 = "select * from apt_chitha_rmk_ordbasic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q3_result = $this->db->query($q3, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q3_result->num_rows() > 0) {
            /////////Insert before arcive data////////////
            $returndata=$this->archieve_table_insert(json_encode($q3_result->result_array()),$case_no,'apt_chitha_rmk_ordbasic');
            if($returndata!=1){
                log_message('error',"apt_chitha_rmk_ordbasicInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('apt_chitha_rmk_ordbasic',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q3_result->num_rows())
            {
                log_message("error", "#apt_chitha_rmk_ordbasic001 case no: " . $case_no."apt_chitha_rmk_ordbasic001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////apt_chitha_rmk_other////////
        $q4 = "select * from apt_chitha_rmk_other where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q4_result = $this->db->query($q4, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q4_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q4_result->result_array()),$case_no,'apt_chitha_rmk_other');
            if($returndata!=1){
                log_message('error',"apt_chitha_rmk_otherInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('apt_chitha_rmk_other',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q4_result->num_rows())
            {
                log_message("error", "#apt_chitha_rmk_other001 case no: " . $case_no."apt_chitha_rmk_other001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ///////////AP end/////////////////////////
        ///////////FIeld case start///////////////
        $q5="Select * from field_mut_dag_details where dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $field_mut_dag_details = $this->db->query($q5, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if($field_mut_dag_details->num_rows()>0){
            foreach($field_mut_dag_details->result() as $field)
            {
                $case_no=$field->case_no;
                $q5_1="Select * from field_mut_basic where case_no=? and order_passed is null";
                $fieldCasesFoun=$this->db->query($q5_1,$case_no);
                if($fieldCasesFoun->num_rows()>0){
                    log_message('error',"FiledCaseFoundError001".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                $returndata=$this->archieve_table_insert(json_encode($fieldCasesFoun->result_array()),$case_no,'field_mut_basic');
                if($returndata!=1){
                    log_message('error',"field_mut_basicInsert002".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                $q5_2="Delete from field_mut_basic where case_no=? and order_passed is null";
                $this->db->query($q5_2,$case_no);
                if($this->db->affected_rows()!=$fieldCasesFoun->num_rows()){
                    log_message('error',"field_mut_basicDeleteError001".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }
            $returndata=$this->archieve_table_insert(json_encode($field_mut_dag_details->result_array()),$case_no,'field_mut_dag_details');
            if($returndata!=1){
                log_message('error',"field_mut_dag_detailsInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('field_mut_dag_details',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $field_mut_dag_details->num_rows())
            {
                log_message("error", "#field_mut_dag_details Delete failed case no: " . $case_no."field_mut_dag_detailsError111".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////field_mut_pattadar////////
        $q6 = "select * from field_mut_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $fieldmutpattadar = $this->db->query($q6, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($fieldmutpattadar->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($fieldmutpattadar->result_array()),$case_no,'field_mut_pattadar');
            if($returndata!=1){
                log_message('error',"field_mut_dag_detailsInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('field_mut_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $fieldmutpattadar->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#field_mut_pattadar Delete failed field_mut_pattadar case no: " . $case_no."field_mut_pattadar111".$this->db->last_query());
                return false;
            }
        }
        ////////////field_part_petitioner////////
        $q7 = "select * from field_part_petitioner where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $fieldpartpattadar = $this->db->query($q7, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($fieldpartpattadar->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($fieldpartpattadar->result_array()),$case_no,'field_part_petitioner');
            if($returndata!=1){
                log_message('error',"field_part_petitionerInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('field_part_petitioner',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $fieldpartpattadar->row()->c)
            {
                $this->db->trans_rollback();
                log_message("error", "#field_part_petitioner Delete failed field_part_petitioner case no: " . $case_no."field_part_petitioner111".$this->db->last_query());
                return false;
            }
        }
        ////////////t_chitha_col8_order////////
        $q8 = "select * from t_chitha_col8_order where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q8_result = $this->db->query($q8, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q8_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q8_result->result_array()),$case_no,'t_chitha_col8_order');
            if($returndata!=1){
                log_message('error',"t_chitha_col8_orderInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_col8_order',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q8_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#t_chitha_col8_order Delete failed t_chitha_col8_order case no: " . $case_no."t_chitha_col8_order111".$this->db->last_query());
                return false;
            }
        }
        ////////////t_chitha_col8_inplace////////
        $q9 = "select * from t_chitha_col8_inplace where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q9_result = $this->db->query($q9, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q9_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q9_result->result_array()),$case_no,'t_chitha_col8_inplace');
            if($returndata!=1){
                log_message('error',"t_chitha_col8_inplaceInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_col8_inplace',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q9_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#t_chitha_col8_inplace Delete failed t_chitha_col8_inplace case no: " . $case_no."t_chitha_col8_inplace111".$this->db->last_query());
                return false;
            }
        }

        ////////////chitha_col8_occup////////
        $q10 = "select * from chitha_col8_occup where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q10_result = $this->db->query($q10, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q10_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q10_result->result_array()),$case_no,'chitha_col8_occup');
            if($returndata!=1){
                log_message('error',"chitha_col8_occupInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_col8_occup',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q10_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_col8_occup Delete failed chitha_col8_occup case no: " . $case_no."chitha_col8_occup111".$this->db->last_query());
                return false;
            }
        }
        ////////////t_chitha_col8_occup////////
        $q11 = "select * from t_chitha_col8_occup where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q11_result = $this->db->query($q11, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q11_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q11_result->result_array()),$case_no,'t_chitha_col8_occup');
            if($returndata!=1){
                log_message('error',"t_chitha_col8_occupInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_col8_occup',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q11_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#t_chitha_col8_occup Delete failed t_chitha_col8_occup case no: " . $case_no."t_chitha_col8_occup111".$this->db->last_query());
                return false;
            }
        }

        ////////////chitha_col8_order////////
        $q12 = "select * from chitha_col8_order where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q12_result = $this->db->query($q12, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q12_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q12_result->result_array()),$case_no,'chitha_col8_order');
            if($returndata!=1){
                log_message('error',"chitha_col8_orderInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_col8_order',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q12_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_col8_order Delete failed chitha_col8_order case no: " . $case_no."chitha_col8_order111".$this->db->last_query());
                return false;
            }
        }
        ////////////chitha_col8_inplace////////
        $q13 = "select * from chitha_col8_inplace where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q13_result = $this->db->query($q13, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q13_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q13_result->result_array()),$case_no,'chitha_col8_inplace');
            if($returndata!=1){
                log_message('error',"chitha_col8_inplaceInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_col8_inplace',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q13_result->num_rows())
            {
                log_message("error", "#chitha_col8_inplace001 Delete case no: " . $case_no ."chitha_col8_inplace001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_col8_tenant////////
        $q14 = "select * from chitha_col8_tenant where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q14_result = $this->db->query($q14, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q14_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q14_result->result_array()),$case_no,'chitha_col8_tenant');
            if($returndata!=1){
                log_message('error',"chitha_col8_tenantInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_col8_tenant',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));

            if($this->db->affected_rows() != $q14_result->num_rows())
            {
                log_message("error", "#chitha_col8_tenant001 Delete failed case no: " . $case_no."chitha_col8_tenant001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }

        ////////////chitha_dag_all_flag_details////////
        $q15 = "select * from chitha_dag_all_flag_details where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q15_result = $this->db->query($q15, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q15_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q15_result->result_array()),$case_no,'chitha_dag_all_flag_details');
            if($returndata!=1){
                log_message('error',"chitha_dag_all_flag_detailsInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_dag_all_flag_details',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q15_result->num_rows())
            {
                log_message("error", "#chitha_dag_all_flag_details Delete failed case no: " . $case_no."chitha_dag_all_flag_details001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_dag_all_flag_details_final////////
        $q17 = "select * from chitha_dag_all_flag_details_final where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q17_result = $this->db->query($q17, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q17_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q17_result->result_array()),$case_no,'chitha_dag_all_flag_details_final');
            if($returndata!=1){
                log_message('error',"chitha_dag_all_flag_details_finalInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_dag_all_flag_details_final',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q17_result->num_rows())
            {
                log_message("error", "#chitha_dag_all_flag_details_final Delete failed case no: " . $case_no."chitha_dag_all_flag_details_final001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_fruit////////
        $q18 = "select * from chitha_fruit where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q18_result = $this->db->query($q18, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q18_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q18_result->result_array()),$case_no,'chitha_fruit');
            if($returndata!=1){
                log_message('error',"chitha_fruitInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_fruit',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q18_result->num_rows())
            {
                log_message("error", "#chitha_fruit Delete failed case no: " . $case_no."chitha_fruit001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_mcrop////////
        $q19 = "select * from chitha_mcrop where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q19_result = $this->db->query($q19, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q19_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q19_result->result_array()),$case_no,'chitha_mcrop');
            if($returndata!=1){
                log_message('error',"chitha_mcropInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_mcrop',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q19_result->num_rows())
            {
                log_message("error", "#chitha_mcrop Delete failed case no: " . $case_no."chitha_mcrop001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_noncrop////////
        $q20 = "select * from chitha_noncrop where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q20_result = $this->db->query($q20, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q20_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q20_result->result_array()),$case_no,'chitha_noncrop');
            if($returndata!=1){
                log_message('error',"chitha_noncropInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_noncrop',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q20_result->num_rows())
            {
                log_message("error", "#chitha_noncrop Delete failed case no: " . $case_no."chitha_noncrop001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }

        ////////////chitha_rmk_sknote////////
        $q21 = "select * from chitha_rmk_sknote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q21_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q21_result->result_array()),$case_no,'chitha_rmk_sknote');
            if($returndata!=1){
                log_message('error',"chitha_rmk_sknoteInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_sknote',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q21_result->num_rows())
            {
                log_message("error", "#chitha_rmk_sknote Delete failed case no: " . $case_no."chitha_rmk_sknote001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////////////
        $q22 = "select * from chitha_rmk_lmnote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q22_result = $this->db->query($q22, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q22_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q22_result->result_array()),$case_no,'chitha_rmk_lmnote');
            if($returndata!=1){
                log_message('error',"chitha_rmk_lmnoteInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_lmnote',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q22_result->num_rows())
            {
                log_message("error", "#chitha_rmk_lmnote Delete failed case no: " . $case_no."chitha_rmk_lmnote001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_lmnote////////
        $q23 = "select * from chitha_rmk_lmnote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q23_result = $this->db->query($q23, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q23_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q23_result->result_array()),$case_no,'chitha_rmk_lmnote');
            if($returndata!=1){
                log_message('error',"chitha_rmk_lmnoteInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_lmnote',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q23_result->num_rows())
            {
                log_message("error", "#chitha_rmk_lmnote Delete failed case no: " . $case_no."chitha_rmk_lmnote001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_encro////////
        $q24 = "select * from chitha_rmk_encro where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q24_result = $this->db->query($q24, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q24_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q24_result->result_array()),$case_no,'chitha_rmk_encro');
            if($returndata!=1){
                log_message('error',"chitha_rmk_encroInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_encro',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q24_result->num_rows())
            {
                log_message("error", "#chitha_rmk_encro Delete failed case no: " . $case_no."chitha_rmk_encro001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_onbehalf////////
        $q25 = "select * from t_chitha_rmk_onbehalf where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q25_result = $this->db->query($q25, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q25_result->num_rows()>0) {
            $returndata=$this->archieve_table_insert(json_encode($q25_result->result_array()),$case_no,'t_chitha_rmk_onbehalf');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_onbehalfInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_onbehalf',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q25_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_onbehalf Delete failed case no: " . $case_no."t_chitha_rmk_onbehalf001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_onbehalf////////
        $q26 = "select * from chitha_rmk_onbehalf where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q26_result = $this->db->query($q26, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q26_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q26_result->result_array()),$case_no,'chitha_rmk_onbehalf');
            if($returndata!=1){
                log_message('error',"chitha_rmk_onbehalfInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_onbehalf',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q26_result->num_rows())
            {
                log_message("error", "#chitha_rmk_onbehalf Delete failed case no: " . $case_no."chitha_rmk_onbehalf001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////petition_dag_details////////
        $q27 = "select * from petition_dag_details where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q27_result = $this->db->query($q27, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q27_result->num_rows() > 0) {
            ///////////////Mutiplecheck/////////////
            foreach($q27_result->result() as $pdd){
                $petition_no=$pdd->petition_no;
                $q27_1="Select * from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and 
            	mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=? and (status='P' or status is null) ";
                $q27_1_result=$this->db->query($q27_1,array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code,$petition_no));
                if($q27_1_result->num_rows()>0){
                    log_message('error',"petition_basic_casefound001".$this->db->last_query());
                    return false;
                }
                $returndata=$this->archieve_table_insert(json_encode($q27_1_result->result_array()),$case_no,'petition_basic');
                if($returndata!=1){
                    log_message('error',"petition_basicInsert002".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                $q27_2="delete from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and 
            	mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=? and (status='P' or status is null)";
                $q27_2_result=$this->db->query($q27_2,array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code,$petition_no));
                if($this->db->affected_rows() != $q27_1_result->num_rows()){
                    log_message('error',"petition_basic_caseDeeletedError001".$this->db->last_query());
                    return false;
                }
            }
            $returndata=$this->archieve_table_insert(json_encode($q27_result->result_array()),$case_no,'petition_dag_details');
            if($returndata!=1){
                log_message('error',"petition_dag_detailsInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('petition_dag_details',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q27_result->num_rows())
            {
                log_message("error", "#petition_dag_details Delete failed case no: " . $case_no."petition_dag_details001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////petitioner_part////////
        $q28 = "select * from petitioner_part where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q28_result = $this->db->query($q28, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q28_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q28_result->result_array()),$case_no,'petitioner_part');
            if($returndata!=1){
                log_message('error',"petitioner_partInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('petitioner_part',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q28_result->num_rows())
            {
                log_message("error", "#petitioner_part Delete failed case no: " . $case_no."petitioner_part001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_ordbasic////////
        $q29 = "select * from t_chitha_rmk_ordbasic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q29_result = $this->db->query($q29, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q29_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q29_result->result_array()),$case_no,'t_chitha_rmk_ordbasic');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_ordbasicInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_ordbasic',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q29_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_ordbasic Delete failed case no: " . $case_no."t_chitha_rmk_ordbasic001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////petition_lm_note////////
        $q30 = "select * from petition_lm_note where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q30_result = $this->db->query($q30, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q30_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q30_result->result_array()),$case_no,'petition_lm_note');
            if($returndata!=1){
                log_message('error',"petition_lm_noteInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('petition_lm_note',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q30_result->num_rows())
            {
                log_message("error", "#petition_lm_note Delete failed case no: " . $case_no."petition_lm_note001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////petition_pattadar////////
        $q31 = "select * from petition_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q31_result = $this->db->query($q31, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q31_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q31_result->result_array()),$case_no,'petition_pattadar');
            if($returndata!=1){
                log_message('error',"petition_pattadarInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('petition_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q31_result->num_rows())
            {
                log_message("error", "#petition_pattadar Delete failed case no: " . $case_no."petition_pattadar001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_allottee////////
        $q32 = "select * from chitha_rmk_allottee where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q32_result = $this->db->query($q32, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q32_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q32_result->result_array()),$case_no,'chitha_rmk_allottee');
            if($returndata!=1){
                log_message('error',"chitha_rmk_allotteeInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_allottee',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q32_result->num_rows())
            {
                log_message("error", "#chitha_rmk_allottee Delete failed case no: " . $case_no."chitha_rmk_allottee001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_allottee////////
        $q33 = "select * from t_chitha_rmk_allottee where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q33_result = $this->db->query($q33, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q33_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q33_result->result_array()),$case_no,'t_chitha_rmk_allottee');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_allotteeInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_allottee',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q33_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_allottee Delete failed case no: " . $case_no."t_chitha_rmk_allottee001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_alongwith////////
        $q34 = "select * from chitha_rmk_alongwith where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q34_result = $this->db->query($q34, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q34_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q34_result->result_array()),$case_no,'chitha_rmk_alongwith');
            if($returndata!=1){
                log_message('error',"chitha_rmk_alongwithInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_alongwith',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q34_result->num_rows())
            {
                log_message("error", "#chitha_rmk_alongwith Delete failed case no: " . $case_no."chitha_rmk_alongwith001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_alongwith////////
        $q35 = "select * from t_chitha_rmk_alongwith where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q35_result = $this->db->query($q35, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q35_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q35_result->result_array()),$case_no,'t_chitha_rmk_alongwith');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_alongwithInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_alongwith',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q35_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_alongwith Delete failed case no: " . $case_no."t_chitha_rmk_alongwith001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_convorder////////
        $q36 = "select * from chitha_rmk_convorder where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q36_result = $this->db->query($q36, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q36_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q36_result->result_array()),$case_no,'chitha_rmk_convorder');
            if($returndata!=1){
                log_message('error',"chitha_rmk_convorderInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_convorder',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q36_result->num_rows())
            {
                log_message("error", "#chitha_rmk_convorder Delete failed case no: " . $case_no."chitha_rmk_convorder001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_convorder////////
        $q37 = "select * from t_chitha_rmk_convorder where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q37_result = $this->db->query($q37, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q37_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q37_result->result_array()),$case_no,'t_chitha_rmk_convorder');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_convorderInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_convorder',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q37_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_convorder Delete failed case no: " . $case_no."t_chitha_rmk_convorder001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_gen////////
        $q38 = "select * from chitha_rmk_gen where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q38_result = $this->db->query($q38, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q38_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q38_result->result_array()),$case_no,'chitha_rmk_gen');
            if($returndata!=1){
                log_message('error',"chitha_rmk_genInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_gen',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q38_result->num_rows())
            {
                log_message("error", "#chitha_rmk_gen Delete failed case no: " . $case_no."chitha_rmk_gen001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_infavor_of////////
        $q39 = "select * from chitha_rmk_infavor_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q39_result = $this->db->query($q39, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q39_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q39_result->result_array()),$case_no,'chitha_rmk_infavor_of');
            if($returndata!=1){
                log_message('error',"chitha_rmk_infavor_ofInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_infavor_of',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q39_result->num_rows())
            {
                log_message("error", "#chitha_rmk_infavor_of Delete failed case no: " . $case_no."chitha_rmk_infavor_of001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_infavor_of////////
        $q40 = "select * from t_chitha_rmk_infavor_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q40_result = $this->db->query($q40, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q40_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q40_result->result_array()),$case_no,'t_chitha_rmk_infavor_of');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_infavor_ofInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_infavor_of',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q40_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_infavor_of Delete failed case no: " . $case_no."t_chitha_rmk_infavor_of001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_inplace_of////////
        $q41 = "select * from chitha_rmk_inplace_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q41_result = $this->db->query($q41, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q41_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q41_result->result_array()),$case_no,'chitha_rmk_inplace_of');
            if($returndata!=1){
                log_message('error',"chitha_rmk_inplace_ofInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_inplace_of',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q41_result->num_rows())
            {
                log_message("error", "#chitha_rmk_inplace_of Delete failed case no: " . $case_no."chitha_rmk_inplace_of001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_chitha_rmk_inplace_of////////
        $q42 = "select * from t_chitha_rmk_inplace_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q42_result = $this->db->query($q42, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q42_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q42_result->result_array()),$case_no,'t_chitha_rmk_inplace_of');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_inplace_ofInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_inplace_of',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q42_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_inplace_of Delete failed case no: " . $case_no."t_chitha_rmk_inplace_of001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_other_opp_party////////
        $q43 = "select * from chitha_rmk_other_opp_party where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q43_result = $this->db->query($q43, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q43_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q43_result->result_array()),$case_no,'chitha_rmk_other_opp_party');
            if($returndata!=1){
                log_message('error',"chitha_rmk_other_opp_partyInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_other_opp_party',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q43_result->num_rows())
            {
                log_message("error", "#chitha_rmk_other_opp_party Delete failed case no: " . $case_no."chitha_rmk_other_opp_party001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }

        ////////////t_chitha_rmk_other_opp_party////////
        $q44 = "select * from t_chitha_rmk_other_opp_party where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q44_result = $this->db->query($q44, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q44_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q44_result->result_array()),$case_no,'t_chitha_rmk_other_opp_party');
            if($returndata!=1){
                log_message('error',"t_chitha_rmk_other_opp_partyInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_chitha_rmk_other_opp_party',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q44_result->num_rows())
            {
                log_message("error", "#t_chitha_rmk_other_opp_party Delete failed case no: " . $case_no."t_chitha_rmk_other_opp_party001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////t_reclassification////////
        $q45 = "select * from t_reclassification where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q45_result = $this->db->query($q45, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q45_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q45_result->result_array()),$case_no,'t_reclassification');
            if($returndata!=1){
                log_message('error',"t_reclassificationInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('t_reclassification',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q45_result->num_rows())
            {
                log_message("error", "#t_reclassification Delete failed case no: " . $case_no."t_reclassification001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_rmk_reclassification////////
        $q46 = "select * from chitha_rmk_reclassification where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q46_result = $this->db->query($q46, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q46_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q46_result->result_array()),$case_no,'chitha_rmk_reclassification');
            if($returndata!=1){
                log_message('error',"chitha_rmk_reclassificationInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_rmk_reclassification',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q46_result->num_rows())
            {
                log_message("error", "#chitha_rmk_reclassification Delete failed case no: " . $case_no."chitha_rmk_reclassification001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_tenant////////
        $q47 = "select * from chitha_tenant where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q47_result = $this->db->query($q47, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q47_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q47_result->result_array()),$case_no,'chitha_tenant');
            if($returndata!=1){
                log_message('error',"chitha_tenantInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_tenant',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q47_result->num_rows())
            {
                log_message("error", "#chitha_tenant Delete failed case no: " . $case_no."chitha_tenant001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////chitha_subtenant////////
        $q48 = "select * from chitha_subtenant where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q48_result = $this->db->query($q48, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q48_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q48_result->result_array()),$case_no,'chitha_subtenant');
            if($returndata!=1){
                log_message('error',"chitha_subtenantInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_subtenant',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q48_result->num_rows())
            {
                log_message("error", "#chitha_subtenant Delete failed case no: " . $case_no."chitha_subtenant001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ////////////jama_dag////////
        $q49 = "select * from jama_dag where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q49_result = $this->db->query($q49, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q49_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q49_result->result_array()),$case_no,'jama_dag');
            if($returndata!=1){
                log_message('error',"jama_dagInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('jama_dag',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number));
            if($this->db->affected_rows() != $q49_result->num_rows())
            {
                log_message("error", "#jama_dag Delete failed case no: " . $case_no."jama_dag001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }

            //////////check multiple dag////////
            $q34 = "select count(*) as c from jama_dag where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and dag_no !=? and patta_no=? and patta_type_code=?";
            $q34_result = $this->db->query($q34, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
            if ($q34_result->row()->c == 0) {
                ///////Delete jama_patta///////////
                $q35 = "select * from jama_patta where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q35_result = $this->db->query($q35, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code,
                    $patta_number,$patta_type));
                if ($q35_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q35_result->result_array()),$case_no,'jama_patta');
                    if($returndata!=1){
                        log_message('error',"jama_pattaInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_patta',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q35_result->num_rows()) {
                        log_message("error", "#jama_patta Delete failed case no: " . $case_no."jama_patta001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                ///////Delete jama_pattadar///////////
                $q36 = "select * from jama_pattadar where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q36_result = $this->db->query($q36, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
                if ($q36_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q36_result->result_array()),$case_no,'jama_pattadar');
                    if($returndata!=1){
                        log_message('error',"jama_pattadarInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_pattadar',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q36_result->num_rows()) {
                        log_message("error", "#jama_patta Delete failed case no: " . $case_no."jama_patta001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                ///////Delete jama_remark///////////
                $q37 = "select * from jama_remark where 
                    dist_code=? and subdiv_code=? and cir_code=? and 
                    mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
                    and patta_no=? and patta_type_code=?";
                $q37_result = $this->db->query($q37, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
                if ($q37_result->num_rows() > 0) {
                    $returndata=$this->archieve_table_insert(json_encode($q37_result->result_array()),$case_no,'jama_remark');
                    if($returndata!=1){
                        log_message('error',"jama_remarkInsert002".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    $this->db->delete('jama_remark',
                        array('dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'patta_no' => $patta_number,
                            'patta_type_code' => $patta_type));
                    if ($this->db->affected_rows() != $q37_result->num_rows()) {
                        $this->db->trans_rollback();
                        log_message("error", "#jama_remark Delete failed case no: " . $case_no."jama_remark001".$this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }
            }
        }
        /////////chitha_dag_pattadar//////////
        $q1 = "select * from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q1_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q1_result->result_array()),$case_no,'chitha_dag_pattadar');
            if($returndata!=1){
                log_message('error',"chitha_dag_pattadarInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_dag_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));

            if($this->db->affected_rows() != $q1_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_dag_pattadar Delete failed case no: " . $case_no."chitha_dag_pattadar001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }

        ///////chitha_pattadar/////////////
        $q55 = "select count(*) as c from chitha_basic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and dag_no !=? and patta_no=? and patta_type_code=?";
        $q55_result = $this->db->query($q55, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
        if ($q55_result->row()->c == 0) {
            $q2 = "select * from chitha_pattadar where 
                        dist_code=? and subdiv_code=? and cir_code=? 
                        and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
                . "and patta_no=? and patta_type_code=? ";
            $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
            if ($q2_result->num_rows() > 0) {
                $returndata=$this->archieve_table_insert(json_encode($q2_result->result_array()),$case_no,'chitha_pattadar');
                if($returndata!=1){
                    log_message('error',"chitha_pattadarInsert002".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                $this->db->delete('chitha_pattadar',
                    array('dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'patta_no' => $patta_number,
                        'patta_type_code' => $patta_type));
                if($this->db->affected_rows() != $q2_result->num_rows())
                {
                    $this->db->trans_rollback();
                    log_message("error", "#chitha_pattadar Delete failed case no: " . $case_no."chitha_pattadar001".$this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }
        /////////chitha_basic//////////
        $q21 = "select * from chitha_basic where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q21_result->num_rows() > 0) {
            $returndata=$this->archieve_table_insert(json_encode($q21_result->result_array()),$case_no,'chitha_basic');
            if($returndata!=1){
                log_message('error',"chitha_basicInsert002".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $this->db->delete('chitha_basic',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_number,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));

            if($this->db->affected_rows() != $q21_result->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error", "#chitha_basic Delete failed case no: " . $case_no."chitha_basic001".$this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        } else {
            $this->db->trans_rollback();
            log_message("error", "#chitha_basic Delete failed case no Data not found in Chitha ");
            $this->db->trans_rollback();
            return false;
        }

        if ($this->db->trans_status() === FALSE || $this->db->trans_status()==false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


    public function archieve_table_insert($data,$case_no,$table)
    {
        $table_date=[
            'case_no'    => $case_no,
            'table_name' => $table,
            'data'       => $data,
            'date'       => date('Y-m-d')
        ];
        $this->db->insert('archive_data',$table_date);
        log_message('error','archive_data'.$this->db->last_query());
        return $this->db->affected_rows();
    }


}