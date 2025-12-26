<?php
class CronEscalationModel extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->model('AutoEscalationmodel');
    $this->load->model('Escalationmodel');  
    $this->load->model('EscTableFieldsModel');
  }

  public function holidayInsertForTheDay($db,$response_log)
  {
    $status = 'N';
    if(isset($response_log) && $response_log != 'n')
    {
      $status = 'Y';
    }
    $insArray = [
      'holiday_running_date'   => date('Y-m-d H:i:s'),
      'status'             => $status,
      'dist_code'          => '01',
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
    $insert = $db->insert('escalation_holiday_daily_insert', $insArray);     
  }

  public function getHoliday($db)
  {
    $date = date('Y-m-d');
    $query = $db->query("SELECT holiday_date FROM holiday_details WHERE holiday_date=?", array($date));
    return $query->num_rows();
  }

  // get all cases where escalated date is today for other users
  public function getTodayEscalatedList($db)
  {
    // 2,3,6,7,9 == DC, ADC, CO, SK, LM
    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d');
      return $db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_to_code IN (2,3,6,7,9)", array('P'));
    }else
    {
      $currDate = date('Y-m-d');
      return $db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_to_code IN (2,3,6,7,9)", array('P'));
    }    
  }

  // get all cases where escalated date is today for assistant
  public function getTodayEscalatedListOfAsistant($db)
  {
    // 8 == AST

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      return $db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_other_code = ?", array('P', 8));
    }
    else
    {
      $currDate = date('Y-m-d');
      return $db->query("SELECT * FROM escalation_details WHERE status = ? and final_completion_date  is null AND assigned_other_code = ?", array('P', 8));
    }
    
  }


  // update table if escalated date is holiday
  public function updateTablesIfHoliday($db)
  {
    $currDate = date('Y-m-d');
    // get all cases where escalated date is today for other users
    $otherResp = $this->getTodayEscalatedList($db);
    
    $total_count = $otherResp->num_rows();
    $total_affected_row =array();
    log_message("error","#HOLIDAY COUNT OTHER CASES==".json_encode($otherResp->num_rows()));
    log_message("error","#HOLIDAY OTHER CASES==".json_encode($otherResp->result()));

    if($otherResp->num_rows() > 0)
    {
      $resp = $otherResp->result();

      foreach($resp as $row)
      {
        log_message("error","#HOLIDAY START OTHER UPDATE FOR CASE_NO==".json_encode($row->case_no));
        // update escalation_details table
        $updateArray = [          
          'escalated_date'              => date('Y-m-d H:i:s', strtotime($row->escalated_date. ' + 1 day')),
          'to_be_completed_within_days' => $row->to_be_completed_within_days + 1,
          'updated_date'                 => date('Y-m-d H:i:s'),
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

        // $db->where('escalated_date', $currDate);
        $db->where('case_no', $row->case_no);
        $db->where_in('assigned_to_code', array(2,3,6,7,9));
        $db->update('escalation_details', $updateArray);
        if($db->affected_rows() == 1)
        {
          $total_affected_row[] = $db->affected_rows();
          log_message("error","#HOLIDAY SUCCESS OTHER UPDATE FOR CASE_NO==".json_encode($row->case_no));

        }
        
      }
    } // end of $otherResp

    if($total_count != count($total_affected_row))
    {
      log_message("error","#HOLIDAY COUNT MISMATCH OTHER UPDATE FOR CASES======ASTCOUNT==".json_encode($total_count)."==UPDATECOUNT==".json_encode($total_affected_row));
      // $db->trans_rollback();
      // return 'n';
    }

    // get all cases where escalated date is today for assistant
    $asstResp = $this->getTodayEscalatedListOfAsistant($db);
    $total_ast_affected_row = array();
    $total_ast_count = $asstResp->num_rows();
    log_message("error","#HOLIDAY COUNT AST CASES==".json_encode($asstResp->num_rows()));
    log_message("error","#HOLIDAY AST CASES==".json_encode($asstResp->result()));
    if($asstResp->num_rows() > 0)
    {
      $resp = $asstResp->result();

      foreach($resp as $row)
      {
        log_message("error","#HOLIDAY START AST UPDATE FOR CASE_NO==".json_encode($row->case_no));
        // update escalation_details table
        $updateArray = [          
          'assigned_other_es_date'              => date('Y-m-d', strtotime($row->assigned_other_es_date. ' + 1 day')),
          'to_be_other_completed_within_days' => $row->to_be_other_completed_within_days + 1,
          'da_target_days'              => $row->da_target_days + 1,
          'updated_date'                 => date('Y-m-d H:i:s'),
          'total_days'                 => $row->total_days + 1,
        ];
        // $db->where('assigned_other_es_date', $currDate);
        $db->where('case_no', $row->case_no);
        $db->where('assigned_other_code', 8);
        $db->update('escalation_details', $updateArray);
        if($db->affected_rows() == 1)
        {
          $total_ast_affected_row[] = $db->affected_rows();
          log_message("error","#HOLIDAY SUCCESS UPDATE FOR CASE_NO==".json_encode($row->case_no));
        }

      }
    } // end of $asstResp

    if($total_ast_count != count($total_ast_affected_row))
    {
      log_message("error","#HOLIDAY COUNT MISMATCH AST UPDATE FOR CASES======ASTCOUNT==".json_encode($total_ast_count)."==UPDATECOUNT==".json_encode($total_ast_affected_row));
      // $db->trans_rollback();
      // return 'n';
    }

    // if($db->trans_status() === FALSE)
    // {
    //   log_message("error","#HOLIDAY Rollback UPDATE FOR CASES======ASTCOUNT==".json_encode($total_ast_count)."==OTHERCOUNT==".json_encode($total_count));
    //   $db->trans_rollback();
    //   return 'n';
    // }
    // else
    // {
      
      log_message("error","#SUCCESS HOLIDAY UPDATE FOR CASES======ASTCOUNT==".json_encode($total_ast_count)."==OTHERCOUNT==".json_encode($total_count));
      return 'y';
    // }
  }

  // get to be auto escalate cases from escalation_details
  public function getListOfToBeAutoEscalatedCases($db)
  {
    $result_array = array();
    $user_desig_code_arr = ['LM', 'SK', 'CO', 'ADC', 'DC'];

    foreach($user_desig_code_arr as $key=>$val)
    {

      // $user_desig_code = $this->session->userdata('user_desig_code');
      $assigned_to = $this->EscTableFieldsModel->getUserCode($val);
      $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($val);

      if(ESCALATION_ALLOW_TIME ==1)
      {
        $currDate = date('Y-m-d H:i:s');
        $currDateLast = date('Y-m-d 23:59:23');

        $queryVal =  $db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
      }

      else
      {
        $currDate = date('Y-m-d');
        // $queryVal = $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) < ? and status = ? and final_completion_date  is null", array($currDate,'P'));
        $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,'P','N',$assigned_to));

      }

      $result_array[] = $queryVal->result();

    }
    log_message('error','#CRONRESULTS===='.json_encode($result_array));
    return $result_array;
  }

  public function generateDateCode($db)
  {
    $code = $db->query("select nextval('escalation_dates_details_sr_no_seq') as count ")->row()->count;
    return $code;
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
  public function getPetitionNoByCaseNo($table, $case_no, $db)
  {
    if($table == 'misc_case_basic')
    {
      $query = $db->query("SELECT misc_case_petition_no FROM $table 
                  WHERE misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
    }
    else if($table == 't_reclassification' || $table == 't_legacyupdation')
    {
      $query = $db->query("SELECT proposal_no FROM $table 
                  WHERE case_no=?", array($case_no))->row()->proposal_no;
    }
    else
    {
      $query = $db->query("SELECT petition_no FROM $table 
                  WHERE case_no=?", array($case_no))->row()->petition_no;
    }
    return $query;
  }



  public function getPetitionDetailsByCaseNo($table, $case_no, $db)
  {
    if($table == 'misc_case_basic')
    {
      $query = $db->query("SELECT misc_case_petition_no FROM $table 
                  WHERE misc_case_no=?", array($case_no))->row();
    }
    else if($table == 't_reclassification' || $table == 't_legacyupdation')
    {
      $query = $db->query("SELECT proposal_no FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    else
    {
      $query = $db->query("SELECT petition_no FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    return $query;
  }

  public function getCaseDetailsNoByCaseNo($table, $case_no, $db)
  {
    if($table == 'misc_case_basic')
    {
      $query = $db->query("SELECT * FROM $table 
                  WHERE misc_case_no=?", array($case_no))->row();
    }
    else if($table == 't_reclassification' || $table == 't_legacyupdation')
    {
      $query = $db->query("SELECT * FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    else
    {
      $query = $db->query("SELECT * FROM $table 
                  WHERE case_no=?", array($case_no))->row();
    }
    // log_message('error', "***********TABLE***************:".$table.', '.$case_no);
    return $query;
  }

  public function getRemainingDays($previousCompletedDays, $orginalTargetDays)
  {
    // log_message("error", "ddd==" . $previousCompletedDays . " ==========" . $orginalTargetDays);
    return $orginalTargetDays - $previousCompletedDays;
  }

  public function getEscalatedDateNew($target_days, $executionDate)
  {
    if (ESCALATION_ALLOW_TIME == 1) {
        return date("Y-m-d H:i:s", strtotime($executionDate) + (60 * $target_days));
    } else {
        $Interval = '+' . $target_days . ' days';
        // $escalatedDate =Date('Y-m-d', strtotime($Interval));
        $escalatedDate = date('Y-m-d', strtotime($executionDate . $Interval));
        return $escalatedDate;
    }
  }

  public function dateDiff($date1, $date2)
  {
    if (ESCALATION_ALLOW_TIME == 1) 
    {
      $to_time = strtotime($date1);
      $from_time = strtotime($date2);
      return round(abs($to_time - $from_time) / 60, 2);
    } 
    else 
    {
      $date1_ts = strtotime($date1);
      $date2_ts = strtotime($date2);
      $diff = $date1_ts - $date2_ts;
      return round($diff / 86400);
    }
  }

  public function getPendingOfficerDC($d, $desig_code, $db)
  {
      $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table 
                lt join users u on
                  lt.dist_code=u.dist_code
                    and lt.subdiv_code=u.subdiv_code
                      and u.user_code=lt.user_code where lt.dis_enb_option='E'
                        and u.user_desig_code not like 'DCN%'
                          and u.user_desig_code like 'DC%'";
      $data = $db->query($sql);
      return $data->row();
  }

  public function getTimeLine($service_code, $service_name, $escalation_type = 'normal', $db)
  {
    if($service_name == 'MiNC')
    {
      $service_name = 'NCOR';
    }
    $sql = "Select * from escalation_matrix where service_code=? and category = ? and escalation_type = ?";
    $matrix = $db->query($sql, array($service_code, $service_name, $escalation_type))->row();
    if (isset($matrix) && !empty($matrix) && $matrix != null) {
        return $matrix;
    } else {
        return null;
    }
  }

  public function updateDaysForDC($case_no,$allocation_days,$updateField, $db)
  {
    $sql = $db->query("update escalation_details set $updateField = '$allocation_days' where case_no = ? ",array($case_no));
    // echo $db->last_query(); die;
    return $db->affected_rows();
  }


  // auto escalation for other user
  public function userWiseEscalation($row, $db)
  {
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate  = date('Y-m-d H:i');
      $escalatedDated = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      $executionDate  = date('Y-m-d');
      $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));
    }

    
    log_message('error','ESCALATED DATE===================='.$escalatedDated.'=========='.$executionDate);
    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      // $executionDate = date('Y-m-d H:i:s');
      log_message('error','######ESCALATESTART==========='.$row->case_no);
      // From LM to CO
      if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
      {
        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);


        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->lm_date_code_list;
        $previousCompletedDays = $row->lm_completed_days;
        $lm_target_days        = $row->lm_target_days;


        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $lm_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[0]->CODE, // LM message
          'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
          'lm_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 9,
          'assigned_to'                 => $co_code->user_code,
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 9,
          'assigned_to'            => $co_code->user_code,
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
          return $response;
        }


        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'LM',
          'assigned_from_code'          => 9,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107 : Insert Failed on escalation_cases_remark_status Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107 : Insert Failed on escalation_cases_remark_status Failed';
          return $response;
        }
      }

      // From SK to CO
      if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
      { 

        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);

        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->sk_date_code_list;
        $previousCompletedDays = $row->sk_completed_days;
        $sk_target_days        = $row->sk_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
        $sk_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
          'sk_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 7,
          'assigned_to'                 => $co_code->user_code,
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
        'completion_date'  => $executionDate.date(' H:i:s'),
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $co_code->user_code,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 7,
          'assigned_to'            => $co_code->user_code,
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4448 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4448 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'SK',
          'assigned_from_code'          => 7,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR01071 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
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
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);

        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);


        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $co_code->user_code,
          'assigned_from_code'          => 6,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
        'completion_date'  => $executionDate.date(' H:i:s'),
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $dcUserDetails->user_code,
          'assigned_user'          => $co_code->user_code,
          'assigned_user_code'     => 6,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => 6,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => 2,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR010712 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR010712 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From CO to DC for MUT/PART/NCAN/NCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $db->trans_begin();
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $co_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR6498 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR6498 : De-escalation error';
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



        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);
          
        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
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
          'assigned_from'               => $co_code->user_code,
          'assigned_from_code'          => 6,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $dcUserDetails->user_code,
          'assigned_user'          => $co_code->user_code,
          'assigned_user_code'     => 6,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR6632 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6632 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            $db->trans_rollback();
            log_message("error","#ERR6650 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6650 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          $db->trans_rollback();
          log_message("error","#ERR6658 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6658 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'CO',
          'assigned_from_code' => 6,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR06679 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR06679 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        $db->trans_commit();
      }
      // $escDataForStore = $this->getEscalatedRowDetailsCaseNo($row->case_no);
      // return $escDataForStore;
      
    }
    return $response;
    log_message('error','ESCALATE---NOT---START==========='.$row->case_no);
  }


  // insert successfull auto escalated data
  public function insertSuccessData($row, $db)
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

      $status = $db->insert('escalation_of_success_cases', $successInsert);

      if($status != 1)
      {
        log_message("error","#ERRCRONMODEL102 : Insert Failed on escalation_of_success_cases Failed=======".$db->last_query());
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
  public function insertFailedData($row, $db)
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

      $status = $db->insert('escalation_of_failed_cases', $failedInsert);

      if($status != 1)
      {
        log_message("error","#ERRCRONMODEL209 : Insert Failed on escalation_of_failed_cases Failed=======".$db->last_query());
        $response['responseType'] = 0;
        $response['msg'] = '#ERRCRONMODEL209 : Insertion failed in escalation_of_failed_cases';
        return $response;
      }

      $response['responseType'] = 1;
      $response['msg'] = 'Successfully inserted';
      return $response;
    }
  }

  // auto escalation for other user
  // public function checkTotalTimeIsOutorNot($row, $db)
  // {
  //   $response           = array('responseType' => 1,'msg' => null);
  //   $taskId             = json_decode(TASK_ID);
  //   $dateCode           = $this->generateDateCode($db);
  //   $service_code_array = [1,2,3,5,6,8]; // other then reclass    

  //   $service_type = $this->getServiceName($row->case_no);
  //   $table        = $this->getTableNameByServiceType($service_type);
  //   $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

  //   $loc_details  = $this->getPetitionDetailsByCaseNo($table, $row->case_no, $db);


  //   if(ESCALATION_ALLOW_TIME == 1)
  //   {
  //     $executionDate= date('Y-m-d H:i');
  //     $escalatedDatedAst = date('Y-m-d H:i',strtotime($row->assigned_other_es_date));
  //   }
  //   else
  //   {
  //     $executionDate  = date('Y-m-d');
  //     $escalatedDatedAst = date('Y-m-d',strtotime($row->assigned_other_es_date));
  //   }

  //   // From AST to CO
  //   if($escalatedDatedAst == $executionDate)
  //   {
  //     log_message('error','ESCALATESTART==========='.$row->case_no);
  //     if($row->assigned_other_code == 8 && in_array($row->service_code, $service_code_array)) 
  //     { 
  //       $originalAllocation      = $row->co_target_days;
  //       $previousCompletedDaysCO = $row->co_completed_days;
  //       $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
  //       $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

  //       $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_other_date));

  //       $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

  //       $dateCodes             = $row->da_date_code_list;
  //       $previousCompletedDays = $row->da_completed_days;
  //       $da_target_days        = $row->da_target_days;

  //       // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
  //       $da_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

  //       // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
  //       // if($da_target_days < $da_completed_days)
  //       // {   
  //       //   $escalate_status = 'Y';
  //       // }
  //       // else{
  //       //   $escalate_status = 'N';
  //       // }

  //       //changes done on 26062024--  
  //       $escalate_status = 'Y';

  //       // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
  //       if($dateCodes == null)
  //       {
  //         $dateCodes = $dateCode;
  //       }
  //       else
  //       {
  //         $dateCodes = $dateCodes.','.$dateCode;
  //       }
        
  //       $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
  //       $updateArray = array(
  //         'taskid'                      => $taskId[1]->CODE, // AST message
  //         'da_completed_days'           => (int) $da_completed_days + (int) $previousCompletedDays,
  //         'da_escalate_status'          => $escalate_status,
  //         // 'assigned_from'               => $row->assigned_to,
  //         // 'assigned_from_code'          => $row->assigned_to_code,
  //         // 'assigned_to'                 => $row->assigned_from,
  //         // 'assigned_to_code'            => $row->assigned_from_code,
  //         // 'assigned_date'               => $executionDate.date(' H:i:s'),
  //         // 'escalated_date'              => $escalatedDate.date(' H:i:s'),
  //         'da_date_code_list'           => $dateCodes,
  //         'to_be_other_completed_within_days' => $to_be_completed_within_days,
  //       );

  //       $updateFlag = true;
  //       $history_id = $row->history_id;

  //       // log_message("error","UPDATED FLAG ==========".$updateFlag);

  //       //STEPS to be followed:
  //       // 1. update escalation_dates_details against or history id
  //       // 2. update escalation_details with new date codes without history id
  //       // 3. insert history details and updated escalattion details with new history id

  //       $where_history = array(
  //         'petition_no' => $petition_no,
  //         'date_code'   => $history_id
  //       );
  //       $updateDatesArray = array(
  //         'completion_date'  => $executionDate.date(' H:i:s'),
  //         'escalated_status' => $escalate_status,
  //         'completion_days'  => $completion_days_for_history
  //       );

  //       $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

  //       $where = array(
  //         'petition_no' => $petition_no,
            // 'case_no'     => $row->case_no,
  //       );

  //       $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

  //       $date_history    = $this->generateDateCode($db);
  //       // $insertDateArray = array(
  //       //   'sr_no'                  => $dateCode,
  //       //   'date_code'              => $date_history,
  //       //   'petition_no'            => $petition_no,
  //       //   'service_code'           => $row->service_code,
  //       //   'taskid'                 => $taskId[2]->CODE,
  //       //   'pending_officer'        => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
  //       //   'assigned_user'          => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
  //       //   'assigned_user_code'     => '6',
  //       //   'assigned_to'            => $row->assigned_other,
  //       //   'assigned_to_code'       => $row->assignment_type_other,
  //       //   'registerd_on'           => $row->registerd_on,
  //       //   'allocation_date'        => $executionDate.date(' H:i:s'),
  //       //   'target_completion_date' => $escalatedDate.date(' H:i:s'),
  //       //   'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
  //       //   'escalated_status'       => $escalate_status,
  //       //   'created_date'           => date('Y-m-d H:i:s'),
  //       //   'updated_date'           => date('Y-m-d H:i:s'),
  //       // );

  //       $insertDateArray = array(
  //         'sr_no'                  => $dateCode,
  //         'date_code'              => $date_history,
  //         'petition_no'            => $petition_no,
  //         'service_code'           => $row->service_code,
  //         'taskid'                 => $taskId[2]->CODE,
  //         'pending_officer'        => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
  //         'assigned_user'          => $row->assigned_other,
  //         'assigned_user_code'     => $row->assigned_other_code,
  //         'assigned_to'            => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
  //         'assigned_to_code'       => 6,
  //         'registerd_on'           => $row->registerd_on,
  //         'allocation_date'        => $executionDate.date(' H:i:s'),
  //         'target_completion_date' => $escalatedDate.date(' H:i:s'),
  //         'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
  //         'escalated_status'       => $escalate_status,
  //         'created_date'           => date('Y-m-d H:i:s'),
  //         'updated_date'           => date('Y-m-d H:i:s'),
  //       );

  //       // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
  //       $status = $db->insert('escalation_dates_details',$insertDateArray);
  //       if($status != 1)
  //       {
  //         log_message("error","#ERR4500 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
  //         $response['responseType'] =0;
  //         $response['msg'] = '#ERR4500 : Insert Failed on escalation_dates_details Failed';
  //         return $response;
  //       }
  //       if($updateFlag == true)
  //       {
  //         $where_history_set = array(
  //           'petition_no' => $petition_no,
  // 'case_no'     => $row->case_no,
  //         );
  //         $updateDatesArraySet = array(
  //           'history_id'     => $date_history,
  //         );
  //         $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
  //         if($db->affected_rows() <= 0)
  //         {
  //           log_message("error","#ERR5000 : Update Failed on escalation_details Failed=======".$db->last_query());
  //           $response['responseType'] = 0;
  //           $response['msg'] = '#ERR5000 : Update Failed on escalation_details Failed';
  //           return $response;
  //         }
  //       }

  //       $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
  //       if($updateTable == 'n')
  //       {
  //         log_message("error","#ERR4736 : Update Failed on service wise table Failed=======".$db->last_query());
  //         $response['responseType'] =0;
  //         $response['msg'] = '#ERR4736 : Update Failed on escalation_details Failed';
  //         return $response;
  //       }

  //       $insertRemarkArray = array(
  //         'case_no'                     => $row->case_no,
  //         'petition_no'                 => $row->petition_no,
  //         'assigned_from'               => 'DA',
  //         'assigned_from_code'          => $row->assigned_other,
  //         'assigned_to'                 => 'CO',
  //         'assigned_to_code'            => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
  //         'created_at'                  => date('Y-m-d H:i:s'),
  //         'updated_at'                  => date('Y-m-d H:i:s'),
  //         'remark_status'               => null
  //       );

  //       $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
  //       if($remarkInsertionStatus != 1)
  //       {
  //         log_message("error","#ERR0107123 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
  //         $response['responseType'] =0;
  //         $response['msg'] = '#ERR0107123 : Insert Failed on escalation_dates_details Failed';
          
  //       }
  //     }

  //   }
  //   return $response;

  //   log_message('error','ESCALATENOT---START==========='.$row->case_no);
  // }

  // get to be escalate cases from assistant
  public function getToBeAutoEscalatedCasesOfAssistant($db)
  {
    $user_desig_code = 'AST';
    $assigned_to = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      $queryVal = $db->query("SELECT * FROM escalation_details WHERE assigned_other_es_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_other_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
    }

    else
    {
      $currDate = date('Y-m-d');
     
      $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(assigned_other_es_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_other_code = ?", array($currDate,'P','N',$assigned_to));
      
    }
    log_message('error','#ESCALATE==AST==QUERY====--'.$db->last_query());
    return $queryVal;
  }



  // auto escalate the cases to next officer
  public function autoEscalateToRespectiveOfficer($db)
  {
    $date = date('Y-m-d');
    $json = array();

    // ========== holiday check if auto escalation required starts here  =============
    $isHoliday = $this->getHoliday($db);

    $holidayInsertCountForTheDay = $this->checkHolidayInsertOrNot($db,$date);
    log_message('error','HOLIDAY--INSERT--OR--NOT======='.json_encode($holidayInsertCountForTheDay));

    if($isHoliday == 1 && $holidayInsertCountForTheDay == 0)
    {
      $message = '';
      $holidayResp = $this->updateTablesIfHoliday($db);
      if($holidayResp == 'n')
      {
        log_message('error', "#ERR4122: Data updation failed  : ".json_encode($holidayResp));
        $message = 'Though data updation failed';
      }

      $statusHolidayInsert = $this->holidayInsertForTheDay($db,$holidayResp);

      log_message('error', "#ERR4127: Auto escalation is not required as today is holiday : $date");
      $json = [
        'response'    => 3,
        'message'     => 'Auto escalation is not required !!! '.$holidayResp,
      ];
      return $json;
    }
    // ========== holiday check if auto escalation required ends here  ==========
    $otherResp = array();
    $failedCases = array();
    $successCases = array();

    $failedCasesLM = array();
    $successCasesLM = array();

    $failedCasesCO = array();
    $successCasesCO = array();

    $failedCasesSK = array();
    $successCasesSK = array();

    $failedCasesADC = array();
    $successCasesADC = array();
    // for other officer
    // $otherResult = $this->getListOfToBeAutoEscalatedCases($db);
    // log_message('error','#CRONESC_DATA====================='.json_encode($otherResult));
    // if(!empty($otherResult))
    // {
    //   foreach($otherResult as $res_row)
    //   {
    //     foreach($res_row as $row)
    //     {
    //       // $otherResp[] = $this->userWiseEscalation($row, $db);
    //       $escalatedResponse = $this->userWiseEscalation($row, $db);
    //       if($escalatedResponse['responseType'] == 1)
    //       {
    //         $successCases[] = $row;
    //         $this->insertSuccessData($row, $db);
    //         $otherResp[] = $row;
    //       }
    //       elseif($escalatedResponse['responseType'] == 0)
    //       {
    //         $failedCases[] = $row;
    //         $this->insertFailedData($row, $db);
    //         $otherResp[] = $row;
    //       }
    //     }        
    //   }
    // }

    // ============= Assistant starts here ===============
    // $asstResp = array();
    // // for assistant
    // $asstResult = $this->getToBeAutoEscalatedCasesOfAssistant($db);
    // $total_ast_escalate_count = $asstResult->num_rows();
    
    // log_message("error","ESCALATE START AST========CASES==".json_encode($asstResult->result()));
    // if($asstResult->num_rows() > 0)
    // {
    //   $result = $asstResult->result();
    //   foreach($result as $row)
    //   {
    //     log_message("error","ESCALATE START AST========CASE NO==".json_encode($row->case_no));
    //     $escalatedResponse = $this->assistantEscalation($row, $db);
    //     if($escalatedResponse['responseType'] == 1)
    //     {
    //       log_message("error","ESCALATE SUCCESS AST========CASE NO==".json_encode($row->case_no));
    //       $successCases[] = $row;
    //       $this->insertSuccessData($row, $db);
    //       $asstResp[] = $row;
    //     }
    //     elseif($escalatedResponse['responseType'] == 0)
    //     {
    //       log_message("error","ESCALATE FAILED AST========CASE NO==".json_encode($row->case_no));
    //       $failedCases[] = $row;
    //       $this->insertFailedData($row, $db);
    //       $asstResp[] = $row;
    //     }
    //   }
    // }
    // if($total_ast_escalate_count != count($successCases)){
    //   log_message("error","ESCALATE FAILED AST COUNT MISMATCH========CASE NO COUNT==".json_encode($total_ast_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCases)));
    //   $db->trans_rollback();
    //   return;
    // }
    

    // ============= LM starts here ===============
    $lmResp = array();
    $lmResult = $this->getToBeAutoEscalatedCasesOfLm($db);
    $total_lm_escalate_count = $lmResult->num_rows();
    if($lmResult->num_rows() > 0)
    {
      $result = $lmResult->result();
      foreach($result as $row)
      {
        //$db->trans_begin();
        $escalatedResponse = $this->lmEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesLM[] = $row;
          $this->insertSuccessData($row, $db);
          $lmResp[] = $row;
          //$db->trans_commit();
        }
        elseif($escalatedResponse['responseType'] == 0)
        {

          $failedCasesLM[] = $row;
          $this->insertFailedData($row, $db);
          $lmResp[] = $row;
          // continue;
          
        }
      }
    }

    if($total_lm_escalate_count != count($successCasesLM)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_ast_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesLM)));
      // $db->trans_rollback();
      // return;
    }

    // ============= SK starts here ===============
    $skResp = array();
    $skResult = $this->getToBeAutoEscalatedCasesOfSk($db);
    $total_sk_escalate_count = $skResult->num_rows();

    if($skResult->num_rows() > 0)
    {
      $result = $skResult->result();
      foreach($result as $row)
      {
        //$db->trans_begin();
        $escalatedResponse = $this->skEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesSK[] = $row;
          $this->insertSuccessData($row, $db);
          $skResp[] = $row;
          //$db->trans_commit();
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesSK[] = $row;
          $this->insertFailedData($row, $db);
          $skResp[] = $row;
        }
      }
    }

    if($total_sk_escalate_count != count($successCasesSK)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_sk_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesSK)));
      // $db->trans_rollback();
      // return;
    }

    // ============= CO starts here ===============
    $coResp = array();
    $coResult = $this->getToBeAutoEscalatedCasesOfCo($db);
    // echo $db->last_query(); die;
    $total_co_escalate_count = $coResult->num_rows();
    if($coResult->num_rows() > 0)
    {
      $result = $coResult->result();
      foreach($result as $row)
      {
        //$db->trans_begin();
        $escalatedResponse = $this->coEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesCO[] = $row;
          $this->insertSuccessData($row, $db);
          $coResp[] = $row;
          //$db->trans_commit();
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesCO[] = $row;
          $this->insertFailedData($row, $db);
          $coResp[] = $row;
        }
      }
    }

    if($total_co_escalate_count != count($successCasesCO)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_co_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesCO)));
      // $db->trans_rollback();
      // return;
    }


    // ================ADC START=====================
    $adcResp = array();
    $adcResult = $this->getToBeAutoEscalatedCasesOfAdc($db);
    $total_adc_escalate_count = $adcResult->num_rows();

    if($adcResult->num_rows() > 0)
    {
      $result = $adcResult->result();
      foreach($result as $row)
      {
        //$db->trans_begin();
        $escalatedResponse = $this->adcEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {

          $successCasesADC[] = $row;
          $this->insertSuccessData($row, $db);
          $adcResp[] = $row;
          //$db->trans_commit();

        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesADC[] = $row;
          $this->insertFailedData($row, $db);
          $adcResp[] = $row;
        }
      }
    }

    if($total_adc_escalate_count != count($successCasesADC)){
      log_message("error","ESCALATE FAILED ADC COUNT MISMATCH========CASE NO COUNT==".json_encode($total_adc_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesADC)));
      // $db->trans_rollback();
      // return;
    }

    

    // if($db->trans_status() === FALSE)
    // {
    //   $json = [
    //     'response'  => 5,
    //   ];

    //   return $json;

    // }
    // else
    // {
      // $db->trans_commit();
      $json = [
        'response'  => 3,
        'otherResp' => $otherResp,
        // 'asstResp'  => $asstResp,
        'lmResp'    => $lmResp,
        'skResp'    => $skResp,
        'adcResp'   => $adcResp,
        'coResp'    => $coResp,
        'message'   => 'Auto escalation successfull !!!',
      ];
      $this->insertAutoEscalateData($db,$json);
      return $json;
    // } 
  }

    // insert auto ecalation log
  public function insertAutoEscalateData($db,$response_log)
  {
    $status = 'N';
    if(isset($response_log) && $response_log['response'] == 3)
    {
      $status = 'Y';
    }
    $insArray = [
      'api_running_date'   => date('Y-m-d H:i:s'),
      'status'             => $status,
      'dist_code'          => '01',
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
    $insert = $db->insert('auto_escalation_daily_status', $insArray);     
  }

  // get failed escalated cases from table to update in escalation_details table
  public function getFailedEscalatedCases($db)
  {
    $currDate = date('Y-m-d');

    // get from escalation_of_failed_cases
    $query = $db->query("SELECT * FROM escalation_of_failed_cases WHERE date(created_at) = ? AND  
                resolve_status = ?", array($currDate, 'n'));
    return $query;
  }

  // update servicewise table
  public function updateServiceWiseTable($case_no, $db)
  {
    // get service name
    $service_type = $this->getServiceName($case_no);

    //update service wise table
    $table = $this->getTableNameByServiceType($service_type);

    $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';

    // update service table
    $query = $db->query("UPDATE $table SET is_escalated=? WHERE $case=? 
                AND es_flag=?", array(1, $case_no, 1));
    if($db->affected_rows() != 1)
    {
      return 'n';
    }
    return 'y';
  }

  public function getPendingOfficer($d, $s, $c, $desig_code, $db)
  {
      $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code
          and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
          and u.user_code=lt.user_code where lt.dis_enb_option='E'
          and u.user_desig_code = '$desig_code' and lt.dist_code='$d'
          and lt.subdiv_code='$s' and lt.cir_code='$c'";
      $data = $db->query($sql);
      log_message('error', '52======************========pendingOfficer==' . json_encode($db->last_query()) . json_encode($data->row()));
      return $data->row();
  }


  // update failed escalated cases to escalation_details table
  public function scheduleForFailedEscCases($db)
  {
    $json = array();
    $failedCases = $this->getFailedEscalatedCases($db);
    $dateCode = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction

    if($failedCases->num_rows() <= 0)
    {

    }
    else // if data available
    { 
      $listCases = $failedCases->result();

      foreach($listCases as $row)
      {
        $service_type = $this->getServiceName($row->case_no);
        $table        = $this->getTableNameByServiceType($service_type);
        $loc_details  = $this->getPetitionDetailsByCaseNo($table, $row->case_no, $db);

        if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
        { 
          $db->trans_begin();
          $originalAllocation      = $row->co_target_days;
          $previousCompletedDaysCO = $row->co_completed_days;
          $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
          $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

          $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

          $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

          $dateCodes             = $row->lm_date_code_list;
          $previousCompletedDays = $row->lm_completed_days;
          $lm_target_days        = $row->lm_target_days;


          // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
          $lm_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);
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
          
          $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
          $updateArray = array(
            'taskid'                      => $taskId[0]->CODE, // LM message
            'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
            'lm_escalate_status'          => $escalate_status,
            'assigned_from'               => $row->assigned_to,
            'assigned_from_code'          => 9,
            'assigned_to'                 => $row->assigned_from,
            'assigned_to_code'            => 6,
            'assigned_date'               => $executionDate.date(' H:i:s'),
            'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
            'completion_date'  => $executionDate.date(' H:i:s'),
            'escalated_status' => $escalate_status,
            'completion_days'  => $completion_days_for_history
          );

          $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

          $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );

          $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

          $date_history    = $this->generateDateCode($db);
          $insertDateArray = array(
            'sr_no'                  => $dateCode,
            'date_code'              => $date_history,
            'petition_no'            => $petition_no,
            'service_code'           => $row->service_code,
            'taskid'                 => $taskId[0]->CODE,
            'pending_officer'        => $row->assigned_from,
            'assigned_user'          => $row->assigned_to,
            'assigned_user_code'     => 9,
            'assigned_to'            => $row->assigned_from,
            'assigned_to_code'       => 6,
            'registerd_on'           => $row->registerd_on,
            'allocation_date'        => $executionDate.date(' H:i:s'),
            'target_completion_date' => $escalatedDate.date(' H:i:s'),
            'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
            'escalated_status'       => $escalate_status,
            'created_date'           => date('Y-m-d H:i:s'),
            'updated_date'           => date('Y-m-d H:i:s'),
          );

          // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
          $status = $db->insert('escalation_dates_details',$insertDateArray);
          if($status != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
          if($updateFlag == true)
          {
            $where_history_set = array(
              'petition_no' => $petition_no,
              'case_no'     => $row->case_no,
            );
            $updateDatesArraySet = array(
              'history_id'     => $date_history,
            );
            $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
            if($db->affected_rows() <= 0)
            {
              $db->trans_rollback();
              log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$db->last_query());
              $response['responseType'] =0;
              $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
              return $response;
            }
          }

          $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
          if($updateTable == 'n')
          {
            $db->trans_rollback();
            log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
            return $response;
          }

          $insertRemarkArray = array(
            'case_no'                     => $row->case_no,
            'petition_no'                 => $row->petition_no,
            'assigned_from'               => 'LM',
            'assigned_from_code'          => 9,
            'assigned_to'                 => 'CO',
            'assigned_to_code'            => 6,
            'created_at'                  => date('Y-m-d H:i:s'),
            'updated_at'                  => date('Y-m-d H:i:s'),
            'remark_status'               => null
          );

          $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
          if($remarkInsertionStatus != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR0107 : Insert Failed on escalation_cases_remark_status Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR0107 : Insert Failed on escalation_cases_remark_status Failed';
            return $response;
          }

          // update escalation_of_failed_cases
          $failedUpdate = $db->query("UPDATE escalation_of_failed_cases SET resolve_status=? 
                      AND updated_date=?", array('y', date('Y-m-d H:i:s')));
          if($db->affected_rows() != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR498 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR498 : Updation Failed on escalation_of_failed_cases';
            return $response;
          }

          $db->trans_commit();
        }

        // From SK to CO
        if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
        { 
          $db->trans_begin();

          $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
          $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

          // get location detail from service table
          $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
                array($row->case_no, 1))->row();

          // get CO user code
          $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);

          $originalAllocation      = $row->co_target_days;
          $previousCompletedDaysCO = $row->co_completed_days;
          $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
          $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

          $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

          $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

          $dateCodes             = $row->sk_date_code_list;
          $previousCompletedDays = $row->sk_completed_days;
          $sk_target_days        = $row->sk_target_days;

          // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
          $sk_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate); 
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
          
          $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
          $updateArray = array(
            'taskid'                      => $taskId[1]->CODE, // SK message
            'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
            'sk_escalate_status'          => $escalate_status,
            'assigned_from'               => $row->assigned_to,
            'assigned_from_code'          => 7,
            'assigned_to'                 => $co_code->user_code,
            'assigned_to_code'            => 6,
            'assigned_date'               => $executionDate.date(' H:i:s'),
            'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
          );

          $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

          $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );

          $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

          $date_history    = $this->generateDateCode($db);
          $insertDateArray = array(
            'sr_no'                  => $dateCode,
            'date_code'              => $date_history,
            'petition_no'            => $petition_no,
            'service_code'           => $row->service_code,
            'taskid'                 => $taskId[0]->CODE,
            'pending_officer'        => $co_code->user_code,
            'assigned_user'          => $row->assigned_to,
            'assigned_user_code'     => 7,
            'assigned_to'            => $co_code->user_code,
            'assigned_to_code'       => 6,
            'registerd_on'           => $row->registerd_on,
            'allocation_date'        => $executionDate.date(' H:i:s'),
            'target_completion_date' => $escalatedDate.date(' H:i:s'),
            'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
            'escalated_status'       => $escalate_status,
            'created_date'           => date('Y-m-d H:i:s'),
            'updated_date'           => date('Y-m-d H:i:s'),
          );

          // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
          $status = $db->insert('escalation_dates_details',$insertDateArray);
          if($status != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
          if($updateFlag == true)
          {
            $where_history_set = array(
              'petition_no' => $petition_no,
              'case_no'     => $row->case_no,
            );
            $updateDatesArraySet = array(
              'history_id'     => $date_history,
            );
            $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
            if($db->affected_rows() <= 0)
            {
              $db->trans_rollback();
              log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
              $response['responseType'] =0;
              $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
              return $response;
            }
          }
          
          $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
          if($updateTable == 'n')
          {
            $db->trans_rollback();
            log_message("error","#ERR4448 : Update Failed on service wise table Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4448 : Update Failed on escalation_details Failed';
            return $response;
          }

          $insertRemarkArray = array(
            'case_no'                     => $row->case_no,
            'petition_no'                 => $row->petition_no,
            'assigned_from'               => 'SK',
            'assigned_from_code'          => 7,
            'assigned_to'                 => 'CO',
            'assigned_to_code'            => 6,
            'created_at'                  => date('Y-m-d H:i:s'),
            'updated_at'                  => date('Y-m-d H:i:s'),
            'remark_status'               => null
          );

          $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
          if($remarkInsertionStatus != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR01071 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR01071 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }

          // update escalation_of_failed_cases
          $failedUpdate = $db->query("UPDATE escalation_of_failed_cases SET resolve_status=? 
                      AND updated_date=?", array('y', date('Y-m-d H:i:s')));
          if($db->affected_rows() != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR498 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR498 : Updation Failed on escalation_of_failed_cases';
            return $response;
          }

          $db->trans_commit();
        } 

        // From CO to DC for Reclass/AreaCOR cases========
        if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
        { 
          $originalAllocation      = $row->dc_target_days;
          //if dc target days null then get remaining days from other users with maximum available days
          //update dc target days from available users days
          //set zero for dc completion days

          $previousCompletedDaysDC = $row->dc_completed_days;
          $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
          $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

          $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

          $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

          $dateCodes             = $row->co_date_code_list;
          $previousCompletedDays = $row->co_completed_days;
          $co_target_days        = $row->co_target_days;

          // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
          $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

          $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);


          $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
          $updateArray = array(
            'taskid'                      => $taskId[1]->CODE, // SK message
            'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
            'co_escalate_status'          => $escalate_status,
            'assigned_from'               => $row->assigned_to,
            'assigned_from_code'          => 6,
            'assigned_to'                 => $dcUserDetails->user_code,
            'assigned_to_code'            => 2,
            'assigned_date'               => $executionDate.date(' H:i:s'),
            'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
          );

          $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

          $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );

          $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

          $date_history    = $this->generateDateCode($db);
          $insertDateArray = array(
            'sr_no'                  => $dateCode,
            'date_code'              => $date_history,
            'petition_no'            => $petition_no,
            'service_code'           => $row->service_code,
            'taskid'                 => $taskId[0]->CODE,
            'pending_officer'        => $row->assigned_from,
            'assigned_user'          => $row->assigned_to,
            'assigned_user_code'     => 6,
            'assigned_to'            => $dcUserDetails->user_code,
            'assigned_to_code'       => 2,
            'registerd_on'           => $row->registerd_on,
            'allocation_date'        => $executionDate.date(' H:i:s'),
            'target_completion_date' => $escalatedDate.date(' H:i:s'),
            'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
            'escalated_status'       => $escalate_status,
            'created_date'           => date('Y-m-d H:i:s'),
            'updated_date'           => date('Y-m-d H:i:s'),
          );

          // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
          $status = $db->insert('escalation_dates_details',$insertDateArray);
          if($status != 1)
          {
            log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
          if($updateFlag == true)
          {
            $where_history_set = array(
              'petition_no' => $petition_no,
              'case_no'     => $row->case_no,
            );
            $updateDatesArraySet = array(
              'history_id'     => $date_history,
            );
            $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
            if($db->affected_rows() <= 0)
            {
              log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
              $response['responseType'] =0;
              $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
              return $response;
            }
          }      

          $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
          if($updateTable == 'n')
          {
            log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
            return $response;
          }

          $insertRemarkArray = array(
            'case_no'                     => $row->case_no,
            'petition_no'                 => $row->petition_no,
            'assigned_from'               => 'CO',
            'assigned_from_code'          => 6,
            'assigned_to'                 => 'DC',
            'assigned_to_code'            => 2,
            'created_at'                  => date('Y-m-d H:i:s'),
            'updated_at'                  => date('Y-m-d H:i:s'),
            'remark_status'               => null
          );

          $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
          if($remarkInsertionStatus != 1)
          {
            log_message("error","#ERR010712 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR010712 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
        }

        // From CO to DC for MUT/PART/NCAN/NCOR cases========
        if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
        { 
          $db->trans_begin();
          $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
          $co_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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
          // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

          $originalAllocation      = $total_remaining_days_for_dc;
          $deEscalationUsed = false;
          if($originalAllocation <= 0)
          {
            $deEscalationUsed = true;
            // $originalAllocation = 2;
            ///get timeline from matrix version for de-escalation=================
            $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
            if(empty($timeLineForDeesc))
            {
              log_message("error","#ERR6498 : update Failed on escalation_details Failed=======");
              $response['responseType'] =0;
              $response['msg'] = '#ERR6498 : De-escalation error';
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



          $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
          log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
          $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

          $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

          $dateCodes             = $row->co_date_code_list;
          $previousCompletedDays = $row->co_completed_days;
          $co_target_days        = $row->co_target_days;

          // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
          $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

          $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
          $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

          // get location detail from service table
          $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
                array($row->case_no, 1))->row();

          // get CO user code
          $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);
            
          $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);

          $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
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
            'assigned_from'               => $co_code->user_code,
            'assigned_from_code'          => 6,
            'assigned_to'                 => $dcUserDetails->user_code,
            'assigned_to_code'            => 2,  //hard code for DC
            'assigned_date'               => $executionDate.date(' H:i:s'),
            'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
            'completion_date'  => $executionDate.date(' H:i:s'),
            'escalated_status' => $escalate_status,
            'completion_days'  => $completion_days_for_history
          );

          $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

          $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );

          $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

          $date_history    = $this->generateDateCode($db);
          $insertDateArray = array(
            'sr_no'                  => $dateCode,
            'date_code'              => $date_history,
            'petition_no'            => $petition_no,
            'service_code'           => $row->service_code,
            'taskid'                 => $taskId[3]->CODE,
            'pending_officer'        => $dcUserDetails->user_code,
            'assigned_user'          => $co_code->user_code,
            'assigned_user_code'     => 6,
            'assigned_to'            => $dcUserDetails->user_code,
            'assigned_to_code'       => 2,
            'registerd_on'           => $row->registerd_on,
            'allocation_date'        => $executionDate.date(' H:i:s'),
            'target_completion_date' => $escalatedDate.date(' H:i:s'),
            'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
            'escalated_status'       => 'N',
            'created_date'           => date('Y-m-d H:i:s'),
            'updated_date'           => date('Y-m-d H:i:s'),
          );

          // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
          $status = $db->insert('escalation_dates_details',$insertDateArray);
          if($status != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR6632 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6632 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
          if($updateFlag == true)
          {
            $where_history_set = array(
              'petition_no' => $petition_no,
              'case_no'     => $row->case_no,
            );
            $updateDatesArraySet = array(
              'history_id'     => $date_history,
            );
            $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
            if($db->affected_rows() <= 0)
            {
              $db->trans_rollback();
              log_message("error","#ERR6650 : Update Failed on escalation_details Failed=======".$db->last_query());
              $response['responseType'] =0;
              $response['msg'] = '#ERR6650 : Update Failed on escalation_details Failed';
              return $response;
            }
          }      
          
          $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
          if($updateTable == 'n')
          {
            $db->trans_rollback();
            log_message("error","#ERR6658 : Update Failed on service wise table Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6658 : Update Failed on escalation_details Failed';
            return $response;
          }

          $insertRemarkArray = array(
            'case_no'            => $row->case_no,
            'petition_no'        => $row->petition_no,
            'assigned_from'      => 'CO',
            'assigned_from_code' => 6,
            'assigned_to'        => 'DC',
            'assigned_to_code'   => 2,
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
            'remark_status'      => null
          );

          $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
          if($remarkInsertionStatus != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR06679 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR06679 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }

          $db->trans_commit();
        }

        // assistant
        if($row->assigned_other_code == 8 && in_array($row->service_code, $service_code_array)) 
        { 
          $db->trans_begin();
          $originalAllocation      = $row->co_target_days;
          $previousCompletedDaysCO = $row->co_completed_days;
          $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
          $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

          $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_other_date));

          $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

          $dateCodes             = $row->da_date_code_list;
          $previousCompletedDays = $row->da_completed_days;
          $da_target_days        = $row->da_target_days;

          // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
          $da_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
          
          $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
          $updateArray = array(
            'taskid'                      => $taskId[1]->CODE, // AST message
            'da_completed_days'           => (int) $da_completed_days + (int) $previousCompletedDays,
            'da_escalate_status'          => $escalate_status,
            // 'assigned_from'               => $row->assigned_to,
            // 'assigned_from_code'          => $row->assigned_to_code,
            // 'assigned_to'                 => $row->assigned_from,
            // 'assigned_to_code'            => $row->assigned_from_code,
            // 'assigned_date'               => $executionDate.date(' H:i:s'),
            // 'escalated_date'              => $escalatedDate.date(' H:i:s'),
            'da_date_code_list'           => $dateCodes,
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
            'completion_date'  => $executionDate.date(' H:i:s'),
            'escalated_status' => $escalate_status,
            'completion_days'  => $completion_days_for_history
          );

          $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

          $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );

          $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

          $date_history    = $this->generateDateCode($db);
          // $insertDateArray = array(
          //   'sr_no'                  => $dateCode,
          //   'date_code'              => $date_history,
          //   'petition_no'            => $petition_no,
          //   'service_code'           => $row->service_code,
          //   'taskid'                 => $taskId[2]->CODE,
          //   'pending_officer'        => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
          //   'assigned_user'          => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
          //   'assigned_user_code'     => '6',
          //   'assigned_to'            => $row->assigned_other,
          //   'assigned_to_code'       => $row->assignment_type_other,
          //   'registerd_on'           => $row->registerd_on,
          //   'allocation_date'        => $executionDate.date(' H:i:s'),
          //   'target_completion_date' => $escalatedDate.date(' H:i:s'),
          //   'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
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
            'pending_officer'        => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
            'assigned_user'          => $row->assigned_other,
            'assigned_user_code'     => $row->assigned_other_code,
            'assigned_to'            => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
            'assigned_to_code'       => 6,
            'registerd_on'           => $row->registerd_on,
            'allocation_date'        => $executionDate.date(' H:i:s'),
            'target_completion_date' => $escalatedDate.date(' H:i:s'),
            'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
            'escalated_status'       => $escalate_status,
            'created_date'           => date('Y-m-d H:i:s'),
            'updated_date'           => date('Y-m-d H:i:s'),
          );

          // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
          $status = $db->insert('escalation_dates_details',$insertDateArray);
          if($status != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR4500 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4500 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }
          if($updateFlag == true)
          {
            $where_history_set = array(
              'petition_no' => $petition_no,
              'case_no'     => $row->case_no,
            );
            $updateDatesArraySet = array(
              'history_id'     => $date_history,
            );
            $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
            if($db->affected_rows() <= 0)
            {
              $db->trans_rollback();
              log_message("error","#ERR5000 : Update Failed on escalation_details Failed=======".$db->last_query());
              $response['responseType'] = 0;
              $response['msg'] = '#ERR5000 : Update Failed on escalation_details Failed';
              return $response;
            }
          }

          $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
          if($updateTable == 'n')
          {
            $db->trans_rollback();
            log_message("error","#ERR4736 : Update Failed on service wise table Failed=======".$db->last_query());
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
            'assigned_to_code'            => $this->getPendingOfficer($loc_details->dist_code, $loc_details->subdiv_code, $loc_details->cir_code, 'CO', $db),
            'created_at'                  => date('Y-m-d H:i:s'),
            'updated_at'                  => date('Y-m-d H:i:s'),
            'remark_status'               => null
          );

          $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
          if($remarkInsertionStatus != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR0107123 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR0107123 : Insert Failed on escalation_dates_details Failed';
            return $response;
          }

          // update escalation_of_failed_cases
          $failedUpdate = $db->query("UPDATE escalation_of_failed_cases SET resolve_status=? 
                      AND updated_date=?", array('y', date('Y-m-d H:i:s')));
          if($db->affected_rows() != 1)
          {
            $db->trans_rollback();
            log_message("error","#ERR498 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR498 : Updation Failed on escalation_of_failed_cases';
            return $response;
          }

          $db->trans_commit();
        }

        


      }

    }

  }

  // auto escalation for assistant
  public function assistantEscalation($row, $db)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    

    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate= date('Y-m-d H:i');
      $escalatedDatedAst = date('Y-m-d H:i',strtotime($row->assigned_other_es_date));
    }
    else
    {
      $executionDate  = date('Y-m-d');
      $escalatedDatedAst = date('Y-m-d',strtotime($row->assigned_other_es_date));
    }

    // From AST to CO
    log_message('error','AST======'.$executionDate.'==========='.$escalatedDatedAst);
    if($escalatedDatedAst == $executionDate)
    {
      // $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffAst==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC5163 : Update Failed on service wise table Failed=======".$db->last_query());
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
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_other_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->da_date_code_list;
        $previousCompletedDays = $row->da_completed_days;
        $da_target_days        = $row->da_target_days;

        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $da_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
            $petDetails = $this->getPetitionDetails($row->case_no, $db);
        }
        if($case_prefix[4] == 'MiND')
        {
            $petDetails = $this->getNcanDetailsByCaseNo($row->case_no, $db);
        }
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // AST message
          'da_completed_days'           => (int) $da_completed_days + (int) $previousCompletedDays,
          'da_escalate_status'          => $escalate_status,
          'assigned_from_other'            => $row->assigned_other,
          'assigned_from_other_code'       => $row->assigned_other_code,
          'assigned_other'                 => 6,
          'assigned_other_code'            => $this->getPendingOfficer($petDetails->dist_code, $petDetails->subdiv_code, $petDetails->cir_code, 'CO', $db),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        // $insertDateArray = array(
        //   'sr_no'                  => $dateCode,
        //   'date_code'              => $date_history,
        //   'petition_no'            => $petition_no,
        //   'service_code'           => $row->service_code,
        //   'taskid'                 => $taskId[2]->CODE,
        //   'pending_officer'        => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
        //   'assigned_user'          => $this->getPendingOfficer($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),'CO'),
        //   'assigned_user_code'     => '6',
        //   'assigned_to'            => $row->assigned_other,
        //   'assigned_to_code'       => $row->assignment_type_other,
        //   'registerd_on'           => $row->registerd_on,
        //   'allocation_date'        => $executionDate.date(' H:i:s'),
        //   'target_completion_date' => $escalatedDate.date(' H:i:s'),
        //   'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
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
          'pending_officer'        => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO', $db),
          'assigned_user'          => $row->assigned_other,
          'assigned_user_code'     => $row->assignment_type_other,
          'assigned_to'            => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO', $db),
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        log_message("error","ASTCES-ST======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4500 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4500 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR5000 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERR5000 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        log_message("error","ASTCES-ST======updateTable".json_encode($updateTable));
        if($updateTable == 'n')
        {
          log_message("error","#ERR4736 : Update Failed on service wise table Failed=======".$db->last_query());
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
          'assigned_to_code'            => $this->getPendingOfficer($petDetails->dist_code,$petDetails->subdiv_code,$petDetails->cir_code,'CO', $db),
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );


        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107123 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107123 : Insert Failed on escalation_dates_details Failed';
          return $response;
          
        }
      }

      if($row->assigned_other_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $lastAssignedDate        = $row->assigned_other_date;
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
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



        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate        = $row->assigned_other_date;

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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


          
        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
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
          'assigned_other_date'         => $executionDate.date(' H:i:s'),
          'assigned_other_es_date'      => $escalatedDate.date(' H:i:s'),
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
        'completion_date'  => $executionDate.date(' H:i:s'),
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
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
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id_others'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$db->last_query());
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

        // $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        // if($remarkInsertionStatus != 1)
        // {
        //   log_message("error","#ERR0107124 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
        //   $response['responseType'] =0;
        //   $response['msg'] = '#ERR0107124 : Insert Failed on escalation_dates_details Failed';
        //   return $response;
        // }
        
      }

    }
    return $response;

    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  

  public function checkTotalTimeIsOutorNot($case_no,$service_code, $db)
  {
    ///////////checking total timeline////////////////////
    $service = $this->getServiceName($case_no);
    $totalTimeline = $this->getTotalTimeLine($service_code, $db);
    $row = $this->getEscalatedRowDetailsCaseNo($case_no, $db);
    $getHolidayCount = $this->getHolidayCountDetails($db,date('Y-m-d',strtotime($row->registerd_on)),date('Y-m-d'));
    //adding also holidays===========
    $totalTimeline =  (int) $getHolidayCount + (int) $totalTimeline;

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

  public function getHolidayCountDetails($db,$registerd_on, $curr_date)
  {
    $sql = "Select count(*) as tot_time from holiday_details where holiday_date between ? and ? ";
    $matrix = $db->query($sql, array($registerd_on, $curr_date))->row();
    log_message('error','HOLIDAY_COUNT_TOTAL======'.json_encode($matrix));
    if (isset($matrix) && !empty($matrix) && $matrix != null) {
        return $matrix->tot_time;
    } else {
        return null;
    }
  }

  public function getTotalTimeLine($service_code, $db)
  {
    $sql = "Select sum(total_timeline) as tot_time from escalation_matrix where service_code=? ";
    $matrix = $db->query($sql, array($service_code))->row();
    if (isset($matrix) && !empty($matrix) && $matrix != null) {
        return $matrix->tot_time;
    } else {
        return null;
    }
  }

  public function getEscalatedRowDetailsCaseNo($case_no, $db)
  {
      $sql = $db->query("select * from escalation_details where case_no = ? ", array($case_no));
      return $sql->row();
  }


  public function escalationMatrixBlock($case_no, $executionDate,$finalStatus, $db)
  {
  
      $response = array('responseType' => 2,'msg'=>null);
      $where = array(
          'case_no' => $case_no
      );
      $updateDatesArray = array(
          'status' => $finalStatus,
          'final_completion_date' => $executionDate.date(' H:i:s'),
          'out_of_esc_status' => 'y'
      );
      $updateStatus22 = $db->update('escalation_details', $updateDatesArray, $where);
      log_message("error","#ESCQUERY=======".$case_no);
      if ($db->affected_rows() <= 0) {
          $response['responseType'] = 1;
          $response['msg'] = '#ERRESCLATION78777721 : Updation failed on Escalation row not found';
          return $response;
      }
      $serviceResponse = $this->updateServiceWiseTableForBlockBeforeEscalation($case_no, $db);
      if($serviceResponse == 'n')
      {
          $response['responseType'] = 1;
          $response['msg'] = '#ERRESCLATION78777821 : Updation failed on service wise table';
          return $response;
      }
      return $response;
  }

  public function updateServiceWiseTableForBlockBeforeEscalation($case_no, $db)
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
    $query = $db->query("UPDATE $table SET out_of_esc=?,is_escalated=? WHERE $case_no_val=?", array(1,0, $case_no));
    if($db->affected_rows() != 1)
    {
      return 'n';
    }
    return 'y';
  }

  public function getPetitionDetails($case_no, $db)
  {
      $sql = "Select * from petition_basic where  case_no=?";
      $data = $db->query($sql, array($case_no))->row();
      return $data;
  }

  public function getNcanDetailsByCaseNo($case_no, $db)
  {
      $sql = "Select * from misc_case_basic where  misc_case_no=?";
      $data = $db->query($sql, array($case_no))->row();
      return $data;

  }

  public function checkHolidayInsertOrNot($db,$date)
  {
    $checkHolidayInsertOrNot = $db->query("select * from escalation_holiday_daily_insert where date(holiday_running_date) = ? and status = ? ",array($date,'Y'));
    return $checkHolidayInsertOrNot->num_rows();
  }

  public function autoUpdatedHoliday($db)
  {
    $message = '';
    $holidayResp = $this->updateTablesIfHoliday($db);
    if($holidayResp == 'n')
    {
      log_message('error', "#ERR4122: Data updation failed  : ".json_encode($holidayResp));
      $message = 'Though data updation failed';
    }

    //log_message('error', "#ERR4127: Auto escalation is not required as today is holiday : $date");
    $json = [
      'response'    => 3,
      'message'     => 'Auto escalation is not required !!! '.$message,
    ];
    return $json;
  }


  // ======================================================================
  public function autoEscalateSingleCaseToRespectiveOfficer($db)
  {
    log_message("error" ,"INSIDE3479: I have entered to the method !!!");
    $date = date('Y-m-d');
    $json = array();

    // ========== holiday check if auto escalation required starts here  =============
    $isHoliday = $this->getHoliday($db);

    $holidayInsertCountForTheDay = $this->checkHolidayInsertOrNot($db,$date);
    log_message('error','HOLIDAY--INSERT--OR--NOT======='.json_encode($holidayInsertCountForTheDay));

    if($isHoliday == 1 && $holidayInsertCountForTheDay == 0)
    {
      $message = '';
      $holidayResp = $this->updateTablesIfHoliday($db);
      if($holidayResp == 'n')
      {
        log_message('error', "#ERR4122: Data updation failed  : ".json_encode($holidayResp));
        $message = 'Though data updation failed';
      }

      log_message('error', "#ERR4127: Auto escalation is not required as today is holiday : $date");
      $json = [
        'response'    => 3,
        'message'     => 'Auto escalation is not required !!! '.$message,
      ];
      return $json;
    }
    log_message("error" ,"INSIDE3524: Holiday logic is completed !!! ");
    // ========== holiday check if auto escalation required ends here  ==========
    // $otherResp    = array();
    $failedCases  = array();
    $successCases = array();
    $asstResp     = array();
    $lmResp       = array();
    $skResp       = array();
    $coResp       = array();
        
    // ============= AST starts here ===============
    $asstResult = $this->getToBeAutoEscalatedCasesOfAssistant($db);
    if($asstResult->num_rows() > 0)
    {
      $result = $asstResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->assistantEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row, $db);
          $asstResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row, $db);
          $asstResp[] = $row;
        }
      }
    } 
    log_message("error" ,"INSIDE3555: Assistant logic is completed !!! ");

    // ============= LM starts here ===============    
    $lmResult = $this->getToBeAutoEscalatedCasesOfLm($db);
    if($lmResult->num_rows() > 0)
    {
      $result = $lmResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->lmEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row, $db);
          $lmResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row, $db);
          $lmResp[] = $row;
        }
      }
    }
    log_message("error" ,"INSIDE3580: LM logic is completed !!! ");

    // ============= SK starts here ===============    
    $skResult = $this->getToBeAutoEscalatedCasesOfSk($db);
    if($skResult->num_rows() > 0)
    {
      $result = $skResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->skEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row, $db);
          $skResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row, $db);
          $skResp[] = $row;
        }
      }
    }
    log_message("error" ,"INSIDE3580: SK logic is completed !!! "); 

    // ============= CO starts here ===============    
    $coResult = $this->getToBeAutoEscalatedCasesOfCo($db);
    if($coResult->num_rows() > 0)
    {
      log_message("error" ,"INSIDE3610: I am inside CO !!! ");
      $result = $coResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->coEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row, $db);
          $coResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row, $db);
          $coResp[] = $row;
        }
      }
    }

    // ============= ADC starts here ===============    
    $adcResult = $this->getToBeAutoEscalatedCasesOfAdc($db);
    if($adcResult->num_rows() > 0)
    {
      log_message("error" ,"INSIDE3610: I am inside ADC !!! ");
      $result = $adcResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->adcEscalation($row, $db);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCases[] = $row;
          $this->insertSuccessData($row, $db);
          $adcResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCases[] = $row;
          $this->insertFailedData($row, $db);
          $adcResp[] = $row;
        }
      }
    }

    $json = [
      'response'     => 3,
      'asstResp'     => $asstResp,
      'lmResp'       => $lmResp,
      'skResp'       => $skResp,
      'coResp'       => $coResp,
      'adcResp'      => $adcResp,
      'failedCases'  => $failedCases,
      'successCases' => $successCases,
      'message'      => 'Auto escalation successfull !!!',
    ];
    return $json;   
  }

  public function getToBeAutoEscalatedCasesOfLm($db)
  {
    $user_desig_code = 'LM';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      $queryVal = $db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
    }

    else
    {
      $currDate = date('Y-m-d');
      // $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,'P','N',$assigned_to));
      $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and assigned_to_code = ?", array($currDate,'P',$assigned_to));
      
    }
    log_message('error','#LMESCQUERY4496--'.$db->last_query());
    return $queryVal;
  }

  public function getToBeAutoEscalatedCasesOfSk($db)
  {
    $user_desig_code = 'SK';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      $queryVal = $db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
    }
    else
    {
      $currDate = date('Y-m-d');
     
      $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and assigned_to_code = ?", array($currDate,'P',$assigned_to));
      
    }
    log_message('error','#SKESCQUERY4520--'.$db->last_query());
    return $queryVal;
  }

  public function getToBeAutoEscalatedCasesOfCo($db)
  {
    $user_desig_code = 'CO';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');

      // $queryVal = $db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,$currDateLast,'P','N',$assigned_to));
      $queryVal = $db->query("SELECT * FROM escalation_details WHERE escalated_date between ? and ? and status = ? and final_completion_date  is null and assigned_to_code = ?", array($currDate,$currDateLast,'P',$assigned_to));
    }
    else
    {
      // $currDate = date('Y-m-d');
      $currDate = date('Y-m-d');
     
      // $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ?", array($currDate,'P','N',$assigned_to));
      $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and assigned_to_code = ?", array($currDate,'P',$assigned_to));
      
    }
    log_message('error','#COESCQUERY4592--'.$db->last_query());
    return $queryVal;
  }

  // auto escalation for LM to CO
  public function lmEscalation($row, $db)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type       = $this->getServiceName($row->case_no);
    $table              = $this->getTableNameByServiceType($service_type);
    $petition_no        = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate= date('Y-m-d H:i');
      $escalatedDatedLm = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      // $executionDate  = date('Y-m-d');
      $executionDate  = date('Y-m-d');
      $escalatedDatedLm = date('Y-m-d',strtotime($row->escalated_date));
    }

    // From LM to CO
    log_message('error','LM======'.$executionDate.'==========='.$escalatedDatedLm);
    if($escalatedDatedLm == $executionDate)
    {
      // $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','ESCALATESTART timeOffLm==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC4542 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC4542 : Update Failed on escalation_details Failed';
          return $response;
        }
        log_message('error','ESCALATESTART out of escalation==========='.$row->case_no);
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From LM to CO
      if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
      { 
        log_message('error','ESCALATESTART LM TO CO==========='.$row->case_no);

        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);
        //if co remaining days not found what will happend=========


        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->lm_date_code_list;
        $previousCompletedDays = $row->lm_completed_days;
        $lm_target_days        = $row->lm_target_days;

        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $lm_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);

        $updateArray = array(
          'taskid'                      => $taskId[0]->CODE, // LM message
          'lm_completed_days'           => (int) $lm_completed_days+(int) $previousCompletedDays,
          'lm_escalate_status'          => 'Y',
          'assigned_from'               => $officerCode['lm'],
          'assigned_from_code'          => 9,
          'assigned_to'                 => $officerCode['co'],
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        // $db->last_query();
        // $db->trans_rollback();

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['co'],
          'assigned_user'          => $officerCode['lm'],
          'assigned_user_code'     => 9,
          'assigned_to'            => $officerCode['co'],
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4672 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4672 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4688 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4688 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4700 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR4700 : Update Failed on escalation_details Failed';
          return $response;
        }


        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'LM',
          'assigned_from_code' => 9,
          'assigned_to'        => 'CO',
          'assigned_to_code'   => 6,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null,
        );


        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR4721 : Insert Failed on escalation_cases_remark_status Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4721 : Insert Failed on escalation_cases_remark_status Failed';
          return $response;
        }
        log_message('error','ESCALATESTART LM TO CO COMPLETED==========='.$row->case_no);
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // auto escalation for SK to CO
  public function skEscalation($row, $db)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate= date('Y-m-d H:i');
      $escalatedDatedLm = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      $executionDate  = date('Y-m-d');
      // $executionDate  = '2024-09-24';
      $escalatedDatedLm = date('Y-m-d',strtotime($row->escalated_date));
    }

    // From SK to CO
    log_message('error','SK======'.$executionDate.'==========='.$escalatedDatedLm);
    if($escalatedDatedLm == $executionDate)
    {
      // $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffSk==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC4790 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC4790 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From SK to CO
      if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
      { 
        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);

        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->sk_date_code_list;
        $previousCompletedDays = $row->sk_completed_days;
        $sk_target_days        = $row->sk_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
        $sk_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
          'sk_escalate_status'          => $escalate_status,
          'assigned_from'               => $officerCode['sk'],
          'assigned_from_code'          => 7,
          'assigned_to'                 => $officerCode['co'],
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['co'],
          'assigned_user'          => $officerCode['sk'],
          'assigned_user_code'     => 7,
          'assigned_to'            => $officerCode['co'],
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4900 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4900 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4924 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4924 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4936 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4936 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'SK',
          'assigned_from_code'          => 7,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR4955 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4955 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // auto escalation for CO to DC
  public function coEscalation($row, $db)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,6,8]; // other then reclass
    $service_code_array_2 = [4,7,5]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate  = date('Y-m-d H:i');
      $escalatedDated = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      $executionDate  = date('Y-m-d');
      $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));
    }

    log_message("error" ,"INSIDE4185: Execution Date : ". $executionDate);
    log_message("error" ,"INSIDE4186: Escalated Date : ". $escalatedDated);

    // echo $escalatedDated."==".$executionDate; die;

    // var_dump('ESCALATED DATE==='.$escalatedDated.'===='.$executionDate);
    // log_message('error','ESCALATED DATE===================='.$escalatedDated.'=========='.$executionDate);
    // die;
    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      log_message("error" ,"INSIDE4185: As date are similar so i am inside the logic");
      // echo $escalatedDated."==".$executionDate; die;
      // $executionDate = date('Y-m-d H:i:s');
      // log_message('error','######ESCALATESTART==========='.$row->case_no);
      
      // From CO to DC for Reclass/AreaCOR/ACPP cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);


        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $officerCode['co'],
          'assigned_from_code'          => 6,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['co'],
          'assigned_user_code'     => 6,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => 6,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => 2,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR010712 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR010712 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From CO to DC for MUT/PART/NCAN/NCOR cases========
      ///changed 191124--== if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array))
      { 
        $db->trans_begin();
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $co_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE,$db);
          // var_dump('$timeLineForDeesc: '.$timeLineForDeesc); die;
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR6498 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR6498 : De-escalation error';
            return $response;
          }
          // var_dump($timeLineForDeesc->da_allocated_days);die;


          $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
          $originalAllocation = $sumationOfTotalTime;

          // var_dump('originalAllocation: '.$originalAllocation);die;

        }
        else
        {
          $originalAllocation = $total_remaining_days_for_dc;
        }


        $previousCompletedDaysDC = 0;

        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

        // var_dump('remaining_days_other: '.$remaining_days_other);
        // echo "<br>";
        // var_dump('escalatedDate: '.$escalatedDate);
        // echo "<br>";
        // var_dump('co_completed_days: '.$co_completed_days);
        // die;

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

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        // var_dump($to_be_completed_within_days);die;
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
          'assigned_from'               => $officerCode['co'],
          'assigned_from_code'          => 6,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['co'],
          'assigned_user_code'     => 6,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // var_dump($insertDateArray); die;

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR6632 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6632 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            $db->trans_rollback();
            log_message("error","#ERR6650 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6650 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          $db->trans_rollback();
          log_message("error","#ERR6658 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6658 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'CO',
          'assigned_from_code' => 6,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR06679 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR06679 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        $db->trans_commit();
      }

      log_message("error" ,"INSIDE4648: I am done, I am supoose to return success !!");

      // $escDataForStore = $this->getEscalatedRowDetailsCaseNo($row->case_no);
      // return $escDataForStore;
      
    }
    return $response;
    log_message('error','ESCALATE---NOT---START==========='.$row->case_no);
  }

  // auto escalation for ADC to DC
  public function adcEscalation($row, $db)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,6,8]; // other then reclass
    $service_code_array_2 = [4,7,5];
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $executionDate  = date('Y-m-d H:i');
      $escalatedDated = date('Y-m-d H:i',strtotime($row->escalated_date));
    }
    else
    {
      $executionDate  = date('Y-m-d');
      $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));
    }

    log_message("error" ,"INSIDE4786: Execution Date : ". $executionDate);
    log_message("error" ,"INSIDE4787: Escalated Date : ". $escalatedDated);

    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      // From ADC to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","ADC-TARGET_DAYS=======".$adc_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code, 'DC', $db);

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                     => $taskId[1]->CODE, // SK message
          'adc_completed_days'         => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'        => $escalate_status,
          'assigned_from'              => $officerCode['adc'],
          'assigned_from_code'         => 3,
          'assigned_to'                => $officerCode['dc'],
          'assigned_to_code'           => 2,
          'assigned_date'              => $executionDate.date(' H:i:s'),
          'escalated_date'             => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'         => $dateCodes,
          'to_be_completed_within_days'=> $to_be_completed_within_days,
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22 = $db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['adc'],
          'assigned_user_code'     => 3,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4898 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4898 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4914 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4914 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4924 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4924 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'ADC',
          'assigned_from_code' => $row->assigned_to,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => $row->assigned_from,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR4945 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4945 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // FROM ADC TO DC FOR NCOR
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array))
      { 
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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

        $coRemainingDays = $row->co_target_days - $row->co_completed_days;
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

        $adcRemainingDays = $row->adc_target_days - $adc_completed_days;
        if($adcRemainingDays == $row->adc_target_days)
        {
          $new_adc_target_days = 0;
          $new_adc_completed_days = 0;
        }
        else
        {
          $new_adc_target_days = $row->adc_completed_days;
          $new_adc_completed_days = $row->adc_completed_days;
        }

        $total_remaining_days_for_dc = $lmRemainingDays + $skRemainingDays + $coRemainingDays + $daRemainingDays + $adcRemainingDays;
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR5129 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR5129 : De-escalation error';
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

        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","adc-TARGET_DAYS=======".$adc_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);
           
        $escalate_status = 'Y';        

        // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE,
          'lm_target_days'              => (int) $new_lm_target_days,
          'lm_completed_days'           => (int) $new_lm_completed_days,
          'sk_target_days'              => (int) $new_sk_target_days,
          'sk_completed_days'           => (int) $new_sk_completed_days,
          'da_target_days'              => (int) $new_da_target_days,
          'da_completed_days'           => (int) $new_da_completed_days,
          'co_target_days'              => (int) $new_co_target_days,
          'co_completed_days'           => (int) $new_co_completed_days,
          'adc_completed_days'          => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'         => $escalate_status,
          'assigned_from'               => $officerCode['adc'],
          'assigned_from_code'          => 3,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'          => $dateCodes,
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['adc'],
          'assigned_user_code'     => 3,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR5254 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR5254 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR5272 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR5272 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR5285 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR5285 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'ADC',
          'assigned_from_code' => 3,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR5305 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR5305 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        $db->trans_commit();
      }
    }
    return $response;
  }

  public function getToBeAutoEscalatedCasesOfAdc($db)
  {
    $user_desig_code = 'ADC';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if(ESCALATION_ALLOW_TIME ==1)
    {
      $currDate     = date('Y-m-d H:i:s');
      $currDateLast = date('Y-m-d 23:59:23');
      $queryVal = $db->query("SELECT * FROM escalation_details WHERE escalated_date 
                    BETWEEN ? AND ? AND status = ? AND final_completion_date IS NULL AND 
                      ($escalate_status = ? OR $escalate_status IS NULL) AND 
                        assigned_to_code = ?", 
                          array($currDate, $currDateLast, 'P', 'N', $assigned_to));
    }
    else
    {
      $currDate = date('Y-m-d');
      $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? 
                      AND status = ? AND final_completion_date IS NULL AND  assigned_to_code = ?", array($currDate, 'P', $assigned_to));
      
    }
    log_message('error','#ADCESCQUERY4496--'.$db->last_query());
    return $queryVal;
  }
  

  // ======================================================================

  // api for auto escalate the cases to next officer
  public function apiForAutoEscalate($db, $api_date)
  {
    // $date = date('Y-m-d');
    $json = array();
    
    // ========== holiday check if auto escalation required starts here  =============
    // $isHoliday = $this->getHoliday($db);

    // $holidayInsertCountForTheDay = $this->checkHolidayInsertOrNot($db,$api_date);
    // log_message('error','HOLIDAY--INSERT--OR--NOT======='.json_encode($holidayInsertCountForTheDay));

    // if($isHoliday == 1 && $holidayInsertCountForTheDay == 0)
    // {
    //   $message = '';
    //   $holidayResp = $this->updateTablesIfHoliday($db);
    //   if($holidayResp == 'n')
    //   {
    //     log_message('error', "#ERR5086: Data updation failed  : ".json_encode($holidayResp));
    //     $message = 'Though data updation failed';
    //   }

    //   $statusHolidayInsert = $this->holidayInsertForTheDay($db,$holidayResp);

    //   log_message('error', "#ERR5092: Auto escalation is not required as today is holiday : $api_date");
    //   $json = [
    //     'response' => 3,
    //     'message'  => 'Auto escalation is not required !!! '.$holidayResp,
    //   ];
    //   return $json;
    // }
    // ========== holiday check if auto escalation required ends here  ==========
    $otherResp       = array();

    $failedCases     = array();
    $successCases    = array();

    $failedCasesLM   = array();
    $successCasesLM  = array();

    $failedCasesSK   = array();
    $successCasesSK  = array();

    $failedCasesCO   = array();
    $successCasesCO  = array();

    $failedCasesADC  = array();
    $successCasesADC = array();

    // ============= Assistant starts here ===============
    // $asstResp = array();
    // $asstResult = $this->apiToGetAutoEscalatedCasesOfAssistant($db, $api_date);
    // $total_ast_escalate_count = $asstResult->num_rows();
    // $db->trans_begin();
    // // log_message("error","ESCALATE START AST========CASES==".json_encode($asstResult->result()));
    // if($asstResult->num_rows() > 0)
    // {
    //   $result = $asstResult->result();
    //   foreach($result as $row)
    //   {
    //     // log_message("error","ESCALATE START AST========CASE NO==".json_encode($row->case_no));
    //     $escalatedResponse = $this->apiAssistantEscalation($row, $db, $api_date);
    //     if($escalatedResponse['responseType'] == 1)
    //     {
    //       log_message("error","ESCALATE SUCCESS AST========CASE NO==".json_encode($row->case_no));
    //       $successCases[] = $row;
    //       $this->insertSuccessData($row, $db);
    //       $asstResp[] = $row;
    //     }
    //     elseif($escalatedResponse['responseType'] == 0)
    //     {
    //       log_message("error","ESCALATE FAILED AST========CASE NO==".json_encode($row->case_no));
    //       $failedCases[] = $row;
    //       $this->insertFailedData($row, $db);
    //       $asstResp[] = $row;
    //     }
    //   }
    // }
    // if($total_ast_escalate_count != count($successCases)){
    //   log_message("error","ESCALATE FAILED AST COUNT MISMATCH========CASE NO COUNT==".json_encode($total_ast_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCases)));
    //   $db->trans_rollback();
    //   return;
    // } 

    // ============= LM starts here ===============
    $lmResp = array();
    $lmResult = $this->apiToGetAutoEscalatedCasesOfLm($db, $api_date);
    $total_lm_escalate_count = $lmResult->num_rows();
    // var_dump($total_lm_escalate_count); die;
    if($lmResult->num_rows() > 0)
    {
      $result = $lmResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->apiLmEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesLM[] = $row;
          $this->insertSuccessData($row, $db);
          $lmResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesLM[] = $row;
          $this->insertFailedData($row, $db);
          $lmResp[] = $row;
        }
      }
    }
    if($total_lm_escalate_count != count($successCasesLM)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_ast_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesLM)));
      $db->trans_rollback();
      return;
    }

    // ============= SK starts here ===============
    $skResp = array();
    $skResult = $this->apiToGetAutoEscalatedCasesOfSk($db, $api_date);
    $total_sk_escalate_count = $skResult->num_rows();
    if($skResult->num_rows() > 0)
    {
      $result = $skResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->apiSkEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesSK[] = $row;
          $this->insertSuccessData($row, $db);
          $skResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesSK[] = $row;
          $this->insertFailedData($row, $db);
          $skResp[] = $row;
        }
      }
    }
    if($total_sk_escalate_count != count($successCasesSK)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_sk_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesSK)));
      $db->trans_rollback();
      return;
    }

    // ============= CO starts here ===============
    $coResp = array();
    $coResult = $this->apiToGetAutoEscalatedCasesOfCo($db, $api_date);
    $total_co_escalate_count = $coResult->num_rows();
    // var_dump($total_co_escalate_count); die;
    if($coResult->num_rows() > 0)
    {
      $result = $coResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->apiCoEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesCO[] = $row;
          $this->insertSuccessData($row, $db);
          $coResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesCO[] = $row;
          $this->insertFailedData($row, $db);
          $coResp[] = $row;
        }
      }
    }
    if($total_co_escalate_count != count($successCasesCO)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_co_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesCO)));
      $db->trans_rollback();
      return;
    }
    
    // ================ADC START=====================
    $adcResp = array();
    $adcResult = $this->apiToGetAutoEscalatedCasesOfAdc($db, $api_date);
    $total_adc_escalate_count = $adcResult->num_rows();
    if($adcResult->num_rows() > 0)
    {
      $result = $adcResult->result();
      foreach($result as $row)
      {
        $escalatedResponse = $this->apiAdcEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesADC[] = $row;
          $this->insertSuccessData($row, $db);
          $adcResp[] = $row;
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesADC[] = $row;
          $this->insertFailedData($row, $db);
          $adcResp[] = $row;
        }
      }
    }
    if($total_adc_escalate_count != count($successCasesADC)){
      log_message("error","ESCALATE FAILED ADC COUNT MISMATCH========CASE NO COUNT==".json_encode($total_adc_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesADC)));
      $db->trans_rollback();
      return;
    }

    if($db->trans_status() === FALSE)
    {
      $json = [
        'response'  => 5,
      ];
      return $json;
    }
    else
    {
      $db->trans_commit();
      $json = [
        'response'  => 3,
        'otherResp' => $otherResp,
        // 'asstResp'  => $asstResp,
        'lmResp'    => $lmResp,
        'skResp'    => $skResp,
        'adcResp'   => $adcResp,
        'coResp'    => $coResp,
        'message'   => 'Auto escalation successfull !!!',
      ];
      return $json;
    } 
  }

  public function apiToGetAutoEscalatedCasesOfAssistant($db, $api_date)
  {
    $user_desig_code = 'AST';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);
   
    $queryVal = $db->query("SELECT * FROM escalation_details WHERE 
                  date(assigned_other_es_date) = ? AND status = ? AND final_completion_date IS NULL AND ($escalate_status = ? OR $escalate_status IS NULL) AND 
                      assigned_other_code = ?", array($api_date, 'P', 'N', $assigned_to));
    // echo $db->last_query(); die;
    log_message('error','#DAESCQUERY5299--'.$db->last_query());
    return $queryVal;
  }

  public function apiToGetAutoEscalatedCasesOfLm($db, $api_date)
  {
    $user_desig_code = 'LM';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);
     
    $queryVal = $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? AND             status = ? AND final_completion_date IS NULL AND ($escalate_status = ? or 
                      $escalate_status IS NULL) AND assigned_to_code = ?", 
                        array($api_date,'P','N',$assigned_to));
    // echo $db->last_query(); die;
    // log_message('error','#LMESCQUERY5311--'.$db->last_query());
    return $queryVal;
  }

  public function apiToGetAutoEscalatedCasesOfSk($db, $api_date)
  {
    $user_desig_code = 'SK';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    $queryVal =  $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? 
                    AND status = ? AND final_completion_date IS NULL AND ($escalate_status = ? 
                      OR $escalate_status IS NULL) AND assigned_to_code = ?", 
                        array($api_date,'P','N',$assigned_to));
    // log_message('error','#SKESCQUERY5325--'.$db->last_query());
    return $queryVal;
  }

  public function apiToGetAutoEscalatedCasesOfCo($db, $api_date)
  {
    $user_desig_code = 'CO';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    $queryVal = $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? 
                  AND status = ? AND final_completion_date IS NULL AND ($escalate_status = ? 
                    OR $escalate_status IS NULL) AND assigned_to_code = ?", 
                      array($api_date,'P','N',$assigned_to));
    // echo $db->last_query(); die;

    // log_message('error','#COESCQUERY5340--'.$db->last_query());
    return $queryVal;
  }

  public function apiToGetAutoEscalatedCasesOfAdc($db, $api_date)
  {
    $user_desig_code = 'ADC';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    $queryVal = $db->query("SELECT * FROM escalation_details WHERE date(escalated_date) = ? 
                  AND status = ? AND final_completion_date IS NULL AND 
                    ($escalate_status = ? OR $escalate_status IS NULL) 
                      AND assigned_to_code = ?", array($api_date, 'P', 'N', $assigned_to));

    log_message('error','#ADCESCQUERY5354--'.$db->last_query());
    return $queryVal;
  }

  public function apiAssistantEscalation($row, $db, $api_date)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    

    $service_type = $this->getServiceName($row->case_no);
    $table        = $this->getTableNameByServiceType($service_type);
    $petition_no  = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $executionDate     = $api_date;
    $escalatedDatedAst = date('Y-m-d',strtotime($row->assigned_other_es_date));

    // From AST to CO
    // log_message('error','AST======'.$executionDate.'==========='.$escalatedDatedAst);
    if($escalatedDatedAst == $executionDate)
    {
      // $executionDate= $api_date.date(' H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffAst==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC5401 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC5401 : Update Failed on escalation_details Failed';
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
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_other_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->da_date_code_list;
        $previousCompletedDays = $row->da_completed_days;
        $da_target_days        = $row->da_target_days;

        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $da_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);

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
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        log_message("error","ASTCES-ST======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR5518 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR5518 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR5534 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERR5534 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        log_message("error","ASTCES-ST======updateTable".json_encode($updateTable));
        if($updateTable == 'n')
        {
          log_message("error","#ERR5545 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR5545 : Update Failed on escalation_details Failed';
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


        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR05567 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR05567 : Insert Failed on escalation_dates_details Failed';
          return $response;
          
        }
      }
    }
    return $response;

    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // auto escalation for LM to CO
  public function apiLmEscalation($row, $db, $api_date)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type       = $this->getServiceName($row->case_no);
    $table              = $this->getTableNameByServiceType($service_type);
    $petition_no        = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    
    $executionDate    = $api_date;
    $escalatedDatedLm = date('Y-m-d',strtotime($row->escalated_date));

    // From LM to CO
    log_message('error','LM======'.$executionDate.'==========='.$escalatedDatedLm);
    if($escalatedDatedLm == $executionDate)
    {
      // $executionDate= $api_date.date(' H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffLm==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC5608 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC5608 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From LM to CO
      if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
      { 
        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->lm_date_code_list;
        $previousCompletedDays = $row->lm_completed_days;
        $lm_target_days        = $row->lm_target_days;


        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $lm_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[0]->CODE, // LM message
          'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
          'lm_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 9,
          'assigned_to'                 => $row->assigned_from,
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 9,
          'assigned_to'            => $row->assigned_from,
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4263 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4263 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4280 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4280 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4309 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR4309 : Update Failed on escalation_details Failed';
          return $response;
        }


        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'LM',
          'assigned_from_code'          => 9,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR0107 : Insert Failed on escalation_cases_remark_status Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR0107 : Insert Failed on escalation_cases_remark_status Failed';
          return $response;
        }
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // auto escalation for SK to CO
  public function apiSkEscalation($row, $db, $api_date)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type       = $this->getServiceName($row->case_no);
    $table              = $this->getTableNameByServiceType($service_type);
    $petition_no        = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $executionDate    = $api_date;
    $escalatedDatedLm = date('Y-m-d',strtotime($row->escalated_date));

    // From SK to CO
    log_message('error','SK======'.$executionDate.'==========='.$escalatedDatedLm);
    if($escalatedDatedLm == $executionDate)
    {
      // $executionDate = $api_date.date(' H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffSk==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC5815 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC5815 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From SK to CO
      if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
      { 
        // $db->trans_begin();
        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        // get CO user code
        $co_code = $this->getPendingOfficer($loc->dist_code, $loc->subdiv_code, $loc->$circle, 'CO', $db);

        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
        $dateCodes             = $row->sk_date_code_list;
        $previousCompletedDays = $row->sk_completed_days;
        $sk_target_days        = $row->sk_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
        $sk_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
          'sk_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 7,
          'assigned_to'                 => $co_code->user_code,
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
          'sk_date_code_list'           => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
        );

        // echo "<pre>"; var_dump($updateArray); die;

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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);
        // echo $db->last_query(); die;

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);
        // echo $db->last_query(); die;

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $co_code->user_code,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 7,
          'assigned_to'            => $co_code->user_code,
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // echo "<pre>"; var_dump($insertDateArray); die;

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6182 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6182 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            // $db->trans_rollback();
            log_message("error","#ERR6198 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6198 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        // echo $db->last_query(); die;
        if($updateTable == 'n')
        {
          // $db->trans_rollback();
          log_message("error","#ERR6209 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6209 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'SK',
          'assigned_from_code'          => 7,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );
        // var_dump($insertRemarkArray); die;

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6227 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6227 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        // $db->trans_commit();
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // auto escalation for CO to DC
  public function apiCoEscalation($row, $db, $api_date)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $executionDate  = $api_date;
    $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));

    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      // From CO to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        // co User code
        $co_code = $this->getPendingOfficer($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->$circle, 'CO', $db);

        // dc user code
        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);


        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 6,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
        'completion_date'  => $executionDate.date(' H:i:s'),
        'escalated_status' => $escalate_status,
        'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 6,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR4300 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4300 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR4400 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR4400 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR4587 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR4587 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => 6,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => 2,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR010712 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR010712 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From CO to DC for MUT/PART/NCAN/NCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        // $db->trans_begin();
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $co_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR6498 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR6498 : De-escalation error';
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



        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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


          
        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
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
          'assigned_from_code'          => 6,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $row->assigned_from,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 6,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6632 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6632 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            // $db->trans_rollback();
            log_message("error","#ERR6650 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6650 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          // $db->trans_rollback();
          log_message("error","#ERR6658 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6658 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'CO',
          'assigned_from_code' => 6,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR06679 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR06679 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        // $db->trans_commit();
      }

      // log_message("error" ,"INSIDE4648: I am done, I am supoose to return success !!");

      // $escDataForStore = $this->getEscalatedRowDetailsCaseNo($row->case_no);
      // return $escDataForStore;
      
    }
    return $response;
    log_message('error','ESCALATE---NOT---START==========='.$row->case_no);
  }

  public function apiAdcEscalation($row, $db, $api_date)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7];
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $executionDate  = $api_date;
    $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));

    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      // FROM ADC TO DC FOR NCOR
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        // $db->trans_begin();
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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

        $coRemainingDays = $row->co_target_days - $row->co_completed_days;
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

        $adcRemainingDays = $row->adc_target_days - $adc_completed_days;
        if($adcRemainingDays == $row->adc_target_days)
        {
          $new_adc_target_days = 0;
          $new_adc_completed_days = 0;
        }
        else
        {
          $new_adc_target_days = $row->adc_completed_days;
          $new_adc_completed_days = $row->adc_completed_days;
        }

        $total_remaining_days_for_dc = $lmRemainingDays + $skRemainingDays + $coRemainingDays + $daRemainingDays + $adcRemainingDays;
        // var_dump($total_remaining_days_for_dc); die;
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR6602 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR6602 : De-escalation error';
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

        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","adc-TARGET_DAYS=======".$adc_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);
           
        $escalate_status = 'Y';        

        // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }
          
        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE,
          'lm_target_days'              => (int) $new_lm_target_days,
          'lm_completed_days'           => (int) $new_lm_completed_days,
          'sk_target_days'              => (int) $new_sk_target_days,
          'sk_completed_days'           => (int) $new_sk_completed_days,
          'da_target_days'              => (int) $new_da_target_days,
          'da_completed_days'           => (int) $new_da_completed_days,
          'co_target_days'              => (int) $new_co_target_days,
          'co_completed_days'           => (int) $new_co_completed_days,
          'adc_completed_days'          => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'         => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 3,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'          => $dateCodes,
          'to_be_completed_within_days' => $to_be_completed_within_days,
          'dc_target_days'              => $originalAllocation, // for DC new assigning days
          'dc_allocate_days'            => $originalAllocation, // dc allocate days
          'dc_completed_days'           => 0, //set Zero for Newly assigned
        );

        // echo "<pre>";var_dump($updateArray); die;

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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $dcUserDetails->user_code,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 3,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // var_dump($insertDateArray);die;

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6728 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6728 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            // $db->trans_rollback();
            log_message("error","#ERR6746 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6746 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          // $db->trans_rollback();
          log_message("error","#ERR6757 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6757 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'ADC',
          'assigned_from_code' => 3,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );
        // var_dump($insertDateArray);die;
        

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR06781 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR06781 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        // $db->trans_commit();
      }

      // From ADC to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array_2))
      { 
        // $db->trans_begin();
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $dcUserDetails = $this->getPendingOfficerDC($caseDetails->dist_code,'DC', $db);


        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'adc_completed_days'          => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'         => $escalate_status,
          'assigned_from'               => $row->assigned_to,
          'assigned_from_code'          => 3,
          'assigned_to'                 => $dcUserDetails->user_code,
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'          => $dateCodes,
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
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $dcUserDetails->user_code,
          'assigned_user'          => $row->assigned_to,
          'assigned_user_code'     => 3,
          'assigned_to'            => $dcUserDetails->user_code,
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6589 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6589 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            // $db->trans_rollback();
            log_message("error","#ERR6605 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR6605 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          // $db->trans_rollback();
          log_message("error","#ERR6615 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6615 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'ADC',
          'assigned_from_code'          => 3,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => 2,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          // $db->trans_rollback();
          log_message("error","#ERR6636 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR6636 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        // $db->trans_commit();
      }
    }
    return $response;
  }

  // ==========================================================================


  // newly added on 30-10-2024

  // auto escalate the cases to next officer for failed cron cases
  public function failedCasesAutoEscalate($db, $api_date)
  {
    $date = date('Y-m-d');
    $json = array();

    $otherResp = array();
    $failedCases = array();
    $successCases = array();

    $failedCasesLM = array();
    $successCasesLM = array();

    $failedCasesCO = array();
    $successCasesCO = array();

    $failedCasesSK = array();
    $successCasesSK = array();

    $failedCasesADC = array();
    $successCasesADC = array();

    

    // ============= LM starts here ===============
    $lmResp = array();
    $lmResult = $this->getFailedAutoEscalatedCasesOfLm($db, $api_date);
    $total_lm_escalate_count = $lmResult->num_rows();
    if($lmResult->num_rows() > 0)
    {
      $result = $lmResult->result();
      foreach($result as $row)
      {
        $db->trans_begin();
        $escalatedResponse = $this->failedLmEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesLM[] = $row;
          $this->insertSuccessData($row, $db);
          $lmResp[] = $row;
          $db->trans_commit();    
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesLM[] = $row;
          $this->insertFailedData($row, $db);
          $lmResp[] = $row;
        }
      }
    }

    if($total_lm_escalate_count != count($successCasesLM)){
      log_message("error","ESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_ast_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesLM)));
      // $db->trans_rollback();
      // return;
    }

    // ============= SK starts here ===============
    $skResp = array();
    $skResult = $this->getFailedAutoEscalatedCasesOfSk($db, $api_date);
    $total_sk_escalate_count = $skResult->num_rows();

    if($skResult->num_rows() > 0)
    {
      $result = $skResult->result();
      foreach($result as $row)
      {
        $db->trans_begin();    
        $escalatedResponse = $this->failedSkEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesSK[] = $row;
          $this->insertSuccessData($row, $db);
          $skResp[] = $row;
          $db->trans_commit();    
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesSK[] = $row;
          $this->insertFailedData($row, $db);
          $skResp[] = $row;
        }
      }
    }

    if($total_sk_escalate_count != count($successCasesSK)){
      log_message("error","ESCALATE FAILED SK COUNT MISMATCH========CASE NO COUNT==".json_encode($total_sk_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesSK)));
      // $db->trans_rollback();
      // return;
    }

    // ============= CO starts here ===============
    $coResp = array();
    $coResult = $this->getFailedAutoEscalatedCasesOfCo($db, $api_date);
    // echo $db->last_query(); die;
    $total_co_escalate_count = $coResult->num_rows();
    if($coResult->num_rows() > 0)
    {
      $result = $coResult->result();
      foreach($result as $row)
      {
        $db->trans_begin();    
        $escalatedResponse = $this->failedCoEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesCO[] = $row;
          $this->insertSuccessData($row, $db);
          $coResp[] = $row;
          $db->trans_commit();    
        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesCO[] = $row;
          $this->insertFailedData($row, $db);
          $coResp[] = $row;
        }
      }
    }

    if($total_co_escalate_count != count($successCasesCO)){
      log_message("error","COESCALATE FAILED LM COUNT MISMATCH========CASE NO COUNT==".json_encode($total_co_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesCO)));
      // $db->trans_rollback();
      // return;
    }

    // ================ADC START=====================
    $adcResp = array();
    $adcResult = $this->getFailedAutoEscalatedCasesOfAdc($db, $api_date);
    $total_adc_escalate_count = $adcResult->num_rows();

    if($adcResult->num_rows() > 0)
    {
      $result = $adcResult->result();
      foreach($result as $row)
      {
        $db->trans_begin();    
        $escalatedResponse = $this->failedAdcEscalation($row, $db, $api_date);
        if($escalatedResponse['responseType'] == 1)
        {
          $successCasesADC[] = $row;
          $this->insertSuccessData($row, $db);
          $adcResp[] = $row;
          $db->trans_commit();    

        }
        elseif($escalatedResponse['responseType'] == 0)
        {
          $failedCasesADC[] = $row;
          $this->insertFailedData($row, $db);
          $adcResp[] = $row;
        }
      }
    }

    if($total_adc_escalate_count != count($successCasesADC)){
      log_message("error","ESCALATE FAILED ADC COUNT MISMATCH========CASE NO COUNT==".json_encode($total_adc_escalate_count)."===SUCCESSCOUNT==".json_encode(count($successCasesADC)));
      // $db->trans_rollback();
      // return;
    }

    if($db->trans_status() === FALSE)
    {
      $json = [
        'response'  => 5,
      ];

      return $json;
    }
    else
    {
      // $db->trans_commit();
      $json = [
        'response'  => 3,
        'otherResp' => $otherResp,
        // 'asstResp'  => $asstResp,
        'lmResp'    => $lmResp,
        'skResp'    => $skResp,
        'adcResp'   => $adcResp,
        'coResp'    => $coResp,
        'message'   => 'Auto escalation successfull !!!',
      ];
      $this->insertAutoEscalateData($db,$json);
      return $json;
    } 
  }

  // list of failed cases from LM
  public function getFailedAutoEscalatedCasesOfLm($db, $api_date)
  {
    $user_desig_code = 'LM';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);
        
    $queryVal =  $db->query("SELECT * FROM escalation_of_failed_cases WHERE date(escalated_date) = ? and status = ? and final_completion_date  is null and ($escalate_status = ? or $escalate_status is null) and assigned_to_code = ? AND resolve_status=?", array($api_date, 'P', 'N', $assigned_to, 'n'));      
    
    log_message('error','#LMFAILESCQUERY7566--'.$db->last_query());
    return $queryVal;
  }

  // failed cases auto escalation for LM to CO
  public function failedLmEscalation($row, $db, $api_date)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type       = $this->getServiceName($row->case_no);
    $table              = $this->getTableNameByServiceType($service_type);
    $petition_no        = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    $executionDate  = $api_date;
    $escalatedDatedLm = date('Y-m-d',strtotime($row->escalated_date));

    // From LM to CO
    log_message('error','LM======'.$executionDate.'==========='.$escalatedDatedLm);
    if($escalatedDatedLm == $executionDate)
    {
      // $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffLm==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC7609 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC7609 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From LM to CO
      if($row->assigned_to_code == 9 && in_array($row->service_code, $service_code_array)) 
      { 
        // var_dump($row->assigned_to_code); die;
        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->lm_date_code_list;
        $previousCompletedDays = $row->lm_completed_days;
        $lm_target_days        = $row->lm_target_days;

        // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
        $lm_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        // $db->trans_begin();
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);

        // var_dump($to_be_completed_within_days); die;

        $updateArray = array(
          'taskid'                      => $taskId[0]->CODE, // LM message
          'lm_completed_days'           => (int) $lm_completed_days+(int) $previousCompletedDays,
          'lm_escalate_status'          => $escalate_status,
          'assigned_from'               => $officerCode['lm'],
          'assigned_from_code'          => 9,
          'assigned_to'                 => $officerCode['co'],
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,          
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        // echo "<pre>"; 

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        // $db->last_query();
        // $db->trans_rollback();

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['co'],
          'assigned_user'          => $officerCode['lm'],
          'assigned_user_code'     => 9,
          'assigned_to'            => $officerCode['co'],
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR7731 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR7731 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() != 1)
          {
            log_message("error","#ERR7750 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR7750 : Update Failed on escalation_details Failed';
            return $response;
          }
        }

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR7760 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERR7760 : Update Failed on escalation_details Failed';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'LM',
          'assigned_from_code' => 9,
          'assigned_to'        => 'CO',
          'assigned_to_code'   => 6,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null,
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR7779 : Insert Failed on escalation_cases_remark_status Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR7779 : Insert Failed on escalation_cases_remark_status Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR7791 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR7791 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        // echo "<pre>"; 

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        // $db->last_query();
        // $db->trans_rollback();

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // list of failed cases from SK
  public function getFailedAutoEscalatedCasesOfSk($db, $api_date)
  {
    $user_desig_code = 'SK';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);
       
    $queryVal =  $db->query("SELECT * FROM escalation_of_failed_cases WHERE 
                      date(escalated_date) = ? AND status = ? AND final_completion_date 
                        IS NULL AND ($escalate_status = ? OR $escalate_status IS NULL) 
                          AND assigned_to_code = ? AND resolve_status=?", 
                            array($api_date, 'P', 'N', $assigned_to, 'n'));      
    
    log_message('error','#SKFAILESCQUERY7849--'.$db->last_query());
    return $queryVal;
  }

  // failed cases auto escalation for SK to CO
  public function failedSkEscalation($row, $db, $api_date)
  {
    $response           = array('responseType' => 1,'msg' => null);
    $taskId             = json_decode(TASK_ID);
    $dateCode           = $this->generateDateCode($db);
    $service_code_array = [1,2,3,5,6,8]; // other then reclass    
    $service_type       = $this->getServiceName($row->case_no);
    $table              = $this->getTableNameByServiceType($service_type);
    $petition_no        = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    $executionDate    = $api_date;
    $escalatedDatedSk = date('Y-m-d',strtotime($row->escalated_date));

    // From SK to CO
    log_message('error','SK======'.$executionDate.'==========='.$escalatedDatedSk);
    if($escalatedDatedSk == $executionDate)
    {
      // $executionDate= date('Y-m-d H:i:s');
      log_message('error','ESCALATESTART==========='.$row->case_no);

      $totalTimeOff = $this->checkTotalTimeIsOutorNot($row->case_no, $row->service_code, $db);
      log_message('error','timeOffSk==============='.$totalTimeOff);
      if($totalTimeOff == true)
      {
        $updateTable = $this->escalationMatrixBlock($row->case_no, $executionDate,'F', $db);
        if($updateTable['responseType'] == 1)
        {
          log_message("error","#ERRESC7894 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] = 0;
          $response['msg'] = '#ERRESC7894 : Update Failed on escalation_details Failed';
          return $response;
        }
        $response['responseType'] = 2;
        $response['msg'] = 'Case is out of escalation';
        return $response;
      }

      // From SK to CO
      if($row->assigned_to_code == 7 && in_array($row->service_code, $service_code_array)) 
      { 
        $case   = ($table == 'misc_case_basic') ? 'misc_case_no' : 'case_no';
        $circle = ($table == 'allotment_cert_basic') ? 'circle_code' : 'cir_code';

        // get location detail from service table
        $loc = $db->query("SELECT * FROM $table WHERE $case=? AND es_flag=?", 
              array($row->case_no, 1))->row();

        $originalAllocation      = $row->co_target_days;
        $previousCompletedDaysCO = $row->co_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->sk_date_code_list;
        $previousCompletedDays = $row->sk_completed_days;
        $sk_target_days        = $row->sk_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$CO_target_days);
        $sk_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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
        
        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'sk_completed_days'           => (int) $sk_completed_days + (int) $previousCompletedDays,
          'sk_escalate_status'          => $escalate_status,
          'assigned_from'               => $officerCode['sk'],
          'assigned_from_code'          => 7,
          'assigned_to'                 => $officerCode['co'],
          'assigned_to_code'            => 6,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['co'],
          'assigned_user'          => $officerCode['sk'],
          'assigned_user_code'     => 7,
          'assigned_to'            => $officerCode['co'],
          'assigned_to_code'       => 6,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR8013 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8013 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR8030 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR8030 : Update Failed on escalation_details Failed';
            return $response;
          }
        }
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR8040 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8040 : Update Failed on escalation_details Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR8050 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8050 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'SK',
          'assigned_from_code'          => 7,
          'assigned_to'                 => 'CO',
          'assigned_to_code'            => 6,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR8071 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8071 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }
    }
    return $response;
    log_message('error','ESCALATENOT---START==========='.$row->case_no);
  }

  // list of failed cases from CO
  public function getFailedAutoEscalatedCasesOfCo($db, $api_date)
  {
    $user_desig_code = 'CO';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);
       
    $queryVal =  $db->query("SELECT * FROM escalation_of_failed_cases WHERE 
                      date(escalated_date) = ? AND status = ? AND final_completion_date 
                        IS NULL AND ($escalate_status = ? or $escalate_status IS NULL) 
                          AND assigned_to_code = ? AND resolve_status=?", 
                            array($api_date, 'P', 'N', $assigned_to, 'n'));      
    
    log_message('error','#COFAILESCQUERY8097--'.$db->last_query());
    return $queryVal;
  }





  // failed cases auto escalation for CO to CO
  public function failedCoEscalation($row, $db, $api_date)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7]; // reclass, area correction
    // log_message('error','4210********'.json_encode($row));
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    $executionDate    = $api_date;
    $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));

    log_message("error" ,"INSIDE4185: Execution Date : ". $executionDate);
    log_message("error" ,"INSIDE4186: Escalated Date : ". $escalatedDated);

    // echo $escalatedDated."==".$executionDate; die;

    // var_dump('ESCALATED DATE==='.$escalatedDated.'===='.$executionDate);
    // log_message('error','ESCALATED DATE===================='.$escalatedDated.'=========='.$executionDate);
    // die;
    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      log_message("error" ,"INSIDE4185: As date are similar so i am inside the logic");
      // echo $escalatedDated."==".$executionDate; die;
      // $executionDate = date('Y-m-d H:i:s');
      // log_message('error','######ESCALATESTART==========='.$row->case_no);
      
      // From CO to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

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

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE, // SK message
          'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
          'co_escalate_status'          => $escalate_status,
          'assigned_from'               => $officerCode['co'],
          'assigned_from_code'          => 6,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['co'],
          'assigned_user_code'     => 6,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR8274 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8274 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR8289 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR8289 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR8301 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8301 : Update Failed on escalation_details Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR8313 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8313 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'                     => $row->case_no,
          'petition_no'                 => $row->petition_no,
          'assigned_from'               => 'CO',
          'assigned_from_code'          => 6,
          'assigned_to'                 => 'DC',
          'assigned_to_code'            => 2,
          'created_at'                  => date('Y-m-d H:i:s'),
          'updated_at'                  => date('Y-m-d H:i:s'),
          'remark_status'               => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR08334 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR08334 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // From CO to DC for MUT/PART/NCAN/NCOR cases========
      if($row->assigned_to_code == 6 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $db->trans_begin();
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $co_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation      = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE,$db);
          // var_dump('$timeLineForDeesc: '.$timeLineForDeesc); die;
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR8411 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR8411 : De-escalation error';
            return $response;
          }
          // var_dump($timeLineForDeesc->da_allocated_days);die;


          $sumationOfTotalTime = $timeLineForDeesc->da_allocated_days + $timeLineForDeesc->lm_allocated_days + $timeLineForDeesc->sk_allocated_days + $timeLineForDeesc->co_allocated_days + $timeLineForDeesc->bo_allocated_days + $timeLineForDeesc->adc_allocated_days;
          $originalAllocation = $sumationOfTotalTime;

          // var_dump('originalAllocation: '.$originalAllocation);die;

        }
        else
        {
          $originalAllocation = $total_remaining_days_for_dc;
        }


        $previousCompletedDaysDC = 0;

        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->co_date_code_list;
        $previousCompletedDays = $row->co_completed_days;
        $co_target_days        = $row->co_target_days;

        // log_message("error","CO-TARGET_DAYS=======".$co_target_days);
        $co_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

        // var_dump('remaining_days_other: '.$remaining_days_other);
        // echo "<br>";
        // var_dump('escalatedDate: '.$escalatedDate);
        // echo "<br>";
        // var_dump('co_completed_days: '.$co_completed_days);
        // die;

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

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        // var_dump($to_be_completed_within_days);die;
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
          'assigned_from'               => $officerCode['co'],
          'assigned_from_code'          => 6,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['co'],
          'assigned_user_code'     => 6,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // var_dump($insertDateArray); die;

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR8555 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8555 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            $db->trans_rollback();
            log_message("error","#ERR8573 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR8573 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          $db->trans_rollback();
          log_message("error","#ERR8582 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8582 : Update Failed on escalation_details Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR8596 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8596 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'CO',
          'assigned_from_code' => 6,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          $db->trans_rollback();
          log_message("error","#ERR8616 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8616 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        $db->trans_commit();
      }

      log_message("error" ,"INSIDE4648: I am done, I am supoose to return success !!");

      // $escDataForStore = $this->getEscalatedRowDetailsCaseNo($row->case_no);
      // return $escDataForStore;
      
    }
    return $response;
    log_message('error','ESCALATE---NOT---START==========='.$row->case_no);
  }

  // list of failed cases from ADC
  public function getFailedAutoEscalatedCasesOfAdc($db, $api_date)
  {
    $user_desig_code = 'ADC';
    $assigned_to     = $this->EscTableFieldsModel->getUserCode($user_desig_code);
    $escalate_status = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    $queryVal = $db->query("SELECT * FROM escalation_of_failed_cases WHERE 
                  date(escalated_date) = ? AND status = ? AND final_completion_date IS NULL AND ($escalate_status = ? OR $escalate_status IS NULL) 
                      AND assigned_to_code = ? AND resolve_status=?", 
                        array($api_date, 'P', 'N', $assigned_to, 'n'));      
    
    log_message('error','#ADCESCQUERY8663--'.$db->last_query());
    return $queryVal;
  }

  // failed cases auto escalation for ADC to CO
  public function failedAdcEscalation($row, $db, $api_date)
  {
    // echo "<pre>"; var_dump($row); die;
    $response             = array('responseType' => 1,'msg' => null);
    $taskId               = json_decode(TASK_ID);
    $dateCode             = $this->generateDateCode($db);
    $service_code_array   = [1,2,3,5,6,8]; // other then reclass
    $service_code_array_2 = [4,7];
    $service_type         = $this->getServiceName($row->case_no);
    $table                = $this->getTableNameByServiceType($service_type);
    $petition_no          = $this->getPetitionNoByCaseNo($table, $row->case_no, $db);
    $caseDetails          = $this->getCaseDetailsNoByCaseNo($table, $row->case_no, $db);

    $officerCode = $this->getOfficerCode($db, $table, $row->case_no, $service_type);

    $executionDate    = $api_date;
    $escalatedDated = date('Y-m-d',strtotime($row->escalated_date));

    log_message("error" ,"INSIDE4786: Execution Date : ". $executionDate);
    log_message("error" ,"INSIDE4787: Escalated Date : ". $escalatedDated);

    //if escalated is same as execution date then only excute escalation=========
    if($escalatedDated == $executionDate)
    {
      // From ADC to DC for Reclass/AreaCOR cases========
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array_2))
      { 
        $originalAllocation      = $row->dc_target_days;
        //if dc target days null then get remaining days from other users with maximum available days
        //update dc target days from available users days
        //set zero for dc completion days

        $previousCompletedDaysDC = $row->dc_completed_days;
        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $lastAssignedDate = date('Y-m-d', strtotime($row->assigned_date));

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","ADC-TARGET_DAYS=======".$adc_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate,$lastAssignedDate);

        //changes done on 26062024--  
        $escalate_status = 'Y';

        // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                     => $taskId[1]->CODE, // SK message
          'adc_completed_days'         => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'        => $escalate_status,
          'assigned_from'              => $officerCode['adc'],
          'assigned_from_code'         => 3,
          'assigned_to'                => $officerCode['dc'],
          'assigned_to_code'           => 2,
          'assigned_date'              => $executionDate.date(' H:i:s'),
          'escalated_date'             => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'         => $dateCodes,
          'to_be_completed_within_days'=> $to_be_completed_within_days,
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22 = $db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[0]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['adc'],
          'assigned_user_code'     => 3,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => $escalate_status,
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR8804 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8804 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR8821 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR8821 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      

        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR8831 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8831 : Update Failed on escalation_details Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR8848 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8848 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'ADC',
          'assigned_from_code' => $row->assigned_to,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => $row->assigned_from,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR8864 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR8864 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
      }

      // FROM ADC TO DC FOR NCOR
      if($row->assigned_to_code == 3 && in_array($row->service_code, $service_code_array) && $row->dc_target_days == 0)
      { 
        $lastAssignedDate  = date('Y-m-d', strtotime($row->assigned_date));
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);

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

        $coRemainingDays = $row->co_target_days - $row->co_completed_days;
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

        $adcRemainingDays = $row->adc_target_days - $adc_completed_days;
        if($adcRemainingDays == $row->adc_target_days)
        {
          $new_adc_target_days = 0;
          $new_adc_completed_days = 0;
        }
        else
        {
          $new_adc_target_days = $row->adc_completed_days;
          $new_adc_completed_days = $row->adc_completed_days;
        }

        $total_remaining_days_for_dc = $lmRemainingDays + $skRemainingDays + $coRemainingDays + $daRemainingDays + $adcRemainingDays;
        // log_message('error','#total_remaining_days_for_dc============='.$total_remaining_days_for_dc);

        $originalAllocation = $total_remaining_days_for_dc;
        $deEscalationUsed = false;
        if($originalAllocation <= 0)
        {
          $deEscalationUsed = true;
          // $originalAllocation = 2;
          ///get timeline from matrix version for de-escalation=================
          $timeLineForDeesc = $this->getTimeLine($row->service_code,$service_type,DEESCALATE, $db);
          if(empty($timeLineForDeesc))
          {
            log_message("error","#ERR8952 : update Failed on escalation_details Failed=======");
            $response['responseType'] =0;
            $response['msg'] = '#ERR8952 : De-escalation error';
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

        $remaining_days_other    = $this->getRemainingDays($previousCompletedDaysDC,$originalAllocation);
        log_message('error','**************remaining_days*****DC*****'.$previousCompletedDaysDC.'*****'.$originalAllocation.'**DIFF**'.$remaining_days_other);
        $escalatedDate           = $this->getEscalatedDateNew($remaining_days_other,$executionDate);

        $completion_days_for_history = $this->dateDiff($executionDate,$lastAssignedDate); 

        $dateCodes             = $row->adc_date_code_list;
        $previousCompletedDays = $row->adc_completed_days;
        $adc_target_days       = $row->adc_target_days;

        // log_message("error","adc-TARGET_DAYS=======".$adc_target_days);
        $adc_completed_days =  $this->dateDiff($executionDate, $lastAssignedDate);
           
        $escalate_status = 'Y';        

        // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
        if($dateCodes == null)
        {
          $dateCodes = $dateCode;
        }
        else
        {
          $dateCodes = $dateCodes.','.$dateCode;
        }

        $to_be_completed_within_days = $this->dateDiff($escalatedDate,$executionDate);
        $updateArray = array(
          'taskid'                      => $taskId[1]->CODE,
          'lm_target_days'              => (int) $new_lm_target_days,
          'lm_completed_days'           => (int) $new_lm_completed_days,
          'sk_target_days'              => (int) $new_sk_target_days,
          'sk_completed_days'           => (int) $new_sk_completed_days,
          'da_target_days'              => (int) $new_da_target_days,
          'da_completed_days'           => (int) $new_da_completed_days,
          'co_target_days'              => (int) $new_co_target_days,
          'co_completed_days'           => (int) $new_co_completed_days,
          'adc_completed_days'          => (int) $adc_completed_days + (int) $previousCompletedDays,
          'adc_escalate_status'         => $escalate_status,
          'assigned_from'               => $officerCode['adc'],
          'assigned_from_code'          => 3,
          'assigned_to'                 => $officerCode['dc'],
          'assigned_to_code'            => 2,  //hard code for DC
          'assigned_date'               => $executionDate.date(' H:i:s'),
          'escalated_date'              => $escalatedDate.date(' H:i:s'),
          'adc_date_code_list'          => $dateCodes,
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
          'service_code'=> $row->service_code,
        );
        $updateDatesArray = array(
          'completion_date'  => $executionDate.date(' H:i:s'),
          'escalated_status' => $escalate_status,
          'completion_days'  => $completion_days_for_history
        );

        $updateStatus22=$db->update('escalation_dates_details',$updateDatesArray,$where_history);

        $where = array(
          'petition_no' => $petition_no,
          'case_no'     => $row->case_no,
        );

        $updateStatus1 = $db->update('escalation_details',$updateArray ,$where);

        $date_history    = $this->generateDateCode($db);
        $insertDateArray = array(
          'sr_no'                  => $dateCode,
          'date_code'              => $date_history,
          'petition_no'            => $petition_no,
          'service_code'           => $row->service_code,
          'taskid'                 => $taskId[3]->CODE,
          'pending_officer'        => $officerCode['dc'],
          'assigned_user'          => $officerCode['adc'],
          'assigned_user_code'     => 3,
          'assigned_to'            => $officerCode['dc'],
          'assigned_to_code'       => 2,
          'registerd_on'           => $row->registerd_on,
          'allocation_date'        => $executionDate.date(' H:i:s'),
          'target_completion_date' => $escalatedDate.date(' H:i:s'),
          'date_diff'              => $this->dateDiff($escalatedDate,$executionDate),
          'escalated_status'       => 'N',
          'created_date'           => date('Y-m-d H:i:s'),
          'updated_date'           => date('Y-m-d H:i:s'),
        );

        // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
        $status = $db->insert('escalation_dates_details',$insertDateArray);
        if($status != 1)
        {
          log_message("error","#ERR9075 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR9075 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }
        if($updateFlag == true)
        {
          $where_history_set = array(
            'petition_no' => $petition_no,
            'case_no'     => $row->case_no,
          );
          $updateDatesArraySet = array(
            'history_id'     => $date_history,
          );
          $updateStatus22 = $db->update('escalation_details',$updateDatesArraySet ,$where_history_set);
          if($db->affected_rows() <= 0)
          {
            log_message("error","#ERR9092 : Update Failed on escalation_details Failed=======".$db->last_query());
            $response['responseType'] =0;
            $response['msg'] = '#ERR9092 : Update Failed on escalation_details Failed';
            return $response;
          }
        }      
        
        $updateTable = $this->updateServiceWiseTable($row->case_no, $db);
        if($updateTable == 'n')
        {
          log_message("error","#ERR9102 : Update Failed on service wise table Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR9102 : Update Failed on escalation_details Failed';
          return $response;
        }

        // update resolve status to y if success
        $updateFailedStatus = $db->query("UPDATE escalation_of_failed_cases 
                                SET resolve_status=? WHERE case_no=?",
                                  array('y', $row->case_no));
        if($db->affected_rows() != 1)
        {
          log_message("error","#ERR9114 : Updation Failed on escalation_of_failed_cases Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR9114 : Updation Failed on escalation_of_failed_cases';
          return $response;
        }

        $insertRemarkArray = array(
          'case_no'            => $row->case_no,
          'petition_no'        => $row->petition_no,
          'assigned_from'      => 'ADC',
          'assigned_from_code' => 3,
          'assigned_to'        => 'DC',
          'assigned_to_code'   => 2,
          'created_at'         => date('Y-m-d H:i:s'),
          'updated_at'         => date('Y-m-d H:i:s'),
          'remark_status'      => null
        );

        $remarkInsertionStatus = $db->insert('escalation_cases_remark_status',$insertRemarkArray);
        if($remarkInsertionStatus != 1)
        {
          log_message("error","#ERR9135 : Insert Failed on escalation_dates_details Failed=======".$db->last_query());
          $response['responseType'] =0;
          $response['msg'] = '#ERR9135 : Insert Failed on escalation_dates_details Failed';
          return $response;
        }

        $db->trans_commit();
      }
    }
    return $response;
  }

  // get users
  public function getOfficerCode($db, $table, $case_no, $service_type)
  {
    $json   = array();
    $case   = ($service_type=='MiNC' || $service_type=='MiND')?'misc_case_no':'case_no';
    $circle = ($service_type == 'ACPP') ? 'circle_code':'cir_code';

    $query  = $db->query("SELECT dist_code, subdiv_code, $circle, mouza_pargona_code, 
                lot_no, vill_townprt_code FROM $table WHERE $case=?", 
                  array($case_no))->row();
    log_message('error','getOfficerCode==='.$db->last_query());
    $dist   = $query->dist_code;
    $sub    = $query->subdiv_code;
    $cir    = $query->$circle;
    $mouza  = $query->mouza_pargona_code;
    $lot    = $query->lot_no;
    $vill   = $query->vill_townprt_code;

    $lm  = $this->getPendingOfficerLM($db,$dist,$sub,$cir,$mouza,$lot)->user_code;
    $dc  = $this->getPendingOfficerDC($dist,'DC',$db)->user_code;
    $adc = $this->getPendingOfficerADC($db,$dist,'ADC')->user_code;
    $co  = $this->getPendingOfficer($dist,$sub,$cir,'CO',$db)->user_code;
    $da  = $this->getPendingOfficer($dist,$sub,$cir,'AST',$db)->user_code;
    $sk  = $this->getPendingOfficer($dist,$sub,$cir,'SK',$db)->user_code;

    $json = [
      'da'  => $da,
      'lm'  => $lm,
      'sk'  => $sk,
      'co'  => $co,
      'adc' => $adc,
      'dc'  => $dc,
    ];
    log_message('error','getOfficerCode===JSON'.json_encode($json));
    return $json;
  }

  public function getPendingOfficerLM($db,$d, $s, $c, $mouza_pargona_code, $lot_no)
  {
      $sql = "select lt.user_code from loginuser_table lt join lm_code u on lt.dist_code=u.dist_code
          and lt.subdiv_code=u.subdiv_code
          and lt.cir_code=u.cir_code
          and lt.mouza_pargona_code=u.mouza_pargona_code
          and lt.lot_no=u.lot_no
          and u.lm_code=lt.user_code
          where lt.dis_enb_option='E'
          and lt.dist_code='$d'
          and lt.subdiv_code='$s' and lt.cir_code='$c' and lt.mouza_pargona_code='$mouza_pargona_code' and lt.lot_no='$lot_no'";
      $data = $db->query($sql);
      return $data->row();
  }

  public function getPendingOfficerADC($db,$d, $desig_code)
  {
      $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on
                lt.dist_code=u.dist_code
                  and lt.subdiv_code=u.subdiv_code
                    and u.user_code=lt.user_code where lt.dis_enb_option='E'
                      and u.user_desig_code like 'ADC%'";
      $data = $db->query($sql);
      return $data->row();
  }




}
?>
