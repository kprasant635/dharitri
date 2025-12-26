<?php

class TraceMapModel extends CI_Model {

    
    public function getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
		
        // status CO is for circle officers first proceedin for tarce map
        $sql = "select count(*) AS cnt from   trace_map where status='CO' and (not_fresh is null or not_fresh='') and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getMiscCasesAST($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        
        // status CO is for circle officers first proceedin for tarce map
      $sql = "select count(*) AS cnt from   trace_map where status='F' and (not_fresh is not null or not_fresh!='') and (certi_status!='D' or certi_status is null) and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getMiscCasesF($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        
        // status CO is for circle officers first proceedin for tarce map
        $sql = "select count(*) AS cnt from   trace_map where status='CO' and not_fresh='Y' and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }


    public function Tracemap($case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select * from   trace_map where case_no='$case_no'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function tracemapApplicant($case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select * from   trace_map_applicant where case_no='$case_no'";
        $result = $this->db->query($sql);
        return $result->result();
    }


     public function getTPCasesLM($user_code, $dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        
        // status LM is for lm's first proceedin for tarce map
        $sql = "select count(*) AS cnt from   trace_map where status='LM' and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getTPCasesLMrevert($user_code, $dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        
        // status LM is for lm's first proceedin for tarce map
        $sql = "select count(*) AS cnt from   trace_map where revert='LM' and (status is null or status='') and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

     public function getTPCasesSK($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        
        // status SK is for sk's first proceedin for tarce map
        $sql = "select count(*) AS cnt from   trace_map where status='SK' and "
                . "submission_date >= '$define_date' and  "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }


}
