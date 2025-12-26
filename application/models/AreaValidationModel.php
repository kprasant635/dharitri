<?php
class AreaValidationModel extends CI_Model {
  
  public function __construct() 
  {
    parent::__construct();
  }

  // get from settlement basic
  protected function getFromBasic($case_no)
  {
    return $query = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no))->row();
  }

  // get from settlement dag details
  protected function getFromDagDetails($case_no)
  {
    return $getAppliedArea = $this->db->query("SELECT 
                        COALESCE(SUM(home_b), 0) AS home_bigha,
                        COALESCE(SUM(home_k), 0) AS home_katha,
                        COALESCE(SUM(home_lc), 0) AS home_lessa,
                        COALESCE(SUM(home_g), 0) AS home_ganda,

                        COALESCE(SUM(agri_b), 0) AS agri_bigha,
                        COALESCE(SUM(agri_k), 0) AS agri_katha, 
                        COALESCE(SUM(agri_lc), 0) AS agri_lessa,
                        COALESCE(SUM(agri_g), 0) AS agri_ganda,

                        COALESCE(SUM(applied_b), 0) AS tea_bigha,
                        COALESCE(SUM(applied_k), 0) AS tea_katha,
                        COALESCE(SUM(applied_lc), 0) AS tea_lessa,
                        COALESCE(SUM(applied_g), 0) AS tea_ganda

                        FROM settlement_dag_details WHERE case_no=?", array($case_no))->row();
  }


  public function areaValidation($case_no)
  {
    $getFromSettPrem = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? AND is_final=?", array($case_no, 1));

    if($getFromSettPrem->num_rows() == 0){
      
      log_message("error", "AREAVALIDATIONMODEL : No detail found in settlement_premium for case no $case_no : ".$this->db->last_query());

      return json_encode(array(
        'responseType' => 3,
        'message'      => "#ERRAREAEXCEED48: Failed to forward to case to DC for case no $case_no. Kindly contact system administrator !!!",
      ));
    }

    $areaName = $getFromSettPrem->row()->area_name;

    // get dist_code from settlement basic
    $district = $this->getFromBasic($case_no)->dist_code;

    // get applied area
    $appliedArea = $this->getFromDagDetails($case_no);

    if(in_array($district, json_decode(BARAK_VALLEY))) // for barak valley
    { 
      $total_home_lessa = ($appliedArea->home_bigha * 6400) + ($appliedArea->home_katha * 320) + ($appliedArea->home_lessa * 20) + $appliedArea->home_ganda; 
      $total_agri_lessa = ($appliedArea->agri_bigha * 6400) + ($appliedArea->agri_katha * 320) + ($appliedArea->agri_lessa * 20) + $appliedArea->agri_ganda;
      $total_tea_lessa  = ($appliedArea->tea_bigha * 6400) + ($appliedArea->tea_katha * 320) + ($appliedArea->tea_lessa * 20) + $appliedArea->tea_ganda; 

      $total_lessa = $total_home_lessa + $total_agri_lessa + $total_tea_lessa;
    }
    else //other than barak valley
    { 
      $total_home_lessa = ($appliedArea->home_bigha * 100) + ($appliedArea->home_katha * 20) + $appliedArea->home_lessa;
      $total_agri_lessa = ($appliedArea->agri_bigha * 100) + ($appliedArea->agri_katha * 20) + $appliedArea->agri_lessa;
      $total_tea_lessa  = ($appliedArea->tea_bigha * 100) + ($appliedArea->tea_katha * 20) + $appliedArea->tea_lessa;

      $total_lessa = $total_home_lessa + $total_agri_lessa + $total_tea_lessa;
    }

    if($areaName == '10') // for rural area
    {
      // convert bigha to lessa
      if(in_array($district, json_decode(BARAK_VALLEY))) // for barak valley
      {
        if($total_home_lessa > 6400)
        {
          return json_encode(array(
            'responseType' => 3,
            'message'      => "#ERRAREAEXCEED86: Applied area for homestead can not be more than 1 bigha for case no $case_no. Kindly contact system administrator !!!",
          ));
        }
        if($total_agri_lessa > 7*6400)
        {
          return json_encode(array(
            'responseType' => 3,
            'message'      => "#ERRAREAEXCEED93: Applied area for agriculture can not be more than 7 bigha for case no $case_no. Kindly contact system administrator !!!",
          ));
        }
      }
      else
      {
        if($total_home_lessa > 100)
        {
          return json_encode(array(
            'responseType' => 3,
            'message'      => "#ERRAREAEXCEED103: Applied area for homestead can not be more than 1 bigha for case no $case_no. Kindly contact system administrator !!!",
          ));
        }
        if($total_agri_lessa > 7*100)
        {
          return json_encode(array(
            'responseType' => 3,
            'message'      => "#ERRAREAEXCEED110: Applied area for agriculture can not be more than 7 bigha for case no $case_no. Kindly contact system administrator !!!",
          ));
        }
      }
    }
    else // for urban areas
    {
      $max_land_allowed = $this->db->query("SELECT * FROM settlement_premium_rate WHERE paid=? LIMIT 1", array($areaName))->row()->max_land;

      if($total_lessa > $max_land_allowed)
      {
        return json_encode(array(
          'responseType' => 3,
          'message'      => "#ERRAREAEXCEED83: Applied area exceeds the limit of max allowed area for case no $case_no. Kindly contact system administrator !!!",
        ));
      }
    }
  }


}