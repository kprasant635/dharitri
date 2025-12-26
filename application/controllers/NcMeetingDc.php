<?php

class NcMeetingDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('NcModel/NcCommonSdoModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('NcModel/NcPullModel');
        $this->load->model('NcModel/NcMeetingDcModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('UtilsModel');
        $this->load->model('ProgressModel');

        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code != MB_DEPUTY_COMM){
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

    }

    // NC code by Masud Reza (19/02/2024)

    //////////////// *************** **************** ////////////////



    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // meeting view page
    public function pendingMeetingList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $getDistrict = $this->NcMeetingDcModel->getLocationName($dist_code);
        $location    = $getDistrict->result();
        $circleList  = array();

        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->ncutility->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $checkDsc = $this->NcMeetingDcModel->countDscRegistrationWithDistCode($dist_code);
        $data['dist_code'] = $dist_code;
        $data['location']  = $circleList;
        $data['checkDsc']  = $checkDsc;

        $data['_view'] = 'NcVillageService/NcMeetingDc/pending_meeting_list_dc';
        $this->load->view('layouts/main', $data);
    }


    // list of common proposals for all services
    public function listOfPendingMeetingIds()
    {

        $cir_code    = trim($this->input->post('circle'));
        $subdiv_code = trim($this->input->post('subdiv'));
        $mouza_code  = trim($this->input->post('mouza'));
        $lot_no      = trim($this->input->post('lot'));
        $village     = trim($this->input->post('vill_id'));
        $ru          = trim($this->session->userdata('user_desig_code'));
        $service     = trim($this->input->post('service_code'));
        $by_case_no  = trim($this->input->post('case_no'));
        $proposal_no = trim($this->input->post('proposal_no'));
        $dist_code   = trim($this->session->userdata('dist_code'));
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
        $this->db->where('proposal_meeting_list.nc', 1);
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM]);
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
            $this->db->where('proposal_meeting_list.nc', 1);
            $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM]);
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
                        $digitalMinutes    = '<a class="rezaButt btn btn-sm btn-danger showMinutesGenerateModal" data-id='.$rows->id.' style="color: #FFF;">Generate Digital Minutes</a>';
                        $revertBackMeeting = '<a class="rezaButt btn btn-sm  revertBackMeetingModal" data-id='.$rows->id.' style="background-color :#9C27B0; color: #FFF">Revert Back Meeting</a>';
                    }
                    else
                    {
                        $digitalMinutes = '<a class="rezaButt btn btn-sm " style="color: #FFF; background-color: #9C27B0;" href="'.base_url().'index.php/SettlementMeetingControllerDc/getPendingProposalsAgainstMeetingId/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Digital Minutes</a>';
                    }
                    if($rows->file_minute_path == '' && $rows->file_minute_path == NULL)
                    {
                        $uploadedMinutes ='';
                    }
                    else
                    {
                        $uploadedMinutes ='<a class="rezaButt btn btn-sm" style="background-color :#03A9F4" target="SdlacMinutes" href="'.base_url().'index.php/NcMeetingDc/viewSdlacUploadedMinute/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Uploaded Minutes</a>';
                    }
                    if($rows->signed_minute == 0)
                    {
                        $gurdSignedUploadCopy = '<span style="color: red; font-weight: bold">
                                        <br> Kindly upload the minutes of the meeting signed by the Guardian Minister.</span>';
                    }
                    else
                    {
                        $gurdSignedUploadCopy = '';
                    }
                    $attendance = '<a class="rezaButt btn btn-sm " style="background-color :#3F51B5" target="SdlacAttendance" href="'.base_url().'index.php/NcMeetingDc/viewSdlacAttendance/?meetingId='.$rows->id.'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Attendance</a>';
                }

                $viewMeeting ='<a class="rezaButt btn btn-sm " style="background-color :#4CAF50" href="'.base_url().'index.php/NcMeetingDc/getPendingProposalsAgainstMeetingId/?meetingId='.$rows->id.'"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View Detail</a>';

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
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

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
                    return false;
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
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

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
                if(!file_exists($path))
                {
                    return false;
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


    // get all pending  proposal under selected meeting
    public function getPendingProposalsAgainstMeetingId()
    {

        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');
        $meeting   = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcMeetingDc/pendingMeetingList");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->NcMeetingDcModel->sdlacMemberReportDetail($dist_code,$meetingId)->result();

        $additionalDoc = $this->NcMeetingDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'NcVillageService/NcMeetingDc/pending_proposals_against_meeting_id';
        $this->load->view('layouts/main', $data);
    }


    //view case nos against a proposal no
    public function viewCasesAgainstProposalNo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalNo = trim($this->input->post('propId'));

        //list of cases
        $cases = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposalNo);

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
            'proposal_name' => $this->NcMeetingDcModel->getProposalNameByProposalNo($proposalNo),
        ];
        echo json_encode($json);
        return;
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
            $meetingId   = trim($this->input->post('meetingId'));
            $meetingName = trim($this->input->post('meetingName'));
            $fileName    = $this->input->post('fileName');
            $dist_code   = $this->session->userdata('dist_code');
            $gurdDocType = $this->input->post('gurdDocType');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('nc', 1)
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
            $dist_code    = $this->session->userdata('dist_code');
            $subdiv_code  = $this->session->userdata('subdiv_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);
            if($checkMeeting == 1)
            {
                $proposals        = $this->NcMeetingDcModel->getProposalListAgainstMeetingId($meetingId,$dist_code);
                $meetingDetails   = $this->NcMeetingDcModel->getMeetingDetailsByMeetingId($meetingId,$dist_code);

                if($meetingDetails->signed_minute != 1)
                {
                    $json = [
                        'responseType' => 1,
                        'message'  => '#MREZA001:  Kindly upload the minutes of the meeting signed by the Guardian Minister',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $createdBy        = $meetingDetails->user_code;
                $districtName     = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName      = substr($districtName->locname_eng, 0, 3);
                $memoName         = $distEngName.'/MEMO-NC/'.date("Y").'/'.$meetingId;
                $allProposalCases = $this->generateProposalCases($proposals,$meetingId);
                $caseList         = $allProposalCases['final_result_array_rec'];
                $caseDivNot       = $allProposalCases['final_result_array_not_rec'];
                $sdlacReport      = $this->NcMeetingDcModel->sdlacMemberReportDetailOnlyUserCode($dist_code,$meetingId)->result();


                $subDivArray = [];
                foreach ($caseList as $key => $value)
                {
                    $subDivArray[] = $value['subdiv_code'];
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


                $allSelectedMember = [];
                $commMembers = [];
                foreach ($sdlacReport as $member)
                {
                    $allSelectedMember[] = $member->sdlac_member_code;
                }

                $allMembers = $this->NcCommonSdoAdcDcModel->getMembersFromUsers($dist_code);


                foreach ($allMembers as $mem)
                {
                    if(in_array($mem->user_code,$allSelectedMember))
                    {
                        $nominee = $this->NcMeetingDcModel->sdlacMemberReportDetailWithMeetingIdUserCode($dist_code,$meetingId,$mem->user_code);
                        if($nominee->nominee_id != 0)
                        {
                            $nn = $this->NcCommonSdoAdcDcModel->getNomineeName($nominee->nominee_id);
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

                $subDivCode      = $meetingDetails->subdiv_code;
                $createdUserCode = $meetingDetails->user_code;
                $user_desig_code = $meetingDetails->created_by;
                if($user_desig_code == MB_ADD_DEPUTY_COMM)
                {
                    $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
                }
                else
                {
                    $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
                }
                if($countCopy == 0)
                {
                    $proposalCreatedBy = '';
                }
                else
                {
                    $proposalCreatedBy = $createdUserCode;
                }

                if($meetingDetails->created_by == MB_ADD_DEPUTY_COMM)
                {
                    $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMpCount = $userMp->num_rows();
                    $userMp = $userMp->result();

                    $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMlaCount = $userMla->num_rows();
                    $userMla = $userMla->result();

                    $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userSdlacCount = $userSdlac->num_rows();
                    $userSdlacList  = $userSdlac->result();
                }
                else
                {
                    $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMpCount = $userMp->num_rows();
                    $userMp = $userMp->result();

                    $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMlaCount = $userMla->num_rows();
                    $userMla = $userMla->result();

                    $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userSdlacCount = $userSdlac->num_rows();
                    $userSdlacList  = $userSdlac->result();
                }


                if($userMpCount == 0 OR $userMlaCount == 0 OR $userSdlacCount == 0)
                {
                    $json = [
                        'responseType' => 1,
                        'message'      => 'Minutes Copy to Members are incomplete ! Kindly Contact '. $meetingDetails->created_by. ' to Add Members For Minutes Copy To ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                else
                {
                    $mpName = '';
                    $mpHPC  = '';
                    $indexM = 0;
                    foreach ($userMp as $mp)
                    {
                        if ($indexM == 0)
                        {
                            if($mp->hpc_type == 'HPC')
                            {
                                $mpName = $mp->user_name;
                                $mpHPC  = $mp->hpc_lac;
                            }
                            else
                            {
                                $mpName = $mp->user_name;
                                $mpHPC  = $mp->hpc_lac. ' '.$mp->hpc_type;
                            }

                        }
                        else
                        {
                            if($mp->hpc_type == 'HPC')
                            {
                                $mpName = $mpName . ", " . $mp->user_name;
                                $mpHPC  = $mpHPC . ", " . $mp->hpc_lac;
                            }
                            else
                            {
                                $mpName = $mpName . ", " . $mp->user_name;
                                $mpHPC  = $mpHPC . ", " . $mp->hpc_lac. ' '.$mp->hpc_type;
                            }
                        }
                        $indexM++;
                    }

                    $mlaName = '';
                    $mlaLAC = '';
                    $index = 0;
                    foreach ($userMla as $mla)
                    {
                        if ($index == 0)
                        {
                            $mlaName = $mla->user_name;
                            $mlaLAC = $mla->hpc_lac;
                        }
                        else
                        {
                            $mlaName = $mlaName . ", " . $mla->user_name;
                            $mlaLAC = $mlaLAC . ", " . $mla->hpc_lac;
                        }
                        $index++;
                    }


                    $zpcName = '';
                    $municipalName = '';
                    $socialWorker = '';
                    $indexM = 0;
                    $indexS = 0;
                    foreach ($userSdlacList as $user)
                    {
                        if($user->user_level == 6)
                        {
                            $zpcName = $user->user_name;
                        }
                        if($user->user_level == 7)
                        {
                            if ($indexM == 0)
                            {
                                $bn = '';
                                if($user->board_name != '')
                                {
                                    $bn = '(' .$user->board_name. ') ';
                                }
                                $municipalName = $user->user_name.$bn;
                            }
                            else
                            {
                                $bn = '';
                                if($user->board_name != '')
                                {
                                    $bn = '(' .$user->board_name. ') ';
                                }
                                $municipalName = $municipalName . ", " . $user->user_name.$bn;                            }
                            $indexM++;
                        }
                        if($user->user_level == 8)
                        {
                            if ($indexS == 0)
                            {
                                $socialWorker = $user->user_name;
                            }
                            else
                            {
                                $socialWorker = $socialWorker . "," . $user->user_name;
                            }
                            $indexS++;
                        }

                    }


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
                        'mpName' => $mpName,
                        'mpHPC' => $mpHPC,
                        'mlaName' => $mlaName,
                        'mlaLAC' => $mlaLAC,
                        'zpcName' => $zpcName,
                        'municipalName' => $municipalName,
                        'socialWorker' => $socialWorker,
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


    // All recommended / not recommended cases By MRIDU SIR
    public function generateProposalCases($proposals, $meetingId)
    {
        //FOR_PROGRESS
        $session_status = 0;
        $log_status     = 0;
        $tmp_file       = null;
        $dist_code      = $this->session->userdata('dist_code');
        try
        {
            $prop  = '';
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

            $sql = "SELECT t.case_no, t.proposal_id,t.remark,t.case_status,s.subdiv_code FROM settlement_basic s JOIN (
                    SELECT  case_no,  proposal_id,
    		                sc.template_remarks as  remark, sc.case_status FROM settlement_proposal_cases sc
    		                WHERE sc.proposal_id IN ($prop)
    		                ) t ON s.case_no=t.case_no ORDER BY s.dist_code,s.subdiv_code,s.cir_code";

            $result = $this->db->query($sql)->result();
            $sql    = "SELECT id,proposal_name FROM settlement_proposal_list WHERE id in ($prop)";
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
    			    vill_townprt_code = s.vill_townprt_code) as village,applid, service_code from settlement_basic s where case_no='$r->case_no'";
                $locations = $this->db->query($sql)->row();

                $sql = " select string_agg(distinct(eng_pdar_name || '---' || eng_pdar_guardian || ''),',') as name from 
    	    	          settlement_applicant where case_no='$r->case_no' and pdar_type='B'";
                $applicants = $this->db->query($sql)->row();

                $sql = " select STRING_AGG(sp.dag_no||'---' || sp.total_lessa::VARCHAR || '',',') as dags from settlement_premium sp
                  where case_no='$r->case_no' and is_final = 1";
                $dags = $this->db->query($sql)->row();

                $sql = " select string_agg((sd.land_type),',') ladtype from settlement_dag_details sd 
    	    	       where case_no='$r->case_no'";
                $land_type = $this->db->query($sql)->row();

                $result_array[] = array(
                    "cirname"       => $locations->cirname,
                    "mouza"         => $locations->mouza,
                    "village"       => $locations->village,
                    "applid"        => $locations->applid,
                    "service_code"  => $locations->service_code,
                    "name"          => $applicants->name,
                    "dags"          => $dags->dags,
                    "ladtype"       => $land_type->ladtype,
                    "subdiv_code"   => $r->subdiv_code,
                    "case_no"       => $r->case_no,
                    "case_status"   => $r->case_status,
                    "remark"        => $r->remark,
                    "proposal_name" => $props[$r->proposal_id]

                );
                if ($log_status == 1)
                {
                    log_message('error','case_count: '.$row_count.', time taken='.(microtime(true)-$st_time));
                }
            }


            $serviceNames[NC_KHAS_LAND_ID]  = $this->lang->line('ncKhasLandTitle');
            $serviceNames[NC_CULTIVATOR_ID] = $this->lang->line('ncCultivatorTitle');
            $serviceNames[NC_TRIBAL_ID]     = $this->lang->line('ncTribalTitle');

            foreach ($result_array as $row)
            {
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
                            $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa2($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                            $final_area = $final_area . $bklArea;
                        }
                        else
                        {
                            $final_dag  = $final_dag . $final_all[0];
                            $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                            $final_area = $final_area . $bklArea;
                        }
                    }
                    else
                    {
                        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $final_dag  = $final_dag . $final_all[0].'<br>';
                            $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa2($final_all[1]);
                            $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                            $final_area = $final_area . $bklArea.'<br>';
                        }
                        else
                        {
                            $final_dag  = $final_dag . $final_all[0].'<br>';
                            $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa($final_all[1]);
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
                        "remark" =>  $row['remark'],
                        "ladtype"=>	$row['ladtype'],
                        "status"=>	$row['case_status']
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
                        "status"=>	$row['case_status']
                    );
                }
            }


            $final_result_array = array(
                'final_result_array_rec' =>
                    (isset($final_result_array_rec) && $final_result_array_rec != NULL)? $final_result_array_rec: '',
                'final_result_array_not_rec' =>
                    (isset($final_result_array_not_rec) && $final_result_array_not_rec != NULL)? $final_result_array_not_rec: '',
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

            $dist_name    = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
            $distEngName  = substr($dist_name->locname_eng, 0, 3);
            $fileName     = $distEngName.'_SDLAC_NC_'.$dist_code.'_'.date("Y").'_'.$meetingId;
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);
            if($checkMeeting == 1)
            {

                if(MB2_DIGITAL_SIGN_LIVE_NC == 1)
                {
                    include 'vendor/mpdf/vendor/autoload.php';
                    $mpdf=new \Mpdf\Mpdf();
                    if(MB2_DIGITAL_SIGN_DRAFT_MODE_NC == 1)
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
                    if(MB2_DIGITAL_SIGN_DRAFT_MODE_NC == 1)
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

            $dist_code    = $this->session->userdata('dist_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $pdfData      = $this->input->post('pdfData');
            $dist_name    = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
            $distEngName  = substr($dist_name->locname_eng, 0, 3);
            $fileName     = $distEngName.'_SDLAC_NC_'.$dist_code.'_'.date("Y").'_'.$meetingId;
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);

            if($checkMeeting != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ER-MR001546: Meeting not found ! Kindly contact system administrator',

                ));
                return;
            }

            //get list of proposals
            $getProposalsList = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();

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

                $proposal_no  = $prop->proposal_id;
                $proposalDetails = $this->NcMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
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
                    $pendingCase = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
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

                        $case_no = trim($case->case_no);
                        $user_code       = $this->session->userdata('user_code');
                        $proposal_id     = $proposal_no;
                        $proposal_no_int = (int)$proposal_no;
                        $remarks         = 'DC verification done & Recommended';
                        $dag             = $this->NcCommonSdoAdcDcModel->getSettlementDagCommon($case_no);
                        $urbanByLm       = $this->NcCommonSdoAdcDcModel->getLandFallsUnderUrban($case_no);
                        $basic           = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($case_no);


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
                            if($basic['approve_by'] == '')
                            {
                                if(strtoupper($dag->is_urban) == 'Y' || (strtoupper($dag->is_urban) == 'N' && strtoupper($urbanByLm->falls_und_gmc) == YES))
                                {
                                    $finalApprovedBy = 1; // dept
                                }
                                if($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc != YES)
                                {
                                    $wedLandStatus = $this->NcCommonSdoAdcDcModel->caseUnderDeptOrDCByWetLand($case_no);
                                    if($wedLandStatus == 1)
                                    {
                                        $finalApprovedBy = 1; // dept

                                        // update basic
                                        $updateBasicForWedL = [
                                            'is_wed_land' => 1,
                                            'approve_by'  => 'GOVT',
                                        ];
                                        $this->db->where('case_no', $case_no);
                                        $this->db->update('settlement_basic', $updateBasicForWedL);
                                        if($this->db->affected_rows() !=1)
                                        {
                                            $this->db->trans_rollback();
                                            log_message('error', '#MR0002132: Updation failed in settlement_basic '
                                                .$this->db->last_query());
                                            echo json_encode(array(
                                                'responseType' => 1,
                                                'message'      => '#MR0002132: Unable to process for final approval. 
                                                                     !! Kindly contact system administrator',
                                            ));
                                            return;
                                        }
                                    }
                                    else
                                    {
                                        $finalApprovedBy = 2; // dc
                                    }
                                }
                            }
                            else if($basic['approve_by'] != '')
                            {
                                if($basic['approve_by'] == 'GOVT')
                                {
                                    $finalApprovedBy = 1; // dept
                                }
                                if($basic['approve_by'] == 'DC')
                                {
                                    $wedLandStatus = $this->NcCommonSdoAdcDcModel->caseUnderDeptOrDCByWetLand($case_no);
                                    if($wedLandStatus == 1)
                                    {
                                        $finalApprovedBy = 1; // dept
                                        // update basic
                                        $updateBasicForWedL = [
                                            'is_wed_land' => 1,
                                            'approve_by'  => 'GOVT',
                                        ];
                                        $this->db->where('case_no', $case_no);
                                        $this->db->update('settlement_basic', $updateBasicForWedL);
                                        if($this->db->affected_rows() !=1)
                                        {
                                            $this->db->trans_rollback();
                                            log_message('error', '#MR0002161: Updation failed in settlement_basic '
                                                .$this->db->last_query());
                                            echo json_encode(array(
                                                'responseType' => 1,
                                                'message'      => '#MR0002161: Unable to process for final approval. 
                                                                     !! Kindly contact system administrator',
                                            ));
                                            return;
                                        }
                                    }
                                    else
                                    {
                                        $finalApprovedBy = 2; // dc
                                    }
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
                            if($this->NcMeetingDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updateProReject) == 0)
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

                            //*****update in settlement_basic */
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
                            $this->db->update('settlement_basic', $basic_update_arr);
                            if($this->db->affected_rows() <= 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR0001458: Updation failed in settlement_basic '
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

                            $sql = "select MAX(proceeding_id)+1 as id from settlement_proceeding where
                            case_no=? ";
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
                                $application_no = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no)->applid;
                                $rmk    = 'Rejected by SDLAC: '.$rejectedReasonList;
                                $status = 'R';
                                $task   = 'SDLAC';
                                $pen    = 'NA';
//                                $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2nd
//                                ($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);
//
//                                if (trim($rtps_status)!="y")
//                                {
//                                    $this->db->trans_rollback();
//                                    log_message('error', '#MR0001555: Issue in API Call'
//                                        .$this->db->last_query());
//                                    echo json_encode(array(
//                                        'responseType' => 3,
//                                        'message'      => '#MR0001555: Unable to process for final approval.
//                                              Kindly contact system administration !!!',
//                                    ));
//                                    return;
//                                }
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
                        $count_updateData_db = $this->updateBatch('settlement_basic',$updateDataUrban, 'case_no', $allCasesUrbanByProposal);
                        if ($count_updateData != $count_updateData_db)
                        {

                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR0002874: Unable to batch update settlement_basic  final approval. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                    }


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
                        $count_updateData = count($allCasesRuralByProposal);
                        $count_updateData_db = $this->updateBatch('settlement_basic',$updateDataRural, 'case_no', $allCasesRuralByProposal);
                        if ($count_updateData != $count_updateData_db)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MR0002874: Unable to batch update settlement_basic  final approval. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }
                    }

                    $dataUpdate = array(
                        'final_verify_status' => 2,
                        'dept_status' => 1
                    );
                    if($this->NcMeetingDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
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

            //ALL CASE UPDATES
            $updatePro = array(
                'status' => PRO_CASE_STATUS_APPROVE,
                'approved_by_dc' => 1,
                'updated_at'     => date('Y-m-d h:i:s'),
            );
            //URBAN CASES
            if (isset($allAPICasesUrban))
            {
                $count_updatePro = count($allAPICasesUrban);
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
            //RURAL CASES
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
            $this->db->where(['id' => $meetingId, 'dist_code' => $dist_code, 'nc' => 1]);
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

            //////////////POST To basundhara Bulk Urban////////////////////
            if (isset($allAPICasesUrban) && count($allAPICasesUrban)>0)
            {
                $caseAppUrban = $this->NcCommonSdoAdcDcModel->convertLiteral($allAPICasesUrban);
                $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppUrban)";
                $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

                $rmk    = 'Forwarded to Department';
                $status = 'M';
                $task   = MB_DEPUTY_COMM;
                $pen    = MB_DEPARTMENT;
                $rtps_status=$this->NcApiModel->applicationStatusUpdateBulk($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
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

            //////////////POST To basundhara Bulk Rural////////////////////
            if (isset($allAPICasesRural) && count($allAPICasesRural)>0)
            {
                $caseAppRural = $this->NcCommonSdoAdcDcModel->convertLiteral($allAPICasesRural);
                $caseAppRuralSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppRural)";
                $allAPICasesRuralIds   = $this->db->query($caseAppRuralSql)->row()->applids;

                $rmk    = 'Forwarded To CO';
                $status = 'M';
                $task   = MB_DEPUTY_COMM;
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status = $this->NcApiModel->applicationStatusUpdateBulk($allAPICasesRuralIds,'NA',$rmk,$status,$task,$pen);
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
        $endDate = HOLD_CASES_FORWARD_TO_DEPT_BY_DC_NC;
        $today   = date('Y-m-d H:i:s');
        $finalApprovedBy = 2; // dc
        if(strtotime($endDate) < strtotime($today))
        {
            $basic = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($case_no);
            if(trim($basic['final_status']) == MB_APPROVED_BY_SDLAC)
            {
                $dag       = $this->NcCommonSdoAdcDcModel->getSettlementDagCommon($case_no);
                $urbanByLm = $this->NcCommonSdoAdcDcModel->getLandFallsUnderUrban($case_no);
                if($basic['approve_by'] == '')
                {
                    if(strtoupper($dag->is_urban) == 'Y' || (strtoupper($dag->is_urban) == 'N' && strtoupper($urbanByLm->falls_und_gmc) == YES))
                    {
                        $finalApprovedBy = 1; // dept
                    }
                    if($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc != YES)
                    {
                        $wedLandStatus = $this->NcCommonSdoAdcDcModel->caseUnderDeptOrDCByWetLand($case_no);
                        if($wedLandStatus == 1)
                        {
                            $finalApprovedBy = 1; // dept
                        }
                    }
                }
                elseif($basic['approve_by'] != '')
                {
                    if($basic['approve_by'] == 'GOVT')
                    {
                        $finalApprovedBy = 1; // dept
                    }
                    if($basic['approve_by'] == 'DC')
                    {
                        $wedLandStatus = $this->NcCommonSdoAdcDcModel->caseUnderDeptOrDCByWetLand($case_no);
                        if($wedLandStatus == 1)
                        {
                            $finalApprovedBy = 1; // dept
                        }
                    }
                }
                else
                {
                    $finalApprovedBy = 3;
                }
            }
        }

        return $finalApprovedBy;
    }


    // verify cases for Modification request & Chitha Area check
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

            $dist_code    = $this->session->userdata('dist_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $errorArray   = array();
            $pullArray    = array();
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);
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
            $getProposalsList = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();
            foreach($getProposalsList as $prop)
            {

                //FOR PROGRESS
                $final_prop_st_time = microtime(true);

                $proposal_no  = $prop->proposal_id;
                $proposalDetails = $this->NcMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
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
                    $pendingCase = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
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
                        $caseCount = $this->NcMeetingDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($case_no,$dist_code);

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
                        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                        $pullCheck = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
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
                        if($checkArea != 0)
                        {
                            $errorArray[] = $case_no;
                        }
                        if($pullCheck!=null && $pullCheck->pull_request == 1)
                        {
                            $pullArray[] = $case_no;
                        }
                        if($checkArea != 0 OR $pullCheck->pull_request == 0 OR $deptCheck != 1)
                        {
                            continue;
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
        } catch (Exception $e) {
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


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags                 = $this->NcCommonSdoAdcDcModel->getNcApplicationDag($application_no);
        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck            = 0;
        $appliedDags          = $dags;
        $basic                = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($application_no);
        $service_code         = trim($basic['service_code']);

        if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $application_no");
            redirect(base_url() . "index.php/home");
            return false;
        }


        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
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

            $chithaDag = $this->NcCommonSdoAdcDcModel->getNcChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocationNotSubmit(
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


                if($basic['dc_proceeding'] == 0)
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

                if($basic['dc_proceeding'] == 0)
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

        return $areaCheck;
    }


    // delete proposal with zero cases
    public function deleteProposalWithZeroCasesForPendingMeetingByDc()
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
            $proposalCount = $this->NcCommonSdoAdcDcModel->countSettlementProposalList($pro);
            if($proposalCount == 0 || $proposalCount == '')
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD02993: Proposal not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $caseCount = $this->NcMeetingDcModel->countCasesWithProposalId($pro);
            if($caseCount != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03004: There is some cases under the Proposal, You cannot Delete ',
                ]);
                return false;
            }

            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($pro);
            if($proposalDetails == '' || $proposalDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD03015: Meeting not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $meetingDetails = $this->NcMeetingDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
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

            $checkProDeleted = $this->NcMeetingDcModel->countSettlementProposalListDeleted($pro);
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
                'nc'                     => 1,
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
            $deletePro = $this->NcMeetingDcModel->deleteSettlementProposalByProId($proDel,$dist_code);
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


    // update batch Query By MRIDU SIR
    public function updateBatch($table, $data, $where_filed, $where_array)
    {
        $sql = "update $table set ";
        //var_dump($data);
        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . '=\'' . $value . '\', ';
        }
        $sql = substr(trim($sql), 0, -1);
        $caseApp = $this->NcCommonSdoAdcDcModel->convertLiteral($where_array);
        $sql = $sql . ' where '.$where_filed.' in ('.$caseApp.')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }





    // *****  Reverted meeting to ADC/SDO ****** ///

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
            $dist_code    = $this->session->userdata('dist_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);

            if($checkMeeting == 1)
            {
                $meetingDetails = $this->NcMeetingDcModel->getMeetingDetailsByMeetingId($meetingId,$dist_code);

                echo json_encode(array(
                    'responseType'      => 2,
                    'meetingId'         => $meetingId,
                    'revertMeetingName' => $meetingDetails->meeting_name,
                    'revertBackTo'      => $meetingDetails->created_by,
                ));

                return;
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
            $dist_code    = $this->session->userdata('dist_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutes($meetingId,$dist_code);

            if($checkMeeting == 1)
            {
                $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

                //list of proposals against meeting id
                $getProposal = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId);

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
                    'user_code'  => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation'  => 'E',
                    'ip'         => $this->utilityclass->get_client_ip(),
                    'office_from'=> MB_DEPUTY_COMM,
                    'office_to'  => $revertedTo,
                    'task'       => 'Reverted to '.$revertedTo,
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
                        $proceeding_case['case_no']       = $row->case_no;
                        $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                        $proceeding_case['note_on_order'] = 'Reverted by DC';
                        $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                        $proceeding_case['status'] = MB_REVERT;
                        $final_proceeding_case[]   = $proceeding_case;
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
                        $proceeding_case['case_no']       = $row->case_no;
                        $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                        $proceeding_case['note_on_order'] = 'Reverted by DC';
                        $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                        $proceeding_case['status'] = MB_REVERT;
                        $final_proceeding_case[]   = $proceeding_case;
                    }

                }


                // batch insert into settlement_basic for recommended
                if (isset($allAPICases_reco) && count($allAPICases_reco)>0)
                {
                    $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_rec,
                        'case_no',$allAPICases_reco);
                    if($recomend_count != $update_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002198: Updation failed in settlement_basic for meeting reverted (recommended) '.$this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#MRDC002198: Meeting can not be reverted. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

                // batch insert into settlement_basic for not recommended
                if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0)
                {
                    $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_nrec,
                        'case_no',$allAPICases_nrec );
                    if($notrecomend_count != $update_count)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRDC002217: Updation failed in settlement_basic for meeting reverted (not recommended) '.$this->db->last_query());
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
                $this->db->where('nc', 1);
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

                $caseApp = $this->NcCommonSdoAdcDcModel->convertLiteral($allAPICases);

                $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
                $applids = $this->db->query($sql)->row()->applids;

                //api call
                $rmk    = 'DC Revert to '.$revertedTo.' for modification';
                $status = 'M';
                $task   = $this->session->userdata['user_desig_code'];
                $pen    = $revertedTo;
                $rtps_status = $this->NcApiModel->applicationStatusUpdateBulk($applids,'NA',$rmk,$status,$task,$pen);

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


    // all approved meeting list
    public function approvedMeetingList()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_update_status', 0);
        $this->db->where('proposal_meeting_list.dc_approve_status', 1);
        $this->db->where('proposal_meeting_list.nc', 1);
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();


        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'NcVillageService/NcMeetingDc/approve_meeting_list_for_approval';
        $this->load->view('layouts/main', $data);
    }


    // view Digital Minutes
    public function getDigitalMinutesWithMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

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
                    return false;
                }
            }
            else
            {
                $path = $meetingDetails->encode_pdf_dir_path;
            }
            $mainfile = file_get_contents($meetingDetails->encode_pdf_dir_path);
            $conType  = mime_content_type($meetingDetails->encode_pdf_dir_path);
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


    // get all  approved proposal under selected meeting
    public function getApprovedProposalsAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();
        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcMeetingDc/meetingApprovedLandPage");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport   = $this->NcMeetingDcModel->sdlacMemberReportDetail($dist_code,$meetingId)->result();
        $additionalDoc = $this->NcMeetingDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'NcVillageService/NcMeetingDc/approved_proposals_against_meeting_id';
        $this->load->view('layouts/main', $data);
    }

    ////////////// Reverted meeting to ADC/SDO ///////////////////////




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
        $this->db->where('proposal_meeting_list.nc', 1);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();

        $data['meetingCount'] = $total_records;
        $data['meetings']     = $meetings;

        $data['_view'] = 'NcVillageService/NcMeetingDc/pending_meeting_for_digital_resigning';
        $this->load->view('layouts/main', $data);
    }


    // get all Digital Resigning proposal under selected meeting
    public function getResigningProposalsAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');

        $meeting     = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();
        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcMeetingDc/approvedMeetingList");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport   = $this->NcMeetingDcModel->sdlacMemberReportDetail($dist_code, $meetingId)->result();
        $additionalDoc = $this->NcMeetingDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'NcVillageService/NcMeetingDc/pending_resigning_proposals_against_meeting_id';
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
            $dist_code    = $this->session->userdata('dist_code');
            $subdiv_code  = $this->session->userdata('subdiv_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutesResigning($meetingId,$dist_code);
            if($checkMeeting == 1)
            {
                $proposals      = $this->NcMeetingDcModel->getProposalListAgainstMeetingId($meetingId,$dist_code);
                $meetingDetails = $this->NcMeetingDcModel->getMeetingForGenerateMinutesResigning($meetingId,$dist_code);
                $createdBy      = trim($meetingDetails->user_code);
                $districtName   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName    = substr($districtName->locname_eng, 0, 3);
                $memoName       = $distEngName.'/MEMO-NC/'.date('Y', strtotime($meetingDetails->meeting_date)).'/'.$meetingId;

                $allProposalCases = $this->generateProposalCases($proposals,$meetingId);
                $caseList    = $allProposalCases['final_result_array_rec'];
                $caseDivNot  = $allProposalCases['final_result_array_not_rec'];
                $sdlacReport = $this->NcMeetingDcModel->sdlacMemberReportDetailOnlyUserCode($dist_code, $meetingId)->result();

                $subDivArray = [];
                foreach ($caseList as $key => $value)
                {
                    $subDivArray[] = $value['subdiv_code'];
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


                $allSelectedMember = [];
                $commMembers = [];
                foreach ($sdlacReport as $member)
                {
                    $allSelectedMember[]= $member->sdlac_member_code;
                }
                $allMembers = $this->NcCommonSdoAdcDcModel->getMembersFromUsers($dist_code);
                foreach ($allMembers as $mem)
                {
                    if(in_array($mem->user_code,$allSelectedMember))
                    {
                        $commMembers[] = $mem;
                    }
                }

                $subDivCode = trim($meetingDetails->subdiv_code);
                $createdUserCode = $meetingDetails->user_code;
                $user_desig_code = $meetingDetails->created_by;
                if($user_desig_code == MB_ADD_DEPUTY_COMM)
                {
                    $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
                }
                else
                {
                    $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
                }
                if($countCopy == 0)
                {
                    $proposalCreatedBy = '';
                }
                else
                {
                    $proposalCreatedBy = $createdUserCode;
                }
                if($meetingDetails->created_by == MB_ADD_DEPUTY_COMM)
                {
                    $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMpCount = $userMp->num_rows();
                    $userMp = $userMp->result();

                    $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMlaCount = $userMla->num_rows();
                    $userMla = $userMla->result();

                    $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyTo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userSdlacCount = $userSdlac->num_rows();
                    $userSdlacList  = $userSdlac->result();
                }
                else
                {
                    $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMpCount = $userMp->num_rows();
                    $userMp = $userMp->result();

                    $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userMlaCount = $userMla->num_rows();
                    $userMla = $userMla->result();

                    $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyToForSdo($dist_code,$subDivCode,$proposalCreatedBy);
                    $userSdlacCount = $userSdlac->num_rows();
                    $userSdlacList  = $userSdlac->result();
                }

                if($userMpCount == 0 OR $userMlaCount == 0 OR $userSdlacCount == 0)
                {
                    $json = [
                        'responseType' => 1,
                        'message'      => 'Minutes Copy to Members are incomplete ! Kindly Contact '. $meetingDetails->created_by. ' to Add Members For Minutes Copy To ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                else
                {
                    $mpName = '';
                    $mpHPC  = '';
                    $indexM = 0;
                    foreach ($userMp as $mp)
                    {
                        if ($indexM == 0)
                        {
                            if($mp->hpc_type == 'HPC')
                            {
                                $mpName = $mp->user_name;
                                $mpHPC  = $mp->hpc_lac;
                            }
                            else
                            {
                                $mpName = $mp->user_name;
                                $mpHPC  = $mp->hpc_lac. ' '.$mp->hpc_type;
                            }

                        }
                        else
                        {
                            if($mp->hpc_type == 'HPC')
                            {
                                $mpName = $mpName . ", " . $mp->user_name;
                                $mpHPC  = $mpHPC . ", " . $mp->hpc_lac;
                            }
                            else
                            {
                                $mpName = $mpName . ", " . $mp->user_name;
                                $mpHPC  = $mpHPC . ", " . $mp->hpc_lac. ' '.$mp->hpc_type;
                            }
                        }
                        $indexM++;
                    }

                    $mlaName = '';
                    $mlaLAC = '';
                    $index = 0;
                    foreach ($userMla as $mla)
                    {
                        if ($index == 0)
                        {
                            $mlaName = $mla->user_name;
                            $mlaLAC = $mla->hpc_lac;
                        }
                        else
                        {
                            $mlaName = $mlaName . ", " . $mla->user_name;
                            $mlaLAC = $mlaLAC . ", " . $mla->hpc_lac;
                        }
                        $index++;
                    }


                    $zpcName = '';
                    $municipalName = '';
                    $socialWorker = '';
                    $indexM = 0;
                    $indexS = 0;
                    foreach ($userSdlacList as $user)
                    {
                        if($user->user_level == 6)
                        {
                            $zpcName = $user->user_name;
                        }
                        if($user->user_level == 7)
                        {
                            if ($indexM == 0)
                            {
                                $bn = '';
                                if($user->board_name != '')
                                {
                                    $bn = '(' .$user->board_name. ') ';
                                }
                                $municipalName = $user->user_name.$bn;
                            }
                            else
                            {
                                $bn = '';
                                if($user->board_name != '')
                                {
                                    $bn = '(' .$user->board_name. ') ';
                                }
                                $municipalName = $municipalName . ", " . $user->user_name.$bn;                            }
                            $indexM++;
                        }
                        if($user->user_level == 8)
                        {
                            if ($indexS == 0)
                            {
                                $socialWorker = $user->user_name;
                            }
                            else
                            {
                                $socialWorker = $socialWorker . "," . $user->user_name;
                            }
                            $indexS++;
                        }

                    }


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
                        'mpName' => $mpName,
                        'mpHPC' => $mpHPC,
                        'mlaName' => $mlaName,
                        'mlaLAC' => $mlaLAC,
                        'zpcName' => $zpcName,
                        'municipalName' => $municipalName,
                        'socialWorker' => $socialWorker,
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

        $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutesResigning($meetingId,$dist_code);
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
        $getProposalsList = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();
        foreach($getProposalsList as $prop)
        {
            $final_prop_st_time = microtime(true);

            $proposal_no     = $prop->proposal_id;
            $proposalDetails = $this->NcMeetingDcModel->getProposalDetailsById($proposal_no,$dist_code);
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
                $pendingCase = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
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

                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    $pullCheck = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
                    log_message('error','case_count: '.$count_mridu.', time taken='.(microtime(true)-$st_time));
                    if($checkArea != 0)
                    {
                        $errorArray[] = $case_no;
                    }
                    if($pullCheck->pull_request == 1)
                    {
                        $pullArray[] = $case_no;
                    }
                    if($checkArea != 0 OR $pullCheck->pull_request == 0)
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
            $dist_code    = $this->session->userdata('dist_code');
            $subdiv_code  = $this->session->userdata('subdiv_code');
            $meetingId    = $this->input->post('meetingIdDigital');
            $html1        = base64_decode($this->input->post('html1'));
            $html2        = $this->input->post('html2');
            $html3        = $this->input->post('html3');
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutesResigning($meetingId,$dist_code);
            if($checkMeeting == 1)
            {
                $meetingDetails = $this->NcMeetingDcModel->getMeetingForGenerateMinutesResigning($meetingId,$dist_code);
                $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName = substr($dist_name->locname_eng, 0, 3);
                $fileName    = $distEngName.'_SDLAC_NC_'.$dist_code.'_'.date('Y', strtotime($meetingDetails->meeting_date)).'_'.$meetingId;
                $timeUpdate  = '_'.date('YmdHiss');

                $nn = explode('/',$meetingDetails->encode_pdf_dir_path);
                $kk = count($nn);
                $jj = $nn[$kk-1];
                $lastString = explode('.', $jj);
                $lastFileName = $lastString[0];


                $updateFileName = SIGNPDF_UPLOAD_DIR.$lastFileName.$timeUpdate.'.pdf';
                $oldFileName    = SIGNPDF_UPLOAD_DIR.$lastFileName.'.pdf';
                rename($oldFileName,$updateFileName);


                include 'vendor\mpdf\vendor\autoload.php';
                $mpdf=new \Mpdf\mPDF();
                if(MB2_DIGITAL_SIGN_DRAFT_MODE_NC == 1)
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
            $dist_code    = $this->session->userdata('dist_code');
            $meetingId    = trim($this->input->post('meetingId'));
            $pdfData      = $this->input->post('pdfData');
            $checkMeeting = $this->NcMeetingDcModel->checkMeetingForGenerateMinutesResigning($meetingId,$dist_code);
            if($checkMeeting == 1)
            {
                $meetingDetails = $this->NcMeetingDcModel->getMeetingForGenerateMinutesResigning($meetingId,$dist_code);
                $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName = substr($dist_name->locname_eng, 0, 3);
                $fileName    = $distEngName.'_SDLAC_NC_'.$dist_code.'_'.date('Y', strtotime($meetingDetails->meeting_date)).'_'.$meetingId;

                $base64PDFData = $pdfData;
                $uploadpath    = SIGNPDF_UPLOAD_DIR;
                file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));
                $updateMeetingID = array(
                    'encode_pdf_dir_path'        => $uploadpath.$fileName.".pdf",
                    'digital_sign_update_status' => 0,
                    'digital_resign_date'        => date('Y-m-d H:i:s')
                );
                $this->db->where(['id' => $meetingId, 'dist_code' => $dist_code, 'nc' => 1]);
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
        $proposalIds      = $this->input->post('proposalIds');
        $proposalName     = $this->input->post('proposalName');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');

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
            $proposalCount = $this->NcCommonSdoAdcDcModel->countSettlementProposalList($pro);
            if($proposalCount == 0 || $proposalCount == '')
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04333: Proposal not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $caseCount = $this->NcMeetingDcModel->countCasesWithProposalId($pro);
            if($caseCount != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04343: There is some cases under the Proposal, You cannot Delete ',
                ]);
                return false;
            }

            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($pro);
            if($proposalDetails == '' || $proposalDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04353: Meeting not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $meetingDetails = $this->NcMeetingDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
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

            $checkProDeleted = $this->NcMeetingDcModel->countSettlementProposalListDeleted($pro);
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
                'nc'                     => 1,
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
            $deletePro = $this->NcMeetingDcModel->deleteSettlementProposalByProId($proDel,$dist_code);
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

        $sqlForRevertList = 'select distinct pml.meeting_name,pml.id as meeting_id,pml.meeting_venue,pml.meeting_date from settlement_basic sb  
                                join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                join settlement_proposal_list spl on spc.proposal_id = spl.id
                                join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                    where sb.dist_code=? and sb.dept_revert=? 
                                    and sb.pending_officer=? and sb.from_office=? and sb.service_code=?';
        $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,MB_DEPUTY_COMM,MB_DEPARTMENT,NC_KHAS_LAND_ID));
        $total_records = $query1->num_rows();
        $meetings      = $query1->result();
        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'NcVillageService/NcMeetingDc/reverted_meeting_list_by_department_dc_nc';
        $this->load->view('layouts/main', $data);
    }


    // get all  reverted proposal under selected meeting
    public function getRevertedProposalsAgainstMeetingId()
    {

        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');
        $meeting   = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcMeetingDc/revertedMeetingByDepartmentForDC");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->NcMeetingDcModel->getProposalDetailAgainstMeetingId($dist_code,$meetingId)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->NcMeetingDcModel->sdlacMemberReportDetail($dist_code,$meetingId)->result();

        $additionalDoc = $this->NcMeetingDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();


        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'NcVillageService/NcMeetingDc/reverted_dept_proposals_against_meeting_id_nc';

        $this->load->view('layouts/main', $data);

    }


    // reverted cases under meeting list by dept
    public function getRevertedCasesDeptAgainstMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        if($meetingId == null){
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/SettlementMeetingControllerDcIns/revertedMeetingByDepartmentForDC");
        }
        $dist_code = $this->session->userdata('dist_code');
        $meeting = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID(
            $meetingId)->row();
        $meetingName = null;
        if(!empty($meeting) && $meeting != null)
        {
            $meetingName = trim($meeting->meeting_name);
            if($meetingName == '')
            {
                $this->session->set_flashdata('error', "Meeting Not Found !");
                redirect(base_url() . "index.php/NcMeetingDc/revertedMeetingByDepartmentForDC");
            }
        }
        else
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcMeetingDc/revertedMeetingByDepartmentForDC");
        }
        $data['meetingName'] = $meetingName;
        $data['meeting_id'] = $meetingId;

        $sqlForRevertList = 'select distinct sb.case_no, sb.service_code,(select note_on_order from settlement_proceeding sp where sp.case_no = sb.case_no 
                             and office_from=? and office_to =? and status=? order by id desc limit 1) as note_on_order from settlement_basic sb  
                             join settlement_proposal_cases spc on sb.case_no = spc.case_no
                             join settlement_proposal_list spl on spc.proposal_id = spl.id
                             join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                             where sb.dist_code=? and sb.dept_revert=? and pml.id =? and meeting_name = ? 
                             and sb.pending_officer = ? and sb.service_code =?';
        $query1 = $this->db->query($sqlForRevertList,array(MB_DEPARTMENT,MB_DEPUTY_COMM,'R',$dist_code,1,$meetingId,$meetingName,MB_DEPUTY_COMM,NC_KHAS_LAND_ID));
        $total_records = $query1->num_rows();
        $caselist      = $query1->result();

        $data['caseCount'] = $total_records;
        $data['caselist'] = $caselist;

        $data['_view'] = 'NcVillageService/NcMeetingDc/reverted_cases_by_department_dc_nc';
        $this->load->view('layouts/main', $data);
    }


    // reverted case array
    public function getAllDeptRevertedCases()
    {
        $dist_code    = $this->session->userdata('dist_code');
        $meeting_id   = trim($this->input->post('meeting_id'));
        $meeting_name = trim($this->input->post('meeting_name'));
        if($meeting_name == null || $meeting_id == null)
        {
            echo json_encode(array('responseType' => 3,'select_cases' => null));
            return;
        }
        $sqlForRevertList = "select string_agg(distinct sb.case_no::text, ',') from settlement_basic sb  
                                join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                join settlement_proposal_list spl on spc.proposal_id = spl.id
                                join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                    where sb.dist_code=? and sb.dept_revert=? and sb.service_code =?
                                    and sb.pending_officer=? and sb.from_office=? and pml.id =? and meeting_name = ?";
        $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,NC_KHAS_LAND_ID,MB_DEPUTY_COMM,MB_DEPARTMENT,$meeting_id,$meeting_name));
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
            $dist_code       = $this->session->userdata('dist_code');
            $meeting_id      = trim($this->input->post('meetingIdNew'));
            $user_code       = $this->session->userdata('user_code');
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

            $sqlForRevertList = 'select distinct sb.case_no from settlement_basic sb  
                                 join settlement_proposal_cases spc on sb.case_no = spc.case_no
                                 join settlement_proposal_list spl on spc.proposal_id = spl.id
                                 join proposal_meeting_list pml on spl.proposal_meeting_id = pml.id
                                 where sb.dist_code=? and sb.dept_revert=? 
                                 and sb.pending_officer=? and sb.from_office=? and pml.id =?  and sb.service_code=?';
            $query1 = $this->db->query($sqlForRevertList,array($dist_code,1,MB_DEPUTY_COMM,MB_DEPARTMENT,$meeting_id,NC_KHAS_LAND_ID));
            $arrayM = $query1->result();

            $meetingDetails  = $this->NcPullModel->getMeetingDetailByMeetingIDPull(trim($meeting_id));
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
                if($this->NcMeetingDcModel->countSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no) != 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003814: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                    ));
                    return false;
                }
                if($this->NcMeetingDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003824: Application ('.$case_no.') not found ! Kindly contact system administrator',
                    ));
                    return false;
                }

                $caseDetails = $this->NcMeetingDcModel->getSettlementAppDetailsByCaseNo($case_no);
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

                $getProposalID = $this->NcMeetingDcModel->getSettlementProposalPendingCaseByCaseNoForDeptRevert($case_no);
                $proposalId    = trim($getProposalID->proposal_id);
                $checkReqMod   = 0;
                if($caseDetails->pull_request != 0)
                {
                    $requested = $this->NcPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
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

                $deleteCase = $this->NcCommonModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                $insertIntoDeletedTable = array(
                    'proposal_id' => $proposalId,
                    'case_no'     => $deleteCase->case_no,
                    'status'      => $deleteCase->status,
                    'ip'          => $deleteCase->ip,
                    'created_at'  => $deleteCase->created_at,
                    'updated_at'  => $deleteCase->updated_at,
                    'co_submit'   => $deleteCase->co_submit,
                    'nc'          => 1,
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
                $deleteProCase = $this->NcCommonModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
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
                if($this->NcMeetingDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'task'                 => 'Reverted to CO',
                        'note_on_order'        => $revertRemarks
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
                                'note_on_order'        => $revertRemarks,
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
            $this->db->where(['id' => $meeting_id, 'dist_code' => $dist_code]);
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
                $caseAppUrban = $this->NcCommonSdoAdcDcModel->convertLiteral($caseArray);
                $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppUrban)";
                $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

                $rmk    = 'Reverted to CO';
                $status = 'M';
                $task   = $this->session->userdata('user_desig_code');
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status=$this->NcApiModel->applicationStatusUpdateBulk($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
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








}