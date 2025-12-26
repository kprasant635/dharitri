<?php
class OfflineSettlementSdoController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->load->model('OfflineSettlementModel/OfflineCommonModel');
        $this->offlineutility->dbSwitchSession();


    }


    //// ******************* 29-05-2024 / Masud Reza *************************

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }




    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {
        $dist_code = trim($this->session->userdata('dist_code'));
        $dags      = $this->OfflineCommonModel->getOfflineSettlementDagDetails($dist_code,$application_no);

        $totalAreaInChitha[]    = 0;
        $appAreaInApplication   = 0;
        $areaCheck              = 0;
        $chithaDagArray         = [];
        $lmProcessArea          = [];
        $allApplicationDagArray = [];
        $appliedDags            = $dags;
        $basic                  = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$application_no);

        foreach ($dags as $dag)
        {
            $totalAreaInApplication        = 0;
            $totalAreaInLMApplication      = 0;
            $totalAppliedAreaInApplication = 0;
            $appDistrict                   = $dag->dist_code;
            $appSubDiv                     = $dag->subdiv_code;
            $appCircle                     = $dag->cir_code;
            $appMouza                      = $dag->mouza_pargona_code;
            $appLot                        = $dag->lot_no;
            $appVillage                    = $dag->vill_townprt_code;
            $appDag                        = $dag->dag_no;
            $appPattaType                  = $dag->patta_type_code;
            $appPatta                      = $dag->patta_no;

            $chithaDag = $this->OfflineCommonModel->getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag);

            $allApplicationDags = $this->OfflineCommonModel->getAllDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            //  all lm processing application but  SDO/ADC/DC not proceeded
            $allLmProcess = $this->OfflineCommonModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);


            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_g, 0);

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
                            $bighaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_g, 0);
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
                $bighaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->OfflineCommonModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->OfflineCommonModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->OfflineCommonModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
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
                            $bighaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->OfflineCommonModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
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

            $lmProcessArea[]          = $allLmProcess;
            $chithaDagArray[]         = $chithaDag;
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



    // view all pending application for CO
    public function getPendingApplicationListSdo()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subDiv_code = trim($this->session->userdata('subdiv_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $pendingApplication = $this->OfflineCommonModel->getPendingOfflineApplicationListSdo($dist_code,$subDiv_code,$serviceCode);

        $data['applicationCount'] = $pendingApplication->num_rows();
        $data['applications']     = $pendingApplication->result();

        $data['_view'] = 'OfflineSettlement/Sdo/pending_offline_application_list_sdo';
        $this->load->view('layouts/main', $data);

    }



    // get application
    public function getKhasApplicationDetailsSdo()
    {
        $caseNoEn  = $this->input->get('app');
        $caseNo    = $this->offlineutility->decryptJwtCase($caseNoEn);
        $dist_code = trim($this->session->userdata('dist_code'));
        $sub_code  = trim($this->session->userdata('subdiv_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        // check application
        if($this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$caseNo) != 1)
        {
            $errors = '#MROFC0001: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');

        }

        // application details
        $application = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);

        $serviceCode = $application->service_code;
        if(!in_array($serviceCode, OFFLINE_SERVICE_CODE_ALLOW))
        {
            $errors = '#MROFC0002: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');

        }

        // applicant details
        $applicants = $this->OfflineCommonModel->getApplicantOfflineApplication($dist_code,$caseNo);

        // encroacher details
        $applicants_encroacher = $this->OfflineCommonModel->getAllApplicantEncroacher($caseNo);

        // getting the deleted settlement_dag_details data from settlement_deleted_data table
        $deletedEnc = $this->OfflineCommonModel->getDeletedEncroacher($caseNo);

        foreach($applicants_encroacher as $en)
        {
            $sqlVlbEntryQuery = $this->OfflineCommonModel->getLandBankData($caseNo, $en->dag_no, $application->uuid);
            if($sqlVlbEntryQuery->num_rows() > 0)
            {
                $vlbData = $sqlVlbEntryQuery->row();
                $settlement_land_bank_details[] = $vlbData;
                $vlb_encroacher_added_check[]   = $vlbData->dag_no;

                $land_bank_status[] = $this->OfflineCommonModel->getSelectedLandBankData($vlbData->land_bank_details_id);
            }
            else
            {
                $settlement_land_bank_details[] = false;
                $vlb_encroacher_added_check[]   = false;
                $land_bank_status[]             = false;
            }
        }


        // dag details
        $dags = $this->OfflineCommonModel->getOfflineSettlementDagDetails($dist_code,$caseNo);

        // getting the settlement_applicant occupiers data from settlement_deleted_data table
        $deletedData = $this->OfflineCommonModel->getDeletedDags($caseNo);

        // family member details
        $nominee = $this->OfflineCommonModel->getAllNomineeDetail($caseNo);

        // for guardian relation
        $relations = $this->OfflineCommonModel->getGuardianRelation($dist_code,$caseNo);

        // document
        $documents   = $this->OfflineCommonModel->getDocuments($caseNo);
        $documentsLm = $this->OfflineCommonModel->getDocumentsTraceMapFieldMap($caseNo);

        // application proceeding
        $proceedings = $this->OfflineCommonModel->getOfflineApplicationProceeding($caseNo);

        // premium details
        $premium = $this->OfflineCommonModel->getOfflineAppPremium($caseNo);

        // LM Note
        $lmNotes = $this->OfflineCommonModel->getNcLmNote($caseNo);

        // reservation area
        $reservation = $this->OfflineCommonModel->getSettlementReservation($caseNo);

        // additional property
        $additional_property = $this->OfflineCommonModel->getAdditionalProperty($caseNo);
        if ($additional_property->num_rows() > 0)
        {
            $totallesaa = 0;
            $totalganda = 0;
            foreach ($additional_property->result() as $addprop)
            {
                if (in_array($addprop->dist_code, json_decode(BARAK_VALLEY))) {
                    $total_g = $this->offlineutility->Total_ganda($addprop->bigha, $addprop->katha, $addprop->lessa, $addprop->ganda);
                    $totalganda = $totalganda + $total_g;
                } else {
                    $total_l = $this->offlineutility->Total_Lessa($addprop->bigha, $addprop->katha, $addprop->lessa);
                    $totallesaa = $totallesaa + $total_l;
                }
            }
            if (!empty($totallesaa))
            {
                $data['total_aditional_area'] = $this->offlineutility->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if (!empty($totalganda))
            {
                $data['total_aditional_area_g'] = $this->offlineutility->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $data['additional_property'] = $additional_property->result();
        }

        // area modification
        $areaModificationCheck = $this->OfflineCommonModel->checkIfAreaModified($caseNo);
        if(isset($areaModificationCheck)){
            if($areaModificationCheck)
            {
                foreach($areaModificationCheck as $areaHis)
                {
                    $applied_area_home_bigha     = $areaHis->applied_area_home_bigha;
                    $applied_area_home_katha     = $areaHis->applied_area_home_katha;
                    $applied_area_home_lessa     = $areaHis->applied_area_home_lessa;
                    $applied_area_home_ganda     = $areaHis->applied_area_home_ganda;
                    $applied_area_agri_bigha     = $areaHis->applied_area_agri_bigha;
                    $applied_area_agri_katha     = $areaHis->applied_area_agri_katha;
                    $applied_area_agri_lessa     = $areaHis->applied_area_agri_lessa;
                    $applied_area_agri_ganda     = $areaHis->applied_area_agri_ganda;
                    $settlement_area_home_bigha  = $areaHis->settlement_area_home_bigha;
                    $settlement_area_home_katha  = $areaHis->settlement_area_home_katha;
                    $settlement_area_home_lessa  = $areaHis->settlement_area_home_lessa;
                    $settlement_area_home_ganda  = $areaHis->settlement_area_home_ganda;
                    $settlement_area_agri_bigha  = $areaHis->settlement_area_agri_bigha;
                    $settlement_area_agri_katha  = $areaHis->settlement_area_agri_katha;
                    $settlement_area_agri_lessa  = $areaHis->settlement_area_agri_lessa;
                    $settlement_area_agri_ganda  = $areaHis->settlement_area_agri_ganda;

                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                        $total_applied_area_home_in_ganda    = $this->ncutility->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda    = $this->ncutility->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->ncutility->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->ncutility->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda))
                        {
                            $data['area_modified'] = $areaModificationCheck;
                        }
                    }
                    else
                    {
                        $total_applied_area_home_in_lessa    = $this->ncutility->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa    = $this->ncutility->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->ncutility->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->ncutility->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa))
                        {
                            $data['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }


        // check if SDO exist for that area
        $headQtrCheck = $this->OfflineCommonModel->headquarterCheck($dist_code,$sub_code);
        if(trim($headQtrCheck) != 'Y')
        {
            $sdoCheckResult = $this->OfflineCommonModel->userCheckSDO($dist_code,$sub_code);
            if(trim($sdoCheckResult) == 'y')
            {
                $data['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $data['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $data['sdo_user_check'] = 'y';
        }

        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($caseNo);

        $data['chithaArea']    = $checkAreaDetails['chithaArea'];
        $data['reservedArea']  = $checkAreaDetails['reservedArea'];
        $data['areaCheck']     = $checkAreaDetails['areaCheck'];
        $data['appliedDags']   = $checkAreaDetails['appliedDags'];
        $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
        $data['guar_rel']      = $relations;
        $data['case_no']       = $caseNo;
        $data['basic']         = $application;
        $data['applicants']    = $applicants;
        $data['dags']          = $dags;
        $data['dag_count']     = count($dags);
        $data['nominee']       = $nominee;
        $data['deleted_dags']  = $deletedData;
        $data['documents']     = $documents;
        $data['documentsLm']   = $documentsLm;
        $data['proceedings']   = $proceedings;
        $data['premium_data']  = $premium;
        $data['premium']       = $premium;
        $data['lmnotes']       = $lmNotes;
        $data['reservation']   = $reservation;
        $data['validation_bypass']               = 0;
        $data['applicants_encroacher']           = $applicants_encroacher;
        $data['deleted_encroacher']              = $deletedEnc;
        $data['land_bank_status']                = $land_bank_status;
        $data['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
        $data['settlement_land_bank_details']    = $settlement_land_bank_details;

        $data['_view'] = 'OfflineSettlement/Sdo/offline_application_details_sdo';
        $this->load->view('layouts/main', $data);

    }




}