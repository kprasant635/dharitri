<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaChangeRequestController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->model('eKhajana/Common/EkhajanaHelperModel');
        $this->load->model('eKhajana/ChangeRequest/EkhajanaChangeRequestModel');
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
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        //echo "Ekhajana Co COntroller <br>Dist-Code : ".$dist_code."<br>Subdiv-Code : ".$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['pendingCountforLC'] = $this->EkhajanaChangeRequestModel->pendingForLCCount($dist_code,$subdiv_code,$cir_code);
        $data['pendingCountforPA'] = $this->EkhajanaChangeRequestModel->pendingForPACount($dist_code,$subdiv_code,$cir_code);
       // $data['mouzadarObjectionCount'] = $this->EkhajanaCoModel->mouzadarObjectionForCoCount($dist_code,$subdiv_code,$cir_code);//mouzadari sytem
       // $data['revertedCount'] = $this->EkhajanaCoModel->revertedForCoCount($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/change_request/index';
        $this->load->view('layouts/main',$data);
    }

    //displaying pending list in co 
    public function pendingListforLC(){
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
        $data['pendingList'] = $this->EkhajanaChangeRequestModel->pendingListForLC($dist_code,$subdiv_code,$cir_code);
        // var_dump($data);exit;
        $data['_view'] = 'e_khajana/change_request/pending_list';
        $this->load->view('layouts/main',$data);
    }

    //pending case details
    public function pendingCaseDetails($petition_no){
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaChangeRequestModel->getPendingCaseDetailsFromId($petition_no);
       // $data['jama_wasil_status']=$this->EkhajanaCoModel->getJamaWasilDetails($caseDetails->dist_code, 
           // $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            //$caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        //check if additional document is available
        //$ld_application_no = $caseDetails->ld_application_no;
       // $data['additional_doc'] = $this->EkhajanaCoModel->checkAdditonalDocument($ld_application_no);
        $data['_view'] = 'e_khajana/change_request/pending_case_details_lc';
        $this->load->view('layouts/main',$data);        
    }

    public function pendingListforPA(){
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
        $data['pendingList'] = $this->EkhajanaChangeRequestModel->pendingListForPA($dist_code,$subdiv_code,$cir_code);
        // var_dump($data);exit;
        $data['_view'] = 'e_khajana/change_request/pending_list_pattadar_area';
        $this->load->view('layouts/main',$data);
    }


    

    //pending case details
    public function pendingCaseDetailsPA($petition_no){
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['caseDetails'] = $caseDetails = $this->EkhajanaChangeRequestModel->getPendingCaseDetailsFromIdPA($petition_no);
        //var_dump($data);exit;
        $data['_view'] = 'e_khajana/change_request/pending_case_details_pa';
        $this->load->view('layouts/main',$data);        
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
        $data['caseDetails'] = $caseDetails = $this->EkhajanaCoModel->getPendingCaseDetailsFromId($id);
        
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
        $data['_view'] = 'e_khajana/co_views/pendingCaseDetailsMouzadariArea';
        $this->load->view('layouts/main',$data);        
    }

    //co dispose the case in mouzadari system 1st flow
    public function COdisposeCase(){
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
        [
            'field' => 'guardian_name_eng',
            'label' => 'Guardian Name in English',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'guardian_name_asm',
            'label' => 'Guardian Name in Assamese',
            'rules' => 'required|trim|xss_clean'
        ],
        [
            'field' => 'guardian_relation',
            'label' => 'Guardian Relation',
            'rules' => 'required|trim|xss_clean'
        ],
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
            'label' => 'Pattadar Identification flag',
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
            'field' => 'pattadar_identified',
            'label' => 'Pattadar Identified',
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
       
        if($jamawasil_status == 'paid_in_jama_wasil'){
            //no updation in jamawasil
            $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails);
            if(!$aadhar_link_flag){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0085']);
                exit;
            }
            $updateData = $this->EkhajanaCoModel->COdisposeCaseMouzadariSystemWithoutInsert($posted_data,$ekBasicDetails,$getJamaWasilData);
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
            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails);
            if(!$aadhar_link_flag){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0083']);
                exit;
            }
            //financial_year
            if (date('m') <= 6) {
                $financial_year = (date('Y')-1) . '-' . date('Y');
            } else {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            }
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
                "dol_year_no" => $ArrearData->current_doul_year,
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

            $aadhar_link_flag = $this->EkhajanaCoModel->linkAadhar($ekBasicDetails);
            if(!$aadhar_link_flag){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0083']);
                exit;
            }
            //financial_year
            if (date('m') <= 6) {
                $financial_year = (date('Y')-1) . '-' . date('Y');
            } else {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            }
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
                "dol_year_no" => $ArrearData->current_doul_year,
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
        $ld_application_no = $_POST['ld_application_no'];
        $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
        //checking whether the pattadar is identifeid before rejecting
        if($_POST['pattadar_identified']=='Y'){
            $link_aadhaaar = $this->EkhajanaCoModel->linkAadharInRejectCase($ekBasicDetails);
            if(!$link_aadhaaar){
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
}