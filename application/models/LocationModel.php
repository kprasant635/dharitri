<?php 
    class LocationModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_circle($dist_code, $subdiv_code, $cir_code, $connection = NULL){
        if(empty($connection)){
            $connection = $this->db;
        }
        return $connection->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', '00')
                            ->where('lot_no', '00')
                            ->where('vill_townprt_code', '00000')
                            ->get('location')
                            ->row();
    }

    public function get_village($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $connection = NULL){
        if(empty($connection)){
            $connection = $this->db;
        }
        return $connection->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', $mouza_pargona_code)
                            ->where('lot_no', $lot_no)
                            ->where('vill_townprt_code', $vill_townprt_code)
                            ->get('location')
                            ->row();
    }
}