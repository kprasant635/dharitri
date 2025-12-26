<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MisReportControllerDemo extends CI_Controller {

    public function index() {
        $this->load->model('mutation/mutationmodel');
        $this->load->model('demo/DemoModel');
        $this->load->view('../views/header');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data['stats'] = $this->DemoModel->getTeaEstateLand($_POST);
            $data['landlocation'] = $this->DemoModel->getTeaEstateLand($_POST);
            $this->load->view('misreport/saveteaestatereport',$data);
        } else {
            $this->load->model('mutation/mutationmodel');
            $data = $this->mutationmodel->getDistricts();
            $district['names'] = $data;
            $this->load->view('misreport/misreportTeaEstate',$district);
        }
    }
}
