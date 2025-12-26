<?php

class NameCorrectionModel extends CI_Model {

    public function getSupportingDoc() {
		$db=  $this->session->userdata('db');
        $sql = "select * from   misc_case_supp_doc ORDER BY supp_doc_code ASC";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getAvailLand($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code) {
        $db=  $this->session->userdata('db');
		$sql = "select count(*)  AS cnt from   chitha_basic where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no')";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getPdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $dag_no) {
        $db=  $this->session->userdata('db');
		$sql = "select pdar_id, pdar_name, pdar_father, pdar_add1, pdar_add2, pdar_guard_reln from   chitha_pattadar where dist_code ='$dist_code' and 
            subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . "and TRIM(patta_no) =trim('$patta_no') and patta_type_code = '$patta_type_code' and pdar_id IN (Select pdar_id from   chitha_dag_pattadar where dist_code ='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . "and TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and dag_no='$dag_no' and (p_flag='0' or p_flag=''))";
        //echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getPdarDataJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id) {
        $db=  $this->session->userdata('db');
		$sql = "select pdar_id, pdar_name, pdar_father, pdar_add1, pdar_add2, pdar_guard_reln from   chitha_pattadar "
                . " where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
		$db=  $this->session->userdata('db');
        // status 1 is for circle officers first proceedin for name correction
        $sql = "select count(*) AS cnt from   misc_case_basic where status='1' and lm_note_yn is null and sk_note_yn is null and "
                . "submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and add_to_officer = '$user_code' and es_flag='0'";

        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

//     public function getMiscCases1($user_code) {
// 		$db=  $this->session->userdata('db');
//         $dist_code = $this->session->userdata('dist_code');
//         $subdiv_code = $this->session->userdata('subdiv_code');
//         $cir_code = $this->session->userdata('cir_code');
//         $year_no = year_no;
//         $define_date = define_date;
//         // status 1 is for circle officers first proceedin for name correction
//         $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='1' and lm_note_yn is null and sk_note_yn is null  "
//                 . "and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
//                 . "and cir_code='$cir_code' and add_to_officer = '$user_code' ORDER BY submission_date DESC";
//         $result = $this->db->query($sql);
//         return $result->result();
//     }

//     public function getMiscCases2($user_code) {
// 		$db=  $this->session->userdata('db');
//         $dist_code = $this->session->userdata('dist_code');
//         $subdiv_code = $this->session->userdata('subdiv_code');
//         $cir_code = $this->session->userdata('cir_code');
//         //$year_no = year_no;
//         $define_date = define_date;
//         // status 1 is for circle officers first proceedin for name correction
//         $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where status='1' and lm_note_yn is null and sk_note_yn is null "
//                 . "and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
//                 . "and cir_code='$cir_code' and add_to_officer = '$user_code' ORDER BY submission_date DESC";

// //      $sql="(select distinct on (ba.basundhara) ba.basundhara, * from misc_case_basic fmb left 
// //   join basundhar_application ba on fmb.misc_case_no=ba.dharitree where ba.basundhara !='' and status='1' and lm_note_yn is null and sk_note_yn is null 
// //                 and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' 
// //                 and cir_code='$cir_code' and add_to_officer = '$user_code' )
// // union (
// // select ba.basundhara, * from misc_case_basic fmb left 
// //   join basundhar_application ba on fmb.misc_case_no=ba.dharitree where ba.basundhara is null 
// // and  status='1' and lm_note_yn is null and sk_note_yn is null 
// //                 and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' 
// //                 and cir_code='$cir_code' and add_to_officer = '$user_code'  )";

//         $result = $this->db->query($sql);
//         return $result;
//     }

    public function getMiscCases1() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        // status 1 is for circle officers first proceedin for name correction
        $sql = "select count(*) as c from   misc_case_basic where status='1' and lm_note_yn is null and sk_note_yn is null  "
                . "and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and add_to_officer = '$user_code'";
        $result = $this->db->query($sql)->row()->c;
        return $result;
    }

