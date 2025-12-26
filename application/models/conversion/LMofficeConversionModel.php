<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class LMofficeConversionModel extends CI_Model{
    
    public function getPendingConversionLM_with_escalation($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
		$db=  $this->session->userdata('db');
        $year_no=year_no;
        $define_date=define_date;

        $es_flag = (ESCALATION_ENABLE == 1) ? " and es_flag = 1" : "";

        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and not_fresh = 'Y' and "
                . "lm_note_yn is null and status in ('P','R')  and date_entry >= '$define_date'  and mut_type='01' $es_flag order by petition_no ASC";

                // echo $this->db->last_query();
        
        $cases = $this->db->query($q);
        if(ESCALATION_ENABLE == 1)
        {
            $caseList = $this->Escalationmodel->getEscaltionViewFormat($cases->result());
        }
        return $cases;
    }

    public function getPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
		$db=  $this->session->userdata('db');
        $year_no=year_no;
        $define_date=define_date;

        // $es_flag = (ESCALATION_ENABLE == 1) ? " and es_flag = 1" : "";
        $es_flag ="";

        $q = "select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and not_fresh = 'Y' and "
                . "lm_note_yn is null and status in ('P','R')  and date_entry >= '$define_date'  and mut_type='01' and is_mb3!=1 $es_flag order by petition_no ASC";

                // echo $this->db->last_query();
        
        $cases = $this->db->query($q);
        if(ESCALATION_ENABLE == 1)
        {
            $caseList = $this->Escalationmodel->getEscaltionViewFormat($cases->result());
        }
        return $cases;
    }
    
    public function countPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
		$db=  $this->session->userdata('db');
        $year_no=year_no;
        $define_date=define_date;
        return $this->db->query("select count(*) as c from   petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "not_fresh = 'Y' and lm_note_yn is null and status = 'P'  and mut_type='01' and date_entry >= '$define_date' and is_mb3!=1")->row()->c;
    }
    ////05-04-22
    public function getPattadar($dag, $dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $case)
    {
        $query = $this->db->query("SELECT  distinct(A.pdar_id), A.pdar_name,
        A.pdar_father, A.pdar_add1, A.pdar_mobile FROM chitha_pattadar A 
        JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND 
        A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND 
        A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no 
        AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no 
        AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id 
        WHERE B.dag_no=? AND B.p_flag!=? AND A.dist_code=? AND A.subdiv_code=? 
        AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? 
        AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? 
        AND A.pdar_id NOT IN 
        (SELECT pdar_id FROM petitioner_part WHERE dist_code=? AND subdiv_code=? 
        AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
        AND patta_no=? AND patta_type_code=? AND case_no=? )", 
        array($dag, '1', $dist, $sub, $cir, $mouza, $lot, $vill, $pn, 
        $ptype, $dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $case));
        //echo $this->db->last_query();die();

        return $query; 
    }

    public function getAllPetitioners($case_no, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pn)
    {
        $query = $this->db->query("SELECT * FROM petitioner_part WHERE 
        case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
        mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND 
        patta_no=? ORDER BY pdar_cron_no", 
        array($case_no, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pn));

        return $query; 
    }
    // public function getDuplicatePattadar($dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $dag, $case_no)
    // {
    //     $query = $this->db->query("SELECT pdar_id, dag_no, patta_no, 
    //     dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
    //     vill_townprt_code, patta_type_code, COUNT(*)
    //     FROM petitioner_part WHERE dist_code=? 
    //     AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
    //     AND vill_townprt_code=? AND patta_no=trim(?) AND patta_type_code=? AND dag_no=? 
    //     AND case_no=? GROUP BY pdar_id, dag_no, patta_no, 
    //     dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
    //     vill_townprt_code, patta_type_code HAVING COUNT(*) > 1", 
    //     array($dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $dag, $case_no));

    //     return $query;
    // }

    public function getDuplicatePattadar($dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $dag, $case_no)
    {
        $query = $this->db->query("SELECT pdar_id, dag_no, patta_no, 
        dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
        vill_townprt_code, patta_type_code, COUNT(*)
        FROM petitioner_part WHERE dist_code=? 
        AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
        AND vill_townprt_code=? AND patta_no=trim(?) AND patta_type_code=? AND dag_no=? 
        AND case_no=? GROUP BY pdar_id, dag_no, patta_no, 
        dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
        vill_townprt_code, patta_type_code", 
        array($dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $dag, $case_no));

        return $query;
    }
    
}

