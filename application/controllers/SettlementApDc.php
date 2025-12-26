<?php


class SettlementApDc extends CI_Controller
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
        // $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementApDcModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        if($user_desig_code != MB_DEPUTY_COMM)
        {
            echo json_encode(['error' => 'Unauthorized access']);
            exit;
        }



    }


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
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
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
        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
            $totalAreaInApplication2  = 0;
            $totalAreaInLMApplication = 0;
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
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmitOnlyApCase(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);


            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);

                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;
                    $totalAreaInApplication += $areaInApplication;

                    if($singleApp->new_dag_no == '')
                    {
                        $bighaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $gandaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);

                        $areaInApplication2 = ($bighaApp2 * 6400) + ($kathaApp2 * 320) + ($lessaApp2 * 20) + $gandaApp2;
                        $totalAreaInApplication2 += $areaInApplication2;
                    }
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);

                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;
                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInLMApplication == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInLMApplication + $totalAreaInApplication2)
                {
                    $areaCheck = 1;
                }
            }
            else
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SDO/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;

                    if($singleApp->new_dag_no == '')
                    {
                        $bighaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $areaInApplication2 = ($bighaApp2 * 100) + ($kathaApp2 * 20) + $lessaApp2;

                        $totalAreaInApplication2 += $areaInApplication2;
                    }
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }

                //  if($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication)
                //  {
                //      $areaCheck = 1;
                //  }
                // if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                // {
                //     $areaCheck = 1;
                // }
                // if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                // {
                //     $areaCheck = 1;
                // }

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInLMApplication == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInLMApplication + $totalAreaInApplication2)
                {
                    $areaCheck = 1;
                }
            }
            $chithaDagArray[]         = $chithaDag;
            $lmProcessArea[]          = $allLmProcess;
            $allApplicationDagArray[] = $allApplicationDags;
        }
        $checkAreaDetail = array(
            'chithaArea'    => $chithaDagArray,
            'reservedArea'  => $allApplicationDagArray,
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
            'lmProcessArea' => $lmProcessArea,
        );

        return $checkAreaDetail;
    }


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
            $totalAreaInApplication2  = 0;
            $totalAreaInApplicationNR = 0;
            $totalAreaInLMApplication = 0;
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
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmitOnlyApCase(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);


            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;

                    if($singleApp->new_dag_no == '')
                    {
                        $bighaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $gandaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);

                        $areaInApplication2 = ($bighaApp2 * 6400) + ($kathaApp2 * 320) + ($lessaApp2 * 20) + $gandaApp2;
                        $totalAreaInApplication2 += $areaInApplication2;
                    }
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }


                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;

                            $bighaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_bigha, 0);
                            $kathaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_katha, 0);
                            $lessaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_lessa, 0);
                            $gandaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_ganda, 0);
                            $appAreaInApplication3 = ($bighaAppArea3 * 6400) + ($kathaAppArea3 * 320) + ($lessaAppArea3 * 20) + $gandaAppArea3;

                            $totalAreaInApplicationNR += $appAreaInApplication3;
                        }
                    }
                }

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInLMApplication == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInLMApplication + $totalAreaInApplication2)
                {
                    $areaCheck = 1;
                }
                if($totalAppliedAreaInApplication > $totalAreaInApplicationNR)
                {
                    $areaCheck = 1;
                }
            }
            else
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;

                    if($singleApp->new_dag_no == '')
                    {
                        $bighaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $gandaApp2 = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);

                        $areaInApplication2 = ($bighaApp2 * 6400) + ($kathaApp2 * 320) + ($lessaApp2 * 20) + $gandaApp2;
                        $totalAreaInApplication2 += $areaInApplication2;
                    }
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;

                            $bighaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_bigha, 0);
                            $kathaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_katha, 0);
                            $lessaAppArea3 = $this->UtilsModel->defaultValue($singleAppArea->nr_lessa, 0);
                            $appAreaInApplication3 = ($bighaAppArea3 * 100) + ($kathaAppArea3 * 20) + $lessaAppArea3;

                            $totalAreaInApplicationNR += $appAreaInApplication3;
                        }
                    }
                }

                // if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                // {
                //     $areaCheck = 1;
                // }
                // if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                // {
                //     $areaCheck = 1;
                // }

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInLMApplication == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInLMApplication + $totalAreaInApplication2)
                {
                    $areaCheck = 1;
                }
                if($totalAppliedAreaInApplication > $totalAreaInApplicationNR)
                {
                    // show error mgs
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;
    }



    // modification request check with Session
    public function checkCaseInModificationRequestWithSession($caseNo)
    {
        $modificationRequest = 0;
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->SettlementPullModel->getSettlementBasicDetails($caseNo);
        if($basic->pull_request == 1)
        {
            $service_code = $basic->service_code;
            $pendingWith  = $basic->pending_officer;
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_DEPUTY_COMM)
                {
                    $modificationRequest = 1;
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #MRPULL000111: There is modification request for this case # $caseNo by CO");
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
            else
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRPULL000222: There is modification request for this case # $caseNo by CO");
                redirect(base_url() . "index.php/home");
                return false;
            }
        }

        return $modificationRequest;
    }




    public function getErrorPage()
    {
        return '<h2>'.'Data not Found'. '</h2>';
    }


    // generate Proposal Id
    function generateProposalIdSequenceNo()
    {
        $proposalId = $this->db->query("select nextval('settlement_proposal_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    // random file name
    function randomFileName()
    {
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->SettlementApDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // Revert from dc to co
    public function applicationRevertFromDCToCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 9,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails  = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
                if(trim($caseDetails->pull_request) == 1)
                {
                    echo json_encode([
                        'responseType' => 10,
                    ]);
                    return false;
                }

                $updateData = array(
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                );
                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted to CO.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0001: Reverted to CO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 9,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $updateData = array(
                    'status'          => MB_DISMISS,
                    'pending_office'  => '',
                    'pending_officer' => '',
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_DISMISS,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => '',
                        'task'        => 'Rejected by DC.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Rejected by DC.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen='';
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0002: Rejected by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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
        $this->form_validation->set_rules('proposalId', 'Proposal Number', 'trim|required|is_natural|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $proposal_id = $this->input->post('proposalId');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $updateData = array(
                    'status'          => MB_DISMISS,
                    'pending_office'  => '',
                    'pending_officer' => '',
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    $updatePro = array(
                        'status' => PRO_CASE_STATUS_REJECT,
                    );

                    $mmnn = $this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                    if($mmnn == 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_DISMISS,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => '',
                        'task'        => 'Rejected by SDLAC.',
                        'minutes_proposal_id' => $proposal_id

                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Rejected by SDLAC.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen='';
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0002: Rejected by SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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
        $this->form_validation->set_rules('proposalId', 'Proposal Number', 'trim|required|is_natural|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $proposal_id = $this->input->post('proposalId');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $sql = "SELECT * FROM settlement_proposal_cases WHERE case_no = ? ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;

            $caseCount      = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->SettlementApDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
            $dag = $this->SettlementApDcModel->getSettlementDag($case_no);
            $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);

            if($caseCount == 0 && $caseCountInPro != 1)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if($checkArea != 0)
                {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $this->db->trans_begin();

                if($dag->is_urban == 'Y' || ($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc == YES))
                {
                    $updateData = array(
                        'status'          => MB_PENDING,
                        'pending_office'  => MB_DEPARTMENT,
                        'pending_officer' => MB_DEPARTMENT,
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        'sdlac_approval'  => 'Y',
                        'dc_proceeding'   => 1,
                        'sdlac_date'      => date('Y-m-d h:i:s'),
                        'sdlace_proposal_no' => $proposal_no_int,
                    );

                    if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $updatePro = array(
                            'status' => PRO_CASE_STATUS_APPROVE,
                        );

                        $mmnn = $this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($mmnn == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                        if($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no' => $case_no,
                            'proceeding_id' => $proceeding_id,
                            'date_of_hearing' => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status' => MB_PENDING,
                            'user_code'  => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d h:i:s'),
                            'operation'  => 'E',
                            'note_on_order' => $remarks,
                            'ip' => $this->utilityclass->get_client_ip(),
                            'office_from' => MB_DEPUTY_COMM,
                            'office_to'   => MB_DEPARTMENT,
                            'task'        => 'Approved by SDLAC.',
                            'minutes_proposal_id' => $proposal_id

                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if($insertProceeding != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        else
                        {

                            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                            $rmk='Approved by SDLAC.';
                            $status='M';
                            $task=MB_DEPUTY_COMM;
                            $pen=MB_DEPARTMENT;
                            $case=$case_no;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            //var_dump($rtps_status);
                            if(trim($rtps_status)!="y")
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
                                redirect(base_url() . "index.php/home");
                            }
                            else
                            {
                                $this->db->trans_commit();
                                echo json_encode(array(
                                    'responseType' => 5,
                                ));
                                return;
                            }
                        }

                        //////proceeding end//////
                    }
                }
                if($dag->is_urban == 'N')
                {
                    $updateData = array(
                        'status'          => MB_PAYMENT_REQUEST,
                        'pending_office'  => MB_CIRCLE_OFFICER,
                        'pending_officer' => MB_CIRCLE_OFFICER,
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        'sdlac_approval'  => 'Y',
                        'dc_proceeding'   => 1,
                    );

                    if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $updatePro = array(
                            'status' => PRO_CASE_STATUS_APPROVE,
                        );

                        $mmnn = $this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($mmnn == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                        if($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no' => $case_no,
                            'proceeding_id' => $proceeding_id,
                            'date_of_hearing' => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status' => MB_PENDING,
                            'user_code'  => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d h:i:s'),
                            'operation'  => 'E',
                            'note_on_order' => $remarks,
                            'ip' => $this->utilityclass->get_client_ip(),
                            'office_from' => MB_DEPUTY_COMM,
                            'office_to'   => MB_CIRCLE_OFFICER,
                            'task'        => 'Approved by SDLAC.',
                            'minutes_proposal_id' => $proposal_id

                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if($insertProceeding != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        else
                        {
                            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                            $rmk='Approved by SDLAC.';
                            $status='M';
                            $task=MB_DEPUTY_COMM;
                            $pen=MB_CIRCLE_OFFICER;
                            $case=$case_no;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            //var_dump($rtps_status);
                            if(trim($rtps_status)!="y")
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0004: Approved by SDLAC failed case no # $case_no");
                                redirect(base_url() . "index.php/home");
                            }
                            else
                            {
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
    }


    // view payment received application details
    public function viewPaymentReceivedAppDetailsByDc()
    {
        $case_no   = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        $urban = $this->SettlementApModel->getUrban($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);

        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['reservation']=$reservation;
        $data['basic']=$basic;
        $data['applicants']=$applicants;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['urban']=$urban;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementApDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementApFirstLandDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->SettlementApDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementApDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Ap/payment_received_app_details_ap';
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

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if($checkArea != 0)
                {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $updateData = array(
                    'status'          => MB_ORDER_FOR_CHITHA_UPDATE,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_approval'     => 'Y',
                    'dc_proceeding'   => 1,

                );

                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Order for Chitha Updating.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Order for chitha update.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00014: Order for chitha update failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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
    public function updateProposalHearingDateAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposalNo', 'Hearing Date', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $currentDate = date('Y-m-d');
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $remarks     = $this->input->post('remarks');
            $proposalNo  = $this->input->post('proposalNo');

            if($currentDate > $hearingDate)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;

            }

            $allCases      = $this->SettlementApDcModel->getAllAppInReportSendByDcToSdlacAp($proposalNo);
            $allCasesCount = $allCases->num_rows();

            if($allCasesCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 2,
                    'remarks'      => $remarks,
                    'hearingDate'  => date("F j, Y",strtotime($hearingDate)),
                    'caseList'     => $allCases->result(),
                    'proposalSequenceNo' => $proposalNo,

                ));
                return;
            }
        }
    }


    // final approve the proposal
    public function finalApproveTheProposalByDcAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proposalNo', 'Proposal Number', 'trim|required|is_natural|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'errCode' => '#ERR432343233',
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $proposal_no = trim($this->input->post('proposalNo'));
            $dist_code   = $this->session->userdata('dist_code');
            $proposalDetails = $this->SettlementApDcModel->getProposalDetailsById($proposal_no,$dist_code);

            if($proposalDetails->final_verify_status == 0)
            {
                echo json_encode(array(
                    'responseType' => 6,
                ));
                return;
            }
            if($proposalDetails->final_verify_status == 2)
            {
                echo json_encode(array(
                    'responseType' => 7,
                ));
                return;
            }
            if($proposalDetails->final_verify_status == 1)
            {

                $pendingCase = $this->SettlementApDcModel->getAllAppInReportSendByDcToSdlacAp($proposal_no);
                $cases       = $pendingCase->result();
                $caseCount   = $pendingCase->num_rows();

                if($caseCount == 0)
                {
                    echo json_encode(array(
                        'responseType' => 2,
                    ));
                    return;
                }
                else
                {
                    $this->db->trans_begin();
                    foreach ($cases as $case)
                    {

                        $case_no     = $case->case_no;
                        $user_code   = $this->session->userdata('user_code');
                        $proposal_id = $proposal_no;
                        $proposal_no_int = (int)$proposal_no;
                        $remarks   = 'DC verification done';
                        $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($case_no,$dist_code);
                        $dag       = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
                        $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
                        $basic     = $this->SettlementApModel->getSettlementBasic($case_no);

                        if($caseCount == 0)
                        {
                            echo json_encode(array(
                                'responseType' => 3,
                            ));
                            return;
                        }
                        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                        if($checkArea != 0)
                        {
                            echo json_encode(array(
                                'responseType' => 10,
                            ));
                            return;
                        }

                        if(trim($basic['final_status']) == MB_APPROVED_BY_SDLAC)
                        {
                            if($dag->is_urban == 'Y' || ($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc == YES))
                            {
                                $updateData = array(
                                    'status'          => MB_PENDING,
                                    'pending_office'  => MB_DEPARTMENT,
                                    'pending_officer' => MB_DEPARTMENT,
                                    'from_office'     => MB_DEPUTY_COMM,
                                    'dc_code'         => $user_code,
                                    'sdlac_approval'  => 'Y',
                                    'sdlac_date'      => date('Y-m-d h:i:s'),
                                    'dc_proceeding'   => 1,
                                    'sdlace_proposal_no' => $proposal_no_int,
                                );

                                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error',"PROPOSAL####1111".$this->db->last_query());
                                    echo json_encode(array(
                                        'errCode' => '#ERR4323432',
                                        'responseType' => 1,
                                    ));
                                    return;
                                }
                                else
                                {
                                    $updatePro = array(
                                        'status' => PRO_CASE_STATUS_APPROVE,
                                        'approved_by_dc' => 1,
                                    );

                                    if($this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRUPDT001285 Insertion failed in settlement_proposal_cases!');
                                        echo json_encode(array(
                                            'responseType' => 47,
                                            'msg' => '#ERRUPDT007865: Error encountered ! Contact admin...'
                                        ));
                                        return false;
                                    }

                                    //////proceeding start//////
                                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                    if($proceeding_id==null)
                                    {
                                        $proceeding_id=1;
                                    }
                                    $insPetProceed = [
                                        'case_no' => $case_no,
                                        'proceeding_id' => $proceeding_id,
                                        'date_of_hearing' => date('Y-m-d h:i:s'),
                                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                        'status' => MB_PENDING,
                                        'user_code'  => $this->session->userdata('user_code'),
                                        'date_entry' => date('Y-m-d h:i:s'),
                                        'operation'  => 'E',
                                        'note_on_order' => $remarks,
                                        'ip' => $this->utilityclass->get_client_ip(),
                                        'office_from' => MB_DEPUTY_COMM,
                                        'office_to'   => MB_DEPARTMENT,
                                        'task'        => 'Approved by SDLAC',
                                        'minutes_proposal_id' => $proposal_id
                                    ];
                                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                                    if($insertProceeding != 1)
                                    {
                                        log_message('error',"PROPOSAL####1112".$this->db->last_query());
                                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                        $this->db->trans_rollback();
                                        echo json_encode(array(
                                            'errCode' => '#ERR43233432',
                                            'responseType' => 1,
                                        ));
                                        return;
                                    }
                                    else
                                    {
                                        //////////////POST To basundhara////////////////////
                                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                                        $rmk='Forwarded to Department';
                                        $status='M';
                                        $task = MB_DEPUTY_COMM;
                                        $pen  = MB_DEPARTMENT;
                                        $case=$case_no;
                                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                                        $rtps_status=json_decode($rtps_status);
                                        if(trim($rtps_status)!="y")
                                        {
                                            $this->db->trans_rollback();
                                            $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                                            redirect(base_url() . "index.php/home");
                                        }
                                    }
                                }
                            }
                            if($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc != YES)
                            {
                                $updateData = array(
                                    'status'          => MB_PAYMENT_REQUEST,
                                    'pending_office'  => MB_CIRCLE_OFFICER,
                                    'pending_officer' => MB_CIRCLE_OFFICER,
                                    'from_office'     => MB_DEPUTY_COMM,
                                    'dc_code'         => $user_code,
                                    'sdlac_approval'  => 'Y',
                                    'dc_proceeding'   => 1,
                                    'sdlac_date'      => date('Y-m-d h:i:s'),
                                    'sdlace_proposal_no' => $proposal_no_int,
                                );
                                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                {
                                    log_message('error',"PROPOSAL####1113".$this->db->last_query());
                                    $this->db->trans_rollback();
                                    echo json_encode(array(
                                        'errCode' => '#ERR43432',
                                        'responseType' => 1,
                                    ));
                                    return;
                                }
                                else
                                {
                                    $updatePro = array(
                                        'status' => PRO_CASE_STATUS_APPROVE,
                                        'approved_by_dc' => 1,
                                    );

                                    if($this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRUPDT001285 Insertion failed in settlement_proposal_cases!');
                                        echo json_encode(array(
                                            'responseType' => 47,
                                            'msg' => '#ERRUPDT007865: Error encountered ! Contact admin...'
                                        ));
                                        return false;
                                    }


                                    //////proceeding start//////
                                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                    if($proceeding_id==null)
                                    {
                                        $proceeding_id=1;
                                    }
                                    $insPetProceed = [
                                        'case_no' => $case_no,
                                        'proceeding_id' => $proceeding_id,
                                        'date_of_hearing' => date('Y-m-d h:i:s'),
                                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                        'status' => MB_PENDING,
                                        'user_code'  => $this->session->userdata('user_code'),
                                        'date_entry' => date('Y-m-d h:i:s'),
                                        'operation'  => 'E',
                                        'note_on_order' => $remarks,
                                        'ip' => $this->utilityclass->get_client_ip(),
                                        'office_from' => MB_DEPUTY_COMM,
                                        'office_to'   => MB_CIRCLE_OFFICER,
                                        'task'        => 'Approved by SDLAC',
                                        'minutes_proposal_id' => $proposal_id
                                    ];
                                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                                    if($insertProceeding != 1)
                                    {
                                        log_message('error',"PROPOSAL####1114".$this->db->last_query());
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                        echo json_encode(array(
                                            'errCode' => '#ERR3443432',
                                            'responseType' => 1,
                                        ));
                                        return;
                                    }
                                    else
                                    {
                                        //////////////POST To basundhara////////////////////
                                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                                        $rmk='Forwarded To CO';
                                        $status='M';
                                        $task=MB_DEPUTY_COMM;
                                        $pen =MB_CIRCLE_OFFICER;
                                        $case=$case_no;
                                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                                        $rtps_status=json_decode($rtps_status);
                                        //var_dump($rtps_status);
                                        if(trim($rtps_status)!="y")
                                        {
                                            $this->db->trans_rollback();
                                            $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                                            redirect(base_url() . "index.php/home");
                                        }
                                    }
                                    //////proceeding end//////
                                }
                            }
                        }
                        elseif(trim($basic['final_status']) == MB_DISMISS)
                        {
                            $basic_update_arr = array(
                                'status'          => MB_DISMISS,
                                'pending_office'  => MB_DEPUTY_COMM,
                                'pending_officer' => MB_DEPUTY_COMM,
                                'from_office'     => MB_DEPUTY_COMM,
                                'dc_code'         => $user_code,
                                'dc_proceeding'   => 0,
                            );

                            $this->db->where('case_no', $case_no);
                            $this->db->update('settlement_basic', $basic_update_arr);
                            if($this->db->affected_rows() <= 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRUPDT001145 update failed in settlement_basic!');
                                echo json_encode(array(
                                    'responseType' => 47,
                                    'msg' => '#ERRUPDT001145: Error encountered ! Contact admin...'
                                ));
                                return false;
                            }
                            //*******insert in settlement_proceeding */
                            $getRejectedReasonSql = $this->db->query("SELECT A.reject_code, A.service_code, B.remark FROM rejected_remark A 
                            INNER JOIN reject_master B ON CAST(A.reject_code AS int) = B.reject_code
                            WHERE A.case_no = ?", array($case_no));

                            if($getRejectedReasonSql->num_rows() > 0)
                            {
                                $rejReasonArr    = $getRejectedReasonSql->result();
                                $rejectCodeArray = array();
                                $rejReasonArr1   = array();
                                foreach($rejReasonArr as $rejRe)
                                {
                                    $rejectCodeArray[] = [
                                        'service_code' => $rejRe->service_code,
                                        'id'  => $rejRe->reject_code,
                                        'name' => $rejRe->remark
                                    ];
                                    $rejReasonArr1[] = $rejRe->remark;
                                }
                                $rejectedReasonList = implode ( ", ", $rejReasonArr1 );
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRUPDT001185 No rejected reason found!');
                                echo json_encode(array(
                                    'responseType' => 47,
                                    'msg' => '#ERRUPDT001185: Error encountered ! Contact admin...'
                                ));
                                return false;
                            }

                            $sql = "select MAX(proceeding_id) as id from settlement_proceeding where
                            case_no=? ";
                            $res = $this->db->query($sql, array($case_no));
                            if ($res->num_rows() > 0) {
                                $proceeding_id = $res->row()->id + 1;
                            } else {
                                $proceeding_id = 1;
                            }
                            $proceeding_array = array(
                                'case_no'              => $case_no,
                                'proceeding_id'        => $proceeding_id,
                                'date_of_hearing'      => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                'status'               => MB_DISMISS,
                                'user_code'            => $this->session->userdata('user_code'),
                                'date_entry'           => date('Y-m-d G:i:s'),
                                'operation'            => 'E',
                                'note_on_order'        => 'Rejected for: '.$rejectedReasonList,
                                'ip'                   => $this->utilityclass->get_client_ip(),
                                'office_from'          => $this->session->userdata('user_desig_code'),
                                'office_to'            => '',
                                'task'                 => 'Rejected by ' . trim($this->session->userdata('user_desig_code')),
                            );

                            $insertProceeSql = $this->db->insert('settlement_proceeding', $proceeding_array);

                            if($insertProceeSql != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRUPDT001285 Insertion failed in settlement_proceeding!');
                                echo json_encode(array(
                                    'responseType' => 47,
                                    'msg' => '#ERRUPDT001285: Error encountered ! Contact admin...'
                                ));
                                return false;
                            }
                            else
                            {
                                $updatePro = array(
                                    'status' => PRO_CASE_STATUS_REJECT,
                                    'approved_by_dc' => 1,
                                );
                                $mmnn = $this->SettlementApDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                                if($mmnn == 0)
                                {
                                    log_message('error', '#ERRUPDT001185 Updation Failed on settlement_proposal_cases !');
                                    $this->db->trans_rollback();
                                    echo json_encode(array(
                                        'errCode' => '#ERR3D443D432',
                                        'responseType' => 1,
                                    ));
                                    return;
                                }
                                else
                                {
                                    ////////////// POST Reject status To basundhara ////////////////////
                                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                                    $rmk    = 'Rejected by DC: '.$rejectedReasonList;
                                    $status = 'R';
                                    $task   = MB_DEPUTY_COMM;
                                    $pen    = MB_DEPUTY_COMM;
                                    $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2nd($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);

                                    if (trim($rtps_status)!="y")
                                    {
                                        //*********API hit unsuccessfull data to be inserted in a table */
                                        $rejected_failed_arr = [
                                            'case_no' => $case_no,
                                            'remarks' => json_encode($rejectCodeArray)
                                        ];

                                        $rejected_failed_insert = $this->db->insert('settlement_failed_api', $rejected_failed_arr);

                                        if($rejected_failed_insert != 1)
                                        {
                                            log_message('error', '#ERREJ0033035: API failed.');
                                            // $json = [
                                            //     'responseType' => 47,
                                            //     'msg' => '#ERREJ0033035: Unable to process',
                                            // ];
                                            // echo json_encode($json);
                                            //return false;
                                        }
                                        log_message('error', '#ERREJ003305: API failed.');
                                        // $json = [
                                        //     'responseType' => 47,
                                        //     'msg' => '#ERREJ003305: Unable to process',
                                        // ];
                                        //echo json_encode($json);
                                        //return false;
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array(
                                'errCode' => '#ERR344343332',
                                'responseType' => 1,
                            ));
                            return;
                        }
                    }

                    //// foreach end
                    $dataUpdate = array(
                        'final_verify_status' => 2,
                        'dept_status' => 1
                    );
                    if($this->SettlementApDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'errCode' => '#ERR3443DD43332',
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                }
            }

            echo json_encode(array(
                'responseType' => 6,
            ));
            return;
        }
    }


    // save new notice and pro
    public function updateHearingDateGenerateNoticeAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposalNo', 'Proposal Details', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $proposalNo  = $this->input->post('proposalNo');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));

            if($htmlstring_text == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            $proposalDetails = $this->SettlementApDcModel->getProposalDetailsById($proposalNo,$dist_code);

            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementApDcModel->getAllAppInReportSendByDcToSdlacAp($proposalNo);
                $allCasesCount = $allCases->num_rows();
                if($allCasesCount == 0)
                {
                    echo json_encode(array(
                        'responseType' => 3,
                    ));
                    return;
                }
                else
                {
                    $new_case_no = $this->randomFileName();
                    if(is_dir(SEND_TO_SDLAC_NOTICE_PATH)===false)
                    {
                        mkdir(SEND_TO_SDLAC_NOTICE_PATH,0777);
                    }

                    $base_64_file_path    = SEND_TO_SDLAC_NOTICE_PATH.$new_case_no.".json";
                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                    fwrite($file_to_write_base64, $htmlstring_text);
                    fclose($file_to_write_base64);

                    $allSelectedList = $allCases->result();
                    $oldFileName     = $proposalDetails->file_path;

                    $updateProposalData = array(
                        'h_date'  => $hearingDate,
                        'remarks' => $remarks,
                        'ip'      => $this->input->ip_address(),
                        'file_path' => $base_64_file_path
                    );

                    $this->db->trans_begin();
                    if($this->SettlementApDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        unlink($oldFileName);

                        foreach ($allSelectedList as $row)
                        {
                            $case_no = $row->case_no;
                            $this->utilityclass->checkUserAuthForCaseForDcWithRollback($case_no);
                            //////proceeding start//////
                            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                            if($proceeding_id==null)
                            {
                                $proceeding_id=1;
                            }

                            $insPetProceed = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'date_of_hearing' => date('Y-m-d h:i:s') ,
                                'next_date_of_hearing' => date("Y-m-d h:i:s", strtotime($hearingDate)),
                                'status' => MB_HEARING_DATE_CHANGED,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'note_on_order' => $remarks,
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => MB_DEPUTY_COMM,
                                'office_to'   => MB_DEPUTY_COMM,
                                'task' => 'Hearing Date Changed'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if($insertProceeding != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                echo json_encode(array(
                                    'responseType' => 1,
                                ));
                                return;
                            }
                            //////proceeding end//////
                        }

                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Hearing Date Changed';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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
    }


//********************** COMMON **********************************








    //********************************************************************
    //********************** START AP **********************************

    // 1st landing page AP
    public function SettlementApFirstLandDc()
    {

        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementApDcModel->countAllPendingSettlementAp($dist_code);

        $rejctedListCount = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_AP_TRANSFER_ID, MB_DEPUTY_COMM);

        $revivalListCount = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_AP_TRANSFER_ID, MB_DEPUTY_COMM);
        //  $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        //  $reReportByCOCount    = $this->SettlementApDcModel->countReRevertedByCoApplicationAp($dist_code);
        //  $approvedListCount    = $this->SettlementApDcModel->countAllApproveAppBySdlacAp($dist_code);
        //  $rejectedListCount    = $this->SettlementApDcModel->countAllRejectAppByDcAp($dist_code);
        //  $revertedByDepartmentCount = $this->SettlementApDcModel->countRevertedByDeptApplicationAp($dist_code);
        //  $chithaUpdateOrderCount    = $this->SettlementApDcModel->countAllOrderChithaUpdateAppAp($dist_code);

        $caseStatusCount      = 0;
        $SDLACCommitteeCount  = 0;
        $reReportByCOCount    = 0;
        $approvedListCount    = 0;
        $rejectedListCount    = 0;
        $SDLACNoticeCount     = 0;
        $SDLACReportCount     = 0;
        $SDLACConsideration   = 0;
        $finalVerifyCaseCount = 0;
        $sdlacMemberApproval  = 0;
        $revertedByDepartmentCount = 0;
        $chithaUpdateOrderCount    = 0;


        //  $SDLACNoticeCount   = $this->SettlementApDcModel->countMarkAsSDLACSettlementAp($dist_code);
        //  $SDLACReportCount   = $this->SettlementApDcModel->countAllProposalSendByDcToSdlacAp($dist_code);;
        //  $SDLACConsideration = $this->SettlementApDcModel->countAllUnderConsiderationAppKhas($dist_code);
        //  $finalVerifyCaseCount = $this->SettlementApDcModel->countAllCasesForFinalVerifyAppAp($dist_code);
        //  $sdlacMemberApproval = $this->SettlementApDcModel->countSdlacStatusList($dist_code);

        $data['dist_code']            = $dist_code;
        $data['firstProceedingCount'] = $firstProceedingCount;
        $data['reReportByCOCount']    = $reReportByCOCount;
        $data['caseStatusCount']      = $caseStatusCount;
        $data['approvedListCount']    = $approvedListCount;
        $data['rejectedListCount']    = $rejectedListCount;
        $data['SDLACCommitteeCount']  = $SDLACCommitteeCount;
        $data['SDLACNoticeCount']     = $SDLACNoticeCount;
        $data['SDLACReportCount']     = $SDLACReportCount;
        $data['SDLACConsideration']   = $SDLACConsideration;
        $data['finalVerifyCaseCount'] = $finalVerifyCaseCount;
        $data['revertedByDepartmentCount'] = $revertedByDepartmentCount;
        $data['chithaUpdateOrderCount']    = $chithaUpdateOrderCount;
        $data['sdlacMemberApprovalCount']  = $sdlacMemberApproval;
        $data['rejctedListCount']   = $rejctedListCount;
        $data['revivalListCount']   = $revivalListCount;

        $data['_view'] = 'settlementView/Dc/Ap/first_landing_page_dc_ap';
        $this->load->view('layouts/main', $data);

    }


    // get all proposal for final verify
    public function getAllProposalForFinalVerification()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $allCase = $this->SettlementApDcModel->getAllCasesForFinalVerifyAppAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCase->result();
        $data['pendingCaseCount'] = $allCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/final_verify_list_by_dc_ap';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report KHAS
    public function getAllApplicationInSdlacReportForVerifyAp()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllAppInReportSendByDcToSdlacAp($proposal_no);
        $proposalDetails = $this->SettlementApDcModel->getProposalDetailsById($proposal_no,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;

        $data['_view'] = 'settlementView/Dc/Ap/final_verify_sdlac_case_dc_ap';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list AP
    public function viewAllApFirstProceedingDCCaseList()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllPendingSettlementAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/first_proceeding_case_dc_ap';
        $this->load->view('layouts/main', $data);

    }


    //  settlement application details AP
    public function getSettlementApApplicationDetails()
    {
        $case_no   = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $dist_code = $this->session->userdata('dist_code');
        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        $urban = $this->SettlementApModel->getUrban($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);

        $premium_data = $this->SettlementCommonModel->getPremium($application_no);
        $data['premium_data'] = $premium_data;
        $data['premium'] = $premium_data;


        $apValidationCon = $lmnotes[0]->is_nr_settlement;

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $data['guar_rel'] = $relation_executation->result();
        }

        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['reservation']=$reservation;
        $data['basic']=$basic;
        $data['applicants']=$applicants;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['urban']=$urban;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }
        $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementApFirstLandDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->SettlementApDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementApDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }

            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }

            $data['validation_bypass'] = 0;

            foreach($data['lmnotes'] as $lm_rr)
            {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if($decoded_r){
                    foreach($decoded_r as  $lm_rejected_code)
                    {
                        if(isset($lm_rejected_code->reject_code))
                        {
                            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                        else
                        {
                            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                    }
                }
            }

            $data['reject_list_type'] = '';

            foreach($lmnotes as $r_remark)
            {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if($rejected_list_json)
                {
                    foreach ($rejected_list_json as $re_list) {

                        if(isset($re_list->reject_code))
                        {
                            $r_code = $re_list->reject_code;
                        }
                        else
                        {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if($sql->row()->remark_head != null)
                        {
                            $data['reject_list_type'] = 'new';
                        }
                        else
                        {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $checkArea = 0;
            $totalLandArea = 0;
            $totalDagAreaLessaValidation = 0;
            $totalAdditionalProToLessa = 0;

            // check for only NR Area by DC
            if(trim($apValidationCon) == 'NR')
            {
                $checkArea = 0;
            }
            else
            {
                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );

                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda

                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
                else
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;

                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
            }


            $data['checkAppliedArea'] = $checkArea;

            $data['_view'] = 'settlementView/Dc/Ap/settlement_app_details_ap';
            $this->load->view('layouts/main', $data);
        }
    }


    // get all DC approved list AP
    public function getAllApprovedBySDLACListAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllApproveAppBySdlacAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/approve_list_by_sdlac_ap';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application AP
    public function viewApprovedAppDetailsAp()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        $urban = $this->SettlementApModel->getUrban($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);

        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['reservation']=$reservation;
        $data['basic']=$basic;
        $data['applicants']=$applicants;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['urban']=$urban;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($application_no);

        $caseCount = $this->SettlementApDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementApFirstLandDc();
        }
        else
        {

            $caseDetails = $this->SettlementApDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementApDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['nominee'] = $nominee;
            $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;
            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $data['deleted_dags'] = $deletedData;
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }

            $premium_data = $this->SettlementCommonModel->getPremium($application_no);
            $data['premium_data'] = $premium_data;
            $data['premium'] = $premium_data;


            $data['_view'] = 'settlementView/Dc/Ap/settlement_app_details_only_view_ap';
            $this->load->view('layouts/main', $data);
        }

    }


    // get all rejected app by dc AP
    public function getAllRejectByDcListAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllRejectAppByDcAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/rejected_list_by_dc_ap';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application AP
    public function viewRejectedAppDetailsAp()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        $urban = $this->SettlementApModel->getUrban($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);

        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['reservation']=$reservation;
        $data['basic']=$basic;
        $data['applicants']=$applicants;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['urban']=$urban;
        //   calling API for self declaration data
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }


        $caseCount = $this->SettlementApDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementApFirstLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementApDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementApDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Ap/settlement_app_details_rejected_only_view_ap';
            $this->load->view('layouts/main', $data);
        }

    }


    // view all chitha update application AP
    public function getAllOrderChithaUpdateForDcAppAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllOrderChithaUpdateAppAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/order_chitha_update_list_by_dc_ap';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC AP
    public function getAllReReportAppByCOForDcAppAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getReRevertedByCoApplicationAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/re_revert_by_co_list_ap';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC AP
    public function getAllRevertedAppByDeptForDcAppAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getRevertedByDeptApplicationAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/revert_by_dept_list_ap';
        $this->load->view('layouts/main', $data);
    }


    // Application Approve by DC
    public function applicationApprovedByDcAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->caseForDcApprovalAp($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if($checkArea != 0)
                {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $updateData = array(
                    'status'          => MB_PAYMENT_REQUEST,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                );

                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_PAYMENT_REQUEST,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Forwarded To CO For Payment Generate.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Forwarded To CO For Payment Generate.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0012: Forward to CO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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


    // Application Forwarded to dept
    public function applicationForwardedToDeptAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->caseForDcApprovalAp($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $updateData = array(
                    'status'          => MB_PENDING,
                    'pending_office'  => MB_DEPARTMENT,
                    'pending_officer' => MB_DEPARTMENT,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                );
                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_PENDING,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_DEPARTMENT,
                        'task'        => 'Forwarded To Department.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Forwarded To Department.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPARTMENT;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0013: Forward to Department failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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



    // Application Approve by DC for NR
    public function applicationApprovedByDcNr()
    {

        // echo json_encode(array(
        //     'responseType' => 1,
        // ));
        // return;

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                ));
                return false;
            }
            $caseCount = $this->SettlementApDcModel->caseForDcApprovalAp($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if($checkArea != 0)
                {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                //////proceeding start//////
                $this->db->trans_begin();
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }
                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'status' => MB_PAYMENT_REQUEST,
                    'user_code'  => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation'  => 'E',
                    'note_on_order' => $remarks,
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => MB_DEPUTY_COMM,
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Forwarded To CO For NR Case Settlement Process.'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 99,
                        'message'      => '#MRSP002978 : Unable to update proceeding ! Kindly contact system administrator',
                    ));
                    return;
                }
                ///////////////////////////////
                $status=$this->SettlementMbModel->updateChithaNR($case_no);

                if($status ===true || $status == 1)
                {
                    //basundhara API DC END
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk='Forwarded To CO For NR Case Settlement Process.';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_CIRCLE_OFFICER;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0014: Forward to CO failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                        ));
                        return;
                    }

                }
                else
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 99,
                        'message'      => '#MRCH003017 : Unable to update chitha ! Kindly contact system administrator',
                    ));
                    return;
                }
                //////proceeding end//////
            }
        }
    }




    // new MH & MR 27/09/2022

    // Mark as SDLAC
    /**
     *
     */
    public function markApplicationForSDLAC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 9,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                if($checkArea != 0)
                {
                    echo json_encode(array(
                        'responseType' => 10,
                    ));
                    return;
                }

                $updateData = array(
                    'status'  => MB_MARK_AS_SDLAC,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 1,
                );
                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_MARK_AS_SDLAC,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => 'Recommended for SDLAC',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPUTY_COMM,
                        'task' => 'Recommended for SDLAC.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Recommended for SDLAC.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0015: Recommended for SDLAC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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

    // view all mark as SDLAC AP
    public function viewAllMarkAsSDLACListForDCAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getMarkAsSDLACSettlementAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/mark_as_sdlac_case_dc_ap';
        $this->load->view('layouts/main', $data);

    }

    // Remove from mark as SDLAC
    public function removeMarkApplicationForSDLAC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 9,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $updateData = array(
                    'status'  => MB_PENDING,
                    'dc_code' => $user_code,
                    'dc_proceeding'   => 0,
                );

                $this->db->trans_begin();
                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {

                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
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
                        'note_on_order' => 'Unmarked from SDLAC List',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPUTY_COMM,
                        'task' => 'Unmarked from SDLAC List'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Under SDLAC Consideration';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0016: SDLAC Consideration failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
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

    // get all SDLAC Under consideration AP
    public function getAllUnderConSdlacAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllUnderConSettlementAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/under_consideration_case_dc_ap';
        $this->load->view('layouts/main', $data);
    }


    // send all application to SDLAC
    public function sendAllMarkAppToSDLACByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $hearingDate = $this->input->post('hearingDate');
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $allSelectedList = $this->input->post('selectedList');
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();

            //check if SDLAC/CDLAC Member available
            $getSdlcMember = $this->SettlementCommonModel->checkAvailabilitySdlcMemberDistrictWise($dist_code);
            if($getSdlcMember->num_rows() <= 0 || $getSdlcMember->num_rows() == ''){
                echo json_encode(array(
                    'responseType' => 4,
                    'message'      => 'No SDLAC/CDLAC Member available. Click on Back to menu and 
                                            add SDLAC/CDLAC Member in Step 2 of the list and then process..'
                ));
                return;
            }

            if(!empty($allSelectedList))
            {
                foreach ($allSelectedList as $row)
                {
                    $case_no = $row;
                    $this->utilityclass->checkUserAuthForCaseForDc($case_no);
                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    if($checkArea != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 10,
                            'application' => $case_no
                        ));
                        return;
                    }

                    $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
                    if($caseIdSdlacProposal != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 9,
                            'application' => $case_no
                        ));
                        return;
                    }
                    if($caseCount == 0) {
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                }
                echo json_encode(array(
                    'responseType' => 2,
                    'caseList'     => $allSelectedList,
                    'hearingDate'  => date("F j, Y",strtotime($hearingDate)),
                    'remarks'      => $remarks,
                    'proposalSequenceNo' => $proposalSequenceNo,
                ));

                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }
        }
    }


    // generate proposal notice Ap
    public function generateNoticeSendAllMarkAppToSDLACByDcAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required|is_natural');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $user_code   = $this->session->userdata('user_code');
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $allSelectedList = $this->input->post('selectedList');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $proposal_id     = $this->input->post('proposal_id');

            if($htmlstring_text == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            if(!empty($allSelectedList))
            {
                $new_case_no = $this->randomFileName();
                if(is_dir(SEND_TO_SDLAC_NOTICE_PATH)===false)
                {
                    mkdir(SEND_TO_SDLAC_NOTICE_PATH,0777);
                }

                $base_64_file_path    = SEND_TO_SDLAC_NOTICE_PATH.$new_case_no.".json";
                $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                fwrite($file_to_write_base64, $htmlstring_text);
                fclose($file_to_write_base64);

                // save data into proposal list
                $dataProSave = array(
                    'id'        => $proposal_id,
                    'dist_code' => $dist_code,
                    'user_code' => $user_code,
                    'status'    => 1,
                    'proposal_status' => 1,
                    'h_date'  => $hearingDate,
                    'remarks' => $remarks,
                    'ip' => $this->input->ip_address(),
                    'file_path' => $base_64_file_path

                );

                $this->db->trans_begin();
                if($this->SettlementApDcModel->saveProposalSDLACAp($dataProSave) == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    $proposalId = $proposal_id;

                    foreach ($allSelectedList as $row)
                    {
                        $case_no = $row;
                        $this->utilityclass->checkUserAuthForCaseForDcWithRollback($case_no);
                        $saveCaseList = array(
                            'proposal_id' => $proposalId,
                            'case_no' => $case_no,
                            'status' => 1,
                            'ip' => $this->input->ip_address()
                        );

                        if($this->SettlementApDcModel->saveProposalCaseListSDLACAp($saveCaseList) == 0)
                        {
                            $this->db->trans_rollback();

                            //  $this->SettlementApDcModel->deleteProposalSDLAC($proposalId);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        $updateData = array(
                            'status'          => MB_SEND_TO_SDLAC,
                            'pending_office'  => MB_SDLAC,
                            'pending_officer' => MB_DEPUTY_COMM,
                            'from_office'     => MB_DEPUTY_COMM,
                            'dc_code'         => $user_code,
                            'dc_proceeding'   => 1,
                        );

                        if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        else
                        {

                            //////proceeding start//////
                            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                            if($proceeding_id==null)
                            {
                                $proceeding_id=1;
                            }

                            $insPetProceed = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'date_of_hearing' => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                'status' => MB_SEND_TO_SDLAC,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'note_on_order' => 'Send to SDLAC',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => MB_DEPUTY_COMM,
                                'office_to'   => MB_DEPUTY_COMM,
                                'task' => 'Send to SDLAC.'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if($insertProceeding != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                echo json_encode(array(
                                    'responseType' => 1,
                                ));
                                return;
                            }
                            //////proceeding end//////
                        }

                    }

                    //basundhara API DC END
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk='Send to SDLAC.';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0017: Send to SDLAC failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                        ));
                        return;
                    }
                }
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }
        }
    }


    // get all proposal list for AP
    public function getAllProposalListSdlacAp()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllProposalSendByDcToSdlacAp($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/ap/proposal_list_send_to_sdlac_ap';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report AP
    public function getAllApplicationInReportSendByDcToSdlacAp()
    {
        $proposal_no = $this->input->get('case');

        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementApDcModel->getAllAppInReportSendByDcToSdlacAp($proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Ap/send_to_sdlac_case_dc_ap';
        $this->load->view('layouts/main', $data);

    }


    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOAp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('status', 'Approved Status', 'trim|required|is_natural');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'error' => $error,
            ));
            return;
        }
        else
        {
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $status    = $this->input->post('status');
            $user_code = $this->session->userdata('user_code');

            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementApDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseInSdlacProposal = $this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no);
            if($caseInSdlacProposal != 1)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }

            // Approved by SDLAC
            if($status == PRO_CASE_APPROVED_STATUS)
            {
                $dataUpdate = array(
                    'status' => PRO_CASE_STATUS_REVERTED,

                );

                $this->db->trans_begin();
                if($this->SettlementCommonDcModel->updateSettlementProposalCaseDetailsByCaseNo($case_no,$dataUpdate) == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Update failed in settlement_proposal_cases for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }

                $updateData = array(
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,

                );

                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted to CO.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0001: Reverted to CO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                }
            }

            // Not Approved by SDLAC
            if($status == PRO_CASE_NOT_APPROVED_STATUS)
            {

                $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);

                $this->db->trans_begin();
                $insertIntoDeletedTable = array(
                    'proposal_id' => $deleteCase->proposal_id,
                    'case_no'     => $deleteCase->case_no,
                    'status'      => $deleteCase->status,
                    'ip'          => $deleteCase->ip,
                    'created_at'  => $deleteCase->created_at,
                    'updated_at'  => $deleteCase->updated_at,
                    'co_submit'   => $deleteCase->co_submit,
                );

                $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                if($insertDeleteData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }

                $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if($deleteProCase != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }

                $updateData = array(
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                );

                if($this->SettlementApDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //basundhara API DC END
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted to CO.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP0001: Reverted to CO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                            ));
                            return;
                        }
                    }
                }
            }


            echo json_encode(array(
                'responseType' => 3,
            ));
            return;

        }
    }




    //********************** END AP **********************************












}
