<?php
class SettlementMbSdoModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    //*****************************************************************
    //********************** COMMON MODEL BY MASUD REZA **************************************



    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$suv_div,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }

    // get application id by case no
    public function getSettlementApplicationDetailsByCaseNo($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->row();
    }

    // get application id by case no
    public function getSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->row();
    }

    // get payment receive application id by case no
    public function getSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->get('settlement_basic')
            ->row();

    }

    // count application id by case no for SDO
    public function countSettlementApplicationDetailsByCaseNo($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count application id by case no by SDO for SDLAC
    public function countSettlementApplicationDetailsByCaseNoForSDLAC($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count application id by case no for SDO
    public function countSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count payment receive application id by case no for SDO
    public function countSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('pending_officer', MB_SUB_DIV_COMM)
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




    //********************** KHAS MODEL **************************************

    // get all pending settlement  cases KHAS
    public function getAllPendingSettlementKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }

    // count  all pending settlement  cases KHAS
    public function countAllPendingSettlementKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all Mark list for SDLAC KHAS
    public function countMarkAsSDLACSettlementKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending settlement  cases KHAS
    public function getMarkAsSDLACSettlementKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }

    // get all under consideration  cases KHAS
    public function getAllUnderConSettlementKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }


    // count all under consideration  cases KHAS
    public function countAllUnderConsiderationAppKhas($dist_code,$suv_div)
    {

        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }


    // count all report in send by SDO to SDLAC KHAS
    public function countAllAppInReportSendByDcToSdlacKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();


    }


    // get all case under selected proposal in send by SDO to SDLAC KHAS
    public function getAllAppInReportSendByDcToSdlacKhas($proposal_no)
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

    // get all proposal list in send by SDO to SDLAC KHAS
    public function getAllProposalSendByDcToSdlacKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;


    }


    // get all proposal list in send by DC to SDLAC KHAS
    public function getSdlacApprovalProposalListKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('final_verify_status', 0);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;

    }



    // get proposal details by id
    public function getProposalDetailsById($proId,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('status', 1);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $data = $this->db->get()->row();

        return $data;
    }

    // count all proposal list in send by SDO to SDLAC KHAS
    public function countAllProposalSendByDcToSdlacKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('status', 1)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('created_by', MB_SUB_DIV_COMM)
            ->get('settlement_proposal_list')
            ->num_rows();

    }


    // SDLAC/CDLAC Member report details proposal wise
    public function getSdlacMemberReportDetailsKhas($proposal_no,$dist_code)
    {
        $this->db->select('settlement_sdlac_member_report.*,users.username,users.phone_no');
        $this->db->from('settlement_sdlac_member_report');
        $this->db->join('users','users.user_code = settlement_sdlac_member_report.sdlac_member_code');
        $this->db->where('settlement_sdlac_member_report.proposal_no', $proposal_no);
        $this->db->where('settlement_sdlac_member_report.dist_code', $dist_code);
        $this->db->where('settlement_sdlac_member_report.service_code', SETTLEMENT_KHAS_LAND_ID);
        $data = $this->db->get();
        return $data;

    }


    // get single proposal list in send by DC to SDLAC KHAS
    public function getSdlacApprovalProposalIndividualKhas($proposal_no,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proposal_no);
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $data = $this->db->get();

        return $data;
    }

    // save proposal list for SDLAC
    public function saveProposalSDLACKhas($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('service_code',SETTLEMENT_KHAS_LAND_ID );
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->trans_status();

    }

    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLACKhas($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_cases', $data);
        return $this->db->trans_status();
    }

    // update proposal list
    public function updateProposalListById($proId,$dist_code,$suv_div,$data)
    {
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
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

    // count all approve list KHAS
    public function countAllApproveAppBySdlacKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list KHAS
    public function getAllApproveAppBySdlacKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('from_office', MB_SUB_DIV_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by SDO KHAS
    public function countAllRejectAppByDcKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list KHAS
    public function getAllRejectAppByDcKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('from_office', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application KHAS
    public function countAllOrderChithaUpdateAppKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application KHAS
    public function getAllOrderChithaUpdateAppKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for SDO KHAS
    public function countRevertedByDeptApplicationKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_DEPARTMENT)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for SDO KHAS
    public function getRevertedByDeptApplicationKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for SDO KHAS
    public function countReRevertedByCoApplicationKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for SDO KHAS
    public function getReRevertedByCoApplicationKhas($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_KHAS_LAND_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }



    // count application id by case no for SDO
    public function caseForDcApprovalKhas($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('status', MB_PENDING)
            ->where('pending_officer', MB_SUB_DIV_COMM)
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


    // Count all final verify by SDO application list KHAS
    public function countAllCasesForFinalVerifyAppKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_FINAL_APPROVED_BY_DC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }


    // get all final verify by dc application list KHAS
    public function getAllCasesForFinalVerifyAppKhas($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_FINAL_APPROVED_BY_DC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic');
    }

    // Count all Sdlac Status List KHAS
    public function countSdlacStatusList($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('sdlac_prceed_status', SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            ->where('final_verify_status', 0)
            ->where('created_by', MB_SUB_DIV_COMM)
            ->where('service_code', SETTLEMENT_KHAS_LAND_ID)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // get SDLAC/CDLAC Member Status List KHAS
    public function getSdlacMemberStatus($dist_code, $proposal_no)
    {
        return $this->db->select('status')
            ->where('dist_code', $dist_code)
            ->where('proposal_no', $proposal_no)
            ->where_in('status', [0,2]) //0:pending, 2:disagree
            ->where('created_by', MB_SUB_DIV_COMM)
            ->get('settlement_sdlac_member_report')
            ->num_rows();
    }



    //********************** END KHAS **************************************


}