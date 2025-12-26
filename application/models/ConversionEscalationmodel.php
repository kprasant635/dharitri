<?php
class ConversionEscalationModel extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Escalationmodel');
  }

  // common array for all users Conversion
  public function escalationZoneWiseSearchConversion($zone_status, $user_code, $array, $target_days)
  {
    $row = json_decode($array);
    $curr_date = date('Y-m-d');
    $esc_date = $row->escalated_date;
    $esc_flag = $row->es_flag;
    $final_array = '';

    if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1) && $target_days>0) 
    {
      $remaining_days = $this->Escalationmodel->dateDiff($esc_date, $curr_date);
      $per_avail = (100 * $remaining_days) / $target_days;

      //green zone
      if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) 
      {
        $final_array = (object) [
          'case_no'               => $row->c_no,
          'dist_code'             => $row->dist_code,
          'subdiv_code'           => $row->subdiv_code,
          'cir_code'              => $row->cir_code,
          'mouza_pargona_code'    => $row->mouza_pargona_code,
          'lot_no'                => $row->lot_no,
          'vill_townprt_code'     => $row->vill_townprt_code,
          'basundhara'            => $row->rtps_no,
          'submission_date'       => $row->submission_date,
          'escalated_date'        => $row->escalated_date,
          'es_flag'               => $row->es_flag,
          'assigned_from'         => $row->user_code,
          'co_target_days'        => $target_days,
          'assigned_date'         => $row->assigned_date,
          'date_entry'            => $row->date_entry,
          'application_ref_no'    => $row->rtps_no,
          'next_date_of_hearing'  => $row->next_date_of_hearing,
          'status'                => $row->status,
          'lm_note_yn'            => $row->lm_note_yn,
          'notice_generated_yn'   => $row->notice_generated_yn,
          'sk_comment'            => $row->sk_comment,
          'proceeding_yn'         => $row->proceeding_yn,
          'is_escalated'          => $row->is_escalated,
        ];
      }
      //yellow zone
      else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) 
      {
        $final_array = (object) [
          'case_no'               => $row->c_no,
          'dist_code'             => $row->dist_code,
          'subdiv_code'           => $row->subdiv_code,
          'cir_code'              => $row->cir_code,
          'mouza_pargona_code'    => $row->mouza_pargona_code,
          'lot_no'                => $row->lot_no,
          'vill_townprt_code'     => $row->vill_townprt_code,
          'basundhara'            => $row->rtps_no,
          'submission_date'       => $row->submission_date,
          'escalated_date'        => $row->escalated_date,
          'es_flag'               => $row->es_flag,
          'assigned_from'         => $row->user_code,
          'co_target_days'        => $target_days,
          'assigned_date'         => $row->assigned_date,
          'date_entry'            => $row->date_entry,
          'application_ref_no'    => $row->rtps_no,
          'next_date_of_hearing'  => $row->next_date_of_hearing,
          'status'                => $row->status,
          'lm_note_yn'            => $row->lm_note_yn,
          'notice_generated_yn'   => $row->notice_generated_yn,
          'sk_comment'            => $row->sk_comment,
          'proceeding_yn'         => $row->proceeding_yn,
          'is_escalated'          => $row->is_escalated,
        ];
      }
      //red zone
      else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) 
      {
        $final_array = (object) [
          'case_no'               => $row->c_no,
          'dist_code'             => $row->dist_code,
          'subdiv_code'           => $row->subdiv_code,
          'cir_code'              => $row->cir_code,
          'mouza_pargona_code'    => $row->mouza_pargona_code,
          'lot_no'                => $row->lot_no,
          'vill_townprt_code'     => $row->vill_townprt_code,
          'basundhara'            => $row->rtps_no,
          'submission_date'       => $row->submission_date,
          'escalated_date'        => $row->escalated_date,
          'es_flag'               => $row->es_flag,
          'assigned_from'         => $row->user_code,
          'co_target_days'        => $target_days,
          'assigned_date'         => $row->assigned_date,
          'date_entry'            => $row->date_entry,
          'application_ref_no'    => $row->rtps_no,
          'next_date_of_hearing'  => $row->next_date_of_hearing,
          'status'                => $row->status,
          'lm_note_yn'            => $row->lm_note_yn,
          'notice_generated_yn'   => $row->notice_generated_yn,
          'sk_comment'            => $row->sk_comment,
          'proceeding_yn'         => $row->proceeding_yn,
          'is_escalated'          => $row->is_escalated,
        ];
      }
      //old cases
      else if ($zone_status == 4) 
      {
        $final_array = (object) [
            'case_no'               => $row->c_no,
          'dist_code'             => $row->dist_code,
          'subdiv_code'           => $row->subdiv_code,
          'cir_code'              => $row->cir_code,
          'mouza_pargona_code'    => $row->mouza_pargona_code,
          'lot_no'                => $row->lot_no,
          'vill_townprt_code'     => $row->vill_townprt_code,
          'basundhara'            => $row->rtps_no,
          'submission_date'       => $row->submission_date,
          'escalated_date'        => $row->escalated_date,
          'es_flag'               => $row->es_flag,
          'assigned_from'         => $row->user_code,
          'co_target_days'        => $target_days,
          'assigned_date'         => $row->assigned_date,
          'date_entry'            => $row->date_entry,
          'application_ref_no'    => $row->rtps_no,
          'next_date_of_hearing'  => $row->next_date_of_hearing,
          'status'                => $row->status,
          'lm_note_yn'            => $row->lm_note_yn,
          'notice_generated_yn'   => $row->notice_generated_yn,
          'sk_comment'            => $row->sk_comment,
          'proceeding_yn'         => $row->proceeding_yn,
          'is_escalated'          => $row->is_escalated,
        ];
      }
    } 
    else {
      $final_array = (object) [
        'case_no'               => $row->c_no,
        'dist_code'             => $row->dist_code,
        'subdiv_code'           => $row->subdiv_code,
        'cir_code'              => $row->cir_code,
        'mouza_pargona_code'    => $row->mouza_pargona_code,
        'lot_no'                => $row->lot_no,
        'vill_townprt_code'     => $row->vill_townprt_code,
        'basundhara'            => $row->rtps_no,
        'submission_date'       => $row->submission_date,
        'escalated_date'        => $row->escalated_date,
        'es_flag'               => $row->es_flag,
        'assigned_from'         => $row->user_code,
        'co_target_days'        => $target_days,
        'assigned_date'         => $row->assigned_date,
        'date_entry'            => $row->date_entry,
        'application_ref_no'    => $row->rtps_no,
        'next_date_of_hearing'  => $row->next_date_of_hearing,
        'status'                => $row->status,
        'lm_note_yn'            => $row->lm_note_yn,
        'notice_generated_yn'   => $row->notice_generated_yn,
        'sk_comment'            => $row->sk_comment,
        'proceeding_yn'         => $row->proceeding_yn,
        'is_escalated'          => $row->is_escalated,
      ];
    }
    return $final_array;
  }


  // **************************** CIRCLE OFFICER ************************************

  // pending cases for CO
  public function getPendingConversionCasesForCo($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
  {
    $curr_date = date('Y-m-d');
    $col = 0;
    $dir = "asc";
    if (!empty($order)) {
      foreach ($order as $o) {
        $col = $o['column'];
        $dir = $o['dir'];
      }
    }

    if ($dir != "asc" && $dir != 'desc') {
      $dir = 'desc';
    }
    $valid_columns = array(
      0 => 'petition_basic.petition_no',
    );
    if (!isset($valid_columns[$col])) {
      $order = null;
    } else {
      $order = $valid_columns[$col];
    }
    if ($order != null) {
      $this->db->order_by($order, $dir);
    }
    if (!empty($searchByCol_0)) {
      $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }

    $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('petition_basic.dist_code', $dist_code);
    $this->db->where('petition_basic.subdiv_code', $subdiv_code);
    $this->db->where('petition_basic.cir_code', $cir_code);

    $this->db->where('petition_basic.not_fresh IS NULL');
    $this->db->where('petition_basic.lm_note_yn IS NULL');
    $this->db->where('petition_basic.mut_type', '01');
    $this->db->where('petition_basic.co_user_code', $user_code);
    $this->db->where('petition_basic.date_entry >=', $define_date);
    $this->db->where("petition_basic.status IS NULL OR petition_basic.status = 'P'");
  
    if ($zone_status == 4) {
        $this->db->where('petition_basic.es_flag', 0);
    } else {
        $this->db->where('petition_basic.es_flag', 1);
    }
    $this->db->limit($length, $start);
    $query = $this->db->get('petition_basic');
    // log_message('error', "#13662: petition_basic: " . $this->db->last_query());
    if ($query->num_rows() > 0) 
    {
      $data_results = $query->result();
      $final_array = array();
      foreach ($data_results as $rr) {

        $row_array = json_encode($rr);

        // log_message('error', "#13662_RR: petition_basic: " .json_encode($rr));

        $variable=$this->escalationZoneWiseSearchConversion($zone_status, $user_code, $row_array, $rr->co_target_days);

        if (!empty($variable)) {
          $final_array[] = $variable;
        }
      }
      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);
      if (!empty($searchByCol_0)) {
        $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
      }
      $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

      $this->db->where('petition_basic.dist_code', $dist_code);
      $this->db->where('petition_basic.subdiv_code', $subdiv_code);
      $this->db->where('petition_basic.cir_code', $cir_code);

      $this->db->where('petition_basic.not_fresh IS NULL');
      $this->db->where('petition_basic.lm_note_yn IS NULL');
      $this->db->where('petition_basic.mut_type', '01');
      $this->db->where('petition_basic.co_user_code', $user_code);
      $this->db->where('petition_basic.date_entry >=', $define_date);
      $this->db->where("petition_basic.status IS NULL OR petition_basic.status = 'P'");

      if ($zone_status == 4) {
        $this->db->where('petition_basic.es_flag', 0);
      } else {
        $this->db->where('petition_basic.es_flag', 1);
      }
      $res = $this->db->get('petition_basic')->result();
      // echo $this->db->last_query();
      $cc = array();
      foreach ($res as $r) {
        if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)  && $r->co_target_days>0) {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100 * $remain_days) / $r->co_target_days;
          //green zone
          if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
            $cc[] = 1;
          }
          //red zone
          else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
            $cc[] = 1;
          } else if ($zone_status == 4) {
            $cc[] = 1;
          }
        } else {
          $cc[] = 1;
        }
      }
      $data['total_records'] = count($cc);
      return $data;
    }
  }

  public function escalationCoConversionReport($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
  {
    $assigned_to = $this->Escalationmodel->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
    $user_type          = 'CO';
    $service_code       = '9';
    $assigned_to_code   = $assigned_to->user_code;
    $assigned_user_type = 'LM';
    $finalStatus        = null;
    $hearing_date       = null;
    $task               = json_decode(CONV);
    $taskid             = $task[1]->CODE;
    $assignment_type    = null;
    $allocation_days    = 0;
    $service_type       = explode('/',$case_no);
    $response           = array();

    $escalationUpdateStatus = $this->escalationMatrixUpdateConversion($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);

    return $escalationUpdateStatus;
  }

  // **************************** CIRCLE OFFICER ************************************


  // **************************** LOT MONDOL ************************************

  // pending cases for LM
  public function getPendingConversionCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, 
    $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
  {
    $curr_date = date('Y-m-d');
    $col = 0;
    $dir = "asc";
    if (!empty($order)) {
      foreach ($order as $o) {
        $col = $o['column'];
        $dir = $o['dir'];
      }
    }

    if ($dir != "asc" && $dir != 'desc') {
      $dir = 'desc';
    }
    $valid_columns = array(
      0 => 'petition_basic.petition_no',
    );
    if (!isset($valid_columns[$col])) {
      $order = null;
    } else {
      $order = $valid_columns[$col];
    }
    if ($order != null) {
      $this->db->order_by($order, $dir);
    }
    if (!empty($searchByCol_0)) {
      $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }

    $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

    $this->db->where('petition_basic.dist_code', $dist_code);
    $this->db->where('petition_basic.subdiv_code', $subdiv_code);
    $this->db->where('petition_basic.cir_code', $cir_code);
    $this->db->where('petition_basic.mouza_pargona_code', $mouza);
    $this->db->where('petition_basic.lot_no', $lot_no);

    $this->db->where('petition_basic.not_fresh', 'Y');
    $this->db->where('petition_basic.lm_note_yn IS NULL');
    $this->db->where("petition_basic.status IN ('P','R')");
    $this->db->where('petition_basic.date_entry >=', $define_date);
    $this->db->where('petition_basic.mut_type', '01');
  
    if ($zone_status == 4) {
        $this->db->where('petition_basic.es_flag', 0);
    } else {
        $this->db->where('petition_basic.es_flag', 1);
    }
    $this->db->limit($length, $start);
    $query = $this->db->get('petition_basic');
    // log_message('error', "#65: petition_basic: " . $this->db->last_query());
    if ($query->num_rows() > 0) 
    {
      $data_results = $query->result();
      $final_array = array();
      foreach ($data_results as $rr) {

        $row_array = json_encode($rr);

        // log_message('error', "#74_RR: petition_basic: " .json_encode($rr));

        $variable=$this->escalationZoneWiseSearchConversion($zone_status, $user_code, $row_array, $rr->co_target_days);

        if (!empty($variable)) {
          $final_array[] = $variable;
        }
      }
      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);
      if (!empty($searchByCol_0)) {
        $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
      }
      $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

      $this->db->where('petition_basic.dist_code', $dist_code);
      $this->db->where('petition_basic.subdiv_code', $subdiv_code);
      $this->db->where('petition_basic.cir_code', $cir_code);
      $this->db->where('petition_basic.mouza_pargona_code', $mouza);
      $this->db->where('petition_basic.lot_no', $lot_no);

      $this->db->where('petition_basic.not_fresh', 'Y');
      $this->db->where('petition_basic.lm_note_yn IS NULL');
      $this->db->where("petition_basic.status IN ('P','R')");
      $this->db->where('petition_basic.date_entry >=', $define_date);
      $this->db->where('petition_basic.mut_type', '01');

      if ($zone_status == 4) {
        $this->db->where('petition_basic.es_flag', 0);
      } else {
        $this->db->where('petition_basic.es_flag', 1);
      }
      $res = $this->db->get('petition_basic')->result();
      // echo $this->db->last_query();
      $cc = array();
      foreach ($res as $r) {
        if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)  && $r->co_target_days>0) {
          $remain_days = $this->Escalationmodel->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100 * $remain_days) / $r->co_target_days;
          //green zone
          if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
            $cc[] = 1;
          }
          //red zone
          else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
            $cc[] = 1;
          } else if ($zone_status == 4) {
            $cc[] = 1;
          }
        } else {
          $cc[] = 1;
        }
      }
      $data['total_records'] = count($cc);
      return $data;
    }
  }

  public function escalationLmConversionReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $check_whetherOr)
  {
    $executionDate      = $executionDate;
    $assigned_to        = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'SK');
    $user_type          = 'LM';
    $service_code       = '9';
    $assigned_to_code   = $assigned_to->user_code;
    $assigned_user_type = 'SK';      
    $finalStatus        = null;
    $hearing_date       = null;
    $task               = json_decode(CONV);
    $taskid             = $task[2]->CODE;
    $assignment_type    = null;
    $allocation_days    = 0;
    $service_type       = explode('/',$case_no);
    $response           = array();

    $escalationUpdateStatus = $this->escalationMatrixUpdateConversion($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days, $check_whetherOr);

    return $escalationUpdateStatus;
  }

  // **************************** LOT MONDOL ************************************


  public function escalationMatrixUpdateConversion($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days, $check_whetherOr)
  {
    $response = array('responseType' => 1, 'msg' => null);
    $petition_no = $this->Escalationmodel->getPetitionNoOMUT($case_no);
    if ($petition_no == null || $petition_no == '') {
        $response['responseType'] = 0;
        $response['msg'] = '#ERRESC485 : Petition no not found';
        return $response;
    }
    // WARNING BEFORE CODE=========================
    // $assigned_to_other_type may be notice or role name
    ///////////////////////////////////

    $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetails($petition_no);
    if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
      $response['responseType'] = 0;
      $response['msg'] = '#ERRESC495 : Escalation row not found';
      return $response;
    }
    $assigned_to_code = $assigned_from_code = null;
    
    $userCodeList = json_decode(USER_ALLOT_CODE);
    foreach ($userCodeList as $key => $value) {
      if ($value->USER == $user_type) {
        $assigned_from_code = $value->CODE;
      }
      if ($value->USER == $assigned_user_type) {
        $assigned_to_code = $value->CODE;
      }
    }

    $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
    // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);

    $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
    
    $validateExecutionDateTime = $this->Escalationmodel->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);

    // log_message('error', 'validation:--' . json_encode($validateExecutionDateTime));

    if ($validateExecutionDateTime == 'n') {
      $response['responseType'] = 0;
      $response['msg'] = '#ERRESC521 : Case Execution not on Time';
      return $response;
    }

    $timeLineRow = $this->Escalationmodel->getTimeLine($escalatedRowDetailsAgainstPetitionno->service_code, $stype);

    if ($timeLineRow == null || empty($timeLineRow)) {
        $response['responseType'] = 0;
        $response['msg'] = '#ERRESC544 : Escalation row not found';
        return $response;
    }

    $entryTimes = 0;

    if ($assigned_user_type == 'CO') 
    {
      $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
      $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
      $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
    } 
    elseif ($assigned_user_type == 'LM') 
    {
      $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
      $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
    } 
    elseif ($assigned_user_type == 'SK') 
    {
      $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
      $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
      $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
    }
    elseif ($assigned_user_type == 'ADC') 
    {
      $originalAllocation = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
      $previousCompletedDaysAdc = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysAdc, $originalAllocation);
      $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
    }
    elseif ($assigned_user_type == 'DC') 
    {
      $originalAllocation = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
      $previousCompletedDaysDc = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
      $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDc, $originalAllocation);
      $escalatedDate = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
    }

    $dateCode = $this->Escalationmodel->generateDateCode();
    // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
    if ($user_type == 'CO') {
        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);
        $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

        $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

        $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

        // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

        $co_completed_days = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);

        // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
        if ($co_target_days < $co_completed_days) {
            $escalate_status = 'Y';
        } else {
            $escalate_status = 'N';
        }
        // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
        $latestHistoryCode = $dateCodes;
        if ($dateCodes == null) {
            $dateCodes = $dateCode;
        } else {
            $dateCodes = $dateCodes . ',' . $dateCode;
        }
        $entryTimes = 0;
        $doubleEntry = 0;
        $assigned_other_date = null;
        $to_be_other_completed_within_days = null;
        $assigned_other_es_date = null;
        if ($assigned_to_other != null) {
            //this is designed for CO first proceding as assigned to LM and DA==========
            $entryTimes = 1;
            //////////

            $assigned_other_date = $executionDate;
            if ($assigned_to_other_type == 'LM') {
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                $assigned_other_es_date = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $executionDate);
                $to_be_other_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date, $executionDate);
            } 

        }
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate, $executionDate);

        $updateArray = array(
            'taskid' => $taskid,
            'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
            'co_escalate_status' => $escalate_status,
            'assigned_to' => $assigned_to,
            'assigned_to_code' => $assigned_to_code,
            'assigned_from' => $user_code,
            'assigned_from_code' => $assigned_from_code,
            'assigned_date' => $executionDate,
            'escalated_date' => $escalatedDate,
            'to_be_completed_within_days' => $to_be_completed_within_days,
            'co_date_code_list' => $dateCodes,
            'assignment_type_other' => $assignment_type_other,
            'assigned_other' => $assigned_to_other,
            'assigned_other_code' => $assigned_other_code,
            'assigned_other_date' => $assigned_other_date,
            'assigned_other_es_date' => $assigned_other_es_date,
            'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
        );
    }



    if ($user_type == 'LM') {

      $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);

      $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
      $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
      $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
      // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);

      $lm_completed_days = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);
      // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);

      if ($lm_target_days < $lm_completed_days) {
        $escalate_status = 'Y';
      } else {
        $escalate_status = 'N';
      }
      // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
      if ($dateCodes == null) {
        $dateCodes = $dateCode;
      } else {
        $dateCodes = $dateCodes . ',' . $dateCode;
      }

      $to_be_completed_within_days = $this->Escalationmodel->dateDiff($escalatedDate, $executionDate);
      $updateArray = array(
        'taskid' => $taskid,
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
    

    if ($user_type == 'SK') {
        $completion_days_for_history = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);

        $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
        $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
        $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
        // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
        $sk_completed_days = $this->Escalationmodel->dateDiff($executionDate, $lastAssignedDate);
        // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
        if ($sk_target_days < $sk_completed_days) {
            $escalate_status = 'Y';
        } else {
            $escalate_status = 'N';
        }
        // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
        if ($dateCodes == null) {
            $dateCodes = $dateCode;
        } else {
            $dateCodes = $dateCodes . ',' . $dateCode;
        }

        //this calculation is for assigning CO from SK and taking hearing date as assigned date====
        $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
        $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
        $remaining_days_other = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
        // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
        $assigned_other_es_date = $this->Escalationmodel->getOtherEscalatedDate($remaining_days_other, $hearing_date);
        $to_be_completed_within_days = $this->Escalationmodel->dateDiff($assigned_other_es_date, $hearing_date);
        // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

        ///end==============

        //if action taken done then co assigned date is sk report date
        //otherwise co report date is action taken date

        $checkDAActionTakenDoneOrNot = $escalatedRowDetailsAgainstPetitionno->assigned_other;
        if ($checkDAActionTakenDoneOrNot == null) {
            $hearing_date = $executionDate;
            $assigned_other_es_date = $this->Escalationmodel->getEscalatedDateNew($remaining_days_other, $hearing_date);
        }

        $updateArray = array(
            'taskid' => $taskid,
            'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
            'sk_escalate_status' => $escalate_status,
            'assigned_from' => $user_code,
            'assigned_from_code' => $assigned_from_code,
            'assigned_to' => $assigned_to,
            'assigned_to_code' => $assigned_to_code,
            // 'assigned_date'      => $executionDate,
            'assigned_date' => $hearing_date,
            'escalated_date' => $assigned_other_es_date,
            'sk_date_code_list' => $dateCodes,
            'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        // log_message("error","CO==============SK".json_encode($updateArray));

    }

    

    //UPDATE ESCALATION DATE HISTORY TABLE=====================

    $updateFlag = true;
    if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
        $updateFlag = false;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
    } else {
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
    }

    // log_message("error","UPDATED FLAG ==========".$updateFlag);

    //STEPS to be followed:
    // 1. update escalation_dates_details against or history id
    // 2.update escalation_details with new date codes without history id
    // 3.insert history details and updated escalattion details with new history id

    $where_history = array(
        'petition_no' => $petition_no,
        'date_code' => $history_id,
    );
    $updateDatesArray = array(
        'completion_date' => $executionDate,
        'escalated_status' => $escalate_status,
        'completion_days' => $completion_days_for_history,
    );

    $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
    // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
    if ($this->db->affected_rows() <= 0) {
        $response['responseType'] = 0;
        $response['msg'] = '#ERRESCLATION565 : Updation failed on Escalation row not found';
        return $response;
    }

    ///////////////END PROCESS//////////////////////////

    $where = array(
        'petition_no' => $petition_no,
    );

    if ($finalStatus == 'final') {
        unset($updateArray['assigned_to']);
        unset($updateArray['assigned_to_code']);
        unset($updateArray['assigned_from']);
        unset($updateArray['assigned_from_code']);
        unset($updateArray['assigned_date']);
        unset($updateArray['escalated_date']);
        unset($updateArray['to_be_completed_within_days']);
        unset($updateArray['co_date_code_list']);

        $updateArray['assignment_type_other'] = null;
        $updateArray['assigned_other'] = null;
        $updateArray['assigned_other_code'] = null;
        $updateArray['assigned_other_date'] = null;
        $updateArray['assigned_other_es_date'] = null;
        $updateArray['to_be_other_completed_within_days'] = null;
        $updateArray['final_completion_date'] = $executionDate;
        $updateArray['status'] = 'F';

    }

    // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
    $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

    // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
    // if($this->db->affected_rows() <= 0){
    //    $flag = 0;
    // }else{
    //    $flag = 1;
    // }
    if ($this->db->affected_rows() <= 0) {
        $response['responseType'] = 0;
        $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
        return $response;
    }

    if ($doubleEntry == 0 && $finalStatus == null) {
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
            $executionDate = $hearing_date;
            $escalatedDate = $assigned_other_es_date;
        }

        $action_type = json_decode(ASSIGNMENT_TYPE);
        $action_type = $action_type[0]->CODE;
        if ($escalate_status == 'Y') {
            $action_type = $action_type[1]->CODE;
        }

        $date_history = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
            'sr_no' => $dateCode,
            'date_code' => $date_history,
            'petition_no' => $petition_no,
            'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
            'taskid' => $taskid,
            'action_type' => $action_type,
            'pending_officer' => $assigned_to,
            'assigned_user' => $user_code,
            'assigned_user_code' => $assigned_from_code,
            'assigned_to' => $assigned_to,
            'assigned_to_code' => $assigned_to_code,
            'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
            'allocation_date' => $executionDate,
            'target_completion_date' => $escalatedDate,
            'date_diff' => $this->Escalationmodel->dateDiff($escalatedDate, $executionDate),
            'escalated_status' => $escalate_status,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        );
        if ($finalStatus == 'final') {
            $insertDateArray['completion_date'] = $executionDate;
        }
        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $this->db->insert('escalation_dates_details', $insertDateArray);
        if ($status != 1) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
            return $response;
        }
        if ($updateFlag == true) {
            $where_history_set = array(
                'petition_no' => $petition_no,
            );
            $updateDatesArraySet = array(
                'history_id' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION662 : Updation failed on escalation_details';
                return $response;
            }
        }

    }

    //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
    if ($entryTimes == 1) {
        $action_type = json_decode(ASSIGNMENT_TYPE);
        $action_type = $action_type[0]->CODE;
        if ($escalate_status == 'Y') {
            $action_type = $action_type[1]->CODE;
        }

        $date_history = $this->Escalationmodel->generateDateCode();
        $insertDateArray = array(
            'date_code' => $date_history,
            'petition_no' => $petition_no,
            'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
            'taskid' => $taskid,
            'action_type' => $action_type,
            'pending_officer' => $assigned_to_other,
            'assigned_user' => $user_code,
            'assigned_user_code' => $assigned_from_code,
            'assigned_to' => $assigned_to_other,
            'assigned_to_code' => $assigned_other_code,
            'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
            'allocation_date' => $assigned_other_date,
            'target_completion_date' => $assigned_other_es_date,
            'date_diff' => $this->Escalationmodel->dateDiff($assigned_other_es_date, $executionDate),
            'escalated_status' => $escalate_status,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        );
        $status = $this->db->insert('escalation_dates_details', $insertDateArray);
        if ($status != 1) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION696 : Updation failed on escalation_dates_details';
            return $response;
        }
        $where_history_set = array(
            'petition_no' => $petition_no,
        );

        $updateDatesArraySet = array(
            'history_id_others' => $date_history,
        );
        $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION710 : Updation failed on escalation_details';
            return $response;
        }
    }

    return $response;

  }

  public function conversionLandUnder($check_whetherOr, $case_no, $user_code, $service_code)
  {

    if($check_whetherOr == 'withintown' || $check_whetherOr == 'withinrevenuetown' || $check_whetherOr == 'withinmunicipal5km' || $check_whetherOr == 'withinghy')
    {
      $stype = CONV_URBAN;
    }
    elseif($check_whetherOr == 'within3km' || $check_whetherOr == 'within10km' || $check_whetherOr == 'withintown5km')
    {
      $stype = CONV_PERI;
    }
    elseif($check_whetherOr == 'within15km' || $check_whetherOr == 'withinrural')
    {
      $stype = CONV_RURAL;
    }

    $timeLineRow = $this->Escalationmodel->getTimeLine($service_code, $stype);

    // update escalation table





  }


  
    

}
