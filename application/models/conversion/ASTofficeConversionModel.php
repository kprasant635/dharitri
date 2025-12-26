<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ASTofficeConversionModel extends CI_Model{
    //$db=  $this->session->userdata('db');
    public function getPendingNoticeGeneratedAST($user_code){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where not_fresh = 'Y'  and notice_generated_yn is null and status = 'P'  and "
                . "mut_type = '01' and user_code like 'AS%' and date_entry >= '$define_date' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1 order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingNoticeGeneratedAST($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01'"
        //         . " and notice_generated_yn is not null and status = 'P' and date_entry >= '$define_date' and "
        //         . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code like '%AS%' and mut_type = '01'"
        . " and notice_generated_yn is not null and status = 'P' and date_entry >= '$define_date' and "
        . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1")->row()->c;
    }
    
    public function getPendingActionTakenAST($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and mut_type = '01' and proceeding_yn is null and"
                . " status = 'P' and user_code like '%AS%' and date_entry >= '$define_date' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1 order by petition_no ASC";
        $cases = $this->db->query($q);
        log_message('error',"sq1-------------".$this->db->last_query());
        return $cases;
    }
    
    public function countPendingActionTakenAST($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01' and "
        //         . "proceeding_yn is null and status = 'P' and date_entry >= '$define_date' "
        //         . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and mut_type = '01' and "
        . "proceeding_yn is null and status = 'P' and date_entry >= '$define_date' "
        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1")->row()->c;
    }
    
    public function getPendingPremiumAST($user_code){
		    $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y'"
                . "  and date_entry >= '$define_date' and co_order_conv_notice is not null and dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1 and user_code like 'AS%' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingPremiumAST($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01' and status = 'P' and "
        //         . "co_order_conv_premium = 'Y' and date_entry >= '$define_date' and "
        //         . "co_order_conv_notice is not null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and mut_type = '01' and status = 'P' and "
        . "co_order_conv_premium = 'Y' and date_entry >= '$define_date' and "
        . "co_order_conv_notice is not null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1")->row()->c;
    }
    
    public function getPendingPaymentAST($user_code){
		    $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and status = 'P' and mut_type='01'  and co_order_conv_premium = 'Y' "
        //         . "and date_entry >= '$define_date' and dist_code='$dist_code' and "
        //         . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code = '$user_code' order by petition_no ASC";
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and status = 'P' and mut_type='01'  and co_order_conv_premium = 'Y' and user_code like '%AS%' "
                . "and date_entry >= '$define_date' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1 order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingPaymentAST($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and mut_type='01' and user_code = '$user_code' and status = 'P' "
        //         . "and date_entry >= '$define_date' and co_order_conv_premium = 'Y' and "
        //         . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and mut_type='01' and status = 'P' and user_code like '%AS%' "
                . "and date_entry >= '$define_date' and co_order_conv_premium = 'Y' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3!=1")->row()->c;
    }
    
    public function getRelationName($relation_code){
		$db=  $this->session->userdata('db');
        $relation_name = $this->db->query("select guard_rel_desc_as as rel_name from   master_guard_rel where guard_rel = '$relation_code'");
        return $relation_name->row()->rel_name;
    }
            
    public function get_rec_auth_users($controller_name,$method){
        $db=  $this->session->userdata('db');
        $code = $this->db->query("select user_desig_code from   user_permission where controller_name = '$controller_name' and function_name = '$method'")->result();
        //$count = sizeof($code);
        return $code;
    }
    
    public function getPendingActionTakenBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and mut_type = '01' and user_code = '$user_code' and proceeding_yn is null and"
                . " status = 'P' and date_entry >= '$define_date' and "
                . "dist_code='$dist_code' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingActionTakenBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01' and "
                . "proceeding_yn is null and status = 'P' and date_entry >= '$define_date' "
                . "and dist_code='$dist_code'")->row()->c;
    }
    
    public function getPendingPremiumBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where is_mb3!=1 and not_fresh = 'Y' and status = 'P' and mut_type = '01' and user_code = '$user_code' and co_order_conv_premium = 'Y'"
                . "  and date_entry >= '$define_date' and co_order_conv_notice is not null and dist_code='$dist_code' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingPremiumBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where is_mb3!=1 and not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01' and status = 'P' and "
                . "co_order_conv_premium = 'Y' and date_entry >= '$define_date' and "
                . "co_order_conv_notice is not null and dist_code='$dist_code'")->row()->c;
    }
    
    public function getPendingPaymentBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where is_mb3!=1 and not_fresh = 'Y' and status = 'P' and mut_type='01' and user_code = '$user_code' and co_order_conv_premium = 'Y' "
                . "and date_entry >= '$define_date' and dist_code='$dist_code' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingPaymentBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where is_mb3!=1 and not_fresh = 'Y' and mut_type='01' and user_code = '$user_code' and status = 'P' "
                . "and date_entry >= '$define_date' and co_order_conv_premium = 'Y' and "
                . "dist_code='$dist_code'")->row()->c;
    }
    
    public function getPendingReportBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where is_mb3!=1 and user_code = '$user_code' and bo_note_yn is null and "
                . "mut_type = '01' and date_entry >= '$define_date' and dist_code='$dist_code' and status = 'P' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }
    
    public function countPendingReportBO($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where is_mb3!=1 and user_code = '$user_code' and bo_note_yn is null and "
                . "mut_type = '01' and date_entry >= '$define_date' and dist_code='$dist_code' and status = 'P'")->row()->c;
    }

    public function countPendingNoticeGeneratedASTMb3($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        // return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and user_code = '$user_code' and mut_type = '01'"
        //         . " and notice_generated_yn is not null and status = 'P' and date_entry >= '$define_date' and "
        //         . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
   
        return $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "notice_generated_yn='Y' and notice_served_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3=1")->row()->c;
    }

    public function getPendingNoticeGeneratedASTMb3($user_code){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where not_fresh = 'Y'  and notice_generated_yn='Y' and status = 'P'  and "
                . "mut_type = '01' and notice_served_yn is null and is_mb3=1 and date_entry >= '$define_date' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' order by petition_no ASC";

        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingActionTakenASTMb3($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;

        return $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and mut_type = '01' and "
        . "proceeding_yn is null and status = 'P' and notice_served_yn='Y' and is_mb3=1 and (new_status='COLM1' or new_status='LMLRS' or new_status='LRSCO') and date_entry >= '$define_date' "
        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
    }

    public function getPendingActionTakenASTMb3($user_code){
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no=year_no;
        $define_date=define_date;
        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where not_fresh = 'Y' and mut_type = '01' and proceeding_yn is null and"
                . " status = 'P' and notice_served_yn='Y' and is_mb3=1 and (new_status='COLM1' or new_status='LMLRS' or new_status='LRSCO') and date_entry >= '$define_date' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' order by petition_no ASC";
        $cases = $this->db->query($q);
        log_message('error',"sq1-------------".$this->db->last_query());
        return $cases;
    }
    
}



