<?php
class TicketCommonController extends CI_Controller
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

    // check access
    public function checkTicketAccess()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,TECHNICAL_TICKET_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }


    // check access Dashboard And Search
    public function checkTicketDashboardAndSearchAccess()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,TICKET_DASHBOARD_ACCESS_YES))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }



    // first Dashboard
    public function getTicketSystemDashboard()
    {
        $this->checkTicketAccess();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $countPendingTicket  = 0;
        $countClosedTicket   = 0;
        $countRejectedTicket = 0;

        if(in_array($userDegCode,TECHNICAL_TICKET_REPORT))
        {
            $countPendingTicket  = $this->TechnicalTicketModel->countPendingTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,TICKET_STATUS_PENDING);
            $countClosedTicket   = $this->TechnicalTicketModel->countClosedTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,TICKET_STATUS_CLOSED);
            $countRejectedTicket = $this->TechnicalTicketModel->countRejectedTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,TICKET_STATUS_REJECTED);
        }

        $data['dist_code']           = $dist_code;
        $data['countPendingTicket']  = $countPendingTicket;
        $data['countClosedTicket']   = $countClosedTicket;
        $data['countRejectedTicket'] = $countRejectedTicket;

        $data['_view'] = 'TicketSystem/dashboard';
        $this->load->view('layouts/main', $data);

    }


    // get Over all Dashboard
    public function getTicketSystemDashboardOverAll()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $dist_code    = trim($this->session->userdata('dist_code'));
        $userDegCode  = trim($this->session->userdata('user_desig_code'));
        $allService   = $this->TicketCommonModel->getAllServiceTypeWithOutStatus();
        $serviceArray = [];
        if($userDegCode == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            foreach ($allService as $key=> $service)
            {
                $serviceArray[$key]['id']               = $service->id;
                $serviceArray[$key]['app_id']           = $service->app_id;
                $serviceArray[$key]['application_name'] = $service->application_name;
                $serviceArray[$key]['service_name']     = $service->service_name;
                $serviceArray[$key]['count']            = $this->TicketCommonModel->countTicketServiceWiseWithSubDiv($service->app_id,$service->id,$dist_code,$subdiv_code);
            }
        }
        else
        {
            foreach ($allService as $key=> $service)
            {
                $serviceArray[$key]['id']               = $service->id;
                $serviceArray[$key]['app_id']           = $service->app_id;
                $serviceArray[$key]['application_name'] = $service->application_name;
                $serviceArray[$key]['service_name']     = $service->service_name;
                $serviceArray[$key]['count']            = $this->TicketCommonModel->countTicketServiceWise($service->app_id,$service->id,$dist_code);
            }
        }


        $data['services']        = $serviceArray;
        $data['allCount']        = $this->TicketCommonModel->countAllTicketForReport();
        $data['inQueueCount']    = $this->TicketCommonModel->countAllInQueueTicketForReport();
        $data['closedCount']     = $this->TicketCommonModel->countAllClosedTicketForReport();
        $data['rejectedCount']   = $this->TicketCommonModel->countAllRejectedTicketForReport();
        $data['pendingCount']    = $this->TicketCommonModel->countAllPendingTicketForReport();
        $data['processingCount'] = $this->TicketCommonModel->countAllProcessingTicketForReport();

        $data['_view'] = 'TicketSystem/dashboard_over_all';
        $this->load->view('layouts/main', $data);

    }


    // ticket Search
    public function ticketSearchOverAll()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $application = $this->TicketCommonModel->getAllApplication();
        $service     = $this->TicketCommonModel->getAllServiceTypeWithOutStatus();
        if($this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $allCircle   = $this->utilityclass->getAllCircleNameWithDistCodeSubDiv($dist_code,$subdiv_code);
        }
        else
        {
            $allCircle   = $this->utilityclass->getAllCircleNameWithDistCode($dist_code);
        }


        $data['applications'] = $application;
        $data['services']     = $service;
        $data['circles']      = $allCircle;

        $data['_view'] = 'TicketSystem/ticket_search';
        $this->load->view('layouts/main', $data);
    }


    // ajax for search
    public function ajaxSearchTicketForReport()
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
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/ticketSearchOverAll');
        }

        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $json        = null;
        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
        $case_no     = $this->input->post('ticketName');
        $tStatus     = $this->input->post('ticketStatus');
        $dateFrom    = $this->input->post('dateFrom');
        $dateTo      = $this->input->post('dateTo');
        $application = $this->input->post('application');
        $serviceId   = $this->input->post('serviceType');
        $dist_code   = trim($this->session->userdata('dist_code'));
        $sub_cir     = $this->input->post('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $sub_code = '';
        $cir_code = '';
        if(!empty($sub_cir))
        {
            $code = explode("_", $sub_cir);
            $sub_code = $code[1];
            $cir_code = $code[0];
        }

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
        if(!empty($tStatus))
        {
            $this->db->where('technical_ticket_details.ticket_status', $tStatus);
        }
        if(!empty($application))
        {
            $this->db->where('technical_ticket_details.t_app_type_id',$application);
        }
        if(!empty($serviceId))
        {
            $this->db->where('technical_ticket_details.t_service_id',$serviceId);
        }
        if(!empty($cir_code))
        {
            $this->db->where('technical_ticket_details.subdiv_code',$sub_code);
            $this->db->where('technical_ticket_details.cir_code',$cir_code);
        }

        if(empty($dateTo))
        {
            if(!empty($dateFrom))
            {
                $this->db->where('DATE(technical_ticket_details.created_at)',date('Y-m-d', strtotime($dateFrom)));
            }
        }

        if(empty($dateFrom))
        {
            if(!empty($dateTo))
            {
                $this->db->where('DATE(technical_ticket_details.created_at)',date('Y-m-d', strtotime($dateTo)));
            }
        }
        if($dateFrom !='' && $dateTo !='')
        {
            $this->db->where('DATE(technical_ticket_details.created_at) >=', date('Y-m-d',strtotime($dateFrom)));
            $this->db->where('DATE(technical_ticket_details.created_at) <=', date('Y-m-d',strtotime($dateTo)));
        }

        if($userDegCode == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        }

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
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
            if($userDegCode == MB_SUB_DIV_COMM)
            {
                $subdiv_code = trim($this->session->userdata('subdiv_code'));
                $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
            }

            $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
            $this->db->from('technical_ticket_details');
            $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
            $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
            $this->db->where('technical_ticket_details.status',1);
            $this->db->where('technical_ticket_details.dist_code',$dist_code);
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
                    '<a class="rezaButt buttInfo" href="'.base_url().'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $rows->ticket_id, 600).'">
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


    // get all service type by application id
    public function getAllServiceTypeByAppId()
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
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/ticketSearchOverAll');
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('appTypeId', 'Application', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Could not Complete your Request ..!, Please Try Again later..!',
            ));
            return;
        }
        else
        {
            $appId = trim($this->input->post('appTypeId'));
            if($this->TicketCommonModel->checkApplicationTypeIdExistOrNot($appId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => 'Could not Complete your Request ..!, Data not found !',
                ));
                return;
            }

            $allServices = $this->TicketCommonModel->getServiceTypeWithAppId($appId);

            $data['services']     = $allServices;
            $data['responseType'] = 2;

            echo json_encode($data);
            return;

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


    // view uploaded Ticket doc
    public function getViewTicketUploadedDoc()
    {
        $filePathId = $this->input->get('fileId');
        $fileType   = $this->input->get('type');
        if($filePathId == '' OR $fileType == '')
        {
            die("Unable to open file !");
        }

        $fileDetails = $this->TicketCommonModel->getTicketDocWithFileId($filePathId);
        if($fileType == 1)
        {
            if($fileDetails->file_path == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->file_path))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->file_path, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->file_path;
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
                    $path = $fileDetails->file_path;
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
        elseif($fileType == 2)
        {
            if($fileDetails->file_path == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->file_path))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->file_path, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->file_path;
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
                    $path = $fileDetails->file_path;
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
        else
        {
            die("Unable to open file !");
        }

    }


    // view uploaded comment doc
    public function getViewTicketCommentDoc()
    {
        $filePathId = $this->input->get('fileId');
        $fileType   = $this->input->get('type');
        if($filePathId == '' OR $fileType == '')
        {
            die("Unable to open file !");
        }

        $fileDetails = $this->TicketCommonModel->getTicketCommentDocWithFileId($filePathId);
        if($fileType == 1)
        {
            if($fileDetails->file_path == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->file_path))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->file_path, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->file_path;
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
                    $path = $fileDetails->file_path;
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
        elseif($fileType == 2)
        {
            if($fileDetails->file_path == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->file_path))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->file_path, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->file_path;
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
                    $path = $fileDetails->file_path;
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
        else
        {
            die("Unable to open file !");
        }

    }




    // get all register ticket
    public function getAllRegisterTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['tHeading'] = 'All Register Ticket';

        $data['_view'] = 'TicketSystem/all_register_ticket';
        $this->load->view('layouts/main', $data);

    }


    // ajax for all register ticket
    public function ajaxAllRegisterTicketForReport()
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
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/ticketSearchOverAll');
        }

        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $json        = null;
        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
        $case_no     = $this->input->post('case_no');
        $status      = $this->input->post('status');
        $sub_date    = $this->input->post('sub_date');
        $dist_code   = trim($this->session->userdata('dist_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $sub_code = '';
        $cir_code = '';
        if(!empty($sub_cir))
        {
            $code = explode("_", $sub_cir);
            $sub_code = $code[1];
            $cir_code = $code[0];
        }

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

        if($userDegCode == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        }

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
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
            if($userDegCode == MB_SUB_DIV_COMM)
            {
                $subdiv_code = trim($this->session->userdata('subdiv_code'));
                $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
            }

            $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
            $this->db->from('technical_ticket_details');
            $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
            $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
            $this->db->where('technical_ticket_details.status',1);
            $this->db->where('technical_ticket_details.dist_code',$dist_code);
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
                    '<a class="rezaButt buttInfo" href="'.base_url().'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $rows->ticket_id, 600).'">
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


    // get all closed ticket
    public function getAllClosedTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['title']    = 'Closed';
        $data['tStatus']  = TICKET_STATUS_CLOSED;
        $data['tProcess'] = 2;

        $data['_view'] = 'TicketSystem/all_ticket_with_status';
        $this->load->view('layouts/main', $data);
    }


    // get all Rejected ticket
    public function getAllRejectedTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['title']    = 'Rejected';
        $data['tStatus']  = TICKET_STATUS_REJECTED;
        $data['tProcess'] = 0;

        $data['_view'] = 'TicketSystem/all_ticket_with_status';
        $this->load->view('layouts/main', $data);
    }


    // get all InQueue ticket
    public function getAllInQueueTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['title']    = 'In Queue';
        $data['tStatus']  = TICKET_STATUS_PENDING;
        $data['tProcess'] = 1;

        $data['_view'] = 'TicketSystem/all_ticket_with_status';
        $this->load->view('layouts/main', $data);
    }


    // get all UnderProcessing ticket
    public function getAllUnderProcessingTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['title']    = 'Under Processing';
        $data['tStatus']  = TICKET_STATUS_PENDING;
        $data['tProcess'] = 2;

        $data['_view'] = 'TicketSystem/all_ticket_with_status';
        $this->load->view('layouts/main', $data);
    }


    // get all pending ticket
    public function getAllPendingTicketForReport()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();

        $data['title']    = 'Pending';
        $data['tStatus']  = TICKET_STATUS_PENDING;
        $data['tProcess'] = 0;

        $data['_view'] = 'TicketSystem/all_ticket_with_status';
        $this->load->view('layouts/main', $data);
    }


    // ajax for all register ticket status wise
    public function ajaxAllTicketWithStatusForReport()
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
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboard');
        }

        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $json        = null;
        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
        $case_no     = $this->input->post('case_no');
        $tStatus     = $this->input->post('tStatus');
        $tProcess    = $this->input->post('tProcess');
        $sub_date    = $this->input->post('sub_date');
        $dist_code   = trim($this->session->userdata('dist_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $sub_code = '';
        $cir_code = '';
        if(!empty($sub_cir))
        {
            $code = explode("_", $sub_cir);
            $sub_code = $code[1];
            $cir_code = $code[0];
        }

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
        if(!empty($sub_date))
        {
            $this->db->where('DATE(technical_ticket_details.created_at)',date('Y-m-d', strtotime($sub_date)));
        }

        if($userDegCode == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        }

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
        $this->db->where('technical_ticket_details.status',1);
        $this->db->where('technical_ticket_details.ticket_status',$tStatus);
        $this->db->where('technical_ticket_details.a_status',$tProcess);
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
            if($userDegCode == MB_SUB_DIV_COMM)
            {
                $subdiv_code = trim($this->session->userdata('subdiv_code'));
                $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
            }

            $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
            $this->db->from('technical_ticket_details');
            $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
            $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
            $this->db->where('technical_ticket_details.status',1);
            $this->db->where('technical_ticket_details.dist_code',$dist_code);
            $this->db->where('technical_ticket_details.ticket_status',$tStatus);
            $this->db->where('technical_ticket_details.a_status',$tProcess);
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
                    '<a class="rezaButt buttInfo" href="'.base_url().'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $rows->ticket_id, 600).'">
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


    // get ticket with service Type Wise
    public function getTicketServiceTypeWise()
    {
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $serviceId = $this->input->get('service');
        $appQuery  = $this->TicketCommonModel->getServiceTypeDetailsWithId($serviceId);
        if($appQuery->num_rows() != 1)
        {
            $this->session->set_flashdata('error',"Data not found !");
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboardOverAll');
        }
        $services = $appQuery->row();

        $data['serviceName'] = $services->service_name;
        $data['appName']     = $services->application_name;
        $data['serviceId']   = $serviceId;

        $data['_view'] = 'TicketSystem/all_ticket_by_service';
        $this->load->view('layouts/main', $data);
    }


    // ajax for all register ticket service wise
    public function ajaxAllTicketByServiceForReport()
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
        if($errorMessageStr != '')
        {
            $this->session->set_flashdata('error', $errorMessageStr);
            redirect(base_url() . 'index.php/TicketCommonController/getTicketSystemDashboard');
        }
        $this->checkTicketAccess();
        $this->checkTicketDashboardAndSearchAccess();
        $json        = null;
        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
        $case_no     = $this->input->post('case_no');
        $tStatus     = $this->input->post('tStatus');
        $tProcess    = $this->input->post('tProcess');
        $sub_date    = $this->input->post('sub_date');
        $status      = $this->input->post('status');
        $serviceId   = $this->input->post('serviceId');
        $dist_code   = trim($this->session->userdata('dist_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $sub_code = '';
        $cir_code = '';
        if(!empty($sub_cir))
        {
            $code = explode("_", $sub_cir);
            $sub_code = $code[1];
            $cir_code = $code[0];
        }

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
        if(!empty($sub_date))
        {
            $this->db->where('DATE(technical_ticket_details.created_at)',date('Y-m-d', strtotime($sub_date)));
        }
        if(!empty($status))
        {
            $this->db->where('technical_ticket_details.ticket_status', $status);
        }

        if($userDegCode == MB_SUB_DIV_COMM)
        {
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        }

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
        $this->db->where('technical_ticket_details.status',1);
        $this->db->where('technical_ticket_details.t_service_id',$serviceId);
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
            if($userDegCode == MB_SUB_DIV_COMM)
            {
                $subdiv_code = trim($this->session->userdata('subdiv_code'));
                $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
            }

            $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
            $this->db->from('technical_ticket_details');
            $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
            $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
            $this->db->where('technical_ticket_details.status',1);
            $this->db->where('technical_ticket_details.dist_code',$dist_code);
            $this->db->where('technical_ticket_details.t_service_id',$serviceId);
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
                    '<a class="rezaButt buttInfo" href="'.base_url().'index.php/TicketTechnicalController/viewTechnicalTicketDetailsOnly/?app='.enc_param('app', $rows->ticket_id, 600).'">
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




}