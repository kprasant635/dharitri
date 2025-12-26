<?php

class MisReportControllerBondita extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
    }

    public function JamaWasil() {
        $this->load->helper('html');
        $this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
		
		$dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $this->load->view('../views/misreport/JamaWasilBondita', $district);
        $this->load->view('../views/footer');
    }

    public function saveJamaWasil() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');


        $this->load->model('misreport/MisModel');
        //$g_lands = array('0209', '0212', '0213', '0214', '0215', '0218', '0219');
        //print_r($g_land);

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);
       // print_r($maindata);

        $this->load->model('misreport/MisReportModelBondita');
        $Jama_patta_info['patta_numbr'] = $this->MisReportModelBondita->getPattano($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        
        
        // $Jama_dag_info['dag_info']=$this->MisReportModelBondita->getdagno($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code,$patta_no);
         
         
        //print_r($Jama_patta_info);
        
       // $mainarraywitlocationAndpattano['MAIN'] = array_merge($maindata, $Jama_patta_info);
        //$Total_patta_numbers = count($Jama_patta_info['patta_numbr']);
        //print_r($Jama_patta_info['patta_numbr']);
     
        
        /*for ($i = '0'; $i < $Total_patta_numbers; $i++) {
            
        } */
//        frommmmmmmmmmmm
//        foreach($Jama_patta_info['patta_numbr'] as $patta_no) {
//            //print $patta_no->ptno . '<br/>';
//           $patta_no = $patta_no->ptno;
//           
//           $Jama_pattadar_info['pdarname']= $this->MisReportModelBondita->getPattadarName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code,$patta_no);
//           
         //  $Jama_dag_info['dag_info']=$this->MisReportModelBondita->getdagno($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code,$patta_no);
//           //print_r($Jama_pattadar_info['pdarname']).'<br>';
//           //$number_of_pattadars=count($Jama_pattadar_info['pdarname']);
//           //print_r($Jama_dag_info['dag_info']);
//           
//           
//        }end
        
        $Mainjamawasil = array_merge($maindata,$Jama_patta_info);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/misreport/saveJamaWasil', $Mainjamawasil );
        $this->load->view('../views/footer');
        // print_r($Jama_patta_info['patta_numbr'] );
    }
      

}
