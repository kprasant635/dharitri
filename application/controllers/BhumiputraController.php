<?php

class BhumiputraController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('UtilsModel');
        $this->load->model('BhumiputraModel');
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
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    // case search page
    public function loadViewPage()
    {
        $data['_view'] = 'list_of_bhumiputra';
        $this->load->view('layouts/main', $data);
    }

    public function getBhumiputraPagination()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {

            $this->db->where("a.case_no like '%".strtoupper($searchByCol_0)."%' OR a.applid like '%".strtoupper($searchByCol_0)."%'");
        }
        if (!empty($searchByCol_1))
        {
            $this->db->like('a.bhumiputra_certificate_no', strtoupper($searchByCol_1));
        }
        $this->db->limit($length, $start);

        if($user_desig_code == 'CO')
        {
            $this->db->where('a.pending_officer', $user_desig_code);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        }

        $this->db->where('a.bhumiputra_confirmation != ', '0');
        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows)
            {

                $button = '<button type="button" class="lmreportmut btn-sm btn btn-primary" onclick="getBhumiApi(\''.$rows->case_no.'\')">View Status</button>';

                $dist_name = $this->utilityclass->getDistrictName($rows->dist_code);
                $cir_name  = $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code);
                $mouza_name  = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code);
                $lot_name  = $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);
                $vill_name  = $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code);

                $location = $dist_name.'/'.$cir_name.' / '.$lot_name.' / '.$vill_name;

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span><br><span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->bhumiputra_certificate_no . '</strong></span>',
                    $location,
                    $button
                );
            }

            if($user_desig_code == 'CO')
            {
                $this->db->where('a.pending_officer', $user_desig_code);
                $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
                $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            }
            $this->db->where('a.bhumiputra_confirmation != ', '0');

            $total_records = $this->db->count_all_results('settlement_basic a');
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


    public function getBhumiputraStatusApi()
    {
        $json    = null;
        $case_no = $this->input->post('case_no');
        $appl_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $query = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?",
            array($case_no));

        if($query->num_rows() <= 0)
        {
            log_message('error', "No data found in settlement_basic for ceritificate/ack no $case_no");
            $json = [
                'responseType' => '3',
                'message'      => "Bhumiputra data not available for ceritificate/ack no $case_no",
            ];
            echo json_encode($json);
            return false;
        }
        $res = $query->row();
        $bhumi_no = $res->bhumiputra_certificate_no;

        $postRequest = array(
            'ackNo'   => $bhumi_no
        );


        // ===============================================

        $bhumiputra_status_url = RTPS_API_LINK."getBhumiputraStatus" ;

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $bhumiputra_status_url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $output = curl_exec($cURL);

        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        // var_dump($httpcode);die;
        curl_close($cURL);
        if($httpcode != 200)
        {
            log_message('error', "Unable to get bhumiputra status. Api call failed for for ceritificate/ack no $bhumi_no");
            $json = [
                'responseType' => '3',
                'message'      => "Unable to get bhumiputra status for ceritificate/ack no $bhumi_no",
            ];
            return false;
        }
        $output = json_decode($output);

        $bhumi_status    = isset($output->status) ? $output->status : "NA";
        $bhumi_applicant = isset($output->applicantName) ? $output->applicantName : "NA";
        $bhumi_caste     = isset($output->caste) ? $output->caste : "NA";

        log_message('error', 'BHUMIPUTRA_STATUS_AFTER_API_CALL: ' . json_encode($output));

        // ===============================================


        // $bhumi_status    = 'Pending';
        // $bhumi_applicant = 'Hoi aru kunuba';
        // $bhumi_caste     = "Gen";


        //check if data already available in bhumiputra_status
        $query = $this->db->query("SELECT bhumi_status FROM bhumiputra_status 
                    WHERE trim(cert_ack_no)=? AND case_no=?", array($bhumi_no, $res->case_no));
        // echo $this->db->last_query();

        if($query->num_rows() != 0)
        {
            //update bhumiputra_status 
            $updateBhumi = $this->db->query("UPDATE bhumiputra_status SET bhumi_status=? 
                                WHERE trim(cert_ack_no)=? AND case_no=?",
                array($bhumi_status, $bhumi_no, $case_no));

            if($this->db->affected_rows() != 1)
            {
                log_message('error', "Updation failed in for ceritificate/ack no $bhumi_no");
                $json = [
                    'responseType' => '3',
                    'message'      => "Bhumiputra data not available for ceritificate/ack no $bhumi_no",
                ];
                echo json_encode($json);
                return false;
            }
        }

        else
        {
            $insert = [
                'application_no'  => $res->applid,
                'case_no'         => $res->case_no,
                'cert_ack_no'     => $bhumi_no,
                'bhumi_status'    => $bhumi_status,
                'bhumi_applicant' => $bhumi_applicant,
                'bhumi_caste'     => $bhumi_caste,
                'user_code'       => $this->session->userdata('user_code'),
                'ip'              => $_SERVER['SERVER_ADDR'],
                'created_at'      => date('Y-m-d h:i:s'),
                'updated_at'      => date('Y-m-d h:i:s'),
            ];
            $insertData = $this->db->insert('bhumiputra_status', $insert);
            if($insertData != 1)
            {
                log_message('error', "Insertion failed in for ceritificate/ack no $bhumi_no");
                $json = [
                    'responseType' => '3',
                    'message'      => "Bhumiputra data not available for ceritificate/ack no $bhumi_no",
                ];
                echo json_encode($json);
                return false;
            }
        }

        log_message('error', "Successfully stored in bhumiputra_status for ceritificate/ack no $bhumi_no");
        $json = [
            'responseType'    => '1',
            'bhumi_status'    => $bhumi_status,
            'bhumi_applicant' => $bhumi_applicant,
            'bhumi_caste'     => $bhumi_caste,
            'message'         => "Certificate/ack no: $bhumi_no saved successfully. To view the status again just click on list of bhumitra Status.",
        ];
        echo json_encode($json);
        return false;

    }

    public function loadFetchedBhuhmiputraData()
    {
        $data['_view'] = 'list_of_fetched_bhumiputra_data';
        $this->load->view('layouts/main', $data);
    }

    public function getBhumiputraInsertedData()
    {
        $user_code = $this->session->userdata('user_code');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {

            $this->db->where("a.case_no like '%".strtoupper($searchByCol_0)."%' OR a.application_no like '%".strtoupper($searchByCol_0)."%'");
        }
        if (!empty($searchByCol_1))
        {
            $this->db->like('a.cert_ack_no', strtoupper($searchByCol_1));
        }
        $this->db->limit($length, $start);

        if($user_code == 'CO')
        {
            $this->db->where('a.user_code', $user_code);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        }

        $this->db->from('bhumiputra_status a');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows)
            {
                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span><br><span style= font-size:14px;><strong>' . $rows->application_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->cert_ack_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->bhumi_applicant . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->bhumi_caste . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->bhumi_status . '</strong></span>'
                );
            }

            if($user_code == 'CO')
            {
                $this->db->where('a.user_code', $user_code);
                $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
                $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            }

            $total_records = $this->db->count_all_results('bhumiputra_status a');
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


}
