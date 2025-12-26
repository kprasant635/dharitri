<?php

/*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

class ADCCaseTransfer extends CI_Controller
{

    public $user_code;
    public $base_query;
    public $base_query1;
    public $db;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mutation/cofieldmutationmodel');
        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('TransactionModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('jamabandi/jamabandiAutoUpdateModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('ADCCaseTransferModel');

        if (! $this->input->is_ajax_request()) {
            //$this->load->view('../views/header');
        }
        if (ENABLED_BLOCKCHAIN == 1) {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }

        if (ESCALATION_ENABLE == 1) {
            $this->load->model('AutoEscalationmodel');
            $this->load->model('Escalationmodel');
        }

        if (MULTIGENERATION_ACTIVE == 1) {
            $this->load->model('ChithaUpdateForMutationModel');
        }

        $location    = $this->utilityclass->getLocationFromSession();
        $dist_code   = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code    = $location['cir_code'];
        $db          = $this->session->userdata('db');

        $year_no           = year_no;
        $this->base_query  = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
        $this->base_query1 = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
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
        }
    }

    public function index()
    {
        // Fetch services from the model
        $services         = $this->ADCCaseTransferModel->get_services();
        $data['services'] = $services;

        $adcs = $this->ADCCaseTransferModel->get_adc_details();

        // print_r($adcs);
        // exit;

        // if ($adcs == null || $adcs == "" || empty($adcs)) {
        //     $this->session->set_flashdata('message', "You are not authorized to access this page.");
        //     redirect(base_url() . "index.php/home");
        //     exit;
        // }

        foreach ($adcs as $key => $adc) {
            $adc->selected_adc_name = $this->utilityclass->getSelectedADCName($adc->dist_code, $adc->user_code)->username;
        }
        $data['adcs'] = $adcs;

        $get_disbaled_adc_details = $this->ADCCaseTransferModel->get_disbaled_adc_details();
        foreach ($get_disbaled_adc_details as $key => $adc) {
            $adc->selected_adc_name = $this->utilityclass->getSelectedADCName($adc->dist_code, $adc->user_code)->username;
        }
        $data['disbaled_adc'] = $get_disbaled_adc_details;

        // print_r($data['adcs']);exit;
        // Load the view with the data
        $data['_view'] = 'transfer/transfer_adc_v2';
        $this->load->view('layouts/main', $data);
    }

    public function transferCase()
    {
        // 1. Get the POST data
        $service_code_name = $_POST['service_code_name'];
        $from_officer      = $_POST['from_officer'];
        $officer_to        = $_POST['officer_to'];
        $district_code     = $_POST['district']; // Optional, used if needed in your validation

        // 2. Validate that the required data is provided
        if (empty($service_code_name) || empty($from_officer) || empty($officer_to) || empty($district_code)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            return;
        }

        $this->ADCCaseTransferModel->transferCase($service_code_name, $from_officer, $officer_to, $district_code); // updateCase
    }

}
