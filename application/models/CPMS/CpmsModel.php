<?php

class CpmsModel extends CI_Model {

    //getting the cpmx matrix
    public function getCpmsMasterTasks(){        
        $query = $this->db->query("select * from cpms_tasks_master");
        return $query->result();
    }
    public function getCpmsMatrix($cpmsTaskId){
        $query = $this->db->query("select * from cpms_matrix where task_id='$cpmsTaskId' order by subtask_id asc");
        return $query->result();
    }
    public function getSubtaskNameFromId($cpmsSubTaskId){
        //return $cpmsSubTaskId;
        $query = $this->db->query("select name from cpms_sub_tasks_master 
            where id='$cpmsSubTaskId'");
        return $query->row()->name;
    }
    //inserting task 1 details 
    public function insertTask1Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm1i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm1i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm1i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm1i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm1i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm1i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm1i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm1i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm1i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm1i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 1 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    //checking data exists or not against user 
    public function checkTask1DataExistsFromUserCode($master_task_id){
        $user_code = (string)$this->session->all_userdata()['user_code'];
        $master_task_id = (int)$master_task_id;
        //return $master_task_id;
        $query = $this->db->query("select count(*) from cpms_task_wise_verification where 
        master_task_id=$master_task_id and user_code='$user_code'");        
        $count = $query->row()->count; 
        if($count == 0){
            return true;
        }else{
            return false;
        }
    }
    //getting subtaskj wise result from the master task id 
    public function getSubTaskWiseResultFromMasterTaskID($master_task_id){
        //return $master_task_id." from the model";
        $user_code = (string)$this->session->all_userdata()['user_code'];
        $master_task_id = (int)$master_task_id;
        $sql = "select * from cpms_subtask_wise_result where master_task_id=? and user_code=?";
        $query = $this->db->query($sql,array($master_task_id, $user_code));
        return $query->result();         
    }
    //getting master task wise result
    public function getMasterTaskWiseResultFromMasterTaskID($master_task_id){
        $user_code = (string)$this->session->all_userdata()['user_code'];
        $master_task_id = (int)$master_task_id;
        $sql = "select * from cpms_master_task_wise_result where master_task_id=? and user_code=?";
        $query = $this->db->query($sql,array($master_task_id, $user_code));
        return $query->row();         
    }
    //inserting task 3 details 
    public function insertTask3Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm3i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm3i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm3i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm3i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm3i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm3i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm3i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm3i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm3i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm3i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 3 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    //inserting task 8 details 
    public function insertTask8Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm8i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm8i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm8i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm8i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm8i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm8i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm8i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm8i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm8i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm8i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 8 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    //inserting task 7 details 
    public function insertTask7Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm7i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm7i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm7i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm7i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm7i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm7i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm7i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm7i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm7i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm7i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 7 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 9 details 
    public function insertTask9Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm9i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm9i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm9i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm9i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm9i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm9i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm9i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm9i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm9i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm9i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 9 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 10 details 
    public function insertTask10Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm10i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm10i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm10i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm10i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm10i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm10i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm10i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm10i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm10i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm10i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 10 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 5 details 
    public function insertTask5Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm5i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm5i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm5i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm5i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm5i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm5i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm5i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm5i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm5i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm5i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 5 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 6 details 
    public function insertTask6Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm6i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm6i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm6i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm6i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm6i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm6i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm6i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm6i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm6i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm6i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 6 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 2 details 
    public function insertTask2Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm2i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm2i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm2i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm2i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm2i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm2i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm2i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm2i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm2i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm2i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 2 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    // inserting task 4 details 
    public function insertTask4Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification){        
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms master task wise result table  
        $tstatus1 = $this->db->insert('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm4i001, Error in insert, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm4i001'];
        }
        //********************************************************/
        //inserting in cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){
            $tstatus2 = $this->db->insert('cpms_subtask_wise_result', $cpms_subtask_wise_result);        
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#cpmsm4i002, Error in insert, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm4i002'];
            }
        }        
        //********************************************************/
        //inserting in cpms user wise result table    
        $tstatus3 = $this->db->insert('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm4i003, Error in insert, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm4i003'];
        }
        //********************************************************/
        //inserting in cpms verificatiuon result table    
        $tstatus4 = $this->db->insert('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsm4i004, Error in insert, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm4i004'];
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsm4i005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsm4i005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 4 Details Added Successfully And Forwarded To ADC!'];
        }  
    }
    //checking form completion 
    public function checkFormCompletion($user_code, $year){
        $query = $this->db->query("select distinct(master_task_id) from 
        cpms_task_wise_verification where user_code=?",array($user_code));
        $master_task_id_list =  $query->result();
        if(count($master_task_id_list) == 10){
            //checking already submitted or not 
            $query = $this->db->query("select count(*) from cpms_proceedings where 
            consultant_uesr_code=?",array($user_code));
            //return $query->row()->count; 
            if($query->row()->count == 0){
                return "completed_and_not_submitted";
            }else{
                return "already_submitted";
            }            
        }else{
            return "forms_not_completed";
        }
    }
    //inserting cpms proceeding 
    public function insertProceeding($cpms_proceeding_data){
        $this->db->trans_begin();         
        //********************************************************/ 
        //inserting in cpms proceedings
        $tstatus1 = $this->db->insert('cpms_proceedings', $cpms_proceeding_data);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsPI001, Error in insert, table 'cpms_proceedings' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsPI001'];
        }
        //********************************************************/
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsPI002, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsPI002'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'CPMS Details Forwarded To ADC!'];
        }  
    }
    //getting consult name 
    public function getConsultantCode($dist_code){    
        $query = $this->db->query("select user_code from loginuser_table lt where dist_code=? and 
        dis_enb_option='E' and user_code like '%DCN%'",array($dist_code));
        return $query->row()->user_code;         
    }
    //getting no of forms completion 
    public function getNoOfFormsCompletionCount($user_code){
        $query = $this->db->query("select distinct(master_task_id) from 
        cpms_task_wise_verification where user_code=?",array($user_code));
        return count($query->result());
    }
    //getting cpms status 
    public function getCpmsStatus($user_code){
        $query = $this->db->query("select * from cpms_proceedings where 
        consultant_uesr_code=?",array($user_code));
        $result= $query->result(); 
        if(count($result) == 0){
            return "NOT-FORWARDED";
        }else if($result[0]->status == 'P'){
            return "PENDING-FOR-APPROVAL";
        }else if($result[0]->status == 'C'){
            return "EVALUATION-COMPLETED";
        }   
    }
    //getting consultant name 
    public function getConsultantName($consultant_code){

        $query = $this->db->query("select u.username as uname from users u join loginuser_table l on l.user_code=u.user_code where l.dis_enb_option='E'
        and l.user_code=?",array($consultant_code));
        return $query->row()->uname;
        
    }
    //getting verification details of cpms 
    public function getCpmsVerificatiuonDetails($consultant_code){
        $query = $this->db->query("select * from cpms_task_wise_verification where user_code=?",array($consultant_code));
        return $query->result();
    }
    //getting master task name from id 
    public function getCpmsMasterTaskName($master_task_id){
        $query = $this->db->query("select * from cpms_tasks_master where id=?",array($master_task_id));
        return $query->row();
    }
    //getting subtaskj wise result from the master task id 
    public function getSubTaskWiseResultFromMasterTaskIDADC($master_task_id, $user_code, $year){        
        $master_task_id = (int)$master_task_id;
        $sql = "select * from cpms_subtask_wise_result where master_task_id=? and user_code=? and year=?";
        $query = $this->db->query($sql,array($master_task_id, $user_code,$year));
        return $query->result();         
    }
    //insertinf details of verification 
    public function verificationDetailsEntry($consultant_code,$year,$cpms_result_array,$verified_marks_with_master_task_id_arr){    
        $this->db->trans_begin();   
        //******************************************************************/
        //inserting in the cpms results table 
        $tstatus1 = $this->db->insert('cpms_result', $cpms_result_array);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#cpmsvcrI001, Error in insert, table 'cpms_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsvcrI001'];
        }
        //******************************************************************/     
        //updating task wise verification table
        foreach($verified_marks_with_master_task_id_arr as $verified_marks_with_master_task_id){
            $update_data = [
                'verified_marks' => $verified_marks_with_master_task_id['verified_marks'],
                'modified_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('master_task_id', $verified_marks_with_master_task_id['master_task_id'])
                    ->where('user_code', $consultant_code)
                    // ->where('year', $year)
                    ->update('cpms_task_wise_verification', $update_data);  
            if($this->db->affected_rows() != 1){ 
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#cpmsvU001, Error in update, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsvU001'];
            } 
        }   
        //******************************************************************/     
        //updating task wise verification table
        $update_data = [
            'status' => 'C',
            'modified_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('consultant_uesr_code', $consultant_code)
                // ->where('year', $year)
                ->update('cpms_proceedings', $update_data);  
        if($this->db->affected_rows() != 1){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#cpmsvU002, Error in update, table 'cpms_proceedings' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsvU002'];
        } 
        //********************************************************/
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsV001, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsV001'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'CPMS verification details submitted successfully..!'];
        }  
    }
    //getting evaluation status 
    public function getCpmsEvaluationStaus($consultant_code){
        $query = $this->db->query("select count(*) from cpms_proceedings where consultant_uesr_code=?"
        ,array($consultant_code));        
        $row = $query->row();
        if($row->count != 1){
            return "verification_not_completed";
        }else{
            $query = $this->db->query("select status from cpms_proceedings where consultant_uesr_code=?"
            ,array($consultant_code));        
            $row = $query->row();
            if($row->status == 'C'){
                return "verification_completed";
            }else{
                return "verification_not_completed";
            }
        }
    }
    //getting cpms report user wise 
    public function getCpmsReportUserWise($consultant_code){
        //return $consultant_code;
        $query = $this->db->query("select * from cpms_result where user_code=?",array($consultant_code));        
        $row = $query->row();
        return $row;
    }
    //updating task 1 details 
    public function updateTask1Details($cpms_master_task_wise_data, 
    $cpms_subtask_wise_data, $cpms_uesr_wise_result, $cpms_task_and_user_wise_verification,
    $user_code, $year, $master_task_id){        
        $this->db->trans_begin();         
        //checking if status is Completed, if completed then its changed to Pending 
        $query = $this->db->query("select * from cpms_proceedings where consultant_uesr_code=? and year=?"
        ,array($user_code, $year));        
        $row = $query->row();
        if($row->consultant_uesr_code != 'P'){            
            $update_data = [
                "status" => 'P',
                'modified_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('consultant_uesr_code', $user_code)
                    ->where('year', $year)
                    ->update('cpms_proceedings', $update_data);       
            if($this->db->affected_rows() != 1){ 
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#cpmsuP001, Error in update, table 'cpms_proceedings' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsuP001'];
            }  
        }
        //********************************************************/ 
        //updating in cpms master task wise result table  
        $this->db->where('user_code', $user_code)
                ->where('year', $year)
                ->where('master_task_id', $master_task_id)
                ->update('cpms_master_task_wise_result', $cpms_master_task_wise_data);        
        if($this->db->affected_rows() != 1){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#cpmsu001, Error in update, table 'cpms_master_task_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsu001'];
        } 
        //********************************************************/
        //updating cpms subtask task wise result table    
        foreach($cpms_subtask_wise_data as $cpms_subtask_wise_result){        
            $update_data_for_subtask_wise_result = [
                'subtask_id_value' => $cpms_subtask_wise_result['subtask_id_value'],
                'related_subtask_id_value' => $cpms_subtask_wise_result['related_subtask_id_value'],
                'modified_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('user_code', $user_code)
                    ->where('year', $year)
                    ->where('master_task_id', $master_task_id)
                    ->where('subtask_id', $cpms_subtask_wise_result['subtask_id'])
                    ->where('related_subtask_id', $cpms_subtask_wise_result['related_subtask_id'])
                    ->update('cpms_subtask_wise_result', $update_data_for_subtask_wise_result);        
            if($this->db->affected_rows() != 1){ 
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#cpmsu002, Error in update, table 'cpms_subtask_wise_result' with query :". $this->db->last_query());
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsu002'];
            }
        }        
        //********************************************************/
        //updating in cpms user wise result table    
        $this->db->where('user_code', $user_code)
                ->where('year', $year)
                ->where('master_task_id', $master_task_id)
                ->update('cpms_user_wise_result', $cpms_uesr_wise_result);        
        if($this->db->affected_rows() != 1){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#cpmsu003, Error in update, table 'cpms_user_wise_result' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsu003'];
        } 
        //********************************************************/
        //updating in cpms user wise result table    
        $this->db->where('user_code', $user_code)
                ->where('year', $year)
                ->where('master_task_id', $master_task_id)
                ->update('cpms_task_wise_verification', $cpms_task_and_user_wise_verification);        
        if($this->db->affected_rows() != 1){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#cpmsu004, Error in update, table 'cpms_task_wise_verification' with query :". $this->db->last_query());
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsu004'];
        } 
        //********************************************************/
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#cpmsu005, Transaction Status Error In CPMS Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #cpmsu005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Task 1 Details Successfully Updated!'];
        }  
    }

    //getting proceeding flag 
    public function getProceedingFlag($year){
        $user_code = $this->session->all_userdata()['user_code'];
        $query = $this->db->query("select status from cpms_proceedings where consultant_uesr_code=? and year=?"
        ,array($user_code, $year));   
        return $query->row()->status;
    }

}