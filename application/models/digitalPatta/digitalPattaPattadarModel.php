<?php
class digitalPattaPattadarModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    //db_switch method
    public function dbswitch(){
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    //getting applicant details 
    public function getApplicantDetails($case_no)
    {
        $query = $this->db->select('*')
                        ->where('is_applicant', 1)
                        ->where('case_no', $case_no)
                        ->from('chitha_settlement_allottee')
                        ->get(); 
                        
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return "NOT-FOUND";
        }
    }

    //getting applicant details from chitha pattadar 
    public function getAllDetailsOfApplicant($case_no)
    {
        // $query = $this->db->query("Select * from chitha_pattadar where o1_case_no =? and (pdar_aadharno is not null or pdar_aadharno='' or pdar_pan_no is not null or pdar_pan_no ='' or pdar_nrcno is not null or pdar_nrcno='')",array($case_no));
        $query = $this->db->query("SELECT *
        FROM chitha_pattadar
        WHERE o1_case_no = ? and pdar_occupation is not null
        AND (pdar_aadharno IS NOT NULL OR pdar_aadharno != '' 
        or pdar_pan_no is not null or pdar_pan_no !='' 
        or pdar_nrcno is not null or pdar_nrcno !='')
        AND (CHAR_LENGTH(pdar_aadharno) > 5 or CHAR_LENGTH(pdar_pan_no) > 5 or char_length(pdar_nrcno) > 5)",array($case_no));
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return "NOT-FOUND";
        }
        
    }
    

    //getting joint applicant details 
    public function getJointApplicantDetails($case_no)
    {
        // $query = $this->db->query("Select * from chitha_pattadar where o1_case_no =? and pdar_aadharno is null and  pdar_pan_no is null and pdar_nrcno is null",array($case_no));
        $query = $this->db->query("SELECT *
        FROM chitha_pattadar
        WHERE o1_case_no = ?
        and (pdar_pan_no is null or pdar_pan_no ='') and (pdar_nrcno  is null or pdar_nrcno ='') 
        and (pdar_aadharno ='' or pdar_aadharno is null)",array($case_no));
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return "NOT-FOUND";
        }
    }

    //getting family details 
    public function getFamilyDetailsFromcaseNo($case_no){
        $query = $this->db->query("select * from settlement_nominee where case_no=?",array($case_no));
        if($query->num_rows() == 0){
            return "No Data Found";
        }else{
            return $result = $query->result();
        }
    }

    //getting family details from location
    public function getFamilyDetailsFromLocation($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
    {
        $query = $this->db->select('*')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', $mouza_pargona_code)
                            ->where('lot_no', $lot_no)
                            ->where('vill_townprt_code', $vill_townprt_code)
                            ->where('patta_type_code', $patta_type_code)
                            ->where('patta_no', $patta_no)
                            ->from('chitha_nominee_pattadar')
                            ->get(); 
            if($query->num_rows() != 0 ){
                return $query->result();
            }else{
                return "NOT-FOUND";
            }
    }

    //function to get applicant data
    public function getSettlememtApplicant_data($case_no)
    {
        $query = $this->db->query("select * from settlement_applicant where is_applicant =1 and case_no=?",array($case_no));
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return "NOT-FOUND";
        }

    }
}
?>