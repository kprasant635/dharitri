<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RevenueModificationController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function step1(){
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/lm_mutation');
        $this->load->view('../views/footer');
    }
    
}
