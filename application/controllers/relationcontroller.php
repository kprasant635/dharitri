<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class RelationController extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('relation/relationmodel');
    }
    
    public function getRelationJSON(){
        $data =$this->relationmodel->getRelations();
        $json = array();
        foreach($data as $d){
            $json[] = array('guard_rel'=>$d->guard_rel,'guard_rel_desc_as'=>$d->guard_rel_desc_as);
        }
        echo json_encode($json);
    }
}
