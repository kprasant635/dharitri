<?php

class EkhajanaUpdateModel extends CI_Model {

    public function updateBasundharaPaymenttoNull($data)
    {

        $this->db->trans_begin();
        
        $update_data = array(
            'manual_flag' =>'1',
        ); 
        $this->db->where('ld_application_no', $data->ld_application_no);
        $this->db->update('ekhajana_basic', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKCORD001, Error in update, table 'ekhajana_basic ' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD001'];
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => EKHAJANA_UPDATE_MANUAL_CASES,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'ld_application_no' => $data->ld_application_no,
                    'application_no' => $data->application_no,
                    'query' => $data->query,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'Case Updated Successfully!'];                   
                }else{
                    $this->db->trans_rollback();
                    log_message("error", "#EKCORCRLD004, Curl Error(Y) In Api ".EKHAJANA_UPDATE_MANUAL_CASES);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD004'];
                } 
            }else{
                $this->db->trans_rollback();
                log_message("error", "#EKCORCRLD005, Curl Error(200) In Api ".EKHAJANA_UPDATE_MANUAL_CASES);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
            } 
        }
            
    }

    //method to update revenue and local tax in jama wasil from currnt doul
    // public function updateDharitreeJamawasilandDoulMismatched($data)
    // {
    //     $this->db->trans_begin();

    //     $update_data = array(
    //         'manual_flag' => '1',
    //     ); 
        
    //     $this->db->where('ld_application_no', $data->ld_application_no);
    //     $this->db->update('ekhajana_basic', $update_data);
       
    //     $affected_rows =$this->db->affected_rows();
    //     log_message("error", "*******************". $this->db->last_query());
    //     if($affected_rows != 1){ 
    //         $this->db->trans_rollback();
    //         log_message("error", "#EKCORD001, Error in update, table 'ekhajana_basic ' with query- ". json_encode($this->db->last_query()));
    //         return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD001'];
    //     }
    //     else
    //     {
    //         $case = $data->ld_application_no;
            
    //         $queryForPatta = $this->db->query("SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,vill_townprt_code,patta_type_code,patta_no FROM ekhajana_basic WHERE trim(ld_application_no) in ('$case')");
            
    //         $location_details = $queryForPatta->result_array();
            
    //         $dist_code = $location_details[0]['dist_code'];
    //         $subdiv_code = $location_details[0]['subdiv_code'];
    //         $cir_code = $location_details[0]['cir_code'];
    //         $mouza_pargona_code = $location_details[0]['mouza_pargona_code'];
    //         $lot_no = $location_details[0]['lot_no'];
    //         $vill_townprt_code = $location_details[0]['vill_townprt_code'];
    //         $patta_type_code = $location_details[0]['patta_type_code'];
    //         $patta_no = $location_details[0]['patta_no'];
        
    //         $revenue = $this->getDagRevenueFromDoulDemand($dist_code,$subdiv_code,$cir_code,
    //                     $mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);

    //         log_message("error", "*******************REVENUE************". $revenue);

    //         $local_tax = $this->getDagLocalTaxFromDoulDemand($dist_code,$subdiv_code,$cir_code,
    //                     $mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);

    //         log_message("error", "*******************LOCAL-TAX************". $local_tax);

    //         $opening_balance = $this->getOpeningBalanceFromJamaWasil($dist_code,$subdiv_code,$cir_code,
    //                     $mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no);

    //         log_message("error", "*******************OPENNING BALANCE*********for location".$dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.
    //                     $mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code.'_'.$patta_type_code.'_'.$patta_no."***===>>>>". $opening_balance);
             
    //         if ($revenue == null || $local_tax == null)
    //         {
    //             $updateData =array(
    //                 'revenue' =>0,
    //                 'local_tax' =>0,
    //                 'is_deleted' => '1'
    //             );
    //         }
    //         else
    //         {
    //             $updateData =array(
    //                 'revenue'   =>    $revenue,
    //                 'local_tax' =>  $local_tax,
    //                 'is_deleted'=>  '0',
    //                 'due_payment'=> $revenue + $local_tax + $opening_balance,
                    
    //             );

    //         }
    //         $due_payment = $revenue + $local_tax + $opening_balance;

    //         $this->db->where('dist_code', $dist_code);
    //         $this->db->where('subdiv_code', $subdiv_code);
    //         $this->db->where('cir_code', $cir_code);
    //         $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    //         $this->db->where('lot_no', $lot_no);
    //         $this->db->where('vill_townprt_code', $vill_townprt_code);
    //         $this->db->where('patta_type_code', $patta_type_code);
    //         $this->db->where('patta_no', $patta_no);
    //         $this->db->update('jama_wasil', $updateData);
    //         log_message('error','updating jama wasil for the location:'.$dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code.'_'.$patta_type_code.'_'.$patta_no);
            
    //         $affected_rows1 = $this->db->affected_rows();
    //         if($affected_rows1 <= 0){ 
    //             $this->db->trans_rollback();
    //             log_message("error", "#EKHMJWCDD002, Error in update, table 'jama_wasil' with query ".$this->db->last_query());
    //             return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
    //         }

    //         //*******************************update jama wasil transaction//

    //         if ($revenue == null || $local_tax == null)
    //         {
    //             $updateDataTrans =array(
    //                 'revenue' =>0,
    //                 'local_tax' =>0,
    //                 'is_deleted' => '1'
    //             );
    //         }
    //         else
    //         {
    //             $updateDataTrans =array(
    //                 'revenue' =>$revenue,
    //                 'local_tax' =>$local_tax,
    //                 'is_deleted' => '0',
    //                 'due_payment' => $revenue + $local_tax + $opening_balance
    //             );

    //         }
    //         $this->db->where('dist_code', $dist_code);
    //         $this->db->where('subdiv_code', $subdiv_code);
    //         $this->db->where('cir_code', $cir_code);
    //         $this->db->where('mouza_pargona_code', $mouza_pargona_code);
    //         $this->db->where('lot_no', $lot_no);
    //         $this->db->where('vill_townprt_code', $vill_townprt_code);
    //         $this->db->where('patta_type_code', $patta_type_code);
    //         $this->db->where('patta_no', $patta_no);
    //         $this->db->where('dol_year_no', '2024');
    //         $this->db->update('jama_wasil_transaction', $updateDataTrans);
    //         log_message('error','updating jama_wasil_transaction for the location:'.$dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code.'_'.$patta_type_code.'_'.$patta_no);
    //         $affected_rows2 = $this->db->affected_rows();
    //         if($affected_rows2 <= 0){ 
    //             $this->db->trans_rollback();
    //             log_message("error", "#EKHMJWCDD002, Error in update, table 'jama_wasil_transaction' with query ".$this->db->last_query());
    //             return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
    //         }
    //         //final transaction status
    //         if($this->db->trans_status()==FALSE){
    //             $this->db->trans_rollback();
    //             log_message("error", "#EKCORD002, Transaction Status Error In Saving Land Details with query- ". json_encode($this->db->last_query()));
    //             return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORD002'];
    //         }else{
    //             $curl = curl_init();
    //             curl_setopt_array($curl, array(
    //                 CURLOPT_URL => EKHAJANA_JAMA_WASIL_CURRENT_DOUL_MISMATCHED,
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_ENCODING => '',
    //                 CURLOPT_MAXREDIRS => 10,
    //                 CURLOPT_TIMEOUT => 0,
    //                 CURLOPT_FOLLOWLOCATION => true,
    //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                 CURLOPT_CUSTOMREQUEST => 'POST',
    //                 CURLOPT_POSTFIELDS => array(
    //                     'ld_application_no' => $data->ld_application_no,
    //                     'application_no' => $data->application_no,
    //                     'due_payment' => $due_payment,
    //                 ),
    //             ));
    //             $response = curl_exec($curl);
    //             $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //             curl_close($curl);
    //             if($httpcode == 200){
    //                 //return "curl successfull";
    //                 $response_obj = json_decode($response);
    //                 if($response_obj->result == "Y"){
    //                     $this->db->trans_commit();
    //                     return ['result' => 'SUCCESS', 'msg' => 'Case UPDATED Successfully!'];                   
    //                 }else{
    //                     $this->db->trans_rollback();
    //                     log_message("error", "#EKCORCRLD004, Curl Error(Y) In Api ".EKHAJANA_JAMA_WASIL_CURRENT_DOUL_MISMATCHED);
    //                     return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD004'];
    //                 } 
    //             }else{
    //                 $this->db->trans_rollback();
    //                 log_message("error", "#EKCORCRLD005, Curl Error(200) In Api ".EKHAJANA_JAMA_WASIL_CURRENT_DOUL_MISMATCHED);
    //                 return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCORCRLD005'];
    //             }  
    //         }
    //     }
         
    // }

    //getting dag revenue from current doul
    // public function getDagRevenueFromDoulDemand($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no){
    //     $query = $this->db->select('*')
    //                 ->where('dist_code', $dist_code)
    //                 ->where('subdiv_code', $subdiv_code)
    //                 ->where('cir_code', $cir_code)
    //                 ->where('mouza_pargona_code', $mouza_pargona_code)
    //                 ->where('lot_no', $lot_no)
    //                 ->where('vill_townprt_code', $vill_townprt_code)
    //                 ->where('patta_type_code', $patta_type_code)
    //                 ->where('patta_no', $patta_no)
    //                 ->where('year_no','2024')
    //                 ->from('current_doul_demand')
    //                 ->get(); 
    //         if($query->num_rows() != 0 ){
    //             return $query->row()->dag_revenue;
    //         }else{
    //             return null;
    //         }
    // }

    //getting dag local tax from current doul
    // public function getDagLocalTaxFromDoulDemand($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no){
    //     $query = $this->db->select('*')
    //                     ->where('dist_code', $dist_code)
    //                     ->where('subdiv_code', $subdiv_code)
    //                     ->where('cir_code', $cir_code)
    //                     ->where('mouza_pargona_code', $mouza_pargona_code)
    //                     ->where('lot_no', $lot_no)
    //                     ->where('vill_townprt_code', $vill_townprt_code)
    //                     ->where('patta_type_code', $patta_type_code)
    //                     ->where('patta_no', $patta_no)
    //                     ->where('year_no','2024')
    //                     ->from('current_doul_demand')
    //                     ->get();   
    //             if($query->num_rows() != 0 ){
    //                 return $query->row()->dag_local_tax;
    //             }else{
    //                 return null;
    //             }
    // }

    //getting openning balance from jama wasil
    // public function getOpeningBalanceFromJamaWasil($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no){
    //     $query = $this->db->select('*')
    //                     ->where('dist_code', $dist_code)
    //                     ->where('subdiv_code', $subdiv_code)
    //                     ->where('cir_code', $cir_code)
    //                     ->where('mouza_pargona_code', $mouza_pargona_code)
    //                     ->where('lot_no', $lot_no)
    //                     ->where('vill_townprt_code', $vill_townprt_code)
    //                     ->where('patta_type_code', $patta_type_code)
    //                     ->where('patta_no', $patta_no)
    //                     ->where('dol_year_no','2024')
    //                     ->from('jama_wasil')
    //                     ->get();   
    //             if($query->num_rows() != 0 ){
    //                 return $query->row()->opening_balance;
    //             }else{
    //                 return null;
    //             }
    // }

    //method to update cases of basundhara where egras data is inserted as P
    // public function updateBasundharaEgrasPendingEntries($data)
    // {
    //     $this->db->trans_begin();
    //     $update_data = array(
    //         'manual_flag' =>'1',
    //     ); 
    //     $this->db->where('application_no', $data->application_no);
    //     $this->db->update('ekhajana_basic', $update_data);
    //     if($this->db->affected_rows() != 1){ 
    //         $this->db->trans_rollback();
    //         log_message("error", "#EKUBEGPC001, Error in update, table 'ekhajana_basic ' with query- ". json_encode($this->db->last_query()));
    //         return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUBEGPC001'];
    //     }else{
    //         $curl = curl_init();
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => EKHAJANA_UPDATE_EGRAS_PENDING_CASES,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => array(
    //                 'ld_application_no' => $data->ld_application_no,
    //                 'application_no' => $data->application_no,
    //                 'query' => $data->query,
    //             ),
    //         ));
    //         $response = curl_exec($curl);
    //         $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //         curl_close($curl);
    //         if($httpcode == 200){
    //             $response_obj = json_decode($response);
    //             if($response_obj->result == "Y"){
    //                 $this->db->trans_commit();
    //                 return ['result' => 'SUCCESS', 'msg' => 'Payment Updated Successfully!'];                   
    //             }else{
    //                 $this->db->trans_rollback();
    //                 log_message("error", "#EKUBEGPCCRLL001, Curl Error(Y) In Api ".EKHAJANA_UPDATE_EGRAS_PENDING_CASES);
    //                 return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUBEGPCCRLL001'];
    //             } 
    //         }else{
    //             $this->db->trans_rollback();
    //             log_message("error", "#EKUBEGPCCRLL002, Curl Error(200) In Api ".EKHAJANA_UPDATE_EGRAS_PENDING_CASES);
    //             return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKUBEGPCCRLL002'];
    //         } 
    //     }
    // }

}
?>