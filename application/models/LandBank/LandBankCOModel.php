<?php

class LandBankCOModel extends CI_Model {

    //getting unique village ids in land bank details circle wise
    public function getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code){
        $this->db->distinct()->select('village_uuid')
                ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                ->where('cir_code', $cir_code)->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }

    //pending lb details count
    public function getPendingLbCount(){
        $this->db->select('count(*)')
                ->where('status', LAND_BANK_STATUS_PENDING)
                ->where('application_no', null)
                ->where('dist_code', $this->session->userdata('dist_code'))
                ->where('subdiv_code',$this->session->userdata('subdiv_code'))
                ->where('cir_code', $this->session->userdata('cir_code'))
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->count;
    }

    //lb details approve handle 
    public function lbdetailsApprove($lb_details_id, $lb_approval_rmk){
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");  
        $this->db->trans_begin();
        //**************************************************//
        //getting the location,dag and year details frtom land bank details table
        $this->db->select('*')->where('id',  $lb_details_id)->from('land_bank_details');                
        $query = $this->db->get(); 
        $lb_details = $query->row();
        //**************************************************//
        //update data in land bank details
        $this->db->where('id', $lb_details_id)->update('land_bank_details', array(
            'status' => LAND_BANK_STATUS_APPROVED
        ));     
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBCO001U, Error in update, table 'land_bank_details' in changing status to approved");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO001U'];
        }
        //**************************************************//
        //insert data in land bank proceeding details 
        $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
            'land_bank_details_id' => $lb_details_id,
            'remark' => $lb_approval_rmk,
            'status' => LAND_BANK_STATUS_APPROVED,
            'created_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->all_userdata()['user_code']
        )); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBCO002U, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO002U'];
        }
        //**************************************************//
        //update data in t land bank details
        //getting the t land bank details id for update 
        $this->db->select('id')->order_by('id',"DESC")
                  ->where('village_uuid',  $lb_details->village_uuid)
                  ->where('year',  $lb_details->year)  
                  ->where('dag_no',  $lb_details->dag_no)                                                     
                  ->from('t_land_bank_details'); 
        $query = $this->db->get(); 
        $t_lb_details_id = $query->row()->id;
        $this->db->where('id', $t_lb_details_id)->update('t_land_bank_details', 
            array(
                'status' => LAND_BANK_STATUS_APPROVED,
                'co_code' => $this->session->all_userdata()['user_code'],
                'co_action_flag' =>LAND_BANK_STATUS_APPROVED,
                'co_action_time' => date('Y-m-d H:i:s')
        ));         
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBCO003U, Error in update, table 't_land_bank_details' in updating co flags");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO003U'];
        }                    
        //**************************************************//
        //update data in c land bank details  
        //checking whether previous data exists or not in c_land_bank_details 
        $this->db->select('*')
                  ->where('village_uuid',  $lb_details->village_uuid) 
                  ->where('dag_no',  $lb_details->dag_no)                                                     
                  ->from('c_land_bank_details'); 
        $query = $this->db->get(); 
        $c_land_bank_details = $query->row();
        if(count($c_land_bank_details) != 0){
            //*****************************************/
            //delete in c land bank details 
            $this->db->where('id', $c_land_bank_details->id)->delete('c_land_bank_details');
            if($this->db->affected_rows() != 1){ 
                $this->db->trans_rollback();
                log_message("error", "#LBCO004U, Error in delete, table 'c_land_bank_details' with id ".$c_land_bank_details->id);
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO004U'];
            }  
            //*****************************************/
            //delete in c land bank encroacher details 
            $c_land_bank_existing_details = $this->db->select('*')->from('c_land_bank_encroacher_details')->where('c_land_bank_details_id', $c_land_bank_details->id)->get()->result();
            foreach($c_land_bank_existing_details as $c_land_bank_enc_detail){
                $this->db->where('id', $c_land_bank_enc_detail->id)->delete('c_land_bank_encroacher_details');
                if($this->db->affected_rows() != 1){ 
                    $this->db->trans_rollback();
                    log_message("error", "#LBCO005U, Error in delete, table 'c_land_bank_encroacher_details' with id ".$c_land_bank_enc_detail->id);
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO005U'];
                }  
            }
        }
        //insert data in land bank proceeding details 
        $lb_details->status = LAND_BANK_STATUS_APPROVED;
        $lb_id = $lb_details->id;
        unset($lb_details->id);
        $tstatus2 = $this->db->insert('c_land_bank_details', $lb_details);

        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBCO004U, Error in insert on c_land_bank_details table");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO004U'];
        }
        $c_land_bank_inserted_id = $this->db->insert_id(); 
        //return $c_land_bank_inserted_id;
        //getting data from land bank encroacher details
        $this->db->select('*')
                ->where('land_bank_details_id',  $lb_id)
                ->from('land_bank_encroacher_details'); 
        $query = $this->db->get(); 
        $land_bank_encroacher_details = $query->result_array();
        //insert data in the land bank encroacher details 
        foreach($land_bank_encroacher_details as $land_bank_encroacher_detail){
            unset($land_bank_encroacher_detail['land_bank_details_id']);
            $land_bank_encroacher_detail['c_land_bank_details_id'] = $c_land_bank_inserted_id;
            $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $land_bank_encroacher_detail); 
            if ($tstatus3 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBCO005U, Error in insert on c_land_bank_encroacher_details table");
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO004U'];
            }
        }            
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBCO006U, Transaction Status Error In Land Bank Tables on Updation in CO profile");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO006U'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Bank Details Approved Successfully!'];
        } 
    }

    //lb details revert handle
    public function lbdetailsReject($lb_details_id, $lb_reject_rmk){
        //**************************************************//
        //testing
        //return "from the model lb details id is ".$lb_details_id. " remark is ".$lb_approval_rmk;
        //**************************************************//
        //updating land bank details status
        $this->db->trans_begin();
        $this->db->where('id', $lb_details_id)->update('land_bank_details', array(
            'status' => LAND_BANK_STATUS_REVERT_BACK
        ));  
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBCOR001, Error in update, table 'land_bank_details' in updating reject status");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCOR001'];
        }   
        //**************************************************//
        //insert data in land bank proceeding details 
        $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
            'land_bank_details_id' => $lb_details_id,
            'remark' => $lb_reject_rmk,
            'status' => LAND_BANK_STATUS_REVERT_BACK,
            'created_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->all_userdata()['user_code']
        )); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBCOR002, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCOR002'];
        }
        //**************************************************//
        //updating t land bank details 
        //getting the location,dag and year details from land bank details table
        $this->db->select('*')->where('id',  $lb_details_id)->from('land_bank_details');                
        $query = $this->db->get(); 
        $lb_details = $query->row();
        //update data in t land bank details
        //getting the t land bank details id for update 
        $this->db->select('id')->order_by('id',"DESC")
                  ->where('village_uuid',  $lb_details->village_uuid)
                  ->where('year',  $lb_details->year)  
                  ->where('dag_no',  $lb_details->dag_no)                                                     
                  ->from('t_land_bank_details'); 
        $query = $this->db->get(); 
        $t_lb_details_id = $query->row()->id;
        $this->db->where('id', $t_lb_details_id)->update('t_land_bank_details', 
            array(
                'status' => LAND_BANK_STATUS_REVERT_BACK,
                'co_code' => $this->session->all_userdata()['user_code'],
                'co_action_flag' =>LAND_BANK_STATUS_REVERT_BACK,
                'co_action_time' => date('Y-m-d H:i:s')
        ));         
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBCO003U, Error in update, table 't_land_bank_details' in updating co flags");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO003U'];
        }   
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBCOR003, Transaction Status Error In Land Bank Tables on Rejection in CO profile");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCOR003'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Bank Details Rejected Successfully!'];
        } 

    }

    //getting recent pending list for each dag no 
    public function getLbPendingList($uniqueVillageIdsInLandBankDetails, $offset){        
        //converting the object into array
        $array = json_decode(json_encode($uniqueVillageIdsInLandBankDetails),true);
        $villageUUIDarr = array_column($array, 'village_uuid');
        $villageUUIDStr = implode(',', $villageUUIDarr);
        // if no entry exits
        if($villageUUIDStr == ""){
            return [];
        }
        // return $villageUUIDStr;
        // $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
        //                    and application_no is null and status=? limit ".LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT."  offset ". $offset;

        //////////CHANGED AS PER DISCUSS///////JAYANTA AND MRIDU SIR///////2024-11-21///

        $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and status=? limit ".LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT."  offset ". $offset;
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_PENDING, ));        
        //return $this->db->last_query();
        $pending_list = $pendingListQuery->result();
        return $pending_list;
        //*******************old-code********************
        // $pendingListArr = array();
        // foreach($uniqueVillageIdsInLandBankDetails as $villageId){
        //     //getting unique dag no from each villages
        //     $this->db->distinct()->select("dag_no")
        //     ->where('village_uuid', $villageId->village_uuid)
        //     ->from('land_bank_details');
        //     $query = $this->db->get(); 
        //     $dagVillageWise = $query->result();
        //     //return $dagVillageWise;
        //     //populating the pending list
        //     foreach($dagVillageWise as $dag_no){
        //         $this->db->select("*")
        //         ->order_by('id',"DESC")
        //         ->where('village_uuid', $villageId->village_uuid)
        //         ->where('dag_no', $dag_no->dag_no)
        //         ->where('status', 'P')
        //         ->from('land_bank_details');
        //         $query = $this->db->get(); 
        //         if(!empty($query->result())){
        //             array_push($pendingListArr, $query->result()[0]);
        //         }
        //     }            
        // }
        // return $pendingListArr;   
        //***************************************/
    }
    //search pending  dag no
    function getLbSearchPendingListByDag($uniqueVillageIdsInLandBankDetails, $search)
    {
        if (!$search)
            return $this->getLbPendingList($uniqueVillageIdsInLandBankDetails, 0);

        $array = json_decode(json_encode($uniqueVillageIdsInLandBankDetails),true);
        $villageUUIDarr = array_column($array, 'village_uuid');
        $villageUUIDStr = implode(',', $villageUUIDarr);
        // if no entry exits
        if($villageUUIDStr == ""){
            return [];
        }
        // return $villageUUIDStr;
        $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and application_no is null and status=? and dag_no like '$search%'";
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_PENDING));        
        //return $this->db->last_query();
        $pending_list = $pendingListQuery->result();
        return $pending_list;
    }
    //Approved lb details count
    public function getApproveLbCount(){
        $this->db->select('count(*)')
                //->where('status', LAND_BANK_STATUS_APPROVED)
                ->where('dist_code', $this->session->userdata('dist_code'))
                ->where('subdiv_code',$this->session->userdata('subdiv_code'))
                ->where('cir_code', $this->session->userdata('cir_code'))
                ->from('c_land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->count;
    }
    //getting approved list for each dag no
    public function getLbApprovedList($uniqueVillageIdsInLandBankDetails, $offset){        
        //converting the object into array
        $array = json_decode(json_encode($uniqueVillageIdsInLandBankDetails),true);
        $villageUUIDarr = array_column($array, 'village_uuid');
        $villageUUIDStr = implode(',', $villageUUIDarr);
        // if no entry exits
        if($villageUUIDStr == ""){
            return [];
        }
        // return $villageUUIDStr;
        $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and status=? limit ".LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT."  offset ". $offset;
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_APPROVED));        
        //echo $this->db->last_query();
        $pending_list = $pendingListQuery->result();
        return $pending_list;
    }
    //search approved dag no
    function getLbSearchApprovedListByDag($uniqueVillageIdsInLandBankDetails, $search)
    {        
        if (!$search)
        {
            return $this->getLbApprovedList($uniqueVillageIdsInLandBankDetails,0);
            exit;
        }

        $array = json_decode(json_encode($uniqueVillageIdsInLandBankDetails),true);
        $villageUUIDarr = array_column($array, 'village_uuid');
        $villageUUIDStr = implode(',', $villageUUIDarr);
        // if no entry exits
        if($villageUUIDStr == ""){
            return [];
        }
        // return $villageUUIDStr;
        $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and status=? and dag_no like '$search%'";
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_APPROVED));        
        //return $this->db->last_query();
        $pending_list = $pendingListQuery->result();
        return $pending_list;
    }

     //lb details approve handle 
    public function lbdetailsForwardedbyCO($lb_details_id, $lb_approval_rmk){
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");  
       // $this->db->trans_begin();
        //**************************************************//
        //getting the location,dag and year details frtom land bank details table
        $this->db->select('*')->where('id',  $lb_details_id)->from('land_bank_details');                
        $query = $this->db->get(); 
        $lb_details = $query->row();

        $this->db->select('count(*) as total')->where('land_bank_details_id',  $lb_details_id)->from('land_bank_encroacher_details');                
        $query = $this->db->get(); 
        $total_encroacher_updated = $query->row()->total;
        //**************************************************//
        //update data in land bank details
        $this->db->where('id', $lb_details_id)->update('land_bank_details', array(
            'status' => LAND_BANK_STATUS_FORWARD,
            'no_of_encroacher' => $total_encroacher_updated
        ));     
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBCO001U, Error in update, table 'land_bank_details' in changing status to approved");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO001U'];
        }


        //**************************************************//
        //insert data in land bank proceeding details 
        // if($lb_delete_rmk != null){
        //     $remarkString = $lb_approval_rmk. " Deleted Remarks : ".$lb_delete_rmk;
        // }else{
        //     $remarkString = $lb_approval_rmk;
        // }
        
        $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
            'land_bank_details_id' => $lb_details_id,
            'remark' => $lb_approval_rmk,
            'status' => LAND_BANK_STATUS_FORWARD,
            'created_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->all_userdata()['user_code']
        )); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBCO002U, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO002U'];
        }
        //**************************************************//
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBCO006U, Transaction Status Error In Land Bank Tables on Updation in CO profile");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBCO006U'];
        }else{
            //$this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Bank Details Forwarded to DC for Approval!'];
        } 
    }

    public function lbOldDataSaveAndDelete($lb_details_id, $lb_approval_rmk,$encroacher_id,$lb_delete_rmk ){
        date_default_timezone_set("Asia/Calcutta");  
        $sql = 'select * from land_bank_details where id=?';
        $query = $this->db->query($sql,array($lb_details_id));
        $result = $query->result_array();
        $land_bank_existing_details = $this->db->select('*')->from('land_bank_encroacher_details')->where("id IN (".trim($encroacher_id).")")->get()->result_array();
        $arrayForInsertVlb = array(
            'landbankid'  => $lb_details_id,
            'deleted_vlb' => json_encode($result),
            'deleted_enc' => json_encode($land_bank_existing_details),
            'deleted_remarks' => $lb_delete_rmk ,
            'deleted_user' => $this->session->all_userdata()['user_code'],
            'deleted_date_time' => date('Y-m-d H:i:s')
        );
        $insertCheckStatus = $this->db->insert('deleted_vlb_data', $arrayForInsertVlb);
        if ($insertCheckStatus != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBCO00989U, Error in insert on deleted_vlb_data table".$lb_details_id);
            return 0;
        }
    
        if ($land_bank_existing_details != null && $land_bank_existing_details!='')
        {
            $this->db->where('land_bank_details_id', $lb_details_id)->where("id IN (".trim($encroacher_id).")")->delete('land_bank_encroacher_details');
            if($this->db->affected_rows()<=0){ 
                $this->db->trans_rollback();
                // log_message('error',$this->db->last_query());
                log_message("error", "#LBCO094394, Error in delete, table 'land_bank_encroacher_details' with enc id ".$encroacher_id);
                return 0;
            }
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBCO0054545U, Transaction Status Error In Land Bank Tables on Deletion in CO login");
            return 0;
        }else{
            //$this->db->trans_commit();
            return 1;
        } 

    }
}
?>