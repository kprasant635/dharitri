<?php
    class ReportsController extends CI_Controller {
        public function __construct()
        {
            parent::__construct();
            // $this->load->model('v2/PetitionBasicModel');
            // $this->load->model('v2/PetitionDagDetailsModel');
            // $this->load->model('v2/MasterOfficeMutationTypeModel');
            // $this->load->model('v2/PattacodeModel');
            // $this->load->model('v2/PetitionerPartModel');
            $this->load->model('v2/Services/Conversion/ConversionModel');
        }

        public function application() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'co_first_proceeding') {
                    $data = $this->ConversionModel->getApplicationDataForCOFirst($case_no);
                    $this->load->view('conversion/co/co_first_proceeding_application', $data);
                }
                else if($process == 'lm_first_proceeding') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/lm/lm_first_proceeding_application', $data);
                }
                else if($process == 'sk_first_proceeding') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_application', $data);
                }
                else if($process == 'co_second_proceeding') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/co/co_first_proceeding_application', $data);
                }
                else if($process == 'premium_notice') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_application', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_application', $data);
                }
                else if($process == 'co_final_order') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_application', $data);
                }
                else if($process == 'co_all_cases') {
                    $data = $this->ConversionModel->getApplicationData($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_application', $data);
                }
            }
        }

        public function coReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'co_first_proceeding') {
                    $data = $this->ConversionModel->getCOReportForCOFirst($case_no);
                    $this->load->view('conversion/co/co_first_proceeding_report', $data);
                }
                else if($process == 'lm_first_proceeding') {
                    $data = $this->ConversionModel->getCOReportForLMFirst($case_no);
                    $this->load->view('conversion/lm/lm_first_proceeding_coreport', $data);
                }
                else if ($process == 'sk_first_proceeding') {
                    $data = $this->ConversionModel->getCOReportForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_coreport', $data);
                }
                else if($process == 'co_second_proceeding') {
                    $data = $this->ConversionModel->getCOReportForCOSecond($case_no);
                    $this->load->view('conversion/co/co_second_proceeding_report', $data);
                }
                else if ($process == 'premium_notice') {
                    $data = $this->ConversionModel->getCOSecondReportForAst($case_no);
                    $this->load->view('conversion/ast/ast_coreport', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getCOSecondReportForAst($case_no);
                    $this->load->view('conversion/ast/ast_coreport', $data);
                }
                else if ($process == 'co_chitha_update') {
                    $data = $this->ConversionModel->getFirstFormChithaUpdate($case_no);
                    $this->load->view('conversion/co/chithaUpdateFirstForm', $data);
                }
                else if($process == 'co_final_order') {
                    $data = $this->ConversionModel->getCoFinalOrder($case_no);
                    $this->load->view('conversion/co/co_final_order_report', $data);
                }
                else if($process == 'co_all_cases') {
                    $data = $this->ConversionModel->getCoAllCases($case_no);
                    $this->load->view('conversion/co/co_all_cases', $data);
                }
                else {
                    $this->load->view('v2/conversion/reportViews/coReport');
                }
            }
        }


        public function lmReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'lm_first_proceeding') {
                    $data = $this->ConversionModel->getLMReportForLMFirst($case_no);
                    $this->load->view('conversion/lm/lm_first_proceeding_report', $data);
                }
                else if($process == 'sk_first_proceeding') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else if ($process == 'co_second_proceeding') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else if($process == 'premium_notice') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else if($process == 'co_final_order') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else if($process == 'co_all_cases') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_lmreport', $data);
                }
                else{
                   
                }
                
            }
        }

        public function daReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'premium_notice') {
                    $data = $this->ConversionModel->getPremiumNoticeDetails($case_no);
                    $this->load->view('conversion/ast/premium_notice', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getConfirmPremiumDetails($case_no);
                    $this->load->view('conversion/ast/confirm_premium', $data);
                }
                else {
                    $this->load->view('v2/conversion/reportViews/daReport');
                }
                
            }
        }

        public function skReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'sk_first_proceeding') {
                    $data = $this->ConversionModel->getSKReportForSKFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_report', $data);
                }
                else if ($process == 'co_second_proceeding') {
                    $data = $this->ConversionModel->getSKReportForCOSecond($case_no);
                    $this->load->view('conversion/co/co_second_proceeding_skreport', $data);
                }
                else if ($process == 'premium_notice') {
                    $data = $this->ConversionModel->getSKReportForCOSecond($case_no);
                    $this->load->view('conversion/co/co_second_proceeding_skreport', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getSKReportForCOSecond($case_no);
                    $this->load->view('conversion/co/co_second_proceeding_skreport', $data);
                }
                else if($process == 'co_final_order') {
                    $data = $this->ConversionModel->getSKReportForCOSecond($case_no);
                    $this->load->view('conversion/co/co_second_proceeding_skreport', $data);
                }
                else {
                    $this->load->view('v2/conversion/reportViews/skReport');
                }
            }
        }
        public function boReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            if($service == SERVICE_CONVERSION) {
                $this->load->view('v2/conversion/reportViews/boReport');
            }
        }

        public function adcReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            if($service == SERVICE_CONVERSION) {
                $this->load->view('v2/conversion/reportViews/adcReport');
            }
        }

        public function dcReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            if($service == SERVICE_CONVERSION) {
                $this->load->view('v2/conversion/reportViews/dcReport');
            }
        }

        public function dptReport() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            if($service == SERVICE_CONVERSION) {
                $this->load->view('v2/conversion/reportViews/dptReport');
            }
        }

        public function proceeding() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            if($service == SERVICE_CONVERSION) {
                $this->load->view('v2/conversion/reportViews/proceeding');
            }
        }

        public function premium() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getPremiumNoticeDetails($case_no);
                    $this->load->view('conversion/ast/ast_premium', $data);
                } else {
                    $this->load->view('v2/conversion/reportViews/premium');
                }
            }
        }

        public function history() {
            $service = $this->input->post('service_code');
            $case_no = $this->input->post('case_no');
            $process = $this->input->post('process');
            if($service == SERVICE_CONVERSION) {
                if($process == 'lm_first_proceeding') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/lm/lm_first_proceeding_history', $data);
                }
                else if($process == 'sk_first_proceeding') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
                else if ($process == 'co_second_proceeding') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
                else if($process == 'premium_notice') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
                else if($process == 'confirm_premium') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
                else if($process == 'co_final_order') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
                else if($process == 'co_all_cases') {
                    $data = $this->ConversionModel->getLMHistoryForLMFirst($case_no);
                    $this->load->view('conversion/sk/sk_first_proceeding_history', $data);
                }
            }
        }

    }



