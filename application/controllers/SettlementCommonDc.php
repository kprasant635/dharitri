<?php



class SettlementCommonDc extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('NcModel/NcServiceModel');
        $this->load->model('Bhoodan/ADC/BhoodanAdcModel');
        $this->load->model('Bhoodan/BhoodanModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('basundhara3/ReclassCommonDcModel');
        $this->load->model('basundhara3/reclassSuiteADCModel');
        $this->load->model('basundhara3/reclassModel');
        $this->load->model('basundhara3/reclassPullModel');
        $this->load->model('SettlementMb/SettlementTenantUrbanDcModel');

        $method = $this->router->fetch_method();

        if(!in_array($method, VERIFICATION_MODULE_METHODS))
        {
            if(HOLD_All_MB2_CASES_STATUS == 1)
            {
                if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
                {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }

        $allowed = ['DC','ADC','CO','LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
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
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }



    // checking login user access
    public function checkingLoginUserAccessAdcDcUser()
    {
        $allowed = ['DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
    }


    // checking login user access
    public function checkingLoginUserAccessSingleUserOnlyDC()
    {
        $allowed = [MB_DEPUTY_COMM];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
    }


    // checking login user access
    public function checkingLoginUserAccessSingleUserOnlyADC()
    {
        $allowed = [MB_ADD_DEPUTY_COMM];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
    }




    // New MB2 code by Masud Reza


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



    // modification request check with redirect
    public function checkCaseInModificationRequest($caseNo)
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($caseNo);

        if($basic->pull_request == 1)
        {
            $service_code = trim($basic->service_code);
            $pendingWith  = trim($basic->pending_officer);
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
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_ADD_DEPUTY_COMM)
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


    // case search page
    public function getCaseSearchCommon()
    {
        $dist_code = $this->session->userdata('dist_code');
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng 
        from location where dist_code='$dist_code' and cir_code!='00' and  mouza_pargona_code='00' and  
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data['circles']    = $circle->result();
        $data['dist_code']  = $dist_code;
        $data['cases']      = '';
        $data['casesCount'] = 0;

        $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
        $this->load->view('layouts/main', $data);

    }


    // search data
    public function searchCasesWithData()
    {
        $caseNo        = trim($this->input->post('caseNo'));
        $applicationNo = trim($this->input->post('applicationNo'));
        $serviceType   = trim($this->input->post('serviceType'));
        $appStatus     = trim($this->input->post('appStatus'));
        $pendingOffice = trim($this->input->post('pendingOffice'));
        $fromDate      = trim($this->input->post('fromDate'));
        $toDate        = trim($this->input->post('toDate'));
        $selectCircle  = trim($this->input->post('selectCircle'));
        $dist_code     = $this->session->userdata('dist_code');
        $rezaBhai      = 0;
        $cases         = '';
        $casesCount    = 0;

        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng 
                from location where dist_code='$dist_code' and cir_code!='00' and  mouza_pargona_code='00' and  
                vill_townprt_code='00000' and lot_no='00' order by loc_name ");
        $data['circles']   = $circle->result();
        $data['dist_code'] = $dist_code;


        if($applicationNo == 'RTPS-OMUT/2022/12649' || $caseNo == 'GOL/DER/2022-23/7767/OMUT')
        {
            $this->load->model('CurlModel');
            $applId = '20471416';

            $get_attachement_api_link = "https://landhub.assam.gov.in/webapi/dhar_api_land/mutation/mutation_case_details.php?application_ref_no=$applicationNo&applid=$applId";

            $api_response = $this->CurlModel->apiCall($get_attachement_api_link);

            $data['files'] = $api_response["data"][0]->attachment;
            $data['_view'] = 'settlementView/Dc/Common/get_Attachment_List';
            $this->load->view('layouts/main', $data);
        }



        if ($caseNo == '' AND $applicationNo == '' AND $serviceType == '' AND $appStatus == '' AND $pendingOffice == '' AND $fromDate == '' AND $toDate == '' AND $selectCircle == '' )
        {
            $data['cases']      = '';
            $data['casesCount'] = 0;
            $data['reClass']    = $rezaBhai;

            $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            // only case number
            if($caseNo != '')
            {
                $cases = $this->SettlementCommonDcModel->getCasesByCaseNo($caseNo);
                if($cases->num_rows() == 0)
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByCaseNoReCla($caseNo);
                    $rezaBhai = 1;
                }
                $data['cases']      = $cases->result();
                $data['casesCount'] = $cases->num_rows();
                $data['reClass']    = $rezaBhai;

                $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                $this->load->view('layouts/main', $data);
            }
            elseif ($applicationNo != '')
            {
                $cases = $this->SettlementCommonDcModel->getCasesByApplicationNo($applicationNo);
                if($cases->num_rows() == 0)
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByApplicationNoReCla($caseNo);
                    $rezaBhai = 1;
                }
                $data['cases']      = $cases->result();
                $data['casesCount'] = $cases->num_rows();
                $data['reClass']    = $rezaBhai;

                $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                $this->load->view('layouts/main', $data);
            }
            else
            {
                if($fromDate != '' AND $toDate != '')
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByRespectedDataWithDateRage
                    ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);

                    $data['cases']      = $cases->result();
                    $data['casesCount'] = $cases->num_rows();
                    $data['reClass']    = $rezaBhai;

                    $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                    $this->load->view('layouts/main', $data);
                }
                else
                {

                    if($serviceType == RECLASS_ID)
                    {
                        $cases = $this->SettlementCommonDcModel->getCasesByRespectedDataReCla
                        ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);
                        $rezaBhai = 1;
                    }
                    else
                    {
                        $cases = $this->SettlementCommonDcModel->getCasesByRespectedData
                        ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);
                    }


                    $data['cases']      = $cases->result();
                    $data['casesCount'] = $cases->num_rows();
                    $data['reClass']    = $rezaBhai;

                    $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                    $this->load->view('layouts/main', $data);
                }
            }
        }
    }


    // view Application details
    public function viewApplicationDetailsOnly()
    {

        if (strlen($_GET['case']) > 30)
        {
            $_GET['case'] = dec_param($this->input->get('case'), 'case');
            if($_GET['case'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no        = $_GET['case'];
            $application_no = $_GET['case'];
        }
        else
        {
            $case_no        = trim($this->input->get('case'));
            $application_no = trim($this->input->get('case'));
        }

        $dist_code      = trim($this->session->userdata('dist_code'));
        $caseCount      = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        $caseCountReCla = $this->ReclassCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);


        if($caseCount == 0 AND $caseCountReCla == 0)
        {
            $this->getCaseSearchCommon();
        }
        else
        {
            if($caseCount == 0)
            {
                $caseDetails = $this->ReclassCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            }
            if($caseCountReCla == 0)
            {
                $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            }

            $inArr = 0;
            if (in_array($caseDetails->service_code, MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if (in_array($caseDetails->service_code, MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if (in_array($caseDetails->service_code, NC_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if ($caseDetails->service_code == RECLASS_ID)
            {
                $inArr = 1;
            }
            if ($caseDetails->service_code == SETTLEMENT_TENANT_URBAN_ID)
            {
                $inArr = 1;
            }
            if ($caseDetails->service_code == TEA_SERVICE_CODE)
            {
                $inArr = 1;
            }

            if($inArr == 0)
            {
                echo 'Coming soon';
                die();
            }


            // khas land
            if($caseDetails->service_code == SETTLEMENT_KHAS_LAND_ID)
            {
                $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
                $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;

                }
                $data['encdata']=$lmdata;

                $data['basic']=$basic;

                $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['dhardocuments']=$dhardocuments;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;
                $data['premium'] = $this->SettlementCommonModel->getPremium($application_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_KHAS_LAND_ID)
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

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'settlementView/Dc/Common/application_details_common_khas';
                $this->load->view('layouts/main', $data);
            }

            // Ap Transfer
            if($caseDetails->service_code == SETTLEMENT_AP_TRANSFER_ID)
            {
                $basic   = $this->SettlementApModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementApModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementApModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementApModel->getAllApplicantEncroacher($application_no);
                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);

                $dags   = $this->SettlementApModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementApModel->getSettlementApLmNote($application_no);
                $proceedings   = $this->SettlementApModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementApModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
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
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }

                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
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

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'settlementView/Dc/Common/application_details_common_ap';
                $this->load->view('layouts/main', $data);

            }

            // tribal
            if($caseDetails->service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID)
            {
                $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementTribalModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementTribalModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementTribalModel->getDocuments($application_no);

                $data['basic']=$basic;

                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;

                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
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
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TRIBAL_COMMUNITY_ID);
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


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }

                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tribal';
                $this->load->view('layouts/main', $data);

            }

            // special cultivator tea
            if($caseDetails->service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID)
            {
                $basic   = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementKhasModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementKhasModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
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

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->SettlementCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
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


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }

                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tea';
                $this->load->view('layouts/main', $data);

            }

            // vgr pgr
            if($caseDetails->service_code == SETTLEMENT_PGR_VGR_LAND_ID)
            {

                $basic   = $this->SettlementVgrModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
                $reservation   = $this->SettlementVgrModel->getSettlementReservation($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    if($encroacher->enc_id==null || $encroacher->enc_id==""){

                        $this->session->set_flashdata('message', "Case no # $encroacher->case_no encroacher not avaialble");
                        redirect(base_url() . 'index.php/Home/index');

                    }else{

                        $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                        // echo $query; die();
                        $encdata=$this->db->query($query)->result();



                        $data[] = $encdata;
                    }

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementVgrModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementVgrModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementVgrModel->getDocuments($application_no);
                $vgrReservation = $this->SettlementVgrModel->getSettlementVgrReservation($application_no);

                $data['basic']=$basic;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;
                $data['reservation']=$reservation;
                $data['vgrReservation']=$vgrReservation;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
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
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_PGR_VGR_LAND_ID);
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
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_PGR_VGR_LAND_ID)
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


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'SettlementView/Dc/Common/application_vgr_view';
                $this->load->view('layouts/main',$data);
            }

            // tenant
            if($caseDetails->service_code == SETTLEMENT_TENANT_ID)
            {
                $basic   = $this->SettlementTenantModel->getSettlementBasic($application_no);
                //  result
                $applicants_buyers = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok   = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);

                $dags   = $this->SettlementTenantModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementTenantModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementTenantModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;
                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
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
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
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


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';

                }

                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tenant';
                $this->load->view('layouts/main', $data);

            }


            // MB3

            // Institution land
            if($caseDetails->service_code == SLIJE_ID)
            {
                $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
                $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;

                }
                $data['encdata']=$lmdata;

                $data['basic']=$basic;

                $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['dhardocuments']=$dhardocuments;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;
                $data['premium'] = $this->db->query("SELECT *  from settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SLIJE_ID)
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

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }
                $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($application_no));

                $data['ins_data'] = $sql->result();
                $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($application_no);

                $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();
                $data['_view'] = 'settlementView/Dc/Common/application_details_common_ins';
                $this->load->view('layouts/main', $data);
            }

            // Bhoodan land
            if($caseDetails->service_code == BHODDAN_SERVICE_CODE)
            {

                $basic = $this->BhoodanModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->BhoodanModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->BhoodanModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->BhoodanModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->BhoodanModel->getAllApplicantRioteeNok($application_no);
                $dags = $this->BhoodanModel->getSettlementDag($application_no);
                $lmnotes = $this->BhoodanModel->getSettlementTenantLmNote($application_no);
                $proceedings = $this->BhoodanModel->getSettlementProceeding($application_no);
                $dhardocuments = $this->BhoodanModel->getDocuments($application_no);
                $nominee = $this->BhoodanModel->getAllNomineeDetail($application_no);

                $lmdata = [];
                foreach ($applicants_encroacher as $encroacher) {
                    // getting the encroacher details
                    $query = "select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata = $this->db->query($query)->result();
                    $lmdata[] = $encdata;
                }

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }


                $premium_data = $this->SettlementCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;
                $data['encdata'] = $lmdata;
                $data['basic'] = $basic;
                $data['applicants_buyers'] = $applicants_buyers;
                $data['applicants_owners'] = $applicants_owners;
                $data['applicants_encroacher'] = $applicants_encroacher;
                $data['applicants_riotee_nok'] = $applicants_riotee_nok;
                $data['dags'] = $dags;
                $data['lmnotes'] = $lmnotes;
                $data['proceedings'] = $proceedings;
                $data['dhardocuments'] = $dhardocuments;
                $data['nominee'] = $nominee;
                $data['deleted_dags'] = $this->SettlementCommonModel->getDeletedDags($application_no);

                $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
                $data['caseCount']     = $caseCount;
                $data['caseDetails']   = $caseDetails;
                $data['proceedings']   = $proceedings;



                $data['reservation']   = $this->SettlementVgrModel->getSettlementReservation($application_no);

                foreach ($data['applicants_encroacher'] as $applicant_enc)
                {
                    $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

                    if ($enc_check->num_rows() > 0) {

                        $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid, $enc_check->row()->dag_no, $enc_check->row()->encroacher_id));

                        // echo $this->db->last_query();
                        if ($sql_land_bank->num_rows() > 0) {
                            $added_enc_data[] = $sql_land_bank->row();
                        }
                    }
                }



                if (isset($added_enc_data)) {
                    $data['new_added_enc_data'] = $added_enc_data;
                }

                $data['additional_property'] = $this->BhoodanModel->getAdditionalProperty($application_no);
                $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

                if (isset($areaModificationCheck)) {
                    if ($areaModificationCheck) {
                        foreach ($areaModificationCheck as $areaHis) {
                            $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                            $applied_area_home_katha = $areaHis->applied_area_home_katha;
                            $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                            $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                            $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                            $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                            $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                            $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                            $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                            $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                            $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                            $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                            $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                            $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                            $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                            $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                            $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                            $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                            $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                            $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                                $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                                $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                                $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                                $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                                if (($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)) {

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            } else {
                                $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                                $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                                $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                                $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                                //check if area modified
                                if (($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)) {

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            }
                        }
                    }
                }

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc = $this->SettlementCommonModel->getDeletedEncroacher($application_no);
                $deletedEncArray = array();
                foreach ($deletedEnc as $encroacherDeleted_data) {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags = $this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach ($deletedDags as $deleteDag) {
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(BHODDAN_SERVICE_CODE);
                if ($rejected_data == 'n') {
                    $data['rejected_list'] = false;
                } else {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach (json_decode(VALIDATION_BYPASS_BHOODAN) as $val_bypas) {
                    if ($val_bypas->SERVICE_CODE == BHODDAN_SERVICE_CODE) {
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
                    foreach ($data['additional_property'] as $singleAdditionalDag) {
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
                    if ((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea) {
                        $checkArea = 1;
                    }
                }
                else {
                    foreach ($data['dags'] as $singleDag) {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag) {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if ((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
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

                foreach ($lmnotes as $r_remark)
                {
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

                $data['checkAppliedArea'] = $checkArea;
                $data['_view'] = 'Bhoodan/ADC/bhoodan_app_details_only';
                $this->load->view('layouts/main', $data);

            }

            // NC khas land
            if($caseDetails->service_code == NC_KHAS_LAND_ID)
            {

                $service_code          = NC_KHAS_LAND_ID;
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

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
                $data['caseCount']     = $caseCount;
                $data['caseDetails']   = $caseDetails;
                $data['reservation']   = $this->NcCommonSdoAdcDcModel->getNcReservation($application_no);


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

                $data['_view'] = 'NcVillageService/Common/application_details_common_khas';
                $this->load->view('layouts/main', $data);
            }

            // NC tribal
            if($caseDetails->service_code == NC_TRIBAL_ID)
            {
                $basic   = $this->NcServiceModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->NcServiceModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->NcServiceModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->NcServiceModel->getAllApplicantEncroacher($application_no);
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->NcServiceModel->getSettlementDag($application_no);
                $lmnotes   = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->NcServiceModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->NcServiceModel->getDocuments($application_no);

                $data['basic']=$basic;

                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;

                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB3."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
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
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->NcCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->NcCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->NcCommonModel->getRejectModal(NC_TRIBAL_ID);
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


                $data['_view'] = 'NcVillageService/Common/application_details_common_tribal';
                $this->load->view('layouts/main', $data);

            }

            // NC special cultivator tea
            if($caseDetails->service_code == NC_CULTIVATOR_ID)
            {
                $basic   = $this->NcServiceModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->NcServiceModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->NcServiceModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->NcServiceModel->getAllApplicantEncroacher($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->NcServiceModel->getSettlementDag($application_no);
                $lmnotes   = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->NcServiceModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->NcServiceModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation'] = $this->NcServiceModel->getSettlementReservation($application_no);
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB3."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
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

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->NcCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->NcCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->NcCommonModel->getRejectModal(NC_CULTIVATOR_ID);
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
                $data['_view'] = 'NcVillageService/Common/application_details_common_tea';
                $this->load->view('layouts/main', $data);

            }

            // Reclass
            if ($caseDetails->service_code == RECLASS_ID)
            {
                $basic= $this->reclassModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->reclassModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->reclassModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->reclassModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->reclassModel->getSettlementDag($application_no);
                $lmnotes = $this->reclassModel->getSettlementTenantLmNote($application_no);
                $proceedings = $this->reclassModel->getSettlementProceeding($application_no);
                $dhardocuments = $this->reclassModel->getDocuments($application_no);
                $nominee = $this->reclassModel->getAllNomineeDetail($application_no);


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

                $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;

                $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' ")->row();
                $data['premium_data_lm'] = $premium_data_lm;


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
                $data['deleted_dags']=$this->SettlementCommonModel->getDeletedDags($application_no);


                $caseCount = $this->reclassSuiteADCModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $data['chithaArea']    = '';
                $data['reservedArea']  = '';
                $data['areaCheck']     = '';
                $data['appliedDags']   = '';
                $data['lmProcessArea'] = '';


                $caseDetails = $this->reclassSuiteADCModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);

                //var_dump($caseDetails);exit;
                $proceedings = $this->reclassSuiteADCModel->getSettlementProceeding($case_no);
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

                $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == RECLASS_ID)
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

                $data['_view'] = 'reclass_suite/Adc/reclass_app_details_only_view';
                $this->load->view('layouts/main', $data);

            }

            // Urban Tenant
            if ($caseDetails->service_code == SETTLEMENT_TENANT_URBAN_ID) {


                // $application_no        = $this->input->get('case');
                $basic                 = $this->SettlementApModel->getSettlementBasic($application_no);
                $applicants            = $this->SettlementApModel->getAllApplicant($application_no);
                $dags                  = $this->SettlementApModel->getSettlementDag($application_no);
                $lmnotes               = $this->SettlementApModel->getSettlementApLmNote($application_no);
                $proceedings           = $this->SettlementApModel->getSettlementProceeding($application_no);
                $dhardocuments         = $this->SettlementApModel->getDocuments($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_buyers     = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners     = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);
                $dags                  = $this->SettlementApModel->getSettlementDag($application_no);


                $data['basic']                 = $basic;
                $data['applicants']            = $applicants;
                $data['dags']                  = (array) $dags[0];
                $data['lmnotes']               = $lmnotes;
                $data['proceedings']           = $proceedings;
                $data['dhardocuments']         = $dhardocuments;
                $data['applicants_encroacher'] = $applicants_encroacher;
                $data['applicants_buyers']     = $applicants_buyers;
                $data['applicants_owners']     = $applicants_owners;
                $data['applicants_riotee_nok'] = $applicants_riotee_nok;
                $data['validation_bypass']     = 0;

                $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();

                $url = API_LINK_MB3 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
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

                $caseCount = $this->SettlementTenantUrbanDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

                if ($caseCount == 0) {
                    $this->getCaseSearchCommon();
                } else {
                    $caseDetails         = $this->SettlementTenantUrbanDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
                    $proceedings         = $this->SettlementTenantUrbanDcModel->getSettlementProceeding($case_no);
                    $data['caseCount']   = $caseCount;
                    $data['caseDetails'] = $caseDetails;
                    $data['proceedings'] = $proceedings;

                    $data['_view'] = 'SettlementView/Dc/TenantUrban/settlement_app_details_only_view_tenant';
                    $this->load->view('layouts/main', $data);
                }
            }

            // Tea Grant
            if ($caseDetails->service_code == TEA_SERVICE_CODE)
            {
                $this->load->model('TeaGrant/LM/TeaGrantModel');
                $this->load->model('TeaGrant/ADC/TeaGrantAdcModel');
                $basic                  = $this->TeaGrantModel->getSettlementBasic($application_no);
                $applicants_buyers      = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
                $applicants_owners      = $this->TeaGrantModel->getAllApplicantOwners($application_no);
                $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

                $adcdata                = [];
                $dags                   = $this->TeaGrantModel->getSettlementDag($application_no);
                $lmnotes                = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
                $proceedings            = $this->TeaGrantModel->getSettlementProceeding($application_no);
                $dhardocuments          = $this->TeaGrantModel->getDocuments($application_no);
                $nominee                = $this->TeaGrantModel->getAllNomineeDetail($application_no);
                $existing_pattadar      = $this->TeaGrantModel->getAllExistingPattadar($application_no);
                $deed_applicant         = $this->TeaGrantModel->getAllDeedPattadar($application_no);
                $family_tree            = $this->TeaGrantModel->getAllFamilyTree($application_no);

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }

                // $premium_data                   = $this->SettlementCommonModel->getPremium($application_no);
                $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['premium_data']           = $premium_data;
                $data['premium']                = $premium_data;

                $data['encdata']                = $adcdata;
                $data['basic']                  = $basic;
                $data['applicants_buyers']      = $applicants_buyers;
                $data['applicants_owners']      = $applicants_owners;
                $data['applicants_dag_details'] = $applicants_dag_details;
                $data['dags']                   = $dags;
                $data['lmnotes']                = $lmnotes;
                $data['proceedings']            = $proceedings;
                $data['dhardocuments']          = $dhardocuments;
                $data['nominee']                = $nominee;
                $data['deleted_dags']           = $this->SettlementCommonModel->getDeletedDags($application_no);

                $data['existing_pattadar']      = $existing_pattadar;
                $data['deed_applicant']         = $deed_applicant;
                $data['family_tree']            = $family_tree;

                $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);

                $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

                $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $proceedings         = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;
                $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
                $data['additional_property'] = $this->TeaGrantModel->getAdditionalProperty($application_no);

                $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

                if(isset($areaModificationCheck)){
                    if($areaModificationCheck){
                        foreach($areaModificationCheck as $areaHis){
                            $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                            $applied_area_home_katha = $areaHis->applied_area_home_katha;
                            $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                            $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                            $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                            $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                            $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                            $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                            $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                            $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                            $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                            $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                            $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                            $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                            $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                            $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                            $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                            $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                            $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                            $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                                $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                                $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                                $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                                $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                                if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                                    $data['area_modified'] = $areaModificationCheck;
                                }

                            }
                            else
                            {
                                $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                                $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                                $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                                $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                                //check if area modified
                                if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            }
                        }
                    }
                }

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS_TEA_GRANT) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == TEA_SERVICE_CODE)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }


                $checkArea                   = 0;
                $totalLandArea               = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa   = 0;

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
                        foreach ($rejected_list_json as $re_list)
                        {
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

                // get basundhara appl no from basundhar application table
                $basundharCaseNo = $this->TeaGrantModel->fromBasundharApplication($case_no);
                $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($basundharCaseNo);
                if($get_aadhaar_photo != 'n'){
                    $data['base64_decoded_adhar_file'] = "<img src = data:".$this->TeaGrantModel->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $data['checkAppliedArea'] = $checkArea;
                $data['_view'] = 'TeaGrant/ADC/TeaGrantPullBackViewOnly';
                $this->load->view('layouts/main', $data);


            }



        }
    }


    // get SDLAC Committee
    public function getSdlacCommitteeCommon()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $userData = $this->session->userdata;
        $dist_code = $userData['dist_code'];
        $user_code = $userData['user_code'];
        $user_desig_code = $userData['user_desig_code'];
        $memberDetails = $this->SettlementCommonDcModel->fetch_sdlac_member_list($dist_code);
        $data['committeeCount'] = $memberDetails->num_rows();
        $data['committeeList']  = $memberDetails->result();
        $data['_view'] = 'settlementView/Dc/Common/sdlac_committee_list';
        $this->load->view('layouts/main', $data);
    }


    // Add New Member
    public function addNewSdlacMember()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Member Name', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('phone', 'Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|min_length[2]|max_length[70]');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('position', 'Position', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $this->load->helper('security');

            $userData  = $this->session->userdata;
            $dist_code = $userData['dist_code'];
            $user_code = $userData['user_code'];
            $user_desig_code = $userData['user_desig_code'];

            //check if same user already exist in login usertable
            $checkLogin = $this->db->query("SELECT use_name FROM loginuser_table WHERE dist_code = ? AND 
              use_name = ?", array($dist_code, $this->input->post('username')));
            if($checkLogin->num_rows() > 0){
                log_message('error', 'Same username already exist '.$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            //switching to auth db
            $this->dbb = $this->load->database('auth', TRUE);

            //check if same user already exist in central_auth
            $checkAuthLogin = $this->dbb->query("SELECT dhar_user FROM central_auth WHERE dist_code = ? AND 
              dhar_user = ?", array($dist_code, $this->input->post('username')));
            if($checkAuthLogin->num_rows() > 0){
                log_message('error', 'Same username already exist '.$this->dbb->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            //switching to district db
            $this->dbswitch();

            //insert into login user table
            $loginuser_table = array(
                'use_name'           => $this->input->post('username'),
                'user_code'          => $user_code,
                'priv'               => SDLAC_ROLE,
                'date_of_creation'   => date('Y-m-d'),
                'dis_enb_option'     => ENABLE_ROLE,
                'first_login'        => 'Y',
                'activity'           => '1',
                'dist_code'          => $dist_code,
                'subdiv_code'        => '00',
                'cir_code'           => '00',
                'mouza_pargona_code' => '00',
                'lot_no'             => '00',
                'password'           => do_hash($this->input->post('password')),
                'prev_password1'     => $this->utilityclass->encryptData($this->input->post('password')),
            );
            $insLogin = $this->db->insert('loginuser_table', $loginuser_table);
            if($insLogin != 1) {
                log_message('error', "Insertion falied in loginuser_table 
                table ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            //switching to auth db
            $this->dbb = $this->load->database('auth', TRUE);

            //insert into central auth table
            $auth_insert= array(
                'dhar_user'          => $this->input->post('username'),
                'dhar_code'          => $user_code,
                'dist_code'          => $dist_code,
                'subdiv_code'        => '00',
                'cir_code'           => '00',
                'mouza_pargona_code' => '00',
                'lot_no'             => '00',
                'mapped_by'          => $this->input->post('username'),
                'date_of_map'        => date('Y-m-d'),
                'password'           => do_hash($this->input->post('password')),
                'prev_password1'     => $this->utilityclass->encryptData($this->input->post('password'))
            );
            $insAuth = $this->dbb->insert('central_auth', $auth_insert);
            echo $this->dbb->last_query(); die;
            if($insAuth != 1){
                log_message('error', "Insertion falied in central_auth table ".$this->dbb->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }

            //switching to district db
            $this->dbswitch();

            $dataSave = array(
                'dist_code'      => $dist_code,
                'created_by'     => $user_code,
                'created_des'    => $user_desig_code,
                'name'           => $this->input->post('name'),
                'phone'          => $this->input->post('phone'),
                'email'          => $this->input->post('email'),
                'designation'    => $this->input->post('designation'),
                'status'         => 1,
                'ip'             => $this->utilityclass->get_client_ip(),
                'position_order' => $this->input->post('position'),
            );

            if($this->SettlementCommonDcModel->saveSdlacCommitteeMemberToDB($dataSave)== 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 2,
                ));
                return;
            }
        }
    }


    // view individual member
    public function getSdlacMemberIndividual()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $memberId  = $this->input->get('member');
        $userData  = $this->session->userdata;
        $dist_code = $userData['dist_code'];
        $user_code = $userData['user_code'];
        $user_desig_code = $userData['user_desig_code'];

        $memberCount = $this->SettlementCommonDcModel->countIndSdlacMemberUnderMe
        ($memberId,$dist_code,$user_code,$user_desig_code);

        if($memberCount == 0)
        {
            $this->getSdlacCommitteeCommon();
        }
        else
        {

            $data['member'] = $this->SettlementCommonDcModel->getIndSdlacMemberUnderMe
            ($memberId,$dist_code,$user_code,$user_desig_code);

            $data['_view'] = 'settlementView/Dc/Common/sdlac_committee_member_details';
            $this->load->view('layouts/main', $data);
        }

    }


    // edit member details
    public function editSdlacMemberDetails()
    {

        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('memId', 'Id', 'trim|required|is_natural');
        $this->form_validation->set_rules('name', 'Member Name', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('phone', 'Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|is_natural');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', "Please provide valid data and try again");
            redirect(base_url().'index.php/SettlementCommonDc/getSdlacCommitteeCommon', 'refresh');
        }
        else
        {
            $memberId  = trim($this->input->post('memId'));
            $userData  = $this->session->userdata;
            $dist_code = $userData['dist_code'];
            $user_code = $userData['user_code'];
            $user_desig_code = $userData['user_desig_code'];

            if($this->SettlementCommonDcModel->countIndSdlacMemberUnderMe($memberId,$dist_code,$user_code,$user_desig_code)==0)
            {
                $this->session->set_flashdata('error', "Data not found !");
                redirect(base_url().'index.php/SettlementCommonDc/getSdlacCommitteeCommon', 'refresh');
            }
            else
            {
                $dataUpdate = array(
                    'name'  => trim($this->input->post('name')),
                    'phone' => trim($this->input->post('phone')),
                    'email' => trim($this->input->post('email')),
                    'designation' => trim($this->input->post('designation')),
                    'status' => trim($this->input->post('status')),
                    'ip'     => $this->utilityclass->get_client_ip(),
                    'position_order' => trim($this->input->post('position_order')),
                );

                if($this->SettlementCommonDcModel->updateSdlacCommitteeMemberToDB($memberId,$dataUpdate)== 0)
                {
                    $this->session->set_flashdata('error', "Please provide valid data and try again");
                    redirect(base_url().'index.php/SettlementCommonDc/getSdlacCommitteeCommon', 'refresh');

                }
                else
                {
                    $this->session->set_flashdata('success', "Member Details Successfully Updated ");
                    redirect(base_url().'index.php/SettlementCommonDc/getSdlacCommitteeCommon', 'refresh');

                }
            }
        }
    }



    // ---------

    function TotalBighaKathaLessa()
    {
        $total_lessa = (int)$this->input->post('final_area');

        $bigha = $total_lessa / 100;
        $rem_lessa = fmod($total_lessa, 100);
        $katha = $rem_lessa / 20;
        $r_lessa = fmod($rem_lessa, 20);
        $mesaure = array();
        $mesaure[].=floor($bigha);
        $mesaure[].=floor($katha);
        $mesaure[].=$r_lessa;
        $mesaure[].=0;

        return $mesaure;
    }

    //-------- for Bengali version 13/6/18
    function TotalBighaKathaLessa2()
    {
        $total_ganda = (int)$this->input->post('final_area');

        $bigha = $total_ganda / 6400;
        $rem_ganda = $total_ganda % 6400;
        $katha = $rem_ganda / 320;
        $rem_ganda2 = $rem_ganda % 320;
        $chatak = $rem_ganda2/20;
        $rem_ganda3 =  $rem_ganda2%20;


        $mesaure = array();
        $mesaure[].=floor($bigha);
        $mesaure[].=floor($katha);
        $mesaure[].=floor($chatak);
        $mesaure[].=number_format($rem_ganda3,4);

        return $mesaure;
    }
    //----------------




    // view SDLAC notice
    public function getProposalNotice()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $id = $this->input->get('case');
        $sql = "SELECT * from settlement_proposal_list WHERE id = ?";
        $result_row = $this->db->query($sql, $id)->row();

        if(!file_exists($result_row->file_path))
        {
            $parts = explode("uploads".UPLOAD_SEPARATOR, $result_row->file_path, 2);
            if (count($parts) > 1)
            {
                $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
            }
            else
            {
                $path = $result_row->file_path;
            }

            if(!file_exists($path))
            {
                $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
            }
            else
            {
                echo "No Data Found..";
                return;
            }
        }
        else
        {
            $path = $result_row->file_path;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);

        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];

        $data['_view'] = 'settlementView/Dc/Common/sdlac_notice_print';

        $this->load->view('layouts/main',$data);
    }


    // view SDLAC Attendance
    public function viewSdlacAttendance()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $proposal_no = trim($this->input->get('case'));
        $meetingDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposal_no);

        if($meetingDetails->file_attendance_path == '')
        {
            die("Unable to open file !");
        }
        else
        {

            //  $replaceFileName = str_replace("./","",$proDetails->file_attendance_path);
            //  $file = base_url().$replaceFileName;
            //  redirect($file);

            if(!file_exists($meetingDetails->file_attendance_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_attendance_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_attendance_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }
            }
            else
            {
                $path = $meetingDetails->file_attendance_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // view SDLAC Attendance
    public function viewSdlacUploadedMinute()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $proposal_no = trim($this->input->get('case'));
        $meetingDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposal_no);

        if($meetingDetails->file_minute_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            // $replaceFileName = str_replace("./","",$proDetails->file_minute_path);
            // $file = base_url().$replaceFileName;
            // redirect($file);

            if(!file_exists($meetingDetails->file_attendance_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_attendance_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_attendance_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }
            }
            else
            {
                $path = $meetingDetails->file_attendance_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // get Minutes approved / Reject by SDLAC
    public function getMinutesApprovedRejectedBySdlac()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('type', 'Action Type', 'trim|required');


        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {

            $dist_code  = $this->session->userdata('dist_code');
            $case_no    = trim($this->input->post('caseNo'));
            $actionType = trim($this->input->post('type'));

            $proposalId = $this->SettlementCommonDcModel->getSettlementProposalDetailsByCaseNo($case_no);
            if($proposalId == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }

            $allApplicants = $this->SettlementCommonDcModel->getAllApplicantBuyers($case_no);
            $applicants = $allApplicants->result();
            $appCount   = $allApplicants->num_rows();

            if($appCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }

            $applicantsArray = '';
            $i = 0;
            foreach ($applicants as $applicant)
            {
                $i = $i+1;
                if($i == $appCount)
                {
                    $applicantsArray .= $applicant->pdar_name;
                }
                else
                {
                    $applicantsArray .= $applicant->pdar_name.', ';
                }
            }

            // application approve
            if($actionType == 1)
            {
                $minute = 'The case '. $case_no. ' has been approved by SDLAC/CDLAC on '.
                    date("F j, Y") .' for Proposal number ' .$proposalId->proposal_id .
                    ' in favour of '.$applicantsArray .'.';
            }
            // application reject
            if($actionType == 2)
            {
                $minute = 'The case '. $case_no. ' has been rejected by SDLAC/CDLAC on '.
                    date("F j, Y") .' for Proposal number ' .$proposalId->proposal_id .
                    ' in favour of '.$applicantsArray .'.';

            }

            echo json_encode(array(
                'responseType' => 2,
                'minutes' => $minute,
                'minutesProId' => $proposalId->proposal_id
            ));
            return;
        }

    }


    // generate Minutes
    public function generateSdlacMinutesForProposal()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $proposal_no = trim($this->input->get('case'));
        $caseCountInPro = $this->SettlementCommonDcModel->countSettlementProposalList($proposal_no);

        if($caseCountInPro == 0)
        {
            redirect(base_url(). 'index.php/home/index');
        }
        else
        {
            $dist_code    = $this->session->userdata('dist_code');
            $proDetails   = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposal_no);
            $dcName       = $this->UtilsModel->getUserNameDc($proDetails->dist_code);
            $allCases     = $this->SettlementCommonDcModel->getAllAppInReportSendByDcToSdlacCommon($proposal_no,$proDetails->dist_code,$proDetails->service_code);
            $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($proDetails->dist_code);
            $sdlacMembers = $this->SettlementCommonDcModel->getSdlacMemberListByProId($proposal_no,$proDetails->dist_code,$proDetails->service_code);
            $allCase      = $allCases->result();

            $data['dist_code']    = $dist_code;
            $data['proposal_no']  = $proposal_no;
            $data['caseCount']    = $allCases->num_rows();
            $data['proDetails']   = $proDetails;
            $data['dcName']       = $dcName;
            $data['districtName'] = $districtName;
            $data['sdlacMembers'] = $sdlacMembers->result();

            foreach ($allCase as $case)
            {
                $reza[] = $this->SettlementCommonDcModel->getAllDataForSDLACMinutes($case->case_no);
            }

            $data['cases'] = $reza;

            $data['_view'] = 'settlementView/Dc/Common/sdlac_minutes_print';
            $this->load->view('layouts/main',$data);
        }
    }


    // Search proposal ID by Case / Application Number
    public function searchProposalIdByAppCaseNo()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $case_no = '';

        if(trim($this->input->post('caseNo'))!= null or trim($this->input->post('caseNo')) != '')
        {
            $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required|min_length[10]|max_length[70]');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }
            else
            {
                $case_no = trim($this->input->post('caseNo'));
            }
        }
        else
        {
            $this->form_validation->set_rules('applicationNo', 'Application Number', 'trim|required|min_length[10]|max_length[70]');

            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
                return;
            }
            else
            {
                $app_no = trim($this->input->post('applicationNo'));

                $countApplicationDetails = $this->SettlementCommonDcModel->countApplicationDetailsByAppNo($app_no);

                if($countApplicationDetails == '' or $countApplicationDetails == 0)
                {
                    echo json_encode(array(
                        'responseType' => 3,
                    ));
                    return;
                }

                $getApplicationDetails = $this->SettlementCommonDcModel->getApplicationDetailsByAppNo($app_no);
                $case_no = $getApplicationDetails->case_no;

            }
        }

        if(trim($case_no)== null or trim($case_no) == '')
        {
            echo json_encode(array(
                'responseType' => 3,
            ));
            return;
        }

        $countCaseIdSdlacProposal = $this->SettlementCommonDcModel->countProposalIdByCaseNo($case_no);

        if($countCaseIdSdlacProposal == '' or $countCaseIdSdlacProposal == 0)
        {
            echo json_encode(array(
                'responseType' => 3,
            ));
            return;
        }

        $getSdlacProposalID = $this->SettlementCommonDcModel->getProposalNameByCaseNo($case_no);

        echo json_encode(array(
            'responseType' => 2,
            'proposalIds' => $getSdlacProposalID,
        ));
        return;

    }


    // download case list/Area details with proposal id
    public function downloadCasesWithProposalId()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $ProposalNo = trim($this->input->get('case'));
        $file_name  = time()."_proposal.xlsx";

        // $data = $this->db->query("select
        // (select locname_eng from location where dist_code=t1.dist_code and subdiv_code='00') district,
        // (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code='00') circle,
        // (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no='00') mouza,
        // (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code='00000') lot,
        // (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code=t1.vill_townprt_code) village,
        // t1.uuid,t1.applid as application_no,t1.case_no, t2.applicant_name, t2.guardian_name, t2.Address, t3.dag_no, t3.applied_area, t3.proposed_area, t5.encroacher_name, t6.joint_applicants
        // from (select case_no,proposal_id from settlement_proposal_cases spc where proposal_id=$ProposalNo) t11
        // left join (select applid,case_no,dist_code,subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,uuid from settlement_basic a) t1 on t11.case_no=t1.case_no
        // left join ( select case_no,sa.pdar_name as applicant_name,sa.pdar_guardian as guardian_name,sa.pdar_add1 as Address from settlement_applicant sa where is_applicant='1') t2 on t11.case_no=t2.case_no
        // left join ( select case_no,string_agg(distinct(dag_no),'-') as dag_no,string_agg(distinct(dag_no || '-area( home: ' || home_b || ' B-'||home_k||' K-'||home_lc ||'L, agri: '||agri_b||'B-'||agri_k||'K-'||agri_lc||'L)'),',') as applied_area, string_agg(distinct(dag_no || '-area( Total_Proposed_area: ' || s_dag_area_b || ' B-'||s_dag_area_k||' K-'||s_dag_area_lc ||'L)'),',') as proposed_area from settlement_dag_details sdd group by case_no) t3 on t11.case_no=t3.case_no
        // left join ( select case_no,array_agg(distinct(pdar_name)) as encroacher_name from settlement_applicant sap where pdar_type='EN' group by case_no) t5 on t11.case_no=t5.case_no
        // left join ( select case_no,string_agg(distinct(pdar_name),'-') as joint_applicants from settlement_applicant sa where is_applicant!='1' and pdar_type='B' group by case_no) t6 on t11.case_no=t6.case_no")->result_array();

        $data = $this->db->query("
         select
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code='00') district,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code='00') circle,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no='00') mouza,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code='00000') lot,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code=t1.vill_townprt_code) village,
        t1.uuid,t1.applid as application_no,t1.case_no, t2.applicant_name, t2.guardian_name, t2.Address, t3.dag_no,
        (select lc.land_type from chitha_basic cb join landclass_code lc on cb.land_class_code=lc.class_code where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code=t1.vill_townprt_code and dag_no=t3.dag_no) land_type,
        t3.applied_area, t3.proposed_area, t5.encroacher_name, t6.joint_applicants,
        t1.occupation_applicant as Occupation,t2.period_possession_by_citizen,t17.period_possession_by_lra,
        (select 'DagNo: '||string_agg(distinct(dag_no) || '- AreaType: '||
		CASE WHEN area_name=1 THEN 'Guwahati City'
		WHEN area_name=2 THEN 'Within GMDA area'
		WHEN area_name=3 THEN 'District Headquarter Towns, North Guwahati, Rangia and Palashbari town'
		WHEN area_name=4 THEN 'Within Restructured Development Authority Area of District Headquarter Towns.'
		WHEN area_name=5 THEN 'Within 5 Km radius from the periphery of North Guwahati, Rangia and Palashbari towns.'
		WHEN area_name=6 THEN 'Municipal Towns other than District Head Quarter Towns'
		WHEN area_name=7 THEN 'Within 5 km radius from the periphery of Municipal Towns other than District Head Quarter Towns'
		WHEN area_name=8 THEN 'Revenue Towns'
		WHEN area_name=9 THEN 'Within 3 km radius from the periphery of  Revenue Towns'
		WHEN area_name=10 THEN 'Rural Areas'
		WHEN area_name=11 THEN 'Municipal Corporation (Town Area)'
        WHEN area_name=12 THEN 'Municipal Corporation (Peripheral Area)'
        WHEN area_name=13 THEN 'District Headquarter Municipal Towns, Rangia and Palashbari Towns, having Master Plan area (Town Area)'
        WHEN area_name=14 THEN 'District Headquarter Municipal Towns, Rangia and Palashbari Towns, having Master Plan area (Peripheral Area)'
        WHEN area_name=15 THEN 'District Headquarter Municipal Towns for which Master Plan area is not notified (Town Area)'
        WHEN area_name=16 THEN 'District Headquarter Municipal Towns for which Master Plan area is not notified (Peripheral Area)'
        WHEN area_name=17 THEN 'Other Municipal Towns (Town Area)'
        WHEN area_name=18 THEN 'Other Municipal Towns (No Peripheral Area)'
        WHEN area_name=19 THEN 'Revenue Towns showing urbanization and industrial growth (Town Area)'
        WHEN area_name=20 THEN 'Revenue Towns showing urbanization and industrial growth (No Peripheral Area)'
        WHEN area_name=21 THEN 'Other Revenue Towns (Town Area)'
        WHEN area_name=22 THEN 'Other Revenue Towns (No Peripheral Area)'
		END, ',' )  from settlement_premium where case_no=t11.case_no and is_final=1 and  area_name is not null and t11.case_no is not null) as area_type
		
        from (select case_no,proposal_id from settlement_proposal_cases spc where proposal_id=?) t11
        left join (select applid,case_no,dist_code,subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,uuid,occupation_applicant from settlement_basic a) t1 on t11.case_no=t1.case_no
        left join ( select case_no,sa.pdar_name as applicant_name,sa.period_possession as period_possession_by_citizen,sa.pdar_guardian as guardian_name,sa.pdar_add1 as Address from settlement_applicant sa where is_applicant='1') t2 on t11.case_no=t2.case_no
        left join ( select case_no,string_agg(distinct(dag_no),'-') as dag_no,string_agg(distinct(dag_no || '-area( home: ' || home_b || ' B-'||home_k||' K-'||home_lc ||'L, agri: '||agri_b||'B-'||agri_k||'K-'||agri_lc||'L)'),',') as applied_area, string_agg(distinct(dag_no || '-area( Total_Proposed_area: ' || s_dag_area_b || ' B-'||s_dag_area_k||' K-'||s_dag_area_lc ||'L)'),',') as proposed_area from settlement_dag_details sdd group by case_no) t3 on t11.case_no=t3.case_no
        left join ( select case_no,array_agg(distinct(pdar_name)) as encroacher_name from settlement_applicant sap where pdar_type='EN' group by case_no) t5 on t11.case_no=t5.case_no
        left join ( select case_no,string_agg(distinct(pdar_name),'-') as joint_applicants from settlement_applicant sa where is_applicant!='1' and pdar_type='B' group by case_no) t6 on t11.case_no=t6.case_no
        left join (Select case_no,period_possession as period_possession_by_lra from settlement_ap_lmnote ) t17 ON t17.case_no=t1.case_no
        ",array($ProposalNo))->result_array();


        //dd($this->db->last_query());

        $this->UtilsModel->downloadExcelReport($file_name,$data);

    }


    // view Digital Minutes
    public function getDigitalMinutesWithMeetingId()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->SettlementCommonDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->encode_pdf_dir_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->encode_pdf_dir_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->encode_pdf_dir_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->encode_pdf_dir_path;
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_34."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }

            }
            else
            {
                $path = $meetingDetails->encode_pdf_dir_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }





    public function updateMemberPriority()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $sdlc_code = $this->input->post('user_code');
        $priority  = $this->input->post('priority');
        $dist_code = $this->session->userdata('dist_code');
        $this->db->trans_begin();
        if(isset($priority) && !empty($priority)){
            for ($i=0; $i < count($sdlc_code); $i++) {
                $updated = $this->SettlementCommonDcModel->updateFlag($dist_code,$sdlc_code[$i],$priority[$i]);
                if($updated == 3){
                    echo json_encode(array(
                        'responseType' => 3,
                        'message' => "#ERROR0987: User details not found"
                    ));
                    return;
                }else if($updated == 0){
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => "#ERROR0988: Updated error,Something went wrong"
                    ));
                    return;
                }

            }
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message'      => "Updated Successfully"
            ));
            return;
        }else{
            echo json_encode(array(
                'responseType' => 1,
                'message'      => "#ERROR0989: Priority already set"
            ));
            return;
        }


    }


    function villageListCommon()
    {
        $subdiv=$this->input->post('subdiv_code');
        $circle=$this->input->post('cir_code');
        $query = $this->db->query("SELECT B.subdiv_code,B.cir_code,B.mouza_pargona_code,B.lot_no,B.vill_townprt_code, B.loc_name FROM settlement_basic A 
          JOIN location B ON A.uuid=B.uuid
          WHERE B.subdiv_code=? and B.cir_code=? and B.vill_townprt_code!='00000'
          GROUP BY B.subdiv_code,B.cir_code,B.mouza_pargona_code,B.lot_no,
          B.vill_townprt_code, B.loc_name",
            array($subdiv, $circle))->result();
        echo json_encode(array(
            'responseType' => 1,
            'location'     => $query,
        ));
        return;
    }

    // added on 15/05/2023
    public function addEditCopyTo()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');

        $userMp = $this->SettlementCommonDcModel->getUsersMp($dist_code, $subdiv_code);
        $data['userMp_count'] = $userMp->num_rows();
        $data['userMp_name']  = $userMp->result();

        $userMla = $this->SettlementCommonDcModel->getUsersMla($dist_code, $subdiv_code);
        $data['userMla_count'] = $userMla->num_rows();
        $data['userMla_list']  = $userMla->result();

        $usersdlc = $this->SettlementCommonDcModel->getUsersSdlac($dist_code, $subdiv_code);
        $data['usersdlc_count'] = $usersdlc->num_rows();
        $data['usersdlc_list']  = $usersdlc->result();

        $data['dist_code']   = $dist_code;
        $data['subdiv_code'] = $subdiv_code;

        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ? and created_by = ? and created_code = ?", array($dist_code, $subdiv_code, $user_desig_code, $user_log_code));

        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }

        $data['_view'] = 'SettlementView/Dc/add_edit_copy_to';
        $this->load->view('layouts/main', $data);
    }

    //save sdlac CC data
    public function saveCcData()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $this->db->query("DELETE FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ? and created_code=?", array($dist_code, $subdiv_code, $user_log_code));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('hpc', 'Name of H.P.C.', 'trim|required');
        $this->form_validation->set_rules('zila_parishad', 'Please select Zilla Parishad', 'trim|required');

        $zila_parishad   = $this->input->post('zila_parishad');
        $municipal_board = $this->input->post('municipal_board');
        $social_worker   = $this->input->post('social_worker');

        if(count($municipal_board) == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343434: Please enter municipal board details!!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
            return false;
        }

        if(count($social_worker) == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343435: Please enter social worker board details!!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
            return false;
        }

        // array of MP detail / 1
        $getMp = $this->SettlementCommonDcModel->getUsersMp($dist_code, $subdiv_code);
        $userMp_count = $getMp->num_rows();
        $userMp_list  = $getMp->result();
        if($userMp_count > 0)
        {
            $j=0;
            foreach($userMp_list as $mp)
            {
                $honble_mp = $this->input->post('honble_mp'.$j);
                $hpc       = $this->input->post('hpc'.$j);
                $hpcType   = $this->input->post('hpcType'.$j);

                if(($honble_mp != '' || $honble_mp != null) && ($hpc == null || $hpc == ''))
                {
                    // echo "1st";
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR3444355: You forgot to insert the MP field!");
                    redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
                    return false;
                }

                if($honble_mp != false || strlen($honble_mp) > 1)
                {
                    $getMP = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mp));

                    if($getMP->num_rows() > 0)
                    {
                        $getMPData = $getMP->row();
                        $insertData[] = [
                            'user_level'   => '1',
                            'dist_code'    => $dist_code,
                            'subdiv_code'  => $subdiv_code,
                            'user_code'    => $honble_mp,
                            'user_name'    => $getMPData->username,
                            'user_desg'    => $getMPData->user_type,
                            'user_mobile'  => $getMPData->phone_no,
                            'user_email'   => $getMPData->emailid,
                            'hpc_lac'      => $hpc,
                            'status'       => 1,
                            'created_by'   => $user_desig_code,
                            'created_at'   => date('Y-m-d h:i:s'),
                            'updated_at'   => date('Y-m-d h:i:s'),
                            'board_name'   => '',
                            'created_code' => $user_log_code,
                            'hpc_type'     => $hpcType,
                            'sl_no'        => 0,
                        ];
                    }
                }
                $j++;
            }

        }

        //array of MLA / 2
        $userMla = $this->SettlementCommonDcModel->getUsersMla($dist_code, $subdiv_code);
        $userMla_count = $userMla->num_rows();
        $userMla_list  = $userMla->result();
        if($userMla_count > 0)
        {
            $i=0;
            foreach($userMla_list as $mla)
            {
                $honble_mla = $this->input->post('honble_mla'.$i);
                $lac        = $this->input->post('lac'.$i);
                $mlaSlNo    = $this->input->post('mlaSlNo'.$i);

                if(($honble_mla != '' || $honble_mla != null) && ($lac == null || $lac == ''))
                {
                    // echo "2nd";
                    $this->db->trans_rollback();

                    $this->session->set_flashdata('message', "#ERR3444334: You forgot to insert the LAC field!");
                    redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
                    return false;
                }

                if($honble_mla != false || strlen($honble_mla) > 1)
                {
                    $getMla = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mla));

                    if($getMla->num_rows() > 0)
                    {
                        $getMlaData = $getMla->row();
                        $insertData[] = [
                            'user_level'   => '2',
                            'dist_code'    => $dist_code,
                            'subdiv_code'  => $subdiv_code,
                            'user_code'    => $honble_mla,
                            'user_name'    => $getMlaData->username,
                            'user_desg'    => $getMlaData->user_type,
                            'user_mobile'  => $getMlaData->phone_no,
                            'user_email'   => $getMlaData->emailid,
                            'hpc_lac'      => $lac,
                            'status'       => 1,
                            'created_by'   => $user_desig_code,
                            'created_at'   => date('Y-m-d h:i:s'),
                            'updated_at'   => date('Y-m-d h:i:s'),
                            'board_name'   => '',
                            'created_code' => $user_log_code,
                            'hpc_type'     => '',
                            'sl_no'        => $mlaSlNo,
                        ];
                    }
                }
                $i++;
            }
        }
        else
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR843411: No MLA list found!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
            return false;
        }


        // array of zillaparishad / 6
        $getZilaPar = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $zila_parishad);

        $getZilaPar_count = $getZilaPar->num_rows();

        if($getZilaPar_count > 0)
        {
            $getZilaPar_list = $getZilaPar->row();
            $insertData[] = [
                'user_level'   => '6',
                'dist_code'    => $dist_code,
                'subdiv_code'  => $subdiv_code,
                'user_code'    => $zila_parishad,
                'user_name'    => $getZilaPar_list->username,
                'user_desg'    => $getZilaPar_list->user_type,
                'user_mobile'  => $getZilaPar_list->phone_no,
                'user_email'   => $getZilaPar_list->emailid,
                'hpc_lac'      => '',
                'status'       => 1,
                'created_by'   => $user_desig_code,
                'created_at'   => date('Y-m-d h:i:s'),
                'updated_at'   => date('Y-m-d h:i:s'),
                'board_name'   => '',
                'created_code' => $user_log_code,
                'hpc_type'     => '',
                'sl_no'        => 0,
            ];

        }

        // array of municipal detail / 7
