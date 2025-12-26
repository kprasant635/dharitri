<?php
    class PetitionProceedingDcAdcModel extends CI_Model {
        protected $table = 'petition_proceeding_dc_adc';

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

        public function getProceedingDcAdc($case_no) {
            return $this->db->query("SELECT * FROM petition_proceeding_dc_adc WHERE case_no=? ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();
        }

        
    }

?>