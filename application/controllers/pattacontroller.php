<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PattaController extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
    }
    public function  getPattaType(){
        $data= $this->pattamodel->getAllPattaType();
        $json_data= array();
        foreach($data as $d){
            $json_data[] = array('type'=>$d->type_code,'patta_type'=>$d->patta_type);
        }
        echo json_encode($data);
    }
    
    public function getDagByPatta($pattano){
        $data = $this->pattamodel->getDagsByPattaNo($pattano)->result();
        $json = array();
        foreach($data as $d){
            $json[]=array('dag_no'=>$d->dag_no);
        }
        return json_encode($json);
    }
    
    public function getDagByPattNoPattaType($pattano,$pattatype){
        $data = $this->pattamodel->getDagsByPattaNoPattaType($pattano,$pattatype)->result();
        $json = array();
        foreach($data as $d){
            $json[]=array('dag_no'=>$d->dag_no);
        }
        return json_encode($json);
    }
    
    public function getGuardianName($pattadarID,$dag=0){
		
        $data = $this->pattamodel->getGuardianName($pattadarID,$dag)->result();
        $json = array();
        foreach($data as $d){
            $json[]=array('gaurdian_name'=>$d->pdar_father,'relation'=>$d->pdar_guard_reln, 'pdar_add1'=>$d->pdar_add1,'pdar_add2'=>$d->pdar_add2,'pdar_gender'=>$d->pdar_gender,
                'pdar_mother'=>$d->pdar_mother,'aadhar'=>$d->pdar_aadharno,'nrc'=>$d->pdar_nrcno,'mobile'=>$d->pdar_mobile,'pan'=>$d->pdar_pan_no,'voter'=>$d->pdar_citizen_no);
        }
        echo json_encode($json);
    }
    
    
     public function getGuardianNameNoSession($pattadarID){
        $case_no = $this->input->get('case_no');
        $data = $this->pattamodel->getGuardianNameNoSession($pattadarID,$case_no)->result();
        $json = array();
        foreach($data as $d){
            $json[]=array('gaurdian_name'=>$d->pdar_father,'relation'=>$d->pdar_guard_reln, 'pdar_add1'=>$d->pdar_add1);
        }
        echo json_encode($json);
    }
    

}