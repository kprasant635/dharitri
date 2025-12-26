<?php
class LabourLineModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('NcModel/tableModels/BasundharApplicationModel');
        $this->load->model('NcModel/tableModels/SettlementBasicModel');
        $this->load->model('NcModel/tableModels/SettlementApplicantModel');
        $this->load->model('NcModel/tableModels/SettlementNomineeModel');
        $this->load->model('NcModel/tableModels/SettlementAdditionalPropertyModel');
        $this->load->model('NcModel/tableModels/LocationModels');
        $this->load->model('NcModel/tableModels/ChithaBasicModel');
        $this->load->model('NcModel/tableModels/LandbankModel');
        $this->load->model('NcModel/tableModels/SettlementDagDetailsModel');
        $this->load->model('NcModel/NcLogicModel');
    }

    public function dbSwitchSession()
    {
        $CI = &get_instance();
        $CI->load->library('session');

        if ($CI->session->userdata('dist_code') == "02") {
            $CI->db = $CI->load->database('dha3', TRUE);
        } else if ($CI->session->userdata('dist_code') == "05") {
            $CI->db = $CI->load->database('dha1', TRUE);
        } else if ($CI->session->userdata('dist_code') == "10") {
            $CI->db = $CI->load->database('dha24', TRUE);
        } else if ($CI->session->userdata('dist_code') == "13") {
            $CI->db = $CI->load->database('dha2', TRUE);
        } else if ($CI->session->userdata('dist_code') == "17") {
            $CI->db = $CI->load->database('dha4', TRUE);
        } else if ($CI->session->userdata('dist_code') == "15") {
            $CI->db = $CI->load->database('dha5', TRUE);
        } else if ($CI->session->userdata('dist_code') == "14") {
            $CI->db = $CI->load->database('dha6', TRUE);
        } else if ($CI->session->userdata('dist_code') == "07") {
            $CI->db = $CI->load->database('dha7', TRUE);
        } else if ($CI->session->userdata('dist_code') == "03") {
            $CI->db = $CI->load->database('dha8', TRUE);
        } else if ($CI->session->userdata('dist_code') == "18") {
            $CI->db = $CI->load->database('dha9', TRUE);
        } else if ($CI->session->userdata('dist_code') == "12") {
            $CI->db = $CI->load->database('dha13', TRUE);
        } else if ($CI->session->userdata('dist_code') == "24") {
            $CI->db = $CI->load->database('dha10', TRUE);
        } else if ($CI->session->userdata('dist_code') == "06") {
            $CI->db = $CI->load->database('dha11', TRUE);
        } else if ($CI->session->userdata('dist_code') == "11") {
            $CI->db = $CI->load->database('dha12', TRUE);
        } else if ($CI->session->userdata('dist_code') == "12") {
            $CI->db = $CI->load->database('dha13', TRUE);
        } else if ($CI->session->userdata('dist_code') == "16") {
            $CI->db = $CI->load->database('dha14', TRUE);
        } else if ($CI->session->userdata('dist_code') == "32") {
            $CI->db = $CI->load->database('dha15', TRUE);
        } else if ($CI->session->userdata('dist_code') == "33") {
            $CI->db = $CI->load->database('dha16', TRUE);
        } else if ($CI->session->userdata('dist_code') == "34") {
            $CI->db = $CI->load->database('dha17', TRUE);
        } else if ($CI->session->userdata('dist_code') == "21") {
            $CI->db = $CI->load->database('dha18', TRUE);
        } else if ($CI->session->userdata('dist_code') == "08") {
            $CI->db = $CI->load->database('dha19', TRUE);
        } else if ($CI->session->userdata('dist_code') == "35") {
            $CI->db = $CI->load->database('dha20', TRUE);
        } else if ($CI->session->userdata('dist_code') == "36") {
            $CI->db = $CI->load->database('dha21', TRUE);
        } else if ($CI->session->userdata('dist_code') == "37") {
            $CI->db = $CI->load->database('dha22', TRUE);
        } else if ($CI->session->userdata('dist_code') == "25") {
            $CI->db = $CI->load->database('dha23', TRUE);
        } else if ($CI->session->userdata('dist_code') == "39") {
            $CI->db = $CI->load->database('dha39', true);
        } else if ($CI->session->userdata('dist_code') == "38") {
            $CI->db = $CI->load->database('dha25', true);
        }
    }
    public function dbSwitchCode($dist_code)
    {
        $CI = &get_instance();
        if ($dist_code == "02") {
            $CI->db = $CI->load->database('dha3', TRUE);
        } else if ($dist_code == "05") {
            $CI->db = $CI->load->database('dha1', TRUE);
        } else if ($dist_code == "10") {
            $CI->db = $CI->load->database('dha24', TRUE);
        } else if ($dist_code == "13") {
            $CI->db = $CI->load->database('dha2', TRUE);
        } else if ($dist_code == "17") {
            $CI->db = $CI->load->database('dha4', TRUE);
        } else if ($dist_code == "15") {
            $CI->db = $CI->load->database('dha5', TRUE);
        } else if ($dist_code == "14") {
            $CI->db = $CI->load->database('dha6', TRUE);
        } else if ($dist_code == "07") {
            $CI->db = $CI->load->database('dha7', TRUE);
        } else if ($dist_code == "03") {
            $CI->db = $CI->load->database('dha8', TRUE);
        } else if ($dist_code == "18") {
            $CI->db = $CI->load->database('dha9', TRUE);
        } else if ($dist_code == "12") {
            $CI->db = $CI->load->database('dha13', TRUE);
        } else if ($dist_code == "24") {
            $CI->db = $CI->load->database('dha10', TRUE);
        } else if ($dist_code == "06") {
            $CI->db = $CI->load->database('dha11', TRUE);
        } else if ($dist_code == "11") {
            $CI->db = $CI->load->database('dha12', TRUE);
        } else if ($dist_code == "12") {
            $CI->db = $CI->load->database('dha13', TRUE);
        } else if ($dist_code == "16") {
            $CI->db = $CI->load->database('dha14', TRUE);
        } else if ($dist_code == "32") {
            $CI->db = $CI->load->database('dha15', TRUE);
        } else if ($dist_code == "33") {
            $CI->db = $CI->load->database('dha16', TRUE);
        } else if ($dist_code == "34") {
            $CI->db = $CI->load->database('dha17', TRUE);
        } else if ($dist_code == "21") {
            $CI->db = $CI->load->database('dha18', TRUE);
        } else if ($dist_code == "08") {
            $CI->db = $CI->load->database('dha19', TRUE);
        } else if ($dist_code == "35") {
            $CI->db = $CI->load->database('dha20', TRUE);
        } else if ($dist_code == "36") {
            $CI->db = $CI->load->database('dha21', TRUE);
        } else if ($dist_code == "37") {
            $CI->db = $CI->load->database('dha22', TRUE);
        } else if ($dist_code == "25") {
            $CI->db = $CI->load->database('dha23', TRUE);
        } else if ($dist_code == "39") {
            $CI->db = $CI->load->database('dha39', TRUE);
        } else if ($dist_code == "38") {
            $CI->db = $CI->load->database('dha25', TRUE);
        } else if ($dist_code == "22") {
            $CI->db = $CI->load->database('dha41', TRUE);
        } else if ($dist_code == "23") {
            $CI->db = $CI->load->database('dha40', TRUE);
        }
    }

    public function getSelfDocAPIData($application_no)
    {
        $curlUrl = API_LINK_NC . "getAppDetails";
        $token = $this->createTokenJwt();
        $curlData = $this->curlPost($curlUrl, array(
            'application_no' => $application_no,
            'api_key' => API_KEY,
            'token' => $token
        ));

        if ($curlData == false) {
            return $this->errorResp('ERRJS56', 'Unable to connect to Basundhara API!');
        }

        if (isset(json_decode($curlData)->responseType)) {
            if (json_decode($curlData)->responseType == 3) {
                return $this->errorResp('ERRJS66', 'Unauthorized access!!' . json_decode($curlData)->data, true);
            }
        }
        // return json_decode($curlData);

        return $this->successResp('SUCSJS09020257', 'Data successfully fetched...', false, 2, json_decode($curlData));
    }

    // show reject modal
    public function getRejectModal($service_code)
    {
        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, remark_head, service_code, reject_code, remark FROM reject_master WHERE flag=? and service_code=?", array('1', (string)$service_code));
        if ($sql->num_rows() > 0) {
            return $sql->result();
        } else {
            return 'n';
        }
    }


    public function getBasuApplIdFromCaseNo($case_no)
    {

        $CI = &get_instance();
        $d = $CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $applid = $CI->db->query("SELECT basundhara FROM basundhar_application 
                        WHERE dharitree=?", array($case_no));
        if ($applid->num_rows() <= 0) {
            return $applid = '';
        }
        return 'Basundhara : ' . $applid->row()->basundhara;
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no', $case)
            ->get('settlement_dag_details');

        return $dags->result();
    }

    public function getChithaFlaggedRemarks($dags, $rejected_list)
    {
        $dagFlagCheckChitha = '';
        foreach ($dags as $cd) {
            foreach ($rejected_list as $rej_list_key => $rej_list_chitha) {
                if ($rej_list_chitha->chitha_flag != 0) {

                    $chithaUuid = $this->utilityclass->getVillageUUID($cd->dist_code, $cd->subdiv_code, $cd->cir_code, $cd->mouza_pargona_code, $cd->lot_no, $cd->vill_townprt_code);

                    $resp = $this->utilityclass->getChithaFlagRemarks((string)$chithaUuid, (string)$cd->dag_no, $rej_list_chitha->chitha_flag);
                    if ($resp == true) {
                        $frech = '';
                        foreach ($resp as $pp) {
                            $frech .= $pp->remark . ", ";
                        }
                        $dagFlagCheckChitha .= "<div class='text-danger alert-warning pl-2 pr-2 pb-1'><b style='border-radius:2px; background:red; color:white; padding:3px;'>Dag No " . $cd->dag_no . " </b> &nbsp; <i class='fa fa-arrow-right' aria-hidden='true'></i> <span style='background:yellow; color:black; font-weight:500;'>This dag is flagged in Chitha with the followings - " . $frech . "</span></div>";
                        break;
                    }
                }
            }
        }
        return $dagFlagCheckChitha;
    }

    public function getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $CI = &get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $CI->db->query("select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    function encryptJwtCase($case_no)
    {
        $CI = &get_instance();
        $CI->output->set_header("Access-Control-Allow-Origin:*");
        $jwt = new JWT();
        $key = SECRET_KEY;
        $payload = $case_no;
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    function decryptJwtCase($token)
    {
        $CI = &get_instance();
        $jwt = new JWT();
        $key = SECRET_KEY;
        try {
            $decode = $jwt->decode($token, $key, 'HS256');
            return $decode;
        } catch (\Exception $e) {
            $CI->session->set_flashdata('message', "#ERR2222: Invalid Case Number!");
            redirect(base_url() . "index.php/home");
            return false;
        }
    }

    public function errorResp($code, $msg, $log = null)
    {
        $CI = &get_instance();
        if ($log == true) {
            log_message('error', '#' . $code . ': ' . $msg . '------>' . $CI->db->last_query());
        }

        return [
            'responseType'  => 0,
            'msg'           => '#' . $code . ': ' . $msg,
        ];
    }


    function checkExistDharitree($case_basu)
    {
        $sql = "Select count(*) as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
        $dataFound = $this->db->query($sql)->row();
        //echo json_encode($dataFound);
        if ($dataFound->c > 0) {
            $dataFound = $dataFound->c;
        } else {
            $dataFound = null;
        }
        //echo $dataFound;
        return $dataFound;
    }

    public function createRegistration($application_no, $curlOutput, $service_code, $service_name)
    {

        //****************generating case number********************
        $case_name = $this->genearteCaseName();
        if (empty($case_name)) {
            return $this->errorResp('ERRJS81', 'Unable to generate case number!');
        }
        //*******generating petition_no and case_no */
        $petition_no = $this->genearteSettlementPetitionNo();
        $case_no = $case_name . $petition_no . "/" . $service_name;

        //********basundhar_application insertation */
        $basuResp = $this->basundharInsert($case_no, $application_no);
        if ($basuResp['responseType'] != 2) {
            return $basuResp;
        }

        //********** Insertion in settlement_basic*/
        $basicResp = $this->settlementBasicInsert($case_no, $application_no, $petition_no, $curlOutput);
        if ($basicResp['responseType'] != 2) {
            return $basicResp;
        }

        //********** Insertion in settlement_applicant */
        $appResp = $this->settlementApplicantInsert($case_no, $application_no, $petition_no, $curlOutput);
        if ($appResp['responseType'] != 2) {
            return $appResp;
        }

        //***********Insertion in settlement_nominee */
        $nomResp = $this->settlementNomineeInsert($case_no, $curlOutput);
        if ($nomResp['responseType'] != 2) {
            return $nomResp;
        }
        //**********Insertion in settlement_additional_property */
        $addProResp = $this->settlementAdditionalPropertyInsert($case_no, $application_no, $service_code, $curlOutput);
        if ($addProResp['responseType'] != 2) {
            return $addProResp;
        }

        //*******overall success */
        return $this->successResp('SUCSJS091022', 'Application successfully registered...');
    }

    public function getAadhaarPhoto($application_no)
    {
        $applicants = $this->SettlementApplicantModel->get($application_no);

        if ($applicants->num_rows() <= 0) {
            return $this->errorResp('ERRJS020209', 'Applicant data not found!');
        }

        $applicants = $applicants->result();
        foreach ($applicants as $adhar_photo):
            if ($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if (!file_exists($adhar_photo_link)) {
                        $url = API_LINK_NC . "getApplicantPhoto";
                        $arrayData = array(
                            'application_no' => $application_no,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if ($aadhaarPhotoReCall == true) {
                            $aadhar_path = $adhar_photo_link;
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $aadhaarPhotoReCall;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        } else {
                            return $this->errorResp('ERRJS120209', 'API response failed!');
                        }
                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    return  $read_adhar_file;
                endif;
            endif;
        endforeach;
    }

    ///////////Case no using sequence//////////////
    function genearteCaseName()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        // $abbrname = $this->db->query($q)->row();

        $this->db->select('dist_abbr, cir_abbr');
        $this->db->from('location');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code !=', '00');
        $abbrname = $this->db->get()->row();

        if ($abbrname) {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/";
            return $case_no;
        }
        return false;
    }

    function genearteSettlementPetitionNo()
    {
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }

    private function basundharInsert($case_no, $application_no)
    {
        $basundhara = array(
            'dharitree'     => $case_no,
            'basundhara'    => $application_no,
            'date_reg'      => date('Y-m-d'),
            'reg_by'        => $this->session->userdata('user_code'),
            'app_status'    => 'M',
            'pending_with'  => 'LM'
        );

        $basundharAppInsert = $this->BasundharApplicationModel->insert($basundhara);

        if ($basundharAppInsert != true) {
            return $this->errorResp('ERRSET0003202', 'Something went wrong! Unable to process...', true);
        }
        return $this->successResp('SUCSJS091016', 'Dharitree relation created...');
    }

    private function settlementBasicInsert($case_no, $application_no, $petition_no, $curlOutput)
    {
        //****bhumiputra condition prepare for insertation */
        if (!empty($curlOutput->bhumi['0'])) {
            if ($curlOutput->bhumi['0']->bhumi_cert_available == 1) { //if bhumiputra available
                $bhumiputra_confirmation     = 'YES';
                $bhumiputra_certificate_no   = $curlOutput->bhumi['0']->bhumi_ack_no;
                $bhumiputra_certificate_type = 'CERT';
            } else if ($curlOutput->bhumi['0']->is_bhumi_applied == 1) { //if applied in bhumiputra
                $bhumiputra_confirmation     = 'YES';
                $bhumiputra_certificate_no   = $curlOutput->bhumi['0']->bhumi_ack_no;
                $bhumiputra_certificate_type = 'ACK';
            } else {
                $bhumiputra_confirmation     = '0';
                $bhumiputra_certificate_no   = '0';
                $bhumiputra_certificate_type = '0';
            }
        } else {
            $bhumiputra_confirmation     = '0';
            $bhumiputra_certificate_no   = '0';
            $bhumiputra_certificate_type = '0';
        }


        if ($curlOutput->application->is_urban == NULL or $curlOutput->application->is_urban == '') {
            return $this->errorResp('MR0202020', 'Something went wrong ! (Urban/Rural)');
        }
        $basicArray = array(
            'dist_code'                     => $curlOutput->application->dist_code,
            'subdiv_code'                   => $curlOutput->application->subdiv_code,
            'cir_code'                      => $curlOutput->application->cir_code,
            'mouza_pargona_code'            => $curlOutput->application->mouza_code,
            'lot_no'                        => $curlOutput->application->lot_no,
            'vill_townprt_code'             => $curlOutput->application->village_code,
            'service_code'                  => $curlOutput->application->service_code,
            'ref_no'                        => $curlOutput->application->ref_no,
            'case_no'                       => $case_no,
            'trans_code'                    => 'F',
            'petition_no'                   => $petition_no,
            'year_no'                       => date('Y'),
            'date_entry'                    => date('Y-m-d G:i:s'),
            'status'                        => 'Z',
            'user_code'                     => $this->session->userdata('user_code'),
            'submission_date'               => date('Y-m-d G:i:s'),
            'from_office'                   => 'API',
            'pending_officer'               => 'LM',
            'pending_office'                => 'CO',
            'occupation_applicant'          => $curlOutput->applicants[0]->applicant_occupation,
            'applid'                        => $curlOutput->application->application_no,
            'caste'                         => $curlOutput->applicants[0]->caste_category,
            'uuid'                          => $curlOutput->application->uuid,
            'protected_class'               => 0,
            'bhumiputra_confirmation'       => $bhumiputra_confirmation,
            'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
            'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
            'nc_is_urban'                   => $curlOutput->application->is_urban,
        );

        $resp = $this->SettlementBasicModel->insert($basicArray);

        if ($resp != true) {
            return $this->errorResp('ERR080419', 'Something went wrong! Unable to process...#' . $case_no, true);
        }
        return $this->successResp('SUCSJS091015', 'Basic data successfully saved...');
    }

    public function settlementApplicantInsert($case_no, $application_no, $petition_no, $curlOutput)
    {
        //*********** */ aadhaar photo api*******
        $url = API_LINK_NC . "getApplicantPhoto";
        $aadhaarPhotoApi = $this->curlPost($url, array(
            'application_no' => $application_no,
        ));

        if ($aadhaarPhotoApi != 'n') {
            $aadhaarPhotoApiPhoto = "<img src = data:" . $this->decodeBase64($aadhaarPhotoApi) . ";base64," . $aadhaarPhotoApi . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        $cron_no = $this->settlementApplicantCronNo($case_no);

        foreach ($curlOutput->settlements as $setl) {

            if ($aadhaarPhotoApiPhoto != 'n' && $setl->is_applicant == '1') {
                $timestamp = date('mdYhis', time()) . uniqid();
                $identity_doc_unique_name = str_replace('/', "-", $application_no . '_' . $timestamp);
                // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                $aadhaar_encoded_file = $aadhaarPhotoApiPhoto;
                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                fclose($aadhaar_file_to_write_base64);
            } else {
                $aadhar_path = '';
            }

            if ($curlOutput->aadhar->type == 'AADHAAR') {
                $identity_ref_no = $curlOutput->aadhar->aadhaar_no;
            } else {
                $identity_ref_no = $curlOutput->aadhar->pan_no;
            }

            $applicantArr = array(
                'dist_code'                 => $curlOutput->application->dist_code,
                'subdiv_code'               => $curlOutput->application->subdiv_code,
                'cir_code'                  => $curlOutput->application->cir_code,
                'mouza_pargona_code'        => $curlOutput->application->mouza_code,
                'lot_no'                    => $curlOutput->application->lot_no,
                'vill_townprt_code'         => $curlOutput->application->village_code,
                'user_code'                 => $this->session->userdata('user_code'),
                'case_no'                   => $case_no,
                'petition_no'               => $petition_no,
                'operation'                 => 'E',
                'dag_no'                    => 0,
                'patta_no'                  => 0,
                'patta_type_code'           => 0,
                'year_no'                   => date('Y'),
                'date_entry'                => date('Y-m-d'),
                'pdar_id'                   => '-1',
                'pdar_cron_no'              => (int) $cron_no++,
                'pdar_name'                 => $setl->name_ass,
                'pdar_guardian'             => $setl->gurdian_name_ass,
                'eng_pdar_name'             => $setl->name_eng,
                'eng_pdar_guardian'         => $setl->gurdian_name_eng,
                'pdar_rel_guar'             => $setl->gurdian_relation_id == null ? 0 : $setl->gurdian_relation_id,
                'pdar_gender'               => $setl->gender,
                'pdar_add1'                 => $setl->pre_add,
                'pdar_add2'                 => $setl->per_add,
                'pdar_mobile'               => $setl->mobile,
                'pdar_type'                 => $setl->pdar_type,
                'is_applicant'              => $setl->is_applicant,
                'identity_ref_no'           => $identity_ref_no,
                'identity_type'             => $curlOutput->aadhar->type,
                'identity_doc_link'         => $aadhar_path,
                'marital_status'            => $setl->marital_status,
                'dob'                       => $setl->dob,
                'under_tribe_belts'         => $setl->under_tribe_belts,
            );

            $inserResp = $this->SettlementApplicantModel->insert($applicantArr);

            if ($inserResp != true) {
                return $this->errorResp('ERRJS020508', 'Something went wrong! Unable to process...#' . $case_no, true);
            }
        }
        return $this->successResp('SUCSJS091015', 'Applicant details successfully saved...');
    }

    public function settlementNomineeInsert($case_no, $curlOutput)
    {
        if ($curlOutput->nextKin == true) {
            foreach ($curlOutput->nextKin as $nex_of_kin) {
                $nominee_data = array(
                    'case_no'       => $case_no,
                    'nominee_name'  => $nex_of_kin->next_of_kin_name,
                    'address'       => $nex_of_kin->address,
                    'mobile_no'     => $nex_of_kin->mobile_no,
                    'relation'      => $nex_of_kin->relation_with_kin
                );

                $insNominee = $this->SettlementNomineeModel->insert($nominee_data);
                if ($insNominee != true) {
                    return $this->errorResp('ERRJS080522', 'Something went wrong! Unable to process...#' . $case_no, true);
                }
            }
        }
        return $this->successResp('SUCSJS091014', 'Nominee successfully saved...');
    }


    public function settlementAdditionalPropertyInsert($case_no, $application_no, $service_code, $curlOutput)
    {
        $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($application_no));

        if ($checkAdditionalProperty->num_rows() == 0) {
            if (isset($curlOutput->property)) {
                foreach ($curlOutput->property as $value) {
                    $add_property = array(
                        'case_no'             => $case_no,
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
                        'service_id'          => $service_code,
                        'applied_flag'        => CITIZEN,
                        'dist_name'           => trim($value->dist_name),
                        'cir_name'            => trim($value->cir_name),
                        'vill_name'           => trim($value->vill_name),
                        'applid'              => $application_no,
                    );
                    $insAddProperty = $this->SettlementAdditionalPropertyModel->insert($add_property);

                    if ($insAddProperty != true) {
                        return $this->errorResp('ERRORJS080535', 'Something went wrong! Unable to process...#' . $case_no, true);
                    }
                }
            }
        }
        return $this->successResp('SUCSJS091013', 'Additional property successfully saved...');
    }


    public function successResp($code, $msg, $log = null, $respType = null, $data = null)
    {
        if ($log == true) {
            log_message('error', '#' . $code . ': ' . $msg);
        }
        if ($respType == null)
            $respType = 2;
        else
            $respType = $respType;

        return [
            'responseType'  => $respType,
            'code'          => $code,
            'msg'           => '#' . $code . ': ' . $msg,
            'data'          => $data,
        ];
    }

    public function settlementApplicantCronNo($case_no)
    {
        $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '" . $case_no . "'";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $cron_no = (int)$result->row()->pdar_cron_no + 1;
        } else {
            return $cron_no = 1;
        }
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


    function Total_ganda($bigha, $katha, $lessa, $ganda)
    {
        $total_ganda = $ganda + ($lessa * 20) + ($katha * 320) + ($bigha * 6400);
        return $total_ganda;
    }

    function Total_Lessa($bigha, $katha, $lessa)
    {
        $total_lessa = $lessa + ($katha * 20) + ($bigha * 100);
        return $total_lessa;
    }

    function Total_Bigha_Katha_Lessa($total_lessa)
    {
        $mm = 0;
        if ($total_lessa < 0) {
            $mm = 1;
            $total_lessa = abs($total_lessa);
        }
        $bigha = $total_lessa / 100;
        $rem_lessa = fmod($total_lessa, 100);
        $katha = $rem_lessa / 20;
        $r_lessa = fmod($rem_lessa, 20);
        $mesaure = array();
        $mesaure[] .= ($mm == 1) ? -floor($bigha) : floor($bigha);
        $mesaure[] .= ($mm == 1) ? -floor($katha) : floor($katha);
        $mesaure[] .= ($mm == 1) ? - ($r_lessa) : $r_lessa;
        $mesaure[] .= 0;
        return $mesaure;
    }

    function Total_Bigha_Katha_Lessa2($total_ganda)
    {
        $mm = 0;
        if ($total_ganda < 0) {
            $mm = 1;
            $total_ganda = abs($total_ganda);
        }

        $bigha = $total_ganda / 6400;
        $rem_ganda = $total_ganda % 6400;
        $katha = $rem_ganda / 320;
        $rem_ganda2 = $rem_ganda % 320;
        $chatak = $rem_ganda2 / 20;
        $rem_ganda3 =  $rem_ganda2 % 20;


        $mesaure = array();
        $mesaure[] .= ($mm == 1) ? -floor($bigha) : floor($bigha);
        $mesaure[] .= ($mm == 1) ? -floor($katha) : floor($katha);
        $mesaure[] .= ($mm == 1) ? -floor($chatak) : floor($chatak);
        $mesaure[] .= ($mm == 1) ? - (number_format($rem_ganda3, 4)) : number_format($rem_ganda3, 4);

        return $mesaure;
    }

    function createTokenJwt()
    {
        $timestamp = date("Y-m-d H:i:s");
        $CI = &get_instance();
        $CI->output->set_header("Access-Control-Allow-Origin:*");
        $jwt = new JWT();
        $key = SECRET_KEY;
        $payload = array(
            "timestamp" => $timestamp
        );
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    public function curlPost($url, $arrayData)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($arrayData));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if ($httpcode != 200 || $result == null) {
            return false;
        } else {
            return $result;
        }
    }



    //End of Model
}