//        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and created_code=?", array($dist_code,$user_log_code));
        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ?  and created_code=?", array($dist_code, $subdiv_code, $user_log_code));

        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }

        foreach($municipal_board as $municipal)
        {
            $getMunicipal = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $municipal);

            $getMunicipal_count = $getMunicipal->num_rows();
            $getMunicipal_data  = $getMunicipal->row();

            if($getMunicipal_count > 0)
            {

                $insertData[] = [
                    'user_level'   => '7',
                    'dist_code'    => $dist_code,
                    'subdiv_code'  => $subdiv_code,
                    'user_code'    => $municipal,
                    'user_name'    => $getMunicipal_data->username,
                    'user_desg'    => $getMunicipal_data->user_type,
                    'user_mobile'  => $getMunicipal_data->phone_no,
                    'user_email'   => $getMunicipal_data->emailid,
                    'hpc_lac'      => '',
                    'status'       => 1,
                    'created_by'   => $user_desig_code,
                    'created_at'   => date('Y-m-d h:i:s'),
                    'updated_at'   => date('Y-m-d h:i:s'),
                    'board_name'   => $this->input->post('boardNameMunicipal'.$municipal),
                    'created_code' => $user_log_code,
                    'hpc_type'     => '',
                    'sl_no'        => 0,
                ];

            }

        }

        // array of social worker / 8
        foreach($social_worker as $social)
        {
            $getSocial = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $social);

            $getSocialCount = $getSocial->num_rows();
            $getSocialData= $getSocial->row();

            if($getSocialCount > 0)
            {
                $insertData[] = [
                    'user_level'  => '8',
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'user_code'   => $social,
                    'user_name'   => $getSocialData->username,
                    'user_desg'   => $getSocialData->user_type,
                    'user_mobile' => $getSocialData->phone_no,
                    'user_email'  => $getSocialData->emailid,
                    'hpc_lac'     => '',
                    'status'      => 1,
                    'created_by'  => $user_desig_code,
                    'created_at'  => date('Y-m-d h:i:s'),
                    'updated_at'  => date('Y-m-d h:i:s'),
                    'board_name'  => '',
                    'created_code' => $user_log_code,
                    'hpc_type'     => '',
                    'sl_no'        => 0,
                ];

            }
        }


        //insert_batch
        $insertBatch = $this->db->insert_batch('minute_meeting_copy_to',$insertData);
        $this->db->trans_commit();

        if($insertBatch != 1) {
            $this->session->set_flashdata('message', "#ERR743411: Data insertion fail! Contact admin...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
            return false;
        }
        else {
            $this->session->set_flashdata('message', "Data inserted successfully...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyTo");
            return false;
        }

    }



    // added on 15/05/2023
    public function addEditCopyToIns()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');


        $userMp = $this->SettlementCommonDcModel->getUsersMp($dist_code, $subdiv_code);
        $data['userMp_count'] = $userMp->num_rows();
        $data['userMp_name']  = $userMp->result();

        $userMla = $this->SettlementCommonDcModel->getUsersMla($dist_code, $subdiv_code);
        $data['userMla_count'] = $userMla->num_rows();
        $data['userMla_list']  = $userMla->result();

        $usersdlc = $this->SettlementCommonDcModel->getUsersSdlac($dist_code, $subdiv_code);
        $data['usersdlc_count'] = $usersdlc->num_rows();
        $data['usersdlc_list']  = $usersdlc->result();

        $data['dist_code']   = $dist_code;
        $data['subdiv_code'] = $subdiv_code;

        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ? and created_by = ? and created_code = ?", array($dist_code, $subdiv_code, $user_desig_code, $user_log_code));

        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }

        $data['_view'] = 'SettlementView/Dc/add_edit_copy_to_ins';
        $this->load->view('layouts/main', $data);
    }

    //save sdlac CC data
    public function saveCcDataIns()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $this->db->query("DELETE FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ? and created_code=?", array($dist_code, $subdiv_code, $user_log_code));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('hpc', 'Name of H.P.C.', 'trim|required');
        $this->form_validation->set_rules('zila_parishad', 'Please select Zilla Parishad', 'trim|required');

        $zila_parishad   = $this->input->post('zila_parishad');
        $municipal_board = $this->input->post('municipal_board');
        $social_worker   = $this->input->post('social_worker');

        if(count($municipal_board) == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343434: Please enter municipal board details!!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
            return false;
        }

        if(count($social_worker) == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343435: Please enter social worker board details!!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
            return false;
        }

        // array of MP detail / 1
        $getMp = $this->SettlementCommonDcModel->getUsersMp($dist_code, $subdiv_code);
        $userMp_count = $getMp->num_rows();
        $userMp_list  = $getMp->result();
        if($userMp_count > 0)
        {
            $j=0;
            foreach($userMp_list as $mp)
            {
                $honble_mp = $this->input->post('honble_mp'.$j);
                $hpc       = $this->input->post('hpc'.$j);
                $hpcType   = $this->input->post('hpcType'.$j);

                if(($honble_mp != '' || $honble_mp != null) && ($hpc == null || $hpc == ''))
                {
                    // echo "1st";
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR3444355: You forgot to insert the MP field!");
                    redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
                    return false;
                }

                if($honble_mp != false || strlen($honble_mp) > 1)
                {
                    $getMP = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mp));

                    if($getMP->num_rows() > 0)
                    {
                        $getMPData = $getMP->row();
                        $insertData[] = [
                            'user_level'   => '1',
                            'dist_code'    => $dist_code,
                            'subdiv_code'  => $subdiv_code,
                            'user_code'    => $honble_mp,
                            'user_name'    => $getMPData->username,
                            'user_desg'    => $getMPData->user_type,
                            'user_mobile'  => $getMPData->phone_no,
                            'user_email'   => $getMPData->emailid,
                            'hpc_lac'      => $hpc,
                            'status'       => 1,
                            'created_by'   => $user_desig_code,
                            'created_at'   => date('Y-m-d h:i:s'),
                            'updated_at'   => date('Y-m-d h:i:s'),
                            'board_name'   => '',
                            'created_code' => $user_log_code,
                            'hpc_type'     => $hpcType,
                            'sl_no'        => 0,
                        ];
                    }
                }
                $j++;
            }

        }

        //array of MLA / 2
        $userMla = $this->SettlementCommonDcModel->getUsersMla($dist_code, $subdiv_code);
        $userMla_count = $userMla->num_rows();
        $userMla_list  = $userMla->result();
        if($userMla_count > 0)
        {
            $i=0;
            foreach($userMla_list as $mla)
            {
                $honble_mla = $this->input->post('honble_mla'.$i);
                $lac        = $this->input->post('lac'.$i);
                $mlaSlNo    = $this->input->post('mlaSlNo'.$i);

                if(($honble_mla != '' || $honble_mla != null) && ($lac == null || $lac == ''))
                {
                    // echo "2nd";
                    $this->db->trans_rollback();

                    $this->session->set_flashdata('message', "#ERR3444334: You forgot to insert the LAC field!");
                    redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
                    return false;
                }

                if($honble_mla != false || strlen($honble_mla) > 1)
                {
                    $getMla = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mla));

                    if($getMla->num_rows() > 0)
                    {
                        $getMlaData = $getMla->row();
                        $insertData[] = [
                            'user_level'   => '2',
                            'dist_code'    => $dist_code,
                            'subdiv_code'  => $subdiv_code,
                            'user_code'    => $honble_mla,
                            'user_name'    => $getMlaData->username,
                            'user_desg'    => $getMlaData->user_type,
                            'user_mobile'  => $getMlaData->phone_no,
                            'user_email'   => $getMlaData->emailid,
                            'hpc_lac'      => $lac,
                            'status'       => 1,
                            'created_by'   => $user_desig_code,
                            'created_at'   => date('Y-m-d h:i:s'),
                            'updated_at'   => date('Y-m-d h:i:s'),
                            'board_name'   => '',
                            'created_code' => $user_log_code,
                            'hpc_type'     => '',
                            'sl_no'        => $mlaSlNo,
                        ];
                    }
                }
                $i++;
            }
        }
        else
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR843411: No MLA list found!");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
            return false;
        }


        // array of zillaparishad / 6
        $getZilaPar = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $zila_parishad);

        $getZilaPar_count = $getZilaPar->num_rows();

        if($getZilaPar_count > 0)
        {
            $getZilaPar_list = $getZilaPar->row();
            $insertData[] = [
                'user_level'   => '6',
                'dist_code'    => $dist_code,
                'subdiv_code'  => $subdiv_code,
                'user_code'    => $zila_parishad,
                'user_name'    => $getZilaPar_list->username,
                'user_desg'    => $getZilaPar_list->user_type,
                'user_mobile'  => $getZilaPar_list->phone_no,
                'user_email'   => $getZilaPar_list->emailid,
                'hpc_lac'      => '',
                'status'       => 1,
                'created_by'   => $user_desig_code,
                'created_at'   => date('Y-m-d h:i:s'),
                'updated_at'   => date('Y-m-d h:i:s'),
                'board_name'   => '',
                'created_code' => $user_log_code,
                'hpc_type'     => '',
                'sl_no'        => 0,
            ];

        }

        // array of municipal detail / 7
