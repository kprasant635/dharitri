<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaDcController extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/EkhajanaDc/EkhajanaDcModel');
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

    //index method of demand satisfaction 
    public function mouzaWiseDemandSatisfiedIndex(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "DC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_list']=$subdiv_list = $this->EkhajanaCommonModel->getSubdivListFromDist($dist_code);   
        $data['demand_satisfied_list'] = $this->EkhajanaCommonModel->getDemandSatisfiedListFromDist($dist_code);   
        $data['_view'] = 'e_khajana/dc_views/mouza_wise_demand_satisfy';
        $this->load->view('layouts/main',$data);
    }

    //getting circle list 
    public function getCircleList(){
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $subdiv_code= $_POST['subdiv_code'];
        $data['circle_list']= $circle_list = $this->EkhajanaCommonModel->getCircleList($dist_code,$subdiv_code);    
        echo json_encode($circle_list);
    }

    //getting mouza list  
    public function getMouzaList(){
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $subdiv_code= $_POST['subdiv_code'];
        $cir_code = $_POST['cir_code'];
        $data['mouza_list']= $mouza_list = $this->EkhajanaCommonModel->getMouzaList($dist_code,$subdiv_code,$cir_code);    
        echo json_encode($mouza_list);
    }

    //dsm form submit handle
    public function submitDSMHandle(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "DC"){
            echo json_encode("Not Authorised!!");
            exit;
        }     
        
        //***********************************************************************/
        // file validation 
        if(isset($_FILES['demand_satisfied_certificate']['name'])){
            if($_FILES['demand_satisfied_certificate']['name'] && $_FILES['demand_satisfied_certificate']['size'] && $_FILES['demand_satisfied_certificate']['tmp_name']){
                $name = $_FILES['demand_satisfied_certificate']['name'];
                $size = $_FILES['demand_satisfied_certificate']['size'];
                $mime = mime_content_type($_FILES['demand_satisfied_certificate']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];
                if($name != NULL)
                {
                    if($ext == NULL)
                    {   
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Demand Satisfied Certificate, Please Upload Correctly, ERR-#EKHDSCPF001']);
                        exit;

                    }
                    if($ext != 'pdf')
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Demand Satisfied Certificate, Please Upload Pdf Only, ERR-#EKHDSCPF002']);
                        exit;
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Demand Satisfied Certificate, Please Upload Demand Satisfied Certificate Less Than 5mb, ERR-#EKHDSCPF003']);
                        exit;
                    }
                }
                else
                {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Demand Satisfied Certificate, ERR-#EKHDSCPF004']);
                    exit;
                }
            }
            else{
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Demand Satisfied Certificate, ERR-#EKHDSCPF005']);
                exit;
            }
        }else{
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Demand Satisfied Certificate..!']);
            exit;
        }        
        //***********************************************************************/
        //*****************************************************************/
        //backend validation 
        $error_msg = array();
        $arrear_update_form_val = [
            [
                'field' => 'subdiv_code',
                'label' => 'Sub-Division',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'mouza_code',
                'label' => 'Mouza',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'year',
                'label' => 'Up To Which Year Demand Satisfied',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[9]'
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
        //*****************************************************************/
        //file moving section
        $dist_name = $this->utilityclass->getDistrictNameEng($this->session->userdata('dist_code'));
        $subdiv_name = $this->utilityclass->getSubDivNameEng($this->session->userdata('dist_code'),$_POST['subdiv_code']);
        $cir_name = $this->utilityclass->getEnglishCircleName($this->session->userdata('dist_code'),$_POST['subdiv_code'],$_POST['cir_code']);
        $mouza_name = $this->utilityclass->getEnglishMouzaName($this->session->userdata('dist_code'),$_POST['subdiv_code'],$_POST['cir_code'],$_POST['mouza_code']);
        $location = trim($dist_name)."_".trim($subdiv_name)."_".trim($cir_name)."_".trim($mouza_name).'_'.strtotime("now");
        $file_new_name = "demand_satisfied_certificate_".$location; 
        $manual_challan_upload_dir = DEMAND_SATISFIED_CERTIFICATE_UPLOAD_DIR.$file_new_name; 
        $file_full_path = DEMAND_SATISFIED_CERTIFICATE_UPLOAD_DIR.$file_new_name.".pdf";
        move_uploaded_file($_FILES['demand_satisfied_certificate']['tmp_name'], $file_full_path);
        if(!file_exists($file_full_path)){
            log_message("error", "#DSFUF001, Error in moving file for the location ".$location);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSFUF001']);
            exit;
        }
        //******************************************************************/
        $insert_data = [
            "dist_code"=>$this->session->userdata('dist_code'),
            "subdiv_code"=>$_POST['subdiv_code'],
            "cir_code"=>$_POST['cir_code'],
            "mouza_pargona_code"=>$_POST['mouza_code'],
            "upto_demand_satisfied_year"=>$_POST['year'],
            "user_data"=>json_encode($this->session->all_userdata()), 
            "created_at"=> date('Y-m-d h:i:s'),
            "year_no" => substr($_POST['year'],5,4),
            "doc_upload_path" => $file_full_path
        ];
        $tstatus1 = $this->db->insert('ekhajana_demand_satisfy_year', $insert_data);    
        if ($tstatus1 != 1 )
        {
            log_message("error", "#ekhdsm001, Error in insert, table 'ekhajana_demand_satisfy_year' with query :". $this->db->last_query());
            echo json_encode(['result' => false, 'msg' => 'Some error occured, Error-Code : #ekhdsm001']);
        }else{
            echo json_encode(['result' => true, 'msg' => 'Demand Satisfied Year Added Successfully..!!']);
        }
    }

    public function deleteDSMHandle(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "DC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //*****************************************************************/
        //backend validation 
        $error_msg = array();
        $arrear_update_form_val = [
            [
                'field' => 'dsm_id',
                'label' => 'id',
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
        $this->db->trans_begin();
        //insertion of previous entries on the transaction table
        $previous_entry = $this->db->query("select * from ekhajana_demand_satisfy_year where id=?",
                          $_POST['dsm_id'])->result();
        $ekhajana_transaction_details = [
            "previous_data"     => json_encode($previous_entry),
            "created_at"        => date('Y-m-d h:i:s'),
            "modified_at"       => date('Y-m-d h:i:s'),
            "user_details"      => json_encode($this->session->all_userdata()),
        ];
        $tstatus2 = $this->db->insert('ekhajana_demand_satisfy_year_transactions', $ekhajana_transaction_details);
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#ekhdsm0021, Error in insert on table 'ekhajana_demand_satisfy_year_transactions' with query :". $this->db->last_query());
            echo json_encode(['result' => false, 'msg' => 'Some error occured, Error-Code : #ekhdsm0021']);
            exit;
        }
        //deletion of previous entries from the demand satisfied table
        $where = [
            'id' => $_POST['dsm_id'],
        ];
        $status = $this->db->where($where)->delete('ekhajana_demand_satisfy_year');
        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ekhdsm002, Error in delete, table 'ekhajana_demand_satisfy_year' with query :". $this->db->last_query());
            echo json_encode(['result' => false, 'msg' => 'Some error occured, Error-Code : #ekhdsm002']);
            exit;
        }
        //checkeing all transaction status
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#ekhdsm00212, Transaction error in demand satisfied delete module");
            echo json_encode(['result' => false, 'msg' => 'Some error occured, Error-Code : #ekhdsm00212']);
            exit;
        }else{
            $this->db->trans_commit();
            echo json_encode(['result' => true, 'msg' => 'Demand Satisfied Year Deleted Successfully..!!']);
        }
        //*****************************************************************/
    }

    public function EcfrMouzadarDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['ecfr_data'] = $this->EkhajanaDcModel->getEcfrDetails($dist_code);
        if($data['ecfr_data']['flag'] == 'ERROR'){
            echo "SOme error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['ecfr_details'] = $data['ecfr_data']['msg'];
        $data['_view'] = 'e_khajana/dc_views/ecfr_report';
        $this->load->view('layouts/main',$data);
        
    }

    public function MouzadarDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['mouzadari_data'] = $this->EkhajanaDcModel->getMouzadariDetails($dist_code);
        if($data['mouzadari_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['mouzadari_details'] = $data['mouzadari_data']['msg'];
        $data['_view'] = 'e_khajana/dc_views/mouzadari_report';
        $this->load->view('layouts/main',$data);
    }

    
}