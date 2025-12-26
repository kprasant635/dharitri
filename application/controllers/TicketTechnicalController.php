<?php
class TicketTechnicalController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->model('TicketModel/TicketCommonModel');
        $this->load->model('TicketModel/TechnicalTicketModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->offlineutility->dbSwitchSession();


        $allowed = [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM, MB_CIRCLE_OFFICER, MB_LOT_MONDOL, MB_DIST_CONSULTANT];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRLQM003 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

    }

    public function dbswitchmb2($district)
    {
        //$CI=&get_instance();
        if ($district == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($district == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($district == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($district == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($district == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($district == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($district == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($district == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($district == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($district == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($district == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($district == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($district == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($district == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($district == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($district == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($district == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($district == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($district == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($district == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($district == "25") {
            $this->db = $this->load->database('dha23', true);
        }
    }


    //// ******************* 10-07-2024 / Masud Reza *************************

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    // check access
    public function checkTicketAccess()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if (!in_array($userDegCode, TECHNICAL_TICKET_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() . 'index.php/Home/index');
        }
    }


    // check Reporting access
    public function checkTicketAccessForReporting()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if (!in_array($userDegCode, TECHNICAL_TICKET_REPORT))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() . 'index.php/Home/index');
        }
    }


    // report a technical ticket
    public function reportTechnicalTicket()
    {
        $this->checkTicketAccess();
        $this->checkTicketAccessForReporting();

        $data['applications'] = $this->TicketCommonModel->getAllApplication();
        $data['types']        = $this->TicketCommonModel->getAllTicketType();

        $data['_view'] = 'TicketSystem/Technical/add_tech_ticket';
        $this->load->view('layouts/main', $data);

    }


    // save ticket
    public function saveTechnicalTicket()
    {
        $postData = $_POST;
        unset($postData['ckeditor'], $postData['refCaseNo']);
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($postData);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($postData);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != '')
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => $errorMessageStr,
            ));
            return true;
        }

        $this->checkTicketAccess();
        $this->checkTicketAccessForReporting();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('appType', 'Application Type', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('serviceType', 'Service Type', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('ticketCategory', 'Ticket Category', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('fileCounter', 'file Counter', 'trim|required');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|min_length[2]|max_length[180]');
        $this->form_validation->set_rules('ckeditor', 'Ticket Details', 'trim|required|min_length[2]|max_length[3000]');

        // ticket category --- others
        $ticketCategory = trim($this->input->post('ticketCategory'));
        $refCaseNo      = trim($this->input->post('refCaseNo'));

        $secureRegex = 'regex_match[/^[^<>@!?]*$/]';

        if ($ticketCategory == 2)
        {
            $this->form_validation->set_rules('refCaseNo', 'Reference Case No', "trim|max_length[180]|$secureRegex");
        }
        else
        {
            $this->form_validation->set_rules('refCaseNo', 'Reference Case No', "trim|required|min_length[5]|max_length[180]|$secureRegex");
        }

        if(preg_match('/(script|select|insert|update|delete)/i', $refCaseNo))
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Invalid characters or words detected in Reference Case No.',
            ));
            return true;
        }


        if($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $errors,
            ));
            return true;
        }
        else
        {
            $masterKeyFile = array();
            foreach ($_FILES as $key=>$val)
            {
                $masterKeyFile[] = $key;
            }

            $fileCount = trim($this->input->post('fileCounter'));

            // validation for file type and file size
            $validation = array();
            for($i = 1; $i <= $fileCount; $i++)
            {
                $indexFile = 'uploadFile'.$i;
                if(!in_array($indexFile,$masterKeyFile))
                {
                    continue;
                }
                if($this->input->post('document'.$i) == null || $this->input->post('document'.$i) == '')
                {
                    $validation[] = array('field' => 'document'.$i, 'message' => "Title is missing");
                }
                if($this->input->post('uploadFile'.$i) != 'undefined')
                {
                    $name = $_FILES['uploadFile'.$i]['name'];
                    $size = $_FILES['uploadFile'.$i]['size'];
                    $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];

                    if($name != NULL)
                    {
                        if($ext == NULL)
                        {
                            $validation[] = array('field' => 'uploadFile'.$i, 'message' => "File extension required");
                        }
                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                        {
                            $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Only JPG/PNG/PDF file");
                        }
                        if($size > UPLOAD_MAX_SIZE)
                        {
                            $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Maximum 2MB file size");
                        }
                    }
                    else
                    {
                        $validation[] = array('field' => 'uploadFile'.$i, 'message' => "File Name Required");
                    }
                }
                else
                {
                    $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Document Title is missing");
                }
            }
            if (sizeof($validation) > 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'validation'   => $validation,
                    'message'      => 'Some field is missing during submission...please check form properly'
                ));
                return false;
            }
            else
            {
                $appTypeId      = trim($this->input->post('appType'));
                $serviceType    = trim($this->input->post('serviceType'));
                $ticketCategory = trim($this->input->post('ticketCategory'));
                $subject        = trim($this->input->post('subject'));
                $ticketDetails  = htmlspecialchars(trim($this->input->post('ckeditor')), ENT_QUOTES, 'UTF-8');


                // application type exit or not
                if($this->TicketCommonModel->checkApplicationTypeIdExistOrNotWithStatus($appTypeId)==0)
                {
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "Application type not found ! Please try Again",
                    ));
                    return true;
                }

                //Service Type exist or not
                if($this->TicketCommonModel->checkTicketServiceTypeExistOrNotWithStatus($appTypeId,$serviceType)==0)
                {
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "Service Type not found ! Please try Again",
                    ));
                    return true;
                }
                //Ticket Category exist or not
                if($this->TicketCommonModel->checkTicketCategoryExistOrNotWithStatus($ticketCategory)==0)
                {
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "Ticket Category not found ! Please try Again",
                    ));
                    return true;
                }


                $dist_code    = trim($this->session->userdata('dist_code'));
                $subdiv_code  = trim($this->session->userdata('subdiv_code'));
                $cir_code     = trim($this->session->userdata('cir_code'));
                $mouza_code   = trim($this->session->userdata('mouza_pargona_code'));
                $lot_no       = trim($this->session->userdata('lot_no'));
                $user_code    = trim($this->session->userdata('user_code'));
                $userDegCode  = trim($this->session->userdata('user_desig_code'));
                //$ticketNameG  = $this->TechnicalTicketModel->generateCaseName($dist_code,$subdiv_code,$cir_code);
                $ticketNameG  = $this->TechnicalTicketModel->generateCaseName2($dist_code);
                $ticketNameId = $this->TechnicalTicketModel->generateTicketSqNo();

                if(empty($ticketNameG))
                {
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "Network Issue or Session Out. Please try Again",
                    ));
                    return true;
                }
                if(empty($ticketNameId))
                {
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "Network Issue or Session Out. Please try Again",
                    ));
                    return true;
                }

                $ticketName = $ticketNameG.$ticketNameId."/".TICKET_NAME;
                $today      = date('Y-m-d G:i:s');
                $ipAddress  = $this->TicketCommonModel->get_client_ip();

                $this->db = $this->load->database('ticket_sys', TRUE);
                $this->db->trans_begin();

                $ticket = array(
                    'ticket_id'          => $ticketNameId,
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'             => $lot_no,
                    't_unicode'          => $ticketName,
                    't_app_type_id'      => $appTypeId,
                    't_service_id'       => $serviceType,
                    't_category_id'      => $ticketCategory,
                    'ref_case_no'        => $refCaseNo,
                    'draft_status'       => TICKET_DRAFT_STATUS_NO,
                    'ticket_status'      => TICKET_STATUS_PENDING,
                    'status'             => 1,
                    'subject'            => $subject,
                    'details'            => $ticketDetails,
                    'pro_time'           => 0,
                    'created_by'         => $userDegCode,
                    'user_code'          => $user_code,
                    'pending_with'       => TICKET_FORWARD_TO,
                    'ip'                 => $ipAddress,
                    'created_at'         => $today,
                );

                $insertTicket = $this->db->insert('technical_ticket_details', $ticket);
                if ($insertTicket != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRTT0001: Insertion failed in technical_ticket_details for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "#MRTT0001: There is some problem, Please try again",
                    ));
                    return true;
                }

                $historySave = array(
                    'ticket_id'        => $ticketNameId,
                    'assign_from'      => $userDegCode,
                    'assign_from_code' => $user_code,
                    'assign_date'      => $today,
                    'assign_status'    => 'Added',
                    'status'           => 1,
                    'action_status'    => 'Added',
                    'created_at'       => $today,
                    'ip'               => $ipAddress,

                );
                $insertTicketHis = $this->db->insert('technical_ticket_history', $historySave);
                if ($insertTicketHis != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRTT0002: Insertion failed in technical_ticket_history for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "#MRTT0002: There is some problem, Please try again",
                    ));
                    return true;
                }

                $historySaveFor = array(
                    'ticket_id'        => $ticketNameId,
                    'assign_from'      => $userDegCode,
                    'assign_from_code' => $user_code,
                    'assign_to'        => TICKET_FORWARD_TO,
                    'assign_date'      => $today,
                    'action_date'      => $today,
                    'assign_status'    => 'Forwarded',
                    'status'           => 1,
                    'action_status'    => 'Pending',
                    'created_at'       => $today,
                    'ip'               => $ipAddress,

                );
                $insertTicketHisFor = $this->db->insert('technical_ticket_history', $historySaveFor);
                if ($insertTicketHisFor != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRTT0003: Insertion failed in technical_ticket_history for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,  'message' => "#MRTT0003: There is some problem, Please try again",
                    ));
                    return true;
                }


                // upload additional file
                for($i = 1; $i <= $fileCount; $i++)
                {

                    $indexFile = 'uploadFile'.$i;
                    if(!in_array($indexFile,$masterKeyFile))
                    {
                        continue;
                    }
                    $_FILES['file']['name']     = $_FILES['uploadFile'.$i]['name'];
                    $_FILES['file']['type']     = $_FILES['uploadFile'.$i]['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['uploadFile'.$i]['tmp_name'];
                    $_FILES['file']['error']    = $_FILES['uploadFile'.$i]['error'];
                    $_FILES['file']['size']     = $_FILES['uploadFile'.$i]['size'];

                    $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];

                    $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                    $config['upload_path']   = UPLOAD_TICKET_DIR;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']      = UPLOAD_MAX_SIZE;;
                    $config['file_name']     = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'ticket_id'   => $ticketNameId,
                            'uploaded_by' => $user_code,
                            'file_path'   => UPLOAD_TICKET_DIR . $fileRename,
                            'file_name'   => $this->input->post('document'.$i),
                            'file_type'   => $_FILES['file']['type'],
                            'created_at'  => $today,
                            'ip'          => $ipAddress,
                            'type'        => 'TECH',
                        );

                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('technical_ticket_attachment',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRTT0004: Insertion failed in technical_ticket_attachment for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
                            echo json_encode(array(
                                'responseType' => 1,  'message' => "#MRTT0004: There is some problem, Please try again",
                            ));
                            return true;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRTT0005: Insertion failed in technical_ticket_attachment for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,  'message' => "#MRTT0005: There is some problem, Please try again",
                        ));
                        return true;
                    }
                }

                $this->db->trans_commit();
                $this->offlineutility->dbSwitchSession();
                echo json_encode(array(
                    'responseType' => 2,  'message' => "Ticket successfully submitted & forwarded to NIC Manager",
                ));
                return true;
            }
        }
    }


    // get ticket application for CO (Pending)
    public function getAllPendingTicketListForCo()
    {
        $this->checkTicketAccess();
        $data['tStatus']  = TICKET_STATUS_PENDING;
        $data['tProcess'] = 0;
        $data['tHeading'] = $this->lang->line('TicketTechPendingMy');

        $data['_view'] = 'TicketSystem/Technical/pending_ticket_list_co';
        $this->load->view('layouts/main', $data);
    }


    // get ticket application for CO (Closed)
    public function getAllClosedTicketListForCo()
    {
        $this->checkTicketAccess();
        $data['tStatus']  = TICKET_STATUS_CLOSED;
        $data['tProcess'] = 0;
        $data['tHeading'] = $this->lang->line('TicketTechClosedMy');

        $data['_view'] = 'TicketSystem/Technical/pending_ticket_list_co';
        $this->load->view('layouts/main', $data);
    }


    // get ticket application for CO (Rejected)
    public function getAllRejectedTicketListForCo()
    {
        $this->checkTicketAccess();
        $data['tStatus']  = TICKET_STATUS_REJECTED;
        $data['tProcess'] = 0;
        $data['tHeading'] = $this->lang->line('TicketTechRejectedMy');

        $data['_view'] = 'TicketSystem/Technical/pending_ticket_list_co';
        $this->load->view('layouts/main', $data);
    }


    // ajax for all pending tickets
    public function getAllPendingTicketListForCoAjax()
    {
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != ''){
            $this->session->set_flashdata('error', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }


        $this->checkTicketAccess();
        $json     = null;
        $draw     = intval($this->input->post('draw'));
        $start    = intval($this->input->post('start'));
        $length   = intval($this->input->post('length'));
        $order    = $this->input->post('order');
        $case_no  = $this->input->post('case_no');
        $sub_date = $this->input->post('sub_date');
        $tStatus  = $this->input->post('tStatus');
        $tProcess = $this->input->post('tProcess');

        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $searchByCol_0 = strtoupper(trim($this->input->post('columns')[0]['search']['value']));

        $this->db = $this->load->database('ticket_sys', TRUE);

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
        $valid_columns = array(
            0   => 'technical_ticket_details.created_at',
        );
        if(!isset($valid_columns[$col])){
            $order = 'technical_ticket_details.created_at';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){

            $this->db->order_by($order, $dir);
        }
        if(!empty($case_no))
        {
            $this->db->where('technical_ticket_details.t_unicode', $case_no);
        }
        if(!empty($status))
        {
            $this->db->where('technical_ticket_details.ticket_status', $status);
        }
        if(!empty($sub_date))
        {
            $this->db->where('DATE(technical_ticket_details.created_at)',date('Y-m-d', strtotime($sub_date)));
        }

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
        $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        $this->db->where('technical_ticket_details.cir_code',$cir_code);
        $this->db->where('technical_ticket_details.user_code',$user_code);
        $this->db->where('technical_ticket_details.created_by',$userDegCode);
        $this->db->where('technical_ticket_details.ticket_status',$tStatus);
        $this->db->where('technical_ticket_details.status',1);



        $this->db->order_by('technical_ticket_details.id','asc');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            $result = $query->result();
            $i=1;

            if(!empty($by_case_no))
            {
                $this->db->where('technical_ticket_details.t_unicode', $by_case_no);
            }

            $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
            $this->db->from('technical_ticket_details');
            $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
            $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
            $this->db->where('technical_ticket_details.dist_code',$dist_code);
            $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
            $this->db->where('technical_ticket_details.cir_code',$cir_code);
            $this->db->where('technical_ticket_details.user_code',$user_code);
            $this->db->where('technical_ticket_details.created_by',$userDegCode);
            $this->db->where('technical_ticket_details.ticket_status',$tStatus);
            $this->db->where('technical_ticket_details.status',1);
            $this->db->order_by('technical_ticket_details.id','asc');
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                if($rows->ticket_status == TICKET_STATUS_PENDING){
                    $status = '<span style="color:#455A64; font-weight: bold "> Pending </span>';
                }
                elseif($rows->ticket_status == TICKET_STATUS_CLOSED){
                    $status = '<span style="color: #4CAF50; font-weight: bold"> Closed </span>';
                }
                elseif($rows->ticket_status == TICKET_STATUS_REJECTED){
                    $status = '<span style="color: #F44336; font-weight: bold"> Rejected </span>';
                }
                else{
                    $status = 'Unknown';
                }

                $json[] = array(
                    $i,
                    $rows->application_name,
                    $rows->service_name,
                    $rows->t_unicode,
                    date("d-m-Y", strtotime($rows->created_at)),
                    $status,
                    '<a class="rezaButt buttInfo" href="'.base_url().'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $rows->ticket_id, 600).'"> 
                    <i class="fa fa-eye"></i>  View </a>',

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


    // get technical Tickets Details
    public function viewTechnicalTicketDetails()
    {
        $this->checkTicketAccess();
        $tIden = trim($this->input->get('app'));
        $tId   = dec_param($tIden, 'app');
        if($tId == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $dist_code = trim($this->session->userdata('dist_code'));
        $user_code = trim($this->session->userdata('user_code'));

        if($this->TechnicalTicketModel->countTicketDetailsById($tId,$dist_code,$user_code) != 1)
        {
            $this->session->set_flashdata('error', "Ticket details not found !");
            redirect(base_url().'index.php/TicketTechnicalController/getAllPendingTicketListForCo', 'refresh');
        }

        $data['ticket']      = $this->TechnicalTicketModel->getTicketDetailsById($tId,$dist_code,$user_code);
        $data['histories']   = $this->TechnicalTicketModel->getTicketHistoryById($tId);
        $data['attachments'] = $this->TechnicalTicketModel->getTicketDocumentById($tId);
        $data['comments']    = $this->TechnicalTicketModel->getTicketCommentById($tId);


        $data['_view'] = 'TicketSystem/Technical/tech_ticket_details';
        $this->load->view('layouts/main', $data);

    }


    // get technical Tickets Details only view
    public function viewTechnicalTicketDetailsOnly()
    {
        $this->checkTicketAccess();
        $tIden = trim($this->input->get('app'));
        $tId   = dec_param($tIden, 'app');
        if($tId == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $dist_code = trim($this->session->userdata('dist_code'));
        $user_code = trim($this->session->userdata('user_code'));
        if($this->TechnicalTicketModel->countTicketDetailsByIdOnlyDistAndTid($tId,$dist_code) != 1)
        {
            $this->session->set_flashdata('error', "Ticket details not found !");
            redirect(base_url().'index.php/TicketTechnicalController/getAllPendingTicketListForCo', 'refresh');
        }

        $data['ticket']      = $this->TechnicalTicketModel->getTicketDetailsByIdOnlyTid($tId,$dist_code);
        $data['histories']   = $this->TechnicalTicketModel->getTicketHistoryById($tId);
        $data['attachments'] = $this->TechnicalTicketModel->getTicketDocumentById($tId);
        $data['comments']    = $this->TechnicalTicketModel->getTicketCommentById($tId);


        $data['_view'] = 'TicketSystem/Technical/tech_ticket_details_view_only';
        $this->load->view('layouts/main', $data);

    }


    // add comment on ticket
    public function addCommentOnTechnicalTicket()
    {

        $postData = $_POST;
        unset($postData['tId']);
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($postData);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboard');
        }

        $this->checkTicketAccess();
        $tId       = trim($this->input->post('tId'));
        $ticketId  = base64_decode($tId);
        $user_code = trim($this->session->userdata('user_code'));
        $dist_code = trim($this->session->userdata('dist_code'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('tId', 'Ticket Details', 'trim|required');
        $this->form_validation->set_rules('comment', 'comment', 'trim|required|min_length[2]|max_length[2500]');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));

        }

        $comment = trim($this->input->post('comment'));
        if($this->TechnicalTicketModel->countTicketDetailsById($ticketId,$dist_code,$user_code) != 1)
        {
            $this->session->set_flashdata('error', "Ticket details not found !");
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboard');
        }
        $ticketDetails = $this->TechnicalTicketModel->getOnlyTicketDetailsById($ticketId);
        if($ticketDetails->ticket_status != TICKET_STATUS_PENDING)
        {
            $this->session->set_flashdata('error', "You cannot comment on this Ticket !");
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
        }

        // validation for file type and file size
        $name = $_FILES['attachment']['name'];
        $size = $_FILES['attachment']['size'];
        $fileHasOrNot = 0;
        $exp  = '';
        if($name != NULL)
        {
            $mime = mime_content_type($_FILES['attachment']['tmp_name']);
            $exp  = explode("/",$mime);
            $ext  = $exp[1];

            $fileHasOrNot = 1;

            if($ext == NULL)
            {
                $this->session->set_flashdata('error', "Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
            }
            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
            {
                $this->session->set_flashdata('error', "Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
            }
            if($size > UPLOAD_MAX_SIZE)
            {
                $this->session->set_flashdata('error', "Attachment size is more then " . UPLOAD_MAX_SIZE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
            }
        }

        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $today       = date('Y-m-d G:i:s');
        $ipAddress   = $this->TicketCommonModel->get_client_ip();

        $this->db = $this->load->database('ticket_sys', TRUE);
        $this->db->trans_begin();

        $dataSave = array(
            'ticket_id'       => $ticketId,
            'comment_by'      => $userDegCode,
            'comment_code'    => $user_code,
            'comment_details' => $comment,
            'ip'              => $ipAddress,
            'status'          => 1,
            'created_at'      => $today,
        );

        if($fileHasOrNot > 0)
        {
            // save attachment
            $_FILES['file']['name']     = $_FILES['attachment']['name'];
            $_FILES['file']['type']     = $_FILES['attachment']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['attachment']['error'];
            $_FILES['file']['size']     = $_FILES['attachment']['size'];

            $mime = mime_content_type($_FILES['attachment']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];

            $fileRename =  $this->UUID4() . '.' . $onlyExtension;

            $config['upload_path']   = UPLOAD_TICKET_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = UPLOAD_MAX_SIZE;;
            $config['file_name']     = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $dataSave = array(
                    'ticket_id'       => $ticketId,
                    'comment_by'      => $userDegCode,
                    'comment_code'    => $user_code,
                    'comment_details' => $comment,
                    'ip'              => $ipAddress,
                    'status'          => 1,
                    'created_at'      => $today,
                    'file_path'       => UPLOAD_TICKET_DIR . $fileRename,
                    'file_name'       => $_FILES['file']['name'],
                    'file_type'       => $_FILES['file']['type'],
                );
            }
            else
            {
                $this->session->set_flashdata('error', "There is some problem, Please try again");
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
            }
        }

        $insertTicketHis = $this->db->insert('technical_ticket_comment', $dataSave);
        if ($insertTicketHis != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRTT0002: Insertion failed in technical_ticket_comment for Ticket No ' . $ticketId . 'and query is ' . $this->db->last_query());
            $this->session->set_flashdata('error', "There is some problem, Please try again");
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));
        }

        $this->db->trans_commit();
        $this->offlineutility->dbSwitchSession();
        $this->session->set_flashdata('success', "Your Comment Successfully added ");
        redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetails/?app='.enc_param('app', $ticketId, 600));

    }


    // add comment on ticket only view page
    public function addCommentOnTechnicalTicketOnlyView()
    {
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('message', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboard');
        }

        $this->checkTicketAccess();
        $tId       = trim($this->input->post('tId'));
        $ticketId  = base64_decode($tId);
        $user_code = trim($this->session->userdata('user_code'));
        $dist_code = trim($this->session->userdata('dist_code'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('tId', 'Ticket Details', 'trim|required');
        $this->form_validation->set_rules('comment', 'comment', 'trim|required|min_length[2]|max_length[2500]');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));

        }

        $comment = trim($this->input->post('comment'));
        if($this->TechnicalTicketModel->countTicketDetailsByIdOnlyDistAndTid($ticketId,$dist_code) != 1)
        {
            $this->session->set_flashdata('error', "Ticket details not found !");
            redirect(base_url() . 'index.php/Home/index');
        }
        $ticketDetails = $this->TechnicalTicketModel->getOnlyTicketDetailsById($ticketId);
        if($ticketDetails->ticket_status != TICKET_STATUS_PENDING)
        {
            $this->session->set_flashdata('error', "You cannot comment on this Ticket !");
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
        }

        // validation for file type and file size
        $name = $_FILES['attachment']['name'];
        $size = $_FILES['attachment']['size'];
        $fileHasOrNot = 0;
        $exp  = '';
        if($name != NULL)
        {
            $mime = mime_content_type($_FILES['attachment']['tmp_name']);
            $exp  = explode("/",$mime);
            $ext  = $exp[1];

            $fileHasOrNot = 1;

            if($ext == NULL)
            {
                $this->session->set_flashdata('error', "Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
            }
            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
            {
                $this->session->set_flashdata('error', "Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
            }
            if($size > UPLOAD_MAX_SIZE)
            {
                $this->session->set_flashdata('error', "Attachment size is more then " . UPLOAD_MAX_SIZE_VALIDATION_SHOW);
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
            }
        }

        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $today       = date('Y-m-d G:i:s');
        $ipAddress   = $this->TicketCommonModel->get_client_ip();

        $this->db = $this->load->database('ticket_sys', TRUE);
        $this->db->trans_begin();

        $dataSave = array(
            'ticket_id'       => $ticketId,
            'comment_by'      => $userDegCode,
            'comment_code'    => $user_code,
            'comment_details' => $comment,
            'ip'              => $ipAddress,
            'status'          => 1,
            'created_at'      => $today,
        );

        if($fileHasOrNot > 0)
        {
            // save attachment
            $_FILES['file']['name']     = $_FILES['attachment']['name'];
            $_FILES['file']['type']     = $_FILES['attachment']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['attachment']['error'];
            $_FILES['file']['size']     = $_FILES['attachment']['size'];

            $mime = mime_content_type($_FILES['attachment']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];

            $fileRename =  $this->UUID4() . '.' . $onlyExtension;

            $config['upload_path']   = UPLOAD_TICKET_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = UPLOAD_MAX_SIZE;;
            $config['file_name']     = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $dataSave = array(
                    'ticket_id'       => $ticketId,
                    'comment_by'      => $userDegCode,
                    'comment_code'    => $user_code,
                    'comment_details' => $comment,
                    'ip'              => $ipAddress,
                    'status'          => 1,
                    'created_at'      => $today,
                    'file_path'       => UPLOAD_TICKET_DIR . $fileRename,
                    'file_name'       => $_FILES['file']['name'],
                    'file_type'       => $_FILES['file']['type'],
                );
            }
            else
            {
                $this->session->set_flashdata('error', "There is some problem, Please try again");
                redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
            }
        }

        $insertTicketHis = $this->db->insert('technical_ticket_comment', $dataSave);
        if ($insertTicketHis != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRTT0002: Insertion failed in technical_ticket_comment for Ticket No ' . $ticketId . 'and query is ' . $this->db->last_query());
            $this->session->set_flashdata('error', "There is some problem, Please try again");
            redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));
        }

        $this->db->trans_commit();
        $this->offlineutility->dbSwitchSession();
        $this->session->set_flashdata('success', "Your Comment Successfully added ");
        redirect(base_url() . 'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $ticketId, 600));


    }


    // close ticket by ticket reporter
    public function closeTicketByTicketReporter()
    {
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n')
        {
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != '')
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => $errorMessageStr,
            ));
            return true;
        }


        $this->checkTicketAccess();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ticketId', 'Ticket Details', 'trim|required|min_length[2]|max_length[300]');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[300]');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $errors,
            ));
            return true;
        }

        $ticketIdEn  = trim($this->input->post('ticketId'));
        $ticketId    = base64_decode($ticketIdEn);
        $remarks     = trim($this->input->post('remarks'));
        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $dist_code   = trim($this->session->userdata('dist_code'));

        if($this->TechnicalTicketModel->countTicketDetailsById($ticketId,$dist_code,$user_code) != 1)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Ticket details not found',
            ));
            return true;
        }
        $ticketDetails = $this->TechnicalTicketModel->getOnlyTicketDetailsById($ticketId);
        if($ticketDetails->ticket_status != TICKET_STATUS_PENDING)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Request could not be completed. This ticket is already assigned..!',
            ));
            return true;
        }


        $ticketName = $ticketDetails->t_unicode;
        $today      = date('Y-m-d G:i:s');
        $ipAddress  = $this->TicketCommonModel->get_client_ip();
        $this->db = $this->load->database('ticket_sys', TRUE);
        $this->db->trans_begin();

        $ticketUpdate = array(
            'ticket_status' => TICKET_STATUS_CLOSED,
            'updated_by'    => $userDegCode,
            'close_u_code'  => $user_code,
            'updated_at'    => $today,
            'closed_on'     => $today,
            'pro_note'      => $remarks,
            'a_status'      => 2,
        );

        $this->db->where('ticket_id', $ticketId);
        $this->db->where('status', 1);
        $this->db->update('technical_ticket_details', $ticketUpdate);
        if ($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRTTC0001: Updating failed in technical_ticket_details for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
            echo json_encode(array(
                'responseType' => 1,  'message' => "#MRTTC0001: There is some problem, Please try again",
            ));
            return true;
        }


        $historySaveFor = array(
            'ticket_id'        => $ticketId,
            'assign_from'      => $userDegCode,
            'assign_from_code' => $user_code,
            'assign_date'      => $today,
            'assign_status'    => 'Closed',
            'status'           => 1,
            'note'             => $remarks,
            'action_status'    => 'Closed',
            'created_at'       => $today,
            'action_date'      => $today,
            'ip'               => $ipAddress,

        );
        $insertTicketHisFor = $this->db->insert('technical_ticket_history', $historySaveFor);
        if ($insertTicketHisFor != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRTTC0002: Insertion failed in technical_ticket_history for Ticket No ' . $ticketName . 'and query is ' . $this->db->last_query());
            echo json_encode(array(
                'responseType' => 1,  'message' => "#MRTTC0002: There is some problem, Please try again",
            ));
            return true;
        }

        $this->db->trans_commit();
        $this->offlineutility->dbSwitchSession();
        echo json_encode(array(
            'responseType' => 2,  'message' => "Ticket Successfully Closed",
        ));
        return true;

    }




}



