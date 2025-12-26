<?php

class AreaCorrectionModel extends CI_Model {


    public function __construct() {
        parent::__construct();
        //$this->Utili
        $this->dbswitch();
    }




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

   public function getAreaCorrectionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='L' "
                . "and fresh_yn='Y' and misc_case_type='06' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "submission_date >= '$define_date' ORDER BY submission_date DESC";
        $result = $this->db->query($sql);
        return $result->result();
   }

   //get pending office partition cases in co end--------SEARCH-13022023
   public function getPendingAreaCaseLMend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0)
    {
          $col = 0;
          $dir = "asc";
          if(!empty($order)){
              foreach($order as $o){
                  $col = $o['column'];
                  $dir = $o['dir'];
              }
          }
          if($dir != "asc" && $dir != 'desc'){
              $dir = 'desc';
          }
          $valid_columns = array(
              0   => 'proposal_no',
          );
          if(!isset($valid_columns[$col])){
              $order = null;
          }else{
              $order = $valid_columns[$col];
          }
          if($order != null){
              $this->db->order_by($order, $dir);
          }
          if(!empty($searchByCol_0)){
            // $this->db->like('case_no', strtoupper($searchByCol_0));
            // $this->db->like('basundhara', strtoupper($searchByCol_0));
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
          }
          if(!empty($mouza_code)){
            $this->db->where('mouza_pargona_code', $mouza_code);
          }
          if(!empty($lot_no)){
            $this->db->where('lot_no', $lot_no);
          }
          if(!empty($vill_mouza_code)){
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
          }
          if(!empty($vill_lot_no)){
            $this->db->where('lot_no', $vill_lot_no);
          }
          if(!empty($village_code)){
            $this->db->where('vill_townprt_code', $village_code);
          }
          $this->db->select('t_legacyupdation.*,basundhar_application.basundhara');
          $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
          $this->db->where('dist_code', $dist_code);
          $this->db->where('subdiv_code', $subdiv_code);
          $this->db->where('cir_code', $cir_code);
          $this->db->where('t_legacyupdation.lm_note', 'y');
          $this->db->where('t_legacyupdation.is_escalated', 0);
          $this->db->where('t_legacyupdation.es_flag', '1');

          // $this->db->where('date(date_entry) >=', $define_date);
          $this->db->limit($length, $start);
          $query = $this->db->get('t_legacyupdation');
          log_message('error',$this->db->last_query());
          if($query->num_rows()>0){
              $data['data_results'] = $query->result();
              if(!empty($mouza_code)){
                $this->db->where('mouza_pargona_code', $mouza_code);
              }
              if(!empty($lot_no)){
                $this->db->where('lot_no', $lot_no);
              }
              if(!empty($vill_mouza_code)){
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
              }
              if(!empty($vill_lot_no)){
                $this->db->where('lot_no', $vill_lot_no);
              }
              if(!empty($village_code)){
                $this->db->where('vill_townprt_code', $village_code);
              }
              if(!empty($searchByCol_0)){
                $this->db->like('case_no', strtoupper($searchByCol_0));
              }
              $this->db->where('dist_code', $dist_code);
              $this->db->where('subdiv_code', $subdiv_code);
              $this->db->where('cir_code', $cir_code);
             $this->db->where('t_legacyupdation.lm_note', 'y');
               $this->db->where('t_legacyupdation.is_escalated', 0);
               $this->db->where('t_legacyupdation.es_flag', '1');
              //$this->db->limit($length, $start);
              $data['total_records']= $this->db->count_all_results('t_legacyupdation');
              return $data;
          }
    }
    public function getPendingAreaCorCases($limit, $offset, $key=null) {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');        
        $define_date = define_date;
        $year_no = year_no;

        if($key) { // if searching keywords available

            $q = "SELECT fmb.*, fmb.status_date as date_entry, ba.basundhara FROM t_legacyupdation fmb 
            LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree WHERE lm_note != 'y' and es_flag =1 and status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
            AND cir_code=? AND (case_no LIKE '%$key%' OR ba.basundhara LIKE '%$key%')  
            ORDER BY proposal_no ASC LIMIT 10 OFFSET 0";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }
        else // if searching keywords not available
        {
            $q = "SELECT fmb.*, fmb.status_date as date_entry, ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree WHERE lm_note != 'y' and es_flag =1 and status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
            AND cir_code=? ORDER BY proposal_no ASC LIMIT $limit OFFSET $offset";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }

        // ESCALATION VIEW FORMAT TO SHOW ZONES
        $this->Escalationmodel->getEscaltionViewFormat($cases);

        log_message('error',$this->db->last_query());
        return $cases;

    }

    public function getCountPendingAreaCorCases() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "SELECT count(*) AS count FROM t_legacyupdation WHERE status = 'P'  and lm_note != 'y' AND 
            co_yn is null AND dc_yn is null AND dist_code=? AND subdiv_code=? AND cir_code=? and es_flag =1";
            return $cases = $this->db->query($q, 
                array($dist_code, $subdiv_code, $cir_code))->row()->count;       
    }
}

?>