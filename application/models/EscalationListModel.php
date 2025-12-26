<?php
class EscalationListModel extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->load->model('AutoEscalationmodel');
  }

  // get all escalated pending cases to whom cases are pening
  public function getAllEscalatedPendingCases() 
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $curr_date       = date('Y-m-d');

    $query = $this->db->query("SELECT * FROM escalation_details WHERE assigned_to=? AND status=?
                AND escalated_date < ? AND final_completion_date IS NULL", 
                  array($user_code, 'P', $curr_date));
    return $query;
  }

  public function getPendingOfficerAST($d, $s, $c, $desig_code)
    {
        $sql = "select lt.user_code from loginuser_table lt join users u on lt.dist_code=u.dist_code
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E'
            and u.user_desig_code = '$desig_code' and lt.dist_code='$d'
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);
        log_message('error','Ast list========'.$this->db->last_query());
        return $data->result();
    }

  public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

  public function getPendingEscalationCountFromAST($stype, $from_user, $to_user)
  {
    // echo "hi";die;
    $where_in_ast = array();
    $desig_code = $from_user;
    $user_code = $this->session->userdata('user_code');
    $from_user = $this->getUserCodeByDesigCode($from_user);
    $to_user   = $this->getUserCodeByDesigCode($to_user);
    $ast_array = $this->getPendingOfficerAST($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $desig_code);
    foreach ($ast_array as $key => $value) {
      $where_in_ast[] = $value->user_code;
    }

    $ast_in = $this->convertLiteral($where_in_ast);


    // get field name to check escalate status
    $esc_field_status = $this->AutoEscalationmodel->checkEscalatedStatus($from_user);
    $upper_officer_escalate_field = '';
    $queryCont = '';
    // if($esc_field_status == 'da_escalate_status')
    // {
    //   $upper_officer_escalate_field = 'co_escalate_status';
    //   $queryCont = " AND ($upper_officer_escalate_field ='N' or $upper_officer_escalate_field is null) ";
    // }

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $curr_date = date('Y-m-d H:i:s');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE assigned_other in ($ast_in)  and assigned_other_code=? and status=? AND final_completion_date IS NULL AND da_escalate_status=? AND case_no LIKE '%".$stype."'", 
                array(8, 'P', 'Y'));
      log_message('error','=========$esc_field_status==='.json_encode($this->db->last_query()));
      // echo $this->db->last_query(); die;
      return $query;
    }
    else
    {
      $curr_date = date('Y-m-d');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE assigned_other in ($ast_in)  and assigned_other_code=? and status=? AND final_completion_date IS NULL AND da_escalate_status=? AND case_no LIKE '%".$stype."'", 
                array(8, 'P', 'Y'));
      log_message('error','=========$esc_field_status==='.json_encode($this->db->last_query()));
      // echo $this->db->last_query(); die;
      return $query;
      // $query = $this->db->query("SELECT * FROM escalation_details WHERE 
      //           assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
      //           $queryCont
      //            AND final_completion_date IS NULL 
      //           AND $esc_field_status=? AND case_no LIKE '%".$stype."'", 
      //           array($user_code, $to_user, $from_user, 'P', 'Y'));
      // // echo $this->db->last_query();die;
      // return $query;
    }   
  }

  public function getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, $to_user)
  {
    $user_code = $this->session->userdata('user_code');
    $from_user = $this->getUserCodeByDesigCode($from_user);
    $to_user   = $this->getUserCodeByDesigCode($to_user);

    // var_dump($from_user); 
    // var_dump($to_user); die;

    // get field name to check escalate status
    $esc_field_status = $this->AutoEscalationmodel->checkEscalatedStatus($from_user);
    $upper_officer_escalate_field = '';
    $queryCont = '';
    if($esc_field_status == 'lm_escalate_status' || $esc_field_status == 'sk_escalate_status' || $esc_field_status == 'da_escalate_status')
    {
      $upper_officer_escalate_field = 'co_escalate_status';
      $queryCont = " AND ($upper_officer_escalate_field ='N' or $upper_officer_escalate_field is null) ";
    }
    else if($esc_field_status == 'adc_escalate_status' || $esc_field_status == 'co_escalate_status' || $esc_field_status == 'bo_escalate_status')
    {
      $upper_officer_escalate_field = 'dc_escalate_status';
      $queryCont = " AND ($upper_officer_escalate_field ='N' or $upper_officer_escalate_field is null) ";
    }
    if($stype == MIND_SERV || $stype == MINC_SERV)
    {
      $stype1 = MINC_SERV;
      $stype = "(case_no like '%".$stype."' or case_no like '%".$stype1."')";
    }
    else
    {
      $stype = " case_no like '%".$stype."'";
    }

    if(ESCALATION_ALLOW_TIME == 1)
    {

      $curr_date = date('Y-m-d H:i:s');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE 
                assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=? 
                AND final_completion_date IS NULL 
                $queryCont
                AND $esc_field_status=? AND $stype", 
                array($user_code, $to_user, $from_user, 'P', 'Y'));
      // log_message('error','=========AUTOPOPULATECASEQUERY==='.json_encode($this->db->last_query()));
      // echo $this->db->last_query(); die;
      return $query;
    }
    else
    {
      $curr_date = date('Y-m-d');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE 
                assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
                $queryCont
                 AND final_completion_date IS NULL 
                AND $esc_field_status=? AND $stype", 
                array($user_code, $to_user, $from_user, 'P', 'Y'));
      // echo $this->db->last_query();die;
      // log_message('error','=========AUTOPOPULATECASEQUERY==='.json_encode($this->db->last_query()));
      return $query;
    }      
  }

  // from lm to co
  public function getEscalationFromLmToCo($stype) 
  {
    // 6: CO; 9: LM
    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $curr_date       = date('Y-m-d');

    $query = $this->db->query("SELECT * FROM escalation_details WHERE 
              assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
              AND escalated_date < ? AND final_completion_date IS NULL 
              AND case_no LIKE '%".$stype."' ", array($user_code, 6, 9, 'P', $curr_date));
    return $query;
  }

  // from sk to co
  public function getEscalationFromSkToCo($stype)
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $curr_date       = date('Y-m-d');

    $query = $this->db->query("SELECT * FROM escalation_details WHERE 
              assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
              AND escalated_date < ? AND final_completion_date IS NULL 
              AND case_no LIKE '%".$stype."'", array($user_code, 6, 7, 'P', $curr_date, $stype));
    return $query;
  }

  // from ast to co
  public function getEscalationFromAstToCo($stype)
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $curr_date       = date('Y-m-d');

    $query = $this->db->query("SELECT * FROM escalation_details WHERE 
              assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
              AND escalated_date < ? AND final_completion_date IS NULL 
              AND case_no LIKE '%".$stype."'", array($user_code, 6, 8, 'P', $curr_date, $stype));
    return $query;
  }

  // get detail from master basic table service wise
  public function getFromMasterBasicTable($stype, $case){
    $table = $this->getTableNameByServiceType($stype);
    log_message('error','============*********_+=========='.$stype);
    if($table == 'misc_case_basic')
    {
      if($stype == MIND_SERV || $stype == MINC_SERV)
      {
        $stype1 = MINC_SERV;
        $stype = "(misc_case_no like '%".$stype."' or misc_case_no like '%".$stype1."')";
      }
      else
      {
        $stype = " misc_case_no like '%".$stype."'";
      }
      log_message('error','999999999'.$stype);
      $param = " misc_case_no=? AND ".$stype;
    }
    else {
      $param = " case_no=? AND case_no LIKE '%".$stype."%' ";
    }
    $query = $this->db->query("SELECT * FROM $table WHERE $param", array($case));
    log_message('error','============*********_+==========11'.$this->db->last_query());
    return $query;
  }


  // get detail from petition_basic
  public function getFromPetitionBasicByCaseNo($case){
    $query = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?", array($case));
    return $query;
  }

  // get detail from basundhar_application
  public function getFromBasundharApplByCaseNo($case){
    $query = $this->db->query("SELECT basundhara FROM basundhar_application WHERE dharitree=?", array($case));
    if($query->num_rows() == 0){
      return null;
    }
    else {
      return $query->row()->basundhara;
    }
  }

  // get detail from misc_case_basic
  public function getFromMiscCaseBasicByCaseNo($case){
    $query = $this->db->query("SELECT * FROM misc_case_basic WHERE misc_case_no=?", array($case));
    return $query;
  }

  // get detail from field_mut_basic
  public function getFromFieldMutBasicByCaseNo($case){
    $query = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=?", array($case));
    return $query;
  }

  // get detail from legacy correction
  public function getFromLegacyCorrectionByCaseNo($case){
    $query = $this->db->query("SELECT * FROM legacy_correction WHERE case_no=?", array($case));
    return $query;
  }

  // get detail from reclassification
  public function getFromReclassificationByCaseNo($case){
    $query = $this->db->query("SELECT * FROM t_reclassification WHERE case_no=?", array($case));
    return $query;
  }

  // go back button as per user
  public function goBackButtonByUser($service_type, $user_desig_code)
  {
    $back_to_main_menu = '';

    // LM ---------
    if($service_type == OMUT && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/MutationLmOM';
    }
    else if($service_type == OPART && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/PartitionLmOP';
    }
    else if(($service_type == FMUT || $service_type == FPART) && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/MutationLm';
    }
    else if(($service_type == CONV_SERV) && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/ConversionLm';
    }
    else if(($service_type == RECLASS_SERV) && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/LandReLm';
    }
    else if(($service_type == ALLOT_SERV) && $user_desig_code == 'LM'){
      $back_to_main_menu = base_url().'index.php/Home/AcPPLm';
    }
    

    // CO -------------
    else if($service_type == OMUT && $user_desig_code == 'CO'){
      $back_to_main_menu = base_url().'index.php/Home/MutationCoOM';
    }
    
    else if($service_type == FMUT && $user_desig_code == 'CO'){
      $back_to_main_menu = base_url().'index.php/Home/MutationCo';
    }

    return $back_to_main_menu;
  }

  public function getTitleOfServices($service_type)
  {
    $title = '';
    if ($service_type == OMUT) {
      $title = "Office Mutation Escalated List";
    }
    else if ($service_type == FMUT) {
      $title = "Field Mutation Escalated List";
    }
    else if ($service_type == OPART) {
      $title = "Office Partition Escalated List";
    }
    else if ($service_type == FPART) {
      $title = "Field Partition Escalated List";
    }
    else if ($service_type == RECLASS_SERV) {
      $title = "Reclassification Escalated List";
    }
    else if ($service_type == ALLOT_SERV) {
      $title = "Allotment Certificate Escalated List";
    }
    else if ($service_type == CONV_SERV) {
      $title = "Conversion Escalated List";
    }
    else if ($service_type == LEGACY_SERV) {
      $title = "Legacy Updation Escalated List";
    }
    else if ($service_type == MIND_SERV) {
      $title = "Name Cancellation Escalated List";
    }
    else if ($service_type == ANCOR_SERV) {
      $title = "Area Name Correction Escalated List";
    }
    else if ($service_type == MCOR_SERV) {
      $title = "Mobile Updation Escalated List";
    }
    else if ($service_type == MINC_SERV) {
      $title = "Name Correction Escalated List";
    }
    return $title;
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



  public function getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, $to_user)
  {
    $user_code = $this->session->userdata('user_code');
    $from_user = $this->getUserCodeByDesigCode($from_user);
    $to_user   = $this->getUserCodeByDesigCode($to_user);

    // get field name to check escalate status
    $esc_field_status = $this->AutoEscalationmodel->checkEscalatedStatus($from_user);
    $upper_officer_escalate_field = '';
    $queryCont = '';
    $queryLowerOfficerEscStatus = '';
    if($esc_field_status == 'lm_escalate_status' || $esc_field_status == 'sk_escalate_status' || $esc_field_status == 'da_escalate_status')
    {
      // $queryLowerOfficerEscStatus = " AND (lm_escalate_status='Y' or sk_escalate_status='Y' or da_escalate_status='Y')";

      $upper_officer_escalate_field = 'co_escalate_status';
      $queryCont = " AND ($upper_officer_escalate_field ='N' or $upper_officer_escalate_field is null) ";
    }
    else if($esc_field_status == 'adc_escalate_status' || $esc_field_status == 'co_escalate_status' || $esc_field_status == 'bo_escalate_status')
    {

      // $queryLowerOfficerEscStatus = " AND (adc_escalate_status='Y' or co_escalate_status='Y' or bo_escalate_status='Y')";

      $upper_officer_escalate_field = 'dc_escalate_status';
      $queryCont = " AND ($upper_officer_escalate_field ='N' or $upper_officer_escalate_field is null) ";
    }

    if(ESCALATION_ALLOW_TIME == 1)
    {
      $curr_date = date('Y-m-d H:i:s');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE 
                assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=? 
                AND final_completion_date IS NULL 
                $queryCont AND $esc_field_status=? AND deescalation_status IS NULL 
                AND case_no LIKE '%".$stype."'", 
                array($user_code, $to_user, $from_user, 'P', 'N'));
      log_message('error','=========$esc_field_status==='.json_encode($this->db->last_query()));
      return $query;
    }
    else
    {
      $curr_date = date('Y-m-d');
      $query = $this->db->query("SELECT * FROM escalation_details WHERE 
                assigned_to=? AND assigned_to_code=? AND assigned_from_code=? AND status=?
                $queryCont AND final_completion_date IS NULL 
                AND $esc_field_status=? AND deescalation_status  IS NULL
                AND case_no LIKE '%".$stype."'",  
                array($user_code, $to_user, $from_user, 'P', 'N'));
      // echo $this->db->last_query();die;
      return $query;
    }      
  }

}
?>