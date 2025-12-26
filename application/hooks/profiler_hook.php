<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function profiler_hook() {
    //$CI = & get_instance();
    log_message('info', 'GET --> ' . var_export($CI->input->get(null), true));
    log_message('info', 'POST --> ' . var_export($CI->input->post(null), true));
    log_message('info', '$_SERVER -->' . var_export($_SERVER, true));

    foreach($_POST as $key=>$value){
          $_POST[$key] = $CI->security->xss_clean($CI->db->escape_str($value));
     }     
    
}

function checkLogin(){
    $CI = &get_instance();
    if($CI->session->userdata('user_code')==null){
        redirect(base_url()."login/index");
    }
    echo "Hok";
}

function check_auth() {
    $CI = & get_instance();
    $route_class = $CI->router->fetch_class();
    $route_method = $CI->router->fetch_method();
    $route_class = $CI->router->fetch_class();
    $route_method = $CI->router->fetch_method();
    $u_d_c = $CI->session->userdata('user_desig_code');
    $district = $CI->db->query("select * from user_permission where controller_name ='$route_class'  and function_name ='$route_method'");
    $result = $district->result();
    $data = array();
    foreach ($result as $rd) {
        $d_code = $rd->user_desig_code;
        $data[] = $d_code;
        //echo $d_code;
    }
    //echo $route_class;
    //echo $route_method;
    //var_dump($data);
    //echo $u_d_c;
    if(($u_d_c == '') && ($route_class == 'login'))
    {
        //echo "ok";
    }
    else 
    {
        if(!in_array($u_d_c, $data))
        {
            die("<h4>Sorry Boss you are restricted to this page...!</h4>");
        }
    }
}

?>

