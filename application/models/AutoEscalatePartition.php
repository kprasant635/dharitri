<?php
class AutoEscalatePartition extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->model('Escalationmodel');
    $this->load->model('AutoRegistrationmodel');
    $this->load->model('EscalationHolidayModel');
  }

  // field partion auto escalation
  public function autoEscalationMatrixUpdateFieldPartion($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days)
  {    
    $response = array('responseType' => 1,'msg' => null);
    $petition_no = $this->Escalationmodel->getPetitionNo($case_no,$service_code,'FPART');
    if($petition_no == null || $petition_no == '')
    {
      $response['responseType'] = 0;
      $response['msg'] = '#ERRFPART17 : Petition No not found';
      return $response;
    }
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////
    
    $doubleEntry = 0;

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
    {
      $response['responseType'] = 0;
      $response['msg'] = '#ERRFPART30 : Escalation Matrix Row Not Updated';
      return $response;
    }

    // log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

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

    // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'FPART');

    if(empty($timeLineRow) || $timeLineRow == null)
    {
      $response['responseType'] = 0;
      $response['msg'] = '#ERRFPART60 : Escalation Timeline Not Updated';
      return $response;
    }

    
    if($assigned_user_type == 'LM'){

      $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
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
    // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if($user_type == 'CO'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

      $co_target_days    = $escalatedRowDetailsAgainstPetitionno->co_target_days;

      // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

      $co_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
      if($co_target_days < $co_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
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
        'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
        'co_escalate_status'          => $escalate_status,
        'assigned_to'                 => $assigned_to,
        'assigned_to_code'            => $assigned_to_code,
        'assigned_from'               => $user_code,
        'assigned_from_code'          => $assigned_from_code,
        'assigned_date'               => $executionDate,
        'escalated_date'              => $escalatedDate,
        'to_be_completed_within_days' => $to_be_completed_within_days,
        'co_date_code_list'           => $dateCodes
      );

    }

    if($user_type == 'SK'){
      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);


      $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $sk_target_days    = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
      $sk_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
      if($sk_target_days < $sk_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
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
      // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      ///end==============

      $updateArray = array(
        'taskid'                      => $taskid,
        'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
        'sk_escalate_status'          => $escalate_status,
        'assigned_from'               => $user_code,
        'assigned_from_code'          => $assigned_from_code,
        'assigned_to'                 => $assigned_to,
        'assigned_to_code'            => $assigned_to_code,
        // 'assigned_date'               => $executionDate,
        'assigned_date'               => $hearing_date,
        'escalated_date'              => $assigned_other_es_date,
        'sk_date_code_list'           => $dateCodes,
        'to_be_completed_within_days' => $to_be_completed_within_days,
      );

      // log_message("error","CO==============SK".json_encode($updateArray));

    }

    if($user_type == 'LM'){

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);

      $dateCodes         = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days    = $escalatedRowDetailsAgainstPetitionno->lm_target_days;


      // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
      $lm_completed_days =  $this->Escalationmodel->dateDiff($executionDate,$lastAssignedDate);
      // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
      if($lm_target_days < $lm_completed_days){   
        $escalate_status = 'Y';
      }else{
        $escalate_status = 'N';
      }
      // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
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
      //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
      //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
      //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
      //   $executionDate = $hearing_date;
      //   $escalatedDate = $assigned_other_es_date;
      // }
      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate,$executionDate);
      $updateArray = array(
        'taskid'                      => $taskid,
        'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
        'lm_escalate_status'          => $escalate_status,
        'assigned_from'               => $user_code,
        'assigned_from_code'          => $assigned_from_code,
        'assigned_to'                 => $assigned_to,
        'assigned_to_code'            => $assigned_to_code,
        'assigned_date'               => $executionDate,
        'escalated_date'              => $escalatedDate,
        'lm_date_code_list'           => $dateCodes,
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

    // log_message("error","UPDATED FLAG ==========".$updateFlag);

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
    // log_message("error","Update history escalation_dates_details TABLE=======".$this->db->affected_rows());
    if($this->db->affected_rows() <= 0)
    {
      log_message("error","#ERRFPART70 : Update history escalation_dates_details TABLE=======".$this->db->affected_rows());
      $response['responseType'] =0;
      $response['msg'] = '#ERRFPART70 : Update Failed on escalation';
      return $response;
    }

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

    // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details',$updateArray ,$where);

    // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    // if($this->db->affected_rows() <= 0){
    //    $flag = 0;
    // }else{
    //    $flag = 1;
    // }
    if($this->db->affected_rows() <= 0)
    {
      log_message("error","#ERRFPART80 : Update Failed on escalation_details Failed=======".$this->db->last_query());
      $response['responseType'] =0;
      $response['msg'] = '#ERRFPART80 : Update Failed on escalation_details Failed';
      return $response;
    }
    


    if($doubleEntry == 0 && $finalStatus == null){
        // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
        //   $executionDate = $hearing_date;
        //   $escalatedDate = $assign      ed_other_es_date;
        // }

        $date_history    = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
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
        // if($finalStatus == 'final'){
        //   $insertDateArray['completion_date'] = $executionDate; 
        // }
        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERRFPART90 : Insert Failed on escalation_dates_details Failed=======".$this->db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERRFPART90 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true){
          $where_history_set = array(
            'petition_no' => $petition_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $this->db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($this->db->affected_rows() <= 0)
          {
            log_message("error","#ERRFPART100 : Update Failed on escalation_details Failed=======".$this->db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERRFPART100 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
    }
    return $response;
  }


  // field partition auto escalation from LM to CO
  public function autoEscalationFieldPartFromLmToCo()
  {
    $remain_days        = '';
    $executeDate        = date('Y-m-d');
    $user_code          = $this->session->userdata('user_code');
    $user_desig_code    = $this->session->userdata('user_desig_code');

    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $lot_no             = $this->session->userdata('lot_no');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $define_date        = define_date;

    $this->db->select('field_mut_basic.*, escalation_details.case_no as c_no, escalation_details.*');
    $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('lot_no', $lot_no);
    $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    $this->db->where('date(date_entry) >=', $define_date);
    $this->db->where('mut_type', '02');
    $this->db->where('is_dispose IS NULL');
    $this->db->where('es_flag', '1');
    $this->db->where('is_escalated', 0);

    $query = $this->db->get('field_mut_basic');

    // switch Database
    // $this->session->set_userdata('dist_code', $dist_code);
    $db = $this->AutoRegistrationmodel->dbswitch();

    //get holidays
    $executionDate = $this->EscalationHolidayModel->getHoliday($executeDate, $db, $dist_code);


    if($query->num_rows() <= 0){
      return;
    }    
    else 
    {
      $this->db->trans_begin();
      foreach($query->result() as $row) 
      {
        $remain_days = $this->EscalationModel->dateDiff($row->escalated_date, $executionDate);
        $new_hearing_date = date('Y-m-d', strtotime($executionDate. ' + 30 days'));

        if($remain_days <= 1)
        {
          $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'CO');
          $user_type              = 'LM';
          $service_code           = '3';
          $assigned_to_code       = $assigned_to->user_code;
          $assigned_user_type     = 'CO';
          $assigned_to_other_type = null;
          $finalStatus            = null;
          $assigned_to_other      = null;
          $hearing_date           = null;
          $task                   = json_decode(FPART_TASK);
          $taskid                 = $task[5]->CODE;
          $assignment_type        = null;
          $assignment_type_other  = null;
          $allocation_days        = 0;

          $escalationUpdateStatus = $this->autoEscalationMatrixUpdateFieldPartion($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to_code,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days);

          if($escalationUpdateStatus != 1 || $escalationUpdateStatus != true){
            log_message('error', '#ERR450: Updation failed '.$this->db->last_query());
            $this->db->trans_rollback();
            return;
          }
        }

        if($remain_days <= 1) { $is_escalated = 0; }
        else { $is_escalated = 1; }

        //update field_mut_basic table
        $updatePetitionBasic = $this->db->query("UPDATE field_mut_basic SET 
                                    is_escalated=? WHERE petition_no=? AND case_no=?
                                      AND is_escalated=? AND es_flag=?", array($is_escalated, $row->petition_no, $row->case_no, 0, 1));

        if($this->db->affected_rows() <= 0) {
          log_message('error', '#ERR478: Updation failed '.$this->db->last_query());
          $this->db->trans_rollback();
          return;
        }
      }
    }
    $this->db->trans_commit();
    return;
  }

  

}
?>