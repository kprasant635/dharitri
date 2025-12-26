<?php
class ReportModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    function PattadarSQL_old()
    {
        $sql = "
            SELECT 
                dist.loc_name AS district_name,
                circ.loc_name AS circle_name,
            l.loc_name AS village_name,
                res.uuid,
                res.cnt 
            FROM (
                SELECT c.uuid, COUNT(*) AS cnt
                FROM (
                    SELECT dist_code,
                        subdiv_code,
                        cir_code,
                        mouza_pargona_code,
                        lot_no,
                        vill_townprt_code,
                        patta_type_code,
                        patta_no,
                        pdar_id,
                        date_entry,
                        created_on
                    FROM chitha_pattadar
                    WHERE DATE(date_entry) > '2023-07-01'
                ) cp
                JOIN (
                    SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id) *
                    FROM chitha_pattadars_mat_view
                    WHERE land_class_code IN (
                        SELECT class_code 
                        FROM landclass_code 
                        WHERE class_code_cat = '01' 
                    )
                ) c 
                ON cp.dist_code||cp.subdiv_code||cp.cir_code||cp.mouza_pargona_code||cp.lot_no||cp.vill_townprt_code||cp.patta_type_code||cp.patta_no||cp.pdar_id
                = c.dist_code||c.subdiv_code||c.cir_code||c.mouza_pargona_code||c.lot_no||c.vill_townprt_code||c.patta_type_code||c.patta_no||c.pdar_id
                GROUP BY c.uuid
            ) res
            JOIN location l 
            ON res.uuid = l.uuid
            JOIN location circ 
            ON l.dist_code = circ.dist_code
            AND l.subdiv_code = circ.subdiv_code
            AND l.cir_code = circ.cir_code
            AND circ.mouza_pargona_code = '00'
            AND circ.lot_no = '00'
            AND circ.vill_townprt_code = '00000'
            JOIN location dist
            ON l.dist_code = dist.dist_code
            AND dist.subdiv_code = '00'
            AND dist.cir_code = '00'
            AND dist.mouza_pargona_code = '00'
            AND dist.lot_no = '00'
            AND dist.vill_townprt_code = '00000'
        ";
        return $sql;
    }

    function PattadarDetailsSQL_OLD()
    {
        $sql = "
            SELECT 
                ld.loc_name   AS dist_name,   
                ls.loc_name   AS subdiv_name, 
                lc.loc_name   AS cir_name,    
                lm.loc_name   AS mouza_name,  
                ll.loc_name   AS lot_name,    
                lv.loc_name   AS village_name,
                pc.patta_type,
                cp.patta_no,
                cp.pdar_id,
                c.dag_no,
                lcc.land_type,
                c.uuid,
                c.pdar_name,
                c.pdar_father
            FROM (
                SELECT dist_code,
                    subdiv_code,
                    cir_code,
                    mouza_pargona_code,
                    lot_no,
                    vill_townprt_code,
                    patta_type_code,
                    patta_no,
                    pdar_id,
                    date_entry,
                    created_on
                FROM chitha_pattadar
                WHERE DATE(date_entry) > '2023-07-01'
            ) cp
            JOIN (
                SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id) *
                FROM chitha_pattadars_mat_view
                WHERE land_class_code IN (
                    SELECT class_code 
                    FROM landclass_code 
                    WHERE class_code_cat = '01'
                )
            ) c 
            ON cp.dist_code||cp.subdiv_code||cp.cir_code||cp.mouza_pargona_code||cp.lot_no||cp.vill_townprt_code||cp.patta_type_code||cp.patta_no||cp.pdar_id
            = c.dist_code||c.subdiv_code||c.cir_code||c.mouza_pargona_code||c.lot_no||c.vill_townprt_code||c.patta_type_code||c.patta_no||c.pdar_id

            -- Location joins
            LEFT JOIN location ld 
                ON ld.dist_code = cp.dist_code 
                AND ld.subdiv_code = '00'
                AND ld.cir_code = '00'
                AND ld.mouza_pargona_code = '00'
                AND ld.lot_no = '00'
                AND ld.vill_townprt_code = '00000'

            LEFT JOIN location ls 
                ON ls.dist_code = cp.dist_code 
                AND ls.subdiv_code = cp.subdiv_code
                AND ls.cir_code = '00'
                AND ls.mouza_pargona_code = '00'
                AND ls.lot_no = '00'
                AND ls.vill_townprt_code = '00000'

            LEFT JOIN location lc 
                ON lc.dist_code = cp.dist_code 
                AND lc.subdiv_code = cp.subdiv_code
                AND lc.cir_code = cp.cir_code
                AND lc.mouza_pargona_code = '00'
                AND lc.lot_no = '00'
                AND lc.vill_townprt_code = '00000'

            LEFT JOIN location lm 
                ON lm.dist_code = cp.dist_code 
                AND lm.subdiv_code = cp.subdiv_code
                AND lm.cir_code = cp.cir_code
                AND lm.mouza_pargona_code = cp.mouza_pargona_code
                AND lm.lot_no = '00'
                AND lm.vill_townprt_code = '00000'

            LEFT JOIN location ll 
                ON ll.dist_code = cp.dist_code 
                AND ll.subdiv_code = cp.subdiv_code
                AND ll.cir_code = cp.cir_code
                AND ll.mouza_pargona_code = cp.mouza_pargona_code
                AND ll.lot_no = cp.lot_no
                AND ll.vill_townprt_code = '00000'

            LEFT JOIN location lv 
                ON lv.dist_code = cp.dist_code 
                AND lv.subdiv_code = cp.subdiv_code
                AND lv.cir_code = cp.cir_code
                AND lv.mouza_pargona_code = cp.mouza_pargona_code
                AND lv.lot_no = cp.lot_no
                AND lv.vill_townprt_code = cp.vill_townprt_code
            
            LEFT JOIN patta_code pc
                on pc.type_code =cp.patta_type_code
            
            LEFT JOIN landclass_code lcc
                on lcc.class_code = c.land_class_code

            WHERE c.uuid = ?
            ORDER BY c.uuid, c.dag_no;

        ";
        return $sql;
    }

    // function PattadarDetailsSQL()
    // {
    //     $sql = "
    //         WITH cp AS (
    //         SELECT
    //             dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
    //             patta_type_code, patta_no, pdar_id, date_entry, created_on
    //         FROM chitha_pattadar
            
    //         WHERE (date_entry  > DATE '2023-07-01')
    //         ),
    //         lc AS (
    //         SELECT class_code,land_type
    //         FROM landclass_code
    //         WHERE class_code_cat = '01'
    //         ),
    //         c AS (
    //         SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id)
    //                 uuid, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
    //                 patta_type_code, patta_no, dag_no, pdar_id, pdar_name, pdar_father, land_class_code
    //         FROM chitha_pattadars_mat_view m
    //         WHERE m.land_class_code IN (SELECT class_code FROM lc)  
    //         )
    //         SELECT
    //         c.uuid, 
    //         (select loc_name from location l where l.dist_code=c.dist_code and subdiv_code='00') as dist_name,
    //         (select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code='00') as cir_name,
    //         (select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code=c.mouza_pargona_code and l.lot_no='00') as mouza_name,
    //         (select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code=c.mouza_pargona_code and l.lot_no=c.lot_no and l.vill_townprt_code='00000') as lot_name,
    //         (select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code=c.mouza_pargona_code and l.lot_no=c.lot_no and l.vill_townprt_code=c.vill_townprt_code) as village_name,
    //         (select patta_type from patta_code where type_code=c.patta_type_code) as patta_type,
    //         (select land_type from landclass_code where class_code=c.land_class_code),
    //         c.patta_no, c.pdar_id, c.dag_no, c.pdar_name, c.pdar_father,
    //         cp.date_entry, cp.created_on
    //         FROM cp
    //         JOIN c
    //         ON  cp.dist_code           = c.dist_code
    //         AND cp.subdiv_code         = c.subdiv_code
    //         AND cp.cir_code            = c.cir_code
    //         AND cp.mouza_pargona_code  = c.mouza_pargona_code
    //         AND cp.lot_no              = c.lot_no
    //         AND cp.vill_townprt_code   = c.vill_townprt_code
    //         AND cp.patta_type_code     = c.patta_type_code
    //         AND cp.patta_no            = c.patta_no
    //         AND cp.pdar_id             = c.pdar_id
    //         WHERE c.uuid = ?
    //         ORDER BY c.uuid, c.dag_no;

    //     ";
    //     return $sql;
    // }


    function PattadarDetailsSQL()
    {
        $sql = "
            WITH 
            cp AS (
                SELECT
                    dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
                    patta_type_code, patta_no, pdar_id, date_entry, created_on
                FROM chitha_pattadar
                WHERE (date_entry > DATE '2023-07-01')
            ),
            lc AS (
                SELECT class_code, land_type
                FROM landclass_code
                WHERE class_code_cat = '01'
            ),
            c AS (
                SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id)
                    uuid, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
                    patta_type_code, patta_no, dag_no, pdar_id, pdar_name, pdar_father, land_class_code
                FROM chitha_pattadars_mat_view m
                WHERE m.land_class_code IN (SELECT class_code FROM lc)
            )

            SELECT DISTINCT ON (uuid, dag_no, pdar_id)
                *
            FROM (
                -- 🔹 First query
                SELECT  
                    cbm.uuid,
                    (SELECT loc_name FROM location l WHERE l.dist_code = cbm.dist_code AND l.subdiv_code = '00') AS dist_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = cbm.dist_code AND l.subdiv_code = cbm.subdiv_code AND l.cir_code = cbm.cir_code AND l.mouza_pargona_code = '00') AS cir_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = cbm.dist_code AND l.subdiv_code = cbm.subdiv_code AND l.cir_code = cbm.cir_code AND l.mouza_pargona_code = cbm.mouza_pargona_code AND l.lot_no = '00') AS mouza_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = cbm.dist_code AND l.subdiv_code = cbm.subdiv_code AND l.cir_code = cbm.cir_code AND l.mouza_pargona_code = cbm.mouza_pargona_code AND l.lot_no = cbm.lot_no AND l.vill_townprt_code = '00000') AS lot_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = cbm.dist_code AND l.subdiv_code = cbm.subdiv_code AND l.cir_code = cbm.cir_code AND l.mouza_pargona_code = cbm.mouza_pargona_code AND l.lot_no = cbm.lot_no AND l.vill_townprt_code = cbm.vill_townprt_code) AS village_name,
                    (SELECT patta_type FROM patta_code WHERE type_code = cbm.patta_type_code) AS patta_type,
                    (SELECT land_type FROM landclass_code WHERE class_code = cbm.land_class_code) AS land_type,
                    cbm.patta_no,
                    cpm.pdar_id,
                    cbm.dag_no,
                    cpm.pdar_name,
                    cpm.pdar_father,
                    NULL AS date_entry,
                    NULL AS created_on
                FROM chitha_basic_mat_view cbm
                JOIN chitha_pattadars_mat_view cpm 
                    ON cbm.uuid = cpm.uuid AND cbm.dag_no = cpm.dag_no
                WHERE EXISTS (
                    SELECT 1 FROM landclass_code lc
                    WHERE lc.class_code = cbm.land_class_code 
                    AND (lc.land_type LIKE 'বাৰী%' OR lc.land_type LIKE 'বাড়ী%')
                )
                AND cbm.uuid = ?
                AND cbm.rural_urban = 'R'

                UNION ALL

                -- 🔹 Second query
                SELECT
                    c.uuid,
                    (SELECT loc_name FROM location l WHERE l.dist_code = c.dist_code AND subdiv_code='00') AS dist_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = c.dist_code AND l.subdiv_code = c.subdiv_code AND l.cir_code = c.cir_code AND l.mouza_pargona_code='00') AS cir_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = c.dist_code AND l.subdiv_code = c.subdiv_code AND l.cir_code = c.cir_code AND l.mouza_pargona_code = c.mouza_pargona_code AND l.lot_no='00') AS mouza_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = c.dist_code AND l.subdiv_code = c.subdiv_code AND l.cir_code = c.cir_code AND l.mouza_pargona_code = c.mouza_pargona_code AND l.lot_no = c.lot_no AND l.vill_townprt_code='00000') AS lot_name,
                    (SELECT loc_name FROM location l WHERE l.dist_code = c.dist_code AND l.subdiv_code = c.subdiv_code AND l.cir_code = c.cir_code AND l.mouza_pargona_code = c.mouza_pargona_code AND l.lot_no = c.lot_no AND l.vill_townprt_code = c.vill_townprt_code) AS village_name,
                    (SELECT patta_type FROM patta_code WHERE type_code = c.patta_type_code) AS patta_type,
                    (SELECT land_type FROM landclass_code WHERE class_code = c.land_class_code) AS land_type,
                    c.patta_no,
                    c.pdar_id,
                    c.dag_no,
                    c.pdar_name,
                    c.pdar_father,
                    cp.date_entry,
                    cp.created_on
                FROM cp
                JOIN c
                ON  cp.dist_code = c.dist_code
                AND cp.subdiv_code = c.subdiv_code
                AND cp.cir_code = c.cir_code
                AND cp.mouza_pargona_code = c.mouza_pargona_code
                AND cp.lot_no = c.lot_no
                AND cp.vill_townprt_code = c.vill_townprt_code
                AND cp.patta_type_code = c.patta_type_code
                AND cp.patta_no = c.patta_no
                AND cp.pdar_id = c.pdar_id
                WHERE c.uuid = ?
            ) AS unified
            ORDER BY uuid, dag_no;
        ";
        return $sql;
    }


    function PattadarSQL_before_marge()
    {
        $sql = "
            WITH cp AS (
                SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
                    vill_townprt_code, patta_type_code, patta_no, pdar_id, date_entry, created_on
                FROM chitha_pattadar
                WHERE (date_entry > DATE '2023-07-01')
            ),
            lc AS (
                SELECT class_code, land_type
                FROM landclass_code
                WHERE class_code_cat = '01'
            ),
            c AS (
                SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id)
                    uuid, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
                    vill_townprt_code, patta_type_code, patta_no, dag_no, pdar_id, 
                    pdar_name, pdar_father, land_class_code
                FROM chitha_pattadars_mat_view m
                WHERE m.land_class_code IN (SELECT class_code FROM lc)
            )
            SELECT 
                c.uuid,
                MAX((select loc_name from location l where l.dist_code=c.dist_code and subdiv_code='00')) as district_name,
                MAX((select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code='00')) as circle_name,
                MAX((select loc_name from location l where l.dist_code=c.dist_code and l.subdiv_code=c.subdiv_code and l.cir_code=c.cir_code and l.mouza_pargona_code=c.mouza_pargona_code and l.lot_no=c.lot_no and l.vill_townprt_code=c.vill_townprt_code)) as village_name,
                c.uuid,
                COUNT(*) AS cnt
            FROM cp
            JOIN c ON cp.dist_code = c.dist_code
                AND cp.subdiv_code = c.subdiv_code
                AND cp.cir_code = c.cir_code
                AND cp.mouza_pargona_code = c.mouza_pargona_code
                AND cp.lot_no = c.lot_no
                AND cp.vill_townprt_code = c.vill_townprt_code
                AND cp.patta_type_code = c.patta_type_code
                AND cp.patta_no = c.patta_no
                AND cp.pdar_id = c.pdar_id
            GROUP BY c.uuid;
        ";
        return $sql;
    }

    function PattadarSQL(){
        $sql = "WITH 
                cp AS (
                    SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
                        vill_townprt_code, patta_type_code, patta_no, pdar_id, date_entry, created_on
                    FROM chitha_pattadar
                    WHERE date_entry > DATE '2023-07-01'
                ),
                lc AS (
                    SELECT class_code, land_type
                    FROM landclass_code
                    WHERE class_code_cat = '01'
                ),
                c AS (
                    SELECT DISTINCT ON (uuid, patta_type_code, patta_no, dag_no, pdar_id)
                        uuid, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
                        vill_townprt_code, patta_type_code, patta_no, dag_no, pdar_id, 
                        pdar_name, pdar_father, land_class_code
                    FROM chitha_pattadars_mat_view m
                    WHERE m.land_class_code IN (SELECT class_code FROM lc)
                ),
                two_years AS (
                    SELECT 
                        c.uuid,
                        MAX((SELECT loc_name FROM location l 
                            WHERE l.dist_code=c.dist_code AND l.subdiv_code='00')) AS district_name,
                        MAX((SELECT loc_name FROM location l 
                            WHERE l.dist_code=c.dist_code AND l.subdiv_code=c.subdiv_code 
                            AND l.cir_code=c.cir_code AND l.mouza_pargona_code='00')) AS circle_name,
                        MAX((SELECT loc_name FROM location l 
                            WHERE l.dist_code=c.dist_code AND l.subdiv_code=c.subdiv_code 
                            AND l.cir_code=c.cir_code AND l.mouza_pargona_code=c.mouza_pargona_code 
                            AND l.lot_no=c.lot_no AND l.vill_townprt_code=c.vill_townprt_code)) AS village_name,
                        COUNT(*) AS two_years_count
                    FROM cp
                    JOIN c ON cp.dist_code = c.dist_code
                        AND cp.subdiv_code = c.subdiv_code
                        AND cp.cir_code = c.cir_code
                        AND cp.mouza_pargona_code = c.mouza_pargona_code
                        AND cp.lot_no = c.lot_no
                        AND cp.vill_townprt_code = c.vill_townprt_code
                        AND cp.patta_type_code = c.patta_type_code
                        AND cp.patta_no = c.patta_no
                        AND cp.pdar_id = c.pdar_id
                    GROUP BY c.uuid
                ),
                base AS (
                    SELECT 
                        cbm.uuid,
                        cbm.dist_code,
                        cbm.subdiv_code,
                        cbm.cir_code,
                        cbm.mouza_pargona_code,
                        cbm.lot_no,
                        cbm.vill_townprt_code,
                        COUNT(*) AS bari_count
                    FROM chitha_basic_mat_view cbm
                    JOIN chitha_pattadars_mat_view cpm 
                    ON cbm.uuid = cpm.uuid 
                    AND cbm.dag_no = cpm.dag_no
                    WHERE EXISTS (
                        SELECT 1 
                        FROM landclass_code lc
                        WHERE lc.class_code = cbm.land_class_code 
                        AND (lc.land_type LIKE 'বাৰী%' OR lc.land_type LIKE 'বাড়ী%')
                    )
                    AND cbm.rural_urban = 'R'
                    GROUP BY 
                        cbm.uuid, cbm.dist_code, cbm.subdiv_code, cbm.cir_code, 
                        cbm.mouza_pargona_code, cbm.lot_no, cbm.vill_townprt_code
                ),
                bari AS (
                    SELECT 
                        b.uuid,
                        (SELECT loc_name 
                        FROM location 
                        WHERE dist_code = b.dist_code 
                        AND subdiv_code = '00') AS district_name,
                        (SELECT loc_name 
                        FROM location 
                        WHERE dist_code = b.dist_code 
                        AND subdiv_code = b.subdiv_code 
                        AND cir_code = b.cir_code 
                        AND mouza_pargona_code = '00') AS circle_name,
                        (SELECT loc_name 
                        FROM location 
                        WHERE dist_code = b.dist_code 
                        AND subdiv_code = b.subdiv_code 
                        AND cir_code = b.cir_code 
                        AND mouza_pargona_code = b.mouza_pargona_code 
                        AND lot_no = b.lot_no 
                        AND vill_townprt_code = b.vill_townprt_code) AS village_name,
                        b.bari_count
                    FROM base b
                )
                SELECT 
                    COALESCE(t.uuid, b.uuid) AS uuid,
                    COALESCE(t.district_name, b.district_name) AS district_name,
                    COALESCE(t.circle_name, b.circle_name) AS circle_name,
                    COALESCE(t.village_name, b.village_name) AS village_name,
                    t.two_years_count,
                    b.bari_count
                FROM two_years t
                FULL OUTER JOIN bari b ON t.uuid = b.uuid;
";
        return $sql;
    }
}