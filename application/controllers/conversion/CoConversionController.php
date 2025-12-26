<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/libraries/CommonTrait.php';

class CoConversionController extends CI_Controller {

    use CommonTrait;

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/COofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/RtpsModel');
        $this->load->model('v2/PetitionBasicModel');
        $this->load->model('v2/UsersModel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('v2/ChithaBasicModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('v2/Services/Conversion/ConversionModel');
        $this->load->model('v2/PetitionProceedingModel');
        $this->load->model('conversion/MbOfficeConversionModel');
        $this->load->model('ChithaUpdateModel');
        ini_set('memory_limit', '1024M');
        if(ENABLED_BLOCKCHAIN == 1)
        {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }
    }

    public function GoToCO() {
        $this->load->library('pagination');
        $process = $this->input->get('pro');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
    
        $searchKeyword=null;
        if($this->input->post('submitSearch')){
            $inputKeywords = $this->input->post('searchKeyword');
            $searchKeyword = strip_tags($inputKeywords);
            if(!empty($searchKeyword)){
                $this->session->set_userdata('searchKeyword',$searchKeyword);
            }else{
                $this->session->unset_userdata('searchKeyword');
            }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }
        
        if ($process == '1') {
            //$config['total_rows'] = $this->COofficeConversionModel->countPendingConversionFreshCases($user_code);
            //$cases['cases'] = $this->COofficeConversionModel->getPendingConversionFreshCases($user_code)->result();

            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/CoConversionController/GoToCO';        
            // $config['total_rows'] = $this->COofficeConversionModel->countPendingConversionFreshCases($user_code);
            $config['total_rows'] = $this->COofficeConversionModel->countCoConversionFirst();

            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            // $cases['cases'] = $this->COofficeConversionModel->getPendingConversionFreshCases($user_code,$config["per_page"], $page,$searchKeyword)->result(); 
            $cases['cases'] = $this->COofficeConversionModel->getCoConversionFirst($user_code,$config["per_page"], $page,$searchKeyword); 

        } elseif ($process == '2') {
            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/COconversionPartha/GoToCO';        
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases($user_code);
            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCasesMb3($user_code,$config["per_page"], $page,$searchKeyword)->result();           
        } elseif ($process == '3') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countChithaUpdateConvCases($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getChithaUpdateConvCases($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countconversion_proceeding_report($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getconversion_proceeding_report($user_code)->result();
        } elseif ($process == '5') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countRejectedConversionSecondCases($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getRejectedConversionSecondCases($user_code)->result();
            //var_dump($cases);
        } elseif ($process == '6') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countConvertionOrderPassedByDC($user_desig_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getConvertionOrderPassedByDC($user_desig_code)->result();
            //var_dump($cases);
        } elseif ($process == '7') {
            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/COconversionPartha/GoToCO';        
            $config['total_rows'] = $this->MbOfficeConversionModel->countFinalOrderConvMb3($user_code);
            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            $cases['cases'] = $this->MbOfficeConversionModel->getFinalOrderConvMb3($user_code,$config["per_page"], $page,$searchKeyword)->result();   
        } elseif ($process == '8') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countAllCircleCases($user_desig_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getAllCircleCases($user_desig_code)->result();
        } elseif ($process == '11') {
            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/COconversionPartha/GoToCO';        
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionPaymentDeclinedCases($user_code);
            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionPaymentDeclinedCases($user_code,$config["per_page"], $page,$searchKeyword)->result();           
        }
        //$cases['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        $cases['process'] = $process;
        // $cases['_view'] = 'co_office_conversion/co_conversion_cases';
        $cases['_view'] = 'conversion/co/co_proceeding_cases';
        $this->load->view('layouts/main',$cases);
    }

    public function firstProceeding() {
        $application_no = $this->input->get('application_no');

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(102, 'CO', $application_no);
        if($authorization['status']=='n') {
            //ERRRTPSCONVCO0001
            log_message('error', $authorization['messages'] .' Error: ERRRTPSCONVCO0001');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRRTPSCONVCO0001');
            redirect(base_url('index.php/home'));
            // return [
            //     'status'=>'FAILED',
            //     'responseType'=>1,
            //     'msg'=>'User not authorized. Error: #ERRRTPSCONVCO0001',
            // ];
        }
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$application_no,
            'reports'=>'co',
            'process'=>'co_first_proceeding',
            'default_report'=>'co'
        ];


        // $data['_view'] = 'conversion/co/co_first_proceeding';
        $this->load->view('layouts/main',$data);
    }

    public function coAllCases() {
        $case_no = $this->input->get('case_no', true);


        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'lm,co',
            'process'=>'co_all_cases',
            'default_report'=>'co'
        ];


        /*
        $applid = $this->db->query("select basundhara from basundhar_application where dharitree =?", array($case_no));
        $application_no = $applid->row()->basundhara;

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid=?", [$application_no]);

        if($supportive_document_sql->num_rows() > 0){
            $data['geo_tag_doc'] = $supportive_document_sql->result();
        }else{
            $data['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }

        $data['case_no'] = $case_no;
        
        $data['_view'] = 'conversion/co/co_all_cases';
        */
        $this->load->view('layouts/main',$data);
    }

