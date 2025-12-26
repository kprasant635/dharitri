<?php

class EkhajanaTnModel extends CI_Model {

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

    //getting village uuid
    function getVillageUUID($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code){    
        $this->dbswitch();        
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

    public function getLandDetailsFromId($ek_land_details_id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_PENDING_CASE_DETAILS_DP_ESTATE_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ld_details_id' =>$ek_land_details_id)
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            return ["flag"=>true, "result"=>$response_obj];            
        }else{
            log_message("error", "#EKCRLMOUCASE0001, Curl Error(200) In Api ".EKHAJANA_PENDING_CASE_DETAILS_DP_ESTATE_API);
            return ["flag"=>false, "result"=>"Some Error Occured, Error Code: #EKCRLMOUCASE0001"]; 
        }

    }

    //getting current revenue and local tax
    public function getCurrentRevenueAndLocalTaxFromDpDoul($land_details){
        $query = $this->db->select("*")
                            ->where('dist_code', $land_details['result']->land_details->dist_code)
                            ->where('subdiv_code', $land_details['result']->land_details->subdiv_code)
                            ->where('cir_code', $land_details['result']->land_details->cir_code)
                            ->where('mouza_pargona_code', $land_details['result']->land_details->mouza_pargona_code)
                            ->where('lot_no', $land_details['result']->land_details->lot_no)
                            ->where('vill_townprt_code', $land_details['result']->land_details->vill_townprt_code)
                            ->where('patta_type_code', $land_details['result']->land_details->patta_type_code)
                            ->where('patta_no', $land_details['result']->land_details->patta_no)
                            ->from('current_dp_doul_demand')
                            ->get(); 
        //echo $this->db->last_query();
        if($query->num_rows() != 0){
            $row = $query->row();
            if(($row->dag_revenue=='' || $row->dag_revenue==null) || ($row->dag_local_tax=='' || $row->dag_local_tax==null)){
                return ['flag' => false, 'result' => 'Revenue Or Local Tax Not Found in Doul For The Patta : '.$land_details['result']->land_details->patta_no. ", Please verify the patta no in current doul.!" ];
            }else{
                return ['flag' => true, 'result' => $row];
            }
            
        }else{
            return ['flag' => false, 'result' => 'Doul Entry Not Found For The Patta : '.$land_details['result']->land_details->patta_no. ", Please verify the patta no in current doul.!" ];
        }  
    }

