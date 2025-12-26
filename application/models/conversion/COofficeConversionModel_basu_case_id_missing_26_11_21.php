<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class COofficeConversionModel extends CI_Model {
//$db=  $this->session->userdata('db');
    public function getPendingConversionFreshCases($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where fmb.not_fresh is null and fmb.lm_note_yn is null and fmb.mut_type='01' and fmb.co_user_code = '$dsg' and fmb.date_entry >= '$define_date' "
                . "and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code' and (fmb.status is null or fmb.status = 'P') order by fmb.petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionFreshCases($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh is null and lm_note_yn is null and mut_type='01' and co_user_code = '$dsg' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status is null or status = 'P') ")->row()->c;
    }

    public function getPendingConversionSecondCases($dsg) {
	$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.not_fresh = 'Y' and fmb.status = 'P' and fmb.mut_type='01' and fmb.co_user_code = '$dsg'  and fmb.date_entry >= '$define_date'"
                . " and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code' order by fmb.petition_no ASC";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionSecondCases($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
    }

    public function getRejectedConversionSecondCases($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where not_fresh = 'Y' and status = 'R' and mut_type='01' and co_user_code = '$dsg'  and date_entry >= '$define_date'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' order by petition_no ASC";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countRejectedConversionSecondCases($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and status = 'R' and mut_type='01' and co_user_code = '$dsg' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
    }

    public function getConvertionOrderPassedByDC($user_desig_code) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where not_fresh = 'Y' and status = 'W' and mut_type='01' and add_off_desig = '$user_desig_code'  and date_entry >= '$define_date'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' order by petition_no ASC";
        // echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countConvertionOrderPassedByDC($user_desig_code) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and status = 'W' and mut_type='01' and add_off_desig = '$user_desig_code' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
    }

    public function getChithaUpdateConvCases($dsg) {
		$db=  $this->session->userdata('db');
        $q = "select * from   t_chitha_rmk_ordbasic where co_code = '$dsg' and ord_type_code = '01' and iscorrected_inco = '' order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countChithaUpdateConvCases($dsg) {
		$db=  $this->session->userdata('db');
        return $this->db->query("select count(*) as c from   t_chitha_rmk_ordbasic where co_code = '$dsg' and ord_type_code = '01' and iscorrected_inco = ''")->row()->c;
    }

    public function getPendingLandReclassificationProposals() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
		///modified 7/10/21
        //$q = "select * from t_reclassification where dist_code='$dist_code' and "
               // . "subdiv_code='$subdiv_code' and cir_code='$cir_code'  and rkg_chitha_updated_yn!='Y'  and (status != 'R' OR status is null OR status='C') ORDER BY proposal_no asc";
        $q = "select *,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree  where co_yn is null and dc_yn is null and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' and status!='M' OR status is null OR status='C') ORDER BY proposal_no asc";

		//echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingLandReclassificationProposals() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from   t_reclassification where co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and (status != 'R' and status!='M' OR status is null OR status='C') ";
        //echo $q;
        return $this->db->query($q)->row()->count;
    }

    public function getPendingGenerateTransmissionForDC() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select *,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree  where co_yn = 'Y' and dc_yn is null and dc_approval is null and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) ORDER BY proposal_no asc ";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countGenerateTransmissionForDC() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)";
        //echo $q;
        return $this->db->query($q)->row()->count;
    }

    public function getPendingLandReclassificationDC() {
		$db=  $this->session->userdata('db');
        //$this->db->limit($limit, $start);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$q = "select * from   t_reclassification where co_yn = 'Y' and dc_yn is null  and dc_approval is null and dist_code='$dist_code' "
        //        . "and (status = 'A') ORDER BY proposal_no asc ";

        $q = "select *,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree where co_yn = 'Y' and dc_yn is null  and dc_approval is null and dist_code='$dist_code' "
                . "and (status = 'A' OR status = 'P' OR status is null) ORDER BY proposal_no asc ";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }
    public function getPendingLandReclassificationDCReal() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        // $q = "select * from t_reclassification where  status='D' and co_chitha_updated_yn is null ORDER BY proposal_no asc ";

        $q = "select *,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree  where  tr.status='D' and tr.co_chitha_updated_yn is null ORDER BY tr.proposal_no asc ";
        
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingLandReclassificationDC() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn is null and dc_approval is null and "
                . "dist_code='$dist_code' and (status != 'R' OR status is null)";
        return $this->db->query($q)->row()->count;
    }
     public function countPendingLandReclassificationDCReal() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from t_reclassification where co_yn = 'Y' and dc_yn is null and forwardtodc is not  null and account is not null and dc_approval is null and "
                . "dist_code='$dist_code' and ( status is null)";
        return $this->db->query($q)->row()->count;
    }

    public function countRevertedPending() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn is null and dc_approval is not null and "
                . "dist_code='$dist_code' and (status != 'R' OR status is null)";
        return $this->db->query($q)->row()->count;
    }

    public function getRevertedPending() {
		$db=  $this->session->userdata('db');
        //$this->db->limit($limit, $start);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select * from   t_reclassification where co_yn = 'Y' and dc_yn is null and dc_approval is not null and dist_code='$dist_code' "
                . "and (status != 'R' OR status is null) ORDER BY proposal_no asc ";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function getPendingRevertedBackFromDC() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$q = "select * from   t_reclassification where co_yn = 'Y' and dc_yn is null and co_chitha_updated_yn is null and dc_approval is not null and dist_code='$dist_code' and "
               // . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) ORDER BY proposal_no asc";
        $q = "select*,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree  where co_yn = 'Y' and dc_yn is null and co_chitha_updated_yn is null and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) ORDER BY proposal_no asc";

		//echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countRevertedBackFromDC() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn is null and dc_approval is not null and co_chitha_updated_yn is null "
               // . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)";
        $q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn is null and co_chitha_updated_yn is null "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)";

		//echo $q;
        return $this->db->query($q)->row()->count;
    }

    public function countApprovedLandReclassification() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        return $this->db->query("select count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;
    }

     public function getPendingRevertedBackFromCO() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        //$q = "select * from   t_reclassification where co_yn = 'Y' and dc_yn is null and co_chitha_updated_yn is null and dc_approval is not null and dist_code='$dist_code' and "
               // . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) ORDER BY proposal_no asc";
        $q = "select *,ba.basundhara from t_reclassification tr left join basundhar_application ba on tr.case_no=ba.dharitree  where status='M' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ORDER BY proposal_no asc";

        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function getJamaupdatereclass() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "SELECT * FROM  t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
                . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
                . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and TRIM(c.patta_no) = TRIM(t.patta_no) and c.dist_code='$dist_code' and "
                . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countJamaupdatereclass() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "SELECT count(*) as count FROM  t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
                . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
                . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and TRIM(c.patta_no) = TRIM(t.patta_no) and c.dist_code='$dist_code' and "
                . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'";
        return $this->db->query($q)->row()->count;
    }

    public function getApprovedLandReclassification() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select * from   t_reclassification WHERE co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) order by proposal_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function getPendingGenerateTransmissionForCO() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select * from   t_reclassification where co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null) ORDER BY proposal_no asc";
        //echo $q;
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countGenerateTransmissionForCO() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select count(*) as count from   t_reclassification where co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)";
        //echo $q;
        return $this->db->query($q)->row()->count;
    }

    public function getconversion_proceeding_report($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        $q = "SELECT p.case_no, p.petition_no,p.status, p.submission_date,p.date_entry,p.not_fresh,p.lm_note_yn,p.notice_generated_yn,p.proceeding_yn,p.sk_comment,"
                . "p.co_order_conv_premium, p.next_date_of_hearing, pd.dag_no,p.dist_code,p.subdiv_code,p.cir_code,p.mouza_pargona_code,p.lot_no,p.vill_townprt_code,p.add_off_desig"
                . " FROM  petition_basic as p INNER JOIN  petition_dag_details as pd ON "
                . "p.dist_code=pd.dist_code and p.subdiv_code = pd.subdiv_code and p.cir_code = pd.cir_code and p.mouza_pargona_code=pd.mouza_pargona_code "
                . "and p.lot_no=pd.lot_no and p.vill_townprt_code=pd.vill_townprt_code and p.petition_no = pd.petition_no and p.dist_code='$dist_code' "
                . "and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . "p.mut_type = '01' and p.date_entry >= '$define_date' and p.status != 'B' order by CAST(coalesce(p.petition_no, '0') AS numeric) asc";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countconversion_proceeding_report($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where mut_type = '01' and status != 'B' and "
                . "date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and proceeding_yn is null and not_fresh = 'Y'")->row()->c;
    }

    public function getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p, $patta_no) {
		$db=  $this->session->userdata('db');
        $district = $this->db->query(""
                . "Select dag_no, dag_no_int from   Chitha_Basic where "
                . "Dist_code='$dist_code' and Subdiv_code='$subdiv_code' and  patta_type_code='$p' and "
                . "TRIM(patta_no) = trim('$patta_no') and Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_no' "
                . "and Vill_townprt_code='$vill_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
        return $district->result();
    }

    public function getSubDivJSON_wdb($distCode) {
		$db=  $this->session->userdata('db');
		$database="Select database_name as live,default_language as language from  district_details where district_code='$distCode' 	";
		$activeDB=$this->db->query($database)->row();
		$this->load->database($activeDB->live);
		$db=  $activeDB->live;
		$this->session->set_userdata('db',$activeDB->live);
        //$db = $this->load->database($distCode, TRUE);
        //$this->dbb = $db;
        $district = $this->db->query("select * from  location where dist_code =?  and "
                . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'", array($distCode));
        return $district->result();
    }

    public function getCirCodeJSON_wdb($distCode, $subdivcode) {
		$db=  $this->session->userdata('db');
		$database="Select database_name as live,default_language as language from  district_details where district_code='$distCode' 	";
		$activeDB=$this->db->query($database)->row();
		$this->load->database($activeDB->live);
		$db=  $activeDB->live;
        $district = $this->db->query("select * from   location where dist_code =?  and "
                . " subdiv_code=? and cir_code!='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'", array($distCode, $subdivcode));
        return $district->result();
    }

    public function get_checklist_for_field_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no) {
		$db=  $this->session->userdata('db');
        //$message = '';
        $count = "select count(*) as c from   field_mut_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
        $count = $this->db->query($count)->row()->c;
        //echo $count."<br>";
        if ($count > 0) {
            $check_field_cases_dag = "select * from   field_mut_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
            //echo $check_field_cases_dag."<br>";
            $check_field_cases_dag = $this->db->query($check_field_cases_dag)->result();


            foreach ($check_field_cases_dag as $field_cases) {

                if ($field_cases->case_no != '') {
                    $check_field_cases_basic = "select order_passed as order_passed from   field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                            . "and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
                            . "vill_townprt_code='$village_code' and petition_no = '$field_cases->petition_no' and case_no = '$field_cases->case_no'";
                    //echo $check_field_cases_basic."<br>";
                    $check_field_cases_basic = $this->db->query($check_field_cases_basic)->row()->order_passed;
                    //echo $check_field_cases_basic;
                    if ($check_field_cases_basic == 'Y') {
                        $check_chitha_correction = "select iscorrected_inco as citha_corrected from   t_chitha_col8_order where dist_code='$dist_code' and "
                                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                                . "lot_no='$lot_no' and vill_townprt_code='$village_code' and petition_no = '$field_cases->petition_no' and "
                                . "case_no = '$field_cases->case_no' and dag_no = '$dag_no' ";
                        //echo $check_chitha_correction."<br>";
                        $check_chitha_correction = $this->db->query($check_chitha_correction)->row()->citha_corrected;
                        //echo $check_chitha_correction;
                        if ($check_chitha_correction != 'Y') {
                            $message = "Field Case was registered but chitha not updated ";
                        } else {
                            $message = "";
                        }
                    } else {
                        $message = "Field Case was registered but Order not Passed ";
                    }
                } else {
                    $message = "";
                }
            }
        } else {
            $message = "";
        }
        return $message;
    }

    public function get_checklist_for_office_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no) {
		$db=  $this->session->userdata('db');
        //$message = '';
        $count = "select count(*) as c from   petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
        //echo $count."<br>";
        $count = $this->db->query($count)->row()->c;

        if ($count > 0) {
            $check_office_cases_dag = "select * from   petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
            //echo $check_office_cases_dag."<br>";
            $check_office_cases_dag = $this->db->query($check_office_cases_dag)->result();


            foreach ($check_office_cases_dag as $office_cases) {
                if ($office_cases->petition_no != '') {
                    $check_office_cases_basic = "select order_passed as order_passed, case_no as case_no from   petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                            . "and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
                            . "vill_townprt_code='$village_code' and petition_no = '$office_cases->petition_no'";
                    //echo $check_office_cases_basic."<br>";
                    $check_office_cases_basic = $this->db->query($check_office_cases_basic)->row();
                    //echo $check_field_cases_basic;
                    $case_no = $check_office_cases_basic->case_no;
                    if ($check_office_cases_basic->order_passed == 'Y') {
                        $check_chitha_correction = "select iscorrected_inco as citha_corrected from   t_chitha_rmk_ordbasic where dist_code='$dist_code' and "
                                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                                . "lot_no='$lot_no' and vill_townprt_code='$village_code' and petition_no = '$office_cases->petition_no' and "
                                . "case_no = '$case_no' and dag_no = '$dag_no' ";
                        //echo $check_chitha_correction."<br>";
                        $check_chitha_correction = $this->db->query($check_chitha_correction)->row()->citha_corrected;
                        //echo $check_chitha_correction;
                        if ((!empty($check_chitha_correction)) && ($check_chitha_correction != 'Y')) {
                            $message = "Office Case was registered but chitha not updated ";
                        } else {
                            $message = "";
                        }
                    } else {
                        $message = "Office Case was registered but Order not Passed ";
                    }
                } else {
                    $message = "";
                }
            }
        } else {
            $message = "";
        }
        return $message;
    }

    public function get_checklist_for_reclassification_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no, $Dagno_int) {
		$db=  $this->session->userdata('db');
        //$message = '';
        $count = "select count(*) as c from   t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no='$dag_no' and (status != 'R' OR status is null)";
        //echo $count;
        $count = $this->db->query($count)->row()->c;
        //echo $count."<br>";
        if ($count > 0) {
            $get_reclassification_class_code = "select land_class_code as land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no_int = '$Dagno_int'";
            //echo $check_field_cases_dag."<br>";
            $get_reclassification_class_code = $this->db->query($get_reclassification_class_code)->row()->land_class_code;

            $check_reclassification_cases = "select * from   t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
                    . "vill_townprt_code='$village_code' and present_land_class = '$get_reclassification_class_code' and dag_no='$dag_no' and (status != 'R' OR status is null)";
            //echo $check_field_cases_basic."<br>";// co_yn,dc_yn,co_chitha_updated_yn
            $check_reclassification_cases = $this->db->query($check_reclassification_cases)->row();

//            if($check_chitha_correction != 'Y')
//            {
//                $message = "Field Case was registered but chitha not updated";
//            }
//            else {
//                $message = "No Field Cases Going On";
//            }
            $message = "";
        } else {
            $message = "";
        }
        return $message;
    }

    public function getPendingConversionSecondCases_dc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg'  and date_entry >= '$define_date'"
                . " and dist_code='$dist_code' and bo_note_yn is not null order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionSecondCases_dc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
    }

    public function getPendingConversionSecondCases_adc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg'  and date_entry >= '$define_date'"
                . " and dist_code='$dist_code' and bo_note_yn is not null order by petition_no ASC";
        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionSecondCases_adc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and "
                        . "date_entry >= '$define_date' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
    }

    public function getPendingConversionFirstCases_dc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where bo_note_yn is null and bo_notice_gen is null and mut_type='01' and co_user_code = '$dsg' and add_off_desig = '$user_desig_code' and "
                . "date_entry >= '$define_date' and dist_code='$dist_code' order by petition_no ASC";

        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionFirstCases_dc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where bo_note_yn is null and bo_notice_gen is null and mut_type='01' and co_user_code = '$dsg' and "
                        . "add_off_desig = '$user_desig_code' and date_entry >= '$define_date' and dist_code='$dist_code'")->row()->c;
    }

    public function getPendingConversionFirstCases_adc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        $q = "select * from   petition_basic where bo_note_yn is null and bo_notice_gen is null and mut_type='01' and co_user_code = '$dsg' and add_off_desig = '$user_desig_code' "
                . "and date_entry >= '$define_date' and dist_code='$dist_code' order by petition_no ASC";

        $cases = $this->db->query($q);
        return $cases;
    }

    public function countPendingConversionFirstCases_adc($dsg) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        return $this->db->query("select count(*) as c from   petition_basic where bo_note_yn is null and bo_notice_gen is null and mut_type='01' and co_user_code = '$dsg' and "
                        . "add_off_desig = '$user_desig_code' and date_entry >= '$define_date' and dist_code='$dist_code'")->row()->c;
    }

}
