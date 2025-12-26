<?php
class SettlementTenant extends CI_Controller
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
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
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

    public function agrAreaLessaValidation()
    {
        return false;
    }

    public function appAreaMoreThanDagA()
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

    // settlement Tenant application view
    public function settlementTenantRegistration($review_flag = false)
    {
        $appli = $this->input->get('app'); // get rtps application no
        $application_no = $this->utilityclass->decryptJwtCase($appli);

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
                $data = array(
                    'error' => "#ERROR0002: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                exit;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->SettlementApiModel->genearteSettlementPetitionNo();
            $case_no['case_no'] = $case_name . $petition_no . "/" . SETTLEMENT_TENANT;

            //check for tribal belt
            if ($output->applicants['0']->tribe_category == 1) {
                $tribal_belt = 'YES';
            } else if ($output->applicants['0']->tribe_category == 0) {
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

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM
            $settlement_basic = [
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' => $m,
                'lot_no' => $l,
                'vill_townprt_code' => $v,
                'service_code' => SETTLEMENT_TENANT_ID,
                'ref_no' => $output->applicants['0']->ref_no,
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F',
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'Z',
                'submission_date' => date('Y-m-d G:i:s'),
                'period_possession' => date('Y-m-d'),
                'occupation_applicant' => $output->applicants['0']->applicant_occupation,
                'applid' => $application_no,
                'caste' => $output->applicants['0']->caste_category,
                'uuid' => $output->applicants['0']->uuid,
                'tribal_belt' => $tribal_belt,
                'bhumiputra_confirmation' => $bhumiputra_confirmation,
                'bhumiputra_certificate_no' => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                'user_code' => $this->session->userdata('user_code'),
            ];
            $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);

            if ($settlement_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Settlement failed for RTPS application no : " . $application_no);
                $data = array(
                    'error' => "#ERROR0003: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
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
                            'service_id' => SETTLEMENT_TENANT_ID,
                            'applied_flag' => CITIZEN,
                            'dist_name' => trim($value->dist_name),
                            'cir_name' => trim($value->cir_name),
                            'vill_name' => trim($value->vill_name),
                            'applid' => $application_no,
                        ];
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No ' . $application_no . ' and query is ' . $this->db->last_qery());
                            $data = array(
                                'error' => "#ERROR0004: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT DAG DETAILS
            if (!empty($output->settlements)) {
                foreach ($output->settlements as $dag) {
                    if ($dag->is_applicant == 1) {

                        $new_land_class = $this->utilityclass->getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag->dag_no);

                        $insSettlementDagDetails = [

                            'dist_code' => $d,
                            'subdiv_code' => $s,
                            'cir_code' => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no' => $l,
                            'vill_townprt_code' => $v,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d'),
                            'case_no' => $case_no['case_no'],
                            'petition_no' => $case_no['petition_no'],
                            'year_no' => date('Y'),
                            'operation' => 'E',
                            'new_land_class_code' => $new_land_class->land_class_code,
                            'dag_no' => $dag->dag_no,
                            'patta_no' => $dag->patta_no,
                            'patta_type_code' => $dag->patta_code,
                            'dag_area_b' => $dag->applied_bigha,
                            'dag_area_k' => $dag->applied_katha,
                            'dag_area_lc' => $dag->applied_lessa,
                            'dag_area_g' => $dag->applied_ganda,
                            'dag_area_kr' => $dag->applied_kranti,
                            's_dag_area_b' => $dag->mbigha,
                            's_dag_area_k' => $dag->mkatha,
                            's_dag_area_lc' => $dag->mlessa,
                            's_dag_area_g' => $dag->mganda,
                            's_dag_area_kr' => $dag->mkranti,
                            'revenue' => 0,
                            'is_urban' => $app->is_urban
                        ];
                        $settlement_dag_details = $this->db->insert('settlement_dag_details', $insSettlementDagDetails);

                        if ($settlement_dag_details != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0005: Insertion failed in settlement_dag_details for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : " . $application_no);
                            $data = array(
                                'error' => "#ERROR0005: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }

                        //*******insertion in settlement_area_history**************
                        if (in_array($d, json_decode(BARAK_VALLEY))){
                            //***********actual Encroachment area ***************
                            $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($dag->mbigha, $dag->mkatha, $dag->mlessa, $dag->mganda);

                            //***********Settlement area that applicant will get settlement on***********
                            $total_settlement_ganda_home = $this->utilityclass->Total_ganda($dag->mbigha, $dag->mkatha, $dag->mlessa, $dag->mganda);

                            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda_home);

                            //*************leftout area homestead**************
                            $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;

                            $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);


                            $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);
                        }
                        else
                        {
                            //********actual Encroachment area********** 
                            $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($dag->mbigha, $dag->mkatha, $dag->mlessa);

                            //*******Settlement area that applicant will get settlement on**********
                            $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($dag->mbigha, $dag->mkatha, $dag->mlessa);

                            //*************Total settlement area */
                            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa_home);

                            //****************leftout area homestead**************
                            $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;

                            $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                            //**********Total left out area***************

                            $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);
                        }

                        $settlementAreaHistoryArr = [
                            'application_no' => $application_no,
                            'case_no' => $case_no['case_no'],
                            'dag_no' => $dag->dag_no,
                            'uuid' => $dag->uuid,
                            'created_at' => date('Y-m-d'),
                            'applied_area_home_bigha' => $dag->mbigha,
                            'applied_area_home_katha' => $dag->mkatha,
                            'applied_area_home_lessa' => $dag->mlessa,
                            'applied_area_home_ganda' => $dag->mganda,
                            'applied_area_home_kranti' => $dag->mkranti,

                            'settlement_area_home_bigha' => $dag->mbigha,
                            'settlement_area_home_katha' => $dag->mkatha,
                            'settlement_area_home_lessa' => $dag->mlessa,
                            'settlement_area_home_ganda' => $dag->mganda,
                            'settlement_area_home_kranti' => $dag->mkranti,

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

                    }
                }
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
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file 2!");
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

                    if($appl->gurdian_relation_id == null)
                    {
                        $pdar_rel_guar = 0;
                    }
                    else
                    {
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }

                    if ($appl->pdar_type == 'EN')
                    {
                        //************this to  be edited */
                        if(isset($appl->khatian_no))
                        {
                            if(trim($appl->khatian_no) == '' || trim($appl->khatian_no) == NULL || trim($appl->khatian_no) == -1)
                            {
                                $get_pdar_name = 'NA';
                                $get_pdar_guardian = 'NA';
                                $get_pdar_add1 = '';
                                $get_pdar_add2 = '';
                            }
                            else
                            {
                                $getRiotee = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=?
                                AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=? AND khatian_no=? AND tenant_id=?", array($s, $c, $l, $m, $v, $appl->dag_no, $appl->khatian_no, $appl->encroacher_id));

                                if($getRiotee->num_rows() <= 0)
                                {
                                    $get_pdar_name = '';
                                    $get_pdar_guardian = '';
                                    $get_pdar_add1 = '';
                                    $get_pdar_add2 = '';
                                }
                                else
                                {
                                    $riotee_details = $getRiotee->row();

                                    $get_pdar_name = $riotee_details->tenant_name;
                                    $get_pdar_guardian = $riotee_details->tenants_father;
                                    $get_pdar_add1 = $riotee_details->tenants_add1;
                                    $get_pdar_add2 = $riotee_details->tenants_add2;
                                }
                            }
                        }

                        $riotee_id = $appl->encroacher_id;
                        $khatian_no = $appl->khatian_no;
                    }
                    else
                    {
                        $riotee_id = '-1';
                        $khatian_no = '-1';

                        $get_pdar_name = isset($appl->name_ass) ? $appl->name_ass : 'NA';
                        $get_pdar_guardian = isset($appl->gurdian_name_ass) ? $appl->gurdian_name_ass : 'NA';
                        $get_pdar_add1 = $appl->pre_add;
                        $get_pdar_add2 = $appl->per_add;
                    }

                    if($appl->chitha_pdar_id == null){
                        $chitha_pdar_id = '-1';
                    }
                    else
                    {
                        $chitha_pdar_id = $appl->chitha_pdar_id;
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
                        'pdar_id' => $chitha_pdar_id,
                        'pdar_cron_no' => $cron_no,
                        'pdar_name' => $get_pdar_name,
                        'pdar_guardian' => $get_pdar_guardian,
                        'pdar_rel_guar' => $pdar_rel_guar,
                        'pdar_gender' => $appl->gender,
                        'pdar_add1' => $get_pdar_add1,
                        'pdar_add2' => $get_pdar_add2,
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
                        'period_possession' => $appl->possession_date,
                        'riotee_id' => $riotee_id,
                        'khatian_no' => $khatian_no,
                    ];
                    $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);

                    if ($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : " . $application_no);

                        $data = array(
                            'error' => "#ERROR0006: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
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

            //insert into BASUNDHAR APPLICATION
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

            //insert into back up file
            $backup_array = [
                'applid' => $application_no,
                'case_no' => $case_no['case_no'],
                'status' => 'I',
                'data' => $backup,
            ];
            $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
            if ($backup_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No ' . $application_no);

                $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : " . $application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }
            $this->db->trans_commit(); // transaction ends here

        }

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

        //get case no from basundhar_application

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

        //get petition no from basundhar_application

        // $this->utilityclass->lmAuthBasic($case_no);

        $this->utilityclass->lmAuthFirstProceeding($case_no);

        $petition_no = $this->db->select()
            ->where('applid', $application_no)
            ->get('settlement_basic')->row()->petition_no;

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


        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['nominee']=$nominee;

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
        $district['nextKin'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['bhumi'] = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $district['aadhar'] = $this->SettlementKhasModel->getMainApplicant($case_no);

        $district['basic'] = $basic;
        $district['applicants_buyers'] = $applicants_buyers;
        $district['applicants_owners'] = $applicants_owners;
        $district['applicants_encroacher'] = $applicants_encroacher;
        $district['applicants_riotee_nok'] = $applicants_riotee_nok;

        $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);
        $district['dags'] = $dags;
        $district['area_details'] = $dags;
        $district['lmnotes'] = $lmnotes;
        $district['proceedings'] = $proceedings;

        $district['dhardocuments'] = $dhardocuments;
        $district['case_no'] = $case_no;


        $district['co_name'] = $this->SettlementCommonModel->getCoName($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code);
        $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $revenue = $this->db->query("SELECT dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no))->row();
        $district['revenue'] = $revenue;



        if(trim($applicants_encroacher[0]->khatian_no) == NULL || trim($applicants_encroacher[0]->khatian_no) == '' || trim($applicants_encroacher[0]->khatian_no) == -1)
        {
            $district['chitha_tenant_exist'] = 'n';
            $district['chitha_tenant_app_end'] = $applicants_encroacher[0];
        }
        else
        {
            $getChithaTenant = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=?
            AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=?
            AND khatian_no=? AND tenant_id=?", array($district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->lot_no, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no, $applicants_encroacher[0]->riotee_id));

            if($getChithaTenant->num_rows() <= 0)
            {
                $district['chitha_tenant_exist'] = 'n';
                $district['chitha_tenant_app_end'] = $applicants_encroacher[0];
            }
            else
            {
                $district['chitha_tenant_exist'] = 'y';
                $district['chitha_tenant'] = $getChithaTenant->row();
            }

        }


        $district['riotee_list'] = $this->SettlementTenantModel->getRioteeList($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no);

        if (!empty($district['applicants_owners'])) {
            foreach ($district['applicants_owners'] as $appl) {

                if ($appl->pdar_mobile == null) {
                    $mobile_tenant = "'NA'";
                } else {
                    $mobile_tenant = $appl->pdar_mobile;
                }

                $query = "SELECT pdar_id, pdar_name, pdar_father, $mobile_tenant as mobile FROM chitha_pattadar WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND trim(patta_no)=? AND patta_type_code=? AND pdar_id=?";

                $owner[] = $this->db->query($query, array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->lot_no, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->vill_townprt_code, $dags[0]->patta_no, $dags[0]->patta_type_code, $appl->pdar_id))->result();
            }
            $district['owner'] = $owner;
        }


        //var_dump($applicants_encroacher);die;
        $this->db = $this->load->database('db2', true);
        $district['district_all'] = $this->db->query("Select * from district_details")->result();

        $this->dbswitch();

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry) ? $geo_date_query->date_entry : '.....';
        $district['geo_date'] = $geo_date;

        $additional_property = $this->db->query("Select * from settlement_additional_property
        where (applid='$application_no' or applid = '$case_no')");
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

        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) {
            $district['guar_rel'] = $relation_executation->result();
        }

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO));
        if ($supportive_document_sql == true) {
            if ($supportive_document_sql->num_rows() > 0) {
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            } else {
                $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }
        }

        ///aadhar photo
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
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file 3!");
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
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file 4!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $district['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                endif;
            endif;
        endforeach;


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

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
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


        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $district['_view'] = 'SettlementView/SettlementTenantView';
            $this->load->view('layouts/main', $district);
        }

        //*************if request method is a post then insert data  */
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $application_no = trim($this->input->post('application_no'));

            // var_dump($application_no);
            // die;

            $distCode = trim($this->input->post('dist_code'));

            if($distCode == NULL)
            {
                redirect(base_url(). 'index.php/SettlementTenant/settlementTenantRegistration');
            }
            if($application_no == NULL)
            {
                redirect(base_url(). 'index.php/SettlementTenant/settlementTenantRegistration');
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            foreach($applicants_buyers as $appEligibility)
            {
                $this->form_validation->set_rules('applicant_eligibility'.$appEligibility->id, 'Applicant eligibility', 'trim|required|is_natural');
            }

            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                {

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_TENANT_ID);

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

                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', '');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', '');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', '');
                $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', '');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', '');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', '');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', '');
                $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', '');

                foreach ($district['applicants_owners'] as $owners) {

                    $this->form_validation->set_rules('owners_in_place' . $owners->id, 'Owners in Place', '');
                }
            }

            //****checking if validation is required */
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
                //******Geo tag validation */
                $geo_tag_dags = array();
                foreach($district['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;

                    //******NCBTAD check  */
                    $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($geo_tag->dist_code, $geo_tag->subdiv_code, $geo_tag->cir_code, $geo_tag->mouza_pargona_code, $geo_tag->lot_no, $geo_tag->vill_townprt_code, $geo_tag->dag_no);

                    if($ncBtadCheck > 0)
                    {
                        //*******throw error for NCBTAD */
                        log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                        $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";

                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($district['dags']);

                if((int)$get_tag_dag_count != (int)$total_dag_count)
                {
                    if(GEO_TAG_ACTIVE_STATUS == 1)
                    {
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
                $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
                // $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
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
                $this->form_validation->set_rules('rk_verified', 'RK Verified', 'trim|required');
                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('litigation', 'Proposed land is under litigation', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Under Tribal Belt/ Block', 'trim|required');
                $this->form_validation->set_rules('landslide', 'Area Under cover landslide prone', 'trim|required');
                $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
                $this->form_validation->set_rules('period_possession_lm', 'Period of Possession from Date', 'trim|required');
                $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', 'Is landless', 'trim|required');

                $this->form_validation->set_rules('khajana_receipt', 'Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant', 'trim|required');
                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                $this->form_validation->set_rules('total_due_amount', 'Calculate Premium', 'trim|required');

                //$this->form_validation->set_rules('aadhar_verified', 'Aadhaar verified', 'trim|required');
                $this->form_validation->set_rules('land_used_by_occupants', 'Purpose of the land used by the occupants', 'trim|required');
                $this->form_validation->set_rules('period_possession', 'Period of Possession from Date', 'trim|required');
                $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

                if (empty($_FILES['field_report']['name']))
                {
                    $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                }



                // new additional property calculation
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                $additional_properties = $this->db->query("Select * from settlement_additional_property where (applid='$application_no' or applid = '$case_no' )")->result();
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



                $appAreaMoreThanDagA      = 0;
                $lmEnterAreaMoreThanDagA  = 0;
                $appAreaTotalMoreThanMaxA = 0;

                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach($district['encroachers'] as $trace_dag){
                        if (empty($_FILES['trace_map_copy'.$trace_dag->id]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$trace_dag->id, 'Trace map document', 'required');
                        }
                    }

                    $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                    $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                    $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                    $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                    $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                    // $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 6400) + ($kathaValidationTotalLm * 320) + ($lessaValidationTotalLm * 20) + $gandaValidationTotalLm;

                    if($dagAreaLessaValidation < $agrAreaLessaValidation)
                    {
                        $appAreaMoreThanDagA = 1;
                    }
                    if(TENANT_MAX_BOTH_ADDITIONAL_AREA * 6400 < $agrAreaLessaValidation + $totalAdditionalProToLessa)
                    {
                        $appAreaTotalMoreThanMaxA = 1;
                    }
                    // if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
                    // {
                    //     $lmEnterAreaMoreThanDagA = 1;
                    // }
                }
                else
                {
                    foreach($district['encroachers'] as $trace_dag){
                        if (empty($_FILES['trace_map_copy'.$trace_dag->id]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$trace_dag->id, 'Trace map document', 'required');
                        }
                    }

                    $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                    // $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
                    // $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
                    // $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);

                    $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                    $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                    // $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 100) + ($kathaValidationTotalLm * 20) + $lessaValidationTotalLm;

                    if($dagAreaLessaValidation < $agrAreaLessaValidation)
                    {
                        $appAreaMoreThanDagA = 1;
                    }
                    if(TENANT_MAX_BOTH_ADDITIONAL_AREA * 100 < $agrAreaLessaValidation + $totalAdditionalProToLessa)
                    {
                        $appAreaTotalMoreThanMaxA = 1;
                    }

                    // if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
                    // {
                    //     $lmEnterAreaMoreThanDagA = 1;
                    // }
                }

                foreach ($district['applicants_owners'] as $owners) {

                    $this->form_validation->set_rules('owners_in_place' . $owners->id, 'Owners in Place', 'trim|required|min_length[1]');
                }


                if($agrAreaLessaValidation == 0)
                {
                    // $this->session->set_flashdata('error','Total applied area should not be Zero !');
                    // redirect(base_url(). 'index.php/SettlementTenant/settlementTenantRegistration?app='.$application_no);
                    $this->form_validation->set_rules('agrAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_agrAreaLessaValidation');
                }

                if($appAreaMoreThanDagA == 1)
                {
                    // $this->session->set_flashdata('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !');
                    // redirect(base_url(). 'index.php/SettlementTenant/settlementTenantRegistration?app='.$application_no);

                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                }
                if($appAreaTotalMoreThanMaxA == 1)
                {
                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area & additional area should not be more than 50 Bigha !', 'required|callback_appAreaMoreThanDagA');
                }

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

                //******compensation beneficiary validation******

                $beneUNTcheck = $this->db->query('SELECT owner_living_status FROM settlement_tenent_beneficiary WHERE case_no = ?', array($case_no));

                $untraceableCheck = 0;

                if($beneUNTcheck->num_rows() > 0)
                {
                    foreach($beneUNTcheck->result() as $untChk)
                    {
                        if(trim($untChk->owner_living_status) != 'UNT' && trim($untChk->owner_living_status) != 'CCA')
                        {
                            $untraceableCheck = 1;
                        }
                    }
                }

                $bene_inserted_count = $this->db->query("SELECT pdar_id FROM settlement_tenent_beneficiary WHERE case_no = ? GROUP BY pdar_id", array($case_no));

                $db_owner_count = count($applicants_owners);
                $bene_inserted_count = count($bene_inserted_count->result());

                if($db_owner_count != $bene_inserted_count)
                {
                    $this->form_validation->set_rules('beneficiary_err', 'Please enter all Beneficiary details !', 'required');
                }

                if($untraceableCheck == 1)
                {
                    $com_per_sql = $this->db->query("SELECT pdar_id FROM settlement_tenent_beneficiary WHERE case_no = ? GROUP BY pdar_id", array($case_no));

                    if($com_per_sql->num_rows() > 0)
                    {
                        $compensation_res = $com_per_sql->result();
                        $countInsertedBeneficiary = count($compensation_res);
                    }

                    if(!isset($countInsertedBeneficiary))
                    {
                        $countInsertedBeneficiary = 0;
                    }
                    $countApplicantOwner = count($applicants_owners);

                    $comp_percent = $this->db->query("SELECT SUM(bene_percentage) as total_percentage FROM settlement_tenent_beneficiary WHERE case_no = ?", array($case_no));

                    $total_bene_percentage = 0;
                    if($comp_percent->num_rows() > 0)
                    {
                        $total_bene_percentage = $comp_percent->row()->total_percentage;
                    }

                    if($countApplicantOwner > $countInsertedBeneficiary)
                    {
                        $this->form_validation->set_rules('beneficiary_err', 'Please enter all Beneficiary details !', 'required');
                    }
                    else if($total_bene_percentage != 100)
                    {
                        $this->form_validation->set_rules('beneficiary_err', 'Total Beneficiary percentage should be exactly 100!', 'required');
                    }
                }

                $this->form_validation->set_rules('riotee_name', 'Riotee Name', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('riotee_guardian', 'Riotee Guardian', 'trim|required|min_length[1]|max_length[70]');
                $this->form_validation->set_rules('khatian_no', 'Riotee Id', 'trim|required|is_natural');

                if ($applicants_riotee_nok == true) {
                    foreach ($applicants_riotee_nok as $riotee_nok) {
                        $this->form_validation->set_rules('riotee_nok_name'.$riotee_nok->id, 'Riotee NOK Name', 'trim|required|min_length[3]|max_length[70]');
                        $this->form_validation->set_rules('riotee_nok_khatian_no'.$riotee_nok->id, 'Riotee NOK Id', 'trim|required|is_natural');
                        $this->form_validation->set_rules('riotee_nok_guardian'.$riotee_nok->id, 'Riotee NOK Guardian', 'trim|required|min_length[3]|max_length[70]');
                        $this->form_validation->set_rules('riotee_nok_relation'.$riotee_nok->id, 'Riotee NOK Id', 'trim|required|min_length[1]|max_length[6]');
                    }
                }
            }


            if ($this->form_validation->run() == FALSE)
            {

                if(isset($fileCount)){
                    $district['fileCount'] = $fileCount;
                }
                $district['all_errors'] = validation_errors();
                $district['err_return'] = true;
                $district['_view'] = 'SettlementView/SettlementTenantView';
                $this->load->view('layouts/main',$district);
            }
            else
            {
                $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='LM'";
                $dataFound=$this->db->query($sqlCheckExist)->row();
                //echo json_encode($dataFound);

                if($dataFound->c >0){

                    $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded to circle office. case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $this->db->trans_begin();


                $sk_code = null;
                $co_code = null;
                if(trim($district['sk_availability']) == 'y')
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

                //****update in settlement_applicant for applicant eligibility */
                foreach($applicants_buyers as $updateApp)
                {
                    $updateApplicantArr = [
                        'applicant_eligibility' => $this->input->post('applicant_eligibility'.$updateApp->id)
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('id', $updateApp->id);
                    $this->db->update('settlement_applicant', $updateApplicantArr);

                    if($this->db->affected_rows() == 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR1509: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROR1509: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
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
                    'co_code'         => $co_code
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

                // UPDATING Geo Tag Photo case number in supportive document
                if(isset($district['geo_tag_doc'])){
                    foreach($district['geo_tag_doc'] as $geo_tag_loop){
                        $geo_tag_array = array(
                            'case_no' => $case_no
                        );
                        $this->db->where('applid', $geo_tag_loop->applid);
                        $this->db->where('dag_no', $geo_tag_loop->dag_no);
                        $this->db->where('file_name', GEO_TAG_PHOTO);
                        $this->db->update('supportive_document', $geo_tag_array);

                        if($this->db->affected_rows() == 0 ){
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
                                    'mut_type'   => SETTLEMENT_TENANT_ID,
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

                    if ($district['applicants_owners'] == true) {
                        foreach ($district['applicants_owners'] as $owners) {
                            $owners_update = array(
                                'inplace_alongwith' => $this->input->post('owners_in_place' . $owners->id),
                            );

                            $this->db->where('id', $owners->id);
                            $this->db->update('settlement_applicant', $owners_update);
                            //   echo $this->db->last_query();

                            if ($this->db->affected_rows() == 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#SETUP00034: Updation failed in settlement_applicant Dharitree Case No ' . $application_no);
                                $data = array(
                                    'error' => "#SETUP00034: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }

                    //*****updating riotee is changed */
                    if ($applicants_encroacher == true) {
                        foreach ($applicants_encroacher as $encroacher) {
                            $encroacher_update = array(
                                'user_code' => $this->session->userdata('user_code'),
                                'date_update' => date('Y-m-d G:i:s'),
                                'khatian_no' => $this->input->post('khatian_no'),
                                'pdar_name' => $this->input->post('riotee_name'),
                                'pdar_guardian' => $this->input->post('riotee_guardian'),
                            );

                            $this->db->where('id', $encroacher->id);
                            $this->db->update('settlement_applicant', $encroacher_update);

                            if ($this->db->affected_rows() == 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#SETUP00053434: Updation failed in settlement_applicant Dharitree Case No ' . $application_no);
                                $data = array(
                                    'error' => "#SETUP00053434: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }

                    $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
                    $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']['dist_code'],$district['app']['subdiv_code'],$district['app']['cir_code'],$district['app']['mouza_pargona_code'],$district['app']['lot_no'],$district['app']['vill_townprt_code'],$this->input->post('dag_no'));


                    ////settlement_dag_details insert start

                    $landmark_east = $this->input->post('landmark_east');
                    $landmark_west = $this->input->post('landmark_west');
                    $landmark_north = $this->input->post('landmark_north');
                    $landmark_south = $this->input->post('landmark_south');
                    $landmark = [
                        'east' => $landmark_east,
                        'west' => $landmark_west,
                        'north' => $landmark_north,
                        'south' => $landmark_south,
                    ];

                    $fmd = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d'),
                        'case_no' => $case_no,
                        'petition_no' => $petition_no,
                        'year_no' => date('Y'),
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'dag_area_b' => $this->input->post('dag_area_b'),
                        'dag_area_k' => $this->input->post('dag_area_k'),
                        'dag_area_lc' => $this->input->post('dag_area_lc'),
                        'dag_area_g' => $this->input->post('dag_area_g'),
                        'dag_area_kr' => $this->input->post('dag_area_kr'),
                        's_dag_area_b' => $this->input->post('s_dag_area_b'),
                        's_dag_area_k' => $this->input->post('s_dag_area_k'),
                        's_dag_area_lc' => $this->input->post('s_dag_area_lc'),
                        's_dag_area_g' => $this->input->post('s_dag_area_g'),
                        's_dag_area_kr' => $this->input->post('s_dag_area_kr'),
                        // 'is_urban' => trim($this->input->post('is_urban')),
                        'revenue' => 0,
                        'new_land_class_code'=>$district['pattaNo']->land_class_code,
                        'landmark'   => json_encode($landmark),
                    );

                    $this->db->where('case_no', $case_no);
                    $this->db->where('dag_no', $this->input->post('dag_no'));
                    $this->db->update('settlement_dag_details', $fmd);

                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0002: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                    ////settlement Tenant LM Report insert start
                    ////////////////////file///////////////////////////

                    // For uploading dag wise trace_map_copy
                    foreach($district['encroachers'] as $dags_doc){
                        $timestamp = date('mdYhis', time()).uniqid();

                        // Trace Map copy upload
                        $config['file_name']            = 'trace_map_copy'.$timestamp;
                        $config['upload_path']          = UPLOAD_DIR;
                        $config['allowed_types']        = 'pdf|jpg|png';
                        $config['max_size']             = 2000;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            echo json_encode($error);
                            return false;
                        }
                        else
                        {
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
                                'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                            );

                            $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                            if($insert_supportive_doc != 1){
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                                $json = [
                                    'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                                ];
                                echo json_encode($json);
                                return false;
                            }
                        }
                    }

                    $timestamp = date('mdYhis', time()).uniqid();
                    // For uploading field report
                    $config2['file_name']            = 'field_report'.$timestamp;
                    $config2['upload_path']          = UPLOAD_DIR;
                    $config2['allowed_types']        = 'pdf|jpg|png';
                    $config2['max_size']             = 2000;

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

                    ///////////////////////////////////////////////
                    $comment = addslashes($this->input->post('lm_note'));
                    $lm_remark_text = $this->input->post('lm_remark_text');

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

                    //*********if LM if case of case rejected the rejected remarks */

                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_TENANT_ID);

                    $lmnote = array(
                        'user_code' => $this->session->userdata('user_code'),
                        'chitha_verified' => $this->input->post('chitha_verified'),
                        'possession_verification' => $this->input->post('possession_verification'),
                        'period_possession' => $this->input->post('period_possession_lm'),
                        'nature_possession' => $this->input->post('nature_possession'),
                        'is_landless' => $this->input->post('is_landless'),
                        'land_falls' => $this->input->post('land_falls'),
                        'falls_und_gmc' => $this->input->post('falls_und_gmc'),
                        'trace_map_copy' => 'NA',
                        'chitha_copy' => 'NA',
                        'lm_note' => $comment,
                        'lm_remark_text' => $lm_remark_text,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'case_no' => $case_no,
                        'status' => 'W',
                        'land_used_by_occupants' => $this->input->post('land_used_by_occupants'),
                        'e_khajana_receipt_check' => $this->input->post('khajana_receipt'),
                        'rk_verified' => $this->input->post('rk_verified'),
                        'protected_class_lm' => $protected_class_lm,
                        'erosion' => $this->input->post('erosion'),
                        'litigation' => $this->input->post('litigation'),
                        'landslide' => $this->input->post('landslide'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );
                    $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
                    if ($insLmnote != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0007: Insertion failed in settlement_ap_lmnote RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0007: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //// premium insert

                    /// premium verify start ************
                    $total_dag_lessa =$this->input->post('total_dag_lessa');
                    $total_app_lessa =$this->input->post('total_s_lessa');
                    $zonal_bigha =$this->input->post('dag_revenue');
                    $dag_per_lessa_revenue = ($zonal_bigha / $total_dag_lessa);
                    $final_amount = ($total_app_lessa * $dag_per_lessa_revenue);
                    $sumMbAmount= ceil($final_amount * 50);
                    if($sumMbAmount != $this->input->post('total_due_amount')){
                        // var_dump("Amount mismatch!!!"); die;
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0001: Settlement Application not submitted case no # $application_no");
                        redirect(base_url() . "index.php/home");
                    }
                    /// premium verify end ************

                    $premdata=array(
                        'case_no'=>$case_no,
                        'user_code'=>$this->session->userdata('user_code'),
                        // 'uuid'=>$premdags->uuid,
                        'dag_no'=>$this->input->post('dag_no'),
                        'zonal_valuation'=>$this->input->post('dag_revenue'),
                        'final_amount'=>$this->input->post('total_due_amount'),
                        'due_amount'=>$this->input->post('total_due_amount'),
                        'total_lessa'=>$this->input->post('total_s_lessa'),
                        'is_final'=>1,
                        'date_entry'=>date('Y-m-d h:i:s'),

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
                }


                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/

                    $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
                        SETTLEMENT_TENANT_ID,
                        $case_no,
                        $application_no,
                        $district['rejected_list']
                    );
                }

                //// premium insert end


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
                    'note_on_order' => $lm_remark_text,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'Forwarded to CO',
                    'note_type' => $this->input->post('lm_note'),
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

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

                ////settlement Tenant LM Report insert end
                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk = 'Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    // var_dump($rtps_status); die();
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } 
                    else 
                    {
                        $this->db->trans_commit();

                        $checkIfCommited = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

                        if($checkIfCommited->num_rows() <= 0)
                        {
                            $rmk = 'Pending at LM';
                            $status = 'S';
                            $task = 'LM';
                            $pen = 'LM';
                            $case = $case_no;
                            $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                            $rtps_status = json_decode($rtps_status);
                            // var_dump($rtps_status); die();
                            if (trim($rtps_status) !="y") 
                            {
                                $this->session->set_flashdata('message', "Error #ERRAPP2047: Settlement Application not submitted case no # $case_no");
                                redirect(base_url() . "index.php/home");
                            }
                            else
                            {
                                $this->session->set_flashdata('message', "Something went wrong! Application couldn't be registered... " .$case_no);
                                redirect(base_url() . "index.php/home");
                            } 
                        }
                        else
                        {
                            if(isset($checkIfCommited->row()->status))
                            {
                                if(trim($checkIfCommited->row()->status) == 'Z')
                                {
                                    $rmk = 'Pending at LM';
                                    $status = 'S';
                                    $task = 'LM';
                                    $pen = 'LM';
                                    $case = $case_no;
                                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                                    $rtps_status = json_decode($rtps_status);
                                    // var_dump($rtps_status); die();
                                    if (trim($rtps_status) !="y") 
                                    {
                                        $this->session->set_flashdata('message', "Error #ERRAPP2073: Settlement Application not submitted case no # $case_no");
                                        redirect(base_url() . "index.php/home");
                                    }
                                    else
                                    {
                                        $this->session->set_flashdata('message', "Something went wrong! Application couldn't be registered... " .$case_no);
                                        redirect(base_url() . "index.php/home");
                                    }
                                }
                            }
                            else
                            {
                                $rmk = 'Pending at LM';
                                $status = 'S';
                                $task = 'LM';
                                $pen = 'LM';
                                $case = $case_no;
                                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                                $rtps_status = json_decode($rtps_status);
                                // var_dump($rtps_status); die();
                                if (trim($rtps_status) !="y") 
                                {
                                    $this->session->set_flashdata('message', "Error #ERRAPP002096: Settlement Application not submitted case no # $case_no");
                                    redirect(base_url() . "index.php/home");
                                }
                                else
                                {
                                    $this->session->set_flashdata('message', "Something went wrong! Application couldn't be registered... " .$case_no);
                                    redirect(base_url() . "index.php/home");
                                }
                            }
                           
                        }
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to " .$pending_officer. " With Case No # $case_no");
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

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
        $district['application_no'] = $application_no;

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

        //get case no from basundhar_application
        $case_no = $this->db->select()
            ->where('basundhara', $application_no)
            ->get('basundhar_application')->row()->dharitree;

        //get petition no from basundhar_application
        $petition_no = $this->db->select()
            ->where('applid', $application_no)
            ->get('settlement_basic')->row()->petition_no;

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

        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['nominee']=$nominee;

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
        $district['nextKin'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['bhumi'] = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $district['aadhar'] = $this->SettlementKhasModel->getMainApplicant($case_no);

        $district['basic'] = $basic;
        $district['applicants_buyers'] = $applicants_buyers;
        $district['applicants_owners'] = $applicants_owners;
        $district['applicants_encroacher'] = $applicants_encroacher;
        $district['applicants_riotee_nok'] = $applicants_riotee_nok;

        $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);
        $district['dags'] = $dags;
        $district['area_details'] = $dags;
        $district['lmnotes'] = $lmnotes;
        $district['proceedings'] = $proceedings;

        $district['dhardocuments'] = $dhardocuments;
        $district['case_no'] = $case_no;


        $district['co_name'] = $this->SettlementCommonModel->getCoName($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code);
        $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $revenue = $this->db->query("SELECT dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no))->row();
        $district['revenue'] = $revenue;


        $getChithaTenant = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=?
        AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=?
        AND khatian_no=? AND tenant_id=?", array($district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->lot_no, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no, $applicants_encroacher[0]->riotee_id));

        $district['chitha_tenant'] = $getChithaTenant->row();

        $district['riotee_list'] = $this->SettlementTenantModel->getRioteeList($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no);

        if (!empty($district['applicants_owners'])) {
            foreach ($district['applicants_owners'] as $appl) {

                if ($appl->pdar_mobile == null) {
                    $mobile_tenant = "'NA'";
                } else {
                    $mobile_tenant = $appl->pdar_mobile;
                }

                $query = "SELECT pdar_id, pdar_name, pdar_father, $mobile_tenant as mobile FROM chitha_pattadar WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND trim(patta_no)=? AND patta_type_code=? AND pdar_id=?";

                $owner[] = $this->db->query($query, array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->lot_no, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->vill_townprt_code, $dags[0]->patta_no, $dags[0]->patta_type_code, $appl->pdar_id))->result();
            }
            $district['owner'] = $owner;
        }


        //var_dump($applicants_encroacher);die;
        $this->db = $this->load->database('db2', true);
        $district['district_all'] = $this->db->query("Select * from district_details")->result();

        $this->dbswitch();

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry) ? $geo_date_query->date_entry : '.....';
        $district['geo_date'] = $geo_date;

        $additional_property = $this->db->query("Select * from settlement_additional_property
        where (applid='$application_no' or applid='$case_no')");
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

        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) {
            $district['guar_rel'] = $relation_executation->result();
        }

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO));
        if ($supportive_document_sql == true) {
            if ($supportive_document_sql->num_rows() > 0) {
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            } else {
                $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }
        }

        ///aadhar photo
        if (isset($applicants_buyers)) {
            if ($applicants_buyers) {
                foreach ($applicants_buyers as $adhar_photo) {
                    if ($adhar_photo->is_applicant == 1) {
                        if (trim($adhar_photo->identity_type) == 'AADHAAR') {
                            $adhar_photo_link = $adhar_photo->identity_doc_link;

                            if(!file_exists($adhar_photo_link))
                            {
                                //****Directory Change */
                                $parts = explode("uploads".UPLOAD_SEPARATOR, $adhar_photo_link, 2);
                                if (count($parts) > 1)
                                {
                                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                                }
                                else
                                {
                                    $path = $adhar_photo_link;
                                }

                                if(!file_exists($path))
                                {
                                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                                }
                                else
                                {
                                    $path = $path;
                                }
                                
                                
                                if(!file_exists($path))
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
                                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file 5!");
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
                                else
                                {
                                    $adhar_photo_link = $path;
                                }
                            }

                            $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file 1!");
                            $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                            fclose($open_adhar_file);
                            // decoding the base64 encoding file variable

                            $district['base64_decoded_adhar_file'] = "<img src = data:" . $this->decodeBase64($read_adhar_file) . ";base64," . $read_adhar_file . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        }
                    }
                }
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

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
        if($rejected_data == 'n')
        {
            $district['rejected_list'] = false;
        }
        else
        {
            $district['rejected_list'] = $rejected_data;
        }

        //get data from settlement_ap_lmnote
        $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where case_no='$case_no'")->row()->is_landless;
        $district['apLmNote'] = $apLmNote;

        $district['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $district['rejected_list']);


        $district['enc_case']= null;
        if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
        {
            // var_dump($application_no.','.$basic['dist_code'].','.$basic['service_code']);
            $this->load->model('ApplicantChangeModel');
            $district['deceased'] = $this->ApplicantChangeModel->getDeceasedData($basic['applid']);
            $district['enc_case'] = $this->ApplicantChangeModel->ekycVerify($basic['case_no'], $basic['dist_code'], $basic['service_code']);
        }

        $district['citizen_nrc_doc'] = null;
        $district['lm_nrc_doc'] = null;
        $district['rejected_cat'] = 0;
        $district['status_not_in_d'] = null;
        if(NRC_FILE_UPLOAD_ENABLED == 1) {
            $this->load->model('NrcDocModel');
            $citizen_nrc_doc = json_decode($this->NrcDocModel->getNrcDocsUploadedByCitizen($basic['applid']));
            $district['citizen_nrc_doc'] = $citizen_nrc_doc;
            $district['lm_nrc_doc'] = $this->NrcDocModel->getNrcDocsUploadedByLm($basic['case_no']);
            $district['rejected_cat'] = $this->NrcDocModel->getRejectedCategoryForNrcUp($basic['case_no']);
            $district['status_not_in_d'] = $this->NrcDocModel->getFromBasicNotD($basic['case_no']);
        }


        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $district['_view'] = 'SettlementView/Lm/Tenant/SettlementTenantView';
            $this->load->view('layouts/main', $district);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $is_prem_update = $this->input->post('prem_update');
            $this->load->library('form_validation');
            // $application_no = $this->input->post('application_no');
            // $case_no = $application_no;
            $distCode = trim($this->input->post('dist_code'));

            if($distCode == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementKhasLandLm?service='.SETTLEMENT_TENANT_ID);
            }
            if($case_no == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementKhasLandLm?service='.SETTLEMENT_TENANT_ID);
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            foreach($applicants_buyers as $appEligibility)
            {
                $this->form_validation->set_rules('applicant_eligibility'.$appEligibility->id, 'Applicant eligibility', 'trim|required|is_natural');
            }
            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                {

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_TENANT_ID);

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

                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', '');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', '');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', '');
                $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', '');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', '');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', '');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', '');
                $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', '');

                foreach ($district['applicants_owners'] as $owners) {

                    $this->form_validation->set_rules('owners_in_place' . $owners->id, 'Owners in Place', '');
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
                foreach($district['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;

                    //******NCBTAD check  */
                    $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($geo_tag->dist_code, $geo_tag->subdiv_code, $geo_tag->cir_code, $geo_tag->mouza_pargona_code, $geo_tag->lot_no, $geo_tag->vill_townprt_code, $geo_tag->dag_no);

                    if($ncBtadCheck > 0)
                    {
                        //*******throw error for NCBTAD */
                        log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                        $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";

                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($district['dags']);

                if((int)$get_tag_dag_count != (int)$total_dag_count)
                {
                    if(GEO_TAG_ACTIVE_STATUS == 1)
                    {
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
                // $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
                // $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
                // $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
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
                $this->form_validation->set_rules('rk_verified', 'RK Verified', 'trim|required');
                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('litigation', 'Proposed land is under litigation', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Under Tribal Belt/ Block', 'trim|required');
                $this->form_validation->set_rules('landslide', 'Area Under cover landslide prone', 'trim|required');
                $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
                $this->form_validation->set_rules('period_possession_lm', 'Period of Possession From Date', 'trim|required');
                $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', 'Is landless', 'trim|required');

                $this->form_validation->set_rules('khajana_receipt', 'Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant', 'trim|required');
                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                // $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                // $this->form_validation->set_rules('total_due_amount', 'Calculate Premium', 'trim|required');

                $this->form_validation->set_rules('land_used_by_occupants', 'Purpose of the land used by the occupants', 'trim|required');
                $this->form_validation->set_rules('period_possession', 'Period of Possession from Date', 'trim|required');
                $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
                // if (empty($_FILES['field_report']['name']))
                // {
                //     $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                // }

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

                $this->form_validation->set_rules('prem_update', 'Do you want to chnage the premium', 'trim|required');
                // $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');

                if($is_prem_update=='YES'){
                    // $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                    $this->form_validation->set_rules('total_due_amount', 'Premium Amount', 'trim|required');
                }

                $appAreaMoreThanDagA = 0;
                $lmEnterAreaMoreThanDagA = 0;

                // for barak valley
                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                    $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                    $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                    $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                    $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                    // $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 6400) + ($kathaValidationTotalLm * 320) + ($lessaValidationTotalLm * 20) + $gandaValidationTotalLm;

                    if($dagAreaLessaValidation < $agrAreaLessaValidation)
                    {
                        $appAreaMoreThanDagA = 1;
                    }
                    // if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
                    // {
                    //     $lmEnterAreaMoreThanDagA = 1;
                    // }
                }
                else
                {
                    $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                    // $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
                    // $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
                    // $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);

                    $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                    $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                    // $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 100) + ($kathaValidationTotalLm * 20) + $lessaValidationTotalLm;

                    if($dagAreaLessaValidation < $agrAreaLessaValidation)
                    {
                        $appAreaMoreThanDagA = 1;
                    }
                    // if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
                    // {
                    //     $lmEnterAreaMoreThanDagA = 1;
                    // }
                }

                // new additional property calculation
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa  = 0;
                $appAreaTotalMoreThanMaxA   = 0;
                $additional_properties = $this->db->query("Select * from settlement_additional_property where (applid='$application_no' or applid='$case_no')")->result();

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

                    if(TENANT_MAX_BOTH_ADDITIONAL_AREA * 6400 < $agrAreaLessaValidation + $totalAdditionalProToLessa)
                    {
                        $appAreaTotalMoreThanMaxA = 1;
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

                    if(TENANT_MAX_BOTH_ADDITIONAL_AREA * 100 < $agrAreaLessaValidation + $totalAdditionalProToLessa)
                    {
                        $appAreaTotalMoreThanMaxA = 1;
                    }
                }

                foreach ($district['applicants_owners'] as $owners) {
                    $this->form_validation->set_rules('owners_in_place' . $owners->id, 'Owners in Place', 'trim|required|min_length[1]');
                }

                if($agrAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('agrAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_agrAreaLessaValidation');
                }

                if($appAreaMoreThanDagA == 1)
                {
                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                }
                if($appAreaTotalMoreThanMaxA == 1)
                {
                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area & additional area should not be more than 50 Bigha !', 'required|callback_appAreaMoreThanDagA');
                }

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




                //******compensation beneficiary validation******

                $beneUNTcheck = $this->db->query('SELECT owner_living_status FROM settlement_tenent_beneficiary WHERE case_no = ?', array($case_no));

                $untraceableCheck = 0;

                if($beneUNTcheck->num_rows() > 0)
                {
                    foreach($beneUNTcheck->result() as $untChk)
                    {
                        if(trim($untChk->owner_living_status) != 'UNT' && trim($untChk->owner_living_status) != 'CCA')
                        {
                            $untraceableCheck = 1;
                        }
                    }
                }

                $bene_inserted_count = $this->db->query("SELECT pdar_id FROM settlement_tenent_beneficiary WHERE case_no = ? GROUP BY pdar_id", array($case_no));

                $db_owner_count = count($applicants_owners);
                $bene_inserted_count = count($bene_inserted_count->result());

                if($db_owner_count != $bene_inserted_count)
                {
                    $this->form_validation->set_rules('beneficiary_err', 'Please enter all Beneficiary details !', 'required');
                }

                if($untraceableCheck == 1)
                {
                    $com_per_sql = $this->db->query("SELECT pdar_id FROM settlement_tenent_beneficiary WHERE case_no = ? GROUP BY pdar_id", array($case_no));

                    if($com_per_sql->num_rows() > 0)
                    {
                        $compensation_res = $com_per_sql->result();
                        $countInsertedBeneficiary = count($compensation_res);
                    }

                    if(!isset($countInsertedBeneficiary))
                    {
                        $countInsertedBeneficiary = 0;
                    }
                    $countApplicantOwner = count($applicants_owners);

                    $comp_percent = $this->db->query("SELECT SUM(bene_percentage) as total_percentage FROM settlement_tenent_beneficiary WHERE case_no = ?", array($case_no));

                    $total_bene_percentage = 0;
                    if($comp_percent->num_rows() > 0)
                    {
                        $total_bene_percentage = $comp_percent->row()->total_percentage;
                    }

                    if($countApplicantOwner > $countInsertedBeneficiary)
                    {
                        $this->form_validation->set_rules('beneficiary_err', 'Please enter all Beneficiary details !', 'required');
                    }
                    else if($total_bene_percentage != 100)
                    {
                        $this->form_validation->set_rules('beneficiary_err', 'Total Beneficiary percentage should be exactly 100!', 'required');
                    }
                }

                $this->form_validation->set_rules('riotee_name', 'Riotee Name', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('riotee_guardian', 'Riotee Guardian', 'trim|required|min_length[1]|max_length[70]');
                $this->form_validation->set_rules('khatian_no', 'Riotee Id', 'trim|required|is_natural');


                if ($applicants_riotee_nok == true) {
                    foreach ($applicants_riotee_nok as $riotee_nok) {
                        $this->form_validation->set_rules('riotee_nok_name' . $riotee_nok->id, 'Riotee NOK Name', 'trim|required|min_length[3]|max_length[70]');
                        $this->form_validation->set_rules('riotee_nok_khatian_no' . $riotee_nok->id, 'Riotee NOK Id', 'trim|required|is_natural');
                        $this->form_validation->set_rules('riotee_nok_guardian' . $riotee_nok->id, 'Riotee NOK Guardian', 'trim|required|min_length[3]|max_length[70]');
                        $this->form_validation->set_rules('riotee_nok_relation' . $riotee_nok->id, 'Riotee NOK Id', 'trim|required|min_length[1]|max_length[6]');
                    }
                }


            }

            if ($this->form_validation->run() == FALSE)
            {
                if(isset($fileCount)){
                    $district['fileCount'] = $fileCount;
                }
                $district['all_errors'] = validation_errors();
                $district['err_return'] = true;
                $district['_view'] = 'SettlementView/Lm/Tenant/SettlementTenantView';
                $this->load->view('layouts/main', $district);
            }
            else
            {

                // $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='LM'";
                // $dataFound=$this->db->query($sqlCheckExist)->row();
                // // echo json_encode($dataFound);
                // if($dataFound->c >0){

                //     $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded to circle office. case no : ".$application_no);
                //     redirect(base_url() . "index.php/home");
                //     return false;
                // }

                $this->db->trans_begin();

                $sk_code = null;
                $co_code = null;
                if(trim($district['sk_availability']) == 'y')
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

                //*****json backup insertion */
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

                foreach($applicants_buyers as $updateApp)
                {
                    $updateApplicantArr = [
                        'applicant_eligibility' => $this->input->post('applicant_eligibility'.$updateApp->id)
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('id', $updateApp->id);
                    $this->db->update('settlement_applicant', $updateApplicantArr);

                    if($this->db->affected_rows() == 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR1509: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROR1509: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //*******settlement basic update */
                $basic = array(
                    'date_update' => date('Y-m-d G:i:s'),
                    'status' => 'X',
                    'user_code' => $this->session->userdata('user_code'),
                    'lm_code' => $this->session->userdata('user_code'),
                    //'period_possession' => $this->input->post('period_possession'),
                    'occupation_applicant' => $this->input->post('occupation_applicant'),
                    'from_office' => 'LM',
                    'pending_officer' => $pending_officer,
                    'pending_office' => $pending_officer
                    /////////
                );

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basic);
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No ' . $application_no);
                    $data = array(
                        'error' => "#SETUP0001: Registration of Settlement basic failed for case no : " . $application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
                //*******settlement basic update end */
                if($validation_bypass == 0)
                {
                    //*****json backup insertion end */



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
                        $service_code = SETTLEMENT_TENANT_ID;

                        $nrcFilesUploadStatus = $this->SettlementNRCFileUploadModel->uploadNrcFiles($case_no,$nrcDesc,$nrcFileArray,$nrcFileName,$service_code);
                        if($nrcFilesUploadStatus['responseType'] == 1)
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "#ERRSOTNRCDOC0001: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }

                    }
                    //end=====================

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
                                    'mut_type'   => SETTLEMENT_TENANT_ID,
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

                    //****update settlement_applicant */
                    //*****updating riotee is changed */
                    if ($applicants_encroacher == true) {
                        foreach ($applicants_encroacher as $encroacher) {
                            $encroacher_update = array(
                                'user_code' => $this->session->userdata('user_code'),
                                'date_update' => date('Y-m-d G:i:s'),
                                'khatian_no' => $this->input->post('khatian_no'),
                                'pdar_name' => $this->input->post('riotee_name'),
                                'pdar_guardian' => $this->input->post('riotee_guardian'),
                            );

                            $this->db->where('id', $encroacher->id);
                            $this->db->update('settlement_applicant', $encroacher_update);

                            if ($this->db->affected_rows() == 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#SETUP00053434: Updation failed in settlement_applicant Dharitree Case No ' . $application_no);
                                $data = array(
                                    'error' => "#SETUP00053434: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }

                    //********updating inplace_alongwith for owners */
                    if ($district['applicants_owners'] == true) {
                        foreach ($district['applicants_owners'] as $owners) {
                            $owners_update = array(
                                'inplace_alongwith' => $this->input->post('owners_in_place' . $owners->id),
                            );

                            $this->db->where('id', $owners->id);
                            $this->db->update('settlement_applicant', $owners_update);
                            //   echo $this->db->last_query();

                            if ($this->db->affected_rows() == 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#SETUP00034: Updation failed in settlement_applicant Dharitree Case No ' . $application_no);
                                $data = array(
                                    'error' => "#SETUP00034: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }

                    //****update settlement_applicant end */

                    $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
                    $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']['dist_code'],$district['app']['subdiv_code'],$district['app']['cir_code'],$district['app']['mouza_pargona_code'],$district['app']['lot_no'],$district['app']['vill_townprt_code'],$this->input->post('dag_no'));


                    //*********settlement_dag_details update start*****
                    $landmark_east = $this->input->post('landmark_east');
                    $landmark_west = $this->input->post('landmark_west');
                    $landmark_north = $this->input->post('landmark_north');
                    $landmark_south = $this->input->post('landmark_south');
                    $landmark = [
                        'east' => $landmark_east,
                        'west' => $landmark_west,
                        'north' => $landmark_north,
                        'south' => $landmark_south,
                    ];

                    $fmd = array(
                        'user_code' => $this->session->userdata('user_code'),
                        'date_update' => date('Y-m-d'),
                        'dag_area_b' => $this->input->post('dag_area_b'),
                        'dag_area_k' => $this->input->post('dag_area_k'),
                        'dag_area_lc' => $this->input->post('dag_area_lc'),
                        'dag_area_g' => $this->input->post('dag_area_g'),
                        'dag_area_kr' => $this->input->post('dag_area_kr'),
                        's_dag_area_b' => $this->input->post('s_dag_area_b'),
                        's_dag_area_k' => $this->input->post('s_dag_area_k'),
                        's_dag_area_lc' => $this->input->post('s_dag_area_lc'),
                        's_dag_area_g' => $this->input->post('s_dag_area_g'),
                        's_dag_area_kr' => $this->input->post('s_dag_area_kr'),
                        'landmark'   => json_encode($landmark),
                    );

                    $this->db->where('case_no', $case_no);
                    $this->db->where('dag_no', $this->input->post('dag_no'));
                    $this->db->update('settlement_dag_details', $fmd);

                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0002: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
                    //*********settlement_dag_details update end*****

                    //*****File update starts */
                    if(isset($_FILES))
                    {
                        foreach ($_FILES as $file => $key)
                        {
                            if ($key['tmp_name'] == false) {
                                continue;
                            }

                            $doc_dag_no =  strstr($file,  '_', true);
                            // $traceMapDag = (int)str_replace("DOCMAIN", "", $doc_dag_no);

                            $doc_id = substr($file, strpos($file, "_") + 1);

                            preg_match('/DOCMAIN/', $file, $match);

                            if($match){
                                if ($match[0] == 'DOCMAIN') {
                                    $timestamp = date('mdYhis', time()).uniqid();

                                    $config['file_name']            = 'updated_file'.$timestamp;
                                    $config['upload_path']          = UPLOAD_DIR;
                                    $config['allowed_types']        = UPLOAD_ALLOW_TYPE;
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
                                            log_message('error', '#SETUP6845545: Updation failed in supprotive_documents Dharitree Case No ' . $application_no);
                                            $data = array(
                                                'error' => "#SETUP6845545: Failed to upload documents, Please compress the file and reupload. case no : " . $application_no,
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
                    //*****File update ends */

                    //*****Lmnote update starts */
                    $comment = addslashes($this->input->post('lm_note'));
                    $lm_remark_text = $this->input->post('lm_remark_text');

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

                    //*********if LM if case of case rejected the rejected remarks */

                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_TENANT_ID);

                    $lmnote = array(
                        'user_code' => $this->session->userdata('user_code'),
                        'chitha_verified' => $this->input->post('chitha_verified'),
                        'possession_verification' => $this->input->post('possession_verification'),
                        'period_possession' => $this->input->post('period_possession_lm'),
                        'nature_possession' => $this->input->post('nature_possession'),
                        'is_landless' => $this->input->post('is_landless'),
                        'land_falls' => $this->input->post('land_falls'),
                        'falls_und_gmc' => $this->input->post('falls_und_gmc'),
                        'trace_map_copy' => 'NA',
                        'chitha_copy' => 'NA',
                        'lm_note' => $comment,
                        'lm_remark_text' => $lm_remark_text,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'case_no' => $case_no,
                        'status' => 'W',
                        'land_used_by_occupants' => $this->input->post('land_used_by_occupants'),
                        'e_khajana_receipt_check' => $this->input->post('khajana_receipt'),
                        'rk_verified' => $this->input->post('rk_verified'),
                        'protected_class_lm' => $protected_class_lm,
                        'erosion' => $this->input->post('erosion'),
                        'litigation' => $this->input->post('litigation'),
                        'landslide' => $this->input->post('landslide'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );
                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_ap_lmnote', $lmnote);
                    if ($this->db->affected_rows() == 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0007: Insertion failed in settlement_ap_lmnote RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0007: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
                    //*****Lmnote update ends */

                    //*********premium insert lm update start */
                    if ($is_prem_update == 'YES') {

                        /// premium verify start ************
                        $total_dag_lessa = $this->input->post('total_dag_lessa');
                        $total_app_lessa = $this->input->post('total_s_lessa');
                        $zonal_bigha = $this->input->post('dag_revenue');
                        $dag_per_lessa_revenue = ($zonal_bigha / $total_dag_lessa);
                        $final_amount = ($total_app_lessa * $dag_per_lessa_revenue);
                        $sumMbAmount = ceil($final_amount * 50);
                        if ($sumMbAmount != $this->input->post('total_due_amount')) {
                            // var_dump("Amount mismatch!!!"); die;
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0002: Settlement Application not submitted case no # $application_no");
                            redirect(base_url() . "index.php/home");
                        }
                        /// premium verify end ************

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

                        $premdata = array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            // 'uuid'=>$premdags->uuid,
                            'dag_no' => $this->input->post('dag_no'),
                            'zonal_valuation' => $this->input->post('dag_revenue'),
                            'final_amount' => $this->input->post('total_due_amount'),
                            'due_amount' => $this->input->post('total_due_amount'),
                            'total_lessa' => $this->input->post('total_s_lessa'),
                            'is_final' => 1,
                            'date_entry' => date('Y-m-d h:i:s'),

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

                    }
                    //************premium insert lm update end */
                }

                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                        SETTLEMENT_TENANT_ID,
                        $case_no,
                        $application_no,
                        $district['rejected_list']
                    );
                }

                //*********proceeding starts */
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $lm_remark_text,
                    'status' => 'X',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'LM updated note submitted',
                    'note_type' => $this->input->post('lm_note'),
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

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

                ////settlement Tenant LM Report insert end
                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk = 'Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    // var_dump($rtps_status); die();
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to " .$pending_officer. " With Case No # $case_no");
                    redirect(base_url() . "index.php/home");

                }
            }

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
            $vlb_enc['_view'] = 'SettlementView/VlbEncroacherDetails';
            $this->load->view('layouts/main', $vlb_enc);
        }
    }

    public function rioteePagination()
    {

        $tenant_id = $this->input->post('tenant_id');
        // $khatian_no = $this->input->post('khatian_no');
        $dag_no = $this->input->post('dag_no');
        $dist_code = $this->input->post('dist');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code = $this->input->post('cir');
        $mouza_pargona_code = $this->input->post('mouza');
        $lot_no = $this->input->post('lot');
        $vill_townprt_code = $this->input->post('vill');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        //$searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_3 = trim($this->input->post('columns')[3]['search']['value']);

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'tenant_id',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('LOWER(tenant_name)', strtolower($searchByCol_1));
        }

        // if(!empty($searchByCol_3)){
        //     $this->db->like('TO_CHAR(encroachment_from,\'yyyy-mm-dd\')', $searchByCol_3);
        //     //$this->db->like('date_entry', $searchByCol_2);
        // }

        $this->db->limit($length, $start);

        $this->db->select('*');
        $this->db->from('chitha_tenant');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('dag_no', $dag_no);
        // $this->db->where('khatian_no', $khatian_no);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $sl_count = 1;
            foreach ($query->result() as $rows) {

                $json[] = array(
                    $sl_count++,
                    '<span style= font-size:14px;><strong>' . $rows->khatian_no . '</strong></span>',

                    '<span style= font-size:14px;><strong>' . $rows->tenant_name . '</strong></span>',

                    '<span style= font-size:14px;><strong>' . $rows->tenants_father . '</strong></span>',

                    '<span style= font-size:14px;><strong>' . $rows->tenants_add1 . ',' . $rows->tenants_add1 . '</strong></span>


                  <input type="hidden" name="khatian_no" id="khatian_no' . $rows->tenant_id . '" value="' . $rows->khatian_no . '">
                  <input type="hidden" name="tenant_name" id="tenant_name' . $rows->tenant_id . '" value="' . $rows->tenant_name . '">
                  <input type="hidden" name="tenants_father" id="tenants_father' . $rows->tenant_id . '" value="' . $rows->tenants_father . '">',

                    '<button type="button" onclick="changeEncroacher(' . $rows->tenant_id . ',' . $tenant_id . ');" id="' . $rows->tenant_id . '" class="btn btn-sm btn-danger">Select</button>',

                );
            }

            if (!empty($searchByCol_1)) {

                $this->db->like('LOWER(tenant_name)', strtolower($searchByCol_1));

            }

            $this->db->select('*');
            $this->db->from('chitha_tenant');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            $this->db->where('dag_no', $dag_no);
            // $this->db->where('khatian_no', $khatian_no);
            $total_records = $this->db->count_all_results();
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function insertOwnerData()
    {
        $owner_pan_no = $this->input->post('owner_pan_no');
        $owner_bank_name = $this->input->post('owner_bank_name');
        $owner_acc_no = $this->input->post('owner_acc_no');
        $owner_ifsc = $this->input->post('owner_ifsc');
        $original_pdar_id = $this->input->post('original_pdar_id');
        $original_owner_father = $this->input->post('original_owner_father');
        $original_owner_name = $this->input->post('original_owner_name');
        $owner_living_stats = $this->input->post('owner_living_stats');
        $case_no = $this->input->post('case_no');
        $bene_percentage = $this->input->post('bene_percentage');

        $total_amount_due_by_applicant = (float)$this->input->post('total_due_amount');

        $_FILES['file']['name'] = $_FILES['bank_photo']['name'];
        $_FILES['file']['type'] = $_FILES['bank_photo']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['bank_photo']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['bank_photo']['error'];
        $_FILES['file']['size'] = $_FILES['bank_photo']['size'];

        $mime = mime_content_type($_FILES['bank_photo']['tmp_name']);
        $exp  = explode("/",$mime);
        $onlyExtension  = $exp[1];

        $fileRename =  $this->UUID4() . '.' . $onlyExtension;

        $bankPhoto['upload_path']   = UPLOAD_DIR;
        $bankPhoto['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $bankPhoto['max_size']  = UPLOAD_MAX_SIZE;;
        $bankPhoto['file_name'] = $fileRename;
        $this->load->library('upload', $bankPhoto);
        $this->upload->initialize($bankPhoto);

        if ($this->upload->do_upload('file'))
        {
            $beneficiary_not_owner = array(
                'owner_living_status' => 'YES',
                'bene_name' => $original_owner_name,
                'bene_guardian' => $original_owner_father,
                'bene_pan_no' => $owner_pan_no,
                'bene_compensation_eligibility' => 'YES',
                'bene_bank_name' => $owner_bank_name,
                'bene_account_no' => $owner_acc_no,
                'bene_ifsc' => $owner_ifsc,
                'bene_percentage' => $bene_percentage,
                'case_no' => $case_no,
                'amount' => ($total_amount_due_by_applicant * (float)$bene_percentage) / 100,
                'owner_name' => $original_owner_name,
                'pdar_id' => $original_pdar_id,
                'owner_father' => $original_owner_father,
                'service_code' => SETTLEMENT_TENANT_ID,
                'dist_code' => $this->session->userdata('dist_code'),
                'supporting_doc'  => UPLOAD_DIR . $fileRename,
            );

            $insert_beneficiary_not_owner = $this->db->insert('settlement_tenent_beneficiary', $beneficiary_not_owner);

            if ($insert_beneficiary_not_owner != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0008939: Insertion failed in settlement_tenent_beneficiary RTPS Case No ' . $case_no);
                $data = array(
                    'responseType' => 0,
                    'msg' => "#ERRSET0008939: Registration of Settlement failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#ERRSET0008930: Unable to upload Bank/Cheque copy for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
        $data = array(
            'responseType' => 2,
            'msg' => "Data successfully saved...",
        );
        echo json_encode($data);

    }

    public function checkAddedBeneficiary()
    {
        $case_no = $this->input->post('case_no');

        $sql2 = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = ?", array($case_no, 'O'));

        if($sql2->num_rows() > 0)
        {
            $result2 = $sql2->result();
            $data = array(
                'responseType' => 2,
                'data' => $result2,
                // 'data1' => $result
            );
            echo json_encode($data);
        }

    }

    public function checkOwnerLivingStatus()
    {
        $case_no = $this->input->post('case_no');
        $pdar_id = $this->input->post('pdar_id');

        $sql = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no = ? AND pdar_id = ?", array($case_no, $pdar_id));

        // echo $this->db->last_query();

        if($sql->num_rows() > 0)
        {
            $data = array(
                'responseType' => 2,
                'data' => $sql->row(),
                'pdar_id' => $pdar_id,
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'data' => $sql->row(),
                'pdar_id' => $pdar_id,
            );
            echo json_encode($data);
        }

    }

    public function checkIfAreadlyBeneExist()
    {
        $pdar_id = $this->input->post('pdar_id');
        $case_no = $this->input->post('case_no');

        $sql = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no = ? AND pdar_id =?", array($case_no, $pdar_id));

        if($sql->num_rows() > 0)
        {
            $data = array(
                'data' => $sql->row()->owner_living_status,
                'responseType' => 2,
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 1,
            );
            echo json_encode($data);
        }
    }

    public function getInsertedBeneficiary()
    {
        $pdar_id = $this->input->post('pdar_id');
        $case_no = $this->input->post('case_no');

        $sql = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no = ? AND pdar_id = ?", array($case_no, $pdar_id));

        if($sql->num_rows() > 0)
        {
            $data = array(
                'data' => $sql->result(),
                'responseType' => 2,
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'msg' => '#ERRRED0034: No data found !'
            );
            echo json_encode($data);
        }
    }

    public function deleteBeneficiary()
    {
        $id = $this->input->post('id');
        $pdar_id = $this->input->post('pdar_id');
        $case_no = $this->input->post('case_no');

        $this->db->query("DELETE FROM settlement_tenent_beneficiary WHERE id = ? AND pdar_id = ? AND case_no = ?", array($id, $pdar_id, $case_no));

        if($this->db->affected_rows() < 0)
        {
            $data = array(
                'responseType' => 0,
                'msg' => '#ERRRED003334: Unable to delete data! Please contact admin...'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 2,
                'msg' => 'Data Successfully deleted...'
            );
            echo json_encode($data);
        }
    }

    public function insertBeneficiaryData()
    {
        $owner_pan_no = $this->input->post('owner_pan_no');
        $owner_bank_name = $this->input->post('owner_bank_name');
        $owner_acc_no = $this->input->post('owner_acc_no');
        $owner_ifsc = $this->input->post('owner_ifsc');
        $original_pdar_id = $this->input->post('original_pdar_id');
        $original_owner_father = $this->input->post('original_owner_father');
        $original_owner_name = $this->input->post('original_owner_name');
        $owner_living_stats = $this->input->post('owner_living_stats');
        $case_no = $this->input->post('case_no');
        $total_due_amount = $this->input->post('total_due_amount');
        $bene_percentage = $this->input->post('bene_percentage');
        $bene_name = $this->input->post('bene_name');
        $bene_guardian_name = $this->input->post('bene_guardian_name');
        $bene_relation = $this->input->post('bene_relation');
        $bene_gender = $this->input->post('bene_gender');
        $bene_dob = $this->input->post('bene_dob');
        $bene_mobile = $this->input->post('bene_mobile');
        $bene_present_add = $this->input->post('bene_present_add');
        $bene_permanent = $this->input->post('bene_permanent');

        $total_amount_due_by_applicant = (float)$total_due_amount;

        $_FILES['file']['name'] = $_FILES['bank_photo']['name'];
        $_FILES['file']['type'] = $_FILES['bank_photo']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['bank_photo']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['bank_photo']['error'];
        $_FILES['file']['size'] = $_FILES['bank_photo']['size'];

        $mime = mime_content_type($_FILES['bank_photo']['tmp_name']);
        $exp  = explode("/",$mime);
        $onlyExtension  = $exp[1];

        $fileRename =  $this->UUID4() . '.' . $onlyExtension;

        $bankPhoto['upload_path']   = UPLOAD_DIR;
        $bankPhoto['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $bankPhoto['max_size']  = UPLOAD_MAX_SIZE;;
        $bankPhoto['file_name'] = $fileRename;
        $this->load->library('upload', $bankPhoto);
        $this->upload->initialize($bankPhoto);

        if ($this->upload->do_upload('file'))
        {
            $insertBeneArr = [
                'owner_living_status' => $owner_living_stats,
                'bene_name' => $bene_name,
                'bene_guardian' => $bene_guardian_name,
                'bene_pan_no' => $owner_pan_no,
                'bene_compensation_eligibility' => 'YES',
                'bene_bank_name' => $owner_bank_name,
                'bene_account_no' => $owner_acc_no,
                'bene_ifsc' => $owner_ifsc,
                'bene_percentage' => $bene_percentage,
                'case_no' => $case_no,
                'amount' => ($total_amount_due_by_applicant * (float)$bene_percentage) / 100,
                'owner_name' => $original_owner_name,
                'pdar_id' => $original_pdar_id,
                'owner_father' => $original_owner_father,
                'service_code' => SETTLEMENT_TENANT_ID,
                'dist_code' => $this->session->userdata('dist_code'),
                'supporting_doc' => UPLOAD_DIR . $fileRename,
                'bene_dob' => $bene_dob,
                'bene_relation' => $bene_relation,
                'bene_gender' => $bene_gender,
                'bene_mobile' => $bene_mobile,
                'bene_present_address' => $bene_present_add,
                'bene_permanent_address' => $bene_permanent
            ];

            $insert_beneficiary = $this->db->insert('settlement_tenent_beneficiary', $insertBeneArr);

            if ($insert_beneficiary != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00045: Insertion failed in settlement_tenent_beneficiary RTPS Case No ' . $case_no);
                $data = array(
                    'responseType' => 0,
                    'msg' => "#ERRSET00045: Registration of Settlement failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#ERRSET003430: Unable to upload Bank/Cheque copy for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
        $data = array(
            'responseType' => 2,
            'msg' => "Data successfully saved...",
        );
        echo json_encode($data);
    }

    public function ownerUntraceble()
    {
        $case_no = $this->input->post('case_no');
        $pdar_id = $this->input->post('pdar_id');
        $owner_name = $this->input->post('owner_name');
        $owner_father = $this->input->post('owner_father');
        $owner_living_status = $this->input->post('owner_living_status');

        $insertArr = [
            'case_no' => $case_no,
            'owner_living_status' => $owner_living_status,
            'pdar_id' => $pdar_id,
            'owner_name' => $owner_name,
            'owner_father' => $owner_father,
        ];

        $insertIntoDb = $this->db->insert('settlement_tenent_beneficiary', $insertArr);

        if($insertIntoDb != 1)
        {
            $data = array(
                'responseType' => 0,
                'msg' => '#EWSD3444: Unable to process! Contact admin...'
            );
            echo json_encode($data);
            return false;
        }

        $data = array(
            'responseType' => 2,
            'msg' => 'Successlly saved...'
        );
        echo json_encode($data);
    }

    public function totalCompensationSum()
    {
        $case_no = $this->input->post('case_no');

        $sql = $this->db->query("SELECT SUM(bene_percentage) as total_percent FROM settlement_tenent_beneficiary WHERE case_no = ?", array($case_no));

        if($sql->num_rows() > 0)
        {
            $value = 0;

            if(isset($sql->row()->total_percent))
            {
                $value = $sql->row()->total_percent;
            }

            $data = array(
                'responseType' => 2,
                'data' => $value,
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'responseType' => 0,
                'msg' => '#EDRRH3434: Something went wrong ! Contact admin...',
            );
            echo json_encode($data);
            return false;
        }
    }

    public function deleteBeneficiaryData()
    {
        $case_no = $this->input->post('case_no');
        $this->db->query('DELETE FROM settlement_tenent_beneficiary WHERE case_no = ?', array($case_no));
    }

}
