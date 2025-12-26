<?php

class SettlementTenantUrbanAdc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Allowed designations
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->model('basundhara/SettlementApiModel');
        $location    = $this->utilityclass->getLocationFromSession();
        $dist_code   = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code    = $location['cir_code'];
        $define_date = define_date;
        $year_no     = year_no;

        $this->append     = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(['form', 'url', 'Language']);
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementTenantDcModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementMb/SettlementTenantUrbanAdcModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('UtilsModel');

        if (HOLD_All_MB2_CASES_STATUS == 1) {
            if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
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

    // New MB2 code by Masud Reza

//********************** COMMON **********************************

    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[]    = 0;
        $appAreaInApplication   = 0;
        $areaCheck              = 0;
        $chithaDagArray         = [];
        $lmProcessArea          = [];
        $allApplicationDagArray = [];
        $appliedDags            = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic                  = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag) {
            $totalAreaInApplication        = 0;
            $totalAreaInLMApplication      = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict  = $dag->dist_code;
            $appSubDiv    = $dag->subdiv_code;
            $appCircle    = $dag->cir_code;
            $appMouza     = $dag->mouza_pargona_code;
            $appLot       = $dag->lot_no;
            $appVillage   = $dag->vill_townprt_code;
            $appDag       = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta     = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta, $application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY))) {
                // chitha
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
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
                            $bighaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
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
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
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

            $chithaDagArray[]         = $chithaDag;
            $lmProcessArea[]          = $allLmProcess;
            $allApplicationDagArray[] = $allApplicationDags;
        }

        $checkAreaDetail = [
            'chithaArea'    => $chithaDagArray,
            'reservedArea'  => $allApplicationDagArray,
            'lmProcessArea' => $lmProcessArea,
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
        ];

        return $checkAreaDetail;

    }

    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck            = 0;
        $appliedDags          = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic                = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        foreach ($dags as $dag) {
            $totalAreaInApplication        = 0;
            $totalAreaInLMApplication      = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict  = $dag->dist_code;
            $appSubDiv    = $dag->subdiv_code;
            $appCircle    = $dag->cir_code;
            $appMouza     = $dag->mouza_pargona_code;
            $appLot       = $dag->lot_no;
            $appVillage   = $dag->vill_townprt_code;
            $appDag       = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta     = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta, $application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY))) {
                // chitha
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
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
                            $bighaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
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
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }
                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
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
        }

        return $areaCheck;

    }

    // random file name
    public function randomFileName()
    {
        $rand        = rand(00000, 99999);
        $dist_code   = $this->session->userdata('dist_code');
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
        $rand        = rand(000000, 999999);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {

            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $updateData = [
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_REVERT,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_CIRCLE_OFFICER,
                        'task'                 => 'Reverted to CO.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Reverted by DC.';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = MB_CIRCLE_OFFICER;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00011: Reverted by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $updateData = [
                    'status'          => MB_DISMISS,
                    'pending_office'  => '',
                    'pending_officer' => '',
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_DISMISS,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => '',
                        'task'                 => 'Rejected by DC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Rejected by DC.';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = null;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00012: Rejected by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $updateData = [
                    'status'          => MB_DISMISS,
                    'pending_office'  => '',
                    'pending_officer' => '',
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    $updatePro = [
                        'status' => PRO_CASE_STATUS_REJECT,
                    ];

                    $this->SettlementTenantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no, $updatePro);

                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_DISMISS,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => '',
                        'task'                 => 'Rejected by SDLAC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Rejected by SDLAC.';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = null;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00013: Rejected by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);

            $sql             = "SELECT * FROM settlement_proposal_cases WHERE case_no = ? ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no     = $this->db->query($sql, [$case_no])->row();
            $proposal_no_int = (int) $proposal_no->proposal_id;

            $caseCount      = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no, $dist_code);
            $caseCountInPro = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);

            if ($caseCount == 0 && $caseCountInPro != 1) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                if ($checkArea != 0) {
                    echo json_encode([
                        'responseType' => 10,
                    ]);
                    return;
                }

                $updateData = [
                    'status'             => MB_PENDING,
                    'pending_office'     => MB_DEPARTMENT,
                    'pending_officer'    => MB_DEPARTMENT,
                    'from_office'        => MB_DEPUTY_COMM,
                    'dc_code'            => $user_code,
                    'sdlac_approval'     => 'Y',
                    'sdlac_date'         => date('Y-m-d h:i:s'),
                    'sdlace_proposal_no' => $proposal_no_int,
                    'dc_proceeding'      => 1,
                ];

                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    $updatePro = [
                        'status' => PRO_CASE_STATUS_APPROVE,
                    ];

                    $this->SettlementTenantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no, $updatePro);

                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_PENDING,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_DEPARTMENT,
                        'task'                 => 'Approved by SDLAC.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Approved by SDLAC.';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = MB_DEPARTMENT;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
        $case_no   = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $caseCount = $this->SettlementTenantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails         = $this->SettlementTenantDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);
            $proceedings         = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                if ($checkArea != 0) {
                    echo json_encode([
                        'responseType' => 10,
                    ]);
                    return;
                }
                $updateData = [
                    'status'          => MB_ORDER_FOR_CHITHA_UPDATE,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_approval'     => 'Y',
                    'dc_proceeding'   => 1,

                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_ORDER_FOR_CHITHA_UPDATE,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_CIRCLE_OFFICER,
                        'task'                 => 'Order for Chitha Updating.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Order for chitha update.';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = MB_CIRCLE_OFFICER;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00014: Order for chitha update failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $currentDate = date('Y-m-d');
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $proposalNo  = $this->input->post('proposalNo');

            if ($currentDate > $hearingDate) {
                echo json_encode([
                    'responseType' => 1,
                ]);
                return;

            }

            $allCases      = $this->SettlementTenantDcModel->getAllAppInReportSendByDcToSdlacTenant($proposalNo);
            $allCasesCount = $allCases->num_rows();

            if ($allCasesCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                echo json_encode([
                    'responseType' => 2,
                    'remarks'      => $remarks,
                    'hearingDate'  => $hearingDate,
                    'caseList'     => $allCases->result(),
                ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $hearingDate     = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code       = $this->session->userdata('dist_code');
            $remarks         = $this->input->post('remarks');
            $proposalNo      = $this->input->post('proposalNo');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));

            if ($htmlstring_text == '') {
                echo json_encode([
                    'responseType' => 1,
                ]);
                return;
            }

            $proposalDetails = $this->SettlementTenantDcModel->getProposalDetailsById($proposalNo, $dist_code);
            if ($proposalDetails == '') {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $allCases      = $this->SettlementTenantDcModel->getAllAppInReportSendByDcToSdlacTenant($proposalNo);
                $allCasesCount = $allCases->num_rows();
                if ($allCasesCount == 0) {
                    echo json_encode([
                        'responseType' => 3,
                    ]);
                    return;
                } else {
                    $new_case_no = $this->randomFileName();

                    if (is_dir(SEND_TO_SDLAC_NOTICE_PATH) === false) {
                        mkdir(SEND_TO_SDLAC_NOTICE_PATH, 0777);
                    }

                    $base_64_file_path    = SEND_TO_SDLAC_NOTICE_PATH . $new_case_no . ".json";
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    $allSelectedList = $allCases->result();
                    $oldFileName     = $proposalDetails->file_path;

                    $updateProposalData = [
                        'h_date'    => $hearingDate,
                        'remarks'   => $remarks,
                        'ip'        => $this->input->ip_address(),
                        'file_path' => $base_64_file_path,
                    ];
                    $this->db->trans_begin();
                    if ($this->SettlementTenantDcModel->updateProposalListById($proposalNo, $updateProposalData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                        ]);
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
                                'case_no'              => $case_no,
                                'proceeding_id'        => $proceeding_id,
                                'date_of_hearing'      => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date("Y-m-d h:i:s", strtotime($hearingDate)),
                                'status'               => MB_HEARING_DATE_CHANGED,
                                'user_code'            => $this->session->userdata('user_code'),
                                'date_entry'           => date('Y-m-d h:i:s'),
                                'operation'            => 'E',
                                'note_on_order'        => $remarks,
                                'ip'                   => $this->utilityclass->get_client_ip(),
                                'office_from'          => MB_DEPUTY_COMM,
                                'office_to'            => MB_DEPUTY_COMM,
                                'task'                 => 'Hearing Date Changed',
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if ($insertProceeding != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                                echo json_encode([
                                    'responseType' => 1,
                                ]);
                                return;
                            }

                            //////proceeding end//////

                        }
                        $this->db->trans_commit();
                        echo json_encode([
                            'responseType' => 2,
                        ]);
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
    public function SettlementApFirstLandAdc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementTenantDcModel->countAllPendingSettlementTenant($dist_code);
        $paymentConfirmCount  = $this->SettlementTenantDcModel->paymentConfirmNoticeCount($dist_code);
        $paymentReceivedCount = $this->SettlementTenantDcModel->paymentReceivedCount($dist_code);

        // $reReportByCOCount    = $this->SettlementTenantDcModel->countReRevertedByCoApplicationTenant($dist_code);
        // $approvedListCount    = $this->SettlementTenantDcModel->countAllApproveAppBySdlacTenant($dist_code);
        // $rejectedListCount    = $this->SettlementTenantDcModel->countAllRejectAppByDcTenant($dist_code);
        // $revertedByDepartmentCount = $this->SettlementTenantDcModel->countRevertedByDeptApplicationTenant($dist_code);

        $caseStatusCount           = 0;
        $beneficiaryCount          = 0;
        $reReportByCOCount         = 0;
        $approvedListCount         = 0;
        $rejectedListCount         = 0;
        $revertedByDepartmentCount = 0;

        $data['dist_code']                 = $dist_code;
        $data['firstProceedingCount']      = $firstProceedingCount;
        $data['reReportByCOCount']         = $reReportByCOCount;
        $data['caseStatusCount']           = $caseStatusCount;
        $data['approvedListCount']         = $approvedListCount;
        $data['rejectedListCount']         = $rejectedListCount;
        $data['paymentConfirmCount']       = $paymentConfirmCount;
        $data['revertedByDepartmentCount'] = $revertedByDepartmentCount;
        $data['beneficiaryCount']          = $beneficiaryCount;
        $data['lotCount']                  = $this->SettlementTenantDcModel->lotCount($dist_code);
        $data['genExlReportCount']         = $this->SettlementTenantDcModel->exlReportGenCount($dist_code)->count;
        $data['paymentReceivedCount']      = $paymentReceivedCount;
        //$data['SDLACCommitteeCount']  = $SDLACCommitteeCount;

        $data['_view'] = 'settlementView/Dc/Tenant/first_landing_page_dc_tenant';
        $this->load->view('layouts/main', $data);

    }

    public function applicationRevertFromADCToCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);

            $caseCount = $this->SettlementTenantUrbanAdcModel->countSettlementApplicationDetailsByCaseNov2($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $updateData = [
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantUrbanAdcModel->updateSettlementBasicDatav2($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {

                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_REVERT,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_CIRCLE_OFFICER,
                        'task'                 => 'Reverted to CO.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Reverted by ADC.';
                        $status         = 'M';
                        $task           = 'ADC';
                        $pen            = MB_CIRCLE_OFFICER;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'error'        => 'RTPS API Failed',
                            ]);
                            return;
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    public function generateGeneralNoticeBYADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $dist_code    = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no      = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForADc($case_no);
            $caseCount = $this->SettlementTenantUrbanAdcModel->countSettlementApplicationDetailsByCaseNoADC($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $caseDetails     = $this->SettlementTenantUrbanAdcModel->getSettlementApplicationDetailsByCaseNoAdc($case_no, $dist_code);
                $applicantDetail = $this->SettlementCommonDcModel->getApplicantDetails($case_no);
                $get_dag_details = $this->SettlementTenantUrbanAdcModel->getDagDetailsTenant($case_no);

                $dist_name    = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name  = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
                $mouza_name   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
                $village_name = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
                $getKhatian   = $this->SettlementTenantUrbanAdcModel->getKhatianDetailsByCaseNo($case_no);
                $get_owners   = $this->SettlementApModel->getOwners($case_no);
                $get_riotee   = $this->SettlementTenantModel->getRiotee($case_no);
                $get_buyers   = $this->SettlementApModel->getBuyers($case_no);

                $pattadardetails = $this->db->query("select pdar_name,pdar_father from chitha_pattadar a join chitha_dag_pattadar b on a.pdar_id=b.pdar_id and
                    a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code and a.mouza_pargona_code=b.mouza_pargona_code and a.lot_no=b.lot_no and a.vill_townprt_code=b.vill_townprt_code and a.patta_no=b.patta_no
                    and a.patta_type_code =b.patta_type_code
                    where (b.p_flag is null or b.p_flag='0') and a.dist_code='$caseDetails->dist_code' and a.subdiv_code='$caseDetails->subdiv_code' and a.cir_code='$caseDetails->cir_code' and a.lot_no='$caseDetails->lot_no' and a.vill_townprt_code='$caseDetails->vill_townprt_code' and a.mouza_pargona_code='$caseDetails->mouza_pargona_code' and b.dag_no='$get_dag_details->dag_no' and TRIM(a.patta_no)=trim('$get_dag_details->patta_no') and a.patta_type_code= '$get_dag_details->patta_type_code'")->result();

                $pattadarString = '';

                foreach ($pattadardetails as $detail) {
                    $name   = trim($detail->pdar_name);
                    $father = trim($detail->pdar_father);
                    $pattadarString .= "$name ($father), ";
                }

                // Remove the trailing comma and space
                $pattadarString = rtrim($pattadarString, ', ');

                $notice_no = "MB3/GN/" . date('Y') . "/" . SETTLEMENT_TENANT_URBAN . "/" . $caseDetails->petition_no;

                $notice_to = $this->input->post('notice_to');
                if ($notice_to != null) {
                    $data = [
                        'case_no'   => $case_no,
                        'notice_no' => $notice_no,
                        'notice_to' => $notice_to,
                    ];

                    // Save to DB
                    $this->db->insert('notice_to_additional_names', $data);
                } else {
                    $query = $this->db
                        ->where('case_no', $case_no)
                        ->where('notice_no', $notice_no)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get('notice_to_additional_names');

                    $existing_data = $query->num_rows() > 0 ? $query->row_array() : null;
                    // print_r($existing_data);
                    $notice_to = $existing_data['notice_to'];
                    // die;
                }

                echo json_encode([
                    'responseType'    => 2,
                    'case_no'         => $case_no,
                    'hearing_date'    => date("F j, Y", strtotime($hearing_date)),
                    'caseDetails'     => $caseDetails,
                    'applicantName'   => $applicantDetail,
                    'dist_name'       => $dist_name,
                    'circle_name'     => $circle_name,
                    'mouza_name'      => $mouza_name,
                    'village_name'    => $village_name,
                    'get_dag_details' => $get_dag_details,
                    'notice_no'       => $notice_no,
                    'get_owners'      => $get_owners,
                    'get_riotee'      => $get_riotee,
                    'get_buyers'      => $get_buyers,
                    'get_khatian'     => $getKhatian,
                    'notice_to'       => $notice_to,
                    'pattadarString'  => $pattadarString,
                ]);
                return;
            }
        }
    }
    // view all first Proceeding case list TENANT
    public function viewAllApFirstProceedingDCCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantUrbanAdcModel->getAllHearingPendingCasesForAdc($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/TenantUrban/first_proceeding_case_dc_tenant';
        $this->load->view('layouts/main', $data);

    }

    //  settlement application details TENANT
    public function getSettlementApApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $dist_code             = $this->session->userdata('dist_code');
        $application_no        = $this->input->get('case');
        $basic                 = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants            = $this->SettlementApModel->getAllApplicant($application_no);
        $dags                  = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes               = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings           = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments         = $this->SettlementApModel->getDocuments($application_no);
        $data['basic']         = $basic;
        $data['applicants']    = $applicants;
        $data['dags']          = $dags;
        $data['lmnotes']       = $lmnotes;
        $data['proceedings']   = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query']    = $output->query;
        $data['property'] = $output->property;
        $data['aadhar']   = $output->aadhar;
        $data['nextKin']  = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }
        $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $application_no        = $this->input->get('case');
            $basic                 = $this->SettlementTenantModel->getSettlementBasic($application_no);
            $applicants_buyers     = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
            $applicants_owners     = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);
            $dags                  = $this->SettlementTenantModel->getSettlementDag($application_no);
            $lmnotes               = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
            $proceedings           = $this->SettlementTenantModel->getSettlementProceeding($application_no);
            $dhardocuments         = $this->SettlementTenantModel->getDocuments($application_no);

            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $data['basic']                 = $basic;
            $data['applicants_buyers']     = $applicants_buyers;
            $data['applicants_owners']     = $applicants_owners;
            $data['applicants_encroacher'] = $applicants_encroacher;
            $data['applicants_riotee_nok'] = $applicants_riotee_nok;
            $data['dags']                  = $dags;
            $data['lmnotes']               = $lmnotes;
            $data['proceedings']           = $proceedings;
            $data['dhardocuments']         = $dhardocuments;

            //   calling API for self declaration data

            // $lmdata['pattaNo']=$this->utilityclass->getPattaTypeNo($lmdata['basic']["dist_code"],$lmdata['basic']["subdiv_code"],$lmdata['basic']["cir_code"],$lmdata['basic']["mouza_pargona_code"],$lmdata['basic']["lot_no"],$lmdata['basic']["vill_townprt_code"],$lmdata['dags']["dag_no"]);

            $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
            $basundhara = $this->db->query($sql)->row();
            // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
            $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);
            //var_dump($output);

            $data['document'] = $output->documents;
            $data['query']    = $output->query;
            $data['property'] = $output->property;
            $data['aadhar']   = $output->aadhar;
            $data['nextKin']  = $output->nextKin;
            foreach ($output->selfDeclaration as $selfDec) {
                $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
            }

            $caseDetails         = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            $proceedings         = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            foreach ($lmnotes as $r_remark) {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                foreach ($rejected_list_json as $re_list) {
                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", [$re_list]);

                    if ($sql->row()->remark_head != null) {
                        $data['reject_list_type'] = 'new';
                    } else {
                        $data['reject_list_type'] = 'old';
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
            $case_no   = $this->input->post('case_no');
            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
            if ($checkArea != 0) {
                $this->getSettlementApApplicationDetails($case_no);
            }
            $payment_amount = $this->input->post('payment_amount');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $remark               = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners               = $this->SettlementApModel->getOwners($case_no);
            $get_buyers               = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details          = $this->SettlementApModel->getDags($case_no);
            $data                     = [
                'payment_amount'           => $payment_amount,
                'case_no'                  => $case_no,
                'get_settlement_basic'     => $get_settlement_basic,
                'get_dag_details'          => $get_dag_details,
                'get_owners'               => $get_owners,
                'get_buyers'               => $get_buyers,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark'                   => $remark,
                'pay_notice_date'          => date('Y-m-d'),
            ];
            $this->load->view('SettlementView/Dc/Tenant/paymentNotice', $data);
        } else {
            $case_no   = $this->input->get('case');
            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
            if ($checkArea != 0) {
                $this->getSettlementApApplicationDetails($case_no);
            }

            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['_view'] = 'SettlementView/DC/Tenant/generateNoticeView';
            $this->load->view('layouts/main', $data);

        }
    }

    // save payment notice
    public function savePaymentNotice()
    {
        $case_no = $this->input->post('case_no');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path    = PAYMENT_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount                   = $this->input->post('amount');
        $remark_co                = $this->input->post('remark');
        $get_settlement_basic     = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details          = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $district                 = $this->input->post('district');
        $sub_division             = $this->input->post('sub_division');
        $circle                   = $this->input->post('circle');
        $lot_no                   = $this->input->post('lot_no');
        $mouza                    = $this->input->post('mouza');
        $village                  = $this->input->post('village');
        // $petitioner_name = $this->input->post('petitioner_name');
        // $g_name = $this->input->post('g_name');
        // $dag_name = $this->input->post('dag_name');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');
        // $data = [
        //    'case_no' => $case_no,
        //    'remark' => $remark,
        //    'get_settlement_basic' => $get_settlement_basic,
        //    'get_dag_details' => $get_dag_details,
        //    'get_settlement_applicant' => $get_settlement_applicant,
        // ];

        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

        if ($checkArea != 0) {
            log_message('error', '#ERRPN00678: Applied area cannot exceed total chitha area !');
            $json = [
                'responseType' => 10,
                'message'      => '#ERRPN00678: Applied area cannot exceed total chitha area !',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service      = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details  = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers       = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                'APPLICANT_ID'         => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME'        => $buyers->pdar_guardian,
            ];
        }
        $notice_no                  = "MB2/PN/" . date('Y') . "/" . SETTLEMENT_TENANT_URBAN . "/" . $service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date'    => date('Y-m-d'),
            'total_amount'           => $amount,
            'sdlac_proposal_id'      => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date'    => $service_details->sdlac_date,
            'applicant_details'      => json_encode($applicant_buyers_json),
            //'payment_completed_date'      => date('Y-m-d'),
            'notice_no'              => $notice_no,
            'notice_link'            => $base_64_file_path,
            'notice_type'            => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $json = [
                'responseType' => 3,
                'message'      => '#ERRPN00678: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        $updateArr = [
            'status'             => 'N',
            'dc_code'            => $this->session->userdata('user_code'),
            'user_code'          => $this->session->userdata('user_code'),
            'pay_notice_gen_yn'  => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update'        => date('Y-m-d h:i:s'),
            'from_office'        => 'DC',
            'pending_officer'    => 'DC',
            'pending_office'     => 'DC',
            'co_notice_link'     => $base_64_file_path,
            'dc_proceeding'      => 1,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message'      => '#ERRPN0001: Failed to generate notice. Kindly contact system administrator',
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
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $remark_co,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
            'office_to'            => 'DC',
            'task'                 => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message'      => '#ERRPN0002: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = [
                'error' => "PN0001: Error in submitting. Please try Again",
            ];
            echo json_encode($data);
            return false;
        } else {

            //   API CALL END HERE
            $sql        = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                'encoded_file'   => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type'           => 'PN',
                'amount'         => $amount,
            ]));
            $result = curl_exec($curl_handle);
            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $data = [
                    'error' => "PN0005: Error in submitting. Please try Again",
                ];
                echo json_encode($data);
                return false;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementTenantDc/generatePaymentNotice?case=' . $case_no);
            }
        }
    }

    // get all DC approved list TENANT
    public function getAllApprovedBySDLACListTenant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllApproveAppBySdlacTenant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/approve_list_by_sdlac_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view Approve Application TENANT
    public function viewApprovedAppDetailsTenant()
    {
        $case_no   = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no        = $this->input->get('case');
        $basic                 = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants            = $this->SettlementApModel->getAllApplicant($application_no);
        $dags                  = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes               = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings           = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments         = $this->SettlementApModel->getDocuments($application_no);
        $data['basic']         = $basic;
        $data['applicants']    = $applicants;
        $data['dags']          = $dags;
        $data['lmnotes']       = $lmnotes;
        $data['proceedings']   = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query']    = $output->query;
        $data['property'] = $output->property;
        $data['aadhar']   = $output->aadhar;
        $data['nextKin']  = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails         = $this->SettlementTenantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
            $proceedings         = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tenant/settlement_app_details_only_view_tenant';
            $this->load->view('layouts/main', $data);
        }

    }

    // get all rejected app by dc TENANT
    public function getAllRejectByDcListTenant()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getAllRejectAppByDcTenant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/rejected_list_by_dc_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view Rejected Application TENANT
    public function viewRejectedAppDetailsTenant()
    {
        $case_no   = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no        = $this->input->get('case');
        $basic                 = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants            = $this->SettlementApModel->getAllApplicant($application_no);
        $dags                  = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes               = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings           = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments         = $this->SettlementApModel->getDocuments($application_no);
        $data['basic']         = $basic;
        $data['applicants']    = $applicants;
        $data['dags']          = $dags;
        $data['lmnotes']       = $lmnotes;
        $data['proceedings']   = $proceedings;
        $data['dhardocuments'] = $dhardocuments;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document'] = $output->documents;
        $data['query']    = $output->query;
        $data['property'] = $output->property;
        $data['aadhar']   = $output->aadhar;
        $data['nextKin']  = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTenantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

        if ($caseCount == 0) {
            $this->SettlementApFirstLandDc();
        } else {
            $caseDetails         = $this->SettlementTenantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
            $proceedings         = $this->SettlementTenantDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tenant/settlement_app_details_rejected_only_view_tenant';
            $this->load->view('layouts/main', $data);
        }

    }

    // view all chitha update application TENANT
    public function excelGeneratedCases()
    {
        $service_code = SETTLEMENT_TENANT_URBAN_ID;
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationDc($service_code);

        $sql = $this->db->query("SELECT exl_id, date_created FROM settlement_beneficiary_excel GROUP BY exl_id, date_created");

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
        $service_code                     = SETTLEMENT_TENANT_URBAN_ID;
        $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationDc($service_code);
        $data['_view']                    = 'settlementView/Dc/Tenant/order_chitha_update_list_by_dc_tenant';
        $this->load->view('layouts/main', $data);
    }

    public function confirmPaymentChithaUpdate()
    {
        $service_code = SETTLEMENT_TENANT_URBAN_ID;
        //$data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationDc($service_code);

        $sql = $this->db->query("SELECT * FROM settlement_basic A INNER JOIN settlement_beneficiary_excel B ON A.case_no = B.case_no WHERE A.service_code = ?", [$service_code]);

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
        $case_no_rtps         = $get_settlement_basic->applid;
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);

        $data = [
            'case_no'        => $case_no,
            'payment_status' => $payment_status_check->payment_status,
            'payment_date'   => $payment_status_check->payment_date,
            'case_no_rtps'   => $case_no_rtps,
            '_view'          => 'settlementView/Dc/Tenant/confirmPaymentApplicantView',
        ];
        $this->load->view('layouts/main', $data);

    }

    public function confirmPaymentOwnerDc()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $case_no_rtps         = $get_settlement_basic->applid;
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);

        $data = [
            'case_no'        => $case_no,
            'payment_status' => $payment_status_check->payment_status,
            'payment_date'   => $payment_status_check->payment_date,
            'case_no_rtps'   => $case_no_rtps,
            '_view'          => 'settlementView/Dc/Tenant/confirmPaymentOwnerView',
        ];
        $this->load->view('layouts/main', $data);

    }

    public function confirmPaymentApplicant()
    {
        $case_no = $this->input->post('case_no');

        if (isset($_POST['payment_confirmed'])) {

            $this->db->trans_begin();
            $updateArr = [
                'status'          => 'P',
                'dc_code'         => $this->session->userdata('user_code'),
                'user_code'       => $this->session->userdata('user_code'),
                'date_update'     => date('Y-m-d h:i:s'),
                'from_office'     => 'DC',
                'pending_officer' => 'DC',
                'pending_office'  => 'DC',
                'dc_proceeding'   => 1,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN000333: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRPN000333: Payment confirmation updation failed. Kindly contact system administrator',
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
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => 'Payment Cofirmed',
                'status'               => 'P',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => 'DC',
                'office_to'            => 'DC',
                'task'                 => 'Payment Confirmed from Applicant',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = [
                    'error' => "ERR34234: Error in submitting. Please try Again",
                ];
                return $data;
                exit;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "<span class ='alert-success text-center'>Payment status updated to confirmed...</span>");
                redirect(base_url() . 'index.php/SettlementTenantDc/SettlementApFirstLandDc');
            }

        }

    }

    public function SettlementApFirstLandDc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $hearingAdcCount = $this->SettlementTenantUrbanAdcModel->hearingAdcCount($dist_code);

        $data['dist_code'] = $dist_code;

        $data['hearingAdcCount'] = $hearingAdcCount;

        $rejctedListCount = $this->SettlementCommonDcModel->rejectedCaseList($dist_code, SETTLEMENT_TENANT_URBAN_ID, MB_DEPUTY_COMM);

        $data['rejctedListCount'] = $rejctedListCount;

        //$data['SDLACCommitteeCount']  = $SDLACCommitteeCount;

        $data['_view'] = 'settlementView/Adc/TenantUrban/first_landing_page_dc_tenant';
        $this->load->view('layouts/main', $data);

    }

    public function AllApplicantPaymentConfirmedCases()
    {
        $service_code = SETTLEMENT_TENANT_URBAN_ID;

        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $getDistrict = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location    = $getDistrict->result();
        $circleList  = [];
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code, $circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentReceivedApplicant($service_code);
        $data['_view']                    = 'settlementView/Dc/Tenant/all_applicant_confirmed_payment_cases';
        $this->load->view('layouts/main', $data);
    }

    public function getPaymentReceivedCases()
    {
        $service    = $this->input->post('service');
        $by_case_no = $this->input->post('case_no');
        // $remark_cat  = $this->input->post('remark_cat');

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code    = $this->input->post('circle');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $col = 0;
        $dir = "";
        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = [
            0 => 'settlement_basic.submission_date',
        ];
        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (! empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if (! empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if (! empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }

        $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');

        $this->db->from('settlement_basic');

        $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');

        $this->db->where('settlement_beneficiary_excel.id', null, true);

        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
        $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM]);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {

            $result = $query->result();
            $i      = 1;

            if (! empty($cir_code)) {
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if (! empty($village)) {
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if (! empty($by_case_no)) {
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }

            $this->db->select('settlement_basic.case_no as c_no, settlement_basic.id as b_id, settlement_basic.dist_code as d_code, settlement_basic.subdiv_code as s_code, settlement_basic.cir_code as c_code, settlement_basic.mouza_pargona_code as m_code, settlement_basic.lot_no as l_no, settlement_basic.vill_townprt_code as v_code, settlement_basic.submission_date as s_date, settlement_basic.applid as applid');

            $this->db->from('settlement_basic');
            $this->db->join('settlement_beneficiary_excel', 'settlement_basic.case_no = settlement_beneficiary_excel.case_no', 'left');

            $this->db->where('settlement_beneficiary_excel.id', null, true);

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_RECEIVED);
            $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_DEPUTY_COMM]);
            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach ($result as $rows) {

                // if(strtolower($rows->is_urban) == 'y' || strtolower($rows->falls_und_gmc) == 'yes') { $approved_by = "<span style='color:red'>Department</span>"; }
                // else { $approved_by = "<span style='color:blue'>DC</span>"; }

                $json[] = [

                    '<input  type="checkbox" class="checkBoxD selectMark" value="' . $rows->c_no . '" id="' . $rows->b_id . '" name="selectMark[]">',

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->d_code, $rows->s_code, $rows->c_code),

                    $this->utilityclass->getVillageName($rows->d_code, $rows->s_code, $rows->c_code, $rows->m_code, $rows->l_no, $rows->v_code),

                    date('d-M-Y', strtotime($rows->s_date)),

                    $rows->c_no . "<br><span style='color:red'>Basundhara:" . $rows->applid . "</span>",

                    // $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success" href="' . base_url() . 'index.php/SettlementMbADC/getSettlementKhasApplicationDetails/?case=' . $rows->c_no . '">View Application</a>',
                ];

                $i++;
            }

            $response = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);
        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    private function UUID4()
    {
        $bytes    = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function excelDataInsertion()
    {
        $selectedListDataArray = json_decode($this->input->post('selectedData'));

        // //*****************Converting array to string */
        $stringDataList = "'" . implode("','", $selectedListDataArray) . "'";

        // //******creating unique ID */
        $dist_code = $this->session->userdata('dist_code');

        $sql_id = $this->db->query("SELECT MAX(exl_id) as id FROM settlement_beneficiary_excel");

        if ($sql_id->num_rows() > 0) {
            $excel_id_tem = (int) $sql_id->row()->id + 1;
            $excel_id     = $dist_code . $excel_id_tem;
        } else {
            $excel_id_tem = 1;
            $excel_id     = $dist_code . $excel_id_tem;
        }

        // $excel_id = $this->UUID4();

        $this->db->trans_start();

        if (isset($selectedListDataArray)) {
            //*****inserting into settlement_beneficiary_excel if data successfully retrieved */
            foreach ($selectedListDataArray as $dataList) {
                $insertArr = [
                    'exl_id'       => $excel_id,
                    'dist_code'    => $this->session->userdata('dist_code'),
                    'case_no'      => $dataList,
                    'date_created' => date('Y-m-d H:i:s'),
                ];

                // save data in attachment file
                $insertQuery = $this->db->insert('settlement_beneficiary_excel', $insertArr);

                if ($insertQuery != 1) {
                    $this->db->trans_rollback();
                    $data = [
                        'responseType' => 0,
                        'msg'          => "#EXL00333344: Excel not generated. Contact admin !",
                    ];
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
                $data = [
                    'responseType' => 0,
                    'msg'          => "#EXL00333344333: No Benficiary data found !",
                ];
                echo json_encode($data);
                return false;
            }

        }
    }

    public function generateExcel($exl_id)
    {
        $sql_data = $this->db->query("SELECT case_no FROM settlement_beneficiary_excel WHERE exl_id = ?", [$exl_id]);

        if ($sql_data->num_rows() > 0) {
            $casesNew = [];
            $cases    = $sql_data->result_array();
            foreach ($cases as $cases) {
                $casesNew[] = $cases['case_no'];
            }
        }

        $clist = "'" . implode("','", $casesNew) . "'";

        //******getting data from settlement_tenent_beneficiary */
        $sql = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no in ($clist)");

        // echo $this->db->last_query();
        if ($sql->num_rows() > 0) {
            //*********creating excel report for beneficiaries */
            $bene_data = $sql->result_array();

            $file_name = "BENEFICIARY_DATA_" . time() . '.csv';
            $temp_file = tempnam(sys_get_temp_dir(), $file_name);
            $fh        = fopen($temp_file, 'w');

            fputcsv($fh, array_keys($bene_data[0]));
            foreach ($bene_data as $row) {
                fputcsv($fh, $row);
            }
            fclose($fh);
            // header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");
            echo file_get_contents($temp_file);
        }
    }

    public function confirmFinalPayment($excel_id)
    {
        $sql = $this->db->query("SELECT case_no FROM settlement_beneficiary_excel WHERE exl_id = ?", [$excel_id]);

        if ($sql->num_rows() > 0) {
            //***************case array */
            $case_no_array = $sql->result();

            $case_list_array = [];
            foreach ($case_no_array as $list) {
                $case_list_array[] = $list->case_no;
            }

            //*******imploding the cases with qoutation and comma */
            $case_no_list = "'" . implode("','", $case_list_array) . "'";

            $update_array = [
                'date_update' => date('Y-m-d'),
                'status'      => 'B',
            ];

            $this->db->where_in('case_no', $case_no_list);
            $this->db->update('settlement_basic', $update_array);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN003303: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRPN003303: Payment confirmation updation failed. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        } else {
            //************no data found */
            $json = [
                'responseType' => 0,
                'message'      => '#ERRPN0E03: Unable to confirm the payment status! Contact admin...',
            ];
            echo json_encode($json);
            return false;
        }
    }

    public function confirmFinalPaymentIndividual($case_no)
    {

        $update_array = [
            'date_update' => date('Y-m-d'),
            'status'      => 'B',
        ];

        $this->db->where_in('case_no', $case_no);
        $this->db->update('settlement_basic', $update_array);

        if ($this->db->affected_rows() == 0) {
            log_message('error', '#ERRPN003303EE: Payment confirmation updation failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message'      => '#ERRPN003303EE: Payment confirmation updation failed. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
    }

    public function individualCaseConfirmFinalPayment($excel_id)
    {

        $data['dist_code']   = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code']    = $this->session->userdata('cir_code');

        $data['ind_list'] = $this->SettlementTenantModel->getIndividualCases($excel_id);

        $data['_view'] = 'settlementView/Dc/Tenant/individual_case_payment_confirm';
        $this->load->view('layouts/main', $data);
    }

    public function confirmPaymentDc()
    {

        $case_no   = $this->input->get('case');
        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
        if ($checkArea != 0) {
            $this->getSettlementApApplicationDetails($case_no);
        }

        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $case_no_rtps         = $get_settlement_basic->applid;
        // payment status check thourgh API
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);
        $data                 = [
            'case_no'        => $case_no,
            'payment_status' => $payment_status_check->payment_status,
            'payment_date'   => $payment_status_check->payment_date,
            'case_no_rtps'   => $case_no_rtps,
            '_view'          => 'settlementView/Dc/Tenant/confirmPaymentView',
        ];

        $dist_code   = $get_settlement_basic->dist_code;
        $subdiv_code = $get_settlement_basic->subdiv_code;
        $cir_code    = $get_settlement_basic->cir_code;
        $q           = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();
        $mouza       = $get_settlement_basic->mouza_pargona_code;
        $lot_no      = $get_settlement_basic->lot_no;
        $vill        = $get_settlement_basic->vill_townprt_code;
        //$patta_type = $alm->patta_type_code;
        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();
        $data['class_code'] = $patta_type_code[0]->new_land_class_code;
        $pattasqll          = "SELECT type_code, patta_type FROM patta_code";
        $data['mutpatta']   = $this->db->query($pattasqll)->result();
        $data['newdag']     = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta']   = 0;
        // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        $q                       = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        $data['dag_patta']       = $this->db->query($q)->result();
        $data['dcnote']          = 'Manipulate text';
        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();
        ////////////Settlement Applicant Tenant//////////////
        $sql                    = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        $sql                    = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        ///////////////////////////
        $this->load->view('layouts/main', $data);

        if (isset($_POST['payment_confirmed'])) {
            $case_no = $this->input->post('case_no');
            $this->db->trans_begin();
            $updateArr = [
                'status'          => 'P',
                'dc_code'         => $this->session->userdata('user_code'),
                'user_code'       => $this->session->userdata('user_code'),
                'date_update'     => date('Y-m-d h:i:s'),
                'from_office'     => 'CO',
                'pending_officer' => 'DC',
                'pending_office'  => 'DC',
                'dc_proceeding'   => 1,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0003: Payment confirmation updation failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRPN0003: Payment confirmation updation failed. Kindly contact system administrator',
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
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => 'Payment Cofirmed',
                'status'               => 'P',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => 'CO',
                'office_to'            => 'DC',
                'task'                 => 'Payment Confirmed',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = [
                    'error' => "Error in submitting. Please try Again",
                ];
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
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getReRevertedByCoApplicationTenant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/re_revert_by_co_list_tenant';
        $this->load->view('layouts/main', $data);
    }

    // view all Reverted by DEPT application for DC TENANT
    public function getAllRevertedAppByDeptForDcAppTenant()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTenantDcModel->getRevertedByDeptApplicationTenant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->caseForDcApprovalTenant($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if ($checkArea != 0) {
                    echo json_encode([
                        'responseType' => 10,
                    ]);
                    return;
                }

                $updateData = [
                    'status'          => MB_PAYMENT_REQUEST,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                ];

                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_PAYMENT_REQUEST,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_CIRCLE_OFFICER,
                        'task'                 => 'Forwarded To CO For Payment Generate.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $this->db->trans_commit();
                        echo json_encode([
                            'responseType' => 2,
                        ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->caseForDcApprovalTenant($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $updateData = [
                    'status'          => MB_PENDING,
                    'pending_office'  => MB_DEPARTMENT,
                    'pending_officer' => MB_DEPARTMENT,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    //////proceeding start//////
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insPetProceed = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_PENDING,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_DEPUTY_COMM,
                        'office_to'            => MB_DEPARTMENT,
                        'task'                 => 'Forwarded To Department.',
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if ($insertProceeding != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk            = 'Forwarded To Department';
                        $status         = 'M';
                        $task           = MB_DEPUTY_COMM;
                        $pen            = MB_DEPARTMENT;
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        if ($rtps_status != "y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            echo json_encode([
                                'responseType' => 2,
                            ]);
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $dist_code    = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no      = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $caseDetails     = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetail = $this->SettlementCommonDcModel->getApplicantDetails($case_no);
                $get_dag_details = $this->SettlementTenantDcModel->getDagDetailsTenant($case_no);

                $dist_name    = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name  = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
                $mouza_name   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
                $village_name = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
                $getKhatian   = $this->SettlementTenantDcModel->getKhatianDetailsByCaseNo($case_no);
                $get_owners   = $this->SettlementApModel->getOwners($case_no);
                $get_buyers   = $this->SettlementApModel->getBuyers($case_no);

                $notice_no = "MB2/GN/" . date('Y') . "/" . SETTLEMENT_TENANT_URBAN . "/" . $caseDetails->petition_no;

                echo json_encode([
                    'responseType'    => 2,
                    'case_no'         => $case_no,
                    'hearing_date'    => date("F j, Y", strtotime($hearing_date)),
                    'caseDetails'     => $caseDetails,
                    'applicantName'   => $applicantDetail,
                    'dist_name'       => $dist_name,
                    'circle_name'     => $circle_name,
                    'mouza_name'      => $mouza_name,
                    'village_name'    => $village_name,
                    'get_dag_details' => $get_dag_details,
                    'notice_no'       => $notice_no,
                    'get_owners'      => $get_owners,
                    'get_buyers'      => $get_buyers,
                    'get_khatian'     => $getKhatian,
                ]);
                return;
            }
        }
    }

    public function saveGeneralNoticeTenantAdc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('htmlstring_text', 'Notice', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $dist_code       = $this->session->userdata('dist_code');
            $hearing_date    = $this->input->post('hearingDate');
            $case_no         = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForADc($case_no);
            $caseCount = $this->SettlementTenantUrbanAdcModel->countSettlementApplicationDetailsByCaseNoAdc($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {

                $caseDetails      = $this->SettlementTenantUrbanAdcModel->getSettlementApplicationDetailsByCaseNoAdc($case_no, $dist_code);
                $applicantDetails = $this->SettlementApModel->getAllApplicant($case_no);

                $sqlCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? and service_code = ?', [$case_no, 'GN', $caseDetails->service_code]);

                if ($sqlCheck->num_rows() <= 0) {
                    $notice_no = "MB3/GN/" . date('Y') . "/" . SETTLEMENT_TENANT_URBAN . "/" . $caseDetails->petition_no;

                    $new_case_no = $this->randomFileNameGeneral();

                    if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_DC, 0777);
                    }

                    $base_64_file_path    = GENERAL_NOTICE_PATH_DC . $new_case_no . ".json";
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    foreach ($applicantDetails as $buyers) {
                        $applicant_buyers_json[] = [
                            'APPLICANT_ID'         => $buyers->id,
                            'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                            'GUARDIAN_NAME'        => $buyers->pdar_guardian,
                        ];
                    }
                    $insertIntoSettlementNotice = [
                        'case_no'                => $case_no,
                        'service_code'           => $caseDetails->service_code,
                        'case_registration_date' => $caseDetails->submission_date,
                        'applicant_details'      => json_encode($applicant_buyers_json),
                        'notice_no'              => $notice_no,
                        'notice_link'            => $base_64_file_path,
                        'notice_type'            => 'GN',
                        'hearing_date'           => $hearing_date,
                    ];
                    $this->db->trans_begin();
                    $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
                    if ($insertIntoSettlementNotice != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');

                        echo json_encode([
                            'responseType' => 5,
                        ]);
                        return;
                    }
                    $updateData = [
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                    ];
                    if ($this->SettlementTenantUrbanAdcModel->updateSettlementBasicDataAdc($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    }

                    $this->db->trans_commit();

                    echo json_encode([
                        'responseType' => 2,
                    ]);
                    return;
                } else {
                    $path = $sqlCheck->row()->notice_link;

                    if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_DC, 0777);
                    }

                    $base_64_file_path    = $path;
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    foreach ($applicantDetails as $buyers) {
                        $applicant_buyers_json[] = [
                            'APPLICANT_ID'         => $buyers->id,
                            'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                            'GUARDIAN_NAME'        => $buyers->pdar_guardian,
                        ];
                    }
                    $insertIntoSettlementNotice = [
                        'case_no'                => $case_no,
                        'service_code'           => $caseDetails->service_code,
                        'case_registration_date' => $caseDetails->submission_date,
                        'applicant_details'      => json_encode($applicant_buyers_json),
                        'notice_link'            => $base_64_file_path,
                        'notice_type'            => 'GN',
                        'hearing_date'           => $hearing_date,
                    ];
                    $this->db->trans_begin();
                    $this->db->where('case_no', $case_no);
                    $this->db->where('notice_type', 'GN');
                    $this->db->where('service_code', $caseDetails->service_code);
                    $this->db->update('settlement_notice', $insertIntoSettlementNotice);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRPN3229: Insertion failed in settlement_notice');

                        echo json_encode([
                            'responseType' => 5,
                        ]);
                        return;
                    }
                    $updateData = [
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                    ];
                    if ($this->SettlementTenantUrbanAdcModel->updateSettlementBasicDataAdc($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    }

                    $sql        = "Select basundhara from basundhar_application where dharitree='$case_no' ";
                    $basundhara = $this->db->query($sql)->row();
                    // call api to upload notice
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                        'encoded_file'   => json_decode($htmlstring_text),
                        'application_no' => $basundhara->basundhara,
                        'type'           => 'GN',
                        'amount'         => 0,
                        'is_full_pay'    => 'N',
                    ]));
                    $result = curl_exec($curl_handle);

                    if (trim($result) != 'y') {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                        ]);
                        return;
                    } else {
                        //////////////POST To basundhara/////////////////////
                        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                        $rmk            = 'General notice generated';
                        $status         = 'M';
                        $task           = $this->session->userdata('user_desig_code');
                        $pen            = $this->session->userdata('user_desig_code');
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if (trim($rtps_status) != "y") {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                            ]);
                            return;
                        }
                    }

                    $this->load->model('AddProccedings');

                    $overrides = [
                        'note_on_order' => 'Reschedule of Hearing Date by ADC',
                        'status'        => 'Z',
                        'operation'     => 'E',
                        'office_from'   => 'ADC',
                        'office_to'     => 'ADC',
                        'task'          => 'Reschedule of Hearing Date by ADC',
                        'note_type'     => 'Pending At ADC',
                    ];

                    $insertId = $this->AddProccedings->quickAddSP($case_no, $overrides);

                    $this->db->trans_commit();
                    echo json_encode([
                        'responseType' => 2,
                    ]);
                    return;
                }

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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $dist_code       = $this->session->userdata('dist_code');
            $hearing_date    = $this->input->post('hearingDate');
            $case_no         = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementTenantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            } else {
                $caseDetails      = $this->SettlementTenantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetails = $this->SettlementApModel->getAllApplicant($case_no);
                $notice_no        = "MB2/GN/" . date('Y') . "/" . SETTLEMENT_TENANT_URBAN . "/" . $caseDetails->petition_no;

                $new_case_no = $this->randomFileNameGeneral();

                if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
                    mkdir(GENERAL_NOTICE_PATH_DC, 0777);
                }

                $base_64_file_path    = GENERAL_NOTICE_PATH_DC . $new_case_no . ".json";
                $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                fwrite($file_to_write_base64, $htmlstring_text);
                fclose($file_to_write_base64);

                foreach ($applicantDetails as $buyers) {
                    $applicant_buyers_json[] = [
                        'APPLICANT_ID'         => $buyers->id,
                        'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                        'GUARDIAN_NAME'        => $buyers->pdar_guardian,
                    ];
                }
                $insertIntoSettlementNotice = [
                    'case_no'                => $case_no,
                    'service_code'           => $caseDetails->service_code,
                    'case_registration_date' => $caseDetails->submission_date,
                    'applicant_details'      => json_encode($applicant_buyers_json),
                    'notice_no'              => $notice_no,
                    'notice_link'            => $base_64_file_path,
                    'notice_type'            => 'GN',
                    'hearing_date'           => $hearing_date,
                ];
                $this->db->trans_begin();
                $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
                if ($insertIntoSettlementNotice != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');

                    echo json_encode([
                        'responseType' => 5,
                    ]);
                    return;
                }
                $updateData = [
                    'general_notice_dc' => 'y',
                    // 'dc_proceeding' => 1,
                ];
                if ($this->SettlementTenantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                }

                $this->db->trans_commit();
                echo json_encode([
                    'responseType' => 2,
                ]);
                return;
            }
        }
    }

    // view general notice
    public function viewGeneralNoticeTenant()
    {
        $case_no       = $this->input->get('case');
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
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = SETTLEMENT_TENANT_URBAN_ID;
        $beneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryListTenant($dist_code, $serviceCode);

        $data['beneficiary']      = $beneficiary->result();
        $data['beneficiaryCount'] = $beneficiary->num_rows();

        $data['_view'] = 'settlementView/Dc/Tenant/beneficiary_list_tea';
        $this->load->view('layouts/main', $data);
    }

    // view all Beneficiary by case number
    public function getAllBeneficiaryListByCaseNo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $case_no   = $this->input->get('case');

        $beneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryIndividualByCaseNo($case_no, $dist_code);

        $data['case_no']          = $case_no;
        $data['beneficiary']      = $beneficiary->result();
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
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $case_no   = $this->input->post('case_no');
            $payStatus = (int) trim($this->input->post('payStatus'));

            if ($this->SettlementTenantDcModel->countBeneficiaryByCaseNo($case_no, $dist_code) == 0) {
                echo json_encode([
                    'responseType' => 3,
                ]);
                return;
            }
            if ($payStatus == 0 or $payStatus == 1) {
                $updateData = [
                    'payment_status' => $payStatus,
                ];
                $this->db->trans_begin();
                if ($this->SettlementTenantDcModel->updateBeneficiaryPaymentStatus($case_no, $dist_code, $updateData) == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                    ]);
                    return;
                } else {
                    $this->db->trans_commit();
                    echo json_encode([
                        'responseType' => 2,
                        'case_no'      => $case_no,
                    ]);
                    return;
                }

            } else {
                echo json_encode([
                    'responseType' => 1,
                    'mm'           => 'dd',
                ]);
                return;
            }

        }

    }

    // download Beneficiary list by case wise
    public function downloadBeneficiaryList()
    {
        $dist_code = $this->session->userdata('dist_code');
        $case_no   = $this->input->get('case');

        $allBeneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryIndividualByCaseNo($case_no, $dist_code);

        $allBeneficiary = $allBeneficiary->result();
        $i              = 1;
        foreach ($allBeneficiary as $singleB) {

            if ($singleB->payment_status == 1) {
                $status = 'Paid';
            } else {
                $status = 'Pending';
            }

            $beneficiary = [
                'SL No.'                 => $i,
                'Case Number'            => $singleB->case_no,
                'Name'                   => $singleB->bene_name,
                'Mobile Number'          => $singleB->bene_mobile,

                'Date of Birth'          => $singleB->bene_dob,
                'Present Address'        => $singleB->bene_present_address,
                'Permanent Address'      => $singleB->bene_permanent_address,
                'Beneficiary Percentage' => $singleB->bene_percentage,

                'PAN'                    => $singleB->bene_pan_no,
                'Account Number'         => $singleB->bene_account_no,
                'IFSC Code'              => $singleB->bene_ifsc,
                'Bank Name'              => $singleB->bene_bank_name,
                'Amount'                 => $singleB->amount,
                'Payment Status'         => $status,
            ];

            $printBeneficiary[] = $beneficiary;
            $i                  = $i + 1;

        }

        $file_name = "case_wise_beneficiary_list_" . time() . '.csv';
        $temp_file = tempnam(sys_get_temp_dir(), $file_name);
        $fh        = fopen($temp_file, 'w');
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
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = SETTLEMENT_TENANT_URBAN_ID;

        $allBeneficiary = $this->SettlementTenantDcModel->getAllBeneficiaryForDownload($dist_code, $serviceCode);
        $allBeneficiary = $allBeneficiary->result();

        $i = 1;
        foreach ($allBeneficiary as $singleB) {

            if ($singleB->payment_status == 1) {
                $status = 'Paid';
            } else {
                $status = 'Pending';
            }

            $beneficiary = [
                'SL No.'                 => $i,
                'Case Number'            => $singleB->case_no,
                'Name'                   => $singleB->bene_name,
                'Mobile Number'          => $singleB->bene_mobile,

                'Date of Birth'          => $singleB->bene_dob,
                'Present Address'        => $singleB->bene_present_address,
                'Permanent Address'      => $singleB->bene_permanent_address,
                'Beneficiary Percentage' => $singleB->bene_percentage,

                'PAN'                    => $singleB->bene_pan_no,
                'Account Number'         => $singleB->bene_account_no,
                'IFSC Code'              => $singleB->bene_ifsc,
                'Bank Name'              => $singleB->bene_bank_name,
                'Amount'                 => $singleB->amount,
                'Payment Status'         => $status,
            ];

            $printBeneficiary[] = $beneficiary;
            $i                  = $i + 1;

        }

        $file_name = "all_beneficiary_list_" . time() . '.csv';
        $temp_file = tempnam(sys_get_temp_dir(), $file_name);
        $fh        = fopen($temp_file, 'w');
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

    // public function forwardToDCAfterHearing()
    // {
    //     $case_no        = $this->input->post('case_no');
    //     $hearing_remark = $this->input->post('hearing_remark');

    //     $this->db->trans_begin();

    //     $updateBasicArr = [
    //         'status'          => 'W',
    //         'pending_officer' => 'DC',
    //         'note_action_yn'  => 'y',
    //         'date_update'     => date('Y-m-d H:i:s'),
    //     ];

    //     $this->db->where('case_no', $case_no);
    //     $this->db->update('settlement_basic', $updateBasicArr);

    //     if ($this->db->affected_rows() == 0) {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType' => 0,
    //             'msg'          => '#ERR3384: Something went wrong! Contact admin...',
    //         ]);
    //         return false;
    //     }

    //     //////proceeding start//////
    //     $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
    //     if ($proceeding_id == null) {
    //         $proceeding_id = 1;
    //     }
    //     $insertArr = [
    //         'case_no'              => $case_no,
    //         'proceeding_id'        => $proceeding_id,
    //         'date_of_hearing'      => date('Y-m-d h:i:s'),
    //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
    //         'note_on_order'        => $hearing_remark,
    //         'status'               => 'N',
    //         'user_code'            => $this->session->userdata('user_code'),
    //         'date_entry'           => date('Y-m-d h:i:s'),
    //         'operation'            => 'E',
    //         'ip'                   => $this->utilityclass->get_client_ip(),
    //         'office_from'          => 'ADC',
    //         'office_to'            => 'DC',
    //         'task'                 => 'Forwarded to DC after hearing',
    //     ];
    //     $insertProc = $this->db->insert('settlement_proceeding', $insertArr);

    //     if ($insertProc != 1) {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType' => 0,
    //             'msg'          => '#ERR3881: Something went wrong! Contact admin...',
    //         ]);
    //         return false;
    //     }

    //     //*****post api basundhara */
    //     $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
    //     $rmk            = 'Forwarded to DC';
    //     $status         = 'M';
    //     $task           = MB_ADD_DEPUTY_COMM;
    //     $pen            = MB_DEPUTY_COMM;
    //     $case           = $case_no;
    //     $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
    //     $rtps_status    = json_decode($rtps_status);
    //     if ($rtps_status != "y") {
    //         $this->db->trans_rollback();

    //         echo json_encode([
    //             'responseType' => 0,
    //             'msg'          => '#ERR3436: Something went wrong! Contact admin...',
    //         ]);
    //         return false;
    //     } else {

    //         $this->db->trans_commit();
    //         echo json_encode([
    //             'responseType' => 2,
    //             'msg'          => 'Successfully forwarded to DC...',
    //         ]);
    //     }

    // }

    public function forwardToDCAfterHearing()
    {
        $case_no        = $this->input->post('case_no');
        $hearing_remark = $this->input->post('hearing_remark');

        if (isset($_FILES['signed_notice']) && $_FILES['signed_notice']['error'] == 0) {

            $case_no_underscore              = str_replace('/', '_', $case_no);
            $file                            = $case_no_underscore . $this->UUID4() . '_' . date('YmdHis');
            $ext                             = pathinfo($_FILES['signed_notice']['name'], PATHINFO_EXTENSION);
            $_FILES['signed_notice']['name'] = $file . '.' . $ext;

            $folder = UPLOAD_BASE . 'tenant_signed_notices/'; // define this path (make sure folder exists and writable)

            // Create folder if not exists
            if (! file_exists($folder)) {
                mkdir($folder, 0777, true);
                $path = $folder;
            } else {
                $path = $folder;
            }

            $config = [
                'upload_path'   => $path,
                'allowed_types' => FILE_TYPE, // example: 'pdf|jpg|jpeg|png'
                'max_size'      => MAX_SIZE,  // in KB
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('signed_notice')) {
                $data            = $this->upload->data();
                $insert_noc_data = [
                    'case_no'         => $case_no,
                    'user_code'       => $this->session->userdata('user_code'),
                    'file_name'       => 'Signed Notice BY ADC For Tenant',
                    'fetch_file_name' => $file . $data['file_ext'],
                    'file_type'       => $data['file_type'],
                    'file_path'       => $path . $file . $data['file_ext'],
                    'date_entry'      => date('Y-m-d h:i:s'),
                    'mut_type'        => '01',
                ];
                $this->db->insert('supportive_document', $insert_noc_data);
            } else {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR9431: File upload failed! ' . $this->upload->display_errors('', ''),
                ]);
                return false;
            }
        }

        $this->db->trans_begin();

        $updateBasicArr = [
            'status'          => 'W',
            'pending_officer' => 'DC',
            'note_action_yn'  => 'y',
            'date_update'     => date('Y-m-d H:i:s'),
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateBasicArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR3384: Something went wrong! Contact admin...',
            ]);
            return false;
        }

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $hearing_remark,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => 'DC',
            'task'                 => 'Forwarded to DC after hearing',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);

        // ---- Upload Signed Notice ----

        if ($insertProc != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR3881: Something went wrong! Contact admin...',
            ]);
            return false;
        }

        //*****post api basundhara */
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Forwarded to DC';
        $status         = 'M';
        $task           = MB_ADD_DEPUTY_COMM;
        $pen            = MB_DEPUTY_COMM;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
        $rtps_status    = json_decode($rtps_status);
        if ($rtps_status != "y") {
            $this->db->trans_rollback();

            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR3436: Something went wrong! Contact admin...',
            ]);
            return false;
        } else {

            $this->db->trans_commit();
            echo json_encode([
                'responseType' => 2,
                'msg'          => 'Successfully forwarded to DC...',
            ]);
        }

    }

//********************** END TENANT **********************************

}
