<?php
class ReclassSuiteControllerAst extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //ob_start();
        $this->load->model('basundhara/SettlementApiModel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        // $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');

        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('basundhara3/reclassModel');

        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }


    public function printNotice(){
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
        // reading the base64 json file and saving it to a variable

        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_notice_link']);
        if($path == false){
            echo 'No data found!';
            return;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];
        $data['_view'] = 'SettlementView/Co/PrintNotice';
        $this->load->view('layouts/main',$data);
    }

    public function saveNotice(){
        $case_no = $this->input->post('case_no');
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH.$new_case_no.".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $remark_co = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $district = $this->input->post('district');
        $sub_division = $this->input->post('sub_division');
        $circle = $this->input->post('circle');
        $lot_no = $this->input->post('lot_no');
        $mouza = $this->input->post('mouza');
        $village = $this->input->post('village');
        // $petitioner_name = $this->input->post('petitioner_name');
        // $g_name = $this->input->post('g_name');
        // $dag_name = $this->input->post('dag_name');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');
        // $data = [
        //    'case_no' => $case_no,
        //    'remark' => $remark,
        //    'get_settlement_basic' => $get_settlement_basic,
        //    'get_dag_details' => $get_dag_details,
        //    'get_settlement_applicant' => $get_settlement_applicant,
        // ];
        $this->db->trans_begin();
        $updateArr = [
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            //  'notice_generated_date' => date('Y-m-d h:i:s'),
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $base_64_file_path
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if($this->db->affected_rows() == 0 ){
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0001: Failed to generate notice. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }
        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $remark_co,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Payment Notice Generated'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0002: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            return $data;
            exit;
        }else{
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;
            //   payment request API
            $status = $this->SettlementMbModel->paymentRequest($rtps_case_no,$amount);
            //   USER END STATUS API CALLING
            //   $user_status_api = $this->SettlementApiModel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if($status === false || $status === 0){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again $case_no"
                );
                return $data;
                exit;
            }
            //   API CALL END HERE
            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type' => 'PN'
            )));
            $result = curl_exec($curl_handle);
            if(!$result){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                return $data;
                exit;
            }else{


                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementMbCo/generatePaymentNoticeCo?case='.$case_no);
            }
        }
    }

    // public function reclassNoticeGenertaedCases(){
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $chitha_data['cases'] = $this->db->query("
    //         SELECT * FROM reclass_suite_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code' AND service_code = '40' AND pending_officer = 'AST'")->result();

    //     $chitha_data['select_data'] = $this->reclassModel->reclassNoticeCases();
    //     $chitha_data['_view'] = 'settlement_mb/co_print_notice_cases';

    //     $this->load->view('layouts/main', $chitha_data);
    // }

    public function reclassNoticeGenertaedCases() {
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $cases = $this->db->query("SELECT ba.basundhara,rsb.* FROM reclass_suite_basic rsb join basundhar_application ba on ba.dharitree=rsb.case_no WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code' AND service_code = '40' AND pending_officer = 'AST' and status ='A' and notice_generated_yn is null and next_date_of_hearing is not null and note_action_yn is null")->result();

        $data['cases'] = $cases;
        $data['_view'] = 'reclass_suite/AST/reclassAstNotice';
        $this->load->view('layouts/main',$data);
    }

    public function settlementApAst()
    {
        $application_no = $this->input->get('case');

        $lmdata['state'] = $this->input->get('state');
        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementApModel->getAllApplicantEncroacher($application_no);
        $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);

        $dags = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($application_no);
        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
            $lmdata['lm_report'] ="no";
        }else{
            $lmdata['lm_report'] ="yes";
        }

        $lmdata['basic']=$basic;
        $lmdata['nominee'] = $nominee;
        $lmdata['reservation']=$reservation;
        $lmdata['applicants_buyers']=$applicants_buyers;
        $lmdata['applicants_owners']=$applicants_owners;
        $lmdata['applicants_encroacher']=$applicants_encroacher;

        $lmdata['dags']=$dags;
        $lmdata['lmnotes']=$lmnotes;
        $lmdata['proceedings']=$proceedings;
        $lmdata['dhardocuments']=$dhardocuments;

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;

        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);

        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        foreach($output->selfDeclaration as $selfDec)
        {
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }


        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        $url = API_LINK_MB2."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $applid,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if($aadhaarPhotoReCall == true)
                        {
                            $aadhar_path = $adhar_photo_link;
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $aadhaarPhotoReCall;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }
                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                endif;
            endif;
        endforeach;


        $lmdata['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);


        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

        if(trim($headQtrCheck) != 'Y')
        {
            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
            if(trim($sdoCheckResult) == 'y')
            {
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }

        $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($application_no));

        if($sql->num_rows() > 0){
            $areaModificationCheck = $sql->result();
        }
        else
        {
            return false;
        }

        if(isset($areaModificationCheck)){
            if($areaModificationCheck){
                foreach($areaModificationCheck as $areaHis){
                    $nr_bigha = $areaHis->nr_bigha;
                    $nr_katha = $areaHis->nr_katha;
                    $nr_lessa = $areaHis->nr_lessa;
                    $nr_ganda = $areaHis->nr_ganda;
                    $nr_kranti = $areaHis->nr_kranti;

                    $s_dag_area_b = $areaHis->s_dag_area_b;
                    $s_dag_area_k = $areaHis->s_dag_area_k;
                    $s_dag_area_lc = $areaHis->s_dag_area_lc;
                    $s_dag_area_g = $areaHis->s_dag_area_g;
                    $s_dag_area_kr = $areaHis->s_dag_area_kr;

                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($nr_bigha, $nr_katha, $nr_lessa, $nr_ganda);
                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc, $s_dag_area_g);
                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda))
                        {
                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($nr_bigha, $nr_katha, $nr_lessa);
                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa))
                        {
                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }


        // $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

        // $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        // $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        // $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        // $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        // $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];
        // $lmdata['newDag']= $checkAreaDetails['newDag'];

        $user_desig_code = $this->session->userdata('user_desig_code');
        // if($user_desig_code == 'SK')
        // {
        //     $this->utilityclass->checkUserAuthForCaseForSk($application_no);
        // }
        // else
        // {
        //     $this->utilityclass->checkUserAuthForCaseForCo($application_no);
        // }

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);


        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }
        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $lmdata['validation_bypass'] = 0;

        foreach($lmdata['lmnotes'] as $lm_rr)
        {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

            if($decoded_r){
                foreach($decoded_r as  $lm_rejected_code)
                {
                    if(isset($lm_rejected_code->reject_code))
                    {
                        if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    else
                    {
                        if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    
                }
            }
           
        }

        $lmdata['reject_list_type'] = '';

        foreach($lmnotes as $r_remark)
        {
            $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

            if($rejected_list_json)
            {
                foreach ($rejected_list_json as $re_list) {

                    if(isset($re_list->reject_code))
                    {
                        $r_code = $re_list->reject_code;
                    }
                    else
                    {
                        $r_code = $re_list;
                    }

                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));
    
                    if($sql->row()->remark_head != null)
                    {
                        $lmdata['reject_list_type'] = 'new';
                    }
                    else
                    {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }


        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        $lmdata['_view'] = 'SettlementView/SettlementApAstView';
        $this->load->view('layouts/main',$lmdata);
    }

    public function decodeBase64($encoded_string){
      $file_data= base64_decode($encoded_string);
      $file = finfo_open();
      $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
      $file_type = explode('/', $mime_type)[0];
      $extension = explode('/', $mime_type)[1];
      log_message("error","No error occured".json_encode($mime_type));
      return $mime_type;
  }

  public function generateNotice(){

    // to print notice
    // if(isset($_POST['print_notice'])){
    //     $case_no = $this->input->post('case_no');
    //     // getting the notice file link
    //     $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
    //     // reading the base64 json file and saving it to a variable
    //     $open_notice_file = fopen($data['print_data']['co_app_notice_link'], "r") or die("Unable to open file!");
    //     $read_notice_file = fread($open_notice_file,filesize($data['print_data']['co_app_notice_link']));
    //     fclose($open_notice_file);
    //     // decoding the base64 encoding file variable
    //     $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
    //     $data = [
    //         'base64_decoded_notice_file' => $base64decoded_notice_file,
    //         'case_no' =>$case_no
    //     ];
    //     $data['_view'] = 'SettlementView/AstPrintNotice';
    //     $this->load->view('layouts/main',$data);
    // }

    if(isset($_POST['print_notice'])){
        $case_no = $this->input->post('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);

        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_app_notice_link']);
        if($path == false){
            echo 'No data found!';
            return;
        }
        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);
        
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
            'case_no' =>$case_no
        ];

        // if(!file_exists($data['print_data']['co_app_notice_link']))
        // {
        //     $getFile = $this->SettlementCommonModel->callRemoteFile('index.php/DharitreeApi/getRemoteFile',$data['print_data']['co_app_notice_link']);
        //     if ($getFile == true)
        //     {
        //         $open_notice_file = fopen($data['print_data']['co_app_notice_link'], "r") or die("Unable to open file!");
        //         $read_notice_file = fread($open_notice_file,filesize($data['print_data']['co_app_notice_link']));
        //         fclose($open_notice_file);
                
        //         $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        //         $data = [
        //             'base64_decoded_notice_file' => $base64decoded_notice_file,
        //             'case_no' =>$case_no
        //         ];
        //     }
        //     else
        //     {
        //         echo json_encode('#ERR842: Something went wrong!');
        //         return false;
        //     }
        // }
        // else
        // {
        //     $open_notice_file = fopen($data['print_data']['co_app_notice_link'], "r") or die("Unable to open file!");
        //     $read_notice_file = fread($open_notice_file,filesize($data['print_data']['co_app_notice_link']));
        //     fclose($open_notice_file);
            
        //     $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        //     $data = [
        //         'base64_decoded_notice_file' => $base64decoded_notice_file,
        //         'case_no' =>$case_no
        //     ];
        // }

        // $data['_view'] = 'SettlementView/Co/Ap/PrintNotice';
        $data['_view'] = 'SettlementView/AstPrintNotice';
        $this->load->view('layouts/main',$data);
    }

}

  public function ReclassSuiteAst()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'AST') {
            $this->session->set_flashdata('message', "#HOMEC250773 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        $counts['reclassnotice'] = $this->db->query("select count(*) as c from reclass_suite_basic where status ='A' and notice_generated_yn is null and next_date_of_hearing is not null and note_action_yn is null and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='AST'  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;

        $counts['apconotice_generated'] = '';//$this->db->query("select count(*) as c from settlement_basic where status !='D' and ast_notice_print_yn='Y' and notice_generated_yn='Y' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (pending_officer='CO' OR pending_officer='LM')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        $counts['ppp'] = '';//$this->db->query("select count(distinct(a.case_no)) as c from settlement_basic a join settlement_premium b on a.case_no=b.case_no where a.status ='N' and a.chitha_processing_details=2 and b.grn_no is not null and b.is_final=1 and  a.dist_code='$dist_code' and a.subdiv_code='$subdiv_code' and a.cir_code='$cir_code' and a.pending_officer='CO'  and a.date_entry >= '$define_date' and a.service_code='$service_code' ")->row()->c;

        $counts['ProceedingOrder'] = $this->db->query("SELECT count(*) as c from    reclass_suite_basic WHERE status ='A' and notice_generated_yn is not null and notice_generated_date is not null and note_action_yn is null and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='AST'  and date_entry >= '$define_date' and service_code='$service_code'")->row()->c;

        $counts['service_code'] = $service_code;

        $counts['_view'] = 'reclass_suite/AST/reclass_ast';
        $this->load->view('layouts/main', $counts);
    }


    public function NoticeSubmit() {
        //$db=  $this->session->userdata('db');
        $petition_no = $this->input->get('id');
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "select * from    reclass_suite_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'";
        $pb = $data['pb'] = $this->db->query($sql)->row();

        $sql = "SELECT * FROM  reclass_applicant WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and Petition_no = '$pb->petition_no' and is_applicant = 1";
        $data['partition'] = $this->db->query($sql)->result();
        

        $sql = "SELECT * FROM  reclass_dag_details WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code'  and Petition_no = '$pb->petition_no' and is_partition = 'Y'";
        $data['dag'] = $this->db->query($sql)->result();

        foreach($data['dag'] as $dag_row){

            $sql = "SELECT * FROM  Chitha_dag_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$dag_row->patta_no') and patta_type_code = '$dag_row->patta_type_code' and dag_no='$dag_row->dag_no' and (p_flag ='0' or p_flag is null)";
            $dagpattadar = $this->db->query($sql)->result();

            foreach ($dagpattadar as $p) {
                $sql = "SELECT * FROM  Chitha_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                        . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$dag_row->patta_no') and patta_type_code = '$dag_row->patta_type_code' and pdar_id='$p->pdar_id' ";
                //echo $sql;
                $pattadars[] = $this->db->query($sql)->row();
            }

            $dag_row->pattadar_array = $pattadars;

            $sql = "SELECT patta_type as name from    patta_code where type_code='$dag_row->patta_type_code'";
            $patta_name = $this->db->query($sql)->row()->name;

            $dag_row->patta_name = $patta_name;

        }  


        $sql = "Select loc_name as cirname from    location where dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '00' and lot_no='00' and vill_townprt_code='00000'";
        $data['cirname'] = $this->db->query($sql)->row();
        $sql = "SELECT loc_name as mouza FROM  location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='00' and vill_townprt_code='00000'";
        $data['mouza'] = $this->db->query($sql)->row();
        $sql = "SELECT loc_name as vill FROM  location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='$pb->lot_no' and vill_townprt_code='$pb->vill_townprt_code'";
        $data['vill'] = $this->db->query($sql)->row();

        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
        $data['_view'] = 'partition/printpetitioner_kar';
        }
        else{
            $data['_view'] = 'reclass_suite/AST/printpetitioner_reclass';
        }

        $this->load->view('layouts/main',$data);
    }

     public function SaveNotcPetionerReclass() {
         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $case_no = $this->input->post('case_no');

        $this->db->trans_begin();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $pending_officer = 'AST';
        $pending_office = 'CO';

        $updateArr = [
            'notice_generated_yn' => 'Y',
            'notice_generated_date' => date('Y-m-d G:i:s'),
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => $pending_officer,
            'pending_office' => $pending_office,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('reclass_suite_basic', $updateArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO00034343: Failed to forward to CO');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO00034343: Failed to generate Notice. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'note_type' => 'NOTICE',
            'note_on_order' => 'Notice generated by AST',
            'status' => 'A',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => $pending_officer,
            'task' => 'Forwarded to '.$pending_officer,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0004: Failed to generate Notice . Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
            return $data;
            exit;
        } 
        else 
        {

            //////////////POST To basundhara////////////////////

            $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
            // $this->db->trans_rollback();

            $rmk='Forwarded to '.$pending_officer;
            $status='A';
            $task='AST';
            $pen=$pending_officer;
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP2076: Notice Generated for Case no # $case_no failed");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Notice Generated for Case no # $case_no By ".$pending_officer);
                redirect(base_url() . "index.php/home");
                // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
            }
            // $this->load->view('SettlementView/Co/SettlementApTransferred');
        }
    }


    public function getPendingProceeReportReclass() 
    {
        //$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        $cases = $this->db->query("select fmb.*, fmb.case_no as c_no, ba.basundhara
                    from reclass_suite_basic fmb 
                    left join basundhar_application ba on fmb.case_no=ba.dharitree
                    where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
                    and cir_code='$cir_code'
                    and fmb.date_entry>='$define_date' and status ='A' and notice_generated_yn is not null and notice_generated_date is not null and note_action_yn is null
                    order by fmb.petition_no ")->result();
        $data['cases'] = $cases;

        $data['_view'] = 'reclass_suite/AST/NoteactionFirstReclass';
        $this->load->view('layouts/main',$data);
    }

     public function AsstActionTakenReclass() {
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "SELECT * FROM  reclass_suite_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  case_no = " . $this->db->escape($case_no) . "";
        $pb = $data['pb'] = $this->db->query($sql)->row();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_name = $this->utilityclass->getDistrictName($pb->dist_code);
        $data['NameDist'] = array('dist' => $dist_name);
        $sql = "SELECT MIN(next_date_of_hearing) as stdate FROM  reclass_suite_basic  Where case_no=" . $this->db->escape($case_no) . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $data['stdate'] = $this->db->query($sql)->row();
        $sql = "SELECT MAX(next_date_of_hearing) as endate FROM  Petition_Proceeding Where case_no=" . $this->db->escape($case_no) . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['endate'] = $this->db->query($sql)->row();
        $q = "Select * from    settlement_proceeding where case_no=" . $this->db->escape($case_no) . " ";

        $data['pd'] = $this->db->query($q)->result();

        $data['_view'] = 'reclass_suite/AST/NoteactionSecReclass';
        $this->load->view('layouts/main',$data);
    }

     public function uploadSupportiveDocsReclass()
    {
        // XSS Validation START
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        
        if($errorMessageStr != ''){
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $val = $this->input->post();
        $case_no = $val['case_no'];
        $flag = $val['flag'];
        $dist_code = $this->session->userdata('dist_code');//$val['dist_code'];
        $doc1 = isset($val['doc1']) ? $val['doc1'] : '';

        $val = explode('/',$case_no);
        $petition_no = $val[3];        

        if($val[4]=='RECLS'){
            $folder = UPLOAD_DIR . $dist_code . UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM reclass_suite_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if ($petition_no == null || $petition_no == '' || empty($petition_no))
        {
            $validation['img_upload'] = false;
            echo json_encode($validation);
            return;
        }

        $name = (($flag==1)?'doc1_file':(($flag==2)?'doc2_file':'null'));
        $sl = (($flag==1)?'1':(($flag==2)?'2':'3'));
        $file_name = (($flag==1)?$doc1:(($flag==2)?$doc2:$doc3));
        

        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;

        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        } 
        //echo $path;       
        $config = [
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        ];
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        $validation=null;
        //log_message('error',json_encode($_FILES[$name]['size']));
        if(!$checkFileExt){
            $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
        }
        else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
        {
            $validation['error'][] = array('message' => ' Larger file size selected.');
        }
        else
        {   
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND user_code=? and doc_flag= ? ",array($case_no, $this->user_code,$flag))->num_rows();
           // var_dump($count);
           //  exit;

            if($count == 0)
            {
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'file_name' => $file_name,
                        'user_code' => $this->user_code,
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => RECLASS_ID,
                        'doc_flag'=>$flag
                    ];
                    $ins = $this->db->insert('supportive_document', $img);
                    if($ins == true)
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                    else
                    {
                        $validation['img_upload'] = false;
                    }
                }//end do upload
                else{
                    $validation['img_upload'] = false;
                }
            }// end count if

            else { //overwrite previous one

                $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? and doc_flag= ?", array($case_no,$flag))->row()->file_path;
                // echo $file;
                // exit;
                unlink($file);
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $overwrite = [
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => RECLASS_ID,
                        'file_name'=>$file_name
                    ];
                    $this->db->where(['case_no'=>$case_no, 'doc_flag'=>$flag, 'user_code'=>$this->user_code]);
                    $this->db->update('supportive_document', $overwrite);
                    if($this->db->affected_rows() != 1)//if no updation made
                    {
                        $validation['img_upload'] = false;   
                    }
                    else
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND doc_flag=?", array($case_no, $flag))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                }
            }
        }
        echo json_encode($validation);        
    }


    public function SaveNoteofActionReclass() {
         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');

        if($remark==null)
        {
            $data = array(
                'msg' => "Remark for Case not provided. [##ERRRECL1065]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##ERRRECL1065. Remark for Case no not provided: " . $case_no);
            echo json_encode($data);
            return;
        }

        $this->db->trans_begin();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $pending_officer = 'CO';
        $pending_office = 'CO';

        $updateArr = [
            'status'=>'S',
            'note_action_yn' => 'Y',
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => $pending_officer,
            'pending_office' => $pending_office
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('reclass_suite_basic', $updateArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            $data = array(
                'msg' => "Update failed for Case. [##ERRRECL1097]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##ERRRECL1097. Update failed for Case: " . $case_no);
            echo json_encode($data);
            return;
        }

        

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'note_type' => 'NOTE of Action',
            'note_on_order' => $remark,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => $pending_officer,
            'task' => 'Forwarded to '.$pending_officer,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            $data = array(
                'msg' => "Insertion failed for Case. [##ERRRECL1132]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##ERRRECL1132. Insertion failed for Case: " . $case_no);
            echo json_encode($data);
            return;
        }
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
            return $data;
            exit;
        } 
        else 
        {

            //////////////POST To basundhara////////////////////

            $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
            // $this->db->trans_rollback();

            $rmk='Forwarded to '.$pending_officer;
            $status='W';
            $task='AST';
            $pen=$pending_officer;
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $data = array(
                'msg' => "API Update failed for Case. [##ERRRECL1166]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##ERRRECL1170. API Update failed for Case: " . $case_no);
            echo json_encode($data);
            return;
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata("message", "Note of action for Case.: " . $case_no . " Given !!");
                $data = array(
                    'msg' => "Note of action for Case " . $case_no . " Given !!",
                    'error' => false,
                    'url' => base_url().'index.php/home',
                );
                echo json_encode($data);
                return;
            }
        }
    }


}
