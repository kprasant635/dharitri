<?php

class ViewDetails extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ViewDetailsModel');
        $this->load->library('session'); // Load session library
        $this->load->helper(['form', 'url']);
        $this->load->helper('qrcode');

        $this->dbswitch();

        $method = $this->router->fetch_method();

        if (! in_array($method, VERIFICATION_MODULE_METHODS)) {
            if (HOLD_All_MB2_CASES_STATUS == 1) {
                if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }
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

public function index()
{
    $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
    $data['case_no']   = $case_no   = $this->input->get('case_no');
    $decryptBase64     = base64_decode($case_no);
    $data['case_no']   = $case_no   = $decryptBase64;

    // echo $case_no;
    // die;
    $certificateData = $this->ViewDetailsModel->getViewDetailss($dist_code, $case_no);

    // print_r($certificateData);

    if ($certificateData == null) {
        $data['_view'] = 'allotment_certificate/no-certificate';
        $this->load->view('layouts/main', $data);
    } else {
        $certifcatePath = $certificateData->base_64_file;

        if (file_exists($certifcatePath)) {
            // Read Base64 string from file
            $base64Content = file_get_contents($certifcatePath);

            // Decode Base64 to HTML
            $decodedHtml = base64_decode($base64Content);

            // Output as HTML in browser (no saving)
            header('Content-Type: text/html; charset=utf-8');
            echo $decodedHtml;
            exit;
        } else {
            echo "Certificate file not found at: " . $certifcatePath;
        }
    }
}


}
