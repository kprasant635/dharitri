<?php

class EkhajanaMouzadarModel extends CI_Model {

    //getting all the mouza list 
    public function getAllMouzaList($dist_code, $subdiv_code, $cir_code){
        //return $dist_code.$subdiv_code.$cir_code;
        $sql = "select locname_eng, loc_name, mouza_pargona_code from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code!='00' and lot_no ='00' and vill_townprt_code ='00000'";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));        
        //return $this->db->last_query();
        return $query->result(); 
    }
    
}