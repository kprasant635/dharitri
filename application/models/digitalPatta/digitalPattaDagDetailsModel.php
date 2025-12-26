<?php
class digitalPattaDagDetailsModel extends CI_Model {
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

    //getting dag details of the case no
    public function getDagDetails($case_no)
    {
        $query = $this->db->query("select * from settlement_dag_details where case_no=?", array($case_no));
        
        if($query->num_rows() == 0){
            return "No Data Found";
        }else{
            return $result = $query->result();
        }
        
    }

    public function getVillagenameFromLocation_old($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,
                                            $lot_no,$vill_townprt_code,$patta_type_code,$patta_no,$dag_no)
    {

        $query = $this->db->query("select locname_eng from location where dist_code=? and 
                                    subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? 
                                    and vill_townprt_code=? and patta_type_code=? and patta_no=? and dag_no=?",
                                    array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,
                                    $patta_type_code,$patta_no,$dag_no));
        if($query->num_rows() == 0){
            return "NOT-FOUND";
        }else{
            return $query->row()->locname_eng;
        }
        

    }

    public function getVillagenameFromLocation($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $this->db->query("select locname_eng AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function checkOldDagNo($case_no,$dag_no,$old_dag_no)
    {
       $query = $this->db->query("select * from settlement_dag_details where case_no=? and (new_dag_no=? or dag_no =?)",array($case_no,$dag_no,$dag_no)); 
       $result = $query->row();
       if($result->new_dag_no == $dag_no){
            return "SAME_DAG";
        }else{
            return "ERROR";
        }
    }
    
}
?>