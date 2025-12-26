<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaCFR extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/EkhajanaDc/EkhajanaDcModel');
        $this->load->model('eKhajana/EkhajanaCFR/EkhajanaCFRmodel');
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
        }  else if($this->session->userdata('dist_code') == "22"){
            $this->db=$this->load->database('dha41', TRUE);   
        }  else if($this->session->userdata('dist_code') == "23"){
            $this->db=$this->load->database('dha40', TRUE);   
        }
    }

    public function tnIndex(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != 'TN'){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['_view'] = 'e_khajana/cfr_views/tn_index'; 
        $this->load->view('layouts/main',$data);
    }

    public function updatCFRdetailsForm(){
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        //echo $data['dist_code'];exit;
        $data['circleList'] = $this->EkhajanaCFRmodel->getCircleListFromDistCode($dist_code);
        // echo "<pre>";
        // var_dump($circleList);
        // echo "</pre>";
        $data['_view'] = 'e_khajana/cfr_views/cfrDetailsUpdateForm';
        $this->load->view('layouts/main',$data);
    }

    //get all mouzas
    public function getAllMouzas()
    {
        $dist_code      = $_POST['dist_code'];
        $subdiv_code    = $_POST['subdiv_code'];
        $cir_code       = $_POST['cir_code'];
        $mouzas         = $this->EkhajanaCFRmodel->getAllMouzaName($dist_code,$subdiv_code,$cir_code);
        echo json_encode($mouzas);
    }

    public function forwardCFRdetailsToADC(){
        //validation error section
        $error_msg = array();
        $tn_branch_validation = [
            [
                'field' => 'circle',
                'label' => 'Circle',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'mouza',
                'label' => 'Mouza',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'cfr_book_number',
                'label' => 'CFR BOOK NUMBER',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean|integer'
            ],
            [
                'field' => 'no_of_cfr_pages_in_the_book',
                'label' => 'TOTAL NO OF CFR PAGES IN THE BOOK',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean|integer'
            ],
            [
                'field' => 'cfr_page_serial_no_start',
                'label' => 'CFR PAGE SERIAL NO-(START)',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean|integer'
            ],
            [
                'field' => 'cfr_page_serial_no_end',
                'label' => 'CFR PAGE SERIAL NO-(END)',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean|integer'
            ],
            [
                'field' => 'remarks',
                'label' => 'REMARK',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ]
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
        //**************************************************/        
        $expStr = explode("_",$_POST['mouza']);
        $dist_code=$expStr[0];
        $subdiv_code= $expStr[1];
        $cir_code= $expStr[2];
        $mouza_pargona_code= $expStr[3];
        $cfr_book_no=$_POST['cfr_book_number'];
        $total_cfr_pages =$_POST['no_of_cfr_pages_in_the_book'];
        $cfr_page_no_starts =$_POST['cfr_page_serial_no_start'];
        $cfr_page_no_ends =$_POST['cfr_page_serial_no_end'];
        $user_details = $this->session->userdata;
        //****************************************************/
        //page no check validation 
        if($total_cfr_pages != ($cfr_page_no_ends-$cfr_page_no_starts)+1){
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'No Of Pages Is Not Matched With The Serial Number Start And End. Kindly Enter The Data Properly']);
            exit;
        }
        //****************************************************/
        $checkdataExists = $this->EkhajanaCFRmodel->checkDuplicateData($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$cfr_book_no,
                                                                        $total_cfr_pages,$cfr_page_no_starts,$cfr_page_no_ends);
        if($checkdataExists['result'] == "SERVER-ERROR"){
            echo json_encode($checkdataExists); 
            exit; 
        }                                                                
        //insert data for cfr details 
        $insert_details_for_cfr_data = [
            "dist_code"                     => $dist_code = $_SESSION['credentials']["dist_code"],
            "subdiv_code"                   => $subdiv_code,
            "cir_code"                      => $cir_code,
            "mouza_pargona_code"            => $mouza_pargona_code,
            "cfr_book_number"               => $this->input->post('cfr_book_number'),
            "no_of_cfr_pages_in_the_book"   => $this->input->post('no_of_cfr_pages_in_the_book'),
            "cfr_page_serial_no_start"      => $this->input->post('cfr_page_serial_no_start'),
            "cfr_page_serial_no_end"        => $this->input->post('cfr_page_serial_no_end'),
            "entry_year"                    => date('Y'),
            "doul_year"                     => doul_year_no,
            "status"                        => 'P',
            "tn_user_details"               => json_encode($user_details),
            "tn_remarks"                    => $this->input->post('remarks'),
            "created_at"                    => date('Y-m-d H:i:s')
        ];

        $insert_details_for_cfr_transactions = [
            "dist_code"                     => $dist_code = $_SESSION['credentials']["dist_code"],
            "subdiv_code"                   => $subdiv_code,
            "cir_code"                      => $cir_code,
            "mouza_pargona_code"            => $mouza_pargona_code,
            "cfr_book_number"               => $this->input->post('cfr_book_number'),
            "no_of_cfr_pages_in_the_book"   => $this->input->post('no_of_cfr_pages_in_the_book'),
            "cfr_page_serial_no_start"      => $this->input->post('cfr_page_serial_no_start'),
            "cfr_page_serial_no_end"        => $this->input->post('cfr_page_serial_no_end'),
            "entry_year"                    => date('Y'),
            "doul_year"                     => doul_year_no,
            "status"                        => 'P',
            "tn_user_details"               => json_encode($user_details),
            "tn_posted_data"                => json_encode($_POST),
            "tn_remarks"                    => $this->input->post('remarks'),            
            "created_at"                    => date('Y-m-d H:i:s')            
        ];

        //**************************************************/      
        $insert_flag = $this->EkhajanaCFRmodel->insertCFRDetails($insert_details_for_cfr_data,$insert_details_for_cfr_transactions);
        echo json_encode($insert_flag);
    }

    public function viewCfrDetails(){
        $data['cfrDetails'] = $cfrDetails = $this->EkhajanaCFRmodel->getCfrDetailsDistWise();
        // echo "<pre>";
        // var_dump($cfrDetails);
        // echo "</pre>";
        $data['_view'] = 'e_khajana/cfr_views/cfrDetailsView';
        $this->load->view('layouts/main',$data);
    }

    public function viewCFRBookDetails($id)
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['cfrBookDetails'] = $this->EkhajanaCFRmodel->geCFRBookDetails($id);
        $data['_view'] = 'e_khajana/cfr_views/cfr_book_detail';
        $this->load->view('layouts/main',$data);

    }

    public function pendingCfrRecordsForAdc()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['allCfrBoooksDetails'] = $this->EkhajanaCFRmodel->getPendingCFRBooksDetails($dist_code);
        // echo "<pre>";
        // var_dump($data['allCfrBoooksDetails']);
        // exit;
        $data['_view'] = 'e_khajana/cfr_views/cfr_books_pending_list';
        $this->load->view('layouts/main',$data);

    }

    public function approveEcfrBook()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //validation error section
        $error_msg = array();
        $adc_validation = [
            [
                'field' => 'id',
                'label' => 'id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'adc_remarks',
                'label' => 'ADC remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($adc_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($adc_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $cfr_record_id = $this->input->post('id');
        $adc_remarks   =   $this->input->post('adc_remarks');
        $posted_data = $_POST;
        $updateApprove = $this->EkhajanaCFRmodel->approveEcfrBook($cfr_record_id,$adc_remarks,$posted_data);
        echo json_encode($updateApprove);
    }

    public function rejectCfrBook()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //validation error section
        $error_msg = array();
        $adc_validation = [
            [
                'field' => 'id',
                'label' => 'id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'adc_remarks',
                'label' => 'ADC remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'adc_reject_remarks',
                'label' => 'ADC reject remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($adc_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($adc_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $cfr_record_id      = $this->input->post('id');
        $adc_reject_remarks =  $this->input->post('adc_reject_remarks');
        $adc_remarks  = $this->input->post('adc_remarks');
        $posted_data = $_POST;
        $updateReject = $this->EkhajanaCFRmodel->rejectEcfrBook($cfr_record_id,$adc_remarks,$adc_reject_remarks,$posted_data);
        echo json_encode($updateReject);
    }

    public function approvedCfrRecordsForAdc(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['allCfrBoooksDetails'] = $this->EkhajanaCFRmodel->getApprovedCFRBooksDetails($dist_code);
        // echo "<pre>";
        // var_dump($data['allCfrBoooksDetails']);
        // exit;
        $data['_view'] = 'e_khajana/cfr_views/cfr_books_approved_list';
        $this->load->view('layouts/main',$data);
    }

    public function rejectedCfrRecordsForAdc(){        
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['allCfrBoooksDetails'] = $this->EkhajanaCFRmodel->getRejectedCFRBooksDetails($dist_code);
        // echo "<pre>";
        // var_dump($data['allCfrBoooksDetails']);
        // exit;
        $data['_view'] = 'e_khajana/cfr_views/cfr_books_rejected_list';
        $this->load->view('layouts/main',$data);
    }

}
