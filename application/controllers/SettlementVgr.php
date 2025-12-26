<?php
class SettlementVgr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->dbswitch();


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }

    public function dbswitch(){
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


    public function vgrPgrAreaCheck(){
        return false;
    }

    public function reserveMoreThanAppArea(){
        return false;
    }

    public function familyMoreThanAppArea(){
        return false;
    }

    public function totalAppliedAreaZeroCheck(){
        return false;
    }

    public function appAreaMoreThanDagA(){
        return false;
    }

    public function vgrMaxHomestead(){
        return false;
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

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function getValidationBypass($service_code)
    {
        if(!$service_code)
        {
            return false;
        }

        foreach(json_decode(VALIDATION_BYPASS) as $cons_reasons)
        {
            if($cons_reasons->SERVICE_CODE == $service_code)
            {
                $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
            }
        }
        return $validation_bypass_array;
    }

    function applicationVgrRegistration($review_flag =false)
    {
        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();
        
        $this->dbswitch();

        $application_no = $this->input->get('app');
        $application_no = $this->utilityclass->decryptJwtCase($application_no);

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

        if($supportive_document_sql->num_rows() > 0){
            $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
        }else{
            $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }

        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if(!$recordExist)
        {

            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'api_key' => API_KEY,
                'token' => $token
            )));
            $output = curl_exec($curl_handle);
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType == 3){
                    echo json_decode($output)->data." - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);

            //******strating the insertation transaction */
            $this->db->trans_begin();

            $case_name=$this->SettlementApiModel->genearteCaseName();
            if(empty($case_name)){
                $data=array(
                    'error'=>"Network Issue or Seesion Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }

            //*******************Creating petition no and case_no */
            $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_PGR_VGR_LAND;

            //******************insertion in settlement_json_backup(LM) */
            $backup_array = [
                'applid' => $application_no,
                'case_no' => $case_no['case_no'],
                // 'from_office' => '',
                // 'to_office' => '',
                'status' => 'I',
                // 'phase' => '',
                'data' => $backup
            ];
            $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
            if($backup_insertion != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //*************insertion into settlement_additional_property */
            $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($application_no));
            if($checkAdditionalProperty->num_rows() == 0){
                if(isset($output->property)) {
                    foreach($output->property as $value) {
                        $add_property = array(
                            'case_no'             => $case_no['case_no'],
                            'dist_code'           => $value->dist_code,
                            'subdiv_code'         => $value->subdiv_code,
                            'cir_code'            => $value->cir_code,
                            'mouza_pargona_code'  => $value->mouza_pargona_code,
                            'lot_no'              => $value->lot_no,
                            'vill_townprt_code'   => $value->vill_townprt_code,
                            'bigha'               => $value->bigha,
                            'katha'               => $value->katha,
                            'lessa'               => $value->lessa,
                            'chatak'              => $value->lessa,
                            'ganda'               => $value->ganda,
                            'kranti'              => $value->kranti,
                            'entry_date'          => date('Y-m-d h:i:s'),
                            'is_rural'            => $value->is_rural,
                            'dag_no'              => $value->dag_no,
                            'patta_no'            => $value->patta_no,
                            'service_id'          => SETTLEMENT_PGR_VGR_LAND_ID,
                            'applied_flag'        => CITIZEN,
                            'dist_name'           => trim($value->dist_name),
                            'cir_name'            => trim($value->cir_name),
                            'vill_name'           => trim($value->vill_name),
                            'applid'              => $application_no,
                        );
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            //*******insertion into settlement_basic */
            foreach($output->settlements as $settlementsInsertion)
            {
                if($settlementsInsertion->is_applicant == 1)
                {
                    //*********protected_category/tribe_category */
                    if(isset($settlementsInsertion->tribe_category))
                    {
                        if($settlementsInsertion->tribe_category || $settlementsInsertion->tribe_category == '' || $settlementsInsertion->tribe_category == 0)
                        {
                            $protected_class = $settlementsInsertion->tribe_category;
                        }
                        else
                        {
                            $protected_class = 0;
                        }
                    }
                    else
                    {
                        $protected_class = 0;
                    }

                    //***********applicant_occupation */
                    $applicant_occupation = $settlementsInsertion->applicant_occupation;
                    $caste_category = $settlementsInsertion->caste_category;
                    $applied_scheme = $settlementsInsertion->applied_scheme;
                    $tribal_belt = $settlementsInsertion->under_tribe_belts;

                }
            }

            //****bhumiputra condition prepare for insertation */
            if(!empty($output->bhumi['0'])) {
                if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                    $bhumiputra_confirmation     = 'YES';
                    $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'CERT';
                }
                else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                    $bhumiputra_confirmation     = 'YES';
                    $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'ACK';
                }
                else {
                    $bhumiputra_confirmation     = '0';
                    $bhumiputra_certificate_no   = '0';
                    $bhumiputra_certificate_type = '0';
                }
            }
            else {
                $bhumiputra_confirmation     = '0';
                $bhumiputra_certificate_no   = '0';
                $bhumiputra_certificate_type = '0';
            }

            //********settlement_basic insertation */
            $basic=array(
                'dist_code'                     => $output->application->dist_code,
                'subdiv_code'                   => $output->application->subdiv_code,
                'cir_code'                      => $output->application->cir_code,
                'mouza_pargona_code'            => $output->application->mouza_code,
                'lot_no'                        => $output->application->lot_no,
                'vill_townprt_code'             => $output->application->village_code,
                'service_code'                  => $output->application->service_code,
                'ref_no'                        => $output->application->ref_no,
                'case_no'                       => $case_no['case_no'],
                'trans_code'                    => 'F',/////////full
                'petition_no'                   => $case_no['petition_no'],
                'year_no'                       => date('Y'),
                'date_entry'                    => date('Y-m-d G:i:s'),
                'status'                        =>'Z',
                'user_code'                     => $this->session->userdata('user_code'),
                'submission_date'               => date('Y-m-d G:i:s'),
                'from_office'                   => 'API',
                'pending_officer'               => 'LM',
                'pending_office'                => 'CO',
                'tribal_belt'                   => $tribal_belt,
                'occupation_applicant'          => $applicant_occupation,
                'applid'                        => $output->application->application_no,
                'caste'                         => $caste_category,
                'uuid'                          => $output->application->uuid,
                'protected_class'               => $protected_class,
                'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                'applied_scheme'                => $applied_scheme
            );

            $insSetBasic = $this->db->insert('settlement_basic', $basic);

            if ($insSetBasic != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                $data = array(
                    'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            //*********creating the cron number for applicant */
            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '$c_n'";
            $result = $this->db->query($sql)->row();
            if($result == true)
            {
                $cron_no = (int)$result->pdar_cron_no + 1;
            }
            else
            {
                $cron_no = 1;
            }

            //**********fetching aadhaar from API */
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);

            //***********inserting settlement_applicant(Buyers) */
            foreach($output->applicants as $settlementAppInsert){

                if ($get_aadhaar_photo != 'n' && $settlementAppInsert->is_applicant == '1') {
                    $timestamp = date('mdYhis', time()).uniqid();
                    $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                    // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                    $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                    $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                    $aadhaar_encoded_file = $get_aadhaar_photo;
                    fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                    fclose($aadhaar_file_to_write_base64);
                }else{
                    $aadhar_path = '';
                }
                if($output->aadhar->type == 'AADHAAR'){
                    $identity_ref_no = $output->aadhar->aadhaar_no;
                }else{
                    $identity_ref_no = $output->aadhar->pan_no;
                }

                $applicant=array(
                    'dist_code'             => $output->application->dist_code,
                    'subdiv_code'           => $output->application->subdiv_code,
                    'cir_code'              => $output->application->cir_code,
                    'mouza_pargona_code'    => $output->application->mouza_code,
                    'lot_no'                => $output->application->lot_no,
                    'vill_townprt_code'     => $output->application->village_code,
                    'user_code'             => $this->session->userdata('user_code'),
                    'case_no'               => $case_no['case_no'],
                    'petition_no'           => $case_no['petition_no'],
                    'operation'             => 'E',
                    'dag_no'                => 0,
                    'patta_no'              => 0,
                    'patta_type_code'       => 0,
                    'year_no'               => date('Y'),
                    'date_entry'            => date('Y-m-d'),
                    'pdar_id'               => -1,
                    'pdar_cron_no'          => (int) $cron_no++,
                    'pdar_name'             => $settlementAppInsert->name_ass,
                    'eng_pdar_name'         => $settlementAppInsert->name_eng,
                    'pdar_guardian'         => $settlementAppInsert->gurdian_name_ass,
                    'eng_pdar_guardian'     => $settlementAppInsert->gurdian_name_eng,
                    'pdar_rel_guar'         => $settlementAppInsert->gurdian_relation_id,
                    'pdar_gender'           => $settlementAppInsert->gender,
                    'pdar_add1'             => $settlementAppInsert->pre_add,
                    'pdar_add2'             => $settlementAppInsert->per_add,
                    'pdar_mobile'           => $settlementAppInsert->mobile,
                    'pdar_type'             => $settlementAppInsert->pdar_type,
                    'is_applicant'          => $settlementAppInsert->is_applicant,
                    'identity_ref_no'       => $identity_ref_no,
                    'identity_type'         => $output->aadhar->type,
                    'identity_doc_link'     => $aadhar_path,
                    'dob'                   => $settlementAppInsert->dob,
                    'marital_status'        => $settlementAppInsert->marital_status
                );

                $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);

                if($insSetApplicant != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }
          
            //************inserting settlement_applicant(Encroacher) */
            foreach($output->encroachers as $enc_applicant){
                $encroacher_app=array(
                    'dist_code'                => $output->application->dist_code,
                    'subdiv_code'              => $output->application->subdiv_code,
                    'cir_code'                 => $output->application->cir_code,
                    'mouza_pargona_code'       => $output->application->mouza_code,
                    'lot_no'                   => $output->application->lot_no,
                    'vill_townprt_code'        => $output->application->village_code,
                    'user_code'                => $this->session->userdata('user_code'),
                    'case_no'                  => $case_no['case_no'],
                    'petition_no'              => $case_no['petition_no'],
                    'operation'                => 'E',
                    'dag_no'                   => $enc_applicant->dag_no,
                    'patta_no'                 => $enc_applicant->patta_no,
                    'patta_type_code'          => $enc_applicant->patta_code,
                    'period_possession'        => $enc_applicant->possession_date,
                    'year_no'                  => date('Y'),
                    'date_entry'               => date('Y-m-d'),
                    'pdar_name'                => $enc_applicant->name_ass,
                    'pdar_guardian'            => $enc_applicant->gurdian_name_ass,
                    'pdar_rel_guar'            => '0',
                    'pdar_cron_no'             => (int) $cron_no++,
                    'pdar_id'                  => -1,
                    'pdar_type'                => 'EN',
                    'enc_id'                   => $enc_applicant->encroacher_id
                );
                $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                if($insSetEncroacher != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }

            //********inserting settlement_dag_details */
            foreach ($output->encroachers as $dags) {
                $district['class']=$this->utilityclass->getPattaTypeNo($output->application->dist_code, $output->application->subdiv_code, $output->application->cir_code, $output->application->mouza_code, $output->application->lot_no, $output->application->village_code, $dags->dag_no);

                $enc_home_bigha = $dags->mbigha;
                $enc_home_katha = $dags->mkatha;
                $enc_home_lessa = $dags->mlessa;
                $enc_home_ganda = $dags->mganda;
                $enc_home_kranti = $dags->mkranti;

                $enc_agri_bigha = $dags->agri_bigha;
                $enc_agri_katha = $dags->agri_katha;
                $enc_agri_lessa = $dags->agri_lessa;
                $enc_agri_ganda = $dags->agri_ganda;
                $enc_agri_kranti = $dags->agri_kranti;

                $encroachment_area = [
                    'homestead' => [
                        'bigha' => $enc_home_bigha,
                        'katha' => $enc_home_katha,
                        'lessa' => $enc_home_lessa,
                        'ganda' => $enc_home_ganda,
                        'kranti' => $enc_home_kranti,
                    ],

                    'agriculture' => [
                        'bigha' => $enc_agri_bigha,
                        'katha' => $enc_agri_katha,
                        'lessa' => $enc_agri_lessa,
                        'ganda' => $enc_agri_ganda,
                        'kranti' => $enc_agri_kranti,
                    ],
                ];

                $fmd=array(
                    'dist_code'             => $output->application->dist_code,
                    'subdiv_code'           => $output->application->subdiv_code,
                    'cir_code'              => $output->application->cir_code,
                    'mouza_pargona_code'    => $output->application->mouza_code,
                    'lot_no'                => $output->application->lot_no,
                    'vill_townprt_code'     => $output->application->village_code,
                    'user_code'             => $this->session->userdata('user_code'),
                    'date_entry'            => date('Y-m-d'),
                    'case_no'               => $case_no['case_no'],
                    'petition_no'           => $case_no['petition_no'],
                    'year_no'               => date('Y'),
                    'new_land_class_code'   => $district['class']->land_class_code,
                    'dag_no'                => $dags->dag_no, 
                    'patta_no'              => $dags->patta_no, 
                    'patta_type_code'       => $dags->patta_code,  
                    'is_urban'              => $output->application->is_urban,
                    'land_type'             => $dags->land_type,
                    'revenue'               => 0,
                    'operation'             => 'E',
                    'encroachement_area'    => json_encode($encroachment_area)
                );

                $fmd['dag_area_b']=$dags->applied_bigha;
                $fmd['dag_area_k']=$dags->applied_katha;
                $fmd['dag_area_lc']=$dags->applied_lessa;
                $fmd['dag_area_g']=$dags->applied_ganda;
                $fmd['dag_area_kr']=$dags->applied_kranti;

                $fmd['home_b']=$dags->mbigha;
                $fmd['home_k']=$dags->mkatha;
                $fmd['home_lc']=$dags->mlessa;
                $fmd['home_g']=$dags->mganda;
                $fmd['home_kr']=$dags->mkranti;

                $fmd['agri_b']=$dags->agri_bigha;
                $fmd['agri_k']=$dags->agri_katha;
                $fmd['agri_lc']=$dags->agri_lessa;
                $fmd['agri_g']=$dags->agri_ganda;
                $fmd['agri_kr']=$dags->agri_kranti;


                //************Total Area Calculation -js- ******************
                if (in_array($output->application->dist_code, json_decode(BARAK_VALLEY))){
                    //******for Barak valley */
                    $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
                }

                $fmd['s_dag_area_b'] = $totalAreaArr[0];
                $fmd['s_dag_area_k'] = $totalAreaArr[1];
                $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                $fmd['s_dag_area_g'] = $totalAreaArr[3];
                $fmd['s_dag_area_kr'] = 0;

                $rezaHome = $fmd['home_b'] + $fmd['home_k'] + $fmd['home_lc'] + $fmd['home_g'] + $fmd['home_kr'];
                $rezaAgri = $fmd['agri_b'] + $fmd['agri_k'] + $fmd['agri_lc'] + $fmd['agri_g'] + $fmd['agri_kr'];

                $landTypeUpdate = 0;
                if($rezaHome > 0 && $rezaAgri > 0)
                {
                    $landTypeUpdate = 3;
                }
                else if($rezaHome > 0  )
                {
                    $landTypeUpdate = 1;
                }
                else if($rezaAgri > 0)
                {
                    $landTypeUpdate = 2;
                }

                $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                // log_message('error',$this->db->last_query());
                if ($insSetDag != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //*******insertion in settlement_area_history**************
                if (in_array($output->application->dist_code, json_decode(BARAK_VALLEY))){
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************


                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

                }
                else
                {
                    //********actual Encroachment area********** 
                    $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************

                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                }

                $settlementAreaHistoryArr = [
                    'application_no'                        => $application_no,
                    'case_no'                               => $case_no['case_no'],
                    'dag_no'                                => $dags->dag_no,
                    'uuid'                                  => $output->application->uuid,
                    'created_at'                            => date('Y-m-d'),
                    'applied_area_home_bigha'               => $dags->mbigha,
                    'applied_area_home_katha'               => $dags->mkatha,
                    'applied_area_home_lessa'               => $dags->mlessa,
                    'applied_area_home_ganda'               => $dags->mganda,
                    'applied_area_home_kranti'              => $dags->mkranti,
                    'applied_area_agri_bigha'               => $dags->agri_bigha,
                    'applied_area_agri_katha'               => $dags->agri_katha,
                    'applied_area_agri_lessa'               => $dags->agri_lessa,
                    'applied_area_agri_ganda'               => $dags->agri_ganda,
                    'applied_area_agri_kranti'              => $dags->agri_kranti,
                    'actual_encroachment_area_home_bigha'   => $enc_home_bigha,
                    'actual_encroachment_area_home_katha'   => $enc_home_katha,
                    'actual_encroachment_area_home_lessa'   => $enc_home_lessa,
                    'actual_encroachment_area_home_ganda'   => $enc_home_ganda,
                    'actual_encroachment_area_home_kranti'  => $enc_home_kranti,
                    'actual_encroachment_area_agri_bigha'   => $enc_agri_bigha,
                    'actual_encroachment_area_agri_katha'   => $enc_agri_katha,
                    'actual_encroachment_area_agri_lessa'   => $enc_agri_lessa,
                    'actual_encroachment_area_agri_ganda'   => $enc_agri_ganda,
                    'actual_encroachment_area_agri_kranti'  => $enc_agri_kranti,
                    'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
                    'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
                    'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
                    'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
                    'total_actual_encroachment_area_kranti' => 0,
                    'settlement_area_home_bigha'            => $fmd['home_b'],
                    'settlement_area_home_katha'            => $fmd['home_k'],
                    'settlement_area_home_lessa'            => $fmd['home_lc'],
                    'settlement_area_home_ganda'            => $fmd['home_g'],
                    'settlement_area_home_kranti'           => $fmd['home_kr'],
                    'settlement_area_agri_bigha'            => $fmd['agri_b'],
                    'settlement_area_agri_katha'            => $fmd['agri_k'],
                    'settlement_area_agri_lessa'            => $fmd['agri_lc'],
                    'settlement_area_agri_ganda'            => $fmd['agri_g'],
                    'settlement_area_agri_kranti'           => $fmd['agri_kr'],
                    'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
                    'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
                    'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
                    'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
                    'total_settlement_area_kranti'          => 0,
                    'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
                    'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
                    'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
                    'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
                    'leftout_area_home_kranti'              => 0,
                    'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
                    'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
                    'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
                    'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
                    'leftout_area_agri_kranti'              => 0,
                    'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0], 
                    'total_leftout_area_katha'              => $totalLeftOutAreaArr[1], 
                    'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2], 
                    'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3], 
                    'total_leftout_area_kranti'             => 0,
                ];

                $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
            
                if ($insertSetlArea != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                } 

                //**************end of settlement_area_history********************
            }

            //******insertion in settlement_nominee */
            if ($output->nextKin == true) {
                foreach ($output->nextKin as $nex_of_kin) {
                    $nominee_data=array(
                        'case_no'=> $case_no['case_no'],
                        'nominee_name' => $nex_of_kin->next_of_kin_name,
                        'address' => $nex_of_kin->address,
                        'mobile_no' => $nex_of_kin->mobile_no,
                        'relation' => $nex_of_kin->relation_with_kin
                    );
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                    if ($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            //********basundhar_application insertation */
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }else{
                //******commit if no errors */
                $this->db->trans_commit();
            }
        }

        //*********fetching data */
        $startTime = microtime(true);
        try
        {
            $lmdata['review_flag'] = false;

            if($review_flag){
                $sql = $this->db->query('select * from settlement_basic where applid = ? and review_flag = ?', array($application_no, $review_flag));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->case_no;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
                $lmdata['review_flag'] = true;

            }else{
                $sql = $this->db->query('SELECT dharitree FROM basundhar_application WHERE basundhara = ?', array($application_no));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->dharitree;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            
            // $this->utilityclass->lmAuthBasic($case_no);
            $this->utilityclass->lmAuthFirstProceeding($case_no);

            //  row_array
            $basic   = $this->SettlementKhasModel->getSettlementBasic($case_no);
            //  result
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->SettlementKhasModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($case_no);
            $nominee = $this->SettlementKhasModel->getAllNomineeDetail($case_no);

            /// premium
            $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $lmdata['premiumData'] = $premiumData;
            /// premium end

            $lmdata['basic']=$basic;
            $lmdata['geo_date']=$geo_date;
            $lmdata['applicants_buyers']=$applicants_buyers;
            $lmdata['applicants_owners']=$applicants_owners;
            $lmdata['applicants_encroacher']=$applicants_encroacher;
            $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

            $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);


            $lmdata['dags']=$dags;
            $lmdata['lmnotes']=$lmnotes;
            $lmdata['proceedings']=$proceedings;
            $lmdata['dhardocuments']=$dhardocuments;
            $lmdata['nominee']=$nominee;

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];

            $lmdata['villagelist']  = $this->SettlementVgrModel->getVillageList($d,$s,$c,$m,$l);

            $uuidSInLot = array();
            foreach($lmdata['villagelist'] as $uuidFrmVill)
            {
                $uuidSInLot[] = $uuidFrmVill->uuid;
            }

            $stringUuidInLot = "'" . implode ( "','", $uuidSInLot ) . "'";

            $curl_handle_uuid = curl_init();
            curl_setopt($curl_handle_uuid, CURLOPT_URL, API_LINK_MB2."totalAppliedAreaByUuids");
            curl_setopt($curl_handle_uuid, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle_uuid, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle_uuid, CURLOPT_POSTFIELDS, http_build_query(array(
                'uuid' => $stringUuidInLot,
            )));
            $output_uuid = curl_exec($curl_handle_uuid);
            curl_close($curl_handle_uuid);
            
            $output_uuid = json_decode($output_uuid);

            if($output_uuid->responseType == 2)
            {
                $village_wise_table = array();

                $sortingAvailableArea = array();

                foreach($output_uuid->data as $vil_uuid)
                {
                    $uuid = $vil_uuid->uuid;
                    $tot_applied_bigha = $vil_uuid->tot_applied_bigha;
                    $tot_applied_katha = $vil_uuid->tot_applied_katha;
                    $tot_applied_lessa = $vil_uuid->tot_applied_lessa;
                    $tot_applied_ganda = $vil_uuid->tot_applied_ganda;
                    $barak_converted_ganda = $vil_uuid->barak_converted_ganda;
                    $brahmaputra_converted_lessa = $vil_uuid->brahmaputra_converted_lessa;

                    //******getting area details from chitha_basic */
                    $getLoc = $this->utilityclass->getLocationFromUUID($vil_uuid->uuid);

                    $sqlQuery = $this->db->query('SELECT dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr FROM chitha_basic WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ?', array($getLoc->dist_code, $getLoc->subdiv_code, $getLoc->cir_code, $getLoc->mouza_pargona_code, $getLoc->lot_no, $getLoc->vill_townprt_code));

                    // echo $this->db->last_query();
                    if($sqlQuery->num_rows() <= 0)
                    {
                        echo json_encode('#ERR343434355: Something went wrong! Contact admin.');
                        return false;
                    }

                    $chithaAreaArray = $sqlQuery->result();


                    if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                        $chitha_total_ganda = 0;
                        foreach($chithaAreaArray as $chithaArea)
                        {
                            $chitha_bigha = $chithaArea->dag_area_b;
                            $chitha_katha = $chithaArea->dag_area_k;
                            $chitha_lessa = $chithaArea->dag_area_lc;
                            $chitha_ganda = $chithaArea->dag_area_g;
                            $chitha_kranti = $chithaArea->dag_area_kr;

                            $chitha_total_ganda += $this->utilityclass->Total_ganda($chitha_bigha, $chitha_katha, $chitha_lessa, $chitha_ganda);
                        }

                        //****this is for barack valley */
                        $bklARR = $this->utilityclass->Total_Bigha_Katha_Lessa2($barak_converted_ganda);
                        $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa2($chitha_total_ganda);

                        //*****availabe area */
                        $total_available_area = (float)$chitha_total_ganda - (float)$barak_converted_ganda;
                        $bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_available_area);
                    }
                    else
                    {

                        $chitha_total_lessa = 0;
                        foreach($chithaAreaArray as $chithaArea)
                        {
                            $chitha_bigha = $chithaArea->dag_area_b;
                            $chitha_katha = $chithaArea->dag_area_k;
                            $chitha_lessa = $chithaArea->dag_area_lc;
                            $chitha_ganda = $chithaArea->dag_area_g;
                            $chitha_kranti = $chithaArea->dag_area_kr;

                            $chitha_total_lessa += $this->utilityclass->Total_Lessa($chitha_bigha, $chitha_katha, $chitha_lessa);
                        }

                        $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa($chitha_total_lessa);
                        $bklARR = $this->utilityclass->Total_Bigha_Katha_Lessa($brahmaputra_converted_lessa);

                        //*****availabe area */
                        $total_available_area = (float)$chitha_total_lessa - (float)$brahmaputra_converted_lessa;
                        $bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa($total_available_area);

                    }

                    $sortingAvailableArea[] = $total_available_area;

                    //***total area applied by applicant */
                    $total_bigha = $bklARR[0];
                    $total_katha = $bklARR[1];
                    $total_lessa = $bklARR[2];
                    $total_ganda = $bklARR[3];

                    //******total chitha area */
                    $total_chitha_bigha = $bklChitha[0];
                    $total_chitha_katha = $bklChitha[1];
                    $total_chitha_lessa = $bklChitha[2];
                    $total_chitha_ganda = $bklChitha[3];

                    //*****total available area */
                    $total_avail_area_bigha = $bklAvailableArea[0];
                    $total_avail_area_katha = $bklAvailableArea[1];
                    $total_avail_area_lessa = $bklAvailableArea[2];
                    $total_avail_area_ganda = $bklAvailableArea[3];

                    //*******Getting chitha area for non applied uuids */
                    foreach($uuidSInLot as $lot_uuid)
                    {
                        $getNonLoc = $this->utilityclass->getLocationFromUUID($lot_uuid);

                        $sqlQueryNon = $this->db->query('SELECT dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr FROM chitha_basic WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ?', array($getNonLoc->dist_code, $getNonLoc->subdiv_code, $getNonLoc->cir_code, $getNonLoc->mouza_pargona_code, $getNonLoc->lot_no, $getNonLoc->vill_townprt_code));

                        // echo $this->db->last_query();
                        if($sqlQueryNon->num_rows() <= 0)
                        {
                            continue;
                            // echo json_encode('#ERR3434343558: Something went wrong! Contact admin.');
                            // return false;
                        }

                        $chithaAreaArrayForNonApplied = $sqlQueryNon->result();

                        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $chitha_total_ganda_non = 0;

                            foreach($chithaAreaArrayForNonApplied as $chithaArea_non)
                            {
                                $chitha_bigha_non = $chithaArea_non->dag_area_b;
                                $chitha_katha_non = $chithaArea_non->dag_area_k;
                                $chitha_lessa_non = $chithaArea_non->dag_area_lc;
                                $chitha_ganda_non = $chithaArea_non->dag_area_g;
                                $chitha_kranti_non = $chithaArea_non->dag_area_kr;
    
                                $chitha_total_ganda_non += $this->utilityclass->Total_ganda($chitha_bigha_non, $chitha_katha_non, $chitha_lessa_non, $chitha_ganda_non);
                            }

                            $bklChitha_non = $this->utilityclass->Total_Bigha_Katha_Lessa2($chitha_total_ganda_non);
                           
                            if($vil_uuid->uuid != $lot_uuid)
                                $sortingAvailableArea[] = $chitha_total_ganda_non;

                        }
                        else
                        {
                            $chitha_total_lessa_non = 0;
                            foreach($chithaAreaArrayForNonApplied as $chithaArea_non)
                            {
                                $chitha_bigha_non = $chithaArea_non->dag_area_b;
                                $chitha_katha_non = $chithaArea_non->dag_area_k;
                                $chitha_lessa_non = $chithaArea_non->dag_area_lc;
                                $chitha_ganda_non = $chithaArea_non->dag_area_g;
                                $chitha_kranti_non = $chithaArea_non->dag_area_kr;

                                $chitha_total_lessa_non += $this->utilityclass->Total_Lessa($chitha_bigha_non, $chitha_katha_non, $chitha_lessa_non);
                            }

                            $bklChitha_non = $this->utilityclass->Total_Bigha_Katha_Lessa($chitha_total_lessa_non);

                            if($vil_uuid->uuid != $lot_uuid)
                                $sortingAvailableArea[] = $chitha_total_lessa_non;
                        }

                        if(trim($lot_uuid) == trim($vil_uuid->uuid))
                        {
                            $village_wise_table[] = (object)[
                                'vil_uuid' => $vil_uuid->uuid,
                                'vil_name' => $this->utilityclass->getVillageNameByUUID($vil_uuid->uuid),
                                'total_area_in_village' => 'B: '.$total_chitha_bigha.' K: '. $total_chitha_katha.' L: '.$total_chitha_lessa,
                                'total_area_in_village_barak' => 'B: '.$total_chitha_bigha.' K: '. $total_chitha_katha.' L: '.$total_chitha_lessa.' G: '.$total_chitha_ganda,
        
                                'total_applied_area' => 'B: '.$total_bigha.' K: '. $total_katha.' L: '.$total_lessa,
                                'total_applied_area_barak' => 'B: '.$total_bigha.' K: '. $total_katha.' C: '.$total_lessa.' G: '.$total_ganda,
        
                                'total_available_area' => 'B: '.$total_avail_area_bigha.' K: '. $total_avail_area_katha.' L: '.$total_avail_area_lessa,
                                'total_available_area_barak' => 'B: '.$total_avail_area_bigha.' K: '. $total_avail_area_katha.' C: '.$total_avail_area_lessa.' G: '.$total_avail_area_ganda,
                        
                                'avail_in_less_ganda' => $total_available_area,
                                
                            ];
                        }
                        else
                        {
                            $village_wise_table[] = (object)[
                                'vil_uuid' => $lot_uuid,
                                'vil_name' => $this->utilityclass->getVillageNameByUUID($lot_uuid),
                                'total_area_in_village' => 'B: '.$bklChitha_non[0].' K: '. $bklChitha_non[1].' L: '.$bklChitha_non[2],
                                'total_area_in_village_barak' => 'B: '.$bklChitha_non[0].' K: '. $bklChitha_non[1].' L: '.$bklChitha_non[2].' G: '.$bklChitha_non[3],
    
                                'total_applied_area' => '-',
                                'total_applied_area_barak' => '-',
    
                                'total_available_area' => 'B: '.$bklChitha_non[0].' K: '. $bklChitha_non[1].' L: '.$bklChitha_non[2],
                                'total_available_area_barak' => 'B: '.$bklChitha_non[0].' K: '. $bklChitha_non[1].' L: '.$bklChitha_non[2].' G: '.$bklChitha_non[3],
                                'avail_in_less_ganda' => in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)) ? $chitha_total_ganda_non : $chitha_total_lessa_non,
    
                            ];
                        }
                    }
                }
            }

            //****sorting by available area  */

            asort($sortingAvailableArea, SORT_NUMERIC);
            $sortingAvailableArea = array_reverse($sortingAvailableArea, true);

            // arsort($sortingAvailableArea);
            $sorted_final_data = array();

            foreach($sortingAvailableArea as $sortArr)
            {
                foreach($village_wise_table as $vil_tab)
                {
                    if($sortArr == $vil_tab->avail_in_less_ganda)
                    {
                        $sorted_final_data[] = $vil_tab; 
                    }
                }
            }

            $lmdata['villageWiseArr'] = $sorted_final_data;


            // echo "<pre>";
            // var_dump($sorted_final_data);
            // // echo "<pre>";
            // // var_dump($village_wise_table);
            // die;


            if(isset($applicants_encroacher)):
                foreach($applicants_encroacher as $settl_vlb_add_check):
                    $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($application_no, $settl_vlb_add_check->dag_no, $lmdata['basic']['uuid']));

                    if($sqlVlbEntryQuery->num_rows() > 0){
                        $settlement_land_bank_details[] = $sqlVlbEntryQuery->row();

                        $vlb_encroacher_added_check[] = $sqlVlbEntryQuery->row()->dag_no;

                        $sql = $this->db->query("SELECT dag_no, status FROM land_bank_details WHERE id = ?", array($sqlVlbEntryQuery->row()->land_bank_details_id));

                        $land_bank_status[] =  $sql->row();

                    }else{
                        $settlement_land_bank_details[] = false;
                        $vlb_encroacher_added_check[] = false;
                        $land_bank_status[] = false;
                    }
                endforeach;
                if(isset($vlb_encroacher_added_check)):
                    if($vlb_encroacher_added_check):
                        $lmdata['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
                    endif;
                endif;
                if(isset($land_bank_status)):
                    $lmdata['land_bank_status'] = $land_bank_status;
                endif;
                if(isset($settlement_land_bank_details)):
                    $lmdata['settlement_land_bank_details'] = $settlement_land_bank_details;
                endif;
            endif;

            foreach($applicants_encroacher as $encroacher_prem)
            {
                $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
                $lmdata['revenue']=$revenue;
                
            }

            //**************get documents/self-declaration/query from API */
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDeclaration");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'api_key' => API_KEY,
                'token' => $token
            )));
            $output = curl_exec($curl_handle);
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType == 3){
                    echo json_decode($output)->data." - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $output = json_decode($output);


            $lmdata['document']=$output->documents;
            $lmdata['query']=$output->query;
            foreach($output->selfDeclaration as $selfDec){
                $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            foreach($lmdata['applicants_buyers'] as $adhar_photo):
                if($adhar_photo->is_applicant == 1):
                    if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                        $adhar_photo_link = $adhar_photo->identity_doc_link;

                        if(!file_exists($adhar_photo_link))
                        {
                            $url = API_LINK_MB2."getApplicantPhoto";
                            $arrayData =array(
                                    'application_no' => $application_no,
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

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $lmdata['guar_rel'] = $relation_executation->result();
            }

            /// vlb data 
            if(isset($dags)){
                foreach($dags as $vlb_dag){
                    $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($application_no, $vlb_dag->dag_no));

                    if($sqlvlbcheck->num_rows() > 0){
                        $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
                    }
                    else{
                        $vlb_newly_added[] = false;
                    }
                }
                $lmdata['vlb_newly_added'] = $vlb_newly_added;
            }

            /// additional property for LM note
            $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
            if($additional_property->num_rows() > 0){
                $totallesaa=0;
                $totalganda=0;
                foreach($additional_property->result() as $addprop){
                    if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                        $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                        $totalganda = $totalganda+$total_g;
                    }else{
                        $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                        $totallesaa = $totallesaa+$total_l;
                    }

                }
                if(!empty($totallesaa)){
                    $lmdata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $lmdata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $lmdata['additional_property']=$additional_property->result();
                //var_dump($lmdata['additional_property']); die;
            }

            //************check if SK is available*/
            $lmdata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

            if($lmdata['sk_name'] == 'n')
            {
                //************if SK is not available then load CO */
                $lmdata['sk_availability'] = 'n';

                $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            }
            else
            {
                $lmdata['sk_availability'] = 'y';

            }

            $lmdata['case_no'] = $case_no;

            //************dag eligibility */
            $lmdata['dag_count']=count($dags);

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $lmdata['deleted_encroacher'] = $deletedEncArray;

            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $lmdata['deleted_dags'] = $deletedData;

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_PGR_VGR_LAND_ID);
            if($rejected_data == 'n')
            {
                $lmdata['rejected_list'] = false;
            }
            else
            {
                $lmdata['rejected_list'] = $rejected_data;
            }

            $lmdata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            
            $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);	
        }
        catch (Exception $e)
        {
            log_message('ERROR#LM_DATA_FETCH', 'Lm application data fetch...####'. $e);
        }
        finally
        {
            $endTime = microtime(true);
            $timeDiff = $endTime - $startTime;

            if($timeDiff > (float)2){
                log_message('EXECUTION_TIME', $this->router->fetch_class().'->'.$this->router->fetch_method().' # The execution time is : '.$timeDiff);
            }
        }
       

        //********if request_method is not post then view the application */
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $lmdata['_view'] = 'SettlementView/SettlementVgrView';
            $this->load->view('layouts/main', $lmdata);
        }

        //********if request_method is post then submit */
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $caseId = trim($this->input->post('case_no'));
            $sql = $this->db->query('SELECT dharitree,basundhara FROM basundhar_application WHERE dharitree = ?', array($caseId));
            
            if($sql->num_rows() > 0){
                $case_no = $sql->row()->dharitree;
                $application_no = $sql->row()->basundhara;
            }
            else{
                $data = array(
                    'error' => 'ERR221221: Something went wrong! please contact administration!' .$caseId,
                );
                echo json_encode($data);
                return false;
            }

            $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$caseId' and pending_officer !='LM'";
            $dataFound=$this->db->query($sqlCheckExist)->row();
            //echo json_encode($dataFound);
            if($dataFound->c >0){
                $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded to circle office. case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $roadside_comment_check = $this->input->post('roadside_comment_check');

            // $ReservationAreaWithDag = 0;
            $totalReservationArea = 0;
            $totalDagAreaLessaValidation = 0;
            $totalAgrAreaLessaValidation = 0;
            $totalHomeAreaLessaValidation = 0;
            $appAreaMoreThanDagA = 0;
            $reserveMoreThanAppArea = 0;
            $familyMoreThanAppArea = 0;
            $totalRoadSideAreaLessaValidation = 0;
            // $totalFamilyAreaLessaValidation = 0;

            $this->load->library('form_validation');            
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            $distCode = trim($this->input->post('dist_code'));
            if ($distCode == null) {
                redirect(base_url(). 'index.php/basundhara2/settlementCases');
            }
            if ($application_no == null) {
                redirect(base_url(). 'index.php/basundhara2/settlementCases');
            }

             //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_PGR_VGR_LAND_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    { 

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

             //****this validation is required in all cases */
            if($validation_bypass == 1)
            {
                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }
                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }
                }

                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                // $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
                $this->form_validation->set_rules('co_code_reject', 'Select Circle Officer', 'trim|required');
                
                if ($applicants_encroacher == true)
                {
                    foreach ($applicants_encroacher as $enc_applicant)
                    {
                        $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('period_possession'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, '', '');
                    }
                }
            }

            if($validation_bypass == 0)
            {
                //******Geo tag validation */
                $geo_tag_dags = array();
                foreach($lmdata['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";
            
                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($lmdata['dags']);

                if((int)$get_tag_dag_count != (int)$total_dag_count)
                {
                    if(GEO_TAG_ACTIVE_STATUS == 1){
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }
                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }
                }

                $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                // $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
                $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
                $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
                $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
                $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
                $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
                $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
                $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
                $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');


                $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
                $this->form_validation->set_rules('applied_scheme', 'Applied Scheme', 'trim|required');

                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required|greater_than[-1]');
                $this->form_validation->set_rules('litigation', 'Proposed land is under litigation', 'trim|required');
                $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide clone ', 'trim|required');
                $this->form_validation->set_rules('erosion', 'Is Area falls under erosion ', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Proposed land falls under Tribal Belt/ Block', 'trim|required');
                $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
                $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
                $this->form_validation->set_rules('roadside_comment_check', 'Roadside/riverside reservation', 'trim|required');


                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
        
                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');

                

                // $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');

                $this->form_validation->set_rules('re_dereservation', ' Filling of Reservation / De Reservation Proposal', 'trim|required');

                if($this->input->post('re_dereservation') == 'RESERVATION')
                {

                    $sqlReserveCheck = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no ));

                    if($sqlReserveCheck->num_rows() <= 0)
                    {
                        $this->form_validation->set_rules('re_dereservation', 'Vgr Reservation', 'required');
                    }

                    //*******check area settlement_dag_details and settlement_vgr_pgr_area table area similarity */
                    $notValErr = 0;
                    $notValErrR = 0;

                    $dagSql = $this->db->query('select 
                    SUM(d.s_dag_area_b*100 + d.s_dag_area_k*20 + d.s_dag_area_lc) AS total_lessa, 
                    SUM(d.s_dag_area_b*6400 + d.s_dag_area_k*320 + d.s_dag_area_lc*20 + d.s_dag_area_g) AS total_ganda 
                    from settlement_dag_details d where d.case_no = ? GROUP BY d.case_no', array($case_no));

                    if($dagSql->num_rows() <= 0)
                    {
                        $notValErr = 1;
                    }
                    else
                    {
                        $dagLessa = $dagSql->row();
                    }
    
                    $reservSql = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS total_lessa, 
                    SUM(dag_area_b*6400 + dag_area_k*320 + dag_area_lc*20 + dag_area_g) AS total_ganda from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));
                    
                    if($reservSql->num_rows() <= 0)
                    {
                        $notValErrR = 1;
                    }
                    else
                    {
                        $reservLessa = $reservSql->row();
                    }

                    if($notValErr != 1)
                    {
                        if($notValErrR !=1)
                        {
                            if(in_array($distCode, json_decode(BARAK_VALLEY)))
                            {
                                if((float)$dagLessa->total_ganda != (float)$reservLessa->total_ganda)
                                {
                                    $this->form_validation->set_rules('area_mismatch', 'Reservation/De-reservation area should be equal!', 'required');
                                }
                            }
                            else
                            {
                                if((float)$dagLessa->total_lessa != (float)$reservLessa->total_lessa)
                                {
                                    $this->form_validation->set_rules('area_mismatch', 'Reservation/De-reservation area should be equal!', 'required');
                                }
                            }
                        }
                        else
                        {
                            $this->form_validation->set_rules('area_mismatch', 'Unaspected err occured! Contact admin...', 'required');
                        }
                    }
                    else
                    {
                        //*****show error */
                        $this->form_validation->set_rules('area_mismatch', 'Unaspected err occured! Contact admin...', 'required');
                    }
                }

                $this->form_validation->set_rules('roadside_reservation','','');

                if (empty($_FILES['field_report']['name']))
                {
                    $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                }

                $checkUrbanCon = trim($this->input->post('is_urban'));

                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach($lmdata['dags'] as $dags_area)
                    {
                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_area->dist_code, $dags_area->subdiv_code, $dags_area->cir_code, $dags_area->mouza_pargona_code, $dags_area->lot_no, $dags_area->vill_townprt_code, $dags_area->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }

                        if (empty($_FILES['trace_map_copy'.$dags_area->dag_no]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$dags_area->dag_no, 'Trace map document', 'required');
                        }

                        $this->form_validation->set_rules('landmark_east'.$dags_area->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_area->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_area->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_area->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('zonal_valuation_prem'.$dags_area->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                    
                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags_area->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags_area->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags_area->dag_no), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dags_area->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dags_area->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dags_area->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dags_area->dag_no), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'.$dags_area->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dags_area->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dags_area->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dags_area->dag_no), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'.$dags_area->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                        if($roadside_comment_check=='YES')
                        {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_area->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_area->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_area->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_area->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_area->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda'.$dags_area->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti'.$dags_area->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_area->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_area->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_area->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dags_area->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                            {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;


                        }

                    }
                }
                else
                {
                    foreach($lmdata['dags'] as $dags_area)
                    {
                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_area->dist_code, $dags_area->subdiv_code, $dags_area->cir_code, $dags_area->mouza_pargona_code, $dags_area->lot_no, $dags_area->vill_townprt_code, $dags_area->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }

                        if (empty($_FILES['trace_map_copy'.$dags_area->dag_no]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$dags_area->dag_no, 'Trace map document', 'required');
                        }

                        $this->form_validation->set_rules('landmark_east'.$dags_area->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_area->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_area->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_area->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('zonal_valuation_prem'.$dags_area->dag_no, 'Zonal Value', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags_area->dag_no), 0);

                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags_area->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags_area->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dags_area->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dags_area->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dags_area->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dags_area->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dags_area->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dags_area->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation ;
                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome ;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr ;

                        if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;


                        if($roadside_comment_check=='YES')
                        {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_area->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_area->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_area->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_area->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_area->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_area->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_area->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_area->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                            if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                            {
                                $reserveMoreThanAppArea = 1;
                            }

                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                    }
                }

                // new additional property calculation
                $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                        $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }
                else
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }

                // new additional property calculation end here
                // additional file upload validation
                // upload additional files
                if(isset($_FILES['fileUpload']['name'])){
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size
                
                    for($i = 0; $i < $fileCount; $i++)
                    {
                        if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                            $name = $_FILES['fileUpload']['name'][$i];
                            $size = $_FILES['fileUpload']['size'][$i];
        
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $ext  = $exp[1];
        
                            if($name != NULL)
                            {
                                if($ext == NULL)
                                {
                                    // todo error show extension missing
                                    $this->form_validation->set_rules('additional_doc_err','File extension','required');
        
                                }
                                if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                {
                                    // todo error show file allow type not match
                                    $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                                }
                                if($size > UPLOAD_MAX_SIZE)
                                {
                                    // todo error show file size
                                    $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
                                }
                            }
                            else
                            {
                                // todo error show file not nullable
                                $this->form_validation->set_rules('additional_doc_err','File name','required');
                            }
                        }
                        else{
                            $this->form_validation->set_rules('additional_doc_err','File','required');
                        }
                    }
                }
    
                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_katha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa','','');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda','','');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti','','');
                
                // for total applied area set_value in validation error Agriculture
                $this->form_validation->set_rules('total_applied_area_agricultural_bigha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_katha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_lessa','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_ganda','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_kranti','','');
    
                if($reserveMoreThanAppArea == 1)
                {
                    $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area  !', 'required|callback_reserveMoreThanAppArea');
    
                }
    
                if($familyMoreThanAppArea == 1)
                {
                    $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area  !', 'required|callback_familyMoreThanAppArea');
                }
    
                if($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
                }
    
                if($appAreaMoreThanDagA == 1)
                {
                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                }
    
    
                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    if(VGR_PGR_MAX_HOME * 6400 < $totalHomeAreaLessaValidation)
                    {
                        $this->form_validation->set_rules('vgrMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_vgrMaxHomestead');
                    }
    
                    if(VGR_PGR_MAX_HOME * 6400 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. VGR_PGR_MAX_HOME . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed = 1;
                    }

                    // new premium addition
                    if(!empty($this->input->post('area_new'.$dags_area->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_area->dag_no));
                        if(!empty($maxland_check->max_land)){

                            if($maxland_check->max_land =='40'){
                                $maxland_ganda = 2560;
                            }elseif($maxland_check->max_land =='60'){
                                $maxland_ganda = 3840;
                            }

                            if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }

                    }
    
                    // if($checkUrbanCon == 'Y')
                    // {
                    //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                    //     {
                    //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                    //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                    //     }
                    // }
                }
                else
                {
                    if(VGR_PGR_MAX_HOME * 100 < $totalHomeAreaLessaValidation)
                    {
                        $this->form_validation->set_rules('vgrMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_vgrMaxHomestead');
                    }
    
                    if(VGR_PGR_MAX_HOME * 100 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. VGR_PGR_MAX_HOME . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed = 1;
                    }

                    // new premium addition
                    if(!empty($this->input->post('area_new'.$dags_area->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_area->dag_no));
                        if(!empty($maxland_check->max_land)){

                            if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }

                    }else{
                        $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                    }

                    // if($checkUrbanCon == 'Y')
                    // {
                    //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                    //     {
                    //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                    //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                    //     }
                    // }
    
                }

                if($_POST['lm_note'] == '1' && $land_exceed == 1)
                {
                    $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (VGR_PGR_MAX_HOME) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                }

                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_katha', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti', '', '');
    
    
                $enc_count = count($applicants_encroacher);
                $enc_avl_check = 0;
                if ($applicants_encroacher == true)
                {
                    $enc_avl_check = $enc_count;
                    foreach ($applicants_encroacher as $enc_applicant)
                    {
                        if($this->input->post('encroacher_exist_vlb'.$enc_applicant->id) != 4)
                        {
                            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, 'Encroacher exist in VLB', 'trim|required|is_natural');
                            $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, 'Encroachers Dag No.', 'trim|required|is_natural');
                            $this->form_validation->set_rules('period_possession'.$enc_applicant->id, 'Encroachers Period Possession', 'trim|required');
                            $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, 'Encroachers Name', 'trim|required|min_length[3]|max_length[70]');
                            $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, 'Encroachers  Guardian', 'trim|required|min_length[1]|max_length[70]');
                            // $this->form_validation->set_rules('enc_id'.$enc_applicant->id, 'Encroacher Id', 'trim|required|is_natural');
                        }
                        else
                        {
                            $enc_avl_check++;
                            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                            // $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('period_possession'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, '', '');
                        } 
                    }
    
                    if($enc_avl_check != $enc_count)
                    {
                        if($enc_avl_check != ((int)$enc_count * 2))
                        {
                            $this->form_validation->set_rules('encroacher_exist_vlb', '(If you select "Name does not exist and also not in possession" for one Dag then the uneligible dag must be deleted from area details!)', 'required');
                        }
                    }
                }

            }


            if ($this->form_validation->run() == FALSE)
            {
                $lmdata['all_errors'] = validation_errors();
                $lmdata['err_return'] = true;
                if(isset($fileCount)){
                    $lmdata['fileCount'] = $fileCount;
                }
                $lmdata['_view'] = 'SettlementView/SettlementVgrView';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {
                $this->db->trans_begin();

                if ($applicants_encroacher == true)
                {
                    foreach ($applicants_encroacher as $enc_applicant)
                    {

                        $applicant_array = [
                            'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'.$enc_applicant->id)
                        ];

                        $this->db->where('id', $enc_applicant->id);
                        $this->db->where('case_no', $case_no);
                        $this->db->update('settlement_applicant', $applicant_array);

                        if($this->db->affected_rows() <= 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR00112: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                            $data = array(
                                'error'=>"#ERROR00112: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                //*************update in settlement_basic during LM registration */

                $sk_code = null;
                $co_code = null;
                if(trim($lmdata['sk_availability']) == 'y')
                {
                    $pending_officer = 'SK';
                    $sk_code = $this->input->post('co_code');
                }
                else
                {
                    $pending_officer = 'CO';
                    $co_code = $this->input->post('co_code');
                }
                if($validation_bypass == 1)
                {
                    $pending_officer = 'CO';
                    $co_code = $this->input->post('co_code_reject');
                }

                //new premium condition
                
                foreach ($district['encroachers'] as $dag_for_approve) {
                    $dag_arraay[]=$this->input->post('approval'.$dag_for_approve->dag_no);
                    $dag_by_approve = $this->input->post('approval'.$dag_for_approve->dag_no);
                }
                $approved_by =null;
                if ($dag_by_approve !='' || $dag_by_approve !=null )
                {
                    if(count($dag_arraay)==1){
                        $approved_by =$dag_by_approve;
                    }else{
    
                        if(count(array_unique($dag_arraay))<count($dag_arraay)){
                            $approved_by =$dag_by_approve;
                        }else{
                            $approved_by ='GOVT';
                        }
                        
                    }

                }

                $basicData = [
                    'status'          => 'W',
                    'lm_code'         => $this->session->userdata('user_code'),
                    'submission_date' => date('Y-m-d G:i:s'),
                    'from_office'     => 'LM',
                    'pending_officer' => $pending_officer,
                    'pending_office'  => $pending_officer,
                    'sk_code'         => $sk_code,
                    'co_code'         => $co_code,
                    'approve_by'      => $approved_by
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicData);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                // insertion in backup table
                $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = '$application_no' AND from_office = 'LM'")->row()->ct;

                $phase_count = (int)$phase_count+1;
                $backup_array_lm = [
                        'applid' => $application_no,
                        'case_no' => $case_no,
                        'from_office' => 'LM',
                        'to_office' => $pending_officer,
                        'status' => 'W',
                        'phase' => 'LM_'.$phase_count,
                        'data' => json_encode($_POST)
                ];

                $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
                if($backup_insertion_lm != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP002: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                    $this->session->set_flashdata('error_data', "#BACKUP002: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                
                //update additional property
                $additional_property_check = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");

                if($additional_property_check->num_rows() > 0){
                    $additionalPropertyUpdate = [
                        'case_no' => $case_no,
                    ];
                    $this->db->where('applid', $application_no);
                    $this->db->update('settlement_additional_property', $additionalPropertyUpdate);
                    if($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR1836: Updation failed in settlement_additional_property RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROR1836: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // *******UPDATING Geo Tag Photo case number in supportive document
                if (isset($lmdata['geo_tag_doc'])) {
                    foreach ($lmdata['geo_tag_doc'] as $geo_tag_loop) {
                        $geo_tag_array = array(
                            'case_no' => $case_no
                        );
                        $this->db->where('applid', $geo_tag_loop->applid);
                        $this->db->where('dag_no', $geo_tag_loop->dag_no);
                        $this->db->where('file_name', GEO_TAG_PHOTO);
                        $this->db->update('supportive_document', $geo_tag_array);

                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                            $data = array(
                                'error'=>"#SETUP0001S: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }


                if($validation_bypass == 0)
                {
                     // upload additional file
                    if(isset($_FILES['fileUpload']['name'])){
                        for($i = 0; $i < $fileCount; $i++)
                        {
                            $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $onlyExtension  = $exp[1];

                            $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                            $config['upload_path']   = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']  = UPLOAD_MAX_SIZE;;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file'))
                            {
                                $document= array(
                                    'case_no'   => $case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type'  => $_FILES['file']['type'],
                                    'file_path'  => UPLOAD_DIR . $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type'   => SETTLEMENT_PGR_VGR_LAND_ID,
                                );

                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);
                
                                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$application_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }

                            }
                            else
                            {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);
                
                                $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }
                    //end of additional file upload

                    //*************update in settlement_dag_detals */
                    foreach ($lmdata['dags'] as $dagsland) {
                        $landmark_east = $this->input->post('landmark_east'.$dagsland->dag_no);
                        $landmark_west = $this->input->post('landmark_west'.$dagsland->dag_no);
                        $landmark_north = $this->input->post('landmark_north'.$dagsland->dag_no);
                        $landmark_south = $this->input->post('landmark_south'.$dagsland->dag_no);
                        $landmark = [
                                'east' => $landmark_east,
                                'west' => $landmark_west,
                                'north' => $landmark_north,
                                'south' => $landmark_south,
                        ];

                        $fmddata= [
                                'date_entry' => date('Y-m-d'),
                                'landmark'   => json_encode($landmark),
                            ];
                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->update('settlement_dag_details', $fmddata);
                        if($this->db->affected_rows() <= 0)
                        {
                                $this->db->trans_rollback();
                                log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$application_no);
                                $data = array(
                                        'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                        }
                    }

                    // ***********For uploading dag wise trace_map_copy
                    foreach ($lmdata['dags'] as $dags_doc) {
                        $timestamp = date('mdYhis', time()).uniqid();

                        // Trace Map copy upload
                        $config['file_name']            = 'trace_map_copy'.$timestamp;
                        $config['upload_path']          = UPLOAD_DIR;
                        $config['allowed_types']        = UPLOAD_ALLOW_TYPE;
                        $config['max_size']             = 2000;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (! $this->upload->do_upload('trace_map_copy'.$dags_doc->dag_no)) {
                            $error = array('error' => $this->upload->display_errors());
                            echo json_encode($error);
                            return false;
                        } else {
                            $data = array('upload_data' => $this->upload->data());
                            $document= array(
                                'case_no' => $case_no,
                                'file_name' => 'Trace Map Copy',
                                'user_code' => $this->session->userdata('user_code'),
                                'fetch_file_name' => $data['upload_data']['orig_name'],
                                'file_type' => $data['upload_data']['file_type'],
                                'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type' => $this->input->post('service_code'),
                                'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->dag_no)
                            );

                            $insert_supportive_doc= $this->db->insert('supportive_document', $document);


                            if ($insert_supportive_doc != 1) {
                                log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $this->db->last_query());
                                $this->db->trans_rollback();
                                
                                $json = [
                                    'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                                ];
                                echo json_encode($json);
                                return false;
                            }
                        }
                    }

                    //**********For uploading field_report copy */
                    $timestamp = date('mdYhis', time()).uniqid();
                    // For uploading field report 
                    $config2['file_name']            = 'field_report'.$timestamp;
                    $config2['upload_path']          = UPLOAD_DIR;
                    $config2['allowed_types']        = 'pdf|jpg|png';
                    $config2['max_size']             = 2000;

                    // $this->load->library('upload', $config2);
                    $this->upload->initialize($config2);

                    if ( ! $this->upload->do_upload('field_report'))
                    {
                        $error = array('error' => $this->upload->display_errors());

                        var_dump($error);
                        die;
                    }
                    else
                    {
                        $data = array('upload_data' => $this->upload->data());
                        $document= array(
                            'case_no' => $case_no,
                            'file_name' => 'Field Report',
                            'user_code' => $this->session->userdata('user_code'),
                            'fetch_file_name' => $data['upload_data']['orig_name'],
                            'file_type' => $data['upload_data']['file_type'],
                            'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type' => $this->input->post('service_code'),
                        );

                        $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                        if($insert_supportive_doc != 1){
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                            $json = [
                                'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }

                    //**********Insert into settlement_ap_lmnote */
                    //*********if LM if case of case rejected the rejected remarks */
                    // if($_POST['lm_note'] == '2')
                    // {
                    //     $reject_remarks = json_encode($_POST['rejected_reasons']);
                    // }
                    // else
                    // {
                    //     $reject_remarks = null;
                    // }

                    //*********if LM if case of case rejected the rejected remarks */

                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_PGR_VGR_LAND_ID);

                    $comment = addslashes($this->input->post('lm_note'));
                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

                    $reserve_dereserve = $this->input->post('re_dereservation');

                    $lmnote=array(
                        'user_code'                  => $this->session->userdata('user_code'),
                        'chitha_verified'            => $this->input->post('chitha_verified'),
                        'vlb_verified'               => $this->input->post('vlb_verified'),
                        'possession_verification'    => $this->input->post('possession_verification'),
                        'period_possession'          => date('Y-m-d'),
                        'nature_possession'          => $this->input->post('nature_possession'),
                        'is_landless'                => $this->input->post('is_landless'),
                        'land_falls'                 => $this->input->post('land_falls'),
                        'falls_und_gmc'              => $this->input->post('falls_und_gmc'),
                        'roadside_reservation'       => $this->input->post('roadside_reservation'),
                        // 'zonal_valuation'            => $this->input->post('zonal_valuation'),
                        'trace_map_copy'             => 'NA',
                        'chitha_copy'                => 'NA',
                        'lm_note'                    => $comment,
                        'date_entry'                 => date('Y-m-d h:i:s'),
                        'case_no'                    => $case_no,
                        'status'                     => 'W',
                        'protected_class_lm'         => $protected_class_lm,
                        'litigation'                 => $this->input->post('litigation'),
                        'landslide'                  => $this->input->post('landslide'),
                        'lm_remark_text'             => $this->input->post('lm_remark_text'),
                        'is_tribal_belt'             => $this->input->post('is_tribal_belt'),
                        'erosion'                    => $this->input->post('erosion'),
                        'bhumiputra_confirmation'    => $this->input->post('bhumiputra_confirmation_lm'),
                        'applied_scheme'             => $this->input->post('applied_scheme'),
                        'lm_rejected_remarks'        => json_encode($responseMasterObj->reject_remarks)
                    );

                    if($reserve_dereserve == 'RESERVATION'){
                        $lmnote['vgr_dag_availability'] = 'y';
                    }elseif($reserve_dereserve == 'n'){
                        $lmnote['vgr_dag_availability'] = 'n';
                    }

                    $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
                    if($insLmnote != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //***********Insertion in settlement_reservation VGR reservation */
                    // if($reserve_dereserve == 'RESERVATION'){
                    //     $reserve=array(
                    //         'dist_code'                  => $this->input->post('district_code_vgr'),
                    //         'subdiv_code'                => $this->input->post('sub_div_code_vgr'),
                    //         'cir_code'                   => $this->input->post('circle_code_vgr'),
                    //         'mouza_pargona_code'         => $this->input->post('mouza_code_vgr'),
                    //         'lot_no'                     => $this->input->post('lot_no_vgr'),
                    //         'vill_townprt_code'          => $getLocation->vill_townprt_code,
                    //         'dag_no'                     => $this->input->post('dag_no_vgr'),
                    //         'patta_type_code'            => $this->input->post('patta_code_dropdown'),
                    //         'patta_no'                   => $this->input->post('patta_no_dropdown'),
                    //         'bigha'                      => $this->input->post('bigha_dropdown'),
                    //         'katha'                      => $this->input->post('katha_dropdown'),
                    //         'lessa'                      => $this->input->post('lessa_dropdown'),
                    //         'ganda'                      => $this->input->post('ganda_dropdown'),
                    //         'kranti'                     => $this->input->post('kranti_dropdown'),
                    //         'case_no'                    => $case_no,
                    //         'applid'                     => $this->input->post('applid'),
                    //         'lm_code'                    => $this->session->userdata('user_code'),
                    //         'date_entry'                 => date('Y-m-d h:i:s'),
                    //         'date_update'                => date('Y-m-d h:i:s'),
                    //         'type'                       => 'V'
                    //     );

                    //     $reservePost = $this->db->insert('settlement_reservation',$reserve);
                    //     if($reservePost != 1)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error', '#ERRSET00051: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                    //         $data = array(
                    //             'error'=>"#ERRSET00051: Registration of Settlement failed for case no : ".$application_no
                    //         );
                    //         echo json_encode($data);
                    //         return false;
                    //     }
                    // }

                    //************Insertion in settlement_reservation roadside/riverside reservation */
                    $roadside_comment_check=$this->input->post('roadside_comment_check');
                    if ($roadside_comment_check=='YES') {

                         //********calculate VGR reservation (Minus the VGR reservation) */
                        $getVgrRData = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));

                        $num_rows_vgr_reservation = $getVgrRData->num_rows();

                        $total_calculated_lessa = 0;

                        foreach ($lmdata['dags'] as $dags_road) 
                        {

                            if($num_rows_vgr_reservation > 0)
                            {
                                //******if data available the minus roadside reserve area */
                                $total_calculated_lessa += $this->input->post('total_lessa'.$dags_road->dag_no);
                            }

                            $reservedarea=array(
                                'dist_code'=>$this->input->post('dist_code'),
                                'subdiv_code'=>$this->input->post('subdiv_code'),
                                'cir_code'=>$this->input->post('cir_code'),
                                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                'lot_no'=>$this->input->post('lot_no'),
                                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                'dag_no'=>$this->input->post('reserved_dag_road'.$dags_road->dag_no),
                                'patta_no'=>$this->input->post('reserved_patta_road'.$dags_road->dag_no),
                                'bigha'=>$this->input->post('reserved_bigha'.$dags_road->dag_no),
                                'katha'=>$this->input->post('reserved_katha'.$dags_road->dag_no),
                                'lessa'=>$this->input->post('reserved_lessa'.$dags_road->dag_no),
                                'ganda'=>$this->input->post('reserved_ganda'.$dags_road->dag_no),
                                'kranti'=>$this->input->post('reserved_kranti'.$dags_road->dag_no),
                                'case_no'=>$case_no,
                                'applid'=>$this->input->post('applid'),
                                'lm_code'=>$this->session->userdata('user_code'),
                                'date_entry'=>date('Y-m-d h:i:s'),
                                'date_update'=>date('Y-m-d h:i:s'),
                                'type'=>'R'
                            );

                            $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                            if ($reserveData != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }

                        //*********update settlement_vgr_pgr_reservation table in roadside reservation available */
                        if($num_rows_vgr_reservation > 0)
                        {
                            if (in_array($distCode, json_decode(BARAK_VALLEY)))
                            {
                                //****for barak valley */
                                $reservBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_calculated_lessa);
                            }
                            else
                            {
                                //*****for non-barak vallery */
                                $reservBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa($total_calculated_lessa);
                            }
    
                            $reservUpdateArr = [
                                'dag_area_b' => $reservBKLG[0], 
                                'dag_area_k' => $reservBKLG[1], 
                                'dag_area_lc' => $reservBKLG[2], 
                                'dag_area_g' => $reservBKLG[3], 
                            ];
    
                            $this->db->where('case_no', $case_no);
                            $this->db->update('settlement_vgr_pgr_reservation', $reservUpdateArr);
    
                            if ($this->db->affected_rows() == 0) 
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET5542114: Update failed in settlement_vgr_pgr_reservation RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRSET5542114: Registration of Settlement failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }

                    //// premium insert start
                    $sumMbAmount=0;
                    $approved_by ='';
                    $count =0;

                    foreach ($lmdata['dags'] as $dagsprem) {

                        $count++;
                        if($count >1){
                            if ($approved_by != $this->input->post('approval'.$dagsprem->dag_no)){
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAM000199: Settlement Application not submitted case no # $application_no");
                                log_message('error', '#ERRAM000199: Multiple User Approval, RTPS Case No '.$application_no);
                                redirect(base_url() . "index.php/home");
                            }
                        }

                        // premium verify start ******************
                        if (in_array($distCode, json_decode(BARAK_VALLEY))){
                            $area_in_bigha=6400;
                        }else{
                            $area_in_bigha=100;
                        }
                        $concession_rate=25;
                        $ratetype=$this->input->post('rate_type'.$dagsprem->dag_no);
                        $ratepr2=$this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                        $ratepr = $ratepr2->rate_type;
                        // var_dump($ratepr->rate_type); die;
                        $is_full_pay=$this->input->post('paymode');
                        $prem_zonal=$this->input->post('zonal_valuation_prem'.$dagsprem->dag_no);
                        $prem_area = $this->input->post('total_lessa'.$dagsprem->dag_no);
                        $prem_rate = $this->input->post('rate'.$dagsprem->dag_no);
                        $prem_concession =$this->input->post('concession'.$dagsprem->dag_no);

                        $mb_land =$this->input->post('mb_land'.$dagsprem->dag_no);

                        if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                            if($mb_land == 25){
                                $mb_land=1600;
                            }else if ($mb_land == 30){
                                $mb_land=1920;
                            }else if ($mb_land == 40){
                                $mb_land=2560;
                            }
                        }
                        
                        // if ($prem_concession=="YES"){
                        //     if($ratepr =='P'){
                        //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        //         $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                        //         $amount = ($premium * $discount / 100);
                        //         // $finalamount = round($amount,2);
                        //         $finalamount = ceil($amount);
                        //     }else if($ratepr =='R'){
                        //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                        //         $discount = $prem_rate - $concession_rate;
                        //         $amount = ($premium * $discount / 100);
                        //         $finalamount = ceil($amount);
                        //     }
                            
                        // }else if($prem_concession=="NO"){
                        //     if($ratepr =='P'){
                        //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        //         $amount = ($premium * $prem_rate / 100);
                        //         $finalamount = ceil($amount);
                        //     }else if($ratepr =='R'){
                        //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                        //         $amount = ($premium * $prem_rate / 100);
                        //         $finalamount = ceil($amount);
                        //     }
                        // }

                        if ($prem_concession=="YES"){
                            if($ratepr =='P'){
                                $this->db->trans_rollback();
                                log_message('error', '#ERRAM2716: Urban area flag found!'.$case_no);
                                $this->session->set_flashdata('message', "Error #ERRAM2716: Settlement Application not submitted case no # $case_no");
                                redirect(base_url() . "index.php/home");

                                // if($prem_area>$mb_land){
                                //     $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                //     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                //     $amount1 = ceil($premium * $discount / 100);

                                //     $access_area = $prem_area - $mb_land;
                                //     $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                                //     $amount2 = ceil($premium2 * $discount / 100);

                                //     // $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                //     // $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                //     // $amount = ($premium * $discount / 100);
                                //     // $finalamount = ceil($amount);
                                //     $finalamount = ceil($amount1 + $amount2);
                                // }else{
                                //     $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                //     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                //     $amount = ($premium * $discount / 100);
                                //     // $finalamount = round($amount,2);
                                //     $finalamount = ceil($amount);
                                // }
                                
                            }else if($ratepr =='R'){
                                // $premium = $prem_area * $prem_rate / $area_in_bigha;
                                // $discount = $prem_rate - $concession_rate;
                                // $amount = ($premium * $discount / 100);
                                // $finalamount = ceil($amount);

                                $premium = $prem_area * $prem_rate / $area_in_bigha;
                                $discount = ceil($premium * ($concession_rate/100));
                                $finalamount = ceil($premium - $discount);
                            }

                        }else if($prem_concession=="NO"){
                            if($ratepr =='P'){

                                $this->db->trans_rollback();
                                log_message('error', '#ERRAM2753: Urban area flag found!'.$case_no);
                                $this->session->set_flashdata('message', "Error #ERRAM2753: Urban flag found! In case of VGR/PGR, only rural cases are allowed. case no # $case_no");
                                redirect(base_url() . "index.php/home");

                                // if($prem_area>$mb_land){
                                //     $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                //     $amount1 = ceil($premium * $prem_rate / 100);

                                //     $access_area = $prem_area - $mb_land;
                                //     $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                //     $amount2 = ceil($premium2 * $prem_rate / 100);

                                //     $finalamount = ceil($amount1 + $amount2);
                                    
                                // }else{
                                //     $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                //     $amount = ($premium * $prem_rate / 100);
                                //     $finalamount = ceil($amount);
                                // }
                            }else if($ratepr =='R'){
                                // $premium = $prem_area * $prem_rate / $area_in_bigha;
                                // $amount = ($premium * $prem_rate / 100);
                                // $finalamount = ceil($amount);
                                $finalamount = ceil($prem_area * $prem_rate / $area_in_bigha);
                            }
                        }

                        $sumMbAmount += $finalamount; 

                        // premium verify end ******************

                        $fmd=array(
                            'case_no'=>$case_no,
                            'user_code'=>$this->session->userdata('user_code'),
                            'uuid'=>$basic['uuid'],
                            'dag_no'=>$dagsprem->dag_no,
                            // 'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$dagsprem->dag_no),
                            'area_name'=>$this->input->post('area'.$dagsprem->dag_no),
                            'land_type'=>$this->input->post('land_type'.$dagsprem->dag_no),
                            'rate_type'=>$this->input->post('rate_type'.$dagsprem->dag_no),
                            'rate'=>$this->input->post('rate'.$dagsprem->dag_no),
                            'concession'=>$this->input->post('concession'.$dagsprem->dag_no),
                            'amount_dag'=>$this->input->post('amount'.$dagsprem->dag_no),
                            'final_amount'=>$this->input->post('finalamount'),
                            'due_amount'=>$this->input->post('totaldue'),
                            'total_lessa'=>$this->input->post('total_lessa'.$dagsprem->dag_no),
                            'is_full_pay'=>$this->input->post('paymode'),
                            'is_final'=>1,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'approve_by'=>$this->input->post('approval'.$dagsprem->dag_no),
                            
                        );
                        
                        $insPremium = $this->db->insert('settlement_premium', $fmd);
                        
                        if ($insPremium != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$case_no);
                            $data = array(
                                'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    } // foreach end

                    // premium verify 2 start ******************
                    if($sumMbAmount != $this->input->post('finalamount')){
                        // var_dump("Amount mismatch!!!"); die;
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0001: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    if ($is_full_pay=="NO"){
                        $discount = 30;
                        $finaldue = ($sumMbAmount * $discount / 100);
                        // $finaldueamount = round($finaldue,2);
                        $finaldueamount = ceil($finaldue);
                    }else if ($is_full_pay=="YES"){
                        $finaldueamount= $sumMbAmount;
                    }
                    
                    if($finaldueamount != $this->input->post('totaldue'))
                    {
                        // var_dump("Due Amount mismatch!!!");
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0002: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    // premium verify 2 end ******************
                }

                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
                        SETTLEMENT_PGR_VGR_LAND_ID,
                        $case_no,
                        $application_no,
                        $lmdata['rejected_list']
                    );
                }

                //**********Insert into settlement_proceeding  */
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }
                $insPetProceed = [
                    'case_no'                => $case_no,
                    'proceeding_id'          => $proceeding_id,
                    'date_of_hearing'        => date('Y-m-d h:i:s'),
                    'next_date_of_hearing'   => date('Y-m-d h:i:s'),
                    'note_on_order'          => $this->input->post('lm_remark_text'),
                    'status'                 => 'W',
                    'user_code'              => $this->session->userdata('user_code'),
                    'date_entry'             => date('Y-m-d h:i:s'),
                    'operation'              => 'E',
                    'ip'                     => $this->utilityclass->get_client_ip(),
                    'office_from'            => 'LM',
                    'office_to'              => $pending_officer,
                    'task'                   => 'LM note submitted',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP343: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPP3434: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                //*******checking transaction status for any errors */
                if($this->db->trans_status()==FALSE)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"ERRFINAL00384: Error in submitting. Please try Again"
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to '.$pending_officer;
                    $status='M';
                    $task='LM';
                    $pen=$pending_officer;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                    }

                    //**********Success redirect with case_no */
                    $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
                    redirect(base_url() . "index.php/home");

                }
            }
        }

    }


    public function secondProceeding()
    {
        $case_no = $this->input->get('case');
        $case_no = $this->utilityclass->decryptJwtCase($case_no);

        $this->utilityclass->lmAuthBasic($case_no);

        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();
        
        $this->dbswitch();

        $basic = $this->SettlementVgrModel->getSettlementBasic($case_no);
        $applicants_buyers = $this->SettlementVgrModel->getAllApplicantBuyers($case_no);
        $applicants_owners = $this->SettlementVgrModel->getAllApplicantOwners($case_no);
        $applicants_encroacher = $this->SettlementVgrModel->getAllApplicantEncroacher($case_no);
        $applicants_riotee_nok = $this->SettlementVgrModel->getAllApplicantRioteeNok($case_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($case_no);
        $road_reservation = $this->SettlementVgrModel->getSettlementReservationRoad($case_no);
        $dags = $this->SettlementVgrModel->getSettlementDag($case_no);
        $lmnotes = $this->SettlementVgrModel->getSettlementTenantLmNote($case_no);
        $proceedings = $this->SettlementVgrModel->getSettlementProceeding($case_no);
        $dhardocuments = $this->SettlementVgrModel->getDocuments($case_no);

        $lmdata['basic']=$basic;
        $lmdata['reservation']=$reservation;
        $lmdata['road_reservation']=$road_reservation;

        // if($lmdata['reservation'] == true){
        //     foreach($reservation as $reserv){
        //         if ($reserv->type == "V") {
        //             $lmdata['reserv_v_v_uuid'] = $this->utilityclass->getVillageUUID($reserv->dist_code,$reserv->subdiv_code, $reserv->cir_code, $reserv->mouza_pargona_code, $reserv->lot_no, $reserv->vill_townprt_code);
        //         }
        //     }
        // }

        $lmdata['applicants_buyers']=$applicants_buyers;
        $lmdata['applicants_owners']=$applicants_owners;
        $lmdata['applicants_encroacher']=$applicants_encroacher;
        $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

        $lmdata['dags']=$dags;
        $lmdata['lmnotes']=$lmnotes;
        $lmdata['proceedings']=$proceedings;
        $lmdata['dhardocuments']=$dhardocuments;

        $d=$basic["dist_code"];
        $s=$basic["subdiv_code"];
        $c=$basic["cir_code"];
        $m=$basic["mouza_pargona_code"];
        $l=$basic["lot_no"];
        $v=$basic["vill_townprt_code"];

        $lmdata['application_no'] = $applid = $this->utilityclass->getApplidFromCaseNo($case_no);

        if(isset($applicants_encroacher)):
            foreach($applicants_encroacher as $settl_vlb_add_check):
                $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($applid, $settl_vlb_add_check->dag_no, $lmdata['basic']['uuid']));

                if($sqlVlbEntryQuery->num_rows() > 0){
                    $settlement_land_bank_details[] = $sqlVlbEntryQuery->row();

                    $vlb_encroacher_added_check[] = $sqlVlbEntryQuery->row()->dag_no;

                    $sql = $this->db->query("SELECT dag_no, status FROM land_bank_details WHERE id = ?", array($sqlVlbEntryQuery->row()->land_bank_details_id));

                    $land_bank_status[] =  $sql->row();

                }else{
                    $settlement_land_bank_details[] = false;
                    $vlb_encroacher_added_check[] = false;
                    $land_bank_status[] = false;
                }
            endforeach;
            if(isset($vlb_encroacher_added_check)):
                if($vlb_encroacher_added_check):
                    $lmdata['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
                endif;
            endif;
            if(isset($land_bank_status)):
                $lmdata['land_bank_status'] = $land_bank_status;
            endif;
            if(isset($settlement_land_bank_details)):
                $lmdata['settlement_land_bank_details'] = $settlement_land_bank_details;
            endif;
        endif;



        if(isset($applicants_buyers)){
        
            if($applicants_buyers){
                foreach($applicants_buyers as $adhar_photo){

                    if($adhar_photo->is_applicant == 1){
                        if(trim($adhar_photo->identity_type) == 'AADHAAR'){
                            $adhar_photo_link = $adhar_photo->identity_doc_link;

                            $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                            $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                            fclose($open_adhar_file);
                            // decoding the base64 encoding file variable

                            $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        }
                    }
                }
            }
        }
        /// premium
        // $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
        // $lmdata['s_area'] = $s_area;

        $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
        $lmdata['premiumData'] = $premiumData;
        /// premium end


        $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $basundhara->basundhara,
            'api_key' => API_KEY,
            'token' => $token
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType == 3){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);

        $output = json_decode($output);
        //   var_dump($output); die();

        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        $lmdata['nextKin']=$output->nextKin;

        $d = $lmdata['basic']['dist_code'];
        $s = $lmdata['basic']['subdiv_code'];
        $c = $lmdata['basic']['cir_code'];
        $m = $lmdata['basic']['mouza_pargona_code'];
        $l = $lmdata['basic']['lot_no'];
        $lmdata['villagelist']  = $this->SettlementVgrModel->getVillageList($d,$s,$c,$m,$l);

        foreach($output->selfDeclaration as $selfDec)
        {
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        //get data from settlement_ap_lmnote
        $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
        case_no='$case_no'")->row()->is_landless;
        $lmdata['apLmNote'] = $apLmNote;

        $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$applid'");

        if($additional_property->num_rows() > 0){
            $totallesaa=0;
            $totalganda=0;
            foreach($additional_property->result() as $addprop){
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                    $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }else{
                    $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }

            }
            if(!empty($totallesaa)){
                $lmdata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda)){
                $lmdata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $lmdata['additional_property']=$additional_property->result();
            // var_dump($lmdata['total_aditional_area_g']); die;
        }

        $lmdata['case_no'] = $case_no;

        $lmdata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        if($lmdata['sk_name'] == 'n')
        {
            //************if SK is not available then load CO */
            $lmdata['sk_availability'] = 'n';

            $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        }
        else
        {
            $lmdata['sk_availability'] = 'y';
        }

        //************dag eligibility */
        $lmdata['dag_count']=count($dags);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_PGR_VGR_LAND_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }

        $sqlToCheckPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));
        if($sqlToCheckPremium->num_rows() <= 0)
        {
            $lmdata['premium_not_calculated'] = 1;
        }
        else
        {
            $lmdata['premium_not_calculated'] = 0;
        }

        $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);	

        $lmdata['enc_case']= null;
        if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
        {
            // var_dump($application_no.','.$basic['dist_code'].','.$basic['service_code']);
            $this->load->model('ApplicantChangeModel');
            $lmdata['deceased'] = $this->ApplicantChangeModel->getDeceasedData($basic['applid']);
            $lmdata['enc_case'] = $this->ApplicantChangeModel->ekycVerify($application_no, $basic['dist_code'], $basic['service_code']);
        }

        $lmdata['citizen_nrc_doc'] = null;
        $lmdata['lm_nrc_doc'] = null;
        $lmdata['rejected_cat'] = 0;
        $lmdata['status_not_in_d'] = null;
        if(NRC_FILE_UPLOAD_ENABLED == 1) {
            $this->load->model('NrcDocModel');
            $citizen_nrc_doc = json_decode($this->NrcDocModel->getNrcDocsUploadedByCitizen($basic['applid']));
            $lmdata['citizen_nrc_doc'] = $citizen_nrc_doc;
            $lmdata['lm_nrc_doc'] = $this->NrcDocModel->getNrcDocsUploadedByLm($basic['case_no']);
            $lmdata['rejected_cat'] = $this->NrcDocModel->getRejectedCategoryForNrcUp($basic['case_no']);
            $lmdata['status_not_in_d'] = $this->NrcDocModel->getFromBasicNotD($basic['case_no']);
        }

        //********display application */
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $lmdata['_view'] = 'SettlementView/Lm/Vgr/SettlementVgrView';
            $this->load->view('layouts/main',$lmdata);
        }

        //***********To update  */
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $roadside_comment_check = $this->input->post('roadside_comment_check');
            $is_prem_update = $this->input->post('prem_update');

            // $ReservationAreaWithDag = 0;
            $totalReservationArea = 0;
            $totalDagAreaLessaValidation = 0;
            $totalAgrAreaLessaValidation = 0;
            $totalHomeAreaLessaValidation = 0;
            $appAreaMoreThanDagA = 0;
            $reserveMoreThanAppArea = 0;
            $familyMoreThanAppArea = 0;
            $totalRoadSideAreaLessaValidation = 0;
            // $totalFamilyAreaLessaValidation = 0;

            $this->load->library('form_validation');            
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            $distCode = trim($this->input->post('dist_code'));
            if ($distCode == null) {
                redirect(base_url(). 'index.php/basundhara2/settlementCases');
            }
            if ($applid == null) {
                redirect(base_url(). 'index.php/basundhara2/settlementCases');
            }

             //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_PGR_VGR_LAND_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    { 

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

            //****this validation is required in all cases */
            if($validation_bypass == 1)
            {
                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }

                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }

                }

                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                // $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');

                // $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
                
                if ($applicants_encroacher == true)
                {
                    foreach ($applicants_encroacher as $enc_applicant)
                    {
                        $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('period_possession'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, '', '');
                        $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, '', '');
                    }
                }
            }

            if($validation_bypass == 0)
            {


                if(NRC_FILE_UPLOAD_ENABLED == 1)
                {
                    $nrc_file1 = $this->input->post('nrc_file1');
                    $nrc_file2 = $this->input->post('nrc_file2');
                    $nrc_file3 = $this->input->post('nrc_file3');
                    $nrc_file4 = $this->input->post('nrc_file4');
                    $nrc_file5 = $this->input->post('nrc_file5');


                    $this->form_validation->set_rules('nrc_file1', 'NRC_1951 Details', 'trim|xss_clean|required');
                    $this->form_validation->set_rules('nrc_file2', 'Link Document 1 Details', 'trim|xss_clean|required');
                    $this->form_validation->set_rules('nrc_file3', 'Link Document 2 Details', 'trim|xss_clean|required');
                    $this->form_validation->set_rules('nrc_file4', 'Link Document 3', 'trim|xss_clean|required');
                    $this->form_validation->set_rules('nrc_file5', 'Link Document 4', 'trim|xss_clean|required');

                    for ($i = 1; $i <= 5; $i++) 
                    { 

                        if($_FILES['nrc_file_upload'.$i]['name'] && $_FILES['nrc_file_upload'.$i]['size'] && $_FILES['nrc_file_upload'.$i]['tmp_name'])
                            {

                                $name = $_FILES['nrc_file_upload'.$i]['name'];
                                $size = $_FILES['nrc_file_upload'.$i]['size'];

                                $mime = mime_content_type($_FILES['nrc_file_upload'.$i]['tmp_name']);
                                $exp  = explode("/",$mime);
                                $ext  = $exp[1];

                                if($name != NULL)
                                {
                                    if($ext == NULL)
                                    {
                                        // todo error show extension missing
                                        $this->form_validation->set_rules('nrc_file_upload'.$i,'File extension','required');

                                    }
                                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                    {
                                        // todo error show file allow type not match
                                        $this->form_validation->set_rules('nrc_file_upload'.$i,'Only JPG/PNG/PDF file','required');
                                    }
                                    if($size > UPLOAD_MAX_SIZE)
                                    {
                                        // todo error show file size
                                        $this->form_validation->set_rules('nrc_file_upload'.$i,'Maximum 2MB file size','required');
                                    }
                                }
                                else
                                {
                                    // todo error show file not nullable
                                    $this->form_validation->set_rules('nrc_file_upload'.$i,'File name','required');
                                }
                            }
                            else
                            {
                                $this->form_validation->set_rules('nrc_file_upload'.$i,'File','required');
                            }
                        // code...
                    }
                }
                //******Geo tag validation */
                $geo_tag_dags = array();
                foreach($lmdata['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";
            
                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($applid, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($lmdata['dags']);

                if((int)$get_tag_dag_count != (int)$total_dag_count)
                {
                    if(GEO_TAG_ACTIVE_STATUS == 1){
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                // $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
                $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
                $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
                $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
                $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
                $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
                $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
                $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
                $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

                $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
                $this->form_validation->set_rules('applied_scheme', 'Applied Scheme', 'trim|required');

                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required|greater_than[-1]');
                $this->form_validation->set_rules('litigation', 'Proposed land is under litigation', 'trim|required');
                $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide clone ', 'trim|required');
                $this->form_validation->set_rules('erosion', 'Is Area falls under erosion ', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Proposed land falls under Tribal Belt/ Block', 'trim|required');
                $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
                $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
                $this->form_validation->set_rules('roadside_comment_check', 'Roadside/riverside reservation', 'trim|required');

                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                // $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
        
                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }

                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }

                }

                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');

                // $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');

                $this->form_validation->set_rules('re_dereservation', ' Filling of Reservation / De Reservation Proposal', 'trim|required');

                if($this->input->post('re_dereservation') == 'RESERVATION'){

                    $sqlReserveCheck = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no ));

                    if($sqlReserveCheck->num_rows() <= 0)
                    {
                        $this->form_validation->set_rules('re_dereservation', 'Vgr Reservation', 'required');
                    }

                    //*******check area settlement_dag_details and settlement_vgr_pgr_area table area similarity */
                    $notValErr = 0;
                    $notValErrR = 0;

                    $dagSql = $this->db->query('select 
                    SUM(d.s_dag_area_b*100 + d.s_dag_area_k*20 + d.s_dag_area_lc) AS total_lessa, 
                    SUM(d.s_dag_area_b*6400 + d.s_dag_area_k*320 + d.s_dag_area_lc*20 + d.s_dag_area_g) AS total_ganda 
                    from settlement_dag_details d where d.case_no = ? GROUP BY d.case_no', array($case_no));

                    if($dagSql->num_rows() <= 0)
                    {
                        $notValErr = 1;
                    }
                    else
                    {
                        $dagLessa = $dagSql->row();
                    }
    
                    $reservSql = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS total_lessa, 
                    SUM(dag_area_b*6400 + dag_area_k*320 + dag_area_lc*20 + dag_area_g) AS total_ganda from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));
                    
                    if($reservSql->num_rows() <= 0)
                    {
                        $notValErrR = 1;
                    }
                    else
                    {
                        $reservLessa = $reservSql->row();
                    }

                    if($notValErr != 1)
                    {
                        if($notValErrR !=1)
                        {
                            if(in_array($distCode, json_decode(BARAK_VALLEY)))
                            {
                                if((float)$dagLessa->total_ganda != (float)$reservLessa->total_ganda)
                                {
                                    $this->form_validation->set_rules('area_mismatch', 'Reservation/De-reservation area should be equal!', 'required');
                                }
                            }
                            else
                            {
                                if((float)$dagLessa->total_lessa != (float)$reservLessa->total_lessa)
                                {
                                    $this->form_validation->set_rules('area_mismatch', 'Reservation/De-reservation area should be equal!', 'required');
                                }
                            }
                        }
                        else
                        {
                            $this->form_validation->set_rules('area_mismatch', 'Unaspected err occured! Contact admin...', 'required');
                        }
                    }
                    else
                    {
                        //*****show error */
                        $this->form_validation->set_rules('area_mismatch', 'Unaspected err occured! Contact admin...', 'required');
                    }
                }



                $this->form_validation->set_rules('roadside_reservation','','');

                // if (empty($_FILES['field_report']['name']))
                // {
                //     $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                // }

                $checkUrbanCon = trim($this->input->post('is_urban'));

                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach($lmdata['dags'] as $dags_area)
                    {

                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_area->dist_code, $dags_area->subdiv_code, $dags_area->cir_code, $dags_area->mouza_pargona_code, $dags_area->lot_no, $dags_area->vill_townprt_code, $dags_area->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }

                        // if (empty($_FILES['trace_map_copy'.$dags_area->dag_no]['name']))
                        // {
                        //     $this->form_validation->set_rules('trace_map_copy'.$dags_area->dag_no, 'Trace map document', 'required');
                        // }

                        $this->form_validation->set_rules('landmark_east'.$dags_area->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_area->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_area->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_area->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('zonal_valuation_prem'.$dags_area->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                    
                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags_area->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags_area->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags_area->dag_no), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dags_area->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dags_area->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dags_area->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dags_area->dag_no), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'.$dags_area->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dags_area->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dags_area->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dags_area->dag_no), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'.$dags_area->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;

                        if($roadside_comment_check=='YES')
                        {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_area->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_area->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_area->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_area->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_area->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda'.$dags_area->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti'.$dags_area->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_area->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_area->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_area->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dags_area->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                            {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                        // new premium addition
                        if($this->input->post('area_new'.$dags_area->dag_no) !=10){

                            $maxland_ganda ='';
                            if(!empty($this->input->post('area_new'.$dags_area->dag_no))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_area->dag_no));
                            
                            if(!empty($maxland_check->max_land)){
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }
                                if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }


                            }

                            }else{
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                                        $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }

                    }
                }
                else
                {
                    foreach($lmdata['dags'] as $dags_area)
                    {
                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_area->dist_code, $dags_area->subdiv_code, $dags_area->cir_code, $dags_area->mouza_pargona_code, $dags_area->lot_no, $dags_area->vill_townprt_code, $dags_area->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }
                        // if (empty($_FILES['trace_map_copy'.$dags_area->dag_no]['name']))
                        // {
                        //     $this->form_validation->set_rules('trace_map_copy'.$dags_area->dag_no, 'Trace map document', 'required');
                        // }

                        $this->form_validation->set_rules('landmark_east'.$dags_area->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_area->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_area->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_area->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('zonal_valuation_prem'.$dags_area->dag_no, 'Zonal Value', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags_area->dag_no), 0);

                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags_area->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags_area->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dags_area->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dags_area->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dags_area->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dags_area->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dags_area->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dags_area->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation ;
                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome ;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr ;

                        if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;


                        if($roadside_comment_check=='YES')
                        {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_area->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_area->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_area->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_area->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_area->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_area->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_area->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_area->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                            if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                            {
                                $reserveMoreThanAppArea = 1;
                            }

                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                        // new premium addition
                        if($this->input->post('area_new'.$dags_area->dag_no) !=10){
                            if(!empty($this->input->post('area_new'.$dags_area->dag_no))){
                                $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_area->dag_no));
                                if(!empty($maxland_check->max_land)){

                                    if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                        $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                                        $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                    }

                                }

                            }else{
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ', 'required|callback_totalAppliedAreaInUrban');
                            }
                        }

                    }
                }

                // new additional property calculation
                $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$applid'")->result();
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                        $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }
                else
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }

                // new additional property calculation end here

                // additional file upload validation
                // upload additional files
                if(isset($_FILES['fileUpload']['name'])){
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size
                
                    for($i = 0; $i < $fileCount; $i++)
                    {
                        if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                            $name = $_FILES['fileUpload']['name'][$i];
                            $size = $_FILES['fileUpload']['size'][$i];
        
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $ext  = $exp[1];
        
                            if($name != NULL)
                            {
                                if($ext == NULL)
                                {
                                    // todo error show extension missing
                                    $this->form_validation->set_rules('additional_doc_err','File extension','required');
        
                                }
                                if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                {
                                    // todo error show file allow type not match
                                    $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                                }
                                if($size > UPLOAD_MAX_SIZE)
                                {
                                    // todo error show file size
                                    $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
                                }
                            }
                            else
                            {
                                // todo error show file not nullable
                                $this->form_validation->set_rules('additional_doc_err','File name','required');
                            }
                        }
                        else{
                            $this->form_validation->set_rules('additional_doc_err','File','required');
                        }
                    }
                }

                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_katha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa','','');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda','','');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti','','');
                
                // for total applied area set_value in validation error Agriculture
                $this->form_validation->set_rules('total_applied_area_agricultural_bigha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_katha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_lessa','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_ganda','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_kranti','','');

                if($reserveMoreThanAppArea == 1)
                {
                    $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area  !', 'required|callback_reserveMoreThanAppArea');

                }

                if($familyMoreThanAppArea == 1)
                {
                    $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area  !', 'required|callback_familyMoreThanAppArea');
                }

                if($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
                }

                if($appAreaMoreThanDagA == 1)
                {
                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                }

                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    if(VGR_PGR_MAX_HOME * 6400 < $totalHomeAreaLessaValidation)
                    {
                        $this->form_validation->set_rules('vgrMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_vgrMaxHomestead');
                    }

                    if(VGR_PGR_MAX_HOME * 6400 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. VGR_PGR_MAX_HOME . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                    }

                    if($checkUrbanCon == 'Y')
                    {
                        if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                                MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }
                else
                {
                    if(VGR_PGR_MAX_HOME * 100 < $totalHomeAreaLessaValidation)
                    {
                        $this->form_validation->set_rules('vgrMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_vgrMaxHomestead');
                    }

                    if(VGR_PGR_MAX_HOME * 100 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. VGR_PGR_MAX_HOME . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                    }
                    if($checkUrbanCon == 'Y')
                    {
                        if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                                MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }

                }

                $enc_count = count($applicants_encroacher);
                $enc_avl_check = 0;
                if ($applicants_encroacher == true)
                {
                    $enc_avl_check = $enc_count;
                    foreach ($applicants_encroacher as $enc_applicant)
                    {
                        
                        if($this->input->post('encroacher_exist_vlb'.$enc_applicant->id) != 4)
                        {
                            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, 'Encroacher exist in VLB', 'trim|required|is_natural');
                            $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, 'Encroachers Dag No.', 'trim|required|is_natural');
                            $this->form_validation->set_rules('period_possession'.$enc_applicant->id, 'Encroachers Period Possession', 'trim|required');
                            $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, 'Encroachers Name', 'trim|required|min_length[3]|max_length[70]');
                            $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, 'Encroachers  Guardian', 'trim|required|min_length[1]|max_length[70]');
                            // $this->form_validation->set_rules('enc_id'.$enc_applicant->id, 'Encroacher Id', 'trim|required|is_natural');
                        }
                        else
                        {

                            $enc_avl_check++;

                            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');

                            $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('period_possession'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, '', '');
                            $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, '', '');
                        } 
                    }

                    if($enc_avl_check != $enc_count)
                    {
                        if($enc_avl_check != ((int)$enc_count * 2))
                        {
                            $this->form_validation->set_rules('encroacher_exist_vlb', '(If you select "Name does not exist and also not in possession" for one Dag then the uneligible dag must be deleted from area details!)', 'required');
                        }
                    }
                }
            }

            if ($this->form_validation->run() == FALSE)
            {
                $lmdata['all_errors'] = validation_errors();
                $lmdata['err_return'] = true;
                if(isset($fileCount)){
                    $lmdata['fileCount'] = $fileCount;
                }
         
                $lmdata['_view'] = 'SettlementView/Lm/Vgr/SettlementVgrView';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {
                $this->db->trans_begin();

                if($lmdata['sk_availability'] == 'y')
                {
                    $pending_officer = 'SK';
                }
                else
                {
                    $pending_officer = 'CO';
                }
                if($validation_bypass == 1)
                {
                    $pending_officer = 'CO';
                }

                //*************insert into settlement_json_backup talble */
                $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'LM'")->row()->ct;
                    
                $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);
    
                $phase_count = (int)$phase_count+1;
                $backup_array_lm = [
                        'applid' => $applid_backup,
                        'case_no' => $case_no,
                        'from_office' => 'LM',
                        'to_office' => $pending_officer,
                        'status' => 'X',
                        'phase' => 'LM_'.$phase_count,
                        'data' => json_encode($_POST)
                ];
    
                $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
    
                if($backup_insertion_lm != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP0032: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);
    
                    $this->session->set_flashdata('error_data', "#BACKUP0032: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //************update in settlement_applicant */
                if ($applicants_encroacher == true)
                {
                    foreach ($applicants_encroacher as $enc_applicant)
                    {

                        $applicant_array = [
                            'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'.$enc_applicant->id)
                        ];

                        $this->db->where('id', $enc_applicant->id);
                        $this->db->where('case_no', $case_no);
                        $this->db->update('settlement_applicant', $applicant_array);

                        if($this->db->affected_rows() <= 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR90112: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                            $data = array(
                                'error'=>"#ERROR90112: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                //new premium condition

                foreach ($dags as $dag_for_approve) {
                    $dag_arraay[]=$this->input->post('approval'.$dag_for_approve->dag_no);
                    $dag_by_approve = $this->input->post('approval'.$dag_for_approve->dag_no);
                }

                $approved_by =null;
                if ($dag_by_approve !='' || $dag_by_approve !=null )
                {
                    if(count($dag_arraay)==1){
                        $approved_by =$dag_by_approve;
                    }else{
    
                        if(count(array_unique($dag_arraay))<count($dag_arraay)){
                            $approved_by =$dag_by_approve;
                        }else{
                            $approved_by ='GOVT';
                        }
                        
                    }

                }

                //**************update in settlement_basic table */
                $basic = array(
                    'date_update'          => date('Y-m-d G:i:s'),
                    'status'               => 'X',
                    'user_code'            => $this->session->userdata('user_code'),
                    'lm_code'              => $this->session->userdata('user_code'),
                    'from_office'          => 'LM',
                    'pending_officer' => $pending_officer,
				    'pending_office' => $pending_officer,
                    'approve_by' => $approved_by
                );
    
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basic);
    
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No ' . $case_no);
                    $data = array(
                        'error' => "#SETUP0001: Registration of Settlement basic failed for case no : " . $case_no,
                    );
                    echo json_encode($data);
                    return false;
                }

                if($validation_bypass == 0)
                {


                    //NRC FILE UPLOAD =================
                    if(NRC_FILE_UPLOAD_ENABLED ==1)
                    {
                        $nrc_file1 = $this->input->post('nrc_file1');
                        $nrc_file2 = $this->input->post('nrc_file2');
                        $nrc_file3 = $this->input->post('nrc_file3');
                        $nrc_file4 = $this->input->post('nrc_file4');
                        $nrc_file5 = $this->input->post('nrc_file5');
                        $nrc_file6 = $this->input->post('nrc_file6');

                        $nrc_fileName1 = 'NRC_1951';
                        $nrc_fileName2 = 'DOC_1';
                        $nrc_fileName3 = 'DOC_2';
                        $nrc_fileName4 = 'DOC_3';
                        $nrc_fileName5 = 'DOC_4';
                        $nrc_fileName6 = 'DOC_5';


                        $nrcFileName = array($nrc_fileName1,$nrc_fileName2,$nrc_fileName3,$nrc_fileName4,$nrc_fileName5,$nrc_fileName6);
                        $nrcDesc     = array($nrc_file1,$nrc_file2,$nrc_file3,$nrc_file4,$nrc_file5,$nrc_file6);

                        $nrcFileArray  = array($_FILES["nrc_file_upload1"],$_FILES["nrc_file_upload2"],$_FILES["nrc_file_upload3"],$_FILES["nrc_file_upload4"],$_FILES["nrc_file_upload5"],$_FILES["nrc_file_upload6"]);
                        $service_code = SETTLEMENT_PGR_VGR_LAND_ID;

                        $nrcFilesUploadStatus = $this->SettlementNRCFileUploadModel->uploadNrcFiles($case_no,$nrcDesc,$nrcFileArray,$nrcFileName,$service_code);
                        if($nrcFilesUploadStatus['responseType'] == 1)
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "#ERRVGRPGRNRCDOC0001: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }

                    }
                    //end=====================
                    //*********upload additional file if exist */
                    if(isset($_FILES['fileUpload']['name'])){
                        for($i = 0; $i < $fileCount; $i++)
                        {
                            $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
        
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $onlyExtension  = $exp[1];
        
                            $fileRename =  $this->UUID4() . '.' . $onlyExtension;
        
                            $config['upload_path']   = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']  = UPLOAD_MAX_SIZE;;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file'))
                            {
                                $document= array(
                                    'case_no'   => $case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type'  => $_FILES['file']['type'],
                                    'file_path'  => UPLOAD_DIR . $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type'   => SETTLEMENT_PGR_VGR_LAND_ID,
                                );
        
                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);
        
                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                
                                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }
        
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                
                                $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }

                    //*************update in settlement_dag_detals */
                    foreach ($lmdata['dags'] as $dagsland) {
                        $landmark_east = $this->input->post('landmark_east'.$dagsland->dag_no);
                        $landmark_west = $this->input->post('landmark_west'.$dagsland->dag_no);
                        $landmark_north = $this->input->post('landmark_north'.$dagsland->dag_no);
                        $landmark_south = $this->input->post('landmark_south'.$dagsland->dag_no);
                        $landmark = [
                                'east' => $landmark_east,
                                'west' => $landmark_west,
                                'north' => $landmark_north,
                                'south' => $landmark_south,
                        ];

                        $fmddata= [
                                'date_entry' => date('Y-m-d'),
                                'landmark'   => json_encode($landmark),
                            ];
                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->update('settlement_dag_details', $fmddata);
                        if($this->db->affected_rows() <= 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                            $data = array(
                                    'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    //**************If File update */
                    if(isset($_FILES)){
                        foreach ($_FILES as $file => $key) {

                            if ($key['tmp_name'] == false) {
                                continue;
                            }

                            $doc_dag_no =  strstr($file,  '_', true);
                            $doc_id = substr($file, strpos($file, "_") + 1);

                            preg_match('/DOCMAIN/', $file, $match);

                            if($match){
                                if ($match[0] == 'DOCMAIN') {
                                    $timestamp = date('mdYhis', time()).uniqid();

                                    $config['file_name']            = 'updated_file'.$timestamp;
                                    $config['upload_path']          = UPLOAD_DIR;
                                    $config['allowed_types']        = 'pdf|jpg|png';
                                    $config['max_size']             = 2000;
                
                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);
                
                                    if ( ! $this->upload->do_upload($file))
                                    {
                                        $error = array('error' => $this->upload->display_errors());
                                        echo json_encode($error);
                                        return false;
                                    }
                                    else
                                    {
                                        $data = array('upload_data' => $this->upload->data());
                                        $document= array(
                                            'file_type' => $data['upload_data']['file_type'],
                                            'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                        );
                
                                        $this->db->where('id', $doc_id);
                                        $this->db->update('supportive_document', $document);
                
                                        // echo $this->db->last_query();
                
                                        if ($this->db->affected_rows() == 0) {
                                            $this->db->trans_rollback();
                                            log_message('error', '#SETUP6845545: Updation failed in supprotive_documents Dharitree Case No ' . $case_no);
                                            $data = array(
                                                'error' => "#SETUP6845545: Failed to upload documents, Please compress the file and reupload. case no : " . $case_no,
                                            );
                                            echo json_encode($data);
                                            log_message("error", "last query" . json_encode($this->db->last_query()));
                                            return false;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if($reservation == true)
                    {
                        if ($roadside_comment_check=='YES') 
                        {
                            //********calculate VGR reservation (Minus the VGR reservation) */
                            $getVgrRData = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));

                            $num_rows_vgr_reservation = $getVgrRData->num_rows();

                            $total_calculated_lessa = 0;

                            foreach ($reservation as $reservation_road)
                            {
                                if($num_rows_vgr_reservation > 0)
                                {
                                    //******if data available the minus roadside reserve area */
                                    $total_calculated_lessa += $this->input->post('total_lessa'.$reservation_road->dag_no);
                                }

                                if($reservation_road->type == 'R')
                                {
                                    $reservedarea_road = array(
                                        'bigha' => $this->input->post('reserved_bigha' . $reservation_road->dag_no),
                                        'katha' => $this->input->post('reserved_katha' . $reservation_road->dag_no),
                                        'lessa' => $this->input->post('reserved_lessa' . $reservation_road->dag_no),
                                        'ganda' => $this->input->post('reserved_ganda' . $reservation_road->dag_no),
                                        'kranti' => $this->input->post('reserved_kranti' . $reservation_road->dag_no),
                                        'lm_code' => $this->session->userdata('user_code'),
                                        'date_update' => date('Y-m-d h:i:s'),
                                    );

                                    $this->db->where('case_no', $case_no);
                                    $this->db->where('type', 'R');
                                    $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                                    $this->db->update('settlement_reservation', $reservedarea_road);

                                    if ($this->db->affected_rows() == 0) 
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#SETUP000444: Updation failed in settlement_reservation Dharitree Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#SETUP000444: Registration of settlement_reservation failed for case no : " . $case_no,
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                }
                                else
                                {
                                    //******insert here */
                                    foreach($dags as $road_insert)
                                    {
                                        $reservedarea=array(
                                            'dist_code'=>$this->input->post('dist_code'),
                                            'subdiv_code'=>$this->input->post('subdiv_code'),
                                            'cir_code'=>$this->input->post('cir_code'),
                                            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                            'lot_no'=>$this->input->post('lot_no'),
                                            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                            'dag_no'=>$this->input->post('reserved_dag_road'.$road_insert->dag_no),
                                            'patta_no'=>$this->input->post('reserved_patta_road'.$road_insert->dag_no),
                                            'bigha'=>$this->input->post('reserved_bigha'.$road_insert->dag_no),
                                            'katha'=>$this->input->post('reserved_katha'.$road_insert->dag_no),
                                            'lessa'=>$this->input->post('reserved_lessa'.$road_insert->dag_no),
                                            'ganda'=>$this->input->post('reserved_ganda'.$road_insert->dag_no),
                                            'kranti'=>$this->input->post('reserved_kranti'.$road_insert->dag_no),
                                            'case_no'=>$case_no,
                                            'applid'=>$this->input->post('applid'),
                                            'lm_code'=>$this->session->userdata('user_code'),
                                            'date_entry'=>date('Y-m-d h:i:s'),
                                            'date_update'=>date('Y-m-d h:i:s'),
                                            'type'=>'R'
                                        );
            
                                        $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                                        // echo $this->db->last_query(); die();
                                        if ($reserveData != 1) 
                                        {
                                            $this->db->trans_rollback();
                                            log_message('error', '#UPDTT00052: Update failed in settlement_reservation RTPS Case No '.$case_no);
                                            $data = array(
                                                'error'=>"#UPDTT00052: Update failed for case no : ".$case_no
                                            );
                                            echo json_encode($data);
                                            return false;
                                        }
                                    }
                                }
                            }

                            //*********update settlement_vgr_pgr_reservation table in roadside reservation available */
                            if($num_rows_vgr_reservation > 0)
                            {
                                if (in_array($distCode, json_decode(BARAK_VALLEY)))
                                {
                                    //****for barak valley */
                                    $reservBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_calculated_lessa);
                                }
                                else
                                {
                                    //*****for non-barak vallery */
                                    $reservBKLG = $this->utilityclass->Total_Bigha_Katha_Lessa($total_calculated_lessa);
                                }
        
                                $reservUpdateArr = [
                                    'dag_area_b' => $reservBKLG[0], 
                                    'dag_area_k' => $reservBKLG[1], 
                                    'dag_area_lc' => $reservBKLG[2], 
                                    'dag_area_g' => $reservBKLG[3], 
                                ];
        
                                $this->db->where('case_no', $case_no);
                                $this->db->update('settlement_vgr_pgr_reservation', $reservUpdateArr);
        
                                if ($this->db->affected_rows() == 0) 
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRSET4268: Update failed in settlement_vgr_pgr_reservation RTPS Case No '.$case_no);
                                    $data = array(
                                        'error'=>"#ERRSET4268: Registration of Settlement failed for case no : ".$case_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }
                            }
                        }

                        if ($roadside_comment_check=='NO') 
                        {
                            $resUpdate = "UPDATE settlement_reservation SET is_deleted = 1  WHERE case_no = '$case_no' AND type = 'R'";

                            $this->db->query($resUpdate);

                            // if ($this->db->affected_rows() == 0)
                            // {
                            //     $this->db->trans_rollback();
                            //     log_message('error', '#RESUPDTT000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                            //     $data = array(
                            //         'error'=>"#RESUPDTT000311: Updation Settlement failed for case no : ".$case_no
                            //     );
                            //     echo json_encode($data);
                            //     return false;
                            // }

                        }
                    }

                    //***********update in settlement_ap_lmnote */
                    //*********if LM if case of case rejected the rejected remarks */
                    $reserve_dereserve = $this->input->post('re_dereservation');

                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_PGR_VGR_LAND_ID);

                    $comment = $this->input->post('lm_note');
                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');
                    $lmnote = array(
                        'chitha_verified'            => $this->input->post('chitha_verified'),
                        'vlb_verified'               => $this->input->post('vlb_verified'),
                        'possession_verification'    => $this->input->post('possession_verification'),
                        'period_possession'          => date('Y-m-d'),
                        'nature_possession'          => $this->input->post('nature_possession'),
                        'is_landless'                => $this->input->post('is_landless'),
                        'land_falls'                 => $this->input->post('land_falls'),
                        'falls_und_gmc'              => $this->input->post('falls_und_gmc'),
                        'roadside_reservation'       => $this->input->post('roadside_reservation'),
                        'zonal_valuation'            => $this->input->post('zonal_valuation'),
                        'lm_note'                    => $comment,
                        'date_update'                => date('Y-m-d h:i:s'),
                        'case_no'                    => $case_no,
                        'status'                     => 'W',
                        'protected_class_lm'         => $protected_class_lm,
                        'litigation'                 => $this->input->post('litigation'),
                        'landslide'                  => $this->input->post('landslide'),
                        'lm_remark_text'             => $this->input->post('lm_remark_text'),
                        'is_tribal_belt'             => $this->input->post('is_tribal_belt'),
                        'erosion'                    => $this->input->post('erosion'),
                        'bhumiputra_confirmation'    => $this->input->post('bhumiputra_confirmation_lm'),
                        'applied_scheme'             => $this->input->post('applied_scheme'),
                        'lm_rejected_remarks'        => json_encode($responseMasterObj->reject_remarks)
                    );
                    
                    if($reserve_dereserve == 'RESERVATION')
                    {
                        $lmnote['vgr_dag_availability'] = 'y';
                    }
                    elseif($reserve_dereserve == 'n')
                    {
                        $lmnote['vgr_dag_availability'] = 'n';
                    }
                    
                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_ap_lmnote', $lmnote);

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No ' . $case_no);
                        $data = array(
                            'error' => "#SETUP0004: Registration of settlement_ap_lmnote failed for case no : " . $case_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //// premium insert lm update start
                    if($is_prem_update=='YES'){
                        
                        $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));
                        if($checkingPremiumExistSql->num_rows() > 0)
                        {
                            $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
                            $resultprem = $this->db->query($sqlprem);

                            if ($this->db->affected_rows() == 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRSET000311: Updation Settlement failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                

                        $sumMbAmount=0;
                        foreach ($dags as $premdags) {

                            // premium verify start ******************
                            if (in_array($premdags->dist_code, json_decode(BARAK_VALLEY))){
                                $area_in_bigha=6400;
                            }else{
                                $area_in_bigha=100;
                            }
                            $concession_rate=25;
                            $ratetype=$this->input->post('rate_type'.$premdags->dag_no);
                            $ratepr2=$this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                            $ratepr = $ratepr2->rate_type;
                            $is_full_pay=$this->input->post('paymode');
                            $prem_zonal=$this->input->post('zonal_valuation_prem'.$premdags->dag_no);
                            $prem_area = $this->input->post('total_lessa'.$premdags->dag_no);
                            $prem_rate = $this->input->post('rate'.$premdags->dag_no);
                            $prem_concession =$this->input->post('concession'.$premdags->dag_no);
                            $mb_land =$this->input->post('mb_land'.$premdags->dag_no);

                            if (in_array($premdags->dist_code, json_decode(BARAK_VALLEY))){
                                if($mb_land == 25){
                                    $mb_land=1600;
                                }else if ($mb_land == 30){
                                    $mb_land=1920;
                                }else if ($mb_land == 40){
                                    $mb_land=2560;
                                }
                            }

                            if ($prem_concession=="YES"){
                                if($ratepr =='P'){
                                    
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRAM4422: Urban area flag found!'.$case_no);
                                    $this->session->set_flashdata('message', "Error #ERRAM4422: Urban case not allowed in VGR/PGR! # $case_no");
                                    redirect(base_url() . "index.php/home");
                                    // if($prem_area>$mb_land){
                                    //     $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                    //     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    //     $amount1 = ceil($premium * $discount / 100);
    
                                    //     $access_area = $prem_area - $mb_land;
                                    //     $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                                    //     $amount2 = ceil($premium2 * $discount / 100);
    
                                    //     // $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    //     // $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    //     // $amount = ($premium * $discount / 100);
                                    //     // $finalamount = ceil($amount);
                                    //     $finalamount = ceil($amount1 + $amount2);
                                    // }else{
                                    //     $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    //     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    //     $amount = ($premium * $discount / 100);
                                    //     // $finalamount = round($amount,2);
                                    //     $finalamount = ceil($amount);
                                    // }
                                    
                                }else if($ratepr =='R'){
                                    // $premium = $prem_area * $prem_rate / $area_in_bigha;
                                    // $discount = $prem_rate - $concession_rate;
                                    // $amount = ($premium * $discount / 100);
                                    // $finalamount = ceil($amount);
                                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                                    $discount = ceil($premium * ($concession_rate/100));
                                    $finalamount = ceil($premium - $discount);
                                }
    
                            }else if($prem_concession=="NO"){
                                if($ratepr =='P'){
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRAM4423: Urban area flag found!'.$case_no);
                                    $this->session->set_flashdata('message', "Error #ERRAM4423: Settlement Application not submitted case no # $case_no");
                                    redirect(base_url() . "index.php/home");
                                    // if($prem_area>$mb_land){
                                    //     $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                    //     $amount1 = ceil($premium * $prem_rate / 100);
    
                                    //     $access_area = $prem_area - $mb_land;
                                    //     $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                    //     $amount2 = ceil($premium2 * $prem_rate / 100);
    
                                    //     $finalamount = ceil($amount1 + $amount2);
                                        
                                    // }else{
                                    //     $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    //     $amount = ($premium * $prem_rate / 100);
                                    //     $finalamount = ceil($amount);
                                    // }
                                }else if($ratepr =='R'){
                                    // $premium = $prem_area * $prem_rate / $area_in_bigha;
                                    // $amount = ($premium * $prem_rate / 100);
                                    // $finalamount = ceil($amount);
                                    $finalamount = ceil($prem_area * $prem_rate / $area_in_bigha);
                                }
                            }
                            
                            // if ($prem_concession=="YES"){
                            //     if($ratepr =='P'){
                            //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                            //         $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                            //         $amount = ($premium * $discount / 100);
                            //         // $finalamount = round($amount,2);
                            //         $finalamount = ceil($amount);
                            //     }else if($ratepr =='R'){
                            //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                            //         $discount = $prem_rate - $concession_rate;
                            //         $amount = ($premium * $discount / 100);
                            //         $finalamount = ceil($amount);
                            //     }
                                
                            // }else if($prem_concession=="NO"){
                            //     if($ratepr =='P'){
                            //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                            //         $amount = ($premium * $prem_rate / 100);
                            //         $finalamount = ceil($amount);
                            //     }else if($ratepr =='R'){
                            //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                            //         $amount = ($premium * $prem_rate / 100);
                            //         $finalamount = ceil($amount);
                            //     }
                            // }

                            $sumMbAmount += $finalamount; 

                            // premium verify end ******************

                            $premdata=array(
                                'case_no'=>$case_no,
                                'user_code'=>$this->session->userdata('user_code'),
                                // 'uuid'=>$premdags->uuid,
                                'dag_no'=>$premdags->dag_no,
                                // 'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$premdags->dag_no),
                                'area_name'=>$this->input->post('area'.$premdags->dag_no),
                                'land_type'=>$this->input->post('land_type'.$premdags->dag_no),
                                'rate_type'=>$this->input->post('rate_type'.$premdags->dag_no),
                                'rate'=>$this->input->post('rate'.$premdags->dag_no),
                                'concession'=>$this->input->post('concession'.$premdags->dag_no),
                                'amount_dag'=>$this->input->post('amount'.$premdags->dag_no),
                                'final_amount'=>$this->input->post('finalamount'),
                                'due_amount'=>$this->input->post('totaldue'),
                                'total_lessa'=>$this->input->post('total_lessa'.$premdags->dag_no),
                                'is_full_pay'=>$this->input->post('paymode'),
                                'is_final'=>1,
                                'date_entry'=>date('Y-m-d h:i:s'),
                                'approve_by'=>$this->input->post('approval'.$premdags->dag_no),
                                
                            );
                            
                            $insPremiumUpdate = $this->db->insert('settlement_premium', $premdata);
                            
                            if ($insPremiumUpdate != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRSET000102: Update of Settlement failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            $approved_by = $this->input->post('approval'.$premdags->dag_no);
                        }


                        // premium verify 2 start ******************

                        // var_dump($this->db->trans_status());

                        if($sumMbAmount != $this->input->post('finalamount')){
                            // var_dump("Amount mismatch!!!"); die;
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0003: Settlement Application not submitted case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        if ($is_full_pay=="NO"){
                            $discount = 30;
                            $finaldue = ($sumMbAmount * $discount / 100);
                            // $finaldueamount = round($finaldue,2);
                            $finaldueamount = ceil($finaldue);
                        }else if ($is_full_pay=="YES"){
                            $finaldueamount= $sumMbAmount;
                        }
                        
                        if($finaldueamount != $this->input->post('totaldue')){
                            // var_dump("Due Amount mismatch!!!");
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0004: Settlement Application not submitted case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }

                        // premium verify 2 end ******************
                    }
                }


                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

                    $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                        SETTLEMENT_PGR_VGR_LAND_ID, 
                        $case_no, 
                        $application_no, 
                        $lmdata['rejected_list']
                    ); 
                }
      
                
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no'                    => $case_no,
                    'proceeding_id'              => $proceeding_id,
                    'date_of_hearing'            => date('Y-m-d h:i:s'),
                    'next_date_of_hearing'       => date('Y-m-d h:i:s'),
                    'note_on_order'              => $this->input->post('lm_remark_text'),
                    'status'                     => 'X',
                    'user_code'                  => $this->session->userdata('user_code'),
                    'date_entry'                 => date('Y-m-d h:i:s'),
                    'operation'                  => 'E',
                    'ip'                         => $this->utilityclass->get_client_ip(),
                    'office_from'                => 'LM',
                    'office_to'                  => $pending_officer,
                    'task'                       => 'LM updated note submitted',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                // echo $this->db->last_query(); die();
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    $json = [
                        'errorMessage' => "#ERRORPP: Failed to forward the case for Case No : " . $case_no,
                    ];
                    echo json_encode($json);
                    return false;
                }
                //////proceeding end//////

                ////settlement Khas LM Report insert end

                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                }
                else
                {
                    //********postAPI Basundhara */
                    $rtps_id = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                    $rmk = 'Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($rtps_id, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    //////////////////
                    // $this->DashboardInheritance($case_no['case_no']);
                    $this->session->set_flashdata('message', "Settlement Application Updated Successfully with case no # $case_no");
                    redirect(base_url() . "index.php/home");

                }
            }
        }
    }


    public function vlbEncroacherDetails(){
        if(isset($_GET['dag']) && isset($_GET['m']) && isset($_GET['l']) && isset($_GET['v']) && isset($_GET['dist']) && isset($_GET['cir']) && isset($_GET['sub_div'])){

            $dist_code = $this->input->get('dist');
            $subdiv_code = $this->input->get('sub_div');
            $circle_code = $this->input->get('cir');
            $mouza_code = $this->input->get('m');
            $lot_no = $this->input->get('l');
            $vill_townprt_code = $this->input->get('v');
            $dag_no = $this->input->get('dag');

            $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_townprt_code, $dag_no);
            $vlb_enc['vlb_enc'] = $vlb_encroacher;
            if($vlb_encroacher == true){
                // getting the encroacher details
                $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                $vlb_enc['vlb_enc_details'] = $vlb_encroacher_in_dag;
            }else{
                $vlb_enc['empty_err'] = "No Land Bank Details found!!";
            }
            $vlb_enc['_view'] = 'SettlementView/VlbEncroacherDetails';
            $this->load->view('layouts/main',$vlb_enc);
        }
    }


    public function getDags($district, $subdiv, $circle, $mouza, $lot, $village, $service)
    {
        //////mutation inheritance dag////
        if($service=='1')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation in ('a','i')) and (dag_status is null or dag_status !='NR') order by dag_no_int ");
            log_message("error", "MPR: getDags: dag query: ".json_encode($this->db->last_query()));

        }

        //////mutation deed dag////

        else if($service=='2')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation='a') and (dag_status is null or dag_status !='NR') order by dag_no_int ");

        }

        //////partition dag////
        else if($service=='3')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation='a') and (dag_status is null or dag_status !='NR') order by dag_no_int ");

        }

        //////reclassification dag////
        else if($service=='4')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation='a') and"
                . " land_class_code in (select class_code from landclass_code where class_code_cat='01') and (dag_status is null or dag_status !='NR') order by dag_no_int ");


        }

        //////AC to PP dag////
        else  if($service=='5')
        {
            // echo "Select patta_type_code, patta_no, dag_no,dag_no_int from   chitha_Basic where "
            // . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
            // . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation='n') order by dag_no_int ";
            $dag = $this->db->query("Select patta_type_code, patta_no,dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation='n') and (dag_status is null or dag_status !='NR') order by dag_no_int ");
            // var_dump($dag);

        }
        //////name correction////
        else if($service=='6')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation in ('a','i')) and (dag_status is null or dag_status !='NR') order by dag_no_int ");

        }

        //////strikeout name////
        else  if($service=='7')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where mutation in ('a','i')) and (dag_status is null or dag_status !='NR') order by dag_no_int ");

        }
        //////conversion////
        else  if($service=='9')
        {

            $dag = $this->db->query("Select patta_type_code, patta_no,dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where conversion='y') and (dag_status is null or dag_status !='NR') order by dag_no_int ");
            // var_dump($dag);

        }
        else if($service=='17')
        {
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in (select type_code from patta_code where jamabandi='n') and (dag_status is null or dag_status !='NR') order by dag_no_int ");
            log_message("error", "MPR: getDags: dag query: ".json_encode($this->db->last_query()));

        }
        else{
            $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
                . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle' and mouza_Pargona_code='$mouza' and lot_No='$lot' "
                . "and vill_townprt_code='$village' and patta_type_code in
         (select type_code from patta_code where mutation='a') and
         (dag_status is null or dag_status !='NR') order by dag_no_int ");
        }



        $data = $dag->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array(
                'dag_no' => trim($object->dag_no),
                'dag_no_int' => trim($object->dag_no_int),
            );
        }
        echo json_encode($json);
    }

    public function getArea($district, $subdiv, $circle, $mouza, $lot, $village, $dag)
    {
        $json = null;
        //$this->session->set_userdata('dist_code', $district);
        // $this->db = $this->landdetails->dbswitch();
        $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,
         patta_type_code from chitha_basic where dist_code=? and cir_code=? and
         subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=?
         and lot_no=? and dag_no=?", array($district,$circle,$subdiv,$village,$mouza,$lot,$dag));
        $data = $area->result();
        $json = array();
        foreach ($data as $object) {
            $type = $this->db->query("select patta_type from patta_code
         where type_code=?",$object->patta_type_code)->row()->patta_type;
            $json = array(
                'bigha' => trim($object->dag_area_b),
                'katha' => trim($object->dag_area_k),
                'lessa' => trim($object->dag_area_lc),
                'ganda' => trim($object->dag_area_g),
                'kranti' => trim($object->dag_area_kr),
                'patta_no' => trim($object->patta_no),
                'patta_type' => $type,
                'patta_code' => trim($object->patta_type_code),
            );
        }
        echo json_encode($json);
    }

    public function getAvailabilityDetails()
    {
        $uuid = $this->input->post('uuid');
        $case_no = $this->input->post('case_no');

        //*****getting the total applied area by applicant for reservation */
        $dags = $this->SettlementVgrModel->getSettlementDag($case_no);
        $total_min = 0;
        foreach($dags as $totalAppliedArea)
        {
            $dag_area_b = $totalAppliedArea->s_dag_area_b;
            $dag_area_k = $totalAppliedArea->s_dag_area_k;
            $dag_area_lc = $totalAppliedArea->s_dag_area_lc;
            $dag_area_g = $totalAppliedArea->s_dag_area_g;

            if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
            {
                $total_min += $this->utilityclass->Total_ganda($dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g);
            }
            else
            {
                $total_min += $this->utilityclass->Total_Lessa($dag_area_b, $dag_area_k, $dag_area_lc);
            }
        }

        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
        {
            $appBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_min);
            $applied_min = $total_min;
        }
        else
        {
            $appBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($total_min);
            $applied_min = $total_min;
        }


        $curl_handle_uuid = curl_init();
        curl_setopt($curl_handle_uuid, CURLOPT_URL, API_LINK_MB2."totalApplicationAppliedAreaOfVillageBySingleUuid");
        curl_setopt($curl_handle_uuid, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle_uuid, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle_uuid, CURLOPT_POSTFIELDS, http_build_query(array(
            'uuid' => $uuid,
        )));
        $output_uuid = curl_exec($curl_handle_uuid);
        curl_close($curl_handle_uuid);
        
        $output = json_decode($output_uuid);

        $original_dag_array = array();
        $applied_dag_array = array();

        $getLoc = $this->utilityclass->getLocationFromUUID($uuid);

        $sqlQuery = $this->db->query("SELECT l.dist_code, l.subdiv_code, l.cir_code, l.mouza_pargona_code, l.lot_no, l.vill_townprt_code, l.dag_no, c.dag_area_b, c.dag_area_k, c.dag_area_lc, c.dag_area_g, c.dag_area_kr  FROM c_land_bank_details l JOIN chitha_basic C ON l.dist_code = c.dist_code AND l.subdiv_code = c.subdiv_code AND l.cir_code = c.cir_code AND l.mouza_pargona_code = c.mouza_pargona_code AND l.lot_no = c.lot_no AND l.vill_townprt_code = c.vill_townprt_code AND l.dag_no = c.dag_no WHERE l.nature_of_reservation IN ('7', '8') AND l.dist_code = ? AND l.subdiv_code = ? AND l.cir_code = ? AND l.mouza_pargona_code = ? AND l.lot_no = ? AND l.vill_townprt_code = ?", array($getLoc->dist_code, $getLoc->subdiv_code, $getLoc->cir_code, $getLoc->mouza_pargona_code, $getLoc->lot_no, $getLoc->vill_townprt_code));


        // echo $this->db->last_query();
        if($sqlQuery->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR343437455: No data found!',
                'content' => '',
            ]);
            return false;
        }

        $chithaAreaArray = $sqlQuery->result();

        $chitha_total_ganda = 0;
        $chitha_total_lessa = 0;

        // $sort_lessa_ganda = array();

        foreach($chithaAreaArray as $chithaArea)
        {
            $original_dag_array[] = $chithaArea->dag_no;

            if($output->responseType == 2)
            {
                foreach($output->data as $dagArea)
                {
                    $total_ganda = $dagArea->barak_converted_ganda;
                    $total_lessa = $dagArea->luit_converted_lessa;
    
                    if($chithaArea->dag_no == $dagArea->dag_no)
                    {
    
                        $getAlreadyReservedAreaByLmSql = $this->db->query("SELECT 
                            SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS total_lessa_applied, 
                            SUM(dag_area_b*6400 + dag_area_k*320 + dag_area_lc*20 + dag_area_g) AS total_ganda_applied FROM settlement_vgr_pgr_reservation 
                            WHERE dist_code = ? 
                            AND subdiv_code = ? 
                            AND cir_code = ? 
                            AND mouza_pargona_code = ? 
                            AND lot_no = ? 
                            AND vill_townprt_code = ? 
                            AND dag_no = ?  
                            AND is_rejected = ?
                            GROUP BY 
                            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no", array($getLoc->dist_code, $getLoc->subdiv_code, $getLoc->cir_code, $getLoc->mouza_pargona_code, $getLoc->lot_no, $getLoc->vill_townprt_code, $dagArea->dag_no, 0));
    
                        if($getAlreadyReservedAreaByLmSql->num_rows() > 0)
                        {
                            $total_lessa_applied = $getAlreadyReservedAreaByLmSql->row()->total_lessa_applied;
                            $total_ganda_applied = $getAlreadyReservedAreaByLmSql->row()->total_ganda_applied;
                        }
                        else
                        {
                            $total_lessa_applied = 0;
                            $total_ganda_applied = 0;
                        }
    
                        $applied_dag_array[] = $dagArea->dag_no;
    
                        if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                        {
                            $chitha_bigha = $chithaArea->dag_area_b;
                            $chitha_katha = $chithaArea->dag_area_k;
                            $chitha_lessa = $chithaArea->dag_area_lc;
                            $chitha_ganda = $chithaArea->dag_area_g;
                            $chitha_kranti = $chithaArea->dag_area_kr;
        
                            $chitha_total_ganda = $this->utilityclass->Total_ganda($chitha_bigha, $chitha_katha, $chitha_lessa, $chitha_ganda);
    
                            $total_available_ganda = (float)$chitha_total_ganda - ((float)$total_ganda + (float)$total_ganda_applied);
        
                            $blkTotalApplied = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_ganda);
                            $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa2($chitha_total_ganda);
                            //*****availabe area */
                            $bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_available_ganda);
    
                            $dag_wise_table[] = (object)[
                                'dag_no' => $dagArea->dag_no,
                                'total_area_in_dag' => 'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2].' G: '.$bklChitha[3],
                    
                                'total_applied_area_in_dag' => 'B: '.$blkTotalApplied[0].' K: '. $blkTotalApplied[1].' L: '.$blkTotalApplied[2].' G: '.$blkTotalApplied[3],
                    
                                'total_available_area_in_dag' => 'B: '.$bklAvailableArea[0].' K: '. $bklAvailableArea[1].' L: '.$bklAvailableArea[2].' G: '.$bklAvailableArea[3], 
    
                                'avail_in_less_ganda' => $total_available_ganda,
    
                                'b' => $appBKL[0],
                                'k' => $appBKL[1],
                                'l' => $appBKL[2],
                                'g' => $appBKL[3],
                                'applied_min' => $applied_min,
                                'avail_min' => $total_available_ganda,
                            ];
                            
                        }
                        else
                        {
    
                            $chitha_bigha = $chithaArea->dag_area_b;
                            $chitha_katha = $chithaArea->dag_area_k;
                            $chitha_lessa = $chithaArea->dag_area_lc;
                            $chitha_ganda = $chithaArea->dag_area_g;
                            $chitha_kranti = $chithaArea->dag_area_kr;
        
                            $chitha_total_lessa = $this->utilityclass->Total_Lessa($chitha_bigha, $chitha_katha, $chitha_lessa);
    
                            // $total_available_lessa =  (float)$chitha_total_lessa - ((float)$total_lessa);
                            
    
                            $total_available_lessa =  (float)$chitha_total_lessa - ((float)$total_lessa + (float)$total_lessa_applied);
    
                            $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa($chitha_total_lessa);
                            $bklChithaApplied = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
    
                            //*****availabe area */
                            $bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa($total_available_lessa);
    
                            $dag_wise_table[] = (object)[
                                'dag_no' => $dagArea->dag_no,
                                'total_area_in_dag' => 'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2],
                    
                                'total_applied_area_in_dag' => 'B: '.$bklChithaApplied[0].' K: '. $bklChithaApplied[1].' L: '.$bklChithaApplied[2],
                    
                                'total_available_area_in_dag' => 'B: '.$bklAvailableArea[0].' K: '. $bklAvailableArea[1].' L: '.$bklAvailableArea[2],
    
                                'avail_in_less_ganda' => $total_available_lessa,
                                
                                'b' => $appBKL[0],
                                'k' => $appBKL[1],
                                'l' => $appBKL[2],
                                'g' => $appBKL[3],
                                'applied_min' => $applied_min,
                                'avail_min' => $total_available_lessa,
                            ];
    
                        }
                    }
                }
            }

        }

        $diff_dags = array_diff($original_dag_array, $applied_dag_array);

        foreach($chithaAreaArray as $chithaArea)
        {
            foreach($diff_dags as $dff)
            {
                if($dff == $chithaArea->dag_no)
                {
                    $getAlreadyReservedAreaByLmSql2 = $this->db->query("SELECT 
                        SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS total_lessa_applied, 
                        SUM(dag_area_b*6400 + dag_area_k*320 + dag_area_lc*20 + dag_area_g) AS total_ganda_applied FROM settlement_vgr_pgr_reservation 
                        WHERE dist_code = ? 
                        AND subdiv_code = ? 
                        AND cir_code = ? 
                        AND mouza_pargona_code = ? 
                        AND lot_no = ? 
                        AND vill_townprt_code = ? 
                        AND dag_no = ?  
                        AND is_rejected = ?
                        GROUP BY 
                        dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no", array($getLoc->dist_code, $getLoc->subdiv_code, $getLoc->cir_code, $getLoc->mouza_pargona_code, $getLoc->lot_no, $getLoc->vill_townprt_code, $chithaArea->dag_no, 0));

                        // echo $this->db->last_query();

                    if($getAlreadyReservedAreaByLmSql2->num_rows() > 0)
                    {
                        $total_lessa_applied2 = $getAlreadyReservedAreaByLmSql2->row()->total_lessa_applied;
                        $total_ganda_applied2 = $getAlreadyReservedAreaByLmSql2->row()->total_ganda_applied;
                    }
                    else
                    {
                        $total_lessa_applied2 = 0;
                        $total_ganda_applied2 = 0;
                    }

                    if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                    {
                    
                        $chitha_bigha = $chithaArea->dag_area_b;
                        $chitha_katha = $chithaArea->dag_area_k;
                        $chitha_lessa = $chithaArea->dag_area_lc;
                        $chitha_ganda = $chithaArea->dag_area_g;
                        $chitha_kranti = $chithaArea->dag_area_kr;
        
                        $chitha_total_ganda = $this->utilityclass->Total_ganda($chitha_bigha, $chitha_katha, $chitha_lessa, $chitha_ganda);
        
                        //$total_available_ganda = (float)$total_ganda - (float)$chitha_total_ganda;
        
                        //$blkTotalApplied = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_ganda);
                        $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa2((float)$chitha_total_ganda - (float)$total_ganda_applied2);
                        //*****availabe area */
                        //$bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_available_ganda);
        
                        $dag_wise_table[] = (object)[
                            'dag_no' => $chithaArea->dag_no,
                            'total_area_in_dag' =>  'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2].' G: '.$bklChitha[3],
                
                            'total_applied_area_in_dag' => '-',
                
                            'total_available_area_in_dag' => 'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2].' G: '.$bklChitha[3],

                            'avail_in_less_ganda' => $chitha_total_ganda,

                            'b' => $appBKL[0],
                            'k' => $appBKL[1],
                            'l' => $appBKL[2],
                            'g' => $appBKL[3],
                            'applied_min' => $applied_min,
                            'avail_min' => (float)$chitha_total_ganda - (float)$total_ganda_applied2,
                
                        ];
                        
                    }
                    else
                    {
        
                        $chitha_bigha = $chithaArea->dag_area_b;
                        $chitha_katha = $chithaArea->dag_area_k;
                        $chitha_lessa = $chithaArea->dag_area_lc;
                        $chitha_ganda = $chithaArea->dag_area_g;
                        $chitha_kranti = $chithaArea->dag_area_kr;
        
                        $chitha_total_lessa = $this->utilityclass->Total_Lessa($chitha_bigha, $chitha_katha, $chitha_lessa);
        
                        //$total_available_lessa = (float)$total_lessa - (float)$chitha_total_lessa;
        
                        $bklChitha = $this->utilityclass->Total_Bigha_Katha_Lessa((float)$chitha_total_lessa - (float)$total_lessa_applied2);
                        //$bklChithaApplied = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
        
                        //*****availabe area */
                        //$bklAvailableArea = $this->utilityclass->Total_Bigha_Katha_Lessa($total_available_lessa);
        
                        $dag_wise_table[] = (object)[
                            'dag_no' => $chithaArea->dag_no,
                            'total_area_in_dag' => 'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2],
                
                            'total_applied_area_in_dag' => '-',
                
                            'total_available_area_in_dag' => 'B: '.$bklChitha[0].' K: '. $bklChitha[1].' L: '.$bklChitha[2],

                            'avail_in_less_ganda' => $chitha_total_lessa,

                            'b' => $appBKL[0],
                            'k' => $appBKL[1],
                            'l' => $appBKL[2],
                            'g' => $appBKL[3],
                            'applied_min' => $applied_min,
                            'avail_min' => (float)$chitha_total_lessa - (float)$total_lessa_applied2,
                        ];

                    }
                }
            }
          
        }
      
        $key_values = array_column($dag_wise_table, 'avail_in_less_ganda'); 
        array_multisort($key_values, SORT_DESC, $dag_wise_table);
        // echo json_encode($dag_wise_table);

        // echo "<pre>";
        // var_dump($dag_wise_table);
        // die;
        echo json_encode([
            'responseType' => 2,
            'content'   => $dag_wise_table,
        ]);
    }

    public function getPattaDetails()
    {
        $uuid = $this->input->post('uuid');
        $dag_no = $this->input->post('dag_no');

        $getLoc = $this->db->query("SELECT * FROM location WHERE uuid = ?", array($uuid));

        if($getLoc->num_rows() <= 0)
        {
            echo json_encode('ERR323DD33: Something went wrong!');
            return false;
        }

        $result = $getLoc->row();

        $dist_code = $result->dist_code;
        $subdiv_code = $result->subdiv_code;
        $cir_code = $result->cir_code;
        $mouza = $result->mouza_pargona_code;
        $lot_no = $result->lot_no;
        $vill_townprt_code = $result->vill_townprt_code;

        $pattaQuery = $this->db->query("SELECT patta_type_code, patta_no FROM chitha_basic WHERE dist_code=? AND cir_code=? AND
        subdiv_code=? AND vill_townprt_code=? AND mouza_pargona_code=? AND lot_no=? AND dag_no=?", array($dist_code, $cir_code, $subdiv_code, $vill_townprt_code, $mouza, $lot_no, $dag_no));

        if($pattaQuery->num_rows() <= 0)
        {
            echo json_encode('ERR32DC33: Something went wrong!');
            return false;
        }

        echo json_encode([
            'patta_type_code' => $pattaQuery->row()->patta_type_code,
            'patta_no' => $pattaQuery->row()->patta_no,
            'patta_type' => $this->utilityclass->getPattaType($pattaQuery->row()->patta_type_code),
        ]);

    }
    public function editAreaPremium()
    { 
        die();
        $final_amount =0;
        $amount_dag =0;
        $case_no='KAM/PAL/2022-23/2594/SKHAS';;
        $dag_no = array("295", "267");
        $arrlength = count($dag_no);
        $newlessa=4;

        for($i = 0; $i < $arrlength; $i++) {
            $result = $this->SettlementCommonModel->calculateNewPremium($case_no, $dag_no[$i], $newlessa);

            $newPrem = json_decode($result);
            $amount_dag = $newPrem->amount_dag;
            $final_amount += $amount_dag;

            // update or insert premium against dag here
        }
        
        var_dump($final_amount); die;
    }

    public function vgrReservationDistrict()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_townprt_code = $this->input->post('village_townprt_code');

        $user_desig_code = $this->session->userdata('user_desig_code');

    }


    public function vgrReservationLot()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_townprt_code = $this->input->post('vill_townprt_code');

        $user_desig_code = $this->session->userdata('user_desig_code');

        if(!empty($village_townprt_code))
        {
            $appliedVillageUUID = $this->utilityclass->getVillageUUID($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$village_townprt_code);
        }
        else
        {
            $appliedVillageUUID = null;
        }


        $villageListInALot  = $this->SettlementVgrModel->getVillageList($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $uuidSInLot = array();
        foreach($villageListInALot as $uuidFrmVill)
        {
            $uuidSInLot[] = $uuidFrmVill->uuid;
        }

        $stringUuidInLot = "'" . implode ( "','", $uuidSInLot ) . "'";

        //***********API for getting the applied area in villages */
        $curl_handle_uuid = curl_init();
        curl_setopt($curl_handle_uuid, CURLOPT_URL, API_LINK_MB2."totalAppliedAreaByUuids");
        curl_setopt($curl_handle_uuid, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle_uuid, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle_uuid, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle_uuid, CURLOPT_POSTFIELDS, http_build_query(array(
            'uuid' => $stringUuidInLot,
            // 'uuid' => "'10000000004530','10000000004531'",
        )));
        $output_uuid = curl_exec($curl_handle_uuid);
        curl_close($curl_handle_uuid);
        
        $output_uuid = json_decode($output_uuid);

        //*****getting data from chitha */
        $lotArray = array();
        $apiLotArray = array();
        $api_uuid = array();
        $chitha_uuid = array();
        
        foreach($uuidSInLot as $chithaUuid)
        {
            $getLoc = $this->utilityclass->getLocationFromUUID($chithaUuid);

            $sqlGetChitha = $this->db->query("SELECT  c.dist_code,  c.subdiv_code,  c.cir_code,  c.mouza_pargona_code,  c.lot_no,  SUM(c.dag_area_b*100 + c.dag_area_k*20 + c.dag_area_lc) AS total_lessa_in_chitha, SUM(c.dag_area_b*6400 + c.dag_area_k*320 + c.dag_area_lc*20 + c.dag_area_g) AS total_ganda_in_chitha
            FROM chitha_basic c

            JOIN c_land_bank_details l
            ON l.dist_code = c.dist_code 
            AND l.subdiv_code = c.subdiv_code 
            AND l.cir_code = c.cir_code 
            AND l.mouza_pargona_code = c.mouza_pargona_code 
            AND l.lot_no = c.lot_no 
            AND l.vill_townprt_code = c.vill_townprt_code 
            AND l.dag_no = c.dag_no 
            WHERE l.nature_of_reservation IN ('7', '8')
            
            AND 
                c.dist_code = ? 
            AND 
                c.subdiv_code = ? 
            AND 
                c.cir_code = ? 
            AND 
                c.mouza_pargona_code = ?
            AND
                c.lot_no = ? 
            AND 
                c.vill_townprt_code = ?
            GROUP BY 
                c.dist_code, c.subdiv_code, c.cir_code, c.mouza_pargona_code, c.lot_no", 
                array($getLoc->dist_code, $getLoc->subdiv_code, $getLoc->cir_code, $getLoc->mouza_pargona_code, $getLoc->lot_no, $getLoc->vill_townprt_code));

            if($sqlGetChitha->num_rows() <= 0)
            {
                continue;
            }

            $chithaResult = $sqlGetChitha->result();

         
            //*******chitha village details */
            foreach($chithaResult as $cRes)
            {
                //*****API applied */
                if($output_uuid->responseType == 2)
                {
                    foreach($output_uuid->data as $vil_uuid)
                    {
                        if($vil_uuid->uuid == $chithaUuid)
                        {
                            if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                            {
                                $totalAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($cRes->total_ganda_in_chitha);

                                $appliedArea = $vil_uuid->barak_converted_ganda;

                                $availableArea = (float)$cRes->total_ganda_in_chitha - (float)$appliedArea;

                                $appliedAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($appliedArea);

                                $availableAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($availableArea);

                                $api_uuid[] = $vil_uuid->uuid;

                                $apiLotArray[] = (object)[
                                    'vil_uuid' => $vil_uuid->uuid,
                                    'vil_name' => $this->utilityclass->getVillageNameByUUID($vil_uuid->uuid),
                                    'total_area_in_village' => 'B: '.$totalAreaBKL[0].' K: '. $totalAreaBKL[1].' C: '.$totalAreaBKL[2]. 'G: '.$totalAreaBKL[3] ,
                                    
                                    'total_applied_area' => 'B: '.$appliedAreaBKL[0].' K: '. $appliedAreaBKL[1].' C: '.$appliedAreaBKL[2]. 'G: '.$appliedAreaBKL[3] ,
            
                                    'total_available_area' => 'B: '.$availableAreaBKL[0].' K: '. $availableAreaBKL[1].' C: '.$availableAreaBKL[2]. 'G: '.$availableAreaBKL[3] ,
            
                                    'avail_in_less_ganda' => $availableArea
                                ];

                            }
                            else
                            {
                                $totalAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($cRes->total_lessa_in_chitha);

                                $appliedArea = $vil_uuid->barak_converted_ganda;

                                $availableArea = (float)$cRes->total_lessa_in_chitha - (float)$appliedArea;

                                $appliedAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($appliedArea);

                                $availableAreaBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($availableArea);

                                $api_uuid[] = $vil_uuid->uuid;

                                $apiLotArray[] = (object)[
                                    'vil_uuid' => $vil_uuid->uuid,
                                    'vil_name' => $this->utilityclass->getVillageNameByUUID($vil_uuid->uuid),
                                    'total_area_in_village' => 'B: '.$totalAreaBKL[0].' K: '. $totalAreaBKL[1].' L: '.$totalAreaBKL[2],
                                    
                                    'total_applied_area' => 'B: '.$appliedAreaBKL[0].' K: '. $appliedAreaBKL[1].' L: '.$appliedAreaBKL[2],
            
                                    'total_available_area' => 'B: '.$availableAreaBKL[0].' K: '. $availableAreaBKL[1].' L: '.$availableAreaBKL[2],
            
                                    'avail_in_less_ganda' => $availableArea
                                ];
                            }
                        }
                    }
                }

                //****chitha */
                if(in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
                {

                    $bkl = $this->utilityclass->Total_Bigha_Katha_Lessa2($cRes->total_ganda_in_chitha);

                    $chitha_uuid[] = $chithaUuid;

                    $lotArray[] = (object)[
                        'vil_uuid' => $chithaUuid,
                        'vil_name' => $this->utilityclass->getVillageNameByUUID($chithaUuid),
                        'total_area_in_village' => 'B: '.$bkl[0].' K: '. $bkl[1].' C: '.$bkl[2]. 'G: '.$bkl[3] ,
                        
                        'total_applied_area' => '-',

                        'total_available_area' => 'B: '.$bkl[0].' K: '. $bkl[1].' C: '.$bkl[2]. 'G: '.$bkl[3] ,

                        'avail_in_less_ganda' => $cRes->total_ganda_in_chitha
                    ];
                }
                else
                {
                    $bkl = $this->utilityclass->Total_Bigha_Katha_Lessa($cRes->total_lessa_in_chitha);
                    
                    $chitha_uuid[] = $chithaUuid;

                    $lotArray[] = (object)[
                        'vil_uuid' => $chithaUuid,
                        'vil_name' => $this->utilityclass->getVillageNameByUUID($chithaUuid),
                        'total_area_in_village' => 'B: '.$bkl[0].' K: '. $bkl[1].' L: '.$bkl[2],
                        'total_applied_area' => '-',
                        'total_available_area' => 'B: '.$bkl[0].' K: '. $bkl[1].' L: '.$bkl[2],
                        'avail_in_less_ganda' => $cRes->total_lessa_in_chitha
                    ];
                }
            }
        }

        $diff = array_diff($chitha_uuid, $api_uuid);
        
        $finalArray = array();
        $sortByAvailableArea= array();

        foreach($diff as $df)
        {
            foreach($lotArray as $cLot)
            {
                if($df == $cLot->vil_uuid)
                {
                    $finalArray[] = (object)[
                        'vil_uuid' => $cLot->vil_uuid,
                        'vil_name' => $cLot->vil_name,
                        'total_area_in_village' => $cLot->total_area_in_village,
                        'total_applied_area' => $cLot->total_applied_area,
                        'total_available_area' => $cLot->total_available_area,
                        'avail_in_less_ganda' => $cLot->avail_in_less_ganda,
                    ];
                    $sortByAvailableArea[] = $cLot->avail_in_less_ganda;
                }
            }
        }
 
     
        foreach($apiLotArray as $aLot)
        {
            // if($cLot->vil_uuid == $aLot->vil_uuid)
            // {
                $finalArray[] = (object)[
                    'vil_uuid' => $aLot->vil_uuid,
                    'vil_name' => $aLot->vil_name,
                    'total_area_in_village' => $aLot->total_area_in_village,
                    'total_applied_area' => $aLot->total_applied_area,
                    'total_available_area' => $aLot->total_available_area,
                    'avail_in_less_ganda' => $aLot->avail_in_less_ganda,
                ];
                
                $sortByAvailableArea[] = $aLot->avail_in_less_ganda;
            //}
        }
        

        asort($sortByAvailableArea, SORT_NUMERIC);
        $sortByAvailableArea = array_reverse($sortByAvailableArea, true);

        // arsort($sortingAvailableArea);
        $sorted_final_data = array();


        if($appliedVillageUUID != null)
        {
            foreach($finalArray as $finAr)
            {
                if($finAr->vil_uuid == $appliedVillageUUID)
                {
                    $sorted_final_data[] = $finAr;
                }
            }
        }

        foreach($sortByAvailableArea as $sort)
        {
            foreach($finalArray as $finAr)
            {
                if($appliedVillageUUID != null)
                {
                    if($finAr->vil_uuid != $appliedVillageUUID)
                    {   
                        if($sort == $finAr->avail_in_less_ganda)
                        {
                            $sorted_final_data[] = $finAr;
                        }
                    }
                }
                else
                {
                    if($sort == $finAr->avail_in_less_ganda)
                    {
                        $sorted_final_data[] = $finAr;
                    }
                }               
            }
        }

        echo json_encode([
            'responseType' => 2,
            'content' => $sorted_final_data
        ]);

    }


    public function submitLmVgrData()
    {
        $uuid = $this->input->post('uuid');
        $dag_no = $this->input->post('dag_no');
        $bigha = $this->input->post('bigha');
        $katha = $this->input->post('katha');
        $lessa = $this->input->post('lessa');
        $ganda = $this->input->post('ganda');
        $case_no = $this->input->post('case_no');
        $reservation = $this->input->post('reservation');

        $this->db->trans_begin();

        if(empty($reservation))
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5089: Unable to process! Please insert reservation details before processing...'
            ]);
            return false;
        }

        if($reservation == 'n')
        {
            $reservation = 'n';
        }
        else
        {
            $reservation = 'y';
        }

        $checkExist = $this->db->query("SELECT * FROM settlement_vgr_pgr_reservation WHERE uuid = ? AND dag_no = ? AND case_no = ?", array($uuid, $dag_no, $case_no));

        if($checkExist->num_rows() > 0)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'msg' => 'Reservation area already inserted...'
            ]);
            return false;
        }

        $location = $this->utilityclass->getLocationFromUUID($uuid);

        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
        {
            $total_applied_lessa = $this->utilityclass->Total_ganda($bigha, $katha, $lessa, $ganda);
        }
        else
        {
            $total_applied_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
        }

        $checkReserv = $this->SettlementVgrModel->getTotalVgrReservationInDagSubmitCheck($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code, $dag_no, $total_applied_lessa);

        if($checkReserv['responseType'] != 2)
        {
            echo json_encode([
                'responseType' => 1,
                'msg' => '#ERR5702: Chitha area exceed for reservation!'
            ]);
            return false;
        }
        //********check for roadside reservation availability / if yes then minus the roadside reservation from reservation area */
        // $sqlRoad = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no, 1));

        // if($sqlRoad->num_rows() > 0)
        // {
        //     //*****calculate the area for reservation */
        //     $totLRes = $sqlRoad->result();

        //     $total_lessa_to_be_reserved = 0;
        //     foreach($totLRes as $ll)
        //     {
        //         $total_lessa_to_be_reserved += $ll->total_lessa;
        //     }

        //     if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))
        //     {
        //         $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa_to_be_reserved);
        //     }
        //     else
        //     {
        //         $bklg = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa_to_be_reserved);
        //     }

        //     $insertArr = [
        //         'dist_code' => $location->dist_code,
        //         'subdiv_code' => $location->subdiv_code,
        //         'cir_code' => $location->cir_code,
        //         'mouza_pargona_code' => $location->mouza_pargona_code,
        //         'lot_no' => $location->lot_no,
        //         'vill_townprt_code' => $location->vill_townprt_code,
        //         'uuid' => $uuid,
        //         'user_code' => $this->session->userdata('user_code'),
        //         'dag_no' => $dag_no,
        //         'dag_area_b' => $bklg[0], 
        //         'dag_area_k' => $bklg[1], 
        //         'dag_area_lc' => $bklg[2], 
        //         'dag_area_g' => $bklg[3], 
        //         'case_no' => $case_no
        //     ];
        // }
        // else
        // {
            $insertArr = [
                'dist_code' => $location->dist_code,
                'subdiv_code' => $location->subdiv_code,
                'cir_code' => $location->cir_code,
                'mouza_pargona_code' => $location->mouza_pargona_code,
                'lot_no' => $location->lot_no,
                'vill_townprt_code' => $location->vill_townprt_code,
                'uuid' => $uuid,
                'user_code' => $this->session->userdata('user_code'),
                'dag_no' => $dag_no,
                'dag_area_b' => $bigha, 
                'dag_area_k' => $katha, 
                'dag_area_lc' => $lessa, 
                'dag_area_g' => $ganda, 
                'case_no' => $case_no
            ];
        //}

        $insert = $this->db->insert('settlement_vgr_pgr_reservation', $insertArr);

        if($insert != true)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR6862->table->settlement_vgr_pgr_reservation->->'.$this->db->last_query());
            echo json_encode([
                'responseType' => 1,
                'msg' => '#ERR6862: Something went wrong! Contact admin...'
            ]);
            return false;
        }

        //******check and update settlement_ap_lmnote table vgr_pgr_availability col */
        $sqlLm = $this->db->query('select * from settlement_ap_lmnote where case_no = ?', array($case_no));

        if($sqlLm->num_rows() > 0)
        {
            $lmRowReservation = $sqlLm->row()->vgr_dag_availability;

            if($lmRowReservation != $reservation)
            {
                $lmnoteAr = [
                    'vgr_dag_availability' => $reservation,
                    'date_update' => date('Y-m-d H:i:s'),
                ];
    
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_ap_lmnote', $lmnoteAr);
        
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR5229: Update failed in settlement_ap_lmnote'. $this->db->last_query());
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR5157: Unable to send to LM! Contact admin...'
                    ]);
                    return false;
                }
            }
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Reservation/Dereservation details successfully saved..'
        ]);
        return false;

    }

    public function getPreviouslyInsertedVgrLotData()
    {
        $dist_code = $this->input->post('dist_code'); 
        $subdiv_code = $this->input->post('subdiv_code');
        
        if(!empty($this->input->post('cir_code')))
        {
            $cir_code = $this->input->post('cir_code');
        }
        else
        {
            $cir_code = '00';
        }

        if(!empty($this->input->post('mouza_pargona_code')))
        {
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        }
        else
        {
            $mouza_pargona_code = '00';
        }

        if(!empty($this->input->post('lot_no')))
        {
            $lot_no = $this->input->post('lot_no');
        }
        else
        {
            $lot_no = '00';
        }

        // $sql = $this->db->query("select * from settlement_vgr_pgr_reservation where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no));

        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_reservation');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        if($cir_code != '00')
        {
            $this->db->where('cir_code', $cir_code);
        }
        if($mouza_pargona_code != '00')
        {
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        }
        if($lot_no != '00')
        {
            $this->db->where('lot_no', $lot_no);
        }

        $sql = $this->db->get();

        if($sql->num_rows() <=0)
        {
            echo json_encode([
                'responseType' => 1,
                'content' => ''
            ]);
            return false;
        }

        $selected_village_uuid_array = array();
        $selected_dags_array = array();
        $selected_lot_array = array();
        $selected_dist_sub_cir_array = array();

        $res = $sql->result();

        foreach($res as $re)
        {
            $selected_village_uuid_array[] = $re->uuid;
            $selected_dags_array[] = $re->dag_no;
            $selected_dist_sub_cir_mouza_lot_array[] = $re->dist_code.$re->subdiv_code.$re->cir_code.$re->mouza_pargona_code.$re->lot_no;
            $selected_dist_sub_cir_array[] = $re->dist_code.$re->subdiv_code.$re->cir_code;
        }

        echo json_encode([
            'responseType' => 2,
            'content' => (object)[
                'selected_village_uuid_array' => $selected_village_uuid_array,
                'selected_dags_array' => $selected_dags_array,
                'selected_dist_sub_cir_mouza_lot_array' => $selected_dist_sub_cir_mouza_lot_array,
                'selected_dist_sub_cir_array' => $selected_dist_sub_cir_array,
            ]
        ]);
    }

    public function reservationNotAvailableDelete()
    {
        $case_no = $this->input->post('case_no');
        $this->db->query('delete from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));
    }

    public function checkIfReserveAreaInsertedForCase()
    {

        $case_no = $this->input->post('case_no');

        $sql = $this->db->query('select * from settlement_vgr_pgr_reservation where case_no = ?', array($case_no));
        if($sql->num_rows() > 0)
        {
            $row = $sql->row();

            $case_no = $row->case_no;

            $dist_name = $this->utilityclass->getDistrictName($row->dist_code);

            $subdiv_name = $this->utilityclass->getSubDivName($row->dist_code,$row->subdiv_code);

            $cir_name = $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code);

            $mouza_name = $this->utilityclass->getMouzaName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code);

            $lot_name = $this->utilityclass->getLotName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no);

            $vill_name = $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code);

            $dag_no = $row->dag_no;
            
            $area = '';
            if (in_array($row->dist_code, json_decode(BARAK_VALLEY)))
            {
                $area = "B: ".$row->dag_area_b. " K: ".$row->dag_area_k. " C: ".$row->dag_area_lc. " G: ".$row->dag_area_g;

            }
            else
            {
                $area = "B: ".$row->dag_area_b. " K: ".$row->dag_area_k. " L: ".$row->dag_area_lc;
            }

            echo json_encode([
                'responseType' => 2,
                'content' => (object)[
                    'case_no' => $case_no,
                    'dist_name' => $dist_name,
                    'subdiv_name' => $subdiv_name,
                    'cir_name' => $cir_name,
                    'mouza_name' => $mouza_name,
                    'lot_name' => $lot_name,
                    'vill_name' => $vill_name,
                    'dag_no' => $dag_no,
                    'area' => $area,
                    'user_name' => $this->utilityclass->getUserNameByUserCode($row->user_code)
                ]
            ]);
        }
        else
        {
            echo json_encode([
                'responseType' => 1,
                'content' => ''
            ]);
        }
    }


    public function vgrReservationInquiryList()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        $sql = $this->db->query('select * from settlement_vgr_lm_assign where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and user_code = ? and status = ?', array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code, 'AB'));

        if($sql->num_rows() <= 0)
        {
            $data['res'] = '';
        }
        else
        {
            $res = $sql->result();
        }

        $data['res'] = $res;
        $data['_view'] = 'SettlementView/lm_assign_list';
        $this->load->view('layouts/main', $data);
    }


    public function vgrAssignedReservation()
    {
        $data['case_no'] = $this->input->get('case');

        $data['dist_code'] = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $this->session->userdata('lot_no');

        $data['_view'] = 'SettlementView/vgr_assigned_case';
        $this->load->view('layouts/main', $data);
    }

    public function reSubmitVgrProposal()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $reservation = $this->input->post('reservation');

        if(empty($reservation))
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5186: Unable to forward to CO! Contact admin...'
            ]);
            return false;
        }

        if($reservation == 'n')
        {
            $reservation = 'n';
        }
        else
        {
            $reservation = 'y';
        }

        
        $this->db->trans_begin();

        $sqlLm = $this->db->query('select * from settlement_ap_lmnote where case_no = ?', array($case_no));

        if($sqlLm->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5200: Unable to forward to CO! Contact admin...'
            ]);
            return false;
        }

        $lmRowReservation = $sqlLm->row()->vgr_dag_availability;

        if($lmRowReservation != $reservation)
        {
            $lmnoteAr = [
                'vgr_dag_availability' => $reservation,
                'date_update' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_ap_lmnote', $lmnoteAr);
    
            if($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR5229: Update failed in settlement_ap_lmnote'. $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR5229: Unable to send to LM! Contact admin...'
                ]);
                return false;
            }
        }

        //***settlement_basic update */
        $basicArr = [
            'status' => 'AC',
            // 'co_code' => $this->session->userdata('user_code'),
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO'
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3346: Update failed in settlement_basic'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3346: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }

        $insertVgrLmAssign = [
            // 'case_no' => $case_no,
            // 'dist_code' => $dist_code,
            // 'subdiv_code' => $subdiv_code,
            // 'cir_code' => $cir_code,
            // 'mouza_pargona_code' => $mouza_pargona_code,
            // 'lot_no' => $lot_no,
            // 'user_code' => $lm_code,
            'status' => 'AC',
            'date_update' => date('Y-m-d H:i:s')
            // 'date_update'
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_vgr_lm_assign', $insertVgrLmAssign);

        if($this->db->affected_rows() == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3395: Update failed in settlement_vgr_lm_assign'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3395: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }


        //******insert into settlement_proceeding */
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            // 'note_type' => $remark_co,
            'note_on_order' => $remark,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'Sent to CO with new VGR/PGR Reservation details'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR3401: Insertion failed in settlement_proceeding'. $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3401: Unable to send to LM! Contact admin...'
            ]);
            return false;
        }

        //*******postAPIBasundhara */
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
    
        $rmk='Forwarded to CO';
        $status='M';
        $task='LM';
        $pen='CO';
        $case=$case_no;
        $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status=json_decode($rtps_status);
        //var_dump($rtps_status);
        if(trim($rtps_status) != "y")
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3453: Unable to send to CO! Contact admin...'
            ]);
            return false;
        }
        else
        {
            $this->db->trans_commit();

            echo json_encode([
                'responseType' => 2,
                'msg' => 'Case successfully sent to CO...'
            ]);
        }
    }

}