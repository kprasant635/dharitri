<?php

class NameCancellationModel extends CI_Model {


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

    public function getSupportingDoc() {
		$db=  $this->session->userdata('db');
        $sql = "select * from   misc_case_supp_doc ORDER BY supp_doc_code ASC";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function getPdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $misc_case_no) {
        $db=  $this->session->userdata('db');
		$sql = "select pdar_id, pdar_name, pdar_father, pdar_add1, pdar_add2, pdar_guard_reln from   chitha_pattadar "
                . " where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and pdar_id NOT IN "
                . " (select petition_pdar_id from   misc_case_first_party where misc_case_no='$misc_case_no') ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function getPdarInfo1($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $misc_case_no,$dag_no) {
        $db=  $this->session->userdata('db');
		$sql = "select pdar_id, pdar_name, pdar_father, pdar_add1, pdar_add2, pdar_guard_reln from   chitha_pattadar "
                . " where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and pdar_id NOT IN "
                . " (select petition_pdar_id from   misc_case_first_party where misc_case_no='$misc_case_no') and pdar_id NOT IN"
                . " (select opp_pdar_id from   misc_case_scnd_party where misc_case_no='$misc_case_no') and pdar_id IN (Select pdar_id from   chitha_dag_pattadar where dist_code ='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . "and TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and dag_no='$dag_no' and (p_flag='0' or p_flag='')) ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no) {
        $db=  $this->session->userdata('db');
		 $sql = "select t2.pdar_id,t2.pdar_name,t2.pdar_father,t2.pdar_guard_reln,t2.pdar_add1,t2.pdar_add2 from   misc_case_scnd_party AS t1 JOIN  chitha_pattadar AS t2 "
                . " ON t1.opp_pdar_id=t2.pdar_id "
                . " where t1.misc_case_no='$misc_case_no' and t2.dist_code ='$dist_code'  and "
                . " t2.subdiv_code='$subdiv_code' and t2.cir_code='$cir_code' and "
                . " t2.mouza_pargona_code='$mouza_pargona_code' and "
                . " t2.lot_no='$lot_no' and t2.vill_townprt_code='$vill_code' and "
                . " TRIM(t2.patta_no)=trim('$patta_no') and t2.patta_type_code='$patta_type_code'";
        
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function getNoticeGenerateMiscCase($dist_code, $subdiv_code, $cir_code) {
        //$db=  $this->session->userdata('db');
		$year_no = year_no;
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date from   misc_case_basic where status='18' and lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and misc_case_type='07' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function getNoticeGenerateMiscCase1($limit, $start, $dist_code, $subdiv_code, $cir_code) {
        $db=  $this->session->userdata('db');
		$year_no = year_no;
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date from   misc_case_basic where status='18' and lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and misc_case_type='07' limit $limit offset $start";
        $result = $this->db->query($sql);
        return $result;
    }
    
    public function getCOorderDate($misc_case_no) {
       $db=  $this->session->userdata('db');
	   $sql = "select note_date from   misc_case_process_reports where misc_case_no='$misc_case_no' LIMIT 1 ";
       $result = $this->db->query($sql);
       return $result->row()->note_date;
    }
    
    public function getConfirmNoticeGenerate($dist_code, $subdiv_code, $cir_code) {
        //$this->dbswitch();
        $year_no = year_no;
		//$db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date from   misc_case_basic where dag_no is not null and notice_generated_yn='Y' "
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "submission_date >= '$define_date' and notice_generated_date is not null and status='18'";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function getConfirmNoticeGenerate1($limit, $start, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
		$db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date from   misc_case_basic where dag_no is not null and notice_generated_yn='Y' and "
                . "notice_generated_date is not null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='18' ORDER BY submission_date DESC limit $limit offset $start";
        $result = $this->db->query($sql);
        return $result;
    }
    
    public function getCOOrder($misc_case_no){
		$db=  $this->session->userdata('db');
        $sql = "select t1.process_note,t2.username from   misc_case_process_reports AS t1 JOIN users AS t2 ON t1.user_code=t2.user_code"
                . " where t1.misc_case_no='$misc_case_no' ORDER BY t1.note_date ASC LIMIT 1 ";
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    public function getASTReport($misc_case_no){
		$db=  $this->session->userdata('db');
        $sql="select process_note from   misc_case_process_reports where misc_case_no='$misc_case_no' ";
        $result = $this->db->query($sql);
        return $result->row()->process_note;
    }
    
    public function getPdarIDMisc($misc_case_no){
		$db=  $this->session->userdata('db');
        $sql="select * from   misc_case_first_party where misc_case_no='$misc_case_no' and petition_pdar_id NOT IN "
                . "(select pdar_id from   t_chitha_rmk_infavor_of where ord_no='$misc_case_no') LIMIT 1";
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    public function getPdarIDMiscSecondParty($misc_case_no){
		$db=  $this->session->userdata('db');
        $sql="select * from   misc_case_scnd_party where misc_case_no='$misc_case_no' and opp_pdar_id NOT IN "
                . "(select name_for_id from   t_chitha_rmk_other_opp_party where ord_no='$misc_case_no') LIMIT 1";
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->row();
    }

	public function getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code) {
		$db=  $this->session->userdata('db');
        // status 1 is for circle officers first proceedin for name correction
        $sql = "select count(*) AS cnt from   misc_case_basic where status='01' and lm_note_yn is null and sk_note_yn is null and notice_generated_yn is null and fresh_yn='Y' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and add_to_officer = '$user_code' and misc_case_type='07' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }
	public function NameCancellation($misc_case_no) {
		$db=  $this->session->userdata('db');
        $sql = "select * from   misc_case_basic where misc_case_no='$misc_case_no'";
        $result = $this->db->query($sql);
        return $result->row();
    }
	public function getNameCorrCaseInfo($misc_case_no) {
		$db=  $this->session->userdata('db');
        $sql = "select * from   misc_case_basic where misc_case_no='$misc_case_no'";
        $result = $this->db->query($sql);
        return $result->row();
    }
	public function getNameSecPartyInfo($case_no){
		$db=  $this->session->userdata('db');
		$sql = "select * from   misc_case_scnd_party where misc_case_no='$case_no'";
        $result = $this->db->query($sql);
        return $result->row();
	}
	public function getNameFirstPartyInfo($case_no){
		$db=  $this->session->userdata('db');
		$sql = "select * from   misc_case_first_party where misc_case_no='$case_no'";
        $result = $this->db->query($sql);
        return $result->row();
	}


    ///////////////////

    public function getMiscCaseLMRevert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='L' "
                . "and fresh_yn='Y' and misc_case_type='07' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "submission_date >= '$define_date' ORDER BY submission_date DESC";
        $result = $this->db->query($sql);
        return $result->result();
    }

      public function getMiscCaseLMRe($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and lm_note_yn is null "
                . "and status='L' and mcb.misc_case_type='07' and fresh_yn='Y' and submission_date >= '$define_date' ORDER BY submission_date DESC ";


        $result = $this->db->query($sql);
        return $result;
    }
}