    //inserting/updating dp estate cases into dharitree
    public function updateEkhajanaBasicDpEstate($data){
        $CheckStatus = $this->CheckCaseNumber($data);
        if($CheckStatus['result'] == 'NOT-GENERATED'){
            return $this->freshCaseRegistrationForDpEstate($data);
        }else if($CheckStatus['result'] == 'GENERATED'){
            return $this->registeredCaseProcessForDpEstate($data, $CheckStatus['case_no']);
        }else{
            log_message("error", "#EKUEBDPETN001, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN001'];
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

    //getting the case abbr
    function generteCaseName($dist_code,$subdiv_code,$cir_code){
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

    //inserting dp estate case to dharitree and generating the case number
    public function freshCaseRegistrationForDpEstate($data) 
    {
        $this->db->trans_begin();
        $village_uuid = $this->getVillageUUID($data['dist_code'],$data['subdiv_code'],
        $data['cir_code'],$data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code']);
        $case_no_abbr = $this->generteCaseName($data['dist_code'],$data['subdiv_code'],$data['cir_code']);        
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
            "pending_with_officer" => "LM",
            "tn_remark" => $data['tn_report'],
            "status" => EKHAJANA_STATUS_TN_FORWARD_DP_ESTATE,
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
            log_message("error", "#EKUEBDPETN002, Error in insert on ekhajana_basic table with data ". json_encode($insertDataForEkhajanaBasic));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN002'];
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
            log_message("error", "#EKUEBDPETN003, Error in update, table 'ekhajana_basic' with rtps application no ".$data['ld_application_no']);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN003'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['tn_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => EKHAJANA_STATUS_TN_FORWARD_DP_ESTATE
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUEBDPETN004, Error in insert on ekhajana_basic_proceedings table with data ". json_encode($proceeding_details_data));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN004'];
        }
        if($_POST['arrear_status'] != "jamawasil_updated"){
            //ekhjana_tn_branch_arrear_details table insert
            $insertArrearDetails = [
                "application_no" => $data['application_no'],
                "ld_application_no" => $data['ld_application_no'],
                "case_no" => $case_no,
                "dist_code" => $data['dist_code'],
                "subdiv_code" => $data['subdiv_code'],
                "cir_code" => $data['cir_code'],
                "mouza_pargona_code" => $data['mouza_pargona_code'],
                "lot_no" => $data['lot_no'],
                "vill_townprt_code" => $data['vill_townprt_code'],
                "village_uuid" => $village_uuid,
                "patta_type_code" => $data['patta_type_code'],
                "patta_no" => $data['patta_no'],
                "current_revenue" => $data['current_revenue'],
                "current_local_tax" => $data['current_local_tax'],
                "current_doul_year" => $data['current_doul_year'],
                "opening_balance" => $data['openinig_balance'],
                'last_pay_date' => $data['last_pay_date1'],
                "last_revenue_payment" => $data['last_revenue_payment_amount'],
                "last_local_tax_payment" => $data['last_local_tax_payment_amount'],
                "backup_arrear_json" => json_encode($data),
                "payment_by" => $data['paymentBy'],
                "created_at" =>date('Y-m-d h:i:s'),
                "surcharge" =>$data['surcharge']
            ];
            $tstatus3 = $this->db->insert('ekhajana_tn_branch_arrear_details', $insertArrearDetails);
            if ($tstatus3!= 1)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETN005, Error in insert on ekhajana_tn_branch_arrear_details table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN005'];
            }
        }else if($_POST['arrear_status'] == "tn_updated"){
            $tn_update_data = [
                "backup_arrear_json" => json_encode($data),
                "opening_balance" => $data['openinig_balance'],
                'last_pay_date' => $data['last_pay_date1'],
                "last_revenue_payment" => $data['last_revenue_payment_amount'],
                "last_local_tax_payment" => $data['last_local_tax_payment_amount'],
                "current_revenue" => $data['current_revenue'],
                "current_local_tax" => $data['current_local_tax'],
                "modified_at" => date('Y-m-d h:i:s'),
                "surcharge" =>$data['surcharge']
            ];

            $this->db->where('dist_code', $data['dist_code'])
                    ->where('subdiv_code', $data['subdiv_code'])
                    ->where('cir_code', $data['cir_code'])
                    ->where('mouza_pargona_code', $data['mouza_pargona_code'])
                    ->where('lot_no', $data['lot_no'])
                    ->where('patta_type_code', $data['patta_type_code'])
                    ->where('patta_no', $data['patta_no'])
                    ->where('vill_townprt_code', $data['vill_townprt_code'])
                    ->where('village_uuid', $data['village_uuid'])
                    ->update('ekhajana_tn_branch_arrear_details', $tn_update_data);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETN006, Error in update on ekhajana_tn_branch_arrear_details table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN006'];
            }
        }
        //transaction final check
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKUEBDPETN007, Transaction Status Error In Ekhajana Basic Details");
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN007'];
        }else{
            //post api to basundhara
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_FIRST,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => $this->session->all_userdata()['user_code'],                    
                    'date_of_action' => date('Y-m-d h:i:s'),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['tn_report'],
                    'pending_with_officer' => 'LM',
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwareded Successfully!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKUEBDPETN008, Curl Error(Y) In Api ".EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_FIRST);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN008'];
                } 
                curl_close($curl);
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETN009, Curl Error(200) In Api ".EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_FIRST);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETN009'];
            }  
        }
    } 
    
    //upadting case in dharitree after tn branch forwards a case where acse no is generated by lm
    public function registeredCaseProcessForDpEstate($data, $case_no){
        $village_uuid = $this->getVillageUUID($data['dist_code'],$data['subdiv_code'],
                                            $data['cir_code'],$data['mouza_pargona_code'],$data['lot_no'],$data['vill_townprt_code']);
        $this->db->trans_begin();
        //updating ekhajana basic table status
        $update_data = array(
            'pending_with_officer' => 'CO',
            'status' => EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE,
            'tn_remark' => $data['tn_report'],
            'modified_at' => date('Y-m-d h:i:s'),
            'user_code' => $this->session->all_userdata()['user_code'],
        ); 
        $this->db->where('ld_application_no', $data['ld_application_no']);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKUEBDPETNS001, Error in update, table 'ekhajana_basic'  with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS001'];
        }
        //ekhajana basic proceeding details insert
        $proceeding_details_data = array(
            'ld_application_no' => $data['ld_application_no'],
            'application_no' => $data['application_no'],
            'remark' => $data['tn_report'],            
            'user_code' => $this->session->all_userdata()['user_code'],
            "created_at" => date('Y-m-d h:i:s'),
            "case_no" => $case_no,
            'status' => EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE
        ); 
        $tstatus2 = $this->db->insert('ekhajana_basic_proceedings', $proceeding_details_data); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKUEBDPETNS002, Error in insert on ekhajana_basic_proceedings table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS002'];
        }
        //*********************************************************/
        if($_POST['arrear_status'] != "jamawasil_updated"){
            //ekhjana_tn_branch_arrear_details table insert
            $insertArrearDetails = [
                "application_no" => $data['application_no'],
                "ld_application_no" => $data['ld_application_no'],
                "case_no" => $case_no,
                "dist_code" => $data['dist_code'],
                "subdiv_code" => $data['subdiv_code'],
                "cir_code" => $data['cir_code'],
                "mouza_pargona_code" => $data['mouza_pargona_code'],
                "lot_no" => $data['lot_no'],
                "vill_townprt_code" => $data['vill_townprt_code'],
                "village_uuid" => $village_uuid,
                "patta_type_code" => $data['patta_type_code'],
                "patta_no" => $data['patta_no'],
                "current_revenue" => $data['current_revenue'],
                "current_local_tax" => $data['current_local_tax'],
                "current_doul_year" => $data['current_doul_year'],
                "opening_balance" => $data['openinig_balance'],
                'last_pay_date' => $data['last_pay_date1'],
                "last_revenue_payment" => $data['last_revenue_payment_amount'],
                "last_local_tax_payment" => $data['last_local_tax_payment_amount'],
                "backup_arrear_json" => json_encode($data),
                "payment_by" => $data['paymentBy'],
                "created_at" =>date('Y-m-d h:i:s'),
                "surcharge" =>$data['surcharge']
            ];
            $tstatus3 = $this->db->insert('ekhajana_tn_branch_arrear_details', $insertArrearDetails);
            if ($tstatus3!= 1)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETNS003, Error in insert on ekhajana_tn_branch_arrear_details table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS003'];
            }
        }else if($_POST['arrear_status'] == "tn_updated"){
            $mad_update_data = [
                "backup_arrear_json" => json_encode($data),
                "opening_balance" => $data['openinig_balance'],
                'last_pay_date' => $data['last_pay_date1'],
                "last_revenue_payment" => $data['last_revenue_payment_amount'],
                "last_local_tax_payment" => $data['last_local_tax_payment_amount'],
                "current_revenue" => $data['current_revenue'],
                "current_local_tax" => $data['current_local_tax'],
                "modified_at" => date('Y-m-d h:i:s'),
                "surcharge" =>$data['surcharge'],
            ];
            $this->db->where('dist_code', $data['dist_code'])
                    ->where('subdiv_code', $data['subdiv_code'])
                    ->where('cir_code', $data['cir_code'])
                    ->where('mouza_pargona_code', $data['mouza_pargona_code'])
                    ->where('lot_no', $data['lot_no'])
                    ->where('patta_type_code', $data['patta_type_code'])
                    ->where('patta_no', $data['patta_no'])
                    ->where('vill_townprt_code', $data['vill_townprt_code'])
                    ->where('village_uuid', $data['village_uuid'])
                    ->update('ekhajana_tn_branch_arrear_details', $mad_update_data);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETNS004, Error in update on ekhajana_tn_branch_arrear_details table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS004'];
            }
        }
        //final transaction status check 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKUEBDPETNS005, Transaction Status Error In Saving Land Details with query- ". json_encode($this->db->last_query()));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS005'];
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_SECOND,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'ld_application_no' => $data['ld_application_no'],
                    'application_no' => $data['application_no'],
                    'dharitree_case_no' => $case_no,
                    'user_code' => $this->session->all_userdata()['user_code'],                    
                    'date_of_action' => date("Y-m-d"),
                    "patta_no" => $data['patta_no'],
                    'remark' => $data['tn_report'],
                    'pending_with_officer' => 'CO',
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Ekhajana Case Details Forwared Successfully!'];                 
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKUEBDPETNS006, Curl Error(Y) In Api ".EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_SECOND);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS006'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKUEBDPETNS007, Curl Error(200) In Api ".EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_SECOND);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUEBDPETNS007'];
            }
        }
    }

    //method to check whether arrear is upated in jama wasil
    public function checkArrearStatus($land_details){
        //checking whether jamawasil updated 
        $query = $this->db->select('*')
                          ->where('dist_code', $land_details->dist_code)
                          ->where('cir_code', $land_details->cir_code)
                          ->where('subdiv_code', $land_details->subdiv_code)
                          ->where('mouza_pargona_code', $land_details->mouza_pargona_code)
                          ->where('lot_no', $land_details->lot_no)
                          ->where('vill_townprt_code', $land_details->vill_townprt_code)
                          ->where('patta_type_code', $land_details->patta_type_code)
                          ->where('patta_no', $land_details->patta_no)
                          ->from('jama_wasil')
                          ->get();
        if($query->num_rows() != 0){
            $jama_wasil_details = $query->row();
            return [ "flag"=>"jamawasil_updated", "arrear_details" => $jama_wasil_details];
        }
        //checking whether tn branch arrear updated 
        $query = $this->db->select('*')
                          ->where('dist_code', $land_details->dist_code)
                          ->where('cir_code', $land_details->cir_code)
                          ->where('subdiv_code', $land_details->subdiv_code)
                          ->where('mouza_pargona_code', $land_details->mouza_pargona_code)
                          ->where('lot_no', $land_details->lot_no)
                          ->where('vill_townprt_code', $land_details->vill_townprt_code)
                          ->where('patta_type_code', $land_details->patta_type_code)
                          ->where('patta_no', $land_details->patta_no)
                          ->from('ekhajana_tn_branch_arrear_details')
                          ->get();
        if($query->num_rows() != 0){
            $tn_branch_arrear_details = $query->row();
            return [ "flag"=>"tn_updated", "arrear_details" => $tn_branch_arrear_details];
        }else{
            return [ "flag"=>"arrear_not_updated", "arrear_details" => []];
        }
    }

    public function getAllSubDivName($dist_code)
    {
        $this->dbswitch();
        $query = $this->db->query("select dist_code,subdiv_code,locname_eng,loc_name from location where dist_code=? and subdiv_code!=? and cir_code=?",array($dist_code,'00','00'))->result();
        return $query;
    }

    public function getAllCircleName($dist_code,$subdiv_code)
    {
        $this->dbswitch();
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code!=? and mouza_pargona_code =?",array($dist_code,$subdiv_code,'00','00'))->result();
        return $query;
    }

    public function getAllMouzaName($dist_code,$subdiv_code,$cir_code)
    {
        $this->dbswitch();
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?",array($dist_code,$subdiv_code,$cir_code,'00','00'))->result();
        return $query;
    }

    public function getAllLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code)
    {
        $this->dbswitch();
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no!=? and vill_townprt_code =?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,'00','00000'))->result();
        log_message("error","**************#######################".$this->db->last_query());
        return $query;
    }

    public function getAllVillagesName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no)
    {
        $this->dbswitch();
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code !=?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,'00000'))->result();
        return $query;
    }

    //patta type selection 
    public function getPattaType(){
        $this->dbswitch();
        $query = $this->db->query("Select type_code,patta_type,pattatype_eng from patta_code order by type_code asc")->result();       
        return $query; 
    }

    //selecting patta no
    public function getPattaNo($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code){
        $this->dbswitch();
        // $query = $this->db->query("select distinct (patta_no) from chitha_basic where dist_code=? and subdiv_code= ? and cir_code =? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? order by patta_no asc",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code))->result();       
        $query = $this->db->query("select distinct (cb.patta_no) from chitha_basic cb join jama_dag jd on cb.dist_code=jd.dist_code and cb.subdiv_code=jd.subdiv_code and cb.cir_code=jd.cir_code and cb.mouza_pargona_code = jd.mouza_pargona_code
        and cb.lot_no = jd.lot_no and cb.vill_townprt_code = jd.vill_townprt_code and cb.patta_type_code =jd.patta_type_code and cb.patta_no=jd.patta_no where cb.dist_code=? and cb.subdiv_code= ? and cb.cir_code =? and cb.mouza_pargona_code=? 
        and cb.lot_no=? and cb.vill_townprt_code=? and cb.patta_type_code=? and cb.dp_flag_yn='Y' and jd.dp_flag_yn='Y' order by cb.patta_no asc",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code))->result();
        log_message("error","*************************************".$this->db->last_query());       
        return $query; 
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
                            ->from('ekhajana_arrear_pre_updation_dp_estate')
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
            "surcharge"             => $posted_data['total_surcharge'],
            // "miran"                 => $posted_data['total_miran'],
            "status"                => EKHAJANA_AREEAR_PRE_UPDATED,
            "created_at"            => date('Y-m-d h:i:s'),
            "modified_at"           => null,
            'user_code'             => $this->session->all_userdata()['user_code'],
            'doul_year_no'          => $doul_year,
            'previous_arrears'      => json_encode($posted_data),
                
        ];
        $this->dbswitch();
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert('ekhajana_arrear_pre_updation_dp_estate', $insertPreArrearData);
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

            $year_surcharge = $row['surcharge'];
            if($year_surcharge == null){
                $year_surcharge =0;
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
                'total_surcharge'       => $posted_data['total_surcharge'],
                // 'total_miran'           => $posted_data['total_miran'],
                'user_code'             => $this->session->all_userdata()['user_code'],
                'financial_year'        => $row['year'],
                'year_arrear'           =>  $year_arrear,
                'year_revenue'          =>  $year_revenue,
                'year_tax'              =>  $year_tax,
                'year_surcharge'        =>  $year_surcharge,
                // 'year_miran'            =>  $year_miran,
                "created_at"            => date('Y-m-d h:i:s'),
                'modified_at'           => null,
                "status"                => EKHAJANA_AREEAR_PRE_UPDATED,
                "revenue_year"          => substr($row['year'],5),
            );
            $tstatus3 = $this->db->insert('ekhajana_year_wise_arrear_dp_estate', $year_wise_arrear);
            if ($tstatus3 <= 0)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKHIPAD002, Error in insert on ekhajana_year_wise_arrear table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD002'];
            }
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#EKHIPAD003, Transaction failure occured the last query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD003'];
        }
        else
        {
            $this->db->trans_commit();
            
            return ['result' => 'SUCCESS', 'msg' => 'Arrear Data Inserted Successfully'];  
        }
    }

    public function getTotalArrear($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no){
        $arrear_update_query = $this->db->query('select arrear from ekhajana_arrear_pre_updation_dp_estate where 
                                        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                                        and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?',
                                        array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no));
        $arrear_update_count = $arrear_update_query->num_rows();
        if($arrear_update_count != 1){
            return 'NOT-FOUND';
        }else{
            return $arrear_update_query->row()->arrear;
        }
    }

    public function getPreUpdatedList($dist_code)
    {
        $query = $this->db->query("select * from ekhajana_arrear_pre_updation_dp_estate where
                     dist_code=?",array($dist_code));
    
        if($query->num_rows() != 0){
            $pre_arrear_details =  $query->result(); 
        }else{
            $pre_arrear_details =  []; 
        }
        return $pre_arrear_details;
    }

    public function getYearWiseArrear($pre_arrear_id)
    {
        $query = $this->db->query("select * from ekhajana_year_wise_arrear_dp_estate where pre_arrear_id =? order by financial_year asc",array($pre_arrear_id));
        if($query->num_rows() == 0)
        {
            return ['flag' =>'N', 'msg' => []];
        }else{
            return ['flag' =>'Y', 'msg' => $query->result()];
        }
    }

    public function getPreUpdatedListForEdit($dist_code)
    {   $query = $this->db->query("select id as pre_id,* from ekhajana_arrear_pre_updation_dp_estate where dist_code=? ",array($dist_code));
        // $query = $this->db->query("select eap.id as pre_id,* from ekhajana_year_wise_arrear_dp_estate eap join jama_wasil jw on eap.dist_code=jw.dist_code and eap.subdiv_code=jw.subdiv_code
        // and eap.cir_code=jw.cir_code and eap.mouza_pargona_code=jw.mouza_pargona_code and eap.lot_no=jw.lot_no and eap.vill_townprt_code=jw.vill_townprt_code
        // and eap.patta_type_code=jw.patta_type_code and eap.patta_no= jw.patta_no where eap.dist_code=?
        // and jw.pay_status=?",
        // array($dist_code,'UNPAID'));
      if($query->num_rows() != 0){
         $pre_arrear_details =  $query->result(); 
      }else{
         $pre_arrear_details =  []; 
      }
      return $pre_arrear_details;
    }

    public function insertArrearTransactiondata($pre_arrear_id)
    {
      $pre_arrear_updation_row = $this->db->query("select * from ekhajana_arrear_pre_updation_dp_estate where id=? ",array($pre_arrear_id))->result();
      $year_wise_arrear_data = $this->db->query("select * from ekhajana_year_wise_arrear_dp_estate where pre_arrear_id =? order by id asc", array($pre_arrear_id))->result();
      
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
      $total_surcharge     = $pre_arrear_updation_row[0]->surcharge;
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
         "total_surcharge"       => $total_surcharge,
         "user_code"             => $user_code,
         'status'                => $status,
         "created_at"            => date('Y-m-d h:i:s'),
         "modified_at"           => null,
         "arrear_pre_json"       => json_encode($pre_arrear_updation_row),
         "year_wise_arrear_json" => json_encode($year_wise_arrear_data),
      ];
      $tstatus3 = $this->db->insert('ekhajana_arrear_pre_updation_dp_estate_transactions', $insertTransactionData); 
      if ($tstatus3!= 1)
      {
            $this->db->trans_rollback();
            log_message("error", "#EKAPRT001, Error in insert on ekhajana_arrear_pre_updation_dp_estate_transactions table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT001'];
      }else{
            return ['result' => 'SUCCESS', 'msg' => 'DATA INSERTED SUCCESSFULLY']; 
      }
    }

    public function updatePreArrearUpdation($pre_arrear_id,$update_array,$previous_arrears)
    { 

        $year_wise_arrear_with_priorF_query = $this->db->query("select * from ekhajana_year_wise_arrear_dp_estate where pre_arrear_id=?
        and financial_year=?",array($pre_arrear_id, '0000-2000'));
        if($year_wise_arrear_with_priorF_query->num_rows() == 0){
            $prior2000Flag = true;
        }else{
            $prior2000Flag = false;
        }
        $pre_arrear_updation_row = $this->db->query("select * from ekhajana_arrear_pre_updation_dp_estate where id=? ",array($pre_arrear_id))->result();

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
                'total_surcharge'    => $update_array[0]['total_surcharge'],
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
            $tstatus3 = $this->db->insert('ekhajana_year_wise_arrear_dp_estate', $year_wise_arrear);
            if ($tstatus3 <= 0)
            {
                $this->db->trans_rollback();
                log_message("error", "#EKHIPAD002, Error in insert on ekhajana_year_wise_arrear_dp_estate table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHIPAD002'];
            }
        }
      
        //updating ekhajana pre updation table 
        $update_data = array(
            'arrear'             => $update_array[0]['total_arrear'],
            'revenue'            => $update_array[0]['total_revenue'],
            'tax'                => $update_array[0]['total_tax'],
            'surcharge'          => $update_array[0]['total_surcharge'],
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
                ->update('ekhajana_arrear_pre_updation_dp_estate', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKAPRT002, Error in update, table 'ekhajana_arrear_pre_updation_dp_estate' with query ".json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT002'];
        }

        foreach($update_array as $update_row)
        {

            $update_data_year_wise = array(
                'total_arrear'       => $update_row['total_arrear'],
                'total_revenue'      => $update_row['total_revenue'],
                'total_tax'          => $update_row['total_tax'],
                'total_surcharge'    => $update_row['total_surcharge'],
                'year_arrear'        => $update_row['arrear'],
                'year_revenue'       => $update_row['revenue'],
                'year_surcharge'     => $update_row['surcharge'],
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
                    ->update('ekhajana_year_wise_arrear_dp_estate', $update_data_year_wise);
            if($this->db->affected_rows() != 1){ 
                $this->db->trans_rollback();
                log_message("error", "#EKAPRT003, Error in update on ekhajana_year_wise_arrear_dp_estate table with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKAPRT003'];
            }
        }
         
        return ['result' => 'SUCCESS', 'msg' => 'DATA UPDATED SUCCESSFULLY'];   
         
    }


    public function checkSurcharge($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
    {
        $surcharge_value =  null;
        $surcharge_brkdown = null;
        $surcharge = $this->db->query('select surcharge from ekhajana_arrear_pre_updation_dp_estate where 
                dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?',
                array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no))->row();
        if($surcharge->surcharge == null || $surcharge->surcharge == "")
        {
            $surcharge_value = "NOT-FOUND";
        }else{
            $surcharge_value = $surcharge->surcharge;
        }

        

        $surcharge_brkdown = $this->db->query('select year_surcharge from ekhajana_year_wise_arrear_dp_estate where 
                dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?',
                array($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no))->result();

        foreach($surcharge_brkdown as $row)
        {
            if($row->year_surcharge == null){
                $surcharge_brkdown = "NOT-FOUND";
                break;
            }
        }



        if($surcharge_value == "NOT-FOUND" || $surcharge_brkdown == "NOT-FOUND"){
            return "SURCHARGE-NOT-FOUND";
        }else{
            return $surcharge_value;
        }

    }


    public function get2025ArchiveDouldata($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
    {
            $query = $this->db->query("select * from current_dp_doul_demand_2025 where dist_code=? and subdiv_code=? and cir_code=?
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
?>