<?php
class DemandNoticeModel extends CI_Model {

    public function get_demand_notice_list($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no, $village_townprt_code, $direct_paying = false) {
        $table_name = $direct_paying ? 'ekhajana_year_wise_arrear_dp_estate' : 'ekhajana_year_wise_arrear';
        $where = "A.dist_code = ? AND A.subdiv_code = ? AND A.cir_code = ?";
        $params = [$dist_code, $subdiv_code, $cir_code];
    
        // For subquery parameters
        $sub_params = [$dist_code, $subdiv_code, $cir_code];
    
        if ($mouza_pargona_code !== false) {
            $where .= " AND A.mouza_pargona_code = ?";
            $params[] = $mouza_pargona_code;
            $sub_params[] = $mouza_pargona_code;
        }

        if ($lot_no !== false) {
            $where .= " AND A.lot_no = ?";
            $params[] = $lot_no;
            $sub_params[] = $lot_no;
        }

        if ($village_townprt_code !== false) {
            $where .= " AND A.vill_townprt_code = ?";
            $params[] = $village_townprt_code;
            $sub_params[] = $village_townprt_code;
        }
    
        $query = "SELECT DISTINCT A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code, A.lot_no, A.vill_townprt_code, A.patta_type_code, A.patta_no 
                  FROM $table_name A 
                  LEFT JOIN jama_wasil J 
                  ON A.dist_code = J.dist_code 
                  AND A.subdiv_code = J.subdiv_code 
                  AND A.cir_code = J.cir_code 
                  AND A.mouza_pargona_code = J.mouza_pargona_code 
                  AND A.lot_no = J.lot_no 
                  AND A.vill_townprt_code = J.vill_townprt_code 
                  AND A.patta_type_code = J.patta_type_code 
                  AND A.patta_no = J.patta_no 
                  WHERE $where
                  AND (
                      (
                          SELECT COUNT(*) 
                          FROM $table_name B 
                          WHERE B.dist_code = A.dist_code 
                          AND B.subdiv_code = A.subdiv_code 
                          AND B.cir_code = A.cir_code 
                          AND B.mouza_pargona_code = A.mouza_pargona_code 
                          AND B.lot_no = A.lot_no 
                          AND B.vill_townprt_code = A.vill_townprt_code 
                          AND B.patta_type_code = A.patta_type_code 
                          AND B.patta_no = A.patta_no 
                          AND B.financial_year IN (
                              SELECT DISTINCT financial_year 
                              FROM $table_name 
                              WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ?" .
                              ($mouza_pargona_code !== false ? " AND mouza_pargona_code = ?" : "") .
                              ($lot_no !== false ? " AND lot_no = ?" : "") .
                              ($village_townprt_code !== false ? " AND vill_townprt_code = ?" : "") .
                              " ORDER BY financial_year DESC 
                              LIMIT 5 
                          ) 
                          AND CAST(B.year_arrear AS NUMERIC) > 0 
                      ) = 5 
                      OR (
                          SELECT SUM(CAST(C.year_arrear AS NUMERIC)) 
                          FROM $table_name C 
                          WHERE C.dist_code = A.dist_code 
                          AND C.subdiv_code = A.subdiv_code 
                          AND C.cir_code = A.cir_code 
                          AND C.mouza_pargona_code = A.mouza_pargona_code 
                          AND C.lot_no = A.lot_no 
                          AND C.vill_townprt_code = A.vill_townprt_code 
                          AND C.patta_type_code = A.patta_type_code 
                          AND C.patta_no = A.patta_no 
                      ) > 1000
                  )
                  AND (J.patta_no IS NULL OR J.pay_status = 'UNPAID')";
    
        // Merge main and subquery parameters
        $final_params = array_merge($params, $sub_params);
        if ($mouza_pargona_code !== false) $final_params[] = $mouza_pargona_code;
        if ($lot_no !== false) $final_params[] = $lot_no;
        if ($village_townprt_code !== false) $final_params[] = $village_townprt_code;
    
        return $this->db->query($query, $final_params)->result();
    }

