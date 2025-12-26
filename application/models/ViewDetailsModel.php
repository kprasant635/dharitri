
<?php
    class ViewDetailsModel extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->dbswitch();
            $this->load->model('ChithaUpdateModel');
            $this->load->model('patta/pattamodel');
            $this->load->helper(['form', 'url']);
            $this->load->library('form_validation');
            $this->load->helper('file');
            $this->load->helper('download');
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
        public function getViewDetailss($dist_code, $case_no) {
            // $this->db->where('dist_code', $dist_code);
            $this->db->where('dhar_case_no', $case_no); // correct column
            $query = $this->db->get('allotment_certificates_new');
            return $query->row(); // return single row instead of array
        }


}