    public function deleteConvDoc() {
        if(!isset($_POST['id']) || $_POST['id'] == '') {
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Missing Inputs',
            ]);
            exit();
        }
        $id = $this->input->post('id', true);
        $case_no = $this->input->post('case_no', true);
        // $dist_code = $this->session->userdata('dist_code');

        $this->db->trans_begin();
        $deleteArr = [
            'id' => $id,
            'case_no' => $case_no
        ];

        $deleteStatus = $this->db->delete('supportive_document', $deleteArr);
        if(!$deleteStatus || $this->db->affected_rows() < 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not delete document',
            ]);
            exit();
        }

        $this->db->trans_commit();

        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=>'Successfully deleted document',
        ]);
        exit;

    }

    public function firstProceedingPost() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'application_no'=>'Application No.|required|application_no',
            'co_order'=>'CO Order|required',
            'hearing_date'=>'Hearing Date|required|date',
            'radio'=>'Order Type|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOFIRST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOFIRST0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVCOFIRST0001',
            ]);
            exit();
        }

        //syntax validation
        // $requestResponse = checkRequestSpecChar($_POST, [], [], ['co_order'=>true]);
        $requestResponse = checkRequestSpecChar($_POST, ['co_order'=>['{', '}']], [], ['co_order'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOFIRST0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOFIRST0002');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVCOFIRST0002',
            ]);
            exit();
        }

        //check for malicious query
        $validResponse = checkRequestValidQuery($_POST, [], ['co_order'=>false]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOFIRST0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOFIRST0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVCOFIRST0003',
            ]);
            exit();
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(102, 'CO', $_POST['application_no']);
        if($authorization['status']=='n') {
            // ERRCONVCOFIRST0004
            log_message('error', 'User not authorized. Error: #ERRCONVCOFIRST0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'User not authorized. Error: #ERRCONVCOFIRST0004',
            ]);
            exit();
        }

        $application_no = $this->input->post('application_no');
        $hearing_date = $this->input->post('hearing_date');
        $co_order = $this->input->post('co_order');
        $radio = $this->input->post('radio');
        
        //from session
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $barak_districts = json_decode(BARAK_VALLEY);


        $recordExist = $this->RtpsModel->checkExistDharitree($application_no);

        if($recordExist) {
            //ERRCONVCOFIRST0005
            log_message('error', 'Case have been Registered Already. Please Check. Error: ERRCONVCOFIRST0005');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Case have been Registered Already. Please Check. Error: #ERRCONVCOFIRST0005'
            ]);
            exit();
        }

        $appDetails = $this->RtpsModel->getApplicationDetails($application_no);

        // echo '<pre>';
        // var_dump($appDetails);
        // die();

        $application = $appDetails->application;
        $mutation = $appDetails->mutation;
        $selfDeclaration = $appDetails->selfDeclaration;
        $applicants = $appDetails->applicants;

        $this->db->trans_begin();

        $chithaBasicDetails = $this->ChithaBasicModel->get([
            'dist_code' => $application->dist_code,
            'subdiv_code' => $application->subdiv_code,
            'cir_code' => $application->cir_code,
            'mouza_pargona_code' => $application->mouza_code,
            'lot_no' => $application->lot_no,
            'vill_townprt_code' => $application->village_code,
            'dag_no_int' => $application->dag_no
        ]);
        if(empty($chithaBasicDetails)) {
            // ERRCONVCOFIRST0014
            $this->db->trans_rollback();
            log_message('error', 'Dag could not be found in chitha_basic table. Error: ERRCONVCOFIRST0014');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Dag could not be found in chitha_basic table. Error: ERRCONVCOFIRST0014'
            ]);
            exit();
        }

        $case_name = $this->RtpsModel->genearteCaseName();
        if(empty($case_name)){
            //ERRCONVCOFIRST0006
            $this->db->trans_rollback();
            log_message('error', 'Network Issue or Session Out. Please try Again. Error: ERRCONVCOFIRST0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Network Issue or Session Out. Please try Again. Error: ERRCONVCOFIRST0006'
            ]);
            exit();
        }
        $seq_pet=year_no.'00';
        $petition_no = $seq_pet.$this->RtpsModel->genearteOfficePetitionNo();
        $case_no = $case_name . $petition_no. "/CONV";

        //insert into petition_basic
        $coDetails = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $check_trans_code = $this->ConversionModel->checkTransCode($application_no);
        $petition_basic_insert_array = [
            'dist_code'=>$application->dist_code,
            'subdiv_code'=>$application->subdiv_code,
            'cir_code'=>$application->cir_code,
            'mouza_pargona_code'=>$application->mouza_code,
            'lot_no'=>$application->lot_no,
            'vill_townprt_code'=>$application->village_code,
            'user_code'=>$user_code,
            'case_no'=>$case_no,
            'mut_type'=>'01', /////mut type
            'trans_code'=>$check_trans_code,/////////full
            'petition_no'=>$petition_no,
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d H:i:s'),                 
            'operation'=>'E',
            'submission_date' => date('Y-m-d H:i:s'),
            'add_off_name' => $coDetails->username,//
            'add_off_desig' =>'CO',
            'supported_doc' => 'Y',
            'co_user_code' =>$user_code,
            'status'=>'P',
            'next_date_of_hearing'=>$hearing_date,
            'not_fresh'=>'Y',
            'notice_generated_yn'=>'Y',
            'notice_generated_date'=>date('Y-m-d H:i:s'),
            'is_mb3' =>1,
            'new_status'=>'COLM1',
        ];
        $insertPetitionBasic = $this->db->insert('petition_basic', $petition_basic_insert_array);
        if(!$insertPetitionBasic || $this->db->affected_rows() < 1) {
            //ERRCONVCOFIRST0007
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in petition basic. Error: ERRCONVCOFIRST0007');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not insert into database table. Error: ERRCONVCOFIRST0007'
            ]);
            exit();
        }

        if(!in_array($application->dist_code, $barak_districts)) {
            $mutated_ganda = '0.00';
            $chitha_ganda = '0';
            $mutated_kranti = '0';
            $chitha_kranti = '0';
        }
        else {
            $mutated_ganda = $mutation[0]->area_g;
            $chitha_ganda = $application->area_g;
            $mutated_kranti = $mutation[0]->area_ka;
            $chitha_kranti = $application->area_kr;
        }

        //insert into petition_dag_details
        $pattaDetails = $this->utilityclass->getPattaTypeNoMB3Api($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code,$application->lot_no,$application->village_code,$application->dag_no);
        $petition_dag_insert_array = [
            'dist_code'=>$application->dist_code,
            'subdiv_code'=>$application->subdiv_code,
            'cir_code'=>$application->cir_code,
            'mouza_pargona_code'=>$application->mouza_code,
            'lot_no'=>$application->lot_no,
            'vill_townprt_code'=>$application->village_code,
            'dag_no'=>$chithaBasicDetails->dag_no,
            'patta_no'=>$pattaDetails->patta_no,
            'patta_type_code'=>$pattaDetails->patta_type_code,
            'user_code'=>$user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no,
            'petition_no'=>$petition_no,
            'year_no'=>date('Y'),
            'operation'=>'E',
            'm_dag_area_b'=>$mutation[0]->area_b,
            'm_dag_area_k'=>$mutation[0]->area_k,
            'm_dag_area_lc'=>$mutation[0]->area_lc,
            'dag_area_b'=>$application->area_b,
            'dag_area_k'=>$application->area_k,
            'dag_area_lc'=>$application->area_l,
            'm_dag_area_g'=>$mutated_ganda,
            'm_dag_area_kr'=>$mutated_kranti,
            'dag_area_g'=>$chitha_ganda,
            'dag_area_kr'=>$chitha_kranti,
            'revenue'=>0
        ];
        $insertPetitionDagDetails = $this->db->insert('petition_dag_details',$petition_dag_insert_array);
        if(!$insertPetitionDagDetails || $this->db->affected_rows() < 1) {
            //ERRCONVCOFIRST0008
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in petition dag details. Error: ERRCONVCOFIRST0008');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not insert into database table. Error: ERRCONVCOFIRST0008'
            ]);
            exit();
        }

        // insert into petitioner_part
        $i = 0;
        foreach ($mutation as $part) {
            $file = null;
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
            if($part->is_applicant == '1') {
                if(isset($selfDeclaration) && !empty($selfDeclaration) && isset($selfDeclaration[0]->dec_details) && !empty($selfDeclaration[0]->dec_details)) {
                    $dec = $selfDeclaration[0]->dec_details;
                }
                $auth_type = $part->auth_type;
                $id_ref_no = $part->id_ref_no;
                if($part->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $appDetails->photo;
                    $file         = $uploadpath . $id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }
            $faddress = $this->ConversionModel->address($part->address);
            $petitioner_part_insert_array = [
                'dist_code'=>$application->dist_code,
                'subdiv_code'=>$application->subdiv_code,
                'cir_code'=>$application->cir_code,
                'mouza_pargona_code'=>$application->mouza_code,
                'lot_no'=>$application->lot_no,
                'vill_townprt_code'=>$application->village_code,
                'user_code'=>$user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no,
                'petition_no'=>$petition_no,
                'operation'=>'E',
                'dag_no' =>$chithaBasicDetails->dag_no,
                'patta_no' =>$pattaDetails->patta_no,
                'patta_type_code'=>$pattaDetails->patta_type_code,
                'year_no'=>date('Y'),
                'pdar_id' =>$part->chitha_pdar_id,
                'pdar_cron_no'=>$i++,
                'pdar_name' =>$part->name_ass,
                'pdar_guardian' =>$part->gurdian_name_ass,
                'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($application->dist_code,$part->gurdian_relation_id),/////////////
                'pdar_gender'=>$this->utilityclass->gnderRevertBasu($application->dist_code,$part->gender),
                'pdar_add1' => $faddress[0],
                'pdar_add2' => $faddress[1],
                'pdar_mobile' => $part->mobile,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo,
                'pdar_dob'=>date('Y-m-d', strtotime($part->dob))
            ];
            $insertPetitionerPart = $this->db->insert('petitioner_part',$petitioner_part_insert_array);
            if(!$insertPetitionerPart || $this->db->affected_rows() < 1) {
                //ERRCONVCOFIRST0009
                $this->db->trans_rollback();
                log_message('error', 'Error in insert query in petitioner_part. Error: ERRCONVCOFIRST0009');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=>'Could not insert into database table. Error: ERRCONVCOFIRST0009'
                ]);
                exit();
            }
        }

        // insert into basundhar_application
        $uuid = $this->utilityclass->getVillageUUID($application->dist_code, $application->subdiv_code, $application->cir_code,$application->mouza_code, $application->lot_no, $application->village_code);
        $basundhara = [
            'dharitree' => $case_no,
            'basundhara' => $application_no,
            'date_reg' => date('Y-m-d'),
            'reg_by' => $user_code,
            'app_status' => 'P',
            'pending_with' => 'CO',
            'uuid' => $uuid
        ];
        $insertBasundharApplication = $this->db->insert('basundhar_application',$basundhara);
        if(!$insertBasundharApplication || $this->db->affected_rows() < 1) {
            //ERRCONVCOFIRST0010
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in basundhar_application. Error: ERRCONVCOFIRST0010');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not insert into database table. Error: ERRCONVCOFIRST0010'
            ]);
            exit();
        }

        // insert into petition_proceeding
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $co_order,
            'note_on_order' => 'CO Forwarded to LRA',
            'next_date_of_hearing' => $hearing_date,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $application->dist_code,
            'subdiv_code' => $application->subdiv_code,
            'cir_code' => $application->cir_code,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            //ERRCONVCOFIRST0011
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in petition_proceeding. Error: ERRCONVCOFIRST0011');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not insert into database table. Error: ERRCONVCOFIRST0011'
            ]);
            exit();
        }
        

        $penUser='LM';
        $rmrk='Report by CO';
        $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
        $status='M';
        $task='CO';
        $pen='LM';
        $case=$case_no;
        $rtps_status = $this->basundharamodel->postApiBasundharaConvMb3($application_no,$case,$rmrk,$status,$task,$pen);
        
        if(trim($rtps_status) !="y") {  //(trim($rtps_status) =="n") this check is dangerous
            //ERRCONVCOFIRST0012
            $this->db->trans_rollback();
            log_message('error', 'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVCOFIRST0012');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVCOFIRST0012'
            ]);
            exit();
        }

        // var_dump("mmm blocked:-".$rtps_status); die;

        if($this->db->trans_status() == FALSE) {
            //ERRCONVCOFIRST0013
            $this->db->trans_rollback();
            log_message('error', 'Error in Transaction. Error: ERRCONVCOFIRST0013');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Error in Transaction. Error: ERRCONVCOFIRST0013'
            ]);
            exit();
        }

        $this->db->trans_commit();


        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=>'Successfully passed to LRA. Case No: '. $case_no .'.'
        ]);
        exit();
        
    }

    public function secondProceeding() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVCOSECONDVIEW001');
            $this->session->set_flashdata('message', 'Case No not set. Error: ERRCONVCOSECONDVIEW001');
            redirect(base_url('index.php/home'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_GET['case_no'], CONV_CO_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOSECONDVIEW002
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOSECONDVIEW002');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOSECONDVIEW002');
            redirect(base_url('index.php/home'));
        }

        $case_no = $this->input->get('case_no');

        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'lm,sk,co',
            'process'=>'co_second_proceeding',
            'default_report'=>'co'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function secondProceedingPost() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'co_notice'=>'CO Notice|required',
            'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required',
            'co_reason_note'=>'CO Revert Note|required_on_condition(order_type,equals,[re_lm_note])',
            're_hearing_date'=>'Reverted Hearing Date|required_on_condition(order_type,equals,[re_lm_note])|date',
            'adc_dc_code'=>'ADC/DC Name|required_on_condition(order_type,equals,[forwardtodc])'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOSECOND0001
            log_message('error', 'Message: '. $formValidation['message'] .',Data: '. json_encode($formValidation['data']) .' Error: ERRCONVCOSECOND0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVCOSECOND0001',
            ]);
            exit();
        }
        //syntax validation

        // ? mark to check and the open this code
        // $requestResponse = checkRequestSpecChar($_POST, ['co_notice'=>['%', '৚']], [], ['co_notice'=>true]);
        // if($requestResponse['status'] == 'n') {
        //     //ERRCONVCOSECOND0002
        //     log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOSECOND0002');
        //     echo json_encode([
        //         'status'=>'FAILED',
        //         'responseType'=>1,
        //         'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVCOSECOND0002',
        //     ]);
        //     exit();
        // }
 
        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['co_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOSECOND0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOSECOND0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVCOSECOND0003',
            ]);
            exit();
        }
        
        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOSECOND0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOSECOND0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$authorization['messages'] . '. Error: #ERRCONVCOSECOND0004',
            ]);
            exit();
        }

        // echo '<pre>';
        // var_dump($_POST);
        // die();

        $case_no = $this->input->post('case_no');
        $co_notice = $this->input->post('co_notice');
        $hearing_date = $this->input->post('hearing_date');
        $hearing_date_type = strtotime($hearing_date);
        $hearing_date_formatted = date('Y-m-d', $hearing_date_type);
        $order_type = $this->input->post('order_type');
        if($order_type == 're_lm_note') {
            $co_reason_note = $this->input->post('co_reason_note');
            $re_hearing_date = $this->input->post('re_hearing_date');
            $re_hearing_date_type = strtotime($re_hearing_date);
            $re_hearing_date_formatted = date('Y-m-d', $re_hearing_date_type);
        }
        else if($order_type == 'forwardtodc') {
            $adc_dc_code = $this->input->post('adc_dc_code');
        }
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code,$petitionBasic->subdiv_code,$petitionBasic->cir_code,$user_code);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);

        if($order_type == 're_lm_note') {
            $note_on_order = 'Reverted to LRA by CO';
            $date_of_hearing = $re_hearing_date_formatted;
        }
        else if($order_type == 'forwardtodc') {
            $note_on_order = 'Forwarded to ADC/DC by CO';
            $date_of_hearing = $hearing_date_formatted;
        }
        else if($order_type == 'prepare_premium') {
            $note_on_order = 'Forwarded to AST For premium';
            $date_of_hearing = date('Y-m-d');
        }
        else if($order_type == 'continuehearing') {
            $note_on_order = 'Hearing Continued by CO';
            $date_of_hearing = $hearing_date_formatted;
        }
        else if($order_type == 'finalhukum') {
            $note_on_order = 'Final Proceeding';
            $date_of_hearing = date('Y-m-d');
        }

        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d H:i:s', $date_of_hearing),
            'co_order' => ($order_type == 're_lm_note') ? $co_reason_note : $co_notice,
            'note_on_order' => $note_on_order,
            'next_date_of_hearing' => $date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];

        if($order_type == 're_lm_note') {
            //petition_basic
            $petitionBasicUpdateArr = [
                'lm_note_yn' => null,
                'lm_note_date' => null,
                'proceeding_yn' => null,
                'new_status' =>'COLMR'
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0005
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVCOSECOND0005');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_basic table. Error: #ERRCONVCOSECOND0005',
                ]);
                exit();
            }

            //petition_lm_note
            $petitionLmNoteUpdateArr = [
                'co_reject' => 'Y'
            ];
            $this->db->where([
                'petition_no' => $petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionLmNoteUpdate = $this->db->update('petition_lm_note', $petitionLmNoteUpdateArr);
            if(!$petitionLmNoteUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0006
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_lm_note table. Error: ERRCONVCOSECOND0006');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_lm_note table. Error: #ERRCONVCOSECOND0006',
                ]);
                exit();
            }

            //petition_proceeding
            $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0007
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVCOSECOND0007');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_proceeding table. Error: #ERRCONVCOSECOND0007',
                ]);
                exit();
            }

            $penUser='LM';
            $rmrk='Forwarded by CO';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='LM';
            $case=$case_no;
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            if (trim($rtps_status) !="y") {
                //ERRCONVCOSECOND0008
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVCOSECOND0008');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVCOSECOND0008',
                ]);
                exit();
            }

            if($this->db->trans_status() == FALSE) {
                //ERRCONVCOSECOND0009
                $this->db->trans_rollback();
                log_message('error', 'Error in DB Transaction. Error: ERRCONVCOSECOND0009');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'DB Transaction Failed. Error: #ERRCONVCOSECOND0009',
                ]);
                exit();
            }

            $this->db->trans_commit();
            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Successfully reverted the case no '. $case_no .' to LRA'
            ]);
            exit();
        }
        else if ($order_type == 'forwardtodc') {
            $adcDcUserDetails = $this->UsersModel->getDetails($adc_dc_code, $petitionBasic->dist_code);
            //petition_basic
            $petitionBasicUpdateArr = [
                'add_off_desig' => $adcDcUserDetails->user_desig_code,
                'add_off_name' => $adcDcUserDetails->username,
                'co_user_code' => $adcDcUserDetails->user_code,
                'status' => 'P',
                'new_status' => 'COADC'
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0005
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVCOSECOND0005');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_basic table. Error: #ERRCONVCOSECOND0005',
                ]);
                exit();
            }

            //petition_proceeding
            $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0006
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVCOSECOND0006');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_proceeding table. Error: #ERRCONVCOSECOND0006',
                ]);
                exit();
            }

            $penUser='DC';
            $rmrk='Forwarded By CO';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='DC';
            $case=$case_no;
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            if (trim($rtps_status) !="y") {
                // ERRCONVCOSECOND0007
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted case no '. $case_no .'. Error: ERRCONVCOSECOND0007');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted case no '. $case_no .'. Error: #ERRCONVCOSECOND0007',
                ]);
                exit();
            }

            if($this->db->trans_status() == FALSE) {
                //ERRCONVCOSECOND0008
                $this->db->trans_rollback();
                log_message('error', 'Error in DB Transaction. Error: ERRCONVCOSECOND0008');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'DB Transaction Failed. Error: #ERRCONVCOSECOND0008',
                ]);
                exit();
            }

            $this->db->trans_commit();
            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Successfully forwarded to ADC/DC the case no '. $case_no
            ]);
            exit();

        }
        else if($order_type == 'prepare_premium') {
            $astUser = $this->UsersModel->getAstDetails($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            //petition_basic
            $petitionBasicUpdateArr = [
                'proceeding_yn' => null,
                'co_order_conv_premium' => 'Y',
                'co_order_conv_date' => date('Y-m-d H:i:s'),
                'co_order_conv_notice' => 'Y',
                'user_code' => $astUser->user_code,
                'new_status' => 'COASP'
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0005
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVCOSECOND0005');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_basic table. Error: #ERRCONVCOSECOND0005',
                ]);
                exit();
            }

            //petition_proceeding
            $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0006
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVCOSECOND0006');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_proceeding table. Error: #ERRCONVCOSECOND0006',
                ]);
                exit();
            }

            $penUser='AST';
            $rmrk='Notice for premium';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='AST';
            $case=$case_no;
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            if (trim($rtps_status) !="y") {
                // ERRCONVCOSECOND0007
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted case no '. $case_no .'. Error: ERRCONVCOSECOND0007');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted case no '. $case_no .'. Error: #ERRCONVCOSECOND0007',
                ]);
                exit();
            }

            if($this->db->trans_status() == FALSE) {
                // ERRCONVCOSECOND0008
                $this->db->trans_rollback();
                log_message('error', 'Error in DB transaction. Error: ERRCONVCOSECOND0008');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'DB Transaction Failed. Error: #ERRCONVCOSECOND0008',
                ]);
                exit();
            }
            
            $this->db->trans_commit();
            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Premium Notice Given by CO for case no '. $case_no
            ]);
            exit();
        }
        else if($order_type == 'continuehearing') {
            $petitionBasicUpdateArr = [
                'next_date_of_hearing' => $date_of_hearing,
                'notice_served_yn' => null,
                'proceeding_yn' => null
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND0005
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVCOSECOND0005');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_basic table. Error: #ERRCONVCOSECOND0005',
                ]);
                exit();
            }

            $proceeding_data_continue_hearing = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d H:i:s', $date_of_hearing),
            'co_order' => 'Continue Hearing',
            'note_on_order' => 'Hearing proceedings have been continued by CO',
            'next_date_of_hearing' => $date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
            ];

             //petition_proceeding
            $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data_continue_hearing);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVCOSECOND00079
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVCOSECOND00079');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Error in updation in petition_proceeding table. Error: #ERRCONVCOSECOND00079',
                ]);
                exit();
            }

            $penUser='AST';
            $rmrk='Hearing proceedings have been continued by CO';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='AST';
            $case=$case_no; 
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            if (trim($rtps_status) !="y") {
                // ERRCONVCOSECOND0006
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVCOSECOND0006');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVCOSECOND0006',
                ]);
                exit();
            }

            if($this->db->trans_status() == FALSE) {
                // ERRCONVCOSECOND0007
                $this->db->trans_rollback();
                log_message('error', 'Error in DB transaction. Error: ERRCONVCOSECOND0007');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'DB Transaction Failed. Error: #ERRCONVCOSECOND0007',
                ]);
                exit();
            }

            $this->db->trans_commit();
            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Hearing Continued for case no '. $case_no
            ]);
            exit();
        }
        else if($order_type == 'finalhukum') {

        }
    }

    public function chithaUpdate() {
        $case_no = $this->input->get('case_no');

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $case_no, CONV_CO_CHITHAUPD_COEND);
        if($authorization['status']=='n') {
            //ERRRTPSCONVCO0001
            log_message('error', $authorization['messages'] .' Error: ERRCONVCHITHAUPDVIEW0001');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVCHITHAUPDVIEW0001');
            redirect(base_url('index.php/home'));
            // return [
            //     'status'=>'FAILED',
            //     'responseType'=>1,
            //     'msg'=>'User not authorized. Error: #ERRRTPSCONVCO0001',
            // ];
        }
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'lm,sk,premium,co',
            'process'=>'co_chitha_update',
            'default_report'=>'co'
        ];


        // $data['_view'] = 'conversion/co/co_first_proceeding';
        $this->load->view('layouts/main',$data);
    }

    public function coFinalOrder() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVCOSECONDVIEW001');
            $this->session->set_flashdata('message', 'Case No not set. Error: ERRCONVCOSECONDVIEW001');
            redirect(base_url('index.php/home'));
        }

        //authorization
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_GET['case_no'], CONV_CO_SECOND);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVCOSECONDVIEW002
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVCOSECONDVIEW002');
        //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOSECONDVIEW002');
        //     redirect(base_url('index.php/home'));
        // }

        $case_no = $this->input->get('case_no');

        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'lm,sk,premium,co',
            'process'=>'co_final_order',
            'default_report'=>'co'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function coFinalOrderPost() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'co_notice'=>'CO Notice|required',
            'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required',
            'co_reason_note'=>'CO Revert Note|required_on_condition(order_type,equals,[re_lm_note])',
            're_hearing_date'=>'Reverted Hearing Date|required_on_condition(order_type,equals,[re_lm_note])|date',
            'adc_dc_code'=>'ADC/DC Name|required_on_condition(order_type,equals,[forwardtodc])'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOSECOND0001
            log_message('error', 'Message: '. $formValidation['message'] .',Data: '. json_encode($formValidation['data']) .' Error: ERRCONVCOSECOND0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVCOSECOND0001',
            ]);
            exit();
        }
        //syntax validation

        // ? mark to check and the open this code
        // $requestResponse = checkRequestSpecChar($_POST, ['co_notice'=>['%', '৚']], [], ['co_notice'=>true]);
        // if($requestResponse['status'] == 'n') {
        //     //ERRCONVCOSECOND0002
        //     log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOSECOND0002');
        //     echo json_encode([
        //         'status'=>'FAILED',
        //         'responseType'=>1,
        //         'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVCOSECOND0002',
        //     ]);
        //     exit();
        // }
 
        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['co_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOSECOND0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOSECOND0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVCOSECOND0003',
            ]);
            exit();
        }
        
        //authorization
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_SECOND);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVCOSECOND0004
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVCOSECOND0004');
        //     echo json_encode([
        //         'status'=>'FAILED',
        //         'responseType'=>1,
        //         'msg'=>$authorization['messages'] . '. Error: #ERRCONVCOSECOND0004',
        //     ]);
        //     exit();
        // }

        // echo '<pre>';
        // var_dump($_POST);
        // die();

        $case_no = $this->input->post('case_no');
        $co_notice = $this->input->post('co_notice');
        $hearing_date = $this->input->post('hearing_date');
        $hearing_date_type = strtotime($hearing_date);
        $hearing_date_formatted = date('Y-m-d', $hearing_date_type);
        $order_type = $this->input->post('order_type');
        if($order_type == 're_lm_note') {
            $co_reason_note = $this->input->post('co_reason_note');
            $re_hearing_date = $this->input->post('re_hearing_date');
            $re_hearing_date_type = strtotime($re_hearing_date);
            $re_hearing_date_formatted = date('Y-m-d', $re_hearing_date_type);
        }
        else if($order_type == 'forwardtodc') {
            $adc_dc_code = $this->input->post('adc_dc_code');
        }
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code,$petitionBasic->subdiv_code,$petitionBasic->cir_code,$user_code);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);

        if($order_type == 're_lm_note') {
            $note_on_order = 'Reverted to LRA by CO';
            $date_of_hearing = $re_hearing_date_formatted;
        }
        else if($order_type == 'forwardtodc') {
            $note_on_order = 'Forwarded to ADC/DC by CO';
            $date_of_hearing = $hearing_date_formatted;
        }
        else if($order_type == 'prepare_premium') {
            $note_on_order = 'Forwarded to AST For premium';
            $date_of_hearing = date('Y-m-d');
        }
        else if($order_type == 'continuehearing') {
            $note_on_order = 'Hearing Continued by CO';
            $date_of_hearing = $hearing_date_formatted;
        }
        else if($order_type == 'finalhukum') {
            $note_on_order = 'Final Proceeding';
            $date_of_hearing = date('Y-m-d');
        }

        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d H:i:s', $date_of_hearing),
            'co_order' => ($order_type == 're_lm_note') ? $co_reason_note : $co_notice,
            'note_on_order' => $note_on_order,
            'next_date_of_hearing' => $date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];

        
        if($order_type == 'finalhukum') {
            var_dump('aaaaaaaaaa'); die;

        }
        else{

                echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Error: #ERRCONVCOSECOND00094: Wrong Selection, Please Contact Administrator!!',
            ]);
            exit();

        }

        
    }


    public function coFinalOrderPostNew() {
        $case_no = $this->input->post('case_no');
        $dag_revenue = $this->input->post('dag_revenue');
        $dag_local_tax = $this->input->post('dag_local_tax');
        // $new_dag_no           =  $this->input->post('sugg_dag_no');
        // $new_patta_no         =  $this->input->post('sugg_patta_no');
        $new_patta_type_code  =  $this->input->post('new_patta_type');
        //and new_status in ('ADCTP', 'ASPNS') and is_mb3=1
        $petition_basic_sql = $this->db->query("SELECT * FROM petition_basic WHERE case_no = ? and (new_status=? and dc_final_approval=?) or (new_status=? or new_status=?) and is_mb3=? ", [$case_no,'DCCOC','Y','ASPNS','ASPPC',1]);//->row();
        // echo $this->db->last_query();
        if($petition_basic_sql->num_rows()==0){
            echo show_error('401');
        }
        $petition_basic=$petition_basic_sql->row();
        $petitioner_part = $this->db->query("SELECT * FROM petitioner_part WHERE case_no = ?", [$case_no])->result_array();
        $petition_dag_details = $this->db->query("SELECT * FROM petition_dag_details WHERE case_no = ?", [$case_no])->row();
        $petition_lm_note = $this->db->query("SELECT * FROM petition_lm_note WHERE case_no = ? and prem_pay_method is not null and recpt_number is not null and prim_tot is not null order by id desc", [$case_no])->row();
        //  and rem_pay_method is not null and 
        // recpt_number is not null and prim_tot is not null
        // var_dump($petitioner_part);die;
        foreach($petitioner_part as $petitioner){
            $applicant[]=[
                'name'                => $petitioner['pdar_name'],
                'gurdian_name'        => $petitioner['pdar_guardian'],
                'relation'            => $petitioner['pdar_rel_guar'], /// ////
                'caste'               => null,
                'mobile'              => $petitioner['pdar_mobile'],
                'gender'              => $petitioner['pdar_gender'],
                'pdar_id'             => $petitioner['pdar_id'],
                'dag_no'              => $petitioner['dag_no'],
                'ekyc-type'           => $petitioner['auth_type'],
                'ejyc-hash'           => $petitioner['id_ref_no'],
                'eng_name'            => null,
                'guardina_eng_name'   => null,
            ];
        }
        $loc_array=[
                'dist_code' =>$petition_basic->dist_code,
                'subdiv_code' =>$petition_basic->subdiv_code,
                'cir_code' =>$petition_basic->cir_code,
                'mouza_pargona_code' =>$petition_basic->mouza_pargona_code,
                'lot_no' =>$petition_basic->lot_no,
                'vill_townprt_code' =>$petition_basic->vill_townprt_code,
        ];
        $Final_array = [
            'application_no'       => $this->basundharamodel->checkExistBasundhar($petition_basic->case_no) ?: '',
            'service_code'         => 44,
            'case_no'              => $petition_basic->case_no,
            'date_of_registration' => $petition_basic->submission_date,
            'reg_deed_no'          => $petition_basic->deed_no,
            'deed_date'            => $petition_basic->deed_date,
            'goa_approve_date'     => $petition_basic->dept_order_date??"NA",
            'goa_order_no'         => $petition_basic->dept_order_no,
            'dc_order_date'        => date('Y-m-d'),
            'dc_order_no'          => "NA",
            'dc_code'              => "NA",
            'lm_code'              => $petition_lm_note->lm_code,
            'lm_date'              => $petition_lm_note->lm_sign_date,
            'co_code'              => $petition_basic->co_user_code,
            'co_date'              => date('Y-m-d'),
            'grn_no'               => $petition_lm_note->recpt_number,
            'premium_amt'          => $petition_lm_note->prim_tot,
            'payment_date'         => $petition_lm_note->prem_pay_date,
            'dags' => [
                'dag_no'               => $petition_dag_details->dag_no,
                'patta_no'             => $petition_dag_details->patta_no,
                'patta_type_code'      => $petition_dag_details->patta_type_code,
                'new_dag_no'           => null,//$new_dag_no,
                'new_patta_no'         => null,//$new_patta_no,
                'new_patta_type_code'  => $new_patta_type_code,
                'applied_b'            => $petition_lm_note->conv_b,
                'applied_k'            => $petition_lm_note->conv_k,
                'applied_lc'           => $petition_lm_note->conv_lc,
                'applied_g'            => $petition_lm_note->conv_g,
                'reservation_b'        => $petition_lm_note->roadside_rsv_b + $petition_lm_note->riverside_rsv_b,
                'reservation_k'        => $petition_lm_note->roadside_rsv_k + $petition_lm_note->riverside_rsv_k ,
                'reservation_lc'       => $petition_lm_note->roadside_rsv_lc + $petition_lm_note->riverside_rsv_lc,
                'reservation_g'        => $petition_lm_note->roadside_rsv_g + $petition_lm_note->riverside_rsv_g,
                'revenue'              => $dag_revenue,
                'local_tax'            => $dag_local_tax,
            ],
            'applicant' => $applicant,
            'location' => $loc_array
        ];
        $this->db->trans_begin();
        $response=$this->ChithaUpdateModel->conversionUpdateChitha($case_no,$Final_array);
        $result=json_decode($response);
        if($result->responseType==2){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }
        echo $response;
        // var_dump($array);die;  
    }

    public function getNewDagPattaTypeJSON() {
       $case_no = $this->input->get('case_no');
       $type_code = $this->input->get('type_code');

       $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no'")->row();
       $dist_code = $petition_basic->dist_code;
       $subdiv_code = $petition_basic->subdiv_code;
       $cir_code = $petition_basic->cir_code;
       $mouza_pargona_code = $petition_basic->mouza_pargona_code;
       $lot_no = $petition_basic->lot_no;
       $vill_townprt_code = $petition_basic->vill_townprt_code;
       $sql = "Select dag_no,patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
       //echo $sql;
       $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
       //var_dump($dag_no);
       $newDag = 0;
       foreach ($dag_no as $d) {
           $d = $d->dag_no;
           if ($newDag < $d) {
               $newDag = $d;
           }
       }
       $sqll = "Select dag_no,patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
       $patta = $data['oldPatta'] = $this->db->query($sqll)->result();
       $newpatta = 0;
       foreach ($patta as $p) {
           $p = trim($p->patta_no);
           if ($newpatta < $p) {
               $newpatta = $p;
           }
       }
       $json[] = array('new_dag' => $newDag + 1, 'new_patta' => $newpatta + 1);
       echo json_encode($json);
   }

   public function paymentDeclinedCases() {
    //$db=  $this->session->userdata('db');
      $case_no = $this->input->get('case_no');
      $type_code = $this->input->get('type_code');

      $case_details = $this->db->query("select * from petition_basic where case_no='$case_no'")->row();

      $db=  $this->session->userdata('db');
      $dist_code = $case_details->dist_code;
      $subdiv_code = $case_details->subdiv_code;
      $cir_code = $case_details->cir_code;
      $mouza_pargona_code = $case_details->mouza_pargona_code;
      $lot_no = $case_details->lot_no;
      $vill_townprt_code = $case_details->vill_townprt_code;
      $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
      $this->session->set_userdata(array('lot_no1' => $lot_no));
      $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
      $data = array();
      $case_no = $this->input->get('case_no');
      $user_code=$this->session->userdata('user_code');
      $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);
      $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' "
              . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
              . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3=1")->row();


      $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment,petition_no"
                      . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
              . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3=1")->row_array();
      
      $petition_no = $location['petition_no'];
      $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
      from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
      and cir_code='$cir_code' and lot_no='$lot_no' and 
      vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
      and petition_no='$petition_no'")->row_array();
    

      $locationData = array(
          'dist_code' => $location['dist_code'],
          'subdiv_code' => $location['subdiv_code'],
          'cir_code' => $location['cir_code'],
          'lot_no' => $location['lot_no'],
          'vill_code' => $location['vill_townprt_code'],
          'mouza_pargona_code' => $location['mouza_pargona_code']
      );
      $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
      $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
      $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
      $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
      $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
      $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
      
      $data['patta_type'] = $this->db->query("select patta_type from patta_code "
                      . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
      $m_dag_area_lc = $landdetails['m_dag_area_lc'];
      $m_dag_area_lc = round($m_dag_area_lc, 2);
      $data['location'] = array(
          'dist' => $dist_code,
          'sub' => $subdiv_code,
          'cir' => $cir_code,
          'mouza' => $mouza_pargona_code,
          'lot' => $lot_no,
          'vill' => $vill_townprt_code,
          'case_no' => $case_no,
          'date' => $location['date_entry'],
          'add_to' => $coname->username,
          'next_date' => $location['next_date_of_hearing'],
          'sk_comment' => $location['sk_comment'],
          'dag' => $landdetails['dag_no'],
          'm_dag_area_b' => $landdetails['m_dag_area_b'],
          'm_dag_area_k' => $landdetails['m_dag_area_k'],
          'm_dag_area_lc' => $m_dag_area_lc,
          'patta_no' => trim($landdetails['patta_no']),
          'patta_type' => $landdetails['patta_type_code'],
      );

      $convertion_code = CONVERSION_CODE;
      $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
              . "where order_type_code='$convertion_code'")->row()->order_type;

      $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
              . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
              . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

      $m_dag_area_lc = $landdetails['m_dag_area_lc'];
      $m_dag_area_lc = round($m_dag_area_lc, 2);

      $data['land_details'] = array(
          'dag' => $landdetails['dag_no'],
          'm_dag_area_b' => $landdetails['m_dag_area_b'],
          'm_dag_area_k' => $landdetails['m_dag_area_k'],
          'm_dag_area_lc' => $m_dag_area_lc,
          'patta_no' => trim($landdetails['patta_no']),
          'patta_type' => $landdetails['patta_type_code']
      );

      $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                      . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

      $pattadardetails = "select auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from petitioner_part where dist_code='$petition_basic->dist_code' and "
              . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
              . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
              . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
              . "patta_type_code= '$landdetails[patta_type_code]'";
              
      
      $data['pattadar'] = $this->db->query($pattadardetails)->result();
      $data['p_in_order'] = $this->db->query($pattadardetails)->result();
      
      $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
              . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
              . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();
              
      if($lm_details['premium_new_yn'] == 1) {
          $getPremiumRate = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();
          if($getPremiumRate->amount != 0 && $getPremiumRate->rate == 0) {
              $effective_premium_amount = $getPremiumRate->amount;
              $is_percent = 0;
          }
          else if($getPremiumRate->amount == 0 && $getPremiumRate->rate != 0) {
              $effective_premium_amount = $getPremiumRate->rate;
              $is_percent = 1;
          }
          else {
              $effective_premium_amount = 0;
              $is_percent = 0;
          }
          $data['premium_rate_details'] = $getPremiumRate;
          $data['premium_area_details'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE is_deleted=0 AND id=?", [$lm_details['conversion_premium_areas_id']])->row();
          $data['conversion_premium_area'] = $data['premium_area_details'];
      }
      else {
          $effective_premium_amount = 0;
          $is_percent = 0;
          $data['premium_rate_details'] = '';
          $data['premium_area_details'] = '';
          $data['conversion_premium_area'] = '';
      }
      if (count($lm_details) != '0') {
          $land = $lm_details['land_class_code'];
          $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

          $prim_per_bigha = $lm_details['prim_per_bigha'];
          $prim_per_bigha = round($prim_per_bigha, 2);

          $prim_tot = $lm_details['prim_tot'];
          $prim_tot = round($prim_tot, 2);

          $data['lm_details'] = array(
              //'petition_no' => $lm_details[''],
              'dag_no' => $lm_details['dag_no'],
              'note_no' => $lm_details['note_no'],
              'partition_info' => $lm_details['partition_info'],
              //'user_code' => $lm_details[''],
              'date_entry' => $lm_details['date_entry'],
              //'operation' => $lm_details[''],
              'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
              'occupied_yn' => $lm_details['occupied_yn'],
              'val_tree_yn' => $lm_details['val_tree_yn'],
              'dist_frm_town' => $lm_details['dist_frm_town'],
              'inside_outside_town' => $lm_details['inside_outside_town'],
              'land_class_code' => $land_type->land_type,
              'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
              'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
              'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
              'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
              'near_river_yn' => $lm_details['near_river_yn'],
              'prim_per_bigha' => $prim_per_bigha,
              'conv_b' => $lm_details['conv_b'],
              'conv_k' => $lm_details['conv_k'],
              'conv_lc' => $lm_details['conv_lc'],
              'prim_tot' => $prim_tot,
              'lm_sign_yn' => $lm_details['lm_sign_yn'],
              'case_no' => $case_no,
              'lm_code' => $lm_details['lm_code'],
              'sk_note_date' => $lm_details['sk_note_date'],
              'sk_note' => $lm_details['sk_note'],
              'sk_sign_yn' => $lm_details['sk_sign_yn'],
              'sk_name' => $lm_details['user_code'],
              'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
              'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
              'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
              'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
              'widow_yn' => $lm_details['widow_yn'],
              'widow_upload' => $lm_details['widow_upload'],
              'premium_assesment' => $lm_details['premium_assesment'],
              'land_trans_yn' => $lm_details['land_trans_yn'],
              'premium_new_yn' => $lm_details['premium_new_yn'],
              'effective_premium_amount' => $effective_premium_amount,
              'is_percent' => $is_percent
          );
      }
      
      $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
      $data['lm_name'] = $namelm->lm_name;

      
      $skname = $this->db->query("select * from  users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
      $data['sk_skname'] = $skname->username;

      $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
      $data['cases'] = $this->db->query($query)->result();

      $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' ORDER BY note_no DESC LIMIT 1")->result();
      
      $data['premium'] = $this->db->query("Select * from petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

      
      $data['dc_adc']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
              . "loginuser_table where users.dist_code = loginuser_table.dist_code "
              . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
              . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

      $data['adc_only']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
      . "loginuser_table where users.dist_code = loginuser_table.dist_code "
      . "and users.user_code = loginuser_table.user_code and users.user_desig_code ='ADC' and users.dist_code='$petition_basic->dist_code' and "
      . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();
      //$data['basundharaExist']=$this->basundharamodel->checkExistBasundhar($case_no);
      $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
      
    //   if($basundharaExist){
       
    //       $data['query']=null;
    //       $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
    //       var_dump($rtps); die;
    //       if($rtps=='RTPS'){
    //           $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
    //       }else{
    //           $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
    //       }
    //       $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
    //   }
    //   else{
    //       $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
    //   }


      if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
      {
          //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
          $this->load->model('propChain/PropChainModel');

          $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

          $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

          // get total land area
          $landArea = $this->PropChainModel->getLandArea($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], trim($landdetails['patta_no']), $landdetails['dag_no']);

          // echo "<pre>";
          // var_dump($landdetails);
          $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], trim($landdetails['patta_no']), $landdetails['dag_no'], $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $landdetails['patta_type_code']);

          // die;

          // var_dump($checkRemainingLand);
          if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
              $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
              if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                  $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                      $case_no,
                      $location['dist_code'],
                      $location['subdiv_code'],
                      $location['cir_code'],
                      $location['mouza_pargona_code'],
                      $location['lot_no'],
                      $location['vill_townprt_code'],
                      trim($landdetails['patta_no']),
                      $landdetails['dag_no'],
                      $landArea->dag_area_b,
                      $landArea->dag_area_k,
                      $landArea->dag_area_lc,
                      $landArea->dag_area_g,
                      $landdetails['patta_type_code']
                  );
              }
          }

          $data['ulpinCheck'] = $chainChithaCheck['ulpinCheck'];
          $data['ulpinMsg'] = $chainChithaCheck['ulpinMsg'];

          if ($data['ulpinCheck'] == 1) {
              $data['ulpin'] = $chainChithaCheck['ulpin'];
              if (isset($data['old_ulpin']))
                  $data['old_ulpin'] = $chainChithaCheck['old_ulpin'];
              else
                  $data['old_ulpin'] = "";
          }

          $data['chithaPropChainCmpFlag'] =  $chainChithaCheck['chithaPropChainCmpFlag'];
          $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];

          if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')
              $data['createPropChainBtn'] = $chainChithaCheck['createPropChainBtn'];

          $data['revenue'] = $chainChithaCheck['revenue'];
          $data['local_tax'] = $chainChithaCheck['local_tax'];
          // hidden fields
          $data['ulpin_hidden'] = $chainChithaCheck['ulpin_hidden'];
          $data['uplpin_msg_hidden'] = $chainChithaCheck['uplpin_msg_hidden'];
          $data['compare_hidden'] = $chainChithaCheck['compare_hidden'];
          $data['compare_msg_hidden'] = $chainChithaCheck['compare_msg_hidden'];

          // bhunaksha area cmp
          $data['bhuChithaCmpStatus'] = $chainChithaCheck['bhuChithaCmpStatus'];
          $data['bhuChithaCmpMsg'] = $chainChithaCheck['bhuChithaCmpMsg'];
          $data['bhu_hidden'] = $chainChithaCheck['bhu_hidden'];
          $data['bhu_compare_msg_hidden'] = $chainChithaCheck['bhu_compare_msg_hidden'];
      }
      

      // $data['show_nav'] = ['allow'=>true, 'service_code'=>SERVICE_CONVERSION, 'case_no'=>$case_no, 'reports'=>'ast,lm,sk,co'];

      $data['_view'] = 'co_office_conversion/payment_declined_cases_mb3';
      $this->load->view('layouts/main',$data);
  }

  public function paymentDeclinedCasesPost() {
    $coNotice = $_POST['Co_notice'];
    $coReasonNote = $_POST['co_reason_note'];
    // $_POST['Co_notice'] = preg_replace('/\s+/', ' ', strip_tags($coNotice));
    $_POST['co_reason_note'] = preg_replace('/\xc2\xa0/', '', $coReasonNote);

    //form validation
    $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
        'case_no'=>'Case No.|required|case_no',
        'Co_notice'=>'CO Notice|required',
        'hearing_date'=>'Hearing Date|required|date',
        'order_type'=>'Order Type|required',
        'co_reason_note'=>'CO Revert Note|required_on_condition(order_type,equals,[re_lm_note])',
        're_hearing_date'=>'Reverted Hearing Date|required_on_condition(order_type,equals,[re_lm_note])|date'
    ]);
    if($formValidation['status'] == 'n') {
        //ERRCONVCOSECOND0001
        log_message('error', 'Message: '. $formValidation['message'] .',Data: '. json_encode($formValidation['data']) .' Error: ERRCONVPAYDEC00010');
        $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVPAYDEC00010');
        redirect(base_url('index.php/go_to_co?pro=11'));
    }

    //syntax validation
    $requestResponse = checkRequestSpecChar($_POST, ['Co_notice'=>['%', '৚']], [], ['Co_notice'=>true]);
    if($requestResponse['status'] == 'n') {
        //ERRCONVCOSECOND0002
        log_message('error', $requestResponse['messages'] . '. Error: ERRCONVPAYDEC00011');
        $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVPAYDEC00011');
        redirect(base_url('index.php/go_to_co?pro=11'));
    }

    //malicious query validation
    $validResponse = checkRequestValidQuery($_POST, [], ['Co_notice'=>true]);
    if($validResponse['status'] == 'n') {
        //ERRCONVCOSECOND0003
        log_message('error', $validResponse['messages'] . '. Error: ERRCONVPAYDEC00012');
        $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVPAYDEC00012');
        redirect(base_url('index.php/go_to_co?pro=11'));
    }
    
   
  //$db=  $this->session->userdata('db');
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
    $lot_no = $this->session->userdata('lot_no1');
    $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
    $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
    $re_hearing_date = date('Y-m-d', strtotime($this->input->post('re_hearing_date')));
    // $co_order = $this->input->post('Co_notice');
    // $co_reason_note = $this->input->post('co_reason_note');
    $co_order = $coNotice;
    $co_reason_note = $coReasonNote;
    $this->session->set_userdata(array('Co_notice' => $co_order));
    $case_no = $this->input->post('case_no');
    $dc_code = $this->input->post('dc_code');
    
    $order_type = $this->input->post('order_type');
    $user_code=$this->session->userdata('user_code');
    $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);
    $this->session->set_userdata(array('case_no' => $case_no));
    
    $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
            . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
    
    $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
    
    $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
    $proceeding_id = $proceeding[0]->proceed + 1;
    
    $date_entry = date('Y-m-d G:i:s');
    
    if($order_type == 're_lm_note'){
        $co_order = $co_reason_note;
    }
    $proceeding_data = array(
        'case_no' => $case_no,
        'proceeding_id' => $proceeding_id,
        'date_of_hearing' => $hearing_date,
        'co_order' => $co_order,
        //'note_on_order' => '',
        //'next_date_of_hearing' => $hearing_date,
        'status' => 'Pending',
        'user_code' => $user_code,
        'date_entry' => $date_entry,
        'operation' => 'E',
        'dist_code' => $location['dist_code'],
        'subdiv_code' => $location['subdiv_code'],
        'cir_code' => $location['cir_code']
    );
    //var_dump($proceeding_data);
    $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);

    
    if($order_type == 're_lm_note') {
        //petition_basic
        $petitionBasicUpdateArr = [
            'lm_note_yn' => null,
            'lm_note_date' => null,
            'proceeding_yn' => null,
            'co_order_conv_premium' => null,
            'pay_notice_gen_yn' => null,
            'new_status' =>'COLMR'
        ];
        $this->db->where([
            'case_no' => $case_no,
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code
        ]);
        $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
        if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
            //ERRCONVCOSECOND0005
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVCOSECOND0005');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=> 'Error in updation in petition_basic table. Error: #ERRCONVCOSECOND0005',
            ]);
            exit();
        }

        //petition_lm_note
        $petitionLmNoteUpdateArr = [
            'co_reject' => 'Y'
        ];
        $this->db->where([
            'petition_no' => $petitionBasic->petition_no,
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code
        ]);
        $petitionLmNoteUpdate = $this->db->update('petition_lm_note', $petitionLmNoteUpdateArr);
        if(!$petitionLmNoteUpdate || $this->db->affected_rows() < 1) {
            //ERRCONVCOSECOND0006
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_lm_note table. Error: ERRCONVCOSECOND0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=> 'Error in updation in petition_lm_note table. Error: #ERRCONVCOSECOND0006',
            ]);
            exit();
        }

        //petition_proceeding
        $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            //ERRCONVCOSECOND0007
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVCOSECOND0007');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=> 'Error in updation in petition_proceeding table. Error: #ERRCONVCOSECOND0007',
            ]);
            exit();
        }

        $penUser='LM';
        $rmrk='Forwarded by CO';
        $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
        $status='M';
        $task='CO';
        $pen='LM';
        $case=$case_no;
        $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
        if (trim($rtps_status) !="y") {
            //ERRCONVCOSECOND0008
            $this->db->trans_rollback();
            log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVCOSECOND0008');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVCOSECOND0008',
            ]);
            exit();
        }

        // payment request cancel api call
        $basundhara=$this->MbOfficeConversionModel->checkExistBasundhar($case_no);
        if($basundhara){
            $apilink=API_LINK_MB3;
            $curl_handle = curl_init();
            //curl_setopt($curl_handle,CURLOPT_URL, "https://basundhara.assam.gov.in/demo/LocalAPI/cancelPayRequest");
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."cancelPayRequest");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'query' => 'Cacncel the Premium Notice',
                'query_from_officer' => $this->session->userdata('user_code'),
                'query_from_office' => 'CO',
            )));
            $data=curl_exec($curl_handle);
            echo json_decode($data);
        }
        // payment request cancel api call end

        if($this->db->trans_status() == FALSE) {
            //ERRCONVCOSECOND0009
            $this->db->trans_rollback();
            log_message('error', 'Error in DB Transaction. Error: ERRCONVCOSECOND0009');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=> 'DB Transaction Failed. Error: #ERRCONVCOSECOND0009',
            ]);
            exit();
        }

        $this->db->trans_commit();
        echo json_encode([
            'status' => 'SUCCESS',
            'responseType' => 2,
            'msg' => 'Successfully reverted the case no '. $case_no .' to LRA'
        ]);
        exit();
    }
    else
    {
        log_message('error', $validResponse['messages'] . '. Error: ERRCONVPAYDEC00090');
        $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVPAYDEC00090');
        redirect(base_url('index.php/go_to_co?pro=11'));
    }
 }

 public function rejectedSecondProceeding() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        $data = array();
        $case_no = $this->input->get('case_no');
        $data['pb']=$petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' ")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment']
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                . "where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->row_array();

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code']
            );
        }
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        //echo " select * from    lm_code where lm_code = '".$lm_details['lm_code']."'  and dist_code = '".$location['dist_code']."' and subdiv_code = '".$location['subdiv_code']."' and cir_code = '".$location['cir_code']."' and mouza_pargona_code = '".$location['mouza_pargona_code']."' and lot_no = '".$location['lot_no']."' ";
        $data['lm_name'] = $namelm->lm_name;
        $skname = $this->db->query("select * from users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();
        
        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $this->db->query($dc_adc_order)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        //echo "Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'";
        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['dc_adc']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();
        
        $data['_view'] = 'co_office_conversion/rejected_Second_Proceeding_mb3';
        $this->load->view('layouts/main',$data);

    }

    public function regenerateAfterReject() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'proceeding_id'=>'Proceeding Id|required|digit',
            'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCORVRT0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCORVRT0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCORVRT0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }
        
        //syntax validation
        $note_on_order = $_POST['note_on_order'];
        $_POST['note_on_order'] = preg_replace('/\xc2\xa0/', '', $note_on_order);
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCORVRT0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCORVRT0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCORVRT0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCORVRT0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCORVRT0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCORVRT0003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_REVERT);
        if($authorization['status'] == 'n') {
            //ERRCONVCORVRT0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCORVRT0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCORVRT0004');
            redirect(base_url('index.php/home'));
        }

        
        // echo '<pre>';
        // var_dump($_POST);
        // die();
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $case_no = $this->input->post('case_no');
        $proceedings = $this->input->post('proceeding_id');
        // $action_note = $this->input->post('note_on_order');
        $action_note = $note_on_order;
        $action_note = str_replace("'", '', $action_note);
        $user_code = $this->session->userdata('user_code');
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $re_lm_note = $this->input->post('re_lm_note');
        $order_type = $this->input->post('order_type');
        $dc_code = $this->input->post('dc_code');
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $date_entry = date('Y-m-d G:i:s');
        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $action_note,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'operation' => 'E',
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code']
        );
        
        $this->db->trans_begin();
        //newly added by hridayjit
        $ast_info = $this->db->query("SELECT users.username, loginuser_table.user_code, users.user_desig_code FROM users, loginuser_table WHERE users.dist_code = loginuser_table.dist_code AND users.subdiv_code = loginuser_table.subdiv_code AND users.cir_code = loginuser_table.cir_code AND users.user_code = loginuser_table.user_code AND users.user_desig_code = 'AST' AND users.dist_code='$dist_code' AND users.subdiv_code='$subdiv_code' AND users.cir_code='$cir_code' AND loginuser_table.dis_enb_option = 'E' AND loginuser_table.priv = 'mut' ORDER BY loginuser_table.date_of_creation DESC LIMIT 1")->row();

        $update = "UPDATE  petition_basic SET dept_note_yn = NULL, dept_order_no = NULL, co_order_conv_date = NULL, co_order_conv_premium = NULL, user_code = '$ast_info->user_code', trans_code = 'F', bo_note_yn = NULL, bo_note_date = NULL, bo_notice_gen = NULL, lm_note_yn = NULL , lm_note_date = NULL, proceeding_yn = NULL, sk_comment = NULL, status = 'P',new_status='CORLM' WHERE case_no = '$case_no' and "
                    . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        $this->db->query($update);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV062: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV062: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $update1 = "UPDATE  petition_lm_note SET co_reject = 'Y' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'";
        $this->db->query($update1);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV063: Updation failed in petition_lm_note Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV063: Registration of Petition lm note for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        // $this->db->insert("petition_proceeding", $proceeding_data);
        $insert_pp5 = $this->db->insert("petition_proceeding", $proceeding_data);
        if($insert_pp5 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV064: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV064: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            ///////////////////////////////////////
            $penUser='LM';
            $rmrk='Reverted to LRA by CO';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='LM';
            $case=$case_no;
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            if (trim($rtps_status) !="y") {
                //ERRCONVCOSECOND0008
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVCOSECOND0008');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVCOSECOND0008',
                ]);
                exit();
            }
            ////////////////////////////////////////
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Request To Reserve Lot Mondals Note for Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }
    

}

