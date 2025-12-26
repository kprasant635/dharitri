<?php
class EscPercentageController extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function userAllocateDaysPercentage()
  {
    // var_dump("dfghj"); die;
    $districts = ['35','08','25','02','17','03','14','36','15','24','21','12','34','32','33','06','16','11','37','18','07','10','38','13','05','39'];

    $districts = ['07'];

    foreach($districts as $dist) 
    {
      $this->db = $this->dbswitch($dist);

      $query = $this->db->query("SELECT total_timeline, da_allocated_days, lm_allocated_days, sk_allocated_days, co_allocated_days, bo_allocated_days, adc_allocated_days, dc_allocated_days, dept_allocated_days, sro_allocated_days, mouzadar_allocated_days, escalation_type, category FROM escalation_matrix");
      // echo $this->db->last_query();

      $count = $query->num_rows();
      $update_count = 0;

      foreach($query->result() as $row)
      {
        $total_timeline  = $row->total_timeline;
        $escalation_type = $row->escalation_type;
        $category        = $row->category;

        $da_percentage       = round((($row->da_allocated_days*100)/$total_timeline), 2);
        $lm_percentage       = round((($row->lm_allocated_days*100)/$total_timeline), 2);
        $sk_percentage       = round((($row->sk_allocated_days*100)/$total_timeline), 2);
        $co_percentage       = round((($row->co_allocated_days*100)/$total_timeline), 2);
        $bo_percentage       = round((($row->bo_allocated_days*100)/$total_timeline), 2);
        $adc_percentage      = round((($row->adc_allocated_days*100)/$total_timeline), 2);
        $dc_percentage       = round((($row->dc_allocated_days*100)/$total_timeline), 2);
        $dept_percentage     = round((($row->dept_allocated_days*100)/$total_timeline), 2);
        $sro_percentage      = round((($row->sro_allocated_days*100)/$total_timeline), 2);
        $mouzadar_percentage = round((($row->mouzadar_allocated_days*100)/$total_timeline), 2);

        // update matrix table
        $update = [
          'da_allocate_perc'       => $da_percentage,
          'lm_allocate_perc'       => $lm_percentage,
          'sk_allocate_perc'       => $sk_percentage,
          'co_allocate_perc'       => $co_percentage,
          'bo_allocate_perc'       => $bo_percentage,
          'adc_allocate_perc'      => $adc_percentage,
          'dc_allocate_perc'       => $dc_percentage,
          'dept_allocate_perc'     => $dept_percentage,
          'sro_allocate_perc'      => $sro_percentage,
          'mouzadar_allocate_perc' => $mouzadar_percentage,
        ];

        $where = [
          'category'        => $category,
          'escalation_type' => $escalation_type,
        ];

        $this->db->update('escalation_matrix', $update, $where);
        if($this->db->affected_rows() != 1)
        {
          log_message('error',"#ERR288: Updation_Failed");
          echo "Updation failed";
          exit;
        }
        $update_count++;
      }
    }
    if($update_count == $count)
    {
      echo "Total number of rows updated successfully $update_count";
    }
  }

  public function dbswitch($dist_code)
  {
    if ($dist_code == "02") {
        $this->db = $this->load->database('dha3', TRUE);
    } else if ($dist_code == "05") {
        $this->db = $this->load->database('dha1', TRUE);
    } else if ($dist_code == "10") {
        $this->db = $this->load->database('dha24', TRUE);
    } else if ($dist_code == "13") {
        $this->db = $this->load->database('dha2', TRUE);
    } else if ($dist_code == "17") {
        $this->db = $this->load->database('dha4', TRUE);
    } else if ($dist_code == "15") {
        $this->db = $this->load->database('dha5', TRUE);
    } else if ($dist_code == "14") {
        $this->db = $this->load->database('dha6', TRUE);
    } else if ($dist_code == "07") {
        $this->db = $this->load->database('dha7', TRUE);
    } else if ($dist_code == "03") {
        $this->db = $this->load->database('dha8', TRUE);
    } else if ($dist_code == "18") {
        $this->db = $this->load->database('dha9', TRUE);
    } else if ($dist_code == "12") {
        $this->db = $this->load->database('dha13', TRUE);
    } else if ($dist_code == "24") {
        $this->db = $this->load->database('dha10', TRUE);
    } else if ($dist_code == "06") {
        $this->db = $this->load->database('dha11', TRUE);
    } else if ($dist_code == "11") {
        $this->db = $this->load->database('dha12', TRUE);
    } else if ($dist_code == "16") {
        $this->db = $this->load->database('dha14', TRUE);
    } else if ($dist_code == "32") {
        $this->db = $this->load->database('dha15', TRUE);
    } else if ($dist_code == "33") {
        $this->db = $this->load->database('dha16', TRUE);
    } else if ($dist_code == "34") {
        $this->db = $this->load->database('dha17', TRUE);
    } else if ($dist_code == "21") {
        $this->db = $this->load->database('dha18', TRUE);
    } else if ($dist_code == "08") {
        $this->db = $this->load->database('dha19', TRUE);
    } else if ($dist_code == "35") {
        $this->db = $this->load->database('dha20', TRUE);
    } else if ($dist_code == "36") {
        $this->db = $this->load->database('dha21', TRUE);
    } else if ($dist_code == "37") {
        $this->db = $this->load->database('dha22', TRUE);
    } else if ($dist_code == "25") {
        $this->db = $this->load->database('dha23', TRUE);
    } else if ($dist_code == "39") {
        $this->db = $this->load->database('dha39', TRUE);
    }else if ($dist_code == "auth") {
        $this->db = $this->load->database('auth', TRUE);
    }
    return $this->db;
  }


}

