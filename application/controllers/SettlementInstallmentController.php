<?php
class SettlementInstallmentController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SettlementModel/SettlementInstallment');
        $this->dbswitch();
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
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

    //date-validation-callback
    function date_valid($date){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
            return false;
        
        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);                        
        return checkdate($month, $day, $year);
    }

    public function getInstallmentPaymentList(){
        $service_code = $_GET['service'];
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['caseListForDueInstallmentPayment'] = $this->SettlementInstallment->getDueInstallmentPaymentCaseListFromServiceCode($service_code,$dist_code,$subdiv_code,$cir_code);
        // echo "<pre>";
        // var_dump($data['caseListForDueInstallmentPayment']);
        // echo "</pre>";
        $data['_view'] = 'SettlementView/installment_payment/dueInstallmentPaymentCaseList';
        $this->load->view('layouts/main',$data);
    }

    public function installmentPaymentUpdateForm(){        
        $data['case_no']=$case_no = $_GET['case_no'];     
        //******************************************************************/
        //validation    
        //******************************************************************/
        //settlement_premium details 
        $data['sp_details'] = $this->SettlementInstallment->getSpDetailsFromCaseNo($data['case_no']);        
        //settlement basic details 
        $data['sb_details'] = $this->SettlementInstallment->getSbDetailsFromCaseNo($data['case_no']);
        //settlement emi history details
        $data['seh_details'] = $this->SettlementInstallment->getSehDetailsFromCaseNo($data['case_no']);      
        //getting details from rtpsmb
        //******************************************************************/        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => FETCH_MANUAL_INSTALLMENT_PAYMENT_INFO_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('rtps_application_no' => $data['sb_details']->applid,'case_no' => $data['case_no']),            
        ));
        $response = curl_exec($curl);        
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode != 200){
            log_message('error','#DSIPGL006-200E, CURL 200 ERROR IN '.FETCH_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API FOR THE APPLICATION NO  '. $data['case_no']);
            echo json_encode(['result'=>false, 'msg'=>'SOME ERROR OCCURED, ERROR-CODE: #DSIPGL006-200E']);
            exit;
        }
        $responseObj = json_decode($response);
        // curl_close($curl);
        // echo "<pre>";
        // var_dump($responseObj);
        // echo "</pre>";
        // exit;
        if($responseObj->result == false){
            log_message('error','#DSIPGL0066, ERROR IN '.FETCH_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API WITH RESPONSE '. json_encode($responseObj));
            echo json_encode(['result'=>false, 'msg'=>$responseObj->msg]);
            exit;
        }
        //******************************************************************/
        $data['installment_info'] = $responseObj->data; 
        // curl_close($curl);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // exit;
        $data['_view'] = 'SettlementView/installment_payment/installmentPaymentUpdateForm';
        $this->load->view('layouts/main',$data);
    }

    public function manualInstallmentPaymentSubmitHandle(){
        // echo json_encode($_POST);
        // exit;
        //********************************************************************/
        // validation of posted details         
        $error_msg = array();
        $manual_installment_validation_arr = [
            [
                'field' => 'application_no',
                'label' => 'Application-No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'installment_amount',
                'label' => 'Installment-Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'installment_no',
                'label' => 'Installment-No',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'no_of_installment',
                'label' => 'No-Of-Installment',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'paid_installment_amount',
                'label' => 'No-Of-Installment',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'payment_link_generated_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'pre_paid_amount',
                'label' => 'Pre-Paid-Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'pre_remaining_amount',
                'label' => 'Pre-Remaining-Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'total_premium',
                'label' => 'Total-Premium',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],                        
        ];
        $this->form_validation->set_rules($manual_installment_validation_arr);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($manual_installment_validation_arr as $rule){
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
        // case no db validation in settlement basic 
        $this->dbswitch();
        $sb_query = $this->db->query("select * from settlement_basic where case_no=?", array($_POST['case_no']));
        $sb_num_rows = $sb_query->num_rows();
        if($sb_num_rows != 1){
            log_message("error", "#DIPSBRNF001, Case no not found in settlement_basic for ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DIPSBRNF001']);
            exit;
        } 
        //***********************************************************************/
        // dharitree db row in settlement emi history validation 
        $seh_row_count = $this->db->query("select * from settlement_emi_history where case_no=?", array($_POST['case_no']))->num_rows();
        if($seh_row_count == 0){
            log_message("error", "#DSIPSEH001, Row not found in settlement emi history for ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPSEH001']);
            exit;
        }
        $seh_last_row = $this->db->query("select * from settlement_emi_history where case_no=? order by id desc", array($_POST['case_no']))->row();
        if($seh_last_row->paid_amount != $_POST['pre_paid_amount']){
            log_message("error", "#DSIPSEH002, Amount Mismatched in SettlementEmiHistory And SettlementInstallment for ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPSEH002']);
            exit;
        }
        //***********************************************************************/
        // file validation 
        if(isset($_FILES['t_challan']['name'])){
            if($_FILES['t_challan']['name'] && $_FILES['t_challan']['size'] && $_FILES['t_challan']['tmp_name']){
                $name = $_FILES['t_challan']['name'];
                $size = $_FILES['t_challan']['size'];
                $mime = mime_content_type($_FILES['t_challan']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];
                if($name != NULL)
                {
                    if($ext == NULL)
                    {   
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#FDIPSMCPF001']);
                        exit;

                    }
                    if($ext != 'pdf')
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#FDIPSMCPF002']);
                        exit;
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#FDIPMCPF003']);
                        exit;
                    }
                }
                else
                {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF004']);
                    exit;
                }
            }
            else{
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF005']);
                exit;
            }
        }else{
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF006']);
            exit;
        }        
        //***********************************************************************/        
        //file handle(challan)        
        $file_new_name = "echallanInstallmentPayment".$_POST['grn_no']; 
        $manual_challan_upload_dir = UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR.$file_new_name; 
        $file_full_path = UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR.$file_new_name.".pdf";
        move_uploaded_file($_FILES['t_challan']['tmp_name'], $file_full_path);        
        if(!file_exists($file_full_path)){
            log_message("error", "#fsdipsmcuuf001, Error in moving file for the case_no ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #fsdipsmcuuf001']);
            exit;
        }
        $challan_link = $file_full_path;
        // echo json_encode($file_full_path);
        // exit;
        //********************************************************************/
        //settlement_installment_details 
        $pre_remaining_amount_new = $_POST['pre_remaining_amount']-$_POST['paid_installment_amount'];
        $pre_paid_amount_new = $_POST['pre_paid_amount']+ $_POST['paid_installment_amount'];
        $response = json_encode([
            "manual_challan_path" => $challan_link,
            "posted_data" => $_POST,
            "user_data" => $this->session->all_userdata()
        ]);
        $settlement_installment_insert_data = [
            "rtps_application_no"=>$_POST['application_no'],
            "dharitree_case_no"=>$_POST['case_no'],
            "status"=> 'Y',       
            "paid_installment_amount" => $_POST['paid_installment_amount'],     
            "pre_remaining_amount"=>$pre_remaining_amount_new,
            "pre_paid_amount"=>$pre_paid_amount_new,
            "created_at"=>date('Y-m-d H:i:s'),
            "grn_no"=>$_POST['grn_no'],
            "payment_response"=> $response,
            "installment_payment_received_date"=>date('Y-m-d'),
            "payment_mode"=>"OFFLINE",
            "gras_payment_date"=>$_POST['payment_date'],
        ];
        // echo "<pre>";
        // var_dump($settlement_installment_insert_data);
        // echo "</pre>";
        // exit;
        //********************************************************************/
        //settlement_emi_history details        
        $sp_query = $this->db->query("select * from settlement_premium where case_no=? and is_final=? 
                                      and grn_no is not null", array($_POST['case_no'], '1'));                        
        $sp_details = $sp_query->result();
        $dag_no_arr = array();
        foreach($sp_details as $sp_detail){
            array_push($dag_no_arr, $sp_detail->dag_no);
        }
        $dag_no_str_string = implode(',', $dag_no_arr);
        if($pre_remaining_amount_new <= 0){
            $is_full_paid = 1;            
        }else{
            $is_full_paid = 0;
        }
        $settlement_emi_history_insert_data = [
            "case_no"=>$_POST['case_no'],
            "application_no"=>$_POST['application_no'],
            "final_amount"=>$_POST['total_premium'],
            "paid_amount"=>$pre_paid_amount_new,
            "remaining_amount"=>$pre_remaining_amount_new,
            "tenure"=>$sp_details[0]->tenure,
            "installment_amount"=>$_POST['installment_amount'],
            "payment_date"=>date('Y-m-d'),
            "grn_no"=>$_POST['grn_no'],
            "old_dag_no"=>$dag_no_str_string,             
            "is_full_paid"=> $is_full_paid,
            "date_entry"=> date('Y-m-d h:i:s'),
            "date_update"=> date('Y-m-d h:i:s'),
            "ekhajana_application_no" => null,
            "settlement_dag_no" => null,
            "challen_link" => $challan_link,
            "paid_installment_amount" => $_POST['paid_installment_amount'],
            "paid_installment_no" => $_POST['installment_no'],
            "paid_no_of_installment" => $_POST['no_of_installment']
        ];
        // echo "<pre>";
        // var_dump($settlement_emi_history_insert_data);
        // echo "</pre>";
        // exit;
        //********************************************************************/
        $this->db->trans_begin();
        $inStatus2=$this->db->insert('settlement_emi_history',$settlement_emi_history_insert_data);
        if($inStatus2 != 1){
            $this->db->trans_rollback();
            log_message('error','#DMIPSEHIERR, UNBALE TO INSERT IN settlement_emi_history TABLE, FOR THE APPLICATION NO '. $si_last_row->dharitree_case_no);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DMIPSEHIERR']);
        }
        //********************************************************************/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => SAVE_MANUAL_INSTALLMENT_PAYMENT_INFO_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('rtps_application_no' => $_POST['application_no'], 'case_no' => $_POST['case_no'], 'insert_data'=>json_encode($settlement_installment_insert_data)),            
        ));
        $response = curl_exec($curl);        
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode != 200){
            log_message('error','#DSIPGL006S-200E, CURL 200 ERROR IN '.SAVE_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API FOR THE APPLICATION NO  '. $si_last_row->dharitree_case_no);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPGL006S-200E']);
            exit;
        }
        $responseObj = json_decode($response);
        // curl_close($curl);
        // echo "<pre>";
        // var_dump($responseObj);
        // echo "</pre>";
        // exit;
        if($responseObj->result == false){
            log_message('error','#DSIPGL0066S, ERROR IN '.SAVE_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API WITH RESPONSE '. json_encode($responseObj));            
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPGL0066S']);
            exit;
        }
        //**************************************************************************/
        $this->db->trans_commit();
        echo json_encode(['result' => 'SUCCESS', 'msg' => 'Installment Details Updated Successfully, The Newly Added Installment Info Will Be Displayed In The INSTALLMENT PAYMENT INFORMATION Section Of This Page..!']);        
    }
    
    public function manualInstallmentPaymentSubmitHandleWithoutPaymentLink(){        
        // echo json_encode($_POST);
        // exit;    
        //***********************************************************************/       
        // validation of posted details         
        $error_msg = array();
        $manual_installment_validation_arr = [
            [
                'field' => 'application_no',
                'label' => 'Application-No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            
            [
                'field' => 'no_of_installment',
                'label' => 'No-Of-Installment',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'paid_installment_amount',
                'label' => 'No-Of-Installment',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric'
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],                                
        ];
        $this->form_validation->set_rules($manual_installment_validation_arr);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($manual_installment_validation_arr as $rule){
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
        $this->dbswitch();
        // AMOUNT VALIDATION WITH DB 
        $sp_query = $this->db->query("select * from settlement_premium where case_no=? and is_final=? 
                                      and grn_no is not null", array($_POST['case_no'], '1'));     
        $sp_details = $sp_query->result();
        $installment_amount = $sp_details[0]->installment_amount; 
        if(round($_POST['no_of_installment']*$installment_amount,2) != round($_POST['paid_installment_amount'],2)){
            log_message("error", "#VDIPSBRNF001, Paid Amount Mismatched for ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Paid Amount Mismatched(For '.$_POST['no_of_installment'].' installments amount should be '. $_POST['no_of_installment']*$installment_amount.' Rs), Error-Code : #VDIPSBRNF001']);
            exit;
        }
        $total_premium = $sp_details[0]->total_premium;
        $remaining_amount_initial = $sp_details[0]->remaining_amount;
        $paid_amount_initial = $sp_details[0]->paid_amount;
        //***********************************************************************/
        // case no db validation in settlement basic         
        $sb_query = $this->db->query("select * from settlement_basic where case_no=?", array($_POST['case_no']));
        $sb_num_rows = $sb_query->num_rows();
        if($sb_num_rows != 1){
            log_message("error", "#DIPSBRNF001, Case no not found in settlement_basic for ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DIPSBRNF001']);
            exit;
        } 
        $sb_row = $sb_query->row();
        //***********************************************************************/
        //existing grn validation
        $seh_results = $this->db->query("select grn_no from settlement_emi_history where case_no=?", array($_POST['case_no']))->result();
        foreach($seh_results as $seh_row){
            if($seh_row->grn_no == $_POST['grn_no']){
                echo json_encode(['result' => 'FAILED', 'msg' => 'GRN alreday exists, Error-Code : #grnmatch0201']);
                exit;
            }
        }
        $this->db->trans_begin(); 
        //***********************************************************************/
        // settlement emi history validation 
        $seh_row_count = $this->db->query("select * from settlement_emi_history where case_no=?", array($_POST['case_no']))->num_rows();
        //no of installment validation 
        if($seh_row_count == 0){
            if($_POST['no_of_installment'] > 5){
                log_message("error", "#VDIPSBRNF0012, No Of Installment Mismatched for ".$_POST['case_no']);
                echo json_encode(['result' => 'FAILED', 'msg' => 'No Of Installments Can not Be Greater Than 5,Error-Code : #VDIPSBRNF0012']);
                exit;
            }
            //inserting base entries into settlement emi history             
            $sp_query = $this->db->query("select * from settlement_premium where case_no=? and is_final=? 
            and grn_no is not null", array($_POST['case_no'], '1'));
            $sp_details = $sp_query->result();
            $dag_no_arr = array();
            foreach($sp_details as $sp_detail){
                array_push($dag_no_arr, $sp_detail->dag_no);
            }
            $dag_no_str_string = implode(',', $dag_no_arr);
            if($sp_details[0]->remaining_amount <= 0){
                $is_full_paid = 1;            
            }else{
                $is_full_paid = 0;
            }
            $insert_data = [
                "case_no"=>$_POST['case_no'],
                "application_no"=> $_POST['application_no'],
                "final_amount"=> $sp_details[0]->total_premium,
                "paid_amount"=>$sp_details[0]->paid_amount,
                "remaining_amount"=>$sp_details[0]->remaining_amount,
                "tenure"=>$sp_details[0]->tenure,
                "installment_amount"=>$sp_details[0]->installment_amount,
                "payment_date"=>$sp_details[0]->payment_date,
                "grn_no"=>$sp_details[0]->grn_no,
                "challen_link"=>$sp_details[0]->manual_challan_upload_dir,
                "old_dag_no"=>$dag_no_str_string,             
                "is_full_paid"=> $is_full_paid,
                "ekhajana_application_no" => null,
                "settlement_dag_no" => null,
                "date_entry"=> date('Y-m-d h:i:s'),
                "date_update"=> date('Y-m-d h:i:s'),
            ];
            $inStatus=$this->db->insert('settlement_emi_history',$insert_data);
            if($inStatus != 1){
                $this->db->trans_rollback();
                log_message('error','#DSIPGL001,UNBALE TO INSERT IN SETTLEMENT EMI HISTORY TABLE, FOR THE APPLICATION NO '. $application_no);
                return ['result'=>false, 'msg'=>'SOME ERROR OCCURED, ERROR-CODE: #DSIPGL001'];
            }
            $installment_no = 1;
            $pre_paid_amount = $paid_amount_initial;
            $pre_remaining_amount = $remaining_amount_initial;
        }else{
            $seh_last_row = $this->db->query("select * from settlement_emi_history where case_no=? order by id desc", array($_POST['case_no']))->row();
            $paid_no_of_installment_earlier = $seh_last_row->paid_no_of_installment;
            if($_POST['no_of_installment']+$paid_no_of_installment_earlier > 5){
                log_message("error", "#VDIPSBRNF0012, No Of Installment Mismatched for ".$_POST['case_no']);
                echo json_encode(['result' => 'FAILED', 'msg' => 'No Of Installments Can not Be Greater Than '.(5-$paid_no_of_installment_earlier).',Error-Code : #VDIPSBRNF0012']);
                exit;
            }            
            $installment_no = $seh_last_row->paid_installment_no+1;
            $pre_paid_amount = $seh_last_row->paid_amount;
            $pre_remaining_amount = $seh_last_row->remaining_amount;
        }        
        //***********************************************************************/
        // file validation 
        if(isset($_FILES['t_challan']['name'])){
            if($_FILES['t_challan']['name'] && $_FILES['t_challan']['size'] && $_FILES['t_challan']['tmp_name']){
                $name = $_FILES['t_challan']['name'];
                $size = $_FILES['t_challan']['size'];
                $mime = mime_content_type($_FILES['t_challan']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];
                if($name != NULL)
                {
                    if($ext == NULL)
                    {   
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#FDIPSMCPF001']);
                        exit;

                    }
                    if($ext != 'pdf')
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#FDIPSMCPF002']);
                        exit;
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#FDIPMCPF003']);
                        exit;
                    }
                }
                else
                {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF004']);
                    exit;
                }
            }
            else{
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF005']);
                exit;
            }
        }else{
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#FDIPSMCPF006']);
            exit;
        }        
        //***********************************************************************/    
        //file handle(challan)        
        $file_new_name = "echallanInstallmentPayment".$_POST['grn_no']; 
        $manual_challan_upload_dir = UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR.$file_new_name; 
        $file_full_path = UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR.$file_new_name.".pdf";
        move_uploaded_file($_FILES['t_challan']['tmp_name'], $file_full_path);        
        if(!file_exists($file_full_path)){
            log_message("error", "#fsdipsmcuuf001, Error in moving file for the case_no ".$_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #fsdipsmcuuf001']);
            exit;
        }
        $challan_link = $file_full_path;
        // echo json_encode($file_full_path);
        // exit;
        //********************************************************************/
        //settlement_installment_details 
        $pre_remaining_amount_new = $pre_remaining_amount-$_POST['paid_installment_amount'];
        $pre_paid_amount_new = $pre_paid_amount + $_POST['paid_installment_amount'];
        $response = json_encode([
            "manual_challan_path" => $challan_link,
            "posted_data" => $_POST,
            "user_data" => $this->session->all_userdata()
        ]);
        $settlement_installment_insert_data = [
            "reff_no"=> "manualIpWpl_".$_POST['grn_no'],
            "sub_reff_no"=>"manualIpWpl_".$installment_no."_".$_POST['grn_no'],
            "installment_no"=>$installment_no,
            "rtps_application_no"=>$_POST['application_no'],
            "dharitree_case_no"=>$_POST['case_no'],
            "payment_link_configuration"=> json_encode($_POST),
            "status"=>'Y',
            "total_premium"=>$total_premium,
            "pre_remaining_amount"=>$pre_remaining_amount_new,
            "pre_paid_amount"=>$pre_paid_amount_new,
            "installment_amount"=>$installment_amount,
            "paid_installment_amount"=> $_POST['paid_installment_amount'],
            "no_of_installment_paid"=> $_POST['no_of_installment'],
            "created_at"=>date('Y-m-d H:i:s'),
            "grn_no"=>$_POST['grn_no'],
            "payment_response"=>$response,
            "service_code"=>$sb_row->service_code,
            "installment_payment_link_created_date"=>date('Y-m-d'),
            "installment_payment_received_date"=>date('Y-m-d'),
            "payment_process"=>'WITHOUT-LINK',
            "payment_mode"=>"OFFLINE",
            "gras_payment_date"=>$_POST['payment_date'],
        ];
        // echo "<pre>";
        // var_dump($settlement_installment_insert_data);
        // echo "</pre>";
        // exit;
        //********************************************************************/
        //********************************************************************/
        //settlement_emi_history details        
        $sp_query = $this->db->query("select * from settlement_premium where case_no=? and is_final=? 
                                      and grn_no is not null", array($_POST['case_no'], '1'));                        
        $sp_details = $sp_query->result();
        $dag_no_arr = array();
        foreach($sp_details as $sp_detail){
            array_push($dag_no_arr, $sp_detail->dag_no);
            if($sp_details[0]->grn_no == $_POST['grn_no'])
            {
                echo json_encode(['result' => 'FAILED', 'msg' => 'GRN alreday exists, Error-Code : #grnmatch0201']);
                exit;
            }
        }
        $dag_no_str_string = implode(',', $dag_no_arr);
        if($pre_remaining_amount_new <= 0){
            $is_full_paid = 1;            
        }else{
            $is_full_paid = 0;
        }
        $settlement_emi_history_insert_data = [
            "case_no"=>$_POST['case_no'],
            "application_no"=>$_POST['application_no'],
            "final_amount"=>$total_premium,
            "paid_amount"=>$pre_paid_amount_new,
            "remaining_amount"=>$pre_remaining_amount_new,
            "tenure"=>$sp_details[0]->tenure,
            "installment_amount"=>$installment_amount,
            "payment_date"=>date('Y-m-d'),
            "grn_no"=>$_POST['grn_no'],
            "old_dag_no"=>$dag_no_str_string,             
            "is_full_paid"=> $is_full_paid,
            "date_entry"=> date('Y-m-d h:i:s'),
            "date_update"=> date('Y-m-d h:i:s'),
            "ekhajana_application_no" => null,
            "settlement_dag_no" => null,
            "challen_link" => $challan_link,
            "paid_installment_amount" => $_POST['paid_installment_amount'],
            "paid_installment_no" => $installment_no,
            "paid_no_of_installment" => $_POST['no_of_installment']
        ];
        // echo "<pre>";
        // var_dump($settlement_emi_history_insert_data);
        // echo "</pre>";
        // exit;
        //********************************************************************/
        $inStatus2=$this->db->insert('settlement_emi_history',$settlement_emi_history_insert_data);
        if($inStatus2 != 1){
            $this->db->trans_rollback();
            log_message('error','#DMIPSEHIERR, UNBALE TO INSERT IN settlement_emi_history TABLE, FOR THE APPLICATION NO '. $si_last_row->dharitree_case_no);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DMIPSEHIERR']);
        }
        //********************************************************************/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => SAVE_MANUAL_INSTALLMENT_PAYMENT_WITHOUT_LINK_INFO_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('rtps_application_no' => $_POST['application_no'], 'case_no' => $_POST['case_no'], 'insert_data'=>json_encode($settlement_installment_insert_data)),            
        ));
        $response = curl_exec($curl);        
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpcode != 200){
            log_message('error','#DSIPGL006S-200E, CURL 200 ERROR IN '.SAVE_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API FOR THE APPLICATION NO  '. $si_last_row->dharitree_case_no);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPGL006S-200E']);
            exit;
        }
        $responseObj = json_decode($response);
        // curl_close($curl);
        // echo "<pre>";
        // var_dump($responseObj);
        // echo "</pre>";
        // exit;
        if($responseObj->result == false){
            log_message('error','#DSIPGL0066S, ERROR IN '.SAVE_MANUAL_INSTALLMENT_PAYMENT_INFO_URL.' API WITH RESPONSE '. json_encode($responseObj));            
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #DSIPGL0066S']);
            exit;
        }
        //**************************************************************************/
        $this->db->trans_commit();
        echo json_encode(['result' => 'SUCCESS', 'msg' => 'Installment Details Updated Successfully, The Newly Added Installment Info Will Be Displayed In The INSTALLMENT PAYMENT INFORMATION Section Of This Page..!']);        
    }
}
