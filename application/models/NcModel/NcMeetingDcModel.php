<?php
class NcMeetingDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    // update proposal list
    public function updateProposalListById($proId,$data)
    {
        $this->db->where('id', $proId);
        $this->db->where('nc', 1);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_list',$data);
        return $this->db->affected_rows();
    }


    // update data exist or not under proposal list by case no
    public function updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$data)
    {
        $this->db->where('case_no', $caseNo);
        $this->db->where('nc', 1);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_cases',$data);
        return $this->db->affected_rows();
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

    // count  application id by case no
    public function countSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get  application id by case no
    public function getSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
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


    // get meeting details by meeting id
    public function getPendingMeetingDetailByMeetingID($meetingId)
    {
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where('nc', 1);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }


    // get all proposal by meeting id
    public function getProposalDetailAgainstMeetingId($dist_code, $meetingId)
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('nc', 1);
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    // get all proposal name by meeting id
    public function getProposalListAgainstMeetingId($meetingId,$dist_code)
    {
        $data = $this->db->select('id,proposal_name')
            ->where('proposal_meeting_id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('nc', 1)
            ->get('settlement_proposal_list')
            ->result();

        return $data;
    }

    // get all of SDLAC/CDLAC Member report
    public function sdlacMemberReportDetail($dist_code, $meetingId)
    {
        $this->db->select('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('nc', 1);
        $this->db->group_by('sdlac_member_code, emailid, nominee_id, status, meeting_attend_status');
        $data = $this->db->get('settlement_sdlac_member_report');
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

    //list of cases
    public function getCaseDetailsByProposalNos($propId)
    {
        $this->db->select();
        $this->db->where('proposal_id', $propId);
        $this->db->where('nc', 1);
        $data = $this->db->get('settlement_proposal_cases');
        return $data;
    }

    // get proposal Name
    public function getProposalNameByProposalNo($propId)
    {
        $this->db->select('proposal_name');
        $this->db->where('id', $propId);
        $this->db->where('nc', 1);
        $data = $this->db->get('settlement_proposal_list');
        return $data->row()->proposal_name;
    }



    // check meeting for generate minutes by meeting id
    public function checkMeetingForGenerateMinutes($meetingId,$dist_code)
    {
        $data = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 0)
            ->where('dc_approve_status', 0)
            ->where('nc', 1)
            ->get('proposal_meeting_list')
            ->num_rows();

        return $data;
    }

    // get meeting for generate minutes by meeting id
    public function getMeetingDetailsByMeetingId($meetingId,$dist_code)
    {
        $data = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 0)
            ->where('dc_approve_status', 0)
            ->where('nc', 1)
            ->get('proposal_meeting_list')
            ->row();

        return $data;
    }



    // check meeting for generate minutes by meeting id
    public function checkMeetingForGenerateMinutesResigning($meetingId,$dist_code)
    {
        $data = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 1)
            ->where('digital_sign_update_status', 1)
            ->where('dc_approve_status', 1)
            ->where('nc', 1)
            ->get('proposal_meeting_list')
            ->num_rows();

        return $data;
    }


    // get meeting for generate minutes by meeting id
    public function getMeetingForGenerateMinutesResigning($meetingId,$dist_code)
    {
        $data = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 1)
            ->where('digital_sign_update_status', 1)
            ->where('dc_approve_status', 1)
            ->where('nc', 1)
            ->get('proposal_meeting_list')
            ->row();

        return $data;
    }



    public function sdlacMemberReportDetailOnlyUserCode($dist_code, $meetingId)
    {
        $this->db->select('sdlac_member_code');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('nc', 1);
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
            ->where('nc', 1)
            ->get('settlement_sdlac_member_report')
            ->row();
    }

    // get proposal details by id
    public function getProposalDetailsById($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('nc', 1);
        $data = $this->db->get()->row();

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

    // count case under proposal with proposal id
    public function countCasesWithProposalId($proNo)
    {
        return $this->db->select()
            ->where('proposal_id', $proNo)
            ->where('nc', 1)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }


    // get meeting details
    public function getMeetingDetailByMeetingId($meetingId)
    {
        return $this->db->select()
            ->where('id', $meetingId)
            ->where('nc', 1)
            ->get('proposal_meeting_list')
            ->row();
    }


    // check data exist or not under proposal list deleted by case no
    public function countSettlementProposalListDeleted($proposal_no)
    {
        return $this->db->select()
            ->where('proposal_id', $proposal_no)
            ->where('nc', 1)
            ->get('settlement_proposal_list_deleted')
            ->num_rows();
    }


    // delete proposal from proposal list
    public function deleteSettlementProposalByProId($id,$dist_code)
    {
        $this->db->where('id', $id);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('nc', 1);
        $this->db->delete('settlement_proposal_list');
        return $this->db->trans_status();
    }


    // count revert case bu dept in SDLAC proposal
    public function countSettlementProposalPendingCaseByCaseNoForDeptRevert($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

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


    // get revert case bu dept in SDLAC proposa
    public function getSettlementProposalPendingCaseByCaseNoForDeptRevert($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT])
            ->get('settlement_proposal_cases')
            ->row();
    }


}