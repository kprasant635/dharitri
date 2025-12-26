<?php
class RelinquishmentDcController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->model('Relinquishment/RelinquishmentCommonModel');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->dbswitch();


    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }


    //// ******************* 08-08-2024 / Masud Reza *************************


    public function checkAccessRelinquishment()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,RELINQUISHMENT_PROCESS_ACCESS))
        {
            $errors = '#MRLQMD00: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }


    public function checkAccessRelinquishmentOnlyDc()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if($userDegCode != MB_DEPUTY_COMM)
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }

    public function checkAccessForRelinquishmentCases($case_no)
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $caseDetails = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNo($dist_code,$serviceCode,$case_no);
        if($caseDetails->pending_officer != $userDegCode)
        {
            $errors = '#MRLQM000: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }
    }


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


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    // checking for area
    public function checkChithaAreaWithAppliedArea($case_no)
    {
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = RELINQUISHMENT_ID;
        $basic       = $this->RelinquishmentCommonModel->getRelinquishmentCasesDetails($dist_code,$serviceCode,$case_no);
        $appliedDags = $this->RelinquishmentCommonModel->getSettlementDag($case_no);
        $areaCheck   = 0;
        foreach ($appliedDags as $dag)
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
            $chithaDag    = $this->RelinquishmentCommonModel->getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag);
            $areaCheck    = 0;

            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // applied area
                $bighaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_b, 0);
                $kathaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_k, 0);
                $lessaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_lc, 0);
                $gandaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_g, 0);
                $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($areaInApplication == 0)
                {
                    $areaCheck = 2;
                }
                if($totalAreaInChitha < $areaInApplication)
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

                // applied area
                $bighaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_b, 0);
                $kathaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_k, 0);
                $lessaApp = $this->UtilsModel->defaultValue($dag->s_dag_area_lc, 0);
                $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if($areaInApplication == 0)
                {
                    $areaCheck = 2;
                }
                if($totalAreaInChitha < $areaInApplication)
                {
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;
    }



    // get all pending cases for DC
    public function getAllPendingRelinquishmentCasesDc()
    {

        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $pendingCases = 0;
        if($userDegCode ==  MB_DEPUTY_COMM)
        {
            $pendingCases = $this->RelinquishmentCommonModel->countPendingRelinquishmentCasesDc($dist_code,$serviceCode);
        }

        $data['pendingCaseCount'] = $pendingCases;

        $data['_view'] = 'Relinquishment/pending_cases_list_dc';
        $this->load->view('layouts/main', $data);

    }


    // pagination of first proceeding for DC
    public function firstProceedingPaginationAPIDc()
    {
        $this->checkAccessRelinquishmentOnlyDc();
        $this->checkAccessRelinquishment();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
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

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', 'W');
        $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {

            $result = $query->result();
            $i=1;

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


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', 'W');
            $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),


                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case='.$rows->case_no.'">Process</a>',

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



    // get all notice  cases for DC
    public function getAllNoticeRelinquishmentCasesDc()
    {

        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $pendingCases = 0;
        if($userDegCode ==  MB_DEPUTY_COMM)
        {
            $pendingCases = $this->RelinquishmentCommonModel->countNoticeServedRelinquishmentCasesDc($dist_code,$serviceCode);
        }

        $data['pendingCaseCount'] = $pendingCases;

        $data['_view'] = 'Relinquishment/notice_cases_list_dc';
        $this->load->view('layouts/main', $data);

    }


    // pagination of notice for DC
    public function getAllNoticeRelinquishmentPaginationAPI()
    {
        $this->checkAccessRelinquishmentOnlyDc();
        $this->checkAccessRelinquishment();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
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

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', 'S');
        $this->db->where('notice_generated_yn','Y');
        $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {

            $result = $query->result();
            $i=1;

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


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', 'S');
            $this->db->where('notice_generated_yn','Y');
            $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),


                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case='.$rows->case_no.'">Process</a>',

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




    // get case details
    public function getRelinquishmentApplicationDetailsDc()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $case_no     = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $caseQuery   = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);

        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMD001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != MB_DEPUTY_COMM)
        {
            $errors = '#MRLQMD002: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $areaCheck = $this->checkChithaAreaWithAppliedArea($case_no);

        $application_no = $caseDetails->applid;
        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date       = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
        $sup_doc_sql    = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

        if($sup_doc_sql->num_rows() > 0)
        {
            $data['geo_tag_doc'] = $sup_doc_sql->result();
        }
        else
        {
            $data['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }

        // additional property
        $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
        if($additional_property->num_rows() > 0)
        {
            $totallesaa = 0;
            $totalganda = 0;
            foreach($additional_property->result() as $addprop){
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY)))
                {
                    $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }
                else
                {
                    $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }
            }
            if(!empty($totallesaa))
            {
                $data['total_aditional_area'] = $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda))
            {
                $data['total_aditional_area_g'] = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $data['additional_property'] = $additional_property->result();
        }

        $applicants_owners = $this->RelinquishmentCommonModel->getAllApplicantOwners($case_no);
        $applicants_buyers = $this->RelinquishmentCommonModel->getAllApplicantBuyers($case_no);
        $dags              = $this->RelinquishmentCommonModel->getSettlementDag($case_no);
        $proceedings       = $this->RelinquishmentCommonModel->getSettlementProceeding($case_no);
        $dhardocuments     = $this->RelinquishmentCommonModel->getDocuments($case_no);
        $nominee           = $this->RelinquishmentCommonModel->getAllNomineeDetail($case_no);
        $lmnotes           = $this->RelinquishmentCommonModel->getSettlementLraReport($case_no);

        $data['lmnotes'] = $lmnotes;
        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes))
        {
            $lmdata['lm_report'] ="no";
        }
        else
        {
            $lmdata['lm_report'] ="yes";
        }

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0)
        {
            $data['guar_rel'] = $relation_executation->result();
        }

        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        if($get_aadhaar_photo != 'n')
        {
            $data['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
            'api_key' => API_KEY,
            'token' => $token
        )));

        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType == 3){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $backup = $output;
        $output = json_decode($output);

        foreach($output->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        $rejected_data = $this->RelinquishmentCommonModel->getRejectModal(RELINQUISHMENT_ID);
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
            if($val_bypas->SERVICE_CODE == RELINQUISHMENT_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }
        $data['validation_bypass'] = 0;

        foreach($data['lmnotes'] as $lm_rr)
        {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);
            if($decoded_r)
            {
                foreach($decoded_r as  $lm_rejected_code)
                {
                    if(isset($lm_rejected_code->reject_code))
                    {
                        if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code))
                        {
                            $data['validation_bypass'] = 1;
                        }
                    }
                    else
                    {
                        if(in_array($lm_rejected_code, $const_bypass_arr_code))
                        {
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



        $notice = 0;
        if (in_array($caseDetails->status, ['S', 'G']))
        {
            $notice = 1;
        }


        $data['document']          = $output->documents;
        $data['basic']             = $caseDetails;
        $data['application_no']    = $application_no;
        $data['case_no']           = $case_no;
        $data['applicants_buyers'] = $applicants_buyers;
        $data['applicants_owners'] = $applicants_owners;
        $data['dags']              = $dags;
        $data['proceedings']       = $proceedings;
        $data['dhardocuments']     = $dhardocuments;
        $data['nominee']           = $nominee;
        $data['areaCheck']         = $areaCheck;
        $data['notice']            = $notice;

        $data['_view'] = 'Relinquishment/register_case_details_without_lm_note';
        $this->load->view('layouts/main',$data);

    }



    // generate Notice
    public function relinquishmentApplicationGenerateNotice()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $app         = $this->input->post('appNo');
        $case_no     = $this->utilityclass->decryptJwtCase($app);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('appNo', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('hearingDate', 'Hearing Date', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case='.$case_no);
        }

        $hearingDate = $this->input->post('hearingDate');
        $timestamp   = strtotime($hearingDate);
        if ($timestamp === false)
        {
            $this->session->set_flashdata('error', 'Invalid date format.');
            redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
        }

        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMDG003: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_CIRCLE_OFFICER OR $caseDetails->status != 'W')
        {
            $errors = '#MRLQMDG004: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $application_no    = $caseDetails->applid;
        $applicants_owners = $this->RelinquishmentCommonModel->getAllApplicantOwners($case_no);
        $applicants_buyers = $this->RelinquishmentCommonModel->getAllApplicantBuyers($case_no);
        $dags              = $this->RelinquishmentCommonModel->getSettlementDag($case_no);


        $lmnotes = $this->RelinquishmentCommonModel->getSettlementLraReport($case_no);

        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes))
        {
            $remark_co = "AP Notice";
            $remark_co_text = "Notice Generated";
        }
        else
        {
            $remark_co = $this->input->post('remark_co');
            $remark_co_text = $this->input->post('remark_co_text');
        }

        $get_chitha_owners = $this->RelinquishmentCommonModel->getAllOwnersChitha($case_no);

        $data['basic']               = $caseDetails;
        $data['application_no']      = $application_no;
        $data['case_no']             = $case_no;
        $data['get_buyers']          = $applicants_buyers;
        $data['get_owners']          = $applicants_owners;
        $data['get_chitha_owners']   = $get_chitha_owners;
        $data['get_dag_details']     = $dags;
        $data['hearing_date']        = $hearingDate;
        $data['notice_hearing_date'] = $hearingDate;
        $data['remark_co']           = $remark_co;
        $data['remark']              = $remark_co;
        $data['remark_co_text']      = $remark_co_text;
        $data['is_generated']        = false;



        $data['_view'] = 'Relinquishment/notice_generate.php';
        $this->load->view('layouts/main',$data);
    }



    // save Hearing Notice
    public function saveRelinquishmentHearingNotice()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('en_case_no', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('notice_generated_date', 'Hearing Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('htmlstring_text', 'Hearing Date', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentDcController/getAllPendingRelinquishmentCasesDc');
        }

        $dist_code    = trim($this->session->userdata('dist_code'));
        $user_code    = trim($this->session->userdata('user_code'));
        $serviceCode  = RELINQUISHMENT_ID;
        $userDegCode  = trim($this->session->userdata('user_desig_code'));
        $app          = $this->input->post('en_case_no');
        $case_no      = $this->utilityclass->decryptJwtCase($app);
        $hearingDate  = $this->input->post('hearing_date');
        $is_generated = $this->input->post('is_generated');
        $timestamp    = strtotime($hearingDate);
        if ($timestamp === false)
        {
            $this->session->set_flashdata('error', 'Invalid date format.');
            redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
        }

        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMDNG001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($is_generated == 1)
        {
            if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_DEPUTY_COMM OR $caseDetails->status != 'S')
            {
                $errors = '#MRLQMDNG002: You are not Authorized for this process';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }
        }
        else
        {
            if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_CIRCLE_OFFICER OR $caseDetails->status != 'W')
            {
                $errors = '#MRLQMDNG002: You are not Authorized for this process';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }
        }


        $new_case_no = str_replace('/', "-", $case_no);
        if(is_dir(RELINQUISHMENT_NOTICE_PATH)===false)
        {
            mkdir(RELINQUISHMENT_NOTICE_PATH,0777);
        }

        $base_64_file_path    = RELINQUISHMENT_NOTICE_PATH.$new_case_no.".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        // base64 file
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);



        $applicant_buyers = $this->RelinquishmentCommonModel->getAllApplicantBuyers($case_no);
        foreach($applicant_buyers as $buyers)
        {
            $applicant_buyers_json[] = [
                'APPLICANT_ID'         => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME'        => $buyers->pdar_guardian
            ];
        }
        $notice_no = RELINQUISHMENT_NAME."/GN/".date('Y')."/".$serviceCode."/".$caseDetails->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => RELINQUISHMENT_ID,
            'case_registration_date' => $caseDetails->submission_date,
            'applicant_details'      => json_encode($applicant_buyers_json),
            'notice_no'              => $notice_no,
            'notice_link'            => $base_64_file_path,
            'notice_type'            => 'GN',
            'hearing_date'           => $hearingDate
        ];


        if($is_generated == true)
        {
            $this->db->where('case_no', $case_no);
            $this->db->where('notice_type', 'GN');
            $this->db->update('settlement_notice', $insertIntoSettlementNotice);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDNG003: Updation Failed in settlement_notice table');
                $this->session->set_flashdata('error', '#MRLQMDNG003: Failed to generate notice. Kindly contact system administrator');
                redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
            }
            $updateArr = [
                'co_hearing_date'    => $hearingDate,
                'date_update'        => date('Y-m-d h:i:s'),
                'co_app_notice_link' => $base_64_file_path
            ];
            $this->db->where('case_no', $case_no);
            $this->db->where('notice_generated_yn', 'Y');
            $this->db->where('status', 'S');
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDNG004: Updation Failed in settlement_basic table');
                $this->session->set_flashdata('error', '#MRLQMDNG004: Failed to generate notice. Kindly contact system administrator');
                redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
            }
        }
        else
        {
            $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
            if($insertIntoSettlementNotice != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDNG005: Insertion failed in settlement_notice');
                $this->session->set_flashdata('error', '#MRLQMDNG005: Failed to generate notice. Kindly contact system administrator');
                redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
            }


            $updateArr = [
                'co_hearing_date'       => $hearingDate,
                'dc_code'               => $this->session->userdata('user_code'),
                'status'                => 'S',
                'notice_generated_yn'   => 'Y',
                'notice_generated_date' => date('Y-m-d h:i:s'),
                'date_update'           => date('Y-m-d h:i:s'),
                'from_office'           => MB_DEPUTY_COMM,
                'co_app_notice_link'    => $base_64_file_path
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDNG006: Updating Failed in settlement_basic table');
                $this->session->set_flashdata('error', '#MRLQMDNG006: Failed to generate notice. Kindly contact system administrator');
                redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
            }
        }

        $proceeding_id = $this->RelinquishmentCommonModel->getOfflineProceedingId($case_no);
        if($is_generated == true)
        {
            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => $hearingDate,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => 'General notice re-generated',
                'status'               => 'A',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => MB_DEPUTY_COMM,
                'office_to'            => MB_DEPUTY_COMM,
                'task'                 => 'Notice Re-generated by DC'
            ];
        }
        else
        {
            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => $hearingDate,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => 'General notice generated',
                'status'               => 'A',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => MB_DEPUTY_COMM,
                'office_to'            => MB_DEPUTY_COMM,
                'task'                 => 'Notice Generated By DC'
            ];
        }

        $insertProceeding = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRLQMCD004: Insertion failed in settlement_proceeding Case No '.$case_no);
            $this->session->set_flashdata('error', '#MRLQMDNG007: Failed to generate notice. Kindly contact system administrator');
            redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
        }
        if ($this->db->trans_status() == false)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', '#MRLQMDNG008: Failed to generate notice. Kindly contact system administrator');
            redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);

        }
        else
        {

            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file'   => json_decode($htmlstring_text),
                'application_no' => $caseDetails->applid,
                'type'           => 'GN',
                'amount'         => 0,
                'is_full_pay'    => 'N'
            )));
            $result = curl_exec($curl_handle);

            if(trim($result) != 'y')
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', '#MRLQMAPI008: Failed to generate notice. Kindly contact system administrator');
                redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
            }
            else
            {

                $this->db->trans_commit();
                $errors = "Notice Successfully Saved for Application (".$case_no.")";
                $this->session->set_flashdata('success', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }
        }
    }



    // print Notice
    public function printRelinquishmentNotice()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code    = trim($this->session->userdata('dist_code'));
        $user_code    = trim($this->session->userdata('user_code'));
        $serviceCode  = RELINQUISHMENT_ID;
        $userDegCode  = trim($this->session->userdata('user_desig_code'));
        $app          = $this->input->get('case');
        $case_no      = $this->utilityclass->decryptJwtCase($app);

        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQDP001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != $userDegCode)
        {
            $errors = '#MRLQDP002: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $path = $this->RelinquishmentCommonModel->downloadNotice($caseDetails->co_app_notice_link);
        if($path == false)
        {
            echo 'No data found!';
            return;
        }
        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);

        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];


        $data['_view'] = 'Relinquishment/notice_print.php';
        $this->load->view('layouts/main',$data);

    }



    // Re generate Notice
    public function relinquishmentApplicationReGenerateNotice()
    {

        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('appNoReGenerate', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('hearingDateRe', 'Hearing Date', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $dist_code    = trim($this->session->userdata('dist_code'));
        $user_code    = trim($this->session->userdata('user_code'));
        $serviceCode  = RELINQUISHMENT_ID;
        $userDegCode  = trim($this->session->userdata('user_desig_code'));
        $app          = $this->input->post('appNoReGenerate');
        $case_no      = $this->utilityclass->decryptJwtCase($app);
        $hearingDate  = $this->input->post('hearingDateRe');
        $timestamp    = strtotime($hearingDate);
        if ($timestamp === false)
        {
            $this->session->set_flashdata('error', 'Invalid date format.');
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMNR001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_DEPUTY_COMM OR $caseDetails->status != 'S')
        {
            $errors = '#MRLQMNR002: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }


        $application_no    = $caseDetails->applid;
        $applicants_owners = $this->RelinquishmentCommonModel->getAllApplicantOwners($case_no);
        $applicants_buyers = $this->RelinquishmentCommonModel->getAllApplicantBuyers($case_no);
        $dags              = $this->RelinquishmentCommonModel->getSettlementDag($case_no);


        $lmnotes = $this->RelinquishmentCommonModel->getSettlementLraReport($case_no);

        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes))
        {
            $remark_co = "AP Notice";
            $remark_co_text = "Notice Generated";
        }
        else
        {
            $remark_co = $this->input->post('remark_co');
            $remark_co_text = $this->input->post('remark_co_text');
        }

        $get_chitha_owners = $this->RelinquishmentCommonModel->getAllOwnersChitha($case_no);

        $data['basic']               = $caseDetails;
        $data['application_no']      = $application_no;
        $data['case_no']             = $case_no;
        $data['get_buyers']          = $applicants_buyers;
        $data['get_owners']          = $applicants_owners;
        $data['get_chitha_owners']   = $get_chitha_owners;
        $data['get_dag_details']     = $dags;
        $data['hearing_date']        = $hearingDate;
        $data['notice_hearing_date'] = $hearingDate;
        $data['remark_co']           = $remark_co;
        $data['remark']              = $remark_co;
        $data['remark_co_text']      = $remark_co_text;
        $data['is_generated']        = true;

        $data['_view'] = 'Relinquishment/notice_generate.php';
        $this->load->view('layouts/main',$data);

    }



    // Forward to final order
    public function relinquishmentApplicationForwardToFinalOrder()
    {

        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('appNoForward', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('finalRemarks', 'Hearing Remarks', 'trim|required|max_length[2000]|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $dist_code    = trim($this->session->userdata('dist_code'));
        $user_code    = trim($this->session->userdata('user_code'));
        $serviceCode  = RELINQUISHMENT_ID;
        $userDegCode  = trim($this->session->userdata('user_desig_code'));
        $app          = $this->input->post('appNoForward');
        $case_no      = $this->utilityclass->decryptJwtCase($app);
        $finalRemarks = $this->input->post('finalRemarks');

        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMSF001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_DEPUTY_COMM OR $caseDetails->status != 'S')
        {
            $errors = '#MRLQMSF002: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }


        // validation for file type and file size
        $name = $_FILES['signedNotice']['name'];
        $size = $_FILES['signedNotice']['size'];
        $exp  = '';
        if($name != NULL)
        {
            $mime = mime_content_type($_FILES['signedNotice']['tmp_name']);
            $exp  = explode("/",$mime);
            $ext  = $exp[1];

            if($ext == NULL)
            {
                $this->session->set_flashdata('error', "#MRLQMSF003:  Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case=',$case_no);

            }
            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
            {
                $this->session->set_flashdata('error', "#MRLQMSF004:  Attachment type must be " . UPLOAD_TYPE_VALIDATION_SHOW);
                redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case=',$case_no);
            }
            if($size > UPLOAD_MAX_SIZE)
            {
                $this->session->set_flashdata('error', "MRLQMSF005:  Attachment size is more then " . UPLOAD_MAX_SIZE_VALIDATION_SHOW);
                redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case=',$case_no);
            }
        }



        $this->db->trans_begin();

        // save attachment
        $_FILES['file']['name']     = $_FILES['signedNotice']['name'];
        $_FILES['file']['type']     = $_FILES['signedNotice']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['signedNotice']['tmp_name'];
        $_FILES['file']['error']    = $_FILES['signedNotice']['error'];
        $_FILES['file']['size']     = $_FILES['signedNotice']['size'];

        $mime = mime_content_type($_FILES['signedNotice']['tmp_name']);
        $exp  = explode("/",$mime);
        $onlyExtension  = $exp[1];

        $fileRename = 'hearing_document_'.$this->UUID4() . '.' . $onlyExtension;

        $config['upload_path']   = UPLOAD_DIR;
        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $config['max_size']      = UPLOAD_MAX_SIZE;;
        $config['file_name']     = $fileRename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file'))
        {
            $document = array(
                'case_no'         => $case_no,
                'file_name'       => 'hearing_document',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => $fileRename,
                'file_type'       => $_FILES['file']['type'],
                'file_path'       => UPLOAD_DIR . $fileRename,
                'date_entry'      => date('Y-m-d h:i:s'),
                'mut_type'        => RELINQUISHMENT_ID,

            );


            // save data in attachment file
            $addMoreDocQuery = $this->db->insert('supportive_document',$document);
            if($addMoreDocQuery != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMSF006: Insertion failed in supportive document RTPS Case No '.$case_no);
                $this->session->set_flashdata('error', "MRLQMSF006:  Failed to forward the case for Case No " .$case_no);
                redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case=',$case_no);
            }
            else
            {

                $updateArr = [
                    'status'      => 'G',
                    'date_update' => date('Y-m-d h:i:s')
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('status', 'S');
                $this->db->update('settlement_basic', $updateArr);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRLQMSF008: Updating Failed in settlement_basic table');
                    $this->session->set_flashdata('error', '#MRLQMSF008: Failed to forward the case. Kindly contact system administrator');
                    redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
                }
                $proceeding_id = $this->RelinquishmentCommonModel->getOfflineProceedingId($case_no);
                $insertArr = [
                    'case_no'              => $case_no,
                    'proceeding_id'        => $proceeding_id,
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => $finalRemarks,
                    'status'               => 'G',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => MB_DEPUTY_COMM,
                    'office_to'            => MB_DEPUTY_COMM,
                    'task'                 => 'Application Forwarded for Final Order'
                ];

                $insertProceeding = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRLQMSF009: Insertion failed in settlement_proceeding Case No '.$case_no);
                    $this->session->set_flashdata('error', '#MRLQMSF009: Failed to forward the case. Kindly contact system administrator');
                    redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);
                }
                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', '#MRLQMSF0010: Failed to forward the case. Kindly contact system administrator');
                    redirect(base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case=' . $case_no);

                }
                else
                {
                    $this->db->trans_commit();
                    $errors = "Forward for Final Order successfully completed for Application (".$case_no.")";
                    $this->session->set_flashdata('success', $errors);
                    redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
                }
            }
        }
        else
        {
            $this->db->trans_rollback();
            log_message('error', '#MRLQMSF007: Insertion failed in supportive document RTPS Case No '.$case_no);
            $this->session->set_flashdata('error', "MRLQMSF007:  Failed to forward the case for Case No " .$case_no);
            redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case=',$case_no);
        }

    }



    // get all final Order pending  cases for DC
    public function getAllPendingForFinalOrderRelinquishmentCasesDc()
    {

        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $pendingCases = 0;
        if($userDegCode ==  MB_DEPUTY_COMM)
        {
            $pendingCases = $this->RelinquishmentCommonModel->countFinalOrderRelinquishmentCasesDc($dist_code,$serviceCode);
        }

        $data['pendingCaseCount'] = $pendingCases;

        $data['_view'] = 'Relinquishment/final_order_pending_cases_list_dc';
        $this->load->view('layouts/main', $data);

    }


    // pagination of final Order pending for DC
    public function getAllPendingForFinalOrderRelinquishmentPaginationAPI()
    {
        $this->checkAccessRelinquishmentOnlyDc();
        $this->checkAccessRelinquishment();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
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

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('settlement_basic.service_code', $service);
        $this->db->where('settlement_basic.dist_code', $dist_code);
        $this->db->where('settlement_basic.status', 'G');
        $this->db->where('notice_generated_yn','Y');
        $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {

            $result = $query->result();
            $i=1;

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


            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->where('settlement_basic.service_code', $service);
            $this->db->where('settlement_basic.dist_code', $dist_code);
            $this->db->where('settlement_basic.status', 'G');
            $this->db->where('notice_generated_yn','Y');
            $this->db->where_in('settlement_basic.pending_officer', MB_DEPUTY_COMM);
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows)
            {
                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date('d-M-Y', strtotime($rows->submission_date)),


                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn btn-success" href="'.base_url().'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc/?case='.$rows->case_no.'">Process</a>',

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


    // application process for final order
    public function relinquishmentApplicationFinalOrderPass()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentOnlyDc();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $app         = $this->input->post('appNo');
        $case_no     = $this->utilityclass->decryptJwtCase($app);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('appNo', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|max_length[2000]|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentDcController/getRelinquishmentApplicationDetailsDc?case='.$case_no);
        }

        $this->db->trans_begin();

        $remarks   = trim($this->input->post('remarks'));
        $caseQuery = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$case_no);

        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQMD003: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->from_office != MB_DEPUTY_COMM OR $caseDetails->status != 'G')
        {
            $errors = '#MRLQMD004: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }


        $location = [
            'dist_code'          => $caseDetails->dist_code,
            'subdiv_code'        => $caseDetails->subdiv_code,
            'cir_code'           => $caseDetails->cir_code,
            'mouza_pargona_code' => $caseDetails->mouza_pargona_code,
            'lot_no'             => $caseDetails->lot_no,
            'vill_townprt_code'  => $caseDetails->vill_townprt_code,
            'service_code'       => RELINQUISHMENT_ID,
            'case_no'            => $caseDetails->case_no,
            'applid'             => $caseDetails->applid,
            'petition_no'        => $caseDetails->petition_no,
            'status'             => $caseDetails->status,
        ];

        $applicants_owners = $this->RelinquishmentCommonModel->getAllApplicantOwners($case_no);
        $dagList           = $this->RelinquishmentCommonModel->getSettlementDag($case_no);

        $dags = [];
        foreach ($dagList as $dag)
        {
            $pattadar = [];

            foreach ($applicants_owners as $own)
            {
                if ($own->dag_no == $dag->dag_no)
                {
                    $pattadar[] = [
                        'pdar_id'           => $own->pdar_id,
                        'pdar_cron_no'      => $own->pdar_cron_no,
                        'pdar_name'         => $own->pdar_name,
                        'pdar_guardian'     => $own->pdar_guardian,
                        'inplace_alongwith' => $own->inplace_alongwith,
                        'pdar_type'         => $own->pdar_type,
                    ];
                }
            }

            $dags[] = [
                'dag_no'           => $dag->dag_no,
                'patta_no'         => $dag->patta_no,
                'patta_type_code'  => $dag->patta_type_code,
                'land_type'        => $dag->land_type,
                's_dag_area_b'     => $dag->s_dag_area_b,
                's_dag_area_k'     => $dag->s_dag_area_k,
                's_dag_area_lc'    => $dag->s_dag_area_lc,
                's_dag_area_g'     => $dag->s_dag_area_g,
                'dag_area_b'       => $dag->dag_area_b,
                'dag_area_k'       => $dag->dag_area_k,
                'dag_area_lc'      => $dag->dag_area_lc,
                'dag_area_g'       => $dag->dag_area_g,
                'is_urban'         => $dag->is_urban,
                'pattadars'        => $pattadar,
            ];
        }


        $data['case_no']  = $caseDetails->case_no;
        $data['remarks']  = $remarks;
        $data['location'] = $location;
        $data['dags']     = $dags;

        $this->load->model('ChithaUpdateModel');
        $responseChitha  = $this->ChithaUpdateModel->RelinqishmentChithaUpdate($data);
        $chithaUpdate = json_decode($responseChitha, true);


        if($chithaUpdate['status'] == 1)
        {
            $application_no = $caseDetails->applid;
            $basicUpdate = array(
                'status'          => 'F',
                'from_office'     => null,
                'pending_officer' => null,
                'pending_office'  => null,
                'dc_code'         => $user_code,
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('service_code', $serviceCode);
            $this->db->where('case_no', $case_no);
            $this->db->where('status', 'G');
            $this->db->update('settlement_basic', $basicUpdate);
            if ($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDF001: Update failed in settlement_basic RTPS Case No '.$case_no);
                $errors = '#MRLQMDF001: Final order process cannot be done for Application no ( ' . $case_no . ' )! Please contact the administration.';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }

            $proceeding_id = $this->RelinquishmentCommonModel->getOfflineProceedingId($case_no);

            $insPetProceed = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => $remarks,
                'status'               => 'F',
                'user_code'            => $user_code,
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => MB_DEPUTY_COMM,
                'office_to'            => MB_DEPUTY_COMM,
                'task'                 => 'Final Order Passed'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if ($insertProceeding != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRLQMDF002: Insertion failed in settlement_proceeding Case No '.$case_no);
                $errors = "#MRLQMDF002: Final order process cannot be done for Application no ( ' . $case_no . ' )! Please contact the administration.";
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }
            if ($this->db->trans_status() == false)
            {
                $this->db->trans_rollback();
                $errors = "#MRLQMDF003: Final order process cannot be done for Application no ( ' . $case_no . ' )! Please contact the administration.";
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');

            }
            else
            {
                //////////////POST To basundhara/////////////////////
                $rmk    = 'Final Order Passed';
                $status = 'F';
                $task   = MB_DEPUTY_COMM;
                $pen    = '';
                $case   = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                if (trim($rtps_status) !="y")
                {
                    $this->db->trans_rollback();
                    $errors = "#MRLQMDF004: Final order process cannot be done for Application no ( ' . $case_no . ' )! Please contact the administration.";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
                }
                else
                {
                    $this->db->trans_commit();
                    $errors = "The final order has been passed successfully for Application (".$case_no.")";
                    $this->session->set_flashdata('success', $errors);
                    redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
                }
            }
        }
        else
        {
            $this->db->trans_rollback();
            log_message('error', '#MRLQMDC001: Final order process cannot be done for Application no ( ' . $case_no . ' ) ' . $chithaUpdate['msg']);
            $errors = '#MRLQMDC001: Final order process cannot be done for Application no ( ' . $case_no . ' )! Please contact the administration.';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

    }





}