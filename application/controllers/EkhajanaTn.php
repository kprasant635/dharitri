<?php

class EkhajanaTn extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/EkhajanaTn/EkhajanaTnModel');
        $this->load->library('AES');
        $this->dbswitch();
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

    //function to get pending list count for tn branch
    public function index(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        if(in_array($this->session->userdata('dist_code'),EKHAJANA_EXCLUDE_DISTRICT_FROM_EKHAJANA_PROCESS))
        {
            echo json_encode("E-Khajana Service is on Hold For This District. Will be resumed Soon");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_COUNT_TN_BRANCH_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,
                                        'user_designation_code' => $this->session->userdata('user_desig_code')),
                                        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_count_tn_branch'] = $response_obj->msg;
            }else{
                log_message("error", "#EKCRLTN0001, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_COUNT_TN_BRANCH_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLTN0001");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLTN0002, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_COUNT_TN_BRANCH_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLTN0002");
        }
        $data['_view'] = 'e_khajana/tn_views/index';
        $this->load->view('layouts/main',$data);
    }

    //function to get pending list for tn branch
    public function pendingListTn(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_LIST_TN_BRANCH_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('dist_code' => $dist_code,
                                        'user_designation_code' => $this->session->userdata('user_desig_code')),
                                        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $data['pending_list_tn_branch'] = $response_obj->msg;
            }else{
                log_message("error", "#EKCRLTN0003, Curl Error(Y) In Api ".EKHAJANA_PENDING_LIST_TN_BRANCH_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLTN0003");
            } 
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLTN0004, Curl Error(200) In Api ".EKHAJANA_PENDING_LIST_TN_BRANCH_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLTN0004");
        }
        $data['_view'] = 'e_khajana/tn_views/pending_list';
        $this->load->view('layouts/main',$data);

    }

    //method to decode image
    public function imageDecodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }

    //function to get pending list details for tn branch
    public function pendingCaseDetailsTnBranch($land_details_id){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['landDetails'] = $landDetails = $this->EkhajanaTnModel->getLandDetailsFromId($land_details_id);
        $data['pendingCaseLandDetails'] = $land_details = $landDetails['result']->land_details;
        $data['pendingCaseApplicantDetails'] = $landDetails['result']->applicant_details;
        $data['pendingCaseDocumentDetails'] = $landDetails['result']->document_details;
        $currentDpDoulDemand = $this->EkhajanaTnModel->getCurrentRevenueAndLocalTaxFromDpDoul($landDetails);        
        if(!$currentDpDoulDemand['flag']){
            echo json_encode("Current Dp Doul Demand Not Found For This Patta..!!");
            exit;
        }
        $dist_code = $land_details->dist_code;
        $subdiv_code = $land_details->subdiv_code;
        $cir_code = $land_details->cir_code;
        $mouza_pargona_code = $land_details->mouza_pargona_code;
        $lot_no = $land_details->lot_no;
        $vill_townprt_code = $land_details->vill_townprt_code;
        $village_uuid = $land_details->village_uuid;
        $patta_type_code = $land_details->patta_type_code;
        $patta_no = $land_details->patta_no;

        


        $data['total_arrear'] = $total_arrear =  $this->EkhajanaTnModel->getTotalArrear($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);  
        
        if($total_arrear =='NOT-FOUND'){            
            $ek_land_details = $this->EkhajanaTnModel->getLandDetailsFromId($land_details_id);
            $data['ek_land_details'] = $ek_land_details['result'];
            // echo "<pre>";
            // var_dump($data['ek_land_details']);
            // exit;
            $data['_view'] = 'e_khajana/tn_views/arrear_error';
            $this->load->view('layouts/main',$data);   
            return;
        }
        

        $check_surcharge = $this->EkhajanaTnModel->checkSurcharge($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);
        if($check_surcharge == 'SURCHARGE-NOT-FOUND'){ 
            $data['surcharge_msg'] = "Surcharge Field is not entered for this patta, Kindly edit the Patta details and add the surcharge data of the Patta. Enter 0 if no surcharge should be imposed on the Patta for the respective financial year" ;         
            $ek_land_details = $this->EkhajanaTnModel->getLandDetailsFromId($land_details_id);
            $data['ek_land_details'] = $ek_land_details['result'];
            // echo "<pre>";
            // var_dump($data['ek_land_details']);
            // exit;
            $data['_view'] = 'e_khajana/tn_views/arrear_error'; 
            $this->load->view('layouts/main',$data);   
            return;
        }


        $data['arrear_status'] = $this->EkhajanaTnModel->checkArrearStatus($land_details);
        $rtps_application_no = $landDetails['result']->land_details->application_no;

        //for getting aadaar photo///
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
        
        }
        $data['current_revenue'] = $currentDpDoulDemand['result']->dag_revenue;
        $data['current_local_tax'] = $currentDpDoulDemand['result']->dag_local_tax;
        $data['current_doul_year'] = $currentDpDoulDemand['result']->year_no;
        $data['surcharge'] = $currentDpDoulDemand['result']->surcharge;
        
        $data['_view'] = 'e_khajana/tn_views/pending_case_details';
        $this->load->view('layouts/main',$data);
    }

    //function to update a case in dharitree from TN branch
    public function dpEstateCaseRegistration(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
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
        $tn_branch_validation = [
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
                'field' => 'tn_report',
                'label' => 'Tn report',
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
            [
                'field' => 'openinig_balance',
                'label' => 'Opening Balance',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'current_revenue',
                'label' => 'Current Revenue',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'current_local_tax',
                'label' => 'Current Local Tax',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'current_doul_year',
                'label' => 'Current Doul Year',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'surcharge',
                'label' => 'Surcharge',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'arrear_status',
                'label' => 'Arrear status',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'last_pay_date1',
                'label' => 'Last Pay date',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'last_revenue_payment_amount',
                'label' => 'Last Revenue Payment Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'last_local_tax_payment_amount',
                'label' => 'Last Local tax payment Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'paymentBy',
                'label' => 'Payment by',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'land_details_id',
                'label' => 'Land Details Id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($tn_branch_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($tn_branch_validation as $rule){
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
        $ekBasicAddFlag = $this->EkhajanaTnModel->updateEkhajanaBasicDpEstate($posted_data);
        echo json_encode($ekBasicAddFlag);
    }

    public function preArrearIndex()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['_view'] = 'e_khajana/tn_views/pre_arrear_index'; 
        $this->load->view('layouts/main',$data);
    }

    //arrear update form 
    public function preArrearUpdateForm()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdivisions'] =$subdivisions = $this->EkhajanaTnModel->getAllSubDivName($dist_code);
        $data['_view'] = 'e_khajana/tn_views/preArrearUpdateFrom';
        $this->load->view('layouts/main',$data);
    }

    //get all circles 
    public function getAllCircles()
    {
        $dist_code      = $_POST['dist_code'];
        $subdiv_code    = $_POST['subdiv_code'];
        $circles        = $this->EkhajanaTnModel->getAllCircleName($dist_code,$subdiv_code);
        echo json_encode($circles);
    }

    //get all mouzas
    public function getAllMouzas()
    {
        $dist_code      = $_POST['dist_code'];
        $subdiv_code    = $_POST['subdiv_code'];
        $cir_code       = $_POST['cir_code'];
        $mouzas         = $this->EkhajanaTnModel->getAllMouzaName($dist_code,$subdiv_code,$cir_code);
        echo json_encode($mouzas);
    }

    //get all lots
    public function getAllLots()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lots               = $this->EkhajanaTnModel->getAllLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code);
        
        echo json_encode($lots);
    }

    //get all villages
    public function getAllVillages()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lot_no             = $_POST['lot_no'];
        $villages           = $this->EkhajanaTnModel->getAllVillagesName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
        echo json_encode($villages);
    }

    //get all patta_types
    public function getPattaTypes()
    {
        $patta_types = $this->EkhajanaTnModel->getPattaType();
        echo json_encode($patta_types);
    }

    //get all patta nos
    public function getPattaNo()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lot_no             = $_POST['lot_no'];
        $vill_townprt_code  = $_POST['vill_townprt_code'];
        $patta_type_code    = $_POST['patta_type_code'];
        $patta_types = $this->EkhajanaTnModel->getPattaNo($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code);
        echo json_encode($patta_types);
    }

    public function submitArrear($autoYear = null)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']              = $_POST['dist'];
        $data['subdiv_code']            = $_POST['subdivison'];
        $data['cir_code']               = $_POST['circles'];
        $data['mouza_pargona_code']     = $_POST['mouzas'];
        $data['lot_no']                 = $_POST['lots'];
        $data['vill_townprt_code']      = $_POST['villages'];
        $data['patta_type_code']        = $_POST['patta_type_code'];
        $data['patta_no']               = $_POST['patta_no'];
        // $data['arch_doul_2025']         = $this->EkhajanaTnModel->get2025ArchiveDouldata($data['dist_code'],$data['subdiv_code'],$data['cir_code'],
        //                                         $data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code'],$data['patta_type_code'],$data['patta_no']);

        $autoYear = $autoYear ?? $this->input->get('autoYear');
        $data['is_auto_year'] = $autoYear;
        $data['_view'] = 'e_khajana/tn_views/insertArrear';
        $this->load->view('layouts/main',$data);
    }

    public function submitInsertedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $posted_data = $_POST;
        $years = $_POST['years'];
        $arear = $_POST['arrear'];
        $tax = $_POST['tax'];
        $revenue = $_POST['revenue'];
        $surcharge = $_POST['surcharge'];
        // $miran = $_POST['miran'];
        $data = [];
        foreach($arear as $key=>$arrearvalue) 
        {                 
            $data[$key]['year'] = $years[$key];
            $data[$key]['revenue'] = $revenue[$key];
            $data[$key]['tax'] = $tax[$key];
            $data[$key]['surcharge'] = $surcharge[$key];
            // $data[$key]['miran'] = $miran[$key];
            $data[$key]['arear'] = $arrearvalue;
        }

        foreach($data as $arr_row){            

            if($arr_row['revenue'] != '' || $arr_row['tax'] != '' || $arr_row['revenue'] != null || $arr_row['tax'] != null){
                if($arr_row['year'] == '' || $arr_row['year'] == null || $arr_row['revenue'] == '' || $arr_row['revenue'] == null
                || $arr_row['tax'] == '' || $arr_row['tax'] == null || $arr_row['arear'] == '' || $arr_row['arear'] == null || $arr_row['surcharge'] == '' || $arr_row['surcharge'] == null ){
                    echo json_encode(['result' => 'INPUT-ERROR', 'msg' => 'Some fields missing for the year '.$arr_row['year']. ', kindly insert properly..!!']);
                    exit;
                } 
            }
                       
        }
        $ekArrearPreUpdateFlag = $this->EkhajanaTnModel->insertPreArrearData($posted_data,$data);
        echo json_encode($ekArrearPreUpdateFlag);
    }

    public function viewPreUpdatedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['all_pre_arrear_list'] = $this->EkhajanaTnModel->getPreUpdatedList($dist_code);
        $data['_view']          = 'e_khajana/tn_views/preArrearUpdatedList';
        $this->load->view('layouts/main',$data); 
    }

    public function viewYearWiseArrear($pre_arrear_id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $year_wise_arrear = $this->EkhajanaTnModel->getYearWiseArrear($pre_arrear_id);
        if($year_wise_arrear['flag'] =='N')
        {
            echo "Year Wise Arrear Not Found, Kindly Contact System Administrator";
            exit;  
        }
        $data['year_wise_arrear'] = $year_wise_arrear['msg'];
        $data['_view']          = 'e_khajana/tn_views/yearWiseArrearView';
        $this->load->view('layouts/main',$data); 
    }

    public function editPreUpdatedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['edit_pre_arrear_list'] = $this->EkhajanaTnModel->getPreUpdatedListForEdit($dist_code);
        $data['_view']          = 'e_khajana/tn_views/preArrearEditList';
        $this->load->view('layouts/main',$data); 
    }

    public function editYearWiseArrear($pre_arrear_id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $year_wise_arrear = $this->EkhajanaTnModel->getYearWiseArrear($pre_arrear_id);
        if($year_wise_arrear['flag'] =='N')
        {
            echo "Year Wise Arrear Not Found, Kindly Contact System Administrator";
            exit;  
        }
        $data['year_wise_arrear'] = $year_wise_arrear['msg'];
        $data['_view']          = 'e_khajana/tn_views/yearWiseArrearEdit';
        $this->load->view('layouts/main',$data); 
    }

    public function submitEditArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "TN"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $error_msg = array();
        $validation = [
            [
                'field' => 'pre_arrear_id',
                'label' => 'pre_arrear_id',
                'rules' => 'required|callback_check_script|trim'
            ],
            [
                'field' => 'year_revenue[]',
                'label' => 'Revenue of particular year',
                'rules' => 'required|callback_check_script|trim'
            ],
            [
                'field' => 'year_tax[]',
                'label' => 'Local tax of particular year',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'year_surcharge[]',
                'label' => 'Surcharge of particular year',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'year_arrear[]',
                'label' => 'Arrear of particular year',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'total_revenue',
                'label' => 'Total revenue',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'total_tax',
                'label' => 'Total tax',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'total_surcharge',
                'label' => 'Surcharge',
                'rules' => 'required|callback_check_script|trim',
            ],
            [
                'field' => 'total_arrear',
                'label' => 'Total Arrear',
                'rules' => 'required|callback_check_script|trim',
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
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        $posted_data = $_POST;
        $pre_arrear_id = $_POST['pre_arrear_id'];
        $total_revenue = $_POST['total_revenue'];
        $total_tax = $_POST['total_tax'];
        $total_surcharge = $_POST['total_surcharge'];
        $total_arrear = $_POST['total_arrear'];
        $year_revenue = $_POST['year_revenue'];
        $year_tax = $_POST['year_tax'];
        $year_surcharge = $_POST['year_surcharge'];
        $year_arrear = $_POST['year_arrear'];
        $update_array = array();

        $previous_arrears = array();
        $years_arr = array();
        $revenue_arr = array();
        $tax_arr = array();
        $surcharge_arr = array();
        $arrear_arr = array();

        $total_revenue_db = 0;
        $total_tax_db = 0;
        $total_surcharge_db = 0;
        $total_arrear_db = 0;

        foreach($year_revenue as $year=>$revenue) 
        {         
            //validations 
            if(($revenue + $year_tax[$year] + $year_surcharge[$year]) != $year_arrear[$year])
            { 

                echo json_encode(['result' => 'validation_error', 'msg' => ["Sum of Revenue and local tax and Surcharge is not matching with total arrear value"]]);
                exit;  
            }
            //revenue and local tx addition should be same as the key value arrear          
            array_push($update_array, [
                "financial_year"    => $year,
                "revenue"           => $revenue,
                "tax"               => $year_tax[$year],
                "surcharge"         => $year_surcharge[$year],
                "arrear"            => $year_arrear[$year],
                "pre_arrear_id"     => $pre_arrear_id,
                "total_tax"         => $total_tax, 
                "total_surcharge"   => $total_surcharge, 
                "total_revenue"     => $total_revenue, 
                "total_arrear"      => $total_arrear
            ]);
            //creating the previous arrear fileds arrays 
            array_push($years_arr, $year);
            array_push($revenue_arr,$revenue);
            array_push($tax_arr, $year_tax[$year]);
            array_push($surcharge_arr, $year_surcharge[$year]);
            array_push($arrear_arr, $year_arrear[$year]);
            //for logical validation of the arrears, tax and revenue with total 
            $total_revenue_db = $total_revenue_db+$revenue;
            $total_tax_db = $total_tax_db+$year_tax[$year];
            $total_surcharge_db = $total_surcharge_db+$year_surcharge[$year];
            $total_arrear_db = $total_arrear_db+$year_arrear[$year];  
        }
        // Checking revenue total if mismatching
        if($total_revenue_db != $total_revenue){
            echo json_encode(['result' => 'validation_error', 'msg' => ["Mismatch In Total Revenue, Kindly re-enter"]]);
            exit;  
        }
        // Checking local tax total if mismatching
        if($total_tax_db != $total_tax){
            echo json_encode(['result' => 'validation_error', 'msg' => ["Mismatch In Total Local tax, Kindly re-enter"]]);
            exit;  
        }
        // Checking local surcharge total if mismatching
        if($total_surcharge_db != $total_surcharge){
            echo json_encode(['result' => 'validation_error', 'msg' => ["Mismatch In Total Surcharge, Kindly re-enter"]]);
            exit;  
        }
        // Checking arrear total if mismatching
        if($total_arrear_db != $total_arrear){
            echo json_encode(['result' => 'validation_error', 'msg' => ["Mismatch In Total Arrear, Kindly re-enter"]]);
            exit;  
        }


        //creating the previous arrear 
        $previous_arrears['years'] = $years_arr;
        $previous_arrears['revenue'] = $revenue_arr;
        $previous_arrears['tax'] = $tax_arr;
        $previous_arrears['surcharge'] = $surcharge_arr;
        $previous_arrears['arrear'] = $arrear_arr;
        $previous_arrears['total_revenue'] = $total_revenue;
        $previous_arrears['total_tax'] = $total_tax;
        $previous_arrears['total_surcharge'] = $total_surcharge;
        $previous_arrears['total_arrear'] = $total_arrear;

        $this->db->trans_begin();
        $insertTransactions = $this->EkhajanaTnModel->insertArrearTransactiondata($pre_arrear_id);
        if($insertTransactions['result'] =="SERVER-ERROR"){
            echo json_encode($insertTransactions);
            exit;
        }
        $updatePreArrearUpdation =$this->EkhajanaTnModel->updatePreArrearUpdation($pre_arrear_id,$update_array,$previous_arrears);
        if($updatePreArrearUpdation['result'] =="SERVER-ERROR"){
            echo json_encode($updatePreArrearUpdation);
            exit;
        }else{
            $this->db->trans_commit();
            echo json_encode($updatePreArrearUpdation);
        }
    }

}

?>