//        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and created_code=?", array($dist_code,$user_log_code));
        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ?  and created_code=?", array($dist_code, $subdiv_code, $user_log_code));

        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }

        foreach($municipal_board as $municipal)
        {
            $getMunicipal = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $municipal);

            $getMunicipal_count = $getMunicipal->num_rows();
            $getMunicipal_data  = $getMunicipal->row();

            if($getMunicipal_count > 0)
            {

                $insertData[] = [
                    'user_level'   => '7',
                    'dist_code'    => $dist_code,
                    'subdiv_code'  => $subdiv_code,
                    'user_code'    => $municipal,
                    'user_name'    => $getMunicipal_data->username,
                    'user_desg'    => $getMunicipal_data->user_type,
                    'user_mobile'  => $getMunicipal_data->phone_no,
                    'user_email'   => $getMunicipal_data->emailid,
                    'hpc_lac'      => '',
                    'status'       => 1,
                    'created_by'   => $user_desig_code,
                    'created_at'   => date('Y-m-d h:i:s'),
                    'updated_at'   => date('Y-m-d h:i:s'),
                    'board_name'   => $this->input->post('boardNameMunicipal'.$municipal),
                    'created_code' => $user_log_code,
                    'hpc_type'     => '',
                    'sl_no'        => 0,
                ];

            }

        }

        // array of social worker / 8
        foreach($social_worker as $social)
        {
            $getSocial = $this->SettlementCommonDcModel->getUsersDetail($dist_code, $social);

            $getSocialCount = $getSocial->num_rows();
            $getSocialData= $getSocial->row();

            if($getSocialCount > 0)
            {
                $insertData[] = [
                    'user_level'  => '8',
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'user_code'   => $social,
                    'user_name'   => $getSocialData->username,
                    'user_desg'   => $getSocialData->user_type,
                    'user_mobile' => $getSocialData->phone_no,
                    'user_email'  => $getSocialData->emailid,
                    'hpc_lac'     => '',
                    'status'      => 1,
                    'created_by'  => $user_desig_code,
                    'created_at'  => date('Y-m-d h:i:s'),
                    'updated_at'  => date('Y-m-d h:i:s'),
                    'board_name'  => '',
                    'created_code' => $user_log_code,
                    'hpc_type'     => '',
                    'sl_no'        => 0,
                ];

            }
        }


        //insert_batch
        $insertBatch = $this->db->insert_batch('minute_meeting_copy_to',$insertData);
        $this->db->trans_commit();

        if($insertBatch != 1) {
            $this->session->set_flashdata('message', "#ERR743411: Data insertion fail! Contact admin...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
            return false;
        }
        else {
            $this->session->set_flashdata('message', "Data inserted successfully...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToIns");
            return false;
        }

    }



    // added on 10/07/2025
    public function addEditCopyToForDLC()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');

        $inserted_data = $this->db->query("SELECT * FROM dlc_copy_to WHERE dist_code = ? and subdiv_code = ? 
                        and created_by = ? and user_code = ? ORDER BY sl_no", array($dist_code, $subdiv_code, $user_desig_code, $user_log_code));

        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }

        $data['_view'] = 'SettlementView/Dc/add_edit_copy_to_for_dlc';
        $this->load->view('layouts/main', $data);
    }

    public function saveCcDataForDLC()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_log_code   = $this->session->userdata('user_code');
        $this->db->trans_begin();

        $this->db->query("DELETE FROM dlc_copy_to WHERE dist_code = ? and subdiv_code = ? and user_code=?", array($dist_code, $subdiv_code, $user_log_code));

        $this->load->library('form_validation');

        $slno        = $this->input->post('slno');
        $nameArray   = $this->input->post('name');
        $desgArray   = $this->input->post('designation');

        $insertData = [];
        if (is_array($slno) && is_array($nameArray) && is_array($desgArray))
        {
            for ($j = 0; $j < count($slno); $j++)
            {
                $sl_no       = trim($slno[$j]);
                $name        = trim($nameArray[$j]);
                $designation = trim($desgArray[$j]);

                if ($sl_no !== '' && ($name === '' || $designation === ''))
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR3444355: You forgot to fill all field!");
                    redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToForDLC");
                    return false;
                }

                if ($sl_no !== '' && $name !== '' && $designation !== '')
                {

                    $insertData[] = [
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'user_code'   => $user_log_code,
                        'user_name'   => $name,
                        'user_desg'   => $designation,
                        'sl_no'       => $sl_no,
                        'status'      => 1,
                        'created_by'  => $user_desig_code,
                        'created_at'  => date('Y-m-d h:i:s'),
                        'updated_at'  => date('Y-m-d h:i:s'),

                    ];
                }
            }
        }

        $insertBatch = $this->db->insert_batch('dlc_copy_to',$insertData);
        $this->db->trans_commit();

        if($insertBatch != 1) {
            $this->session->set_flashdata('message', "#ERR743411: Data insertion fail! Contact admin...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToForDLC");
            return false;
        }
        else {
            $this->session->set_flashdata('message', "Data inserted successfully...");
            redirect(base_url() . "index.php/SettlementCommonDc/addEditCopyToForDLC");
            return false;
        }


    }





    // application revert to co from proposal list
    public function applicationRemoveFromProposal()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applicationNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('proCaseId', 'Proposal Case Id', 'trim|required');
        $this->form_validation->set_rules('selectProposalId', 'Proposal No', 'trim|required');
        $this->form_validation->set_rules('revertRemarks', 'Revert Remarks', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $proposalCaseId = trim($this->input->post('proCaseId'));
            $revertRemarks  = trim($this->input->post('revertRemarks'));
            $case_no    = trim($this->input->post('applicationNo'));
            $proposalId = trim($this->input->post('selectProposalId'));
            $dist_code  = $this->session->userdata('dist_code');
            $user_code       = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');

            if($this->SettlementCommonDcModel->countSettlementProposalListAllService($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002249: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002257: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002265: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Revert VGR/PGR application here ! Kindly contact system administrator',
                ));
                return;
            }
            if($caseDetails->status != MB_SEND_TO_SDLAC)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002275: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }

            // proposal in meeting or not
            $proposalDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id != '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002286: Proposal already assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
            if($deleteCase->id != $proposalCaseId)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002296: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $this->db->trans_begin();

            $checkReqMod = 0;
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0001177: Case not found in Modification Request  ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $this->session->userdata('user_code'),
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002318: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002318: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002334: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002334: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $this->session->userdata('user_desig_code'),
                'dc_proceeding'   => 0,
                'pull_request'    => 0,

            );
            if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002353: Application unable to Revert ! Kindly contact system administrator',

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
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002390: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR002390: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRPULL002400: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002400:  Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order' => $revertRemarks,
                            'status'        => 'MR',
                            'user_code'     => $this->session->userdata('user_code'),
                            'date_entry'    => date('Y-m-d h:i:s'),
                            'operation'     => 'E',
                            'ip'            => $this->utilityclass->get_client_ip(),
                            'office_from'   => $user_desig_code,
                            'office_to'     => MB_CIRCLE_OFFICER,
                            'task'          => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002470: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002470: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $this->session->userdata('user_desig_code');
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;

                    if(in_array(trim($caseDetails->service_code), MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL))
                    {
                        $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    }
                    else
                    {
                        $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    }

                    $rtps_status = json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI002411: Reverted failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                            'message'  => 'Application Successfully Reverted to CO',

                        ));
                        return;
                    }
                }
            }
        }
    }


    // application revert to co from proposal list
    public function applicationRemoveFromRevertedProposal()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applicationNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('proCaseId', 'Proposal Case Id', 'trim|required');
        $this->form_validation->set_rules('selectProposalId', 'Proposal No', 'trim|required');
        $this->form_validation->set_rules('revertRemarks', 'Revert Remarks', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $this->checkingLoginUserAccessAdcDcUser();
            $proposalCaseId = trim($this->input->post('proCaseId'));
            $revertRemarks  = trim($this->input->post('revertRemarks'));
            $case_no    = trim($this->input->post('applicationNo'));
            $proposalId = trim($this->input->post('selectProposalId'));
            $dist_code  = $this->session->userdata('dist_code');

            if($this->SettlementCommonDcModel->countSettlementProposalList($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002443: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002451: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002459: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Revert VGR/PGR application here ! Kindly contact system administrator',
                ));
                return false;
            }
            if($caseDetails->status != MB_REVERT)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002469: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }
            $checkReqMod = 0;
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002572: Case not found in Modification Request ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            // proposal in meeting or not
            $proposalDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002480: Proposal not assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementRevertedProposalCaseDetailsByCaseNo($case_no);
            if($deleteCase->id != $proposalCaseId)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002490: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $this->db->trans_begin();
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $this->session->userdata('user_code'),
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002512: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002512: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002525: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002525: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $this->session->userdata('user_desig_code'),
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002547: Application unable to Revert ! Kindly contact system administrator',

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
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002584: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR002584: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $user_code       = $this->session->userdata('user_code');
                        $user_desig_code = $this->session->userdata('user_desig_code');
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRPULL002713: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002713:  Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order' => $revertRemarks,
                            'status'        => 'MR',
                            'user_code'     => $this->session->userdata('user_code'),
                            'date_entry'    => date('Y-m-d h:i:s'),
                            'operation'     => 'E',
                            'ip'            => $this->utilityclass->get_client_ip(),
                            'office_from'   => $user_desig_code,
                            'office_to'     => MB_CIRCLE_OFFICER,
                            'task'          => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002741: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002741: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $this->session->userdata('user_desig_code');
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status = json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI002621: Reverted failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                            'message'  => 'Application Successfully Reverted to CO',

                        ));
                        return;
                    }
                }
            }
        }
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
            $totalAreaInApplication = 0;
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
                if($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication)
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
                if($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication)
                {
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;
    }


    // application put under consideration
    public function applicationPutUnderConsideration()
    {

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('reason', 'Consideration Reason', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('remark', 'Additional Note', 'trim|max_length[295]');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $this->checkingLoginUserAccessSingleUserOnlyADC();
            $case_no   = trim($this->input->post('caseNo'));
            $reason    = trim($this->input->post('reason'));
            $remark    = trim($this->input->post('remark'));
            $dist_code = $this->session->userdata('dist_code');
            $userDesg  = $this->session->userdata('user_desig_code');

            $caseCount   = $this->SettlementCommonDcModel->countSettlementApplicationDetailsByCaseNoCommon($case_no,$dist_code);
            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Put this VGR/PGR application as Under Consideration ! Kindly contact system administrator',
                ));
                return false;
            }

            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR02085: Application already send to SDLAC/CDLAC Committee ! Kindly contact system administrator',

                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR02094: Application not found ! Kindly contact system administrator',
                ));
                return;
            }
            else
            {
                // $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                // if($checkArea != 0)
                // {
                //     echo json_encode(array(
                //         'responseType' => 1,
                //         'message'  => '#ERMR002105: Applied area cannot exceed total Chitha area !',
                //     ));
                //     return;
                // }


                $updateData = array(
                    'status'             => MB_UNDER_CONSIDERATION,
                    'dc_proceeding'      => 0,
                    'consideration_code' => $reason,
                    'consideration_note' => $remark,
                );


                $this->db->trans_begin();
                if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR02126: Updation failed in settlement_basic '. $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#ERMR02126: Unable to process. Kindly contact system administrator !!!!',
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
                        'status'        => MB_UNDER_CONSIDERATION,
                        'user_code'     => $this->session->userdata('user_code'),
                        'date_entry'    => date('Y-m-d h:i:s'),
                        'operation'     => 'E',
                        'note_on_order' => 'Under SDLAC Consideration',
                        'ip'            => $this->utilityclass->get_client_ip(),
                        'office_from'   => $userDesg,
                        'office_to'     => $userDesg,
                        'task'          => 'Under SDLAC Consideration'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERMR02164: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#ERMR02164: Unable to process. Kindly contact system administrator !!!!',
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



    // Chitha/Approve/Applied area 15 bigha reaming calculation  for DC/ADC/SDO/CO/SK/LM
    public function getChithaApproveAppliedAppAreaCalculation()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $case_no   = trim($this->input->post('caseNo'));
            $dist_code = $this->session->userdata('dist_code');
            $userDesg  = $this->session->userdata('user_desig_code');

            $case = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNoDistCode($case_no,$dist_code);

            if($case->num_rows() > 0)
            {
                $caseDetails = $case->row();
                if(in_array($caseDetails->service_code,MB_3_SERVICE_CODE_ALLOW_API_CALL))
                {
                    $setApiLink = API_LINK_MB3;
                }
                else
                {
                    $setApiLink = API_LINK_MB2;
                }

                $appDistrict = trim($caseDetails->dist_code);
                $appSubDiv   = trim($caseDetails->subdiv_code);
                $appCircle   = trim($caseDetails->cir_code);
                $appMouza    = trim($caseDetails->mouza_pargona_code);
                $appLot      = trim($caseDetails->lot_no);
                $appVillage  = trim($caseDetails->vill_townprt_code);

                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $setApiLink . "getTotalVillageAppliedArea");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($curl_handle, CURLOPT_TIMEOUT, 60);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'dist_code'   => $appDistrict,
                    'subdiv_code' => $appSubDiv,
                    'cir_code'    => $appCircle,
                    'mouza_code'  => $appMouza,
                    'lot_no'      => $appLot,
                    'vill_code'   => $appVillage
                )));

                $output = curl_exec($curl_handle);
                $curl_errno = curl_errno($curl_handle);
                $curl_error = curl_error($curl_handle);
                $outputResponse = json_decode($output);
                if ($curl_errno > 0)
                {
                    log_message('error', '#MRAPI010101: API Error for verify area for case:'. $case_no.
                        ' Error'.$curl_error.' ErrorNo'.$curl_errno);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#MRAPI010101: There is some problem ! Kindly contact system administrator',

                    ));
                    return;
                }
                if (isset($outputResponse->responseType))
                {
                    curl_close($curl_handle);
                    if ($outputResponse->responseType == 2)
                    {
                        $output = $outputResponse->data;
                        $apiOutput = $output[0];

                    }
                    elseif ($outputResponse->responseType == 1)
                    {
                        $output = [
                            'tot_applied_bigha' => 0,
                            'tot_applied_katha' => 0,
                            'tot_applied_lessa' => 0,
                            'tot_applied_ganda' => 0,
                            'barak_converted_ganda' => 0,
                            'luit_converted_lessa'  => 0,
                        ];
                        $apiOutput = (object)$output;
                    }
                    else
                    {
                        echo json_encode(array(
                            'responseType' => 1,
                            'message' => '#MRAPI02250: There is some problem ! Kindly contact system administrator',

                        ));
                        return;
                    }

                }
                else
                {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#MRAPI020202: There is some problem ! Kindly contact system administrator',

                    ));
                    return;
                }

                $totalApprovedAreaVillageWise = $this->SettlementCommonDcModel->getApprovedChithaAreaVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $totalPendingAreaVillageWise = $this->SettlementCommonDcModel->getPendingChithaAreaVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $totalAreaInDagVillage = $this->SettlementCommonDcModel->getTotalChithaAreaInDagVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $approveDagAreaLessa = 0;
                $pendingDagAreaLessa = 0;
                $totalReamingArea = 0;
                $totalAppliedArea = 0;
                $process = 0;
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $approveDagAreaLessa = $this->utilityclass->Total_ganda(
                        $totalApprovedAreaVillageWise->dag_bigha,
                        $totalApprovedAreaVillageWise->dag_katha,
                        $totalApprovedAreaVillageWise->dag_lessa,
                        $totalApprovedAreaVillageWise->dag_ganda
                    );
                    $pendingDagAreaLessa = $this->utilityclass->Total_ganda(
                        $totalPendingAreaVillageWise->dag_bigha,
                        $totalPendingAreaVillageWise->dag_katha,
                        $totalPendingAreaVillageWise->dag_lessa,
                        $totalPendingAreaVillageWise->dag_ganda
                    );
                    $chithaDagAreaLessa = $this->utilityclass->Total_ganda(
                        $totalAreaInDagVillage->chitha_bigha,
                        $totalAreaInDagVillage->chitha_katha,
                        $totalAreaInDagVillage->chitha_lessa,
                        $totalAreaInDagVillage->chitha_ganda
                    );
                    $approveDagAreaLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa2($approveDagAreaLessa);
                    $pendingDagAreaLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa2($pendingDagAreaLessa);
                    $chithaDagAreaLessaD  = $this->utilityclass->Total_Bigha_Katha_Lessa2($chithaDagAreaLessa);
                    $lmReportNotSubLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa2($apiOutput->barak_converted_ganda);

                    $totalReamingArea = $chithaDagAreaLessa - $approveDagAreaLessa;
                    $totalAppliedArea = $pendingDagAreaLessa + $apiOutput->barak_converted_ganda;
                    $area = $totalReamingArea - $totalAppliedArea;
                    if($area >= AREA_RESERVE_VILLAGE_WISE * 6400)
                    {
                        $process = 1;
                    }

                    $totalReamingAreaD = $this->utilityclass->Total_Bigha_Katha_Lessa2($area);

                }
                else
                {
                    $approveDagAreaLessa = $this->utilityclass->Total_Lessa(
                        $totalApprovedAreaVillageWise->dag_bigha,
                        $totalApprovedAreaVillageWise->dag_katha,
                        $totalApprovedAreaVillageWise->dag_lessa
                    );
                    $pendingDagAreaLessa = $this->utilityclass->Total_Lessa(
                        $totalPendingAreaVillageWise->dag_bigha,
                        $totalPendingAreaVillageWise->dag_katha,
                        $totalPendingAreaVillageWise->dag_lessa
                    );
                    $chithaDagAreaLessa = $this->utilityclass->Total_Lessa(
                        $totalAreaInDagVillage->chitha_bigha,
                        $totalAreaInDagVillage->chitha_katha,
                        $totalAreaInDagVillage->chitha_lessa
                    );

                    $approveDagAreaLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa($approveDagAreaLessa);
                    $pendingDagAreaLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa($pendingDagAreaLessa);
                    $chithaDagAreaLessaD  = $this->utilityclass->Total_Bigha_Katha_Lessa($chithaDagAreaLessa);
                    $lmReportNotSubLessaD = $this->utilityclass->Total_Bigha_Katha_Lessa($apiOutput->luit_converted_lessa);

                    $totalReamingArea = $chithaDagAreaLessa - $approveDagAreaLessa;
                    $totalAppliedArea = $pendingDagAreaLessa + $apiOutput->luit_converted_lessa;
                    $area = $totalReamingArea - $totalAppliedArea;
                    if($area >= AREA_RESERVE_VILLAGE_WISE * 100)
                    {
                        $process = 1;
                    }
                    $totalReamingAreaD = $this->utilityclass->Total_Bigha_Katha_Lessa($area);
                }

                echo json_encode(array(
                    'responseType' => 2,
                    'lmPendingApiBigha' => $lmReportNotSubLessaD[0],
                    'lmPendingApiKatha' => $lmReportNotSubLessaD[1],
                    'lmPendingApiLessa' => $lmReportNotSubLessaD[2],
                    'lmPendingApiGanda' => $lmReportNotSubLessaD[3],
                    'pendingBigha' => $pendingDagAreaLessaD[0],
                    'pendingKatha' => $pendingDagAreaLessaD[1],
                    'pendingLessa' => $pendingDagAreaLessaD[2],
                    'pendingGanda' => $pendingDagAreaLessaD[3],
                    'approveBigha' => $approveDagAreaLessaD[0],
                    'approveKatha' => $approveDagAreaLessaD[1],
                    'approveLessa' => $approveDagAreaLessaD[2],
                    'approveGanda' => $approveDagAreaLessaD[3],
                    'chithaBigha'  => $chithaDagAreaLessaD[0],
                    'chithaKatha'  => $chithaDagAreaLessaD[1],
                    'chithaLessa'  => $chithaDagAreaLessaD[2],
                    'chithaGanda'  => $chithaDagAreaLessaD[3],
                    'reamingBigha' => $totalReamingAreaD[0],
                    'reamingKatha' => $totalReamingAreaD[1],
                    'reamingLessa' => $totalReamingAreaD[2],
                    'reamingGanda' => $totalReamingAreaD[3],
                    'process'      => $process
                ));

                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR02373: There is some problem ! Kindly contact system administrator',

                ));
                return;
            }
        }
    }



    // count rejected application by co
    public function getAllRejectedApplicationByCoForAdc()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $dist_code    = $this->session->userdata('dist_code');
        $service_code = trim($this->input->get('service'));
        if($service_code == '' OR $service_code == NULL)
        {
            $data['select_data'] = '';
            $data['serviceCode'] = '';
            $data['application'] = 0;
        }
        else
        {
            $data['select_data'] = $this->SettlementCommonDcModel->getCoRejectedCaseForADC($service_code,$dist_code);
            $data['application'] = 1;
            if($service_code == SETTLEMENT_TENANT_ID)
            {
                $data['service_name'] = 'Settlement Occupancy Tenant';
            }
            elseif($service_code == SETTLEMENT_AP_TRANSFER_ID)
            {
                $data['service_name'] = 'Settlement AP';
            }
            elseif($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID)
            {
                $data['service_name'] = 'Settlement Tribal Community';
            }
            elseif($service_code == SETTLEMENT_KHAS_LAND_ID)
            {
                $data['service_name'] = 'Settlement Khasland';
            }
            elseif($service_code == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $data['service_name'] = 'Settlement PGR/VGR land';
            }
            elseif($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID)
            {
                $data['service_name'] = 'Settlement Special Cultivators';
            }
            elseif($service_code == SLIJE_ID)
            {
                $data['service_name'] = NJS_TAGLINE;
            }
            elseif($service_code == BHODDAN_SERVICE_CODE)
            {
                $data['service_name'] = BHODDAN_SERVICE_NAME;
            }
        }


        $data['_view'] = 'settlementView/Adc/rejected_by_co_list_for_adc';
        $this->load->view('layouts/main', $data);
    }


    public function paginationForRejectedApplicationByCoForAdc()
    {
        $this->checkingLoginUserAccessSingleUserOnlyADC();
        $s_code      = trim($this->input->post('service'));
        $search_term = trim($this->input->post('search_term'));
        $remark_cat  = trim($this->input->post('remark_cat'));
        $reverted    = trim($this->input->post('reverted'));


        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

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
            0 => 'case_no',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        if (!empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if(!empty($remark_cat))
        {
            $this->db->where('b.lm_note', $remark_cat);
        }

        $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER));
        $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
        $this->db->where('a.status', $status);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->from('settlement_basic a');

        $query = $this->db->get();

