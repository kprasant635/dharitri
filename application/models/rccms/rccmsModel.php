<?php

class rccmsModel extends CI_Model {


    public function getAllMouzas($dist_code,$subdiv_code,$cir_code)
    {
        $mouza_list = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!='00' and lot_no='00'",array($dist_code,$subdiv_code,$cir_code));
        return $mouza_list->result();
    }

    public function getAllLots($dist_code,$subdiv_code,$cir_code,$mouza_code)
    {
        $lot_list = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no!='00' and vill_townprt_code ='00000'",array($dist_code,$subdiv_code,$cir_code,$mouza_code));
        return $lot_list->result();
    }

    public function getAllVillages($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no)
    {
        $villages = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code !='00000'",array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));
        return $villages->result();
    }

    public function getDharitreeLgdCode($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_townprt_code)
    {
        $query = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_townprt_code));
        return $query->row()->lgd_code;
        
    }
}
?>