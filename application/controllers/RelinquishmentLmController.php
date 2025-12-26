<?php
class RelinquishmentLmController extends CI_Controller
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
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
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


    // get all pending cases for LM
    public function getAllPendingRelinquishmentCasesLm()
    {
        $this->checkAccessRelinquishment();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza       = $this->session->userdata('mouza_pargona_code');
        $lot_no      = $this->session->userdata('lot_no');
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $pendingCases = 0;
        if($userDegCode ==  MB_LOT_MONDOL)
        {
            $pendingCases = $this->RelinquishmentCommonModel->countPendingRelinquishmentCasesLm($dist_code,$subdiv_code,$cir_code,$mouza,$lot_no,$serviceCode);
        }

        $data['pendingCaseCount'] = $pendingCases;

        $data['_view'] = 'Relinquishment/pending_cases_list_lm';
        $this->load->view('layouts/main', $data);

    }



    //pagination of first proceeding for LM
    public function firstProceedingPaginationAPILm()
    {
        $this->checkAccessRelinquishment();
        $service     = $this->input->post('service');
        $by_case_no  = $this->input->post('case_no');
        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $mouza_code  = $this->session->userdata('mouza_pargona_code');
        $lot_no      = $this->session->userdata('lot_no');
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
        $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
        $this->db->where('settlement_basic.cir_code', $cir_code);
        $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
        $this->db->where('settlement_basic.lot_no', $lot_no);
        $this->db->where('settlement_basic.status', 'W');
        $this->db->where_in('settlement_basic.from_office', MB_CIRCLE_OFFICER);
        $this->db->where_in('settlement_basic.pending_officer', MB_LOT_MONDOL);
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
            $this->db->where('settlement_basic.subdiv_code', $subDiv_code);
            $this->db->where('settlement_basic.cir_code', $cir_code);
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('settlement_basic.lot_no', $lot_no);
            $this->db->where('settlement_basic.status', 'W');
            $this->db->where_in('settlement_basic.from_office', MB_CIRCLE_OFFICER);
            $this->db->where_in('settlement_basic.pending_officer', MB_LOT_MONDOL);
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

                    '<a class="btn btn-success" href="'.base_url().'index.php/RelinquishmentLmController/getRelinquishmentApplicationDetailsLm/?case='.$rows->case_no.'">Process</a>',

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
    public function getRelinquishmentApplicationDetailsLm()
    {
        $this->checkAccessRelinquishment();
        $case_no     = $this->input->get('case');
        $dist_code   = $this->session->userdata('dist_code');
        $subDiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = $this->session->userdata('mouza_pargona_code');
        $lot_no      = $this->session->userdata('lot_no');
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $caseQuery   = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForLm($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode,$case_no);
        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQML001: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode)
        {
            $errors = '#MRLQML002: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

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

        $data['_view'] = 'Relinquishment/register_case_details_without_lm_note_lm';
        $this->load->view('layouts/main',$data);

    }


    // application forward to CO
    public function relinquishmentApplicationForwardToCo()
    {
        $this->checkAccessRelinquishment();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = $this->session->userdata('cir_code');
        $mouza_code  = $this->session->userdata('mouza_pargona_code');
        $lot_no      = $this->session->userdata('lot_no');
        $user_code   = trim($this->session->userdata('user_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $app         = $this->input->post('appNo');
        $case_no     = $this->utilityclass->decryptJwtCase($app);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('appNo', 'Application', 'trim|required|xss_clean');
        $this->form_validation->set_rules('forwardTo', 'Forwarding officer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required||max_length[2000]|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentLmController/getRelinquishmentApplicationDetailsLm?case='.$case_no);
        }

        $this->db->trans_begin();

        $forwardTo      = trim($this->input->post('forwardTo'));
        $remarks        = trim($this->input->post('remarks'));
        $caseQuery      = $this->RelinquishmentCommonModel->getRelinquishmentCasesByCaseNoForLm($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode,$case_no);

        if($caseQuery->num_rows() != 1)
        {
            $errors = '#MRLQML003: Application not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $caseDetails = $caseQuery->row();
        if($caseDetails->pending_officer != $userDegCode OR $caseDetails->status != 'W')
        {
            $errors = '#MRLQML004: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

        $application_no = $caseDetails->applid;
        $basic = array(
            'status'          => 'W',
            'from_office'     => MB_LOT_MONDOL,
            'pending_officer' => MB_CIRCLE_OFFICER,
            'pending_office'  => MB_CIRCLE_OFFICER,
            'lm_code'         => $user_code,
        );
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $serviceCode);
        $this->db->where('case_no', $case_no);
        $this->db->where('status', 'W');
        $this->db->update('settlement_basic', $basic);
        if ($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRLQML005: Update failed in settlement_basic RTPS Case No '.$case_no);
            $errors = "#MRLQML005: Application unable to Forward ! Kindly contact system administrator";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentLmController/getRelinquishmentApplicationDetailsLm?case='.$case_no);
        }

        $proceeding_id = $this->RelinquishmentCommonModel->getOfflineProceedingId($case_no);
        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $remarks,
            'status'               => 'W',
            'user_code'            => $user_code,
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => MB_LOT_MONDOL,
            'office_to'            => MB_CIRCLE_OFFICER,
            'task'                 => 'Application Forward to '. MB_CIRCLE_OFFICER
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRLQML007: Insertion failed in settlement_proceeding Case No '.$case_no);
            $errors = "#MRLQML007: Application unable to Forward ! Kindly contact system administrator";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentLmController/getRelinquishmentApplicationDetailsLm?case='.$case_no);
        }
        if ($this->db->trans_status() == false)
        {
            $this->db->trans_rollback();
            $errors = "#MRLQML008: Application unable to Forward ! Kindly contact system administrator";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentLmController/getRelinquishmentApplicationDetailsLm?case='.$case_no);

        }
        else
        {
            //////////////POST To basundhara/////////////////////
            $rmk    = 'Case Forwarded to CO';
            $status = 'M';
            $task   = MB_LOT_MONDOL;
            $pen    = MB_CIRCLE_OFFICER;
            $case   = $case_no;
            $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
            $rtps_status = json_decode($rtps_status);
            if (trim($rtps_status) !="y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRLQAPI001: Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            else
            {
                $this->db->trans_commit();
                $errors = "Application (".$case_no.") Successfully Forwarded to CO";
                $this->session->set_flashdata('success', $errors);
                redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
            }
        }
    }





}