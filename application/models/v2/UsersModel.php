<?php
    class UsersModel extends CI_Model {
        protected $table = 'users';

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('v2/LmCodeModel');
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

        public function checkIfLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code) {
            $checkUserCode = $this->get(
                [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'user_code' => $user_code
                ]
            );
            if(empty($checkUserCode)) {
                $lm_details = $this->LmCodeModel->get([
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'lm_code' => $user_code
                ]);
                if(empty($lm_details)) {
                    return 0;
                }
                return true;
            }
            return false;
        }

        public function adcDcLoginTableJoin($dist_code) {
            return $this->db->query("SELECT u.username, u.user_desig_code, u.user_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.priv='adm' AND lut.dis_enb_option='E' AND lut.dist_code=? AND lut.subdiv_code='00' AND lut.cir_code='00' AND u.user_desig_code LIKE '%DC' ORDER BY lut.date_of_creation DESC", [$dist_code])->result();
        }
        public function adcLoginTableJoin($dist_code) {
            return $this->db->query("SELECT u.username, u.user_desig_code, u.user_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.priv='adm' AND lut.dis_enb_option='E' AND u.dist_code=? AND u.subdiv_code='00' AND u.cir_code='00' AND u.user_desig_code='ADC' ORDER BY lut.date_of_creation DESC", [$dist_code])->result();
        }

        public function getDetails($user_code, $dist_code, $subdiv_code = null, $cir_code = null) {
            if($subdiv_code == null || $cir_code == null) {
                return $this->db->query("SELECT u.username, u.user_code, u.user_desig_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.dis_enb_option='E' AND lut.priv='adm' AND u.user_code=? AND u.dist_code=? AND u.subdiv_code='00' AND u.cir_code='00' ORDER BY lut.date_of_creation DESC", [$user_code, $dist_code])->row();
            }
            else {
                return $this->db->query("SELECT u.username, u.user_code, u.user_desig_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.dis_enb_option='E' AND u.user_code=? AND u.dist_code=? AND u.subdiv_code=? AND u.cir_code=? ORDER BY lut.date_of_creation DESC", [$user_code, $dist_code, $subdiv_code, $cir_code])->row();
            }
        }

        public function getAstDetails($dist_code, $subdiv_code, $cir_code) {
            return $this->db->query("SELECT u.user_code, u.username, u.user_desig_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.dis_enb_option='E' AND u.user_desig_code='AST' AND u.dist_code=? AND u.subdiv_code=? AND u.cir_code=? ORDER BY lut.date_of_creation DESC", [$dist_code, $subdiv_code, $cir_code])->row();
        }
    }




?>