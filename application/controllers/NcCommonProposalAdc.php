<?php

class NcCommonProposalAdc extends CI_Controller
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
        $this->load->model('NcModel/NcCommonAdcModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('NcModel/NcPullModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('UtilsModel');
        $this->load->model('ProgressModel');

        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code != MB_ADD_DEPUTY_COMM){
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }


    }


    // NC code by Masud Reza (01/03/2024)

    //////////////// *************** **************** ////////////////



    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
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


    // view page SDLAC Proposal
    public function commonProposalListViewAdc()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $createdBy   = trim($this->session->userdata('user_desig_code'));

        $data['countPendingCase'] = $this->NcCommonSdoAdcDcModel->getPendingProposalsReadyForMeeting($dist_code,MB_ADD_DEPUTY_COMM);
        $commMembers              = $this->NcCommonSdoAdcDcModel->getMembersFromUsersWithUserType($dist_code);
        $data['committeeList']    = $commMembers;
        $getDistrict              = $this->NcCommonSdoAdcDcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();
        $data['dist_code']        = $dist_code;
        $data['subdiv_code']      = $subdiv_code;
        

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->ncutility->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'NcVillageService/NcProposalAdc/common_proposal_list_forward_to_adc';
        $this->load->view('layouts/main', $data);
    }


    // list of common proposals for all services
    public function listOfProposalsAllServicesAdc()
    {

        $cir_code    = trim($this->input->post('circle'));
        $mouza_code  = trim($this->input->post('mouza'));
        $lot_no      = trim($this->input->post('lot'));
        $village     = trim($this->input->post('vill_id'));
        $service     = trim($this->input->post('service_code'));
        $by_case_no  = trim($this->input->post('case_no'));
        $proposal_no = trim($this->input->post('proposal_no'));
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $userCode    = trim($this->session->userdata('user_desig_code'));
        $draw        = intval($this->input->post('draw'));
        $start       = intval($this->input->post('start'));
        $length      = intval($this->input->post('length'));
        $order       = $this->input->post('order');
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
            $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('settlement_proposal_list.nc', 1);
            $this->db->where('settlement_proposal_list.meeting_create_status', 1);
            $this->db->where('settlement_proposal_list.user_code', $adc_code);
        }
        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('nc', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('meeting_create_status', 1);
            $this->db->where('id', $proposal_no);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('user_code', $adc_code);

        }
        else if (!empty($service)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('nc', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('meeting_create_status', 1);
            $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
            $this->db->where('user_code', $adc_code);

        }

        $this->db->select('*');
        $this->db->where('settlement_proposal_list.dist_code', $dist_code);
        $this->db->where('settlement_proposal_list.meeting_create_status', 1);
        $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
        $this->db->where('settlement_proposal_list.nc', 1);
        $this->db->where('settlement_proposal_list.user_code', $adc_code);
        $this->db->where_in('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
        $this->db->limit($length, $start);
        $this->db->order_by('settlement_proposal_list.id', 'asc');
        $query = $this->db->get('settlement_proposal_list');



        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($by_case_no)) { //join table settlement_proposal_cases
                $this->db->select('*');
                $this->db->from('settlement_proposal_cases');
                $this->db->join('settlement_proposal_list', 'settlement_proposal_cases.proposal_id = settlement_proposal_list.id');
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_list.status', 1);
                $this->db->where('settlement_proposal_list.nc', 1);
                $this->db->where('settlement_proposal_list.user_code', $adc_code);
                $this->db->where('settlement_proposal_list.sdlac_prceed_status', 2);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where('settlement_proposal_list.created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('settlement_proposal_list.meeting_create_status', 1);
            }
            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('nc', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('meeting_create_status', 1);
                $this->db->where('id', $proposal_no);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('user_code', $adc_code);
            }

            else if (!empty($service)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('nc', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('meeting_create_status', 1);
                $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
                $this->db->where('user_code', $adc_code);
            }

            $this->db->select('*');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('meeting_create_status', 1);
            $this->db->where('nc', 1);
            $this->db->where('user_code', $adc_code);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where_in('created_by', MB_ADD_DEPUTY_COMM);
            $query1 = $this->db->get('settlement_proposal_list');

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                $json[] = array(

                    $rows->id,

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    '<b>'. $rows->proposal_name .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>
                <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    $this->ncutility->getServiceName($rows->service_code),

                    date('d-M-Y', strtotime($rows->h_date)),

                    '<a class="btn btn-xs btn-primary" style=" padding: 7px!important; margin-bottom: 5px!important;" target= "SDLACProposalNotice" href="'.base_url().'index.php/NcCommonSdoAdcDc/getProposalNotice/?case='.$rows->id.'">
                        <i class="fa fa-print" aria-hidden="true"></i> Notice
                    </a>
                         
                    <a class="btn btn-xs btn-dark" style=" padding: 7px!important; margin-bottom: 5px!important;" target= "SDLACProposalNotice" href="'.base_url().'index.php/NcCommonSdoAdcDc/downloadCasesWithProposalId/?case='.$rows->id.'">
                        <i class="fa fa-download" aria-hidden="true"></i> Excel
                    </a>
                    
                    <a class="btn btn-xs btn-success" style=" padding: 7px!important; margin-bottom: 5px!important;" target= "SDLACProposalNotice" href="'.base_url().'index.php/NcCommonProposalAdc/proposalEditOnSdlacMinutesAdc/?case='.$rows->id.'">
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


    // proposal edit option from sdlac minutes Sdo
    public function proposalEditOnSdlacMinutesAdc()
    {
        $proposal_no     = trim($this->input->get('case'));
        $dist_code       = $this->session->userdata('dist_code');
        $pendingCase     = $this->NcCommonSdoAdcDcModel->getAllCaseInProposalUnderRevertedMeeting($proposal_no);
        $proposalDetails = $this->NcCommonSdoAdcDcModel->getRevertedProposalDetailsByIdAdc($proposal_no,$dist_code);

        if($proposalDetails->meeting_create_status != 1)
        {
            $this->session->set_flashdata('error', "Proposal already add in Meeting !");
            redirect(base_url() . "index.php/NcCommonProposalAdc/listOfProposalsAllServicesAdc");
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

        $data['_view'] = 'NcVillageService/NcProposalAdc/edit_proposal_from_sdlac_minutes_adc';
        $this->load->view('layouts/main', $data);

    }


    // get case list by pro id
    public function getCasesAgainstProposalNoSdlac()
    {
        $proposal_id  = $this->input->post('id');
        $dist_code    = $this->session->userdata('dist_code');
        $user_code    = $this->session->userdata('user_code');

        $result = $this->NcCommonSdoAdcDcModel->getCasesAgainstProposalIdSDLAC($proposal_id, $dist_code);

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }


    // application revert to co from proposal Under SDLAC Minutes
    public function applicationRevertToCoFromProposalUnderMinutes()
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
            $proposalCaseId  = trim($this->input->post('proCaseId'));
            $revertRemarks   = trim($this->input->post('revertRemarks'));
            $case_no         = trim($this->input->post('applicationNo'));
            $proposalId      = trim($this->input->post('selectProposalId'));
            $dist_code       = $this->session->userdata('dist_code');
            $user_code       = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');

            if($this->NcCommonSdoAdcDcModel->countSettlementProposalList($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003566: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003579: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003581: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
            if($caseDetails->status != MB_SEND_TO_SDLAC)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003591: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }

            // proposal in meeting or not
            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id != '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR003602: Proposal not assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->NcCommonSdoAdcDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
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
                $requested = $this->NcPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
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
                'deleted_by'  => $user_code,
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR00253637: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR00253637: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->NcCommonSdoAdcDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR003650: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
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
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->NcCommonSdoAdcDcModel->updateNcBasicDataAdc($case_no,$dist_code,$caseDetails->service_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
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
                    'user_code'     => $user_code,
                    'date_entry'    => date('Y-m-d h:i:s'),
                    'operation'     => 'E',
                    'ip'            => $this->utilityclass->get_client_ip(),
                    'office_from'   => $user_desig_code,
                    'office_to'     => MB_CIRCLE_OFFICER,
                    'task'          => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR003706: Insertion failed in settlement_proceeding for case no :'. $case_no);
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
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => ''
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->where('nc',1);
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
                            'user_code'            => $user_code,
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
                            log_message('error', '#MRPULL0003896: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0003896: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = $caseDetails->applid;
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $user_desig_code;
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;
                    $rtps_status = $this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
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


    // check all SDLAC/CDLAC Member b4 meeting create
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


    // add member to copy to (minutes)
    public function addEditCopyToNc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $userMp = $this->NcCommonSdoAdcDcModel->getUsersMp($dist_code, $subdiv_code);
        $data['userMp_count'] = $userMp->num_rows();
        $data['userMp_name']  = $userMp->result();

        $userMla = $this->NcCommonSdoAdcDcModel->getUsersMla($dist_code, $subdiv_code);
        $data['userMla_count'] = $userMla->num_rows();
        $data['userMla_list']  = $userMla->result();

        $usersdlc = $this->NcCommonSdoAdcDcModel->getUsersSdlac($dist_code, $subdiv_code);
        $data['usersdlc_count'] = $usersdlc->num_rows();
        $data['usersdlc_list']  = $usersdlc->result();

        $data['dist_code']   = $dist_code;
        $data['subdiv_code'] = $subdiv_code;

        $inserted_data = $this->NcCommonSdoAdcDcModel->getCopyToData($dist_code, $subdiv_code,$user_desig_code);


        if($inserted_data->num_rows() > 0)
        {
            $data['isInserted'] = true;
            $data['inserted_data'] = $inserted_data->result();
        }
        else
        {
            $data['isInserted'] = false;
        }


        $data['_view'] = 'NcVillageService/DcAdcSdoCommon/add_edit_copy_to';
        $this->load->view('layouts/main', $data);
    }


    //save sdlac CC data
    public function saveCcDataNc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $this->db->trans_begin();
        $this->db->query("DELETE FROM minute_meeting_copy_to WHERE dist_code = ? and subdiv_code = ?", array($dist_code, $subdiv_code));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('hpc', 'Name of H.P.C.', 'trim|required');
        $this->form_validation->set_rules('zila_parishad', 'Please select Zilla Parishad', 'trim|required');

        $zila_parishad   = $this->input->post('zila_parishad');
        $municipal_board = $this->input->post('municipal_board');
        $social_worker   = $this->input->post('social_worker');

        if(count($municipal_board) == 0)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343434: Please enter municipal board details!!");
            redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
            return false;
        }
        if(count($social_worker) == 0)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR0343435: Please enter social worker board details!!");
            redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
            return false;
        }

        // array of MP detail / 1
        $getMp = $this->NcCommonSdoAdcDcModel->getUsersMp($dist_code, $subdiv_code);
        $userMp_count = $getMp->num_rows();
        $userMp_list  = $getMp->result();
        if($userMp_count > 0)
        {
            $j=0;
            foreach($userMp_list as $mp)
            {
                $honble_mp = $this->input->post('honble_mp'.$j);
                $hpc       = $this->input->post('hpc'.$j);

                if(($honble_mp != '' || $honble_mp != null) && ($hpc == null || $hpc == ''))
                {
                    // echo "1st";
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR3444355: You forgot to insert the MP field!");
                    redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
                    return false;
                }

                if($honble_mp != false || strlen($honble_mp) > 1)
                {
                    $getMP = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mp));

                    if($getMP->num_rows() > 0)
                    {
                        $getMPData = $getMP->row();
                        $insertData[] = [
                            'user_level'  => '1',
                            'dist_code'   => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'user_code'   => $honble_mp,
                            'user_name'   => $getMPData->username,
                            'user_desg'   => $getMPData->user_type,
                            'user_mobile' => $getMPData->phone_no,
                            'user_email'  => $getMPData->emailid,
                            'hpc_lac'     => $hpc,
                            'status'      => 1,
                            'nc'          => 1,
                            'created_by'  => $user_desig_code,
                            'created_at'  => date('Y-m-d h:i:s'),
                            'updated_at'  => date('Y-m-d h:i:s'),
                            'board_name'  => '',
                        ];
                    }
                }
                $j++;
            }
        }

        //array of MLA / 2
        $userMla = $this->NcCommonSdoAdcDcModel->getUsersMla($dist_code, $subdiv_code);
        $userMla_count = $userMla->num_rows();
        $userMla_list  = $userMla->result();
        if($userMla_count > 0)
        {
            $i=0;
            foreach($userMla_list as $mla)
            {
                $honble_mla = $this->input->post('honble_mla'.$i);
                $lac        = $this->input->post('lac'.$i);

                if(($honble_mla != '' || $honble_mla != null) && ($lac == null || $lac == ''))
                {
                    // echo "2nd";
                    $this->db->trans_rollback();

                    $this->session->set_flashdata('message', "#ERR3444334: You forgot to insert the LAC field!");
                    redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
                    return false;
                }

                if($honble_mla != false || strlen($honble_mla) > 1)
                {
                    $getMla = $this->db->query("SELECT * FROM users WHERE dist_code = ? AND user_code = ?", array($dist_code, $honble_mla));

                    if($getMla->num_rows() > 0)
                    {
                        $getMlaData = $getMla->row();
                        $insertData[] = [
                            'user_level'  => '2',
                            'dist_code'   => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'user_code'   => $honble_mla,
                            'user_name'   => $getMlaData->username,
                            'user_desg'   => $getMlaData->user_type,
                            'user_mobile' => $getMlaData->phone_no,
                            'user_email'  => $getMlaData->emailid,
                            'hpc_lac'     => $lac,
                            'status'      => 1,
                            'nc'          => 1,
                            'created_by'  => $user_desig_code,
                            'created_at'  => date('Y-m-d h:i:s'),
                            'updated_at'  => date('Y-m-d h:i:s'),
                            'board_name'  => '',
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
            redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
            return false;
        }


        // array of zillaparishad / 6
        $getZilaPar = $this->NcCommonSdoAdcDcModel->getUsersDetail($dist_code, $zila_parishad);

        $getZilaPar_count = $getZilaPar->num_rows();

        if($getZilaPar_count > 0)
        {
            $getZilaPar_list = $getZilaPar->row();
            $insertData[] = [
                'user_level'  => '6',
                'dist_code'   => $dist_code,
                'subdiv_code' => $subdiv_code,
                'user_code'   => $zila_parishad,
                'user_name'   => $getZilaPar_list->username,
                'user_desg'   => $getZilaPar_list->user_type,
                'user_mobile' => $getZilaPar_list->phone_no,
                'user_email'  => $getZilaPar_list->emailid,
                'hpc_lac'     => '',
                'status'      => 1,
                'nc'          => 1,
                'created_by'  => $user_desig_code,
                'created_at'  => date('Y-m-d h:i:s'),
                'updated_at'  => date('Y-m-d h:i:s'),
                'board_name'  => '',
            ];

        }

        // array of municipal detail / 7
        $inserted_data = $this->db->query("SELECT * FROM minute_meeting_copy_to WHERE dist_code = ?", array($dist_code));

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
            $getMunicipal = $this->NcCommonSdoAdcDcModel->getUsersDetail($dist_code, $municipal);

            $getMunicipal_count = $getMunicipal->num_rows();
            $getMunicipal_data  = $getMunicipal->row();

            if($getMunicipal_count > 0)
            {

                $insertData[] = [
                    'user_level'  => '7',
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'user_code'   => $municipal,
                    'user_name'   => $getMunicipal_data->username,
                    'user_desg'   => $getMunicipal_data->user_type,
                    'user_mobile' => $getMunicipal_data->phone_no,
                    'user_email'  => $getMunicipal_data->emailid,
                    'hpc_lac'     => '',
                    'status'      => 1,
                    'nc'          => 1,
                    'created_by'  => $user_desig_code,
                    'created_at'  => date('Y-m-d h:i:s'),
                    'updated_at'  => date('Y-m-d h:i:s'),
                    'board_name'  => $this->input->post('boardNameMunicipal'.$municipal)
                ];
            }
        }

        // array of social worker / 8
        foreach($social_worker as $social)
        {
            $getSocial = $this->NcCommonSdoAdcDcModel->getUsersDetail($dist_code, $social);

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
                    'nc'          => 1,
                    'created_by'  => $user_desig_code,
                    'created_at'  => date('Y-m-d h:i:s'),
                    'updated_at'  => date('Y-m-d h:i:s'),
                    'board_name'  => '',
                ];

            }
        }


        //insert_batch
        $insertBatch = $this->db->insert_batch('minute_meeting_copy_to',$insertData);
        $this->db->trans_commit();

        if($insertBatch != 1) {
            $this->session->set_flashdata('message', "#ERR743411: Data insertion fail! Contact admin...");
            redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
            return false;
        }
        else {
            $this->session->set_flashdata('message', "Data inserted successfully...");
            redirect(base_url() . "index.php/NcCommonProposalAdc/addEditCopyToNc");
            return false;
        }

    }


    // Generate minute b4 send to DC verification
    public function sendProposalsToDcMinute()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meeting_date = $this->input->post('meeting_date');

        if(MEETING_PROPOSAL_SDLAC_NOTICE_HOLD_NC == 1)
        {
            if(date('Y-m-d H:i:s',strtotime(MEETING_PROPOSAL_SDLAC_NOTICE_DATE_NC)) < date('Y-m-d H:i:s',strtotime($meeting_date)))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'response'     => 1,
                    'message'      => 'Maximum Date of meeting '.MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW_NC
                ));
                return;
            }
        }

        $meeting_venue   = trim($this->input->post('meeting_venue'));
        $meeting_remarks = trim($this->input->post('meeting_remarks'));
        $nominee         = json_decode($this->input->post('nominee'));
        $selectMem       = json_decode($this->input->post('selectMem'));
        $proposals       = json_decode($this->input->post('proposals'));
        $dist_code       = $this->session->userdata('dist_code');
        $allMembers      = $this->NcCommonSdoAdcDcModel->getMembersFromUsers($dist_code);
        $subDivArray     = [];

        if($this->NcCommonSdoAdcDcModel->checkProposalAlreadyExistInMeeting($proposals) != 0)
        {
            $json = [
                'response' => 1,
                'message'  => 'Some of the Proposals Already listed in Meeting ! kindly check in SDLAC/CDLAC Minutes list',
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
                    $nn = $this->NcCommonSdoAdcDcModel->getNomineeName($nominee[$i]->select_nominee);
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

        $subdiv_code      = $this->session->userdata('subdiv_code');
        $districtName     = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $allProposalCases = $this->generateProposalCases($proposals);
        $caseList         = $allProposalCases['final_result_array_rec'];
        $caseDivNot       = $allProposalCases['final_result_array_not_rec'];

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


        $generate_meeting_id = $this->generateProposalIdSequenceNo();
        $dist_name   = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName = substr($dist_name->locname_eng, 0, 3);
        $memoName    = $distEngName.'/MEMO-NC/'.date("Y").'/'.$generate_meeting_id;
        $meetingName = $distEngName.'/SDLAC-NC/'.date("Y").'/'.$generate_meeting_id;

        $proposalDetails = $this->NcCommonSdoAdcDcModel->getAllProposalDetailsByProId($proposals);

        $createdUserCode = $proposalDetails[0]->user_code;
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == MB_ADD_DEPUTY_COMM)
        {
            $countCopy = $this->NcCommonSdoAdcDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
        }
        else
        {
            $countCopy = $this->NcCommonSdoAdcDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
        }
        if($countCopy == 0)
        {
            $proposalCreatedBy = '';
        }
        else
        {
            $proposalCreatedBy = $createdUserCode;
        }


        $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMpCount = $userMp->num_rows();
        $userMp = $userMp->result();

        $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMlaCount = $userMla->num_rows();
        $userMla = $userMla->result();

        $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
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
                'socialWorker' => $socialWorker
            ));

            return;
        }

    }


    // generate Meeting Id Sequence No
    function generateProposalIdSequenceNo()
    {
        $proposalId = $this->db->query("select nextval('proposal_meeting_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    // All recommended / not recommended cases
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

            $sql = " select string_agg(distinct(eng_pdar_name || '---' || eng_pdar_guardian || ''),',') as name from 
	    	          settlement_applicant where case_no='$r->case_no' and pdar_type='B'";
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
                "dags"          => $dags->dags,
                "ladtype"       => $land_type->ladtype,
                "case_no"       => $r->case_no,
                "subdiv_code"   => $r->subdiv_code,
                "case_status"   => $r->case_status,
                "remark"        => $r->remark,
                "proposal_name" => $props[$r->proposal_id]

            );

        }

        $serviceNames[NC_KHAS_LAND_ID]  = $this->lang->line('ncKhasLandTitle');
        $serviceNames[NC_CULTIVATOR_ID] = $this->lang->line('ncCultivatorTitle');
        $serviceNames[NC_TRIBAL_ID]     = $this->lang->line('ncTribalTitle');

        foreach ($result_array as $row)
        {
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
                        $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa2($final_all[1]);
                        $bklArea    =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                        $final_area = $final_area . $bklArea;
                    }
                    else
                    {
                        $final_dag  = $final_dag . $final_all[0];
                        $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa($final_all[1]);
                        $bklArea    =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
                        $final_area = $final_area . $bklArea;
                    }
                }
                else
                {
                    if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                        $final_dag  = $final_dag . $final_all[0].'<br>';
                        $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa2($final_all[1]);
                        $bklArea    =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."C".$BKLData[3]."G";
                        $final_area = $final_area . $bklArea.'<br>';
                    }
                    else
                    {
                        $final_dag  = $final_dag . $final_all[0].'<br>';
                        $BKLData    = $this->ncutility->Total_Bigha_Katha_Lessa($final_all[1]);
                        $bklArea    =  $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L";
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
                    "mouza"  =>	 $row['mouza'],
                    "village"=>	 $row['village'],
                    "case_no"=>	 $row['case_no'],
                    "applid" =>	 $row['applid'],
                    "service_name"  => $serviceNames[$row['service_code']],
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
                    "subdiv_code"   =>  $row['subdiv_code'],
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
            'final_result_array_rec' =>
                (isset($final_result_array_rec) && $final_result_array_rec != NULL)? $final_result_array_rec: '',
            'final_result_array_not_rec' =>
                (isset($final_result_array_not_rec) && $final_result_array_not_rec != NULL)? $final_result_array_not_rec: ''
        );


        return $final_result_array;

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
        $meeting_venue       = trim($this->input->post('meeting_venue'));
        $meeting_remarks     = trim($this->input->post('meeting_remarks'));
        $dist_code           = $this->session->userdata('dist_code');
        $subdiv_code         = $this->session->userdata('subdiv_code');
        $generate_meeting_id = trim($this->input->post('meeting_id'));


        if($this->NcCommonSdoAdcDcModel->checkProposalAlreadyExistInMeeting($proposals) != 0)
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

        $this->db->trans_begin();
        $allSelectedMember = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[]= $member->check_status;
        }


        $nomineeCheck = [];
        $nominee = [];
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
                'message'  => '#ERMR00717: There is no NC SDLAC/CDLAC Member, Case can not be forwarded. Kindly contact 
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


        $timestamp = date('mdYhis', time()).uniqid();
        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName = substr($dist_name->locname_eng, 0, 3);
        $meetingName = $distEngName.'/SDLAC-NC/'.date("Y").'/'.$generate_meeting_id;

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
            'meeting_remarks'          => $meeting_remarks,
            'meeting_name'             => $meetingName,
            'nc'                       => 1,
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
        if(isset($_FILES['upload_minute_online']['name']))
        {
            // Upload Minutes in meeting table
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
                              AND pl.case_status=1 AND pl.nc=1", array($prop))->result();

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
                }

                $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2 AND pl.nc=1", array($prop))->result();

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
                        WHERE id=? AND nc=?", array($prop,1))->row()->service_code;
            //echo $this->db->last_query();

            // Upload Minutes
            $uploadMinute= [
                'file_minute_path' => $file_minute_path,
            ];
            $this->db->where('id', $prop);
            $this->db->where('nc', 1);
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
            $this->db->where('nc', 1);
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
            $checkMember = $this->NcCommonSdoAdcDcModel->checkSdlacMember($prop);

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
                        'nc'                    => 1,
                    ];
                    $this->db->where([
                        'dist_code'         => $dist_code,
                        'proposal_no'       => $prop,
                        'sdlac_member_code' => $row->sdlac_user,
                        'username'          => $this->ncutility->getUserNameByUserCode($row->sdlac_user),
                        'service_code'      => $service_code,
                    ]);
                    $this->db->update('settlement_sdlac_member_report', $updateSdlacReport);

                    if($this->db->affected_rows() <= 0){
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
                        'username'              => $this->ncutility->getUserNameByUserCode($row->sdlac_user),
                        'emailid'               => $this->ncutility->getEmailIdByUserCode($row->sdlac_user),
                        'created_at'            => date('Y-m-d h:i:s'),
                        'service_code'          => $service_code,
                        'created_by'            => $this->session->userdata['user_desig_code'],
                        'status'                => $status,
                        'nominee_id'            => $row->select_nominee,
                        'meeting_attend_status' => $row->attend_status,
                        'proposal_meeting_id'   => $generate_meeting_id,
                        'nc'                    => 1,
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

            $checkMemberDetail = $this->NcCommonSdoAdcDcModel->checkSdlacMember($prop);

            //insert into settlement_sdlac_member_proceeding
            $insMemberProceeding = [
                'dist_code'         => $dist_code,
                'proposal_no'       => $prop,
                'sdlac_member_json' => json_encode($checkMemberDetail->result()),
                'created_at'        => date('Y-m-d h:i:s'),
                'nc'                => 1,

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
                'nc'                => 1,
                'service_code'      => $service_code,
                'sdlac_user_code'   => $this->session->userdata('user_code'),
            ];
            $insertProceeding = $this->db->insert('sdlac_proceeding', $insSdlacProceeding);
            if($insertProceeding != 1 || $insertProceeding != true ){
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
            $this->db->where('nc', 1);
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

        //hit api
        if($adc_forward_to_dc == 1){ // all offline cases , hit API
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
            $this->db->where('nc', 1);
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

            $caseApp = $this->NcCommonSdoAdcDcModel->convertLiteral($allAPICases);

            $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
            $applids = $this->db->query($sql)->row()->applids;


            //api call
            $rmk    = 'Forwarded to DC for Final Check';
            $status = 'M';
            $task   = $this->session->userdata['user_desig_code'];
            $pen    = MB_DEPUTY_COMM;
            $rtps_status=$this->NcApiModel->applicationStatusUpdateBulk($applids,'NA',$rmk,$status,$task,$pen);
            if($rtps_status!="y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0123: Forward to DC failed case no # $applids");
                $json = [
                    'response' => 1,
                    'message'  => '#ERRAPP0123: Case can not be forwarded. Kindly contact system administrator',
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
            $this->db->where('nc', 1);
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
        $caseApp = $this->NcCommonSdoAdcDcModel->convertLiteral($where_array);
        $sql = $sql . ' where '.$where_filed.' in ('.$caseApp.')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }



    /// ***************  Forwarded Meeting by ADC ********************

    // get Forwarded meeting list
    public function forwardedMeetingListForAdc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $createdBy = $this->session->userdata('user_desig_code');
        $data['dist_code'] = $dist_code;

        $pendingCase              = $this->NcCommonAdcModel->getForwardedMeetingListAdc($dist_code,$createdBy);
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'NcVillageService/NcProposalAdc/forwarded_meeting_list_adc';
        $this->load->view('layouts/main', $data);
    }


    // get Meeting details by ADC
    public function getForwardedMeetingDetailsByIdAdc()
    {
        $meetingId   = trim($this->input->get('meetingId'));
        $dist_code   = trim($this->session->userdata('dist_code'));
        $createdBy   = trim($this->session->userdata('user_desig_code'));
        $meeting     = $this->NcCommonAdcModel->getForwardedMeetingDetailByMeetingID($meetingId,$dist_code,$createdBy)->row();

        $meetingName = trim($meeting->meeting_name);
        if($meetingName == '')
        {
            $this->session->set_flashdata('error', "Meeting Not Found !");
            redirect(base_url() . "index.php/NcCommonProposalAdc/forwardedMeetingListForAdc");
        }

        //list of proposals against meeting id
        $proposalDetail = $this->NcCommonAdcModel->getProposalDetailAgainstMeetingIdForAdc($meetingId,$dist_code,$createdBy)->result();

        //list of SDLAC/CDLAC Member report
        $sdlacReport   = $this->NcCommonAdcModel->sdlacMemberReportDetail($dist_code,$meetingId)->result();
        $additionalDoc = $this->NcCommonAdcModel->getMeetingAdditionalDocumentDetail($meetingName)->result();

        $data['meeting']         = $meeting;
        $data['dist_code']       = $dist_code;
        $data['sdlac_member']    = $sdlacReport;
        $data['proposal_detail'] = $proposalDetail;
        $data['additionalDoc']   = $additionalDoc;

        $data['_view'] = 'NcVillageService/NcProposalAdc/forwarded_proposals_against_meeting_id';
        $this->load->view('layouts/main', $data);
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
                        $this->form_validation->set_rules('additional_doc_err','Maximum 10MB file size','required');
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

        $this->form_validation->set_rules('meetingId', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('meetingName', 'Meeting Name', 'trim|required');
        $this->form_validation->set_rules('fileName',  'Document Name', 'required|min_length[3]|max_length[99]');
        $this->form_validation->set_rules('gurdDocType', 'Document Type', 'trim|required');
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
            $dist_code   = $this->session->userdata('dist_code');
            $gurdDocType = $this->input->post('gurdDocType');

            $checkMeeting = $this->db->select()
                ->where('id', $meetingId)
                ->where('dist_code', $dist_code)
                ->where('nc', 1)
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
                        'mut_type'   => 'SDO',
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





    /// ***************  Reverted Meeting Meeting by DC ********************


    // reverted meeting list
    public function revertMeetingListForAdc()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $createdBy   = trim($this->session->userdata('user_desig_code'));

        $pendingCase              = $this->NcCommonSdoAdcDcModel->getRevertedMeetingListAdc($dist_code,$createdBy);
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['dist_code']        = $dist_code;

        $data['_view'] = 'NcVillageService/NcProposalAdc/reverted_meeting_list_adc';
        $this->load->view('layouts/main', $data);
    }


    // view proposal under reverted meeting
    public function getProposalUnderRevertedMeetingForAdc()
    {
        $meetingId   = trim($this->input->get('meetingId'));
        $dist_code   = trim($this->session->userdata('dist_code'));

        $pendingMeeting      = $this->NcCommonSdoAdcDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdc($meetingId,$dist_code);
        $meetingDetails      = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();

        if($pendingMeetingCount == 0)
        {
            $this->session->set_flashdata('error', "Reverted Meeting by DC Not Found !");
            redirect(base_url() . "index.php/NcCommonProposalAdc/revertMeetingListForAdc");
            $this->pendingProposalList();
        }
        else
        {
            //list of reverted proposals against meeting id
            $proposalDetail = $this->NcCommonSdoAdcDcModel->getRevertedProposalDetailAgainstMeetingId($dist_code,$meetingId);
            $commMembers    = $this->NcCommonSdoAdcDcModel->getMembersFromUsersWithUserType($dist_code);
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
                                          WHERE proposal_id IN ($allProposals) AND status=? AND dist_code=?",
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


            $data['_view'] = 'NcVillageService/NcProposalAdc/reverted_proposal_by_dc_list_adc';
            $this->load->view('layouts/main', $data);
        }
    }


    // view case under proposal reverted meeting
    public function caseListUnderRevertedMeetingForAdc()
    {
        $proposal_no     = $this->input->get('proposal');
        $dist_code       = $this->session->userdata('dist_code');
        $pendingCase     = $this->NcCommonSdoAdcDcModel->getAllCaseInProposalUnderRevertedMeeting($proposal_no);
        $proposalDetails = $this->NcCommonSdoAdcDcModel->getRevertedProposalDetailsByIdAdc($proposal_no,$dist_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails']  = $proposalDetails;

        $sql = $this->db->query('SELECT id, case_no FROM settlement_proposal_cases WHERE proposal_id = ? AND nc = ?', array($proposal_no,1));

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

        $data['_view'] = 'NcVillageService/NcProposalAdc/reverted_application_by_proposal_adc';
        $this->load->view('layouts/main', $data);

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

            $errorArray    = array();
            $pullArray     = array();
            $errorProArray = array();
            $errorProId    = array();

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
                $dist_code   = trim($this->session->userdata('dist_code'));
                $subdiv_code = trim($this->session->userdata('subdiv_code'));
                $createdBy   = trim($this->session->userdata('user_desig_code'));

                $pendingMeeting = $this->NcCommonSdoAdcDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdc($meetingId, $dist_code);
                $meetingDetails = $pendingMeeting->row();
                $pendingMeetingCount = $pendingMeeting->num_rows();
                if ($pendingMeetingCount == 0) {
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

                $getProposalsList = $this->NcCommonAdcModel->getProposalDetailAgainstMeetingIdForAdc($meetingId,$dist_code,$createdBy)->result();

                foreach ($getProposalsList as $prop)
                {
                    $proposal_no = $prop->proposal_id;
                    $caseCount   = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposal_no)->num_rows();
                    $pendingCase = $this->NcMeetingDcModel->getCaseDetailsByProposalNos($proposal_no);
                    $cases       = $pendingCase->result();
                    $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($proposal_no);
                    if($caseCount == 0)
                    {
                        $errorProArray[] = $proposalDetails->proposal_name;
                        $errorProId[]    = $proposalDetails->id;
                    }
//                    else
//                    {
//                        continue;
//                    }



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
                $revertBulkChitha = $errorArray;
                $revertBulkPull   = $pullArray;

                // check for zero cases under proposal
                if(count($errorProArray) > 0 OR count($errorProArray) > 0)
                {
                    $error_pro_zero_cases = '';
                    foreach ($errorProArray as $errorPro)
                    {
                        $error_pro_zero_cases = $error_pro_zero_cases.$errorPro.',';
                    }
                    log_message('error', '#MRNP01162: There is no case under proposal '.$error_pro_zero_cases);
                    echo json_encode(array(
                        'responseType' => 102,
                        'message'      => $error_pro_zero_cases,
                        'proIds'       => $errorProId,
                    ));
                    return;

                }
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
                    return;

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


    // reverted Meeting Generate minute b4 send to DC verification
    public function sendRevertedProposalsToDcMinute()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meetingId       = trim($this->input->post('meeting_id'));
        $meeting_date    = $this->input->post('meeting_date');
        $meeting_venue   = trim($this->input->post('meeting_venue'));
        $meeting_remarks = trim($this->input->post('meeting_remarks'));
        $nominee         = json_decode($this->input->post('nominee'));
        $selectMem       = json_decode($this->input->post('selectMem'));
        $dist_code       = $this->session->userdata('dist_code');
        $allMembers      = $this->NcCommonSdoAdcDcModel->getMembersFromUsers($dist_code);
        $proposalDetails = $this->NcCommonSdoAdcDcModel->getRevertedProposalDetailAgainstMeetingId($dist_code, $meetingId)->result();
        $subDivArray     = [];

        $proposals = [];
        foreach ($proposalDetails as $proposal)
        {
            $proposals[] = $proposal->id;
        }

        $pendingMeeting = $this->NcCommonSdoAdcDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdc($meetingId, $dist_code);
        $meetingDetails = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();

        if ($pendingMeetingCount == 0) {
            $json = [
                'responseType' => 3,
                'message' => 'Meeting not found !',
            ];
            echo json_encode($json);
            return false;
        }

        $allSelectedMember = [];
        $commMembers = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[] = $member->check_status;
        }

        $i = 0;
        foreach ($allMembers as $mem)
        {
            if (in_array($mem->user_code, $allSelectedMember))
            {
                if ($mem->user_code == $nominee[$i]->sdlac_user && $nominee[$i]->select_nominee != 0) {
                    $nn = $this->NcCommonSdoAdcDcModel->getNomineeName($nominee[$i]->select_nominee);
                    if ($mem->display_name == '') {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->name . ', ' . $mem->designation;
                    } else {
                        $commMembers[] = $nn->nominee_name . ' nominee of ' . $mem->display_name;
                    }
                } else {
                    if ($mem->display_name == '') {
                        $commMembers[] = $mem->name . ', ' . $mem->designation;
                    } else {
                        $commMembers[] = $mem->display_name;
                    }
                }
            }
            $i = $i + 1;
        }


        if (count($commMembers) == 0)
        {
            $json = [
                'response' => 1,
                'message' => '#ERMR000493: There is no SDLAC/CDLAC Member, Kindly Select SDLAC Members',
            ];
            echo json_encode($json);
            return false;
        }


        $subdiv_code      = $this->session->userdata('subdiv_code');
        $districtName     = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $allProposalCases = $this->generateProposalCases($proposals);
        $caseList         = $allProposalCases['final_result_array_rec'];
        $caseDivNot       = $allProposalCases['final_result_array_not_rec'];

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



        $dist_name      = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName    = substr($dist_name->locname_eng, 0, 3);
        $memoName       = $distEngName . '/MEMO-NC/' . date("Y") . '/' . $meetingDetails->id;
        $meetingName    = $meetingDetails->meeting_name;

        $createdUserCode = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == MB_ADD_DEPUTY_COMM)
        {
            $countCopy = $this->NcCommonSdoAdcDcModel->countUsersMpCopyToForADC($dist_code, $createdUserCode);
        }
        else
        {
            $countCopy = $this->NcCommonSdoAdcDcModel->countUsersMpCopyToForSDO($dist_code, $subdiv_code, $createdUserCode);
        }
        if($countCopy == 0)
        {
            $proposalCreatedBy = '';
        }
        else
        {
            $proposalCreatedBy = $createdUserCode;
        }


        $userMp = $this->NcCommonSdoAdcDcModel->getUsersMpCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMpCount = $userMp->num_rows();
        $userMp = $userMp->result();

        $userMla = $this->NcCommonSdoAdcDcModel->getUsersMlaCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userMlaCount = $userMla->num_rows();
        $userMla = $userMla->result();

        $userSdlac = $this->NcCommonSdoAdcDcModel->getUsersSdlacCopyTo($dist_code, $subdiv_code, $proposalCreatedBy);
        $userSdlacCount = $userSdlac->num_rows();
        $userSdlacList  = $userSdlac->result();

        if ($userMpCount == 0 OR $userMlaCount == 0 OR $userSdlacCount == 0) {
            $json = [
                'response' => 1,
                'message' => 'Minutes Copy to Members are incomplete ! Kindly Add Members For Minutes Copy To ',
            ];
            echo json_encode($json);
            return false;
        } else {
            $mpName = '';
            $mpHPC = '';
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
            foreach ($userMla as $mla) {
                if ($index == 0) {
                    $mlaName = $mla->user_name;
                    $mlaLAC = $mla->hpc_lac;
                } else {
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
            foreach ($userSdlacList as $user) {
                if ($user->user_level == 6) {
                    $zpcName = $user->user_name;
                }
                if ($user->user_level == 7) {
                    if ($indexM == 0) {
                        $bn = '';
                        if ($user->board_name != '') {
                            $bn = '(' . $user->board_name . ') ';
                        }
                        $municipalName = $user->user_name . $bn;
                    } else {
                        $bn = '';
                        if ($user->board_name != '') {
                            $bn = '(' . $user->board_name . ') ';
                        }
                        $municipalName = $municipalName . ", " . $user->user_name . $bn;
                    }
                    $indexM++;
                }
                if ($user->user_level == 8) {
                    if ($indexS == 0) {
                        $socialWorker = $user->user_name;
                    } else {
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
            ));

            return;
        }

    }


    // reverted Meeting forward to dc
    public function sendRevertedProposalsToDc()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $meetingId       = trim($this->input->post('meeting_id'));
        $allMem          = json_decode($this->input->post('nominee'));
        $selectMem       = json_decode($this->input->post('selectMem'));
        $meeting_date    = $this->input->post('meeting_date');
        $meeting_venue   = trim($this->input->post('meeting_venue'));
        $meeting_remarks = trim($this->input->post('meeting_remarks'));
        $dist_code       = $this->session->userdata('dist_code');
        $proposalQ       = $this->NcCommonSdoAdcDcModel->getRevertedProposalDetailAgainstMeetingId($dist_code, $meetingId);
        $proposalDetails = $proposalQ->result();
        $proposalCount   = $proposalQ->num_rows();
        $proposals       = [];

        $index = 0;
        $allProposals = '';
        foreach ($proposalDetails as $proposal)
        {
            $proposals[] = $proposal->id;
            if ($index == 0)
            {
                $allProposals .= "'" . $proposal->id . "'";
            }
            else
            {
                $allProposals .= ",'" . $proposal->id . "'";
            }
            $index++;
        }

        $pendingMeeting = $this->NcCommonSdoAdcDcModel->checkRevertedMeetingExistOrNotWithMeetingIdAdc($meetingId, $dist_code);
        $meetingDetails = $pendingMeeting->row();
        $pendingMeetingCount = $pendingMeeting->num_rows();
        if ($pendingMeetingCount == 0)
        {
            $json = [
                'response' => 1,
                'message' => 'Meeting not found ! Meeting can not be forwarded',
            ];
            echo json_encode($json);
            return false;
        }
        if ($proposalCount == 0)
        {
            $json = [
                'response' => 1,
                'message' => 'Proposal not found ! Meeting can not be forwarded',
            ];
            echo json_encode($json);
            return false;
        }

        $allSelectedMember = [];
        foreach ($selectMem as $member)
        {
            $allSelectedMember[] = $member->check_status;
        }

        $nomineeCheck = [];
        $nominee = [];

        // for offline, forward to DC
        $adc_forward_to_dc = 1;


        $sql = $this->db->query("SELECT DISTINCT(user_code) FROM sdlac_present_member WHERE proposal_id IN ($allProposals)
                                            AND status=? AND dist_code=?", array(1, $dist_code));

        $mmm = $sql->result();
        $memberPresents = [];
        foreach ($mmm as $mm)
        {
            $memberPresents[] = $mm->user_code;
        }

        $newInsertedMem = [];
        foreach ($allSelectedMember as $selectedMem)
        {
            if (!in_array($selectedMem, $memberPresents))
            {
                $newInsertedMem[] = $selectedMem;
            }
        }

        // check if any of SDLAC/CDLAC Member is online
        foreach ($allMem as $r)
        {
            if (in_array($r->sdlac_user, $allSelectedMember))
            {
                $nomineeCheck[] = $r;
                if (in_array($r->sdlac_user, $newInsertedMem))
                {
                    $nominee[] = $r;
                }
            }
        }

        if (count($nomineeCheck) == 0) {
            $json = [
                'response' => 1,
                'message' => '#ERMR002480: There is no SDLAC/CDLAC Member, Case can not be forwarded. Kindly contact 
                        system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_begin();

        // update sdlac Meeting list with MEETING ID
        $updateMeetingDetail = [
            'meeting_date'  => $meeting_date,
            'meeting_venue' => $meeting_venue,
            'ip' => $this->utilityclass->get_client_ip(),
            'meeting_remarks' => $meeting_remarks,
            'updated_at' => date('Y-m-d h:i:s'),
            'adc_forward_to_dc_status' => 1,
        ];
        $this->db->where('id', $meetingId);
        $this->db->where('nc', 1);
        $this->db->update('proposal_meeting_list', $updateMeetingDetail);
        if ($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERMR002501: Updation failed in proposal_meeting_list 
                        and query is ' . $this->db->last_query());
            $json = [
                'response' => 1,
                'message' => '#ERMR002501: Meeting can not be forwarded. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        // update in settlement proceeding
        $proceeding_case = [
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'   => $this->session->userdata('user_code'),
            'date_entry'  => date('Y-m-d h:i:s'),
            'operation'   => 'E',
            'ip'          => $this->utilityclass->get_client_ip(),
            'office_from' => $this->session->userdata['user_desig_code'],
            'office_to'   => MB_DEPUTY_COMM,
            'task'        => 'Forwarded to DC for Final Check',
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
            'status' => PRO_CASE_STATUS_APPROVE,
        ];

        // update in settlement proposal cases for  not recommended cases
        $final_settlement_pro_nrec_case = [
            'case_status' => 2,
            'status' => PRO_CASE_STATUS_REJECT,
        ];


        $recomend_count    = 0;
        $notrecomend_count = 0;

        //list of proposals
        foreach ($proposals as $prop)
        {
            // for only offline cases
            if ($adc_forward_to_dc == 1)
            {
                //get cases by proposal number
                $cases_recomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                              (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                              FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                              ON pl.case_no=t.case_no AND pl.proposal_id=?
                              AND pl.case_status=1", array($prop))->result();

                // all Recommended cases
                $recomend_count = $recomend_count + count($cases_recomend);
                foreach ($cases_recomend as $row)
                {
                    $allAPICases[] = $row->case_no;
                    $allAPICases_reco[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no'] = $row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id + 1;
                    $proceeding_case['note_on_order'] = 'Recommended';
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[] = $proceeding_case;
                }


                $cases_notrecomend = $this->db->query("SELECT t.proceeding_id,pl.* from settlement_proposal_cases pl JOIN 
                                (SELECT pc.case_no,MAX(proceeding_id) AS proceeding_id 
                                FROM settlement_proceeding  AS pc  GROUP BY case_no) t
                                ON pl.case_no=t.case_no AND pl.proposal_id=?
                                AND pl.case_status=2", array($prop))->result();

                // all Not Recommended cases
                $notrecomend_count = $notrecomend_count + count($cases_notrecomend);
                foreach ($cases_notrecomend as $row)
                {
                    $allAPICases[] = $row->case_no;
                    $allAPICases_nrec[] = $row->case_no;

                    // update in settlement proceeding
                    $proceeding_case['case_no'] = $row->case_no;
                    $proceeding_case['proceeding_id'] = $row->proceeding_id + 1;
                    $proceeding_case['note_on_order'] = $row->template_remarks;
                    $proceeding_case['minutes_proposal_id'] = $prop;
                    $proceeding_case['status'] = MB_FINAL_APPROVED_BY_DC;
                    $final_proceeding_case[] = $proceeding_case;
                }
            }

            //get service code
            $service_code = $this->db->query("SELECT service_code FROM settlement_proposal_list 
                        WHERE id=?", array($prop))->row()->service_code;

            //insert into settlement_sdlac_member_report
            foreach ($nominee as $row)
            {
                $insSdlacReport = [
                    'dist_code'             => $dist_code,
                    'proposal_no'           => $prop,
                    'username'              => $this->ncutility->getUserNameByUserCode($row->sdlac_user),
                    'emailid'               => $this->ncutility->getEmailIdByUserCode($row->sdlac_user),
                    'created_at'            => date('Y-m-d h:i:s'),
                    'service_code'          => $service_code,
                    'created_by'            => $this->session->userdata['user_desig_code'],
                    'status'                => 1,
                    'nc'                    => 1,
                    'nominee_id'            => $row->select_nominee,
                    'sdlac_member_code'     => $row->sdlac_user,
                    'meeting_attend_status' => $row->attend_status,
                    'proposal_meeting_id'   => $meetingId,
                ];

                $insert = $this->db->insert('settlement_sdlac_member_report', $insSdlacReport);
                if ($insert != 1 || $insert != true)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002644: Insertion failed in settlement_sdlac_member_report for 
                            proposal no : ' . $prop . ' and query is ' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message' => '#ERMR002644: Meeting can not be forwarded. Kindly contact 
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
            $this->db->where('nc', 1);
            $this->db->update('settlement_proposal_list', $updateSdlacList);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002666: Updation failed in settlement_proposal_list 
                  for proposal no : ' . $prop . ' and query is ' . $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message' => '#ERMR002666: Case can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        }


        //hit api
        if ($adc_forward_to_dc == 1)
        {
            // batch insert into settlement_proceeding
            $insert_count = $this->db->insert_batch('settlement_proceeding', $final_proceeding_case);
            if (($recomend_count + $notrecomend_count) != $insert_count)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002689: INSERT failed in settlement_proceeding ' . $this->db->last_query());
                $json = [
                    'response' => 1,
                    'message' => '#ERMR002689: Meeting can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            // batch insert into settlement_basic for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco) > 0)
            {
                //echo count($cases_recomend);
                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_rec,
                    'case_no', $allAPICases_reco);
                if ($recomend_count != $update_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCODE2710: Updation failed in settlement_basic for recommended ' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message' => '#ERRCODE2710: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_basic for not recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec) > 0)
            {
                $update_count = $this->updateBatch('settlement_basic', $final_settlement_case_nrec,
                    'case_no', $allAPICases_nrec);
                if ($notrecomend_count != $update_count) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002725: Updation failed in settlement_basic for not recommended ' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message' => '#ERMR002725: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            // batch update into settlement_proposal_cases for recommended
            if (isset($allAPICases_reco) && count($allAPICases_reco) > 0)
            {
                $update_pro_rec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_rec_case,
                    'case_no', $allAPICases_reco);
                if ($recomend_count != $update_pro_rec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002743: Updation failed in settlement_proposal_cases for recommended ' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message' => '#ERMR002743: Meeting can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            // batch insert into settlement_proposal_cases for not  recommended
            if (isset($allAPICases_nrec) && count($allAPICases_nrec) > 0)
            {
                $update_pro_nrec_count = $this->updateBatch('settlement_proposal_cases', $final_settlement_pro_nrec_case,
                    'case_no', $allAPICases_nrec);
                if ($notrecomend_count != $update_pro_nrec_count)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002763: Updation failed in settlement_proposal_cases for not recommended ' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message' => '#ERMR002763: Case can not be forwarded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            $caseApp = $this->NcCommonSdoAdcDcModel->convertLiteral($allAPICases);

            $sql = "select string_agg(applid,',') as applids from settlement_basic where 
                    case_no in ($caseApp)";
            $applids = $this->db->query($sql)->row()->applids;


            //api call
            $rmk    = 'Forwarded to DC for Final Check';
            $status = 'M';
            $task   = $this->session->userdata['user_desig_code'];
            $pen    = MB_DEPUTY_COMM;
            $rtps_status = $this->NcApiModel->applicationStatusUpdateBulk($applids, 'NA', $rmk, $status, $task, $pen);
            if (trim($rtps_status) != "y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERMRAPI002788: Forward to DC failed case no # $applids");
                $json = [
                    'response' => 1,
                    'message' => '#ERMRAPI002788: Meeting can not be forwarded. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            $this->db->trans_commit();

            $json = [
                'response' => 2,
                'message' => 'Reverted meeting has successfully forwarded to DC',
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



    // delete proposal with zero cases
    public function deleteProposalWithZeroCasesByAdc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $proposalIds      = $this->input->post('proposalIds');
        $proposalName     = $this->input->post('proposalName');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');

        if (empty($proposalIds) || empty($proposalName) )
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD04312: Validation error ! Please try again ',
            ]);
            return false;
        }
        if($user_desig_code != MB_ADD_DEPUTY_COMM)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRNPD04320: You are not authorized for this process.! ',
            ]);
            return false;
        }

        $this->db->trans_begin();

        // check proposal
        foreach ($proposalIds as $singlePro)
        {
            $pro = trim($singlePro);
            $proposalCount = $this->NcCommonSdoAdcDcModel->countSettlementProposalList($pro);
            if($proposalCount == 0 || $proposalCount == '')
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04333: Proposal not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $caseCount = $this->NcMeetingDcModel->countCasesWithProposalId($pro);
            if($caseCount != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04343: There is some cases under the Proposal, You cannot Delete ',
                ]);
                return false;
            }

            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($pro);
            if($proposalDetails == '' || $proposalDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04353: Meeting not found !  Kindly contact system administrator.',
                ]);
                return false;
            }

            $meetingDetails = $this->NcMeetingDcModel->getMeetingDetailByMeetingId(trim($proposalDetails->proposal_meeting_id));
            if($meetingDetails == '' || $meetingDetails == NULL)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04363: Meeting not found ! Kindly contact system administrator.',
                ]);
                return false;
            }

            if($meetingDetails->digital_sign_status == 1)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04372: Meeting already processed !',
                ]);
                return false;
            }

            $checkProDeleted = $this->NcMeetingDcModel->countSettlementProposalListDeleted($pro);
            if($checkProDeleted != 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04391: Proposal already removed ! Kindly contact system administrator.',
                ]);
                return false;
            }

            $saveDelPro = array(
                'proposal_id'            => trim($proposalDetails->id),
                'dist_code'              => trim($proposalDetails->dist_code),
                'user_code'              => trim($proposalDetails->user_code),
                'status'                 => trim($proposalDetails->status),
                'proposal_status'        => trim($proposalDetails->proposal_status),
                'file_path'              => trim($proposalDetails->file_path),
                'service_code'           => trim($proposalDetails->service_code),
                'h_date'                 => trim($proposalDetails->h_date),
                'remarks'                => trim($proposalDetails->remarks),
                'ip'                     => trim($proposalDetails->ip),
                'nc'                     => 1,
                'created_at'             => trim($proposalDetails->created_at),
                'updated_at'             => trim($proposalDetails->updated_at),
                'pro_minutes'            => trim($proposalDetails->pro_minutes),
                'pro_minutes_status'     => trim($proposalDetails->pro_minutes_status),
                'created_by'             => trim($proposalDetails->created_by),
                'final_verify_status'    => trim($proposalDetails->final_verify_status),
                'subdiv_code'            => trim($proposalDetails->subdiv_code),
                'dept_status'            => trim($proposalDetails->dept_status),
                'file_minute_path'       => trim($proposalDetails->file_minute_path),
                'file_attendance_path'   => trim($proposalDetails->file_attendance_path),
                'sdlac_prceed_status'    => trim($proposalDetails->sdlac_prceed_status),
                'meeting_date'           => trim($proposalDetails->meeting_date),
                'expiry_hour_start_time' => trim($proposalDetails->expiry_hour_start_time),
                'expiry_status'          => trim($proposalDetails->expiry_status),
                'meeting_venue'          => trim($proposalDetails->meeting_venue),
                'proposal_meeting_id'    => trim($proposalDetails->proposal_meeting_id),
                'meeting_create_status'  => trim($proposalDetails->meeting_create_status),
                'proposal_name'          => trim($proposalDetails->proposal_name),
                'deleted_ip'             => $this->input->ip_address(),
                'deleted_by'             => $user_code,
                'deleted_at'             => date('Y-m-d h:i:s'),
                'deleted_remarks'        => 'There is no cases under this proposal'
            );

            $insertProInDeleted = $this->db->insert('settlement_proposal_list_deleted', $saveDelPro);
            if($insertProInDeleted != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD04439: Insertion failed in settlement_proposal_list_deleted for proposal no : ' .$pro );
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04439: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        foreach ($proposalIds as $singleProId)
        {
            $proDel    = trim($singleProId);
            $deletePro = $this->NcMeetingDcModel->deleteSettlementProposalByProId($proDel,$dist_code);
            if($deletePro != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRNPD04455: Deletion failed in settlement_proposal_list_deleted for proposal no :'. $pro);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRNPD04455: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Proposals Successfully Removed ! You can resign the minutes now',
        ));
        return false;


    }







}