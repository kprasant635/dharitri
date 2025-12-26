<?php

class SmsApiControllerNew extends CI_Controller {

    private $templates = [];
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('template');
        $this->load->model('SmsApiModel');

        $this->templates[] = new Template("1407169166221130663","user_registration","Your account with credential {VAR} has been successfully created in {VAR} portal.");

        $this->templates[] = new Template("1407169166282393395","password_change","Password for your account {VAR} has been changed successfully in {VAR} portal.");

        $this->templates[] = new Template("1407169587928277966","user_activate","Your account with user id {VAR} has been activated in {VAR} portal.");

        $this->templates[] = new Template("1407169587939303345","user_deactivate","Your account with user id {VAR} has been deactivated in {VAR} portal.");

        $this->templates[] = new Template("1407169166302234966","login_otp","Please enter the OTP {VAR} to login to {VAR} portal.");

        $this->templates[] = new Template("1407169166311762141","passwordreset_otp","Please enter the OTP {VAR} to reset your password for the {VAR} portal.");

        $this->templates[] = new Template("1407169166320374443","applicant_query","A query has been raised for your Application No. {VAR}. Please login to https://sewasetu.assam.gov.in and respond accordingly");

        $this->templates[] = new Template("1407169166327138889","notice_generation","A notice has been generated for your Application No. {VAR}. Please login to https://sewasetu.assam.gov.in to view details");

        $this->templates[] = new Template("1407169166338778047","payment_notice","Payment notice has been generated for your Application No. {VAR}. Please login to https://sewasetu.assam.gov.in to pay the amount");

        $this->templates[] = new Template("1407169166347407246","application_disposal","Your application with Application No. {VAR} is disposed successfully. Please login to https://sewasetu.assam.gov.in to view details");

        $this->templates[] = new Template("1407169166354340526","application_rejection","Your application with Application No. {VAR} is Rejected. Please login to https://sewasetu.assam.gov.in to view details");

        $this->templates[] = new Template("1407169166364153472","ekhajana_notify","Your Application No. {VAR} is disposed successfully. You can pay your due khajana online in https://sewasetu.assam.gov.in");

        $this->templates[] = new Template("1407169166372897656","mobileno_verify","Please enter the OTP {VAR} to verify Mobile Number {VAR}");


        // ==================== newly added on 16-01-2025 by UTPAL  ==============

        $this->templates[] = new Template("1407173372269825411","user_registration1","Your account with user id {VAR} and password {VAR} has been successfully created in RCCMS portal. https://rccms.assam.gov.in");

        $this->templates[] = new Template("1407173372285878409","password_change1","Password for your account with user id {VAR} has been changed successfully in RCCMS portal. https://rccms.assam.gov.in");

        $this->templates[] = new Template("1407173372310034842","login_otp1","Please enter the OTP {VAR}  to login to your account with user id {VAR} in RCCMS portal. https://rccms.assam.gov.in");

        $this->templates[] = new Template("1407173372337375154","passwordreset_otp1","Please enter the OTP {VAR} to reset your password of your account with user id {VAR} in RCCMS portal. https://rccms.assam.gov.in");

        $this->templates[] = new Template("1407173372350749738","applicant_query1","A query has been raised for your Application No. {VAR}. Please visit https://rccms.assam.gov.in and respond accordingly via your account.");

        $this->templates[] = new Template("1407173391487602412","admission_hearing","Your RCCMS Case No. {VAR} has been generated vide submitted Application No. {VAR}. Your date of hearing is scheduled on {VAR} from {VAR} onwards at {VAR}. Please login to https://rccms.assam.gov.in to view causelist and other details via your account.");

