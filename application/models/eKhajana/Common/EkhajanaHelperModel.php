<?php

class EkhajanaHelperModel extends CI_Model
{	

    public function __construct() {
        parent::__construct();
        
        //$this->load->library('form_validation');
        $this->dbswitch();
    }
    //db switch method
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
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
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
        }
    }
    //getting current revenue year
    public function getCurrentRevenueYear(){
        if (date('m') <= 6)
        {
            $yera = date('Y') - 1;
            $currentRevenueYear = date($yera).'-'.date('Y');
        }
        else
        {
            $yera = date('Y') + 1;
            $currentRevenueYear = date('Y').'-'.date($yera);
        }
        return $currentRevenueYear;
    }
    //getting current doul year 
    public function getCurrentDoulYear(){
        if (date('m') <= 6)
        {
            $currentDoulYear = date('Y');
        }
        else
        {
            $currentDoulYear = date('Y') + 1;
        }
        return $currentDoulYear;
    }
    //getting revenue year from created at 
    public function getRevenueYearFromCreatedAt($created_at){
        $year = date('Y',strtotime($created_at));
        if (date('m',strtotime($created_at)) <= 6) {
        $revenue_year = ($year-1)."-".$year;
        } else {
        $revenue_year = $year."-".($year+1);
        }
        return $revenue_year;
    }
    //getting revenue year from the doul year 
    public function getRevenueYearFromDoulYear($dol_year_no){
        //return gettype();
        return (intval($dol_year_no)-1)."-".$dol_year_no;
    }
    //getting patta status 
    public function getPattaStatus($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,
    $vill_townprt_code,$patta_type_code,$patta_no){
        //return "Patta Location Details Are : ". $dist_code.$subdiv_code.$cir_code.$mouza_pargona_code.$lot_no.$vill_townprt_code.$patta_type_code.$patta_no;
        $current_year = $this->getCurrentDoulYear();
        $patta_status_arr = array();
        //***************************************************************/
        //doul_approval_status
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('yeardoul',(string)$current_year)
                    ->from('current_doul_approve')
                    ->get(); 
        if($query->num_rows() != 0 ){
            $patta_status_arr['current_doul_approve'] = $query->row();
        }else{
            $patta_status_arr['current_doul_approve'] = [];
        }
        //***************************************************************/
        //doul_demand
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_pargona_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->where('year_no',(string)$current_year)
                    ->from('current_doul_demand')
                    ->get(); 
        if($query->num_rows() != 0 ){
            $patta_status_arr['current_doul_demand'] = $query->row();
        }else{
            $patta_status_arr['current_doul_demand'] = [];
        }
        //***************************************************************/
        //doul_demand
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_pargona_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->from('chitha_basic')
                    ->get(); 
        if($query->num_rows() != 0 ){
            $patta_status_arr['chitha_basic'] = $query->row();
        }else{
            $patta_status_arr['chitha_basic'] = [];
        }
        //***************************************************************/
        return $patta_status_arr;
    }

    public function getYearWiseArrearDetails($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,
    $vill_townprt_code,$patta_type_code,$patta_no){
        //***************************************************************/
        //doul_demand
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_pargona_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->from('ekhajana_year_wise_arrear')
                    ->get(); 
        if($query->num_rows() != 0 ){
            $year_wise_arrear =  $query->result();
        }else{
            $year_wise_arrear =   [];
        }
        //***************************************************************/
        return $year_wise_arrear;
    }
}
?>