<?php

class APCancellationModel extends CI_Model {

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
    //getLocationFromSession
    //#########################################################################################################################################
    //function starts for AST AP Cancellation Process
    public function getEksonaPatta() {
        $db=  $this->session->userdata('db');
        $eksonapatta = $this->db->query("select type_code,patta_type from   patta_code where apcancellation='y'");
        return $eksonapatta->result();
    }

    public function getAllPatta() {
        $db=  $this->session->userdata('db');
        $eksonapatta = $this->db->query("select type_code,patta_type from   patta_code where type_code <> '0000' ORDER BY patta_code ASC");
        return $eksonapatta->result();
    }

    public function getCOName($dist_code, $subdiv_code, $cir_code) {
        $db=  $this->session->userdata('db');
        $q="Select * from   loginuser_table where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like 'C%' and dis_enb_option='E'";
        $data=$this->db->query($q)->result();       
        foreach($data as $r){
        $coname = $this->db->query("select user_code, username  from   users where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code='$r->user_code' ");
        return $coname->result();
        }
    }

    public function checkAbilableEksonaLand($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code) {

//        echo "select count(*)  AS countLand from   chitha_basic where dist_code ='$dist_code'  and "
//                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                . "mouza_pargona_code='$mouza_pargona_code' and "
//                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
//                . "patta_type_code IN (select type_code  from   patta_code where apcancellation='y') ";
        $db=  $this->session->userdata('db');
        $AvilLand = $this->db->query("select count(*)  AS countLand from   chitha_basic where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code IN (select type_code  from   patta_code where apcancellation='y' )");


        return $AvilLand->row();
    }

    public function checkavailpattatype($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code) {
        $db=  $this->session->userdata('db');
        $sql = "select count(*)  AS cnt from   chitha_basic where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'";

        $result = $this->db->query($sql);

        return $result->row()->cnt;
    }