        $this->templates[] = new Template("1407173391505355786","notice_generate","A notice of hearing/appearance has
            been generated for Application No. {VAR} vide RCCMS Case No. {VAR}. Your date of hearing is scheduled on
            {VAR} from {VAR} onwards at {VAR}. Please login to https://rccms.assam.gov.in to view daily causelist and
            other details via your account.");

        $this->templates[] = new Template("1407173391517532060","application_disposal1","Your application No. {VAR} is disposed off vide RCCMS Case No.{VAR}. Please login to https://rccms.assam.gov.in to view or download final order and other details via your account.");

        $this->templates[] = new Template("1407173372425112608","application_rejection1","Your Application No. {VAR} is rejected. Please login to https://rccms.assam.gov.in to view details via your account.");

        // new sms template for review
        $this->templates[] = new Template("1407173676121780018","review_approved","Dear applicant, your 
            application {#var#} for review has been approved. Please login to https://sewasetu.assam.gov.in and submit 
            your updated details under track application.");

        $this->templates[] = new Template("1407173676138718876","review_reject","Dear applicant, your 
            application {#var#} for review has been rejected for reason: {#var#}. Please login to 
            https://sewasetu.assam.gov.in to see the details.");

        // ==================== newly added on 27-10-2025 by UTPAL ==============

        $this->templates[] = new Template("1407176112260915764","authentication_success","Aadhaar Authentication bearing Aadhaar No. {VAR} processed on {VAR} at {VAR} for availing {VAR} service is successful. - DLRS");

        $this->templates[] = new Template("1407176112291600293","authentication_failure","Aadhaar Authentication bearing Aadhaar No. {VAR} processed on {VAR} at {VAR} for availing {VAR} service has failed. Reason: {VAR}. - DLRS");

    }

    public function sendSms()
    {
        header('Content-Type: application/json');        

        // multiple parameter works here
        $data = file_get_contents("php://input");
        $input = json_decode($data, true);  


        // otp works here
        // $data  = json_decode(file_get_contents("php://input"));
        // $input = json_decode($this->getMobileNo($data), true);  

        if(isset($input['response']) && $input['response'] == false)
        {
            echo json_encode(['responseType'=>2,'error' => 'Error in SMS sent']);
        }

        if (isset($input['key']) && isset($input['variables']) && isset($input['mobilenos'])) 
        {

          // var_dump($input['variables']); die;
          $smsText = $this->createSMSText($input['key'],$input['variables']);
          $templateId = $this->getTemplateId($input['key'],$input['variables']);

          if($smsText !== -1 && $templateId !== -1)
          {
            $this->callSmsApi($smsText,$templateId,$input['mobilenos']);
             
          }
          else
          {
            echo json_encode(['responseType'=>2,'error' => 'Invalid key']);
          }
             
        } else {
            echo json_encode(['responseType'=>2,'error' => 'Required fields are missing']);
        }

    }

    function createSMSText($templateKey, $variables = []) 
    {
            $index=$this->findTemplateIndexByKey($this->templates,$templateKey);

            if ($index !== -1) 
            {
                $sms = $this->templates[$index]->getContent();
                $result = preg_replace_callback('/{VAR}/', function($matches) use (&$variables) {
                      return array_shift($variables);}, $sms);
                return $result;
            } else 
            {
                return -1;
            }

    }

    function getTemplateId($templateKey, $variables = []) 
    {
      $index=$this->findTemplateIndexByKey($this->templates,$templateKey);
      if ($index !== -1) 
      {
        // var_dump($this->templates[$index]->getId();die;
        return $this->templates[$index]->getId();
      } else 
      {
        // $index=$this->findTemplateIndexById($this->templates,$templateKey);  
        return -1;
      }
           
    }

    function findTemplateIndexByKey(array $list, $searchKey) 
    {
        foreach ($list as $index => $template) 
        {
            if ($template->getKey() === $searchKey) {
                return $index;
            }
        }
        return -1; 
    }

    function findTemplateIndexById(array $list, $searchId) 
    {
        foreach ($list as $index => $template) 
        {
            if ($template->getKey() === $searchKey) {
                return $index;
            }
        }
        return -1; 
    }

    function callSmsApi($message, $templateid, $mobilenos)
    {
        header('Content-Type: application/json');
        $username="DLRS_ASSAM"; 
        $password="Dlrsassam@123";
        $senderid="ASMREV";
        $deptSecureKey= "e62099ca-23ed-40a1-882e-b83b891da835";
        $encryp_password=sha1(trim($password));
        if(count($mobilenos) == 1)
        {

           $this->callSingleSmsApi($username,$encryp_password,$senderid,$message,$mobilenos,$deptSecureKey,$templateid);
            
        }
        else
        {

             $this->callBulkSmsApi($username,$encryp_password,$senderid,$message,$mobilenos,$deptSecureKey,$templateid);  
        }
    }

    function callSingleSmsApi($username,$encryp_password,$senderid,$message,$mobilenos,$deptSecureKey,$templateid)
    {
        $key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
        $data = array(
        "username" => trim($username),
        "password" => trim($encryp_password),
        "senderid" => trim($senderid),
        "content" => trim($message),
        "smsservicetype" =>"singlemsg",
        "mobileno" =>trim($mobilenos[0]),
        "key" => trim($key),
        "templateid" => trim($templateid)
        );
        $this->post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT",$data);
    }

    function callBulkSmsApi($username,$encryp_password,$senderid,$message,$mobilenos,$deptSecureKey,$templateid)
    {
      $key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
      $data = array(
      "username" => trim($username),
      "password" => trim($encryp_password),
      "senderid" => trim($senderid),
      "content" => trim($message),
      "smsservicetype" =>"bulkmsg",
      "bulkmobno" =>trim(implode(",", $mobilenos)),
      "key" => trim($key),
      "templateid" => trim($templateid)
      );
      $this->post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT",$data);
    }

    
    function post_to_url($url, $data) 
    {
        $fields = '';
        foreach($data as $key => $value) 
        {
          $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
        $post = curl_init();
        curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($post);
        $httpcode = curl_getinfo($post, CURLINFO_HTTP_CODE);

        log_message("error", "SMS_EKYC_RES:".json_encode($result));
        log_message("error", "SMS_EKYC_HTTP:".json_encode($httpcode));
        log_message("error", "SMS_EKYC_URL:".json_encode($url));
        log_message("error", "SMS_EKYC_DATA:".json_encode($data));

        if($httpcode != 200)
        {
          echo json_encode(['responseType'=>3,'error' => 'Server error occured', 'code'=>$httpcode]);
        }
        else
        {
          $resultcode = substr($result,0, 3);
          echo json_encode(['responseType'=>1,'code' => $resultcode,'msg' => $this->getErrorMessage($resultcode),'mgsId'=>$this->getMessageID($result)]); 
        }
        
        curl_close($post);
   }

   

   function getErrorMessage($code) 
   {
    $errorMessages = array(
        '401' => 'Credentials Error, may be invalid username or password',
        '402' => 'SMS sent successfully',
        '403' => 'Credits not available',
        '404' => 'Internal Database Error',
        '405' => 'Internal Networking Error',
        '406' => 'Invalid or Duplicate numbers',
        '407' => '408 Network Error on SMSC',
        '409' => 'SMSC response timed out, message will be submitted',
        '410' => 'Internal Limit Exceeded, Contact support',
        '411' => '412 Sender ID not approved.',
        '413' => 'Suspect Spam, we do not accept these messages.',
        '414' => 'Rejected by various reasons by the operator such as DND, SPAM etc',
        '415' => 'Secure Key not available',
        '416' => 'Hash doesn’t match',
        '417' => 'otpmsg method can contain at max two mobile numbers',
        '418' => 'Daily Limit Exceeded',
        '422' => 'Entity id should be 12 to 19 digit',
        '423' => 'TEMPLATE_ID is mandatory and it should be 12 or 19 digit length',
        '425' => 'Secure Key is a mandatory field'
    );

    if (isset($errorMessages[$code])) 
    {
        return $errorMessages[$code];
    } else 
    {
        return "Undefined error";
    }
  }


  //Extracts mgsId from response
  function getMessageID($result)
  {  
    //result e.g. "402,MsgID = 151020231697372145601DLRS_ASSAM";
    if(strpos($result, "MsgID") == true)
    {
        if (preg_match('/MsgID\s*=\s*([^\s]+)/', $result, $matches)) 
        {
            return $matches[1];
        } else 
        {
            return "MsgID not found!";
        }
    }
    else
    {
        return "MsgID not found!";
    }
  }


    public function getMobileNo($data)
    {
        $response    = false;
        $rand_otp    = array();
        $mobile      = array();
        $variables   = array();
        $key         = $data->key;
        $mobile[]    = $data->mobilenos;
        $variables[] = $data->variables;

        $response = $this->insertOtpData($data);
    
        $final_results=array(
            'key'       => $key,
            'variables' => $variables,
            'mobilenos' => $mobile,
            'response'  => $response,
        );
        log_message('error','----------POST OTP--'.json_encode($final_results));
        return json_encode($final_results);
    }

    public function insertOtpData($data)
    {
        $arr = [
            'key'    => $data->key,
            'mobile' => $data->mobilenos,
            'otp'    => $data->variables,
        ];

        $this->db->trans_begin();

        //insert into json data
        $insJsonData = [
            'json_data' => json_encode($arr),
        ];
        $insertJson = $this->db->insert('sms_json_data', $insJsonData);
        if($insertJson != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR285: Insertion failed in sms_json_data : '.json_encode($data));
            return false;
        }

        // get last insert id
        $last_id = $this->db->insert_id();

        //insert into sms_otp_log table
        $insLog = [
            'mobile_no'  => '******'.substr($data->mobilenos, -4),
            'sms_key'    => $data->key,
            'sms_status' => 1,
            'json_id'    => $last_id,
        ];
        $insertSmsLog = $this->db->insert('sms_otp_log', $insLog);
        if($insertSmsLog != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR285: Insertion failed in sms_otp_log : '.json_encode($insLog));
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    
}
  