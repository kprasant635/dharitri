<?php

class ServicePlusModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function count_online_ror_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."ror/recieve_ror_cases_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }
    
    public function count_online_mutation_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."mutation/recieve_mutation_cases_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }
    public function count_online_os_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."mutation_order/recieve_mutation_order_cases_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }
    public function count_online_partition_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."partition/recieve_partition_cases_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }
    //#START PLB
    public function getRoRCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $sql = "select count(*) AS cnt from cert_application where status='B' and co_comment is not null and service_status='R'
        and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $result = $this->db->query($sql);
        return $result->row()->cnt;
    }
    //#END PLB
    function rtpsMobile($appl_no)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mobileApi.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'appl_no' => $appl_no                
        )));
        $result = curl_exec($curl_handle);
        $decoded = json_decode($result);            
        $mobile_no = "";
        if ($decoded->response == '0')
        {
            $mobile_no = json_decode($decoded->data)->data->Phone_no;
        }
        else
        {
            $mobile_no = null;
        }
        return $mobile_no;            
    }
    public function total_partition_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."partition/total_ofc_partition_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $sql1="Select distinct on (application_ref_no) * from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and  mut_type='04' and status ='P' and applid is not null ";
        $numRows=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code ));
        $sql2="Select distinct on (application_ref_no) * from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and  mut_type='04' and status in ('F','D') and applid is not null ";
        $numRowss=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code ));
        return array('total'=>$output,'pending'=>$numRows->num_rows(),'register'=>$this->count_online_partition_cases(),'final'=>$numRowss->num_rows());
        // if($numRows->num_rows()>0){
            
        // }else{
        //     return array('total'=>$output,'pending'=>0,'register'=>$this->count_online_partition_cases());
        // }
    }
    public function total_mutation_cases() {
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $url = RTPS_LINK."mutation/total_ofc_mutation_count.php?dist=" . $dist_code . "&sub=" . $subdiv_code . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."application".$application_no."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        curl_close($ch);
        
        $output = json_decode($output);
        $sql1="Select distinct on (application_ref_no) * from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and mut_type='03' and (status ='P' or status is null) and applid is not null  ";
        $numRows=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code));
        //echo $this->db->last_query();
        $sql2="Select distinct on (application_ref_no) * from petition_basic where dist_code=? and subdiv_code=? and cir_code=? and mut_type='03' and status in ('F') and applid is not null ";
        $numRowss=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code ));
        return array('total'=>$output,
            'pending'=>$numRows->num_rows(),
            'register'=>$this->count_online_mutation_cases(),
            'final'=>$numRowss->num_rows()
        );
        // if($numRows->num_rows()>0){
            
        // }else{
        //     return array('total'=>$output,'pending'=>0,'register'=>$this->count_online_mutation_cases());
        // }
    }
}
