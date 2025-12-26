<?php
class EscTableFieldsModel extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  // get user code
  public function getUserCode($user_desig_code)
  {

    $assignedUserCode = json_decode(USER_ALLOT_CODE);

    if($user_desig_code == 'LM')
    {
      $assignedUserCode = $assignedUserCode[8]->CODE; // code = 9
    }
    else if($user_desig_code == 'SK')
    {
      $assignedUserCode = $assignedUserCode[6]->CODE; // code = 7
    }
    else if($user_desig_code == 'CO')
    {
      $assignedUserCode = $assignedUserCode[5]->CODE; // code = 6
    }
    else if($user_desig_code == 'AST')
    {
      $assignedUserCode = $assignedUserCode[7]->CODE; // code = 8
    }
    else if($user_desig_code == 'DC')
    {
      $assignedUserCode = $assignedUserCode[1]->CODE; // code = 2
    }
    else if($user_desig_code == 'BO')
    {
      $assignedUserCode = $assignedUserCode[4]->CODE; // code = 5
    }
    else if($user_desig_code == 'ADC')
    {
      $assignedUserCode = $assignedUserCode[2]->CODE; // code = 3
    }
    else if($user_desig_code == 'SDO')
    {
      $assignedUserCode = $assignedUserCode[3]->CODE; // code = 4
    }
    else if($user_desig_code == 'DEO')
    {
      $assignedUserCode = $assignedUserCode[11]->CODE; // code = 4
    }
    else if($user_desig_code == 'TN')
    {
      $assignedUserCode = $assignedUserCode[12]->CODE; // code = 4
    }
    else if($user_desig_code == 'DCN')
    {
      $assignedUserCode = $assignedUserCode[13]->CODE; // code = 4
    }
    return $assignedUserCode;
  }


  // get a specific field names by user desig code
  public function getTargetDaysFieldName($user_desig_code)
  {
    if($user_desig_code == 'LM')
    {
      $target_days = 'lm_target_days';
    }
    else if($user_desig_code == 'CO')
    {
      $target_days = 'co_target_days';
    }
    else if($user_desig_code == 'AST')
    {
      $target_days = 'da_target_days';
    }
    else if($user_desig_code == 'SK')
    {
      $target_days = 'sk_target_days';
    }
    else if($user_desig_code == 'ADC')
    {
      $target_days = 'adc_target_days';
    }
    else if($user_desig_code == 'DC')
    {
      $target_days = 'dc_target_days';
    }
    return $target_days;
  }

  // get escalate status field by user code
  public function getEscalatedStatusByUserCode($user_desig_code)
  {
    if($user_desig_code == 'AST')
    {
      $field_esc_status = 'da_escalate_status';
    }
    else if($user_desig_code == 'SK')
    {
      $field_esc_status = 'sk_escalate_status';
    }
    else if($user_desig_code == 'LM')
    {
      $field_esc_status = 'lm_escalate_status';
    }
    else if($user_desig_code == 'CO')
    {
      $field_esc_status = 'co_escalate_status';
    }
    else if($user_desig_code == 'ADC')
    {
      $field_esc_status = 'adc_escalate_status';
    }
    else if($user_desig_code == 'DC')
    {
      $field_esc_status = 'dc_escalate_status';
    }
    else if($user_desig_code == 'BO')
    {
      $field_esc_status = 'bo_escalate_status';
    }
    else if($user_desig_code == 'DEPT')
    {
      $field_esc_status = 'dept_escalate_status';
    }
    else if($user_desig_code == 'MOUZADAR')
    {
      $field_esc_status = 'mouzadar_escalate_status';
    }
    else if($user_desig_code == 'SRO')
    {
      $field_esc_status = 'sro_escalate_status';
    }
    return $field_esc_status;
  }

  // get user code
  public function getUserCodeByDesigCode($user_desig_code)
  {
    $code = '';
    if ($user_desig_code == 'DEPT') {
      $code = 1;
    }
    else if ($user_desig_code == 'DC') {
      $code = 2;
    }
    else if ($user_desig_code == 'ADC') {
      $code = 3;
    }
    else if ($user_desig_code == 'SDO') {
      $code = 4;
    }
    else if ($user_desig_code == 'BO') {
      $code = 5;
    }
    else if ($user_desig_code == 'CO') {
      $code = 6;
    }
    else if ($user_desig_code == 'SK') {
      $code = 7;
    }
    else if ($user_desig_code == 'AST') {
      $code = 8;
    }
    else if ($user_desig_code == 'LM') {
      $code = 9;
    }
    else if ($user_desig_code == 'SRO') {
      $code = 10;
    }
    else if ($user_desig_code == 'MOUZADAR') {
      $code = 11;
    }
    return $code;
  }


  // get assigned to field
  public function getAssignedToField($user_desig_code)
  {
    if($user_desig_code == 'AST')
    {
      $assigned_to = 'assigned_other';
    }
    else
    {
      $assigned_to = 'assigned_to';
    }
    return $assigned_to;
  }


  // get escalated to field
  public function getEscalatedDateToField($user_desig_code)
  {
    if($user_desig_code == 'AST')
    {
      $esc_date = 'assigned_other_es_date';
    }
    else
    {
      $esc_date = 'escalated_date';
    }
    return $esc_date;
  }


  // get assigned to date field
  public function getAssignedToDateField($user_desig_code)
  {
    if($user_desig_code == 'AST')
    {
      $assigned_to = 'assigned_date';
    }
    else
    {
      $assigned_to = 'assigned_other_es_date';
    }
    return $assigned_to;
  }


  // get a specific field names by user desig code
  public function getAllocatedDaysFieldName($user_desig_code)
  {
    if($user_desig_code == 'LM')
    {
      $target_days = 'lm_allocate_days';
    }
    else if($user_desig_code == 'CO')
    {
      $target_days = 'co_allocate_days';
    }
    else if($user_desig_code == 'AST')
    {
      $target_days = 'da_allocate_days';
    }
    else if($user_desig_code == 'SK')
    {
      $target_days = 'sk_allocate_days';
    }
    else if($user_desig_code == 'ADC')
    {
      $target_days = 'adc_allocate_days';
    }
    else if($user_desig_code == 'DC')
    {
      $target_days = 'dc_allocate_days';
    }
    return $target_days;
  }


  // get details from escalation matrix
  public function getUserWiseTimeAllocate($cat, $esc_type, $user_type, $db)
  {
    $allocated_days = 0;

    $query = $db->query("SELECT * FROM escalation_matrix WHERE category=? AND escalation_type=? AND status=?",
              array($cat, DEESCALATE, 'y'))->row();

    if($user_type == 'AST')
    {
      $allocated_days = $query->da_allocated_days;
    }
    else if($user_type == 'LM')
    {
      $allocated_days = $query->lm_allocated_days;
    }
    else if($user_type == 'SK')
    {
      $allocated_days = $query->sk_allocated_days;
    }
    else if($user_type == 'CO')
    {
      $allocated_days = $query->co_allocated_days;
    }
    else if($user_type == 'BO')
    {
      $allocated_days = $query->bo_allocated_days;
    }
    else if($user_type == 'ADC')
    {
      $allocated_days = $query->adc_allocated_days;
    }
    else if($user_type == 'DC')
    {
      $allocated_days = $query->dc_allocated_days;
    }
    else if($user_type == 'DEPT')
    {
      $allocated_days = $query->dept_allocated_days;
    }
    else if($user_type == 'SRO')
    {
      $allocated_days = $query->sro_allocated_days;
    }
    else if($user_type == 'MOUZADAR')
    {
      $allocated_days = $query->mouzadar_allocated_days;
    }
    return $allocated_days;
  }



  // get date code field name
  public function getDateCodesFieldName($user_desig_code)
  {
    $date_code_list = null;
    if($user_desig_code == 'AST')
    {
      $date_code_list = 'da_date_code_list';
    }
    else if($user_desig_code == 'LM')
    {
      $date_code_list = 'lm_date_code_list';
    }
    else if($user_desig_code == 'SK')
    {
      $date_code_list = 'sk_date_code_list';
    }
    else if($user_desig_code == 'CO')
    {
      $date_code_list = 'co_date_code_list';
    }
    else if($user_desig_code == 'BO')
    {
      $date_code_list = 'bo_date_code_list';
    }
    else if($user_desig_code == 'ADC')
    {
      $date_code_list = 'adc_date_code_list';
    }
    else if($user_desig_code == 'DC')
    {
      $date_code_list = 'dc_date_code_list';
    }
    else if($user_desig_code == 'DEPT')
    {
      $date_code_list = 'dept_date_code_list';
    }
    else if($user_desig_code == 'SRO')
    {
      $date_code_list = 'sro_date_code_list';
    }
    else if($user_desig_code == 'MOUZADAR')
    {
      $date_code_list = 'mouzadar_date_code_list';
    }
    return $date_code_list;
  }

}