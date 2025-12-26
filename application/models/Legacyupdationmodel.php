<?php

class Legacyupdationmodel extends CI_Model {


	public function getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no){
		$year_no = year_no;
		$db=  $this->session->userdata('db');
                $define_date = define_date;
                $sql = "select lc.*,ba.basundhara from   legacy_correction lc left join basundhar_application ba on lc.case_no= ba.dharitree where lc.service_type in ('A','N') and  lc.status = 'A' "
                        . "and lc.dist_code='$dist_code' and lc.subdiv_code='$subdiv_code' and lc.cir_code='$cir_code' and "
                        . " lc.mouza_pargona_code ='$mouza_pargona_code' and lc.lot_no='$lot_no' "
                        . " ORDER BY lc.date_of_reg DESC";
                $result = $this->db->query($sql);
                log_message("error",$this->db->last_query());
                return $result->result();
	}

	public function getCaseDetails($case_no, $petition_no)
	{
		$db=  $this->session->userdata('db');

    $sql = "select * from   legacy_correction where service_type in ('A','N') and  status = 'A' "
            . "and case_no =? and petition_no = ? "
            . " ORDER BY date_of_reg DESC";
    $result = $this->db->query($sql,array($case_no,$petition_no));
    log_message("error",$this->db->last_query());
    return $result->row();
	}

  public function getCaseDetailsCO($case_no, $petition_no)
  {
    $db=  $this->session->userdata('db');

    $sql = "select * from   legacy_correction where service_type in ('A','N') and  status = 'C' "
            . "and case_no =? and petition_no = ? "
            . " ORDER BY date_of_reg DESC";
    $result = $this->db->query($sql,array($case_no,$petition_no));
    log_message("error",$this->db->last_query());
    return $result->row();
  }

  public function getMiscCaseCO($dist_code, $subdiv_code, $cir_code){
    $year_no = year_no;
    $define_date = define_date;
    $sql = "select lc.*,ba.basundhara from legacy_correction lc left join basundhar_application ba on lc.case_no= ba.dharitree where lc.service_type in ('A','N') and  lc.status = ? "
            . "and lc.dist_code=? and lc.subdiv_code=? and lc.cir_code=? "
            . " ORDER BY lc.date_of_reg DESC";
    $result = $this->db->query($sql,array('C',$dist_code, $subdiv_code, $cir_code));

    return $result->result();
  }

  public function getMobileUpdationCo($dist_code, $subdiv_code, $cir_code){
    $year_no = year_no;
    $db=  $this->session->userdata('db');
    $define_date = define_date;
    $sql = "SELECT lc.*, ba.basundhara FROM legacy_correction lc LEFT JOIN basundhar_application ba ON
          lc.case_no= ba.dharitree WHERE lc.service_type=? AND  lc.status=? AND lc.dist_code=?
          AND lc.subdiv_code=? AND lc.cir_code=? ORDER BY lc.date_of_reg DESC";
    $result = $this->db->query($sql, array('M', 'A', $dist_code, $subdiv_code, $cir_code));
    log_message("error",$this->db->last_query());
    return $result->result();
  }

  public function getMobileUpdationCaseDetails($case_no, $petition_no){
    $db=  $this->session->userdata('db');
    $sql = "SELECT * FROM legacy_correction WHERE service_type=? AND  status=? AND case_no =? AND
              petition_no=? ORDER BY date_of_reg DESC";
    $result = $this->db->query($sql,array('M','A',$case_no,$petition_no));
    log_message("error",$this->db->last_query());
    return $result->row();
  }
}
?>