<?php

class ChithaBasicModel extends CI_Model {
    protected $table = 'chitha_basic';

    public function __construct() {
        parent::__construct();

    }

    public function get($conditions = [], $selectFields = '*', $numRow = 'single', $orderBy = []) {
        if(!empty($conditions)) {
            $this->db->where($conditions);
        }

        if(!empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if($numRow == 'single') {
            return $this->db->select($selectFields)->get($this->table)->row();
        }
        else if($numRow == 'multiple') {
            return $this->db->select($selectFields)->get($this->table)->result();
        }
    }
}