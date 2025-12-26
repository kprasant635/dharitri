<?php

class SettlementProposalControllerIns extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('SettlementMb/SettlementMeetingDcInsModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementMb/SettlementMeetingDcModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('ProgressModel');

        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

    }

    public function dbswitch()
    {
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


    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags                 = $this->SettlementApModel->getSettlementDag($application_no);
        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck            = 0;
        $appliedDags          = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic                = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        $newDag = '';

        if (!in_array(trim($basic->service_code), MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL))
        {
            echo 'Case Number '. $application_no . 'is not belongs to MB3';
            die();
        }

        if($basic->service_code == SETTLEMENT_AP_TRANSFER_ID)
        {
            $newDag = $appliedDags[0]->new_dag_no;
            if($newDag != '')
            {
                foreach ($dags as $dag)
                {
                    $totalReservedAreaInApplication = 0;
                    $totalAppliedAreaInApplication  = 0;
                    $totalAreaInApplicationNR       = 0;

                    $appDistrict = $dag->dist_code;
                    $appSubDiv = $dag->subdiv_code;
                    $appCircle = $dag->cir_code;
                    $appMouza = $dag->mouza_pargona_code;
                    $appLot = $dag->lot_no;
                    $appVillage = $dag->vill_townprt_code;
                    $appDag = $dag->dag_no;

                    // chitha details for new Dag
                    $chithaDag = $this->SettlementCommonDcModel->getNewChithaDagAreaDetails(
                        $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $newDag);

                    $reservation = $this->SettlementCommonDcModel->getSettlementReservationCommon($application_no);

                    if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
                    {
                        // chitha
                        $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                        $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                        $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                        $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                        $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if ($appDag == $singleAppArea->dag_no)
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

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $gandaReservedApp = $this->UtilsModel->defaultValue($singleApp->ganda, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 6400) + ($kathaReservedApp * 320) + ($lessaReservedApp * 20) + $gandaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha == 0)
                        {
                            $areaCheck = 1;
                        }
                        if(($totalAppliedAreaInApplication - $totalReservedAreaInApplication) == 0)
                        {
                            $areaCheck = 1;
                        }
                        if ($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
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

                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if ($appDag == $singleAppArea->dag_no)
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

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 100) + ($kathaReservedApp * 20) + $lessaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha == 0)
                        {
                            $areaCheck = 1;
                        }
                        if(($totalAppliedAreaInApplication - $totalReservedAreaInApplication) == 0)
                        {
                            $areaCheck = 1;
                        }
                        if ($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
                        {
                            $areaCheck = 1;
                        }
                        if($totalAppliedAreaInApplication > $totalAreaInApplicationNR)
                        {
                            $areaCheck = 1;
                        }
                    }
                }
            }
            else
            {
                $areaCheck = 1;
            }
        }
        else
        {
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
                    $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                    $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                    $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                    $gandaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                    $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                    // SOD/ADC processing application
                    foreach ($allApplicationDags as $singleApp)
                    {
                        $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                        $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                        $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                        $gandaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
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

                    //SOD/ADC processing application
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


    // view page
    public function commonProposalListView()
    {
        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');
        $data['dist_code'] = $dist_code;

        $pendingCase              = $this->SettlementCommonDcModel->getPendingProposalsMbTin($dist_code,$createdBy);
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['countPendingCase'] = $this->SettlementCommonDcModel->getPendingProposalsReadyForMeetingMbTin($dist_code,MB_ADD_DEPUTY_COMM);
        $commMembers              = $this->SettlementMbDcModel->getMembersFromUsersWithUserType($dist_code);
        $data['committeeList']    = $commMembers;
        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'SettlementView/Adc/common_proposal_list_forward_to_dc_ins';
        $this->load->view('layouts/main', $data);
    }


    //insert new nominee of SDLAC/CDLAC Member`s
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


    // list of common proposals for all services
    public function listOfProposalsAllServices()
    {
        $cir_code    = $this->input->post('circle');
        $subdiv_code = $this->input->post('subdiv');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');
        $village     = $this->input->post('vill_id');
        $ru          = $this->session->userdata('user_desig_code');

        $service     = $this->input->post('service_code');
        $by_case_no  = $this->input->post('case_no');
        $proposal_no = $this->input->post('proposal_no');
        $dist_code   = $this->session->userdata('dist_code');

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
            $dir = 'desc';
        }
        $valid_columns = array(
            0   => 'settlement_proposal_list.h_date',
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
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
            $this->db->where('settlement_proposal_list.status', 1);
            $this->db->where('settlement_proposal_list.mb_status', 3);
            $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
            $this->db->where_in('settlement_proposal_list.service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where("(settlement_proposal_list.user_code = '" . $this->session->userdata('user_code') . "' OR settlement_proposal_list.user_code IS NULL)", null, false);
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.meeting_create_status', 1);
        }
        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('mb_status', 3);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('meeting_create_status', 1);
            $this->db->where('id', $proposal_no);
            $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
            $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        }
        else if (!empty($service)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('mb_status', 3);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('meeting_create_status', 1);
            $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
            $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        }

        $this->db->select('*');
        $this->db->where('settlement_proposal_list.dist_code', $dist_code);
        $this->db->where('settlement_proposal_list.meeting_create_status', 1);
        $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
        $this->db->where('settlement_proposal_list.mb_status', 3);
        $this->db->where_in('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
        $this->db->where_in('settlement_proposal_list.service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $this->db->where("(settlement_proposal_list.user_code = '" . $this->session->userdata('user_code') . "' OR settlement_proposal_list.user_code IS NULL)", null, false);
        $this->db->limit($length, $start);
        $this->db->order_by('settlement_proposal_list.id', 'asc');
        $query = $this->db->get('settlement_proposal_list');
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($by_case_no)) { //join table settlement_proposal_cases
                $this->db->select('*');
                $this->db->from('settlement_proposal_cases');
                $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_list.status', 1);
                $this->db->where('settlement_proposal_list.mb_status', 3);
                $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where("(settlement_proposal_list.user_code = '" . $this->session->userdata('user_code') . "' OR settlement_proposal_list.user_code IS NULL)", null, false);
                $this->db->where_in('settlement_proposal_list.service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
                $this->db->where('settlement_proposal_list.meeting_create_status', 1);
            }
            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('mb_status', 3);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('meeting_create_status', 1);
                $this->db->where('id', $proposal_no);
                $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
                $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            }

            else if (!empty($service)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('mb_status', 3);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('meeting_create_status', 1);
                $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
                $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            }

            $this->db->select('*');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('meeting_create_status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('mb_status', 3);
            $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
            $this->db->where_in('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
            $query1 = $this->db->get('settlement_proposal_list');

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $json[] = array(

                    $rows->id,

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->proposal_name .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>
                <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    $this->utilityclass->getServiceName($rows->service_code),

                    date('d-M-Y', strtotime($rows->h_date)),

                    '<a class="btn btn-xs btn-primary" style=" padding: 7px!important; margin-bottom: 5px!important" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">
                        <i class="fa fa-print" aria-hidden="true"></i> Notice
                    </a>
                         
                    <a class="btn btn-xs btn-dark" style=" padding: 7px!important; margin-bottom: 5px!important" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonIns/downloadCasesWithProposalId/?case='.$rows->id.'">
                        <i class="fa fa-download" aria-hidden="true"></i> Excel
                    </a>
                    
                    <a class="btn btn-xs btn-success" style=" padding: 7px!important; margin-bottom: 5px!important" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementProposalControllerIns/proposalEditOnSdlacMinutesAdc/?case='.$rows->id.'">
                        <i class="fa fa-edit" aria-hidden="true"></i> Edit Proposal
                    </a>'

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


    // generate Meeting Id Sequence No
    function generateProposalIdSequenceNo()
    {
        $proposalId = $this->db->query("select nextval('proposal_meeting_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    public function getCasesAgainstProposalNo(){
        $proposal_id  = $this->input->post('id');
        $dist_code    = $this->session->userdata('dist_code');
        $user_code    = $this->session->userdata('user_code');

        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
    settlement_proposal_cases A JOIN settlement_proposal_list B ON
    B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=?", array($proposal_id, $dist_code));

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }


    public function checkAllSdlacPresentMember()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $proposals = $this->input->post('selectedList');
            $dist_code = $this->session->userdata('dist_code');

            $allProposals = '';
            $index = 0;
            $i = count($proposals);
            foreach ($proposals as $proposal)
            {
                if ($index == $i - 1)
                {
                    $allProposals .= "'".$proposal."'";
                }
                else
                {
                    $allProposals .= "'".$proposal."'". ",";
                }
                $index++;
            }

            // check for PGR/VGR not allowed in other proposals
            $proSql = $this->db->query("SELECT service_code FROM settlement_proposal_list
                                          WHERE id IN ($allProposals) AND dist_code=? AND mb_status=?",
                array($dist_code,3));

            $allSelectedProposal = $proSql->result_array();
            $checkVal = array_map("unserialize", array_unique(array_map("serialize", $allSelectedProposal)));

            if(count($checkVal) > 1)
            {
                if(in_array(SETTLEMENT_PGR_VGR_LAND_ID, array_column($checkVal, 'service_code')))
                {
                    echo json_encode(array(
                        'responseType'   => 3,
                        'message' => "PGR/VGR not allowed in other proposals",
                    ));
                    return;
                }
            }

            $sql = $this->db->query("SELECT DISTINCT(user_code), nominee FROM sdlac_present_member
                                          WHERE proposal_id IN ($allProposals)
                                            AND status=? AND dist_code=?",
                array(1, $dist_code));


            $memberPresents = $sql->result();

            echo json_encode(array(
                'responseType'   => 2,
                'memberPresents' => $memberPresents,

            ));
            return;

        }
    }


    // Generate minute b4 send to DC verification
    public function sendProposalsToDcMinute()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meeting_date = $this->input->post('meeting_date');
        if(MEETING_PROPOSAL_SDLAC_NOTICE_HOLD_INSTITUTE == 1)
        {
            if(date('Y-m-d H:i:s',strtotime(MEETING_PROPOSAL_SDLAC_NOTICE_DATE_INSTITUTE)) < date('Y-m-d H:i:s',strtotime($meeting_date)))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'response'     => 1,
                    'message'      => 'Maximum Date of meeting '.MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW_INSTITUTE
                ));
                return;
            }
        }


        $meeting_venue   = $this->input->post('meeting_venue');
        $meeting_remarks = $this->input->post('meeting_remarks');
        $nominee         = json_decode($this->input->post('nominee'));
        $proposals       = json_decode($this->input->post('proposals'));
        $dist_code       = $this->session->userdata('dist_code');
        $selectMem       = json_decode($this->input->post('selectMem'));

        if($this->SettlementCommonDcModel->checkProposalAlreadyExistInMeeting($proposals) != 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Some of the Proposals Already listed in Meeting ! kindly check in SDLAC/CDLAC Minutes list',
            ];
            echo json_encode($json);
            return false;
        }


        if($this->SettlementCommonDcModel->checkProposalMatchWithMbTwoWithMbThree($proposals) != 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Some of the Proposals Mismatch with MB 2.0 !',
            ];
            echo json_encode($json);
            return false;
        }

        $allMembers = $this->SettlementCommonDcModel->getMembersFromUsers($dist_code);

        $allSelectedMember = [];
        $commMembers = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[]= $member->check_status;
        }


        $i= 0;
        foreach ($allMembers as $mem)
        {
            if(in_array($mem->user_code,$allSelectedMember))
            {
                if ($mem->user_code == $nominee[$i]->sdlac_user && $nominee[$i]->select_nominee != 0)
                {
                    $nn = $this->SettlementCommonDcModel->getNomineeName($nominee[$i]->select_nominee);
                    if($mem->display_name == '')
                    {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->name . ', ' . $mem->designation;
                    }
                    else
                    {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->display_name;
                    }
                }
                else
                {
                    if($mem->display_name == '')
                    {
                        $commMembers[] = $mem->name . ', ' . $mem->designation;
                    }
                    else
                    {
                        $commMembers[] = $mem->display_name;
                    }
                }
            }
            $i = $i + 1;
        }

        if(count($commMembers) == 0)
        {
            $json = [
                'response' => 1,
                'message'  => '#ERMR000491: There is no SDLAC/CDLAC Member, Kindly Select SDLAC Members',
            ];
            echo json_encode($json);
            return false;
        }

        $subdiv_code  = $this->session->userdata('subdiv_code');
        $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $allProposalCases = $this->generateProposalCases($proposals);
        $caseList     = $allProposalCases['final_result_array_rec'];
        $caseDivNot   = $allProposalCases['final_result_array_not_rec'];

        $subDivArray = [];
        foreach ($caseList as $key => $value)
        {
            $subDivArray[] = $value['subdiv_code'];
        }

        $uniqueArraySub = array_unique($subDivArray);

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



        // for VGR/PGR only
        $checkVGRPGRCluster = $allProposalCases['CheckClusterStatus'];
        if(isset($checkVGRPGRCluster) && $checkVGRPGRCluster != NULL)
        {
            foreach ($checkVGRPGRCluster as $singleVgrPgrError)
            {
                if($singleVgrPgrError['response'] == 1)
                {
                    echo json_encode(array(
                        'response' => 1,
                        'message'  => $singleVgrPgrError['message']
                    ));
                    return false;
                }
            }
        }


        // reservation area for VGR PGR
        $vgrPgrStatus = $allProposalCases['vgrPgrStatus'];
        $reservationDetails = array();
        if(trim($vgrPgrStatus) == 1)
        {
            foreach ($proposals as $key => $proposal_id)
            {
                if($this->SettlementCommonDcModel->countClusterIdByProposal($proposal_id) == 0)
                {
                    $json = [
                        'response' => 1,
                        'message'  => 'Cluster not found ! Kindly contact system administrator ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                $cluster_id = $this->SettlementCommonDcModel->getClusterIdByProposal($proposal_id);
                $reservationDetailData = $this->getReservationDetailsVGRPGR($cluster_id,MB_SEND_TO_SDLAC);
                if($reservationDetailData['responseType'] != 0)
                {
                    $reservationDetails[]  = $reservationDetailData;
                }
                else
                {
                    $json = [
                        'response' => 1,
                        'message'  => $reservationDetailData['message']
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
        }


        $generate_meeting_id = $this->generateProposalIdSequenceNo();
        $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName = substr($dist_name->locname_eng, 0, 3);
        $memoName    = $distEngName.'/MEMO-MB/'.date("Y").'/'.$generate_meeting_id;
        $meetingName = $distEngName.'/SDLAC-MB/'.date("Y").'/'.$generate_meeting_id;

        $proposalDetails = $this->SettlementCommonDcModel->getAllProposalDetailsByProIdMbTin($proposals);

        $createdUserCode = $proposalDetails[0]->user_code;
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == MB_ADD_DEPUTY_COMM)
        {
            $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
        }
        else
        {
            $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
        }
        if($countCopy == 0)
        {
            $proposalCreatedBy = '';
        }
        else
        {
            $proposalCreatedBy = $createdUserCode;
        }


        $userMp = $this->SettlementCommonDcModel->getUsersMpCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMpCount = $userMp->num_rows();
        $userMp = $userMp->result();

        $userMla = $this->SettlementCommonDcModel->getUsersMlaCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMlaCount = $userMla->num_rows();
        $userMla = $userMla->result();

        $userSdlac = $this->SettlementCommonDcModel->getUsersSdlacCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userSdlacCount = $userSdlac->num_rows();
        $userSdlacList  = $userSdlac->result();



        if($userMpCount == 0 OR $userMlaCount == 0 OR $userSdlacCount == 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Minutes Copy to Members are incomplete ! Kindly Add Members For Minutes Copy To ',
            ];
            echo json_encode($json);
            return false;
        }
        else
        {

            $mpName = '';
            $mpHPC  = '';
            $indexM = 0;
            foreach ($userMp as $mp)
            {
                if ($indexM == 0)
                {
                    if($mp->hpc_type == 'HPC')
                    {
                        $mpName = $mp->user_name;
                        $mpHPC  = $mp->hpc_lac;
                    }
                    else
                    {
                        $mpName = $mp->user_name;
                        $mpHPC  = $mp->hpc_lac. ' '.$mp->hpc_type;
                    }

                }
                else
                {
                    if($mp->hpc_type == 'HPC')
                    {
                        $mpName = $mpName . ", " . $mp->user_name;
                        $mpHPC  = $mpHPC . ", " . $mp->hpc_lac;
                    }
                    else
                    {
                        $mpName = $mpName . ", " . $mp->user_name;
                        $mpHPC  = $mpHPC . ", " . $mp->hpc_lac. ' '.$mp->hpc_type;
                    }
                }
                $indexM++;
            }

            $mlaName = '';
            $mlaLAC = '';
            $index = 0;
            foreach ($userMla as $mla)
            {
                if ($index == 0)
                {
                    $mlaName = $mla->user_name;
                    $mlaLAC = $mla->hpc_lac;
                }
                else
                {
                    $mlaName = $mlaName . ", " . $mla->user_name;
                    $mlaLAC = $mlaLAC . ", " . $mla->hpc_lac;
                }
                $index++;
            }


            $zpcName = '';
            $municipalName = '';
            $socialWorker = '';
            $indexM = 0;
            $indexS = 0;
            foreach ($userSdlacList as $user)
            {
                if($user->user_level == 6)
                {
                    $zpcName = $user->user_name;
                }
                if($user->user_level == 7)
                {
                    if ($indexM == 0)
                    {
                        $bn = '';
                        if($user->board_name != '')
                        {
                            $bn = '(' .$user->board_name. ') ';
                        }
                        $municipalName = $user->user_name.$bn;
                    }
                    else
                    {
                        $bn = '';
                        if($user->board_name != '')
                        {
                            $bn = '(' .$user->board_name. ') ';
                        }
                        $municipalName = $municipalName . ", " . $user->user_name.$bn;
                    }
                    $indexM++;
                }
                if($user->user_level == 8)
                {
                    if ($indexS == 0)
                    {
                        $socialWorker = $user->user_name;
                    }
                    else
                    {
                        $socialWorker = $socialWorker . "," . $user->user_name;
                    }
                    $indexS++;
                }

            }

            echo json_encode(array(
                'responseType' => 2,
                'meetingId' => $generate_meeting_id,
                'meetingName' => $meetingName,
                'memoName' => $memoName,
                'districtName' => $districtName->locname_eng,
                'subDivName' => $subdiv_name,
                'meetingDate' => date("F j, Y", strtotime($meeting_date)),
                'timing' => strtoupper(date("h:i a", strtotime($meeting_date))),
                'meetingVenue' => $meeting_venue,
                'nominee' => $commMembers,
                'proposals' => $proposals,
                'caseList' => $caseList,
                'caseDivNot' => $caseDivNot,
                'proposalDetails' => $proposalDetails,
                'mpName' => $mpName,
                'mpHPC' => $mpHPC,
                'mlaName' => $mlaName,
                'mlaLAC' => $mlaLAC,
                'zpcName' => $zpcName,
                'municipalName' => $municipalName,
                'socialWorker' => $socialWorker,
                'reservationDetails' => $reservationDetails,
                'meeting_remarks_show' => $meeting_remarks,

            ));

            return;
        }
    }


    // get vgr/pgr reservation details for minutes
    public function getReservationDetailsVGRPGR($cluster_id,$status)
    {
        $dist_code  = $this->session->userdata('dist_code');
        $cluster_id = trim($cluster_id);
        $status     = trim($status);

        //*****getting the circle location */
        $circleLocationSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ? and dist_code = ?', array($cluster_id,$dist_code));

        if($circleLocationSql->num_rows() <= 0)
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRV001074: Cluster not found ! Kindly contact system administrator '
            );
            return $reservations;
        }

        $cirLoc          = $circleLocationSql->row();
        $cir_dist_code   = $cirLoc->dist_code;
        $cir_subdiv_code = $cirLoc->subdiv_code;
        $cir_cir_code    = $cirLoc->cir_code;

        //check if all cases selected to be approved by either department(urban) or dc(rural)
        $clustSql = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

        if($clustSql->num_rows() <= 0)
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRV001089: Cases not found in Cluster! Kindly contact system administrator '
            );
            return $reservations;
        }

        $cluster_cases = $clustSql->result();
        $allSelectedList = array();

        foreach($cluster_cases as $ccs)
        {
            $clu_case = trim($ccs->case_no);
            $sqlBasicCheck = $this->SettlementVgrModel->getSettlementBasic($clu_case);

            if($sqlBasicCheck['status'] != trim($status))
            {
                $reservations = array(
                    'responseType' => 0,
                    'message'      => '#MRCLRV001106: Some cases of this cluster is still pending ! Kindly contact system administrator '
                );
                return $reservations;
            }
            $allSelectedList[] = $clu_case;
        }

        if(!empty($allSelectedList))
        {
            $reservationDetails = array();

            foreach ($allSelectedList as $row)
            {
                $case_no = trim($row);
                $rSql    = $this->db->query('select r.case_no, r.dist_code,r.subdiv_code,r.cir_code,r.mouza_pargona_code,r.lot_no,r.vill_townprt_code,r.dag_no from settlement_vgr_pgr_reservation r where r.case_no = ?', array($case_no));

                if($rSql->num_rows() <= 0)
                {
                    $reservations = array(
                        'responseType' => 0,
                        'message'      => '#MRCLRV001126: Something went wrong ! Kindly contact system administrator '
                    );
                    return $reservations;
                }

                $dSql = $this->db->query('select SUM(d.s_dag_area_b*100 + d.s_dag_area_k*20 + d.s_dag_area_lc) AS total_lessa, 
                    SUM(d.s_dag_area_b*6400 + d.s_dag_area_k*320 + d.s_dag_area_lc*20 + d.s_dag_area_g) AS total_ganda from settlement_dag_details d where d.case_no = ? GROUP BY d.case_no', array($case_no));

                if($dSql->num_rows() <= 0)
                {
                    $reservations = array(
                        'responseType' => 0,
                        'message'      => '#MRCLRV001138: Something went wrong ! Kindly contact system administrator '
                    );
                    return $reservations;
                }

                $reservation = $rSql->row();
                $dArea = $dSql->row();

                $isBarakValley = 0;

                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                {
                    $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa2($dArea->total_ganda);
                    $isBarakValley = 1;
                }
                else
                {
                    $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa($dArea->total_lessa);
                }

                $basic = $this->SettlementVgrModel->getSettlementBasic($case_no);

                $reservationDetails[] = (object)
                [
                    'case_no'     => $reservation->case_no,
                    'dist_code'   => $basic['dist_code'],
                    'subdiv_code' => $basic['subdiv_code'],
                    'cir_code'    => $basic['cir_code'],
                    'lot_no'      => $basic['lot_no'],
                    'mouza_pargona_code'   => $basic['mouza_pargona_code'],
                    'village_townprt_code' => $basic['vill_townprt_code'],
                    'dist_name'    => $this->utilityclass->getDistrictName($basic['dist_code']),
                    'subdiv_name'  => $this->utilityclass->getSubDivName($basic['dist_code'], $basic['subdiv_code']),
                    'cir_name'     => $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']),
                    'mouza_name'   => $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']),
                    'lot_name'     => $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']),
                    'village_name' => $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']),
                    'reservation_dist_code'   => $reservation->dist_code,
                    'reservation_subdiv_code' => $reservation->subdiv_code,
                    'reservation_cir_code'    => $reservation->cir_code,
                    'reservation_mouza_pargona_code' => $reservation->mouza_pargona_code,
                    'reservation_lot_no' => $reservation->lot_no,
                    'reservation_vill_townprt_code' => $reservation->vill_townprt_code,
                    'reservation_dag_no' => $reservation->dag_no,
                    'reservation_bigha' => $bklg[0],
                    'reservation_katha' => $bklg[1],
                    'reservation_lessa' => $bklg[2],
                    'reservation_ganda' => $bklg[3],
                    'reservation_dist_name'    => $this->utilityclass->getDistrictName($reservation->dist_code),
                    'reservation_subdiv_name'  => $this->utilityclass->getSubDivName($reservation->dist_code, $reservation->subdiv_code),
                    'reservation_cir_name'     => $this->utilityclass->getCircleName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code),
                    'reservation_mouza_name'   => $this->utilityclass->getMouzaName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code),
                    'reservation_lot_name'     => $this->utilityclass->getLotName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no),
                    'reservation_village_name' => $this->utilityclass->getVillageName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no, $reservation->vill_townprt_code),
                    'isBarakValley' => $isBarakValley,
                ];
            }

            $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($this->session->userdata('dist_code'));
            $subdiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'));

            //*****reservation details in circle  */
            $reservationByCircleDetails = array();

            $sql_rc = $this->db->query('select r.dist_code, r.subdiv_code, r.cir_code, 
                SUM(r.dag_area_b*100 + r.dag_area_k*20 + r.dag_area_lc) AS total_lessa, 
                SUM(r.dag_area_b*6400 + r.dag_area_k*320 + r.dag_area_lc*20 + r.dag_area_g) AS total_ganda 
                from settlement_vgr_pgr_reservation r join settlement_basic b on r.case_no = b.case_no where b.status not in (\'D\', \'F\') and b.status = ? and r.dist_code =? and r.subdiv_code =? and r.cir_code =? group by r.dist_code, r.subdiv_code, r.cir_code', array($status, $cir_dist_code, $cir_subdiv_code, $cir_cir_code));

            if($sql_rc->num_rows() <= 0)
            {
                echo json_encode(array(
                    'responseType' => 0,
                    'message' => '#ERR1154: Something went wrong! Contact admin...'
                ));
                return;
            }

            $rc_result = $sql_rc->result();

            foreach($rc_result as $rrc)
            {
                $isBV = 0;
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                {
                    $circleBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa2($rrc->total_ganda);
                    $isBV = 1;
                }
                else
                {
                    $circleBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa($rrc->total_lessa);
                }

                $reservationByCircleDetails[] = (object)
                [
                    'dist_name' => $this->utilityclass->getDistrictName($rrc->dist_code),
                    'subdiv_name' => $this->utilityclass->getSubDivName($rrc->dist_code, $rrc->subdiv_code),
                    'cir_name' => $this->utilityclass->getCircleName($rrc->dist_code, $rrc->subdiv_code, $rrc->cir_code),
                    'bigha' => $circleBKLG[0],
                    'katha' => $circleBKLG[1],
                    'lessa' => $circleBKLG[2],
                    'ganda' => $circleBKLG[3],
                    'isBV'  => $isBV
                ];
            }

            $reservations = array(
                'responseType' => 2,
                'caseList'     => $allSelectedList,
                'reservationDetails'         => $reservationDetails,
                'reservationByCircleDetails' => $reservationByCircleDetails,
                'distName'   => $dist_name->locname_eng,
                'subDivName' => $subdiv_name->locname_eng,
                'cluster_id' => $cluster_id,
                'message'    => 'ok'
            );

            return $reservations;
        }
        else
        {
            $reservations = array(
                'responseType' => 0,
                'message'      => '#MRCLRV001114: Something went wrong ! Kindly contact system administrator '
            );
            return $reservations;
        }

    }


    //send to DC depends on online offline status
    public function sendProposalsToDc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $proposals           = json_decode($this->input->post('proposals'));
        $allMem              = json_decode($this->input->post('nominee'));
        $selectMem           = json_decode($this->input->post('selectMem'));
        $meeting_date        = $this->input->post('meeting_date');
        $meeting_venue       = $this->input->post('meeting_venue');
        $meeting_remarks     = $this->input->post('meeting_remarks');
        $dist_code           = $this->session->userdata('dist_code');
        $subdiv_code         = $this->session->userdata('subdiv_code');
        $generate_meeting_id = $this->input->post('meeting_id');

        if($this->SettlementCommonDcModel->checkProposalAlreadyExistInMeeting($proposals) != 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Some of the Proposals Already listed in Meeting ! kindly check in SDLAC/CDLAC Minutes list',
            ];
            echo json_encode($json);
            return false;
        }

        $allProposalId = '';
        $index = 0;
        $i = count($proposals);
        foreach ($proposals as $singlePro)
        {
            if ($index == $i - 1)
            {
                $allProposalId .= "'".$singlePro."'";
            }
            else
            {
                $allProposalId .= "'".$singlePro."'". ",";
            }
            $index++;
        }

        // check for PGR/VGR not allowed in other proposals
        $proSql = $this->db->query("SELECT service_code FROM settlement_proposal_list
                                          WHERE id IN ($allProposalId) AND dist_code=? AND mb_status=?",
            array($dist_code,3));

        $allSelectedProposal = $proSql->result_array();
        $checkVal = array_map("unserialize", array_unique(array_map("serialize", $allSelectedProposal)));
        if(count($checkVal) > 1)
        {
            if(in_array(SETTLEMENT_PGR_VGR_LAND_ID, array_column($checkVal, 'service_code')))
            {
                echo json_encode(array(
                    'response' => 1,
                    'message'  => "#MRCLU001104: PGR/VGR not allowed in other proposals",
                ));
                return false;
            }
        }


        $this->db->trans_begin();

        $updateVgrPgrCluStatus = 0;
        if(in_array(SETTLEMENT_PGR_VGR_LAND_ID, array_column($checkVal, 'service_code')))
        {
            $updateVgrPgrCluStatus = 1;
            $clusterSql = $this->db->query("SELECT cluster_id FROM settlement_circle_cluster
                                          WHERE proposal_id IN ($allProposalId) AND dist_code=?",
                array($dist_code));
            $allSelectedCluster = $clusterSql->result();

            if(count($allSelectedCluster) == 0)
            {
                echo json_encode(array(
                    'response' => 1,
                    'message'  => "#MRCLU001123: Cluster not found ! Kindly contact system administrator",
                ));
                return false;
            }

            foreach ($allSelectedCluster as $singleCluster)
            {
                $clusterArr = [
                    'status'      => MB_FINAL_APPROVED_BY_DC,
                    'pending_at'  => MB_DEPUTY_COMM,
                    'date_update' => date('Y-m-d H:i:s'),
                    'meeting_id'  => $generate_meeting_id,
                ];
                $this->db->where('cluster_id', trim($singleCluster->cluster_id));
                $this->db->update('settlement_circle_cluster', $clusterArr);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MRCLU001144: There is some problem, Please try again'
                    ));
                    return;
                }
            }
        }

        $allSelectedMember = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[]= $member->check_status;
        }


        $nomineeCheck = [];
        $nominee      = [];
        // check if any of SDLAC/CDLAC Member is online
        foreach($allMem as $r)
        {
            if(in_array($r->sdlac_user,$allSelectedMember))
            {
                $nomineeCheck[] = $r;
                if($r->attend_status == 1)
                {
                    // for online
                    $adc_forward_to_dc = 0;
                    break;
                }
                else
                {
                    // for offline, forward to DC
                    $adc_forward_to_dc = 1;
                }
            }
        }

        if(count($nomineeCheck) == 0)
        {
            $json = [
                'response' => 1,
                'message'  => '#ERMR00708: There is no SDLAC/CDLAC Member, Case can not be forwarded. Kindly contact 
                        system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        foreach($allMem as $r)
        {
            if(in_array($r->sdlac_user,$allSelectedMember))
            {
                $nominee[] = $r;
            }
        }


        $timestamp   = date('mdYhis', time()).uniqid();
        $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName = substr($dist_name->locname_eng, 0, 3);
        $meetingName = $distEngName.'/SDLAC-MB/'.date("Y").'/'.$generate_meeting_id;

        if(in_array(SLIJE_ID, array_column($checkVal, 'service_code')))
        {
            $meeting_type_ins = SLIJE_ID;
        }
        else
        {
            $meeting_type_ins = BHODDAN_SERVICE_CODE;
        }

        //insert into proposal_meeting_list for creating MEETING ID
        $insMeetingDetail = [
            'id'                       => $generate_meeting_id,
            'dist_code'                => $dist_code,
            'subdiv_code'              => $subdiv_code,
            'created_by'               => $this->session->userdata('user_desig_code'),
            'user_code'                => $this->session->userdata('user_code'),
            'meeting_date'             => $meeting_date,
            'meeting_venue'            => $meeting_venue,
            'expiry_hour_start_time'   => date('Y-m-d h:i:s'),
            'ip'                       => $this->utilityclass->get_client_ip(),
            'created_at'               => date('Y-m-d h:i:s'),
            'updated_at'               => date('Y-m-d h:i:s'),
            'digital_sign_status'      => 0,
            'mb_status'                => 3,
            'meeting_remarks'          => $meeting_remarks,
            'meeting_name'             => $meetingName,
            // 'vgr_pgr_status'           => $updateVgrPgrCluStatus,
            'meeting_type_ins'         => $meeting_type_ins
        ];
        $insertMeeting = $this->db->insert('proposal_meeting_list', $insMeetingDetail);
        if($insertMeeting != 1 || $insertMeeting != true ){
            $this->db->trans_rollback();
            log_message('error', '#ERRCODE701: Insertion failed in proposal_meeting_list 
                        and query is '. $this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => '#ERRCODE701: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }


        $file_minute_path = NULL;

        // Upload Minutes in meeting table
        if(isset($_FILES['upload_minute_online']['name']))
        {
            $config['file_name']     = 'upload_minute_online'.$timestamp;
            $config['upload_path']   = UPLOAD_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = 2000;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('upload_minute_online'))
            {
                $error =$this->upload->display_errors();
                echo json_encode(array(
                    'response' => 1,
                    'message' => $error,
                ));
                return;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $uploadMinute= [
                    'file_minute_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                ];
                $this->db->where('id', $generate_meeting_id);
                $this->db->update('proposal_meeting_list', $uploadMinute);

                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE639: Updation failed in proposal_meeting_list :'. $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE639: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
                $file_minute_path = $config['upload_path'].$data['upload_data']['orig_name'];
            }
        }

        // Upload Attendance in meeting table
        $config1['file_name']     = 'upload_attendance'.$timestamp;
        $config1['upload_path']   = UPLOAD_DIR;
        $config1['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $config1['max_size']      = 2000;

        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);

        if (!$this->upload->do_upload('upload_attendance'))
        {
            $error = $this->upload->display_errors();
            echo json_encode(array(
                'response' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $uploadAttendance = [
                'file_attendance_path' => $config1['upload_path'].$data['upload_data']['orig_name'],
            ];
            $this->db->where('id', $generate_meeting_id);
            $this->db->update('proposal_meeting_list', $uploadAttendance);

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE675: Updation failed in proposal_meeting_list :'. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE675: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
            $file_attendance_path = $config1['upload_path'].$data['upload_data']['orig_name'];
        }


        // update in settlement proceeding
        $proceeding_case=[
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'  => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation'  => 'E',
            'ip'         => $this->utilityclass->get_client_ip(),
            'office_from'=> $this->session->userdata['user_desig_code'],
            'office_to'  => MB_DEPUTY_COMM,
            'task'       => 'Forwarded to DC for Final Check',
        ];

        // update in settlement basic for recommended cases
        $final_settlement_case_rec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $this->session->userdata['user_desig_code'],
            'dc_code'         => $this->session->userdata('user_code'),
            'sdlac_approval'  => 'Y',
            'sdlac_date'      => date('Y-m-d h:i:s'),
            'dc_proceeding'   => 1,
        ];

        // update in settlement basic for not recommended cases
        $final_settlement_case_nrec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $this->session->userdata['user_desig_code'],
            'dc_code'         => $this->session->userdata('user_code'),
            'sdlac_approval'  => 'Y',
            'sdlac_date'      => date('Y-m-d h:i:s'),
            'dc_proceeding'   => 1,
        ];

        // update in settlement proposal cases for recommended cases
        $final_settlement_pro_rec_case = [
            'case_status'    => 1,
            'status'         => PRO_CASE_STATUS_APPROVE,
            'approved_by_dc' => 0,
        ];


        // update in settlement proposal cases for  not recommended cases
        $final_settlement_pro_nrec_case = [
            'case_status'    => 2,
            'status'         => PRO_CASE_STATUS_REJECT,
            'approved_by_dc' => 0,
        ];

        $recomend_count = 0;
        $notrecomend_count = 0;

        //list of proposals
        foreach($proposals as $prop)
        {
            // for only offline cases
            if($adc_forward_to_dc == 1)
            {
                //get cases by proposal number
                $cases_recomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                              (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                              FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                              ON pl.case_no=t.case_no AND pl.proposal_id=?
                              AND pl.case_status=1", array($prop))->result();

                // all Recommended cases
                $recomend_count = $recomend_count + count($cases_recomend);
                foreach($cases_recomend as $row)
                {
                    $allAPICases[] = $row->case_no;
                    $allAPICases_reco[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no']=$row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                    $proceeding_case['note_on_order'] = 'Recommended';
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[] = $proceeding_case;

                    // check chitha dag flag
                    $chithaDagFlagCheck = $this->SettlementInsModel->checkChithaFlagUpdatePremiumAreaExceptSocioCultureEduWithoutTran($row->case_no);
                    if($chithaDagFlagCheck['response'] != 2)
                    {
                        echo json_encode(array(
                            'response'     => 1,
                            'message'      => $chithaDagFlagCheck['msg'].' for Case No '. $row->case_no,
                        ));
                        return false;
                    }
                }


                $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2", array($prop))->result();

                // all Not Recommended cases
                $notrecomend_count = $notrecomend_count + count($cases_notrecomend);
                foreach($cases_notrecomend as $row)
                {

                    $allAPICases[] = $row->case_no;
                    $allAPICases_nrec[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no']=$row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                    $proceeding_case['note_on_order'] = $row->template_remarks;
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[]   = $proceeding_case;
                }
            }

            //get service code
            $service_code = $this->db->query("SELECT service_code FROM settlement_proposal_list 
                        WHERE id=?", array($prop))->row()->service_code;
            //echo $this->db->last_query();

            // Upload Minutes
            $uploadMinute= [
                'file_minute_path' => $file_minute_path,
            ];
            $this->db->where('id', $prop);
            $this->db->update('settlement_proposal_list', $uploadMinute);

            if ($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2234: Updation failed in settlement_proposal_list for proposal no :'. $prop);
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2234: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            // Upload Attendance
            $uploadAttendance = [
                'file_attendance_path' => $file_attendance_path,
            ];
            $this->db->where('id', $prop);
            $this->db->update('settlement_proposal_list', $uploadAttendance);

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2235: Updation failed in settlement_proposal_list for proposal no :'. $prop);
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2235: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            //check if data already available in settlement_sdlac_member_report table
            $checkMember = $this->SettlementCommonModel->checkSdlacMember($prop);

            //insert into settlement_sdlac_member_report
            $proSendToSDLACStatus = 2;
            foreach($nominee as $row)
            {
                if($row->attend_status == SDLAC_ATTEND_ONLINE)
                {
                    $status = 0;
                    $proSendToSDLACStatus = 1;
                }
                else
                {
                    $status = 1;
                }
                if($checkMember->num_rows() > 0)
                {
                    $updateSdlacReport = [
                        'status'                => $status,
                        'nominee_id'            => $row->select_nominee,
                        'meeting_attend_status' => $row->attend_status,
                        'proposal_meeting_id'   => $generate_meeting_id,
                        'updated_at'            => date('Y-m-d h:i:s'),
                    ];
                    $this->db->where([
                        'dist_code'         => $dist_code,
                        'proposal_no'       => $prop,
                        'sdlac_member_code' => $row->sdlac_user,
                        'username'          => $this->utilityclass->getUserNameByUserCode($row->sdlac_user),
                        'service_code'      => $service_code,
                    ]);
                    $this->db->update('settlement_sdlac_member_report', $updateSdlacReport);

                    if($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCODE2236: Updation failed in settlement_sdlac_member_report for 
                        proposal no : '.$prop. ' and query is '. $this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#ERRCODE2236: Case can not be forwarded. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
                else
                {
                    $insSdlacReport = [
                        'dist_code'             => $dist_code,
                        'proposal_no'           => $prop,
                        'sdlac_member_code'     => $row->sdlac_user,
                        'username'              => $this->utilityclass->getUserNameByUserCode($row->sdlac_user),
                        'emailid'               => $this->utilityclass->getEmailIdByUserCode($row->sdlac_user),
                        'created_at'            => date('Y-m-d h:i:s'),
                        'service_code'          => $service_code,
                        'created_by'            => $this->session->userdata['user_desig_code'],
                        'status'                => $status,
                        'nominee_id'            => $row->select_nominee,
                        'meeting_attend_status' => $row->attend_status,
                        'proposal_meeting_id'   => $generate_meeting_id,
                    ];

                    $insert = $this->db->insert('settlement_sdlac_member_report', $insSdlacReport);

                    if($insert != 1 || $insert != true ){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCODE2237: Insertion failed in settlement_sdlac_member_report for 
                        proposal no : '.$prop. ' and query is '. $this->db->last_query());
                        $json = [
                            'response' => 1,
                            'message'  => '#ERRCODE2237: Case can not be forwarded. Kindly contact 
                        system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }

            $checkMemberDetail = $this->SettlementCommonModel->checkSdlacMember($prop);

            //insert into settlement_sdlac_member_proceeding
            $insMemberProceeding = [
                'dist_code'         => $dist_code,
                'proposal_no'       => $prop,
                'sdlac_member_json' => json_encode($checkMemberDetail->result()),
                'created_at'        => date('Y-m-d h:i:s'),
            ];
            $ins = $this->db->insert('settlement_sdlac_member_proceeding', $insMemberProceeding);
            if($ins != 1 || $ins != true ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2238: Insertion failed in settlement_sdlac_member_proceeding for 
                    proposal no : '.$prop. ' and query is '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2238: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //insert into sdlac_proceeding table
            $insSdlacProceeding = [
                'proposal_no'       => $prop,
                'dist_id'           => $dist_code,
                'proceeding_status' => 1,
                'sdlac_remarks'     => $meeting_remarks,
                'date_entry'        => date('Y-m-d h:i:s'),
                'ip'                => $this->utilityclass->get_client_ip(),
                'office_from'       => $this->session->userdata['user_desig_code'],
                'office_to'         => 'SDLAC',
                'service_code'      => $service_code,
                'sdlac_user_code'   => $this->session->userdata('user_code'),
            ];
            $insertProceeding = $this->db->insert('sdlac_proceeding', $insSdlacProceeding);
            if($insertProceeding != 1 || $insertProceeding != true )
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2239: Insertion failed in sdlac_proceeding 
                for proposal no : '.$prop. ' and query is '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2239: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //update sdlac proposal list
            $updateSdlacList = [
                'sdlac_prceed_status'    => $proSendToSDLACStatus,
                'meeting_date'           => $meeting_date,
                'expiry_hour_start_time' => date('Y-m-d h:i:s'),
                'meeting_venue'          => $meeting_venue,
                'proposal_meeting_id'    => $generate_meeting_id,
                'meeting_create_status'  => 2,
                'final_verify_status'    => 1
            ];
            $this->db->where('id', $prop);
            $this->db->update('settlement_proposal_list', $updateSdlacList);
            if($this->db->affected_rows() <= 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2246: Updation failed in settlement_proposal_list 
                  for proposal no : '.$prop. ' and query is '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2246: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        }

        // all offline cases , hit API
        if($adc_forward_to_dc == 1)
        {
            // batch insert into settlement_proceeding
            $insert_count = $this->db->insert_batch('settlement_proceeding',$final_proceeding_case);
            if(($recomend_count+$notrecomend_count) != $insert_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2634: INSERT failed in settlement_proceeding '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2634: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            // batch insert into settlement_basic for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
                //echo count($cases_recomend);
                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_rec,
                    'case_no',$allAPICases_reco);
                if($recomend_count != $update_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2650: Updation failed in settlement_basic for recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE2650: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_basic for not recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {

                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_nrec,
                    'case_no',$allAPICases_nrec );
                if($notrecomend_count != $update_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2669: Updation failed in settlement_basic for not recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE2669: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            // batch update into settlement_proposal_cases for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
                $update_pro_rec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_rec_case,
                    'case_no',$allAPICases_reco);
                if ($recomend_count != $update_pro_rec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2685: Updation failed in settlement_proposal_cases for recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE2685: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_proposal_cases for not  recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {
                $update_pro_nrec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_nrec_case,
                    'case_no',$allAPICases_nrec);
                if ($notrecomend_count != $update_pro_nrec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2727: Updation failed in settlement_proposal_cases for not recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE2727: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            //update sdlac proposal list
            $updateMeetingTable = [
                'adc_forward_to_dc_status' => 1,
                'updated_at'               => date('Y-m-d h:i:s'),
            ];
            $this->db->where('id', $generate_meeting_id);
            $this->db->update('proposal_meeting_list', $updateMeetingTable);

            if($this->db->affected_rows() <= 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE711: Updation failed in proposal_meeting_list : '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE711: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            $caseApp = $this->SettlementCommonModel->convertLiteral($allAPICases);

            $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
            $applids = $this->db->query($sql)->row()->applids;

            //api call
            $rmk    = 'Forwarded to DC for Final Check';
            $status = 'M';
            $task   = $this->session->userdata['user_desig_code'];
            $pen    = MB_DEPUTY_COMM;
            $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulkMb3($applids,'NA',$rmk,$status,$task,$pen);
            if($rtps_status!="y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $applids");
                $json = [
                    'response' => 1,
                    'message'  => '#ERRAPP0011: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                //redirect(base_url() . "index.php/home");
                return;
            }

            $this->db->trans_commit();
            $json = [
                'response' => 2,
                'message'  => 'All selected proposals has successfully forwarded to DC',
            ];
            echo json_encode($json);

        }
        else
        {
            //$adc_forward_to_dc == 0, online cases available, DONOT HIT API

            //update sdlac proposal list
            $updateMeetingTable = [
                'adc_forward_to_dc_status' => 0,
                'expiry_status'            => 1,
                'expiry_hour_start_time'   => date('Y-m-d h:i:s'),
                'updated_at'               => date('Y-m-d h:i:s'),
            ];
            $this->db->where('id', $generate_meeting_id);
            $this->db->update('proposal_meeting_list', $updateMeetingTable);

            if($this->db->affected_rows() <= 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE740: Updation failed in proposal_meeting_list : '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE740: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            $this->db->trans_commit();
            $json = [
                'response' => 2,
                'message'  => 'Proposal(s) will be hold for 48 hrs for online cases. 
                        Pending for SDLAC/CDLAC Member`s action',
            ];
            echo json_encode($json);
        }

    }


    // update batch Query
    public function updateBatch($table, $data, $where_filed, $where_array)
    {
        $sql = "update $table set ";
        //var_dump($data);
        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . '=\'' . $value . '\', ';
        }
        $sql = substr(trim($sql), 0, -1);
        $caseApp = $this->SettlementCommonModel->convertLiteral($where_array);
        $sql = $sql . ' where '.$where_filed.' in ('.$caseApp.')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }


    // check case match status in cluster or not
    public function checkIfCaseRevertedFromCluster($case_no)
    {
        $case_no = trim($case_no);
        $sql = $this->db->query('select * from settlement_circle_cluster_cases where case_no = ?', array($case_no));

        $clusterStatus = 0;
        $clusterError  = '';
        $clusterIdList = 0;
        if($sql->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004663: No cluster found for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $clusterIdList,
            ];
            return $returnDataArray;
        }

        $cluster_id = $sql->row()->cluster_id;
        $clusterStatusSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

        if($sql->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004679: No cluster found for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $cluster_id,
            ];
            return $returnDataArray;
        }

        $cluster_row        = $clusterStatusSql->row();
        $cluster_status     = trim($cluster_row->status);
        $cluster_pending_at = trim($cluster_row->pending_at);
        $getCaseStatusBasic = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if($getCaseStatusBasic->num_rows() <= 0)
        {
            $clusterStatus = 0;
            $clusterError  = 'ERR004697: There is some problem for case no '.$case_no;

            $returnDataArray = [
                'clusterStatus' => $clusterStatus,
                'clusterError'  => $clusterError,
                'clusterIdList' => $cluster_id,
            ];
            return $returnDataArray;
        }

        $basicRow = $getCaseStatusBasic->row();

        $caseBasicStatus    = trim($basicRow->status);
        $caseBasicPendingAt = trim($basicRow->pending_officer);

        if($caseBasicStatus != 'D')
        {
            if(($cluster_status != $caseBasicStatus) || ($cluster_pending_at != $caseBasicPendingAt))
            {
                $clusterStatus = 0;
                $clusterError  = 'ERR004717: Some cases of this cluster is reverted and still pending';

                $returnDataArray = [
                    'clusterStatus' => $clusterStatus,
                    'clusterError'  => $clusterError,
                    'clusterIdList' => $cluster_id,
                ];
                return $returnDataArray;
            }
        }

        $returnDataArray = [
            'clusterStatus' => 1,
            'clusterError'  => 'OK',
            'clusterIdList' => $cluster_id,
        ];
        return $returnDataArray;

    }


    //All recommended / not recommended  cases By MRIDU SIR
    public function generateProposalCases($proposals)
    {
        $prop = '';
        $index = 0;
        foreach ($proposals as $p)
        {
            if ($index == 0)
            {
                $prop = $prop."'".$p."'";
            }
            else
            {
                $prop = $prop.",'".$p."'";
            }
            $index++;
        }

        $sql = "SELECT t.case_no, t.proposal_id,t.remark,t.case_status, s.subdiv_code FROM settlement_basic s JOIN (
                SELECT  case_no,  proposal_id,
		                sc.template_remarks as  remark, sc.case_status FROM settlement_proposal_cases sc
		                WHERE sc.proposal_id IN ($prop)
		                ) t ON s.case_no=t.case_no ORDER BY s.dist_code,s.subdiv_code,s.cir_code";

        $result = $this->db->query($sql)->result();
        $sql = "SELECT id,proposal_name FROM settlement_proposal_list WHERE id in ($prop)";
        $proposals = $this->db->query($sql)->result();
        foreach($proposals as $p)
        {
            $props[$p->id]=$p->proposal_name;
        }

        foreach($result as $r)
        {
            $sql = "SELECT
			        (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
			    cir_code=s.cir_code and mouza_pargona_code='00') as cirname,
			                (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
			    cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no='00') as mouza,
			                (select locname_eng from location where dist_code=s.dist_code and subdiv_code=s.subdiv_code and
			    cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no AND
			    vill_townprt_code = s.vill_townprt_code) as village,applid, service_code from settlement_basic s where case_no='$r->case_no'";
            $locations = $this->db->query($sql)->row();
            if($locations->service_code == SLIJE_ID)
            {
                $sql = " select string_agg(distinct(ins_name_co || '---' || dept_of_co || ''),',') as name from 
                      settlement_institution_details where case_no='$r->case_no'";
            }
            else
            {
                $sql = " select string_agg(distinct(eng_pdar_name || '---' || eng_pdar_guardian || ''),',') as name from 
                      settlement_applicant where case_no='$r->case_no' and pdar_type='B'";
            }
            $applicants = $this->db->query($sql)->row();

            $sql = " select STRING_AGG(sp.dag_no||'---' || sp.total_lessa::VARCHAR || '',',') as dags from settlement_premium sp
              where case_no='$r->case_no' and is_final = 1";
            $dags = $this->db->query($sql)->row();

            $sql = " select string_agg((sd.land_type),',') ladtype from settlement_dag_details sd 
	    	       where case_no='$r->case_no'";
            $land_type = $this->db->query($sql)->row();

            $result_array[] = array(
                "cirname"       => $locations->cirname,
                "mouza"         => $locations->mouza,
                "village"       => $locations->village,
                "applid"        => $locations->applid,
                "service_code"  => $locations->service_code,
                "name"          => $applicants->name,
                "subdiv_code"   => $r->subdiv_code,
                "dags"          => $dags->dags,
                "ladtype"       => $land_type->ladtype,
                "case_no"       => $r->case_no,
                "case_status"   => $r->case_status,
                "remark"        => $r->remark,
                "proposal_name" => $props[$r->proposal_id]

            );
        }

        $serviceNames[45] = NJS_TAGLINE;
        $serviceNames[39] = "Bhoodan Gramdan";

        $CheckClusterStatus = [];
        $vgrPgrStatus = 0;
        foreach ($result_array as $row)
        {
            if(trim($row['service_code']) == SETTLEMENT_PGR_VGR_LAND_ID)
            {
                $case_no = trim($row['case_no']);
                $CheckClusterCount = $this->checkIfCaseRevertedFromCluster($case_no);
                if(trim($CheckClusterCount['clusterStatus']) != 1)
                {
                    $CheckClusterStatus[] = array(
                        'response' => 1,
                        'message'  => $CheckClusterCount['clusterError']
                    );
                }
                $vgrPgrStatus = 1;
            }

            $jsmr = explode(",", $row['dags']);
            $final_dag ='';
            $final_area = '';
            for($j=0; $j<count($jsmr); $j++)
            {
                $final_all = explode('---',$jsmr[$j]);
                if($j==count($jsmr) - 1)
                {
                    if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                        $final_dag  = $final_dag . $final_all[0];
                        $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_all[1]);
                        $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                        $final_area = $final_area . $bklArea;
                    }
                    else
                    {
                        $final_dag  = $final_dag . $final_all[0];
                        $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                        $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                        $final_area = $final_area . $bklArea;
                    }

                }
                else
                {
                    if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                        $final_dag  = $final_dag . $final_all[0].'<br>';
                        $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_all[1]);
                        $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                        $final_area = $final_area . $bklArea.'<br>';
                    }
                    else
                    {
                        $final_dag  = $final_dag . $final_all[0].'<br>';
                        $BKLData    = $this->utilityclass->Total_Bigha_Katha_Lessa($final_all[1]);
                        $bklArea    = $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                        $final_area = $final_area . $bklArea.'<br>';
                    }
                }
            }

            $jsmr2 = explode(",", $row['name']);
            $final_name ='';
            $final_guard = '';
            for($j=0; $j<count($jsmr2); $j++)
            {
                $final_all = explode('---',$jsmr2[$j]);

                if($j==count($jsmr2) - 1)
                {
                    $final_name = $final_name . $final_all[0];
                    $final_guard = $final_guard . (isset($final_all[1]) ? $final_all[1] : '');
                }
                else
                {
                    $final_name = $final_name . $final_all[0].', ';
                    $final_guard = $final_guard . (isset($final_all[1]) ? $final_all[1] : '').', ';
                }
            }


            // rec
            if($row['case_status']==1)
            {
                $final_result_array_rec[] = array(
                    "cirname"=>  $row['cirname'],
                    "mouza"=>	 $row['mouza'],
                    "village"=>	 $row['village'],
                    "case_no"=>	 $row['case_no'],
                    "applid"=>	 $row['applid'],
                    "service_name"  =>  $serviceNames[$row['service_code']],
                    "proposal_name" => $row['proposal_name'],
                    "subdiv_code"   => $row['subdiv_code'],
                    "name"   =>	$final_name,
                    "guard"  =>	$final_guard,
                    "dag"    =>	$final_dag,
                    "area"   =>	$final_area,
                    "remark" =>  $row['remark'],
                    "ladtype"=>	$row['ladtype'],
                    "status"=>	$row['case_status']
                );
            }

            // not rec
            if($row['case_status']==2)
            {
                $final_result_array_not_rec[] = array(
                    "cirname"=>  $row['cirname'],
                    "mouza"=>	 $row['mouza'],
                    "village"=>	 $row['village'],
                    "case_no"=>	 $row['case_no'],
                    "applid"=>	 $row['applid'],
                    "service_name"  =>  $serviceNames[$row['service_code']],
                    "proposal_name" => $row['proposal_name'],
                    "subdiv_code"   => $row['subdiv_code'],
                    "name"   =>	$final_name,
                    "guard"  =>	$final_guard,
                    "dag"    =>	$final_dag,
                    "area"   =>	$final_area,
                    "remark" =>  $row['remark'],
                    "ladtype"=>	$row['ladtype'],
                    "status"=>	$row['case_status']
                );
            }
        }


        $final_result_array = array(
            'final_result_array_rec'     =>
                (isset($final_result_array_rec) && $final_result_array_rec != NULL)? $final_result_array_rec: '',
            'final_result_array_not_rec' =>
                (isset($final_result_array_not_rec) && $final_result_array_not_rec != NULL)? $final_result_array_not_rec: '',
            'CheckClusterStatus' =>
                (isset($CheckClusterStatus) && $CheckClusterStatus != NULL)? $CheckClusterStatus: '',
            'vgrPgrStatus' => $vgrPgrStatus

        );

        return $final_result_array;

    }



    // online meeting list pending on ADC end
    public function pendingProposalList()
    {

        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');
        $data['dist_code'] = $dist_code;

        $pendingCase   = $this->SettlementCommonDcModel->getPendingProposalsMbTin($dist_code,$createdBy);
        $data['cases'] = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'SettlementView/Adc/pending_proposal_list_holds_for_48_hrs_ins';
        $this->load->view('layouts/main', $data);

    }


    // pending meeting details with meeting id on SDO/ADC end
    public function getPendingMeetingDetailsBySdoAdc()
    {
        $meetingId = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');

        $pendingMeeting      = $this->SettlementCommonDcModel->checkMeetingExistOrNotWithMeetingId($meetingId,$dist_code);
        $meetingDetails      = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();

        if($pendingMeetingCount == 0)
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/pendingProposalList");
            $this->pendingProposalList();
        }
        else
        {
            //list of proposals against meeting id
            $proposalDetail = $this->SettlementMeetingDcInsModel->getProposalDetailAgainstMeetingIdMBTin($dist_code,
                $meetingId)->result();


            //list of SDLAC/CDLAC Member report
            $sdlacReport = $this->SettlementMeetingDcModel->sdlacMemberReportDetail($dist_code,
                $meetingId)->result();

            $onlineCase = 0;
            $forwardButt = 1;
            foreach ($sdlacReport as $row)
            {
                if($row->status == 0)
                {
                    $onlineCase = 1;
                    $forwardButt = 0;
                }
            }
            if($onlineCase == 1)
            {
                $ExpTime   = strtotime($meetingDetails->expiry_hour_start_time);
                $now       = strtotime(date('Y-m-d H:i:s'));
                $timeCheck = round(abs($now - $ExpTime) / 60 / 60, 2). " hour";

                if($timeCheck > 48)
                {
                    $forwardButt = 1;
                }
                else
                {
                    $forwardButt = 0;
                }
            }


            $data['meeting']         = $meetingDetails;
            $data['dist_code']       = $dist_code;
            $data['sdlac_member']    = $sdlacReport;
            $data['proposal_detail'] = $proposalDetail;
            $data['forwardButt']     = $forwardButt;

            $data['_view'] = 'SettlementView/Adc/pending_meeting_details_holds_for_48_hrs_ins';
            $this->load->view('layouts/main', $data);
        }
    }


    //view case nos against a proposal no
    public function viewCasesAgainstProposalNo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalNo = $this->input->post('propId');

        //list of cases
        $cases = $this->SettlementMeetingDcModel->getCaseDetailsByProposalNos($proposalNo);

        if($cases->num_rows() == 0 || $cases->num_rows() == '')
        {
            $json = [
                'response' => 1,
                'message'  => '#ERR323: No cases found.',
            ];
            echo json_encode($json);
            return;
        }
        $json = [
            'response'      => 2,
            'tableCases'    => $cases->result(),
            'proposal_name' => $this->SettlementMeetingDcInsModel->getProposalNameByProposalNo($proposalNo),
        ];
        echo json_encode($json);
        return;
    }


    // forward online meeting to dc for final verification
    public function forwardOnlineMeetingToDcForFinalVerification()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $_POST = json_decode(file_get_contents("php://input"), true);
        $meetingId = $this->input->post('meetingId');
        $dist_code = $this->session->userdata('dist_code');
        $desi_code = $this->session->userdata['user_desig_code'];

        $meeting = $this->SettlementCommonDcModel->checkMeetingExistOrNotWithMeetingId($meetingId,$dist_code);

        if($meeting->num_rows() == 0 || $meeting->num_rows() == '')
        {
            $json = [
                'response' => 1,
                'message'  => '#ERR323: No Meeting found.',
            ];
            echo json_encode($json);
            return;
        }

        //list of proposals against meeting id
        $getProposal = $this->SettlementMeetingDcInsModel->getProposalDetailAgainstMeetingIdMBTin($dist_code,$meetingId);

        if($getProposal->num_rows() == 0 || $getProposal->num_rows() == '')
        {
            $json = [
                'response' => 1,
                'message'  => '#ERR323: Proposal not found.',
            ];
            echo json_encode($json);
            return;
        }

        $proposalDetails = $getProposal->result();

        $proposals = '';
        $index = 0;
        foreach ($proposalDetails as $row)
        {

            if ($index == 0)
            {
                $proposals = $proposals."'".$row->proposal_id."'";
            }
            else
            {
                $proposals = $proposals.",'".$row->proposal_id."'";
            }
            $index++;
        }

        // update in settlement proceeding
        $proceeding_case=[
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'  => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation'  => 'E',
            'ip'         => $this->utilityclass->get_client_ip(),
            'office_from'=> $desi_code,
            'office_to'  => MB_DEPUTY_COMM,
            'task'       => 'Forwarded to DC for Final Check',
        ];

        // update in settlement basic for recommended cases
        $final_settlement_case_rec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $desi_code,
            'dc_code'         => $dist_code,
            'sdlac_approval'  => 'Y',
            'sdlac_date'      => date('Y-m-d h:i:s'),
            'dc_proceeding'   => 1,
        ];

        // update in settlement basic for not recommended cases
        $final_settlement_case_nrec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $desi_code,
            'dc_code'         => $dist_code,
            'sdlac_approval'  => 'Y',
            'sdlac_date'      => date('Y-m-d h:i:s'),
            'dc_proceeding'   => 1,
        ];

        // update in settlement proposal cases for recommended cases
        $final_settlement_pro_rec_case = [
            'case_status'    => 1,
            'status'         => PRO_CASE_STATUS_APPROVE,
            'approved_by_dc' => 0,
        ];


        // update in settlement proposal cases for  not recommended cases
        $final_settlement_pro_nrec_case = [
            'case_status'    => 2,
            'status'         => PRO_CASE_STATUS_REJECT,
            'approved_by_dc' => 0,
        ];

        $recomend_count = 0;
        $notrecomend_count = 0;

        //list of proposals
        foreach($proposalDetails as $prop)
        {

            //get cases by proposal number
            $cases_recomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                              (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                              FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                              ON pl.case_no=t.case_no AND pl.proposal_id=?
                              AND pl.case_status=1", array($prop->proposal_id))->result();


            // all Recommended cases
            $recomend_count = $recomend_count + count($cases_recomend);
            foreach($cases_recomend as $row)
            {
                $allAPICases[] = $row->case_no;
                $allAPICases_reco[] = $row->case_no;

                // update in settlement proceeding
                $proceeding_case['case_no']=$row->case_no;
                $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                $proceeding_case['note_on_order'] = 'Recommended';
                $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                $final_proceeding_case[] = $proceeding_case;

            }


            $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2", array($prop->proposal_id))->result();


            // all Not Recommended cases
            $notrecomend_count = $notrecomend_count + count($cases_notrecomend);
            foreach($cases_notrecomend as $row)
            {

                $allAPICases[] = $row->case_no;
                $allAPICases_nrec[] = $row->case_no;

                // update in settlement proceeding
                $proceeding_case['case_no']=$row->case_no;
                $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                $proceeding_case['note_on_order'] = $row->template_remarks;
                $proceeding_case['minutes_proposal_id'] = trim($prop->proposal_id);
                $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                $final_proceeding_case[]   = $proceeding_case;
            }

        }


        // batch insert into settlement_basic for recommended
        if (isset($allAPICases_reco) && count($allAPICases_reco)>0)
        {
            $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_rec,
                'case_no',$allAPICases_reco);
            if($recomend_count != $update_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR01746: Updation failed in settlement_basic for recommended '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERMR01746: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }

        // batch insert into settlement_basic for not recommended
        if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0)
        {
            $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_nrec,
                'case_no',$allAPICases_nrec );
            if($notrecomend_count != $update_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR01764: Updation failed in settlement_basic for not recommended '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERMR01764: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }

        // batch update into settlement_proposal_cases for recommended
        if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
            $update_pro_rec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_rec_case,
                'case_no',$allAPICases_reco);
            if ($recomend_count != $update_pro_rec_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2685: Updation failed in settlement_proposal_cases for recommended '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2685: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }

        // batch insert into settlement_proposal_cases for not  recommended
        if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {
            $update_pro_nrec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_nrec_case,
                'case_no',$allAPICases_nrec);
            if ($notrecomend_count != $update_pro_nrec_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCODE2727: Updation failed in settlement_proposal_cases for not recommended '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERRCODE2727: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }

        // batch insert into settlement_proceeding
        $insert_count = $this->db->insert_batch('settlement_proceeding',$final_proceeding_case);
        if(($recomend_count+$notrecomend_count) != $insert_count)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERMR01751: INSERT failed in settlement_proceeding '.$this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => '#ERMR01751: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        //update sdlac proposal list
        $updateSdlacList = [
            'sdlac_prceed_status' => 2,
        ];
        $this->db->where('id', trim($prop->proposal_id));
        $this->db->update('settlement_proposal_list', $updateSdlacList);
        if($this->db->affected_rows() <= 0 ){
            $this->db->trans_rollback();
            log_message('error', '#ERMR17269: Updation failed in settlement_proposal_list 
                  for proposal no : '.$prop. ' and query is '. $this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => '#ERMR17269: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }


        //update sdlac proposal list
        $updateMeetingTable = [
            'adc_forward_to_dc_status' => 1,
            'updated_at'               => date('Y-m-d h:i:s'),
            'expiry_status'            => 0,
        ];
        $this->db->where('id', $meetingId);
        $this->db->update('proposal_meeting_list', $updateMeetingTable);

        if($this->db->affected_rows() <= 0 ){
            $this->db->trans_rollback();
            log_message('error', '#ERMR1790: Updation failed in proposal_meeting_list : '. $this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => '#ERMR1790: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $caseApp = $this->SettlementCommonModel->convertLiteral($allAPICases);
        $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
        $applids = $this->db->query($sql)->row()->applids;


        //api call
        $rmk    = 'Forwarded to DC for Final Check';
        $status = 'M';
        $task   = $desi_code;
        $pen    = MB_DEPUTY_COMM;
        $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulkMb3($applids,'NA',$rmk,$status,$task,$pen);

        if($rtps_status!="y")
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #ERMR1813: Forward to DC failed case no # $applids");
            $json = [
                'response' => 1,
                'message'  => '#ERMR1813: Meeting can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return;
        }

        $this->db->trans_commit();
        $json = [
            'response' => 2,
            'message'  => 'All selected proposals has successfully forwarded to DC',
        ];
        echo json_encode($json);
        return;


    }





    /// ***********************************************************************




    // reverted meeting list
    public function revertMeetingListForAdc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');
        $data['dist_code'] = $dist_code;

        $pendingCase              = $this->SettlementCommonDcModel->getRevertedMeetingListMbTin($dist_code,$createdBy);
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'SettlementView/Adc/reverted_meeting_list_adc_ins';
        $this->load->view('layouts/main', $data);
    }


    // view proposal under reverted meeting
    public function getProposalUnderRevertedMeetingForAdc()
    {
        $meetingId   = $this->input->get('meetingId');
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');

        $pendingMeeting      = $this->SettlementCommonDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdc($meetingId,$dist_code);
        $pendingMeetingCount = $pendingMeeting->num_rows();

        if($pendingMeetingCount == 0)
        {
            $this->session->set_flashdata('error', "Reverted Meeting by DC Not Found !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/revertMeetingListForAdc");
            $this->pendingProposalList();
        }
        else
        {
            $meetingDetails = $pendingMeeting->row();


            //list of reverted proposals against meeting id
            $proposalDetail = $this->SettlementCommonDcModel->getRevertedProposalDetailAgainstMeetingIdMbTin($dist_code,$meetingId);
            $commMembers    = $this->SettlementMbDcModel->getMembersFromUsersWithUserType($dist_code);
            $proposals      = $proposalDetail->result();

            $data['dist_code']       = $dist_code;
            $data['proposals']       = $proposals;
            $data['pendingProCount'] = $proposalDetail->num_rows();
            $data['meeting']         = $meetingDetails;
            $data['meetingName']     = $meetingDetails->meeting_name;
            $data['meetingDetails']  = $meetingDetails;

            $allProposals = '';
            $index = 0;
            foreach ($proposals as $proposal)
            {
                if ($index == 0)
                {
                    $allProposals .= "'".$proposal->id."'";
                }
                else
                {
                    $allProposals .= ",'".$proposal->id."'";
                }
                $index++;
            }


            $sql = $this->db->query("SELECT DISTINCT(user_code), nominee FROM sdlac_present_member
                                          WHERE proposal_id IN ($allProposals)
                                            AND status=? AND dist_code=?",
                array(1, $dist_code));

            $memberPresents = $sql->result();

            $allPreMem = [];
            $allPreNom = [];
            foreach ($memberPresents as $memberPresent)
            {
                $allPreMem[]= $memberPresent->user_code;
                $allPreNom[]= $memberPresent->nominee;
            }

            $data['committeeList']  = $commMembers;
            $data['allPreMem']      = $allPreMem;
            $data['allPreNom']      = $allPreNom;

            $data['_view'] = 'SettlementView/Adc/reverted_proposal_by_dc_list_ins';
            $this->load->view('layouts/main', $data);
        }
    }


    // view case under proposal reverted meeting
    public function caseListUnderRevertedMeetingForAdc()
    {
        $proposal_no = $this->input->get('proposal');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementCommonDcModel->getAllCaseInProposalUnderRevertedMeeting($proposal_no);
        $proposalDetails = $this->SettlementCommonDcModel->getRevertedProposalDetailsByIdAdcMbTin($proposal_no,$dist_code);

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

        $data['_view'] = 'settlementView/Adc/reverted_application_by_proposal_ins';
        $this->load->view('layouts/main', $data);

    }


    // reverted Meeting Generate minute b4 send to DC verification
    public function sendRevertedProposalsToDcMinuteAdc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meetingId       = $this->input->post('meeting_id');
        $meeting_date    = $this->input->post('meeting_date');
        $meeting_venue   = $this->input->post('meeting_venue');
        $meeting_remarks = $this->input->post('meeting_remarks');
        $nominee     = json_decode($this->input->post('nominee'));
        $selectMem   = json_decode($this->input->post('selectMem'));
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $allMembers  = $this->SettlementCommonDcModel->getMembersFromUsers($dist_code);

        $proposalDetails = $this->SettlementCommonDcModel->getRevertedProposalDetailAgainstMeetingIdMbTin($dist_code,$meetingId)->result();
        $proposals = [];
        foreach ($proposalDetails as $proposal)
        {
            $proposals[]= $proposal->id;
        }

        $pendingMeeting      = $this->SettlementCommonDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdcMbTin($meetingId,$dist_code);
        $meetingDetails      = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();

        if($pendingMeetingCount == 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Meeting not found !',
            ];
            echo json_encode($json);
            return false;
        }

        $allSelectedMember = [];
        $commMembers = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[]= $member->check_status;
        }

        $i= 0;
        foreach ($allMembers as $mem)
        {

            if(in_array($mem->user_code,$allSelectedMember))
            {
                if($mem->user_code == $nominee[$i]->sdlac_user && $nominee[$i]->select_nominee !=0)
                {
                    $nn = $this->SettlementCommonDcModel->getNomineeName($nominee[$i]->select_nominee);
                    if($mem->display_name == '')
                    {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->name . ', ' . $mem->designation;
                    }
                    else
                    {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->display_name;
                    }
                }
                else
                {
                    if($mem->display_name == '')
                    {
                        $commMembers[] = $mem->name . ', ' . $mem->designation;
                    }
                    else
                    {
                        $commMembers[] = $mem->display_name;
                    }
                }
            }

            $i = $i + 1;
        }


        if(count($commMembers) == 0)
        {
            $json = [
                'response' => 1,
                'message'  => '#ERMR000493: There is no SDLAC/CDLAC Member, Kindly Select SDLAC Members',
            ];
            echo json_encode($json);
            return false;
        }


        $subdiv_code  = $this->session->userdata('subdiv_code');
        $districtName = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $allProposalCases = $this->generateProposalCases($proposals);
        $caseList   = $allProposalCases['final_result_array_rec'];
        $caseDivNot = $allProposalCases['final_result_array_not_rec'];

        $subDivArray = [];
        foreach ($caseList as $key => $value)
        {
            $subDivArray[] = $value['subdiv_code'];
        }

        $uniqueArraySub = array_unique($subDivArray);

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



        // for VGR/PGR only
        $checkVGRPGRCluster = $allProposalCases['CheckClusterStatus'];
        if(isset($checkVGRPGRCluster) && $checkVGRPGRCluster != NULL)
        {
            foreach ($checkVGRPGRCluster as $singleVgrPgrError)
            {
                if($singleVgrPgrError['response'] == 1)
                {
                    echo json_encode(array(
                        'response' => 1,
                        'message'  => $singleVgrPgrError['message']
                    ));
                    return false;
                }
            }
        }

        // reservation area for VGR PGR
        $vgrPgrStatus = $allProposalCases['vgrPgrStatus'];
        $reservationDetails = array();
        if(trim($vgrPgrStatus) == 1)
        {
            foreach ($proposals as $key => $proposal_id)
            {
                if($this->SettlementCommonDcModel->countClusterIdByProposal($proposal_id) == 0)
                {
                    $json = [
                        'response' => 1,
                        'message'  => 'Cluster not found ! Kindly contact system administrator ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                $cluster_id = $this->SettlementCommonDcModel->getClusterIdByProposal($proposal_id);
                $reservationDetailData = $this->getReservationDetailsVGRPGR($cluster_id,MB_SEND_TO_SDLAC);
                if($reservationDetailData['responseType'] != 0)
                {
                    $reservationDetails[]  = $reservationDetailData;
                }
                else
                {
                    $json = [
                        'response' => 1,
                        'message'  => $reservationDetailData['message']
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
        }


        $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName = substr($dist_name->locname_eng, 0, 3);
        $memoName    = $distEngName.'/MEMO/'.date("Y").'/'.$meetingDetails->id;
        $meetingName = $meetingDetails->meeting_name;

        $createdUserCode = $proposalDetails[0]->user_code;
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == MB_ADD_DEPUTY_COMM)
        {
            $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
        }
        else
        {
            $countCopy = $this->SettlementCommonDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
        }
        if($countCopy == 0)
        {
            $proposalCreatedBy = '';
        }
        else
        {
            $proposalCreatedBy = $createdUserCode;
        }


        $userMp = $this->SettlementCommonDcModel->getUsersMpCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMpCount = $userMp->num_rows();
        $userMp = $userMp->result();

        $userMla = $this->SettlementCommonDcModel->getUsersMlaCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMlaCount = $userMla->num_rows();
        $userMla = $userMla->result();

        $userSdlac = $this->SettlementCommonDcModel->getUsersSdlacCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userSdlacCount = $userSdlac->num_rows();
        $userSdlacList  = $userSdlac->result();


        if($userMpCount == 0 OR $userMlaCount == 0 OR $userSdlacCount == 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Minutes Copy to Members are incomplete ! Kindly Add Members For Minutes Copy To ',
            ];
            echo json_encode($json);
            return false;
        }
        else
        {
            $mpName = '';
            $mpHPC  = '';
            $indexM = 0;
            foreach ($userMp as $mp)
            {
                if ($indexM == 0)
                {
                    if($mp->hpc_type == 'HPC')
                    {
                        $mpName = $mp->user_name;
                        $mpHPC  = $mp->hpc_lac;
                    }
                    else
                    {
                        $mpName = $mp->user_name;
                        $mpHPC  = $mp->hpc_lac. ' '.$mp->hpc_type;
                    }

                }
                else
                {
                    if($mp->hpc_type == 'HPC')
                    {
                        $mpName = $mpName . ", " . $mp->user_name;
                        $mpHPC  = $mpHPC . ", " . $mp->hpc_lac;
                    }
                    else
                    {
                        $mpName = $mpName . ", " . $mp->user_name;
                        $mpHPC  = $mpHPC . ", " . $mp->hpc_lac. ' '.$mp->hpc_type;
                    }
                }
                $indexM++;
            }

            $mlaName = '';
            $mlaLAC  = '';
            $index   = 0;
            foreach ($userMla as $mla)
            {
                if ($index == 0)
                {
                    $mlaName = $mla->user_name;
                    $mlaLAC = $mla->hpc_lac;
                }
                else
                {
                    $mlaName = $mlaName . ", " . $mla->user_name;
                    $mlaLAC = $mlaLAC . ", " . $mla->hpc_lac;
                }
                $index++;
            }


            $zpcName = '';
            $municipalName = '';
            $socialWorker = '';
            $indexM = 0;
            $indexS = 0;
            foreach ($userSdlacList as $user)
            {
                if($user->user_level == 6)
                {
                    $zpcName = $user->user_name;
                }
                if($user->user_level == 7)
                {
                    if ($indexM == 0)
                    {
                        $bn = '';
                        if($user->board_name != '')
                        {
                            $bn = '(' .$user->board_name. ') ';
                        }
                        $municipalName = $user->user_name.$bn;
                    }
                    else
                    {
                        $bn = '';
                        if($user->board_name != '')
                        {
                            $bn = '(' .$user->board_name. ') ';
                        }
                        $municipalName = $municipalName . ", " . $user->user_name.$bn;
                    }
                    $indexM++;
                }
                if($user->user_level == 8)
                {
                    if ($indexS == 0)
                    {
                        $socialWorker = $user->user_name;
                    }
                    else
                    {
                        $socialWorker = $socialWorker . "," . $user->user_name;
                    }
                    $indexS++;
                }

            }

            echo json_encode(array(
                'responseType' => 2,
                'meetingId' => $meetingDetails->id,
                'meetingName' => $meetingName,
                'memoName' => $memoName,
                'districtName' => $districtName->locname_eng,
                'subDivName' => $subdiv_name,
                'meetingDate' => date("F j, Y", strtotime($meeting_date)),
                'timing' => strtoupper(date("h:i a", strtotime($meeting_date))),
                'meetingVenue' => $meeting_venue,
                'nominee' => $commMembers,
                'proposals' => $proposals,
                'caseList' => $caseList,
                'caseDivNot' => $caseDivNot,
                'proposalDetails' => $proposalDetails,
                'mpName' => $mpName,
                'mpHPC' => $mpHPC,
                'mlaName' => $mlaName,
                'mlaLAC' => $mlaLAC,
                'zpcName' => $zpcName,
                'municipalName' => $municipalName,
                'socialWorker' => $socialWorker,
                'reservationDetails' => $reservationDetails
            ));

            return;
        }

    }


    // reverted Meeting forward to dc
    public function sendRevertedProposalsToDcAdc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meetingId       = trim($this->input->post('meeting_id'));
        $allMem          = json_decode($this->input->post('nominee'));
        $selectMem       = json_decode($this->input->post('selectMem'));
        $meeting_date    = $this->input->post('meeting_date');
        $meeting_venue   = $this->input->post('meeting_venue');
        $meeting_remarks = $this->input->post('meeting_remarks');
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');

        $proposalQ       = $this->SettlementCommonDcModel->getRevertedProposalDetailAgainstMeetingIdMbTin($dist_code,$meetingId);
        $proposalDetails = $proposalQ->result();
        $proposalCount   = $proposalQ->num_rows();
        $proposals       = [];

        $index = 0;
        $allProposals = '';
        foreach ($proposalDetails as $proposal)
        {
            $proposals[]= $proposal->id;
            if ($index == 0)
            {
                $allProposals .= "'".$proposal->id."'";
            }
            else
            {
                $allProposals .= ",'".$proposal->id."'";
            }
            $index++;
        }

        $pendingMeeting      = $this->SettlementCommonDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdcMbTin($meetingId,$dist_code);
        $meetingDetails      = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();
        if($pendingMeetingCount == 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Meeting not found ! Meeting can not be forwarded',
            ];
            echo json_encode($json);
            return false;
        }

        if($proposalCount == 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Proposal not found ! Meeting can not be forwarded',
            ];
            echo json_encode($json);
            return false;
        }


        $allSelectedMember = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[]= $member->check_status;
        }

        $nomineeCheck = [];
        $nominee      = [];

        // for offline, forward to DC
        $adc_forward_to_dc = 1;

        $sql = $this->db->query("SELECT DISTINCT(user_code) FROM sdlac_present_member
                                          WHERE proposal_id IN ($allProposals)
                                            AND status=? AND dist_code=?",
            array(1, $dist_code));

        $mmm = $sql->result();
        $memberPresents = [];
        foreach ($mmm as $mm)
        {
            $memberPresents[] = $mm->user_code;
        }

        $newInsertedMem = [];
        foreach ($allSelectedMember as $selectedMem)
        {
            if(!in_array($selectedMem,$memberPresents))
            {
                $newInsertedMem[] = $selectedMem;
            }
        }

        // check if any of SDLAC/CDLAC Member is online
        foreach($allMem as $r)
        {
            if(in_array($r->sdlac_user,$allSelectedMember))
            {
                $nomineeCheck[] = $r;
                if(in_array($r->sdlac_user,$newInsertedMem))
                {
                    $nominee[] = $r;
                }
            }
        }

        if(count($nomineeCheck) == 0)
        {
            $json = [
                'response' => 1,
                'message'  => '#ERMR002480: There is no SDLAC/CDLAC Member, Case can not be forwarded. Kindly contact 
                        system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_begin();

        // update sdlac Meeting list with MEETING ID
        $updateMeetingDetail = [
            'meeting_date'    => $meeting_date,
            'meeting_venue'   => $meeting_venue,
            'ip'              => $this->utilityclass->get_client_ip(),
            'meeting_remarks' => $meeting_remarks,
            'updated_at'      => date('Y-m-d h:i:s'),
            'adc_forward_to_dc_status' => 1,
        ];
        $this->db->where('id', $meetingId);
        $this->db->update('proposal_meeting_list', $updateMeetingDetail);
        if($this->db->affected_rows() <= 0 ){
            $this->db->trans_rollback();
            log_message('error', '#ERMR002501: Updation failed in proposal_meeting_list 
                        and query is '. $this->db->last_query());
            $json = [
                'response' => 1,
                'message'  => '#ERMR002501: Meeting can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // update in settlement proceeding
        $proceeding_case=[
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $this->session->userdata['user_desig_code'],
            'office_to'            => MB_DEPUTY_COMM,
            'task'                 => 'Forwarded to DC for Final Check',
        ];

        // update in settlement basic for recommended cases
        $final_settlement_case_rec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $this->session->userdata['user_desig_code'],
            'dc_code'         => $this->session->userdata('user_code'),
            'dc_proceeding'   => 1,
        ];

        // update in settlement basic for not recommended cases
        $final_settlement_case_nrec = [
            'status'          => MB_FINAL_APPROVED_BY_DC,
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'from_office'     => $this->session->userdata['user_desig_code'],
            'dc_code'         => $this->session->userdata('user_code'),
            'dc_proceeding'   => 1,
        ];


        // update in settlement proposal cases for recommended cases
        $final_settlement_pro_rec_case = [
            'case_status' => 1,
            'status'      => PRO_CASE_STATUS_APPROVE,
        ];

        // update in settlement proposal cases for  not recommended cases
        $final_settlement_pro_nrec_case = [
            'case_status' => 2,
            'status'      => PRO_CASE_STATUS_REJECT,
        ];


        $recomend_count = 0;
        $notrecomend_count = 0;

        //list of proposals
        foreach($proposals as $prop)
        {
            // for only offline cases
            if($adc_forward_to_dc == 1)
            {
                //get cases by proposal number
                $cases_recomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                              (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                              FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                              ON pl.case_no=t.case_no AND pl.proposal_id=?
                              AND pl.case_status=1", array($prop))->result();


                // all Recommended cases
                $recomend_count = $recomend_count + count($cases_recomend);
                foreach($cases_recomend as $row)
                {
                    $allAPICases[] = $row->case_no;
                    $allAPICases_reco[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no']       = $row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                    $proceeding_case['note_on_order'] = 'Recommended';
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[]   = $proceeding_case;
                }


                $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2", array($prop))->result();


                // all Not Recommended cases
                $notrecomend_count = $notrecomend_count + count($cases_notrecomend);
                foreach($cases_notrecomend as $row)
                {
                    $allAPICases[] = $row->case_no;
                    $allAPICases_nrec[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no']       = $row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id+1;
                    $proceeding_case['note_on_order'] = $row->template_remarks;
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[]   = $proceeding_case;
                }
            }

            //get service code
            $service_code = $this->db->query("SELECT service_code FROM settlement_proposal_list 
                        WHERE id=?", array($prop))->row()->service_code;
            //echo $this->db->last_query();


            //insert into settlement_sdlac_member_report
            foreach($nominee as $row)
            {
                $insSdlacReport = [
                    'dist_code'             => $dist_code,
                    'proposal_no'           => $prop,
                    'sdlac_member_code'     => $row->sdlac_user,
                    'username'              => $this->utilityclass->getUserNameByUserCode($row->sdlac_user),
                    'emailid'               => $this->utilityclass->getEmailIdByUserCode($row->sdlac_user),
                    'created_at'            => date('Y-m-d h:i:s'),
                    'service_code'          => $service_code,
                    'created_by'            => $this->session->userdata['user_desig_code'],
                    'status'                => 1,
                    'nominee_id'            => $row->select_nominee,
                    'meeting_attend_status' => $row->attend_status,
                    'proposal_meeting_id'   => $meetingId,
                ];

                $insert = $this->db->insert('settlement_sdlac_member_report', $insSdlacReport);

                if($insert != 1 || $insert != true ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002644: Insertion failed in settlement_sdlac_member_report for 
                            proposal no : '.$prop. ' and query is '. $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR002644: Meeting can not be forwarded. Kindly contact 
                        system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

            }

            //update sdlac proposal list
            $updateSdlacList = [
                'meeting_date'  => $meeting_date,
                'meeting_venue' => $meeting_venue,
            ];
            $this->db->where('id', $prop);
            $this->db->update('settlement_proposal_list', $updateSdlacList);
            if($this->db->affected_rows() <= 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERMR002666: Updation failed in settlement_proposal_list 
                  for proposal no : '.$prop. ' and query is '. $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERMR002666: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        }

        //hit api
        if($adc_forward_to_dc == 1)
        {
            // batch insert into settlement_proceeding
            $insert_count = $this->db->insert_batch('settlement_proceeding',$final_proceeding_case);
            if(($recomend_count+$notrecomend_count) != $insert_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002689: INSERT failed in settlement_proceeding '.$this->db->last_query());
                $json = [
                    'response' => 1,
                    'message'  => '#ERMR002689: Meeting can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            // batch insert into settlement_basic for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
                //echo count($cases_recomend);
                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_rec,
                    'case_no',$allAPICases_reco);
                if($recomend_count != $update_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2710: Updation failed in settlement_basic for recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERRCODE2710: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_basic for not recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {

                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_nrec,
                    'case_no',$allAPICases_nrec );
                if($notrecomend_count != $update_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002725: Updation failed in settlement_basic for not recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR002725: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            // batch update into settlement_proposal_cases for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco)>0) {
                $update_pro_rec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_rec_case,
                    'case_no',$allAPICases_reco);
                if ($recomend_count != $update_pro_rec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002743: Updation failed in settlement_proposal_cases for recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR002743: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_proposal_cases for not  recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec)>0) {
                $update_pro_nrec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_nrec_case,
                    'case_no',$allAPICases_nrec);
                if ($notrecomend_count != $update_pro_nrec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002763: Updation failed in settlement_proposal_cases for not recommended '.$this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR002763: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            $caseApp = $this->SettlementCommonModel->convertLiteral($allAPICases);

            $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
            $applids = $this->db->query($sql)->row()->applids;


            //api call
            $rmk    = 'Forwarded to DC for Final Check';
            $status = 'M';
            $task   = $this->session->userdata['user_desig_code'];
            $pen    = MB_DEPUTY_COMM;
            $rtps_status=$this->SettlementApiModel->applicationStatusUpdateBulkMb3($applids,'NA',$rmk,$status,$task,$pen);

            if($rtps_status!="y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERMRAPI002788: Forward to DC failed case no # $applids");
                $json = [
                    'response' => 1,
                    'message'  => '#ERMRAPI002788: Meeting can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            $this->db->trans_commit();

            $json = [
                'response' => 2,
                'message'  => 'Reverted meeting has successfully forwarded to DC',
            ];
            echo json_encode($json);

        }
        else
        {
            $this->db->trans_rollback();
            $json = [
                'response' => 1,
                'message' => '#ERRCODE740: Meeting can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

    }


    // verify cases under reverted meeting
    public function verifyCasesUnderRevertedMeetingByDc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        // FOR_PROGRESS
        $session_status = 0;
        $log_status     = 0;
        $tmp_file       = null;
        $dist_code      = $this->session->userdata('dist_code');
        try
        {
            $_POST = json_decode(file_get_contents("php://input"), true);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required');

            $errorArray = array();
            $pullArray  = array();
            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => 'Validation Error !',
                ));
                return;
            }
            else
            {
                $meetingId   = trim($this->input->post('meetingId'));
                $dist_code   = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');



                $pendingMeeting = $this->SettlementCommonDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdcMbTin($meetingId, $dist_code);
                $meetingDetails = $pendingMeeting->row();
                $pendingMeetingCount = $pendingMeeting->num_rows();

                if ($pendingMeetingCount == 0)
                {
                    $json = [
                        'responseType' => 1,
                        'message' => 'Meeting not found !',
                    ];
                    echo json_encode($json);
                    return false;
                }


                $row_count = 0;
                if (PROG_MEET_AREA == '1')
                {
                    $sql = "select count(distinct(case_no)) as c from settlement_proposal_cases spc where spc.proposal_id in (select distinct(id) from settlement_proposal_list spl where proposal_meeting_id=?)";
                    $total_count = $this->db->query($sql, array($meetingId))->row()->c;
                    $tmp_file = PROGRESS_DIR . $dist_code.'_'.$meetingId . ".txt";
                    if (file_exists($tmp_file))
                        unlink($tmp_file);
                    $session_status = session_write_close();
                }

                $getProposalsList = $this->SettlementMeetingDcInsModel->getProposalDetailAgainstMeetingIdMBTin($dist_code, $meetingId)->result();


                foreach ($getProposalsList as $prop)
                {
                    $proposal_no = $prop->proposal_id;
                    $pendingCase = $this->SettlementMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                    $cases       = $pendingCase->result();
                    $caseCount   = $pendingCase->num_rows();


                    if($caseCount == 0)
                    {
                        if ($session_status == 1) session_start();
                        log_message('error', '#MR0003155: Cases not found for proposal id '.$proposal_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#MR0003155: Unable to process for final approval (Cases not found). 
                                          Kindly contact system administrator !!!!',
                        ));
                        return;
                    }
                    else
                    {
                        foreach ($cases as $case)
                        {
                            $row_count++;
                            $st_time   = microtime(true);
                            $case_no   = trim($case->case_no);
                            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);

                            $pullCheck = $this->checkCaseInModificationRequestWithSession($case_no);

                            if (PROG_MEET_AREA == '1')
                            {
                                $this->ProgressModel->saveBulkCasesByMeetingProgress($row_count,$total_count,$tmp_file);
                            }
                            if ($checkArea != 0)
                            {
                                $errorArray[] = $case_no;
                            }
                            if ($pullCheck != 0)
                            {
                                $pullArray[] = $case_no;
                            }
                            if($checkArea !=0 OR $pullCheck !=0)
                            {
                                continue;
                            }
                            if ($log_status == 1)
                            {
                                log_message('error','case_count: '.$row_count.', time taken='.(microtime(true)-$st_time));
                            }
                        }
                    }
                }
                $revertBulkChitha = $errorArray;
                $revertBulkPull   = $pullArray;
                if(count($errorArray) > 0 OR count($pullArray) > 0)
                {
                    $case_str  = '';
                    $case_pull = '';

                    foreach ($errorArray as $err)
                    {
                        $case_str = $case_str.$err.',';
                    }
                    foreach ($pullArray as $pull)
                    {
                        $case_pull = $case_pull.$pull.',';
                    }
                    $errorShow = '';
                    if($case_pull != NULL && $case_str == NULL)
                    {
                        $errorShow = '<b>There is modification request for  
                                      Case No.</b> '.'<br>'.$case_pull;
                    }
                    else if($case_str != NULL && $case_pull == NULL)
                    {
                        $errorShow = '<b>Total Area Recommended for Settlement can’t exceed available Area in Chitha
                                      Case No.</b>  '.'<br>'.$case_str ;
                    }
                    else
                    {
                        $var1 = '<b>Total Area Recommended for Settlement can’t exceed available Area in Chitha
                                 Case No.</b> '.'<br>'.$case_str;
                        $var2 = '<b>There is modification request for  
                                 Case No.</b> '.'<br>'.$case_pull;

                        $errorShow = $var1.'<br><br>'.$var2;
                    }
                    log_message('error', '#MR0003166: '.$errorShow .') !');
                    if ($session_status == 1) session_start();
                    echo json_encode(array(
                        'responseType'     => 101,
                        'message'          => $errorShow,
                        'revertBulkChitha' => $revertBulkChitha,
                        'revertBulkPull'   => $revertBulkPull
                    ));
                    return false;
                }
                else
                {
                    if ($session_status == 1) session_start();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message'      => 'Everything ok, now you can click on "VIEW MEETING MINUTES & SEND TO DC" button to send the meeting to DC ',

                    ));
                    return false;
                }
            }
        }
        catch (Exception $e)
        {
            if ($session_status == 1) session_start();
            echo json_encode(array(
                'responseType' =>1,
                'message'      => '#ERR3110: Some error occured  !!',
            ));
            return;
        }
        finally
        {
            if (PROG_MEET_GENERATE == '1')
            {
                if (file_exists($tmp_file))
                {
                    unlink($tmp_file);
                }
            }
            if ($log_status == 1)
            {
                log_message('error', ' session_status: '.$session_status);
            }
        }
    }








    /// ***************  Forwarded Meeting by ADC ********************

    // get Forwarded meeting list
    public function forwardedMeetingListForAdc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');
        $data['dist_code'] = $dist_code;

        $pendingCase              = $this->SettlementCommonDcModel->getForwardedMeetingListAdcMbTin($dist_code,$createdBy);
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'SettlementView/Adc/forwarded_meeting_list_adc_ins';
        $this->load->view('layouts/main', $data);
    }


    // get Meeting details by ADC
    public function getForwardedMeetingDetailsByIdAdc()
    {

        $meetingId = trim($this->input->get('meetingId'));
        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');

        $meeting = $this->SettlementCommonDcModel->getForwardedMeetingDetailByMeetingIDAdcMbTin(
            $meetingId,$dist_code,$createdBy)->row();

        $meetingName = trim($meeting->meeting_name);

        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/forwardedMeetingListForAdc");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->SettlementCommonDcModel->getProposalDetailAgainstMeetingIdForAdc($meetingId,
            $dist_code,$createdBy)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport = $this->SettlementMeetingDcModel->sdlacMemberReportDetail($dist_code,
            $meetingId)->result();

        $additionalDoc = $this->SettlementCommonDcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'SettlementView/Adc/forwarded_proposals_against_meeting_id_adc_ins';
        $this->load->view('layouts/main', $data);
    }


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // additional file upload
    public function postAdditionalFileUnderMeetingAdc()
    {
        $this->load->library('form_validation');
        
        if(isset($_FILES['fileUpload']['name']))
        {
            if($_FILES['fileUpload']['name'] && $_FILES['fileUpload']['size'] && $_FILES['fileUpload']['tmp_name'])
            {

                $name = $_FILES['fileUpload']['name'];
                $size = $_FILES['fileUpload']['size'];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];

                if($name != NULL)
                {
                    if($ext == NULL)
                    {
                        $this->form_validation->set_rules('additional_doc_err','File extension','required');

                    }
                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                    {
                        $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        $this->form_validation->set_rules('additional_doc_err','Maximum 5MB file size','required');
                    }
                }
                else
                {
                    $this->form_validation->set_rules('additional_doc_err','File name','required');
                }
            }
            else
            {
                $this->form_validation->set_rules('additional_doc_err','File','required');
            }
        }


        $this->form_validation->set_rules('gurdDocType', 'Document Type', 'trim|required');
        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('meetingName', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('fileName',  'Document Name', 'required|min_length[3]|max_length[99]');
        if($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'response' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $meetingId   = $this->input->post('meetingId');
            $meetingName = $this->input->post('meetingName');
            $fileName    = $this->input->post('fileName');
            $gurdDocType = $this->input->post('gurdDocType');
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('mb_status', 3)
                ->get('proposal_meeting_list')
                ->num_rows();

            if($checkMeeting == 1)
            {
                $_FILES['file']['name']  = $_FILES['fileUpload']['name'];
                $_FILES['file']['type']  = $_FILES['fileUpload']['type'];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'];
                $_FILES['file']['size']  = $_FILES['fileUpload']['size'];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name']);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $this->db->trans_begin();

                    if(trim($gurdDocType) == 1)
                    {
                        $upMeeting = [
                            'signed_minute' => $gurdDocType
                        ];

                        $this->db->where('id', $meetingId);
                        $this->db->where('dist_code', $dist_code);
                        $this->db->update('proposal_meeting_list', $upMeeting);
                        if($this->db->affected_rows() !=1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMRDOC0033799: Updation failed in proposal_meeting_list '
                                .$this->db->last_query());
                            echo json_encode(array(
                                'response' => 1,
                                'message' => 'ERMRDOC0033799: There is some problem, Please try again',
                            ));
                            return;
                        }
                    }

                    $document= array(
                        'case_no'    => $meetingName,
                        'file_name'  => $fileName,
                        'user_code'  => $this->session->userdata('user_code'),
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => UPLOAD_DIR. $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'ADC',
                        'fetch_file_name' => $fileName,
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERMRDOC003370: Insertion failed in supportive document Meeting Name '.$meetingName);
                        echo json_encode(array(
                            'response' => 1,
                            'message' => 'ERMRDOC003370: There is some problem, Please try again',
                        ));
                        return;
                    }

                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMRDOC003382: Insertion failed in supportive document Meeting Name '.$meetingName);
                    echo json_encode(array(
                        'response' => 1,
                        'message' => 'ERMRDOC003382: There is some problem, Please try again',
                    ));
                    return;
                }

                $this->db->trans_commit();
                echo json_encode(array(
                    'response' => 2,
                    'message' => 'Additional document successfully uploaded',
                ));
                return;
            }
            else
            {
                echo json_encode(array(
                    'response' => 1,
                    'message' => 'ERMRDOC003399: Meeting not found !',
                ));
                return;
            }
        }
    }


    // proposal edit option from sdlac minutes Adc
    public function proposalEditOnSdlacMinutesAdc()
    {
        $proposal_no = trim($this->input->get('case'));
        $dist_code   = $this->session->userdata('dist_code');
        $createdBy   = $this->session->userdata('user_desig_code');
        $subDiv_code = $this->session->userdata('subdiv_code');

        $pendingCase = $this->SettlementCommonDcModel->getAllCaseInProposalUnderRevertedMeeting($proposal_no);
        $proposalDetails = $this->SettlementCommonDcModel->getRevertedProposalDetailsByIdAdcMbTin($proposal_no,$dist_code);

        if($proposalDetails->meeting_create_status != 1)
        {
            $this->session->set_flashdata('error', "Proposal already add in Meeting !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/commonProposalListView");
        }

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


        $data['_view'] = 'settlementView/Adc/edit_proposal_from_sdlac_minutes_adc_ins';
        $this->load->view('layouts/main', $data);
    }



    //// VGR/PGR REVERT CASE FROM ADC END  ///****************

    // get VGR/PGR reverted case page
    public function getVgrPgrRevertedCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $createdBy   = $this->session->userdata('user_desig_code');
        $subDiv_code = $this->session->userdata('subdiv_code');

        $allCases = $this->SettlementCommonDcModel->getAllVgrPgrRevertedCaseForAdc($dist_code,$createdBy);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCases->result();
        $data['pendingCaseCount'] = $allCases->num_rows();

        $data['_view'] = 'settlementView/Adc/vgr_pgr_reverted_adc';
        $this->load->view('layouts/main', $data);

    }


    // get VGR/PGR reverted case Details
    public function getVgrPgrRevertedCaseDetails()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $createdBy   = $this->session->userdata('user_desig_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $caseId      = trim($this->input->get('case'));

        if($caseId == '' || $caseId == NULL)
        {
            $this->session->set_flashdata('error', "Case not found !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }

        $revert = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetails($dist_code,$caseId);
        if($revert->num_rows() == 0 || $revert->num_rows()== '')
        {
            $this->session->set_flashdata('error', "Case not found !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }
        $revertDetails = $revert->row();

        if(trim($revertDetails->status) == 0)
        {
            $this->session->set_flashdata('error', "Case already processed !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }
        if(trim($revertDetails->to_office) != $createdBy)
        {
            $this->session->set_flashdata('error', "You are not authorized !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }

        $case_no   = trim($revertDetails->case_no);
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            $this->session->set_flashdata('message', " Case not found ! ");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }
        $caseDetails     = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
        $proposalDetails = $this->SettlementCommonDcModel->getProposalDetailsByProId(trim($revertDetails->proposal_id));
        $meetingDetails  = $this->SettlementCommonDcModel->getMeetingDetailByMeetingIdMbTin(trim($revertDetails->meeting_id));
        $getProposalID   = $this->SettlementCommonDcModel->getSettlementRevertedProposalCaseDetailsByCaseNo($case_no);
        if($meetingDetails->vgr_pgr_status != 1)
        {
            $this->session->set_flashdata('error', "Only VGR/PGR cases can revert !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            $this->session->set_flashdata('error', "Meeting already Processed !");
            redirect(base_url() . "index.php/SettlementProposalControllerIns/getVgrPgrRevertedCaseList");
        }

        $data['dist_code']       = $dist_code;
        $data['basic']           = $caseDetails;
        $data['proposalDetails'] = $proposalDetails;
        $data['meetingDetails']  = $meetingDetails;
        $data['proposalCaseD']   = $getProposalID;
        $data['revertDetails']   = $revertDetails;


        $data['_view'] = 'settlementView/Adc/vgr_pgr_reverted_details_adc';
        $this->load->view('layouts/main', $data);

    }


    // reverted vgr case revert back to CO
    public function revertedVgrCaseRevertToCo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('revertedId', 'Reverted case ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004318: Validation error ! Please enter remarks ',
            ]);
            return false;
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $case_no   = trim($this->input->post('caseNo'));
        $rev_id    = trim($this->input->post('revertedId'));
        $remark    = trim($this->input->post('remarks'));

        if($user_desig_code != MB_ADD_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004334: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $revertedCase = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetailsForRevertToCo
        ($rev_id,$case_no,$dist_code,$user_desig_code);
        if($revertedCase->num_rows() != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004345: Case not found ! ',
            ]);
            return false;
        }

        $revertedCaseDetails = $revertedCase->row();
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004356: Case not found ! ',
            ]);
            return false;
        }

        $meetingDetails = $this->SettlementCommonDcModel->getMeetingDetailByMeetingIdMbTin(trim($revertedCaseDetails->meeting_id));
        if($meetingDetails->vgr_pgr_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004365: Only VGR/PGR cases can revert ! ',
            ]);
            return false;
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004374: Meeting already Processed ! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        $updateData = array(
            'to_office'   => MB_CIRCLE_OFFICER,
            'from_office' => trim($user_desig_code),
            'updated_at'  => date('Y-m-d h:i:s'),
        );

        $this->db->where('id', $rev_id);
        $this->db->where('case_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->update('settlement_vgr_pgr_revert_cases', $updateData);
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR004374: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR004400: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // add proceeding
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null)
        {
            $proceeding_id=1;
        }
        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => 'VR',
            'user_code'            => $user_code,
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_on_order'        => $remark,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => trim($user_desig_code),
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Meeting Revert back to '.MB_CIRCLE_OFFICER
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR004433: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR004433: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // API Calling
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk    = 'Reverted by '.$user_desig_code;
        $status = 'M';
        $task   = $user_desig_code;
        $pen    = MB_CIRCLE_OFFICER;
        $case   = $case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        if(trim($rtps_status)!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPIVR04454: Case revert to CO failed for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRAPIVR04454: Case can not be reverted. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message' => 'Case ('.$case_no.') successfully reverted to CO',
        ]);
        return false;

    }


    // reverted vgr case Forward to DC
    public function revertedVgrCaseForwardToDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('forwardId', 'Forwarded case ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004318: Validation error ! Please enter remarks ',
            ]);
            return false;
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $case_no   = trim($this->input->post('caseNo'));
        $for_id    = trim($this->input->post('forwardId'));
        $remark    = trim($this->input->post('remarks'));

        if($user_desig_code != MB_ADD_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004498: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $revertedCase = $this->SettlementCommonDcModel->getVgrPgrRevertedCaseDetailsForRevertToCo
        ($for_id,$case_no,$dist_code,$user_desig_code);
        if($revertedCase->num_rows() != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004509: Case not found ! ',
            ]);
            return false;
        }

        $revertedCaseDetails = $revertedCase->row();
        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0 || $caseCount == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004520: Case not found ! ',
            ]);
            return false;
        }

        $meetingDetails = $this->SettlementCommonDcModel->getMeetingDetailByMeetingIdMbTin(trim($revertedCaseDetails->meeting_id));
        if($meetingDetails->vgr_pgr_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004530: Only VGR/PGR cases can revert ! ',
            ]);
            return false;
        }
        if($meetingDetails->vgr_pgr_revert_status != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004538: Meeting already Processed ! ',
            ]);
            return false;
        }

        $remainingCases = $this->SettlementCommonDcModel->countAllPendingVgrPgrRevertedMeetingCases(trim($revertedCaseDetails->meeting_id),$dist_code);

        $this->db->trans_begin();
        if($remainingCases == 0 || $remainingCases == '' )
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004550: All reverted cases already Processed ! ',
            ]);
            return false;
        }

        // if meeting hold under DC
        if(trim($revertedCaseDetails->meeting_pending_at) == MB_DEPUTY_COMM && $meetingDetails->digital_sign_status == 0)
        {
            if($remainingCases == 1)
            {
                $updateMeeting = array(
                    'vgr_pgr_revert_status' => 0
                );
                $this->db->where('id', trim($revertedCaseDetails->meeting_id));
                $this->db->where('dist_code', $dist_code);
                $this->db->update('proposal_meeting_list', $updateMeeting);
                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRVGRR004573: Updation failed in proposal_meeting_list 
                    for meeting no : '.trim($revertedCaseDetails->meeting_id). ' and query is '. $this->db->last_query());
                    $json = [
                        'responseType' => 1,
                        'message' => '#MRVGRR004573: Case can not be forward. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            $updateDataC = array(
                'to_office'      => MB_DEPUTY_COMM,
                'from_office'    => trim($user_desig_code),
                'status'         => 0,
                'approve_status' => 'VC',
                'updated_at'     => date('Y-m-d h:i:s'),
            );

            $this->db->where('id', $for_id);
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->update('settlement_vgr_pgr_revert_cases', $updateDataC);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRVGRR004600: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRR004600: Case can not be forward. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }
        elseif(trim($revertedCaseDetails->meeting_pending_at) == MB_DEPARTMENT && $meetingDetails->digital_sign_status == 1)
        {
            $updateDataF = array(
                'to_office'   => MB_DEPUTY_COMM,
                'from_office' => trim($user_desig_code),
                'updated_at'  => date('Y-m-d h:i:s'),
            );

            $this->db->where('id', $for_id);
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->update('settlement_vgr_pgr_revert_cases', $updateDataF);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRVGRR004626: Updation failed in settlement_vgr_pgr_revert_cases 
                    for case_no : '.$case_no. ' and query is '. $this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message' => '#MRVGRR004626: Case can not be forward. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRVGRR004637: Case can not be forward !  Kindly contact system administrator',
            ]);
            return false;
        }

        // add proceeding
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null)
        {
            $proceeding_id=1;
        }
        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => 'VF',
            'user_code'            => $user_code,
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_on_order'        => $remark,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => trim($user_desig_code),
            'office_to'            => MB_DEPUTY_COMM,
            'task'                 => 'Meeting Forwarded to '.MB_DEPUTY_COMM
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVGRR004667: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRVGRR004667: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // API Calling
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk    = 'Forwarded by '.$user_desig_code;
        $status = 'M';
        $task   = $user_desig_code;
        $pen    = MB_DEPUTY_COMM;
        $case   = $case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        if(trim($rtps_status)!="y")
        {
            $this->db->trans_rollback();
            log_message('error', '#MRAPIVR04691: Case forwarded to CO failed for case no :'. $case_no);
            $json = [
                'responseType' => 1,
                'message' => '#MRAPIVR04691: Case can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message' => 'Case ('.$case_no.') successfully forwarded to DC',
        ]);
        return false;

    }

}

