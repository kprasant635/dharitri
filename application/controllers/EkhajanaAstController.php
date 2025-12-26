<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaAstController extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->model('eKhajana/EkhajanaAST/EkhajanaAstModel');
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
        if($this->session->userdata('user_desig_code') != "AST"){
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
        // echo "Ekhajana Co COntroller <br>Dist-Code : ".$dist_code."<br>Subdiv-Code : "
        //      .$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['pendingCount'] = $this->EkhajanaAstModel->pendingForAstCount($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/ast_views/index';
        $this->load->view('layouts/main',$data);
    }

    //displaying pending list for ast
    public function pendingList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        // echo "Ekhajana Co COntroller <br>Dist-Code : ".$dist_code."<br>Subdiv-Code : "
        //      .$subdiv_code."<br>Circle-Code : ".$cir_code;
        // exit;
        $data['pendingList'] = $this->EkhajanaAstModel->pendingListForAst($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/ast_views/pending_list';
        $this->load->view('layouts/main',$data);
    }

    //displaying due payment form 
    public function arrearUpdateForm($ek_basic_id){
        
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        //checking doul existance
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');        
        $doulExistsFlag = $this->EkhajanaDoulModel->checkDoulExists($dist_code,$subdiv_code,$cir_code);
        if(!$doulExistsFlag){
            $data['_view'] = 'e_khajana/ast_views/doul_error_page';
            $this->load->view('layouts/main',$data);   
            return;
        }
        $doulApproveFlag = $this->EkhajanaDoulModel->checkDoulApprove($dist_code,$subdiv_code,$cir_code);
        if(!$doulApproveFlag){
            $data['_view'] = 'e_khajana/ast_views/doul_error_page';
            $this->load->view('layouts/main',$data);   
            return;
        }
        //getting current revenue and local tax
        $data['ekBasicDetails'] = $ekBasicDetails = $this->EkhajanaAstModel->getEkBasicDetailsFromId($ek_basic_id);
        if(!$ekBasicDetails){
            echo json_encode("Some Error Occured, Error Code : EKABNA0001");
            exit;
        }
        //checking whether jama wasil is already updated or not for this patta 
        $checkJamaWasilStatus = $this->EkhajanaAstModel->checkJamaWasilStatus($ekBasicDetails);
        if($checkJamaWasilStatus == "jamawasil_updated"){
            $data['_view'] = 'e_khajana/ast_views/ast_jamawasil_exists_form';
            $this->load->view('layouts/main',$data);
            return;
        }

        $dist_code = $ekBasicDetails->dist_code;
        $subdiv_code = $ekBasicDetails->subdiv_code;
        $cir_code = $ekBasicDetails->cir_code;
        $mouza_pargona_code = $ekBasicDetails->mouza_pargona_code;
        $lot_no = $ekBasicDetails->lot_no;
        $vill_townprt_code = $ekBasicDetails->vill_townprt_code;
        $village_uuid = $ekBasicDetails->village_uuid;
        $patta_type_code = $ekBasicDetails->patta_type_code;
        $patta_no = $ekBasicDetails->patta_no;

        if (EKHAJANA_AST_PRE_ARREAR_UPDATE == 1):
        $data['total_arrear'] = $total_arrear =  $this->EkhajanaAstModel->getTotalArrear($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no); 
        // var_dump($data['total_arrear']);
        // exit; 
        
        if($total_arrear =="not_updated"){            
            $data['ek_land_details'] = $this->EkhajanaAstModel->getEkBasicDetailsFromId($ek_basic_id);
            $data['_view'] = 'e_khajana/ast_views/arrear_not_found';
            $this->load->view('layouts/main',$data);   
            return;
        }
        endif; 


        $currentDoulDemand = $this->EkhajanaAstModel->getCurrentRevenueAndLocalTaxFromDoul($village_uuid,$patta_type_code,$patta_no);        
        if(!$currentDoulDemand['flag']){
            $data['doul_entry_flag'] = false;
        }else{
            $data['doul_entry_flag'] = true;
        }
        $data['current_revenue'] = $currentDoulDemand['result']->dag_revenue;
        $data['current_local_tax'] = $currentDoulDemand['result']->dag_local_tax;
        $data['current_doul_year'] = $currentDoulDemand['result']->year_no;
        //payee relations
        $data['payee_relations'] = $this->EkhajanaCommonModel->getGuardianRelations();
        $data['_view'] = 'e_khajana/ast_views/ast_arrear_update_form';
        $this->load->view('layouts/main',$data);
    }

    //arrear update form submit handle 
    public function arrearUpdateFormSubmit(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
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
                'field' => 'ek_basic_id',
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
                //check if 26 nos of pre arrear rows are present before disposing the application
                $ekh_year_wise_arr_query = $this->db->query("select * from ekhajana_year_wise_arrear where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and application_under ='TEHSILDAR' and year_arrear is not null order by revenue_year desc", array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']));

                $ekh_year_wise_arr_count = $ekh_year_wise_arr_query->num_rows(); 
                $last_row = $ekh_year_wise_arr_query->result()[0]->revenue_year;
                if($last_row =='2024' && $ekh_year_wise_arr_count =='25'){

                    echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Arrear Of last revenue year has not been updated, Please update it through the pre-arrear update Module']);
                    exit;
                } 
            }else{
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Doul For The Current Revenue Year Has Not Been Approved From DC, Hence application cannot be forwarded..!!']);
                exit;
            }
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
        //getting ek basic details from id 
        $ekBasicDetails = $this->EkhajanaAstModel->getEkBasicDetailsFromId($_POST['ek_basic_id']);
        if(!$ekBasicDetails){
            echo json_encode("Some Error Occured, Error Code : EKABNA0001");
            exit;
        }
        //financial_year
        if (date('m') <= 6) {
              $financial_year = (date('Y')-1) . '-' . date('Y');
        } else {
              $financial_year = date('Y') . '-' . (date('Y') + 1);
        }
        $financial_year = ekhajana_financial_year;
        //jama_wasil_table_data_array
        $jama_wasil_data = [
           "dist_code" => $ekBasicDetails->dist_code,
           "subdiv_code" => $ekBasicDetails->subdiv_code,
           "cir_code" => $ekBasicDetails->cir_code,
           "mouza_pargona_code" => $ekBasicDetails->mouza_pargona_code,
           "lot_no" => $ekBasicDetails->lot_no,
           "vill_townprt_code" => $ekBasicDetails->vill_townprt_code,
           "village_uuid" => $ekBasicDetails->village_uuid,
           "patta_type_code" => $ekBasicDetails->patta_type_code,
           "patta_no" =>  $ekBasicDetails->patta_no,
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
           "dol_year_no" => $_POST['current_doul_year'],
           "pdar_id" => $ekBasicDetails->pdar_id, 
           "pdar_name" =>  $ekBasicDetails->pdar_name,
           "pdar_father_name" => $ekBasicDetails->pdar_father_name,
           "status" => JAMA_WASIL_STATUS_OFFLINE, 
           "created_at" => date('Y-m-d h:i:s'),
           "modified_at" => null,
           'user_code' => $this->session->all_userdata()['user_code'],
           "application_no" => $_POST['application_no'],
           "ld_application_no" => $_POST['ld_application_no'],
           "case_no" => $_POST['case_no'],
           "pay_status" => JAMA_WASIL_STATUS_UNPAID
        ];
        //jama_wasil_payee_list_data
        $jama_wasil_payee_list_data = [
            "dist_code" => $ekBasicDetails->dist_code,
            "subdiv_code" => $ekBasicDetails->subdiv_code,
            "cir_code" => $ekBasicDetails->cir_code,
            "mouza_pargona_code" => $ekBasicDetails->mouza_pargona_code,
            "lot_no" => $ekBasicDetails->lot_no,
            "vill_townprt_code" => $ekBasicDetails->vill_townprt_code,
            "village_uuid" => $ekBasicDetails->village_uuid,
            "patta_type_code" => $ekBasicDetails->patta_type_code,
            "patta_no" =>  $ekBasicDetails->patta_no,
            "dag_no"=> "",
            "pdar_id"=> $ekBasicDetails->pdar_id, 
            "pdar_name"=> $ekBasicDetails->pdar_name,
            "pdar_father_name"=> $ekBasicDetails->pdar_father_name,
            "payment_by"=> $_POST['paymentBy'],
            "payee_name"=> $_POST['payee_name'],
            "payee_contant_no"=> $_POST['payee_contact_no'],
            "payee_relation"=>$_POST['payee_relation'],
            "payee_email"=>$_POST['payee_email'],
            "created_at"=> date('Y-m-d h:i:s'),
            "modified_at"=> null,
            'user_code' => $this->session->all_userdata()['user_code'],
            "application_no" => $_POST['application_no'],
            "ld_application_no" => $_POST['ld_application_no'],
            "case_no" => $_POST['case_no']
        ];
        //jama_wasil_backup_data
        $jama_wasil_backup_table_data = [
           "data" => json_encode($_POST),
           "action" => JAMA_WASIL_ACTION_AST_ENTRY,
           'user_data' => json_encode($this->session->all_userdata()),
           'ip_address' => $this->session->all_userdata()['ip_address'],
           "created_at"=> date('Y-m-d h:i:s'),
           "application_no" => $_POST['application_no'],
           "ld_application_no" => $_POST['ld_application_no'],
           "case_no" => $_POST['case_no']
        ];
        //**************checking-prev-entry********/
        $insertFlag = $this->EkhajanaAstModel->insertAstArrearUpdateDetails($jama_wasil_data,
        $jama_wasil_payee_list_data,$jama_wasil_backup_table_data,$ekBasicDetails);
        echo json_encode($insertFlag);
        
    }

    // jama wasil already exists case dispose handle
    public function jwExistsCaseDispose(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $ek_details_id = $_POST['ek_details_id'];
        //getting ek basic details from id 
        $ekBasicDetails = $this->EkhajanaAstModel->getEkBasicDetailsFromId($ek_details_id);
        if(!$ekBasicDetails){
            echo json_encode("Some Error Occured, Error Code : EKABNA0001");
            exit;
        }
        $disposeFlag = $this->EkhajanaAstModel->jwExistsCaseForward($ekBasicDetails);
        echo json_encode($disposeFlag);
    }

    // Forwarding the reverted case to the CO
    public function UpdateRevertCase(){ 
        $ekUpdateData = $_POST;
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //*****************validation*************/
        $error_msg = array();
        $arrear_update_form_val = [
            [
                'field' => 'ek_basic_id',
                'label' => 'Ekhajana Basic Id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'land details application_no',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'case_no',
                'label' => 'case_no',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'remark',
                'label' => 'Remark',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'patta_no',
                'label' => 'PATTA NO',
                'rules' => 'required|callback_check_script|trim|xss_clean'
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
       

        $revertUpdatedData = $this->EkhajanaAstModel->UpdateRevertCase($ekUpdateData);
        echo json_encode($revertUpdatedData);

    }

    //*****************************NEW CODES***********************

    public function pre_arrear_index()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['_view'] = 'e_khajana/ast_views/pre_arrear_index'; 
        $this->load->view('layouts/main',$data); 
    }

    public function preArrearUpdateForm()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['subdiv_code']    = $subdiv_code  = $this->session->userdata('subdiv_code');
        $data['cir_code']       = $cir_code     = $this->session->userdata('cir_code');
        $data['mouzas']         = $mouza        = $this->EkhajanaAstModel->getAllMouzaName($dist_code,$subdiv_code,$cir_code);
        $data['_view']          = 'e_khajana/ast_views/preArrearUpdateFrom';
        $this->load->view('layouts/main',$data);
    }

    public function getAllLots()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lots               = $this->EkhajanaAstModel->getAllLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code);
        echo json_encode($lots);
    }

    public function getAllVillages()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lot_no             = $_POST['lot_no'];
        $villages           = $this->EkhajanaAstModel->getAllVillagesName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
        echo json_encode($villages);
    }

    public function getPattaTypes()
    {
        $patta_types = $this->EkhajanaAstModel->getPattaType();
        echo json_encode($patta_types);
    }

    public function getPattaNo()
    {
        $dist_code          = $_POST['dist_code'];
        $subdiv_code        = $_POST['subdiv_code'];
        $cir_code           = $_POST['cir_code'];
        $mouza_pargona_code = $_POST['mouza_pargona_code'];
        $lot_no             = $_POST['lot_no'];
        $vill_townprt_code  = $_POST['vill_townprt_code'];
        $patta_type_code    = $_POST['patta_type_code'];
        $patta_types = $this->EkhajanaAstModel->getPattaNo($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code);
        echo json_encode($patta_types);
    }

    public function submitArrear($autoYear = null)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $posted_data = $_POST;
        $data['dist_code']              = $posted_data['dist_code'];
        $data['subdiv_code']            = $posted_data['subdiv_code'];
        $data['cir_code']               = $posted_data['cir_code'];
        $data['mouza_pargona_code']     = $posted_data['mouza_pargona_code'];
        $data['lot_no']                 = $posted_data['lots'];
        $data['vill_townprt_code']      = $posted_data['villages'];
        $data['patta_type_code']        = $posted_data['patta_type_code'];
        $data['patta_no']               = $posted_data['patta_no'];
        // $data['arch_doul_2025']         = $this->EkhajanaAstModel->get2025ArchiveDouldata($data['dist_code'],$data['subdiv_code'],$data['cir_code'],
        //                                         $data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code'],$data['patta_type_code'],$data['patta_no']);

        $autoYear = $autoYear ?? $this->input->get('autoYear');
        $data['is_auto_year'] = $autoYear;
        $data['_view'] = 'e_khajana/ast_views/insertArrear';
        $this->load->view('layouts/main',$data);
    }

    public function submitInsertedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $posted_data = $_POST;
        $years = $_POST['years'];
        $arear = $_POST['arrear'];
        $tax = $_POST['tax'];
        $revenue = $_POST['revenue'];
        //$miran = $_POST['miran'];
        $data = [];
        foreach($arear as $key=>$arrearvalue) 
        {                 
            $data[$key]['year'] = $years[$key];
            $data[$key]['revenue'] = $revenue[$key];
            $data[$key]['tax'] = $tax[$key];
            //$data[$key]['miran'] = $miran[$key];
            $data[$key]['arear'] = $arrearvalue;
        }

        foreach($data as $arr_row){            

            if($arr_row['revenue'] != '' || $arr_row['tax'] != '' || $arr_row['revenue'] != null || $arr_row['tax'] != null ){
                if($arr_row['year'] == '' || $arr_row['year'] == null || $arr_row['revenue'] == '' || $arr_row['revenue'] == null
                || $arr_row['tax'] == '' || $arr_row['tax'] == null || $arr_row['arear'] == '' || $arr_row['arear'] == null){
                    echo json_encode(['result' => 'INPUT-ERROR', 'msg' => 'Some fields missing for the year '.$arr_row['year']. ', kindly insert properly..!!']);
                    exit;
                } 
            }
                       
        }
        $ekArrearPreUpdateFlag = $this->EkhajanaAstModel->insertPreArrearData($posted_data,$data);
        echo json_encode($ekArrearPreUpdateFlag);
    }

    public function viewPreUpdatedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['subdiv_code']    = $subdiv_code  = $this->session->userdata('subdiv_code');
        $data['cir_code']       = $cir_code     = $this->session->userdata('cir_code');
        $data['all_pre_arrear_list'] = $this->EkhajanaAstModel->getPreUpdatedList($dist_code,$subdiv_code,$cir_code);
        $data['_view']          = 'e_khajana/ast_views/preArrearUpdatedList';
        $this->load->view('layouts/main',$data); 
    }

    public function editPreUpdatedArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['subdiv_code']    = $subdiv_code  = $this->session->userdata('subdiv_code');
        $data['cir_code']       = $cir_code     = $this->session->userdata('cir_code');
        $data['edit_pre_arrear_list'] = $this->EkhajanaAstModel->getPreUpdatedListForEdit($dist_code,$subdiv_code,$cir_code);
        $data['_view']          = 'e_khajana/ast_views/preArrearEditList';
        $this->load->view('layouts/main',$data); 
    }

    public function viewYearWiseArrear($pre_arrear_id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['subdiv_code']    = $subdiv_code  = $this->session->userdata('subdiv_code');
        $data['cir_code']       = $cir_code     = $this->session->userdata('cir_code');
        $year_wise_arrear = $this->EkhajanaAstModel->getYearWiseArrear($pre_arrear_id);
        if($year_wise_arrear['flag'] =='N')
        {
            echo "Year Wise Arrear Not Found, Kindly Contact System Administrator";
            exit;  
        }
        $data['year_wise_arrear'] = $year_wise_arrear['msg'];
        $data['_view']          = 'e_khajana/ast_views/yearWiseArrearView';
        $this->load->view('layouts/main',$data); 
    }

    public function editYearWiseArrear($pre_arrear_id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'AST'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code']      = $dist_code    = $this->session->userdata('dist_code');
        $data['subdiv_code']    = $subdiv_code  = $this->session->userdata('subdiv_code');
        $data['cir_code']       = $cir_code     = $this->session->userdata('cir_code');
        $year_wise_arrear = $this->EkhajanaAstModel->getYearWiseArrear($pre_arrear_id);
        if($year_wise_arrear['flag'] =='N')
        {
            echo "Year Wise Arrear Not Found, Kindly Contact System Administrator";
            exit;  
        }
        $data['year_wise_arrear'] = $year_wise_arrear['msg'];
        $data['_view']          = 'e_khajana/ast_views/yearWiseArrearEdit';
        $this->load->view('layouts/main',$data); 
    }

    public function submitEditArrear()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "AST"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        // echo "<pre>";
        // var_dump($_POST);
        // exit;
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
        $total_arrear = $_POST['total_arrear'];
        $year_revenue = $_POST['year_revenue'];
        $year_tax = $_POST['year_tax'];
        $year_arrear = $_POST['year_arrear'];
        $update_array = array();

        $previous_arrears = array();
        $years_arr = array();
        $revenue_arr = array();
        $tax_arr = array();
        $arrear_arr = array();

        $total_revenue_db = 0;
        $total_tax_db = 0;
        $total_arrear_db = 0;

        foreach($year_revenue as $year=>$revenue) 
        {         
            //validations 
            if($revenue + $year_tax[$year] != $year_arrear[$year])
            { 

                echo json_encode(['result' => 'validation_error', 'msg' => ["Sum of Revenue and local tax is not matching with total arrear value"]]);
                exit;  
            }
            //revenue and local tx addition should be same as the key value arrear          
            array_push($update_array, [
                "financial_year"    => $year,
                "revenue"           => $revenue,
                "tax"               => $year_tax[$year],
                "arrear"            => $year_arrear[$year],
                "pre_arrear_id"     => $pre_arrear_id,
                "total_tax"         => $total_tax, 
                "total_revenue"     => $total_revenue, 
                "total_arrear"      => $total_arrear
            ]);
            //creating the previous arrear fileds arrays 
            array_push($years_arr, $year);
            array_push($revenue_arr,$revenue);
            array_push($tax_arr, $year_tax[$year]);
            array_push($arrear_arr, $year_arrear[$year]);
            //for logical validation of the arrears, tax and revenue with total 
            $total_revenue_db = $total_revenue_db+$revenue;
            $total_tax_db = $total_tax_db+$year_tax[$year];
            $total_arrear_db = $total_arrear_db+$year_arrear[$year];  
        }
        //testing 
        //echo "db-".$total_revenue_db. "post-". $total_revenue; exit;
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
        // Checking arrear total if mismatching
        if($total_arrear_db != $total_arrear){
            echo json_encode(['result' => 'validation_error', 'msg' => ["Mismatch In Total Arrear, Kindly re-enter"]]);
            exit;  
        }


        //creating the previous arrear 
        $previous_arrears['years'] = $years_arr;
        $previous_arrears['revenue'] = $revenue_arr;
        $previous_arrears['tax'] = $tax_arr;
        $previous_arrears['arrear'] = $arrear_arr;
        $previous_arrears['total_revenue'] = $total_revenue;
        $previous_arrears['total_tax'] = $total_tax;
        $previous_arrears['total_arrear'] = $total_arrear;

        $this->db->trans_begin();
        $insertTransactions = $this->EkhajanaAstModel->insertArrearTransactiondata($pre_arrear_id);
        if($insertTransactions['result'] =="SERVER-ERROR"){
            echo json_encode($insertTransactions);
            exit;
        }
        $updatePreArrearUpdation =$this->EkhajanaAstModel->updatePreArrearUpdation($pre_arrear_id,$update_array,$previous_arrears);
        if($updatePreArrearUpdation['result'] =="SERVER-ERROR"){
            echo json_encode($updatePreArrearUpdation);
            exit;
        }else{
            $this->db->trans_commit();
            echo json_encode($updatePreArrearUpdation);
        }
    }
}