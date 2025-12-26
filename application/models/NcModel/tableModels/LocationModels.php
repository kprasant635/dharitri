<?php
class LocationModels extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function getNcVillagesInLot($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no){
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('status', 1);
        $this->db->from('location');
        return $this->db->get();
    }


}