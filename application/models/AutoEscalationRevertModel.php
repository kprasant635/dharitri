<?php
class AutoEscalationRevertModel extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->load->model('Escalationmodel');
    $this->load->model('AutoEscalationmodel');
    $this->load->model('EscTableFieldsModel');
  }    

  public function escalationCORevertAuto($revert_back,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$mouza_pargona_code,$lot_no,$allocation_days,$service_code)
  {

      if($revert_back == 'LM')
      {
        $assigned_to = $this->Escalationmodel->getPendingOfficerLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);

      }
      else
      {
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,$revert_back);
      }

      $hearing_date = null;
      $user_type = 'CO';
      // $service_code = '1';
      $assigned_to_code = $assigned_to->user_code;
      $assigned_user_type = $revert_back;
      $assigned_to_other_type = null;
      $finalStatus = null;
      $assigned_to_other = null;
      $task= json_decode(FMUT_TASK);
      $taskid = $task[4]->CODE;
      $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
      $assignment_type=null;
      $assignment_type_other = $assignment_type_list[3]->CODE;
      if($allocation_days != null){
        $updateExtraDaysAgainstPetitionNo = $this->Escalationmodel->updateExtraDays($case_no,$allocation_days,$revert_back);
      }
      if($service_code == SERVICE_FIELD_MUTATION)
      {
      $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFMUT($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to_code,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days);
      }
      elseif($service_code == SERVICE_OFFICE_MUTATION)
      {
      $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to_code,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days);

      }
      return $escalationUpdateStatus;
  }


  // revert from higher authority
  public function revertEscalatedCasesForAssistant($postData)
  {
    // echo "sdfghjk";
    // var_dump($postData); die;
    $json           = array();
    $taskId         = json_decode(TASK_ID); // common for all services
    $allocate_day   = $postData['allocate_day'];
    $revert_remarks = $postData['revert_remarks'];
    $executionDate  = $postData['executionDate'];
    $case_no        = $postData['case_no'];
    $revert_to_user = $postData['revert_to_user'];
    if($revert_to_user == 'LM')
    {
      $taskid = $taskId[4]->CODE;
    }
    else if($revert_to_user == 'SK')
    {
      $taskid = $taskId[5]->CODE;
    }
    else if($revert_to_user == 'AST')
    {
      $taskid = $taskId[6]->CODE;
    }
    else if($revert_to_user == 'CO')
    {
      $taskid = $taskId[7]->CODE;
    }
    $en_case_no     = $this->utilityclass->encryptJwtCase($case_no);
    $en_revert_user = $this->utilityclass->encryptJwtCase($revert_to_user);
    $dateCode       = $this->Escalationmodel->generateDateCode();
    // calculate escalation date
    if($allocate_day == 1)
    {
        
      if(ESCALATION_ALLOW_TIME == 1)
      {
        $esc_date = date( "Y-m-d H:i:s", strtotime($executionDate)+(60*$allocate_day));
      }else
      {
        $esc_date = date('Y-m-d', strtotime($executionDate. " + 1 day"));
      }
    }
    else
    {
      if(ESCALATION_ALLOW_TIME == 1)
      {
        $esc_date = date( "Y-m-d H:i:s", strtotime($executionDate)+(60*$allocate_day));
      }else
      {
        $esc_date = date('Y-m-d', strtotime($executionDate. " + ".$allocate_day." days"));
      }      
    }
    
    // get detail from escalation_details
    $getEscData = $this->db->query("SELECT * FROM escalation_details WHERE case_no=?", 
                    array($case_no));
    if($getEscData->num_rows() == 0)
    {
      $json = [
        'responseType' => 1,
        'message'      => "#ERR117: No data found to revert for case no $case_no",
      ];
      return $json;
    }

    $service_type = $this->AutoEscalationmodel->getServiceName($case_no);
    $table        = $this->AutoEscalationmodel->getTableNameByServiceType($service_type);
    $petition_no  = $this->AutoEscalationmodel->getPetitionNoByCaseNo($table, $case_no);
    //echo $this->db->last_query(); die;

    $detail = $getEscData->row();

    $to_be_completed_within_days = $this->Escalationmodel->dateDiff($esc_date,$executionDate);

    $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate, $detail->assigned_other_date);

    // var_dump($completion_days_for_history); die;


    $completed_days = $detail->co_completed_days;

    $rem_completed_days = $this->checkDaysRevertedOn($detail->assigned_other_es_date, $completed_days);

    //update escalation_detail table
    $updateArray = [
      'taskid'                      => $taskid,
      'assigned_other_date'         => $executionDate,
      'assigned_other_es_date'      => $esc_date,
      'to_be_other_completed_within_days' => $to_be_completed_within_days,
      'assignment_type'             => '2', // 2 is for auto escalate
    ];

    if($revert_to_user == 'AST')
    {
      $lastAssignedDate = $detail->assigned_date;
      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $prev_co_completed_days = $detail->co_completed_days;
      $updateArray['da_escalate_status'] = 'N';
      $updateArray['da_date_code_list']  = $detail->da_date_code_list == null ? $dateCode : $detail->da_date_code_list.','.$dateCode;
      $updateArray['da_target_days']     = $detail->da_target_days + $allocate_day;
      $updateArray['co_completed_days']  = $allocate_day + $co_completed_days + $prev_co_completed_days;
    }

    $updateFlag = true;
    $history_id = $detail->history_id;

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code'   => $history_id,
      'service_code' => $detail->service_code,
    );
    $updateDatesArray = array(
      'completion_date'  => $executionDate,
      'escalated_status' => 'N',
      'completion_days'  => $completion_days_for_history,
    );

    $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);
    // echo $this->db->last_query();die;
    if($this->db->affected_rows() <= 0)
    {
      log_message("error","#ERR154 : Updation failed on escalation_dates_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR154 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $where = array(
      'petition_no' => $petition_no
    );

    $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);
    if($this->db->affected_rows() != 1)
    {
      log_message("error","#ERR161 : Updation failed on escalation_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR161 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $date_history    = $this->Escalationmodel->generateDateCode();

    $insertDateArray = array(
      'sr_no'                  => $dateCode,
      'date_code'              => $date_history,
      'petition_no'            => $petition_no,
      'service_code'           => $detail->service_code,
      'taskid'                 => $taskid,
      'action_type'            => 2,  // 2 is for auto escalate
      'pending_officer'        => $detail->assigned_from,
      'assigned_user'          => $detail->assigned_to,
      'assigned_user_code'     => $detail->assigned_to_code,
      'assigned_to'            => $detail->assigned_from,
      'assigned_to_code'       => $detail->assigned_from_code,
      'registerd_on'           => $detail->registerd_on,
      'allocation_date'        => $executionDate,
      'target_completion_date' => $esc_date,
      'date_diff'              => $this->Escalationmodel->dateDiff($esc_date,$executionDate),
      'escalated_status'       => 'N',
      'created_date'           => date('Y-m-d H:i:s'),
      'updated_date'           => date('Y-m-d H:i:s'),
    );

    // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    if($status != 1)
    {
      log_message("error","#ERR171 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR171 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    // update service wise table
    $updateServiceTable = [
      'is_escalated'  => 0,
    ];
    if($table == 'misc_case_basic')
    {
      $whereServiceTable = [
        'misc_case_no'     => $case_no,
      ];
    }
    else
    {
      $whereServiceTable = [
        'case_no'     => $case_no,
      ];
    }
    
    $this->db->update($table, $updateServiceTable, $whereServiceTable);
    if($this->db->affected_rows() != 1)
    {
      log_message("error","#ERR224 : Updation Failed on $table =======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR224 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM escalation_procceding 
                      WHERE case_no=?", array($case_no))->row()->c;
    if($proceeding_id == null || $proceeding_id == '')
    {
        $proceeding_id = 1;
    }

    // insert into escalation proceeding
    $insProceeding = [
      'task_id'        => $taskid,
      'action_type'    => 2, // 2 for auto escalation cases
      'petition_no'    => $petition_no,
      'case_no'        => $case_no,
      'proceeding_id'  => $proceeding_id,
      'revert_remarks' => $revert_remarks,
      'status'         => 1,
      'user_code'      => $this->session->userdata('user_code'),
      'date_entry'     => date('Y-m-d H:i:s'),
      'ip'             => $_SERVER['REMOTE_ADDR'],
    ];
    $insStatus = $this->db->insert('escalation_procceding', $insProceeding);
    // echo $this->db->last_query(); die;
    if($insStatus != 1)
    {
      log_message("error","#ERR271 : Insertion Failed on escalation_procceding =======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR271 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $json = [
      'responseType' => 2,
      'message'      => "#SUCCESS234 : Successfully reverted to $revert_to_user for case no $case_no",
      'service_type' => $this->utilityclass->encryptJwtCase($service_type),
    ];
    return $json;
  }


  // revert from higher authority
  public function revertEscalatedCases($postData)
  {
    // echo "sdfghjk";
    // var_dump($postData); die;
    $json           = array();
    $taskId         = json_decode(TASK_ID); // common for all services

    $allocate_day   = $postData['allocate_day'];
    $revert_remarks = $postData['revert_remarks'];
    $executionDate  = $postData['executionDate'];
    $case_no        = $postData['case_no'];
    $revert_to_user = $postData['revert_to_user'];

    if($revert_to_user == 'LM')
    {
      $taskid = $taskId[4]->CODE;
    }
    else if($revert_to_user == 'SK')
    {
      $taskid = $taskId[5]->CODE;
    }
    else if($revert_to_user == 'AST')
    {
      $taskid = $taskId[6]->CODE;
    }
    else if($revert_to_user == 'CO')
    {
      $taskid = $taskId[7]->CODE;
    }

    $en_case_no     = $this->utilityclass->encryptJwtCase($case_no);
    $en_revert_user = $this->utilityclass->encryptJwtCase($revert_to_user);

    $dateCode       = $this->Escalationmodel->generateDateCode();

    // calculate escalation date
    if($allocate_day == 1)
    {
        
      if(ESCALATION_ALLOW_TIME == 1)
      {
        $esc_date = date( "Y-m-d H:i:s", strtotime($executionDate)+(60*$allocate_day));
      }else
      {
        $esc_date = date('Y-m-d', strtotime($executionDate. " + 1 day"));
      }
    }
    else
    {
      if(ESCALATION_ALLOW_TIME == 1)
      {
        $esc_date = date( "Y-m-d H:i:s", strtotime($executionDate)+(60*$allocate_day));
      }else
      {
        $esc_date = date('Y-m-d', strtotime($executionDate. " + ".$allocate_day." days"));
      }      
    }
    
    // get detail from escalation_details
    $getEscData = $this->db->query("SELECT * FROM escalation_details WHERE case_no=?", 
                    array($case_no));
    if($getEscData->num_rows() == 0)
    {
      $json = [
        'responseType' => 1,
        'message'      => "#ERR117: No data found to revert for case no $case_no",
      ];
      return $json;
    }

    $service_type = $this->AutoEscalationmodel->getServiceName($case_no);
    $table        = $this->AutoEscalationmodel->getTableNameByServiceType($service_type);
    $petition_no  = $this->AutoEscalationmodel->getPetitionNoByCaseNo($table, $case_no);
    //echo $this->db->last_query(); die;

    $detail = $getEscData->row();

    $to_be_completed_within_days = $this->Escalationmodel->dateDiff($esc_date,$executionDate);

    $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate, $detail->assigned_date);

    // var_dump($completion_days_for_history); die;

    if($detail->assigned_to_code == 2) //dc
    {
      $completed_days = $detail->dc_completed_days;
    }
    else if($detail->assigned_to_code == 6) //co
    {
      $completed_days = $detail->co_completed_days;
    }
    $rem_completed_days = $this->checkDaysRevertedOn($detail->escalated_date, $completed_days);

    //update escalation_detail table
    $updateArray = [
      'taskid'                      => $taskid,
      'assigned_from'               => $detail->assigned_to,
      'assigned_from_code'          => $detail->assigned_to_code,
      'assigned_to'                 => $detail->assigned_from,
      'assigned_to_code'            => $detail->assigned_from_code,
      'assigned_date'               => $executionDate,
      'escalated_date'              => $esc_date,
      'to_be_completed_within_days' => $to_be_completed_within_days,
      'assignment_type'             => '2', // 2 is for auto escalate
    ];


    if($revert_to_user == 'LM')
    {
      $lastAssignedDate = $detail->assigned_date;
      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $prev_co_completed_days = $detail->co_completed_days;
      $updateArray['lm_escalate_status'] = 'N';
      $updateArray['lm_date_code_list']  = $detail->lm_date_code_list == null ? $dateCode : $detail->lm_date_code_list.','.$dateCode;
      $updateArray['lm_target_days']     = $detail->lm_target_days + $allocate_day;
      $updateArray['lm_allocate_days']     = $detail->lm_allocate_days + $allocate_day;
      $updateArray['co_completed_days']  = $allocate_day + $prev_co_completed_days;
      // $updateArray['co_completed_days']  = $allocate_day + $co_completed_days + $prev_co_completed_days;

    }
    else if($revert_to_user == 'SK')
    {
      $lastAssignedDate = $detail->assigned_date;
      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $prev_co_completed_days = $detail->co_completed_days;
      $updateArray['sk_escalate_status'] = 'N';
      $updateArray['sk_date_code_list']  = $detail->sk_date_code_list == null ? $dateCode : $detail->sk_date_code_list.','.$dateCode;
      $updateArray['sk_target_days']     = $detail->sk_target_days + $allocate_day;
      $updateArray['sk_allocate_days']     = $detail->sk_allocate_days + $allocate_day;
      $updateArray['co_completed_days']  = $allocate_day + $prev_co_completed_days;
      // $updateArray['co_completed_days']  = $allocate_day + $co_completed_days + $prev_co_completed_days;
    }
    else if($revert_to_user == 'AST')
    {
      $lastAssignedDate = $detail->assigned_date;
      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $prev_co_completed_days = $detail->co_completed_days;
      $updateArray['da_escalate_status'] = 'N';
      $updateArray['da_date_code_list']  = $detail->da_date_code_list == null ? $dateCode : $detail->da_date_code_list.','.$dateCode;
      $updateArray['da_target_days']     = $detail->da_target_days + $allocate_day;
      $updateArray['da_allocate_days']   = $detail->da_allocate_days + $allocate_day;
      $updateArray['co_completed_days']  = $allocate_day + $prev_co_completed_days;
      // $updateArray['co_completed_days']  = $allocate_day + $co_completed_days + $prev_co_completed_days;
    }
    else if($revert_to_user == 'CO')
    {
      $lastAssignedDate = $detail->assigned_date;
      $dc_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $prev_dc_completed_days = $detail->dc_completed_days;
      $updateArray['co_escalate_status'] = 'N';
      $updateArray['co_date_code_list']  = $detail->co_date_code_list == null ? $dateCode : $detail->co_date_code_list.','.$dateCode;
      $updateArray['co_target_days']     = $detail->co_target_days + $allocate_day;
      $updateArray['co_allocate_days']     = $detail->co_allocate_days + $allocate_day;
      $updateArray['dc_completed_days']  = $allocate_day + $dc_completed_days + $prev_dc_completed_days;
    }

    $updateFlag = true;
    $history_id = $detail->history_id;

    $where_history = array(
      'petition_no' => $petition_no,
      'date_code'   => $history_id,
      'service_code' => $detail->service_code,
    );
    $updateDatesArray = array(
      'completion_date'  => $executionDate,
      'escalated_status' => 'N',
      'completion_days'  => $completion_days_for_history,
    );

    $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);
    // echo $this->db->last_query();die;
    if($this->db->affected_rows() <= 0)
    {
      log_message("error","#ERR154 : Updation failed on escalation_dates_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR154 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $where = array(
      'petition_no' => $petition_no,
      'case_no' => $case_no,
     );

    $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);
    if($this->db->affected_rows() != 1)
    {
      log_message("error","#ERR161 : Updation failed on escalation_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR161 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $date_history    = $this->Escalationmodel->generateDateCode();

    $insertDateArray = array(
      'sr_no'                  => $dateCode,
      'date_code'              => $date_history,
      'petition_no'            => $petition_no,
      'service_code'           => $detail->service_code,
      'taskid'                 => $taskid,
      'action_type'            => 2,  // 2 is for auto escalate
      'pending_officer'        => $detail->assigned_from,
      'assigned_user'          => $detail->assigned_to,
      'assigned_user_code'     => $detail->assigned_to_code,
      'assigned_to'            => $detail->assigned_from,
      'assigned_to_code'       => $detail->assigned_from_code,
      'registerd_on'           => $detail->registerd_on,
      'allocation_date'        => $executionDate,
      'target_completion_date' => $esc_date,
      'date_diff'              => $this->Escalationmodel->dateDiff($esc_date,$executionDate),
      'escalated_status'       => 'N',
      'created_date'           => date('Y-m-d H:i:s'),
      'updated_date'           => date('Y-m-d H:i:s'),
    );

    // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    if($status != 1)
    {
      log_message("error","#ERR171 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR171 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    // update service wise table
    $updateServiceTable = [
      'is_escalated'  => 0,
    ];
    if($table == 'misc_case_basic')
    {
      $whereServiceTable = [
        'misc_case_no'     => $case_no,
      ];
    }
    else
    {
      $whereServiceTable = [
        'case_no'     => $case_no,
      ];
    }
    
    $this->db->update($table, $updateServiceTable, $whereServiceTable);
    if($this->db->affected_rows() != 1)
    {
      log_message("error","#ERR224 : Updation Failed on $table =======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR224 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM escalation_procceding 
                      WHERE case_no=?", array($case_no))->row()->c;
    if($proceeding_id == null || $proceeding_id == '')
    {
        $proceeding_id = 1;
    }

    // insert into escalation proceeding
    $insProceeding = [
      'task_id'        => $taskid,
      'action_type'    => 2, // 2 for auto escalation cases
      'petition_no'    => $petition_no,
      'case_no'        => $case_no,
      'proceeding_id'  => $proceeding_id,
      'revert_remarks' => $revert_remarks,
      'status'         => 1,
      'user_code'      => $this->session->userdata('user_code'),
      'date_entry'     => date('Y-m-d H:i:s'),
      'ip'             => $_SERVER['REMOTE_ADDR'],
    ];
    $insStatus = $this->db->insert('escalation_procceding', $insProceeding);
    // echo $this->db->last_query(); die;
    if($insStatus != 1)
    {
      log_message("error","#ERR271 : Insertion Failed on escalation_procceding =======".$this->db->last_query());
      $json = [
        'responseType' => 1,
        'message'      => "#ERR271 : Some issue occured on reverting for case no $case_no",
      ];
      return $json;
    }

    $json = [
      'responseType' => 2,
      'message'      => "#SUCCESS234 : Successfully reverted to $revert_to_user for case no $case_no",
      'service_type' => $this->utilityclass->encryptJwtCase($service_type),
    ];
    return $json;
  }

  // check for reverted on date
  public function checkDaysRevertedOn($escalated_date, $to_be_completed_days)
  {
    if(ESCALATION_ALLOW_TIME == 1)
    {
      $currDate    = date('Y-m-d H:i:s');
      $getDiffDays = $this->Escalationmodel->dateDiff($currDate,$escalated_date);
      return $tobeCompletedIn = $to_be_completed_days - $getDiffDays;
    }
    else
    {
      $currDate    = date('Y-m-d');
      $getDiffDays = $this->Escalationmodel->dateDiff($currDate, date('Y-m-d', strtotime($escalated_date)));
      return $tobeCompletedIn = $to_be_completed_days - $getDiffDays;
    }
  }



  // auto escalation for other user
  public function autoEscalateToDcForRevertedDeEscalation($postData)
  {
    // echo "<pre>";
    // var_dump($postData); die;

    $case_no = $postData['case_no'];

    $fromUser = $this->utilityclass->decryptJwtCase($postData['from_user']);
    $userCode = $this->EscTableFieldsModel->getUserCode($fromUser);

    // get detail from escalation_details
    $getEscData = $this->db->query("SELECT * FROM escalation_details WHERE case_no=?", array($case_no));
    if($getEscData->num_rows() == 0)
    {
      $json = [
        'responseType' => 1,
        'message'      => "#ERR370: No data found to revert for case no ".$case_no,
      ];
      return $json;
    }

    $row = $getEscData->row();

    $service_type = $this->AutoEscalationmodel->getServiceName($case_no);

    // From CO to DC
    if($userCode == 6)
    {
      $timeLineForDeesc = $this->EscalationModel->getTimeLine($row->service_code,$service_type,DEESCALATE);




      // this case is not under DC but it will pop up in dc escalated list==========
      //calculate maximum days from other users====

      $lmRemainingDays = $row->lm_target_days - $row->lm_completed_days;
      $skRemainingDays = $row->sk_target_days - $row->sk_completed_days;
      $coRemainingDays = $row->co_target_days - $row->co_completed_days;
      $daRemainingDays = $row->da_target_days - $row->da_completed_days;

      $arrayDays = array(
        'lm' => $lmRemainingDays,
        'sk' => $skRemainingDays,
        'co' => $coRemainingDays,
        'da' => $daRemainingDays
      );
      $maxValue = max($arrayDays);
      $maxIndex = array_search(max($arrayDays), $arrayDays);

      // log_message('error','******4659 : '.json_encode($maxValue,'---'.$maxIndex));

      

      //assigning max days to DC
      $originalAllocation      = $maxValue;
      $deEscalationUsed = false;
      if($originalAllocation <= 0)
      {
        $deEscalationUsed = true;
        // $originalAllocation = 2;
        ///get timeline from matrix version for de-escalation=================
        $timeLineForDeesc = $this->EscalationModel->getTimeLine($row->service_code,$service_type,DEESCALATE);
        if(empty($timeLineForDeesc))
        {
          log_message("error","#ERR4677 : no data available in escalation_matrix =======");
          $response['responseType'] =0;
          $response['msg'] = '#ERR4677 : De-escalation error';
          return $response;
        }


        $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
        $originalAllocation = $sumationOfTotalTime;

      }
      else
      {
        $originalAllocation = $maxValue;
      }


      


      $previousCompletedDaysDC = 0;



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


        
      $dcUserDetails = $this->EscalationModel->getPendingOfficerDC($caseDetails->dist_code,'DC');

      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'                      => $taskId[1]->CODE, // SK message
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
        'dc_target_days'              => $originalAllocation - $co_completed_days, // for DC new assigning days
        'dc_allocate_days'            => $originalAllocation - $co_completed_days, // dc allocate days
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
    }
























    // $response             = array('responseType' => 1,'msg' => null);
    // $taskId               = json_decode(TASK_ID);
    // $dateCode             = $this->Escalationmodel->generateDateCode();
    // $service_code_array   = [1,2,3,6,8]; // other then reclass
    // $service_code_array_2 = [4,7]; // reclass, area correction
    // // log_message('error','4210********'.json_encode($row));
    // $service_type         = $this->getServiceName($row->case_no);
    // $table                = $this->getTableNameByServiceType($service_type);
    // $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no);
    // $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no);
    // $executionDate        = date('Y-m-d H:i:s');
    // //if escalated is same as execution date than only excute escalation=========
    // if($row->escalated_date == $executionDate)
    // {
    //   log_message('error','ESCALATESTART==========='.$row->case_no);
    //   // From LM to CO
    //   if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
    //   { 
    //     $originalAllocation      = $row->co_target_days;
    //     $previousCompletedDaysCO = $row->co_completed_days;
    //     $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
    //     $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    //     $lastAssignedDate = $row->assigned_date;

    //     $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

    //     $dateCodes             = $row->lm_date_code_list;
    //     $previousCompletedDays = $row->lm_completed_days;
    //     $lm_target_days        = $row->lm_target_days;


    //     // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
    //     $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

    //     // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
    //     if($lm_target_days <= $lm_completed_days)
    //     {   
    //       $escalate_status = 'Y';
    //     }
    //     else{
    //       $escalate_status = 'N';
    //     }

    //     // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
    //     if($dateCodes == null)
    //     {
    //       $dateCodes = $dateCode;
    //     }
    //     else
    //     {
    //       $dateCodes = $dateCodes.','.$dateCode;
    //     }
        
    //     $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
    //     $updateArray = array(
    //       'taskid'                      => $taskId[0]->CODE, // LM message
    //       'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
    //       'lm_escalate_status'          => $escalate_status,
    //       'assigned_from'               => $row->assigned_to,
    //       'assigned_from_code'          => $row->assigned_to_code,
    //       'assigned_to'                 => $row->assigned_from,
    //       'assigned_to_code'            => $row->assigned_from_code,
    //       'assigned_date'               => $executionDate,
    //       'escalated_date'              => $escalatedDate,
    //       'lm_date_code_list'           => $dateCodes,
    //       'to_be_completed_within_days' => $to_be_completed_within_days,
    //     );

    //     $updateFlag = true;
    //     $history_id = $row->history_id;

    //     // log_message("error","UPDATED FLAG ==========".$updateFlag);

    //     //STEPS to be followed:
    //     // 1. update escalation_dates_details against or history id
    //     // 2. update escalation_details with new date codes without history id
    //     // 3. insert history details and updated escalattion details with new history id

    //     $where_history = array(
    //       'petition_no' => $petition_no,
    //       'date_code'   => $history_id
    //     );
    //     $updateDatesArray = array(
    //       'completion_date'  => $executionDate,
    //       'escalated_status' => $escalate_status,
    //       'completion_days'  => $completion_days_for_history
    //     );

    //     $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

    //     $where = array(
    //       'petition_no' => $petition_no
    //     );

    //     $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    //     $date_history    = $this->Escalationmodel->generateDateCode();
    //     $insertDateArray = array(
    //       'sr_no'                  => $dateCode,
    //       'date_code'              => $date_history,
    //       'petition_no'            => $petition_no,
    //       'service_code'           => $row->service_code,
    //       'taskid'                 => $taskId[0]->CODE,
    //       'pending_officer'        => $row->assigned_from,
    //       'assigned_user'          => $row->assigned_to,
    //       'assigned_user_code'     => $row->assigned_to_code,
    //       'assigned_to'            => $row->assigned_from,
    //       'assigned_to_code'       => $row->assigned_from_code,
    //       'registerd_on'           => $row->registerd_on,
    //       'allocation_date'        => $executionDate,
    //       'target_completion_date' => $escalatedDate,
    //       'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
    //       'escalated_status'       => $escalate_status,
    //       'created_date'           => date('Y-m-d H:i:s'),
    //       'updated_date'           => date('Y-m-d H:i:s'),
    //     );

    //     // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    //     $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    //     if($status != 1)
    //     {
    //       log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
    //       return $response;
    //     }
    //     if($updateFlag == true)
    //     {
    //       $where_history_set = array(
    //         'petition_no' => $petition_no,
    //       );
    //       $updateDatesArraySet = array(
    //         'history_id'     => $date_history,
    //       );
    //       $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    //       if($this->db->affected_rows() <= 0)
    //       {
    //         log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$this->db->last_query());
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
    //         return $response;
    //       }
    //     }

    //     $updateTable = $this->updateServiceWiseTable($row->case_no);
    //     if($updateTable == 'n')
    //     {
    //       log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$this->db->last_query());
    //       $response['responseType'] = 0;
    //       $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
    //       return $response;
    //     }
    //   }

    //   // From SK to CO
    //   if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
    //   { 
    //     $originalAllocation      = $row->co_target_days;
    //     $previousCompletedDaysCO = $row->co_completed_days;
    //     $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
    //     $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    //     $lastAssignedDate = $row->assigned_date;

    //     $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

    //     $dateCodes             = $row->sk_date_code_list;
    //     $previousCompletedDays = $row->sk_completed_days;
    //     $sk_target_days        = $row->sk_target_days;

    //     // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
    //     $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

    //     // log_message("error","CO-COMPLETION_DAYS=======".$CO_completed_days);
    //     if($sk_target_days <= $sk_completed_days)
    //     {   
    //       $escalate_status = 'Y';
    //     }
    //     else{
    //       $escalate_status = 'N';
    //     }

    //     // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
    //     if($dateCodes == null)
    //     {
    //       $dateCodes = $dateCode;
    //     }
    //     else
    //     {
    //       $dateCodes = $dateCodes.','.$dateCode;
    //     }
        
    //     $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
    //     $updateArray = array(
    //       'taskid'                      => $taskId[1]->CODE, // SK message
    //       'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
    //       'sk_escalate_status'          => $escalate_status,
    //       'assigned_from'               => $row->assigned_to,
    //       'assigned_from_code'          => $row->assigned_to_code,
    //       'assigned_to'                 => $row->assigned_from,
    //       'assigned_to_code'            => $row->assigned_from_code,
    //       'assigned_date'               => $executionDate,
    //       'escalated_date'              => $escalatedDate,
    //       'sk_date_code_list'           => $dateCodes,
    //       'to_be_completed_within_days' => $to_be_completed_within_days,
    //     );

    //     $updateFlag = true;
    //     $history_id = $row->history_id;

    //     // log_message("error","UPDATED FLAG ==========".$updateFlag);

    //     //STEPS to be followed:
    //     // 1. update escalation_dates_details against or history id
    //     // 2. update escalation_details with new date codes without history id
    //     // 3. insert history details and updated escalattion details with new history id

    //     $where_history = array(
    //     'petition_no' => $petition_no,
    //     'date_code'   => $history_id
    //     );
    //     $updateDatesArray = array(
    //     'completion_date'  => $executionDate,
    //     'escalated_status' => $escalate_status,
    //     'completion_days'  => $completion_days_for_history
    //     );

    //     $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

    //     $where = array(
    //       'petition_no' => $petition_no
    //     );

    //     $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    //     $date_history    = $this->Escalationmodel->generateDateCode();
    //     $insertDateArray = array(
    //       'sr_no'                  => $dateCode,
    //       'date_code'              => $date_history,
    //       'petition_no'            => $petition_no,
    //       'service_code'           => $row->service_code,
    //       'taskid'                 => $taskId[0]->CODE,
    //       'pending_officer'        => $row->assigned_from,
    //       'assigned_user'          => $row->assigned_to,
    //       'assigned_user_code'     => $row->assigned_to_code,
    //       'assigned_to'            => $row->assigned_from,
    //       'assigned_to_code'       => $row->assigned_from_code,
    //       'registerd_on'           => $row->registerd_on,
    //       'allocation_date'        => $executionDate,
    //       'target_completion_date' => $escalatedDate,
    //       'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
    //       'escalated_status'       => $escalate_status,
    //       'created_date'           => date('Y-m-d H:i:s'),
    //       'updated_date'           => date('Y-m-d H:i:s'),
    //     );

    //     // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    //     $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    //     if($status != 1)
    //     {
    //       log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
    //       return $response;
    //     }
    //     if($updateFlag == true)
    //     {
    //       $where_history_set = array(
    //         'petition_no' => $petition_no,
    //       );
    //       $updateDatesArraySet = array(
    //         'history_id'     => $date_history,
    //       );
    //       $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    //       if($this->db->affected_rows() <= 0)
    //       {
    //         log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
    //         return $response;
    //       }
    //     }
        
    //     $updateTable = $this->updateServiceWiseTable($row->case_no);
    //     if($updateTable == 'n')
    //     {
    //       log_message("error","#ERR4448 : Update Failed on service wise table Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4448 : Update Failed on escalation_details Failed';
    //       return $response;
    //     }
    //   } 

    //   // From CO to DC for Reclass/AreaCOR cases========
    //   if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
    //   { 
    //     $originalAllocation      = $row->dc_target_days;
    //     //if dc target days null then get remaining days from other users with maximum available days
    //     //update dc target days from available users days
    //     //set zero for dc completion days

    //     $previousCompletedDaysDC = $row->dc_completed_days;
    //     $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
    //     $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    //     $lastAssignedDate = $row->assigned_date;

    //     $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

    //     $dateCodes             = $row->co_date_code_list;
    //     $previousCompletedDays = $row->co_completed_days;
    //     $co_target_days        = $row->co_target_days;

    //     // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
    //     $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

    //     // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
    //     if($co_target_days <= $co_completed_days)
    //     {   
    //       $escalate_status = 'Y';
    //     }
    //     else{
    //       $escalate_status = 'N';
    //     }

    //     // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
    //     if($dateCodes == null)
    //     {
    //       $dateCodes = $dateCode;
    //     }
    //     else
    //     {
    //       $dateCodes = $dateCodes.','.$dateCode;
    //     }

    //     $dcUserDetails = $this->EscalationModel->getPendingOfficerDC($caseDetails->dist_code,'DC');


    //     $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
    //     $updateArray = array(
    //       'taskid'                      => $taskId[1]->CODE, // SK message
    //       'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
    //       'co_escalate_status'          => $escalate_status,
    //       'assigned_from'               => $row->assigned_to,
    //       'assigned_from_code'          => $row->assigned_to_code,
    //       'assigned_to'                 => $dcUserDetails->user_code,
    //       'assigned_to_code'            => 2,
    //       'assigned_date'               => $executionDate,
    //       'escalated_date'              => $escalatedDate,
    //       'co_date_code_list'           => $dateCodes,
    //       'to_be_completed_within_days' => $to_be_completed_within_days,
    //     );

    //     $updateFlag = true;
    //     $history_id = $row->history_id;

    //     // log_message("error","UPDATED FLAG ==========".$updateFlag);

    //     //STEPS to be followed:
    //     // 1. update escalation_dates_details against or history id
    //     // 2. update escalation_details with new date codes without history id
    //     // 3. insert history details and updated escalattion details with new history id

    //     $where_history = array(
    //     'petition_no' => $petition_no,
    //     'date_code'   => $history_id
    //     );
    //     $updateDatesArray = array(
    //     'completion_date'  => $executionDate,
    //     'escalated_status' => $escalate_status,
    //     'completion_days'  => $completion_days_for_history
    //     );

    //     $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

    //     $where = array(
    //       'petition_no' => $petition_no
    //     );

    //     $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    //     $date_history    = $this->Escalationmodel->generateDateCode();
    //     $insertDateArray = array(
    //       'sr_no'                  => $dateCode,
    //       'date_code'              => $date_history,
    //       'petition_no'            => $petition_no,
    //       'service_code'           => $row->service_code,
    //       'taskid'                 => $taskId[0]->CODE,
    //       'pending_officer'        => $row->assigned_from,
    //       'assigned_user'          => $row->assigned_to,
    //       'assigned_user_code'     => $row->assigned_to_code,
    //       'assigned_to'            => $dcUserDetails->user_code,
    //       'assigned_to_code'       => 2,
    //       'registerd_on'           => $row->registerd_on,
    //       'allocation_date'        => $executionDate,
    //       'target_completion_date' => $escalatedDate,
    //       'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
    //       'escalated_status'       => $escalate_status,
    //       'created_date'           => date('Y-m-d H:i:s'),
    //       'updated_date'           => date('Y-m-d H:i:s'),
    //     );

    //     // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    //     $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    //     if($status != 1)
    //     {
    //       log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
    //       return $response;
    //     }
    //     if($updateFlag == true)
    //     {
    //       $where_history_set = array(
    //         'petition_no' => $petition_no,
    //       );
    //       $updateDatesArraySet = array(
    //         'history_id'     => $date_history,
    //       );
    //       $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    //       if($this->db->affected_rows() <= 0)
    //       {
    //         log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
    //         return $response;
    //       }
    //     }      

    //     $updateTable = $this->updateServiceWiseTable($row->case_no);
    //     if($updateTable == 'n')
    //     {
    //       log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
    //       return $response;
    //     }
    //   }

    //   // From CO to DC for MUT/PART/NCAN/NCOR cases========
    //   if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
    //   { 
          
    
    //     // this case is not under DC but it will pop up in dc escalated list==========
    //     //calculate maximum days from other users====

    //     $lmRemainingDays = $row->lm_target_days - $row->lm_completed_days;
    //     $skRemainingDays = $row->sk_target_days - $row->sk_completed_days;
    //     $coRemainingDays = $row->co_target_days - $row->co_completed_days;
    //     $daRemainingDays = $row->da_target_days - $row->da_completed_days;

    //     $arrayDays = array(
    //       'lm' => $lmRemainingDays,
    //       'sk' => $skRemainingDays,
    //       'co' => $coRemainingDays,
    //       'da' => $daRemainingDays
    //     );
    //     $maxValue = max($arrayDays);
    //     $maxIndex = array_search(max($arrayDays), $arrayDays);

    //     // log_message('error','******4659 : '.json_encode($maxValue,'---'.$maxIndex));

        

    //     //assigning max days to DC
    //     $originalAllocation      = $maxValue;
    //     $deEscalationUsed = false;
    //     if($originalAllocation <= 0)
    //     {
    //       $deEscalationUsed = true;
    //       // $originalAllocation = 2;
    //       ///get timeline from matrix version for de-escalation=================
    //       $timeLineForDeesc = $this->EscalationModel->getTimeLine($row->service_code,$service_type,DEESCALATE);
    //       if(empty($timeLineForDeesc))
    //       {
    //         log_message("error","#ERR4677 : update Failed on escalation_details Failed=======");
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4677 : De-escalation error';
    //         return $response;
    //       }


    //       $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
    //       $originalAllocation = $sumationOfTotalTime;

    //     }
    //     else
    //     {
    //       $originalAllocation = $maxValue;
    //     }


    //     if($deEscalationUsed == false)
    //     {

    //       //update other users completed days as days are used by DC=========
    //       $updateField = $maxIndex.'_completed_days';

    //       $statusUpdate = $this->updateDaysForDC($row->case_no,$originalAllocation,$updateField);
    //       if($statusUpdate != 1)
    //       {
    //         log_message("error","#ERR4680 : update Failed on escalation_details Failed=======".$this->db->last_query());
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4680 : Update Failed on escalation_details Failed';
    //         return $response;
    //       }

    //     }
        


    //     $previousCompletedDaysDC = 0;



    //     $remaining_days_other    = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
    //     $escalatedDate           = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other,$executionDate);

    //     $lastAssignedDate = $row->assigned_date;

    //     $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate); 

    //     $dateCodes             = $row->co_date_code_list;
    //     $previousCompletedDays = $row->co_completed_days;
    //     $co_target_days        = $row->co_target_days;

    //     // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
    //     $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

    //     // log_message("error","CO-COMPLETION_DAYS=======".$co_completed_days);
    //     // if($co_target_days < $co_completed_days)
    //     // {   
    //       $escalate_status = 'Y';
    //     // }
    //     // else{
    //     //   $escalate_status = 'N';
    //     // }

    //     // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
    //     if($dateCodes == null)
    //     {
    //       $dateCodes = $dateCode;
    //     }
    //     else
    //     {
    //       $dateCodes = $dateCodes.','.$dateCode;
    //     }


          
    //     $dcUserDetails = $this->EscalationModel->getPendingOfficerDC($caseDetails->dist_code,'DC');

    //     $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
    //     $updateArray = array(
    //       'taskid'                      => $taskId[1]->CODE, // SK message
    //       'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
    //       'co_escalate_status'          => $escalate_status,
    //       'assigned_from'               => $row->assigned_to,
    //       'assigned_from_code'          => $row->assigned_to_code,
    //       'assigned_to'                 => $dcUserDetails->user_code,
    //       'assigned_to_code'            => 2,  //hard code for DC
    //       'assigned_date'               => $executionDate,
    //       'escalated_date'              => $escalatedDate,
    //       'co_date_code_list'           => $dateCodes,
    //       'to_be_completed_within_days' => $to_be_completed_within_days,
    //       'dc_target_days'              => $originalAllocation - $co_completed_days, // for DC new assigning days
    //       'dc_allocate_days'            => $originalAllocation - $co_completed_days, // dc allocate days
    //       'dc_completed_days'           => 0, //set Zero for Newly assigned
    //     );

    //     $updateFlag = true;
    //     $history_id = $row->history_id;

    //     // log_message("error","UPDATED FLAG ==========".$updateFlag);

    //     //STEPS to be followed:
    //     // 1. update escalation_dates_details against or history id
    //     // 2. update escalation_details with new date codes without history id
    //     // 3. insert history details and updated escalattion details with new history id

    //     $where_history = array(
    //     'petition_no' => $petition_no,
    //     'date_code'   => $history_id
    //     );
    //     $updateDatesArray = array(
    //     'completion_date'  => $executionDate,
    //     'escalated_status' => $escalate_status,
    //     'completion_days'  => $completion_days_for_history
    //     );

    //     $updateStatus22=$this->db->update('escalation_dates_details',$updateDatesArray,$where_history);

    //     $where = array(
    //       'petition_no' => $petition_no
    //     );

    //     $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    //     $date_history    = $this->Escalationmodel->generateDateCode();
    //     $insertDateArray = array(
    //       'sr_no'                  => $dateCode,
    //       'date_code'              => $date_history,
    //       'petition_no'            => $petition_no,
    //       'service_code'           => $row->service_code,
    //       'taskid'                 => $taskId[3]->CODE,
    //       'pending_officer'        => $row->assigned_from,
    //       'assigned_user'          => $row->assigned_to,
    //       'assigned_user_code'     => $row->assigned_to_code,
    //       'assigned_to'            => $dcUserDetails->user_code,
    //       'assigned_to_code'       => 2,
    //       'registerd_on'           => $row->registerd_on,
    //       'allocation_date'        => $executionDate,
    //       'target_completion_date' => $escalatedDate,
    //       'date_diff'              => $this->Escalationmodel->dateDiff($escalatedDate,$executionDate),
    //       'escalated_status'       => 'N',
    //       'created_date'           => date('Y-m-d H:i:s'),
    //       'updated_date'           => date('Y-m-d H:i:s'),
    //     );

    //     // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
    //     $status = $this->db->insert('escalation_dates_details',$insertDateArray);
    //     if($status != 1)
    //     {
    //       log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
    //       return $response;
    //     }
    //     if($updateFlag == true)
    //     {
    //       $where_history_set = array(
    //         'petition_no' => $petition_no,
    //       );
    //       $updateDatesArraySet = array(
    //         'history_id'     => $date_history,
    //       );
    //       $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
    //       if($this->db->affected_rows() <= 0)
    //       {
    //         log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$this->db->last_query());
    //         $response['responseType'] =0;
    //         $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
    //         return $response;
    //       }
    //     }      
        
    //     $updateTable = $this->updateServiceWiseTable($row->case_no);
    //     if($updateTable == 'n')
    //     {
    //       log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$this->db->last_query());
    //       $response['responseType'] =0;
    //       $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
    //       return $response;
    //     }
    //   }


    //   // from CO to DC for reverted deescalation cases
    //   if()


    // }

    // log_message('error','ESCALATENOT---START==========='.$row->case_no);

      
  }



}