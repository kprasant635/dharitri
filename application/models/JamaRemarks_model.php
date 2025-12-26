<?php

class JamaRemarks_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRemarks15years($dist_code, $subdiv_code, $cir_code, $start = 0, $length = 5) {
        $sql = "SELECT * FROM jama_remark 
                WHERE remark ILIKE '%২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা %'
                  AND dist_code = ?
                  AND subdiv_code = ?
                  AND cir_code = ?
                LIMIT ? OFFSET ?";
    
        $query = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code, $length, $start]);
        return $query->result_array();
    }

    public function countAllRemarks($dist_code, $subdiv_code, $cir_code) {
        $sql = "SELECT COUNT(*) as total FROM jama_remark 
                WHERE remark ILIKE '%২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা %'
                  AND dist_code = ?
                  AND subdiv_code = ?
                  AND cir_code = ?";
    
        $query = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code]);
        return $query->row()->total;
    }

    public function getRemark($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townport_code, $patta_type_code, $patta_no, $rmk_line_no) {
        $query = $this->db->query("select * from jama_remark where 
                dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? 
                and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=? and rmk_line_no=?",
                array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townport_code,
                $patta_type_code, $patta_no, $rmk_line_no))->row();
        return $query->remark; 
    }

    public function insertIntoBackup($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townport_code, $patta_type_code, $patta_no, $rmk_line_no,$remark) {
        $query = $this->db->query("select * from jama_remark where 
                dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? 
                and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=? and rmk_line_no=?",
                array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townport_code,
                $patta_type_code, $patta_no, $rmk_line_no))->row();
        $old_record = json_encode($query);     
        $old_remark =  $query->remark; 
        // var_dump($old_record);

        $sql = "INSERT INTO jama_remark_update (
                            dist_code,
                            subdiv_code,
                            cir_code,
                            mouza_pargona_code,
                            lot_no,
                            vill_townprt_code,
                            patta_type_code,
                            patta_no,
                            rmk_line_no,
                            old_record,
                            old_remark,
                            new_remark,
                            updated_by
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";

                $this->db->query($sql, [
                    $dist_code,
                    $subdiv_code,
                    $cir_code,
                    $mouza_pargona_code,
                    $lot_no,
                    $vill_townport_code,
                    $patta_type_code,
                    $patta_no,
                    $rmk_line_no,
                    $old_record,
                    $old_remark,
                    $remark,
                    $this->session->userdata('user_code')
                ]);

        // die;
        return true;
    }

    


    public function getLocName($dist_code, $subdiv_code, $cir_code){
        $cir_loca = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and	mouza_pargona_code='00'",array($dist_code, $subdiv_code, $cir_code))->row_array();
        return $cir_loca['loc_name'];
    }

    public function getMouzaName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code){
        $cir_loca = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and	mouza_pargona_code=? and lot_no ='00'",array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code))->row_array();
        return $cir_loca['loc_name'];
    }

    public function getLotName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no){
        $cir_loca = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and	mouza_pargona_code=? and lot_no=? and vill_townprt_code='00000'",array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no))->row_array();
        // var_dump($this->db->last_query());die;
        return $cir_loca['loc_name'];
    }

    public function getVillageName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code){
        $cir_loca = $this->db->query("select * from location where dist_code=? and subdiv_code=? and cir_code=? and	mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row_array();
        return $cir_loca['loc_name'];
    }

    public function getPattaName($var){
        $cir_loca = $this->db->query("select * from patta_code where type_code=?",array($var))->row_array();
        return $cir_loca['patta_type'];
    }


    
    
}