<?php
    class LocationModel extends CI_Model {
        protected $table = 'location';

        public function __construct() 
        {
            parent::__construct();
        }

        public function get($conditions = [], $selectFields = '*') {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            return $this->db->select($selectFields)->get($this->table)->row();
        }

        
    }

?>