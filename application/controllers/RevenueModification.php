<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RevenueModification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));

        $this->load->library('form_validation');
    }

    public function index() {
        $this->session->unset_userdata('petitioner');
        $this->session->unset_userdata('dags');
        $this->session->unset_userdata('pattadar');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $location = array(
                'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no, 'vill_code' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/RevenueModification/showLandClasses");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/common/bar');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['mouzas'] = $mouzas;
            ////var_dump($this->session->all_userdata());
            //$this->load->view('menu/menu4');
            $this->load->view('../views/RevenueModification/show_location', $district);
            $this->load->view('../views/footer');
        }
    }

    public function showLandClasses() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $landClassCode = $this->utilityclass->getLandClasses();
            $data['landclasses'] = $landClassCode;

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/common/bar');
            $this->load->view('../views/RevenueModification/show_mod_form', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $circle_code = $this->session->userdata('circle_code');
            $mouza_pargona_code = $this->session->userdata('mouza_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprtcode = $this->session->userdata('vill_code');
            $landClassCode = $this->input->post('landclass');
            $revenue = $this->input->post('revenue');
            
            $dags= $this->getDags($landClassCode);
            if(sizeof($dags)<=0){
                echo "This Village Does not have land with land class code $landClassCode ";
                return;
            }
            foreach($dags as $key=>$value){
                $bigha = $value->dag_area_b;
                $katha = $value->dag_area_k;
                $lessa = $value->dag_area_lc;
                $revenueKatha = $revenue/5;
                $revenueLessa = $revenueKatha/20;
                $dag_revenue = $bigha*$revenue + $katha*$revenueKatha + $lessa*$revenueLessa;
                //echo $revenue;
                //echo $value->dag_no ."<br>";
                echo $bigha."," . $katha.",".$lessa.",".$dag_revenue."<br>";
            //     $this->db->query("update chitha_basic set dag_revenue=$dag_revenue, dag_local_tax=$dag_revenue/4 WHERE dist_code = ?"
            //    . " and subdiv_code=? and land_class_code=? and  cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",array($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$landClassCode, $this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'),$this->session->userdata('vill_code')));

            $table = 'chitha_basic';
            $dag_revenue = floatval($dag_revenue); // Ensure it's numeric
            $dag_local_tax = $dag_revenue / 4;
            $params = [
                'dag_revenue'   => $dag_revenue,
                'dag_local_tax' => $dag_local_tax,
            ];
            $where = [
                'dist_code'          => $this->session->userdata('dist_code'),
                'subdiv_code'        => $this->session->userdata('subdiv_code'),
                'land_class_code'    => $landClassCode,
                'cir_code'           => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                'lot_no'             => $this->session->userdata('lot_no'),
                'vill_townprt_code'  => $this->session->userdata('vill_code'),
            ];
            $this->Chitha_basic_model->update_table($table, $params, $where);

            }
           $this->session->set_flashdata('message',"Revenue updated for " . sizeof($dags)." Records");
           redirect(base_url() . "index.php/home/");
        }
    }
    
    public function getDags($code){
       $dbResult = $this->db->query("SELECT dag_no,dag_area_b,dag_area_k,dag_area_lc FROM  chitha_basic WHERE dist_code = ?"
               . " and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and land_class_code=?",array($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'),$this->session->userdata('vill_code'),$code))->result();
       return $dbResult;          ;
    }

}
