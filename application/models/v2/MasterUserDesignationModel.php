<?php

class MasterUserDesignationModel extends CI_Model {
    protected $table = 'master_user_designation';

    public function __construct() {
        parent::__construct();
    }

    public function get($conditions = [], $selectFields = '*', $numRow = 'single') {
        if(!empty($conditions)) {
            $this->db->where($conditions);
        }

        if($numRow == 'single') {
            return $this->db->select($selectFields)->get($this->table)->row();
        }
        else if($numRow == 'multiple') {
            return $this->db->select($selectFields)->get($this->table)->result();
        }
    }

}