    public function getCountPetId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select count(*)  AS cnt from   apcancel_petitioner where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->row()->cnt;
    }

    public function getAvailDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code) {
        $db=  $this->session->userdata('db');
        $AvilDags = $this->db->query("select dag_no from   chitha_basic where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'");
        return $AvilDags->result();
    }

    public function getCountPdarId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $dag_no, $case_no, $patta_no, $patta_type_code) {
        //APCancel_petition_pattadar
        $db=  $this->session->userdata('db');
        $sql = "select count(*)  AS cnt from   apcancel_petition_pattadar where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'"
                . " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' ";

        $result = $this->db->query($sql);

        return $result->row()->cnt;
    }

    public function getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no) {
//        $sql="select cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2,cp.pdar_guard_reln from   chitha_dag_pattadar AS cdp JOIN chitha_pattadar AS cp ON "
//                . " cdp.dist_code=cp.dist_code and cdp.subdiv_code=cp.subdiv_code and cdp.cir_code=cp.cir_code and cdp.mouza_pargona_code=cp.mouza_pargona_code and "
//                . " cdp.lot_no=cp.lot_no and cdp.vill_townprt_code=cp.vill_townprt_code and cdp.patta_no=cp.patta_no and "
//                . " cdp.patta_type_code=cp.patta_type_code  and cdp.pdar_id=cp.pdar_id where cdp.dist_code ='$dist_code'  and "
//                . " cdp.subdiv_code='$subdiv_code' and cdp.cir_code='$cir_code' and "
//                . " cdp.mouza_pargona_code='$mouza_pargona_code' and "
//                . " cdp.lot_no='$lot_no' and cdp.vill_townprt_code='$vill_code' and "
//                . " cdp.dag_no='$dag_no' and cdp.patta_no='$patta_no' and cdp.patta_type_code='$patta_type_code' and "
//                . "cdp.pdar_id NOT IN (select pdar_id from   apcancel_petition_pattadar where dist_code ='$dist_code'  and "
//                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                . "mouza_pargona_code='$mouza_pargona_code' and "
//                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and case_no='$case_no')";
        $db=  $this->session->userdata('db');
        $sql = "select cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2,cp.pdar_guard_reln from   chitha_dag_pattadar AS cdp JOIN  chitha_pattadar AS cp ON "
                . " cdp.dist_code=cp.dist_code and cdp.subdiv_code=cp.subdiv_code and cdp.cir_code=cp.cir_code and cdp.mouza_pargona_code=cp.mouza_pargona_code and "
                . " cdp.lot_no=cp.lot_no and cdp.vill_townprt_code=cp.vill_townprt_code and TRIM(cdp.patta_no)=TRIM(cp.patta_no) and "
                . " cdp.patta_type_code=cp.patta_type_code  and cdp.pdar_id=cp.pdar_id where cdp.dist_code ='$dist_code'  and "
                . " cdp.subdiv_code='$subdiv_code' and cdp.cir_code='$cir_code' and "
                . " cdp.mouza_pargona_code='$mouza_pargona_code' and "
                . " cdp.lot_no='$lot_no' and cdp.vill_townprt_code='$vill_code' and "
                . " cdp.dag_no='$dag_no' and TRIM(cdp.patta_no)='$patta_no' and cdp.patta_type_code='$patta_type_code' ";
        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getPdarDataJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $pdar_id) {
        $db=  $this->session->userdata('db');
        $sql = "select cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2,cp.pdar_guard_reln from   chitha_dag_pattadar AS cdp JOIN  chitha_pattadar AS cp ON "
                . " cdp.dist_code=cp.dist_code and cdp.subdiv_code=cp.subdiv_code and cdp.cir_code=cp.cir_code and cdp.mouza_pargona_code=cp.mouza_pargona_code and "
                . " cdp.lot_no=cp.lot_no and cdp.vill_townprt_code=cp.vill_townprt_code and TRIM(cdp.patta_no)=TRIM(cp.patta_no) and "
                . " cdp.patta_type_code=cp.patta_type_code  and cdp.pdar_id=cp.pdar_id where cdp.dist_code ='$dist_code'  and "
                . " cdp.subdiv_code='$subdiv_code' and cdp.cir_code='$cir_code' and "
                . " cdp.mouza_pargona_code='$mouza_pargona_code' and "
                . " cdp.lot_no='$lot_no' and cdp.vill_townprt_code='$vill_code' and "
                . " cdp.dag_no='$dag_no' and TRIM(cdp.patta_no)='$patta_no' and cdp.patta_type_code='$patta_type_code' and cdp.pdar_id='$pdar_id'";

        $result = $this->db->query($sql);

        return $result->result();
    }

    //#########################################################################################################################################
    //function ends for AST AP Cancellation Process

    public function getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from   apcancel_petition_basic "
                . "where status='P' and lm_note_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and date_entry >= '$define_date'";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getCountAPCasesforLM1($limit, $start, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from   apcancel_petition_basic "
                . "where status='P' and lm_note_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and date_entry >= '$define_date'"
                . " ORDER BY submission_date DESC"
                . " limit $limit offset $start";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getCountAPCasesforSK() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from   apcancel_petition_basic "
                . "where status='P' and date_entry >= '$define_date' and lm_note_yn='Y' and sk_note_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code'";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getCountAPCasesforSK1($limit, $start) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from   apcancel_petition_basic "
                . " where status='P' and lm_note_yn='Y' and date_entry >= '$define_date' and sk_note_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code'"
                . " ORDER BY submission_date DESC"
                . " limit $limit offset $start";

        $result = $this->db->query($sql);

        return $result;
    }

    public function getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select t3.type_code,t3.patta_type,t1.add_off_name from   apcancel_petition_basic AS t1 JOIN  apcancel_petition_pattadar AS t2 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no JOIN  patta_code AS t3 ON t2.patta_type_code=t3.type_code "
                . " where t1.dist_code ='$dist_code'  and "
                . " t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . "t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and t1.petition_no='$petition_no' and t1.case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select pet_name, guard_name, guard_rel, add1, add2 from   apcancel_petitioner where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select t1.dag_no, t1.patta_no, t1.patta_type_code from   apcancel_petition_pattadar AS t1  where t1.dist_code ='$dist_code'  and "
                . " t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and t1.petition_no='$petition_no' and t1.case_no='$case_no'";
        //JOIN patta_code AS t2 ON t1.
        $result = $this->db->query($sql);

        return $result->result();
    }

    //get patta type code with respect to 
    public function getPattaName($land_type_code) {
        $db=  $this->session->userdata('db');
        $eksonapatta = $this->db->query("select type_code,patta_type from   patta_code where type_code='$land_type_code'");
        return $eksonapatta->row();
    }

    public function getLMReport($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select lm_report from   apcancel_petition_lm_note where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->row()->lm_report;
    }

    public function getCountAPCaseCO($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select t3.patta_type, t2.patta_no,t2.dag_no "
                . " from   apcancel_petition_basic AS t1 "
                . " JOIN  apcancel_petition_pattadar AS t2 ON t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code "
                . " and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no "
                . " JOIN patta_code AS t3 ON t3.type_code=t2.patta_type_code "
                . " where t1.dist_code ='$dist_code'  and t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_code' and t1.petition_no='$petition_no' and t1.case_no='$case_no' and "
                . " t1.status='P' and t1.lm_note_yn='Y' and t1.sk_note_yn='Y' and t1.date_entry >= '$define_date' and "
                . " t1.case_no NOT IN (select case_no from   apcancel_petition_proceeding)";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function getCountAPCasesforCO() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select t1.case_no,t1.submission_date, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no,  t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_basic AS t1 where t1.status='P' and t1.lm_note_yn='Y' and t1.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and t1.sk_note_yn='Y' and "
                . " t1.case_no NOT IN (select case_no from   apcancel_petition_proceeding)";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getCountAPCasesforCO1() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select t1.case_no,t1.submission_date,  t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_basic AS t1 
                 where t1.status='P' and t1.lm_note_yn='Y' and t1.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and t1.sk_note_yn='Y' and "
                . " t1.case_no NOT IN (select case_no from   apcancel_petition_proceeding) "
                . " ORDER BY t1.submission_date DESC ";
        $result = $this->db->query($sql);

        return $result;
    }

    public function getCountAPCaseCO2ndStep($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select t3.patta_type, t2.patta_no,t2.dag_no from   apcancel_petition_basic AS t1 "
                . " JOIN  apcancel_petition_pattadar AS t2 ON t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code "
                . " and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no JOIN  patta_code AS t3 ON t3.type_code=t2.patta_type_code "
                . " where t1.dist_code ='$dist_code'  and t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_code' and t1.date_entry >= '$define_date' and "
                . " t1.petition_no='$petition_no' and t1.case_no='$case_no' and "
                . " t1.status='P' and t1.lm_note_yn='Y' and t1.sk_note_yn='Y' ";
        //echo $sql;

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function getNoteHearingAPCasesforCO() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select t1.next_date_of_hearing,t1.submission_date, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no from   apcancel_petition_basic AS t1  where t1.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and  t1.notice_generated_yn='Y' and (t1.co_recommendation_yn!='Y' or t1.co_recommendation_yn is null ) "
                . " ORDER BY t1.submission_date DESC ";
        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getNoteHearingAPCasesforCO1() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select t1.next_date_of_hearing,t1.submission_date, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no from   apcancel_petition_basic AS t1  where t1.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and  t1.notice_generated_yn='Y' and (t1.co_recommendation_yn!='Y' or t1.co_recommendation_yn is null ) "
                . " ORDER BY t1.submission_date DESC ";
        $result = $this->db->query($sql);

        return $result;
    }

    public function getSKReport($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select sk_note from   apcancel_petition_lm_note where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->row()->sk_note;
    }

    public function countAPCaseShowCauseForAST() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        //$db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select t1.date_hearing, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_proceeding AS t1 JOIN  apcancel_petition_basic AS t2 ON"
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no"
                . " where t2.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and t2.notice_generated_yn is null and t1.co_order is not null and t1.note_on_order is null";

        $result = $this->db->query($sql);
        return $result->result();
    }

    public function countAPCaseShowCauseForAST1($limit, $start) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select t1.date_hearing, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_proceeding AS t1 JOIN  apcancel_petition_basic AS t2 ON"
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no"
                . " where t2.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and t2.notice_generated_yn is null and t1.co_order is not null and t1.note_on_order is null"
                . " ORDER BY t2.submission_date DESC"
                . " limit $limit offset $start";

        $result = $this->db->query($sql);
        return $result;
    }

    public function getAPCaseShowCauseAST($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no, $date_hearing) {
        $db=  $this->session->userdata('db');
        $sql = "select * from   apcancel_petition_pattadar where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        //pdar_name,pdar_guardian,pdar_add1,pdar_add2
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getNoteOfHearingNRforCO() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $db=  $this->session->userdata('db');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select * from   apcancel_petition_basic AS t1 JOIN  apcancel_petition_proceeding AS t2 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no "
                . " and t1.petition_no=t2.petition_no where t1.date_entry >= '$define_date' and t2.co_order is not null and t2.note_on_order is null and t1.notice_generated_yn='Y'";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getGiveRecommendationforCO() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "SELECT t1.submission_date,t1.case_no,t1.dist_code,t1.subdiv_code,t1.cir_code,t1.mouza_pargona_code,t1.lot_no,t1.vill_townprt_code,t1.year_no, t1.petition_no FROM  apcancel_petition_basic AS t1 JOIN  apcancel_petition_proceeding AS t2 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no "
                . " and t1.petition_no=t2.petition_no "
                . "WHERE t1.date_entry >= '$define_date' and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' "
                . "and t1.cir_code='$cir_code' and t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t2.note_on_order is not null and t1.co_recommendation_yn is null and t1.dc_approval_yn is null";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getCONoteOfHearing($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select t2.co_order from   apcancel_petition_proceeding AS t2 JOIN  apcancel_petition_basic AS t1 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no "
                . " and t1.petition_no=t2.petition_no "
                . " where t1.dist_code ='$dist_code' and "
                . " t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and "
                . " t1.date_entry >= '$define_date' and t1.petition_no='$petition_no' and t1.case_no='$case_no' and"
                . "  t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t1.co_recommendation_yn='Y'";
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->row()->co_order;
    }

    public function getco1stproceeding($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select co_order from   apcancel_petition_proceeding where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->result();
    }

//DC DC DC dC DC DC DC dC DC Dc Dc dC dC Dc Dc dC  Ddc DC Dc Dc Dc DcDcDcDcDcDcDcDcDc
    public function getDCAPCancellationMatter() {
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "SELECT t1.submission_date,t1.case_no,t1.dist_code,t1.subdiv_code,t1.cir_code,t1.mouza_pargona_code,t1.lot_no,t1.vill_townprt_code,t1.year_no, t1.petition_no FROM apcancel_petition_basic AS t1 WHERE t1.date_entry >= '$define_date' and t1.not_fresh='Y' "
                . "and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' "
                . "and t1.co_recommendation_yn='Y' and t1.dc_approval_yn IS null";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getDCAPCancellationMatter1() {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "SELECT t1.submission_date,t1.case_no,t1.dist_code,t1.subdiv_code,t1.cir_code,t1.mouza_pargona_code,t1.lot_no,t1.vill_townprt_code,t1.year_no, t1.petition_no FROM apcancel_petition_basic AS t1 WHERE t1.date_entry >= '$define_date' and t1.not_fresh='Y' and t1.status='P' "
                . "and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and  t1.co_recommendation_yn='Y' and t1.dc_approval_yn IS null"
                . " ORDER BY t1.submission_date DESC"
                . " ";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getDCAPCancellation11($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "SELECT t1.submission_date,t1.case_no,t1.dist_code,t1.subdiv_code,t1.cir_code,t1.mouza_pargona_code,t1.lot_no,t1.vill_townprt_code,t1.year_no, t1.petition_no FROM  apcancel_petition_basic AS t1 JOIN  apcancel_petition_proceeding AS t2 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no "
                . " and t1.petition_no=t2.petition_no "
                . " WHERE t1.dist_code ='$dist_code' and t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and "
                . " t1.date_entry >= '$define_date' and t1.petition_no='$petition_no' and t1.case_no='$case_no'"
                . " and t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t2.note_on_order IS NOT null and t1.co_recommendation_yn='Y' and t1.dc_approval_yn IS null";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getOrderAPCancellation() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $db=  $this->session->userdata('db');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select submission_date, case_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,year_no, petition_no from   apcancel_petition_basic where "
                . "date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_yn='Y' and notice_generated_yn='Y' and "
                . "co_recommendation_yn='Y' and dc_approval_yn='Y' and  order_passed is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code'";
        
        //echo $sql; 
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getOrderAPCancellation1($limit, $start) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $db=  $this->session->userdata('db');
        $year_no = year_no;
        $define_date = define_date;
//        $sql="select submission_date, case_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,year_no, petition_no from   apcancel_petition_basic where not_fresh='Y' and status='P' and lm_note_yn='Y' and notice_generated_yn='Y' and co_recommendation_yn='Y' "
//                . "and dc_approval_yn='Y' and  order_passed is null ORDER BY submission_date DESC limit $limit offset $start";

        $sql = "select * from   apcancel_petition_basic AS t1 JOIN  apcancel_petition_proceeding AS t2 ON t1.case_no=t2.case_no where t1.not_fresh='Y' 
and t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code
and t1.lot_no = t2.lot_no and t1.vill_townprt_code= t2.vill_townprt_code and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t1.co_recommendation_yn='Y' 
and t1.dc_approval_yn='Y' and t1.order_passed is null and t1.dist_code='$dist_code' and t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' ORDER BY proceeding_id DESC limit $limit offset $start";


        $result = $this->db->query($sql);
        return $result;
    }

    public function getCountAPCaseDC($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select t3.patta_type, t2.patta_no,t2.dag_no "
                . " from   apcancel_petition_basic AS t1 "
                . " JOIN  apcancel_petition_pattadar AS t2 ON t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code "
                . " and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no "
                . " JOIN  patta_code AS t3 ON t3.type_code=t2.patta_type_code "
                . " where t1.dist_code ='$dist_code'  and t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and "
                . " t1.date_entry >= '$define_date' and t1.petition_no='$petition_no' and t1.case_no='$case_no' and "
                . " t1.status='P' and t1.lm_note_yn='Y' and t1.sk_note_yn='Y' and "
                . " t1.co_recommendation_yn='Y' and t1.dc_approval_yn IS null  ";

        //. " t1.case_no NOT IN (select case_no from   apcancel_petition_proceeding)";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from   apcancel_petition_pattadar where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no'";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function getDCNote($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select t1.dc_order from   apcancel_petition_proceeding AS t2 JOIN  apcancel_petition_basic AS t1 ON "
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no "
                . " and t1.petition_no=t2.petition_no "
                . " where t1.dist_code ='$dist_code' and "
                . " t1.subdiv_code='$subdiv_code' and t1.cir_code='$cir_code' and "
                . " t1.mouza_pargona_code='$mouza_pargona_code' and "
                . " t1.lot_no='$lot_no' and t1.vill_townprt_code='$vill_townprt_code' and "
                . " t1.date_entry >= '$define_date' and t1.petition_no='$petition_no' and t1.case_no='$case_no' and"
                . "  t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t1.co_recommendation_yn='Y'";
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->row()->dc_order;
    }

    //DC DC DC dC DC DC DC dC DC Dc Dc dC dC Dc Dc dCDdc DCDcDcDcDcDcDcDcDcDcDcDcDc
    //for final order
    public function getLandType() {
        $db=  $this->session->userdata('db');
        $sql = "select * from   ord_on_gl_type_code where type_code <> '00' ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getOrderNo() {
        $db=  $this->session->userdata('db');
        $sql = "select count(*) AS c from   apt_chitha_rmk_ordbasic";
        $result = $this->db->query($sql);
        return $result->row()->c;
    }

    public function getLMList($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $db=  $this->session->userdata('db');
        $sql = "select lm_name,lm_code from   lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getSKList($dist_code, $subdiv_code, $cir_code) {
        $db=  $this->session->userdata('db');
        $sql = "select user_code,username from   users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and user_desig_code='SK' ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getCOList($dist_code, $subdiv_code, $cir_code) {
        $db=  $this->session->userdata('db');
        $sql = "select user_code,username from   users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_desig_code='CO' ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getCOIname($dist_code, $subdiv_code, $cir_code,$user_code) {
      $db=  $this->session->userdata('db');
        $sql = "select user_code,username from   users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_desig_code='CO' and user_code='$user_code' ";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function getLMCODate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select lm_note_date,co_recommendation_date,sk_note_date from   apcancel_petition_basic where "
                . " dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " petition_no='$petition_no' and case_no='$case_no'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function getPattadars11($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select pdar_id,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from   apcancel_petition_pattadar where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no' and case_no='$case_no' and pdar_name NOT IN "
                . "(select name_for from   apt_chitha_rmk_other where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                . "petition_no='$petition_no') LIMIT 1";
        //echo $sql;
        $result = $this->db->query($sql);

        return $result->row();
    }

    public function getNameForID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no) {
        $db=  $this->session->userdata('db');
        $sql = "select count(*) AS name_for_id from   apt_chitha_rmk_other where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "petition_no='$petition_no'";
        $result = $this->db->query($sql);

        return $result->row()->name_for_id;
    }

    public function getRelation() {
        $db=  $this->session->userdata('db');
        $sql = "select * from   master_guard_rel";
        $result = $this->db->query($sql);

        return $result->result();
    }

    //for final order
}
