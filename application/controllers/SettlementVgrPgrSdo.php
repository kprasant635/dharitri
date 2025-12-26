<?php

class SettlementVgrPgrSdo extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementMbADCModel');
        $this->load->model('SettlementMb/SettlementMbSdoModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementVgrPgrSdoModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');

        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
        if(HOLD_All_MB2_CASES_FOR_SDO == 1)
        {
            $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped For SDO !");
            redirect(base_url() . "index.php/Home/index");
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


    ///////// START VgrPgr FOR SDO BY MASUD REZA ///////////////

    // random file name for general
    function randomFileNameGeneral()
    {
        $rand = rand(000000,999999);
        $new_case_no = 'general_notice_'.$rand;

        if($this->SettlementVgrPgrSdoModel->checkDuplicateFileNameInGeneral($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }



    // 1st landing page VgrPgr
    public function SettlementVgrPgrLandSdo()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $user_code   = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $firstProceedingCount = $this->SettlementVgrPgrSdoModel->countAllPendingSettlementVgrPgr($dist_code,$subDiv_code);
        $SDLACCommitteeCount  = $this->SettlementCommonDcModel->countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code);
        $SDLACNoticeCount     = $this->SettlementVgrPgrSdoModel->countMarkAsSDLACSettlementVgrPgr($dist_code,$subDiv_code);
        $SDLACReportCount     = $this->SettlementVgrPgrSdoModel->countAllProposalSendByDcToSdlacVgrPgr($dist_code,$subDiv_code);;
        $caseStatusCount      = 0;
        $SDLACConsideration   = $this->SettlementVgrPgrSdoModel->countAllUnderConsiderationAppVgrPgr($dist_code,$subDiv_code);
        $sdlacMemberApproval  = $this->SettlementVgrPgrSdoModel->countSdlacStatusList($dist_code,$subDiv_code);
        $circleCluster        = $this->SettlementVgrPgrSdoModel->getCircleClusters($dist_code, $subDiv_code);
        $clusterCaseReReport  = $this->SettlementVgrPgrSdoModel->clusterCaseReReport($dist_code, $subDiv_code);
        $coRejectedListCount  = $this->SettlementCommonDcModel->countCoRejectedCaseForSDO($dist_code,$subDiv_code,SETTLEMENT_PGR_VGR_LAND_ID);
        $rejctedListCount     = $this->SettlementCommonDcModel->rejectedCaseListSDO($dist_code,$subDiv_code, SETTLEMENT_PGR_VGR_LAND_ID, MB_SUB_DIV_COMM);
        $revivalListCount     = $this->SettlementCommonDcModel->revivalListCountSDO($dist_code, $subDiv_code, SETTLEMENT_PGR_VGR_LAND_ID, MB_SUB_DIV_COMM);
        $vgrPgrRevertCount    = $this->SettlementCommonDcModel->countAllVgrPgrRevertedCaseForSdo($dist_code,$subDiv_code);
        $coModificationListCount = $this->SettlementPullModel->getCoModificationRequestCaseForSDO($dist_code,$subDiv_code,SETTLEMENT_PGR_VGR_LAND_ID);

        $reReportByCOCount  = 0;
        $approvedListCount  = 0;
        $rejectedListCount  = 0;
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
        $data['coRejectedCaseCount']       = $coRejectedListCount;
        $data['coModificationListCount']   = $coModificationListCount;
        $data['circleCluster']       = $circleCluster;
        $data['clusterCaseReReport'] = $clusterCaseReReport;
        $data['rejctedListCount']    = $rejctedListCount;
        $data['revivalListCount']    = $revivalListCount;
        $data['vgrPgrRevertCount']   = $vgrPgrRevertCount;

        $data['_view'] = 'settlementView/Sdo/VgrPgr/first_landing_page_sdo_VgrPgr';
        $this->load->view('layouts/main', $data);

    }


    // view all first Proceeding case list VgrPgr
    public function viewAllVgrPgrFirstProceedingSdoCaseList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getAllPendingSettlementVgrPgr($dist_code,$subdiv_code);
        $data['dist_code']        = $dist_code;
        $data['subdiv_code']        = $subdiv_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
        $location                 = $getDistrict->result();
        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'settlementView/Sdo/VgrPgr/first_proceeding_case_sdo_VgrPgr';
        $this->load->view('layouts/main', $data);

    }


    //pagination of first proceeding --VgrPgr SDO
    public function firstProceedingPaginationAPI()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');

        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->input->post('subdiv');
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
            $dir = 'asc';
        }
        $valid_columns = array(
            0   => 'settlement_basic.submission_date',
        );
        if(!isset($valid_columns[$col])){
            $order = 'settlement_basic.submission_date';
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
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
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
        $this->db->where_in('settlement_basic.pending_officer', MB_SUB_DIV_COMM);
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
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');

            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_PENDING);
            $this->db->where_in('settlement_basic.pending_officer', MB_SUB_DIV_COMM);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {

//                if($rows->general_notice_dc == 'y')
//                {
//                    $view_generate_notice = '<a class="rezaButt buttPrimary" href="'.base_url().'index.php/SettlementVgrPgrSdo/getSettlementVgrPgrApplicationDetails/?case='.$rows->case_no.'">
//                            <i class="fa fa-cog" aria-hidden="true"></i> Process
//                        </a>
//                        <a target="_blank" class="rezaButt buttInfo" href="'.base_url().'index.php/SettlementVgrPgrSdo/viewGeneralNoticeVgrPgr/?case='.$rows->case_no.'">
//                            <i class="fa fa-eye" aria-hidden="true"></i> View Notice
//                        </a>';
//                }
//                else
//                {
//                    $view_generate_notice = '<button  class="rezaButt case_no" id="case_no" onclick="generalNotice" value="'.$rows->case_no.'">
//                            <i class="fa fa-bullhorn" aria-hidden="true"></i> Generate Notice
//                        </button>';
//                }

                $view_generate_notice = '<a class="rezaButt buttPrimary" href="'.base_url().'index.php/SettlementVgrPgrSdo/getSettlementVgrPgrApplicationDetails/?case='.$rows->case_no.'">
                            <i class="fa fa-cog" aria-hidden="true"></i> Process
                        </a>';


                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    $view_generate_notice


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
            $dist_code    = $this->session->userdata('dist_code');
            $subdiv_code  = $this->session->userdata('subdiv_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no      = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails     = $this->SettlementVgrPgrSdoModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
                $get_dag_details = $this->SettlementVgrPgrSdoModel->getReservationDetails($case_no,$dist_code,$subdiv_code);
                $applicantDetail = $this->SettlementCommonDcModel->getApplicantDetails($case_no);
                $dist_name    = $this->UtilsModel->getDistrictNameByDistCode($caseDetails->dist_code);
                $circle_name  = $this->UtilsModel->getCircleDetailsByDistDivision($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code);
                $mouza_name   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code);
                $village_name = $this->UtilsModel->getVillageDetailsNameByDistDivisionCircleMouzaLot($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code);
                $notice_no    = "MB2/GN/".date('Y')."/SVGR/".$caseDetails->petition_no;

                $deReserveArr = '';

                foreach($get_dag_details as $dereserveRes)
                {
                    if(in_array($dereserveRes->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $deReserveArr .=  '<div>
                                            <span><b>'.$dereserveRes->dag_no.'</b>নং দাগৰ অংশ</span>
                                            <span><b>'.$dereserveRes->s_dag_area_b.'</b>বি:</span>
                                            <span><b>'.$dereserveRes->s_dag_area_k.'</b>ক:</span>
                                            <span><b>'.$dereserveRes->s_dag_area_lc.'</b>চ:</span>
                                            <span><b>'.$dereserveRes->s_dag_area_g.'</b>গ:</span>
                                        </div>';
                    }
                    else
                    {
                        $deReserveArr .=  '<div>
                                            <span><b>'.$dereserveRes->dag_no.'</b> নং দাগৰ অংশ</span>
                                            <span><b>'.$dereserveRes->s_dag_area_b.'</b> বিঘা</span>
                                            <span><b>'.$dereserveRes->s_dag_area_k.'</b> কঠা</span>
                                            <span><b>'.$dereserveRes->s_dag_area_lc.'</b> লেছা</span>
                                        </div>';
                    }
                }

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
                    'deReserveDetails' => $deReserveArr,
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
            $dist_code    = $this->session->userdata('dist_code');
            $subdiv_code  = $this->session->userdata('subdiv_code');
            $hearing_date = $this->input->post('hearingDate');
            $case_no      = $this->input->post('case_no');
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $caseDetails = $this->SettlementVgrPgrSdoModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
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
                foreach($applicantDetails as $buyers)
                {
                    $applicant_buyers_json[] = [
                        'APPLICANT_ID' => $buyers->id,
                        'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                        'GUARDIAN_NAME' => $buyers->pdar_guardian
                    ];
                }

                $this->db->trans_begin();

                $sql = $this->db->query('select * from settlement_notice where case_no = ?', array($case_no));

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


                if($sql->num_rows() > 0)
                {
                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_notice', $insertIntoSettlementNotice);

                    if($this->db->affected_rows() == 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');

                        echo json_encode(array(
                            'responseType' => 5,
                        ));
                        return;
                    }
                }
                else
                {
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
                }

                $updateData = array(
                    'general_notice_dc' => 'y',
                    'notice_generated_yn' => 'y',
                    'notice_generated_date' => date('Y-m-d H:i:s'),
                    'next_date_of_hearing' => $hearing_date,
                    'date_update' => date('Y-m-d H:i:s'),
                );
                if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subdiv_code,$updateData)== 0)
                {
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
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."uploadNotice");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'encoded_file' => json_decode($htmlstring_text),
                    'application_no' => $basundhara->basundhara,
                    'type' => 'GN',
                    'amount' => 0,
                    'is_full_pay' => 'N'
                )));
                $result = curl_exec($curl_handle);

                if(trim($result) != 'y'){
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                    ));
                    return;
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                    $rmk='General notice generated';
                    $status='M';
                    $task= $this->session->userdata('user_desig_code');
                    $pen= $this->session->userdata('user_desig_code');
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
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
                ));
                return;
            }
        }
    }


    // view general notice
    public function viewGeneralNoticeVgrPgr()
    {
        $case_no = $this->input->get('case');
        $noticeDetails = $this->SettlementVgrPgrSdoModel->getGeneralNoticeDetails($case_no);
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

        $data['_view'] = 'settlementView/Sdo/VgrPgr/general_notice_print';

        $this->load->view('layouts/main',$data);
    }


    //  settlement application details VGR PGR
    public function getSettlementVgrPgrApplicationDetails()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
        $application_no = $this->input->get('case');

        $basic= $this->SettlementVgrModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($application_no);

        $dags = $this->SettlementVgrModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($application_no);
        $nominee = $this->SettlementVgrModel->getAllNomineeDetail($application_no);
        $vgrReservation = $this->SettlementVgrModel->getSettlementVgrReservation($application_no);


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

        $premium_data = $this->SettlementCommonModel->getPremium($application_no);
        $data['premium_data'] = $premium_data;
        $data['premium'] = $premium_data;

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
        $data['vgrReservation']=$vgrReservation;

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

        $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code, $subdiv_code);
        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandSdo();
        }
        else
        {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->SettlementVgrPgrSdoModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code, $subdiv_code);
            $proceedings = $this->SettlementVgrPgrSdoModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            foreach($data['applicants_encroacher'] as $applicant_enc)
            {
                $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));
                if($enc_check->num_rows() > 0)
                {
                    $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid,$enc_check->row()->dag_no,$enc_check->row()->encroacher_id));

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

            $data['additional_property'] = $this->SettlementVgrModel->getAdditionalProperty($application_no);

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;

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

                                $lmdata['area_modified'] = $areaModificationCheck;
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

                                $lmdata['area_modified'] = $areaModificationCheck;
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

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_PGR_VGR_LAND_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }
            foreach($data['applicants_encroacher'] as $applicant_enc){
                $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

                if($enc_check->num_rows() > 0){
                    $added_enc_data[] = $enc_check->row();
                }
            }
            if(isset($added_enc_data)){
                $data['new_added_enc_data'] = $added_enc_data;
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
            $data['_view'] = 'settlementView/Sdo/VgrPgr/settlement_app_details_vgr_pgr';
            $this->load->view('layouts/main', $data);
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
            $subdiv_code = $this->session->userdata('subdiv_code');
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
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
                    'dc_proceeding' => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subdiv_code,$updateData)== 0)
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
                        'office_from' => MB_SUB_DIV_COMM,
                        'office_to' => MB_SUB_DIV_COMM,
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
                        $task=MB_SUB_DIV_COMM;
                        $pen=null;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status!="y"){
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


    // Revert from dc to co
    public function applicationRevertFromSDOToCO()
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
            $subdiv_code = $this->session->userdata('subdiv_code');
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
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
                    'from_office'     => MB_SUB_DIV_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subdiv_code,$updateData)== 0)
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
                        'office_from' => MB_SUB_DIV_COMM,
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
                        $task= MB_SUB_DIV_COMM;
                        $pen= MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status!="y")
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
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
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
                        $rmk='Rejected by DC';
                        $status='N';
                        $task= MB_DEPUTY_COMM;
                        $pen= MB_DEPUTY_COMM;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        //var_dump($rtps_status);
                        if($rtps_status!="y")
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


    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
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
                // SOD/ADC chitha
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
                    $totalAppliedAreaInApplication = 0;
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
            'chithaArea'   => $chithaDagArray,
            'reservedArea' => $allApplicationDagArray,
            'appliedDags'  => $appliedDags,
            'areaCheck'    => $areaCheck,
            'lmProcessArea' => $lmProcessArea,
        );

        return $checkAreaDetail;

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
            $subdiv_code = $this->session->userdata('subdiv_code');
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
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
                if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subdiv_code,$updateData)== 0)
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
                        'case_no'               => $case_no,
                        'proceeding_id'         => $proceeding_id,
                        'date_of_hearing'       => date('Y-m-d h:i:s'),
                        'next_date_of_hearing'  => date('Y-m-d h:i:s'),
                        'status'                => MB_MARK_AS_SDLAC,
                        'user_code'             => $this->session->userdata('user_code'),
                        'date_entry'            => date('Y-m-d h:i:s'),
                        'operation'             => 'E',
                        'note_on_order'         => 'Recommended for SDLAC',
                        'ip'                    => $this->utilityclass->get_client_ip(),
                        'office_from'           => MB_SUB_DIV_COMM,
                        'office_to'             => MB_SUB_DIV_COMM,
                        'task'                  => 'Recommended for SDLAC'
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
                    // {
                    //     $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    //     $rmk='Recommended for SDLAC';
                    //     $status='N';
                    //     $task= MB_DEPUTY_COMM;
                    //     $pen= MB_DEPUTY_COMM;
                    //     $case=$case_no;
                    //     $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    //     $rtps_status=json_decode($rtps_status);
                    //     //var_dump($rtps_status);
                    //     if($rtps_status!="y"){
                    //         $this->db->trans_rollback();
                    //         $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    //         redirect(base_url() . "index.php/home");
                    //     }else{
                    //         $this->db->trans_commit();
                    //         echo json_encode(array(
                    //             'responseType' => 2,
                    //         ));
                    //         return;
                    //     }
                    // }
                    //////proceeding end//////
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
                    $totalAppliedAreaInApplication=0;
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

                // processing application
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
                    $totalAppliedAreaInApplication = 0;
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


    // view all mark as SDLAC VgrPgr
    public function viewAllMarkAsSdlacListForSdoVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getMarkAsSDLACSettlementVgrPgr($dist_code,$subdiv_code);
        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
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

        $data['_view'] = 'settlementView/Sdo/VgrPgr/mark_as_sdlac_case_sdo_VgrPgr';
        $this->load->view('layouts/main', $data);

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

        $this->db->select('cluster_id, dist_code, subdiv_code, cir_code');
        $this->db->from('settlement_circle_cluster');

        $this->db->group_by('cluster_id, dist_code, subdiv_code, cir_code');
        $this->db->where('status', 'T');
        $this->db->where_in('pending_at', MB_SUB_DIV_COMM);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            $this->db->select('cluster_id, dist_code, subdiv_code, cir_code');
            $this->db->from('settlement_circle_cluster');

            $this->db->group_by('cluster_id, dist_code, subdiv_code, cir_code');
            $this->db->where('status', 'T');
            $this->db->where_in('pending_at', MB_SUB_DIV_COMM);
            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                $json[] = array(

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    '<a class="btn btn-info" onclick="sendToSDLAC(\''.$rows->cluster_id.'\')" style="background-color: #9C27B0">
                        <span style="font-weight: bold; color: white" >Make Proposal</span>
                    </a>
                    <a class="btn btn-success" href="'.base_url().'index.php/SettlementVgrPgrSdo/viewSDLACListForDCVgrPgr?cid='.$rows->cluster_id.'">
                        <span style="font-weight: bold; color: white" >View Applications </span>
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


    // case put in cluster
    public function putInCircleCluster()
    {
        $case_no = $this->input->post('case_no');

        $vgrReservation = $this->SettlementVgrModel->getSettlementVgrReservation($case_no);

        if(empty($vgrReservation))
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#JSMR0014545: Please reserve area! '.$case_no
            ]);
            return false;
        }

        $checkReserv = $this->SettlementVgrModel->getTotalVgrReservationInDag($vgrReservation->dist_code, $vgrReservation->subdiv_code, $vgrReservation->cir_code, $vgrReservation->mouza_pargona_code, $vgrReservation->lot_no, $vgrReservation->vill_townprt_code, $vgrReservation->dag_no);

        if($checkReserv['responseType'] != 2)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3530: Chitha area exceed for reservation! '.$case_no
            ]);
            return false;
        }

        //****check if vgr_pgr reservation details inserted if not return */
        $reservationCheckSql = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));

        if($reservationCheckSql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4938: Unable to process! Please insert VGR/PGR reservation details...'
            ]);
            return false;
        }

        $lmNoteReservSqlCheck = $this->db->query('select * from settlement_ap_lmnote where case_no = ?', array($case_no));

        if($lmNoteReservSqlCheck->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4949: Unable to process! Contact admin...'
            ]);
            return false;
        }

        if(trim($lmNoteReservSqlCheck->row()->vgr_dag_availability ) != 'y')
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR4958: Unable to process! Contact admin...'
            ]);
            return false;
        }

        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $user_desig_code = $this->session->userdata('user_desig_code');

        $dist_code = $basic['dist_code'];
        $subdiv_code = $basic['subdiv_code'];
        $cir_code = $basic['cir_code'];

        $this->db->trans_begin();

        $sql = $this->db->query('select * from settlement_circle_cluster where dist_code = ? and subdiv_code = ? and cir_code = ? and proposal_id IS NULL', array($dist_code, $subdiv_code, $cir_code));

        if($sql->num_rows() <= 0)
        {
            //******insert and create cluster ID */
            $insertArr = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'status' => 'AE',
                'pending_at' => $user_desig_code,
                'date_entry' => date('Y-m-d H:i:s'),
            ];

            $insert = $this->db->insert('settlement_circle_cluster', $insertArr);

            if($insert != 1)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5267: Unable to process! Contact admin...'
                ]);
                return false;
            }

            $this->db->trans_commit();
        }

        $this->db->trans_begin();
        //******update basic status */
        $basicArr = [
            'status' => 'AE',
            // 'co_code' => $co_code,
            'date_update' => date('Y-m-d h:i:s'),
            // 'from_office' => $user_desig_code,
            'pending_officer' => $user_desig_code,
            'pending_office' => $user_desig_code,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3346: Update failed in settlement_basic'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5296: Unable to process! Contact admin...'
            ]);
            return false;
        }

        //*******get the cluster id */
        $sqlC = $this->db->query('select cluster_id from settlement_circle_cluster where dist_code = ? and subdiv_code = ? and cir_code = ? and proposal_id IS NULL', array($dist_code, $subdiv_code, $cir_code));

        if($sqlC->num_rows() <= 0)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5282: Unable to process! Contact admin...'
            ]);
            return false;
        }

        $clusterID = $sqlC->row()->cluster_id;

        //********check if case already inserted in circle cluster*/
        $sqlCircleC = $this->db->query('select * from settlement_circle_cluster_cases where case_no = ?', array($case_no));
        if($sqlCircleC->num_rows() > 0)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5323: Unable to process! Case already forwarded to circle cluster...'
            ]);
            return false;
        }

        $insertArrCases = [
            'cluster_id' => $clusterID,
            'case_no' => $case_no,
            'date_entry' => date('Y-m-d H:i:s')
        ];

        $insertCases = $this->db->insert('settlement_circle_cluster_cases', $insertArrCases);

        if($insertCases != 1)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5302: Unable to process! Contact admin...'
            ]);
            return false;
        }

        //******insert into settlement_proceeding */
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            // 'note_type' => $remark_co,
            'note_on_order' => 'Case forwarded to circle cluster',
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => $user_desig_code,
            'office_to' => $user_desig_code,
            'task' => 'Case forwarded to circle cluster'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR5372: Insertion failed in settlement_proceeding'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3401: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Successfully forwarded to circle cluster...'
        ]);
    }

    // Marked all cases
    public function forwardSdlac()
    {
        $cluster_id = $this->input->post('cluster_id');
        $user_code = $this->session->userdata('user_code');

        $sql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

        if($sql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5403: Something went wrong! Contact admin...'
            ]);
            return false;
        }

        $cluster_id = $sql->row()->cluster_id;

        //*******check if all cluster cases has been processed */

        //*******total processed */
        $url = API_LINK_MB2.'getCaseCountByCircle/'.$sql->row()->dist_code.'/'.$sql->row()->subdiv_code.'/'.$sql->row()->cir_code.'/'.SETTLEMENT_PGR_VGR_LAND_ID;
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
        $countApiSum = (int)$apiTot[0]->pending;
        $cluster_status = $sql->row()->status;

        $sql_cases = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

        if($sql_cases->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5416: Something went wrong! Contact admin...'
            ]);
            return false;
        }
        $caseCountInCluster = $sql_cases->num_rows();

        // $getAllCasesFromClusterCount = $this->db->query('select count(*) from settlement_circle_cluster a 
        //   join settlement_circle_cluster_cases b on a.cluster_id::varchar = b.cluster_id::varchar where a.dist_code =? and 
        //   a.subdiv_code = ? and a.cir_code = ?',
        //     array($sql->row()->dist_code, $sql->row()->subdiv_code,$sql->row()->cir_code))->row()->count;


        // $remainingClusCases = $getAllCasesFromClusterCount - $caseCountInCluster;
        // $remainingClusCases = $caseCountInCluster;
        // $totalPendingAppInCircle = $countApiSum - $remainingClusCases;

        // if($caseCountInCluster != $totalPendingAppInCircle)
        // {
        //     echo json_encode([
        //         'responseType' => 0,
        //         'msg' => '#ERR5633: All cases in this circle should be in the cluster to process further!'
        //     ]);
        //     return false;
        // }


        $result = $sql_cases->result();

        //*****API to check if cases are yet to come in circle cluster */


        //******end of API */

        foreach($result as $res)
        {
            $cluster_case_no = $res->case_no;
            $basic_sql = $this->db->query('select * from settlement_basic where case_no = ?', array($cluster_case_no));

            if($basic_sql->num_rows() <= 0)
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5434: Something went wrong! Contact admin...'
                ]);
                return false;
            }

            $basic_row = $basic_sql->row();
            $basic_status = $basic_row->status;

            if($cluster_status != $basic_status)
            {
                if($basic_status == 'D')
                {
                    continue;
                }
                else
                {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR5454: Some cases of this cluster are reverted and still pending...'
                    ]);
                    return false;
                }
            }

            ///****check if chitha area exceed */
            $checkArea = $this->chithaReserveAreaCheckWithCaseNo($cluster_case_no);
            if($checkArea == 1)
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5472: Applied area exceeded than chitha area!'
                ]);
                return false;
            }

            //******Recommend for SDLAC */
            $this->db->trans_begin();

            $updateBasicArr = [
                'status'  => MB_MARK_AS_SDLAC,
                'dc_code' => $user_code,
                'dc_proceeding' => 1,
            ];

            $this->db->where('case_no', $cluster_case_no);
            $this->db->update('settlement_basic', $updateBasicArr);

            if($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5494: Unable to recommend for SDLAC !'
                ]);
                return false;
            }

            //****insert into settlemnet_proceeding */
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$cluster_case_no' ")->row()->c;
            if($proceeding_id==null)
            {
                $proceeding_id=1;
            }
            $insPetProceed = [
                'case_no' => $cluster_case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'status' => MB_MARK_AS_SDLAC,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'note_on_order' => 'Recommended for SDLAC',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => MB_SUB_DIV_COMM,
                'office_to' => MB_SUB_DIV_COMM,
                'task' => 'Recommended for SDLAC'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if($insertProceeding != 1)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5526: Unable to recommend for SDLAC !'
                ]);
                return false;
            }
        }

        //*****update cluster status */
        $upateClusterArr = [
            'status' => MB_MARK_AS_SDLAC,
            'date_update' => date('Y-m-d H:i:s')
        ];

        $this->db->where('cluster_id', $cluster_id);
        $this->db->update('settlement_circle_cluster', $upateClusterArr);

        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5543: Unable to recommend for SDLAC !'
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Successfully recommended for SDLAC'
        ]);
    }


    // check case match status in cluster or not // meooo
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


    // send all application to SDLAC // meooo
    public function sendAllMarkAppToSdlacBySdo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cluster_id', 'Cluster id', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('selectedMem[]', 'Case Number', 'required');

        $errorArray = array();
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 0,
                'message' => '#ERR909: Validation error! Please fill all the required fields...'
            ));
        }
        else
        {
            $currentDate = date('Y-m-d');
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
            $cluster_id = $this->input->post('cluster_id');
            $allSelectedMem  = $this->input->post('selectedMem');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $proposalSequenceNo = $this->generateProposalIdSequenceNo();
            $venue = $this->input->post('venue');

            //*****getting the circle location */
            $circleLocationSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

            if($circleLocationSql->num_rows() <= 0)
            {
                echo json_encode(array(
                    'responseType' => 0,
                    'message' => '#ERR931: Something went wrong! Contact admin...'
                ));
                return;
            }

            $cirLoc = $circleLocationSql->row();
            $cir_dist_code = $cirLoc->dist_code;
            $cir_subdiv_code = $cirLoc->subdiv_code;
            $cir_cir_code = $cirLoc->cir_code;

            $clustSql = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

            if($clustSql->num_rows() <= 0)
            {
                echo json_encode(array(
                    'responseType' => 0,
                    'message' => '#ERR932: Something went wrong! Contact admin...'
                ));
                return;
            }

            $cluster_cases = $clustSql->result();
            $allSelectedList = array();

            foreach($cluster_cases as $ccs)
            {
                $clu_case = $ccs->case_no;

                $sqlBasicCheck = $this->SettlementVgrModel->getSettlementBasic($clu_case);
                $modificationRequest = $this->checkCaseInModificationRequestWithSession($clu_case);
                if($modificationRequest == 1)
                {
                    echo json_encode(array(
                        'responseType' => 101,
                        'response'     => 101,
                        'message'      => '#MRPULL00101 : There is a Modification request from CO for this 
                        case ('.$clu_case. ')',
                    ));
                    return false;
                }
                if($sqlBasicCheck['status'] != 'D')
                {
                    if($sqlBasicCheck['status'] != 'T')
                    {
                        echo json_encode(array(
                            'responseType' => 0,
                            'message' => '#ERR951: Some cases of this cluster is still pending !'
                        ));
                        return;
                    }
                }

                $allSelectedList[] = $clu_case;
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

            // if($currentDate > $hearingDate)
            // {
            //     echo json_encode(array(
            //         'responseType' => 0,
            //         'message' => '#ERR1006: Something went wrong! Contact admin...'
            //     ));
            //     return;
            // }

            if(!empty($allSelectedList))
            {
                $reservationDetails = array();

                foreach ($allSelectedList as $row)
                {
                    $case_no = trim($row);
                    $CheckClusterCount = $this->checkIfCaseRevertedFromCluster($case_no);
                    if(trim($CheckClusterCount['clusterStatus']) != 1)
                    {
                        echo json_encode(array(
                            'responseType' => 0,
                            'message' => $CheckClusterCount['clusterError']
                        ));
                        return ;
                    }

                    $rSql = $this->db->query('select r.case_no, r.dist_code,r.subdiv_code,r.cir_code,r.mouza_pargona_code,r.lot_no,r.vill_townprt_code,r.dag_no from settlement_vgr_pgr_reservation r where r.case_no = ?', array($case_no));

                    if($rSql->num_rows() <= 0)
                    {
                        echo json_encode(array(
                            'responseType' => 0,
                            'message' => '#ERR1025: Something went wrong! Contact admin...'
                        ));
                        return;
                    }

                    $dSql = $this->db->query('select SUM(d.s_dag_area_b*100 + d.s_dag_area_k*20 + d.s_dag_area_lc) AS total_lessa, 
                    SUM(d.s_dag_area_b*6400 + d.s_dag_area_k*320 + d.s_dag_area_lc*20 + d.s_dag_area_g) AS total_ganda from settlement_dag_details d where d.case_no = ? GROUP BY d.case_no', array($case_no));

                    if($dSql->num_rows() <= 0)
                    {
                        echo json_encode(array(
                            'responseType' => 0,
                            'message' => '#ERR1037: Something went wrong! Contact admin...'
                        ));
                        return;
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


                    $reservationDetails[] = (object)[
                        'case_no' => $reservation->case_no,
                        'dist_code' => $basic['dist_code'],
                        'subdiv_code' => $basic['subdiv_code'],
                        'cir_code' => $basic['cir_code'],
                        'mouza_pargona_code' => $basic['mouza_pargona_code'],
                        'lot_no' => $basic['lot_no'],
                        'village_townprt_code' => $basic['vill_townprt_code'],
                        'dist_name' => $this->utilityclass->getDistrictName($basic['dist_code']),
                        'subdiv_name' => $this->utilityclass->getSubDivName($basic['dist_code'], $basic['subdiv_code']),
                        'cir_name' => $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']),
                        'mouza_name' => $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']),
                        'lot_name' => $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']),
                        'village_name' => $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']),
                        'reservation_dist_code' => $reservation->dist_code,
                        'reservation_subdiv_code' => $reservation->subdiv_code,
                        'reservation_cir_code' => $reservation->cir_code,
                        'reservation_mouza_pargona_code' => $reservation->mouza_pargona_code,
                        'reservation_lot_no' => $reservation->lot_no,
                        'reservation_vill_townprt_code' => $reservation->vill_townprt_code,
                        'reservation_dag_no' => $reservation->dag_no,
                        'reservation_bigha' => $bklg[0],
                        'reservation_katha' => $bklg[1],
                        'reservation_lessa' => $bklg[2],
                        'reservation_ganda' => $bklg[3],
                        'reservation_dist_name' => $this->utilityclass->getDistrictName($reservation->dist_code),
                        'reservation_subdiv_name' => $this->utilityclass->getSubDivName($reservation->dist_code, $reservation->subdiv_code),
                        'reservation_cir_name' => $this->utilityclass->getCircleName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code),
                        'reservation_mouza_name' => $this->utilityclass->getMouzaName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code),
                        'reservation_lot_name' => $this->utilityclass->getLotName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no),
                        'reservation_village_name' => $this->utilityclass->getVillageName($reservation->dist_code, $reservation->subdiv_code, $reservation->cir_code,$reservation->mouza_pargona_code,$reservation->lot_no, $reservation->vill_townprt_code),
                        'isBarakValley' => $isBarakValley
                    ];


                    $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
                    $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subdiv_code);
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
                            'responseType' => 0,
                            'message' => '#ERR1116: Something went wrong! Contact admin...'
                        ));
                    }
                }

                if(count($errorArray) > 0)
                {
                    $case_str = '';

                    foreach ($errorArray as $err)
                    {
                        $case_str = $case_str.$err.',';
                    }
                    echo json_encode(array(
                        'responseType' => 10,
                        'application'  => $case_str
                    ));
                    return;
                }

                $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($this->session->userdata('dist_code'));
                $commMembers = $this->SettlementMbDcModel->getMembersFromUsers($this->session->userdata('dist_code'));
                $subdiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'));


                //*****reservation details in circle  */
                $reservationByCircleDetails = array();

                $sql_rc = $this->db->query('select r.dist_code, r.subdiv_code, r.cir_code, 
                SUM(r.dag_area_b*100 + r.dag_area_k*20 + r.dag_area_lc) AS total_lessa, 
                SUM(r.dag_area_b*6400 + r.dag_area_k*320 + r.dag_area_lc*20 + r.dag_area_g) AS total_ganda 
                from settlement_vgr_pgr_reservation r join settlement_basic b on r.case_no = b.case_no where b.status not in (\'D\', \'F\') and b.status = ? and r.dist_code =? and r.subdiv_code =? and r.cir_code =? group by r.dist_code, r.subdiv_code, r.cir_code', array('T', $cir_dist_code, $cir_subdiv_code, $cir_cir_code));

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

                    $reservationByCircleDetails[] = (object)[
                        'dist_name' => $this->utilityclass->getDistrictName($rrc->dist_code),
                        'subdiv_name' => $this->utilityclass->getSubDivName($rrc->dist_code, $rrc->subdiv_code),
                        'cir_name' => $this->utilityclass->getCircleName($rrc->dist_code, $rrc->subdiv_code, $rrc->cir_code),
                        'bigha' => $circleBKLG[0],
                        'katha' => $circleBKLG[1],
                        'lessa' => $circleBKLG[2],
                        'ganda' => $circleBKLG[3],
                        'isBV' => $isBV
                    ];
                }


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

                if($allSelectedMember == '')
                {
                    echo json_encode(array(
                        'responseType' => 0,
                        'message' => 'Please select SDLAC/CDLAC Member...'
                    ));
                    return;
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
                    'responseType'          => 2,
                    'caseList'              => $allSelectedList,
                    'reservationDetails' => $reservationDetails,
                    'reservationByCircleDetails' => $reservationByCircleDetails,
                    'hearingDate'           => date("F j, Y",strtotime($hearingDate)),
                    'timing'             => date("h:i a",strtotime($hearingDate)),
                    'remarks'            => $remarks,
                    'proposalSequenceNo' => $proposalSequenceNo,
                    'distName'           => $dist_name->locname_eng,
                    'subDivName'         => $subdiv_name->locname_eng,
                    'commMembers'        => $commMembers,
                    'venue'              => $venue,
                    'cluster_id'         => $cluster_id,
                ));

                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 0,
                    'message' => '#ERR1244: Something went wrong! Contact admin...'
                ));
                return;
            }
        }
    }


    // generate Proposal Id
    function generateProposalIdSequenceNo()
    {
        $proposalId = $this->db->query("select nextval('settlement_proposal_list_id_seq') as count ")->row()->count;
        return $proposalId;
    }


    // generate proposal notice VgrPgr // meooo
    public function generateNoticeSendAllMarkAppToSdlacBySdoVgrPgr()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required');
        $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('cluster_id', 'Cluster ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('selectedMem[]', 'Case Number', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => '#JSMR002720: Validation Error !, Please try again'
            ));
            return;
        }
        else
        {
            $cluster_id = $this->input->post('cluster_id');

            //check if all cases selected to be approved by either department(urban) or dc(rural)
            $clustSql = $this->db->query('select * from settlement_circle_cluster_cases where cluster_id = ?', array($cluster_id));

            if($clustSql->num_rows() <= 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#JSMR002734: Cluster not found !, Please try again'
                ));
                return;
            }

            $cluster_cases = $clustSql->result();
            $allSelectedList = array();

            foreach($cluster_cases as $ccs)
            {
                $clu_case = $ccs->case_no;

                $sqlBasicCheck = $this->SettlementVgrModel->getSettlementBasic($clu_case);

                if($sqlBasicCheck['status'] != 'D')
                {
                    if($sqlBasicCheck['status'] != 'T')
                    {
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#JSMR002749: There is some problem !, Please try again'
                        ));
                        return;
                    }
                }
                $allSelectedList[] = $clu_case;
            }

            $currentDate = date('Y-m-d');
            $hearingDate = date("Y-m-d", strtotime($this->input->post('hearingDate')));
            $user_code   = $this->session->userdata('user_code');
            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $remarks     = $this->input->post('remarks');
            $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
            $proposal_id     = $this->input->post('proposal_id');
            $allSelectedMem  = $this->input->post('selectedMem');

            if($htmlstring_text == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#JSMR002768: There is some problem, Please try again'
                ));
                return;
            }

            // if($currentDate > $hearingDate)
            // {
            //     echo json_encode(array(
            //         'responseType' => 1,
            //         'message'      => '#JSMR002777: Hearing date should be greater then current date !, Please try again'
            //     ));
            //     return;
            // }

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
                    'id'              => $proposal_id,
                    'dist_code'       => $dist_code,
                    'user_code'       => $user_code,
                    'status'          => 1,
                    'proposal_status' => 1,
                    'h_date'          => $hearingDate,
                    'remarks'         => $remarks,
                    'ip'              => $this->input->ip_address(),
                    'file_path'       => $base_64_file_path,
                    'created_by'      => MB_SUB_DIV_COMM,
                    'subdiv_code'     => $subdiv_code,
                    'proposal_name'   => strtoupper($proposalName)
                );
                $this->db->trans_begin();
                if($this->SettlementVgrPgrSdoModel->saveProposalSDLACVgrPgr($dataProSave) == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#JSMR002825: There is some problem, Please try again'
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
                            'created_at'  => date('Y-m-d h:i:s'),
                        ];
                        $ins = $this->db->insert('sdlac_present_member', $memberData);
                        if($ins != 1 || $ins != true ){
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002185: Insertion failed in sdlac_present_member for 
                        proposal no : '.$proposal_id. ' and query is '. $this->db->last_query());
                            $json = [
                                'response' => 1,
                                'message'  => '#ERMR002185: SDLAC/CDLAC Member not added. Kindly contact system administrator',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }


                    foreach ($allSelectedList as $row)
                    {
                        $case_no = $row;
                        $this->utilityclass->checkUserAuthForCaseForSdoWithRollback($case_no);
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
                        $saveCaseList = array(
                            'proposal_id' => $proposalId,
                            'case_no' => $case_no,
                            'status' => 1,
                            'ip' => $this->input->ip_address()
                        );
                        if($this->SettlementVgrPgrSdoModel->saveProposalCaseListSDLACVgrPgr($saveCaseList) == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#JSMR002884: There is some problem, Please try again'
                            ));
                            return;
                        }

                        $clusterArr = [
                            'status'      => MB_SEND_TO_SDLAC,
                            'pending_at'  => MB_SUB_DIV_COMM,
                            'date_update' => date('Y-m-d H:i:s'),
                            'proposal_id' => $proposalId
                        ];

                        $this->db->where('cluster_id', $cluster_id);
                        $this->db->update('settlement_circle_cluster', $clusterArr);
                        if($this->db->affected_rows() == 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#JSMR002904: There is some problem, Please try again'
                            ));
                            return;
                        }

                        $updateData = array(
                            'status'          => MB_SEND_TO_SDLAC,
                            'pending_office'  => MB_SDLAC,
                            'pending_officer' => MB_SUB_DIV_COMM,
                            'from_office'     => MB_SUB_DIV_COMM,
                            'dc_code'         => $user_code,
                            'dc_proceeding'   => 1,
                        );
                        if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subdiv_code,$updateData)== 0)
                        {
                            $this->db->trans_rollback();
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#JSMR002824: There is some problem, Please try again'
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
                                'status'               => MB_SEND_TO_SDLAC,
                                'user_code'            => $this->session->userdata('user_code'),
                                'date_entry'           => date('Y-m-d h:i:s'),
                                'operation'            => 'E',
                                'note_on_order'        => 'Send to SDLAC',
                                'ip'                   => $this->utilityclass->get_client_ip(),
                                'office_from'          => MB_SUB_DIV_COMM,
                                'office_to'            => MB_SUB_DIV_COMM,
                                'task'                 => 'Send to SDLAC'
                            ];
                            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                            if($insertProceeding != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                                echo json_encode(array(
                                    'responseType' => 1,
                                    'message'      => '#JSMR002960: There is some problem, Please try again'
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
                    'message'      => '#JSMR002979: There is some problem !, Please try again'
                ));
                return;
            }
        }
    }


    function randomFileName()
    {
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'proposal_notice_'.$dist_code.'_'.$rand;

        if($this->SettlementVgrPgrSdoModel->checkDuplicateFileNameInProposal($new_case_no) != 0)
        {
            $this->randomFileName();
        }
        else
        {
            return $new_case_no;
        }

    }


    // get all proposal list for VgrPgr
    public function getAllProposalListSdlacVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code   = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getAllProposalSendByDcToSdlacVgrPgr($dist_code,$subdiv_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Sdo/VgrPgr/proposal_list_send_to_sdlac_VgrPgr';
        $this->load->view('layouts/main', $data);
    }


    // pagination of third proceeding SDLAC Report
    public function thirdProceedingSdlacReport()
    {
        $service      = $this->input->post('service');
        $by_case_no   = $this->input->post('case_no');
        $proposal_no  = $this->input->post('proposal_no');
        $hdate        = strtotime($this->input->post('hearing_date'));
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
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
            $this->db->where('settlement_proposal_list.status', 1);
            $this->db->where('settlement_proposal_list.created_by', MB_SUB_DIV_COMM);
            $this->db->where('settlement_proposal_list.dist_code', $dist_code);
            $this->db->where('settlement_proposal_list.subdiv_code', $subdiv_code);
            $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
            $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
            $this->db->where('settlement_proposal_list.final_verify_status', 0);
        }

        else if (!empty($proposal_no)) {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('id', $proposal_no);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
        }

        else if(!empty($hearing_date)){
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('h_date', $hearing_date);
            $this->db->where_in('sdlac_prceed_status', [0,1]);
            $this->db->where('final_verify_status', 0);
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('status', 1);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
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
                $this->db->where('settlement_proposal_list.created_by', MB_SUB_DIV_COMM);
                $this->db->where('settlement_proposal_list.dist_code', $dist_code);
                $this->db->where('settlement_proposal_list.subdiv_code', $subdiv_code);
                $this->db->where('settlement_proposal_cases.case_no', $by_case_no);
                $this->db->where_in('settlement_proposal_list.sdlac_prceed_status', [0,1]);
                $this->db->where('settlement_proposal_list.final_verify_status', 0);
            }

            else if (!empty($proposal_no)) {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_SUB_DIV_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('id', $proposal_no);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
            }

            else if(!empty($hearing_date)){
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_SUB_DIV_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('h_date', $hearing_date);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('status', 1);
                $this->db->where('created_by', MB_SUB_DIV_COMM);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where_in('sdlac_prceed_status', [0,1]);
                $this->db->where('final_verify_status', 0);
            }

            $query1 = $this->db->get();

            $total_records = $query1->num_rows();
            $i=1;

            foreach($result as $rows) {

                $json[] = array (

                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    'Proposal No <b>'. $rows->id .'</b> <i class="fa fa-chevron-down text-red btn_down" onclick="openTab('.$rows->id.')"></i>

                  <div class="text-green" id="list_of_cases_'.$rows->id.'"></div>',

                    '<i class="fa fa-calendar"></i> On '. date('d-m-Y', strtotime($rows->h_date)),

                    '<i class="fa fa-user"></i> '. ($rows->created_by == '')? $rows->created_by: 'NA',

                    '<a class="btn btn-sm btn-primary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Print Notice</a>
                     
                     <a class="btn btn-sm btn-dark" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/downloadCasesWithProposalId/?case='.$rows->id.'">Download</a>
                                     
                     <a class="btn btn-sm btn-success" href="'.base_url().'index.php/SettlementVgrPgrSdo/getAllApplicationInReportSendBySdoToSdlacVgrPgr/?case='.$rows->id.'">
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
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $user_code    = $this->session->userdata('user_code');

        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
        settlement_proposal_cases A JOIN settlement_proposal_list B ON
        B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=? AND B.service_code=?
        AND B.created_by=? AND B.subdiv_code=?",
            array($proposal_id, $dist_code, $service_code, MB_SUB_DIV_COMM, $subdiv_code));

        $response = array(
            'response' => $result->result(),
        );
        echo json_encode($response);
    }


    // get all application send by dc to sdlac for report VgrPgr // meooo
    public function getAllApplicationInReportSendBySdoToSdlacVgrPgr()
    {

        $proposal_no = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code   = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposal_no);
        $proposalDetails = $this->SettlementVgrPgrSdoModel->getProposalDetailsById($proposal_no,$dist_code,$subdiv_code);

        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $data['proposalDetails'] = $proposalDetails;

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

        $data['_view'] = 'settlementView/Sdo/VgrPgr/send_to_sdlac_case_dc_VgrPgr';
        $this->load->view('layouts/main', $data);

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
            $remarks     = $this->input->post('remarks');
            $proposalNo  = $this->input->post('proposalNo');
            // if($currentDate > $hearingDate)
            // {
            //     echo json_encode(array(
            //         'responseType' => 1,
            //     ));
            //     return;

            // }

            $allCases      = $this->SettlementVgrPgrSdoModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposalNo);
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


    //check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus() {
        $proposal_id  = $this->input->post('prop_id');
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');

        $processStatus = $this->db->query("SELECT * FROM settlement_proposal_list
                                    WHERE sdlac_prceed_status ".PROPOSAL_SEND_TO_SDLAC." 
                                    AND dist_code = ? AND id = ? AND subdiv_code = ? 
                                    AND created_by = ? ",
            array($dist_code, $proposal_id, $subdiv_code, MB_SUB_DIV_COMM));

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
            $proposalDetails = $this->SettlementVgrPgrSdoModel->getProposalDetailsById($proposalNo,$dist_code);
            if($proposalDetails == '')
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $allCases      = $this->SettlementVgrPgrSdoModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposalNo);
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
                    if($this->SettlementVgrPgrSdoModel->updateProposalListById($proposalNo,$updateProposalData)== 0)
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
                            $this->utilityclass->checkUserAuthForCaseForSdoWithRollback($case_no);
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
                                'office_from' => MB_SUB_DIV_COMM,
                                'office_to'   => MB_SUB_DIV_COMM,
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


    // get all forth proceeding SDLAC Report Khas page
    public function getAllSdlacMemberApprovalProposalListVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getSdlacApprovalProposalListVgrPgr($dist_code,$subdiv_code);

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();

        $data['_view'] = 'settlementView/Sdo/VgrPgr/sdlac_approval_proposal_list_VgrPgr';
        $this->load->view('layouts/main', $data);

    }


    // get all forth proceeding SDLAC Report Khas with data
    public function getAllSdlacMemberApprovalProposalListDataVgrPgr()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $proposal_no = $this->input->post('proposal_no');
        $hdate       = strtotime($this->input->post('hearing_date'));
        $dist_code   = $this->session->userdata('dist_code');
        $ru          = $this->session->userdata('user_desig_code');
        $suv_div     = $this->session->userdata('subdiv_code');

        if($hdate != false && $hdate != ''){
            $hearing_date = date('Y-m-d', $hdate);
        }

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
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
            $this->db->where('settlement_proposal_list.subdiv_code', $suv_div);
            $this->db->where('settlement_proposal_list.created_by', MB_SUB_DIV_COMM);
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
            $this->db->where('subdiv_code', $suv_div);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
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
            $this->db->where('subdiv_code', $suv_div);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
        }

        else {
            $this->db->select('*');
            $this->db->from('settlement_proposal_list');
            $this->db->where('service_code', $service);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('status', 1);
            $this->db->where('sdlac_prceed_status', 2);
            $this->db->where('final_verify_status', 0);
            $this->db->where('subdiv_code', $suv_div);
            $this->db->where('created_by', MB_SUB_DIV_COMM);
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
                $this->db->where('settlement_proposal_list.subdiv_code', $suv_div);
                $this->db->where('settlement_proposal_list.created_by', MB_SUB_DIV_COMM);
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
                $this->db->where('subdiv_code', $suv_div);
                $this->db->where('created_by', MB_SUB_DIV_COMM);
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
                $this->db->where('subdiv_code', $suv_div);
                $this->db->where('created_by', MB_SUB_DIV_COMM);
            }

            else {
                $this->db->select('*');
                $this->db->from('settlement_proposal_list');
                $this->db->where('service_code', $service);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('status', 1);
                $this->db->where('sdlac_prceed_status', 2);
                $this->db->where('final_verify_status', 0);
                $this->db->where('subdiv_code', $suv_div);
                $this->db->where('created_by', MB_SUB_DIV_COMM);

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

                    '<a class="rezaButt buttPrimary" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/getProposalNotice/?case='.$rows->id.'">Notice</a>
                    
                    <a class="rezaButt buttInfo2" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacAttendance/?case='.$rows->id.'">Attendance</a>
                    
                    <a class="rezaButt buttCust" target= "SDLACProposalNotice" href="'.base_url().'index.php/SettlementCommonDc/viewSdlacUploadedMinute/?case='.$rows->id.'">Minutes</a>
                    
                    <a class="rezaButt btn-success" href="'.base_url().'index.php/SettlementVgrPgrSdo/getSdlacMemberApproveProposalViewIndividualVgrPgr/?case='.$rows->id.'">
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


    // SDLAC Report status send to SDLAC/CDLAC Member // meooo
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

            $CheckClusterCount = $this->checkIfCaseRevertedFromCluster($caseNo);
            if(trim($CheckClusterCount['clusterStatus']) != 1)
            {
                echo json_encode(array(
                    'response' => 1,
                    'message'  => $CheckClusterCount['clusterError']
                ));
                return ;
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
            $created_at  = date('Y-m-d h:i:s');
            $updated_at  = date('Y-m-d h:i:s');
            $sdlac_mem   = $this->input->post('sdlac_mem');
            $nom_name    = $this->input->post('nominee_name');
            $nom_contact = $this->input->post('nominee_cont');
            $nom_email   = $this->input->post('nominee_email');

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
            if($insert != 1 || $insert != true)
            {
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


    // forth proceeding SDLAC Report view
    public function getSdlacMemberApproveProposalViewIndividualVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $suv_div     = $this->session->userdata('subdiv_code');
        $proposal_no = $this->input->get('case');
        $proposalDetails  = $this->SettlementVgrPgrSdoModel->getSdlacApprovalProposalIndividualVgrPgr($proposal_no,$dist_code,$suv_div);
        $reportDetails    = $this->SettlementVgrPgrSdoModel->getSdlacMemberReportDetailsVgrPgr($proposal_no,$dist_code,$suv_div);
        $getMembersStatus = $this->SettlementVgrPgrSdoModel->getSdlacMemberStatus($dist_code, $proposal_no);
        $data['dist_code']        = $dist_code;
        $data['proposal_no']      = $proposal_no;
        $data['cases']            = $proposalDetails->row();
        $data['pendingCaseCount'] = $proposalDetails->num_rows();
        $data['reports']          = $reportDetails->result();
        $data['reportCount']      = $reportDetails->num_rows();
        $data['getMemberStatus']  = $getMembersStatus;
        $data['_view'] = 'settlementView/Sdo/VgrPgr/sdlac_committee_report_details_VgrPgr';
        $this->load->view('layouts/main', $data);
    }


    // proposal Forward To Dc For Final Verify By SDO
    public function proposalForwardToDcForFinalVerifyVgrPgr()
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
            $subDiv_code = $this->session->userdata('subdiv_code');
            $user_code   = $this->session->userdata('user_code');
            $proposal_no = trim($this->input->post('proposalNo'));
            $dist_code   = $this->session->userdata('dist_code');
            $pendingCase = $this->SettlementVgrPgrSdoModel->getAllAppInReportSendByDcToSdlacVgrPgr($proposal_no,$subDiv_code);
            $cases       = $pendingCase->result();
            $caseCount   = $pendingCase->num_rows();
            $proposalDetails = $this->SettlementVgrPgrSdoModel->getProposalDetailsById($proposal_no,$dist_code,$subDiv_code);

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
                // if($case->case_status == 0 or $case->case_status == '')
                // {
                //     $this->db->trans_rollback();
                //     echo json_encode(array(
                //         'responseType' => 3,
                //         'pendingCases' => $pending,
                //         'proposalSequenceNo' => $proposal_no,
                //     ));
                //     return;
                // }

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
                    if($this->SettlementVgrPgrSdoModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
                    {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'responseType' => 1,
                        ));
                        return;
                    }
                    // update in settlement basic
                    $updateBasicData = array(
                        'status'             => MB_FINAL_APPROVED_BY_DC,
                        'pending_office'     => MB_DEPUTY_COMM,
                        'pending_officer'    => MB_DEPUTY_COMM,
                        'from_office'        => MB_SUB_DIV_COMM,
                        'dc_code'            => $user_code,
                        'sdlac_approval'     => 'Y',
                        'sdlac_date'         => date('Y-m-d h:i:s'),
                        'dc_proceeding'      => 1,
                        'final_status'       => MB_APPROVED_BY_SDLAC,
                        'sdlace_proposal_no' => trim($case->proposal_id),
                    );
                    if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($caseNo,$dist_code,$subDiv_code,$updateBasicData)== 0)
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
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_FINAL_APPROVED_BY_DC,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => $case->template_remarks,
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_SUB_DIV_COMM,
                        'office_to'            => MB_DEPUTY_COMM,
                        'task'                 => 'Forwarded to DC for Final Check',
                        'minutes_proposal_id'  => trim($case->proposal_id)
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
                    $task   = MB_SUB_DIV_COMM;
                    $pen    = MB_DEPUTY_COMM;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$caseNo,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if($rtps_status!="y")
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
                    if($this->SettlementVgrPgrSdoModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updateCase)== 0)
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
                        'final_status'    => MB_DISMISS,
                    );

                    if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($caseNo,$dist_code,$subDiv_code,$updateBasicData)== 0)
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
                        $mmnn = $this->SettlementVgrPgrSdoModel->updateSettlementAppDetailsByCaseNoUnderProposal($caseNo,$updatePro);
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
                            'office_from' => MB_SUB_DIV_COMM,
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
                            if($rtps_status!="y")
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
            if($this->SettlementVgrPgrSdoModel->updateProposalListById($proposal_no,$dist_code,$subDiv_code,$dataUpdate)== 0)
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


    // view Approve Application VgrPgr
    public function viewApprovedAppDetailsVgrPgr()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
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
        $nominee = $this->SettlementVgrModel->getAllNomineeDetail($application_no);

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

        $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code,$subDiv_code);
        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandSdo();
        }
        else
        {

            $caseDetails = $this->SettlementVgrPgrSdoModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code,$subDiv_code);
            $proceedings = $this->SettlementVgrPgrSdoModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            $data['_view'] = 'settlementView/Sdo/VgrPgr/settlement_app_details_only_view_vgr_pgr';
            $this->load->view('layouts/main', $data);
        }
    }


    // view Rejected Application Pgr Vgr
    public function viewRejectedAppDetailsVgrPgr()
    {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $this->utilityclass->checkUserAuthForCaseForSdo($case_no);
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
        $nominee = $this->SettlementVgrModel->getAllNomineeDetail($application_no);

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

        $caseCount = $this->SettlementMbSdoModel->countSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code,$subDiv_code);
        if($caseCount == 0)
        {
            $this->SettlementVgrPgrLandSdo();
        }
        else
        {
            $caseDetails = $this->SettlementMbSdoModel->getSettlementAppDetailsByCaseNoOnlyView($case_no,$dist_code,$subDiv_code);
            $proceedings = $this->SettlementMbSdoModel->getSettlementProceeding($case_no);
            $data['caseCount']   = $caseCount;
            $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

            $data['_view'] = 'settlementView/Sdo/VgrPgr/settlement_app_details_rejected_only_view_vgr_pgr';
            $this->load->view('layouts/main', $data);
        }
    }


    // Revert from sdo to co
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
            $case_no   = trim($this->input->post('caseNo'));
            $dist_code = trim($this->session->userdata('dist_code'));
            $remarks   = trim($this->input->post('remarks'));
            $user_code = trim($this->session->userdata('user_code'));
            $subDiv_code = trim($this->session->userdata('subdiv_code'));
            $this->utilityclass->checkUserAuthForCaseForSdo($case_no);

            $caseCount = $this->SettlementVgrPgrSdoModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code,$subDiv_code);
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
                    'from_office'     => MB_SUB_DIV_COMM,
                    'dc_code'         => $user_code,
                    'dc_proceeding'   => 0,
                );
                $this->db->trans_begin();
                if($this->SettlementVgrPgrSdoModel->updateSettlementBasicData($case_no,$dist_code,$subDiv_code,$updateData)== 0)
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
                        'office_from' => MB_SUB_DIV_COMM,
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
                        $rmk='Reverted by SDO';
                        $status='M';
                        $task=MB_SUB_DIV_COMM;
                        $pen=MB_CIRCLE_OFFICER;
                        $case=$case_no;
                        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                        $rtps_status=json_decode($rtps_status);
                        if($rtps_status!="y")
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
                }
            }
        }
    }

    public function getCirclesFromSubdiv()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');

        $curl_handle_uuid = curl_init();
        curl_setopt($curl_handle_uuid, CURLOPT_URL, API_LINK_MB2."totalAppliedAreaInCircleByDistSubdiv");
        curl_setopt($curl_handle_uuid, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle_uuid, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle_uuid, CURLOPT_POSTFIELDS, http_build_query(array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
        )));
        $output = curl_exec($curl_handle_uuid);
        curl_close($curl_handle_uuid);

        $output = json_decode($output);

        //*********getting available total area from chitha */
        $sqlForChithaArea = $this->db->query("SELECT  c.dist_code,  c.subdiv_code,  c.cir_code, SUM(c.dag_area_b*100 + c.dag_area_k*20 + c.dag_area_lc) AS total_lessa_in_chitha, SUM(c.dag_area_b*6400 + c.dag_area_k*320 + c.dag_area_lc*20 + c.dag_area_g) AS total_ganda_in_chitha
            FROM 
                chitha_basic c
            JOIN c_land_bank_details l 
            ON l.dist_code = c.dist_code 
            AND l.subdiv_code = c.subdiv_code 
            AND l.cir_code = c.cir_code 
            AND l.mouza_pargona_code = c.mouza_pargona_code 
            AND l.lot_no = c.lot_no 
            AND l.vill_townprt_code = c.vill_townprt_code 
            AND l.dag_no = c.dag_no 
            WHERE l.nature_of_reservation IN ('7', '8')
            AND 
                c.dist_code = ? 
            AND 
                c.subdiv_code = ? 
            GROUP BY 
                c.dist_code, c.subdiv_code, c.cir_code",
            array($dist_code, $subdiv_code, '00'));

        $chithaAreaInCircleByLot = $sqlForChithaArea->result();

        $lotWiseArrayChita = array();
        $lotWiseArrayApi = array();

        //********separting available area from chitha_area - applied area */
        foreach($chithaAreaInCircleByLot as $chithaLotData)
        {
            //******calculation for barak velley */
            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
            {
                //*********total chitha area in lot */
                $totalChithaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($chithaLotData->total_ganda_in_chitha);
            }
            else
            {
                $totalChithaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($chithaLotData->total_lessa_in_chitha);
            }

            $arrayC1[] = $chithaLotData->dist_code.$chithaLotData->subdiv_code.$chithaLotData->cir_code;

            $lotWiseArrayChita[] = (object)[
                'dist_code' => $chithaLotData->dist_code,
                'subdiv_code' => $chithaLotData->subdiv_code,
                'cir_code' => $chithaLotData->cir_code,
                'cir_name' => $this->utilityclass->getCircleName($chithaLotData->dist_code,$chithaLotData->subdiv_code,$chithaLotData->cir_code),

                'total_area_in_circle' => 'B: '.$totalChithaBKL[0].' K: '. $totalChithaBKL[1].' C: '.$totalChithaBKL[2]. ' G: '.round($totalChithaBKL[3],2),

                'total_applied_area' => '-',

                'total_available_area' => 'B: '.$totalChithaBKL[0].' K: '. $totalChithaBKL[1].' C: '.$totalChithaBKL[2]. ' G: '.round($totalChithaBKL[3],2),

                'available_area_lessa_ganda' =>  in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)) ? $chithaLotData->total_ganda_in_chitha : $chithaLotData->total_lessa_in_chitha,
            ];

            if($output->responseType == 2)
            {
                foreach($output->data as $apiData)
                {

                    if($apiData->dist_code == $chithaLotData->dist_code
                        && $apiData->subdiv_code == $chithaLotData->subdiv_code
                        && $apiData->cir_code == $chithaLotData->cir_code)
                    {
                        $arrayC2[] = $apiData->dist_code.$apiData->subdiv_code.$apiData->cir_code;

                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $totalAppliedApiBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($apiData->barak_converted_ganda);

                            $totalAreaInChita = $this->utilityclass->Total_Bigha_Katha_Lessa2($chithaLotData->total_ganda_in_chitha);

                            $total_avilable_min = (float)$chithaLotData->total_ganda_in_chitha - (float)$apiData->barak_converted_ganda;

                            $totalAvailAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($total_avilable_min);

                            $lotWiseArrayApi[] = (object)[
                                'dist_code' => $chithaLotData->dist_code,
                                'subdiv_code' => $chithaLotData->subdiv_code,
                                'cir_code' => $chithaLotData->cir_code,
                                'cir_name' => $this->utilityclass->getCircleName($chithaLotData->dist_code,$chithaLotData->subdiv_code,$chithaLotData->cir_code),

                                'total_area_in_circle' => 'B: '.$totalAreaInChita[0].' K: '. $totalAreaInChita[1].' C: '.$totalAreaInChita[2]. ' G: '.round($totalAreaInChita[3],2),

                                'total_applied_area' => 'B: '.$totalAppliedApiBKL[0].' K: '. $totalAppliedApiBKL[1].' C: '.$totalAppliedApiBKL[2]. ' G: '.round($totalAppliedApiBKL[3],2),

                                'total_available_area' => 'B: '.$totalAvailAreaBKL[0].' K: '. $totalAvailAreaBKL[1].' C: '.$totalAvailAreaBKL[2]. ' G: '.round($totalAvailAreaBKL[3],2),

                                'available_area_lessa_ganda' => $total_avilable_min
                            ];

                        }
                        else
                        {
                            $totalAppliedApiBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($apiData->luit_converted_lessa);

                            $totalAreaInChita = $this->utilityclass->Total_Bigha_Katha_Lessa($chithaLotData->total_lessa_in_chitha);

                            $total_avilable_min = (float)$chithaLotData->total_lessa_in_chitha - (float)$apiData->luit_converted_lessa;

                            $totalAvailAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($total_avilable_min);

                            $lotWiseArrayApi[] = (object)[
                                'dist_code' => $chithaLotData->dist_code,
                                'subdiv_code' => $chithaLotData->subdiv_code,
                                'cir_code' => $chithaLotData->cir_code,
                                'cir_name' => $this->utilityclass->getCircleName($chithaLotData->dist_code,$chithaLotData->subdiv_code,$chithaLotData->cir_code),


                                'total_area_in_circle' => 'B: '.$totalAreaInChita[0].' K: '. $totalAreaInChita[1].' L: '.$totalAreaInChita[2],

                                'total_applied_area' => 'B: '.$totalAppliedApiBKL[0].' K: '. $totalAppliedApiBKL[1].' L: '.$totalAppliedApiBKL[2],

                                'total_available_area' => 'B: '.$totalAvailAreaBKL[0].' K: '. $totalAvailAreaBKL[1].' L: '.$totalAvailAreaBKL[2],

                                'available_area_lessa_ganda' => $total_avilable_min
                            ];
                        }
                    }
                }
            }
        }

        $sortingArray = array();
        $finalArrayUnsorted = array();
        $diff = array_diff($arrayC1, $arrayC2);

        if(count($diff) > 0)
        {
            foreach($diff as $d)
            {
                foreach($lotWiseArrayChita as $cf)
                {
                    if($d == $cf->dist_code.$cf->subdiv_code.$cf->cir_code)
                    {
                        $sortingArray[] = $cf->available_area_lessa_ganda;

                        $finalArrayUnsorted[] = (object)[
                            'dist_code' => $cf->dist_code,
                            'subdiv_code' => $cf->subdiv_code,
                            'cir_code' => $cf->cir_code,
                            'cir_name' => $cf->cir_name,

                            'total_area_in_circle' => $cf->total_area_in_circle,

                            'total_applied_area' => $cf->total_applied_area,

                            'total_available_area' => $cf->total_available_area,

                            'available_area_lessa_ganda' => $cf->available_area_lessa_ganda,
                        ];
                    }
                }
            }
        }

        foreach($lotWiseArrayApi as $aaf)
        {
            $finalArrayUnsorted[] = (object)[
                'dist_code' => $aaf->dist_code,
                'subdiv_code' => $aaf->subdiv_code,
                'cir_code' => $aaf->cir_code,
                'cir_name' => $aaf->cir_name,

                'total_area_in_circle' => $aaf->total_area_in_circle,

                'total_applied_area' => $aaf->total_applied_area,

                'total_available_area' => $aaf->total_available_area,

                'available_area_lessa_ganda' => $aaf->available_area_lessa_ganda,
            ];
            $sortingArray[] = $aaf->available_area_lessa_ganda;

        }


        //******sorting the final data */\
        $sortedFinalData = array();

        asort($sortingArray, SORT_NUMERIC);
        $sortByAvailableArea = array_reverse($sortingArray, true);

        foreach($sortByAvailableArea as $sort)
        {
            $duplicateCheck = '';

            foreach($finalArrayUnsorted as $unarr)
            {
                if($unarr->dist_code.$unarr->subdiv_code.$unarr->cir_code != $duplicateCheck)
                {
                    if($sort == $unarr->available_area_lessa_ganda)
                    {
                        $sortedFinalData[] = $unarr;

                        $duplicateCheck = $unarr->dist_code.$unarr->subdiv_code.$unarr->cir_code;

                    }
                }
            }
        }

        if(count($sortedFinalData) <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR8487522: Something went wrong! Contact admin...'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'content' => $sortedFinalData,
        ]);

    }

    public function otherCoList()
    {
        // $case_no = $this->input->post();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        // $cir_code = $this->session->userdata('cir_code');

        $case_no = $this->input->post('case_no');

        $this->db->select('c.loc_name, a.user_code, b.username, b.dist_code, b.subdiv_code, b.cir_code');
        $this->db->from('loginuser_table a');
        $this->db->join('users b', 'a.dist_code = b.dist_code AND a.subdiv_code = b.subdiv_code AND a.cir_code = b.cir_code AND a.user_code = b.user_code');
        $this->db->join('location c', 'a.dist_code = c.dist_code AND a.subdiv_code = c.subdiv_code AND a.cir_code = c.cir_code');
        $this->db->where('a.dis_enb_option', 'E');
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('c.mouza_pargona_code', '00');

        if($user_desig_code == 'SDO')
        {
            $this->db->where('a.subdiv_code', $subdiv_code);
        }

        $this->db->where('b.user_desig_code', 'CO');
        $query = $this->db->get();

        if($query->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3304: No CO found!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'content' => $query->result()
        ]);
    }

    public function sendToOtherCo()
    {
        $case_no = $this->input->post('case_no');
        $co_code = $this->input->post('co_code');
        $remark = $this->input->post('remark');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $this->db->trans_begin();
        //***settlement_basic update */
        $basicArr = [
            'status' => 'AD',
            'co_code' => $co_code,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => $user_desig_code,
            'pending_officer' => 'CO',
            'pending_office' => 'CO'
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3346: Update failed in settlement_basic'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3346: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }

        //*****insert into assign talbe */
        $checkIfInserted = $this->db->query('select * from settlement_vgr_co_assign where case_no = ?', array($case_no));


        $insertVgrLmAssign = [
            'case_no' => $case_no,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'user_code' => $co_code,
            'status' => 'AD',
            'date_entry' => date('Y-m-d H:i:s')
            // 'date_update'
        ];

        if($checkIfInserted->num_rows() <= 0)
        {
            $insert = $this->db->insert('settlement_vgr_co_assign', $insertVgrLmAssign);

            if($insert != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR3364: Insertion failed in settlement_vgr_co_assign'. $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3364: Unable to send to CO! Contact admin...'
                ]);
                return false;
            }

        }
        else
        {
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_vgr_co_assign', $insertVgrLmAssign);

            if($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR3395: Update failed in settlement_vgr_co_assign'. $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3395: Unable to send to CO! Contact admin...'
                ]);
                return false;
            }
        }

        //******insert into settlement_proceeding */
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            // 'note_type' => $remark_co,
            'note_on_order' => $remark,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => $user_desig_code,
            'office_to' => 'CO',
            'task' => 'Sent to other circle CO for VGR/PGR reservation'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3401: Insertion failed in settlement_proceeding'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3401: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }

        //*******postAPIBasundhara */
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

        $rmk='Reverted to CO';
        $status='M';
        $task=$user_desig_code;
        $pen='CO';
        $case=$case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        //var_dump($rtps_status);
        if(trim($rtps_status) != "y")
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3453: Unable to send to CO! Contact admin...'
            ]);
            return false;
        }
        else
        {
            $this->db->trans_commit();

            echo json_encode([
                'responseType' => 2,
                'msg' => 'Successfully sent to CO for reservation...'
            ]);
        }
    }


    public function forwardToExistingCluster()
    {
        $case_no = $this->input->post('case_no');

        // todo by masud reza
        echo json_encode([
            'responseType' => 0,
            'msg' => '#JSMR001122: Something went wrong ! Contact admin...'
        ]);
        return false;

        $sql = $this->db->query('select * from settlement_circle_cluster_cases where case_no = ?', array($case_no));
        if($sql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5568: Something went wrong! Contact admin...'
            ]);
            return false;
        }

        $cluster_id = $sql->row()->cluster_id;

        $clust_sql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

        if($clust_sql->num_rows() <=0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5581: Something went wrong! Contact admin...'
            ]);
            return false;
        }

        $cluster_status = $clust_sql->row()->status;
        $cluster_pending_at = $clust_sql->row()->pending_at;

        $checkArea = $this->chithaReserveAreaCheckWithCaseNo($case_no);
        if($checkArea == 1)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5472: Applied area exceeded than chitha area!'
            ]);
            return false;
        }

        $this->db->trans_begin();

        $basicArr = [
            'status' => $cluster_status,
            'pending_officer' => $cluster_pending_at,
            'date_update' => date('Y-m-d H:i:s'),
            'dc_proceeding' => 1,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);
        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5612: Applied area exceeded than chitha area!'
            ]);
            return false;
        }

        //****insert into settlemnet_proceeding */
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
            'note_on_order' => 'Case forwarded to existing cluster',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => MB_SUB_DIV_COMM,
            'office_to' => $cluster_pending_at,
            'task' => 'Case forwarded to existing cluster'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5648: Applied area exceeded than chitha area!'
            ]);
            return false;
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Case successfully forwarded to existing cluster...'
        ]);

    }


    // view all mark as SDLAC KHAS ADC
    public function viewSDLACListForDCVgrPgr()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $pendingCase = $this->SettlementVgrPgrSdoModel->getMarkAsSDLACSettlementVgrPgr($dist_code, $subdiv_code);
        // $getDistrict = $this->SettlementMbDcModel->getLocationName($dist_code);
        $cluster_id = $this->input->get('cid');
        $data['cluster_id'] = $cluster_id;

        $data['dist_code']        = $dist_code;
        $data['cases']            = $pendingCase->result();
        $data['pendingCaseCount'] = $pendingCase->num_rows();
        $getDistrict              = $this->SettlementTribalAdcModel->getLocationName($dist_code);
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
        $data['_view']    = 'settlementView/Adc/VgrPgr/sdlac_all_list';
        $this->load->view('layouts/main', $data);

    }

    public function sdlacRecommendedMarked()
    {
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $remark_cat  = $this->input->post('remark_cat');
        $approvedBy  = $this->input->post('approvedBy');
        $remark_cat_lm  = $this->input->post('remark_cat_lm');

        $cluster_id = $this->input->post('cluster_id');

        $getLocationSql = $this->db->query('select * from settlement_circle_cluster where cluster_id = ?', array($cluster_id));

        $getLocation = $getLocationSql->row();

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
            $this->db->where('settlement_basic.case_no like \'%'.$by_case_no.'%\'');
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
        $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $getLocation->dist_code);
        $this->db->where('settlement_basic.subdiv_code', $getLocation->subdiv_code);
        $this->db->where('settlement_basic.cir_code', $getLocation->cir_code);
        $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
        $this->db->where_in('settlement_basic.pending_officer', MB_SUB_DIV_COMM);
        //approved by  department or DC
        if(!empty($approvedBy))
        {
            if ($approvedBy == 1) // department
            {
                $this->db->where("(trim(settlement_basic.approve_by)='GOVT' or (t.is_urban='Y' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='YES')))" );
            }
            if($approvedBy == 2) // DC
            {
                $this->db->where("(trim(settlement_basic.approve_by)='DC' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='NO'))" );
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
            $this->db->join('(select distinct on(case_no) case_no,is_urban  from settlement_dag_details) t', 'settlement_basic.case_no = t.case_no');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', MB_MARK_AS_SDLAC);
            $this->db->where_in('settlement_basic.pending_officer', MB_SUB_DIV_COMM);
            //approved by  department or DC
            if(!empty($approvedBy))
            {
                if ($approvedBy == 1) // department
                {
                    $this->db->where("(trim(settlement_basic.approve_by)='GOVT' or (t.is_urban='Y' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='YES')))" );
                }
                if($approvedBy == 2) // DC
                {
                    $this->db->where("(trim(settlement_basic.approve_by)='DC' or (t.is_urban='N' and settlement_ap_lmnote.falls_und_gmc='NO'))" );
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
                    if($rows->approve_by == 'DC')
                    {
                        $approved_by = "<span style='color:blue'>DC</span>";
                    }
                    if($rows->approve_by == 'GOVT')
                    {
                        $approved_by = "<span style='color:red'>Department</span>";
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


                    '<span class="px-1"><strong>' . $i . '</strong></span>',
                    $rows->case_no."<br><span style='color:red; font-size:12px'>MB:".$rows->applid."</span>",

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),

                    $lm_remark,

                    $co_remark,

                    // $rows->case_no."<br><span style='color:red; font-size:12px'>MB:".$rows->applid."</span>",

                    $approved_by.'<input type="hidden" value="'.$rows->is_urban.'" id="is_urban'.$rows->id.'" class="is_urban" name="is_urban[]">',

                    '<a class="btn btn-success btn-sm" href="'.base_url().'index.php/SettlementVgrPgrSdo/getSettlementVgrPgrApplicationDetails?case='.$rows->case_no.'">View Application</a>'
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

    public function printNotice()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementVgrModel->getNoticeData($case_no);

        if($data['print_data']->num_rows() <= 0)
        {
            echo json_encode('#ERR3247: Something went wrong! Contact admin');
            return false;
            die;
        }

        $data['print_data'] = $data['print_data']->row();

        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']->notice_link);
        if($path == false){
            echo 'No data found!';
            return;
        }

        // reading the base64 json file and saving it to a variable
        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];
        $data['_view'] = 'SettlementView/Co/Tenant/PrintNotice';
        $this->load->view('layouts/main',$data);
    }


}


?>