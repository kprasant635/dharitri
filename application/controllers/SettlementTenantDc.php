<?php

class SettlementTenantDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basundhara/SettlementApiModel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;

        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementTenantDcModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('UtilsModel');

        $method = $this->router->fetch_method();
        if (!in_array($method, VERIFICATION_MODULE_METHODS)) {
            if (HOLD_All_MB2_CASES_STATUS == 1) {
                if (HOLD_All_MB2_CASES_STATUS == 1) {
                    if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                        $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                        redirect(base_url() . "index.php/Home/index");
                    }
                }
            }
        }

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

    //********************** COMMON **********************************

    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag) {
            $totalAreaInApplication = 0;
            $totalAreaInLMApplication = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict = $dag->dist_code;
            $appSubDiv = $dag->subdiv_code;
            $appCircle = $dag->cir_code;
            $appMouza = $dag->mouza_pargona_code;
            $appLot = $dag->lot_no;
            $appVillage = $dag->vill_townprt_code;
            $appDag = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta, $application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY))) {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }
                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }

                    }
                }
                if ($totalAreaInChitha == 0) {
                    $areaCheck = 1;
                }
                if (($totalAreaInApplication + $totalAppliedAreaInApplication) == 0) {
                    $areaCheck = 1;
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication) {
                    $areaCheck = 1;
                }

            } else {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if ($totalAreaInChitha == 0) {
                    $areaCheck = 1;
                }
                if (($totalAreaInApplication + $totalAppliedAreaInApplication) == 0) {
                    $areaCheck = 1;
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication) {
                    $areaCheck = 1;
                }
            }

            $chithaDagArray[] = $chithaDag;
            $lmProcessArea[] = $allLmProcess;
            $allApplicationDagArray[] = $allApplicationDags;
        }

        $checkAreaDetail = array(
            'chithaArea' => $chithaDagArray,
            'reservedArea' => $allApplicationDagArray,
            'lmProcessArea' => $lmProcessArea,
            'appliedDags' => $appliedDags,
            'areaCheck' => $areaCheck,
        );

        return $checkAreaDetail;

    }

    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $totalAreaInApplication = 0;
        $totalAppliedAreaInApplication = 0;
        $areaCheck = 0;
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        foreach ($dags as $dag) {
            $appDistrict = $dag->dist_code;
            $appSubDiv = $dag->subdiv_code;
            $appCircle = $dag->cir_code;
            $appMouza = $dag->mouza_pargona_code;
            $appLot = $dag->lot_no;
            $appVillage = $dag->vill_townprt_code;
            $appDag = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY))) {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }

                    }
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication) {
                    $areaCheck = 1;
                }

            } else {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication) {
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;

    }

    // Generate random File name
    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    // random file name
    public function randomFileName()
    {
        $rand = rand(00000, 99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_' . $dist_code . '_' . $rand;

        if ($this->SettlementTeaDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0) {
            $this->randomFileName();
        } else {
            return $new_case_no;
        }
    }

    // random file name for general
    public function randomFileNameGeneral()
    {
        $rand = rand(000000, 999999);
        $new_case_no = 'general_notice_' . $rand;

        if ($this->SettlementTenantDcModel->checkDuplicateFileNameInGeneral($new_case_no) != 0) {
            $this->randomFileName();
        } else {
            return $new_case_no;
        }

    }

    public function getErrorPage()
    {
        return '<h2>' . 'Data not Found' . '</h2>';
    }

    // Revert from dc to co
    public function applicationRevertFromDCToCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {

            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $updateData = array(
                    'status' => MB_REVERT,
                    'pending_office' => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 0,

                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_REVERT,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_CIRCLE_OFFICER,
                        'task' => 'Reverted to CO.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Reverted by DC.';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = MB_CIRCLE_OFFICER;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00011: Reverted by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // Rejected  Application by DC
    public function applicationRejectedByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $updateData = array(
                    'status' => MB_DISMISS,
                    'pending_office' => '',
                    'pending_officer' => '',
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 0,
                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_DISMISS,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => '',
                        'task' => 'Rejected by DC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Rejected by DC.';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = null;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00012: Rejected by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // Rejected Application by SDLAC
    public function applicationRejectedBySdlac()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $updateData = array(
                    'status' => MB_DISMISS,
                    'pending_office' => '',
                    'pending_officer' => '',
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 0,
                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    $updatePro = array(
                        'status' => PRO_CASE_STATUS_REJECT,
                    );

                    $this->SettlementTenantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no, $updatePro);

                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_DISMISS,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => '',
                        'task' => 'Rejected by SDLAC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Rejected by SDLAC.';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = null;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00013: Rejected by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // Approve application by SDLAC
    public function applicationApprovedBySdlac()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);

            $sql = "SELECT * FROM settlement_proposal_cases WHERE case_no = ? ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int) $proposal_no->proposal_id;

            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no, $dist_code);
            $caseCountInPro = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);

            if ($caseCount == 0 && $caseCountInPro != 1) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                if ($checkArea != 0) {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $updateData = array(
                    'status' => MB_PENDING,
                    'pending_office' => MB_DEPARTMENT,
                    'pending_officer' => MB_DEPARTMENT,
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'sdlac_approval' => 'Y',
                    'sdlac_date' => date('Y-m-d h:i:s'),
                    'sdlace_proposal_no' => $proposal_no_int,
                    'dc_proceeding' => 1,
                );

                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    $updatePro = array(
                        'status' => PRO_CASE_STATUS_APPROVE,
                    );

                    $this->SettlementTenantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no, $updatePro);

                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_PENDING,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPARTMENT,
                        'task' => 'Approved by SDLAC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Approved by SDLAC.';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = MB_DEPARTMENT;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // view payment received application details
    public function viewPaymentReceivedAppDetailsByDc()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $caseCount = $this->SettlementTenantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails = $this->SettlementTenantDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);
            $proceedings = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount'] = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tenant/payment_received_app_details_tenant';
            $this->load->view('layouts/main', $data);
        }
    }

    // order to co by dc for chitha updating
    public function orderToCoByDcForChithaUpdating()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                if ($checkArea != 0) {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }
                $updateData = array(
                    'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                    'pending_office' => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_approval' => 'Y',
                    'dc_proceeding' => 1,

                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_CIRCLE_OFFICER,
                        'task' => 'Order for Chitha Updating.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Order for chitha update.';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = MB_CIRCLE_OFFICER;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00014: Order for chitha update failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // update the proposal hearing date
    public function updateProposalHearingDateTenant()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposalNo', 'Hearing Date', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $currentDate = date('Y-m-d');
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $proposalNo = $this->input->post('proposalNo');

            if ($currentDate > $hearingDate) {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;

            }

            $allCases = $this->SettlementTenantDcModel->getAllAppInReportSendByDcToSdlacTenant($proposalNo);
            $allCasesCount = $allCases->num_rows();

            if ($allCasesCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                echo json_encode(array(
                    'responseType' => 2,
                    'remarks' => $remarks,
                    'hearingDate' => $hearingDate,
                    'caseList' => $allCases->result(),
                ));
                return;
            }
        }
    }

    // save new notice and pro
    public function updateHearingDateGenerateNoticeTenant()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposalNo', 'Proposal Details', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $proposalNo = $this->input->post('proposalNo');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));

            if ($htmlstring_text == '') {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            $proposalDetails = $this->SettlementTenantDcModel->getProposalDetailsById($proposalNo, $dist_code);
            if ($proposalDetails == '') {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $allCases = $this->SettlementTenantDcModel->getAllAppInReportSendByDcToSdlacTenant($proposalNo);
                $allCasesCount = $allCases->num_rows();
                if ($allCasesCount == 0) {
                    echo json_encode(array(
                        'responseType' => 3,
                    ));
                    return;
                } else {
                    $new_case_no = $this->randomFileName();

                    if (is_dir(SEND_TO_SDLAC_NOTICE_PATH) === false) {
                        mkdir(SEND_TO_SDLAC_NOTICE_PATH, 0777);
                    }

                    $base_64_file_path = SEND_TO_SDLAC_NOTICE_PATH . $new_case_no . ".json";
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    $allSelectedList = $allCases->result();
                    $oldFileName = $proposalDetails->file_path;

                    $updateProposalData = array(
                        'h_date' => $hearingDate,
                        'remarks' => $remarks,
                        'ip' => $this->input->ip_address(),
                        'file_path' => $base_64_file_path,
                    );
                    $this->db->trans_begin();
                    if ($this->SettlementTenantDcModel->updateProposalListById($proposalNo, $updateProposalData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        unlink($oldFileName);

                        foreach ($allSelectedList as $row) {
                            $case_no = $row->case_no;
                            //////proceeding start//////
                            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                            if ($proceeding_id == null) {
                                $proceeding_id = 1;
                            }

                            $insPetProceed = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'date_of_hearing' => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date("Y-m-d h:i:s", strtotime($hearingDate)),
                                'status' => MB_HEARING_DATE_CHANGED,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'note_on_order' => $remarks,
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => MB_DEPUTY_COMM,
                                'office_to' => MB_DEPUTY_COMM,
                                'task' => 'Hearing Date Changed',
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if ($insertProceeding != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                                echo json_encode(array(
                                    'responseType' => 1,
                                ));
                                return;
                            }

                            //////proceeding end//////

                        }
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                        ));
                        return;
                    }
                }
            }
        }
    }
    //********************** COMMON **********************************

    //********************************************************************
    //********************** START TENANT **********************************
    // 1st landing page TENANT
    public function SettlementApFirstLandDc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementTenantDcModel->countAllPendingSettlementTenant($dist_code);
        $paymentConfirmCount = $this->SettlementTenantDcModel->paymentConfirmNoticeCount($dist_code);
        $paymentReceivedCount = $this->SettlementTenantDcModel->paymentReceivedCount($dist_code);

        $rejctedListCount = $this->SettlementCommonDcModel->rejectedCaseList($dist_code, SETTLEMENT_TENANT_ID, MB_DEPUTY_COMM);

        $revivalListCount = $this->SettlementCommonDcModel->revivalListCount($dist_code, SETTLEMENT_TENANT_ID, MB_DEPUTY_COMM);

        $noticeGeneratedAdcHearingCount = $this->SettlementTenantDcModel->noticeGeneratedAdcHearingCasesCount($dist_code);

        $generatePaymentNoticeCount = $this->SettlementTenantDcModel->generatePaymentNoticeCount($dist_code);

        // $reReportByCOCount = $this->SettlementTenantDcModel->countReRevertedByCoApplicationTenant($dist_code);
        // $approvedListCount = $this->SettlementTenantDcModel->countAllApproveAppBySdlacTenant($dist_code);
        // $rejectedListCount = $this->SettlementTenantDcModel->countAllRejectAppByDcTenant($dist_code);
        // $revertedByDepartmentCount = $this->SettlementTenantDcModel->countRevertedByDeptApplicationTenant($dist_code);

        $caseStatusCount = 0;
        $beneficiaryCount = 0;
        $reReportByCOCount = 0;
        $approvedListCount = 0;
        $rejectedListCount = 0;
        $revertedByDepartmentCount = 0;

        $data['lotCount'] = $this->SettlementTenantDcModel->lotCount($dist_code);
        $data['dist_code'] = $dist_code;
        $data['beneficiaryCount'] = $beneficiaryCount;
        $data['genExlReportCount'] = $this->SettlementTenantDcModel->exlReportGenCount($dist_code)->count;
        $data['reReportByCOCount'] = $reReportByCOCount;
        $data['caseStatusCount'] = $caseStatusCount;
        $data['approvedListCount'] = $approvedListCount;
        $data['rejectedListCount'] = $rejectedListCount;
        $data['paymentConfirmCount'] = $paymentConfirmCount;
        $data['paymentReceivedCount'] = $paymentReceivedCount;
        $data['firstProceedingCount'] = $firstProceedingCount;
        $data['revertedByDepartmentCount'] = $revertedByDepartmentCount;
        $data['rejctedListCount'] = $rejctedListCount;
        $data['revivalListCount'] = $revivalListCount;

        $data['noticeGeneratedAdcHearingCount'] = $noticeGeneratedAdcHearingCount;

        $data['generatePaymentNoticeCount'] = $generatePaymentNoticeCount;

        //$data['SDLACCommitteeCount']  = $SDLACCommitteeCount;

        $data['_view'] = 'settlementView/Dc/Tenant/first_landing_page_dc_tenant';
        $this->load->view('layouts/main', $data);

    }

    // view all first Proceeding case list TENANT
    public function viewAllApFirstProceedingDCCaseList()
    {
        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllPendingSettlementTenant($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/first_proceeding_case_dc_tenant';
        $this->load->view('layouts/main', $data);

    }
    // view all first Proceeding case list TENANT
    public function noticeGeneratedAdcHearingCases()
    {
        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllNoticeGeneratedCases($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['select_data'] = $this->db->query('select * from settlement_basic where dist_code = ? and service_code = ? and status =? and pending_officer = ?', array($dist_code, SETTLEMENT_TENANT_ID, 'W', 'DC'))->result();

        $data['adcList'] = $this->db->query('SELECT u.username, l.user_code FROM loginuser_table l JOIN users u ON l.dist_code = u.dist_code AND l.subdiv_code = u.subdiv_code AND l.user_code = u.user_code WHERE l.dist_code = ? AND l.subdiv_code = ? AND u.user_desig_code = ? AND l.dis_enb_option = ?', array($dist_code, '00', 'ADC', 'E'))->result();

        $data['_view'] = 'settlementView/Dc/Tenant/notice_generated_adc_hearing';
        $this->load->view('layouts/main', $data);

    }

    public function paymentNoticeCases()
    {
        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->paymentNoticeCases($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/paymenet_notice_forwarded_by_adc';
        $this->load->view('layouts/main', $data);

    }

    public function generatePaymentNoticeCaseView()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $data['basic'] = $basic;
        $data['applicants'] = $applicants;
        $data['dags'] = $dags;
        $data['lmnotes'] = $lmnotes;
        $data['proceedings'] = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query'] = $output->query;
        $data['property'] = $output->property;
        $data['aadhar'] = $output->aadhar;
        $data['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }
        $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $application_no = $this->input->get('case');
            $basic = $this->SettlementTenantModel->getSettlementBasic($application_no);
            $applicants_buyers = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
            $applicants_owners = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);
            $dags = $this->SettlementTenantModel->getSettlementDag($application_no);
            $data['dagsResult'] = $this->SettlementTenantModel->getSettlementDagResult($application_no);

            $lmnotes = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
            $proceedings = $this->SettlementTenantModel->getSettlementProceeding($application_no);
            $dhardocuments = $this->SettlementTenantModel->getDocuments($application_no);
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea'] = $checkAreaDetails['chithaArea'];
            $data['reservedArea'] = $checkAreaDetails['reservedArea'];
            $data['areaCheck'] = $checkAreaDetails['areaCheck'];
            $data['appliedDags'] = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $data['basic'] = $basic;
            $data['applicants_buyers'] = $applicants_buyers;
            $data['applicants_owners'] = $applicants_owners;
            $data['applicants_encroacher'] = $applicants_encroacher;
            $data['applicants_riotee_nok'] = $applicants_riotee_nok;
            $data['dags'] = $dags;
            $data['lmnotes'] = $lmnotes;
            $data['proceedings'] = $proceedings;
            $data['dhardocuments'] = $dhardocuments;
            $data['pattaNo'] = $this->utilityclass->getPattaTypeNo($data['basic']["dist_code"], $data['basic']["subdiv_code"], $data['basic']["cir_code"], $data['basic']["mouza_pargona_code"], $data['basic']["lot_no"], $data['basic']["vill_townprt_code"], $data['dags']["dag_no"]);

            $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
            $basundhara = $this->db->query($sql)->row();
            $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            $data['document'] = $output->documents;
            $data['query'] = $output->query;
            $data['property'] = $output->property;
            $data['aadhar'] = $output->aadhar;
            $data['nextKin'] = $output->nextKin;
            foreach ($output->selfDeclaration as $selfDec) {
                $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
            }

            $caseDetails = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            $proceedings = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            // $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
            if ($rejected_data == 'n') {
                $data['rejected_list'] = false;
            } else {
                $data['rejected_list'] = $rejected_data;
            }

            foreach (json_decode(VALIDATION_BYPASS) as $val_bypas) {
                if ($val_bypas->SERVICE_CODE == SETTLEMENT_TENANT_ID) {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }

            $data['validation_bypass'] = 0;

            foreach ($data['lmnotes'] as $lm_rr) {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if ($decoded_r) {
                    foreach ($decoded_r as $lm_rejected_code) {
                        if (isset($lm_rejected_code->reject_code)) {
                            if (in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        } else {
                            if (in_array($lm_rejected_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach ($lmnotes as $r_remark) {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if ($rejected_list_json) {
                    foreach ($rejected_list_json as $re_list) {

                        if (isset($re_list->reject_code)) {
                            $r_code = $re_list->reject_code;
                        } else {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if ($sql->row()->remark_head != null) {
                            $data['reject_list_type'] = 'new';
                        } else {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $data['_view'] = 'settlementView/Dc/Tenant/payment_notice_case_view';
            $this->load->view('layouts/main', $data);
        }
    }

    public function hearingNoticeAdcPagination()
    {
        $service = $this->input->post('service');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $occupation = trim($this->input->post('occupation'));

        $searchByCol_0 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[2]['search']['value']);

        $is_cat = $this->input->post('is_category');

        $is_rural = $this->input->post('rural');

        $dist_code = $this->session->userdata('dist_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========

        if (!empty($searchByCol_0)) {

            $this->db->like('case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('applid', strtoupper($searchByCol_1));
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PENDING);
        $this->db->where('(general_notice_dc = \'y\' or general_notice_dc is not null)');
        $this->db->where('(note_action_yn != \'y\' or note_action_yn is null)');
        $this->db->where('dist_code', $dist_code);
        $this->db->limit($length, $start);
        $results = $this->db->get();

        if ($results->num_rows() > 0) {
            //==============getting the reject_list
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            if ($rejected_data == 'n') {
                $rejected_list = false;
            } else {
                $rejected_list = $rejected_data;
            }

            $res = $results->result();

            foreach ($res as $rows) {
                $case_no = $rows->case_no;

                $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $rejected_list);

                if ($chithaRemarks == true) {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                } else {
                    $chithaFlag = 'No';
                }

                $link = '<a target="_black" type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';

                $json[] = array(
                    $rows->case_no,
                    '<span class="px-3"><strong>' . $rows->applid . '</strong></span>',
                    '<span class="px-3"><strong>' . $rows->case_no . '</strong></span>',

                    '<b>' . $chithaFlag . '</b>',

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $link,
                );
            }

            $this->db->select('*');
            $this->db->where('service_code', SETTLEMENT_TENANT_ID);
            $this->db->where('pending_officer', MB_DEPUTY_COMM);
            $this->db->where('status', MB_PENDING);
            $this->db->where('(general_notice_dc = \'y\' or general_notice_dc is not null)');
            $this->db->where('(note_action_yn != \'y\' or note_action_yn is null)');
            $this->db->where('dist_code', $dist_code);
            $total_records = $this->db->count_all_results('settlement_basic a');

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    // settlement application details TENANT
    public function getSettlementApApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $data['basic'] = $basic;
        $data['applicants'] = $applicants;
        $data['dags'] = $dags;
        $data['lmnotes'] = $lmnotes;
        $data['proceedings'] = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query'] = $output->query;
        $data['property'] = $output->property;
        $data['aadhar'] = $output->aadhar;
        $data['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }
        $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $application_no = $this->input->get('case');
            $basic = $this->SettlementTenantModel->getSettlementBasic($application_no);
            $applicants_buyers = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
            $applicants_owners = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);
            $dags = $this->SettlementTenantModel->getSettlementDag($application_no);
            $data['dagsResult'] = $this->SettlementTenantModel->getSettlementDagResult($application_no);

            $lmnotes = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
            $proceedings = $this->SettlementTenantModel->getSettlementProceeding($application_no);
            $dhardocuments = $this->SettlementTenantModel->getDocuments($application_no);
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea'] = $checkAreaDetails['chithaArea'];
            $data['reservedArea'] = $checkAreaDetails['reservedArea'];
            $data['areaCheck'] = $checkAreaDetails['areaCheck'];
            $data['appliedDags'] = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $data['basic'] = $basic;
            $data['applicants_buyers'] = $applicants_buyers;
            $data['applicants_owners'] = $applicants_owners;
            $data['applicants_encroacher'] = $applicants_encroacher;
            $data['applicants_riotee_nok'] = $applicants_riotee_nok;
            $data['dags'] = $dags;
            $data['lmnotes'] = $lmnotes;
            $data['proceedings'] = $proceedings;
            $data['dhardocuments'] = $dhardocuments;
            $data['pattaNo'] = $this->utilityclass->getPattaTypeNo($data['basic']["dist_code"], $data['basic']["subdiv_code"], $data['basic']["cir_code"], $data['basic']["mouza_pargona_code"], $data['basic']["lot_no"], $data['basic']["vill_townprt_code"], $data['dags']["dag_no"]);

            $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
            $basundhara = $this->db->query($sql)->row();
            $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            $data['document'] = $output->documents;
            $data['query'] = $output->query;
            $data['property'] = $output->property;
            $data['aadhar'] = $output->aadhar;
            $data['nextKin'] = $output->nextKin;
            foreach ($output->selfDeclaration as $selfDec) {
                $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
            }

            $caseDetails = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            $proceedings = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount'] = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
            if ($rejected_data == 'n') {
                $data['rejected_list'] = false;
            } else {
                $data['rejected_list'] = $rejected_data;
            }

            foreach (json_decode(VALIDATION_BYPASS) as $val_bypas) {
                if ($val_bypas->SERVICE_CODE == SETTLEMENT_TENANT_ID) {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }

            $data['validation_bypass'] = 0;

            foreach ($data['lmnotes'] as $lm_rr) {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if ($decoded_r) {
                    foreach ($decoded_r as $lm_rejected_code) {
                        if (isset($lm_rejected_code->reject_code)) {
                            if (in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        } else {
                            if (in_array($lm_rejected_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach ($lmnotes as $r_remark) {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if ($rejected_list_json) {
                    foreach ($rejected_list_json as $re_list) {

                        if (isset($re_list->reject_code)) {
                            $r_code = $re_list->reject_code;
                        } else {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if ($sql->row()->remark_head != null) {
                            $data['reject_list_type'] = 'new';
                        } else {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $data['_view'] = 'settlementView/Dc/Tenant/settlement_app_details_tenant';
            $this->load->view('layouts/main', $data);
        }
    }

    // get payment generation page
    public function generatePaymentNotice()
    {

        if (isset($_POST['generate_notice'])) {
            $case_no = $this->input->post('case_no');
            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
            if ($checkArea != 0) {
                $this->getSettlementApApplicationDetails($case_no);
            }
            $payment_amount = $this->input->post('payment_amount');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $remark = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementTenantModel->getBuyersTenant($case_no);

            if (empty($get_buyers) || $get_buyers == null || $get_buyers == '') {
                $this->session->set_flashdata('message', "#ERR1949: Unable to process! Something went wrong...#" . $case_no);
                redirect(base_url() . 'index.php/home');
            }

            $get_dag_details = $this->SettlementApModel->getDags($case_no);

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getApplicationDate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
            )));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                if (json_decode($output)->responseType != 'y') {
                    echo json_decode($output)->data . " - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $res = json_decode($output);

            // $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));
            $khatian_no = '';
            foreach ($get_settlement_applicant as $khatianRow) {
                if ($khatianRow->pdar_type == 'EN') {
                    $khatian_no = $khatianRow->khatian_no;
                }
            }

            $data = [
                'payment_amount' => $payment_amount,
                'case_no' => $case_no,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark' => $remark,
                'pay_notice_date' => date('Y-m-d'),
                'premium_data' => $premium_data,
                'date_of_application' => date('d/m/Y', strtotime($res->submission_date)),
                'khatian_no' => $khatian_no,
            ];
            $this->load->view('SettlementView/Dc/Tenant/paymentNotice', $data);
        } else {
            $case_no = $this->input->get('case');

            $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);
            foreach (json_decode(VALIDATION_BYPASS) as $val_bypas) {
                if ($val_bypas->SERVICE_CODE == SETTLEMENT_TENANT_ID) {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }

            $data['validation_bypass'] = 0;

            foreach ($lmnotes as $lm_rr) {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if ($decoded_r) {
                    foreach ($decoded_r as $lm_rejected_code) {
                        if (isset($lm_rejected_code->reject_code)) {
                            if (in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        } else {
                            if (in_array($lm_rejected_code, $const_bypass_arr_code)) {
                                $data['validation_bypass'] = 1;
                            }
                        }
                    }
                }
            }

            if ($data['validation_bypass'] != 1) {
                $premSql = $this->db->query('select * from settlement_premium where case_no = ?', array($case_no));

                if ($premSql->num_rows() <= 0) {
                    $district['dags'] = $this->SettlementKhasModel->getSettlementDag($case_no);

                    $revenue = $this->db->query("SELECT dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no))->row();
                    $district['revenue'] = $revenue;

                    if ((in_array($district['dags'][0]->dist_code, json_decode(BARAK_VALLEY)))) {
                        $total_dag_lessa = ($district['dags'][0]->dag_area_b * 6400) + ($district['dags'][0]->dag_area_k * 320) + ($district['dags'][0]->dag_area_lc * 20) + $district['dags'][0]->dag_area_g;

                        $total_s_lessa = ($district['dags'][0]->s_dag_area_b * 6400) + ($district['dags'][0]->s_dag_area_k * 320) + ($district['dags'][0]->s_dag_area_lc * 20) + $district['dags'][0]->s_dag_area_g;
                    } else {
                        $total_dag_lessa = ($district['dags'][0]->dag_area_b * 100) + ($district['dags'][0]->dag_area_k * 20) + ($district['dags'][0]->dag_area_lc);

                        $total_s_lessa = ($district['dags'][0]->s_dag_area_b * 100) + ($district['dags'][0]->s_dag_area_k * 20) + ($district['dags'][0]->s_dag_area_lc);
                    }

                    $total_dag_lessa = $total_dag_lessa;
                    $total_app_lessa = $total_s_lessa;
                    $zonal_bigha = $revenue->dag_revenue;
                    $dag_per_lessa_revenue = ($zonal_bigha / $total_dag_lessa);
                    $final_amount = ($total_app_lessa * $dag_per_lessa_revenue);
                    $sumMbAmount = ceil($final_amount * 50);

                    $premdata = array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'dag_no' => $district['dags'][0]->dag_no,
                        'zonal_valuation' => $zonal_bigha,
                        'final_amount' => $sumMbAmount,
                        'due_amount' => $sumMbAmount,
                        'total_lessa' => $total_app_lessa,
                        'is_final' => 1,
                        'date_entry' => date('Y-m-d h:i:s'),

                    );

                    $insPremiumUpdate = $this->db->insert('settlement_premium', $premdata);

                    if ($insPremiumUpdate != 1) {
                        // $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERR2098: Unable to process! Something went wrong...#" . $case_no);
                        redirect(base_url() . 'index.php/home');
                    }
                }
            }

            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
            if ($checkArea != 0) {
                $this->getSettlementApApplicationDetails($case_no);
            }

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();

            $get_buyers = $this->SettlementApModel->getBuyers($case_no);

            $data['tenant_multiple_applicant'] = '';

            $eligibility_flagged = 0;
            $applicantNames = '';

            if (count($get_buyers) > 1) {
                foreach ($get_buyers as $buyers) {
                    if (!empty($buyers->applicant_eligibility) || $buyers->applicant_eligibility != null || $buyers->applicant_eligibility != '') {
                        $eligibility_flagged = 1;
                    }

                    $applicantNames .= '<br>' . $buyers->pdar_name;
                }
            }

            if ($eligibility_flagged != 1 && count($get_buyers) > 1) {
                $data['tenant_multiple_applicant'] = '<span class="text-justify text-danger alert-warning pl-5 pr-5"><h5>*Note - Eligibility of applicant(s) for settlement of patta is not flagged yet! Forwarding this application will be considered of all applicant(s) for settlement of patta.</h5> <u><b>Applicants</b></u>' . $applicantNames . '</span>';
            }

            $data['premium_data'] = $premium_data;
            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['case_no'] = $case_no;
            $data['_view'] = 'SettlementView/DC/Tenant/generateNoticeView';
            $this->load->view('layouts/main', $data);

        }
    }

    // save payment notice
    public function savePaymentNotice()
    {
        $case_no = $this->input->post('case_no');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) {
            $this->session->set_flashdata('message', "#ERR1843: Premium notice already generated # " . $case_no);
            redirect(base_url() . "index.php/home");
        }

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $remark_co = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $district = $this->input->post('district');
        $sub_division = $this->input->post('sub_division');
        $circle = $this->input->post('circle');
        $lot_no = $this->input->post('lot_no');
        $mouza = $this->input->post('mouza');
        $village = $this->input->post('village');

        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');

        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

        if ($checkArea != 0) {
            log_message('error', '#ERRPN00678: Applied area cannot exceed total chitha area !');
            $json = [
                'responseType' => 10,
                'message' => '#ERRPN00678: Applied area cannot exceed total chitha area !',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_begin();

        //*******inserting riotee NOK's in the chitha tenant */
        $applicants_riotee_nok = $this->SettlementTenantModel->getAllApplicantRioteeNok($case_no);
        $firstCheck = true;

        if ($applicants_riotee_nok == true) {

            $getEndata = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = ?", array($case_no, 'EN'));

            if ($getEndata->num_rows() > 0) {
                $riotee_data = $getEndata->row();

                $tenant_dag_no = $riotee_data->dag_no;
                $tenant_khatian_no = $riotee_data->khatian_no;

                foreach ($applicants_riotee_nok as $nok) {
                    if ($firstCheck === true) {

                        $sql = "Select tenant_id from chitha_tenant where subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and khatian_no=? and dag_no=? order by tenant_id desc ";
                        $tenant_id = $this->db->query($sql, array($nok->subdiv_code, $nok->cir_code, $nok->mouza_pargona_code, $nok->lot_no, $nok->vill_townprt_code, $tenant_khatian_no, $tenant_dag_no));
                        if ($tenant_id->num_rows() <= 0) {
                            $t_id = 1;
                        } else {
                            $dd = $tenant_id->row();
                            $t_id = $dd->tenant_id + 1;
                        }
                    }
                    $t_id = $firstCheck == true ? $t_id : $t_id + 1;
                    $insertData = [
                        'dist_code' => $nok->dist_code,
                        'subdiv_code' => $nok->subdiv_code,
                        'cir_code' => $nok->cir_code,
                        'mouza_pargona_code' => $nok->mouza_pargona_code,
                        'lot_no' => $nok->lot_no,
                        'vill_townprt_code' => $nok->vill_townprt_code,
                        'dag_no' => $tenant_dag_no,
                        'tenant_name' => $nok->pdar_name,
                        'tenants_father' => $nok->pdar_guardian,
                        'tenants_add1' => 'addr1',
                        'tenants_add2' => 'addr2',
                        'type_of_tenant' => '01',
                        'khatian_no' => $tenant_khatian_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'tenant_id' => $t_id,
                    ];
                    $firstCheck = false;
                    $insertChithaTenant = $this->db->insert('chitha_tenant', $insertData);

                    if ($insertChithaTenant != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO0045: Insertion failed in chitha_tenant');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO0045: Failed to generate notice. Kindly contact System Administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    if ($insertChithaTenant == 1) {
                        $updateDataSettle = [
                            'riotee_id' => $t_id,
                        ];
                        $this->db->where('id', $nok->id);
                        $this->db->where('case_no', $case_no);
                        $this->db->update('settlement_applicant', $updateDataSettle);
                        if ($this->db->affected_rows() != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRCO004554: Falied to update riotee id in settlement_applicant');
                            $json = [
                                'responseType' => 3,
                                'message' => '#ERRCO004554: Falied to forward to DC. Kindly contact system administrator',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }
                    $firstCheck = false;
                }
            }
        }

        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                'APPLICANT_ID' => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME' => $buyers->pdar_guardian,
            ];
        }
        $notice_no = "MB2/PN/" . date('Y') . "/SOT/" . $service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no' => $case_no,
            'service_code' => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date' => date('Y-m-d'),
            'total_amount' => $amount,
            'sdlac_proposal_id' => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date' => $service_details->sdlac_date,
            'applicant_details' => json_encode($applicant_buyers_json),
            //'payment_completed_date'      => date('Y-m-d'),
            'notice_no' => $notice_no,
            'notice_link' => $base_64_file_path,
            'notice_type' => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN00678: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        $updateArr = [
            'status' => 'N',
            'dc_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'DC',
            'pending_officer' => 'DC',
            'pending_office' => 'DC',
            'co_notice_link' => $base_64_file_path,
            'dc_proceeding' => 1,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0001: Failed to generate notice. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $remark_co,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'DC',
            'office_to' => 'DC',
            'task' => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0002: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "PN0001: Error in submitting. Please try Again",
            );
            echo json_encode($data);
            return false;
        } else {

            //   API CALL END HERE
            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type' => 'PN',
                'amount' => $amount,
                'is_full_pay' => 'Y',
            )));
            $result = curl_exec($curl_handle);
            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "PN0005: Error in submitting. Please try Again",
                );
                echo json_encode($data);
                return false;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...(This notice will be available under step #4)");
                redirect(base_url() . 'index.php/SettlementTenantDc/SettlementApFirstLandDc');
            }
        }
    }

    // get all DC approved list TENANT
    public function getAllApprovedBySDLACListTenant()
    {
        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllApproveAppBySdlacTenant($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/approve_list_by_sdlac_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view Approve Application TENANT
    public function viewApprovedAppDetailsTenant()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $data['basic'] = $basic;
        $data['applicants'] = $applicants;
        $data['dags'] = $dags;
        $data['lmnotes'] = $lmnotes;
        $data['proceedings'] = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query'] = $output->query;
        $data['property'] = $output->property;
        $data['aadhar'] = $output->aadhar;
        $data['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails = $this->SettlementTenantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
            $proceedings = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount'] = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tenant/settlement_app_details_only_view_tenant';
            $this->load->view('layouts/main', $data);
        }

    }

    // get all rejected app by dc TENANT
    public function getAllRejectByDcListTenant()
    {

        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllRejectAppByDcTenant($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/rejected_list_by_dc_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view Rejected Application TENANT
    public function viewRejectedAppDetailsTenant()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $data['basic'] = $basic;
        $data['applicants'] = $applicants;
        $data['dags'] = $dags;
        $data['lmnotes'] = $lmnotes;
        $data['proceedings'] = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query'] = $output->query;
        $data['property'] = $output->property;
        $data['aadhar'] = $output->aadhar;
        $data['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails = $this->SettlementTenantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
            $proceedings = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount'] = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tenant/settlement_app_details_rejected_only_view_tenant';
            $this->load->view('layouts/main', $data);
        }

    }

    // view all chitha update application TENANT
    public function excelGeneratedCases()
    {
        $sql = $this->db->query("SELECT exl_id, date_created FROM settlement_beneficiary_excel WHERE dc_process = 0 GROUP BY exl_id, date_created");
        if ($sql->num_rows() > 0) {
            $data['exl_list'] = $sql->result();
        } else {
            $data['no_data'] = true;
        }

        $data['_view'] = 'settlementView/Dc/Tenant/excel_generated_cases_view';
        $this->load->view('layouts/main', $data);
    }

    public function getAllOrderChithaUpdateForDcAppTenant()
    {
        $dist_code = $this->session->userdata('dist_code');
        $service_code = SETTLEMENT_TENANT_ID;
        $pendingCase = $this->SettlementTenantDcModel->getPaymentConfirmationDc($service_code, $dist_code);

        $data['dist_code'] = $dist_code;
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['cases'] = $pendingCase->result();

        $data['_view'] = 'settlementView/Dc/Tenant/order_chitha_update_list_by_dc_tenant';
        $this->load->view('layouts/main', $data);
    }

    public function confirmPaymentChithaUpdate()
    {
        $service_code = SETTLEMENT_TENANT_ID;
        //$data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationDc($service_code);

        $sql = $this->db->query("SELECT * FROM settlement_basic A INNER JOIN settlement_beneficiary_excel B ON A.case_no = B.case_no WHERE A.service_code = ?", array($service_code));

        if ($sql->num_rows() > 0) {
            $data['getPaymentConfirmationCo'] = $sql->result_array();
        } else {
            $data['getPaymentConfirmationCo'] = 'No data found !';
        }

        $data['_view'] = 'settlementView/Dc/Tenant/cofirm_payment_owner_end';
        $this->load->view('layouts/main', $data);
    }

    public function confirmPaymentApplicantDc()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $case_no_rtps = $get_settlement_basic->applid;
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);

        if ($payment_status_check == null || (
            !isset($payment_status_check->payment_status)
            && !isset($payment_status_check->total_premium)
            && !isset($payment_status_check->paid_amount)
            && !isset($payment_status_check->remaining_amount)
            && !isset($payment_status_check->tenure)
            && !isset($payment_status_check->installment_amount)
        )) {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $pay_status = $payment_status_check->payment_status;
        if (strtoupper($pay_status) == 'Y') {
            $total_premium = $payment_status_check->total_premium;
            $paid_amount = $payment_status_check->paid_amount;
            $remaining_amount = $payment_status_check->remaining_amount;
            $tenure = $payment_status_check->tenure;
            $installment_amount = $payment_status_check->installment_amount;
            $percentage = $payment_status_check->percentage;
            $pay_date = $payment_status_check->payment_date;
        } else {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $data = [
            'case_no' => $case_no,
            'payment_status' => strtolower($pay_status),
            'payment_date' => $pay_date,
            'case_no_rtps' => $case_no_rtps,
            'total_premium' => $total_premium,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => $tenure,
            'installment_amount' => $installment_amount,
            'percentage' => $percentage,
            //'_view' => 'settlement_mb/confirmPaymentView'
        ];

        if (strtoupper($pay_status) == 'Y') {
            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {
                $this->db->trans_begin();

                $dagsResult = $this->SettlementKhasModel->getSettlementDag($case_no);
                $isFullPay = 'YES';

                if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
                    $isFullPay = 'NO';
                }

                $insertArr = [
                    'is_full_pay' => $isFullPay,
                    'total_premium' => $payment_status_check->total_premium,
                    'paid_amount' => $payment_status_check->paid_amount,
                    'remaining_amount' => $payment_status_check->remaining_amount,
                    'tenure' => $payment_status_check->tenure,
                    'installment_amount' => $payment_status_check->installment_amount,
                    'payment_date' => $payment_status_check->payment_date,
                    'grn_no' => $payment_status_check->grn_no,
                ];

                $this->db->where('case_no', $case_no);
                $this->db->where('is_final', 1);
                $this->db->update('settlement_premium', $insertArr);

                if ($this->db->affected_rows() != count($dagsResult)) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
                    redirect(base_url() . "index.php/Home/index");
                }
                $this->db->trans_commit();
            }
        }

        // $data = [
        //     'case_no' => $case_no,
        //     'payment_status' => $payment_status_check->payment_status,
        //     'payment_date' => $payment_status_check->payment_date,
        //     'case_no_rtps' => $case_no_rtps,
        //     '_view' => 'settlementView/Dc/Tenant/confirmPaymentApplicantView'
        // ];

        $data = [
            'case_no' => $case_no,
            'payment_status' => strtolower($pay_status),
            'payment_date' => $pay_date,
            'case_no_rtps' => $case_no_rtps,
            'total_premium' => $total_premium,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => $tenure,
            'installment_amount' => $installment_amount,
            'percentage' => $percentage,
            '_view' => 'settlementView/Dc/Tenant/confirmPaymentApplicantView',
        ];

        $this->load->view('layouts/main', $data);

    }

    public function confirmPaymentOwnerDc()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $case_no_rtps = $get_settlement_basic->applid;
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);

        $data = [
            'case_no' => $case_no,
            'payment_status' => $payment_status_check->payment_status,
            'payment_date' => $payment_status_check->payment_date,
            'case_no_rtps' => $case_no_rtps,
            '_view' => 'settlementView/Dc/Tenant/confirmPaymentOwnerView',
        ];
        $this->load->view('layouts/main', $data);

    }

    public function confirmPaymentApplicant()
    {
        $case_no = $this->input->post('case_no');
        if (isset($_POST['payment_confirmed'])) {
            $this->db->trans_begin();
            $updateArr = [
                'status' => 'P',
                'dc_code' => $this->session->userdata('user_code'),
                'user_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'DC',
                'pending_officer' => 'DC',
                'pending_office' => 'DC',
                'dc_proceeding' => 1,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN000333: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRPN000333: Payment confirmation updation failed. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'Payment Cofirmed',
                'status' => 'P',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'DC',
                'office_to' => 'DC',
                'task' => 'Payment Confirmed from Applicant',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "ERR34234: Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "<span class ='alert-success text-center'>Payment status updated to confirmed...</span>");
                redirect(base_url() . 'index.php/SettlementTenantDc/SettlementApFirstLandDc');
            }
        }

    }

    public function AllApplicantPaymentConfirmedCases()
    {
        $service_code = SETTLEMENT_TENANT_ID;
        $dist_code = $this->session->userdata('dist_code');
        $getDistrict = $this->SettlementTenantDcModel->getLocationName($dist_code);
        $location = $getDistrict->result();
        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code, $circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $data['location'] = $circleList;
        $data['dist_code'] = $dist_code;
        $data['getPaymentConfirmationCo'] = $this->SettlementTenantDcModel->getPaymentReceivedApplicant($service_code);

        $data['_view'] = 'settlementView/Dc/Tenant/all_applicant_confirmed_payment_cases';
        $this->load->view('layouts/main', $data);
    }

    public function AllApplicantPaymentConfirmedCasesForNotice()
    {
        $service_code = SETTLEMENT_TENANT_ID;
        $dist_code = $this->session->userdata('dist_code');
        $getDistrict = $this->SettlementTenantDcModel->getLocationName($dist_code);
        $location = $getDistrict->result();
        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code, $circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $data['location'] = $circleList;
        $data['dist_code'] = $dist_code;
        $data['getPaymentConfirmationCo'] = $this->SettlementTenantDcModel->getPaymentReceivedApplicant($service_code);
        // $data['next_id'] = $this->db->query("select nextval('settlement_notice_id_seq') as count ")->row()->count;
        $data['next_id'] = $this->db->query("select nextval('settlement_village_wise_notice_id_seq') as count ")->row()->count;

        $data['_view'] = 'settlementView/Dc/Tenant/tenant_notice_list';
        $this->load->view('layouts/main', $data);
    }
    public function AllApplicantPaymentConfirmedCasesForNoticeCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code)
    {
        $service_code = SETTLEMENT_TENANT_ID;
        $dist_code = $this->session->userdata('dist_code');
        $getDistrict = $this->SettlementTenantDcModel->getLocationName($dist_code);
        $location = $getDistrict->result();
        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $data['location'] = $circleList;
        $data['dist_code'] = $dist_code;
        $data['getPaymentConfirmationCo'] = $this->SettlementTenantDcModel->getPaymentReceivedApplicant($service_code);

        $data['_view'] = 'settlementView/Dc/Tenant/tenant_notice_list_cases';
        $this->load->view('layouts/main', $data);
    }

    public function getPaymentReceivedCases()
    {
        $service = $this->input->post('service');
        $by_case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code = $this->input->post('circle');
        $mouza_code = $this->input->post('mouza');
        $lot_no = $this->input->post('lot');
        $village = $this->input->post('vill_id');
        $ru = $this->session->userdata('user_desig_code');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'settlement_basic.submission_date',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if (!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if (!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }

        $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');
        $this->db->where('settlement_beneficiary_excel.id', null, true);
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
        $this->db->where_in('settlement_basic.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM));
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result = $query->result();
            $i = 1;
            if (!empty($cir_code)) {
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if (!empty($village)) {
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if (!empty($by_case_no)) {
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }

            $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');
            $this->db->where('settlement_beneficiary_excel.id', null, true);
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
            $this->db->where_in('settlement_basic.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM));
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach ($result as $rows) {
                $json[] = array(

                    '<input  type="checkbox" class="checkBoxD selectMark" value="' . $rows->c_no . '" id="' . $rows->b_id . '" name="selectMark[]">',

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->d_code, $rows->s_code, $rows->c_code),

                    $this->utilityclass->getVillageName($rows->d_code, $rows->s_code, $rows->c_code, $rows->m_code, $rows->l_no, $rows->v_code),

                    date('d-M-Y', strtotime($rows->s_date)),

                    $rows->c_no . "<br><span style='color:red'>Basundhara:" . $rows->applid . "</span>",

                    // $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success" href="' . base_url() . 'index.php/SettlementTenantDc/getSettlementApApplicationDetails/?case=' . $rows->c_no . '">View Application</a>',
                );

                $i++;
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function getPaymentReceivedCasesNoticeByVillage()
    {
        $service = $this->input->post('service');
        $dist_code = $this->session->userdata('dist_code');

        $ru = $this->session->userdata('user_desig_code');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $this->db->select('sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');
        $this->db->from('settlement_basic sb');
        $this->db->join('settlement_beneficiary_excel xl', 'sb.case_no = xl.case_no', 'left');
        $this->db->where('xl.id', null, true);
        $this->db->where('sb.service_code', $service);
        $this->db->where('sb.dist_code', $dist_code);
        $this->db->where_in('sb.status', array(MB_PAYMENT_RECEIVED, 'VN'));
        $this->db->where_in('sb.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM, MB_CIRCLE_OFFICER));

        $this->db->group_by('sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');

        $this->db->limit($length, $start);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $i = 1;
            $result = $query->result();
            foreach ($result as $rows) {
                $gen_notice = 1;
                $sql = $this->db->query('select * from settlement_village_wise_notice where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ?', array($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code, $service));
                if ($sql->num_rows() > 0) {
                    $gen_notice = 0;
                }

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $gen_notice == 1 ? '<button class="btn btn-danger btn-sm" onclick="generateVillageNotice(\'' . $rows->dist_code . '\',\'' . $rows->subdiv_code . '\',\'' . $rows->cir_code . '\',\'' . $rows->mouza_pargona_code . '\',\'' . $rows->lot_no . '\',\'' . $rows->vill_townprt_code . '\',\'' . $service . '\')">Generate Notice</button>' : '<a href="' . base_url() . 'index.php/SettlementTenantDc/printNotice?loc=' . $rows->dist_code . '_' . $rows->subdiv_code . '_' . $rows->cir_code . '_' . $rows->mouza_pargona_code . '_' . $rows->lot_no . '_' . $rows->vill_townprt_code . '_' . $service . '" type="button" class="btn btn-success btn-sm" target="printVillageNotice">Print Notice</a>',
                    // <a class="btn btn-warning btn-sm mt-1" href="'.base_url().'index.php/SettlementTenantDc/AllApplicantPaymentConfirmedCasesForNoticeCases('.$rows->dist_code.','.$rows->subdiv_code.','.$rows->cir_code.','.$rows->mouza_pargona_code.','.$rows->lot_no.','.$rows->vill_townprt_code.')">View Cases</a>
                    // '
                );

                $i++;
            }

            $this->db->select('sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_beneficiary_excel xl', 'sb.case_no = xl.case_no', 'left');
            $this->db->where('xl.id', null, true);
            $this->db->where('sb.service_code', $service);
            $this->db->where('sb.dist_code', $dist_code);
            $this->db->where_in('sb.status', array(MB_PAYMENT_RECEIVED, 'VN'));
            $this->db->where_in('sb.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM, MB_CIRCLE_OFFICER));

            $this->db->group_by('sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function getPaymentReceivedCasesNoticeCases()
    {
        $service = $this->input->post('service');
        $by_case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code = $this->input->post('circle');
        $mouza_code = $this->input->post('mouza');
        $lot_no = $this->input->post('lot');
        $village = $this->input->post('vill_id');
        $ru = $this->session->userdata('user_desig_code');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'settlement_basic.submission_date',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if (!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if (!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }

        $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');
        $this->db->where('settlement_beneficiary_excel.id', null, true);
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
        $this->db->where_in('settlement_basic.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM));
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result = $query->result();
            $i = 1;
            if (!empty($cir_code)) {
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if (!empty($village)) {
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if (!empty($by_case_no)) {
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }

            $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');
            $this->db->where('settlement_beneficiary_excel.id', null, true);
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
            $this->db->where_in('settlement_basic.pending_officer', array(MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM));
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach ($result as $rows) {
                $json[] = array(

                    '<input  type="checkbox" class="checkBoxD selectMark" value="' . $rows->c_no . '" id="' . $rows->b_id . '" name="selectMark[]">',

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->d_code, $rows->s_code, $rows->c_code),

                    $this->utilityclass->getVillageName($rows->d_code, $rows->s_code, $rows->c_code, $rows->m_code, $rows->l_no, $rows->v_code),

                    date('d-M-Y', strtotime($rows->s_date)),

                    $rows->c_no . "<br><span style='color:red'>Basundhara:" . $rows->applid . "</span>",

                    // $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success" href="' . base_url() . 'index.php/SettlementTenantDc/getSettlementApApplicationDetails/?case=' . $rows->c_no . '">View Application</a>',
                );

                $i++;
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function excelDataInsertion()
    {
        $selectedListDataArray = json_decode($this->input->post('selectedData'));

        // //*****************Converting array to string */
        $stringDataList = "'" . implode("','", $selectedListDataArray) . "'";

        // //******creating unique ID */
        $dist_code = $this->session->userdata('dist_code');

        $sql_id = $this->db->query("SELECT MAX(id) as id FROM settlement_beneficiary_excel");

        if ($sql_id->num_rows() > 0) {
            $excel_id_tem = (int) $sql_id->row()->id + 1;
            $excel_id = SETTLEMENT_TENANT . $dist_code . 'XLS' . $excel_id_tem;
        } else {
            $excel_id_tem = 1;
            $excel_id = SETTLEMENT_TENANT . $dist_code . 'XLS' . $excel_id_tem;
        }

        // $excel_id = $this->UUID4();

        $this->db->trans_begin();

        if (isset($selectedListDataArray)) {
            //*****inserting into settlement_beneficiary_excel if data successfully retrieved */
            foreach ($selectedListDataArray as $dataList) {
                $insertArr = [
                    'exl_id' => $excel_id,
                    'dist_code' => $this->session->userdata('dist_code'),
                    'case_no' => $dataList,
                    'date_created' => date('Y-m-d H:i:s'),
                ];

                // save data in attachment file
                $insertQuery = $this->db->insert('settlement_beneficiary_excel', $insertArr);

                if ($insertQuery != 1) {
                    $this->db->trans_rollback();
                    $data = array(
                        'responseType' => 0,
                        'msg' => "#EXL00333344: Excel not generated. Contact admin !",
                    );
                    echo json_encode($data);
                    return false;
                }

            }

            if ($this->db->trans_status() == true) {
                $this->db->trans_commit();

                //************call method to download excel */
                $this->generateExcel($excel_id);
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'responseType' => 0,
                    'msg' => "#EXL00333344333: No Benficiary data found !",
                );
                echo json_encode($data);
                return false;
            }

        }
    }

    public function generateExcel($exl_id)
    {
        $sql_data = $this->db->query("SELECT case_no FROM settlement_beneficiary_excel WHERE exl_id = ?", array($exl_id));

        if ($sql_data->num_rows() > 0) {
            $casesNew = array();
            $cases = $sql_data->result_array();
            foreach ($cases as $cases) {
                $casesNew[] = $cases['case_no'];
            }
        }

        $clist = "'" . implode("','", $casesNew) . "'";

        //******getting data from settlement_tenent_beneficiary */
        $sql = $this->db->query("SELECT
                                    case_no,
                                    owner_name,
                                    owner_father,
                                    CASE owner_living_status
                                        WHEN 'YES' THEN 'ALIVE'
                                        WHEN 'NO' THEN 'DEAD'
                                        WHEN 'UNT' THEN 'UNTRACEABLE'
                                        WHEN 'CCA' THEN 'Could not capture account details'
                                    END as livings_status,
                                    bene_name as beneficiary_name,
                                    bene_guardian as beneficiary_guardian_name,
                                    bene_dob as beneficiary_dob,
                                    bene_relation as beneficiary_relation,
                                    bene_gender as beneficiary_gender,
                                    bene_mobile as beneficiary_mobile,
                                    bene_present_address as beneficiary_present_address,
                                    bene_permanent_address as beneficiary_permanenet_address,
                                    bene_pan_no as beneficiary_pan_no,
                                    bene_bank_name as beneficiary_bank_name,
                                    bene_account_no as beneficiary_account_no,
                                    bene_ifsc as beneficiary_ifsc_code,
                                    bene_percentage as beneficiary_compensation_percentage,
                                    amount as total_due_amount
                                    FROM settlement_tenent_beneficiary
                                    WHERE case_no in ($clist)");

        if ($sql->num_rows() > 0) {
            //*********creating excel report for beneficiaries */
            $bene_data = $sql->result_array();
            $file_name = "BENEFICIARY_DATA_" . time() . '.xls';

            $this->UtilsModel->downloadExcelReport($file_name, $bene_data);

            // $temp_file = tempnam(sys_get_temp_dir(), $file_name);
            // $fh = fopen($temp_file, 'w');

            // fputcsv($fh, array('SN.', 'CASE NO','OWNER NAME','FATHERS NAME','OWNER LIVING STATUS', 'BENEFICIARY NAME','BENEFICIARY GUARDIAN NAME','BENEFICIARY DOB','BENEFICIARY RELATION WITH OWNER','BENEFICIARY GENDER','BENEFICIARY MOBILE','BENEFICIARY PRESENT ADDRESS','BENEFICIARY PERMENT ADDRESS','BENEFICIARY PAN NO','BENEFICIARY BANK NAME','BENEFICIARY ACCOUNT NO','BENEFICIARY IFSC','BENEFICIARY PERCENTAGE','TOTAL AMOUNT'));

            // $sl_no = 1;
            // foreach($bene_data as $row)
            // {
            //     fputcsv($fh, array($sl_no++, $row['case_no'], $row['owner_name'], $row['owner_father'], $row['livings_status'], $row['bene_name'], $row['bene_guardian'], $row['bene_dob'], $row['bene_relation'], $row['bene_gender'], $row['bene_mobile'], $row['bene_present_address'], $row['bene_permanent_address'], $row['bene_pan_no'], $row['bene_bank_name'], $row['bene_account_no'], $row['bene_ifsc'], $row['bene_percentage'], $row['amount']));
            // }

            // fclose($fh);
            // // header('Content-Encoding: UTF-8');
            // header('Content-type: text/csv; charset=UTF-8');
            // header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");
            // echo file_get_contents($temp_file);
        }
    }

    public function confirmFinalPayment($excel_id)
    {
        $sql = $this->db->query("SELECT case_no FROM settlement_beneficiary_excel WHERE exl_id = ?", array($excel_id));

        if ($sql->num_rows() > 0) {
            //***************case array */
            $case_no_array = $sql->result();

            $case_list_array = array();
            foreach ($case_no_array as $list) {
                $case_list_array[] = $list->case_no;
            }

            //*******imploding the cases with qoutation and comma */
            $case_no_list = "'" . implode("','", $case_list_array) . "'";

            $update_array = [
                'date_update' => date('Y-m-d'),
                'status' => 'B',
            ];

            $this->db->where_in('case_no', $case_no_list);
            $this->db->update('settlement_basic', $update_array);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN003303: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRPN003303: Payment confirmation updation failed. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        } else {
            //************no data found */
            $json = [
                'responseType' => 0,
                'message' => '#ERRPN0E03: Unable to confirm the payment status! Contact admin...',
            ];
            echo json_encode($json);
            return false;
        }
    }

    public function confirmFinalPaymentIndividual($case_no)
    {

        $update_array = [
            'date_update' => date('Y-m-d'),
            'status' => 'B',
        ];
        $this->db->where_in('case_no', $case_no);
        $this->db->update('settlement_basic', $update_array);
        if ($this->db->affected_rows() == 0) {
            log_message('error', '#ERRPN003303EE: Payment confirmation updation failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN003303EE: Payment confirmation updation failed. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
    }

    public function individualCaseConfirmFinalPayment($excel_id)
    {
        $data['dist_code'] = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $this->session->userdata('cir_code');
        $data['ind_list'] = $this->SettlementTenantModel->getIndividualCases($excel_id);

        $data['_view'] = 'settlementView/Dc/Tenant/individual_case_payment_confirm';
        $this->load->view('layouts/main', $data);
    }

    public function confirmPaymentDc()
    {

        $case_no = $this->input->get('case');
        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
        if ($checkArea != 0) {
            $this->getSettlementApApplicationDetails($case_no);
        }

        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $case_no_rtps = $get_settlement_basic->applid;
        // payment status check thourgh API
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);
        $data = [
            'case_no' => $case_no,
            'payment_status' => $payment_status_check->payment_status,
            'payment_date' => $payment_status_check->payment_date,
            'case_no_rtps' => $case_no_rtps,
            '_view' => 'settlementView/Dc/Tenant/confirmPaymentView',
        ];

        $dist_code = $get_settlement_basic->dist_code;
        $subdiv_code = $get_settlement_basic->subdiv_code;
        $cir_code = $get_settlement_basic->cir_code;
        $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();
        $mouza = $get_settlement_basic->mouza_pargona_code;
        $lot_no = $get_settlement_basic->lot_no;
        $vill = $get_settlement_basic->vill_townprt_code;
        //$patta_type = $alm->patta_type_code;
        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();
        $data['class_code'] = $patta_type_code[0]->new_land_class_code;
        $pattasqll = "SELECT type_code, patta_type FROM patta_code";
        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta'] = 0;
        // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        $data['dag_patta'] = $this->db->query($q)->result();
        $data['dcnote'] = 'Manipulate text';
        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();
        ////////////Settlement Applicant Tenant//////////////
        $sql = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        $sql = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        ///////////////////////////
        $this->load->view('layouts/main', $data);

        if (isset($_POST['payment_confirmed'])) {
            $case_no = $this->input->post('case_no');
            $this->db->trans_begin();
            $updateArr = [
                'status' => 'P',
                'dc_code' => $this->session->userdata('user_code'),
                'user_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'DC',
                'pending_office' => 'DC',
                'dc_proceeding' => 1,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0003: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRPN0003: Payment confirmation updation failed. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'Payment Cofirmed',
                'status' => 'P',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Payment Confirmed',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment status updated to confirmed...");
                redirect(base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $case_no);
            }
        }
    }

    // view all Re-Report by CO application for DC TENANT
    public function getAllReReportAppByCOForDcAppTenant()
    {
        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getReRevertedByCoApplicationTenant($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/re_revert_by_co_list_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view all Reverted by DEPT application for DC TENANT
    public function getAllRevertedAppByDeptForDcAppTenant()
    {

        $dist_code = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getRevertedByDeptApplicationTenant($dist_code);

        $data['dist_code'] = $dist_code;
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/revert_by_dept_list_tenant';
        $this->load->view('layouts/main', $data);
    }

    // Application Request for payment by DC
    public function applicationApprovedByDcTenant()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->caseForDcApprovalTenant($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if ($checkArea != 0) {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $updateData = array(
                    'status' => MB_PAYMENT_REQUEST,
                    'pending_office' => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 1,
                );

                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_PAYMENT_REQUEST,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_CIRCLE_OFFICER,
                        'task' => 'Forwarded To CO For Payment Generate.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                        ));
                        return;
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // Application Forwarded to dept
    public function applicationForwardedToDeptTenant()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $case_no = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->caseForDcApprovalTenant($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $updateData = array(
                    'status' => MB_PENDING,
                    'pending_office' => MB_DEPARTMENT,
                    'pending_officer' => MB_DEPARTMENT,
                    'from_office' => MB_DEPUTY_COMM,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 1,
                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_PENDING,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPARTMENT,
                        'task' => 'Forwarded To Department.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk = 'Forwarded To Department';
                        $status = 'M';
                        $task = MB_DEPUTY_COMM;
                        $pen = MB_DEPARTMENT;
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    // generate General Notice
    public function generateGeneralNotice()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {
                $caseDetails = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetail = $this->SettlementCommonDcModel->getApplicantDetails($case_no);
                $get_dag_details = $this->SettlementTenantDcModel->getDagDetailsTenant($case_no);

                $dist_name = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
                $mouza_name = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
                $village_name = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
                $getKhatian = $this->SettlementTenantDcModel->getKhatianDetailsByCaseNo($case_no);
                $get_owners = $this->SettlementApModel->getOwners($case_no);
                $get_riotee = $this->SettlementTenantModel->getRiotee($case_no);
                $get_buyers = $this->SettlementApModel->getBuyers($case_no);

                $notice_no = "MB2/GN/" . date('Y') . "/SOT/" . $caseDetails->petition_no;

                echo json_encode(array(
                    'responseType' => 2,
                    'case_no' => $case_no,
                    'hearing_date' => date("F j, Y", strtotime($hearing_date)),
                    'caseDetails' => $caseDetails,
                    'applicantName' => $applicantDetail,
                    'dist_name' => $dist_name,
                    'circle_name' => $circle_name,
                    'mouza_name' => $mouza_name,
                    'village_name' => $village_name,
                    'get_dag_details' => $get_dag_details,
                    'notice_no' => $notice_no,
                    'get_owners' => $get_owners,
                    'get_riotee' => $get_riotee,
                    'get_buyers' => $get_buyers,
                    'get_khatian' => $getKhatian,
                ));
                return;
            }
        }
    }

    // save general notice
    public function saveGeneralNoticeTenant()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('htmlstring_text', 'Notice', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $dist_code = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            } else {

                $caseDetails = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetails = $this->SettlementApModel->getAllApplicant($case_no);

                $sqlCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? and service_code = ?', array($case_no, 'GN', $caseDetails->service_code));

                if ($sqlCheck->num_rows() <= 0) {
                    $notice_no = "MB2/GN/" . date('Y') . "/SOT/" . $caseDetails->petition_no;

                    $new_case_no = $this->randomFileNameGeneral();

                    if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_DC, 0777);
                    }

                    $base_64_file_path = GENERAL_NOTICE_PATH_DC . $new_case_no . ".json";
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    foreach ($applicantDetails as $buyers) {
                        $applicant_buyers_json[] = [
                            'APPLICANT_ID' => $buyers->id,
                            'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                            'GUARDIAN_NAME' => $buyers->pdar_guardian,
                        ];
                    }
                    $insertIntoSettlementNotice = [
                        'case_no' => $case_no,
                        'service_code' => $caseDetails->service_code,
                        'case_registration_date' => $caseDetails->submission_date,
                        'applicant_details' => json_encode($applicant_buyers_json),
                        'notice_no' => $notice_no,
                        'notice_link' => $base_64_file_path,
                        'notice_type' => 'GN',
                        'hearing_date' => $hearing_date,
                    ];
                    $this->db->trans_begin();
                    $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
                    if ($insertIntoSettlementNotice != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');

                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                    $updateData = array(
                        'general_notice_dc' => 'y',
                        'notice_generated_yn' => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => $hearing_date,
                        'date_update' => date('Y-m-d H:i:s'),
                    );
                    if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                    ));
                    return;
                } else {
                    $path = $sqlCheck->row()->notice_link;

                    if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_DC, 0777);
                    }

                    $base_64_file_path = $path;
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    foreach ($applicantDetails as $buyers) {
                        $applicant_buyers_json[] = [
                            'APPLICANT_ID' => $buyers->id,
                            'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                            'GUARDIAN_NAME' => $buyers->pdar_guardian,
                        ];
                    }
                    $insertIntoSettlementNotice = [
                        'case_no' => $case_no,
                        'service_code' => $caseDetails->service_code,
                        'case_registration_date' => $caseDetails->submission_date,
                        'applicant_details' => json_encode($applicant_buyers_json),
                        // 'notice_no'              => $notice_no,
                        'notice_link' => $base_64_file_path,
                        'notice_type' => 'GN',
                        'hearing_date' => $hearing_date,
                    ];
                    $this->db->trans_begin();
                    $this->db->where('case_no', $case_no);
                    $this->db->where('notice_type', 'GN');
                    $this->db->where('service_code', $caseDetails->service_code);
                    $this->db->update('settlement_notice', $insertIntoSettlementNotice);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRPN3229: Insertion failed in settlement_notice');

                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                    $updateData = array(
                        'general_notice_dc' => 'y',
                        'notice_generated_yn' => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => $hearing_date,
                        'date_update' => date('Y-m-d H:i:s'),
                    );
                    if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
                    $basundhara = $this->db->query($sql)->row();
                    // call api to upload notice
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'encoded_file' => json_decode($htmlstring_text),
                        'application_no' => $basundhara->basundhara,
                        'type' => 'GN',
                        'amount' => 0,
                        'is_full_pay' => 'N',
                    )));
                    $result = curl_exec($curl_handle);

                    if (trim($result) != 'y') {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    } else {
                        //////////////POST To basundhara/////////////////////
                        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                        $rmk = 'General notice generated';
                        $status = 'M';
                        $task = $this->session->userdata('user_desig_code');
                        $pen = $this->session->userdata('user_desig_code');
                        $case = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status = json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if (trim($rtps_status) != "y") {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                    ));
                    return;
                }

            }
        }
    }

    // view general notice
    public function viewGeneralNoticeTenant()
    {
        $case_no = $this->input->get('case');
        $noticeDetails = $this->SettlementTenantDcModel->getGeneralNoticeDetails($case_no);
        if ($noticeDetails == '' or $noticeDetails == null) {
            echo 'Data not found !';
            return;
        }

        $open_notice_file = fopen($noticeDetails->notice_link, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file, filesize($noticeDetails->notice_link));
        fclose($open_notice_file);
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));

        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
        ];

        $data['_view'] = 'settlementView/Dc/VgrPgr/general_notice_print';

        $this->load->view('layouts/main', $data);
    }

    // get all Beneficiary list
    public function getAllBeneficiaryForDcAppTenant()
    {
        $dist_code = $this->session->userdata('dist_code');
        $serviceCode = SETTLEMENT_TENANT_ID;
        $beneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryListTenant($dist_code, $serviceCode);

        $data['beneficiary'] = $beneficiary->result();
        $data['beneficiaryCount'] = $beneficiary->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/beneficiary_list_tea';
        $this->load->view('layouts/main', $data);
    }

    // view all Beneficiary by case number
    public function getAllBeneficiaryListByCaseNo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->get('case');

        $beneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryIndividualByCaseNo($case_no, $dist_code);

        $data['case_no'] = $case_no;
        $data['beneficiary'] = $beneficiary->result();
        $data['beneficiaryCount'] = $beneficiary->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/beneficiary_list_case_wise_tea';
        $this->load->view('layouts/main', $data);

    }

    // update beneficiary payment status
    public function updateBeneficiaryPaymentStatus()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('payStatus', 'Payment Status', 'trim|required|is_natural');

        if ($this->form_validation->run() == false) {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $case_no = $this->input->post('case_no');
            $payStatus = (int) trim($this->input->post('payStatus'));

            if ($this->SettlementTenantDcModel->countBeneficiaryByCaseNo($case_no, $dist_code) == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            if ($payStatus == 0 or $payStatus == 1) {
                $updateData = array(
                    'payment_status' => $payStatus,
                );
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateBeneficiaryPaymentStatus($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                } else {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'case_no' => $case_no,
                    ));
                    return;
                }

            } else {
                echo json_encode(array(
                    'responseType' => 1,
                    'mm' => 'dd',
                ));
                return;
            }

        }

    }

    // download Beneficiary list by case wise
    public function downloadBeneficiaryList()
    {
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->get('case');

        $allBeneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryIndividualByCaseNo($case_no, $dist_code);

        $allBeneficiary = $allBeneficiary->result();
        $i = 1;
        foreach ($allBeneficiary as $singleB) {

            if ($singleB->payment_status == 1) {
                $status = 'Paid';
            } else {
                $status = 'Pending';
            }

            $beneficiary = array(
                'SL No.' => $i,
                'Case Number' => $singleB->case_no,
                'Name' => $singleB->bene_name,
                'Mobile Number' => $singleB->bene_mobile,

                'Date of Birth' => $singleB->bene_dob,
                'Present Address' => $singleB->bene_present_address,
                'Permanent Address' => $singleB->bene_permanent_address,
                'Beneficiary Percentage' => $singleB->bene_percentage,

                'PAN' => $singleB->bene_pan_no,
                'Account Number' => $singleB->bene_account_no,
                'IFSC Code' => $singleB->bene_ifsc,
                'Bank Name' => $singleB->bene_bank_name,
                'Amount' => $singleB->amount,
                'Payment Status' => $status,
            );

            $printBeneficiary[] = $beneficiary;
            $i = $i + 1;

        }

        $file_name = "case_wise_beneficiary_list_" . time() . '.csv';
        $temp_file = tempnam(sys_get_temp_dir(), $file_name);
        $fh = fopen($temp_file, 'w');
        fputcsv($fh, array_keys($printBeneficiary[0]));
        foreach ($printBeneficiary as $row) {
            fputcsv($fh, $row);
        }

        fclose($fh);
        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Transfer-Encoding: UTF-8');
        header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");
        echo file_get_contents($temp_file);

    }

    // download all beneficiary
    public function downloadAllBeneficiaryWiseDist()
    {
        $dist_code = $this->session->userdata('dist_code');
        $serviceCode = SETTLEMENT_TENANT_ID;

        $allBeneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryForDownload($dist_code, $serviceCode);
        $allBeneficiary = $allBeneficiary->result();

        $i = 1;
        foreach ($allBeneficiary as $singleB) {

            if ($singleB->payment_status == 1) {
                $status = 'Paid';
            } else {
                $status = 'Pending';
            }

            $beneficiary = array(
                'SL No.' => $i,
                'Case Number' => $singleB->case_no,
                'Name' => $singleB->bene_name,
                'Mobile Number' => $singleB->bene_mobile,

                'Date of Birth' => $singleB->bene_dob,
                'Present Address' => $singleB->bene_present_address,
                'Permanent Address' => $singleB->bene_permanent_address,
                'Beneficiary Percentage' => $singleB->bene_percentage,

                'PAN' => $singleB->bene_pan_no,
                'Account Number' => $singleB->bene_account_no,
                'IFSC Code' => $singleB->bene_ifsc,
                'Bank Name' => $singleB->bene_bank_name,
                'Amount' => $singleB->amount,
                'Payment Status' => $status,
            );

            $printBeneficiary[] = $beneficiary;
            $i = $i + 1;

        }

        $file_name = "all_beneficiary_list_" . time() . '.csv';
        $temp_file = tempnam(sys_get_temp_dir(), $file_name);
        $fh = fopen($temp_file, 'w');
        fputcsv($fh, array_keys($printBeneficiary[0]));
        foreach ($printBeneficiary as $row) {
            fputcsv($fh, $row);
        }

        fclose($fh);
        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Transfer-Encoding: UTF-8');
        header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");
        echo file_get_contents($temp_file);

    }

    public function confirmPaymentForwardToCo()
    {
        $selectedListDataArray = json_decode($this->input->post('selectedData'));

        $this->db->trans_begin();

        foreach ($selectedListDataArray as $indCase) {
            $basicUpdateArr = [
                'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                'from_office' => MB_DEPUTY_COMM,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'pending_office' => MB_CIRCLE_OFFICER,
                'date_update' => date('Y-m-d'),
            ];

            $this->db->where('case_no', $indCase);
            $this->db->update('settlement_basic', $basicUpdateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->tran_rollback();
                $this->session->set_flashdata('message', "Error #ERR998337: Unable to process! Contact admin... # " . $indCase);
                redirect($_SERVER['HTTP_REFERER']);
                return false;
            }

            $updateBeneTenArr = [
                'payment_status' => '1',
            ];

            $this->db->where('case_no', $indCase);
            $this->db->update('settlement_tenent_beneficiary', $updateBeneTenArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->tran_rollback();
                $this->session->set_flashdata('message', "Error #ERR948337: Unable to process! Contact admin... # " . $indCase);
                redirect($_SERVER['HTTP_REFERER']);
                return false;
            }

            $updateExcelTenArr = [
                'dc_process' => '1',
            ];

            $this->db->where('case_no', $indCase);
            $this->db->update('settlement_beneficiary_excel', $updateExcelTenArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->tran_rollback();
                $this->session->set_flashdata('message', "Error #ERR548337: Unable to process! Contact admin... # " . $indCase);
                redirect($_SERVER['HTTP_REFERER']);
                return false;
            }

            //insert into proceeding
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$indCase' ")->row()->c;

            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insPetProceed = [
                'case_no' => $indCase,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'note_on_order' => 'Forwarded to CO for chitha update',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => MB_DEPUTY_COMM,
                'office_to' => MB_CIRCLE_OFFICER,
                'task' => 'Forwarded to CO for chitha update',
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            if ($insertProceeding != 1) {
                $this->db->tran_rollback();
                $this->session->set_flashdata('message', '#ERRORPP34343434: Insertion failed in settlement_proceeding for case no :' . $indCase);
                redirect($_SERVER['HTTP_REFERER']);
                return false;
            }
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Cases successfully forwarded to CO...");
        redirect(base_url() . 'index.php/SettlementTenantDc/excelGeneratedCases');

    }

    public function bulkFowardToAdcForHearing()
    {
        $caseArray = $this->input->post('selectMark');
        $remark = $this->input->post('remark');
        $send_adc_to = $this->input->post('send_adc_to');

        if (!$send_adc_to) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4033: Please select ADC!',
            ]);
            return false;
        }

        if (!$caseArray) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3819: No cases selected!',
            ]);
            return false;
        }
        if (!$remark) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3827: No remark given!',
            ]);
            return false;
        }

        foreach ($caseArray as $case_no) {
            $this->db->trans_begin();

            $updateBasicArr = [
                'status' => 'JA',
                'pending_officer' => 'ADC',
                'date_update' => date('Y-m-d H:i:s'),
                'adc_code' => $send_adc_to,
            ];

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateBasicArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3845: Something went wrong! Contact admin...',
                ]);
                return false;
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => $remark,
                'status' => 'N',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'DC',
                'office_to' => 'ADC',
                'task' => 'Forwarded to ADC for hearing',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3881: Something went wrong! Contact admin...',
                ]);
                return false;
            }

            //****post api basundhara */
            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
            $rmk = 'Forwared to ADC for hearing';
            $status = 'M';
            $task = MB_DEPUTY_COMM;
            $pen = MB_ADD_DEPUTY_COMM;
            $case = $case_no;
            $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
            $rtps_status = json_decode($rtps_status);
            if ($rtps_status != "y") {
                $this->db->trans_rollback();

                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR4126: Something went wrong! Contact admin...',
                ]);
                return false;
            } else {
                $this->db->trans_commit();
                echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Successfully forwarded to ADC...',
                ]);
            }

        }

    }

    public function generateVillNotice()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $service = $this->input->post('service');

        $data = [
            'dist_name' => $this->utilityclass->getDistrictName($dist_code),
            'cir_name' => $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code),
            'mouza_name' => $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code),
            'village_name' => $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code),
        ];

        $sql = $this->db->query('select * from settlement_basic where dist_code =? and subdiv_code =? and cir_code =? and mouza_pargona_code =? and lot_no = ? and vill_townprt_code =? and status =? and service_code = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, 'P', $service));

        if ($sql->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR23022024: No case found!',
            ]);
            return false;
        }
        $basicResult = $sql->result();

        foreach ($basicResult as $row) {
            $getOwner = $this->db->query('select * from settlement_applicant where case_no = ? and pdar_type = ?', array($row->case_no, 'O'));
            if ($getOwner->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR36022024: No case found!',
                ]);
                return false;
            }

            $getApplicant = $this->db->query('select * from settlement_applicant where case_no = ? and pdar_type = ? and is_applicant = ?', array($row->case_no, 'B', 1));
            if ($getApplicant->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR39022024: No case found!',
                ]);
                return false;
            }

            $get_missing_rel = $this->db->query('select * from settlement_applicant where case_no = ? and pdar_type in(\'P\',\'GP\',\'GGP\')', array($row->case_no));
            // if ($get_missing_rel->num_rows() <= 0) {
            //     echo json_encode([
            //         'responseType' => 0,
            //         'msg' => '#ERR3902753: No case found!',
            //     ]);
            //     return false;
            // } else {

            // }

            $getRioteeDetails = $this->db->query('select * from settlement_applicant where case_no = ? and pdar_type = ?', array($row->case_no, 'EN'));
            if ($getRioteeDetails->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR89022024: No case found!',
                ]);
                return false;
            }

            $getDagDetails = $this->db->query('select * from settlement_dag_details where case_no = ?', array($row->case_no));
            if ($getDagDetails->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR37022024: No case found!',
                ]);
                return false;
            }

            $getPrem = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($row->case_no, 1));
            if ($getPrem->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR42022024: No case found!',
                ]);
                return false;
            }

            $applicantRow = $getApplicant->row();
            $owner_result = $getOwner->result();
            $rioteeRow = $getRioteeDetails->row();
            $dagRow = $getDagDetails->row();
            $premRow = $getPrem->row();

            $bkl = in_array($row->dist_code, json_decode(BARAK_VALLEY)) ? $this->utilityclass->Total_Bigha_Katha_Lessa2($premRow->total_lessa) : $this->utilityclass->Total_Bigha_Katha_Lessa($premRow->total_lessa);

            $premRow->bkl = in_array($row->dist_code, json_decode(BARAK_VALLEY)) ? 'B:' . $bkl[0] . ' K:' . $bkl[1] . ' C:' . $bkl[2] . ' G:' . $bkl[3] : 'B:' . $bkl[0] . ' K:' . $bkl[1] . ' L:' . $bkl[2];

            $applicantData[] = [
                'application_no' => $this->utilityclass->getApplidFromCaseNo($applicantRow->case_no),
                'case_no' => $applicantRow->case_no,
                'applicantRow' => $applicantRow,
                'rioteeRow' => $rioteeRow,
                'dagRow' => $dagRow,
                'premRow' => $premRow,
            ];
        }

        echo json_encode([
            'responseType' => 2,
            'loc_data' => $data,
            'missing_rel' => $get_missing_rel->result(),
            'owner_result' => $owner_result,
            'tenant_data' => $applicantData,
            'msg' => 'Successfully fetched data...',
        ]);

    }

    public function genVIllNotice()
    {
        $case_array = $this->input->post('case_array');
        $htmlString = json_encode($this->input->post('htmlString'));
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $service = $this->input->post('service');
        $hearing_date = $this->input->post('hearing_date');

        if (is_dir(TENANT_VILLAGE_NOTICE) === false) {
            mkdir(TENANT_VILLAGE_NOTICE, 0777);
        }
        $base_64_file_path = TENANT_VILLAGE_NOTICE . '/' . SETTLEMENT_TENANT . $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code . $service . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        fwrite($file_to_write_base64, $htmlString);
        fclose($file_to_write_base64);

        if (!file_exists($base_64_file_path)) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR28022024: Something went wrong! Unable to process',
            ]);
            return false;
        }

        $checkifalreadyInsert = $this->db->query('select * from settlement_village_wise_notice where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code =? and service_code =?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service));
        if ($checkifalreadyInsert->num_rows() > 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4838: Village notice already generated...',
            ]);
            return false;
        }

        $this->db->trans_begin();

        $insAr = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'service_code' => $service,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'case_array_json' => $case_array,
            'notice_link' => $base_64_file_path,
            'hearing_date' => date("Y-m-d", strtotime($hearing_date)),
        ];

        $insert = $this->db->insert('settlement_village_wise_notice', $insAr);

        if ($insert != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4851: Something went wrong! Unable to process',
            ]);
            return false;
        }
        $timestamp = date('mdYhis', time());

        $case_array = json_decode($case_array);
        foreach ($case_array as $case) {
            //check if payment done for the cases...
            $checkPaymentDoneSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and due_amount > paid_amount', array($case, 1));

            if ($checkPaymentDoneSql->num_rows() > 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR4443: Payment not done for this case number!',
                ]);
                return false;
            }

            $sql = $this->db->query('select * from settlement_notice where case_no = ? and notice_type =?', array($case, 'VN'));
            if ($sql->num_rows() > 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR4877: Something went wrong! Unable to process',
                ]);
                return false;
            }
            //****insert into settlement_notice */
            $notice_no = "MB2/VN/" . date('Y') . "/" . SETTLEMENT_TENANT_ID . "/" . $timestamp;

            $insertIntoSettlementNotice = [
                'case_no' => $case,
                'service_code' => $service,
                'notice_no' => $notice_no,
                'notice_link' => $base_64_file_path,
                'notice_type' => 'VN',
                'hearing_date' => date("Y-m-d", strtotime($hearing_date)),
                'date_entry' => date('Y-m-d H:i:s'),
                'user_code' => $this->session->userdata('user_code'),
            ];

            $notice_ins = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
            if ($notice_ins != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR4880: Something went wrong! Unable to process',
                ]);
                return false;
            }

            // update in settlement_basic
            $basic_update_arr = [
                'status' => 'VN',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'from_office' => 'DC',
                'user_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('case_no', $case);
            $this->db->update('settlement_basic', $basic_update_arr);
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO4494: Failed to generate notice. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //****insert into proceeding  */
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => 'Village wise notice generated',
                'note_on_order' => 'Village wise notice generated forwarded to CO',
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'DC',
                'office_to' => 'CO',
                'task' => 'Village wise notice generated and forwarded to CO',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Notice successfully generated...',
        ]);
    }

    public function printNotice()
    {
        $loc = $this->input->get('loc');
        $loc = explode("_", $loc);
        $dist_code = $loc[0];
        $subdiv_code = $loc[1];
        $cir_code = $loc[2];
        $mouza_pargona_code = $loc[3];
        $lot_no = $loc[4];
        $vill_townprt_code = $loc[5];
        $service = $loc[6];

        $sql = $this->db->query('select * from settlement_village_wise_notice where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service));

        $noticeRow = $sql->row();
        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($noticeRow->notice_link);
        if ($path == false) {
            echo 'No data found!';
            return;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file, filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
        ];
        $data['_view'] = 'SettlementView/Co/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

//********************** END TENANT **********************************

}
