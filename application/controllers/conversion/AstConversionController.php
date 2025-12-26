<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/libraries/CommonTrait.php';

class AstConversionController extends CI_Controller {

    use CommonTrait;

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('v2/PetitionBasicModel');
        $this->load->model('v2/UsersModel');
        $this->load->model('v2/BasundharApplicationModel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('v2/Services/Conversion/ConversionModel');
        $this->load->model('v2/PetitionProceedingModel');
        $this->load->model('conversion/MbOfficeConversionModel');
        $this->load->model('basundhara/SettlementApiModel');
        ini_set('memory_limit', '1024M');
        if(ENABLED_BLOCKCHAIN == 1)
        {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }
    }

    public function GoToAST() {
		//$db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $this->load->library('pagination');
        $process = $this->input->get('pro');

        if ($process == '1') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingNoticeGeneratedAST($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingNoticeGeneratedAST($user_code)->result();
        } elseif ($process == '2') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingActionTakenAST($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingActionTakenAST($user_code)->result();
        } elseif ($process == '3') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingPremiumAST($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingPremiumAST($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingPaymentAST($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingPaymentAST($user_code)->result();
        }

        $cases['process'] = $process;
        $cases['_view'] = 'conversion/ast/ast_proceeding_cases';
        $this->load->view('layouts/main',$cases);

    }

    // code by Bhaskar
    public function savePremiumNotice() {        
        // Check if validation failed
        if (!isset($_POST['case_no']) || !isset($_POST['amount'])) {
            echo json_encode([
                'status' => 'FAILED',
                'msg' => 'Case No. or Amount is missing'
            ]);
            exit();
        }
    
        // Extract POST data
        $case_no = $this->input->post('case_no');
        $amount = $this->input->post('amount');
        $html_content = $this->input->post('html_content'); // If included in AJAX
        $user_code = $this->session->userdata('user_code');
    
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp = date('mdYhis', time()).uniqid();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no' => $case_no]);
        $petition_no = $petitionBasic->petition_no;
        
        // preg_match('/\/(\d+)\//', $case_no, $matches);

        // if (!empty($matches[1])) {
        //     $petition_no = $matches[1];
        // } else {
        //     echo json_encode([
        //         'status' => 'FAILED',
        //         'msg' => 'Application number not found'
        //     ]);
        // }
    
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = CONVERSION_DOCS_BASE_DIR .'Premium_Notice' .UPLOAD_SEPARATOR. $petition_no.'_'.$timestamp. ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($html_content);
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
    
    
        // Prepare data for insertion
        $data = [
            'case_no' => $case_no,
            'user_code' => $user_code,
            // 'amount' => $amount,
            'file_name' => 'Premium Notice', // Adjust this as needed
            'file_type' => 'application/json',
            'file_path' => $base_64_file_path, // Update path
            'date_entry' => date('Y-m-d H:i:s'),
            'mut_type' => '01',
            'fetch_file_name' => $petition_no.'_'.$timestamp. ".json",
            'applid' => '',
            'dag_no' => '',
            'doc_flag' => '',
            'api_doc_id' => ''
        ];
    
        // Insert into database
        $insert = $this->db->insert('supportive_document', $data);
        // echo $this->db->last_query(); die;
        if ($insert) {
            try {
                // Fetch `basundhara` from `basundhar_application`
                $rtps_case_no = $this->db->get_where('basundhar_application', ['dharitree' => $case_no])->row()->basundhara ?? null;
        
                // Fetch `prim_tot` (amount) from `petition_lm_note`
                $amount = $this->db->get_where('petition_lm_note', ['case_no' => $case_no])->row()->prim_tot ?? null;
        
                // Check if values are retrieved correctly
                if (!$rtps_case_no || !$amount) {
                    echo json_encode([
                        'status' => 'FAILED',
                        'msg' => 'Cannot send the premium notice to RTPS. Required data missing.'
                    ]);
                    exit;
                }
        
                // Initialize cURL request to the API
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                    'encoded_file' => $htmlstring_text,  // Assuming it's already a JSON-encoded string
                    'application_no' => $rtps_case_no,
                    'type' => 'PN',
                    'amount' => $amount,
                    'is_full_pay' => 'Y'
                ]));
        
                $result = curl_exec($curl_handle);
                curl_close($curl_handle);
        
                // Handle API response
                if (trim($result) !== 'y') {
                    echo json_encode([
                        'status' => 'FAILED',
                        'msg' => 'Cannot send the premium notice to RTPS. API error.'
                    ]);
                    exit;
                }
        
                echo json_encode([
                    'status' => 'SUCCESS',
                    'msg' => 'Premium notice saved and sent successfully.'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'FAILED',
                    'msg' => 'An unexpected error occurred: ' . $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'FAILED',
                'msg' => 'Database insertion failed'
            ]);
        }
        exit();
        }
    
    

