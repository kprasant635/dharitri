<?php

class MisReportModelBondita extends CI_Model {

    public function getPattano($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
		$db=  $this->session->userdata('db');
        $innerquery = $this->db->query("SELECT TRIM(jp.patta_no) AS patta_no,jp.pdar_name AS pdar_name,jp.p_flag AS p_flag,jp.pdar_father AS pdar_father,"
                . "jd.dag_no AS dag_no,jd.dag_revenue AS dag_revenue,jd.dag_localtax AS dag_localtax from    jama_pattadar AS jp JOIN jama_dag AS jd "
                . "ON TRIM(jd.patta_no)=TRIM(jp.patta_no) AND jp.dist_code=jd.dist_code AND jp.subdiv_code=jd.subdiv_code AND jp.cir_code=jd.cir_code "
                . "AND jp.mouza_pargona_code=jd.mouza_pargona_code AND jp.lot_no=jd.lot_no AND jp.vill_townprt_code= jd.vill_townprt_code where "
                . "jp.dist_code='$dist_code' and jp.subdiv_code='$subdiv_code' and jp.cir_code='$circle_code' and jp.mouza_pargona_code='$mouza_code' "
                . "and jp.lot_no='$lot_no' and jp.vill_townprt_code='$vill_code'");
        return $innerquery->result();
    }

    public function getPattaTypeName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattano) {
		$db=  $this->session->userdata('db');
        $village = $this->db->query("select loc_name AS village from    location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");
        return $village->result();
    }

    public function getpattatypeNameforJamabandi($pattatypecode) {
		$db=  $this->session->userdata('db');
        $village = $this->db->query("Select patta_type from    patta_code where Type_code='$pattatypecode'");
        return $village->result();
    }

    //By Bijoy Mazumder, DIO, Bongaigaon
    public function getPattanoSingle($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no) {
		$db=  $this->session->userdata('db');
        $innerquery = $this->db->query("SELECT TRIM(jp.patta_no) AS patta_no,jp.pdar_name AS pdar_name,jp.p_flag AS p_flag,jp.pdar_father AS "
                . "pdar_father,jd.dag_no AS dag_no,jd.dag_revenue AS dag_revenue,jd.dag_localtax AS dag_localtax from    jama_pattadar AS jp JOIN "
                . "jama_dag AS jd ON TRIM(jd.patta_no)=TRIM(jp.patta_no) AND jp.dist_code=jd.dist_code AND jp.subdiv_code=jd.subdiv_code AND "
                . "jp.cir_code=jd.cir_code AND jp.mouza_pargona_code=jd.mouza_pargona_code AND jp.lot_no=jd.lot_no AND jp.vill_townprt_code= jd.vill_townprt_code "
                . "where jp.dist_code='$dist_code' and jp.subdiv_code='$subdiv_code' and jp.cir_code='$circle_code' and jp.mouza_pargona_code='$mouza_code' and "
                . "jp.lot_no='$lot_no' and jp.vill_townprt_code='$vill_code' and TRIM(jp.patta_no)='$patta_no' ");
        return $innerquery->result();
    }
}

?>