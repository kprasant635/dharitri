<?php
    class PetitionerPartModel extends CI_Model {
        protected $table = 'petitioner_part';

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

        public function getUniquePattadars($conditions = [], $selectFields = '*', $groupBy = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            if(!empty($groupBy)) {
                $this->db->group_by($groupBy);
            }
            return $this->db->select($selectFields)->get($this->table)->result();
        }

        public function checkPattadar($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id) {
            $this->db->where([
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'pdar_id' => $pdar_id
            ]);
            return $this->db->select('*')->get($this->table)->row(); 
        }

        public function getMaxCronNo($conditions = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            return $this->db->select('MAX(pdar_cron_no) AS max_cron_no')->get($this->table)->row()->max_cron_no;
        }

        public function deleteApplicant($conditions = []) {
            if(!empty($conditions)) {
                $this->db->where($conditions);
            }
            return $this->db->delete($this->table);
        }

        public function checkPattadarInThisCase($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id, $case_no) {
            $this->db->where([
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'pdar_id' => $pdar_id,
                'case_no' => $case_no
            ]);
            return $this->db->select('*')->get($this->table)->row(); 
        }
    }

?>