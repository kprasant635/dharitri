<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ChithaReportKamrup extends CI_Controller {

    public function index() {
        $this->load->helper('html');
        $this->load->view('header');
        $this->load->view('chitha_report_kamrup/cithareportkamrup1');
        $this->load->view('footer');
    }
}