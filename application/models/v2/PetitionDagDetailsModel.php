<?php
    class PetitionDagDetailsModel extends CI_Model {
        protected $table = 'petition_dag_details';

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