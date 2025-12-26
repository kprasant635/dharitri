<?php
    class PetitionProceedingModel extends CI_Model {
        protected $table = 'petition_proceeding';

        public function __construct() 
        {
            parent::__construct();
        }

        public function get($conditions = [], $selectFields = '*', $numRow = 'single', $orderBy = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }

            if(!empty($orderBy)) {
                foreach($orderBy as $key => $value) {
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

        public function update($conditions = [], $data = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            if(!empty($data)) {
                $this->db->update($this->table, $data);
            }
            return $this->db->affected_rows();
        }

        public function insert($data) {
            $this->db->insert($this->table, $data);
            return $this->db->affected_rows();
        }

        public function getProceeding($case_no) {
            return $this->db->query("SELECT * FROM petition_proceeding WHERE case_no=? ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();
        }   
    }

?>