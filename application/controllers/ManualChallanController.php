<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ManualChallanController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
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

    //settlement-manual-challan-reverify-page
    public function settlementManualChallanReVerify() {        
        $data['_view'] = 'manual_challan_reverify/settlementManualChallanReverify';
        $this->load->view('layouts/main',$data);
    }

    //settlement-manual-challan-reverify-handle
    public function settlementManualChallanReVerifyHandle(){        
        //***********************************************************************/
        // file validation 
        if(isset($_FILES['manual_chalan']['name'])){
            if($_FILES['manual_chalan']['name'] && $_FILES['manual_chalan']['size'] && $_FILES['manual_chalan']['tmp_name']){
                $name = $_FILES['manual_chalan']['name'];
                $size = $_FILES['manual_chalan']['size'];
                $mime = mime_content_type($_FILES['manual_chalan']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];
                if($name != NULL)
                {
                    if($ext == NULL)
                    {   
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#SMCPF001']);
                        exit;

                    }
                    if($ext != 'pdf')
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#SMCPF002']);
                        exit;
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#SMCPF003']);
                        exit;
                    }
                }
                else
                {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF004']);
                    exit;
                }
            }
            else{
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF005']);
                exit;
            }
        }else{
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF006']);
            exit;
        }        
        //***********************************************************************/
        //***********************************************************************/
        // post field validation
        $error_msg = array();
        $manual_challan_validation_arr = [
            [
                'field' => 'application_no',
                'label' => 'RTPS-APPLICATION-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ]          
        ];
        $this->form_validation->set_rules($manual_challan_validation_arr);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($manual_challan_validation_arr as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************************************************************/
        //***********************************************************************/
        $sql = "select case_no,applid from settlement_basic sb where applid=?";
        $query = $this->db->query($sql,array($_POST['application_no']));
        if($query->num_rows() != 1){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Application Not Found, Error-Code : #smcu0045']);
            exit;
        }
        $application_no = $query->row()->applid; 
        $case_no = $query->row()->case_no;
        //************************************************************************/
        $grn_allowed_arr = ['RTPS/SKCSL/2022/493026','RTPS/SKCSL/2023/1824953','RTPS/SKCSL/2023/1302042','RTPS/SKCSL/2022/100488','RTPS/SOSC/2023/1205819','RTPS/SKCSL/2023/1484638','RTPS/SKCSL/2023/1805426','RTPS/SKCSL/2023/1471262','RTPS/SKCSL/2023/1345085','RTPS/SKCSL/2023/1802428','RTPS/SOSC/2023/1289346','RTPS/SKCSL/2022/490663','RTPS/SKCSL/2022/421200','RTPS/SKCSL/2023/1441083','RTPS/SKCSL/2023/530281','RTPS/SKCSL/2023/1383359','RTPS/SKCSL/2022/467870','RTPS/SKCSL/2023/1559271','RTPS/SKCSL/2023/1413465','RTPS/SOSC/2023/1231519','RTPS/SKCSL/2023/694253','RTPS/SKCSL/2023/1197871','RTPS/SAPH/2023/1186007','RTPS/SAPH/2023/1177829','RTPS/SKCSL/2023/1030403','RTPS/SKCSL/2023/744291','RTPS/SKCSL/2022/171303','RTPS/SKCSL/2023/626600','RTPS/SKCSL/2023/1597648','RTPS/SAPH/2023/805950','RTPS/SAPH/2023/1444350','RTPS/SKCSL/2023/1021588','RTPS/SKCSL/2023/862804','RTPS/SKCSL/2023/1432043','RTPS/SAPH/2023/952637','RTPS/SOSC/2023/798316','RTPS/SKCSL/2022/39568','RTPS/SKCSL/2023/1403165','RTPS/SOSC/2023/581396','RTPS/SAPH/2023/1165893','RTPS/SKCSL/2023/521721','RTPS/SKCSL/2023/994892','RTPS/SKCSL/2023/1629856','RTPS/SKCSL/2023/1721927','RTPS/SKCSL/2023/1682874','RTPS/SOSC/2023/1229232','RTPS/SKCSL/2023/1263273','RTPS/SKCSL/2023/940562','RTPS/SKCSL/2023/626000','RTPS/SOSC/2023/1065596','RTPS/SKCSL/2023/1000733','RTPS/SKCSL/2023/1000319','RTPS/SOSC/2022/283911','RTPS/SKCSL/2023/1709362','RTPS/SKCSL/2022/127521','RTPS/SKCSL/2023/635956','RTPS/SKCSL/2023/756124','RTPS/SKCSL/2023/1640804','RTPS/SKCSL/2023/1033288','RTPS/SKCSL/2022/284524','RTPS/SKCSL/2023/1771443','RTPS/SAPH/2023/1129415','RTPS/SAPH/2023/589632','RTPS/SKCSL/2023/1294939','RTPS/SKCSL/2023/528145','RTPS/SKCSL/2022/172509','RTPS/SKCSL/2023/662731','RTPS/SKCSL/2022/432394','RTPS/SKCSL/2023/703810','RTPS/SKCSL/2022/452753','RTPS/SKCSL/2022/454251','RTPS/SKCSL/2023/636400','RTPS/SKCSL/2023/1447494','RTPS/SKCSL/2023/1348394','RTPS/SKCSL/2023/639089','RTPS/SKCSL/2023/1707792','RTPS/SKCSL/2023/1110969','RTPS/SKCSL/2023/1148930','RTPS/SKCSL/2023/1093333','RTPS/SKCSL/2023/1859919','RTPS/SAPH/2023/803536','RTPS/SKCSL/2023/1110142','RTPS/SKCSL/2023/1070624','RTPS/SKCSL/2023/1092745','RTPS/SKCSL/2023/745916','RTPS/SKCSL/2023/944388','RTPS/SKCSL/2022/200667','RTPS/SKCSL/2022/369266','RTPS/SKCSL/2023/1061583','RTPS/SKCSL/2023/879501'];
        if (!in_array($application_no, $grn_allowed_arr)) { 
            echo json_encode(['result' => 'FAILED', 'msg' => 'This case no is not allowed to update the manual payment details..!']);
            exit;
        } 
        $sql = "select pid,due_amount from settlement_premium where case_no=? and is_final=1";
        $query = $this->db->query($sql,array($case_no));
        $result = $query->result();        
        $sp_row_count = count($result);
        //***********************************************************************/        
        if($sp_row_count == 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu003']);
            exit;
        }
        //***************************************************************** */
        //file moving section
        $file_new_name = "echallan".$_POST['grn_no']; 
        $manual_challan_upload_dir = RE_UPLOAD_MANUAL_CHALAN_DIR.$file_new_name; 
        $file_full_path = RE_UPLOAD_MANUAL_CHALAN_DIR.$file_new_name.".pdf";
        move_uploaded_file($_FILES['manual_chalan']['tmp_name'], $file_full_path);
        if(!file_exists($file_full_path)){
            log_message("error", "#smcuuf001, Error in moving file for the case_no ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcuuf001']);
            exit;
        }
        //******************************************************************/
        $sp_update_data = [
            'grn_no' => $_POST['grn_no'],
            'manual_challan_upload_dir' => $manual_challan_upload_dir,
            'is_manual_challan' => 'Y'
        ];
        $this->db->trans_begin(); 
        $this->db->where('case_no', $case_no) 
                ->where('is_final',1)               
                ->update('settlement_premium', $sp_update_data);
                
        if($this->db->affected_rows() != $sp_row_count){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#smcu001, Error in update, table 'settlement_premium' with query :". $this->db->last_query());
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu001']);
            exit;
        } 

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#smcu002, Transaction Status Error In manual challan update, settlement_premium tables for case_no ". $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu002']);
            exit;
        }else{           
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => API_LINK_MB2.'reVerifyManualPaymentDetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'application_no' => $application_no,
                    'grn_no' => $_POST['grn_no'],
                    'ip_address' => $this->utilityclass->get_client_ip(),
                ),
            ));
            $response = curl_exec($curl);            
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $resp = json_decode($response);
                if($resp->result == 'SUCCESS'){          
                    $this->db->trans_commit();
                    echo json_encode(['result' => 'SUCCESS', 'msg' => 'Challan Details Updated Successfully..!']);
                    exit;
                }else{
                    echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0034']);
                    exit;
                }

            }else{
                echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0035']);
                exit;
            }
        }
    }
}