<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CPMSController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('form_validation');
        $this->dbswitch();
        $this->check_user_designation('DCN');
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

    //index method 
    public function getPMSForm(){
        $data['cpmsMaster'] = $cpmsMatrix = $this->CpmsModel->getCpmsMasterTasks();
        $user_code = $this->session->all_userdata()['user_code'];
        $year = date('Y');        
        //************************************************************/
        $completionFlag = $this->CpmsModel->checkFormCompletion($user_code,$year);

        // echo "<pre>";
        // var_dump($completionFlag);
        // echo "</pre>";
        // exit;

        if($completionFlag == "already_submitted"){
            $data['forward_to_adc_flag'] = false;
            $data['forward_to_adc_flag_message'] = "CPMS Forms Submitted To ADC";
        }else if($completionFlag == "forms_not_completed"){
            $data['forward_to_adc_flag'] = false;
            $data['forward_to_adc_flag_message'] = "All The Forms Are Not Submitted Yet";
        }else if($completionFlag == "completed_and_not_submitted"){
            $data['forward_to_adc_flag'] = true;
            $data['forward_to_adc_flag_message'] = "";
        }
        //************************************************************/        
        $data['_view'] = 'pms/pms_form';
        $this->load->view('layouts/main',$data);
    }

    public function getJsonForDb(){
        $ui_json = [
            'new_row' => 'Y',
            'end_row' => 'N',
            'calc_field_after' => 'Y'
        ];

        echo json_encode($ui_json);
    }

    //handling submisiion of task 1 from 
    public function task_1_submit_handle(){
        //*****************************************************/
        //valiation of task 1 
        $error_msg = array();
        $task_1_form_val = [
            [
                'field' => 'task_1_subtask_id_1',
                'label' => $this->CpmsModel->getSubtaskNameFromId(1),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_2',
                'label' => $this->CpmsModel->getSubtaskNameFromId(2),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_3',
                'label' => $this->CpmsModel->getSubtaskNameFromId(3),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_4',
                'label' => $this->CpmsModel->getSubtaskNameFromId(4),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_5',
                'label' => $this->CpmsModel->getSubtaskNameFromId(5),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_6',
                'label' => $this->CpmsModel->getSubtaskNameFromId(6),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_evaluation_id_t1s12',
                'label' => $this->CpmsModel->getSubtaskNameFromId(1). " and ".$this->CpmsModel->getSubtaskNameFromId(2). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_evaluation_id_t1s34',
                'label' => $this->CpmsModel->getSubtaskNameFromId(3). " and ".$this->CpmsModel->getSubtaskNameFromId(4). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_evaluation_id_t1s56',
                'label' => $this->CpmsModel->getSubtaskNameFromId(5). " and ".$this->CpmsModel->getSubtaskNameFromId(6). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_1',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]
            
        ];
        $this->form_validation->set_rules($task_1_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_1_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_1'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 24) == "task_1_evaluation_id_t1s"){
                $subtask_arr =str_split(substr($key,24,26));
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0],
                    "subtask_id_value" => $_POST['task_1_subtask_id_'.$subtask_arr[0]],
                    "related_subtask_id" => $subtask_arr[1],
                    "related_subtask_id_value"=> $_POST['task_1_subtask_id_'.$subtask_arr[1]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE'
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_1'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_1'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        //inserting task 1 details 
        $task_1_insertion_flag = $this->CpmsModel->insertTask1Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_1_insertion_flag);
    }

    //handling submission of task 3 from 
    public function task_3_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************/
        //valiation of task 3
        $error_msg = array();
        $task_3_form_val = [
            [
                'field' => 'task_3_subtask_id_13',
                'label' => $this->CpmsModel->getSubtaskNameFromId(13),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_3_subtask_id_14',
                'label' => $this->CpmsModel->getSubtaskNameFromId(14),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_3_subtask_id_15',
                'label' => $this->CpmsModel->getSubtaskNameFromId(15),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_subtask_id_16',
                'label' => $this->CpmsModel->getSubtaskNameFromId(16),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_subtask_id_17',
                'label' => $this->CpmsModel->getSubtaskNameFromId(17),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_subtask_id_18',
                'label' => $this->CpmsModel->getSubtaskNameFromId(18),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_evaluation_id_t1s1314',
                'label' => $this->CpmsModel->getSubtaskNameFromId(13). " and ".$this->CpmsModel->getSubtaskNameFromId(14). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_evaluation_id_t1s1516',
                'label' => $this->CpmsModel->getSubtaskNameFromId(15). " and ".$this->CpmsModel->getSubtaskNameFromId(16). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_3_evaluation_id_t1s1718',
                'label' => $this->CpmsModel->getSubtaskNameFromId(17). " and ".$this->CpmsModel->getSubtaskNameFromId(18). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_3',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]
            
        ];
        $this->form_validation->set_rules($task_3_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_3_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_3'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 24) == "task_3_evaluation_id_t1s"){
                $subtask_arr =str_split(substr($key,24,26));                
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_3_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_3_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE'
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_3'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_3'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_3_insertion_flag = $this->CpmsModel->insertTask3Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_3_insertion_flag);
    }

    //handling submission of task 8 form 
    public function task_8_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************************/
        //valiation of task 8
        $error_msg = array();
        $task_8_form_val = [
            [
                'field' => 'task_8_subtask_id_32',
                'label' => $this->CpmsModel->getSubtaskNameFromId(32),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_8_subtask_id_33',
                'label' => $this->CpmsModel->getSubtaskNameFromId(33),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_8_subtask_id_34',
                'label' => $this->CpmsModel->getSubtaskNameFromId(34),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_subtask_id_35',
                'label' => $this->CpmsModel->getSubtaskNameFromId(35),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_subtask_id_36',
                'label' => $this->CpmsModel->getSubtaskNameFromId(36),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_subtask_id_37',
                'label' => $this->CpmsModel->getSubtaskNameFromId(37),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_evaluation_id_t8s3233',
                'label' => $this->CpmsModel->getSubtaskNameFromId(32). " and ".$this->CpmsModel->getSubtaskNameFromId(33). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_evaluation_id_t8s3435',
                'label' => $this->CpmsModel->getSubtaskNameFromId(34). " and ".$this->CpmsModel->getSubtaskNameFromId(35). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_8_evaluation_id_t8s3637',
                'label' => $this->CpmsModel->getSubtaskNameFromId(36). " and ".$this->CpmsModel->getSubtaskNameFromId(37). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_8',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]
            
        ];
        $this->form_validation->set_rules($task_8_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_8_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_8'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 24) == "task_8_evaluation_id_t8s"){
                $subtask_arr =str_split(substr($key,24,26));                
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_8_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_8_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE'
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_8'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_8'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_8_insertion_flag = $this->CpmsModel->insertTask8Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_8_insertion_flag);
    }

    //handling submission of task 7 
    public function task_7_submit_handle(){        
        //*****************************************************************/
        //valiation of task 8
        $error_msg = array();
        $task_7_form_val = [
            [
                'field' => 'task_7_subtask_id_30',
                'label' => $this->CpmsModel->getSubtaskNameFromId(30),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_7_subtask_id_31',
                'label' => $this->CpmsModel->getSubtaskNameFromId(31),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_7_evaluation_id_t7s3031',
                'label' => $this->CpmsModel->getSubtaskNameFromId(30). " and ".$this->CpmsModel->getSubtaskNameFromId(31). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_7',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_7_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_7_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_7'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 24) == "task_7_evaluation_id_t7s"){
                $subtask_arr =str_split(substr($key,24,26));                
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_7_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_7_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE'                    
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_7'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_7'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_7_insertion_flag = $this->CpmsModel->insertTask7Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_7_insertion_flag);
    }

    //handling submission of task 9
    public function task_9_submit_handle(){
        //*****************************************************************/
        //valiation of task 9
        $error_msg = array();
        $task_9_form_val = [ 
            [
                'field' => 'task_9_subtask_id_38',
                'label' => $this->CpmsModel->getSubtaskNameFromId(38),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_9_subtask_id_39',
                'label' => $this->CpmsModel->getSubtaskNameFromId(39),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_9_evaluation_id_t9s3839',
                'label' => $this->CpmsModel->getSubtaskNameFromId(38). " and ".$this->CpmsModel->getSubtaskNameFromId(39). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_9',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_9_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_9_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_9'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 24) == "task_9_evaluation_id_t9s"){
                $subtask_arr =str_split(substr($key,24,26));                
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_9_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_9_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE'     
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_9'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_9'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_9_insertion_flag = $this->CpmsModel->insertTask9Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_9_insertion_flag);
    }

    //handling submission of task 10
    public function task_10_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************************/
        //valiation of task 10
        $error_msg = array();
        $task_10_form_val = [ 
            [
                'field' => 'task_10_subtask_id_40',
                'label' => $this->CpmsModel->getSubtaskNameFromId(40),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_10_subtask_id_41',
                'label' => $this->CpmsModel->getSubtaskNameFromId(41),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_10_evaluation_id_t10s4041',
                'label' => $this->CpmsModel->getSubtaskNameFromId(40). " and ".$this->CpmsModel->getSubtaskNameFromId(41). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_10',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_10_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_10_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_10'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask 
            if(substr($key, 0, 26) == "task_10_evaluation_id_t10s"){
                $subtask_arr =str_split(substr($key,26,28));                              
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_10_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_10_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE' 
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_10'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_10'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_10_insertion_flag = $this->CpmsModel->insertTask10Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_10_insertion_flag);
    }

    //handling submission of task 5 
    public function task_5_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************************/
        //valiation of task 5
        $error_msg = array();
        $task_5_form_val = [ 
            [
                'field' => 'task_5_subtask_id_22',
                'label' => $this->CpmsModel->getSubtaskNameFromId(22),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_id_23',
                'label' => $this->CpmsModel->getSubtaskNameFromId(23),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_id_24',
                'label' => $this->CpmsModel->getSubtaskNameFromId(24),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_id_25',
                'label' => $this->CpmsModel->getSubtaskNameFromId(25),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_result_id_22',
                'label' => $this->CpmsModel->getSubtaskNameFromId(22). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_result_id_23',
                'label' => $this->CpmsModel->getSubtaskNameFromId(23). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_result_id_24',
                'label' => $this->CpmsModel->getSubtaskNameFromId(24). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_5_subtask_result_id_25',
                'label' => $this->CpmsModel->getSubtaskNameFromId(25). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'average_marks_achieved_task_5',
                'label' => "Average Percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_5',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_5_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_5_form_val as $rule){
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
        // cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_5'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask             
            if(substr($key, 0, 25) == "task_5_subtask_result_id_"){
                $subtask_id =substr($key,25,27);    
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_id,
                    "subtask_id_value" => $_POST['task_5_subtask_id_'.$subtask_id],
                    "related_subtask_id" => $subtask_id,
                    "related_subtask_id_value"=> $_POST['task_5_subtask_id_'.$subtask_id],
                    "subtask_result" => $_POST['task_5_subtask_result_id_'.$subtask_id],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'YES-NO' 
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_5'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_5'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_5_insertion_flag = $this->CpmsModel->insertTask5Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_5_insertion_flag);
    }

    //handling submission of task 5 
    public function task_6_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************************/
        //valiation of task 6
        $error_msg = array();
        $task_6_form_val = [ 
            [
                'field' => 'task_6_subtask_id_26',
                'label' => $this->CpmsModel->getSubtaskNameFromId(26),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_id_27',
                'label' => $this->CpmsModel->getSubtaskNameFromId(27),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_id_28',
                'label' => $this->CpmsModel->getSubtaskNameFromId(28),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_id_29',
                'label' => $this->CpmsModel->getSubtaskNameFromId(29),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_result_id_26',
                'label' => $this->CpmsModel->getSubtaskNameFromId(26). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_result_id_27',
                'label' => $this->CpmsModel->getSubtaskNameFromId(27). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_result_id_28',
                'label' => $this->CpmsModel->getSubtaskNameFromId(28). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_6_subtask_result_id_29',
                'label' => $this->CpmsModel->getSubtaskNameFromId(29). " percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'average_marks_achieved_task_6',
                'label' => "Average Percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_6',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_6_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_6_form_val as $rule){
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
        // cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_6'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask             
            if(substr($key, 0, 25) == "task_6_subtask_result_id_"){
                $subtask_id =substr($key,25,27);    
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_id,
                    "subtask_id_value" => $_POST['task_6_subtask_id_'.$subtask_id],
                    "related_subtask_id" => $subtask_id,
                    "related_subtask_id_value"=> $_POST['task_6_subtask_id_'.$subtask_id],
                    "subtask_result" => $_POST['task_6_subtask_result_id_'.$subtask_id],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'YES-NO' 
                ]);
            }
        }
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_6'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_6'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_6_insertion_flag = $this->CpmsModel->insertTask6Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_6_insertion_flag);
    }

    //handling task 2 form 
    public function task_2_submit_handle(){
        //*****************************************************************/
        //valiation of task 2
        $error_msg = array();
        $task_2_form_val = [ 
            [
                'field' => 'task_2_subtask_id_7',
                'label' => $this->CpmsModel->getSubtaskNameFromId(7),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_2_subtask_id_8',
                'label' => $this->CpmsModel->getSubtaskNameFromId(8),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_2_subtask_id_9',
                'label' => $this->CpmsModel->getSubtaskNameFromId(9),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_2_subtask_id_10',
                'label' => $this->CpmsModel->getSubtaskNameFromId(10),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_2_subtask_id_11',
                'label' => $this->CpmsModel->getSubtaskNameFromId(11),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],

            [
                'field' => 't2sT',
                'label' => "Total No Of Training Done",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_2',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_2_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_2_form_val as $rule){
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
        // cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_2'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                                
            //getting the subtask                      
            if(substr($key, 0, 18) == "task_2_subtask_id_"){                                
                $subtask_id =substr($key,18,19);                    
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_id,
                    "subtask_id_value" => $_POST['task_2_subtask_id_'.$subtask_id],
                    "related_subtask_id" => $subtask_id,
                    "related_subtask_id_value"=> $_POST['task_2_subtask_id_'.$subtask_id],
                    "subtask_result" => $_POST['task_2_subtask_id_'.$subtask_id],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'NUMBERS' 
                ]);
            }
        }
        //for substask id 12(result total as a subtask)
        array_push($cpms_subtask_wise_data, [
            "master_task_id" => $_POST['master_task_id'],
            "subtask_id" => 12,
            "subtask_id_value" => $_POST['t2sT'],
            "related_subtask_id" => $subtask_id,
            "related_subtask_id_value"=> 12,
            "subtask_result" => $_POST['t2sT'],
            "user_code" => $this->session->all_userdata()['user_code'], 
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s'),
            "result_type" => 'TOTAL-NUMBERS' 
        ]);
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_2'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_2'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_2_insertion_flag = $this->CpmsModel->insertTask2Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_2_insertion_flag);
    }

    //handling task 4 submit 
    public function task_4_submit_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************************/
        //valiation of task 4
        $error_msg = array();
        $task_4_form_val = [  
            [
                'field' => 'task_4_subtask_id_19',
                'label' => $this->CpmsModel->getSubtaskNameFromId(19),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_4_subtask_id_20',
                'label' => $this->CpmsModel->getSubtaskNameFromId(20),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'total_percentage_task_4',
                'label' => "Total Percentage" ,
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_4_evaluation_id_t4s1920',
                'label' => $this->CpmsModel->getSubtaskNameFromId(19). " and ". $this->CpmsModel->getSubtaskNameFromId(20). " Percentage",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'ytp_task_4_subtask_id_21',
                'label' => $this->CpmsModel->getSubtaskNameFromId(21),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_4',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]            
        ];
        $this->form_validation->set_rules($task_4_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_4_form_val as $rule){
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
        // cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_4'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = array();
        foreach($_POST as $key=>$value){                        
            //getting the subtask                         
            if(substr($key, 0, 24) == "task_4_evaluation_id_t4s"){                
                $subtask_arr =str_split(substr($key,24,26));    
                array_push($cpms_subtask_wise_data, [
                    "master_task_id" => $_POST['master_task_id'],
                    "subtask_id" => $subtask_arr[0].$subtask_arr[1],
                    "subtask_id_value" => $_POST['task_4_subtask_id_'.$subtask_arr[0].$subtask_arr[1]],
                    "related_subtask_id" => $subtask_arr[2].$subtask_arr[3],
                    "related_subtask_id_value"=> $_POST['task_4_subtask_id_'.$subtask_arr[2].$subtask_arr[3]],
                    "subtask_result" => $_POST[$key],
                    "user_code" => $this->session->all_userdata()['user_code'], 
                    "user_data" => json_encode($this->session->all_userdata()),      
                    "year" => date('Y'),
                    "created_at" => date('Y-m-d H:i:s'),
                    "result_type" => 'PERCENTAGE' 
                ]);
            }
        }
        //for subtask id 21 
        array_push($cpms_subtask_wise_data, [
            "master_task_id" => $_POST['master_task_id'],
            "subtask_id" => 21,
            "subtask_id_value" => $_POST['task_4_subtask_id_21'],
            "related_subtask_id" => 21,
            "related_subtask_id_value"=> $_POST['task_4_subtask_id_21'],
            "subtask_result" => $_POST['ytp_task_4_subtask_id_21'],
            "user_code" => $this->session->all_userdata()['user_code'], 
            "user_data" => json_encode($this->session->all_userdata()),      
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s'),        
            "result_type" => 'YES-NO' 
        ]);
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_4'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "master_task_id" => $_POST['master_task_id'],
            "result" => $_POST['cumalative_marks_achieved_task_4'],
            "user_code" => $this->session->all_userdata()['user_code'],      
            "user_data" => json_encode($this->session->all_userdata()),      
            "posted_data" => json_encode($_POST),
            "year" => date('Y'),
            "status" => 'P',
            "created_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $task_4_insertion_flag = $this->CpmsModel->insertTask4Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification);
        echo json_encode($task_4_insertion_flag);
    }

    //forward to adc handle 
    public function forwardToAdc(){        
        $user_code = $this->session->all_userdata()['user_code'];
        $year = date('Y');        
        //************************************************************/
        $completionFlag = $this->CpmsModel->checkFormCompletion($user_code,$year);
        if($completionFlag == "already_submitted"){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => "Can Not Resubmit Details, CPMS Details Already Submitted To ADC..!"]);
            exit;
        }else if($completionFlag == "forms_not_completed"){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => "All The Forms Are Not Submitted,Please Fill All The Forms Before Forwarding To ADC"]);
            exit;
        }
        //************************************************************/
        $cpms_proceeding_data=[
            "consultant_uesr_code" => $user_code,
            "status" => 'P',
            "consultant_user_data" => json_encode($this->session->all_userdata()),            
            "created_at" => date('Y-m-d H:i:s'),
            "year" => $year
        ];
        $proceedingInsertionFlag = $this->CpmsModel->insertProceeding($cpms_proceeding_data);
        echo json_encode($proceedingInsertionFlag);
    }

    //task 1 update handle 
    public function task_1_update_handle(){
        // echo json_encode($_POST);
        // exit;
        //*****************************************************/
        //valiation of task 1 
        $error_msg = array();
        $task_1_form_val = [
            [
                'field' => 'task_1_subtask_id_edit1',
                'label' => $this->CpmsModel->getSubtaskNameFromId(1),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_edit2',
                'label' => $this->CpmsModel->getSubtaskNameFromId(2),
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_edit3',
                'label' => $this->CpmsModel->getSubtaskNameFromId(3),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_edit4',
                'label' => $this->CpmsModel->getSubtaskNameFromId(4),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_edit5',
                'label' => $this->CpmsModel->getSubtaskNameFromId(5),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_subtask_id_edit6',
                'label' => $this->CpmsModel->getSubtaskNameFromId(6),
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_edit_result_id_12',
                'label' => $this->CpmsModel->getSubtaskNameFromId(1). " and ".$this->CpmsModel->getSubtaskNameFromId(2). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_edit_result_id_34',
                'label' => $this->CpmsModel->getSubtaskNameFromId(3). " and ".$this->CpmsModel->getSubtaskNameFromId(4). " Result",
                'rules' => 'required|callback_check_script|trim|numeric'
            ],
            [
                'field' => 'task_1_edit_result_id_56',
                'label' => $this->CpmsModel->getSubtaskNameFromId(5). " and ".$this->CpmsModel->getSubtaskNameFromId(6). " Result",
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'master_task_id',
                'label' => 'MT-ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'cumalative_marks_achieved_task_1_edit',
                'label' => 'Cumalative Marks',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ]
            
        ];
        $this->form_validation->set_rules($task_1_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($task_1_form_val as $rule){
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
        //cpms master task wise result data 
        $cpms_master_task_wise_data = [
            "result" => $_POST['cumalative_marks_achieved_task_1_edit'],
            "modified_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_master_task_wise_data);      
        // exit;  
        //*****************************************************************/
        //cpms subtask wise results 
        $cpms_subtask_wise_data = [
            [
                "subtask_id" => 1,
                "subtask_id_value" => $_POST['task_1_subtask_id_edit1'],
                "related_subtask_id" => 2,
                "related_subtask_id_value"=> $_POST['task_1_subtask_id_edit2'],
                "subtask_result" => $_POST['task_1_edit_result_id_12'],            
            ],
            [
                "subtask_id" => 3,
                "subtask_id_value" => $_POST['task_1_subtask_id_edit3'],
                "related_subtask_id" => 4,
                "related_subtask_id_value"=> $_POST['task_1_subtask_id_edit4'],
                "subtask_result" => $_POST['task_1_edit_result_id_34'],            
            ],
            [
                "subtask_id" => 5,
                "subtask_id_value" => $_POST['task_1_subtask_id_edit5'],
                "related_subtask_id" => 6,
                "related_subtask_id_value"=> $_POST['task_1_subtask_id_edit6'],
                "subtask_result" => $_POST['task_1_edit_result_id_56'],            
            ]
        ];        
        // echo json_encode($cpms_subtask_wise_data);      
        // exit;
        //*****************************************************************/
        //cpms user wise result 
        $cpms_uesr_wise_result = [
            "result" => $_POST['cumalative_marks_achieved_task_1_edit'],
            "posted_data" => json_encode($_POST),
            "modified_at" => date('Y-m-d H:i:s')
        ];
        // echo json_encode($cpms_uesr_wise_result);      
        // exit;
        //*****************************************************************/
        $cpms_task_and_user_wise_verification = [
            "result" => $_POST['cumalative_marks_achieved_task_1_edit'],    
            "posted_data" => json_encode($_POST),
            "status" => 'P',
            "modified_at" => date('Y-m-d H:i:s'),
            "verified_marks" => null
        ];
        // echo json_encode($cpms_task_and_user_wise_verification);      
        // exit;
        //*****************************************************************/
        $user_code = $this->session->all_userdata()['user_code'];
        $year = $_POST['year'];
        $master_task_id = $_POST['master_task_id'];
        $task_1_updation_flag = $this->CpmsModel->updateTask1Details($cpms_master_task_wise_data, 
        $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification, 
        $user_code, $year, $master_task_id);
        echo json_encode($task_1_updation_flag);
    }

}