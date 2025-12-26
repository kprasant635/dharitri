<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CPMSAdcController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('form_validation');
        $this->dbswitch();
        $this->check_user_designation('ADC');
        $this->load->model('CPMS/CpmsModel');
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
    //checking user designation 
    public function check_user_designation($user_code){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != $user_code){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/    
    }
    //getting cpms details for adc
    public function getCPMSDetails(){
        $dist_code = $this->session->userdata('dist_code');
        $data['year'] = $year = date('Y');
        $data['consultant_code'] = $consultant_code = $this->CpmsModel->getConsultantCode($dist_code); 
        $data['consultant_name'] = $this->CpmsModel->getConsultantName($consultant_code);               
        $data['no_of_forms_completed'] = $this->CpmsModel->getNoOfFormsCompletionCount($consultant_code);
        $data['status'] = $this->CpmsModel->getCpmsStatus($consultant_code);
        $data['_view'] = 'pms/adc_views/cpms_details';
        $this->load->view('layouts/main',$data);
    }
    //evaluation of cpms 
    public function evaluate(){
        $dist_code = $this->session->userdata('dist_code');
        if ($dist_code == "05") { // Barpeta
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "39") { // Bajali
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "13") { // Bongaigaon
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "14") { // Golaghat
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "25") { // Dhemaji
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "08") { // Darrang
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "02") { // Dhubri
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "17") { // Dibrugarh
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "03") { // Goalpara
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "06") { // Nalbari
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "16") { // Sivasagar
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "11") { // Sonitpur
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "21") { // Karimganj
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "24") { // Kamrup Metropolitan
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "07") { // Kamrup
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "12") { // Lakhimpur
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "34") { // Majuli
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "32") { // Morigaon
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "33") { // Nagaon
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "36") { // Hojai
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "35") { // Biswanath
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "38") { // South Salmara-Mankachar
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "37") { // Charaideo
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "18") { // Tinsukia
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "15") { // Jorhat
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "22") { // Hailakandi
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "23") { // Cachar
            $data['baseSalary'] = 27000;
        } else {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => "Base Salary Not Found..!"]);
            exit;
        }
        $data['year'] = $year = date('Y');
        $data['consultant_code'] = $consultant_code = $this->CpmsModel->getConsultantCode($dist_code); 
        $data['cpms_verification_data'] = $this->CpmsModel->getCpmsVerificatiuonDetails($consultant_code);
        $data['evaluation_status'] = $this->CpmsModel->getCpmsEvaluationStaus($consultant_code);        
        // echo "<pre>"; 
        // var_dump($data['evaluation_status']);
        // echo "</pre>";
        // exit;
        $data['_view'] = 'pms/adc_views/cpms_evaluation';
        $this->load->view('layouts/main',$data);
    }
    //cpms verification marks submission handle 
    public function cpmsVerificationMarksSubmitHandle(){
        //***********************************************************/
        //valiation of cpms verified marks form 
        $error_msg = array();
        $cpms_verification_form_val = [
            [
                'field' => 'cpms_verified_marks_master_task_id_1',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(1)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_2',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(2)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_3',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(3)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_4',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(4)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_5',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(5)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_6',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(6)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_7',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(7)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_8',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(8)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_9',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(9)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
            [
                'field' => 'cpms_verified_marks_master_task_id_10',
                'label' => $this->CpmsModel->getCpmsMasterTaskName(10)->name,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric|less_than[11]'
            ],
        ];
        $this->form_validation->set_rules($cpms_verification_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($cpms_verification_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //*****************************************************************/
        //creating array with master task id and verified marks 
        $verified_marks_with_master_task_id_arr = [
            [
                'master_task_id' => 1,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_1']
            ],
            [
                'master_task_id' => 2,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_2']
            ],
            [
                'master_task_id' => 3,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_3']
            ],
            [
                'master_task_id' => 4,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_4']
            ],
            [
                'master_task_id' => 5,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_5']
            ],
            [
                'master_task_id' => 6,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_6']
            ],
            [
                'master_task_id' => 7,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_7']
            ],
            [
                'master_task_id' => 8,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_8']
            ],
            [
                'master_task_id' => 9,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_9']
            ],
            [
                'master_task_id' => 10,
                'verified_marks' => $_POST['cpms_verified_marks_master_task_id_10']
            ],
        ];
        //****************************************************
        //calculating final percentage 
        $total_percentage = 0;
        foreach($verified_marks_with_master_task_id_arr as $verified_marks_with_master_task_id){
            $total_percentage = $total_percentage+ $verified_marks_with_master_task_id['verified_marks'] * 10;
        }
        $overall_percentage = $total_percentage/10;
        if($overall_percentage < 60){
            $grade = 'C';
            $increment = 0;
            $increment_type = 'PERCENTAGE';
            $action = 'TERMINATE';
        }elseif($overall_percentage >=60 && $overall_percentage <70){
            $grade = 'B';
            $increment = 0;
            $increment_type = 'PERCENTAGE';
            $action = 'O';
        }elseif($overall_percentage >=70 && $overall_percentage <80){
            $grade = 'A-';
            $increment = 5;
            $increment_type = 'PERCENTAGE';
            $action = 'INCREMENT(5%)';
        }elseif($overall_percentage >=80 && $overall_percentage <90){            
            $grade = 'A';
            $increment = 8;
            $increment_type = 'PERCENTAGE';
            $action = 'INCREMENT(8%)';
        }elseif($overall_percentage >=90){
            $grade = 'A+';
            $increment = 10;
            $increment_type = 'PERCENTAGE';
            $action = 'INCREMENT(10%)';
        }

        $dist_code = $this->session->userdata('dist_code'); // Fetch district code from session
        if ($dist_code == "05") { // Barpeta
            $baseSalary = 27000;
        } elseif ($dist_code == "39") { // Bajali
            $baseSalary = 25000;
        } elseif ($dist_code == "13") { // Bongaigaon
            $baseSalary = 27000;
        } elseif ($dist_code == "14") { // Golaghat
            $baseSalary = 26250;
        } elseif ($dist_code == "25") { // Dhemaji
            $baseSalary = 26250;
        } elseif ($dist_code == "08") { // Darrang
            $baseSalary = 27000;
        } elseif ($dist_code == "02") { // Dhubri
            $baseSalary = 26250;
        } elseif ($dist_code == "17") { // Dibrugarh
            $baseSalary = 27500;
        } elseif ($dist_code == "03") { // Goalpara
            $baseSalary = 26250;
        } elseif ($dist_code == "06") { // Nalbari
            $baseSalary = 26250;
        } elseif ($dist_code == "16") { // Sivasagar
            $baseSalary = 27500;
        } elseif ($dist_code == "11") { // Sonitpur
            $baseSalary = 27500;
        } elseif ($dist_code == "21") { // Karimganj
            $baseSalary = 25000;
        } elseif ($dist_code == "24") { // Kamrup Metropolitan
            $baseSalary = 25000;
        } elseif ($dist_code == "07") { // Kamrup
            $baseSalary = 27000;
        } elseif ($dist_code == "12") { // Lakhimpur
            $baseSalary = 27000;
        } elseif ($dist_code == "34") { // Majuli
            $baseSalary = 26250;
        } elseif ($dist_code == "32") { // Morigaon
            $baseSalary = 26250;
        } elseif ($dist_code == "33") { // Nagaon
            $baseSalary = 27000;
        } elseif ($dist_code == "36") { // Hojai
            $baseSalary = 26250;
        } elseif ($dist_code == "35") { // Biswanath
            $baseSalary = 26250;
        } elseif ($dist_code == "38") { // South Salmara-Mankachar
            $baseSalary = 26250;
        } elseif ($dist_code == "37") { // Charaideo
            $baseSalary = 27000;
        } elseif ($dist_code == "18") { // Tinsukia
            $baseSalary = 27000;
        } elseif ($dist_code == "15") { // Jorhat
            $baseSalary = 25000;
        } elseif ($dist_code == "22") { // Hailakandi
            $baseSalary = 26250;
        } elseif ($dist_code == "23") { // Cachar
            $baseSalary = 27000;
        } else {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => "Base Salary Not Found..!"]);
            exit;
        }
        $revised_salary = $baseSalary + ($baseSalary*$increment)/100;
        $dist_code = $this->session->userdata('dist_code');
        $year = date('Y');
        $consultant_code = $this->CpmsModel->getConsultantCode($dist_code); 
        $cpms_result_array = [
            'user_code' => $consultant_code, 
            "verify_entry_user_code" => $this->session->all_userdata()['user_code'],      
            "verify_entry_user_data" => json_encode($this->session->all_userdata()),      
            "year" => $year,
            "total_verified_percentage" => $total_percentage, 
            "total_verified_score" => $total_percentage/10,
            "overall_percentage" => $overall_percentage,
            "grade" => $grade,
            "increment" => $increment, 
            "increment_type" => $increment_type,
            "action" => $action, 
            "reveised_salary" => $revised_salary,
            "created_at" => date('Y-m-d H:i:s')
        ];
        $verification_entry_flag = $this->CpmsModel->verificationDetailsEntry($consultant_code,$year,$cpms_result_array,$verified_marks_with_master_task_id_arr);
        echo json_encode($verification_entry_flag);
    }
    //report of the consultant 
    public function getCPMSreport($year){
        $dist_code = $this->session->userdata('dist_code');
        $consultant_code = $this->CpmsModel->getConsultantCode($dist_code); 
        $data['reportData'] = $this->CpmsModel->getCpmsReportUserWise($consultant_code);
        $data['consultant_name'] = $this->CpmsModel->getConsultantName($consultant_code);    
        $dist_code = $this->session->userdata('dist_code'); // Fetch district code from session
        if ($dist_code == "05") { // Barpeta
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "39") { // Bajali
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "13") { // Bongaigaon
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "14") { // Golaghat
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "25") { // Dhemaji
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "08") { // Darrang
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "02") { // Dhubri
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "17") { // Dibrugarh
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "03") { // Goalpara
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "06") { // Nalbari
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "16") { // Sivasagar
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "11") { // Sonitpur
            $data['baseSalary'] = 27500;
        } elseif ($dist_code == "21") { // Karimganj
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "24") { // Kamrup Metropolitan
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "07") { // Kamrup
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "12") { // Lakhimpur
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "34") { // Majuli
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "32") { // Morigaon
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "33") { // Nagaon
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "36") { // Hojai
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "35") { // Biswanath
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "38") { // South Salmara-Mankachar
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "37") { // Charaideo
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "18") { // Tinsukia
            $data['baseSalary'] = 27000;
        } elseif ($dist_code == "15") { // Jorhat
            $data['baseSalary'] = 25000;
        } elseif ($dist_code == "22") { // Hailakandi
            $data['baseSalary'] = 26250;
        } elseif ($dist_code == "23") { // Cachar
            $data['baseSalary'] = 27000;
        }else {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => "Base Salary Not Found..!"]);
            exit;
        }
        //echo json_encode($reportData);
        $data['_view'] = 'pms/adc_views/cpms_report';
        $this->load->view('layouts/main',$data);
    }
}

