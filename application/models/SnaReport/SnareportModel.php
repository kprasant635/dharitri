<?php

class SnaReportModel extends CI_Model {

    //db switch method
    public function dbswitch(){       
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
            } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
        }
    }

    //method to get all the user data using the user code
    public function fetchAllUserdata($dist_code,$subdiv_code,$cir_code,$user_code)
    {
        $query = $this->db->query("select * from users  where dist_code=? and subdiv_code=? and cir_code=? and user_code=?",array($dist_code,$subdiv_code,$cir_code,$user_code));
        return $query->row();
    }

    //method to get all the district names with code from central auth database
    public function getAllDistrict()
    {
        $CI=&get_instance();
        $aurth_data = $this->db=$CI->load->database('auth', TRUE);
        $query = $this->db->query("select locname_eng,loc_name,dist_code from location where subdiv_code='00'")->result();
        return $query;
    }

    //method to isnert data in dharitree table for neww joinee
    public function insertDharitreeArray($dhar_db,$dharitree_array)
    {
        $dhar_db->trans_begin();
        $insert_data = $dhar_db->insert('dhar_sna_details',$dharitree_array);
        if($insert_data <= 0){
            return ['result' => 'N', 'msg'=> "Data not inserted Properly"] ;
            log_message("error","Some error occured in inserting into dharitree dhar_sna_details table with data".json_encode($dharitree_array));
        }else{
            return ['result'=> 'Y' , 'msg'=> "Data Inserted" ];
            log_message("error","Data inserted into dharitree db".json_encode($dharitree_array));
        }

    }

    //method insert data into ilrms 
    public function insertSnaDetailsInIlrms($dhar_db,$dhar_old_db,$ilrms_db_sna_primary_account,$ilrms_db_sna_account_history)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => POST_SNA_DATA,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                "unique_user_id"        =>$ilrms_db_sna_primary_account['unique_user_id'],
                "unique_sna_code"       =>$ilrms_db_sna_primary_account['unique_sna_code'],
                "dhar_user_code"        =>$ilrms_db_sna_primary_account['dhar_user_code'],
                "status"                => $ilrms_db_sna_primary_account['status'],
                "name"                  =>$ilrms_db_sna_primary_account['name'],
                "mobile"                =>$ilrms_db_sna_primary_account['mobile'],
                "gender"                =>$ilrms_db_sna_primary_account['gender'],
                "address"               =>$ilrms_db_sna_primary_account['address'], 
                "transferred_from_yn"   =>$ilrms_db_sna_primary_account['transferred_from_yn'],
                "dist_code"             =>$ilrms_db_sna_primary_account['dist_code'],
                "subdiv_code"           =>$ilrms_db_sna_primary_account['subdiv_code'],
                "cir_code"              =>$ilrms_db_sna_primary_account['cir_code'],
                "mouza_pargona_code"    =>'00',
                "lot_no"                =>'00',
                "date_of_joining"       =>$ilrms_db_sna_primary_account['date_of_joining'],
                "date_of_leaving"       =>null,
                "created_at"            =>date('Y-m-d h:i:s'),
                
                // other table
                "dist_name"             => $ilrms_db_sna_account_history['dist_name'],
                "subdiv_name"           => $ilrms_db_sna_account_history['subdiv_name'],
                "cir_name"              => $ilrms_db_sna_account_history['cir_name'],
                "status"                => $ilrms_db_sna_account_history['status'],
                "prev_date_of_joining"  => $ilrms_db_sna_account_history['prev_date_of_joining'],
                "prev_date_of_leaving"  => $ilrms_db_sna_account_history['prev_date_of_leaving'],
                "prev_unique_user_id"   => $ilrms_db_sna_account_history['prev_unique_user_id'], 
                "prev_unique_sna_code"  => $ilrms_db_sna_account_history['prev_unique_sna_code'],
                "pre_dhar_code"         => $ilrms_db_sna_account_history['pre_dhar_code'],
                "pre_dist_code"         => $ilrms_db_sna_account_history['pre_dist_code'],
                "pre_subdiv_code"       => $ilrms_db_sna_account_history['pre_subdiv_code'],
                "pre_cir_code"          => $ilrms_db_sna_account_history['pre_cir_code'],
                "pre_mouza_pargona_code"=> null,
                "pre_lot_no"            => null,
                
            ),
        ));
       
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
     
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $dhar_old_db->trans_commit();
                $dhar_db->trans_commit();
                return ['result' => 'SUCCESS', 'msg' => 'All Details Inserted Successfully!'];                 
            }else{
                $dhar_old_db->trans_rollback();
                $dhar_db->trans_rollback();
                log_message("error", "#CURLLSNAREPORT001, Curl Error(Y) In Api ".POST_SNA_DATA);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CURLLSNAREPORT001'];
            } 
        }else{
            $dhar_old_db->trans_rollback();
            $dhar_db->trans_rollback();
            log_message("error", "#CURLLSNAREPORT002, Curl Error(200) In Api ".POST_SNA_DATA);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CURLLSNAREPORT002'];
        }
    }

    //methdo to insert data using curl in ilrms for new joinee
    public function insertSnaDetailsInIlrmsNewJoinee($dhar_db,$ilrms_db_sna_primary_account)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => POST_SNA_DATA,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                "unique_user_id"        =>$ilrms_db_sna_primary_account['unique_user_id'],
                "unique_sna_code"       =>$ilrms_db_sna_primary_account['unique_sna_code'],
                "dhar_user_code"        =>$ilrms_db_sna_primary_account['dhar_user_code'],
                "status"                =>$ilrms_db_sna_primary_account['status'],
                "name"                  =>$ilrms_db_sna_primary_account['name'],
                "mobile"                =>$ilrms_db_sna_primary_account['mobile'],
                "gender"                =>$ilrms_db_sna_primary_account['gender'],
                "address"               =>$ilrms_db_sna_primary_account['address'], 
                "transferred_from_yn"   =>$ilrms_db_sna_primary_account['transferred_from_yn'],
                "dist_code"             =>$ilrms_db_sna_primary_account['dist_code'],
                "subdiv_code"           =>$ilrms_db_sna_primary_account['subdiv_code'],
                "cir_code"              =>$ilrms_db_sna_primary_account['cir_code'],
                "mouza_pargona_code"    =>'00',
                "lot_no"                =>'00',
                "date_of_joining"       =>$ilrms_db_sna_primary_account['date_of_joining'],
                "date_of_leaving"       =>null,
                "created_at"            =>date('Y-m-d h:i:s'),
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $dhar_db->trans_commit();
                return ['result' => 'SUCCESS', 'msg' => 'All Details Inserted Successfully!'];                 
            }else{
                $dhar_db->trans_rollback();
                log_message("error", "#CURLLSNAREPORT0011, Curl Error(Y) In Api ".POST_SNA_DATA);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CURLLSNAREPORT0011'];
            } 
        }else{
            $dhar_db->trans_rollback();
            log_message("error", "#CURLLSNAREPORT0022, Curl Error(200) In Api ".POST_SNA_DATA);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CURLLSNAREPORT0022'];
        }
    }

    //method to check whethr the modal form is submitted by sna or not
    public function checkSnaReportSubmitted($dist_code,$subdiv_code,$cir_code,$user_code)
    {
        $query = $this->db->query("select * from dhar_sna_details where dist_code=? and subdiv_code=? and cir_code=? and usercode=?",array($dist_code,$subdiv_code,$cir_code,$user_code));
        if($query->num_rows() <= 0){
            return "NOT_FOUND";
        }else{
            $result = $query->row();
            if($result->status =='A' || $result->status =='D'){
                return "ROW_FOUND";
            }
        }
        
    }

    //method to get sna unique code
    public function getUniqueSnaCode($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select * from sna_master_code where dist_code=? and subdiv_code=? and cir_code=? and status =?",array($dist_code,$subdiv_code,$cir_code,'Y'));
        
        if($query->num_rows() == 0){
            return "NOT-FOUND";
        }
        else{
            return $query->row()->unique_sna_code;
        }
    }

    //method to get old sna unique code
    public function getOldSnaUniqueCode($dhar_old_db,$dist_code,$subdiv_code,$cir_code)
    {
        $query = $dhar_old_db->query("select * from sna_master_code where dist_code=? and subdiv_code=? and cir_code=? and status =?",array($dist_code,$subdiv_code,$cir_code,'Y'));
        
        if($query->num_rows() == 0){
            return "NO_OLD_SNA_CODE_FOUND";
        }
        else{
            return $query->row()->unique_sna_code;
        }
    }

    //methdo to insert old dharitree array if transfers type is y
    public function insertDharitreeOldArray($dhar_old_db,$dharitree_old_array)
    {
        $insert_data = $dhar_old_db->insert('dhar_sna_details',$dharitree_old_array);
        if($insert_data != 1){
            return['result' => 'N', 'msg'=> "Data not inserted Properly"] ;
        }else{
            return ['result'=>'Y' , 'msg'=> "Data Inserted" ];
        }
    }

    //method used to get the sna inserted data to show in the profile page
    public function getAllSnaDetails($dhar_db,$dist_code,$subdiv_code,$cir_code,$user_code)
    {
        $query = $dhar_db->query("select * from dhar_sna_details dsd join users u on dsd.dist_code = u.dist_code and dsd.subdiv_code = u.subdiv_code and dsd.cir_code= u.cir_code and dsd.usercode = u.user_code where dsd.status=?",array('A'));
        if($query->num_rows() <= 0){
            return "NOT_FOUND";
        }else{
            $result = $query->row();
            return $result;
        }
    }
}
?>