    public function getMiscCases2($start,$limit,$key=null) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $define_date = define_date;
        if($key){
            $sql = "select mcb.dist_code,mcb.subdiv_code,mcb.cir_code,mcb.mouza_pargona_code,mcb.lot_no,mcb.vill_townprt_code,mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,es_flag,is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where es_flag =0 and status='1' and lm_note_yn is null and sk_note_yn is null "
                    . "and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and add_to_officer = '$user_code' and (misc_case_no like '%$key%' or ba.basundhara like '%$key%') limit 5 offset 0 ";
            $result = $this->db->query($sql)->result();
        }else{
            $sql = "select mcb.dist_code,mcb.subdiv_code,mcb.cir_code,mcb.mouza_pargona_code,mcb.lot_no,mcb.vill_townprt_code,mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,es_flag,is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where es_flag =0 and status='1' and lm_note_yn is null and sk_note_yn is null "
                    . "and submission_date >= '$define_date' and notice_generated_yn is null and fresh_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and add_to_officer = '$user_code' limit $start offset $limit ";
            $result = $this->db->query($sql)->result();
        }
        return $result;
    }

    
    public function getNameCorrCaseInfo($misc_case_no, $petition_no) {
		$db=  $this->session->userdata('db');
        $sql = "select * from  misc_case_basic where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($misc_case_no, $petition_no));
        return $result->row();
    }

    public function caseInfoForAuthorization($misc_case_no) {
        $db=  $this->session->userdata('db');
        $sql = "SELECT * FROM misc_case_basic WHERE misc_case_no=?";
        $row = $this->db->query($sql, array($misc_case_no));
        return $row->row();
    }

    public function getPetitionNo($misc_case_no) {
        $db=  $this->session->userdata('db');
        $sql = "select misc_case_petition_no from  misc_case_basic where misc_case_no=?";
        $result = $this->db->query($sql, array($misc_case_no));
        return $result->row();
    }


    public function getSupportedDoc($supported_doc_code) {
		$db=  $this->session->userdata('db');
        $doc = explode(',', $supported_doc_code);
        $c = 1;
        $con = "";
        foreach ($doc AS $d) {
            if ($c > 1) {
                $con.=" or supp_doc_code='$d'";
            } elseif ($c == 1) {
                $con.=" supp_doc_code='$d'";
            }
            $c++;
        }
        $sql = "select * from   misc_case_supp_doc where " . $con;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getPetitionerInfo($misc_case_no, $patta_no, $petition_no) {
		$db=  $this->session->userdata('db');
        $sql = "select t1.auth_type,t1.petition_pdar_name_new, t1.petition_pdar_name_old, t2.pdar_father,t2.pdar_add1,t2.pdar_add2 from   misc_case_first_party AS t1 JOIN  chitha_pattadar AS t2 "
                . " ON t1.petition_pdar_id=t2.pdar_id and trim(t1.petition_pdar_name_old)=trim(t2.pdar_name) "
                . " where t1.misc_case_no='$misc_case_no' and t1.misc_case_petition_no='$petition_no' and TRIM(t2.patta_no)=trim('$patta_no')";

        //echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getPetitionerInfo1($misc_case_no, $patta_no, $petition_no) {
		$db=  $this->session->userdata('db');
        $sql = "select t1.petition_pdar_name_new, t1.petition_pdar_name_old, t2.pdar_father,t2.pdar_add1,t2.pdar_add2 from   misc_case_first_party AS t1 JOIN  chitha_pattadar AS t2 "
                . " ON t1.petition_pdar_id=t2.pdar_id and t1.petition_pdar_name_old=t2.pdar_name "
                . " where t1.misc_case_no='$misc_case_no' and t1.misc_case_petition_no='$petition_no' and TRIM(t2.patta_no)=trim('$patta_no')";

        //echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no) {
        $db=  $this->session->userdata('db');
		$sql = "select t2.pdar_name,t2.pdar_father,t2.pdar_father,t2.pdar_add1,t2.pdar_add2 from   misc_case_scnd_party AS t1 JOIN  chitha_pattadar AS t2 "
                . " ON t1.opp_pdar_id=t2.pdar_id "
                . " where t1.misc_case_no='$misc_case_no' and t2.dist_code ='$dist_code' and "
                . " t2.subdiv_code='$subdiv_code' and t2.cir_code='$cir_code' and "
                . " t2.mouza_pargona_code='$mouza_pargona_code' and "
                . " t2.lot_no='$lot_no' and t2.vill_townprt_code='$vill_code' and "
                . " TRIM(t2.patta_no)=trim('$patta_no') and t2.patta_type_code='$patta_type_code'";

        //echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getNoticeGenerateMiscCase1($user_code) {
        $db=  $this->session->userdata('db');
		$dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and status='18' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $result = $this->db->query($sql);
        return $result;
    }

    public function getNoticeGenerateMiscCase($user_code) {
        $db=  $this->session->userdata('db');
		$dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and status='18' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code = '$user_code'";

        $result = $this->db->query($sql);
        return $result->result();
    }


    ///notice re-generation/////
    public function getNoticeReGenerateMiscCase1($user_code,$case_no) {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara, mcb.es_flag from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where status not in('l','10') and submission_date >= '$define_date' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and misc_case_no='$case_no' ";

        $result = $this->db->query($sql)->row();
        return $result;
    }
    ////

    public function getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
		$db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where lm_note_yn is  null and  next_date_of_hearing is not null "
                . "and fresh_yn='Y' and status!='F' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "submission_date >= '$define_date' ORDER BY submission_date DESC";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getMiscCaseLMRevert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='L' "
                . "and fresh_yn='Y' and misc_case_type='06' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "submission_date >= '$define_date' ORDER BY submission_date DESC";
        $result = $this->db->query($sql);
        return $result->result();
    }



    public function getMiscCaseLM1($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
		$db=  $this->session->userdata('db');
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.submission_date,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and lm_note_yn is null "
                . "and next_date_of_hearing is not null and fresh_yn='Y' and status!='F' and submission_date >= '$define_date' ORDER BY submission_date DESC ";


        $result = $this->db->query($sql);
        return $result;
    }

      public function getMiscCaseLMRe($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        $db=  $this->session->userdata('db');
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and lm_note_yn is null "
                . "and status='L' and mcb.misc_case_type='06' and fresh_yn='Y' and submission_date >= '$define_date' and es_flag='0' ORDER BY submission_date DESC ";


        $result = $this->db->query($sql);
        return $result;
    }

    public function getMiscCaseSK($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
		$db=  $this->session->userdata('db');
        $define_date = define_date;
        // 02 is a status after lm report
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='02' and lm_note_yn='Y' and sk_note_yn is null and status!='F' and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' ORDER BY submission_date DESC";

        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getMiscCaseSK1($user_code) {
        $dist_code = $this->session->userdata('dist_code');
		$db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where status='02' and lm_note_yn='Y' and sk_note_yn is null and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' ORDER BY submission_date DESC ";
        $result = $this->db->query($sql);
        return $result;
    }

  //   public function getFinalOrderMisc($user_code) {
  //       $dist_code = $this->session->userdata('dist_code');
		// $db=  $this->session->userdata('db');
  //       $subdiv_code = $this->session->userdata('subdiv_code');
  //       $cir_code = $this->session->userdata('cir_code');
  //       $year_no = year_no;
  //       $define_date = define_date;
  //       // 02 is after lm and sk's report
  //       $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='02' and lm_note_yn='Y' and sk_note_yn='Y' and "
  //               . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
  //               . "add_to_officer = '$user_code'";
  //       $result = $this->db->query($sql);
  //       return $result->result();
  //   }

  //   public function getFinalOrderMisc1($user_code) {
  //       $dist_code = $this->session->userdata('dist_code');
		// $db=  $this->session->userdata('db');
  //       $subdiv_code = $this->session->userdata('subdiv_code');
  //       $cir_code = $this->session->userdata('cir_code');
  //       $year_no = year_no;
  //       $define_date = define_date;
  //       $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where status='02' and lm_note_yn='Y' and sk_note_yn='Y' and "
  //               . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
  //               . "add_to_officer = '$user_code' ORDER BY misc_case_petition_no DESC";
  //       $result = $this->db->query($sql);
  //       return $result;
  //   }


    ////////////////
    public function getFinalOrderMisc($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        // 02 is after lm and sk's report
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status='02' and lm_note_yn='Y' and misc_case_type='06' and  sk_note_yn='Y' and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "add_to_officer = '$user_code'";
        $result = $this->db->query($sql);
        return $result->result();
    }
     public function getFinalOrderMiscDelete($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        // 02 is after lm and sk's report
        $sql = "select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from   misc_case_basic where status in  ('02','10') and operation!='E' and misc_case_type='07' and lm_note_yn='Y' and sk_note_yn='Y' and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "add_to_officer = '$user_code'";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getFinalOrderMisc1($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select mcb.dist_code,mcb.subdiv_code,mcb.cir_code,mcb.mouza_pargona_code,mcb.lot_no,mcb.vill_townprt_code,mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where status='02' and lm_note_yn='Y' and misc_case_type='06' and sk_note_yn='Y' and es_flag = 0 and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "add_to_officer = '$user_code' ORDER BY misc_case_petition_no DESC";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getFinalOrderMiscDeletion($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select mcb.dist_code,mcb.subdiv_code,mcb.cir_code,mcb.mouza_pargona_code,mcb.lot_no,mcb.vill_townprt_code,mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree  where status in('10','02')  and operation!='E' and misc_case_type='07' and lm_note_yn='Y' and sk_note_yn='Y' and "
                . "submission_date >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "add_to_officer = '$user_code' ORDER BY misc_case_petition_no DESC";
        $result = $this->db->query($sql);
        return $result;
    }
    /////

    public function getLMReport($misc_case_no, $petition_no) {
        // l stands from   lm
		$db=  $this->session->userdata('db');
        $sql = "select process_note from   misc_case_process_reports where misc_case_no='$misc_case_no' and operation='l' and misc_case_petition_no = '$petition_no' order by note_no desc ";
        $result = $this->db->query($sql);
        return $result->row()->process_note;
    }

    public function getSKReport($misc_case_no, $petition_no) {
        // s stands for sk
		$db=  $this->session->userdata('db');
        $sql = "select process_note from   misc_case_process_reports where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' and operation='s' order by note_no desc";
        $result = $this->db->query($sql);
        return $result->row()->process_note;
    }

    public function getLMSignDate($misc_case_no) {
		$db=  $this->session->userdata('db');
        $sql = "select note_date from   misc_case_process_reports where misc_case_no='$misc_case_no' and operation='l'";
        $result = $this->db->query($sql);
        return $result->row()->note_date;
    }

    public function getSKSignDate($misc_case_no) {
		$db=  $this->session->userdata('db');
        $sql = "select note_date from   misc_case_process_reports where misc_case_no='$misc_case_no' and operation='s'";
        $result = $this->db->query($sql);
        return $result->row()->note_date;
    }

    public function getCOSignDate($misc_case_no) {
		$db=  $this->session->userdata('db');
        $sql = "select note_date from   misc_case_process_reports where misc_case_no='$misc_case_no' and operation='c' ORDER BY note_no DESC";
        $result = $this->db->query($sql);
        return $result->row()->note_date;
    }

    public function getOrderNo() {
		$db=  $this->session->userdata('db');
        $sql = "select count(*) AS cnt from   t_chitha_rmk_ordbasic where ord_type_code='06'";
        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getPdarIDMisc($misc_case_no,$petition_no) {
		$db=  $this->session->userdata('db');
        $sql = "select * from   misc_case_first_party where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id) {
        $db=  $this->session->userdata('db');
		$sql = "select dag_no from   chitha_dag_pattadar where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id) {
        $db=  $this->session->userdata('db');
		$sql = "select pdar_id,pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_guard_reln  from   chitha_pattadar where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and  mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function getMiscID($misc_case_no) {
        $db=  $this->session->userdata('db');
		$sql = "select count(*) AS cnt from   t_chitha_rmk_infavor_of where ord_no='$misc_case_no'";
        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }

    public function getCOorderDate($misc_case_no) {
        $db=  $this->session->userdata('db');
		$sql = "select note_date from   misc_case_process_reports where misc_case_no='$misc_case_no' LIMIT 1 ";
        $result = $this->db->query($sql);
        return $result->row()->note_date;
    }

     ///////pagination/////
    public function count_getNoticeGenerateMiscCase() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select count(*) as c from   misc_case_basic where lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and status='18' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";

        
        $cases = $this->db->query($sql)->row()->c;
        return $cases;
    }


public function getNoticeGenerateMiscCasePagi($start,$limit,$key=null) {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        if($key)
        {
        $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb  left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and status='18' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and (misc_case_no like '%$key%' or ba.basundhara like '%$key%') limit 50 offset 0";
                $result = $this->db->query($sql)->result();
         }
        else
        {
            $sql = "select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,mcb.misc_case_petition_no,ba.basundhara,mcb.es_flag,mcb.is_escalated from   misc_case_basic mcb  left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where lm_note_yn is null and sk_note_yn is null and "
                . " notice_generated_yn is null and submission_date >= '$define_date' and status='18' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  limit $start offset $limit ";
                $result = $this->db->query($sql)->result();
        }
       // $result = $this->db->query($sql);
        return $result;
    }

}
