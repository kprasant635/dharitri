<?php



class SettlementMbDc extends CI_Controller
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
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');

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


    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $allApplicationDagArray = [];
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
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
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

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAppliedAreaInApplication)
                {
                    $areaCheck = 1;
                }
            }
            $chithaDagArray[] = $chithaDag;
            $allApplicationDagArray[] = $allApplicationDags;
        }

        $checkAreaDetail = array(
            'chithaArea'   => $chithaDagArray,
            'reservedArea' => $allApplicationDagArray,
            'appliedDags'  => $appliedDags,
            'areaCheck'    => $areaCheck,
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


    // random file name
    function randomFileName()
    {
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->SettlementMbDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
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
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $rmk='Reverted by DC';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
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
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $pen=null;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
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
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $remarks   = $this->input->post('remarks');
            $user_code = $this->session->userdata('user_code');
            $proposal_id = $this->input->post('proposalId');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'status'         => PRO_CASE_STATUS_REJECT,
                        'approved_by_dc' => 0,
                    );
                    $mmnn = $this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
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
                        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
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
        $this->form_validation->set_rules('venue', 'Venue name', 'trim|required');

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
            $venue = $this->input->post('venue');

            //check if all cases selected to be approved by either department(urban) or dc(rural)
            if(SELECTED_CASES_APPROVED_BY_DEPT_DC == 1)
            {
                foreach ($allSelectedList as $case_no)
                {
                    $dag       = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
                    $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);

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
                    $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    if($checkArea != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 10,
                            'application' => $case_no
                        ));
                        return;
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
                $dist_name    = $this->UtilsModel->getEngDistrictNameByDistCode($this->session->userdata('dist_code'));
                $commMembers  = $this->SettlementMbDcModel->getMembersFromUsers($this->session->userdata('dist_code'));
                $subdiv_name  = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'));
                $distEngName  = substr($dist_name->locname_eng, 0, 3);
                $proposalName = $distEngName.'/PROPOSAL/'.date("Y").'/'.$proposalSequenceNo;

                echo json_encode(array(
                    'responseType'       => 2,
                    'caseList'           => $allSelectedList,
                    'hearingDate'        => date("F j, Y",strtotime($hearingDate)),
                    'timing'             => date("h:i a",strtotime($hearingDate)),
                    'remarks'            => $remarks,
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
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                $updateData = array(
                    'status'  => MB_MARK_AS_SDLAC,
                    'dc_code' => $user_code,
                    'dc_proceeding' => 1,
                );

                $this->db->trans_begin();
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
            $case_no   = $this->input->post('caseNo');
            $dist_code = $this->session->userdata('dist_code');
            $user_code = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

            $caseCount      = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->SettlementMbDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);

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
                    'sdlac_date'      => date('Y-m-d h:i:s'),
                    'dc_proceeding'   => 1,
                    'final_status'    => MB_APPROVED_BY_SDLAC,
                    'sdlace_proposal_no' => $proposal_no_int,
                );

                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                    $this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
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
                            $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
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
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $caseCount = $this->SettlementMbDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $caseDetails = $this->SettlementMbDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementMbDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Khas/payment_received_app_details_khas';
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
            $caseCount = $this->SettlementMbDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
    public function updateProposalHearingDateKhas()
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

            $allCases      = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposalNo);
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
    public function updateHearingDateGenerateNoticeKhas()
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

            $proposalDetails = $this->SettlementMbDcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposalNo);
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
                    if($this->SettlementMbDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
    //********************** START KHAS **********************************

    // 1st landing page KHAS
    public function SettlementKhasLandDc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');


        // todo
        $firstProceedingCount = $this->SettlementMbDcModel->countAllPendingSettlementKhas($dist_code);
        $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACNoticeCount     = $this->SettlementMbDcModel->countMarkAsSDLACSettlementKhas($dist_code);
        $SDLACReportCount     = $this->SettlementMbDcModel->countAllProposalSendByDcToSdlacKhas($dist_code);;
        $caseStatusCount      = 0;
        $sdlacMemberApproval  = $this->SettlementMbDcModel->countSdlacStatusList($dist_code);

        // $reReportByCOCount    = $this->SettlementMbDcModel->countReRevertedByCoApplicationKhas($dist_code);
        // $approvedListCount    = $this->SettlementMbDcModel->countAllApproveAppBySdlacKhas($dist_code);
        // $rejectedListCount    = $this->SettlementMbDcModel->countAllRejectAppByDcKhas($dist_code);
        // $SDLACConsideration   = $this->SettlementMbDcModel->countAllUnderConsiderationAppKhas($dist_code);
        // $finalVerifyCaseCount = $this->SettlementMbDcModel->countAllCasesForFinalVerifyAppKhas($dist_code);
        // $revertedByDepartmentCount = $this->SettlementMbDcModel->countRevertedByDeptApplicationKhas($dist_code);
        // $chithaUpdateOrderCount    = $this->SettlementMbDcModel->countAllOrderChithaUpdateAppKhas($dist_code);
        // $rejectedCasesCount = $this->SettlementMbDcModel->rejectedCasesCount($dist_code);


        $reReportByCOCount  = 0;
        $approvedListCount  = 0;
        $rejectedListCount  = 0;
        $SDLACConsideration = 0;
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
        // $data['rejectedCasesSdoAdc'] = $rejectedCasesCount;

        $data['_view'] = 'settlementView/Dc/Khas/first_landing_page_dc_khas';
        $this->load->view('layouts/main', $data);

    }


    //***********all rejected cases by SDO/ADC */
    public function getAllRejectedCasesByAdcSdo()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $allCase = $this->SettlementMbDcModel->getAllRejectedCasesBySdoAdc($dist_code);

        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCase->result();
        $data['pendingCaseCount'] = $allCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/rejected_list_by_sdo_adc_khas';
        $this->load->view('layouts/main', $data);
    }


    // view all first Proceeding case list KHAS
    public function viewAllKhasFirstProceedingDCCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllPendingSettlementKhas($dist_code);

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

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/first_proceeding_case_dc_khas';
        $this->load->view('layouts/main', $data);

    }


    //  settlement application details KHAS
    public function getSettlementKhasApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $application_no = $this->input->get('case');
        $basic= $this->SettlementKhasModel->getSettlementBasic($application_no);
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

        $premium_data = $this->SettlementCommonModel->getPremium($application_no);
        $data['premium_data'] = $premium_data;
        $data['premium'] = $premium_data;

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

        $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->SettlementKhasLandDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']= $checkAreaDetails['chithaArea'];
            $data['reservedArea']= $checkAreaDetails['reservedArea'];
            $data['areaCheck']= $checkAreaDetails['areaCheck'];
            $data['appliedDags']= $checkAreaDetails['appliedDags'];

            $caseDetails = $this->SettlementMbDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementMbDcModel->getSettlementProceeding($case_no);
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


            $data['_view'] = 'settlementView/Dc/Khas/settlement_app_details_khas';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all mark as SDLAC KHAS
    public function viewAllMarkAsSDLACListForDCKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getMarkAsSDLACSettlementKhas($dist_code);

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

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();


        $data['_view'] = 'settlementView/Dc/Khas/mark_as_sdlac_case_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all proposal list for KHAS
    public function getAllProposalListSdlacKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllProposalSendByDcToSdlacKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/proposal_list_send_to_sdlac_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all SDLAC Under consideration KHAS
    public function getAllUnderConSdlacKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllUnderConSettlementKhas($dist_code);

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

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/under_consideration_case_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report KHAS
    public function getAllApplicationInReportSendByDcToSdlacKhas()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposal_no);
        $proposalDetails = $this->SettlementMbDcModel->getProposalDetailsById($proposal_no,$dist_code);

        $commMembers = $this->SettlementMbDcModel->getMembersFromUsers($this->session->userdata('dist_code'));

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;
        $data['committeeList']    = $commMembers;

        $data['_view'] = 'settlementView/Dc/Khas/send_to_sdlac_case_dc_khas';
        $this->load->view('layouts/main', $data);

    }


    // generate proposal notice KHAS
    public function generateNoticeSendAllMarkAppToSDLACByDcKhas()
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
                    'created_by' => MB_DEPUTY_COMM,
                    'proposal_name' => strtoupper($proposalName)

                );
                $this->db->trans_begin();
                if($this->SettlementMbDcModel->saveProposalSDLACKhas($dataProSave) == 0)
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

                        if($this->SettlementMbDcModel->saveProposalCaseListSDLACKhas($saveCaseList) == 0)
                        {
                            // $this->SettlementMbDcModel->deleteProposalSDLAC($proposalId);

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

                        if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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


    // get all DC approved list KHAS
    public function getAllApprovedBySDLACListKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllApproveAppBySdlacKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/approve_list_by_sdlac_khas';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application KHAS
    public function viewApprovedAppDetailsKhas()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
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
        $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);
        $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        // $data['deleted_dags']=$this->SettlementCommonModel->getDeletedDags($application_no);

        $premium_data = $this->SettlementCommonModel->getPremium($application_no);
        $data['premium_data'] = $premium_data;
        $data['premium'] = $premium_data;


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
        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
        if($rejected_data == 'n')
        {
            $data['rejected_list'] = false;
        }
        else
        {
            $data['rejected_list'] = $rejected_data;
        }


        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $data['guar_rel'] = $relation_executation->result();
        }

        //   calling API for self declaration data

        // $lmdata['pattaNo']=$this->utilityclass->getPattaTypeNo($lmdata['basic']["dist_code"],$lmdata['basic']["subdiv_code"],$lmdata['basic']["cir_code"],$lmdata['basic']["mouza_pargona_code"],$lmdata['basic']["lot_no"],$lmdata['basic']["vill_townprt_code"],$lmdata['dags']["dag_no"]);

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

        $caseCount = $this->SettlementMbDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->SettlementKhasLandDc();
        }
        else
        {

            $caseDetails = $this->SettlementMbDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementMbDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            $data['_view'] = 'settlementView/Dc/Khas/settlement_app_details_only_view_khas';
            $this->load->view('layouts/main', $data);
        }
    }


    // get all rejected app by dc KHAS
    public function getAllRejectByDcListKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllRejectAppByDcKhas($dist_code);
        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/rejected_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application KHAS
    public function viewRejectedAppDetailsKhas()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
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

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        $data['premium_data'] = $premium_data;
        $data['premium'] = $this->SettlementCommonModel->getPremium($application_no);

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

        // $lmdata['pattaNo']=$this->utilityclass->getPattaTypeNo($lmdata['basic']["dist_code"],$lmdata['basic']["subdiv_code"],$lmdata['basic']["cir_code"],$lmdata['basic']["mouza_pargona_code"],$lmdata['basic']["lot_no"],$lmdata['basic']["vill_townprt_code"],$lmdata['dags']["dag_no"]);

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

        $caseCount = $this->SettlementMbDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->SettlementKhasLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementMbDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementMbDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);


            $data['_view'] = 'settlementView/Dc/Khas/settlement_app_details_rejected_only_view_khas';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all chitha update application KHAS
    public function getAllOrderChithaUpdateForDcAppKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllOrderChithaUpdateAppKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/order_chitha_update_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC KHAS
    public function getAllReReportAppByCOForDcAppKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getReRevertedByCoApplicationKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/re_revert_by_co_list_khas';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC KHAS
    public function getAllRevertedAppByDeptForDcAppKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getRevertedByDeptApplicationKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/revert_by_dept_list_khas';
        $this->load->view('layouts/main', $data);
    }


    // Application Order for payment generate Dc
    public function applicationPaymentGenerateDcKhas()
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
            $caseCount = $this->SettlementMbDcModel->caseForDcApprovalKhas($case_no,$dist_code);
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
                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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


    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOKhas()
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
            $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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

                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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


    // proposal Forward For Final Verify By DC
    public function proposalForwardToDcForFinalVerifyKhas()
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
            $pendingCase = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposal_no);
            $cases       = $pendingCase->result();
            $caseCount   = $pendingCase->num_rows();
            $proposalDetails = $this->SettlementMbDcModel->getProposalDetailsById($proposal_no,$dist_code);
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
                    if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
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
                        'from_office'     => MB_DEPUTY_COMM,
                        'dc_code'         => $user_code,
                        'sdlac_approval'  => 'Y',
                        'sdlac_date'      => date('Y-m-d h:i:s'),
                        'dc_proceeding'   => 1,
                        'final_status'    => MB_APPROVED_BY_SDLAC,
                        'sdlace_proposal_no' => trim($case->proposal_id),
                    );
                    if($this->SettlementMbDcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
                    {
                        $this->db->trans_rollback();
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
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status' => MB_FINAL_APPROVED_BY_DC,
                        'user_code'  => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
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
                    $task   = MB_DEPUTY_COMM;
                    $pen    = MB_DEPUTY_COMM;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
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
                    if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
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
                    if($this->SettlementMbDcModel->updateSettlementBasicData($caseNo,$dist_code,$updateBasicData)== 0)
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
                            'status'         => PRO_CASE_STATUS_REJECT,
                            'approved_by_dc' => 0,
                        );
                        $mmnn = $this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updatePro);
                        if($mmnn == 0)
                        {
                            $this->db->trans_rollback();
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
                            'date_of_hearing' => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'status' => MB_FINAL_APPROVED_BY_DC,
                            'user_code'  => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d h:i:s'),
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
                            $task   = MB_DEPUTY_COMM;
                            $pen    = null;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            if(trim($rtps_status)!="y")
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
            if($this->SettlementMbDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
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


    // get all proposal for final verify
    public function getAllProposalForFinalVerification()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $allCase = $this->SettlementMbDcModel->getAllCasesForFinalVerifyAppKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCase->result();
        $data['pendingCaseCount'] = $allCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/final_verify_list_by_dc_khas';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report KHAS
    public function getAllApplicationInSdlacReportForVerifyKhas()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposal_no);
        $proposalDetails = $this->SettlementMbDcModel->getProposalDetailsById($proposal_no,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;

        $data['_view'] = 'settlementView/Dc/Khas/final_verify_sdlac_case_dc_khas';
        $this->load->view('layouts/main', $data);

    }


    // final approve the proposal
    public function finalApproveTheProposalByDcKhas()
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
            $proposal_no = trim($this->input->post('proposalNo'));
            $dist_code   = $this->session->userdata('dist_code');
            $proposalDetails = $this->SettlementMbDcModel->getProposalDetailsById($proposal_no,$dist_code);

            if(trim($proposalDetails->final_verify_status) == 0)
            {
                echo json_encode(array(
                    'responseType' => 6,
                ));
                return;
            }
            if(trim($proposalDetails->final_verify_status) == 2)
            {
                echo json_encode(array(
                    'responseType' => 7,
                ));
                return;
            }
            if(trim($proposalDetails->final_verify_status) == 1)
            {
                $pendingCase = $this->SettlementMbDcModel->getAllAppInReportSendByDcToSdlacKhas($proposal_no);
                $cases     = $pendingCase->result();
                $caseCount = $pendingCase->num_rows();
                if($caseCount == 0)
                {
                    echo json_encode(array(
                        'responseType' => 2,
                    ));
                    return;
                }
                else
                {
                    // $this->db->trans_begin();

                    foreach ($cases as $case)
                    {
                        $case_no = trim($case->case_no);

                        //********check if payment link already generated for this case */
                        $payReqGenStatu = $this->SettlementCommonDcModel->checkPaymentRequestGenerated($case_no);
                        $checkStatusProposalCases = $this->SettlementCommonDcModel->checkStatusProposalCases($case_no);

                        //******process if DC not already processed the case  */
                        if(isset($payReqGenStatu) && $checkStatusProposalCases != 'n')
                        {
                            if(trim($payReqGenStatu) == 'n' && trim($checkStatusProposalCases) == 0)
                            {
                                $this->db->trans_begin();

                                $user_code   = $this->session->userdata('user_code');
                                $proposal_id = $proposal_no;
                                $proposal_no_int = (int)$proposal_no;
                                $remarks   = 'DC verification done';
                                $caseCount = $this->SettlementMbDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($case_no,$dist_code);
                                $dag       = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
                                $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
                                $basic     = $this->SettlementKhasModel->getSettlementBasic($case_no);

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
                                        if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                        {
                                            log_message('error',"PROPOSAL####1111".$this->db->last_query());
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
                                                'approved_by_dc' => 1,
                                            );
                                            if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
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

                                    //******this is for RURAL cases normarl process */
                                    if(PAYMENT_REQUEST_AT_DC_DEPT == 0)
                                    {
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

                                            if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                            {
                                                log_message('error',"PROPOSAL####1113".$this->db->last_query());
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
                                                    'approved_by_dc' => 1,
                                                );

                                                if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
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
                                                    $pen=MB_CIRCLE_OFFICER;
                                                    $case=$case_no;
                                                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                                                    $rtps_status=json_decode($rtps_status);
                                                    //var_dump($rtps_status);
                                                    if(trim($rtps_status)!="y")
                                                    {
                                                        log_message('error',"PROPOSAL####1115".$this->db->last_query());
                                                        $this->db->trans_rollback();
                                                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                                                        redirect(base_url() . "index.php/home");
                                                    }
                                                }
                                                //////proceeding end//////
                                            }
                                        }
                                    }

                                    //***********this is for RURAL payment notice generation done here */
                                    if(PAYMENT_REQUEST_AT_DC_DEPT == 1)
                                    {
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

                                            if($this->SettlementMbDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                            {
                                                log_message('error',"PROPOSAL####1113".$this->db->last_query());
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
                                                    'approved_by_dc' => 1,
                                                );

                                                if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
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
                                                        'responseType' => 1,
                                                    ));
                                                    return;
                                                }
                                                else
                                                {
                                                    //****PAYMENT NOTICE AUTO GENERATION  */
                                                    $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
                                                    $get_buyers = $this->SettlementApModel->getBuyers($case_no);
                                                    $get_dag_details = $this->SettlementApModel->getDags($case_no);
                                                    $remark = REMARK_UNDER_PAYMENT_NOTICE;

                                                    $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();

                                                    $dag_position = 0;
                                                    $dag_length = count($get_dag_details);

                                                    $notice_dag_details = array();

                                                    foreach($get_dag_details as $dags){
                                                        $notice_dag_details[] = "<b>".$dags->dag_no."</b> 
                                                        দাগৰ, <b>".$dags->s_dag_area_b."</b> 
                                                        বিঘা <b>".$dags->s_dag_area_k."</b> 
                                                        কঠা <b>".$dags->s_dag_area_lc."</b> 
                                                        লেচা ";
                                                        if($dag_position == $dag_length - 1){
                                                            echo "";
                                                        }elseif($dag_position == ($dag_length - 2)){
                                                            echo "আৰু";
                                                        }else{
                                                            echo ",";
                                                        }
                                                        $dag_position++;
                                                    }

                                                    $notice_dag_details_list = implode ( "", $notice_dag_details );

                                                    $payment_notice_data = "<div class=\"container bg-white shadow pt-3 pb-3\" id=\"print_direct\">
                                                        <div class=\"row mt-5 text-center\">
                                                        <div class=\"col-12 text-center\" style=\"font-size: 18px; font-weight:bold;\">
                                                            <u>প্ৰিমিয়াম আদায়ৰ বাবে জাননী (গাঁৱৰ ক্ষেত্ৰত- Rural)</u>                
                                                        </div>
                                                        </div>
                                                        <div class=\"row mt-4\">
                                                        <div class=\"col-12 text-justify p-5\">
                                                            ইয়াৰ জৰিয়তে আপোনাক জনোৱা হ'ল যে, 
                                                            <b>".date("Y-m-d", strtotime($get_settlement_basic->sdlac_date))."</b>
                                                            তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি 
                                                            <b>".$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)."</b> 
                                                            মৌজাৰ,  
                                                            <b>".$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)."</b>ৰ,
                                                            <b>".$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)." </b> গাঁৱৰ, ".$notice_dag_details_list."চিলিং চৰকাৰী/ সাধাৰণ চৰকাৰী মাটিৰ পট্টনৰ বাবে আপোনাৰ আবেদন প্ৰস্তাৱ নং <b>(".$get_settlement_basic->applid.") / (".$case_no.")</b> ত অনুমোদন জনোৱা হৈছে। সেই অনুসৰি উক্ত জমি প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ নামত পট্টনৰ বাবে কৰ্তৃপক্ষই বিবেচনা কৰিছে।<br><br>
                                                            সেই সূত্ৰে আপোনাক ২৪/০৮/২০২১ ৰ চৰকাৰী অধিসূচনা RSS.502/2019/Pt/2 (ECF No. 130241/ 2020) ৰ দ্বাৰা সংশোধিত ভূমি নীতি, ২০১৯ ৰ দফা ১.১ আৰু RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314) দফা 7(IV) ৰ মতে মিছন বসুন্ধৰা ২.০ ৰ ৰেহাই হিচাপে বিঘাই প্ৰতি ধাৰ্য হোৱা ১০০ টকা হাৰত (অনুসূচিত জাতি/ অনুসূচিত জনজাতি/ বিশেষভাৱে সক্ষম ব্যক্তি / বিধবা মহিলাৰ ক্ষেত্ৰত ৰেহাই হিচাপে বিঘাই প্ৰতি ৭৫ টকা হাৰত) সৰ্বমুঠ <b>".$premium_data[0]->final_amount."</b> টকাৰ প্ৰিমিয়াম অহা ১৫ দিনৰ ভিতৰত  আদায় দিবলৈ অনুৰোধ জনোৱা হ'ল।
                                                        </div>
                                                        </div>
                                                        <div class=\"row mt-5 justify-content-end mb-5\">
                                                        <div class=\"col-5 text-center\">
                                                            <b>".$this->utilityclass->getSelectedCOName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code, $get_settlement_basic->co_code)->username.
                                                        "</b><br>
                                                            চক্ৰ বিষয়া <br> 
                                                            ".$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)."
                                                        </div>
                                                        </div>
                                                    </div>";

                                                    $base64Encoded_file = base64_encode($payment_notice_data);

                                                    if(is_dir(PAYMENT_NOTICE_PATH)===false)
                                                    {
                                                        mkdir(PAYMENT_NOTICE_PATH,0777);
                                                    }

                                                    $new_case_no = str_replace('/', "-", $case_no);

                                                    $base_64_file_path = PAYMENT_NOTICE_PATH.$new_case_no.".json";
                                                    $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                                                    $htmlstring_text = json_encode($base64Encoded_file);
                                                    fwrite($file_to_write_base64, $htmlstring_text);
                                                    fclose($file_to_write_base64);


                                                    foreach($get_buyers as $buyers)
                                                    {
                                                        $applicant_buyers_json[] =
                                                            [
                                                                'APPLICANT_ID' => $buyers->id,
                                                                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                                                                'GUARDIAN_NAME' => $buyers->pdar_guardian
                                                            ];
                                                    }
                                                    $notice_no = "MB2/PN/".date('Y')."/".SETTLEMENT_KHAS_LAND."/".$get_settlement_basic->petition_no;
                                                    $insertIntoSettlementNotice = [
                                                        'case_no'                     => $case_no,
                                                        'service_code'                => $get_settlement_basic->service_code,
                                                        'case_registration_date'      => $get_settlement_basic->submission_date,
                                                        'payment_notice_date'         => date('Y-m-d'),
                                                        'total_amount'                => $premium_data[0]->final_amount,
                                                        'sdlac_proposal_id'           => $get_settlement_basic->sdlace_proposal_no,
                                                        'sdlac_proposal_date'         => $get_settlement_basic->sdlac_date,
                                                        'applicant_details'           => json_encode($applicant_buyers_json),
                                                        //'payment_completed_date'      => date('Y-m-d'), 
                                                        'notice_no'                   => $notice_no,
                                                        'notice_link'                 => $base_64_file_path,
                                                        'notice_type'                 => 'PN'
                                                    ];
                                                    $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
                                                    if($insertIntoSettlementNotice != 1){
                                                        $this->db->trans_rollback();
                                                        log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
                                                        $json = [
                                                            'responseType' => 47,
                                                            'message' => '#ERRPN00678: Failed to generate notice. Kindly contact System Administrator',
                                                        ];
                                                        echo json_encode($json);
                                                        return false;
                                                    }
                                                    $updateArr = [
                                                        'status'             => MB_PAYMENT_NOTICE,
                                                        'dc_code'            => $this->session->userdata('user_code'),
                                                        'user_code'          => $this->session->userdata('user_code'),
                                                        'pay_notice_gen_yn'  => 'Y',
                                                        'pay_notice_gn_date' => date('Y-m-d'),
                                                        'date_update'        => date('Y-m-d h:i:s'),
                                                        'from_office'        => 'DC',
                                                        'pending_officer'    => 'CO',
                                                        'pending_office'     => 'CO',
                                                        'co_notice_link'     => $base_64_file_path
                                                    ];
                                                    $this->db->where('case_no', $case_no);
                                                    $this->db->update('settlement_basic', $updateArr);
                                                    if($this->db->affected_rows() == 0 )
                                                    {
                                                        $this->db->trans_rollback();
                                                        log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');

                                                        $json = [
                                                            'responseType' => 47,
                                                            'message' => '#ERRPN0001: Failed to generate notice. Kindly contact system administrator'.$case_no,
                                                        ];
                                                        echo json_encode($json);
                                                        return false;
                                                    }
                                                    //////proceeding start//////
                                                    $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                                                    if($proceeding_id==null){
                                                        $proceeding_id=1;
                                                    }
                                                    $insertArr = [
                                                        'case_no'               => $case_no,
                                                        'proceeding_id'         => $proceeding_id,
                                                        'date_of_hearing'       => date('Y-m-d h:i:s'),
                                                        'next_date_of_hearing'  => date('Y-m-d h:i:s'),
                                                        'note_on_order'         => $remark,
                                                        'status'                => MB_PAYMENT_NOTICE,
                                                        'user_code'             => $this->session->userdata('user_code'),
                                                        'date_entry'            => date('Y-m-d h:i:s'),
                                                        'operation'             => 'E',
                                                        'ip'                    => $this->utilityclass->get_client_ip(),
                                                        'office_from'           => 'CO',
                                                        'office_to'             => 'CO',
                                                        'task'                  => 'Payment Notice Generated'
                                                    ];
                                                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                                                    if($insertProc != 1)
                                                    {
                                                        $this->db->trans_rollback();
                                                        log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
                                                        $json = [
                                                            'responseType' => 47,
                                                            'message' => '#ERRPN0002: Failed to generate notice. Kindly contact System Administrator',
                                                        ];
                                                        echo json_encode($json);
                                                        return false;
                                                    }
                                                    if($this->db->trans_status()==FALSE)
                                                    {
                                                        $this->db->trans_rollback();
                                                        $json = [
                                                            'responseType' => 47,
                                                            'message' => '#ERRPN000234: Error in submitting. Please try Again',
                                                        ];
                                                        echo json_encode($json);
                                                        // return false;
                                                    }
                                                    else
                                                    {
                                                        $is_full_pay ='N';
                                                        $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
                                                        if($premium_tot_data->num_rows() > 0)
                                                        {
                                                            foreach($premium_tot_data->result() as $prem_records)
                                                            {
                                                                if($prem_records->area_name =='7' || $prem_records->area_name =='8' || $prem_records->area_name =='9' || $prem_records->area_name =='10')
                                                                {
                                                                    $is_full_pay ='Y';
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $this->db->trans_rollback();
                                                            log_message('error', '#BACKUP003277: Premium payment type not found. Case No '.$case_no);
                                                            $json = [
                                                                'responseType' => 47,
                                                                'message' => '#BACKUP003277: Premium payment type not found. Case No '.$case_no,
                                                            ];
                                                            echo json_encode($json);
                                                            return false;
                                                        }

                                                        $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
                                                        $basundhara = $this->db->query($sql)->row();

                                                        // call api to upload notice
                                                        $curl_handle = curl_init();
                                                        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."uploadNotice");
                                                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                                                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                                                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                                                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                                                            'encoded_file' => json_decode($htmlstring_text),
                                                            'application_no' => $basundhara->basundhara,
                                                            'type' => 'PN',
                                                            'amount' => $premium_data[0]->final_amount,
                                                            'is_full_pay' => $is_full_pay
                                                        )));
                                                        $result = curl_exec($curl_handle);

                                                        if (trim($result) != 'y')
                                                        {
                                                            $this->db->trans_rollback();

                                                            $rejected_failed_arr = [
                                                                'case_no' => $case_no,
                                                                'remarks' => json_encode(array(
                                                                    'encoded_file' => $htmlstring_text,
                                                                    'application_no' => $basundhara->basundhara,
                                                                    'type' => 'PN',
                                                                    'amount' => $premium_data[0]->final_amount,
                                                                    'is_full_pay' => $is_full_pay))
                                                            ];

                                                            $rejected_failed_insert = $this->db->insert('settlement_failed_api', $rejected_failed_arr);

                                                            if($rejected_failed_insert != 1)
                                                            {
                                                                log_message('error', '#ERREJ0033035: API failed.');
                                                                $json = [
                                                                    'responseType' => 47,
                                                                    'message' => '#TRIBALPAYAPI044011: Failed to process! Contact admin...'.$case_no,
                                                                ];
                                                                echo json_encode($json);
                                                                return false;
                                                            }

                                                            $json = [
                                                                'responseType' => 47,
                                                                'message' => '#TRIBALPAYAPI0011  Payment notice  could not be generated !'.$case_no,
                                                            ];
                                                            echo json_encode($json);
                                                            return false;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //**************insert into c_land_bank_details  */
                                    $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
                                    foreach($applicants_encroacher as $applicant_enc)
                                    {
                                        $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($case_no), $applicant_enc->dag_no));

                                        if($enc_check->num_rows() > 0)
                                        {

                                            $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid,$enc_check->row()->dag_no,$enc_check->row()->encroacher_id));

                                            // echo $this->db->last_query();
                                            if($sql_land_bank->num_rows() > 0){
                                                $lb_details_id = $sql_land_bank->row()->land_bank_details_id;
                                                $elb_enc_id = $sql_land_bank->row()->enc_id;
                                                $uuid = $sql_land_bank->row()->uuid;
                                                $dag_no = $sql_land_bank->row()->dag_no;
                                                $application_no = $sql_land_bank->row()->application_no;
                                                $lb_approval_rmk = "Approved by DC";

                                                $insertVLBquery = $this->SettlementMbDcModel->lbdetailsApproveSettlementCases($lb_details_id,$elb_enc_id,$uuid,$dag_no,$application_no,$lb_approval_rmk);

                                                $VLBresponse = json_decode($insertVLBquery);
                                                if($VLBresponse->responseType != 1){
                                                    $this->db->trans_rollback();
                                                    log_message('error', '#LNDBNK0002212: Insertion failed in landbank for case no :'. $case_no);
                                                    echo json_encode(array(
                                                        'responseType' => 1,
                                                    ));
                                                    return false;
                                                }
                                            }
                                        }
                                    }

                                }
                                elseif(trim($basic['final_status']) == MB_DISMISS)
                                {
                                    $updatePro = array(
                                        'status' => PRO_CASE_STATUS_REJECT,
                                        'approved_by_dc' => 1,
                                    );
                                    if($this->SettlementMbDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRUPDT001285 Insertion failed in settlement_proposal_cases!');
                                        echo json_encode(array(
                                            'responseType' => 47,
                                            'msg' => '#ERRUPDT007865: Error encountered ! Contact admin...'
                                        ));
                                        return false;
                                    }

                                    //*****update in settlement_basic */
                                    $basic_update_arr = [
                                        'status'          => MB_DISMISS,
                                        'dc_proceeding'   => 0,
                                        'pending_office'  => MB_DEPUTY_COMM,
                                        'pending_officer' => MB_DEPUTY_COMM,
                                        'from_office'     => MB_DEPUTY_COMM,
                                        'dc_code'         => $this->session->userdata('user_code'),
                                    ];

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
                                else
                                {
                                    echo json_encode(array(
                                        'responseType' => 1,
                                    ));
                                    return;
                                }

                                $this->db->trans_commit();

                            }
                        }
                    }

                    //******end foreach */

                    $this->db->trans_begin();

                    $dataUpdate = array(
                        'final_verify_status' => 2,
                        'dept_status' => 1
                    );
                    if($this->SettlementMbDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
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
            echo json_encode(array(
                'responseType' => 6,
            ));
            return;
        }
    }



    //********************** END KHAS **********************************



    //// end Masud's code

    ///// 09/02/2023

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


    // pagination of first proceeding
    public function firstProceedingPaginationAPI()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');

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
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_PENDING);
        $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
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
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/SettlementMbDc/getSettlementKhasApplicationDetails/?case='.$rows->case_no.'">Process</a>',
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

    // pagination of Second proceeding SDLAC Recommended (Marked)
    public function secondProceedingSdlacRecommendedMarked()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');

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
        $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
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
            $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                if(strtoupper($rows->is_urban) == 'Y' || (strtoupper($rows->is_urban)=='N' && strtoupper($rows->falls_und_gmc) == YES))
                { $approved_by = "<span style='color:red'>Department</span>"; }
                else { $approved_by = "<span style='color:blue'>DC</span>"; }

                $json[] = array(

                    $rows->case_no,

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success" href="'.base_url().'index.php/SettlementMbDc/getSettlementKhasApplicationDetails/?case='.$rows->case_no.'">View Application</a>'
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

    // pagination of Second proceeding SDLAC Recommended (Marked)
    //  public function rejectedCasesBySdoAdc()
    //  {
    //      $service     = $this->input->post('service');
    //      $by_case_no  = $this->input->post('case_no');
    //      $remark_cat  = $this->input->post('remark_cat');

    //      $dist_code   = $this->session->userdata('dist_code');
    //      $subdiv_code = $this->input->post('subdiv');
    //      $cir_code    = $this->input->post('circle');
    //      $mouza_code  = $this->input->post('mouza');
    //      $lot_no      = $this->input->post('lot');
    //      $village     = $this->input->post('vill_id');
    //      $ru          = $this->session->userdata('user_desig_code');

    //      $draw        = intval($this->input->post('draw'));
    //      $start       = intval($this->input->post('start'));
    //      $length      = intval($this->input->post('length'));
    //      $order       = $this->input->post('order');

    //      $col = 0;
    //      $dir = "";
    //      if(!empty($order)){
    //          foreach($order as $o){
    //              $col = $o['column'];
    //              $dir = $o['dir'];
    //          }
    //      }
    //      if($dir != "asc" && $dir != 'desc'){
    //          $dir = 'desc';
    //      }
    //      $valid_columns = array(
    //          0   => 'settlement_basic.submission_date',
    //      );
    //      if(!isset($valid_columns[$col])){
    //          $order = null;
    //      } else {
    //          $order = $valid_columns[$col];
    //      }
    //      if($order != null){
    //          $this->db->order_by($order, $dir);
    //      }
    //      if(!empty($cir_code)){
    //          $this->db->where('settlement_basic.cir_code', $cir_code);
    //      }
    //      if(!empty($village)){
    //          $this->db->where('settlement_basic.vill_townprt_code', $village);
    //          $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
    //          $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
    //          $this->db->where('settlement_basic.lot_no', $lot_no);
    //          $this->db->where('settlement_basic.vill_townprt_code', $village);
    //      }
    //      if(!empty($by_case_no)){
    //          $this->db->where('settlement_basic.case_no', $by_case_no);
    //      }
    //      if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
    //          $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
    //      }

    //      $this->db->select('*');
    //      $this->db->from('settlement_basic');
    //      $this->db->join('(select distinct on(case_no) * from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
    //      $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
    //      $this->db->where('settlement_basic.service_code', $service);
    //      $this->db->where('settlement_basic.dist_code', $dist_code);
    //      $this->db->where('settlement_basic.status', MB_REJECT_REASON_ENTERED);
    //      $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
    //      $this->db->limit($length, $start);
    //      $query = $this->db->get();

    //      if($query->num_rows() > 0) {

    //          $result = $query->result();
    //          $i=1;

    //          if(!empty($cir_code)){
    //              $this->db->where('settlement_basic.cir_code', $cir_code);
    //          }
    //          if(!empty($village)){
    //              $this->db->where('settlement_basic.vill_townprt_code', $village);
    //              $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
    //              $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
    //              $this->db->where('settlement_basic.lot_no', $lot_no);
    //              $this->db->where('settlement_basic.vill_townprt_code', $village);
    //          }
    //          if(!empty($by_case_no)){
    //              $this->db->where('settlement_basic.case_no', $by_case_no);
    //          }
    //          if(!empty($remark_cat)){  //settlement_ap_lmnote, lm_note
    //              $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
    //          }

    //          $this->db->select('*');
    //          $this->db->from('settlement_basic');
    //          $this->db->join('(select distinct on(case_no) * from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
    //          $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

    //          $this->db->where('settlement_basic.service_code', $service);
    //          $this->db->where('settlement_basic.dist_code', $dist_code);
    //          $this->db->where('settlement_basic.status', MB_REJECT_REASON_ENTERED);
    //          $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM]);
    //          $query1 = $this->db->get();
    //          $total_records = $query1->num_rows();

    //          foreach($result as $rows) {

    //              if(strtolower($rows->is_urban) == 'y' || strtolower($rows->falls_und_gmc) == 'yes') { $approved_by = "<span style='color:red'>Department</span>"; }
    //              else { $approved_by = "<span style='color:blue'>DC</span>"; }

    //             //  $viewlink = "<a href='#' onclick='rejectedModal("'"$rows->case_no"'")'>Rejected Reasons</a>";


    //             $viewlink = "<button class=\"btn btn-sm btn-info\" href=\"#\" onclick=\"rejectedModal('$rows->case_no')\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> Rejected Reasons</button>";

    //              $json[] = array(

    //                  $rows->case_no,

    //                  '<span class="px-3"><strong>' . $i . '</strong></span>',

    //                  $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

    //                  $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

    //                  $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

    //                  $viewlink,

    //                  '<a class="btn btn-sm btn-success" href="'.base_url().'index.php/SettlementMbDc/getSettlementKhasApplicationDetails/?case='.$rows->case_no.'">View Application</a>'
    //              );

    //              $i++;
    //          }

    //          $response = array(
    //              'draw' => $draw,
    //              'recordsTotal' => $total_records,
    //              'recordsFiltered' => $total_records,
    //              'data' => $json,
    //          );
    //          echo json_encode($response);
    //      }
    //      else {
    //          $response = array();
    //          $response['sEcho'] = 0;
    //          $response['iTotalRecords'] = 0;
    //          $response['iTotalDisplayRecords'] = 0;
    //          $response['aaData'] = [];
    //          echo json_encode($response);
    //      }
    //  }


    // pagination of third proceeding SDLAC Report
    public function thirdProceedingSdlacReport()
    {
        $service      = $this->input->post('service');
        $by_case_no   = $this->input->post('case_no');
        $proposal_no  = $this->input->post('proposal_no');
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = $this->session->userdata('dist_code');
        $ru           = $this->session->userdata('user_desig_code');

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
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
            $this->db->where('settlement_proposal_list.final_verify_status', 0);
        }

        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('id', $proposal_no);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
        }

        else if(!empty($hearing_date)){
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('h_date', $hearing_date);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
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
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
                $this->db->where('settlement_proposal_list.final_verify_status', 0);
            }

            else if (!empty($hearing_date)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('h_date', $hearing_date);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
            }

            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('id', $proposal_no);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
                $this->db->where('status', 1);
            }

            $query1 = $this->db->get();
            $total_records = $query1->num_rows();
            $i=1;

            foreach($result as $rows) {

                $check = $this->db->query("SELECT * FROM settlement_proposal_cases WHERE id=?",
                    array());

                $json[] = array (

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->proposal_name .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>

                  <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    '<i class="fa fa-calendar"></i> On '. date('d-m-Y', strtotime($rows->h_date)),

                    '<i class="fa fa-user"></i> '. $rows->created_by,

                    '<a class="btn btn-primary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Print Notice</a>

                <a class="btn btn-success" href="'.base_url().'index.php/SettlementMbDc/getAllApplicationInReportSendByDcToSdlacKhas/?case='.$rows->id.'">
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


    public function getCasesAgainstProposalNo(){
        $proposal_id  = $this->input->post('id');
        $service_code = $this->input->post('service_code');
        $dist_code    = $this->session->userdata('dist_code');

        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
        settlement_proposal_cases A JOIN settlement_proposal_list B ON
        B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=? AND B.service_code=?",
            array($proposal_id, $dist_code, $service_code));

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }


    // pagination of third proceeding Under Consideration
    public function thirdProceedingUnderConsideration()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');

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
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', MB_UNDER_CONSIDERATION);
        $this->db->where_in('settlement_basic.pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $total_records = $query->num_rows();
            $result = $query->result();
            $i=1;

            foreach($result as $rows) {

                $json[] = array(

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/SettlementMbDc/getSettlementKhasApplicationDetails/?case='.$rows->case_no.'">Process</a>'
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


    // check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus() {
        $proposal_id = $this->input->post('prop_id');
        $dist_code   = $this->session->userdata('dist_code');

        $processStatus = $this->SettlementCommonDcModel->checkForSdlacProcess($dist_code, $proposal_id);

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


        $this->db->trans_begin();
        foreach($detail as $row)
        {
            $caseNo= trim($row['case_no']);
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
                        'responseType' => 1,
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
                        'responseType' => 1,
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
    public function getAllSdlacMemberApprovalProposalListKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementMbDcModel->getSdlacApprovalProposalListKhas($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Khas/sdlac_approval_proposal_list_khas';
        $this->load->view('layouts/main', $data);

    }


    // get all forth proceeding SDLAC Report Khas with data
    public function getAllSdlacMemberApprovalProposalListDataKhas()
    {
        $service      = $this->input->post('service');
        $by_case_no   = $this->input->post('case_no');
        $proposal_no  = $this->input->post('proposal_no');
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = $this->session->userdata('dist_code');
        $ru           = $this->session->userdata('user_desig_code');

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
            $this->db->where('settlement_proposal_list.final_verify_status', 0);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
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
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
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
                $this->db->where('settlement_proposal_list.final_verify_status', 0);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
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
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);

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

                    '<a class="btn btn-primary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Print Notice</a>

                <a class="btn btn-success" href="'.base_url().'index.php/SettlementMbDc/getSdlacMemberApproveProposalViewIndividualKhas/?case='.$rows->id.'">
                    '.$this->lang->line('view').'</a>'
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
    public function getSdlacMemberApproveProposalViewIndividualKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $proposal_no = $this->input->get('case');
        $proposalDetails = $this->SettlementMbDcModel->getSdlacApprovalProposalIndividualKhas($proposal_no,$dist_code);
        // SDLAC/CDLAC Member report details
        $reportDetails   = $this->SettlementMbDcModel->getSdlacMemberReportDetailsKhas($proposal_no,$dist_code);

        $getMembersStatus = $this->SettlementMbDcModel->getSdlacMemberStatus($dist_code, $proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $proposalDetails->row();
        $data['pendingCaseCount'] = $proposalDetails->num_rows();
        $data['reports']          = $reportDetails->result();
        $data['reportCount']      = $reportDetails->num_rows();
        $data['getMemberStatus']  = $getMembersStatus;

        $data['_view'] = 'settlementView/Dc/Khas/sdlac_committee_report_details_khas';
        $this->load->view('layouts/main', $data);


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

}
