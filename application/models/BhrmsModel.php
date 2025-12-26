<?php
class BhrmsModel extends CI_Model
{
    public function __construct() {
    }
    public function getMouzas($dist_code, $subdiv_code, $cir_code){
        return $this->db->query('select * from location where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code != ? and lot_no = ?', array($dist_code, $subdiv_code, $cir_code, '00', '00'));
    }
    public function getList($dist_code, $subdiv_code, $cir_code){
        return $this->db->query('select * from bhrms where dist_code = ? and subdiv_code = ? and cir_code = ?', array($dist_code, $subdiv_code, $cir_code));
    }

    public function deleteById($id){
        return $this->db->query('delete from bhrms where id = ?', array($id));
    }
}