//         echo $this->db->last_query();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }


                $app_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View</a>';

//                $tenant_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                        <i class="fa fa-eye"></i> View</a>';
//                $tribal_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                        <i class="fa fa-eye"></i> View</a>';
//                $ap_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                        <i class="fa fa-eye"></i>  View</a>';
//                $khas_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                       <i class="fa fa-eye"></i>  View</a>';
//                $vgr_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                        <i class="fa fa-eye"></i>  View</a>';
//                $tea_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
//                        <i class="fa fa-eye"></i>  View</a>';


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    '<p><span style="font-size:14px;"><strong>Mouza :</strong> ' . $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . ',
                         <strong>Lot :</strong> ' . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no) . ',
                        </p><p style="line-height: 1px; font-size:14px;"><strong>Village :</strong> ' . $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code) . '</span></p>',

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark,

                    $app_link

//                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                );
            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {
                $this->db->where('b.lm_note', $remark_cat);
            }

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER));
            $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            $this->db->where('a.status', $status);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

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


    // get all rejected application by co
    public function getAllRejectedApplicationByCoForSdo()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $service_code = trim($this->input->get('service'));

        if($service_code == '' OR $service_code == NULL)
        {
            $data['select_data'] = '';
            $data['serviceCode'] = '';
            $data['application'] = 0;
        }
        else
        {
            $data['select_data'] = $this->SettlementCommonDcModel->getCoRejectedCaseForSDO($service_code,$dist_code,$subdiv_code);
            $data['application'] = 1;
            if($service_code == SETTLEMENT_TENANT_ID)
            {
                $data['service_name'] = 'Settlement Occupancy Tenant';
            }
            elseif($service_code == SETTLEMENT_AP_TRANSFER_ID)
            {
                $data['service_name'] = 'Settlement AP';
            }
            elseif($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID)
            {
                $data['service_name'] = 'Settlement Tribal Community';
            }
            elseif($service_code == SETTLEMENT_KHAS_LAND_ID)
            {
                $data['service_name'] = 'Settlement Khasland';
            }
            elseif($service_code == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $data['service_name'] = 'Settlement PGR/VGR land';
            }
            elseif($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID)
            {
                $data['service_name'] = 'Settlement Special Cultivators';
            }
            elseif($service_code == SLIJE_ID)
            {
                $data['service_name'] = NJS_TAGLINE;
            }
            elseif($service_code == BHODDAN_SERVICE_CODE)
            {
                $data['service_name'] = BHODDAN_SERVICE_NAME;
            }



        }


        $data['_view'] = 'settlementView/Sdo/rejected_by_co_list_for_sdo';
        $this->load->view('layouts/main', $data);

    }


    // Pagination for get all rejected application by co
    public function paginationForRejectedApplicationByCoForSdo()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $s_code      = trim($this->input->post('service'));
        $search_term = trim($this->input->post('search_term'));
        $remark_cat  = trim($this->input->post('remark_cat'));
        $reverted    = trim($this->input->post('reverted'));


        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

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
            0 => 'case_no',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        if (!empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if(!empty($remark_cat))
        {
            $this->db->where('b.lm_note', $remark_cat);
        }

        $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER));
        $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
        $this->db->where('a.status', $status);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->from('settlement_basic a');

        $query = $this->db->get();

