<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SKofficeConversionModel extends CI_Model{
    
    public function getPendingConversionCasesSK(){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and "
                . "mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and date_entry >= '$define_date' and is_mb3!=1 order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingConversionCasesSK(){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and lm_note_yn = 'Y' and status = 'P' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry >= '$define_date' "
                . "and sk_comment is null and mut_type='01' and is_mb3!=1")->row()->c;
    }

    public function countPendingConversionCasesSKMb3(){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and lm_note_yn = 'Y' and status = 'P' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry >= '$define_date' "
                . "and sk_comment is null and mut_type='01' and is_mb3=1")->row()->c;
    }

    public function getPendingConversionCasesSKMb3(){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and "
                . "mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and date_entry >= '$define_date' and is_mb3=1 order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
}

