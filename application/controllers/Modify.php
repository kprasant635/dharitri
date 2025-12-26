<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Modify extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));

        $this->load->library('form_validation');
    }

    public function index() {
		$db=  $this->session->userdata('db');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $this->input->post('action');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $lot_no = $this->input->post('lot_no');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $vill_townprt_code = $this->input->post('vill_code');
            $patta_no = trim($this->input->post('patta_no'));
            $dag_no = $this->input->post('dag_no');
            $patta_type = $this->input->post('patta_type_code');
            $locationData = array(
                'vill_code' => $vill_townprt_code,
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('circle_code'),
                'lot_no' => $this->input->post('lot_no'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'patta_no' => $patta_no,
                'dag_no' => $dag_no,
                'patta_type_code' => $patta_type
            );
            $this->session->set_userdata($locationData);
            if ($action == 1) {
                $this->addPattadar();
            } else if ($action == 2) {
                $this->deletePattadar();
            }
        } else {
            $this->load->helper('html');
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->session->unset_userdata('appdet');
            $this->session->unset_userdata('patdet');
            $this->session->unset_userdata('fmb');

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $this->session->set_userdata(array('end' => false));
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['mouzas'] = $mouzas;
            $district['type'] = $this->db->query("select * from    patta_code")->result();

            $this->load->view('../views/modification/select_location', $district);
            $this->load->view('../views/footer');
        }
    }

    public function selectLocation() {
        
    }

    public function addPattadar() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type_code');
        //$dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $dag_no = $this->session->userdata('dag_no');
        //var_dump($this->session->all_userdata());
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo'  and d.p_flag='0'
            and p.patta_type_code='$pattaType'";
       
        $data['pattadars'] = $this->db->query($q)->result();
     
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/modification/addpattadar',$data);
        $this->load->view('../views/footer');
    }

    public function deletePattadar() {
        
    }

    public function changeName() {
        
    }

}
