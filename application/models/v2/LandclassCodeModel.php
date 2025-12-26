<?php
class LandclassCodeModel extends CI_Model {
    protected $table = 'landclass_code';

    public function __construct() {
        parent::__construct();
    }

    public function get_land_classes__count(array $conditions){
        return $this->land_classes_query($conditions)->num_rows();
    }

    public function all_land_classes(){
        // DO NOT PASS ANY CONDITIONS IN THE BELOW CALLED FUNCTION. AS WE WILL GET ALL DATA WITHOUT ANY CONDITIONS
        return $this->get_land_classes([]);
    }

    public function get_land_classes(array $conditions){
        return $this->land_classes_query($conditions)->result();
    }

    public function get_the_land_class($condition_array){
        return $this->db->where($condition_array)
                    ->get($this->table)
                    ->row();
    }

    private function land_classes_query(array $conditions){
        if(count($conditions)){
            $this->db->where($conditions);
        }
        return $this->db->get($this->table);
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