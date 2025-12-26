<?php
class ApiLogModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    function sendCurlRequest($case,$rmk,$status,$task,$pen)
    {
      $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
      $linkAvail=$this->db->query($sql)->num_rows();
      if($linkAvail>0)
      {
          $linkAvail = $this->db->query($sql)->row()->basundhara;
          $statusResponse = $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
          $result = $statusResponse['result'];
          if($result===true || $result=='true' || $result==1 || trim($result)=='y'){
              // return "y";
              return [
                'result'    => "y"
              ];
          }else{
              // return "n";
              return [
                'url'       => $statusResponse['url'],
                'method'    => $statusResponse['method'],
                'postData'  => $statusResponse['postData'],
                'httpcode'  => $statusResponse['httpcode'],
                'curlError' => $statusResponse['curlError'],
                'result'    => "n"
              ];
          }

      }
   }

   function postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen)
   {
    $parts = explode('/', $application_no);
    $result = $parts[0] . '/' . $parts[1] . '/';
    if($result=='RTPS/APPP/'){
        $apilink=API_LINK_MB3;
    }
    else
    {
        $caseRtpsBasu=$this->checkRtpsService($application_no);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
    }

    // $apilink='http://172.16.3.134/rtpsdemo/Api/';
    $url =$apilink."applicationStatusUpdateV2";
    $method ="POST";
    $postData = [
        "application" => $application_no,
        "dharitree" => $case,
        "rmk" => $rmk,
        "status" => $status,
        "task" => $task,
        "pen" => $pen

    ];

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $postData);
    
    $result = curl_exec($curl_handle);
    $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl_handle);
    curl_close($curl_handle);

    $curlResponse = json_decode($result);
    // var_dump($curlResponse); die;

    // $result ='n';

    // if ($httpcode !== 200 || !empty($curlError) || empty($response) || $result =='n' || json_decode($result)=='n' || $result ==null || json_decode($result)==null || $result === false ) {
    //   $this->saveCurlLog($url, $method, $postData, $httpcode, $curlError, $result);
    // }

    if ($httpcode !== 200 || !empty($curlError) || $curlResponse =='n' || $curlResponse !='y' || $result ==null || json_decode($result)==null || $result === false ) {
      $curlResponse ='n';
    }

    if($httpcode != 200){
        log_message("error", " Curl-Error in api: ".$apilink."applicationStatusUpdateV2 with json_data: "
            .json_encode(array(
                    'application' => $application_no,
                    'dharitree' => $case,
                    'rmk' => $rmk,
                    'status' => $status,
                    'task' => $task,
                    'pen'=>$pen
                )
            ));
    }
    // return $result;

    return [
      'url'       => $url,
      'method'    => $method,
      'postData'  => $postData,
      'httpcode'  => $httpcode,
      'curlError' => $curlError,
      'result'    => $curlResponse
    ];
    
  }

  function checkRtpsService($case)
  {
    $sql="SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
    $dataFound=$this->db->query($sql, $case)->row();
    if($dataFound){
        $data = $dataFound->basundhara;
        $var = explode('/', $data);
        $service = $var['0'];
    }else{
        $service = null;
    }
    return $service;
  }

  function saveCurlLog($url, $method, $postData, $httpCode, $curlError, $response, $case_no)
  {
      // $this->dbb=$this->load->database($_SESSION['credentials']['dn'],TRUE);
      
      $requestData = json_encode($postData);
      $params=array(
        'url' => $url,
        'method'=>$method,
        'request'=>$requestData,
        'http_code'=>$httpCode,
        'curl_error'=>$curlError,
        'response'=>$response,
        'created_at'=>date('Y-m-d h:i:s'),
        'case_no'=>$case_no
      );

      $this->db->insert('api_log',$params);



  }

}

?>