//         echo $this->db->last_query();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }


                $app_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View</a>';


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    '<p><span style="font-size:14px;"><strong>Mouza :</strong> ' . $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . ',
                         <strong>Lot :</strong> ' . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no) . ',
                        </p><p style="line-height: 1px; font-size:14px;"><strong>Village :</strong> ' . $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code) . '</span></p>',

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark, $app_link

                );
            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {
                $this->db->where('b.lm_note', $remark_cat);
            }

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER));
            $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            $this->db->where('a.status', $status);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

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


    // application revert to co from proposal Under SDLAC Minutes
    public function applicationRevertToCoFromProposalUnderMinutes()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applicationNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('proCaseId', 'Proposal Case Id', 'trim|required');
        $this->form_validation->set_rules('selectProposalId', 'Proposal No', 'trim|required');
        $this->form_validation->set_rules('revertRemarks', 'Revert Remarks', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $proposalCaseId = trim($this->input->post('proCaseId'));
            $revertRemarks  = trim($this->input->post('revertRemarks'));
            $case_no        = trim($this->input->post('applicationNo'));
            $proposalId     = trim($this->input->post('selectProposalId'));
            $dist_code      = $this->session->userdata('dist_code');

            if($this->SettlementCommonDcModel->countSettlementProposalList($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003566: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003579: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003581: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if($caseDetails->status != MB_SEND_TO_SDLAC)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003591: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Revert VGR/PGR application here ! Kindly contact system administrator',
                ));
                return false;
            }

            // proposal in meeting or not
            $proposalDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id != '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003602: Proposal not assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementRevertedProposalCaseDetailsByCaseNo($case_no);
            if($deleteCase->id != $proposalCaseId)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003612: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $this->db->trans_begin();

            $checkReqMod = 0;
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR00253637: Insertion failed in settlement_pull for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0003720: Case not found in Modification Request  ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $this->session->userdata('user_code'),
            );
            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR00253637: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR00253637: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);

            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR003650: Deletion failed in settlement_proposal_cases for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003650: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $this->session->userdata('user_desig_code'),
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR003669: Updating failed in settlement_basic for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003669: Application unable to Revert ! Kindly contact system administrator',

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
                    'status'        => MB_REVERT,
                    'user_code'     => $this->session->userdata('user_code'),
                    'date_entry'    => date('Y-m-d h:i:s'),
                    'operation'     => 'E',
                    'ip'            => $this->utilityclass->get_client_ip(),
                    'office_from'   => $this->session->userdata('user_desig_code'),
                    'office_to'     => MB_CIRCLE_OFFICER,
                    'task'          => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR003706: Insertion failed in settlement_proceeding for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR003706: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $user_code       = $this->session->userdata('user_code');
                        $user_desig_code = $this->session->userdata('user_desig_code');
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => ''
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRPULL003843: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL003843:  Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $revertRemarks,
                            'status'               => 'MR',
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0003896: Insertion failed in settlement_proceeding for case no :'. $case_no. 'Last Q' .$this->db->last_query());
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0003896: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $this->session->userdata('user_desig_code');
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status = json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI003741: Reverted failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                            'message'  => 'Application Successfully Reverted to CO',
                        ));
                        return;
                    }
                }
            }
        }
    }


    // Bulk Revert cases from reverted meeting
    public function bulkRevertCasesInRevertedMeeting()
    {

        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $revertBulkPull   = $this->input->post('revertBulkPull');
        $revertBulkChitha = $this->input->post('revertBulkChitha');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');
        $arrayM = array_unique(array_merge($revertBulkPull,$revertBulkChitha));

        if (empty($arrayM))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBR0003846: Revert request cancelled...! cases missing ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $row_count = 0;
        foreach ($arrayM as $arrayS)
        {
            $case_no = $arrayS;
            $row_count++;
            $tmp_st_time = microtime(true);
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003859: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003867: Application ('.$case_no.') not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if($caseDetails->status != MB_REVERT)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003882: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                ));
                return;
            }
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Revert VGR/PGR application ('.$case_no.') here ! Kindly contact system administrator',
                ));
                return false;
            }

            $getProposalID = $this->SettlementPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
            $proposalId    = trim($getProposalID->proposal_id);
            $checkReqMod = 0;

            $revertRemarks = '';
            if($caseDetails->pull_request != 0)
            {
                $revertRemarks = 'Reverted as requested by CO for Modification';
            }
            else
            {
                $revertRemarks = 'Reverted as settlement area is exceeding Chitha area ';
            }
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRBR0003909: Application ('.$case_no.') not found in Modification Request ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $this->session->userdata('user_code'),
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRBR0003933: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003933: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                ));
                return;
            }
            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRBR0003945: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003945: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $this->session->userdata('user_desig_code'),
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003966: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
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
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003996: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003996: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRBR0004027: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0004027:  Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $revertRemarks,
                            'status'               => 'MR',
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRBR0004051: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0004051: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }
                }
            }
            log_message('error','Time taken: '.(microtime(true)-$tmp_st_time).', count='.$row_count);
        }

        if (isset($arrayM) && count($arrayM)>0)
        {
            $caseAppUrban = $this->SettlementCommonModel->convertLiteral($arrayM);
            $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppUrban)";
            $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

            $rmk    = 'Reverted to CO';
            $status = 'M';
            $task   = $this->session->userdata('user_desig_code');
            $pen    = MB_CIRCLE_OFFICER;
            $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulk($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
            if($rtps_status!="y")
            {
                $this->db->trans_rollback();
                log_message('error', '#MRAPI104213: Issue in API Call'
                    .$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 3,
                    'message'      => '#MRAPI104213: Unable to process for final approval.
                                               Kindly contact system administration !!!',
                ));
                return;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Application Successfully Reverted to CO',
        ));
        return false;


    }


    // Bulk Revert cases from meeting to hold cases to dept
    public function bulkRevertCasesForHoldDeptCases()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $arrayM           = $this->input->post('revertCasesBulk');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');

        if (empty($arrayM))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRHDC0003846: Revert request cancelled...! cases missing ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $row_count = 0;
        foreach ($arrayM as $arrayS)
        {
            $case_no = trim($arrayS);
            $row_count++;
            $tmp_st_time = microtime(true);
            if($this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNoDeptHold($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003859: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return false;
            }
            if($this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003867: Application ('.$case_no.') not found ! Kindly contact system administrator',
                ));
                return false;
            }

            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            if($caseDetails->status != 'O')
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003882: Application ('.$case_no.') already processed ! Kindly contact system administrator',
                ));
                return;
            }
            if(trim($caseDetails->service_code) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC00909: You cannot Revert VGR/PGR application ('.$case_no.') here ! Kindly contact system administrator',
                ));
                return false;
            }

            $getProposalID = $this->SettlementPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
            $proposalId    = trim($getProposalID->proposal_id);
            if($caseDetails->pull_request != 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC02909: You cannot Revert application ('.$case_no.') here ! There is an modification request from CO',
                ));
                return false;
            }

            $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $user_code,
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRHDC0003933: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003933: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                ));
                return;
            }
            $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRHDC0003945: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003945: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->SettlementCommonDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRHDC0003966: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
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
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => 'As forwarding to Department has been stopped'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRHDC0003996: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRHDC0003996: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return;
                }
            }
            log_message('error','Time taken: '.(microtime(true)-$tmp_st_time).', count='.$row_count);
        }

        $caseAppUrban    = $this->SettlementCommonModel->convertLiteral($arrayM);
        $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppUrban)";
        $allAPICases = $this->db->query($caseAppUrbanSql)->row()->applids;

        $rmk    = 'Reverted to CO';
        $status = 'M';
        $task   = $this->session->userdata('user_desig_code');
        $pen    = MB_CIRCLE_OFFICER;
        $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulk($allAPICases,'NA',$rmk,$status,$task,$pen);
        if($rtps_status!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPI104213: Issue in API Call'
                .$this->db->last_query());
            echo json_encode(array(
                'responseType' => 3,
                'message'      => '#MRAPI104213: Unable to process for final approval.
                                               Kindly contact system administration !!!',
            ));
            return false;
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Applications Successfully Reverted to CO',
        ));
        return false;


    }



    // SDLAC Report for DC/ADC/SDO page
    public function getSdlacApprovedMeetingReportPage()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $allAllowDeg     = [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM];

        if(in_array($user_desig_code,$allAllowDeg))
        {
            $data['_view'] = 'SettlementView/sdlac_approve_case_report';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR010101: Unauthorized access for ");
            redirect(base_url() . "index.php/home");
        }
    }


    // SDLAC Report for DC/ADC/SDO Approved
    public function getSdlacApprovedMeetingReport()
    {

        $this->checkingLoginUserAccessAdcDcUser();
        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $allAllowDeg     = [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM];
        if(in_array($user_desig_code,$allAllowDeg))
        {
            $dist_code = $this->session->userdata('dist_code');

            $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE dist_code = '$dist_code'
                    GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

            $circle   = $this->db->query($sql);
            $location =  $circle->result();

            $circleList = array();
            foreach ($location as $key => $circle)
            {
                $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
                $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
                $circleList[$key]['cir_code'] = $circle->cir_code;
            }
            $data['locations'] = $circleList;

            $this->db->select('id,meeting_date,meeting_name,dist_code,subdiv_code');
            $this->db->where('proposal_meeting_list.dist_code', $dist_code);
            $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
            $this->db->where('mb_status', 0);
            $this->db->order_by('proposal_meeting_list.id', 'asc');
            $query = $this->db->get('proposal_meeting_list');

            $data['meetings']  = $query->result();

            $data['_view'] = 'SettlementView/sdlac_approve_case_report_data';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR010101: Unauthorized access for ");
            redirect(base_url() . "index.php/home");
        }
    }


    // SDLAC Report for DC/ADC/SDO Rejected
    public function getSdlacRejectedMeetingReport()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $allAllowDeg     = [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM];
        if(in_array($user_desig_code,$allAllowDeg))
        {
            $dist_code = $this->session->userdata('dist_code');

            $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE dist_code = '$dist_code'
                    GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

            $circle   = $this->db->query($sql);
            $location =  $circle->result();

            $circleList = array();
            foreach ($location as $key => $circle)
            {
                $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
                $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
                $circleList[$key]['cir_code'] = $circle->cir_code;
            }
            $data['locations'] = $circleList;

            $this->db->select('id,meeting_date,meeting_name,dist_code,subdiv_code');
            $this->db->where('proposal_meeting_list.dist_code', $dist_code);
            $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
            $this->db->where('mb_status', 0);
            $this->db->order_by('proposal_meeting_list.id', 'asc');
            $query = $this->db->get('proposal_meeting_list');

            $data['meetings']  = $query->result();

            $data['_view'] = 'SettlementView/sdlac_rejected_case_report_data';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR010101: Unauthorized access for ");
            redirect(base_url() . "index.php/home");
        }
    }


    // update chitha dag flag
    public function updateBulkChithaDagFlagCaseWise()
    {
        $this->checkingLoginUserAccessAdcDcUser();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('serviceCode', 'service', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRCHU004422: Validation error ! Please try again ',
            ]);
            return false;
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $user_code       = trim($this->session->userdata('user_code'));
        $serviceCode     = trim($this->input->post('service'));
        $userAccess      = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];

        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRCHU004437: You are not authorized for this process.! ',
            ]);
            return false;
        }
        if(CHITHA_DAG_FLAG_DIST_CODE != $dist_code)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRCHU004444: You are not authorized for this process.! ',
            ]);
            return false;
        }

        // all updated cases define in constants
        $allCases = CHITHA_FLAG_UPDATE_CASES;

        foreach ($allCases as $case)
        {
            $case_no = trim($case);
            $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
            if($caseCount == 0 || $caseCount == '')
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRCHU004453: Case No '.$case_no.' not found ! ',
                ]);
                return false;
            }

            $caseUpdateEn = $this->SettlementCommonModel->wetlandUpdateToDoByCase($case_no);
            $caseUpdate = json_decode($caseUpdateEn);

            if($caseUpdate->responseType != 2)
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => $caseUpdate->msg,
                ]);
                return false;
            }
        }


        echo json_encode([
            'responseType' => 2,
            'message' => 'All Chitha dag flag successfully updated',
        ]);
        return false;


    }




    // Rejected Landing page for DC only
    public function rejectedListDcLandingPage()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        $rejectedListCountKhas   = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_KHAS_LAND_ID, MB_DEPUTY_COMM);
        $rejectedListCountVGR    = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_PGR_VGR_LAND_ID, MB_DEPUTY_COMM);
        $rejectedListCountTea    = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID, MB_DEPUTY_COMM);
        $rejectedListCountTribal = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_TRIBAL_COMMUNITY_ID, MB_DEPUTY_COMM);
        $rejectedListCountAp     = $this->SettlementCommonDcModel->rejectedCaseList($dist_code,SETTLEMENT_AP_TRANSFER_ID, MB_DEPUTY_COMM);

        $data['rejectedListCountKhas']   = $rejectedListCountKhas;
        $data['rejectedListCountVGR']    = $rejectedListCountVGR;
        $data['rejectedListCountTea']    = $rejectedListCountTea;
        $data['rejectedListCountTribal'] = $rejectedListCountTribal;
        $data['rejectedListCountAp']     = $rejectedListCountAp;

        $data['_view'] = 'settlementView/Dc/rejected_case_landing_page_dc';
        $this->load->view('layouts/main', $data);
    }


    // Rejected list page for DC only
    public function rejectedListDcServiceWise()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $service_code = $this->input->get('service');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $status = 'D';

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }
        if($service_code == '')
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        $data['select_data'] = $this->SettlementCommonDcModel->locationSelectCoRejectCasesDc($service_code, $status);
        $data['_view'] = 'SettlementView/rejected_case_list_dc';

        $this->load->view('layouts/main', $data);
    }


    // Rejected list pagination for DC only
    public function rejectedListDcPagination()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $s_code      = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat  = $this->input->post('remark_cat');
        $user_code   = $this->session->userdata('user_code');
        $lot_no      = $this->input->post('lot_no');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $pending_office     = $this->input->post('pending_office');
        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];


        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3))
        {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if(!empty($remark_cat))
        {
            $this->db->where('b.lm_note', $remark_cat);
        }

        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat))
        {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        else
        {
            $this->db->where_in('a.from_office', array($pending_office));
        }

        $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
        $this->db->where('a.status', 'D');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status in(1)', array($rows->case_no));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="mt-2 btn btn-sm btn-warning">Flag for Revival</button>';
                }

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                $app_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>'.$revival_flg_button;

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark,$app_link

                );
            }

            $this->db->where('a.service_code', $s_code);
            if(!empty($remark_cat))
            {
                $this->db->where('b.lm_note', $remark_cat);
            }
            if(!empty($dist_code))
            {
                $this->db->where('a.dist_code', $dist_code);
            }
            if(!empty($subdiv_code))
            {
                $this->db->where('a.subdiv_code', $subdiv_code);
            }
            if(!empty($cir_code))
            {
                $this->db->where('a.cir_code', $cir_code);
            }
            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }
            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }
            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat))
            {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }
            else
            {
                $this->db->where_in('a.from_office', array($pending_office));
            }
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            $this->db->where('a.status', 'D');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            if($this->session->userdata('user_desig_code') == 'SDO')
            {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            }

            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        }
        else
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }







    // Revival Landing page for DC only
    public function revivalListDcLandingPage()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        $revivalListCountKhas   = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_KHAS_LAND_ID, MB_DEPUTY_COMM);
        $revivalListCountVGR    = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_PGR_VGR_LAND_ID, MB_DEPUTY_COMM);
        $revivalListCountTea    = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_SPECIAL_CULTIVATORS_ID, MB_DEPUTY_COMM);
        $revivalListCountTribal = $this->SettlementCommonDcModel->revivalListCount($dist_code,SETTLEMENT_TRIBAL_COMMUNITY_ID, MB_DEPUTY_COMM);

        $data['revivalListCountKhas']   = $revivalListCountKhas;
        $data['revivalListCountVGR']    = $revivalListCountVGR;
        $data['revivalListCountTea']    = $revivalListCountTea;
        $data['revivalListCountTribal'] = $revivalListCountTribal;

        $data['_view'] = 'settlementView/Dc/revival_case_landing_page_dc';
        $this->load->view('layouts/main', $data);
    }


    // Revival list page for DC only
    public function revivalListDcServiceWise()
    {
        $service_code = $this->input->get('service');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $status = 'D';

        if($user_desig_code != MB_DEPUTY_COMM)
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }
        if($service_code == '')
        {
            $this->session->set_flashdata('message', " You Are not Authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        $data['select_data'] = $this->SettlementCommonDcModel->locationSelectCoRejectCasesDc($service_code, $status);
        $data['_view'] = 'SettlementView/revival_case_list_dc';

        $this->load->view('layouts/main', $data);
    }


    // Revival list pagination for DC only
    public function revivalListDcPagination()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $s_code = $this->input->post('service');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $pending_office     = $this->input->post('pending_office');
        $lot_no = $this->input->post('lot_no');
        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $r_head_filter = $this->input->post('r_head_filter');

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        $this->db->where('a.service_code', $s_code);
        $this->db->where_in('a.from_office', array($pending_office));
        $this->db->select('distinct(a.case_no)');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no');
        $this->db->where('b.req_by', $this->session->userdata('user_desig_code'));
        $this->db->where('b.revival_status = \'1\'');
        $this->db->from('settlement_basic a');
        $this->db->get();
        //***First query */
        $activeQuery1 = $this->db->last_query();

        $this->db->select('distinct(a.case_no)');
        $this->db->from('settlement_basic a');
        $this->db->join('rejected_remark c', 'a.case_no = c.case_no');
        $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no', 'left');
        $this->db->where('a.service_code', $s_code);
        $this->db->where_in('a.from_office', array($pending_office));
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

        if(!empty($r_head_filter) && $r_head_filter != '10')
        {
            $this->db->where('c.reject_code', $r_head_filter);
        }

        $this->db->where_in('c.reject_code', REVIVAL_REJECT_CODE);;
        // Execute the main query
        $this->db->get();
        //****second query */
        $activeQuery2 = $this->db->last_query();

        $this->db->distinct()->select('a.case_no, r.revival_reason_code, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry', false);
        $this->db->from('settlement_basic a');
        $this->db->where('a.status', 'D');
        $this->db->join('settlement_revival_flag r', 'a.case_no = r.case_no', 'left');

        if(!empty($r_head_filter) && $r_head_filter == '10')
        {
            $this->db->where("a.case_no IN ($activeQuery1)", null, false);
        }
        elseif(!empty($r_head_filter) && $r_head_filter != '10')
        {
            $this->db->where("a.case_no IN ($activeQuery2)", null, false);
        }
        else
        {
            $this->db->where("a.case_no IN ($activeQuery1 UNION $activeQuery2)", null, false);
        }


        $this->db->limit($length, $start);

        //***conditions */
        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }
        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }
        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }
        $valid_columns = array(
            0 => 'date_entry',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }
        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }
        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }


        // Execute the main query
        $query = $this->db->get();

        // echo $this->db->last_query()

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {

                $getRejectRemark = $this->db->query("select string_agg(distinct(b.remark),', ') as remark from rejected_remark a join reject_master b on a.reject_code::varchar = b.reject_code::varchar where case_no = ?", array($rows->case_no))->row()->remark;

                $app_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';


                //*****revival_reason retrieve */

                $revival_reason_code = $rows->revival_reason_code;

                $revival_reason = '';

                foreach(json_decode(REVIVAL_REASONS) as $rr_res)
                {
                    if($rr_res->CODE == $revival_reason_code)
                    {
                        $revival_reason = $rr_res->NAME;
                    }
                }

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    '<span class="alert-warning"><b>'.$revival_reason.'</b></span>',

                    '<small><b>'.$getRejectRemark.'</b></small>',

                    $app_link
                );
            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where_in('a.from_office', array($pending_office));
            $this->db->select('distinct(a.case_no)');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no');
            $this->db->where('b.req_by', $this->session->userdata('user_desig_code'));
            $this->db->where('b.revival_status = \'1\'');
            $this->db->from('settlement_basic a');
            $this->db->get();
            //***First query */
            $activeQuery1 = $this->db->last_query();

            $this->db->select('distinct(a.case_no)');
            $this->db->from('settlement_basic a');
            $this->db->join('rejected_remark c', 'a.case_no = c.case_no');
            $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no', 'left');
            $this->db->where('a.service_code', $s_code);
            $this->db->where_in('a.from_office', array($pending_office));
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where_in('c.reject_code', REVIVAL_REJECT_CODE);;
            // Execute the main query
            $this->db->get();
            //****second query */
            $activeQuery2 = $this->db->last_query();

            $this->db->distinct()->select('a.case_no, r.revival_reason_code, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry', false);
            // $this->db->from('settlement_basic a');
            $this->db->join('settlement_revival_flag r', 'a.case_no = r.case_no', 'left');
            $this->db->where("a.case_no IN ($activeQuery1 UNION $activeQuery2)", null, false);;
            // $this->db->get();
            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }
            if (!empty($searchByCol_0)) {

                $this->db->like('a.case_no', strtoupper($searchByCol_0));
            }

            if (!empty($searchByCol_1)) {

                $this->db->like('a.applid', strtoupper($searchByCol_1));
            }

            if (!empty($searchByCol_3)) {
                $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            }

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







    // code by JS
    public function clusterList()
    {
        $userData = $this->session->userdata;
        $dist_code = $userData['dist_code'];
        $clusterList = $this->SettlementCommonDcModel->getClusterList($dist_code);
        $data['clusterListCount'] = $clusterList->num_rows();
        $clusterList  = $clusterList->result();

        $finalArr = array();

        foreach($clusterList as $clist)
        {
            //****getting the count of cases in the cluster */

            $clusCountSql = $this->db->query('select count(*) as c from settlement_circle_cluster_cases where cluster_id = ?', array($clist->cluster_id));

            $clusterCasesCount = $clusCountSql->row()->c;

            //*******total processed */
            $url = API_LINK_MB2.'getCaseCountByCircle/'.$clist->dist_code.'/'.$clist->subdiv_code.'/'.$clist->cir_code.'/'.SETTLEMENT_PGR_VGR_LAND_ID;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $apiTot = json_decode($response);

            //****creating the final data array */
            $finalArr[] = (object)[
                'dist_code' => $clist->dist_code,
                'subdiv_code' => $clist->subdiv_code,
                'cir_code' => $clist->cir_code,
                'status' => $clist->status,
                'pending_at' => $clist->pending_at,
                'cluster_id' => $clist->cluster_id,
                'cir_name' => $this->utilityclass->getCircleName($clist->dist_code, $clist->subdiv_code, $clist->cir_code),
                'clusterCaseCount' => $clusterCasesCount,
                'total_applied' => $apiTot[0]->total,
                'total_pending' =>  $apiTot[0]->pending,
                'total_rejected' =>  $apiTot[0]->rejected,
                'total_delivered' =>  $apiTot[0]->delivered,
            ];
        }

        $data['clusterList'] = $finalArr;

        $data['_view'] = 'settlementView/Dc/Common/cluster_liset';
        $this->load->view('layouts/main', $data);
    }

    public function clusterReReport()
    {
        $userData = $this->session->userdata;
        $dist_code = $userData['dist_code'];
        $clusterList = $this->SettlementCommonDcModel->getClusterReReport($dist_code);
        $data['clusterList']  = $clusterList->result();
        $data['clusterListCount'] = $clusterList->num_rows();
        $data['_view'] = 'settlementView/Dc/Common/cluster_list_re_report';
        $this->load->view('layouts/main', $data);
    }

    public function viewClusterCases()
    {
        $cluster_id = $this->input->post('cluster_id');
        $sql = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

        if($sql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => 'ERR3778: No cases found in this cluster!',
            ]);
            return false;
        }

        $results = $sql->result();

        $casesArray = array();

        foreach($results as $res)
        {
            $case_no = $res->case_no;
            $case_status_sql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

            if($case_status_sql->num_rows() <= 0)
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3795: Something went wrong! Contact admin...',
                ]);
                return false;
            }

            $basicRow = $case_status_sql->row();

            $casesArray[] = (object)[
                'case_no' => $basicRow->case_no,
                'status' => $basicRow->status,
                'pending_officer' => $basicRow->pending_officer,
            ];
        }

        echo json_encode([
            'responseType' => 2,
            'content' => $casesArray
        ]);
    }

    public function rejectedList()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoRejectCases($service_code, $status);
        $data['_view'] = 'SettlementView/rejected_case_list';

        $this->load->view('layouts/main', $data);
    }

    public function rejectedListPagination()
    {
        $s_code      = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat  = $this->input->post('remark_cat');
        $user_code   = $this->session->userdata('user_code');
        $lot_no      = $this->input->post('lot_no');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');


        $pending_office     = $this->input->post('pending_office');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3))
        {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if(!empty($dist_code))
        {
            $this->db->where('a.dist_code', $dist_code);
        }
        if(!empty($subdiv_code))
        {
            $this->db->where('a.subdiv_code', $subdiv_code);
        }
        if(!empty($cir_code))
        {
            $this->db->where('a.cir_code', $cir_code);
        }

        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat))
        {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        else
        {
            $this->db->where_in('a.from_office', array($pending_office));
        }

        $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

        $this->db->where('a.status', 'D');

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

        if($this->session->userdata('user_desig_code') == 'SDO')
        {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        }

        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status in(1)', array($rows->case_no));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    if($rows->service_code == '13')
                    {
                        if($this->session->userdata('user_desig_code') == 'DC')
                        {
                            $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="mt-2 btn btn-sm btn-warning">Flag for Revival</button>';
                        }
                        else
                        {
                            $revival_flg_button = '';
                        }
                    }
                    else
                    {
                        $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="mt-2 btn btn-sm btn-warning">Flag for Revival</button>';
                    }
                }

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                $app_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>'.$revival_flg_button;


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark, $app_link
                );
            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }
            $this->db->where_in('a.pending_officer', array($pending_office));

            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

            $this->db->where('a.status', 'D');

            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

            if($this->session->userdata('user_desig_code') == 'SDO')
            {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            }

            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

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

}
