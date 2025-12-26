<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class JSException extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
	
	public function index(){
		echo "No JS";
	}

   public function showError(){
           $this->load->view('header');
	   $this->load->view('nojs');
   }

}
