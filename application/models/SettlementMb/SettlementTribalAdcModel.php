<?php
class SettlementTribalAdcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }





    //*****************************************************************
    //********************** COMMON MODEL **************************************

    // Count all Sdlac Status List TRIBAL
    public function countSdlacStatusList($dist_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('sdlac_prceed_status', SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            ->where('final_verify_status', 0)
            ->where('created_by', MB_ADD_DEPUTY_COMM)
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('status', 1)
            ->where('user_code',$this->session->userdata('user_code'))
            ->get('settlement_proposal_list')
            ->num_rows();
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

    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
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
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
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
            ->where('pending_officer', MB_DEPUTY_COMM)
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
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
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
            ->where('pending_officer', MB_DEPUTY_COMM)
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
            ->where('pending_officer', MB_DEPUTY_COMM)
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
        $this->db->trans_complete();
    }



    //*****************************************************************
    //********************** END COMMON MODEL  **************************************








    //********************** TRIBAL MODEL **************************************

    // get all pending settlement  cases TRIBAL
    public function getAllPendingSettlementTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // count  all pending settlement  cases TRIBAL
    public function countAllPendingSettlementTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all Mark list for SDLAC TRIBAL
    public function countMarkAsSDLACSettlementTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending settlement  cases TRIBAL
    public function getMarkAsSDLACSettlementTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // count all report in send by DC to SDLAC TRIBAL
    public function countAllAppInReportSendByDcToSdlacTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();


    }

    // get all case under selected proposal in send by DC to SDLAC TRIBAL
    public function getAllAppInReportSendByDcToSdlacTribal($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }


    // get all under consideration  cases TRIBAL
    public function getAllUnderConSettlementTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }


    // count all under consideration  cases TRIBAL
    public function countAllUnderConsiderationAppTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();
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

    // get all proposal list in send by DC to SDLAC TRIBAL
    public function getAllProposalSendByDcToSdlacTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('status', 1);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('user_code',$this->session->userdata('user_code'));
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
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        $data = $this->db->get()->row();

        return $data;
    }

    // count all proposal list in send by DC to SDLAC TRIBAL
    public function countAllProposalSendByDcToSdlacTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('status', 1)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('dist_code', $dist_code)
            ->where('created_by', MB_ADD_DEPUTY_COMM)
            ->where('user_code',$this->session->userdata('user_code'))
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // save proposal list for SDLAC
    public function saveProposalSDLACTribal($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('service_code',SETTLEMENT_TRIBAL_COMMUNITY_ID );
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->affected_rows();
    }

    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLACTribal($data)
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

    // count all approve list TRIBAL
    public function countAllApproveAppBySdlacTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('from_office', MB_ADD_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list TRIBAL
    public function getAllApproveAppBySdlacTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by Dc TRIBAL
    public function countAllRejectAppByDcTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('from_office', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list TRIBAL
    public function getAllRejectAppByDcTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application TRIBAL
    public function countAllOrderChithaUpdateAppTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application TRIBAL
    public function getAllOrderChithaUpdateAppTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for DC TRIBAL
    public function countRevertedByDeptApplicationTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('from_office', MB_DEPARTMENT)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for DC TRIBAL
    public function getRevertedByDeptApplicationTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for DC TRIBAL
    public function countReRevertedByCoApplicationTribal($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for DC TRIBAL
    public function getReRevertedByCoApplicationTribal($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $this->db->where("(adc_code = '" . $this->session->userdata('user_code') . "' OR adc_code IS NULL)", null, false);
        $data = $this->db->get();
        return $data;
    }

    // get all proposal list in send by DC to SDLAC TRIBAL
    public function getSdlacApprovalProposalListTribal($dist_code)
    {

        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('final_verify_status', 0);
        $this->db->where('service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        $this->db->where('status', 1);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $data = $this->db->get();
        return $data;
    }

    // get single proposal list in send by DC to SDLAC TRIBAL
    public function getSdlacApprovalProposalIndividualTribal($proposal_no,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proposal_no);
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $data = $this->db->get();

        return $data;
    }


    // SDLAC/CDLAC Member report details proposal wise
    public function getSdlacMemberReportDetailsTribal($proposal_no,$dist_code)
    {
        $this->db->select('settlement_sdlac_member_report.*,users.username,users.phone_no');
        $this->db->from('settlement_sdlac_member_report');
        $this->db->join('users','users.user_code = settlement_sdlac_member_report.sdlac_member_code');
        $this->db->where('settlement_sdlac_member_report.proposal_no', $proposal_no);
        $this->db->where('settlement_sdlac_member_report.dist_code', $dist_code);
        $this->db->where('settlement_sdlac_member_report.service_code', SETTLEMENT_TRIBAL_COMMUNITY_ID);
        $data = $this->db->get();
        return $data;

    }

    // get SDLAC/CDLAC Member Status List TRIBAL
    public function getSdlacMemberStatus($dist_code, $proposal_no)
    {
        return $this->db->select('status')
            ->where('dist_code', $dist_code)
            ->where('proposal_no', $proposal_no)
            ->where_in('status', [0,2]) //0:pending, 2:disagree
            ->where('created_by', MB_ADD_DEPUTY_COMM)
            ->get('settlement_sdlac_member_report')
            ->num_rows();
    }

    // // get all case under selected proposal in send by DC to SDLAC Tribal
    // public function getAllAppInReportSendByDcToSdlacTribal($proposal_no)
    // {
    //     $this->db->select('*');
    //     $this->db->from('settlement_proposal_cases');
    //     $this->db->where('proposal_id', $proposal_no);
    //     $data = $this->db->get();
    //     return $data;

    // }




    //**********************END TRIBAL **************************************










}