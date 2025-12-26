<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/libraries/CommonTrait.php';

class SkConversionController extends CI_Controller {

    use CommonTrait;

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['SK'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/SKofficeConversionModel');
        $this->load->library('form_validation');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('v2/Services/Conversion/ConversionModel');
        $this->load->model('v2/PetitionerPartModel');
        $this->load->model('v2/PetitionBasicModel');
        $this->load->model('v2/PetitionDagDetailsModel');
        $this->load->model('v2/ChithaDagPattadarModel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('v2/PetitionLmNoteModel');
        $this->load->model('v2/BasundharApplicationModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        //$this->load->model('ConversionEscalationModel');
    }


    public function GoToSK() {
        $process = $this->input->get('pro');
        if ($process == '1') {
            $config['total_rows'] = $this->SKofficeConversionModel->countPendingConversionCasesSKMb3();
            $cases['cases'] = $this->SKofficeConversionModel->getPendingConversionCasesSKMb3()->result();
        }

        $cases['process'] = $process;
        
        $this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/SKofficeconversion/sk_conversion_cases', $cases);
        //$this->load->view('../views/footer');

        $cases['_view'] = 'conversion/sk/sk_proceeding_cases';
        $this->load->view('layouts/main',$cases);
    }

    public function skFirstProceeding() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVSKFIRSTVIEW001');
            $this->session->set_flashdata('message', 'Case No. not set. Error: ERRCONVSKFIRSTVIEW001');
            redirect(base_url('index.php/home'));
        }
        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'SK', $_GET['case_no'], CONV_SK_FIRST);
        if($authorization['status']=='n') {
            //ERRCONVSKFIRSTVIEW002
            log_message('error', $authorization['messages'] .' Error: ERRCONVSKFIRSTVIEW002');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVSKFIRSTVIEW002');
            redirect(base_url('index.php/home'));
        }

        $case_no = $this->input->get('case_no');
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'co,lm,sk',
            'process'=>'sk_first_proceeding',
            'default_report'=>'sk'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function skFirstProceedingPost() {
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'sk_notice'=>'SK Notice|required',
            'sk_sign'=>'SK Sign|required|char',
            'sk_code'=>'SK Code|required',
            'sk_name'=>'SK Name|required',
            // 'sk_date_of_entry'=>'SK Date of Entry|required|date',
            'case_no'=>'Case No.|required|case_no',
            'dag_no'=>'Dag No.|required|digit',
            'note_no'=>'Note No.|required|digit',
         ]);
         if($formValidation['status'] == 'n') {
            //ERRCONVSK0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVSK0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVSK0001',
            ]);
            exit();
         }

         //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVSK0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVSK0002');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVSK0002',
            ]);
            exit();
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVSK0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVSK0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVSK0003',
            ]);
            exit();
        }

        // authentication and authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'SK', $_POST['case_no'], CONV_SK_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVSK0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVSK0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$authorization['messages'] . '. Error: #ERRCONVSK0004',
            ]);
            exit();
        }

        $sk_notice = $this->input->post('sk_notice');
        $sk_sign = $this->input->post('sk_sign');
        $sk_code = $this->input->post('sk_code');
        $sk_name = $this->input->post('sk_name');
        $sk_date_of_entry = date('Y-m-d H:i:s');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $note_no = $this->input->post('note_no');
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no' => $case_no]);
        if(empty($petitionBasic)) {
            //ERRCONVSK0005
            $this->db->trans_rollback();
            log_message('error', 'Cannot find case_no in petition_basic. Error: ERRCONVSK0005');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not find Case No. Error: #ERRCONVSK0005',
            ]);
            exit();        
        }

        //update petition_lm_note
        $petition_lm_note_update_arr = [
            'sk_note_date' => $sk_date_of_entry,
            'sk_note' => $sk_notice,
            'user_code' => $sk_code,
            'sk_sign_yn' => $sk_sign
        ];
        $this->db->where([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'petition_no' => $petitionBasic->petition_no,
            'dag_no' => $dag_no,
            'note_no' => $note_no
        ]);
        $petitionLmNoteStatus = $this->db->update('petition_lm_note', $petition_lm_note_update_arr);
        if(!$petitionLmNoteStatus || $this->db->affected_rows() < 1) {
            //ERRCONVSK0006
            $this->db->trans_rollback();
            log_message('error', 'Error in updating petition_lm_note table. Error: ERRCONVSK0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'DB Updation Failed. Error: #ERRCONVSK0006',
            ]);
            exit();
        }

        //insert into petition_proceeding
        $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
            'co_order' => $getPreviousPetitionProceeding->co_order,
            'note_on_order' => 'LRS Forwarded to CO',
            'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => null,
            'lot_no' => null,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            //ERRCONVSK0006
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in petition_proceeding. Error: ERRCONVSK0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'DB Insertion error. Error: ERRCONVSK0006'
            ]);
            exit();
        }

        //update petition_basic
        $petition_basic_update_arr = [
            'sk_comment' => 'Y',
            // 'proceeding_yn' => '1',
            'new_status' => 'LRSCO'
        ];
        $this->db->where([
            'case_no' => $case_no
        ]);
        $petitionBasicUpdateStatus = $this->db->update('petition_basic', $petition_basic_update_arr);
        if(!$petitionBasicUpdateStatus || $this->db->affected_rows() < 1) {
            //ERRCONVSK0007
            $this->db->trans_rollback();
            log_message('error', 'Error in update query in petition_basic. Error: ERRCONVSK0007');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'DB Updation error. Error: ERRCONVSK0007'
            ]);
            exit();
        }

        $penUser='CO';
        $rmrk='Report by SK';
        $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
        $rmk=$rmrk;
        $status='M';
        $task='SK';
        $pen='CO';
        $case=$case_no;
        $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        
        if(trim($rtps_status) !="y") {
            //ERRCONVCOFIRST0012
            $this->db->trans_rollback();
            log_message('error', 'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVSKFIRST00912');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVSKFIRST00912'
            ]);
            exit();
        }

        if($this->db->trans_status() == FALSE) {
            //ERRCONVSK0008
            $this->db->trans_rollback();
            log_message('error', 'Error in transaction. Error: ERRCONVSK0008');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Transaction Error. Error: ERRCONVSK0008'
            ]);
            exit();
        }

        $this->db->trans_commit();

        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=>'Successfully forwarded to Circle Officer. Case No: ' . $case_no
        ]);
        exit();
    }


}