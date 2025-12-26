<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DemoModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTeaEstateLand($arr) {
$db=  $this->session->userdata('db');
        $land_class_code = TEA_ESTATE_CLASS_CODE;
        $query = "select * from   chitha_basic  cb  where cb.dist_code='$arr[dist_code]'"
                . " and cb.subdiv_code='$arr[subdiv_code]' and cb.cir_code='$arr[cir_code]' and "
                . "cb.mouza_pargona_code='$arr[mouza_pargona_code]' and land_class_code='$land_class_code'";
      
        $outerdata = $this->db->query($query)->result();
      
        $innerdata = array();
        $estates = array();
        foreach ($outerdata as $location) {
           
            $innerquery = "select pdar_name,patta_no from   chitha_pattadar cb where cb.dist_code='$location->dist_code'"
                    . " and cb.subdiv_code='$location->subdiv_code' and cb.cir_code='$location->cir_code' and "
                    . "cb.mouza_pargona_code='$location->mouza_pargona_code'"
                    . " and cb.vill_townprt_code='10001' "
                    . "and lot_no='$location->lot_no' and TRIM(patta_no)=trim('$location->patta_no')";
           
            $innerdata = $this->db->query($innerquery)->result();
            
            foreach($innerdata as $data){
                
                $estates[]=array
                    (
                        'estatename'=>$data->pdar_name,
                        'patta_no'=>trim($location->dag_no),
                        'b'=>$location->dag_area_b,
                        'k'=>$location->dag_area_k,
                        'l'=>$location->dag_area_lc,
                        ''
                    );
            }
        }
        return $estates;
    }

}
