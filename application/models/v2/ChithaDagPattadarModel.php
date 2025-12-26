<?php

class ChithaDagPattadarModel extends CI_Model {
    protected $table = 'chitha_dag_pattadar';
    public function __construct(){
        parent::__construct();
    }

    public function getOtherPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no) {
        
        return $this->db->query("SELECT cp.pdar_name, cp.pdar_father, cdp.pdar_id, cdp.dist_code, cdp.subdiv_code, cdp.cir_code, cdp.mouza_pargona_code, cdp.lot_no, cdp.vill_townprt_code, cdp.dag_no FROM chitha_pattadar cp, chitha_dag_pattadar cdp WHERE cdp.pdar_id=cp.pdar_id AND cdp.patta_no=cp.patta_no AND cdp.patta_type_code=cp.patta_type_code AND cdp.dist_code=cp.dist_code AND cdp.subdiv_code=cp.subdiv_code AND cdp.cir_code=cp.cir_code AND cdp.mouza_pargona_code=cp.mouza_pargona_code AND cdp.lot_no=cp.lot_no AND cdp.vill_townprt_code=cp.vill_townprt_code AND cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? AND cdp.lot_no=? AND cdp.vill_townprt_code=? AND cdp.dag_no=? GROUP BY cdp.dist_code, cdp.subdiv_code, cdp.cir_code, cdp.mouza_pargona_code, cdp.lot_no, cdp.vill_townprt_code, cdp.dag_no, cdp.pdar_id, cp.pdar_name, cp.pdar_father", [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no])->result();
    }

    public function getSinglePattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id) {

        return $this->db->query("SELECT cp.pdar_name, cp.pdar_father, cp.pdar_id, cp.pdar_add1, cp.pdar_add2, cp.pdar_add3, cp.pdar_guard_reln, cp.pdar_gender, cp.pdar_minor_dob FROM chitha_pattadar cp, chitha_dag_pattadar cdp WHERE cdp.pdar_id=cp.pdar_id AND cdp.patta_no=cp.patta_no AND cdp.patta_type_code=cp.patta_type_code AND cdp.dist_code=cp.dist_code AND cdp.subdiv_code=cp.subdiv_code AND cdp.cir_code=cp.cir_code AND cdp.mouza_pargona_code=cp.mouza_pargona_code AND cdp.lot_no=cp.lot_no AND cdp.vill_townprt_code=cp.vill_townprt_code AND cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? AND cdp.lot_no=? AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.pdar_id=?", [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id])->row();

    }
}