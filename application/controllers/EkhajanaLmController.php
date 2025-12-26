<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaLmController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaLm/EkhajanaLmModel');
        $this->load->model('eKhajana/Common/EkhajanaHelperModel');
        $this->dbswitch();
    }

    //script-validation-callback
    function check_script($str){

        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }

    //date-validation-callback
    function date_valid($date){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
            return false;
        
        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);                        
        return checkdate($month, $day, $year);
    }

    //db switch method
    public function dbswitch(){       
        //$CI=&get_instance();
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
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
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
        }
    }

    //index-method
    public function index() {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        if(in_array($this->session->userdata('dist_code'),EKHAJANA_EXCLUDE_DISTRICT_FROM_EKHAJANA_PROCESS))
        {
            echo json_encode("E-Khajana Service is on Hold For This District. Will be resumed Soon");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no'); 
        // $data['updated_patta_count'] = $this->CoArrearUpdateModel->getUpdatedPattaArrearCount($dist_code,$subdiv_code, $cir_code);
        // $data['pending_count'] = $this->CoArrearUpdateModel->getPendingPattaArrearCount($dist_code,$subdiv_code, $cir_code);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_COUNT_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,'mouza_pargona_code' => $mouza_pargona_code,'lot_no' => $lot_no,
            'user_designation_code' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_count_tehsiladari_area'] = json_decode($response_obj->msg);
            }else{
                log_message("error", "#EKCRLLM0001, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_COUNT_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0001");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0002, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_COUNT_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0002");
        }

        //api for lot mondol count with bifurcation in mouzadari sytem
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_LOT_MONDOL_PENDING_LIST_COUNT_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,'mouza_pargona_code' => $mouza_pargona_code,'lot_no' => $lot_no,
            'user_designation_code' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_count_mouzadari_area'] = json_decode($response_obj->msg);
            }else{
                log_message("error", "#EKCRLLM0002, Curl Error(Y) In Api ".EKHAJANA_LOT_MONDOL_PENDING_LIST_COUNT_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0002");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0003, Curl Error(200) In Api ".EKHAJANA_LOT_MONDOL_PENDING_LIST_COUNT_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0003");
        }

        //pending count for dp estate
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_COUNT_DP_ESTATE_FOR_LM,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,
                                        'subdiv_code'=> $subdiv_code, 
                                        'cir_code'=> $cir_code,    
                                        'mouza_pargona_code'=> $mouza_pargona_code,    
                                        'lot_no'=> $lot_no,    
                                        'user_designation_code' => $this->session->userdata('user_desig_code')),
                                        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_count_dpEstate'] = $response_obj->msg;
            }else{
                log_message("error", "#EKCRLLMDP001, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_COUNT_DP_ESTATE_FOR_LM);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLMDP001");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLMDP0012, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_COUNT_DP_ESTATE_FOR_LM);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLMDP0012");
        }


        $data['_view'] = 'e_khajana/lm_views/index';
        $this->load->view('layouts/main',$data);
        
    }

    //pending-list
    public function pendingList(){

        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no'); 
        //echo $dist_code. "-".$subdiv_code. "-".$cir_code. "-".$mouza_pargona_code."-".$lot_no;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,'mouza_pargona_code' => $mouza_pargona_code,'lot_no' => $lot_no,
            'user_desig' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_list'] = $response_obj->msg;
                $data['_view'] = 'e_khajana/lm_views/pending_list';
                $this->load->view('layouts/main',$data);
            }else{
                log_message("error", "#EKCRLLM0003, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0003");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0004, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0004");
        }
        
    }    

    
    //pending case details from rtps ref no 
    public function pendingCaseDetails($ld_details_id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        //echo "rtps ref no is ".$rtps_ref_no;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_CASE_DETAILS_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ld_details_id' =>$ld_details_id,'user_designation_code' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            $data['pendingCaseLandDetails'] = $response_obj->land_details;
            $data['pendingCaseApplicantDetails'] = $response_obj->applicant_details;
            $data['pendingCaseDocumentDetails'] = $response_obj->document_details;
            $data['_view'] = 'e_khajana/lm_views/pending_case_details';
            $this->load->view('layouts/main',$data);
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0005, Curl Error(200) In Api ".EKHAJANA_PENDING_CASE_DETAILS_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0005");
        }
    }

    //displayig forwared to co cases list 
    public function forwardedToCoList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no'); 
        $data['_view'] = 'e_khajana/lm_views/forwardedToCoList';
        $this->load->view('layouts/main',$data);
    }

    //handling forwared to co 
    public function forwardedToCo_old(){
        $posted_ek_basic_details = $_POST;
        //to-do-validation 
        $ekBasicAddFlag = $this->EkhajanaLmModel->insertEkhajanaBasicDetails($posted_ek_basic_details);
        echo json_encode($ekBasicAddFlag);
    }
    
    public function forwardedToCo(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $posted_ek_basic_details = $_POST;
        $application_no = $_POST['application_no'];
        $ld_application_no = $_POST['ld_application_no'];
        $rtps_doc_id = $_POST['rtps_doc_id'];
        $tmp_name = $_FILES['fileUpload']['name'];
        // if($tmp_name== "" || $tmp_name == null){
        //     if($rtps_doc_id == null || $rtps_doc_id == ""){
        //         $searchAdditionalDocument = $this->EkhajanaLmModel->searchAdditionalDocument($application_no,$ld_application_no);
        //         if($searchAdditionalDocument == "NOT-FOUND"){
        //             echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'RTPS Document Not Found For this case, Kindly Self Upload citizens Last khajana Receipt from your end for further processing...!!!']);
        //             die();
        //         }
        //     }
        // }   
        //***********************validation***************************/
        if($_POST['pan_type'] != 'ORG')
        {
            if($_POST['guardian_name_eng'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In English Field Is Required']);
                die();
            }
            if($_POST['guardian_relation'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Relation Field Is Required']);
                die();
            }
            if($_POST['guardian_name_asm'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In Assamese  Field Is Required']);
                die();
            }
            
        }
        $error_msg = array();
        $lm_approve_form_val = [
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'is_urban',
                'label' => 'Is urban',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'patta_type',
                'label' => 'Patta Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[150]'
            ],
            [
                'field' => 'patta_type_code',
                'label' => 'Patta type code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[4]'
            ],
            [
                'field' => 'pdar_id',
                'label' => 'pdar id',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'pdar_name',
                'label' => 'pdar name',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            // [
            //     'field' => 'pdar_father_name',
            //     'label' => 'pdar father name',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'applicant_name_asm',
                'label' => 'applicant name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            // [
            //     'field' => 'guardian_name_eng',
            //     'label' => 'gurdian name in english',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_name_asm',
            //     'label' => 'gurdian name in assamese',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_relation',
            //     'label' => 'gurdian relation',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            // ],
            [
                'field' => 'date_of_birth',
                'label' => 'date of birth',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'mobile_no',
                'label' => 'mobile no',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[10]'
            ],
            // [
            //     'field' => 'rtps_doc_id',
            //     'label' => 'rtps document id',
            //     'rules' => 'required|callback_check_script|trim|xss_clean'
            // ],
            [
                'field' => 'lm_report',
                'label' => 'lm report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Aadhar Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
        ];
        $this->form_validation->set_rules($lm_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($lm_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        if($rtps_doc_id == null || $rtps_doc_id == ""){
            $this->form_validation->set_rules('fileText', 'Document Details', 'trim|xss_clean|required');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Rtps Document missing, please enter document name and upload additional document']);
                exit();
            }
            
            //additional file upload section
            
            // validation for file type and file size
            
            $name = $_FILES['fileUpload']['name'];
            $size = $_FILES['fileUpload']['size'];

            $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
            $exp  = explode("/",$mime);
            $ext  = $exp[1];

            if($name != NULL)
            {
                if($ext == NULL)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File extension not found']);
                    exit();
                }
                if(! in_array($ext, EKHAJANA_UPLOAD_TYPE_VALIDATION))
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File type not matched, Please upload only PDF Format files']);
                    exit();
                }
                if($size > EKHAJANA_UPLOAD_MAX_SIZE)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File size is too large to upload, Please Upload File of size less than 2MB']);
                    exit();
                }
            }
            else
            {
                log_message("error","#EKHFU001 Some error Occurred for application no ".$application_no);
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Please Upload additional Document since Rtps Document is not available for this case!!!']);
                exit();
            }
            
            // save file
            $_FILES['file']['name'] = $_FILES['fileUpload']['name'];
            $_FILES['file']['type'] = $_FILES['fileUpload']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['fileUpload']['error'];
            $_FILES['file']['size'] = $_FILES['fileUpload']['size'];

            $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];

            $fileRename =  'Ekhajana_AdditionalDoc_' .time(). '.' . $onlyExtension;

            $config['upload_path']   = UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA;
            $config['allowed_types'] = EKHAJANA_UPLOAD_ALLOW_TYPE;
            $config['max_size']  = EKHAJANA_UPLOAD_MAX_SIZE;
            $config['file_name'] = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $document= array(
                    'application_no'   => $_POST['application_no'],
                    'ld_application_no'   => $_POST['ld_application_no'],
                    'file_name' => $_POST['fileText'],
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $_FILES['file']['name'],
                    'file_type'  => $_FILES['file']['type'],
                    'file_path'  => UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA . $fileRename,
                    'document_name'  => "Khajana_receipt",
                    'created_at' => date('Y-m-d h:i:s'),
                );
                // save data in attachment file
                $tstatus1 = $this->db->insert('ekhajana_additional_document',$document);

                if ($tstatus1!= 1){
                    log_message("error","Could not insert into ekhajana additional document table for application no".$ld_application_no);
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Could not upload additional document please try again after refreshing the application!!!']);
                    exit();
                }

            }
            else
            {
                log_message("error","could not insert into ekhajana additional document  #EKHFU002");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Some Error Occured Please Try Again #EKHFU002!!!']);
                exit();
            }
            
        }
        
        $ekBasicAddFlag = $this->EkhajanaLmModel->insertEkhajanaBasicDetails($posted_ek_basic_details);
        echo json_encode($ekBasicAddFlag);
    }

    //to view receipt in lm end
    function document($doc){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, EKHAJANA_DOWNLOAD_DOCUMENT_API);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'name' => $doc
        )));
        $result = curl_exec($curl_handle);
        $result = json_decode($result);
        $output=$result->raw_data;
        $content_type=$result->mime_type;
        $check=explode("/",$content_type);
        if($check[1]=='pdf'){
            $output=base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        }else{
            echo '<img src="data:'.$content_type.';base64,'.$output.'" />';
        }
    }

    function testGrn(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://assamegras.gov.in/challan/models/frmgetgrn.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'DEPARTMENT_ID' => 'MB608191E49F51C579711B987',
                'OFFICE_CODE' => 'LRS318',
                'AMOUNT' => '94511.80',
                'ACTION_CODE' => 'GETGRN',
                'SUB_SYSTEM' => 'BASUNDHARA|http://localhost/rtpsDemo/LocalAPI/verifyPayment'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    //method for getting pending-list of mouzadari sytem for lot mondol
     public function LmPendingListformouzadarisystem(){

        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no'); 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_API_FOR_MOUZADARI_SYSTEM,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,'mouza_pargona_code' => $mouza_pargona_code,'lot_no' => $lot_no,
            'user_desig' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_list_mouzadari_system'] = $response_obj->msg;
                $data['_view'] = 'e_khajana/lm_views/pending_list_mouzadari_system';
                $this->load->view('layouts/main',$data);
            }else{
                log_message("error", "#EKCRLLM0003, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_API_FOR_MOUZADARI_SYSTEM);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0003");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0004, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_API_FOR_MOUZADARI_SYSTEM);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0004");
        }
        
    }

    //pending case details from rtps ref no 
    public function pendingCaseDetails_mouzadarisystem($ld_details_id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
       
        //**************************************************/
        //echo "rtps ref no is ".$rtps_ref_no;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_CASE_DETAILS_API_MOUZADRI_SYSTEM,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ld_details_id' =>$ld_details_id,'user_designation_code' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            $data['pendingCaseLandDetails'] = $response_obj->land_details;
            $data['pendingCaseApplicantDetails'] = $response_obj->applicant_details;
            $data['pendingCaseDocumentDetails'] = $response_obj->document_details;
            
            //for getting aadaar photo
            $rtps_application_no = $data['pendingCaseLandDetails']->application_no;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, EKHAJANA_AADHAAR_PHOTO_FETCH);

            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $rtps_application_no,

            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);

            if ($get_aadhaar_photo != 'n') {
                $data['aadhaar_b64_decoded'] = "<img src = data:".$this->imageDecodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                //$data['aadhaar_b64_decoded'] = "<img src = data:" . "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAACldJREFUeNrs3Wtv03YbwGEoZRyebRLivA22aYhNQki82vf/Apu2Fdi6lh62MppTW0jTloYkz/20kpenFJo4dg72db1AiIMLrn+9/3Yd53yv1zsHTM55EYIIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhMBsRLi1tbW6umpfM4vu379/8+bNXD/E/Bj+G+12u9ls+nQyi+LozftDzNnLMFkiBBGCCAERgggBEYIIARGCCAERgggBEYIIARGCCAERggiBnM1P+b9vbm7uzp07Pk+MolKpdDodEaaP8OHDhw4jRrG1tTXNEVqOgghBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYSACEGEgAhBhIAIQYRARubtgkEcHBy02+0LFy5cvXrV3kCE49Dr9ba3txuNRr1ef/v27f/tsvn5a9eu3bp1K36Mn9tXiDB7r169WltbO9Fe4t27d7UjMRjvHYmf2GmIMButVuv58+fx4yB/uNPpRKv//PPP999/f/36dXuPdFyY+VcsPn/++ecBC0wcHh4uLCz89ddfdiAiHEmlUomWUr+p8srKytLSkt2ICFN68+bN4uLiiBt5+fJlLE3tTEQ4tHa7/fTp0263O/qmlpeXo2e7FBEOJ07n4rwuk01FyS9evCjPrsvkKxdlj/Dg4CCWkRlu8PXr1/V6vSR7L86Em82mikQ4kjiLy/zL+d9//12GXbezsxNfv169eqUiEY6kWq1mvs04LYzzzGLvt06ns7i42Ov1KpVK6kvKiPB/35qP5Wjmm41Ds1arFXvXra6u7u/vH9cYHQpJhOnP33LacrHPlGK/9Z9IW5GKML08xuCx4ylRSHEK/ccff8S07/+K4xszIkzp3bt3OW25wOeEyUK0n2EoQsYkJt7Gxsb7vx6nhfl9RRNhkeX3EqSLFy+WYSHa/1suz4gwjStXruS05UuXLhVyIbq3t/eh33XfrAjT+PTTT3Pa8meffVaShWii1Wrld7VZhIUVqeS0brx27VpJFqKGoQhHcv78+Rs3bmS+2f8cKc9CNFGr1Qp/q5AIs/fVV19Fitlu8/79+6VaiPYPTJdnRJhmat29ezfb88xbt24VaSF6fI/ogH/eilSEaXz99ddZPbkwhup3332X+Wid7EJ0qIfuxKp1Z2fHQSXC4Vy6dOnRo0eZlPPtt98W6ZLM4AvRfu6eEWEaUc6DBw9G3Mjt27eLdDY47EI04fKMCFP68ssvf/jhh7m5lDvk3r178deLtEPW19eHffpjUu/m5qYjSoRp3Llz58mTJ5cvXx7qb8X5ZORXsFPBZrM5ypNUXZ4Z7hCyC/p9/vnnP/7448uXL2MOnHlHcozNu3fvfvPNNwW7U3TAb81/xP7+/vb2dsHuWBDhGNcGc3Oxtoy64jCqVqvx44kaY+LF4XX9+vUbN24U8h7R1AvRE8NQhCIcbb/Mz988cu7oCQ7J/SJR3SeffFLg//iIC9FEo9E4PDws9r4S4fhcuHCheDdk57QQ7d/U5uZmwW4eymvxZRdMp93d3fE/Wjdm4OgL0f4VaSY9i5AJiAXw0yPj7DCyz/a9pQ4ODuKM2mdThDNpfX09juCtra1nz56Np8PjhWjmH8v3KkQ4qwvR5GaxRqMxng5jBsbHzXyz8e//0BseI8LptbS01F9dHMfPnz/PtcPMF6KJOCd0K6kIZ0ys395/SES9Xs+vw5wWoomI0OUZEc6Mdru9urp66m/l12FOC9FELEfj5NYnV4SzYXl5+SOvP8ijw1arldNC9MR498kV4QyIVeiZz4aIDn///fesOoxVYq4L0URMwvzecUCEZHZitri4OMifrNVq0WEmZ1kxA8fzxjXxr/XiJhFOu42NjUEeZ5Z0GOvSETuMhej6+vrY/oPunhHhVNvf319bWxvqr4w4D8e2EE0cHh42Gg2faxFOqeXl5RQ9VKvV1B2ObSHar/8tDRHhFKlUKqlHRHSY4kUPY16IJnZ2dgr8to0inFWdTmdlZWXEhofqMP7k4uLi+F+fcc7dMyKcTi9evBj91sqhOtzY2Jjgu+pubm5OpH8Rcrrd3d2sJkN0OMjjCff29j50R854uDwjwilyfH0yw6v2MWQ+/p3G8V8RPZW7Z0Q4LWIGZn7HZnQYmU3nQjSxvb3t8owIJy/OA+NsMKeTrlPn4cQXooahCNPLY/22srLS6XTym7EnOpyShWj/VwqXZ0Q4xNop8we9NBqNvN/E70SHU7IQTbTb7Vqt5ugS4UBiCbe1tbWwsJBVh7Gd5eXl8Zxz/vnnn+eO7ombnoWoFempPHf0Y2PweIDET6LDx48fp367mMTa2trYLkscH+gTeXTimV6/fh2nqVevXnWYmYRnjMH+IH/77bcRj+Y47FK83d+IHU7VQtQwFGGaMZjY2dn59ddfR7mgMqn7xaZTnBjbGyIcdAz2L6JiHqbrMI6595/gVGbtdrtardoPIhx0DPZ3GPPwzHdNe/+AG8/1mNliRSrC4cZgIvqMeThUh7FB7yB96p7M8K0vRFiKMdh/9Aw+D2N4+pL/IV7pK8Khx2Ci2WxGh2fOt263u7S0ZK9+SJwW5nfzkAgLOwaH6nBjYyPXR+vOulhNuDwjwjRjMBGBfaTDg4ODiTxIYrZ4ub0IU47B/g5/+eWXUzuMhai11plin4//qVMiLMgYTLRarejw8PCw/xfr9bpXkRuGIsx9DPZ3GOvSpMMYgK7HDK5SqZR5ySDCUcfgiXl4/OCmtbU1b445uCgw75d3ibDgYzCxt7cX8zBWoWO+UbsAyvytVBFmMwb7O1xYWPC+C8Pa3d2d2hd8iHBmxiCGoQgnPwYZRbVaHfbOeBEag2Sp2+2W8/JM2SM0Bq1IRWgM8q9Wq1XClz6XOkJj0DAUoTHISbVarWwvgC5vhMbgdOp2u5ubmyI0Bpmkst3PXdIIjcFptre3F18lRWgMMkmlWpGWMUJjcPqV6vJM6SI0BmdCqS7PlC5CY3BWlOcbhuWK0BicIfv7+yW5PFOuCI1Bw1CExiBDqNfrJx6fJUJjkLHq9Xpl+MZ9WSI0BmdURFj4Z4WU5e2y4yz/iy++cEzPordv316+fFmEM0+BWI4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBGCCAERgggBEYIIgYmY9sdb9Hq9ZrPp88Qout2uCNPrdDo//fSTwwjLUUCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIZCx871ez14AEYIIARGCCAERgggBEYIIARGCCAERgggBEYIIARGCCAERgggBEYIIARGCCAERgggBEYIIARGCCAERgggBEYIIARHC7PqvAAMA/BkrMLAeft8AAAAASUVORK5CYII=" . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            
            }
            $data['arrear_by_mouzadar'] = $this->EkhajanaLmModel->fetchArrearByMouzadar($data['pendingCaseLandDetails']->dist_code, 
                                        $data['pendingCaseLandDetails']->subdiv_code, $data['pendingCaseLandDetails']->cir_code, $data['pendingCaseLandDetails']->mouza_pargona_code, 
                                        $data['pendingCaseLandDetails']->lot_no, $data['pendingCaseLandDetails']->vill_townprt_code, $data['pendingCaseLandDetails']->patta_type_code, $data['pendingCaseLandDetails']->patta_no);
        
            $data['current_doul_demand'] = $this->EkhajanaLmModel->getCurrentDoulDemand($data['pendingCaseLandDetails']->dist_code, 
                                    $data['pendingCaseLandDetails']->subdiv_code, $data['pendingCaseLandDetails']->cir_code, $data['pendingCaseLandDetails']->mouza_pargona_code, 
                                    $data['pendingCaseLandDetails']->lot_no, $data['pendingCaseLandDetails']->vill_townprt_code, $data['pendingCaseLandDetails']->patta_type_code, $data['pendingCaseLandDetails']->patta_no);
            ///////////////////////////////////////
            $data['_view'] = 'e_khajana/lm_views/pending_case_details_mouzadari';
            $this->load->view('layouts/main',$data);
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLM0005, Curl Error(200) In Api ".EKHAJANA_PENDING_CASE_DETAILS_API_MOUZADRI_SYSTEM);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLM0005");
        }
    }

    //function to forward a case to co in mouzadari system
    public function forwardedToCoForMouzadariSystem(){
        // echo "<pre>";
        // var_dump($_POST);
        // exit;
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //checking special characters in address field
        $string = $_POST['address'];
        $special_chars = EKHAJANA_REPLACE_SPECIAL_CHAR;
        $new_address = $string;
        foreach ($special_chars as $char) {
            $new_address = str_replace($char, '.', $new_address);
        }
        $_POST['address'] = $new_address;
        $posted_ek_basic_details = $_POST;
        $application_no = $_POST['application_no'];
        $ld_application_no = $_POST['ld_application_no'];
        $rtps_doc_id = $_POST['rtps_doc_id'];

        if(isset($_FILES['fileUpload']['name'])){
            $tmp_name = $_FILES['fileUpload']['name'];
        }else{
            $tmp_name = "";
        }
        // if($tmp_name== "" || $tmp_name == null){
        //     if($rtps_doc_id == null || $rtps_doc_id == ""){
        //         echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'RTPS Document Not Found For this case, Kindly Self Upload A Relevant Document From Your end For Further Processing...!!!']);
        //         die();
        //     }
        // }  

        if($_POST['pan_type'] != 'ORG')
        {
            if($_POST['guardian_name_eng'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In English Field Is Required']);
                die();
            }
            if($_POST['guardian_relation'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Relation Field Is Required']);
                die();
            }
            if($_POST['guardian_name_asm'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In Assamese  Field Is Required']);
                die();
            }
            
        }
        $error_msg = array();
        $lm_approve_form_val = [
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'is_urban',
                'label' => 'Is urban',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'patta_type',
                'label' => 'Patta Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[150]'
            ],
            [
                'field' => 'patta_type_code',
                'label' => 'Patta type code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[4]'
            ],
            [
                'field' => 'pdar_id',
                'label' => 'pdar id',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'pdar_name',
                'label' => 'pdar name',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            // [
            //     'field' => 'pdar_father_name',
            //     'label' => 'pdar father name',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'applicant_name_asm',
                'label' => 'applicant name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            // [
            //     'field' => 'guardian_name_eng',
            //     'label' => 'gurdian name in english',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_name_asm',
            //     'label' => 'gurdian name in assamese',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_relation',
            //     'label' => 'gurdian relation',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            // ],
            [
                'field' => 'date_of_birth',
                'label' => 'date of birth',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'mobile_no',
                'label' => 'mobile no',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[10]'
            ],
            // [
            //     'field' => 'rtps_doc_id',
            //     'label' => 'rtps document id',
            //     'rules' => 'required|callback_check_script|trim|xss_clean'
            // ],
            [
                'field' => 'lm_report',
                'label' => 'lm report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Aadhar Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
            [
                'field' => 'pattadar_identified',
                'label' => 'Pattadar Identified flag',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($lm_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($lm_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        if($tmp_name!= "" || $tmp_name != null){
            $this->form_validation->set_rules('fileText', 'Document Details', 'trim|xss_clean|required');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Kindly Enter The Name Of The Additional Document..!']);
                exit();
            }
            
            //additional file upload section
            // validation for file type and file size
            $name = $_FILES['fileUpload']['name'];
            $size = $_FILES['fileUpload']['size'];
            $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
            $exp  = explode("/",$mime);
            $ext  = $exp[1];
            if($name != NULL)
            {
                if($ext == NULL)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File extension not found']);
                    exit();
                }
                if(! in_array($ext, EKHAJANA_UPLOAD_TYPE_VALIDATION))
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File type not matched, Please upload only PDF Format files']);
                    exit();
                }
                if($size > EKHAJANA_UPLOAD_MAX_SIZE)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File size is too large to upload, Please Upload File of size less than 2MB']);
                    exit();
                }
            }
            else
            {
                log_message("error","#EKHFU001 Some error Occurred for application no ".$application_no);
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Please Upload additional Document since Rtps Document is not available for this case!!!']);
                exit();
            }
            // save file
            $_FILES['file']['name'] = $_FILES['fileUpload']['name'];
            $_FILES['file']['type'] = $_FILES['fileUpload']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['fileUpload']['error'];
            $_FILES['file']['size'] = $_FILES['fileUpload']['size'];

            $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];
            $fileRename =  'Ekhajana_AdditionalDoc_ByLm' .time(). '.' . $onlyExtension;
            $config['upload_path']   = UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA;
            $config['allowed_types'] = EKHAJANA_UPLOAD_ALLOW_TYPE;
            $config['max_size']  = EKHAJANA_UPLOAD_MAX_SIZE;
            $config['file_name'] = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                if(!file_exists(UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA . $fileRename)) {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Additional Document Uploading is not Successfull, Kindly Constact Admin..!!']);
                    exit;
                }
                $document= array(
                    'application_no'   => $_POST['application_no'],
                    'ld_application_no'   => $_POST['ld_application_no'],
                    'file_name' => $_POST['fileText'],
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $_FILES['file']['name'],
                    'file_type'  => $_FILES['file']['type'],
                    'file_path'  => UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA . $fileRename,
                    'document_name'  => "Additional Document",
                    'created_at' => date('Y-m-d h:i:s'),
                );
                // save data in attachment file
                $tstatus1 = $this->db->insert('ekhajana_additional_document',$document);

                if ($tstatus1!= 1){
                    log_message("error","Could not insert into ekhajana additional document table for application no".$ld_application_no);
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Could not upload additional document please try again after refreshing the application!!!']);
                    exit();
                }

            }
            else
            {
                log_message("error","could not insert into ekhajana additional document  #EKHFU002");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Some Error Occured Please Try Again #EKHFU002!!!']);
                exit();
            }
        }
        $ekBasicAddFlag = $this->EkhajanaLmModel->updateEkBasicForMouzadariSystem($posted_ek_basic_details);
        echo json_encode($ekBasicAddFlag);
    }

    //for aadhaar image decode
    public function imageDecodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        return $mime_type;
    }

      // ************************************DIRECT PAYING CODE STARTS ******************************

    //Getting pending list  in lm's end for dp estate
    public function LmPendingListforDpEstate()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no'); 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_FOR_LM_DP_ESTATE_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,
                                        'subdiv_code' => $subdiv_code,
                                        'cir_code' => $cir_code,
                                        'mouza_pargona_code' => $mouza_pargona_code,
                                        'lot_no' => $lot_no,
                                        'user_desig' => $this->session->userdata('user_desig_code')),
                                    ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_list_lm_dpEstate'] = $response_obj->msg;
                $data['_view'] = 'e_khajana/lm_views/pending_list_dpEstate';
                $this->load->view('layouts/main',$data);
            }else{
                log_message("error", "#EKCRLLMDP002, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_FOR_LM_DP_ESTATE_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLMDP002");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLMDP003, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_FOR_LM_DP_ESTATE_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLMDP003");
        }  
    }

    //getting pending list details in lm's end for dp estate
    public function pendingCaseDetailsDpEstate($land_details_id)
    {
        // var_dump($_POST);exit;
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_CASE_DETAILS_LM_FOR_DP_ESTATE_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ld_details_id' =>$land_details_id,
                                        'user_designation_code' => $this->session->userdata('user_desig_code')),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            $data['pendingCaseLandDetails'] = $response_obj->land_details;
            $data['pendingCaseApplicantDetails'] = $response_obj->applicant_details;
            $data['pendingCaseDocumentDetails'] = $response_obj->document_details;
            $data['_view'] = 'e_khajana/lm_views/pending_case_details_dpEstate';
            $this->load->view('layouts/main',$data);
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLLMDP004, Curl Error(200) In Api ".EKHAJANA_PENDING_CASE_DETAILS_LM_FOR_DP_ESTATE_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLLMDP004");
        }
    }

    //method to update data in dharitree when lm forwards a case
    public function forwardCaseByLmForDpEstate()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        error_reporting(0);

        if($_POST['pan_type'] != 'ORG')
        {
            if($_POST['guardian_name_eng'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In English Field Is Required']);
                die();
            }
            if($_POST['guardian_relation'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Relation Field Is Required']);
                die();
            }
            if($_POST['guardian_name_asm'] == null)
            {
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'The Guardian Name In Assamese  Field Is Required']);
                die();
            }
            
        }
        $error_msg = array();
        $lm_validation = [
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'is_urban',
                'label' => 'Is urban',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'patta_type',
                'label' => 'Patta Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[150]'
            ],
            [
                'field' => 'patta_type_code',
                'label' => 'Patta type code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[4]'
            ],
            [
                'field' => 'pdar_id',
                'label' => 'pdar id',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'pdar_name',
                'label' => 'pdar name',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'pdar_father_name',
                'label' => 'pdar father name',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'applicant_name_asm',
                'label' => 'applicant name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            // [
            //     'field' => 'guardian_name_eng',
            //     'label' => 'gurdian name in english',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_name_asm',
            //     'label' => 'gurdian name in assamese',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_relation',
            //     'label' => 'gurdian relation',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            // ],
            [
                'field' => 'date_of_birth',
                'label' => 'date of birth',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'mobile_no',
                'label' => 'mobile no',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[10]'
            ],
            // [
            //     'field' => 'rtps_doc_id',
            //     'label' => 'rtps document id',
            //     'rules' => 'required|callback_check_script|trim|xss_clean'
            // ],
            [
                'field' => 'lm_report',
                'label' => 'Lm report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Aadhar Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
        ];
        $this->form_validation->set_rules($lm_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($lm_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $posted_data = $_POST;
        $ekBasicAddFlag = $this->EkhajanaLmModel->updateEkhajanaBasicDpEstate($posted_data);
        echo json_encode($ekBasicAddFlag);
    }

}