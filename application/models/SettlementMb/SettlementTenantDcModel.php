<?php
class SettlementTenantDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }




    //*****************************************************************
    //********************** COMMON MODEL **************************************

    // update data exist or not under proposal list by case no
    public function updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$data)
    {
        $this->db->where('case_no', $caseNo);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_cases',$data);
        return $this->db->affected_rows();
    }

    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
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
            // ->where('general_notice_dc', 'y')
            ->where('status', MB_PENDING)
            ->where_in('pending_officer', array(MB_DEPUTY_COMM))
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
            // ->where('general_notice_dc', 'y')
            ->where('status', MB_PENDING)
            ->where_in('pending_officer', array(MB_DEPUTY_COMM))
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



    // get all beneficiary list
    public function getAllBeneficiaryListTenant($dist_code,$serviceCode)
    {
        $beneficiary = $this->db->select('case_no,payment_status')
            ->DISTINCT('case_no')
            ->where('dist_code',$dist_code)
            ->where('service_code',$serviceCode)
            ->where('bene_compensation_eligibility','YES')
            ->get('settlement_tenent_beneficiary');
        return $beneficiary;
    }

    // get all beneficiary list for download
    public function getAllBeneficiaryForDownload($dist_code,$serviceCode)
    {
        $beneficiary = $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('service_code',$serviceCode)
            ->where('bene_compensation_eligibility','YES')
            ->get('settlement_tenent_beneficiary');
        return $beneficiary;
    }


    // get all beneficiary individual by case no
    public function getAllBeneficiaryIndividualByCaseNo($case_no,$dist_code)
    {
        $beneficiary = $this->db->select()
            ->where('case_no',$case_no)
            ->where('dist_code',$dist_code)
            ->where('bene_compensation_eligibility','YES')
            ->get('settlement_tenent_beneficiary');
        return $beneficiary;
    }


    // count payment receive application id by case no for DC
    public function countBeneficiaryByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no',$caseNo)
            ->where('dist_code',$dist_code)
            ->where('bene_compensation_eligibility','YES')
            ->get('settlement_tenent_beneficiary')
            ->num_rows();
    }


    // update Beneficiary payment status
    public function updateBeneficiaryPaymentStatus($case_no,$dist_code,$updateData)
    {
        $this->db->where('case_no',$case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('bene_compensation_eligibility','YES');
        $this->db->update('settlement_tenent_beneficiary', $updateData);
        return $this->db->affected_rows();
    }



    //*****************************************************************
    //********************** END COMMON MODEL  **************************************








    //********************** TENANT MODEL **************************************

    // get all pending settlement  cases TENANT
    public function getAllPendingSettlementTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('(general_notice_dc != \'y\' or general_notice_dc is null)');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }
    // get all pending settlement  cases TENANT
    public function getAllNoticeGeneratedCases($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('(general_notice_dc = \'y\' or general_notice_dc is not null)');
        $this->db->where('(note_action_yn != \'y\' or note_action_yn is null)');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }
    // get all pending settlement  cases TENANT
    public function paymentNoticeCases($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('general_notice_dc', 'y');
        // $this->db->where('(note_action_yn is not null or note_action_yn != \'y\')');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where_in('status', array(MB_PENDING));
        $this->db->where_in('pending_officer', array(MB_DEPUTY_COMM));
        $data = $this->db->get();
        return $data;
    }

    // count  all pending settlement  cases TENANT
    public function countAllPendingSettlementTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->where('(general_notice_dc != \'y\' or general_notice_dc is null)')
            ->get('settlement_basic')
            ->num_rows();
    }


    // get all pending settlement  cases TENANT
    public function getMarkAsSDLACSettlementTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }




    // count all approve list TENANT
    public function countAllApproveAppBySdlacTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPARTMENT)
            ->where('status', MB_PENDING)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all approve list TENANT
    public function getAllApproveAppBySdlacTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('pending_officer', MB_DEPARTMENT);
        $this->db->where('status', MB_PENDING);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all rejected list by Dc TENANT
    public function countAllRejectAppByDcTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('status', MB_DISMISS)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // count all payment list by payment
    public function paymentConfirmNoticeCount($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_PAYMENT_NOTICE)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // count all payment received list by applicant
    public function paymentReceivedCount($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();

    }

    // get all rejected list TENANT
    public function getAllRejectAppByDcTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('from_office', MB_DEPUTY_COMM);
        $this->db->where('status', MB_DISMISS);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // Count all chitha update application TENANT
    public function countAllOrderChithaUpdateAppTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_PAYMENT_RECEIVED)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all chitha update application TENANT
    public function getAllOrderChithaUpdateAppTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    // count all Reverted By DEPARTMENT case for DC TENANT
    public function countRevertedByDeptApplicationTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_DEPARTMENT)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_REVERT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted By DEPARTMENT case for DC TENANT
    public function getRevertedByDeptApplicationTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('from_office', MB_DEPARTMENT);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_REVERT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }

    // count all Re-Reverted By CO case for DC TENANT
    public function countReRevertedByCoApplicationTenant($dist_code)
    {
        return $this->db->select()
            ->where('service_code', SETTLEMENT_TENANT_ID)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status', MB_RE_REPORT)
            ->where('dist_code', $dist_code)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Reverted By CO case for DC TENANT
    public function getReRevertedByCoApplicationTenant($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('from_office', MB_CIRCLE_OFFICER);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_RE_REPORT);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // count application id by case no for DC
    public function caseForDcApprovalTenant($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('status', MB_PENDING)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->get('settlement_basic')
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

    public function getLocationName($dist_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->group_by('subdiv_code, cir_code');
        $data = $this->db->get();
        return $data;
    }


    public function getPaymentConfirmationDc($service_code,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;

    }

    public function getPaymentReceivedApplicant($service_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        return $this->db->get()->result_array();
    }


    // get khatian details
    public function getKhatianDetailsByCaseNo($case_no)
    {
        return $this->db->select()
            ->where('case_no', $case_no)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant')
            ->row();
    }


    // count general file name duplicate
    public function checkDuplicateFileNameInGeneral($fileName)
    {
        return $this->db->select()
            ->where('notice_link', $fileName)
            ->get('settlement_notice')
            ->num_rows();
    }


    // get general notice
    public function getGeneralNoticeDetails($case)
    {
        return $this->db->select()
            ->where('case_no',$case)
            ->where('service_code',SETTLEMENT_TENANT_ID)
            ->where('notice_type','GN')
            ->get('settlement_notice')
            ->row();
    }

    public function lotCount($dist_code)
    {
        $this->db->select('COUNT(DISTINCT exl_id) as count');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('dc_process', 0);
        $query = $this->db->get('settlement_beneficiary_excel');
        return $query->row();
    }

    public function exlReportGenCount($dist_code)
    {
        $this->db->select('count(*)');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');
        $this->db->where('settlement_beneficiary_excel.id', NULL, TRUE);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
        $this->db->where_in('settlement_basic.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM));
        return $this->db->get()->row();
    }

    public function noticeGeneratedAdcHearingCasesCount($dist_code)
    {
        $this->db->select('count(*)');
        $this->db->from('settlement_basic');
        $this->db->where('general_notice_dc', 'y');
        $this->db->where('(note_action_yn is null or note_action_yn != \'y\')');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('status', MB_PENDING);
        $this->db->where_in('pending_officer', array(MB_DEPUTY_COMM));
        return $this->db->get()->row()->count;
        // echo $this->db->last_query();
    }
    public function generatePaymentNoticeCount($dist_code)
    {
        $this->db->select('count(*)');
        $this->db->from('settlement_basic');
        $this->db->where('general_notice_dc', 'y');
        // $this->db->where('(note_action_yn is not null or note_action_yn != \'y\')');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where_in('status', array(MB_PENDING));
        $this->db->where_in('pending_officer', array(MB_DEPUTY_COMM));
        return $this->db->get()->row()->count;
        // echo $this->db->last_query();
    }


    //**********************END TENANT **************************************










}