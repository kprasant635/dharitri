<?php



class RelassSuiteMeetingControllerDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basundhara/SettlementApiModel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        // $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementMeetingDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('ProgressModel');
        $this->load->model('basundhara/basundhara3Model');
        $this->load->model('basundhara3/ReclassSuiteMeetingDcModel');
        $this->load->model('basundhara3/ReclassCommonDcModel');
        $this->load->model('basundhara3/reclassModel');
        $this->load->model('basundhara3/reclassPullModel');
        $this->load->model('basundhara3/reclassSuiteADCModel');


        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        if($user_desig_code != MB_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }


    }

    public function dbswitch()
    {
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // meeting view page
    public function meetingLandPage()
    {
        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->ReclassSuiteMeetingDcModel->getLocationName($dist_code);
        $location          = $getDistrict->result();
        $circleList        = array();

        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $checkDsc = $this->SettlementMeetingDcModel->countDscRegistrationWithDistCode($dist_code);

        $data['location'] = $circleList;
        $data['checkDsc'] = $checkDsc;

        $data['_view'] = 'reclass_suite/Dc/pending_meeting_list_for_approval_reclass';
        $this->load->view('layouts/main', $data);
    }


    // list of common proposals for all services
    public function listOfPendingMeetingIds()
    {

        $cir_code    = $this->input->post('circle');
        $subdiv_code = $this->input->post('subdiv');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $service     = $this->input->post('service_code');
        $by_case_no  = $this->input->post('case_no');
        $proposal_no = $this->input->post('proposal_no');
        $dist_code   = $this->session->userdata('dist_code');

        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'desc';
        }
        $valid_columns = array(
            0   => 'proposal_meeting_list.meeting_date',
        );
        if(!isset($valid_columns[$col])){
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }



        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_status', 0);
        $this->db->where('proposal_meeting_list.dc_approve_status', 0);
        $this->db->where('proposal_meeting_list.meeting_type_ins', '40');
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
        $this->db->limit($length, $start);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query = $this->db->get('proposal_meeting_list');

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            $this->db->select('*');
            $this->db->where('proposal_meeting_list.dist_code', $dist_code);
            $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
            $this->db->where('proposal_meeting_list.digital_sign_status', 0);
            $this->db->where('proposal_meeting_list.dc_approve_status', 0);
            $this->db->where('proposal_meeting_list.meeting_type_ins', '40');
            $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
            $this->db->order_by('proposal_meeting_list.id', 'asc');
            $query1 = $this->db->get('proposal_meeting_list');

            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                if($rows->vgr_pgr_revert_status == 1)
                {
                    $digitalMinutes    = '<b style="color: #FF5252;">Some cases are Reverted back from this Meeting.</b>'.'<br>';
                    $revertBackMeeting = '';
                    $uploadedMinutes   = '';
                    $attendance        = '';
                }
                else
                {
                    if($rows->digital_sign_status == 0)
                    {

//                        $digitalMinutes    = '';
                        $digitalMinutes    = '<a class="rezaButt btn btn-sm btn-danger showMinutesGenerateModal" data-id='.$rows->id.' style="color: #FFF;">Generate Digital Minutes</a>';
                        $revertBackMeeting = '<a class="rezaButt btn btn-sm  revertBackMeetingModal" data-id='.$rows->id.' style="background-color :#9C27B0; color: #FFF">Revert Back Meeting</a>';
                    }
                    else
                    {
                        $digitalMinutes = '<a class="rezaButt btn btn-sm " style="color: #FFF; background-color: #9C27B0;" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/getPendingProposalsAgainstMeetingId/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Digital Minutes</a>';
                    }
                    if($rows->file_minute_path == '' && $rows->file_minute_path == NULL)
                    {
                        $uploadedMinutes ='';
                    }
                    else
                    {
                        $uploadedMinutes ='<a class="rezaButt btn btn-sm" style="background-color :#03A9F4" target="SdlacMinutes" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/viewSdlacUploadedMinute/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Uploaded Minutes</a>';
                    }

                    $gurdSignedUploadCopy = '';

                    $attendance = '<a class="rezaButt btn btn-sm " style="background-color :#3F51B5" target="SdlacAttendance" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/viewSdlacAttendance/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Attendance</a>';
                }

                $viewMeeting ='<a class="rezaButt btn btn-sm " style="background-color :#4CAF50" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/getPendingProposalsAgainstMeetingId/?meetingId='.$rows->id.'"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View Detail</a>';

                $json[] = array(

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->meeting_name .'</b>',

                    $rows->meeting_venue .'<br><span style="color:red">'. date('d-M-Y',strtotime($rows->meeting_date)).'</span>',

                    $rows->created_by,


                    $digitalMinutes.
                    $revertBackMeeting.
                    $attendance.
                    $viewMeeting.
                    $uploadedMinutes.
                    $gurdSignedUploadCopy
                );
                $i++;
            }
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    // all approved meeting list
    public function meetingApprovedLandPage()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_update_status', 0);
        $this->db->where('proposal_meeting_list.dc_approve_status', 1);
        $this->db->where('proposal_meeting_list.meeting_type_ins', '40');
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();


        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'reclass_suite/Dc/approve_meeting_list_for_approval';
        $this->load->view('layouts/main', $data);
    }


    // all approved meeting list
    public function meetingApprovedDptLandPage()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.dept_approval', 'Y');
        $this->db->where('proposal_meeting_list.pending_at', 'DC');
        $this->db->where('proposal_meeting_list.digital_sign_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_update_status', 0);
        $this->db->where('proposal_meeting_list.dc_approve_status', 1);
        $this->db->where('proposal_meeting_list.meeting_type_ins','40');
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();


        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'reclass_suite/Dc/approve_meeting_list_for_dpt';
        $this->load->view('layouts/main', $data);
    }


    // get all pending  proposal under selected meeting
    public function getPendingProposalsAgainstMeetingId()
    {

        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting = $this->SettlementMeetingDcModel->getPendingMeetingDetailByMeetingIDReCla(
            $meetingId)->row();


        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingLandPage");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->SettlementMeetingDcModel->getProposalDetailAgainstMeetingIdReCla($dist_code,
            $meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->ReclassSuiteMeetingDcModel->sdlacMemberReportDetail($dist_code,
            $meetingId)->result();

        $additionalDoc = $this->SettlementCommonDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'reclass_suite/Dc/pending_proposals_against_meeting_id';
        $this->load->view('layouts/main', $data);
    }


    // get all  approved proposal under selected meeting
    public function getApprovedProposalsAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting = $this->SettlementMeetingDcModel->getPendingMeetingDetailByMeetingIDReCla(
            $meetingId)->row();
        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingApprovedLandPage");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->SettlementMeetingDcModel->getProposalDetailAgainstMeetingIdReCla($dist_code,
            $meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->ReclassSuiteMeetingDcModel->sdlacMemberReportDetail($dist_code,
            $meetingId)->result();

        $additionalDoc = $this->SettlementCommonDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'reclass_suite/Dc/approved_proposals_against_meeting_id';

        $this->load->view('layouts/main', $data);
    }


    public function getMeetingIdForwardtoCO()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');
        $this->db->trans_begin();

        $meeting = $this->ReclassSuiteMeetingDcModel->getPendingMeetingDetailByMeetingID(
            $meetingId)->row();
        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingApprovedLandPage");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,
            $meetingId)->result();

        //list of SDLAC/CDLAC Member report
        // $sdlacReport = $this->SettlementMeetingDcModel->sdlacMemberReportDetail($dist_code,$meetingId)->result();

        foreach($proposalDetail as $propdet)
        {
            $propcases= $this->db->query('select * from settlement_proposal_cases where proposal_id =?',array($propdet->proposal_id));
            $prop = $propcases->result();

            foreach($prop as $cases)
            {
                $recbasic=[
                    'date_update' => date('Y-m-d H:i:s'),
                    'status' => 'M',
                    'from_office' =>'DC',
                    'pending_officer' => 'CO',
                    'pending_office' =>'CO'
                ];

                $this->db->where('case_no',$cases->case_no);
                $this->db->update('reclass_suite_basic',$recbasic);

                if($this->db->affected_rows() !=1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR0002132: Updation failed in reclass_basic '
                        .$this->db->last_query());
                    return;
                }

                $sql = "select MAX(proceeding_id)+1 as id from settlement_proceeding where
                            case_no=? ";
                $proceeding_id = $this->db->query($sql, array($cases->case_no))->row()->id;
                $proceeding_array = array(
                    'case_no'              =>$cases->case_no,
                    'proceeding_id'        => $proceeding_id,
                    'status'               => 'M',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d G:i:s'),
                    'operation'            => 'E',
                    'note_on_order'        => 'Sent for payment notice by DC',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => $this->session->userdata('user_desig_code'),
                    'office_to'            => '',
                    'task'                 => 'Sent for payment notice by DC',
                );

                $insertProceeSql = $this->db->insert('settlement_proceeding', $proceeding_array);

                if($insertProceeSql != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR0001433: Insertion failed in settlement_proceeding '.
                        $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0001433: Unable to process for final approval. 
                      Few cases under this meeting has already been approved !!',
                    ));
                    return;
                }
                else
                {
                    // ////////////// POST Reject status To basundhara ////////////////////
                    $application_no = $this->reclassSuiteADCModel->getSettlementBasicCo($cases->case_no)->applid;
                    $rmk    = 'Sent for payment notice by DC';
                    $status = 'M';
                    $task   = 'DC';
                    $pen    = 'CO';
                    $case_no     = $cases->case_no;
                    $rtps_status = 'y';
                    $this->SettlementApiModel->postApiBasundharaForRejectedCase3rd($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);

                    if (trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR0001555: Issue in API Call'
                            .$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 3,
                            'message'      => '#MR0001555: Unable to process for final approval.
                                  Kindly contact system administration !!!',
                        ));
                        return;
                    }
                }
            }
        }

        $updateProposalMeeting = [
            'pending_at' => 'CO'
        ];

        $this->db->where('id',$meetingId);
        $this->db->update('proposal_meeting_list',$updateProposalMeeting);

        if($this->db->affected_rows() !=1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MR0002132: Updation failed in reclass_basic '
                .$this->db->last_query());
            return;
        }

        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Forwared to CO for Payment Notice !");
            redirect(base_url() . "index.php/Home/index");
        }


    }


    //view case nos against a proposal no
    public function viewCasesAgainstProposalNo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalNo = $this->input->post('propId');

        //list of cases
        $cases = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($proposalNo);

        if($cases->num_rows() == 0 || $cases->num_rows() == ''){
            $json = [
                'response' => 1,
                'message'  => '#MR0000413: No cases found.',
            ];
            echo json_encode($json);
            return;
        }
        $json = [
            'response'      => 2,
            'tableCases'    => $cases->result(),
            'proposal_name' => $this->SettlementMeetingDcModel->getProposalNameByProposalNoReCla($proposalNo),
        ];
        echo json_encode($json);
        return;
    }


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags                 = $this->SettlementApModel->getSettlementDag($application_no);
        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck            = 0;
        $appliedDags          = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic                = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        $newDag = '';



        if($basic->service_code == SETTLEMENT_AP_TRANSFER_ID)
        {
            $newDag = $appliedDags[0]->new_dag_no;
            if($newDag != '')
            {
                foreach ($dags as $dag)
                {
                    $totalReservedAreaInApplication = 0;
                    $totalAppliedAreaInApplication  = 0;
                    $totalAreaInApplicationNR       = 0;

                    $appDistrict = $dag->dist_code;
                    $appSubDiv = $dag->subdiv_code;
                    $appCircle = $dag->cir_code;
                    $appMouza = $dag->mouza_pargona_code;
                    $appLot = $dag->lot_no;
                    $appVillage = $dag->vill_townprt_code;
                    $appDag = $dag->dag_no;

                    // chitha details for new Dag
                    $chithaDag = $this->SettlementCommonDcModel->getNewChithaDagAreaDetails(
                        $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $newDag);

                    $reservation = $this->SettlementCommonDcModel->getSettlementReservationCommon($application_no);

                    if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
                    {
                        // chitha
                        $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                        $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                        $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                        $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                        $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if ($appDag == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                                $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;

                                $bighaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_bigha, 0);
                                $kathaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_katha, 0);
                                $lessaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_lessa, 0);
                                $gandaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_ganda, 0);
                                $appAreaInApplication3 = ($bighaAppArea3 * 6400) + ($kathaAppArea3 * 320) + ($lessaAppArea3 * 20) + $gandaAppArea3;

                                $totalAreaInApplicationNR += $appAreaInApplication3;
                            }
                        }

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $gandaReservedApp = $this->UtilsModel->defaultValue($singleApp->ganda, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 6400) + ($kathaReservedApp * 320) + ($lessaReservedApp * 20) + $gandaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha == 0)
                        {
                            $areaCheck = 1;
                        }
                        if(($totalAppliedAreaInApplication - $totalReservedAreaInApplication) == 0)
                        {
                            $areaCheck = 1;
                        }
                        if ($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
                        {
                            $areaCheck = 1;
                        }
                        if($totalAppliedAreaInApplication > $totalAreaInApplicationNR)
                        {
                            $areaCheck = 1;
                        }
                    }
                    else
                    {
                        // chitha
                        $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                        $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                        $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                        $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if ($appDag == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;

                                $bighaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_bigha, 0);
                                $kathaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_katha, 0);
                                $lessaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_lessa, 0);
                                $appAreaInApplication3 = ($bighaAppArea3 * 100) + ($kathaAppArea3 * 20) + $lessaAppArea3;

                                $totalAreaInApplicationNR += $appAreaInApplication3;
                            }
                        }

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 100) + ($kathaReservedApp * 20) + $lessaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha == 0)
                        {
                            $areaCheck = 1;
                        }
                        if(($totalAppliedAreaInApplication - $totalReservedAreaInApplication) == 0)
                        {
                            $areaCheck = 1;
                        }
                        if ($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
                        {
                            $areaCheck = 1;
                        }
                        if($totalAppliedAreaInApplication > $totalAreaInApplicationNR)
                        {
                            $areaCheck = 1;
                        }
                    }
                }
            }
            else
            {
                $areaCheck = 1;
            }
        }
        else
        {
            foreach ($dags as $dag)
            {
                $totalAreaInApplication = 0;
                $totalAreaInLMApplication = 0;
                $totalAppliedAreaInApplication = 0;

                $appDistrict  = $dag->dist_code;
                $appSubDiv    = $dag->subdiv_code;
                $appCircle    = $dag->cir_code;
                $appMouza     = $dag->mouza_pargona_code;
                $appLot       = $dag->lot_no;
                $appVillage   = $dag->vill_townprt_code;
                $appDag       = $dag->dag_no;
                $appPattaType = $dag->patta_type_code;
                $appPatta     = $dag->patta_no;

                $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                    $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

                $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                    $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

                $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                    $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);

                if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
                {
                    // chitha
                    $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                    $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                    $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                    $gandaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                    $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                    // SOD/ADC processing application
                    foreach ($allApplicationDags as $singleApp)
                    {
                        $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $gandaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                        $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                        $totalAreaInApplication += $areaInApplication;
                    }

                    // LM processing application
                    foreach ($allLmProcess as $singleLMApp)
                    {
                        $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                        $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                        $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                        $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                        $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                        $totalAreaInLMApplication += $areaInLMApplication;
                    }


                    if($basic->dc_proceeding == 0)
                    {
                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if($chithaDag->dag_no == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                                $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;
                            }
                        }
                    }

                    if($totalAreaInChitha == 0)
                    {
                        $areaCheck = 1;
                    }
                    if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                    {
                        $areaCheck = 1;
                    }
                    if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                    {
                        $areaCheck = 1;
                    }
                }
                else
                {
                    // chitha
                    $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                    $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                    $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                    $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                    //SOD/ADC processing application
                    foreach ($allApplicationDags as $singleApp)
                    {
                        $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                        $totalAreaInApplication += $areaInApplication;
                    }

                    // LM processing application
                    foreach ($allLmProcess as $singleLMApp)
                    {
                        $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                        $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                        $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                        $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                        $totalAreaInLMApplication += $areaInLMApplication;
                    }

                    if($basic->dc_proceeding == 0)
                    {
                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if($chithaDag->dag_no == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;
                            }
                        }
                    }

                    if($totalAreaInChitha == 0)
                    {
                        $areaCheck = 1;
                    }
                    if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                    {
                        $areaCheck = 1;
                    }
                    if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                    {
                        $areaCheck = 1;
                    }
                }
            }
        }

        return $areaCheck;
    }


    //get service abbreviation name by service code
    public function serviceAbbreviation($scode)
    {
        if($scode == SETTLEMENT_TENANT_ID) {
            $service_abbreviation = SETTLEMENT_TENANT;
        }
        if($scode == SETTLEMENT_AP_TRANSFER_ID) {
            $service_abbreviation = SETTLEMENT_AP_TRANSFER;
        }
        if($scode == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
            $service_abbreviation = SETTLEMENT_TRIBAL_COMMUNITY;
        }
        if($scode == SETTLEMENT_KHAS_LAND_ID) {
            $service_abbreviation = SETTLEMENT_KHAS_LAND;
        }
        if($scode == SETTLEMENT_PGR_VGR_LAND_ID) {
            $service_abbreviation = SETTLEMENT_PGR_VGR_LAND;
        }
        if($scode == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
            $service_abbreviation = SETTLEMENT_SPECIAL_CULTIVATORS;
        }
        return $service_abbreviation;
    }


    // decode for showing file
    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }


    // view SDLAC Attendance
    public function viewSdlacAttendance()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->ReclassSuiteMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->file_attendance_path == '')
        {
            die("Unable to open file !");
        }
        else
        {

            if(!file_exists($meetingDetails->file_attendance_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_attendance_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_attendance_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_34."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }
            }
            else
            {
                $path = $meetingDetails->file_attendance_path;
            }


            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // view SDLAC Uploaded Minute
    public function viewSdlacUploadedMinute()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->ReclassSuiteMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->file_minute_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->file_minute_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_minute_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_minute_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }
            }
            else
            {
                $path = $meetingDetails->file_minute_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // view Digital Minutes
    public function getDigitalMinutesWithMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->SettlementMeetingDcModel->getPendingMeetingDetailByMeetingIDReCla($meetingId)->row();

        if($meetingDetails->encode_pdf_dir_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->encode_pdf_dir_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->encode_pdf_dir_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->encode_pdf_dir_path;
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_34."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }

            }
            else
            {
                $path = $meetingDetails->encode_pdf_dir_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // generate digital minutes
    public function generateDigitalMinutesDc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingId');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $proposals = $this->db->select('id,proposal_name')
                    ->where('proposal_meeting_id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('service_code', RECLASS_ID)
                    ->get('settlement_proposal_list')
                    ->result();

                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 0)
                    ->where('dc_approve_status', 0)
                    ->where('meeting_type_ins', '40')
                    ->get('proposal_meeting_list')
                    ->row();


//                if($meetingDetails->signed_minute != 1)
//                {
//                    echo json_encode(array(
//                        'responseType' => 1,
//                        'message'  => '#MREZA001:  Kindly upload the minutes of the meeting signed by the Guardian Minister',
//
//                    ));
//                    return false;
//                }

                if(DC_DIGITAL_SIGN_MINUTES_BUTTON_VGR == 0)
                {
                    if($meetingDetails->vgr_pgr_status == 1)
                    {
                        $json = [
                            'responseType' => 1,
                            'message'      => '#MRVGR002509: --- Coming Soon ---',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }


                $createdBy    = $meetingDetails->user_code;
                $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName  = substr($districtName->locname_eng, 0, 3);
                $memoName     = $distEngName.'/MEMO/'.date("Y").'/'.$meetingId;

                $allProposalCases = $this->generateProposalCases($proposals,$meetingId);
                $caseList   = $allProposalCases['final_result_array_rec'];
                $caseDivNot = $allProposalCases['final_result_array_not_rec'];

                $subDivArray = [];
                if (!empty($caseList) && is_array($caseList))
                {
                    foreach ($caseList as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }
                else
                {
                    foreach ($caseDivNot as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }

                $uniqueArraySub = array_unique($subDivArray);

                $subdivNameArray = [];
                foreach ($uniqueArraySub as $singleSub)
                {
                    $subdivNameOnly    = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$singleSub);
                    $subdivNameArray[] = $subdivNameOnly->locname_eng;
                }


                $subdiv_name = '';
                $indexN = 0;
                $ii = count($subdivNameArray);
                foreach ($subdivNameArray as $div)
                {
                    $indexN++;
                    if ($indexN == $ii)
                    {
                        $subdiv_name = $subdiv_name.trim($div);
                    }
                    else
                    {
                        $subdiv_name = $subdiv_name.trim($div). ", ";
                    }
                }


                $sdlacReport = $this->SettlementMeetingDcModel->sdlacMemberReportDetailOnlyUserCode($dist_code,
                    $meetingId)->result();

                $allSelectedMember = [];
                $commMembers = [];
                foreach ($sdlacReport as $member)
                {
                    $allSelectedMember[] = $member->sdlac_member_code;
                }

                $allMembers = $this->SettlementCommonDcModel->getMembersFromUsers($this->session->userdata('dist_code'));


                foreach ($allMembers as $mem)
                {
                    if(in_array($mem->user_code,$allSelectedMember))
                    {
                        $nominee = $this->SettlementMeetingDcModel->sdlacMemberReportDetailWithMeetingIdUserCode
                        ($dist_code,$meetingId,$mem->user_code);
                        if($nominee->nominee_id != 0)
                        {
                            $nn = $this->SettlementCommonDcModel->getNomineeName($nominee->nominee_id);
                            if($mem->display_name == '')
                            {
                                $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->name . ', ' . $mem->designation;
                            }
                            else
                            {
                                $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->display_name;
                            }
                        }
                        else
                        {
                            if($mem->display_name != '')
                            {
                                $commMembers[] = $mem->display_name;
                            }
                            else
                            {
                                $commMembers[] = $mem->name .$mem->designation;
                            }
                        }
                    }
                }

                $subDivCode = $meetingDetails->subdiv_code;

                $createdUserCode = $meetingDetails->user_code;
                $user_desig_code = $meetingDetails->created_by;

                $userDlc      = $this->SettlementCommonDcModel->getUsersDLCCopyTo($dist_code, $user_desig_code,$createdUserCode);
                $userDlcCount = $userDlc->num_rows();
                $userDlcList  = $userDlc->result();

                if($userDlcCount == 0)
                {
                    $json = [
                        'responseType' => 1,
                        'message'      => 'Minutes Copy to Members are incomplete ! Kindly Contact '. $meetingDetails->created_by. ' to Add Members For Minutes Copy To For DLC',
                    ];
                    echo json_encode($json);
                    return false;
                }
                else
                {

                    $reservationDetails = '';

                    echo json_encode(array(
                        'responseType' => 2,
                        'meetingId' => $meetingId,
                        'meetingName' => $meetingDetails->meeting_name,
                        'memoName' => $memoName,
                        'districtName' => $districtName->locname_eng,
                        'subDivName' => $subdiv_name,
                        'meetingDate' => date("F j, Y", strtotime($meetingDetails->meeting_date)),
                        'timing' => strtoupper(date("h:i a", strtotime($meetingDetails->meeting_date))),
                        'meetingVenue' => $meetingDetails->meeting_venue,
                        'nominee' => $commMembers,
                        'caseList' => $caseList,
                        'caseDivNot' => $caseDivNot,
                        'proposalDetails' => $proposals,
                        'userDlcList' => $userDlcList,
                        'userDlcCount' => $userDlcCount,
                        'reservationDetails' => $reservationDetails
                    ));

                    return false;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR000801: Meeting not found ! Kindly contact system administrator',

                ));
                return false;
            }
        }
    }


    // get vgr/pgr reservation details for minutes
    public function getReservationDetailsVGRPGR($cluster_id,$status)
    {
        $dist_code  = $this->session->userdata('dist_code');
        $cluster_id = trim($cluster_id);
        $status     = trim($status);

        //*****getting the circle location */
        $circleLocationSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ? and dist_code = ?', array($cluster_id,$dist_code));

        if($circleLocationSql->num_rows() <= 0)
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRVD001074: Cluster not found ! Kindly contact system administrator '
            );
            return $reservations;
        }

        $cirLoc          = $circleLocationSql->row();
        $cir_dist_code   = $cirLoc->dist_code;
        $cir_subdiv_code = $cirLoc->subdiv_code;
        $cir_cir_code    = $cirLoc->cir_code;

        //check if all cases selected to be approved by either department(urban) or dc(rural)
        $clustSql = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

        if($clustSql->num_rows() <= 0)
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRVD001089: Cases not found in Cluster! Kindly contact system administrator '
            );
            return $reservations;
        }

        $cluster_cases = $clustSql->result();
        $allSelectedList = array();

        foreach($cluster_cases as $ccs)
        {
            $clu_case = trim($ccs->case_no);
            $sqlBasicCheck = $this->SettlementVgrModel->getSettlementBasic($clu_case);

            if($sqlBasicCheck['status'] != trim($status))
            {
                $reservations = array(
                    'responseType' => 0,
                    'message'      => '#MRCLRVD001106: Some cases of this cluster is still pending ! Kindly contact system administrator '
                );
                return $reservations;
            }
            $allSelectedList[] = $clu_case;
        }

        if(!empty($allSelectedList))
        {
            $reservationDetails = array();

            foreach ($allSelectedList as $row)
            {
                $case_no = trim($row);
                $rSql    = $this->db->query('select r.case_no, r.dist_code,r.subdiv_code,r.cir_code,r.mouza_pargona_code,r.lot_no,r.vill_townprt_code,r.dag_no from settlement_vgr_pgr_reservation r where r.case_no = ?', array($case_no));

                if($rSql->num_rows() <= 0)
                {
                    $reservations = array(
                        'responseType' => 0,
                        'message'      => '#MRCLRVD001126: Something went wrong ! Kindly contact system administrator '
                    );
                    return $reservations;
                }

                $dSql = $this->db->query('select SUM(d.s_dag_area_b*100 + d.s_dag_area_k*20 + d.s_dag_area_lc) AS total_lessa, 
                    SUM(d.s_dag_area_b*6400 + d.s_dag_area_k*320 + d.s_dag_area_lc*20 + d.s_dag_area_g) AS total_ganda from settlement_dag_details d where d.case_no = ? GROUP BY d.case_no', array($case_no));

                if($dSql->num_rows() <= 0)
                {
                    $reservations = array(
                        'responseType' => 0,
                        'message'      => '#MRCLRVD001138: Something went wrong ! Kindly contact system administrator '
                    );
                    return $reservations;
                }

                $reservation = $rSql->row();
                $dArea = $dSql->row();

                $isBarakValley = 0;

                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                {
                    $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa2($dArea->total_ganda);
                    $isBarakValley = 1;
                }
                else
                {
                    $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa($dArea->total_lessa);
                }

                $basic = $this->SettlementVgrModel->getSettlementBasic($case_no);

                $reservationDetails[] = (object)
                [
                    'case_no'     => $reservation->case_no,
                    'dist_code'   => $basic['dist_code'],
                    'subdiv_code' => $basic['subdiv_code'],
                    'cir_code'    => $basic['cir_code'],
                    'lot_no'      => $basic['lot_no'],
                    'mouza_pargona_code'   => $basic['mouza_pargona_code'],
                    'village_townprt_code' => $basic['vill_townprt_code'],
                    'dist_name'    => $this->utilityclass->getDistrictName($basic['dist_code']),
                    'subdiv_name'  => $this->utilityclass->getSubDivName($basic['dist_code'], $basic['subdiv_code']),
                    'cir_name'     => $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']),
                    'mouza_name'   => $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']),
                    'lot_name'     => $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']),
                    'village_name' => $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']),
                    'reservation_dist_code'   => $reservation->dist_code,
                    'reservation_subdiv_code' => $reservation->subdiv_code,
                    'reservation_cir_code'    => $reservation->cir_code,
                    'reservation_mouza_pargona_code' => $reservation->mouza_pargona_code,
                    'reservation_lot_no' => $reservation->lot_no,
                    'reservation_vill_townprt_code' => $reservation->vill_townprt_code,
                    'reservation_dag_no' => $reservation->dag_no,
                    'reservation_bigha' => $bklg[0],
                    'reservation_katha' => $bklg[1],
                    'reservation_lessa' => $bklg[2],
                    'reservation_ganda' => $bklg[3],
                    'reservation_dist_name'    => $this->utilityclass->getDistrictName($reservation->dist_code),
                    'reservation_subdiv_name'  => $this->utilityclass->getSubDivName($reservation->dist_code, $reservation->subdiv_code),
                    'reservation_cir_name'     => $this->utilityclass->getCircleName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code),
                    'reservation_mouza_name'   => $this->utilityclass->getMouzaName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code),
                    'reservation_lot_name'     => $this->utilityclass->getLotName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no),
                    'reservation_village_name' => $this->utilityclass->getVillageName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no, $reservation->vill_townprt_code),
                    'isBarakValley' => $isBarakValley,
                ];
            }

            $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($this->session->userdata('dist_code'));
            $subdiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'));

            //*****reservation details in circle  */
            $reservationByCircleDetails = array();

            $sql_rc = $this->db->query('select r.dist_code, r.subdiv_code, r.cir_code, 
                SUM(r.dag_area_b*100 + r.dag_area_k*20 + r.dag_area_lc) AS total_lessa, 
                SUM(r.dag_area_b*6400 + r.dag_area_k*320 + r.dag_area_lc*20 + r.dag_area_g) AS total_ganda 
                from settlement_vgr_pgr_reservation r join reclass_suite_basic b on r.case_no = b.case_no where b.status not in (\'D\', \'F\') and b.status = ? and r.dist_code =? and r.subdiv_code =? and r.cir_code =? group by r.dist_code, r.subdiv_code, r.cir_code', array($status, $cir_dist_code, $cir_subdiv_code, $cir_cir_code));

            if($sql_rc->num_rows() <= 0)
            {
                echo json_encode(array(
                    'responseType' => 0,
                    'message' => '#ERR1154: Something went wrong! Contact admin...'
                ));
                return;
            }

            $rc_result = $sql_rc->result();

            foreach($rc_result as $rrc)
            {
                $isBV = 0;
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                {
                    $circleBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa2($rrc->total_ganda);
                    $isBV = 1;
                }
                else
                {
                    $circleBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa($rrc->total_lessa);
                }

                $reservationByCircleDetails[] = (object)
                [
                    'dist_name' => $this->utilityclass->getDistrictName($rrc->dist_code),
                    'subdiv_name' => $this->utilityclass->getSubDivName($rrc->dist_code, $rrc->subdiv_code),
                    'cir_name' => $this->utilityclass->getCircleName($rrc->dist_code, $rrc->subdiv_code, $rrc->cir_code),
                    'bigha' => $circleBKLG[0],
                    'katha' => $circleBKLG[1],
                    'lessa' => $circleBKLG[2],
                    'ganda' => $circleBKLG[3],
                    'isBV'  => $isBV
                ];
            }

            $reservations = array(
                'responseType' => 2,
                'caseList'     => $allSelectedList,
                'reservationDetails'         => $reservationDetails,
                'reservationByCircleDetails' => $reservationByCircleDetails,
                'distName'   => $dist_name->locname_eng,
                'subDivName' => $subdiv_name->locname_eng,
                'cluster_id' => $cluster_id,
                'message'    => 'ok'
            );

            return $reservations;
        }
        else
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRVD001114: Something went wrong ! Kindly contact system administrator '
            );
            return $reservations;
        }

    }


    // check case match status in cluster or not
    public function checkIfCaseRevertedFromCluster($case_no)
    {
        $case_no = trim($case_no);
        $sql = $this->db->query('select * from settlement_circle_cluster_cases where case_no = ?', array($case_no));

        $clusterStatus = 0;
        $clusterError  = '';
        $clusterIdList = 0;
        if($sql->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004663: No cluster found for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $clusterIdList,
            ];
            return $returnDataArray;
        }

        $cluster_id = $sql->row()->cluster_id;
        $clusterStatusSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

        if($sql->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004679: No cluster found for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $cluster_id,
            ];
            return $returnDataArray;
        }

        $cluster_row        = $clusterStatusSql->row();
        $cluster_status     = trim($cluster_row->status);
        $cluster_pending_at = trim($cluster_row->pending_at);
        $getCaseStatusBasic = $this->db->query('select * from reclass_suite_basic where case_no = ?', array($case_no));

        if($getCaseStatusBasic->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004697: There is some problem for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $cluster_id,
            ];
            return $returnDataArray;
        }

        $basicRow = $getCaseStatusBasic->row();

        $caseBasicStatus    = trim($basicRow->status);
        $caseBasicPendingAt = trim($basicRow->pending_officer);

        if($caseBasicStatus != 'D')
        {
            if(($cluster_status != $caseBasicStatus) || ($cluster_pending_at != $caseBasicPendingAt))
            {
                $clusterStatus = 0;
                $clusterError  = 'ERR004717: Some cases of this cluster is reverted and still pending';

                $returnDataArray = [
                    'clusterStatus' => $clusterStatus,
                    'clusterError'  => $clusterError,
                    'clusterIdList' => $cluster_id,
                ];
                return $returnDataArray;
            }
        }

        $returnDataArray = [
            'clusterStatus' => 1,
            'clusterError'  => 'OK',
            'clusterIdList' => $cluster_id,
        ];
        return $returnDataArray;

    }


    // All recommended / not recommended cases By MRIDU SIR
    public function generateProposalCases($proposals, $meetingId)
    {
        //FOR_PROGRESS
        $session_status = 0;
        $log_status = 0;
        $tmp_file = null;
        $dist_code   = $this->session->userdata('dist_code');
        try
        {
            $prop = '';
            $index = 0;
            foreach ($proposals as $p)
            {
                if ($index == 0)
                {
                    $prop = $prop."'".$p->id."'";
                }
                else
                {
                    $prop = $prop.",'".$p->id."'";
                }
                $index++;
            }

            $sql = "SELECT t.case_no, t.proposal_id,t.remark,t.case_status, s.subdiv_code FROM reclass_suite_basic s JOIN (
                    SELECT  case_no,  proposal_id,
    		                sc.template_remarks as  remark, sc.case_status FROM settlement_proposal_cases sc
    		                WHERE sc.proposal_id IN ($prop)
    		                ) t ON s.case_no=t.case_no ORDER BY s.dist_code,s.subdiv_code,s.cir_code";

            $result = $this->db->query($sql)->result();
            $sql = "SELECT id,proposal_name FROM settlement_proposal_list WHERE id in ($prop)";
            $proposals = $this->db->query($sql)->result();
            foreach($proposals as $p)
            {
                $props[$p->id]=$p->proposal_name;
            }

            //FOR_PROGRESS            
            $row_count = 0;
            if (PROG_MEET_GENERATE == '1')
            {
                $total_count = $result == null ? 0 : count($result);
                $tmp_file = PROGRESS_DIR . $dist_code.'_'.$meetingId . ".txt";
                if (file_exists($tmp_file))
                    unlink($tmp_file);
                $session_status = session_write_close() ? 1 : 0;
            }

            foreach($result as $r)
            {
                //FOR_PROGRESS
                $row_count++;
                $st_time = microtime(true);
                if (PROG_MEET_GENERATE == '1')
                {
                    $this->ProgressModel->saveBulkCasesByMeetingProgress($row_count,$total_count,$tmp_file);
                }
                $sql = "SELECT
    			        (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
    			    cir_code=s.cir_code and mouza_pargona_code='00') as cirname,
    			                (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
    			    cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no='00') as mouza,
    			                (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
    			    cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no AND
    			    vill_townprt_code = s.vill_townprt_code) as village,applid, service_code from reclass_suite_basic s where case_no='$r->case_no'";
                $locations = $this->db->query($sql)->row();

                $sql = " select string_agg(distinct(eng_pdar_name || '---' || eng_pdar_guardian || ''),',') as name from 
    	    	          reclass_applicant where case_no='$r->case_no' and pdar_type='O'";
                $applicants = $this->db->query($sql)->row();

                $sql = " select STRING_AGG(sp.dag_no||'---' || sp.total_lessa::VARCHAR || '',',') as dags from settlement_premium sp
                  where case_no='$r->case_no' and is_final = 1";
                $dags = $this->db->query($sql)->row();

                $sql = "SELECT STRING_AGG(sd.land_type, ',') AS ladtype,sd.exist_land_class_name AS Existing_Class,
                    sd.proposed_land_class_name AS Proposed_Class,
                    CASE sd.nature_possession
                    WHEN '1' THEN 'Agricultural'
                    WHEN '2' THEN 'Residential'
                    WHEN '3' THEN 'Industrial'
                    WHEN '4' THEN 'Trade'
                    WHEN '6' THEN 'Plantation'
                    WHEN '10' THEN 'Institution'
                    ELSE 'Other'
                    END  AS Nature_of_Possession FROM reclass_dag_details sd WHERE sd.case_no = '$r->case_no'
                    GROUP BY sd.exist_land_class_name,sd.proposed_land_class_name,sd.nature_possession";
                $land_type = $this->db->query($sql)->row();


                $result_array[] = array(
                    "cirname"              => $locations->cirname,
                    "mouza"                => $locations->mouza,
                    "village"              => $locations->village,
                    "applid"               => $locations->applid,
                    "service_code"         => $locations->service_code,
                    "name"                 => $applicants->name,
                    "dags"                 => $dags->dags,
                    "ladtype"              => $land_type->ladtype,
                    "subdiv_code"          => $r->subdiv_code,
                    "case_no"              => $r->case_no,
                    "case_status"          => $r->case_status,
                    "remark"               => $r->remark,
                    "proposal_name"        => $props[$r->proposal_id],
                    "existing_class"       => $land_type->existing_class,
                    "proposed_class"       => $land_type->proposed_class,
                    "nature_of_possession" => $land_type->nature_of_possession,

                );
                if ($log_status == 1)
                {
                    log_message('error','case_count: '.$row_count.', time taken='.(microtime(true)-$st_time));
                }
            }


            $serviceNames[40] = 'Offering Reclassification Suite';

            $CheckClusterStatus = [];
            $vgrPgrStatus = 0;
            foreach ($result_array as $row)
            {
                if(trim($row['service_code']) == SETTLEMENT_PGR_VGR_LAND_ID)
                {
                    $case_no = trim($row['case_no']);
                    $CheckClusterCount = $this->checkIfCaseRevertedFromCluster($case_no);
                    if(trim($CheckClusterCount['clusterStatus']) != 1)
                    {
                        $CheckClusterStatus[] = array(
                            'response' => 1,
                            'message'  => $CheckClusterCount['clusterError']
                        );
                    }
                    $vgrPgrStatus = 1;
                }

                $jsmr = explode(",", $row['dags']);
                $final_dag     = '';
                $final_area    = '';
                for($j=0; $j<count($jsmr); $j++)
                {
                    $final_all = explode('---',$jsmr[$j]);
                    if($j==count($jsmr) - 1)
                    {
                        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $final_dag  = $final_dag . $final_all[0];
                            $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                            $final_area = $final_area . $bklArea;
                        }
                        else
                        {
                            $final_dag  = $final_dag . $final_all[0];
                            $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                            $final_area = $final_area . $bklArea;
                        }
                    }
                    else
                    {
                        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $final_dag  = $final_dag . $final_all[0].'<br>';
                            $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                            $final_area = $final_area . $bklArea.'<br>';
                        }
                        else
                        {
                            $final_dag  = $final_dag . $final_all[0].'<br>';
                            $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                            $final_area = $final_area . $bklArea.'<br>';
                        }
                    }
                }


                $jsmr2 = explode(",", $row['name']);
                $final_name ='';
                $final_guard = '';
                for($j=0; $j<count($jsmr2); $j++)
                {
                    $final_all = explode('---',$jsmr2[$j]);

                    if($j==count($jsmr2) - 1)
                    {
                        $final_name = $final_name . $final_all[0];
                        $final_guard = $final_guard . (isset($final_all[1]) ? $final_all[1] : '');
                    }
                    else
                    {
                        $final_name = $final_name . $final_all[0].', ';
                        $final_guard = $final_guard . (isset($final_all[1]) ? $final_all[1] : '').', ';
                    }
                }


                // rec
                if($row['case_status']==1)
                {
                    $final_result_array_rec[] = array(
                        "cirname"=>  $row['cirname'],
                        "mouza"=>	 $row['mouza'],
                        "village"=>	 $row['village'],
                        "case_no"=>	 $row['case_no'],
                        "applid"=>	 $row['applid'],
                        "service_name"  =>  $serviceNames[$row['service_code']],
                        "proposal_name" => $row['proposal_name'],
                        "subdiv_code"   => $row['subdiv_code'],
                        "name"   =>	$final_name,
                        "guard"  =>	$final_guard,
                        "dag"    =>	$final_dag,
                        "area"   =>	$final_area,
                        "remark" => $row['remark'],
                        "ladtype"=>	$row['ladtype'],
                        "status"=>	$row['case_status'],
                        "existing_class"       => $row['existing_class'],
                        "proposed_class"       => $row['proposed_class'],
                        "nature_of_possession" => $row['nature_of_possession'],
                    );
                }

                // not rec
                if($row['case_status']==2)
                {
                    $final_result_array_not_rec[] = array(
                        "cirname"=>  $row['cirname'],
                        "mouza"=>	 $row['mouza'],
                        "village"=>	 $row['village'],
                        "case_no"=>	 $row['case_no'],
                        "applid"=>	 $row['applid'],
                        "service_name"  =>  $serviceNames[$row['service_code']],
                        "proposal_name" => $row['proposal_name'],
                        "subdiv_code"   => $row['subdiv_code'],
                        "name"   =>	$final_name,
                        "guard"  =>	$final_guard,
                        "dag"    =>	$final_dag,
                        "area"   =>	$final_area,
                        "remark" =>  $row['remark'],
                        "ladtype"=>	$row['ladtype'],
                        "status"=>	$row['case_status'],
                        "existing_class"       => $row['existing_class'],
                        "proposed_class"       => $row['proposed_class'],
                        "nature_of_possession" => $row['nature_of_possession'],
                    );
                }
            }

            $final_result_array = array(
                'final_result_array_rec'     =>
                    (isset($final_result_array_rec) && $final_result_array_rec != NULL)? $final_result_array_rec: '',
                'final_result_array_not_rec' =>
                    (isset($final_result_array_not_rec) && $final_result_array_not_rec != NULL)? $final_result_array_not_rec: '',
                'CheckClusterStatus' =>
                    (isset($CheckClusterStatus) && $CheckClusterStatus != NULL)? $CheckClusterStatus: '',
                'vgrPgrStatus' => $vgrPgrStatus
            );

            return $final_result_array;
        }
        catch (Exception $e)
        {
            echo json_encode(array(
                'responseType' =>1,
                'message'      => '#ERR3110: Some error occurred  !!',
            ));
            return;
        }
        finally
        {
            if (PROG_MEET_GENERATE == '1')
            {
                if (file_exists($tmp_file))
                {
                    unlink($tmp_file);
                }
                if ($session_status == 1)
                {
                    session_start();
                }
            }
            if ($log_status == 1)
            {
                log_message('error', ' session_status: '.$session_status);
            }
        }
    }


    // digital sign and save the pdf
    public function digitalSignAndSavePdf()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingIdDigital', 'Meeting Name', 'trim|required');

        ini_set("pcre.backtrack_limit", "50000000");

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingIdDigital');
            $html1       = base64_decode($this->input->post('html1'));
            $html2       = $this->input->post('html2');
            $html3       = $this->input->post('html3');

            $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
            $distEngName = substr($dist_name->locname_eng, 0, 3);
            $fileName    = $distEngName.'_DLC_RE_'.$dist_code.'_'.date("Y").'_'.$meetingId;


            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                // Mriganka da's code here
                if(MB3_DIGITAL_SIGN_LIVE == 1)
                {
                    include 'vendor/mpdf/vendor/autoload.php';
                    $mpdf=new \Mpdf\Mpdf();
                    if(MB3_DIGITAL_SIGN_DRAFT_MODE == 1)
                    {
                        $waterMark = 'Mission Basundhara 3.0';
                    }
                    else
                    {
                        $waterMark = 'DRAFT';
                    }

                    $mpdf->SetWatermarkText($waterMark);
                    $mpdf->showWatermarkText = true;
                    $mpdf->autoScriptToLang = true;
                    $mpdf->autoLangToFont = true;

                    $html ="<style>                   
                    .reza-title{
                        font-weight: bold;
                        font-size: 16px;
                        padding: 20px;
                    }                                
                    .rezaText {
                        font-size: 14px;
                    }
                    .divCard {
                        background: #fff;
                        border-radius: 2px;
                        display: inline-block;
                        position: relative;
                        width: 100%;
                    }
                    .mrigankaCenter{
                        text-align: center!important;
                    }                    
                    .mrigankaRight{
                        text-align: right!important;
                        margin-top: 40px;
                    }
                    .rezaText2 {
                        font-size: 14px!important;
                        margin: 20px!important;
                        text-align: center;
                    }
                   
                   
                </style>";
                    $mpdf->writeHTML($html1.$html);
                    $mpdf->AddPage();
                    $mpdf->writeHTML($html2.$html);
                    $mpdf->AddPage();
                    $mpdf->writeHTML($html3.$html);
                    $mpdf->Output(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf','F');
                    $b64Doc = chunk_split(base64_encode(file_get_contents(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf')));
                    //$b64Doc = base64_encode(file_get_contents(SIGNPDF_UPLOAD_DIR.'LAK_SDLAC_2023_30_155'.'.pdf'));

                    echo json_encode(array(
                        'responseType' => 2,
                        'meetingId'    => $meetingId,
                        'base64pdfData' => $b64Doc,
                    ));

                    return;
                }
                else
                {

                    include 'vendor/mpdf/vendor/autoload.php';
                    $mpdf=new \Mpdf\Mpdf();
                    if(MB3_DIGITAL_SIGN_DRAFT_MODE == 1)
                    {
                        $waterMark = 'Mission Basundhara 3.0';
                    }
                    else
                    {
                        $waterMark = 'DRAFT';
                    }

                    $mpdf->SetWatermarkText($waterMark);
                    $mpdf->showWatermarkText = true;
                    $mpdf->autoScriptToLang = true;
                    $mpdf->autoLangToFont = true;

                    $html ="<style>                   
                    .reza-title{
                        font-weight: bold;
                        font-size: 16px;
                        padding: 20px;
                    }                                
                    .rezaText {
                        font-size: 14px;
                    }
                    .divCard {
                        background: #fff;
                        border-radius: 2px;
                        display: inline-block;
                        position: relative;
                        width: 100%;
                    }
                    .mrigankaCenter{
                        text-align: center!important;
                    }                    
                    .mrigankaRight{
                        text-align: right!important;
                        margin-top: 40px;
                    }
                    .rezaText2 {
                        font-size: 14px!important;
                        margin: 20px!important;
                        text-align: center;
                    }
                   
                   
                </style>";
                    $mpdf->writeHTML($html1.$html);
                    $mpdf->AddPage();
                    $mpdf->writeHTML($html2.$html);
                    $mpdf->AddPage();
                    $mpdf->writeHTML($html3.$html);
                    $mpdf->Output(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf','F');
                    $b64Doc = chunk_split(base64_encode(file_get_contents(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf')));

                    echo json_encode(array(
                        'responseType' => 2,
                        'meetingId'    => $meetingId,
                        'base64pdfData' => $b64Doc,
                    ));

                    return;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR0001087: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }


    // signed and final approved meeting by DC By MRIDU SIR
    public function signedAndFinalApproveByDC()
    {
        //FOR_PROGRESS
        $session_status = 0;
        $log_status = 0;
        $tmp_file = null;
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        try
        {
            $_POST = json_decode(file_get_contents("php://input"), true);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            $dist_code   = $this->session->userdata('dist_code');
            $meetingId   = trim($this->input->post('meetingId'));
            $pdfData     = $this->input->post('pdfData');
            $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
            $distEngName = substr($dist_name->locname_eng, 0, 3);
            $fileName    = $distEngName.'_DLC_RE_'.$dist_code.'_'.date("Y").'_'.$meetingId;


            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }

            //get list of proposals
            $getProposalsList = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();


            //FOR_PROGRESS
            $row_count = 0;
            $final_st_time = microtime(true);
            if (PROG_MEET_APPROVE == '1')
            {
                $sql = "select count(distinct(case_no)) as c from settlement_proposal_cases spc where spc.proposal_id in (select distinct(id) from settlement_proposal_list spl where proposal_meeting_id=?)";
                $total_count = $this->db->query($sql, array($meetingId))->row()->c;
                $tmp_file = PROGRESS_DIR . $dist_code.'_'.$meetingId . ".txt";
                if (file_exists($tmp_file))
                    unlink($tmp_file);
                $session_status = session_write_close();
            }

            $this->db->trans_begin();
            $vgrPgrClusterStatus = 0;
            foreach($getProposalsList as $prop)
            {
                //FOR_PROGRESS
                $final_prop_st_time = microtime(true);

                $allCasesUrbanByProposal = array();
                $allCasesRuralByProposal = array();
                $allCasesDLRByProposal   = array();

                $proposal_no         = trim($prop->proposal_id);
                $proposalDetails     = $this->ReclassSuiteMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
                $final_verify_status = trim($proposalDetails->final_verify_status);

                if($final_verify_status == 0 || $final_verify_status == 2)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR0001147: Validation issue. Verification pending at SDO/ADC');
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0001147: Unable to process for final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
                if($final_verify_status == 1)
                {
                    $pendingCase = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                    $caseCount   = $pendingCase->num_rows();
                    if($caseCount == 0)
                    {
                        log_message('error', '#MRNP01162: There is no case under proposal '.$proposal_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MRNP01162: There is no case under proposal '. $proposalDetails->proposal_name
                                .' Kindly contact system administrator !!!!',
                        ));
                        return;
                    }

                    $cases = $pendingCase->result();


                    //PROCESS EACH CASE OF THE PROPOSAL
                    foreach ($cases as $case)
                    {
                        //FOR_PROGRESS
                        $row_count++;
                        $st_time = microtime(true);

                        $finalApprovedBy = 0; // approved by:  1 dept  2 dc
                        $wedLandStatus   = 0; // wet Land Status by:  1 dept  0 dc
                        $case_no         = trim($case->case_no);
                        $user_code       = $this->session->userdata('user_code');
                        $proposal_id     = $proposal_no;
                        $proposal_no_int = (int)$proposal_no;
                        $remarks         = 'DC verification done & Recommended';
                        $dag             = $this->ReclassCommonDcModel->getSettlementDagCommon($case_no);
                        $urbanByLm       = $this->ReclassCommonDcModel->getLandFallsUnderUrban($case_no);
                        $basic           = $this->reclassModel->getSettlementBasic($case_no);



                        //if($caseCount == 0)
                        if ($basic['status'] != MB_FINAL_APPROVED_BY_DC || !in_array($basic['pending_officer'],[MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]))
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MR0001189: Few cases under this proposal has already 
                            been approved. Proposal# : '.$proposal_no.' Case# : '.$case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR0001189: Unable to process for final approval. 
                                    Few cases under this meeting has already been approved !!!!',
                            ));
                            return;
                        }

                        if(trim($basic['final_status']) == MB_APPROVED_BY_SDLAC)
                        {
                            if(trim($basic['service_code']) == SETTLEMENT_PGR_VGR_LAND_ID)
                            {
                                $finalApprovedBy     = 1; // dept
                                $vgrPgrClusterStatus = 1; // update for cluster table
                            }
                            else
                            {
                                if($basic['approve_by'] == '')
                                {
                                    echo json_encode(array(
                                        'responseType' => 1,
                                        'message'      => '#MR0001761: Approved by office not found ( '.$case_no.' ). 
                                                            Kindly contact system administrator !!!!',
                                    ));
                                    return;
                                }
                                else if($basic['approve_by'] != '')
                                {
                                    if($basic['approve_by'] == 'GOVT')
                                    {
                                        $finalApprovedBy = 1; // dept
                                    }
                                    if($basic['approve_by'] == 'DC')
                                    {
                                        $finalApprovedBy = 2; // dc
                                    }
                                    if($basic['approve_by'] == 'DLR')
                                    {
                                        $finalApprovedBy = 3; // DLR
                                    }
                                }
                                else
                                {
                                    echo json_encode(array(
                                        'responseType' => 1,
                                        'message'      => '#MR0001761: Approved by office not found. 
                                                            Kindly contact system administrator !!!!',
                                    ));
                                    return;
                                }
                            }

                            if($finalApprovedBy == 1) // approve by dept
                            {
                                $allAPICasesUrban[] = $case_no;
                                $allCasesUrbanByProposal[] = $case_no;
                                //////proceeding start//////
                                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                $insPetProceed[] = [
                                    'case_no'              => $case_no,
                                    'proceeding_id'        => $proceeding_id,
                                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                    'status'               => MB_PENDING,
                                    'user_code'            => $this->session->userdata('user_code'),
                                    'date_entry'           => date('Y-m-d h:i:s'),
                                    'operation'            => 'E',
                                    'note_on_order'        => $remarks,
                                    'ip'                   => $this->utilityclass->get_client_ip(),
                                    'office_from'          => MB_DEPUTY_COMM,
                                    'office_to'            => MB_DEPARTMENT,
                                    'task'                 => 'Approved by SDLAC',
                                    'minutes_proposal_id'  => $proposal_id
                                ];
                            }
                            else if($finalApprovedBy == 2) // approve by DC
                            {
                                $allAPICasesRural[] = $case_no;
                                $allCasesRuralByProposal[] = $case_no;
                                //////proceeding start//////
                                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                $insPetProceed[] = [
                                    'case_no'               => $case_no,
                                    'proceeding_id'         => $proceeding_id,
                                    'date_of_hearing'       => date('Y-m-d h:i:s'),
                                    'next_date_of_hearing'  => date('Y-m-d h:i:s'),
                                    'status'                => MB_PAYMENT_REQUEST,
                                    'user_code'             => $this->session->userdata('user_code'),
                                    'date_entry'            => date('Y-m-d h:i:s'),
                                    'operation'             => 'E',
                                    'note_on_order'         => $remarks,
                                    'ip'                    => $this->utilityclass->get_client_ip(),
                                    'office_from'           => MB_DEPUTY_COMM,
                                    'office_to'             => MB_CIRCLE_OFFICER,
                                    'task'                  => 'Approved by SDLAC',
                                    'minutes_proposal_id'   => $proposal_id
                                ];
                            }
                            else if($finalApprovedBy == 3) // approve by DLR
                            {
                                $allAPICasesDLR[]        = $case_no;
                                $allCasesDLRByProposal[] = $case_no;
                                //////proceeding start//////
                                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                $insPetProceed[] = [
                                    'case_no'              => $case_no,
                                    'proceeding_id'        => $proceeding_id,
                                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                    'status'               => MB_PENDING,
                                    'user_code'            => $this->session->userdata('user_code'),
                                    'date_entry'           => date('Y-m-d h:i:s'),
                                    'operation'            => 'E',
                                    'note_on_order'        => $remarks,
                                    'ip'                   => $this->utilityclass->get_client_ip(),
                                    'office_from'          => MB_DEPUTY_COMM,
                                    'office_to'            => 'DLR',
                                    'task'                 => 'Approved by SDLAC',
                                    'minutes_proposal_id'  => $proposal_id
                                ];
                            }
                            else
                            {
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#MR0001778: Approved by office not found. 
                                Kindly contact system administrator !!!!',
                                ));
                                return;
                            }
                        }
                        elseif(trim($basic['final_status']) == MB_DISMISS)
                        {
                            $updateProReject = array(
                                'status' => PRO_CASE_STATUS_REJECT,
                                'approved_by_dc' => 1,
                            );
                            if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updateProReject) == 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR0001429: Updation failed settlement_proposal_cases '
                                    .$this->db->last_query());
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#MR0001429: Unable to process for final approval. 
                                    Few cases under this meeting has already been approved !!!!',
                                ));
                                return;
                            }

                            //*****update in reclass_suite_basic */
                            $basic_update_arr = [
                                'status'            => MB_DISMISS,
                                'dc_proceeding'     => 0,
                                'pending_office'    => '',
                                'pending_officer'   => '',
                                'from_office'       => MB_DEPUTY_COMM,
                                'dc_code'           => $this->session->userdata('user_code'),
                                'cab_memo_prepared' => 0
                            ];

                            $this->db->where('case_no', $case_no);
                            $this->db->update('reclass_suite_basic', $basic_update_arr);
                            if($this->db->affected_rows() <= 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR0001458: Updation failed in reclass_suite_basic '
                                    .$this->db->last_query());
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#MR0001458: Unable to process for final approval. 
                                  Few cases under this meeting has already been approved !!',
                                ));
                                return;
                            }

                            //*******insert in settlement_proceeding */
                            $getRejectedReasonSql = $this->db->query("SELECT A.reject_code, A.service_code, B.remark, A.sub_remark FROM rejected_remark A 
                            INNER JOIN reject_master B ON CAST(A.reject_code AS int) = B.reject_code
                            WHERE A.case_no = ?", array($case_no));

                            if($getRejectedReasonSql->num_rows() > 0)
                            {
                                $rejReasonArr    = $getRejectedReasonSql->result();
                                $rejectCodeArray = array();
                                $rejReasonArr1   = array();
                                foreach($rejReasonArr as $rejRe)
                                {
                                    $rejectCodeArray[] = [
                                        'service_code' => $rejRe->service_code,
                                        'id'  => $rejRe->reject_code,
                                        'name' => $rejRe->remark
                                    ];
                                    if($rejRe != '')
                                    {
                                        $reza = $rejRe->remark.':'.$rejRe->sub_remark;
                                    }
                                    else
                                    {
                                        $reza = $rejRe->remark;
                                    }
                                    $rejReasonArr1[] = $reza;
                                }
                                $rejectedReasonList = implode ( ", ", $rejReasonArr1 );
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR0001491: No rejected reason found');
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#MR0001491: Unable to process for final approval. 
                                  Few cases under this meeting has already been approved !!',
                                ));
                                return;
                            }

                            $sql = "select MAX(proceeding_id)+1 as id from settlement_proceeding where case_no=? ";
                            $proceeding_id = $this->db->query($sql, array($case_no))->row()->id;
                            $proceeding_array = array(
                                'case_no'              => $case_no,
                                'proceeding_id'        => $proceeding_id,
                                'date_of_hearing'      => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                'status'               => MB_DISMISS,
                                'user_code'            => $this->session->userdata('user_code'),
                                'date_entry'           => date('Y-m-d G:i:s'),
                                'operation'            => 'E',
                                'note_on_order'        => 'Rejected for: '.$rejectedReasonList,
                                'ip'                   => $this->utilityclass->get_client_ip(),
                                'office_from'          => $this->session->userdata('user_desig_code'),
                                'office_to'            => '',
                                'task'                 => 'Rejected by SDLAC',
                            );

                            $insertProceeSql = $this->db->insert('settlement_proceeding', $proceeding_array);

                            if($insertProceeSql != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR0001433: Insertion failed in settlement_proceeding '.
                                    $this->db->last_query());
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#MR0001433: Unable to process for final approval. 
                                  Few cases under this meeting has already been approved !!',
                                ));
                                return;
                            }
                            else
                            {
                                // ////////////// POST Reject status To basundhara ////////////////////
                                $application_no = $this->reclassSuiteADCModel->getSettlementBasicCo($case_no)->applid;
                                $rmk    = 'Rejected by SDLAC: '.$rejectedReasonList;
                                $status = 'R';
                                $task   = 'SDLAC';
                                $pen    = 'NA';

                                $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2ndMb3
                                ($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);

                                if (trim($rtps_status)!="y")
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#MR0001555: Issue in API Call'
                                        .$this->db->last_query());
                                    echo json_encode(array(
                                        'responseType' => 3,
                                        'message'      => '#MR0001555: Unable to process for final approval.
                                              Kindly contact system administration !!!',
                                    ));
                                    return;
                                }
                            }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR0001568: Unable to process for final approval. 
                                    Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                        //FOR_PROGRESS
                        if ($session_status == 1)
                        {
                            log_message('error','case_count: '.$row_count.', time taken='.(microtime(true)-$st_time));
                        }
                        if (PROG_MEET_APPROVE == '1')
                        {
                            $this->ProgressModel->saveBulkCasesByMeetingProgress($row_count,$total_count,$tmp_file);
                        }
                    }

                    //AFTER PROCESSING EACH CASE OF THE PROPOSAL UPDATES PROPOSAL DETAILS & BATCH UPDATE

                    // for Department
                    if (isset($allCasesUrbanByProposal) && count($allCasesUrbanByProposal)>0)
                    {
                        $updateDataUrban = array(
                            'status'             => MB_PENDING,
                            'pending_office'     => MB_DEPARTMENT,
                            'pending_officer'    => MB_DEPARTMENT,
                            'from_office'        => MB_DEPUTY_COMM,
                            'dc_code'            => $user_code,
                            'sdlac_approval'     => 'Y',
                            'sdlac_date'         => date('Y-m-d h:i:s'),
                            'dc_proceeding'      => 1,
                            'sdlace_proposal_no' => $proposal_no,
                            'date_update'        => date('Y-m-d h:i:s'),
                            'dept_approval'      => NULL,
                            'cab_memo_prepared'  => 0
                        );
                        $count_updateData = count($allCasesUrbanByProposal);
                        $count_updateData_db = $this->updateBatch('reclass_suite_basic',$updateDataUrban, 'case_no', $allCasesUrbanByProposal);

                        if ($count_updateData != $count_updateData_db)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR00028740000: Unable to batch update reclass_suite_basic  final approval. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                    }


                    // for DLR
                    if (isset($allCasesDLRByProposal) && count($allCasesDLRByProposal)>0)
                    {
                        $updateDataDLR = array(
                            'status'             => MB_PENDING,
                            'pending_office'     => 'DLR',
                            'pending_officer'    => 'DLR',
                            'from_office'        => MB_DEPUTY_COMM,
                            'dc_code'            => $user_code,
                            'sdlac_approval'     => 'Y',
                            'sdlac_date'         => date('Y-m-d h:i:s'),
                            'dc_proceeding'      => 1,
                            'sdlace_proposal_no' => $proposal_no,
                            'date_update'        => date('Y-m-d h:i:s'),
                            'dept_approval'      => NULL,
                            'cab_memo_prepared'  => 0
                        );
                        $count_updateData    = count($allCasesDLRByProposal);
                        $count_updateData_db = $this->updateBatch('reclass_suite_basic',$updateDataDLR, 'case_no', $allCasesDLRByProposal);

                        if ($count_updateData != $count_updateData_db)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR00028740000: Unable to batch update reclass_suite_basic  final approval. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                    }


                    // for DC
                    if (isset($allCasesRuralByProposal) && count($allCasesRuralByProposal)>0)
                    {
                        $updateDataRural = array(
                            'status'             => MB_PAYMENT_REQUEST,
                            'pending_office'     => MB_CIRCLE_OFFICER,
                            'pending_officer'    => MB_CIRCLE_OFFICER,
                            'from_office'        => MB_DEPUTY_COMM,
                            'dc_code'            => $user_code,
                            'sdlac_approval'     => 'Y',
                            'dc_proceeding'      => 1,
                            'sdlac_date'         => date('Y-m-d h:i:s'),
                            'sdlace_proposal_no' => $proposal_no,
                            'date_update'        => date('Y-m-d h:i:s'),
                        );
                        $count_updateData    = count($allCasesRuralByProposal);
                        $count_updateData_db = $this->updateBatch('reclass_suite_basic',$updateDataRural, 'case_no', $allCasesRuralByProposal);

                        if ($count_updateData != $count_updateData_db)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR00028749999: Unable to batch update reclass_suite_basic  final approval. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                    }
                    $dataUpdate = array(
                        'final_verify_status' => 2,
                        'dept_status' => 1
                    );
                    if($this->SettlementMbDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR0001582: Updation failed in settlement_proposal_list '.
                            $this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MR0001582: Unable to process for final approval. 
                                Kindly contact system administrator !!!!',
                        ));
                        return;
                    }
                }

                //FOR_PROGRESS
                if ($log_status == 1)
                {
                    log_message('error','Time for single proposal: '.$proposal_no.', time taken='.(microtime(true)-$final_prop_st_time));
                }
            }


            // Vgr Pgr condition check
            if($vgrPgrClusterStatus == 1)
            {
                if($this->SettlementCommonDcModel->countClusterIdByMeetingId($meetingId) == 0)
                {
                    $json = [
                        'response' => 1,
                        'message'  => '#MRCLUVP001993: Cluster not found ! Kindly contact system administrator ',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $clusterDetails = $this->SettlementCommonDcModel->getClusterIdByMeetingId($meetingId);

                if($clusterDetails->status != MB_FINAL_APPROVED_BY_DC)
                {
                    $json = [
                        'response' => 1,
                        'message'  => '#MRCLUVP002005: Some cases of this cluster is reverted and still pending ! Kindly contact system administrator ',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $clusterArr = [
                    'status'      => MB_PENDING,
                    'pending_at'  => MB_DEPARTMENT,
                    'date_update' => date('Y-m-d H:i:s'),
                ];
                $this->db->where('cluster_id', trim($clusterDetails->cluster_id));
                $this->db->update('settlement_circle_cluster', $clusterArr);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MRCLU002024: There is some problem, Please try again'
                    ));
                    return;
                }
            }


            //ALL CASE UPDATES
            $updatePro = array(
                'status'         => PRO_CASE_STATUS_APPROVE,
                'approved_by_dc' => 1,
                'updated_at'     => date('Y-m-d h:i:s'),
            );

            //URBAN CASES DPT
            if (isset($allAPICasesUrban))
            {
                $count_updatePro    = count($allAPICasesUrban);
                $count_updatePro_db = $this->updateBatch('settlement_proposal_cases',$updatePro, 'case_no', $allAPICasesUrban);

                if ($count_updatePro != $count_updatePro_db)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0002892: Unable to batch update settlement_proposal_cases  final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
            }

            //DLR CASES
            if (isset($allAPICasesDLR))
            {
                $count_updatePro    = count($allAPICasesDLR);
                $count_updatePro_db = $this->updateBatch('settlement_proposal_cases',$updatePro, 'case_no', $allAPICasesDLR);

                if ($count_updatePro != $count_updatePro_db)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0002892: Unable to batch update settlement_proposal_cases  final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
            }

            //RURAL CASES DC
            if (isset($allAPICasesRural))
            {
                $count_updatePro = count($allAPICasesRural);
                $count_updatePro_db = $this->updateBatch('settlement_proposal_cases',$updatePro, 'case_no', $allAPICasesRural);

                if ($count_updatePro != $count_updatePro_db)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0002892: Unable to batch update settlement_proposal_cases  final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
            }


            if (isset($insPetProceed) && count($insPetProceed)>0)
            {
                $count_insertProc = count($insPetProceed);
                $count_insertProc_db = $this->db->insert_batch('settlement_proceeding',$insPetProceed);
                if ($count_insertProc != $count_insertProc_db)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0002906 Unable to batch update settlement_proceeding  final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
            }
            //SIGNED PDF STORAGE
            $base64PDFData = $pdfData;
            $uploadpath   = SIGNPDF_UPLOAD_DIR;
            file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));
            $signDateTime = date('Y-m-d H:i:s');
            $updateMeetingID = array(
                'dc_approve_status'   => 1,
                'digital_sign_status' => 1,
                'updated_at'          => date('Y-m-d h:i:s'),
                'encode_pdf_dir_path' => $uploadpath.$fileName.".pdf",
                'digital_sign_date'   => $signDateTime
            );
            $this->db->where(['id' => $meetingId, 'dist_code' => $dist_code]);
            $this->db->update('proposal_meeting_list', $updateMeetingID);
            if($this->db->affected_rows() <=  0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MR0001607: Updation failed in proposal_meeting_list '.
                    $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MR0001607: Unable to process for final approval. 
                        Kindly contact system administrator !!!!',
                ));
                return;
            }
            if ($log_status == 1)
            {
                log_message('error','FINAL time taken='.(microtime(true)-$final_st_time));
            }

            //////////////POST To basundhara Bulk Urban DPT////////////////////
            if (isset($allAPICasesUrban) && count($allAPICasesUrban)>0)
            {
                $caseAppUrban = $this->SettlementCommonModel->convertLiteral($allAPICasesUrban);
                $caseAppUrbanSql = "select string_agg(applid,',') as applids from reclass_suite_basic where case_no in ($caseAppUrban)";
                $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

                $rmk    = 'Forwarded to Department';
                $status = 'M';
                $task   = MB_DEPUTY_COMM;
                $pen    = MB_DEPARTMENT;
                $rtps_status='y';
                $this->SettlementApiModel->applicationStatusUpdateBulkMb3($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
                if($rtps_status!="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRMRAPI9: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 3,
                        'message'      => '#ERRMRAPI9: Unable to process for final approval.
                                                  Kindly contact system administration !!!',
                    ));
                    return;
                }
            }


            //////////////POST To basundhara Bulk DLR////////////////////
            if (isset($allAPICasesDLR) && count($allAPICasesDLR)>0)
            {
                $caseAppDLR    = $this->SettlementCommonModel->convertLiteral($allAPICasesDLR);
                $caseAppDLRSql = "select string_agg(applid,',') as applids from reclass_suite_basic where case_no in ($caseAppDLR)";
                $allAPICasesDLRIds = $this->db->query($caseAppDLRSql)->row()->applids;

                $rmk    = 'Forwarded to DLR';
                $status = 'M';
                $task   = MB_DEPUTY_COMM;
                $pen    = 'DLR';
                $rtps_status='y';
                $this->SettlementApiModel->applicationStatusUpdateBulkMb3($allAPICasesDLRIds,'NA',$rmk,$status,$task,$pen);
                if($rtps_status!="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRMRAPI9: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 3,
                        'message'      => '#ERRMRAPI9: Unable to process for final approval.
                                                  Kindly contact system administration !!!',
                    ));
                    return;
                }
            }


            //////////////POST To basundhara Bulk Rural DC ////////////////////
            if (isset($allAPICasesRural) && count($allAPICasesRural)>0)
            {
                $caseAppRural = $this->SettlementCommonModel->convertLiteral($allAPICasesRural);
                $caseAppRuralSql = "select string_agg(applid,',') as applids from reclass_suite_basic where case_no in ($caseAppRural)";
                $allAPICasesRuralIds   = $this->db->query($caseAppRuralSql)->row()->applids;

                $rmk    = 'Forwarded To CO';
                $status = 'M';
                $task   = MB_DEPUTY_COMM;
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status = 'y';
                $this->SettlementApiModel->applicationStatusUpdateBulkMb3($allAPICasesRuralIds,'NA',$rmk,$status,$task,$pen);
                if($rtps_status!="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRMRAPI8: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 3,
                        'message'      => '#ERRMRAPI8: Unable to process for final approval.
                                                  Kindly contact system administration !!!',
                    ));
                    return;
                }
            }

            $this->db->trans_commit();

            echo json_encode(array(
                'responseType' => 2,
                'message'      => '#SUCCESS1290: Signing Process completed & Successfully Approved the meeting !!',
            ));
            return;
        }
        catch (Exception $e)
        {
            //alert the user.
            echo json_encode(array(
                'responseType' =>1,
                'message'      => '#ERR3110: Some error occured  !!',
            ));
            return;
        }
        finally
        {
            if (PROG_MEET_APPROVE == '1')
            {
                if (file_exists($tmp_file))
                {
                    unlink($tmp_file);
                }
                if ($session_status == 1)
                {
                    session_start();
                }
            }
            if ($log_status == 1)
            {
                log_message('error', ' session_status: '.$session_status);
            }
        }
    }


    // cases hold for forwarding to dept after date expire
    public function holdDeptCaseForwardTimeOut($case_no)
    {
        $case_no = trim($case_no);
        $endDate = HOLD_CASES_FORWARD_TO_DEPT_BY_DC_RECLASS;
        $today   = date('Y-m-d H:i:s');
        $finalApprovedBy = 2; // dc
        if(strtotime($endDate) < strtotime($today))
        {

            $basic = $this->reclassPullModel->getSettlementBasicReCla($case_no);
            if(trim($basic['final_status']) == MB_APPROVED_BY_SDLAC)
            {

                if($basic['approve_by'] == '')
                {
                    $finalApprovedBy = 1; // dept
                }
                elseif($basic['approve_by'] != '')
                {
                    if($basic['approve_by'] == 'GOVT')
                    {
                        $finalApprovedBy = 1; // dept
                    }
                    else
                    {
                        $finalApprovedBy = 2; // dc
                    }
                }
                else
                {
                    $finalApprovedBy = 1;
                }
            }
        }

        return $finalApprovedBy;
    }


    // Modification request & Chitha Area check
    public function verifyArea()
    {

        //FOR PROGRESS
        $session_status = 0;
        $log_status = 0;
        $tmp_file = null;
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        try
        {

            $_POST = json_decode(file_get_contents("php://input"), true);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => 'Meeting ID cannot be null',
                ));
                return;
            }

            $dist_code  = $this->session->userdata('dist_code');
            $meetingId  = trim($this->input->post('meetingId'));
            $errorArray = array();
            $pullArray  = array();
            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();
            if($checkMeeting != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }


            //FOR PROGRESS
            $final_st_time = microtime(true);
            if (PROG_MEET_AREA == '1')
            {
                $row_count = 0;
                $sql = "select count(distinct(case_no)) as c from settlement_proposal_cases spc where spc.proposal_id in (select distinct(id) from settlement_proposal_list spl where proposal_meeting_id=?)";
                $total_count = $this->db->query($sql, array($meetingId))->row()->c;
                $tmp_file = PROGRESS_DIR . $dist_code.'_'.$meetingId . ".txt";
                if (file_exists($tmp_file))
                    unlink($tmp_file);
                $session_status = session_write_close() ? 1 : 0;
            }


            $errorProArray = array();
            $errorProId    = array();
            $errorHoldArray     = array();
            $errorNotFoundArray = array();
            //get list of proposals
            $getProposalsList = $this->SettlementMeetingDcModel->getProposalDetailAgainstMeetingIdReCla($dist_code, $meetingId)->result();
            foreach($getProposalsList as $prop)
            {

                //FOR PROGRESS
                $final_prop_st_time = microtime(true);
                $proposal_no  = $prop->proposal_id;
                $proposalDetails = $this->SettlementMeetingDcModel->getProposalDetailsByIdReCla($proposal_no,$dist_code);
                $final_verify_status = trim($proposalDetails->final_verify_status);

                if($final_verify_status == 0 || $final_verify_status == 2)
                {
                    log_message('error', '#MR0001147: Validation issue. Verification pending at SDO/ADC');
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MR0001147: Unable to process for final approval. 
                                Kindly contact system administrator !!!!',
                    ));
                    return;
                }
                if($final_verify_status == 1)
                {
                    $pendingCase = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                    $caseCount   = $pendingCase->num_rows();
                    if($caseCount == 0)
                    {
                        $errorProArray[] = $proposalDetails->proposal_name;
                        $errorProId[]    = $proposalDetails->id;
                    }

                    $cases = $pendingCase->result();
                    foreach ($cases as $case)
                    {
                        $row_count++;
                        $st_time = microtime(true);

                        $case_no = trim($case->case_no);
                        $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerifyReCla($case_no,$dist_code);

                        if($caseCount == 0)
                        {
                            log_message('error', '#MR0001189: Few cases under this proposal has already 
                            been approved. Proposal# : '.$proposal_no.' Case# : '.$case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR0001189: Unable to process for final approval. 
                                    Few cases under this meeting has already been approved !!!!',
                            ));
                            return;
                        }
                        //$checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                        $pullCheck = $this->reclassPullModel->getSettlementBasicDetails($case_no);
                        $deptCheck = $this->holdDeptCaseForwardTimeOut($case_no);

                        //FOR PROGRESS
                        if ($log_status == 1)
                        {
                            log_message('error','case_count: '.$row_count.', time taken='.(microtime(true)-$st_time));
                        }
                        // 1 hold case;  2 ok;  3 approved by officer not found
                        if(trim($deptCheck) == 1)
                        {
                            $errorHoldArray[] = $case_no;
                        }
                        if (PROG_MEET_AREA == '1')
                        {
                            $this->ProgressModel->saveBulkCasesByMeetingProgress($row_count,$total_count,$tmp_file);
                        }
                        if($pullCheck!=null && $pullCheck->pull_request == 1)
                        {
                            $pullArray[] = $case_no;
                        }

                    }
                }
                //FOR PROGRESS
                if ($log_status == 1)
                    log_message('error','Time for single proposal: '.$proposal_no.', time taken='.(microtime(true)-$final_prop_st_time));
            }
            //FOR PROGRESS
            if ($log_status == 1)
                log_message('error','FINAL_TIME: , time taken='.(microtime(true)-$final_st_time));

            if(count($errorArray) > 0 OR count($pullArray) > 0)
            {
                $case_str  = '';
                $case_pull = '';
                foreach ($errorArray as $err)
                {
                    $case_str = $case_str.$err.',';
                }
                foreach ($pullArray as $pull)
                {
                    $case_pull = $case_pull.$pull.',';
                }

                $errorShow = '';
                if($case_pull != NULL && $case_str == NULL)
                {
                    $errorShow = 'There is modification request for  
                                      (Case No. -  '.$case_pull .')';
                }
                else if($case_str != NULL && $case_pull == NULL)
                {
                    $errorShow = 'Total Area Recommended for Settlement can’t exceed available Area in Chitha
                                      (Case No. -  '.$case_str .')';
                }
                else
                {
                    $var1 = 'Total Area Recommended for Settlement can’t exceed available Area in Chitha
                                (Case No. -  '.$case_str.')';
                    $var2 = 'There is modification request for  
                                      (Case No. -  '.$case_pull .')';

                    $errorShow = $var1.'<br>'.$var2;
                }
                log_message('error', '#MR0003166: '.$errorShow .') !');
                echo json_encode(array(
                    'responseType' => 101,
                    'message'      => '#MR0003166: Unable to process for final approval .'.$errorShow.' !!!',
                ));
                return;
            }

            // check for zero cases under proposal
            if(count($errorProArray) > 0)
            {
                $error_pro_zero_cases = '';
                foreach ($errorProArray as $errorPro)
                {
                    $error_pro_zero_cases = $error_pro_zero_cases.$errorPro.',';
                }
                log_message('error', '#MRNP01162: There is no case under proposal '.$error_pro_zero_cases);
                echo json_encode(array(
                    'responseType' => 102,
                    'message'      => $error_pro_zero_cases,
                    'proIds'       => $errorProId,
                ));
                return;

            }

            // checking for hold case
            if(count($errorHoldArray) > 0)
            {
                $error_hold_cases = '';
                $revertCasesBulk  = $errorHoldArray;
                foreach ($errorHoldArray as $errorHoldC)
                {
                    $error_hold_cases = $error_hold_cases.$errorHoldC.',';
                }
                log_message('error', '#MRDHC001: As forwarding to Department has been stopped  '.$error_hold_cases);
                echo json_encode(array(
                    'responseType'    => 103,
                    'message'         => $error_hold_cases,
                    'revertCasesBulk' => $revertCasesBulk,
                ));
                return;

            }

            echo json_encode(array(
                'responseType' => 2,
                'message'      => '#SUCCESS1290: Verifying Process completed  !!',
            ));
            return;
        }
        catch (Exception $e)
        {
            //alert the user.
            var_dump($e);
            echo json_encode(array(
                'responseType' =>1,
                'message'      => '#ERR3110: Some error occured  !!',
            ));
            return;
        }
        finally
        {
            if (PROG_MEET_AREA == '1')
            {
                if (file_exists($tmp_file))
                    unlink($tmp_file);
                if ($session_status == 1) session_start();
            }
            if ($log_status == 1)
                log_message('error', ' session_status: '.$session_status);
        }
    }


    // delete proposal with zero cases
    public function deleteProposalWithZeroCasesForPendingMeetingByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalIds  = $this->input->post('proposalIds');
        $proposalName = $this->input->post('proposalName');
        $dist_code    = $this->session->userdata('dist_code');
        $user_code    = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');

        if (empty($proposalIds) || empty($proposalName) )
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD02968: Validation error ! Please try again ',
            ]);
            return false;
        }
        if($user_desig_code != MB_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD02976: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // check proposal
        foreach ($proposalIds as $singlePro)
        {
            $pro = trim($singlePro);
            $proposalCount = $this->SettlementCommonDcModel->countSettlementProposalListReCla($pro);
            if($proposalCount == 0 || $proposalCount == '')
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD02993: Proposal not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $caseCount = $this->SettlementCommonDcModel->countCasesWithProposalId($pro);
            if($caseCount != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03004: There is some cases under the Proposal, You cannot Delete ',
                ]);
                return false;
            }

            $proposalDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($pro);
            if($proposalDetails == '' || $proposalDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03015: Meeting not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $meetingDetails = $this->SettlementCommonDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
            if($meetingDetails == '' || $meetingDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03026: Meeting not found ! Kindly contact system administrator.',
                ]);
                return false;
            }

            if($meetingDetails->digital_sign_status != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03036: Meeting already processed !',
                ]);
                return false;
            }

            $checkProDeleted = $this->SettlementCommonDcModel->countSettlementProposalListDeleted($pro);
            if($checkProDeleted != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03047: Proposal already removed ! Kindly contact system administrator.',
                ]);
                return false;
            }

            $saveDelPro = array(
                'proposal_id'            => trim($proposalDetails->id),
                'dist_code'              => trim($proposalDetails->dist_code),
                'user_code'              => trim($proposalDetails->user_code),
                'status'                 => trim($proposalDetails->status),
                'proposal_status'        => trim($proposalDetails->proposal_status),
                'file_path'              => trim($proposalDetails->file_path),
                'service_code'           => trim($proposalDetails->service_code),
                'h_date'                 => trim($proposalDetails->h_date),
                'remarks'                => trim($proposalDetails->remarks),
                'ip'                     => trim($proposalDetails->ip),
                'created_at'             => trim($proposalDetails->created_at),
                'updated_at'             => trim($proposalDetails->updated_at),
                'pro_minutes'            => trim($proposalDetails->pro_minutes),
                'pro_minutes_status'     => trim($proposalDetails->pro_minutes_status),
                'created_by'             => trim($proposalDetails->created_by),
                'final_verify_status'    => trim($proposalDetails->final_verify_status),
                'subdiv_code'            => trim($proposalDetails->subdiv_code),
                'dept_status'            => trim($proposalDetails->dept_status),
                'file_minute_path'       => trim($proposalDetails->file_minute_path),
                'file_attendance_path'   => trim($proposalDetails->file_attendance_path),
                'sdlac_prceed_status'    => trim($proposalDetails->sdlac_prceed_status),
                'meeting_date'           => trim($proposalDetails->meeting_date),
                'expiry_hour_start_time' => trim($proposalDetails->expiry_hour_start_time),
                'expiry_status'          => trim($proposalDetails->expiry_status),
                'meeting_venue'          => trim($proposalDetails->meeting_venue),
                'proposal_meeting_id'    => trim($proposalDetails->proposal_meeting_id),
                'meeting_create_status'  => trim($proposalDetails->meeting_create_status),
                'proposal_name'          => trim($proposalDetails->proposal_name),
                'deleted_ip'             => $this->input->ip_address(),
                'deleted_by'             => $user_code,
                'deleted_at'             => date('Y-m-d h:i:s'),
                'deleted_remarks'        => 'There is no cases under this proposal'
            );

            $insertProInDeleted = $this->db->insert('settlement_proposal_list_deleted', $saveDelPro);
            if($insertProInDeleted != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD03094: Insertion failed in settlement_proposal_list_deleted for proposal no : ' .$pro );
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03094: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        foreach ($proposalIds as $singleProId)
        {
            $proDel = trim($singleProId);
            $deletePro = $this->SettlementCommonDcModel->deleteSettlementProposalByProId($proDel,$dist_code);
            if($deletePro != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD03110: Deletion failed in settlement_proposal_list_deleted for proposal no :'. $pro);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03110: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Proposals Successfully Removed ! You can proceeds now',
        ));
        return false;


    }



    // Bulk Revert cases from meeting to hold cases to dept
    public function bulkRevertCasesForHoldDeptCases()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $arrayM           = $this->input->post('revertCasesBulk');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');

        if (empty($arrayM))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRHDC0003846: Revert request cancelled...! cases missing ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $row_count = 0;
        foreach ($arrayM as $arrayS)
        {
            $case_no = trim($arrayS);
            $row_count++;
            $tmp_st_time = microtime(true);
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNoDeptHold($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003859: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return false;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNoReCla($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003867: Application ('.$case_no.') not found ! Kindly contact system administrator',
                ));
                return false;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNoReCla($case_no);
            if($caseDetails->status != 'O')
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003882: Application ('.$case_no.') already processed ! Kindly contact system administrator',
                ));
                return;
            }
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC00909: You cannot Revert VGR/PGR application ('.$case_no.') here ! Kindly contact system administrator',
                ));
                return false;
            }

            $getProposalID = $this->reclassPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
            $proposalId    = trim($getProposalID->proposal_id);
            if($caseDetails->pull_request != 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC02909: You cannot Revert application ('.$case_no.') here ! There is an modification request from CO',
                ));
                return false;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $user_code,
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRHDC0003933: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003933: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                ));
                return;
            }
            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRHDC0003945: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003945: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->ReclassCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003966: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }
            else
            {
                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => 'As forwarding to Department has been stopped'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRHDC0003996: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRHDC0003996: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return;
                }
            }
            log_message('error','Time taken: '.(microtime(true)-$tmp_st_time).', count='.$row_count);
        }

        $caseAppUrban    = $this->SettlementCommonModel->convertLiteral($arrayM);
        $caseAppUrbanSql = "select string_agg(applid,',') as applids from reclass_suite_basic where case_no in ($caseAppUrban)";
        $allAPICases = $this->db->query($caseAppUrbanSql)->row()->applids;

        $rmk    = 'Reverted to CO';
        $status = 'M';
        $task   = $this->session->userdata('user_desig_code');
        $pen    = MB_CIRCLE_OFFICER;
        $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulkMb3($allAPICases,'NA',$rmk,$status,$task,$pen);
        if($rtps_status!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPI104213: Issue in API Call'
                .$this->db->last_query());
            echo json_encode(array(
                'responseType' => 3,
                'message'      => '#MRAPI104213: Unable to process for final approval.
                                               Kindly contact system administration !!!',
            ));
            return false;
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Applications Successfully Reverted to CO',
        ));
        return false;


    }



    // get revert back meeting details
    public function getRevertBackMeetingDetails()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $meetingId   = $this->input->post('meetingId');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 0)
                    ->where('dc_approve_status', 0)
                    ->get('proposal_meeting_list')
                    ->row();

                if(trim($meetingDetails->vgr_pgr_status) == 1)
                {
                    // return to function getVgrPgrCasesForRevertDc
                    echo json_encode(array(
                        'responseType' => 3,
                        'meetingId'    => $meetingId,
                    ));

                    return false;
                }
                else
                {
                    echo json_encode(array(
                        'responseType'      => 2,
                        'meetingId'         => $meetingId,
                        'revertMeetingName' => $meetingDetails->meeting_name,
                        'revertBackTo'      => $meetingDetails->created_by,
                    ));

                    return;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001986: Meeting not found ! Kindly contact system administrator',
                ));
                return;
            }
        }
    }


    // update batch Query By MRIDU SIR
    public function updateBatch($table, $data, $where_filed, $where_array)
    {
        $sql = "update $table set ";
        //var_dump($data);
        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . '=\'' . $value . '\', ';
        }
        $sql = substr(trim($sql), 0, -1);
        $caseApp = $this->SettlementCommonModel->convertLiteral($where_array);
        $sql = $sql . ' where '.$where_filed.' in ('.$caseApp.')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }


    // revert back the meeting
    public function revertBackMeetingToAdcSdo()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'response' => 1,
                'message'  => '#ERMR002025: Validation error !',
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $meetingId = $this->input->post('meetingId');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 0)
                    ->where('dc_approve_status', 0)
                    ->where('meeting_type_ins', '40')
                    ->get('proposal_meeting_list')
                    ->row();


                if($meetingDetails->vgr_pgr_status == 1)
                {
                    $json = [
                        'response' => 1,
                        'message'  => '#MRVGR002509: --- You cannot revert VGR/PGR Meeting  ---',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //list of proposals against meeting id
                $getProposal = $this->SettlementMeetingDcModel->getProposalDetailAgainstMeetingIdReCla($dist_code,$meetingId);

                if($getProposal->num_rows() == 0 || $getProposal->num_rows() == '')
                {
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR002061: Proposal not found.',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $proposalDetails = $getProposal->result();
                $revertedTo = $meetingDetails->created_by;
                $proposals  = '';
                $index      = 0;
                foreach ($proposalDetails as $row)
                {
                    if ($index == 0)
                    {
                        $proposals = $proposals."'".$row->proposal_id."'";
                    }
                    else
                    {
                        $proposals = $proposals.",'".$row->proposal_id."'";
                    }
                    $index++;
                }

                $this->db->trans_begin();

                // update in settlement proceeding
                $proceeding_case=[
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => MB_DEPUTY_COMM,
                    'office_to'            => $revertedTo,
                    'task'                 => 'Reverted to '.$revertedTo,
                ];

                // update in settlement basic for recommended cases
                $final_settlement_case_rec = [
                    'status'          => MB_REVERT,
                    'pending_office'  => 'SDLAC',
                    'pending_officer' => $revertedTo,
                    'from_office'     => MB_DEPUTY_COMM,
                ];

                // update in settlement basic for not recommended cases
                $final_settlement_case_nrec = [
                    'status'          => MB_REVERT,
                    'pending_office'  => 'SDLAC',
                    'pending_officer' => $revertedTo,
                    'from_office'     => MB_DEPUTY_COMM,
                ];


                // update in settlement proposal cases for recommended cases
                $final_settlement_pro_rec_case = [
                    'case_status' => 1,
                    'status'      => PRO_CASE_STATUS_PENDING,
                ];

                // update in settlement proposal cases for  not recommended cases
                $final_settlement_pro_nrec_case = [
                    'case_status' => 2,
                    'status'      => PRO_CASE_STATUS_PENDING,
                ];

                $recomend_count    = 0;
                $notrecomend_count = 0;

                //list of proposals
                foreach($proposalDetails as $prop)
                {
                    //get cases by proposal number
                    $cases_recomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                              (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                              FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                              ON pl.case_no=t.case_no AND pl.proposal_id=?
                              AND pl.case_status=1", array($prop->proposal_id))->result();


                    // all Recommended cases
                    $recomend_count = $recomend_count + count($cases_recomend);
                    foreach($cases_recomend as $row)
                    {
                        $allAPICases[]      = $row->case_no;
                        $allAPICases_reco[] = $row->case_no;

                        // update in settlement proceeding
                        $proceeding_case['case_no']             = $row->case_no;
                        $proceeding_case['proceeding_id']       = $row->proceeding_id+1;
                        $proceeding_case['note_on_order']       = 'Reverted by DC';
                        $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                        $proceeding_case['status']              = MB_REVERT;
                        $final_proceeding_case[]                = $proceeding_case;
                    }


                    $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2", array($prop->proposal_id))->result();


                    // all Not Recommended cases
                    $notrecomend_count = $notrecomend_count + count($cases_notrecomend);
                    foreach($cases_notrecomend as $row)
                    {

                        $allAPICases[] = $row->case_no;
                        $allAPICases_nrec[] = $row->case_no;

                        // update in settlement proceeding
                        $proceeding_case['case_no']             = $row->case_no;
                        $proceeding_case['proceeding_id']       = $row->proceeding_id+1;
                        $proceeding_case['note_on_order']       = 'Reverted by DC';
                        $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                        $proceeding_case['status']              = MB_REVERT;
                        $final_proceeding_case[]                = $proceeding_case;
                    }

                }


                // batch insert into reclass_suite_basic for recommended
                if (isset($allAPICases_reco) && count($allAPICases_reco)>0)
                {
                    $update_count = $this->updateBatch('reclass_suite_basic', $final_settlement_case_rec,
                        'case_no',$allAPICases_reco);
                    if($recomend_count != $update_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002198: Updation failed in reclass_suite_basic for meeting reverted (recommended) '.$this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#MRDC002198: Meeting can not be reverted. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

                // batch insert into reclass_suite_basic for not recommended
                if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0)
                {
                    $update_count = $this->updateBatch('reclass_suite_basic', $final_settlement_case_nrec,
                        'case_no',$allAPICases_nrec );
                    if($notrecomend_count != $update_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002217: Updation failed in reclass_suite_basic for meeting reverted (not recommended) '.$this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#MRDC002217: Meeting can not be reverted. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }



                // batch update into settlement_proposal_cases for recommended
                if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
                    $update_pro_rec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_rec_case,
                        'case_no',$allAPICases_reco);
                    if ($recomend_count != $update_pro_rec_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002234: Updation failed in settlement_proposal_cases for meeting reverted (recommended) '.$this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#MRDC002234: Meeting can not be reverted. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

                // batch insert into settlement_proposal_cases for not  recommended
                if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {
                    $update_pro_nrec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_nrec_case,
                        'case_no',$allAPICases_nrec);
                    if ($notrecomend_count != $update_pro_nrec_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002253: Updation failed in settlement_proposal_cases for meeting reverted (not recommended) '.$this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#MRDC002253: Meeting can not be reverted. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }



                // batch insert into settlement_proceeding
                $insert_count = $this->db->insert_batch('settlement_proceeding',$final_proceeding_case);
                if(($recomend_count+$notrecomend_count) != $insert_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRDC002271: INSERT failed in settlement_proceeding '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#MRDC002271: Meeting can not be reverted. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }


                //update sdlac proposal list
                $updateMeetingTable = [
                    'adc_forward_to_dc_status' => 2,
                    'updated_at'               => date('Y-m-d h:i:s'),
                ];
                $this->db->where('id', $meetingId);
                $this->db->where('meeting_type_ins', '40');
                $this->db->update('proposal_meeting_list', $updateMeetingTable);

                if($this->db->affected_rows() <= 0 ){
                    $this->db->trans_rollback();
                    log_message('error', '#MRDC002293: Updation failed in proposal_meeting_list : '. $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#MRDC002293: Meeting can not be reverted. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $caseApp = $this->SettlementCommonModel->convertLiteral($allAPICases);

                $sql = "select string_agg(applid,',') as applids from reclass_suite_basic where 
                    case_no in ($caseApp)";
                $applids = $this->db->query($sql)->row()->applids;

                //api call
                $rmk    = 'DC Revert to '.$revertedTo.' for modification';
                $status = 'M';
                $task   = $this->session->userdata['user_desig_code'];
                $pen    = $revertedTo;
                $rtps_status = $this->SettlementApiModel->applicationStatusUpdateBulkMb3($applids,'NA',$rmk,$status,$task,$pen);

                if(trim($rtps_status)!='y')
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #MRDCAPI002318: Revert to '.$revertedTo.' failed case no # $applids");
                    $json = [
                        'response' => 1,
                        'message'  => '#MRDCAPI002318: Meeting can not be Revert to '.$revertedTo.', Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $this->db->trans_commit();
                $json = [
                    'response' => 2,
                    'message'  => 'Meeting ('.$meetingDetails->meeting_name.') successfully reverted to '.$revertedTo,
                ];
                echo json_encode($json);

                return false;
            }
            else
            {
                echo json_encode(array(
                    'response' => 1,
                    'message'  => '#MR000801: Meeting not found ! Kindly contact system administrator',

                ));
                return false;
            }
        }
    }


    // additional file upload
    public function postAdditionalFileUnderMeetingDc()
    {
        $this->load->library('form_validation');

        if(isset($_FILES['fileUpload']['name']))
        {
            if($_FILES['fileUpload']['name'] && $_FILES['fileUpload']['size'] && $_FILES['fileUpload']['tmp_name'])
            {

                $name = $_FILES['fileUpload']['name'];
                $size = $_FILES['fileUpload']['size'];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];

                if($name != NULL)
                {
                    if($ext == NULL)
                    {
                        $this->form_validation->set_rules('additional_doc_err','File extension','required');

                    }
                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                    {
                        $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        $this->form_validation->set_rules('additional_doc_err','Maximum 10MB file size','required');
                    }
                }
                else
                {
                    $this->form_validation->set_rules('additional_doc_err','File name','required');
                }
            }
            else
            {
                $this->form_validation->set_rules('additional_doc_err','File','required');
            }
        }

        $this->form_validation->set_rules('gurdDocType', 'Document Type', 'trim|required');
        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('meetingName', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('fileName',  'Document Name', 'required|min_length[3]|max_length[99]');
        if($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'response' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $meetingId   = $this->input->post('meetingId');
            $meetingName = $this->input->post('meetingName');
            $fileName    = $this->input->post('fileName');
            $dist_code   = $this->session->userdata('dist_code');
            $gurdDocType = $this->input->post('gurdDocType');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $_FILES['file']['name']  = $_FILES['fileUpload']['name'];
                $_FILES['file']['type']  = $_FILES['fileUpload']['type'];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'];
                $_FILES['file']['size']  = $_FILES['fileUpload']['size'];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $this->db->trans_begin();

                    if(trim($gurdDocType) == 1)
                    {
                        $upMeeting = [
                            'signed_minute' => $gurdDocType
                        ];

                        $this->db->where('id', $meetingId);
                        $this->db->where('dist_code', $dist_code);
                        $this->db->update('proposal_meeting_list', $upMeeting);
                        if($this->db->affected_rows() !=1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMRDOC0033799: Updation failed in proposal_meeting_list '
                                .$this->db->last_query());
                            echo json_encode(array(
                                'response' => 1,
                                'message' => 'ERMRDOC0033799: There is some problem, Please try again',
                            ));
                            return;
                        }
                    }


                    $document= array(
                        'case_no'    => $meetingName,
                        'file_name'  => $fileName,
                        'user_code'  => $this->session->userdata('user_code'),
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => UPLOAD_DIR. $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'DC',
                        'fetch_file_name' => $fileName,
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERMRDOC003370: Insertion failed in supportive document Meeting Name '.$meetingName);
                        echo json_encode(array(
                            'response' => 1,
                            'message' => 'ERMRDOC003370: There is some problem, Please try again',
                        ));
                        return;
                    }

                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMRDOC003382: Insertion failed in supportive document Meeting Name '.$meetingName);
                    echo json_encode(array(
                        'response' => 1,
                        'message' => 'ERMRDOC003382: There is some problem, Please try again',
                    ));
                    return;
                }

                $this->db->trans_commit();
                echo json_encode(array(
                    'response' => 2,
                    'message' => 'Additional document successfully uploaded',
                ));
                return;
            }
            else
            {
                echo json_encode(array(
                    'response' => 1,
                    'message' => 'ERMRDOC003399: Meeting not found !',
                ));
                return;
            }
        }
    }




    // *****  RESIGN DIGITAL MINUTES ****** ///

    // All Pending Meeting for Digital Resigning
    public function getAllPendingMeetingForDigitalResigning()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_update_status', 1);
        $this->db->where('proposal_meeting_list.dc_approve_status', 1);
        $this->db->where('proposal_meeting_list.mb_status', 0);
        $this->db->where('proposal_meeting_list.nc', 0);
        $this->db->where('proposal_meeting_list.meeting_type_ins', '40');
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();

        $data['meetingCount'] = $total_records;
        $data['meetings']     = $meetings;

        $data['_view'] = 'reclass_suite/Dc/pending_meeting_for_digital_resigning';

        $this->load->view('layouts/main', $data);
    }


    // get all Digital Resigning proposal under selected meeting
    public function getResigningProposalsAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting = $this->ReclassSuiteMeetingDcModel->getPendingMeetingDetailByMeetingID(
            $meetingId)->row();
        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingApprovedLandPage");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,
            $meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->ReclassSuiteMeetingDcModel->sdlacMemberReportDetail($dist_code,
            $meetingId)->result();

        $additionalDoc = $this->SettlementCommonDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'reclass_suite/Dc/pending_resigning_proposals_against_meeting_id';

        $this->load->view('layouts/main', $data);
    }


    // generate Resign Digital Minutes for Dc
    public function generateResignDigitalMinutesDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingId');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 1)
                ->where('digital_sign_update_status', 1)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $proposals = $this->db->select('id,proposal_name')
                    ->where('proposal_meeting_id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->get('settlement_proposal_list')
                    ->result();

                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 1)
                    ->where('digital_sign_update_status', 1)
                    ->where('meeting_type_ins', '40')
                    ->get('proposal_meeting_list')
                    ->row();

                $createdBy = $meetingDetails->user_code;


                $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName  = substr($districtName->locname_eng, 0, 3);
                $memoName     = $distEngName.'/MEMO/'.date('Y', strtotime($meetingDetails->meeting_date)).'/'.$meetingId;
                $allProposalCases = $this->generateProposalCases($proposals,$meetingId);
                $caseList   = $allProposalCases['final_result_array_rec'];
                $caseDivNot = $allProposalCases['final_result_array_not_rec'];

                $subDivArray = [];
                if (!empty($caseList) && is_array($caseList))
                {
                    foreach ($caseList as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }
                else
                {
                    foreach ($caseDivNot as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }

                $uniqueArraySub = array_unique($subDivArray);

                $subdivNameArray = [];
                foreach ($uniqueArraySub as $singleSub)
                {
                    $subdivNameOnly    = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$singleSub);
                    $subdivNameArray[] = $subdivNameOnly->locname_eng;
                }


                $subdiv_name = '';
                $indexN = 0;
                $ii = count($subdivNameArray);
                foreach ($subdivNameArray as $div)
                {
                    $indexN++;
                    if ($indexN == $ii)
                    {
                        $subdiv_name = $subdiv_name.trim($div);
                    }
                    else
                    {
                        $subdiv_name = $subdiv_name.trim($div). ", ";
                    }
                }

                $sdlacReport = $this->ReclassSuiteMeetingDcModel->sdlacMemberReportDetailOnlyUserCode($dist_code,
                    $meetingId)->result();

                $allSelectedMember = [];
                $commMembers = [];
                foreach ($sdlacReport as $member)
                {
                    $allSelectedMember[]= $member->sdlac_member_code;
                }
                $allMembers = $this->SettlementCommonDcModel->getMembersFromUsers($this->session->userdata('dist_code'));
                foreach ($allMembers as $mem)
                {
                    if(in_array($mem->user_code,$allSelectedMember))
                    {
                        $commMembers[] = $mem;
                    }
                }

                $subDivCode      = $meetingDetails->subdiv_code;
                $createdUserCode = $meetingDetails->user_code;
                $user_desig_code = $meetingDetails->created_by;

                $userDlc      = $this->SettlementCommonDcModel->getUsersDLCCopyTo($dist_code, $user_desig_code,$createdUserCode);
                $userDlcCount = $userDlc->num_rows();
                $userDlcList  = $userDlc->result();
                if($userDlcCount == 0)
                {
                    $json = [
                        'responseType' => 1,
                        'message'      => 'Minutes Copy to Members are incomplete ! Kindly Contact '. $meetingDetails->created_by. ' to Add Members For Minutes Copy To For DLC',
                    ];
                    echo json_encode($json);
                    return false;
                }
                else
                {


                    echo json_encode(array(
                        'responseType' => 2,
                        'meetingId' => $meetingId,
                        'meetingName' => $meetingDetails->meeting_name,
                        'memoName' => $memoName,
                        'districtName' => $districtName->locname_eng,
                        'subDivName' => $subdiv_name,
                        'meetingDate' => date("F j, Y", strtotime($meetingDetails->meeting_date)),
                        'timing' => strtoupper(date("h:i a", strtotime($meetingDetails->meeting_date))),
                        'meetingVenue' => $meetingDetails->meeting_venue,
                        'nominee' => $commMembers,
                        'caseList' => $caseList,
                        'caseDivNot' => $caseDivNot,
                        'proposalDetails' => $proposals,
                        'userDlcList' => $userDlcList,
                        'userDlcCount' => $userDlcCount,
                        'reservationDetails' => ''
                    ));

                    return;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR000801: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }


    // Verify Area For Resign Minutes
    public function verifyAreaForResignMinutes()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => 'Meeting ID cannot be null',
            ));
            return;
        }
        $dist_code  = $this->session->userdata('dist_code');
        $meetingId  = trim($this->input->post('meetingId'));
        $errorArray = array();
        $pullArray  = array();
        $checkMeeting = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 1)
            ->where('digital_sign_update_status', 1)
            ->where('dc_approve_status', 1)
            ->where('meeting_type_ins', '40')
            ->get('proposal_meeting_list')
            ->num_rows();
        if($checkMeeting != 1)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

            ));
            return;
        }

        $count_mridu = 0;
        $final_st_time = microtime(true);
        $errorProArray = array();
        $errorProId    = array();

        //get list of proposals
        $getProposalsList = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();
        foreach($getProposalsList as $prop)
        {
            $final_prop_st_time = microtime(true);

            $proposal_no  = $prop->proposal_id;
            $proposalDetails = $this->ReclassSuiteMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
            $final_verify_status = trim($proposalDetails->final_verify_status);

            if($final_verify_status == 0 || $final_verify_status == 1)
            {
                log_message('error', '#MR0001147: Validation issue. Verification pending at SDO/ADC');
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MR0001147: Unable to process, Verification pending at SDO/ADC. 
                            Kindly contact system administrator !!!!',
                ));
                return;
            }
            if($final_verify_status == 2)
            {
                $pendingCase = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                $caseCount   = $pendingCase->num_rows();
                if($caseCount == 0)
                {
                    $errorProArray[] = $proposalDetails->proposal_name;
                    $errorProId[]    = $proposalDetails->id;
                }
                else
                {
                    continue;
                }

                $cases = $pendingCase->result();
                foreach ($cases as $case)
                {
                    $count_mridu++;
                    $st_time = microtime(true);
                    $case_no = trim($case->case_no);

                    $pullCheck = $this->reclassPullModel->getSettlementBasicDetails($case_no);
                    log_message('error','case_count: '.$count_mridu.', time taken='.(microtime(true)-$st_time));

                    if($pullCheck->pull_request == 1)
                    {
                        $pullArray[] = $case_no;
                    }
                    if($pullCheck->pull_request == 0)
                    {
                        continue;
                    }
                }
            }

            log_message('error','Time for single proposal: '.$proposal_no.', time taken='.(microtime(true)-$final_prop_st_time));
        }

        log_message('error','FINAL_TIME: , time taken='.(microtime(true)-$final_st_time));


        if(count($errorArray) > 0 OR count($pullArray) > 0)
        {
            $case_str  = '';
            $case_pull = '';
            foreach ($errorArray as $err)
            {
                $case_str = $case_str.$err.',';
            }
            foreach ($pullArray as $pull)
            {
                $case_pull = $case_pull.$pull.',';
            }

            $errorShow = '';
            if($case_pull != NULL && $case_str == NULL)
            {
                $errorShow = 'There is modification request for  
                                  (Case No. -  '.$case_pull .')';
            }
            else if($case_str != NULL && $case_pull == NULL)
            {
                $errorShow = 'Total Area Recommended for Settlement can’t exceed available Area in Chitha
                                  (Case No. -  '.$case_str .')';
            }
            else
            {
                $var1 = 'Total Area Recommended for Settlement can’t exceed available Area in Chitha
                            (Case No. -  '.$case_str.')';
                $var2 = 'There is modification request for  
                                  (Case No. -  '.$case_pull .')';

                $errorShow = $var1.'<br>'.$var2;
            }
            log_message('error', '#MR0003166: '.$errorShow .') !');
            echo json_encode(array(
                'responseType' => 101,
                'message'      => '#MR0003166: Unable to process for Resign Digital Minutes .'.$errorShow.' !!!',
            ));
            return;
        }

        // check for zero cases under proposal
        if(count($errorProArray) > 0 OR count($errorProArray) > 0)
        {
            $error_pro_zero_cases = '';
            foreach ($errorProArray as $errorPro)
            {
                $error_pro_zero_cases = $error_pro_zero_cases.$errorPro.',';
            }
            log_message('error', '#MRNP01162: There is no case under proposal '.$error_pro_zero_cases);
            echo json_encode(array(
                'responseType' => 102,
                'message'      => $error_pro_zero_cases,
                'proIds'       => $errorProId,
            ));
            return;

        }

        echo json_encode(array(
            'responseType' => 2,
            'message'      => '#SUCCESS1290: Verifying Process completed  !!',
        ));
        return;
    }


    // digital Resign and save the pdf
    public function digitalResignAndSavePdf()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingIdDigital', 'Meeting Name', 'trim|required');

        ini_set("pcre.backtrack_limit", "50000000");

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingIdDigital');
            $html1       = base64_decode($this->input->post('html1'));
            $html2       = $this->input->post('html2');
            $html3       = $this->input->post('html3');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 1)
                ->where('digital_sign_update_status', 1)
                ->where('dc_approve_status', 1)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();


            if($checkMeeting == 1)
            {
                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 1)
                    ->where('digital_sign_update_status', 1)
                    ->where('dc_approve_status', 1)
                    ->where('meeting_type_ins', '40')
                    ->get('proposal_meeting_list')
                    ->row();

                $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName = substr($dist_name->locname_eng, 0, 3);
                $fileName    = $distEngName.'_DLC_RE_'.$dist_code.'_'.date('Y', strtotime($meetingDetails->meeting_date)).'_'.$meetingId;
                $timeUpdate  = '_'.date('YmdHiss');

                $nn = explode('/',$meetingDetails->encode_pdf_dir_path);
                $kk = count($nn);
                $jj = $nn[$kk-1];
                $lastString = explode('.', $jj);
                $lastFileName = $lastString[0];


                $updateFileName = SIGNPDF_UPLOAD_DIR.$lastFileName.$timeUpdate.'.pdf';
                $oldFileName    = SIGNPDF_UPLOAD_DIR.$lastFileName.'.pdf';
                rename($oldFileName,$updateFileName);

                // Mriganka da's code here
                include 'vendor/mpdf/vendor/autoload.php';
                $mpdf=new \Mpdf\Mpdf();
                if(MB3_DIGITAL_SIGN_DRAFT_MODE == 1)
                {
                    $waterMark = 'Mission Basundhara 3.0';
                }
                else
                {
                    $waterMark = 'DRAFT';
                }

                $mpdf->SetWatermarkText($waterMark);
                $mpdf->showWatermarkText = true;
                $mpdf->autoScriptToLang = true;
                $mpdf->autoLangToFont = true;

                $html ="<style>                   
                    .reza-title{
                        font-weight: bold;
                        font-size: 16px;
                        padding: 20px;
                    }                                
                    .rezaText {
                        font-size: 14px;
                    }
                    .divCard {
                        background: #fff;
                        border-radius: 2px;
                        display: inline-block;
                        position: relative;
                        width: 100%;
                    }
                    .mrigankaCenter{
                        text-align: center!important;
                    }                    
                    .mrigankaRight{
                        text-align: right!important;
                        margin-top: 40px;
                    }
                    .rezaText2 {
                        font-size: 14px!important;
                        margin: 20px!important;
                        text-align: center;
                    }
                   
                   
                </style>";
                $mpdf->writeHTML($html1.$html);
                $mpdf->AddPage();
                $mpdf->writeHTML($html2.$html);
                $mpdf->AddPage();
                $mpdf->writeHTML($html3.$html);
                $mpdf->Output(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf','F');
                $b64Doc = chunk_split(base64_encode(file_get_contents(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf')));

                echo json_encode(array(
                    'responseType' => 2,
                    'meetingId'    => $meetingId,
                    'base64pdfData' => $b64Doc,
                ));

                return;

            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR0001087: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }


    // Resigned final update status meeting by DC
    public function resignedFinalUpdatedMeetingByDC()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $meetingId = trim($this->input->post('meetingId'));
            $pdfData   = $this->input->post('pdfData');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 1)
                ->where('digital_sign_update_status', 1)
                ->where('dc_approve_status', 1)
                ->where('meeting_type_ins', '40')
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->where('adc_forward_to_dc_status', 1)
                    ->where('digital_sign_status', 1)
                    ->where('digital_sign_update_status', 1)
                    ->where('dc_approve_status', 1)
                    ->where('meeting_type_ins', '40')
                    ->get('proposal_meeting_list')
                    ->row();

                $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName = substr($dist_name->locname_eng, 0, 3);
                $fileName    = $distEngName.'_DLC_RE_'.$dist_code.'_'.date('Y', strtotime($meetingDetails->meeting_date)).'_'.$meetingId;

                $base64PDFData = $pdfData;
                $uploadpath    = SIGNPDF_UPLOAD_DIR;
                file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));
                $updateMeetingID = array(
                    'encode_pdf_dir_path'        => $uploadpath.$fileName.".pdf",
                    'digital_sign_update_status' => 0,
                    'digital_resign_date'        => date('Y-m-d H:i:s')
                );
                $this->db->where(['id' => $meetingId, 'dist_code' => $dist_code, 'meeting_type_ins'=>'40']);
                $this->db->update('proposal_meeting_list', $updateMeetingID);
                if($this->db->affected_rows() <=  0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR1273: Updation failed in proposal_meeting_list '.
                        $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#ERR1273: Unable to process for Resigning. 
                                        Kindly contact system administrator !!!!',
                    ));
                    return;
                }

                $this->db->trans_commit();

                echo json_encode(array(
                    'responseType' => 2,
                    'message'      => '#SUCCESS1290: Resigning Process Successfully Done !!',
                ));
                return;
            }
            else
            {

                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }


    // delete proposal with zero cases
    public function deleteProposalWithZeroCasesByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalIds     = $this->input->post('proposalIds');
        $proposalName    = $this->input->post('proposalName');
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if (empty($proposalIds) || empty($proposalName) )
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD04312: Validation error ! Please try again ',
            ]);
            return false;
        }
        if($user_desig_code != MB_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD04320: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // check proposal
        foreach ($proposalIds as $singlePro)
        {
            $pro = trim($singlePro);
            $proposalCount = $this->ReclassSuiteMeetingDcModel->countSettlementProposalList($pro);
            if($proposalCount == 0 || $proposalCount == '')
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04333: Proposal not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $caseCount = $this->SettlementCommonDcModel->countCasesWithProposalId($pro);
            if($caseCount != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04343: There is some cases under the Proposal, You cannot Delete ',
                ]);
                return false;
            }

            $proposalDetails = $this->ReclassSuiteMeetingDcModel->getProposalDetailsByProId($pro);
            if($proposalDetails == '' || $proposalDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04353: Meeting not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $meetingDetails = $this->ReclassSuiteMeetingDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
            if($meetingDetails == '' || $meetingDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04363: Meeting not found ! Kindly contact system administrator.',
                ]);
                return false;
            }

            if($meetingDetails->digital_sign_status != 1 || $meetingDetails->digital_sign_update_status != 1)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04372: Meeting already processed !',
                ]);
                return false;
            }

            $checkProDeleted = $this->SettlementCommonDcModel->countSettlementProposalListDeleted($pro);
            if($checkProDeleted != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04391: Proposal already removed ! Kindly contact system administrator.',
                ]);
                return false;
            }

            $saveDelPro = array(
                'proposal_id'            => trim($proposalDetails->id),
                'dist_code'              => trim($proposalDetails->dist_code),
                'user_code'              => trim($proposalDetails->user_code),
                'status'                 => trim($proposalDetails->status),
                'proposal_status'        => trim($proposalDetails->proposal_status),
                'file_path'              => trim($proposalDetails->file_path),
                'service_code'           => trim($proposalDetails->service_code),
                'h_date'                 => trim($proposalDetails->h_date),
                'remarks'                => trim($proposalDetails->remarks),
                'ip'                     => trim($proposalDetails->ip),
                'created_at'             => trim($proposalDetails->created_at),
                'updated_at'             => trim($proposalDetails->updated_at),
                'pro_minutes'            => trim($proposalDetails->pro_minutes),
                'pro_minutes_status'     => trim($proposalDetails->pro_minutes_status),
                'created_by'             => trim($proposalDetails->created_by),
                'final_verify_status'    => trim($proposalDetails->final_verify_status),
                'subdiv_code'            => trim($proposalDetails->subdiv_code),
                'dept_status'            => trim($proposalDetails->dept_status),
                'file_minute_path'       => trim($proposalDetails->file_minute_path),
                'file_attendance_path'   => trim($proposalDetails->file_attendance_path),
                'sdlac_prceed_status'    => trim($proposalDetails->sdlac_prceed_status),
                'meeting_date'           => trim($proposalDetails->meeting_date),
                'expiry_hour_start_time' => trim($proposalDetails->expiry_hour_start_time),
                'expiry_status'          => trim($proposalDetails->expiry_status),
                'meeting_venue'          => trim($proposalDetails->meeting_venue),
                'proposal_meeting_id'    => trim($proposalDetails->proposal_meeting_id),
                'meeting_create_status'  => trim($proposalDetails->meeting_create_status),
                'proposal_name'          => trim($proposalDetails->proposal_name),
                'deleted_ip'             => $this->input->ip_address(),
                'deleted_by'             => $user_code,
                'deleted_at'             => date('Y-m-d h:i:s'),
                'deleted_remarks'        => 'There is no cases under this proposal'
            );

            $insertProInDeleted = $this->db->insert('settlement_proposal_list_deleted', $saveDelPro);
            if($insertProInDeleted != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD04439: Insertion failed in settlement_proposal_list_deleted for proposal no : ' .$pro );
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04439: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        foreach ($proposalIds as $singleProId)
        {
            $proDel = trim($singleProId);
            $deletePro = $this->ReclassSuiteMeetingDcModel->deleteSettlementProposalByProId($proDel,$dist_code);
            if($deletePro != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD04455: Deletion failed in settlement_proposal_list_deleted for proposal no :'. $pro);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04455: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Proposals Successfully Removed ! You can resign the minutes now',
        ));
        return false;


    }

    ////////////// Digital Re-Signing ///////////////////////




    //MB:=================REVERTED LIST OF MEETING=======BY DEPARTMENT==11102023

    // reverted meeting list by dept
    public function revertedMeetingByDepartmentForDC()
    {
        $dist_code = $this->session->userdata('dist_code');

        $sqlForRevertList = "select distinct pml.meeting_name,pml.signed_minute,pml.id as
                                meeting_id,pml.meeting_venue,pml.meeting_date from reclass_suite_basic sb  
                                join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                join settlement_proposal_list spl on spc.proposal_id = spl.id
                                join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                    where sb.dist_code=? and sb.dept_revert=? 
                                    and sb.pending_officer=? and sb.from_office=? 
                                    and sb.service_code='40'";
        $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,MB_DEPUTY_COMM,MB_DEPARTMENT));
        $total_records = $query1->num_rows();
        $meetings      = $query1->result();
        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'reclass_suite/Dc/reverted_meeting_list_by_department_dc';

        $this->load->view('layouts/main', $data);
    }


    // get all  reverted proposal under selected meeting
    public function getRevertedProposalsAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting = $this->SettlementMeetingDcModel->getPendingMeetingDetailByMeetingIDReCla($meetingId)->row();
        $meetingName = trim($meeting->meeting_name);

        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/revertedMeetingByDepartmentForDC");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->SettlementMeetingDcModel->getProposalDetailAgainstMeetingIdReCla($dist_code,
            $meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->ReclassSuiteMeetingDcModel->sdlacMemberReportDetail($dist_code,
            $meetingId)->result();

        $additionalDoc = $this->SettlementCommonDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'reclass_suite/Dc/reverted_dept_proposals_against_meeting_id';

        $this->load->view('layouts/main', $data);
    }


    // reverted cases under meeting list by dept
    public function getRevertedCasesDeptAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        if($meetingId == null)
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/revertedMeetingByDepartmentForDC");
        }

        $dist_code = $this->session->userdata('dist_code');
        $meeting = $this->SettlementMeetingDcModel->getPendingMeetingDetailByMeetingIDReCla($meetingId)->row();
        $meetingName = null;
        if(!empty($meeting) && $meeting != null)
        {
            $meetingName = trim($meeting->meeting_name);
            if($meetingName == '')
            {
                $this->session->set_flashdata('error', "Meeting Not Found !");
                redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/revertedMeetingByDepartmentForDC");
            }
        }
        else
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/revertedMeetingByDepartmentForDC");
        }
        $data['meetingName'] = $meetingName;
        $data['meeting_id'] = $meetingId;

        $sqlForRevertList = "select distinct sb.case_no, sb.service_code,(select note_on_order from settlement_proceeding sp where sp.case_no = sb.case_no 
                             and office_from=? and office_to =? and status=? order by id desc limit 1) as note_on_order from reclass_suite_basic sb  
                             join settlement_proposal_cases spc on sb.case_no = spc.case_no
                             join settlement_proposal_list spl on spc.proposal_id = spl.id
                             join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                             where sb.dist_code=? and sb.dept_revert=? and pml.id =? and meeting_name = ? 
                             and sb.pending_officer = ?  and sb.service_code='40'";
        $query1 = $this->db->query($sqlForRevertList,array(MB_DEPARTMENT,MB_DEPUTY_COMM,'R',$dist_code,1,$meetingId,$meetingName,MB_DEPUTY_COMM));
        $total_records = $query1->num_rows();
        $caselist      = $query1->result();

        $data['caseCount'] = $total_records;
        $data['caselist'] = $caselist;

        $data['_view'] = 'reclass_suite/Dc/reverted_cases_by_department_dc';

        $this->load->view('layouts/main', $data);
    }


    // reverted case array
    public function getAllDeptRevertedCases()
    {
        $dist_code = $this->session->userdata('dist_code');
        $meeting_id = trim($this->input->post('meeting_id'));
        $meeting_name = trim($this->input->post('meeting_name'));
        if($meeting_name== null || $meeting_id == null){
            echo json_encode(array('responseType' => 3,'select_cases' => null));
            return;
        }
        $sqlForRevertList = "select string_agg(distinct sb.case_no::text, ',') from reclass_suite_basic sb  
                                join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                join settlement_proposal_list spl on spc.proposal_id = spl.id
                                join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                    where sb.dist_code=? and sb.dept_revert=? 
                                    and sb.pending_officer=? and sb.from_office=? and pml.id =? and meeting_name = ?
                                    and sb.service_code='40'";
        $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,MB_DEPUTY_COMM,MB_DEPARTMENT,$meeting_id,$meeting_name));
        if(!empty($query1->row()))
        {
            $cases = $query1->row()->string_agg;
            if($cases == null)
            {
                echo json_encode(array('responseType' => 3,'select_cases' => null));
                return;
            }
            else
            {
                echo json_encode(array('responseType' => 2,'select_cases' => $cases));
                return;
            }
        }
        else
        {
            echo json_encode(array('responseType' => 3,'select_cases' => null));
            return;
        }
    }


    // final revert case to CO by DC for dept reverted case by MR
    public function finalDeptRevertedCaseRevertToCO()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseListRevert', 'Case Number', 'required');
        $this->form_validation->set_rules('meetingIdNew', 'Meeting ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('dcRevertedRemarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#MRBR0003772: Revert request cancelled...! Validation Error ',
            ));
            return;
        }
        else
        {
            $dist_code  = $this->session->userdata('dist_code');
            $meeting_id = trim($this->input->post('meetingIdNew'));
            $user_code  = $this->session->userdata('user_code');
            $caseListRevert  = $this->input->post('caseListRevert');
            $revertRemarks   = trim($this->input->post('dcRevertedRemarks'));
            $user_desig_code = $this->session->userdata('user_desig_code');

            if(empty($caseListRevert))
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRBR0003789: Revert request cancelled...! cases missing ',
                ]);
                return false;
            }

            $sqlForRevertList = "select distinct sb.case_no from reclass_suite_basic sb  
                                 join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                 join settlement_proposal_list spl on spc.proposal_id = spl.id
                                 join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                 where sb.dist_code=? and sb.dept_revert=? 
                                 and sb.pending_officer=? and sb.from_office=? and pml.id =? and sb.service_code='40'";
            $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,MB_DEPUTY_COMM,MB_DEPARTMENT,$meeting_id));
            $arrayM = $query1->result();

            $meetingDetails  = $this->reclassPullModel->getMeetingDetailByMeetingIDPull(trim($meeting_id));
            if($meetingDetails->digital_sign_status != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003800: Revert request cancelled..! Kindly contact system administrator',
                ));
                return false;
            }

            $this->db->trans_begin();
            $row_count = 0;
            $caseArray = [];
            foreach ($arrayM as $arrayS)
            {
                $case_no = $arrayS->case_no;
                $caseArray[] = $arrayS->case_no;
                $row_count++;
                $tmp_st_time = microtime(true);
                if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no) != 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003814: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                    ));
                    return false;
                }
                if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNoReCla($case_no) != 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003824: Application ('.$case_no.') not found ! Kindly contact system administrator',
                    ));
                    return false;
                }

                $caseDetails = $this->ReclassCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
                if($caseDetails->status != MB_REVERT)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003835: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                    ));
                    return;
                }
                if($caseDetails->dept_revert != 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003844: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                    ));
                    return;
                }

                $getProposalID = $this->SettlementCommonDcModel->getSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no);
                $proposalId    = trim($getProposalID->proposal_id);
                $checkReqMod   = 0;
                if($caseDetails->pull_request != 0)
                {
                    $requested = $this->reclassPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                    if($requested->num_rows() == 0)
                    {
                        $checkReqMod = 0;
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#MRBR0003961: Application ('.$case_no.') not found in Modification Request ! Kindly contact system administrator',
                        ]);
                        return false;
                    }
                    $requestedData = $requested->row();
                    $checkReqMod   = 1;
                }

                $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                $insertIntoDeletedTable = array(
                    'proposal_id' => $proposalId,
                    'case_no'     => $deleteCase->case_no,
                    'status'      => $deleteCase->status,
                    'ip'          => $deleteCase->ip,
                    'created_at'  => $deleteCase->created_at,
                    'updated_at'  => $deleteCase->updated_at,
                    'co_submit'   => $deleteCase->co_submit,
                    'deleted_by'  => $this->session->userdata('user_code'),
                );

                $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                if($insertDeleteData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003988: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003988: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return;
                }
                $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if($deleteProCase != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003900: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003900: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                    ));
                    return false;
                }

                $updateData = array(
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => $user_desig_code,
                    'dc_proceeding'   => 0,
                    'pull_request'    => 0,
                    'dept_revert'     => 2,
                );
                if($this->ReclassCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003918: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                    ));
                    return false;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no'         => $case_no,
                        'proceeding_id'   => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'      => MB_REVERT,
                        'user_code'   => $this->session->userdata('user_code'),
                        'date_entry'  => date('Y-m-d h:i:s'),
                        'operation'   => 'E',
                        'ip'          => $this->utilityclass->get_client_ip(),
                        'office_from' => $user_desig_code,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO',
                        'note_on_order' => $revertRemarks
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0003952: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003952: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                        ));
                        return;
                    }
                    else
                    {
                        if($checkReqMod == 1)
                        {
                            $updateReq = [
                                'final_status'     => MODIFICATION_REQUEST_APPROVED,
                                'approved_by'      => $user_desig_code,
                                'approved_by_uc'   => $user_code,
                                'approve_date'     => date('Y-m-d H:i:s'),
                                'approved_remarks' => $revertRemarks,
                                'pending_request_officer' => '',
                            ];

                            $this->db->where('id',$requestedData->id);
                            $this->db->update('settlement_pull_request',$updateReq);
                            if($this->db->affected_rows() !=1){
                                log_message('error', '#MRBR0003978: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                                $this->db->trans_rollback();
                                echo json_encode([
                                    'responseType' => 1,
                                    'message' => '#MRBR0003978:  Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                ]);
                                return false;
                            }

                            $insPetProceed = [
                                'case_no'              => $case_no,
                                'proceeding_id'        => $proceeding_id + 1,
                                'date_of_hearing'      => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                'note_on_order' => $revertRemarks,
                                'status'        => 'MR',
                                'user_code'     => $this->session->userdata('user_code'),
                                'date_entry'    => date('Y-m-d h:i:s'),
                                'operation'     => 'E',
                                'ip'            => $this->utilityclass->get_client_ip(),
                                'office_from'   => $user_desig_code,
                                'office_to'     => MB_CIRCLE_OFFICER,
                                'task'          => 'Modification Request Accepted'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if ($insertProceeding != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#MRBR0004006: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                echo json_encode([
                                    'responseType' => 1,
                                    'message' => '#MRBR0004006: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                ]);
                                return false;
                            }
                        }
                    }
                }
            }


            // update meeting
            $updateMeetingID = array(
                'digital_sign_update_status' => 1,
            );
            $this->db->where(['id' => $meeting_id, 'dist_code' => $dist_code,'meeting_type_ins' => '40']);
            $this->db->update('proposal_meeting_list', $updateMeetingID);
            if($this->db->affected_rows() <=  0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRBR0004040: Updation failed in proposal_meeting_list '.$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MRBR0004040: Unable to update status for Resigning. 
                                        Kindly contact system administrator !!!!',
                ));
                return;
            }

            if (isset($caseArray) && count($caseArray)>0)
            {
                $caseAppUrban = $this->SettlementCommonModel->convertLiteral($caseArray);
                $caseAppUrbanSql = "select string_agg(applid,',') as applids from reclass_suite_basic where case_no in ($caseAppUrban)";
                $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

                $rmk    = 'Reverted to CO';
                $status = 'M';
                $task   = $this->session->userdata('user_desig_code');
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulkMb3($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
                if($rtps_status!="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRAPI104042: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 3,
                        'message'      => '#MRAPI104042: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                    ));
                    return;
                }
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message'  => 'Application Successfully Reverted to CO. ! You have resign this meeting '.($meetingDetails->meeting_name),
            ));
            return false;
        }
    }

    //MB:=================REVERTED LIST OF MEETING=======BY DEPARTMENT==11102023





    // pull back dept pending cases
    public function pullBackCasesFromDepartmentForDC()
    {

        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->ReclassCommonDcModel->getLocationName($dist_code);
        $location          = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'reclass_suite/Dc/pull_back_cases_from_dept';
        $this->load->view('layouts/main', $data);

    }


    // Ajax for pull back case list
    public function pullBackCasesWithDeptPaginationAPI()
    {
        $service       = RECLASS_ID;
        $by_case_no    = trim($this->input->post('case_no'));
        $remark_cat    = trim($this->input->post('remark_cat'));
        $remark_cat_lm = trim($this->input->post('remark_cat_lm'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subDiv_code   = trim($this->input->post('subdiv'));
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = trim($this->session->userdata('user_desig_code'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }

        if($order != null){
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)){
            $this->db->where('reclass_suite_basic.cir_code', $cir_code);
        }
        if(!empty($village)){
            $this->db->where('reclass_suite_basic.vill_townprt_code', $village);
            $this->db->where('reclass_suite_basic.subdiv_code', $subDiv_code);
            $this->db->where('reclass_suite_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('reclass_suite_basic.lot_no', $lot_no);
            $this->db->where('reclass_suite_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('reclass_suite_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)){
            $this->db->where('reclass_suite_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)){
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->join('settlement_ap_lmnote', 'reclass_suite_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('reclass_suite_basic.service_code', $service);
        $this->db->where('reclass_suite_basic.dist_code', $dist_code);
        $this->db->where('reclass_suite_basic.status', MB_PENDING);
        $this->db->where("(reclass_suite_basic.add_cases_to_memo != 'Y' OR reclass_suite_basic.add_cases_to_memo IS NULL)", NULL, false);
        $this->db->where('reclass_suite_basic.pending_officer', 'DPT');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('reclass_suite_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('reclass_suite_basic.vill_townprt_code', $village);
                $this->db->where('reclass_suite_basic.subdiv_code', $subDiv_code);
                $this->db->where('reclass_suite_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('reclass_suite_basic.lot_no', $lot_no);
                $this->db->where('reclass_suite_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('reclass_suite_basic.case_no', $by_case_no);
            }
            if(!empty($remark_cat)){
                $this->db->where('reclass_suite_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('reclass_suite_basic');
            $this->db->join('settlement_ap_lmnote', 'reclass_suite_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('reclass_suite_basic.service_code', $service);
            $this->db->where('reclass_suite_basic.dist_code', $dist_code);
            $this->db->where('reclass_suite_basic.status', MB_PENDING);
            $this->db->where("(reclass_suite_basic.add_cases_to_memo != 'Y' OR reclass_suite_basic.add_cases_to_memo IS NULL)", NULL, false);
            $this->db->where('reclass_suite_basic.pending_officer', 'DPT');
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $co_remark ='';
                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                    if($rows->co_note_yn == $co_remark_cat->CODE){
                        $co_remark = $co_remark_cat->NAME;
                    }
                }
                $lm_remark ='';
                foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                    if($rows->lm_note == $lm_remark_cat->CODE){
                        $lm_remark = $lm_remark_cat->NAME;
                    }
                }

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $lm_remark,

                    $co_remark,

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn rezaButt" target="_blank" href="'.base_url().'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case='.$rows->case_no.'">  VIEW
                    </a>
                        
                    <button class="btn rezaButt buttPrimary pullBackCasesModal" data-id='.$rows->case_no.'  style="margin-top: 10px">  PULL BACK
                    </button>'

                );

                $i++;
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    // get revert back meeting details
    public function getPullBackCaseDetails()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $appId     = trim($this->input->post('meetingId'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', RECLASS_ID)
                ->where('status', 'W')
                ->where('pending_officer', 'DPT')
                ->where("(add_cases_to_memo != 'Y' OR add_cases_to_memo IS NULL)", NULL, false)
                ->get('reclass_suite_basic')
                ->num_rows();


            if($checkCase == 1)
            {

                $result = $this->db->query("select b.proposal_name, c.meeting_name from settlement_proposal_cases a
	                              join settlement_proposal_list b on b.id=a.proposal_id
	                              join proposal_meeting_list c on c.id=b.proposal_meeting_id
	                              where a.case_no=?",
                    array($appId));

                $meetingDetails = $result->row();

                if (!empty($meetingDetails))
                {
                    echo json_encode(array(
                        'responseType'       => 2,
                        'meetingId'          => $appId,
                        'caseNumber'         => $appId,
                        'revertMeetingName'  => $meetingDetails->meeting_name,
                        'revertProposalName' => $meetingDetails->proposal_name,
                    ));

                    return;
                }
                else
                {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MR0001991: Meeting not found ! Kindly contact system administrator',
                    ));
                    return;
                }

            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return;
            }
        }
    }


    // final pull back submit & revert back to co
    public function finalPullBackRevertToCoSubmit()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();

            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#ERMR002025: Validation error ! ' .$errors,
            ));
            return;
        }
        else
        {
            $dist_code       = trim($this->session->userdata('dist_code'));
            $appId           = trim($this->input->post('meetingId'));
            $remarks         = trim($this->input->post('remarks'));
            $user_desig_code = trim($this->session->userdata('user_desig_code'));
            $user_code       = trim($this->session->userdata('user_code'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', RECLASS_ID)
                ->where('status', 'W')
                ->where('pending_officer', 'DPT')
                ->where("(add_cases_to_memo != 'Y' OR add_cases_to_memo IS NULL)", NULL, false)
                ->get('reclass_suite_basic')
                ->num_rows();


            if($checkCase == 1)
            {

                $result = $this->db->query("select b.proposal_name, c.id from settlement_proposal_cases a
	                              join settlement_proposal_list b on b.id=a.proposal_id
	                              join proposal_meeting_list c on c.id=b.proposal_meeting_id
	                              where a.case_no=?",
                    array($appId));

                $meetingDetail = $result->row();
                if (!empty($meetingDetail))
                {
                    $meetingDetails  = $this->reclassPullModel->getMeetingDetailByMeetingIDPull(trim($meetingDetail->id));

                    if($meetingDetails->digital_sign_status != 1)
                    {
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003800: Revert request cancelled..! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $this->db->trans_begin();
                    $case_no = $appId;
                    if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no) != 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003814: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                        ));
                        return false;
                    }
                    if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNoReCla($case_no) != 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003824: Application ('.$case_no.') not found ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $caseDetails = $this->ReclassCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
                    if($caseDetails->status != MB_PENDING)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003835: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                        ));
                        return false;
                    }
                    if($caseDetails->dept_revert == 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003844: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $getProposalID = $this->SettlementCommonDcModel->getSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no);
                    $proposalId    = trim($getProposalID->proposal_id);
                    $checkReqMod   = 0;
                    if($caseDetails->pull_request != 0)
                    {
                        $requested = $this->reclassPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                        if($requested->num_rows() == 0)
                        {
                            $checkReqMod = 0;
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0003961: Application ('.$case_no.') not found in Modification Request ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        $requestedData = $requested->row();
                        $checkReqMod   = 1;
                    }

                    $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                    $insertIntoDeletedTable = array(
                        'proposal_id' => $proposalId,
                        'case_no'     => $deleteCase->case_no,
                        'status'      => $deleteCase->status,
                        'ip'          => $deleteCase->ip,
                        'created_at'  => $deleteCase->created_at,
                        'updated_at'  => $deleteCase->updated_at,
                        'co_submit'   => $deleteCase->co_submit,
                        'deleted_by'  => $this->session->userdata('user_code'),
                    );

                    $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                    if($insertDeleteData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0003988: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003988: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                        ));
                        return false;
                    }
                    $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                    if($deleteProCase != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0003900: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003900: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $updateData = array(
                        'status'          => MB_REVERT,
                        'pending_office'  => MB_CIRCLE_OFFICER,
                        'pending_officer' => MB_CIRCLE_OFFICER,
                        'from_office'     => $user_desig_code,
                        'dc_proceeding'   => 0,
                        'pull_request'    => 0,
                    );
                    if($this->ReclassCommonDcModel->updateSettlementBasicDataOnlyDept($case_no,$dist_code,$updateData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003918: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                        ));
                        return false;
                    }
                    else
                    {
                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                        if($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status'               => MB_REVERT,
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Pull Back & Reverted to CO',
                            'note_on_order'        => $remarks
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                        if($insertProceeding != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRBR0003952: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#MRBR0003952: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                            ));
                            return false;
                        }
                        else
                        {
                            if($checkReqMod == 1)
                            {
                                $updateReq = [
                                    'final_status'     => MODIFICATION_REQUEST_APPROVED,
                                    'approved_by'      => $user_desig_code,
                                    'approved_by_uc'   => $user_code,
                                    'approve_date'     => date('Y-m-d H:i:s'),
                                    'approved_remarks' => $remarks,
                                    'pending_request_officer' => '',
                                ];

                                $this->db->where('id',$requestedData->id);
                                $this->db->update('settlement_pull_request',$updateReq);
                                if($this->db->affected_rows() !=1){
                                    log_message('error', '#MRBR0003978: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    echo json_encode([
                                        'responseType' => 1,
                                        'message' => '#MRBR0003978:  Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                    ]);
                                    return false;
                                }

                                $insPetProceed = [
                                    'case_no'              => $case_no,
                                    'proceeding_id'        => $proceeding_id + 1,
                                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                    'note_on_order'        => $remarks,
                                    'status'               => 'MR',
                                    'user_code'            => $this->session->userdata('user_code'),
                                    'date_entry'           => date('Y-m-d h:i:s'),
                                    'operation'            => 'E',
                                    'ip'                   => $this->utilityclass->get_client_ip(),
                                    'office_from'          => $user_desig_code,
                                    'office_to'            => MB_CIRCLE_OFFICER,
                                    'task'                 => 'Modification Request Accepted'
                                ];
                                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                                if($insertProceeding != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#MRBR0004006: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                    echo json_encode([
                                        'responseType' => 1,
                                        'message' => '#MRBR0004006: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                    ]);
                                    return false;
                                }
                            }
                        }
                    }

                    // update meeting
                    $updateMeetingID = array(
                        'digital_sign_update_status' => 1,
                    );
                    $this->db->where(['id' => $meetingDetail->id, 'dist_code' => $dist_code,'meeting_type_ins' => '40']);
                    $this->db->update('proposal_meeting_list', $updateMeetingID);
                    if($this->db->affected_rows() <=  0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0004040: Updation failed in proposal_meeting_list '.$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MRBR0004040: Unable to update status for Resigning. 
                                        Kindly contact system administrator !!!!',
                        ));
                        return false;
                    }

                    $application_no = $this->reclassModel->getSettlementBasicCo($case_no)->applid;
                    $case   = $case_no;
                    $rmk    = 'Pull Back & Reverted to CO';
                    $status = 'M';
                    $task   = $this->session->userdata('user_desig_code');
                    $pen    = MB_CIRCLE_OFFICER;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status = json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRAPI104042: Issue in API Call'
                            .$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MRAPI104042: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                        ));
                        return false;
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message'  => 'Application has been successfully pulled back and reverted to the CO.!
                         You have resign this meeting '.($meetingDetails->meeting_name),
                    ));
                    return false;
                }
                else
                {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MR0001991: Meeting not found ! Kindly contact system administrator',
                    ));
                    return false;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return false;
            }
        }
    }








    // PULL BACK FORM DC AFTER FINAL VERIFICATION DONE
    // RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDCHardCode
    // pull back dept pending cases
    public function pullBackCasesFromDepartmentForDCHardCode()
    {

        if(PULL_BACK_CASES_HARD_CODE_LIVE != 1)
        {
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDC");
        }

        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->ReclassCommonDcModel->getLocationName($dist_code);
        $location          = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'reclass_suite/Dc/pull_back_cases_from_dept_hard_code';
        $this->load->view('layouts/main', $data);

    }


    // Ajax for pull back case list
    public function pullBackCasesWithDeptPaginationAPIHardCode()
    {
        if(PULL_BACK_CASES_HARD_CODE_LIVE != 1)
        {
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDC");
        }
        $service       = RECLASS_ID;
        $by_case_no    = trim($this->input->post('case_no'));
        $remark_cat    = trim($this->input->post('remark_cat'));
        $remark_cat_lm = trim($this->input->post('remark_cat_lm'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subDiv_code   = trim($this->input->post('subdiv'));
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = trim($this->session->userdata('user_desig_code'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }

        if($order != null){
            $this->db->order_by($order, $dir);
        }

        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->join('settlement_ap_lmnote', 'reclass_suite_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('reclass_suite_basic.service_code', $service);
        $this->db->where('reclass_suite_basic.dist_code', $dist_code);
        $this->db->where('reclass_suite_basic.case_no', PULL_BACK_CASES_HARD_CODE);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;



            $this->db->select('*');
            $this->db->from('reclass_suite_basic');
            $this->db->join('settlement_ap_lmnote', 'reclass_suite_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('reclass_suite_basic.service_code', $service);
            $this->db->where('reclass_suite_basic.dist_code', $dist_code);
            $this->db->where('reclass_suite_basic.case_no', PULL_BACK_CASES_HARD_CODE);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $co_remark ='';
                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                    if($rows->co_note_yn == $co_remark_cat->CODE){
                        $co_remark = $co_remark_cat->NAME;
                    }
                }
                $lm_remark ='';
                foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                    if($rows->lm_note == $lm_remark_cat->CODE){
                        $lm_remark = $lm_remark_cat->NAME;
                    }
                }

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $lm_remark,

                    $co_remark,

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn rezaButt" target="_blank" href="'.base_url().'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case='.$rows->case_no.'">  VIEW
                    </a>
                        
                    <button class="btn rezaButt buttPrimary pullBackCasesModal" data-id='.$rows->case_no.'  style="margin-top: 10px">  PULL BACK
                    </button>'

                );

                $i++;
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    // get revert back meeting details
    public function getPullBackCaseDetailsHardCode()
    {
        if(PULL_BACK_CASES_HARD_CODE_LIVE != 1)
        {
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDC");
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $appId     = PULL_BACK_CASES_HARD_CODE;

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', RECLASS_ID)
                ->get('reclass_suite_basic')
                ->num_rows();


            if($checkCase == 1)
            {

                $result = $this->db->query("select b.proposal_name, c.meeting_name from settlement_proposal_cases a
	                              join settlement_proposal_list b on b.id=a.proposal_id
	                              join proposal_meeting_list c on c.id=b.proposal_meeting_id
	                              where a.case_no=?",
                    array($appId));

                $meetingDetails = $result->row();

                if (!empty($meetingDetails))
                {
                    echo json_encode(array(
                        'responseType'       => 2,
                        'meetingId'          => $appId,
                        'caseNumber'         => $appId,
                        'revertMeetingName'  => $meetingDetails->meeting_name,
                        'revertProposalName' => $meetingDetails->proposal_name,
                    ));

                    return;
                }
                else
                {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MR0001991: Meeting not found ! Kindly contact system administrator',
                    ));
                    return;
                }

            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return;
            }
        }
    }


    // final pull back submit & revert back to co
    public function finalPullBackRevertToCoSubmitHardCode()
    {
        if(PULL_BACK_CASES_HARD_CODE_LIVE != 1)
        {
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDC");
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();

            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#ERMR002025: Validation error ! ' .$errors,
            ));
            return;
        }
        else
        {
            $dist_code       = trim($this->session->userdata('dist_code'));
            $appId           = PULL_BACK_CASES_HARD_CODE;
            $remarks         = trim($this->input->post('remarks'));
            $user_desig_code = trim($this->session->userdata('user_desig_code'));
            $user_code       = trim($this->session->userdata('user_code'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', RECLASS_ID)
                ->get('reclass_suite_basic')
                ->num_rows();


            if($checkCase == 1)
            {

                $result = $this->db->query("select b.proposal_name, c.id from settlement_proposal_cases a
	                              join settlement_proposal_list b on b.id=a.proposal_id
	                              join proposal_meeting_list c on c.id=b.proposal_meeting_id
	                              where a.case_no=?",
                    array($appId));

                $meetingDetail = $result->row();
                if (!empty($meetingDetail))
                {
                    $meetingDetails  = $this->reclassPullModel->getMeetingDetailByMeetingIDPull(trim($meetingDetail->id));
                    if($meetingDetails->digital_sign_status != 1)
                    {
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003800: Revert request cancelled..! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $this->db->trans_begin();
                    $case_no = $appId;
                    if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no) != 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003814: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                        ));
                        return false;
                    }
                    if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNoReCla($case_no) != 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003824: Application ('.$case_no.') not found ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $caseDetails = $this->ReclassCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
                    if($caseDetails->dept_revert == 1)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003844: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $getProposalID = $this->SettlementCommonDcModel->getSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no);
                    $proposalId    = trim($getProposalID->proposal_id);
                    $checkReqMod   = 0;
                    if($caseDetails->pull_request != 0)
                    {
                        $requested = $this->reclassPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                        if($requested->num_rows() == 0)
                        {
                            $checkReqMod = 0;
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0003961: Application ('.$case_no.') not found in Modification Request ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        $requestedData = $requested->row();
                        $checkReqMod   = 1;
                    }

                    $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                    $insertIntoDeletedTable = array(
                        'proposal_id' => $proposalId,
                        'case_no'     => $deleteCase->case_no,
                        'status'      => $deleteCase->status,
                        'ip'          => $deleteCase->ip,
                        'created_at'  => $deleteCase->created_at,
                        'updated_at'  => $deleteCase->updated_at,
                        'co_submit'   => $deleteCase->co_submit,
                        'deleted_by'  => $this->session->userdata('user_code'),
                    );

                    $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                    if($insertDeleteData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0003988: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003988: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                        ));
                        return false;
                    }
                    $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                    if($deleteProCase != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0003900: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003900: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                        ));
                        return false;
                    }

                    $updateData = array(
                        'status'          => MB_REVERT,
                        'pending_office'  => MB_CIRCLE_OFFICER,
                        'pending_officer' => MB_CIRCLE_OFFICER,
                        'from_office'     => $user_desig_code,
                        'dc_proceeding'   => 0,
                        'pull_request'    => 0,
                    );
                    if($this->ReclassCommonDcModel->updateSettlementBasicDataHardCode($case_no,$dist_code,$updateData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'  => '#MRBR0003918: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                        ));
                        return false;
                    }
                    else
                    {
                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                        if($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status'               => MB_REVERT,
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Pull Back & Reverted to CO',
                            'note_on_order'        => $remarks,
                            'note_type'            => 'As per request received via email the case has been reverted to CO'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                        if($insertProceeding != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRBR0003952: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#MRBR0003952: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                            ));
                            return false;
                        }
                        else
                        {
                            if($checkReqMod == 1)
                            {
                                $updateReq = [
                                    'final_status'     => MODIFICATION_REQUEST_APPROVED,
                                    'approved_by'      => $user_desig_code,
                                    'approved_by_uc'   => $user_code,
                                    'approve_date'     => date('Y-m-d H:i:s'),
                                    'approved_remarks' => $remarks,
                                    'pending_request_officer' => '',
                                ];

                                $this->db->where('id',$requestedData->id);
                                $this->db->update('settlement_pull_request',$updateReq);
                                if($this->db->affected_rows() !=1){
                                    log_message('error', '#MRBR0003978: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    echo json_encode([
                                        'responseType' => 1,
                                        'message' => '#MRBR0003978:  Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                    ]);
                                    return false;
                                }

                                $insPetProceed = [
                                    'case_no'              => $case_no,
                                    'proceeding_id'        => $proceeding_id + 1,
                                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                    'note_on_order'        => $remarks,
                                    'status'               => 'MR',
                                    'user_code'            => $this->session->userdata('user_code'),
                                    'date_entry'           => date('Y-m-d h:i:s'),
                                    'operation'            => 'E',
                                    'ip'                   => $this->utilityclass->get_client_ip(),
                                    'office_from'          => $user_desig_code,
                                    'office_to'            => MB_CIRCLE_OFFICER,
                                    'task'                 => 'Modification Request Accepted'
                                ];
                                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                                if($insertProceeding != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#MRBR0004006: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                    echo json_encode([
                                        'responseType' => 1,
                                        'message' => '#MRBR0004006: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                                    ]);
                                    return false;
                                }
                            }
                        }
                    }

                    // update meeting
                    $updateMeetingID = array(
                        'digital_sign_update_status' => 1,
                    );
                    $this->db->where(['id' => $meetingDetail->id, 'dist_code' => $dist_code,'meeting_type_ins' => '40']);
                    $this->db->update('proposal_meeting_list', $updateMeetingID);
                    if($this->db->affected_rows() <=  0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRBR0004040: Updation failed in proposal_meeting_list '.$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MRBR0004040: Unable to update status for Resigning. 
                                        Kindly contact system administrator !!!!',
                        ));
                        return false;
                    }

                    $application_no = $this->reclassModel->getSettlementBasicCo($case_no)->applid;
                    $case   = $case_no;
                    $rmk    = 'Pull Back & Reverted to CO';
                    $status = 'M';
                    $task   = $this->session->userdata('user_desig_code');
                    $pen    = MB_CIRCLE_OFFICER;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status = json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRAPI104042: Issue in API Call'
                            .$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MRAPI104042: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                        ));
                        return false;
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message'  => 'Application has been successfully pulled back and reverted to the CO.!
                         You have resign this meeting '.($meetingDetails->meeting_name),
                    ));
                    return false;
                }
                else
                {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MR0001991: Meeting not found ! Kindly contact system administrator',
                    ));
                    return false;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return false;
            }
        }
    }









    // VGR/PGR REVERT CASE FROM DC END  ///****************

    // Meeting details for VGR/PGR revert cases
    public function getVgrPgrCasesForRevertDc($meetingId)
    {
        $meetingId = trim($meetingId);
        $dist_code = $this->session->userdata('dist_code');

        $checkMeeting = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->where('digital_sign_status', 0)
            ->where('dc_approve_status', 0)
            ->get('proposal_meeting_list')
            ->num_rows();

        if($checkMeeting == 1)
        {

            $meetingDetails = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('adc_forward_to_dc_status', 1)
                ->where('digital_sign_status', 0)
                ->where('dc_approve_status', 0)
                ->get('proposal_meeting_list')
                ->row();

            if (trim($meetingDetails->vgr_pgr_status) == 1)
            {
                $proposals = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId)->result();

                $allCases = [] ;
                foreach ($proposals as $singlePro)
                {
                    $cases = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($singlePro->proposal_id);

                    if($cases->num_rows() == 0 || $cases->num_rows() == '')
                    {
                        $this->session->set_flashdata('error', "There is no VGR/PGR Cases Under this Meeting !");
                        redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingLandPage");
                    }
                    $allCases[] = $cases->result();

                }

                $data['dist_code']       = $dist_code;
                $data['meeting']         = $meetingDetails;
                $data['proposal_detail'] = $proposals;
                $data['allCases']        = $allCases;

                $data['_view'] = 'SettlementView/Dc/vgr_pgr_meeting_for_revert_dc';
                $this->load->view('layouts/main', $data);

            }
            else
            {
                $this->session->set_flashdata('error', "There is no VGR/PGR Cases Under this Meeting !");
                redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingLandPage");
            }
        }
        else
        {
            $this->session->set_flashdata('error', "Meeting already processed/Not Found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/meetingLandPage");
        }
    }


    // VGR/PGR revert case to ADC/SDO
    public function saveVgrPgrCasesForRevertDcData()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('selectedCases', 'Case Number', 'trim|required|is_natural');
        $this->form_validation->set_rules('meetingId','Meeting id', 'trim|required|is_natural');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MRVGRR004827: Validation Error',
            ));
            return;
        }
        else
        {
            $totalCount = (int)$this->input->post('selectedCases');
            $meetingId  = trim($this->input->post('meetingId'));
            $dist_code  = $this->session->userdata('dist_code');
            $desi_code  = $this->session->userdata['user_desig_code'];
            if($desi_code != MB_DEPUTY_COMM)
            {
                $json = [
                    'responseType' => 1, 'message'  => '#MRVGRR004838: You are not authorized for this process',
                ];
                echo json_encode($json); return false;
            }
            $errorInSelection = 0;
            $caseRemarkArray  = [];
            $caseRemarkError  = [];
            for($i = 0; $i < $totalCount; $i++)
            {
                $case_no = $this->input->post('case_no'.$i);
                $remark  = $this->input->post('revert_remark'.$i);

                if(isset($case_no) && isset($remark))
                {
                    if(!$case_no == '' && !$remark == '')
                    {
                        $caseRemarkArray[] = array(
                            'case'   => $case_no,
                            'remark' => $remark
                        );
                    }
                    elseif($case_no == '' && $remark == '')
                    {
                    }
                    else
                    {
                        $errorInSelection = $errorInSelection + 1;
                        if($case_no != '')
                        {
                            $caseRemarkError[] = $case_no;
                        }
                    }
                }
            }
            $caseErrors = '';
            $mnp = count($caseRemarkError);
            $index = 0;
            foreach ($caseRemarkError as $caseError)
            {
                if ($index == $mnp - 1)
                {
                    $caseErrors .= "'".$caseError."'";
                }
                else
                {
                    $caseErrors .= "'".$caseError."'". ",";
                }
                $index++;
            }
            if($errorInSelection > 0)
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004888: Kindly check selected cases with proper remarks' .$caseErrors,
                ];
                echo json_encode($json);
                return false;
            }

            $zeroSelectedCase = count($caseRemarkArray);
            if($zeroSelectedCase == 0)
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004900: There is no selected cases for revert',
                ];
                echo json_encode($json);
                return false;
            }

            // check meeting details
            $meeting = $this->ReclassSuiteMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId);
            $meetingCount = $meeting->num_rows();
            if($meetingCount == 0 || $meetingCount == '')
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004914: Meeting not found !',
                ];
                echo json_encode($json);
                return false;
            }
            $meetingDetails = $meeting->row();
            if($meetingDetails->vgr_pgr_status != 1)
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004925: Only VGR/PGR cases can revert !',
                ];
                echo json_encode($json);
                return false;
            }
            if($meetingDetails->vgr_pgr_revert_status != 0)
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004934: Some cases are already Reverted from this Meeting !',
                ];
                echo json_encode($json);
                return false;
            }
            if($meetingDetails->digital_sign_status != 0)
            {
                $json = [
                    'responseType' => 1,
                    'message'  => '#MRVGRR004943: Meeting already processed ! You cannot revert cases',
                ];
                echo json_encode($json);
                return false;
            }

            $this->db->trans_begin();
            foreach ($caseRemarkArray as $singleCase)
            {
                $caseNo = trim($singleCase['case']);
                $revertRemarks = trim($singleCase['remark']);
                $allAPICases[] = $caseNo;
                if($caseNo == '' OR $revertRemarks == '')
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MRVGRR004957: Kindly check selected cases with proper remarks',
                    ];
                    echo json_encode($json);
                    return false;
                }

                // case check
                $caseQ = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNoDistCode($caseNo,$dist_code);
                $caseCount = $caseQ->num_rows();
                if($caseCount == 0 || $caseCount == '')
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MRVGRR004970: Case ('.$caseNo.') is not found !',
                    ];
                    echo json_encode($json);
                    return false;
                }
                $caseDetails = $caseQ->row();
                if($caseDetails->pending_office != MB_DEPUTY_COMM OR $caseDetails->status != MB_FINAL_APPROVED_BY_DC)
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MRVGRR004980: Case ('.$caseNo.') already processed !',
                    ];
                    echo json_encode($json);
                    return false;
                }
                if($caseDetails->service_code != SETTLEMENT_PGR_VGR_LAND_ID)
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MRVGRR004989: '.$caseNo.' is not a VGR/PGR case !',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $caseProCount   = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($caseNo);
                if($caseProCount == 0 || $caseProCount == '')
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MRVGRR005000: Case ('.$caseNo.') not mapped with proposal !',
                    ];
                    echo json_encode($json);
                    return false;
                }
                $caseProDetails = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($caseNo);

                // save data
                $saveData = array(
                    'dist_code'             => trim($caseDetails->dist_code),
                    'subdiv_code'           => trim($caseDetails->subdiv_code),
                    'cir_code'              => trim($caseDetails->cir_code),
                    'mouza_pargona_code'    => trim($caseDetails->mouza_pargona_code),
                    'lot_no'                => trim($caseDetails->lot_no),
                    'vill_townprt_code'     => trim($caseDetails->vill_townprt_code),
                    'meeting_id'            => $meetingId,
                    'proposal_id'           => trim($caseProDetails->proposal_id),
                    'pro_cases_id'          => trim($caseProDetails->id),
                    'case_no'               => $caseNo,
                    'meeting_pending_at'    => MB_DEPUTY_COMM,
                    'user_code'             => $this->session->userdata('user_code'),
                    'revert_date'           => date('Y-m-d h:i:s'),
                    'status'                => 1,
                    'approve_status'        => MB_PENDING,
                    'from_office'           => MB_DEPUTY_COMM,
                    'to_office'             => trim($meetingDetails->created_by),
                    'remarks'               => $revertRemarks,
                    'basic_pending_office'  => trim($caseDetails->pending_office),
                    'basic_pending_officer' => trim($caseDetails->pending_officer),
                    'basic_status'          => trim($caseDetails->status),
                    'basic_from_office'     => trim($caseDetails->from_office),
                    'created_at'            => date('Y-m-d h:i:s'),
                );

                $insertRevert = $this->db->insert('settlement_vgr_pgr_revert_cases',$saveData);
                if($insertRevert != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRVGRR005043: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case no : '.$caseNo. ' and query is '. $this->db->last_query());
                    $json = [
                        'responseType' => 1,
                        'message' => '#MRVGRR005043: Case can not be reverted. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                // add proceeding
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$caseNo' ")->row()->c;
                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }
                $insPetProceed = [
                    'case_no'              => $caseNo,
                    'proceeding_id'        => $proceeding_id,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'status'               => 'VR',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'note_on_order'        => $revertRemarks,
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => MB_DEPUTY_COMM,
                    'office_to'            => trim($meetingDetails->created_by),
                    'task'                 => 'Meeting Revert back to '.trim($meetingDetails->created_by)
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRVGRR005077: Insertion failed in settlement_proceeding for case no :'. $caseNo);
                    $json = [
                        'responseType' => 1,
                        'message' => '#MRVGRR005077: Case can not be reverted. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // update meeting
            $updateMeeting = array(
                'vgr_pgr_revert_status' => 1
            );
            $this->db->where('id', $meetingId);
            $this->db->where('dist_code', $dist_code);
            $this->db->update('proposal_meeting_list', $updateMeeting);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRVGRR005093: Updation failed in proposal_meeting_list 
                    for meeting no : '.$meetingId. ' and query is '. $this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRR005093: Case can not be reverted. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            $caseApp = $this->SettlementCommonModel->convertLiteral($allAPICases);
            $sql = "select string_agg(applid,',') as applids from reclass_suite_basic where 
                    case_no in ($caseApp)";
            $applids = $this->db->query($sql)->row()->applids;


            //api call
            $rmk    = 'Meeting Revert back to '.trim($meetingDetails->created_by);
            $status = 'M';
            $task   = $this->session->userdata['user_desig_code'];
            $pen    = trim($meetingDetails->created_by);
            $rtps_status = $this->SettlementApiModel->applicationStatusUpdateBulkMb3($applids, 'NA', $rmk, $status, $task, $pen);
            if (trim($rtps_status) != "y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRVGRAPI001: Revert back to $meetingDetails->created_by failed case no # $applids");
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRAPI001: Case can not be reverted. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            $this->db->trans_commit();
            $json = [
                'responseType' => 2,
                'message'      => 'All selected cases has successfully Reverted to '.$meetingDetails->created_by,
            ];
            echo json_encode($json);
            return false;
        }
    }


    // VGR/PGR Meeting Reverted by DPT
    public function getAllVgrPgrRevertedCaseByDept()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $createdBy   = $this->session->userdata('user_desig_code');

        $allCases = $this->SettlementCommonDcModel->getAllVgrPgrRevertedCaseForDc($dist_code,$createdBy);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCases->result();
        $data['pendingCaseCount'] = $allCases->num_rows();

        $data['_view'] = 'settlementView/Dc/vgr_pgr_reverted_dc';
        $this->load->view('layouts/main', $data);
    }


    // get VGR/PGR reverted case Details
    public function getVgrPgrRevertedCaseDetailsForDc()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $createdBy   = $this->session->userdata('user_desig_code');
        $caseId      = trim($this->input->get('case'));

        if($caseId == '' || $caseId == NULL)
        {
            $this->session->set_flashdata('error', "Case not found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }

        $revert = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetails($dist_code,$caseId);
        if($revert->num_rows() == 0 || $revert->num_rows()== '')
        {
            $this->session->set_flashdata('error', "Case not found !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }
        $revertDetails = $revert->row();

        if(trim($revertDetails->status) == 0)
        {
            $this->session->set_flashdata('error', "Case already processed !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }
        if(trim($revertDetails->to_office) != $createdBy)
        {
            $this->session->set_flashdata('error', "You are not authorized !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }

        $case_no   = trim($revertDetails->case_no);
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            $this->session->set_flashdata('message', " Case not found ! ");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }
        $caseDetails     = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
        $proposalDetails = $this->ReclassSuiteMeetingDcModel->getProposalDetailsByProId(trim($revertDetails->proposal_id));
        $meetingDetails  = $this->ReclassSuiteMeetingDcModel->getMeetingDetailByMeetingId(trim($revertDetails->meeting_id));
        $getProposalID   = $this->SettlementCommonDcModel->getSettlementRevertedProposalCaseDetailsByCaseNo($case_no);
        if($meetingDetails->vgr_pgr_status != 1)
        {
            $this->session->set_flashdata('error', "Only VGR/PGR cases can revert !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            $this->session->set_flashdata('error', "Meeting already Processed !");
            redirect(base_url() . "index.php/RelassSuiteMeetingControllerDc/getAllVgrPgrRevertedCaseByDept");
        }

        $data['dist_code']       = $dist_code;
        $data['basic']           = $caseDetails;
        $data['proposalDetails'] = $proposalDetails;
        $data['meetingDetails']  = $meetingDetails;
        $data['proposalCaseD']   = $getProposalID;
        $data['revertDetails']   = $revertDetails;


        $data['_view'] = 'settlementView/dc/vgr_pgr_reverted_details_dc';
        $this->load->view('layouts/main', $data);

    }


    // reverted vgr case revert back to CO
    public function revertedVgrCaseRevertToCoByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('revertedId', 'Reverted case ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005240: Validation error ! Please enter remarks ',
            ]);
            return false;
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $case_no   = trim($this->input->post('caseNo'));
        $rev_id    = trim($this->input->post('revertedId'));
        $remark    = trim($this->input->post('remarks'));

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005256: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $revertedCase = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetailsForRevertToCo
        ($rev_id,$case_no,$dist_code,$user_desig_code);
        if($revertedCase->num_rows() != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005267: Case not found ! ',
            ]);
            return false;
        }

        $revertedCaseDetails = $revertedCase->row();
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005278: Case not found ! ',
            ]);
            return false;
        }

        $meetingDetails = $this->ReclassSuiteMeetingDcModel->getMeetingDetailByMeetingId(trim($revertedCaseDetails->meeting_id));
        if($meetingDetails->vgr_pgr_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005288: Only VGR/PGR cases can revert ! ',
            ]);
            return false;
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005296: Meeting already Processed ! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        $updateData = array(
            'to_office'   => MB_CIRCLE_OFFICER,
            'from_office' => trim($user_desig_code),
            'updated_at'  => date('Y-m-d h:i:s'),
        );

        $this->db->where('id', $rev_id);
        $this->db->where('case_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->update('settlement_vgr_pgr_revert_cases', $updateData);
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR005321: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR005321: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // add proceeding
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null)
        {
            $proceeding_id=1;
        }
        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => 'VR',
            'user_code'            => $user_code,
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_on_order'        => $remark,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => trim($user_desig_code),
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Meeting Revert back to '.MB_CIRCLE_OFFICER
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR005355: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR005355: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // API Calling
        $application_no = $this->reclassSuiteADCModel->getSettlementBasicCo($case_no)->applid;
        $rmk    = 'Reverted by '.$user_desig_code;
        $status = 'M';
        $task   = $user_desig_code;
        $pen    = MB_CIRCLE_OFFICER;
        $case   = $case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        if(trim($rtps_status)!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPIVR04454: Case revert to CO failed for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRAPIVR04454: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message' => 'Case ('.$case_no.') successfully reverted to CO',
        ]);
        return false;

    }


    // reverted vgr case Forward to DPT
    public function revertedVgrCaseForwardToDeptByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('forwardId', 'Forwarded case ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005404: Validation error ! Please enter remarks ',
            ]);
            return false;
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $case_no   = trim($this->input->post('caseNo'));
        $for_id    = trim($this->input->post('forwardId'));
        $remark    = trim($this->input->post('remarks'));

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005420: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $revertedCase = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetailsForRevertToCo
        ($for_id,$case_no,$dist_code,$user_desig_code);
        if($revertedCase->num_rows() != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005431: Case not found ! ',
            ]);
            return false;
        }

        $revertedCaseDetails = $revertedCase->row();
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR0054425: Case not found ! ',
            ]);
            return false;
        }

        $meetingDetails = $this->ReclassSuiteMeetingDcModel->getMeetingDetailByMeetingId(trim($revertedCaseDetails->meeting_id));
        if($meetingDetails->vgr_pgr_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005452: Only VGR/PGR cases can revert ! ',
            ]);
            return false;
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005460: Meeting already Processed ! ',
            ]);
            return false;
        }

        $remainingCases = $this->SettlementCommonDcModel->countAllPendingVgrPgrRevertedMeetingCases(trim($revertedCaseDetails->meeting_id),$dist_code);

        $this->db->trans_begin();
        if($remainingCases == 0 || $remainingCases == '' )
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005472: All reverted cases already Processed ! ',
            ]);
            return false;
        }

        // if meeting hold under DPT
        if(trim($revertedCaseDetails->meeting_pending_at) == MB_DEPARTMENT && $meetingDetails->digital_sign_status == 1)
        {
            if($remainingCases == 1)
            {
                $updateMeeting = array(
                    'vgr_pgr_revert_status'      => 0,
                    'digital_sign_update_status' => 1
                );
                $this->db->where('id', trim($revertedCaseDetails->meeting_id));
                $this->db->where('dist_code', $dist_code);
                $this->db->update('proposal_meeting_list', $updateMeeting);
                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRVGRR005497: Updation failed in proposal_meeting_list 
                    for meeting no : '.trim($revertedCaseDetails->meeting_id). ' and query is '. $this->db->last_query());
                    $json = [
                        'responseType' => 1,
                        'message' => '#MRVGRR005497: Case can not be forward. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            $updateDataC = array(
                'to_office'      => MB_DEPARTMENT,
                'from_office'    => trim($user_desig_code),
                'status'         => 0,
                'approve_status' => 'VC',
                'updated_at'     => date('Y-m-d h:i:s'),
            );

            $this->db->where('id', $for_id);
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->update('settlement_vgr_pgr_revert_cases', $updateDataC);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRVGRR005524: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRR005524: Case can not be forward. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            $updateBas = array(
                'dept_vgr_revert' => 0
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->update('reclass_suite_basic', $updateBas);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRVGRR005526: Updation failed in reclass_suite_basic 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRR005526: Case can not be forward. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR005535: Case can not be forward !  Kindly contact system administrator',
            ]);
            return false;
        }

        // add proceeding
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null)
        {
            $proceeding_id=1;
        }
        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => 'VF',
            'user_code'            => $user_code,
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_on_order'        => $remark,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => trim($user_desig_code),
            'office_to'            => MB_DEPARTMENT,
            'task'                 => 'Meeting Forwarded to '.MB_DEPARTMENT
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR005568: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR005568: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // API Calling
        $application_no = $this->reclassSuiteADCModel->getSettlementBasicCo($case_no)->applid;
        $rmk    = 'Forwarded by '.$user_desig_code;
        $status = 'M';
        $task   = $user_desig_code;
        $pen    = MB_DEPARTMENT;
        $case   = $case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        if(trim($rtps_status)!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPIVR04691: Case forwarded to CO failed for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRAPIVR04691: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message' => 'Case ('.$case_no.') successfully forwarded to Department',
        ]);
        return false;

    }



    // get meeting name/signing date/DC code
    public function getOrderNameDateDcCodeByCaseNo()
    {
        $case_no = 'KAM/PAL/2023-24/702/SKHAS';
        if($case_no == null OR $case_no == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBD001: Case number not found ! ',
            ]);
            return false;
        }
        $dist_code = $this->session->userdata('dist_code');
        $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
        if(empty($caseDetails))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBD002: Case not found ! ',
            ]);
            return false;
        }
        $countProposalID = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
        if($countProposalID != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBD003: Case not found under proposal ! ',
            ]);
            return false;
        }

        $getProposalID   = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
        $proposalDetails = $this->ReclassSuiteMeetingDcModel->getProposalDetailsByProId(trim($getProposalID->proposal_id));
        if(trim($proposalDetails->proposal_meeting_id) == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBD004: Case not found in meeting ! ',
            ]);
            return false;
        }
        $caseInMeeting = $this->ReclassSuiteMeetingDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
        if(empty($caseInMeeting))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBD002: Case not mapped with any meeting! ',
            ]);
            return false;
        }

        $data = array(
            'case_no'    => $case_no,
            'order_no'   => $caseInMeeting->meeting_name,
            'order_date' => $caseInMeeting->digital_sign_date,
            'order_by'   => $caseDetails->dc_code
        );



