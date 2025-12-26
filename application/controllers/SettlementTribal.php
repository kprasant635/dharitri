<?php
class SettlementTribal extends CI_Controller
{

    public function __construct()
    {
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
        $this->load->library('upload');
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

    public function applied_area_check()
    {
        return false;
    }

    public function agiAreaMoreThanDagA()
    {
        return false;
    }

    public function homeAreaMoreThanDagA()
    {
        return false;
    }

    public function reserveMoreThanAppArea()
    {
        return false;
    }

    public function totalAppliedAreaMoreThanDagArea()
    {
        return false;
    }

    public function tribalMaxHomestead()
    {
        return false;
    }

    public function tribalMaxAgriculture()
    {
        return false;
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // ***********************************************************************
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

    // insert in dharitree table on click write report from list, added on 12/01/2023
    public function TribalApplicationRegistration($review_flag = false)
    {

        $application_no = $this->input->get('app'); // get rtps application no

        $application_no = $this->utilityclass->decryptJwtCase($application_no);
        //$redirect = 'index.php/SettlementTribal/TribalApplicationRegistration?app=' . $application_no;

        // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO));
        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));
        if ($supportive_document_sql == true) {
            if ($supportive_document_sql->num_rows() > 0) {
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            } else {
                $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }
        }

        // check if case already registered
        $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);

