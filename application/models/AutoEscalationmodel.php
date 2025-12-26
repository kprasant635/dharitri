<?php
class AutoEscalationmodel extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->model('Escalationmodel');
    $this->load->model('basundhara/basundharamodel');
  }

  public function DashboardData($case_no,$penUser,$rmrk){
    $this->dbb = $this->load->database('dash', TRUE);
    $base=array(
      'pending_with_user' => $penUser,
      'date_of_update'    => date("Y-m-d h:i:s"),
    );
    $this->dbb->where('case_no',$case_no);
    $this->dbb->update('dashboard_data',$base);

    $this->db->where('case_no',$case_no);
    $this->db->update('dashboard_data',$base);

    $action= array(
      'case_no'              => $case_no,
      'user_code'            => $this->session->userdata('user_code'),
      'date_of_action_taken' => date("Y-m-d h:i:s"),
      'user_designation'     => $this->session->userdata('user_desig_code'),
      'remark'               => $rmrk,
      'ip_address'           => $this->utilityclass->get_client_ip(),
    );
    $this->dbb->insert('dashboard_action',$action);
    $this->db->insert('dashboard_action',$action);
  }

  // from petition basic for first proceeding
  public function getPendingDetailOfCoFromPetitionBasicForFirstProceeding()
  {
    $remain_days     = '';
    $executionDate   = date('Y-m-d');
    $user_code       = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code       = $this->session->userdata('dist_code');
    $subdiv_code     = $this->session->userdata('subdiv_code');
    $cir_code        = $this->session->userdata('cir_code');
    $define_date     = define_date;
    $trans_type      = '02';

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('date(date_entry) >=', $define_date);
    $this->db->where('petition_basic.status', null);
    $this->db->where('comp_serv_yn', null);
    $this->db->where('not_fresh', null);
    $this->db->where('lm_note_yn', null);
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d h:i:s', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $assigned_to_other = $this->Escalationmodel->getPendingOfficer($row->dist_code, $row->subdiv_code,
          $row->cir_code, 'AST');
          $assigned_to = $this->Escalationmodel->getPendingOfficerLM($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no);
          $hearing_date = null;
          $user_type = 'CO';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'LM';
          $assigned_to_other_type = 'AST';
          $finalStatus = null;
          $assigned_to_other = $assigned_to_other->user_code;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[1]->CODE;
          $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
          $assignment_type=null;
          $assignment_type_other = $assignment_type_list[0]->CODE;
          $allocation_days = 0;

          $escalationUpdateStatus = $this->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR71: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        $is_escalated = 0;

        //get from petition_proceeding
        $proceeding_id = $this->db->query("SELECT count(proceeding_id)+1 as pid FROM  
                          petition_proceeding where case_no=? AND dist_code=? AND subdiv_code=? 
                            AND cir_code=?", array($row->case_no, $row->dist_code, $row->subdiv_code, $row->cir_code))->row()->pid;
        if ($proceeding_id == null) {
          $proceeding_id = 1;
        }

        // var_dump($this->db->last_query());

        $co_order = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                    $this->utilityclass->getMouzaName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code)
                    . " মৌজা ৰ " . $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code) .
                    " গাৱৰ মাটিত নামজাৰী বিচাৰিছে |"
                    . "ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন  কৰি  দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব  |";

        //insert into petition_proceeding
        $data = array(
          'case_no'              => $row->case_no,
          'proceeding_id'        => $proceeding_id,
          'date_of_hearing'      => $new_hearing_date,
          'co_order'             => $co_order,
          'next_date_of_hearing' => $new_hearing_date,
          'status'               => null,
          'user_code'            => $user_code,
          'date_entry'           => date('Y-m-d G:i:s'),
          'dist_code'            => $row->dist_code,
          'cir_code'             => $row->cir_code,
          'subdiv_code'          => $row->subdiv_code,
          'operation'            => 'E'
        );
        $tstatus1=$this->db->insert("petition_proceeding", $data); //********************                
        if ($tstatus1 != 1 )
        {
          $this->db->trans_rollback();
          log_message("error", "#ERR115, Insertion failed in petition_proceeding: ".$this->db->last_query());
          return;
        }

        $location_append = " dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                              AND lot_no=? AND vill_townprt_code=?";    

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET 
                                      is_escalated=?, next_date_of_hearing=?, 
                                      trans_code=?, not_fresh=?, status=?
                                      WHERE petition_no=? AND case_no=?
                                      AND is_escalated=? AND $location_append", 
                                        array(0, $new_hearing_date, $trans_type, 'Y', 'P', 
                                          $row->petition_no, $row->case_no, 0, $row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR132: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }

        $firstParty = $this->db->query("SELECT * FROM petitioner WHERE $location_append AND 
                        petition_no=?", array($row->dist_code, $row->subdiv_code, $row->cir_code, 
                          $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, 
                          $row->petition_no));

        $secondParty = $this->db->query("SELECT * FROM petition_pattadar WHERE $location_append AND 
                        petition_no=?", array($row->dist_code, $row->subdiv_code, $row->cir_code, 
                          $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, 
                          $row->petition_no));

        $query = "SELECT count(notified_id)+1 as cunt FROM petition_notified 
                    WHERE $location_append AND petition_no=?";
        $notified_id = $this->db->query($query, array($row->dist_code, $row->subdiv_code, $row->cir_code, 
                          $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, 
                          $row->petition_no))->row()->cunt;

        // insert into petition_notified
        if($firstParty->num_rows() > 0){
          foreach ($firstParty->result() as $app) {
            $noticeData = array(
              'dist_code'          => $row->dist_code,
              'subdiv_code'        => $row->subdiv_code,
              'cir_code'           => $row->cir_code,
              'lot_no'             => $row->lot_no,
              'mouza_pargona_code' => $row->mouza_pargona_code,
              'vill_townprt_code'  => $row->vill_townprt_code,
              'petition_no'        => $row->petition_no,
              'notified_id'        => $notified_id++,
              'notified_name'      => $app->pet_name,
              'add1'               => $app->add1,
              'add2'               => $app->add2,
              'user_code'          => $this->session->userdata('user_code'),
              'date_entry'         => date('Y-m-d G:i:s'),
              'operation'          => 'E',
              'year_no'            => date('Y'),
            );
            $tstatus2 = $this->db->insert("petition_notified", $noticeData);
            if ($tstatus2 != 1 )
            {
              $this->db->trans_rollback();
              log_message("error", "#ERR177, Insertion failed in petition_notified for first party: ". $this->db->last_query());
              return;
            }
          }
        }

        // insert into petition_notified 
        if($secondParty->num_rows() > 0){ 
          foreach ($secondParty->result() as $app) {
            $noticeData = array(
              'dist_code'          => $row->dist_code,
              'subdiv_code'        => $row->subdiv_code,
              'cir_code'           => $row->cir_code,
              'lot_no'             => $row->lot_no,
              'mouza_pargona_code' => $row->mouza_pargona_code,
              'vill_townprt_code'  => $row->vill_townprt_code,
              'petition_no'        => $row->petition_no,
              'notified_id'        => $notified_id++,
              'notified_name'      => $app->pdar_name,
              'add1'               => $app->pdar_add1,
              'add2'               => $app->pdar_add2,
              'user_code'          => $this->session->userdata('user_code'),
              'date_entry'         => date('Y-m-d G:i:s'),
              'operation'          => 'E',
              'year_no'            => date('Y')
            );
            $tstatus3 = $this->db->insert("petition_notified", $noticeData);
            if ($tstatus3 != 1 )
            {
              $this->db->trans_rollback();
              log_message("error", "#ERR208, Insertion failed in petition_notified for second party: ". $this->db->last_query());
              return;
            }
          }
        }

        $penUser = 'AST';
        $rmrk    = 'First Proceeding given by CO';
        $this->DashboardData($row->case_no, $penUser, $rmrk);
        //////////////////////////
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($row->case_no);
        if($basundharaExist){
          $rmk    = 'Forwarded to LM';
          $status = 'M';
          $task   = 'CO';
          $pen    = 'LM';
          $case   = $row->case_no;
          $this->basundharamodel->postApiBasundharaSec($row->case_no, $rmk, $status, $task, $pen); 
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  // from petition basic for second proceeding
  public function getPendingDetailOfCoFromPetitionBasicForSecondProceeding()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('date(date_entry) >=', $define_date);
    $this->db->where('petition_basic.status', 'P');
    $this->db->where('comp_serv_yn', null);
    $this->db->where('not_fresh', 'Y');
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');
    // echo $this->db->last_query();
    // return $query->result();

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1){
          $executionDate = $executionDate;
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $hearing_date = null;
          $user_type = 'CO';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = null;
          $finalStatus = 'final';
          $assigned_to_other = null;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[6]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR152: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        $is_escalated = 0;

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET is_escalated=? 
                                  WHERE petition_no=? AND case_no=? AND is_escalated=?", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR164: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  // from field mut basic for field mutation
  public function getPendingDetailOfCoFromFieldMutBasicForMutation()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('field_mut_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('order_passed', null);
    $this->db->where('date(date_entry) >=', $define_date);
    $this->db->where('is_dispose', null);
    $this->db->where('mut_type', '01');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('field_mut_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $hearing_date = null;
          $user_type = 'CO';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = null;
          $finalStatus = 'final';
          $assigned_to_other = null;
          $task= json_decode(FMUT_TASK);
          $taskid = $task[3]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
          
          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR230: Updation failed in field_mut_basic '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days == 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update field_mut_basic table
        $updateFieldMutBasic = $this->db->query("UPDATE field_mut_basic SET is_escalated=? 
                                  WHERE petition_no=? AND case_no=? AND is_escalated=?", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR242: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        } 
      }
    }
    $this->db->trans_commit();
    return;
  }

  // from misc case basic for name cancellation first proceeding
  public function getPendingDetailOfCoFromMiscCaseBasicFirstProcess() 
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('misc_case_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','misc_case_basic.misc_case_no=escalation_details.case_no','left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('add_to_officer', $user_code);
    $this->db->where('misc_case_basic.status', '01');
    $this->db->where('lm_note_yn', null);
    $this->db->where('sk_note_yn', null);
    $this->db->where('notice_generated_yn', null);
    $this->db->where('fresh_yn', 'Y');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('misc_case_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $allocation_days = 0;
          $assigned_to_other = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'AST');
          $assigned_to     = $this->Escalationmodel->getPendingOfficerLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
          $hearing_date    = null;
          $user_type       = 'CO';
          $service_code    = '8';
          $assigned_to_code   = $assigned_to->user_code;
          $assigned_user_type = 'LM';
          $assigned_to_other_type = 'AST';
          $finalStatus        = null;
          $assigned_to_other  = $assigned_to_other->user_code;
          $task= json_decode(NCAN);
          $taskid = $task[1]->CODE;
          $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
          $assignment_type=$assignment_type_list[0]->CODE;;
          $assignment_type_other = $assignment_type_list[0]->CODE;

          $escalationUpdateStatus = $this->escalationMatrixUpdateNCAN($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR311: Updation failed in field_mut_basic '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update misc_case_basic table
      $updateNameCancellation = $this->db->query("UPDATE misc_case_basic SET 
                                is_escalated=?, next_date_of_hearing=? 
                                WHERE misc_case_petition_no=? AND misc_case_no=? AND is_escalated=? ", 
                                  array($is_escalated, $new_hearing_date, $row->petition_no, $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR323: Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }

  // from misc case basic for name cancellation second proceeding
  public function getPendingDetailOfCoFromMiscCaseBasicSecondProcess() 
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('misc_case_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','misc_case_basic.misc_case_no=escalation_details.case_no','left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('add_to_officer', $user_code);

    $this->db->where("misc_case_basic.status IN ('10','02')");
    $this->db->where('operation !=', 'E');
    $this->db->where('misc_case_type', '07');
    $this->db->where('lm_note_yn', 'Y');
    $this->db->where('sk_note_yn', 'Y');
    $this->db->where('submission_date >=', $define_date);
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('misc_case_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $hearing_date = null;
          $user_type = 'CO';
          $service_code = '8';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = null;
          $finalStatus = 'final';
          $assigned_to_other = null;
          $task= json_decode(NCAN);
          $taskid = $task[5]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;

          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR415: Updation failed in misc_case_basic for second proceeding '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update misc_case_basic table
      $updateNameCancellation = $this->db->query("UPDATE misc_case_basic SET is_escalated=? 
                                  WHERE misc_case_petition_no=? AND misc_case_no=? AND is_escalated=? ", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR431: Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }

  // from legacy_correction for name/area correction
  public function getPendingDetailOfCoFromLegacyForAreaNameCorrection()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('legacy_correction.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','legacy_correction.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('legacy_correction.status', 'C');
    $this->db->where("service_type IN ('A','N')");
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('legacy_correction');
    // echo $this->db->last_query();
    return $query->result();
  }

  // from legacy_correction for mobile updation
  public function getPendingDetailOfCoFromLegacyForMobileUpdation()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('legacy_correction.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','legacy_correction.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('legacy_correction.status', 'A');
    $this->db->where('service_type', 'M');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('legacy_correction');
    // echo $this->db->last_query();
    // return $query->result();

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $assigned_to_other = null;
          $hearing_date = null;
          $user_type = 'CO';
          $service_code = '20';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = null;
          $assigned_to_other_type = null;
          $finalStatus = 'final';
          // $assigned_to_other = $assigned_to_other->user_code;
          $task = json_decode(MCOR);
          $taskid = $task[1]->CODE;
          $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
          $assignment_type = null;
          $assignment_type_other = $assignment_type_list[0]->CODE;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->escalationMatrixUpdateMCOR($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR522: Updation failed in legacy_correction for second proceeding '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update legacy_correction table
      $updateNameCancellation = $this->db->query("UPDATE legacy_correction SET is_escalated=? 
                                  WHERE petition_no=? AND case_no=? AND is_escalated=? ", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR538: Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }


  // pending applications reclassification 
  public function getPendingDetailOfCoFromReclassification()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('t_reclassification.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','t_reclassification.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where("(t_reclassification.status != 'R' and t_reclassification.status!='M' OR t_reclassification.status is null OR t_reclassification.status='C')");
    $this->db->where('es_flag', '1');
    $this->db->where('lm_yn IS NOT NULL');
    $this->db->where('co_yn', null);
    $this->db->where('dc_yn', null);
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('t_reclassification');

    // echo $this->db->last_query();
    // return $query->result();

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficerADC($dist_code,$subdiv_code,$cir_code,'ADC');
          $user_type = 'CO';
          $service_code = '4';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'ADC';
          $assigned_to_other_type = null;
          $finalStatus = null;
          $assigned_to_other = null;
          $hearing_date = null;
          $task= json_decode(RECLASS);
          $taskid = $task[2]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateReclass($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR608: Updation failed in t_reclassification '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update legacy_correction table
      $updateNameCancellation = $this->db->query("UPDATE t_reclassification SET is_escalated=? 
                                  WHERE proposal_no=? AND case_no=? AND is_escalated=? ", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR624
          : Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }

  // ===========================================================================================

  // office mutation LM
  public function getPendingDetailOfLmFromPetitionBasic()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $lot_no = $this->session->userdata('lot_no');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $define_date = define_date;

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    $this->db->where('date(date_entry) >=', $define_date);

    $this->db->where('petition_basic.status', 'P');
    $this->db->where('lm_note_date', null);
    $this->db->where('not_fresh', 'Y');
    $this->db->where('sk_comment', null);
    $this->db->where('order_passed', null);
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'SK');
          $user_type = 'LM';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'SK';
          $assigned_to_other_type = null;
          $finalStatus = null;
          $assigned_to_other = null;
          $hearing_date = null;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[3]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR700: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days == 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET 
                                    is_escalated=? WHERE petition_no=? AND case_no=?
                                      AND is_escalated=?", array($is_escalated, $row->petition_no, $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR715: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  // field mutation LM
  public function getPendingDetailOfLmFromFieldMutBasicForMutation()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $lot_no = $this->session->userdata('lot_no');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $define_date = define_date;
    $this->db->select('field_mut_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');
    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    $this->db->where('mut_type', '01');
    $this->db->where('es_flag', '1');
    //$this->db->where('is_escalated', 0);
    $query = $this->db->get('field_mut_basic');
    //return $this->db->last_query();
    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        //echo $remain_days."-".$row->escalated_date."-".$executionDate."<br>";
        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $user_type = 'LM';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = null;
          $finalStatus = null;
          $assigned_to_other = null;
          $hearing_date = null;
          $task= json_decode(FMUT_TASK);
          $taskid = $task[1]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
          
          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR783: Updation failed in field_mut_basic '.$this->db->last_query());
            $this->db->trans_rollback();
            return "944";
          }
        }

        // if($remain_days == 1) 
        // { 
        //   $is_escalated = 0; 
        // }
        // else 
        // { 
        //   $is_escalated = 1;
        // }

        //update field_mut_basic table
        $updateFieldMutBasic = $this->db->query("UPDATE field_mut_basic SET is_escalated=? 
                                  WHERE petition_no=? AND case_no=? AND is_escalated=?", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR798: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        } 
      }
    }
    $this->db->trans_commit();
    return "success";
  }

  // name cancellation LM
  public function getPendingDetailOfLmFromMiscCaseBasic() 
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $lot_no      = $this->session->userdata('lot_no');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $define_date = define_date;

    $this->db->select('misc_case_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','misc_case_basic.misc_case_no=escalation_details.case_no','left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('mouza_pargona_code', $mouza_pargona_code);

    $this->db->where('lm_note_yn', null);
    $this->db->where('next_date_of_hearing IS NOT NULL');
    $this->db->where('misc_case_basic.status !=', 'F');
    $this->db->where('fresh_yn', 'Y');
    $this->db->where('date(submission_date) >=', $define_date);
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('misc_case_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $user_type = 'LM';
          $service_code = '8';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = "LMRevert";
          $finalStatus = null;
          $assigned_to_other = null;
          $task= json_decode(NCAN);
          $taskid = $task[7]->CODE;
          $assignment_type=null;
          $hearing_date = null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR870: Updation failed in misc_case_basic '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update misc_case_basic table
      $updateNameCancellation = $this->db->query("UPDATE misc_case_basic SET 
                                is_escalated=? WHERE misc_case_petition_no=? AND misc_case_no=? AND is_escalated=? ", array($is_escalated, 
                                  $row->petition_no, $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR886: Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }

  // reclassification LM
  public function getPendingDetailOfLmFromReclassification()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $lot_no      = $this->session->userdata('lot_no');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $define_date = define_date;

    $this->db->select('t_reclassification.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details','t_reclassification.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    
    $this->db->where('t_reclassification.lm_code', null);
    $this->db->where('t_reclassification.lm_yn', null);
    $this->db->where('t_reclassification.lm_date', null);
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('t_reclassification');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row){

        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $executionDate = $executionDate;
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $user_type = 'LM';
          $service_code = '4';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = null;
          $finalStatus = null;
          $assigned_to_other = null;
          $hearing_date = null;
          $task= json_decode(RECLASS);
          $taskid = $task[1]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateRECLASS($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR956: Updation failed in t_reclassification '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }
      }

      if($remain_days == 1) { $is_escalated = 0; }
      else { $is_escalated = 1; }

      //update legacy_correction table
      $updateNameCancellation = $this->db->query("UPDATE t_reclassification SET is_escalated=? 
                                  WHERE proposal_no=? AND case_no=? AND is_escalated=? ", 
                                    array($is_escalated, $row->petition_no,  $row->case_no, 0));

      if($this->db->affected_rows() <= 0) {
        log_message('error', '#ERR972 : Updation failed '.$this->db->last_query());
        $this->db->trans_rollback();
        return;
      } 
    }
    $this->db->trans_commit();
    return;
  }

  // ===========================================================================================

  // office mutation notice generate DA
  public function getPendingDetailOfNoticeGenerateOfDaFromPetitionBasic()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('date(date_entry) >=', $define_date);

    $this->db->where('petition_basic.status', 'P');
    $this->db->where('notice_generated_yn', null);
    $this->db->where('not_fresh', 'Y');
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $user_type = 'AST';
          $service_code = '1';
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'AST';
          $assigned_to_other_type = "Notice";
          $finalStatus = null;
          $assigned_to_other = null;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[2]->CODE;
          $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
          $assignment_type=null;
          $assignment_type_other = $assignment_type_list[0]->CODE;
          $allocation_days = 0;
          $hearing_date = $row->next_date_of_hearing;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR1046: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days == 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET 
                                    is_escalated=? WHERE petition_no=? AND case_no=?
                                      AND is_escalated=?", array($is_escalated, $row->petition_no, $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR1061: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  // office mutation action taken DA
  public function getPendingDetailOfActionTakenOfDaFromPetitionBasic()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('date(date_entry) >=', $define_date);

    $this->db->where('petition_basic.status !=', 'F');
    $this->db->where('proceeding_yn', null);
    $this->db->where('not_fresh', 'Y');
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          
          $user_type = 'AST';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = 'Action';
          $finalStatus = null;
          $assigned_to_other = null;
          $hearing_date = null;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[4]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR1128: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days == 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET 
                                    is_escalated=? WHERE petition_no=? AND case_no=?
                                      AND is_escalated=?", array($is_escalated, $row->petition_no, $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR1143: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  // ===========================================================================================

  // office mutation SK
  public function getPendingDetailOfSkFromPetitionBasic()
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');
    $define_date = define_date;

    $this->db->select('petition_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('date(date_entry) >=', $define_date);

    $this->db->where('petition_basic.status !=', 'D');
    $this->db->where('sk_comment', null);
    $this->db->where('lm_note_date IS NOT NULL');
    $this->db->where('not_fresh', 'Y');
    $this->db->where('order_passed', null);
    $this->db->where('mut_type', '03');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);
    $query = $this->db->get('petition_basic');

    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->Escalationmodel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $user_type = 'SK';
          $service_code = '1';
          $assigned_to_code = $assigned_to->user_code;
          $assigned_user_type = 'CO';
          $assigned_to_other_type = 'SKReport';
          $finalStatus = null;
          $assigned_to_other = null;
          $task= json_decode(OMUT_TASK);
          $taskid = $task[5]->CODE;
          $assignment_type=null;
          $assignment_type_other = null;
          $allocation_days = 0;
          $hearing_date = $row->next_date_of_hearing;

          $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($row->case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR1217: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days == 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update petition_basic table
        $updatePetitionBasic = $this->db->query("UPDATE petition_basic SET 
                                    is_escalated=? WHERE petition_no=? AND case_no=?
                                      AND is_escalated=?", array($is_escalated, $row->petition_no, $row->case_no, 0));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR1232: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }
  // ===========================================================================================  
  //auto escalation generic method
  public function autoEscalatePendingCases()
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    //return $user_desig_code;
    // log_message('error', '#1248: User designation code '.$user_desig_code);
    // var_dump($user_desig_code);
    // $escalation = json_decode($this->getPendingDetailsFromBasicTablesByUserCodeForEscalationCases());
    $this->db->trans_begin();
    if($user_desig_code == 'CO')
    {
      $this->getPendingDetailOfCoFromPetitionBasicForFirstProceeding(); // omut first process
      $this->getPendingDetailOfCoFromPetitionBasicForSecondProceeding(); // omut second process
      $this->getPendingDetailOfCoFromFieldMutBasicForMutation(); // field mutation
      $this->getPendingDetailOfCoFromMiscCaseBasicFirstProcess(); // name cancellation first process
      $this->getPendingDetailOfCoFromMiscCaseBasicSecondProcess(); // name cancellation second process
      $this->getPendingDetailOfCoFromLegacyForMobileUpdation(); // mobile updation
      $this->getPendingDetailOfCoFromReclassification(); // reclassification
    }
    else if($user_desig_code == 'LM')
    {
      $this->getPendingDetailOfLmFromPetitionBasic(); // office mutation 
      $this->autoEscalateLmCasesToCoForOfficeMutation(); // office mutation auto escalation
      $this->getPendingDetailOfLmFromFieldMutBasicForMutation(); // field mutation
      $this->getPendingDetailOfLmFromMiscCaseBasic(); // name cancellation
      $this->getPendingDetailOfLmFromReclassification(); // reclassification

      $this->AutoEscalatePartition->autoEscalationFieldPartFromLmToCo(); // field partition



    }
    // else if($user_desig_code == 'AST')
    // {
    //   $this->getPendingDetailOfNoticeGenerateOfDaFromPetitionBasic(); // office mutation notice generate
    //   $this->getPendingDetailOfActionTakenOfDaFromPetitionBasic(); // office mutation action taken
    // }
    // else if($user_desig_code == 'SK')
    // {
    //   $this->getPendingDetailOfSkFromPetitionBasic(); // office mutation
    // }

    if($this->db->trans_status() != true){
      $this->db->trans_rollback();
      return;
    }

    $this->db->trans_commit();
    return "Auto Escalation Successfull";
  }

  public function escalationMatrixUpdateOMUT($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){

    $petition_no = $this->Escalationmodel->getPetitionNo($case_no,$service_code,'OMUT');

    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);

    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }


    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'OMUT');

    
    if($assigned_user_type == 'AST'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->da_target_days;
      $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);

    }elseif($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);


    }elseif($assigned_user_type == 'SK'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysSK,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);


    }elseif($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);


    }

    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;
      if($assigned_to_other != null){
        //this is designed for CO first proceding as assigned to LM and DA==========
        $entryTimes = 1;
        //////////

        $assigned_other_date = $executionDate;
        if($assigned_to_other_type == 'LM'){
          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
          $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }elseif($assigned_to_other_type == 'AST'){
          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
          $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }


        
      }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes,
        'assignment_type_other' => $assignment_type_other,
        'assigned_other'     => $assigned_to_other,
        'assigned_other_code' => $assigned_other_code,
        'assigned_other_date' => $assigned_other_date,
        'assigned_other_es_date' => $assigned_other_es_date,
        'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
      );

    }
    if($user_type == 'AST'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$escalatedRowDetailsAgainstPetitionno->assigned_other_date);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

      if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
      }

      $da_target_days    = $escalatedRowDetailsAgainstPetitionno->da_target_days;
      log_message("error","DA-TARGET_DAYS=======".$da_target_days);
      $da_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
      if($da_target_days < $da_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      

      $updateArray = array(
        'taskid' => $taskid,
        // 'da_target_days'     => $da_target_days,
        'da_completed_days'  => (int) $da_completed_days + (int) $previousCompletedDays,
        'da_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'da_date_code_list'  => $dateCodes,
      );

      //this code use only while Asistant generate notice==============
      if($assigned_to_other_type == 'Notice'){


          //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
          $previousCompletedDaysDA = $da_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
          //end==============
          log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);


          $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
          unset($updateArray['assigned_from']);
          unset($updateArray['assigned_from_code']);
          unset($updateArray['assigned_to_code']);
          unset($updateArray['assigned_to']);
          unset($updateArray['assigned_date']);
          unset($updateArray['escalated_date']);
          $updateArray['assigned_other_date']= $hearing_date;
          $updateArray['to_be_other_completed_within_days'] = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
          $updateArray['assigned_other_es_date'] = $assigned_other_es_date;


      }
      //// end====================
      //this code use only while Asistant generate Action Taken==============
      if($assigned_to_other_type == 'Action'){

        

        unset($updateArray['assigned_from']);
        unset($updateArray['assigned_from_code']);
        unset($updateArray['assigned_to_code']);
        unset($updateArray['assigned_to']);
        unset($updateArray['assigned_date']);
        unset($updateArray['escalated_date']);
        $updateArray['history_id_others'] = null;
        $updateArray['assignment_type_other'] = null;
        $updateArray['assigned_other'] = null;
        $updateArray['assigned_other_code'] = null;
        $updateArray['assigned_other_date']= null;
        $updateArray['assigned_other_es_date'] = null;
        $updateArray['to_be_other_completed_within_days'] = null;

        $checkSKReportDoneorNot =$escalatedRowDetailsAgainstPetitionno->assigned_to_code;
        if($checkSKReportDoneorNot == 6){
          $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
          $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
          $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
          $updateArray['assigned_date']  = $executionDate;
          $updateArray['escalated_date'] = $escalatedDate;
        }
        
      }
      //// end====================

    }

    if($user_type == 'SK'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);


      $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $sk_target_days    = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
      $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
      if($sk_target_days < $sk_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      

      //this calculation is for assigning CO from SK and taking hearing date as assigned date====
      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);


      ///end==============

      
      //if action taken done then co assigned date is sk report date 
      //otherwise co report date is action taken date

      $checkDAActionTakenDoneOrNot = $escalatedRowDetailsAgainstPetitionno->assigned_other;
      if($checkDAActionTakenDoneOrNot == null){
        $hearing_date = $executionDate;
        $assigned_other_es_date = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      }



      $updateArray = array(
        'taskid'             => $taskid,
        'sk_completed_days'  => (int) $sk_completed_days + (int) $previousCompletedDays,
        'sk_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        // 'assigned_date'      => $executionDate,
        'assigned_date'      => $hearing_date,
        'escalated_date'     => $assigned_other_es_date,
        'sk_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      log_message("error","CO==============SK".json_encode($updateArray));


    }

    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }

      // if($assigned_to_other_type == 'LMRevert'){
      //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
      //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
      //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      //   $executionDate = $hearing_date;
      //   $escalatedDate = $assigned_other_es_date;
      // }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'lm_completed_days'  => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'lm_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================

    $updateFlag =true;
    if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        $updateFlag = false;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
    }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    }

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'     => $executionDate,
        'escalated_status'    => $escalate_status,
        'completion_days'     => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );
 

    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){
        if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
          $executionDate = $hearing_date;
          $escalatedDate = $assigned_other_es_date;
        }
        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'date_code'      =>  $date_history,
          'petition_no'     => $petition_no,
          'service_code'    => $service_code,
          'taskid'          => $taskid,
          'pending_officer' => $assigned_to,
          'assigned_user'   => $user_code,
          'assigned_user_code' => $assigned_from_code,
          'assigned_to'     => $assigned_to,
          'assigned_to_code'=> $assigned_to_code,
          'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
          'allocation_date' => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'       => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'=> $escalate_status,
          'created_date'    => date('Y-m-d H:i:s'),
          'updated_date'    => date('Y-m-d H:i:s'),
        );
        if($finalStatus == 'final'){
          $insertDateArray['completion_date'] = $executionDate; 
        }
        log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($updateFlag == true){
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        }
        
    }else{
      $status=1;
    }



    //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
    if($entryTimes == 1){
      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'date_code'       => $date_history,
        'petition_no'     => $petition_no,
        'service_code'    => $service_code,
        'taskid'          => $taskid,
        'pending_officer' => $assigned_to_other,
        'assigned_user'   => $user_code,
        'assigned_user_code' => $assigned_from_code,
        'assigned_to'     => $assigned_to_other,
        'assigned_to_code'=> $assigned_other_code,
        'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
        'allocation_date' => $assigned_other_date,
        'target_completion_date' => $assigned_other_es_date,
        'date_diff'       => $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate),
        'escalated_status'=> $escalate_status,
        'created_date'    => date('Y-m-d H:i:s'),
        'updated_date'    => date('Y-m-d H:i:s'),
      );
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      $where_history_set = array(
        'petition_no' => $petition_no,
      );
      
      $updateDatesArraySet = array(
          'history_id_others'     => $date_history,
      );
      $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    }
    
    
    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }

  public function escalationMatrixUpdateFMUT($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){
    

    $petition_no = $this->Escalationmodel->getPetitionNo($case_no,$service_code,'FMUT');
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////
    
    $doubleEntry =0;

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);

    log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }


    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'FMUT');

    
    if($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);


    }elseif($assigned_user_type == 'SK'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysSK,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
      // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);


    }elseif($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    }

    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;

      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes
      );

    }

    if($user_type == 'SK'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);


      $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $sk_target_days    = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
      $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
      if($sk_target_days < $sk_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      

      //this calculation is for assigning CO from SK and taking hearing date as assigned date====
      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      ///end==============


      $updateArray = array(
        'taskid'             => $taskid,
        'sk_completed_days'  => (int) $sk_completed_days + (int) $previousCompletedDays,
        'sk_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        // 'assigned_date'      => $executionDate,
        'assigned_date'      => $hearing_date,
        'escalated_date'     => $assigned_other_es_date,
        'sk_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      log_message("error","CO==============SK".json_encode($updateArray));


    }

    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }

      // if($assigned_to_other_type == 'LMRevert'){
      //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
      //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
      //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      //   $executionDate = $hearing_date;
      //   $escalatedDate = $assigned_other_es_date;
      // }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'lm_completed_days'  => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'lm_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================

    // $updateFlag =true;
    // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
    //     $updateFlag = false;
    //     $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
    // }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    // }

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'     => $executionDate,
        'escalated_status'    => $escalate_status,
        'completion_days'     => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );

    // old01082023
    // if($finalStatus == 'final'){

    //   $updateArray['final_completion_date']= $executionDate;
    //   $updateArray['status']= 'F';

    // }
    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){
        // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
        //   $executionDate = $hearing_date;
        //   $escalatedDate = $assigned_other_es_date;
        // }

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'date_code'      =>  $date_history,
          'petition_no'     => $petition_no,
          'service_code'    => $service_code,
          'taskid'          => $taskid,
          'pending_officer' => $assigned_to,
          'assigned_user'   => $user_code,
          'assigned_user_code' => $assigned_from_code,
          'assigned_to'     => $assigned_to,
          'assigned_to_code'=> $assigned_to_code,
          'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
          'allocation_date' => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'       => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'=> $escalate_status,
          'created_date'    => date('Y-m-d H:i:s'),
          'updated_date'    => date('Y-m-d H:i:s'),
        );
        // if($finalStatus == 'final'){
        //   $insertDateArray['completion_date'] = $executionDate; 
        // }
        log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($updateFlag == true){
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        }
        
    }else{
        $status = 1;
    }

    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }

  public function escalationMatrixUpdateNCAN($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){
    

    $petition_no = $this->Escalationmodel->getPetitionNoNCAN($case_no);
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////
    


    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }


    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'NCAN');

    
    if($assigned_user_type == 'AST'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->da_target_days;
      $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    }elseif($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);


    }elseif($assigned_user_type == 'SK'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysSK,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
      // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);


    }elseif($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);


    }
    $doubleEntry = 0;
    $entryTimes= 0;
    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;

      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;
      if($assigned_to_other != null){
        //this is designed for CO first proceding as assigned to LM and DA==========
        $entryTimes = 1;
        //////////

        $assigned_other_date = $executionDate;
        if($assigned_to_other_type == 'LM'){

          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
          $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
          // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }elseif($assigned_to_other_type == 'AST'){

          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
          $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
          // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }


        
      }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes,
        'assignment_type'    => $assignment_type,
        'assignment_type_other' => $assignment_type_other,
        'assigned_other'     => $assigned_to_other,
        'assigned_other_code' => $assigned_other_code,
        'assigned_other_date' => $assigned_other_date,
        'assigned_other_es_date' => $assigned_other_es_date,
        'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
      );

    }
    if($user_type == 'AST'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$escalatedRowDetailsAgainstPetitionno->assigned_other_date);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

      if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
      }

      $da_target_days    = $escalatedRowDetailsAgainstPetitionno->da_target_days;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
      log_message("error","DA-TARGET_DAYS=======".$da_target_days);
      $da_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
      if($da_target_days < $da_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      

      $updateArray = array(
        'taskid' => $taskid,
        'da_completed_days'  => (int) $da_completed_days + (int) $previousCompletedDays,
        'da_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'da_date_code_list'  => $dateCodes,
      );

      //this code use only while Asistant generate notice==============
      if($assigned_to_other_type == 'Notice'){


          //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
          $previousCompletedDaysDA = $da_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
          //end==============
          log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);


          $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
          unset($updateArray['assigned_from']);
          unset($updateArray['assigned_from_code']);
          unset($updateArray['assigned_to_code']);
          unset($updateArray['assigned_to']);
          unset($updateArray['assigned_date']);
          unset($updateArray['escalated_date']);
          $updateArray['assigned_other_date']= $hearing_date;
          $updateArray['to_be_other_completed_within_days'] = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
          $updateArray['assigned_other_es_date'] = $assigned_other_es_date;


      }
      //// end====================
      //this code use only while Asistant generate Action Taken==============


      if($assigned_to_other_type == 'Action'){

        unset($updateArray['assigned_from']);
        unset($updateArray['assigned_from_code']);
        unset($updateArray['assigned_to_code']);
        unset($updateArray['assigned_to']);
        unset($updateArray['assigned_date']);
        unset($updateArray['escalated_date']);
        $updateArray['history_id_others'] = null;
        $updateArray['assignment_type_other'] = null;
        $updateArray['assigned_other'] = null;
        $updateArray['assigned_other_code'] = null;
        $updateArray['assigned_other_date']= null;
        $updateArray['assigned_other_es_date'] = null;
        $updateArray['to_be_other_completed_within_days'] = null;

        $checkLMReportDoneorNot =$escalatedRowDetailsAgainstPetitionno->assigned_to_code;
        if($checkLMReportDoneorNot == 6){
          $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
          $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
          // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
          $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
          $updateArray['assigned_date']  = $executionDate;
          $updateArray['escalated_date'] = $escalatedDate;
        }
        
      }
      //// end====================

    }

    if($user_type == 'SK'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);


      $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $sk_target_days    = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
      $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
      if($sk_target_days < $sk_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      

      //this calculation is for assigning CO from SK and taking hearing date as assigned date====
      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      ///end==============


      $updateArray = array(
        'taskid'             => $taskid,
        'sk_completed_days'  => (int) $sk_completed_days + (int) $previousCompletedDays,
        'sk_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        // 'assigned_date'      => $executionDate,
        'assigned_date'      => $hearing_date,
        'escalated_date'     => $assigned_other_es_date,
        'sk_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      log_message("error","CO==============SK".json_encode($updateArray));


    }


    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }

      

      //this calculation is for assigning CO from SK and taking hearing date as assigned date====
      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
      $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);


      if($assigned_to_other_type == 'LMRevert'){
        //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
        $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
        $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
        $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
        $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
        $assigned_other_es_date = $escalatedDate;
        $hearing_date = $executionDate;
      }
      ///end==============


      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'lm_completed_days'  => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $hearing_date,
        'escalated_date'     => $assigned_other_es_date,
        'lm_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================

    $updateFlag =true;
    if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        $updateFlag = false;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
    }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    }

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'     => $executionDate,
        'escalated_status'    => $escalate_status,
        'completion_days'     => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );
    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){
        if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
          $executionDate = $hearing_date;
          $escalatedDate = $assigned_other_es_date;
        }
        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'date_code'      =>  $date_history,
          'petition_no'     => $petition_no,
          'service_code'    => $service_code,
          'taskid'          => $taskid,
          'pending_officer' => $assigned_to,
          'assigned_user'   => $user_code,
          'assigned_user_code' => $assigned_from_code,
          'assigned_to'     => $assigned_to,
          'assigned_to_code'=> $assigned_to_code,
          'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
          'allocation_date' => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'       => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'=> $escalate_status,
          'created_date'    => date('Y-m-d H:i:s'),
          'updated_date'    => date('Y-m-d H:i:s'),
        );
        // if($finalStatus == 'final'){
        //   $insertDateArray['completion_date'] = $executionDate; 
        // }
        log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($updateFlag == true){
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        }
        
    }else{
        $status = 1;
    }



    //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
    if($entryTimes == 1){
      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'date_code'       => $date_history,
        'petition_no'     => $petition_no,
        'service_code'    => $service_code,
        'taskid'          => $taskid,
        'pending_officer' => $assigned_to_other,
        'assigned_user'   => $user_code,
        'assigned_user_code' => $assigned_from_code,
        'assigned_to'     => $assigned_to_other,
        'assigned_to_code'=> $assigned_other_code,
        'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
        'allocation_date' => $assigned_other_date,
        'target_completion_date' => $assigned_other_es_date,
        'date_diff'       => $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate),
        'escalated_status'=> $escalate_status,
        'created_date'    => date('Y-m-d H:i:s'),
        'updated_date'    => date('Y-m-d H:i:s'),
      );
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      $where_history_set = array(
        'petition_no' => $petition_no,
      );
      
      $updateDatesArraySet = array(
          'history_id_others'     => $date_history,
      );
      $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    }
    
    
    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }

  public function escalationMatrixUpdateANCOR($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){
    

    $petition_no = $this->Escalationmodel->getPetitionNoANCOR($case_no);
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////
    


    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }


    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'ACOR');

    $doubleEntry =0;
    if($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);


    }elseif($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);


    }

    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;
      if($assigned_to_other != null){
        //this is designed for CO first proceding as assigned to LM and DA==========
        $entryTimes = 1;
        //////////

        $assigned_other_date = $executionDate;
        if($assigned_to_other_type == 'LM'){

          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
          $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }elseif($assigned_to_other_type == 'AST'){

          $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
          $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
          $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDA,$originalAllocation);
          $assigned_other_es_date = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
          $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$executionDate);
        }


        
      }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes,
        'assignment_type'    => $assignment_type,
        'assignment_type_other' => $assignment_type_other,
        'assigned_other'     => $assigned_to_other,
        'assigned_other_code' => $assigned_other_code,
        'assigned_other_date' => $assigned_other_date,
        'assigned_other_es_date' => $assigned_other_es_date,
        'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
      );

    }


    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }



      // //this calculation is for assigning CO from SK and taking hearing date as assigned date====
      // $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      // $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      // $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // // $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      // $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      // $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      // ///end==============


      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'lm_completed_days'  => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'lm_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================


    $updateFlag = true;
    $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );
    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){

      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'date_code'              => $date_history,
        'petition_no'            => $petition_no,
        'service_code'           => $service_code,
        'taskid'                 => $taskid,
        'pending_officer'        => $assigned_to,
        'assigned_user'          => $user_code,
        'assigned_user_code'     => $assigned_from_code,
        'assigned_to'            => $assigned_to,
        'assigned_to_code'       => $assigned_to_code,
        'registerd_on'           => $escalatedRowDetailsAgainstPetitionno->registerd_on,
        'allocation_date'        => $executionDate,
        'target_completion_date' => $escalatedDate,
        'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        'escalated_status'       => $escalate_status,
        'created_date'           => date('Y-m-d H:i:s'),
        'updated_date'           => date('Y-m-d H:i:s'),
      );

      log_message("error","escalate_dates_status======".json_encode($insertDateArray));
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($updateFlag == true){
        $where_history_set = array(
          'petition_no' => $petition_no,
        );
        $updateDatesArraySet = array(
          'history_id'     => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
      }        
    }
    else{
      $status = 1;
    }

    
    
    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }

  public function escalationMatrixUpdateMCOR($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){
    

    $petition_no = $this->Escalationmodel->getPetitionNoMCOR($case_no);
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    // echo $this->db->last_query();
    log_message('error', '#3033: '.json_encode($escalatedRowDetailsAgainstPetitionno));
    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }

    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'MCOR');

    $doubleEntry =0;
    if($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
    }

    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;
    
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes,
        'assignment_type'    => $assignment_type,
        'assignment_type_other' => $assignment_type_other,
        'assigned_other'     => $assigned_to_other,
        'assigned_other_code' => $assigned_other_code,
        'assigned_other_date' => $assigned_other_date,
        'assigned_other_es_date' => $assigned_other_es_date,
        'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================


    $updateFlag = true;
    $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'     => $executionDate,
        'escalated_status'    => $escalate_status,
        'completion_days'     => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );
    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){

      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'date_code'              =>  $date_history,
        'petition_no'            => $petition_no,
        'service_code'           => $service_code,
        'taskid'                 => $taskid,
        'pending_officer'        => $assigned_to,
        'assigned_user'          => $user_code,
        'assigned_user_code'     => $assigned_from_code,
        'assigned_to'            => $assigned_to,
        'assigned_to_code'       => $assigned_to_code,
        'registerd_on'           => $escalatedRowDetailsAgainstPetitionno->registerd_on,
        'allocation_date'        => $executionDate,
        'target_completion_date' => $escalatedDate,
        'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        'escalated_status'       => $escalate_status,
        'created_date'           => date('Y-m-d H:i:s'),
        'updated_date'           => date('Y-m-d H:i:s'),
      );

      log_message("error","escalate_dates_status======".json_encode($insertDateArray));
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($updateFlag == true){
        $where_history_set = array(
          'petition_no' => $petition_no,
        );
        $updateDatesArraySet = array(
          'history_id'     => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
      }
        
    }else{
      $status = 1;
    }
    
    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }

  public function escalationMatrixUpdateReclass($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days){
    

    $petition_no = $this->Escalationmodel->getPetitionNoRECLASS($case_no);
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////
    
    $doubleEntry =0;

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);

    log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

    $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if($value->USER == $user_type){
        $assigned_from_code = $value->CODE;
      }
      if($value->USER == $assigned_user_type){
        $assigned_to_code = $value->CODE;
      }
      if($value->USER == $assigned_to_other_type){
        $assigned_other_code = $value->CODE;
      }
    }


    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'RECLASS');

    
    if($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);
      // $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);


    }elseif($assigned_user_type == 'CO'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      // $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);


    }elseif($assigned_user_type == 'ADC'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
      $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysADC,$originalAllocation);
      // $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
    }elseif($assigned_user_type == 'DC'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
      $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
      // $escalatedDate        = $this->Escalationmodel->getEscalatedDate($remaining_days_other);
      $escalatedDate        = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);
    }


    $dateCode    = $this->Escalationmodel->generateDateCode();
    log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);

    if($user_type == 'ADC'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->adc_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;

      $adc_target_days    = $escalatedRowDetailsAgainstPetitionno->adc_target_days;

      log_message("error","========ADC-TARGET_DAYS =======".$adc_target_days);

      $adc_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========ADC-COMPLETION_DAYS=======".$adc_completed_days);
      if($adc_target_days < $adc_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;

      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'adc_completed_days'  => (int) $adc_completed_days + (int) $previousCompletedDays,
        'adc_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'adc_date_code_list'  => $dateCodes
      );

    }


    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      $latestHistoryCode = $dateCodes;
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }
      $entryTimes= 0;
      $doubleEntry = 0;
      $assigned_other_date = null;
      $to_be_other_completed_within_days = null;
      $assigned_other_es_date = null;

      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      
      $updateArray = array(
        'taskid' => $taskid,
        'co_completed_days'  => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status' => $escalate_status,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'  => $dateCodes
      );

    }


    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }

      // if($assigned_to_other_type == 'LMRevert'){
      //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
      //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      //   $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      //   $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      //   $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      //   $executionDate = $hearing_date;
      //   $escalatedDate = $assigned_other_es_date;
      // }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'lm_completed_days'  => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'lm_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    if($user_type == 'DC'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->dc_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
      $dc_target_days    = $escalatedRowDetailsAgainstPetitionno->dc_target_days;


      log_message("error","DC-TARGET_DAYS=======".$dc_target_days);
      $dc_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      log_message("error","DC-COMPLETION_DAYS=======".$dc_completed_days);
      if($dc_target_days < $dc_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      log_message("error","DC-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null){
        $dateCodes = $dateCode;
      }else{
        $dateCodes = $dateCodes.','.$dateCode;
      }

      // if($assigned_to_other_type == 'LMRevert'){
      //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
      //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      //   $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      //   $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      //   $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date,$hearing_date);
      //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      //   $executionDate = $hearing_date;
      //   $escalatedDate = $assigned_other_es_date;
      // }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'             => $taskid,
        'dc_completed_days'  => (int) $dc_completed_days + (int) $previousCompletedDays,
        'dc_escalate_status' => $escalate_status,
        'assigned_from'      => $user_code,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'        => $assigned_to,
        'assigned_to_code'   => $assigned_to_code,
        'assigned_date'      => $executionDate,
        'escalated_date'     => $escalatedDate,
        'dc_date_code_list'  => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

    }

    //UPDATE ESCALATION DATE HISTORY TABLE=====================

    // $updateFlag =true;
    // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
    //     $updateFlag = false;
    //     $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
    // }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    // }

    log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code' => $history_id,
      'service_code' => $service_code,
    );
    $updateDatesArray = array(
        'completion_date'     => $executionDate,
        'escalated_status'    => $escalate_status,
        'completion_days'     => $completion_days_for_history
    );

    $updateStatus22 = $this->db->update('escalation_dates_details',$updateDatesArray ,$where_history);
    log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());


    ///////////////END PROCESS//////////////////////////

    $where = array(
      'petition_no' => $petition_no
    );

    // old01082023
    // if($finalStatus == 'final'){

    //   $updateArray['final_completion_date']= $executionDate;
    //   $updateArray['status']= 'F';

    // }
    if($finalStatus == 'final'){
      unset($updateArray['assigned_to']);
      unset($updateArray['assigned_to_code']);
      unset($updateArray['assigned_from']);
      unset($updateArray['assigned_from_code']);
      unset($updateArray['assigned_date']);
      unset($updateArray['escalated_date']);
      unset($updateArray['to_be_completed_within_days']);


      $updateArray['assignment_type_other'] = null;
      $updateArray['assigned_other']     = null;
      $updateArray['assigned_other_code'] = null;
      $updateArray['assigned_other_date'] = null;
      $updateArray['assigned_other_es_date'] = null;
      $updateArray['to_be_other_completed_within_days'] = null;
      $updateArray['final_completion_date']= $executionDate;
      $updateArray['status']= 'F';

    }

    log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0){
       $flag = 0;
    }else{
       $flag = 1;
    }


    if($doubleEntry == 0 && $finalStatus == null){


        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'date_code'      =>  $date_history,
          'petition_no'     => $petition_no,
          'service_code'    => $service_code,
          'taskid'          => $taskid,
          'pending_officer' => $assigned_to,
          'assigned_user'   => $user_code,
          'assigned_user_code' => $assigned_from_code,
          'assigned_to'     => $assigned_to,
          'assigned_to_code'=> $assigned_to_code,
          'registerd_on'    => $escalatedRowDetailsAgainstPetitionno->registerd_on,
          'allocation_date' => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'       => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'=> $escalate_status,
          'created_date'    => date('Y-m-d H:i:s'),
          'updated_date'    => date('Y-m-d H:i:s'),
        );
  
        log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($updateFlag == true){
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        }
        
    }else{
        $status = 1;
    }

    
    
    log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
    //////////////////////END PROCESS////////////////////
    if($status !=1){
      $flag1 = 0;
    }else{
      $flag1 = 1;
    }
    if($flag==1 && $flag1 == 1){
      return $flag;
    }else{
      return 0;
    }
  }


  // *********************** added on 21082023

  // office mutation LM auto escalation
  public function autoEscalateLmCasesToCoForOfficeMutation() 
  {
    $remain_days = '';
    $executionDate = date('Y-m-d');
    $user_code = $this->session->userdata('user_code');
    $user_desig_code = $this->session->userdata('user_desig_code');

    // get all from escalation detail table
    $query = $this->db->query("SELECT * FROM escalation_details WHERE status=? AND 
                assigned_from_code=? AND assigned_to_code=? AND final_completion_date IS NULL 
                AND escalated_date < ? ", array('P', 6, 9, $executionDate));
    // echo $this->db->last_query();   

    if($query->num_rows() == 0){
      return;
    }

    foreach($query->result() as $row) {

      $history_id = $this->Escalationmodel->generateDateCode();

      // get total remaining days
      $getTotalLeftDays = $row->total_days - ($row->da_completed_days+$row->lm_completed_days+$row->co_completed_days);

      if($getTotalLeftDays > $row->total_days){
        return;
      }

      //get remaining days of CO
      $remainig_days_of_co = $row->co_target_days - $row->co_completed_days;
      if($remainig_days_of_co > 0){
        $escalate_date_of_co = date('Y-m-d', strtotime($executionDate. ' + '.$remainig_days_of_co.' days'));
      }

      $get_case_no = explode('/', $row->case_no);
      $get_type = $get_case_no[4];

      //check for office mutation cases
      if($get_type == 'OMUT') 
      {  
        $this->db->trans_begin();    

        //update escalation_detail table
        $this->db->query("UPDATE escalation_details SET 
                          assigned_from=?, 
                          assigned_from_code=?, 
                          assigned_to=?, 
                          assigned_date=?, 
                          escalated_date=?, 
                          history_id=?,
                          lm_escalate_status=?, 
                          lm_date_code_list=?,
                          to_be_completed_within=?
                          WHERE
                          case_no=? AND status=?",

                          array($row->assigned_to, $row->assigned_to_code, $row->assigned_from, $executionDate, $escalate_date_of_co, 
                            $history_id, 'Y', $history_id, $remainig_days_of_co, $row->case_no, 'P'));

        if($this->db->affected_rows() <= 0){
          log_message('error', '#ERR3867: Updation failed in escalation_details table '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }

        //get latest updated data from escalation_details
        $sql = $this->db->query("SELECT * FROM escalation_details WHERE case_no=?", 
                    array($row->case_no))->row();

        $task= json_decode(OMUT_TASK);
        $taskid = $task[8]->CODE;

        // insert into escalation_dates_details
        $insEscalationHistory = array(
          'date_code'              => $history_id,
          'petition_no'            => $sql->petition_no,
          'service_code'           => $sql->service_code,
          'taskid'                 => $taskid,
          'pending_officer'        => $sql->assigned_to,
          'assigned_user'          => $user_code,
          'assigned_user_code'     => $sql->assigned_from_code,
          'assigned_to'            => $sql->assigned_to,
          'assigned_to_code'       => $sql->assigned_to_code,
          'registerd_on'           => $sql->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalate_date_of_co,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalate_date_of_co,$executionDate),
          'escalated_status'       => 'Y',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );
        log_message("error","#ERR3898: escalate_dates_status ".json_encode($insEscalationHistory));
        $status = $this->db->insert('escalation_dates_details',$insEscalationHistory);

        if($status != 1 || $status != true){
          log_message('error', '#ERR3898: Insertion failed in escalation_dates_details table '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }

        //update petition_basic escalated flag
        $this->db->query("UPDATE petition_basic SET is_escalated=? WHERE case_no=? AND petition_no=?", 
                            array('1', $row->case_no, $row->petition_no));
        if($this->db->affected_rows() <= 0){
          log_message('error', '#ERR3911: Insertion failed in escalation_dates_details table '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }

        $this->db->trans_commit();
        return;
      }
    }
  }

  // displayEscalatedText($rows->es_flag, $escRow, 'field_mut_basic', $rows->case_no)

  // disable button for from auto escalated officer
  public function displayEscalatedText($esFlag, $escRow, $table, $case_no)
  {
    if($esFlag == 1 && ESCALATION_ENABLE == 1 && !empty($escRow)) 
    {
      // check if is escalated flag is 1 in basic table
      $serviceTable = $this->db->query("SELECT is_escalated FROM $table WHERE is_escalated=? 
                        AND case_no=?", array(1, $case_no));

      $officer_field_status = $this->checkEscalatedStatus($escRow->assigned_from_code);

      // check in escalation table
      $escTable = $this->db->query("SELECT * FROM escalation_details WHERE assigned_from_code=? 
                    AND $officer_field_status=? AND case_no=? AND assignment_type=?", 
                      array($escRow->assigned_from_code, 'Y', $case_no, $escRow->assignement_type));

      if($serviceTable->num_rows() != 0 && $escTable->num_rows() != 0)
      {
        return 'y';
      }
      return 'n';
    }      
  }

  // pending escalation status
  public function checkEscalatedStatus($user_type)
  {
    $esc_field_status = '';
    $user = json_decode(USER_ALLOT_CODE);
    // echo "<pre>";
    // var_dump($user[0]->CODE); die;
    
    if($user_type == $user[0]->CODE)  // DEPT
    {
      $esc_field_status = 'dept_escalate_status';
    }
    else if($user_type == $user[1]->CODE)  // DC
    {
      $esc_field_status = 'dc_escalate_status';
    }
    else if($user_type == $user[2]->CODE)  // ADC
    {
      $esc_field_status = 'adc_escalate_status';
    }
    else if($user_type == $user[4]->CODE)  // BO
    {
      $esc_field_status = 'bo_escalate_status';
    }
    else if($user_type == $user[5]->CODE)  // CO
    {
      $esc_field_status = 'co_escalate_status';
    }
    else if($user_type == $user[6]->CODE)  // SK
    {
      $esc_field_status = 'sk_escalate_status';
    }
    else if($user_type == $user[7]->CODE)  // AST
    {
      $esc_field_status = 'da_escalate_status';
    }
    else if($user_type == $user[8]->CODE)  // LM
    {
      $esc_field_status = 'lm_escalate_status';
    }
    else if($user_type == $user[9]->CODE)  // SRO
    {
      $esc_field_status = 'sro_escalate_status';
    }
    else if($user_type == $user[10]->CODE)  // MOUZADAR
    {
      $esc_field_status = 'mouzadar_escalate_status';
    }
    return $esc_field_status;
  }


  // get Officer by user code
  public function getOfficerByUserCode($user_code)
  {
    $user_type = '';
    $user = json_decode(USER_ALLOT_CODE);
    
    if($user_code == $user[0]->CODE)  // DEPT
    {
      $user_type = 'Department';
    }
    else if($user_code == $user[1]->CODE)  // DC
    {
      $user_type = 'DC';
    }
    else if($user_code == $user[2]->CODE)  // ADC
    {
      $user_type = 'ADC';
    }
    else if($user_code == $user[4]->CODE)  // BO
    {
      $user_type = 'BO';
    }
    else if($user_code == $user[5]->CODE)  // CO
    {
      $user_type = 'CO';
    }
    else if($user_code == $user[6]->CODE)  // SK
    {
      $user_type = 'SK';
    }
    else if($user_code == $user[7]->CODE)  // AST
    {
      $user_type = 'AST';
    }
    else if($user_code == $user[8]->CODE)  // LM
    {
      $user_type = 'LM';
    }
    else if($user_code == $user[9]->CODE)  // SRO
    {
      $user_type = 'SRO';
    }
    else if($user_code == $user[10]->CODE)  // MOUZADAR
    {
      $user_type = 'MOUZADAR';
    }
    return $user_type;
  }



  // ============================ added on 25/01/2023 ============================

  // check if the date is holiday
  public function getHoliday()
  {
    $date = date('Y-m-d');
    $query = $this->db->query("SELECT holiday_date FROM holiday_details WHERE holiday_date=?", array($date));
    return $query->num_rows();
  }

  // get to be escalate cases from assistant
  public function getToBeAutoEscalatedCasesOfAssistant()
  {


    $user_desig_code = $this->session->userdata('user_desig_code');
    $assigned_to = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    // if(ESCALATION_ALLOW_TIME ==1)
    // {
    // $currDate = date('Y-m-d H:i:s');
    // $currDateLast = date('Y-m-d 23:59:23');

    // $queryVal = $this->db->query("SELECT * FROM escalation_details WHERE assigned_other_es_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_other_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));


    // // log_message('error','AST-ESCALATE-QWERY---'.$this->db->last_query());

    // return $queryVal;
    // if(ESCALATION_ALLOW_TIME ==1)
    // {
    //   $currDate = date('Y-m-d H:i:s');
    //   return $this->db->query("SELECT * FROM escalation_details WHERE assigned_other_es_date < ? and status = ? and final_completion_date  is null", array($currDate,'P'));

    // }else
    // {
    //   $currDate = date('Y-m-d');
    //   return $this->db->query("SELECT * FROM escalation_details WHERE date(assigned_other_es_date) < ? and status = ? and final_completion_date  is null", array($currDate,'P'));

    // }

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      // $queryVal =  $this->db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));

      $queryVal = $this->db->query("SELECT * FROM escalation_details WHERE assigned_other_es_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_other_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
    }

    else
    {
      $currDate = date('Y-m-d');
      // $queryVal = $this->db->query("SELECT * FROM escalation_details WHERE date(escalated_date) < ? and status = ? and final_completion_date  is null", array($currDate,'P'));
      $queryVal =  $this->db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ( $escalate_status = ? or $escalate_status is null ) and assigned_other_code = ?", array($currDate,'P','N',$assigned_to));

    }
    log_message('error','##############ASTESCQUERY091######################'.$this->db->last_query());
    return $queryVal;
  }
  
  // get to be auto escalate cases from escalation_details
  public function getListOfToBeAutoEscalatedCases()
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $assigned_to = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      $queryVal =  $this->db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
    }

    else
    {
      $currDate = date('Y-m-d');
      // $queryVal = $this->db->query("SELECT * FROM escalation_details WHERE date(escalated_date) < ? and status = ? and final_completion_date  is null", array($currDate,'P'));
      $queryVal =  $this->db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,'P','N',$assigned_to));

    }
    log_message('error','09--'.$this->db->last_query());
    return $queryVal;
  }

  // ['CODE' => 1, 'USER' => 'DEPT'],
  //   ['CODE' => 2, 'USER' => 'DC'],
  //   ['CODE' => 3, 'USER' => 'ADC'],
  //   ['CODE' => 4, 'USER' => 'SDO'],
  //   ['CODE' => 5, 'USER' => 'BO'],
  //   ['CODE' => 6, 'USER' => 'CO'],
  //   ['CODE' => 7, 'USER' => 'SK'],
  //   ['CODE' => 8, 'USER' => 'AST'],
  //   ['CODE' => 9, 'USER' => 'LM'],
  //   ['CODE' => 10, 'USER' => 'SRO'],
  //   ['CODE' => 11, 'USER' => 'MOUZADAR'],

  // get all cases where escalated date is today for other users
  public function getTodayEscalatedList()
  {
    // 2,3,6,7,9 == DC, ADC, CO, SK, LM

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d');
      return $this->db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_to_code IN (2,3,6,7,9)", array($currDate,'P'));
    }else
    {
      $currDate = date('Y-m-d');
      return $this->db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_to_code IN (2,3,6,7,9)", array($currDate,'P'));
    }
    
  }

  // get all cases where escalated date is today for assistant
  public function getTodayEscalatedListOfAsistant()
  {
    // 8 == AST

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      return $this->db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_other_code = ?", array($currDate, 'P', 8));
    }
    else
    {
      $currDate = date('Y-m-d');
      return $this->db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_other_code = ?", array($currDate, 'P', 8));
    }
    
  }

  // auto escalate the cases to next officer
  public function autoEscalateToRespectiveOfficer()
  {
    $date = date('Y-m-d');
    $json = array();

    // ========== holiday check if auto escalation required starts here  =============
    $isHoliday = $this->getHoliday();

    $holidayInsertCountForTheDay = $this->checkHolidayInsertOrNot($date);
    log_message('error','HOLIDAY--INSERT--OR--NOT======='.json_encode($holidayInsertCountForTheDay));
    if($isHoliday == 1 && $holidayInsertCountForTheDay == 0)
    {
      $message = '';
      $holidayResp = $this->updateTablesIfHoliday();
      if($holidayResp == 'n')
      {
        log_message('error', "#ERR4122: Data updation failed  : ".json_encode($holidayResp));
        $message = 'Though data updation failed';
      }

      $statusHolidayInsert = $this->holidayInsertForTheDay($holidayResp);

      log_message('error', "#ERR4127: Auto escalation is not required as today is holiday : $date");
      $json = [
        'response'    => 3,
        'message'     => 'Auto escalation is not required !!! '.$message,
      ];
      return $json;
    }
    // ========== holiday check if auto escalation required ends here  ==========
    $otherResp = array();
    $failedCases = array();
    $successCases = array();
    // for other officer
    $otherResult = $this->getListOfToBeAutoEscalatedCases();
    log_message('error','AUTOESC DATA====================='.json_encode($otherResult->num_rows()));
    if($otherResult->num_rows() > 0)
    {
      $result = $otherResult->result();
      foreach($result as $row)
      {
        // $otherResp[] = $this->userWiseEscalation($row);
        $escalatedResponse = $this->userWiseEscalation($row);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row);
          $otherResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row);
          $otherResp[] = $row;
        }
      }
    }

    $asstResp = array();
    // for assistant
    $asstResult = $this->getToBeAutoEscalatedCasesOfAssistant();
    if($asstResult->num_rows() > 0)
    {
      $result = $asstResult->result();
      foreach($result as $row)
      {
        // $asstResp[] = $this->assistantEscalation($row);
        $escalatedResponse = $this->assistantEscalation($row);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row);
          $asstResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row);
          $asstResp[] = $row;
        }
      }
    } 

    $json = [
      'response'  => 3,
      'otherResp' => $otherResp,
      'asstResp'  => $asstResp,
      'message'   => 'Auto escalation successfull !!!',
    ];
    return $json;   
  }

  // auto escalation for other user
  public function userWiseEscalation($row)
  {
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->Escalationmodel->generateDateCode();
    $service_code_array   = [1,2,3,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no);
    $caseDetails  = $this->getCaseDetailsNoByCaseNo($table, $row->case_no);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate  = date('Y-m-d H:i');
      $escalatedDated = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      $executionDate  = date('Y-m-d H');
      $escalatedDated = date('Y-m-d 23',strtotime($row->escalated_date));
    }

    
    log_message('error','ESCALATED DATE===================='.$escalatedDated.'=========='.$executionDate);
    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      $executionDate= date('Y-m-d H:i:s');


      //if total time line is over then case will be out from escalation=========
      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no,$row->service_code);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F');
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERR4312 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR4312 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        log_message('error','#ERRORESC4321 : =======Case is out of escalation=='.$row->case_no);
        return $response;
      }

      ////////////////END///////////////////////


      log_message('error','######ESCALATESTART==========='.$row->case_no);
      // From LM to CO
      if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
      { 
        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = $row->assigned_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->lm_date_code_list;
        $previousCompletedDays = $row->lm_completed_days;
        $lm_target_days        = $row->lm_target_days;


        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
        // if($lm_target_days <= $lm_completed_days)
        // {   
        //   $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }
        
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[0]->CODE, // LM message
          'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
          'lm_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => $row->assigned_to_code,
          'assigned_to'                 => $row->assigned_from,
          'assigned_to_code'            => $row->assigned_from_code,
          'assigned_date'               => $executionDate,
          'escalated_date'              => $escalatedDate,
          'lm_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
          'petition_no' => $petition_no,
          'date_code'   => $history_id,
          'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate,
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $row->assigned_from,
          'assigned_to_code'       => $row->assigned_from_code,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
          return $response;
        }


        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'LM',
          'assigned_from_code'          => $row->assigned_to,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => $row->assigned_from,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107 : Insert Failed on escalation_cases_remark_status Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107 : Insert Failed on escalation_cases_remark_status Failed';
          return $response;
        }
      }

      // From SK to CO
      if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
      { 
        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = $row->assigned_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->sk_date_code_list;
        $previousCompletedDays = $row->sk_completed_days;
        $sk_target_days        = $row->sk_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
        $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","CO-COMPLETION_DAYS=======".$CO_completed_days);
        // if($sk_target_days <= $sk_completed_days)
        // {   
        //   $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }


        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }
        
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
          'sk_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => $row->assigned_to_code,
          'assigned_to'                 => $row->assigned_from,
          'assigned_to_code'            => $row->assigned_from_code,
          'assigned_date'               => $executionDate,
          'escalated_date'              => $escalatedDate,
          'sk_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $row->assigned_from,
          'assigned_to_code'       => $row->assigned_from_code,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4448 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4448 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'SK',
          'assigned_from_code'          => $row->assigned_to,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => $row->assigned_from,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR01071 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR01071 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      } 

      // From CO to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = $row->assigned_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
        // if($co_target_days <= $co_completed_days)
        // {   
        //   $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $dcUserDetails = $this->Escalationmodel->getPendingOfficerDC($caseDetails->dist_code,'DC');


        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => $row->assigned_to_code,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate,
          'escalated_date'              => $escalatedDate,
          'co_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => $row->assigned_to,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => $row->assigned_from,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR010712 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR010712 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From ADC to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = $row->assigned_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days        = $row->adc_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $adc_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
        // if($co_target_days <= $co_completed_days)
        // {   
        //   $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $dcUserDetails = $this->Escalationmodel->getPendingOfficerDC($caseDetails->dist_code,'DC');


        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'adc_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => $row->assigned_to_code,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate,
          'escalated_date'              => $escalatedDate,
          'adc_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERRADCDC4943 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERRADCDC4945 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERRADCDC4959 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERRADCDC4961 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERRADCDC4969 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERRADCDC4972 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => $row->assigned_to,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => $row->assigned_from,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERRADCDC4990 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERRADCDC4992 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From CO to DC for MUT/PART/NCAN/NCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $lastAssignedDate        = $row->assigned_date;
        $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        //new method calling for co escalation to DC==============
        //all remaining time will be allocated to DC as DC will resuffle the times to all users if escalated from co
        $lmRemainingDays = $row->lm_target_days - $row->lm_completed_days;
        if($lmRemainingDays == $row->lm_target_days)
        {
          $new_lm_target_days = 0;
          $new_lm_completed_days = 0;
        }
        else
        {
          $new_lm_target_days = $row->lm_completed_days;
          $new_lm_completed_days = $row->lm_completed_days;
        }
        $skRemainingDays = $row->sk_target_days - $row->sk_completed_days;
        if($skRemainingDays == $row->sk_target_days)
        {
          $new_sk_target_days = 0;
          $new_sk_completed_days = 0;
        }
        else
        {
          $new_sk_target_days = $row->sk_completed_days;
          $new_sk_completed_days = $row->sk_completed_days;
        }
        $coRemainingDays = $row->co_target_days - $co_completed_days;
        if($coRemainingDays == $row->co_target_days)
        {
          $new_co_target_days = 0;
          $new_co_completed_days = 0;
        }
        else
        {
          $new_co_target_days = $row->co_completed_days;
          $new_co_completed_days = $row->co_completed_days;
        }
        $daRemainingDays = $row->da_target_days - $row->da_completed_days;
        if($daRemainingDays == $row->da_target_days)
        {
          $new_da_target_days = 0;
          $new_da_completed_days = 0;
        }
        else
        {
          $new_da_target_days = $row->da_completed_days;
          $new_da_completed_days = $row->da_completed_days;
        }


        $total_remaining_days_for_dc = $lmRemainingDays + $skRemainingDays + $coRemainingDays + $daRemainingDays;
        log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->Escalationmodel->getTimeLine($row->service_code,$service_type,DEESCALATE);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR4677 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR4677 : De-escalation error';
            return $response;
          }


          $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
          $originalAllocation = $sumationOfTotalTime;

        }
        else
        {
          $originalAllocation = $total_remaining_days_for_dc;
        }


        $previousCompletedDaysDC = 0;



        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate        = $row->assigned_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
        // if($co_target_days < $co_completed_days)
        // {   
          $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }


          
        $dcUserDetails = $this->Escalationmodel->getPendingOfficerDC($caseDetails->dist_code,'DC');

        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE,
          'lm_target_days'              => (int) $new_lm_target_days,
          'lm_completed_days'           => (int) $new_lm_completed_days,
          'sk_target_days'              => (int) $new_sk_target_days,
          'sk_completed_days'           => (int) $new_sk_completed_days,
          'da_target_days'              => (int) $new_da_target_days,
          'da_completed_days'           => (int) $new_da_completed_days,
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => $row->assigned_to_code,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate,
          'escalated_date'              => $escalatedDate,
          'co_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
          'dc_target_days'              => $originalAllocation, // for DC new assigning days
          'dc_allocate_days'            => $originalAllocation, // dc allocate days
          'dc_completed_days'           => 0, //set Zero for Newly assigned
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }


        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => $row->assigned_to,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => $row->assigned_from,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107124 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107124 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }





        // if any user give report to officers===============sum of total time allocated to circle officer by dc


        // if lm sk ast did not give first proceeding to DC then dc will allocated the total time with resuffling==complete


        //if first total time is over then DC will deescalated to CO with new timeline



        ///================


          
    
        // this case is not under DC but it will pop up in dc escalated list==========
        //calculate maximum days from other users====

        // $lmRemainingDays = $row->lm_target_days - $row->lm_completed_days;
        // $skRemainingDays = $row->sk_target_days - $row->sk_completed_days;
        // $coRemainingDays = $row->co_target_days - $row->co_completed_days;
        // $daRemainingDays = $row->da_target_days - $row->da_completed_days;

        // $arrayDays = array(
        //   'lm' => $lmRemainingDays,
        //   'sk' => $skRemainingDays,
        //   'co' => $coRemainingDays,
        //   'da' => $daRemainingDays
        // );
        // $maxValue = max($arrayDays);
        // $maxIndex = array_search(max($arrayDays), $arrayDays);

        // log_message('error','******4659 : '.json_encode($maxValue,'---'.$maxIndex));

          

        //assigning max days to DC
        // $originalAllocation      = $maxValue;
        // $deEscalationUsed = false;
        // if($originalAllocation <= 0)
        // {
        //   $deEscalationUsed = true;
        //   // $originalAllocation = 2;
        //   ///get timeline from matrix version for de-escalation=================
        //   $timeLineForDeesc = $this->Escalationmodel->getTimeLine($row->service_code,$service_type,DEESCALATE);
        //   if(empty($timeLineForDeesc))
        //   {
        //     log_message("error","#ERR4677 : update Failed on escalation_details Failed=======");
        //     $response['responseType'] =0;
        //     $response['msg'] = '#ERR4677 : De-escalation error';
        //     return $response;
        //   }


        //   $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
        //   $originalAllocation = $sumationOfTotalTime;

        // }
        // else
        // {
        //   $originalAllocation = $maxValue;
        // }


        // if($deEscalationUsed == false)
        // {

        //   //update other users completed days as days are used by DC=========
        //   $updateField = $maxIndex.'_completed_days';

        //   if($maxIndex == 'lm')
        //   {
        //     $originalAllocation = $originalAllocation + $row->lm_completed_days;
        //   }
        //   else if($maxIndex == 'sk')
        //   {
        //     $originalAllocation = $originalAllocation + $row->sk_completed_days;
        //   }
        //   else if($maxIndex == 'co')
        //   {
        //     $originalAllocation = $originalAllocation + $row->co_completed_days;
        //   }
        //   else if($maxIndex == 'da')
        //   {
        //     $originalAllocation = $originalAllocation + $row->da_completed_days;
        //   }
        //   else if($maxIndex == 'adc')
        //   {
        //     $originalAllocation = $originalAllocation + $row->adc_completed_days;
        //   }
        //   else if($maxIndex == 'dc')
        //   {
        //     $originalAllocation = $originalAllocation + $row->dc_completed_days;
        //   }
        //   else if($maxIndex == 'bo')
        //   {
        //     $originalAllocation = $originalAllocation + $row->bo_completed_days;
        //   }
        //   else if($maxIndex == 'mouzadar')
        //   {
        //     $originalAllocation = $originalAllocation + $row->mouzadar_completed_days;
        //   }

        //   $statusUpdate = $this->updateDaysForDC($row->case_no,$originalAllocation,$updateField);
        //   if($statusUpdate != 1)
        //   {
        //     log_message("error","#ERR4680 : update Failed on escalation_details Failed=======".$this->db->last_query());
        //     $response['responseType'] =0;
        //     $response['msg'] = '#ERR4680 : Update Failed on escalation_details Failed';
        //     return $response;
        //   }

        // }
        


        // $previousCompletedDaysDC = 0;



        // $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        // $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        // $lastAssignedDate        = $row->assigned_date;

        // $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        // $dateCodes             = $row->co_date_code_list;
        // $previousCompletedDays = $row->co_completed_days;
        // $co_target_days        = $row->co_target_days;

        // // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        // $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
        // // if($co_target_days < $co_completed_days)
        // // {   
        //   $escalate_status = 'Y';
        // // }
        // // else{
        // //   $escalate_status = 'N';
        // // }

        // // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        // if($dateCodes == null)
        // {
        //   $dateCodes = $dateCode;
        // }
        // else
        // {
        //   $dateCodes = $dateCodes.','.$dateCode;
        // }


          
        // $dcUserDetails = $this->Escalationmodel->getPendingOfficerDC($caseDetails->dist_code,'DC');

        // $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        // $updateArray = array(
        //   'taskid'                      => $taskId[1]->CODE, // SK message
        //   'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
        //   'co_escalate_status'          => $escalate_status,
        //   'assigned_from'               => $row->assigned_to,
        //   'assigned_from_code'          => $row->assigned_to_code,
        //   'assigned_to'                 => $dcUserDetails->user_code,
        //   'assigned_to_code'            => 2,  //hard code for DC
        //   'assigned_date'               => $executionDate,
        //   'escalated_date'              => $escalatedDate,
        //   'co_date_code_list'           => $dateCodes,
        //   'to_be_completed_within_days' => $to_be_completed_within_days,
        //   'dc_target_days'              => $originalAllocation - $co_completed_days, // for DC new assigning days
        //   'dc_allocate_days'            => $originalAllocation - $co_completed_days, // dc allocate days
        //   'dc_completed_days'           => 0, //set Zero for Newly assigned
        // );

        // $updateFlag = true;
        // $history_id = $row->history_id;

        // // log_message("error","UPDATED FLAG ==========".$updateFlag);

        // //STEPS to be followed:
        // // 1. update escalation_dates_details against or history id
        // // 2. update escalation_details with new date codes without history id
        // // 3. insert history details and updated escalattion details with new history id

        // $where_history = array(
        // 'petition_no' => $petition_no,
        // 'date_code'   => $history_id
        // );
        // $updateDatesArray = array(
        // 'completion_date'  => $executionDate,
        // 'escalated_status' => $escalate_status,
        // 'completion_days'  => $completion_days_for_history
        // );

        // $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        // $where = array(
        //   'petition_no' => $petition_no
        // );

        // $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        // $date_history    = $this->Escalationmodel->generateDateCode();
        // $insertDateArray = array(
        //   'sr_no'                  => $dateCode,
        //   'date_code'              => $date_history,
        //   'petition_no'            => $petition_no,
        //   'service_code'           => $row->service_code,
        //   'taskid'                 => $taskId[3]->CODE,
        //   'pending_officer'        => $row->assigned_from,
        //   'assigned_user'          => $row->assigned_to,
        //   'assigned_user_code'     => $row->assigned_to_code,
        //   'assigned_to'            => $dcUserDetails->user_code,
        //   'assigned_to_code'       => 2,
        //   'registerd_on'           => $row->registerd_on,
        //   'allocation_date'        => $executionDate,
        //   'target_completion_date' => $escalatedDate,
        //   'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        //   'escalated_status'       => 'N',
        //   'created_date'           => date('Y-m-d H:i:s'),
        //   'updated_date'           => date('Y-m-d H:i:s'),
        // );

        // // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        // $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        // if($status != 1)
        // {
        //   log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        //   $response['responseType'] =0;
        //   $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
        //   return $response;
        // }
        // if($updateFlag == true)
        // {
        //   $where_history_set = array(
        //     'petition_no' => $petition_no,
        //   );
        //   $updateDatesArraySet = array(
        //     'history_id'     => $date_history,
        //   );
        //   $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        //   if($this->db->affected_rows() <= 0)
        //   {
        //     log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
        //     $response['responseType'] =0;
        //     $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
        //     return $response;
        //   }
        // }      
        
        // $updateTable = $this->updateServiceWiseTable($row->case_no);
        // if($updateTable == 'n')
        // {
        //   log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
        //   $response['responseType'] =0;
        //   $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
        //   return $response;
        // }


        // $insertRemarkArray = array(
        //   'case_no'                     => $row->case_no,
        //   'petition_no'                 => $row->petition_no,
        //   'assigned_from'               => 'CO',
        //   'assigned_from_code'          => $row->assigned_to,
        //   'assigned_to'                 => 'DC',
        //   'assigned_to_code'            => $row->assigned_from,
        //   'created_at'                  => date('Y-m-d H:i:s'),
        //   'updated_at'                  => date('Y-m-d H:i:s'),
        //   'remark_status'               => null
        // );

        // $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        // if($remarkInsertionStatus != 1)
        // {
        //   log_message("error","#ERR0107124 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        //   $response['responseType'] =0;
        //   $response['msg'] = '#ERR0107124 : Insert Failed on escalation_dates_details Failed';
        //   return $response;
        // }
      }
      // $escDataForStore = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($row->case_no);
      // return $escDataForStore;
      
    }
    return $response;
    log_message('error','ESCALATE---NOT---START==========='.$row->case_no);
  }

  public function updateDaysForDC($case_no,$allocation_days,$updateField){
        $sql = $this->db->query("update escalation_details set $updateField = '$allocation_days' where case_no = ? ",array($case_no));
        return $this->db->affected_rows();
    }

  // auto escalation for other user
  public function assistantEscalation($row)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->Escalationmodel->generateDateCode();
    $service_code_array = [1,2,3,6,8]; // other then reclass
    

    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no);


    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate= date('Y-m-d H:i');
      $escalatedDatedAst = date('Y-m-d H:i',strtotime($row->assigned_other_es_date));
    }
    else
    {

      $executionDate  = date('Y-m-d H');
      $escalatedDatedAst = date('Y-m-d 23',strtotime($row->assigned_other_es_date));
    }

    // From AST to CO
    log_message('error','AST======'.$executionDate.'==========='.$escalatedDatedAst);
    if($escalatedDatedAst == $executionDate)
    {
      $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no,$row->service_code);
      log_message('error','timeOffAst==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F');
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC5163 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC5163 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }
      
      if($row->assigned_other_code == 8 && in_array($row->service_code, $service_code_array)) 
      { 
        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = $row->assigned_other_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->da_date_code_list;
        $previousCompletedDays = $row->da_completed_days;
        $da_target_days        = $row->da_target_days;

        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $da_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
        // if($da_target_days < $da_completed_days)
        // {   
        //   $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }
        $case_prefix = explode('/',$row->case_no);
        if($case_prefix[4] == 'OMUT' || $case_prefix[4] == 'OPART')
        {
            $petDetails = $this->getPetitionDetails($row->case_no);
        }
        if($case_prefix[4] == 'MiND')
        {
            $petDetails = $this->getNcanDetailsByCaseNo($row->case_no);
        }
        
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // AST message
          'da_completed_days'           => (int) $da_completed_days + (int) $previousCompletedDays,
          'da_escalate_status'          => $escalate_status,
          'assigned_from_other'            => $row->assigned_other,
          'assigned_from_other_code'       => $row->assigned_other_code,
          'assigned_other'                 => 6,
          'assigned_other_code'            => $this->getPendingOfficer($petDetails->dist_code, $petDetails->subdiv_code, $petDetails->cir_code, 'CO'),
          'da_date_code_list'              => $dateCodes,
          'to_be_other_completed_within_days' => $to_be_completed_within_days,
        );

        $updateFlag = true;
        $history_id = $row->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
          'petition_no' => $petition_no,
          'date_code'   => $history_id,
          'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate,
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        // $insertDateArray = array(
        //   'sr_no'                  => $dateCode,
        //   'date_code'              => $date_history,
        //   'petition_no'            => $petition_no,
        //   'service_code'           => $row->service_code,
        //   'taskid'                 => $taskId[2]->CODE,
        //   'pending_officer'        => $this->Escalationmodel->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
        //   'assigned_user'          => $this->Escalationmodel->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
        //   'assigned_user_code'     => '6',
        //   'assigned_to'            => $row->assigned_other,
        //   'assigned_to_code'       => $row->assignment_type_other,
        //   'registerd_on'           => $row->registerd_on,
        //   'allocation_date'        => $executionDate,
        //   'target_completion_date' => $escalatedDate,
        //   'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        //   'escalated_status'       => $escalate_status,
        //   'created_date'           => date('Y-m-d H:i:s'),
        //   'updated_date'           => date('Y-m-d H:i:s'),
        // );

        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[2]->CODE,
          'pending_officer'        => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO'),
          'assigned_user'          => $row->assigned_other,
          'assigned_user_code'     => $row->assignment_type_other,
          'assigned_to'            => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO'),
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        log_message("error","ASTCES-ST======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4500 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4500 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR5000 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERR5000 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no);
        log_message("error","ASTCES-ST======updateTable".json_encode($updateTable));
        if($updateTable == 'n')
        {
          log_message("error","#ERR4736 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4736 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'DA',
          'assigned_from_code'          => $row->assigned_other,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO'),
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );


        $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107123 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107123 : Insert Failed on escalation_dates_details Failed';
          return $response;
          
        }
      }

      if($row->assigned_other_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $lastAssignedDate        = $row->assigned_other_date;
        $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        //new method calling for co escalation to DC==============
        //all remaining time will be allocated to DC as DC will resuffle the times to all users if escalated from co
        $lmRemainingDays = $row->lm_target_days - $row->lm_completed_days;
        if($lmRemainingDays == $row->lm_target_days)
        {
          $new_lm_target_days = 0;
          $new_lm_completed_days = 0;
        }
        else
        {
          $new_lm_target_days = $row->lm_completed_days;
          $new_lm_completed_days = $row->lm_completed_days;
        }
        $skRemainingDays = $row->sk_target_days - $row->sk_completed_days;
        if($skRemainingDays == $row->sk_target_days)
        {
          $new_sk_target_days = 0;
          $new_sk_completed_days = 0;
        }
        else
        {
          $new_sk_target_days = $row->sk_completed_days;
          $new_sk_completed_days = $row->sk_completed_days;
        }
        $coRemainingDays = $row->co_target_days - $co_completed_days;
        if($coRemainingDays == $row->co_target_days)
        {
          $new_co_target_days = 0;
          $new_co_completed_days = 0;
        }
        else
        {
          $new_co_target_days = $row->co_completed_days;
          $new_co_completed_days = $row->co_completed_days;
        }
        $daRemainingDays = $row->da_target_days - $row->da_completed_days;
        if($daRemainingDays == $row->da_target_days)
        {
          $new_da_target_days = 0;
          $new_da_completed_days = 0;
        }
        else
        {
          $new_da_target_days = $row->da_completed_days;
          $new_da_completed_days = $row->da_completed_days;
        }


        $total_remaining_days_for_dc = $lmRemainingDays + $skRemainingDays + $coRemainingDays + $daRemainingDays;
        log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->Escalationmodel->getTimeLine($row->service_code,$service_type,DEESCALATE);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR4677 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR4677 : De-escalation error';
            return $response;
          }


          $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
          $originalAllocation = $sumationOfTotalTime;

        }
        else
        {
          $originalAllocation = $total_remaining_days_for_dc;
        }


        $previousCompletedDaysDC = 0;



        $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate        = $row->assigned_other_date;

        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

        // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
        // if($co_target_days < $co_completed_days)
        // {   
          $escalate_status = 'Y';
        // }
        // else{
        //   $escalate_status = 'N';
        // }

        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }


          
        $dcUserDetails = $this->Escalationmodel->getPendingOfficerDC($caseDetails->dist_code,'DC');

        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE,
          'lm_target_days'              => (int) $new_lm_target_days,
          'lm_completed_days'           => (int) $new_lm_completed_days,
          'sk_target_days'              => (int) $new_sk_target_days,
          'sk_completed_days'           => (int) $new_sk_completed_days,
          'da_target_days'              => (int) $new_da_target_days,
          'da_completed_days'           => (int) $new_da_completed_days,
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from_other'         => $row->assigned_to,
          'assigned_from_other_code'    => $row->assigned_to_code,
          'assigned_other'              => $dcUserDetails->user_code,
          'assigned_other_code'         => 2,  //hard code for DC
          'assigned_other_date'         => $executionDate,
          'assigned_other_es_date'      => $escalatedDate,
          'co_date_code_list'           => $dateCodes,
          'to_be_other_completed_within_days' => $to_be_completed_within_days,
          'dc_target_days'              => $originalAllocation - $co_completed_days, // for DC new assigning days
          'dc_allocate_days'            => $originalAllocation - $co_completed_days, // dc allocate days
          'dc_completed_days'           => 0, //set Zero for Newly assigned
        );

        $updateFlag = true;
        $history_id = $row->history_id_others;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2. update escalation_details with new date codes without history id
        // 3. insert history details and updated escalattion details with new history id

        $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
        );
        $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no
        );

        $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => $row->assigned_to_code,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate,
          'target_completion_date' => $escalatedDate,
          'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id_others'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }


        // $insertRemarkArray = array(
        //   'case_no'                     => $row->case_no,
        //   'petition_no'                 => $row->petition_no,
        //   'assigned_from'               => 'CO',
        //   'assigned_from_code'          => $row->assigned_to,
        //   'assigned_to'                 => 'DC',
        //   'assigned_to_code'            => $row->assigned_from,
        //   'created_at'                  => date('Y-m-d H:i:s'),
        //   'updated_at'                  => date('Y-m-d H:i:s'),
        //   'remark_status'               => null
        // );

        // $remarkInsertionStatus = $this->db->insert('escalation_cases_remark_status',$insertRemarkArray);
        // if($remarkInsertionStatus != 1)
        // {
        //   log_message("error","#ERR0107124 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        //   $response['responseType'] =0;
        //   $response['msg'] = '#ERR0107124 : Insert Failed on escalation_dates_details Failed';
        //   return $response;
        // }
        
      }

    }
    return $response;

    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  public function checkTotalTimeIsOutorNot($case_no,$service_code)
  {
    ///////////checking total timeline////////////////////

    $service = $this->getServiceName($case_no);
    $totalTimeline = $this->getTotalTimeLine($service_code);

    $row = $this->getEscalatedRowDetailsCaseNo($case_no);

    $totalExecutionTime = $row->da_completed_days + $row->lm_completed_days + $row->sk_completed_days + $row->co_completed_days + $row->adc_completed_days + $row->dc_completed_days + $row->sro_completed_days + $row->bo_completed_days + $row->mouzadar_completed_days;
    log_message('error','checkTotalTimeIsOutorNot=================****'.$totalExecutionTime.'**********'.$totalTimeline);
    if($totalExecutionTime >= $totalTimeline)
    {
      return true;
    }
    else
    {
      return false;
    }

  }

  public function getEscalatedRowDetailsCaseNo($case_no)
  {
      $sql = $this->db->query("select * from escalation_details where case_no = ? ", array($case_no));
      return $sql->row();
  }


  public function getTotalTimeLine($service_code)
  {
      $sql = "Select sum(total_timeline) as tot_time from escalation_matrix where service_code=? ";
      $matrix = $this->db->query($sql, array($service_code))->row();
      if (isset($matrix) && !empty($matrix) && $matrix != null) {
          return $matrix->tot_time;
      } else {
          return null;
      }

  }

  // update table if escalated date is holiday
  public function updateTablesIfHoliday()
  {
    $currDate = date('Y-m-d');

    // get all cases where escalated date is today for other users
    $otherResp = $this->getTodayEscalatedList();
    log_message('error','updateTablesIfHoliday========ListCases====='.json_encode($otherResp));

    if($otherResp->num_rows() > 0)
    {
      $resp = $otherResp->result();

      foreach($resp as $row)
      {
        // update escalation_details table
        $updateArray = [          
          'escalated_date'              => date('Y-m-d H:i:s', strtotime($row->escalated_date. ' + 1 day')),
          'to_be_completed_within_days' => $row->to_be_completed_within_days + 1,
          'update_date'                 => date('Y-m-d H:i:s'),
          'total_days'                 => $row->total_days + 1,
        ];

        if($row->assigned_to_code == 2) { // DC
          $updateArray['dc_target_days'] = $row->dc_target_days + 1;
        }
        else if($row->assigned_to_code == 3) { // ADC
          $updateArray['adc_target_days'] = $row->adc_target_days + 1;
        }
        else if($row->assigned_to_code == 6) { // CO
          $updateArray['co_target_days'] = $row->co_target_days + 1;
        }
        else if($row->assigned_to_code == 7) { // SK
          $updateArray['sk_target_days'] = $row->sk_target_days + 1;
        }
        else if($row->assigned_to_code == 9) { // LM
          $updateArray['lm_target_days'] = $row->lm_target_days + 1;
        }

        $this->db->where('escalated_date', $currDate);
        $this->db->where('petition_no', $row->petition_no);
        $this->db->where_in('assigned_to_code', array(2,3,6,7,9));
        $this->db->update('escalation_details', $updateArray);

        if($this->db->affected_rows() != $otherResp->num_rows())
        {
          log_message('error', "#ERR4178: Updation failed. ".$this->db->last_query());
          return 'n';
        }
      }
      return 'y';
    } // end of $otherResp

    // get all cases where escalated date is today for assistant
    $asstResp = $this->getTodayEscalatedListOfAsistant();
    log_message('error','updateTablesIfHolidayASST========ListCases====='.json_encode($asstResp));
    if($asstResp->num_rows() > 0)
    {
      $resp = $asstResp->result();

      foreach($resp as $row)
      {
        // update escalation_details table
        $updateArray = [          
          'assigned_other_es_date'      => date('Y-m-d H:i:s', strtotime($row->assigned_other_es_date. ' + 1 day')),
          'to_be_other_completed_within_days' => $row->to_be_other_completed_within_days + 1,
          'da_target_days'              => $row->da_target_days + 1,
          'update_date'                 => date('Y-m-d H:i:s'),
          'total_days'                  => $row->total_days + 1,
        ];
        $this->db->where('assigned_other_es_date', $currDate);
        $this->db->where('petition_no', $row->petition_no);
        $this->db->where('assigned_other_code', 8);
        $this->db->update('escalation_details', $updateArray);

        if($this->db->affected_rows() != $asstResp->num_rows())
        {
          log_message('error', "#ERR4205: Updation failed. ".$this->db->last_query());
          return 'n';
        }
      }
      return 'y';
    } // end of $asstResp
    log_message('error','cases user holiday count==========='.$otherResp->num_rows().'==='.$asstResp->num_rows());
    if($otherResp->num_rows() == 0 && $asstResp->num_rows() == 0)
    {
      return 'n';
    }
  }

  // explode case name from case no
  public function getServiceName($case_no)
  {
    $get_case_no = explode('/', $case_no);
    return $get_type = $get_case_no[4];
  }


  public function getTableNameByServiceType($service_type)
  {
    $table = '';
    if($service_type == OMUT || $service_type == OPART || $service_type == CONV_SERV)
    {
      $table = 'petition_basic';
    }
    else if($service_type == FMUT || $service_type == FPART)
    {
      $table = 'field_mut_basic';
    }
    else if($service_type == ALLOT_SERV)
    {
      $table = 'allotment_cert_basic';
    }
    else if($service_type == RECLASS_SERV)
    {
      $table = 't_reclassification';
    }
    else if($service_type == MIND_SERV || $service_type == MINC_SERV)
    {
      $table = 'misc_case_basic';
    }
    else if($service_type == LEGACY_SERV || $service_type == ANCOR_SERV || $service_type == MCOR_SERV)
    {
      $table = 't_legacyupdation';
    }

    return $table;
  }


  // update servicewise table
  public function updateServiceWiseTable($case_no)
  {
    // get service name
    $service_type = $this->getServiceName($case_no);
    log_message('error','updateServiceWiseTable======'.$service_type);

    //update service wise table
    $table = $this->getTableNameByServiceType($service_type);
    log_message('error','updateServiceWiseTable1======'.$table);

    // update service table
    $case_no_val = 'case_no';
    if($table == 'misc_case_basic')
    {
      $case_no_val = 'misc_case_no';
    }

    $query = $this->db->query("UPDATE $table SET is_escalated=? WHERE $case_no_val=? 
                AND es_flag=?", array(1, $case_no, 1));
    log_message('error','updateServiceWiseTableQuery======'.$this->db->last_query());  
    if($this->db->affected_rows() != 1)
    {
      return 'n';
    }
    return 'y';
  }


  public function escalationMatrixBlock($case_no, $executionDate,$finalStatus)
  {
  
      $response = array('responseType' => 2,'msg'=>null);
      $where = array(
          'case_no' => $case_no
      );
      $updateDatesArray = array(
          'status' => $finalStatus,
          'final_completion_date' => $executionDate,
      );
      $updateStatus22 = $this->db->update('escalation_details', $updateDatesArray, $where);
      log_message("error","#ESCQUERY=======".$case_no);
      if ($this->db->affected_rows() <= 0) {
          $response['responseType'] = 1;
          $response['msg'] = '#ERRESCLATION78777721 : Updation failed on Escalation row not found';
          return $response;
      }
      $serviceResponse = $this->updateServiceWiseTableForBlockBeforeEscalation($case_no);
      if($serviceResponse == 'n')
      {
          $response['responseType'] = 1;
          $response['msg'] = '#ERRESCLATION78777821 : Updation failed on service wise table';
          return $response;
      }
      return $response;
  }

  public function updateServiceWiseTableForBlockBeforeEscalation($case_no)
  {
      // get service name
    $service_type = $this->getServiceNameForBlock($case_no);

    //update service wise table
    $table = $this->getTableNameByServiceTypeForBlock($service_type);
    if($table == 'misc_case_basic')
    {
      $case_no_val = ' misc_case_no ';
    }
    else
    {
      $case_no_val = ' case_no ';
    }
    // update service table
    $query = $this->db->query("UPDATE $table SET es_flag=? WHERE $case_no_val=?", array(0, $case_no));
    if($this->db->affected_rows() != 1)
    {
      return 'n';
    }
    return 'y';
  }

  public function getServiceNameForBlock($case_no)
  {
    $get_case_no = explode('/', $case_no);
    return $get_type = $get_case_no[4];
  }


  public function getTableNameByServiceTypeForBlock($service_type)
  {
    $table = '';
    if($service_type == OMUT || $service_type == OPART || $service_type == CONV_SERV)
    {
      $table = 'petition_basic';
    }
    else if($service_type == FMUT || $service_type == FPART)
    {
      $table = 'field_mut_basic';
    }
    else if($service_type == ALLOT_SERV)
    {
      $table = 'allotment_cert_basic';
    }
    else if($service_type == RECLASS_SERV)
    {
      $table = 't_reclassification';
    }
    else if($service_type == NCAN_SERV || $service_type == MIND_SERV || $service_type == MINC_SERV)
    {
      $table = 'misc_case_basic';
    }
    else if($service_type == LEGACY_SERV || $service_type == ANCOR_SERV || $service_type == MCOR_SERV)
    {
      $table = 't_legacyupdation';
    }

    return $table;
  }

  // get petition no
  public function getPetitionNoByCaseNo($table, $case_no)
  {
    // var_dump($table); die;


    if($table == 'misc_case_basic')
    {
      $query = $this->db->query("SELECT misc_case_petition_no FROM $table 
                  WHERE misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
    }
    else if($table == 't_reclassification' || $table == 't_legacyupdation')
    {
      $query = $this->db->query("SELECT proposal_no FROM $table 
                  WHERE case_no=?", array($case_no))->row()->proposal_no;
    }
    else
    {
      $query = $this->db->query("SELECT petition_no FROM $table 
                  WHERE case_no=?", array($case_no))->row()->petition_no;
    }
    // echo $this->db->last_query();
    // log_message('error', "ERR5230: ".$this->db->last_query());
    // log_message('error', "***********TABLE***************:".$table.', '.$case_no);
    return $query;
  }


  public function getCaseDetailsNoByCaseNo($table, $case_no)
  {
    if($table == 'misc_case_basic')
    {
      $query = $this->db->query("SELECT * FROM $table 
                  WHERE misc_case_no=?", array($case_no))->row();
    }
    else if($table == 't_reclassification' || $table == 't_legacyupdation')
    {
      $query = $this->db->query("SELECT * FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    else
    {
      $query = $this->db->query("SELECT * FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    // log_message('error', "***********TABLE***************:".$table.', '.$case_no);
    return $query;
  }


  // check if auto escalte done
  public function checkIfAutoEscalateTakesPlace()
  {
    if(ESCALATION_ALLOW_TIME == 1)
    {
      return $check = $this->db->query("SELECT status FROM auto_escalation_daily_status WHERE 
                api_running_date=? AND status=?", array(date('Y-m-d H:i:s'), 'Y'))->num_rows();
    }
    else
    {
      return $check = $this->db->query("SELECT status FROM auto_escalation_daily_status WHERE 
                date(api_running_date)=? AND status=?", array(date('Y-m-d'), 'Y'))->num_rows();
    }
    
  }


  // insert auto ecalation log
  public function insertAutoEscalateData($response_log)
  {
    $status = 'N';
    if(isset($response_log) && $response_log['response'] == 3)
    {
      $status = 'Y';
    }
    $insArray = [
      'api_running_date'   => date('Y-m-d H:i:s'),
      'status'             => $status,
      'dist_code'          => $this->session->userdata('dist_code'),
      'subdiv_code'        => null,
      'cir_code'           => null,
      'mouza_pargona_code' => null,
      'lot_no'             => null,
      'vill_townprt_code'  => null,
      'uuid'               => null,
      'year_no'            => date('Y'),
      'ip'                 => $_SERVER['REMOTE_ADDR'],
      'response_log'       => json_encode($response_log),
      'created_at'         => date('Y-m-d H:i:s'),
      'updated_at'         => date('Y-m-d H:i:s'),
    ];
    $insert = $this->db->insert('auto_escalation_daily_status', $insArray);     
  }

  // auto escalation for other user
  public function autoEscalateByCaseNoAndServiceCode($case_row)
  {
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->Escalationmodel->generateDateCode();
    $service_code_array   = [1,2,3,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no);
    $executionDate= date('Y-m-d H:i:s');
    
    // From LM to CO
    if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
    { 
      $originalAllocation      = $row->co_target_days;
      $previousCompletedDaysCO = $row->co_completed_days;
      $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

      $lastAssignedDate = $row->assigned_date;

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

      $dateCodes             = $row->lm_date_code_list;
      $previousCompletedDays = $row->lm_completed_days;
      $lm_target_days        = $row->lm_target_days;


      // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days)
      {   
        $escalate_status = 'Y';
      }
      else{
        $escalate_status = 'N';
      }

      // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null)
      {
        $dateCodes = $dateCode;
      }
      else
      {
        $dateCodes = $dateCodes.','.$dateCode;
      }
      
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'                      => $taskId[0]->CODE, // LM message
        'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status'          => $escalate_status,
        'assigned_from'               => $row->assigned_to,
        'assigned_from_code'          => $row->assigned_to_code,
        'assigned_to'                 => $row->assigned_from,
        'assigned_to_code'            => $row->assigned_from_code,
        'assigned_date'               => $executionDate,
        'escalated_date'              => $escalatedDate,
        'lm_date_code_list'           => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      $updateFlag = true;
      $history_id = $row->history_id;

      // log_message("error","UPDATED FLAG ==========".$updateFlag);

      //STEPS to be followed:
      // 1. update escalation_dates_details against or history id
      // 2. update escalation_details with new date codes without history id
      // 3. insert history details and updated escalattion details with new history id

      $where_history = array(
        'petition_no' => $petition_no,
        'date_code'   => $history_id,
        'service_code' => $row->service_code,
      );
      $updateDatesArray = array(
        'completion_date'  => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
      );

      $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

      $where = array(
        'petition_no' => $petition_no
      );

      $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'sr_no'                  => $dateCode,
        'date_code'              => $date_history,
        'petition_no'            => $petition_no,
        'service_code'           => $row->service_code,
        'taskid'                 => $taskId[0]->CODE,
        'pending_officer'        => $row->assigned_from,
        'assigned_user'          => $row->assigned_to,
        'assigned_user_code'     => $row->assigned_to_code,
        'assigned_to'            => $row->assigned_from,
        'assigned_to_code'       => $row->assigned_from_code,
        'registerd_on'           => $row->registerd_on,
        'allocation_date'        => $executionDate,
        'target_completion_date' => $escalatedDate,
        'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        'escalated_status'       => $escalate_status,
        'created_date'           => date('Y-m-d H:i:s'),
        'updated_date'           => date('Y-m-d H:i:s'),
      );

      // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($status != 1)
      {
        log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        $response['responseType'] =0;
        $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
        return $response;
      }
      if($updateFlag == true)
      {
        $where_history_set = array(
          'petition_no' => $petition_no,
        );
        $updateDatesArraySet = array(
          'history_id'     => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        if($this->db->affected_rows() <= 0)
        {
          log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
          return $response;
        }
      }

      $updateTable = $this->updateServiceWiseTable($row->case_no);
      if($updateTable == 'n')
      {
        log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$this->db->last_query());
        $response['responseType'] = 0;
        $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
        return $response;
      }
    }

    // From SK to CO
    if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
    { 
      $originalAllocation      = $row->co_target_days;
      $previousCompletedDaysCO = $row->co_completed_days;
      $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
      $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

      $lastAssignedDate = $row->assigned_date;

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

      $dateCodes             = $row->sk_date_code_list;
      $previousCompletedDays = $row->sk_completed_days;
      $sk_target_days        = $row->sk_target_days;

      // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
      $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      // log_message("error","CO-COMPLETION_DAYS=======".$CO_completed_days);
      if($sk_target_days < $sk_completed_days)
      {   
        $escalate_status = 'Y';
      }
      else{
        $escalate_status = 'N';
      }

      // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null)
      {
        $dateCodes = $dateCode;
      }
      else
      {
        $dateCodes = $dateCodes.','.$dateCode;
      }
      
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'                      => $taskId[1]->CODE, // SK message
        'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
        'sk_escalate_status'          => $escalate_status,
        'assigned_from'               => $row->assigned_to,
        'assigned_from_code'          => $row->assigned_to_code,
        'assigned_to'                 => $row->assigned_from,
        'assigned_to_code'            => $row->assigned_from_code,
        'assigned_date'               => $executionDate,
        'escalated_date'              => $escalatedDate,
        'sk_date_code_list'           => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      $updateFlag = true;
      $history_id = $row->history_id;

      // log_message("error","UPDATED FLAG ==========".$updateFlag);

      //STEPS to be followed:
      // 1. update escalation_dates_details against or history id
      // 2. update escalation_details with new date codes without history id
      // 3. insert history details and updated escalattion details with new history id

      $where_history = array(
      'petition_no' => $petition_no,
      'date_code'   => $history_id,
      'service_code' => $row->service_code,
      );
      $updateDatesArray = array(
      'completion_date'  => $executionDate,
      'escalated_status' => $escalate_status,
      'completion_days'  => $completion_days_for_history
      );

      $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

      $where = array(
        'petition_no' => $petition_no
      );

      $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'sr_no'                  => $dateCode,
        'date_code'              => $date_history,
        'petition_no'            => $petition_no,
        'service_code'           => $row->service_code,
        'taskid'                 => $taskId[0]->CODE,
        'pending_officer'        => $row->assigned_from,
        'assigned_user'          => $row->assigned_to,
        'assigned_user_code'     => $row->assigned_to_code,
        'assigned_to'            => $row->assigned_from,
        'assigned_to_code'       => $row->assigned_from_code,
        'registerd_on'           => $row->registerd_on,
        'allocation_date'        => $executionDate,
        'target_completion_date' => $escalatedDate,
        'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        'escalated_status'       => $escalate_status,
        'created_date'           => date('Y-m-d H:i:s'),
        'updated_date'           => date('Y-m-d H:i:s'),
      );

      // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($status != 1)
      {
        log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        $response['responseType'] =0;
        $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
        return $response;
      }
      if($updateFlag == true)
      {
        $where_history_set = array(
          'petition_no' => $petition_no,
        );
        $updateDatesArraySet = array(
          'history_id'     => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        if($this->db->affected_rows() <= 0)
        {
          log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
          return $response;
        }
      }
      
      $updateTable = $this->updateServiceWiseTable($row->case_no);
      if($updateTable == 'n')
      {
        log_message("error","#ERR4448 : Update Failed on service wise table Failed=======".$this->db->last_query());
        $response['responseType'] =0;
        $response['msg'] = '#ERR4448 : Update Failed on escalation_details Failed';
        return $response;
      }

    } 

    // From CO to DC
    if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2)) 
    { 
      $originalAllocation      = $row->dc_target_days;
      $previousCompletedDaysDC = $row->dc_completed_days;
      $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
      $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

      $lastAssignedDate = $row->assigned_date;

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

      $dateCodes             = $row->co_date_code_list;
      $previousCompletedDays = $row->co_completed_days;
      $co_target_days        = $row->co_target_days;

      // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days)
      {   
        $escalate_status = 'Y';
      }
      else{
        $escalate_status = 'N';
      }

      // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
      if($dateCodes == null)
      {
        $dateCodes = $dateCode;
      }
      else
      {
        $dateCodes = $dateCodes.','.$dateCode;
      }
      
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'                      => $taskId[1]->CODE, // SK message
        'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status'          => $escalate_status,
        'assigned_from'               => $row->assigned_to,
        'assigned_from_code'          => $row->assigned_to_code,
        'assigned_to'                 => $row->assigned_from,
        'assigned_to_code'            => $row->assigned_from_code,
        'assigned_date'               => $executionDate,
        'escalated_date'              => $escalatedDate,
        'co_date_code_list'           => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      $updateFlag = true;
      $history_id = $row->history_id;

      // log_message("error","UPDATED FLAG ==========".$updateFlag);

      //STEPS to be followed:
      // 1. update escalation_dates_details against or history id
      // 2. update escalation_details with new date codes without history id
      // 3. insert history details and updated escalattion details with new history id

      $where_history = array(
      'petition_no' => $petition_no,
      'date_code'   => $history_id,
      'service_code' => $row->service_code,
      );
      $updateDatesArray = array(
      'completion_date'  => $executionDate,
      'escalated_status' => $escalate_status,
      'completion_days'  => $completion_days_for_history
      );

      $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

      $where = array(
        'petition_no' => $petition_no
      );

      $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

      $date_history    = $this->Escalationmodel->generateDateCode();
      $insertDateArray = array(
        'sr_no'                  => $dateCode,
        'date_code'              => $date_history,
        'petition_no'            => $petition_no,
        'service_code'           => $row->service_code,
        'taskid'                 => $taskId[0]->CODE,
        'pending_officer'        => $row->assigned_from,
        'assigned_user'          => $row->assigned_to,
        'assigned_user_code'     => $row->assigned_to_code,
        'assigned_to'            => $row->assigned_from,
        'assigned_to_code'       => $row->assigned_from_code,
        'registerd_on'           => $row->registerd_on,
        'allocation_date'        => $executionDate,
        'target_completion_date' => $escalatedDate,
        'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
        'escalated_status'       => $escalate_status,
        'created_date'           => date('Y-m-d H:i:s'),
        'updated_date'           => date('Y-m-d H:i:s'),
      );

      // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($status != 1)
      {
        log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
        $response['responseType'] =0;
        $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
        return $response;
      }
      if($updateFlag == true)
      {
        $where_history_set = array(
          'petition_no' => $petition_no,
        );
        $updateDatesArraySet = array(
          'history_id'     => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
        if($this->db->affected_rows() <= 0)
        {
          log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
          return $response;
        }
      }      

      $updateTable = $this->updateServiceWiseTable($row->case_no);
      if($updateTable == 'n')
      {
        log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
        $response['responseType'] =0;
        $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
        return $response;
      }
    }
  }




  // update servicewise table
  public function updateIsEscToZeroServiceWiseTable($case_no)
  {
    // get service name
    $service_type = $this->getServiceName($case_no);

    //update service wise table
    $table = $this->getTableNameByServiceType($service_type);
    if($table == 'misc_case_basic')
    {
      $case_no_val = 'misc_case_no';
    }
    else
    {
      $case_no_val = 'case_no';
    }

    // update service table
    $query = $this->db->query("UPDATE $table SET is_escalated=? WHERE $case_no_val = ? 
                AND es_flag=?", array(0, $case_no, 1));
    if($this->db->affected_rows() != 1)
    {
      return 'n';
    }
    return 'y';
  }

  // insert successfull auto escalated data
  public function insertSuccessData($row)
  {
    $response = array('responseType' => 1,'msg' => null);
    if(!empty($row))
    {
      unset($row->sl_no);
      $successInsert = [
        'taskid'                            => $row->taskid,
        'petition_no'                       => $row->petition_no,
        'case_no'                           => $row->case_no,
        'service_code'                      => $row->service_code,
        'registerd_on'                      => $row->registerd_on,
        'case_type'                         => $row->case_type,
        'total_days'                        => $row->total_days,
        'status'                            => $row->status,
        'assignment_type'                   => $row->assignment_type,
        'assigned_from'                     => $row->assigned_from,
        'assigned_from_code'                => $row->assigned_from_code,
        'assigned_to'                       => $row->assigned_to,
        'assigned_to_code'                  => $row->assigned_to_code,
        'assigned_date'                     => $row->assigned_date,
        'escalated_date'                    => $row->escalated_date,
        'history_id'                        => $row->history_id,
        'to_be_completed_within_days'       => $row->to_be_completed_within_days,
        'assignment_type_other'             => $row->assignment_type_other,
        'assigned_other'                    => $row->assigned_other,
        'assigned_other_date'               => $row->assigned_other_date,
        'assigned_other_es_date'            => $row->assigned_other_es_date,
        'to_be_other_completed_within_days' => $row->to_be_other_completed_within_days,
        'da_target_days'                    => $row->da_target_days,
        'da_allocate_days'                  => $row->da_allocate_days,
        'da_completed_days'                 => $row->da_completed_days,
        'da_date_code_list'                 => $row->da_date_code_list,
        'da_escalate_status'                => $row->da_escalate_status,
        'lm_target_days'                    => $row->lm_target_days,
        'lm_allocate_days'                  => $row->lm_allocate_days,
        'lm_completed_days'                 => $row->lm_completed_days,
        'lm_date_code_list'                 => $row->lm_date_code_list,
        'lm_escalate_status'                => $row->lm_escalate_status,
        'sk_target_days'                    => $row->sk_target_days,
        'sk_allocate_days'                  => $row->sk_allocate_days,
        'sk_completed_days'                 => $row->sk_completed_days,
        'sk_date_code_list'                 => $row->sk_date_code_list,
        'sk_escalate_status'                => $row->sk_escalate_status,
        'co_target_days'                    => $row->co_target_days,
        'co_allocate_days'                  => $row->co_allocate_days,
        'co_completed_days'                 => $row->co_completed_days,
        'co_date_code_list'                 => $row->co_date_code_list,
        'co_escalate_status'                => $row->co_escalate_status,
        'bo_target_days'                    => $row->bo_target_days,
        'bo_allocate_days'                  => $row->bo_allocate_days,
        'bo_completed_days'                 => $row->bo_completed_days,
        'bo_date_code_list'                 => $row->bo_date_code_list,
        'bo_escalate_status'                => $row->bo_escalate_status,
        'adc_target_days'                   => $row->adc_target_days,
        'adc_allocate_days'                 => $row->adc_allocate_days,
        'adc_completed_days'                => $row->adc_completed_days,
        'adc_date_code_list'                => $row->adc_date_code_list,
        'adc_escalate_status'               => $row->adc_escalate_status,
        'dc_target_days'                    => $row->dc_target_days,
        'dc_allocate_days'                  => $row->dc_allocate_days,
        'dc_completed_days'                 => $row->dc_completed_days,
        'dc_date_code_list'                 => $row->dc_date_code_list,
        'dc_escalate_status'                => $row->dc_escalate_status,
        'dept_target_days'                  => $row->dept_target_days,
        'dept_allocate_days'                => $row->dept_allocate_days,
        'dept_completed_days'               => $row->dept_completed_days,
        'dept_date_code_list'               => $row->dept_date_code_list,
        'dept_escalate_status'              => $row->dept_escalate_status,
        'sro_target_days'                   => $row->sro_target_days,
        'sro_allocate_days'                 => $row->sro_allocate_days,
        'sro_completed_days'                => $row->sro_completed_days,
        'sro_date_code_list'                => $row->sro_date_code_list,
        'sro_escalate_status'               => $row->sro_escalate_status,
        'mouzadar_target_days'              => $row->mouzadar_target_days,
        'mouzadar_allocate_days'            => $row->mouzadar_allocate_days,
        'mouzadar_completed_days'           => $row->mouzadar_completed_days,
        'mouzadar_date_code_list'           => $row->mouzadar_date_code_list,
        'mouzadar_escalate_status'          => $row->mouzadar_escalate_status,
        'created_date'                      => $row->created_date,
        'updated_date'                      => $row->updated_date,
        'history_id_others'                 => $row->history_id_others,
        'assigned_other_code'               => $row->assigned_other_code,
        'final_completion_date'             => $row->final_completion_date,
        'deescalation_start_date'           => $row->deescalation_start_date,
        'deescalation_status'               => $row->deescalation_status,
      ];

      $status = $this->db->insert('escalation_of_success_cases', $successInsert);

      if($status != 1)
      {
        log_message("error","#ERRCRONMODEL102 : Insert Failed on escalation_of_success_cases Failed=======".$this->db->last_query());
        $response['responseType'] = 0;
        $response['msg'] = '#ERRCRONMODEL102 : Insert Failed on ERRCRONMODEL102 Failed';
        return $response;
      }

      $response['responseType'] = 1;
      $response['msg'] = 'Successfully inserted';
      return $response;
    }
  }

  // insert for failed auto escalated cases
  public function insertFailedData($row)
  {
    $response = array('responseType' => 1,'msg' => null);
    if(!empty($row))
    {
      unset($row->sl_no);
      $failedInsert = [
        'taskid'                            => $row->taskid,
        'petition_no'                       => $row->petition_no,
        'case_no'                           => $row->case_no,
        'service_code'                      => $row->service_code,
        'registerd_on'                      => $row->registerd_on,
        'case_type'                         => $row->case_type,
        'total_days'                        => $row->total_days,
        'status'                            => $row->status,
        'assignment_type'                   => $row->assignment_type,
        'assigned_from'                     => $row->assigned_from,
        'assigned_from_code'                => $row->assigned_from_code,
        'assigned_to'                       => $row->assigned_to,
        'assigned_to_code'                  => $row->assigned_to_code,
        'assigned_date'                     => $row->assigned_date,
        'escalated_date'                    => $row->escalated_date,
        'history_id'                        => $row->history_id,
        'to_be_completed_within_days'       => $row->to_be_completed_within_days,
        'assignment_type_other'             => $row->assignment_type_other,
        'assigned_other'                    => $row->assigned_other,
        'assigned_other_date'               => $row->assigned_other_date,
        'assigned_other_es_date'            => $row->assigned_other_es_date,
        'to_be_other_completed_within_days' => $row->to_be_other_completed_within_days,
        'da_target_days'                    => $row->da_target_days,
        'da_allocate_days'                  => $row->da_allocate_days,
        'da_completed_days'                 => $row->da_completed_days,
        'da_date_code_list'                 => $row->da_date_code_list,
        'da_escalate_status'                => $row->da_escalate_status,
        'lm_target_days'                    => $row->lm_target_days,
        'lm_allocate_days'                  => $row->lm_allocate_days,
        'lm_completed_days'                 => $row->lm_completed_days,
        'lm_date_code_list'                 => $row->lm_date_code_list,
        'lm_escalate_status'                => $row->lm_escalate_status,
        'sk_target_days'                    => $row->sk_target_days,
        'sk_allocate_days'                  => $row->sk_allocate_days,
        'sk_completed_days'                 => $row->sk_completed_days,
        'sk_date_code_list'                 => $row->sk_date_code_list,
        'sk_escalate_status'                => $row->sk_escalate_status,
        'co_target_days'                    => $row->co_target_days,
        'co_allocate_days'                  => $row->co_allocate_days,
        'co_completed_days'                 => $row->co_completed_days,
        'co_date_code_list'                 => $row->co_date_code_list,
        'co_escalate_status'                => $row->co_escalate_status,
        'bo_target_days'                    => $row->bo_target_days,
        'bo_allocate_days'                  => $row->bo_allocate_days,
        'bo_completed_days'                 => $row->bo_completed_days,
        'bo_date_code_list'                 => $row->bo_date_code_list,
        'bo_escalate_status'                => $row->bo_escalate_status,
        'adc_target_days'                   => $row->adc_target_days,
        'adc_allocate_days'                 => $row->adc_allocate_days,
        'adc_completed_days'                => $row->adc_completed_days,
        'adc_date_code_list'                => $row->adc_date_code_list,
        'adc_escalate_status'               => $row->adc_escalate_status,
        'dc_target_days'                    => $row->dc_target_days,
        'dc_allocate_days'                  => $row->dc_allocate_days,
        'dc_completed_days'                 => $row->dc_completed_days,
        'dc_date_code_list'                 => $row->dc_date_code_list,
        'dc_escalate_status'                => $row->dc_escalate_status,
        'dept_target_days'                  => $row->dept_target_days,
        'dept_allocate_days'                => $row->dept_allocate_days,
        'dept_completed_days'               => $row->dept_completed_days,
        'dept_date_code_list'               => $row->dept_date_code_list,
        'dept_escalate_status'              => $row->dept_escalate_status,
        'sro_target_days'                   => $row->sro_target_days,
        'sro_allocate_days'                 => $row->sro_allocate_days,
        'sro_completed_days'                => $row->sro_completed_days,
        'sro_date_code_list'                => $row->sro_date_code_list,
        'sro_escalate_status'               => $row->sro_escalate_status,
        'mouzadar_target_days'              => $row->mouzadar_target_days,
        'mouzadar_allocate_days'            => $row->mouzadar_allocate_days,
        'mouzadar_completed_days'           => $row->mouzadar_completed_days,
        'mouzadar_date_code_list'           => $row->mouzadar_date_code_list,
        'mouzadar_escalate_status'          => $row->mouzadar_escalate_status,
        'created_date'                      => $row->created_date,
        'updated_date'                      => $row->updated_date,
        'history_id_others'                 => $row->history_id_others,
        'assigned_other_code'               => $row->assigned_other_code,
        'final_completion_date'             => $row->final_completion_date,
        'deescalation_start_date'           => $row->deescalation_start_date,
        'deescalation_status'               => $row->deescalation_status,
      ];

      $status = $this->db->insert('escalation_of_failed_cases', $failedInsert);

      if($status != 1)
      {
        log_message("error","#ERRCRONMODEL209 : Insert Failed on escalation_of_failed_cases Failed=======".$this->db->last_query());
        $response['responseType'] = 0;
        $response['msg'] = '#ERRCRONMODEL209 : Insertion failed in escalation_of_failed_cases';
        return $response;
      }

      $response['responseType'] = 1;
      $response['msg'] = 'Successfully inserted';
      return $response;
    }
  }

  public function getPetitionDetails($case_no)
  {
      $sql = "Select * from petition_basic where  case_no=?";
      $data = $this->db->query($sql, array($case_no))->row();
      return $data;
  }

  public function getNcanDetailsByCaseNo($case_no)
  {
      $sql = "Select * from misc_case_basic where  misc_case_no=?";
      $data = $this->db->query($sql, array($case_no))->row();
      return $data;

  }


  public function holidayInsertForTheDay($response_log)
  {
    $status = 'N';
    if(isset($response_log) && $response_log != 'n')
    {
      $status = 'Y';
    }
    $insArray = [
      'holiday_running_date'   => date('Y-m-d H:i:s'),
      'status'             => $status,
      'user_code'          => $this->session->userdata('user_code'),
      'dist_code'          => $this->session->userdata('dist_code'),
      'subdiv_code'        => null,
      'cir_code'           => null,
      'mouza_pargona_code' => null,
      'lot_no'             => null,
      'vill_townprt_code'  => null,
      'uuid'               => null,
      'year_no'            => date('Y'),
      'ip'                 => $_SERVER['REMOTE_ADDR'],
      'response_log'       => json_encode($response_log),
      'created_at'         => date('Y-m-d H:i:s'),
      'updated_at'         => date('Y-m-d H:i:s'),
    ];
    $insert = $this->db->insert('escalation_holiday_daily_insert', $insArray);     
  }

  public function checkHolidayInsertOrNot($date)
  {
    $checkHolidayInsertOrNot = $this->db->query("select * from escalation_holiday_daily_insert where date(holiday_running_date) = ? and status = ? ",array($date,'Y'));
    return $checkHolidayInsertOrNot->num_rows();
  }
  

  

}
?>