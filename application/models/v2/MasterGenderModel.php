<?php

class MasterGenderModel extends CI_Model {
    protected $table = 'master_gender';

    public function __construct() {
        parent::__construct();
    }

    public function get($conditions = [], $selectFields = '*') {
        if(!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->select($selectFields)->get($this->table)->result();
    }

    public function getByShortName($short_name) {
        $this->db->where(['short_name'=>$short_name]);
        return $this->db->select("*")->get($this->table)->row();
    }
}