<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/libraries/CommonTrait.php';

class LmConversionController extends CI_Controller {

    use CommonTrait;

    public function __construct() {
        parent::__construct();
        // Allowed designations
        $allowed = ['LM', 'LRA'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/LMofficeConversionModel');
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
        $this->load->model('v2/PetitionProceedingModel');
        $this->load->model('v2/ConversionPremiumRatesModel');
        $this->load->model('conversion/MbOfficeConversionModel');
        //$this->load->model('ConversionEscalationModel');
    }

    public function GoToLM() {
        $this->dbswitch();
		//s$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $process=$this->input->get('pro');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        if($process == '1')
        {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no)->result();
        }
        
        $cases['process'] = $process;
        //var_dump($cases);
        $this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/lm_office_conversion/lm_conversion_cases', $cases);
        //$this->load->view('../views/footer');
        // $cases['_view'] = 'lm_office_conversion/lm_conversion_cases';
        $cases['_view'] = 'conversion/lm/lm_proceeding_cases';
        $this->load->view('layouts/main',$cases);
    }

    public function lmFirstProceeding() {
        if(!isset($_GET['case_no'])) {
            log_message('error', 'Case No not set. Error: ERRCONVLMFIRSTVIEW001');
            $this->session->set_flashdata('message', 'Case No. not set. Error: ERRCONVLMFIRSTVIEW001');
            redirect(base_url('index.php/home'));
        }
        //authorization
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_GET['case_no'], CONV_LM_FIRST);
        // if($authorization['status']=='n') {
        //     //ERRCONVLMFIRSTVIEW002
        //     log_message('error', $authorization['messages'] .' Error: ERRCONVLMFIRSTVIEW002');
        //     $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVLMFIRSTVIEW002');
        //     redirect(base_url('index.php/home'));
        // }

        $case_no = $this->input->get('case_no');
        
        $data['show_nav'] = [
            'allow'=>true,
            'service_code'=>SERVICE_CONVERSION,
            'case_no'=>$case_no,
            'reports'=>'co,lm',
            'process'=>'lm_first_proceeding',
            'default_report'=>'lm'
        ];

