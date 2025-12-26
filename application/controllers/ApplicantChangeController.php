<?php
class ApplicantChangeController extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('ApplicantChangeModel');
        $this->load->model('UtilsModel');
        $this->load->library('AES');
        $this->dbswitch();
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function dashboard()
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $l=$this->session->userdata('lot_no');
        $u=$this->session->userdata('user_desig_code');

        $district['_view'] = 'applicant_change/list_of_to_be_changed_data';
        $this->load->view('layouts/main',$district);
    }

    public function applicantDetail()
    {
        $data = null;
        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $m = $this->session->userdata('mouza_pargona_code');
        $l = $this->session->userdata('lot_no');
        $u = $this->session->userdata('user_desig_code');
        $case_no = $this->input->get('case');
        $dhar_no = $this->utilityclass->decryptJwtCase($case_no);    

        // $var = 'F4/XBeVZRZbuFX28pp9tu+/fVeHZXtkkAj/dhzgZfL5Bv8C214bYKZA1ZSpKQnOWAASl04K9IK/lPucqY11sXPupMqljVPCe+EJ9fDegArnmzV5cAyezFBmgFT2CsjmtS2vgNbs+Fs5xkSEPUk72hzw+B9d8TBBjtjJYcL73WFAPARWiyf7DDTHkjYkk81piE7lMzNo51MHjelDbKmMoKZBsK5bWob52adgmNnTgYgO6Q7hOEeNdQGhpPmsFSPuJyQFdDma4rZWr61PVVAMRGm46akp2J1gwNff+KGkI85/fokaaSRTETNBun96oU7awU2edTTNLLF92ksVSYesZqeERUwOAmpY8exMxCRKla2iw+Vk+daUBg+/VxnJbrxJCc0IJRatuBsEJr2FtXUqqfZIuaLU4VcYxsMP1ZDNzxHVKUlWK+8/U0yrqvAQkb4Jyyz6NrG858xNXPlZovUT6irXb48Y6uPbpvf+OM6eMEW6HN86W5rje95/mest7a2nvwyPpIFavHD4yX8sX27CcGg==';

        // $aes = new AES(($var), '1234567890123456');
        // $post_enc_data = $aes->decrypt();

        // var_dump($post_enc_data); die;

        //settlement basic
        $basic = $this->ApplicantChangeModel->getFromSettlementBasic($dhar_no)->row();

        // from settlement applicants
        $applicants = $this->ApplicantChangeModel->getFromSettlementApplicant($dhar_no)->result();

        // get main applicant
        $main_appl = $this->ApplicantChangeModel->getMainApplicant($dhar_no);

        //get encroacher
        $en = $this->ApplicantChangeModel->getEncroacher($dhar_no);

        $encrypted_data = [
            'case_no'      => $dhar_no,
            'auth_key'     => SECRET_KEY,
            'response_url' => base_url().'index.php/ApplicantChangeController/applicantDetail?case='.$case_no,
            'service_code' => $basic->service_code,
        ];

        $aes = new AES(json_encode($encrypted_data), '1234567890123456');
        $post_enc_data = $aes->encrypt();

        // $post_enc_data = $this->utilityclass->encryptJwtCase($encrypted_data);

        $data = [
            'basic'    => $basic,
            'appl'     => $applicants,
            'mainAppl' => $main_appl,
            'case_no'  => $dhar_no,
            'enc'      => $en,
            'enc_case' => $post_enc_data,
            '_view'    => 'applicant_change/appl_described_data',
        ];

        $this->load->view('layouts/main', $data);
    }


    public function ekycVerification()
    {
        // $_POST = json_decode(file_get_contents("php://input"), true);
        $data     = null;
        $dist     = $this->session->userdata('dist_code');
        $sub      = $this->session->userdata('subdiv_code');
        $cir      = $this->session->userdata('cir_code');
        $mouza    = $this->session->userdata('mouza_pargona_code');
        $lot      = $this->session->userdata('lot_no');
        $ucode    = $this->session->userdata('user_desig_code');
        $case_no  = $this->input->post('case_no');
        $base_url = $this->input->post('base_url');
        $scode    = $this->input->post('scode');

        //check if any joint applicant available
        $jointApplAvail = $this->ApplicantChangeModel->getJointApplicant($case_no);

        $data['jointAppl'] = $jointApplAvail->num_rows();
        $data['appl_list'] = $jointApplAvail->result();
        $this->load->view('SettlementView/include/view_page_multiple_appl_ekyc', $data);
    }


    public function requestToModifyAppl()
    {
        $data = array();
        $ekyc = array();
        $case_no = $_POST['case_no'];

        $basu_no = $this->ApplicantChangeModel->getBasuApplIdFromCaseNo($case_no);
        // var_dump($basu_no);die;

        // call api to perform operation at basundhara end    
        $api = $this->ApplicantChangeModel->ekycAtBasundhara($basu_no);
        $result = json_decode($api);

        // var_dump($result); die;

        if (isset($result) && (trim($result->responseType) != 'y' || $result == null)) 
        {
            $data['responseType'] = $result->responseType;
            $data['message']      = $result->message;
        }
        else
        {
            $ekyc = json_encode($result->auth_data);

            if(isset($ekyc) && $ekyc != null || $ekyc != '')
            {
                $data['eKyc_data'] = json_encode($result->auth_data);
                log_message('error', 'ekycVerification '.json_encode($data['eKyc_data']));
            }
            else
            {
                $data['message'] = $result->message;
            }
        }
        $this->load->view('SettlementView/include/ekyc_response_page', $data);
    }

    public function addNewMainApplicant()
    {
        $_POST               = json_decode(file_get_contents("php://input"), true);
        $json                = null;

        $base_url            = $this->input->post('base_url');
        $case_no             = $this->input->post('case_no');
        $auth_response       = $this->input->post('auth_response');
        $ekyc_pdar_type      = $this->input->post('ekyc_pdar_type');
        $ekyc_pdar_name      = $this->input->post('ekyc_pdar_name');
        $ekyc_pdar_guardian  = $this->input->post('ekyc_pdar_guardian');
        $ekyc_dob            = $this->input->post('ekyc_dob');
        $ekyc_gender         = $this->input->post('ekyc_gender');
        $ekyc_address        = $this->input->post('ekyc_address');
        $ekyc_appl_asm       = $this->input->post('ekyc_appl_asm');
        $ekyc_guar_appl_asm  = $this->input->post('ekyc_guar_appl_asm');
        $ekyc_marital_status = $this->input->post('ekyc_marital_status');
        $ekyc_per_add        = $this->input->post('ekyc_per_add');
        $ekyc_mobile         = $this->input->post('ekyc_mobile');
        $ekyc_relation       = $this->input->post('ekyc_relation');
        // $this->ApplicantChangeModel->insertSettlementApplicant($case_no, $_POST);
        // return;
        // var_dump($_POST);die;

        $oldApplId = $this->ApplicantChangeModel->getMainApplicant($case_no)->id;
        // var_dump($oldApplId);

        // get basundhara case no
        $appl_no = $this->ApplicantChangeModel->getBasuApplIdFromCaseNo($case_no);

        //descrypt auth response
        // $auth = $this->ApplicantChangeModel->encryptAuthResponse($auth_response);


        //check

        

        // check for validation
        $valid = json_decode($this->inputValidation($_POST));
        if(isset($valid) && $valid['responseType'] == 3)
        {
            echo json_encode($valid);
            return;
        }

        $this->db->trans_begin();

        //check for joint applicant as main applicant
        $jointAppl = $this->ApplicantChangeModel->checkJointApplEkycDone($case_no);
        // echo $this->db->last_query();
        if($jointAppl->num_rows() > 0) // if join applicant as main applicant
        {
            $res = $this->ApplicantChangeModel->jointApplicantUpdateAsMain($case_no, $_POST, $oldApplId);
            $result = json_decode($res);
            // var_dump($result->responseType); die;
            if($result->responseType == 1)
            {
                // var_dump("sdfg");
                $this->db->trans_commit();
                log_message('error', "#SUCC150: Successfully inserted and verified new applicant detail for application no $appl_no");
                $json = [
                    'responseType' => 1,
                    'message'      => "#SUCC150: New applicant detail successfully inserted for application no $appl_no",
                ];
                echo json_encode($json);
                return;
            }
            else 
            {
                $this->db->trans_rollback();
                echo json_encode($res);
                return;
            }
        }
        else
        {
            // echo "sdfghjk"; die;
            // insert into applicant deleted table (old applicant)
            $old_appl = $this->ApplicantChangeModel->insertIntoApplicantDelete($case_no);
            // echo $this->db->last_query();
            if($old_appl != 1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERR100: Insertion failed in applicant_deleted_data '.$this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR100: Unable to add new applicant.',
                ];
                echo json_encode($json);
                return;
            }

            //new applicant insert in settlement_applicant
            $insNewAppl = $this->ApplicantChangeModel->insertSettlementApplicant($case_no, $_POST);
            // echo $this->db->last_query();
            if($insNewAppl != 1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERR120: Insertion failed in settlement_applicant '.$this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR120: Unable to add new applicant.',
                ];
                echo json_encode($json);
                return;
            }

            //delete old main applicant from settlement_applicant
            $delOldAppl = $this->ApplicantChangeModel->deleteOldMainAppl($case_no, $oldApplId);
            // echo $this->db->last_query();
            // echo $this->db->last_query(); die;
            if($delOldAppl != 1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERR110: Deletion failed in settlement_applicant '.$this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR110: Unable to add new applicant.',
                ];
                echo json_encode($json);
                return;
            }

            // //check if existing applicant is going to be main applicant
            // $checkCount = $this->ApplicantChangeModel->checkJointApplEkycDone($case_no);

            // if($checkCount->num_rows() > 0)
            // {
            //     //updation in settlement_applicant of old applicant
            //     $upOldAppl = $this->ApplicantChangeModel->updateSettlementApplicant($case_no);
            //     // echo $this->db->last_query(); die;
            //     if($upOldAppl != 1)
            //     {
            //         $this->db->trans_rollback();
            //         log_message('error','#ERR110: Updation failed in settlement_applicant '.$this->db->last_query());
            //         $json = [
            //             'responseType' => 3,
            //             'message'      => '#ERR110: Unable to add new applicant.',
            //         ];
            //         echo json_encode($json);
            //         return;
            //     }
            // }
                        

            // insert into settlement proceeding
            $insProceed = $this->ApplicantChangeModel->insertSettlementProceeding($case_no);
            // echo $this->db->last_query();
            if($insProceed != 1)
            {
                $this->db->trans_rollback();
                log_message('error','#ERR130: Insertion failed in settlement_proceeding '.$this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR130: Unable to add new applicant.',
                ];
                echo json_encode($json);
                return;
            }  

            // $this->db->trans_rollback();
            $this->db->trans_commit();

            log_message('error', "#SUCC150: Successfully inserted and verified new applicant detail for application no $appl_no");
            $json = [
                'responseType' => 1,
                'message'      => "#SUCC150: New applicant detail successfully inserted for application no $appl_no",
            ];
            echo json_encode($json);
            return;
        }

        
    }

    public function inputValidation($data)
    {
        $json = null;

        if($data['ekyc_pdar_name'] == null || $data['ekyc_pdar_name'] == ''){
          log_message('error', '#ERR352: Applicant name can not be empty');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR352: Applicant name can not be empty',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_pdar_guardian'] == null || $data['ekyc_pdar_guardian'] == ''){
          log_message('error', '#ERR361: Guardian name can not be empty');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR361: Applicant name can not be empty',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_dob'] == null || $data['ekyc_dob'] == ''){
          log_message('error', '#ERR369: Date of birth is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR369: Date of birth is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_gender'] == null || $data['ekyc_gender'] == ''){
          log_message('error', '#ERR377: Gender is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR377: Gender is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_address'] == null || $data['ekyc_address'] == ''){
          log_message('error', '#ERR385: Present address is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR385: Present address is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_address'] == null || $data['ekyc_address'] == ''){
          log_message('error', '#ERR385: Present address is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR385: Present address is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_marital_status'] == null || $data['ekyc_marital_status'] == ''){
          log_message('error', '#ERR401: Marital status is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR401: Marital status is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_per_add'] == null || $data['ekyc_per_add'] == ''){
          log_message('error', '#ERR412: Permanent address is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR412: Permanent address is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_mobile'] == null || $data['ekyc_mobile'] == ''){
          log_message('error', '#ERR417: Mobile No is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR417: Mobile No is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_relation'] == null || $data['ekyc_relation'] == ''){
          log_message('error', '#ERR428: Relation with guardian is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR428: Relation with guardian is required',
          ];
          return json_encode($json);
        }
        else if($data['ekyc_occ'] == null || $data['ekyc_occ'] == ''){
          log_message('error', '#ERR531: Occupation is required');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR531: Occupation is required',
          ];
          return json_encode($json);
        }
        $name_assamese = $this->ApplicantChangeModel->checkAssameseCharacterOnly($data['ekyc_appl_asm']);
        if($name_assamese != null || $name_assamese != ''){
          log_message('error', '#ERR540: Assamese character not entered in Applicant detail Name in Assamese field');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR540: Only Assamese character allowed in Applicant detail Name in Assamese',
          ];
          return json_encode($json);
        }
        $guar_name_assamese = $this->ApplicantChangeModel->checkAssameseCharacterOnly($data['ekyc_guar_appl_asm']);
        if($guar_name_assamese != null || $guar_name_assamese != ''){
          log_message('error', '#ERR549: Assamese character not entered in Applicant detail Name in Assamese field');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR549: Only Assamese character allowed in Applicant detail Name in Assamese',
          ];
          return json_encode($json);
        }   

        $date1 = date_create ($data['ekyc_dob']);
        $date2 = date_create (date('Y-m-d'));
        $diff = date_diff ($date1, $date2);
        $ageLimit = $diff->y;  

        if($ageLimit < MIN_APPLIED_AGE){
          log_message('error', '#ERR563: Applied applicant is having age less than 18');
          $json = [
            'responseType' => 3,
            'message'      => '#ERR563: You are not eligible to apply for this service. Your age must be or greater than 18.',
          ];
          return json_encode($json);
        }   
    }

    public function selectedJointAppl()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $json  = null;

        $base_url   = $_POST['baseurl'];
        $case_no    = $_POST['case_no'];
        $sel_appl_id= isset($_POST['sel_appl'])?$_POST['sel_appl']:0;
        // var_dump($_POST);die;



        if($sel_appl_id != 0)
        {
            //update settlement basic for selected applicant
            $query = $this->db->query("UPDATE settlement_applicant SET ekyc_done=? WHERE case_no=? AND id=? AND pdar_type=? AND is_applicant=?", array(1, $case_no, $sel_appl_id, 'B', 0));
            // echo $this->db->last_query(); die;

            if($this->db->affected_rows() != 1)
            {
                log_message('error', '#ERR863: Updation failed '.$this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR563: eKyc failed for case no '.$case_no,
                ];
                echo json_encode($json);
                return;
            }
        }        

        $json = [
            'responseType' => 1,
            'message'      => '#SUCC890: Successfull',
        ];
        echo json_encode($json);
        return;
    }

    


}