    public function premiumNotice() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVASTPREMVIEW001');
            $this->session->set_flashdata('message', 'Case No. not set. Error: ERRCONVASTPREMVIEW001');
            redirect(base_url('index.php/home'));
        }
        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_GET['case_no'], CONV_AST_PREMIUM_NOTICE);
        if($authorization['status']=='n') {
            //ERRCONVLMFIRSTVIEW002
            log_message('error', $authorization['messages'] .' Error: ERRCONVASTPREMVIEW002');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVASTPREMVIEW002');
            redirect(base_url('index.php/home'));
        }

        $case_no = $this->input->get('case_no');
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'co,lm,sk,ast',
            'process'=>'premium_notice',
            'default_report'=>'ast'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function premiumNoticeSave() {
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'amount'=>'Amount|required|4_digit_decimal'
         ]);
         if($formValidation['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTPREMNOTICE0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVASTPREMNOTICE0001',
            ]);
            exit();
         }

         //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTPREMNOTICE0002');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVASTPREMNOTICE0002',
            ]);
            exit();
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTPREMNOTICE0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVASTPREMNOTICE0003',
            ]);
            exit();
        }

        //Authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_PREMIUM_NOTICE);
        if($authorization['status']=='n') {
            //ERRCONVASTPREMNOTICE0004
            log_message('error', $authorization['messages'] .' Error: ERRCONVASTPREMNOTICE0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$authorization['messages'] . '. Error: #ERRCONVASTPREMNOTICE0004',
            ]);
            exit();
        }

        $case_no = $this->input->post('case_no');
        $amount = $this->input->post('amount');
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $petitionBasicUpdateArr = [
            'co_order_conv_notice' => null,
            'pay_notice_gen_yn' => 'Y',
            'new_status' => 'ASPNS'
        ];
        $this->db->where([
            'case_no' => $case_no
        ]);
        $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
        if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
            // ERRCONVASTPREMNOTICE0005
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVASTPREMNOTICE0005');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB updation Error. Error: #ERRCONVASTPREMNOTICE0005',
            ]);
            exit();
        }

        //insert into petition_proceeding
        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
            'co_order' => $getPreviousPetitionProceeding->co_order,
            'note_on_order' => 'Premium Notice Given By AST',
            'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert('petition_proceeding', $proceeding_data);
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            // ERRCONVASTPREMNOTICE0006
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVASTPREMNOTICE0006');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB updation Error. Error: #ERRCONVASTPREMNOTICE0006',
            ]);
            exit();
        }

        $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
        if($basundharApplication) {
            $rmk='Payment Notice Generated';
            $status='Q';
            $task='AST';
            $pen='AST';
            $case=$basundharApplication;
            $success=$this->basundharamodel->payqueryRequestMb3($basundharApplication,$amount);
            if(!$success) {
                // ERRCONVASTPREMNOTICE0007
                $this->db->trans_rollback();
                log_message('error', 'Error in updation in basundhara. Error: ERRCONVASTPREMNOTICE0007');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Error. Error: #ERRCONVASTPREMNOTICE0007',
                ]);
                exit();
            }
            $penUser='AST';
            $rmrk='Notice for premium by AST';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            // $rtps_status = json_decode($this->basundharamodel->postApiBasundharaConvMb3($case_no,$rmrk,$status,$task,$pen));
            $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($case, $case_no, $rmk, $status, $task, $pen);
            // var_dump($rtps_status); die;
            if (trim($rtps_status) =="n") {
                // ERRCONVASTPREMNOTICE0009
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVASTPREMNOTICE0009');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVASTPREMNOTICE0009',
                ]);
                exit();
            }
        }


        if($this->db->trans_status() == FALSE) {
            // ERRCONVASTPREMNOTICE0008
            $this->db->trans_rollback();
            log_message('error', 'DB Transaction Failed. Error: ERRCONVASTPREMNOTICE0008');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB Transaction Error. Error: #ERRCONVASTPREMNOTICE0008',
            ]);
            exit();
        }

        $this->db->trans_commit();
        echo json_encode([
            'status' => 'SUCCESS',
            'responseType' => 2,
            'msg' => 'Successfully generated the premium notice for case no: ' . $case_no,
        ]);
        exit();
    }

    public function premiumConfirm() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVASTCONFPREMVIEW001');
            $this->session->set_flashdata('message', 'Case No. not set. Error: ERRCONVASTCONFPREMVIEW001');
            redirect(base_url('index.php/home'));
        }
        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_GET['case_no'], CONV_AST_CONFIRM_PREMIUM);
        if($authorization['status']=='n') {
            //ERRCONVLMFIRSTVIEW002
            log_message('error', $authorization['messages'] .' Error: ERRCONVASTCONFPREMVIEW002');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVASTCONFPREMVIEW002');
            redirect(base_url('index.php/home'));
        }

        $case_no = $this->input->get('case_no');
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'co,lm,sk,ast,premium',
            'process'=>'confirm_premium',
            'default_report'=>'ast'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function premiumConfirmSave() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no' => 'Case No.|required|case_no',
            'submit_type' => 'Submit type|required',
            'payment_type' => 'Payment Type|required_on_condition(submit_type,equals,[got_premium])',
            'chalan_no' => 'Challan No.|required_on_condition(payment_type,notEquals,[003])',
            'payment_date' => 'Payment Date|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVASTCONFIRM0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTCONFIRM0001');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $formValidation['message'] . '. Error: #ERRCONVASTCONFIRM0001'
            ]);
            exit();
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVASTCONFIRM0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTCONFIRM0002');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $requestResponse['messages'] . '. Error: #ERRCONVASTCONFIRM0002'
            ]);
            exit();
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVASTCONFIRM0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTCONFIRM0003');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $validResponse['messages'] . '. Error: #ERRCONVASTCONFIRM0003'
            ]);
            exit();
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_CONFIRM_PREMIUM);
        if($authorization['status'] == 'n') {
            //ERRCONVASTCONFIRM0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVASTCONFIRM0004');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $authorization['messages'] . '. Error: #ERRCONVASTCONFIRM0004'
            ]);
            exit();
        }

        $case_no = $this->input->post('case_no', true);
        $submit_type = $this->input->post('submit_type', true);
        if($submit_type == 'got_premium') {
            $payment_type = $this->input->post('payment_type', true);
            $chalan_no = $this->input->post('chalan_no', true);
            $payment_date = $this->input->post('payment_date', true);
        }
        else if($submit_type == 'basu_premium') {
            $payment_date = $this->input->post('payment_date', true);
        }
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no' => $case_no]);
        if($submit_type == 'no_premium') {
            //chitha_basic update
            $petitionBasicUpdateArr = [
                'co_order_conv_notice' => null,
                'co_order_conv_premium' => null,
                'new_status' => 'ASPCA'
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVASTCONFIRM0005
                $this->db->trans_rollback();
                log_message('error','DB updation failed in petition_basic table. Error: #ERRCONVASTCONFIRM0005');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Error. Error: #ERRCONVASTCONFIRM0005'
                ]);
                exit();
            }

            //petition_lm_note update
            $petitionLmNoteUpdateArr = [
                'recpt_number' => 'N'
            ];
            $this->db->where([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no,
                'co_reject' => null
            ]);
            $petitionLmNoteUpdate = $this->db->update('petition_lm_note', $petitionLmNoteUpdateArr);
            if(!$petitionLmNoteUpdate || $this->db->affected_rows() < 1) {
                //ERRCONVASTCONFIRM0006
                $this->db->trans_rollback();
                log_message('error','DB updation failed in petition_lm_note table. Error: #ERRCONVASTCONFIRM0006');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Error. Error: #ERRCONVASTCONFIRM0006'
                ]);
                exit();
            }

            //petition_proceeding insert
            $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
            $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
            $proceeding_data = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
                'co_order' => $getPreviousPetitionProceeding->co_order,
                'note_on_order' => 'Payment not confirmed by AST',
                'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
                'status' => 'Done',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'ip' => $this->utilityclass->get_client_ip()
            ];
            $insertPetitionProceeding = $this->db->insert('petition_proceeding', $proceeding_data);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVASTCONFIRM0007
                $this->db->trans_rollback();
                log_message('error','DB insertion failed in petition_proceeding table. Error: #ERRCONVASTCONFIRM0007');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB insertion Error. Error: #ERRCONVASTCONFIRM0007'
                ]);
                exit();
            }

            $penUser='CO';
            $rmrk='Payment not confirmed by AST';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($basundharApplication, $case_no, $rmrk, $status, $task, $pen);
            if (trim($rtps_status) =="n") {
                // ERRCONVASTCONFIRM0008
                $this->db->trans_rollback();
                log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVASTCONFIRM0008');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVASTCONFIRM0008',
                ]);
                exit();
            }

            if($this->db->trans_status() == FALSE) {
                //ERRCONVASTCONFIRM0009
                $this->db->trans_rollback();
                log_message('error','DB Transaction Failed. Error: #ERRCONVASTCONFIRM0009');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB Transaction Error. Error: #ERRCONVASTCONFIRM0009'
                ]);
                exit();
            }
            $this->db->trans_commit();

            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Record Successfully updated for case No: ' . $case_no
            ]);
            exit();

        }
        else if($submit_type == 'got_premium') {
            if(!isset($_FILES['up_prem_conv']) || !isset($_FILES['up_prem_conv']['name']) || $_FILES['up_prem_conv']['name'] == '' || $_FILES['up_prem_conv']['error'] == 4) {
                //ERRCONVASTCONFIRM0010
                log_message('error', 'Premium Challan file upload is mandatory for case_no: ' . $case_no . '. Error: ERRCONVASTCONFIRM0010');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Premium Challan file upload is mandatory for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0010',
                ]);
                exit();
            }

            $path = CONVERSION_PREMCHALLAN_BASE_DIR;
            if(!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $this->db->trans_begin();

            $sl = $this->SupportiveDocumentModel->get(['case_no' => $case_no], 'COUNT(*)')->count + 1;
            
            $file = $petitionBasic->petition_no.date('Y').'_'.$sl;
            $ext = pathinfo($_FILES['up_prem_conv']['name'], PATHINFO_EXTENSION);
            
            $_FILES['up_prem_conv']['name'] = $file.'.'.$ext;

            $config = array(
                'upload_path' => $path,
                'allowed_types' => FILE_TYPE,
                'max_size' => MAX_SIZE,
            );
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('up_prem_conv')) {
                //ERRCONVASTCONFIRM0011
                $this->db->trans_rollback();
                log_message('error', 'Premium Challan uploading failed for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0011');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Premium Challan uploading failed for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0011'
                ]);
                exit();
            }
            $data = $this->upload->data();
            if(!file_exists($data['full_path'])) {
                $this->db->trans_rollback();
                log_message('error', 'Premium Challan file could not be uploaded for case no: ' . $case_no);
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Premium Challan file could not be uploaded for case no: ' . $case_no
                ]);
                exit();
            }
            $supportiveDocArr = [
                'case_no' => $case_no,
                'user_code' => $user_code,
                'file_name' => NOC,
                'fetch_file_name' => $file . $data['file_ext'],
                'file_type' => $data['file_type'],
                'file_path' => $path . $file . $data['file_ext'],
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => 'NA',
            ];
            $insertSupportiveDoc = $this->db->insert('supportive_document', $supportiveDocArr);
            if(!$insertSupportiveDoc || $this->db->affected_rows() < 1) {
                // ERRCONVASTCONFIRM0012
                $this->db->trans_rollback();
                log_message('error', 'DB insertion Failed in supportive_document table for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0012');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB Insertion Error for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0012'
                ]);
                exit();
            }

            //petition_basic update
            $petitionBasicUpdateArr = [
                'co_order_conv_notice' => null,
                'co_order_conv_premium' => 'P',
                'proceeding_yn' => 1,
                'status' => 'W',
                'new_status' =>'ASPPC'
            ];
            $this->db->where([
                'case_no' => $case_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionBasicUpdate = $this->db->update('petition_basic', $petitionBasicUpdateArr);
            if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
                // ERRCONVASTCONFIRM0013
                $this->db->trans_rollback();
                log_message('error', 'DB updation Failed in petition_basic table for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0013');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB Updation Error for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0013'
                ]);
                exit();
            }

            //petition_lm_note update
            $petitionLmNoteUpdateArr = [
                'astt_confirm' => 'Y',
                'prem_pay_method' => $payment_type,
                'recpt_number' => $chalan_no,
                'prem_pay_date' => $payment_date
            ];
            $this->db->where([
                'petition_no' => $petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'co_reject' => null
            ]);
            $petitionLmNoteUpdate = $this->db->update('petition_lm_note', $petitionLmNoteUpdateArr);
            if(!$petitionLmNoteUpdate || $this->db->affected_rows() < 1) {
                // ERRCONVASTCONFIRM0014
                $this->db->trans_rollback();
                log_message('error', 'DB updation Failed in petition_lm_note table for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0014');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB Updation Error for case no: ' . $case_no . '. Error: #ERRCONVASTCONFIRM0014'
                ]);
                exit();
            }
            //petition_proceeding insert
            $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
            $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
            $proceeding_data = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
                'co_order' => $getPreviousPetitionProceeding->co_order,
                'note_on_order' => 'Payment confirmed by AST',
                'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
                'status' => 'Done',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'ip' => $this->utilityclass->get_client_ip()
            ];
            $insertPetitionProceeding = $this->db->insert('petition_proceeding', $proceeding_data);
            if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
                //ERRCONVASTCONFIRM0015
                $this->db->trans_rollback();
                log_message('error','DB insertion failed in petition_proceeding table. Error: #ERRCONVASTCONFIRM0015');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB insertion Error. Error: #ERRCONVASTCONFIRM0015'
                ]);
                exit();
            }
            //
            $penUser='CO';
            $rmrk='Payment confirmed by AST';
            $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            if($basundharApplication) {
                $success = $this->basundharamodel->postApiManualPaymentMb3($case_no,$task);
                if(!$success || intval($success) < 1) {
                    //ERRCONVASTCONFIRM0016
                    $this->db->trans_rollback();
                    log_message('error','Basundhara postApiManualPayment method API failed. Error: #ERRCONVASTCONFIRM0016');
                    echo json_encode([
                        'status' => 'FAILED',
                        'responseType' => 1,
                        'msg' => 'Basundhara API Failed. Error: #ERRCONVASTCONFIRM0016'
                    ]);
                    exit();
                }
                // $rtps_status = json_decode($this->basundharamodel->postApiBasundharaConvMb3($case_no,$rmrk,$status,$task,$pen));
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($basundharApplication, $case_no, $rmrk, $status, $task, $pen);
                if (trim($rtps_status) =="n") {
                    // ERRCONVASTCONFIRM0017
                    $this->db->trans_rollback();
                    log_message('error', 'Settlement Application not submitted for case no '. $case_no .'. Error: ERRCONVASTCONFIRM0017');
                    echo json_encode([
                        'status'=>'FAILED',
                        'responseType'=>1,
                        'msg'=> 'Settlement Application not submitted for case no '. $case_no .'. Error: #ERRCONVASTCONFIRM0017',
                    ]);
                    exit();
                }
            }

            //db transaction
            if($this->db->trans_status() == FALSE) {
                // ERRCONVASTCONFIRM0018
                $this->db->trans_rollback();
                log_message('error', 'DB Transaction failed. Error: #ERRCONVASTCONFIRM0018');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB Transaction error. Error: #ERRCONVASTCONFIRM0018'
                ]);
                exit();
            }
            $this->db->trans_commit();
            
            echo json_encode([
                'status' => 'SUCCESS',
                'responseType' => 2,
                'msg' => 'Premium Payment Successfully Confirmed for case No: ' . $case_no
            ]);
            exit();
        }
        else if($submit_type == 'basu_premium') {
            
        }





        echo '<pre>';
        var_dump($authorization);
        die();
    }


    /*
public function confirmation_premium_save() {
        if(!isset($_POST['paymentBasu'])) {
            // form validation
            $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
                'case_no'=>'Case No.|required|case_no',
                'payment_type'=>'Type of Premium|digit',
                'chalan_no'=>'Challan No|digit',
            ]);
            if($formValidation['status'] == 'n') {
                //ERRCONVASTCONFIRM0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTCONFIRM0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVASTCONFIRM0001');
                redirect(base_url('index.php/AsistantMutationPartha/GoToAST?pro=4'));
            }

            //syntax validation
            $requestResponse = checkRequestSpecChar($_POST);
            if($requestResponse['status'] == 'n') {
                //ERRCONVASTCONFIRM0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTCONFIRM0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVASTCONFIRM0002');
                redirect(base_url('index.php/AsistantMutationPartha/GoToAST?pro=4'));
            }

            //malicious query validation
            $validResponse = checkRequestValidQuery($_POST);
            if($validResponse['status'] == 'n') {
                //ERRCONVASTCONFIRM0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTCONFIRM0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVASTCONFIRM0003');
                redirect(base_url('index.php/AsistantMutationPartha/GoToAST?pro=4'));
            }

            //authorization
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_CONFIRM_PREMIUM);
            if($authorization['status'] == 'n') {
                //ERRCONVASTCONFIRM0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVASTCONFIRM0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVASTCONFIRM0004');
                redirect(base_url('index.php/home'));
            }

            // echo '<pre>';
            // var_dump($_POST);
            // die();
        }

		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->input->post('case_no');
        $payment_type = $this->input->post('payment_type');
        $chalan_no = $this->input->post('chalan_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                        . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        if (isset($_POST['submit2'])) {
            //echo "one";
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = NULL  WHERE case_no = '$case_no' "
                    . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment not confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            $this->basundharamodel->postApiBasundharaConvMb3($case_no,$rmk,$status,$task,$pen);
            ////////////////////////////////////////

            $this->db->query("UPDATE petition_lm_note SET recpt_number = 'N' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
            $this->session->set_flashdata('message', "Conversion Case no # $case_no will be sent back to Circle officer without Confirmation of Premium. Please Give the action taken report.");
        }
        if(isset($_POST['paymentBasu'])){

            $petition_basic_update2="UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
            $this->db->query($petition_basic_update2); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0021: Unable to pass order !");
                log_message("error","#ASCON0021 Failed to update petition_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $petition_lm_note_update2="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '200', recpt_number = 'basundhara_payment' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
            $this->db->query($petition_lm_note_update2);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0022: Unable to pass order !");
                log_message("error","#ASCON0022 Failed to update petition_lm_note for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk='Payment Received';
            $status='M';
            $task='AST';
            $pen='CO';
            $this->session->set_flashdata('message', "Payment confirmed, submit action taken report !");
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $this->basundharamodel->postApiBasundharaConvMb3($case_no,$rmrk,$status,$task,$pen);
            }else{
                $this->db->trans_commit();
            }
            ////////////////////////////////////////
        }
        if (isset($_POST['submit1'])) {
            $formValid = $this->FormValidationModel->formValidationForPost($_POST, [
                'payment_type'=>'Type of Premium|required|digit',
                'chalan_no'=>'Challan No|required_on_condition(payment_type,notEquals,[003])|3_digit_decimal',
            ]);
            if($formValid['status'] == 'n') {
                //ERRCONVASTCONFIRM0005
                log_message('error', 'Message: '. $formValid['message'] .', Data: '. json_encode($formValid['data']) .'. Error: ERRCONVASTCONFIRM0005');
                $this->session->set_flashdata('message', $formValid['message'] .' Error: ERRCONVASTCONFIRM0005');
                redirect(base_url('index.php/AsistantMutationPartha/GoToAST?pro=4'));
            }

            $path = CONVERSION_PREMCHALLAN_BASE_DIR;
            
            if(!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $this->db->trans_begin();
            // $config['upload_path'] = './ConversionDocs/PremChallan/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);

            //Premium challan upload validation starts here

            $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
            $sl = $count+1;
            // $path = './ConversionDocs/PremChallan/';
            
            $file = $petition_basic->petition_no.date('Y').'_'.$sl;
            
            $_FILES['file']['type'] = $_FILES['up_prem_conv']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['up_prem_conv']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['up_prem_conv']['error'];
            $_FILES['file']['size'] = $_FILES['up_prem_conv']['size'];

            $ext = pathinfo($_FILES['up_prem_conv']['name'], PATHINFO_EXTENSION);
            $_FILES['file']['name'] = $file.'.'.$ext;

            // var_dump($_FILES['file']); die();

            // $file_path = './ConversionDocs/PremChallan/';

            $config = array(
                // 'upload_path' => './ConversionDocs/PremChallan/',
                'upload_path' => $path,
                'allowed_types' => FILE_TYPE,
                'max_size' => MAX_SIZE,
            );
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'file_name' => NOC,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ASCON0010: Unable to pass order !");
                    log_message("error","#ASCON0010 Uploading Failed for dist:"
                                .$dist_code.", case no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }
            else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0009: Unable to pass order !");
                log_message("error","#ASCON0009 Uploading Failed for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////Premium challan ends here////////

            $petition_basic_update="UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
            $this->db->query($petition_basic_update); // ********************
            // echo $this->db->last_query(); die;
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0011: Unable to pass order !");
                log_message("error","#ASCON0011 Failed to update petition_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $petition_lm_note_update="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '$payment_type', recpt_number = '$chalan_no' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
            $this->db->query($petition_lm_note_update);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0012: Unable to pass order !");
                log_message("error","#ASCON0012 Failed to update petition_lm_note for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $success=$this->basundharamodel->postApiManualPayment($case_no,$task);  
                log_message("info", "************ success=".$success);
                // $this->db->trans_rollback(); die();
                if(intval($success) > 0){
                    $this->db->trans_commit();
                    $this->basundharamodel->postApiBasundharaConvMb3($case_no,$rmk,$status,$task,$pen);
                }else{
                    // $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ASCON0013: Unable to pass order !");
                    log_message("error","#ASCON0013 Failed to update payment confirmation for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }else{
                $this->db->trans_commit();
            }
            ////////////////////////////////////////
            $this->session->set_flashdata('message', "Payment of Premium Confirmed on Conversion Case no # ". $case_no);
        }
        redirect(base_url() . "index.php/home");
    }
    */
}
