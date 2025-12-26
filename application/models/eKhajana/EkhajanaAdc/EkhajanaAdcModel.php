<?php

class EkhajanaAdcModel extends CI_Model {
    //function to get oending count in adc end 
    public function pendingForAdcCount($dist_code)
    {
        $query = $this->db->select('count(*)')
                    ->where('dist_code', $dist_code)
                    ->where('status', EKHAJANA_STATUS_CO_FORWARD_DP_ESTATE)
                    ->from('ekhajana_basic')
                    ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row()->count;
        }else{
            return 0;
        }
    }

    //function to get pending list in adc end 
    public function pendingForAdcList($dist_code){
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('status', EKHAJANA_STATUS_CO_FORWARD_DP_ESTATE)
                    ->from('ekhajana_basic')
                    ->get(); 
        return $query->result();
    }

    //getting pending case details 
    public function getPendingCaseDetailsFromId($id){
        $query = $this->db->select('*')
                    ->where('id', $id)
                    ->from('ekhajana_basic')
                    ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return false;
        }
    }

    //function to check whether data is abvailable in jama wasil already
    public function CheckJamaWasil($caseDetails)
    {
        $query = $this->db->select('*')
                        ->where('dist_code', $caseDetails['dist_code'])
                        ->where('subdiv_code', $caseDetails['subdiv_code'])
                        ->where('cir_code', $caseDetails['cir_code'])
                        ->where('mouza_pargona_code', $caseDetails['mouza_pargona_code'])
                        ->where('lot_no', $caseDetails['lot_no'])
                        ->where('vill_townprt_code', $caseDetails['vill_townprt_code'])
                        ->where('patta_type_code', $caseDetails['patta_type_code'])
                        ->where('patta_no', $caseDetails['patta_no'])
                        ->from('jama_wasil')
                        ->get(); 
            if($query->num_rows() != 0 ){
                return $query->row();
            }else{
                return false;
            }
    }

    //getting ekhajana basic details form id 
    public function getEkBasicDetailsFromldAppNo($ld_application_no){        
        $query = $this->db->select('*')
                    ->where('ld_application_no', $ld_application_no)
                    ->from('ekhajana_basic')
                    ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return false;
        }
    }

    //method to link aadhaar with chitha
    public function linkAadhar($ekBasicDetails){
        //checking row in chitha pattadar whether aadhar linked or not 
        if($ekBasicDetails->pattadar_identification_flag!= 'Y'){
            return ['result' => true, 'msg' => ''];
        }
        //*********************************************************/
        $this->db->trans_begin();
        //checking row in chitha pattadar whether aadhar linked or not 
        $query = $this->db->select('*')
                    ->where('dist_code', $ekBasicDetails->dist_code)
                    ->where('subdiv_code', $ekBasicDetails->subdiv_code)
                    ->where('cir_code', $ekBasicDetails->cir_code)
                    ->where('mouza_pargona_code', $ekBasicDetails->mouza_pargona_code)
                    ->where('lot_no', $ekBasicDetails->lot_no)
                    ->where('vill_townprt_code', $ekBasicDetails->vill_townprt_code)
                    ->where('patta_no', $ekBasicDetails->patta_no)
                    ->where('patta_type_code', $ekBasicDetails->patta_type_code)
                    ->where('pdar_id', $ekBasicDetails->pdar_id)   
                    ->from('chitha_pattadar')                 
                    ->get();
                  
        if($query!="" && $query!=null && $query->num_rows()==1){
            
            if($ekBasicDetails->aadhaar_pan_type == 'AADHAAR'){
                $update_data = array(
                    'pdar_aadharno' => $ekBasicDetails->aadhaar_pan_ref_no,
                ); 
            }else if($ekBasicDetails->aadhaar_pan_type == 'PAN'){
                $update_data = array(
                    'pdar_pan_no' => $ekBasicDetails->aadhaar_pan_ref_no,
                ); 
            }
            
            $this->db->where('dist_code', $ekBasicDetails->dist_code)
                    ->where('subdiv_code', $ekBasicDetails->subdiv_code)
                    ->where('cir_code', $ekBasicDetails->cir_code)
                    ->where('mouza_pargona_code', $ekBasicDetails->mouza_pargona_code)
                    ->where('lot_no', $ekBasicDetails->lot_no)
                    ->where('vill_townprt_code', $ekBasicDetails->vill_townprt_code)
                    ->where('patta_no', $ekBasicDetails->patta_no)
                    ->where('patta_type_code', $ekBasicDetails->patta_type_code)
                    ->where('pdar_id', $ekBasicDetails->pdar_id)   
                    ->update('chitha_pattadar', $update_data);
                     
            if($this->db->affected_rows() != 1){ 
                $this->db->trans_rollback();
                log_message("error", "#EKCOADHL001, Error in update, table 'chitha_pattadar'  with query- ". json_encode($this->db->last_query()));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCOADHL001'];
            }else{
                $this->db->trans_commit();
                return ['result' => true, 'msg' => 'Aadhar Linked'];    
            }
        } 
    }

    //function to dispose case upadting ekhajana basic
    public function AdcdisposeCaseDpEstateWithoutInsert($posted_data,$ekBasicDetails,$getJamaWasilData){
        $this->db->trans_begin();
        //ekhajana basic update 
        $update_data = array(
            'status' => EKHAJANA_STATUS_COMPLETED,
            'pending_with_officer' => '--',
            'adc_remark' => $posted_data['adc_report'],
            'user_code' => 'ADC',
            'modified_at' => date('Y-m-d h:i:s')
        ); 
        $this->db->where('case_no', $ekBasicDetails->case_no);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPEWI001, Error in update  table 'ekhajana_basic' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWI001'];
        }
      
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $ekBasicDetails->ld_application_no,
            'application_no' => $ekBasicDetails->application_no,
            'remark' => "ADC-CASE-DISPOSED",            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $ekBasicDetails->case_no,
            'status' => EKHAJANA_STATUS_COMPLETED
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPEWI003, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWI003'];
        }
        //**************************************************//
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPEWI004, Transaction Status Error  Update Details with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWI004'];
        }else{
            //basundhara ekhajana payment update
            //basundhara ekhajana land details update
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                        'ld_application_no' => $ekBasicDetails->ld_application_no,
                        'application_no' => $ekBasicDetails->application_no,
                        'dharitree_case_no' => $ekBasicDetails->case_no,
                        'user_code' => 'ADC',                    
                        'date_of_action' => date("Y-m-d"),
                        "patta_no" => $ekBasicDetails->patta_no,
                        'remark' => "ADC CASE DISPOSED",
                    ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){

                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Case Disposed Sucessfully..!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKHADCDCDPEWICRLL005, Curl Error(Y) In Api ".EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL005'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL006'];
            }
        } 
    }

    //function to get the arrear details of the case
    public function getEkhajanaArrearDetails($caseDetails){
        $query = $this->db->select('*')
                        ->where('dist_code', $caseDetails['dist_code'])
                        ->where('subdiv_code', $caseDetails['subdiv_code'])
                        ->where('cir_code', $caseDetails['cir_code'])
                        ->where('mouza_pargona_code', $caseDetails['mouza_pargona_code'])
                        ->where('lot_no', $caseDetails['lot_no'])
                        ->where('vill_townprt_code', $caseDetails['vill_townprt_code'])
                        ->where('patta_type_code', $caseDetails['patta_type_code'])
                        ->where('patta_no', $caseDetails['patta_no'])
                        ->from('ekhajana_tn_branch_arrear_details')
                        ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return false;
        }
    }

    //inserting in jama wasil and updating status in basundhara
    public function AdcdisposeCaseDpEstate($posted_data,$ArrearData,$ekBasicDetails,$jama_wasil_data,
                                            $jama_wasil_payee_list_data,$jama_wasil_backup_table_data){
        $this->db->trans_begin();
        //insert data in jama_wasil 
        $tstatus1 = $this->db->insert('jama_wasil', $jama_wasil_data); 
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE001, Error in insert on jama_wasil table with  query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE001'];
        }
        $jama_wasil_inserted_id = $this->db->insert_id(); 

        //insert data in jama_wasil_transaction 
        $jama_wasil_data['jama_wasil_id'] = $jama_wasil_inserted_id;
        $tstatus2 = $this->db->insert('jama_wasil_transaction', $jama_wasil_data); 
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE002, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE002'];
        }
        
        $jama_wasil_transaction_inserted_id = $this->db->insert_id();
        
        //insert data in jama_wasil_payee_list 
        $jama_wasil_payee_list_data['jama_wasil_id'] = $jama_wasil_inserted_id;
        $jama_wasil_payee_list_data['jama_wasil_transaction_id'] = $jama_wasil_transaction_inserted_id;
        $tstatus3 = $this->db->insert('jama_wasil_payee_list', $jama_wasil_payee_list_data); 
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE003, Error in insert on jama_wasil_payee_list table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE003'];
        }
        //insert data in jama_wasil_backup
        $tstatus4 = $this->db->insert('jama_wasil_backup', $jama_wasil_backup_table_data); 
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE004, Error in insert on jama_wasil_backup table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE004'];
        }
        //ekhajana basic update 
        $update_data = array(
            'status' => EKHAJANA_STATUS_COMPLETED,
            'pending_with_officer' => '--',
            'adc_remark' => $posted_data['adc_report'],
            'user_code' => $this->session->all_userdata()['user_code'],
            'modified_at' => date('Y-m-d h:i:s'),
        ); 
        $this->db->where('case_no', $ekBasicDetails->case_no);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE005, Error in update , table 'ekhajana_basic' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE005'];
        }
        //ekhajana mouzadar arrear details update 
        $update_data_arrear = array(
            'ek_basic_id' => $ekBasicDetails->id
        ); 
        $this->db->where('case_no', $ekBasicDetails->case_no);
        $this->db->update('ekhajana_tn_branch_arrear_details', $update_data_arrear);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE006, Error in update table 'ekhajana_mouzadar_arrear_details' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE007'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $ekBasicDetails->ld_application_no,
            'application_no' => $ekBasicDetails->application_no,
            'remark' => "ADC-CASE-DISPOSED",            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $ekBasicDetails->case_no,
            'status' => EKHAJANA_STATUS_COMPLETED
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE008, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE008'];
        }
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE009, Transaction Status  Update Details with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE009'];
        }else{
            //basundhara ekhajana payment update
            //basundhara ekhajana land details update
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                        'ld_application_no' => $ekBasicDetails->ld_application_no,
                        'application_no' => $ekBasicDetails->application_no,
                        'dharitree_case_no' => $ekBasicDetails->case_no,
                        'due_payment' => $jama_wasil_data['due_payment'],
                        'user_code' => 'ADC',                    
                        'date_of_action' => date("Y-m-d"),
                        "patta_no" => $ekBasicDetails->patta_no,
                        'remark' => "ADC CASE DISPOSED",
                    ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
    
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Case Disposed Sucessfully..!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKHADCDCDPECRLL0010, Curl Error(Y) In Api ".EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPECRLL0010'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKHADCDCDPECRLL0011, Curl Error(200) In Api ".EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPECRLL0011'];
            }
        } 
    }

    public function getArrearData($dist_code,$subdiv_code,$cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no)
    {
        $query = $this->db->select('*')
                          ->where('dist_code', $dist_code)
                          ->where('subdiv_code', $subdiv_code)
                          ->where('cir_code', $cir_code)
                          ->where('mouza_pargona_code', $mouza_pargona_code)
                          ->where('lot_no', $lot_no)
                          ->where('vill_townprt_code', $vill_townprt_code)
                          ->where('patta_type_code', $patta_type_code)
                          ->where('patta_no', $patta_no)
                          ->from('ekhajana_tn_branch_arrear_details')
                          ->get();
            if($query->num_rows() > 0){
                return $query->row();
            }else{
                return "NO-DATA-FOUND";
            }
    }

    //verify all mouzadar bank details 
    public function getAllMouzadarDetails($dist_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_GET_ALL_MOUZADAR_BANK_DETAILS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'dist_code' => $dist_code,
                ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){

            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                return ['result' => 'SUCCESS', 'msg' => $response_obj->msg];                 
            }else{
                log_message("error", "#EKHADCDCDPEWICRLL005, Curl Error(Y) In Api ".EKHAJANA_GET_ALL_MOUZADAR_BANK_DETAILS);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL005'];
            } 
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_GET_ALL_MOUZADAR_BANK_DETAILS);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL006'];
        }
    }

    
    public function updateAdcVerifed($all_data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_UPDATE_EKHAJANA_ADC_MOUZADAR_ACCOUNT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'all_data' => $all_data,
                ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "SUCCESS"){
                return ['result' => 'SUCCESS', 'msg' => "Details Updated Successfully"];                 
            }else{
                log_message("error", "#EKHADCDCDPEWICRLL005, Curl Error(Y) In Api ".EKHAJANA_UPDATE_EKHAJANA_ADC_MOUZADAR_ACCOUNT);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL005'];
            } 
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_UPDATE_EKHAJANA_ADC_MOUZADAR_ACCOUNT);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWICRLL006'];
        }
    }

    public function getMouzadarnameName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code)
    {
        $query = $this->db->query("select u.username as usename from loginuser_table lut join users u on lut.user_code = u.user_code where lut.dist_code=? and lut.subdiv_code=? and lut.cir_code=? and lut.mouza_pargona_code=? and lut.dis_enb_option=? and lut.user_map=? and u.user_desig_code =?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,'E','y','MOU'));
        if($query->num_rows() ==0){
            return "Not Found";
        }else{
            $mouzadar_name =  $query->row()->usename;
            return $mouzadar_name;
        }
        
    }

    public function getEcfrDetails($dist_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_ECFR_DETAILS_MOUZA_WISE_ADC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'dist_code' => $dist_code,
                ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_ECFR_DETAILS_MOUZA_WISE_ADC);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function getMouzadariDetails($dist_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_MOUZADARI_REPORT_ADC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'dist_code' => $dist_code,
                ),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_MOUZADARI_REPORT_ADC);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    //function to get the arrear details of the case
    public function getPreArrearDetails($caseDetails){
        $query = $this->db->select('*')
                        ->where('dist_code', $caseDetails['dist_code'])
                        ->where('subdiv_code', $caseDetails['subdiv_code'])
                        ->where('cir_code', $caseDetails['cir_code'])
                        ->where('mouza_pargona_code', $caseDetails['mouza_pargona_code'])
                        ->where('lot_no', $caseDetails['lot_no'])
                        ->where('vill_townprt_code', $caseDetails['vill_townprt_code'])
                        ->where('patta_type_code', $caseDetails['patta_type_code'])
                        ->where('patta_no', $caseDetails['patta_no'])
                        ->from('ekhajana_arrear_pre_updation_dp_estate')
                        ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return 'NO-DATA-FOUND';
        }
    }

    //function to get the arrear details of the case
    public function getCurrentDpDoulDemand($caseDetails){
        $query = $this->db->select('*')
                        ->where('dist_code', $caseDetails['dist_code'])
                        ->where('subdiv_code', $caseDetails['subdiv_code'])
                        ->where('cir_code', $caseDetails['cir_code'])
                        ->where('mouza_pargona_code', $caseDetails['mouza_pargona_code'])
                        ->where('lot_no', $caseDetails['lot_no'])
                        ->where('vill_townprt_code', $caseDetails['vill_townprt_code'])
                        ->where('patta_type_code', $caseDetails['patta_type_code'])
                        ->where('patta_no', $caseDetails['patta_no'])
                        ->from('current_dp_doul_demand')
                        ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return 'NO-DATA-FOUND';
        }
    }

    //handling the case rejection in mouzadari system
    public function rejectCaseDpEstate($posted_data){
        error_reporting(0);
        $this->db->trans_begin();
        $array = json_decode(json_encode($posted_data['reject_code']),true);
        $reject_codes_str = implode(',', $array);
        $sql = "select string_agg(remark::text,',') as rmk from reject_master rm where reject_code in (".$reject_codes_str.")";
        $query = $this->db->query($sql);
        $codes_rmk = $query->row()->rmk;
        $rmk_all_str = $posted_data['remark'].", ".$codes_rmk;
        //updating ekhajana basic table status
        $update_data = array(
            'modified_at'                     => date('Y-m-d h:i:s'),
            'status'                          => EKHAJANA_STATUS_REJECTED,
            'adc_remark'                      => $rmk_all_str,
            'pending_with_officer'            => '--',
            'reject_codes'                    => json_encode($posted_data['reject_code']),
            'adc_pattadar_identification_flag'=> $posted_data['adc_pattadar_identification_flag'],
            'user_code'                       => $this->session->all_userdata()['user_code'],
        ); 
        $this->db->where('id', $posted_data['ek_details_id']);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKCORD001, Error in update, table 'ekhajana_basic ' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD001'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $posted_data['ld_application_no'],
            'application_no'    => $posted_data['application_no'],
            'remark'            => $rmk_all_str,           
            'user_code'         => $this->session->all_userdata()['user_code'],
            "created_at"        => date('Y-m-d h:i:s'),
            "case_no"           => $posted_data['case_no'],
            'reject_codes'      => json_encode($posted_data['reject_code']),
            'status'            => EKHAJANA_STATUS_REJECTED
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCORD006, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD006'];
        }
        //final transaction status
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKCORD002, Transaction Status Error In Saving Land Details with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD002'];
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_CO_REJECTED_API,
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
                    'ld_application_no' => $posted_data['ld_application_no'],
                    'application_no'    => $posted_data['application_no'],
                    'dharitree_case_no' => $posted_data['case_no'],
                    'user_code'         => $this->session->all_userdata()['user_code'],                    
                    'date_of_action'    => date("Y-m-d"),
                    "patta_no"          => $posted_data['patta_no'],
                    'remark'            => $rmk_all_str,
                    'reject_codes'      => json_encode($posted_data['reject_code'])
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
                    return ['result' => 'SUCCESS', 'msg' => 'Case Rejected Successfully!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKCORCRLD004, Curl Error(Y) In Api ".EKHAJANA_CO_REJECTED_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD004'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKCORCRLD005, Curl Error(200) In Api ".EKHAJANA_CO_REJECTED_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
            }  
        } 
    }


    // ********************************************************

    //method to check whether new table(current doul demand) is created or not 
    public function checkTableCreated($archive_table){
        $query = $this->db->query("SELECT EXISTS (
            SELECT FROM pg_tables
            WHERE  schemaname = 'public'
            AND    tablename  = '$archive_table'
            )");
        return $query->result();               
    }


    //method to move current doul in archive table and insert into arrear table
    public function updateEkhajanaBeforeDoulChange($dist_code,$subdiv_code,$cir_code,$current_year){
        // error_reporting(0);
        $old_year =(int)$current_year-1;
        log_message('error','searching data for the year in jama wasil '.$old_year);
        
        //creating a archive doul table
        $current_demand_new = 'current_dp_doul_demand_'.$old_year;
        $current_doul_demand = 'current_dp_doul_demand';
        $this->db->query("CREATE TABLE IF NOT EXISTS $current_demand_new (LIKE $current_doul_demand including all)");
        $checkTableCreated = $this->checkTableCreated($current_demand_new);
        if (trim($checkTableCreated[0]->exists) != 't')
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCNTODC001, Error in insert on current_dp_doul_demand_new table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCNTODC001'];
        }
        else
        {
            $old_doul_count = $this->db->query("select count(*) as old_doul_count from current_dp_doul_demand where dist_code=? and subdiv_code=? and cir_code=?",array($dist_code,$subdiv_code,$cir_code))->row()->old_doul_count;
            log_message("error","OLD CURRENT DP DOUL COUNT ==> ".$old_doul_count);
            //insert the current doul demand data to the archive table
            $insertStatus = $this->db->query("INSERT INTO $current_demand_new SELECT * FROM $current_doul_demand where dist_code = '$dist_code'
                                and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and year_no = '$old_year'");
        
            if(!$insertStatus)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKCNTODC002, Error in insert on current_dp_doul_demand_new table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCNTODC002'];
            }
            $archive_doul_count = $this->db->query("select count(*) as arc_doul_count from $current_demand_new where dist_code=? and subdiv_code=? and cir_code=?",array($dist_code,$subdiv_code,$cir_code))->row()->arc_doul_count;
            log_message("error","ARCHIVE CURRENT DP DOUL COUNT ==> ".$archive_doul_count);
            //cheching if all the data are correctly inserted into the archive table before deletingg
            if($old_doul_count != $archive_doul_count){
                $this->db->trans_rollback();
                log_message("error", "#EKCNTODC845, mismatch in count in the archive table created with the old_dp_doul count- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCNTODC845'];
            }
            else
            {
                //delete the data upto cir_code from current doul demand
                $query = $this->db->query("SELECT COUNT(*) AS cnt FROM current_dp_doul_demand WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND year_no = ?", array($dist_code, $subdiv_code, $cir_code, (string)$old_year));
                $doul_demand_row_count = $query->row()->cnt;

                if($doul_demand_row_count != 0){
                    $this->db->where('dist_code', $dist_code)
                                ->where('subdiv_code', $subdiv_code)
                                ->where('cir_code', $cir_code)
                                ->where('year_no', (string)$old_year)
                                ->delete('current_dp_doul_demand');
                    if($this->db->affected_rows() <= 0){
                        $this->db->trans_rollback();
                        log_message("error", "#EKCNTODC003, Error in delete, table current_dp_doul_demand with query- ". json_encode($this->db->last_query()));
                        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCNTODC003'];
                    }else{
                        return ['result' => 'SUCCESS', 'msg' => 'Archive table created successfully'];
                    }
                }
                else
                {
                    log_message("error","data not deleted from current dp doul demand since no data is available against the circle in the year");
                    return ['result' => 'SUCCESS', 'msg' => 'data not deleted from current dp doul demand'];
                }
            } 
        }
    }

    //method to update the jama wasil with new doul data and with arrear data
    public function updateEkhajanaAfterDoulChange($dist_code,$subdiv_code,$cir_code,$year){
        
        $current_year = date('Y');
        $old_year = ($year-1);
        $getJamaWasilData = $this->getAllDpJamaWasilData($dist_code,$subdiv_code,$cir_code,$old_year);
        log_message('error','searching data for the year in jama wasil after doul change '.$old_year);
        
        if($getJamaWasilData != 'NO-DATA-FOUND'){
            
            $is_deleted = 0;
            $count = 1;
            
            foreach($getJamaWasilData as $jamaData){
                $rev_query = $this->getCurrentRevenueDpData($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,$jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no,$year);
                if($rev_query->num_rows() > 0)
                {
                    $row = $rev_query->row();
                    if(isset($row->dag_revenue) && $row->dag_revenue!=0 && $row->dag_revenue!='' && $row->dag_revenue!=null){
                        $revenue = $row->dag_revenue;
                    }else{
                        $revenue = 0;
                        $is_deleted = 1;    
                    }
                    
                }
                else
                {
                    $revenue = 0;
                    $is_deleted = 1;
                }
                
                $localTaxQuery = $this->getCurrentLocalDpTax($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,$jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no,$year); 

                if($localTaxQuery->num_rows() > 0)
                {
                    $row1 = $localTaxQuery->row();
                    if(isset($row1->dag_local_tax) && $row1->dag_local_tax!=0 && $row1->dag_local_tax!='' && $row1->dag_local_tax!=null){
                        $local_tax = $row1->dag_local_tax;
                    }else{
                        $local_tax = 0;
                        $is_deleted = 1;    
                    }
                }
                else
                {
                    $local_tax = 0;
                    $is_deleted = 1;
                }

                $SurchargeQuery = $this->getCurrentDpSurcharge($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,$jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no,$year); 

                if($SurchargeQuery->num_rows() > 0)
                {
                    $row2 = $SurchargeQuery->row();
                    if(isset($row2->surcharge)){
                        $surcharge = $row2->surcharge;
                    }else{
                        $surcharge = 0;
                        $is_deleted = 1;    
                    }
                }
                else
                {
                    $surcharge = 0;
                    $is_deleted = 1;
                }
                // ********************************************
                //update in the ekhajana_arrear_pre_updation and insert into ekhajana_year_wise_arrear for the revenue year 2024
                if($jamaData->pay_status == 'UNPAID'){
                    //updating in pre arrear table
                    $year = doul_year_no;
                    $old_dp_year = ($year-1);
                    $current_dp_demand_archive = 'current_dp_doul_demand_'.$old_dp_year;
                    $ekhajana_arrear_pre_updation_table_row = $this->db->query("select * from ekhajana_arrear_pre_updation_dp_estate where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code =?
                                    and lot_no =? and vill_townprt_code=? and patta_type_code =? and patta_no =? ",array($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,
                                    $jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no))->row();
                    $archive_dp_doul = $this->db->query("select * from $current_dp_demand_archive where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code =?
                                    and lot_no =? and vill_townprt_code=? and patta_type_code =? and patta_no =? ",array($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,
                                    $jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no))->row();

                    $pre_arrear_revenue     =  $jamaData->revenue + $ekhajana_arrear_pre_updation_table_row->revenue;
                    $pre_arrear_tax         =  $jamaData->local_tax + $ekhajana_arrear_pre_updation_table_row->tax;
                    $pre_arrear_arrear      =  $archive_dp_doul->surcharge + $jamaData->local_tax + $jamaData->revenue + $ekhajana_arrear_pre_updation_table_row->arrear;
                    $pre_arrear_surcharge   =  $archive_dp_doul->surcharge + $ekhajana_arrear_pre_updation_table_row->surcharge;
                    $pre_arrear_id          =  $ekhajana_arrear_pre_updation_table_row->id;

                    $update_pre_arrear= array(
                        'revenue'           => $pre_arrear_revenue,
                        'tax'               => $pre_arrear_tax,
                        'arrear'            => $pre_arrear_arrear,
                        'surcharge'         => $pre_arrear_surcharge,
                        'modified_at'       => date('Y-m-d h:i:s'),
                    );
                    $this->db->where('id', $pre_arrear_id);
                    $this->db->update('ekhajana_arrear_pre_updation_dp_estate', $update_pre_arrear);    
                    if($this->db->affected_rows() != 1){ 
                        $this->db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in update, table 'ekhajana_arrear_pre_updation_dp_estate'  with query- ". ($this->db->last_query()));
                        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012'];
                    }

                    //inserting into  in pre arrear table year wise table
                    $year_wise_arrear= array(
                        'pre_arrear_id'         => $pre_arrear_id,
                        'dist_code'             => $dist_code,
                        'subdiv_code'           => $subdiv_code,
                        'cir_code'              => $cir_code,            
                        'mouza_pargona_code'    => $jamaData->mouza_pargona_code,
                        "lot_no"                => $jamaData->lot_no,
                        "vill_townprt_code"     => $jamaData->vill_townprt_code,
                        'village_uuid'          => $jamaData->village_uuid,
                        'patta_type_code'       => $jamaData->patta_type_code,
                        'patta_no'              => $jamaData->patta_no,
                        'total_arrear'          => $pre_arrear_arrear,
                        'total_revenue'         => $pre_arrear_revenue,
                        'total_tax'             => $pre_arrear_tax,
                        'total_surcharge'       => $pre_arrear_surcharge,
                        'user_code'             => $this->session->all_userdata()['user_code'],
                        'financial_year'        => $jamaData->financial_year,
                        'year_arrear'           => $jamaData->revenue + $jamaData->local_tax + $archive_dp_doul->surcharge,
                        'year_revenue'          => $jamaData->revenue,
                        'year_tax'              => $jamaData->local_tax,
                        'year_surcharge'        => $archive_dp_doul->surcharge,
                        "created_at"            => date('Y-m-d h:i:s'),
                        'modified_at'           => null,
                        "status"                => PORT_DOUL_PRE_ARREAR_UPDATE_STATUS,
                        "revenue_year"          => $jamaData->dol_year_no,
                        'modified_at'           => date('Y-m-d h:i:s'),
                    );
                    $tstatus38 = $this->db->insert('ekhajana_year_wise_arrear_dp_estate', $year_wise_arrear);
                    if ($tstatus38 != 1)
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in insert on ekhajana_year_wise_arrear_dp_estate table with query- ". json_encode($this->db->last_query()));
                        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012'];
                    }
                    $update_year_wise =array(
                        'total_arrear'          => $pre_arrear_arrear,
                        'total_revenue'         => $pre_arrear_revenue,
                        'total_tax'             => $pre_arrear_tax,
                        'total_surcharge'       => $pre_arrear_surcharge,
                    );
                    $this->db->where('pre_arrear_id', $pre_arrear_id);
                    $this->db->update('ekhajana_year_wise_arrear_dp_estate', $update_year_wise);  
                    if($this->db->affected_rows() != 26){ 
                        $this->db->trans_rollback();
                        log_message("error", "#EKHPAUR001845, Error in update, table 'ekhajana_year_wise_arrear_dp_estate'  with query- ". json_encode($this->db->last_query()));
                        return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR001845'];
                    }
                    $count_pre_year_wise = $this->db->query("select count(*) as count from ekhajana_year_wise_arrear_dp_estate where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and year_arrear is not null ", array($jamaData->dist_code, $jamaData->subdiv_code, 
                                            $jamaData->cir_code, $jamaData->mouza_pargona_code, $jamaData->lot_no, $jamaData->vill_townprt_code,
                                            $jamaData->patta_type_code, $jamaData->patta_no))->row()->count;
                    if($count_pre_year_wise != 26){
                        log_message("error", "PORTDPDOULEKHMOUYEARWARRNF,ekhajana_year_wise_arrear_dp_estate not found to be 26 count for ". json_encode($this->db->last_query()));
                        return ['result' => 'SERVER-ERROR', 'msg' => 'PORTDPDOULEKHMOUYEARWARRNF Some Error Occureed Please try again..'];
                    }
                }
                // ********************************************
                $previousArrearData = $this->getPreviousDpArrearData($jamaData->dist_code,$jamaData->subdiv_code,$jamaData->cir_code,$jamaData->mouza_pargona_code,
                $jamaData->lot_no,$jamaData->vill_townprt_code,$jamaData->patta_type_code,$jamaData->patta_no, $old_year);
                if($previousArrearData == false){
                    $this->db->trans_rollback();
                    log_message("error", "#EKUEADC002, Error in fetching previous areear data- ". ($this->db->last_query()));
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEADC002'];   
                }
                if($previousArrearData->due_payment == 0)
                {
                    $opening_balance = 0;
                }
                else
                {
                    $opening_balance = $previousArrearData->revenue + $previousArrearData->local_tax + $previousArrearData->opening_balance + $archive_dp_doul->surcharge;
                }

                $new_due_payment =  $opening_balance + $revenue + $local_tax + $surcharge;                   

                $jama_Wasil_Details = array(
                    'entry_year'        => $current_year,
                    'revenue'           => $revenue,
                    'due_payment'       => $new_due_payment,
                    'opening_balance'   => $opening_balance,
                    'local_tax'         => $local_tax,
                    'surcharge'         => $surcharge,
                    'dol_year_no'       => $year,
                    'modified_at'       => date("Y-m-d h:i:s"),
                    'financial_year'    => date("Y").'-'.(date("Y")+1),
                    'pay_status'        => JAMA_WASIL_STATUS_UNPAID,
                    'is_deleted'        => $is_deleted,
                    'is_dp'             => 'Y',
                );
                $this->db->where('dist_code', $jamaData->dist_code);
                $this->db->where('subdiv_code', $jamaData->subdiv_code);
                $this->db->where('cir_code', $jamaData->cir_code);
                $this->db->where('mouza_pargona_code', $jamaData->mouza_pargona_code);
                $this->db->where('lot_no', $jamaData->lot_no);
                $this->db->where('vill_townprt_code', $jamaData->vill_townprt_code);
                $this->db->where('patta_type_code', $jamaData->patta_type_code);
                $this->db->where('patta_no', $jamaData->patta_no);
                $this->db->where('id', $jamaData->id);
                $this->db->update('jama_wasil', $jama_Wasil_Details);    
                if($this->db->affected_rows() <= 0){ 
                    $this->db->trans_rollback();
                    log_message("error", "#EKUEADC002, Error in update, table 'jama_wasil'  with query- ". ($this->db->last_query()));
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEADC002'];
                }
            
                $jama_Wasil_transaction_array = array(
                    'jama_wasil_id'                 => $jamaData->id,
                    'due_payment'                   => $new_due_payment,
                    'opening_balance'               => $opening_balance,
                    'dist_code'                     => $jamaData->dist_code,
                    'subdiv_code'                   => $jamaData->subdiv_code,
                    'cir_code'                      => $jamaData->cir_code,           
                    'mouza_pargona_code'            => $jamaData->mouza_pargona_code,
                    "lot_no"                        => $jamaData->lot_no,
                    "vill_townprt_code"             => $jamaData->vill_townprt_code,
                    "village_uuid"                  => $jamaData->village_uuid,
                    'patta_type_code'               => $jamaData->patta_type_code,
                    'patta_no'                      => $jamaData->patta_no,
                    'dag_no'                        => $jamaData->dag_no,
                    'financial_year'                => date("Y").'-'.(date("Y")+1),
                    'entry_year'                    => $current_year,
                    'entry_date'                    => date("Y-m-d"),
                    'revenue'                       => $revenue,
                    'local_tax'                     => $local_tax,
                    'other_payment'                 => null,
                    'last_revenue_payment_amount'   => $jamaData->last_revenue_payment_amount,
                    'last_local_tax_payment_amount' => $jamaData->last_revenue_payment_amount,
                    'dol_year_no'                   => $year,
                    'pdar_id'                       => $jamaData->pdar_id,
                    'pdar_name'                     => $jamaData->pdar_name,
                    'pdar_father_name'              => $jamaData->pdar_father_name,
                    'status'                        => $jamaData->status,
                    'created_at'                    => $jamaData->created_at,
                    'modified_at'                   => $jamaData->modified_at,
                    'user_code'                     => $jamaData->user_code,
                    'application_no'                => $jamaData->application_no,
                    'ld_application_no'             => $jamaData->ld_application_no,
                    'case_no'                       => $jamaData->case_no,
                    'pay_status'                    => JAMA_WASIL_STATUS_UNPAID,
                    'is_deleted'                    => $is_deleted,
                    'is_dp'                         => 'Y',

                ); 
                $tstatus2 = $this->db->insert('jama_wasil_transaction', $jama_Wasil_transaction_array); 
                if ($tstatus2!= 1)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#EKCOF002, Error in insert on jama_wasil_transaction table with query- ". json_encode($this->db->last_query()));
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF002'];
                }
                $is_deleted = 0;    
                $count = $count + 1;           
            }
            return ['result' => 'SUCCESS', 'msg' => 'Data Updated Successfully!!'];
        }
        log_message('error','jama wasil data not found but data updated!!');
        return ['result' => 'SUCCESS', 'msg' => 'jama wasil data not available for the circle but data updated!!'];
    }

    //function to get the jamawasil data 
    public function getAllDpJamaWasilData($dist_code,$subdiv_code,$cir_code,$year){
            $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('is_dp','Y')
                    ->where('dol_year_no',(string)$year)
                    ->from('jama_wasil')
                    ->get(); 
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return 'NO-DATA-FOUND';
        }
    }

    //method to get the current revenue from current doul demand  table
    public function getCurrentRevenueDpData($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_townprt_code,
    $patta_type_code,$patta_no,$year){
        $query = $this->db->select('dag_revenue')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->where('year_no',(string)$year)
                    ->from('current_dp_doul_demand')
                    ->get();   
            return $query;
    }

    //method to get the current local tax from current doul demand
    public function getCurrentLocalDpTax($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_townprt_code,
    $patta_type_code,$patta_no,$year){
        $query = $this->db->select('dag_local_tax')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->where('year_no',(string)$year)
                    ->from('current_dp_doul_demand')
                    ->get(); 
            //log_message('error',$this->db->last_query());
            return $query;
        
    }

    //method to get the current surcharge from current doul demand
    public function getCurrentDpSurcharge($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_townprt_code,
    $patta_type_code,$patta_no,$year){
        $query = $this->db->select('surcharge')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->where('year_no',(string)$year)
                    ->from('current_dp_doul_demand')
                    ->get(); 
            //log_message('error',$this->db->last_query());
            return $query;
        
    }

    //method to get ekhajana arrear details table data
    public function getPreviousDpArrearData($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no,$old_year){
        $query = $this->db->select('*')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('mouza_pargona_code', $mouza_pargona_code)
                    ->where('lot_no', $lot_no)
                    ->where('vill_townprt_code', $vill_townprt_code)
                    ->where('patta_type_code', $patta_type_code)
                    ->where('patta_no', $patta_no)
                    ->where('is_dp', 'Y')
                    ->where('dol_year_no', (string)$old_year)
                    ->from('jama_wasil')
                    ->get(); 
        
            if($query->num_rows() != 0 ){
                return $query->row();
            }else{
                return false;
            }

    }
    

    

}
?>