        if (!$recordExist) {

            // get data from basundhara end (API call)
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'api_key' => API_KEY,
                'token' => $token,
            )));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                if (json_decode($output)->responseType == 3) {
                    echo json_decode($output)->data . " - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);



            // get AADHAAR PHOTO (API CALL)
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getApplicantPhoto");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);
            if ($get_aadhaar_photo != 'n') {
                $district['aadhaar_b64_decoded'] = "<img src = data:" . $this->decodeBase64($get_aadhaar_photo) . ";base64," . $get_aadhaar_photo . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            }

            $app = $output->application;
            $d = $app->dist_code;
            $s = $app->subdiv_code;
            $c = $app->cir_code;
            $m = $app->mouza_code;
            $l = $app->lot_no;
            $v = $app->village_code;
            $dag = $app->dag_no;

            $case_name = $this->SettlementApiModel->genearteCaseName(); // generate case name
            if (empty($case_name)) {
                log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                return false;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->SettlementApiModel->genearteSettlementPetitionNo();
            $case_no['case_no'] = $case_name . $petition_no . "/" . SETTLEMENT_TRIBAL_COMMUNITY;

            //check for tribal belt
            if ($output->applicants['0']->under_tribe_belts == 1) {
                $tribal_belt = 'YES';
            } else if ($output->applicants['0']->under_tribe_belts == 0) {
                $tribal_belt = 'NO';
            } else {
                $tribal_belt = '';
            }

            //check for bhumiputra certificate starts here
            if (!empty($output->bhumi['0'])) {

                if ($output->bhumi['0']->bhumi_cert_available == 1) { //if bhumiputra available
                    $bhumiputra_confirmation = 'YES';
                    $bhumiputra_certificate_no = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'CERT';
                } else if ($output->bhumi['0']->is_bhumi_applied == 1) { //if applied in bhumiputra
                    $bhumiputra_confirmation = 'YES';
                    $bhumiputra_certificate_no = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'ACK';
                } else {
                    $bhumiputra_confirmation = '0';
                    $bhumiputra_certificate_no = '0';
                    $bhumiputra_certificate_type = '0';
                }
            } else {
                $bhumiputra_confirmation = '0';
                $bhumiputra_certificate_no = '0';
                $bhumiputra_certificate_type = '0';
            }

            $this->db->trans_begin(); // transaction begins here

            // insertion in backup table (lm)
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

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM

            if(isset($output->applicants)){
                foreach($output->applicants as $type_of_lands){
                    if($type_of_lands->is_applicant == 1){
                        $api_free_encroachment = $type_of_lands->free_encrochment;
                        $applicant_occupation = $type_of_lands->applicant_occupation;
                        $applicant_ref_no = $type_of_lands->ref_no;
                        $applicant_caste_category= $type_of_lands->caste_category;
                        $applicant_uuid= $type_of_lands->uuid;
                    }
                }
            }

            $settlement_basic = [
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' => $m,
                'lot_no' => $l,
                'vill_townprt_code' => $v,
                'service_code' => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                'ref_no' => $applicant_ref_no,
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F',
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'Z',
                'submission_date' => date('Y-m-d G:i:s'),
                'period_possession' => date('Y-m-d'),
                'occupation_applicant' => $applicant_occupation,
                'applid' => $application_no,
                'caste' => $applicant_caste_category,
                'uuid' => $applicant_uuid,
                'tribal_belt' => $tribal_belt,
                'bhumiputra_confirmation' => $bhumiputra_confirmation,
                'bhumiputra_certificate_no' => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                'user_code' => $this->session->userdata('user_code'),
                'is_occupying_land' => $api_free_encroachment
            ];

            $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);
            if ($settlement_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Settlement failed for RTPS application no : " . $application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //insert into ADDITIONAL PROPERTY
            $checkAdditionalProperty = $this->SettlementCommonModel->getAdditionalPropertyDetail($application_no);
            if ($checkAdditionalProperty->num_rows() == 0) {
                if (isset($output->property)) {
                    foreach ($output->property as $value) {
                        $add_property = [
                            'case_no' => $case_no['case_no'],
                            'dist_code' => $value->dist_code,
                            'subdiv_code' => $value->subdiv_code,
                            'cir_code' => $value->cir_code,
                            'mouza_pargona_code' => $value->mouza_pargona_code,
                            'lot_no' => $value->lot_no,
                            'vill_townprt_code' => $value->vill_townprt_code,
                            'bigha' => $value->bigha,
                            'katha' => $value->katha,
                            'lessa' => $value->lessa,
                            'chatak' => $value->lessa,
                            'ganda' => $value->ganda,
                            'kranti' => $value->kranti,
                            'entry_date' => date('Y-m-d h:i:s'),
                            'is_rural' => $value->is_rural,
                            'dag_no' => $value->dag_no,
                            'patta_no' => $value->patta_no,
                            'service_id' => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                            'applied_flag' => CITIZEN,
                            'dist_name' => trim($value->dist_name),
                            'cir_name' => trim($value->cir_name),
                            'vill_name' => trim($value->vill_name),
                            'applid' => $application_no,
                        ];
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No ' . $application_no . ' and
                  query is ' . $this->db->last_qery());
                            $data = array(
                                'error' => "#ERROR0004: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            foreach ($output->encroachers as $dags_details) {

                $district['class']=$this->utilityclass->getPattaTypeNo($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code, $dags_details->dag_no);

                $enc_home_bigha = $dags_details->mbigha;
                $enc_home_katha = $dags_details->mkatha;
                $enc_home_lessa = $dags_details->mlessa;
                $enc_home_ganda = $dags_details->mganda;
                $enc_home_kranti = $dags_details->mkranti;

                $enc_agri_bigha = $dags_details->agri_bigha;
                $enc_agri_katha = $dags_details->agri_katha;
                $enc_agri_lessa = $dags_details->agri_lessa;
                $enc_agri_ganda = $dags_details->agri_ganda;
                $enc_agri_kranti = $dags_details->agri_kranti;

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
                    'dist_code'=>$app->dist_code,
                    'subdiv_code'=>$app->subdiv_code,
                    'cir_code'=>$app->cir_code,
                    'mouza_pargona_code'=>$app->mouza_code,
                    'lot_no'=>$app->lot_no,
                    'vill_townprt_code'=>$app->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'new_land_class_code' => $district['class']->land_class_code,
                    'dag_no' => $dags_details->dag_no,
                    'patta_no' => $dags_details->patta_no,
                    'patta_type_code' => $dags_details->patta_code,
                    'is_urban' => $app->is_urban,
                    'land_type' => $dags_details->land_type,
                    'revenue' => 0,
                    'operation' => 'E',
                    // 'landmark' => json_encode($landmark),
                    'encroachement_area' => json_encode($encroachment_area)
                );

                $fmd['dag_area_b']=$dags_details->applied_bigha;
                $fmd['dag_area_k']=$dags_details->applied_katha;
                $fmd['dag_area_lc']=$dags_details->applied_lessa;
                $fmd['dag_area_g']=$dags_details->applied_ganda;
                $fmd['dag_area_kr']=$dags_details->applied_kranti;

                $fmd['home_b']=$dags_details->mbigha;
                $fmd['home_k']=$dags_details->mkatha;
                $fmd['home_lc']=$dags_details->mlessa;
                $fmd['home_g']=$dags_details->mganda;
                $fmd['home_kr']=$dags_details->mkranti;

                $fmd['agri_b']=$dags_details->agri_bigha;
                $fmd['agri_k']=$dags_details->agri_katha;
                $fmd['agri_lc']=$dags_details->agri_lessa;
                $fmd['agri_g']=$dags_details->agri_ganda;
                $fmd['agri_kr']=$dags_details->agri_kranti;


                //************Total Area Calculation -js- ******************
                if (in_array($app->dist_code, json_decode(BARAK_VALLEY))){
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
                if (in_array($app->dist_code, json_decode(BARAK_VALLEY))){
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
                    'application_no' => $application_no,
                    'case_no' => $case_no['case_no'],
                    'dag_no' => $dags_details->dag_no,
                    'uuid' => $app->uuid,
                    'created_at' => date('Y-m-d'),
                    'applied_area_home_bigha' => $dags_details->mbigha,
                    'applied_area_home_katha' => $dags_details->mkatha,
                    'applied_area_home_lessa' => $dags_details->mlessa,
                    'applied_area_home_ganda' => $dags_details->mganda,
                    'applied_area_home_kranti' => $dags_details->mkranti,
                    'applied_area_agri_bigha' => $dags_details->agri_bigha,
                    'applied_area_agri_katha' => $dags_details->agri_katha,
                    'applied_area_agri_lessa' => $dags_details->agri_lessa,
                    'applied_area_agri_ganda' => $dags_details->agri_ganda,
                    'applied_area_agri_kranti' => $dags_details->agri_kranti,
                    'actual_encroachment_area_home_bigha' => $enc_home_bigha,
                    'actual_encroachment_area_home_katha' => $enc_home_katha,
                    'actual_encroachment_area_home_lessa' => $enc_home_lessa,
                    'actual_encroachment_area_home_ganda' => $enc_home_ganda,
                    'actual_encroachment_area_home_kranti' => $enc_home_kranti,
                    'actual_encroachment_area_agri_bigha' => $enc_agri_bigha,
                    'actual_encroachment_area_agri_katha' => $enc_agri_katha,
                    'actual_encroachment_area_agri_lessa' => $enc_agri_lessa,
                    'actual_encroachment_area_agri_ganda' => $enc_agri_ganda,
                    'actual_encroachment_area_agri_kranti' => $enc_agri_kranti,
                    'total_actual_encroachment_area_bigha' => $totalEncroachmentAreaArr[0],
                    'total_actual_encroachment_area_katha' => $totalEncroachmentAreaArr[1],
                    'total_actual_encroachment_area_lessa' => $totalEncroachmentAreaArr[2],
                    'total_actual_encroachment_area_ganda' => $totalEncroachmentAreaArr[3],
                    'total_actual_encroachment_area_kranti' => 0,
                    'settlement_area_home_bigha' => $fmd['home_b'],
                    'settlement_area_home_katha' => $fmd['home_k'],
                    'settlement_area_home_lessa' => $fmd['home_lc'],
                    'settlement_area_home_ganda' => $fmd['home_g'],
                    'settlement_area_home_kranti' => $fmd['home_kr'],
                    'settlement_area_agri_bigha' => $fmd['agri_b'],
                    'settlement_area_agri_katha' => $fmd['agri_k'],
                    'settlement_area_agri_lessa' => $fmd['agri_lc'],
                    'settlement_area_agri_ganda' => $fmd['agri_g'],
                    'settlement_area_agri_kranti' => $fmd['agri_kr'],
                    'total_settlement_area_bigha' => $totalSettlementAreaArr[0],
                    'total_settlement_area_katha' => $totalSettlementAreaArr[1],
                    'total_settlement_area_lessa' => $totalSettlementAreaArr[2],
                    'total_settlement_area_ganda' => $totalSettlementAreaArr[3],
                    'total_settlement_area_kranti' => 0,
                    'leftout_area_home_bigha' => $leftOutAreaHomeArr[0],
                    'leftout_area_home_katha' => $leftOutAreaHomeArr[1],
                    'leftout_area_home_lessa' => $leftOutAreaHomeArr[2],
                    'leftout_area_home_ganda' => $leftOutAreaHomeArr[3],
                    'leftout_area_home_kranti' => 0,
                    'leftout_area_agri_bigha' => $leftOutAreaAgriArr[0],
                    'leftout_area_agri_katha' => $leftOutAreaAgriArr[1],
                    'leftout_area_agri_lessa' => $leftOutAreaAgriArr[2],
                    'leftout_area_agri_ganda' => $leftOutAreaAgriArr[3],
                    'leftout_area_agri_kranti' => 0,
                    'total_leftout_area_bigha' => $totalLeftOutAreaArr[0],
                    'total_leftout_area_katha' => $totalLeftOutAreaArr[1],
                    'total_leftout_area_lessa' => $totalLeftOutAreaArr[2],
                    'total_leftout_area_ganda' => $totalLeftOutAreaArr[3],
                    'total_leftout_area_kranti' => 0,
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

            //insert into SETTLEMENT APPLICANT, main applicant/encrochers details
            if (!empty($output->settlements)) {
                foreach ($output->settlements as $appl) {

                    if ($appl->dag_no == 0 || $appl->dag_no == null || $appl->dag_no == '') {
                        $dag_no = 0;
                        $patta_no = 0;
                        $patta_type_code = 0;
                    } else {
                        $dag_no = $appl->dag_no;
                        $patta_no = $appl->patta_no;
                        $patta_type_code = $appl->patta_code;
                    }

                    if ($appl->is_applicant == 1) { // main applicant, for identity authentication
                        if ($get_aadhaar_photo != 'n') {
                            $timestamp = date('mdYhis', time()) . uniqid();
                            $identity_doc_unique_name = str_replace('/', "-", $application_no . '_' . $timestamp);
                            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                            $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $get_aadhaar_photo;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        } else {
                            $aadhar_path = '';
                        }
                        if ($output->aadhar->type == 'AADHAAR') {
                            $identity_ref_no = $output->aadhar->aadhaar_no;
                        } else {
                            $identity_ref_no = $output->aadhar->pan_no;
                        }
                        $identity_type = $output->aadhar->type;
                        $identity_doc_link = $aadhar_path;

                    } else {
                        $identity_ref_no = '';
                        $identity_type = '';
                        $identity_doc_link = '';

                    }

                    if (trim($appl->pdar_type) == 'B'){
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }else{
                        $pdar_rel_guar = 0;
                    }

                    if (trim($appl->pdar_type) == 'EN'){
                        $possession_date = $appl->possession_date;
                    }else{
                        $possession_date = null;
                    }
                    //pdar_cron_no
                    $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no['case_no']);


                    $insApplicant = [
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $m,
                        'lot_no' => $l,
                        'vill_townprt_code' => $v,
                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no['case_no'],
                        'petition_no' => $case_no['petition_no'],
                        'operation' => 'E',
                        'dag_no' => $dag_no,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type_code,
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_id' => '-1',
                        'pdar_cron_no' => $cron_no,
                        'pdar_name' => $appl->name_ass,
                        'pdar_guardian' => $appl->gurdian_name_ass,
                        'pdar_rel_guar' => $pdar_rel_guar,
                        'pdar_gender' => $appl->gender,
                        'pdar_add1' => $appl->pre_add,
                        'pdar_add2' => $appl->per_add,
                        'pdar_mobile' => $appl->mobile,
                        'pdar_type' => $appl->pdar_type,
                        'is_applicant' => $appl->is_applicant,
                        'marital_status' => $appl->marital_status,
                        'dob' => $appl->dob,
                        'eng_pdar_name' => $appl->name_eng,
                        'eng_pdar_guardian' => $appl->gurdian_name_eng,
                        'identity_ref_no' => $identity_ref_no,
                        'identity_type' => $identity_type,
                        'identity_doc_link' => $identity_doc_link,
                        'enc_id' => $appl->encroacher_id,
                        'period_possession' => $possession_date,

                    ];
                    $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);
                    if ($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : " . $application_no);
                        return false;
                    }
                }
            }

            // insert into settlement_nominee, NEXT OF KIN
            if (!empty($output->nextKin)) {
                foreach ($output->nextKin as $nok) {
                    $nominee_data = [
                        'case_no' => $case_no['case_no'],
                        'nominee_name' => $nok->next_of_kin_name,
                        'address' => $nok->address,
                        'mobile_no' => $nok->mobile_no,
                        'relation' => $nok->relation_with_kin,
                    ];
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                    if ($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0007: Insertion failed in settlement_nominee for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0007: Registration of Settlement failed for RTPS application no : " . $application_no);
                        return false;
                    }
                }
            }

            //   insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree' => $case_no['case_no'],
                'basundhara' => $application_no,
                'date_reg' => date('Y-m-d'),
                'reg_by' => $this->session->userdata('user_code'),
                'app_status' => 'M',
                'pending_with' => 'LM',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);

            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0008: Registration of Settlement failed for RTPS application no : " . $application_no);
                return false;
            }
            $this->db->trans_commit();
        }

        //******************Fetching data from dharitree */
        $startTime = microtime(true);
        try{
            $district['review_flag'] = false;

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
                $district['review_flag'] = true;

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



            $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($case_no);
            $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->SettlementKhasModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($case_no);
            $main_applicant = $this->SettlementKhasModel->getMainApplicant($case_no);

            $district['co_name'] = $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $district['premiumData'] = $premiumData;
            /// premium end

            $district['app'] = $basic;
            $district['applicants'] = $this->SettlementKhasModel->getAllApplicant($case_no);
            $district['query'] = $output->query;
            $district['document'] = $output->documents;
            $district['encroachers'] = $applicants_encroacher;
            $district['owners'] = $applicants_owners;
            $district['riotee_noks'] = $applicants_riotee_nok;
            $district['property'] = $this->SettlementKhasModel->getAdditionalProperty($case_no);
            $district['settlements'] = $this->SettlementKhasModel->getAllApplicant($case_no);
            // $district['nextKin'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
            $district['bhumi'] = $this->SettlementKhasModel->getSettlementBasic($case_no);
            $district['aadhar'] = $this->SettlementKhasModel->getMainApplicant($case_no);
            $district['nominee'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);

            // echo "<pre>";
            // var_dump($district['bhumi']); die;

            $district['basic'] = $basic;
            $district['applicants_buyers'] = $applicants_buyers;
            $district['applicants_owners'] = $applicants_owners;
            $district['applicants_encroacher'] = $applicants_encroacher;
            $district['applicants_riotee_nok'] = $applicants_riotee_nok;

            $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);
            $district['dags'] = $dags;
            $district['lmnotes'] = $lmnotes;
            $district['proceedings'] = $proceedings;

            $district['dhardocuments'] = $dhardocuments;
            $district['case_no'] = $case_no;

            $this->db = $this->load->database('db2', true);
            $district['district_all'] = $this->db->query("Select * from district_details")->result();

            $this->dbswitch();

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry) ? $geo_date_query->date_entry : '.....';

            $additional_property = $this->db->query("Select * from settlement_additional_property
            where applid='$application_no'");
            if ($additional_property->num_rows() > 0) {
                $totallesaa = 0;
                $totalganda = 0;
                foreach ($additional_property->result() as $addprop) {
                    if (in_array($addprop->dist_code, json_decode(BARAK_VALLEY))) {
                        $total_g = $this->utilityclass->Total_ganda($addprop->bigha, $addprop->katha, $addprop->lessa, $addprop->ganda);
                        $totalganda = $totalganda + $total_g;
                    } else {
                        $total_l = $this->utilityclass->Total_Lessa($addprop->bigha, $addprop->katha, $addprop->lessa);
                        $totallesaa = $totallesaa + $total_l;
                    }
                }
                if (!empty($totallesaa)) {
                    $district['total_aditional_area'] = $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if (!empty($totalganda)) {
                    $district['total_aditional_area_g'] = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $district['additional_property'] = $additional_property->result();
            }

            foreach ($output->selfDeclaration as $selfDec) {
                $district['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
            }

            $query_for_guar_rel = "select * from master_guard_rel";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $district['guar_rel'] = $relation_executation->result();
            }


            ///aadhar photo

            if(isset($applicants_buyers)){
                if($applicants_buyers){
                    foreach($applicants_buyers as $adhar_photo):
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
                                $district['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                            endif;
                        endif;
                    endforeach;
                }
            }

            $applid_vlb = $this->utilityclass->getApplidFromCaseNo($case_no);
            if (isset($dags)) {
                foreach ($dags as $vlb_dag) {
                    $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details
                WHERE application_no = ? AND dag_no = ?", array($applid_vlb, $vlb_dag->dag_no));

                    if ($sqlvlbcheck->num_rows() > 0) {
                        $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
                    } else {
                        $vlb_newly_added[] = false;
                    }
                }
                $district['vlb_newly_added'] = $vlb_newly_added;
            }

            if(isset($applicants_encroacher)):
                foreach($applicants_encroacher as $settl_vlb_add_check):
                    $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($application_no, $settl_vlb_add_check->dag_no, $district['basic']['uuid']));

                    // echo $this->db->last_query();

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
                        $district['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
                    endif;
                endif;
                if(isset($land_bank_status)):
                    $district['land_bank_status'] = $land_bank_status;
                endif;
                if(isset($settlement_land_bank_details)):
                    $district['settlement_land_bank_details'] = $settlement_land_bank_details;
                endif;
            endif;

            //****getting tribe cat and under tribal belt data from backup */
            $getJsonBackup = $this->SettlementKhasModel->getJsonDataFromBackup($case_no);
            if(isset($getJsonBackup))
            {
                if($getJsonBackup)
                {
                    $json_settlement =  json_decode($getJsonBackup->data);

                    foreach($json_settlement->settlements as $jsonSettle)
                    {
                        if($jsonSettle->is_applicant == 1)
                        {
                            $district['backup_tribe_category'] = $jsonSettle->tribe_category;
                            $district['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                        }
                    }

                }
            }

            //************check if SK is available*/
            $district['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

            if($district['sk_name'] == 'n')
            {
                //************if SK is not available then load CO */
                $district['sk_availability'] = 'n';

                $district['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            }
            else
            {
                $district['sk_availability'] = 'y';

            }

            $district['dag_count']=count($dags);

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $district['deleted_encroacher'] = $deletedEncArray;

            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $district['deleted_dags'] = $deletedData;

            //************LM Rejected Reasons */
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TRIBAL_COMMUNITY_ID);
            if($rejected_data == 'n')
            {
                $district['rejected_list'] = false;
            }
            else
            {
                $district['rejected_list'] = $rejected_data;
            }

            $district['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

            $district['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $district['rejected_list']);		


            if($_SERVER['REQUEST_METHOD'] != 'POST'){
                $district['_view'] = 'SettlementView/SettlementTribalView';
                $this->load->view('layouts/main', $district);
            }
        }
        catch(Exception $e)
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //To upload from mobile application

            //******check if the case already forwarded to CO */
            $checkIfForwardedFromLm = $this->SettlementCommonModel->checkIfForwardedFromLm($case_no);
            if(trim($checkIfForwardedFromLm) == 'y'){
                $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded to circle office. case no : ".$case_no);
                redirect(base_url() . "index.php/home");
            }

            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_TRIBAL_COMMUNITY_ID);

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
                foreach($district['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";
            
                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($district['dags']);

                if((int)$get_tag_dag_count != (int)$total_dag_count)
                {
                    if(GEO_TAG_ACTIVE_STATUS == 1){
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                //*******rejected reason validation */
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
                $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
                $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
                //$this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
                $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');
    
                // LM report validation
                $this->form_validation->set_rules('chitha_verified', 'Chitha verification', 'trim|required');
                $this->form_validation->set_rules('vlb_verified', 'VLB verification', 'trim|required');
                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Schedule of the land', 'trim|required');
                $this->form_validation->set_rules('protected_class_lm', 'Protected category', 'trim|required|is_natural_no_zero|is_natural|greater_than[-1]');
                $this->form_validation->set_rules('litigation', 'Litigation category', 'trim|required');
                $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide prone', 'trim|required');
                $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
                $this->form_validation->set_rules('landed_property', 'landed property of the petitioner', 'trim|required');
                $this->form_validation->set_rules('is_st', 'whether ST', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'whether tribal belt', 'trim|required');
                $this->form_validation->set_rules('is_free_encroachment', 'encroachment verification', 'trim|required');
                $this->form_validation->set_rules('land_falls', 'land_falls', 'is_natural_no_zero');
    
                $this->form_validation->set_rules('is_landless', 'is_landless', 'trim|required');
    
                $this->form_validation->set_rules('falls_und_gmc', 'falls under GMC range', 'required');
                $this->form_validation->set_rules('roadside_comment_check', 'roadside/riverside reservation', 'required');
                $this->form_validation->set_rules('lm_note', 'LM Remark', 'trim|required|is_natural_no_zero');
                $this->form_validation->set_rules('lm_remark_text', 'LM note', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
                $this->form_validation->set_rules('roadside_reservation', '', '');
                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required|greater_than[0]');
    
                if (empty($_FILES['field_report']['name'])) {
                    $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                }
    
                $this->form_validation->set_message('is_natural_no_zero', 'This field needs to be selected !');
    
                $roadside_comment_check = $this->input->post('roadside_comment_check');
    
                $totalDagAreaLessaValidation = 0;
                $totalAgrAreaLessaValidation = 0;
                $totalHomeAreaLessaValidation = 0;
                $agiAreaMoreThanDagA = 0;
                $homeAreaMoreThanDagA = 0;
                $reserveMoreThanAppArea = 0;
                $totalRoadSideAreaLessaValidation = 0;
                $distCode = trim($this->input->post('dist_code'));
    
                if ($distCode == null) {
                    redirect(base_url() . 'index.php/basundhara2/settlementCases');
                }
    
    
                foreach ($district['encroachers'] as $dags) {

                    //******NCBTAD check  */
                    $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags->dist_code, $dags->subdiv_code, $dags->cir_code, $dags->mouza_pargona_code, $dags->lot_no, $dags->vill_townprt_code, $dags->dag_no);

                    if($ncBtadCheck > 0)
                    {
                        //*******throw error for NCBTAD */
                        log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                        $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }

                    // for barak valley
                    if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                        if (empty($_FILES['trace_map_copy' . $dags->dag_no]['name'])) {
                            $this->form_validation->set_rules('trace_map_copy' . $dags->dag_no, 'Trace map document', 'required');
                        }
    
                        $this->form_validation->set_rules('landmark_east' . $dags->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west' . $dags->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north' . $dags->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south' . $dags->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('zonal_valuation_prem' . $dags->dag_no, 'Zonal Value', 'trim|required|xss_clean');
    
                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dags->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dags->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dags->dag_no), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g' . $dags->dag_no), 0);
    
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dags->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dags->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dags->dag_no), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g' . $dags->dag_no), 0);
    
                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dags->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dags->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dags->dag_no), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g' . $dags->dag_no), 0);
    
                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
    
                        if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                            $agiAreaMoreThanDagA = 1;
                        }
                        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
                            $homeAreaMoreThanDagA = 1;
                        }
    
                        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation += $agrAreaLessaValidation;
    
                        if ($roadside_comment_check == 'YES') {
                            $this->form_validation->set_rules('reserved_bigha' . $dags->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha' . $dags->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa' . $dags->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda' . $dags->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti' . $dags->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $dags->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $dags->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $dags->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda' . $dags->dag_no), 0);
    
                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;
    
                            if ($dagAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
    
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                    }
                    else
                    {
                        if (empty($_FILES['trace_map_copy' . $dags->dag_no]['name'])) {
                            $this->form_validation->set_rules('trace_map_copy' . $dags->dag_no, 'Trace map document', 'required');
                        }
    
                        $this->form_validation->set_rules('zonal_valuation_prem' . $dags->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_east' . $dags->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west' . $dags->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north' . $dags->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south' . $dags->dag_no, 'South Landmark', 'trim|required|xss_clean');
    
    
                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dags->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dags->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dags->dag_no), 0);
    
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dags->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dags->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dags->dag_no), 0);
    
                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dags->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dags->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dags->dag_no), 0);
    
                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
    
                        if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                            $agiAreaMoreThanDagA = 1;
                        }
                        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
                            $homeAreaMoreThanDagA = 1;
                        }
                        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation += $agrAreaLessaValidation;
    
                        if ($this->input->post('roadside_comment_check') == 'YES') {
                            $this->form_validation->set_rules('reserved_bigha' . $dags->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha' . $dags->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa' . $dags->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $dags->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $dags->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $dags->dag_no), 0);
    
                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside;
    
                            if ($dagAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                    }
                }
    
                // new additional property calculation
                $additional_properties = $district['additional_property'] = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                    foreach ($additional_properties as $singleProperty) {
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
                    foreach ($additional_properties as $singleProperty) {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
    
                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }
                // new additional property calculation end here
    
                if ($applicants_encroacher == true)
                {
                    foreach ($applicants_encroacher as $enc_applicant)
                    {
                        $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, 'Encroachers Dag Nu.', 'trim|required|is_natural');
                        $this->form_validation->set_rules('period_possession'.$enc_applicant->id, 'Encroachers Period Possession', 'trim|required');
                        $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, 'Encroachers Name', 'trim|required|min_length[3]|max_length[70]');
                        $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, 'Encroachers  Guardian', 'trim|required|min_length[1]|max_length[70]');
                        // $this->form_validation->set_rules('enc_id'.$enc_applicant->id, 'Encroacher Id', 'trim|required|is_natural');
                    }
                }
    
                if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0) {
                    $this->form_validation->set_rules('total_applied_area_error', 'Total applied area should not be Zero', 'required|callback_applied_area_check');
                }
    
                if ($agiAreaMoreThanDagA == 1) {
                    $this->form_validation->set_rules('agiAreaMoreThanDagA', 'Total applied area (Agricultural) should not be more than total Dag Area !', 'required|callback_agiAreaMoreThanDagA');
                }
                if ($homeAreaMoreThanDagA == 1) {
                    $this->form_validation->set_rules('homeAreaMoreThanDagA', 'Total applied area (Homestead) should not be more than total Dag Area !', 'required|callback_homeAreaMoreThanDagA');
                }
    
                if ($reserveMoreThanAppArea == 1) {
                    $this->form_validation->set_rules('reserveMoreThanAppArea', 'Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
                }
    
                if ($totalDagAreaLessaValidation < $totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) {
                    $this->form_validation->set_rules('totalAppliedAreaMoreThanDagArea', 'Total applied area should not be more than total Dag Area !', 'required|callback_totalAppliedAreaMoreThanDagArea');
                }
    
                $checkUrbanCon = trim($this->input->post('is_urban'));
                $land_exceed = 0;
    
                if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                    if (TRIBAL_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {
                        $this->form_validation->set_rules('tribalMaxHomestead', 'Total applied Homestead area should not be more than ' . TRIBAL_MAX_HOMESTEAD . ' Bigha !', 'required|callback_tribalMaxHomestead');
                    }
                    if (TRIBAL_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                        $this->form_validation->set_rules('tribalMaxAgriculture', 'Total applied Agriculture area should not be more than ' . TRIBAL_MAX_AGRICULTURE . ' Bigha !', 'required|callback_tribalMaxAgriculture');
                    }
    
                    if ((TRIBAL_MAX_AGRICULTURE + TRIBAL_MAX_HOMESTEAD) * 6400 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (TRIBAL_MAX_AGRICULTURE + TRIBAL_MAX_HOMESTEAD) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed = 1;
                    }

                    // new premium addition
                    if(!empty($this->input->post('area_new'.$dags->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags->dag_no));
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
    
                    // if ($checkUrbanCon == 'Y') {
                    //     if ((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                    //         $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                    //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                    //     }
                    // }
                }
                else
                {
                    if (TRIBAL_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {
                        $this->form_validation->set_rules('tribalMaxHomestead', 'Total applied Homestead area should not be more than ' . TRIBAL_MAX_HOMESTEAD . ' Bigha !', 'required|callback_tribalMaxHomestead');
                    }
                    if (TRIBAL_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {
                        $this->form_validation->set_rules('tribalMaxAgriculture', 'Total applied Agriculture area should not be more than ' . TRIBAL_MAX_AGRICULTURE . ' Bigha !', 'required|callback_tribalMaxAgriculture');
                    }
    
                    //                if ((TRIBAL_MAX_AGRICULTURE + TRIBAL_MAX_HOMESTEAD) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
                    //                    $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (TRIBAL_MAX_AGRICULTURE + TRIBAL_MAX_HOMESTEAD) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                    //                }
    
                    if ((TRIBAL_MAX_BOTH) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (TRIBAL_MAX_BOTH) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed = 1;
                    }

                    // new premium addition
                    if(!empty($this->input->post('area_new'.$dags->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags->dag_no));
                        if(!empty($maxland_check->max_land)){

                            if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }

                    }else{
                        $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                    }
    
    
                    // if ($checkUrbanCon == 'Y') {
                    //     if ((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                    //         $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                    //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                    //     }
                    // }
                }

                if($_POST['lm_note'] == '1' && $land_exceed == 1)
                {
                    $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (TRIBAL_MAX_BOTH) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                }
    
                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_katha', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda', '', '');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti', '', '');
    
                // for total applied area set_value in validation error Agriculture
                $this->form_validation->set_rules('total_applied_area_agricultural_bigha', '', '');
                $this->form_validation->set_rules('total_applied_area_agricultural_katha', '', '');
                $this->form_validation->set_rules('total_applied_area_agricultural_lessa', '', '');
                $this->form_validation->set_rules('total_applied_area_agricultural_ganda', '', '');
                $this->form_validation->set_rules('total_applied_area_agricultural_kranti', '', '');
    
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
    
                // additional file upload validation
                // upload additional files
                if (isset($_FILES['fileUpload']['name'])) {
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
    
                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size
    
                    for ($i = 0; $i < $fileCount; $i++) {
                        if ($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]) {
    
                            $name = $_FILES['fileUpload']['name'][$i];
                            $size = $_FILES['fileUpload']['size'][$i];
    
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp = explode("/", $mime);
                            $ext = $exp[1];
    
                            if ($name != null) {
                                if ($ext == null) {
                                    // todo error show extension missing
                                    $this->form_validation->set_rules('additional_doc_err', 'File extension', 'required');
    
                                }
                                if (!in_array($ext, UPLOAD_TYPE_VALIDATION)) {
                                    // todo error show file allow type not match
                                    $this->form_validation->set_rules('additional_doc_err', 'Only JPG/PNG/PDF file', 'required');
                                }
                                if ($size > UPLOAD_MAX_SIZE) {
                                    // todo error show file size
                                    $this->form_validation->set_rules('additional_doc_err', 'Maximum 2MB file size', 'required');
                                }
                            } else {
                                // todo error show file not nullable
                                $this->form_validation->set_rules('additional_doc_err', 'File name', 'required');
                            }
                        } else {
                            $this->form_validation->set_rules('additional_doc_err', 'File', 'required');
                        }
                    }
                }

            }
            
            if ($this->form_validation->run() == false) {
                $district['all_errors'] = validation_errors();

                if (isset($fileCount)) {
                    $district['fileCount'] = $fileCount;
                }

                $district['err_return'] = true;
                $district['_view'] = 'SettlementView/SettlementTribalView';
                $this->load->view('layouts/main', $district);
            }
            else
            {
                // VALIDATION ENDS HERE
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
                            log_message('error', '#ERROR00112: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERROR00112: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                $sk_code = null;
                $co_code = null;
                // if(trim($district['sk_availability']) == 'y')
                // {
                //     $pending_officer = 'SK';
                //     $sk_code = $this->input->post('co_code');
                // }
                // else
                // {
                //     $pending_officer = 'CO';
                //     $co_code = $this->input->post('co_code');
                // }

                $pending_officer = 'CO';
                $co_code = $this->input->post('co_code');

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
                if ($backup_insertion_lm != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP002: Insertion failed in settlement_backup_json RTPS Case No ' . $application_no);

                    $this->session->set_flashdata('error_data', "#BACKUP002: Registration of Settlement failed for case no : " . $application_no);
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
                ///additional propertry updation ends here

                  // UPDATING Geo Tag Photo case number in supportive document
                if (isset($district['geo_tag_doc'])) {
                    foreach ($district['geo_tag_doc'] as $geo_tag_loop) {
                        $geo_tag_array = array(
                            'case_no' => $case_no,
                        );
                        $this->db->where('applid', $geo_tag_loop->applid);
                        $this->db->where('dag_no', $geo_tag_loop->dag_no);
                        $this->db->where('file_name', GEO_TAG_PHOTO);
                        $this->db->update('supportive_document', $geo_tag_array);

                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No ' . $geo_tag_loop->applid);

                            $this->session->set_flashdata('error_data', "#SETUP0001S: Registration of Settlement failed for case no : " . $geo_tag_loop->applid);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                }

                //********1 will insert */
                if($validation_bypass == 0)
                {
                     // upload additional file
                    if (isset($_FILES['fileUpload']['name'])) {
                        for ($i = 0; $i < $fileCount; $i++) {
                            $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp = explode("/", $mime);
                            $onlyExtension = $exp[1];

                            $fileRename = $this->UUID4() . '.' . $onlyExtension;

                            $config['upload_path'] = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size'] = UPLOAD_MAX_SIZE;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file')) {
                                $document = array(
                                    'case_no' => $case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type' => $_FILES['file']['type'],
                                    'file_path' => UPLOAD_DIR . $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type' => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                                );

                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document', $document);

                                if ($addMoreDocQuery != 1) {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $application_no);

                                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $application_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }

                            } else {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $application_no);

                                $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }
                    //end of additional file upload

                    ////settlement_dag_details insert start
                    foreach ($district['encroachers'] as $dagsland) {

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

                    ///// road side reserve area start /////
                    if ($roadside_comment_check == 'YES') {
                        foreach ($district['encroachers'] as $dags_road) {
                            $reservedarea = [
                                'dist_code' => $this->input->post('dist_code'),
                                'subdiv_code' => $this->input->post('subdiv_code'),
                                'cir_code' => $this->input->post('cir_code'),
                                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                                'lot_no' => $this->input->post('lot_no'),
                                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                                'dag_no' => $this->input->post('reserved_dag_road' . $dags_road->dag_no),
                                'patta_no' => $this->input->post('reserved_patta_road' . $dags_road->dag_no),
                                'bigha' => $this->input->post('reserved_bigha' . $dags_road->dag_no),
                                'katha' => $this->input->post('reserved_katha' . $dags_road->dag_no),
                                'lessa' => $this->input->post('reserved_lessa' . $dags_road->dag_no),
                                'ganda' => $this->input->post('reserved_ganda' . $dags_road->dag_no),
                                'kranti' => $this->input->post('reserved_kranti' . $dags_road->dag_no),
                                'case_no' => $case_no,
                                'applid' => $this->input->post('applid'),
                                'lm_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'date_update' => date('Y-m-d h:i:s'),
                                'type' => 'R',
                            ];

                            $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                            // echo $this->db->last_query(); die();
                            if ($reserveData != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No ' . $application_no);

                                $this->session->set_flashdata('error_data', "#ERRSET00052: Registration of Settlement failed for case no : " . $application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }

                    
                    // INSERTION IN settlement_ap_lmnote starts here
                    //*********if LM if case of case rejected the rejected remarks */
                     //*********if LM if case of case rejected the rejected remarks */
                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_TRIBAL_COMMUNITY_ID);

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm == null || $pro_class_lm == '' || $pro_class_lm == 0) ? 0 : $this->input->post('protected_class_lm');

                    $lmnote = [
                        'user_code' => $this->session->userdata('user_code'),
                        'chitha_verified' => $this->input->post('chitha_verified'),
                        'vlb_verified' => $this->input->post('vlb_verified'),
                        'possession_verification' => $this->input->post('possession_verification'),
                        'protected_class_lm' => $protected_class_lm,
                        'litigation' => $this->input->post('litigation'),
                        'landed_property' => $this->input->post('landed_property'),
                        'is_st' => $this->input->post('is_st'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'is_free_encroachment' => $this->input->post('is_free_encroachment'),
                        'land_falls' => $this->input->post('land_falls'),
                        'is_landless' => $this->input->post('is_landless'),
                        'falls_und_gmc' => $this->input->post('falls_und_gmc'),
                        'roadside_reservation' => $this->input->post('roadside_reservation'),
                        'lm_note' => $this->input->post('lm_note'),
                        'lm_remark_text' => $this->input->post('lm_remark_text'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'case_no' => $case_no,
                        'status' => 'W',
                        'landslide' => $this->input->post('landslide'),
                        'erosion' => $this->input->post('erosion'),
                        'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    ];

                    $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
                    if ($insLmnote != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No ' . $application_no);

                        $this->session->set_flashdata('error_data', "#ERRSET0005: Registration of Settlement failed for case no : " . $application_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }

                    ////////////////////file///////////////////////////
                    // For uploading dag wise trace_map_copy
                    foreach ($district['encroachers'] as $dags_doc) {
                        $timestamp = date('mdYhis', time()) . uniqid();

                        // Trace Map copy upload
                        $config['file_name'] = 'trace_map_copy' . $timestamp;
                        $config['upload_path'] = UPLOAD_DIR;
                        $config['allowed_types'] = 'pdf|jpg|png';
                        $config['max_size'] = 2000;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('trace_map_copy' . $dags_doc->dag_no)) {
                            $error = array('error' => $this->upload->display_errors());
                            echo json_encode($error);
                            return false;
                        } else {
                            $data = array('upload_data' => $this->upload->data());
                            $document = array(
                                'case_no' => $case_no,
                                'file_name' => 'Trace Map Copy',
                                'user_code' => $this->session->userdata('user_code'),
                                'fetch_file_name' => $data['upload_data']['orig_name'],
                                'file_type' => $data['upload_data']['file_type'],
                                'file_path' => $config['upload_path'] . $data['upload_data']['orig_name'],
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type' => $this->input->post('service_code'),
                                'dag_no' => $this->input->post('dag_no_doc' . $dags_doc->dag_no),
                            );

                            $insert_supportive_doc = $this->db->insert('supportive_document', $document);

                            if ($insert_supportive_doc != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :' . $case_no);
                                $json = [
                                    'errorMessage' => "#ERRORPPSSGG: Failed to forward the case for Case No : " . $case_no,
                                ];
                                echo json_encode($json);
                                return false;
                            }
                        }
                    }

                    $timestamp = date('mdYhis', time()) . uniqid();
                    // For uploading field report
                    $config2['file_name'] = 'field_report' . $timestamp;
                    $config2['upload_path'] = UPLOAD_DIR;
                    $config2['allowed_types'] = 'pdf|jpg|png';
                    $config2['max_size'] = 2000;

                    $this->upload->initialize($config2);

                    if (!$this->upload->do_upload('field_report')) {
                        $error = array('error' => $this->upload->display_errors());

                        var_dump($error);
                        die;
                    }
                    else
                    {
                        $data = array('upload_data' => $this->upload->data());
                        $document = array(
                            'case_no' => $case_no,
                            'file_name' => 'Field Report',
                            'user_code' => $this->session->userdata('user_code'),
                            'fetch_file_name' => $data['upload_data']['orig_name'],
                            'file_type' => $data['upload_data']['file_type'],
                            'file_path' => $config2['upload_path'] . $data['upload_data']['orig_name'],
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type' => $this->input->post('service_code'),
                        );

                        $insert_supportive_doc = $this->db->insert('supportive_document', $document);

                        if ($insert_supportive_doc != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :' . $case_no);
                            $json = [
                                'errorMessage' => "#ERRORPPSSGGP: Failed to forward the case for Case No : " . $case_no,
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }

                    //// premium insert start
                    $sumMbAmount = 0;
                    $approved_by ='';
                    $count =0;
                    foreach ($district['encroachers'] as $dagsprem) {

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
                        if (in_array($dagsprem->dist_code, json_decode(BARAK_VALLEY))) {
                            $area_in_bigha = 6400;
                        } else {
                            $area_in_bigha = 100;
                        }
                        $concession_rate = 25;
                        $ratetype = $this->input->post('rate_type' . $dagsprem->dag_no);
                        $ratepr2 = $this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                        $ratepr = $ratepr2->rate_type;
                        // var_dump($ratepr->rate_type); die;
                        $is_full_pay = $this->input->post('paymode');
                        // $prem_zonal = $this->input->post('zonal_valuation_prem' . $dagsprem->dag_no);
                        $prem_zonal = $this->utilityclass->getZonalValue($dagsprem->dist_code,$basic['uuid'],$dagsprem->dag_no);
                        $prem_area = $this->input->post('total_lessa' . $dagsprem->dag_no);
                        $prem_rate = $this->input->post('rate' . $dagsprem->dag_no);
                        $prem_concession = $this->input->post('concession' . $dagsprem->dag_no);

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
                                if($prem_area>$mb_land){
                                    $concession_factor = (100 - $concession_rate) / 100;

                                    $base_premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                    $amount1 = ceil($base_premium1 * $prem_rate / 100 * $concession_factor);

                                    //for access area
                                    $access_area = max(0, $prem_area - $mb_land);
                                    $base_premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                    $amount2 = ceil($base_premium2 * $concession_factor);
                                    
                                    $finalamount = ceil($amount1 + $amount2);

                                }else{

                                    $concession_factor = (100 - $concession_rate) / 100;

                                    $base_premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                    $amount = $base_premium * ($prem_rate / 100) * $concession_factor;

                                    $finalamount = ceil($amount);
                                }
                                
                            }else if($ratepr =='R'){

                                $premium = $prem_area * $prem_rate / $area_in_bigha;
                                $discount = ceil($premium * ($concession_rate/100));
                                $finalamount = ceil($premium - $discount);
                            }

                        }else if($prem_concession=="NO"){
                            if($ratepr =='P'){
                                if($prem_area>$mb_land){

                                    // --- Part 1: within mb_land ---
                                    $premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                    $amount1  = ceil($premium1 * $prem_rate / 100);

                                    // --- Part 2: excess area at flat 150% zonal (no prem_rate applied) ---
                                    $access_area = $prem_area - $mb_land;
                                    $premium2    = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                    $amount2     = ceil($premium2);

                                    $finalamount = $amount1 + $amount2;
                                    
                                }
                                else{

                                    // --- No excess area ---
                                    $premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                    $amount  = $premium * $prem_rate / 100;
                                    $finalamount = ceil($amount);
                                }
                            }else if($ratepr =='R'){

                                $finalamount = ceil($prem_area * $prem_rate / $area_in_bigha);
                            }
                        }

                        $sumMbAmount += $finalamount;

                        // premium verify end ******************

                        $fmd = array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'uuid' => $dagsprem->uuid,
                            'dag_no' => $dagsprem->dag_no,
                            'zonal_valuation' => $this->input->post('zonal_valuation_prem' . $dagsprem->dag_no),
                            'area_name' => $this->input->post('area' . $dagsprem->dag_no),
                            'land_type' => $this->input->post('land_type' . $dagsprem->dag_no),
                            'rate_type' => $this->input->post('rate_type' . $dagsprem->dag_no),
                            'rate' => $this->input->post('rate' . $dagsprem->dag_no),
                            'concession' => $this->input->post('concession' . $dagsprem->dag_no),
                            'amount_dag' => $this->input->post('amount' . $dagsprem->dag_no),
                            'final_amount' => $this->input->post('finalamount'),
                            'due_amount' => $this->input->post('totaldue'),
                            'total_lessa' => $this->input->post('total_lessa' . $dagsprem->dag_no),
                            'is_full_pay' => $this->input->post('paymode'),
                            'is_final' => 1,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'approve_by'=>$this->input->post('approval'.$dagsprem->dag_no),

                        );

                        $insPremium = $this->db->insert('settlement_premium', $fmd);
                        // echo $this->db->last_query();

                        if ($insPremium != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No ' . $application_no);
                            $data = array(
                                'error' => "#ERRSET000101: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }

                        $approved_by = $this->input->post('approval'.$dagsprem->dag_no);
                    } // foreach end


                    // premium verify 2 start ******************
                    if ($sumMbAmount != $this->input->post('finalamount')) {
                        // var_dump("Amount mismatch!!!"); die;
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0001: Settlement Application not submitted case no # $application_no");
                        redirect(base_url() . "index.php/home");
                    }
                    // if ($is_full_pay == "NO") {
                    //     $discount = 30;
                    //     $finaldue = ($sumMbAmount * $discount / 100);
                    //     // $finaldueamount = round($finaldue,2);
                    //     $finaldueamount = ceil($finaldue);
                    // } else if ($is_full_pay == "YES") {
                    //     $finaldueamount = $sumMbAmount;
                    // }
                    $finaldueamount = $sumMbAmount;

                    if ($finaldueamount != $this->input->post('totaldue')) {
                        // var_dump("Due Amount mismatch!!!");
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0002: Settlement Application not submitted case no # $application_no");
                        redirect(base_url() . "index.php/home");
                    }
                
                }

                if($validation_bypass == 1)
                {
                     //*****insert LM note and rejected reason only*/
                    $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
                        SETTLEMENT_TRIBAL_COMMUNITY_ID,
                        $case_no,
                        $application_no,
                        $district['rejected_list']
                    );
                }

                // premium verify 2 end ******************

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='" . $case_no . "'");

                if ($proceeding_id) {
                    $proceeding_id = $proceeding_id->row()->c;
                }

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no'=>$case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $this->input->post('lm_remark_text'),
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'LM note submitted'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                //echo $this->db->last_query();

                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPPSS: Insertion failed in settlement_proceeding for case no :' . $application_no);
                    $json = [
                        'errorMessage' => "#ERRORPPSS: Failed to forward the case for Case No : " . $application_no,
                    ];
                    echo json_encode($json);
                    return false;
                }
                //////proceeding end//////

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                } else {
                    //////////////POST To basundhara/////////////////////
                    $rmk = 'Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = 'CO';
                    // $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # " . $case_no);
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message_success', "Application Successfully Forwarded to ".$pending_officer." With Case No # ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
        }
    }

    public function secondProceeding()
    {
        $case_no = $this->input->get('case');
        
        $case_no = $this->utilityclass->decryptJwtCase($case_no);

        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();

        $this->dbswitch();

        $this->utilityclass->lmAuthBasic($case_no);

        //  row_array
        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
        //  result
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
        $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($case_no);
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
        $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($case_no);

        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
        $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($case_no);
        $proceedings = $this->SettlementKhasModel->getSettlementProceeding($case_no);
        $dhardocuments = $this->SettlementKhasModel->getDocuments($case_no);

        $lmdata['basic'] = $basic;

        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;
        $lmdata['applicants_riotee_nok'] = $applicants_riotee_nok;
        $lmdata['nominee'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);


        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        $d = $basic["dist_code"];
        $s = $basic["subdiv_code"];
        $c = $basic["cir_code"];
        $m = $basic["mouza_pargona_code"];
        $l = $basic["lot_no"];
        $v = $basic["vill_townprt_code"];
        $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);

        $lmdata['application_no'] = $applid = $this->utilityclass->getApplidFromCaseNo($case_no);

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$applid'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
        $lmdata['geo_date'] = $geo_date;

        /// premium
        // $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
        // $lmdata['s_area'] = $s_area;

        $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
        $lmdata['premiumData'] = $premiumData;

        $lmdata['premium_data'] = $this->SettlementCommonModel->getPremium($case_no);
        /// premium end

        //get data from settlement_ap_lmnote
        $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
            case_no='$case_no'")->row()->is_landless;
        $lmdata['apLmNote'] = $apLmNote;

        if (isset($applicants_buyers)) {

            if ($applicants_buyers) {
                foreach ($applicants_buyers as $adhar_photo) {

                    if ($adhar_photo->is_applicant == 1) {
                        if (trim($adhar_photo->identity_type) == 'AADHAAR') {
                            $adhar_photo_link = $adhar_photo->identity_doc_link;

                            $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                            $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                            fclose($open_adhar_file);
                            // decoding the base64 encoding file variable

                            $lmdata['base64_decoded_adhar_file'] = "<img src = data:" . $this->decodeBase64($read_adhar_file) . ";base64," . $read_adhar_file . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        }
                    }
                }
            }
        }

        if ($applicants_encroacher == true) {
            foreach ($applicants_encroacher as $encroacher) {
                // echo "<pre>";
                // var_dump($encroacher);
                // die;
                $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                $district['vlb_enc'] = $vlb_encroacher;

                if ($vlb_encroacher == true) {
                    // getting the encroacher details

                    $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                    //var_dump($vlb_encroacher_in_dag); die();

                    $vlb_encc[] = $vlb_encroacher_in_dag;
                } else {
                    $lmdata['empty_err'] = "No Land Bank Details found!!";
                }
            }
            $lmdata['vlb_enc_details'] = $vlb_encc;

        }

        //   calling API for self declaration data

        $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $basundhara->basundhara,
            'api_key' => API_KEY,
            'token' => $token,
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);

        $output = json_decode($output);
        //var_dump($output);

        $lmdata['document'] = $output->documents;
        $lmdata['query'] = $output->query;
        $lmdata['property'] = $output->property;
        $lmdata['aadhar'] = $output->aadhar;
        $lmdata['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }
        $reservation = $this->SettlementVgrModel->getSettlementReservation($case_no);

        //**********-js- check if encroacher newly inserted in vlb for this case****************
        $applid_vlb = $this->utilityclass->getApplidFromCaseNo($case_no);

        if(isset($applicants_encroacher)):
            foreach($applicants_encroacher as $settl_vlb_add_check):
                $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($applid_vlb, $settl_vlb_add_check->dag_no, $lmdata['basic']['uuid']));

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

        if (isset($dags)) {
            foreach ($dags as $vlb_dag) {
                $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($applid_vlb, $vlb_dag->dag_no));

                if ($sqlvlbcheck->num_rows() > 0) {
                    $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
                } else {
                    $vlb_newly_added[] = false;
                }
            }
            $lmdata['vlb_newly_added'] = $vlb_newly_added;
        }

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        /// additional property starts here
        $additional_property = $this->db->query("SELECT * FROM settlement_additional_property
          WHERE case_no='$case_no'");
        if ($additional_property->num_rows() > 0) {
            $totallesaa = 0;
            $totalganda = 0;
            foreach ($additional_property->result() as $addprop) {
                if (in_array($addprop->dist_code, json_decode(BARAK_VALLEY))) {
                    $total_g = $this->utilityclass->Total_ganda($addprop->bigha, $addprop->katha, $addprop->lessa, $addprop->ganda);
                    $totalganda = $totalganda + $total_g;
                } else {
                    $total_l = $this->utilityclass->Total_Lessa($addprop->bigha, $addprop->katha, $addprop->lessa);
                    $totallesaa = $totallesaa + $total_l;
                }
            }
            if (!empty($totallesaa)) {
                $lmdata['total_aditional_area'] = $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if (!empty($totalganda)) {
                $lmdata['total_aditional_area_g'] = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $lmdata['additional_property'] = $additional_property->result();
        }
        /// additional property ends here

        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->SettlementKhasModel->getJsonDataFromBackup($case_no);
        if(isset($getJsonBackup))
        {
            if($getJsonBackup)
            {
                $json_settlement =  json_decode($getJsonBackup->data);

                foreach($json_settlement->settlements as $jsonSettle)
                {
                    if($jsonSettle->is_applicant == 1)
                    {
                        $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
                        $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                    }
                }

            }
        }

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

        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TRIBAL_COMMUNITY_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $case_no = $this->input->post('case_no');

            $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

            $distCode = trim($this->input->post('dist_code'));

            $is_prem_update = $this->input->post('prem_update');
            if($distCode == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementKhasLandLm?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID);
            }
            if($case_no == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementKhasLandLm?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID);
            }
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');


            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_TRIBAL_COMMUNITY_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    { 

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

            $roadside_comment_check=$this->input->post('roadside_comment_check');

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
                $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                
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
                $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');
                // $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
                // LM report validation
                $this->form_validation->set_rules('chitha_verified', 'Chitha verification', 'required');
                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'required');
                $this->form_validation->set_rules('vlb_verified', 'VLB verification', 'required');
                $this->form_validation->set_rules('possession_verification', 'Schedule of the land', 'required');
                $this->form_validation->set_rules('protected_class_lm', 'Protected category', 'is_natural_no_zero');
                $this->form_validation->set_rules('litigation', 'Litigation category', 'required');

                $this->form_validation->set_rules('landed_property', 'landed property of the petitioner', 'required');
                $this->form_validation->set_rules('is_st', 'whether ST', 'required');
                $this->form_validation->set_rules('is_tribal_belt', 'whether tribal belt', 'required');
                $this->form_validation->set_rules('is_free_encroachment', 'encroachment verification', 'required');

                $this->form_validation->set_rules('land_falls', 'land_falls', 'is_natural_no_zero');

                // $this->form_validation->set_rules('is_landless', 'is_landless', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

                $this->form_validation->set_rules('falls_und_gmc', 'falls under GMC range', 'required');

                $this->form_validation->set_rules('lm_note', 'LM Remark', 'is_natural_no_zero');
                $this->form_validation->set_rules('lm_remark_text', 'LM note', 'required');

                $this->form_validation->set_message('is_natural_no_zero', 'This field needs to be selected !');

                $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');
                if ($is_prem_update == 'YES') {
                    $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                    $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
                }


                $totalDagAreaLessaValidation = 0;
                $totalAgrAreaLessaValidation = 0;
                $totalHomeAreaLessaValidation = 0;
                $agiAreaMoreThanDagA = 0;
                $homeAreaMoreThanDagA = 0;
                $reserveMoreThanAppArea = 0;
                $totalRoadSideAreaLessaValidation = 0;
                $distCode = trim($this->input->post('dist_code'));

                // for barak valley
                if (in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach ($dags as $dags_val) {

                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_val->dist_code, $dags_val->subdiv_code, $dags_val->cir_code, $dags_val->mouza_pargona_code, $dags_val->lot_no, $dags_val->vill_townprt_code, $dags_val->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }

                        $this->form_validation->set_rules('zonal_valuation_prem'.$dags_val->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_east'.$dags_val->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_val->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_val->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_val->dag_no, 'South Landmark', 'trim|required|xss_clean');

                        $this->form_validation->set_rules('dag_area_b' . $dags_val->dag_no, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k' . $dags_val->dag_no, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc' . $dags_val->dag_no, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g' . $dags_val->dag_no, 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr' . $dags_val->dag_no, 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('home_b' . $dags_val->dag_no, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k' . $dags_val->dag_no, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_lc' . $dags_val->dag_no, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('home_g' . $dags_val->dag_no, 'Applied Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('home_kr' . $dags_val->dag_no, 'Applied Homestead Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b' . $dags_val->dag_no, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k' . $dags_val->dag_no, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_lc' . $dags_val->dag_no, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('agri_g' . $dags_val->dag_no, 'Applied Agricultural Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('agri_kr' . $dags_val->dag_no, 'Applied Agricultural Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dags_val->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dags_val->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dags_val->dag_no), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g' . $dags_val->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dags_val->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dags_val->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dags_val->dag_no), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g' . $dags_val->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dags_val->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dags_val->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dags_val->dag_no), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g' . $dags_val->dag_no), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                            $agiAreaMoreThanDagA = 1;
                        }
                        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
                            $homeAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                        if ($roadside_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_val->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_val->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_val->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_val->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_val->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda'.$dags_val->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti'.$dags_val->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_val->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_val->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_val->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dags_val->dag_no), 0);
    
                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;
    
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }


                        // new premium addition
                        if($this->input->post('area_new'.$dags_val->dag_no) !=10){

                            $maxland_ganda ='';
                            if(!empty($this->input->post('area_new'.$dags_val->dag_no))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_val->dag_no));
                            
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

                    // if ($reservation == true) {
                    //     foreach ($reservation as $reservation_road) {
                    //         if ($reservation_road->type == 'R') {
                    //             $this->form_validation->set_rules('reserved_bigha' . $reservation_road->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    //             $this->form_validation->set_rules('reserved_katha' . $reservation_road->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    //             $this->form_validation->set_rules('reserved_lessa' . $reservation_road->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    //             $this->form_validation->set_rules('reserved_ganda' . $reservation_road->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');

                    //             $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $reservation_road->dag_no), 0);
                    //             $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $reservation_road->dag_no), 0);
                    //             $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $reservation_road->dag_no), 0);
                    //             $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda' . $reservation_road->dag_no), 0);

                    //             $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                    //             if ($dagAreaLessaValidation < $roadSideAreaLessaValidation) {
                    //                 $reserveMoreThanAppArea = 1;
                    //             }

                    //             $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                    //         }
                    //     }
                    // }
                }
                else
                {
                    foreach ($dags as $dags_val)
                    {
                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dags_val->dist_code, $dags_val->subdiv_code, $dags_val->cir_code, $dags_val->mouza_pargona_code, $dags_val->lot_no, $dags_val->vill_townprt_code, $dags_val->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }

                        $this->form_validation->set_rules('zonal_valuation_prem'.$dags_val->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_east'.$dags_val->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dags_val->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dags_val->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dags_val->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('dag_area_b' . $dags_val->dag_no, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k' . $dags_val->dag_no, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc' . $dags_val->dag_no, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('home_b' . $dags_val->dag_no, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k' . $dags_val->dag_no, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc' . $dags_val->dag_no, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b' . $dags_val->dag_no, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k' . $dags_val->dag_no, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc' . $dags_val->dag_no, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dags_val->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dags_val->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dags_val->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dags_val->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dags_val->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dags_val->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dags_val->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dags_val->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dags_val->dag_no), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                            $agiAreaMoreThanDagA = 1;
                        }
                        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
                            $homeAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                        if ($roadside_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_road'.$dags_val->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dags_val->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dags_val->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dags_val->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dags_val->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags_val->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags_val->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags_val->dag_no), 0);
    
                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;
    
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
    
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                        // new premium addition
                        if($this->input->post('area_new'.$dags_val->dag_no) !=10){
                            if(!empty($this->input->post('area_new'.$dags_val->dag_no))){
                                $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dags_val->dag_no));
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

                    // if ($reservation == true) {
                    //     foreach ($reservation as $reservation_road) {
                    //         if ($reservation_road->type == 'R') {
                    //             $this->form_validation->set_rules('reserved_bigha' . $reservation_road->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    //             $this->form_validation->set_rules('reserved_katha' . $reservation_road->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    //             $this->form_validation->set_rules('reserved_lessa' . $reservation_road->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    //             $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $reservation_road->dag_no), 0);
                    //             $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $reservation_road->dag_no), 0);
                    //             $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $reservation_road->dag_no), 0);

                    //             $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside;

                    //             if ($dagAreaLessaValidation < $roadSideAreaLessaValidation) {
                    //                 $reserveMoreThanAppArea = 1;
                    //             }

                    //             $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                    //         }
                    //     }
                    // }
                }

                $isUrbanRevertBack = $this->SettlementCommonModel->getUrbanForRevertBack($case_no);
                $checkUrbanCon = $isUrbanRevertBack->is_urban;

                // new additional property calculation
                $additional_properties = $district['additional_property'] = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                    foreach ($additional_properties as $singleProperty) {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                        $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                } else {
                    foreach ($additional_properties as $singleProperty) {
                        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }

                // new additional property calculation end here

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

                //************getting the Empty trace map file dag number */
                $sqlSupportiveDag = $this->db->query("SELECT dag_no FROM supportive_document WHERE case_no = ? AND file_name = ? AND file_type = ? AND file_path = ?", array($case_no, 'Trace Map Copy', 'NATRACE', 'NATRACE'));

                $dbTracemapDagsArr = array();
                if($sqlSupportiveDag->num_rows() > 0)
                {
                    $db_dag_trace = $sqlSupportiveDag->result();

                    foreach($db_dag_trace as $trace_db_dag)
                    {
                        $dbTracemapDagsArr[] = $trace_db_dag->dag_no;
                    }

                    // $dbTracemapDagsArr = $t_db_dag;
                }

                //****************getting the inserted file by LM during update */
                if(isset($_FILES))
                {
                    $traceMapDagArr = array();
                    foreach ($_FILES as $file => $key)
                    {
                        if ($key['tmp_name'] == false) {
                            continue;
                        }
                        $doc_dag_no =  strstr($file,  '_', true);
                        $traceMapDagArr[] = (int)str_replace("DOCMAIN", "", $doc_dag_no);
                    }
                    // $traceMapDagArr = $traceMapDag;
                }

                //**********checking is all empty trace map from db is exist in intered trace map array by lm */
                if (!empty(array_diff($dbTracemapDagsArr, $traceMapDagArr))) {

                    $this->form_validation->set_rules('Trace_map_extra_validation','(Please insert Trace Map for dag no'. json_encode($dbTracemapDagsArr).')','required');
                }

                // additional file upload validation
                // upload additional files
                if (isset($_FILES['fileUpload']['name'])) {
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size

                    for ($i = 0; $i < $fileCount; $i++) {
                        if ($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]) {

                            $name = $_FILES['fileUpload']['name'][$i];
                            $size = $_FILES['fileUpload']['size'][$i];

                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp = explode("/", $mime);
                            $ext = $exp[1];

                            if ($name != null) {
                                if ($ext == null) {
                                    // todo error show extension missing
                                    $this->form_validation->set_rules('additional_doc_err', 'File extension', 'required');

                                }
                                if (!in_array($ext, UPLOAD_TYPE_VALIDATION)) {
                                    // todo error show file allow type not match
                                    $this->form_validation->set_rules('additional_doc_err', 'Only JPG/PNG/PDF file', 'required');
                                }
                                if ($size > UPLOAD_MAX_SIZE) {
                                    // todo error show file size
                                    $this->form_validation->set_rules('additional_doc_err', 'Maximum 2MB file size', 'required');
                                }
                            } else {
                                // todo error show file not nullable
                                $this->form_validation->set_rules('additional_doc_err', 'File name', 'required');
                            }
                        } else {
                            $this->form_validation->set_rules('additional_doc_err', 'File', 'required');
                        }
                    }
                }
            }

            if ($this->form_validation->run() == false) {
                if (isset($fileCount)) {
                    $district['fileCount'] = $fileCount;
                }
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
            }
            else
            {

                if($validation_bypass == 0)
                {
                    if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0) {
                        $this->session->set_flashdata('error', 'Total applied area should not be Zero !');
                        return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
                    }
                    if ($agiAreaMoreThanDagA == 1) {
                        $this->session->set_flashdata('error', 'Total applied area (Agricultural) should not be more than total Dag Area !');
                        return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
                    }
                    if ($homeAreaMoreThanDagA == 1) {
                        $this->session->set_flashdata('error', 'Total applied area (Homestead) should not be more than total Dag Area !');
                        return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
                    }
                    if ($reserveMoreThanAppArea == 1) {
                        $this->session->set_flashdata('error', 'Total roadside reserved area should not be more than total applied area !');
                        return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
                    }
                    if ($totalDagAreaLessaValidation < $totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) {
                        $this->session->set_flashdata('error', 'Total applied area should not be more than total Dag Area !');
                        return redirect(base_url() . 'index.php/SettlementTribal/secondProceeding?case=' . $this->utilityclass->encryptJwtCase($case_no));
                    }
                }

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

                $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
                
                $this->db->trans_begin();

                // insertion in backup table
                $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'LM'")->row()->ct;

                $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

                $phase_count = (int) $phase_count + 1;
                $backup_array_lm = [
                    'applid' => $applid_backup,
                    'case_no' => $case_no,
                    'from_office' => 'LM',
                    'to_office' => $pending_officer,
                    'status' => 'X',
                    'phase' => 'LM_' . $phase_count,
                    'data' => json_encode($_POST),
                ];

                $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);

                if ($backup_insertion_lm != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP0032: Insertion failed in settlement_backup_json RTPS Case No ' . $case_no);

                    $this->session->set_flashdata('error_data', "#BACKUP0032: Registration of Settlement failed for case no : " . $case_no);
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
                        log_message('error', '#ERROR18365: Updation failed in settlement_additional_property RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROR18365: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
              
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
                            log_message('error', '#ERROR0011266: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERROR0011266: Registration of Settlement failed for case no : ".$application_no
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

                $basicData=array(
                    'date_update' => date('Y-m-d G:i:s'),
                    'status'=>'X',
                    'user_code'=>$this->session->userdata('user_code'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'from_office' => 'LM',
                    'pending_officer' => $pending_officer,
                    'pending_office' => $pending_officer,
                    'approve_by' => $approved_by
                    /////////
                );

                if ($is_prem_update=='NO'){
                    unset($basicData['approve_by']);
                }

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicData);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No ' . $application_no);

                    $this->session->set_flashdata('error_data', "#SETUP0001: Updation of Settlement failed for case no : " . $application_no);
                    redirect(base_url() . "index.php/home");

                    return false;
                }

                $sql1 = "SELECT petition_no FROM settlement_basic WHERE case_no = '$case_no'";
                $result1 = $this->db->query($sql1);
                if ($result1->num_rows() > 0) {
                    $petition_no = (int) $result1->row()->petition_no;
                } else {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No ' . $application_no);
                    $data = array(
                        'error' => "#ERRSET00031: Registration of Settlement failed for case no : " . $application_no,
                    );
                    echo json_encode($data);
                    return false;
                }

                if($validation_bypass == 0)
                {
                    // upload additional file
                    if (isset($_FILES['fileUpload']['name'])) {
                        for ($i = 0; $i < $fileCount; $i++) {
                            $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp = explode("/", $mime);
                            $onlyExtension = $exp[1];

                            $fileRename = $this->UUID4() . '.' . $onlyExtension;

                            $config['upload_path'] = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size'] = UPLOAD_MAX_SIZE;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file')) {
                                $document = array(
                                    'case_no' => $case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type' => $_FILES['file']['type'],
                                    'file_path' => UPLOAD_DIR . $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type' => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                                );

                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document', $document);

                                if ($addMoreDocQuery != 1) {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);

                                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }

                            } else {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);

                                $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }
                    //end of additional file upload

                    foreach ($lmdata['dags'] as $dags_landmark) {
                        $landmark_east = $this->input->post('landmark_east'.$dags_landmark->dag_no);
                        $landmark_west = $this->input->post('landmark_west'.$dags_landmark->dag_no);
                        $landmark_north = $this->input->post('landmark_north'.$dags_landmark->dag_no);
                        $landmark_south = $this->input->post('landmark_south'.$dags_landmark->dag_no);

                        $landmark = [
                            'east' => $landmark_east,
                            'west' => $landmark_west,
                            'north' => $landmark_north,
                            'south' => $landmark_south,
                        ];

                        $dag_details_update_arr = [
                            'landmark' => json_encode($landmark),
                        ];

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dags_landmark->dag_no);
                        $this->db->update('settlement_dag_details', $dag_details_update_arr);

                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP0333004: Updation failed in settlement_dag_details Dharitree Case No ' . $case_no);
                            $data = array(
                                'error' => "#SETUP0333004: Registration of settlement_dag_details failed for case no : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    ////////////////////file///////////////////////////
                    if (isset($_FILES)) {
                        foreach ($_FILES as $file => $key) {

                            if ($key['tmp_name'] == false) {
                                continue;
                            }

                            $doc_dag_no = strstr($file, '_', true);
                            $doc_id = substr($file, strpos($file, "_") + 1);

                            preg_match('/DOCMAIN/', $file, $match);

                            if ($match) {
                                if ($match[0] == 'DOCMAIN') {
                                    $timestamp = date('mdYhis', time()) . uniqid();

                                    $config['file_name'] = 'updated_file' . $timestamp;
                                    $config['upload_path'] = UPLOAD_DIR;
                                    $config['allowed_types'] = 'pdf|jpg|png';
                                    $config['max_size'] = 2000;

                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);

                                    if (!$this->upload->do_upload($file)) {
                                        $error = array('error' => $this->upload->display_errors());
                                        echo json_encode($error);
                                        return false;
                                    } else {
                                        $data = array('upload_data' => $this->upload->data());
                                        $document = array(
                                            'file_type' => $data['upload_data']['file_type'],
                                            'file_path' => $config['upload_path'] . $data['upload_data']['orig_name'],
                                        );

                                        $this->db->where('id', $doc_id);
                                        $this->db->update('supportive_document', $document);

                                        // echo $this->db->last_query();

                                        if ($this->db->affected_rows() == 0) {
                                            $this->db->trans_rollback();
                                            log_message('error', '#SETUP6845545: Updation failed in supprotive_documents Dharitree Case No ' . $application_no);

                                            log_message("error", "last query" . json_encode($this->db->last_query()));
                                            $this->session->set_flashdata('error_data', "#SETUP6845545: Failed to upload documents, Please compress the file and reupload. case no : " . $application_no);
                                            redirect(base_url() . "index.php/home");
                                            return false;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // if ($reservation == true) {
                    //     foreach ($reservation as $reservation_road) {
                    //         if ($reservation_road->type == 'R') {
                    //             $reservedarea_road = array(
    
                    //                 'bigha' => $this->input->post('reserved_bigha' . $reservation_road->dag_no),
                    //                 'katha' => $this->input->post('reserved_katha' . $reservation_road->dag_no),
                    //                 'lessa' => $this->input->post('reserved_lessa' . $reservation_road->dag_no),
                    //                 'ganda' => $this->input->post('reserved_ganda' . $reservation_road->dag_no),
                    //                 'kranti' => $this->input->post('reserved_kranti' . $reservation_road->dag_no),
                    //                 'lm_code' => $this->session->userdata('user_code'),
                    //                 'date_update' => date('Y-m-d h:i:s'),
                    //             );
    
                    //             $this->db->where('case_no', $case_no);
                    //             $this->db->where('type', 'R');
                    //             $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                    //             $this->db->update('settlement_reservation', $reservedarea_road);
    
                    //             // echo $this->db->last_query();
                    //             // die;
    
                    //             if ($this->db->affected_rows() == 0) {
                    //                 $this->db->trans_rollback();
                    //                 log_message('error', '#SETUP000444: Updation failed in settlement_reservation Dharitree Case No ' . $application_no);
                    //                 $data = array(
                    //                     'error' => "#SETUP000444: Registration of settlement_reservation failed for case no : " . $application_no,
                    //                 );
                    //                 echo json_encode($data);
                    //                 return false;
                    //             }
                    //         }
    
                    //     }
                    // }

                       ///// road side reserve area start /////
                    if($reservation == true)
                    {
                        if ($roadside_comment_check=='YES') {
                            foreach ($reservation as $reservation_road)
                            {
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

                                    if ($this->db->affected_rows() == 0) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#SETUP000444: Updation failed in settlement_reservation Dharitree Case No ' . $application_no);
                                        $data = array(
                                            'error' => "#SETUP000444: Registration of settlement_reservation failed for case no : " . $application_no,
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                }

                            }
                        }

                        if ($roadside_comment_check=='NO') {
                            $resUpdate = "UPDATE settlement_reservation SET is_deleted = 1  WHERE case_no = '$case_no' AND type = 'R'";

                            $this->db->query($resUpdate);

                            if ($this->db->affected_rows() == 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#RESUPDTT000311: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#RESUPDTT000311: Updation Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }


                    }else{
                        //insert reservation
                        ///// road side reserve area start /////
                        if ($roadside_comment_check=='YES') {
                            foreach ($dags as $dags_roadside) {
                                $reservedarea=array(
                                    'dist_code'=>$this->input->post('dist_code'),
                                    'subdiv_code'=>$this->input->post('subdiv_code'),
                                    'cir_code'=>$this->input->post('cir_code'),
                                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                    'lot_no'=>$this->input->post('lot_no'),
                                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                    'dag_no'=>$this->input->post('reserved_dag_road'.$dags_roadside->dag_no),
                                    'patta_no'=>$this->input->post('reserved_patta_road'.$dags_roadside->dag_no),
                                    'bigha'=>$this->input->post('reserved_bigha'.$dags_roadside->dag_no),
                                    'katha'=>$this->input->post('reserved_katha'.$dags_roadside->dag_no),
                                    'lessa'=>$this->input->post('reserved_lessa'.$dags_roadside->dag_no),
                                    'ganda'=>$this->input->post('reserved_ganda'.$dags_roadside->dag_no),
                                    'kranti'=>$this->input->post('reserved_kranti'.$dags_roadside->dag_no),
                                    'case_no'=>$case_no,
                                    'applid'=>$this->input->post('applid'),
                                    'lm_code'=>$this->session->userdata('user_code'),
                                    'date_entry'=>date('Y-m-d h:i:s'),
                                    'date_update'=>date('Y-m-d h:i:s'),
                                    'type'=>'R'
                                );

                                $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                                // echo $this->db->last_query(); die();
                                if ($reserveData != 1) {
                                    $this->db->trans_rollback();
                                    log_message('error', '#UPDTT00052: Update failed in settlement_reservation RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#UPDTT00052: Update failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }
                            }
                        }
                    }
                    ///// family reserve area end //////

                     //*********if LM if case of case rejected the rejected remarks */
                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_TRIBAL_COMMUNITY_ID);

                    $comment = addslashes($this->input->post('lm_note'));
                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm == null || $pro_class_lm == '' || $pro_class_lm == 0) ? 0 : $this->input->post('protected_class_lm');

                    $lmnote = array(
                        //'user_code'=>$this->session->userdata('user_code'),
                        'chitha_verified' => $this->input->post('chitha_verified'),
                        'vlb_verified' => $this->input->post('vlb_verified'),
                        'possession_verification' => $this->input->post('possession_verification'),
                        'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
                        'period_possession' => date('Y-m-d'),
                        'land_falls' => $this->input->post('land_falls'),
                        'is_landless' => $this->input->post('is_landless'),
                        'falls_und_gmc' => $this->input->post('falls_und_gmc'),
                        'roadside_reservation' => $this->input->post('roadside_reservation'),
                        'landed_property' => $this->input->post('landed_property'),
                        'is_st' => $this->input->post('is_st'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'is_free_encroachment' => $this->input->post('is_free_encroachment'),
                        'trace_map_copy' => 'NA',
                        'chitha_copy' => 'NA',
                        'lm_note' => $comment,
                        'lm_remark_text' => $this->input->post('lm_remark_text'),
                        'date_update' => date('Y-m-d h:i:s'),
                        'protected_class_lm' => $protected_class_lm,
                        'litigation' => $this->input->post('litigation'),
                        'landslide'            => $this->input->post('landslide'),
                        'erosion'            => $this->input->post('erosion'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );

                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_ap_lmnote', $lmnote);

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No ' . $application_no);

                        $this->session->set_flashdata('error_data', "#SETUP0004: Updation failed for case no : " . $application_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }

                    //// premium insert lm update start
                    if ($is_prem_update == 'YES') {

                        $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));
                        
                        if($checkingPremiumExistSql->num_rows() > 0)
                        {
                            $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
                            $resultprem = $this->db->query($sqlprem);
    
                            if ($this->db->affected_rows() == 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No ' . $application_no);
                                $data = array(
                                    'error' => "#ERRSET000311: Updation Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }

                        $sumMbAmount = 0;
                        $approved_by ='';
                        $count =0;
                        foreach ($dags as $premdags) {

                            $count++;
                            if($count >1){
                                if ($approved_by != $this->input->post('approval'.$premdags->dag_no)){
                                    $this->db->trans_rollback();
                                    $this->session->set_flashdata('message', "Error #ERRAM000399: Settlement Application not submitted case no # $application_no");
                                    log_message('error', '#ERRAM000399: Multiple User Approval, RTPS Case No '.$application_no);
                                    redirect(base_url() . "index.php/home");
                                }

                            }

                            // premium verify start ******************
                            if (in_array($premdags->dist_code, json_decode(BARAK_VALLEY))) {
                                $area_in_bigha = 6400;
                            } else {
                                $area_in_bigha = 100;
                            }
                            $concession_rate = 25;
                            $ratetype = $this->input->post('rate_type' . $premdags->dag_no);
                            $ratepr2 = $this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                            $ratepr = $ratepr2->rate_type;
                            $is_full_pay = $this->input->post('paymode');
                            // $prem_zonal = $this->input->post('zonal_valuation_prem' . $premdags->dag_no);
                            $prem_zonal = $this->utilityclass->getZonalValue($premdags->dist_code,$basic['uuid'],$premdags->dag_no);
                            $prem_area = $this->input->post('total_lessa' . $premdags->dag_no);
                            $prem_rate = $this->input->post('rate' . $premdags->dag_no);
                            $prem_concession = $this->input->post('concession' . $premdags->dag_no);
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

                            // if ($prem_concession == "YES") {
                            //     if ($ratepr == 'P') {
                            //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                            //         $discount = $prem_rate - ($prem_rate * $concession_rate / 100);
                            //         $amount = ($premium * $discount / 100);
                            //         // $finalamount = round($amount,2);
                            //         $finalamount = ceil($amount);
                            //     } else if ($ratepr == 'R') {
                            //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                            //         $discount = $prem_rate - $concession_rate;
                            //         $amount = ($premium * $discount / 100);
                            //         $finalamount = ceil($amount);
                            //     }

                            // } else if ($prem_concession == "NO") {
                            //     if ($ratepr == 'P') {
                            //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                            //         $amount = ($premium * $prem_rate / 100);
                            //         $finalamount = ceil($amount);
                            //     } else if ($ratepr == 'R') {
                            //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                            //         $amount = ($premium * $prem_rate / 100);
                            //         $finalamount = ceil($amount);
                            //     }
                            // }
                            if ($prem_concession=="YES"){
                                if($ratepr =='P'){
                                    if($prem_area>$mb_land){

                                        $concession_factor = (100 - $concession_rate) / 100;

                                        $base_premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                        $amount1 = ceil($base_premium1 * $prem_rate / 100 * $concession_factor);

                                        //for access area
                                        $access_area = max(0, $prem_area - $mb_land);
                                        $base_premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                        $amount2 = ceil($base_premium2 * $concession_factor);
                                        
                                        $finalamount = ceil($amount1 + $amount2);


                                    }else{

                                        $concession_factor = (100 - $concession_rate) / 100;

                                        $base_premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                        $amount = $base_premium * ($prem_rate / 100) * $concession_factor;

                                        $finalamount = ceil($amount);
                                    }
                                    
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
                                    if($prem_area>$mb_land){
                                        // --- Part 1: within mb_land ---
                                        $premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                        $amount1  = ceil($premium1 * $prem_rate / 100);

                                        // --- Part 2: excess area at flat 150% zonal (no prem_rate applied) ---
                                        $access_area = $prem_area - $mb_land;
                                        $premium2    = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                        $amount2     = ceil($premium2);

                                        $finalamount = $amount1 + $amount2;
                                        
                                    }else{
                                        // --- No excess area ---
                                        $premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                        $amount  = $premium * $prem_rate / 100;
                                        $finalamount = ceil($amount);
                                    }
                                }else if($ratepr =='R'){
                                    // $premium = $prem_area * $prem_rate / $area_in_bigha;
                                    // $amount = ($premium * $prem_rate / 100);
                                    // $finalamount = ceil($amount);
                                    $finalamount = ceil($prem_area * $prem_rate / $area_in_bigha);
                                }
                            }

                            $sumMbAmount += $finalamount;

                            // premium verify end ******************

                            $premdata = array(
                                'case_no' => $case_no,
                                'user_code' => $this->session->userdata('user_code'),
                                // 'uuid'=>$premdags->uuid,
                                'dag_no' => $premdags->dag_no,
                                'zonal_valuation' => $this->input->post('zonal_valuation_prem' . $premdags->dag_no),
                                'area_name' => $this->input->post('area' . $premdags->dag_no),
                                'land_type' => $this->input->post('land_type' . $premdags->dag_no),
                                'rate_type' => $this->input->post('rate_type' . $premdags->dag_no),
                                'rate' => $this->input->post('rate' . $premdags->dag_no),
                                'concession' => $this->input->post('concession' . $premdags->dag_no),
                                'amount_dag' => $this->input->post('amount' . $premdags->dag_no),
                                'final_amount' => $this->input->post('finalamount'),
                                'due_amount' => $this->input->post('totaldue'),
                                'total_lessa' => $this->input->post('total_lessa' . $premdags->dag_no),
                                'is_full_pay' => $this->input->post('paymode'),
                                'is_final' => 1,
                                'date_entry' => date('Y-m-d h:i:s'),
                                'approve_by'=>$this->input->post('approval'.$premdags->dag_no),

                            );


                            $insPremiumUpdate = $this->db->insert('settlement_premium', $premdata);


                            if ($insPremiumUpdate != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSET000102: Update of Settlement failed for case no : " . $case_no,
                                );
                                echo json_encode($data);
                                return false;
                            }

                            $approved_by = $this->input->post('approval'.$premdags->dag_no);
                        } // foreach end

                        // premium verify 2 start ******************
                        if ($sumMbAmount != $this->input->post('finalamount')) {
                            // var_dump("Amount mismatch!!!"); die;
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0003: Settlement Application not submitted case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        if ($is_full_pay == "NO") {
                            $discount = 30;
                            $finaldue = ($sumMbAmount * $discount / 100);
                            // $finaldueamount = round($finaldue,2);
                            $finaldueamount = ceil($finaldue);
                        } else if ($is_full_pay == "YES") {
                            $finaldueamount = $sumMbAmount;
                        }

                        if ($finaldueamount != $this->input->post('totaldue')) {
                            // var_dump("Due Amount mismatch!!!");
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0004: Settlement Application not submitted case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }

                        // premium verify 2 end ******************
                    }else{
                        // area check with premium table before update ******************
                        $prem_settleemt_area=0;
                        $total_settlement_area= $totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation-$totalRoadSideAreaLessaValidation;
                        // var_dump($total_settlement_area); die;
                        $prem_s_area = $this->db->query("Select total_lessa from settlement_premium where is_final=1 and case_no='$case_no'")->result();
                        foreach ($prem_s_area as $prem_s) {
                            $prem_settleemt_area=$prem_settleemt_area+$prem_s->total_lessa;
                        }
                        if ($total_settlement_area != $prem_settleemt_area) {

                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM00014: Settlement Application not submitted Area mismatch case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        // area check with premium table before update end ******************
                    }
                    /// premium insert lm update end
                }

                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                        SETTLEMENT_TRIBAL_COMMUNITY_ID, 
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
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $this->input->post('lm_remark_text'),
                    'status' => 'X',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'LM updated note submitted'
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

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                } else {
                    //////////////POST To basundhara/////////////////////
                    $rmk = 'Re Report and Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = 'CO';
                    // $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    // $this->DashboardInheritance($case_no['case_no']);

                    $this->session->set_flashdata('message_success', "Settlement Application Updated Successfully with case no # $case_no");
                    redirect(base_url() . "index.php/home");

                }
            }

        }
        else
        {
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



            $lmdata['_view'] = 'SettlementView/Lm/Tribal/SettlementTribalView';
            $this->load->view('layouts/main', $lmdata);
        }
    }

    //   -js- 29-aug-22 for getting the VLB encroacher deatils
    public function vlbEncroacherDetails()
    {
        if (isset($_GET['dag']) && isset($_GET['m']) && isset($_GET['l']) && isset($_GET['v']) && isset($_GET['dist']) && isset($_GET['cir']) && isset($_GET['sub_div'])) {

            $dist_code = $this->input->get('dist');
            $subdiv_code = $this->input->get('sub_div');
            $circle_code = $this->input->get('cir');
            $mouza_code = $this->input->get('m');
            $lot_no = $this->input->get('l');
            $vill_townprt_code = $this->input->get('v');
            $dag_no = $this->input->get('dag');

            $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_townprt_code, $dag_no);
            $vlb_enc['vlb_enc'] = $vlb_encroacher;
            if ($vlb_encroacher == true) {
                // getting the encroacher details
                $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                $vlb_enc['vlb_enc_details'] = $vlb_encroacher_in_dag;
            } else {
                $vlb_enc['empty_err'] = "No Land Bank Details found!!";
            }

            $vlb_enc['getCaste'] = $this->db->query('select * from master_caste')->result();

            $vlb_enc['_view'] = 'SettlementView/VlbEncroacherDetails';
            $this->load->view('layouts/main', $vlb_enc);
        }
    }

}
