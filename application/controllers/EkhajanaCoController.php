<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaCoController extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->model('eKhajana/Common/EkhajanaHelperModel');
        $this->load->library('AES');
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
        if($this->session->userdata('user_desig_code') != "CO"){
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
        //echo "Ekhajana Co COntroller <br>Dist-Code : ".$dist_code."<br>Subdiv-Code : ".$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['pendingCount'] = $this->EkhajanaCoModel->pendingForCoCount($dist_code,$subdiv_code,$cir_code);
        $data['pendingCountMouzadari'] = $this->EkhajanaCoModel->pendingForCoCountMouzadari($dist_code,$subdiv_code,$cir_code);
        $data['mouzadarObjectionCount'] = $this->EkhajanaCoModel->mouzadarObjectionForCoCount($dist_code,$subdiv_code,$cir_code);//mouzadari sytem
        $data['revertedCount'] = $this->EkhajanaCoModel->revertedForCoCount($dist_code,$subdiv_code,$cir_code);
        $data['pendingCountDpEstate'] = $this->EkhajanaCoModel->pendingForCoCountDpEstate($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/index';
        $this->load->view('layouts/main',$data);
    }

    //displaying pending list in co 
    public function pendingList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        // echo "Ekhajana Co COntroller (Pending List Method)<br>Dist-Code : ".$dist_code."<br>Subdiv-Code : ".$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['pendingList'] = $this->EkhajanaCoModel->pendingListForCo($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/pending_list';
        $this->load->view('layouts/main',$data);
    }

    //pending case details
    public function pendingCaseDetails($id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaCoModel->getPendingCaseDetailsFromId($id);
        $data['jama_wasil_status'] = $this->EkhajanaCoModel->getJamaWasilDetails($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        //check if additional document is available
        $ld_application_no = $caseDetails->ld_application_no;
        $data['additional_doc'] = $this->EkhajanaCoModel->checkAdditonalDocument($ld_application_no);
        $data['_view'] = 'e_khajana/co_views/pending_case_details';
        $this->load->view('layouts/main',$data);        
    }

    //forward to assistant handle
    public function forwardToAssistant(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $posted_data = $_POST;
        $error_msg = array();
        $co_approve_form_val = [
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
                'field' => 'case_no',
                'label' => 'case number',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[5]|'
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
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'pdar_father_name',
                'label' => 'pdar father name',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
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
            [
                'field' => 'rtps_doc_id',
                'label' => 'rtps document id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'lm_report',
                'label' => 'lm report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'co_report',
                'label' => 'co report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Addhar/Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
        ];
        $this->form_validation->set_rules($co_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($co_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        
        $dist_code= $_POST['dist_code'];
        $subdiv_code= $_POST['subdiv_code'];
        $cir_code= $_POST['cir_code'];
        $mouza_pargona_code= $_POST['mouza_pargona_code'];
        $lot_no= $_POST['lot_no'];
        $vill_townprt_code= $_POST['vill_townprt_code'];
        $patta_type_code= $_POST['patta_type_code'];
        $patta_no= $_POST['patta_no'];

        $doulStatus = $this->EkhajanaCoModel->checkDoulStatusBeforeForward($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);        
        if(!$doulStatus['result']){
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => $doulStatus['msg']]);
            exit;
        }
        $forwardedFlag = $this->EkhajanaCoModel->forwardToAssistant($posted_data);
        echo json_encode($forwardedFlag);
    }

    //approve list of ekhajana cases 
    public function approvedList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        // echo "Ekhajana Co COntroller (Approved List Method)<br>Dist-Code : ".$dist_code."<br>Subdiv-Code : ".$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['_view'] = 'e_khajana/co_views/approved_list';
        $this->load->view('layouts/main',$data);
    }

    //case reject handle
    public function rejectCase_old(){
        $posted_data = $_POST;
        $error_msg = array();
        $co_approve_form_val = [
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
                'field' => 'case_no',
                'label' => 'case number',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean|max_length[2]|'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[5]|'
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
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'pdar_father_name',
                'label' => 'pdar father name',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'applicant_name_asm',
                'label' => 'applicant name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'guardian_name_eng',
                'label' => 'gurdian name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'guardian_name_asm',
                'label' => 'gurdian name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'guardian_relation',
                'label' => 'gurdian relation',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
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
            [
                'field' => 'rtps_doc_id',
                'label' => 'rtps document id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'lm_report',
                'label' => 'lm report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'co_report',
                'label' => 'co report',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Addhar/Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ek_details_id',
                'label' => 'ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            
        ];
        $this->form_validation->set_rules($co_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($co_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $rejectedFlag = $this->EkhajanaCoModel->rejectCase_old($posted_data);
        echo json_encode($rejectedFlag);
    }

    //to view receipt in lm end
    function document(){
        $curl_handle = curl_init();
        $ld_application_no = $_GET['appl_no'];
        curl_setopt($curl_handle, CURLOPT_URL, EKHAJANA_DOWNLOAD_DOCUMENT_API_FOR_CO);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'ld_application_no' => $ld_application_no
        )));
        $result = curl_exec($curl_handle);
        $result = json_decode($result);
        if($result == null)
        {
            echo "Last Revenue Receipt was not uploaded by Citizen, Since it is not mandatory since '30-10-2024'";
            exit;
        }
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

    //case reject with category
    public function rejectCase(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }

        //***********************validation-starts*****************/
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');
        $validation = [
            [
                'field' => 'ek_details_id',
                'label' => 'ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
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
                'field' => 'case_no',
                'label' => 'case number',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'reject_code',
                'label' => 'Reject Reason(Atleast-One)',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason(Other)',
                'rules' => 'trim|callback_check_script|xss_clean',
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters entered in %s field');
        if ($this->form_validation->run('validation') == FALSE) {
            foreach ($validation as $rule) {
                if (form_error($rule['field'])) {
                    $message .= form_error($rule['field']);
                }
            }
            $json = [
                'result' => 'VALIDATION-ERROR',
                'msg' => $message,
            ];
            echo json_encode($json);
            return;
        }

        if ($this->form_validation->run() == FALSE)
        {               
            foreach($validation as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************validation-end*****************/
        
        $posted_data = $_POST;
        $rejectedFlag = $this->EkhajanaCoModel->rejectCase($posted_data);
        echo json_encode($rejectedFlag);
    }

    //displaying reverted list for co 
    public function revertedList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        // echo "Ekhajana Co COntroller (Pending List Method)<br>Dist-Code : ".$dist_code."<br>Subdiv-Code : ".$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['revertedList'] = $this->EkhajanaCoModel->revertedListForCo($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/reverted_list';
        $this->load->view('layouts/main',$data);
    }

    //arrear reupdate data show function
    public function arrearReUpdateList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['JamaWasilOffline'] = $this->EkhajanaCoModel->JamaWasilOfflineData($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/arrearReUpdateList';
        $this->load->view('layouts/main',$data);

    }

    //arrear re update form
    public function arrearReUpdateForm($jama_wasil_id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
            //getting current revenue and local tax
            $data['JamaWasilData'] = $jamaWasilDetails = $this->EkhajanaCoModel->getjamaWasilDetailsFromId($jama_wasil_id);
            if(!$jamaWasilDetails){
                echo json_encode("Some Error Occured, Error Code : EKABNA0001");
                exit;
            }
            $data['current_revenue'] = $jamaWasilDetails->revenue;
            $data['current_local_tax'] = $jamaWasilDetails->local_tax;
            $data['current_doul_year'] = $jamaWasilDetails->dol_year_no;
            $data['_view'] = 'e_khajana/co_views/co_reupdate_arrear_form';
            $this->load->view('layouts/main',$data);
    }
        
    //function to update the re arrear form
    public function ReUpdateArrearSubmit(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //*****************validation*************/
        $error_msg = array();
        $arrear_update_form_val = [
        [
            'field' => 'application_no',
            'label' => 'Application No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'ld_application_no',
            'label' => 'Land Details Application No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'case_no',
            'label' => 'CAse No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'current_doul_year',
            'label' => 'current dol Year',
            'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[4]'
        ],
        [
            'field' => 'jama_wasil_id',
            'label' => 'ID',
            'rules' => 'required|callback_check_script|integer|trim|xss_clean'
        ],
        [
            'field' => 'openinig_balance',
            'label' => 'Opening Balance',
            'rules' => 'required|callback_check_script|numeric|trim|xss_clean'
        ],
        [
            'field' => 'current_revenue',
            'label' => 'Current Revenue',
            'rules' => 'required|callback_check_script|numeric|trim|xss_clean'
        ],
        [
            'field' => 'current_local_tax',
            'label' => 'Current Local Tax',
            'rules' => 'required|callback_check_script|numeric|trim|xss_clean'
        ],
        [
            'field' => 'last_pay_date',
            'label' => 'Last Pay Date',
            'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
        ],
        [
            'field' => 'last_revenue_payment_amount',
            'label' => 'Last Revenue Payment Amount',
            'rules' => 'required|callback_check_script|numeric|trim|xss_clean'
        ],
        [
            'field' => 'last_local_tax_payment_amount',
            'label' => 'Last Local Tax Payment Amount',
            'rules' => 'required|callback_check_script|numeric|trim|xss_clean'
        ],
        [
            'field' => 'due_payment_frontend',
            'label' => 'Due payment',
            'rules' => 'required|trim|xss_clean'
        ],
            
        ];
        $this->form_validation->set_rules($arrear_update_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($arrear_update_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        
        $due_payment = $_POST['current_revenue'] + $_POST['current_local_tax'] + $_POST['openinig_balance'];
        // var_dump($due_payment);
        // echo '**************';
        // var_dump((float)$_POST['due_payment_frontend']);
        // exit;
        if($due_payment != (float)$_POST['due_payment_frontend']){
            echo json_encode("Some Error Occured, Error Code : EKHGDPD001");
            exit;
        }
        //getting jama wasil details from id 
        $jama_wasil_details = $this->EkhajanaCoModel->getjamaWasilDetailsFromId($_POST['jama_wasil_id']);
        if(!$jama_wasil_details){
            echo json_encode("Some Error Occured, Error Code : EKHGJWD002");
            exit;
        }
        //recheck posted case no and jama wasil details case no
        if($jama_wasil_details->case_no != $_POST['case_no']){
            echo json_encode("Some Error Occured, Error Code : EKHGJWD003");
            exit;
        }
        //jama_wasil_table_data_array
        $jama_wasil_update_data = [
            "revenue" => $_POST['current_revenue'],
            "local_tax" => $_POST['current_local_tax'],
            "opening_balance" => $_POST['openinig_balance'],
            "due_payment" => $_POST['current_revenue'] + $_POST['current_local_tax'] + $_POST['openinig_balance'],
            "last_revenue_payment_amount" => $_POST['last_revenue_payment_amount'], 
            "last_local_tax_payment_amount" => $_POST['last_local_tax_payment_amount'], 
            "modified_at" => date('Y-m-d h:i:s')
        ];
        //jama_wasil_backup_data
        $jama_wasil_backup_table_update_data = [
            "data" => json_encode($_POST),
            "action" => JAMA_WASIL_ACTION_CO_ENTRY_REUPDATE,
            'user_data' => json_encode($this->session->all_userdata()),
            'ip_address' => $this->session->all_userdata()['ip_address'],
            "created_at"=> date('Y-m-d h:i:s'),
            "application_no" => $_POST['application_no'],
            "ld_application_no" => $_POST['ld_application_no'],
            "case_no" => $_POST['case_no']
        ];

        $grasResponseflag = $this->EkhajanaCoModel->checkPaymentQuerybeforeUpdate($_POST['application_no']);
        if($grasResponseflag != 'Y'){
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Payment already processed for this case ..!!,error:#EKHGJWD003']);
            log_message("error", "#EKHGJWD003, Error in fetching data from rtps side");
            exit;
        }
        //**************update and insert queries********/
        $updateflag = $this->EkhajanaCoModel->arrearReUpdate($jama_wasil_update_data,
        $jama_wasil_backup_table_update_data,$jama_wasil_details);
        echo json_encode($updateflag);
    }

    //function to chck the payment reponse from rtps
    public function checkPaymentQuerybeforeUpdate(){
        $case_no = $_GET['case_no'];
        $input_array=json_encode(array("app_ref_no" => $case_no));
        echo '********input array****<br>';
        echo $input_array;
        $aes = new AES($input_array, ENCRYPTION_KEY);
        $enc = $aes->encrypt();
        $str = '{"data":"'.$enc.'"}';
        echo '******** $str****<br>';
        echo $str; 
        // request from rtps
        $curl_handle = curl_init();
        $url = FETCH_PAYMENT_STATUS_API_LINK;
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  FALSE);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $str);
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        echo $httpcode;
        if($httpcode == 200){
            echo '********result****<br>';
            echo $result;
            echo "************Result-After-Decrypt**********************<br>";
            $resultObj = json_decode($result);
            echo "<pre>";
            var_dump($resultObj);
            echo "</pre>";
            echo "*************Data-After-Decrypt*********************<br>";
            $data = $resultObj->data;
            $aes = new AES($data, ENCRYPTION_KEY);
            $responseStr = $aes->decrypt();
            $responseObj = json_decode($responseStr, true);
            echo "<pre>";
            var_dump($responseObj);
            echo "</pre>";
            echo "**********************************************************";
        }
        else
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCRLCPBU001, Curl Error(200) In Api ".FETCH_PAYMENT_STATUS_API_LINK);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCRLCPBU001'];
        }  
    }

    //displaying pending list in co 
    public function pendingListMouzadari(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['pendingListForCoMouzadari'] = $this->EkhajanaCoModel->pendingListForCoMouzadari($dist_code,$subdiv_code,$cir_code);
        // echo "<pre>";
        // var_dump($data['pendingListForCoMouzadari']);
        // echo "</pre>";
        // exit;        
        $data['_view'] = 'e_khajana/co_views/pendinglistMouzadariArea';
        $this->load->view('layouts/main',$data);
    }

    //pending case details in co end for mouzadari system
    public function pendingCaseDetailsMouzadari($id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaCoModel->getPendingCaseDetailsFromId($id); 
        //*************************************/
        $year_wise_arrear_details = $this->EkhajanaHelperModel->getYearWiseArrearDetails($caseDetails->dist_code,
                            $caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code, 
                            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code,
                            $caseDetails->patta_no);
        if(count($year_wise_arrear_details) == 0){  
            echo json_encode("Year Wise Arrear Not Found For The Application, Kindly Contact Admin, Err-Code: #ERREPRNF001");        
            exit;
        }
        //*************************************/
        $data['dp_flag_status'] = $this->EkhajanaCoModel->getDPFlaggingStatus($caseDetails->dist_code,
                                $caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,
                                $caseDetails->lot_no, $caseDetails->vill_townprt_code,$caseDetails->patta_type_code,
                                $caseDetails->patta_no);
        if(!$data['dp_flag_status']){
            echo json_encode("SOME ERROR OCCURED, PLEASE CONTACT ADMIN, ERR-CODE: #EKHDPFLG001");
            exit;
        }      
        $data['jama_wasil_status'] = $this->EkhajanaCoModel->getJamaWasilDetails($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);

        $data['arrear_by_mouzadar'] = $this->EkhajanaCoModel->fetchArrearByMouzadar($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        $data['current_doul_demand'] = $this->EkhajanaCoModel->getCurrentDoulDemand($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        $data['additional_doc_by_mou'] = $this->EkhajanaCoModel->checkAdditonalDocumentByMouzadar($caseDetails->ld_application_no);
        $data['additional_doc_by_lm'] = $this->EkhajanaCoModel->checkAdditonalDocumentByLm($caseDetails->ld_application_no);
        $data['proceedingDetails'] =  $this->EkhajanaCoModel->getmouzadarObjectionProceedingDetails($caseDetails);
        $data['eCFRStatus'] = $this->EkhajanaCoModel->getEcfrGeneratedStatus($caseDetails);
        $data['_view'] = 'e_khajana/co_views/pendingCaseDetailsMouzadariArea';
        $this->load->view('layouts/main',$data);        
    }

    //co dispose the case in mouzadari system 1st flow
    public function COdisposeCase(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        // var_dump($_POST);
        // exit;
        $posted_data = $_POST;
        $error_msg = array();
        $arrear_update_form_val = [
        [
            'field' => 'application_no',
            'label' => 'Application No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'ld_application_no',
            'label' => 'Land Details Application No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'case_no',
            'label' => 'Case No',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'dist_code',
            'label' => 'Dist Code',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'subdiv_code',
            'label' => 'Subdiv Code',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'cir_code',
            'label' => 'Circle Code',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'mouza_pargona_code',
            'label' => 'Mouza Pargona Code',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'lot_no',
            'label' => 'Lot Number',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'vill_townprt_code',
            'label' => 'Village Townport Code',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'is_urban',
            'label' => 'Is Urban',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'patta_type',
            'label' => 'Patta Type',
            'rules' => 'required|callback_check_script|trim|xss_clean'
        ],
        [
            'field' => 'patta_type_code',
            'label' => 'Patta Type Code',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'pdar_id',
            'label' => 'Pdar ID',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'pdar_name',
            'label' => 'Pdar Name',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'pdar_father_name',
            'label' => 'Pdar Father name',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'patta_no',
            'label' => 'Patta Number',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'applicant_name_eng',
            'label' => 'Appliacnt name in English',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'applicant_name_asm',
            'label' => 'Applicant Name in Assamese',
            'rules' => 'required|trim|xss_clean'
        ],
        // [
        //     'field' => 'guardian_name_eng',
        //     'label' => 'Guardian Name in English',
        //     'rules' => 'required|trim|xss_clean'
        // ],
        // [
        //     'field' => 'guardian_name_asm',
        //     'label' => 'Guardian Name in Assamese',
        //     'rules' => 'required|trim|xss_clean'
        // ],
        // [
        //     'field' => 'guardian_relation',
        //     'label' => 'Guardian Relation',
        //     'rules' => 'required|trim|xss_clean'
        // ],
        [
            'field' => 'date_of_birth',
            'label' => 'Date of Birth',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'mobile_no',
            'label' => 'Mobile number',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'aadhaar_pan_ref_no',
            'label' => 'AAdhaar pan reff number',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'aadhaar_pan_type',
            'label' => 'AAdhaar Pan Type',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'ek_details_id',
            'label' => 'Ek basic Id',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'pattadar_identification_flag',
            'label' => 'Mouzadar Pattadar Identification Field',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'lm_pattadar_identification_flag',
            'label' => 'LM Pattadar Identification flag',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'lm_report',
            'label' => 'LM Report',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'mou_report',
            'label' => 'Mouzadar Report',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'co_pattadar_identification_flag',
            'label' => 'CO Pattadar Identification',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'co_report',
            'label' => 'Co Report',
            'rules' => 'required|trim|xss_clean'
        ],
            
        ];
        $this->form_validation->set_rules($arrear_update_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($arrear_update_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }

        $jamawasil_status = $this->EkhajanaCoModel->getJamaWasil($posted_data);
        if(!$jamawasil_status){
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0081']);
            exit;
        }
        // update pattadar mobile number in chitha_pattadar
        if (isset($_POST['ekh_mobile_no']) && $_POST['ekh_mobile_no'] !== null && $_POST['ekh_mobile_no'] !== '')
        {
            $update_pdar_mobile = $this->EkhajanaCoModel->updatePdarMobileNo($_POST['dist_code'],$_POST['subdiv_code'],$_POST['cir_code'],$_POST['mouza_pargona_code'],$_POST['lot_no'],
                            $_POST['vill_townprt_code'],$_POST['patta_type_code'],$_POST['patta_no'],$_POST['pdar_id'],$_POST['ekh_mobile_no']);
            if($update_pdar_mobile['result'] == 'SERVER-ERROR')
            {
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => $update_pdar_mobile['msg']]);
                exit; 
            }
        }

        //checks after revenue year change
        if (date('Y-m-d') >= EKHAJANA_NEW_REVENUE_YEAR_START_DATE) {
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'e-Khazana case processing has been temporarily restricted as the Doul for the revenue year 2025–2026 is yet to be approved. Processing will resume once the Doul is approved.']);
            exit;
            $doul_approval_status = null;
            //checkDoulApproval 2025
            $check_doul_approval_query = $this->db->query("select * from current_doul_approve where dist_code=? and subdiv_code=? and cir_code=? and yeardoul=? ",array($_POST['dist_code'], $_POST['subdiv_code'],$_POST['cir_code'],doul_year_no));
            if($check_doul_approval_query->num_rows() == 0)
            {
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Doul For The Current Revenue Year Has Not Been Generated,Kindly genrated The Doul before Disposing  Application..!!']);
                exit;
            }else{
                $doul_approval_status = $check_doul_approval_query->row()->status;
            }
            if($doul_approval_status == 'A')
            {   
                $dhar_db = $this->db;
                $dhar_db->trans_begin();
                //check if 26 nos of pre arrear rows are present before disposing the application
                $ekh_year_wise_arr_query = $dhar_db->query("select * from ekhajana_year_wise_arrear where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and year_arrear is not null order by revenue_year desc", array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']));

                $ekh_year_wise_arr_count = $ekh_year_wise_arr_query->num_rows(); 
                $last_row = $ekh_year_wise_arr_query->result()[0]->revenue_year;
                $year = doul_year_no;
                $old_year = ($year-1);
                $current_demand_archive = 'current_doul_demand_'.$old_year;
                if($last_row =='2024' && $ekh_year_wise_arr_count =='25'){
                    $archive_doul_query = $dhar_db->query("select * from $current_demand_archive where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                    and lot_no =? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']));
                    if($archive_doul_query->num_rows() == 0)
                    {
                        log_message("error","#ERRARCDNF001 archive doul demand not found for the patta with last query".json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => '#ERRARCDNF001 Some Error Occurred Please contact System Admin..']);
                        exit;
                    }
                    $archive_doul =  $archive_doul_query->row();
                    $ekhajana_arrear_pre_updation_table_row = $dhar_db->query("select * from ekhajana_arrear_pre_updation where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code =?
                                    and lot_no =? and vill_townprt_code=? and patta_type_code =? and patta_no =? ",array($_POST['dist_code'],$_POST['subdiv_code'],$_POST['cir_code'],$_POST['mouza_pargona_code'],
                                    $_POST['lot_no'],$_POST['vill_townprt_code'],$_POST['patta_type_code'],$_POST['patta_no']))->row();
                    
                    $pre_arrear_revenue =  $archive_doul->dag_revenue + $ekhajana_arrear_pre_updation_table_row->revenue;
                    $pre_arrear_tax     =  $archive_doul->dag_local_tax + $ekhajana_arrear_pre_updation_table_row->tax;
                    $pre_arrear_arrear  =  $archive_doul->dag_local_tax + $archive_doul->dag_revenue + $ekhajana_arrear_pre_updation_table_row->arrear;
                    $pre_arrear_id      =  $ekhajana_arrear_pre_updation_table_row->id;
                    $application_under  =  $ekhajana_arrear_pre_updation_table_row->application_under;

                    $update_pre_arrear= array(
                        'revenue'           => $pre_arrear_revenue,
                        'tax'               => $pre_arrear_tax,
                        'arrear'            => $pre_arrear_arrear,
                        'application_under' => $application_under,
                        'modified_at'       => date('Y-m-d h:i:s'),
                    );
                    $dhar_db->where('id', $pre_arrear_id);
                    $dhar_db->update('ekhajana_arrear_pre_updation', $update_pre_arrear);    
                    if($dhar_db->affected_rows() != 1){ 
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in update, table 'ekhajana_arrear_pre_updation'  with query- ". ($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012']);
                        exit;
                    }

                    //inserting into  in pre arrear table year wise table
                    $year_wise_arrear= array(
                            'pre_arrear_id'         => $pre_arrear_id,
                            'dist_code'             => $_POST['dist_code'],
                            'subdiv_code'           => $_POST['subdiv_code'],
                            'cir_code'              => $_POST['cir_code'],            
                            'mouza_pargona_code'    => $_POST['mouza_pargona_code'],
                            "lot_no"                => $_POST['lot_no'],
                            "vill_townprt_code"     => $_POST['vill_townprt_code'],
                            'village_uuid'          => $ekhajana_arrear_pre_updation_table_row->village_uuid,
                            'patta_type_code'       => $_POST['patta_type_code'],
                            'patta_no'              => $_POST['patta_no'],
                            'total_arrear'          => $pre_arrear_arrear,
                            'total_revenue'         => $pre_arrear_revenue,
                            'total_tax'             => $pre_arrear_tax,
                            'user_code'             => $this->session->all_userdata()['user_code'],
                            'financial_year'        => ekhajana_previous_financial_year,
                            'year_arrear'           => $archive_doul->dag_revenue + $archive_doul->dag_local_tax,
                            'year_revenue'          => $archive_doul->dag_revenue,
                            'year_tax'              => $archive_doul->dag_local_tax,
                            "created_at"            => date('Y-m-d h:i:s'),
                            'modified_at'           => null,
                            "status"                => PORT_DOUL_PRE_ARREAR_UPDATE_STATUS,
                            "revenue_year"          => $archive_doul->year_no,
                            'application_under'     => $application_under,
                            'modified_at'           => date('Y-m-d h:i:s'),
                        );
                    $tstatus38 = $dhar_db->insert('ekhajana_year_wise_arrear', $year_wise_arrear);
                    if ($tstatus38 != 1)
                    {
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in insert on ekhajana_year_wise_arrear table with query- ". json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012']);
                        exit;
                    }

                    $update_year_wise =array(
                        'total_arrear'          => $pre_arrear_arrear,
                        'total_revenue'         => $pre_arrear_revenue,
                        'total_tax'             => $pre_arrear_tax,
                    );
                    $dhar_db->where('pre_arrear_id', $pre_arrear_id);
                    $dhar_db->update('ekhajana_year_wise_arrear', $update_year_wise);    
                    if($dhar_db->affected_rows() != 26){ 
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR001845, Error in update, table 'ekhajana_year_wise_arrear'  with query- ". json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR001845']);
                        exit;
                    }

                } 
                $count_pre_year_wise = $dhar_db->query("select count(*) as count from ekhajana_year_wise_arrear where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and year_arrear is not null ", array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']))->row()->count;
                if($count_pre_year_wise != 26){
                    log_message("error", "EKHMOUYEARWARRNF,ekhajana_year_wise_arrear not found to be 26 count for ". $_POST['ld_application_no']);
                    echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Arrear for the Previous revenue year has not been entered by concerned Mouzadar, Kindly ask to re-enter the arrear data again..']);
                    exit;
                }else{
                    $dhar_db->trans_commit();
                }
            }else{
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Doul For The Current Revenue Year Has Not Been Approved From DC, Hence application cannot be forwarded..!!']);
                exit;
            }

        }
      
        if($jamawasil_status == 'paid_in_jama_wasil'){
            //no updation in jamawasil
            $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails,$posted_data);
            if($aadhar_link_flag['result'] == false){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0085']);
                exit;
            }
            $updateData = $this->EkhajanaCoModel->COdisposeCaseMouzadariSystemWithoutInsert($posted_data,$ekBasicDetails);
            echo json_encode($updateData);
        }elseif($jamawasil_status == 'jama_wasil_not_exists'){
           
            $PreArrearData = $this->EkhajanaCoModel->getEkhajanaPreArrearDetails($posted_data);
            if(!$PreArrearData){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0081']);
                exit;
            }
            $ArrearData = $this->EkhajanaCoModel->getEkhajanaMouzadarArrearDetailsNew($posted_data);
            $currentDoulDemand = $this->EkhajanaCoModel->getCurrentDoulDetails($ArrearData); 
            if(!$currentDoulDemand['flag']){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Current Doul Demand Not Found For This Patta..!!']);
                exit;
            }
            $current_revenue = $currentDoulDemand['result']->dag_revenue;
            $current_local_tax = $currentDoulDemand['result']->dag_local_tax;
            $current_doul_year = $currentDoulDemand['result']->year_no;
            //getting ek basic details from ld_application_no
            $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            if(!$ekBasicDetails){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0082']);
                exit;
            }
            
            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails,$posted_data);
            if($aadhar_link_flag['result'] == false){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0083']);
                exit;
            }
            //financial_year
            if (date('m') <= 6) {
                $financial_year = (date('Y')-1) . '-' . date('Y');
            } else {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            }
            $financial_year = ekhajana_financial_year;
            //if payment is done by self
            if($ArrearData->payment_by == "self"){
                $_POST['payee_name'] = null;
                $_POST['payee_relation'] = null;
                $_POST['payee_contact_no'] = null;
                $_POST['payee_email'] = null;
            }
            //jama_wasil_table_data_array
            $jama_wasil_data = [
                "dist_code" => $PreArrearData->dist_code,
                "subdiv_code" => $PreArrearData->subdiv_code,
                "cir_code" => $PreArrearData->cir_code,
                "mouza_pargona_code" => $PreArrearData->mouza_pargona_code,
                "lot_no" => $PreArrearData->lot_no,
                "vill_townprt_code" => $PreArrearData->vill_townprt_code,
                "village_uuid" => $PreArrearData->village_uuid,
                "patta_type_code" => $PreArrearData->patta_type_code,
                "patta_no" =>  $PreArrearData->patta_no,
                "dag_no" => "", 
                "financial_year" => $financial_year,
                "entry_year" =>  date('Y'),
                "entry_date" => date('Y-m-d'),
                "revenue" => $current_revenue,
                "local_tax" => $current_local_tax,
                "opening_balance" => $PreArrearData->arrear,
                "due_payment" => $current_revenue + $current_local_tax + $PreArrearData->arrear,
                "other_payment" => null,
                "last_revenue_payment_amount" => $ArrearData->last_revenue_payment, 
                "last_local_tax_payment_amount" => $ArrearData->last_local_tax_payment,
                "dol_year_no" => $current_doul_year,
                "pdar_id" => $ekBasicDetails->pdar_id, 
                "pdar_name" =>  $ekBasicDetails->pdar_name,
                "pdar_father_name" => $ekBasicDetails->pdar_father_name,
                "status" => JAMA_WASIL_STATUS_OFFLINE, 
                "created_at" => date('Y-m-d h:i:s'),
                "modified_at" => null,
                'user_code' => $this->session->all_userdata()['user_code'],
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no,
                "pay_status" => JAMA_WASIL_STATUS_UNPAID
            ];

            //jama_wasil_payee_list_data
            $jama_wasil_payee_list_data = [
                "dist_code" => $PreArrearData->dist_code,
                "subdiv_code" => $PreArrearData->subdiv_code,
                "cir_code" => $PreArrearData->cir_code,
                "mouza_pargona_code" => $PreArrearData->mouza_pargona_code,
                "lot_no" => $PreArrearData->lot_no,
                "vill_townprt_code" => $PreArrearData->vill_townprt_code,
                "village_uuid" => $PreArrearData->village_uuid,
                "patta_type_code" => $PreArrearData->patta_type_code,
                "patta_no" =>  $PreArrearData->patta_no,
                "dag_no"=> "",
                "pdar_id"=> $ekBasicDetails->pdar_id, 
                "pdar_name"=> $ekBasicDetails->pdar_name,
                "pdar_father_name"=> $ekBasicDetails->pdar_father_name,
                "payment_by"=> $ArrearData->payment_by,
                "payee_name"=> $_POST['payee_name'],
                "payee_contant_no"=> $_POST['payee_contact_no'],
                "payee_relation"=>$_POST['payee_relation'],
                "payee_email"=>$_POST['payee_email'],
                "created_at"=> date('Y-m-d h:i:s'),
                "modified_at"=> null,
                'user_code' => $this->session->all_userdata()['user_code'],
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no
            ];
            //jama_wasil_backup_data
            $jama_wasil_backup_table_data = [
                "data" => json_encode($_POST),
                "action" => 'JAMA_WASIL_ACTION_CO_REGISTRATION',
                'user_data' => json_encode($this->session->all_userdata()),
                'ip_address' => $this->session->all_userdata()['ip_address'],
                "created_at"=> date('Y-m-d h:i:s'),
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no
            ];
            $insertdata = $this->EkhajanaCoModel->COdisposeCaseMouzadariSystem($posted_data,$ArrearData,$ekBasicDetails,
            $jama_wasil_data,$jama_wasil_payee_list_data,$jama_wasil_backup_table_data);
            echo json_encode($insertdata);
        }elseif($jamawasil_status == 'unpaid_in_jama_wasil'){
            $PreArrearData = $this->EkhajanaCoModel->getEkhajanaPreArrearDetails($posted_data);
            if(!$PreArrearData){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0081']);
                exit;
            }
            $getJamaWasilUnpaidData = $this->EkhajanaCoModel->getJamaWasilUnpaidData($posted_data);
            if(!$getJamaWasilUnpaidData){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL00891']);
                exit;
            }

            $ArrearData = $this->EkhajanaCoModel->getEkhajanaMouzadarArrearDetailsNew($posted_data);
            $currentDoulDemand = $this->EkhajanaCoModel->getCurrentDoulDetails($ArrearData);        
            if(!$currentDoulDemand['flag']){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Current Doul Demand Not Found For This Patta..!!']);
                exit;
            }
            $current_revenue = $currentDoulDemand['result']->dag_revenue;
            $current_local_tax = $currentDoulDemand['result']->dag_local_tax;
            $current_doul_year = $currentDoulDemand['result']->year_no;
            //getting ek basic details from ld_application_no
            $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            if(!$ekBasicDetails){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0082']);
                exit;
            }

            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails,$posted_data);
            if($aadhar_link_flag['result'] == false){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0083']);
                exit;
            }
            //financial_year
            if (date('m') <= 6) {
                $financial_year = (date('Y')-1) . '-' . date('Y');
            } else {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            }
            $financial_year = ekhajana_financial_year;
            //if payment is done by self
            if($ArrearData->payment_by == "self"){
                $_POST['payee_name'] = null;
                $_POST['payee_relation'] = null;
                $_POST['payee_contact_no'] = null;
                $_POST['payee_email'] = null;
            }
            //jama_wasil_table_data_array
            $jama_wasil_data = [
                "dist_code" => $PreArrearData->dist_code,
                "subdiv_code" => $PreArrearData->subdiv_code,
                "cir_code" => $PreArrearData->cir_code,
                "mouza_pargona_code" => $PreArrearData->mouza_pargona_code,
                "lot_no" => $PreArrearData->lot_no,
                "vill_townprt_code" => $PreArrearData->vill_townprt_code,
                "village_uuid" => $PreArrearData->village_uuid,
                "patta_type_code" => $PreArrearData->patta_type_code,
                "patta_no" =>  $PreArrearData->patta_no,
                "dag_no" => "", 
                "financial_year" => $financial_year,
                "entry_year" =>  date('Y'),
                "entry_date" => date('Y-m-d'),
                "revenue" => $current_revenue,
                "local_tax" => $current_local_tax,
                "opening_balance" => $PreArrearData->arrear,
                "due_payment" => $current_revenue + $current_local_tax + $PreArrearData->arrear,
                "other_payment" => null,
                "last_revenue_payment_amount" => $ArrearData->last_revenue_payment, 
                "last_local_tax_payment_amount" => $ArrearData->last_local_tax_payment,
                "dol_year_no" => $current_doul_year,
                "pdar_id" => $ekBasicDetails->pdar_id, 
                "pdar_name" =>  $ekBasicDetails->pdar_name,
                "pdar_father_name" => $ekBasicDetails->pdar_father_name,
                "status" => JAMA_WASIL_STATUS_OFFLINE, 
                "modified_at" => date('Y-m-d h:i:s'),
                'user_code' => $this->session->all_userdata()['user_code'],
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no,
                "pay_status" => JAMA_WASIL_STATUS_UNPAID
            ];
            //jama_wasil_payee_list_data
            $jama_wasil_payee_list_data = [
                "dist_code" => $PreArrearData->dist_code,
                "subdiv_code" => $PreArrearData->subdiv_code,
                "cir_code" => $PreArrearData->cir_code,
                "mouza_pargona_code" => $PreArrearData->mouza_pargona_code,
                "lot_no" => $PreArrearData->lot_no,
                "vill_townprt_code" => $PreArrearData->vill_townprt_code,
                "village_uuid" => $PreArrearData->village_uuid,
                "patta_type_code" => $PreArrearData->patta_type_code,
                "patta_no" =>  $PreArrearData->patta_no,
                "dag_no"=> "",
                "pdar_id"=> $ekBasicDetails->pdar_id, 
                "pdar_name"=> $ekBasicDetails->pdar_name,
                "pdar_father_name"=> $ekBasicDetails->pdar_father_name,
                "payment_by"=> $ArrearData->payment_by,
                "payee_name"=> $_POST['payee_name'],
                "payee_contant_no"=> $_POST['payee_contact_no'],
                "payee_relation"=>$_POST['payee_relation'],
                "payee_email"=>$_POST['payee_email'],
                "modified_at"=> date('Y-m-d h:i:s'),
                'user_code' => $this->session->all_userdata()['user_code'],
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no
            ];
            //jama_wasil_backup_data
            $jama_wasil_backup_table_data = [
                "data" => json_encode($_POST),
                "action" => 'JAMA_WASIL_ACTION_CO_REGISTRATION',
                'user_data' => json_encode($this->session->all_userdata()),
                'ip_address' => $this->session->all_userdata()['ip_address'],
                "created_at"=> date('Y-m-d h:i:s'),
                "application_no" => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no" => $ArrearData->case_no
            ];
            $insertdata = $this->EkhajanaCoModel->COdisposeCaseMouzadariSystemWithJwUpdate($posted_data,$ArrearData,$ekBasicDetails,
            $jama_wasil_data,$jama_wasil_payee_list_data,$jama_wasil_backup_table_data,$getJamaWasilUnpaidData);
            echo json_encode($insertdata);
        }else{
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0081356']);
            exit;
        }

    }

    //case reject with category in mouzadari system
    public function rejectCaseMouzadariSystem(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $ld_application_no = $_POST['ld_application_no'];
        $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
        //checking whether the pattadar is identifeid before rejecting
        if($_POST['co_pattadar_identification_flag']=='Y'){
            $link_aadhaaar = $this->EkhajanaCoModel->linkAadharInRejectCase($ekBasicDetails);
            if($link_aadhaaar['result'] == false){
                log_message('error', 'linking aadhaar pattadar identified2'.$link_aadhaaar);
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0086']);
                exit;
            }
        }
        //***********************validation-starts*****************/
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');
        $error_msg = array();
        $validation = [
            [
                'field' => 'ek_details_id',
                'label' => 'ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
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
                'field' => 'case_no',
                'label' => 'case number',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'reject_code',
                'label' => 'Reject Reason(Atleast-One)',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason(Other)',
                'rules' => 'required|trim|callback_check_script|xss_clean|min_length[50]',
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters entered in %s field');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($validation as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************validation-end*****************/
        
        $posted_data = $_POST;
        $rejectedFlag = $this->EkhajanaCoModel->rejectCaseMouzadariSystem($posted_data);
        echo json_encode($rejectedFlag);
    }

    //function to get the list of pending cases of mouzadar objection
    public function mouzadarObjectionList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouzadarObjection'] = $this->EkhajanaCoModel->mouzadarobjectionListForCo($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/mouzadar_objection_list';
        $this->load->view('layouts/main',$data); 
    }

    //function to get the case details of the objection pending cases
    public function mouzadarObjectionCaseDetails($id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaCoModel->getmouzadarObjectionCaseDetailsFromId($id);
        // echo "<pre>";
        // var_dump($caseDetails);
        // exit;
        $data['arrearDetails'] = $arrearDetails = $this->EkhajanaCoModel->getEkhajanaMouzadarArrearDetailsForObj($caseDetails);
        $data['proceedingDetails'] =  $this->EkhajanaCoModel->getmouzadarObjectionProceedingDetails($caseDetails);
        $data['jama_wasil_status'] = $this->EkhajanaCoModel->getJamaWasilDetails($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        $data['_view'] = 'e_khajana/co_views/mouzadar_objection_case_details';
        $this->load->view('layouts/main',$data);   
    }

    //method to view additional document uploaded by lm
    public function viewAdditionalDocument()
    {
        $ld_application_no = $_GET['ld_application_no'];
        //$ld_application_no = 'RTPS/EKHT/2023/1/1';
        $query = $this->db->select('*')
                    ->where('ld_application_no', $ld_application_no)
                    ->from('ekhajana_additional_document')
                    ->get();
        $name =  $query->row()->file_name;
        
        $sql = "Select file_type,file_path from ekhajana_additional_document where file_name=?"; 
        $documents = $this->db->query($sql, array($name))->row_array();
           
        $file_path = $documents['file_path'];//UPLOAD_DIR . $name;
        $content_type = $documents['file_type'];
        
        if (file_exists($file_path)) {
           $file = file_get_contents($file_path);
           $raw_data = base64_encode($file);
           
        } else {
            $file = null;
            $raw_data = null;
        }
        $output= $raw_data;
        $check=explode("/",$content_type);
        if($check[1]=='pdf'){
            $output=base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        }else{
            echo '<img src="data:'.$content_type.';base64,'.$output.'" />';
        }
    }
    //method to view additional document uploaded by lm
    public function viewAdditionalDocumentByLM()
    {
        $ld_application_no = $_GET['ld_application_no'];
        $query = $this->db->query("select * from ekhajana_additional_document where user_code!='MOU' and ld_application_no=?",array($ld_application_no));
        $name =  $query->row()->file_name;
        
        $sql = "Select file_type,file_path from ekhajana_additional_document where file_name=?"; 
        $documents = $this->db->query($sql, array($name))->row_array();
           
        $file_path = $documents['file_path'];//UPLOAD_DIR . $name;
        $content_type = $documents['file_type'];
        
        if (file_exists($file_path)) {
           $file = file_get_contents($file_path);
           $raw_data = base64_encode($file);
           
        } else {
            $file = null;
            $raw_data = null;
        }
        $output= $raw_data;
        $check=explode("/",$content_type);
        if($check[1]=='pdf'){
            $output=base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        }else{
            echo '<img src="data:'.$content_type.';base64,'.$output.'" />';
        }
    }

    //to view receipt in lm end
    function MouzadarAddlDocView($doc_id){

        $this->dbswitch();
        $query = $this->db->query("select * from ekhajana_additional_document where id=?", array($doc_id));
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, EKHAJANA_MOUZADAR_ADDL_DOCUMENT_VIEW);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'path' => $query->row()->file_path,
        )));
        $result = curl_exec($curl_handle);
        $result = json_decode($result);
        $output=$result->raw_data;
        $output=base64_decode($output);
        header('Content-type: application/pdf');
        echo $output;
    }

    //**************************DP ESTATE CODE STARTS HERE*********************************
    public function dpEstatePendingList()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['pendingListdpEstate'] = $this->EkhajanaCoModel->pendingListofDpEstateForCo($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/co_views/pending_list_dpEstate';
        $this->load->view('layouts/main',$data);
    }

    //method to get case details 
    public function pendingCaseDetailsDpEstate($id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaCoModel->getPendingCaseDetailsFromIdforDpEstate($id);
        $data['jama_wasil_status'] = $this->EkhajanaCoModel->getJamaWasilDetailsForDpEstate($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        $data['arrear_data'] = $this->EkhajanaCoModel->getArrearData($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        if($data['arrear_data'] =="NO-DATA-FOUND"){
            echo json_encode('Some Error occurred ,error_code #EKHPCDDPES001');
            exit();
        }
        $data['_view'] = 'e_khajana/co_views/pending_case_details_dpEstate';
        $this->load->view('layouts/main',$data); 
    }

    //method to forward the case to adc from co
    public function forwardToAdcDpEstate()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $error_msg = array();
        $co_validation = [
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
            [
                'field' => 'rtps_doc_id',
                'label' => 'rtps document id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'co_report',
                'label' => 'CO Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'lm_report',
                'label' => 'lm Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'tn_report',
                'label' => 'Tn Branch Report',
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
        $this->form_validation->set_rules($co_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($co_validation as $rule){
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
        $forwardFlag = $this->EkhajanaCoModel->forwardToAdcDpEstate($posted_data);
        echo json_encode($forwardFlag); 
    }

    public function updateEkhajanaCo()
    {
        $data['_view'] = 'e_khajana/co_views/updateCasesForm';
        $this->load->view('layouts/main',$data);
    }

    public function updateCasesCo()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $application_no = $_POST['application_no'];
        if($application_no != EKHAJANA_UPDATE_APPLICATION_NO){
            echo "Case Updation not allowed for the application no $application_no";
            exit;
        }
        $upadteDharitree = $this->EkhajanaCoModel->updateDataInDharitreeEkhajana($application_no);
        echo json_encode($upadteDharitree['msg']);
    }
    
    public function revertToMouzadar_objection()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $error_msg = array();
        $co_validation = [
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
                'field' => 'case_no',
                'label' => 'Dharitree Application No',
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
            [
                'field' => 'guardian_name_eng',
                'label' => 'gurdian name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'guardian_name_asm',
                'label' => 'gurdian name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'guardian_relation',
                'label' => 'gurdian relation',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
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
            [
                'field' => 'rtps_doc_id',
                'label' => 'rtps document id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'co_report',
                'label' => 'CO Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'lm_report',
                'label' => 'lm Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'tn_report',
                'label' => 'Tn Branch Report',
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
        $this->form_validation->set_rules($co_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($co_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        echo "<pre>";
        var_dump($_POST);
        exit;
    }

    public function revertToMouzadar()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $error_msg = array();
        $co_validation = [
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'case_no',
                'label' => 'Dharitree Case No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'revert_reason',
                'label' => 'Revert Reason',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'patta_no',
                'label' => 'Patta No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($co_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($co_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        // echo "<pre>";
        // var_dump($_POST);
        // exit;
        $posted_data = $_POST;
        $RevertMouzadarFlag = $this->EkhajanaCoModel->RevertToMouzadarFromCo($posted_data);
        echo json_encode($RevertMouzadarFlag); 
    }

    public function updateDoul()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['all_new_mb2_patta'] = $this->EkhajanaCoModel->getNewMb2Patta($dist_code,$subdiv_code,$cir_code);
        if($data['all_new_mb2_patta']=="NO-NEW_PATTAS_FOUND")
        {
            $data['all_new_mb2_patta'] = [];
        }
        
        // echo "<pre>";
        // var_dump($data['all_new_mb2_patta']);
        // exit;
        $data['_view'] = 'e_khajana/co_views/viewNewDouldetails';
        $this->load->view('layouts/main',$data); 
    }

    public function insertNewMb2PattasToDoul()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $all_data = array();
        foreach($_POST['patta_data'] as $all_patta_data){
            list($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no,$dag_revenue,$dag_local_tax,$total_lessa) = explode('_', $all_patta_data);
            $formated_data = [
                'dist_code'             => $dist_code,
                'subdiv_code'           => $subdiv_code,
                'cir_code'              => $cir_code,
                'mouza_pargona_code'    => $mouza_pargona_code,
                'lot_no'                => $lot_no,
                'vill_townprt_code'     => $vill_townprt_code,
                'patta_type_code'       => $patta_type_code,
                'patta_no'              => $patta_no,
                'dag_revenue'           => $dag_revenue,
                'dag_local_tax'         => $dag_local_tax,
                'total_lessa'           => $total_lessa,               
            ];
            array_push($all_data,$formated_data);
        }
        // echo "<pre>";
        // var_dump($all_data);
        // exit;
        $insert_into_doul = $this->EkhajanaCoModel->insertMB2PattaIntoDoul($all_data);
        echo json_encode($insert_into_doul);
    }


    public function getKhajanaReceiptDetails()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['dist_name'] = $this->utilityclass->getDistrictName($dist_code);
        $data['subdiv_name'] = $this->utilityclass->getSubdivName($dist_code,$subdiv_code);
        $data['cir_name'] = $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);
        $data['village_list'] = $village_list = $this->EkhajanaCoModel->getAllVillages($dist_code,$subdiv_code,$cir_code);
        $data['patta'] = $patta = $this->EkhajanaCoModel->getAllPattas();
        $data['_view'] = 'e_khajana/co_views/viewKhajanaReceiptCo';
        $this->load->view('layouts/main',$data); 

    }

    public function getKhajanaReceipt()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        // exploding village to get mouza, lot and village code
        $village_data = explode(',', $_POST['village']); 
        $mouza_pargona_code = $village_data[0]; 
        $lot_no = $village_data[1]; 
        $vill_townprt_code = $village_data[2];
        $patta_type_code = $this->input->post('patta_type'); 
        $patta_no = $this->input->post('patta_no'); 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => GET_EKHAJANA_REGISTARTION_DETAILS_FOR_CO,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POSTFIELDS => array(
                'dist_code'             => $dist_code,
                'subdiv_code'           => $subdiv_code,
                'cir_code'              => $cir_code,
                'mouza_pargona_code'    => $mouza_pargona_code,                    
                'lot_no'                => $lot_no,
                'vill_townprt_code'     => $vill_townprt_code,
                'patta_type_code'       => $patta_type_code,  
                'patta_no'              => $patta_no,  
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->flag == "Y"){
                if($response_obj->registartion_flag == "Y"){
                    //registation details found
                    // if registration details found, check whether payment has been done or not
                    //checking if jama wasil exist i.e paymnt done or not
                    $checkJamaWasil = $this->db->query("select * from jama_wasil where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                            and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($dist_code,$subdiv_code,$cir_code,
                            $mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no));
                    //return that payment has not been done
                    if($checkJamaWasil->num_rows == 0)
                    {
                        echo json_encode([  
                                            "flag" => 'N',
                                            "registration_flag" => 'Y',
                                            "app_count"=>$response_obj->registration_count, 
                                            "app_nos" =>$response_obj->application_nos, 
                                            "msg" =>"Registration details has been found for this patta but this Patta has not been disposed from circle officer end. Kindly Verify the application number and check again..!!!"
                                        ]);
                    }
                    // return payment done
                    if($checkJamaWasil->num_rows == 1)
                    {
                        $jama_wasil_row = $checkJamaWasil->row();
                        if($jama_wasil_row->pay_status =='PAID')
                        {   
                            $ld_application_no = $jama_wasil_row->ld_application_no;
                            echo json_encode([  
                                                "flag"              => 'Y',
                                                "registration_flag" => 'Y',
                                                "app_nos"           =>$response_obj->application_nos, 
                                                "app_count"         =>$response_obj->registration_count, 
                                                "msg"               =>"Payment has been completed for this patta, Kindly Click the View Khajana Receipt button to get the Khajana Receipt of the current revenue year of the patta..!!",
                                                "ld_application_no" =>$ld_application_no,
                                            ]);
                        }else{
                            echo json_encode([
                                                "flag"              => 'N', 
                                                "registration_flag" => 'Y',
                                                "msg"               =>"Registarion has been completed and application against this patta has been diposed from circle officer end, But Payment has not been received against this patta, Kindly Ask Citizen to pay the Khajana Amount and generate the khjana receipt..!!!"
                                             ]);
                        }
                    }

                }else{
                    //registation details not found
                    echo json_encode([ 
                                        "flag" => 'N',
                                        "registration_flag" => 'N',
                                        "msg" => $response_obj->msg
                                    ]);
                }               
            }else{
                echo json_encode([  
                                    "flag" => 'N',
                                    "registration_flag" => 'N',
                                    "msg" => "Some Error Occurred in fetching data"
                                ]);
            } 
        }else{
            echo json_encode([
                              "flag" => 'N', 
                              "registration_flag" => 'N',
                              "msg" => "Server Error"
                            ]);
        }
    }

    public function viewKhajanaReceiptByCo() {
        $ld_application_no = $this->input->get('ld_application_no');
        $ek_basic_row = $this->db->query("select * from ekhajana_basic where ld_application_no=?",array($ld_application_no))->row();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, EKHAJANA_VIEW_KHAJANA_RECIPT_IN_CO_LOGIN);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'dist_code'         => $ek_basic_row->dist_code,
            'subdiv_code'       => $ek_basic_row->subdiv_code,
            'cir_code'          => $ek_basic_row->cir_code,
            'mouza_pargona_code'=> $ek_basic_row->mouza_pargona_code,
            'lot_no'            => $ek_basic_row->lot_no,
            'vill_townprt_code' => $ek_basic_row->vill_townprt_code,
            'patta_type_code'   => $ek_basic_row->patta_type_code,
            'patta_no'          => $ek_basic_row->patta_no,
        )));
        
        $result = curl_exec($curl_handle);
        $result = json_decode($result);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        if($httpcode != 200)
        {
            echo "Network Error in fetching the Khajana Receipt, Kindly Try After Sometime";
            exit;
        }
        if ($result === null) {
            echo "Could not Fetch Khajana Receipt. Please Try again Later";
            exit;
        }
        if($result->flag =='N'){
            echo $result->msg;
            exit;
        }
        if($result->flag =='Y'){
            if(empty($result->msg->path) || empty($result->msg->name)){
                echo "Some Data Missing, Could not Fetch Khajana Receipt. Please Try again Later";
                exit;
            }
            $file_path = $result->msg->path;  // Absolute file path
            $file_name = $result->msg->name;  // File name
        
            if (!file_exists($file_path)) {
                echo "File not found.";
                exit;
            }
            // Serve the PDF file
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=\"$file_name\"");
            readfile($file_path);
            exit;
        }else{
            echo "Internal Server Error, Please try again later";
            exit;
        }
        
    }
    

    
}

 