        $this->load->view('layouts/main',$data);
    }

    public function getSinglePattadarDetails() {
        $unique_id = explode('_', $this->input->post('unique_id'));
        $dist_code = $unique_id[0];
        $subdiv_code = $unique_id[1];
        $cir_code = $unique_id[2];
        $mouza_pargona_code = $unique_id[3];
        $lot_no = $unique_id[4];
        $vill_townprt_code = $unique_id[5];
        $dag_no = $unique_id[6];
        $pdar_id = $unique_id[7];

        if($dist_code == '' || $subdiv_code == '' || $cir_code == '' || $mouza_pargona_code == '' || $lot_no == '' || $vill_townprt_code == '' || $dag_no == '' || $pdar_id == '') {
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'Parameters not available'
            ]);
            exit();
        }

        $pdarDetails = $this->ConversionModel->getSinglePattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id);

        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=> 'Pattadar Details Successfully retrieved!',
            'data'=>$pdarDetails
        ]);
        exit();
    }

    public function applicantSubmit() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'appl_name_conv'=>'Applicant Code|required',
            'guardian_name_conv'=>'Guardian Name|required',
            'rel_conv'=>'Relation|required',
            'gender_conv'=>'Gender|required|char',
            'address_conv'=>'Address|required',
            'case_no'=>'Case No|required|case_no'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVLMAPP0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVLMAPP0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVLMAPP0001',
            ]);
            exit();
        }

        //syntax validation লক্ষি কান্ত গো  (পিঃ ৰ্ধম্ম কান্ত)
        // $requestResponse = checkRequestSpecChar($_POST, [], [], ['guardian_name_conv'=>true, 'applicant_name'=>true]);
        // if($requestResponse['status'] == 'n') {
        //     //ERRCONVLMAPP0002
        //     log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLMAPP0002');
        //     echo json_encode([
        //         'status'=>'FAILED',
        //         'responseType'=>1,
        //         'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVLMAPP0002',
        //     ]);
        //     exit();
        // }

        //check for malicious query
        $validResponse = checkRequestValidQuery($_POST, [], ['guardian_name_conv'=>true, 'applicant_name'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVLMAPP0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLMAPP0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVLMAPP0003',
            ]);
            exit();
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_POST['case_no'], CONV_LM_FIRST);
        if($authorization['status']=='n') {
            // ERRCONVLMAPP0004
            log_message('error', 'User not authorized. Error: #ERRCONVLMAPP0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'User not authorized. Error: #ERRCONVLMAPP0004',
            ]);
            exit();
        }

        $applicantBasicDetailsArray = explode('_', $this->input->post('appl_name_conv'));
        $dist_code = $applicantBasicDetailsArray[0];
        $subdiv_code = $applicantBasicDetailsArray[1];
        $cir_code = $applicantBasicDetailsArray[2];
        $mouza_pargona_code = $applicantBasicDetailsArray[3];
        $lot_no = $applicantBasicDetailsArray[4];
        $vill_townprt_code = $applicantBasicDetailsArray[5];
        $dag_no = $applicantBasicDetailsArray[6];
        $pdar_id = $applicantBasicDetailsArray[7];
        $guardianName = $this->input->post('guardian_name_conv');
        $relation = $this->input->post('rel_conv');
        $gender = $this->input->post('gender_conv');
        $dob = $this->input->post('dob_conv');
        $address = $this->input->post('address_conv');
        $case_no = $this->input->post('case_no');
        // $applicantName = $this->input->post('applicant_name');

        //check 
        // $check = $this->PetitionerPartModel->checkPattadar($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id);
        // if(!empty($check)) {
        //     // ERRCONVLMAPP0005
        //     log_message('error', 'Pattadar Id already available as applicant for this dag. Error: #ERRCONVLMAPP0005');
        //     echo json_encode([
        //         'status'=>'FAILED',
        //         'responseType'=>1,
        //         'msg'=>'Pattadar already registered. Error: #ERRCONVLMAPP0005',
        //     ]);
        //     exit();
        // }

        $check = $this->PetitionerPartModel->checkPattadarInThisCase($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id, $case_no);
        if(!empty($check)) {
            // ERRCONVLMAPP0005
            log_message('error', 'Pattadar Id already available as applicant for this dag. Error: #ERRCONVLMAPP0005');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Pattadar already registered. Error: #ERRCONVLMAPP0005',
            ]);
            exit();
        }

        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
        $maxCronId = $this->PetitionerPartModel->getMaxCronNo(['petition_no'=>$petitionBasic->petition_no]) + 1;
        $pattadarDetails = $this->ChithaDagPattadarModel->getSinglePattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id);
        $faddress = $this->ConversionModel->address($address);

        

        $this->db->trans_begin();

        $insertArray = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'pdar_id' => $pdar_id,
            'year_no' => date('Y'),
            'case_no' => $case_no,
            'petition_no' => $petitionBasic->petition_no,
            'operation' => 'E',
            'patta_no' => $petitionDagDetails->patta_no,
            'patta_type_code' => $petitionDagDetails->patta_type_code,
            'date_entry' => date('Y-m-d'),
            'pdar_cron_no' => $maxCronId,
            'pdar_name' => $pattadarDetails->pdar_name,
            'pdar_guardian' => $guardianName,
            'pdar_rel_guar' => $relation,
            'pdar_gender' => $gender,
            'pdar_add1' => $faddress[0],
            'pdar_add2' => $faddress[1],
            'pdar_dob' => $dob ? date('Y-m-d', strtotime($dob)) : null,
            'user_code' => $this->session->userdata('user_code')
        ];
        $status = $this->db->insert('petitioner_part', $insertArray);
        if(!$status || $this->db->affected_rows() < 1) {
            // ERRCONVLMAPP0006
            $this->db->trans_rollback();
            log_message('error', 'Error in insertion into petitioner_part table. Error: #ERRCONVLMAPP0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not create new applicant. Error: #ERRCONVLMAPP0006',
            ]);
            exit();
        }

        if($this->db->trans_status() == FALSE) {
            // ERRCONVLMAPP0007
            $this->db->trans_rollback();
            log_message('error', 'DB Transaction failed. Error: #ERRCONVLMAPP0007');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Database Transaction Failed. Error: #ERRCONVLMAPP0007',
            ]);
            exit();
        }

        $this->db->trans_commit();

        $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
        $uniquePattadars = $this->PetitionerPartModel->getUniquePattadars([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'patta_no'=>$petitionDagDetails->patta_no,
            'patta_type_code'=>$petitionDagDetails->patta_type_code,
            'dag_no'=>$petitionDagDetails->dag_no,
            'case_no'=>$case_no
        ],
        'dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, patta_no, patta_type_code, pdar_id, COUNT(*)',
        [
            'dist_code',
            'subdiv_code',
            'cir_code',
            'mouza_pargona_code',
            'lot_no',
            'vill_townprt_code',
            'dag_no',
            'patta_no',
            'patta_type_code',
            'pdar_id'
        ]);
        foreach ($petitionerParts as $petitionerPart) {
            $petitionerPart->relation_name = $this->utilityclass->get_relation($petitionerPart->pdar_rel_guar);
            $petitionerPart->gender_name = $this->utilityclass->gender($petitionerPart->pdar_gender);
        }

        foreach ($petitionerParts as $petitionerPart) {
            $petitionerPartIds[] = $petitionerPart->pdar_id;
        }

        $chithaPattadars = $this->ChithaDagPattadarModel->getOtherPattadars($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code, $petitionDagDetails->dag_no);

        $otherPattadars = [];
        foreach ($chithaPattadars as $chithaPattadar) {
            if(!in_array($chithaPattadar->pdar_id, $petitionerPartIds)) {
                $chithaPattadar->unique_id = $chithaPattadar->dist_code . '_' . $chithaPattadar->subdiv_code . '_' . $chithaPattadar->cir_code . '_' . $chithaPattadar->mouza_pargona_code . '_' . $chithaPattadar->lot_no . '_' . $chithaPattadar->vill_townprt_code . '_' . $chithaPattadar->dag_no . '_' . $chithaPattadar->pdar_id;
                $otherPattadars[] = $chithaPattadar;
            }
        }
        
        $data['other_pattadars'] = $otherPattadars;
        $data['unique_pattadars'] = $uniquePattadars;
        $data['pattadars'] = $petitionerParts;



        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=>'Successfully created new applicant',
            'data'=>$data
        ]);
        exit();
    }

    public function applicantDelete() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'dist_code'=>'District Code|required|digit',
            'subdiv_code'=>'Subdivisional Code|required|digit',
            'cir_code'=>'Circle Code|required|digit',
            'mouza_pargona_code'=>'Mouza/Pargona Code|required|digit',
            'lot_no'=>'Lot No|required|digit',
            'vill_townprt_code'=>'Village Code|required|digit',
            'dag_no'=>'Dag No.|required|digit',
            'patta_no'=>'Patta No.|required|digit',
            'patta_type_code'=>'Patta Type Code|required|digit',
            'pdar_id'=>'Pattadar Id|required|digit',
            'case_no'=>'Case No.|required|case_no'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVLMAPPDEL0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVLMAPPDEL0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidation['message'] . '. Error: #ERRCONVLMAPPDEL0001',
            ]);
            exit();
        }

        //syntax validation লক্ষি কান্ত গো  (পিঃ ৰ্ধম্ম কান্ত)
        $requestResponse = checkRequestSpecChar($_POST, [], [], []);
        if($requestResponse['status'] == 'n') {
            //ERRCONVLMAPPDEL0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLMAPPDEL0002');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$requestResponse['messages'] . '. Error: #ERRCONVLMAPPDEL0002',
            ]);
            exit();
        }

        //check for malicious query
        $validResponse = checkRequestValidQuery($_POST, [], []);
        if($validResponse['status'] == 'n') {
            //ERRCONVLMAPPDEL0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLMAPPDEL0003');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$validResponse['messages'] . '. Error: #ERRCONVLMAPPDEL0003',
            ]);
            exit();
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_POST['case_no'], CONV_LM_FIRST);
        if($authorization['status']=='n') {
            // ERRCONVLMAPPDEL0004
            log_message('error', 'User not authorized. Error: #ERRCONVLMAPPDEL0004');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'User not authorized. Error: #ERRCONVLMAPPDEL0004',
            ]);
            exit();
        }

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');
        $patta_no = $this->input->post('patta_no');
        $patta_type_code = $this->input->post('patta_type_code');
        $pdar_id = $this->input->post('pdar_id');
        $pdar_cron_no = $this->input->post('pdar_cron_no');
        $case_no = $this->input->post('case_no');
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $deleteConditions = [
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$cir_code,
            'mouza_pargona_code'=>$mouza_pargona_code,
            'lot_no'=>$lot_no,
            'vill_townprt_code'=>$vill_townprt_code,
            'dag_no'=>$dag_no,
            'patta_no'=>$patta_no,
            'patta_type_code'=>$patta_type_code,
            'pdar_id'=>$pdar_id,
            'pdar_cron_no'=>$pdar_cron_no,
            'case_no'=>$case_no
        ];

        $toBeDeleted = $this->PetitionerPartModel->get($deleteConditions);
        $basundhara = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
        if($basundhara != null) {
            $data = [
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundhara,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($toBeDeleted),
            ];
            $insertBasundharaStatus = $this->db->insert('basundhara_data_updation', $data);
            if(!$insertBasundharaStatus || $this->db->affected_rows() < 1) {
                // ERRCONVLMAPPDEL0005
                $this->db->trans_rollback();
                log_message('error', 'Basundhara_data_updation insert query failed. Error: #ERRCONVLMAPPDEL0005');
                echo json_encode([
                    'status'=>'FAILED',
                    'responseType'=>1,
                    'msg'=>'Basundhara Updation Failed. Error: #ERRCONVLMAPPDEL0005',
                ]);
                exit();
            }
        }

        $status = $this->PetitionerPartModel->deleteApplicant($deleteConditions);

        if(!$status || $this->db->affected_rows() < 1) {
            // ERRCONVLMAPPDEL0006
            $this->db->trans_rollback();
            log_message('error', 'Deletion from petitioner_part failed. Error: #ERRCONVLMAPPDEL0006');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Could not delete applicant. Error: #ERRCONVLMAPPDEL0006',
            ]);
            exit();
        }

        if($this->db->trans_status() == FALSE) {
            // ERRCONVLMAPPDEL0007
            $this->db->trans_rollback();
            log_message('error', 'DB Transaction failed. Error: #ERRCONVLMAPPDEL0007');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'DB Transaction failed. Error: #ERRCONVLMAPPDEL0007',
            ]);
            exit();
        }

        $this->db->trans_commit();

        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
        $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
        $uniquePattadars = $this->PetitionerPartModel->getUniquePattadars([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'patta_no'=>$petitionDagDetails->patta_no,
            'patta_type_code'=>$petitionDagDetails->patta_type_code,
            'dag_no'=>$petitionDagDetails->dag_no,
            'case_no'=>$case_no
        ],
        'dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, patta_no, patta_type_code, pdar_id, COUNT(*)',
        [
            'dist_code',
            'subdiv_code',
            'cir_code',
            'mouza_pargona_code',
            'lot_no',
            'vill_townprt_code',
            'dag_no',
            'patta_no',
            'patta_type_code',
            'pdar_id'
        ]);
        foreach ($petitionerParts as $petitionerPart) {
            $petitionerPart->relation_name = $this->utilityclass->get_relation($petitionerPart->pdar_rel_guar);
            $petitionerPart->gender_name = $this->utilityclass->gender($petitionerPart->pdar_gender);
        }
        

        $data['unique_pattadars'] = $uniquePattadars;
        $data['pattadars'] = $petitionerParts;


        echo json_encode([
            'status'=>'SUCCESS',
            'responseType'=>2,
            'msg'=>'Successfully deleted pattadar',
            'data'=>$data
        ]);
        exit();
    }

    public function CalculatePremiumMb3() {
        $area = $this->input->post('area', true);
        $area_purpose_type = $this->input->post('area_purpose_type', true);
        $zonal_rate = $this->input->post('zonal_rate', true);
        $bigha = $this->input->post('bigha', true);
        $katha = $this->input->post('katha', true);
        $lessa = $this->input->post('lessa', true);
        $ganda = $this->input->post('ganda', true);
        $jati_janajati = $this->input->post('jati_janajati', true);
        $freedom_fighter = $this->input->post('freedom_fighter', true);
        $widow = $this->input->post('widow', true);
        $is_barak = $this->input->post('is_barak', true);
        $premium_percent_amount = '';

        $premium = $this->ConversionPremiumRatesModel->get([
            'premium_area_id' => $area,
            'premium_area_purpose_type_id' => $area_purpose_type
        ]);
        $amount = 0;
        if($premium->amount == 0 && $premium->rate != 0) {
            //rate
            $premium_percent_amount = $premium->rate;
            $amount = ($premium->rate / 100) * $zonal_rate;
        }
        else if ($premium->amount != 0 && $premium->rate == 0) {
            //amount
            $premium_percent_amount = $premium->amount;
            $amount = $premium->amount;
        }

        if($is_barak != '1') {
            $total_lessa = (int)$bigha * 100 + (int)$katha * 20 + $lessa;
            $premium_final = $total_lessa * $amount / 100;
        }
        else {
            $total_ganda = (int)$bigha * 6400 + (int)$katha * 320 + (int)$lessa * 20 + $ganda;
            $premium_final = $total_ganda * $amount / 6400;
        }

        if(($jati_janajati == 'true') || ($freedom_fighter == 'true') || ($widow == 'true'))
        {
            $deduct_amount = (25/100) * $premium_final;
            $tot_amount = $premium_final - $deduct_amount;
        }
        else{
            $tot_amount = $premium_final;
        }

        $json[] = [
            'premium' => $tot_amount,
            'premium_percent_amount' => $premium_percent_amount
        ];
        echo json_encode($json);
        exit();
    }


    public function CalculatePremium($percent, $bigha, $katha, $lessa, $zonal_rate, $jati_janajati, $freedom_fighter, $widow)
    {
        $percentage = $percent;
        $On_amount = $zonal_rate;
        
        if(($percentage == '40') || ($percentage == '20'))//if 40rupees and 20rupees
        {
            $amount=$percentage;
        }
        else
        {
            $amount=($percentage / 100) * $On_amount;
        }
        
        if(($jati_janajati == 'true') || ($freedom_fighter == 'true') || ($widow == 'true'))
        {
            $deduct_amount = (25/100) * $amount;
            $tot_amount = $amount - $deduct_amount;
        }
        else{
            $tot_amount = $amount;
        }
        
        
        $total_lessa = (int)$bigha * 100 + (int)$katha * 20 + (int)$lessa;
        $premium = $total_lessa * $tot_amount / 100;
        
        $json[] = array('premium' => $premium);
        echo json_encode($json);
    }

    public function lmFirstProceedingPost() {
        //Form Validation
        $formValidationCheck = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No|required|case_no',
            'dag_no'=>'Dag No|required|digit',
            'lm_name'=>'LM Name|required',
            'lm_code'=>'LM Code|required',
            'patta_type_code'=>'Patta Type|required|digit',
            'each_bigha_rate'=>'Bigha Rate|2_digit_decimal',
            'land_class'=>'Land Class|required|digit',
            'whetherOr'=>'Land Type|required|digit',
            'recommendation' => 'Recommendation|required',
            'premium_assesment'=>'Premium Assesment|required_on_condition(recommendation,equals,[recommended])|digit',
            'total_premium'=>'Total Premium|required_on_condition(recommendation,equals,[recommended])',
            'lm_notice'=>'LM Notice|required',
            'lm_sign'=>'LM Signature|required|char',
            'land_trans'=>'Land Transferred|required_on_condition(patta_type_code,equals,[0208])|char',
            // 'date_of_entry'=>'Date|required|date',
            'conv_b'=>'Bigha|required|digit',
            'conv_k'=>'Katha|required|katha',
            'conv_lc'=>'Lessa|required|lessa',
            'inplacealong' => 'Inplace/Alongwith|required',
            'b' => 'Applied Bigha|required|digit',
            'k' => 'Applied Katha|required|katha',
            'l' => 'Applied Lessa|required|lessa',
            'pattar_mati_hoi_ne'=>'Pattar Mati|char',//
            'dokhol_ase_ne'=>'Dokhol Mati|char',//
            'gos_gosoni'=>'Gos Gosoni|char',//
            'miyadi_upojugi'=>'Miyadi Upojugi|char',//
            'rastar_kaijo_b'=>'Rastar Kaijo Bigha|digit',
            'rastar_kaijo_k'=>'Rastar Kaijo Katha|katha',
            'rastar_kaijo_lc'=>'Rastar Kaijo Lessa|lessa',
            'nodir_kakhor'=>'Nodir Kakhor|char',//////
            'nodir_kaijo_b'=>'Nodir Kaijo Bigha|digit',
            'nodir_kaijo_k'=>'Nodir Kaijo Katha|katha',
            'nodir_kaijo_lc'=>'Nodir Kaijo Lessa|lessa',
            'partial_conv'=>'Partial Conversion|char',//////
            'partial_b'=>'Partial Bigha|digit',
            'partial_k'=>'Partial Katha|katha',
            'partial_lc'=>'Partial Lessa|lessa',
            'jati_janajati'=>'Jati Janajati|char',//
            'freedom_fighter'=>'Freedom Fighter|char',//
            'widow'=>'Widow|char',//
        ]);
        if($formValidationCheck['status'] == 'n') {
            //ERRCONVLM0001
            log_message('error', 'Message: '. $formValidationCheck['message'] .', Data: '. json_encode($formValidationCheck['data']) .'. Error: ERRCONVLM0001');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>$formValidationCheck['message'] . '. Error: #ERRCONVLM0001',
            ]);
            exit();
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['lm_name'=>['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']], [], ['lm_notice'=>true, 'lm_name'=>true]);//, ['co_order'=>[' ঁ']]
        if($requestResponse['status'] == 'n') {
            //ERRCONVLM0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLM0002');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $requestResponse['messages'] . '. Error: #ERRCONVLM0002',
            ]);
            exit();
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['lm_notice'=>true, 'lm_name'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVLM0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLM0003');
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => $validResponse['messages'] . '. Error: #ERRCONVLM0003',
            ]);
            exit();
        }

        //authentication and authorization
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_POST['case_no'], CONV_LM_FIRST);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVLM0004
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVLM0004');
        //     echo json_encode([
        //         'status' => 'FAILED',
        //         'responseType' => 1,
        //         'msg' => $authorization['messages'] . '. Error: #ERRCONVLM0004',
        //     ]);
        //     exit();
        // }

        //File validation
        // if(!isset($_FILES['up_noc_conv']['name']) || $_FILES['up_noc_conv']['name'] == '' || $_FILES['up_noc_conv']['error'] == 4) {
        //     //ERRCONVLM0005
        //     log_message('error', 'NOC upload is mandatory. Error: ERRCONVLM0005');
        //     echo json_encode([
        //         'status' => 'FAILED',
        //         'responseType' => 1,
        //         'msg' => 'NOC upload is mandatory. Error: #ERRCONVLM0005',
        //     ]);
        //     exit();
        // }
        if($_POST['patta_type_code'] == '0208') {
            if(!isset($_FILES['up_doc']['name']) || $_FILES['up_doc']['name'] == '' || $_FILES['up_doc']['error'] == 4) {
                //ERRCONVLM0006
                log_message('error', 'Nispi Kheraz Document upload is mandatory. Error: ERRCONVLM0006');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Nispi Kheraz Document upload is mandatory. Error: #ERRCONVLM0006',
                ]);
                exit();
            }
        }

        if(isset($_POST['jati_janajati']) && $_POST['jati_janajati'] == 'Y') {
            if(!isset($_FILES['filename_jati_janajati']['name']) || $_FILES['filename_jati_janajati']['name'] == '' || $_FILES['filename_jati_janajati']['error'] == 4) {
                //ERRCONVLM0007
                log_message('error', 'Jati Janajati file upload is mandatory in this case. Error: ERRCONVLM0007');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Jati Janajati file upload is mandatory in this case. Error: #ERRCONVLM0007',
                ]);
                exit();
            }
        }
        if(isset($_POST['freedom_fighter']) && $_POST['freedom_fighter'] == 'Y') {
            if(!isset($_FILES['filename_freedom_fighter']['name']) || $_FILES['filename_freedom_fighter']['name'] == '' || $_FILES['filename_freedom_fighter']['error'] == 4) {
                //ERRCONVLM0008
                log_message('error', 'Freedom Fighter file upload is mandatory in this case. Error: ERRCONVLM0008');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Freedom Fighter file upload is mandatory in this case. Error: #ERRCONVLM0008',
                ]);
                exit();
            }
        }
        if(isset($_POST['widow']) && $_POST['widow'] == 'Y') {
            if(!isset($_FILES['filename_widow']['name']) || $_FILES['filename_widow']['name'] == '' || $_FILES['filename_widow']['error'] == 4) {
                //ERRCONVLM0009
                log_message('error', 'Widow file upload is mandatory in this case. Error: ERRCONVLM0009');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Widow file upload is mandatory in this case. Error: #ERRCONVLM0009',
                ]);
                exit();
            }
        }

        // echo '<pre>';
        // var_dump($_POST);
        // die();

        //data from session
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        // extracting from post data
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $patta_type_code = $this->input->post('patta_type_code');
        $lm_name = $this->input->post('lm_name');
        $lm_code = $this->input->post('lm_code');
        $zonal_rate = $this->input->post('each_bigha_rate');
        $land_class = $this->input->post('land_class');
        $whetherOr = $this->input->post('whetherOr');
        $recommendation = $this->input->post('recommendation');
        $premium_assesment = $this->input->post('premium_assesment');
        $total_premium = $this->input->post('total_premium');
        $lm_notice = $this->input->post('lm_notice');
        $lm_sign = $this->input->post('lm_sign');
        // $date_of_entry = $this->input->post('date_of_entry');
        $is_partial = $this->input->post('is_partial');
        $conv_b = $this->input->post('conv_b');
        $conv_k = $this->input->post('conv_k');
        $conv_lc = $this->input->post('conv_lc');
        $rastar_kaijo_b = $this->input->post('rastar_kaijo_b');
        $rastar_kaijo_k = $this->input->post('rastar_kaijo_k');
        $rastar_kaijo_lc = $this->input->post('rastar_kaijo_lc');
        $nodir_kaijo_b = $this->input->post('nodir_kaijo_b');
        $nodir_kaijo_k = $this->input->post('nodir_kaijo_k');
        $nodir_kaijo_lc = $this->input->post('nodir_kaijo_lc');
        $partial_b = $this->input->post('partial_b');
        $partial_k = $this->input->post('partial_k');
        $partial_lc = $this->input->post('partial_lc');
        $applied_b = $this->input->post('b', true);
        $applied_k = $this->input->post('k', true);
        $applied_lc = $this->input->post('l', true);
        if(in_array($dist_code, json_decode(BARAK_VALLEY))) {
            $conv_g = $this->input->post('conv_g');
            $applied_g = $this->input->post('g', true);
            $rastar_kaijo_g = $this->input->post('rastar_kaijo_g');
            if(isset($_POST['nodir_kakhor']) && $_POST['nodir_kakhor'] == 'Y') {
                $nodir_kaijo_g = $this->input->post('nodir_kaijo_g');
            }
            else {
                $nodir_kaijo_g = '0';
            }
            if(isset($_POST['partial_conv']) && $_POST['partial_conv'] == 'Y') {
                $partial_g = $this->input->post('partial_g');
            }
            else {
                $partial_g = '0';
            }
        }
        else {
            $conv_g = '0';
            $rastar_kaijo_g = '0';
            $nodir_kaijo_g = '0';
            $partial_g = '0';
            $applied_g = '0';
        }
        $inplacealong = $this->input->post('inplacealong');
        $land_trans = ($patta_type_code == '0208') ? $this->input->post('land_trans') : null;
        $pattar_mati_hoi_ne = isset($_POST['pattar_mati_hoi_ne']) ? $this->input->post('pattar_mati_hoi_ne') : null;
        $dokhol_ase_ne = isset($_POST['dokhol_ase_ne']) ? $this->input->post('dokhol_ase_ne') : null;
        $gos_gosoni = isset($_POST['gos_gosoni']) ? $this->input->post('gos_gosoni') : null;
        $miyadi_upojugi = isset($_POST['miyadi_upojugi']) ? $this->input->post('miyadi_upojugi') : null;
        $jati_janajati = isset($_POST['jati_janajati']) ? $this->input->post('jati_janajati') : null;
        $freedom_fighter = isset($_POST['freedom_fighter']) ? $this->input->post('freedom_fighter') : null;
        $widow = isset($_POST['widow']) ? $this->input->post('widow') : null;
        $nodir_kakhor = (isset($_POST['nodir_kakhor']) && $_POST['nodir_kakhor'] == 'Y') ? $_POST['nodir_kakhor'] : null;
        $patial_conv = (isset($_POST['partial_conv']) && $_POST['partial_conv'] == 'Y') ? $_POST['partial_conv'] : null;

        $applid = $this->db->query("select basundhara from basundhar_application where dharitree =?", array($case_no));
        $application_no = $applid->row()->basundhara;

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

        if($supportive_document_sql->num_rows() > 0){
            $geo_tag_doc = $supportive_document_sql->result();
        }else{
            $geo_tag_doc_empty = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }

        if(GEO_TAG_ACTIVE_STATUS == 1)
        {
            if(isset($geo_tag_doc_empty)){

                log_message('error', 'Geo Tag Photo Not Uploaded. Error: ERRCONVLM30006');
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'Geo Tag Photo Not Uploaded. Error: #ERRCONVLM30006',
                ]);
                exit();
                
            }
        }

        $this->db->trans_begin();

        $path = UPLOAD_BASE_CONVERSIONDOCS.UPLOAD_SEPARATOR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        // File uploading (jati_janajati)
        $file_name_jati_janajati = null;
        $file_name_freedom_fighter = null;
        $file_name_widow = null;
        if($jati_janajati != '' || $freedom_fighter != '' || $widow != '') {
            $config['upload_path'] = $path;
            $config['allowed_types'] = FILE_TYPE;
            $config['max_size'] = MAX_SIZE;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($jati_janajati != '' && $_FILES['filename_jati_janajati']['name'] !== "") {
                $file_ext = pathinfo($_FILES['filename_jati_janajati']['name'], PATHINFO_EXTENSION);
                $_FILES['filename_jati_janajati']['name'] = 'jatijanajati_' . date('Y-m-d-H-i-s') . '.' . $file_ext;
                if(!$this->upload->do_upload('filename_jati_janajati')) {
                    //ERRCONVLMUPLOAD0001
                    log_message('error', 'Jati janajati file upload failed. Error: ERRCONVLMUPLOAD0001');
                    echo json_encode([
                        'status' => 'FAILED',
                        'responseType' => 1,
                        'msg' => 'Jati janajati file upload failed. Error: #ERRCONVLMUPLOAD0001',
                    ]);
                    exit();
                }
                $upload_data = $this->upload->data();
                $file_name_jati_janajati = $upload_data['file_name'];
            }
            if ($freedom_fighter != '' && $_FILES['filename_freedom_fighter']['name'] !== "") {
                $file_ext = pathinfo($_FILES['filename_freedom_fighter']['name'], PATHINFO_EXTENSION);
                $_FILES['filename_freedom_fighter']['name'] = 'freedomfighter_' . date('Y-m-d-H-i-s') . '.' . $file_ext;
                if(!$this->upload->do_upload('filename_freedom_fighter')) {
                    //ERRCONVLMUPLOAD0002
                    log_message('error', 'Freedom fighter file upload failed. Error: ERRCONVLMUPLOAD0002');
                    echo json_encode([
                        'status' => 'FAILED',
                        'responseType' => 1,
                        'msg' => 'Freedom fighter file upload failed. Error: #ERRCONVLMUPLOAD0002',
                    ]);
                    exit();
                }
                $upload_data = $this->upload->data();
                $file_name_freedom_fighter = $upload_data['file_name'];
            }
            if ($widow != '' && $_FILES['filename_widow']['name'] !== "") {
                $file_ext = pathinfo($_FILES['filename_widow']['name'], PATHINFO_EXTENSION);
                $_FILES['filename_widow']['name'] = 'widow_' . date('Y-m-d-H-i-s') . '.' . $file_ext;
                if(!$this->upload->do_upload('filename_widow')) {
                    //ERRCONVLMUPLOAD0003
                    log_message('error', 'Widow file upload failed. Error: ERRCONVLMUPLOAD0003');
                    echo json_encode([
                        'status' => 'FAILED',
                        'responseType' => 1,
                        'msg' => 'Widow file upload failed. Error: #ERRCONVLMUPLOAD0003',
                    ]);
                    exit();
                }
                $upload_data = $this->upload->data();
                $file_name_widow = $upload_data['file_name'];
            }
        }

        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);

        // File uploading (NOC)
        // $count = $this->SupportiveDocumentModel->get(['case_no' => $case_no], 'COUNT(*)')->count;
        // $sl = $count+1;
        // $file = $petitionBasic->petition_no . date('Y') . '_' . $sl;
        // $ext = pathinfo($_FILES['up_noc_conv']['name'], PATHINFO_EXTENSION);
        // $_FILES['up_noc_conv']['name'] = $file . '.' . $ext;
        // $config = array(
        //     'upload_path' => $path,
        //     'allowed_types' => FILE_TYPE,
        //     'max_size' => MAX_SIZE,
        // );
        // $this->load->library('upload', $config);
        // $this->upload->initialize($config);
        // if ($this->upload->do_upload('up_noc_conv')) 
        // {
        //     $data = $this->upload->data();
        //     $insert_noc_data = [
        //         'case_no' => $case_no,
        //         'user_code' => $user_code,
        //         'file_name' => NOC,
        //         'fetch_file_name' => $file.$data['file_ext'],
        //         'file_type' => $data['file_type'],
        //         'file_path' => $path.$file.$data['file_ext'],
        //         'date_entry' => date('Y-m-d h:i:s'),
        //         'mut_type' => 'NA',
        //     ];
        //     $insertNocStatus = $this->db->insert('supportive_document', $insert_noc_data);
        //     if(!$insertNocStatus || $this->db->affected_rows() < 1){
        //         // ERRCONVLM0010
        //         $this->db->trans_rollback();
        //         log_message("error","Error - #ERRCONVLM0010. NOC upload data insertion failed in supportive_document for dist: " . $dist_code.", case no: ". $case_no);
        //         echo json_encode([
        //             'status' => 'FAILED',
        //             'responseType' => 1,
        //             'msg' => 'DB insertion Failed. Error: #ERRCONVLM0010',
        //         ]);
        //         exit();
        //     }
        // }
        ////////////NOC ends here////////


        // File uploading (Nisfi Kheraz Doc)
        if($patta_type_code == '0208') {
            $count = $this->SupportiveDocumentModel->get(['case_no' => $case_no], 'COUNT(*)')->count;
            $sl = $count+1;
            $docfile = $petitionBasic->petition_no . '_' . date('Y') . '_nisfi_kheraz_' . $sl;
            $ext = pathinfo($_FILES['up_doc']['name'], PATHINFO_EXTENSION);
            $_FILES['up_doc']['name'] = $docfile . '.' . $ext;
            $config = array(
                'upload_path' => $path,
                'allowed_types' => FILE_TYPE,
                'max_size' => MAX_SIZE,
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('up_doc')) 
            {
                $data = $this->upload->data();
                $insert_nisfi_kheraz_data = [
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'file_name' => 'NISFI KHERAZ',
                    'fetch_file_name' => $docfile . $data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path . $docfile . $data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insertNisfiKherazStatus = $this->db->insert('supportive_document', $insert_nisfi_kheraz_data);
                if(!$insertNisfiKherazStatus || $this->db->affected_rows() < 1){
                   // ERRCONVLM0011
                    $this->db->trans_rollback();
                    log_message("error","Error - #ERRCONVLM0011. Nisfi kheraz doc upload data insertion failed in supportive_document for dist: " . $dist_code.", case no: ". $case_no);
                    echo json_encode([
                        'status' => 'FAILED',
                        'responseType' => 1,
                        'msg' => 'DB insertion Failed. Error: #ERRCONVLM0011'
                    ]);
                    exit();
                }
            }
        }
        ////////////Nisfi Kheraz DOC upload ends here////////
        $maxNoteRow = $this->PetitionLmNoteModel->getLatest([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'petition_no' => $petitionBasic->petition_no
        ]);
        $note_no = (empty($maxNoteRow)) ? 1 : $maxNoteRow->note_no + 1;

        $distance = null;
        $inside_outside = null;

        if($recommendation == 'recommended') {
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'premium_area_id' => $whetherOr,
                'premium_area_purpose_type_id' => $premium_assesment,
                'is_deleted' => 0
            ]);

            if(empty($premiumRateDetails)) {
                // ERRCONVLM0020
                $this->db->trans_rollback();
                log_message("error","Error - #ERRCONVLM0020. Could not find premium rate for this area");
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => ' Could not find premium rate for this area. Error: #ERRCONVLM0020'
                ]);
                exit();
            }
        }
        

        // switch ($whetherOr) {
        //     case 'withintown':
        //         $distance = '0';
        //         $inside_outside = 'd';
        //         break;
        //     case 'within3km':
        //         $distance = '3';
        //         $inside_outside = 'i';
        //         break;
        //     case 'within10km':
        //         $distance = '10';
        //         $inside_outside = 'i';
        //         break;
        //     case 'within15km':
        //         $distance = '15';
        //         $inside_outside = 'g';
        //         break;
        //     case 'withinRev':
        //         $distance = '1';
        //         $inside_outside = 'o';
        //         break;
        //     case 'withinrural':
        //         $distance = '0';
        //         $inside_outside = 'o';
        //         break;
        //     case 'withinrevenuetown':
        //         $distance = '0';
        //         $inside_outside = 'r';
        //         break;
        //     case 'withintown5km':
        //         $distance = '5';
        //         $inside_outside = 'i';
        //         break;
        //     case 'withinmunicipal':
        //         $distance = '0';
        //         $inside_outside = 'm';
        //         break;
        //     case 'withinmunicipal5km':
        //         $distance = '5';
        //         $inside_outside = 'm';
        //         break;
        //     case 'withinghy':
        //         $distance = '0';
        //         $inside_outside = 'g';
        //         break;
        //     default:
        //         # code...
        //         break;
        // }

        $rastarkakhoroldnew = '';
        $nodirkakhoroldnew = '';

        if($rastar_kaijo_b > 0 || $rastar_kaijo_k > 0 || $rastar_kaijo_lc > 0 || $rastar_kaijo_g >0 || $nodir_kaijo_b > 0 || $nodir_kaijo_k > 0 || $nodir_kaijo_lc > 0 || $nodir_kaijo_g > 0 || $partial_b > 0 || $partial_k > 0 || $partial_lc > 0 || $partial_g > 0) 
        {
            //petition_basic update
            $petition_basic_update_arr = [
                'trans_code' => 'P'
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
            $updateStatus = $this->db->update('petition_basic', $petition_basic_update_arr);
            if(!$updateStatus || $this->db->affected_rows() < 1) {
                // ERRCONVLM0012
                $this->db->trans_rollback();
                log_message("error","Error - #ERRCONVLM0012. Trans code update for partial conversion in petition_basic table failed");
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Failed. Error: #ERRCONVLM0012'
                ]);
                exit();
            }
            //petition_dag_details update
            $petition_dag_details_update_arr = [
                'm_dag_area_b' => $conv_b,
                'm_dag_area_k' => $conv_k,
                'm_dag_area_lc' => $conv_lc,
                'm_dag_area_g' => $conv_g,
                'applied_b' => $applied_b,
                'applied_k' => $applied_k,
                'applied_lc' => $applied_lc,
                'applied_g' => $applied_g
            ];
            $this->db->where([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $updateDagDetailsStatus = $this->db->update('petition_dag_details', $petition_dag_details_update_arr);
            if(!$updateDagDetailsStatus || $this->db->affected_rows() < 1) {
                // ERRCONVLM0013
                $this->db->trans_rollback();
                log_message("error","Error - #ERRCONVLM0013. Dag area update for partial conversion in petition_dag_details table failed");
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Failed. Error: #ERRCONVLM0013'
                ]);
                exit();
            }
        }
        else {
            $petition_dag_details_update_arr = [
                'applied_b' => $applied_b,
                'applied_k' => $applied_k,
                'applied_lc' => $applied_lc,
                'applied_g' => $applied_g
            ];
            $this->db->where([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $updateDagDetailsStatus = $this->db->update('petition_dag_details', $petition_dag_details_update_arr);
            if(!$updateDagDetailsStatus || $this->db->affected_rows() < 1) {
                // ERRCONVLM0013
                $this->db->trans_rollback();
                log_message("error","Error - #ERRCONVLM0013. Applied Dag area update for conversion in petition_dag_details table failed");
                echo json_encode([
                    'status' => 'FAILED',
                    'responseType' => 1,
                    'msg' => 'DB updation Failed. Error: #ERRCONVLM0013'
                ]);
                exit();
            }
        }
        //petition_lm_note insert
        $petition_lm_note_insert_arr = [
            'case_no'=>$case_no,
            'dist_code' => $petitionBasic->dist_code, 
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'year_no' => $petitionBasic->year_no,
            'petition_no' => $petitionBasic->petition_no,
            'dag_no' => $dag_no,
            'note_no' => $note_no,
            'partition_info' => $lm_notice,
            'user_code' => $lm_code,
            // 'date_entry' =>  date('Y-m-d',strtotime($date_of_entry)),
            'date_entry' =>  date('Y-m-d H:i:s'),
            'operation' => 'E',
            'applicant_patta_yn' => $pattar_mati_hoi_ne,
            'occupied_yn' => $dokhol_ase_ne,
            'val_tree_yn' => $gos_gosoni,
            'dist_frm_town' => $distance,
            'inside_outside_town' => $inside_outside,
            'land_class_code' => $land_class,
            'issuit_forconv_under105' => $miyadi_upojugi,
            'roadside_rsv_b' => $rastar_kaijo_b,
            'roadside_rsv_k' => $rastar_kaijo_k,
            'roadside_rsv_lc' => $rastar_kaijo_lc,
            'roadside_rsv_g' => $rastar_kaijo_g,
            'riverside_rsv_b' => $nodir_kaijo_b,
            'riverside_rsv_k' => $nodir_kaijo_k,
            'riverside_rsv_lc' => $nodir_kaijo_lc,
            'riverside_rsv_g' => $nodir_kaijo_g,
            'partial_untrans_b' => $partial_b,
            'partial_untrans_k' => $partial_k,
            'partial_untrans_lc' => $partial_lc,
            'partial_untrans_g' => $partial_g,
            'near_river_yn' => $nodir_kakhor,
            'conv_b' => $conv_b,
            'conv_k' => $conv_k,
            'conv_lc' => $conv_lc,
            'lm_sign_yn' => $lm_sign, 
            'land_trans_yn' => $land_trans,
            'lm_code' => $lm_code,
            'lm_sign_date' =>  date('Y-m-d H:i:s'),
            'jati_janajati_yn' => $jati_janajati,
            'jati_janajati_upload' => $file_name_jati_janajati,
            'freedom_fighter_yn' => $freedom_fighter,
            'freedom_fighter_upload' => $file_name_freedom_fighter,
            'widow_yn' => $widow,
            'widow_upload' => $file_name_widow,
            //premium
            'prim_per_bigha' => $zonal_rate ? $zonal_rate : null,
            'prim_tot' => $total_premium ? $total_premium : null,
            'premium_assesment' => $premium_assesment ? $premium_assesment : null,
            'conversion_premium_areas_id' => $whetherOr ? $whetherOr : null,
            'conversion_premium_rates_id' => $premiumRateDetails ? $premiumRateDetails->id : null,
            // newly added by hridayjit
            'roadside_old_new_dag_reservation' => $rastarkakhoroldnew,
            'riverside_old_new_dag_reservation' => $nodirkakhoroldnew,
            'lm_note_type' => ($recommendation == 'not_recommended') ? 2 : 1
            // 
        ];
        $basundhara = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
        if($basundhara != null){
            $rtps_tag = $this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps_tag != 'RTPS'){
                if($inside_outside == 'o'){
                    $petition_lm_note_insert_arr['prem_pay_method'] = '300';
                    $petition_lm_note_insert_arr['prim_tot'] = 0;
                }
            }
        }
        $petitionLmNoteStatus = $this->db->insert('petition_lm_note', $petition_lm_note_insert_arr);
        if(!$petitionLmNoteStatus || $this->db->affected_rows() < 1) {
            // ERRCONVLM0014
            $this->db->trans_rollback();
            log_message("error","Error - #ERRCONVLM0014. Petition Lm Note Insert query failed.");
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB insertion Failed. Error: #ERRCONVLM0014'
            ]);
            exit();
        }

        //petitioner_part update
        $petitionerPartDetails = $this->PetitionerPartModel->get([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'petition_no' => $petitionBasic->petition_no
        ], '*', 'multiple');

        if(!empty($petitionerPartDetails)) {
            foreach ($petitionerPartDetails as $petitionerPartDetail) {
                if(in_array('inplace_' . $petitionerPartDetail->pdar_id, $inplacealong)) {
                    $petitioner_part_update_arr = [
                        'inplace_alongwith' => 'inplace'
                    ];
                    $this->db->where([
                        'dist_code' => $petitionBasic->dist_code,
                        'subdiv_code' => $petitionBasic->subdiv_code,
                        'cir_code' => $petitionBasic->cir_code,
                        'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                        'lot_no' => $petitionBasic->lot_no,
                        'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                        'petition_no' => $petitionBasic->petition_no,
                        'pdar_id' => $petitionerPartDetail->pdar_id
                    ]);
                    $petitionerPartStatus = $this->db->update('petitioner_part', $petitioner_part_update_arr);
                    if(!$petitionerPartStatus || $this->db->affected_rows() < 1) {
                        // ERRCONVLM0015
                        $this->db->trans_rollback();
                        log_message("error","Error - #ERRCONVLM0015. petitioner_part update query failed.");
                        echo json_encode([
                            'status' => 'FAILED',
                            'responseType' => 1,
                            'msg' => 'DB updation Failed. Error: #ERRCONVLM0015'
                        ]);
                        exit();
                    }
                }
            }
        }

        //update petition_basic
        $petition_basic_update_arr = [
            // 'proceeding_yn' => null,
            'co_order_conv_notice' => null,
            'co_order_conv_premium' => null,
            'co_order_conv_date' => null,
            'lm_note_yn' => 'Y',
            'lm_note_date' => date('Y-m-d H:i:s'),
            'sk_comment' => null,
            'new_status' =>'LMLRS'
        ];
        $this->db->where([
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_townprt_code' => $petitionBasic->vill_townprt_code,
            'case_no' => $case_no
        ]);
        $petitionBasicUpdate = $this->db->update('petition_basic', $petition_basic_update_arr);
        if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
            // ERRCONVLM0016
            $this->db->trans_rollback();
            log_message("error","Error - #ERRCONVLM0016. petition_basic update query failed.");
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB updation Failed. Error: #ERRCONVLM0016'
            ]);
            exit();
        }

        // insert into petition_proceeding
        $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
            'co_order' => $getPreviousPetitionProceeding->co_order,
            'note_on_order' => 'LRA Forwarded to LRS',
            'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert("petition_proceeding", $proceeding_data);
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            //ERRCONVLM0017
            $this->db->trans_rollback();
            log_message('error', 'Error in insert query in petition_proceeding. Error: ERRCONVLM0017');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'DB Insertion error. Error: ERRCONVLM0017'
            ]);
            exit();
        }

        // if($petitionBasic->es_flag == 1 && ESCALATION_ENABLE == 1)
        // {
        //     $user_code = $this->session->userdata('user_code');
        //     $executionDate = $this->input->post('executionDate');
        //     $serviceChoose = explode('/',$case_no);
        //     $next_date_of_hearing = $petition_basic->next_date_of_hearing.date(' H:i:s');

        //     // log_message("error", "#POSTPARAMS3353 :".json_encode($_POST));

        //     $escalationUpdateStatus = $this->ConversionEscalationModel->escalationLmConversionReport($executionDate, $petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $case_no, $user_code, $check_whetherOr);

        //     // log_message("error", "#ESC3356, transaction-error-STATUS======".json_encode($escalationUpdateStatus['responseType']));

        //     if($escalationUpdateStatus['responseType'] == 0)
        //     {
        //         $this->db->trans_rollback();
        //         // log_message("error", "#ESC3356, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
        //         $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC3356)");
        //         redirect(base_url() . "index.php/home");
        //     }
        //     ///////////////END ESCALATION//////////////
        // }

        $penUser='SK';
        $rmrk='Report by LM';
        $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
        $rmk=$rmrk;
        $status='M';
        $task='LM';
        $pen='SK';
        $case=$case_no;
        $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        if(trim($rtps_status) !="y") {
            //ERRCONVLM0018
            $this->db->trans_rollback();
            log_message('error', 'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVLM0018');
            echo json_encode([
                'status'=>'FAILED',
                'responseType'=>1,
                'msg'=>'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVLM0018'
            ]);
            exit();
        }

        if($this->db->trans_status() == FALSE) {
            // ERRCONVLM0019
            $this->db->trans_rollback();
            log_message("error","Error - #ERRCONVLM0019. Transaction status failed.");
            echo json_encode([
                'status' => 'FAILED',
                'responseType' => 1,
                'msg' => 'DB transaction Failed. Error: #ERRCONVLM0019'
            ]);
            exit();
        }

        $this->db->trans_commit();

        echo json_encode([
            'status' => 'SUCCESS',
            'responseType' => 2,
            'msg' => 'LRA note successfully generated for case no: ' . $case_no
        ]);
        exit();
    }
}