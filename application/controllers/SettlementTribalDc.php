<?php



class SettlementTribalDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
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
        $this->load->model('SettlementMb/SettlementTribalDcModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('SettlementMb/SettlementMbADCModel');
        $this->load->model('SettlementMb/SettlementMbSdoModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalSdoModel');
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
        }else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
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

        if($this->SettlementTribalDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $rmk='Reverted to CO';
                        $status='N';
                        $task= MB_DEPUTY_COMM;
                        $pen= MB_CIRCLE_OFFICER;
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'task'        => 'Rejected by DC'
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
                        $rmk='Rejected by DC';
                        $status='N';
                        $task= MB_DEPUTY_COMM;
                        $pen= MB_DEPUTY_COMM;
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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

                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                    $mmmmm = $this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                    if($mmmmm == 0)
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
                        $rmk='Rejected by SDLAC';
                        $status='N';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y"){
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
                    $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
                    if($caseIdSdlacProposal != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 9,
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
                    $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
                    if($checkArea != 0)
                    {
                        echo json_encode(array(
                            'responseType' => 10,
                            'application' => $case_no
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Recommended for SDLAC';
                        $status='N';
                        $task= MB_DEPUTY_COMM;
                        $pen= MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y"){
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Under SDLAC Consideration';
                        $status='N';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if(trim($rtps_status)!="y"){
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
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $sql = "SELECT *
            FROM settlement_proposal_cases
            WHERE case_no = ?
            ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;
            $proposal_id = $this->input->post('proposalId');
            $caseCount      = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->SettlementTribalDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
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

                    if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $mmmm = $this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($mmmm == 0)
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
                            if(trim($rtps_status)!="y"){
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
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

                    if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $mmmm = $this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($mmmm == 0)
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
                            if(trim($rtps_status)!="y"){
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC failed case no # $case_no");
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
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $caseCount = $this->SettlementTribalDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $caseDetails = $this->SettlementTribalDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementTribalDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tribal/payment_received_app_details_tribal';
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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

                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
    public function updateProposalHearingDateTribal()
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

            $allCases      = $this->SettlementTribalDcModel->getAllAppInReportSendByDcToSdlacTribal($proposalNo);
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
    public function updateHearingDateGenerateNoticeTribal()
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
            $proposalDetails = $this->SettlementTribalDcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementTribalDcModel->getAllAppInReportSendByDcToSdlacTribal($proposalNo);
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
                    if($this->SettlementTribalDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
    //********************** START TRIBAL **********************************

    // 1st landing page TRIBAL
    public function SettlementTribalLandDc()
    {

        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementTribalDcModel->countAllPendingSettlementTribal($dist_code);
        $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACNoticeCount     = $this->SettlementTribalDcModel->countMarkAsSDLACSettlementTribal($dist_code);
        $SDLACReportCount     = $this->SettlementTribalDcModel->countAllProposalSendByDcToSdlacTribal($dist_code);;
        $caseStatusCount      = 0;
        $sdlacMemberApproval  = $this->SettlementTribalDcModel->countSdlacStatusList($dist_code);

        // $reReportByCOCount    = $this->SettlementTribalDcModel->countReRevertedByCoApplicationTribal($dist_code);
        // $approvedListCount    = $this->SettlementTribalDcModel->countAllApproveAppBySdlacTribal($dist_code);
        // $rejectedListCount    = $this->SettlementTribalDcModel->countAllRejectAppByDcTribal($dist_code);
        // $SDLACConsideration   = $this->SettlementTribalDcModel->countAllUnderConsiderationAppTribal($dist_code);
        // $finalVerifyCaseCount = $this->SettlementTribalDcModel->countAllCasesForFinalVerifyAppTribal($dist_code);
        // $revertedByDepartmentCount = $this->SettlementTribalDcModel->countRevertedByDeptApplicationTribal($dist_code);
        // $chithaUpdateOrderCount    = $this->SettlementTribalDcModel->countAllOrderChithaUpdateAppTribal($dist_code);

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

        $data['_view'] = 'settlementView/Dc/Tribal/first_landing_page_dc_tribal';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list TRIBAL
    public function viewAllTribalFirstProceedingDCCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllPendingSettlementTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/first_proceeding_case_dc_tribal';
        $this->load->view('layouts/main', $data);

    }


    //  settlement application details TRIBAL
    public function getSettlementTribalApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $dist_code = $this->session->userdata('dist_code');
        $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        if($caseCount == 0)
        {
            $this->SettlementTribalLandDc();
        }
        else
        {
            $application_no = $this->input->get('case');
            $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
            $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
            $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
            $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
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
            $dags = $this->SettlementTribalModel->getSettlementDag($application_no);
            $lmnotes = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
            $proceedings = $this->SettlementTribalModel->getSettlementProceeding($application_no);
            $dhardocuments = $this->SettlementTribalModel->getDocuments($application_no);
            $data['basic']=$basic;
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


            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea']= $checkAreaDetails['chithaArea'];
            $data['reservedArea']= $checkAreaDetails['reservedArea'];
            $data['areaCheck']= $checkAreaDetails['areaCheck'];
            $data['appliedDags']= $checkAreaDetails['appliedDags'];

            $caseDetails = $this->SettlementTribalDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementTribalDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);

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
                if($val_bypas->SERVICE_CODE == SETTLEMENT_TRIBAL_COMMUNITY_ID)
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

            $data['_view'] = 'settlementView/Dc/Tribal/settlement_app_details_tribal';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all mark as SDLAC TRIBAL
    public function viewAllMarkAsSDLACListForDCTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getMarkAsSDLACSettlementTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/mark_as_sdlac_case_dc_tribal';
        $this->load->view('layouts/main', $data);

    }


    // get all proposal list for TRIBAL
    public function getAllProposalListSdlacTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllProposalSendByDcToSdlacTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/proposal_list_send_to_sdlac_tribal';
        $this->load->view('layouts/main', $data);
    }


    // get all SDLAC Under consideration TRIBAL
    public function getAllUnderConSdlacTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllUnderConSettlementTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/under_consideration_case_dc_tribal';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report TRIBAL
    public function getAllApplicationInReportSendByDcToSdlacTribal()
    {

        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllAppInReportSendByDcToSdlacTribal($proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/send_to_sdlac_case_dc_tribal';
        $this->load->view('layouts/main', $data);

    }


    // generate proposal notice TRIBAL
    public function generateNoticeSendAllMarkAppToSDLACByDcTribal()
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
                if($this->SettlementTribalDcModel->saveProposalSDLACTribal($dataProSave) == 0)
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

                        if($this->SettlementTribalDcModel->saveProposalCaseListSDLACTribal($saveCaseList) == 0)
                        {
                            $this->db->trans_rollback();
//                            $this->SettlementTribalDcModel->deleteProposalSDLAC($proposalId);
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

                        if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk='Send to SDLAC';
                    $status='N';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
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


    // get all DC approved list TRIBAL
    public function getAllApprovedBySDLACListTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllApproveAppBySdlacTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/approve_list_by_sdlac_tribal';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application TRIBAL
    public function viewApprovedAppDetailsTribal()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
        $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
        $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
        $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $lmdata[] = $encdata;
        }
        $data['encdata']=$lmdata;
        $dags = $this->SettlementTribalModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementTribalModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementTribalModel->getDocuments($application_no);
        $data['basic']=$basic;
        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['applicants_encroacher']=$applicants_encroacher;
        $data['reservation']=$reservation;
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


        $caseCount = $this->SettlementTribalDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementTribalLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementTribalDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementTribalDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;


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
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TRIBAL_COMMUNITY_ID);
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

            $data['_view'] = 'settlementView/Dc/Tribal/settlement_app_details_only_view_tribal';
            $this->load->view('layouts/main', $data);
        }

    }


    // get all rejected app by dc TRIBAL
    public function getAllRejectByDcListTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllRejectAppByDcTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/rejected_list_by_dc_tribal';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application TRIBAL
    public function viewRejectedAppDetailsTribal()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
        $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
        $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
        $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $lmdata[] = $encdata;
        }
        $data['encdata']=$lmdata;
        $dags = $this->SettlementTribalModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementTribalModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementTribalModel->getDocuments($application_no);
        $data['basic']=$basic;
        $data['applicants_buyers']=$applicants_buyers;
        $data['applicants_owners']=$applicants_owners;
        $data['applicants_encroacher']=$applicants_encroacher;
        $data['reservation']=$reservation;
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

        $caseCount = $this->SettlementTribalDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementTribalLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementTribalDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementTribalDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/Tribal/settlement_app_details_rejected_only_view_tribal';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all chitha update application TRIBAL
    public function getAllOrderChithaUpdateForDcAppTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllOrderChithaUpdateAppTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/order_chitha_update_list_by_dc_tribal';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC TRIBAL
    public function getAllReReportAppByCOForDcAppTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getReRevertedByCoApplicationTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/re_revert_by_co_list_tribal';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC TRIBAL
    public function getAllRevertedAppByDeptForDcAppTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getRevertedByDeptApplicationTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/revert_by_dept_list_tribal';
        $this->load->view('layouts/main', $data);
    }



    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOTribal()
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
            $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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

                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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


    //********************** END TRIBAL **********************************


    // get all forth proceeding SDLAC Report Tribal page
    public function getAllSdlacMemberApprovalProposalListTribal()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getSdlacApprovalProposalListTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/sdlac_approval_proposal_list_tribal';
        $this->load->view('layouts/main', $data);

    }


    // get all forth proceeding SDLAC Report Khas with data
    public function getAllSdlacMemberApprovalProposalListDataTribal()
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


    // get all proposal for final verify
    public function getAllProposalForFinalVerification()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $allCase = $this->SettlementTribalDcModel->getAllCasesForFinalVerifyAppTribal($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $allCase->result();
        $data['pendingCaseCount'] = $allCase->num_rows();

        $data['_view'] = 'settlementView/Dc/Tribal/final_verify_list_by_dc_tribal';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report Tribal
    public function getAllApplicationInSdlacReportForVerifyTribal()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementTribalDcModel->getAllAppInReportSendByDcToSdlacTribal($proposal_no);
        $proposalDetails = $this->SettlementTribalDcModel->getProposalDetailsById($proposal_no,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;

        $data['_view'] = 'settlementView/Dc/Tribal/final_verify_sdlac_case_dc_tribal';
        $this->load->view('layouts/main', $data);

    }


    // final approve the proposal
    public function finalApproveTheProposalByDcTribal()
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
            $proposalDetails = $this->SettlementTribalDcModel->getProposalDetailsById($proposal_no,$dist_code);

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
                $pendingCase = $this->SettlementTribalDcModel->getAllAppInReportSendByDcToSdlacTribal($proposal_no);
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
                    $this->db->trans_begin();
                    foreach ($cases as $case)
                    {
                        $case_no = $case->case_no;
                        $user_code = $this->session->userdata('user_code');
                        $proposal_id = $proposal_no;
                        $proposal_no_int = (int)$proposal_no;
                        $remarks = 'DC verification done';
                        $caseCount = $this->SettlementTribalDcModel->countSettlementApplicationDetailsByCaseNoForSDLACFinalVerify($case_no,$dist_code);
                        $dag = $this->SettlementCommonDcModel->getSettlementDagCommon($case_no);
                        $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
                        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);

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
                                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                                    if($this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
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

                                if($this->SettlementTribalDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                                {
                                    log_message('error',"PROPOSAL####111577".$this->db->last_query());
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

                                    if($this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro) == 0)
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
                            else
                            {
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
                                    $mmnn = $this->SettlementTribalDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

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

                    $dataUpdate = array(
                        'final_verify_status' => 2,
                        'dept_status' => 1
                    );
                    if($this->SettlementTribalDcModel->updateProposalListById($proposal_no,$dataUpdate)== 0)
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



//// end Masud's code



}
