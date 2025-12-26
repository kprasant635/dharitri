<?php
class OfflineSettlementCommonController extends CI_Controller
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
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->offlineutility->dbSwitchSession();


    }

    public function dbswitchmb2($district)
    {
        //$CI=&get_instance();
        if ($district == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($district == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($district == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($district == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($district == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($district == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($district == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($district == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($district == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($district == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($district == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($district == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($district == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($district == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($district == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($district == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($district == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($district == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($district == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($district == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($district == "25") {
            $this->db = $this->load->database('dha23', true);
        }
    }


    //// ******************* 16-04-2024 / Masud Reza *************************


    //// ******************* Common sidebar  *************************



    // first landing page for all
    public function firstLandingPageCommonKhas()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subDiv_code = trim($this->session->userdata('subdiv_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $pendingApplicationCount  = 0;
        $meetingApplicationCount  = 0;
        $revertedApplicationCount = 0;
        $reReportApplicationCount = 0;
        $myApplicationCount       = 0;
        $pendingMeetingCount      = 0;

        if(in_array($userDegCode,OFFLINE_SETTLEMENT_REGISTER_ACCESS))
        {
            $myApplicationCount      = $this->OfflineCommonModel->countMyOfflineApplication($dist_code,$serviceCode,$user_code);;
            $meetingApplicationCount = $this->OfflineCommonModel->countOfflineApplicationForMeeting($dist_code,$serviceCode);;
            $pendingMeetingCount     = $this->OfflineCommonModel->countOfflinePendingMeeting($dist_code,$serviceCode);;
        }

        if(in_array($userDegCode,OFFLINE_SETTLEMENT_FIRST_REPORT))
        {
            $cir_code   = trim($this->session->userdata('cir_code'));
            $mouza_code = trim($this->session->userdata('mouza_pargona_code'));
            $lot_no     = trim($this->session->userdata('lot_no'));

            $pendingApplicationCount  = $this->OfflineCommonModel->countPendingOfflineApplication($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode);
            $revertedApplicationCount = $this->OfflineCommonModel->countRevertedOfflineApplication($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode);
        }
        if(in_array($userDegCode,OFFLINE_SETTLEMENT_PROCESS))
        {
            if($userDegCode == MB_CIRCLE_OFFICER)
            {
                $cir_code = trim($this->session->userdata('cir_code'));
                $pendingApplicationCount  = $this->OfflineCommonModel->countPendingOfflineApplicationCo($dist_code,$subDiv_code,$cir_code,$serviceCode);
                $reReportApplicationCount = $this->OfflineCommonModel->countReReportOfflineApplicationCo($dist_code,$subDiv_code,$cir_code,$serviceCode);
            }
            if($userDegCode == MB_SUB_DIV_COMM)
            {
                $pendingApplicationCount  = $this->OfflineCommonModel->countPendingOfflineApplicationSdo($dist_code,$subDiv_code,$serviceCode);

            }
        }

        $data['dist_code']                = $dist_code;
        $data['pendingApplicationCount']  = $pendingApplicationCount;
        $data['meetingApplicationCount']  = $meetingApplicationCount;
        $data['pendingMeetingCount']      = $pendingMeetingCount;
        $data['revertedApplicationCount'] = $revertedApplicationCount;
        $data['reReportApplicationCount'] = $reReportApplicationCount;
        $data['myApplicationCount']       = $myApplicationCount;

        $data['_view'] = 'OfflineSettlement/Common/first_offline_landing_page_khas';
        $this->load->view('layouts/main', $data);

    }


    // application successfully submitted message
    public function getOfflineApplicationSuccessfullySubmittedMsg()
    {
        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $caseNoEn       = $this->input->get('app');
        $caseNo         = $this->offlineutility->decryptJwtCase($caseNoEn);
        $data['caseNo'] = $caseNo;

        $data['_view']  = 'OfflineSettlement/Common/success_page_khas';
        $this->load->view('layouts/main', $data);
    }


    // view my applied application list
    public function getMyAppliedApplicationList()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $user_code   = trim($this->session->userdata('user_code'));
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $myApplicationList = $this->OfflineCommonModel->getMyOfflineApplication($dist_code,$serviceCode,$user_code);

        $data['applicationCount'] = $myApplicationList->num_rows();
        $data['applications']     = $myApplicationList->result();

        $data['_view'] = 'OfflineSettlement/Common/my_applied_offline_application_list';
        $this->load->view('layouts/main', $data);

    }


    // view my applied application details
    public function getMyKhasApplicationDetails()
    {
        $caseNoEn  = $this->input->get('app');
        $caseNo    = $this->offlineutility->decryptJwtCase($caseNoEn);
        $dist_code = trim($this->session->userdata('dist_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        // check application
        if($this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$caseNo) != 1)
        {
            $errors = '#MROFK0001: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');

        }

        // application details
        $application = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$caseNo);

        // Sdlac case details
        $caseDetails = $this->OfflineCommonModel->getOfflineSdlacDetailsByCaseNo($caseNo);

        $serviceCode = $application->service_code;
        if(!in_array($serviceCode, OFFLINE_SERVICE_CODE_ALLOW))
        {
            $errors = '#MROFK0002: Application not found !  Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList');

        }

        // applicant details
        $applicants = $this->OfflineCommonModel->getApplicantOfflineApplication($dist_code,$caseNo);

        // dag details
        $dags = $this->OfflineCommonModel->getOfflineSettlementDagDetails($dist_code,$caseNo);

        // getting the settlement_applicant occupiers data from settlement_deleted_data table
        $deletedData = $this->OfflineCommonModel->getDeletedDags($caseNo);

        // for guardian relation
        $relations = $this->OfflineCommonModel->getGuardianRelation($dist_code,$caseNo);

        // document
        $documents   = $this->OfflineCommonModel->getDocuments($caseNo);
        $documentsLm = $this->OfflineCommonModel->getDocumentsTraceMapFieldMap($caseNo);

        // application proceeding
        $proceedings = $this->OfflineCommonModel->getOfflineApplicationProceeding($caseNo);

        $data['guar_rel']          = $relations;
        $data['case_no']           = $caseNo;
        $data['basic']             = $application;
        $data['caseDetails']       = $caseDetails;
        $data['applicants']        = $applicants;
        $data['dags']              = $dags;
        $data['dag_count']         = count($dags);
        $data['deleted_dags']      = $deletedData;
        $data['documents']         = $documents;
        $data['documentsLm']       = $documentsLm;
        $data['proceedings']       = $proceedings;
        $data['validation_bypass'] = 0;
        $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();

//        dd($data);

        $data['_view'] = 'OfflineSettlement/Common/offline_application_details_view';
        $this->load->view('layouts/main', $data);

    }


    // make meeting from application list
    public function applicationListForMakeMeeting()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $pendingCase = $this->OfflineCommonModel->offlineApplicationForMeeting($dist_code,$serviceCode);
        $getDistrict = $this->OfflineCommonModel->getLocationNameAdcDc($dist_code);
        $location    = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle)
        {
            $circleList[$key]['cir_name'] = $this->ncutility->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }

        $data['location']         = $circleList;
        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'OfflineSettlement/Common/make_meeting_from_application_list';
        $this->load->view('layouts/main', $data);
    }


    // get Village name
    function offlineVillageListCommon()
    {
        $subDiv = trim($this->input->post('subdiv_code'));
        $circle = trim($this->input->post('cir_code'));

        $villageName = $this->OfflineCommonModel->getVillageNameForNc($subDiv,$circle);

        echo json_encode(array(
            'responseType' => 1,
            'location'     => $villageName,
        ));
        return;
    }



    // pagination of make meeting
    public function makeMeetingOfflineCasesAjax()
    {
        $service       = trim($this->input->post('service'));
        $by_case_no    = trim($this->input->post('case_no'));
        $dist_code     = $this->session->userdata('dist_code');
        $subdiv_code   = $this->session->userdata('subdiv_code');
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = $this->session->userdata('user_desig_code');
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $remark_cat_lm = trim($this->input->post('remark_cat_lm'));
        $order         = $this->input->post('order');
        $approved_by   = '';
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
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('settlement_basic.case_no', $by_case_no);
        }


        if(!empty($remark_cat_lm)){
            $this->db->where('offline_settlement_case_details.sdlac_rec', $remark_cat_lm);
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
        $this->db->join('offline_settlement_case_details', 'settlement_basic.case_no = offline_settlement_case_details.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', 'Z');
        $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);

        $this->db->limit($length, $start);
        $query = $this->db->get();
        //        log_message('error',$this->db->last_query());
        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('settlement_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('settlement_basic.vill_townprt_code', $village);
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('settlement_basic.lot_no', $lot_no);
                $this->db->where('settlement_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('settlement_basic.case_no', $by_case_no);
            }

            if(!empty($remark_cat_lm)){
                $this->db->where('offline_settlement_case_details.sdlac_rec', $remark_cat_lm);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
            $this->db->join('offline_settlement_case_details', 'settlement_basic.case_no = offline_settlement_case_details.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', 'Z');
            $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $query1 = $this->db->get();
            log_message('error', 'data'.json_encode($query1));

            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {

                $lm_remark ='';
                foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                    if($rows->sdlac_rec == $lm_remark_cat->CODE){
                        $lm_remark = $lm_remark_cat->NAME;
                    }
                }

                $application_no = $this->offlineutility->encryptJwtcase($rows->case_no);

                $json[] = array(
                    $rows->case_no,

                    '<span class="px-1"><strong>' . $i . '</strong></span>',

                    $this->ncutility->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $lm_remark,


                    $rows->case_no,


                    '<a class="btn btn-success btn-sm" href="'.base_url().'index.php/OfflineSettlementCommonController/getMyKhasApplicationDetails/?app='.$application_no.'">View Application</a>'
                );

                $i++;
            }
            log_message('error', 'last_query'.$this->db->last_query());
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



    // generate Meeting Id
    function generateOfflineMeetingIdSequenceNo()
    {
        $meetingId = $this->db->query("select nextval('offline_meeting_list_id_seq') as count ")->row()->count;
        return $meetingId;
    }

    // make offline meeting
    public function saveOfflineMeeting()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('selectedList[]', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|max_length[3000]');
        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }

        $hearingDate     = $this->input->post('hearingDate');
        $dist_code       = trim($this->session->userdata('dist_code'));
        $remarks         = trim($this->input->post('remarks'));
        $allSelectedList = $this->input->post('selectedList');
        $venue           = trim($this->input->post('venue'));
        $serviceCode     = OFFLINE_KHAS_LAND_ID;
        $user_code       = trim($this->session->userdata('user_code'));
        $userDeg         = trim($this->session->userdata('user_desig_code'));

        if(empty($allSelectedList))
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'There is no selected cases !'
            ));
            return;
        }


        // checking
        foreach ($allSelectedList as $row)
        {
            $caseNo = $row;
            if($this->OfflineCommonModel->countOfflineApplicationByCaseNoInBasic($dist_code,$caseNo) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => 'Case ('.$caseNo.') Not found !'
                ));
                return;
            }

            $caseIdSdlacProposal = $this->OfflineCommonModel->countOfflineApplicationByCaseNoInMeetingList($caseNo);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 2,
                    'application' => $caseNo
                ));
                return;
            }
        }

        $this->db->trans_begin();
        $meetingSequenceNo = $this->generateOfflineMeetingIdSequenceNo();
        $dist_name         = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName       = substr($dist_name->locname_eng, 0, 3);
        $meetingName       = $distEngName.'/MEETING-OFF/'.date("Y").'/'.$meetingSequenceNo;

        $todayT = date('Y-m-d h:i:s');
        $ipAdd  = $this->offlineutility->get_client_ip();

        // save data into offline meeting list
        $meetingSave = array(
            'id'              => $meetingSequenceNo,
            'dist_code'       => $dist_code,
            'meeting_name'    => strtoupper($meetingName),
            'created_by'      => $userDeg,
            'created_user'    => $user_code,
            'venue'           => $venue,
            'meeting_date'    => $hearingDate,
            'status'          => 1,
            'meeting_status'  => 1,
            'remarks'         => $remarks,
            'created_at'      => $todayT,
            'ip'              => $ipAdd,
            'service_code'    => $serviceCode,
        );

        $insMeeting = $this->db->insert('offline_meeting_list', $meetingSave);
        if ($insMeeting != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROM0001: Insertion failed in offline_meeting_list for Case No and query is ' . $this->db->last_query());
            echo json_encode(array(
                'responseType' => 1,
                'message'      => '#MROM0001: There is some problem ! Kindly contact system administrator'
            ));
            return;
        }

        // updated/save  data
        foreach ($allSelectedList as $row)
        {
            $case_no = $row;

            // Sdlac case details
            $caseDetails  = $this->OfflineCommonModel->getOfflineSdlacDetailsByCaseNo($case_no);

            $saveCaseList = array(
                'meeting_id'   => $meetingSequenceNo,
                'dist_code'    => $dist_code,
                'case_no'      => $case_no,
                'status'       => 1,
                'case_status'  => $caseDetails->sdlac_rec,
                'created_at'   => $todayT,
                'ip'           => $ipAdd,
                'service_code' => $serviceCode,
            );
            $insMeeting = $this->db->insert('offline_meeting_cases', $saveCaseList);
            if ($insMeeting != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROM0002: Insertion failed in offline_meeting_cases for Case No ' . $case_no . ' and query is ' . $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MROM0002: There is some problem with ('. $case_no .') ! Kindly contact system administrator'
                ));
                return;
            }


            // update basic data
            $updateData = array(
                'status'          => MB_SEND_TO_SDLAC,
                'pending_office'  => MB_SDLAC,
                'pending_officer' => MB_DEPUTY_COMM,
                'from_office'     => MB_DEPUTY_COMM,
                'dc_proceeding'   => 1,
            );
            if($this->OfflineCommonModel->updateOfflineBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROM0003: updating failed in settlement_basic for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MROM0003: There is some problem with ('. $case_no .') ! Kindly contact system administrator'
                ));
                return;
            }

            $proceeding_id = $this->OfflineCommonModel->getOfflineProceedingId($case_no);
            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => $todayT,
                'next_date_of_hearing' => $todayT,
                'note_type'            => 'Case Forwarded to Meeting List',
                'note_on_order'        => $remarks,
                'status'               => MB_SEND_TO_SDLAC,
                'user_code'            => $user_code,
                'date_entry'           => $todayT,
                'operation'            => 'E',
                'ip'                   => $ipAdd,
                'office_from'          => MB_DEPUTY_COMM,
                'office_to'            => MB_DEPUTY_COMM,
                'task'                 => 'Case Forwarded to Meeting List',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROM0004: Insertion failed in settlement_proceeding Case No '.$case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MROM0004: There is some problem with ('. $case_no .') ! Kindly contact system administrator'
                ));
                return;
            }
        }


        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 3,
        ));
        return;
    }


    // offline meeting
    public function offlinePendingMeetingList()
    {
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $user_code   = trim($this->session->userdata('user_code'));

        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $meetingList = $this->OfflineCommonModel->getOfflinePendingMeeting($dist_code,$serviceCode);

        $data['meetingCount'] = $meetingList->num_rows();
        $data['meetings']     = $meetingList->result();

        $data['_view'] = 'OfflineSettlement/Common/offline_meeting_list';
        $this->load->view('layouts/main', $data);

    }


    // view meeting
    public function getMeetingDetails()
    {
        $meetingIdEn = $this->input->get('meeting');
        $meetingId   = $this->offlineutility->decryptJwtCase($meetingIdEn);
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        $meetingDetails = $this->OfflineCommonModel->getOfflineMeetingDetails($dist_code,$meetingId,$serviceCode);
        if($meetingDetails->num_rows() != 1)
        {
            $errors = '#MROM0013: Meeting not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementCommonController/offlinePendingMeetingList');
        }

        $caseDetails = $this->OfflineCommonModel->getMeetingCaseDetails($meetingId,$serviceCode);

        $data['meetings']   = $meetingDetails->row();
        $data['casesCount'] = $caseDetails->num_rows();
        $data['cases']      = $caseDetails->result();

        $data['_view'] = 'OfflineSettlement/Common/offline_meeting_details';
        $this->load->view('layouts/main', $data);
    }


    // meeting forward  to department
    public function offlineMeetingForwardToDept()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Meeting Id', 'trim|required|is_natural|greater_than[-1]');
        $this->offlineutility->checkUserAccessForOnlineProcessCommon();

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }

        $meetingId   = trim($this->input->post('meetingId'));
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = OFFLINE_KHAS_LAND_ID;
        $user_code   = trim($this->session->userdata('user_code'));

        $meetingDetails = $this->OfflineCommonModel->getOfflineMeetingDetails($dist_code,$meetingId,$serviceCode);
        if($meetingDetails->num_rows() != 1)
        {
            $errors = '#MROM0014: Meeting not found !';
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }

        $meeting = $meetingDetails->row();
        if($meeting->meeting_status != 1)
        {
            $errors = '#MROM0014: Meeting already processed !';
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }

        $caseDetails = $this->OfflineCommonModel->getMeetingCaseList($dist_code,$meetingId,$serviceCode);
        if($caseDetails->num_rows() == 0)
        {
            $errors = '#MROM0015: There is no case found under this Meeting !';
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }

        $this->db->trans_begin();
        $cases  = $caseDetails->result();
        $todayT = date('Y-m-d h:i:s');
        $ipAdd  = $this->offlineutility->get_client_ip();

        // save data into offline meeting list
        $meetingUpdate = array(
            'meeting_status'  => 2,
            'updated_at'      => $todayT,
        );

        $this->db->where('id', $meetingId);
        $this->db->where('meeting_status', 1);
        $this->db->update('offline_meeting_list', $meetingUpdate);
        if ($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFC012: Updating failed in offline_meeting_list Meeting Id '.$meetingId);
            $errors = '#MROM0016: Meeting Failed to Forward. Kindly contact system administrator';
            echo json_encode(array(
                'responseType' => 1,
                'message'      => $errors
            ));
            return;
        }


        // checking
        foreach ($cases as $row)
        {
            $caseNo = $row->case_no;;
            if($this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$caseNo) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => 'Case ('.$caseNo.') Not found !'
                ));
                return;
            }
        }

        // update/save data
        foreach ($cases as $case)
        {
            $case_no = $case->case_no;

            // update basic data
            $updateData = array(
                'status'          => MB_PENDING,
                'pending_office'  => MB_DEPARTMENT,
                'pending_officer' => MB_DEPARTMENT,
                'from_office'     => MB_DEPUTY_COMM,
            );
            if($this->OfflineCommonModel->updateOfflineBasicDataAdc($case_no,$dist_code,$serviceCode,$updateData)== 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROM0003: updating failed in settlement_basic for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MROM0003: There is some problem with ('. $case_no .') ! Kindly contact system administrator'
                ));
                return;
            }

            $proceeding_id = $this->OfflineCommonModel->getOfflineProceedingId($case_no);
            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => $todayT,
                'next_date_of_hearing' => $todayT,
                'note_type'            => 'Case Forwarded to Department',
                'note_on_order'        => 'Case Forwarded to Department',
                'status'               => MB_PENDING,
                'user_code'            => $user_code,
                'date_entry'           => $todayT,
                'operation'            => 'E',
                'ip'                   => $ipAdd,
                'office_from'          => MB_DEPUTY_COMM,
                'office_to'            => MB_DEPARTMENT,
                'task'                 => 'Case Forwarded to Department',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROM0004: Insertion failed in settlement_proceeding Case No '.$case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#MROM0004: There is some problem with ('. $case_no .') ! Kindly contact system administrator'
                ));
                return;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 3,
        ));
        return;
    }










    // decode for showing file
    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }


    // view uploaded minutes
    public function getViewOfflineUploadedMinutes()
    {
        $filePathId = $this->input->get('fileId');
        $fileType   = $this->input->get('type');
        if($filePathId == '' OR $fileType == '')
        {
            die("Unable to open file !");
        }

        $fileDetails = $this->OfflineCommonModel->getMinutesDocWithFileId($filePathId);

        if($fileType == 1)
        {
            if($fileDetails->proposal_doc == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->proposal_doc))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->proposal_doc, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->proposal_doc;
                    }

                    if(!file_exists($path))
                    {
                        $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    if(!file_exists($path))
                    {
                        return false;
                    }
                }
                else
                {
                    $path = $fileDetails->proposal_doc;
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
        elseif($fileType == 2)
        {
            if($fileDetails->minutes_doc == '')
            {
                die("Unable to open file !");
            }
            else
            {

                if(!file_exists($fileDetails->minutes_doc))
                {
                    $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->minutes_doc, 2);
                    if (count($parts) > 1)
                    {
                        $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    else
                    {
                        $path = $fileDetails->minutes_doc;
                    }

                    if(!file_exists($path))
                    {
                        $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                    }
                    if(!file_exists($path))
                    {
                        return false;
                    }
                }
                else
                {
                    $path = $fileDetails->minutes_doc;
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
        else
        {
            die("Unable to open file !");
        }

    }


    // view supportive document
    public function getViewSupportiveDocs()
    {
        $filePathId = $this->input->get('fileId');
        if($filePathId == '')
        {
            die("Unable to open file !");
        }

        $fileDetails = $this->OfflineCommonModel->getDocumentsWithFileId($filePathId);

        if($fileDetails->file_path == '')
        {
            die("Unable to open file !");
        }
        else
        {

            if(!file_exists($fileDetails->file_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $fileDetails->file_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $fileDetails->file_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    return false;
                }
            }
            else
            {
                $path = $fileDetails->file_path;
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




    // get all circle list with db switch
    public function getCircleOffline($district)
    {
        $circle = $this->UtilsModel->getCircleListByDist($district);
        $json   = array();

        foreach ($circle as $object)
        {
            $json[] = array('cir_code' => trim($object->cir_code . ',' . $object->subdiv_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        echo json_encode($json);
    }


    // get all Village list  with db switch
    public function getVillageOffline($district,$subdiv,$circle,$rural)
    {
        if ($rural == 'N')
        {
            $rural = 'R';
        }
        else if ($rural == 'Y')
        {
            $rural = 'U';
        }
        $village = $this->UtilsModel->getVillageListByUrbanRural($district,$subdiv,$circle,$rural);
        $json    = array();

        foreach ($village as $object)
        {
            $json[] = array('vill_townprt_code' => trim($object->vill_townprt_code . ',' . $object->subdiv_code . ',' . $object->mouza_pargona_code . ',' . $object->lot_no), 'loc_name' => trim($object->loc_name));
        }
        echo json_encode($json);
    }


    // get dag list  with db switch
    public function getAllDagsOffline($district,$subdiv,$circle,$mouza,$lot,$village)
    {
        $dags = $this->UtilsModel->getDagListForAdditionalPro($district,$subdiv,$circle,$mouza,$lot,$village);
        $json = array();
        foreach ($dags as $object)
        {
            $json[] = array(
                'dag_no' => trim($object->dag_no),
                'dag_no_int' => trim($object->dag_no_int),
            );
        }
        echo json_encode($json);
    }


    // get area details  with db switch
    public function getAreaAdditionalPro($district,$subdiv,$circle,$mouza,$lot,$village,$dag)
    {
        $area = $this->UtilsModel->getAreaForAdditionalPro($district,$subdiv,$circle,$mouza,$lot,$village,$dag);
        echo json_encode($area);
    }


    // save additional property
    public function addPropertyOffline()
    {

        $validation         = null;
        $dist_code          = trim($this->input->post('additional_district'));
        $dist_name          = $this->input->post('additional_district_name');
        $cir_code           = trim($this->input->post('additional_circle'));
        $cir_name           = $this->input->post('additional_circle_name');
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $bigha              = trim($this->input->post('additional_bigha'));
        $katha              = trim($this->input->post('additional_katha'));
        $lessa              = trim($this->input->post('additional_lessa'));
        $ref_no             = trim($this->input->post('ref_no'));


        if (in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            $ganda  = trim($this->input->post('additional_ganda'));
            $kranti = trim($this->input->post('additional_kranti'));
        }
        else
        {
            $ganda  = 0;
            $kranti = 0;
        }
        $is_additional_urban     = trim($this->input->post('is_additional_urban'));
        $additional_village      = trim($this->input->post('additional_village'));
        $additional_dag          = trim($this->input->post('additional_dag'));
        $additional_patta        = trim($this->input->post('additional_patta'));
        $additional_village_code = trim($this->input->post('additional_village_code'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('additional_district', 'District', 'required|numeric|trim|xss_clean');
        $this->form_validation->set_rules('additional_circle', 'Circle', 'required|trim|xss_clean');
        $this->form_validation->set_rules('additional_bigha', 'Bigha', 'required|is_natural|trim|greater_than[-1]|xss_clean');

        if (in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            // for barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_lessa', 'Chatak', 'required|greater_than[-1]|less_than[16]');
            $this->form_validation->set_rules('additional_ganda', 'Ganda', 'required|numeric|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_kranti', 'Kranti', 'numeric|greater_than[-1]|less_than[12]');
        }
        else
        {
            // other than barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[5]');
            $this->form_validation->set_rules('additional_lessa', 'Lessa', 'required|greater_than[-1]|less_than[20]');
        }

        if ($this->form_validation->run() == false)
        {
            $this->form_validation->set_error_delimiters('', '');

            if (form_error('additional_district')) {
                $validation[] = array('field' => 'additional_district', 'message' => form_error('additional_district'));
            }
            if (form_error('additional_circle')) {
                $validation[] = array('field' => 'additional_circle', 'message' => form_error('additional_circle'));
            }
            if (form_error('additional_bigha')) {
                $validation[] = array('field' => 'additional_bigha', 'message' => form_error('additional_bigha'));
            }
            if (form_error('additional_katha')) {
                $validation[] = array('field' => 'additional_katha', 'message' => form_error('additional_katha'));
            }
            if (form_error('additional_lessa')) {
                $validation[] = array('field' => 'additional_lessa', 'message' => form_error('additional_lessa'));
            }
            if (form_error('additional_ganda')) {
                $validation[] = array('field' => 'additional_ganda', 'message' => form_error('additional_ganda'));
            }
            if (form_error('additional_kranti')) {
                $validation[] = array('field' => 'additional_kranti', 'message' => form_error('additional_kranti'));
            }
        }

        if ($validation != null)
        {
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validation,
            ));
            return;
        }
        else
        {
            $this->db->trans_begin();

            if ($additional_dag == '' || $additional_dag == null)
            {
                $this->db->trans_rollback();
                log_message('error', 'Dag not selected');
                $json = [
                    'responseType' => 3,
                    'message' => 'Please Select Dag',
                ];
                echo json_encode($json);
                return false;
            }
            if ($additional_village_code == '' || $additional_village_code == null)
            {
                $this->db->trans_rollback();
                log_message('error', 'Village not selected');
                $json = [
                    'responseType' => 3,
                    'message' => 'Please Select Village',
                ];
                echo json_encode($json);
                return false;
            }
            if ($additional_patta == '' || $additional_patta == null)
            {
                $this->db->trans_rollback();
                log_message('error', 'Patta is null');
                $json = [
                    'responseType' => 3,
                    'message' => 'Patta can not be null',
                ];
                echo json_encode($json);
                return false;
            }

            //uuid from location table
            $uuid = $this->UtilsModel->getVillageUuid($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);
            if ($uuid == '' OR $uuid == NULL OR $uuid == 0)
            {
                $this->db->trans_rollback();
                log_message('error', 'Incorrect location selected. No uuid found' . $this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message' => 'Incorrect Location selected. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////////////// Save Applicant ///////////////
            $propertyadd = array(
                'applid'             => $ref_no,
                'case_no'            => $ref_no,
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'bigha'              => $bigha,
                'katha'              => $katha,
                'lessa'              => $lessa,
                'ganda'              => $ganda,
                'kranti'             => $kranti,
                'entry_date'         => date('Y-m-d h:i:s'),
                'is_rural'           => $is_additional_urban,
                'dag_no'             => trim($additional_dag),
                'patta_no'           => $additional_patta,
                'uuid'               => $uuid,
                'applied_flag'       => MB_LOT_MONDOL,
                'dist_name'          => trim($dist_name),
                'cir_name'           => trim($cir_name),
                'vill_name'          => trim($additional_village),
            );

            $this->db->insert('settlement_additional_property', $propertyadd);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                $response['status'] = 0;
                echo json_encode(['status' => 0]);
            }
            else
            {
                $property_id = $this->db->insert_id();
                $row = $this->UtilsModel->getAdditionalProperty($property_id);
                $this->db->trans_commit();

                log_message("error", json_encode($this->db->last_query()));
                echo json_encode(['status' => 200, 'result' => $row]);
                return;
            }
        }
    }


    // delete additional property
    public function additionalProDelete()
    {
        $property_id = trim($this->input->post('property_id'));
        if($property_id == '' OR $property_id == NULL)
        {
            $json = [
                'status' => 3,
                'message' => 'Nothing to delete !!',
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_begin();

        $row = $this->UtilsModel->getAdditionalPropertyId($property_id);
        if ($row->num_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', 'No detail available in settlement_additional_property ' . $this->db->last_query());
            $json = [
                'status' => 3,
                'message' => 'Nothing to delete !!',
            ];
            echo json_encode($json);
            return false;
        }

        $applid = $row->row()->applid;
        $this->UtilsModel->deleteAdditionalPropertyId($property_id);
        if ($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP0001 Failed to delete property_id: " . $property_id);
            return;
        }
        else
        {
            $this->db->trans_commit();
            $result =  $this->UtilsModel->getAdditionalPropertyByCase($applid);
            echo json_encode(['status' => 200, 'result' => $result->row_array(), 'count' => $result->num_rows()]);
            return;
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
            $caseCount = $this->OfflineCommonModel->countOfflineApplicationByCaseNo($dist_code,$case_no);

            if($caseCount > 0)
            {
                $caseDetails = $this->OfflineCommonModel->getOfflineApplicationByCaseNo($dist_code,$case_no);
                $appDistrict = trim($caseDetails->dist_code);
                $appSubDiv   = trim($caseDetails->subdiv_code);
                $appCircle   = trim($caseDetails->cir_code);
                $appMouza    = trim($caseDetails->mouza_pargona_code);
                $appLot      = trim($caseDetails->lot_no);
                $appVillage  = trim($caseDetails->vill_townprt_code);

                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getTotalVillageAppliedArea");
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

                $totalApprovedAreaVillageWise = $this->OfflineCommonModel->getApprovedChithaAreaVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $totalPendingAreaVillageWise = $this->OfflineCommonModel->getPendingChithaAreaVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $totalAreaInDagVillage = $this->OfflineCommonModel->getTotalChithaAreaInDagVillageWise
                ($appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage);

                $approveDagAreaLessa = 0;
                $pendingDagAreaLessa = 0;
                $totalReamingArea = 0;
                $totalAppliedArea = 0;
                $process = 0;
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $approveDagAreaLessa = $this->offlineutility->Total_ganda(
                        $totalApprovedAreaVillageWise->dag_bigha,
                        $totalApprovedAreaVillageWise->dag_katha,
                        $totalApprovedAreaVillageWise->dag_lessa,
                        $totalApprovedAreaVillageWise->dag_ganda
                    );
                    $pendingDagAreaLessa = $this->offlineutility->Total_ganda(
                        $totalPendingAreaVillageWise->dag_bigha,
                        $totalPendingAreaVillageWise->dag_katha,
                        $totalPendingAreaVillageWise->dag_lessa,
                        $totalPendingAreaVillageWise->dag_ganda
                    );
                    $chithaDagAreaLessa = $this->offlineutility->Total_ganda(
                        $totalAreaInDagVillage->chitha_bigha,
                        $totalAreaInDagVillage->chitha_katha,
                        $totalAreaInDagVillage->chitha_lessa,
                        $totalAreaInDagVillage->chitha_ganda
                    );
                    $approveDagAreaLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa2($approveDagAreaLessa);
                    $pendingDagAreaLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa2($pendingDagAreaLessa);
                    $chithaDagAreaLessaD  = $this->offlineutility->Total_Bigha_Katha_Lessa2($chithaDagAreaLessa);
                    $lmReportNotSubLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa2($apiOutput->barak_converted_ganda);

                    $totalReamingArea = $chithaDagAreaLessa - $approveDagAreaLessa;
                    $totalAppliedArea = $pendingDagAreaLessa + $apiOutput->barak_converted_ganda;
                    $area = $totalReamingArea - $totalAppliedArea;
                    if($area >= AREA_RESERVE_VILLAGE_WISE * 6400)
                    {
                        $process = 1;
                    }

                    $totalReamingAreaD = $this->offlineutility->Total_Bigha_Katha_Lessa2($area);
                }
                else
                {
                    $approveDagAreaLessa = $this->offlineutility->Total_Lessa(
                        $totalApprovedAreaVillageWise->dag_bigha,
                        $totalApprovedAreaVillageWise->dag_katha,
                        $totalApprovedAreaVillageWise->dag_lessa
                    );
                    $pendingDagAreaLessa = $this->offlineutility->Total_Lessa(
                        $totalPendingAreaVillageWise->dag_bigha,
                        $totalPendingAreaVillageWise->dag_katha,
                        $totalPendingAreaVillageWise->dag_lessa
                    );
                    $chithaDagAreaLessa = $this->offlineutility->Total_Lessa(
                        $totalAreaInDagVillage->chitha_bigha,
                        $totalAreaInDagVillage->chitha_katha,
                        $totalAreaInDagVillage->chitha_lessa
                    );

                    $approveDagAreaLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa($approveDagAreaLessa);
                    $pendingDagAreaLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa($pendingDagAreaLessa);
                    $chithaDagAreaLessaD  = $this->offlineutility->Total_Bigha_Katha_Lessa($chithaDagAreaLessa);
                    $lmReportNotSubLessaD = $this->offlineutility->Total_Bigha_Katha_Lessa($apiOutput->luit_converted_lessa);

                    $totalReamingArea = $chithaDagAreaLessa - $approveDagAreaLessa;
                    $totalAppliedArea = $pendingDagAreaLessa + $apiOutput->luit_converted_lessa;
                    $area = $totalReamingArea - $totalAppliedArea;
                    if($area >= AREA_RESERVE_VILLAGE_WISE * 100)
                    {
                        $process = 1;
                    }
                    $totalReamingAreaD = $this->offlineutility->Total_Bigha_Katha_Lessa($area);
                }

                echo json_encode(array(
                    'responseType' => 2,
                    'lmPendingApiBigha' => $lmReportNotSubLessaD[0],
                    'lmPendingApiKatha' => $lmReportNotSubLessaD[1],
                    'lmPendingApiLessa' => $lmReportNotSubLessaD[2],
                    'lmPendingApiGanda' => $lmReportNotSubLessaD[3],
                    'pendingBigha'      => $pendingDagAreaLessaD[0],
                    'pendingKatha'      => $pendingDagAreaLessaD[1],
                    'pendingLessa'      => $pendingDagAreaLessaD[2],
                    'pendingGanda'      => $pendingDagAreaLessaD[3],
                    'approveBigha'      => $approveDagAreaLessaD[0],
                    'approveKatha'      => $approveDagAreaLessaD[1],
                    'approveLessa'      => $approveDagAreaLessaD[2],
                    'approveGanda'      => $approveDagAreaLessaD[3],
                    'chithaBigha'       => $chithaDagAreaLessaD[0],
                    'chithaKatha'       => $chithaDagAreaLessaD[1],
                    'chithaLessa'       => $chithaDagAreaLessaD[2],
                    'chithaGanda'       => $chithaDagAreaLessaD[3],
                    'reamingBigha'      => $totalReamingAreaD[0],
                    'reamingKatha'      => $totalReamingAreaD[1],
                    'reamingLessa'      => $totalReamingAreaD[2],
                    'reamingGanda'      => $totalReamingAreaD[3],
                    'process'           => $process
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


    // check area rural or urban
    public function checkRuralUrban()
    {
        $case_no   = trim($this->input->post('case_no'));
        $dist_code = trim($this->session->userdata('dist_code'));
        $sql       = $this->OfflineCommonModel->getOfflineSettlementDagDetailsRow($dist_code,$case_no);
        if ($sql->num_rows() > 0)
        {

            $dag = $sql->row();
            $data = array(
                'responseType' => 2,
                'villageName'  => $this->offlineutility->getEnglishVillageName($dag->dist_code,$dag->subdiv_code,$dag->cir_code,$dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code),
                'mouzaName'    => $this->offlineutility->getEnglishMouzaName  ($dag->dist_code,$dag->subdiv_code,$dag->cir_code,$dag->mouza_pargona_code),
                'circleName'   => $this->offlineutility->getEnglishCircleName ($dag->dist_code,$dag->subdiv_code,$dag->cir_code),
                'isUrban'      => $sql->row()->is_urban,
                'area'         => $sql->result(),
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#RURAL003344: Case not found against case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
    }




}