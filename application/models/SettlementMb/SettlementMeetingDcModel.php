<?php
class SettlementMeetingDcModel extends CI_Model
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
        $this->db->where('mb_status', 0);
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;    
    }

    // get all pending proposal list at SDO end
    public function getPendingProposalsOfSdo($dist_code, $subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('mb_status', 0);
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;    
    }


    // get all pending proposal list at DC end
    public function getPendingMeetingDetail($dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('mb_status', 0);
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
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


    public function getProposalDetailAgainstMeetingId($dist_code, $meetingId) 
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('mb_status', 0);
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    public function getProposalDetailAgainstMeetingIdReCla($dist_code, $meetingId)
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('mb_status', 0);
        $this->db->where('service_code', 40);
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
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }


    public function getPendingMeetingDetailByMeetingIDReCla($meetingId){
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where('mb_status', 0);
        $this->db->where('meeting_type_ins', '40');
        $this->db->where('nc', 0);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
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
        $this->db->where('mb_status', 0);
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get('settlement_proposal_list');
        return $data->row()->proposal_name;
    }

    public function getProposalNameByProposalNoReCla($propId){
        $this->db->select('proposal_name');
        $this->db->where('id', $propId);
        $this->db->where('mb_status', 0);
        $this->db->where('service_code',40);
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
        $this->db->where('mb_status', 0);
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get('settlement_proposal_list')->row();
        return $data;
    }


    // get proposal details by id
    public function getProposalDetailsByIdReCla($proId, $dist_code)
    {
        $this->db->select();
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 0);
        $this->db->where('service_code', 40);
        $data = $this->db->get('settlement_proposal_list')->row();
        return $data;
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


    // count
    public function checkServiceCodeFromMeetingToProposal($mId)
    {
        return  $this->db->select('service_code')
            ->where('proposal_meeting_id',$mId)
            ->where_not_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

}