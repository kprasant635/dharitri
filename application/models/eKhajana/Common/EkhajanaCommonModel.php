<?php

class EkhajanaCommonModel extends CI_Model {

    //getting village list from mouza
    
    public function getVillageList($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code){
        //$sql = "select distinct uuid from current_doul_demand where dist_code = ? and subdiv_code = ? and cir_code = ? 
                //and mouza_pargona_code = ? and vill_townprt_code != ?";
        $sql = "select a.loc_name, a.locname_eng, b.uuid from location a 
                join (select distinct uuid::bigint from current_doul_demand 
                where dist_code = ? and subdiv_code = ? and cir_code = ? and 
                mouza_pargona_code = ? and vill_townprt_code != '00000') b on 
                a.uuid = b.uuid";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,'00000'));        
        //return $this->db->last_query();
        return $query->result(); 
    }
    //patta type selection 
    public function getPattaType($mouza_code,$village_uuid){
        //$sql = "select type_code, patta_type, pattatype_eng from patta_code";
        $sql = "select a.type_code, a.patta_type, a.pattatype_eng from patta_code a 
                join (select distinct patta_type_code from current_doul_demand 
                where uuid=?) b on a.type_code = b.patta_type_code";
        $query = $this->db->query($sql,$village_uuid);        
        return $query->result(); 
    }

    //getting patta numbers 
    public function getPattaNumbers($village_uuid, $patta_type_code){
        $sqlPattaNos = "select distinct (patta_no) from current_doul_demand where uuid=? and patta_type_code =?";
        $query = $this->db->query($sqlPattaNos, array(
            $village_uuid,
            $patta_type_code
        ));        
        $patta_list = $query->result(); 
        $patta_to_be_updated_list =  array();
        //checking if patta is already updated
        foreach($patta_list as $patta){
            $sql = "select count(*) from jama_wasil where village_uuid=? and patta_no=? and patta_type_code=? and status=?";
            $query = $this->db->query($sql, array($village_uuid, $patta->patta_no, $patta_type_code,JAMA_WASIL_STATUS_ONLINE));        
            if($query->row()->count == 0){
                array_push($patta_to_be_updated_list, [
                    "patta_no" =>$patta->patta_no,
                ]);
            }
        }
        return $patta_to_be_updated_list;
    }

    //getting pattadars 
    public function getPattadars($village_uuid, $patta_type_code, $patta_no){
        $sqlLocation = "select * from location where uuid=?";
        $query = $this->db->query($sqlLocation, array($village_uuid));        
        $location_details = $query->row();
        $sqlPattadars = " select distinct a.pdar_id,a.pdar_name,a.pdar_father from chitha_pattadar a "
                        ."join chitha_dag_pattadar b on a.dist_code = b.dist_code and " 
                        ."a.subdiv_code = b.subdiv_code and a.cir_code = b.cir_code "
                        ."and a.mouza_pargona_code = b.mouza_pargona_code and a.lot_no = b.lot_no "
                        ."and a.vill_townprt_code = b.vill_townprt_code and a.patta_no = b.patta_no "
                        ."and a.patta_type_code =b.patta_type_code where a.dist_code=? and " 
                        ."a.subdiv_code=? and a.cir_code =? and a.mouza_pargona_code=? and "
                        ."a.lot_no = ? and a.vill_townprt_code = ? and a.patta_no = ? and "
                        ."b.p_flag !='1' and a.patta_type_code = ? ";
        $query = $this->db->query($sqlPattadars, array(
            $location_details->dist_code, 
            $location_details->subdiv_code,
            $location_details->cir_code,
            $location_details->mouza_pargona_code,
            $location_details->lot_no,
            $location_details->vill_townprt_code,
            $patta_no,
            $patta_type_code
        ));        
        //return $this->db->last_query();
        return $query->result(); 
    }

    //get gurdian relations
    public function getGuardianRelations(){
        $sql = "select * from master_guard_rel";
        $query = $this->db->query($sql);        
        return $query->result();
    }

    //getting location details from uuid
    public function getLocationDetailsFromUUID($village_uuid){
        $sqlLocation = "select * from location where uuid=?";
        $query = $this->db->query($sqlLocation, array($village_uuid));        
        return $query->row();
    }

    //storing mouzadar areear update details 
    public function insertMouzadarArrearUpdateDetails($jama_wasil_data,
    $jama_wasil_payee_list_data,$jama_wasil_backup_table_data){
        error_reporting(0);
        $this->db->trans_begin();
        //**************************************************//
        //insert data in jama_wasil 
        $tstatus1 = $this->db->insert('jama_wasil', $jama_wasil_data); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EK0001, Error in insert on jama_wasil table with data ". json_encode($jama_wasil_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EK0001'];
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
            log_message("error", "#EK0002, Error in insert on jama_wasil_transaction table with data ". json_encode($jama_wasil_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EK0002'];
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
            log_message("error", "#EK0003, Error in insert on jama_wasil_payee_list table with data ". json_encode($jama_wasil_payee_list_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EK0003'];
        }
        //**************************************************//
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EK0004, Error in insert on jama_wasil_backup table with data ". json_encode($jama_wasil_backup_table_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EK0004'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EK0005, Transaction Status Error In Mouzadar Arrear Update Details");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EK0005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Arrear Updated Sucessfully..!'];
        } 
    }

    //getting updated arrear list for mouzadar
    public function getUpdatedArrearPattaWise($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code){
        $sql = "select distinct(jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and status=?";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, JAMA_WASIL_STATUS_OFFLINE));        
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

