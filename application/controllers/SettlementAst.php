<?php
class SettlementAst extends CI_Controller
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

    public function apNoticeGenertaedCases(){


        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code' AND service_code = '14' AND (pending_officer = 'CO' or pending_officer = 'LM')")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->apNoticeCases();
        $chitha_data['_view'] = 'settlement_mb/co_print_notice_cases';

        $this->load->view('layouts/main', $chitha_data);
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




}
