<?php 
    class PattaCodeGroupModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function list(){
        return $this->db->order_by('sort_id', 'asc')->get('patta_code_groups')->result();
    }

    public function list_array(){
        return $this->db->order_by('sort_id', 'asc')->get('patta_code_groups')->result_array();
    }
}