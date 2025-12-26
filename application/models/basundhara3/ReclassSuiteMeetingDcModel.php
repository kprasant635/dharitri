<?php
class ReclassSuiteMeetingDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // get all pending proposal list at ADC end
    public function getPendingProposals($dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('meeting_type_ins', '40');
        $data = $this->db->get();
        return $data;    
    }

    // get all pending proposal list at SDO end
    public function getPendingProposalsOfSdo($dist_code, $subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('meeting_type_ins', '40');
        $data = $this->db->get();
        return $data;    
    }


    // get all pending proposal list at DC end
    public function getPendingMeetingDetail($dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('meeting_type_ins', '40');
        $data = $this->db->get();
        return $data;    
    } 


    public function getLocationName($dist_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('reclass_suite_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->group_by('subdiv_code, cir_code');
        $data = $this->db->get();
        return $data;
    }


    public function getProposalDetailAgainstMeetingId($dist_code, $meetingId) 
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('service_code', RECLASS_ID);
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    public function sdlacMemberReportDetail($dist_code, $meetingId){
        $this->db->select('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->group_by('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $data = $this->db->get('settlement_sdlac_member_report');
        return $data;
    }


    // Meeting minutes
    public function sdlacMemberReportDetailWithMeetingIdUserCode($dist_code, $meetingId,$userCode)
    {
        return $this->db->select('nominee_id')
            ->where('dist_code', $dist_code)
            ->where('proposal_meeting_id', $meetingId)
            ->where('sdlac_member_code', trim($userCode))
            ->get('settlement_sdlac_member_report')
            ->row();
    }
    

    public function sdlacMemberReportDetailOnlyUserCode($dist_code, $meetingId){
        $this->db->select('sdlac_member_code');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $data = $this->db->get('settlement_sdlac_member_report');
        return $data;
    }


    public function getPendingMeetingDetailByMeetingID($meetingId){
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where('meeting_type_ins', '40');
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }




    // get meeting details
    public function getMeetingDetailByMeetingId($meetingId)
    {
        return $this->db->select()
            ->where('id', $meetingId)
            ->where('mb_status', 0)
            ->where('meeting_type_ins', '40')
            ->get('proposal_meeting_list')
            ->row();
    }

    public function getCaseDetailsByProposalNos($propId){
        $this->db->select();
        $this->db->where('proposal_id', $propId);
        $data = $this->db->get('settlement_proposal_cases');
        return $data;
    }


    public function getProposalNameByProposalNo($propId){
        $this->db->select('proposal_name');
        $this->db->where('id', $propId);
        $this->db->where('service_code', RECLASS_ID);
        $data = $this->db->get('settlement_proposal_list');
        return $data->row()->proposal_name;
    }


    // get proposal details by id
    public function getProposalDetailsById($proId, $dist_code)
    {
        $this->db->select();
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('service_code', RECLASS_ID);
        $data = $this->db->get('settlement_proposal_list')->row();
        return $data;
    }


    // delete proposal from proposal list
    public function deleteSettlementProposalByProId($id,$dist_code)
    {
        $this->db->where('id', $id);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', RECLASS_ID);
        $this->db->delete('settlement_proposal_list');
        return $this->db->trans_status();
    }


    // get proposal details  by proposal Id
    public function getProposalDetailsByProId($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('mb_status', 0)
            ->where('service_code',RECLASS_ID)
            ->get('settlement_proposal_list')
            ->row();
    }



    // count Dsc registration with dist code
    public function countDscRegistrationWithDistCode($distCode)
    {
        return $this->db->select()
            ->where('dist_code',$distCode)
            ->where('status','ACTIVE')
            ->get('dsc_registration_details')
            ->num_rows();
    }


    // get all case under reverted proposal by DC
    public function getAllCaseInProposalUnderRevertedMeeting($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        reclass_suite_basic.dist_code,reclass_suite_basic.subdiv_code,reclass_suite_basic.cir_code,reclass_suite_basic.service_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('reclass_suite_basic','reclass_suite_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }


    // get proposal details by id
    public function getRevertedProposalDetailsByIdAdc($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 0);
        $this->db->where('service_code',RECLASS_ID);
        $data = $this->db->get()->row();

        return $data;
    }


    // check data exist or not under proposal list by case no
    public function countSettlementProposalList($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('mb_status', 0)
            ->where('service_code',RECLASS_ID)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // count  application id by case no
    public function countSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('reclass_suite_basic')
            ->num_rows();
    }


    // get  application id by case no
    public function getSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('reclass_suite_basic')
            ->row();

    }




}