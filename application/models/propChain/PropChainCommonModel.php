<?php

class PropChainCommonModel extends CI_Model
{

   //inserting into prop chain audit data 
   public function insertPropChainAuditData($insert_data){      
      //insertion in prop_chain_audit_data
      $tstatus1 = $this->db->insert('prop_chain_audit_data', $insert_data);               
      if ($tstatus1 != 1 )
      {
         $this->db->trans_rollback();
         log_message("error", "#PCAIERR001, Error in insert, table 'prop_chain_audit_data' with data :". json_encode($insert_data));
         return ['result' => false, 'msg' => 'Some error occured, Error-Code : #PCAIERR001'];
      }else{
         return ['result' => true, 'msg' => 'prop_chain_audit_data added successfully'];
      }        
   }

   //inserting into prop chain ror success data
   public function insertPropChainRorSuccessData($insert_data){         
      //insertion in prop_chain_audit_data
      $tstatus1 = $this->db->insert('prop_chain_ror_success_transaction', $insert_data);               
      if ($tstatus1 != 1 )
      {
         $this->db->trans_rollback();
         log_message("error", "#PCAIERR002, Error in insert, table 'prop_chain_ror_success_transaction' with data :". json_encode($insert_data));
         return ['result' => false, 'msg' => 'Some error occured, Error-Code : #PCAIERR002'];
      }else{
         return ['result' => true, 'msg' => 'prop_chain_ror_success_transaction added successfully'];
      }    
   }

   //inserting into prop chain transaction success data
   public function insertPropChainTransactionSuccessData($insert_data){   
      //insertion in prop_chain_audit_data
      $tstatus1 = $this->db->insert('prop_chain_other_success_transaction', $insert_data);               
      if ($tstatus1 != 1 )
      {
         $this->db->trans_rollback();
         log_message("error", "#PCAIERR003, Error in insert, table 'prop_chain_other_success_transaction' with data :". json_encode($insert_data));
         return ['result' => false, 'msg' => 'Some error occured, Error-Code : #PCAIERR003'];
      }else{
         return ['result' => true, 'msg' => 'prop_chain_other_success_transaction added successfully'];
      }    
   }

