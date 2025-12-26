<?php
    class PetitionLmNoteModel extends CI_Model {
        protected $table = 'petition_lm_note';

        public function __construct() 
        {
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

        public function getLatest($conditions = [], $selectFields = '*') {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            // $this->db->order_by('note_no', 'DESC');
            // $this->db->limit(1);
            return $this->db->select($selectFields)->order_by('note_no', 'DESC')->limit(1)->get($this->table)->row();
        }

        
    }

?>