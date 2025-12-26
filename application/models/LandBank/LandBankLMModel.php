<?php

class LandBankLMModel extends CI_Model {

    //getting all the master table gender list 
    public function getAllGenderList(){
        $sql = "Select * from master_gender";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return json_encode($query->result()); 
    }

    //getting all the master table caste list 
    public function getAllCasteList(){
        $sql = "Select * from master_caste";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return json_encode($query->result()); 
    }
    public function getPendingLbCount($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no){
        $this->db->select('count(*)')
                ->where_in('status', array(LAND_BANK_STATUS_PENDING,LAND_BANK_STATUS_FORWARD))
                ->where('dist_code', $this->session->userdata('dist_code'))
                ->where('subdiv_code',$this->session->userdata('subdiv_code'))
                ->where('cir_code', $this->session->userdata('cir_code'))
                ->where('mouza_pargona_code', $mouza_code)
                ->where('lot_no', $lot_no)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        // echo $this->db->last_query();
        if($query->num_rows() > 0 ){
            return $query->row()->count;
        }else{
            return 0;
        }
    }
    // getting unique village id 
    public function getVillageUUID($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){
        
        $sql = "select uuid from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code  = ?";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code, '0000'));        
        $result = $query->result(); 

        if(count($result) != 0 ){
            return $result[0]->uuid;
        }else{
            return 0;
        }
    }

    //getting village list with govt daag
    public function getVillageListWithGovtDaag($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no, $flag) {

        if($flag == 1){
            $sql = "select distinct on (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code) dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code from chitha_basic where dist_code=? and subdiv_code=? 
                and cir_code=? and mouza_pargona_code=? and lot_no=? and patta_type_code in 
                (select type_code from patta_code where jamabandi='n' or pattatype_eng like '%GRAM%' or ins_flag = 'y') and 
                (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
		        and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no)
                not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                dag_no from land_bank_details where dist_code=? and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and status in (?,?)) and (dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code) in (select dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code from location where (nc_btad is null or nc_btad='K'))";

                $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,
                $dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,LAND_BANK_STATUS_PENDING, LAND_BANK_STATUS_APPROVED));
        
        }else{
            $sql = "select distinct vill_townprt_code from chitha_basic where dist_code = ? and subdiv_code = ?
                and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and patta_type_code  in 
                (select type_code from patta_code where jamabandi='n' or pattatype_eng like '%GRAM%') and 
                (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and 
                (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                location where (nc_btad is null or TRIM(nc_btad) = '' or nc_btad='K'))";        
                
                $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));
        }
    
        //echo $this->db->last_query();
        $village_codes = $query->result(); 
        $villageCodeWithNames =  array();
        foreach($village_codes as $village_code){
            array_push($villageCodeWithNames, [
                'village_code' => $village_code->vill_townprt_code,
                'village_name' => $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code->vill_townprt_code)
            ]);
        }
        return $villageCodeWithNames;
    }

    // getting land details
    public function getLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code) {
        // (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and ----changed in 28032023
        $sql = "select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and patta_type_code  in 
                (select type_code from patta_code where jamabandi='n' or pattatype_eng like '%GRAM%' or ins_flag='y') and 
                
                (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                location where (nc_btad is null or TRIM(nc_btad) = '' or nc_btad='K'))";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code));
        //echo $this->db->last_query();
        return $query->result(); 
    }

    //getting lm update form details
    public function getLbLmUpdateFormDetails($dist_code,$subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag_no){
        $sql = "select * from c_land_bank_details where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ? order by id desc";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no, $vill_code, $dag_no));
        $land_bank_details = $query->result(); 
        //if no data found 
        if(empty($land_bank_details)){
            return ['result' => false, 'data' => NULL];
        }else{
            //if data not empty             
            $this->db->select("*")->from('c_land_bank_encroacher_details')->where('c_land_bank_details_id', $land_bank_details[0]->id);
            $query = $this->db->get(); 
            $land_bank_encroacher_details = $query->result();
            return ['result' => true,'land_bank_details' => $land_bank_details, 'land_bank_encroacher_details' => $land_bank_encroacher_details];
        }    
    }

    //insert new lb details (if previous data is not found)
    //status will be set to pending
    public function insertNewLbDetails($insertion_data_for_land_bank_details,$insertion_data_for_encroacher_details_arr,
    $diff_year_flag,$prev_year, $encroacher_list_excel_file_arr){
        //for ignoring the last inserted id warning in respose
        error_reporting(0);
        $this->db->trans_begin();           
        //insertion in land bank details
        $tstatus1 = $this->db->insert('land_bank_details', $insertion_data_for_land_bank_details);               
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LB001, Error in insert, table 'land_bank_details' with data :". json_encode($insertion_data_for_land_bank_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB001'];
        }                        
        //insertion of land bank encroacher details
        $land_bank_inserted_id = $this->db->insert_id(); 
        $t_land_bank_encroacher_details_ins_arr = array();
        foreach ($insertion_data_for_encroacher_details_arr as $insertion_data_for_encroacher_details){
            $insertion_data_for_encroacher_details['land_bank_details_id'] =  $land_bank_inserted_id;
            $tstatus2 = $this->db->insert('land_bank_encroacher_details', $insertion_data_for_encroacher_details);
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LB002, Error in insert, table 'land_bank_encroacher_details' with data :". json_encode($insertion_data_for_encroacher_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB002'];
            }
            //creating a new array for t land bank encroacher details
            $land_bank_encroacher_inserted_id = $this->db->insert_id(); 
            unset($insertion_data_for_encroacher_details['land_bank_details_id']);
            $insertion_data_for_encroacher_details['land_bank_encroacher_details_id'] =  $land_bank_encroacher_inserted_id;
            array_push($t_land_bank_encroacher_details_ins_arr, $insertion_data_for_encroacher_details);
        }
        // handling the excel file encroacher list
        $t_land_bank_encroacher_details_ins_arr_excel = array();
        foreach ($encroacher_list_excel_file_arr as $insertion_data_for_encroacher_details){
            $insertion_data_for_encroacher_details['land_bank_details_id'] =  $land_bank_inserted_id;
            $tstatusE1 = $this->db->insert('land_bank_encroacher_details', $insertion_data_for_encroacher_details);
            if ($tstatusE1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBE001, Error in insert of excel file data, table 'land_bank_encroacher_details' with data :". json_encode($insertion_data_for_encroacher_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBE001'];
            }
            //creating a new array for t land bank encroacher details
            $land_bank_encroacher_inserted_id = $this->db->insert_id(); 
            unset($insertion_data_for_encroacher_details['land_bank_details_id']);
            $insertion_data_for_encroacher_details['land_bank_encroacher_details_id'] =  $land_bank_encroacher_inserted_id;
            array_push($t_land_bank_encroacher_details_ins_arr_excel, $insertion_data_for_encroacher_details);
        }


        //insertion of t land bank details
        $tstatus1 = $this->db->insert('t_land_bank_details', $insertion_data_for_land_bank_details);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LB003, Error in insert, table 't_land_bank_details' with data :". json_encode($insertion_data_for_land_bank_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB003'];
        }
        //insertion of t land bank encroacher details 
        $t_land_bank_inserted_id = $this->db->insert_id();
        foreach ($t_land_bank_encroacher_details_ins_arr as $insertion_data_for_encroacher_details){
            $insertion_data_for_encroacher_details['t_land_bank_details_id'] =  $t_land_bank_inserted_id;         
            $tstatus2 = $this->db->insert('t_land_bank_encroacher_details', $insertion_data_for_encroacher_details);
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LB004, Error in insert, table 't_land_bank_encroacher_details' with data :". json_encode($insertion_data_for_encroacher_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB004'];
            }
        }
        //insertion excel file list in t lnd bank encroacher files 
        foreach ($t_land_bank_encroacher_details_ins_arr_excel as $insertion_data_for_encroacher_details){
            $insertion_data_for_encroacher_details['t_land_bank_details_id'] =  $t_land_bank_inserted_id;         
            $tstatusE2 = $this->db->insert('t_land_bank_encroacher_details', $insertion_data_for_encroacher_details);
            if ($tstatusE2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBE002, Error in insert excel file list, table 't_land_bank_encroacher_details' with data :". json_encode($insertion_data_for_encroacher_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBE002'];
            }
        }
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LB005, Transaction Status Error In Land Bank Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB005'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Bank Details Added Successfully And Forwarded To CO For Approval!'];
        }  
    }

    //getting unique village ids in land bank details 
    public function getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code, $mouza_code, $lot_no){
        $this->db->distinct()->select('village_uuid')
                ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                ->where('cir_code', $cir_code)->where('mouza_pargona_code',$mouza_code)
                ->where('lot_no', $lot_no)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }

    //getting recent pending list for each dag no 
    public function getLbPendingList($uniqueVillageIdsInLandBankDetails){
        //old code ---------------------29032023
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
        //         ->where_in('status', array(LAND_BANK_STATUS_PENDING,LAND_BANK_STATUS_FORWARD))
        //         ->from('land_bank_details');
        //         $query = $this->db->get(); 
        //         if(!empty($query->result())){
        //             array_push($pendingListArr, $query->result()[0]);
        //         }
        //     }            
        // }
        // return $pendingListArr; 

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
                           and status IN (?,?) and application_no is null";
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_PENDING,LAND_BANK_STATUS_FORWARD));      
        $pending_list = $pendingListQuery->result();
        return $pending_list;  
    }

    //getiing the recent reverted list
    public function getLbRevertedList($uniqueVillageIdsInLandBankDetails){
        $revertedListArr = array();
        foreach($uniqueVillageIdsInLandBankDetails as $villageId){
            //getting unique dag no from each villages
            $this->db->distinct()->select("dag_no")
            ->where('village_uuid', $villageId->village_uuid)
            ->from('land_bank_details');
            $query = $this->db->get(); 
            $dagVillageWise = $query->result();
            //return $dagVillageWise;
            //populating the pending list
            foreach($dagVillageWise as $dag_no){
                $this->db->select("*")
                ->order_by('id',"DESC")
                ->where('village_uuid', $villageId->village_uuid)
                ->where('dag_no', $dag_no->dag_no)
                ->where('status', 'R')
                ->from('land_bank_details');
                $query = $this->db->get();                 
                if(!empty($query->result())){
                    array_push($revertedListArr, $query->result()[0]);
                }                
            }            
        }
        return $revertedListArr;
    }

    //getting the total lot wise govt daag count
    public function getLotWiseTotalGovtDagCount($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no){
        
        $sql = "select count(*) from chitha_basic where 
                (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                location where (nc_btad is null or TRIM(nc_btad) = '' or nc_btad='K')) and dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and patta_type_code  in 
                (select type_code from patta_code where jamabandi='n' or or pattatype_eng like '%GRAM%') and 
                (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0";        
        //old query
        //$sql = "select count(*) from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? 
        //and mouza_pargona_code = ? and lot_no = ? and patta_type_code  in 
        //(select type_code from patta_code where jamabandi='n') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));
        //return $this->db->last_query();
        //echo $this->db->last_query();
        return $query->row()->count; 

        
    }

    //getting lb data from id
    public function getLbDataFromId($lb_details_id)
    {
        $sql = "select * from land_bank_details where id = ?";
        $query = $this->db->query($sql,array($lb_details_id));        
        $land_bank_details = $query->result(); 
        $sql = "select * from land_bank_encroacher_details where land_bank_details_id = ?";
        $query = $this->db->query($sql,array($land_bank_details[0]->id));        
        $land_bank_encroacher_details = $query->result(); 
        return ['land_bank_details' => $land_bank_details, 'land_bank_encroacher_details' => $land_bank_encroacher_details];
    }

    // getting approved lb data from c land band details
    public function getApprovedLbDataFromId($lb_details_id){
        $sql = "select * from c_land_bank_details where id = ?";
        $query = $this->db->query($sql,array($lb_details_id));        
        $land_bank_details = $query->result(); 
        $sql = "select * from c_land_bank_encroacher_details where c_land_bank_details_id = ?";
        $query = $this->db->query($sql,array($land_bank_details[0]->id));        
        $land_bank_encroacher_details = $query->result(); 
        return ['land_bank_details' => $land_bank_details, 'land_bank_encroacher_details' => $land_bank_encroacher_details];
    }

    //update in land bank details for same year entry
    public function updateSameYearLbDetails($updation_data_for_land_bank_details,
    $update_data_for_encroacher_details_arr, $new_enc_insert_data_in_updation_arr,$existing_enc_arr_in_update,
    $land_bank_whether_encroached_flag, $encroacher_list_excel_file_arr){        
        error_reporting(0);
        $village_uuid = $updation_data_for_land_bank_details['village_uuid'];
        $year = $updation_data_for_land_bank_details['year'];
        $dag_no = $updation_data_for_land_bank_details['dag_no'];
        $land_bank_existing_details = $this->db->select('*')->from('land_bank_details')->where('village_uuid', $village_uuid)->where('dag_no', $dag_no)->get()->row();
        $this->db->trans_begin();  

        //*****************************************/START ADDING IF NOT IN LAND BANK BUT IN C_LAND
        $landBankIdForInsertOldRowDataInEnc = $land_bank_existing_details->id;
        $sqlForFetch ='select cl.*  from c_land_bank_details  cb join c_land_bank_encroacher_details cl 
                        on cb.id=cl.c_land_bank_details_id
                        where  cb.village_uuid=?
                        and cb.dag_no=? and cl.id not in (
                            select id from land_bank_encroacher_details where land_bank_details_id=?
                        )';
        $encroacherListNotInLB = $this->db->query($sqlForFetch,array($village_uuid,$dag_no,$landBankIdForInsertOldRowDataInEnc))->result_array();

        
        if($encroacherListNotInLB !=null && sizeof($encroacherListNotInLB) > 0){
            
            foreach ($encroacherListNotInLB as $key => $encroacherListNotInLB) {
                unset($encroacherListNotInLB['c_land_bank_details_id']);
                $encroacherListNotInLB['land_bank_details_id'] =  $landBankIdForInsertOldRowDataInEnc;
                $lbeInsertAffectedCount = $this->db->insert('land_bank_encroacher_details', $encroacherListNotInLB);        
                if($lbeInsertAffectedCount <= 0 ){
                    $this->db->trans_rollback();
                    log_message("error", "#LBSY00999UM, Error in insert on updation which was not in c_land_bank_details, table 'land_bank_encroacher_details' with data :". json_encode($encroacherListNotInLB));
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY00999UM'];
                }
            }
            
            
        }
        //*****************************************/END--



        
        //*****************************************/
        //update land bank details 
        $this->db->where('id', $land_bank_existing_details->id)->update('land_bank_details', $updation_data_for_land_bank_details);  
        if($this->db->affected_rows() != 1){ 
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#LBSY001U, Error in update, table 'land_bank_details' with data :". json_encode($updation_data_for_land_bank_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY001U'];
        }    
        //*****************************************/
        //update land bank encroacher details 
        //delete in land bank encroacher details
        $sql = "select id from land_bank_encroacher_details where land_bank_details_id = ?";
        $query = $this->db->query($sql,array($land_bank_existing_details->id));
        $existing_encraocher_ids_obj = $query->result();
        $existing_encraocher_ids_arr = array();
        foreach($existing_encraocher_ids_obj as $existing_encraocher_id){
            array_push($existing_encraocher_ids_arr, $existing_encraocher_id->id);
        }
        //if whether encroached is "No" then delete all the existing encroacher
        if($land_bank_whether_encroached_flag == 'N'){
            foreach($existing_encraocher_ids_arr as $existting_enc_id_to_be_deleted){
                $this->db->where('id', $existting_enc_id_to_be_deleted)->delete('land_bank_encroacher_details');
                if($this->db->affected_rows() != 1){ 
                    $this->db->trans_rollback();
                    log_message("error", "#LBSY002U, Error in delete, table 'land_bank_encroacher_details' with id ".$existting_enc_id_to_be_deleted);
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY002U'];
                }    
            }    
        }else{
            $existting_enc_ids_to_be_deleted = array_diff($existing_encraocher_ids_arr, $existing_enc_arr_in_update);                
            foreach($existting_enc_ids_to_be_deleted as $existting_enc_id_to_be_deleted){
                $this->db->where('id', $existting_enc_id_to_be_deleted)->delete('land_bank_encroacher_details');
                if($this->db->affected_rows() != 1){ 
                    //if no updation made
                    $this->db->trans_rollback();
                    log_message("error", "#LBSY003U, Error in delete, table 'land_bank_encroacher_details' with id ".$existting_enc_id_to_be_deleted);
                    return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY003U'];
                }
            }
        }            
        //update in land bank encroacher details  
        $new_t_enc_insert_data_in_updation_arr = array();
        foreach ($update_data_for_encroacher_details_arr as $update_data_for_encroacher_details){
            $enc_id = $update_data_for_encroacher_details['existing_id'];            
            unset($update_data_for_encroacher_details['existing_id']);
            $update_data_for_encroacher_details['land_bank_details_id'] =  $land_bank_existing_details->id;
            $this->db->where('id', $enc_id)->where('land_bank_details_id',$land_bank_existing_details->id)->update('land_bank_encroacher_details', $update_data_for_encroacher_details);  
            if($this->db->affected_rows() != 1){ 
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#LBSY004U, Error in update(existing), table 'land_bank_encroacher_details' with data :". json_encode($updation_data_for_land_bank_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY004U'];
            }
            unset($update_data_for_encroacher_details['land_bank_details_id']);
            $update_data_for_encroacher_details['land_bank_encroacher_details_id'] = $enc_id;
            array_push($new_t_enc_insert_data_in_updation_arr, $update_data_for_encroacher_details); 
        }  
        //insert all the new encroachers        
        foreach ($new_enc_insert_data_in_updation_arr as $new_enc_insert_data_in_updation){            
            $new_enc_insert_data_in_updation['land_bank_details_id'] =  $land_bank_existing_details->id;
            $tstatus4 = $this->db->insert('land_bank_encroacher_details', $new_enc_insert_data_in_updation);            
            if ($tstatus4 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBSY005U, Error in insert(new) on updation, table 'land_bank_encroacher_details' with data :". json_encode($new_enc_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY005U'];
            }
            //creatng a new enc insert array for t land bank encroacher details 
            unset($new_enc_insert_data_in_updation['land_bank_details_id']);
            $new_enc_insert_data_in_updation['land_bank_encroacher_details_id'] = $this->db->insert_id();
            array_push($new_t_enc_insert_data_in_updation_arr, $new_enc_insert_data_in_updation);            
        }    

        $new_t_enc_insert_data_in_updation_arr_excel = array();
        // insert new encroacher in land bank details from excel file
        foreach ($encroacher_list_excel_file_arr as $new_enc_insert_data_in_updation){            
            $new_enc_insert_data_in_updation['land_bank_details_id'] =  $land_bank_existing_details->id;
            $tstatusE1 = $this->db->insert('land_bank_encroacher_details', $new_enc_insert_data_in_updation);            
            if ($tstatusE1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBEU001, Error in insert(new) excel list on updation, table 'land_bank_encroacher_details' with data :". json_encode($new_enc_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBEU001'];
            }
            //creatng a new enc insert array for t land bank encroacher details 
            unset($new_enc_insert_data_in_updation['land_bank_details_id']);
            $new_enc_insert_data_in_updation['land_bank_encroacher_details_id'] = $this->db->insert_id();
            array_push($new_t_enc_insert_data_in_updation_arr_excel, $new_enc_insert_data_in_updation);            
        }    

        //*****************************************/
        //insert in t land bank details         
        $tstatus1 = $this->db->insert('t_land_bank_details', $updation_data_for_land_bank_details);        
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#LBSY006U, Error in insert on updation, table 't_land_bank_details' with data :". json_encode($updation_data_for_land_bank_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY006U'];
        }        
        $t_land_bank_inserted_id = $this->db->insert_id();
        //*****************************************/
        //inserting new encroacher in t_land_bank_encracher_details
        foreach ($new_t_enc_insert_data_in_updation_arr as $new_enc_insert_data_in_updation){
            $new_enc_insert_data_in_updation['t_land_bank_details_id'] =  $t_land_bank_inserted_id;
            $tstatus2 = $this->db->insert('t_land_bank_encroacher_details', $new_enc_insert_data_in_updation);
            if ($tstatus2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBSY007U, Error in insert(new) on updation, table 't_land_bank_encroacher_details' with data :". json_encode($new_enc_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY007U'];
            }
        }
        //inserting new encroacher in t_land_bank_encracher_details from excel file
        foreach ($$new_t_enc_insert_data_in_updation_arr_excel as $new_enc_insert_data_in_updation){
            $new_enc_insert_data_in_updation['t_land_bank_details_id'] =  $t_land_bank_inserted_id;
            $tstatusE2 = $this->db->insert('t_land_bank_encroacher_details', $new_enc_insert_data_in_updation);
            if ($tstatusE2 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error", "#LBEU002, Error in insert(new) excel list on updation, table 't_land_bank_encroacher_details' with data :". json_encode($new_enc_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY007U'];
            }
        }
        //*****************************************/
        //checking transaction status
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#LBSY0010U, Transaction Status Error In Land Bank Tables on Updation");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LBSY0010U'];
        }else{
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Bank Details Updated Successfully And Forwarded to CO For Approval!'];
        }  
    }

    //getting unique village ids from c land bank details table
    public function getUniqueVillageIdsInCLandBankDetails($dist_code,
        $subdiv_code, $cir_code, $mouza_code, $lot_no){
            $this->db->distinct()->select('village_uuid')
                ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                ->where('cir_code', $cir_code)->where('mouza_pargona_code',$mouza_code)
                ->where('lot_no', $lot_no)
                ->from('c_land_bank_details');
        $query = $this->db->get(); 
        return $query->result();
    }

    //getting the approved list
    public function getLbApprovedList($uniqueVillageIdsInCLandBankDetails){

        // old code -----
        // $approvedListArr = array();
        // foreach($uniqueVillageIdsInCLandBankDetails as $villageId){
        //     //getting unique dag no from each villages
        //     $this->db->distinct()->select("dag_no")
        //     ->where('village_uuid', $villageId->village_uuid)
        //     ->from('c_land_bank_details');
        //     $query = $this->db->get(); 
        //     $dagVillageWise = $query->result();
        //     //return $dagVillageWise;
        //     //populating the pending list
        //     foreach($dagVillageWise as $dag_no){
        //         $this->db->select("*")
        //         ->where('village_uuid', $villageId->village_uuid)
        //         ->where('dag_no', $dag_no->dag_no)
        //         ->where('status', 'A')
        //         ->from('c_land_bank_details');
        //         $query = $this->db->get(); 
        //         if(!empty($query->result())){
        //             array_push($approvedListArr, $query->result()[0]);
        //         }
        //     }            
        // }
        // return $approvedListArr;


        //converting the object into array
        $array = json_decode(json_encode($uniqueVillageIdsInCLandBankDetails),true);
        $villageUUIDarr = array_column($array, 'village_uuid');
        $villageUUIDStr = implode(',', $villageUUIDarr);
        // if no entry exits
        if($villageUUIDStr == ""){
            return [];
        }
        // return $villageUUIDStr;
        $pendingListSql = "select * from c_land_bank_details where village_uuid in (".$villageUUIDStr.")
                           and status=?";
        $pendingListQuery = $this->db->query($pendingListSql, array(LAND_BANK_STATUS_APPROVED));        
        $pending_list = $pendingListQuery->result();
        return $pending_list;
    }

    //Getting approved count
    public function getLbApprovedCount($dist_code, $subdiv_code,$cir_code, $mouza_code, $lot_no){
        $this->db->select("count(*)")
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('cir_code', $cir_code)
                ->where('mouza_pargona_code', $mouza_code)
                ->where('lot_no', $lot_no)
                ->from('c_land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->count;
    }

    //getting lb rejected count
    public function getLbRejectedCount($dist_code, $subdiv_code,$cir_code, $mouza_code, $lot_no){
        $this->db->select("dag_no")
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('cir_code', $cir_code)
                ->where('mouza_pargona_code', $mouza_code)
                ->where('lot_no', $lot_no)
                ->where('status', LAND_BANK_STATUS_REVERT_BACK) 
                ->from('land_bank_details');
        $query = $this->db->get(); 
        $dag_no_array = $query->result_array();
        $dag_no_arr =  array_column($dag_no_array, 'dag_no');
        $unique_arr = array_unique($dag_no_arr);
        return count($unique_arr);
    }

    //getting the reject rmk 
    public function getLBrejectedRmk($lb_details_id){
        $this->db->select("*")
                ->order_by('id',"DESC")
                ->where('land_bank_details_id', $lb_details_id)
                ->where('status', LAND_BANK_STATUS_REVERT_BACK)
                ->from('land_bank_proceeding_details');
        $query = $this->db->get(); 
        return $query->row();
    }

    //checking previous entries
    public function checkPreviousEntries($dist_code,$subdiv_code,$circle_code, $mouza_code, $lot_no,
    $vill_code, $lb_lm_update_form_dag_no){
        $this->db->select("*")
                ->order_by('id',"DESC")
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('cir_code', $circle_code)
                ->where('mouza_pargona_code', $mouza_code)
                ->where('lot_no', $lot_no)
                ->where('vill_townprt_code', $vill_code)
                ->where('dag_no ', $lb_lm_update_form_dag_no)
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->row();       
    }

    //getting the last inserted id 
    public function getLastLbInsertedId(){
        $this->db->select("id")
                ->order_by('id',"DESC")
                ->from('land_bank_details');
        $query = $this->db->get(); 
        return $query->row()->id;  
    }

    //getting all the lb dag count
    public function getDagCountFromLb($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no){

        $sql = "select count(*) as c from (select distinct on (village_uuid, dag_no) count(*) as c from land_bank_details where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? group by village_uuid, dag_no) t";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));        
        //echo $this->db->last_query();
        if($query->num_rows() > 0 ){
            return $query->row()->c;
        }else{
            return 0;
        }
    }
    
    //getting rejected without approved vlb counts
    public function getRejectedWithoutApproveCount($dist_code, $subdiv_code,$cir_code, $mouza_code, $lot_no){
        //echo $dist_code.".###". $subdiv_code.".###".$cir_code.".###". $mouza_code.".###". $lot_no;
        $sql = "select count(*) from land_bank_details where status = 'R' and 
        subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?
        and (dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
        vill_townprt_code, dag_no) not in 
        (select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
        vill_townprt_code, dag_no from c_land_bank_details where subdiv_code=? and 
         cir_code=? and mouza_pargona_code=? and lot_no=? )";
        $query = $this->db->query($sql, array($subdiv_code,$cir_code, $mouza_code, $lot_no, $subdiv_code,$cir_code, $mouza_code, $lot_no));
        if($query->num_rows()>0)
            return $query->row()->count;
        else
            return  0;
    }

    //getting overall pending count
    //count of dags which are present in chitha but not in c land bank details 
    public function getOverallPendingCount($dist_code, $subdiv_code,
    $cir_code, $mouza_code, $lot_no){

        $sql2= "select count(*) as c from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=? and  patta_type_code in (select type_code from patta_code 
                where jamabandi='n' or pattatype_eng like '%GRAM%') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
			    and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(dag_no)) 
                not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                trim(dag_no) from c_land_bank_details where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=?) and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code) in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code from location where (nc_btad is null or nc_btad='K'))";
		
        $overallpending=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code,$mouza_code, $lot_no, 
        $dist_code,$subdiv_code,$cir_code,$mouza_code, $lot_no));
        if($overallpending->num_rows()>0){
            $overallpending=$overallpending->row()->c;
        }else{
            $overallpending=0;
        }
        return $overallpending;
    }

    //get VGR dag list 
    public function getVgrLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){
        $sql = "SELECT cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc, clb.dag_no, cb.land_class_code 
                FROM c_land_bank_details clb join chitha_basic cb on 
                clb.dist_code = cb.dist_code and clb.subdiv_code = cb.subdiv_code and
                clb.cir_code = cb.cir_code and clb.mouza_pargona_code =cb.mouza_pargona_code and
                clb.lot_no = cb.lot_no and clb.vill_townprt_code = cb.vill_townprt_code and 
                clb.dag_no = cb.dag_no join land_bank_details lbd on
                clb.dist_code = lbd.dist_code and clb.subdiv_code = lbd.subdiv_code and
                clb.cir_code = lbd.cir_code and clb.mouza_pargona_code =lbd.mouza_pargona_code and
                clb.lot_no = lbd.lot_no and clb.vill_townprt_code = lbd.vill_townprt_code and 
                clb.dag_no = lbd.dag_no WHERE clb.dist_code=? AND clb.subdiv_code=?
                AND clb.cir_code = ? AND clb.mouza_pargona_code = ? AND clb.lot_no = ?
                AND clb.vill_townprt_code = ? AND clb.nature_of_reservation = 1
                and lbd.status !=? ";

        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,
                $vill_code, LAND_BANK_STATUS_PENDING));
        //echo $this->db->last_query();
        return $query->result(); 

    }

    //getting pgr dag list
    public function getPgrLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){
        $sql = "SELECT cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc, clb.dag_no, cb.land_class_code 
                FROM c_land_bank_details clb join chitha_basic cb on 
                clb.dist_code = cb.dist_code and clb.subdiv_code = cb.subdiv_code and
                clb.cir_code = cb.cir_code and clb.mouza_pargona_code =cb.mouza_pargona_code and
                clb.lot_no = cb.lot_no and clb.vill_townprt_code = cb.vill_townprt_code and 
                clb.dag_no = cb.dag_no join land_bank_details lbd on
                clb.dist_code = lbd.dist_code and clb.subdiv_code = lbd.subdiv_code and
                clb.cir_code = lbd.cir_code and clb.mouza_pargona_code =lbd.mouza_pargona_code and
                clb.lot_no = lbd.lot_no and clb.vill_townprt_code = lbd.vill_townprt_code and 
                clb.dag_no = lbd.dag_no WHERE clb.dist_code=? AND clb.subdiv_code=?
                AND clb.cir_code = ? AND clb.mouza_pargona_code = ? AND clb.lot_no = ?
                AND clb.vill_townprt_code = ? AND clb.nature_of_reservation = 2
                and lbd.status !=? ";

        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,
                $vill_code, LAND_BANK_STATUS_PENDING));
        //echo $this->db->last_query();
        return $query->result(); 
    }

    public function getVgrPendingCount($dist_code, $subdiv_code,
    $cir_code, $mouza_code, $lot_no){
        $sql = "select count(*) from (select distinct (lbd.id) from land_bank_details lbd join land_bank_encroacher_details lbed 
        on lbd.id = lbed.land_bank_details_id where lbd.status !='P' and lbd.nature_of_reservation=1 and 
        lbed.type_of_encroacher is null and lbd.dist_code=? and lbd.subdiv_code=? and lbd.cir_code=? and 
        lbd.mouza_pargona_code=? and lbd.lot_no=?) as count";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));
        //echo $this->db->last_query();
        return $query->row()->count; 
    }

    public function getPgrPendingCount($dist_code, $subdiv_code,
    $cir_code, $mouza_code, $lot_no){
        $sql = "select count(*) from (select distinct (lbd.id) from land_bank_details lbd join land_bank_encroacher_details lbed 
        on lbd.id = lbed.land_bank_details_id where lbd.status !='P' and lbd.nature_of_reservation=2 and 
        lbed.type_of_encroacher is null and lbd.dist_code=? and lbd.subdiv_code=? and lbd.cir_code=? and 
        lbd.mouza_pargona_code=? and lbd.lot_no=? group by lbd.id) as count";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no));
        //echo $this->db->last_query();
        return $query->row()->count; 
    }
    public function getLBRevertUser($landBankId){
        $sql = "select LEFT(approved_by, 2)  as revert_user from land_bank_proceeding_details where land_bank_details_id=? and status = ?";
        $query = $this->db->query($sql,array($landBankId,LAND_BANK_STATUS_REVERT_BACK));
        //echo $this->db->last_query();
        return $query->row()->revert_user; 
    }
    public function getLandBankID($encID){
        $sql = "select land_bank_details_id from land_bank_encroacher_details where land_bank_details_id=? and status = ?";
        $query = $this->db->query($sql,array($landBankId,LAND_BANK_STATUS_REVERT_BACK));
        //echo $this->db->last_query();
        return $query->row()->revert_user; 
    }



    //svamitva code
    // public function importOccupiersData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $occupiers, $user_code)
    // {
    //     // check if already imported
    //     $already_done = $this->db->query(
    //         "SELECT id FROM land_bank_import_logs 
    //         WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //         AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
    //         AND success='Y' AND imported_file IS NULL LIMIT 1",
    //         [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code]
    //     )->row();

    //     if ($already_done) {
    //         return ['success' => false, 'message' => 'This village has already been imported successfully.'];
    //     }

    //     $this->db->trans_begin();
    //     foreach ($occupiers as $row) {
    //         $dag_no            = (string)$row['DAG_NO'];
    //         $posessor_name     = $row['POSSESSOR'];
    //         $posessor_guardian = $row['GUARDIAN'];

    //         if (empty($posessor_name)) continue;

    //         // chitha_basic check
    //         $chitha_basic = $this->db->query(
    //             "SELECT * FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //          AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //             [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //         )->row();

    //         if (!$chitha_basic) {
    //             $this->db->trans_rollback();

    //             $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'N', "Dag {$dag_no} not found", $occupiers);
    //             return ['success' => false, 'message' => "Dag {$dag_no} not found"];
    //         }

    //         $village_uuid = $this->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

    //         // prepare land_bank_details data
    //         $lb_data = [
    //             'dist_code'           => $dist_code,
    //             'subdiv_code'         => $subdiv_code,
    //             'cir_code'            => $circle_code,
    //             'mouza_pargona_code'  => $mouza_code,
    //             'lot_no'              => $lot_no,
    //             'vill_townprt_code'   => $vill_code,
    //             'year'                => date('Y'),
    //             'dag_no'              => $dag_no,
    //             'village_uuid'        => $village_uuid,
    //             'created_at'          => date('Y-m-d H:i:s'),
    //             'en_area_b'           => $chitha_basic->dag_area_b,
    //             'en_area_k'           => $chitha_basic->dag_area_k,
    //             'en_area_lc'          => $chitha_basic->dag_area_lc,
    //             'en_area_g'           => $chitha_basic->dag_area_g,
    //             'en_area_kr'          => $chitha_basic->dag_area_kr,
    //             'user_code'           => $user_code,
    //             'nature_of_reservation' => 7,
    //             'whether_encroached'  => 'Y',
    //             'status'              => LAND_BANK_STATUS_PENDING,
    //             'no_of_encroacher'    => 1,
    //             'category_id'         => isset($chitha_basic->category_id) ? $chitha_basic->category_id : null
    //         ];

    //         // insert/find land_bank_details
    //         $existing_lb_num_rows = $this->db->query(
    //             "SELECT * FROM land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //          AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //             [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //         )->num_rows();

    //         if ($existing_lb_num_rows == 0) {
    //             $this->db->insert('land_bank_details', $lb_data);

    //             $existing_lb = $this->db->query(
    //                 "SELECT * FROM land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //              AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //                 [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //             )->row();
    //             $land_bank_details_id = $existing_lb->id;
    //         }else{
    //             //rows found
    //             $existing_lb_row = $this->db->query(
    //                 "SELECT * FROM land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //             AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //                 [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //             )->row();

    //             $update_details = [
    //                 'status' => LAND_BANK_STATUS_PENDING,
    //                 'modified_at' => date('Y-m-d H:i:s'),
    //             ];

    //             $this->db->where('id', $existing_lb_row->id);
    //             $this->db->where('id', $dist_code);
    //             $this->db->where('id', $subdiv_code);
    //             $this->db->where('id', $circle_code);
    //             $this->db->where('id', $mouza_code);
    //             $this->db->where('id', $lot_no);
    //             $this->db->where('id', $vill_code);
    //             $this->db->where('id', $dag_no);
    //             $this->db->update('land_bank_details', $update_details);
    //             if($this->db->affected_rows() != 1){ 
    //                 $this->db->trans_rollback();
    //                 log_message("error", "#EKBI00022, Error in update, table 'ekhajana_basic' with rtps application no ".$data['ld_application_no']);
    //                 return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI00022'];
    //             }
    //         }

    //         // encroacher
    //         $lbe_data = [
    //             'land_bank_details_id' => $land_bank_details_id,
    //             'name'                 => $posessor_name,
    //             'fathers_name'         => $posessor_guardian,
    //             'encroachment_from'    => date('Y-m-d'),
    //             'encroachment_to'      => date('Y-m-d'),
    //             'landless_indigenous'  => 'N',
    //             'erosion'              => 'N',
    //             'landless'             => 'N',
    //             'gender'               => 0,
    //             'caste'                => 0,
    //             'created_at'           => date('Y-m-d H:i:s'),
    //             'landslide'            => 'N',
    //             'type_of_land_use'     => 0
    //         ];
    //         $this->db->insert('land_bank_encroacher_details', $lbe_data);
    //         $lbe_id = $this->db->insert_id();

    //         // insert/find t_land_bank_details
    //         $existing_tlb = $this->db->query(
    //             "SELECT * FROM t_land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //          AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //             [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //         )->row();

    //         if (!$existing_tlb) {
    //             $this->db->insert('t_land_bank_details', $lb_data);
    //             $existing_tlb = $this->db->query(
    //                 "SELECT * FROM t_land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
    //              AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
    //                 [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
    //             )->row();
    //         }

    //         $t_land_bank_details_id = $existing_tlb->id;

    //         unset($lbe_data['land_bank_details_id']);
    //         $lbe_data['t_land_bank_details_id'] = $t_land_bank_details_id;
    //         $lbe_data['land_bank_encroacher_details_id'] = $lbe_id;

    //         $this->db->insert('t_land_bank_encroacher_details', $lbe_data);
    //     }

    //     // commit/rollback
    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'N', 'Transaction failed. Changes rolled back.', $occupiers);
    //         return ['success' => false, 'message' => 'Transaction failed. Changes rolled back.'];
    //     } else {
    //         $this->db->trans_commit();
    //         $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'Y', null, $occupiers);
    //         return ['success' => true, 'message' => 'Occupiers imported successfully.'];
    //     }
    // }

    public function logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, $success, $error_msg, $occupiers=null, $file_path = null)
    {
        $this->db->insert('land_bank_import_logs', [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
            'imported_by'        => $user_code,
            'success'            => $success,
            'error_message'      => $error_msg,
            'occupiers_json'     => json_encode($occupiers),
            'imported_file'      => $file_path
        ]);
    }

    
    public function getVillageListSvamitva($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)
    {
        $villages = $this->db->query("select l_vill.loc_name as vill_name,l.dist_code,l.subdiv_code,l.cir_code,l.mouza_pargona_code,l.lot_no,l.vill_townprt_code from location l
        join location l_vill on l.dist_code = l_vill.dist_code and l.subdiv_code = l_vill.subdiv_code and l.cir_code = l_vill.cir_code and l.mouza_pargona_code = l_vill.mouza_pargona_code and l.lot_no = l_vill.lot_no and l.vill_townprt_code = l_vill.vill_townprt_code
        where l.dist_code = ? and l.subdiv_code = ?  and l.cir_code = ? and l.mouza_pargona_code = ? and l.lot_no = ? and l.vill_townprt_code !='00000' and l.status='1'",[
            $dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no
        ])->result();
        // $villages = $this->db->query("select l_vill.loc_name as vill_name,l.dist_code,l.subdiv_code,l.cir_code,l.mouza_pargona_code,l.lot_no,l.vill_townprt_code from location l
        // join location l_vill on l.dist_code = l_vill.dist_code and l.subdiv_code = l_vill.subdiv_code and l.cir_code = l_vill.cir_code and l.mouza_pargona_code = l_vill.mouza_pargona_code and l.lot_no = l_vill.lot_no and l.vill_townprt_code = l_vill.vill_townprt_code
        // where l.dist_code = ? and l.subdiv_code = ?  and l.cir_code = ? and l.mouza_pargona_code = ? and l.lot_no = ? and l.vill_townprt_code !='00000'", [
        //     $dist_code,
        //     $subdiv_code,
        //     $cir_code,
        //     $mouza_pargona_code,
        //     $lot_no
        // ])->result();
        return $villages;
    }

    public function getVillageVlbs($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code)
    {
        $vlbs = $this->db->query("
        SELECT lb.*,
               COALESCE(
                   string_agg(
                       lbe.name || ' (পিতা: ' || lbe.fathers_name || ')',
                       ', '
                   ),
                   ''
               ) AS encroachers
        FROM land_bank_details lb
        LEFT JOIN land_bank_encroacher_details lbe
               ON lb.id = lbe.land_bank_details_id
        WHERE lb.dist_code = ?
          AND lb.subdiv_code = ?
          AND lb.cir_code = ?
          AND lb.mouza_pargona_code = ?
          AND lb.lot_no = ?
          AND lb.vill_townprt_code = ?
        GROUP BY lb.id
    ", [
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_code
        ])->result();
        return $vlbs;
    }
 

    public function importOccupiersData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $occupiers, $user_code)
    {
        // check if already imported
        $already_done = $this->db->query(
            "SELECT id FROM land_bank_import_logs
         WHERE dist_code=? AND subdiv_code=? AND cir_code=?
           AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?
           AND success='Y' AND imported_file IS NULL LIMIT 1",
            [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code]
        )->row();
        if ($already_done) {
            return ['success' => false, 'message' => 'This village has already been imported successfully.'];
        }
        $this->db->trans_begin();
        foreach ($occupiers as $row) {
            $dag_no            = (string)$row['DAG_NO'];
            $posessor_name     = $row['POSSESSOR'];
            $posessor_guardian = $row['GUARDIAN'];
            if (empty($posessor_name)) continue;
            // chitha_basic check
            $chitha_basic = $this->db->query(
                "SELECT * FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=?
             AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
                [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
            )->row();
            if (!$chitha_basic) {
                $this->db->trans_rollback();
                $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'N', "Dag {$dag_no} not found", $occupiers);
                return ['success' => false, 'message' => "Dag {$dag_no} not found"];
            }
            $village_uuid = $this->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            // prepare land_bank_details data
            $lb_data = [
                'dist_code'           => $dist_code,
                'subdiv_code'         => $subdiv_code,
                'cir_code'            => $circle_code,
                'mouza_pargona_code'  => $mouza_code,
                'lot_no'              => $lot_no,
                'vill_townprt_code'   => $vill_code,
                'year'                => date('Y'),
                'dag_no'              => $dag_no,
                'village_uuid'        => $village_uuid,
                'created_at'          => date('Y-m-d H:i:s'),
                'en_area_b'           => $chitha_basic->dag_area_b,
                'en_area_k'           => $chitha_basic->dag_area_k,
                'en_area_lc'          => $chitha_basic->dag_area_lc,
                'en_area_g'           => $chitha_basic->dag_area_g,
                'en_area_kr'          => $chitha_basic->dag_area_kr,
                'user_code'           => $user_code,
                'nature_of_reservation' => 7,
                'whether_encroached'  => 'Y',
                'status'              => LAND_BANK_STATUS_PENDING,
                'no_of_encroacher'    => 1,
                'category_id'         => isset($chitha_basic->category_id) ? $chitha_basic->category_id : null
            ];
            // insert/find land_bank_details
            $existing_lb = $this->db->query(
                "SELECT * FROM land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=?
             AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
                [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
            )->row();
            if ($existing_lb == null || !$existing_lb) {
                $status = $this->db->insert('land_bank_details', $lb_data);
                if ($status != 1) {
                    $this->db->trans_rollback();
                    log_message('error', 'ER#LBLMMBU01: Insertion failed. Changes rolled back. '.json_encode($lb_data));
                    return ['success' => false, 'message' => 'Insertion failed. Changes rolled back.'];
                }
                $existing_lb = $this->db->query(
                    "SELECT * FROM land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                 AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
                    [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
                )->row();
            } else {
                // update status to pending if already exists
                $this->db->set('status', LAND_BANK_STATUS_PENDING)
                    ->where('id', $existing_lb->id)
                    ->update('land_bank_details');
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', 'ER#LBLMMBU02: Updation failed. Changes rolled back. With Id: ' . $existing_lb->id .' Data: '.json_encode($lb_data));
                    return ['success' => false, 'message' => 'Updation failed. Changes rolled back.'];
                }
            }
            $land_bank_details_id = $existing_lb->id;
            // encroacher
            $lbe_data = [
                'land_bank_details_id' => $land_bank_details_id,
                'name'                 => $posessor_name,
                'fathers_name'         => $posessor_guardian,
                'encroachment_from'    => date('Y-m-d'),
                'encroachment_to'      => date('Y-m-d'),
                'landless_indigenous'  => 'N',
                'erosion'              => 'N',
                'landless'             => 'N',
                'gender'               => 4, 
                'caste'                => 8, 
                'created_at'           => date('Y-m-d H:i:s'),
                'landslide'            => 'N',
                'type_of_land_use'     => 8
            ];
            $status = $this->db->insert('land_bank_encroacher_details', $lbe_data);
            if ($status != 1) {
                $this->db->trans_rollback();
                log_message('error', 'ER#LBLMMBU03: Insertion failed. Changes rolled back. '.json_encode($lbe_data));
                return ['success' => false, 'message' => 'Insertion failed. Changes rolled back.'];
            }
            $lbe_id = $this->db->insert_id();
            // insert/find t_land_bank_details
            $existing_tlb = $this->db->query(
                "SELECT * FROM t_land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=?
             AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
                [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
            )->row();
            if ($existing_tlb == null || !$existing_tlb) {
                $status = $this->db->insert('t_land_bank_details', $lb_data);
                if ($status != 1) {
                    $this->db->trans_rollback();
                    log_message('error', 'ER#LBLMMBU04: Insertion failed. Changes rolled back. '.json_encode($lb_data));
                    return ['success' => false, 'message' => 'Insertion failed. Changes rolled back.'];
                }
                $existing_tlb = $this->db->query(
                    "SELECT * FROM t_land_bank_details WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                 AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?",
                    [$dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no]
                )->row();
            }
            $t_land_bank_details_id = $existing_tlb->id;
            unset($lbe_data['land_bank_details_id']);
            $lbe_data['t_land_bank_details_id'] = $t_land_bank_details_id;
            $lbe_data['land_bank_encroacher_details_id'] = $lbe_id;
            $status = $this->db->insert('t_land_bank_encroacher_details', $lbe_data);
            if ($status != 1) {
                $this->db->trans_rollback();
                log_message('error', 'ER#LBLMMBU05: Insertion failed. Changes rolled back. '.json_encode($lbe_data));
                return ['success' => false, 'message' => 'Insertion failed. Changes rolled back.'];
            }
        }
        // commit/rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'N', 'Transaction failed. Changes rolled back.', $occupiers);
            return ['success' => false, 'message' => 'Transaction failed. Changes rolled back.'];
        } else {
            $this->db->trans_commit();
            $this->logImport($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $user_code, 'Y', null, $occupiers);
            return ['success' => true, 'message' => 'Occupiers imported successfully.'];
        }
    }

}
