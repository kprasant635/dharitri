<?php
class OfflineSettlementLMController extends CI_Controller
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


    //// ******************* 29-04-2024 / Masud Reza *************************

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // view all pending application for LM
    public function getPendingApplicationListLM()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subDiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no      = trim($this->session->userdata('lot_no'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $pendingApplication = $this->OfflineCommonModel->getPendingOfflineApplicationList($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode);

        $data['applicationCount'] = $pendingApplication->num_rows();
        $data['applications']     = $pendingApplication->result();

        $data['_view'] = 'OfflineSettlement/Lm/pending_offline_application_list_lm';
        $this->load->view('layouts/main', $data);

    }


    // get application
    public function getKhasApplicationDetailsLM()
    {
        $caseNoEn  = $this->input->get('app');
        $caseNo    = $this->offlineutility->decryptJwtCase($caseNoEn);
        $dist_code = trim($this->session->userdata('dist_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $this->OfflineCommonModel->checkUserPendingWithByCaseNo($caseNo);

        // check application
        if($this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$caseNo) != 1)
        {
            $errors = '#MROFN01: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getPendingApplicationListLM');
        }

        // application details
        $application = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);

        $serviceCode = $application->service_code;
        if(!in_array($serviceCode, OFFLINE_SERVICE_CODE_ALLOW))
        {
            $errors = '#MROFK0002: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');
        }

        // applicant details
        $applicants = $this->OfflineCommonModel->getApplicantOfflineApplication($dist_code,$caseNo);

        // get applicants as owners
        $applicants_owners = $this->OfflineCommonModel->getAllApplicantOwners($caseNo);

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
        $documents = $this->OfflineCommonModel->getDocuments($caseNo);

        // LM Note
        $lmNotes = $this->OfflineCommonModel->getNcLmNote($caseNo);

        // get all circle officer
        $allCircle = $this->OfflineCommonModel->getCoName($dist_code, $application->subdiv_code,$application->cir_code);

        // premium details
        $premium = $this->OfflineCommonModel->getOfflineAppPremium($caseNo);

        $rejected_data = $this->OfflineCommonModel->getRejectModal($serviceCode);
        if($rejected_data == 'n')
        {
            $data['rejected_list'] = false;
        }
        else
        {
            $data['rejected_list'] = $rejected_data;
        }
        $data['co_name_reject'] = $this->OfflineCommonModel->getCoName($dist_code, $application->subdiv_code,$application->cir_code);
        if($data['rejected_list'] != false)
        {
            $data['dagFlagCheckChitha'] = $this->OfflineCommonModel->getChithaFlaggedRemarks($dags, $data['rejected_list']);
        }
        else
        {
            $data['dagFlagCheckChitha'] = false;
        }

        $additional_property =$this->UtilsModel->getAdditionalPropertyByCase($caseNo);
        if($additional_property->num_rows() > 0)
        {
            $totallesaa=0;
            $totalganda=0;
            foreach($additional_property->result() as $addprop)
            {
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY)))
                {
                    $total_g=$this->offlineutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }
                else
                {
                    $total_l=$this->offlineutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }
            }
            if(!empty($totallesaa))
            {
                $data['total_aditional_area']= $this->offlineutility->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda))
            {
                $data['total_aditional_area_g']= $this->offlineutility->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $data['additional_property']=$additional_property->result();

        }


        $data['geo_date']     = date('Y-m-d');
        $data['district_all'] = $this->UtilsModel->getAllDistrictList();
        $data['co_name']      = $allCircle;
        $data['dist_code']    = $dist_code;
        $data['guar_rel']     = $relations;
        $data['case_no']      = $caseNo;
        $data['basic']        = $application;
        $data['applicants']   = $applicants;
        $data['dags']         = $dags;
        $data['dag_count']    = count($dags);
        $data['nominee']      = $nominee;
        $data['deleted_dags'] = $deletedData;
        $data['documents']    = $documents;
        $data['lmnotes']      = $lmNotes;
        $data['premium_data'] = $premium;
        $data['premium']      = $premium;
        $data['applicants_buyers']               = $applicants;
        $data['applicants_encroacher']           = $applicants_encroacher;
        $data['applicants_owners']               = $applicants_owners;
        $data['deleted_encroacher']              = $deletedEnc;
        $data['land_bank_status']                = $land_bank_status;
        $data['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
        $data['settlement_land_bank_details']    = $settlement_land_bank_details;

        $data['_view'] = 'OfflineSettlement/Lm/offline_application_details_lm';
        $this->load->view('layouts/main', $data);

    }


    // LM Report Submit
    public function saveOfflineSettlementLmReport()
    {
        $distCode       = trim($this->session->userdata('dist_code'));
        $caseNo         = trim($this->input->post('case_no'));
        $application_no = $this->offlineutility->encryptJwtcase($caseNo);
        if($caseNo == '' or $caseNo == NULL)
        {
            $errors = 'There is some problem ! please try again';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getPendingApplicationListLM');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mouza_code', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill_code', 'Village', 'trim|required');
        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('case_no', 'Case No', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
        $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
        $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');

        $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('is_landless', 'Whether application is landless', 'trim|required');
        $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
        $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
        $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');
        $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
        $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
        $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('finalamount', 'Premium Amount', 'trim|required|greater_than[0]');
        if (empty($_FILES['field_report']['name']))
        {
            $this->form_validation->set_rules('field_report', 'Field report document', 'required');
        }

        $roadside_comment_check           = trim($this->input->post('roadside_comment_check'));
        $family_comment_check             = trim($this->input->post('family_comment_check'));
        $totalDagAreaLessaValidation      = 0;
        $totalAgrAreaLessaValidation      = 0;
        $totalHomeAreaLessaValidation     = 0;
        $appAreaMoreThanDagA              = 0;
        $reserveMoreThanAppArea           = 0;
        $familyMoreThanAppArea            = 0;
        $totalRoadSideAreaLessaValidation = 0;
        $totalFamilyAreaLessaValidation   = 0;


        //  LM remarks validation
        $lm_note = trim($this->input->post('lm_note'));
        if($lm_note == 2)
        {
            $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');
            if(isset($_POST['rejected_reasons']))
            {
                foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                {
                    $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                }
            }
            if(isset($_POST['sub_rejected_reasons']))
            {
                foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                {
                    $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                }
            }
            $this->form_validation->set_rules('co_code_reject', 'Select Circle Officer', 'trim|required');
        }

        // dag details
        $dags = $this->OfflineCommonModel->getOfflineSettlementDagDetails($distCode,$caseNo);
        $applicants_encroacher = $this->OfflineCommonModel->getAllApplicantEncroacher($caseNo);

        // area validation
        foreach ($dags as $dag_area_cal)
        {
            if (in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                {
                    $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                }

                $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');

                $bighaValidation     = $dag_area_cal->dag_area_b;
                $kathaValidation     = $dag_area_cal->dag_area_k;
                $lessaValidation     = $dag_area_cal->dag_area_lc;
                $gandaValidation     = $dag_area_cal->dag_area_g;
                $bighaValidationHome = $dag_area_cal->home_b;
                $kathaValidationHome = $dag_area_cal->home_k;
                $lessaValidationHome = $dag_area_cal->home_lc;
                $gandaValidationHome = $dag_area_cal->home_g;
                $bighaValidationAgr  = $dag_area_cal->agri_b;
                $kathaValidationAgr  = $dag_area_cal->agri_k;
                $lessaValidationAgr  = $dag_area_cal->agri_lc;
                $gandaValidationAgr  = $dag_area_cal->agri_g;

                $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation )
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                if ($roadside_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda'.$dag_area_cal->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti'.$dag_area_cal->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                    $kathaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                    $lessaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                    $gandaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }
                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
                if ($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda_family'.$dag_area_cal->dag_no, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti_family'.$dag_area_cal->dag_no, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                    $kathaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                    $lessaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
                    $gandaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }

                // new premium addition
                if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                {
                    $maxland_check = $this->OfflineCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                    if(!empty($maxland_check->max_land))
                    {
                        if($maxland_check->max_land =='40')
                        {
                            $maxland_ganda = 2560;
                        }
                        elseif($maxland_check->max_land =='60')
                        {
                            $maxland_ganda = 3840;
                        }
                        if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }

                if(OFFLINE_KHAS_MAX_HOMESTEAD * 6400 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 6400 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }
            else
            {
                if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                {
                    $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                }

                $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');

                $bighaValidation     = $dag_area_cal->dag_area_b;
                $kathaValidation     = $dag_area_cal->dag_area_k;
                $lessaValidation     = $dag_area_cal->dag_area_lc;
                $bighaValidationHome = $dag_area_cal->home_b;
                $kathaValidationHome = $dag_area_cal->home_k;
                $lessaValidationHome = $dag_area_cal->home_lc;
                $bighaValidationAgr  = $dag_area_cal->agri_b;
                $kathaValidationAgr  = $dag_area_cal->agri_k;
                $lessaValidationAgr  = $dag_area_cal->agri_lc;

                $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation )
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                if ($roadside_comment_check=='YES') {
                    $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                    $kathaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                    $lessaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }

                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
                if ($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                    $kathaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                    $lessaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }

                // new premium addition
                if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                {
                    $maxland_check = $this->OfflineCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                    if(!empty($maxland_check->max_land))
                    {
                        if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }
                else
                {
                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                }

                if (OFFLINE_KHAS_MAX_HOMESTEAD * 100 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 100 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }

            $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of possession', 'trim|required|xss_clean');
            $this->form_validation->set_rules('approval'.$dag_area_cal->dag_no, 'Approve by office', 'trim|required|xss_clean');

            $dag_array[]    = $this->input->post('approval'.$dag_area_cal->dag_no);
            $dag_by_approve = $this->input->post('approval'.$dag_area_cal->dag_no);
        }


        foreach ($applicants_encroacher as $enc_applicant)
        {
            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, 'Encroacher exist in VLB', 'trim|required|is_natural');
        }
        if ($reserveMoreThanAppArea == 1)
        {
            $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
        }
        if ($familyMoreThanAppArea == 1)
        {
            $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');
        }
        if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0)
        {
            $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
        }
        if ($appAreaMoreThanDagA == 1)
        {
            $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
        }

        // additional file upload validation
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size

            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];

                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
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
                            $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
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
        }


        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $this->OfflineCommonModel->checkUserPendingWithByCaseNo($caseNo);

        $dist_code              = trim($this->input->post('dist_code'));
        $subdiv_code            = trim($this->input->post('subdiv_code'));
        $cir_code               = trim($this->input->post('cir_code'));
        $mouza_code             = trim($this->input->post('mouza_code'));
        $lot_no                 = trim($this->input->post('lot_no'));
        $vill_code              = trim($this->input->post('vill_code'));
        $roadside_comment_check = trim($this->input->post('roadside_comment_check'));
        $family_comment_check   = trim($this->input->post('family_comment_check'));
        $co_code                = $this->input->post('co_code');
        $finalamount            = trim($this->input->post('finalamount'));
        $serviceCode            = OFFLINE_KHAS_LAND_ID;


        $this->db->trans_begin();

        foreach ($applicants_encroacher as $enc_applicant)
        {
            $applicant_array = [
                'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'.$enc_applicant->id)
            ];

            $this->db->where('id', $enc_applicant->id);
            $this->db->where('case_no', $caseNo);
            $this->db->update('settlement_applicant', $applicant_array);
            if($this->db->affected_rows() <= 0)
            {

                $this->db->trans_rollback();
                log_message('error', '#MROFK0003: Updating failed in settlement_applicant Case No '.$caseNo);
                $errors = '#MROFK0003: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
            }
        }

        $approved_by =null;
        if ($dag_by_approve !='' || $dag_by_approve !=null )
        {
            if(count($dag_array)==1)
            {
                $approved_by =$dag_by_approve;
            }
            else
            {
                if(count(array_unique($dag_array))<count($dag_array))
                {
                    $approved_by = $dag_by_approve;
                }
                else
                {
                    $approved_by = 'GOVT';
                }
            }
        }


        // update basic data
        $basicData = [
            'status'          => 'W',
            'lm_code'         => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office'     => MB_LOT_MONDOL,
            'pending_officer' => MB_CIRCLE_OFFICER,
            'pending_office'  => MB_CIRCLE_OFFICER,
            'sk_code'         => $co_code,
            'co_code'         => $co_code,
            'approve_by'      => $approved_by
        ];
        $this->db->where('case_no', $caseNo);
        $this->db->update('settlement_basic', $basicData);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0004: Updating failed in settlement_basic Case No '.$caseNo);
            $errors = '#MROFK0004: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);

        }

        // insertion in backup table
        $phase_count         = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = '$caseNo' AND from_office = 'LM'")->row()->ct;
        $phase_count         = (int)$phase_count+1;
        $backup_array_lm     = [
            'applid'      => $caseNo,
            'case_no'     => $caseNo,
            'from_office' => MB_LOT_MONDOL,
            'to_office'   => MB_CIRCLE_OFFICER,
            'status'      => 'W',
            'phase'       => 'LM_'.$phase_count,
            'data'        => json_encode($_POST)
        ];
        $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
        if($backup_insertion_lm != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#BACKUPF002: Insertion failed in settlement_backup_json  Case No '.$caseNo);
            $errors = '#BACKUPF002: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);

        }

        // update dag details
        foreach ($dags as $dagsland)
        {
            $landmark_east  = trim($this->input->post('landmark_east'.$dagsland->dag_no));
            $landmark_west  = trim($this->input->post('landmark_west'.$dagsland->dag_no));
            $landmark_north = trim($this->input->post('landmark_north'.$dagsland->dag_no));
            $landmark_south = trim($this->input->post('landmark_south'.$dagsland->dag_no));
            $landmark = [
                'east'  => $landmark_east,
                'west'  => $landmark_west,
                'north' => $landmark_north,
                'south' => $landmark_south,
            ];

            $fmddata= [
                'date_entry' => date('Y-m-d'),
                'landmark'   => json_encode($landmark),
                'nature_possession' => $this->input->post('nature_possession'.$dagsland->dag_no),
            ];
            $this->db->where('case_no', $caseNo);
            $this->db->where('dag_no', $dagsland->dag_no);
            $this->db->update('settlement_dag_details', $fmddata);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK0005: Insertion failed in settlement_dag_details  Case No '.$caseNo);
                $errors = '#MROFK0005: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
            }
        }


        // upload additional file
        if(isset($_FILES['fileUpload']['name']))
        {
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name']     = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type']     = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size']     = $_FILES['fileUpload']['size'][$i];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']      = UPLOAD_MAX_SIZE;;
                $config['file_name']     = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'         => $caseNo,
                        'file_name'       => $_POST['fileText'][$i],
                        'user_code'       => $this->session->userdata('user_code'),
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'       => $_FILES['file']['type'],
                        'file_path'       => UPLOAD_DIR . $fileRename,
                        'date_entry'      => date('Y-m-d h:i:s'),
                        'mut_type'        => $serviceCode,
                    );

                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MROFK0006: Insertion failed in supportive_document  Case No '.$caseNo);
                        $errors = '#MROFK0006: There is some problem. Kindly contact system administrator';
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFK0007: Insertion failed in supportive_document  Case No '.$caseNo);
                    $errors = '#MROFK0007: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                }
            }
        }


        // For uploading dag wise trace_map_copy
        foreach ($dags as $dags_doc)
        {
            $timestamp         = date('mdYhis', time()).uniqid();
            $trace_map_file    = $_FILES['trace_map_copy'.$dags_doc->dag_no];
            $trace_file_name   = 'trace_map_copy'.$timestamp;
            $trace_upload_path = UPLOAD_DIR.$timestamp.$trace_map_file['name'];

            $document= array(
                'case_no'         => $caseNo,
                'applid'          => $caseNo,
                'file_name'       => 'Trace Map Copy',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => $trace_map_file['name'],
                'file_type'       => $trace_map_file['type'],
                'file_path'       => $trace_upload_path,
                'date_entry'      => date('Y-m-d h:i:s'),
                'mut_type'        => $serviceCode,
                'dag_no'          => $this->input->post('dag_no_doc'.$dags_doc->dag_no),

            );
            $insert_supportive_doc = $this->db->insert('supportive_document', $document);
            if ($insert_supportive_doc != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK0008: Insertion failed in supportive_document  Case No '.$caseNo);
                $errors = '#MROFK0008: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
            }

            if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)
            {
                // Trace Map copy upload
                $config['file_name']     = $trace_file_name;
                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']      = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if(!move_uploaded_file($trace_map_file['tmp_name'], $trace_upload_path))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFK0009: Insertion failed in supportive_document  Case No '.$caseNo);
                    $errors = '#MROFK0009: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                }
            }
        }

        // For Uploading Field Report
        $field_report_file = $_FILES['field_report'];
        $timestamp         = date('mdYhis', time()).uniqid();
        $field_file_name   = 'field_report'.$timestamp;
        $field_report_path = UPLOAD_DIR.$timestamp.$field_report_file['name'];
        $document= array(
            'case_no'         => $caseNo,
            'applid'          => $caseNo,
            'file_name'       => 'Field Report',
            'user_code'       => $this->session->userdata('user_code'),
            'fetch_file_name' => $field_report_file['name'],
            'file_type'       => $field_report_file['type'],
            'file_path'       => $field_report_path,
            'date_entry'      => date('Y-m-d h:i:s'),
            'mut_type'        => $serviceCode,
        );

        $insert_supportive_doc= $this->db->insert('supportive_document', $document);
        if ($insert_supportive_doc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0010: Insertion failed in supportive_document  Case No '.$caseNo);
            $errors = '#MROFK0010: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }


        if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)
        {
            $config2['file_name']     = $field_file_name;
            $config2['upload_path']   = UPLOAD_DIR;
            $config2['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config2['max_size']      = 2000;
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);
            if(!move_uploaded_file($field_report_file['tmp_name'], $field_report_path))
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK0011: Insertion failed in supportive_document  Case No '.$caseNo);
                $errors = '#MROFK0011: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
            }
        }

        //*********if LM if case of case rejected the rejected remarks */

        $responseMasterObj = $this->OfflineCommonModel->lmRejectedValidationBypassFalse($serviceCode);


        $comment = addslashes($this->input->post('lm_note'));

        $pro_class_lm = $this->input->post('protected_class_lm');
        $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

        $lmnote = array(
            'user_code'               => $this->session->userdata('user_code'),
            'chitha_verified'         => $this->input->post('chitha_verified'),
            'vlb_verified'            => $this->input->post('vlb_verified'),
            'is_tribal_belt'          => $this->input->post('is_tribal_belt'),
            'possession_verification' => $this->input->post('possession_verification'),
            'period_possession'       => date('Y-m-d'),
            'is_landless'             => $this->input->post('is_landless'),
            'land_falls'              => $this->input->post('land_falls'),
            'falls_und_gmc'           => $this->input->post('falls_und_gmc'),
            'roadside_reservation'    => $this->input->post('roadside_reservation'),
            'trace_map_copy'          => 'NA',
            'chitha_copy'             => 'NA',
            'lm_note'                 => $comment,
            'lm_remark_text'          => trim($this->input->post('lm_remark_text')),
            'date_entry'              => date('Y-m-d h:i:s'),
            'case_no'                 => $caseNo,
            'status'                  => 'W',
            'total_bigha'             => $this->input->post('total_bigha'),
            'total_Katha'             => $this->input->post('total_Katha'),
            'total_lessa'             => $this->input->post('total_lessa'),
            'total_ganda'             => $this->input->post('total_ganda'),
            'total_kranti'            => $this->input->post('total_kranti'),
            'landslide'               => $this->input->post('landslide'),
            'erosion'                 => $this->input->post('erosion'),
            'protected_class_lm'      => $protected_class_lm,
            'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
            'lm_rejected_remarks'     => json_encode($responseMasterObj->reject_remarks)
        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
        if ($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0012: Insertion failed in settlement_ap_lmnote Case No '.$caseNo);
            $errors = '#MROFK0012: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }


        // road side reserve area
        if ($roadside_comment_check=='YES')
        {
            foreach ($dags as $dag)
            {
                $reservedarea=array(
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill_code,
                    'dag_no'             => $this->input->post('reserved_dag_road'.$dag->dag_no),
                    'patta_no'           => $this->input->post('reserved_patta_road'.$dag->dag_no),
                    'bigha'              => $this->input->post('reserved_bigha'.$dag->dag_no),
                    'katha'              => $this->input->post('reserved_katha'.$dag->dag_no),
                    'lessa'              => $this->input->post('reserved_lessa'.$dag->dag_no),
                    'ganda'              => $this->input->post('reserved_ganda'.$dag->dag_no),
                    'kranti'             => $this->input->post('reserved_kranti'.$dag->dag_no),
                    'case_no'            => $caseNo,
                    'applid'             => $caseNo,
                    'lm_code'            => $this->session->userdata('user_code'),
                    'date_entry'         => date('Y-m-d h:i:s'),
                    'date_update'        => date('Y-m-d h:i:s'),
                    'type'               => 'R'
                );

                $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                if ($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFK0013: Insertion failed in settlement_reservation Case No '.$caseNo);
                    $errors = '#MROFK0013: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                }
            }
        }

        // family reserve area
        if ($family_comment_check=='YES')
        {
            foreach ($dags as $dag)
            {
                $reservedarea=array(
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill_code,
                    'dag_no'             => $this->input->post('reserved_dag_family'.$dag->dag_no),
                    'patta_no'           => $this->input->post('reserved_patta_family'.$dag->dag_no),
                    'bigha'              => $this->input->post('reserved_bigha_family'.$dag->dag_no),
                    'katha'              => $this->input->post('reserved_katha_family'.$dag->dag_no),
                    'lessa'              => $this->input->post('reserved_lessa_family'.$dag->dag_no),
                    'ganda'              => $this->input->post('reserved_ganda_family'.$dag->dag_no),
                    'kranti'             => $this->input->post('reserved_kranti_family'.$dag->dag_no),
                    'case_no'            => $caseNo,
                    'applid'             => $caseNo,
                    'lm_code'            => $this->session->userdata('user_code'),
                    'date_entry'         => date('Y-m-d h:i:s'),
                    'date_update'        => date('Y-m-d h:i:s'),
                    'type'               => 'F'
                );

                $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                if ($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFK0014: Insertion failed in settlement_reservation Case No '.$caseNo);
                    $errors = '#MROFK0014: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                }
            }
        }


        // application details
        $basic = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);


        // premium insert
        $sumMbAmount = 0;
        $approved_by = '';
        $count       = 0;
        foreach ($dags as $dag_premium)
        {
            $count++;
            if($count >1)
            {
                if ($approved_by != $this->input->post('approval'.$dag_premium->dag_no))
                {
                    $this->db->trans_rollback();
                    $errors = '#MROFK0015: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
                }

            }

            // premium verify start ******************
            if (in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $area_in_bigha=6400;
            }
            else
            {
                $area_in_bigha=100;
            }
            $concession_rate = 25;
            $ratetype        = $this->input->post('rate_type'.$dag_premium->dag_no);
            $ratepr2         = $this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
            $ratepr          = $ratepr2->rate_type;
            $is_full_pay     = $this->input->post('paymode');
            $prem_zonal      = $this->offlineutility->getZonalValue($dag_premium->dist_code,$basic->uuid,$dag_premium->dag_no);
            $prem_area       = $this->input->post('total_lessa'.$dag_premium->dag_no);
            $prem_rate       = $this->input->post('rate'.$dag_premium->dag_no);
            $prem_concession = $this->input->post('concession'.$dag_premium->dag_no);
            $mb_land         = $this->input->post('mb_land'.$dag_premium->dag_no);

            if (in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                if($mb_land == 25)
                {
                    $mb_land = 1600;
                }
                else if ($mb_land == 30)
                {
                    $mb_land = 1920;
                }
                else if ($mb_land == 40)
                {
                    $mb_land = 2560;
                }
            }
            if ($prem_concession=="YES")
            {
                if($ratepr =='P')
                {
                    if($prem_area>$mb_land)
                    {
                        $premium     = $mb_land * $prem_zonal / $area_in_bigha;
                        $discount    = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount1     = ceil($premium * $discount / 100);
                        $access_area = $prem_area - $mb_land;
                        $premium2    = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                        $amount2     = ceil($premium2 * $discount / 100);
                        $finalamount = ceil($amount1 + $amount2);
                    }
                    else
                    {
                        $premium     = $prem_area * $prem_zonal / $area_in_bigha;
                        $discount    = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount      = ($premium * $discount / 100);
                        $finalamount = ceil($amount);
                    }

                }
                else if($ratepr =='R')
                {
                    $premium     = $prem_area * $prem_rate / $area_in_bigha;
                    $discount    = $prem_rate - $concession_rate;
                    $amount      = ($premium * $discount / 100);
                    $finalamount = ceil($amount);
                }
            }
            else if($prem_concession=="NO")
            {
                if($ratepr =='P')
                {
                    if($prem_area>$mb_land)
                    {
                        $premium     = $mb_land * $prem_zonal / $area_in_bigha;
                        $amount1     = ceil($premium * $prem_rate / 100);
                        $access_area = $prem_area - $mb_land;
                        $premium2    = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2     = ceil($premium2 * $prem_rate / 100);
                        $finalamount = ceil($amount1 + $amount2);

                    }
                    else
                    {
                        $premium     = $prem_area * $prem_zonal / $area_in_bigha;
                        $amount      = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                }
                else if($ratepr =='R')
                {
                    $premium     = $prem_area * $prem_rate / $area_in_bigha;
                    $amount      = ($premium * $prem_rate / 100);
                    $finalamount = ceil($amount);
                }
            }

            $sumMbAmount += $finalamount;

            // premium verify end ******************

            $fmd=array(
                'case_no'         => $caseNo,
                'user_code'       => $this->session->userdata('user_code'),
                'uuid'            => $basic->uuid,
                'dag_no'          => $dag_premium->dag_no,
                'zonal_valuation' => $this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                'area_name'       => $this->input->post('area_new'.$dag_premium->dag_no),
                'land_type'       => $this->input->post('land_type'.$dag_premium->dag_no),
                'rate_type'       => $this->input->post('rate_type'.$dag_premium->dag_no),
                'rate'            => $this->input->post('rate'.$dag_premium->dag_no),
                'concession'      => $this->input->post('concession'.$dag_premium->dag_no),
                'amount_dag'      => $this->input->post('amount'.$dag_premium->dag_no),
                'final_amount'    => $this->input->post('finalamount'),
                'due_amount'      => $this->input->post('totaldue'),
                'total_lessa'     => $this->input->post('total_lessa'.$dag_premium->dag_no),
                'is_full_pay'     => $this->input->post('paymode'),
                'is_final'        => 1,
                'date_entry'      => date('Y-m-d h:i:s'),
                'approve_by'      => $this->input->post('approval'.$dag_premium->dag_no),
            );

            $insPremium = $this->db->insert('settlement_premium', $fmd);
            if ($insPremium != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK0016: Insertion failed in settlement_premium Case No '.$caseNo);
                $errors = '#MROFK0016: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
            }
            $approved_by = $this->input->post('approval'.$dag_premium->dag_no);
        }

        // premium verify 2 start ******************
        if($sumMbAmount != $this->input->post('finalamount'))
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0017: LM premium Mismatch Case No '.$caseNo);
            $errors = '#MROFK0017: Premium Amount Mismatch. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }
        if ($is_full_pay=="NO")
        {
            $discount = 30;
            $finaldue = ($sumMbAmount * $discount / 100);
            $finaldueamount = ceil($finaldue);
        }
        else if ($is_full_pay=="YES")
        {
            $finaldueamount= $sumMbAmount;
        }

        if($finaldueamount != $this->input->post('totaldue'))
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0018: LM premium Mismatch Case No '.$caseNo);
            $errors = '#MROFK0018: Premium Amount Mismatch. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }


        // proceeding
        $proceeding_id = $this->OfflineCommonModel->getOfflineProceedingId($caseNo);

        $insPetProceed = [
            'case_no'              => $caseNo,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $this->input->post('lm_remark_text'),
            'status'               => 'W',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->offlineutility->get_client_ip(),
            'office_from'          => MB_LOT_MONDOL,
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0019: Insertion failed in settlement_proceeding Case No '.$caseNo);
            $errors = '#MROFK0019: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }

        if ($this->db->trans_status()==false)
        {
            $this->db->trans_rollback();
            $errors = '#MROFK0020: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }
        else
        {
            $this->db->trans_commit();
            $errors = ' Report Successfully Submitted & Application Forwarded to CO';
            $this->session->set_flashdata('success', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getPendingApplicationListLM');
        }

    }


    // view all reverted application for LM
    public function getRevertedApplicationListLM()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subDiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no      = trim($this->session->userdata('lot_no'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $revertedApplication = $this->OfflineCommonModel->getRevertedOfflineApplicationList($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode);

        $data['applicationCount'] = $revertedApplication->num_rows();
        $data['applications']     = $revertedApplication->result();

        $data['_view'] = 'OfflineSettlement/Lm/reverted_offline_application_list_lm';
        $this->load->view('layouts/main', $data);

    }



    // get reverted application
    public function getKhasRevertedApplicationDetailsLM()
    {
        $caseNoEn  = $this->input->get('app');
        $caseNo    = $this->offlineutility->decryptJwtCase($caseNoEn);
        $dist_code = trim($this->session->userdata('dist_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $this->OfflineCommonModel->checkUserPendingWithByCaseNo($caseNo);

        // check application
        if($this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$caseNo) != 1)
        {
            $errors = '#MROFN02: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getRevertedApplicationListLM');
        }

        // application details
        $application = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);

        $serviceCode = $application->service_code;
        if(!in_array($serviceCode, OFFLINE_SERVICE_CODE_ALLOW))
        {
            $errors = '#MROFK0002: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');
        }

        // applicant details
        $applicants = $this->OfflineCommonModel->getApplicantOfflineApplication($dist_code,$caseNo);

        // get applicants as owners
        $applicants_owners = $this->OfflineCommonModel->getAllApplicantOwners($caseNo);

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

        // LM Note
        $lmNotes = $this->OfflineCommonModel->getNcLmNote($caseNo);

        // get all circle officer
        $allCircle = $this->OfflineCommonModel->getCoName($dist_code, $application->subdiv_code,$application->cir_code);

        // premium details
        $premium = $this->OfflineCommonModel->getOfflineAppPremium($caseNo);

        // checking premium
        $sqlToCheckPremium = $this->OfflineCommonModel->checkOfflineAppPremium($caseNo);
        if($sqlToCheckPremium->num_rows() <= 0)
        {
            $data['premium_not_calculated'] = 1;
        }
        else
        {
            $data['premium_not_calculated'] = 0;
        }

        // get calcluted premium
        $premiumData = $this->OfflineCommonModel->getOfflineAppCalPremium($caseNo);


        // application proceeding
        $proceedings = $this->OfflineCommonModel->getOfflineApplicationProceeding($caseNo);

        // get Reservation Area
        $reservation = $this->OfflineCommonModel->getOfflineSettlementReservation($caseNo);


        $rejected_data = $this->OfflineCommonModel->getRejectModal($serviceCode);
        if($rejected_data == 'n')
        {
            $data['rejected_list'] = false;
        }
        else
        {
            $data['rejected_list'] = $rejected_data;
        }
        $data['co_name_reject'] = $this->OfflineCommonModel->getCoName($dist_code, $application->subdiv_code,$application->cir_code);
        if($data['rejected_list'] != false)
        {
            $data['dagFlagCheckChitha'] = $this->OfflineCommonModel->getChithaFlaggedRemarks($dags, $data['rejected_list']);
        }
        else
        {
            $data['dagFlagCheckChitha'] = false;
        }

        $additional_property =$this->UtilsModel->getAdditionalPropertyByCase($caseNo);
        if($additional_property->num_rows() > 0)
        {
            $totallesaa=0;
            $totalganda=0;
            foreach($additional_property->result() as $addprop)
            {
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY)))
                {
                    $total_g=$this->offlineutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }
                else
                {
                    $total_l=$this->offlineutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }
            }
            if(!empty($totallesaa))
            {
                $data['total_aditional_area']= $this->offlineutility->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda))
            {
                $data['total_aditional_area_g']= $this->offlineutility->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $data['additional_property']=$additional_property->result();

        }

        $display_old_nature_revert = 0;
        foreach ($dags as $dag_nature_check)
        {
            if (!is_null($dag_nature_check->nature_possession))
            {
                $display_old_nature_revert = 1;
            }
            else
            {
                $display_old_nature_revert = 0;
            }
        }


        $data['reservation']  = $reservation;
        $data['geo_date']     = date('Y-m-d');
        $data['district_all'] = $this->UtilsModel->getAllDistrictList();
        $data['co_name']      = $allCircle;
        $data['dist_code']    = $dist_code;
        $data['guar_rel']     = $relations;
        $data['case_no']      = $caseNo;
        $data['basic']        = $application;
        $data['applicants']   = $applicants;
        $data['dags']         = $dags;
        $data['dag_count']    = count($dags);
        $data['nominee']      = $nominee;
        $data['deleted_dags'] = $deletedData;
        $data['documents']    = $documents;
        $data['documentsLm']  = $documentsLm;
        $data['lmnotes']      = $lmNotes;
        $data['premium_data'] = $premium;
        $data['premium']      = $premium;
        $data['premiumData']  = $premiumData;
        $data['proceedings']  = $proceedings;
        $data['applicants_buyers']               = $applicants;
        $data['applicants_encroacher']           = $applicants_encroacher;
        $data['applicants_owners']               = $applicants_owners;
        $data['deleted_encroacher']              = $deletedEnc;
        $data['land_bank_status']                = $land_bank_status;
        $data['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
        $data['settlement_land_bank_details']    = $settlement_land_bank_details;
        $data['display_old_nature_revert']       = $display_old_nature_revert;

        $data['_view'] = 'OfflineSettlement/Lm/offline_reverted_application_details_lm';
        $this->load->view('layouts/main', $data);

    }



    // re-report for reverted application
    public function reReportOfRevertedOfflineSettlementLm()
    {
        $distCode       = trim($this->session->userdata('dist_code'));
        $caseNo         = trim($this->input->post('case_no'));
        $application_no = $this->offlineutility->encryptJwtcase($caseNo);
        if($caseNo == '' or $caseNo == NULL)
        {
            $errors = 'There is some problem ! please try again';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getRevertedApplicationListLM');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mouza_code', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill_code', 'Village', 'trim|required');
        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('case_no', 'Case No', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
        $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
        $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');
        $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('is_landless', 'Whether application is landless', 'trim|required');
        $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
        $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
        $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
        $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
        $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');

        $is_prem_update = trim($this->input->post('prem_update'));
        if($is_prem_update == 'YES')
        {
            $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
            $this->form_validation->set_rules('finalamount', 'Premium Amount', 'trim|required');
        }

        $roadside_comment_check           = trim($this->input->post('roadside_comment_check'));
        $family_comment_check             = trim($this->input->post('family_comment_check'));
        $totalDagAreaLessaValidation      = 0;
        $totalAgrAreaLessaValidation      = 0;
        $totalHomeAreaLessaValidation     = 0;
        $appAreaMoreThanDagA              = 0;
        $reserveMoreThanAppArea           = 0;
        $familyMoreThanAppArea            = 0;
        $totalRoadSideAreaLessaValidation = 0;
        $totalFamilyAreaLessaValidation   = 0;

        //  LM remarks validation
        $lm_note = trim($this->input->post('lm_note'));
        if($lm_note == 2)
        {
            $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');
            if(isset($_POST['rejected_reasons']))
            {
                foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                {
                    $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                }
            }
            if(isset($_POST['sub_rejected_reasons']))
            {
                foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                {
                    $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                }
            }
            $this->form_validation->set_rules('co_code_reject', 'Select Circle Officer', 'trim|required');
        }


        // dag details
        $dags = $this->OfflineCommonModel->getOfflineSettlementDagDetails($distCode,$caseNo);
        $applicants_encroacher = $this->OfflineCommonModel->getAllApplicantEncroacher($caseNo);

        // check premium details
        $countPremium = $this->OfflineCommonModel->checkOfflineAppPremium($caseNo)->num_rows();


        // area validation
        foreach ($dags as $dag_area_cal)
        {
            if (in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                {
                    $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                }

                $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');

                $bighaValidation     = $dag_area_cal->dag_area_b;
                $kathaValidation     = $dag_area_cal->dag_area_k;
                $lessaValidation     = $dag_area_cal->dag_area_lc;
                $gandaValidation     = $dag_area_cal->dag_area_g;
                $bighaValidationHome = $dag_area_cal->home_b;
                $kathaValidationHome = $dag_area_cal->home_k;
                $lessaValidationHome = $dag_area_cal->home_lc;
                $gandaValidationHome = $dag_area_cal->home_g;
                $bighaValidationAgr  = $dag_area_cal->agri_b;
                $kathaValidationAgr  = $dag_area_cal->agri_k;
                $lessaValidationAgr  = $dag_area_cal->agri_lc;
                $gandaValidationAgr  = $dag_area_cal->agri_g;

                $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation )
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                if ($roadside_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda'.$dag_area_cal->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti'.$dag_area_cal->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                    $kathaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                    $lessaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                    $gandaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }
                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
                if ($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda_family'.$dag_area_cal->dag_no, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti_family'.$dag_area_cal->dag_no, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                    $kathaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                    $lessaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
                    $gandaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }

                // new premium addition
                if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                {
                    $maxland_check = $this->OfflineCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                    if(!empty($maxland_check->max_land))
                    {
                        if($maxland_check->max_land =='40')
                        {
                            $maxland_ganda = 2560;
                        }
                        elseif($maxland_check->max_land =='60')
                        {
                            $maxland_ganda = 3840;
                        }
                        if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }

                if(OFFLINE_KHAS_MAX_HOMESTEAD * 6400 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 6400 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }

            }
            else
            {

                $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');

                $bighaValidation     = $dag_area_cal->dag_area_b;
                $kathaValidation     = $dag_area_cal->dag_area_k;
                $lessaValidation     = $dag_area_cal->dag_area_lc;
                $bighaValidationHome = $dag_area_cal->home_b;
                $kathaValidationHome = $dag_area_cal->home_k;
                $lessaValidationHome = $dag_area_cal->home_lc;
                $bighaValidationAgr  = $dag_area_cal->agri_b;
                $kathaValidationAgr  = $dag_area_cal->agri_k;
                $lessaValidationAgr  = $dag_area_cal->agri_lc;

                $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation )
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                if ($roadside_comment_check=='YES') {
                    $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                    $kathaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                    $lessaValidationRoadside = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }

                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
                if ($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                    $kathaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                    $lessaValidationFamily = $this->OfflineCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                    if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }

                // new premium addition
                if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                {
                    $maxland_check = $this->OfflineCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                    if(!empty($maxland_check->max_land))
                    {
                        if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }
                else
                {
                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                }

                if (OFFLINE_KHAS_MAX_HOMESTEAD * 100 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 100 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }

            $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of possession', 'trim|required|xss_clean');

            if($is_prem_update == 'YES')
            {
                $this->form_validation->set_rules('approval'.$dag_area_cal->dag_no, 'Approve by office', 'trim|required|xss_clean');

                $dag_array[]    = $this->input->post('approval'.$dag_area_cal->dag_no);
                $dag_by_approve = $this->input->post('approval'.$dag_area_cal->dag_no);
            }
        }


        foreach ($applicants_encroacher as $enc_applicant)
        {
            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, 'Encroacher exist in VLB', 'trim|required|is_natural');
        }
        if ($reserveMoreThanAppArea == 1)
        {
            $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
        }
        if ($familyMoreThanAppArea == 1)
        {
            $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');
        }
        if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0)
        {
            $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
        }
        if ($appAreaMoreThanDagA == 1)
        {
            $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
        }


        // additional file upload validation
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size

            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];

                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
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
                            $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
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
        }


        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
        }

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $this->OfflineCommonModel->checkUserPendingWithByCaseNo($caseNo);

        if($is_prem_update == 'NO' AND $countPremium == 0)
        {
            $errors = '#MROFRP000: You have to re-calculate the premium';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
        }


        $dist_code              = trim($this->input->post('dist_code'));
        $subdiv_code            = trim($this->input->post('subdiv_code'));
        $cir_code               = trim($this->input->post('cir_code'));
        $mouza_code             = trim($this->input->post('mouza_code'));
        $lot_no                 = trim($this->input->post('lot_no'));
        $vill_code              = trim($this->input->post('vill_code'));
        $roadside_comment_check = trim($this->input->post('roadside_comment_check'));
        $family_comment_check   = trim($this->input->post('family_comment_check'));
        $co_code                = $this->input->post('co_code');
        $serviceCode            = OFFLINE_KHAS_LAND_ID;


        // application details
        $basic = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);

        $this->db->trans_begin();

        foreach ($applicants_encroacher as $enc_applicant)
        {
            $applicant_array = [
                'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'.$enc_applicant->id)
            ];

            $this->db->where('id', $enc_applicant->id);
            $this->db->where('case_no', $caseNo);
            $this->db->update('settlement_applicant', $applicant_array);
            if($this->db->affected_rows() <= 0)
            {

                $this->db->trans_rollback();
                log_message('error', '#MROFR0001: Updating failed in settlement_applicant Case No '.$caseNo);
                $errors = '#MROFR0001: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
        }

        $approved_by =null;
        if($is_prem_update == 'YES')
        {
            if ($dag_by_approve !='' || $dag_by_approve !=null )
            {
                if(count($dag_array)==1)
                {
                    $approved_by =$dag_by_approve;
                }
                else
                {
                    if(count(array_unique($dag_array))<count($dag_array))
                    {
                        $approved_by = $dag_by_approve;
                    }
                    else
                    {
                        $approved_by = 'GOVT';
                    }
                }
            }
        }


        // update basic data
        if($is_prem_update == 'YES')
        {
            $basicData = [
                'status'          => 'X',
                'lm_code'         => $this->session->userdata('user_code'),
                'from_office'     => MB_LOT_MONDOL,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'sk_code'         => $co_code,
                'co_code'         => $co_code,
                'approve_by'      => $approved_by
            ];
        }
        else
        {
            $basicData = [
                'status'          => 'X',
                'lm_code'         => $this->session->userdata('user_code'),
                'from_office'     => MB_LOT_MONDOL,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'sk_code'         => $co_code,
                'co_code'         => $co_code,
            ];
        }
        $this->db->where('case_no', $caseNo);
        $this->db->update('settlement_basic', $basicData);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFR0002: Updating failed in settlement_basic Case No '.$caseNo);
            $errors = '#MROFR0002: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
        }


        // insertion in backup table
        $phase_count         = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = '$caseNo' AND from_office = 'LM'")->row()->ct;
        $phase_count         = (int)$phase_count+1;
        $backup_array_lm     = [
            'applid'      => $caseNo,
            'case_no'     => $caseNo,
            'from_office' => MB_LOT_MONDOL,
            'to_office'   => MB_CIRCLE_OFFICER,
            'status'      => 'X',
            'phase'       => 'LM_'.$phase_count,
            'data'        => json_encode($_POST)
        ];
        $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
        if($backup_insertion_lm != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#BACKUPF003: Insertion failed in settlement_backup_json  Case No '.$caseNo);
            $errors = '#BACKUPF003: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
        }


        // update dag details
        foreach ($dags as $dagsland)
        {
            $landmark_east  = trim($this->input->post('landmark_east'.$dagsland->dag_no));
            $landmark_west  = trim($this->input->post('landmark_west'.$dagsland->dag_no));
            $landmark_north = trim($this->input->post('landmark_north'.$dagsland->dag_no));
            $landmark_south = trim($this->input->post('landmark_south'.$dagsland->dag_no));
            $landmark = [
                'east'  => $landmark_east,
                'west'  => $landmark_west,
                'north' => $landmark_north,
                'south' => $landmark_south,
            ];

            $fmddata= [
                'date_update' => date('Y-m-d'),
                'landmark'    => json_encode($landmark),
                'nature_possession' => $this->input->post('nature_possession'.$dagsland->dag_no),
            ];
            $this->db->where('case_no', $caseNo);
            $this->db->where('dag_no', $dagsland->dag_no);
            $this->db->update('settlement_dag_details', $fmddata);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFR0004: Updating failed in settlement_dag_details  Case No '.$caseNo);
                $errors = '#MROFR0004: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
        }


        // upload additional file
        if(isset($_FILES['fileUpload']['name']))
        {
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name']     = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type']     = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size']     = $_FILES['fileUpload']['size'][$i];

                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']      = UPLOAD_MAX_SIZE;;
                $config['file_name']     = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'         => $caseNo,
                        'file_name'       => $_POST['fileText'][$i],
                        'user_code'       => $this->session->userdata('user_code'),
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'       => $_FILES['file']['type'],
                        'file_path'       => UPLOAD_DIR . $fileRename,
                        'date_entry'      => date('Y-m-d h:i:s'),
                        'mut_type'        => $serviceCode,
                    );

                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MROFR0005: Insertion failed in supportive_document  Case No '.$caseNo);
                        $errors = '#MROFR0005: There is some problem. Kindly contact system administrator';
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFR0006: Insertion failed in supportive_document  Case No '.$caseNo);
                    $errors = '#MROFR0006: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                }
            }
        }


        // if LM if case of case rejected the rejected remarks
        $responseMasterObj  = $this->OfflineCommonModel->lmRejectedValidationBypassFalse($serviceCode);
        $comment            = addslashes($this->input->post('lm_note'));
        $pro_class_lm       = $this->input->post('protected_class_lm');
        $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

        $lmnote = array(
            'user_code'               => $this->session->userdata('user_code'),
            'vlb_verified'            => $this->input->post('vlb_verified'),
            'is_tribal_belt'          => $this->input->post('is_tribal_belt'),
            'possession_verification' => $this->input->post('possession_verification'),
            'period_possession'       => date('Y-m-d'),
            'is_landless'             => $this->input->post('is_landless'),
            'land_falls'              => $this->input->post('land_falls'),
            'falls_und_gmc'           => $this->input->post('falls_und_gmc'),
            'roadside_reservation'    => $this->input->post('roadside_reservation'),
            'trace_map_copy'          => 'NA',
            'chitha_copy'             => 'NA',
            'lm_note'                 => $comment,
            'lm_remark_text'          => trim($this->input->post('lm_remark_text')),
            'date_entry'              => date('Y-m-d h:i:s'),
            'case_no'                 => $caseNo,
            'status'                  => 'W',
            'total_bigha'             => $this->input->post('total_bigha'),
            'total_Katha'             => $this->input->post('total_Katha'),
            'total_lessa'             => $this->input->post('total_lessa'),
            'total_ganda'             => $this->input->post('total_ganda'),
            'total_kranti'            => $this->input->post('total_kranti'),
            'landslide'               => $this->input->post('landslide'),
            'erosion'                 => $this->input->post('erosion'),
            'protected_class_lm'      => $protected_class_lm,
            'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
            'lm_rejected_remarks'     => json_encode($responseMasterObj->reject_remarks)
        );
        $this->db->where('case_no', $caseNo);
        $this->db->update('settlement_ap_lmnote', $lmnote);
        if ($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFR0007: Updating failed in settlement_ap_lmnote Case No '.$caseNo);
            $errors = '#MROFR0007: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
        }


        // road side reserve area
        $reservation = $this->OfflineCommonModel->getSettlementReservation($caseNo);
        if($reservation == true)
        {
            if ($roadside_comment_check=='YES')
            {
                foreach ($reservation as $reservation_road)
                {
                    if($reservation_road->type == 'R')
                    {
                        $reservedarea_road = array(
                            'bigha'       => $this->input->post('reserved_bigha' . $reservation_road->dag_no),
                            'katha'       => $this->input->post('reserved_katha' . $reservation_road->dag_no),
                            'lessa'       => $this->input->post('reserved_lessa' . $reservation_road->dag_no),
                            'ganda'       => $this->input->post('reserved_ganda' . $reservation_road->dag_no),
                            'kranti'      => $this->input->post('reserved_kranti' . $reservation_road->dag_no),
                            'lm_code'     => $this->session->userdata('user_code'),
                            'date_update' => date('Y-m-d h:i:s'),
                        );
                        $this->db->where('case_no', $caseNo);
                        $this->db->where('type', 'R');
                        $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                        $this->db->update('settlement_reservation', $reservedarea_road);
                        if ($this->db->affected_rows() == 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MROFR0008: Updating failed in settlement_reservation Case No '.$caseNo);
                            $errors = '#MROFR0008: There is some problem. Kindly contact system administrator';
                            $this->session->set_flashdata('error', $errors);
                            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                        }
                    }
                }
            }
            if ($roadside_comment_check=='NO')
            {
                $resUpdate = "UPDATE settlement_reservation SET is_deleted = 1  WHERE case_no = '$caseNo' AND type = 'R'";
                $this->db->query($resUpdate);
                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFR0009: Updating failed in settlement_reservation Case No '.$caseNo);
                    $errors = '#MROFR0009: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                }
            }
        }
        else
        {
            if ($roadside_comment_check=='YES')
            {
                foreach ($dags as $dag)
                {
                    $reservedarea = array(
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'             => $lot_no,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $this->input->post('reserved_dag_road'.$dag->dag_no),
                        'patta_no'           => $this->input->post('reserved_patta_road'.$dag->dag_no),
                        'bigha'              => $this->input->post('reserved_bigha'.$dag->dag_no),
                        'katha'              => $this->input->post('reserved_katha'.$dag->dag_no),
                        'lessa'              => $this->input->post('reserved_lessa'.$dag->dag_no),
                        'ganda'              => $this->input->post('reserved_ganda'.$dag->dag_no),
                        'kranti'             => $this->input->post('reserved_kranti'.$dag->dag_no),
                        'case_no'            => $caseNo,
                        'applid'             => $caseNo,
                        'lm_code'            => $this->session->userdata('user_code'),
                        'date_entry'         => date('Y-m-d h:i:s'),
                        'date_update'        => date('Y-m-d h:i:s'),
                        'type'               => 'R'
                    );

                    $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                    if ($reserveData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MROFR0010: Insertion failed in settlement_reservation Case No '.$caseNo);
                        $errors = '#MROFR0010: There is some problem. Kindly contact system administrator';
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                    }
                }
            }
        }


        if($is_prem_update == 'YES')
        {
            $sqlprem = "update settlement_premium set is_final = 0  WHERE case_no = '$caseNo'";
            $resultprem = $this->db->query($sqlprem);
            if ($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFR0011: Updating failed in settlement_premium Case No '.$caseNo);
                $errors = '#MROFR0011: There is some problem. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);

            }

            // premium insert
            $sumMbAmount = 0;
            $approved_by = '';
            $count       = 0;
            foreach ($dags as $dag_premium)
            {
                $count++;
                if($count >1)
                {
                    if ($approved_by != $this->input->post('approval'.$dag_premium->dag_no))
                    {
                        $this->db->trans_rollback();
                        $errors = '#MROFR0012: There is some problem. Kindly contact system administrator';
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                    }
                }

                // premium verify start ******************
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $area_in_bigha = 6400;
                }
                else
                {
                    $area_in_bigha = 100;
                }
                $concession_rate = 25;
                $ratetype        = $this->input->post('rate_type'.$dag_premium->dag_no);
                $ratepr2         = $this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                $ratepr          = $ratepr2->rate_type;
                $is_full_pay     = $this->input->post('paymode');
                $prem_zonal      = $this->offlineutility->getZonalValue($dag_premium->dist_code,$basic->uuid,$dag_premium->dag_no);
                $prem_area       = $this->input->post('total_lessa'.$dag_premium->dag_no);
                $prem_rate       = $this->input->post('rate'.$dag_premium->dag_no);
                $prem_concession = $this->input->post('concession'.$dag_premium->dag_no);
                $mb_land         = $this->input->post('mb_land'.$dag_premium->dag_no);

                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($mb_land == 25)
                    {
                        $mb_land = 1600;
                    }
                    else if ($mb_land == 30)
                    {
                        $mb_land = 1920;
                    }
                    else if ($mb_land == 40)
                    {
                        $mb_land = 2560;
                    }
                }
                if ($prem_concession=="YES")
                {
                    if($ratepr =='P')
                    {
                        if($prem_area>$mb_land)
                        {
                            $premium     = $mb_land * $prem_zonal / $area_in_bigha;
                            $discount    = $prem_rate-($prem_rate * $concession_rate / 100);
                            $amount1     = ceil($premium * $discount / 100);
                            $access_area = $prem_area - $mb_land;
                            $premium2    = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                            $amount2     = ceil($premium2 * $discount / 100);
                            $finalamount = ceil($amount1 + $amount2);
                        }
                        else
                        {
                            $premium     = $prem_area * $prem_zonal / $area_in_bigha;
                            $discount    = $prem_rate-($prem_rate * $concession_rate / 100);
                            $amount      = ($premium * $discount / 100);
                            $finalamount = ceil($amount);
                        }
                    }
                    else if($ratepr =='R')
                    {
                        $premium     = $prem_area * $prem_rate / $area_in_bigha;
                        $discount    = $prem_rate - $concession_rate;
                        $amount      = ($premium * $discount / 100);
                        $finalamount = ceil($amount);
                    }
                }
                else if($prem_concession=="NO")
                {
                    if($ratepr =='P')
                    {
                        if($prem_area>$mb_land)
                        {
                            $premium     = $mb_land * $prem_zonal / $area_in_bigha;
                            $amount1     = ceil($premium * $prem_rate / 100);
                            $access_area = $prem_area - $mb_land;
                            $premium2    = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                            $amount2     = ceil($premium2 * $prem_rate / 100);
                            $finalamount = ceil($amount1 + $amount2);

                        }
                        else
                        {
                            $premium     = $prem_area * $prem_zonal / $area_in_bigha;
                            $amount      = ($premium * $prem_rate / 100);
                            $finalamount = ceil($amount);
                        }
                    }
                    else if($ratepr =='R')
                    {
                        $premium     = $prem_area * $prem_rate / $area_in_bigha;
                        $amount      = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                }

                $sumMbAmount += $finalamount;

                // premium verify end ******************

                $fmd=array(
                    'case_no'         => $caseNo,
                    'user_code'       => $this->session->userdata('user_code'),
                    'uuid'            => $basic->uuid,
                    'dag_no'          => $dag_premium->dag_no,
                    'zonal_valuation' => $this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                    'area_name'       => $this->input->post('area_new'.$dag_premium->dag_no),
                    'land_type'       => $this->input->post('land_type'.$dag_premium->dag_no),
                    'rate_type'       => $this->input->post('rate_type'.$dag_premium->dag_no),
                    'rate'            => $this->input->post('rate'.$dag_premium->dag_no),
                    'concession'      => $this->input->post('concession'.$dag_premium->dag_no),
                    'amount_dag'      => $this->input->post('amount'.$dag_premium->dag_no),
                    'final_amount'    => $this->input->post('finalamount'),
                    'due_amount'      => $this->input->post('totaldue'),
                    'total_lessa'     => $this->input->post('total_lessa'.$dag_premium->dag_no),
                    'is_full_pay'     => $this->input->post('paymode'),
                    'is_final'        => 1,
                    'date_entry'      => date('Y-m-d h:i:s'),
                    'approve_by'      => $this->input->post('approval'.$dag_premium->dag_no),
                );

                $insPremium = $this->db->insert('settlement_premium', $fmd);
                if ($insPremium != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFR0013: Insertion failed in settlement_premium Case No '.$caseNo);
                    $errors = '#MROFR0013: There is some problem. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
                }
                $approved_by = $this->input->post('approval'.$dag_premium->dag_no);
            }

            // premium verify 2 start ******************
            if($sumMbAmount != $this->input->post('finalamount'))
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFR0014: LM premium Mismatch Case No '.$caseNo);
                $errors = '#MROFR0014: Premium Amount Mismatch. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
            if ($is_full_pay=="NO")
            {
                $discount = 30;
                $finaldue = ($sumMbAmount * $discount / 100);
                $finaldueamount = ceil($finaldue);
            }
            else if ($is_full_pay=="YES")
            {
                $finaldueamount = $sumMbAmount;
            }
            else
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFR0015: LM premium Mismatch Case No '.$caseNo);
                $errors = '#MROFR0015: Premium Amount Mismatch. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
            if($finaldueamount != $this->input->post('totaldue'))
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFR0016: LM premium Mismatch Case No '.$caseNo);
                $errors = '#MROFR0016: Premium Amount Mismatch. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
        }
        else
        {
            $prem_settleemt_area   = 0;
            $total_settlement_area = $totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation-$totalRoadSideAreaLessaValidation;
            $prem_s_area = $this->db->query("Select total_lessa from settlement_premium where is_final=1 and case_no='$caseNo'")->result();
            foreach ($prem_s_area as $prem_s)
            {
                $prem_settleemt_area = $prem_settleemt_area + $prem_s->total_lessa;
            }
            if ($total_settlement_area != $prem_settleemt_area)
            {
                $this->db->trans_rollback();
                $errors = '#MROFR0016: Application not submitted ! Area mismatch case no '.$caseNo;
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasRevertedApplicationDetailsLM/?app='.$application_no);
            }
        }


        // proceeding
        $proceeding_id = $this->OfflineCommonModel->getOfflineProceedingId($caseNo);
        $insPetProceed = [
            'case_no'              => $caseNo,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $this->input->post('lm_remark_text'),
            'status'               => 'X',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->offlineutility->get_client_ip(),
            'office_from'          => MB_LOT_MONDOL,
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'LM updated note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFR0017: Insertion failed in settlement_proceeding Case No '.$caseNo);
            $errors = '#MROFR0017: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }
        if ($this->db->trans_status()==false)
        {
            $this->db->trans_rollback();
            $errors = '#MROFR0018: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getKhasApplicationDetailsLM/?app='.$application_no);
        }
        else
        {
            $this->db->trans_commit();
            $errors = 'Updated Report Successfully Submitted & Application Forwarded to CO';
            $this->session->set_flashdata('success', $errors);
            redirect(base_url() .'index.php/OfflineSettlementLMController/getRevertedApplicationListLM');
        }
    }




}