    // public function getArrearDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no) {
    //     $query = "SELECT financial_year, year_revenue, year_tax FROM ekhajana_year_wise_arrear WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ?";
    //     return $this->db->query($query, [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no])->result();
    // }

    public function getArrearDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no) {
        $query = "(
    SELECT financial_year, year_revenue, year_tax 
    FROM ekhajana_year_wise_arrear 
    WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
    AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
    ORDER BY financial_year DESC 
    LIMIT 5
)
UNION ALL
(
    SELECT CONCAT('Prior to ', MAX(financial_year)) AS financial_year, 
           SUM(year_revenue) AS year_revenue, 
           SUM(year_tax) AS year_tax 
    FROM ekhajana_year_wise_arrear 
    WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
    AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
    AND financial_year NOT IN (
        SELECT financial_year FROM ekhajana_year_wise_arrear 
        WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
        AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
        ORDER BY financial_year DESC LIMIT 5
    )
);
";
        
        $records =  $this->db->query($query, array_merge(
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no],
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no],
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no]
        ))->result();

        return array_reverse($records);
    }
    

    public function getPattadarNames($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no) {
        $sql = "SELECT cp.pdar_id, cp.pdar_name 
                FROM chitha_pattadar cp 
                JOIN (
                    SELECT cp.dist_code, cp.subdiv_code, cp.cir_code,
                           cp.mouza_pargona_code, cp.lot_no, cp.vill_townprt_code,
                           cp.patta_type_code, cp.patta_no, cp.pdar_id 
                    FROM chitha_dag_pattadar cp 
                    WHERE cp.dist_code = ? 
                      AND cp.subdiv_code = ? 
                      AND cp.cir_code = ? 
                      AND cp.mouza_pargona_code = ? 
                      AND cp.lot_no = ? 
                      AND cp.vill_townprt_code = ? 
                      AND cp.patta_type_code = ? 
                      AND cp.patta_no = ? 
                      AND cp.p_flag != '1' 
                    GROUP BY cp.dist_code, cp.subdiv_code, cp.cir_code, 
                             cp.mouza_pargona_code, cp.lot_no, cp.vill_townprt_code, 
                             cp.patta_type_code, cp.patta_no, cp.pdar_id
                ) cdp 
                ON cp.dist_code = cdp.dist_code 
                AND cp.subdiv_code = cdp.subdiv_code 
                AND cp.cir_code = cdp.cir_code 
                AND cp.mouza_pargona_code = cdp.mouza_pargona_code 
                AND cp.lot_no = cdp.lot_no 
                AND cp.vill_townprt_code = cdp.vill_townprt_code 
                AND cp.patta_type_code = cdp.patta_type_code 
                AND cp.patta_no = cdp.patta_no 
                AND cp.pdar_id = cdp.pdar_id 
                WHERE cp.dist_code = ? 
                  AND cp.subdiv_code = ? 
                  AND cp.cir_code = ? 
                  AND cp.mouza_pargona_code = ? 
                  AND cp.lot_no = ? 
                  AND cp.vill_townprt_code = ? 
                  AND cp.patta_type_code = ? 
                  AND cp.patta_no = ?";
    
        $query = $this->db->query($sql, [
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no, 
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no
        ]);
    
        return $query->result();
    }
    

    public function getCircles($dist_code, $subdiv_code) {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT cir_code, loc_name as circle_name 
                                FROM location 
                                WHERE dist_code = ? 
                                AND subdiv_code = ? 
                                AND cir_code != '00' 
                                AND mouza_pargona_code = '00' 
                                AND vill_townprt_code = '00000' 
                                AND lot_no = '00'", array($dist_code, $subdiv_code));
        return $query->result_array();
    }

    public function getMouzas($dist_code, $subdiv_code, $cir_code) {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT mouza_pargona_code, loc_name as mouza_name 
                                FROM location 
                                WHERE dist_code = ? 
                                AND subdiv_code = ? 
                                AND cir_code = ? 
                                AND mouza_pargona_code != '00' 
                                AND vill_townprt_code = '00000' 
                                AND lot_no = '00'", array($dist_code, $subdiv_code, $cir_code));
        return $query->result_array();
    }

    public function getVillages($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code) {
        $db = $this->load->database('auth', TRUE);
        $query = $db->query("SELECT DISTINCT vill_townprt_code, loc_name as village_name 
                                FROM location 
                                WHERE dist_code = ? 
                                AND subdiv_code = ? 
                                AND cir_code = ? 
                                AND mouza_pargona_code = ? 
                                AND vill_townprt_code != '00000'     
                                AND lot_no != '00'", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code));

        return $query->result_array();
    }

    public function get_demand_notice_count($dist_code, $direct_paying = false) {
        $table_name = $direct_paying ? 'ekhajana_year_wise_arrear_dp_estate' : 'ekhajana_year_wise_arrear';
        
        $query = "
            SELECT COUNT(DISTINCT ROW(
                A.dist_code, 
                A.subdiv_code, 
                A.cir_code, 
                A.mouza_pargona_code, 
                A.lot_no, 
                A.vill_townprt_code, 
                A.patta_type_code, 
                A.patta_no
            )) AS patta_count
            FROM $table_name A
            LEFT JOIN jama_wasil J 
                ON A.dist_code = J.dist_code 
                AND A.subdiv_code = J.subdiv_code 
                AND A.cir_code = J.cir_code 
                AND A.mouza_pargona_code = J.mouza_pargona_code 
                AND A.lot_no = J.lot_no 
                AND A.vill_townprt_code = J.vill_townprt_code 
                AND A.patta_type_code = J.patta_type_code 
                AND A.patta_no = J.patta_no 
            WHERE A.dist_code = ? and  A.notice_generated is null
            AND (
                (
                    SELECT COUNT(*) 
                    FROM $table_name B 
                    WHERE B.dist_code = A.dist_code 
                    AND B.subdiv_code = A.subdiv_code 
                    AND B.cir_code = A.cir_code 
                    AND B.mouza_pargona_code = A.mouza_pargona_code 
                    AND B.lot_no = A.lot_no 
                    AND B.vill_townprt_code = A.vill_townprt_code 
                    AND B.patta_type_code = A.patta_type_code 
                    AND B.patta_no = A.patta_no 
                    AND B.financial_year IN (
                        SELECT DISTINCT financial_year 
                        FROM $table_name 
                        WHERE dist_code = ? 
                        ORDER BY financial_year DESC 
                        LIMIT 5
                    ) 
                    AND CAST(B.year_arrear AS NUMERIC) > 0
                ) = 5
                OR (
                    SELECT SUM(CAST(C.year_arrear AS NUMERIC)) 
                    FROM $table_name C 
                    WHERE C.dist_code = A.dist_code 
                    AND C.subdiv_code = A.subdiv_code 
                    AND C.cir_code = A.cir_code 
                    AND C.mouza_pargona_code = A.mouza_pargona_code 
                    AND C.lot_no = A.lot_no 
                    AND C.vill_townprt_code = A.vill_townprt_code 
                    AND C.patta_type_code = A.patta_type_code 
                    AND C.patta_no = A.patta_no 
                ) > 1000
            )
            AND (J.patta_no IS NULL OR J.pay_status = 'UNPAID')
        ";

        return $this->db->query($query, [$dist_code, $dist_code])->row()->patta_count;
    }

    public function get_dp_demand_notice_list_by_district($dist_code, $direct_paying = false) {
        $table_name = 'ekhajana_year_wise_arrear_dp_estate';

        $query = "
            SELECT DISTINCT A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code, 
                            A.lot_no, A.vill_townprt_code, A.patta_type_code, A.patta_no 
            FROM $table_name A
            LEFT JOIN jama_wasil J 
                ON A.dist_code = J.dist_code 
                AND A.subdiv_code = J.subdiv_code 
                AND A.cir_code = J.cir_code 
                AND A.mouza_pargona_code = J.mouza_pargona_code 
                AND A.lot_no = J.lot_no 
                AND A.vill_townprt_code = J.vill_townprt_code 
                AND A.patta_type_code = J.patta_type_code 
                AND A.patta_no = J.patta_no 
            WHERE A.dist_code = ? and A.notice_generated is null
            AND (
                (
                    SELECT COUNT(*) 
                    FROM $table_name B 
                    WHERE B.dist_code = A.dist_code 
                    AND B.subdiv_code = A.subdiv_code 
                    AND B.cir_code = A.cir_code 
                    AND B.mouza_pargona_code = A.mouza_pargona_code 
                    AND B.lot_no = A.lot_no 
                    AND B.vill_townprt_code = A.vill_townprt_code 
                    AND B.patta_type_code = A.patta_type_code 
                    AND B.patta_no = A.patta_no 
                    AND B.financial_year IN (
                        SELECT DISTINCT financial_year 
                        FROM $table_name 
                        WHERE dist_code = ? 
                        ORDER BY financial_year DESC 
                        LIMIT 5
                    ) 
                    AND CAST(B.year_arrear AS NUMERIC) > 0
                ) = 5
                OR (
                    SELECT SUM(CAST(C.year_arrear AS NUMERIC)) 
                    FROM $table_name C 
                    WHERE C.dist_code = A.dist_code 
                    AND C.subdiv_code = A.subdiv_code 
                    AND C.cir_code = A.cir_code 
                    AND C.mouza_pargona_code = A.mouza_pargona_code 
                    AND C.lot_no = A.lot_no 
                    AND C.vill_townprt_code = A.vill_townprt_code 
                    AND C.patta_type_code = A.patta_type_code 
                    AND C.patta_no = A.patta_no 
                ) > 1000
            )
            AND (J.patta_no IS NULL OR J.pay_status = 'UNPAID')
        ";

        // Parameters: dist_code (main query) and dist_code (subquery for financial_year)
        return $this->db->query($query, [$dist_code, $dist_code])->result();
    }

    public function getArrearDetailsDpEstate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no) {
        $query = "(
                SELECT financial_year, year_revenue, year_tax 
                FROM ekhajana_year_wise_arrear_dp_estate 
                WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
                AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
                ORDER BY financial_year DESC 
                LIMIT 5
            )
            UNION ALL
            (
                SELECT CONCAT('Prior to ', MAX(financial_year)) AS financial_year, 
                    SUM(year_revenue) AS year_revenue, 
                    SUM(year_tax) AS year_tax 
                FROM ekhajana_year_wise_arrear_dp_estate 
                WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
                AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
                AND financial_year NOT IN (
                    SELECT financial_year FROM ekhajana_year_wise_arrear_dp_estate 
                    WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? 
                    AND lot_no = ? AND vill_townprt_code = ? AND patta_type_code = ? AND patta_no = ? 
                    ORDER BY financial_year DESC LIMIT 5
                )
            );
        ";
        
        $records =  $this->db->query($query, array_merge(
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no],
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no],
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_townprt_code, $patta_type_code, $patta_no]
        ))->result();

        return array_reverse($records);
    }

    public function get_dp_demand_notice_generated_by_district($dist_code)
    {
        $query = $this->db->query("select * from dp_demand_notice_delivery_docs where dist_code=? and status =?",array($dist_code,'G'));
        if($query->num_rows() ==0)
        {
            return [];
        }else{
             return $query->result();
        }
    }

    public function get_demand_notice_generated_count($dist_code,$direct_paying)
    {
        $table_name = $direct_paying ? 'dp_demand_notice_delivery_docs' : 'non_dp_demand_notice_delivery_docs';
        // return $table_name;
        $query = $this->db->query("select count(id) as count from $table_name where dist_code=? and status=?",array($dist_code,'G'));
        if($query->num_rows() == 0){
            return 0;
        }else{
            return $query->row()->count;
        }
    }




}

