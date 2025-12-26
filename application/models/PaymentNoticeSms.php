<?php
class PaymentNoticeSms extends CI_Model 
{
  public function __construct() {
    parent::__construct();
  }

  public function sendPaymentGenerateSms($rtps_appl_no, $mobile)
  {
    // call api to upload notice
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."sendPaymentGenerateSms");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
      'rtps_appl_no' => $rtps_appl_no,
      'mobile'       => $mobile,
    )));
    $result = curl_exec($curl_handle);
    $output = json_decode($result);
    log_message("error", "Ouput of SMS after Payment Notice Genrate for RTPS application no $rtps_appl_no : ".json_encode($output));
    return trim($output->responseType) == 'y' ? true : false;
  }

}