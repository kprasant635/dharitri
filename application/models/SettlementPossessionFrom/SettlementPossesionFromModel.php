<?php

class SettlementPossesionFromModel extends CI_Model {

    public function getWrongPossessionFromData($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no)
    {
        $query = $this->db->query("SELECT DISTINCT cp.o1_case_no, cb.dist_code, cb.subdiv_code, cb.cir_code, cb.mouza_pargona_code, cb.lot_no,  
                            cb.vill_townprt_code, cb.patta_type_code, cb.patta_no,cb.possession_from 
                            FROM chitha_basic cb 
                            JOIN chitha_pattadar cp 
                                ON cb.dist_code=cp.dist_code 
                                AND cb.subdiv_code=cp.subdiv_code 
                                AND cb.cir_code=cp.cir_code 
                                AND cb.mouza_pargona_code=cp.mouza_pargona_code 
                                AND cb.lot_no=cp.lot_no 
                                AND cb.vill_townprt_code=cp.vill_townprt_code 
                                AND cb.patta_type_code=cp.patta_type_code 
                                AND cb.patta_no=cp.patta_no 
                            JOIN settlement_basic sb 
                                ON cp.o1_case_no=sb.case_no 
                            WHERE sb.co_chitha_corrected_yn='Y' 
                            AND sb.order_passed='Y' and sb.service_code in(14,15,16,17,18) 
                            AND (
                                    (cb.possession_from ~ '^\d{4}-\d{2}-\d{2}' AND cb.possession_from::date < ?) 
                                    OR cb.possession_from !~ '^\d{4}-\d{2}-\d{2}'
                                ) 
                            AND cb.dist_code=? 
                            AND cb.subdiv_code=? 
                            AND cb.cir_code=? 
                            AND cb.mouza_pargona_code=? 
                            AND cb.lot_no=?",
                            array(SETTLEMENT_POSSESSION_FROM_DATE,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)
                        );
                        
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }

    }

    public function insertBasicDetails($insert_array)
    {
        return $this->db->insert('settlement_pf_basic', $insert_array);
    }

    public function insertProceedingDetails($insert_array)
    {
        return $this->db->insert('settlement_pf_proceedings', $insert_array);
    }

    public function getPossessionFromData($case_no)
    {
        $query = $this->db->query("select cb.* from chitha_basic cb 
        join (select new_dag,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code 
        from chitha_settlement_allottee where ord_no=? group by
        new_dag,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code ) csa 
        on cb.dist_code=csa.dist_code and cb.subdiv_code= csa.subdiv_code and cb.cir_code=csa.cir_code 
        and cb.mouza_pargona_code = csa.mouza_pargona_code and cb.lot_no = csa.lot_no 
        and cb.vill_townprt_code= csa.vill_townprt_code and cb.dag_no= csa.new_dag",array($case_no))->row();
        return $query->possession_from;


        // $query = $this->db->query("
        //             SELECT cb.* FROM chitha_basic cb
        //             JOIN (
        //                 SELECT 
        //                     dist_code,subdiv_code,cir_code, mouza_pargona_code,
        //                     lot_no,vill_townprt_code,patta_type_code,patta_no
        //                 FROM chitha_pattadar WHERE o1_case_no = ?
        //                 GROUP BY 
        //                     dist_code,subdiv_code,cir_code,mouza_pargona_code,
        //                     lot_no,vill_townprt_code,patta_type_code,patta_no
        //             ) AS cpd
        //             ON cb.dist_code = cpd.dist_code 
        //             AND cb.subdiv_code = cpd.subdiv_code 
        //             AND cb.cir_code = cpd.cir_code 
        //             AND cb.mouza_pargona_code = cpd.mouza_pargona_code 
        //             AND cb.lot_no = cpd.lot_no 
        //             AND cb.vill_townprt_code = cpd.vill_townprt_code 
        //             AND cb.patta_type_code = cpd.patta_type_code 
        //             AND cb.patta_no = cpd.patta_no", array($case_no))->row();

        // return $query->possession_from;
    }

    public function getWrongPossessionFromDataForCo($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select * from settlement_pf_basic where dist_code=? and subdiv_code=? and cir_code=? and co_remark is null",array($dist_code,$subdiv_code,$cir_code));
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }
    }

    public function getCorrectedPossessionFromData($case_no)
    {
        $query = $this->db->query("select * from settlement_pf_basic where dharitree_case_no =?",array($case_no));
        return $query->row();
    }

    public function chithaPattadarDetailsFromCaseNo($case_no)
    {
        $query = $this->db->query("select cb.* from chitha_basic cb 
                join (select new_dag,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code 
                from chitha_settlement_allottee where ord_no=? group by
                new_dag,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code ) csa 
                on cb.dist_code=csa.dist_code and cb.subdiv_code= csa.subdiv_code and cb.cir_code=csa.cir_code 
                and cb.mouza_pargona_code = csa.mouza_pargona_code and cb.lot_no = csa.lot_no 
                and cb.vill_townprt_code= csa.vill_townprt_code and cb.dag_no= csa.new_dag",array($case_no));
        if($query->num_rows() == 0)
        {
            return null;
        }else{
            return $query->result();
        }
        
    }

    public function updateChithaBasicPossessionFrom($data)
    {
        $update_arr = array(
            'possession_from' => $data['possession_from']
        );

        $this->db->where('dist_code', $data['dist_code']);
        $this->db->where('subdiv_code', $data['subdiv_code']);
        $this->db->where('cir_code', $data['cir_code']);
        $this->db->where('mouza_pargona_code', $data['mouza_pargona_code']);
        $this->db->where('lot_no', $data['lot_no']);
        $this->db->where('vill_townprt_code', $data['vill_townprt_code']);
        $this->db->where('patta_type_code', $data['patta_type_code']);
        $this->db->where('patta_no', $data['patta_no']);
        $this->db->update('chitha_basic', $update_arr);
        return $this->db->affected_rows();
    }  

    public function insertChithaRemarksDetails($insert_array)
    {
        return $this->db->insert('chitha_rmk_lmnote', $insert_array);
    }

    public function getChithaRmkCountForDag($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no)
    {
        $query_count = $this->db->query("select count(lm_note) as count from chitha_rmk_lmnote where dist_code=? 
        and subdiv_code=? and cir_code=? and mouza_pargona_code=?
        and lot_no =? and vill_townprt_code=? and dag_no=?",
        array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no))->row()->count;

        if($query_count == 0)
        {
            return 1;
        }
        else
        {
            return $query_count +1;
        }
    }

}
?>