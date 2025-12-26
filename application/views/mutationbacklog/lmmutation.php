<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LMMutation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
    }

    public function index() {
        $this->load->helper('html');
        $this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        $this->load->    view('../views/lmmutation/select_location',$district);
        $this->load->view('../views/footer');
    }
    
    public function mutationType(){
        $this->load->view('../views/header');
        $this->load->view('../views/lmmutation/mutationtype');
        $this->load->view('../views/footer');
    }
    
    public function applicantDetails(){
        $this->load->view('../views/header');
        $this->load->view('../views/lmmutation/applicantdetails');
        $this->load->view('../views/footer');
    }
    
      public function mutationLandArea(){
        $this->load->view('../views/header');
        $this->load->view('../views/lmmutation/mutationlandarea');
        $this->load->view('../views/footer');
    }

    
    public function getSubdivJson($distcode) {
        $data = $this->mutationmodel->getSubDivJSON($distcode);
       
        $json = array();
        foreach($data as $object){
            $json[] = array('loc_name'=>$object->loc_name,'subdiv_code'=>$object->subdiv_code);
            
         }
        echo json_encode($json);
    }
    
     public function getCirCodeJson($distcode,$subdivcode) {
        $data = $this->mutationmodel->getCirCodeJSON($distcode,$subdivcode);
       
        $json = array();
        foreach($data as $object){
          
            $json[] = array('loc_name'=>$object->loc_name,'cir_code'=>$object->cir_code);
         }
        echo json_encode($json);
    }
    
     public function getMouzaJson($distcode,$subdivcode,$circode) {
        $data = $this->mutationmodel->getMouzaJSON($distcode,$subdivcode,$circode);
       
        $json = array();
        foreach($data as $object){
        
            $json[] = array('loc_name'=>$object->loc_name,'mouza_pargona_code'=>$object->mouza_pargona_code);
            
         }
        echo json_encode($json);
    }
    
    public function getLotNoJson($distcode,$subdivcode,$circode,$mouzacode) {
        $data = $this->mutationmodel->getLotNoJson($distcode,$subdivcode,$circode,$mouzacode);
        $json = array();
       
        foreach($data as $object){
            $json[] = array('loc_name'=>$object->lot_no,'lot_no'=>$object->lot_no);
         }
        echo json_encode($json);
    }
    
    public function getVillageCodeJSON($distcode,$subdivcode,$circode,$mouzacode,$lotno) {
        $data = $this->mutationmodel->getVillageCodeJSON($distcode,$subdivcode,$circode,$mouzacode,$lotno);
        $json = array();
       
        foreach($data as $object){
            $json[] = array('loc_name'=>$object->loc_name,'vill_townprt_code'=>$object->vill_townprt_code);
         }
        echo json_encode($json);
    }

}
