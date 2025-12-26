<?php
class PattacodeModel extends CI_Model {
    protected $table = 'patta_code';

    public function __construct() {
        parent::__construct();
    }

    public function get_the_patta($condition_array){
        return $this->db->where($condition_array)
                    ->get($this->table)
                    ->row();
    }

    // private function case_pending_with_co_and_dc($dist_code, $subdiv_code, $cir_code){
    //     return $this->db->where('dist_code', $dist_code)
    //                     ->where('subdiv_code', $subdiv_code)
    //                     ->where('cir_code', $cir_code)
    //                     ->where('co_yn', NULL)
    //                     ->where('dc_yn', NULL)
    //                     ->where("(status != 'R' and status!='M' OR status is null OR status='C')")
    //                     ->get($this->table);
    // }

    
    
}
?>