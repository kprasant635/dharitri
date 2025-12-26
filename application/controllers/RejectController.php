<?php
class RejectController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Allowed designations
        $allowed = ['CO','DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->model('basundhara/basundharamodel');
    }
    public function getRejectModal()
    {
        $service_code = $this->input->post('service_code');
        $case_no = $this->input->post('case_no');

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $errorMessages = [];
        $caseNoValidate = caseNumberValidation($case_no);
        if(count($caseNoValidate)){
            array_push($errorMessages, $caseNoValidate['message']);
        }
        
        $serviceCodeValidate = serviceCodeValidation($service_code);
        if(count($serviceCodeValidate)){
            array_push($errorMessages, $serviceCodeValidate['message']);
        }

        // Malecious checking Start
        $response = isValidQuery($case_no);
        if($response['status'] == 'n'){
            array_push($errorMessages, 'Case number has MALECIOUS QUERY');
        }
        
        $response = isValidQuery($service_code);
        if($response['status'] == 'n'){
            array_push($errorMessages, 'Service code has MALECIOUS QUERY');
        }

        // Malecious checking End

        if(count($errorMessages)){
            $data = [
                'success' => false,
                'errors' => $errorMessages
            ];
            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $postServiceCode=null;
        if ($service_code == '1' || $service_code == '2')
        {
            $postServiceCode=$this->CaseSearchForBasundhara($case_no);
            if ($postServiceCode == '01')
            {
                $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('1')";
                $res = $this->db->query($sql,array('1'))->result();
            }
            elseif ($postServiceCode == '03')
            {
                $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('2')";
                $res = $this->db->query($sql,array('1'))->result();
            }
            else
            {
                $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('2','1')";
                $res = $this->db->query($sql,array('1'))->result();
            }
            //echo $this->db->last_query();
        }
        elseif ($service_code == '3' || $service_code == '4')
        {
            $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('3')";
            $res = $this->db->query($sql,array('1'))->result();
        }
        elseif ($service_code == '11' )
        {
            $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('4')";
            $res = $this->db->query($sql,array('1'))->result();
        }

        elseif ($service_code == '12' )
        {
            $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('12')";
            $res = $this->db->query($sql,array('1'))->result();
        }
        else
        {
            $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code=?";
            $res = $this->db->query($sql,array('1',$service_code))->result();
        }

        if(count($res)){
            echo json_encode($res);
        }else{
            log_message('error', '#ERRRJCMSTR10001: No record found in reject_master table for service_code = ' . $service_code . '. Last query => ' . $this->db->last_query());
            $data = [
                'success' => false,
                'errors' => ['#ERRRJCMSTR10001: Something went wrong. Please try again later.']
            ];
            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
    }
    public function getRejectCat($sid)
    {
        $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('$sid')";
        $res = $this->db->query($sql,array('1'))->result();
        
        echo json_encode($res);
    }
    function postRejectedReasonNoCase(){
        $json = null;
        $message = null;
        $all_remark = null;
        $reject_code = $this->input->post('reject_code');
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason',
                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');
        if ($this->form_validation->run('validation') == FALSE)
        {
            foreach($validation as $rule){
                if (form_error($rule['field'])) {
                    $message .= form_error($rule['field']);
                }
            }
            $json = [
                'success' => false,
                'message' => $message,
            ];
            echo json_encode($json);
            return;          
        }
        $this->db->trans_begin();
        foreach ($reject_code as $r)
        {
            $array = [
                'service_code' => $service_code,
                'reject_code' => $r,
                'case_no' => $case_no,
                'user_code' => $user_code,
                'remark' => $this->input->post('remark'),
                'ref_no' => $this->input->post('ref_no'),
                'date_entry' => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];
            
            //*************** Insert into rejected_remark ********* /
            $insert = $this->db->insert('rejected_remark',$array);
            if($insert !=1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0002: Insertion failed in rejected_remark and query is: '. $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0002: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
            $sql2 = "select remark,service_code from reject_master where reject_code=?";
            $res2 = $this->db->query($sql2,$r)->row();
            $remarkRes2=$res2->remark;
            $service_code=$res2->service_code;
            $all_remark .= $remarkRes2.'. ';
            //////////POST TO BASUNDHARA//////////////
            $postArray[]=[
                'service_code'=>$service_code,
                'id'=>$r,
                'name'=>$remarkRes2
            ];
            //////////////////////////////////////////
        }
        $rmk= $all_remark;
        $status='R';
        $task=$this->session->userdata('user_desig_code');
        $pen='NA';
        $case=$case_no;
        //$application_no,$case,$rmk,$status,$task,$pen,$rejectedCtgs
        $api_data = $this->basundharamodel->postApiBasundharaForRejectedCase3rd($case,$case,$rmk,$status,$task,$pen,$postArray);
        if($api_data == false || $api_data == 'false')
        {
            $this->db->trans_rollback();
            log_message('error','#ERREJ0006: Basundhara API failed.');
            $json = [
                'success' => false,
                'message' => '#ERREJ0006: Unable to process',
            ];
            echo json_encode($json);
            return;
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. '.$case_no. ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'message' => 'Case has been successfully rejected !!',
            'redirect' => base_url() . 'index.php/home',
        ];
        echo json_encode($json);
        return;
    }
    public function postRejectedReason()
    {
        //xss & security validation starts
                $errorMessageStr = '';
                $resp = checkRequestSpecChar($_POST,array(),array(),array('remark' => true));
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }
                $resp = checkRequestValidQuery($_POST,array(),array('remark' => true));
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }    
                if($errorMessageStr != ''){
                    $json = [
                        'success' => false,
                        'message' => $errorMessageStr,
                    ];
                    echo json_encode($json);
                    return false;
                    exit;
                }
        //xss & security validation ends 
        $user_dist_code = $this->session->userdata('dist_code');
        $user_subdiv_code = $this->session->userdata('subdiv_code');
        $user_cir_code = $this->session->userdata('cir_code');

        $json = null;
        $message = null;
        $all_remark = null;
        $reject_code = $this->input->post('reject_code');
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $ref_no = $this->input->post('ref_no');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;
        
        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason',
                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];

        $is_case_no_valid = $is_service_code_valid = true;

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');
        if ($this->form_validation->run('validation') == FALSE)
        {
            foreach($validation as $rule){
                if (form_error($rule['field'])) {
                    $message .= form_error($rule['field']);
                }
            }
            $json = [
                'success' => false,
                'message' => $message,
            ];
            echo json_encode($json);
            return;          
        }
        $errorMessages = [];

        /*$caseNoValidate = caseNumberValidation($case_no);
        if(count($caseNoValidate)){
            array_push($errorMessages, $caseNoValidate['message']);
            $is_case_no_valid = false;
        }        
        $response = isValidQuery($case_no);
        if($response['status'] == 'n'){
            array_push($errorMessages, 'Case number has MALECIOUS QUERY');
            $is_case_no_valid = false;
        }        
        $serviceCodeValidate = serviceCodeValidation($service_code);
        if(count($serviceCodeValidate)){
            array_push($errorMessages, $serviceCodeValidate['message']);
            $is_service_code_valid = false;
        }
        if($remark != ''){
            $response = specialCharacterCheckingInInput($remark, ['.'], 'Remark');
            if($response['status'] == 'n'){
                array_push($errorMessages, $response['message']);
            }
            $response = isValidQuery($remark);
            if($response['status'] == 'n'){
                array_push($errorMessages, 'Remark has MALECIOUS QUERY');
            }
        }
        if(isset($ref_no) && $ref_no != ''){
            if($ref_no != 'NA'){
                $response = refNoValidation($ref_no);
                if($response['status'] == 'n'){
                    array_push($errorMessages, $response['message']);
                }                
                $response = isValidQuery($ref_no);
                if($response['status'] == 'n'){
                    array_push($errorMessages, 'Reference number has MALECIOUS QUERY');
                }

            }
        }
        if($service_code != '' && $is_service_code_valid && $is_case_no_valid){ */
        if($service_code != '' ){
            $db_service_code = [];
            $postServiceCode=null;
            if ($service_code == '1' || $service_code == '2')
            {
                $postServiceCode=$this->CaseSearchForBasundhara($case_no);
                if ($postServiceCode == '01') $db_service_code = ['1'];
                elseif ($postServiceCode == '03') $db_service_code = ['2'];
                else $db_service_code = ['1', '2'];
            }

            elseif ($service_code == '3' || $service_code == '4') $db_service_code = ['3'];

            elseif ($service_code == '11' ) $db_service_code = ['4'];

            else $db_service_code = [$service_code];


            if(gettype($reject_code) == 'array' && count($reject_code)){
                $this->db->where_in('reject_code', $reject_code);
                $this->db->where_in('service_code', $db_service_code);
                $this->db->where('flag', '1');
                $check_reject_code = $this->db->get('reject_master')->result_array();
                if(count($check_reject_code) != count($reject_code)){
                    log_message('error', '#ERRRJCTMST10001: Some data not found in reject_master table. QUERY: ' . $this->db->last_query());
                    array_push($errorMessages, '#ERRRJCTMST10001: Something went wrong with the reject reason');
                }
            }else{
                array_push($errorMessages, 'Reject code must be an array.');
            }
        }

        if(count($errorMessages)){
            $data = [
                'success' => false,
                'errors' => $errorMessages
            ];
            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        // case no validation
        if(in_array($service_code, ['1', '3', '9'])){
            // query from petition_basic
            $check_case = $this->db->query("select * from petition_basic where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10004: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10004: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if($check_case->status == 'D'){
                $data = [
                    'success' => false,
                    'errors' => ['\"'. $case_no .'\" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10002: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10002: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10002: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10002: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }

            }

        }elseif(in_array($service_code, ['2', '4'])){
            // query from field_mut_basic
            $check_case = $this->db->query("select * from field_mut_basic where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10005: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10005: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10003: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10003: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10003: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10003: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }

        }elseif(in_array($service_code, ['5'])){
            // query from allotment_cert_basic
            $check_case = $this->db->query("select * from allotment_cert_basic where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10006: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10006: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if($check_case->status == 'D'){
                $data = [
                    'success' => false,
                    'errors' => ['\"'. $case_no .'\" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10004: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10004: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                $db_cir_code = $check_case->cir_code ? $check_case->cir_code : $check_case->circle_code; // AC to PP doesnt contain cir_code, it has circle_code only
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code ||  $db_cir_code != $user_cir_code ){
                    log_message('error', '#ERRRJTTRCL10004: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10004: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }

        }elseif(in_array($service_code, ['11'])){
            // query from t_reclassification
            $check_case = $this->db->query("select * from t_reclassification where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10003: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10003: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }
                    
            if($check_case->status == 'R'){
                $data = [
                    'success' => false,
                    'errors' => ['\"'. $case_no .'\" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10001: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10001: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10001: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10001: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }

        }elseif(in_array($service_code, ['6', '8'])){
            // query from misc_case_basic
            $check_case = $this->db->query("select * from misc_case_basic where misc_case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10007: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10007: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if($check_case->status == 'F'){
                $data = [
                    'success' => false,
                    'errors' => ['\"'. $case_no .'\" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10005: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10005: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10005: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10005: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }

        }elseif(in_array($service_code, ['7', '10'])){
            // query from t_legacyupdation
            $check_case = $this->db->query("select * from t_legacyupdation where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10008: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10008: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if($check_case->status == 'R'){
                $data = [
                    'success' => false,
                    'errors' => ['"'. $case_no .'" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10006: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10006: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10006: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10006: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }
                
        }

        else if(in_array($service_code, ['12']))
        {
            // query from petition_basic
            $check_case = $this->db->query("select * from petition_basic where case_no=?", array($case_no))->row();
            if(!$check_case){
                log_message('error', '#ERRRJCTMST10004: No such case found. QUERY: ' . $this->db->last_query());
                $data = [
                    'success' => false,
                    'errors' => ['#ERRRJCTMST10004: No such case not found']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            if($check_case->status == 'D'){
                $data = [
                    'success' => false,
                    'errors' => ['\"'. $case_no .'\" is already rejected.']
                ];
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));

            }

            if(in_array($desg, ['ADC', 'DC'])){
                if($check_case->dist_code != $user_dist_code){
                    log_message('error', '#ERRRJTTRCL10002: Either "Dist code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10002: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }
            }else{
                if($check_case->dist_code != $user_dist_code || $check_case->subdiv_code != $user_subdiv_code || $check_case->cir_code != $user_cir_code){
                    log_message('error', '#ERRRJTTRCL10002: Either "Dist code" or "Subdiv code" or "Cir code" is mismatched with the login user. Usercode: ' . $user_code);
                    $data = [
                        'success' => false,
                        'errors' => ['#ERRRJTTRCL10002: This case doesn\'t belong to you.']
                    ];
                    return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
                }

            }

        }


        else{
            log_message('error', '#ERRRJCTMST10002: Service code not found');
            $data = [
                'success' => false,
                'errors' => ['#ERRRJCTMST10002: Service code not found']
            ];
            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $this->db->trans_begin();
        //table update as per service
        $params = $this->rejectTableServiceWise($service_code, $case_no, $user_code);
        // var_dump($params);exit;

        
        if($service_code==SERVICE_AUTO_MUTATION)
        {
            if($params[2] != 1)
            {
            $this->db->trans_rollback();
            log_message('error','#ERREJ0001: Updation failed in '.$params[0].$params[1].' and query is: '. $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001: Unable to process',
            ];
            echo json_encode($json);
            return;
            }
        }
        else
        {
            if($params[1] != 1)
            {
            $this->db->trans_rollback();
            log_message('error','#ERREJ0001: Updation failed in '.$params[0].' and query is: '. $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001: Unable to process',
            ];
            echo json_encode($json);
            return;
            }
        }
        


        foreach ($reject_code as $r)
        {
            $array = [
                'service_code' => $service_code,
                'reject_code' => $r,
                'case_no' => $case_no,
                'user_code' => $user_code,
                'remark' => $remark,
                'ref_no' => $ref_no,
                'date_entry' => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];
            
            //*************** Insert into rejected_remark ********* /
            $insert = $this->db->insert('rejected_remark',$array);
            if($insert !=1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0002: Insertion failed in rejected_remark and query is: '. $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0002: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
            $sql2 = "select remark,service_code from reject_master where reject_code=?";
            $res2 = $this->db->query($sql2,$r)->row();
            $remarkRes2=$res2->remark;
            $service_code=$res2->service_code;
            $all_remark .= $remarkRes2.'. ';
            //////////POST TO BASUNDHARA//////////////
            $postArray[]=[
                'service_code'=>$service_code,
                'id'=>$r,
                'name'=>$remarkRes2
            ];
            //////////////////////////////////////////
        }
        $all_remark .= $remark;
        if($desg == 'CO' || $desg == 'AST' || $desg == 'LM' || $desg == 'SK'){
            //*************** Insert into Petition Proceeding ********* /
            $proceeding = $this->proceedingRemark($case_no,$all_remark);
            if($proceeding !=1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0003: Insertion failed in petition_proceeding.'. $this->db->last_query() );
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0003: Unable to process',
                ];
                echo json_encode($json);
                return;
            }

            if($service_code==SERVICE_AUTO_MUTATION)
            {
                $sql = $this->db->query('select dist_code,noc_no from petition_basic where case_no=?',array($case_no))->row();

                $dist_code = $sql->dist_code;
                $appno = $sql->noc_no;

                $update_ls = array(
                    'am_rejected_remarks'=>$all_remark
                    );

                $this->db->where('distcode', $dist_code);
                $this->db->where('appno', $appno);
                $this->db->update('landsale', $update_ls);
            }
        }
        else if($desg == 'ADC' || $desg == 'DC'){
            //*************** Insert into Petition Proceeding DC ADC ********* /
            $proceeding = $this->proceedingDCADCRemark($case_no,$all_remark);
            if($proceeding !=1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0004: Insertion failed in petition_proceeding_dc_adc.');
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0004: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
        }

        
        //*************** Insert into DashboardData ********* /
        $checkDashboardCase = $this->db->query("SELECT case_no FROM dashboard_data 
            WHERE case_no=?", $case_no)->row();
        if($checkDashboardCase){
            $dashboard = $this->DashboardReject($case_no);
            if($dashboard <= 0)
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0005: Insertion failed in dashboard_data.');
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0005: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
        }
        $rmk= $all_remark;
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $status='R';
            $task=$this->session->userdata('user_desig_code');
            $pen='NA';
            $case=$case_no;
            $api_data = $this->basundharamodel->postApiBasundharaForRejectedCase1st($case,$rmk,$status,$task,$pen,$postArray);
            if($api_data == false || $api_data == 'false')
            {
                $this->db->trans_rollback();
                log_message('error','#ERREJ0006: Basundhara API failed.');
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0006: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
        }
        //////////////Send Reject status to RTPS Server////////////////////
        $sql="Select application_ref_no,applid,mut_type from petition_basic where case_no=? ";
        $application_ref_no=$this->db->query($sql,array($case_no));
        if(!$basundharaExist && $application_ref_no->num_rows()==1){
            $refno=$application_ref_no->row();
            $curl_handle = curl_init();
            if($refno->mut_type=='03'){
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation/mutation_response.php");
            }else if($refno->mut_type=='04'){
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_co_order.php");
            }
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
            curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                 'applId' => $refno->applid,
                 'application_ref_no' => $refno->application_ref_no,
                 'msg' => $rmk==null?"Rejected":$rmk,
                 'status' => "R",
             )));
            $result = curl_exec($curl_handle);
            log_message('error',"Response from RTPS:".$case_no ."####".($result));
        }
        //////////////////END////////////////////////////

        //ESCALATION START FOR REJECT=========
        if(ESCALATION_ENABLE == 1 && ESCALATION_BLOCK_AFTER_REJECT == 1)
        {   
            $this->load->model('Escalationmodel');             
            $esData = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            log_message('error','#ERRORESCREJECT955===='.json_encode($esData));
            if($esData && !empty($esData))
            {
                $response = $this->Escalationmodel->blockEscalationForRejectCase($esData->case_no);
                log_message('error','#ERRORESCREJECT959===='.json_encode($response));
                if($response['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message',"#ERRORESCREJECT959 : Error in reject for case_no $case_no ");
                    redirect('/home');
                }
            }
        }



        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. '.$case_no. ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'message' => 'Case has been successfully rejected !!',
            'redirect' => base_url() . 'index.php/home',
        ];
        echo json_encode($json);
        return;    
    }
    public function proceedingRemark($case_no,$remark)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "select MAX(proceeding_id) as id from petition_proceeding where
               case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
        $res = $this->db->query($sql, array($case_no,$dist_code,$subdiv_code,$cir_code));
        if($res->num_rows() > 0){
            $proceeding_id = $res->row()->id+1;
        }
        else
        {
            $proceeding_id = 1;
        }
        $values = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $remark,
            'status' => 'Rejected',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'ip'=> $this->utilityclass->get_client_ip()
        );
        return $this->db->insert("petition_proceeding", $values);
    }
    public function proceedingDCADCRemark($case_no,$remark)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "select MAX(proceeding_id) as id from petition_proceeding_dc_adc where
               case_no=? ";
        $res = $this->db->query($sql, array($case_no,$dist_code,$subdiv_code,$cir_code));
        if($res->num_rows() > 0){
            $proceeding_id = $res->row()->id+1;
        }
        else
        {
            $proceeding_id = 1;
        }
        $values = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $remark,
            'status' => 'Rejected',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'ip' => $this->utilityclass->get_client_ip()
        );
        return $this->db->insert("petition_proceeding_dc_adc", $values);
    }
    public function DashboardReject($case_no)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $base=array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user'=>'NA',
            'status'=>'F',
            'remark'=>'Case Rejected',
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $this->db->where('case_no',$case_no);
        $this->db->update('dashboard_data',$base);
        return $this->db->affected_rows();
    }
    public function rejectTableServiceWise($service_code, $case_no, $user_code){
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $table = array();
        if($this->session->userdata('user_desig_code')=='CO'){
            $name=$this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$user_code);
            $RejectedOfficerName=$name->username;
        }if($this->session->userdata('user_desig_code')=='ADC'||$this->session->userdata('user_desig_code')=='DC'){
            $name=$this->utilityclass->dcname($this->session->userdata('dist_code'),$user_code);
            $RejectedOfficerName=$name;
        }
        // office mutation, office partition, conversion
        if($service_code == SERVICE_OFFICE_MUTATION || $service_code == SERVICE_OFFICE_PARTITION || $service_code == SERVICE_CONVERSION || $service_code == SERVICE_AUTO_MUTATION){
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE 
                case_no=?",$case_no)->row()->petition_no;
            $array = [
                'status' => 'D',
                'order_passed' => 'Y',
                'remarks' => $case_no.' has successfully rejected by '.$RejectedOfficerName,
                'user_code' => $user_code,
                'date_of_order' => date("Y-m-d h:i:s"),
            ];
            $this->db->where(['case_no'=>$case_no, 'petition_no'=>$petition_no]);
            $this->db->update('petition_basic', $array);
            $table[] = 'petition_basic';

            if($service_code==SERVICE_AUTO_MUTATION)
            {

                $sql = $this->db->query('select dist_code,noc_no from petition_basic where case_no=?',array($case_no))->row();

                $dist_code = $sql->dist_code;
                $appno = $sql->noc_no;

                $update_ls = array(
                    'am_rejected' => 'Y',
                    'am_rejected_date' => date('Y-m-d G:i:s')
                );

                $this->db->where('distcode', $dist_code);
                $this->db->where('appno', $appno);
                $this->db->update('landsale', $update_ls);

                $table[] = 'landsale';
            }


        }
        // field mutation, field partition
        if($service_code == SERVICE_FIELD_MUTATION || $service_code == SERVICE_FIELD_PARTITION){
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE 
                case_no=?",$case_no)->row()->petition_no;
            $array = [
                'is_dispose' => 'Y',
                'order_passed' => 'Y',
                'dispose_reason' => $case_no.' has successfully rejected by '.$RejectedOfficerName,
                'user_code' => $user_code,
                'if_dispose_date' => date("Y-m-d h:i:s"),
            ];
            $this->db->where(['case_no'=>$case_no, 'petition_no'=>$petition_no]);
            $this->db->update('field_mut_basic', $array);
            $table[] = 'field_mut_basic';
        }
        // allotment
        if($service_code == SERVICE_ALLOTMENT){
            $petition_no = $this->db->query("SELECT petition_no FROM allotment_cert_basic WHERE 
                case_no=?",$case_no)->row()->petition_no;
            if($this->session->userdata('user_desig_code')=='CO'){
                $array = [
                    'status' => 'D',
                    'next_date_hearing' => date('Y-m-d'),
                    'co_note' => 'Y',
                    'co_code' => $user_code,
                ];
            }elseif($this->session->userdata('user_desig_code')=='DC' || $this->session->userdata('user_desig_code')=='ADC'){
                $array = [
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $case_no.' has successfully rejected by '.$RejectedOfficerName,
                    'status' => 'D',
                    'next_date_hearing' => date('Y-m-d')
                ];
            }
            $this->db->where(['case_no'=>$case_no, 'petition_no'=>$petition_no]);
            $this->db->update('allotment_cert_basic', $array);
            $table[] = 'allotment_cert_basic';
        }
        // name cancellation, name correction
        if($service_code == SERVICE_NAME_CANCEL || $service_code == SERVICE_NAME_CORRECT){
            $this->miscCaseProcessReport($case_no);
            $petition_no = $this->db->query("SELECT misc_case_petition_no FROM misc_case_basic WHERE 
                misc_case_no=?",$case_no)->row()->misc_case_petition_no;
            $array = [
                'user_code'=>$user_code,
                'status'=>'F',
                'date_of_operation'=>date('Y-m-d'),
            ];
            $this->db->where(['misc_case_no'=>$case_no, 'misc_case_petition_no'=>$petition_no]);
            $this->db->update('misc_case_basic', $array);
            $table[] = 'misc_case_basic';
        }
        // Reclassification
        if($service_code == SERVICE_RECLASSIFICATION){
            $array = [
                'status' => 'R',
                'status_date' => date("Y-m-d h:i:s"),
            ];
            $this->db->where('case_no',$case_no);
            $this->db->update('t_reclassification', $array);
            $table[] = 't_reclassification';
        }
        // Area Correction
        if($service_code == SERVICE_AREA_CORRECTION){
         $array = [
            'status' => 'R',
            'co_yn' => 'Y',
            'co_note' => $case_no.' has successfully rejected by '.$user_code,
            'co_orddate' => date("Y-m-d h:i:s"),
            'co_code' => $user_code,
            'status_date' => date("Y-m-d h:i:s")
         ];
         $this->db->where('case_no',$case_no);
         $this->db->update('t_legacyupdation', $array);
         $table[] = 't_legacyupdation';
        }
        // // Mobile Data
        if($service_code == SERVICE_MOBILE_UPDATE){
         $array = [
             'app_status' => 'R',
         ];
         $this->db->where('basundhara',$case_no);
         $this->db->update('basundhar_application', $array);
         if($this->db->affected_rows()==0){
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$case_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'R',
                'pending_with'=>'NA'
            );
          $this->db->insert('basundhar_application',$basundhara);
         }
         $table[] = 'basundhar_application';
        }
        $table[] = $this->db->affected_rows();
        return $table;
    }
    //this method will be used for checking script in the post fields
    function check_script($str){
        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }
    public function miscCaseProcessReport($case_no)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $petition_no = $this->db->query("SELECT misc_case_petition_no FROM misc_case_basic WHERE 
                misc_case_no=?",$case_no)->row()->misc_case_petition_no;
        $sql = "select MAX(note_no) as id from misc_case_process_reports where
               misc_case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
        $res = $this->db->query($sql, array($case_no,$dist_code,$subdiv_code,$cir_code));
        if($res->num_rows() > 0){
            $proceeding_id = $res->row()->id+1;
        }
        else
        {
            $proceeding_id = 1;
        }
        $values = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $proceeding_id,
            'misc_case_no' => $case_no,
            'co_fresh_proceeding' => 'Y',
            'process_note' => $case_no.' has successfully rejected by '.$user_code,
            'note_date' => date('Y-m-d G:i:s'),
            'user_code' => $user_code,
            'operation' => 'C',
            'misc_case_petition_no' => $petition_no,
        );
        return $this->db->insert("misc_case_process_reports", $values);
    }
    function CaseSearchForBasundhara($case){
        $case = trim($case);

        $decrypted = dec_param($case, 'case_no');
        $case   = !is_null($decrypted) ? trim($decrypted) : $case;

        $sql="Select trans_code from petition_basic where case_no='$case'
        union
        Select trans_code from field_mut_basic where case_no='$case'
         ";

        return $this->db->query($sql)->row()->trans_code;
    }
}