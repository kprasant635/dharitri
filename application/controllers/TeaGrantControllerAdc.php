<?php

class TeaGrantControllerAdc extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('TeaGrant/ADC/TeaGrantAdcModel');
        $this->load->model('TeaGrant/LM/TeaGrantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('basundhara/basundhara3Model');

        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        // if(HOLD_All_MB2_CASES_STATUS == 1)
        // {
        //     if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
        //     {
        //         $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
        //         redirect(base_url() . "index.php/Home/index");
        //     }
        // }
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
        } else if ($this->session->userdata('dist_code') == "22") {
            $this->db = $this->load->database('dha41', true);
        }

    }

    // 1st landing page Tea Grant ADC
    public function teaGrantAdc()
    {
        $dist_code            = $this->session->userdata('dist_code');
        $user_code            = $this->session->userdata('user_code');
        $user_desig_code      = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->TeaGrantAdcModel->countAllPendingSettlementTeaGrant($dist_code);
        log_message("error", "DIB_FIRST_PRO_1 : ". $this->db->last_query());
        // echo $this->db->last_query(); die;
        $generatedNoticeCount = $this->TeaGrantAdcModel->countAllHearingRemarks($dist_code);
        // log_message("error", "noticeGeneratePaginationAPI_1: ".$this->db->last_query());

        // echo $this->db->last_query(); die;
        $paymentPendingCount  = $this->TeaGrantAdcModel->countAllPaymentPendingByApplicant($dist_code)->num_rows();
        $paymentApprovalPendingCount = $this->TeaGrantAdcModel->countAllPaymentApprovalPendingByApplicant($dist_code);
        $reportFromDept = $this->TeaGrantAdcModel->countAllDeptApprovalCases($dist_code);
        $revertedFromDcDept = $this->TeaGrantAdcModel->countAllDcDeptRevertCases($dist_code);

        $revertedFromDc = $this->TeaGrantAdcModel->countAllDcRevertCases($dist_code);

        $approvedCasesFromDc = $this->TeaGrantAdcModel->getAllApprovedCasesFromDc($dist_code)->num_rows();
        // echo $this->db->last_query(); die;


        $getAllPendingCasesAtAdc = $this->TeaGrantAdcModel->getAllPendingCasesAtAdc($dist_code)->num_rows();
        $alreadyGeneratedPN = $this->TeaGrantAdcModel->getCountAlreadyGeneratedPN($dist_code)->num_rows();
        $rejectedCaseList = $this->TeaGrantAdcModel->getCountRejectedCaseList($dist_code)->num_rows();
        // echo $this->db->last_query(); die;

        $data['dist_code']                   = $dist_code;
        $data['firstProceedingCount']        = $firstProceedingCount;
        $data['generatedNoticeCount']        = $generatedNoticeCount;
        $data['paymentPendingCount']         = $paymentPendingCount;
        $data['paymentApprovalPendingCount'] = $paymentApprovalPendingCount;
        $data['reportFromDept']              = $reportFromDept;
        $data['revertedFromDcDept']          = $revertedFromDcDept;
        $data['revertedFromDc']              = $revertedFromDc;
        $data['approvedCasesFromDc']         = $approvedCasesFromDc;
        $data['getAllPendingCasesAtAdc']     = $getAllPendingCasesAtAdc;
        $data['alreadyGeneratedPN']          = $alreadyGeneratedPN;
        $data['rejectedCaseList']            = $rejectedCaseList;
        $data['_view']                       = 'TeaGrant/ADC/TeaGrantFirstLandingPageAdc';

        $this->load->view('layouts/main', $data);
    }

    // settlement application details KHAS ADC
    public function getSettlementTeaGrantApplicationDetails()
    {
        $case_no        = $this->input->get('case');
        $case_no        = $this->utilityclass->decryptJwtCase($case_no);

        $dist_code      = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $this->checkCaseInModificationRequest($case_no);

        $application_no = $this->input->get('case');
        $application_no = $this->utilityclass->decryptJwtCase($application_no);

        $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);

        $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

        $adcdata           = [];
        $dags              = $this->TeaGrantModel->getSettlementDag($application_no);
        $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
        $proceedings       = $this->TeaGrantModel->getSettlementProceeding($application_no);
        $dhardocuments     = $this->TeaGrantModel->getDocuments($application_no);
        $nominee           = $this->TeaGrantModel->getAllNomineeDetail($application_no);
        $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
        $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($application_no);
        $family_tree       = $this->TeaGrantModel->getAllFamilyTree($application_no);

        $applier           = $this->TeaGrantModel->getApplierDetail($application_no);

        $mutatedApplList   = $this->TeaGrantModel->isApplicantMutated($application_no);
        $listOfChithaOwners= $this->TeaGrantModel->listOfChithaOwners($application_no);
        $mutatedCount      = $this->TeaGrantModel->getMutatedStatusCount($application_no)->num_rows();
        $mutatedStatus     = $this->TeaGrantModel->getMutatedStatusCount($application_no)->result();
        $mutatedStatusNo   = $this->TeaGrantModel->getMutatedStatusWithNo($application_no);
        // echo $this->db->last_query(); die;

        // var_dump($mutatedStatusNo); die;

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
        $data['mutatedApplList']        = $mutatedApplList;
        $data['listOfChithaOwners']     = $listOfChithaOwners;
        $data['mutatedCount']           = $mutatedCount;
        $data['mutatedStatus']          = $mutatedStatus;
        $data['mutatedStatusNo']        = $mutatedStatusNo;

        // $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);



        $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantAdc();
        }
        else
        {
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


            // $checkArea                   = 0;
            // $totalLandArea               = 0;
            // $totalDagAreaLessaValidation = 0;
            // $totalAdditionalProToLessa   = 0;

            //******for Barak valley */
            // if (in_array($dist_code, json_decode(BARAK_VALLEY)))
            // {
            //     foreach ($data['dags'] as $singleDag)
            //     {
            //         $dagAreaLessa = 0;
            //         $dagAreaLessa = $this->utilityclass->Total_ganda(
            //             $singleDag->s_dag_area_b,
            //             $singleDag->s_dag_area_k,
            //             $singleDag->s_dag_area_lc,
            //             $singleDag->s_dag_area_g
            //         );

            //         $totalDagAreaLessaValidation += $dagAreaLessa;
            //     }
            //     foreach ($data['additional_property'] as $singleAdditionalDag)
            //     {
            //         $additionalAreaLessa = 0;
            //         $additionalAreaLessa = $this->utilityclass->Total_ganda(
            //             $singleAdditionalDag->bigha,
            //             $singleAdditionalDag->katha,
            //             $singleAdditionalDag->lessa,
            //             $singleAdditionalDag->ganda

            //         );
            //         $totalAdditionalProToLessa += $additionalAreaLessa;
            //     }

            //     $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
            //     if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
            //     {
            //         $checkArea = 1;
            //     }
            // }
            // else
            // {
            //     foreach ($data['dags'] as $singleDag)
            //     {
            //         $dagAreaLessa = 0;
            //         $dagAreaLessa = $this->utilityclass->Total_Lessa(
            //             $singleDag->s_dag_area_b,
            //             $singleDag->s_dag_area_k,
            //             $singleDag->s_dag_area_lc
            //         );
            //         $totalDagAreaLessaValidation += $dagAreaLessa;
            //     }
            //     foreach ($data['additional_property'] as $singleAdditionalDag)
            //     {
            //         $additionalAreaLessa = 0;
            //         $additionalAreaLessa = $this->utilityclass->Total_Lessa(
            //             $singleAdditionalDag->bigha,
            //             $singleAdditionalDag->katha,
            //             $singleAdditionalDag->lessa
            //         );
            //         $totalAdditionalProToLessa += $additionalAreaLessa;
            //     }

            //     $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
            //     if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
            //     {
            //         $checkArea = 1;
            //     }
            // }

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

            // $data['checkAppliedArea'] = $checkArea;

            // dd($data);
            
            $data['_view'] = 'TeaGrant/ADC/TeaGrantFirstProceedingAdcView';
            $this->load->view('layouts/main', $data);
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
        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $totalAreaInApplication = 0;
        $totalAppliedAreaInApplication = 0;
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
        }

        return $areaCheck;

    }



    // modification request check with redirect
    public function checkCaseInModificationRequest($caseNo)
    {
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

        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->TeaGrantAdcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // get error page
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
            $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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
                    'status'          => MB_FINAL_APPROVED_BY_DC,
                    'pending_office'  => MB_DEPUTY_COMM,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    // 'dc_proceeding'   => 0,
                    'final_status'    => MB_DISMISS,
                );

                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR00571: Insertion failed in settlement_basic for case no :'. $case_no);
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
                    $mmnn = $this->TeaGrantAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_DEPUTY_COMM,
                        'task'        => 'Forwarded to DC for Final Check',
                        'minutes_proposal_id' => $proposal_id
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR00622: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk    = 'Forwarded to DC for Final Check';
                        $status = 'M';
                        $task   = MB_ADD_DEPUTY_COMM;
                        $pen    = null;
                        $case   = $case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI00641: Rejected by SDLAC failed case no # $case_no");
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


    // send all application to SDLAC ADC
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
            $allSelectedMem  = $this->input->post('selectedMem');
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();
            $venue = $this->input->post('venue');

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

                // $arrCount = $this->SettlementCommonModel->checkCasesApprovedBy($allSelectedList);if ($arrCount != 1){}


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
                    $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                        $case_str = $case_str.$err.', ';
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
                    'proposalSequenceNo' => $proposalSequenceNo,
                    'distName'           => $dist_name->locname_eng,
                    'subDivName'         => $subdiv_name->locname_eng,
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


    // Mark as SDLAC ADC
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
            $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
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
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_MARK_AS_SDLAC,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
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
                        log_message('error', '#MR00891: Insertion failed in settlement_proceeding for case no :'. $case_no);
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


    // Remove from mark as SDLAC ADC
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
            $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'status'  => MB_PENDING,
                    'dc_code' => $user_code,
                    'dc_proceeding'   => 0,

                );
                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_PENDING,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
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


    // Approve application by SDLAC ADC
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
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $sql = "SELECT * FROM settlement_proposal_cases WHERE case_no = ?
                        ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;

            $caseCount      = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->TeaGrantAdcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
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

                $updateData = array(
                    'status'          => MB_FINAL_APPROVED_BY_DC,
                    'pending_office'  => MB_DEPUTY_COMM,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'sdlac_approval'  => 'Y',
                    'sdlac_date'      => date('Y-m-d H:i:s'),
                    'dc_proceeding'   => 1,
                    'final_status'    => MB_APPROVED_BY_SDLAC,
                    'sdlace_proposal_no' => $proposal_no_int,
                );

                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'approved_by_dc' => 0,
                    );

                    $this->TeaGrantAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_DEPUTY_COMM,
                        'task'        => 'Forwarded to DC for Final Check',
                        'minutes_proposal_id' => $proposal_id
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR001136: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        //////////////POST To basundhara////////////////////
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                        $rmk    = 'Forwarded to DC for Final Check';
                        $status = 'M';
                        $task   = MB_ADD_DEPUTY_COMM;
                        $pen    = MB_DEPUTY_COMM;
                        $case   = $case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI001158: Forward to DC failed case no # $case_no");
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
        }
    }


    // view payment received application details
    public function viewPaymentReceivedAppDetailsByDc()
    {
        $case_no   = $this->input->get('case');
        $case_no   = $this->utilityclass->decryptJwtCase($case_no);
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $caseCount = $this->TeaGrantAdcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $caseDetails = $this->TeaGrantAdcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Adc/Khas/payment_received_app_details_khas';
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
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $caseCount = $this->TeaGrantAdcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_approval'     => 'Y',
                    'dc_proceeding'   => 1,

                );
                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR001260: Insertion failed in settlement_basic for case no :'. $case_no);
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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_ORDER_FOR_CHITHA_UPDATE,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Order for Chitha Updating.'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR001295: Insertion failed in settlement_proceeding for case no :'. $case_no);
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
                        $task=MB_ADD_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI001314: Order for chitha update failed case no # $case_no");
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
    public function updateProposalHearingDateTeaGrant()
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

            $allCases      = $this->TeaGrantAdcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposalNo);
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


    // save new notice and pro ADC
    public function updateHearingDateGenerateNoticeTeaGrant()
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

            $proposalDetails = $this->TeaGrantAdcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->TeaGrantAdcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposalNo);
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
                    if($this->TeaGrantAdcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
                            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                            if($proceeding_id==null)
                            {
                                $proceeding_id=1;
                            }

                            $insPetProceed = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'date_of_hearing' => date('Y-m-d H:i:s') ,
                                'next_date_of_hearing' => date("Y-m-d h:i:s", strtotime($hearingDate)),
                                'status' => MB_HEARING_DATE_CHANGED,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d H:i:s'),
                                'operation' => 'E',
                                'note_on_order' => $remarks,
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => MB_ADD_DEPUTY_COMM,
                                'office_to'   => MB_ADD_DEPUTY_COMM,
                                'task' => 'Hearing Date Changed'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                            if($insertProceeding != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MR001508: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                echo json_encode(array(
                                    'responseType' => 1,
                                ));
                                return;
                            }
                            //////proceeding end//////
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
    //********************** START TeaGrant **********************************




    // view all first Proceeding case list KHAS ADC
    public function viewAllTeaGrantFirstProceedingDcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPendingSettlementTeaGrant($dist_code);

        // echo $this->db->last_query();

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcFirstProcList';
        $this->load->view('layouts/main', $data);

    }


    // view all mark as SDLAC KHAS ADC
    public function viewAllMarkAsSDLACListForDCTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getMarkAsSDLACSettlementTeaGrant($dist_code);
        // $getDistrict = $this->SettlementMbDcModel->getLocationName($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
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
        $data['_view']    = 'settlementView/Adc/Khas/mark_as_sdlac_case_dc_khas';
        $this->load->view('layouts/main', $data);

    }


    // get all proposal list for KHAS
    public function getAllProposalListSdlacTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllProposalSendByDcToSdlacTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();


        $data['_view'] = 'settlementView/Adc/Khas/proposal_list_send_to_sdlac_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all SDLAC Under consideration KHAS
    public function getAllUnderConSdlacTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllUnderConSettlementTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/under_consideration_case_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by adc to sdlac for report KHAS
    public function getAllApplicationInReportSendByDcToSdlacTeaGrant()
    {
        $proposal_no = $this->input->get('case');
        $case_no     = $this->utilityclass->decryptJwtCase($case_no);
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposal_no);
        $proposalDetails = $this->TeaGrantAdcModel->getProposalDetailsById($proposal_no,$dist_code);

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

        $data['_view'] = 'settlementView/Adc/Khas/send_to_sdlac_case_dc_khas';
        $this->load->view('layouts/main', $data);

    }

    // generate proposal notice KHAS ADC
    public function generateNoticeSendAllMarkAppToSDLACByDcTeaGrant()
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
                    'file_path'  => $base_64_file_path,
                    'created_by' => MB_ADD_DEPUTY_COMM,
                    'proposal_name' => strtoupper($proposalName)

                );
                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->saveProposalSDLACTeaGrant($dataProSave) == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR002130: Insertion failed in settlement_proposal_list ');
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
                            'created_at'  => date('Y-m-d H:i:s'),
                        ];
                        $ins = $this->db->insert('sdlac_present_member', $memberData);
                        if($ins != 1 || $ins != true ){
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002240: Insertion failed in sdlac_present_member for 
                        proposal no : '.$proposal_id. ' and query is '. $this->db->last_query());
                            $json = [
                                'response' => 1,
                                'message'  => '#ERMR002240: SDLAC/CDLAC Member not added. Kindly contact system administrator',
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

                        if($this->TeaGrantAdcModel->saveProposalCaseListSDLACTeaGrant($saveCaseList) == 0)
                        {
//                            $this->TeaGrantAdcModel->deleteProposalSDLAC($proposalId);

                            log_message('error', '#MR002155: Insertion failed in settlement_proposal_cases for case no :'. $case_no);
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }

                        $updateData = array(
                            'status' => MB_SEND_TO_SDLAC,
                            'pending_office'  => MB_SDLAC,
                            'pending_officer' => MB_ADD_DEPUTY_COMM,
                            'from_office'     => MB_ADD_DEPUTY_COMM,
                            'dc_code'         => $user_code,
                            'dc_proceeding'   => 1,
                        );

                        if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MR002175: Insertion failed in settlement_basic for case no :'. $case_no);
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
                                'date_of_hearing' => date('Y-m-d H:i:s'),
                                'next_date_of_hearing' => date('Y-m-d H:i:s'),
                                'status' => MB_SEND_TO_SDLAC,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d H:i:s'),
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
                                log_message('error', '#MR002211: Insertion failed in settlement_proceeding for case no :'. $case_no);
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


    // get all DC approved list KHAS
    public function getAllApprovedBySDLACListTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllApproveAppBySdlacTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/approve_list_by_sdlac_khas';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application KHAS
    public function viewApprovedAppDetailsTeaGrant()
    {
        $case_no = $this->input->get('case');
        $case_no = $this->utilityclass->decryptJwtCase($case_no);
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $application_no = $this->input->get('case');
        $application_no = $this->utilityclass->decryptJwtCase($application_no);

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

        $adcdata=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $adcdata[] = $encdata;

        }

        // $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        // $data['premium_data'] = $premium_data;

        $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
        $data['premium_data'] = $premium_data;

        $data['premium'] = $premium_data;


        $data['encdata']=$adcdata;
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

        // $adcdata['pattaNo']=$this->utilityclass->getPattaTypeNo($adcdata['basic']["dist_code"],$adcdata['basic']["subdiv_code"],$adcdata['basic']["cir_code"],$adcdata['basic']["mouza_pargona_code"],$adcdata['basic']["lot_no"],$adcdata['basic']["vill_townprt_code"],$adcdata['dags']["dag_no"]);

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

        $caseCount = $this->TeaGrantAdcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantAdc();
        }
        else
        {

            $caseDetails = $this->TeaGrantAdcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            $data['_view'] = 'settlementView/Adc/Khas/settlement_app_details_only_view_khas';
            $this->load->view('layouts/main', $data);
        }
    }


    // get all rejected app by dc KHAS
    public function getAllRejectByDcListTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllRejectAppByDcTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/rejected_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application KHAS
    public function viewRejectedAppDetailsTeaGrant()
    {
        $case_no = $this->input->get('case');
        $case_no = $this->utilityclass->decryptJwtCase($case_no);

        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);

        $application_no = $this->input->get('case');
        $application_no = $this->utilityclass->decryptJwtCase($application_no);

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


        $adcdata=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $adcdata[] = $encdata;

        }

        // $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();

        $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
        $data['premium_data'] = $premium_data;
        $data['premium'] = $premium_data;

        $data['encdata']=$adcdata;
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

        // $adcdata['pattaNo']=$this->utilityclass->getPattaTypeNo($adcdata['basic']["dist_code"],$adcdata['basic']["subdiv_code"],$adcdata['basic']["cir_code"],$adcdata['basic']["mouza_pargona_code"],$adcdata['basic']["lot_no"],$adcdata['basic']["vill_townprt_code"],$adcdata['dags']["dag_no"]);

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

        $caseCount = $this->TeaGrantAdcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantAdc();
        }
        else
        {
            $caseDetails = $this->TeaGrantAdcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);


            $data['_view'] = 'settlementView/Adc/Khas/settlement_app_details_rejected_only_view_khas';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all chitha update application KHAS
    public function getAllOrderChithaUpdateForDcAppTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllOrderChithaUpdateAppTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/order_chitha_update_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC KHAS
    public function getAllReReportAppByCOForDcAppTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getReRevertedByCoApplicationTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/re_revert_by_co_list_khas';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC KHAS
    public function getAllRevertedAppByDeptForDcAppTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getRevertedByDeptApplicationTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/revert_by_dept_list_khas';
        $this->load->view('layouts/main', $data);
    }


    // Application Order for payment generate Dc
    public function applicationPaymentGenerateDcTeaGrant()
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
            $caseCount = $this->TeaGrantAdcModel->caseForDcApprovalTeaGrant($case_no,$dist_code);
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
                    'from_office'     => MB_ADD_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                );

                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR002552: Insertion failed in settlement_basic for case no :'. $case_no);
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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_PAYMENT_REQUEST,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Forwarded To CO For Payment Generate'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR002585: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Forwarded To CO For Payment Generate';
                        $status='M';
                        $task=MB_ADD_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI002604: Order for chitha update failed case no # $case_no");
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


    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOTeaGrant()
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
            $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    log_message('error', '#MR002678: Update failed in settlement_proposal_cases for case no :'. $case_no);
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
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
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
                        log_message('error', '#MR002728: Insertion failed in settlement_proceeding for case no :'. $case_no);
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
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI02749: Reverted to CO failed case no # $case_no");
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
                    log_message('error', '#MR002785: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }

                $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if($deleteProCase != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MR002797: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
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
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_REVERT,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
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
                        log_message('error', '#MR002849 Insertion failed in settlement_proceeding for case no :'. $case_no);
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
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI02870: Reverted to CO failed case no # $case_no");
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


    // get all cases for final verification
    public function getAllCasesForFinalVerifyByDcTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $allCase = $this->TeaGrantAdcModel->getAllCasesForFinalVerifyAppTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCase->result();
        $data['pendingCaseCount'] = $allCase->num_rows();

        $data['_view'] = 'settlementView/Adc/Khas/final_verify_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }



    // proposal Forward To Dc For Final Verify By ADC
    public function proposalForwardToDcForFinalVerifyTeaGrant()
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
            $user_code   = $this->session->userdata('user_code');
            $proposal_no = trim($this->input->post('proposalNo'));
            $dist_code   = $this->session->userdata('dist_code');
            $pendingCase = $this->TeaGrantAdcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposal_no);
            $cases       = $pendingCase->result();
            $caseCount   = $pendingCase->num_rows();
            $proposalDetails = $this->TeaGrantAdcModel->getProposalDetailsById($proposal_no,$dist_code);

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
                // not processed application
                if($case->case_status == 0 or $case->case_status == '')
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 3,
                        'pendingCases' => $pending,
                        'proposalSequenceNo' => $proposal_no,
                    ));
                    return;
                }

                // approved case
                if($case->case_status == 1)
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
                    if($this->TeaGrantAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR002994: Insertion failed in settlement_proposal_cases for case no :'. $caseNo);
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
                        'sdlac_date'      => date('Y-m-d H:i:s'),
                        'dc_proceeding'   => 1,
                        'final_status'    => MB_APPROVED_BY_SDLAC,
                        'sdlace_proposal_no' => trim($case->proposal_id),
                    );

                    if($this->TeaGrantAdcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR003018: Insertion failed in settlement_basic for case no :'. $caseNo);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    //////proceeding start//////
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$caseNo' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }

                    $insPetProceed = [
                        'case_no' => $caseNo,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
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
                        log_message('error', '#MR003053: Insertion failed in settlement_proceeding for case no :'. $caseNo);
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
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI03071: Forward to DC failed case no # $caseNo");
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
                    if($this->TeaGrantAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR003088: Insertion failed in settlement_proposal_cases for case no :'. $caseNo);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    $updateBasicData = array(
                        'status'          => MB_FINAL_APPROVED_BY_DC,
                        'pending_office'  => MB_DEPUTY_COMM,
                        'pending_officer' => MB_DEPUTY_COMM,
                        'from_office'     => MB_ADD_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        // 'dc_proceeding'   => 0,
                        'final_status'    => MB_DISMISS,
                    );

                    if($this->TeaGrantAdcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR003088: Insertion failed in settlement_basic for case no :'. $caseNo);
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
                        $mmnn = $this->TeaGrantAdcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updatePro);

                        if($mmnn == 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MR003088: Insertion failed in settlement_proposal_cases for case no :'. $caseNo);
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$caseNo' ")->row()->c;

                        if($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }

                        $insPetProceed = [
                            'case_no' => $caseNo,
                            'proceeding_id' => $proceeding_id,
                            'date_of_hearing' => date('Y-m-d H:i:s'),
                            'next_date_of_hearing' => date('Y-m-d H:i:s'),
                            'status' => MB_FINAL_APPROVED_BY_DC,
                            'user_code'  => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d H:i:s'),
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
                            log_message('error', '#MR003160: Insertion failed in settlement_proceeding for case no :'. $caseNo);
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
                            $task   = MB_DEPUTY_COMM;
                            $pen    = null;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            if(trim($rtps_status)!="y")
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #MRAPI03173: Rejected by SDLAC failed case no # $caseNo");
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

            if($this->TeaGrantAdcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MR003195: Insertion failed in settlement_proposal_list for case no :'. $caseNo);
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

    //********************** END KHAS **********************************



    //// end Masud's code

    //get village name
    public function getVillName(){

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code    = $this->input->post('circle');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');

        //get list of villages from settlement basic
        $query = $this->db->query("SELECT A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code, 
          A.lot_no, A.vill_townprt_code, B.loc_name FROM settlement_basic A 
          JOIN location B ON A.uuid=B.uuid
          WHERE A.dist_code=? AND
          A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? 
          GROUP BY
          A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code, A.lot_no, 
          A.vill_townprt_code, B.loc_name",
            array($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no))->result();

        echo json_encode(array(
            'responseType' => 1,
            'location'     => $query,
        ));
        return;
    }


    //pagination of first proceeding
    public function firstProceedingPaginationAPI()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', 43);
        $this->db->where('settlement_basic.pending_officer', 'ADC');
        $this->db->where('settlement_basic.status', 'W');
        $this->db->where('settlement_basic.from_office', 'CO');
        $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
        // $this->db->where('settlement_basic.dc_code is null');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        // $this->db->where('settlement_basic.dc_revert is null');
        // $this->db->where('settlement_basic.adc_revert is null');
        // $this->db->where('settlement_basic.notice_generated_yn is null');
        // $this->db->where('settlement_basic.dc_proceeding', 0);
        // $this->db->where('settlement_basic.dc_approve is null');
        //$this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        log_message("error", "DIB_FIRST_PRO_2 : ". $this->db->last_query());

        // echo $this->db->last_query(); die;

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.service_code', 43);
            $this->db->where('settlement_basic.pending_officer', 'ADC');
            $this->db->where('settlement_basic.status', 'W');
            $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
            $this->db->where('settlement_basic.from_office', 'CO');
            // $this->db->where('settlement_basic.dc_code is null');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            // $this->db->where('settlement_basic.dc_revert is null');
            // $this->db->where('settlement_basic.adc_revert is null');
            // $this->db->where('settlement_basic.notice_generated_yn is null');
            // $this->db->where('settlement_basic.dc_proceeding', 0);
            // $this->db->where('settlement_basic.dc_approve is null');
           // $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
            
            $query1 = $this->db->get();
            log_message("error", "firstProceedingPaginationAPI".$this->db->last_query());

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                // var_dump(($getAppliedAreaType)); die;

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed by DC' : 'Processed by Dept';

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
                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'</span>',

                    '<span style="font-size: 13px;">'.$lm_remark.'</span>',

                    '<span style="font-size: 13px;">'.$co_remark.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? '<span style="font-size: 13px;">'.'<a class="btn btn-success" href="'.base_url().'index.php/TeaGrantControllerAdc/getSettlementTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'">'.$this->lang->line('process').'</a></span>' : ''

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
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    //pagination of Second proceeding SDLAC Recommended (Marked)
    public function secondProceedingSdlacRecommendedMarked()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');
        $approvedBy  = $this->input->post('approvedBy');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

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
            //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('(select distinct on(case_no) case_no,is_urban from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
        $this->db->where_in('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
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
        //echo $this->db->last_query(); die;

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('(select distinct on(case_no) case_no,is_urban from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
            $this->db->where_in('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
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

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $lm_remark,

                    $co_remark,

                    $rows->case_no."<br><span style='color:red; font-size:12px'>MB:".$rows->applid."</span>",

                    $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/getSettlementTeaGrantApplicationDetails/?case='.$rows->case_no.'">View Application</a>'
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
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $proposal_no = $this->input->post('proposal_no');
        $hdate       = strtotime($this->input->post('hearing_date'));
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $ru          = $this->session->userdata('user_desig_code');

        if($hdate != false && $hdate != ''){
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
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
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
       
                    <a class="btn btn-sm btn-success" href="'.base_url().'index.php/SettlementMbADC/getAllApplicationInReportSendByDcToSdlacKhas/?case='.$rows->id.'">
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


    //check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus() {
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


    // SDLAC Report status send to SDLAC/CDLAC Member
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


    // get all forth proceeding SDLAC Report Khas page
    public function getAllSdlacMemberApprovalProposalListTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->TeaGrantAdcModel->getSdlacApprovalProposalListTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();


        $data['_view'] = 'settlementView/Adc/Khas/sdlac_approval_proposal_list_khas';
        $this->load->view('layouts/main', $data);

    }


    // get all forth proceeding SDLAC Report Khas with data
    public function getAllSdlacMemberApprovalProposalListDataTeaGrant()
    {
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

            }

            $query1 = $this->db->get();
            $total_records = $query1->num_rows();
            $i=1;

            foreach($result as $rows)
            {
                $json[] = array (

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    'Proposal No <b>'. $rows->id .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>

                <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    '<i class="fa fa-calendar"></i> On '. date('d-m-Y', strtotime($rows->h_date)),

                    '<i class="fa fa-user"></i> '. $rows->created_by,

                    '<a class="rezaButt buttInfo2" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacAttendance/?case='.$rows->id.'">Attendance</a>
                    
                    <a class="rezaButt buttPrimary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Notice</a>
                 
                    <a class="rezaButt buttCust " target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/generateSdlacMinutesForProposal/?case='.$rows->id.'">Digital Minutes</a>
                    
                    <a class="rezaButt buttInfo" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacUploadedMinute/?case='.$rows->id.'">Uploaded Minutes</a>
                    
                    <a class="rezaButt btn-success" href="'.base_url().'index.php/SettlementMbADC/getSdlacMemberApproveProposalViewIndividualKhas/?case='.$rows->id.'">
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
    public function getSdlacMemberApproveProposalViewIndividualTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $proposal_no = $this->input->get('case');
        $proposal_no = $this->utilityclass->decryptJwtCase($proposal_no);
        
        $proposalDetails  = $this->TeaGrantAdcModel->getSdlacApprovalProposalIndividualTeaGrant($proposal_no,$dist_code);
        $reportDetails    = $this->TeaGrantAdcModel->getSdlacMemberReportDetailsTeaGrant($proposal_no,$dist_code);
        $getMembersStatus = $this->TeaGrantAdcModel->getSdlacMemberStatus($dist_code, $proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $proposalDetails->row();
        $data['pendingCaseCount'] = $proposalDetails->num_rows();
        $data['reports']          = $reportDetails->result();
        $data['reportCount']      = $reportDetails->num_rows();
        $data['getMemberStatus']  = $getMembersStatus;

        $data['_view'] = 'settlementView/Adc/Khas/sdlac_committee_report_details_khas';
        $this->load->view('layouts/main', $data);
    }


    public function getCasesAgainstProposalNo(){
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
            $created_at   = date('Y-m-d H:i:s');
            $updated_at   = date('Y-m-d H:i:s');
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
                log_message('warning', '#MR004269: Insertion failed in sdlac_nominee_list '.
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
        }
        else
        {
            $dist_code           = $this->session->userdata('dist_code');
            $hearing_date        = $this->input->post('hearingDate');
            $case_no             = $this->input->post('case_no');
            $adc_hearing_remarks = $this->input->post('adc_hearing_remarks');
            // $is_mutated          = $this->input->post('is_mutated');

            if($hearing_date == null || $hearing_date == '')
            {
              echo json_encode(array(
                'responseType' => 4,
                'msg'          => 'Hearing date field is mandatory !!!',
              ));
              return;
            }
            if($adc_hearing_remarks == null || $adc_hearing_remarks == '')
            {
              echo json_encode(array(
                'responseType' => 4,
                'msg'          => 'Hearing remarks field mandatory !!!',
              ));
              return;
            }
            // if($is_mutated == null || $is_mutated == '')
            // {
            //   echo json_encode(array(
            //     'responseType' => 4,
            //     'msg'          => 'Please check the radio button of : Is/Are the applicant(s) of this application already mutated ?',
            //   ));
            //   return;
            // }


            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $caseCount    = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails     = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetail = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
                $get_dag_details = $this->TeaGrantAdcModel->getDagDetailsTenant($case_no);
                $get_dag_list    = $this->TeaGrantAdcModel->getDagDetailsList($case_no);

                $dist_name       = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name     = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
                $mouza_name      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
                $village_name    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
                $get_owners      = $this->TeaGrantAdcModel->getOwners($case_no);
                $get_buyers      = $this->TeaGrantAdcModel->getBuyers($case_no);
                $get_exist_pattadars = $this->TeaGrantAdcModel->getExistingPattadars($case_no);
                $get_deed_appls = $this->TeaGrantAdcModel->getDeedApplicants($case_no);

                $notice_no       = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;

                $tableData = '';
                $area_det  = '';
                $msg_area  = '';

                $dag_names_list  = '';

                foreach($get_dag_list as $r)
                {
                  if (in_array($r->dist_code, json_decode(BARAK_VALLEY)))
                  {
                    $area_det  = 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' চ: '.$r->s_dag_area_lc.' গ: '.$r->s_dag_area_g;
                    $msg_area .= $r->dag_no.' নং দাগৰ অংশ '.$r->s_dag_area_b.' বিঘা '.$r->s_dag_area_k.' কঠা '.$r->s_dag_area_lc.' চটক '.$r->s_dag_area_g.' গণ্ডা ';
                  }
                  else
                  {
                    $area_det = 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' লে: '.$r->s_dag_area_lc;
                    $msg_area .= $r->dag_no.' নং দাগৰ অংশ '.$r->s_dag_area_b.' বিঘা '.$r->s_dag_area_k.' কঠা '.$r->s_dag_area_lc.' লেছা ';
                  }
                  $tableData .= "<tr>
                    <td>".$this->utilityclass->getDistrictName($r->dist_code)."</td>
                    <td>".$this->utilityclass->getCircleName($r->dist_code,$r->subdiv_code,$r->cir_code)."</td>
                    <td>".$this->utilityclass->getMouzaName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code)."</td>
                    <td>".$this->utilityclass->getLotName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code,$r->lot_no)."</td>
                    <td>".$this->utilityclass->getVillageName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code,$r->lot_no,$r->vill_townprt_code)."</td>
                    <td>".$r->patta_no."</td>
                    <td>".$this->utilityclass->getPattaName($r->patta_type_code)."</td>
                    <td>".$r->dag_no."</td>
                    <td>".$area_det."</td>
                  </tr>";


                  // get all co pattadars from chitha
                  $chitha_co_pattadar = $this->db->query("SELECT cp.pdar_name, cdp.dag_no FROM chitha_dag_pattadar cdp 
                                        JOIN chitha_pattadar cp ON 
                                        cdp.dist_code = cp.dist_code 
                                        AND cdp.subdiv_code = cp.subdiv_code 
                                        AND cdp.cir_code = cp.cir_code 
                                        AND cdp.mouza_pargona_code = cp.mouza_pargona_code 
                                        AND cdp.lot_no = cp.lot_no 
                                        AND cdp.vill_townprt_code = cp.vill_townprt_code 
                                        AND cdp.patta_no = cp.patta_no 
                                        AND cdp.patta_type_code = cp.patta_type_code 
                                        AND cdp.pdar_id = cp.pdar_id
                                        WHERE cdp.dist_code=? 
                                        AND cdp.subdiv_code=? 
                                        AND cdp.cir_code=? 
                                        AND cdp.mouza_pargona_code=? 
                                        AND cdp.lot_no =? 
                                        AND cdp.vill_townprt_code=? 
                                        AND cdp.dag_no=? 
                                        AND cdp.patta_no=? 
                                        AND cdp.patta_type_code=?", 
                                        [$r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, 
                                        $r->lot_no, $r->vill_townprt_code, $r->dag_no, $r->patta_no, 
                                        $r->patta_type_code])->result();

                  $names = array_map(function($row) {
                      return $row->pdar_name;
                  }, $chitha_co_pattadar);

                  $name_string = implode(', ', $names);

                  // Append to final variable
                  $dag_names_list .= "Dag No: {$r->dag_no}: {$name_string}\n";

                  // foreach ($chitha_co_pattadar as $row) {
                  //   $name_list[] = $row->pdar_name; // collect each name
                  // }                  
                }   

                // Convert to comma-separated string
                // $name_list = implode(', ', $name_list);             

                echo json_encode(array(
                  'responseType'        => 2,
                  'case_no'             => $case_no,
                  'hearing_date'        => date("F j, Y", strtotime($hearing_date)),
                  'caseDetails'         => $caseDetails,
                  'applicantName'       => $applicantDetail,
                  'dist_name'           => $dist_name,
                  'circle_name'         => $circle_name,
                  'mouza_name'          => $mouza_name,
                  'village_name'        => $village_name,
                  'get_dag_details'     => $get_dag_list,
                  'notice_no'           => $notice_no,
                  'get_owners'          => $get_owners,
                  'get_buyers'          => $get_buyers,
                  'tableData'           => $tableData,
                  'msg_area'            => $msg_area,
                  'adc_hearing_remarks' => $adc_hearing_remarks,
                  'existing_pattadars'  => $get_exist_pattadars,
                  'deed_applicants'     => $get_deed_appls,
                  'name_list'           => $dag_names_list,
                ));
                return;
            }
        }
    }

    // save general notice
    public function saveGeneralNoticeTeaGrant()
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
        }
        else
        {
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $dist_code       = $this->session->userdata('dist_code');
            $hearing_date    = $this->input->post('hearingDate');
            $case_no         = $this->input->post('case_no');
            $hearing_remarks = $this->input->post('hearing_remarks');

            // var_dump($_POST); die;



            // $ses_dist = $this->session->userdata('dist_code');
            // $ses_sub  = $this->session->userdata('subdiv_code');
            // $ses_user = $this->session->userdata('user_desig_code');

            // var_dump($ses_dist);
            // var_dump($ses_sub);
            // var_dump($ses_user);


            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            // echo $this->db->last_query();

            // var_dump($user); die;



            $caseCount       = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetails = $this->TeaGrantAdcModel->getAllApplicant($case_no);

                $sqlCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? and service_code = ?', array($case_no, 'GN', $caseDetails->service_code));

                if ($sqlCheck->num_rows() <= 0) {

                    $notice_no = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;
                    $new_case_no = $this->randomFileNameGeneral();

                    if (is_dir(GENERAL_NOTICE_PATH_ADC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_ADC, 0777);
                    }

                    $base_64_file_path    = GENERAL_NOTICE_PATH_ADC . $new_case_no . ".json";
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
                        log_message('error', "#ERRPN00678: Insertion failed in settlement_notice for case no $case_no : ".$this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }


                    // insert into settlement_proceeding
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => 'W',
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => $hearing_remarks,
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_ADD_DEPUTY_COMM,
                        'task'        => 'General notice generated'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        log_message("error", "#ERR4947: Insertion failed in settlement_proceeding for case $case_no : ".$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }

                    $updateData = array(
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                        'dc_proceeding'         => 1,
                        'from_office'           => 'ADC',
                    );
                    if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                        log_message("error", "#ERR4963: Updation failed in settlement_basic for case $case_no : ".$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR4963: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllTeaGrantFirstProceedingDcCaseList',
                    ));
                    return;
                }
                else
                {

                    // echo "dsfghjkl"; die;
                    $path = $sqlCheck->row()->notice_link;

                    if (is_dir(GENERAL_NOTICE_PATH_ADC) === false) {
                        mkdir(GENERAL_NOTICE_PATH_ADC, 0777);
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
                    $updateIntoSettlementNotice = [
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
                    $this->db->update('settlement_notice', $updateIntoSettlementNotice);
                    log_message("error", "#err4960".$this->db->last_query());

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', "#ERR5021: Updation failed in settlement_notice for case no $case_no : ".$this->db->last_query());

                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR5021: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }
                    $updateData = array(
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                        'from_office'           => 'ADC',
                        'pending_office'        => 'ADC',
                    );
                    if ($this->TeaGrantAdcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        log_message('error', "#ERR5034: Updation failed in settlement_basic for case no $case_no : ".$this->db->last_query());

                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR5034: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }

                    // insert into settlement_proceeding
                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if($proceeding_id==null)
                    {
                        $proceeding_id=1;
                    }
                    $insPetProceed = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'status' => 'W',
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation'  => 'E',
                        'note_on_order' => "Notice generated updated by ADC",
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_ADD_DEPUTY_COMM,
                        'office_to'   => MB_ADD_DEPUTY_COMM,
                        'task'        => 'Updated general notice generated'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    if($insertProceeding != 1)
                    {
                        log_message("error", "#ERR4947: Insertion failed in settlement_proceeding for case $case_no : ".$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }

                    $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
                    $basundhara = $this->db->query($sql)->row();

                    // call api to upload notice
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'encoded_file'   => json_decode($htmlstring_text),
                        'application_no' => $basundhara->basundhara,
                        'type'           => 'GN',
                        'amount'         => 0,
                        'is_full_pay'    => 'N',
                    )));
                    $result = curl_exec($curl_handle);

                    if (trim($result) != 'y') {
                        $this->db->trans_rollback();
                        log_message('error', "#ERR5063: Notice upload failed for case no $case_no : ".json_encode($result));

                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => "#ERR5063: Unable to generate notice for case $case_no",
                        ));
                        return;
                    }
                    else {
                        //////////////POST To basundhara/////////////////////
                        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                        $rmk            = 'General notice generated';
                        $status         = 'M';
                        $task           = $this->session->userdata('user_desig_code');
                        $pen            = $this->session->userdata('user_desig_code');
                        $case           = $case_no;
                        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                        $rtps_status    = json_decode($rtps_status);

                        if (trim($rtps_status) != "y")
                        {
                            $this->db->trans_rollback();
                            log_message('error', "#ERR5085: Api response failed for case no $case_no : ".json_encode($rtps_status));

                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => "#ERR5085: Unable to generate notice for case $case_no",
                            ));
                            return;
                        }
                    }
                    log_message("error", "#ERR5074 sdfgdfsbgfds" );
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllTeaGrantFirstProceedingDcCaseList',
                    ));
                    return;
                }
            }
        }
    }

    // random file name for general
    public function randomFileNameGeneral()
    {
        $rand = rand(000000, 999999);
        $new_case_no = 'general_notice_' . $rand;

        if ($this->TeaGrantAdcModel->checkDuplicateFileNameInGeneral($new_case_no) != 0) {
            $this->randomFileName();
        } else {
            return $new_case_no;
        }

    }


    // view all notice generated case list tea grant
    public function viewAllGeneratedNoticeTeaGrantAdcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPendingNoticeGenerateTeaGrant($dist_code);
        // echo $this->db->last_query(); die;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcNoticeGeneratedList';
        $this->load->view('layouts/main', $data);
    }

    //pagination of generated notice
    public function noticeGeneratePaginationAPI()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');

        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', 43);
        $this->db->where('settlement_basic.pending_officer', 'ADC');
        $this->db->where('settlement_basic.notice_generated_yn', 'y');
        $this->db->where('settlement_basic.status', 'W');        
        $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
        // $this->db->where('settlement_basic.dc_code is null');
        // $this->db->where('settlement_basic.dc_revert is null');
        // $this->db->where('settlement_basic.adc_revert is null');
        // $this->db->where('settlement_basic.dc_approve is null');        
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', 43);
            $this->db->where('settlement_basic.pending_officer', 'ADC');
            $this->db->where('settlement_basic.notice_generated_yn', 'y');
            $this->db->where('settlement_basic.status', 'W');
            $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
            // $this->db->where('settlement_basic.dc_revert is null');
            // $this->db->where('settlement_basic.adc_revert is null');
            // $this->db->where('settlement_basic.dc_approve is null');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
            $query1 = $this->db->get();
            // echo $this->db->last_query();

            log_message("error", "noticeGeneratePaginationAPI_2: ".$this->db->last_query());

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                // echo "<pre>"; var_dump($rows); die;

                // $co_remark ='';
                // foreach(json_decode(CO_NOTE) as $co_remark_cat){
                //   if($rows->co_note_yn == $co_remark_cat->CODE){
                //     $co_remark = $co_remark_cat->NAME;
                //   }
                // }
                // $lm_remark ='';
                // foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                //   if($rows->lm_note == $lm_remark_cat->CODE){
                //     $lm_remark = $lm_remark_cat->NAME;
                //   }
                // }

                // recommended for department
                // generate payment notice

                $hearing_availability = $this->checkHearingRemarks($rows->case_no);
                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="adcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        // $forward_dc_btn = null;

                        $forward_dc_btn = '<button title="Forward to DC" class="btn btn-default btn-sm forward_dc_btn" onclick="forward_to_dc(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';
                        $gen_payment_notice_btn = null;
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $forward_dc_btn = '<button title="Forward to DC" class="btn btn-default btn-sm forward_dc_btn" onclick="forward_to_dc(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $forward_dc_btn = null;
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $regenerate_gn_btn = '<button title="Generate Payment Notice" class="btn btn-info btn-sm regenerate_gn_btn" onclick="regenerate_pn_btn_tea_grant(\''.$rows->case_no.'\')"><span class="fa fa-refresh"></span></button>';

                // $revert_to_co_btn = '<a title="Revert to" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $revert_to_co_btn = '<button class="btn btn-warning btn-sm revert_to_co_btn" onclick="revert_to_co_btn(\''.$rows->case_no.'\')" title="Revert to CO Remarks">Revert to CO</button>';

                $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$forward_dc_btn.'&nbsp;'.$revert_to_co_btn.'&nbsp;'.$regenerate_gn_btn;
                // $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$gen_payment_notice_btn;


                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : '',

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    // view general notice
    public function viewGeneralNoticeTeaGrant()
    {
        $case_no       = $this->input->get('case');
        $case_no       = $this->utilityclass->decryptJwtCase($case_no);
        $noticeDetails = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);
        if($noticeDetails == '' or $noticeDetails == NULL)
        {
            echo 'Data not found !';
            return;
        }

        $open_notice_file = fopen($noticeDetails->notice_link, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($noticeDetails->notice_link));
        fclose($open_notice_file);
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));

        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];
        $data['_view'] = 'TeaGrant/common/generalNoticePrint';
        $this->load->view('layouts/main',$data);
    }


    // settlement application details KHAS ADC
    public function viewTeaGrantApplicationDetails()
    {
        $case_no        = $this->input->get('case');
        $case_no        = $this->utilityclass->decryptJwtCase($case_no);
        $dist_code      = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        $this->checkCaseInModificationRequest($case_no);
        $application_no = $this->input->get('case');
        $application_no = $this->utilityclass->decryptJwtCase($application_no);

        $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);

        $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

        $adcdata           = [];
        $dags              = $this->TeaGrantModel->getSettlementDag($application_no);
        $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
        $proceedings       = $this->TeaGrantModel->getSettlementProceeding($application_no);
        $dhardocuments     = $this->TeaGrantModel->getDocuments($application_no);
        $nominee           = $this->TeaGrantModel->getAllNomineeDetail($application_no);
        $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
        $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($application_no);
        $family_tree       = $this->TeaGrantModel->getAllFamilyTree($application_no);

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
        if($caseCount == 0)
        {
            $this->teaGrantAdc();
        }
        else
        {
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
            $data['_view'] = 'TeaGrant/ADC/TeaGrantOnlyViewAdc';
            $this->load->view('layouts/main', $data);
        }
    }

    public function loadViewForHearingRemarks()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantAdcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/ADC/TeaGrantLoadModalHearingRemarks', $data);
    }


    // save hearing remarks
    public function saveHearingRemarksByAdc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hearing_rem', 'Hearing Remarks', 'trim|required');
        $this->form_validation->set_rules('case_no_notice', 'Case No', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5569: Validation error ! Please try again ',
            ]);
            return false;
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $user_code       = trim($this->session->userdata('user_code'));
        $hearing_rem     = trim($this->input->post('hearing_rem'));
        $case_no         = trim($this->input->post('case_no_notice'));
        $recommend       = trim($this->input->post('recommend'));
        $userAccess      = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];

        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5585: You are not authorized for this process.! ',
            ]);
            return false;
        }

        if($recommend == null || $recommend == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5795: Please check if the remarks can be recommend !!!',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // *********** proceeding start **************
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $msg = '';
        $msg = $recommend == 'YES' ? 'Can be recommended' : 'Can not be recommended';
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $hearing_rem."<br>".$msg,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => 'DC',
            'task'                 => 'Hearing Remarks Submitted',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5639: Unable to save hearing remarks !!! ',
            ]);
            return false;
        }

        // *********** update settlement_notice ***********

        $updateSettNotice = [
            'hearing_remarks' => $hearing_rem,
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('notice_type', 'GN');
        $this->db->update('settlement_notice', $updateSettNotice);

        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5641: Unable to save hearing remarks !!! ',
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => '#SUCCESS5628: Remarks successfully submitted !!! ',
        ]);
        return;
    }

    // check hearing remarks
    protected function checkHearingRemarks($case_no)
    {
        return $query = $this->db->query("SELECT * FROM settlement_notice WHERE case_no=? 
                        AND notice_type=? AND hearing_remarks IS NOT NULL",
            array($case_no, 'GN'))->num_rows();
    }

    // get area type
    protected function getAppliedAreaType($case_no)
    {
        return $query = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=? LIMIT 1",
            array($case_no, 'GN'))->row()->is_urban;
    }

    public function forwardToDepartmentSingle()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');

        $this->db->trans_begin();

        // **** proceeding start *****
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => null,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => MB_DEPARTMENT,
            'task'                 => 'Forwarded to department for approval',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR5721: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5721: Failed to forward to department !!! ',
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_DEPARTMENT,
            'pending_officer' => MB_DEPARTMENT,
            'adc_code'        => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR5740: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5740: Failed to forward to department !!! ',
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Forwarded to Dept';
        $status         = 'M';
        $task           = MB_ADD_DEPUTY_COMM;
        $pen            = MB_DEPARTMENT;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR5824: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR5824: Failed to forward to department for case no $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS5837: $case_no has successfully forwarded to Department !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
        ]);
        return;
    }

    // send all application to SDLAC ADC
    public function forwardToDepartmentBulk()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('selectedList[]', 'Case Number(s)', 'trim|required');

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
            $dist_code       = trim($this->session->userdata('dist_code'));
            $subDiv_code     = trim($this->session->userdata('subdiv_code'));
            $allSelectedList = $this->input->post('selectedList');
            $serviceCode     = TEA_SERVICE_CODE;

            if(!empty($allSelectedList))
            {
                foreach ($allSelectedList as $row)
                {
                    $case_no   = $row;
                    $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
                    $caseCount = $this->TeaGrantAdcModel->countApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);

                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    if($checkArea != 0)
                    {
                        $errorArray[] = $case_no;
                        continue;
                    }

                    if($caseCount == 0) {
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }


                    $this->db->trans_begin();

                    // **** proceeding start *****
                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }
                    $insertArr = [
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d H:i:s'),
                        'next_date_of_hearing' => date('Y-m-d H:i:s'),
                        'note_on_order'        => null,
                        'status'               => 'N',
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d H:i:s'),
                        'operation'            => 'E',
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => 'ADC',
                        'office_to'            => MB_DEPARTMENT,
                        'task'                 => 'Forwarded to department for approval',
                    ];
                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                    if ($insertProc != 1)
                    {
                        log_message("error", "#ERR5833: Insertion failed in settlement_proceeding ===".$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message'      => '#ERR5833: Failed to forward to department !!! ',
                        ]);
                        return false;
                    }

                    // **** update settlement_basic ****

                    $updateSettlementBasic = [
                        'pending_office'  => MB_DEPARTMENT,
                        'pending_officer' => MB_DEPARTMENT,
                        'adc_code'        => $this->session->userdata('user_code'),
                        'date_update'     => date('Y-m-d H:i:s'),
                    ];
                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_basic', $updateSettlementBasic);

                    if($this->db->affected_rows() != 1)
                    {
                        log_message("error", "#ERR5740: Updation failed in settlement_basic ===".$this->db->last_query());
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message'      => '#ERR5740: Failed to forward to department !!! ',
                        ]);
                        return false;
                    }

                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk            = 'Forwarded to Dept';
                    $status         = 'M';
                    $task           = MB_ADD_DEPUTY_COMM;
                    $pen            = MB_DEPARTMENT;
                    $case           = $case_no;
                    $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status    = json_decode($rtps_status);

                    if(trim($rtps_status) != "y")
                    {
                        log_message("error", "#ERR5956: Updation failed in postApiResponse for case no $case_no !!!");
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message'      => "#ERR5956: Failed to forward to department for case no $case_no !!! ",
                        ]);
                        return false;
                    }

                    $this->db->trans_commit();
                    echo json_encode([
                        'responseType' => 2,
                        'message'      => "#SUCCESS5968: $case_no has successfully forwarded to Department !!! ",
                        'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
                    ]);
                    return;

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


    // get payment generation page
    public function generatePaymentNoticeTeaGrant()
    {
      $input              = json_decode(file_get_contents("php://input"), true);
      $final_amount       = $input['final_amount'] ?? null;
      $due_amount         = $input['due_amount'] ?? null;
      $case_no            = $input['case_no_notice'] ?? null;
      $hearing_date_input = $input['hearing_date_input'] ?? null;
      $appl_applied_area  = $input['appl_applied_area'] ?? null;
      $re_cal_prem        = $input['re_cal_prem'] ?? null;
      $final_total_amount = $input['final_total_amount'] ?? null;

      $date               = new DateTime($hearing_date_input);
      $hearing_date_input = $date->format('Y-m-d');

      $get_settlement_basic     = $this->TeaGrantModel->getSettlementBasic($case_no);
      $get_settlement_applicant = $this->TeaGrantModel->getAllApplicant($case_no);
      $get_owners               = $this->TeaGrantModel->getAllApplicantOwners($case_no);
      $get_buyers               = $this->TeaGrantModel->getMainApplicant($case_no);
      $get_dag_details          = $this->TeaGrantModel->getSettlementDag($case_no);
      $existing_pattadar        = $this->TeaGrantModel->getAllExistingPattadar($case_no);
      $deed_applicant           = $this->TeaGrantModel->getAllDeedPattadar($case_no);
      $outcome_pending          = $this->TeaGrantModel->getMutatedStatusCount($case_no);

      if($outcome_pending->num_rows() == 0) {
        log_message('error', "#ERR6083: The final outcome of this case is yet to be verified. Please review the details before generating the payment notice: $case_no");
        $json = [
          'responseType' => 0,
          'message'      => "#ERR6083: The final outcome of this case is yet to be verified. Please review the details before generating the payment notice: $case_no",
        ];
        echo json_encode($json);
        return;
      }

      if (empty($get_buyers) || $get_buyers == null || $get_buyers == '') {

        log_message('error', "#ERR5930: Unable to generate payment notice for case no: $case_no");
        $json = [
          'responseType' => 0,
          'message'      => "#ERR5930: Unable to generate payment notice for case no: $case_no",
        ];
        echo json_encode($json);
        return;
      }

      if($appl_applied_area == null || $appl_applied_area == '') {

        log_message('error', "#ERR6139: Please check the question 1: if area greater than the area alloted in Deed for case no: $case_no");
        $json = [
          'responseType' => 0,
          'message'      => "#ERR6139: Please check the question 1: if area greater than the area alloted in Deed for case no: $case_no",
        ];
        echo json_encode($json);
        return;
      }

      if($re_cal_prem == null || $re_cal_prem == '') {

        log_message('error', "#ERR6153: Please check the question 2: if like to recalculate premium for case no: $case_no");
        $json = [
          'responseType' => 0,
          'message'      => "#ERR6153: Please check the question 2: if like to recalculate premium for case no: $case_no",
        ];
        echo json_encode($json);
        return;
      }

      // check chitha area
      $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);
      if($checkAreaDetails['areaCheck'] == 1)
      {
        log_message('error', "#ERR6161: Applied area exceeds the limit of chitha area for case no: $case_no");
        $json = [
          'responseType' => 0,
          'message'      => "#ERR6161: Applied area exceeds the limit of chitha area for case no: $case_no",
        ];
        echo json_encode($json);
        return;
      }

      // premium re claculation
      $premReCalculate = $this->TeaGrantModel->premiumReCalculationForTeaGrant($case_no);
      if($premReCalculate['responseType'] == 0)
      {
        log_message('error', $premReCalculate['log_message']);
        $json = [
          'responseType' => 0,
          'message'      => $premReCalculate['message'],
        ];
        echo json_encode($json);
        return;
      }

      // area check
      $finalAreaCheck = $this->TeaGrantModel->finalAreaCheck($case_no);
      if($finalAreaCheck['responseType'] == 0)
      {
        log_message('error', $finalAreaCheck['log_message']);
        $json = [
          'responseType' => 0,
          'message'      => $finalAreaCheck['message'],
        ];
        echo json_encode($json);
        return;
      }

      if($re_cal_prem == 'YES' && $final_total_amount == '')
      {
        // get details from settlement_premium table
        $get_total_dag = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=?", [$case_no]);

        // get details from edited_premium_recalc_teagrant table
        $history = $this->db->query("SELECT * FROM edited_premium_recalc_teagrant WHERE case_no=? AND is_final=?", 
                        [$case_no, 1]);

        if($get_total_dag->num_rows() != $history->num_rows())
        {
          log_message('error', "#ERR6365: Data fetching mismatched for case no: $case_no");
          $json = [
            'responseType' => 1,
            'message'      => "#ERR6365: Please click on Fetch / Get Total button for final amount view of premium recalculation for case no: $case_no",
          ];
          echo json_encode($json);
          return;
        }
      }

      $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no=? and is_final=1", array($case_no))->result();
      // echo $this->db->last_query();

      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
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
          log_message('error', "#ERR6211: API Response for case no: $case_no". json_encode(json_decode($output)->data));
          $json = [
            'responseType' => 0,
            'message'      => "#ERR6211: Unauthorized access!",
          ];
          echo json_encode($json);
          return;
        }
      }
      curl_close($curl_handle);
      $res = json_decode($output);

      $data = [
        'payment_amount'           => $final_amount,
        'case_no'                  => $case_no,
        'get_settlement_basic'     => $get_settlement_basic,
        'get_dag_details'          => $get_dag_details,
        'get_owners'               => $get_owners,
        'get_buyers'               => $get_buyers,
        'get_settlement_applicant' => $get_settlement_applicant,
        'pay_notice_date'          => date('Y-m-d'),
        'premium_data'             => $premium_data,
        'date_of_application'      => date('d/m/Y', strtotime($res->submission_date)),
        'existing_pattadar'        => $existing_pattadar,
        'deed_applicant'           => $deed_applicant,
        'hearing_date_input'       => $hearing_date_input,
        'appl_applied_area'        => $appl_applied_area,
        're_cal_prem'              => $re_cal_prem,
      ];

      $json = [
        'responseType' => 2,
        'load_view'    => $this->load->view('TeaGrant/common/paymentNoticePrint', $data, true),
      ];
      echo json_encode($json);
      return;
    }

    // save payment notice
    public function savePaymentNotice()
    {
        $input                  = json_decode(file_get_contents("php://input"), true);
        $case_no                = $input['case_no'] ?? null;
        $amount                 = $input['amount'] ?? null;
        $district               = $input['district'] ?? null;
        $sub_division           = $input['sub_division'] ?? null;
        $circle                 = $input['circle'] ?? null;
        $lot_no                 = $input['lot_no'] ?? null;
        $mouza                  = $input['mouza'] ?? null;
        $village                = $input['village'] ?? null;
        $payment_notice_gn_date = date('Y-m-d', strtotime($input['pay_notice_gn_date'])) ?? null;
        $appl_applied_area      = $input['appl_applied_area'] ?? null;
        $re_cal_prem            = $input['re_cal_prem'] ?? null;
        $htmlstring_text        = json_encode($input['htmlstring_text']) ?? null;

        log_message('error', "#111_savePaymentNotice_post_data: ".json_encode($input));

        // check chitha area
        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

        log_message('error', "#111_savePaymentNotice_chithaAreaCheckWithCaseNo: ".json_encode($checkAreaDetails));

        if($checkAreaDetails['areaCheck'] == 1)
        {
          log_message('error', "#ERR6263: Applied area exceeds the limit of chitha area for case no: $case_no");
          $json = [
            'responseType' => 1,
            'message'      => "#ERR6263: Applied area exceeds the limit of chitha area for case no: $case_no",
          ];
          echo json_encode($json);
          return;
        }

        // premium re claculation
        $premReCalculate = $this->TeaGrantModel->premiumReCalculationForTeaGrant($case_no);

        log_message('error', "#111_savePaymentNotice_premReCalculate: ".json_encode($premReCalculate));
        if($premReCalculate['responseType'] == 0)
        {
          log_message('error', $premReCalculate['log_message']);
          $json = [
            'responseType' => 1,
            'message'      => $premReCalculate['message'],
          ];
          echo json_encode($json);
          return;
        }

        // area check
        $finalAreaCheck = $this->TeaGrantModel->finalAreaCheck($case_no);

        log_message('error', "#111_savePaymentNotice_finalAreaCheck: ".json_encode($finalAreaCheck));

        if($finalAreaCheck['responseType'] == 0)
        {
          log_message('error', $finalAreaCheck['log_message']);
          $json = [
            'responseType' => 1,
            'message'      => $finalAreaCheck['message'],
          ];
          echo json_encode($json);
          return;
        }

        $this->utilityclass->checkUserAuthForCaseForAdc($case_no);

        // check if general notice generated
        $checkGeneralNotice = $this->db->query("SELECT * FROM settlement_notice WHERE case_no=? AND notice_type=?", array($case_no, 'GN'))->num_rows();

        if($checkGeneralNotice == 0) {
            log_message('error', "#ERR6002: General notice yet to be generated for case no: $case_no");
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6002: General notice yet to be generated for case no: $case_no",
            ];
            echo json_encode($json);
            return;
        }

        $noticeAlreadyGeneratedCheck = $this->db->query('SELECT * FROM settlement_notice WHERE case_no = ? AND notice_type = ?', array($case_no, 'PN'));

        log_message('error', "#111_savePaymentNotice_noticeAlreadyGeneratedCheck: ".json_encode($this->db->last_query()));

        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) 
        {
            //******re-generate premium notice first check if payment already done for this case_no */
            $paymentStatusCheck = $this->basundhara3Model->paymentStatusCheck($case_no);

            log_message('error', "#111_savePaymentNotice_paymentStatusCheck: ".json_encode($paymentStatusCheck));
            // var_dump($case_no);die;

            if($paymentStatusCheck['responseType'] != 2)
            {
                $this->session->set_flashdata('message', "#ERRINS18435896: Payment already made by citizen for this application # ".$case_no);
                redirect(base_url() . "index.php/home");
            }

            //***getting the old notice link before deleting it */
            $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;

            //***delete the notice */

            $this->db->query('UPDATE settlement_notice SET case_no=? WHERE case_no = ? AND notice_type = ?', 
                                array($case_no.'_1', $case_no, 'PN'));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRINS1843444: Unable to process! Something went wrong... # ".$case_no);
                redirect(base_url() . "index.php/home");
            }
        }

        log_message('error', "#111_savePaymentNotice_path: ".PAYMENT_NOTICE_PATH);


        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp = date('mdYhis', time()).uniqid();

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path    = PAYMENT_NOTICE_PATH . $new_case_no.'_'.$timestamp. ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = $htmlstring_text;
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $get_settlement_basic     = $this->TeaGrantModel->getSettlementBasic($case_no);
        $get_dag_details          = $this->TeaGrantModel->getSettlementDag($case_no);
        $get_settlement_applicant = $this->TeaGrantModel->getAllApplicant($case_no);
        $checkArea                = $this->chithaReserveAreaCheckWithCaseNo($case_no);

        if ($checkArea != 0 && IS_PRODUCTION == 1) {
            log_message('error', '#ERR6038: Applied area cannot exceed total chitha area !');
            $json = [
                'responseType' => 1,
                'message'      => '#ERR6038: Applied area cannot exceed total chitha area !',
            ];
            echo json_encode($json);
            return;
        }

        $this->db->trans_begin();

        // settlement_notice table insertaion
        $service_details  = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", array($case_no))->row();
        $applicant_buyers = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?", 
                                array($case_no,'B'))->result();

        foreach ($applicant_buyers as $buyers)
        {
          $applicant_buyers_json[] = [
            'APPLICANT_ID'         => $buyers->id,
            'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
            'GUARDIAN_NAME'        => $buyers->pdar_guardian,
          ];
        }
        $notice_no = "MB3/PN/".date('Y')."/".TEA_PREFIX."/".$service_details->petition_no;

        $insertIntoSettlementNotice = [
          'case_no'                => $case_no,
          'service_code'           => $service_details->service_code,
          'case_registration_date' => $service_details->submission_date,
          'payment_notice_date'    => date('Y-m-d'),
          'total_amount'           => $amount,
          'sdlac_proposal_id'      => $service_details->sdlace_proposal_no,
          'sdlac_proposal_date'    => $service_details->sdlac_date,
          'applicant_details'      => json_encode($applicant_buyers_json),
          'notice_no'              => $notice_no,
          'notice_link'            => $base_64_file_path,
          'notice_type'            => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        log_message('error', "#111_savePaymentNotice_settlement_notice: ".$this->db->last_query());
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6081: Insertion failed in settlement_notice : '.$this->db->last_query());
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6081: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        $updateArr = [
          'status'             => 'N',
          'adc_code'           => $this->session->userdata('user_code'),
          'user_code'          => $this->session->userdata('user_code'),
          'pay_notice_gen_yn'  => 'Y',
          'pay_notice_gn_date' => $payment_notice_gn_date,
          'date_update'        => date('Y-m-d H:i:s'),
          'from_office'        => 'DC',
          'pending_officer'    => 'ADC',
          'pending_office'     => 'DC',
          'co_notice_link'     => $base_64_file_path,
          'dc_proceeding'      => 1,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);

        log_message('error', "#111_savePaymentNotice_settlement_basic: ".$this->db->last_query());

        if ($this->db->affected_rows() == 0) {
          $this->db->trans_rollback();
          log_message('error', '#ERR6109: Updation failed in settlement_basic : '.$this->db->last_query());
          $json = [
            'responseType' => 1,
            'message'      => "#ERR6109: Failed to generate payment notice for case no $case_no",
          ];
          echo json_encode($json);
          return;
        }
        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
          $proceeding_id = 1;
        }

        if($appl_applied_area == 'NO')
        {
          $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => "No Area Modified",
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => 'ADC',
            'task'                 => 'No modification done for applied Area',
          ];
          $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
          if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6460: Insertion failed in settlement_proceeding : '.$this->db->last_query());
            $json = [
              'responseType' => 1,
              'message'      => "#ERR6460: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
          }
        }

        if(!empty($re_cal_prem))
        {
          $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $re_cal_prem. ' re-calculation done',
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => 'ADC',
            'task'                 => 'ADC has selected as '.$re_cal_prem. ' for premium recalculation',
          ];
          $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
          if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6490: Insertion failed in settlement_proceeding : '.$this->db->last_query());
            $json = [
              'responseType' => 1,
              'message'      => "#ERR6490: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
          }
        }

        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => "",
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
            'office_to'            => 'DC',
            'task'                 => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6137: Insertion failed in settlement_proceeding : '.$this->db->last_query());
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6137: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }

        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6132: Transaction failed : '.json_encode($this->db->trans_status()));
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6132: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }


        //   API CALL END HERE
        $sql = "Select basundhara from basundhar_application where dharitree=?";
        $basundhara = $this->db->query($sql, array($case_no))->row();

        log_message('error', "#111_savePaymentNotice_API_LINK_MB3: ".API_LINK_MB3);

        // call api to upload notice
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."uploadNotice");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'encoded_file'   => json_decode($htmlstring_text),
            'application_no' => $basundhara->basundhara,
            'type'           => 'PN',
            'amount'         => $amount,
            'is_full_pay'    => 'Y',
        )));
        $result = curl_exec($curl_handle);
        log_message('error', "#111_savePaymentNotice_uploadNotice: ".json_encode($result));

        // var_dump($result); die;

        if (trim($result) != 'y') {
            $this->db->trans_rollback();
            log_message('error', '#ERR6570: Issue in API response : '.json_encode($result));
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6570: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        else {
            $this->db->trans_commit();

            $json = [
                'responseType' => 2,
                'message'      => "#SUCCESS6175: Payment notice successfully saved for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
    }


    public function loadViewForPaymentGeneration()
    {
        $case_no         = $this->input->post('case_no');
        
        $get_settlement_basic     = $this->TeaGrantModel->getSettlementBasic($case_no);
        $get_dag_details          = $this->TeaGrantModel->getSettlementDag($case_no);
        $outcome_pending          = $this->TeaGrantModel->getMutatedStatusCount($case_no);

        $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no=? and is_final=1", array($case_no))->result();
        // echo $this->db->last_query();

        // check 
        $checkEditedArea = $this->db->query("SELECT * FROM edited_area_by_adc_teagrant WHERE case_no=?", [$case_no])->num_rows();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
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

        $data = [            
            'case_no'                  => $case_no,
            'get_settlement_basic'     => $get_settlement_basic,
            'get_dag_details'          => $get_dag_details,
            'pay_notice_date'          => date('Y-m-d'),
            'premium_data'             => $premium_data,
            'date_of_application'      => date('d/m/Y', strtotime($res->submission_date)),
            'checkEditedArea'           => $checkEditedArea,
        ];

        // echo "<pre>"; var_dump($data); die;

        $checkAreaDetails  = $this->chithaAreaCheckWithCaseNo($case_no);
        $data['areaCheck'] = $checkAreaDetails['areaCheck'];
        $data['case_no'] = $this->input->post('case_no');

        $data['prem']    = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? AND is_final=1", array($case_no))->row();
        $data['all_dags'] = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=?", array($case_no))->result();

        $data['basic'] = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no))->row_array();

        $this->load->view('TeaGrant/ADC/TeaGrantLoadModalPaymentNotice', $data);
    }


    // view all payment notice generated case list tea grant
    public function viewAllPaymentPendingCases()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPaymentPendingTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcPaymentPendingList';
        $this->load->view('layouts/main', $data);
    }

    //pagination of generated notice
    public function paymentPendingByAdcCaseList()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }


        $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
          settlement_basic.submission_date');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
        $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->where('settlement_premium.grn_no IS NULL');

        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);
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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }


            // $this->db->select('*');
            // $this->db->from('settlement_basic');
            // $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            // $this->db->where('settlement_basic.service_code', $service);
            // $this->db->where('settlement_basic.dist_code', $dist_code);
            // $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
            // $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            // $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            // $this->db->where('settlement_premium.grn_no IS NULL');
            // $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);


            $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
              settlement_basic.submission_date');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
            $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where('settlement_premium.grn_no IS NULL');

            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_pn_btn = '<a title="View Payment Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewPaymentNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $write_report_btn = '<a title="Write Report" class="btn btn-danger btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/confirmPaymentAdc/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-edit"></span></a>';

                $button = $appl_view_btn.'&nbsp;'.$view_pn_btn.'&nbsp;'.$write_report_btn;


                $json[] = array(

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    public function viewAllPaymentApprovalPendingCases()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPaymentApprovalPendingTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcPaymentApprovalPendingList';
        $this->load->view('layouts/main', $data);
    }


    // view general notice
    public function viewPaymentNoticeTeaGrant()
    {
        $case_no       = $this->input->get('case');
        $case_no       = $this->utilityclass->decryptJwtCase($case_no);
        $noticeDetails = $this->TeaGrantAdcModel->getPaymentNoticeDetails($case_no);

        if($noticeDetails == '' or $noticeDetails == NULL)
        {
            echo 'Data not found !';
            return;
        }

        $open_notice_file = fopen($noticeDetails->notice_link, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($noticeDetails->notice_link));
        fclose($open_notice_file);
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));

        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];

        $data['_view'] = 'TeaGrant/common/viewPaymentNoticePrint';
        $this->load->view('layouts/main',$data);
    }


    public function confirmPaymentAdc()
    {
        $redirect = base_url() . "index.php/TeaGrantControllerAdc/viewAllPaymentPendingCases";

        $case_no              = $this->input->get('case');
        $case_no              = $this->utilityclass->decryptJwtCase($case_no);
        $get_settlement_basic = $this->TeaGrantModel->getSettlementBasic($case_no);
        $case_no_rtps         = $get_settlement_basic['applid'];

        // payment status check thourgh API
        $payment_status_check = $this->basundhara3Model->paymentConfirmation($case_no_rtps);

        // var_dump($payment_status_check); die;
        if ($payment_status_check == null || (!isset($payment_status_check->payment_status)
                && !isset($payment_status_check->total_premium)
                && !isset($payment_status_check->paid_amount)
                && !isset($payment_status_check->remaining_amount)
                && !isset($payment_status_check->tenure)
                && !isset($payment_status_check->installment_amount)
            ))
        {
            $total_premium      = 0;
            $paid_amount        = 0;
            $remaining_amount   = 0;
            $tenure             = 0;
            $installment_amount = 0;
            $percentage         = 0;
            $pay_date           = null;
        }

        $pay_status = isset($payment_status_check->payment_status) ? $payment_status_check->payment_status : '';
        // $pay_status = 'y';

        if (strtoupper($pay_status) == 'Y')
        {
            $total_premium      = $payment_status_check->total_premium;
            $paid_amount        = $payment_status_check->paid_amount;
            $remaining_amount   = $payment_status_check->remaining_amount;
            $tenure             = $payment_status_check->tenure;
            $installment_amount = $payment_status_check->installment_amount;
            $percentage         = $payment_status_check->percentage;
            $pay_date           = $payment_status_check->payment_date;

            // $total_premium      = 9300;
            // $paid_amount        = 9300;
            // $remaining_amount   = 0;
            // $tenure             = 5;
            // $installment_amount = 0;
            // $percentage         = 100;
            // $pay_date           = '2024-12-23';
        }
        else {
            $total_premium      = 0;
            $paid_amount        = 0;
            $remaining_amount   = 0;
            $tenure             = 0;
            $installment_amount = 0;
            $percentage         = 0;
            $pay_date           = null;
        }

        // this portion have to remove later starts here
        // $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is not null limit 1', array($case_no, 1));
        // if ($sqlCheck->num_rows() > 0) {
        //   $paymentStatus = 'y';
        // }
        // else
        // {
        //   $paymentStatus = strtolower($pay_status);
        // }
        // this portion have to remove later ends here

        $data = [
            'case_no'            => $case_no,
            // 'payment_status'     => $paymentStatus, // remove this
            'payment_status'     => strtolower($pay_status),
            'payment_date'       => $pay_date,
            'case_no_rtps'       => $case_no_rtps,
            'total_premium'      => $total_premium,
            'paid_amount'        => $paid_amount,
            'remaining_amount'   => $remaining_amount,
            'tenure'             => $tenure,
            'installment_amount' => $installment_amount,
            'percentage'         => $percentage,
        ];

        if (strtoupper($pay_status) == 'Y') {

            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {

                $this->db->trans_begin();

                $dagsResult = $this->SettlementKhasModel->getSettlementDag($case_no);
                $isFullPay  = 'YES';

                if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
                    $isFullPay = 'NO';
                }

                $updateArr = [
                    'is_full_pay'        => $isFullPay,
                    'total_premium'      => $payment_status_check->total_premium,
                    'paid_amount'        => $payment_status_check->paid_amount,
                    'remaining_amount'   => $payment_status_check->remaining_amount,
                    'tenure'             => $payment_status_check->tenure,
                    'installment_amount' => $payment_status_check->installment_amount,
                    'payment_date'       => $payment_status_check->payment_date,
                    'grn_no'             => $payment_status_check->grn_no,
                ];

                $this->db->where('case_no', $case_no);
                $this->db->where('is_final', 1);
                $this->db->update('settlement_premium', $updateArr);

                if ($this->db->affected_rows() != count($dagsResult)) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR6547: Something went wrong! Unable to process...");
                    redirect($redirect);
                }
                $this->db->trans_commit();
            }
        }


        // $pattasqll = "SELECT type_code, patta_type FROM patta_code where settlement='y' order by type_code asc";

        $get_settlement_basic['applid'];

        $dist_code   = $get_settlement_basic['dist_code'];
        $subdiv_code = $get_settlement_basic['subdiv_code'];
        $cir_code    = $get_settlement_basic['cir_code'];
        
        $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'";
        $data['alm'] = $alm = $this->db->query($q)->row();

        $mouza  = $get_settlement_basic['mouza_pargona_code'];
        $lot_no = $get_settlement_basic['lot_no'];
        $vill   = $get_settlement_basic['vill_townprt_code'];


        $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is not null limit 1', array($case_no, 1));

        $data['paid_confirm'] = $sqlCheck->num_rows();


        $lraVerificationUsed = false;
        $lraVerify = $this->db->query('select * from settlement_basic where case_no = ? AND chitha_processing_details IN (?,?)', 
                        [$case_no, '1', '2'])->num_rows();
        if($lraVerify > 0)
        {
            $lraVerificationUsed = true;
        }

        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();

        $data['update_land_class'] = false;

        foreach ($data['dagDetails'] as $dagRow) {
            $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->dag_no));

            if ($getPremSql->num_rows() <= 0) {
                $dagRow->final_settlement_area = false;
            } else {
                $premiumRow = $getPremSql->row();
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
                } else {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
                }
            }

            //****getting the roadside reservation area */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->dag_no));

            if ($reservation->num_rows() <= 0) {
                $dagRow->road_side_reservation = false;
            } else {
                $reservation = $reservation->result();

                foreach ($reservation as $reservationRow) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
                    } else {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
                    }
                }
            }

            //*****getting the approval report */

            //******getting the final settlement area */
            // if ($get_settlement_basic->service_code == '14') {
            //     $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            // } else {
            $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            // }

            if ($getAppTransSql->num_rows() <= 0) {
                $data['approvalRow'] = false;
            } else {
                $appRow = $getAppTransSql->row();

                $dagRow->new_patta_type_code = $appRow->patta_type_code;
                $dagRow->new_possession_from = $appRow->possession_from;
                $dagRow->new_landclass_home = $appRow->landclass_home;
                // $dagRow->new_landclass_agri = $appRow->landclass_agri;

                $dagRow->newHomeRevenue = $appRow->new_home_land_revenue;
                // $dagRow->newAgriRevenue = $appRow->new_agri_land_revenue;

                $dagRow->newHomeLocalTax = $appRow->new_home_land_local_tax;
                // $dagRow->newAgrilocalTax = $appRow->new_agri_land_local_tax;

                $dagRow->new_landmark = json_decode($appRow->landmark);
                // $dagRow->land_purpose = $appRow->land_purpose;
                // $dagRow->new_existing_land_type = $appRow->existing_land_type;
            }

            $dagRow->landmark = json_decode($dagRow->landmark);

            if ($data['alm']->chitha_processing_details == 2 && (empty($data['alm']->order_passed) || $data['alm']->order_passed == null || $data['alm']->order_passed == '')) {
                $landType = 0;
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $homestead = $home_b + $home_k + $home_lc + $home_g;
                if ($homestead > 0) {
                    $landType = 1;
                }
                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;
                if ($agriculture > 0) {
                    $landType = 2;
                }
                if ($homestead > 0 && $agriculture > 0) {
                    $landType = 3;
                }

                if ($landType == 3) {
                    if (empty($dagRow->new_land_class_home) || empty($dagRow->new_land_class_agri)) {
                        if ($data['update_land_class'] != true) {
                            $data['update_land_class'] = true;
                        }
                    }
                }
            }
        }




        $data['class_code'] = $patta_type_code[0]->new_land_class_code;
        $data['nomTrans'] = false;

        $data['paid_confirm']        = $sqlCheck->num_rows();
        $data['lraVerificationUsed'] = $lraVerificationUsed;

        $data['_view'] = 'TeaGrant/common/confirmPaymentView';
        $this->load->view('layouts/main', $data);
    }


    public function paymentConfirmationForwardToCo()
    {
        $redirect = base_url() . "index.php/TeaGrantControllerAdc/viewAllPaymentApprovalPendingCases";
        $case_no  = $this->input->post('case_no');
        $rtps_appl_no  = $this->input->post('rtps_case_no');

        // payment status check thourgh API
        $payment_status_check = $this->TeaGrantModel->paymentConfirmation($rtps_appl_no);

        $pay_status = isset($payment_status_check->payment_status)?$payment_status_check->payment_status:'';
        $pay_status = 'y'; // remove this later

        if($pay_status == 'y')
        {
            $this->db->trans_begin();

            // update settlement basic table
            $updateBasic = [
                'pending_office'  => 'CO',
                'pending_officer' => 'CO',
                'status'          => 'N',
                'from_office'     => 'DC',
            ];
            $where = [
                'case_no' => $case_no,
                'applid'  => $rtps_appl_no
            ];
            $this->db->update('settlement_basic', $updateBasic, $where);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                log_message("error", "#ERROR6589: Failed to update settlement_basic for case no ".$case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => 'Unable to forward to CO for case no $case_no',
                ));
                return;
            }

            // insert into proceeding
            $remarks = 'Forward to CO for Chitha Update';
            $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", array($case_no))->row()->c;

            if($proceeding_id==null)
            {
                $proceeding_id=1;
            }
            $insPetProceed = [
                'case_no'               => $case_no,
                'proceeding_id'         => $proceeding_id,
                'date_of_hearing'       => date('Y-m-d H:i:s'),
                'status'                => MB_PAYMENT_NOTICE,
                'user_code'             => $this->session->userdata('user_code'),
                'date_entry'            => date('Y-m-d H:i:s'),
                'operation'             => 'E',
                'note_on_order'         => $remarks,
                'ip'                    => $this->utilityclass->get_client_ip(),
                'office_from'           => MB_ADD_DEPUTY_COMM,
                'office_to'             => MB_CIRCLE_OFFICER,
                'task'                  => 'Forwarded to CO'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            if($insertProceeding != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR6628: Insertion failed in settlement_proceeding for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => 'Unable to forward to CO for case no $case_no',
                ));
                return;
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message'      => "#SUCCESS6684: Final forward to CO for case no: $case_no has successfully done !!!",
                'redirect'     => $redirect,
            ));
            return;
        }
        else
        {
            log_message('error', '#WARNING6691: No response found :'. json_encode($payment_status_check));
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'Unable to forward to CO for case no $case_no',
            ));
            return;
        }
    }

    public function makePaymentDummy()
    {
        $case_no   = $this->input->post('case_no');

        // var_dump($case_no); die;

        $q = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? AND is_final=?", array($case_no, 1))->num_rows();


        $updateArr = [
            'is_full_pay'        => 'YES',
            'total_premium'      => '150',
            'paid_amount'        => '150',
            'remaining_amount'   => '0',
            'tenure'             => '5',
            'installment_amount' => 0,
            'payment_date'       => date('Y-m-d H:i:s'),
            'grn_no'             => 'AS123456789',
        ];
        $this->db->where('case_no', $case_no);
        $this->db->where('is_final', 1);
        $this->db->update('settlement_premium', $updateArr);

        // echo $this->db->last_query();

        if($this->db->affected_rows() != $q)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'Payment Failed !!!',
            ));
            return;
        }
        echo json_encode(array(
            'responseType' => 2,
            'message'      => 'Dummy payment successfully made !!!',
            'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllPaymentPendingCases',
        ));
        return;
    }


    public function paymentApprovalPendingByAdcCaseList()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        

        $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
              settlement_basic.submission_date, settlement_premium.grn_no');

        $this->db->from('settlement_basic');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
        $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
        $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM]);
        $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        // $this->db->where('settlement_premium.grn_no IS NOT NULL');
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query();

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }


            $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
              settlement_basic.submission_date, settlement_premium.grn_no');

            $this->db->from('settlement_basic');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
            $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM]);
            $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            // $this->db->where('settlement_premium.grn_no IS NOT NULL');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $paid_status = ($rows->grn_no == null) ? 'Manual Payment' : 'Online Payment';

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_pn_btn = '<a title="View Payment Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewPaymentNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $write_report_btn = '<a title="Write Report" class="btn btn-danger btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/confirmPaymentAdc/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-edit"></span></a>';

                $button = $appl_view_btn.'&nbsp;'.$view_pn_btn.'&nbsp;'.$write_report_btn;


                $json[] = array(

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span><br><span style='color: green'>".$paid_status."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    // view all department approval list tea grant
    public function viewAllDeptApprovalTeaGrantAdcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPendingDeptApprovalTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcDeptApprovalList';
        $this->load->view('layouts/main', $data);
    }

    //pagination of department approval list
    public function deptApprovalPendingList()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM]);
        $this->db->where('settlement_basic.dept_code IS NOT NULL');
        $this->db->where('settlement_basic.dept_approval', 'Y');
        $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no and sn2.notice_type = 'GN')", NULL, false);
        $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no and sn2.notice_type = 'PN')", NULL, false);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);

            $this->db->where_in('settlement_basic.pending_officer', [MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM]);
            $this->db->where('settlement_basic.dept_code IS NOT NULL');
            $this->db->where('settlement_basic.dept_approval', 'Y');
            $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no and sn2.notice_type = 'GN')", NULL, false);
            $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no and sn2.notice_type = 'PN')", NULL, false);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                // echo "<pre>"; var_dump($rows); die;

                // $co_remark ='';
                // foreach(json_decode(CO_NOTE) as $co_remark_cat){
                //   if($rows->co_note_yn == $co_remark_cat->CODE){
                //     $co_remark = $co_remark_cat->NAME;
                //   }
                // }
                // $lm_remark ='';
                // foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                //   if($rows->lm_note == $lm_remark_cat->CODE){
                //     $lm_remark = $lm_remark_cat->NAME;
                //   }
                // }

                // recommended for department
                // generate payment notice

                $hearing_availability = $this->checkHearingRemarks($rows->case_no);
                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="adcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$gen_payment_notice_btn;


                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    // view all reverted cases from DC
    public function viewAllDcDeptRevertedTeaGrantAdcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllDcRevertedCasesTeaGrant($dist_code);
        // echo $this->db->last_query();

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantRevertedFromDcCaseList';
        $this->load->view('layouts/main', $data);
    }

    //pagination of reverted cases from DC
    public function adcRevertedPendingList()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('vill_townprt_code', $village);
            $this->db->where('subdiv_code', $subDiv_code);
            $this->db->where('mouza_pargona_code', $mouza_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('case_no', $by_case_no);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', MB_REVERT);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('dept_revert', 1);
        $this->db->where('dc_code is not null');
        // $this->db->where('dc_code', trim($this->session->userdata('user_code')));
        
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('vill_townprt_code', $village);
                $this->db->where('subdiv_code', $subDiv_code);
                $this->db->where('mouza_pargona_code', $mouza_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('case_no', $by_case_no);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', MB_REVERT);
            $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('dept_revert', 1);
            $this->db->where('dc_code is not null');
            // $this->db->where('dc_code', trim($this->session->userdata('user_code')));

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                // echo "<pre>"; var_dump($rows); die;

                // $co_remark ='';
                // foreach(json_decode(CO_NOTE) as $co_remark_cat){
                //   if($rows->co_note_yn == $co_remark_cat->CODE){
                //     $co_remark = $co_remark_cat->NAME;
                //   }
                // }
                // $lm_remark ='';
                // foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                //   if($rows->lm_note == $lm_remark_cat->CODE){
                //     $lm_remark = $lm_remark_cat->NAME;
                //   }
                // }

                // recommended for department
                // generate payment notice

                $hearing_availability = $this->checkHearingRemarks($rows->case_no);
                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="adcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $adc_revert_to_co = '<button title="Revert to CO" class="btn btn-warning btn-sm revert_co_btn" onclick="adc_revert_to_co(\''.$rows->case_no.'\')">Revert to CO</button>';

                $forward_to_dc = '<button title="Forward to DC" class="btn btn-default btn-sm forward_dept_btn" onclick="forward_to_dc(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';

                $button = $appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$adc_revert_to_co.'&nbsp;'.$forward_to_dc;

                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    // revert to adc
    public function loadViewForCoRevert()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantAdcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/ADC/TeaGrantAdcToCoRevert', $data);
    }

    public function revertToCoFromAdc()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $adc_revert_rem = $this->input->post('adc_revert_rem');

        if($adc_revert_rem == null || $adc_revert_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR7599: Remarks field is mandatory !!! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // **** proceeding start *****
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $adc_revert_rem,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Revert to CO from ADC',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR7647: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7647: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_CIRCLE_OFFICER,
            'pending_officer' => MB_CIRCLE_OFFICER,
            'adc_code'        => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
            'adc_revert'      => 'y',
            'status'          => 'R',
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR7652: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7652: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Revert to CO';
        $status         = 'M';
        $task           = MB_CIRCLE_OFFICER;
        $pen            = MB_CIRCLE_OFFICER;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR7672: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7672: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS7684: $case_no has successfully reverted to CO !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllDcRevertedTeaGrantAdcCaseList',
        ]);
        return;
    }


    public function loadViewForForwardedToDc()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantAdcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');

        $checkAreaDetails  = $this->chithaAreaCheckWithCaseNo($case_no);
        $data['areaCheck'] = $checkAreaDetails['areaCheck'];

        $this->load->view('TeaGrant/ADC/TeaGrantForwardToDc', $data);
    }

    public function forwardToDc()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $adc_forward_rem = $this->input->post('adc_forward_rem');
        $recommend = $this->input->post('recommend');

        if($adc_forward_rem == null || $adc_forward_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR7720: Remarks field is mandatory !!! ',
            ]);
            return false;
        }
        if($recommend == null || $recommend == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR7746: Please select recommend / not recommend !!! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // **** proceeding start *****
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $msg = '';
        $msg = $recommend == 'YES' ? 'Can be recommended' : 'Can not be recommended';

        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $adc_forward_rem."<br>".$msg,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => MB_ADD_DEPUTY_COMM,
            'office_to'            => MB_DEPUTY_COMM,
            'task'                 => 'Forwarded to DC from ADC',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR7751: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7751: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_DEPUTY_COMM,
            'adc_code'        => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
            'status'          => MB_PENDING,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR7773: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7773: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Forwarded to DC';
        $status         = 'M';
        $task           = MB_DEPUTY_COMM;
        $pen            = MB_DEPUTY_COMM;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR7793: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7793: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS7805: $case_no has successfully fowarded to DC !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
        ]);
        return;
    }



    // view all approved case list from DC
    public function viewAllApprovedCaseFromDcList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllApprovedCasesFromDc($dist_code);
        // echo $this->db->last_query(); die;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcApprovedFromDc';
        $this->load->view('layouts/main', $data);
    }


    //pagination of approved cases from DC
    public function allApprovedCaseListFromDc()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }
        if(!empty($remark_cat_lm)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
        }


        $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
              settlement_basic.submission_date');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', $service);  
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);      
        $this->db->where('settlement_basic.status', MB_PAYMENT_REQUEST);
        $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
        $this->db->where('settlement_basic.dc_code IS NOT NULL');
        // $this->db->where('settlement_basic.dc_revert IS NULL');
        // $this->db->where('settlement_basic.adc_revert IS NULL');
        // $this->db->where('settlement_basic.dc_approve', 'y');
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
        $this->db->limit($length, $start);

        $query = $this->db->get();
        // echo $this->db->last_query(); die;

        log_message("error", "QUERY_FOR_BASIC_APPROVE_FROM_DC". $this->db->last_query());

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
              settlement_basic.submission_date');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', $service);  
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);      
            $this->db->where('settlement_basic.status', MB_PAYMENT_REQUEST);
            $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
            $this->db->where('settlement_basic.dc_code IS NOT NULL');
            // $this->db->where('settlement_basic.dc_revert IS NULL');
            // $this->db->where('settlement_basic.adc_revert IS NULL');
            // $this->db->where('settlement_basic.dc_approve', 'y');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {
                

                $gen_payment_notice_btn = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="gen_payment_notice_btn_tea_grant(\''.$rows->case_no.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16s-7.163 16-16 16m-4.313-21.938h.032c2.875.063 5.75-.062 8.625.063c.718 0 1.562.344 1.718 1.094c.25 1.75-1.218 3.344-2.812 3.75c-1.75.281-3.5.187-5.219.187a924 924 0 0 1-1.25 3.063c2.094 0 4.188.093 6.25-.219a8.71 8.71 0 0 0 6.344-5.688c.5-1.312.719-2.968-.281-4.124C24.25 7.125 22.75 7.125 21.5 7.03L12.937 7l-1.25 3.063zM8 10.906v.031l-1.375 3.438h10.188l1.343-3.469zm1.625 4.25h.031L6 24.531h3.469l3.687-9.375z"/></svg></button>';

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed by DC' : 'Processed by Dept';

                $checkBox  = $rows->case_no;

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $button = $appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$gen_payment_notice_btn;

                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    // view all reverted cases from DC
    public function viewAllDcRevertedTeaGrantAdcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllDcRevertedCasesTeaGrantNormal($dist_code);
        // echo $this->db->last_query();

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantNormalRevertFromDcCaseList';
        $this->load->view('layouts/main', $data);
    }


    //pagination of reverted cases from DC
    public function adcNormalRevertedPendingList()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('vill_townprt_code', $village);
            $this->db->where('subdiv_code', $subDiv_code);
            $this->db->where('mouza_pargona_code', $mouza_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('case_no', $by_case_no);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', MB_REVERT);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('dept_revert', 0);
        $this->db->where('dc_revert', 'y');
        $this->db->where('dc_code is not null');
        // $this->db->where('dc_code', trim($this->session->userdata('user_code')));
        
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('vill_townprt_code', $village);
                $this->db->where('subdiv_code', $subDiv_code);
                $this->db->where('mouza_pargona_code', $mouza_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('case_no', $by_case_no);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', MB_REVERT);
            $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('dept_revert', 0);
            $this->db->where('dc_revert', 'y');
            $this->db->where('dc_code is not null');
            // $this->db->where('dc_code', trim($this->session->userdata('user_code')));

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                // echo "<pre>"; var_dump($rows); die;

                // $co_remark ='';
                // foreach(json_decode(CO_NOTE) as $co_remark_cat){
                //   if($rows->co_note_yn == $co_remark_cat->CODE){
                //     $co_remark = $co_remark_cat->NAME;
                //   }
                // }
                // $lm_remark ='';
                // foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                //   if($rows->lm_note == $lm_remark_cat->CODE){
                //     $lm_remark = $lm_remark_cat->NAME;
                //   }
                // }

                // recommended for department
                // generate payment notice

                $hearing_availability = $this->checkHearingRemarks($rows->case_no);
                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed by Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="adcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $adc_revert_to_co = '<button title="Revert to CO" class="btn btn-warning btn-sm revert_co_btn" onclick="adc_revert_to_co(\''.$rows->case_no.'\')">Revert to CO</button>';

                $forward_to_dc = '<button title="Forward to DC" class="btn btn-default btn-sm forward_dept_btn" onclick="forward_to_dc(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';

                $button = $appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$adc_revert_to_co.'&nbsp;'.$forward_to_dc;

                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
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
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            // var_dump("sdfgh"); die;
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $modificationRequest = $this->checkCaseInModificationRequestWithSession($case_no);
            // var_dump($modificationRequest); die;
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                ));
                return false;
            }
            $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->TeaGrantAdcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            // var_dump($caseIdSdlacProposal); die;
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
                // var_dump($updateData); die;
                $this->db->trans_begin();
                if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from'          => MB_ADD_DEPUTY_COMM,
                        'office_to'            => MB_CIRCLE_OFFICER,
                        'task'                 => 'Reverted to CO'
                    ];
                    // var_dump($insPetProceed); die;
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                    // var_dump($insertProceeding); die;

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR00483: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    else
                    {
                        $application_no = $this->TeaGrantAdcModel->getSettlementBasicCo($case_no)->applid;
                        $rmk         = 'Reverted by ADC';
                        $status      = 'M';
                        $task        = MB_ADD_DEPUTY_COMM;
                        $pen         = MB_CIRCLE_OFFICER;
                        $case        = $case_no;
                        $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                        // var_dump($rtps_status); die;
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI0502: Reverted by DC failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        else
                        {
                            $this->db->trans_commit();
                            echo json_encode(array(
                                'responseType' => 2,
                                'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllTeaGrantFirstProceedingDcCaseList',
                            ));
                            return;
                        }
                    }
                    //////proceeding end//////
                }
            }
        }
    }

    public function loadViewForRevertToCoRemarks()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantAdcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/ADC/TeaGrantAdcToCoRevertAfterNoticeGenerate', $data);
    }

    public function revertToCoFromAdcAfterNoticeGenerate()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $adc_revert_rem = $this->input->post('adc_revert_rem');

        if($adc_revert_rem == null || $adc_revert_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR8393: Remarks field is mandatory !!! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // **** proceeding start *****
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $adc_revert_rem,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'ADC',
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Revert to CO from ADC after notice generate',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR8424: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR8424: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_CIRCLE_OFFICER,
            'pending_officer' => MB_CIRCLE_OFFICER,
            'adc_code'        => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
            'adc_revert'      => 'y',
            'status'          => 'R',
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR8448: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR8448: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        // update settlement_notice
        $updateSettlementNotice = [
            'case_no'  => $case_no.'_1',
        ];
        $this->db->where('case_no', $case_no);
        $this->db->where('notice_type', 'GN');
        $this->db->update('settlement_notice', $updateSettlementNotice);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR8448: Updation failed in settlement_notice ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR8448: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Revert to CO';
        $status         = 'M';
        $task           = MB_CIRCLE_OFFICER;
        $pen            = MB_CIRCLE_OFFICER;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR8472: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR8472: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS8480: $case_no has successfully reverted to CO !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
        ]);
        return;
    }

    public function saveMutationStatus()
    {
      $_POST                 = json_decode(file_get_contents("php://input"), true);
      $case_no               = $this->input->post('case_no');
      $pattadar_array        = $this->input->post('pattadar');
      $service_code          = $this->input->post('service_code');
      $mutatedApplList_count = $this->input->post('mutatedApplList_count');
      $mutatedApplList_array = $this->input->post('mutatedApplList_array');
      $no_pattadar           = $this->input->post('no_pattadar');
      $already_partitioned   = $this->input->post('already_partitioned');
      $joint_appl_remove     = $this->input->post('joint_appl_remove');
      $message               = '';

      $arr_merge             = array_merge($pattadar_array, $no_pattadar);

      $decodedHtml           = htmlspecialchars_decode($mutatedApplList_array, ENT_QUOTES);
      $comboCountArray       = json_decode($decodedHtml, true); // Convert JSON string to PHP array

      $dagIdSet = [];

      foreach ($arr_merge as $entry) {
        $parts = explode('_', $entry);
        
        if (count($parts) !== 3) continue; // skip invalid

        $prefix = $parts[0]; // 0, 1, 2 etc.
        $dagId  = $parts[1] . '_' . $parts[2];

        // Store all combinations with 0_ prefix for quick lookup
        if ($prefix === '0') {
          $dagIdSet[$dagId] = true;
        }
      }

      // Now check if any 1_/2_/etc. has a corresponding 0_ dag_id
      foreach ($arr_merge as $entry) {
        $parts = explode('_', $entry);

        if (count($parts) !== 3) continue;

        $prefix = $parts[0];
        $dagId  = $parts[1] . '_' . $parts[2];

        if ($prefix !== '0' && isset($dagIdSet[$dagId])) {
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR8574: Please do not select both "Pattadar" and "উপলব্ধ নহয়" checkboxes for the same applicant under a single Dag !!!',
          ]);
          return;
        }
      }
      
      $inputCombinations = array_map(function($val) {
        $parts = explode('_', $val);
        return $parts[1] . '_' . $parts[2];
      }, $arr_merge);

      $allExist = true;
      foreach (array_keys($comboCountArray) as $comboKey) {
        if (!in_array($comboKey, $inputCombinations)) {
          $allExist = false;
          break;
        }
      }

      if (!$allExist) {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR8568: For each dag wise applicant, you must have to select a pattadar, if no pattadar exist then please check on উপলব্ধ নহয় !!!',
        ]);
        return;
      }

      $filtered = array_filter($arr_merge, function($value) {
        return explode('_', $value)[0] === '0';
      });

      if (count($filtered) === count($arr_merge)) {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR8545: You have selected no pattadar. In this scenario, proceed with clicking NO button instead of YES !!!',
        ]);
        return;
      }

      // check if data alaready exist in the table
      $check = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case_no))->num_rows();
      if($check > 0)
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR8552: Data already exist !!!',
        ]);
        return;
      }

      $tempArray = $arr_merge; // Copy for manipulation

      foreach ($arr_merge as $val) {
        $parts = explode('_', $val);
        if (count($parts) !== 3) continue;
        if ($parts[0] !== '0') {
          $check = '0_' . $parts[1] . '_' . $parts[2];

          $key = array_search($check, $tempArray);
          if ($key !== false) {
            unset($tempArray[$key]);
          }
        }
      }

      // Reindexing the final result
      $newArray = array_values($tempArray);

      $this->db->trans_begin();

      foreach($newArray as $row)
      {
        $arr = explode('_', $row);

        $pdar_id  = $arr[0];
        $dag_no   = $arr[1];
        $table_id = $arr[2];

        // get pdar name and guardian name from settlement applicant
        $getName = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND id=?", array($case_no, $table_id))->row();

        $pdar_name  = $getName->pdar_name;
        $pdar_gname = $getName->pdar_guardian;
        $is_appl    = $getName->is_applicant;

        // insert into teagrant_is_mutated
        $insArr = [
          'case_no'            => $case_no,
          'service_code'       => $service_code,
          'dag_no'             => $dag_no,
          'sett_appl_id'       => $table_id,
          'pdar_name'          => $pdar_name,
          'pdar_guardian_name' => $pdar_gname,
          'is_applicant'       => $is_appl,
          'already_partitioned'=> 0,
          'chitha_pdar_id'     => $pdar_id,
          'created_at'         => date('Y-m-d H:i:s'),
        ];

        $insertIsMutated = $this->db->insert('teagrant_is_mutated', $insArr);

        if($insertIsMutated != 1)
        {
          $this->db->trans_rollback();
          log_message("error", "#ERR8576: Insertion failed in teagrant_is_mutated ".$this->db->last_query());
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR8576: Failed to save changes data !!!',
          ]);
          return;
        }
      }

      if(!empty($already_partitioned))
      {
        foreach($already_partitioned as $par)
        {
          $ar = explode('_', $par);
          $updateIsMutated = $this->db->query("UPDATE teagrant_is_mutated SET already_partitioned=? 
                                  WHERE case_no=? AND dag_no=? AND sett_appl_id=?", array(1, $case_no, $ar[0], $ar[1]));

          if($this->db->affected_rows() != 1)
          {
            $this->db->trans_rollback();
            log_message("error", "#ERR8704: Updation failed in teagrant_is_mutated ".$this->db->last_query());
            echo json_encode([
              'responseType' => 0,
              'msg'          => '#ERR8704: Failed to save changes data !!!',
            ]);
            return;
          }
        }
      }

      if(!empty($joint_appl_remove))
      {
        foreach($joint_appl_remove as $appl)
        {
          $ar = explode('_', $appl);

          // delete from settlment applicant
          $updateIsMutated = $this->db->query("UPDATE settlement_applicant SET case_no=? WHERE id=? AND is_applicant=? AND pdar_type=?", 
                                array($case_no.'_1', $ar[1], 0, 'B'));

          if($this->db->affected_rows() != 1)
          {
            $this->db->trans_rollback();
            log_message("error", "#ERR8741: Updation failed in settlement_applicant ".$this->db->last_query());
            echo json_encode([
              'responseType' => 0,
              'msg'          => '#ERR8741: Failed to save changes data !!!',
            ]);
            return;
          }

          // delete from teagrant_is_mutated
          $delete = $this->db->query("DELETE FROM teagrant_is_mutated WHERE dag_no=? AND sett_appl_id=? AND case_no=?", 
                        array($ar[0], $ar[1], $case_no));
          if($delete != 1)
          {
            $this->db->trans_rollback();
            log_message("error", "#ERR8777: DELETTION failed in settlement_applicant ".$this->db->last_query());
            echo json_encode([
              'responseType' => 0,
              'msg'          => '#ERR8777: Failed to save changes data !!!',
            ]);
            return;
          }
        }
      }

      // insert into settlement_proceeding
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", 
                        array($case_no))->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      if($this->session->userdata('user_desig_code') == 'ADC') { $office = 'ADC'; }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => "Response provided by the ADC regarding the mutation status of the applicant(s) in this application.",
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => $office,
        'office_to'            => $office,
        'task'                 => "Applicant(s) Status reviewed by $office",
        'note_type'            => "Changes made regarding the mutation status of the applicant(s) in this application.",
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) {
        log_message("error", "#ERR5433: Insertion failed in settlement_proceeding ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5433: Failed to save changes data !!!',
        ]);
        return;
      }

      $this->db->trans_commit();

      // get latest detail from 
      $latesRes = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case_no))->result();

      foreach($latesRes as $row)
      {
        if($row->chitha_pdar_id != 0)
        {
          if($row->already_partitioned == 1)
          {
            $message .= $row->dag_no.': '.$row->pdar_name.' The mutation and partition have already been completed. The next and only remaining step is the process of conversion.'."<br>";
          }
          else
          {
            $message .= $row->dag_no.': '.$row->pdar_name.' is already mutated. Outcome will be PARTITION, followed by a process of CONVERSION.'."<br>";
          }          
        }
        else if($row->chitha_pdar_id == 0)
        {
          $message .= $row->dag_no.': '.$row->pdar_name.' is not mutated. Outcome will be MUTATION with PARTITION, followed by a process of CONVERSION.'."<br>";
        }
      }

      echo json_encode([
        'responseType' => 2,
        'msg'          => 'Data has successfully saved...',
        'status_msg'   => $message,
      ]);
      return;
    }


    // view all first Proceeding case list KHAS ADC
    public function viewAllTeaGrantPendingListAtAdc()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $data['dist_code']        = $dist_code;
        $pendingCase = $this->TeaGrantAdcModel->getAllPendingCasesAtAdc($dist_code);

        
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAdcOutcome';
        $this->load->view('layouts/main', $data);

    }

    //pagination of first proceeding
    public function displayListOfCasesPendingAtAdc()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', 43);
        $this->db->where("settlement_basic.pending_officer IN ('ADC', 'DC')");
        $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
        $this->db->where('settlement_basic.case_no NOT IN (SELECT B.case_no FROM teagrant_is_mutated B)');

        
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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }
            if(!empty($remark_cat_lm)){  //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', 43);
            $this->db->where("settlement_basic.pending_officer IN ('ADC', 'DC')");
            $this->db->where('settlement_basic.adc_code', $this->session->userdata('user_code'));
            $this->db->where('settlement_basic.case_no NOT IN (SELECT B.case_no FROM teagrant_is_mutated B)');

            
            $query1 = $this->db->get();

            // echo $this->db->last_query();
            log_message("error", "firstProceedingPaginationAPI".$this->db->last_query());

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed by DC' : 'Processed by Dept';

                $co_remark ='';
                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                    if($rows->co_note_yn == $co_remark_cat->CODE){
                        $co_remark = $co_remark_cat->NAME;
                    }
                }
                // $lm_remark ='';
                // foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                //     if($rows->lm_note == $lm_remark_cat->CODE){
                //         $lm_remark = $lm_remark_cat->NAME;
                //     }
                // }


                $json[] = array(
                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'</span>',

                    // '<span style="font-size: 13px;">'.$lm_remark.'</span>',

                    '<span style="font-size: 13px;">'.$co_remark.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? '<span style="font-size: 13px;">'.'<a class="btn btn-success" href="'.base_url().'index.php/TeaGrantControllerAdc/getAllPendingTeaGrantApplicationDetailsAtAdc/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'">'.$this->lang->line('process').'</a></span>' : ''

                    // (DISABLE_ALL_BUTTON == 0) ? '<span style="font-size: 13px;">'.'<a class="btn btn-success" href="'.base_url().'index.php/TeaGrantControllerAdc/getAllPendingTeaGrantApplicationDetailsAtAdc/?case='.$rows->case_no.'">
                    //     '.$this->lang->line('process').'</a></span>' : ''

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
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }


    // settlement application details KHAS ADC
    public function getAllPendingTeaGrantApplicationDetailsAtAdc()
    {
        $case_no        = $this->input->get('case');
        $case_no        = $this->utilityclass->decryptJwtCase($case_no);

        $dist_code      = $this->session->userdata('dist_code');
        // $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
        // $this->checkCaseInModificationRequest($case_no);
        $application_no = $this->input->get('case');

        $application_no = $this->utilityclass->decryptJwtCase($application_no);

        $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);

        $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

        $adcdata           = [];
        $dags              = $this->TeaGrantModel->getSettlementDag($application_no);
        $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
        $proceedings       = $this->TeaGrantModel->getSettlementProceeding($application_no);
        $dhardocuments     = $this->TeaGrantModel->getDocuments($application_no);
        $nominee           = $this->TeaGrantModel->getAllNomineeDetail($application_no);
        $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
        $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($application_no);
        $family_tree       = $this->TeaGrantModel->getAllFamilyTree($application_no);

        $applier           = $this->TeaGrantModel->getApplierDetail($application_no);

        $mutatedApplList   = $this->TeaGrantModel->isApplicantMutated($application_no);
        $listOfChithaOwners= $this->TeaGrantModel->listOfChithaOwners($application_no);
        $mutatedCount      = $this->TeaGrantModel->getMutatedStatusCount($application_no)->num_rows();
        $mutatedStatus     = $this->TeaGrantModel->getMutatedStatusCount($application_no)->result();
        $mutatedStatusNo   = $this->TeaGrantModel->getMutatedStatusWithNo($application_no);

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
        $data['mutatedApplList']        = $mutatedApplList;
        $data['listOfChithaOwners']     = $listOfChithaOwners;
        $data['mutatedCount']           = $mutatedCount;
        $data['mutatedStatus']          = $mutatedStatus;
        $data['mutatedStatusNo']        = $mutatedStatusNo;

        
        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

        $data['chithaArea']    = $checkAreaDetails['chithaArea'];
        $data['reservedArea']  = $checkAreaDetails['reservedArea'];
        $data['areaCheck']     = $checkAreaDetails['areaCheck'];
        $data['appliedDags']   = $checkAreaDetails['appliedDags'];
        $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

        $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        $proceedings         = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
        $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
        $data['_view'] = 'TeaGrant/ADC/TeaGrantVerifyOutcomeOfCase';
        $this->load->view('layouts/main', $data);
        
    }


    public function saveMutationStatusWithNo()
    {
      $_POST         = json_decode(file_get_contents("php://input"), true);
      $case_no       = $this->input->post('case_no');
      $service_code  = $this->input->post('service_code');
      $is_mutated2   = $this->input->post('is_mutated2');

      // check if data alaready exist in the table
      $check = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case_no))->num_rows();
      if($check > 0)
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9360: Data already exist !!!',
        ]);
        return;
      }

      $this->db->trans_begin();

      // insert into teagrant_is_mutated
      $insArr = [
        'case_no'            => $case_no,
        'service_code'       => $service_code,
        'dag_no'             => 0,
        'sett_appl_id'       => 0,
        'pdar_name'          => null,
        'pdar_guardian_name' => null,
        'is_applicant'       => 0,
        'already_partitioned'=> 0,
        'chitha_pdar_id'     => 0,
        'created_at'         => date('Y-m-d H:i:s'),
        'option_choosen'     => 'NO',
      ];

      $insertIsMutated = $this->db->insert('teagrant_is_mutated', $insArr);
      // echo $this->db->last_query(); die;

      if($insertIsMutated != 1)
      {
        $this->db->trans_rollback();
        log_message("error", "#ERR9387: Insertion failed in teagrant_is_mutated ".$this->db->last_query());
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9387: Failed to save changes data !!!',
        ]);
        return;
      }

      // insert into settlement_proceeding
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", 
                        array($case_no))->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      if($this->session->userdata('user_desig_code') == 'ADC') { $office = 'ADC'; }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => "Response provided by the ADC regarding the mutation status of the applicant(s) in this application.",
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => $office,
        'office_to'            => $office,
        'task'                 => "Applicant(s) Status reviewed by $office",
        'note_type'            => "Changes made regarding the mutation status of the applicant(s) in this application.",
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) {
        log_message("error", "#ERR9424: Insertion failed in settlement_proceeding ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9424: Failed to save changes data !!!',
        ]);
        return;
      }

      $this->db->trans_commit();

      echo json_encode([
        'responseType' => 2,
        'msg'          => 'Data has successfully saved...',
        'status_msg'   => 'Outcome will be MUTATION with PARTITION, followed by a process of CONVERSION.',
      ]);
      return;
    }

    public function checkIfJointApplExist()
    {
      $_POST        = json_decode(file_get_contents("php://input"), true);
      $case_no      = $this->input->post('case_no');
      $service_code = $this->input->post('service_code');
      $is_mutated2  = $this->input->post('is_mutated2');

      // check if data alaready exist in the table
      $check = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case_no))->num_rows();
      if($check > 0)
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9477: Data already exist !!!',
        ]);
        return;
      }

      // check in settlement_applicant
      $settlAppl = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND is_applicant=? AND pdar_type=?",    
                    array($case_no, 0, 'B'));

      if($settlAppl->num_rows() == 0)
      {
        echo json_encode([
          'responseType' => 1,
          'msg'          => 'No Joint Applcant found !!!',
        ]);
        return;
      }

      echo json_encode([
        'responseType' => 2,
        'result'       => $settlAppl->result(),
        'msg'          => 'Joint applicant(s) have been found in this application. Does/Do the applicant(s) also have their name mentioned in the deed?',
      ]);
      return;

      // $this->db->trans_begin();
    }


    public function removeJointApplicantWithNoStatus()
    {
      $_POST        = json_decode(file_get_contents("php://input"), true);
      $case_no      = $this->input->post('case_no');
      $service_code = $this->input->post('service_code');
      $is_mutated2  = $this->input->post('is_mutated2');
      $joint_appl   = $this->input->post('joint_appl_remove');

      // if(empty($joint_appl))
      // {
      //   echo json_encode([
      //     'responseType' => 0,
      //     'msg'          => '#ERR9518: No joint applicant seleceted to remove !!!',
      //   ]);
      //   return;
      // }

      // check if data alaready exist in the table
      $check = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case_no))->num_rows();
      if($check > 0)
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9360: Data already exist !!!',
        ]);
        return;
      }

      $this->db->trans_begin();

      // insert into teagrant_is_mutated
      $insArr = [
        'case_no'            => $case_no,
        'service_code'       => $service_code,
        'dag_no'             => 0,
        'sett_appl_id'       => 0,
        'pdar_name'          => null,
        'pdar_guardian_name' => null,
        'is_applicant'       => 0,
        'already_partitioned'=> 0,
        'chitha_pdar_id'     => 0,
        'created_at'         => date('Y-m-d H:i:s'),
        'option_choosen'     => 'NO',
      ];

      $insertIsMutated = $this->db->insert('teagrant_is_mutated', $insArr);
      // echo $this->db->last_query(); die;

      if($insertIsMutated != 1)
      {
        $this->db->trans_rollback();
        log_message("error", "#ERR9548: Insertion failed in teagrant_is_mutated ".$this->db->last_query());
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9548: Failed to save changes data !!!',
        ]);
        return;
      }

      // update settlement_applicant
      if(!empty($joint_appl))
      {
        foreach($joint_appl as $appl)
        {
          $ar = explode('_', $appl);

          // delete from settlment applicant
          $updateIsMutated = $this->db->query("UPDATE settlement_applicant SET case_no=? WHERE id=? AND is_applicant=? AND pdar_type=?", 
                                array($case_no.'_1', $ar[1], 0, 'B'));

          if($this->db->affected_rows() != 1)
          {
            $this->db->trans_rollback();
            log_message("error", "#ERR9579: Updation failed in settlement_applicant ".$this->db->last_query());
            echo json_encode([
              'responseType' => 0,
              'msg'          => '#ERR9579: Failed to save changes data !!!',
            ]);
            return;
          }
        }
      }


      // insert into settlement_proceeding
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", 
                        array($case_no))->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      if($this->session->userdata('user_desig_code') == 'ADC') { $office = 'ADC'; }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => "Response provided by the ADC regarding the mutation status of the applicant(s) in this application.",
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => $office,
        'office_to'            => $office,
        'task'                 => "Applicant(s) Status reviewed by $office",
        'note_type'            => "Changes made regarding the mutation status of the applicant(s) in this application.",
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) {
        log_message("error", "#ERR9619: Insertion failed in settlement_proceeding ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR9619: Failed to save changes data !!!',
        ]);
        return;
      }

      $this->db->trans_commit();

      echo json_encode([
        'responseType' => 2,
        'msg'          => 'Data has successfully saved...',
        'status_msg'   => 'Outcome will be MUTATION with PARTITION, followed by a process of CONVERSION.',
      ]);
      return;
    }

    public function viewAllPendingCasesAtAdcForDocUpload()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getAllPendingCasesAtAdcForDocUpload($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAllPendingCasesAtAdcForDocUpload';
        $this->load->view('layouts/main', $data);
    }


    public function allPendingCasesAtAdcForDocUpload()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $upload_doc = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="upload_document_tea_grant(\''.$rows->case_no.'\')">Upload Document</button>';

                $button = $appl_view_btn.'&nbsp;'.$upload_doc;


                $json[] = array(

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function loadViewForDocumentUpload()
    {
        $case_no         = $this->input->post('case_no');
        $data['case_no'] = $this->input->post('case_no');
        $this->load->view('TeaGrant/ADC/TeaGrantLoadModalDocumentUpload', $data);
    }

    public function multipleFileSave()
    {
        log_message('error', json_encode($_POST));
        // $this->checkUserLoginOrNot();
        header('content-type:application/json');
        $documents_config = json_decode(MULTIPLE_FILE_UPLOAD_MAX);
        $validations      = [];
        $document_details = [];
        log_message("error", "------------FILE validation STARTED------------- " . ',config=' . json_encode($documents_config));
        foreach ($documents_config as $key => $value) {
            $return = $this->fileManualValidation($value);
            if (! is_null($return)) {
                $return['status'] == 1 ? $validations[] = $return['validation'] : $document_details[] = $return['data'];
            }
        }
        if (! empty($validations)) {
            echo json_encode([
                'responseType' => 1,
                'validation'   => $validations,
            ]);
            return;
        }
        // NOW STORE THE FILE
        $application_id = $_POST['application_id'];
        $doc_name       = $_POST['doc_name'];

        $basundhar_app  = $this->db->where('dharitree', $application_id)->get('basundhar_application')->row();
        $application_no = $basundhar_app->basundhara;

        $documents = [];
        $this->db->trans_begin();
        foreach ($document_details as $value) {
            log_message("error", "doc data" . json_encode($value));
            $file_new_name = str_replace("/", "_", $application_id) . '_' . time() . '.' . $value['extension'];
            $document      = [
                'case_no'         => $application_id,
                'file_path'       => UPLOAD_DIR . $file_new_name,
                'file_name'       => $doc_name,
                'user_code'       => $this->session->userdata('user_code'),
                'date_entry'      => date('Y-m-d H:i:s'),
                'file_type'       => $value['content_type'],
                'fetch_file_name' => $file_new_name,
                'mut_type'        => '01',
                'applid'          => $application_no,
            ];
            $status = $this->db->insert('supportive_document', $document);
            log_message("error", "insert doc status:" . json_encode($status));
            log_message("error", "last query" . json_encode($this->db->last_query()));
            log_message("error", "doc data" . json_encode($document));
            if (! move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR . $file_new_name)) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 3,
                    'error'        => 'Something Went wrong--1!!!',
                ]);
                return;
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 3,
                'error'        => 'Something Went wrong--2!!!',
            ]);
            return;
        } else {
            log_message("error", "------------FILE SAVE END------------- ");
            $this->db->trans_commit();
            //////////////////////////////////////
            $sql = "Select case_no,file_name,file_path,id from supportive_document  where case_no=? order by id desc limit 1";
            $row = $this->db->query($sql, [$application_id]);
            if ($row->num_rows() > 0) {
                $rowData = $row->row_array();
                echo json_encode([
                    'responseType'   => 2,
                    'application_id' => $application_id,
                    'doc_file'       => $rowData['file_name'],
                    'doc_id'         => $rowData['id'],
                    'file_path'      => $rowData['file_path'],
                ]);
                return;
            } else {
                echo json_encode([
                    'responseType' => 3,
                    'error'        => 'Something Went wrong--3!!!',
                ]);
                return;
            }
            /////////////////////////////////////
        }
    }

    public function selectDagArea()
    {
      //****getting the data  */
      $case_no = $this->input->post('case_no');
      $id      = $this->input->post('id');
      $dag_no  = $this->input->post('dag_no');

      $this->db->trans_begin();

      $this->db->select('*');
      $this->db->from('settlement_dag_details');
      $this->db->where('case_no', $case_no);
      $this->db->where('dag_no', $dag_no);
      $this->db->where('id', $id);
      $query = $this->db->get();

      // echo $this->db->last_query(); 

      if ($query->num_rows() > 0) {

        $data = $query->result_array();

        foreach ($data as $row) {

          $areaUpdateArr = [

            //****total dag area */
            'dag_area_b'    => $row['dag_area_b'],
            'dag_area_k'    => $row['dag_area_k'],
            'dag_area_lc'   => $row['dag_area_lc'],
            'dag_area_g'    => $row['dag_area_g'],
            'dag_area_kr'   => $row['dag_area_kr'],          

            's_dag_area_b'  => $row['applied_b'],
            's_dag_area_k'  => $row['applied_k'],
            's_dag_area_lc' => $row['applied_lc'],
            's_dag_area_g'  => $row['applied_g'],
            's_dag_area_kr' => $row['applied_kr'],
            
            'is_urban'      => $row['is_urban'],
          ];
        }
      }

      $data = array(
        'responseType' => 2,
        'appnData'     => $areaUpdateArr,
      );
      echo json_encode($data);
    }

    public function updateAreaDetails()
    {
      //****getting the data  */
      $case_no        = $this->input->post('area_update_case_no');
      $distCode       = $this->session->userdata('dist_code');
      $service_code   = TEA_SERVICE_CODE;
      $checkUrbanCon  = $this->input->post('area_update_urban_check');
      $land_area_type = $this->input->post('land_area_type');
      $id             = $this->input->post('area_update_id');
      $dag_no         = $this->input->post('area_update_dag_no');

      // var_dump($land_area_type); die;

      $mbLandNullArea = array(7, 8, 9, 10, 18, 20, 22);

      $totalHomeAreaLessaValidation = 0;
      $totalAgrAreaLessaValidation  = 0;
      $totalDagAreaLessaValidation  = 0;
      $totalDagAreaAppliedLessa     = 0;
      $appAreaMoreThanDagA          = 0;

      $get_old_area = $this->db->query("Select encroachement_area from settlement_dag_details where case_no='$case_no' and dag_no='$dag_no'")->row()->encroachement_area;

      $dag_details = $this->db->query("Select * from settlement_dag_details where case_no='$case_no' and dag_no='$dag_no'")->result();
      foreach ($dag_details as $dagone) {
        $area_name = $this->utilityclass->getAreaCategory($dagone->dist_code, $dagone->subdiv_code, $dagone->cir_code, $dagone->mouza_pargona_code, $dagone->lot_no, $dagone->vill_townprt_code, $dagone->dag_no);
      }

      //******backend validation */
      //***delimiter for not returning <p> tag */
      $this->form_validation->set_error_delimiters('', '');

      $singleAdditionalProToLessa = 0;
      $totalAdditionalProToLessa  = 0;

      $application_no        = $this->ncutility->getApplidFromCaseNo($case_no,$dag_no);
      $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
      $appliedDags           = $this->SettlementCommonModel->getAllAppliedDagsByApplicant($case_no,$dag_no);

      // var_dump($appliedDags); die;

      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
        foreach ($additional_properties as $singleProperty) {
          $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
          $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
          $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
          $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

          $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
          $totalAdditionalProToLessa += $singleAdditionalProToLessa;
        }

        foreach ($appliedDags as $appliedDag)
        {
          $appliedBighaAgri = 0;
          $appliedKathaAgri = 0;
          $appliedLessaAgri = 0;
          $appliedGandaAgri = 0;

          $appliedBighaHome = 0;
          $appliedKathaHome = 0;
          $appliedLessaHome = 0;
          $appliedGandaHome = 0;

          $singleAppliedAreaToLessaAgri = 0;
          $singleAppliedAreaToLessaHome = 0;

          $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
          $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
          $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);
          $appliedGandaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_ganda, 0);

          $singleAppliedAreaToLessaAgri = ($appliedBighaAgri * 6400) + ($appliedKathaAgri * 320) + ($appliedLessaAgri * 20) + $appliedGandaAgri;
          $singleAppliedAreaToLessaHome = ($appliedBighaHome * 6400) + ($appliedKathaHome * 320) + ($appliedLessaHome * 20) + $appliedGandaHome;

          $totalDagAreaAppliedLessa += ($singleAppliedAreaToLessaAgri + $singleAppliedAreaToLessaHome);
        }
      }
      else
      {
        foreach ($additional_properties as $singleProperty) {
          $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
          $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
          $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

          $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
          $totalAdditionalProToLessa += $singleAdditionalProToLessa;
        }

        // echo "<pre>";
        // var_dump($appliedDags); die;

        foreach ($appliedDags as $appliedDag)
        {
          $appliedBighaHome = 0;
          $appliedKathaHome = 0;
          $appliedLessaHome = 0;

          $singleAppliedAreaToLessaAgri = 0;
          $singleAppliedAreaToLessaHome = 0;

          $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
          $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
          $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);

          $singleAppliedAreaToLessaHome = ($appliedBighaHome * 100) + ($appliedKathaHome * 20) + $appliedLessaHome;
          $totalDagAreaAppliedLessa += $singleAppliedAreaToLessaHome;
        }
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
          $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
          $this->form_validation->set_rules('total_ganda_in_dag', 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('total_kranti_in_dag', 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
          $this->form_validation->set_rules('enc_ganda_home', 'Applied Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('enc_kranti_home', 'Applied Land Area  Homestead(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
          $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
          $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);
          $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0);

          $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_bigha_home'), 0);
          $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_katha_home'), 0);
          $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_lessa_home'), 0);
          $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0);

          $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
          $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;

          if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
          }

          $totalDagAreaLessaValidation += $dagAreaLessaValidation;
          $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
      }
      else
      {
          $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
          $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
          $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
          $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
          $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);

          $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_bigha_home'), 0);
          $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_katha_home'), 0);
          $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_lessa_home'), 0);

          $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
          $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;

          if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
          }

          $totalDagAreaLessaValidation += $dagAreaLessaValidation;
          $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
      }

      $totalEditArea = $totalHomeAreaLessaValidation;

      $editAreaNotMoreThenApplied = 0;
      if($totalEditArea > $totalDagAreaAppliedLessa)
      {
          $editAreaNotMoreThenApplied = 1;
      }

      if(EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1)
      {
        if ($editAreaNotMoreThenApplied == 1)
        {
          $this->form_validation->set_rules('editAreaNotMoreThenAppliedCheck', 'Total edit area should not more then total applied area !', 'required|callback_editAreaNotMoreThenAppliedCheck');
        }
      }

      if ($totalHomeAreaLessaValidation == 0)
      {
        $this->form_validation->set_rules('totalAppliedAreaZeroCheck', 'Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
      }
      if ($appAreaMoreThanDagA == 1)
      {
        $this->form_validation->set_rules('appAreaMoreThanDagA', 'Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
      }



      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
        if (CULTIVATION_MAX_APPLIED * 6400 < $totalHomeAreaLessaValidation) {

          $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
        }
        if ((CULTIVATION_MAX_APPLIED ) * 6400 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
          $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (CULTIVATION_MAX_APPLIED) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
        }
      }
      else
      {
        if (CULTIVATION_MAX_APPLIED * 100 < $totalHomeAreaLessaValidation) {
          $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
        }
        if ((CULTIVATION_MAX_APPLIED) * 100 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
          $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (CULTIVATION_MAX_APPLIED) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
        }
      }


      if ($this->form_validation->run() == false) {
        $data = array(
          'responseType' => 0,
          'msg'          => "#AREAUPDT0001:" . validation_errors() . "#case_no : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      $this->db->trans_begin();

      //****landType update HOMESTEAD/AGRICULTURE/BOTH */
      $homesteadLandExist = (float)$this->input->post('enc_bigha_home') + (float)$this->input->post('enc_katha_home') + (float)$this->input->post('enc_lessa_home') + (float)$this->input->post('enc_ganda_home') + (float)$this->input->post('enc_kranti_home');

      $landTypeUpdate = 0;
      if ($homesteadLandExist > 0) {
        $landTypeUpdate = 1;
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
          //***********actual Applied area ***************
          $actual_encroachment_area_home_lessa = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

          //***********total Actual Applied area*****************
          $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa;
          $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_lessa);
          // **********************************************

          //***********Settlement area that applicant will get settlement on***********
          $total_settlement_lessa_home = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

          //*****total Settlement area *************/
          $total_settlement_lessa = (float)$total_settlement_lessa_home;
          $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_lessa);

          //*************leftout area homestead**************
          $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
          $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeLessa);

          //**********Total left out area***************
          $totalLeftOutAreaLessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
          $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalLeftOutAreaLessa);
      } else {
          //********actual Applied area**********
          $actual_encroachment_area_home_lessa = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

          //***********total Actual Applied area*****************
          $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa ;
          $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
          // **********************************************

          //*******Settlement area that applicant will get settlement on**********
          $total_settlement_lessa_home = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

          //*************Total settlement area */
          $total_settlement_lessa = (float)$total_settlement_lessa_home;
          $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa);

          //****************leftout area homestead**************
          $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
          $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

          //**********Total left out area***************
          $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
          $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
      }

      // var_dump($total_settlement_lessa_home); die;
      //***Applied area update*/
      $encroachment_area = [
        'appliedArea' => [
          'bigha'   => $this->input->post('enc_bigha_home'),
          'katha'   => $this->input->post('enc_katha_home'),
          'lessa'   => $this->input->post('enc_lessa_home'),
          'ganda'   => $this->input->post('enc_ganda_home'),
          'kranti'  => $this->input->post('enc_kranti_home'),
        ],
      ];

      $areaUpdateArr = [
        //****total dag area */
        'dag_area_b'    => $this->input->post('total_bigha_in_dag'),
        'dag_area_k'    => $this->input->post('total_katha_in_dag'),
        'dag_area_lc'   => $this->input->post('total_lessa_in_dag'),
        'dag_area_g'    => $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
        'dag_area_kr'   => $this->UtilsModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),

        //*****Applied area */
        'encroachement_area'  => json_encode($encroachment_area),

        //*****settlement area */
        'home_b'        => 0,
        'home_k'        => 0,
        'home_lc'       => 0,
        'home_g'        => 0,
        'home_kr'       => 0,
        'agri_b'        => 0,
        'agri_k'        => 0,
        'agri_lc'       => 0,
        'agri_g'        => 0,
        'agri_kr'       => 0,

        'applied_b'     => $this->input->post('enc_bigha_home'),
        'applied_k'     => $this->input->post('enc_katha_home'),
        'applied_lc'    => $this->input->post('enc_lessa_home'),
        'applied_g'     => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'applied_kr'    => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),

        's_dag_area_b'  => $totalSettlementAreaArr[0],
        's_dag_area_k'  => $totalSettlementAreaArr[1],
        's_dag_area_lc' => $totalSettlementAreaArr[2],
        's_dag_area_g'  => $totalSettlementAreaArr[3],
        's_dag_area_kr' => 0,

        //****user info update */
        'user_code'     => $this->session->userdata('user_code'),
        'year_no'       => date('Y'),
        'date_entry'    => date('Y-m-d'),
        'land_type'     => $landTypeUpdate,
      ];

      $this->db->where('case_no', $case_no);
      $this->db->where('id', $id);
      $this->db->where('dag_no', $dag_no);
      $this->db->update('settlement_dag_details', $areaUpdateArr);

      // echo $this->db->last_query();
      //*******check if data updated */
      if ($this->db->affected_rows() != 1) {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS3658: Update fail in settlement_dag_details ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS3658: Update fail in settlement_dag_details : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      //checking settlement--reservation or not=====
      $total_settlement_reservation = 0;
      $reservation = $this->db->query("Select * from settlement_reservation where case_no='$case_no' and dag_no='$dag_no' and is_deleted =0")->row();
      if(!empty($reservation))
      {
        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            $total_settlement_lessa_home = $this->ncutility->Total_ganda($reservation->bigha, $reservation->katha, $reservation->lessa, $reservation->ganda);
              $total_settlement_reservation = (float)$total_settlement_lessa_home;

        } else {

            $total_settlement_lessa_home = $this->ncutility->Total_Lessa($reservation->bigha, $reservation->katha, $reservation->lessa);
              //*************Total settlement area */
            $total_settlement_reservation = (float)$total_settlement_lessa_home;
              
        }
      }
      if(in_array($distCode, json_decode(BARAK_VALLEY))) {
        $total_settlement_lessa = $total_settlement_lessa;
      }else{
        $total_settlement_lessa = $total_settlement_lessa;
      }

      $total_settlement_lessa = $total_settlement_lessa - $total_settlement_reservation;
      if($total_settlement_lessa <= 0)
      {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS5461: Update fail in settlement_dag_details ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS5461: Please verify the area details before proceed for the : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }
      /////////end reservation check////////
      

      //******* premium update start**************
      $this->db->select('*');
      $this->db->from('settlement_premium');
      $this->db->where('is_final', 1);
      $this->db->where('case_no', $case_no);
      $this->db->where('dag_no', $dag_no);
      $query = $this->db->get();

      // echo $this->db->last_query(); die;

      if ($query->num_rows() > 0) {
        $data = $query->result_array();

        foreach ($data as $row) {

          $this->db->set('is_final', 0);
          $this->db->where('is_final', 1);
          $this->db->where('case_no', $case_no);
          $this->db->where('dag_no', $dag_no);
          $this->db->update('settlement_premium');

          if ($this->db->affected_rows() == 0)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET5000311: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET5000311: Failed to update area detail for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }

          $dag_amount          = ($row['amount_dag'] / $row['total_lessa']) * $total_settlement_lessa;
          $final_amount        = ($row['final_amount'] - $row['amount_dag']) + $dag_amount;

          $row['amount_dag']   = $dag_amount;
          $row['final_amount'] = $final_amount;
          $row['due_amount']   = $final_amount;
          $row['total_lessa']  = $total_settlement_lessa;
          $row['user_code']    = $this->session->userdata('user_code');
          $row['date_entry']   = date('Y-m-d H:i:s');
          unset($row['pid']);
          $this->db->insert('settlement_premium', $row);

          if ($this->db->affected_rows() == 0)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET6000312: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET6000312: Failed to update area detail for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }

          $this->db->set('final_amount', $final_amount);
          $this->db->set('due_amount', $final_amount);
          $this->db->where('is_final', 1);
          $this->db->where('case_no', $case_no);
          // $this->db->where('dag_no', $dag_no);
          $this->db->update('settlement_premium');

          if ($this->db->affected_rows() == 0)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET7000313: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET7000313: Failed to update area detail for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }
        }

        if ($this->db->affected_rows() == 0)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET9000311: Premium Updation failed for Case No '.$case_no);
          $data = array(
            'error'=>"#ERRSET9000311: Failed to update area detail for case no : ".$case_no
          );
          echo json_encode($data);
          return false;
        }
      }

      //******* premium update end**************

      //*******insertion in settlement_area_history**************

      $settlementAreaHistoryArr = [
        'created_at'                            => date('Y-m-d'),
        //****Applied area */
        'actual_encroachment_area_home_bigha'   => $this->input->post('enc_bigha_home'),
        'actual_encroachment_area_home_katha'   => $this->input->post('enc_katha_home'),
        'actual_encroachment_area_home_lessa'   => $this->input->post('enc_lessa_home'),
        'actual_encroachment_area_home_ganda'   => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'actual_encroachment_area_home_kranti'  => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),

        'actual_encroachment_area_agri_bigha'   => 0,
        'actual_encroachment_area_agri_katha'   => 0,
        'actual_encroachment_area_agri_lessa'   => 0,
        'actual_encroachment_area_agri_ganda'   => 0,
        'actual_encroachment_area_agri_kranti'  => 0,

        //*****total Applied area */
        'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
        'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
        'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
        'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
        'total_actual_encroachment_area_kranti' => 0,
        //*******setttlement_area */
        'settlement_area_home_bigha'            => $this->input->post('enc_bigha_home'),
        'settlement_area_home_katha'            => $this->input->post('enc_katha_home'),
        'settlement_area_home_lessa'            => $this->input->post('enc_lessa_home'),
        'settlement_area_home_ganda'            => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'settlement_area_home_kranti'           => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),

        'settlement_area_agri_bigha'            => 0,
        'settlement_area_agri_katha'            => 0,
        'settlement_area_agri_lessa'            => 0,
        'settlement_area_agri_ganda'            => 0,
        'settlement_area_agri_kranti'           => 0,

        //*****total settlement_area */
        'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
        'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
        'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
        'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
        'total_settlement_area_kranti'          => 0,
        //******leftout area */
        'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
        'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
        'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
        'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
        'leftout_area_home_kranti'              => 0,
        'leftout_area_agri_bigha'               => 0,
        'leftout_area_agri_katha'               => 0,
        'leftout_area_agri_lessa'               => 0,
        'leftout_area_agri_ganda'               => 0,
        'leftout_area_agri_kranti'              => 0,
        //****total leftout area */
        'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
        'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
        'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
        'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
        'total_leftout_area_kranti'             => 0,
      ];

      $this->db->where('case_no', $case_no);
      $this->db->where('application_no', $application_no);
      $this->db->where('dag_no', $dag_no);
      $this->db->update('settlement_area_history', $settlementAreaHistoryArr);

      //*******check if data updated */
      if ($this->db->affected_rows() == 0) {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS3821: Update fail in settlement_area_history ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS3821: Failed to update area detail : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      // check if data already exist then update or insert
      $checkDataAvailability = $this->db->query("SELECT * FROM edited_area_by_adc_teagrant WHERE case_no=? AND dag_no=? AND is_final=?", 
                                [$case_no, $dag_no, 1]);

      if($checkDataAvailability->num_rows() > 0)
      {
        // update table
        $updateArea = [
          'is_final'   => 0,
          'updated_at' => date('Y-m-d H:i:s'),
        ];
        $whereArea = ['case_no' => $case_no, 'dag_no' => $dag_no, 'is_final' => 1,];
        $this->db->update('edited_area_by_adc_teagrant', $updateArea, $whereArea);

        if($this->db->affected_rows() != 1)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERR10606: Update fail in edited_area_by_adc_teagrant ' . $this->db->last_query());
          $data = array(
            'responseType' => 0,
            'msg'          => "#ERR10606: Failed to update area detail for case no : " . $case_no,
          );
          echo json_encode($data);
          return false;
        }
      }
      
      // insert table
      $ins = [
        'case_no'            => $case_no,
        'dag_no'             => trim($dag_no),
        'dag_area_b'         => $this->input->post('total_bigha_in_dag'),
        'dag_area_k'         => $this->input->post('total_katha_in_dag'),
        'dag_area_lc'        => $this->input->post('total_lessa_in_dag'),
        'dag_area_g'         => $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
        'dag_area_kr'        => $this->UtilsModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),
        'new_area_b'         => $this->input->post('enc_bigha_home'),
        'new_area_k'         => $this->input->post('enc_katha_home'),
        'new_area_lc'        => $this->input->post('enc_lessa_home'),
        'new_area_g'         => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'new_area_kr'        => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),
        'old_area'           => json_encode($get_old_area),
        'created_at'         => date('Y-m-d H:i:s'),
        'is_final'           => 1,
      ];
      $insertNewArea = $this->db->insert('edited_area_by_adc_teagrant', $ins);
      // echo $this->db->last_query();
      if($insertNewArea != 1)
      {
        $this->db->trans_rollback();
        log_message('error', '#ERR10641: Insertion fail in edited_area_by_adc_teagrant ' . $this->db->last_query());
        $data = array(
          'responseType' => 0,
          'msg'          => "#ERR10641: Failed to update area detail for case no : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => 'Area Updated',
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'ADC',
        'office_to'            => 'ADC',
        'task'                 => "ADC has changed the Area for Dag trim($dag_no)",
        'note_type'            => null,
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      // echo $this->db->last_query(); die();
      if ($insertProceeding != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
        $json = [
          'errorMessage' => "#ERRORPP: Failed to forward the case for Case No : " . $case_no,
        ];
        echo json_encode($json);
        return false;
      }
      //////proceeding end//////

      $this->db->trans_commit();

      //*****getting the total applied area from db to check if it exceeds any area conditions*/
      $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));

      if ($sql->num_rows() <= 0) {
        $this->db->trans_rollback();
        $data = array(
          'responseType' => 0,
          'msg'          => "#FETCH0001: Error in fetching data from settlement_dag_details ! . $case_no",
        );
        echo json_encode($data);
        return false;
      }

      $fresh_area_details = $sql->result();

      $total_settlement_home_lessa = 0;
      $total_settlement_home_ganda = 0;
      $total_settlement_agri_ganda = 0;
      $total_settlement_agri_lessa = 0;

      foreach ($fresh_area_details as $fresh_area) {

        $settlement_area_home_bigha = (float)$fresh_area->applied_b;
        $settlement_area_home_kahta = (float)$fresh_area->applied_k;
        $settlement_area_home_lessa = (float)$fresh_area->applied_lc;
        $settlement_area_home_ganda = (float)$fresh_area->applied_g;

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
          //****total settlement area in all dags */
          $total_settlement_home_ganda = $total_settlement_home_ganda + $this->ncutility->Total_ganda($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa, $settlement_area_home_ganda);
        } else {
          //****total settlement area in all dags */
          $total_settlement_home_lessa = $total_settlement_home_lessa + $this->ncutility->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa);
        }
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
        $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_home_ganda);
      } else {
        $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_home_lessa);
      }

      //**** if data intserted successfully*/
      $data = array(
        'responseType'            => 2,
        'totalSettlementAreaHome' => $total_settlement_area_home_formated,
        'totalSettlementAreaAgri' => 0,
        'appnData'                => $areaUpdateArr,
        'msg'                     => "Area updated successfully...",
      );
      echo json_encode($data);
    }


    public function loadViewForReGenerationOfGN()
    {
        $case_no                       = $this->input->post('case_no');
        $basic                         = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail']       = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $data['dagList']               = $this->TeaGrantAdcModel->getDagDetailsList($case_no);
        $data['mouza_name']            = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], 
                                            $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

        $data['village_name']          = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot(
                                            $basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], 
                                            $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']          = $this->TeaGrantAdcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']               = $this->input->post('case_no');
        $data['notice_generated_date'] = date('Y-m-d', strtotime($basic['notice_generated_date']));
        $data['next_date_of_hearing']  = date('Y-m-d', strtotime($basic['next_date_of_hearing']));
        $data['applicants_buyers']     = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
        $data['basic']                 = $this->TeaGrantModel->getSettlementBasic($case_no);

        $this->load->view('TeaGrant/ADC/TeaGrantLoadModalReGenerateGN', $data);
    }

    // re generate General Notice
    public function reGenerateGeneralNoticeTeaGrant()
    {
      $input = json_decode(file_get_contents("php://input"), true);

      $dist_code                   = $this->session->userdata('dist_code');
      $case_no                     = $input['case_no_notice'];
      $regen_preference            = $input['regen_preference'];
      $regen_old_notice_gen_date   = $input['regen_old_notice_gen_date'];
      $regen_old_next_hearing_date = $input['regen_old_next_hearing_date'];
      $regen_old_remarks           = $input['regen_old_remarks'];
      $regen_new_notice_gen_date   = $input['regen_new_notice_gen_date'];
      $regen_new_remarks           = $input['regen_new_remarks'];
      $recommend                   = $input['recommend'];

      // var_dump($recommend); die;

      if($regen_preference == null || $regen_preference == '')
      {
        echo json_encode(array(
          'responseType' => 4,
          'msg'          => '"Please select the hearing preference !!!',
        ));
        return;
      }
      if($recommend == null || $recommend == '')
      {
        echo json_encode(array(
          'responseType' => 4,
          'msg'          => 'Please select recommend / not recommend !!!',
        ));
        return;
      }

      $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
      $caseCount    = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
      // var_dump($caseCount); die;
      if ($caseCount == 0) {
        echo json_encode(array(
            'responseType' => 3,
        ));
        return;
      }
      else
      {
        $caseDetails     = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
        $applicantDetail = $this->TeaGrantAdcModel->getApplicantDetails($case_no);
        $get_dag_details = $this->TeaGrantAdcModel->getDagDetailsTenant($case_no);
        $get_dag_list    = $this->TeaGrantAdcModel->getDagDetailsList($case_no);

        $dist_name       = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
        $circle_name     = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
        $mouza_name      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
        $village_name    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
        $get_owners      = $this->TeaGrantAdcModel->getOwners($case_no);
        $get_buyers      = $this->TeaGrantAdcModel->getBuyers($case_no);
        $get_exist_pattadars = $this->TeaGrantAdcModel->getExistingPattadars($case_no);
        $get_deed_appls  = $this->TeaGrantAdcModel->getDeedApplicants($case_no);

        $notice_no = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;

        $tableData = '';
        $area_det  = '';
        $msg_area  = '';

        $dag_names_list  = '';

        foreach($get_dag_list as $r)
        {
          if (in_array($r->dist_code, json_decode(BARAK_VALLEY)))
          {
            $area_det  = 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' চ: '.$r->s_dag_area_lc.' গ: '.$r->s_dag_area_g;
            $msg_area .= $r->dag_no.' নং দাগৰ অংশ '.$r->s_dag_area_b.' বিঘা '.$r->s_dag_area_k.' কঠা '.$r->s_dag_area_lc.' চটক '.$r->s_dag_area_g.' গণ্ডা ';
          }
          else
          {
            $area_det = 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' লে: '.$r->s_dag_area_lc;
            $msg_area .= $r->dag_no.' নং দাগৰ অংশ '.$r->s_dag_area_b.' বিঘা '.$r->s_dag_area_k.' কঠা '.$r->s_dag_area_lc.' লেছা ';
          }
          $tableData .= "<tr>
            <td>".$this->utilityclass->getDistrictName($r->dist_code)."</td>
            <td>".$this->utilityclass->getCircleName($r->dist_code,$r->subdiv_code,$r->cir_code)."</td>
            <td>".$this->utilityclass->getMouzaName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code)."</td>
            <td>".$this->utilityclass->getLotName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code,$r->lot_no)."</td>
            <td>".$this->utilityclass->getVillageName($r->dist_code,$r->subdiv_code,$r->cir_code,$r->mouza_pargona_code,$r->lot_no,$r->vill_townprt_code)."</td>
            <td>".$r->patta_no."</td>
            <td>".$this->utilityclass->getPattaName($r->patta_type_code)."</td>
            <td>".$r->dag_no."</td>
            <td>".$area_det."</td>
          </tr>";


          // get all co pattadars from chitha
          $chitha_co_pattadar = $this->TeaGrantAdcModel->getChithaCoPattadars($r->dist_code, $r->subdiv_code, $r->cir_code, 
                                  $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code, $r->dag_no, $r->patta_no, 
                                    $r->patta_type_code);

          $names = array_map(function($row) {
              return $row->pdar_name;
          }, $chitha_co_pattadar);

          $name_string = implode(', ', $names);

          // Append to final variable
          $dag_names_list .= "Dag No: {$r->dag_no}: {$name_string}\n";                
        }   

        // var_dump($dag_names_list); die;

        // Convert to comma-separated string
        // $name_list = implode(', ', $name_list);    

        $adc_hearing_remarks = $regen_preference == 'OLD' ? $regen_old_remarks : $regen_new_remarks;
        $hearing_date        = $regen_preference == 'OLD' ? $regen_old_notice_gen_date : $regen_new_notice_gen_date;

        // var_dump("dsfghj"); die;

        echo json_encode(array(
          'responseType'        => 2,
          'case_no'             => $case_no,
          'hearing_date'        => date("F j, Y", strtotime($hearing_date)),
          'caseDetails'         => $caseDetails,
          'applicantName'       => $applicantDetail,
          'dist_name'           => $dist_name,
          'circle_name'         => $circle_name,
          'mouza_name'          => $mouza_name,
          'village_name'        => $village_name,
          'get_dag_details'     => $get_dag_list,
          'notice_no'           => $notice_no,
          'get_owners'          => $get_owners,
          'get_buyers'          => $get_buyers,
          'tableData'           => $tableData,
          'msg_area'            => $msg_area,
          'adc_hearing_remarks' => $adc_hearing_remarks,
          'existing_pattadars'  => $get_exist_pattadars,
          'deed_applicants'     => $get_deed_appls,
          'name_list'           => $dag_names_list,
          'regen_preference'    => $regen_preference,
          'recommend'           => $recommend,
          'regen_date'          => date("d/m/Y", strtotime($hearing_date)),
          'next_regen_date'     => date("F j, Y", strtotime('+15 days', strtotime($hearing_date)))
          ));
        return;
      }
      
    }

    // save re generated hearing remarks
    public function saveRegeneratedHearingRemarksByAdc()
    {
      $input = json_decode(file_get_contents("php://input"), true);
        
      $htmlstring_text  = json_encode($input['htmlstring_text']);
      $dist_code        = $this->session->userdata('dist_code');
      $hearing_date     = $input['hearingDate'];
      $case_no          = $input['case_no'];
      $hearing_remarks  = $input['hearing_remarks'];
      $regen_preference = $input['regen_preference'];
      $recommend_check  = $input['recommend_check'];

      $this->utilityclass->checkUserAuthForCaseForAdc($case_no);

      $caseCount       = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
      if ($caseCount == 0) {
          echo json_encode(array(
              'responseType' => 3,
          ));
          return;
      }
      else
      {
          $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
          $applicantDetails = $this->TeaGrantAdcModel->getAllApplicant($case_no);

          $sqlCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? and service_code = ?', array($case_no, 'GN', $caseDetails->service_code));

          if ($sqlCheck->num_rows() <= 0) {

              $notice_no = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;
              $new_case_no = $this->randomFileNameGeneral();

              if (is_dir(GENERAL_NOTICE_PATH_ADC) === false) {
                  mkdir(GENERAL_NOTICE_PATH_ADC, 0777);
              }

              $base_64_file_path    = GENERAL_NOTICE_PATH_ADC . $new_case_no . ".json";
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

              $this->db->trans_begin();

              // update prev general notice
              $update = $this->db->query("UPDATE settlement_notice SET case_no=? WHERE case_no=? AND notice_type=? 
                          AND service_code=?", [$case_no.'_1', $case_no, 'GN', '43']);
              if($this->db->affected_rows() != 1)
              {
                $this->db->trans_rollback();
                log_message('error', "#ERR11225: Update failed in settlement_notice for case no $case_no : ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => "#ERR11225: Unable to re-generate notice for case $case_no",
                ));
                return;
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
              
              $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
              if ($insertIntoSettlementNotice != 1) {
                  $this->db->trans_rollback();
                  log_message('error', "#ERRPN00678: Insertion failed in settlement_notice for case no $case_no : ".$this->db->last_query());
                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                  ));
                  return;
              }


              // insert into settlement_proceeding
              $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
              if($proceeding_id==null)
              {
                  $proceeding_id=1;
              }

              $recommend_remark = 'Recommendation checked as : '.$recommend_check.'. ';
              $regen_preference_remark = 'Regenerate with preference : '.$regen_preference. ' hearing date. ';           
              $new_hearing_remark = $hearing_remarks ?? 'Regenerated the general notice';

              $remarks = $recommend_remark.$regen_preference_remark.$new_hearing_remark;


              $insPetProceed = [
                  'case_no'              => $case_no,
                  'proceeding_id'        => $proceeding_id,
                  'date_of_hearing'      => date('Y-m-d H:i:s'),
                  'next_date_of_hearing' => date('Y-m-d H:i:s'),
                  'status'               => 'W',
                  'user_code'            => $this->session->userdata('user_code'),
                  'date_entry'           => date('Y-m-d H:i:s'),
                  'operation'            => 'E',
                  'note_on_order'        => $remarks,
                  'ip'                   => $this->utilityclass->get_client_ip(),
                  'office_from'          => MB_ADD_DEPUTY_COMM,
                  'office_to'            => MB_ADD_DEPUTY_COMM,
                  'task'                 => 'General notice re-generated'
              ];
              $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
              if($insertProceeding != 1)
              {
                  log_message("error", "#ERR4947: Insertion failed in settlement_proceeding for case $case_no : ".$this->db->last_query());
                  $this->db->trans_rollback();
                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                  ));
                  return;
              }

              $updateData = array(
                  'general_notice_dc'     => 'y',
                  'notice_generated_yn'   => 'y',
                  'notice_generated_date' => date('Y-m-d H:i:s'),
                  'next_date_of_hearing'  => $hearing_date,
                  'date_update'           => date('Y-m-d H:i:s'),
                  'dc_proceeding'         => 1,
                  'from_office'           => 'ADC',
              );
              if($this->TeaGrantAdcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                  log_message("error", "#ERR4963: Updation failed in settlement_basic for case $case_no : ".$this->db->last_query());
                  $this->db->trans_rollback();
                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR4963: Unable to generate notice for case $case_no",
                  ));
                  return;
              }

              $this->db->trans_commit();
              echo json_encode(array(
                  'responseType' => 2,
                  'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllTeaGrantFirstProceedingDcCaseList',
              ));
              return;
          }
          else
          {
              // echo "dsfghjkl"; die;
              $path = $sqlCheck->row()->notice_link;

              $notice_no = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;
              $new_case_no = $this->randomFileNameGeneral();

              if (is_dir(GENERAL_NOTICE_PATH_ADC) === false) {
                  mkdir(GENERAL_NOTICE_PATH_ADC, 0777);
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

              // update prev general notice
              $update = $this->db->query("UPDATE settlement_notice SET case_no=? WHERE case_no=? AND notice_type=? 
                          AND service_code=?", [$case_no.'_1', $case_no, 'GN', '43']);
              if($this->db->affected_rows() != 1)
              {
                $this->db->trans_rollback();
                log_message('error', "#ERR11352: Update failed in settlement_notice for case no $case_no : ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => "#ERR11352: Unable to re-generate notice for case $case_no",
                ));
                return;
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
              
              $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
              if ($insertIntoSettlementNotice != 1) {
                  $this->db->trans_rollback();
                  log_message('error', "#ERRPN00678: Insertion failed in settlement_notice for case no $case_no : ".$this->db->last_query());
                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                  ));
                  return;
              }

              $updateData = array(
                  'general_notice_dc'     => 'y',
                  'notice_generated_yn'   => 'y',
                  'notice_generated_date' => date('Y-m-d H:i:s'),
                  'next_date_of_hearing'  => $hearing_date,
                  'date_update'           => date('Y-m-d H:i:s'),
                  'from_office'           => 'ADC',
                  'pending_office'        => 'ADC',
              );
              if ($this->TeaGrantAdcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                  $this->db->trans_rollback();
                  log_message('error', "#ERR5034: Updation failed in settlement_basic for case no $case_no : ".$this->db->last_query());

                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR5034: Unable to generate notice for case $case_no",
                  ));
                  return;
              }

              // insert into settlement_proceeding
              $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
              if($proceeding_id==null)
              {
                  $proceeding_id=1;
              }

              $recommend_remark = 'Recommendation checked as : '.$recommend_check.'. ';
              $regen_preference_remark = 'Regenerate with preference : '.$regen_preference. ' hearing date. ';              
              $hearing_remark = $hearing_remarks == null ? 'Regenerated the general notice' : $hearing_remarks;

              $remarks = $recommend_remark.$regen_preference_remark.$hearing_remark;

              $insPetProceed = [
                  'case_no'              => $case_no,
                  'proceeding_id'        => $proceeding_id,
                  'date_of_hearing'      => date('Y-m-d H:i:s'),
                  'next_date_of_hearing' => date('Y-m-d H:i:s'),
                  'status'               => 'W',
                  'user_code'            => $this->session->userdata('user_code'),
                  'date_entry'           => date('Y-m-d H:i:s'),
                  'operation'            => 'E',
                  'note_on_order'        => $remarks,
                  'ip'                   => $this->utilityclass->get_client_ip(),
                  'office_from'          => MB_ADD_DEPUTY_COMM,
                  'office_to'            => MB_ADD_DEPUTY_COMM,
                  'task'                 => 'Updated general notice generated'
              ];
              $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
              if($insertProceeding != 1)
              {
                  log_message("error", "#ERR4947: Insertion failed in settlement_proceeding for case $case_no : ".$this->db->last_query());
                  $this->db->trans_rollback();
                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR4947: Unable to generate notice for case $case_no",
                  ));
                  return;
              }

              $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
              $basundhara = $this->db->query($sql)->row();

              // call api to upload notice
              $curl_handle = curl_init();
              curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
              curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                  'encoded_file'   => json_decode($htmlstring_text),
                  'application_no' => $basundhara->basundhara,
                  'type'           => 'GN',
                  'amount'         => 0,
                  'is_full_pay'    => 'N',
              )));
              $result = curl_exec($curl_handle);

              if (trim($result) != 'y') {
                  $this->db->trans_rollback();
                  log_message('error', "#ERR5063: Notice upload failed for case no $case_no : ".json_encode($result));

                  echo json_encode(array(
                      'responseType' => 1,
                      'message'      => "#ERR5063: Unable to generate notice for case $case_no",
                  ));
                  return;
              }
              else {
                  //////////////POST To basundhara/////////////////////
                  $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                  $rmk            = 'General notice generated';
                  $status         = 'M';
                  $task           = $this->session->userdata('user_desig_code');
                  $pen            = $this->session->userdata('user_desig_code');
                  $case           = $case_no;
                  $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                  $rtps_status    = json_decode($rtps_status);

                  if (trim($rtps_status) != "y")
                  {
                      $this->db->trans_rollback();
                      log_message('error', "#ERR5085: Api response failed for case no $case_no : ".json_encode($rtps_status));

                      echo json_encode(array(
                          'responseType' => 1,
                          'message'      => "#ERR5085: Unable to generate notice for case $case_no",
                      ));
                      return;
                  }
              }
              log_message("error", "#ERR5074 sdfgdfsbgfds" );
              $this->db->trans_commit();
              echo json_encode(array(
                  'responseType' => 2,
                  'redirect'     => base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
              ));
              return;
          }
      }        
    }

    public function fetchTotalPayment()
    {
      $json                    = array();
      $input                   = json_decode(file_get_contents("php://input"), true);
      $case_no                 = $input['case_no_notice'] ?? null;
      $new_zonal_value         = $input['new_zonal_value'] ?? null;
      $prev_zonal_value        = $input['prev_zonal_value'] ?? null;
      $dag_no                  = $input['dag_no'] ?? null;
      $percentage              = 10;
      $finalamount             = 0;
      $total_reservation_lessa = 0;

      // get details from dag details table
      $get_applied_area = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=? AND dag_no=?",
                            [$case_no, $dag_no])->row();

      // get details from reservation table
      $reservation = $this->db->query("SELECT * FROM settlement_reservation WHERE case_no=? AND dag_no=?", [$case_no, $dag_no]);

      if($reservation->num_rows() > 0)
      {
        $reserve_area = $reservation->row();
        if (in_array($reserve_area->dist_code, json_decode(BARAK_VALLEY))) 
        {
          $total_reservation_lessa = $this->utilityclass->Total_ganda($reserve_area->bigha, $reserve_area->katha, $reserve_area->lessa, $reserve_area->ganda);
        }
        else
        {
          $total_reservation_lessa = $this->utilityclass->Total_Lessa($reserve_area->bigha, $reserve_area->katha, $reserve_area->lessa);
        }
      }

      if (in_array($get_applied_area->dist_code, json_decode(BARAK_VALLEY))) {

        $area_in_bigha = 6400;

        $total_applied_lessa   = $this->utilityclass->Total_ganda($get_applied_area->applied_b, $get_applied_area->applied_k, $get_applied_area->applied_lc, $get_applied_area->applied_g);          

        $total_available_lessa = $total_applied_lessa - $total_reservation_lessa;

        $zonal_lessa = $new_zonal_value / $area_in_bigha;
        $premium     = $total_available_lessa * $zonal_lessa;
        $finalamount = ceil($premium * $percentage / 100);
      }
      else
      {
        $area_in_bigha = 100;

        $total_applied_lessa   = $this->utilityclass->Total_Lessa($get_applied_area->applied_b, $get_applied_area->applied_k, $get_applied_area->applied_lc);          

        $total_available_lessa = $total_applied_lessa - $total_reservation_lessa;

        $zonal_lessa = $new_zonal_value / $area_in_bigha;
        $premium     = $total_available_lessa * $zonal_lessa;
        $finalamount = ceil($premium * $percentage / 100);
      }

      $this->db->trans_begin();

      // get detail from edited_premium_recalc_teagrant
      $getDetail = $this->db->query("SELECT * FROM edited_premium_recalc_teagrant WHERE case_no=? AND dag_no=? AND is_final=?",
                    [$case_no, $dag_no, 1]);

      if($getDetail->num_rows() == 1)
      {
        // update prev info in edited_premium_recalc_teagrant
        $update = $this->db->query("UPDATE edited_premium_recalc_teagrant SET is_final=?, updated_at=? 
                    WHERE case_no=? AND dag_no=? AND is_final=?", [0, date('Y-m-d H:i:s'), $case_no, $dag_no, 1]);

        if($this->db->affected_rows() != 1)
        {
          $this->db->trans_rollback();
          log_message('error', "#ERR11574: Update failed in edited_premium_recalc_teagrant for Dag $dag_no : $case_no, ". $this->db->last_query());
          $json = [
            'responseType' => 1,
            'message'      => "#ERR11574: Failed to fetch the calculation for dag $dag_no",
          ];
          echo json_encode($json);
          return;
        }
      }

      // insert into edited_premium_recalc_teagrant
      $ins = [
        'case_no'          => $case_no,
        'dag_no'           => $dag_no,
        'prev_zonal_value' => $prev_zonal_value,
        'new_zonal_value'  => $new_zonal_value,
        'amount_dag'       => $finalamount,
        'total_lessa'      => $total_available_lessa,
        'is_final'         => 1,
        'created_at'       => date('Y-m-d H:i:s'),
      ];
      $insert = $this->db->insert('edited_premium_recalc_teagrant', $ins);
      if($insert != 1)
      {
        $this->db->trans_rollback();
        log_message('error', "#ERR11599: Insert failed in edited_premium_recalc_teagrant for Dag $dag_no : $case_no, ". $this->db->last_query());
        $json = [
          'responseType' => 1,
          'message'      => "#ERR11599: Failed to fetch the calculation for dag $dag_no",
        ];
        echo json_encode($json);
        return;
      } 
      $this->db->trans_commit();
      $json = [
        'responseType' => 2,
        'finalamount'  => $finalamount,
      ];
      echo json_encode($json);
      return;
    }

    public function getTotalPayment()
    {
      $json        = array();
      $input       = json_decode(file_get_contents("php://input"), true);
      $case_no     = $input['case_no'] ?? null;
      $finalamount = 0;

      // get details from settlement_premium table
      $get_total_dag = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=?", [$case_no]);

      // get details from edited_premium_recalc_teagrant table
      $history = $this->db->query("SELECT * FROM edited_premium_recalc_teagrant WHERE case_no=? AND is_final=?", 
                      [$case_no, 1]);

      if($get_total_dag->num_rows() != $history->num_rows())
      {
        log_message('error', "#ERR11632: Data count mismatched : $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR11632: Please click on fetch button for all Dags for premium recalculation !!!",
        ];
        echo json_encode($json);
        return;
      }

      $getFinalAmount = $this->db->query("SELECT sum(amount_dag) AS total_prem FROM edited_premium_recalc_teagrant 
                          WHERE case_no=? AND is_final=?", [$case_no, 1])->row()->total_prem;    

      $json = [
        'responseType'     => 2,
        'totalFinalAmount' => $getFinalAmount,
      ];
      echo json_encode($json);
      return;
    }



    public function viewAllAlreadyGeneratedPN()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getCountAlreadyGeneratedPN($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantAlreadyGeneratedPN';
        $this->load->view('layouts/main', $data);
    }

    public function listOfAlreadyGeneratedPN()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }

        // $this->db->select('*');

        $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
                settlement_basic.submission_date');

        $this->db->from('settlement_basic');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', $service);        
        $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('settlement_basic.status', 'N');
        $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->where('settlement_basic.dc_code is not null');
        $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
        // $this->db->where("settlement_basic.pay_notice_gn_date < '2025-08-08'");
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

        $this->db->where_in('settlement_basic.case_no', ['JOR/TIT/2024-25/39205/TGPP', 'JOR/TIT/2024-25/38920/TGPP']);

        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query();

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
                //$this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }

            $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, settlement_ap_lmnote.lm_note, settlement_basic.chitha_processing_details,
                settlement_basic.submission_date');

            $this->db->from('settlement_basic');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', $service);        
            $this->db->where('settlement_basic.pending_officer', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_basic.status', 'N');
            $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where('settlement_basic.dc_code is not null');
            $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            // $this->db->where("settlement_basic.pay_notice_gn_date < '2025-08-08'");
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

            $this->db->where_in('settlement_basic.case_no', ['JOR/TIT/2024-25/39205/TGPP', 'JOR/TIT/2024-25/38920/TGPP']);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Forward to Dept';

                $re_gen_payment_notice_btn = '<button title="Re-Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="re_gen_payment_notice_btn_tea_grant(\''.$rows->case_no.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16s-7.163 16-16 16m-4.313-21.938h.032c2.875.063 5.75-.062 8.625.063c.718 0 1.562.344 1.718 1.094c.25 1.75-1.218 3.344-2.812 3.75c-1.75.281-3.5.187-5.219.187a924 924 0 0 1-1.25 3.063c2.094 0 4.188.093 6.25-.219a8.71 8.71 0 0 0 6.344-5.688c.5-1.312.719-2.968-.281-4.124C24.25 7.125 22.75 7.125 21.5 7.03L12.937 7l-1.25 3.063zM8 10.906v.031l-1.375 3.438h10.188l1.343-3.469zm1.625 4.25h.031L6 24.531h3.469l3.687-9.375z"/></svg></button>';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $button = $appl_view_btn.'&nbsp;'.$re_gen_payment_notice_btn;


                $json[] = array(

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : ''

                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function viewAllRejectedCases()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantAdcModel->getCountRejectedCaseList($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/ADC/TeaGrantRejectedCaseList';
        $this->load->view('layouts/main', $data);
    }

    public function listOfRejectedCases()
    {
        $service        = $this->input->post('service');
        $by_case_no     = $this->input->post('case_no');
        $remark_cat     = $this->input->post('remark_cat');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $dist_code      = $this->session->userdata('dist_code');
        $subDiv_code    = $this->input->post('subdiv');
        $cir_code       = $this->input->post('circle');
        $mouza_code     = $this->input->post('mouza');
        $lot_no         = $this->input->post('lot');
        $village        = $this->input->post('vill_id');
        $ru             = $this->session->userdata('user_desig_code');

        $draw           = intval($this->input->post('draw'));
        $start          = intval($this->input->post('start'));
        $length         = intval($this->input->post('length'));
        $order          = $this->input->post('order');

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
            0 => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
        } else {
            $order = $valid_columns[$col];
        }
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)) {
            $this->db->where('settlement_basic.cir_code', $cir_code);
        }
        if(!empty($village)) {
            $this->db->where('settlement_basic.vill_townprt_code', $village);
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)) {
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }
        if(!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_basic.co_note_yn', $remark_cat);
        }

        // $this->db->select('*');

        $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, 
        settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, 
        settlement_basic.pending_officer, settlement_basic.submission_date');

        $this->db->from('settlement_basic');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.service_code', $service);        
        $this->db->where('settlement_basic.status', 'D');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query();

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
            if(!empty($remark_cat)){ 
                $this->db->where('settlement_basic.co_note_yn', $remark_cat);
            }

            $this->db->select('distinct(settlement_basic.case_no), settlement_basic.service_code, settlement_basic.applid, settlement_basic.dist_code, settlement_basic.subdiv_code, 
            settlement_basic.cir_code, settlement_basic.mouza_pargona_code, settlement_basic.lot_no, settlement_basic.vill_townprt_code, settlement_basic.date_entry, 
            settlement_basic.pending_officer, settlement_basic.submission_date');

            $this->db->from('settlement_basic');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.service_code', $service);        
            $this->db->where('settlement_basic.status', 'D');

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = null;

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerAdc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'&status=D" target="_view_appl">View Application</a>';

                $button = $appl_view_btn;


                $json[] = array(

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',
                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',
                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',
                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',
                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",
                    $rows->pending_officer,
                    $button
                );

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    protected function getReportedAreaByLra($case_no)
    {

        $res = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", [$case_no])->row();
        return $response = $this->db->query("select rural_urban from location where dist_code=? and subdiv_code=? and cir_code=? 
                                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?", [$res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code])->row()->rural_urban;
    }


    public function manualPaymentDetailsSubmitHandle()
    {
        //***********************************************************************/
        // file validation
        if (isset($_FILES['manual_chalan']['name'])) {
            if ($_FILES['manual_chalan']['name'] && $_FILES['manual_chalan']['size'] && $_FILES['manual_chalan']['tmp_name']) {
                $name = $_FILES['manual_chalan']['name'];
                $size = $_FILES['manual_chalan']['size'];
                $mime = mime_content_type($_FILES['manual_chalan']['tmp_name']);
                $exp = explode("/", $mime);
                $ext = $exp[1];
                if ($name != null) {
                    if ($ext == null) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#SMCPF001']);
                        exit;

                    }
                    if ($ext != 'pdf') {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#SMCPF002']);
                        exit;
                    }
                    if ($size > UPLOAD_MAX_SIZE) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#SMCPF003']);
                        exit;
                    }
                } else {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF004']);
                    exit;
                }
            } else {
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF005']);
                exit;
            }
        } else {
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF006']);
            exit;
        }
        //***********************************************************************/
        // post field validation
        $error_msg = array();
        $manual_challan_validation_arr = [
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]',
            ],
            [
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric',
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid',
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean',
            ],

        ];
        $this->form_validation->set_rules($manual_challan_validation_arr);
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
        if ($this->form_validation->run() == false) {
            foreach ($manual_challan_validation_arr as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************************************************************/
        $sql = "select applid from settlement_basic sb where case_no=?";
        $query = $this->db->query($sql, array($_POST['case_no']));
        if ($query->num_rows() != 1) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu0045']);
            exit;
        }

        $paymentDate = $_POST['payment_date'];
        if (date('Y-m-d H:i:s', strtotime(MANUAL_MAX_PAYMENT_DATE)) < date('Y-m-d H:i:s', strtotime($paymentDate))) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Payment date cannot be greater then ' . MANUAL_MAX_PAYMENT_DATE_SHOW]);
            exit;
        }

        $application_no = $query->row()->applid;
        $sql = "select pid,due_amount from settlement_premium where case_no=? and is_final=1";
        $query = $this->db->query($sql, array($_POST['case_no']));
        $result = $query->result();
        $sp_row_count = count($result);
        //***********************************************************************/
        if ($sp_row_count == 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu003']);
            exit;
        }
        //***********************************************************************/
        $due_amount = $result[0]->due_amount;
        $remaining_amount = (float) $due_amount - (float) $_POST['amount'];
        if ($remaining_amount > 0) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for institution is not allowed..!']);
            exit;
            // $is_full_pay = 'NO';
            // $percentage = '30';
            // //***************************************************************************/
            // //Rural Urban Checking
            // $sqlRU = "select area_name from settlement_premium where case_no=? and is_final=1";
            // $queryRU = $this->db->query($sqlRU, array($_POST['case_no']));
            // $resultRU = $queryRU->result();
            // foreach ($resultRU as $rowRU) {
            //     $area_name = trim((string) $rowRU->area_name);
            //     if ($area_name == '7' || $area_name == '8' || $area_name == '9' || $area_name == '10' || $area_name == '18' || $area_name == '19' || $area_name == '20' || $area_name == '21' || $area_name == '22') {
            //         echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for rural area is not allowed..!']);
            //         exit;
            //     }
            // }
            //***************************************************************************/
        } else {
            $is_full_pay = 'YES';
            $percentage = '100';
        }
        //***************************************************************** */
        //file moving section
        $file_new_name = "ins_echallan" . trim($_POST['grn_no']);
        $manual_challan_upload_dir = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name;
        $file_full_path = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name . ".pdf";
        move_uploaded_file($_FILES['manual_chalan']['tmp_name'], $file_full_path);
        if (!file_exists($file_full_path)) {
            log_message("error", "#smcuuf001, Error in moving file for the case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcuuf001']);
            exit;
        }
        //******************************************************************/
        $this->db->trans_begin();
        $sp_update_data = [
            'grn_no' => $_POST['grn_no'],
            'payment_date' => $_POST['payment_date'],
            'is_full_pay' => $is_full_pay,
            'total_premium' => $due_amount,
            'paid_amount' => $_POST['amount'],
            'remaining_amount' => $remaining_amount,
            'tenure' => '0',
            'installment_amount' => $remaining_amount / 5,
            'manual_challan_upload_dir' => $manual_challan_upload_dir,
            'manual_challan_details' => json_encode($_POST),
            'is_manual_challan' => 'Y',
        ];
        
        $this->db->where('case_no', $_POST['case_no'])
            ->where('is_final', 1)
            ->update('settlement_premium', $sp_update_data);

        if ($this->db->affected_rows() != $sp_row_count) {
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#smcu001, Error in update, table 'settlement_premium' with query :" . $this->db->last_query());
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu001']);
            exit;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message("error", "#smcu002, Transaction Status Error In manual challan update, settlement_premium tables for case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu002']);
            exit;
        } else {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => API_LINK_MB3 . 'updateManualPaymentDetails',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'application_no' => $application_no,
                    'grn_no' => $_POST['grn_no'],
                    'due_amount' => $due_amount,
                    'ip_address' => $this->utilityclass->get_client_ip(),
                    'payment_date' => $_POST['payment_date'],
                    'paid_amount' => $_POST['amount'],
                    'remaining_amount' => $remaining_amount,
                    'installment_amount' => $remaining_amount / 5,
                    'percentage' => $percentage,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($httpcode == 200) {
                $resp = json_decode($response);
                if ($resp->result == 'SUCCESS') {
                    $this->db->trans_commit();
                    echo json_encode(['result' => 'SUCCESS', 'msg' => 'Challan Details Updated Successfully..!']);
                    exit;
                } else {
                    echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0034']);
                    exit;
                }

            } else {
                echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0035']);
                exit;
            }
        }
    }


    public function getFinalVerificationData()
    {
        $case_no = $this->input->post('case_no');
        $basicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if ($basicSql->num_rows() <= 0) {
            log_message('error', '#ERR10263: No case number found!' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR10263: No case number found!',
            ]);
            return false;
        }

        $data['basicRow'] = $basicSql->row();

        if ($this->session->userdata('user_desig_code') != 'ADC') {
            if ($data['basicRow']->chitha_processing_details == 1) {
                // log_message('error', '#ERR10273: No case number found!'. $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR10273: Verification report already submitted!',
                ]);
                return false;
            }
        }


        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if ($getDagsSql->num_rows() <= 0) {
            log_message('error', '#ERR10285: Case not found in settlemnet_dag_details' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR10285: Dag details not found!',
            ]);
            return false;
        }

        $data['dagResult'] = $getDagsSql->result();

        foreach ($data['dagResult'] as $dagRow) 
        {
            //*****Get data if inserted */
            // if ($data['basicRow']->service_code == '14') {
            //     $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            // } else {
            $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            // }

            if ($getDagTransSql->num_rows() <= 0) {
                $data['basicRow']->new_inserted_patta_type_code = false;
                $data['basicRow']->new_inserted_possession_from = false;
                $dagRow->new_inserted_landclass_home = false;
                $dagRow->new_inserted_landclass_agri = false;
                $dagRow->new_inserted_land_mark_with_code = false;

                $dagRow->new_agri_land_revenue = false;
                $dagRow->new_home_land_revenue = false;
                $dagRow->new_agri_land_local_tax = false;
                $dagRow->new_home_land_local_tax = false;
            } else {
                $appRowData = $getDagTransSql->row();

                $data['basicRow']->new_inserted_patta_type_code = $appRowData->patta_type_code;
                $data['basicRow']->new_inserted_possession_from = $appRowData->possession_from;

                /////newly added--
                $data['basicRow']->land_purpose = $appRowData->land_purpose;
                $data['basicRow']->other_land_purpose = $appRowData->other_land_purpose;
                $data['basicRow']->existing_land_type = $appRowData->existing_land_type;


                $dagRow->new_inserted_landclass_home = $appRowData->landclass_home;
                $dagRow->new_inserted_landclass_agri = $appRowData->landclass_agri;

                $dagRow->new_agri_land_revenue = $appRowData->new_agri_land_revenue;
                $dagRow->new_home_land_revenue = $appRowData->new_home_land_revenue;
                $dagRow->new_agri_land_local_tax = $appRowData->new_agri_land_local_tax;
                $dagRow->new_home_land_local_tax = $appRowData->new_home_land_local_tax;

                $land_mark_ent = json_decode($appRowData->landmark_with_code);

                $dagRow->landmark_dist_east = $land_mark_ent->east->dist_code;
                $dagRow->landmark_subdiv_east = $land_mark_ent->east->subdiv_code;
                $dagRow->landmark_cir_east = $land_mark_ent->east->cir_code;
                $dagRow->landmark_mouza_east = $land_mark_ent->east->mouza_pargona_code;
                $dagRow->landmark_lot_east = $land_mark_ent->east->lot_no;
                $dagRow->landmark_village_east = $land_mark_ent->east->vill_townprt_code;
                $dagRow->landmark_dag_east = $land_mark_ent->east->dag_no;

                $dagRow->landmark_dist_west = $land_mark_ent->west->dist_code;
                $dagRow->landmark_subdiv_west = $land_mark_ent->west->subdiv_code;
                $dagRow->landmark_cir_west = $land_mark_ent->west->cir_code;
                $dagRow->landmark_mouza_west = $land_mark_ent->west->mouza_pargona_code;
                $dagRow->landmark_lot_west = $land_mark_ent->west->lot_no;
                $dagRow->landmark_village_west = $land_mark_ent->west->vill_townprt_code;
                $dagRow->landmark_dag_west = $land_mark_ent->west->dag_no;

                $dagRow->landmark_dist_north = $land_mark_ent->north->dist_code;
                $dagRow->landmark_subdiv_north = $land_mark_ent->north->subdiv_code;
                $dagRow->landmark_cir_north = $land_mark_ent->north->cir_code;
                $dagRow->landmark_mouza_north = $land_mark_ent->north->mouza_pargona_code;
                $dagRow->landmark_lot_north = $land_mark_ent->north->lot_no;
                $dagRow->landmark_village_north = $land_mark_ent->north->vill_townprt_code;
                $dagRow->landmark_dag_north = $land_mark_ent->north->dag_no;

                $dagRow->landmark_dist_south = $land_mark_ent->south->dist_code;
                $dagRow->landmark_subdiv_south = $land_mark_ent->south->subdiv_code;
                $dagRow->landmark_cir_south = $land_mark_ent->south->cir_code;
                $dagRow->landmark_mouza_south = $land_mark_ent->south->mouza_pargona_code;
                $dagRow->landmark_lot_south = $land_mark_ent->south->lot_no;
                $dagRow->landmark_village_south = $land_mark_ent->south->vill_townprt_code;
                $dagRow->landmark_dag_south = $land_mark_ent->south->dag_no;
            }

            // $old_dag = $dagRow->dag_no;
            $dagRow->old_dag = $dagRow->dag_no;



            $landclass = $this->utilityclass->classCodeFromChitha($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no);
            if ($landclass) {
                $className = $this->utilityclass->getLandClassCode($landclass);
            }

            $dagRow->old_class_name = $className;

            $premium_data_sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->old_dag));

            if ($premium_data_sql->num_rows() <= 0) {
                log_message('error', '#ERR10313: Case not found in settlement_premium' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR10313: Premium data not found!',
                ]);
                return false;
            }

            $premiumRow = $premium_data_sql->row();

            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
            } else {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
            }

            $landmark = json_decode($dagRow->landmark);

            $dagRow->landmark_entered = 'East - ' . $landmark->east . ', West - ' . $landmark->west . ', North - ' . $landmark->north . ', South - ' . $landmark->south;

            //******reservation area details */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->old_dag));

            if ($reservation->num_rows() <= 0) {
                $dagRow->road_side_reservation = false;
            } else {
                $reservation = $reservation->result();

                foreach ($reservation as $reservationRow) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
                    } else {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
                    }
                }
            }

            //********find out agri or home dag */
            $landType = 0;

            // $home_b = $dagRow->home_b;
            // $home_k = $dagRow->home_k;
            // $home_lc = $dagRow->home_lc;
            // $home_g = $dagRow->home_g;

            // $homestead = $home_b + $home_k + $home_lc + $home_g;

            // if ($homestead > 0) {
            //     $landType = 1;
            // }

            // $agri_b = $dagRow->agri_b;
            // $agri_k = $dagRow->agri_k;
            // $agri_lc = $dagRow->agri_lc;
            // $agri_g = $dagRow->agri_g;

            // $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            // if ($agriculture > 0) {
            //     $landType = 2;
            // }

            // if ($homestead > 0 && $agriculture > 0) {
            //     $landType = 3;
            // }

            // $dagRow->landTypeFinal = $landType;

        }

        $data['dist_array'] = [
            ['dist_code' => '24', 'dist_name' => 'কামৰূপ মহানগৰ ( Kamrup Metro )'],
            ['dist_code' => '12', 'dist_name' => 'লক্ষীমপূৰ ( Lakhimpur )'],
            ['dist_code' => '16', 'dist_name' => 'শিৱসাগৰ ( Sibsagar )'],
            ['dist_code' => '18', 'dist_name' => 'তিনিচুকীয়া ( Tinsukia )'],
            ['dist_code' => '34', 'dist_name' => 'মাজুলী ( Majuli )'],
            ['dist_code' => '37', 'dist_name' => 'চৰাইদেউ ( Charaideo )'],
            ['dist_code' => '11', 'dist_name' => 'শোণিতপুৰ ( Sonitpur )'],
            ['dist_code' => '25', 'dist_name' => 'ধেমাজি ( Dhemaji )'],
            ['dist_code' => '35', 'dist_name' => 'বিশ্বনাথ ( Biswanath )'],
            ['dist_code' => '03', 'dist_name' => 'গোৱালপাৰা ( Goalpara )'],
            ['dist_code' => '14', 'dist_name' => 'গোলাঘাট ( Golaghat )'],
            ['dist_code' => '13', 'dist_name' => 'বঙাইগাঁও ( Bongaigaon )'],
            ['dist_code' => '08', 'dist_name' => 'দৰং ( Darrang )'],
            ['dist_code' => '17', 'dist_name' => 'ডিব্ৰুগড় ( Dibrugarh )'],
            ['dist_code' => '36', 'dist_name' => 'হোজাই ( Hojai )'],
            ['dist_code' => '32', 'dist_name' => 'মৰিগাওঁ ( Morigaon )'],
            ['dist_code' => '39', 'dist_name' => 'বজালী ( Bajali )'],
            ['dist_code' => '15', 'dist_name' => 'যোৰহাট ( Jorhat )'],
            ['dist_code' => '21', 'dist_name' => 'করিমগঞ্জ ( Karimganj )'],
            ['dist_code' => '10', 'dist_name' => 'ছিৰাং ( Chirang )'],
            ['dist_code' => '22', 'dist_name' => 'Hailakandi'],
            ['dist_code' => '23', 'dist_name' => 'Cachar'],
            ['dist_code' => '38', 'dist_name' => 'দক্ষিণ শালমাৰা ( South Salmara )'],
            ['dist_code' => '02', 'dist_name' => 'ধুবুৰী ( Dhubri )'],
            ['dist_code' => '05', 'dist_name' => 'বৰপেটা  ( Barpeta )'],
            ['dist_code' => '27', 'dist_name' => 'Udalguri'],
            ['dist_code' => '33', 'dist_name' => 'নগাওঁ ( Nagaon )'],
            ['dist_code' => '06', 'dist_name' => 'নলবাৰী ( Nalbari )'],
            ['dist_code' => '07', 'dist_name' => 'কামৰূপ ( Kamrup )'],
            ['dist_code' => '01', 'dist_name' => 'কোকৰাঝাৰ (Kokrajhar)'],
        ];

        $data['user_data'] = [
            'user_dist_code' => $this->session->userdata('dist_code'),
            'user_subdiv_code' => $this->session->userdata('subdiv_code'),
            'user_cir_code' => $this->session->userdata('cir_code'),
            'user_mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'user_lot_no' => $this->session->userdata('lot_no'),
        ];

        // $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();

        // $data['land_class_code'] = $this->SettlementInsModel->getLandGroups(); 
        // $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where settlement = ?", 'y')->result();
        // $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'))->result();


        $data['patta_details'] = $this->db->query("SELECT id, name FROM patta_code_groups where id in (1,2,6)")->result();

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($case_no, $case_no));

        if ($nominee->num_rows() <= 0) {
            $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($application_no, $application_no));
        }

        if ($nominee->num_rows() <= 0) {
            $data['nominee'] = false;
        } else {
            $data['nominee'] = $nominee->result();

            foreach ($data['nominee'] as $nomRow) {
                $nomRow->relation_decoded = $this->utilityclass->getrelationByID($nomRow->relation);
            }
        }

        $addededNomSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

        if ($addededNomSql->num_rows() <= 0) {
            $data['transactionNom'] = false;
        } else {
            $data['transactionNom'] = $addededNomSql->result();

            foreach ($data['transactionNom'] as $nomTranRow) {
                $nomTranRow->relation_decoded = $this->utilityclass->getrelationByID($nomTranRow->relation);
            }

        }

        echo json_encode($data);

    }

    public function adcApproveLmReport()
    {
        $case_no = $this->input->post('case_no');
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        $this->db->trans_begin();

        //****insert nominee OR delete nominee if AVAIL*/
        $sqlNominee = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

        $nomineeCount = 0;

        

        //****insert dag related DATA */
        $approvSql = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));

        if ($approvSql->num_rows() <= 0) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2293: Unable to approve report!',
            ]);
            return false;
        }

        $approvResult = $approvSql->result();

        $approvalCount = count($approvResult);

        foreach ($approvResult as $approvRow) {

            // if ($getBasicSql->service_code != '18') {
                // if (trim($approvRow->patta_type_code) == '0203') {
                //     $this->db->trans_rollback();
                //     echo json_encode([
                //         'responseType' => 0,
                //         'msg' => '#ERR36456: বিশেষ ম্যাদী patta type is only allowed in Special Cultivation!',
                //     ]);
                //     return false;
                // }
            // }

            // if ($getBasicSql->service_code == '14') {
            //     $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and new_dag_no = ?', array($case_no, $approvRow->dag_no));
            // } else {
            $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and dag_no = ?', array($case_no, $approvRow->dag_no));
            // }

            if ($getDagsSql->num_rows() <= 0) {
                log_message('error', '#ERR7710285: Case not found in settlement_dag_details' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR7710285: Dag details not found!',
                ]);
                return false;
            }

            $dagRow = $getDagsSql->row();
            $landType = 0;

            // $home_b = $dagRow->home_b;
            // $home_k = $dagRow->home_k;
            // $home_lc = $dagRow->home_lc;
            // $home_g = $dagRow->home_g;

            // $homestead = $home_b + $home_k + $home_lc + $home_g;

            // if ($homestead > 0) {
            //     $landType = 1;
            // }

            // $agri_b = $dagRow->agri_b;
            // $agri_k = $dagRow->agri_k;
            // $agri_lc = $dagRow->agri_lc;
            // $agri_g = $dagRow->agri_g;

            // $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            // if ($agriculture > 0) {
            //     $landType = 2;
            // }

            // if ($homestead > 0 && $agriculture > 0) {
            //     $landType = 3;
            // }

            // if ($landType != 3) {
            //     if (empty($approvRow->landclass_home) && empty($approvRow->landclass_agri)) {
            //         echo json_encode([
            //             'responseType' => 0,
            //             'msg' => '#ERR774912: Please Enter landclass...',
            //         ]);
            //         return false;
            //     }
            // } else {
            //     if (empty($approvRow->landclass_home) || empty($approvRow->landclass_agri)) {
            //         echo json_encode([
            //             'responseType' => 0,
            //             'msg' => '#ERR997912: Please Enter both landclass...',
            //         ]);
            //         return false;
            //     }
            // }

            $updateDagArr = [
                'new_patta_type' => $approvRow->patta_type_code,
                'new_possession' => $approvRow->possession_from,
                'new_land_class_home' => $approvRow->landclass_home,
                'new_land_class_agri' => $approvRow->landclass_agri,
                'landmark' => $approvRow->landmark,
                'landmark_with_code' => $approvRow->landmark_with_code,
                'new_home_land_revenue' => $approvRow->new_home_land_revenue,
                'new_agri_land_revenue' => $approvRow->new_agri_land_revenue,
                'new_home_land_local_tax' => $approvRow->new_home_land_local_tax,
                'new_agri_land_local_tax' => $approvRow->new_agri_land_local_tax,
                'new_total_revenue' => $approvRow->new_total_revenue,
                'new_total_tax' => $approvRow->new_total_tax,
                'new_existing_land_type' => $approvRow->existing_land_type,
                'new_other_purpose' => $approvRow->other_land_purpose
            ];

            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $approvRow->dag_no);

            $this->db->update('settlement_dag_details', $updateDagArr);
            if ($this->db->affected_rows() != 1) {
                // echo $this->db->last_query();
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2320: Unable to approve report!',
                ]);
                return false;
            }
        }

        $approvSqlD = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));
        $approvResultD = $approvSqlD->row();
        $land_purpose_approved = $approvResultD->land_purpose;

        //****udpate basic status */
        $basicArr = [
            'chitha_processing_details' => 2,
            'date_update' => date('Y-m-d H:i:s'),
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2341: Unable to approve report!',
            ]);
            return false;
        }

        //****udpate basic status */        

        //*****delete from transaction table */
        // $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));
        // if ($this->db->affected_rows() != $approvalCount) {
        //     $this->db->trans_rollback();
        //     echo json_encode([
        //         'responseType' => 0,
        //         'msg' => '#ERR2353: Unable to approve report!',
        //     ]);
        //     return false;
        // }


        //*****insert into proceeding */
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
            'note_on_order' => 'Verification report approved',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'ADC',
            'office_to' => 'CO',
            'task' => 'LRA Verification report approved',
            // 'note_type' => $this->input->post('lm_note'),
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2403: Unable to approve report!',
            ]);
            return false;
        }

        $getPremiumStatus = $this->db->query('select payment_date from settlement_premium where case_no = ? and is_final = 1 and grn_no is not null', array($case_no, 1));

        // if ($getPremiumStatus->num_rows() > 0) {
        //     $premiumDate = $getPremiumStatus->row()->payment_date;

        //     $token = $this->utilityclass->createTokenJwt();
        //     //******send premium date */
        //     $curl_handle = curl_init();
        //     curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "insertSwikritiIssueDate");
        //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //         'appl_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
        //         'co_approve_date' => date('Y-m-d H:i:s'),
        //         'ip' => $this->utilityclass->get_client_ip(),
        //         'api_key' => API_KEY,
        //         'token' => $token,
        //     )));
        //     $result = curl_exec($curl_handle);

        //     $result = json_decode($result);

        //     if (trim($result->responseType) != 'y') {
        //         $this->db->trans_rollback();
        //         echo json_encode([
        //             'responseType' => 0,
        //             'msg' => '#ERR2701: Unable to approve report!',
        //         ]);
        //         return false;
        //     }
        // }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Report successfully approved...',
        ]);

    }
    

}
