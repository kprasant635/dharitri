<?php


if (!function_exists('encodeData')) {
    function encodeData($data) {
        if (empty($data)) {
            return null;
        }
        $json = json_encode($data, JSON_UNESCAPED_SLASHES);
        $compressed = gzcompress($json, 9);
        $base_64 =  base64_encode($compressed);
        return $base_64;
    }
}

if (!function_exists('decodeData')) {
    function decodeData($encoded) {
        if (empty($encoded)) {
            return null;
        }
        $compressed = base64_decode($encoded);
        $json = gzuncompress($compressed);
        return json_decode($json, true);
    }
}


if (!function_exists('checkFarmID')) {
    function checkFarmID($db,$lgd_code, $dag_no) {
        $CI =& get_instance();
        $CI->agri_stack_db = $CI->load->database('agri_stack', TRUE);

        $query = $CI->agri_stack_db->get_where('farmid', [
            'lgd_code' => $lgd_code,
            'plot_no'   => $dag_no
        ]);

        // $chitha_basic = $db->get_where('chitha_basic_mat_view', [
        //         'lgd_code' => $lgd_code,
        //         'lot_no'   => $dag_no
        //     ]); chitha_basic

        $q1 = "SELECT *
                FROM chitha_basic_mat_view
                WHERE land_type = '01' AND lgd_code ='$lgd_code' AND dag_no ='$dag_no'
                AND patta_type_code IN (
                    SELECT type_code FROM patta_code WHERE jamabandi = 'y' 
                )";
        $q2 = "SELECT *
                FROM chitha_pattadars_mat_view
                WHERE lgd_code ='$lgd_code' AND dag_no ='$dag_no' AND patta_type_code IN (
                    SELECT type_code FROM patta_code WHERE jamabandi = 'y'
                )
                AND land_class_code in (select class_code from landclass_code where class_code_cat='01')";
        $chitha_basic = $db->query($q1)->result();
        $chitha_pattadars = $db->query($q2)->result();

        // var_dump($chitha_basic);die;
    
        $dag_details = null; $patta_details=null;
        if (!empty($chitha_basic)) {
            $dag_details = encodeData($chitha_basic);
            // echo $dag_details;die;
        }

        if (!empty($chitha_pattadars)) {
            $patta_details = encodeData($chitha_pattadars);
        }

        if ($query->num_rows() > 0) {
            $data = [
                'lgd_code' => $lgd_code,
                'dag_no' => $dag_no,
                'dag_details' => $dag_details,
                'patta_details' => $patta_details,
                'status' => "fount",
            ];
            $db->insert('agri_stack_search', $data);
            // echo $db->last_query();
            // die;
            return "FOUND";
        }else{
            
            $data = [
                'lgd_code' => $lgd_code,
                'dag_no' => $dag_no,
                'dag_details' => $dag_details,
                'patta_details' => $patta_details,
                'status' => "not_fount"
            ];
            // var_dump($data);die;
            $db->insert('agri_stack_search', $data);
            // echo $db->last_query();die;
        }

        return "NOT FOUND";
    }
}

?>

