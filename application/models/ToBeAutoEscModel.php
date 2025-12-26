<?php
class ToBeAutoEscModel extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->model('Escalationmodel');
    $this->load->model('DataBaseSwitchModel');
    $this->load->model('EscTableFieldsModel');
  }


  // get case detail from escalation table
  public function getEscalationDetailByCaseNo($case_no, $user_desig_code, $user_code, $db)
  {
    $assigned_to = $this->EscTableFieldsModel->getAssignedToField($user_desig_code);
    $esc_status  = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($user_desig_code);

    if($user_desig_code == 'AST')
    {
        $query = $db->query("SELECT * FROM escalation_details WHERE case_no=?
                      AND assigned_other_code= ? AND final_completion_date IS NULL AND ($esc_status=? OR $esc_status is null)",
                        array($case_no,8, 'N'));
    }else
    {
        $query = $db->query("SELECT * FROM escalation_details WHERE case_no=?
                      AND $assigned_to=? AND final_completion_date IS NULL AND ($esc_status=? OR $esc_status is null)",
                        array($case_no, $user_code, 'N'));
    }

    // log_message('error','878:'.$db->last_query());
    return $query;
  }

  // get list of to be escalated list from user
  public function getToBeEscalateCasesFromUserOld()
  {
    $user_desig_code = $this->session->userdata('user_desig_code');

    // var_dump($user_desig_code);

    if($user_desig_code == 'AST') // assistant
    { 
      $escalate_date          = 'assigned_other_es_date';
      // $assigned_to_code_field = 'assignment_type_other';
      $assigned_to_code_field = 'assigned_other_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code); // code = 8
      $assigned_to_field      = 'assigned_other';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = " and (da_escalate_status is null or da_escalate_status ='N') ";
    }
    else
    {
      $escalate_date          = 'escalated_date';
      $assigned_to_code_field = 'assigned_to_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code);
      $assigned_to_field      = 'assigned_to';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = null;
    }
    if(ESCALATION_ALLOW_TIME == 1)
    {
      $currDate = date('Y-m-d H:i:s');
      $lastDays = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))+(60*POPUP_INTERVAL_BEFORE_ESC_FOR_TIME));
      $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between 
                '$currDate' AND '$lastDays'  AND 
                  status=? AND final_completion_date IS NULL AND 
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status", 
                      array('P', $assigned_to_code, $assigned_to));
    }
    else
    {
      $currDate = date('Y-m-d');
      $lastDays = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.POPUP_INTERVAL_BEFORE_ESC));
      $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between               
                '$currDate' AND '$lastDays' AND 
                  status=? AND final_completion_date IS NULL AND 
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status", 
                      array('P', $assigned_to_code, $assigned_to));
    }
    //log_message('error','########POPUPQUERY############### : '.json_encode($this->db->last_query()));
    return $query;
  }

  // to be escalate list, pop up should appear
  public function popUpOfToBeEscalatedList()
  {
    if(ESCALATION_ENABLE == 1 && TO_BE_AUTO_ESCALATE_POPUP == 1)
    {
      $toBeEsc = $this->getToBeEscalateCasesFromUser();
      if(!empty($toBeEsc) && $toBeEsc != null)
      {
        return $toBeEsc;//$this->getToBeEscalateCasesFromUser();
      }
    }
  }

  // explode service type by case no
  public function explodeCaseNo($case_no)
  {
    $get_case_no = explode('/', $case_no);
    $c_no = $get_case_no['4'];
    return $c_no;
  }

  // get escalation zone
  public function getEscalationZone($case_no, $user_desig_code, $user_code)
  {
    // log_message('error','90909:'.$case_no.$user_desig_code.$user_code);
    $json = array();
    $db = $this->DataBaseSwitchModel->dharDbSwitch($this->session->userdata('dist_code')); // switch db
    
    // get detail from escalation details
    $res = $this->getEscalationDetailByCaseNo($case_no, $user_desig_code, $user_code, $db)->row();
    // var_dump($res);
    // die;
    // get escalated date field
    $escalated_date = $this->EscTableFieldsModel->getEscalatedDateToField($user_desig_code);

    // $escalated_date = $this->EscTableFieldsModel->getEscalatedDateToField($user_desig_code);
    // $escalated_date = $this->EscTableFieldsModel->getEscalatedDateToField($user_desig_code);

    if($user_desig_code == 'AST')
    {
      $escDate = $res->assigned_other_es_date;
    }
    else
    {
      $escDate = $res->escalated_date;
    }
    //log_message('error','5555555555555555555555======'.json_encode($escDate));
    if(ESCALATION_ALLOW_TIME == 1)
    {
      $curr_date      = date("Y-m-d H:i:s");
      $escalated_date = $res->$escalated_date;
    }
    else
    {
      $curr_date      = date("Y-m-d");
      $escalated_date = date('Y-m-d', strtotime($res->$escalated_date));
    }

    $target_days = $this->EscTableFieldsModel->getTargetDaysFieldName($user_desig_code);  

    
    if($escDate = null)
    {
      $remain_days = 0;
    }
    else
    {
      $remain_days = $this->Escalationmodel->dateDiff($escalated_date, $curr_date);
    }
    //log_message('error','11111111111111111111======'.json_encode($escalated_date));
    //log_message('error','22222222222222222222======'.json_encode($curr_date));
    //log_message('error','00000000000000000000======'.json_encode($remain_days));
    $percentage_availability = (100*$remain_days)/$res->$target_days;
    // log_message('error','=============********===='.json_encode($percentage_availability));

    if($percentage_availability <= RED_ZONE) {
      $esc_zone = '<i class="fa fa-circle text-red"></i>';
      $zone_color = COL_RED;
    }
    if($percentage_availability >= RED_ZONE && $percentage_availability <= YELLOW_ZONE) {
      $esc_zone = '<i class="fa fa-circle text-orange"></i>';
      $zone_color = COL_YELLOW;
    }
    if($percentage_availability >= YELLOW_ZONE) {
      $esc_zone = '<i class="fa fa-circle text-green"></i>';
      $zone_color = COL_GREEN;
    }

    $json = [
      'escalation_zone' => $esc_zone,
      'remain_days'     => $remain_days.' days left',
      'zone_color'      => $zone_color,
      'escalation_date' => $escalated_date,
    ];
    return $json;
  }


  // get list of to be escalated list from user
  public function getToBeEscalateCasesFromUser()
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $response = array();
    // var_dump($user_desig_code);

    if($user_desig_code == 'AST') // assistant
    { 
      $escalate_date          = 'assigned_other_es_date';
      // $assigned_to_code_field = 'assignment_type_other';
      $assigned_to_code_field = 'assigned_other_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code); // code = 8
      $assigned_to_field      = 'assigned_other';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = " and (da_escalate_status is null or da_escalate_status ='N') ";
    }
    else
    {
      $escalate_date          = 'escalated_date';
      $assigned_to_code_field = 'assigned_to_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code);
      $assigned_to_field      = 'assigned_to';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = null;
    }
    if(ESCALATION_ALLOW_TIME == 1)
    {
      $currDate = date('Y-m-d H:i:s');
      $lastDays = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))+(60*POPUP_INTERVAL_BEFORE_ESC_FOR_TIME));

      $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between 
                '$currDate' AND '$lastDays'  AND 
                  status=? AND out_of_esc_status='n' AND final_completion_date IS NULL AND 
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status", 
                      array('P', $assigned_to_code, $assigned_to));
      $resultData = $query->result();
      if(!empty($resultData))
      {
        $response = $this->locationWisePendingCases($resultData, $user_desig_code);
      }
      
    }
    else
    {
      $currDate = date('Y-m-d');
      $lastDays = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.POPUP_INTERVAL_BEFORE_ESC));
      // $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between               
      //           '$currDate' AND '$lastDays' AND 
      //             status=? AND final_completion_date IS NULL AND 
      //               $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status", 
      //                 array('P', $assigned_to_code, $assigned_to));


      if($user_desig_code == 'AST')
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                  between
                '$currDate' AND '$lastDays' AND
                  status=? AND out_of_esc_status='n' AND final_completion_date IS NULL AND
                   assigned_other_code=? $da_escalate_status",
                      array('P', 8));
      }
      else if($user_desig_code == 'DC') // reclass n ACPP only
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                    between '$currDate' AND '$lastDays' AND
                      status=? AND out_of_esc_status = 'n' AND final_completion_date IS NULL AND
                        $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status AND
                          service_code IN (4,5)",
                            array('P', $assigned_to_code, $assigned_to));
        // echo $this->db->last_query();
      }
      else
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                  between
                '$currDate' AND '$lastDays' AND
                  status=? AND out_of_esc_status = 'n' AND final_completion_date IS NULL AND
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status",
                      array('P', $assigned_to_code, $assigned_to));
      }

      $resultData = $query->result();
      if(!empty($resultData))
      {
        $response = $this->locationWisePendingCases($resultData, $user_desig_code);
      }
    }
    //log_message('error','########POPUPQUERY############### : '.json_encode($this->db->last_query()));
    return $response;
  }

  // get list of escalated cases location wise
  // protected function locationWisePendingCases($result, $user_desig_code) 
  // {
  //   if(!empty($result))
  //   {
  //     foreach($result as $res)
  //     {
  //       $stype = $this->explodeCaseNo($res->case_no);
  //       $table = $this->Escalationmodel->getTableNameByServiceTypeForBlock($stype);

  //       if($user_desig_code == 'AST' || $user_desig_code == 'CO')
  //       {
  //         $joinCondition = " ON t.dist_code = lt.dist_code AND t.subdiv_code=lt.subdiv_code AND t.cir_code=lt.cir_code";
  //       }
  //       if($user_desig_code == 'LM')
  //       {
  //         $joinCondition = " ON t.dist_code = lt.dist_code AND t.subdiv_code=lt.subdiv_code AND t.cir_code=lt.cir_code AND t.mouza_pargona_code=lt.mouza_pargona_code AND t.lot_no=lt.lot_no";
  //       }

  //       $query = $this->db->query("SELECT es.* FROM escalation_details es JOIN loginuser_table lt
  //                 ON es.assigned_to=lt.user_code JOIN $table t $joinCondition
  //                   WHERE es.case_no=? AND es.assigned_to=? AND lt.dis_enb_option=?",
  //                     array($res->case_no, $res->assigned_to, 'E'));
  //       if($query->num_rows() == 0)
  //       {
  //         unset($result[$res]);
  //       }
  //     }
  //   }
       
  //   return $result;
  // }

  protected function locationWisePendingCasesOld($result, $user_desig_code) 
  {
    if(!empty($result))
    {
      foreach($result as $res)
      {
        $stype = $this->explodeCaseNo($res->case_no);
        $table = $this->Escalationmodel->getTableNameByServiceTypeForBlock($stype);

        if($user_desig_code == 'AST' || $user_desig_code == 'CO')
        {
        $joinCondition = " ON t.dist_code = lt.dist_code AND t.subdiv_code=lt.subdiv_code AND t.cir_code=lt.cir_code";
        }
        if($user_desig_code == 'LM')
        {
        $joinCondition = " ON t.dist_code = lt.dist_code AND t.subdiv_code=lt.subdiv_code AND t.cir_code=lt.cir_code AND t.mouza_pargona_code=lt.mouza_pargona_code AND t.lot_no=lt.lot_no";
        }
        if($user_desig_code == 'ADC')
        {
        $joinCondition = " ON t.dist_code = lt.dist_code AND t.subdiv_code=lt.subdiv_code";
        }
        if($user_desig_code == 'DC')
        {
        $joinCondition = " ON t.dist_code = lt.dist_code";
        }

        if($user_desig_code == 'AST')
        {
          $query = $this->db->query("SELECT distinct on (es.case_no) es.* FROM (Select * from escalation_details where petition_no in (Select petition_no  from $table t where t.dist_code= and t.subdiv_code='01' and t.cir_code='01'))es JOIN
              (Select * from loginuser_table where dist_code='18' and subdiv_code='01' and cir_code='01' and user_code like 'AS%' and dis_enb_option='E')lt on
                    es.assigned_other=lt.user_code");
        }
        else
        {
          $query = $this->db->query("SELECT distinct on (es.case_no) es.* 
                  FROM escalation_details es JOIN loginuser_table lt
                    ON es.assigned_to=lt.user_code JOIN $table t $joinCondition
                      WHERE es.case_no=? AND es.assigned_to=? AND lt.dis_enb_option=? and es.status=?",
                       array($res->case_no, $res->assigned_to, 'E','P'));
        }

        if($query->num_rows() == 0)
        {
        unset($result[$res]);
        }
      }
    }      
    return $result;
  }


  protected function locationWisePendingCases($result, $user_desig_code)
  {
    if(!empty($result))
    {
      foreach($result as $key=> $res)
      {
        $case_no     = $res->case_no;
        $stype       = $this->explodeCaseNo($case_no);
        $table       = $this->Escalationmodel->getTableNameByServiceTypeForBlock($stype);
        $assigned_to = $res->assigned_to;

        if($table == 'misc_case_basic'){
          $petition_no = 'misc_case_petition_no';
        } else if($table == 't_reclassification'){
          $petition_no = 'proposal_no';
        } else {
          $petition_no = 'petition_no';
        }

        if($table == 'allotment_cert_basic'){
          $cir_code = 'circle_code';
        } else {
          $cir_code = 'cir_code';
        }

        if($user_desig_code == 'AST')
        {
          //log_message('error','---------USERDESIGNCODE======'.$user_desig_code);
          $dist = $this->session->userdata('dist_code');
          $sub  = $this->session->userdata('subdiv_code');
          $cir  = $this->session->userdata('cir_code');

          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                    (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                      petition_no IN (SELECT $petition_no FROM $table t WHERE t.dist_code=? AND
                        t.subdiv_code=? AND t.$cir_code=?)) es JOIN
                          (SELECT * FROM loginuser_table WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND user_code LIKE 'AS%' AND dis_enb_option=?) lt ON
                              es.assigned_other=lt.user_code",
                                array($case_no, 'P', $dist, $sub, $cir, $dist, $sub, $cir, 'E'));
        }
        if($user_desig_code == 'CO')
        {
          $dist = $this->session->userdata('dist_code');
          $sub  = $this->session->userdata('subdiv_code');
          $cir  = $this->session->userdata('cir_code');

          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                    (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                      assigned_to=? AND petition_no IN (SELECT $petition_no FROM $table t WHERE t.dist_code=? AND t.subdiv_code=? AND t.$cir_code=?)) es JOIN
                          (SELECT * FROM loginuser_table WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND user_code LIKE 'CO%' AND dis_enb_option=?) lt ON
                              es.assigned_to=lt.user_code",
                                array($case_no, 'P', $assigned_to, $dist, $sub, $cir,
                                  $dist, $sub, $cir, 'E'));
        }
        if($user_desig_code == 'LM')
        {
          $dist  = $this->session->userdata('dist_code');
          $sub   = $this->session->userdata('subdiv_code');
          $cir   = $this->session->userdata('cir_code');
          $mouza = $this->session->userdata('mouza_pargona_code');
          $lot   = $this->session->userdata('lot_no');

          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                    (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                      assigned_to=? AND petition_no IN (SELECT $petition_no FROM $table t WHERE t.dist_code=? AND t.subdiv_code=? AND t.$cir_code=? AND
                          t.mouza_pargona_code=? AND t.lot_no=?)) es JOIN
                            (SELECT * FROM loginuser_table WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND user_code
                                LIKE 'M%' AND dis_enb_option=?) lt ON
                                  es.assigned_to=lt.user_code",
                                    array($case_no, 'P', $assigned_to, $dist, $sub, $cir, $mouza, $lot, $dist, $sub, $cir, $mouza, $lot, 'E'));
        }
        if($user_desig_code == 'SK')
        {
          $dist = $this->session->userdata('dist_code');
          $sub  = $this->session->userdata('subdiv_code');
          $cir  = $this->session->userdata('cir_code');

          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                    (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                      assigned_to=? AND petition_no IN (SELECT $petition_no FROM $table t WHERE t.dist_code=? AND t.subdiv_code=? AND t.$cir_code=?)) es JOIN
                          (SELECT * FROM loginuser_table WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND user_code LIKE 'SK%' AND dis_enb_option=?) lt ON
                              es.assigned_to=lt.user_code",
                                array($case_no, 'P', $assigned_to, $dist, $sub, $cir,
                                  $dist, $sub, $cir, 'E'));
        }
        if($user_desig_code == 'ADC')
        {
          $dist  = $this->session->userdata('dist_code');
          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                    (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                      assigned_to=? AND petition_no IN (SELECT $petition_no FROM $table t WHERE t.dist_code=?)) es JOIN (SELECT * FROM loginuser_table WHERE dist_code=?
                          AND user_code LIKE 'ADC%' AND dis_enb_option=?) lt ON es.assigned_to=lt.user_code", array($case_no, 'P', $assigned_to, $dist, $dist, 'E'));
        }
        if($user_desig_code == 'DC')
        {
          $dist  = $this->session->userdata('dist_code');
          $query = $this->db->query("SELECT DISTINCT ON (es.case_no) es.* FROM
                      (SELECT * FROM escalation_details WHERE case_no=? AND status=? AND
                        assigned_to=? AND petition_no IN (SELECT $petition_no FROM $table t WHERE
                          t.dist_code=?)) es JOIN (SELECT * FROM loginuser_table WHERE dist_code=?
                            AND user_code LIKE 'DC%' AND dis_enb_option=?) lt ON es.assigned_to=lt.user_code", array($case_no, 'P', $assigned_to, $dist, $dist, 'E'));
        }
        // log_message("error","POPUPFILTERQUERY========".json_encode($this->db->last_query()));
        if($query->num_rows() == 0)
        {
          unset($result[$key]);
        }
      }
    }
    return $result;
  }


  public function getToBeEscalateCasesFromUserPagination($limit, $start)
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $response = array();
    // var_dump($user_desig_code);

    if($user_desig_code == 'AST') // assistant
    { 
      $escalate_date          = 'assigned_other_es_date';
      // $assigned_to_code_field = 'assignment_type_other';
      $assigned_to_code_field = 'assigned_other_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code); // code = 8
      $assigned_to_field      = 'assigned_other';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = " and (da_escalate_status is null or da_escalate_status ='N') ";
    }
    else
    {
      $escalate_date          = 'escalated_date';
      $assigned_to_code_field = 'assigned_to_code';
      $assigned_to_code       = $this->EscTableFieldsModel->getUserCode($user_desig_code);
      $assigned_to_field      = 'assigned_to';
      $assigned_to            = $this->session->userdata('user_code');
      $da_escalate_status     = null;
    }
    if(ESCALATION_ALLOW_TIME == 1)
    {
      $currDate = date('Y-m-d H:i:s');
      $lastDays = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))+(60*POPUP_INTERVAL_BEFORE_ESC_FOR_TIME));

      $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between 
                '$currDate' AND '$lastDays'  AND 
                  status=? AND out_of_esc_status='n' AND final_completion_date IS NULL AND 
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status offset $start limit $limit", 
                      array('P', $assigned_to_code, $assigned_to));
      $resultData = $query->result();
      if(!empty($resultData))
      {
        $response = $this->locationWisePendingCases($resultData, $user_desig_code);
      }
      
    }
    else
    {
      $currDate = date('Y-m-d');
      $lastDays = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.POPUP_INTERVAL_BEFORE_ESC));
      // $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date between               
      //           '$currDate' AND '$lastDays' AND 
      //             status=? AND final_completion_date IS NULL AND 
      //               $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status", 
      //                 array('P', $assigned_to_code, $assigned_to));


      if($user_desig_code == 'AST')
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                  between
                '$currDate' AND '$lastDays' AND
                  status=? AND out_of_esc_status='n' AND final_completion_date IS NULL AND
                   assigned_other_code=? $da_escalate_status offset $start limit $limit",
                      array('P', 8));
      }
      else if($user_desig_code == 'DC') // reclass n ACPP only
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                    between '$currDate' AND '$lastDays' AND
                      status=? AND out_of_esc_status = 'n' AND final_completion_date IS NULL AND
                        $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status AND
                          service_code IN (4,5) offset $start limit $limit",
                            array('P', $assigned_to_code, $assigned_to));
        // echo $this->db->last_query();
      }
      else
      {
        $query = $this->db->query("SELECT * FROM escalation_details WHERE $escalate_date
                  between
                '$currDate' AND '$lastDays' AND
                  status=? AND out_of_esc_status = 'n' AND final_completion_date IS NULL AND
                    $assigned_to_code_field=? AND $assigned_to_field=? $da_escalate_status
                     offset $start limit $limit",
                      array('P', $assigned_to_code, $assigned_to));
      }

      $resultData = $query->result();
      if(!empty($resultData))
      {
        $response = $this->locationWisePendingCases($resultData, $user_desig_code);
      }
    }
    //log_message('error','########POPUPQUERY############### : '.json_encode($this->db->last_query()));
    return $response;
  }






}
?>