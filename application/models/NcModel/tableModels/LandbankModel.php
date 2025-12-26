<?php
class LandbankModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function getEncroacherInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $this->db->from('c_land_bank_details clb');
        $this->db->join('c_land_bank_encroacher_details clbe','clb.id = clbe.c_land_bank_details_id');
        $this->db->where('clb.dist_code', $dist_code);
        $this->db->where('clb.subdiv_code', $subdiv_code);
        $this->db->where('clb.cir_code', $cir_code);
        $this->db->where('clb.mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('clb.lot_no', $lot_no);
        $this->db->where('clb.vill_townprt_code', $vill_townprt_code);
        $this->db->where('clb.dag_no', $dag_no);
        $this->db->distinct('clbe.id');
        return $this->db->get();
    }


    public function getEncroacherByEncroachId($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$en_id)
    {
        $this->db->from('c_land_bank_details clb');
        $this->db->join('c_land_bank_encroacher_details clbe','clb.id = clbe.c_land_bank_details_id');
        $this->db->where('clb.dist_code', $dist_code);
        $this->db->where('clb.subdiv_code', $subdiv_code);
        $this->db->where('clb.cir_code', $cir_code);
        $this->db->where('clb.mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('clb.lot_no', $lot_no);
        $this->db->where('clb.vill_townprt_code', $vill_townprt_code);
        $this->db->where('clb.dag_no', $dag_no);
        $this->db->where('clbe.id', $en_id);
        return $this->db->get();
    }


}