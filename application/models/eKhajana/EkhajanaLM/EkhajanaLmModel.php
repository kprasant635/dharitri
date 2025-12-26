<?php

class EkhajanaLmModel extends CI_Model {

    //inserting case in ekhajan basic table 
    //generated dharitree case no 
    //updating basundhara status to lm forward 
    public function insertEkhajanaBasicDetails($data){
        error_reporting(0);
        $pdar_father_name = null;
        if($data['pdar_father_name'] == null || $data['pdar_father_name'] == "")
        {
            $pdar_father_name = 'NA';
        }else{
            $pdar_father_name = $data['pdar_father_name'];
        }
        $this->db->trans_begin();
        $village_uuid = $this->getVillageUUID($data['dist_code'],$data['subdiv_code'],
        $data['cir_code'],$data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code']);
        $case_no_abbr = $this->generteCaseName();        
        //inserting basic details in ekhajana basic 
        $insertDataForEkhajanaBasic = [
            "application_no" => $data['application_no'],
            "ld_application_no" => $data['ld_application_no'],
            "dist_code" => $data['dist_code'],
            "subdiv_code" => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            "mouza_pargona_code" => $data['mouza_pargona_code'],
            "lot_no" => $data['lot_no'],
            "vill_townprt_code" => $data['vill_townprt_code'],
            "village_uuid" => $village_uuid,
            "is_urban" => $data['is_urban'],
            "patta_type_code" => $data['patta_type_code'],
            "patta_type" => $data['patta_type'],
            "patta_no" => $data['patta_no'],
            "pdar_id" => $data['pdar_id'], 
            "pdar_name" => $data['pdar_name'],
            "pdar_father_name" => $pdar_father_name,
            "applicant_name_eng" => $data['applicant_name_eng'],
            "applicant_name_asm" => $data['applicant_name_asm'],
            "guardian_name_eng" => $data['guardian_name_eng'],
            "guardian_name_asm" => $data['guardian_name_asm'],
            "guardian_relation" => $data['guardian_relation'],
            "gender" => $data['gender'],
            "date_of_birth" => $data['date_of_birth'],
            "address" => $data['address'],
            "mobile_no" => $data['mobile_no'],
            "pending_with_officer" => "CO",
            "lm_remark" => $data['lm_report'],
            "status" => EKHAJANA_STATUS_LM_FORWARD,
            "created_at" => date('Y-m-d h:i:s'),
            'user_code' => $this->session->all_userdata()['user_code'],
            'case_no' => "NOT-GENERATED",
            'aadhaar_pan_ref_no' => $data['aadhaar_pan_ref_no'],
            'aadhaar_pan_type' => $data['aadhaar_pan_type']
        ];
        $tstatus1 = $this->db->insert('ekhajana_basic', $insertDataForEkhajanaBasic); 
        if ($tstatus1!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKBI0001, Error in insert on ekhajana_basic table with data ". json_encode($insertDataForEkhajanaBasic));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI0001'];
        }
        $ekhajana_basic_inserted_id = $this->db->insert_id();
        $case_no = $case_no_abbr."EKH/".$ekhajana_basic_inserted_id;
        //updating ekhajana basic details with case no 
        $update_data = array(
            'case_no' => $case_no,
        ); 
        $this->db->where('id', $ekhajana_basic_inserted_id);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKBI0002, Error in update, table 'ekhajana_basic' with rtps application no ".$data['ld_application_no']);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI0002'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['lm_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => EKHAJANA_STATUS_LM_FORWARD
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKBI0003, Error in insert on ekhajana_basic_proceedings table with data ". json_encode($proceeding_details_data));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI0003'];
        }
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKLDI0006, Transaction Status Error In Saving Land Detasils");
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKLDI0006'];
        }else{
            //post api to basundhara
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_LM_FORAWRDED_API,
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
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => 'LM',                    
                    'date_of_action' => date("Y-m-d"),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['lm_report'],
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
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwared To Co Successfully!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKCRLLMT0007, Curl Error(Y) In Api ".EKHAJANA_LM_FORAWRDED_API);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCRLLMT0007'];
                } 
                curl_close($curl);
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKCRLLMT0008, Curl Error(200) In Api ".EKHAJANA_LM_FORAWRDED_API);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCRLLMT0008'];
            }  
        } 
    }

    //getting the case abbr
    function generteCaseName(){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }

    //getting village uuid
    function getVillageUUID($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){    
        $sql = "select uuid from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code  = ?";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code, '0000'));        
        $result = $query->result(); 

        if(count($result) != 0 ){
            return $result[0]->uuid;
        }else{
            return "";
        }
    }

    //function to insert of update in basic details
    public function updateEkBasicForMouzadariSystem($data){
        $CheckStatus = $this->CheckCaseNumber($data);
        if($CheckStatus['result'] == 'NOT-GENERATED'){
            return $this->freshCaseRegistration($data);
        }else if($CheckStatus['result'] == 'GENERATED'){
            return $this->registeredCaseProcess($data, $CheckStatus['case_no']);
        }else{
            log_message("error", "#EKCOF031, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF031'];
        }
         
    }

    //method to chcek case number
    public function CheckCaseNumber($data){
        $query = $this->db->select('*')
                ->where('ld_application_no', $data['ld_application_no'])
                ->where('application_no', $data['application_no'])
                ->from('ekhajana_basic')
                ->get();
            if($query->num_rows() == 0 ){
                return ['result'=>'NOT-GENERATED', 'case_no' => ''];
            }else{
                $row = $query->row();
                return ['result'=>'GENERATED', 'case_no' => $row->case_no];
            }
    }

    //method to register a fresh case by lm in mouzadri systtem
    public function freshCaseRegistration($data){
        error_reporting(0);
        $pdar_father_name = null;
        if($data['pdar_father_name'] == null || $data['pdar_father_name'] == "")
        {
            $pdar_father_name = 'NA';
        }else{
            $pdar_father_name = $data['pdar_father_name'];
        }
        $this->db->trans_begin();
        $village_uuid = $this->getVillageUUID($data['dist_code'],$data['subdiv_code'],
        $data['cir_code'],$data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code']);
        $case_no_abbr = $this->generteCaseName();        
        //inserting basic details in ekhajana basic 
        $insertDataForEkhajanaBasic = [
            "application_no" => $data['application_no'],
            "ld_application_no" => $data['ld_application_no'],
            "dist_code" => $data['dist_code'],
            "subdiv_code" => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            "mouza_pargona_code" => $data['mouza_pargona_code'],
            "lot_no" => $data['lot_no'],
            "vill_townprt_code" => $data['vill_townprt_code'],
            "village_uuid" => $village_uuid,
            "is_urban" => $data['is_urban'],
            "patta_type_code" => $data['patta_type_code'],
            "patta_type" => $data['patta_type'],
            "patta_no" => $data['patta_no'],
            "pdar_id" => $data['pdar_id'], 
            "pdar_name" => $data['pdar_name'],
            "pdar_father_name" => $pdar_father_name,
            "applicant_name_eng" => $data['applicant_name_eng'],
            "applicant_name_asm" => $data['applicant_name_asm'],
            "guardian_name_eng" => $data['guardian_name_eng'],
            "guardian_name_asm" => $data['guardian_name_asm'],
            "guardian_relation" => $data['guardian_relation'],
            "gender" => $data['gender'],
            "date_of_birth" => $data['date_of_birth'],
            "address" => $data['address'],
            "mobile_no" => $data['mobile_no'],
            "pending_with_officer" => "MOUZADAR",
            "lm_remark" => $data['lm_report'],
            "status" => EKHAJANA_STATUS_LM_FORWARD_MOUZADARI_SYSTEM,
            "created_at" => date('Y-m-d h:i:s'),
            'user_code' => $this->session->all_userdata()['user_code'],
            'case_no' => "NOT-GENERATED",
            'aadhaar_pan_ref_no' => $data['aadhaar_pan_ref_no'],
            'aadhaar_pan_type' => $data['aadhaar_pan_type'],
            'lm_pattadar_identification_flag' => $data['pattadar_identified'],
            'pdar_mobile_no' => $data['ekh_mobile_no'],
        ];
        $tstatus1 = $this->db->insert('ekhajana_basic', $insertDataForEkhajanaBasic); 
        if ($tstatus1!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKBI00012, Error in insert on ekhajana_basic table with data ". json_encode($insertDataForEkhajanaBasic));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI00012'];
        }
        $ekhajana_basic_inserted_id = $this->db->insert_id();
        $case_no = $case_no_abbr."EKH/".$ekhajana_basic_inserted_id;
        //updating ekhajana basic details with case no 
        $update_data = array(
            'case_no' => $case_no,
        ); 
        $this->db->where('id', $ekhajana_basic_inserted_id);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKBI00022, Error in update, table 'ekhajana_basic' with rtps application no ".$data['ld_application_no']);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI00022'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['lm_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => EKHAJANA_STATUS_LM_FORWARD_MOUZADARI_SYSTEM
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKBI00033, Error in insert on ekhajana_basic_proceedings table with data ". json_encode($proceeding_details_data));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKBI00033'];
        }
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKLDI00066, Transaction Status Error In Saving Land Detasils");
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKLDI00066'];
        }else{
            //post api to basundhara
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_LM_FORAWRDED_API_MOUZADARI_SYSTEM,
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
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => $this->session->all_userdata()['user_code'],                    
                    'date_of_action' => date('Y-m-d h:i:s'),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['lm_report'],
                    'pending_with_officer' => 'MOUZADAR',
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
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwared To Co Successfully!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKCRLLMT00077, Curl Error(Y) In Api ".EKHAJANA_LM_FORAWRDED_API_MOUZADARI_SYSTEM);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCRLLMT00077'];
                } 
                curl_close($curl);
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKCRLLMT00088, Curl Error(200) In Api ".EKHAJANA_LM_FORAWRDED_API_MOUZADARI_SYSTEM);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCRLLMT00088'];
            }  
        }
    }

    //method to update a registed case by lm in mouzadri system
    public function registeredCaseProcess($data, $case_no){
        error_reporting(0);
        $this->db->trans_begin();
        //*************************************************/
        $status_query = $this->db->query("select * from ekhajana_basic where case_no =?",array($case_no));
        if($status_query->num_rows()==0)
        {
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUBD002546'];
        }else{
            $status = $status_query->row()->status;
        }
        if($status == 'MLM_F'){
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUBD0025875'];
        }else if($status == 'MOU_F'){
            $status = EKHAJANA_STATUS_COMBINE_FORWARD;
        }
        //*************************************************/

        //updating ekhajana basic table status
        $update_data = array(
            'pending_with_officer' => 'CO',
            'status' => $status,
            'lm_remark' => $data['lm_report'],
            'modified_at' => date('Y-m-d h:i:s'),
            'user_code' => $this->session->all_userdata()['user_code'],
            'lm_pattadar_identification_flag' => $data['pattadar_identified']
        ); 
        $this->db->where('ld_application_no', $data['ld_application_no']);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKCOF001, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF001'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['lm_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => $status
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        //return $this->db->last_query();
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOF002, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF002'];
        }
        //*********************************************************/
        //final transaction status check 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKCU0003, Transaction Status Error In Saving Land Details with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKCU0003'];
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_LM_FORAWRD_MOUZADARI_SYSTEM,
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
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => $this->session->all_userdata()['user_code'],                    
                    'date_of_action' => date("Y-m-d"),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['lm_report'],
                    'pending_with_officer' => 'CO',
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
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwared To CO Successfully!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKCORCRLD004, Curl Error(Y) In Api ".EKHAJANA_LM_FORAWRD_MOUZADARI_SYSTEM);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD004'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKCORCRLD005, Curl Error(200) In Api ".EKHAJANA_LM_FORAWRD_MOUZADARI_SYSTEM);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
            }
        }
    }

    //method to search additional documnt against the applicatin no
    public function searchAdditionalDocument($application_no, $ld_application_no)
    {
        $query = $this->db->select('*')
                        ->where('application_no', $application_no)
                        ->where('ld_application_no', $ld_application_no)
                        ->from('ekhajana_additional_document')
                        ->get(); 
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return "NOT-FOUND";
        }
    }

    // *******************************DP ESTATE CODE STARTS*****************************

    //inserting/updating dp estate cases into dharitree
    public function updateEkhajanaBasicDpEstate($data){
        $CheckStatus = $this->CheckCaseNumber($data);
        if($CheckStatus['result'] == 'NOT-GENERATED'){
            return $this->freshCaseRegistrationForDpEstate($data);
        }else if($CheckStatus['result'] == 'GENERATED'){
            return $this->registeredCaseProcessForDpEstate($data, $CheckStatus['case_no']);
        }else{
            log_message("error", "#EKHUEBDP001, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP001'];
        }
    }

    //inserting dp estate case to dharitree and generating the case number
    public function freshCaseRegistrationForDpEstate($data) 
    {
        $this->db->trans_begin();
        $village_uuid = $this->getVillageUUID($data['dist_code'],$data['subdiv_code'],
        $data['cir_code'],$data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code']);
        $case_no_abbr = $this->generteCaseName();        
        //inserting basic details in ekhajana basic 
        $insertDataForEkhajanaBasic = [
            "application_no" => $data['application_no'],
            "ld_application_no" => $data['ld_application_no'],
            "dist_code" => $data['dist_code'],
            "subdiv_code" => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            "mouza_pargona_code" => $data['mouza_pargona_code'],
            "lot_no" => $data['lot_no'],
            "vill_townprt_code" => $data['vill_townprt_code'],
            "village_uuid" => $village_uuid,
            "is_urban" => $data['is_urban'],
            "patta_type_code" => $data['patta_type_code'],
            "patta_type" => $data['patta_type'],
            "patta_no" => $data['patta_no'],
            "pdar_id" => $data['pdar_id'], 
            "pdar_name" => $data['pdar_name'],
            "pdar_father_name" => $data['pdar_father_name'],
            "applicant_name_eng" => $data['applicant_name_eng'],
            "applicant_name_asm" => $data['applicant_name_asm'],
            "guardian_name_eng" => $data['guardian_name_eng'],
            "guardian_name_asm" => $data['guardian_name_asm'],
            "guardian_relation" => $data['guardian_relation'],
            "gender" => $data['gender'],
            "date_of_birth" => $data['date_of_birth'],
            "address" => $data['address'],
            "mobile_no" => $data['mobile_no'],
            "pending_with_officer" => "MOUZADAR",
            "lm_remark" => $data['lm_report'],
            "status" => EKHAJANA_STATUS_LM_FORWARD_DP_ESTATE,
            "created_at" => date('Y-m-d h:i:s'),
            'user_code' => $this->session->all_userdata()['user_code'],
            'case_no' => "NOT-GENERATED",
            'aadhaar_pan_ref_no' => $data['aadhaar_pan_ref_no'],
            'aadhaar_pan_type' => $data['aadhaar_pan_type'],
        ];
        $tstatus1 = $this->db->insert('ekhajana_basic', $insertDataForEkhajanaBasic); 
        if ($tstatus1!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP002, Error in insert on ekhajana_basic table with data ". json_encode($insertDataForEkhajanaBasic));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP002'];
        }
        $ekhajana_basic_inserted_id = $this->db->insert_id();
        $case_no = $case_no_abbr."EKH/".$ekhajana_basic_inserted_id;
        //updating ekhajana basic details with case no 
        $update_data = array(
            'case_no' => $case_no,
        ); 
        $this->db->where('id', $ekhajana_basic_inserted_id);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP003, Error in update, table 'ekhajana_basic' with rtps application no ".$data['ld_application_no']);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP003'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['lm_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => EKHAJANA_STATUS_LM_FORWARD_DP_ESTATE
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP004, Error in insert on ekhajana_basic_proceedings table with data ". json_encode($proceeding_details_data));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP004'];
        }
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP005, Transaction Status Error In Saving Land Detasils");
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP005'];
        }else{
            //post api to basundhara
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_LM_FORAWRDED_API_DP_ESTATE_FIRST,
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
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => $this->session->all_userdata()['user_code'],                    
                    'date_of_action' => date('Y-m-d h:i:s'),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['lm_report'],
                    'pending_with_officer' => 'TN-BRANCH',
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwarded Successfully!!!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKHUEBDPCRLL006, Curl Error(Y) In Api ".EKHAJANA_LM_FORAWRDED_API_DP_ESTATE_FIRST);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDPCRLL006'];
                } 
                curl_close($curl);
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKHUEBDPCRLL007, Curl Error(200) In Api ".EKHAJANA_LM_FORAWRDED_API_DP_ESTATE_FIRST);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDPCRLL007'];
            }  
        }
    } 
    
    
    //updating a registered case in dharitree after tn forward
    public function registeredCaseProcessForDpEstate($data, $case_no){
        //*************************************************/
        $status_query = $this->db->query("select * from ekhajana_basic where case_no =?",array($case_no));
        if($status_query->num_rows()==0)
        {
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUBD002546'];
        }else{
            $status = $status_query->row()->status;
        }
        if($status == 'LM_DP'){
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUBD0025875'];
        }else if($status == 'CM_DP'){
            $status = EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE;
        }
        //*************************************************/
        $this->db->trans_begin();
        //updating ekhajana basic table status
        $update_data = array(
            'pending_with_officer'  => 'CO',
            'status'                => EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE,
            'lm_remark'             => $data['lm_report'],
            'modified_at'           => date('Y-m-d h:i:s'),
            'user_code'             => $this->session->all_userdata()['user_code'],
        ); 
        $this->db->where('ld_application_no', $data['ld_application_no']);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP008, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP008'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no'     => $data['ld_application_no'],
            'application_no'        => $data['application_no'],
            'remark'                => $data['lm_report'],            
            'user_code'             => $this->session->all_userdata()['user_code'],
            "created_at"            => date('Y-m-d h:i:s'),
            "case_no"               => $case_no,
            'status'                => EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP009, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDP009'];
        }
        //final transaction status check 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHUEBDP0010, Transaction Status Error In Saving Land Details with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKHUEBDP0010'];
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_LM_FORWARDED_API_DP_ESTATE_SECOND,
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
                    'ld_application_no'     => $data['ld_application_no'],
                    'application_no'        => $data['application_no'],
                    'dharitree_case_no'     => $case_no,
                    'user_code'             => $this->session->all_userdata()['user_code'],                    
                    'date_of_action'        => date("Y-m-d"),
                    "patta_no"              => $data['patta_no'],
                    'remark'                => $data['lm_report'],
                    'pending_with_officer'  => 'CO',
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwarded Successfully!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKHUEBDPCRLL0011, Curl Error(Y) In Api ".EKHAJANA_LM_FORWARDED_API_DP_ESTATE_SECOND);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDPCRLL0011'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKHUEBDPCRLL0012, Curl Error(200) In Api ".EKHAJANA_LM_FORWARDED_API_DP_ESTATE_SECOND);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHUEBDPCRLL0012'];
            }
        }
    }

    public function fetchArrearByMouzadar($dist_code,$subdiv_code,$cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no)
    {
        $query = $this->db->query("select * from ekhajana_arrear_pre_updation where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($dist_code,$subdiv_code,$cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no));
       
        if($query->num_rows() ==0){
            return "NO-DATA-FOUND";
        }elseif($query->num_rows() > 1){
            return "NO-DATA-FOUND";
        }else{
            $arrear = $query->row();
            return $arrear;
        }

    }

    public function getCurrentDoulDemand($dist_code,$subdiv_code,$cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no)
    {
        $query = $this->db->query("select * from current_doul_demand where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($dist_code,$subdiv_code,$cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no));
        if($query->num_rows() ==0){
            return "NO-DATA-FOUND";
        }else{
            $doul_demand = $query->row();
            return $doul_demand;
        }

    }


}