<?php

class CaseAPI extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProceedingAPIModel');
        $this->load->library('session'); // Load session library
        $this->load->helper(array('form', 'url'));
        $this->dbswitch();

        $method = $this->router->fetch_method();

        if(!in_array($method, VERIFICATION_MODULE_METHODS))
        {
            if(HOLD_All_MB2_CASES_STATUS == 1)
            {
                if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
                {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }


    public function index(){
      print_r(json_encode($this->ProceedingAPIModel->getTableData()));
      exit();
    }

    public function querytouser(){
            $order=$this->input->post('query');
            $application_no=$this->input->post('application_no');
            $d=$this->session->userdata('dist_code');
            $s=$this->session->userdata('subdiv_code');
            $c=$this->session->userdata('cir_code');
            $m=$this->session->userdata('mouza_pargona_code');
            $l=$this->session->userdata('lot_no');
            $code=$this->session->userdata('user_code');
            $desigcode=$this->session->userdata('user_desig_code');

            $errorMessages = [];

            $applicationNoValidate = applicationNumberValidation($application_no);
            if(count($applicationNoValidate)){
                array_push($errorMessages, $applicationNoValidate['message']);
            }

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
            }else{
                array_push($errorMessages, 'Query Field is required');
            }

            if(count($errorMessages)){
                $error_messages = convertArrayToHtmlUlLi($errorMessages);
                $this->session->set_flashdata('query_mdl_message', $error_messages);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            // if($desigcode=='LM'){
            //     $lm=$this->utilityclass->getDefinedMondalsName($d,$s,$c,$m,$l,$code);
            //     $user_nm=$lm->lm_name;
            // }else{
            //     $lm=$this->utilityclass->getSelectedASOName($d,$s,$c,$code);
            //     $user_nm=$lm->username;
            // }
            // //ESCALATION START FOR QUERY=========
            // if(ESCALATION_ENABLE == 1 && ESCALATION_BLOCK_AFTER_QUERY == 1)
            // {   
            //     $this->load->model('Escalationmodel');             
            //     $basundhara = $this->rtpsmodel->getcaseno($application_no);
            //     if($basundhara)
            //     {
            //         $esData = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($basundhara);
            //         log_message('error','#ERRORESC00920===='.json_encode($esData));
            //         if($esData && !empty($esData))
            //         {
            //             $response = $this->Escalationmodel->blockEscalationForQueryCase($esData->case_no);
            //             log_message('error','#ERRORESC00921===='.json_encode($response));
            //             if($response['responseType'] == 1)
            //             {
            //                 $this->session->set_flashdata('message',"#ERRORESC00921 : Error in query for Application No  $application_no ");
            //                 redirect('/home');
            //             }
            //         }
            //     }
            // }
            // //END 
            
            // $data['rtps']=$rtps=$this->rtpsmodel->checkRtpsService($application_no);
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."queryInsert");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
            curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'query' =>  $order,
                'type' => '0',
                'query_from_officer'=>$desigcode,
                'query_from_office'=>'Circle Office'
            )));
            $result = curl_exec($curl_handle);
            $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            $data= json_decode($result);
            if($httpcode!=200 || $data==null){
                $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
                redirect('/home');
            }            
            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->session->set_flashdata('message',"Your Query has been sent to the user against application no $application_no ");
                redirect('/home');
            }else{
                $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
                redirect('/home');
            }
    }

    // public function checkQueryAPI(){
    //     $application_no=$this->input->post('application_no');
    //     // $application_no='RTPS/APPP/2024/755';



      



    //     $dab  = $this->load->database('rtpsmb_nc', TRUE);

       

    //     // check Authentication in codeignitor 2
    //     if (!$this->session->userdata('user_code')) {
    //       return json_encode(["status"=>"error", "message"=> "user Not Logged In"]);
    //     } 

    //     if ($application_no == null || trim($application_no) == '') {
    //         echo json_encode(["status" => "error", "message" => "Application Number Not Valid", "data" => null]);
    //         exit;
    //     }  
        
    //     $curl_handle = curl_init();
    //     curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."QueryReturn");
    //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //         'application' => $application_no,
    //     )));
    //     $data=curl_exec($curl_handle);
    //     return json_decode($data);

    //     if


    //     // check for query for that application no
    //     $data = $this->ProceedingAPIModel->getApplicationWithQuery($dab, $application_no);
    //     if ($data['query_sent'] == 'Y') {
    //         echo json_encode(['status' => 'success', 'query_sent'=> 'Y','queries'=> json_encode($data['application_queries'])]);
    //     } else {
    //         echo json_encode(['status' => 'error', 'query_sent'=> 'N']);
    //     }
    //     exit;
    // }

    

    public function checkQueryAPI(){
        $application_no=$this->input->post('application_no');
        // $application_no='RTPS/APPP/2025/1206';      

        // check Authentication in codeignitor 2
        if (!$this->session->userdata('user_code')) {
          return json_encode(["status"=>"error", "message"=> "user Not Logged In"]);
        } 

        if ($application_no == null || trim($application_no) == '') {
            echo json_encode(["status" => "error", "message" => "Application Number Not Valid", "data" => null]);
            exit;
        }

        $service_code = $this->db->query("select service_code as c from settlement_basic where applid='$application_no'")->row()->c;
        $validCodes = [13, 14, 15, 16, 17, 18];

        if(in_array($service_code, $validCodes)) 
        {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "queryReturnDagChange");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                'application' => $application_no,
            ]));
            
            $response = curl_exec($curl_handle);
            curl_close($curl_handle);
        }
        else
        {  
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
        }
        
        // Decode the JSON response
        $data = json_decode($response, true);

        // var_dump($response);exit;
        
        // Ensure $data is an array and not empty
        if (is_array($data) && !empty($data)) {
            $queries = $data; // No need to decode again, since it's already an array
        
            if (is_array($queries) && !empty($queries)) {
                $lastQuery = end($queries); // Get the last query
        
                // Check if the last query has a reply
                $querySent = !empty($lastQuery['reply_text']) ? 'QR' : 'Y';
        
                echo json_encode([
                    'status' => 'success',
                    'query_sent' => $querySent,
                    'queries' => $queries // Directly include the array (no need to JSON encode it again)
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'query_sent' => 'N'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'query_sent' => 'Nfdg'
            ]);
        }
    }        


      public function querytouserforDagchange(){
            $order=$this->input->post('query');
            $application_no=$this->input->post('application_no');
            $d=$this->session->userdata('dist_code');
            $s=$this->session->userdata('subdiv_code');
            $c=$this->session->userdata('cir_code');
            $m=$this->session->userdata('mouza_pargona_code');
            $l=$this->session->userdata('lot_no');
            $code=$this->session->userdata('user_code');
            $desigcode=$this->session->userdata('user_desig_code');

            if($desigcode=='LM')
            {
                $desigcode = 'LRA';
            }

            $errorMessages = [];

            // $applicationNoValidate = applicationNumberValidation($application_no);
            // if(count($applicationNoValidate)){
            //     array_push($errorMessages, $applicationNoValidate['message']);
            // }

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
            }else{
                array_push($errorMessages, 'Query Field is required');
            }

            if(count($errorMessages)){
                $error_messages = convertArrayToHtmlUlLi($errorMessages);
                $this->session->set_flashdata('query_mdl_message', $error_messages);
                return redirect($_SERVER['HTTP_REFERER']);
            }


            $service_code = $this->db->query("select service_code as c from settlement_basic where applid='$application_no'")->row()->c;
            
            $validCodes = [13, 14, 15, 16, 17, 18];



            if (in_array($service_code, $validCodes)) 
            {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."queryInsertDagChange");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'query' =>  $order,
                    'type' => 'DC',
                    'query_from_officer'=>$desigcode,
                    'changed_reqd' => 1,
                    'query_from_office'=>'Circle Office'
                )));
                $result = curl_exec($curl_handle);
                $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            }


            // if($desigcode=='LM'){
            //     $lm=$this->utilityclass->getDefinedMondalsName($d,$s,$c,$m,$l,$code);
            //     $user_nm=$lm->lm_name;
            // }else{
            //     $lm=$this->utilityclass->getSelectedASOName($d,$s,$c,$code);
            //     $user_nm=$lm->username;
            // }
            // //ESCALATION START FOR QUERY=========
            // if(ESCALATION_ENABLE == 1 && ESCALATION_BLOCK_AFTER_QUERY == 1)
            // {   
            //     $this->load->model('Escalationmodel');             
            //     $basundhara = $this->rtpsmodel->getcaseno($application_no);
            //     if($basundhara)
            //     {
            //         $esData = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($basundhara);
            //         log_message('error','#ERRORESC00920===='.json_encode($esData));
            //         if($esData && !empty($esData))
            //         {
            //             $response = $this->Escalationmodel->blockEscalationForQueryCase($esData->case_no);
            //             log_message('error','#ERRORESC00921===='.json_encode($response));
            //             if($response['responseType'] == 1)
            //             {
            //                 $this->session->set_flashdata('message',"#ERRORESC00921 : Error in query for Application No  $application_no ");
            //                 redirect('/home');
            //             }
            //         }
            //     }
            // }
            // //END 
            
            // $data['rtps']=$rtps=$this->rtpsmodel->checkRtpsService($application_no);

            else
            {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."queryInsert");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'query' =>  $order,
                    'type' => 'DC',
                    'query_from_officer'=>$desigcode,
                    'query_from_office'=>'Circle Office',
                    'changed_reqd' => 1,
                )));
                $result = curl_exec($curl_handle);
                $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            }

            log_message("error", "#ERR466_queryInsert: ".json_encode($result));


            $data= json_decode($result);
            if($httpcode!=200 || $data==null){
                $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
                redirect('/home');
            }   


            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){

                $sql = "Select dharitree from basundhar_application where basundhara='$application_no' ";
                $case = $this->db->query($sql)->row();
                $case_no = $case->dharitree;

                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id==null) {
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => 'LRA has requested for dag change',
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'task' => 'LRA made query'
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
                    'dag_request'          => 1
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