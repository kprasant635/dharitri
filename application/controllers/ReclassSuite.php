<?php
class ReclassSuite extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/basundhara3Model');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('basundhara3/reclassModel');
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

        foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $cons_reasons)
        {
            if($cons_reasons->SERVICE_CODE == $service_code)
            {
                $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
            }
        }
        return $validation_bypass_array;
    }

    // Reclass application view


    public function reclassSuiteRegistration()
    {
        $appli = $this->input->get('app'); // get rtps application no
        $application_no = $this->utilityclass->decryptJwtCase($appli);

        // var_dump('hrello');exit;

        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicantPhoto");
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
        $recordExist = $this->basundhara3Model->checkExistDharitree($application_no);

        if (!$recordExist) {

            // get data from basundhara end (API call)
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                // 'api_key' => API_KEY,
                // 'token' => $token,
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
            // echo "<pre>";
            // var_dump($output);exit;

            $app = $output->application;
            $d = $app->dist_code;
            $s = $app->subdiv_code;
            $c = $app->cir_code;
            $m = $app->mouza_code;
            $l = $app->lot_no;
            $v = $app->village_code;
            $dag = $app->dag_no;

            $case_name = $this->basundhara3Model->genearteCaseName(); // generate case name

            if (empty($case_name)) {
                log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                $data = array(
                    'error' => "#ERROR0002: Registration of Reclassification failed for case no : " . $application_no,
                );
                echo json_encode($data);
                exit;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->basundhara3Model->geneartemb3PetitionNoReclass();
            $case_no['case_no'] = $case_name . $petition_no . "/" . RECLASS_SUITE;

            //check for tribal belt
            // if ($output->applicants['0']->tribe_category == 1) {
            //     $tribal_belt = 'YES';
            // } else if ($output->applicants['0']->tribe_category == 0) {
            //     $tribal_belt = 'NO';
            // } else {
            //     $tribal_belt = '';
            // }

           // echo "<pre>";
            // var_dump($output->settlements[0]->applicant_occupation);exit;


            $this->db->trans_begin(); // transaction begins here

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM


            $reclass_basic = [
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' => $m,
                'lot_no' => $l,
                'vill_townprt_code' => $v,
                'service_code' => RECLASS_ID,
                'ref_no' => $output->application->ref_no,
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F',
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'Z',
                'submission_date' => date('Y-m-d G:i:s'),
                'applid' => $application_no,
                'caste' => $output->settlements[0]->caste_category,
                'uuid' => $output->application->uuid,
                'user_code' => $this->session->userdata('user_code'),
                'pending_officer' => 'LM',
                'occupation_applicant'=>$output->settlements[0]->applicant_occupation
            ];
            $reclass_basic_insertion = $this->db->insert('reclass_suite_basic', $reclass_basic);

            if ($reclass_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in reclass_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Reclassification failed for RTPS application no : " . $application_no);
                $data = array(
                    'error' => "#ERROR0003: Registration of Reclassification failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }

            // echo "<pre>";
            // var_dump($output);exit;

            //insert into RECLASS DAG DETAILS
            if (!empty($output->settlements)) {
                foreach ($output->settlements as $dag) {

                        if($dag->is_applicant == 1)
                        {
                        $new_land_class = $this->utilityclass->getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag->dag_no);

                        $prop_lc_cat_id = $this->db->query("select landclass_category_id from land_class_groups 
                        where id=?",array($dag->new_classification))->row();
                        $prop_lc_category_id = $prop_lc_cat_id->landclass_category_id;

                        // var_dump($dag->new_classification);exit;

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
                            'proposed_land_class_code' => $dag->new_classification,
                            'land_class_code' => $new_land_class->land_class_code,
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
                            'is_urban' => $app->is_urban,
                            'is_full_partial' => $dag->is_full_partial,
                            'proposed_land_class_name' =>$dag->new_classification_name,
                            'exist_land_class_name' =>$dag->old_classification_name,
                            'prop_lc_cat_id' =>$prop_lc_category_id 
                        ];
                        $reclass_dag_details = $this->db->insert('reclass_dag_details', $insSettlementDagDetails);

                        if ($reclass_dag_details != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0005: Insertion failed in reclass_dag_details for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : " . $application_no);
                            $data = array(
                                'error' => "#ERROR0005: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }

                        $base = array(
                        'caste' => $dag->caste_category,
                        'occupation_applicant'=>$dag->applicant_occupation
                        );

                        $this->db->where('case_no', $case_no['case_no']);
                        $this->db->update('reclass_suite_basic', $base);
                        if ($this->db->affected_rows() == 0) {
                            log_message("error", "##ERROR0005. Unable to 
                            update data into reclass_suite_basic for Case No: " . $case_no['case_no']);

                            $array = array(
                                "error" => true,
                                "msg" => "Error: [##ERROR0005].Unable to update data into reclass_suite_basic",
                            );
                            return $array;
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

                    if($appl->gurdian_relation_id == null)
                    {
                        $pdar_rel_guar = 0;
                    }
                    else
                    {
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }

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
                        'pdar_id' => $appl->pdar_id,
                        //'pdar_cron_no' => $cron_no,
                        'pdar_name' => $appl->name_ass,
                        'pdar_guardian' => $appl->gurdian_name_ass,
                        'pdar_rel_guar' => $appl->gurdian_relation_id,
                        'pdar_gender' => $appl->gender,
                        'pdar_add1' => $appl->per_add,
                        'pdar_add2' => $appl->pre_add,
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
                        'is_full_partial' => $appl->is_full_partial
                    ];
                    $applicantDetail = $this->db->insert('reclass_applicant', $insApplicant);

                    if ($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in reclass_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : " . $application_no);

                        $data = array(
                            'error' => "#ERROR0006: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
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
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
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

        // var_dump($output->selfDeclaration); die;

        //get case no from basundhar_application
        $case_no = $this->db->select()
            ->where('basundhara', $application_no)
            ->get('basundhar_application')->row()->dharitree;

        //get petition no from basundhar_application

        // $this->utilityclass->lmAuthBasic($case_no);

        $this->utilityclass->lmAuthFirstProceedingReclass($case_no);

        $petition_no = $this->db->select()
            ->where('applid', $application_no)
            ->get('reclass_suite_basic')->row()->petition_no;

        $basic = $this->reclassModel->getSettlementBasic($case_no);
        $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($case_no);
        $applicants_owners = $this->reclassModel->getAllApplicantOwners($case_no);
        $applicants_encroacher = 'test';//$this->reclassModel->getAllApplicantEncroacher($case_no);
        $applicants_riotee_nok = '';//$this->reclassModel->getAllApplicantRioteeNok($case_no);
        $dags = $this->reclassModel->getSettlementDag($case_no);

        $dags_part = $this->reclassModel->getSettlementDagPart($case_no);


        $lmnotes = $this->reclassModel->getSettlementTenantLmNote($case_no);

        $proceedings = $this->reclassModel->getSettlementProceeding($case_no);


        $dhardocuments = $this->reclassModel->getDocuments($case_no);
        $main_applicant = $this->reclassModel->getMainApplicant($case_no);



        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['nominee']=$nominee;

        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
        $district['premiumData'] = $premiumData;
        /// premium end

        $district['app'] = $basic;

        $district['applicants'] = $this->SettlementKhasModel->getAllApplicant($case_no);
        $district['query'] = '';//$output->query;
        $district['document'] = $output->documents;
        $district['encroachers'] = $applicants_encroacher;
        $district['owners'] = $applicants_owners;
        $district['riotee_noks'] = '';//$applicants_riotee_nok;
        $district['property'] = $this->SettlementKhasModel->getAdditionalProperty($case_no);
        $district['settlements'] = $this->SettlementKhasModel->getAllApplicant($case_no);
        $district['nextKin'] = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
        $district['bhumi'] = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $district['aadhar'] = $this->reclassModel->getMainApplicant($case_no);

        $district['basic'] = $basic;
        $district['applicants_buyers'] = $applicants_buyers;
        $district['applicants_owners'] = $applicants_owners;
        $district['applicants_encroacher'] = $applicants_encroacher;
        $district['applicants_riotee_nok'] = $applicants_riotee_nok;

        $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);
        $district['dags'] = $dags;
        $district['dags_part'] = $dags_part;
        $district['area_details'] = $dags;
        $district['lmnotes'] = $lmnotes;
        $district['proceedings'] = $proceedings;

        $district['dhardocuments'] = $dhardocuments;
        $district['case_no'] = $case_no;


        $district['co_name'] = $this->SettlementCommonModel->getCoName($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code);
        $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $revenue = $this->db->query("SELECT dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no))->row();
        $district['revenue'] = $revenue;



        // if(trim($applicants_encroacher[0]->khatian_no) == NULL || trim($applicants_encroacher[0]->khatian_no) == '' || trim($applicants_encroacher[0]->khatian_no) == -1)
        // {
        //     $district['chitha_tenant_exist'] = 'n';
        //     $district['chitha_tenant_app_end'] = $applicants_encroacher[0];
        // }
        // else
        // {
        //     $getChithaTenant = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=?
        //     AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=?
        //     AND khatian_no=? AND tenant_id=?", array($district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->lot_no, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no, $applicants_encroacher[0]->riotee_id));

        //     if($getChithaTenant->num_rows() <= 0)
        //     {
        //         $district['chitha_tenant_exist'] = 'n';
        //         $district['chitha_tenant_app_end'] = $applicants_encroacher[0];
        //     }
        //     else
        //     {
        //         $district['chitha_tenant_exist'] = 'y';
        //         $district['chitha_tenant'] = $getChithaTenant->row();
        //     }

        // }


        // $district['riotee_list'] = $this->SettlementTenantModel->getRioteeList($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $district['dags'][0]->dag_no, $applicants_encroacher[0]->khatian_no);

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


        // var_dump($district);die;
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


        // $applid_vlb = $this->utilityclass->getApplidFromCaseNo($case_no);
        // if (isset($dags)) {
        //     foreach ($dags as $vlb_dag) {
        //         $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details
        //     WHERE application_no = ? AND dag_no = ?", array($applid_vlb, $vlb_dag->dag_no));

        //         if ($sqlvlbcheck->num_rows() > 0) {
        //             $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
        //         } else {
        //             $vlb_newly_added[] = false;
        //         }
        //     }
        //     $district['vlb_newly_added'] = $vlb_newly_added;
        // }

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

        $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
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

        // var_dump($_SERVER['REQUEST_METHOD']); die;


      
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
             $district['_view'] = 'reclass_suite/reclassSuiteView';
            $this->load->view('layouts/main', $district);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // echo "<pre>";
            // var_dump($_POST);
            // die;

            $this->utilityclass->lmAuthFirstProceedingReclass($case_no);

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$case_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';


            $mStat = false;
            foreach($district['applicants_buyers'] as $applicantRow)
            {
                if($applicantRow->is_applicant == 1)
                {
                    if($applicantRow->marital_status == '1')
                    {
                         $mStat = true;
                    }
                }
            }

            $mStatErr = false;

            if($mStat == true)
            {
                foreach($district['applicants_buyers'] as $applicantRow)
                {
                    if($applicantRow->is_applicant != 1)
                    {
                        if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
                        {
                            $mStatErr = true;   
                            break;
                        }
                    }
                }
            }
            // if($mStatErr == true)
            // {
            //     $data = array(
            //         'error' => '#ERR14233: Spouse details has to be added if you select applicant as married!!!' .$case_no,
            //     );
            //     echo json_encode($data);
            //     return false;
            // }

            //  row_array
            $basic   = $this->reclassModel->getSettlementBasic($case_no);
            //  result
            $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->reclassModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->reclassModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->reclassModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->reclassModel->getSettlementDag($case_no);
            $lmnotes = $this->reclassModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->reclassModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->reclassModel->getDocuments($case_no);

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];

            /// premium
            $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
            $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $district['premiumData'] = $premiumData;
            /// premium end

            $district['basic']=$basic;
            $district['geo_date']=$geo_date;
            $district['applicants_buyers']=$applicants_buyers;
            $district['applicants_owners']=$applicants_owners;
            $district['applicants_encroacher']=$applicants_encroacher;
            $district['applicants_riotee_nok']=$applicants_riotee_nok;

            $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);


            $district['dags']=$dags;
            $district['lmnotes']=$lmnotes;
            $district['proceedings']=$proceedings;
            $district['dhardocuments']=$dhardocuments;


            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();

            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
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
            //var_dump($output);

            $district['document']=$output->documents;
            $district['query']=$output->query;
            $district['property']=$output->property;
            $district['aadhar']=$output->aadhar;
            $district['nextKin']=$output->nextKin;
            foreach($output->selfDeclaration as $selfDec){
                $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            foreach($district['applicants_buyers'] as $adhar_photo):
                if($adhar_photo->is_applicant == 1):
                    if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                        $adhar_photo_link = $adhar_photo->identity_doc_link;

                        $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                        fclose($open_adhar_file);
                        // decoding the base64 encoding file variable

                        $district['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";

                    endif;
                endif;
            endforeach;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $district['guar_rel'] = $relation_executation->result();
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
                $district['vlb_newly_added'] = $vlb_newly_added;
            }

            $district['case_no'] = $case_no;

            // For insertion of settlement khasland 
            $distCode = trim($this->input->post('dist_code'));
            if ($distCode == null) {
                redirect(base_url(). 'index.php/basundhara3/settlementCases');
            }
            if ($application_no == null) {
                redirect(base_url(). 'index.php/basundhara3/settlementCases');
            }
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            //********validation bypass */
            $validation_bypass = 0;


            if(isset($_POST['lm_note']) && $_POST['lm_note'] == '2')
            {
              if(isset($_POST['rejected_reasons']))
              {
                $validation_bypass_array = $this->getValidationBypass(RECLASS_ID);
                // var_dump($validation_bypass_array); die;
                foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                {
                  $r_c = explode("_", $rej_form_code);

                  if (in_array($r_c[0], $validation_bypass_array)) {
                    $validation_bypass = 1;
                  }
                }
              }
            }

            

            // var_dump($_POST);exit;
            //****checking if validation is required */
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
                    if(GEO_TAG_ACTIVE_STATUS == 1)
                    {
                        $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                    }
                }

                $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                $this->form_validation->set_rules('case_no', 'Case No', 'trim|required|min_length[2]');
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
                $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

                $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                

               // $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
               // $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                // $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
                // $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
                // $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
                // $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');

                // $this->form_validation->set_rules('encroacher_exist_vlb', 'Is Encroacher Exists in VLB ?', 'trim|required');

                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('applicant_type', 'Applicant type', 'trim|required');
                // $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                //$this->form_validation->set_rules('is_landless', 'Whether application is landless', 'trim|required');
               // $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
               // $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
                //$this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
               // $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');
                // $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
                //$this->form_validation->set_rules('field_report', 'Field Report', 'trim|required');
                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');

                $this->form_validation->set_rules('roadside_reservation','','');


               // $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                //$this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');


                if (empty($_FILES['field_report']['name']))
                {
                    $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                }

                $roadside_comment_check=$this->input->post('roadside_comment_check');
                $family_comment_check=$this->input->post('family_comment_check');

                $totalDagAreaLessaValidation = 0;
                $totalAgrAreaLessaValidation = 0;
                $totalHomeAreaLessaValidation = 0;
                $appAreaMoreThanDagA = 0;
                $reserveMoreThanAppArea = 0;
                $familyMoreThanAppArea = 0;
                $fishAreaLessaValidation = 0;
                $totalRoadSideAreaLessaValidation = 0;
                $totalFamilyAreaLessaValidation = 0;
                $totalFishAreaLessaValidation = 0;


                $enc_count = count($applicants_encroacher);
                $enc_avl_check = 0;
                

                foreach ($district['dags'] as $dag_area_cal) {

                    //******NCBTAD check  */
                    $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

                    if($ncBtadCheck > 0)
                    {
                        //*******throw error for NCBTAD */
                        log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                        $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }

                    $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');

                     $this->form_validation->set_rules('reclass_option_'.$dag_area_cal->dag_no, 'Reclass Type', 'trim|required');

                     $this->form_validation->set_rules('wetland_verified_hidden'.$dag_area_cal->dag_no, 'Wetland Verified', 'trim|required');

                     $this->form_validation->set_rules('agritononagri_verified'.$dag_area_cal->dag_no, 'Agri-nonagri  Verified', 'trim|required');

                     $this->form_validation->set_rules('masterplan_notified'.$dag_area_cal->dag_no, 'Master Plan  Verified', 'trim|required');


                    // new premium addition
                    // $this->form_validation->set_rules('area'.$dag_area_cal->dag_no, 'Select Area Type', 'trim|required');
                    //$this->form_validation->set_rules('area_new'.$dag_area_cal->dag_no, 'Select Area Type', 'trim|required');
                    // for barak valley
                    if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                        if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                        }

                        $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');


                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->UtilsModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);
                        $gandaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fganda'.$dag_area_cal->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
                        $fishAreaLessaValidation = ($bighaValidationFish * 6400) + ($kathaValidationFish * 320) + ($lessaValidationFish * 20) + $gandaValidationFish;

                        if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation + $fishAreaLessaValidation) {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;
                        $totalFishAreaLessaValidation += $fishAreaLessaValidation;

                        if ($roadside_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda'.$dag_area_cal->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti'.$dag_area_cal->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                        

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
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
                    }
                    else
                    {

                        if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                        }

                        $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');


                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->UtilsModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);

                        $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                        $fishAreaLessaValidation = ($bighaValidationFish * 100) + ($kathaValidationFish * 20) + $lessaValidationFish;

                        if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation + $fishAreaLessaValidation) {
                            $appAreaMoreThanDagA = 1;
                        }

                        $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                        $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;
                        $totalFishAreaLessaValidation += $fishAreaLessaValidation;
                        // new premium addition
                        // if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                        //     $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                        //     if(!empty($maxland_check->max_land)){

                        //         if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                        //             $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                        //                 $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //         }

                        //     }

                        // }else{
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        // }
                    }



                }

                // new additional property calculation
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();

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

                $checkUrbanCon = trim($this->input->post('is_urban'));


                // if ($reserveMoreThanAppArea == 1) {
                //     $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
                // }

                // if ($familyMoreThanAppArea == 1) {

                //     $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');

                // }

                // if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation + $totalFishAreaLessaValidation == 0) {
                //     $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
                // }

                // if ($appAreaMoreThanDagA == 1) {

                //     $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');

                // }

                $land_exceed =0;
                // for barak valley
                // if (in_array($distCode, json_decode(BARAK_VALLEY)))
                // {
                //     if (KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {

                //         $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');
                //     }
                //     if (KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                //         $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');
                //     }
                //     if (FISHERY_MAX_AREA * 6400 < $totalFishAreaLessaValidation) {
                //         $this->form_validation->set_rules('khasMaxFishery','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !', 'required|callback_khasMaxFishery');
                //     }
                //     if((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 6400 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                //     {
                //         // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                //         $land_exceed =1;
                //     }

                //     // new premium addition
                //     // if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                //     //     $maxland_ganda ='';
                //     //     if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                //     //         $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

                //     //         if(!empty($maxland_check->max_land)){
                //     //             if($maxland_check->max_land =='40'){
                //     //                 $maxland_ganda = 2560;
                //     //             }elseif($maxland_check->max_land =='60'){
                //     //                 $maxland_ganda = 3840;
                //     //             }
                //     //             if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                //     //                 $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                //     //                     $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                //     //             }


                //     //         }

                //     //     }else{
                //     //         $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                //     //             $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                //     //     }

                //     // }


                //     if($checkUrbanCon == 'Y')
                //     {
                //         // if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation)
                //         // {
                //         //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                //         //         MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //         // }


                //         // new premium addition
                //         //  $maxland_ganda ='';
                //         if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                //             if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                //                 $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

                //                 if(!empty($maxland_check->max_land)){
                //                     if($maxland_check->max_land =='40'){
                //                         $maxland_ganda = 2560;
                //                     }elseif($maxland_check->max_land =='60'){
                //                         $maxland_ganda = 3840;
                //                     }
                //                     if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                //                         $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                //                             $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                //                     }


                //                 }

                //             }else{
                //                 $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                //                     $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                //             }
                //         }
                //     }

                // }
                // else
                // {
                //     if (KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {

                //         $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');

                //     }
                //     if (KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {

                //         $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');

                //     }
                //     if (FISHERY_MAX_AREA * 100 < $totalFishAreaLessaValidation) {

                //         $this->form_validation->set_rules('khasMaxFishery','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !', 'required|callback_khasMaxFishery');

                //     }
                //     if((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                //     {
                //         // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                //         $land_exceed =1;
                //     }

                //     // new premium addition
                //     if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                //         if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                //             $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                //             if(!empty($maxland_check->max_land)){

                //                 if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                //                     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                //                         $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //                 }

                //             }

                //         }else{
                //             $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                //                 $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //         }
                //     }

                //     if($checkUrbanCon == 'Y')
                //     {
                //         // if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                //         // {
                //         //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                //         //         MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //         // }

                //         // new premium addition
                //         if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                //             if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                //                 $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                //                 if(!empty($maxland_check->max_land)){

                //                     if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                //                         $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                //                             $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //                     }

                //                 }

                //             }else{
                //                 $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                //                     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                //             }
                //         }
                //     }
                // }

                // if($_POST['lm_note'] == '1' && $land_exceed == 1)
                // {
                //     $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                // }

                // for total applied area set_value in validation error Homestead
                // $this->form_validation->set_rules('total_applied_area_homestead_bigha','','');
                // $this->form_validation->set_rules('total_applied_area_homestead_katha','','');
                // $this->form_validation->set_rules('total_applied_area_homestead_lessa','','');
                // $this->form_validation->set_rules('total_applied_area_homestead_ganda','','');
                // $this->form_validation->set_rules('total_applied_area_homestead_kranti','','');

                // for total applied area set_value in validation error Agriculture
                // $this->form_validation->set_rules('total_applied_area_agricultural_bigha','','');
                // $this->form_validation->set_rules('total_applied_area_agricultural_katha','','');
                // $this->form_validation->set_rules('total_applied_area_agricultural_lessa','','');
                // $this->form_validation->set_rules('total_applied_area_agricultural_ganda','','');
                // $this->form_validation->set_rules('total_applied_area_agricultural_kranti','','');

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


                // if ($applicants_encroacher == true)
                // {
                //     foreach ($applicants_encroacher as $enc_applicant)
                //     {
                //         $this->form_validation->set_rules('encroacher_exist_vlb'.$enc_applicant->id, '', '');
                //         $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, '', '');
                //         $this->form_validation->set_rules('period_possession'.$enc_applicant->id, '', '');
                //         $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, '', '');
                //         $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, '', '');
                //     }
                // }
            }

            if ($this->form_validation->run() == false)
            {

                $district['all_errors'] = validation_errors();
                if(isset($fileCount)){
                    $district['fileCount'] = $fileCount;
                }
                $district['err_return'] = true;
                $district['_view'] = 'reclass_suite/reclassSuiteView';
                $this->load->view('layouts/main',$district);
            }
            else
            {
                $this->db->trans_begin();

                //************update in settlement_applicant */

                // if ($applicants_encroacher == true)
                // {
                //     foreach ($applicants_encroacher as $enc_applicant)
                //     {

                //         $applicant_array = [
                //             'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'.$enc_applicant->id)
                //         ];

                //         $this->db->where('id', $enc_applicant->id);
                //         $this->db->where('case_no', $case_no);
                //         $this->db->update('settlement_applicant', $applicant_array);

                //         if($this->db->affected_rows() <= 0)
                //         {
                //             $this->db->trans_rollback();
                //             log_message('error', '#ERROR00112: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                //             $data = array(
                //                 'error'=>"#ERROR00112: Registration of Settlement failed for case no : ".$application_no
                //             );
                //             echo json_encode($data);
                //             return false;
                //         }
                //     }
                // }

                //new premium condition

                foreach ($district['dags'] as $dag_for_approve) {
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

            

                //*******update in settlement_basic */
                $sk_code = null;
                $co_code = null;
                // if(trim($district['sk_availability']) == 'y')
                if('1' == '2')
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
                $this->db->update('reclass_suite_basic', $basicData);

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0011: Updation failed in reclass_suite_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR0011: Registration of Reclassification failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //update additional property
                // $additional_property_check = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");

                // if($additional_property_check->num_rows() > 0){
                //     $additionalPropertyUpdate = [
                //         'case_no' => $case_no,
                //     ];
                //     $this->db->where('applid', $application_no);
                //     $this->db->update('settlement_additional_property', $additionalPropertyUpdate);
                //     if($this->db->affected_rows() <= 0)
                //     {
                //         $this->db->trans_rollback();
                //         log_message('error', '#ERROR1836: Updation failed in settlement_additional_property RTPS Case No '.$application_no);
                //         $data = array(
                //             'error'=>"#ERROR1836: Registration of Settlement failed for case no : ".$application_no
                //         );
                //         echo json_encode($data);
                //         return false;
                //     }
                // }

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

                    $this->session->set_flashdata('message', "#BACKUP002: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                // UPDATING Geo Tag Photo case number in supportive document
                if (isset($district['geo_tag_doc'])) {
                    foreach ($district['geo_tag_doc'] as $geo_tag_loop) {
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

                //*****only insert if validation bypass is 0 */
                if($validation_bypass == 0)
                {
                    foreach ($district['dags'] as $dagsland) {
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

                        $reclass_option = $this->input->post('reclass_option_'.$dagsland->dag_no);

                        $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $dagsland->dag_no))->row();
                            
                           //echo "<pre>"; var_dump($dag_area->dag_area_lc);$this->db->trans_rollback();exit;
                        $tot_bigha = $dag_area->dag_area_b;
                        $tot_katha = $dag_area->dag_area_k;
                        $tot_lessa = $dag_area->dag_area_lc;
                        $tot_ganda = $dag_area->dag_area_g;

                        if($reclass_option=="part_yes")
                        {
                            // $applied_bigha = $this->input->post('bigha_part'.$dagsland->dag_no);
                            // $applied_katha = $this->input->post('katha_part'.$dagsland->dag_no);
                            // $applied_lessa = $this->input->post('lessa_part'.$dagsland->dag_no);

                            // $dist_code = $this->input->post('dist_code');

                            // if(in_array($dist_code, BARAK_VALLEY))
                            // { // for barak valley
                            //   $total_dag_area = ($tot_bigha * 6400) + ($tot_katha * 320) + ($tot_lessa * 20) + $tot_ganda;
                            //   $total_dag_area_in_lessa = ($total_dag_area/6400);

                            //    $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                            //    $total_p_dag_in_lessa = ($total_p_dag_area/100);


                            //   if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                            //     {
                            //         $this->db->trans_rollback();
                            //         log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            //         $this->session->set_flashdata('message', "#PART0013: For Partial reclass, Applied area and total area of Dag can not be equal..You can choose Full reclass with Partition : ".$case_no);
                            //         redirect(base_url() . "index.php/ReclassSuite/reclassSuiteRegistration");
                            //         return false;
                            //     }

                            //     if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                            //     {
                            //         $this->db->trans_rollback();
                            //         log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            //         $this->session->set_flashdata('message', "#PART0013: For Partial reclass, Applied area can not be more than total area of Dag..You can choose Full reclass with Partition : ".$case_no);
                            //         redirect(base_url() . "index.php/home");
                            //         return false;
                            //     }

                            // }

                            // else
                            // {
                            // $total_dag_area = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa; //total area
                            // $total_dag_area_in_lessa = ($total_dag_area/100);

                            // $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                            // $total_p_dag_in_lessa = ($total_p_dag_area/100);

                            // if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                            // {
                            //     $this->db->trans_rollback();
                            //     log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            //     $this->session->set_flashdata('message', "#PART0013: For Partial reclass applied area and total area of Dag can not be equal..You can choose Full reclass with Partition : ".$case_no);
                            //     redirect(base_url() . "index.php/home");
                            //     return false;
                            // }

                            // if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                            // {
                            //     $this->db->trans_rollback();
                            //     log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            //     $this->session->set_flashdata('message', "#PART0013: For Partial reclass applied area can not be more than total area of Dag..You can choose Full reclass with Partition : ".$case_no);
                            //     redirect(base_url() . "index.php/home");
                            //     return false;
                            // }

                            // }

                            // $lm_area_b = $applied_bigha;
                            // $lm_area_k = $applied_katha;
                            // $lm_area_lc = $applied_lessa;
                            // $lm_area_g = 0;

                            $lm_area_b = $tot_bigha;
                            $lm_area_k = $tot_katha;
                            $lm_area_lc = $tot_lessa;
                            $lm_area_g = $tot_ganda;


                            $is_partion = 'Y';
                            $is_full_partition = 'N';

                            foreach ($_POST['pdar_selected_all'] as $selected) 
                            {
                               ///reclass partition//
                                $partition_array_lm = [
                                    'case_no' => $case_no,
                                    'from_office' => 'LM',
                                    'to_office' => $pending_officer,
                                    'status' => 'W',
                                    'dag_no' => $dagsland->dag_no,
                                    'pdar_id' =>$selected,
                                    'retain_old_dag'=>'0'
                                ];

                                $partition_array_lm = $this->db->insert('reclass_partition_info', $partition_array_lm);
                                if($partition_array_lm != 1){
                                    $this->db->trans_rollback();
                                    log_message('error', '#PART001: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                    $this->session->set_flashdata('message', "#PART001: Registration of Reclassification failed for case no : ".$case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }
                            }  


                            if (isset($_POST['pdar_selected'])) 
                            {
                                foreach ($_POST['pdar_selected'] as $selected_pdar) 
                                {
                                   ///reclass partition//
                                    $chkpdar_array_lm = [
                                        'retain_old_dag'=>'1'
                                    ];

                                    $this->db->where('case_no', $case_no);
                                    $this->db->where('dag_no', $dagsland->dag_no);
                                    $this->db->where('pdar_id', $selected_pdar);
                                    $this->db->update('reclass_partition_info', $chkpdar_array_lm);
                                    if($this->db->affected_rows() <= 0)
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERROR0012: Updation failed in reclass_partition_info RTPS Case No '.$case_no);
                                        $data = array(
                                            'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                }
                            }
                        }
                        else if($reclass_option=="part_no")
                        {
                            $is_partion = 'N';
                            $is_full_partition = 'N';

                            $lm_area_b = null;
                            $lm_area_k = null;
                            $lm_area_lc = null;
                            $lm_area_g = null;
                        }
                        else if($reclass_option=="part_full_yes")
                        {
                            $is_partion = 'Y';
                            $is_full_partition = 'Y';

                            $lm_area_b = $tot_bigha;
                            $lm_area_k = $tot_katha;
                            $lm_area_lc = $tot_lessa;
                            $lm_area_g = $tot_ganda;
                        }
                        // else
                        // {
                        //     $is_partion = 'N';
                        // }

                        $wetland_verified = $this->input->post('wetland_verified_hidden'.$dagsland->dag_no);

                        if($wetland_verified=="YES")
                        {
                            $is_wet_land = 'Y';
                        }
                        else
                        {
                            $is_wet_land = 'N';
                        }

                        // var_dump($this->input->post('nature_possession'.$dagsland->dag_no));
                        // $this->db->trans_rollback();
                        // exit;

                        $masterplan_notified = $this->input->post('masterplan_notified'.$dagsland->dag_no);



                        $fmddata= [
                            'date_entry' => date('Y-m-d'),
                            'landmark'   => json_encode($landmark),
                            'nature_possession'=>$this->input->post('nature_possession'.$dagsland->dag_no),
                            'is_partition' => $is_partion,
                            'is_wet_land' => $is_wet_land,
                            'is_full_partition' => $is_full_partition,
                            'lm_area_b' =>$lm_area_b,
                            'lm_area_k' =>$lm_area_k,
                            'lm_area_lc'=>$lm_area_lc,
                            'lm_area_g' =>$lm_area_g,
                            'is_master_plan' => $masterplan_notified
                        ];
                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->update('reclass_dag_details', $fmddata);
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

                        $agritononagri_verified = $this->input->post('agritononagri_verified'.$dagsland->dag_no);

                        if($agritononagri_verified=="YES")
                        {
                            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ?", array($case_no,$dagsland->dag_no,'Y'));
                            if ($sql->num_rows() <= 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORAGRINAGRI0001: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRORAGRINAGRI0001: Registration of Reclassification failed for case no,Fill the agri to non agri column properly : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            else
                            {
                                $status = 1;

                                $fmddata= [
                                    'status' => $status
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_eligibility', $fmddata);

                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRORAGRINAGRI0002: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                                    $data = array(
                                        'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }


                                $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));

                                //var_dump($sql->row()->is_eligible);$this->db->trans_rollback();exit;

                                $is_eligible = $sql->row()->is_eligible;


                                $fmddata= [
                                    'is_agri_to_nonagri' =>'Y',
                                    'is_eligible' =>$is_eligible
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_details', $fmddata);
                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERROR0012: Updation failed in reclass_dag_details RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }
                        }


                        if($agritononagri_verified=="NO")
                        {
                            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ?", array($case_no,$dagsland->dag_no,'N'));
                            if ($sql->num_rows() <= 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORAGRINAGRI0001: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRORAGRINAGRI0001: Registration of Reclassification failed for case no,Fill the agri to non agri column properly : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            else
                            {
                                $status = 1;

                                $fmddata= [
                                    'status' => $status
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_eligibility', $fmddata);

                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRORAGRINAGRI0002: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                                    $data = array(
                                        'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }


                                $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));

                                //var_dump($sql->row()->is_eligible);$this->db->trans_rollback();exit;
                                $is_eligible = $sql->row()->is_eligible;


                                $fmddata= [
                                    'is_agri_to_nonagri' =>'N',
                                    'is_eligible' =>$is_eligible
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_details', $fmddata);
                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERROR0012: Updation failed in reclass_dag_details RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }
                        }


                        
                    }

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
                                    'mut_type'   => RECLASS_ID,
                                );

                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

                                    $this->session->set_flashdata('message', "#ERRADDDOC0001: Only PDF and Image files area allowed : ".$application_no);
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

                                $this->session->set_flashdata('message', "#ERRADDDOC00851: Only PDF and Image files area allowed : ".$application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }
                    //end of additional file upload

                    $field_report_file = $_FILES['field_report'];


                    // For uploading dag wise trace_map_copy
                    foreach ($district['dags'] as $dags_doc)
                    {
                        $timestamp = date('mdYhis', time()).uniqid();

                        $trace_map_file = $_FILES['trace_map_copy'.$dags_doc->dag_no];
                        $trace_file_name = 'trace_map_copy'.$timestamp;

                        //upload trace map file by calling API
                        $trace_map_api_file = $this->SettlementCommonModel->uploadFileByApiBase($trace_map_file, $application_no, API_KEY, $trace_file_name);
                        // $trace_map_api_file = '{"status": 4}';

                        $trace_json = json_decode($trace_map_api_file);

                        $trace_upload_path = UPLOAD_DIR.$timestamp.$trace_map_file['name'];

                        if($trace_json->status == 4) // success
                        {
                            $document= array(
                                'case_no'         => $case_no,
                                'file_name'       => 'Trace Map Copy',
                                'user_code'       => $this->session->userdata('user_code'),
                                'fetch_file_name' => $trace_map_file['name'],
                                'file_type'       => $trace_map_file['type'],
                                'file_path'       => $trace_upload_path,
                                'date_entry'      => date('Y-m-d h:i:s'),
                                'mut_type'        => $this->input->post('service_code'),
                                'dag_no'          => $this->input->post('dag_no_doc'.$dags_doc->dag_no),
                                'api_doc_id'      => $trace_json->docId,

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
                        else {
                            log_message('error', 'Unable to upload trace map file for case no '.$case_no);
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "#ERRADDDOC077471: Only PDF and Image files area allowed : ".$application_no);
                            redirect(base_url() . "index.php/home");
                        }


                        if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
                        {
                            // Trace Map copy upload
                            $config['file_name']     = $trace_file_name;
                            $config['upload_path']   = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']      = 2000;

                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if(!move_uploaded_file($trace_map_file['tmp_name'], $trace_upload_path)){
                                log_message('error', 'Unable to move trace map file for case no '.$case_no);
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "#ERRADDDOC00711001: Only PDF and Image files area allowed : ".$application_no);
                                redirect(base_url() . "index.php/home");
                            }
                        }
                    }



                    $timestamp = date('mdYhis', time()).uniqid();
                    // For uploading field report                   

                    //upload field report file by calling API
                    $field_file_name = 'field_report'.$timestamp;


                    $field_report_api_file = $this->SettlementCommonModel->uploadFileByApiBase($field_report_file, $application_no, API_KEY, $field_file_name);
                    // $field_report_api_file = '{"status": 4}';

                    $field_report_json = json_decode($field_report_api_file);
                    $field_report_path = UPLOAD_DIR.$timestamp.$field_report_file['name'];

                    if($field_report_json->status == 4) // success 
                    {
                        $document= array(
                            'case_no'         => $case_no,
                            'file_name'       => 'Field Report',
                            'user_code'       => $this->session->userdata('user_code'),
                            'fetch_file_name' => $field_report_file['name'],
                            'file_type'       => $field_report_file['type'],
                            'file_path'       => $field_report_path,
                            'date_entry'      => date('Y-m-d h:i:s'),
                            'mut_type'        => $this->input->post('service_code'),
                            'api_doc_id'      => $field_report_json->docId,
                        );

                        $insert_supportive_doc= $this->db->insert('supportive_document', $document);

                        if ($insert_supportive_doc != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                            $json = [
                                'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }
                    else {
                        log_message('error', 'Unable to upload field report file for case no '.$case_no);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERRADDDOC00998501: Only PDF and Image files area allowed : ".$application_no);
                        redirect(base_url() . "index.php/home");
                    }


                    if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
                    {
                        $config2['file_name']     = $field_file_name;
                        $config2['upload_path']   = UPLOAD_DIR;
                        $config2['allowed_types'] = UPLOAD_ALLOW_TYPE;
                        $config2['max_size']      = 2000;

                        $this->load->library('upload', $config2);
                        $this->upload->initialize($config2);

                        if(!move_uploaded_file($field_report_file['tmp_name'], $field_report_path)){
                            log_message('error', 'Unable to move field report file for case no '.$case_no);
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "#ERRADDDOC000331: Only PDF and Image files area allowed : ".$application_no);
                            redirect(base_url() . "index.php/home");
                        }
                    }

                    //*********if LM if case of case rejected the rejected remarks */

                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(RECLASS_ID);


                    $comment = addslashes($this->input->post('lm_note'));

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

                    $lmnote=array(
                        'user_code'=>$this->session->userdata('user_code'),
                        'chitha_verified'=>$this->input->post('chitha_verified'),
                        'vlb_verified'=>$this->input->post('vlb_verified'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'possession_verification'=>$this->input->post('possession_verification'),
                        'period_possession'=>date('Y-m-d'),
                        // 'nature_possession'=>$this->input->post('nature_possession'),
                        'is_landless'=>$this->input->post('is_landless'),
                        'land_falls'=>$this->input->post('land_falls'),
                        'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                        'roadside_reservation'=>$this->input->post('roadside_reservation'),
                        // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
                        // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                        // 'chitha_copy'=>$this->input->post('chitha_copy'),
                        'trace_map_copy'=>'NA',
                        'chitha_copy'=>'NA',
                        'lm_note'=>$comment,
                        'lm_remark_text'=>$this->input->post('lm_remark_text'),
                        'date_entry'=>date('Y-m-d h:i:s'),
                        'case_no'=>$case_no,
                        'status'=>'W',
                        'total_bigha'=>$this->input->post('total_bigha'),
                        'total_Katha'=>$this->input->post('total_Katha'),
                        'total_lessa'=>$this->input->post('total_lessa'),
                        'total_ganda'=>$this->input->post('total_ganda'),
                        'total_kranti'=>$this->input->post('total_kranti'),
                        // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                        'landslide'            => $this->input->post('landslide'),
                        'erosion'            => $this->input->post('erosion'),
                        'protected_class_lm' => $protected_class_lm,
                        'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );

                    $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
                    if ($insLmnote != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }


                }

                if($validation_bypass == 1)
                {
                    $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
                        RECLASS_ID,
                        $case_no,
                        $application_no,
                        $district['rejected_list']
                    );
                }

                //******do if only validation_bypass 0 */
                if($validation_bypass == 0)
                {
                    ///// road side reserve area start /////
                    if ($roadside_comment_check=='YES') {
                        foreach ($district['dags'] as $dags) {
                            $reservedarea=array(
                                'dist_code'=>$this->input->post('dist_code'),
                                'subdiv_code'=>$this->input->post('subdiv_code'),
                                'cir_code'=>$this->input->post('cir_code'),
                                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                'lot_no'=>$this->input->post('lot_no'),
                                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                'dag_no'=>$this->input->post('reserved_dag_road'.$dags->dag_no),
                                'patta_no'=>$this->input->post('reserved_patta_road'.$dags->dag_no),
                                'bigha'=>$this->input->post('reserved_bigha'.$dags->dag_no),
                                'katha'=>$this->input->post('reserved_katha'.$dags->dag_no),
                                'lessa'=>$this->input->post('reserved_lessa'.$dags->dag_no),
                                'ganda'=>$this->input->post('reserved_ganda'.$dags->dag_no),
                                'kranti'=>$this->input->post('reserved_kranti'.$dags->dag_no),
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
                                log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }

                    if ($family_comment_check=='YES') {
                        foreach ($district['dags'] as $dags) {
                            $reservedarea=array(
                                'dist_code'=>$this->input->post('dist_code'),
                                'subdiv_code'=>$this->input->post('subdiv_code'),
                                'cir_code'=>$this->input->post('cir_code'),
                                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                'lot_no'=>$this->input->post('lot_no'),
                                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                'dag_no'=>$this->input->post('reserved_dag_family'.$dags->dag_no),
                                'patta_no'=>$this->input->post('reserved_patta_family'.$dags->dag_no),
                                'bigha'=>$this->input->post('reserved_bigha_family'.$dags->dag_no),
                                'katha'=>$this->input->post('reserved_katha_family'.$dags->dag_no),
                                'lessa'=>$this->input->post('reserved_lessa_family'.$dags->dag_no),
                                'ganda'=>$this->input->post('reserved_ganda_family'.$dags->dag_no),
                                'kranti'=>$this->input->post('reserved_kranti_family'.$dags->dag_no),
                                'case_no'=>$case_no,
                                'applid'=>$this->input->post('applid'),
                                'lm_code'=>$this->session->userdata('user_code'),
                                'date_entry'=>date('Y-m-d h:i:s'),
                                'date_update'=>date('Y-m-d h:i:s'),
                                'type'=>'F'
                            );

                            $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                            // echo $this->db->last_query(); die();
                            if ($reserveData != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET00053: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRSET00053: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }
                    ///// family reserve area end //////

                    //// premium insert start ******************
                    $sumMbAmount = 0;
                    $approved_by ='';
                    $count =0;
                    

                    foreach ($district['dags'] as $dag_premium) 
                    {
                        $ratetype=$this->input->post('rate_type'.$dag_premium->dag_no);
                        $proposed_lc_code=$this->input->post('prop_lc_code'.$dag_premium->dag_no);

                        $is_penalty = $this->input->post('is_penalty'.$dag_premium->dag_no);
                        $exist_lc_type = $this->input->post('rate_type'.$dag_premium->dag_no);

                        $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
                        where id=?",array($proposed_lc_code))->row();
                        $proc_lc_cat_code = $prop_lc_det->landclass_category_id;


                        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_premium->dag_no,'Y','N',0));

                        if ($sql->num_rows()>=1) 
                        {
                        $ratepr = 0;
                        $sum_area = 0;
                        }
                        else
                        {   
                        $ratepr2=$this->db->query("select prid,rate from reclass_premium_rate where exist_code='$ratetype' and prop_code='$proc_lc_cat_code' order by prid ")->row();
                        $ratepr = $ratepr2->rate;


                        $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ?", array($case_no,$dag_premium->dag_no));

                        $data2 = $sql2->row();

                        if($data2->is_partition=='Y' && $data2->is_full_partition=='N')
                        {
                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                            {
                                $dag_area =$this->db->query("SELECT sum(lm_area_b*6400+lm_area_k*320+lm_area_lc*20+lm_area_g) as sarea
                                from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_premium->dag_no,$case_no))->row();
                            }
                            else
                            {
                                $dag_area =$this->db->query("SELECT sum(lm_area_b*100+lm_area_k*20+lm_area_lc) as sarea
                                from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_premium->dag_no,$case_no))->row();
                            }

                            $sum_area = $dag_area->sarea;
                        }

                        else
                        {
                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                            {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_premium->dag_no))->row();
                            }
                            else
                            {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_premium->dag_no))->row();
                            }

                            $sum_area = $dag_area->sarea;

                        }

                        if($exist_lc_type==1 && $proc_lc_cat_code==2)
                        {
                            if($sum_area<100)
                            {
                                $ratepr = 0;
                            }
                        }
                        }

                        $prem_zonal=$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no);
                        $prem_zonal1 = $this->utilityclass->getZonalValue($dag_premium->dist_code,$basic['uuid'],$dag_premium->dag_no);

                        $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                        {
                            $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
                        }
                        else
                        {
                            $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
                        }

                        $sumMbAmount+= $sum_area * $premium_zonal_per_lessa;

                         /////////penalty case////////

                        $dagPenaltyArr = [
                            'is_penalty' => $is_penalty,
                            'exit_lc_by_lm' => $exist_lc_type
                        ];
                        

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dag_premium->dag_no);
                        $this->db->update('reclass_dag_details', $dagPenaltyArr);

                        //*******check if data updated */
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                        
                    }

                    // var_dump($sumMbAmount);$this->db->trans_rollback();exit;

                        if($sumMbAmount != $this->input->post('finalamount'))
                        {
                            // var_dump("Amount mismatch!!!"); die;
                            // $this->db->trans_rollback();
                            // $this->session->set_flashdata('message', "Error #ERRAM0001: reclass Application not submitted case no # $application_no");
                            // log_message('error', '#ERRAM0001: Premium ghotala by LM, RTPS Case No '.$application_no);
                            // redirect(base_url() . "index.php/home");

                             $this->db->trans_rollback();
                            log_message('error', '#ERRAM0001: Updation failed in reclass_suite_basic RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRAM0001: Registration of Reclassification failed for case no,Fill the premium correctly : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }


                        foreach ($district['dags'] as $dag_premium) 
                        {

                        $fmd=array(
                            'case_no'=>$case_no,
                            'user_code'=>$this->session->userdata('user_code'),
                            'uuid'=>$basic['uuid'],
                            'dag_no'=>$dag_premium->dag_no,
                            'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                            'land_type'=>$this->input->post('land_type'.$dag_premium->dag_no),
                            'rate_type'=>$this->input->post('rate_type'.$dag_premium->dag_no),
                            'rate'=>$this->input->post('rate'.$dag_premium->dag_no),
                            'amount_dag'=>$this->input->post('amount'.$dag_premium->dag_no),
                            'final_amount'=>$this->input->post('finalamount'),
                            'due_amount'=>$this->input->post('totaldue'),
                            'total_lessa'=>$this->input->post('total_lessa'.$dag_premium->dag_no),
                            //'is_full_pay'=>$this->input->post('paymode'),
                            'is_final'=>1,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            //'approve_by'=>$this->input->post('approval'.$dag_premium->dag_no),

                        );

                        $insPremium = $this->db->insert('settlement_premium', $fmd);

                        if ($insPremium != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        } 
                    }
                }

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

                $partition_info = $this->reclassModel->getPartionInfo($case_no);//return
                $wet_land_info = $this->reclassModel->getWetLandInfo($case_no);
                $applicant_type = $this->input->post('applicant_type');

                $basicData = [
                    'partition_enable'=> $partition_info,
                    'wet_land'        => $wet_land_info,
                    'applicant_type'  => $applicant_type
                    
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('reclass_suite_basic', $basicData);

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1111: Updation failed in reclass_suite_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR1111: Registration of Reclassification failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }



                ////settlement Khas LM Report insert end

                if ($this->db->trans_status()==false) {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                } else {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to '.$pending_officer;
                    $status='M';
                    $task='LM';
                    $pen='CO';
                    // $pen=$pending_officer;
                    $case=$case_no;
                    $rtps_status=$this->basundhara3Model->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status=json_decode($rtps_status);
                    if (trim($rtps_status)!="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to ".$pending_officer." With Case No # ".$case_no);
                    redirect(base_url() . "index.php/home");
                }

            }

        }
    }


    public function getRate($exist_code,$proc_lc_code,$dag_no,$case_no,$nature_possession,$reclass_type,$total_lessa)
    {
        // var_dump($reclass_type);

        if($exist_code==1 && $nature_possession!=1)
        {
            // $json[] = array('prid' => 0, 'rate' => 0,'msg' =>'Penalty Case , Dag can not be recommended!!');
            // echo json_encode($json);
            // return;

            $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
            where id=?",array($proc_lc_code))->row();
            $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

            $lands = $this->db->query("select prid,rate from reclass_premium_rate 
            where exist_code='$exist_code' and prop_code='$proc_lc_cat_code' order by prid");

            $data = $lands->result();

            $case_no = str_replace("_", "/", $case_no);

            $sum_area = 0;

            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_no,'Y','N',0));

            //echo $this->db->last_query();

            if ($sql->num_rows()>=1) 
            {
                $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Not Recommended','is_penalty' =>'N','total_lessa'=>'0');
                echo json_encode($json);
                return;
            }

            else
            {
            if($reclass_type == "part_yes")
            {
                $sum_area = $total_lessa;
            }

            else
            {

                $sql2 = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ? ", array($case_no));
                $data2 = $sql2->row();


                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }
                else
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                if($dag_area->sarea!=$total_lessa)
                {
                    //return false;
                    $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Check details again!!','is_penalty' =>'Y','total_lessa' => $sum_area);
                    echo json_encode($json);
                    return;
                }

                $sum_area = $dag_area->sarea;
            }
            }

            // $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ? ", array($case_no,$dag_no));
            // $data2 = $sql2->row();


            // if(isset($data2))
            // {
            //     $sum_area = 0;
            //     if($data2->is_partition=='Y' && $data2->is_full_partition=='N')
            //         {
            //             $dist_code = $this->session->userdata('dist_code');
            //             if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            //             {
            //                 $dag_area =$this->db->query("SELECT sum(lm_area_b*6400+lm_area_k*320+lm_area_lc*20+lm_area_g) as sarea
            //                 from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
            //             }
            //             else
            //             {
            //                 $dag_area =$this->db->query("SELECT sum(lm_area_b*100+lm_area_k*20+lm_area_lc) as sarea
            //                 from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
            //             }

            //             $sum_area = $dag_area->sarea;
            //         }
            //     else
            //         {
            //             $dist_code = $this->session->userdata('dist_code');
            //             if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            //             {
            //                 $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
            //             }
            //             else
            //             {
            //                 $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
            //             }

            //             $sum_area = $dag_area->sarea;

            //         }
            // }

            if($exist_code==1 && $proc_lc_cat_code==2)
            {
                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($sum_area<6400)
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                    }
                    }
                    else
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                        }
                    }
                }
                else
                {
                    if($sum_area<100)
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                    }
                    }
                    else
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                        }
                    }
                }
            }
            else
            {
                $json = array();
                foreach ($data as $object) {
                $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                }
            }
            //var_dump($json);
            echo json_encode($json);
            return;
        }


        $case_no = str_replace("_", "/", $case_no);

        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_no,'Y','N',0));

        //echo $this->db->last_query();

        if ($sql->num_rows()>=1) 
        {
            $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Not Recommended','is_penalty' =>'N','total_lessa'=>'0');
            echo json_encode($json);
            return;
        }

        else
        {
            $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
            where id=?",array($proc_lc_code))->row();
            $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

            $lands = $this->db->query("select prid,rate from reclass_premium_rate 
            where exist_code='$exist_code' and prop_code='$proc_lc_cat_code' order by prid");

            $data = $lands->result();

            $sum_area = 0;
            if($reclass_type == "part_yes")
            {
                $sum_area = $total_lessa;
            }

            else
            {

                $sql2 = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ? ", array($case_no));
                $data2 = $sql2->row();

                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                else
                {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                // if($dag_area!=$total_lessa)
                // {
                //     return false;
                // }

                $sum_area = $dag_area->sarea;
            }

            // var_dump($proc_lc_cat_code);exit;

            if($exist_code==1 && $proc_lc_cat_code==2)
            {
                if($sum_area<100)
                {
                    $json = array();
                    foreach ($data as $object) {
                    $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                }
                }

                else
                {
                    $json = array();
                    foreach ($data as $object) {
                    $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Recommended','is_penalty' =>'N','total_lessa' => $sum_area);
                }
                }
            }

            else
            {
            $json = array();
            foreach ($data as $object) {
                $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Recommended','is_penalty' =>'N','total_lessa' => $sum_area);
            }
            }
            //var_dump($json);
            echo json_encode($json);
        }
    }

    function fetchRenderDataFromChitha(){
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $data['check_ren'] = $this->input->post('check_ren');

        $data['err_msg'] = '';
        $data['err'] = false;

        if($data['check_ren'] == 'false'){
            $this->load->view('reclass_suite/pattadar_partition_render_details', $data);
        }


        $sql = $this->db->query('select rdd.*,ra.pdar_id from reclass_dag_details rdd join reclass_applicant ra on rdd.case_no=ra.case_no
        and rdd.dag_no=ra.dag_no where rdd.case_no = ? and rdd.dag_no = ?', array($case_no, $dag_no));

        if($sql->num_rows() <= 0 ){

            $data['err'] = true;
            $data['err_msg'] =  '#ERRR2442: No data found!';
            $this->load->view('reclass_suite/pattadar_partition_render_details', $data);

        }

        $dag_details_row_r = $sql->result();

        $pdar_array= array();
        foreach ($dag_details_row_r as $key => $dag_details_row) {
            $get_pattadars_sql = $this->db->query("select cp.pdar_id,cp.pdar_name, cp.pdar_father, cdp.dag_no 
            from chitha_pattadar cp join chitha_dag_pattadar cdp on cp.dist_code=cdp.dist_code and cp.subdiv_code=cdp.subdiv_code
            and cp.cir_code=cdp.cir_code and cp.mouza_pargona_code=cdp.mouza_pargona_code and cdp.lot_no=cp.lot_no and cp.pdar_id=cdp.pdar_id and cp.patta_no=cdp.patta_no and cp.patta_type_code=cdp.patta_type_code and cp.vill_townprt_code=cdp.vill_townprt_code 
            where cdp.dist_code=? and cdp.subdiv_code=?
            and cdp.cir_code=? and cdp.mouza_pargona_code=? and cdp.lot_no=? and cdp.vill_townprt_code=?
            and trim(cdp.patta_no)=? and cdp.patta_type_code=? and (cdp.p_flag != '1' or cdp.p_flag is null) and cdp.dag_no = ? and cdp.pdar_id = ?",array($dag_details_row->dist_code, $dag_details_row->subdiv_code, $dag_details_row->cir_code, $dag_details_row->mouza_pargona_code, $dag_details_row->lot_no, $dag_details_row->vill_townprt_code, $dag_details_row->patta_no, $dag_details_row->patta_type_code, $dag_no,$dag_details_row->pdar_id));

            if($get_pattadars_sql->num_rows() <= 0)
            {
               //echo $this->db->last_query();exit;

                $data['err'] = true;
                $data['err_msg'] =  '#ERRR343432442: No data found!';
                $this->load->view('reclass_suite/pattadar_partition_render_details', $data);
            }
            $pdar_array[]= $get_pattadars_sql->row();
        }
        $data['dd_row'] = $dag_details_row_r[0];
        $data['pattadars_array'] = $pdar_array;
        // var_dump($pdar_array);exit;
        $this->load->view('reclass_suite/pattadar_partition_render_details', $data);
    }



    //****update settlement_applicant*** */
    public function updateDagEligibleDetails()
    {
        //****getting the data  */
        $is_prime = $this->input->post('is_prime');
        $is_unfit = $this->input->post('is_unfit');
        $is_notcult = $this->input->post('is_notcult');
        $is_reclass = $this->input->post('is_reclass');
        //$is_masterplan = $this->input->post('is_masterplan');

        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');

        // var_dump($_FILES);exit;

        // if ($this->input->post('is_prime') == 'no')
        // {
        //     $timestamp = date('mdYhis', time()).uniqid();
        //     $doc_file = $_FILES['recommendedDocument'];

        //     $_FILES['file']['name'] = $_FILES['recommendedDocument']['name'];
        //     $_FILES['file']['type'] = $_FILES['recommendedDocument']['type'];
        //     $_FILES['file']['tmp_name'] = $_FILES['recommendedDocument']['tmp_name'];
        //     $_FILES['file']['error'] = $_FILES['recommendedDocument']['error'];
        //     $_FILES['file']['size'] = $_FILES['recommendedDocument']['size'];

        //     $doc_file_name = $timestamp;


        //     $mime = mime_content_type($_FILES['recommendedDocument']['tmp_name']);
        //     $exp  = explode("/",$mime);
        //     $onlyExtension  = $exp[1];

        //     // var_dump($onlyExtension); die;

        //     $doc_upload_path = UPLOAD_DIR.$timestamp;
        //     $doc_upload_path = UPLOAD_DIR;
        //     // var_dump($doc_upload_path);exit;

        //     $config['upload_path']   = UPLOAD_DIR;
        //     $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
        //     $config['max_size']  = UPLOAD_MAX_SIZE;;
        //     $config['file_name'] = $doc_file_name;
        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);


        //     // if (!$this->upload->do_upload('file'))
        //     // {
        //     //    //error
        //     // }

        //     // if(!file_exists($doc_upload_path)){
        //     //     // error
        //     // }
        //     $config = [
        //         'upload_path'   => UPLOAD_DIR,
        //         'allowed_types' => UPLOAD_ALLOW_TYPE,
        //         'max_size'      => UPLOAD_MAX_SIZE, // 2MB limit
        //         'encrypt_name'  => TRUE, // Random file name for security
        //     ];
        //     $this->load->library('upload', $config);
        //     if ($this->upload->do_upload('file'))
        //         log_message('error',json_encode($this->upload->do_upload('file'))."#######File".$doc_upload_path.'.'.$onlyExtension

        //     );
        //                     {

        //                         $document= array(
        //                             'case_no'   => $case_no,
        //                             'file_name' => 'Cultivation Document',
        //                             'user_code' => $this->session->userdata('user_code'),
        //                             'dag_no'    => $dag_no,
        //                             'fetch_file_name' => $_FILES['file']['name'],
        //                             'file_type'  => $_FILES['file']['type'],
        //                             'file_path'  => $doc_upload_path.'.'.$onlyExtension,
        //                             'date_entry' => date('Y-m-d h:i:s'),
        //                             'mut_type'   => RECLASS_ID,
        //                         );

        //                         // save data in attachment file
        //                         $addMoreDocQuery = $this->db->insert('supportive_document',$document);

        //                         if($addMoreDocQuery != 1)
        //                         {
        //                             $this->db->trans_rollback();
        //                             log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

        //                             $this->session->set_flashdata('message', "#ERRADDDOC0001: Only PDF and Image files area allowed : ".$application_no);
        //                             redirect(base_url() . "index.php/home");
        //                             return false;
        //                         }

        //                     }
        // }


        if ($this->input->post('is_prime') == 'no')
        {
          $_FILES['file']['name']     = $_FILES['recommendedDocument']['name'];
          $_FILES['file']['type']     = $_FILES['recommendedDocument']['type'];
          $_FILES['file']['tmp_name'] = $_FILES['recommendedDocument']['tmp_name'];
          $_FILES['file']['error']    = $_FILES['recommendedDocument']['error'];
          $_FILES['file']['size']     = $_FILES['recommendedDocument']['size'];

          $mime = mime_content_type($_FILES['recommendedDocument']['tmp_name']);
          $exp  = explode("/",$mime);
          $onlyExtension  = $exp[1];

          $fileRename =  $this->UUID4() . '.' . $onlyExtension;

          $doc_upload_path = UPLOAD_DIR . $fileRename;

          $config['upload_path']   = UPLOAD_DIR;
          $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
          $config['max_size']      = UPLOAD_MAX_SIZE;;
          $config['file_name']     = $fileRename;
          $this->load->library('upload', $config);
          $this->upload->initialize($config);
          if ($this->upload->do_upload('file'))
          {
            $document= array(
              'case_no'   => $case_no,
              'file_name' => 'Cultivation Document',
              'user_code' => $this->session->userdata('user_code'),
              'dag_no'    => $dag_no,
              'fetch_file_name' => $_FILES['file']['name'],
              'file_type'  => $_FILES['file']['type'],
              'file_path'  => UPLOAD_DIR . $fileRename,
              'date_entry' => date('Y-m-d h:i:s'),
              'mut_type'   => RECLASS_ID,
            );

            // save data in attachment file
            $addMoreDocQuery = $this->db->insert('supportive_document',$document);

            if($addMoreDocQuery != 1)
            {
              $this->db->trans_rollback();
              log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

              $this->session->set_flashdata('message', "#ERRADDDOC0001: Only PDF and Image files area allowed : ".$application_no);
              redirect(base_url() . "index.php/home");
              return false;
            }

          }
        }






        // $data = array(
        //     'responseType' => 2,
        //     //'appnData' => $applicantDetailsArr,
        //     'msg' => "Encroacher data updated successfully...",
        // );
        // echo json_encode($data);

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');
        // $this->form_validation->set_rules('applicant_d_id', 'Applicant ID', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLDAGS00011:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();

        if ($this->input->post('is_prime') == 'yes') {
            $is_prime ='Y';
        } 
        if ($this->input->post('is_prime') == 'no') {
            $is_prime ='N';
        }

        if ($this->input->post('is_unfit') == 'yes') {
            $is_unfit ='Y';
        } 
        if ($this->input->post('is_unfit') == 'no') {
            $is_unfit ='N';
        }

        if ($this->input->post('is_notcult') == 'yes') {
            $is_notcult ='Y';
        } 
        if ($this->input->post('is_notcult') == 'no') {
            $is_notcult ='N';
        }

        if ($this->input->post('is_reclass') == 'yes') {
            $is_reclass ='Y';
        } 
        if ($this->input->post('is_reclass') == 'no') {
            $is_reclass ='N';
        }

        // if ($this->input->post('is_masterplan') == 'yes') {
        //     $is_masterplan ='Y';
        // } 
        // if ($this->input->post('is_masterplan') == 'no') {
        //     $is_masterplan ='N';
        // }


        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and status=0", array($case_no,$dag_no));
        //echo $this->db->last_query();

        if ($sql->num_rows() > 0) 
        {
            $del = $this->db->query("DELETE FROM reclass_dag_eligibility where case_no = ? and dag_no = ? and status=0", array($case_no,$dag_no));

            if($del <= 0)
            {
               $this->db->trans_rollback();
                log_message('error', '#RECLDAG00014: Update fail in reclass_dag_eligibility ' . $case_no);
                $data = array(
                    'responseType' => 0,
                    'msg' => "#RECLDAG00014: Update fail in reclass_dag_eligibility : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
        }

        $sql2 = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and status=1", array($case_no,$dag_no));
        //echo $this->db->last_query();

        if ($sql2->num_rows() > 0) 
        {
            $status = 2; //1 for first proceeding, 2 if reverted
            $fmddata= [
                        'status' => $status
                        ];
            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $dag_no);
            $this->db->update('reclass_dag_eligibility', $fmddata);

            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRORAGRINAGRI0002: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                $data = array(
                    'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }
        }


        $petition_no = $this->db->select()
            ->where('case_no', $case_no)
            ->get('reclass_suite_basic')->row()->petition_no;

        if ($this->input->post('is_prime') == 'no'){
            $document = array(
                'petition_no' => $petition_no,
                'case_no' => $this->input->post('case_no'),
                'is_prime_agri' => $is_prime,
                'is_unfit_culti' => $is_unfit,
                'is_not_culti_ten' => $is_notcult,
                'is_eligible' => $is_reclass,
                //'is_master_plan' => $is_masterplan,
                'dag_no' => $dag_no,
                'doc_agri_dept'=>$doc_upload_path,
                'is_agri_to_nonagri' => 'Y',
                'status'=>0
            );

        }else{
            $document = array(
                'petition_no' => $petition_no,
                'case_no' => $this->input->post('case_no'),
                'is_prime_agri' => $is_prime,
                'is_unfit_culti' => $is_unfit,
                'is_not_culti_ten' => $is_notcult,
                'is_eligible' => $is_reclass,
                //'is_master_plan' => $is_masterplan,
                'dag_no' => $dag_no,
                'is_agri_to_nonagri' => 'Y',
                'status'=>0
            );
        }


        $insertDagReclassdd = $this->db->insert('reclass_dag_eligibility', $document);

        //echo $this->db->last_query();exit;

        if($insertDagReclassdd != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#RECLDAG00012: Insertion fail in reclass_dag_eligibility ' . $case_no);
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLDAG00012: Update fail in settlement_applicant : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }



        // $dagDetailsEligibleArr = [
        //     'petition_no' => $petition_no,
        //     'case_no' => $this->input->post('case_no'),
        //     'is_prime_agri' => $is_prime,
        //     'is_unfit_culti' => $is_unfit,
        //     'is_not_culti_ten' => $is_notcult,
        //     'is_eligible' => $is_reclass,
        //     'is_master_plan' => $is_masterplan,
        //     'dag_no' => $dag_no
        // ];


        // $insertDagReclass = $this->db->insert('reclass_dag_eligibility', $dagDetailsEligibleArr);

        // if($insertDagReclass != 1)
        // {
        //     $this->db->trans_rollback();
        //     log_message('error', '#RECLDAG00012: Insertion fail in reclass_dag_eligibility ' . $case_no);
        //     $data = array(
        //         'responseType' => 0,
        //         'msg' => "#RECLDAG00012: Update fail in settlement_applicant : " . $case_no,
        //     );
        //     echo json_encode($data);
        //     return false;
        // }

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
                    'note_on_order' => $dag_no.'-Dag is made in-elligible',
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => 'CO',
                    'task' => 'LM report submitted'
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

                // $is_agri_to_nonagri = 'Y';


                // $dagDetailsArr = [
                //     'is_eligible' => $is_reclass,
                //     'is_agri_to_nonagri' => $is_agri_to_nonagri
                // ];
                

                // $this->db->where('case_no', $case_no);
                // $this->db->where('dag_no', $dag_no);
                // $this->db->update('reclass_dag_details', $dagDetailsArr);

                // //*******check if data updated */
                // if ($this->db->affected_rows() == 0) {
                //     $this->db->trans_rollback();
                //     log_message('error', '#RECLDAG00013: Update fail in reclass_dag_details ' . $case_no);
                //     $data = array(
                //         'responseType' => 0,
                //         'msg' => "#RECLDAG00013: Update fail in reclass_dag_details : " . $case_no,
                //     );
                //     echo json_encode($data);
                //     return false;
                //}

            $this->db->trans_commit();
            /**** if data intserted successfully*/
            $data = array(
                'responseType' => 2,
                //'appnData' => $applicantDetailsArr,
                'msg' => "Dag information updated successfully...",
            );
            echo json_encode($data);

    }

     public function updateDagNonagristatusDetails()
    {

        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');

        $is_reclass = $this->input->post('is_reclass');

         //var_dump($_POST);exit;

        $this->form_validation->set_error_delimiters('', '');
        // $this->form_validation->set_rules('applicant_d_id', 'Applicant ID', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
        $this->form_validation->set_rules('dag_no', 'Dag no', 'trim|required');
        $this->form_validation->set_rules('is_reclass', 'Reclass info', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLDAGS00021:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if($is_reclass=='yes')
        {
            $is_eligible = 'Y';
            $not_eligible_remark = null;
        }

        if($is_reclass=='no')
        {
            $remark = $this->input->post('remark');
            $is_eligible = 'N';
            $not_eligible_remark = $remark;
        }

        $this->db->trans_begin();

        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and status=0", array($case_no,$dag_no));
        //echo $this->db->last_query();

        if ($sql->num_rows() > 0) 
        {
            $del = $this->db->query("DELETE FROM reclass_dag_eligibility where case_no = ? and dag_no = ? and status=0", array($case_no,$dag_no));

            if($del <= 0)
            {
               $this->db->trans_rollback();
                log_message('error', '#RECLDAG00014: Update fail in reclass_dag_eligibility ' . $case_no);
                $data = array(
                    'responseType' => 0,
                    'msg' => "#RECLDAG00014: Update fail in reclass_dag_eligibility : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
        }

        $sql2 = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ? and status=1", array($case_no,$dag_no));
        //echo $this->db->last_query();

        if ($sql2->num_rows() > 0) 
        {
            $status = 2; //1 for first proceeding, 2 if reverted
            $fmddata= [
                        'status' => $status
                        ];
            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $dag_no);
            $this->db->update('reclass_dag_eligibility', $fmddata);

            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRORAGRINAGRI0002: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                $data = array(
                    'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }
        }


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
                    'note_on_order' => 'LRA made the dag not agri to non agri reclass',
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => 'CO',
                    'task' => 'LM note submitted'
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

        // $dagDetailsArr = [
        //             'is_agri_to_nonagri' => 'N',
        //             'is_eligible' => $is_eligible,
        //             'not_eligible_remark'=>$not_eligible_remark
        //             ];
                

        // $this->db->where('case_no', $case_no);
        // $this->db->where('dag_no', $dag_no);
        // $this->db->update('reclass_dag_details', $dagDetailsArr);

        // //*******check if data updated */
        // if ($this->db->affected_rows() == 0) {
        //     $this->db->trans_rollback();
        //     log_message('error', '#RECLDAG00013: Update fail in reclass_dag_details ' . $case_no);
        //     $data = array(
        //         'responseType' => 0,
        //         'msg' => "#RECLDAG00013: Update fail in reclass_dag_details : " . $case_no,
        //     );
        //     echo json_encode($data);
        //     return false;
        // }

        $petition_no = $this->db->select()
            ->where('case_no', $case_no)
            ->get('reclass_suite_basic')->row()->petition_no;


        $dag_details = array(
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'dag_no' => $dag_no,
                'is_agri_to_nonagri' => 'N',
                'is_eligible' => $is_eligible,
                'not_eligible_remark'=>$not_eligible_remark,
                'status'=>0
            );

        $insertDagReclassdd = $this->db->insert('reclass_dag_eligibility', $dag_details);

        // echo $this->db->last_query();exit;

        if($insertDagReclassdd != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#RECLAGRINONAGRI0001: Insertion fail in reclass_dag_eligibility ' . $case_no);
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLAGRINONAGRI0001: Update fail in settlement_applicant : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();

        $data = array(
                'responseType' => 2,
                //'appnData' => $applicantDetailsArr,
                'msg' => "Dag information updated successfully...",
            );
            echo json_encode($data);

    }


    public function checkForEligibility()
    {
        $case_no = $this->input->post('case_no');
        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ?", array($case_no));

        if ($sql->num_rows() <= 0) {

            $data = array(
                'responseType' => 0,
                'msg' => "#ELIGIBILITY001: Fill all the details for case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if ($sql->num_rows() > 0) {

            $sql2 = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and is_eligible = ?", array($case_no,'N'));

            if ($sql2->num_rows() > 0)
            {

            $data = array(
                'responseType' => 0,
                'msg' => "#ELIGIBILITY002: Case can not be recommended for case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
            }
        }
    }

}
