<?php

class TeaGrantControllerDc extends CI_Controller
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
        $this->load->model('TeaGrant/DC/TeaGrantDcModel');
        $this->load->model('TeaGrant/LM/TeaGrantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('SettlementMb/SettlementMeetingDcInsModel');

        $allowed = ['DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

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
        } else if ($this->session->userdata('dist_code') == "22") {
            $this->db = $this->load->database('dha41', true);
        }

    }

    // 1st landing page Tea Grant ADC
    public function teaGrantDc()
    {
        $dist_code            = $this->session->userdata('dist_code');
        $user_code            = $this->session->userdata('user_code');
        $user_desig_code      = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->TeaGrantDcModel->countAllPendingSettlementTeaGrant($dist_code);
        // echo $this->db->last_query(); die;
        $generatedNoticeCount = $this->TeaGrantDcModel->countAllGeneratedNoticeTeaGrant($dist_code);
        // echo $this->db->last_query(); die;

        $paymentPendingCount  = $this->TeaGrantDcModel->countAllPaymentPendingByApplicant($dist_code);
        $paymentApprovalPendingCount = $this->TeaGrantDcModel->countAllPaymentApprovalPendingByApplicant($dist_code);

        $revertFromDept = $this->TeaGrantDcModel->countAllDeptRevertCases($dist_code);

        $approveFromDept = $this->TeaGrantDcModel->countAllDeptApprovalCases($dist_code);

        $reReportByAdc = $this->TeaGrantDcModel->countAllAdcReReport($dist_code);


        $data['dist_code']                   = $dist_code;
        $data['firstProceedingCount']        = $firstProceedingCount;
        $data['generatedNoticeCount']        = $generatedNoticeCount;
        $data['paymentPendingCount']         = $paymentPendingCount;
        $data['paymentApprovalPendingCount'] = $paymentApprovalPendingCount;
        $data['approveFromDept']             = $approveFromDept;
        $data['revertFromDept']              = $revertFromDept;
        $data['reReportByAdc']               = $reReportByAdc;
        $data['_view']                       = 'TeaGrant/DC/TeaGrantFirstLandingPageDc';

        $this->load->view('layouts/main', $data);
    }

    // settlement application details KHAS ADC
    public function getSettlementTeaGrantApplicationDetails()
    {
        $case_no        = $this->input->get('case');
        $case_no        = $this->utilityclass->decryptJwtCase($case_no);
        $dist_code      = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
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

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $data['guar_rel'] = $relation_executation->result();
        }

        // $premium_data                   = $this->SettlementCommonModel->getPremium($application_no);
        $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
        // var_dump($premium_data);
        // echo $this->db->last_query();
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

        $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->TeaGrantDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings         = $this->TeaGrantDcModel->getSettlementProceeding($case_no);
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

            $data['checkAppliedArea'] = $checkArea;
            $data['_view'] = 'TeaGrant/DC/TeaGrantFirstProceedingDcView';
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
                elseif($user_desig_code == MB_DEPUTY_COMM)
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
                elseif($user_desig_code == MB_DEPUTY_COMM)
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

        if($this->TeaGrantDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
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
            $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to'   => MB_CIRCLE_OFFICER,
                        'task'        => 'Reverted to CO'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

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
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted by ADC';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
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
            $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    // 'dc_proceeding'   => 0,
                    'final_status'    => MB_DISMISS,
                );

                $this->db->trans_begin();
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $mmnn = $this->TeaGrantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task   = MB_DEPUTY_COMM;
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
                    $this->utilityclass->checkUserAuthForCaseForDc($case_no);
                    $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
            $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPUTY_COMM,
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
            $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPUTY_COMM,
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
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $sql = "SELECT * FROM settlement_proposal_cases WHERE case_no = ?
                        ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;

            $caseCount      = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->TeaGrantDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
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
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'sdlac_approval'  => 'Y',
                    'sdlac_date'      => date('Y-m-d H:i:s'),
                    'dc_proceeding'   => 1,
                    'final_status'    => MB_APPROVED_BY_SDLAC,
                    'sdlace_proposal_no' => $proposal_no_int,
                );

                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                    $this->TeaGrantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task   = MB_DEPUTY_COMM;
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
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $caseCount = $this->TeaGrantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $caseDetails = $this->TeaGrantDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->TeaGrantDcModel->getSettlementProceeding($case_no);
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
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->TeaGrantDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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
                    'dc_approve'      => 'y',
                    'dc_proceeding'   => 1,

                );
                $this->db->trans_begin();
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task=MB_DEPUTY_COMM;
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

            $allCases      = $this->TeaGrantDcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposalNo);
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

            $proposalDetails = $this->TeaGrantDcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->TeaGrantDcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposalNo);
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
                    if($this->TeaGrantDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
                                'date_of_hearing' => date('Y-m-d H:i:s') ,
                                'next_date_of_hearing' => date("Y-m-d h:i:s", strtotime($hearingDate)),
                                'status' => MB_HEARING_DATE_CHANGED,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d H:i:s'),
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
        $pendingCase = $this->TeaGrantDcModel->getAllPendingSettlementTeaGrant($dist_code);
        // echo $this->db->last_query(); die;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcFirstProcList';
        $this->load->view('layouts/main', $data);

    }


    // view all mark as SDLAC KHAS ADC
    public function viewAllMarkAsSDLACListForDCTeaGrant()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getMarkAsSDLACSettlementTeaGrant($dist_code);
        // $getDistrict = $this->SettlementMbDcModel->getLocationName($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
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
        $pendingCase = $this->TeaGrantDcModel->getAllProposalSendByDcToSdlacTeaGrant($dist_code);

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
        $pendingCase = $this->TeaGrantDcModel->getAllUnderConSettlementTeaGrant($dist_code);

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
        $proposal_no = $this->utilityclass->decryptJwtCase($proposal_no);
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposal_no);
        $proposalDetails = $this->TeaGrantDcModel->getProposalDetailsById($proposal_no,$dist_code);

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
                    'created_by' => MB_DEPUTY_COMM,
                    'proposal_name' => strtoupper($proposalName)

                );
                $this->db->trans_begin();
                if($this->TeaGrantDcModel->saveProposalSDLACTeaGrant($dataProSave) == 0)
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
                        $this->utilityclass->checkUserAuthForCaseForDcWithRollback($case_no);
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

                        if($this->TeaGrantDcModel->saveProposalCaseListSDLACTeaGrant($saveCaseList) == 0)
                        {
//                            $this->TeaGrantDcModel->deleteProposalSDLAC($proposalId);

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
                            'pending_officer' => MB_DEPUTY_COMM,
                            'from_office'     => MB_DEPUTY_COMM,
                            'dc_code'         => $user_code,
                            'dc_proceeding'   => 1,
                        );

                        if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                                'office_from' => MB_DEPUTY_COMM,
                                'office_to'   => MB_DEPUTY_COMM,
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
        $pendingCase = $this->TeaGrantDcModel->getAllApproveAppBySdlacTeaGrant($dist_code);

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
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
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

        $caseCount = $this->TeaGrantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantDc();
        }
        else
        {

            $caseDetails = $this->TeaGrantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->TeaGrantDcModel->getSettlementProceeding($case_no);
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
        $pendingCase = $this->TeaGrantDcModel->getAllRejectAppByDcTeaGrant($dist_code);

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
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        
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

        $caseCount = $this->TeaGrantDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantDc();
        }
        else
        {
            $caseDetails = $this->TeaGrantDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->TeaGrantDcModel->getSettlementProceeding($case_no);
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
        $pendingCase = $this->TeaGrantDcModel->getAllOrderChithaUpdateAppTeaGrant($dist_code);

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
        $pendingCase = $this->TeaGrantDcModel->getReRevertedByCoApplicationTeaGrant($dist_code);

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
        $pendingCase = $this->TeaGrantDcModel->getRevertedByDeptApplicationTeaGrant($dist_code);

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
            $caseCount = $this->TeaGrantDcModel->caseForDcApprovalTeaGrant($case_no,$dist_code);
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
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task=MB_DEPUTY_COMM;
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
            $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 1,
                );
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task=MB_DEPUTY_COMM;
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
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,

                );
                if($this->TeaGrantDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
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
                        $task=MB_DEPUTY_COMM;
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
        $allCase = $this->TeaGrantDcModel->getAllCasesForFinalVerifyAppTeaGrant($dist_code);

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
            $pendingCase = $this->TeaGrantDcModel->getAllAppInReportSendByDcToSdlacTeaGrant($proposal_no);
            $cases       = $pendingCase->result();
            $caseCount   = $pendingCase->num_rows();
            $proposalDetails = $this->TeaGrantDcModel->getProposalDetailsById($proposal_no,$dist_code);

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
                    if($this->TeaGrantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
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
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        'sdlac_approval'  => 'Y',
                        'sdlac_date'      => date('Y-m-d H:i:s'),
                        'dc_proceeding'   => 1,
                        'final_status'    => MB_APPROVED_BY_SDLAC,
                        'sdlace_proposal_no' => trim($case->proposal_id),
                    );

                    if($this->TeaGrantDcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
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
                        'office_from' => MB_DEPUTY_COMM,
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
                    $task   = MB_DEPUTY_COMM;
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
                    if($this->TeaGrantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
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
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        // 'dc_proceeding'   => 0,
                        'final_status'    => MB_DISMISS,
                    );

                    if($this->TeaGrantDcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
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
                        $mmnn = $this->TeaGrantDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updatePro);

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
                            'office_from' => MB_DEPUTY_COMM,
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

            if($this->TeaGrantDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
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



    // Pull back case list
    public function pullBackCasesFromDepartmentForDCTea()
    {
        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->SettlementMeetingDcInsModel->getLocationName($dist_code);
        $location          = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'TeaGrant/DC/pull_back_cases_from_dept_tea';

        $this->load->view('layouts/main', $data);
    }


    // Ajax for pull back case list
    public function pullBackCasesWithDeptPaginationAPITea()
    {
        $service       = TEA_SERVICE_CODE;
        $by_case_no    = trim($this->input->post('case_no'));
        $remark_cat    = trim($this->input->post('remark_cat'));
        $remark_cat_lm = trim($this->input->post('remark_cat_lm'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subDiv_code   = trim($this->input->post('subdiv'));
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = trim($this->session->userdata('user_desig_code'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');

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
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where("(settlement_basic.add_cases_to_memo != 'Y' OR settlement_basic.add_cases_to_memo IS NULL)", NULL, false);
        $this->db->where('settlement_basic.pending_officer', 'DPT');
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
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where("(settlement_basic.add_cases_to_memo != 'Y' OR settlement_basic.add_cases_to_memo IS NULL)", NULL, false);
            $this->db->where('settlement_basic.pending_officer', 'DPT');
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

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $lm_remark,

                    $co_remark,

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn rezaButt" target="_blank" href="'.base_url().'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case='.$rows->case_no.'">  VIEW
                    </a>
                        
                    <button class="btn rezaButt buttPrimary pullBackCasesModal" data-id='.$rows->case_no.'  style="margin-top: 10px">  PULL BACK
                    </button>'

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


    // get revert back meeting details
    public function getPullBackCaseDetailsTea()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $appId     = trim($this->input->post('meetingId'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', TEA_SERVICE_CODE)
                ->where('status', 'W')
                ->where('pending_officer', 'DPT')
                ->where("(add_cases_to_memo != 'Y' OR add_cases_to_memo IS NULL)", NULL, false)
                ->get('settlement_basic')
                ->num_rows();


            if($checkCase == 1)
            {

                echo json_encode(array(
                    'responseType'       => 2,
                    'meetingId'          => $appId,
                    'caseNumber'         => $appId,
                ));

                return;

            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return;
            }
        }
    }


    // final pull back submit & revert back to co
    public function finalPullBackRevertToCoSubmitTea()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();

            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#ERMR002025: Validation error ! ' .$errors,
            ));
            return;
        }
        else
        {
            $dist_code       = trim($this->session->userdata('dist_code'));
            $appId           = trim($this->input->post('meetingId'));
            $remarks         = trim($this->input->post('remarks'));
            $user_desig_code = trim($this->session->userdata('user_desig_code'));
            $user_code       = trim($this->session->userdata('user_code'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('service_code', TEA_SERVICE_CODE)
                ->where('status', 'W')
                ->where('pending_officer', 'DPT')
                ->where("(add_cases_to_memo != 'Y' OR add_cases_to_memo IS NULL)", NULL, false)
                ->get('settlement_basic')
                ->num_rows();

            if($checkCase == 1)
            {
                $this->db->trans_begin();
                $case_no = $appId;
                $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
                if($caseDetails->status != MB_PENDING)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003835: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                    ));
                    return false;
                }
                if($caseDetails->dept_revert == 1)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003844: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
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
                if($this->SettlementCommonDcModel->updateSettlementBasicDataOnlyDept($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003918: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
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
                    'case_no'              => $case_no,
                    'proceeding_id'        => $proceeding_id,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'status'               => MB_REVERT,
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => $user_desig_code,
                    'office_to'            => MB_CIRCLE_OFFICER,
                    'task'                 => 'Pull Back & Reverted to CO',
                    'note_on_order'        => $remarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003952: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003952: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return false;
                }

                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                $case   = $case_no;
                $rmk    = 'Pull Back & Reverted to CO';
                $status = 'M';
                $task   = $this->session->userdata('user_desig_code');
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status = json_decode($rtps_status);
                if(trim($rtps_status)!="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRAPI104042: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MRAPI104042: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                    ));
                    return false;
                }

                $this->db->trans_commit();
                echo json_encode(array(
                    'responseType' => 2,
                    'message'  => 'Application has been successfully pulled back and reverted to the CO.',
                ));
                return false;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return false;
            }
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
        // $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
        $this->db->where('settlement_basic.dept_code IS NULL');
        $this->db->where('settlement_basic.dept_approval IS NULL');
        // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
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

            // $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
            $this->db->where('settlement_basic.dept_code IS NULL');
            $this->db->where('settlement_basic.dept_approval IS NULL');
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where("NOT EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

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
                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'</span>',

                    '<span style="font-size: 13px;">'.$lm_remark.'</span>',

                    '<span style="font-size: 13px;">'.$co_remark.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span></span>",

                    '<span style="font-size: 13px;">'.'<a class="btn btn-success" href="'.base_url().'index.php/TeaGrantControllerDc/getSettlementTeaGrantApplicationDetails/?case='.$rows->case_no.'">
                        '.$this->lang->line('process').'</a></span>'

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
        $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
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
            $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
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

                    '<a class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/getSettlementTeaGrantApplicationDetails/?case='.$rows->case_no.'">View Application</a>'
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
            $this->db->where('settlement_proposal_list.created_by', MB_DEPUTY_COMM);
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
            $this->db->where('created_by', MB_DEPUTY_COMM);
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
            $this->db->where('created_by', MB_DEPUTY_COMM);
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
            $this->db->where('created_by', MB_DEPUTY_COMM);
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
                $this->db->where('settlement_proposal_list.created_by', MB_DEPUTY_COMM);
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
                $this->db->where('created_by', MB_DEPUTY_COMM);
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
                $this->db->where('created_by', MB_DEPUTY_COMM);
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
                $this->db->where('created_by', MB_DEPUTY_COMM);
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
            array($dist_code, $proposal_id, MB_DEPUTY_COMM));

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
        $pendingCase = $this->TeaGrantDcModel->getSdlacApprovalProposalListTeaGrant($dist_code);

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
            $this->db->where('settlement_proposal_list.created_by', MB_DEPUTY_COMM);
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
            $this->db->where('created_by', MB_DEPUTY_COMM);
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
            $this->db->where('created_by', MB_DEPUTY_COMM);
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
            $this->db->where('created_by', MB_DEPUTY_COMM);
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
                $this->db->where('settlement_proposal_list.created_by', MB_DEPUTY_COMM);
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
                $this->db->where('created_by', MB_DEPUTY_COMM);
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
                $this->db->where('created_by', MB_DEPUTY_COMM);
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);
                $this->db->where('created_by', MB_DEPUTY_COMM);

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

        $proposalDetails  = $this->TeaGrantDcModel->getSdlacApprovalProposalIndividualTeaGrant($proposal_no,$dist_code);
        $reportDetails    = $this->TeaGrantDcModel->getSdlacMemberReportDetailsTeaGrant($proposal_no,$dist_code);
        $getMembersStatus = $this->TeaGrantDcModel->getSdlacMemberStatus($dist_code, $proposal_no);

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
            array($proposal_id, $dist_code, $service_code, MB_DEPUTY_COMM));

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
            $dist_code    = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no      = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount    = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails     = $this->TeaGrantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetail = $this->TeaGrantDcModel->getApplicantDetails($case_no);
                $get_dag_details = $this->TeaGrantDcModel->getDagDetailsTenant($case_no);
                $get_dag_list    = $this->TeaGrantDcModel->getDagDetailsList($case_no);

                $dist_name       = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name     = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code);
                $mouza_name      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code);
                $village_name    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code);
                $get_owners      = $this->TeaGrantDcModel->getOwners($case_no);
                $get_buyers      = $this->TeaGrantDcModel->getBuyers($case_no);

                $notice_no       = "MB3/GN/" . date('Y') . "/".TEA_PREFIX."/" . $caseDetails->petition_no;

                foreach($get_dag_list as $r)
                {
                    $tableData = '';
                    $area_det = '';

                    if (in_array($r->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $area_det .= 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' চ: '.$r->s_dag_area_lc.' গ: '.$r->s_dag_area_g;
                    }
                    else
                    {
                        $area_det .= 'বি: '.$r->s_dag_area_b.' ক: '.$r->s_dag_area_k.' লে: '.$r->s_dag_area_lc;
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
                }

                // $tableData = $tableData;

                echo json_encode(array(
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
                    'tableData'       => $tableData,
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



            // $ses_dist = $this->session->userdata('dist_code');
            // $ses_sub  = $this->session->userdata('subdiv_code');
            // $ses_user = $this->session->userdata('user_desig_code');

            // var_dump($ses_dist);
            // var_dump($ses_sub);
            // var_dump($ses_user);


            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            // echo $this->db->last_query();

            // var_dump($user); die;



            $caseCount       = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
            if ($caseCount == 0) {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails = $this->TeaGrantDcModel->getSettlementApplicationDetailsByCaseNo($case_no, $dist_code);
                $applicantDetails = $this->TeaGrantDcModel->getAllApplicant($case_no);

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
                        log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                    $updateData = array(
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                    );
                    if($this->TeaGrantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllTeaGrantFirstProceedingDcCaseList',
                    ));
                    return;
                }
                else
                {
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

                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                    $updateData = array(
                        'general_notice_dc'     => 'y',
                        'notice_generated_yn'   => 'y',
                        'notice_generated_date' => date('Y-m-d H:i:s'),
                        'next_date_of_hearing'  => $hearing_date,
                        'date_update'           => date('Y-m-d H:i:s'),
                    );
                    if ($this->TeaGrantDcModel->updateSettlementBasicData($case_no, $dist_code, $updateData) == 0) {
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
                        echo json_encode(array(
                            'responseType' => 1,
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
                            echo json_encode(array(
                                'responseType' => 1,
                            ));
                            return;
                        }
                    }
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllTeaGrantFirstProceedingDcCaseList',
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

        if ($this->TeaGrantDcModel->checkDuplicateFileNameInGeneral($new_case_no) != 0) {
            $this->randomFileName();
        } else {
            return $new_case_no;
        }

    }


    // view all notice generated case list tea grant
    public function viewAllGeneratedNoticeTeaGrantDcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllPendingNoticeGenerateTeaGrant($dist_code);
        // echo $this->db->last_query(); die;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcNoticeGeneratedList';
        $this->load->view('layouts/main', $data);
    }

    // pagination of generated notice
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
        // $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->where('settlement_basic.adc_code IS not NULL');
        // $this->db->where('settlement_basic.dept_approval IS NULL');
        // $this->db->where('settlement_basic.dc_code', trim($this->session->userdata('user_code')));
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
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
            // $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where('settlement_basic.adc_code IS not NULL');
            $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            // $this->db->where('settlement_basic.dept_code IS NULL');
            // $this->db->where('settlement_basic.dept_approval IS NULL');
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));

            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

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
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="dcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        $approve_forward_to_adc = '<button title="Approve & Forward to ADC" class="btn btn-danger btn-sm forward_adc_btn" onclick="forward_to_adc(\''.$rows->case_no.'\')">Approve & Forward to ADC</button>';

                        $forward_dept_btn = null;
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $approve_forward_to_adc = null;

                        $forward_dept_btn = ENABLE_FORWARD_TO_DEPT == 1 ? null : '<button title="Forward to Dept" class="btn btn-default btn-sm forward_dept_btn" onclick="forward_to_dept(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $approve_forward_to_adc = null;
                    $forward_dept_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $dc_revert_to_adc = '<button title="Revert to ADC" class="btn btn-warning btn-sm revert_co_btn" onclick="dc_revert_to_adc(\''.$rows->case_no.'\')">Revert to ADC</button>';

                $button = $appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$forward_dept_btn.'&nbsp;'.$dc_revert_to_adc.'&nbsp;'.$approve_forward_to_adc;


                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : $appl_view_btn

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
        $noticeDetails = $this->TeaGrantDcModel->getGeneralNoticeDetails($case_no);
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
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
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

        $caseCount = $this->TeaGrantDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->teaGrantDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->TeaGrantDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings         = $this->TeaGrantDcModel->getSettlementProceeding($case_no);
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
            $data['_view'] = 'TeaGrant/DC/TeaGrantOnlyViewDc';
            $this->load->view('layouts/main', $data);
        }
    }

    public function loadViewForHearingRemarks()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantDcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantDcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantDcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantLoadModalHearingRemarks', $data);
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
        $userAccess      = [MB_DEPUTY_COMM,MB_DEPUTY_COMM,MB_SUB_DIV_COMM];

        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5585: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // *********** proceeding start **************
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", array($case_no))->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => $hearing_rem,
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
            array($case_no))->row()->is_urban;
    }

    public function forwardToDepartmentSingle()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $dept_forward_rem = $this->input->post('dept_forward_rem');
        $recommend = $this->input->post('recommend');

        if($dept_forward_rem == null || $dept_forward_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5762: Remarks field is mandatory !!! ',
            ]);
            return false;
        }
        if($recommend == null || $recommend == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5785: Please select recommend / not recommend !!! ',
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
            'note_on_order'        => $dept_forward_rem.'<br>'.$msg,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
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
            'dc_code'         => $this->session->userdata('user_code'),
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
        $task           = MB_DEPUTY_COMM;
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
            'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllGeneratedNoticeTeaGrantDcCaseList',
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
                    $this->utilityclass->checkUserAuthForCaseForDc($case_no);
                    $caseCount = $this->TeaGrantDcModel->countApplicationDetailsByCaseNo($case_no,$dist_code,$serviceCode);

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
                        'dc_code'         => $this->session->userdata('user_code'),
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
                    $task           = MB_DEPUTY_COMM;
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
                        'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllGeneratedNoticeTeaGrantAdcCaseList',
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
    public function generatePaymentNotice()
    {
        // $_POST        = json_decode(file_get_contents("php://input"), true);
        $final_amount = $this->input->post('final_amount');
        $due_amount   = $this->input->post('due_amount');
        $case_no      = $this->input->post('case_no_notice');

        $get_settlement_basic     = $this->TeaGrantModel->getSettlementBasic($case_no);
        $get_settlement_applicant = $this->TeaGrantModel->getAllApplicant($case_no);
        $get_owners               = $this->TeaGrantModel->getAllApplicantOwners($case_no);
        $get_buyers               = $this->TeaGrantModel->getMainApplicant($case_no);
        $get_dag_details          = $this->TeaGrantModel->getSettlementDag($case_no);

        if (empty($get_buyers) || $get_buyers == null || $get_buyers == '') {
            $this->session->set_flashdata('message', "#ERR5930: Unable to generate payment notice for case #".$case_no);
            redirect(base_url().'index.php/TeaGrantControllerDc/viewAllGeneratedNoticeTeaGrantAdcCaseList');
        }

        // $premium_data = $this->db->query("SELECT sp.*, spa.area, spl.land_type, spr.house_type FROM
        //                 settlement_premium sp LEFT OUTER JOIN settlement_premium_area spa
        //                   ON spa.paid=sp.area_name LEFT OUTER JOIN settlement_premium_land_type spl
        //                     ON spl.plid=sp.land_type LEFT OUTER JOIN settlement_premium_rate spr
        //                       ON spr.prid=sp.rate_type WHERE case_no=? and is_final=?",
        //     array($case_no, 1))->result();

        $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();

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


        // echo "<pre>"; var_dump($premium_data); die;

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
        ];

        $this->load->view('TeaGrant/common/paymentNoticePrint', $data);

    }

    // save payment notice
    public function savePaymentNotice()
    {
        $_POST                  = json_decode(file_get_contents("php://input"), true);
        $case_no                = $this->input->post('case_no');
        $amount                 = $this->input->post('amount');
        $district               = $this->input->post('district');
        $sub_division           = $this->input->post('sub_division');
        $circle                 = $this->input->post('circle');
        $lot_no                 = $this->input->post('lot_no');
        $mouza                  = $this->input->post('mouza');
        $village                = $this->input->post('village');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');

        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

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

        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) {
            log_message('error', "#ERR6009: Premium notice already generated for case no: $case_no");
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6009: Premium notice already generated for case no: $case_no",
            ];
            echo json_encode($json);
            return;
        }

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path    = PAYMENT_NOTICE_PATH . $new_case_no . ".json";

        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $get_settlement_basic     = $this->TeaGrantModel->getSettlementBasic($case_no);
        $get_dag_details          = $this->TeaGrantModel->getSettlementDag($case_no);
        $get_settlement_applicant = $this->TeaGrantModel->getAllApplicant($case_no);
        $checkArea                = $this->chithaReserveAreaCheckWithCaseNo($case_no);

        if ($checkArea != 0) {
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
        $sql_service      = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details  = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers       = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();

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
            'dc_code'            => $this->session->userdata('user_code'),
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

        // var_dump($htmlstring_text); die;


        //   API CALL END HERE
        $sql = "Select basundhara from basundhar_application where dharitree=?";
        $basundhara = $this->db->query($sql, array($case_no))->row();

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
        log_message("error", "#6157_API_RESP: ". json_encode($result));

        // var_dump($result);

        if (trim($result) != 'y') {
            $this->db->trans_rollback();
            log_message('error', '#6162: Issue in API response : '.json_encode($result));
            $json = [
                'responseType' => 1,
                'message'      => "#6162: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        else {
            $this->db->trans_commit();

            $json = [
                'responseType' => 2,
                'message'      => "#SUCCESS6175: Payment notice successfully saved...(This notice will be available under step #3) for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
    }


    public function loadViewForPaymentGeneration()
    {
        $case_no         = $this->input->post('case_no');
        $data['prem']    = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=?",
            array($case_no))->row();

        $data['case_no'] = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantLoadModalPaymentNotice', $data);
    }


    // view all payment notice generated case list tea grant
    public function viewAllPaymentPendingCases()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllPaymentPendingTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcPaymentPendingList';
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

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
        $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
        $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
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


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
            $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where('settlement_premium.grn_no IS NULL');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_pn_btn = '<a title="View Payment Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewPaymentNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $write_report_btn = '<a title="Write Report" class="btn btn-danger btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/confirmPaymentAdc/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-edit"></span></a>';

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
        $pendingCase = $this->TeaGrantDcModel->getAllPaymentApprovalPendingTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcPaymentApprovalPendingList';
        $this->load->view('layouts/main', $data);
    }


    // view general notice
    public function viewPaymentNoticeTeaGrant()
    {
        $case_no       = $this->input->get('case');
        $case_no       = $this->utilityclass->decryptJwtCase($case_no);
        $noticeDetails = $this->TeaGrantDcModel->getPaymentNoticeDetails($case_no);

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
        $redirect = base_url() . "index.php/TeaGrantControllerDc/viewAllPaymentPendingCases";

        $case_no              = $this->input->get('case');
        $case_no              = $this->utilityclass->decryptJwtCase($case_no);
        $get_settlement_basic = $this->TeaGrantModel->getSettlementBasic($case_no);
        $case_no_rtps         = $get_settlement_basic['applid'];

        // payment status check thourgh API
        $payment_status_check = $this->TeaGrantModel->paymentConfirmation($case_no_rtps);

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


        $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is not null limit 1', array($case_no, 1));

        $data['paid_confirm'] = $sqlCheck->num_rows();

        $data['_view'] = 'TeaGrant/common/confirmPaymentView';
        $this->load->view('layouts/main', $data);
    }


    public function paymentConfirmationForwardToCo()
    {
        $redirect = base_url() . "index.php/TeaGrantControllerDc/viewAllPaymentApprovalPendingCases";
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
                'office_from'           => MB_DEPUTY_COMM,
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
            'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllPaymentPendingCases',
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

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
        $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
        $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
        $this->db->where('settlement_premium.grn_no IS NOT NULL');
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


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PAYMENT_NOTICE);
            $this->db->where('settlement_basic.pay_notice_gen_yn', 'Y');
            $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
            $this->db->where('settlement_premium.grn_no IS NOT NULL');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='PN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_pn_btn = '<a title="View Payment Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewPaymentNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $write_report_btn = '<a title="Write Report" class="btn btn-danger btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/confirmPaymentAdc/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-edit"></span></a>';

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


    // view all department approval list tea grant
    public function viewAllDeptRevertToDcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllPendingDeptRevertTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcDeptRevertList';
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
        $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
        $this->db->where('settlement_basic.dept_code IS NOT NULL');
        $this->db->where('settlement_basic.dept_approval', 'Y');
        // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
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

            $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
            $this->db->where('settlement_basic.dept_code IS NOT NULL');
            $this->db->where('settlement_basic.dept_approval', 'Y');
            // $this->db->where('settlement_basic.adc_code', trim($this->session->userdata('user_code')));
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
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

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
                        $gen_payment_notice_btn = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="gen_payment_notice_btn(\''.$rows->case_no.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16s-7.163 16-16 16m-4.313-21.938h.032c2.875.063 5.75-.062 8.625.063c.718 0 1.562.344 1.718 1.094c.25 1.75-1.218 3.344-2.812 3.75c-1.75.281-3.5.187-5.219.187a924 924 0 0 1-1.25 3.063c2.094 0 4.188.093 6.25-.219a8.71 8.71 0 0 0 6.344-5.688c.5-1.312.719-2.968-.281-4.124C24.25 7.125 22.75 7.125 21.5 7.03L12.937 7l-1.25 3.063zM8 10.906v.031l-1.375 3.438h10.188l1.343-3.469zm1.625 4.25h.031L6 24.531h3.469l3.687-9.375z"/></svg></button>';
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

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

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


    public function loadViewForDeptForward()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantDcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantDcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantDcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantDeptForwardRemarks', $data);
    }

    //pagination of department approval list
    public function deptRevertedPendingList()
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
        $this->db->where('service_code', TEA_SERVICE_CODE);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 'R');
        $this->db->where('pending_office', MB_DEPUTY_COMM);
        $this->db->where('dept_revert', 1);
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
            $this->db->where('service_code', TEA_SERVICE_CODE);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 'R');
            $this->db->where('pending_office', MB_DEPUTY_COMM);
            $this->db->where('dept_revert', 1);

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
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

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
                        $forward_dept_btn = null;
                        $gen_payment_notice_btn = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="gen_payment_notice_btn(\''.$rows->case_no.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16s-7.163 16-16 16m-4.313-21.938h.032c2.875.063 5.75-.062 8.625.063c.718 0 1.562.344 1.718 1.094c.25 1.75-1.218 3.344-2.812 3.75c-1.75.281-3.5.187-5.219.187a924 924 0 0 1-1.25 3.063c2.094 0 4.188.093 6.25-.219a8.71 8.71 0 0 0 6.344-5.688c.5-1.312.719-2.968-.281-4.124C24.25 7.125 22.75 7.125 21.5 7.03L12.937 7l-1.25 3.063zM8 10.906v.031l-1.375 3.438h10.188l1.343-3.469zm1.625 4.25h.031L6 24.531h3.469l3.687-9.375z"/></svg></button>';
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $forward_dept_btn = ENABLE_FORWARD_TO_DEPT == 1 ? null : '<button title="Forward to Dept" class="btn btn-default btn-sm forward_dept_btn" onclick="dc_forward_to_dept(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $forward_dept_btn = null;
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                // $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$gen_payment_notice_btn;

                $dc_revert_to_co = '<button title="Revert to ADC" class="btn btn-warning btn-sm revert_co_btn" onclick="dc_revert_to_adc(\''.$rows->case_no.'\')">Revert to ADC</button>';

                $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$gen_payment_notice_btn.'&nbsp;'.$forward_dept_btn.'&nbsp;'.$dc_revert_to_co;


                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : $appl_view_btn

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

    // revert to CO
    public function loadViewForCoRevert()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantDcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantDcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantDcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantDcToCoRevert', $data);
    }



    public function revertToCoByDC()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $dc_revert_rem = $this->input->post('dc_revert_rem');

        if($dc_revert_rem == null || $dc_revert_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR5762: Remarks field is mandatory !!! ',
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
            'note_on_order'        => $dc_revert_rem,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Revert to CO from DC',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR7529: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7529: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_CIRCLE_OFFICER,
            'pending_officer' => MB_CIRCLE_OFFICER,
            'dc_code'         => $this->session->userdata('user_code'),
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
                'message'      => "#ERR7555: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Forwarded to Dept';
        $status         = 'M';
        $task           = MB_DEPUTY_COMM;
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
                'message'      => "#ERR7575: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS7583: $case_no has successfully reverted to CO !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllDeptRevertToDcCaseList',
        ]);
        return;
    }

    // revert to adc
    public function loadViewForAdcRevert()
    {
        $case_no                 = $this->input->post('case_no');
        $basic                   = $this->TeaGrantModel->getSettlementBasic($case_no);
        $data['applicantDetail'] = $this->TeaGrantDcModel->getApplicantDetails($case_no);
        $data['dagList']         = $this->TeaGrantDcModel->getDagDetailsList($case_no);
        $data['mouza_name']      = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $data['village_name']    = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $data['hearing_date']    = $this->TeaGrantDcModel->getGeneralNoticeDetails($case_no);

        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantDcToAdcRevert', $data);
    }


    public function revertToAdcByDC()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $dc_revert_rem = $this->input->post('dc_revert_rem');

        if($dc_revert_rem == null || $dc_revert_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR7616: Remarks field is mandatory !!! ',
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
            'note_on_order'        => $dc_revert_rem,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
            'office_to'            => MB_ADD_DEPUTY_COMM,
            'task'                 => 'Revert to ADC from DC',
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
            'pending_office'  => MB_ADD_DEPUTY_COMM,
            'pending_officer' => MB_ADD_DEPUTY_COMM,
            'dc_code'         => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
            'dc_revert'       => 'y',
            'status'          => 'R',
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR5740: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7555: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Revert to ADC';
        $status         = 'M';
        $task           = MB_ADD_DEPUTY_COMM;
        $pen            = MB_ADD_DEPUTY_COMM;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR5824: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7575: Failed to revert the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS7583: $case_no has successfully reverted to ADC !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllDeptRevertToDcCaseList',
        ]);
        return;
    }


    // approve and forward to adc
    public function loadViewForAdcAprroveForward()
    {
        $case_no                 = $this->input->post('case_no');
        $data['case_no']         = $this->input->post('case_no');
        $this->load->view('TeaGrant/DC/TeaGrantDcToAdcApproveForward', $data);
    }

    // approve and forward to adc save
    public function approveAndForwardToAdc()
    {
        $_POST   = json_decode(file_get_contents("php://input"), true);
        $case_no = $this->input->post('case_no');
        $dc_forward_rem = $this->input->post('dc_forward_rem');

        if($dc_forward_rem == null || $dc_forward_rem == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message'      => '#ERR7736: Remarks field is mandatory !!! ',
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
            'note_on_order'        => $dc_forward_rem,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'DC',
            'office_to'            => MB_ADD_DEPUTY_COMM,
            'task'                 => 'Approve & forward to ADC from DC',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            log_message("error", "#ERR7767: Insertion failed in settlement_proceeding ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7767: Failed to forward the case $case_no !!! ",
            ]);
            return false;
        }

        // **** update settlement_basic ****

        $updateSettlementBasic = [
            'pending_office'  => MB_DEPUTY_COMM,
            'pending_officer' => MB_ADD_DEPUTY_COMM,
            'dc_code'         => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d H:i:s'),
            'from_office'     => MB_DEPUTY_COMM,
            'dc_approve'      => 'y'  ,
            'status'          => 'M'  ,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateSettlementBasic);

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#ERR7789: Updation failed in settlement_basic ===".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7789: Failed to forward the case $case_no !!! ",
            ]);
            return false;
        }

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk            = 'Approve & forward to ADC from DC';
        $status         = 'M';
        $task           = MB_ADD_DEPUTY_COMM;
        $pen            = MB_ADD_DEPUTY_COMM;
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);

        if(trim($rtps_status) != "y")
        {
            log_message("error", "#ERR7809: Updation failed in postApiResponse for case no $case_no !!!");
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message'      => "#ERR7809: Failed to forward the case $case_no !!! ",
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'message'      => "#SUCCESS7821: $case_no has successfully forwarded to ADC !!! ",
            'redirect'     => base_url().'index.php/TeaGrantControllerDc/viewAllGeneratedNoticeTeaGrantDcCaseList',
        ]);
        return;
    }


    // view all re report cases
    public function viewAllReReportTeaGrantDcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllPendingReReportByAdcTeaGrant($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcReReportList';
        $this->load->view('layouts/main', $data);
    }


    //pagination of generated notice
    public function reReportPaginationAPI()
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
        // $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where_in('settlement_basic.status', [MB_PENDING, MB_REVERT]);
        $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->where('settlement_basic.adc_code IS not NULL');
        $this->db->where('settlement_basic.dc_code IS not NULL');
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
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
            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where_in('settlement_basic.status', [MB_PENDING, MB_REVERT]);
            $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $this->db->where('settlement_basic.adc_code IS not NULL');
            $this->db->where('settlement_basic.dc_code IS not NULL');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

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
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

                // var_dump($getAppliedAreaType); die;

                if($hearing_availability == 1)
                {
                    $hearing_rem_btn = null;
                }
                else
                {
                    $hearing_rem_btn = '<button class="btn btn-danger btn-sm hearing_rem_btn" onclick="dcHearing_btn(\''.$rows->case_no.'\')" title="Enter Hearing Remarks"><span class="fa fa-edit"></span></button>';
                }

                if($hearing_availability == 1)
                {
                    if($getAppliedAreaType == 'R') // Rural
                    {
                        $approve_forward_to_adc = '<button title="Approve & Forward to ADC" class="btn btn-danger btn-sm forward_adc_btn" onclick="forward_to_adc(\''.$rows->case_no.'\')">Approve & Forward to ADC</button>';

                        $forward_dept_btn = null;
                        $gen_payment_notice_btn = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="gen_payment_notice_btn(\''.$rows->case_no.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16s-7.163 16-16 16m-4.313-21.938h.032c2.875.063 5.75-.062 8.625.063c.718 0 1.562.344 1.718 1.094c.25 1.75-1.218 3.344-2.812 3.75c-1.75.281-3.5.187-5.219.187a924 924 0 0 1-1.25 3.063c2.094 0 4.188.093 6.25-.219a8.71 8.71 0 0 0 6.344-5.688c.5-1.312.719-2.968-.281-4.124C24.25 7.125 22.75 7.125 21.5 7.03L12.937 7l-1.25 3.063zM8 10.906v.031l-1.375 3.438h10.188l1.343-3.469zm1.625 4.25h.031L6 24.531h3.469l3.687-9.375z"/></svg></button>';
                        $checkBox      = 'NA';
                    }
                    else
                    {
                        $approve_forward_to_adc = null;

                        $forward_dept_btn = ENABLE_FORWARD_TO_DEPT == 1 ? null : '<button title="Forward to Dept" class="btn btn-default btn-sm forward_dept_btn" onclick="forward_to_dept(\''.$rows->case_no.'\')"><span class="fa fa-fast-forward"></span></button>';
                        $gen_payment_notice_btn = null;
                        $checkBox  = $rows->case_no;            }
                }
                else
                {
                    $approve_forward_to_adc = null;
                    $forward_dept_btn = null;
                    $gen_payment_notice_btn = null;
                    $checkBox  = $rows->case_no;
                }

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $dc_revert_to_adc = '<button title="Revert to ADC" class="btn btn-warning btn-sm revert_co_btn" onclick="dc_revert_to_adc(\''.$rows->case_no.'\')">Revert to ADC</button>';

                $button = $hearing_rem_btn.'&nbsp;'.$appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$forward_dept_btn.'&nbsp;'.$dc_revert_to_adc.'&nbsp;'.$approve_forward_to_adc;


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


    // view all notice generated case list tea grant
    public function viewAllDeptApprovalTeaGrantDcCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->TeaGrantDcModel->getAllPendingNoticeGenerateTeaGrant($dist_code);
        // echo $this->db->last_query(); die;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->TeaGrantDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name']    = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code']    = $circle->cir_code;
        }
        $data['location'] = $circleList;
        $data['_view']    = 'TeaGrant/DC/TeaGrantDcDeptApprovalList';
        $this->load->view('layouts/main', $data);
    }


    // pagination of generated notice
    public function listOfDeptApprovedCases()
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
        $this->db->where('settlement_basic.service_code', '43');
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->where('settlement_basic.dept_approval', 'Y');
        $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);
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
            // $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->join('settlement_notice', 'settlement_basic.case_no = settlement_notice.case_no');
            $this->db->where('settlement_basic.service_code', '43');
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $this->db->where('settlement_basic.dept_approval', 'Y');
            $this->db->where("EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = settlement_basic.case_no AND sn2.notice_type='GN')", NULL, FALSE);

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $getAppliedAreaType   = $this->getReportedAreaByLra($rows->case_no);

                $area_type = ($getAppliedAreaType == 'R') ? 'Rural' : 'Urban';
                $processStatus = ($getAppliedAreaType == 'R') ? 'Processed By DC' : 'Processed By Dept';

                $appl_view_btn = '<a title="View Application" class="btn btn-success btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewTeaGrantApplicationDetails/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'"><span class="fa fa-columns"></span></a>';

                $view_gn_btn = '<a title="View General Notice" class="btn btn-primary btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewGeneralNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_gen_notice"><span class="fa fa-eye"></span></a>';

                $view_pn_btn = '<a title="View Payment Notice" class="btn btn-danger btn-sm" href="'.base_url().'index.php/TeaGrantControllerDc/viewPaymentNoticeTeaGrant/?case='.$this->utilityclass->encryptJwtCase($rows->case_no).'" target="_pay_notice"><span class="fa fa-eye"></span></a>';

                $approve_forward_to_adc = '<button title="Approve & Forward to ADC" class="btn btn-warning btn-sm forward_adc_btn" onclick="forward_to_adc(\''.$rows->case_no.'\')">Approve & Forward to ADC</button>';

                $button = $appl_view_btn.'&nbsp;'.$view_gn_btn.'&nbsp;'.$view_pn_btn.'&nbsp;'.$approve_forward_to_adc;

                $json[] = array(

                    $checkBox,

                    '<span class="px-3" style="font-size: 13px;"><strong>' . $i . '</strong></span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code).'</span>',

                    '<span style="font-size: 13px;">'.$this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code).'</span>',

                    '<span style="font-size: 13px;">'.date('d-M-Y', strtotime($rows->submission_date)).'<br>'.$area_type.'</span>',

                    '<span style="font-size: 13px;">'.$rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span><br><span style='color: blue'>".$processStatus."</span></span>",

                    (DISABLE_ALL_BUTTON == 0) ? $button : $appl_view_btn

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

}
