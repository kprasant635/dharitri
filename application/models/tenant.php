<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tenant extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function addTenant() {
        //var_dump($_POST);
		$basic_array=$this->session->userdata('tenants');
		$tenant=$this->input->post();
		$name=array_merge($basic_array,$tenant);
		if (!$this->session->userdata('mut_petitioner')) {
            $this->session->set_userdata('mut_petitioner', array());
            $mut_petitioner = $this->session->userdata('mut_petitioner');
            $mut_petitioner[] = $name;
            $this->session->set_userdata('mut_petitioner',$mut_petitioner);
        } else {
            $mut_petitioner = $this->session->userdata('mut_petitioner');
            $mut_petitioner[] = $name;
            $this->session->set_userdata('mut_petitioner', $mut_petitioner);
        }
		//var_dump($mut_petitioner);
    }
	public function basicDetails() {
        //var_dump($this->session->all_userdata());
		$basic_array=$this->session->userdata('tenants');
		$bd=$this->input->post();
		$basic=array_merge($basic_array,$bd);
		if (!$this->session->userdata('tenant_basic')) {
            $this->session->set_userdata('tenant_basic', array());
            $tenant_basic = $this->session->userdata('tenant_basic');
            $tenant_basic[] = $basic;
            $this->session->set_userdata('tenant_basic',$tenant_basic);
        } else {
            $tenant_basic = $this->session->userdata('tenant_basic');
            $tenant_basic[] = $basic;
            $this->session->set_userdata('tenant_basic', $tenant_basic);
        }
		//var_dump($tenant_basic);
    }
}
