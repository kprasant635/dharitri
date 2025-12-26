<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaCoArrearUpdateController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
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
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['updated_patta_count'] = $this->CoArrearUpdateModel->getUpdatedPattaArrearCount($dist_code,$subdiv_code, $cir_code);
        $data['pending_count'] = $this->CoArrearUpdateModel->getPendingPattaArrearCount($dist_code,$subdiv_code, $cir_code);
        $data['_view'] = 'e_khajana/co_arrear_update/index';
        $this->load->view('layouts/main',$data);
    }

    //displaying doul for co
    public function ViewDoul(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['_view'] = 'e_khajana/ekhajana_doul/co_view_doul';
        $this->load->view('layouts/main',$data);
    }

    //arrear-update-form-co
    public function ArrearUpdateForm(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $doulExistsFlag = $this->EkhajanaDoulModel->checkDoulExists($dist_code,$subdiv_code,$cir_code);
        if(!$doulExistsFlag){
            $data['_view'] = 'e_khajana/ekhajana_doul/doul_error_page';
            $this->load->view('layouts/main',$data);   
            return;
        }
        $data['mouza_list'] = $this->CoArrearUpdateModel->getMouzaList($dist_code,$subdiv_code,$cir_code);
        $data['payee_relations'] = $this->EkhajanaCommonModel->getGuardianRelations();
        $data['_view'] = 'e_khajana/co_arrear_update/co_arrear_update_form';
        $this->load->view('layouts/main',$data);
    }

    //getting-village-list
    public function getVllageList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $_POST['mouza_code'];
        $village_list = $this->EkhajanaCommonModel->getVillageList($dist_code,$subdiv_code,$cir_code,$mouza_code);
        echo json_encode($village_list);
    }
    
    //getting-patta-types
    public function getPattaTypes(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $mouza_code = $_POST['mouza_code'];
        $village_uuid = $_POST['village_uuid'];
        $patta_types = $this->EkhajanaCommonModel->getPattaType($mouza_code,$village_uuid);
        echo json_encode($patta_types);
    }
    
    //co arrrear update form submit
    public function arrearUpdateFormSubmit(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //*****************validation*************/
        $error_msg = array();
        $arrear_update_form_val = [
            [
                'field' => 'ek_mouza_code',
                'label' => 'Mouza',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean'
            ],
            [
                'field' => 'village_uuid',
                'label' => 'Village',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean'
            ],
            [
                'field' => 'patta_type_code',
                'label' => 'Patta-Type',
                'rules' => 'required|callback_check_script|max_length[4]|trim|xss_clean'
            ],
            [
                'field' => 'patta_no',
                'label' => 'Patta-No',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean'
            ],
            // [
            //     'field' => 'pattadar',
            //     'label' => 'Pattadar',
            //     'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
            // ],
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
                'field' => 'paymentBy',
                'label' => 'Last Payment By',
                'rules' => 'required|callback_check_script|in_list[self,other]|trim|xss_clean'
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
        //if payment by other 
        if($_POST['paymentBy'] == "other"){
            $payee_details = [
                [
                'field' => 'payee_name',
                'label' => 'Payee-Name',
                'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                ],
                [
                'field' => 'payee_relation',
                'label' => 'Payee Relation',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean'
                ],
                [
                'field' => 'payee_contact_no',
                'label' => 'Payee Contact No',
                'rules' => 'callback_check_script|integer|exact_length[10]|trim|xss_clean'
                ],
                [
                'field' => 'payee_email',
                'label' => 'Payee Email',
                'rules' => 'callback_check_script|valid_email|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_rules($payee_details);
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
            if ($this->form_validation->run() == FALSE)
            {               
                foreach($payee_details as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
                }              
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        //****************************************/
        date_default_timezone_set('Asia/Kolkata');
        if($_POST['paymentBy'] == "self"){
           $_POST['payee_name'] = null;
           $_POST['payee_relation'] = null;
           $_POST['payee_contact_no'] = null;
           $_POST['payee_email'] = null;
        }
        // pattadar not needed in arrear update 
        // $pattadar_details = $_POST['pattadar'];
        // $pattadar_details_arr = explode("_",$pattadar_details);
        // $_POST['pdar_id'] = $pattadar_details_arr[0];
        // $_POST['pdar_name'] = $pattadar_details_arr[1];
        // $_POST['pdar_father_name'] = $pattadar_details_arr[2];
        $location_details = $this->EkhajanaCommonModel->getLocationDetailsFromUUID($_POST['village_uuid']);
        //financial_year
        if (date('m') <= 8) {
              $financial_year = (date('Y')-1) . '-' . date('Y');
        } else {
              $financial_year = date('Y') . '-' . (date('Y') + 1);
        }
        //jama_wasil_table_data_array
        $jama_wasil_data = [
           "dist_code" => $location_details->dist_code,
           "subdiv_code" => $location_details->subdiv_code,
           "cir_code" => $location_details->cir_code,
           "mouza_pargona_code" => $location_details->mouza_pargona_code,
           "lot_no" => $location_details->lot_no,
           "vill_townprt_code" => $location_details->vill_townprt_code,
           "village_uuid" => $_POST['village_uuid'],
           "patta_type_code" => $_POST['patta_type_code'],
           "patta_no" =>  $_POST['patta_no'],
           "dag_no" => "", 
           "financial_year" => $financial_year,
           "entry_year" =>  date('Y'),
           "entry_date" => date('Y-m-d'),
           "revenue" => $_POST['current_revenue'],
           "local_tax" => $_POST['current_local_tax'],
           "opening_balance" => $_POST['openinig_balance'],
           "due_payment" => $_POST['current_revenue'] + $_POST['current_local_tax'] + $_POST['openinig_balance'],
           "other_payment" => null,
           "last_revenue_payment_amount" => $_POST['last_revenue_payment_amount'], 
           "last_local_tax_payment_amount" => $_POST['last_local_tax_payment_amount'],
           "dol_year_no" => "",
           "pdar_id" => null, 
           "pdar_name" =>  null,
           "pdar_father_name" => null,
           "status" => JAMA_WASIL_STATUS_OFFLINE, 
           "created_at" => date('Y-m-d h:i:s'),
           "modified_at" => null,
           'user_code' => $this->session->all_userdata()['user_code']
        ];
        //jama_wasil_payee_list_data
        $jama_wasil_payee_list_data = [
           "dist_code"=> $location_details->dist_code,
           "subdiv_code"=> $location_details->subdiv_code,
           "cir_code"=> $location_details->cir_code,
           "mouza_pargona_code"=> $location_details->mouza_pargona_code,
           "lot_no"=> $location_details->lot_no,
           "vill_townprt_code"=> $location_details->vill_townprt_code,
           "village_uuid"=>  $_POST['village_uuid'],
           "patta_type_code"=> $_POST['patta_type_code'],
           "patta_no"=> $_POST['patta_no'],
           "dag_no"=> "",
           "pdar_id"=> null, 
           "pdar_name"=> null,
           "pdar_father_name"=> null,
           "payment_by"=> $_POST['paymentBy'],
           "payee_name"=> $_POST['payee_name'],
           "payee_contant_no"=> $_POST['payee_contact_no'],
           "payee_relation"=>$_POST['payee_relation'],
           "payee_email"=>$_POST['payee_email'],
           "created_at"=> date('Y-m-d h:i:s'),
           "modified_at"=> null,
           'user_code' => $this->session->all_userdata()['user_code']
        ];
        //jama_wasil_backup_data
        $jama_wasil_backup_table_data = [
           "data" => json_encode($_POST),
           "action" => JAMA_WASIL_ACTION_CO_ENTRY,
           'user_data' => json_encode($this->session->all_userdata()),
           'ip_address' => $this->session->all_userdata()['ip_address'],
           "created_at"=> date('Y-m-d h:i:s'),
        ];
        //**************checking-prev-entry********/
        //checking previous offline entry exits or not 
        $prevOfflineEntrytFlag = $this->EkhajanaCommonModel->checkPrevEntry($_POST['village_uuid'],$_POST['patta_no']);
        if($prevOfflineEntrytFlag == 1){
            //edited entry
            $jama_wasil_backup_table_data['action'] = JAMA_WASIL_ACTION_CO_ENTRY_UPDATE;
            $updateFlag = $this->CoArrearUpdateModel->updateCoArrearUpdateDetails($jama_wasil_data,
            $jama_wasil_payee_list_data,$jama_wasil_backup_table_data);
            echo json_encode($updateFlag);
            exit;
        }elseif($prevOfflineEntrytFlag > 1){
            //backend error, since more than two offline entry cant exists in jama wasil table
            echo json_encode(['result' => false, 'msg' => 'Server Error Occured..!']);
            exit;
        }else{
            //new entry
            $insertFlag = $this->CoArrearUpdateModel->insertCoArrearUpdateDetails($jama_wasil_data,
            $jama_wasil_payee_list_data,$jama_wasil_backup_table_data);
            echo json_encode($insertFlag);
            exit;
        }
        //******************************************/   
    }

    //co updated arrear view
    public function ViewUpdatedArrear(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //***************************************************/
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $updatedArrearList = $this->CoArrearUpdateModel->getUpdatedArrearPattaWise($dist_code, 
        $subdiv_code, $cir_code);
        $data['updated_arrear_list'] = $updatedArrearList;
        $data['_view'] = 'e_khajana/co_arrear_update/view_updated_arrear';
        $this->load->view('layouts/main',$data);
    }

    //co view updated arrear
    public function getArrearDetailsFromJWTid(){
       //***************chechink-user-designation**********/
       if($this->session->userdata('user_desig_code') != "CO"){
          echo json_encode("Not Authorised!!");
          exit;
       }
       //**************************************************/
       $jamawasil_transaction_id = $_POST['jama_wasil_transaction_id'];
       $arrear_details_from_id = $this->EkhajanaCommonModel->getArrearUpdateDetailsFromJWTid($jamawasil_transaction_id);
       echo json_encode($arrear_details_from_id);
    }

    //getting patta numbers 
    public function getPataNumbers(){
        $village_uuid = $_POST['village_uuid'];
        $patta_type_code = $_POST['patta_type_code'];
        $patta_numbers = $this->EkhajanaCommonModel->getPattaNumbers($village_uuid, $patta_type_code);
        echo json_encode($patta_numbers);
    }

    //geting current revenue and local tax
    public function getCurrentRevenueAndLocalTax(){
        $village_uuid = $_POST['village_uuid'];
        $patta_type_code = $_POST['patta_type_code'];
        $patta_no = $_POST['patta_no'];
        //echo json_encode("village_uuid ".$village_uuid. " patta-type-code ". $patta_type_code. " patta-no ".$patta_no);
        $revenueAndTax = $this->CoArrearUpdateModel->getCurrentRevenueAndLocalTaxFromDoul($village_uuid,$patta_type_code,$patta_no);
        echo json_encode($revenueAndTax);
    }

}