//
//        printf('<pre>');
//        print_r($caseDetails);
//        printf('<br>');
//        print_r($proposalDetails);
//        printf('<br>');
//        print_r($caseInMeeting);
//        die();



    }











    /////////  start HardCode Digital Re-Signing related not used anymore

    // hard code digital sign
    public function hardCodeDigitalResigning()
    {
        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->SettlementMeetingDcModel->getLocationName($dist_code);
        $location          = $getDistrict->result();
        $circleList        = array();

        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $checkDsc = $this->SettlementMeetingDcModel->countDscRegistrationWithDistCode($dist_code);

        $data['location'] = $circleList;
        $data['checkDsc'] = $checkDsc;

        $data['_view'] = 'SettlementView/Dc/pending_meeting_list_for_approval_hard_code';
        $this->load->view('layouts/main', $data);
    }

    // hard code list of common proposals for all services
    public function listOfPendingMeetingIdsHardCode()
    {

        $cir_code    = $this->input->post('circle');
        $subdiv_code = $this->input->post('subdiv');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $service     = $this->input->post('service_code');
        $by_case_no  = $this->input->post('case_no');
        $proposal_no = $this->input->post('proposal_no');
        $dist_code   = $this->session->userdata('dist_code');

        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'desc';
        }
        $valid_columns = array(
            0   => 'proposal_meeting_list.meeting_date',
        );
        if(!isset($valid_columns[$col])){
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }


        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.id', RESIGNING_DIGITAL_MINUTES_MEETING_ID);
        $this->db->limit($length, $start);
        $query = $this->db->get('proposal_meeting_list');

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            $this->db->select('*');
            $this->db->where('proposal_meeting_list.dist_code', $dist_code);
            $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
            $this->db->where('proposal_meeting_list.digital_sign_status', 0);
            $this->db->where('proposal_meeting_list.dc_approve_status', 0);
            $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
            $query1 = $this->db->get('proposal_meeting_list');

            $total_records = $query1->num_rows();

            foreach($result as $rows) {


                $digitalMinutes = '<a class="rezaButt btn btn-sm btn-danger showMinutesGenerateModal" data-id='.$rows->id.' style="color: #FFF;">Generate Digital Minutes</a>';


                if($rows->file_minute_path == '' && $rows->file_minute_path == NULL)
                {
                    $uploadedMinutes ='';
                }
                else
                {
                    $uploadedMinutes ='<a class="rezaButt btn btn-sm" style="background-color :#03A9F4" target="SdlacMinutes" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/viewSdlacUploadedMinute/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Uploaded Minutes</a>';
                }

                $attendance = '<a class="rezaButt btn btn-sm " style="background-color :#3F51B5" target="SdlacAttendance" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/viewSdlacAttendance/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Attendance</a>';

                $viewMeeting ='<a class="rezaButt btn btn-sm " style="background-color :#4CAF50" href="'.base_url().'index.php/RelassSuiteMeetingControllerDc/getPendingProposalsAgainstMeetingId/?meetingId='.$rows->id.'"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View Detail</a>';

                $json[] = array(

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->meeting_name .'</b>',

                    $rows->meeting_venue .'<br><span style="color:red">'. date('d-M-Y',strtotime($rows->meeting_date)).'</span>',

                    $rows->created_by,


                    $digitalMinutes .
                    $attendance.
                    $viewMeeting.
                    $uploadedMinutes
                );
                $i++;
            }
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    // hard code generate digital minutes
    public function generateDigitalMinutesDcHardCode()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingId');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $proposals = $this->db->select('id,proposal_name')
                    ->where('proposal_meeting_id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->get('settlement_proposal_list')
                    ->result();

                $meetingDetails = $this->db->select()
                    ->where('id', $meetingId)
                    ->where('dist_code', $dist_code)
                    ->get('proposal_meeting_list')
                    ->row();

                $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName  = substr($districtName->locname_eng, 0, 3);
                $memoName     = $distEngName.'/MEMO/'.date("Y").'/'.$meetingId;

                $allProposalCases = $this->generateProposalCases($proposals,$meetingId);
                $caseList    = $allProposalCases['final_result_array_rec'];
                $caseDivNot  = $allProposalCases['final_result_array_not_rec'];

                $subDivArray = [];
                if (!empty($caseList) && is_array($caseList))
                {
                    foreach ($caseList as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }
                else
                {
                    foreach ($caseDivNot as $key => $value)
                    {
                        $subDivArray[] = $value['subdiv_code'];
                    }
                }

                $uniqueArraySub = array_unique($subDivArray);

                $subdivNameArray = [];
                foreach ($uniqueArraySub as $singleSub)
                {
                    $subdivNameOnly    = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$singleSub);
                    $subdivNameArray[] = $subdivNameOnly->locname_eng;
                }


                $subdiv_name = '';
                $indexN = 0;
                $ii = count($subdivNameArray);
                foreach ($subdivNameArray as $div)
                {
                    $indexN++;
                    if ($indexN == $ii)
                    {
                        $subdiv_name = $subdiv_name.trim($div);
                    }
                    else
                    {
                        $subdiv_name = $subdiv_name.trim($div). ", ";
                    }
                }



                $commMembers     = $this->SettlementCommonDcModel->getMembersFromUsers($this->session->userdata('dist_code'));
                $subDivCode      = $meetingDetails->subdiv_code;
                $createdUserCode = $meetingDetails->user_code;
                $user_desig_code = $meetingDetails->created_by;

                $userDlc      = $this->SettlementCommonDcModel->getUsersDLCCopyTo($dist_code, $user_desig_code,$createdUserCode);
                $userDlcCount = $userDlc->num_rows();
                $userDlcList  = $userDlc->result();

                if($userDlcCount == 0)
                {
                    $json = [
                        'response' => 1,
                        'message'  => 'Minutes Copy to Members are incomplete ! Kindly Add Members For Minutes Copy To For DLC',
                    ];
                    echo json_encode($json);
                    return false;
                }
                else
                {


                    echo json_encode(array(
                        'responseType' => 2,
                        'meetingId' => $meetingId,
                        'meetingName' => $meetingDetails->meeting_name,
                        'memoName' => $memoName,
                        'districtName' => $districtName->locname_eng,
                        'subDivName' => $subdiv_name,
                        'meetingDate' => date("F j, Y", strtotime($meetingDetails->meeting_date)),
                        'timing' => strtoupper(date("h:i a", strtotime($meetingDetails->meeting_date))),
                        'meetingVenue' => $meetingDetails->meeting_venue,
                        'nominee' => $commMembers,
                        'caseList' => $caseList,
                        'caseDivNot' => $caseDivNot,
                        'proposalDetails' => $proposals,
                        'userDlcList' => $userDlcList,
                        'userDlcCount' => $userDlcCount,
                        'socialWorker' => $socialWorker,
                    ));

                    return;
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }

    // hard code digital sign and save the pdf
    public function digitalSignAndSavePdfHardCode()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingIdDigital', 'Meeting Name', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $meetingId   = $this->input->post('meetingIdDigital');
            $html1       = base64_decode($this->input->post('html1'));
            $html2       = $this->input->post('html2');
            $html3       = $this->input->post('html3');

            $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
            $distEngName = substr($dist_name->locname_eng, 0, 3);
            $fileName    = $distEngName.'_DLC_RE_'.date("Y").'_'.$meetingId;


            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {

                // Mriganka da's code here

                include 'vendor/mpdf/vendor/autoload.php';
                $mpdf=new \Mpdf\Mpdf();
                if(MB3_DIGITAL_SIGN_DRAFT_MODE == 1)
                {
                    $waterMark = 'Mission Basundhara 3.0';
                }
                else
                {
                    $waterMark = 'DRAFT';
                }

                $mpdf->SetWatermarkText($waterMark);
                $mpdf->showWatermarkText = true;
                $mpdf->autoScriptToLang = true;
                $mpdf->autoLangToFont = true;

                $html ="<style>                   
                    .reza-title{
                        font-weight: bold;
                        font-size: 16px;
                        padding: 20px;
                    }                                
                    .rezaText {
                        font-size: 14px;
                    }
                    .divCard {
                        background: #fff;
                        border-radius: 2px;
                        display: inline-block;
                        position: relative;
                        width: 100%;
                    }
                    .mrigankaCenter{
                        text-align: center!important;
                    }                    
                    .mrigankaRight{
                        text-align: right!important;
                        margin-top: 40px;
                    }
                    .rezaText2 {
                        font-size: 14px!important;
                        margin: 20px!important;
                        text-align: center;
                    }
                   
                   
                </style>";
                $mpdf->writeHTML($html1.$html);
                $mpdf->AddPage();
                $mpdf->writeHTML($html2.$html);
                $mpdf->AddPage();
                $mpdf->writeHTML($html3.$html);
                $mpdf->Output(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf','F');
                $b64Doc = chunk_split(base64_encode(file_get_contents(SIGNPDF_UPLOAD_DIR.$fileName.'.pdf')));


                echo json_encode(array(
                    'responseType' => 2,
                    'meetingId'    => $meetingId,
                    'base64pdfData' => $b64Doc,
                ));

                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }
        }

    }

    // not used anymore Chitha Area Check with Meeting
    public function hardCodeChithaAreaCheck()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.id', CHITHA_AREA_CHECK_WITH_MEETING_ID);
        $query = $this->db->get('proposal_meeting_list');
        $meetings = $query->result();

        $data['meetings'] = $meetings;

        $data['_view'] = 'SettlementView/Dc/pending_meeting_list_for_chitha_area_hard_code';
        $this->load->view('layouts/main', $data);
    }


    // Chitha Area Check with Meeting not used anymore
    public function chithaAreaCheckByMeetingIdHardCode()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $checkMeeting = $this->db->select()
            ->where('id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('adc_forward_to_dc_status', 1)
            ->get('proposal_meeting_list')
            ->num_rows();

        if($checkMeeting == 1)
        {

            //get list of proposals
            $getProposalsList = $this->ReclassSuiteMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();


            foreach($getProposalsList as $prop)
            {
                $proposal_no  = $prop->proposal_id;
                $proposalDetails = $this->ReclassSuiteMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
                $final_verify_status = trim($proposalDetails->final_verify_status);

                if($final_verify_status == 1)
                {
                    $pendingCase = $this->ReclassSuiteMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                    $cases       = $pendingCase->result();
                    $caseCount   = $pendingCase->num_rows();
                    if($caseCount == 0)
                    {
                        echo "<h2> Cases not found for proposal id '.$proposal_no) </h2>";
                        return;
                    }
                    else
                    {
                        foreach ($cases as $case)
                        {
                            $case_no = trim($case->case_no);
                            $caseCount       = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($case_no,$dist_code);
                            if($caseCount == 0)
                            {
                                echo "<h2> Few cases under this proposal has already 
                                    been approved. Proposal# : '.$proposal_no.' Case# : '.$case_no)</h2>";
                                return;
                            }

                            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                            if($checkArea != 0)
                            {
                                echo "<h2> Applied area exceeds the limit. Proposal# : '.$proposal_no.' Case# : '.$case_no)</h2>";
                                return;
                            }
                        }

                    }
                }
            }

            echo "<h2> All OK </h2>";
            return;
        }
        else
        {

            echo "<h2> MEETING NOT FOUNT </h2>";
            return;
        }

    }

    // not used anymore
    public function finalApproveOfMeetingDetail()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting ID', 'trim|required|is_natural|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            log_message('error', '#MR0001723: Meeting ID not found '.$this->input->post('meetingId'));
            echo json_encode(array(
                'responseType' => 1,
                'message'      => '#MR0001723: Unable to process for final approval. 
                                Kindly contact system administrator !!!!',
            ));
            return;
        }
        else
        {
            log_message('error', '#MR0001733: Meeting ID not found '.$this->input->post('meetingId'));
            echo json_encode(array(
                'responseType' => 1,
                'message'      => '#MR0001733: Unable to process for final approval. 
                                Kindly contact system administrator !!!!',
            ));
            return;


        }
    }

    // not used anymore
    public function generateProposalCasesOld($proposals)
    {
        $prop = '';
        $index = 0;
        foreach ($proposals as $p)
        {
            if ($index == 0)
            {
                $prop = $prop."'".$p->id."'";
            }
            else
            {
                $prop = $prop.",'".$p->id."'";
            }
            $index++;
        }



        $sql  = "SELECT
        (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and
    cir_code='00') as subdivname,
        (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and
    cir_code=sd.cir_code and mouza_pargona_code='00') as cirname,
                (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and
    cir_code=sd.cir_code and mouza_pargona_code=sd.mouza_pargona_code and lot_no='00') as mouza,
                (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and
    cir_code=sd.cir_code and mouza_pargona_code=sd.mouza_pargona_code and lot_no=sd.lot_no AND
    vill_townprt_code = sd.vill_townprt_code
                ) as village,
                
                sa.case_no,(SELECT applid  FROM reclass_suite_basic WHERE case_no=sa.case_no) AS applid,
                (SELECT service_code FROM reclass_suite_basic WHERE case_no=sa.case_no) AS service_code,
                (SELECT proposal_name FROM settlement_proposal_list WHERE id=sc.proposal_id) AS proposal_name,
                (select string_agg(distinct(eng_pdar_name || '---' || eng_pdar_guardian || ''),',') from settlement_applicant where case_no=sa.case_no and pdar_type='B' ) as name,
                STRING_AGG(sp.dag_no||'---' || sp.total_lessa::VARCHAR || '',',') as dags,
                string_agg(DISTINCT(sc.template_remarks),',') remark,
                string_agg((sd.land_type),',') ladtype,
                sc.case_status
                FROM settlement_proposal_cases sc
                JOIN settlement_applicant sa on sc.case_no = sa.case_no
                JOIN settlement_premium sp on sc.case_no = sp.case_no
                JOIN  settlement_dag_details sd on sd.case_no=sa.case_no and sp.dag_no=sd.dag_no
                WHERE sa.is_applicant=1 and sc.proposal_id IN ($prop) 
                GROUP BY  sd.dist_code,sd.subdiv_code,sd.cir_code,sd.mouza_pargona_code,sd.lot_no,sd.vill_townprt_code,
                sc.proposal_id,sa.case_no,sc.case_status";

        $result_array = $this->db->query($sql)->result_array();



        $serviceNames[13] = 'Settlement of Occupancy Tenant';
        $serviceNames[14] = 'Settlement of AP Transferred';
        $serviceNames[15] = 'Settlement of hereditary land of Tribal Communities';
        $serviceNames[16] = 'Khas Land';
        $serviceNames[17] = 'Settlement of PGR VGR Land';
        $serviceNames[18] = 'Settlement of Land for Indigenous Special Cultivators (Tea/Coffee/Rubber)';


        foreach ($result_array as $row)
        {

            $jsmr = explode(",", $row['dags']);
            $final_dag ='';
            $final_area = '';
            for($j=0; $j<count($jsmr); $j++)
            {
                $final_all = explode('---',$jsmr[$j]);
                if($j==count($jsmr) - 1)
                {
                    $final_dag = $final_dag . $final_all[0];
                    $BKLData = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                    $bklArea =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                    $final_area = $final_area . $bklArea;
                }
                else
                {
                    $final_dag = $final_dag . $final_all[0].'<br>';
                    $BKLData = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                    $bklArea =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                    $final_area = $final_area . $bklArea.'<br>';
                }
            }




            $jsmr2 = explode(",", $row['name']);
            $final_name ='';
            $final_guard = '';
            for($j=0; $j<count($jsmr2); $j++)
            {
                $final_all = explode('---',$jsmr2[$j]);

                if($j==count($jsmr2) - 1)
                {
                    $final_name = $final_name . $final_all[0];
                    $final_guard = $final_guard . $final_all[1];
                }
                else
                {
                    $final_name = $final_name . $final_all[0].', ';
                    $final_guard = $final_guard . $final_all[1].', ';
                }
            }


            // rec
            if($row['case_status']==1)
            {
                $final_result_array_rec[] = array(
                    "subdivname"=>  $row['subdivname'],
                    "cirname"=>  $row['cirname'],
                    "mouza"=>	 $row['mouza'],
                    "village"=>	 $row['village'],
                    "case_no"=>	 $row['case_no'],
                    "applid"=>	 $row['applid'],
                    "service_name"  =>  $serviceNames[$row['service_code']],
                    "proposal_name" => $row['proposal_name'],
                    "name"   =>	$final_name,
                    "guard"  =>	$final_guard,
                    "dag"    =>	$final_dag,
                    "area"   =>	$final_area,
                    "remark" =>  $row['remark'],
                    "ladtype"=>	$row['ladtype'],
                    "status"=>	$row['case_status']
                );
            }

            // not rec
            if($row['case_status']==2)
            {
                $final_result_array_not_rec[] = array(
                    "subdivname"=>  $row['subdivname'],
                    "cirname"=>  $row['cirname'],
                    "mouza"=>	 $row['mouza'],
                    "village"=>	 $row['village'],
                    "case_no"=>	 $row['case_no'],
                    "applid"=>	 $row['applid'],
                    "service_name"  =>  $serviceNames[$row['service_code']],
                    "proposal_name" => $row['proposal_name'],
                    "name"   =>	$final_name,
                    "guard"  =>	$final_guard,
                    "dag"    =>	$final_dag,
                    "area"   =>	$final_area,
                    "remark" =>  $row['remark'],
                    "ladtype"=>	$row['ladtype'],
                    "status"=>	$row['case_status']
                );
            }
        }

        $final_result_array = array(
            'final_result_array_rec'     =>
                (isset($final_result_array_rec) && $final_result_array_rec != NULL)? $final_result_array_rec: '',
            'final_result_array_not_rec' =>
                (isset($final_result_array_not_rec) && $final_result_array_not_rec != NULL)? $final_result_array_not_rec: '',
        );

        return $final_result_array;


    }


    // not used anymore
    public function updateEncroacherInVLB($case_no)
    {
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
        foreach($applicants_encroacher as $applicant_enc)
        {
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($case_no), $applicant_enc->dag_no));
            if ($enc_check->num_rows()<=0)
            {
                return json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-VLB002973: No Encroacher found'
                ));
            }

            $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid,$enc_check->row()->dag_no,$enc_check->row()->encroacher_id));

            if($sql_land_bank->num_rows() > 0) {
                $lb_details_id = $sql_land_bank->row()->land_bank_details_id;
                $elb_enc_id = $sql_land_bank->row()->enc_id;
                $uuid  = $sql_land_bank->row()->uuid;
                $dag_no = $sql_land_bank->row()->dag_no;
                $application_no  = $sql_land_bank->row()->application_no;
                $lb_approval_rmk = "Approved by DC";
                $insertVLBquery   = $this->SettlementMbDcModel->lbdetailsApproveSettlementCases($lb_details_id,$elb_enc_id,$uuid,$dag_no,$application_no,$lb_approval_rmk);
                return $insertVLBquery;
            }
            else
            {
                return json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-VLB002993: Could not update encroacher in vlb ! Kindly contact system administrator',
                ));
            }
        }
    }

    /////////  End  HardCode Digital Re-Signing related not used anymore

}
