<?php

class MasterGuardianRelationModel extends CI_Model {
    protected $table = 'master_guard_rel';

    public function __construct() {
        parent::__construct();
    }

    public function get($conditions = [], $selectFields = '*') {
        if(!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->select($selectFields)->get($this->table)->result();
    }

    public function getByRelation($guard_rel) {
        $this->db->where(['guard_rel' => $guard_rel]);
        return $this->db->select('*')->get($this->table)->row();
    }
}