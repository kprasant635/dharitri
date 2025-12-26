<?php 
    class CurlModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function apiCall($api_link)
    {
        $json = array();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
            'Cookie: X-Oracle-BMC-LBS-Route=cc186366dfc8a5285a9ec79f9a19ea4ded86ec06'
            ),
            
        ));

        $response    = curl_exec($curl);
        $httpcode    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $json = [
          'httpcode' => $httpcode,
          'data'     => json_decode($response),
        ];
        return $json;
    }
}