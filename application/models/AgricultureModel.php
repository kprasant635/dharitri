<?php
class AgricultureModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        // $this->dist_code = $this->session->userdata('dist_code');
        // $this->load->library('AES');
    }

   public function getDagsCount($type = null)
{
    $selectExtra = '';
    if ($type == 'list') {
        $selectExtra = "
            COALESCE(a.dist_code, p.dist_code) AS dist_code,
            COALESCE(a.subdiv_code, p.subdiv_code) AS subdiv_code,
            COALESCE(a.cir_code, p.cir_code) AS cir_code,
            COALESCE(a.mouza_pargona_code, p.mouza_pargona_code) AS mouza_pargona_code,
            COALESCE(a.lot_no, p.lot_no) AS lot_no,
            COALESCE(a.vill_townprt_code, p.vill_townprt_code) AS vill_townprt_code,
        ";
    }

    $query = "
        WITH agri_dags_cte AS (
            SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
                   COUNT(*) AS agri_dags
            FROM chitha_basic_mat_view
            WHERE land_type = '01'
              AND patta_type_code IN (
                  SELECT type_code FROM patta_code WHERE jamabandi = 'y'
              )
            GROUP BY vill_townprt_code, lot_no, mouza_pargona_code, cir_code, subdiv_code, dist_code
        ),
        pattadars_cte AS (
            SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
                   COUNT(*) AS pattadars_count
            FROM chitha_pattadars_mat_view
            WHERE patta_type_code IN (
                SELECT type_code FROM patta_code WHERE jamabandi = 'y'
            )
            AND land_class_code in (select class_code from landclass_code where class_code_cat='01')
            GROUP BY vill_townprt_code, lot_no, mouza_pargona_code, cir_code, subdiv_code, dist_code
        )
        SELECT
            (SELECT loc_name
             FROM location
             WHERE dist_code = a.dist_code
               AND subdiv_code = a.subdiv_code
               AND cir_code = a.cir_code
               AND mouza_pargona_code = '00') AS cir_name,
            (SELECT loc_name
             FROM location
             WHERE dist_code = a.dist_code
               AND subdiv_code = a.subdiv_code
               AND cir_code = a.cir_code
               AND mouza_pargona_code = a.mouza_pargona_code
               AND lot_no = a.lot_no
               AND vill_townprt_code = a.vill_townprt_code) AS vill_name,
            $selectExtra
            a.agri_dags AS dags_count,
            p.pattadars_count
        FROM agri_dags_cte a
        FULL OUTER JOIN pattadars_cte p
            ON a.dist_code = p.dist_code
           AND a.subdiv_code = p.subdiv_code
           AND a.cir_code = p.cir_code
           AND a.mouza_pargona_code = p.mouza_pargona_code
           AND a.lot_no = p.lot_no
           AND a.vill_townprt_code = p.vill_townprt_code
        ORDER BY COALESCE(a.dist_code, p.dist_code),
                 COALESCE(a.subdiv_code, p.subdiv_code),
                 COALESCE(a.cir_code, p.cir_code)
    ";

    if ($type == 'list') {
        return $this->db->query($query)->result();
    }

    return $this->db->query($query)->result_array();
}

public function getPattadarsCount($vill_code,$lot_no,$mouza_code,$cir_code,$subdiv_code,$dist_code,$type=null){
    $query = "
            select dag_no,patta_no,(Select patta_type from patta_code where type_code=patta_type_code) as patta_type ,pdar_name,pdar_father as father_name from chitha_pattadars_mat_view
            where patta_type_code in (Select type_code from patta_code where jamabandi='y')
            AND land_class_code in (select class_code from landclass_code where class_code_cat='01')
            AND vill_townprt_code='$vill_code' AND lot_no='$lot_no' AND  mouza_pargona_code='$mouza_code' AND  cir_code='$cir_code'
            AND  subdiv_code ='$subdiv_code' AND  dist_code='$dist_code'
            order by dag_no,patta_no,patta_type_code,pdar_id
        ";
       if ($type == 'list') {
        return $this->db->query($query)->result();
    }

    return $this->db->query($query)->result_array();
}

}