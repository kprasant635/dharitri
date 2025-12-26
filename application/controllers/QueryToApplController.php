<?php

class QueryToApplController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('session'); // Load session library
    $this->load->helper(array('form', 'url'));
  }

  public function querytouser()
  {
    $order          = $this->input->post('query');
    $application_no = $this->input->post('application_no');
    $desigcode      = $this->session->userdata('user_desig_code');

    $errorMessages = [];

    $response = isValidQuery($application_no);
    if($response['status'] == 'n'){
      array_push($errorMessages, 'Application number has MALECIOUS QUERY');
    }

    if($order != ''){
      $response = specialCharacterCheckingInInput($order, ['.', ',', '|', '-',':','?','\'','/'], 'Query');
      if($response['status'] == 'n'){
        array_push($errorMessages, $response['message']);
      }

      $response = isValidQuery($order);
      if($response['status'] == 'n'){
        array_push($errorMessages, 'Query has MALECIOUS QUERY');
      }
    }
    else{
      array_push($errorMessages, 'Query Field is required');
    }

    if(count($errorMessages)){
      $error_messages = convertArrayToHtmlUlLi($errorMessages);
      $this->session->set_flashdata('query_mdl_message', $error_messages);
      return redirect($_SERVER['HTTP_REFERER']);
    }
    
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."queryInsert");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
      'application'        => $application_no,
      'query'              => $order,
      'type'               => '0',
      'query_from_officer' => $desigcode,
      'query_from_office'  => 'Circle Office'
    )));
    $result   = curl_exec($curl_handle);
    $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
    $data     = json_decode($result);
    if($httpcode!=200 || $data==null){
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }            
    if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
      $this->session->set_flashdata('message',"Your Query has been sent to the user against application no $application_no ");
      redirect('/home');
    } else {
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }
  }

  public function checkQueryApi()
  {
    $application_no = $this->input->post('application_no');     

    // check Authentication in codeignitor 2
    if (!$this->session->userdata('user_code')) {
      return json_encode(["status"=>"error", "message"=> "user Not Logged In"]);
    } 

    if ($application_no == null || trim($application_no) == '') {
      echo json_encode(["status" => "error", "message" => "Application Number Not Valid", "data" => null]);
      exit;
    }

    // var_dump(API_LINK_MB3); die;
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "QueryReturn");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
      'application' => $application_no,
    ]));
    
    $response = curl_exec($curl_handle);
    curl_close($curl_handle);
    
    // Decode the JSON response
    $data = json_decode($response, true);
    
    // Ensure $data is an array and not empty
    if (is_array($data) && !empty($data)) {
      $queries = $data; // No need to decode again, since it's already an array
  
      if (is_array($queries) && !empty($queries)) {
        $lastQuery = end($queries); // Get the last query

        // Check if the last query has a reply
        $querySent = !empty($lastQuery['reply_text']) ? 'QR' : 'Y';

        echo json_encode([
          'status'     => 'success',
          'query_sent' => $querySent,
          'queries'    => $queries // Directly include the array (no need to JSON encode it again)
        ]);
      } else {
        echo json_encode([
          'status'     => 'error',
          'query_sent' => 'N'
        ]);
      }
    } else {
      echo json_encode([
        'status'     => 'error',
        'query_sent' => 'Failed'
      ]);
    }
  }

  public function queryToUserForDagChange()
  {
    $order          = $this->input->post('query');
    $application_no = $this->input->post('application_no');
    $desigcode      = $this->session->userdata('user_desig_code');

    if($desigcode=='LM')
    {
      $desigcode = 'LRA';
    }

    $errorMessages = [];

    $response = isValidQuery($application_no);
    if($response['status'] == 'n'){
      array_push($errorMessages, 'Application number has MALECIOUS QUERY');
    }

    if($order != ''){
      $response = specialCharacterCheckingInInput($order, ['.', ',', '|', '-',':','?','\'','/'], 'Query');
      if($response['status'] == 'n'){
        array_push($errorMessages, $response['message']);
      }

      $response = isValidQuery($order);
      if($response['status'] == 'n'){
        array_push($errorMessages, 'Query has MALECIOUS QUERY');
      }
    } else {
      array_push($errorMessages, 'Query Field is required');
    }

    if(count($errorMessages)){
      $error_messages = convertArrayToHtmlUlLi($errorMessages);
      $this->session->set_flashdata('query_mdl_message', $error_messages);
      return redirect($_SERVER['HTTP_REFERER']);
    }

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."queryInsert");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
      'application'        => $application_no,
      'query'              => $order,
      'type'               => 'DC',
      'query_from_officer' => $desigcode,
      'query_from_office'  => 'Circle Office',
      'changed_reqd'       => 1,
    )));
    $result   = curl_exec($curl_handle);
    $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);


    $data= json_decode($result);
    if($httpcode!=200 || $data==null){
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }   


    if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y') {

      $sql = "Select dharitree from basundhar_application where basundhara='$application_no' ";
      $case = $this->db->query($sql)->row();
      $case_no = $case->dharitree;

      //////proceeding start//////
      $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id==null) {
        $proceeding_id=1;
      }

      $insPetProceed = [
        'case_no'               => $case_no,
        'proceeding_id'         => $proceeding_id,
        'date_of_hearing'       => date('Y-m-d h:i:s'),
        'next_date_of_hearing'  => date('Y-m-d h:i:s'),
        'note_on_order'         => 'LRA has requested for dag change',
        'status'                => 'W',
        'user_code'             => $this->session->userdata('user_code'),
        'date_entry'            => date('Y-m-d h:i:s'),
        'operation'             => 'E',
        'ip'                    => $this->utilityclass->get_client_ip(),
        'office_from'           => 'LM',
        'task'                  => 'LRA made query'
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      // echo $this->db->last_query(); die();
      if ($insertProceeding != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
        $json = [
          'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
        ];
        echo json_encode($json);
        return false;
      }
        //////proceeding end//////


      $basicData = [
        'dag_request' => 1
      ];

      $this->db->where('applid', $application_no);
      $this->db->update('settlement_basic', $basicData);

      if($this->db->affected_rows() != 1)
      {
        // $this->db->trans_rollback();
        log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
        $data = array(
          'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
        );
        echo json_encode($data);
        return false;
      }

      $this->session->set_flashdata('message', "Your Query has been sent to the user against application no $application_no");
        redirect(current_url());
    }
    else{
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }
  }




  public function queryToApplicantForMb2()
  {
    $order          = $this->input->post('query_to_appl');
    $application_no = $this->input->post('appl_no');
    $desigcode      = $this->session->userdata('user_desig_code');

    if($desigcode=='LM')
    {
      $desigcode = 'LRA';
    }

    $errorMessages = [];

    $response = isValidQuery($application_no);
    if($response['status'] == 'n'){
      array_push($errorMessages, 'Application number has MALECIOUS QUERY');
    }

    if($order != ''){
      $response = specialCharacterCheckingInInput($order, ['.', ',', '|', '-',':','?','\'','/'], 'Query');
      if($response['status'] == 'n'){
        array_push($errorMessages, $response['message']);
      }

      $response = isValidQuery($order);
      if($response['status'] == 'n'){
        array_push($errorMessages, 'Query has MALECIOUS QUERY');
      }
    } else {
      array_push($errorMessages, 'Query Field is required');
    }

    if(count($errorMessages)){
      $error_messages = convertArrayToHtmlUlLi($errorMessages);
      $this->session->set_flashdata('query_mdl_message', $error_messages);
      return redirect($_SERVER['HTTP_REFERER']);
    }

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."queryInsert");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
      'application'        => $application_no,
      'query'              => $order,
      'type'               => '0',
      'query_from_officer' => $desigcode,
      'query_from_office'  => 'Circle Office',
    )));
    $result   = curl_exec($curl_handle);
    $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

    $data= json_decode($result);

    if($httpcode!=200 || $data==null){
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }   


    if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y') {

      $sql = "Select dharitree from basundhar_application where basundhara='$application_no' ";
      $case = $this->db->query($sql)->row();
      $case_no = $case->dharitree;

      //////proceeding start//////
      $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id==null) {
        $proceeding_id=1;
      }

      $insPetProceed = [
        'case_no'               => $case_no,
        'proceeding_id'         => $proceeding_id,
        'date_of_hearing'       => date('Y-m-d h:i:s'),
        'next_date_of_hearing'  => date('Y-m-d h:i:s'),
        'note_on_order'         => 'LRA has requested for dag change',
        'status'                => 'W',
        'user_code'             => $this->session->userdata('user_code'),
        'date_entry'            => date('Y-m-d h:i:s'),
        'operation'             => 'E',
        'ip'                    => $this->utilityclass->get_client_ip(),
        'office_from'           => 'LM',
        'task'                  => 'LRA made query'
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      // echo $this->db->last_query(); die();
      if ($insertProceeding != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
        $json = [
          'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
        ];
        echo json_encode($json);
        return false;
      }
        //////proceeding end//////


      $basicData = [
        'dag_request' => 1
      ];

      $this->db->where('applid', $application_no);
      $this->db->update('settlement_basic', $basicData);

      if($this->db->affected_rows() != 1)
      {
        // $this->db->trans_rollback();
        log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
        $data = array(
          'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
        );
        echo json_encode($data);
        return false;
      }

      $this->session->set_flashdata('message', "Your Query has been sent to the user against application no $application_no");
        redirect(current_url());
    }
    else{
      $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
      redirect('/home');
    }
  }
   
}

?>