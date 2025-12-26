<?php

class UserModel extends CI_Model {

    // protected $table = "petition_proceeding";
    
    // public function get_rows_array($conditions, $connection = NULL){
    //     $db = $this->db;
    //     if(!empty($connection)){
    //         $db = $connection;
    //     }

    //     return $db->where($conditions)->get($this->table)->result_array();
    // }

    public function __construct() {
        parent::__construct();
        
        $this->load->model('chitha/ChithaModel');
        
    }

    public function get_user_identification(){
        // Added by Abhijit
        // This function will help to get the Auth user designation - name, Circle / District together

        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $circle_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district_name = $this->utilityclass->getDistrictName($dist_code);

        $str = '';
        if($user_desig_code == 'LM'){
            $lm_name = $this->ChithaModel->lmName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $str = 'লাঃ মঃ - ' . $lm_name . ', ' . $circle_name;
        }elseif($user_desig_code == 'CO'){
            $co_name = $this->ChithaModel->coName($dist_code, $subdiv_code, $cir_code, $user_code);
            $str = 'চক্র বিষয়া - ' . $co_name . ', ' . $circle_name;
        }elseif($user_desig_code == 'ADC'){
            $dc_name = $this->utilityclass->dcname($dist_code, $user_code);
            $str = 'অতিৰিক্ত উপায়ুক্ত - ' . $dc_name . ', ' . $district_name;
        }elseif($user_desig_code == 'DC'){
            $dc_name = $this->utilityclass->dcname($dist_code, $user_code);
            $str = 'উপায়ুক্ত - ' . $dc_name . ', ' . $district_name;
        }

        return $str;
    }
    
}
