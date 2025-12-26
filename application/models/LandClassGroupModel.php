<?php 
    class LandClassGroupModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function list($connection = NULL){
        if($connection){
            return $connection->order_by('sort_id', 'asc')->get('land_class_groups')->result();
        }

        return $this->db->order_by('sort_id', 'asc')->get('land_class_groups')->result();
    }

    public function list_array(){
        return $this->db->order_by('sort_id', 'asc')->get('land_class_groups')->result_array();
    }
}