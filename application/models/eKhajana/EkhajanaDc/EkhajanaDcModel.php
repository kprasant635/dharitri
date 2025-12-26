
<?php

class EkhajanaDcModel extends CI_Model {
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

}
?>