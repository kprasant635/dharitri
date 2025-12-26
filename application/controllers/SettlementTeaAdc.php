<?php



class SettlementTeaAdc extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementTeaDcModel');
        $this->load->model('SettlementMb/SettlementTeaSdoModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementMb/SettlementTeaAdcModel');
        $this->load->model('SettlementMb/SettlementMbADCModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
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


    // checking login user access
    public function checkingLoginUserAccessSingleUser()
    {
        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        if($user_desig_code != MB_ADD_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
    }

    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {
        $this->checkingLoginUserAccessSingleUser();

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
            $totalAreaInApplication = 0;
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

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
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
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
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
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
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
            'lmProcessArea' => $lmProcessArea,
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
        );

        return $checkAreaDetail;

    }


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $this->checkingLoginUserAccessSingleUser();
        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        foreach ($dags as $dag)
        {
            $totalAreaInApplication = 0;
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

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
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
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
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

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
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
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;

    }



    // modification request check with redirect
    public function checkCaseInModificationRequest($caseNo)
    {
        $this->checkingLoginUserAccessSingleUser();
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->SettlementPullModel->getSettlementBasicDetails($caseNo);
        if($basic->pull_request == 1)
        {
            $service_code = $basic->service_code;
            $pendingWith  = $basic->pending_officer;
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_SUB_DIV_COMM)
                {
                    $this->session->set_userdata('message', "There is modification request for this case # $caseNo by CO");
                    redirect(base_url().'index.php/SettlementModification/getAllModificationRequestApplicationByCoForSdo?service='.$service_code);
                    return false;
                }
                elseif($user_desig_code == MB_ADD_DEPUTY_COMM)
                {
                    $this->session->set_userdata('message', "There is modification request for this case # $caseNo by CO");
                    redirect(base_url().'index.php/SettlementModification/getAllModificationRequestApplicationByCoForAdc?service='.$service_code);
                    return false;
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
    }

    // modification request check with Session
    public function checkCaseInModificationRequestWithSession($caseNo)
    {
        $this->checkingLoginUserAccessSingleUser();
        $modificationRequest = 0;
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->SettlementPullModel->getSettlementBasicDetails($caseNo);
        if($basic->pull_request == 1)
        {
            $service_code = $basic->service_code;
            $pendingWith  = $basic->pending_officer;
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_SUB_DIV_COMM)
                {
                    $modificationRequest = 1;
                }
                elseif($user_desig_code == MB_ADD_DEPUTY_COMM)
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


    // random file name
    function randomFileName()
    {
        $this->checkingLoginUserAccessSingleUser();
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->SettlementTeaDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    public function getErrorPage()
    {
        return '<h2>'.'Data not Found'. '</h2>';
    }

    // generate Proposal Id
    function generateProposalIdSequenceNo()
    {
        $this->checkingLoginUserAccessSingleUser();
        $proposalId = $this->db->query("select nextval('settlement_proposal_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    // Revert from adc to co
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
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
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                );
                $this->db->trans_begin();
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id'   => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO'
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
                        $rmk    = 'Reverted by ADC';
                        $status = 'M';
                        $task   = MB_ADD_DEPUTY_COMM;
                        $pen    = MB_CIRCLE_OFFICER;
                        $case   = $case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if($rtps_status!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00011: Reverted by DC failed case no # $case_no");
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


    // Rejected  Application by ADC
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => '',
                        'task'        => 'Rejected by ADC'
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
                        $rmk='Rejected by ADC';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=null;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if($rtps_status!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00012: Rejected by DC failed case no # $case_no");
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
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
            $proposal_id = $this->input->post('proposalId');
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                    $reza = $this->SettlementTeaDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                    if($reza == 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    //////proceeding start//////
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        $pen=null;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if($rtps_status!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAPP00013: Rejected by SDLAC failed case no # $case_no");
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


    // send all application to SDLAC
    public function sendAllMarkAppToSDLACByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('selectedMem[]', 'Case Number', 'required');

        $errorArray = array();
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $this->checkingLoginUserAccessSingleUser();
            $hearingDate = $this->input->post('hearingDate');
            if(MEETING_PROPOSAL_SDLAC_NOTICE_HOLD == 1)
            {
                if(date('Y-m-d H:i:s',strtotime(MEETING_PROPOSAL_SDLAC_NOTICE_DATE)) < date('Y-m-d H:i:s',strtotime($hearingDate)))
                {
                    echo json_encode(array(
                        'responseType' => 4,
                        'response'     => 4,
                        'message'      => 'Maximum Date of processing '.MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW
                    ));
                    return;
                }
            }

            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $allSelectedList = $this->input->post('selectedList');
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();
            $venue = $this->input->post('venue');
            $allSelectedMem  = $this->input->post('selectedMem');

            //check if all cases selected to be approved by either department(urban) or dc(rural)
            if(SELECTED_CASES_APPROVED_BY_DEPT_DC == 1)
            {
                foreach ($allSelectedList as $case_no)
                {
                    $dag       = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
                    $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
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

                    $mm = 0;
                    $nn = 0;
                    if(strtoupper($dag->is_urban) == 'Y' || (strtoupper($dag->is_urban) == 'N' && strtoupper($urbanByLm->falls_und_gmc) == YES))
                    {
                        $mm = 1;
                    }
                    if($dag->is_urban == 'N' && $urbanByLm->falls_und_gmc != YES)
                    {
                        $nn = 1;
                    }
                }
                if($mm == $nn)
                {
                    echo json_encode(array(
                        'responseType' => 4,
                        'message'      => 'Selection of cases must be either all Approved by Department or 
                                                all Approved by DC'
                    ));
                    return;
                }
            }


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
                    $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
                    $caseCount = $this->SettlementTeaAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);

                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    if($checkArea != 0)
                    {
                        $errorArray[] = $case_no;
                        continue;
                    }
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

                if(count($errorArray) > 0)
                {
                    $case_str = '';

                    foreach ($errorArray as $err)
                    {
                        $case_str = $case_str.$err.',';
                    }
                    echo json_encode(array(
                        'responseType' => 10,
                        'application'  => $case_str
                    ));
                    return;
                }

                $dist_name    = $this->UtilsModel->getEngDistrictNameByDistCode($this->session->userdata('dist_code'));
                $subdiv_name  = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'));
                $distEngName  = substr($dist_name->locname_eng, 0, 3);
                $proposalName = $distEngName.'/PROPOSAL/'.date("Y").'/'.$proposalSequenceNo;
                $allSelectedMember = '';
                $index = 0;
                $i = count($allSelectedMem);
                foreach ($allSelectedMem as $member)
                {
                    if ($index == $i - 1)
                    {
                        $allSelectedMember .= "'".$member['name']."'";
                    }
                    else
                    {
                        $allSelectedMember .= "'".$member['name']."'". ",";
                    }
                    $index++;

                }

                $commMembers  = $this->SettlementMbDcModel->getSelectedMembersFromUsers($this->session->userdata('dist_code'),$allSelectedMember);
                if(empty($commMembers))
                {
                    echo json_encode(array(
                        'responseType' => 5,
                    ));
                    return;
                }

                echo json_encode(array(
                    'responseType' => 2,
                    'caseList'     => $allSelectedList,
                    'hearingDate'  => date("F j, Y",strtotime($hearingDate)),
                    'timing'       => date("h:i a",strtotime($hearingDate)),
                    'remarks'      => $remarks,
                    'distName'     => $dist_name->locname_eng,
                    'subDivName'   => $subdiv_name->locname_eng,
                    'commMembers'  => $commMembers,
                    'venue'        => $venue,
                    'proposalSequenceNo' => $proposalSequenceNo,
                    'proposalName'       => strtoupper($proposalName),
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


    // Mark as SDLAC
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
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
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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

                $wedLandStatus = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
                if($wedLandStatus == 1)
                {
                    $updateData = array(
                        'is_wed_land'   => 1,
                        'approve_by'    => 'GOVT',
                        'status'        => MB_MARK_AS_SDLAC,
                        'dc_code'       => $user_code,
                        'dc_proceeding' => 1,
                    );
                }
                else
                {
                    $updateData = array(
                        'status'  => MB_MARK_AS_SDLAC,
                        'dc_code' => $user_code,
                        'dc_proceeding' => 1,
                    );
                }
                $this->db->trans_begin();
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        'office_to' => MB_ADD_DEPUTY_COMM,
                        'task' => 'Recommended for SDLAC'
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
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
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        'office_to' => MB_ADD_DEPUTY_COMM,
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
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
            $sql = "SELECT *
            FROM settlement_proposal_cases
            WHERE case_no = ?
            ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;
            $proposal_id = $this->input->post('proposalId');
            $caseCount      = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->SettlementTeaDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
            $dag = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
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
                        'sdlac_date'      => date('Y-m-d h:i:s'),
                        'dc_proceeding'   => 1,
                        'sdlace_proposal_no' => $proposal_no_int,
                    );

                    if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $reza = $this->SettlementTeaDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($reza == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        //////proceeding start//////
                        $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                        if($proceeding_id == null or $proceeding_id==0)
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
                            //////////////POST To basundhara////////////////////
                            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                            $rmk='Forwarded to Department';
                            $status='M';
                            $task='DC';
                            $pen='DPT';
                            $case=$case_no;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            if($rtps_status!="y"){
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                                redirect(base_url() . "index.php/home");
                            }else{
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
                        'sdlac_date'      => date('Y-m-d h:i:s'),
                        'sdlace_proposal_no' => $proposal_no_int,
                    );

                    if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $reza = $this->SettlementTeaDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($reza == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        //////proceeding start//////
                        $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                        if($proceeding_id == null or $proceeding_id==0)
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

                            //////////////POST To basundhara////////////////////
                            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                            $rmk='Approved by SDLAC.';
                            $status='M';
                            $task=MB_DEPUTY_COMM;
                            $pen=MB_CIRCLE_OFFICER;
                            $case=$case_no;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            //var_dump($rtps_status);
                            if($rtps_status!="y"){
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                                redirect(base_url() . "index.php/home");
                            }else{
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
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $caseCount = $this->SettlementTeaDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $this->checkingLoginUserAccessSingleUser();
            $caseDetails = $this->SettlementTeaDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementTeaDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tea/payment_received_app_details_tea';
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $caseCount = $this->SettlementTeaDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        if($rtps_status!="y")
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
    public function updateProposalHearingDateTea()
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
            $this->checkingLoginUserAccessSingleUser();
            $currentDate = date('Y-m-d');
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $proposalNo  = $this->input->post('proposalNo');

            if($currentDate > $hearingDate)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;

            }

            $allCases      = $this->SettlementTeaDcModel->getAllAppInReportSendByDcToSdlacTea($proposalNo);
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


    // save new notice and pro
    public function updateHearingDateGenerateNoticeTea()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposalNo', 'Proposal Details', 'trim|required|is_natural_no_zero');
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
            $this->checkingLoginUserAccessSingleUser();
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $user_code   = $this->session->userdata('user_code');
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
            $proposalDetails = $this->SettlementTeaDcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementTeaDcModel->getAllAppInReportSendByDcToSdlacTea($proposalNo);
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
                    if($this->SettlementTeaDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        foreach ($allSelectedList as $row)
                        {
                            $case_no = $row->case_no;
                            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
                            if($modificationRequest == 1)
                            {
                                echo json_encode(array(
                                    'responseType' => 101,
                                    'response'     => 101,
                                    'message'      => '#MRPULL00101 : There is a Modification request from CO for case no # '.$case_no,
                                ));
                                return false;
                            }
                            $this->utilityclass->checkUserAuthForCaseForAdcWithRollback($case_no);
                            //////proceeding start//////
                            $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                            if($proceeding_id == null or $proceeding_id==0)
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
                                'office_to'   => MB_ADD_DEPUTY_COMM,
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

                        }
                        unlink($oldFileName);
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
    //********************** START TEA **********************************


    //  settlement application details TEA ADC
    public function getSettlementTeaApplicationDetails()
    {
        $this->checkingLoginUserAccessSingleUser();
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $this->checkCaseInModificationRequest($case_no);
        $application_no = $this->input->get('case');
        $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

        $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementKhasModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);
        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($application_no);

        $lmdata=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $lmdata[] = $encdata;
        }

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $data['guar_rel'] = $relation_executation->result();
        }

        $data['encdata']=$lmdata;
        $data['basic']=$basic;
        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['applicants_encroacher']=$applicants_encroacher;
        $data['applicants_riotee_nok']=$applicants_riotee_nok;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['nominee'] = $nominee;

        //   calling API for self declaration data


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

        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementMbADCModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->SettlementTeaLandAdc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->SettlementMbADCModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementMbADCModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            foreach($data['applicants_encroacher'] as $applicant_enc){
                $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

                if($enc_check->num_rows() > 0){

                    $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid,$enc_check->row()->dag_no,$enc_check->row()->encroacher_id));

                    // echo $this->db->last_query();
                    if($sql_land_bank->num_rows() > 0){
                        $added_enc_data[] = $sql_land_bank->row();
                    }
                }
            }

            if(isset($added_enc_data)){
                $data['new_added_enc_data'] = $added_enc_data;
            }
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
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_SPECIAL_CULTIVATORS_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }
            $premium_data = $this->SettlementCommonModel->getPremiumTea($application_no);
            $data['premium_data'] = $premium_data;

            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SETTLEMENT_SPECIAL_CULTIVATORS_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }



            $checkArea = 0;
            $totalLandArea = 0;
            $totalDagAreaLessaValidation = 0;
            $totalAdditionalProToLessa = 0;
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
                if((CULTIVATION_MAX_APPLIED) * 6400 < $totalLandArea)
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
                if((CULTIVATION_MAX_APPLIED) * 100 < $totalLandArea)
                {
                    $checkArea = 1;
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

            $data['checkAppliedArea'] = $checkArea;


            $data['_view'] = 'settlementView/Adc/Tea/settlement_app_details_tea';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all mark as SDLAC TEA
    public function viewAllMarkAsSDLACListForDCTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaAdcModel->getMarkAsSDLACSettlementTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();
        $commMembers              = $this->SettlementMbDcModel->getMembersFromUsersWithUserType($dist_code);
        $data['committeeList']    = $commMembers;

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;



        $data['_view'] = 'settlementView/Adc/Tea/mark_as_sdlac_case_dc_tea';
        $this->load->view('layouts/main', $data);

    }


    // get all proposal list for TEA
    public function getAllProposalListSdlacTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaAdcModel->getAllProposalSendByDcToSdlacTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Tea/proposal_list_send_to_sdlac_tea';
        $this->load->view('layouts/main', $data);
    }


    // get all SDLAC Under consideration KHAS
    public function getAllUnderConSdlacTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaAdcModel->getAllUnderConSettlementTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Tea/under_consideration_case_dc_tea';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report TEA
    public function getAllApplicationInReportSendByDcToSdlacTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getAllAppInReportSendByDcToSdlacTea($proposal_no);
        $proposalDetails = $this->SettlementMbADCModel->getProposalDetailsById($proposal_no,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;

        $sql = $this->db->query('SELECT id, case_no FROM settlement_proposal_cases WHERE proposal_id = ?', array($proposal_no));

        if($sql->num_rows() > 0)
        {
            $cases_under_proposal = $sql->result();

            $rej_remark = array();
            $cases_id = array();

            foreach($cases_under_proposal as $ca_u_proposal)
            {
                $case_no_remark_check = $ca_u_proposal->case_no;

                $sql_remark = $this->db->query("SELECT * FROM rejected_remark WHERE case_no = ?", array($case_no_remark_check));

                if($sql_remark->num_rows() > 0)
                {
                    $cases_id[] = $ca_u_proposal->id;

                    $rejected_remarks_array = $sql_remark->result();
                    foreach($rejected_remarks_array as $rejected_remarks)
                    {
                        $reject_code = $rejected_remarks->reject_code;

                        $sql_reject_remarks = $this->db->query("SELECT * FROM reject_master WHERE reject_code = ? AND flag = ?", array($reject_code, 1));

                        if($sql_reject_remarks->num_rows() > 0)
                        {
                            $rej_remark[] = $sql_reject_remarks->row()->reject_code;
                        }
                    }
                }
            }

            if(isset($rej_remark))
            {
                $data['cases_id'] = $cases_id;
                $data['rejected_remark_list'] = $rej_remark;
            }
            else
            {
                $data['cases_id'] = false;
                $data['rejected_remark_list'] = false;
            }
        }

        $data['_view'] = 'settlementView/Adc/Tea/send_to_sdlac_case_dc_tea';
        $this->load->view('layouts/main', $data);

    }


    // generate proposal notice TEA
    public function generateNoticeSendAllMarkAppToSDLACByDcTea()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedMem[]', 'Case Number', 'required');
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
            $this->checkingLoginUserAccessSingleUser();
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $user_code   = $this->session->userdata('user_code');
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $allSelectedList = $this->input->post('selectedList');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $proposal_id     = $this->input->post('proposal_id');
            $allSelectedMem  = $this->input->post('selectedMem');

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

                $distName     = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName  = substr($distName->locname_eng, 0, 3);
                $proposalName = $distEngName.'/PROPOSAL/'.date("Y").'/'.$proposal_id;

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
                    'file_path' => $base_64_file_path,
                    'created_by' => MB_ADD_DEPUTY_COMM,
                    'proposal_name' => strtoupper($proposalName)
                );

                $this->db->trans_begin();
                if($this->SettlementTeaAdcModel->saveProposalSDLACTea($dataProSave) == 0)
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

                    // save present member only
                    foreach ($allSelectedMem as $member)
                    {
                        $memberData = [
                            'proposal_id' => $proposal_id,
                            'dist_code'   => $dist_code,
                            'user_code'   => $member['name'],
                            'nominee'     => $member['id'],
                            'status'      => 1,
                            'created_at'  => date('Y-m-d h:i:s'),
                        ];
                        $ins = $this->db->insert('sdlac_present_member', $memberData);
                        if($ins != 1 || $ins != true ){
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002309: Insertion failed in sdlac_present_member for 
                        proposal no : '.$proposal_id. ' and query is '. $this->db->last_query());
                            $json = [
                                'response' => 1,
                                'message'  => '#ERMR002309: SDLAC/CDLAC Member not added. Kindly contact system administrator',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }

                    foreach ($allSelectedList as $row)
                    {
                        $case_no = $row;
                        $this->utilityclass->checkUserAuthForCaseForAdcWithRollback($case_no);
                        $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
                        if($modificationRequest == 1)
                        {
                            echo json_encode(array(
                                'responseType' => 101,
                                'response'     => 101,
                                'message'      => '#MRPULL00101 : There is a Modification request from CO for case no # '.$case_no,
                            ));
                            return false;
                        }
                        $saveCaseList = array(
                            'proposal_id' => $proposalId,
                            'case_no' => $case_no,
                            'status' => 1,
                            'ip' => $this->input->ip_address()
                        );

                        if($this->SettlementTeaDcModel->saveProposalCaseListSDLACTea($saveCaseList) == 0)
                        {
                            $this->db->trans_rollback();

//                            $this->SettlementTeaDcModel->deleteProposalSDLAC($proposalId);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        $updateData = array(
                            'status'          => MB_SEND_TO_SDLAC,
                            'pending_office'  => MB_SDLAC,
                            'pending_officer' => MB_ADD_DEPUTY_COMM,
                            'from_office'     => MB_ADD_DEPUTY_COMM,
                            'dc_code'         => $user_code,
                            'dc_proceeding'   => 1,
                        );
                        if($this->SettlementTeaAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                            $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                            if($proceeding_id == null or $proceeding_id==0)
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
                                'office_from' => MB_ADD_DEPUTY_COMM,
                                'office_to'   => MB_ADD_DEPUTY_COMM,
                                'task' => 'Send to SDLAC'
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
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                    ));
                    return;
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


    // get all DC approved list TEA
    public function getAllApprovedBySDLACListTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getAllApproveAppBySdlacTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tea/approve_list_by_sdlac_tea';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application TEA
    public function viewApprovedAppDetailsTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');

        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $application_no = $this->input->get('case');
        $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);

        $data=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $data[] = $encdata;

        }
        $data['encdata']=$data;
        $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementKhasModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

        $data['basic']=$basic;
        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['applicants_encroacher']=$applicants_encroacher;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['reservation'] = $this->SettlementMbModel->getSettlementReservation($application_no);

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
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec){
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTeaDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementTeaLandAdc();
        }
        else
        {
            $caseDetails = $this->SettlementTeaDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementTeaDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tea/settlement_app_details_only_view_tea';
            $this->load->view('layouts/main', $data);
        }

    }


    // get all rejected app by dc TEA
    public function getAllRejectByDcListTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getAllRejectAppByDcTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tea/rejected_list_by_dc_tea';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application TEA
    public function viewRejectedAppDetailsTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $dist_code = $this->session->userdata('dist_code');
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

        $application_no = $this->input->get('case');
        $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);

        $data=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $data[] = $encdata;

        }
        $data['encdata']=$data;
        $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementKhasModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

        $data['basic']=$basic;
        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['applicants_encroacher']=$applicants_encroacher;
        $data['dags']=$dags;
        $data['lmnotes']=$lmnotes;
        $data['proceedings']=$proceedings;
        $data['dhardocuments']=$dhardocuments;
        $data['reservation'] = $this->SettlementMbModel->getSettlementReservation($application_no);

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
        $data['document']=$output->documents;
        $data['query']=$output->query;
        $data['property']=$output->property;
        $data['aadhar']=$output->aadhar;
        $data['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec){
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementTeaDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementTeaLandAdc();
        }
        else
        {
            $caseDetails = $this->SettlementTeaDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementTeaDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tea/settlement_app_details_rejected_only_view_tea';
            $this->load->view('layouts/main', $data);
        }

    }


    // view all chitha update application TEA
    public function getAllOrderChithaUpdateForDcAppTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getAllOrderChithaUpdateAppTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tea/order_chitha_update_list_by_dc_tea';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC TEA
    public function getAllReReportAppByCOForDcAppTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getReRevertedByCoApplicationTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tea/re_revert_by_co_list_tea';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC TEA
    public function getAllRevertedAppByDeptForDcAppTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaDcModel->getRevertedByDeptApplicationTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tea/revert_by_dept_list_tea';
        $this->load->view('layouts/main', $data);
    }


    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOTea()
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
            $this->checkingLoginUserAccessSingleUser();
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $status    = $this->input->post('status');
            $user_code = $this->session->userdata('user_code');
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for case no # '.$case_no,
                ));
                return false;
            }

            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $caseCount = $this->SettlementTeaDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,

                );

                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO'
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
                        $rmk='Reverted to CO';
                        $status='M';
                        $task=MB_ADD_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status!="y")
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
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                );
                if($this->SettlementTeaDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($case_no);
                    if($proceeding_id == null or $proceeding_id==0)
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
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO'
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
                        $rmk    = 'Reverted to CO';
                        $status = 'M';
                        $task   = MB_ADD_DEPUTY_COMM;
                        $pen    = MB_CIRCLE_OFFICER;
                        $case   = $case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if($rtps_status!="y")
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




    //********************** END TEA **********************************


    // 1st landing page TEA ADC
    public function SettlementTeaLandAdc()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementTeaAdcModel->countAllPendingSettlementKhas($dist_code);
        $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACNoticeCount     = $this->SettlementTeaAdcModel->countMarkAsSDLACSettlementKhas($dist_code);
        $SDLACReportCount     = $this->SettlementTeaAdcModel->countAllProposalSendByDcToSdlacKhas($dist_code);
        $caseStatusCount      = 0;
        $sdlacMemberApproval  = $this->SettlementTeaAdcModel->countSdlacStatusList($dist_code);
        $SDLACConsideration   = $this->SettlementTeaAdcModel->countAllUnderConsiderationAppTea($dist_code);

        // $reReportByCOCount    = $this->SettlementTeaAdcModel->countReRevertedByCoApplicationKhas($dist_code);
        // $approvedListCount    = $this->SettlementTeaAdcModel->countAllApproveAppBySdlacKhas($dist_code);
        // $rejectedListCount    = $this->SettlementTeaAdcModel->countAllRejectAppByDcKhas($dist_code);
        // $finalVerifyCaseCount = $this->SettlementTeaAdcModel->countAllCasesForFinalVerifyAppKhas($dist_code);
        // $revertedByDepartmentCount = $this->SettlementTeaAdcModel->countRevertedByDeptApplicationKhas($dist_code);
        // $chithaUpdateOrderCount    = $this->SettlementTeaAdcModel->countAllOrderChithaUpdateAppKhas($dist_code);

        $coRejectedListCount = $this->SettlementCommonDcModel->countCoRejectedCaseForADC($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID);
        $coModificationListCount = $this->SettlementPullModel->countCoModificationRequestCaseForADC($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID);

        $rejctedListCount = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID, MB_ADD_DEPUTY_COMM);
        $revivalListCount = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID, MB_ADD_DEPUTY_COMM);



        $reReportByCOCount    = 0;
        $approvedListCount    = 0;
        $rejectedListCount    = 0;
        $finalVerifyCaseCount = 0;
        $chithaUpdateOrderCount = 0;
        $revertedByDepartmentCount = 0;



        $data['dist_code']            = $dist_code;
        $data['firstProceedingCount'] = $firstProceedingCount;
        $data['SDLACCommitteeCount']  = $SDLACCommitteeCount;
        $data['SDLACNoticeCount']     = $SDLACNoticeCount;
        $data['SDLACReportCount']     = $SDLACReportCount;
        $data['reReportByCOCount']    = $reReportByCOCount;
        $data['caseStatusCount']      = $caseStatusCount;
        $data['approvedListCount']    = $approvedListCount;
        $data['rejectedListCount']    = $rejectedListCount;
        $data['SDLACConsideration']   = $SDLACConsideration;
        $data['finalVerifyCaseCount'] = $finalVerifyCaseCount;
        $data['chithaUpdateOrderCount']    = $chithaUpdateOrderCount;
        $data['revertedByDepartmentCount'] = $revertedByDepartmentCount;
        $data['sdlacMemberApprovalCount']  = $sdlacMemberApproval;
        $data['coRejectedCaseCount']       = $coRejectedListCount;
        $data['coModificationListCount']   = $coModificationListCount;
        $data['rejctedListCount']   = $rejctedListCount;
        $data['revivalListCount']   = $revivalListCount;

        $data['_view'] = 'settlementView/Adc/Tea/first_landing_page_adc_tea';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list KHAS ADC
    public function viewAllTeaFirstProceedingDCCaseList()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTeaAdcModel->getAllPendingSettlementKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        // $getDistrict = $this->SettlementMbDcModel->getLocationName($dist_code);
        // $data['locations']        = $getDistrict->result();
        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'settlementView/Adc/Tea/first_proceeding_case_adc_cultivators';
        $this->load->view('layouts/main', $data);

    }


    //pagination of first proceeding
    public function firstProceedingPaginationAPI()
    {
        $this->checkingLoginUserAccessSingleUser();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');

        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->input->post('subdiv');
        $cir_code    = $this->input->post('circle');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }
        $valid_columns = array(
            0   => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)){
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)){
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where("(settlement_basic.adc_code = '" . $this->session->userdata('user_code') . "' OR settlement_basic.adc_code IS NULL)", null, false);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }
            if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where("(settlement_basic.adc_code = '" . $this->session->userdata('user_code') . "' OR settlement_basic.adc_code IS NULL)", null, false);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/SettlementTeaAdc/getSettlementTeaApplicationDetails/?case='.$rows->case_no.'">
                        '.$this->lang->line('process').'</a>'

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
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    //pagination of Second proceeding SDLAC Recommended (Marked)
    public function secondProceedingSdlacRecommendedMarked()
    {
        $this->checkingLoginUserAccessSingleUser();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');
        $approvedBy  = $this->input->post('approvedBy');

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code    = $this->input->post('circle');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
        $approved_by = '';

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'desc';
        }
        $valid_columns = array(
            0   => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)){
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)){
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where("(settlement_basic.adc_code = '" . $this->session->userdata('user_code') . "' OR settlement_basic.adc_code IS NULL)", null, false);
        //approved by  department or DC
        if(!empty($approvedBy))
        {
            if ($approvedBy == 1) // department
            {
                $this->db->where("(trim(settlement_basic.approve_by)='GOVT' or
                            (trim(settlement_basic.approve_by) is null and (t.is_urban='Y' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='YES'))))" );
            }
            if($approvedBy == 2) // DC
            {
                $this->db->where("(trim(settlement_basic.approve_by)='DC' or
                            (trim(settlement_basic.approve_by) is null and (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='NO')))" );
            }
        }
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }
            if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where("(settlement_basic.adc_code = '" . $this->session->userdata('user_code') . "' OR settlement_basic.adc_code IS NULL)", null, false);
            //approved by  department or DC
            if(!empty($approvedBy))
            {
                if ($approvedBy == 1) // department
                {
                    $this->db->where("(trim(settlement_basic.approve_by)='GOVT' or
                            (trim(settlement_basic.approve_by) is null and (t.is_urban='Y' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='YES'))))" );
                }
                if($approvedBy == 2) // DC
                {
                    $this->db->where("(trim(settlement_basic.approve_by)='DC' or
                            (trim(settlement_basic.approve_by) is null and (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='NO')))" );
                }
            }
            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                if($rows->approve_by != '')
                {
                    if($rows->approve_by == 'GOVT' || $approvedBy == 1)
                    {
                        $approved_by = "<span style='color:red'>Department</span>";
                    }
                    if($rows->approve_by == 'DC' || $approvedBy == 2)
                    {
                        $approved_by = "<span style='color:blue'>DC</span>";
                    }
                }
                else
                {
                    if(strtoupper($rows->is_urban) == 'Y' || (strtoupper($rows->is_urban)=='N' && strtoupper($rows->falls_und_gmc) == YES))
                    {
                        $approved_by = "<span style='color:red'>Department</span>";
                    }
                    else
                    {
                        $approved_by = "<span style='color:blue'>DC</span>";
                    }
                }

                $json[] = array(

                    $rows->case_no,

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success" href="'.base_url().'index.php/SettlementTeaAdc/getSettlementTeaApplicationDetails/?case='.$rows->case_no.'">View Application</a>'
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
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    //pagination of third proceeding SDLAC Report
    public function thirdProceedingSdlacReport()
    {
        $this->checkingLoginUserAccessSingleUser();
        $service      = $this->input->post('service');
        $by_case_no   = $this->input->post('case_no');
        $proposal_no  = $this->input->post('proposal_no');
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $ru           = $this->session->userdata('user_desig_code');

        if($hdate != false && $hdate != ''){
            $hearing_date = date('Y-m-d', $hdate);
        }

        $draw         = intval($this->input->post('draw'));
        $start        = intval($this->input->post('start'));
        $length       = intval($this->input->post('length'));
        $order        = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }
        $valid_columns = array(
            0 => 'settlement_proposal_list.h_date',
        );
        if(!isset($valid_columns[$col])){
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }

        if(!empty($by_case_no)) { //join table settlement_proposal_cases            
            $this->db->select('*');
            $this->db->from('settlement_proposal_cases');
            $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
            $this->db->where('settlement_proposal_list.service_code', $service);
            $this->db->where('settlement_proposal_list.status', 1);
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
            $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
            $this->db->where('settlement_proposal_list.final_verify_status', 0);
        }

        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('id', $proposal_no);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
        }

        else if(!empty($hearing_date)){
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('h_date', $hearing_date);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
            $this->db->where('user_code',$this->session->userdata('user_code'));
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
            $this->db->where('user_code',$this->session->userdata('user_code'));
        }

        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();

            if(!empty($by_case_no)) { //join table settlement_proposal_cases            
                $this->db->select('*');
                $this->db->from('settlement_proposal_cases');
                $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
                $this->db->where('settlement_proposal_list.service_code', $service);
                $this->db->where('settlement_proposal_list.status', 1);
                $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
                $this->db->where('settlement_proposal_list.final_verify_status', 0);
                $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
            }

            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('id', $proposal_no);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
                $this->db->where('user_code',$this->session->userdata('user_code'));
            }

            else if(!empty($hearing_date)){
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('h_date', $hearing_date);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
                $this->db->where('user_code',$this->session->userdata('user_code'));
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
                $this->db->where('user_code',$this->session->userdata('user_code'));
            }

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();
            $i=1;

            foreach($result as $rows) {

                $json[] = array (

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->proposal_name .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>

                    <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    '<i class="fa fa-calendar"></i> On '. date('d-m-Y', strtotime($rows->h_date)),

                    '<i class="fa fa-user"></i> '. ($rows->created_by == '')? $rows->created_by: 'NA',

                    '<a class="btn btn-sm btn-primary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Print Notice</a>
                       
                    <a class="btn btn-sm btn-dark" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/downloadCasesWithProposalId/?case='.$rows->id.'">Download</a>
         
                    <a class="btn btn-sm btn-success" href="'.base_url().'index.php/SettlementTeaAdc/getAllApplicationInReportSendByDcToSdlacTea/?case='.$rows->id.'">
                      '.$this->lang->line('process').'</a>'

                );

                $i++;
            }

            // <a target="_blank" class="btn btn-info" style="background-color: #673AB7!important; color: white!important; border: none" href="'.base_url().'index.php/SettlementCommonDc/generateSdlacMinutesForProposal/?case='.$rows->id.'">
            //             '.$this->lang->line('generateMinutes').'</a>

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // SDLAC Report status send to SDLAC Minutes
    public function sdlacReportOnlineApprove()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $detail        = $this->input->post('data');
        $proposal_id   = trim($this->input->post('proposal_id'));
        $service_code  = trim($this->input->post('service_code'));
        $dist_code     = $this->session->userdata('dist_code');
        $subdiv_code   = $this->session->userdata('subdiv_code');

        if(count($detail) == 0)
        {
            echo json_encode(array(
                'response' => 1,
                'message'  => '#ER-JM2496: There is no case found. Kindly contact system administrator',

            ));
            return;
        }
        $this->checkingLoginUserAccessSingleUser();
        $this->db->trans_begin();
        foreach($detail as $row)
        {
            $caseNo= trim($row['case_no']);
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($caseNo);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for case no # '.$caseNo,
                ));
                return false;
            }
            $rejectedReasonList = '';
            if(trim($row['report_status']) == SDLAC_MEMBER_REPORT_STATUS_DISAGREE)
            {
                $array = [
                    'rejected_flag' => 1,
                    'final_status' => MB_DISMISS
                ];
                $this->db->where('case_no', $caseNo);
                $this->db->update('settlement_basic', $array);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'response' => 1,
                        'message'  => '#ER-JM122: Case can not be forwarded to SDLAC. Kindly contact system administrator',

                    ));
                    return;
                }

                $getRejectedReasonSql = $this->db->query("SELECT A.reject_code, A.service_code, B.remark FROM rejected_remark A 
                            INNER JOIN reject_master B ON CAST(A.reject_code AS int) = B.reject_code
                            WHERE A.case_no = ?", array($caseNo));

                if($getRejectedReasonSql->num_rows() > 0)
                {
                    $rejReasonArr = $getRejectedReasonSql->result();
                    $rejReasonArr1   = array();
                    foreach($rejReasonArr as $rejRe)
                    {
                        $rejReasonArr1[] = trim($rejRe->remark);
                    }

                    $rejectedReasonList = implode ( ", ", $rejReasonArr1 );
                }

                $template_remark = 'Not Recommended';
                $rejectedRemarks = $rejectedReasonList;

            }
            else
            {
                $array = [
                    'rejected_flag' => 0,
                    'final_status' => MB_APPROVED_BY_SDLAC
                ];
                $this->db->where('case_no', $caseNo);
                $this->db->update('settlement_basic', $array);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'response' => 1,
                        'message'  => '#ER-JM123: Case can not be forwarded to SDLAC. Kindly contact system administrator',

                    ));
                    return;
                }

                $template_remark = 'Recommended';
                $rejectedRemarks = $rejectedReasonList;
            }

            $updateData = [
                'case_status'      => trim($row['report_status']),
                'sdo_remarks'      => $rejectedRemarks,
                'template_remarks' => $template_remark,
            ];

            $this->db->where('id', trim($row['id']));
            $this->db->update('settlement_proposal_cases', $updateData);

            if($this->db->affected_rows() <= 0 )
            {
                $this->db->trans_rollback();
                log_message('error', 'Updation failed in 
            settlement_proposal_cases '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => 'Case can not be forwarded to SDLAC. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }
        }

        //update sdlac proposal list
        $updateSdlacList = [
            'meeting_create_status' => 1, // for ready to create meeting
            'sdlac_prceed_status'   => 2, //
        ];
        $this->db->where('id', $proposal_id);
        $this->db->update('settlement_proposal_list', $updateSdlacList);
        if($this->db->affected_rows() <= 0 )
        {
            $this->db->trans_rollback();
            log_message('error', 'Updation failed in settlement_proposal_list for 
            proposal no : '.$proposal_id. ' and query is '. $this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => 'There is some problem. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
        else
        {
            $this->db->trans_commit();
            $json = [
                'response' => 2,
                'message'  => 'This Proposal would be available under process SDLAC/CDLAC Minutes',
            ];
            echo json_encode($json);
        }
    }




    // insert nominee detail
    public function insertNomineeDetailOfSdlacMember()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('sdlac_mem', 'SDLAC/CDLAC Member', 'trim|required');
        $this->form_validation->set_rules('nominee_name', 'Nominee Name', 'trim|required');
        $this->form_validation->set_rules('nominee_cont', 'Nominee Contact No', 'trim|required|max_length[10]|is_natural');
        $this->form_validation->set_rules('nominee_email', 'Nominee Email', 'trim|valid_email');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'Wrong data entered',
            ));
            return;
        }
        else
        {
            $this->checkingLoginUserAccessSingleUser();
            $created_at   = date('Y-m-d h:i:s');
            $updated_at   = date('Y-m-d h:i:s');
            $sdlac_mem    = $this->input->post('sdlac_mem');
            $nom_name     = $this->input->post('nominee_name');
            $nom_contact  = $this->input->post('nominee_cont');
            $nom_email    = $this->input->post('nominee_email');

            $insNominee = [
                'nominee_name'    => $nom_name,
                'district'        => $this->session->userdata('dist_code'),
                'sdlac_user_code' => $sdlac_mem,
                'email'           => $nom_email,
                'mobile_no'       => $nom_contact,
                'nominee_status'  => NOMINEE_STATUS_ENABLE,
                'created_at'      => $created_at,
                'updated_at'      => $updated_at,
            ];
            $insert = $this->db->insert('sdlac_nominee_list', $insNominee);
            if($insert != 1 || $insert != true) {
                log_message('warning', '#ERROR4013: Insertion failed in sdlac_nominee_list '.
                    $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#ERROR4013: Something went wrong on adding nominee detail. 
                                  Kindly contact system administrator',
                ));
                return;
            }

            echo json_encode(array(
                'responseType' => 2,
                'message'      => 'Nominee detail successfully added',
            ));
            return;
        }
    }


    //check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus()
    {
        $this->checkingLoginUserAccessSingleUser();
        $proposal_id  = $this->input->post('prop_id');
        $dist_code    = $this->session->userdata('dist_code');
        // $subdiv_code  = $this->session->userdata('subdiv_code');

        $processStatus = $this->db->query("SELECT * FROM settlement_proposal_list
                                    WHERE sdlac_prceed_status ".PROPOSAL_SEND_TO_SDLAC." 
                                    AND dist_code = ? AND id = ? AND created_by = ? ",
            array($dist_code, $proposal_id, MB_ADD_DEPUTY_COMM));

        if($processStatus->num_rows() == 0 ) {
            $json = [
                'response' => 1,
                'message'  => 'Already send to SDLAC members',
            ];
            echo json_encode($json);
            return false;
        }
        else {
            $json = [
                'response' => 2,
            ];
            echo json_encode($json);
            return;
        }
    }


    // get all forth proceeding SDLAC Report Khas page
    public function getAllSdlacMemberApprovalProposalListTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementTeaAdcModel->getSdlacApprovalProposalListTea($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Tea/sdlac_approval_proposal_list_tea';
        $this->load->view('layouts/main', $data);

    }


    public function getCasesAgainstProposalNo()
    {
        $this->checkingLoginUserAccessSingleUser();
        $proposal_id  = $this->input->post('id');
        $service_code = $this->input->post('service_code');
        $dist_code    = $this->session->userdata('dist_code');
        $user_code    = $this->session->userdata('user_code');

        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
        settlement_proposal_cases A JOIN settlement_proposal_list B ON
        B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=? AND B.service_code=?
        AND B.created_by=?",
            array($proposal_id, $dist_code, $service_code, MB_ADD_DEPUTY_COMM));

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }


    // get all forth proceeding SDLAC Report Khas with data
    public function getAllSdlacMemberApprovalProposalListDataTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $service      = $this->input->post('service');
        $by_case_no   = $this->input->post('case_no');
        $proposal_no  = $this->input->post('proposal_no');
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = $this->session->userdata('dist_code');
        $ru           = $this->session->userdata('user_desig_code');
        // $suv_div      = $this->session->userdata('subdiv_code');

        if($hdate != false && $hdate != ''){
            $hearing_date = date('Y-m-d', $hdate);
        }

        $draw         = intval($this->input->post('draw'));
        $start        = intval($this->input->post('start'));
        $length       = intval($this->input->post('length'));
        $order        = $this->input->post('order');

        // var_dump($hdate);
        // var_dump($hearing_date); die;

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }
        $valid_columns = array(
            0 => 'settlement_proposal_list.h_date',
        );
        if(!isset($valid_columns[$col])){
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null){
            $this->db->order_by($order, $dir);
        }


        if(!empty($by_case_no)) { //join table settlement_proposal_cases
            $this->db->select('*');
            $this->db->from('settlement_proposal_cases');
            $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
            $this->db->where('settlement_proposal_list.service_code', $service);
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
            $this->db->where('settlement_proposal_list.status', 1);
            $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.final_verify_status', 0);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));

        }
        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
            $this->db->where('id', $proposal_no);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
        }
        else if(!empty($hearing_date)){
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
            $this->db->where('h_date', $hearing_date);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
        }

        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();

            if (!empty($by_case_no)) { //join table settlement_proposal_cases
                $this->db->select('*');
                $this->db->from('settlement_proposal_cases');
                $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
                $this->db->where('settlement_proposal_list.service_code', $service);
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_list.status', 1);
                $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.final_verify_status', 0);
                $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
            }

            else if (!empty($hearing_date)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);
                $this->db->where('h_date', $hearing_date);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
            }

            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);
                $this->db->where('id', $proposal_no);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.user_code',$this->session->userdata('user_code'));

            }

            $query1 = $this->db->get();
            $total_records = $query1->num_rows();
            $i=1;

            foreach($result as $rows)
            {
                $json[] = array (

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->proposal_name .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>

                <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    '<i class="fa fa-calendar"></i> On '. date('d-m-Y', strtotime($rows->h_date)),

                    '<i class="fa fa-user"></i> '. $rows->created_by,


                    '<a class="rezaButt buttInfo2" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacAttendance/?case='.$rows->id.'">Attendance</a>
                    
                    <a class="rezaButt buttPrimary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Notice</a>
                 
                    <a class="rezaButt buttCust " target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/generateSdlacMinutesForProposal/?case='.$rows->id.'">Digital Minutes</a>
                    
                    <a class="rezaButt buttInfo" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacUploadedMinute/?case='.$rows->id.'">Uploaded Minutes</a>
                    
                    <a class="rezaButt btn-success" href="'.base_url().'index.php/SettlementTeaAdc/getSdlacMemberApproveProposalViewIndividualTea/?case='.$rows->id.'">
                    '.'Process'.'</a>'


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
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    // forth proceeding SDLAC Report view
    public function getSdlacMemberApproveProposalViewIndividualTea()
    {
        $this->checkingLoginUserAccessSingleUser();
        $dist_code   = $this->session->userdata('dist_code');
        $proposal_no = $this->input->get('case');
        $proposalDetails = $this->SettlementTeaAdcModel->getSdlacApprovalProposalIndividualKhas($proposal_no,$dist_code);
        // SDLAC/CDLAC Member report details
        $reportDetails   = $this->SettlementTeaAdcModel->getSdlacMemberReportDetailsKhas($proposal_no,$dist_code);

        $getMembersStatus = $this->SettlementTeaAdcModel->getSdlacMemberStatus($dist_code, $proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $proposalDetails->row();
        $data['pendingCaseCount'] = $proposalDetails->num_rows();
        $data['reports']          = $reportDetails->result();
        $data['reportCount']      = $reportDetails->num_rows();
        $data['getMemberStatus']  = $getMembersStatus;

        $data['_view'] = 'settlementView/Adc/Tea/sdlac_committee_report_details_tea';
        $this->load->view('layouts/main', $data);
    }


    // proposal Forward To Dc For Final Verify By ADC
    public function proposalForwardToDcForFinalVerifyTea()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proposalNo', 'Proposal Number', 'trim|required|is_natural|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $this->checkingLoginUserAccessSingleUser();
            $user_code   = $this->session->userdata('user_code');
            $proposal_no = trim($this->input->post('proposalNo'));
            $dist_code   = $this->session->userdata('dist_code');
            $pendingCase = $this->SettlementTeaAdcModel->getAllAppInReportSendByDcToSdlacTea($proposal_no);
            $cases       = $pendingCase->result();
            $caseCount   = $pendingCase->num_rows();
            $proposalDetails = $this->SettlementTeaAdcModel->getProposalDetailsById($proposal_no,$dist_code);

            if($proposalDetails->final_verify_status != 0)
            {
                echo json_encode(array(
                    'responseType' => 6,
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

            $pending = 0;
            $this->db->trans_begin();
            foreach ($cases as $case)
            {
                $caseNo = trim($case->case_no);
                $modificationRequest = $this->checkCaseInModificationRequestWithSession($caseNo);
                if($modificationRequest == 1)
                {
                    echo json_encode(array(
                        'responseType' => 101,
                        'response'     => 101,
                        'message'      => '#MRPULL00101 : There is a Modification request from CO for case no # '.$caseNo,
                    ));
                    return false;
                }
                if($case->status == PRO_CASE_STATUS_APPROVE or $case->status == PRO_CASE_STATUS_REJECT)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 3,
                        'pendingCases' => $pending,
                        'proposalSequenceNo' => $proposal_no,
                    ));
                    return;
                }
                // if($case->case_status == 0 or $case->case_status == '')
                // {
                //     $this->db->trans_rollback();
                //     echo json_encode(array(
                //         'responseType' => 3,
                //         'pendingCases' => $pending,
                //         'proposalSequenceNo' => $proposal_no,
                //     ));
                //     return;
                // }

                // approved case
                if($case->case_status == 1 || $case->case_status == 0)
                {
                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($caseNo);
                    if($checkArea != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 10,
                        ));
                        return;
                    }

                    $updateCase = array(
                        'case_status' => $case->case_status,
                        'status'      => PRO_CASE_STATUS_APPROVE,
                        'approved_by_dc' => 0,
                    );
                    if($this->SettlementTeaAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase) == 0)
                    {
                        log_message('error', '#reza1: '.$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    // update in settlement basic
                    $updateBasicData = array(
                        'status'          => MB_FINAL_APPROVED_BY_DC,
                        'pending_office'  => MB_DEPUTY_COMM,
                        'pending_officer' => MB_DEPUTY_COMM,
                        'from_office'     => MB_ADD_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        'sdlac_approval'  => 'Y',
                        'sdlac_date'      => date('Y-m-d h:i:s'),
                        'dc_proceeding'   => 1,
                        'final_status'    => MB_APPROVED_BY_SDLAC,
                        'sdlace_proposal_no' => trim($case->proposal_id),
                    );

                    if($this->SettlementTeaAdcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
                    {
                        log_message('error', '#upd1: '.$this->db->last_query());

                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    //////proceeding start//////
                    $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($caseNo);
                    if($proceeding_id == null or $proceeding_id==0)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $caseNo,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $case->template_remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_ADD_DEPUTY_COMM,
                        'task'        => 'Forwarded to DC for Final Check',
                        'minutes_proposal_id' => trim($case->proposal_id)
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $caseNo);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($caseNo)->applid;

                    $rmk    = 'Forwarded to DC for Final Check';
                    $status = 'M';
                    $task   = MB_ADD_DEPUTY_COMM;
                    $pen    = MB_DEPUTY_COMM;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if($rtps_status!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $caseNo");
                        redirect(base_url() . "index.php/home");
                    }
                }

                // rejected case
                if($case->case_status == 2)
                {
                    $updateCase = array(
                        'case_status' => $case->case_status,
                        'status'      => PRO_CASE_STATUS_REJECT,
                        'approved_by_dc' => 0,
                    );
                    if($this->SettlementTeaAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
                        log_message('error', '#muzz1: '.$this->db->last_query());

                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    $updateBasicData = array(
                        'status'          => MB_FINAL_APPROVED_BY_DC,
                        'pending_office'  => MB_DEPUTY_COMM,
                        'pending_officer' => MB_DEPUTY_COMM,
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        // 'dc_proceeding'   => 0,
                        'final_status'    => MB_DISMISS,
                    );

                    if($this->SettlementTeaAdcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
                    {
                        log_message('error', '#muzz1: '.$this->db->last_query());

                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $updatePro = array(
                            'status'         => PRO_CASE_STATUS_REJECT,
                            'approved_by_dc' => 0,
                        );

                        if($this->SettlementTeaAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updatePro) == 0)
                        {

                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        //////proceeding start//////
                        $proceeding_id = $this->SettlementCommonDcModel->getProceedingIdAdc($caseNo);
                        if($proceeding_id == null or $proceeding_id==0)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no' => $caseNo,
                            'proceeding_id' => $proceeding_id,
                            'date_of_hearing' => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status' => MB_FINAL_APPROVED_BY_DC,
                            'user_code'  => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d h:i:s'),
                            'operation'  => 'E',
                            'note_on_order' => $case->template_remarks,
                            'ip' => $this->utilityclass->get_client_ip(),
                            'office_from' => MB_ADD_DEPUTY_COMM,
                            'office_to'   => MB_DEPUTY_COMM,
                            'task'        => 'Forwarded to DC for Final Check',
                            'minutes_proposal_id' => trim($case->proposal_id)
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if($insertProceeding != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $caseNo);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        else
                        {
                            $application_no = $this->SettlementApModel->getSettlementBasicCo($caseNo)->applid;
                            $rmk    = 'Forwarded to DC for Final Check';
                            $status = 'M';
                            $task   = MB_ADD_DEPUTY_COMM;
                            $pen    = null;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            if($rtps_status!="y")
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP00013: Rejected by SDLAC failed case no # $caseNo");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        //////proceeding end//////
                    }
                }

            }

            $dataUpdate = array(
                'final_verify_status' => 1
            );

            if($this->SettlementTeaAdcModel->updateProposalListByIdWithDistCode($proposal_no,$dist_code,$dataUpdate)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 5,
            ));
            return;

        }
    }




//// end Masud's code



}
