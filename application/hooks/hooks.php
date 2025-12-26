<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class hooks {

    function checkLogin() {
        $this->CI = &get_instance();
        //log_message('error',"##########".$this->CI->router->fetch_class());
        if (($this->CI->session->userdata('user_code') == null)&&
			($this->CI->router->fetch_class()!='login') &&
			($this->CI->router->fetch_class()!='portal')&&
			($this->CI->router->fetch_class()!='Portal')&&
			($this->CI->router->fetch_class()!='Utility')&&
			($this->CI->router->fetch_class()!='utility') &&
            ($this->CI->router->fetch_class()!='apiJamabandiResponse') &&
            ($this->CI->router->fetch_class()!='apiJamabandiResponse') && 
            ($this->CI->router->fetch_class()!='dharitreeApi') && 
            ($this->CI->router->fetch_class()!='DharitreeApi')){
            redirect(base_url() . "index.php/login/index");
        }
        //$this->logQueries();
    }

    function logQueries() {

        $CI = & get_instance();
       
        $filepath = APPPATH . 'logs/Query-log-' . date('Y-m-d') . '.php'; // Creating Query Log file with today's date in application/logs folder
        $handle = fopen($filepath, "a+");                 // Opening file with pointer at the end of the file

        $times = $CI->db->query_times;                   // Get execution time of all the queries executed by controller
        foreach ($CI->db->queries as $key => $query) {
            $sql = $query . " \n Execution Time:" . $times[$key]."\t from ip ->". $_SERVER['REMOTE_ADDR']; // Generating SQL file alongwith execution time
            fwrite($handle, $sql . "\n\n");              // Writing it in the log file
        }

        fclose($handle);      // Close the file
    }
    
    function dothisthat(){
        
    }

}
