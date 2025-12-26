<?php

class EkhajanaAstModel extends CI_Model {

    //getting pending list count for ast
    public function pendingForAstCount($dist_code,$subdiv_code,$cir_code){
        $query = $this->db->select('count(*)')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('status', EKHAJANA_STATUS_CO_FORWARD)
                    ->from('ekhajana_basic')
                    ->get(); 
        //return $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->row()->count;
        }else{
            return 0;
        }
    }

    //getting pending list for ast 
    public function pendingListForAst($dist_code,$subdiv_code,$cir_code){
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('status', EKHAJANA_STATUS_CO_FORWARD)
                    ->from('ekhajana_basic')
                    ->get(); 
        //return $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return [];
        }
    }

    //getting ekhajana basic details form id 
    public function getEkBasicDetailsFromId($ek_basic_id){        
        $query = $this->db->select('*')
                    ->where('id', $ek_basic_id)
                    ->from('ekhajana_basic')
                    ->get(); 
        //return $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return false;
        }
    }

    //inserting in jama wasil and updating status in basundhara
    public function insertAstArrearUpdateDetails($jama_wasil_data,
    $jama_wasil_payee_list_data,$jama_wasil_backup_table_data,$ekBasicDetails){
        error_reporting(0);
        $this->db->trans_begin();
        //**************************************************//
        //insert data in jama_wasil 
        $tstatus1 = $this->db->insert('jama_wasil', $jama_wasil_data); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKIAU001, Error in insert on jama_wasil table with  query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU001'];
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
            log_message("error", "#EKIAU002, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU002'];
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
            log_message("error", "#EKIAU003, Error in insert on jama_wasil_payee_list table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU003'];
        }
        //**************************************************//
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKIAU004, Error in insert on jama_wasil_backup table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU004'];
        }
        //**************************************************//
        //ekhajana basic update 
        $update_data = array(
            'status' => EKHAJANA_STATUS_COMPLETED,
            'modified_at' => date('Y-m-d h:i:s')
        ); 
        $this->db->where('case_no', $ekBasicDetails->case_no);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKIAU005, Error in update of ast forward, table 'ekhajana_basic' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU005'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $ekBasicDetails->ld_application_no,
            'application_no' => $ekBasicDetails->application_no,
            'remark' => "AST-ARREAR-UPDATED",            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $ekBasicDetails->case_no,
            'status' => EKHAJANA_STATUS_COMPLETED
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKIAU009, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU009'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKIAU006, Transaction Status Error In Mouzadar Arrear Update Details with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAU006'];
        }else{
            //basundhara ekhajana payment update
            //basundhara ekhajana land details update
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_PAYMENT_UPDATE_API,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_POSTFIELDS => array(
                        'ld_application_no' => $ekBasicDetails->ld_application_no,
                        'application_no' => $ekBasicDetails->application_no,
                        'dharitree_case_no' => $ekBasicDetails->case_no,
                        'due_payment' => $jama_wasil_data['due_payment'],
                        'user_code' => $this->session->all_userdata()['user_code'],                    
                        'date_of_action' => date("Y-m-d"),
                        "patta_no" => $ekBasicDetails->patta_no,
                        'remark' => "ASISTANT ARREAR UPDATED",
                    ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                //return "curl successfull";
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Arrear Updated Sucessfully..!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKIAUCRL007, Curl Error(Y) In Api ".EKHAJANA_PAYMENT_UPDATE_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL007'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKIAUCRL008, Curl Error(200) In Api ".EKHAJANA_PAYMENT_UPDATE_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL008'];
            }
        } 
    }
    
    //getting current revenue and local tax
    public function getCurrentRevenueAndLocalTaxFromDoul($village_uuid,$patta_type_code,$patta_no){
        $query = $this->db->select("*")
                ->where('uuid', $village_uuid)
                ->where('patta_type_code', $patta_type_code)
                ->where('patta_no', $patta_no)
                ->from('current_doul_demand')
                ->get(); 
        if($query->num_rows != 0){
            return ['flag' => true, 'result' => $query->row()];
        }else{
            return ['flag' => false, 'result' => []];
        }        
    }

    //checkig whether jama wasil already updated or not 
    public function checkJamaWasilStatus($ek_basic_details){
        $query = $this->db->select('count(*)')
                          ->where('dist_code', $ek_basic_details->dist_code)
                          ->where('subdiv_code', $ek_basic_details->subdiv_code)
                          ->where('cir_code', $ek_basic_details->cir_code)
                          ->where('mouza_pargona_code', $ek_basic_details->mouza_pargona_code)
                          ->where('lot_no', $ek_basic_details->lot_no)
                          ->where('vill_townprt_code', $ek_basic_details->vill_townprt_code)
                          ->where('patta_type_code', $ek_basic_details->patta_type_code)
                          ->where('patta_no', $ek_basic_details->patta_no)
                          ->from('jama_wasil')
                          ->get();

        if($query->row()->count != 0){
            return "jamawasil_updated";
        }else{
            return "jamawasil_not_updated";
        }
    }

    public function jwExistsCaseForward($ekBasicDetails){
        $this->db->trans_begin();
        $query = $this->db->select('due_payment')
                          ->where('dist_code', $ekBasicDetails->dist_code)
                          ->where('subdiv_code', $ekBasicDetails->subdiv_code)
                          ->where('cir_code', $ekBasicDetails->cir_code)
                          ->where('mouza_pargona_code', $ekBasicDetails->mouza_pargona_code)
                          ->where('lot_no', $ekBasicDetails->lot_no)
                          ->where('vill_townprt_code', $ekBasicDetails->vill_townprt_code)
                          ->where('patta_type_code', $ekBasicDetails->patta_type_code)
                          ->where('patta_no', $ekBasicDetails->patta_no)
                          ->from('jama_wasil')
                          ->get();
        $due_payment = $query->row()->due_payment;
        //if due is 0 then 
        if($due_payment == 0){
           $query = $this->db->select('due_payment')
                            ->where('due_payment !=', 0)
                            ->where('dist_code', $ekBasicDetails->dist_code)
                            ->where('subdiv_code', $ekBasicDetails->subdiv_code)
                            ->where('cir_code', $ekBasicDetails->cir_code)
                            ->where('mouza_pargona_code', $ekBasicDetails->mouza_pargona_code)
                            ->where('lot_no', $ekBasicDetails->lot_no)
                            ->where('vill_townprt_code', $ekBasicDetails->vill_townprt_code)
                            ->where('patta_type_code', $ekBasicDetails->patta_type_code)
                            ->where('patta_no', $ekBasicDetails->patta_no)
                            ->order_by('id',"DESC")
                            ->from('jama_wasil_transaction')
                            ->get();
            $due_payment = $query->row()->due_payment;
        }
        //**************************************************//
        //ekhajana basic update 
        $update_data = array(
            'status' => EKHAJANA_STATUS_COMPLETED,
            'modified_at' => date('Y-m-d h:i:s')
        ); 
        $this->db->where('case_no', $ekBasicDetails->case_no);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKJWE001, Error in update of ast forward, table 'ekhajana_basic' with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKJWE001'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $ekBasicDetails->ld_application_no,
            'application_no' => $ekBasicDetails->application_no,
            'remark' => "AST-ARREAR-UPDATED",            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $ekBasicDetails->case_no
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKJWE005, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKJWE005'];
        }
        //**************************************************//
        //final transaction status check 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKJWE002, Transaction Status Error  with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKJWE002'];
        }else{
            //basundhara ekhajana payment update
            //basundhara ekhajana land details update
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_PAYMENT_UPDATE_API,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_POSTFIELDS => array(
                    'ld_application_no' => $ekBasicDetails->ld_application_no,
                    'application_no' => $ekBasicDetails->application_no,
                    'dharitree_case_no' => $ekBasicDetails->case_no,
                    'due_payment' => $due_payment,
                    'user_code' => 'AST',                    
                    'date_of_action' => date("Y-m-d"),
                    "patta_no" => $ekBasicDetails->patta_no,
                    'remark' => "ASISTANT ARREAR UPDATED",
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                //return "curl successfull";
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Case forwarded Sucessfully..!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKJWECRL003, Curl Error(Y) In Api ".EKHAJANA_PAYMENT_UPDATE_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKJWECRL003'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKJWECRL004, Curl Error(200) In Api ".EKHAJANA_PAYMENT_UPDATE_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKJWECRL004'];
            }
        } 
        
    }

    // update the reverted back data
    function UpdateRevertCase($ekUpdateData){
        $this->db->trans_begin();
        $update_data = array(
            'status' => EKHAJANA_AST_MOU_REVERT, 
            'ast_remark' => $ekUpdateData['remark'],
        );  
        $this->db->where('ld_application_no', $ekUpdateData['ld_application_no'])
                    ->where('id', $ekUpdateData['ek_basic_id']);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKURC001, Error in update of reverting case, table 'ekhajana_basic' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKURC001'];
        }

        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $ekUpdateData['ld_application_no'],
            'application_no' => $ekUpdateData['application_no'],
            'remark' => $ekUpdateData['remark'],           
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $ekUpdateData['case_no'],
            'status' => EKHAJANA_AST_MOU_REVERT
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKURC002, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKURC002'];
        }
        //basundhara ekhajana land details update
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_REVERT_CASE_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POSTFIELDS => array(
                'ld_application_no' => $ekUpdateData['ld_application_no'],
                'application_no' => $ekUpdateData['application_no'],
                'dharitree_case_no' => $ekUpdateData['case_no'],
                'user_code' => 'AST',                    
                'date_of_action' => date("Y-m-d"),
                'remark' => $ekUpdateData['remark'],
                'patta_no' => $ekUpdateData['patta_no']
            ),
        ));
        $response = curl_exec($curl);
        //return $response;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                $this->db->trans_commit();
                return ['result' => 'SUCCESS', 'msg' => 'Case reverted back to CO Successfully..!'];                 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKHCRLASTR001, Curl Error(Y) In Api ".EKHAJANA_REVERT_CASE_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'SOME ERROR OCCURED, ERROR-CODE: #EKHCRLASTR001'];
            }
        }else{
            $this->db->trans_rollback();
            log_message("error", "#EKHCRLASTR002, Curl Error(200) In Api ".EKHAJANA_REVERT_CASE_API);
            return ['result' => 'SERVER-ERROR', 'msg' => 'SOME ERROR OCCURED, ERROR-CODE: #EKHCRLASTR002'];
        }
    }

    //***********************NEW CODES*************************/
    
    //function to get all  mouza names
    public function getAllMouzaName($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select loc_name,locname_eng,mouza_pargona_code from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?",array($dist_code,$subdiv_code,$cir_code,'00','00'))->result();
        log_message("error","**********************************".$this->db->last_query());
        return $query;
    }

    //function to get all the lot names
    public function getAllLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code)
    {
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no!=? and vill_townprt_code =?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,'00','00000'))->result();
        log_message("error","**********************************".$this->db->last_query());
        return $query;
    }

    //function to get all the villages
    public function getAllVillagesName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no)
    {
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code !=?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,'00000'))->result();
        return $query;
    }

    //patta type selection 
    public function getPattaType(){
        $query = $this->db->query("Select type_code,patta_type,pattatype_eng from patta_code order by type_code asc")->result();       
        return $query; 
    }

    //function to get patta nos
    public function getPattaNo($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code){
        $query = $this->db->query("select distinct (patta_no) from chitha_basic where dist_code=? and subdiv_code= ? and cir_code =? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? order by patta_no asc",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code))->result();       
        return $query; 
    }

    //getting village uuid
    function getVillageUUID($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){         
        $sql = "select * from location where dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $query = $this->db->query($sql,array(strval($dist_code),strval($subdiv_code),strval($cir_code),strval($mouza_code),strval($lot_no),strval($vill_code)));
        $result = $query->result(); 
        if(count($result) != 0 ){
            return $result[0]->uuid;
        }else{
            return "";
        }
    }
 
    //inserting pre arrear data 
    public function insertPreArrearData($posted_data,$data)
    { 
        error_reporting(0);
        $village_uuid = $this->getVillageUUID($posted_data['dist_code'],$posted_data['subdiv_code'],$posted_data['cir_code'],$posted_data['mouza_pargona_code'],$posted_data['lot_no'],$posted_data['vill_townprt_code']);
        
        if(date('m') <= 6){
            $doul_year = date('Y');
        }else{
            $doul_year = date('Y') + 1;
        }
        $query = $this->db->select('*')
                            ->where('dist_code', $posted_data['dist_code'])
                            ->where('subdiv_code', $posted_data['subdiv_code'])
                            ->where('cir_code', $posted_data['cir_code'])
                            ->where('mouza_pargona_code', $posted_data['mouza_pargona_code'])
                            ->where('lot_no', $posted_data['lot_no'])
                            ->where('vill_townprt_code', $posted_data['vill_townprt_code'])
                            ->where('village_uuid', $village_uuid)
                            ->where('patta_type_code', $posted_data['patta_type_code'])
                            ->where('patta_no', $posted_data['patta_no'])
                            ->from('ekhajana_arrear_pre_updation')
                            ->get();
        
        if($query->num_rows()>= 1){
            $this->db->trans_rollback();
                log_message("error", "#EKHIPAD005, arrear of the patta already exist");
                return ['result' => 'SERVER-ERROR', 'msg' => '#EKHIPAD005, Arrear for the Patta No: '.$posted_data['patta_no'].'is already submitted '];
            }
        $insertPreArrearData = [
            "dist_code"             => $posted_data['dist_code'],
            "subdiv_code"           => $posted_data['subdiv_code'],
            "cir_code"              => $posted_data['cir_code'],
            "mouza_pargona_code"    => $posted_data['mouza_pargona_code'],
            "lot_no"                => $posted_data['lot_no'],
            "vill_townprt_code"     => $posted_data['vill_townprt_code'],
            "village_uuid"          => $village_uuid,
            "patta_type_code"       => $posted_data['patta_type_code'],
            "patta_no"              => $posted_data['patta_no'],
            "arrear"                => $posted_data['total_arrear'],
            "revenue"               => $posted_data['total_revenue'],
            "tax"                   => $posted_data['total_tax'],
            //"miran"                 => $posted_data['total_miran'],
            "status"                => EKHAJANA_AREEAR_PRE_UPDATED,
            "created_at"            => date('Y-m-d h:i:s'),
            "modified_at"           => null,
            'user_code'             => $this->session->all_userdata()['user_code'],
            'doul_year_no'          => $doul_year,
            'previous_arrears'      => json_encode($posted_data),
            'application_under'     => 'TEHSILDAR',
                
        ];
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert('ekhajana_arrear_pre_updation', $insertPreArrearData);
        if ($tstatus1!= 1)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKHIPAD001, Error in insert on ekhajana_arrear_pre_updation table with data ". json_encode($insertPreArrearData));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD001'];
            }
        $ekhajanaPreArrearInsertId = $this->db->insert_id();   
    
        foreach($data as $row){
            $year_arrear = $row['arear'];
            if($year_arrear == null){
                $year_arrear =0;
            }

            $year_revenue = $row['revenue'];
            if($year_revenue == null){
                $year_revenue =0;
            }

            $year_tax = $row['tax'];
            if($year_tax == null){
                $year_tax =0;
            }

            // $year_miran = $row['miran'];
            // if($year_miran == null){
            //     $year_miran =0;
            // }

            $year_wise_arrear= array(
                'pre_arrear_id'         => $ekhajanaPreArrearInsertId,
                'dist_code'             => $posted_data['dist_code'],
                'subdiv_code'           => $posted_data['subdiv_code'],
                'cir_code'              => $posted_data['cir_code'],            
                'mouza_pargona_code'    => $posted_data['mouza_pargona_code'],
                "lot_no"                => $posted_data['lot_no'],
                "vill_townprt_code"     => $posted_data['vill_townprt_code'],
                'village_uuid'          => $village_uuid,
                'patta_type_code'       => $posted_data['patta_type_code'],
                'patta_no'              => $posted_data['patta_no'],
                'total_arrear'          => $posted_data['total_arrear'],
                'total_revenue'         => $posted_data['total_revenue'],
                'total_tax'             => $posted_data['total_tax'],
                //'total_miran'           => $posted_data['total_miran'],
                'user_code'             => $this->session->all_userdata()['user_code'],
                'financial_year'        => $row['year'],
                'year_arrear'           =>  $year_arrear,
                'year_revenue'          =>  $year_revenue,
                'year_tax'              =>  $year_tax,
                //'year_miran'            =>  $year_miran,
                "created_at"            => date('Y-m-d h:i:s'),
                'modified_at'           => null,
                "status"                => EKHAJANA_AREEAR_PRE_UPDATED,
                "revenue_year"          => substr($row['year'],5),
                'application_under'     => 'TEHSILDAR',
            );
            $tstatus3 = $this->db->insert('ekhajana_year_wise_arrear', $year_wise_arrear);
            if ($tstatus3 <= 0)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKHIPAD002, Error in insert on ekhajana_year_wise_arrear table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD002'];
            }
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHIPAD003, Transaction failure occuredwi th query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD003'];
        }
        else
        {
            $this->db->trans_commit();
            
            return ['result' => 'SUCCESS', 'msg' => 'Arrear Data Inserted Successfully'];  
        }

    }

    public function getTotalArrear($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no){
        $arrear_update_query = $this->db->query('select * from ekhajana_arrear_pre_updation where 
                                        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                                        and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?',
                                        array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no));
        if($arrear_update_query->num_rows() != 1){
            return "not_updated";
        }else{
            return $arrear_update_query->row()->arrear;
        }
    }

    public function getPreUpdatedListForEdit($dist_code,$subdiv_code,$cir_code)
    {
        // $query = $this->db->query("select * from ekhajana_arrear_pre_updation where ROW(dist_code, subdiv_code, cir_code,
        //             mouza_pargona_code, lot_no, vill_townprt_code, patta_type_code, patta_no) not in
        //             (select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, patta_type_code, patta_no from jama_wasil)
        //              and dist_code=? and subdiv_code=? and cir_code=? and application_under=?",array($dist_code,$subdiv_code,$cir_code,'TEHSILDAR'));
        $query = $this->db->query("select eap.id as pre_id,* from ekhajana_arrear_pre_updation eap join jama_wasil jw on eap.dist_code=jw.dist_code and eap.subdiv_code=jw.subdiv_code
        and eap.cir_code=jw.cir_code and eap.mouza_pargona_code=jw.mouza_pargona_code and eap.lot_no=jw.lot_no and eap.vill_townprt_code=jw.vill_townprt_code
        and eap.patta_type_code=jw.patta_type_code and eap.patta_no= jw.patta_no where eap.dist_code=? and eap.subdiv_code=? and eap.cir_code=?
        and jw.pay_status=? and eap.application_under=?",
        array($dist_code,$subdiv_code,$cir_code,'UNPAID','TEHSILDAR'));
      if($query->num_rows() != 0){
         $pre_arrear_details =  $query->result(); 
      }else{
         $pre_arrear_details =  []; 
      }
      return $pre_arrear_details;
    }

    public function getPreUpdatedList($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select * from ekhajana_arrear_pre_updation where
                     dist_code=? and subdiv_code=? and cir_code=? and application_under=? ",array($dist_code,$subdiv_code,$cir_code,'TEHSILDAR'));
    
        if($query->num_rows() != 0){
            $pre_arrear_details =  $query->result(); 
        }else{
            $pre_arrear_details =  []; 
        }
        return $pre_arrear_details;
    }

    public function getYearWiseArrear($pre_arrear_id)
    {
        $query = $this->db->query("select * from ekhajana_year_wise_arrear where pre_arrear_id =? and application_under=? order by financial_year asc",array($pre_arrear_id,'TEHSILDAR'));
        if($query->num_rows() == 0)
        {
            return ['flag' =>'N', 'msg' => []];
        }else{
            return ['flag' =>'Y', 'msg' => $query->result()];
        }
    }


    public function insertArrearTransactiondata($pre_arrear_id)
   {
      //$this->dbswitch();
      $pre_arrear_updation_row = $this->db->query("select * from ekhajana_arrear_pre_updation where id=? ",array($pre_arrear_id))->result();
      $year_wise_arrear_data = $this->db->query("select * from ekhajana_year_wise_arrear where pre_arrear_id =? order by id asc", array($pre_arrear_id))->result();
      
      $pre_arrear_id       = $pre_arrear_updation_row[0]->id;
      $dist_code           = $pre_arrear_updation_row[0]->dist_code;
      $subdiv_code         = $pre_arrear_updation_row[0]->subdiv_code;
      $cir_code            = $pre_arrear_updation_row[0]->cir_code;
      $mouza_pargona_code  = $pre_arrear_updation_row[0]->mouza_pargona_code;
      $lot_no              = $pre_arrear_updation_row[0]->lot_no;
      $vill_townprt_code   = $pre_arrear_updation_row[0]->vill_townprt_code;
      $patta_type_code     = $pre_arrear_updation_row[0]->patta_type_code;
      $patta_no            = $pre_arrear_updation_row[0]->patta_no;
      $total_arrear        = $pre_arrear_updation_row[0]->arrear;
      $total_revenue       = $pre_arrear_updation_row[0]->revenue;
      $total_local_tax     = $pre_arrear_updation_row[0]->tax;
      $user_code           = $pre_arrear_updation_row[0]->user_code;
      $status              = $pre_arrear_updation_row[0]->status;

      $insertTransactionData = [
         "pre_arrear_id"         => $pre_arrear_id,
         "dist_code"             => $dist_code,
         "subdiv_code"           => $subdiv_code,
         "cir_code"              => $cir_code ,
         "mouza_pargona_code"    => $mouza_pargona_code,
         "lot_no"                => $lot_no,
         "vill_townprt_code"     => $vill_townprt_code,
         "patta_type_code"       => $patta_type_code,
         "patta_no"              => $patta_no,
         "total_arrear"          => $total_arrear,
         "total_revenue"         => $total_revenue,
         "total_local_tax"       => $total_local_tax,
         "user_code"             => $user_code,
         'status'                => $status,
         "created_at"            => date('Y-m-d h:i:s'),
         "modified_at"           => null,
         "arrear_pre_json"       => json_encode($pre_arrear_updation_row),
         "year_wise_arrear_json" => json_encode($year_wise_arrear_data),
      ];
      $tstatus3 = $this->db->insert('ekhajana_arrear_pre_updation_transactions', $insertTransactionData); 
      if ($tstatus3!= 1)
      {
            $this->db->trans_rollback();
            log_message("error", "#EKAPRT001, Error in insert on ekhajana_arrear_pre_updation_transactions table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT001'];
      }else{
            return ['result' => 'SUCCESS', 'msg' => 'DATA INSERTED SUCCESSFULLY']; 
      }
   }

   public function updatePreArrearUpdation($pre_arrear_id,$update_array,$previous_arrears)
   { 

      $year_wise_arrear_with_priorF_query = $this->db->query("select * from ekhajana_year_wise_arrear where pre_arrear_id=?
      and financial_year=?",array($pre_arrear_id, '0000-2000'));
      if($year_wise_arrear_with_priorF_query->num_rows() == 0){
         $prior2000Flag = true;
      }else{
         $prior2000Flag = false;
      }
      $pre_arrear_updation_row = $this->db->query("select * from ekhajana_arrear_pre_updation where id=? ",array($pre_arrear_id))->result();

      $previous_arrears['dist_code']= $dist_code = $pre_arrear_updation_row[0]->dist_code;
      $previous_arrears['subdiv_code']= $subdiv_code = $pre_arrear_updation_row[0]->subdiv_code;
      $previous_arrears['cir_code']=$cir_code = $pre_arrear_updation_row[0]->cir_code;
      $previous_arrears['mouza_pargona_code']= $mouza_pargona_code = $pre_arrear_updation_row[0]->mouza_pargona_code;
      $lot_no = $pre_arrear_updation_row[0]->lot_no;
      $vill_townprt_code = $pre_arrear_updation_row[0]->vill_townprt_code;
      $previous_arrears['patta_type_code']= $patta_type_code = $pre_arrear_updation_row[0]->patta_type_code;
      $previous_arrears['patta_no']= $patta_no = $pre_arrear_updation_row[0]->patta_no;
      $previous_arrears['location']=$pre_arrear_updation_row[0]->village_uuid."|". $vill_townprt_code. "|". $lot_no;

      //inserting the prior to 2000 field in case if not submited before
      if($prior2000Flag){
         $year_wise_arrear= array(
            'pre_arrear_id'      => $pre_arrear_id,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            "lot_no"             => $lot_no,
            "vill_townprt_code"  => $vill_townprt_code,
            'village_uuid'       => $pre_arrear_updation_row[0]->village_uuid,
            'patta_type_code'    => $patta_type_code,
            'patta_no'           => $patta_no,
            'total_arrear'       => $update_array[0]['total_arrear'],
            'total_revenue'      => $update_array[0]['total_revenue'],
            'total_tax'          => $update_array[0]['total_tax'],
            'user_code'          => $this->session->all_userdata()['user_code'],
            'financial_year'     => '0000-2000',
            'year_arrear'        =>  $update_array[0]['arrear'],
            'year_revenue'       =>  $update_array[0]['revenue'],
            'year_tax'           =>  $update_array[0]['tax'],
            "created_at"         => date('Y-m-d h:i:s'),
            'modified_at'        => null,
            "status"             => EKHAJANA_AREEAR_PRE_UPDATED,
            "revenue_year"       => '2000',
         );
         $tstatus3 = $this->db->insert('ekhajana_year_wise_arrear', $year_wise_arrear);
         if ($tstatus3 <= 0)
         {
            $this->db->trans_rollback();
            log_message("error", "#EKHIPAD002, Error in insert on ekhajana_year_wise_arrear table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD002'];
         }
      }
      $jama_wasil = $this->db->query("select * from jama_wasil where dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and patta_type_code=? and patta_no=?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no))->row();
      //updating jama wasil table 
      $update_data = array(
        'opening_balance'    => $update_array[0]['total_arrear'],
        'revenue'            => $jama_wasil->revenue,
        'local_tax'          => $jama_wasil->local_tax,
        'due_payment'        => $update_array[0]['total_arrear'] + $jama_wasil->revenue + $jama_wasil->local_tax,
        'modified_at'        => date('Y-m-d h:i:s'),
     ); 
     $this->db->where('dist_code', $dist_code)
              ->where('subdiv_code', $subdiv_code)
              ->where('cir_code', $cir_code)
              ->where('mouza_pargona_code', $mouza_pargona_code)
              ->where('lot_no', $lot_no)
              ->where('vill_townprt_code', $vill_townprt_code)
              ->where('patta_type_code', $patta_type_code)
              ->where('patta_no', $patta_no)
              ->update('jama_wasil', $update_data);
     if($this->db->affected_rows() != 1){ 
        $this->db->trans_rollback();
        log_message("error", "#EKAPRT0078, Error in update, table 'jama_wasil' with query ".$this->db->last_query());
        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT0078'];
     }
     $jama_wasil_transaction= array(
        'jama_wasil_id'      => $jama_wasil->id,
        'dist_code'          => $dist_code,
        'subdiv_code'        => $subdiv_code,
        'cir_code'           => $cir_code,
        'mouza_pargona_code' => $mouza_pargona_code,
        "lot_no"             => $lot_no,
        "vill_townprt_code"  => $vill_townprt_code,
        'village_uuid'       => $pre_arrear_updation_row[0]->village_uuid,
        'patta_type_code'    => $patta_type_code,
        'patta_no'           => $patta_no,
        'dag_no'             => null,
        'financial_year'     => $jama_wasil->financial_year,
        'entry_year'         => $jama_wasil->entry_year,
        'entry_date'         => $jama_wasil->entry_date,
        'revenue'            => $jama_wasil->revenue,
        "local_tax"          => $jama_wasil->local_tax,
        'opening_balance'    => $update_array[0]['total_arrear'],
        "due_payment"        => $update_array[0]['total_arrear'] + $jama_wasil->local_tax + $jama_wasil->revenue,
        "other_payment"      => null,
        "last_revenue_payment_amount"   => $jama_wasil->last_revenue_payment_amount, 
        "last_local_tax_payment_amount" => $jama_wasil->last_local_tax_payment_amount,
        "dol_year_no"        => $jama_wasil->dol_year_no,
        "pdar_id"            => $jama_wasil->pdar_id, 
        "pdar_name"          => $jama_wasil->pdar_name,
        "pdar_father_name"   => $jama_wasil->pdar_father_name,
        "status"             => JAMA_WASIL_STATUS_OFFLINE, 
        "created_at"         => date('Y-m-d h:i:s'),
        "modified_at"        => null,
        'user_code'          => $this->session->all_userdata()['user_code'],
        "application_no"     => $jama_wasil->application_no,
        "ld_application_no"  => $jama_wasil->ld_application_no,
        "case_no"            => $jama_wasil->case_no,
        "pay_status"         => JAMA_WASIL_STATUS_UNPAID
     );
     $tstatus3 = $this->db->insert('jama_wasil_transaction', $jama_wasil_transaction);
     if ($tstatus3 <= 0)
     {
        $this->db->trans_rollback();
        log_message("error", "#EKHIPAD00854, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query()));
        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD00854'];
     }

      //updating ekhajana pre updation table 
      $update_data = array(
         'arrear'             => $update_array[0]['total_arrear'],
         'revenue'            => $update_array[0]['total_revenue'],
         'tax'                => $update_array[0]['total_tax'],
         'previous_arrears'   => json_encode($previous_arrears),
         'modified_at'        => date('Y-m-d h:i:s'),
      ); 
      $this->db->where('id', $pre_arrear_id)
               ->where('dist_code', $dist_code)
               ->where('subdiv_code', $subdiv_code)
               ->where('cir_code', $cir_code)
               ->where('mouza_pargona_code', $mouza_pargona_code)
               ->where('lot_no', $lot_no)
               ->where('vill_townprt_code', $vill_townprt_code)
               ->where('patta_type_code', $patta_type_code)
               ->where('patta_no', $patta_no)
               ->update('ekhajana_arrear_pre_updation', $update_data);
      if($this->db->affected_rows() != 1){ 
         $this->db->trans_rollback();
         log_message("error", "#EKAPRT002, Error in update, table 'ekhajana_arrear_pre_updation' with query ".json_encode($this->db->last_query()));
         return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT002'];
      }

      foreach($update_array as $update_row)
      {

         $update_data_year_wise = array(
            'total_arrear'       => $update_row['total_arrear'],
            'total_revenue'      => $update_row['total_revenue'],
            'total_tax'          => $update_row['total_tax'],
            'year_arrear'        => $update_row['arrear'],
            'year_revenue'       => $update_row['revenue'],
            'year_tax'           => $update_row['tax'],
            'modified_at'        => date('Y-m-d h:i:s'),
         ); 

         $this->db->where('pre_arrear_id', $update_row['pre_arrear_id'])
                  ->where('dist_code', $dist_code)
                  ->where('subdiv_code', $subdiv_code)
                  ->where('cir_code', $cir_code)
                  ->where('mouza_pargona_code', $mouza_pargona_code)
                  ->where('lot_no', $lot_no)
                  ->where('vill_townprt_code', $vill_townprt_code)
                  ->where('patta_type_code', $patta_type_code)
                  ->where('patta_no', $patta_no)
                  ->where('financial_year', $update_row['financial_year'])
                  ->update('ekhajana_year_wise_arrear', $update_data_year_wise);
         if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKAPRT003, Error in update on ekhajana_year_wise_arrear table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT003'];
         }
      }
         
      return ['result' => 'SUCCESS', 'msg' => 'DATA UPDATED SUCCESSFULLY'];   
         
   }

   public function get2025ArchiveDouldata($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
   {
        $query = $this->db->query("select * from current_doul_demand_2025 where dist_code=? and subdiv_code=? and cir_code=?
                                     and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array(
                                        $dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no
                                     ));
        //return $this->db->last_query();
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->row();
        }
   }
}