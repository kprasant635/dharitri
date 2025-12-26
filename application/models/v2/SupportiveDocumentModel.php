<?php
    class SupportiveDocumentModel extends CI_Model {
        protected $table = 'supportive_document';

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

        public function getDocs($case_no) {
            return $this->db->query("SELECT id, file_name, file_path FROM supportive_document WHERE case_no=? AND (file_name=? OR file_name=? OR file_name=? OR file_name=? OR file_name=? OR file_name=?)", [$case_no, 'LAND_DETAILS', 'LAND_REVENUE', 'ANNUAL_PATTA', 'SCHEDULE_LAND', 'CHITHA', 'ID_PROOF'])->result();
        }

        // public function supportiveDocCount($case_no) {
        //     return $this->db->query("SELECT COUNT(case_no) FROM supportive_document WHERE case_no=?", [$case_no])->row();
        // }
    }




?>