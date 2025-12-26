<?php
class NcCommonSdoModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    // NC code by Masud Reza (19/02/2024)

    //////////////// *************** **************** ////////////////



    // SDO count all pending NC cases
    public function countAllPendingNcCasesSdo($dist_code,$suv_div,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_PENDING)
            ->get('settlement_basic')
            ->num_rows();
    }

    // SDO get application id by case no
    public function getNcApplicationDetailsByCaseNoSdo($caseNo,$dist_code,$suv_div,$serviceCode)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->row();
    }


    // count application id by case no for SDO
    public function countNcApplicationDetailsByCaseNo($caseNo,$dist_code,$suv_div,$serviceCode)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all Mark list for SDLAC KHAS
    public function countMarkAsSDLACNcKhas($serviceCode,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_MARK_AS_SDLAC)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all under consideration  cases KHAS
    public function countAllUnderConsiderationAppKhas($serviceCode,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('status', MB_UNDER_CONSIDERATION)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending settlement cases KHAS
    public function getMarkAsSDLACNcKhas($serviceCode,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $serviceCode);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_MARK_AS_SDLAC);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }




    // get all under consideration cases KHAS
    public function getAllUnderConSettlementSdo($serviceCode,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $serviceCode);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->where('status', MB_UNDER_CONSIDERATION);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $data = $this->db->get();
        return $data;
    }


    // count all proposal list in send by SDO to SDLAC KHAS
    public function countAllProposalSendByDcToSdlacSdo($serviceCode,$dist_code,$suv_div)
    {
        return $this->db->select()
            ->where('service_code', $serviceCode)
            ->where_in('sdlac_prceed_status', [0,1])
            ->where('final_verify_status', 0)
            ->where('status', 1)
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $suv_div)
            ->where('created_by', MB_SUB_DIV_COMM)
            ->get('settlement_proposal_list')
            ->num_rows();

    }


    // get all proposal list in send by SDO to SDLAC KHAS
    public function getAllProposalSendByDcToSdlacKhasSdo($serviceCode,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('service_code', $serviceCode);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where_in('sdlac_prceed_status', [0,1]);
        $this->db->where('final_verify_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;

    }

    // get all case under selected proposal in send by SDO to SDLAC KHAS
    public function getAllAppInReportSendByDcToSdlacKhasSdo($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $this->db->where('settlement_proposal_cases.nc', 1);
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
        $this->db->where('nc', 1);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $data = $this->db->get()->row();

        return $data;
    }


    public function getCasesAgainstProposalIdSdo($proposal_id,$dist_code,$service_code,$uCode,$subdiv_code)
    {
        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
        settlement_proposal_cases A JOIN settlement_proposal_list B ON
        B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=? AND B.service_code=?
        AND B.created_by=? AND B.subdiv_code=?",
            array($proposal_id, $dist_code, $service_code, $uCode, $subdiv_code));

        return $result;
    }

    // check case mapped or SDLAC/CDLAC Member
    public function getCheckForSdlacMemberStatus($dist_code, $proposal_id, $subdiv_code, $uCode)
    {
        $data = $this->db->query("SELECT * FROM settlement_proposal_list
                                    WHERE sdlac_prceed_status ".PROPOSAL_SEND_TO_SDLAC." 
                                    AND dist_code = ? AND id = ? AND subdiv_code = ? 
                                    AND created_by = ? ",
            array($dist_code, $proposal_id, $subdiv_code, $uCode));

        return $data;
    }


    // get all Forwarded meeting list at SDO end
    public function getForwardedMeetingListSdo($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('nc', 1);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }

    public function getForwardedMeetingDetailByMeetingID($meetingId,$dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('nc', 1);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }

    public function getProposalDetailAgainstMeetingIdForSdo($meetingId,$dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('nc', 1);
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    // get all additional document
    public function getMeetingAdditionalDocumentDetail($meetingName)
    {
        $this->db->select();
        $this->db->where('case_no', $meetingName);
        $data = $this->db->get('supportive_document');
        return $data;
    }

    public function sdlacMemberReportDetail($dist_code, $meetingId){
        $this->db->select('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('nc', 1);
        $this->db->group_by('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $data = $this->db->get('settlement_sdlac_member_report');
        return $data;
    }




}