<?php

class CoArrearUpdateModel extends CI_Model {

    //getting all the mouza list
    public function getMouzaList($dist_code,$subdiv_code,$cir_code){
        $mouza_codes_query = "select distinct mouza_pargona_code from current_doul_demand where dist_code=? and subdiv_code=? and cir_code=?";
        $query = $this->db->query($mouza_codes_query,array($dist_code,$subdiv_code,$cir_code));
        $mouza_codes = $query->result();
        $array = json_decode(json_encode($mouza_codes),true);
        $mouza_codes_arr = array_column($array, 'mouza_pargona_code');
        //return $mouza_codes_arr;
        $mouza_codes_str = "'" . implode ( "', '", $mouza_codes_arr ) . "'";
        //return $mouza_codes_str;
        //return $mouza_codes_str;
        $sql = "select locname_eng, loc_name, mouza_pargona_code from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code in (".$mouza_codes_str.") and lot_no =?";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00', '00'));        
        //return $this->db->last_query();
        return $query->result(); 
    }

    //storing co areear update details 
    public function insertCoArrearUpdateDetails($jama_wasil_data,
    $jama_wasil_payee_list_data,$jama_wasil_backup_table_data){
        error_reporting(0);
        $this->db->trans_begin();
        //**************************************************//
        //insert data in jama_wasil 
        $tstatus1 = $this->db->insert('jama_wasil', $jama_wasil_data); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOAU001, Error in insert on jama_wasil table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOAU001'];
        }
        //**************************************************//
        $jama_wasil_inserted_id = $this->db->insert_id(); 
        //**************************************************//
        //insert data in jama_wasil_transaction 
        $jama_wasil_data['jama_wasil_id'] = $jama_wasil_inserted_id;
        $tstatus2 = $this->db->insert('jama_wasil_transaction', $jama_wasil_data); 
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOAU002, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOAU002'];
        }
        //**************************************************//
        $jama_wasil_transaction_inserted_id = $this->db->insert_id();
        //**************************************************//
        //insert data in jama_wasil_payee_list 
        $jama_wasil_payee_list_data['jama_wasil_id'] = $jama_wasil_inserted_id;
        $jama_wasil_payee_list_data['jama_wasil_transaction_id'] = $jama_wasil_transaction_inserted_id;
        $tstatus3 = $this->db->insert('jama_wasil_payee_list', $jama_wasil_payee_list_data); 
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOAU003, Error in insert on jama_wasil_payee_list table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOAU003'];
        }
        //**************************************************//
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOAU004, Error in insert on jama_wasil_backup table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOAU004'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKCOAU005, Transaction Status Error In Mouzadar Arrear Update Details with query- ". json_encode($this->db->last_query())); 
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOAU005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Arrear Updated Sucessfully..!'];
        } 
    }

    //updating offline entry of arrear 
    public function updateCoArrearUpdateDetails($jama_wasil_data,
    $jama_wasil_payee_list_data,$jama_wasil_backup_table_data){
        error_reporting(0);
        $this->db->trans_begin();
        $sql = "select id from jama_wasil where village_uuid=? and patta_no=? and status=?";
        $query = $this->db->query($sql, array($jama_wasil_data['village_uuid'], $jama_wasil_data['patta_no'], JAMA_WASIL_STATUS_OFFLINE));        
        $jama_wasil_id = $query->row()->id;
        //**************************************************//
        //insert data in jama_wasil 
        $tstatus1 = $this->db->where('id',$jama_wasil_id)->update('jama_wasil', $jama_wasil_data); 
        if($this->db->affected_rows() != 1) 
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUCOA001, Error in update on jama_wasil table with query- ". json_encode($this->db->last_query())); 
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUCOA001'];
        }
        //**************************************************//
        //insert data in jama_wasil_transaction 
        $jama_wasil_data['jama_wasil_id'] = $jama_wasil_id;
        $tstatus2 = $this->db->insert('jama_wasil_transaction', $jama_wasil_data); 
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUCOA002, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query())); 
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUCOA002'];
        }
        //**************************************************//
        $jama_wasil_transaction_inserted_id = $this->db->insert_id();
        //**************************************************//
        //insert data in jama_wasil_payee_list 
        $jama_wasil_payee_list_data['jama_wasil_id'] = $jama_wasil_id;
        $jama_wasil_payee_list_data['jama_wasil_transaction_id'] = $jama_wasil_transaction_inserted_id;
        $tstatus3 = $this->db->insert('jama_wasil_payee_list', $jama_wasil_payee_list_data); 
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUCOA003, Error in insert on jama_wasil_payee_list table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUCOA003'];
        }
        //**************************************************//
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUCOA004, Error in insert on jama_wasil_backup table with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUCOA004'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKUCOA005, Transaction Status Error In Mouzadar Arrear Update Details with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUCOA005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Arrear Updated Sucessfully..!'];
        } 
    }

    //co updated arrear patta count 
    public function getUpdatedPattaArrearCount($dist_code,$subdiv_code, $cir_code){
        $sql = "SELECT COUNT(*) FROM (select distinct(jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and cir_code=? 
        and status=?) as count";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code,JAMA_WASIL_STATUS_OFFLINE));        
        return $query->row()->count;
    }

    //co pending arrear patta count 
    public function getPendingPattaArrearCount($dist_code,$subdiv_code, $cir_code){
        //chitha patta numbers
        $sqlPattaNos = "SELECT COUNT(*) FROM (select distinct (patta_no) from chitha_basic where dist_code=? and subdiv_code=? and
        cir_code=?) AS count";
        $query = $this->db->query($sqlPattaNos, array($dist_code,$subdiv_code, $cir_code,));
        $chitha_patta =  $query->row()->count;
        //jama_wasil_transaction
        $sqlPattaNosJW = "SELECT COUNT(*) FROM (select distinct (jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and
        cir_code=? and status=?) AS count";
        $query = $this->db->query($sqlPattaNosJW, array($dist_code,$subdiv_code, $cir_code,JAMA_WASIL_STATUS_OFFLINE));
        $jw_patta =  $query->row()->count; 
        return $chitha_patta-$jw_patta;
    }

    //getting updated arrear list patta wise for co
    public function getUpdatedArrearPattaWise($dist_code, 
    $subdiv_code, $cir_code){
        $sql = "select distinct(jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and cir_code=? and status=?";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, JAMA_WASIL_STATUS_OFFLINE));        
        $result = $query->result();
        $pending_list = array();
        foreach($result as $row){
            $this->db->select("*")
                ->order_by('id',"DESC")
                ->where('jama_wasil_id', $row->jama_wasil_id)
                ->from('jama_wasil_transaction');
            $query = $this->db->get(); 
            array_push($pending_list, $query->row());
        }
        return $pending_list;
    }

    
}