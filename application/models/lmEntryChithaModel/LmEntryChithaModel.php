<?php

class LMEntryChithaModel extends CI_Model {
    
    
    public function getvillageNameForLM($lm_code) {
        //$CI = &get_instance();
        $db=  $this->session->userdata('db');
        $location=$this->db->query("Select * from   lm_code where lm_code='$lm_code'")->row();
        $locationinfo = $this->db->query("select loc_name from   location where dist_code='$location->dist_code' and subdiv_code='01' and cir_code='06' and mouza_pargona_code ='01' and lot_no ='01' and vill_townprt_code <> '00000'")->result();
        return $locationinfo;
    
    
    
}
}

?>