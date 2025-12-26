<?php
class EscRevertModel extends CI_Model 
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('Escalationmodel');
  }


  public function getPendingFieldRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
  {
    $curr_date = date('Y-m-d');
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
      0   => 'field_mut_basic.petition_no',
    );
    if(!isset($valid_columns[$col])){
      $order = null;
    }else{
      $order = $valid_columns[$col];
    }
    if($order != null){
      $this->db->order_by($order, $dir);
    }

    // select *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where order_passed is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and is_dispose='L'  and date_entry >= '$define_date'

    if(!empty($searchByCol_0)){
      $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }
    $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('field_mut_basic.dist_code', $dist_code);
    $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
    $this->db->where('field_mut_basic.cir_code', $cir_code);
    $this->db->where('field_mut_basic.mouza_pargona_code', $mouza);
    $this->db->where('field_mut_basic.lot_no', $lot_no);
    $this->db->where('field_mut_basic.is_dispose', 'L');    
    $this->db->where('date(date_entry) >=', $define_date);

    if($zone_status == 4){
      $this->db->where('field_mut_basic.es_flag', 0);        
    }
    else {
      $this->db->where('field_mut_basic.es_flag', 1);  
    }
    
    $this->db->limit($length, $start);
    $query = $this->db->get('field_mut_basic');
    // log_message('error',"field_mut_basic: ".$this->db->last_query());

    if($query->num_rows()>0){
    
      $data_results = $query->result();
      $final_array = array();

      foreach($data_results as $rr)
      {
        $variable = $this->Escalationmodel->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->report_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->mut_type);

        if(!empty($variable)){
          $final_array[] = $variable;
        }
      }

      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);

      if(!empty($searchByCol_0)){
        $this->db->like('case_no', strtoupper($searchByCol_0));
      }


      $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

      $this->db->where('field_mut_basic.dist_code', $dist_code);
      $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
      $this->db->where('field_mut_basic.cir_code', $cir_code);
      $this->db->where('field_mut_basic.mouza_pargona_code', $mouza);
      $this->db->where('field_mut_basic.lot_no', $lot_no);
      $this->db->where('field_mut_basic.is_dispose', 'L');    
      $this->db->where('date(date_entry) >=', $define_date);    

      if($zone_status == 4){
        $this->db->where('field_mut_basic.es_flag', 0);        
      }
      else {
        $this->db->where('field_mut_basic.es_flag', 1);  
      }

      $res= $this->db->get('field_mut_basic')->result();

      $cc = array();

      foreach($res as $r) {

        if(!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) 
        {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100*$remain_days)/$r->co_target_days;

          //green zone
          if(($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if(($zone_status == 2) && (($perct_avail<YELLOW_ZONE) && ($perct_avail>RED_ZONE))) { 
            $cc[] = 1;
          }
          //red zone
          else if(($zone_status == 3) && ($perct_avail<=RED_ZONE)) {
            $cc[] = 1;
          }
          else if($zone_status == 4) {
            $cc[] = 1;
          }
        }
        else {
          $cc[] = 1;
        }
      }

      $data['total_records']= count($cc); 
      return $data;
    }
  }

  public function getPendingofficeRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
  {
    $curr_date = date('Y-m-d');
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
      0   => 'petition_basic.petition_no',
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
      $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }
    $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('petition_basic.dist_code', $dist_code);
    $this->db->where('petition_basic.subdiv_code', $subdiv_code);
    $this->db->where('petition_basic.cir_code', $cir_code);
    $this->db->where('petition_basic.mouza_pargona_code', $mouza);
    $this->db->where('petition_basic.lot_no', $lot_no);
    $this->db->where('date(date_entry) >=', $define_date);

    $this->db->where('petition_basic.lm_note_date IS NULL');
    $this->db->where('petition_basic.lm_note_yn IS NULL');
    $this->db->where('petition_basic.is_pending', 'Y');
    $this->db->where('petition_basic.status !=', 'D');
    $this->db->where('petition_basic.mut_type =', '03');      

    if($zone_status == 4){
      $this->db->where('petition_basic.es_flag', 0);        
    }
    else {
      $this->db->where('petition_basic.es_flag', 1);  
    }
    
    $this->db->limit($length, $start);
    $query = $this->db->get('petition_basic');
    log_message('error',"petition_basic: ".$this->db->last_query());

    if($query->num_rows()>0){
    
      $data_results = $query->result();
      $final_array = array();

      foreach($data_results as $rr)
      {
        $variable = $this->Escalationmodel->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn);

        if(!empty($variable)){
          $final_array[] = $variable;
        }
      }

      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);

      if(!empty($searchByCol_0)){
        $this->db->like('case_no', strtoupper($searchByCol_0));
      }


      $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
      
      $this->db->where('petition_basic.dist_code', $dist_code);
      $this->db->where('petition_basic.subdiv_code', $subdiv_code);
      $this->db->where('petition_basic.cir_code', $cir_code);
      $this->db->where('petition_basic.mouza_pargona_code', $mouza);
      $this->db->where('petition_basic.lot_no', $lot_no);
      $this->db->where('date(date_entry) >=', $define_date);

      $this->db->where('petition_basic.lm_note_date IS NULL');
      $this->db->where('petition_basic.lm_note_yn IS NULL');
      $this->db->where('petition_basic.is_pending', 'Y');
      $this->db->where('petition_basic.status !=', 'D');
      $this->db->where('petition_basic.mut_type =', '03');      

      if($zone_status == 4){
        $this->db->where('petition_basic.es_flag', 0);        
      }
      else {
        $this->db->where('petition_basic.es_flag', 1);  
      }

      $res= $this->db->get('petition_basic')->result();

      $cc = array();

      foreach($res as $r) {

        if(!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) 
        {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100*$remain_days)/$r->co_target_days;

          //green zone
          if(($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if(($zone_status == 2) && (($perct_avail<YELLOW_ZONE) && ($perct_avail>RED_ZONE))) { 
            $cc[] = 1;
          }
          //red zone
          else if(($zone_status == 3) && ($perct_avail<=RED_ZONE)) {
            $cc[] = 1;
          }
          else if($zone_status == 4) {
            $cc[] = 1;
          }
        }
        else {
          $cc[] = 1;
        }
      }

      $data['total_records']= count($cc); 
      return $data;
    }
  }

  public function getRevOfficePartitionCasesForLm($dist_code,$subdiv_code,$cir_code,$lot_no,$mouza,$start,$length,$order,$define_date,$searchByCol_0, $zone_status)
  {
    $curr_date = date('Y-m-d');
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
      0   => 'petition_basic.petition_no',
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
      $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }
    $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('petition_basic.dist_code', $dist_code);
    $this->db->where('petition_basic.subdiv_code', $subdiv_code);
    $this->db->where('petition_basic.cir_code', $cir_code);
    $this->db->where('petition_basic.lot_no', $lot_no);
    $this->db->where('petition_basic.mouza_pargona_code', $mouza);
    $this->db->where('petition_basic.lm_note_yn IS NULL');
    $this->db->where('petition_basic.mut_type', '04');
    $this->db->where('petition_basic.order_passed IS NULL');
    $this->db->where('petition_basic.is_pending', 'Y');

    if($zone_status == 4){
      $this->db->where('petition_basic.es_flag', 0);        
    }
    else {
      $this->db->where('petition_basic.es_flag', 1);  
    }
    
    $this->db->limit($length, $start);
    $query = $this->db->get('petition_basic');
    log_message('error',"petition_basic: ".$this->db->last_query());

    if($query->num_rows()>0){
    
      $data_results = $query->result();
      $final_array = array();

      foreach($data_results as $rr)
      {
        $variable = $this->Escalationmodel->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

        if(!empty($variable)){
          $final_array[] = $variable;
        }
      }

      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);

      if(!empty($searchByCol_0)){
        $this->db->like('case_no', strtoupper($searchByCol_0));
      }


      $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
      
      $this->db->where('petition_basic.dist_code', $dist_code);
      $this->db->where('petition_basic.subdiv_code', $subdiv_code);
      $this->db->where('petition_basic.cir_code', $cir_code);
      $this->db->where('petition_basic.lot_no', $lot_no);
      $this->db->where('petition_basic.mouza_pargona_code', $mouza);
      $this->db->where('petition_basic.lm_note_yn IS NULL');
      $this->db->where('petition_basic.mut_type', '04');
      $this->db->where('petition_basic.order_passed IS NULL');
      $this->db->where('petition_basic.is_pending', 'Y');    

      if($zone_status == 4){
        $this->db->where('petition_basic.es_flag', 0);        
      }
      else {
        $this->db->where('petition_basic.es_flag', 1);  
      }

      $res= $this->db->get('petition_basic')->result();

      $cc = array();

      foreach($res as $r) {

        if(!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) 
        {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100*$remain_days)/$r->co_target_days;

          //green zone
          if(($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if(($zone_status == 2) && (($perct_avail<YELLOW_ZONE) && ($perct_avail>RED_ZONE))) { 
            $cc[] = 1;
          }
          //red zone
          else if(($zone_status == 3) && ($perct_avail<=RED_ZONE)) {
            $cc[] = 1;
          }
          else if($zone_status == 4) {
            $cc[] = 1;
          }
        }
        else {
          $cc[] = 1;
        }
      }

      $data['total_records']= count($cc); 
      return $data;
    }
  }

  

  //get reverted pending reclassification cases in LM end
  public function getRevertReclassCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
  {
    $curr_date = date('Y-m-d');
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
      0 => 't_reclassification.proposal_no',
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
      $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }
    $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('mouza_pargona_code', $mouza);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('t_reclassification.status', 'M');

    if($zone_status == 4){ // for old cases
      $this->db->where('t_reclassification.es_flag','0');
    }
    else {
      $this->db->where('t_reclassification.es_flag', '1');
    }

    $this->db->order_by('proposal_no', 'asc');

    $this->db->limit($length, $start);
    $query = $this->db->get('t_reclassification');

    // echo $this->db->last_query();

    log_message('error', "#6384 = t_reclassification : ". $this->db->last_query());
    if($query->num_rows()>0){
      $data_results = $query->result();
      $final_array = array();
      foreach($data_results as $rr)
      {
        $variable = $this->Escalationmodel->escalationZoneWiseSearchReclassification($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->registerd_on, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->proposal_no, $rr->lm_date, $rr->dag_no);
        if(!empty($variable)){
          $final_array[] = $variable;
        }
      }
      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);
      if(!empty($searchByCol_0)){
        $this->db->like('case_no', strtoupper($searchByCol_0));
      }
      $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');

      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('mouza_pargona_code', $mouza);
      $this->db->where('lot_no', $lot_no);
      $this->db->where('t_reclassification.status', 'M');

      if($zone_status == 4){ // for old cases
        $this->db->where('t_reclassification.es_flag','0');
      }
      else {
        $this->db->where('t_reclassification.es_flag', '1');
      }

      $this->db->order_by('proposal_no', 'asc');

      $res= $this->db->get('t_reclassification')->result();
      log_message('error', '#6442 '.$this->db->last_query());
      $cc = array();
      foreach($res as $r) {
        if(!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1))
        {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100*$remain_days)/$r->lm_target_days;
          //green zone
          if(($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if(($zone_status == 2) && (($perct_avail<YELLOW_ZONE) && ($perct_avail>RED_ZONE))) {
            $cc[] = 1;
          }
          //red zone
          else if(($zone_status == 3) && ($perct_avail<=RED_ZONE)) {
            $cc[] = 1;
          }
          else if($zone_status == 4) {
            $cc[] = 1;
          }
        }
        else {
          $cc[] = 1;
        }
      }
      $data['total_records']= count($cc);
      return $data;
    }
  }








}
?>