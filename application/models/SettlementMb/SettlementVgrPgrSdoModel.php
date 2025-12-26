<?php
class SettlementVgrPgrSdoModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    


    //*****************************************************************
    //********************** COMMON MODEL **************************************

    // count general file name duplicate
    public function checkDuplicateFileNameInGeneral($fileName)
    {
        return $this->db->select()
            ->where('notice_link', $fileName)
            ->get('settlement_notice')
            ->num_rows();
    }

    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$subdiv_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();

    }

    // get application id by case no
    public function getSettlementApplicationDetailsByCaseNo($caseNo,$dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->row();
    }

    // get application id by case no
    public function getSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->get('settlement_basic')
            ->row();
    }

    // get payment receive application id by case no
    public function getSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->get('settlement_basic')
            ->row();

    }

    // count application id by case no for DC
    public function countSettlementApplicationDetailsByCaseNo($caseNo,$dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('pending_officer', MB_SUB_DIV_COMM)
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
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count application id by case no for DC
    public function countSettlementAppDetailsByCaseNoOnlyView($caseNo,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count payment receive application id by case no for DC
    public function countSettlementPaymentReceivedAppDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
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
        $this->db->trans_complete();
    }



    //*****************************************************************
    //********************** END COMMON MODEL  **************************************








    //********************** VgrPgr MODEL **************************************

    // get all pending settlement  cases VgrPgr
    public function getAllPendingSettlementVgrPgr($dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;
    }

    // count  all pending settlement  cases VgrPgr
    public function countAllPendingSettlementVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all Mark list for SDLAC VgrPgr
    public function countMarkAsSDLACSettlementVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending settlement  cases VgrPgr
    public function getMarkAsSDLACSettlementVgrPgr($dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;
    }

    // count all report in send by DC to SDLAC VgrPgr
    public function countAllAppInReportSendByDcToSdlacVgrPgr($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();


    }

    // get all case under selected proposal in send by DC to SDLAC VgrPgr
    public function getAllAppInReportSendByDcToSdlacVgrPgr($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }


    // get all under consideration  cases KHAS
    public function getAllUnderConSettlementVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // count all under consideration  cases KHAS
    public function countAllUnderConsiderationAppVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
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

    // get all proposal list in send by DC to SDLAC VgrPgr
    public function getAllProposalSendByDcToSdlacVgrPgr($dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('status', 1);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;


    }

    // get proposal details by id
    public function getProposalDetailsById($proId,$dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where('status', 1);
        $data = $this->db->get()->row();

        return $data;
    }

    // count all proposal list in send by DC to SDLAC VgrPgr
    public function countAllProposalSendByDcToSdlacVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('status', 1)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_proposal_list')
            ->num_rows();

    }

    // save proposal list for SDLAC
    public function saveProposalSDLACVgrPgr($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('service_code',SETTLEMENT_PGR_VGR_LAND_ID );
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->affected_rows();
    }

    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLACVgrPgr($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_cases', $data);
        return $this->db->affected_rows();
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

    // count all approve list VgrPgr
    public function countAllApproveAppBySdlacVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list VgrPgr
    public function getAllApproveAppBySdlacVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('from_office', MB_SUB_DIV_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by Dc VgrPgr
    public function countAllRejectAppByDcVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('from_office', MB_SUB_DIV_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list VgrPgr
    public function getAllRejectAppByDcVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('from_office', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application VgrPgr
    public function countAllOrderChithaUpdateAppVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application VgrPgr
    public function getAllOrderChithaUpdateAppVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for DC VgrPgr
    public function countRevertedByDeptApplicationVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('from_office', MB_DEPARTMENT)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for DC VgrPgr
    public function getRevertedByDeptApplicationVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for DC VgrPgr
    public function countReRevertedByCoApplicationVgrPgr($dist_code,$subdiv_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for DC VgrPgr
    public function getReRevertedByCoApplicationVgrPgr($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // Count all Sdlac Status List VgrPgr
    public function countSdlacStatusList($dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('sdlac_prceed_status', SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            ->where('final_verify_status', 0)
            ->where('created_by', MB_SUB_DIV_COMM)
            ->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // get all proposal list in send by DC to SDLAC VgrPgr
    public function getSdlacApprovalProposalListVgrPgr($dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('sdlac_prceed_status', 2);
        $this->db->where('final_verify_status', 0);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;

    }

    // get single proposal list in send by DC to SDLAC VgrPgr
    public function getSdlacApprovalProposalIndividualVgrPgr($proposal_no,$dist_code,$suv_div)
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

    // SDLAC/CDLAC Member report details proposal wise
    public function getSdlacMemberReportDetailsVgrPgr($proposal_no,$dist_code)
    {
        $this->db->select('settlement_sdlac_member_report.*,users.username,users.phone_no');
        $this->db->from('settlement_sdlac_member_report');
        $this->db->join('users','users.user_code = settlement_sdlac_member_report.sdlac_member_code');
        $this->db->where('settlement_sdlac_member_report.proposal_no', $proposal_no);
        $this->db->where('settlement_sdlac_member_report.dist_code', $dist_code);
        $this->db->where('settlement_sdlac_member_report.service_code', SETTLEMENT_PGR_VGR_LAND_ID);
        $data = $this->db->get();
        return $data;

    }

    // get SDLAC/CDLAC Member Status List VgrPgr
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


    // get reservation dag details
    public function getReservationDetails($case,$distCode,$suv_div)
    {
        $reza = $this->db->select()
            ->where('case_no',$case)
            ->where('dist_code',$distCode)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_dag_details');


        return $reza->result();

    }


    // get general notice
    public function getGeneralNoticeDetails($case)
    {
        return $this->db->select()
            ->where('case_no',$case)
            ->where('service_code',SETTLEMENT_PGR_VGR_LAND_ID)
            ->where('notice_type','GN')
            ->get('settlement_notice')
            ->row();


    }

    public function getCircleClusters($dist_code, $subdiv_code)
    {
        return $this->db->select('*')
        ->where('dist_code', $dist_code)
        ->where('subdiv_code', $subdiv_code)
        ->where('pending_at', MB_SUB_DIV_COMM)
        ->where('status', 'AE')
        ->get('settlement_circle_cluster')
        ->num_rows();
    }

    public function clusterCaseReReport($dist_code, $subdiv_code)
    {
        return $this->db->select('*')
        ->where('dist_code', $dist_code)
        ->where('subdiv_code', $subdiv_code)
        ->where('pending_officer', MB_SUB_DIV_COMM)
        ->where('status', 'AF')
        ->where('(pending_officer = \'ADC\' OR pending_officer = \'SDO\')')
        ->get('settlement_basic')
        ->num_rows();
    }



    //**********************END VgrPgr **************************************










}