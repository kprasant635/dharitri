<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AppealsDc extends CI_Controller {

    public function index() {
		  $db=  $this->session->userdata('db');
    	$this->load->helper('html');
        $this->load->view('../views/header');
        $query = "select * from    appeals where order_passed is null";
        $data = $this->db->query($query)->result();
        $this->load->view('../views/footer');
        $details['data']  = $data;
        $this->load->view('../views/AppealsDc/index',$details);
        
    }

    public function proceeding1() {
		  $db=  $this->session->userdata('db');
        	if ($this->input->server('REQUEST_METHOD') == 'POST') {
        	}else{
        		$petitionQuery = "select * from    appeals where case_no=?";
        		$this->db->query($petitionQuery,array($this->input->get('case_no')));

        		$query = "select * from    appeals,appeal_petitioner where appeals.id = appeal_petitioner.appeals_id and appeal_petitioner.isFirst=1";
        		$fp = $this->db->query($query)->result();
           		$details['fp'] = $fp;
				
				$query = "select * from    appeals,appeal_petitioner where appeals.id = appeal_petitioner.appeals_id and appeal_petitioner.isSecond=1";
        		$sp = $this->db->query($query)->result();
           		$details['fp'] = $sp;
			
				$query = "select * from    appeals,appeal_petitioner where appeals.id = appeal_petitioner.appeals_id and appeal_petitioner.isOther=1";
        		$op = $this->db->query($query)->result();
           		$details['op'] = $op;

            	$details['case_no'] = $this->input->get('case_no');
        		$this->load->view('../views/header');
				$this->load->view('../views/common/bar');
            	//$this->load->view('menu/menu4');
           	 	$this->load->view('../views/AppealsDc/proceeding1',$details);
            	$this->load->view('../views/footer');
        	}
            
    }

}
