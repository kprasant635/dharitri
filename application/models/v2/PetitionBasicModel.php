<?php
    class PetitionBasicModel extends CI_Model {
        protected $table = 'petition_basic';

        public function __construct() 
        {
            parent::__construct();
        }

        public function get($conditions = [], $extraWhere = [], $likeWhere = [], $selectFields = '*') {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            if(!empty($extraWhere)) {
                foreach ($extraWhere as $value) {
                    # code...
                    $this->db->where($value);
                }
            }
            if(!empty($likeWhere)){
                foreach ($likeWhere as $key => $val) {
                    $this->db->like($key, $val);
                }
                
            }
            return $this->db->select($selectFields)->get($this->table)->row();
        }

        public function update($conditions = [], $data = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            if(!empty($data)) {
                $this->db->update($this->table, $data);
            }
            return $this->db->affected_rows();
        }
    }

?>