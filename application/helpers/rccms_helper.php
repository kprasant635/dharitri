<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('include_rccms_view')) {
    function include_rccms_view($params = array())
    {
        $CI =& get_instance();
        if (!empty($params)) {
            $CI->db->where($params);
        }
        $query = $CI->db->get('rccms_cases');
        // echo $CI->db->last_query();
        if ($query->num_rows() > 0) {
            $data['records'] = $query->result_array();
            $CI->load->view('rccms_cases_list', $data);
        }
    }
}


if (!function_exists('map_property_check')) {
    function map_property_check($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        // Get CodeIgniter instance
        $CI =& get_instance();

        // Fetch from location table
        $sql = "SELECT * 
                FROM location 
                WHERE dist_code = ? 
                  AND subdiv_code = ? 
                  AND cir_code = ? 
                  AND mouza_pargona_code = ? 
                  AND lot_no = ? 
                  AND vill_townprt_code = ?";

        $query = $CI->db->query($sql, [
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_townprt_code
        ]);

        $result = $query->row_array();

        // If nc_btad == 'K', update chitha_basic table

        if (!empty($result) && isset($result['nc_btad']) && $result['nc_btad'] === 'K') {
            $sql = "SELECT * 
                    FROM chitha_basic 
                    WHERE dist_code = ? 
                    AND subdiv_code = ? 
                    AND cir_code = ? 
                    AND mouza_pargona_code = ? 
                    AND lot_no = ? 
                    AND vill_townprt_code = ? 
                    AND dag_no = ?";
            $query = $CI->db->query($sql, [
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $lot_no,
                $vill_townprt_code,
                $dag_no
            ]);
            $result_chitha = $query->row_array();
            // var_dump($result_chitha['map_for_property']);die;
            if ($result_chitha['map_for_property'] == 'y') {
                // var_dump("here");
                return 0;
            }
        }
        return 1;
    }
}

if (!function_exists('get_gender')) {
    function get_gender()
    {
        $CI = &get_instance();

        $CI->load->database();

        $query = $CI->db->get('master_gender');
        return $query->result();
    }
}
if (!function_exists('get_relation')) {
    function get_relation()
    {
        $CI = &get_instance();

        $CI->load->database();

        $query = $CI->db->get('master_guard_rel');
        return $query->result();
    }
}
if (!function_exists('get_pattatype')) {
    function get_pattatype()
    {
        $CI = &get_instance();

        $CI->load->database();

        $CI->db->select('type_code,patta_type, pattatype_eng');
        $CI->db->from('patta_code');
        $CI->db->where('jamabandi', 'y');
        $query = $CI->db->get();
        return $query->result();
    }
}
if (!function_exists('get_pattatype_patta_id')) {
    function get_pattatype_patta_id($patta_id)
    {
       
        $CI = &get_instance();
        $CI->load->database();

        $CI->db->select('type_code, patta_type, pattatype_eng');
        $CI->db->from('patta_code');
        $CI->db->where('jamabandi', 'y');
        $CI->db->where('type_code', $patta_id);

        $query = $CI->db->get();
        $final = $query->result_array();
       return $final_data = $final[0]['patta_type'] .'-'. '(' . $final[0]['pattatype_eng'] . ')';
    }
}
if (!function_exists('get_lanclass')) {
    function get_lanclass()
    {
        $CI = &get_instance();

        $CI->load->database();

        $CI->db->select('class_code,land_type, landtype_eng');
        $CI->db->from('landclass_code');
        $query = $CI->db->get();
        return $query->result();
    }
}
if (!function_exists('getUserIP')) {
    function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] == '::1' ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
        }
    }
}

?>