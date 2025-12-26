<?php
class FindCasesModel extends CI_Model {

    public function getApplicationDetails($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => GET_APPLICATION_DETAILS_FROM_BASUNDHARA,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ["flag"=>true, "result"=>$response_obj];            
        }else{
            log_message("error", "#FCBASUNDHARA0001, Curl Error(200) In Api ".GET_APPLICATION_DETAILS_FROM_BASUNDHARA);
            return ["flag"=>false, "result"=>"Some Error Occured, Error Code: #FCBASUNDHARA0001"]; 
        }
    }

    //curl to fetch and update initial payment status of ref no
    public function updateBasundharaInitialPayment($rtps_ref_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => FETCH_INITIAL_PAYMENT_IN_BASUNDHARA,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'rtps_ref_no' => $rtps_ref_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "Y"){
                    return ['result' => 'SUCCESS', 'msg' => 'Payment Status Updated Successfully!'];                   
                }else{
                    log_message("error", "#FCBASUNDHARA0002, Curl Error(Y) In Api ".FETCH_INITIAL_PAYMENT_IN_BASUNDHARA);
                    return ['result' => 'SERVER-ERROR', 'msg' => ''.$response_obj->msg.' : #FCBASUNDHARA0002'];
                } 
            }else{
                log_message("error", "#FCBASUNDHARA0003, Curl Error(200) In Api ".FETCH_INITIAL_PAYMENT_IN_BASUNDHARA);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Could Not Fetch data for the ref no' .$rtps_ref_no .': #FCBASUNDHARA0003'];
            }  
    }

    //method to get application details of basundhara one services
    public function getApplicationDetailsforBasundhara1Services($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => GET_APPLICATION_DETAILS_FOR_BASUNDHARA_ONE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ["flag"=>true, "result"=>$response_obj];            
        }else{
            log_message("error", "#FCBASUNDHARA0001, Curl Error(200) In Api ".GET_APPLICATION_DETAILS_FOR_BASUNDHARA_ONE);
            return ["flag"=>false, "result"=>"Some Error Occured, Error Code: #FCBASUNDHARA0001"]; 
        }    
    }

    //get service name by service code
    public function getBasundharaOneServiceName($scode)
    {
        if($scode == "6") {
            return 'NAME CORRECTION';
        }
        if($scode == '7') {
            return "AREA CORRECTION";
        }
        if($scode == '10') {
            return "LAND ALLOTMENT";
        }
        if($scode == '5') {
            return "STRIKING OUT NAME";
        }
        if($scode == '12') {
            return "TRACEMAP";
        }
        if($scode == '9') {
            return "AP TO PP CONVERSION";
        }
        if($scode == '3') {
            return "CONSENSUS PARTITION";
        }
        if($scode == '4') {
            return "RECLASSIFICATION";
        }
        if($scode == '11') {
            return "JAMABANDI(ROR)";
        }
        if($scode == '1') {
            return "MUTATION BY INHERITANCE";
        }
        if($scode == "2") {
            return "MUTATION BY DEED";
        }else{
            return "NOT FOUND";
        }
    }

    //curl to fetch and update initial payment status of ref no
    public function updateBasundharaOneInitialPayment($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => FETCH_INITIAL_PAYMENT_FOR_BASUNDHARA_ONE_SERVICES,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                return ['result' => 'SUCCESS', 'msg' => 'Payment Status Updated Successfully!'];                   
            }else{
                log_message("error", "#FCBASUNDHARA0002, Curl Error(Y) In Api ".FETCH_INITIAL_PAYMENT_FOR_BASUNDHARA_ONE_SERVICES);
                return ['result' => 'SERVER-ERROR', 'msg' => ''.$response_obj->msg.' : #FCBASUNDHARA0002'];
            } 
        }else{
            log_message("error", "#FCBASUNDHARA0003, Curl Error(200) In Api ".FETCH_INITIAL_PAYMENT_FOR_BASUNDHARA_ONE_SERVICES);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Could Not Fetch data for the application_no' .$application_no .': #FCBASUNDHARA0003'];
        }  
    }

    //method to get the auto updated data of the ekhajana applications
    public function getUpdatedData($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => GET_UPADTED_INITIAL_PAYMENT_STATUS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y" || $response_obj->result == "N"){
                return ['result' => 'SUCCESS', 'msg' => $response_obj];                   
            }else{
                log_message("error", "#FCBASUNDHARA0002, Curl Error(Y) In Api ".GET_UPADTED_INITIAL_PAYMENT_STATUS);
                return ['result' => 'SERVER-ERROR', 'msg' => $response_obj];
            } 
        }else{
            log_message("error", "#FCBASUNDHARA0003, Curl Error(200) In Api ".GET_UPADTED_INITIAL_PAYMENT_STATUS);
            return ['result' => 'SERVER-ERROR', 'msg' => $response_obj];
        }  
    }

    //method to get the auto fetched data of the basundhara one services
    public function autoUpadateBasundharaOneCases($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => GET_UPADTED_INITIAL_PAYMENT_STATUS_BASUNDHARA_ONE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y" || $response_obj->result == "N" ){
                return ['result' => 'SUCCESS', 'msg' => $response_obj->data];                   
            }else{
                log_message("error", "#FCBASUNDHARA0002, Curl Error(Y) In Api ".GET_UPADTED_INITIAL_PAYMENT_STATUS_BASUNDHARA_ONE);
                return ['result' => 'SERVER-ERROR', 'msg' => $response_obj];
            } 
        }else{
            log_message("error", "#FCBASUNDHARA0003, Curl Error(200) In Api ".GET_UPADTED_INITIAL_PAYMENT_STATUS_BASUNDHARA_ONE);
            return ['result' => 'SERVER-ERROR', 'msg' => $response_obj];
        }
    }

}