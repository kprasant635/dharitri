<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DigitalCertificate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('digitalCert/DscModel');
    }

    public function index()
    {
        $data['_view'] = 'dsc/digi_cert_menu';
        $this->load->view('layouts/main', $data);
    }

    public function register_certificate()
    {
        $data['_view'] = 'dsc/indexDsc';
        $this->load->view('layouts/main', $data);
    }

    public function add_update_dsc()
    {
        $this->form_validation->set_rules('cname', 'Name ', 'trim|required|strip_tags');
        $this->form_validation->set_rules('serialNum', 'Serial No.', 'trim|required|strip_tags');
        $this->form_validation->set_rules('validFrom', 'Valid from ', 'trim|required|strip_tags');
        $this->form_validation->set_rules('validTo', 'Valid to ', 'trim|required|strip_tags');
        $this->form_validation->set_rules('cert', 'Certificate ', 'trim|required|strip_tags');
        $this->form_validation->set_rules('sts', 'Status ', 'trim|required|strip_tags');
        $data = $this->input->post();

        if ($this->form_validation->run() == false) {
            $text = str_ireplace('<\/p>', '', validation_errors());
            $text = str_ireplace('<p>', '', $text);
            $text = str_ireplace('</p>', '', $text);
            $result = array('status' => 0, 'msg' => $text, 'error_code' => '#VALIDTN0001');
        } else {
            $result = $this->DscModel->add_update_dsc();
        }
        echo json_encode($result);
    }

    public function signDsc()
    {
        $property_data = $this->input->post('property_data');
        $property_id = $this->input->post('property_id');
        $dag_no = $this->input->post('dag_no');

        $data = array(
            'property_id' => $property_id,
            'property_data' => $property_data,
            'dag_no' => $dag_no,
        );
        // echo "<pre>";
        // var_dump($data);
        $this->load->view('dsc/dscSign', $data);
    }
}