   public function checkValidateMapDagForOrderPass($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_dag_no,$dag_no){
      $query = $this->db->query("select count(*) as tot from bhun_map_creation_cases where dist_code=?
      and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and map_for_property='N' and
      (old_dag_no=? or dag_no=?)", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$new_dag_no));
      log_message('error','MB52 : last query=========='.json_encode($this->db->last_query()));
      $result = $query->row();
      if(!empty($result) && isset($result->tot) && $result->tot != null){
            return $result->tot;
      }else{
         return 0;
      }

   }

   //return true if dag and ror inserted in prop chain sent data table 
   public function checkDagExistsInPropChain($dist_code,$subdiv_code,
   $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no){
      //checking for ror 
      $query = $this->db->query('select count(*) from prop_chain_sent_data where dist_code=? and subdiv_code=?
      and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and certmnemonic=?', array($dist_code,$subdiv_code,
      $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,CERTMNEMONIC_ROR));
      $ror_count = $query->row()->count;       
      //checking for map
      $query = $this->db->query("select count(*) from prop_chain_sent_data where dist_code=? and subdiv_code=?
      and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and certmnemonic=?",array($dist_code,$subdiv_code,
      $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,CERTMNEMONIC_MAP));
      $map_count = $query->row()->count;
      if($ror_count == 0 && $map_count == 0){
         return false;
      }else{
         return true;
      } 
   }

   //return true if dag and ror inserted in prop chain sent data table 
   public function checkDagExistsInPropChainInPending($dist_code,$subdiv_code,
   $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no){
      $query = $this->db->query('select * from bhun_map_creation_cases where dist_code=? and subdiv_code=?
      and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and (dag_no=? or old_dag_no=?) and map_for_property=?', array($dist_code,$subdiv_code,
      $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$dag_no,'N'));

      $map_pending_count = $query->num_rows();
      if($map_pending_count > 0){
         return false;
      }
      
      //checking for ror 
      $query = $this->db->query('select count(*) as pending from prop_chain_sent_data where dist_code=? and subdiv_code=?
      and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and sending_status=?', array($dist_code,$subdiv_code,
      $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,'N'));
      $pendingCount = $query->row();   
      log_message('error','********94***'.json_encode($this->db->last_query()));    
      if(isset($pendingCount))
      {
         if(isset($pendingCount->pending) && $pendingCount->pending > 0)
         {
            return false;
         }else{
            return true;
         }

      }
      log_message('error','********94***'.json_encode($this->db->last_query()));
       
   }

   public function getPendingTransactionDetails($certmnemonic,$push_pending_count){
      //return $certmnemonic.$push_pending_count;
      $result = $this->db->query("select * from prop_chain_sent_data where certmnemonic=? 
                  and sending_status='N' and is_digitally_signed='Y' order by created_at asc 
                  limit $push_pending_count",array($certmnemonic))->result();
      // echo "<pre>";
      // var_dump($result);
      // echo "</pre>";
      $sent_data = array();
      foreach($result as $row){
         $key = $row->dist_code.$row->subdiv_code.$row->cir_code.$row->mouza_pargona_code.
                $row->lot_no.$row->vill_townprt_code.$row->dag_no;
         if (!array_key_exists($key,$sent_data))
         {
            $sent_data[$key] = $row; 
         }         
      }
      return $sent_data;
   }

   public function getPropChainCaseDetails($case_no){
      return $this->db->query('select * from prop_chain_sent_data where case_no=?', array($case_no))->row();
   }

   //bulk update api 
   public function pushDataToPropChain($certmnemonic){
      $response = array('responseType'=> 1, 'message'=>'');
      $certmnemonic = strtoupper($certmnemonic);
      $push_pending_count = $this->db->query("select count(*) from prop_chain_sent_data where certmnemonic=? 
      and sending_status='N'",array(strtoupper($certmnemonic)))->row()->count;    
      if($push_pending_count < BULK_PUSH_TRANSACTION_LIMIT){
         $response['responseType']= 1;
         $response['message']= 'Less than the bulk transaction limit';
         return $response;
      }
      //return "need to push ".$push_pending_count." transactions";
      $pending_transaction_details = $this->getPendingTransactionDetails($certmnemonic,$push_pending_count);
      $payload = array();
      $payload['office_code'] = $this->session->userdata('cir_code');
      $payload['user_code'] = $this->session->userdata('user_code');
      $payload['certmnemonic'] = $certmnemonic;
      $records = array();
      foreach ($pending_transaction_details as $chain_data) {         
         $decoded_data = json_decode($chain_data->json_case_data, true);        
         //return $decoded_data;
         array_push($records,[
            "propertyid" =>  $decoded_data['property_id'],
            "referenceid" => $chain_data->case_no,
            "previousdatahash" =>$decoded_data['previous_hash'],
            "data" => base64_encode(json_encode($decoded_data['property_data'])),
            "certificate" => $decoded_data['certificate'],
            "signature" => $decoded_data['property_signature'],
            "signerkey" => $decoded_data['property_signer_key']
         ]);      
      }
      $payload['records'] = $records;
      log_message('error','bulkpayload -api'.json_encode($payload));
      //*************************************************************************************//
      //testing 
      // echo "*******************BULk-PAYLOAD************************<br>";
      // echo "<pre>";
      // var_dump($payload);
      // echo "</pre>";
      // echo "*******************BULk-PAYLOAD************************<br>";
      //*************************************************************************************//
      $bulkResponse = $this->blockchainutilityclass->propertyChainBulkUpdateApi(json_encode($payload));
      //*************************************************************************************//
      //testing 
      // echo "*******************BULk-RESPONSE************************<br>";
      // echo "<pre>";
      // var_dump($bulkResponse);
      log_message('error','bulkResponse -api'.json_encode($bulkResponse));
      // echo "</pre>";
      // echo "*******************BULk-RESPONSE************************<br>";
      //*************************************************************************************//
      if(!$bulkResponse['result']){
         $response['responseType']= 1;
         $response['message']= 'Bulk Update Api Failure';
         return $response;
      }

      if($bulkResponse['response'] == NULL || $bulkResponse['response'] == null){
         $response['responseType']= 1;
         $response['message']= 'Bulk Update Api Response Not Found';
         return $response;
      }

      if($bulkResponse['response']->success !=1 && $bulkResponse['response']->success !=2){
         $response['responseType']= 1;
         $response['message']= "BLOCK-CHAIN SERVER ERROR. ERROR-MSG : ".$bulkResponse['response']->error_msg;
         return $response;
      }

      $valid_list = $bulkResponse['response']->valid_list;

      if(gettype($bulkResponse['response']->valid_list) == 'string'){
         $valid_list = json_decode($bulkResponse['response']->valid_list);
      }

      
      $invalid_list = $bulkResponse['response']->invalid_list;      

      if(gettype($bulkResponse['response']->invalid_list) == 'string'){
         $invalid_list = json_decode($bulkResponse['response']->invalid_list);     
      }

      if($bulkResponse['response']->success == 1 || $bulkResponse['response']->success == 2){
         $transaction_id = $bulkResponse['response']->transaction_id;
      }else{
         $response['responseType']= 1;
         $response['message']= "BLOCK-CHAIN SERVER ERROR. ERROR-MSG : ".$bulkResponse['response']->error_msg;
         return $response;
      }



      $this->db->trans_begin();    
      //updating the invalid list in the db 
      foreach($invalid_list as $invalid_block){
         $prop_chain_details = $this->getPropChainCaseDetails($invalid_block->referenceId);
         // $ulpinDetails = json_decode($prop_chain_details->json_case_data, true));
         $decoded_data = json_decode($prop_chain_details->json_case_data, true);
         // $ulpinArray=json_decode($decoded_data['property_data'],true);



         if(empty($decoded_data) || $decoded_data==null || $decoded_data == '')
         {
            $response['responseType']= 1;
            $response['message']= "BLOCK-CHAIN ULPIN ERROR. ERROR-MSG : ".json_encode($decoded_data);
            return $response;
         }

         if($invalid_block->errorCode == '04109'){
            $property_chain_status = 'Y';
         }else{
            $property_chain_status = 'N';
         }
         //insert into prop_chain_audit_data
         $insert_data = [
            "dist_code" => $prop_chain_details->dist_code,
            "subdiv_code" => $prop_chain_details->subdiv_code,
            "cir_code" => $prop_chain_details->cir_code,
            "mouza_pargona_code" => $prop_chain_details->mouza_pargona_code,
            "lot_no" => $prop_chain_details->lot_no,
            "vill_townprt_code" => $prop_chain_details->vill_townprt_code,
            "village_uuid" => $prop_chain_details->village_uuid,
            "patta_no" => $prop_chain_details->patta_no,
            "dag_no" => $prop_chain_details->dag_no,
            'case_no' => $invalid_block->referenceId,
            "sent_data_json" => $prop_chain_details->json_case_data,
            "transaction_id" => $transaction_id,
            'certmnemonic' => $certmnemonic,
            'response_data_json' => json_encode($invalid_block),
            "is_digitally_signed" => $prop_chain_details->is_digitally_signed,
            "digitally_signed_date_time" => $prop_chain_details->digitally_signed_date_time,
            'user_code' => $this->session->userdata('user_code'),
            'property_chain_status' => $property_chain_status,
            'created_at' => date('Y-m-d h:i:s'),
            'modified_at' => date('Y-m-d h:i:s')
         ];
         $tstatus1 = $this->db->insert('prop_chain_audit_data', $insert_data);               
         if ($tstatus1 != 1 )
         {
            $this->db->trans_rollback();
            log_message("error", "#PCADIFBUA001, Error in insert, table 'prop_chain_audit_data' with data :". json_encode($insert_data));   
            $response['responseType']= 1;
            $response['message']= "#PCADIFBUA001, Error in insert, table 'prop_chain_audit_data'";
            return $response;        
         }
         //check if updated then update the db again 
         //update prop chain sent data 
         if($invalid_block->errorCode == '04109' && $prop_chain_details->sending_status == 'N'){
            //reference id already exists 
            //chekcing the status of peop chain sent data 
            $update_data = [
               'sending_status' => 'Y',
               'json_response' => json_encode($invalid_block),
               'modified_at' => date('Y-m-d h:i:s'),
            ];
            $this->db->where('case_no', $invalid_block->referenceId)->update('prop_chain_sent_data', $update_data);  
            if($this->db->affected_rows() != 1){ 
               $this->db->trans_rollback();
               log_message("error", "#PCADIFBUA003, Error in update, table 'prop_chain_sent_data' with data :". json_encode($update_data));
               $response['responseType']= 1;
               $response['message']= "#PCADIFBUA003, Error in update, table 'prop_chain_sent_data'";
               return $response;        
            }
            //inserting into prop chain success transaction 
            $insert_data = [
               "dist_code" => $prop_chain_details->dist_code,
               "subdiv_code" => $prop_chain_details->subdiv_code,
               "cir_code" => $prop_chain_details->cir_code,
               "mouza_pargona_code" => $prop_chain_details->mouza_pargona_code,
               "lot_no" => $prop_chain_details->lot_no,
               "vill_townprt_code" => $prop_chain_details->vill_townprt_code,
               "village_uuid" => $prop_chain_details->village_uuid,
               "patta_no" => $prop_chain_details->patta_no,
               "dag_no" => $prop_chain_details->dag_no,
               "transaction_id" => $transaction_id,
               "case_no" => $prop_chain_details->case_no,
               "sent_data_json" => $prop_chain_details->json_case_data,
               "property_chain_status" => 'Y',
               "response_data_json" => json_encode($invalid_block),
               "is_digitally_signed" => $prop_chain_details->is_digitally_signed,
               "digitally_signed_date_time" => $prop_chain_details->digitally_signed_date_time,
               "created_at" => date('Y-m-d h:i:s'),
               "modified_at" => date('Y-m-d h:i:s'),
               "user_code" => $this->session->userdata('user_code'),
               "certmnemonic" => $certmnemonic
            ];
            $tstatus1 = $this->db->insert('prop_chain_other_success_transaction', $insert_data);               
            if ($tstatus1 != 1 )
            {
               $this->db->trans_rollback();
               log_message("error", "#PCADIFBUA0044, Error in insert, table 'prop_chain_other_success_transaction' with data :". json_encode($insert_data));   
               $response['responseType']= 1;
               $response['message']= "#PCADIFBUA0044, Error in insert, table 'prop_chain_other_success_transaction'";
               return $response;  
            }
            $patta_type_code= $this->blockchainutilityclass->pattaNoFromChitha($prop_chain_details->dist_code,$prop_chain_details->subdiv_code,$prop_chain_details->cir_code,$prop_chain_details->mouza_pargona_code,$prop_chain_details->lot_no,$prop_chain_details->vill_townprt_code,$prop_chain_details->dag_no);
            if($patta_type_code!=null){
               $patta_type_code = $patta_type_code->patta_type_code;
            }else{
               $patta_type_code = '--';
            }
            $land_class_code = $this->blockchainutilityclass->classCodeFromChitha($prop_chain_details->dist_code,$prop_chain_details->subdiv_code,$prop_chain_details->cir_code,$prop_chain_details->mouza_pargona_code,$prop_chain_details->lot_no,$prop_chain_details->vill_townprt_code,$prop_chain_details->dag_no);

            if($land_class_code == null){
               $land_class_code = '--';
            }

            $insert_data = [
               "dist_code"=>$prop_chain_details->dist_code,
               "subdiv_code"=>$prop_chain_details->subdiv_code,
               "cir_code"=>$prop_chain_details->cir_code,
               "mouza_pargona_code"=>$prop_chain_details->mouza_pargona_code,
               "lot_no"=>$prop_chain_details->lot_no,
               "vill_townprt_code"=>$prop_chain_details->vill_townprt_code,
               "dag_no"=>$prop_chain_details->dag_no,
               "patta_no"=>$prop_chain_details->patta_no,
               "land_class_code" => $land_class_code,
               "patta_type_code" => $patta_type_code,
               "property_id"=>$invalid_block->propertyId,
               "datetime"=>date('Y-m-d h:i:s'),
               "ip_address"=>$this->utilityclass->get_client_ip(),
               "transaction_id" => $transaction_id,
               "reference_id" => $invalid_block->referenceId,
               "user_code"=>$this->session->userdata('user_code'),
               'ulpin' => $decoded_data['property_data']['ulpin'],
            ];
            $tstatus1 = $this->db->insert('prop_chain_transaction', $insert_data);               
            if ($tstatus1 != 1 )
            {
               $this->db->trans_rollback();
               log_message("error", "#PCADIFBUA0055, Error in insert, table 'prop_chain_transaction' with data :". json_encode($insert_data));         
               $response['responseType']= 1;
               $response['message']= "#PCADIFBUA0055, Error in insert, table 'prop_chain_transaction'";
               return $response;     
            }
         }
         
      }
      //updating the valid list 
      foreach($valid_list as $valid_block){
         $prop_chain_details = $this->getPropChainCaseDetails($valid_block->referenceId);

         $decoded_data = json_decode($prop_chain_details->json_case_data, true);
         // var_dump($decoded_data['property_data']['ulpin']);exit;
         // $ulpinArray=json_decode($decoded_data['property_data'],true);

         if(empty($decoded_data) || $decoded_data==null || $decoded_data == '')
         {
            $response['responseType']= 1;
            $response['message']= "BLOCK-CHAIN ULPIN ERROR. ERROR-MSG : ".json_encode($decoded_data);
            return $response;
         }
         //insert into the prop_chain_audit_data
         $insert_data = [
            "dist_code" => $prop_chain_details->dist_code,
            "subdiv_code" => $prop_chain_details->subdiv_code,
            "cir_code" => $prop_chain_details->cir_code,
            "mouza_pargona_code" => $prop_chain_details->mouza_pargona_code,
            "lot_no" => $prop_chain_details->lot_no,
            "vill_townprt_code" => $prop_chain_details->vill_townprt_code,
            "village_uuid" => $prop_chain_details->village_uuid,
            "patta_no" => $prop_chain_details->patta_no,
            "dag_no" => $prop_chain_details->dag_no,
            "transaction_id" => $transaction_id,
            'case_no' => $valid_block->referenceId,
            "sent_data_json" => $prop_chain_details->json_case_data,
            'certmnemonic' => $certmnemonic,
            'response_data_json' => json_encode($valid_block),
            "is_digitally_signed" => $prop_chain_details->is_digitally_signed,
            "digitally_signed_date_time" => $prop_chain_details->digitally_signed_date_time,
            'user_code' => $this->session->userdata('user_code'),
            'property_chain_status' => 'Y',
            'created_at' => date('Y-m-d h:i:s'),
            'modified_at' => date('Y-m-d h:i:s')
         ];
         $tstatus1 = $this->db->insert('prop_chain_audit_data', $insert_data);               
         if ($tstatus1 != 1 )
         {
            $this->db->trans_rollback();
            log_message("error", "#PCADIFBUA002, Error in insert, table 'prop_chain_audit_data' with data :". json_encode($insert_data));         
            $response['responseType']= 1;
            $response['message']= "#PCADIFBUA002, Error in insert, table 'prop_chain_audit_data'";
            return $response;        
         }         
         //update prop chain sent data 
         $update_data = [
            'sending_status' => 'Y',
            'json_response' => json_encode($valid_block),
            'modified_at' => date('Y-m-d h:i:s'),
         ];
         $this->db->where('case_no', $valid_block->referenceId)->update('prop_chain_sent_data', $update_data);  
         if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#PCADIFBUA003, Error in update, table 'prop_chain_sent_data' with data :". json_encode($update_data));
            $response['responseType']= 1;
            $response['message']= "#PCADIFBUA003, Error in update, table 'prop_chain_sent_data'";
            return $response;        
         }   
         //insert into the prop_chain_other_success_transaction          
         $insert_data = [
            "dist_code" => $prop_chain_details->dist_code,
            "subdiv_code" => $prop_chain_details->subdiv_code,
            "cir_code" => $prop_chain_details->cir_code,
            "mouza_pargona_code" => $prop_chain_details->mouza_pargona_code,
            "lot_no" => $prop_chain_details->lot_no,
            "vill_townprt_code" => $prop_chain_details->vill_townprt_code,
            "village_uuid" => $prop_chain_details->village_uuid,
            "patta_no" => $prop_chain_details->patta_no,
            "dag_no" => $prop_chain_details->dag_no,
            "transaction_id" => $transaction_id,
            "case_no" => $prop_chain_details->case_no,
            "sent_data_json" => $prop_chain_details->json_case_data,
            "property_chain_status" => 'Y',
            "response_data_json" => json_encode($valid_block),
            "is_digitally_signed" => $prop_chain_details->is_digitally_signed,
            "digitally_signed_date_time" => $prop_chain_details->digitally_signed_date_time,
            "created_at" => date('Y-m-d h:i:s'),
            "modified_at" => date('Y-m-d h:i:s'),
            "user_code" => $this->session->userdata('user_code'),
            "certmnemonic" => $certmnemonic
         ];
         $tstatus1 = $this->db->insert('prop_chain_other_success_transaction', $insert_data);               
         if ($tstatus1 != 1 )
         {
            $this->db->trans_rollback();
            log_message("error", "#PCADIFBUA004, Error in insert, table 'prop_chain_other_success_transaction' with data :". json_encode($insert_data));    
            $response['responseType']= 1;
            $response['message']= "#PCADIFBUA004, Error in insert, table 'prop_chain_other_success_transaction'";
            return $response;                
         }
         // insert into prop chain transaction
         $patta_type_code= $this->blockchainutilityclass->pattaNoFromChitha($prop_chain_details->dist_code,$prop_chain_details->subdiv_code,$prop_chain_details->cir_code,$prop_chain_details->mouza_pargona_code,$prop_chain_details->lot_no,$prop_chain_details->vill_townprt_code,$prop_chain_details->dag_no);
         if($patta_type_code!=null){
            $patta_type_code = $patta_type_code->patta_type_code;
         }else{
            $patta_type_code = '--';
         }
         $land_class_code = $this->blockchainutilityclass->classCodeFromChitha($prop_chain_details->dist_code,$prop_chain_details->subdiv_code,$prop_chain_details->cir_code,$prop_chain_details->mouza_pargona_code,$prop_chain_details->lot_no,$prop_chain_details->vill_townprt_code,$prop_chain_details->dag_no);

         if($land_class_code == null){
            $land_class_code = '--';
         }

         $insert_data = [
            "dist_code"=>$prop_chain_details->dist_code,
            "subdiv_code"=>$prop_chain_details->subdiv_code,
            "cir_code"=>$prop_chain_details->cir_code,
            "mouza_pargona_code"=>$prop_chain_details->mouza_pargona_code,
            "lot_no"=>$prop_chain_details->lot_no,
            "vill_townprt_code"=>$prop_chain_details->vill_townprt_code,
            "dag_no"=>$prop_chain_details->dag_no,
            "patta_no"=>$prop_chain_details->patta_no,
            "land_class_code" => $land_class_code,
            "patta_type_code" => $patta_type_code,
            "property_id"=>$valid_block->propertyId,
            "datetime"=>date('Y-m-d h:i:s'),
            "ip_address"=>$this->utilityclass->get_client_ip(),
            "transaction_id" => $transaction_id,
            "reference_id" => $valid_block->referenceId,
            "user_code"=>$this->session->userdata('user_code'),
            "ulpin" =>$decoded_data['property_data']['ulpin'],
         ];
         $tstatus1 = $this->db->insert('prop_chain_transaction', $insert_data);               
         if ($tstatus1 != 1 )
         {
            $this->db->trans_rollback();
            log_message("error", "#PCADIFBUA005, Error in insert, table 'prop_chain_transaction' with data :". json_encode($insert_data));        
            $response['responseType']= 1;
            $response['message']= "#PCADIFBUA005, Error in insert, table 'prop_chain_transaction'";
            return $response;                    
         }

      }
      $this->db->trans_commit();
      $response['responseType']= 2;
      $response['message']= "BULK UPDATION SUCCESSFULL";
      return $response;                    
   }



   public function isLocationEnable($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code){

      $cir_uuid = $this->db->query("select uuid from location where dist_code=? and subdiv_code=? 
         and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?", array($dist_code,$subdiv_code,$cir_code,'00','00','00000'))->row()->uuid;
      $enabledCircles = json_decode(BLOCK_CHAIN_ALLOWED_CIRCLES);
      foreach($enabledCircles as $enableCircle){
         if(in_array($cir_uuid, $enableCircle)){
            if($enableCircle[1] == 1){
               //completey allowed circle 
               return true;
            }else{
               //partially allowed circle 
               $uuid = $this->db->query("select uuid from location where dist_code=? and subdiv_code=? 
                  and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row()->uuid;
               $enabledLocations =  json_decode(BLOCK_CHAIN_ALLOWED_VILLAGES);
               if(in_array($uuid, $enabledLocations)){
                  return true;
               }else{
                  return false;
               }
            }
         }else{
            return false;
         }
      }

      
   }
}