    //getting arrear update details form id
    public function getArrearUpdateDetailsFromJWTid($jamawasil_transaction_id){
        $sql = "select * from jama_wasil_transaction where id=?";
        $query = $this->db->query($sql, array($jamawasil_transaction_id));        
        return $query->row();
    }

    //getting updated patta count
    public function getUpdatedPattaArrearCount($dist_code,$subdiv_code, $cir_code, $mouza_pargona_code){
        $sql = "SELECT COUNT(*) FROM (select distinct(jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and cir_code=? 
        and mouza_pargona_code=? and status=?) as count";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, JAMA_WASIL_STATUS_OFFLINE));        
        return $query->row()->count;
    }

    //getting pending list count 
    public function getPendingPattaArrearCount($dist_code,$subdiv_code, $cir_code, $mouza_pargona_code){
        //chitha patta numbers
        $sqlPattaNos = "SELECT COUNT(*) FROM (select distinct (patta_no) from chitha_basic where dist_code=? and subdiv_code=? and
        cir_code=? and mouza_pargona_code=?) AS count";
        $query = $this->db->query($sqlPattaNos, array($dist_code,$subdiv_code, $cir_code, $mouza_pargona_code));
        $chitha_patta =  $query->row()->count;
        //jama_wasil_transaction
        $sqlPattaNosJW = "SELECT COUNT(*) FROM (select distinct (jama_wasil_id) from jama_wasil_transaction where dist_code=? and subdiv_code=? and
        cir_code=? and mouza_pargona_code=? and status=?) AS count";
        $query = $this->db->query($sqlPattaNosJW, array($dist_code,$subdiv_code, $cir_code, $mouza_pargona_code,JAMA_WASIL_STATUS_OFFLINE));
        $jw_patta =  $query->row()->count; 
        return $chitha_patta-$jw_patta;
    }

    //checking previous entry 
    public function checkPrevEntry($village_uuid, $patta_no){
        $sql = "select count(*) from jama_wasil where village_uuid=? and patta_no=? and status=?";
        $query = $this->db->query($sql, array($village_uuid, $patta_no, JAMA_WASIL_STATUS_OFFLINE));        
        return $query->row()->count;
    }

    //updating offline entry of arrear 
    public function updateMouzadarArrearUpdateDetails($jama_wasil_data,
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
            log_message("error", "#EKU0001, Error in update on jama_wasil table with data ". json_encode($jama_wasil_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKU0001'];
        }
        //**************************************************//
        //insert data in jama_wasil_transaction 
        $jama_wasil_data['jama_wasil_id'] = $jama_wasil_id;
        $tstatus2 = $this->db->insert('jama_wasil_transaction', $jama_wasil_data); 
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKU0002, Error in insert on jama_wasil_transaction table with data ". json_encode($jama_wasil_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKU0002'];
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
            log_message("error", "#EKU0003, Error in insert on jama_wasil_payee_list table with data ". json_encode($jama_wasil_payee_list_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKU0003'];
        }
        //**************************************************//
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKU0004, Error in insert on jama_wasil_backup table with data ". json_encode($jama_wasil_backup_table_data));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKU0004'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKU0005, Transaction Status Error In Mouzadar Arrear Update Details");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKU0005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Arrear Updated Sucessfully..!'];
        } 
    }

    //getting subdivison list 
    public function getSubdivListFromDist($dist_code){
        $subdiv_list = $this->db->query("select subdiv_code,locname_eng,loc_name from location where dist_code=? and subdiv_code!=? 
                                        and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",
                                        array($dist_code, '00', '00', '00', '00', '00000'))->result();
        return $subdiv_list;                                        
    }

    //getting circle list 
    public function getCircleList($dist_code,$subdiv_code){
        $circle_list = $this->db->query("select cir_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? 
        and cir_code!=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",
        array($dist_code, $subdiv_code, '00', '00', '00', '00000'))->result();
        return $circle_list;
    }

    //getting luza list 
    public function getMouzaList($dist_code,$subdiv_code,$cir_code){
        $mouza_list = $this->db->query("select mouza_pargona_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? 
        and cir_code=? and mouza_pargona_code!=? and lot_no=? and vill_townprt_code=?",
        array($dist_code, $subdiv_code, $cir_code, '00', '00', '00000'))->result();
        return $mouza_list;
    }

    public function getDemandSatisfiedListFromDist($dist_code){
        return $this->db->query("select * from ekhajana_demand_satisfy_year")->result();
    }
}