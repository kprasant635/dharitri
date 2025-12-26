<?php
class SettlementApDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }





    //*****************************************************************
    //********************** COMMON MODEL **************************************



    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
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
            ->where('pending_officer', MB_DEPUTY_COMM)
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


    //*****************************************************************
    //********************** END COMMON MODEL  **************************************








    //********************** AP MODEL **************************************


    // Count all final verify by dc application list KHAS
    public function countAllCasesForFinalVerifyAppAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('dist_code', $dist_code)
            ->where('final_verify_status', 1)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }
    // get all final verify by dc application list KHAS
    public function getAllCasesForFinalVerifyAppAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('dist_code', $dist_code)
            ->where('final_verify_status', 1)
            ->where('status', 1)
            ->get('settlement_proposal_list');
    }

    // get all pending settlement  cases AP
    public function getAllPendingSettlementAp($dist_code)
    {
        $status=array(MB_PENDING,MB_NR);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where_in('status', $status);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // count  all pending settlement  cases AP
    public function countAllPendingSettlementAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where_in('status', array(MB_PENDING,MB_NR))
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }


    // get all pending settlement  cases AP
    public function getMarkAsSDLACSettlementAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }



    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLACAp($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_cases', $data);
        return $this->db->trans_status();
    }


    // count all approve list AP
    public function countAllApproveAppBySdlacAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list AP
    public function getAllApproveAppBySdlacAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by Dc AP
    public function countAllRejectAppByDcAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list AP
    public function getAllRejectAppByDcAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application AP
    public function countAllOrderChithaUpdateAppAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application AP
    public function getAllOrderChithaUpdateAppAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for DC AP
    public function countRevertedByDeptApplicationAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('from_office', MB_DEPARTMENT)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for DC AP
    public function getRevertedByDeptApplicationAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for DC AP
    public function countReRevertedByCoApplicationAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for DC AP
    public function getReRevertedByCoApplicationAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // count application id by case no for DC
    public function caseForDcApprovalAp($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            //    ->where('status', MB_PENDING)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->get('settlement_basic')
            ->num_rows();
        //echo $this->db->last_query();
    }




    //  new code by Masud Reza

    // count all Mark list for SDLAC AP
    public function countMarkAsSDLACSettlementAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all proposal list in send by DC to SDLAC AP
    public function countAllProposalSendByDcToSdlacAp($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('status', 1)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('dist_code', $dist_code)
            ->get('settlement_proposal_list')
            ->num_rows();

    }

    // count all under consideration  cases AP
    public function countAllUnderConsiderationAppKhas($dist_code)
    {

        return $this->db->select()
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all under consideration  cases KHAS
    public function getAllUnderConSettlementAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // save proposal list for SDLAC
    public function saveProposalSDLACAp($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('service_code',SETTLEMENT_AP_TRANSFER_ID );
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->trans_status();

    }

    // delete  proposal for SDLAC
    public function deleteProposalSDLAC($id)
    {
        $this->db->trans_start();
        $this->db->where('id',$id);
        $this->db->delete('settlement_proposal_list');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    // count proposal file name duplicate
    public function checkDuplicateFileNameInProposal($fileName)
    {
        return $this->db->select()
            ->where('file_path', $fileName)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // get all proposal list in send by DC to SDLAC AP
    public function getAllProposalSendByDcToSdlacAp($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('status', 1);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count application id by case no by DC for SDLAC final verify
    public function countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('status', MB_FINAL_APPROVED_BY_DC)
            ->where_in('pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM])
            ->get('settlement_basic')
            ->num_rows();
    }
    // get all case under selected proposal in send by DC to SDLAC AP
    public function getAllAppInReportSendByDcToSdlacAp($proposal_no)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_cases');
        $this->db->where('proposal_id', $proposal_no);
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
        $data = $this->db->get()->row();

        return $data;
    }

    // update proposal list
    public function updateProposalListById($proId,$data)
    {
        $this->db->where('id', $proId);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_list',$data);
        return $this->db->affected_rows();
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

    // check data exist or not under proposal list by case no
    public function countSettlementAppDetailsByCaseNoUnderProposal($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('status', 1)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->row();
    }

    // update data exist or not under proposal list by case no
    public function updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$data)
    {
        $this->db->where('case_no', $caseNo);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_cases',$data);
        return $this->db->affected_rows();
    }



    // Count all Sdlac Status List KHAS
    public function countSdlacStatusList($dist_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('sdlac_prceed_status', SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            ->where('final_verify_status', 0)
            ->where('service_code', SETTLEMENT_AP_TRANSFER_ID)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    //**********************END AP **************************************










}