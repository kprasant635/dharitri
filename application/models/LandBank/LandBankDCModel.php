<?php

class LandBankDCModel extends CI_Model {

    //getting unique village ids in land bank details circle wise
    public function getUniqueVillageIdsInLandBankDetails($dist_code){
        $this->db->distinct()->select('village_uuid')
                ->where('dist_code', $dist_code)->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }
    public function getAllPendingVillageUUID($dist_code){
        $this->db->distinct()->select('village_uuid')
                ->where('dist_code', $dist_code)
                ->where('status',LAND_BANK_STATUS_FORWARD)
                ->where('application_no', null)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getSubDivCircleDagsList($dist_code){
        $this->db->distinct()->select('dag_no')
                ->where('dist_code', $dist_code)
                ->where('status',LAND_BANK_STATUS_FORWARD)
                ->where('application_no', null)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getSubDivCircleList($dist_code){
        $this->db->select('subdiv_code,cir_code')
                ->where('dist_code', $dist_code)
                ->where('status',LAND_BANK_STATUS_FORWARD)
                ->where('application_no', null)
                ->group_by('subdiv_code,cir_code')->from('land_bank_details');
                ;
        $query = $this->db->get();
        return $query->result();
    }

    //pending lb details count
    public function getPendingLbCount(){
        $this->db->select('count(*)')
                ->where('status', LAND_BANK_STATUS_FORWARD)
                ->where('dist_code', $this->session->userdata('dist_code'))
                ->where('application_no', null)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->count;
    }
    //settlement lb pending count-------
    public function getSettlementPendingLbCount(){
        $this->db->select('count(*)')
                ->where('status', LAND_BANK_STATUS_FORWARD)
                ->where('dist_code', $this->session->userdata('dist_code'))
                ->where('application_no is not null')
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->count;
       
    }

    //lb details approve handle 
    public function lbdetailsApprove($lb_details_id, $lb_approval_rmk){
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");  
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
            'status' => LAND_BANK_STATUS_APPROVED,
            'no_of_encroacher' => $total_encroacher_updated
        ));     
        if($this->db->affected_rows() != 1){ 
            //if error in update
            $this->db->trans_rollback();
            log_message("error", "#LBDC001U, Error in update, table 'land_bank_details' in changing status to approved");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC001U'];
        }

        // log_message('error',$this->db->last_query());
        //**************************************************//
        // if($lb_delete_rmk_dc != null){
        //     $remarkString = $lb_approval_rmk. " Deleted Remarks : ".$lb_delete_rmk_dc;
        // }else{
        //     $remarkString = $lb_approval_rmk;
        // }
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
            log_message("error", "#LBDC002U, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC002U'];
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
        $this->db->select('id')
                  ->where('village_uuid',  $lb_details->village_uuid) 
                  ->where('dag_no',  $lb_details->dag_no)                                                     
                  ->from('c_land_bank_details'); 
        $query = $this->db->get(); 
        
        //ALEX001:checking for multiple records in table land bank details-------
        //ALEX001:deleting records id wise in both table-------------------------
        if ($query->num_rows() != null && $query->num_rows() != '' && $query->num_rows() >0){
            $c_land_bank_details = $query->result();
            $result = array();
            $result1 = array();
            foreach ($c_land_bank_details as $c_land_bank_details) {
                $sql = 'select * from c_land_bank_details where id=?';
                $query = $this->db->query($sql,array($c_land_bank_details->id));
                $result = $query->result_array();
                // $encInsertArray =array();//declaring new array for inserting vlb backup----
                $c_land_bank_existing_details = $this->db->select('*')->from('c_land_bank_encroacher_details')->where('c_land_bank_details_id', $c_land_bank_details->id)->get()->result_array();
                
                $arrayForInsertVlb = array(
                    'landbankid'  => $c_land_bank_details->id,
                    'deleted_vlb' => json_encode($result),
                    'deleted_enc' => json_encode($c_land_bank_existing_details)
                );
                $insertCheckStatus = $this->db->insert('deleted_vlb_data', $arrayForInsertVlb);
                if ($insertCheckStatus != 1 )
                {
                    $this->db->trans_rollback();
                    log_message("error", "#LBDC004U, Error in insert on deleted_vlb_data table");
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC004U'];
                }
                $this->db->where('id', $c_land_bank_details->id)->delete('c_land_bank_details');
                if($this->db->affected_rows() != 1){ 
                    $this->db->trans_rollback();
                    log_message("error", "#LBDC0010U, Error in delete, table 'c_land_bank_details' with id ".$c_land_bank_details->id);
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC0010U'];
                }
                if ($c_land_bank_existing_details != null && $c_land_bank_existing_details!='' && count($c_land_bank_existing_details)>0)
                {
                    $this->db->where('c_land_bank_details_id', $c_land_bank_details->id)->delete('c_land_bank_encroacher_details');
                    if($this->db->affected_rows() <=0){ 
                        $this->db->trans_rollback();
                        log_message("error", "#LBDC0010U, Error in delete, table 'c_land_bank_details' with id ".$c_land_bank_details->id);
                        return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC0010U'];
                    }
                }
            }
        }

        //insert data in land bank proceeding details 
        $lb_details->status = LAND_BANK_STATUS_APPROVED;
        $lb_id = $lb_details->id;
        unset($lb_details->id);
        $tstatus2 = $this->db->insert('c_land_bank_details', $lb_details);
        $iv_lb_details=$lb_details;
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBDC004U, Error in insert on c_land_bank_details table");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC004U'];
        }



        
        $c_land_bank_inserted_id = $this->db->insert_id(); 

        //return $c_land_bank_inserted_id;
        //getting data from land bank encroacher details
        $this->db->select('*')
                ->where('land_bank_details_id',  $lb_id)
                ->from('land_bank_encroacher_details'); 
        $query = $this->db->get(); 
        $land_bank_encroacher_details = $query->result_array();
        $land_bank_encroacher_detail_ivlb=[];
        //insert data in the land bank encroacher details 
        foreach($land_bank_encroacher_details as $land_bank_encroacher_detail){
            unset($land_bank_encroacher_detail['land_bank_details_id']);
            $land_bank_encroacher_detail['c_land_bank_details_id'] = $c_land_bank_inserted_id;
            $land_bank_encroacher_detail_ivlb[]=$land_bank_encroacher_detail;
            $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $land_bank_encroacher_detail); 
            if ($tstatus3 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBDC005U, Error in insert on c_land_bank_encroacher_details table");
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC005U'];
            }
        }

