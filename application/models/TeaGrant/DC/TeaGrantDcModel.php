<?php
class TeaGrantDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();

    }

    // get application id by case no
    public function getSettlementApplicationDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->get('settlement_basic')
            ->row();
    }

    // get application id by case no
    public function getSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->row();
    }

    // get payment receive application id by case no
    public function getSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->get('settlement_basic')
            ->row();

    }

    // count application id by case no for DC
    public function countSettlementApplicationDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->get('settlement_basic')
            ->num_rows();
    }

    // count application id by case no by DC for SDLAC
    public function countSettlementApplicationDetailsByCaseNoForSDLAC($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->get('settlement_basic')
            ->num_rows();
    }

    // count application id by case no for DC
    public function countSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count payment receive application id by case no for DC
    public function countSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->get('settlement_basic')
            ->num_rows();
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

    // delete  proposal for SDLAC
    public function deleteProposalSDLAC($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('settlement_proposal_list');
        return $this->db->trans_status();
    }



    //*****************************************************************
    //********************** END COMMON MODEL  **************************************




    //********************** TeaGrant MODEL **************************************

    // get all pending settlement  cases TeaGrant
    public function getAllPendingSettlementTeaGrant($dist_code)
    {
      $this->db->select('*');
      $this->db->from('settlement_basic sb');
      // $this->db->join('settlement_notice sn', 'sn.case_no = sb.case_no');
      $this->db->where('sb.service_code', TEA_SERVICE_CODE);
      $this->db->where_in('sb.pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
      $this->db->where('sb.status', MB_PENDING);
      $this->db->where('sb.dist_code', $dist_code);
      $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no and sn2.notice_type = 'GN')", NULL, false);
      $data = $this->db->get();
      return $data;
    }

    // count  all pending settlement  cases TeaGrant
    public function countAllPendingSettlementTeaGrant($dist_code)
    {
      return $this->db->select('sb.*')
         ->from('settlement_basic sb')
         // ->join('settlement_notice sn', 'sn.case_no = sb.case_no')
         ->where('sb.service_code', TEA_SERVICE_CODE)
         ->where('sb.pending_officer', MB_DEPUTY_COMM)
         ->where('sb.status', MB_PENDING) 
         ->where('sb.dist_code', $dist_code) 
         ->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no and sn2.notice_type = 'GN')", NULL, false)
         ->count_all_results();
    }

    // count all notice generated cases TeaGrant
    public function countAllGeneratedNoticeTeaGrant($dist_code)
    {
      return $this->db->select('sb.*')
         ->from('settlement_basic sb')
         ->join('settlement_notice sn', 'sn.case_no = sb.case_no')
         ->where('sb.service_code', TEA_SERVICE_CODE)
         ->where('sb.pending_officer', MB_DEPUTY_COMM)
         ->where('sb.status', MB_PENDING) 
         ->where('sb.dist_code', $dist_code) 
         ->where('sb.adc_code is not null') 
         ->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no)", NULL, false)
         ->count_all_results();
    }

    

    // count all Mark list for SDLAC TeaGrant
    public function countMarkAsSDLACSettlementTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending settlement  cases TeaGrant
    public function getMarkAsSDLACSettlementTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // get all under consideration  cases TeaGrant
    public function getAllUnderConSettlementTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // count all under consideration  cases TeaGrant
    public function countAllUnderConsiderationAppTeaGrant($dist_code)
    {

        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }


    // count all report in send by DC to SDLAC TeaGrant
    public function countAllAppInReportSendByDcToSdlacTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();


    }

    // get all case under selected proposal in send by DC to SDLAC TeaGrant
    public function getAllAppInReportSendByDcToSdlacTeaGrant($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;
    }

    // check data exist or not under proposal list by case no
    public function countSettlementAppDetailsByCaseNoUnderProposal($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('status', 1)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // update data exist or not under proposal list by case no
    public function updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$data)
    {
        $this->db->where('case_no', $caseNo);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_cases',$data);
        return $this->db->affected_rows();
    }

    // get all proposal list in send by DC to SDLAC TeaGrant
    public function getAllProposalSendByDcToSdlacTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('status', 1);
        $this->db->where('created_by', MB_DEPUTY_COMM);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;


    }

    // get proposal details by id
    public function getProposalDetailsById($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('created_by', MB_DEPUTY_COMM);
        $data = $this->db->get()->row();

        return $data;
    }

    // count all proposal list in send by ADC to SDLAC TeaGrant
    public function countAllProposalSendByDcToSdlacTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('status', 1)
            ->where('dist_code', $dist_code)
            ->where('created_by', MB_DEPUTY_COMM)
            ->get('settlement_proposal_list')
            ->num_rows();

    }

    // save proposal list for SDLAC
    public function saveProposalSDLACTeaGrant($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('service_code',TEA_SERVICE_CODE );
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->trans_status();

    }

    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLACTeaGrant($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_cases', $data);
        return $this->db->trans_status();
    }

    // update proposal list
    public function updateProposalListById($proId,$data)
    {
        $this->db->where('id', $proId);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_list',$data);
        return $this->db->affected_rows();
    }

    // count proposal file name duplicate
    public function checkDuplicateFileNameInProposal($fileName)
    {
        return $this->db->select()
            ->where('file_path', $fileName)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // count all approve list TeaGrant
    public function countAllApproveAppBySdlacTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list TeaGrant
    public function getAllApproveAppBySdlacTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by Dc TeaGrant
    public function countAllRejectAppByDcTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list TeaGrant
    public function getAllRejectAppByDcTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application TeaGrant
    public function countAllOrderChithaUpdateAppTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application TeaGrant
    public function getAllOrderChithaUpdateAppTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for DC TeaGrant
    public function countRevertedByDeptApplicationTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_DEPARTMENT)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for DC TeaGrant
    public function getRevertedByDeptApplicationTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for DC TeaGrant
    public function countReRevertedByCoApplicationTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for DC TeaGrant
    public function getReRevertedByCoApplicationTeaGrant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM]);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }



    // count application id by case no for DC
    public function caseForDcApprovalTeaGrant($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('status', MB_PENDING)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->get('settlement_basic')
            ->num_rows();
    }

    //lb details approve handle for settlement application cases---------29122022 
    public function lbdetailsApproveSettlementCases($lb_details_id,$elb_enc_id,$uuid,$dag_no,$application_no,$lb_approval_rmk){
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");
        //getting the location,dag and year details frtom land bank details table
        $this->db->select('*')
            ->where('id',  $lb_details_id)
            ->where('village_uuid',  $uuid)
            ->where('dag_no',  $dag_no)
            ->from('land_bank_details');
        $query = $this->db->get();
        $lb_details = $query->row();

        if(count($lb_details) > 0){
            //update data in land bank details
            $this->db->where('id', $lb_details_id)
                ->where('village_uuid',  $uuid)
                ->where('dag_no',  $dag_no)
                ->update('land_bank_details', array(
                    'status' => LAND_BANK_STATUS_APPROVED
                ));
            if($this->db->affected_rows() != 1){
                //if error in update--------
                log_message("error", "#LBSETL001, Error in update, table 'land_bank_details' in changing status to approved");
                $data = array(
                    'responseType' => 0,
                    'msg'=>"#LBSETL001: Insertion fail in Land Bank for case no : ".$application_no
                );
                return json_encode($data);
                return false;
            }
        }else{
            log_message("error", "#LBSETL003, Error in fetch, table 'land_bank_details' in changing status to approved");
            $data = array(
                'responseType' => 0,
                'msg'=>"#LBSETL003: Insertion fail in Land Bank for case no : ".$application_no
            );
            return json_encode($data);
            return false;
        }

        //**************************************************//
        //insert data in land bank proceeding details 
        $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
            'land_bank_details_id' => $lb_details_id,
            'remark' => $lb_approval_rmk,
            'status' => LAND_BANK_STATUS_APPROVED,
            'created_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->all_userdata()['user_code']
        ));
        if ($tstatus1 != 1 )
        {
            log_message("error", "#LBSETL002, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            $data = array(
                'responseType' => 0,
                'msg'=>"#LBSETL002: Insertion fail in Land Bank for case no : ".$application_no
            );
            return json_encode($data);
            return false;
        }

        //insert data in c_land_bank_details table -------------
        $this->db->select('id')
            ->where('village_uuid',  $uuid)
            ->where('dag_no',  $dag_no)
            ->from('c_land_bank_details');
        $query = $this->db->get();
        $c_lb_id = $query->row()->id;
        if ($c_lb_id == null || $c_lb_id == '' )
        {
            log_message("error", "#LBSETLE4U, Error in fetch on c_land_bank_details table");
            $data = array(
                'responseType' => 0,
                'msg'=>"#LBSETLE4U: Insertion fail in Land Bank for case no : ".$application_no
            );
            return json_encode($data);
            return false;
        }

        //return $c_land_bank_inserted_id;
        //getting data from land bank encroacher details
        $this->db->select('*')
            ->where('land_bank_details_id',  $lb_details_id)
            ->where('application_no',  $application_no)
            ->where('id',$elb_enc_id)
            ->from('land_bank_encroacher_details');
        $query = $this->db->get();
        $lb_encroacher_details_array = $query->row_array();
        //insert data in the land bank encroacher details 
        unset($lb_encroacher_details_array['land_bank_details_id']);
        $lb_encroacher_details_array['c_land_bank_details_id'] = $c_lb_id;
        $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $lb_encroacher_details_array);
        if ($tstatus3 != 1 )
        {
            log_message("error", "#LANDBNK001333, Error in insert on c_land_bank_encroacher_details table");
            $data = array(
                'responseType' => 0,
                'msg'=>"#LANDBNK001333: Insertion fail in Land Bank for case no : ".$application_no
            );
            return json_encode($data);
            return false;
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            log_message("error", "#LANDBNK0013, Transaction Status Error");

            $data = array(
                'responseType' => 0,
                'msg'=>"#LANDBNK0013: Insertion fail in Land Bank for case no : ".$application_no
            );
            return json_encode($data);
            return false;
        }else{
            $data = array(
                'responseType' => 1,
                'msg'=>"#LANDBNK00133: Data successfully inserted into Land Bank : ".$application_no
            );
            return json_encode($data);
        }
    }


    // Count all final verify by dc application list TeaGrant
    public function countAllCasesForFinalVerifyAppTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_FINAL_APPROVED_BY_DC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }


    // get all final verify by dc application list TeaGrant
    public function getAllCasesForFinalVerifyAppTeaGrant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
            ->where('status', MB_FINAL_APPROVED_BY_DC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic');
    }

    // Count all Sdlac Status List TeaGrant
    public function countSdlacStatusList($dist_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('sdlac_prceed_status', SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            ->where('final_verify_status', 0)
            ->where('created_by', MB_DEPUTY_COMM)
            ->where('service_code', TEA_SERVICE_CODE)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // get all proposal list in send by DC to SDLAC TeaGrant
    public function getSdlacApprovalProposalListTeaGrant($dist_code)
    {

        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('final_verify_status', 0);
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', MB_DEPUTY_COMM);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;
    }

    // get single proposal list in send by DC to SDLAC TeaGrant
    public function getSdlacApprovalProposalIndividualTeaGrant($proposal_no,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proposal_no);
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('created_by', MB_DEPUTY_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $data = $this->db->get();

        return $data;
    }

    // SDLAC/CDLAC Member report details proposal wise
    public function getSdlacMemberReportDetailsTeaGrant($proposal_no,$dist_code)
    {
        $this->db->select('settlement_sdlac_member_report.*,users.username,users.phone_no');
        $this->db->from('settlement_sdlac_member_report');
        $this->db->join('users','users.user_code = settlement_sdlac_member_report.sdlac_member_code');
        $this->db->where('settlement_sdlac_member_report.proposal_no', $proposal_no);
        $this->db->where('settlement_sdlac_member_report.dist_code', $dist_code);
        $this->db->where('settlement_sdlac_member_report.service_code', TEA_SERVICE_CODE);
        $data = $this->db->get();
        return $data;

    }

    // get SDLAC/CDLAC Member Status List TeaGrant
    public function getSdlacMemberStatus($dist_code, $proposal_no)
    {
        return $this->db->select('status')
            ->where('dist_code', $dist_code)
            ->where('proposal_no', $proposal_no)
            ->where_in('status', [0,2]) //0:pending, 2:disagree
            ->where('created_by', MB_DEPUTY_COMM)
            ->get('settlement_sdlac_member_report')
            ->num_rows();
    }

    // get dag details
    public function getDagDetailsTenant($case_no)
    {
        return $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_dag_details')
            ->row();
    }

    public function getOwners($case){
        $owners = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $owners->result();
    }

    public function getBuyers($case){
        $buyers = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'B')
            ->get('settlement_applicant');
        return $buyers->result();
    }

    // get all applicant
    public function getApplicantDetails($case)
    {
        return $this->db->select('pdar_name')
            ->where('case_no',$case)
            ->where('is_applicant',1)
            ->get('settlement_applicant')
            ->row();

    }

    // get all applicant
    public function getAllApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_applicant');

        return $applicants->result();
    }

    // count general file name duplicate
    public function checkDuplicateFileNameInGeneral($fileName)
    {
        return $this->db->select()
            ->where('notice_link', $fileName)
            ->get('settlement_notice')
            ->num_rows();
    }

    // get all pending settlement  cases TeaGrant
    public function getAllPendingNoticeGenerateTeaGrant($dist_code)
    {
      $this->db->select('*');
      $this->db->from('settlement_basic sb');
      $this->db->join('settlement_notice sn', 'sn.case_no = sb.case_no');
      $this->db->where('sb.service_code', TEA_SERVICE_CODE);
      $this->db->where('sb.pending_officer', MB_DEPUTY_COMM);
      $this->db->where('sb.status', MB_PENDING);
      $this->db->where('sb.dist_code', $dist_code);
      $this->db->where('sb.adc_code is not null');
      $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no)", NULL, false);
      $data = $this->db->get();
      return $data;
    }

    public function getLocationName($dist_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->group_by('subdiv_code, cir_code');
        $data = $this->db->get();
        return $data;
    }

    // get general notice
    public function getGeneralNoticeDetails($case)
    {
        return $this->db->select()
            ->where('case_no',$case)
            ->where('service_code',TEA_SERVICE_CODE)
            ->where('notice_type','GN')
            ->get('settlement_notice')
            ->row();
    }

    // count application id by case no for ADC
    public function countApplicationDetailsByCaseNo($caseNo, $dist_code, $serviceCode)
    {
        return $this->db->select()
          ->where('case_no', $caseNo)
          ->where('dist_code', $dist_code)
          ->where('service_code', $serviceCode)
          ->where_in('pending_officer', [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM])
          ->get('settlement_basic')
          ->num_rows();
    }

    // count all payment pending cases TeaGrant
    public function countAllPaymentPendingByApplicant($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic sb JOIN settlement_premium sp 
                        ON sb.case_no=sp.case_no WHERE sb.status=? AND sb.pay_notice_gen_yn=? AND 
                          sp.grn_no IS NULL AND sb.service_code=? AND sb.pending_officer=?", 
                            array(MB_PAYMENT_NOTICE, 'Y', TEA_SERVICE_CODE, MB_DEPUTY_COMM))->num_rows();
    }


    // get all payment pending cases TeaGrant
    public function getAllPaymentPendingTeaGrant($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic sb JOIN settlement_premium sp 
                        ON sb.case_no=sp.case_no WHERE sb.status=? AND sb.pay_notice_gen_yn=? AND 
                          sp.grn_no IS NULL AND sb.service_code=? AND sb.pending_officer=?", 
                            array(MB_PAYMENT_NOTICE, 'Y', TEA_SERVICE_CODE, MB_DEPUTY_COMM));
    }


    // count all payment approval pending cases TeaGrant
    public function countAllPaymentApprovalPendingByApplicant($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic sb JOIN settlement_premium sp 
                        ON sb.case_no=sp.case_no WHERE sb.status=? AND sb.pay_notice_gen_yn=? AND 
                          sp.grn_no IS NOT NULL AND sb.service_code=? AND sb.pending_officer=?", 
                            array(MB_PAYMENT_NOTICE, 'Y', TEA_SERVICE_CODE, MB_DEPUTY_COMM))->num_rows();
    }

    // get all payment pending cases TeaGrant
    public function getAllPaymentApprovalPendingTeaGrant($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic sb JOIN settlement_premium sp 
                        ON sb.case_no=sp.case_no WHERE sb.status=? AND sb.pay_notice_gen_yn=? AND 
                          sp.grn_no IS NOT NULL AND sb.service_code=? AND sb.pending_officer=?", 
                            array(MB_PAYMENT_NOTICE, 'Y', TEA_SERVICE_CODE, MB_DEPUTY_COMM));
    }

    // get payment notice
    public function getPaymentNoticeDetails($case)
    {
        return $this->db->select()
            ->where('case_no',$case)
            ->where('service_code',TEA_SERVICE_CODE)
            ->where('notice_type','PN')
            ->get('settlement_notice')
            ->row();
    }

    // report from department 
    public function countAllDeptApprovalCases($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic WHERE service_code=? AND 
                        pending_officer=? AND dept_approval=? AND status=? AND dist_code=?", 
                          array(TEA_SERVICE_CODE, 'DC', 'Y', MB_PENDING, $dist_code))->num_rows();
    }

    // get dag details
    public function getDagDetailsList($case_no)
    {
        return $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_dag_details')
            ->result();
    }


    // report from department 
    public function countAllDeptRevertCases($dist_code)
    {
      return $query = $this->db->query("SELECT * FROM settlement_basic WHERE service_code=? AND 
                        pending_office=? AND status=? AND dist_code=? AND dept_revert=?", 
                          array(TEA_SERVICE_CODE, 'DC', 'R', $dist_code, 1))->num_rows();
    }

    // get all pending settlement  cases TeaGrant
    public function getAllPendingDeptRevertTeaGrant($dist_code)
    {
      $this->db->select('*');
      $this->db->from('settlement_basic');
      $this->db->where('service_code', TEA_SERVICE_CODE);
      $this->db->where('pending_office', MB_DEPUTY_COMM);
      $this->db->where('dept_revert', 1);
      $this->db->where('status', 'R');
      $this->db->where('dist_code', $dist_code);
      $data = $this->db->get();
      return $data;
    }

    // get all pending settlement  cases TeaGrant
    public function getAllPendingDeptApprovalTeaGrant($dist_code)
    {
      $this->db->select('*');
      $this->db->from('settlement_basic sb');
      $this->db->where('sb.service_code', TEA_SERVICE_CODE);
      $this->db->where_in('sb.pending_officer', [MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM]);
      $this->db->where('sb.dept_approval', 'Y');
      $this->db->where('sb.dept_code IS NOT NULL');
      $this->db->where('sb.status', MB_PENDING);
      $this->db->where('sb.dist_code', $dist_code);
      $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no and sn2.notice_type = 'GN')", NULL, false);
      $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no and sn2.notice_type = 'PN')", NULL, false);
      $data = $this->db->get();
      return $data;
    }


    // count all notice generated cases TeaGrant
    public function countAllAdcReReport($dist_code)
    {
      return $this->db->select('sb.*')
         ->from('settlement_basic sb')
         ->join('settlement_notice sn', 'sn.case_no = sb.case_no')
         ->where('sb.service_code', TEA_SERVICE_CODE)
         ->where('sb.pending_officer', MB_DEPUTY_COMM)
         ->where_in('sb.status', [MB_PENDING, MB_REVERT]) 
         ->where('sb.dist_code', $dist_code) 
         ->where('sb.adc_code is not null') 
         ->where('sb.dc_code is not null') 
         ->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no)", NULL, false)
         ->count_all_results();
    }

    // get all pending settlement  cases TeaGrant
    public function getAllPendingReReportByAdcTeaGrant($dist_code)
    {
      $this->db->select('*');
      $this->db->from('settlement_basic sb');
      $this->db->join('settlement_notice sn', 'sn.case_no = sb.case_no');
      $this->db->where('sb.service_code', TEA_SERVICE_CODE);
      $this->db->where('sb.pending_officer', MB_DEPUTY_COMM);
      $this->db->where_in('sb.status', [MB_PENDING, MB_REVERT]);
      $this->db->where('sb.dist_code', $dist_code);
      $this->db->where('sb.adc_code is not null');
      $this->db->where('sb.dc_code is not null');
      $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no)", NULL, false);
      $data = $this->db->get();
      return $data;
    }





}