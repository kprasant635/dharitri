<?php

class AuditController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('basundhara/basundharamodel');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
    }

    public function auditNotWhitelistedParam(){
        // $session_data = $this->session->userdata('audit_notwhitelist_param_err');
        $session_data = $_SESSION['audit_notwhitelist_param_err'];
        $data['error_code'] = $session_data['error_code'];
        $data['not_whitelisted_params'] = $session_data['not_whitelisted_params'];
        $data['_view'] = 'audit_validation_exception/audit_validation_exception';
        $this->load->view('layouts/main', $data);
    }
}