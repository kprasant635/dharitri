<?php
class ChithaBasicModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function getDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code){
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->from('chitha_basic');
        return $this->db->get();
    }

    public function getChitaArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no){
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('dag_no', $dag_no);
        $this->db->from('chitha_basic');
        return $this->db->get();
    }

}