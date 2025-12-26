<?php

class NcKhasLandAdc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('NcModel/NcMeetingDcModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('NcModel/NcCommonAdcModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('NcModel/NcPullModel');
        $this->load->model('UtilsModel');


        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        if($user_desig_code != MB_ADD_DEPUTY_COMM)
        {
            echo json_encode(['error' => 'Unauthorized access']);
            exit;
        }



    }


    // NC code by Masud Reza (01/03/2024)

    //////////////// *************** **************** ////////////////


    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {
        $dags                   = $this->NcCommonSdoAdcDcModel->getNcApplicationDag($application_no);
        $totalAreaInChitha[]    = 0;
        $appAreaInApplication   = 0;
        $areaCheck              = 0;
        $chithaDagArray         = [];
        $lmProcessArea          = [];
        $allApplicationDagArray = [];
        $appliedDags            = $dags;
        $basic                  = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($application_no);
        $service_code           = trim($basic['service_code']);

        if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $application_no");
            redirect(base_url() . "index.php/home");
            return false;
        }
        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
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

            $chithaDag = $this->NcCommonSdoAdcDcModel->getNcChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocationNotSubmit(
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

                if($basic['dc_proceeding'] == 0)
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

                // SDO/ADC processing application
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

                if($basic['dc_proceeding'] == 0)
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
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
            'lmProcessArea' => $lmProcessArea,
        );

        return $checkAreaDetail;
    }


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {

        $dags                 = $this->NcCommonSdoAdcDcModel->getNcApplicationDag($application_no);
        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck            = 0;
        $appliedDags          = $dags;
        $basic                = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($application_no);
        $service_code         = trim($basic['service_code']);

        if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $application_no");
            redirect(base_url() . "index.php/home");
            return false;
        }
        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
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

            $chithaDag = $this->NcCommonSdoAdcDcModel->getNcChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->NcCommonSdoAdcDcModel->getAllNcDagAreaDetailsByLocationNotSubmit(
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


                if($basic['dc_proceeding'] == 0)
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

                if($basic['dc_proceeding'] == 0)
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
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($caseNo);

        if($basic->pull_request == 1)
        {
            $service_code = trim($basic->service_code);
            $pendingWith  = trim($basic->pending_officer);
            if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $caseNo");
                redirect(base_url() . "index.php/home");
                return false;
            }
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_SUB_DIV_COMM)
                {
                    $this->session->set_userdata('message', "There is modification request for this case # $caseNo by CO");
                    redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForSdo?service='.$service_code);
                    return false;
                }
                elseif($user_desig_code == MB_ADD_DEPUTY_COMM)
                {
                    $this->session->set_userdata('message', "There is modification request for this case # $caseNo by CO");
                    redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForAdc?service='.$service_code);
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
        $modificationRequest = 0;
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->NcPullModel->getSettlementBasicDetails($caseNo);
        if($basic->pull_request == 1)
        {
            $service_code = trim($basic->service_code);
            $pendingWith  = trim($basic->pending_officer);
            if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $caseNo");
                redirect(base_url() . "index.php/home");
                return false;
            }
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


    // check applied area more than dag area
    public function checkAppliedAreaMoreThanDagArea($application_no)
    {

        $dags                     = $this->NcServiceModel->getSettlementDag($application_no);
        $appDistrict              = $this->session->userdata('dist_code');;
        $appAreaMoreThanDagA      = 0;
        $appAreaMoreThanDagSingle = 0;
        $rezaDagTotal             = 0;
        $rezaAppTotalHome         = 0;
        $rezaAppTotalAgri         = 0;
        $appAreaMoreThanDagArray  = [];
        foreach ($dags as $dag)
        {

            $totalDagArea = 0;
            $totalAppliedInDagHome = 0;
            $totalAppliedInDagAgri = 0;
            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // Dag
                $bighaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_b, 0);
                $kathaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_k, 0);
                $lessaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_lc, 0);
                $gandaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_g, 0);
                $totalDagArea = ($bighaInDag * 6400) + ($kathaInDag * 320) + ($lessaInDag * 20) + $gandaInDag;

                // home
                $bighaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_b, 0);
                $kathaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_k, 0);
                $lessaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_lc, 0);
                $gandaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_g, 0);
                $totalAppliedInDagHome = ($bighaInDagAppliedHome * 6400) + ($kathaInDagAppliedHome * 320) + ($lessaInDagAppliedHome * 20) + $gandaInDagAppliedHome;

                // Agri
                $bighaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_b, 0);
                $kathaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_k, 0);
                $lessaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_lc, 0);
                $gandaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_g, 0);
                $totalAppliedInDagAgri = ($bighaInDagAppliedAgri * 6400) + ($kathaInDagAppliedAgri * 320) + ($lessaInDagAppliedAgri * 20) + $gandaInDagAppliedAgri;

                if ($totalDagArea < $totalAppliedInDagHome + $totalAppliedInDagAgri)
                {
                    $appAreaMoreThanDagArray[] = 1;
                }
                $rezaDagTotal += $totalDagArea;
                $rezaAppTotalHome += $totalAppliedInDagHome;
                $rezaAppTotalAgri += $totalAppliedInDagAgri;

            }
            else
            {
                // Dag
                $bighaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_b, 0);
                $kathaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_k, 0);
                $lessaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_lc, 0);
                $totalDagArea = ($bighaInDag * 100) + ($kathaInDag * 20) + $lessaInDag;

                // home
                $bighaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_b, 0);
                $kathaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_k, 0);
                $lessaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_lc, 0);
                $totalAppliedInDagHome = ($bighaInDagAppliedHome * 100) + ($kathaInDagAppliedHome * 20) + $lessaInDagAppliedHome;

                // Agri
                $bighaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_b, 0);
                $kathaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_k, 0);
                $lessaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_lc, 0);
                $totalAppliedInDagAgri = ($bighaInDagAppliedAgri * 100) + ($kathaInDagAppliedAgri * 20) + $lessaInDagAppliedAgri;

                if ($totalDagArea < $totalAppliedInDagHome + $totalAppliedInDagAgri)
                {
                    $appAreaMoreThanDagArray[] = 1;
                }
                $rezaDagTotal += $totalDagArea;
                $rezaAppTotalHome += $totalAppliedInDagHome;
                $rezaAppTotalAgri += $totalAppliedInDagAgri;
            }
        }

        if($rezaDagTotal < $rezaAppTotalHome + $rezaAppTotalAgri)
        {
            $appAreaMoreThanDagA = 1;
        }

        if(in_array(1,$appAreaMoreThanDagArray))
        {
            $appAreaMoreThanDagSingle = 1;
        }

        $dagArea = array(
            'appAreaMoreThanDagA'      => $appAreaMoreThanDagA,
            'appAreaMoreThanDagSingle' => $appAreaMoreThanDagSingle,
        );

        return $dagArea;



    }



    //////////////// *************** **************** ////////////////


    // 1st landing page NC Khas ADC
    public function NcKhasLandLandingPageAdc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $serviceCode     = NC_KHAS_LAND_ID;
        $user_desig_code = $this->session->userdata('user_desig_code');

        $firstProceedingCount = $this->NcCommonAdcModel->countAllPendingNcCasesAdc($dist_code,$serviceCode);
        $SDLACCommitteeCount  = $this->NcCommonSdoAdcDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACMarkedCount     = $this->NcCommonAdcModel->countMarkAsSDLACNcKhas($serviceCode,$dist_code);
        $SDLACConsideration   = $this->NcCommonAdcModel->countAllUnderConsiderationAppKhas($serviceCode,$dist_code);
        $coModificationCount  = $this->NcPullModel->countCoModificationRequestCaseForADC($dist_code,$serviceCode);
        $SDLACReportCount     = $this->NcCommonAdcModel->countAllProposalSendByDcToSdlacAdc($serviceCode,$dist_code);

        $data['dist_code']            = $dist_code;
        $data['firstProceedingCount'] = $firstProceedingCount;
        $data['SDLACCommitteeCount']  = $SDLACCommitteeCount;
        $data['SDLACMarkedCount']     = $SDLACMarkedCount;
        $data['SDLACConsideration']   = $SDLACConsideration;
        $data['coModificationCount']  = $coModificationCount;
        $data['SDLACReportCount']     = $SDLACReportCount;

        $data['_view'] = 'NcVillageService/Adc/khas/first_landing_page_khas_adc';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list Khas ADC
    public function viewNcKhasFirstProceedingCaseListAdc()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = NC_KHAS_LAND_ID;
        $pendingCase = $this->NcCommonAdcModel->countAllPendingNcCasesAdc($dist_code,$serviceCode);
        $getDistrict = $this->NcCommonSdoAdcDcModel->getLocationNameAdcDc($dist_code);
        $locations   = $getDistrict->result();

        $circleList = array();
        foreach ($locations as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->ncutility->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }

        $data['location']         = $circleList;
        $data['dist_code']        = $dist_code;
        $data['pendingCaseCount'] = $pendingCase;

        $data['_view'] = 'NcVillageService/Adc/khas/first_proceeding_case_khas_adc';
        $this->load->view('layouts/main', $data);
    }


    // paginate all first proceeding case list khas ADC
    public function firstProceedingPaginationAPIKhasAdc()
    {
        $service       = NC_KHAS_LAND_ID;
        $by_case_no    = trim($this->input->post('case_no'));
        $remark_cat    = trim($this->input->post('remark_cat'));
        $remark_cat_lm = trim($this->input->post('remark_cat_lm'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subDiv_code   = trim($this->session->userdata('subdiv_code'));
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = trim($this->session->userdata('user_desig_code'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');
        $adc_code      = trim($this->session->userdata('user_code'));

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
//            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)){
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)){
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.adc_code', $adc_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where_in('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('settlement_basic.vill_townprt_code', $village);
//                $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }
            if(!empty($remark_cat)){
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.adc_code', $adc_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where_in('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $co_remark ='';
                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                    if($rows->co_note_yn == $co_remark_cat->CODE){
                        $co_remark = $co_remark_cat->NAME;
                    }
                }
                $lm_remark ='';
                foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                    if($rows->lm_note == $lm_remark_cat->CODE){
                        $lm_remark = $lm_remark_cat->NAME;
                    }
                }

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->ncutility->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $lm_remark,

                    $co_remark,

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/NcKhasLandAdc/getNcKhasApplicationDetailsAdc/?case='.$rows->case_no.'">Process</a>',

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


    // nc application details Khas ADC
    public function getNcKhasApplicationDetailsAdc()
    {
        $application_no = trim($this->input->get('case'));
        $dist_code      = trim($this->session->userdata('dist_code'));
        $service_code   = NC_KHAS_LAND_ID;

        $this->ncutility->checkUserAuthForCaseForAdc($application_no);
        $this->ncutility->checkAssignAdcWithRollback($application_no);
        $caseCount = $this->NcCommonAdcModel->countNcApplicationDetailsByCaseNo($application_no,$dist_code,$service_code);
        if($caseCount == 0)
        {
            $this->session->set_flashdata('error', 'Case already processed !');
            redirect(base_url() . "index.php/NcKhasLandAdc/viewNcKhasFirstProceedingCaseListAdc");
        }

        $basic                 = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($application_no);
        $applicants_buyers     = $this->NcCommonSdoAdcDcModel->getAllNcApplicantBuyers($application_no);
        $applicants_owners     = $this->NcCommonSdoAdcDcModel->getAllNcApplicantOwners($application_no);
        $applicants_encroacher = $this->NcCommonSdoAdcDcModel->getAllNcApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->NcCommonSdoAdcDcModel->getAllNcApplicantRioteeNok($application_no);
        $dags                  = $this->NcCommonSdoAdcDcModel->getNcApplicationDag($application_no);
        $lmNotes               = $this->NcCommonSdoAdcDcModel->getNcLmNote($application_no);
        $proceedings           = $this->NcCommonSdoAdcDcModel->getNcApplicationProceeding($application_no);
        $documents             = $this->NcCommonSdoAdcDcModel->getNcDocuments($application_no);
        $nominee               = $this->NcCommonSdoAdcDcModel->getAllNcNomineeDetail($application_no);
        $premium_data          = $this->NcCommonSdoAdcDcModel->getNcPremium($application_no);
        $deleted_dags          = $this->NcCommonSdoAdcDcModel->getNcDeletedDags($application_no);

        $lmData = [];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $encData = $this->NcCommonSdoAdcDcModel->getAllNcEncroacherDetailsWithId($encroacher->enc_id);
            $lmData[] = $encData;
        }

        // for guardian relation
        $relation = $this->NcCommonSdoAdcDcModel->getNcGuardRelation();
        $row      = $relation->num_rows();
        if ($row != 0)
        {
            $data['guar_rel'] = $relation->result();
        }


        $data['premium_data']          = $premium_data;
        $data['premium']               = $premium_data;
        $data['encdata']               = $lmData;
        $data['basic']                 = $basic;
        $data['applicants_buyers']     = $applicants_buyers;
        $data['applicants_owners']     = $applicants_owners;
        $data['applicants_encroacher'] = $applicants_encroacher;
        $data['applicants_riotee_nok'] = $applicants_riotee_nok;
        $data['dags']                  = $dags;
        $data['lmnotes']               = $lmNotes;
        $data['proceedings']           = $proceedings;
        $data['dhardocuments']         = $documents;
        $data['nominee']               = $nominee;
        $data['deleted_dags']          = $deleted_dags;

        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);
        $caseDetails      = $this->NcCommonAdcModel->getNcApplicationDetailsByCaseNoAdc($application_no,$dist_code,NC_KHAS_LAND_ID);

        $data['chithaArea']    = $checkAreaDetails['chithaArea'];
        $data['reservedArea']  = $checkAreaDetails['reservedArea'];
        $data['areaCheck']     = $checkAreaDetails['areaCheck'];
        $data['appliedDags']   = $checkAreaDetails['appliedDags'];
        $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
        $data['caseCount']     = $caseCount;
        $data['caseDetails']   = $caseDetails;
        $data['reservation']   = $this->NcCommonSdoAdcDcModel->getNcReservation($application_no);

        $checkAppliedArea = $this->checkAppliedAreaMoreThanDagArea($application_no);

        $data['appAreaMoreThanDagArea']   = $checkAppliedArea['appAreaMoreThanDagA'];
        $data['appAreaMoreThanDagSingle'] = $checkAppliedArea['appAreaMoreThanDagSingle'];


        foreach($data['applicants_encroacher'] as $applicant_enc)
        {
            $enc_check = $this->NcCommonSdoAdcDcModel->getNcLandBankDetails($caseDetails->applid,$applicant_enc->dag_no);

            if($enc_check->num_rows() > 0)
            {
                $enc_Data = $enc_check->row();
                $sql_land_bank = $this->NcCommonSdoAdcDcModel->getNcLandBankDetailsWithVillage($enc_Data->land_bank_details_id, $enc_Data->uuid,$enc_Data->dag_no,$enc_Data->encroacher_id);
                if($sql_land_bank->num_rows() > 0)
                {
                    $added_enc_data[] = $sql_land_bank->row();
                }
            }
        }

        if(isset($added_enc_data))
        {
            $data['new_added_enc_data'] = $added_enc_data;
        }


        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc = $this->NcCommonSdoAdcDcModel->getNcDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $data['deleted_encroacher'] = $deletedEncArray;


        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags = $deleted_dags;
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $data['deleted_dags'] = $deletedData;


        $rejected_data = $this->NcCommonSdoAdcDcModel->getNcRejectModal(NC_KHAS_LAND_ID);
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
            if($val_bypas->SERVICE_CODE == NC_KHAS_LAND_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $data['additional_property'] = $this->NcCommonSdoAdcDcModel->getNcAdditionalProperty($application_no);

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
                $dagAreaLessa = $this->ncutility->Total_ganda(
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
                $additionalAreaLessa = $this->ncutility->Total_ganda(
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
                $dagAreaLessa = $this->ncutility->Total_Lessa(
                    $singleDag->s_dag_area_b,
                    $singleDag->s_dag_area_k,
                    $singleDag->s_dag_area_lc
                );
                $totalDagAreaLessaValidation += $dagAreaLessa;
            }
            foreach ($data['additional_property'] as $singleAdditionalDag)
            {
                $additionalAreaLessa = 0;
                $additionalAreaLessa = $this->ncutility->Total_Lessa(
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

        foreach($lmNotes as $r_remark)
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

                    $rejectedHead = $this->NcCommonSdoAdcDcModel->getNcRejectHead($r_code);
                    if($rejectedHead->remark_head != null)
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

        $data['_view'] = 'NcVillageService/Adc/khas/nc_case_details_khas_adc';
        $this->load->view('layouts/main', $data);

    }


    // Revert from ADC to CO
    public function applicationRevertFromAdcToCO()
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
            $case_no     = trim($this->input->post('caseNo'));
            $dist_code   = trim($this->session->userdata('dist_code'));
            $remarks     = trim($this->input->post('remarks'));
            $user_code   = trim($this->session->userdata('user_code'));
            $serviceCode = NC_KHAS_LAND_ID;

            $this->ncutility->checkUserAuthForCaseForAdc($case_no);
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                ));
                return;
            }

            $caseCount = $this->NcCommonAdcModel->countNcApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
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
                if($this->NcCommonSdoAdcDcModel->updateNcBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR0001333: Insertion failed in settlement_basic for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id = $this->NcCommonAdcModel->getProceedingIdAdcNc($case_no);
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
                        log_message('error', '#MR000473: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted by ADC';
                        $status='M';
                        $task=MB_ADD_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI00492: Reverted by ADC failed case no # $case_no");
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


    // Mark as SDLAC ADC
    public function markApplicationForSDLACAdc()
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
            $case_no     = trim($this->input->post('caseNo'));
            $dist_code   = trim($this->session->userdata('dist_code'));
            $user_code   = trim($this->session->userdata('user_code'));
            $serviceCode = NC_KHAS_LAND_ID;

            $this->ncutility->checkUserAuthForCaseForAdc($case_no);
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                ));
                return;
            }

            $caseCount = $this->NcCommonAdcModel->countNcApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

            if($checkArea != 0)
            {
                echo json_encode(array(
                    'responseType' => 10,
                ));
                return;
            }
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
                $wedLandStatus = $this->NcCommonSdoAdcDcModel->caseUnderDeptOrDCByWetLand($case_no);
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
                if($this->NcCommonSdoAdcDcModel->updateNcBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
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
                    $proceeding_id = $this->NcCommonAdcModel->getProceedingIdAdcNc($case_no);
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
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to' => MB_ADD_DEPUTY_COMM,
                        'task' => 'Recommended for SDLAC'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR00884: Insertion failed in settlement_proceeding for case no :'. $case_no);
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
                }
            }
        }
    }


    // Remove from mark as SDLAC ADC
    public function removeMarkApplicationForSDLACAdc()
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
            $case_no     = trim($this->input->post('caseNo'));
            $dist_code   = trim($this->session->userdata('dist_code'));
            $user_code   = trim($this->session->userdata('user_code'));
            $serviceCode = NC_KHAS_LAND_ID;
            $this->ncutility->checkUserAuthForCaseForAdc($case_no);

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
            $caseCount = $this->NcCommonAdcModel->countNcApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
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
                    'status'  => MB_PENDING,
                    'dc_code' => $user_code,
                    'dc_proceeding'   => 0,

                );
                $this->db->trans_begin();
                if($this->NcCommonSdoAdcDcModel->updateNcBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR00969: Insertion failed in settlement_basic for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////proceeding start//////
                    $proceeding_id = $this->NcCommonAdcModel->getProceedingIdAdcNc($case_no);
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
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to' => MB_ADD_DEPUTY_COMM,
                        'task' => 'Unmarked from SDLAC List'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR001002: Insertion failed in settlement_proceeding for case no :'. $case_no);
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


    // view all mark as SDLAC KHAS ADC
    public function viewAllMarkAsSDLACListForKhasAdc()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = NC_KHAS_LAND_ID;
        $getDistrict = $this->NcCommonSdoAdcDcModel->getLocationNameAdcDc($dist_code);
        $location    = $getDistrict->result();
        $commMembers = $this->NcCommonSdoAdcDcModel->getMembersFromUsersWithUserType($dist_code);

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->ncutility->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $data['location']         = $circleList;
        $data['committeeList']    = $commMembers;
        $data['dist_code']        = $dist_code;
        $data['cases']            = [];
        $data['pendingCaseCount'] = 0;


        $data['_view'] = 'NcVillageService/Adc/khas/mark_as_sdlac_case_khas_adc';
        $this->load->view('layouts/main', $data);

    }


    // pagination of Second proceeding SDLAC Recommended (Marked)
    public function secondProceedingSdlacRecommendedMarkedAdc()
    {
        $service       = NC_KHAS_LAND_ID;
        $by_case_no    = trim($this->input->post('case_no'));
        $remark_cat    = trim($this->input->post('remark_cat'));
        $approvedBy    = trim($this->input->post('approvedBy'));
        $dist_code     = $this->session->userdata('dist_code');
        $cir_code      = trim($this->input->post('circle'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');
        $adc_code      = trim($this->session->userdata('user_code'));
        $approved_by   = '';
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
        if(!empty($by_case_no)){
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)){
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('(select distinct on(case_no) case_no,is_urban from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('settlement_basic.adc_code', $adc_code);

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
        //        log_message('error',$this->db->last_query());
        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if(!empty($by_case_no)){
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }
            if(!empty($remark_cat)){
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('(select distinct on(case_no) case_no,is_urban from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
            $this->db->where_in('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_basic.adc_code', $adc_code);
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
            log_message('error', 'data'.json_encode($query1));

            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                $co_remark ='';
                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                    if($rows->co_note_yn == $co_remark_cat->CODE){
                        $co_remark = $co_remark_cat->NAME;
                    }
                }

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

                    '<span class="px-1"><strong>' . $i . '</strong></span>',

                    $this->ncutility->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $co_remark,

                    $rows->case_no."<br><span style='color:red; font-size:12px'>MB:".$rows->applid."</span>",

                    $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success btn-sm" href="'.base_url().'index.php/NcKhasLandAdc/getNcKhasApplicationDetailsAdc/?case='.$rows->case_no.'">View Application</a>'
                );

                $i++;
            }
//            log_message('error', 'last_query'.$this->db->last_query());
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




    // generate Proposal Id
    function generateProposalIdSequenceNo()
    {
        $proposalId = $this->db->query("select nextval('settlement_proposal_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    // send all application to SDLAC ADC
    public function sendAllMarkAppToSDLACByAdc()
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
            $hearingDate = $this->input->post('hearingDate');

            if(MEETING_PROPOSAL_SDLAC_NOTICE_HOLD_NC == 1)
            {
                if(date('Y-m-d H:i:s',strtotime(MEETING_PROPOSAL_SDLAC_NOTICE_DATE_NC)) < date('Y-m-d H:i:s',strtotime($hearingDate)))
                {
                    echo json_encode(array(
                        'responseType' => 4,
                        'response'     => 4,
                        'message'      => 'Maximum Date of processing '.MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW_NC
                    ));
                    return;
                }
            }

            $dist_code          = trim($this->session->userdata('dist_code'));
            $remarks            = trim($this->input->post('remarks'));
            $subDiv_code        = trim($this->session->userdata('subdiv_code'));
            $allSelectedList    = $this->input->post('selectedList');
            $allSelectedMem     = $this->input->post('selectedMem');
            $venue              = trim($this->input->post('venue'));
            $serviceCode        = NC_KHAS_LAND_ID;
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();


            $mm = 0;
            $nn = 0;
            $subDivArray = [];
            //check if all cases selected to be approved by either department(urban) or dc(rural)
            if(SELECTED_CASES_APPROVED_BY_DEPT_DC_NC == 1)
            {

                foreach ($allSelectedList as $case_no)
                {

                    $dag       = $this->NcCommonSdoAdcDcModel->getSettlementDagCommon($case_no);
                    $urbanByLm = $this->NcCommonSdoAdcDcModel->getLandFallsUnderUrban($case_no);
                    $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
                    if($modificationRequest == 1)
                    {
                        echo json_encode(array(
                            'responseType' => 101,
                            'response'     => 101,
                            'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                        ));
                        return;
                    }


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
            $getSdlcMember = $this->NcCommonSdoAdcDcModel->checkAvailabilitySdlcMemberDistrictWise($dist_code);
            if($getSdlcMember->num_rows() <= 0 || $getSdlcMember->num_rows() == '')
            {
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
                    $basic     = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
                    $this->ncutility->checkUserAuthForCaseForAdc($case_no);
                    $caseCount = $this->NcCommonAdcModel->countNcApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);
                    $caseIdSdlacProposal = $this->NcCommonSdoAdcDcModel->countNcApplicationByCaseNoInSdlacProList($case_no);

                    $subDivArray[] = $basic->subdiv_code;

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


                $uniqueArraySub  = array_unique($subDivArray);
                $subdivNameArray = [];
                foreach ($uniqueArraySub as $singleSub)
                {
                    $subdivNameOnly    = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$singleSub);
                    $subdivNameArray[] = $subdivNameOnly->locname_eng;
                }


                $subdiv_name = '';
                $indexN = 0;
                $ii = count($subdivNameArray);
                foreach ($subdivNameArray as $div)
                {
                    $indexN++;
                    if ($indexN == $ii)
                    {
                        $subdiv_name = $subdiv_name.trim($div);
                    }
                    else
                    {
                        $subdiv_name = $subdiv_name.trim($div). ", ";
                    }


                }


                if(count($errorArray) > 0)
                {
                    $case_str = '';
                    foreach ($errorArray as $err)
                    {
                        $case_str = $case_str.$err.', ';
                    }
                    echo json_encode(array(
                        'responseType' => 10,
                        'application'  => $case_str
                    ));
                    return;
                }

                $dist_name    = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
                $distEngName  = substr($dist_name->locname_eng, 0, 3);
                $proposalName = $distEngName.'/PROPOSAL-NC/'.date("Y").'/'.$proposalSequenceNo;

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

                $commMembers  = $this->NcCommonSdoAdcDcModel->getSelectedMembersFromUsers($dist_code,$allSelectedMember);
                if(empty($commMembers))
                {
                    echo json_encode(array(
                        'responseType' => 5,
                    ));
                    return;
                }

                echo json_encode(array(
                    'responseType'       => 2,
                    'caseList'           => $allSelectedList,
                    'hearingDate'        => date("F j, Y",strtotime($hearingDate)),
                    'timing'             => date("h:i a",strtotime($hearingDate)),
                    'remarks'            => $remarks,
                    'proposalSequenceNo' => $proposalSequenceNo,
                    'distName'           => $dist_name->locname_eng,
                    'subDivName'         => $subdiv_name,
                    'commMembers'        => $commMembers,
                    'venue'              => $venue,
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


    // random file name
    function randomFileName()
    {
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->NcCommonSdoAdcDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // generate proposal notice and save data KHAS ADC
    public function generateNoticeSendAllMarkAppToSDLACByDcKhasAdc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('selectedMem[]', 'Case Number', 'required');
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
            $hearingDate     = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $user_code       = trim($this->session->userdata('user_code'));
            $dist_code       = trim($this->session->userdata('dist_code'));
            $subDiv_code     = trim($this->session->userdata('subdiv_code'));
            $remarks         = trim($this->input->post('remarks'));
            $allSelectedList = $this->input->post('selectedList');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $proposal_id     = trim($this->input->post('proposal_id'));
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
                $proposalName = $distEngName.'/PROPOSAL-NC/'.date("Y").'/'.$proposal_id;
                $serviceCode  = NC_KHAS_LAND_ID;

                // save data into proposal list
                $dataProSave = array(
                    'id'              => $proposal_id,
                    'dist_code'       => $dist_code,
                    'user_code'       => $user_code,
                    'status'          => 1,
                    'proposal_status' => 1,
                    'h_date'          => $hearingDate,
                    'remarks'         => $remarks,
                    'ip'              => $this->input->ip_address(),
                    'file_path'       => $base_64_file_path,
                    'created_by'      => MB_ADD_DEPUTY_COMM,
                    'subdiv_code'     => $subDiv_code,
                    'proposal_name'   => strtoupper($proposalName),
                    'nc'              => 1,
                    'service_code'    => $serviceCode,

                );
                $this->db->trans_begin();
                if($this->NcCommonSdoAdcDcModel->saveProposalSDLACCases($dataProSave) == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR002075: Insertion failed in settlement_proposal_list ');
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
                        if($ins != 1 || $ins != true )
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002185: Insertion failed in sdlac_present_member for 
                            proposal no : '.$proposal_id. ' and query is '. $this->db->last_query());
                            $json = [
                                'response' => 1,
                                'message'  => '#ERMR002185: SDLAC/CDLAC Member not added. Kindly contact system administrator',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }


                    foreach ($allSelectedList as $row)
                    {
                        $case_no = $row;
                        $this->ncutility->checkUserAuthForCaseForAdcWithRollback($case_no);
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

                        $saveCaseList = array(
                            'proposal_id' => $proposalId,
                            'case_no'     => $case_no,
                            'status'      => 1,
                            'ip'          => $this->input->ip_address(),
                            'nc'          => 1,

                        );
                        if($this->NcCommonSdoAdcDcModel->saveProposalCaseListSDLAC($saveCaseList) == 0)
                        {
                            //$this->SettlementMbSdoModel->deleteProposalSDLAC($proposalId);

                            $this->db->trans_rollback();
                            log_message('error', '#MR002099: Insertion failed in settlement_proposal_cases ');
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

                        if($this->NcCommonSdoAdcDcModel->updateNcBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MR002118: Insertion failed in settlement_basic for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        else
                        {
                            //////proceeding start//////
                            $proceeding_id = $this->NcCommonAdcModel->getProceedingIdAdcNc($case_no);
                            if($proceeding_id == null or $proceeding_id==0)
                            {
                                $proceeding_id=1;
                            }
                            $insPetProceed = [
                                'case_no'              => $case_no,
                                'proceeding_id'        => $proceeding_id,
                                'date_of_hearing'      => date('Y-m-d h:i:s'),
                                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                                'status'               => MB_SEND_TO_SDLAC,
                                'user_code'            => $this->session->userdata('user_code'),
                                'date_entry'           => date('Y-m-d h:i:s'),
                                'operation'            => 'E',
                                'note_on_order'        => 'Send to SDLAC',
                                'ip'                   => $this->utilityclass->get_client_ip(),
                                'office_from'          => MB_ADD_DEPUTY_COMM,
                                'office_to'            => MB_ADD_DEPUTY_COMM,
                                'task'                 => 'Send to SDLAC'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if($insertProceeding != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR002152: Insertion failed in settlement_proceeding for case no :'. $case_no);
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


    // get all SDLAC Under consideration KHAS Adc
    public function getAllUnderConSdlacKhasAdc()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subDiv_code = trim($this->session->userdata('subdiv_code'));
        $serviceCode = NC_KHAS_LAND_ID;
        $pendingCase = $this->NcCommonAdcModel->getAllUnderConSettlementAdc($serviceCode,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'NcVillageService/Adc/khas/under_consideration_case_khas_adc';
        $this->load->view('layouts/main', $data);
    }


    // get all proposal list for KHAS ADC
    public function getAllProposalListSdlacKhasAdc()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = NC_KHAS_LAND_ID;
        $pendingCase = $this->NcCommonAdcModel->getAllProposalSendByDcToSdlacKhasAdc($serviceCode,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'NcVillageService/Adc/khas/proposal_list_send_to_sdlac_khas_adc';
        $this->load->view('layouts/main', $data);
    }


    //pagination of third proceeding SDLAC Report
    public function thirdProceedingSdlacReportAdc()
    {
        $service      = trim($this->input->post('service'));
        $by_case_no   = trim($this->input->post('case_no'));
        $proposal_no  = trim($this->input->post('proposal_no'));
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = trim($this->session->userdata('dist_code'));
        $subdiv_code  = trim($this->session->userdata('subdiv_code'));
        $ru           = trim($this->session->userdata('user_desig_code'));
        $adc_code      = trim($this->session->userdata('user_code'));

        if($hdate != false && $hdate != '')
        {
            $hearing_date = date('Y-m-d', $hdate);
        }

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

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
            $this->db->where('settlement_proposal_list.nc', 1);
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
            $this->db->where('settlement_proposal_list.user_code', $adc_code);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
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
            $this->db->where('nc', 1);
            $this->db->where('user_code', $adc_code);
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
            $this->db->where('nc', 1);
            $this->db->where('user_code', $adc_code);
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
            $this->db->where('nc', 1);
            $this->db->where('user_code', $adc_code);
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
                $this->db->where('settlement_proposal_list.nc', 1);
                $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_list.user_code', $adc_code);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
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
                $this->db->where('nc', 1);
                $this->db->where('user_code', $adc_code);
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
                $this->db->where('nc', 1);
                $this->db->where('user_code', $adc_code);
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
                $this->db->where('nc', 1);
                $this->db->where('user_code', $adc_code);
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

                    '<a class="btn btn-sm btn-primary" target= "SDLACProposalNotice" href="'.base_url().'index.php/NcCommonSdoAdcDc/getProposalNotice/?case='.$rows->id.'">Print Notice</a>
                        
                     <a class="btn btn-sm btn-dark" target= "SDLACProposalNotice" href="'.base_url().'index.php/NcCommonSdoAdcDc/downloadCasesWithProposalId/?case='.$rows->id.'">Download</a>
        
                     <a class="btn btn-sm btn-success" href="'.base_url().'index.php/NcKhasLandAdc/getAllApplicationInReportSendByDcToSdlacKhasAdc/?case='.$rows->id.'">
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


    // get case no by proposal id
    public function getCasesAgainstProposalNo()
    {
        $proposal_id  = $this->input->post('id');
        $service_code = $this->input->post('service_code');
        $dist_code    = $this->session->userdata('dist_code');

        $result = $this->NcCommonAdcModel->getCasesAgainstProposalIdAdc($proposal_id, $dist_code, $service_code, MB_ADD_DEPUTY_COMM);

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }



    // get all application send by ADC to sdlac for report KHAS
    public function getAllApplicationInReportSendByDcToSdlacKhasAdc()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->NcCommonAdcModel->getAllAppInReportSendByDcToSdlacKhasAdc($proposal_no);
        $proposalDetails = $this->NcCommonAdcModel->getProposalDetailsById($proposal_no,$dist_code);


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
            $cases_id   = array();

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

        $data['_view'] = 'NcVillageService/Adc/khas/send_to_sdlac_case_dc_khas_adc';
        $this->load->view('layouts/main', $data);

    }



    //check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus()
    {
        $proposal_id   = trim($this->input->post('prop_id'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $processStatus = $this->NcCommonAdcModel->getCheckForSdlacMemberStatus($dist_code,$proposal_id,MB_ADD_DEPUTY_COMM);

        if($processStatus->num_rows() == 0 )
        {
            $json = [
                'response' => 1,
                'message'  => 'Already send to SDLAC members',
            ];
            echo json_encode($json);
            return false;
        }
        else
        {
            $json = [
                'response' => 2,
            ];
            echo json_encode($json);

            return;
        }
    }


    // SDLAC Report status send to SDLAC Minutes
    public function sdlacReportOnlineApprove()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $detail        = $this->input->post('data');
        $proposal_id   = trim($this->input->post('proposal_id'));
        $service_code  = trim($this->input->post('service_code'));

        if(count($detail) == 0)
        {
            echo json_encode(array(
                'response' => 1,
                'message'  => '#ER-JM2496: There is no case found. Kindly contact system administrator',

            ));
            return;
        }
        if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRP0001375: You are not authorized for this Application ',
            ]);
            return false;
        }

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
                    $rejReasonArr  = $getRejectedReasonSql->result();
                    $rejReasonArr1 = array();
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
            $this->db->where('nc', 1);
            $this->db->update('settlement_proposal_cases', $updateData);

            if($this->db->affected_rows() <= 0 )
            {
                $this->db->trans_rollback();
                log_message('error', 'Updation failed in settlement_proposal_cases '.$this->db->last_query());
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
        $this->db->where('nc', 1);
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










}