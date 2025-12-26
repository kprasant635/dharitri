<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaMouzadarController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaLm/EkhajanaLmModel');
        $this->load->model('eKhajana/EkhajanaMouzadar/EkhajanaMouzadarModel');
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

    //displaying mouzadar add form 
    public function mouzdarAddForm(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_list'] = $mouza_list = $this->EkhajanaMouzadarModel->getAllMouzaList($dist_code, $subdiv_code, $cir_code);        
        $data['_view'] = 'e_khajana/mouzadar_views/mouzadar_add_form';
        $this->load->view('layouts/main',$data);
    }

    //handling mouzdar add form submission 
    public function addMouzadar(){
        //*****************validation*************/
        $error_msg = array();
        $add_mouzadar_form_val = [
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
            ],
            [
                'field' => 'user_name',
                'label' => 'User-Name',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean'
            ],
            [
                'field' => 'mobile_no',
                'label' => 'Mobile-No',
                'rules' => 'required|callback_check_script|max_length[10]|trim|xss_clean'
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'required|callback_check_script|max_length[20]|trim|xss_clean|valid_email'
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required|callback_check_script|max_length[200]|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_rules($add_mouzadar_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($add_mouzadar_form_val as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        //****************************************/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $_POST['dist_code'],
                'subdiv_code' => $_POST['subdiv_code'],
                'cir_code' => $_POST['cir_code'],
                'mouza_pargona_code' => $_POST['mouza_pargona_code'],
                'name' => $_POST['name'],
                'user_name' => $_POST['user_name'],
                'mobile_no' => $_POST['mobile_no'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode == 200){            
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                echo json_encode(['result' => 'SUCCESS', 'msg' => "Mouzdar Added Successfully..!!"]);
            }elseif($response_obj->result == "USER_EXISTS"){    
                echo json_encode(['result' => 'USER_EXISTS', 'msg' => "Can Not Add Mouzadar For This Mouza...!!, Mouzdar Already Exists For This Mouza..!!"]);
            }else{
                log_message("error", "#EKCRLMOU0001, Curl Error(Y) In Api ".EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLMOU0001");
            }
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLMOU0002, Curl Error(200) In Api ".EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLMOU0002");
        }
        //****************************************/
    }

}