        /**Added by Manashjyoti Deka on 18-03-25 start */
        //Replicate c_land_bank_details into iv_land_bank_details along with encroacher_details as json
        $iv_lb_details->c_land_bank_details_id = $c_land_bank_inserted_id; 
        $iv_lb_details->encroacher_details = json_encode($land_bank_encroacher_detail_ivlb);        
        
        
        $tstatus_new = $this->db->insert('iv_land_bank_details', $iv_lb_details);
        log_message('error','#DCFINALAPPROVE======='.$this->db->last_query());
        if ($tstatus_new!= 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBDC004U, Error in insert on iv_land_bank_details table");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC004U'];
        }
        /**Added by Manashjyoti Deka on 18-03-25 end */
     
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBDC006U, Transaction Status Error In Land Bank Tables on Updation in CO profile");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBDC006U'];
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

    //if ($c_land_bank_existing_details != null && $c_land_bank_existing_details!='' && count($c_land_bank_existing_details)>0)
                


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
        $pendingListSql = "select * from land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and status=? limit ".LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT."  offset ". $offset;
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_FORWARD));        
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
                           and status=? and dag_no like '$search%'";
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_FORWARD));        
        //return $this->db->last_query();
        $pending_list = $pendingListQuery->result();
        return $pending_list;
    }
    //Approved lb details count
    public function getApproveLbCount(){
        $this->db->select('count(*)')
                ->where('status', LAND_BANK_STATUS_APPROVED)
                ->where('dist_code', $this->session->userdata('dist_code'))
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

    public function getAllRemarks($lb_details_id){
        // $this->db->select("*")
        //         ->order_by('id',"DESC")
        //         ->where('land_bank_details_id', $lb_details_id)
        //         ->where('status', LAND_BANK_STATUS_FORWARD)
        //         ->from('land_bank_proceeding_details');
        // $query = $this->db->get(); 
        // return $query->row();
        $SQL =  "select remark,to_char(created_at,'DD-MM-YYYY HH24:MI:SS') as created_at from land_bank_proceeding_details
            where land_bank_proceeding_details.land_bank_details_id = ? and status = ?";
        $row = $this->db->query($SQL,array($lb_details_id,LAND_BANK_STATUS_FORWARD));
        return $row->row();
        // log_message('error',$this->db->last_query());
    }
    public function getPendingCasesInDC($dist_code,$start,$length,$order,$subdiv_code,$cir_code,$dags,$village_code){
     
      $col = 0;
      $dir = "";
      if(!empty($order)){
          foreach($order as $o){
              $col = $o['column'];
              $dir = $o['dir'];
          }
      }
      if($dir != "asc" && $dir != 'desc'){
          $dir = 'desc';
      }
      $valid_columns = array(
          0   => 'id',
      );
      if(!isset($valid_columns[$col])){
          $order = null;
      }else{
          $order = $valid_columns[$col];
      }
      if($order != null){
          $this->db->order_by($order, $dir);
      }
      if(!empty($cir_code)){
          $this->db->where('cir_code', $cir_code);
      }
      if(!empty($village_code)){
        $this->db->where('village_uuid', $village_code);
      }
      if(!empty($subdiv_code)){
        $this->db->where('subdiv_code', $subdiv_code);
      }
      if(!empty($dags)){
        $this->db->where('dag_no', $dags);
      }

      // $pendingListSql = "SELECT DISTINCT village_uuid FROM land_bank_details WHERE dist_code =  ? AND status =  ? group by village_uuid";
      // $pendingListQuery = $this->db->query($pendingListSql, array($dist_code,LAND_BANK_STATUS_FORWARD));
      // $pending_list = $pendingListQuery->result();
      // $array = json_decode(json_encode($pending_list),true);
      //  $villageUUIDarr = array_column($array, 'village_uuid');
      //  var_dump($villageUUIDarr);
      //   // $villageUUIDStr = implode(',', $villageUUIDarr);
      //   // $villageUUIDStr =  implode ( "', ", $villageUUIDarr );
      //  $villageUUIDStr = implode ( ",", $villageUUIDarr );
      //   // $villageUUIDStr = implode(', ', array_map(function($val){return sprintf("'%s'", $val);}, $villageUUIDarr));
      //   var_dump($villageUUIDStr);
      //   if($villageUUIDStr == ""){
      //       return [];
      //   }
      
      $this->db->select('*');
      $this->db->where('dist_code', $dist_code);
      // $this->db->where_in('village_uuid', $villageUUIDStr);
      $this->db->where('status',LAND_BANK_STATUS_FORWARD);
      // $this->db->where('application_no',null);/////changed as per discuss JAYANTA AND MRIDU SIR/////
      $this->db->limit($length, $start);
      $query = $this->db->get('land_bank_details');
      // log_message('error',$this->db->last_query());
      if($query->num_rows()>0){
          $data['data_results'] = $query->result();
          if(!empty($cir_code)){
          $this->db->where('cir_code', $cir_code);
          }
          if(!empty($village_code)){
            $this->db->where('village_uuid', $village_code);
          }
          if(!empty($subdiv_code)){
            $this->db->where('subdiv_code', $subdiv_code);
          }
          if(!empty($dags)){
            $this->db->where('dag_no', $dags);
          }
          $this->db->where('dist_code', $dist_code);
          // $this->db->where_in('village_uuid', $villageUUIDStr);
          $this->db->where('status',LAND_BANK_STATUS_FORWARD);
          // $this->db->where('application_no',null);/////changed as per discuss JAYANTA AND MRIDU SIR/////
          $this->db->limit($length, $start);
          $data['total_records']= $this->db->count_all_results('land_bank_details');
          return $data;
      }
  }
  //generating for save and delete data of encracoher=========
  public function lbOldDataSaveAndDeleteDC($lb_details_id,$encroacher_id_dc,$lb_delete_rmk_dc){
        date_default_timezone_set("Asia/Calcutta");  
        $sql = 'select * from land_bank_details where id=? and application_no is null';
        $query = $this->db->query($sql,array($lb_details_id));
        $result = $query->result_array();
        $land_bank_existing_details = $this->db->select('*')->from('land_bank_encroacher_details')->where("id IN (".trim($encroacher_id_dc).")")->get()->result_array();
        $arrayForInsertVlb = array(
            'landbankid'  => $lb_details_id,
            'deleted_vlb' => json_encode($result),
            'deleted_enc' => json_encode($land_bank_existing_details),
            'deleted_remarks' => $lb_delete_rmk_dc ,
            'deleted_user' => $this->session->all_userdata()['user_code'],
            'deleted_date_time' => date('Y-m-d H:i:s')
        );
        $insertCheckStatus = $this->db->insert('deleted_vlb_data', $arrayForInsertVlb);
        if ($insertCheckStatus != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBDC00989U, Error in insert on deleted_vlb_data table".$lb_details_id);
            return 0;
        }
    
        if ($land_bank_existing_details != null && $land_bank_existing_details!='')
        {
            $this->db->where('land_bank_details_id', $lb_details_id)->where("id IN (".trim($encroacher_id_dc).")")->delete('land_bank_encroacher_details');
            if($this->db->affected_rows()<=0){ 
                $this->db->trans_rollback();
                log_message("error", "#LBDC094394, Error in delete, table 'land_bank_encroacher_details' with enc id ".$encroacher_id_dc);
                return 0;
            }
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBDC0054545U, Transaction Status Error In Land Bank Tables on Deletion in DC login");
            return 0;
        }else{
            
            return 1;
        } 

    }


    //lb details approve handle for settlement application cases---------29122022 
    public function lbdetailsApproveSettlementCases($lb_details_id, $elb_enc_id,$uuid,$dag_no,$application_no,$lb_approval_rmk){
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");  
        //getting the location,dag and year details frtom land bank details table
        $this->db->select('*')
                    ->where('id',  $lb_details_id)
                    ->where('village_uuid',  $uuid)
                    ->where('dag_no',  $dag_no)
                    ->from('land_bank_details');                
        $query = $this->db->get(); 
        $lb_details = $query->row();
        if(count($lb_details) > 0){
            //update data in land bank details
            $this->db->where('id', $lb_details_id)
                     ->where('village_uuid',  $uuid)
                     ->where('dag_no',  $dag_no)
                     ->update('land_bank_details', array(
                                                        'status' => LAND_BANK_STATUS_APPROVED
                                                    ));     
            if($this->db->affected_rows() != 1){ 
                //if error in update--------
                log_message("error", "#LBSETL001, Error in update, table 'land_bank_details' in changing status to approved");
                return ['st' => 0, 'msg' => 'Updation Error-LBD, Error-Code : #LBSETL001'];
            }
        }else{
            log_message("error", "#LBSETL003, Error in fetch, table 'land_bank_details' in changing status to approved");
            return ['st' => 0, 'msg' => 'Fetch Data Error-LBD, Error-Code : #LBSETL003'];
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
            log_message("error", "#LBSETL002, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
            return ['st' => 0, 'msg' => 'Updation Error-LBPD, Error-Code : #LBSETL002'];
        }
        
        //insert data in c_land_bank_details table -------------
        $this->db->select('id')
                    ->where('village_uuid',  $uuid)
                    ->where('dag_no',  $dag_no)
                    ->from('c_land_bank_details');                
        $query = $this->db->get(); 
        $c_lb_id = $query->row()->id;
        if ($c_lb_id == null || $c_lb_id == '' )
        {
            log_message("error", "#LBSETLE4U, Error in fetch on c_land_bank_details table");
            return ['result' => false, 'msg' => 'Insert Error -LBCB, Error-Code : #LBSETLE4U'];
        }

        //return $c_land_bank_inserted_id;
        //getting data from land bank encroacher details
        $this->db->select('*')
                ->where('land_bank_details_id',  $lb_details_id)
                ->where('application_no',  $application_no)
                ->where('id',$elb_enc_id)
                ->from('land_bank_encroacher_details'); 
        $query = $this->db->get(); 
        $lb_encroacher_details_array = $query->row_array();
        //insert data in the land bank encroacher details 
        unset($lb_encroacher_details_array['land_bank_details_id']);
        $lb_encroacher_details_array['c_land_bank_details_id'] = $c_lb_id;
        $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $lb_encroacher_details_array); 
        if ($tstatus3 != 1 )
        {
            log_message("error", "#LBSETLE05U, Error in insert on c_land_bank_encroacher_details table");
            return ['result' => 0, 'msg' => 'Insert Error -LBENCT, Error-Code : #LBSETLE05U'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            log_message("error", "#LBSETLE06U, Transaction Status Error");
            return ['st' => 0, 'msg' => 'Something went wrong, Error-Code : #LBSETLE06U'];
        }else{
            return ['st' => 0, 'msg' => 'Land Bank Details Approved Successfully!'];
        } 
    }
}
?>