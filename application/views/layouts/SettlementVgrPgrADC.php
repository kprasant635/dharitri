<?php
class SettlementVgrPgrADC extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementVgrPgrDcModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('UtilsModel');
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
        $totalAreaInApplication = 0;
        $totalAppliedAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
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
        $totalAreaInApplication = 0;
        $totalAppliedAreaInApplication = 0;
        $areaCheck = 0;
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);
        foreach ($dags as $dag)
        {
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
        $new_case_no = 'proposal_notice_'.$rand;

        if($this->SettlementVgrPgrDcModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // random file name for general
    function randomFileNameGeneral()
    {
        $rand = rand(000000,999999);
        $new_case_no = 'general_notice_'.$rand;

        if($this->SettlementVgrPgrDcModel->checkDuplicateFileNameInGeneral($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // get Error Page
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                        $rmk='Reverted by DC.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status=="n")
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        //var_dump($rtps_status);
                        if($rtps_status=="n")
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
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
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                    $reza = $this->SettlementVgrPgrDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);
                    if($reza == 0)
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
                        $rmk='Rejected by SDLAC.';
                        $status='M';
                        $task=MB_DEPUTY_COMM;
                        $pen=null;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status=="n")
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
            $hearingDate = $this->input->post('hearingDate');
            $dist_code   = $this->session->userdata('dist_code');
            $remarks     = $this->input->post('remarks');
            $allSelectedList = $this->input->post('selectedList');
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();

            if($currentDate > $hearingDate)
            {
                echo json_encode(array(
                    'responseType' => 1,
                ));
            }

            if(!empty($allSelectedList))
            {
                foreach ($allSelectedList as $row)
                {
                    $case_no = $row;
                    $this->utilityclass->checkUserAuthForCaseForDc($case_no);
                    $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                    $caseIdSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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
                    'status'  => MB_UNDER_CONSIDERATION,
                    'dc_code' => $user_code,
                );

                $this->db->trans_begin();
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        'status' => MB_UNDER_CONSIDERATION,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => 'Under SDLAC Consideration',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => MB_DEPUTY_COMM,
                        'office_to' => MB_DEPUTY_COMM,
                        'task' => 'Under SDLAC Consideration.'
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
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $sql = "SELECT *
            FROM settlement_proposal_cases
            WHERE case_no = ?
            ORDER BY proposal_id DESC LIMIT 1";
            $proposal_no = $this->db->query($sql, array($case_no))->row();
            $proposal_no_int = (int)$proposal_no->proposal_id;
            $proposal_id = $this->input->post('proposalId');
            $caseCount      = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNoForSDLAC($case_no,$dist_code);
            $caseCountInPro = $this->SettlementVgrPgrDcModel->countSettlementAppDetailsByCaseNoUnderProposal($case_no);
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
                    if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $reza = $this->SettlementVgrPgrDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($reza == 0)
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
                            $proceeding_id = 1;
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
                            'task'        => 'Approved by SDLAC/CDLAC',
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
                            $rmk='Approved by SDLAC/CDLAC';
                            $status='M';
                            $task=MB_DEPUTY_COMM;
                            $pen=MB_DEPARTMENT;
                            $case=$case_no;
                            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                            $rtps_status=json_decode($rtps_status);
                            //var_dump($rtps_status);
                            if($rtps_status=="n")
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAPP0003: Approved by SDLAC/CDLAC failed case no # $case_no");
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
                    if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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

                        $reza = $this->SettlementVgrPgrDcModel->updateSettlementAppDetailsByCaseNoUnderProposal($case_no,$updatePro);

                        if($reza == 0)
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
                            $proceeding_id = 1;
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
                            if($rtps_status=="n"){
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

        $application_no = $this->input->get('case');
        $basic = $this->SettlementVgrModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($application_no);
        $dags = $this->SettlementVgrModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($application_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($application_no);

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
        $data['reservation']=$reservation;

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
        foreach($output->selfDeclaration as $selfDec){
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementVgrPgrDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->getErrorPage();
        }
        else
        {
            $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementVgrPgrDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/VgrPgr/payment_received_app_details_vgr_pgr';
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementPaymentReceivedAppDetailsByCaseNo($case_no,$dist_code);
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
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        //var_dump($rtps_status);
                        if($rtps_status=="n")
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
    public function updateProposalHearingDateVgrPgr()
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

            $allCases      = $this->SettlementVgrPgrDcModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposalNo);
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
    public function updateHearingDateGenerateNoticeVgrPgr()
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

            $proposalDetails = $this->SettlementVgrPgrDcModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementVgrPgrDcModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposalNo);
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
                    if($this->SettlementVgrPgrDcModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
    //********************** START VGR PGR **********************************

    // 1st landing page VGR PGR
    public function SettlementVgrPgrLandDc()
    {

        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        // todo
        $firstProceedingCount = $this->SettlementVgrPgrDcModel->countAllPendingSettlementVgrPgr($dist_code);
        $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACNoticeCount     = $this->SettlementVgrPgrDcModel->countMarkAsSDLACSettlementVgrPgr($dist_code);
        $SDLACReportCount     = $this->SettlementVgrPgrDcModel->countAllProposalSendByDcToSdlacVgrPgr($dist_code);;
        $caseStatusCount      = 0;
        $reReportByCOCount    = $this->SettlementVgrPgrDcModel->countReRevertedByCoApplicationVgrPgr($dist_code);
        $approvedListCount    = $this->SettlementVgrPgrDcModel->countAllApproveAppBySdlacVgrPgr($dist_code);
        $rejectedListCount    = $this->SettlementVgrPgrDcModel->countAllRejectAppByDcVgrPgr($dist_code);
        $SDLACConsideration   = $this->SettlementVgrPgrDcModel->countAllUnderConsiderationAppVgrPgr($dist_code);
        $revertedByDepartmentCount = $this->SettlementVgrPgrDcModel->countRevertedByDeptApplicationVgrPgr($dist_code);
        $chithaUpdateOrderCount    = $this->SettlementVgrPgrDcModel->countAllOrderChithaUpdateAppVgrPgr($dist_code);

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
        $data['chithaUpdateOrderCount']    = $chithaUpdateOrderCount;
        $data['revertedByDepartmentCount'] = $revertedByDepartmentCount;

        $data['_view'] = 'settlementView/Adc/VgrPgr/first_landing_page_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list VGR PGR
    public function viewAllVgrPgrFirstProceedingDCCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllPendingSettlementVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['_view'] = 'settlementView/Dc/VgrPgr/first_proceeding_case_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);

    }


    //  settlement application details VGR PGR
    public function getSettlementVgrPgrApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $dist_code = $this->session->userdata('dist_code');
        $application_no = $this->input->get('case');
        $basic = $this->SettlementVgrModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($application_no);
        $dags = $this->SettlementVgrModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($application_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($application_no);

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
        $data['reservation']=$reservation;

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
        $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandDc();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

            $data['chithaArea']= $checkAreaDetails['chithaArea'];
            $data['reservedArea']= $checkAreaDetails['reservedArea'];
            $data['areaCheck']= $checkAreaDetails['areaCheck'];
            $data['appliedDags']= $checkAreaDetails['appliedDags'];

            $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings = $this->SettlementVgrPgrDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }

            $data['_view'] = 'settlementView/Dc/VgrPgr/settlement_app_details_vgr_pgr';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all mark as SDLAC VGR PGR
    public function viewAllMarkAsSDLACListForDCVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getMarkAsSDLACSettlementVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/mark_as_sdlac_case_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);

    }


    // get all SDLAC Under consideration VGR PGR
    public function getAllUnderConSdlacVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllUnderConSettlementVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/under_consideration_case_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // get all proposal list for VGR PGR
    public function getAllProposalListSdlacVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllProposalSendByDcToSdlacVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/proposal_list_send_to_sdlac_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // get all application send by dc to sdlac for report VGR PGR
    public function getAllApplicationInReportSendByDcToSdlacVgrPgr()
    {
        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposal_no);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/send_to_sdlac_case_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);

    }


    // generate proposal notice VGR PGR
    public function generateNoticeSendAllMarkAppToSDLACByDcVgrPgr()
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
            $currentDate = date('Y-m-d');
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

            if($currentDate > $hearingDate)
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
                if($this->SettlementVgrPgrDcModel->saveProposalSDLACVgrPgr($dataProSave) == 0)
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

                        if($this->SettlementVgrPgrDcModel->saveProposalCaseListSDLACVgrPgr($saveCaseList) == 0)
                        {
                            $this->db->trans_rollback();
//                            $this->SettlementVgrPgrDcModel->deleteProposalSDLAC($proposalId);
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

                        if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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


    // get all DC approved list VGR PGR
    public function getAllApprovedBySDLACListVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllApproveAppBySdlacVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/approve_list_by_sdlac_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // view Approve Application VGR PGR
    public function viewApprovedAppDetailsVgrPgr()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);
        $application_no = $this->input->get('case');
        $basic = $this->SettlementVgrModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($application_no);
        $dags = $this->SettlementVgrModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($application_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($application_no);

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
        $data['reservation']=$reservation;

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
        foreach($output->selfDeclaration as $selfDec){
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }
        $caseCount = $this->SettlementVgrPgrDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementVgrPgrDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/VgrPgr/settlement_app_details_only_view_vgr_pgr';
            $this->load->view('layouts/main', $data);
        }
    }


    // get all rejected app by dc VGR PGR
    public function getAllRejectByDcListVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllRejectAppByDcVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/rejected_list_by_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // view Rejected Application VGR PGR
    public function viewRejectedAppDetailsVgrPgr()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $this->utilityclass->checkUserAuthForCaseForDc($case_no);

        $application_no = $this->input->get('case');
        $basic = $this->SettlementVgrModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($application_no);
        $dags = $this->SettlementVgrModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($application_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($application_no);

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
        $data['reservation']=$reservation;

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
        foreach($output->selfDeclaration as $selfDec){
            $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $caseCount = $this->SettlementVgrPgrDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);

        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandDc();
        }
        else
        {
            $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code);
            $proceedings = $this->SettlementVgrPgrDcModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            $data['_view'] = 'settlementView/Dc/VgrPgr/settlement_app_details_rejected_only_view_vgr_pgr';
            $this->load->view('layouts/main', $data);
        }
    }


    // view all chitha update application VGR PGR
    public function getAllOrderChithaUpdateForDcAppVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getAllOrderChithaUpdateAppVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/order_chitha_update_list_by_dc_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // view all Re-Report by CO application for DC VGR PGR
    public function getAllReReportAppByCOForDcAppVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getReRevertedByCoApplicationVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/re_revert_by_co_list_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // view all Reverted by DEPT application for DC VGR PGR
    public function getAllRevertedAppByDeptForDcAppVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $pendingCase = $this->SettlementVgrPgrDcModel->getRevertedByDeptApplicationVgrPgr($dist_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Dc/VgrPgr/revert_by_dept_list_vgr_pgr';
        $this->load->view('layouts/main', $data);
    }


    // generate general notice
    public function generateGeneralNotice()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
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
            $dist_code = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $get_dag_details = $this->SettlementVgrPgrDcModel->getReservationDetails($case_no,$dist_code);

                $applicantDetail =$this->SettlementCommonDcModel->getApplicantDetails($case_no);

                $dist_name    = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name  = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code);
                $mouza_name   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code);
                $village_name = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code);

                $notice_no = "MB2/GN/".date('Y')."/SVGR/".$caseDetails->petition_no;

                echo json_encode(array(
                    'responseType' => 2,
                    'case_no' => $case_no,
                    'hearing_date' => date("F j, Y",strtotime($hearing_date)),
                    'caseDetails' => $caseDetails,
                    'applicantName' => $applicantDetail,
                    'dist_name' => $dist_name,
                    'circle_name' => $circle_name,
                    'mouza_name' => $mouza_name,
                    'village_name' => $village_name,
                    'get_dag_details' => $get_dag_details,
                    'notice_no' => $notice_no,
                ));
                return;
            }
        }
    }


    // save general notice
    public function saveGeneralNoticeVgrPgr()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('htmlstring_text', 'Notice', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $dist_code = $this->session->userdata('dist_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForDc($case_no);
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails = $this->SettlementVgrPgrDcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $applicantDetails = $this->SettlementApModel->getAllApplicant($case_no);
                $notice_no = "MB2/GN/".date('Y')."/SVGR/".$caseDetails->petition_no;

                $new_case_no = $this->randomFileNameGeneral();

                if(is_dir(GENERAL_NOTICE_PATH_DC)===false)
                {
                    mkdir(GENERAL_NOTICE_PATH_DC,0777);
                }

                $base_64_file_path    = GENERAL_NOTICE_PATH_DC.$new_case_no.".json";
                $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
                fwrite($file_to_write_base64, $htmlstring_text);
                fclose($file_to_write_base64);

                foreach($applicantDetails as $buyers){
                    $applicant_buyers_json[] = [
                        'APPLICANT_ID' => $buyers->id,
                        'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                        'GUARDIAN_NAME' => $buyers->pdar_guardian
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
                    'hearing_date'           => $hearing_date
                ];
                $this->db->trans_begin();
                $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
                if($insertIntoSettlementNotice != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');

                    echo json_encode(array(
                        'responseType' => 5,
                    ));
                    return;
                }
                $updateData = array(
                    'general_notice_dc' => 'y',
//                    'dc_proceeding'     => 1,
                );
                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }

                $this->db->trans_commit();
                echo json_encode(array(
                    'responseType' => 2,
                ));
                return;
            }
        }
    }


    // view general notice
    public function viewGeneralNoticeVgrPgr()
    {
        $case_no = $this->input->get('case');
        $noticeDetails = $this->SettlementVgrPgrDcModel->getGeneralNoticeDetails($case_no);
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

        $data['_view'] = 'settlementView/Dc/VgrPgr/general_notice_print';

        $this->load->view('layouts/main',$data);
    }



    // application revert to co by SDLAC
    public function applicationRevertFromSDLACToCOVgrPgr()
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
            $caseCount = $this->SettlementVgrPgrDcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
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

                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        if($rtps_status=="n")
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

                if($this->SettlementVgrPgrDcModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
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
                        if($rtps_status=="n")
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


    //********************** END VGR PGR **********************************





//// end Masud's code



}