// $dist_code = $this->session->userdata('dist_code');
                // $subdiv_code = $this->session->userdata('subdiv_code');
                // $cir_code = $this->session->userdata('cir_code');
                // $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
                // $lot_no = $this->session->userdata('lot_no1');
                // $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
                // $user_code=$this->session->userdata('user_code');
                // $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);

                // $petition_basic = $this->PetitionBasicModel->get(['case_no'=>$case_no, 'dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 'lot_no'=>$lot_no, 'vill_townprt_code'=>$vill_townprt_code]);

                // $petition_no = $petition_basic->petition_no;

                // $landdetails = $this->PetitionDagDetailsModel->get(['dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 'lot_no'=>$lot_no, 'vill_townprt_code'=>$vill_townprt_code, 'petition_no'=>$petition_no], 'dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code');

                // $dist_name = $this->utilityclass->getDistrictName($petition_basic->dist_code);
                // $subdiv_name = $this->utilityclass->getSubDivName($petition_basic->dist_code, $petition_basic->subdiv_code);
                // $cir_name = $this->utilityclass->getCircleName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code);
                // $mouza_pargona_name = $this->utilityclass->getMouzaName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code);
                // $lot_name = $this->utilityclass->getLotName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no);
                // $vill_townprt_name = $this->utilityclass->getVillageName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code);

                // $m_dag_area_lc = round($landdetails->m_dag_area_lc, 2);

                // $data['land_details'] = array(
                //     'dag' => $landdetails->dag_no,
                //     'm_dag_area_b' => $landdetails->m_dag_area_b,
                //     'm_dag_area_k' => $landdetails->m_dag_area_k,
                //     'm_dag_area_lc' => $m_dag_area_lc,
                //     'patta_no' => trim($landdetails->patta_no),
                //     'patta_type' => $landdetails->patta_type_code
                // );

                // $data['location'] = array(
                //     'dist' => $dist_name,
                //     'sub' => $subdiv_name,
                //     'cir' => $cir_name,
                //     'mouza' => $mouza_pargona_name,
                //     'lot' => $lot_name,
                //     'vill' => $vill_townprt_name,
                //     'case_no' => $case_no,
                //     'date' => $petition_basic->date_entry,
                //     'add_to' => $coname->username,
                //     'next_date' => $petition_basic->next_date_of_hearing,
                //     'sk_comment' => $petition_basic->sk_comment,
                //     'dag' => $landdetails->dag_no,
                //     'm_dag_area_b' => $landdetails->m_dag_area_b,
                //     'm_dag_area_k' => $landdetails->m_dag_area_k,
                //     'm_dag_area_lc' => $m_dag_area_lc,
                //     'patta_no' => trim($landdetails->patta_no),
                //     'patta_type' => $landdetails->patta_type_code,
                // );

                // $conversion_code = CONVERSION_CODE;

                // $data['conv_type'] = $this->MasterOfficeMutationTypeModel->get(['order_type_code'=>$conversion_code], 'order_type')->order_type;
                // $data['patta_type'] = $this->PattacodeModel->get_the_patta(['type_code'=>$landdetails->patta_type_code])->patta_type;

                // $data['pattadar'] = $this->PetitionerPartModel->get(['dist_code'=>$petition_basic->dist_code, 'subdiv_code'=>$petition_basic->subdiv_code, 'cir_code'=>$petition_basic->cir_code, 'lot_no'=>$petition_basic->lot_no, 'vill_townprt_code'=>$petition_basic->vill_townprt_code, 'mouza_pargona_code'=>$petition_basic->mouza_pargona_code, 'petition_no'=>$petition_basic->petition_no, 'dag_no'=>$landdetails->dag_no, 'TRIM(patta_no)'=>trim($landdetails->patta_no), 'patta_type_code'=>$landdetails->patta_type_code], 'auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2', 'multiple');

                // $this->load->view('v2/conversion/reportViews/application', $data);


?>