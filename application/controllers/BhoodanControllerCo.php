<?php
class BhoodanControllerCo extends CI_Controller
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
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('Bhoodan/CO/BhoodanCoModel');

        $this->load->model('AreaValidationModel');

        $this->dbswitch();
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#COKHAS2503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }


        if (HOLD_All_MB2_CASES_STATUS == 1) {
            if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
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



    // New area check By Masud Reza
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag) {
            $totalAreaInApplication = 0;
            $totalAreaInLMApplication = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict  = $dag->dist_code;
            $appSubDiv    = $dag->subdiv_code;
            $appCircle    = $dag->cir_code;
            $appMouza     = $dag->mouza_pargona_code;
            $appLot       = $dag->lot_no;
            $appVillage   = $dag->vill_townprt_code;
            $appDag       = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta     = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict,
                $appSubDiv,
                $appCircle,
                $appMouza,
                $appLot,
                $appVillage,
                $appDag,
                $appPattaType,
                $appPatta
            );

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict,
                $appSubDiv,
                $appCircle,
                $appMouza,
                $appLot,
                $appVillage,
                $appDag,
                $appPattaType,
                $appPatta
            );

            //  all lm processing application but  SDO/ADC/DC not proceeded
            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,
                $appSubDiv,
                $appCircle,
                $appMouza,
                $appLot,
                $appVillage,
                $appDag,
                $appPattaType,
                $appPatta,
                $application_no
            );


            if (in_array($appDistrict, json_decode(BARAK_VALLEY))) {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if ($totalAreaInChitha == 0) {
                    $areaCheck = 1;
                }
                if (($totalAreaInApplication + $totalAppliedAreaInApplication) == 0) {
                    $areaCheck = 1;
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication) {
                    $areaCheck = 1;
                }
            } else {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp) {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp) {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }
                if ($basic->dc_proceeding == 0) {
                    // application area
                    foreach ($appliedDags as $singleAppArea) {
                        if ($chithaDag->dag_no == $singleAppArea->dag_no) {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if ($totalAreaInChitha == 0) {
                    $areaCheck = 1;
                }
                if (($totalAreaInApplication + $totalAppliedAreaInApplication) == 0) {
                    $areaCheck = 1;
                }
                if ($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication) {
                    $areaCheck = 1;
                }
            }

            $lmProcessArea[]          = $allLmProcess;
            $chithaDagArray[]         = $chithaDag;
            $allApplicationDagArray[] = $allApplicationDags;
        }

        $checkAreaDetail = array(
            'chithaArea'    => $chithaDagArray,
            'reservedArea'  => $allApplicationDagArray,
            'lmProcessArea' => $lmProcessArea,
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
        );


        return $checkAreaDetail;
    }




    // Settlement Khas CO view starts here -md-
    public function bhoodanCo()
    {
        $application_no  = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');


        if ($user_desig_code == 'CO') {
            $this->utilityclass->authCheckCoSk($application_no, 'CO');
            $this->utilityclass->checkUserAuthForCaseForCo($application_no);
        } else {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $basic                 = $this->BhoodanCoModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->BhoodanCoModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->BhoodanCoModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->BhoodanCoModel->getAllApplicantEncroacher($application_no);
        $lmdata                = [];
        $dags                  = $this->BhoodanCoModel->getSettlementDag($application_no);
        $lmnotes               = $this->BhoodanCoModel->getSettlementTenantLmNote($application_no);
        $proceedings           = $this->BhoodanCoModel->getSettlementProceeding($application_no);
        $dhardocuments         = $this->BhoodanCoModel->getDocuments($application_no);
        $nominee               = $this->BhoodanCoModel->getAllNomineeDetail($application_no);

        $lmdata['basic']                 = $basic;
        $lmdata['nominee']               = $nominee;
        $lmdata['applicants_buyers']     = $applicants_buyers;
        $lmdata['applicants_owners']     = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;

        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

        foreach ($lmdata['applicants_buyers'] as $adhar_photo):
            if ($adhar_photo->is_applicant == 1 && IS_PRODUCTION == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if (!file_exists($adhar_photo_link)) {
                        //****Directory Change */
                        $parts = explode("uploads/", $adhar_photo_link, 2);
                        if (count($parts) > 1) {
                            $path = BACKUP_DIR . "uploads/" . $parts[1];
                        } else {
                            $path = $adhar_photo_link;
                        }

                        if (!file_exists($path)) {
                            $url = API_LINK_MB3 . "getApplicantPhoto";
                            $arrayData = array(
                                'application_no' => $applid,
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
                                echo json_encode(array('ERROR885784: API Response fail!'));
                                return false;
                            }
                        } else {
                            $adhar_photo_link = $path;
                        }
                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $lmdata['base64_decoded_adhar_file'] = "<img src = data:" . $this->decodeBase64($read_adhar_file) . ";base64," . $read_adhar_file . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                endif;
            endif;
        endforeach;


        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->BhoodanCoModel->getJsonDataFromBackup($application_no);
        if (isset($getJsonBackup)) {
            if ($getJsonBackup) {
                $json_settlement =  json_decode($getJsonBackup->data);

                foreach ($json_settlement->settlements as $jsonSettle) {
                    if ($jsonSettle->is_applicant == 1) {
                        $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
                        $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                    }
                }
            }
        }

        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;

        // $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        // $basundhara = $this->db->query($sql)->row();
        // $token = $this->utilityclass->createTokenJwt();
        // $curl_handle = curl_init();
        // curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //     'application_no' => $basundhara->basundhara,
        //     'api_key' => API_KEY,
        //     'token' => $token
        // )));
        // $output = curl_exec($curl_handle);
        // if(isset(json_decode($output)->responseType)){
        //     if(json_decode($output)->responseType == 3){
        //         echo json_decode($output)->data." - Unauthorized access!";
        //         return false;
        //     }
        // }
        // curl_close($curl_handle);
        // $output = json_decode($output);
        // $lmdata['document']=$output->documents;
        // $lmdata['query']=$output->query;
        // $lmdata['property']=$output->property;
        // $lmdata['aadhar']=$output->aadhar;
        // $lmdata['nextKin']=$output->nextKin;
        // foreach($output->selfDeclaration as $selfDec){
        //     $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        // }
        $lmdata['premium'] = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        $lmdata['additional_property'] = $this->BhoodanCoModel->getAdditionalProperty($application_no);

        foreach ($lmdata['applicants_encroacher'] as $applicant_enc) {
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

            if ($enc_check->num_rows() > 0) {
                $added_enc_data[] = $enc_check->row();
            }
        }
        if (isset($added_enc_data)) {
            $lmdata['new_added_enc_data'] = $added_enc_data;
        }

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if (trim($headQtrCheck) != 'Y') {

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if (trim($sdoCheckResult) == 'y') {
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            } else {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        } else {
            $lmdata['sdo_user_check'] = 'y';
        }

        $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

        if (isset($areaModificationCheck)) {
            if ($areaModificationCheck) {
                foreach ($areaModificationCheck as $areaHis) {
                    $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                    $applied_area_home_katha = $areaHis->applied_area_home_katha;
                    $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                    $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                    $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                    $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                    $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                    $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                    $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                    $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                    $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                    $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                    $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                    $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                    $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                    $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                    $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                    $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                    $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                    $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if (($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)) {

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    } else {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if (($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)) {

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }

        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

        $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name'] = $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc = $this->SettlementCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach ($deletedEnc as $encroacherDeleted_data) {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags = $this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach ($deletedDags as $deleteDag) {
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(BHODDAN_SERVICE_CODE);
        if ($rejected_data == 'n') {
            $lmdata['rejected_list'] = false;
        } else {
            $lmdata['rejected_list'] = $rejected_data;
        }


        foreach (json_decode(VALIDATION_BYPASS_BHOODAN) as $val_bypas) {
            if ($val_bypas->SERVICE_CODE == BHODDAN_SERVICE_CODE) {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $lmdata['validation_bypass'] = 0;

        foreach ($lmdata['lmnotes'] as $lm_rr) {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

            if ($decoded_r) {
                foreach ($decoded_r as  $lm_rejected_code) {
                    if (isset($lm_rejected_code->reject_code)) {
                        if (in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)) {
                            $lmdata['validation_bypass'] = 1;
                        }
                    } else {
                        if (in_array($lm_rejected_code, $const_bypass_arr_code)) {
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                }
            }
        }

        $lmdata['reject_list_type'] = '';

        foreach ($lmnotes as $r_remark) {
            $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

            if ($rejected_list_json) {
                foreach ($rejected_list_json as $re_list) {

                    if (isset($re_list->reject_code)) {
                        $r_code = $re_list->reject_code;
                    } else {
                        $r_code = $re_list;
                    }

                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                    if ($sql->row()->remark_head != null) {
                        $lmdata['reject_list_type'] = 'new';
                    } else {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }

        $adcUsers = $this->UtilsModel->adcSelect($this->session->userdata('dist_code'));
        $lmdata['adcUsers'] = $adcUsers;

        $lmdata['_view'] = 'Bhoodan/CO/bhoodan_write_report_co';
        $this->load->view('layouts/main', $lmdata);
    }

    public function generateNoticeCo()
    {
        // generate notice starts here
        if (isset($_POST['generate_notice'])) {
            // var_dump("m here"); die();
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);

            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,

            ];

            $this->load->view('SettlementView/Co/Tenant/SettlementNotice', $data);
            // var_dump($hearing_date);
            // die();
        }
        // to print notice
        if (isset($_POST['print_notice'])) {
            $case_no = $this->input->post('case_no');
            // getting the notice file link
            $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);

            $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_app_notice_link']);
            if ($path == false) {
                echo 'No data found!';
                return;
            }

            // reading the base64 json file and saving it to a variable
            $open_notice_file = fopen($path, "r") or die("Unable to open file!");
            $read_notice_file = fread($open_notice_file, filesize($path));
            fclose($open_notice_file);
            // decoding the base64 encoding file variable
            $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
            $data = [
                'base64_decoded_notice_file' => $base64decoded_notice_file,
            ];
            $data['_view'] = 'SettlementView/Co/Tenant/PrintNotice';
            $this->load->view('layouts/main', $data);
        }

        //******For co rejection  */
        // if(isset($_POST['co_rejection_agree']))
        // {
        //     if($_POST['co_rejection_agree'] == 'co_rejection_agree')
        //     {
        //         $case_no = $this->input->post('case_no');
        //         $designation = $this->session->userdata('user_desig_code');
        //         $user_code = $this->session->userdata('user_code');

        //         $this->db->trans_begin();

        //         //*******Delete from rejected_remark if exist */
        //         // $this->db->query('DELETE FROM rejected_remark WHERE case_no =? AND service_code = ? AND user_code = ?', array($case_no, $user_code));

        //         $sql = $this->db->query('SELECT lm_rejected_remarks FROM settlement_ap_lmnote WHERE case_no = ?', array($case_no));

        //         if($sql->num_rows() <= 0)
        //         {
        //             echo json_encode([
        //                 'responseType' => 0,
        //                 'msg' => '#ERR774121RRR: Something went wrong! Contact admin!',
        //             ]);
        //             $this->db->trans_rollback();
        //             return false;
        //         }

        //         $rejected_remarks = json_decode($sql->row()->lm_rejected_remarks);

        //         $rejectCodeArray = array();
        //         $getRemarkList = array();

        //         foreach($rejected_remarks as $rej)
        //         {
        //             $service_code = $rej->service_code;
        //             $reject_code = $rej->reject_code;
        //             $sub_rejected_remark = $rej->sub_rejected_remark;

        //             $getRemark = $this->db->query('SELECT remark FROM reject_master WHERE reject_code = ?', array($reject_code));

        //             if($getRemark->num_rows() <= 0)
        //             {
        //                 echo json_encode([
        //                     'responseType' => 0,
        //                     'msg' => '#ERR774322RRR: Something went wrong! Contact admin!',
        //                 ]);
        //                 $this->db->trans_rollback();
        //                 return false;
        //             }

        //             $remark = $getRemark->row()->remark;

        //             //*******insert into rejected_remark table*/
        //             $rejectedArray = [
        //                 'service_code'   => (string)$service_code,
        //                 'reject_code'    => (string)$reject_code,
        //                 'case_no'        => (string)$case_no,
        //                 'user_code'      => (string)$user_code,
        //                 'remark'         => (string)$remark,
        //                 'sub_remark'     => (string)$sub_rejected_remark,
        //                 'date_entry'     => date('Y-m-d'),
        //                 'datetime_entry' => date('Y-m-d H:i:s'),
        //             ];

        //             $insert = $this->db->insert('rejected_remark', $rejectedArray);
        //             // echo $this->db->last_query();

        //             if ($insert != 1) 
        //             {
        //                 $this->db->trans_rollback();
        //                 log_message('error', '#ERREJ0002: Insertion failed in rejected_remark and query is: ' . $this->db->last_query());

        //                 echo json_encode([
        //                     'responseType' => 0,
        //                     'msg' => '#ERREJ0002: Something went wrong! Contact admin!',
        //                 ]);
        //                 return false;
        //             }

        //             //******creating the array to hit API */
        //             $rejectCodeArray[] = [
        //                 'service_code' => $service_code,
        //                 'id'  => $reject_code,
        //                 'name' => $remark
        //             ];

        //             $getRemarkList[] = $remark. ($sub_rejected_remark != '' ? ': '.$sub_rejected_remark : '');
        //         }

        //         //****creating the comma separated remarks  */
        //         $rejectedReasonList = implode ( ", ", $getRemarkList );

        //         //*****update in settlement_basic */
        //         $basicArray = [
        //             'user_code'       => $user_code,
        //             'co_code'         => $user_code,
        //             'status'          => MB_DISMISS,
        //             'pending_office'  => $designation,
        //             'pending_officer' => $designation,
        //             'from_office'     => $designation,
        //             'dc_proceeding'   => 0,
        //             'rejected_flag'   => 1,

        //         ];
        //         $this->db->where('case_no', $case_no);
        //         $this->db->update('settlement_basic', $basicArray);

        //         if($this->db->affected_rows() <= 0)
        //         {
        //             $this->db->trans_rollback();
        //             log_message('error', '#ERREJ0001: Updating failed in settlement_basic and query is: ' . $this->db->last_query());

        //             echo json_encode([
        //                 'responseType' => 0,
        //                 'msg' => '#ERREJ0001: Something went wrong! Contact admin!',
        //             ]);
        //             return false;
        //         }

        //         //****Insertion into settlement_proceeding */

        //         $sqlProc = "select MAX(proceeding_id) as id from settlement_proceeding where case_no=?";
        //         $res = $this->db->query($sqlProc, array($case_no));

        //         if ($res->num_rows() > 0) 
        //         {
        //             $proceeding_id = $res->row()->id + 1;
        //         } 
        //         else 
        //         {
        //             $proceeding_id = 1;
        //         }

        //         $values = array(
        //             'case_no'              => $case_no,
        //             'proceeding_id'        => $proceeding_id,
        //             'date_of_hearing'      => date('Y-m-d h:i:s'),
        //             'next_date_of_hearing' => date('Y-m-d h:i:s'),
        //             'status'               => MB_DISMISS,
        //             'user_code'            => $user_code,
        //             'date_entry'           => date('Y-m-d G:i:s'),
        //             'operation'            => 'E',
        //             'note_type'            => $rejectedReasonList,
        //             'note_on_order'        => 'Rejected for: '.$rejectedReasonList,
        //             'ip'                   => $this->utilityclass->get_client_ip(),
        //             'office_from'          => $designation,
        //             'office_to'            => '',
        //             'task'                 => 'Rejected by ' . $designation,
        //         );

        //         $procInsert = $this->db->insert("settlement_proceeding", $values);

        //         if ($procInsert != 1) 
        //         {
        //             $this->db->trans_rollback();
        //             log_message('error', '#ERREJ0004: Insertion failed in settlement_proceeding.');

        //             echo json_encode([
        //                 'responseType' => 0,
        //                 'msg' => '#ERREJ0004: Something went wrong! Contact admin!',
        //             ]);
        //             return false;
        //         }

        //         ////////////// POST Reject status To basundhara ////////////////////
        //         $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        //         $rmk = 'Rejected by ' . $designation.': '.$rejectedReasonList;
        //         $status = 'R';
        //         $task = $designation;
        //         $pen  = 'NA';
        //         $task = trim($this->session->userdata('user_desig_code'));
        //         $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2nd($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);
        //         if ($rtps_status != "y")
        //         {
        //             $this->db->trans_rollback();
        //             log_message('error', '#ERREJ0005: API failed.');
        //             echo json_encode([
        //                 'responseType' => 0,
        //                 'msg' => '#ERREJ0005: Something went wrong! Contact admin!',
        //             ]);
        //             return false;
        //         }
        //         //////POST to Basundhara End

        //         $this->db->trans_commit();
        //         $this->session->set_flashdata('message', 'Case No. ' . $case_no . ' has been successfully rejected...');
        //         redirect(base_url() . "index.php/home");
        //     }
        // }

        //******disagree and revert to LM */
        if (isset($_POST['co_rejection_disagree'])) {
            if ($_POST['co_rejection_disagree'] == 'co_rejection_disagree') {
                $case_no = $this->input->post('case_no');
                $remark_co = 'Re-verify this case';
                $remark_co_type = '3';

                $this->db->trans_begin();

                $updateArr = [
                    'status' => 'R',
                    'co_code' => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d h:i:s'),
                    'from_office' => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office' => 'CO',

                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArr);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0001: Falied to revert back to LM');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
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
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Reverted Back to LM',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
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
                } else {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk = 'Reverted to LM';
                    $status = 'M';
                    $task = 'CO';
                    $pen = 'LM';
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                }
            }
        }

        // Revert back to LM stats here
        if (isset($_POST['revert_to_lm'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');

            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');
            $circle = $this->input->post('circle');
            $lot_no = $this->input->post('lot_no');
            $mouza = $this->input->post('mouza');
            $village = $this->input->post('village');
            $petitioner_name = $this->input->post('petitioner_name');
            $g_name = $this->input->post('g_name');
            $dag_name = $this->input->post('dag_name');

            $this->db->trans_begin();

            $updateArr = [
                'status' => 'R',
                'co_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'LM',
                'pending_office' => 'CO',

            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0001: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
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
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Reverted Back to LM',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
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
            } else {

                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk = 'Reverted to LM';
                $status = 'M';
                $task = 'CO';
                $pen = 'LM';
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                //var_dump($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
            }
        }

        if (isset($_POST['sk_forward_co'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co_note');

            $basic_status = $this->SettlementCommonModel->getCurrentBasicStatus($case_no);

            if ($basic_status == 'X') {
                $status = 'X';
            } else {
                $status = 'W';
            }

            $co_code = $this->input->post('co_code');

            $this->db->trans_begin();

            $updateArr = [
                'status' => $status,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'SK',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'sk_code' => $this->session->userdata('user_code'),
            ];

            if ($status == 'W') {
                $updateArr['co_code'] = $this->input->post('co_code');
            }

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO003303: Falied to forward to CO');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO003303: Falied to forward to CO. Kindly contact system administrator',
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
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co,
                'note_on_order' => $remark_co_text,
                'status' => $status,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'SK',
                'office_to' => 'CO',
                'task' => 'Forwarded to CO'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to foward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            } else {

                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk = 'Forwarded to CO';
                $status = 'M';
                $task = 'SK';
                $pen = 'CO';
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                //var_dump($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERR1245: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to CO");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //forward to DC starts here
        if (isset($_POST['forward_to_dc'])) {
            $case_no        = $this->input->post('case_no');
            $remark_co      = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district       = $this->input->post('district');
            $sub_division   = $this->input->post('sub_division');

            // var_dump($_POST); die;



            $this->db->trans_begin();


            // new code --- MR

            $sql = $this->db->query(
                "SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?",
                array($case_no, PRO_CASE_STATUS_REVERTED)
            );
            if ($sql->num_rows() > 0) {

                // update basic data
                $updateArrBasic = [
                    'co_code' => $this->session->userdata('user_code'),
                    'co_note_yn' => $remark_co_type,
                    'date_update' => date('Y-m-d h:i:s'),
                    'status'          => MB_SEND_TO_SDLAC,
                    'pending_office'  => MB_SDLAC,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_proceeding'   => 1,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO00032: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO00032: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                // update proposal case details
                $updatePro = [
                    'status' => PRO_CASE_STATUS_PENDING,
                    'co_submit' => 1
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('status', PRO_CASE_STATUS_REVERTED);
                $this->db->update('settlement_proposal_cases', $updatePro);

                // echo $this->db->last_query();
                // die;

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003343: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003343: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //////proceeding for CO//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'DC',
                    'task' => 'Forwarded to DC',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }


                //////proceeding for DC//////
                $proceeding_id_dc = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id_dc == null) {
                    $proceeding_id_dc = 1;
                }

                $insertArrDc = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'status' => MB_SEND_TO_SDLAC,
                    'note_on_order' => 'Send to SDLAC',
                    'office_from' => MB_DEPUTY_COMM,
                    'office_to'   => MB_DEPUTY_COMM,
                    'task' => 'Send to SDLAC'
                ];
                $insertProDC = $this->db->insert('settlement_proceeding', $insertArrDc);
                if ($insertProDC != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    echo json_encode($data);
                    return false;
                } else {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk = 'Send to SDLAC';
                    $status = 'M';
                    $task = MB_DEPUTY_COMM;
                    $pen = MB_DEPUTY_COMM;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERR1422: Forward to DC failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR




            // $applicants_riotee_nok = $this->BhoodanCoModel->getAllApplicantRioteeNok($case_no);
            // if ($applicants_riotee_nok == true) {
            //     foreach ($applicants_riotee_nok as $nok) {

            //         $insertData = [
            //             'dist_code' => $nok->dist_code,
            //             'subdiv_code' => $nok->subdiv_code,
            //             'cir_code' => $nok->cir_code,
            //             'mouza_pargona_code' => $nok->mouza_pargona_code,
            //             'lot_no' => $nok->lot_no,
            //             'vill_townprt_code' => $nok->vill_townprt_code,
            //             'dag_no' => $nok->dag_no,
            //             'tenant_name' => $nok->pdar_name,
            //             'tenants_father' => $nok->pdar_guardian,
            //             'tenants_add1' => 'addr1',
            //             'tenants_add2' => 'addr2',
            //             'type_of_tenant' => '1',
            //             'khatian_no' => $nok->khatian_no,
            //             'user_code' => $this->session->userdata('user_code'),
            //             'date_entry' => date('Y-m-d h:i:s'),
            //             'operation' => 'E',
            //         ];

            //         $insertChithaTenant = $this->db->insert('chitha_tenant', $insertData);
            //         if ($insertChithaTenant != 1) {
            //             $this->db->trans_rollback();
            //             log_message('error', '#ERRCO0045: Insertion failed in chitha_tenant');
            //             $json = [
            //                 'responseType' => 3,
            //                 'message' => '#ERRCO0045: Failed to generate notice. Kindly contact System Administrator',
            //             ];
            //             echo json_encode($json);
            //             return false;
            //         }
            //     }
            // }

            // foward to dc updates

            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if (trim($headQtrCheck) == 'Y') {
                $pending_officer = 'ADC';
                $pending_office  = 'DC';
            } else {
                $pending_officer = 'SDO';
                $pending_office  = 'DC';
            }

            //////proceeding if sk report not submitted//////
            if ($from_office_check == 'LM') {

                $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

                if ($proceeding_sk_check->num_rows() <= 0) {

                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insertArr = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'note_type' => '',
                        'note_on_order' => 'SK Report not submitted',
                        'status' => 'W',
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => 'CO',
                        'office_to' => 'CO',
                        'task' => 'SK Report not submitted.',
                    ];
                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                    if ($insertProc != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO000433: Insertion failed in settlement_proceeding');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO000433: Failed to forward to DC. Kindly contact System Administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }
            //////proceeding if sk report not submitted end//////



            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
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
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to ' . $pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
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
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk = 'Forwarded to ' . $pending_officer;
                $status = 'M';
                $task = 'CO';
                $pen = $pending_officer;
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERR1620: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to " . $pending_officer);
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }
    }

    //  -js- 02-09-2022
    public function saveNotice()
    {
        $case_no = $this->input->post('case_no');

        //$htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = CO_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $hearing_date = $this->input->post('hearing_date');
        $case_no = $this->input->post('case_no');
        $remark_co = $this->input->post('remark_co');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);

        $district = $this->input->post('district');
        $sub_division = $this->input->post('sub_division');
        $circle = $this->input->post('circle');
        $lot_no = $this->input->post('lot_no');
        $mouza = $this->input->post('mouza');
        $village = $this->input->post('village');
        $petitioner_name = $this->input->post('petitioner_name');
        $g_name = $this->input->post('g_name');
        $dag_name = $this->input->post('dag_name');
        $form_resub_check = $this->input->post('form_resub_check');

        $data = [
            'hearing_date' => $hearing_date,
            'case_no' => $case_no,
            'remark_co' => $remark_co,
            'get_settlement_basic' => $get_settlement_basic,
            'get_dag_details' => $get_dag_details,
            'get_settlement_applicant' => $get_settlement_applicant,

        ];

        $this->db->trans_begin();
        $updateArr = [
            'co_hearing_date' => $hearing_date,
            'co_code' => $this->session->userdata('user_code'),
            'status' => 'A',
            'notice_generated_yn' => 'Y',
            'notice_generated_date' => date('Y-m-d h:i:s'),
            'date_update' => date('Y-m-d h:i:s'),
            // 'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_app_notice_link' => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0005: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0005: Failed to generate notice. Kindly contact system administrator',
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
            'date_of_hearing' => $hearing_date,
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $remark_co,
            'status' => 'A',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0006: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0006: Failed to generate notice. Kindly contact System Administrator',
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
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Notice successfully saved...");
            redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);
        }
    }

    public function FirstProceeding()
    {
        $service_code = $this->input->get('service');

        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending($service_code);

        if (trim($status) == 'W') {
            $data['_view'] = 'Bhoodan/CO/first_proceeding_co_bulk';
        } else {
            $data['_view'] = 'settlement_mb/first_proceeding_co';
        }

        $this->load->view('layouts/main', $data);
    }

    public function generatePaymentNoticeCo()
    {
        if (isset($_GET['case'])) {
            $case_no = $this->input->get('case');

            // $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
            $res = array();
            $wetLand = 0;
            $sql = $this->db->query('select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,
                    (select wet_land from chitha_dag_all_flag_details_final  where dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no) from settlement_dag_details s where case_no = ?', array($case_no));

            $res = $sql->result();

            if (!empty($res)) {
                if (in_array(6, array_column($res, 'wet_land'))) {
                    $wetLand = 1;
                }
            }

            $case_under_wetland = $wetLand;

            // $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
            // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
            $get_settlement_basic = $this->db->query($query)->row();

            if ($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DC') {
                log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no ' . $case_no . 'and query is ' . $this->db->last_query());
                $error_msg_new = array('status' => 1, 'message' => '#ERROR1460: Dag no. found as wetland area please check chitha dag flag for case no' . $case_no);
                $this->session->set_flashdata('message', "--" . $error_msg_new['message']);
                redirect(base_url() . 'index.php/home/index');
            }

            if ($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 0 && $get_settlement_basic->from_office == 'DC') {
                log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no ' . $case_no . 'and query is ' . $this->db->last_query());
                $error_msg_new = array('status' => 1, 'message' => '#ERROR1460: Dag no.found as wetland area please check chitha dag flag for case no' . $case_no);
                $this->session->set_flashdata('message', "--" . $error_msg_new['message']);
                redirect(base_url() . 'index.php/home/index');
            }

            if ($case_under_wetland == 0 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DC') {
                //   ********** update basic wetland******* and insert into proceeding
                $this->db->trans_begin();

                $basicUpdateArr = [
                    'is_wed_land' => 0,
                    'date_update' => date('Y-m-d H:i:s'),
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicUpdateArr);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1490: Unable to update settlement_basic ' . $case_no . 'and query is ' . $this->db->last_query());
                    $error_msg_new = array('status' => 1, 'message' => '#ERROR1490: Unable to process for case no' . $case_no);
                    $this->session->set_flashdata('message', "--" . $error_msg_new['message']);
                    redirect(base_url() . 'index.php/home/index');
                }

                //*****insert into proceeding */
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => 'Wetland flag updated',
                    'note_on_order' => 'Wetland flag updated',
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Wetland flag updated',
                ];

                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);

                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1523: Unable to update settlement_proceeding ' . $case_no . 'and query is ' . $this->db->last_query());

                    $error_msg_new = array('status' => 1, 'message' => '#ERROR1523: Unable to process for case no' . $case_no);
                    $this->session->set_flashdata('message', "--" . $error_msg_new['message']);
                    redirect(base_url() . 'index.php/home/index');
                }

                $this->db->trans_commit();
            }

            //check whether dag in wetland--------------
            if ($case_under_wetland == 1) {
                // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
                if ($get_settlement_basic->from_office != 'DPT') {
                    log_message('error', '#ERROR990039876: Dag no. under wetland area and not approved by Dept Case No ' . $case_no);
                    $error_msg_new = array('status' => 1, 'message' => '#ERROR990039876: Dag no. under wetland area and not approved 
                    by Department for case no' . $case_no);
                    $this->session->set_flashdata('message', "--" . $error_msg_new['message']);
                    redirect(base_url() . 'index.php/home/index');
                }
            }

            $this->db->trans_begin();
            $settlement_premium_insertion = $this->premiumReCalculation($case_no);

            $data['old_dag_flag_message'] = false;

            if ($settlement_premium_insertion != null && $settlement_premium_insertion['status'] == 3) {
                $data['old_dag_flag_message'] = '<h5 class="alert-danger text-danger text-center">Old dag area flag found for this case, please check premium amount and area, if found accurate then proceed. If you want to update the premium, you can use modification request</h5>';

                $data['old_dag_flag_button'] = '<div class="row justify-content-center">
                                                    <button type="submit" name="generate_notice" id="btnNotice" class="m-2 col-4 btn btn-success btn-sm">Agree with old premium and generate notice</button> 

                                                    <a href="' . base_url() . 'index.php/SettlementModification/caseListForPullRequest?service=16" type="button" id="disagree" class="m-2 col-4 btn btn-danger btn-sm">Request for modification</a>
                                                </div>';
            } else {
                if ($settlement_premium_insertion != null && $settlement_premium_insertion['status'] == 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR99003: Unable to re calculate premium. Case No ' . $case_no . 'and query is ' . $this->db->last_query());
                    $this->session->set_flashdata('message', "--" . $settlement_premium_insertion['message']);
                    redirect(base_url() . 'index.php/home/index');
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            // $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);
            $finalAreaCheck = $this->finalAreaCheck($case_no);
            if ($finalAreaCheck['responseType'] != 2) {
                $this->session->set_flashdata('message', "--" . $finalAreaCheck['msg']);
                redirect(base_url() . 'index.php/home/index');
            }

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            // $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
            $data['basic'] = $this->db->query($query)->row();


            $data['dags'] = $this->db->query("select sd.*,sr.bigha,sr.katha,sr.lessa,sr.ganda,sr.is_deleted,sp.total_lessa from settlement_dag_details sd 
            left join (select * from settlement_reservation where is_deleted=0) sr 
            on sd.case_no = sr.case_no and sr.dag_no = sd.dag_no
            join (select total_lessa,case_no,dag_no from settlement_premium where is_final=1) sp on sp.case_no=sd.case_no and sp.dag_no=sd.dag_no 
            where sd.case_no='$case_no'")->result();

            //*******general caste or reserve caste check */

            $data['caste'] = $get_settlement_basic->caste;

            $applicants_buyers   = $this->BhoodanCoModel->getAllApplicantBuyers($case_no);

            foreach ($applicants_buyers as $applicant) {
                if ($applicant->is_applicant == 1) {
                    $data['if_widow'] = $applicant->marital_status;
                }
            }

            if (!isset($data['if_widow'])) {
                log_message('error', '#ERROR151220231026: Marital status not found! ' . $case_no);
                $this->session->set_flashdata('message', "#ERROR151220231026: Something went wrong! 1861" . $case_no);
                redirect(base_url() . 'index.php/home/index');
            }

            $data['concessionCheck'] = false;
            $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', array($case_no, 1));

            if ($concenSql->num_rows() <= 0) {
                log_message('error', '#ERROR151220231155: Something went wrong! Unable to process... ' . $case_no);
                $this->session->set_flashdata('message', "#ERROR151220231155: Something went wrong! Unable to process " . $case_no);
                redirect(base_url() . 'index.php/home/index');
            }

            if ($concenSql->row()->concession == 'YES') {
                if (trim($data['caste']) == '6' && trim($data['if_widow']) != '4') {
                    $data['concessionCheck'] = '<span class="text-danger text-center"><h5><b>Applicant applied as general caste but LM had done the premium calculation for reserved caste category! Do you want to remove concession and recalculate premium OR Continue with concession?</b></h5></span>';

                    $data['concessionRecalculate'] = '<div class="row justify-content-center">
                                                    <button type="button" onclick="reCalculatePremiumWithOutConcession(\'' . $case_no . '\', \'NO\')" class="m-2 col-4 btn btn-success btn-sm">Re-Calculate Premium without Concession</button> 
    
                                                    <button type="submit" name="generate_notice" id="btnNotice" class="m-2 col-4 btn btn-warning btn-sm">Proceed with concession</button>
                                                </div>';
                }
            }

            $data['_view'] = 'Bhoodan/CO/generateNoticeViewNew';
            $this->load->view('layouts/main', $data);
        }
    }

    public function generatePaymentNoticeCoSave()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark_co');
        $applicant_buyer = $this->BhoodanCoModel->getAllApplicantBuyers($case_no);
        // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $get_settlement_basic  = $this->db->query($query)->row();

        $data = [
            'case_no' => $case_no,
            'remark' => $remark,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if ($get_settlement_basic->pull_request == '1') {
            $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to modification request active # " . $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        if (isset($applicant_buyer)) {
            foreach ($applicant_buyer as $applicant) {
                if ($applicant->is_applicant == 1) {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                    $marital_status = $applicant->marital_status;
                }
            }
        }

        $basic = $this->BhoodanCoModel->getSettlementBasic($case_no);

        if (isset($basic)) {
            // if ($basic['service_code'] == SETTLEMENT_TENANT_ID) {
            //     $data['service_name'] = 'Settlement Occupency Tenant';
            // } elseif ($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID) {
            //     $data['service_name'] = 'Settlement AP';
            // } elseif ($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
            //     $data['service_name'] = 'Settlement Tribal Community';
            // } elseif ($basic['service_code'] == BHODDAN_SERVICE_CODE) {
            //     $data['service_name'] = 'Settlement Khasland';
            // } elseif ($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID) {
            //     $data['service_name'] = 'Settlement PGR/VGR land';
            // } elseif ($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
            //     $data['service_name'] = 'Settlement Special Cultivators';
            // }

            $data['service_name'] = 'Settlement of erstwhile Bhoodan/Gramdan';

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            if ($basic['sdlac_date'] == null || $basic['sdlac_date'] == '' || empty($basic['sdlac_date'])) {
                $this->session->set_flashdata('message', "#ERR203934: Unable to process! Something went wrong...#" . $case_no);
                redirect(base_url() . 'index.php/home');
            }

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

            $data['dept_order_no'] = $basic['dept_order_no'];
            $data['dept_order_date'] = date('d/m/Y', strtotime($basic['dept_order_date']));
        } else {
            $this->session->set_flashdata('message', "#ERR1917: Unable to process! Something went wrong...#" . $case_no);
            redirect(base_url() . 'index.php/home');
        }

        $dags = $this->BhoodanCoModel->getSettlementDag($case_no);


        // $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
        $urbanByLm = $this->db->select('falls_und_gmc')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type, spr.mb_land, spr.max_land FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if ($premium_data->num_rows() > 0) {
            $caseUrban = null;
            $premium_data_row = $premium_data->row();
            $premium_data_arr = $premium_data->result();

            $oldDagArray = array(1, 2, 3, 4, 5, 6);

            $urbanArray = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
            $ruralArray = array(7, 8, 9, 10, 18, 19, 20, 21, 22);


            if (!isset($dags)) {
                //****show error */
                $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#" . $case_no);
                redirect(base_url() . 'index.php/home');
            }

            foreach ($dags as $dag_item) {
                $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));

                if ($premiumSql->num_rows() <= 0) {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#" . $case_no);
                    redirect(base_url() . 'index.php/home');
                }

                $premData = $premiumSql->row();

                if (in_array($premData->area_name, $urbanArray)) {
                    $caseUrban = "Y";
                } else if (in_array($premData->area_name, $ruralArray)) {
                    $caseUrban = "N";
                } else {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR20466: Something went wrong!...#" . $case_no);
                    redirect(base_url() . 'index.php/home');
                }
            }

            //*******for rural case */
            if ($caseUrban == 'N') {
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach ($premium_data_arr as $premium) {

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if (trim($premium->concession) == 'YES') {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        // $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
                        $data['premium_payable_without_concession'] = ceil($data['net_premium_payable'] / 0.75);
                        $data['concession_amount'] = ceil($data['premium_payable_without_concession'] * 0.25);
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                        $data['actual_premium'] = (float)$data['premium_payable_without_concession'];
                    } else {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                        $data['actual_premium'] += (float)$premium->amount_dag;
                    }

                    // $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                    } else {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                    $area_all_barak[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                }

                $data['area'] = implode(", ", $area_all);
                $data['area_barak'] = implode(", ", $area_all_barak);
                $data['dag_no'] = implode(", ", $dag_arr);

                if ($data['type_of_concession'] == '-') {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                } else {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
            if ($caseUrban == 'Y') /////consider as urban case
            {
                // if($urbanByLm->falls_und_gmc == YES)
                // {
                //     $this->session->set_flashdata('message', "#ERR2033: Case falls under 15km of GMC, unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                // if($basic['is_wed_land'] == null || $basic['is_wed_land'] == '' || empty($basic['is_wed_land']))
                // {
                //     $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
                //     if($case_under_wetland == 1)
                //     {
                //         $this->session->set_flashdata('message', "#ERR202044: Case falls under wetland, unable to process! Something went wrong...#".$case_no);
                //         redirect(base_url().'index.php/home');
                //     }
                // }

                // if(isset($basic['is_wed_land']) && $basic['is_wed_land'] == 1)
                // {
                //     $this->session->set_flashdata('message', "#ERR20388: Case falls under wetland, unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }


                if (($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date']))) {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#" . $case_no);
                    redirect(base_url() . 'index.php/home');
                }

                if ($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc'])) {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#" . $case_no);
                    redirect(base_url() . 'index.php/home');
                }

                if ($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date'])) {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#" . $case_no);
                    redirect(base_url() . 'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                // $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;

                $sl_counter = 1;

                foreach ($premium_data_arr as $premium) {

                    // if(trim($premium->concession) == 'YES')
                    // {
                    //     if($basic['caste'] == '6' && $marital_status !='4')
                    //     {
                    //         $this->session->set_flashdata('message', "#ERR2047: Applicant applied as general caste but LM had done the premium calculation for special caste category! #".$case_no);
                    //         redirect(base_url().'index.php/home');
                    //     }
                    // }
                    //newly add value-----------
                    // $sqlForZonalValue = $this->db->query("select dag_no,zone_id,subclass_id,
                    //                 (select MAX(land_rate) as new_zonal_value from villagewise_zone_info where
                    //                     unique_village_code = dzi.unique_village_code and zone_code::varchar=dzi.zone_id and subclass_name like 'Residential%' )
                    //                             from dagwise_zone_info dzi where dzi.unique_village_code = '$basic[uuid]' and dzi.dag_no='$premium->dag_no'");

                    // log_message('error',"----------Zonal Value Query-------".$this->db->last_query());
                    // $newZonalRow = $sqlForZonalValue->row();  
                    // //get zonal value from max land_rate from settlement -----------
                    // $premium_per_bigha = $newZonalRow->new_zonal_value;


                    $premium_per_bigha = $premium->zonal_valuation;

                    //$premium_per_bigha = $premium->zonal_valuation;// old zonal value-----------
                    $dag_no = $premium->dag_no;

                    $dag_arr[] = $premium->dag_no;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';


                        $area_all[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                    } else {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];

                        $area_all[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                    }

                    $data['first_area'] = implode(", ", $area_all);
                    $data['first_dag_no'] = implode(", ", $dag_arr);


                    $total_amount = $premium->amount_dag;

                    $mbAreaLimit = $premium->mb_land;
                    $maxLand = $premium->max_land;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {

                        if ($mbAreaLimit == 25) {
                            $mbAreaLimit = 1600;
                        } else if ($mbAreaLimit == 30) {
                            $mbAreaLimit = 1920;
                        } else if ($mbAreaLimit == 40) {
                            $mbAreaLimit = 2560;
                        }

                        if ($maxLand == 40) {
                            $maxLand = 2560;
                        } else if ($maxLand == 60) {
                            $maxLand = 3840;
                        }
                    }

                    if (in_array($premium->area_name, $oldDagArray)) {
                        //******if dist code kamrup metro (told by muzammil da) */
                        if ($get_settlement_basic->dist_code == '24') {
                            $mbAreaLimit = 25;

                            if ($premium->total_lessa > 25) {
                                $this->session->set_flashdata('message', "#ERR2192: Unable to process due to old dag area flag...#" . $case_no);
                                redirect(base_url() . 'index.php/home');
                            }
                        } else {
                            $mbAreaLimit = 30;
                            if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                $mbAreaLimit = 1920;
                            }


                            if ($premium->total_lessa > $mbAreaLimit) {
                                $this->session->set_flashdata('message', "#ERR2193: Unable to process due to old dag area flag...#" . $case_no);
                                redirect(base_url() . 'index.php/home');
                            }
                        }
                    }

                    //****getting the zonal value in lessa */
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $zonalValue = $premium_per_bigha / 6400;
                    } else {
                        $zonalValue = $premium_per_bigha / 100;
                    }

                    $exceed_area = false;
                    $exceed_premium_per_bigha = false;
                    $exceedPremium = false;

                    if (trim($premium->concession) == 'YES') {
                        if ($premium->rate == '100') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //****for 100% premium */ if applied area less than the mb limit area
                                // 30%
                                $limitPremium = $mbAreaLimit * $zonalValue;
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */
                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $total_amount = $total_amount / 0.75;
                                $concession_amount = floor($total_amount * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                            }
                        } else if ($premium->rate == '30') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = ($mbAreaLimit * ($zonalValue * 30 / 100));
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */

                                $allowedPremium = $total_lessa * ($zonalValue * 30 / 100);
                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($allowedPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = $allowedPremium;
                            }
                        } else if ($premium->rate == '10') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = $mbAreaLimit * ($zonalValue * 10 / 100);
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */

                                $allowedPremium = ($total_lessa * ($zonalValue * 10 / 100));
                                $type_of_concession = 'ST/SC/Widow/Person with disabilities';
                                $concession_amount = floor($allowedPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = $allowedPremium;
                            }
                        }
                    } else {
                        if ($premium->rate == '100') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //****for 100% premium */ if applied area less than the mb limit area
                                // 30%
                                $limitPremium = $mbAreaLimit * $zonalValue;
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */
                                // $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $total_amount = $total_amount;
                                // $concession_amount = floor($total_amount * 0.25);
                                // $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                            }
                        } else if ($premium->rate == '30') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = ($mbAreaLimit * ($zonalValue * 30 / 100));
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */
                                $total_amount = $total_amount;

                                // $allowedPremium = $total_lessa * ($zonalValue * 30/100);
                                // $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                // $concession_amount = floor($allowedPremium * 0.25);
                                // $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                // $total_amount = $allowedPremium;
                            }
                        } else if ($premium->rate == '10') {
                            if ($total_lessa  > $mbAreaLimit) {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = $mbAreaLimit * ($zonalValue * 10 / 100);
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150 / 100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                                } else {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;
                            } else {
                                //******if applied area is greather than the mb limit area  */
                                $total_amount = $total_amount;

                                // $allowedPremium = ($total_lessa * ($zonalValue * 10/100));
                                // $type_of_concession = 'ST/SC/Widow/Person with disabilities';
                                // $concession_amount = floor($allowedPremium * 0.25);
                                // $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                // $total_amount = $allowedPremium;
                            }
                        }

                        $type_of_concession = false;
                        $concession_amount = false;
                        $concession_mission_govt_notification_no = false;
                    }

                    $net_premium_payable = $premium->final_amount;

                    $loloCounter = 1;

                    $exceed_pre = '';
                    if ($exceedPremium != false) {
                        $loloCounter++;

                        $exceed_pre = '<tr>
                                            <td>
                                                <b><u>অতিৰিক্ত ভূমি</u></b> <br>
                                                <p style="line-height: 1.6!important;">
                                                * (' . $exceed_area . ') - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No.RDM-12011(17)/15/2022-LR-REV-R&DM/14  dtd 21-Aug-2023  আৰু File No. E-40550/5 dtd.20-Nov2023 মৰ্মে অনুমোদিত অতিৰিক্ত ভূমিৰ প্ৰিমিয়াম হিচাপে মাণ্ডলিক মূল্যৰ ১৫০% 
                                                </p>
                                            </td>
                                            <td>' . $exceed_premium_per_bigha . '</td>
                                            <td>' . $dag_no . '</td>
                                            <td style="white-space: nowrap;">' . $exceed_area . '</td>
                                            <td style="white-space: nowrap;" class="text-right pr-2">+₹ ' . $exceedPremium . '</td>
                                        </tr>';
                    }

                    $consc = '';
                    if ($type_of_concession != false) {
                        $loloCounter++;

                        $consc = '<tr>
                                    <td>
                                        <b><u>বিশেষ শ্ৰেণীৰ বাবে ৰেহাই</u></b> <br>
                                        <p style="line-height: 1.6!important;">
                                            অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 মৰ্মে  প্ৰিমিয়ামৰ ২৫% ৰেহাই ' . $area . ' লৈকে
                                        </p>
                                    </td>
                                    <td>' . $type_of_concession . '</td>
                                    <td>' . $dag_no . '</td>
                                    <td style="white-space: nowrap;">' . $area . '</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">-₹ ' . $concession_amount . '</td>
                                </tr>';
                    }

                    if ($premium->rate == '100') {
                        // আৰ.চি.চি. ঘৰ * ১ ক :/২ক:৫লে:/১০লে: লৈকে - মাণ্ডলিক মূল্যৰ ১০০% *অতিৰিক্ত ভূমি - মাণ্ডলিক মূল্যৰ ১৫০%

                        $trArr .= '<tr>
                                    <td rowspan="' . $loloCounter . '" class="text-center">' . $sl_counter++ . '</td>
                                    <td>
                                        <b><u>আৰ.চি.চি. ঘৰ</u></b>
                                        <br> 
                                        <p style="line-height: 1.6!important;">
                                        * ' . $area . ': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়াম হিচাপে মাণ্ডলিক মূল্যৰ ১০০%
                                        </p>
                                    </td>
                                    <td>' . $premium_per_bigha . '</td>
                                    <td>' . $dag_no . '</td>
                                    <td style="white-space: nowrap;">' . $area . '</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ ' . $total_amount . '</td>
                                </tr>
                                ' . $exceed_pre . $consc . '';
                    }

                    if ($premium->rate == '30') {
                        $trArr .=  '<tr>
                                        <td rowspan="' . $loloCounter . '" class="text-center">' . $sl_counter++ . '</td>
                                        <td>
                                            <b><u>অসম আৰ্হিৰ ঘৰ</u></b><br>
                                            
                                            <p style="line-height: 1.6!important;">* ' . $area . ': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়ামৰ ৰেহাই হাৰ হিচাপে মাণ্ডলিক মূল্যৰ ৩০%
                                            </p>
                                            
                                        </td>
                                        <td>' . $premium_per_bigha . '</td>
                                        <td>' . $dag_no . '</td>
                                        <td style="white-space: nowrap;">' . $area . '</td>
                                        <td style="white-space: nowrap;" class="text-right pr-2">+₹ ' . $total_amount . '</td>
                                    </tr>    
                                    
                                    ' . $exceed_pre . $consc . '';
                    }

                    if ($premium->rate == '10') {
                        $trArr .= '<tr>
                                        <td rowspan="' . $loloCounter . '" class="text-center">' . $sl_counter++ . '</td>
                                        <td>
                                            <b><u>চালি ঘৰ</u></b><br>
                                            <p style="line-height: 1.6!important;"> * ' . $area . ': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়ামৰ ৰেহাই হাৰ হিচাপে মাণ্ডলিক মূল্যৰ ১০%
                                            </p>

                                        </td>
                                        <td>' . $premium_per_bigha . '</td>
                                        <td>' . $dag_no . '</td>
                                        <td style="white-space: nowrap;">' . $area . '</td>
                                        <td style="white-space: nowrap;" class="text-right pr-2">+₹ ' . $total_amount . '</td>
                                    </tr>

                                    ' . $exceed_pre . $consc . '';
                    }
                }

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>প্ৰকৃত /চূড়ান্ত দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ ' . $net_premium_payable . '</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['tbody'] = $trArr;
            }
        } else {
            $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#" . $case_no);
            redirect(base_url() . 'index.php/home');
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);

        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        } else {
            // Handle case where responseType is not set or invalid JSON
            echo "Error: Invalid API response.";
            return false;
        }
        curl_close($curl_handle);
        $res = json_decode($output);


        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date'] . ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        // $this->load->helper('qrcode');
        // $base_64 = printQR('https://sewasetu.assam.gov.in/');
        // $data['qrcode'] = $base_64;

        $this->load->helper('qrcode');
        $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
        $data['qrcode'] = ',' . $base_64;

        // if(trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES)
        if ($caseUrban == 'N') /////consider as rural case
        {
            $this->load->view('Bhoodan/include/rural_notice_bhoodan.php', $data);
            // $this->load->view('SettlementView/include/urban_notice', $data);

            // $this->session->set_flashdata('message', "Rural Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
        }
        // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))

        if ($caseUrban == 'Y') /////consider as urbam case
        {
            $this->load->view('Bhoodan/include/urban_notice_bhoodan.php', $data);

            // $this->session->set_flashdata('message', "Urban Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
        }
    }

    public function printNotice()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        // $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);

        $res = $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_basic');

        $data['print_data'] =  $res->row_array();

        // reading the base64 json file and saving it to a variable
        $path = $this->downloadNotice($data['print_data']['co_notice_link']);
        if ($path == false) {
            echo 'No data found!';
            return;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file, filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
        ];
        $data['_view'] = 'Bhoodan/CO/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

    public function premiumNotice($case_no = null)
    {
        // $case_no = 'KAM/PAL/2022-23/3257/SKHAS';
        $applicant_buyer = $this->BhoodanCoModel->getAllApplicantBuyers($case_no);

        if (isset($applicant_buyer)) {
            foreach ($applicant_buyer as $applicant) {
                if ($applicant->is_applicant == 1) {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                }
            }
        }

        $basic = $this->BhoodanCoModel->getSettlementBasic($case_no);

        if (isset($basic)) {
            $data['service_name'] = BHODDAN_SERVICE_NAME;

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));
        }

        $dags = $this->BhoodanCoModel->getSettlementDag($case_no);

        if (isset($dags)) {
            foreach ($dags as $dag_item) {
                $data['isUrban'] = $dag_item->is_urban;
            }
        }

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if ($premium_data->num_rows() > 0) {
            $premium_data_arr = $premium_data->result();

            //*******for rural case */
            // if(trim($data['isUrban']) == 'N')
            if (trim($data['isUrban']) == 'Y') {
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach ($premium_data_arr as $premium) {

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if (trim($premium->concession) == 'YES') {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25 / 100);
                        $data['concession_amount'] = $data['net_premium_payable'] * 25 / 100;
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                    } else {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                    }

                    $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                    } else {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                    $area_all_barak[] =  'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                }

                $data['area'] = implode(", ", $area_all);
                $data['area_barak'] = implode(", ", $area_all_barak);
                $data['dag_no'] = implode(", ", $dag_arr);

                if ($data['type_of_concession'] == '-') {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                } else {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            if (trim($data['isUrban']) == 'Y') {
            }
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);

        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date'] . ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        $this->load->helper('qrcode');
        $base_64 = printQR('https://sewasetu.assam.gov.in/');
        $data['qrcode'] = $base_64;

        if (trim($data['isUrban']) == 'Y') {
            $this->load->view('SettlementView/include/rural_notice', $data);
        }
        if (trim($data['isUrban']) == 'Y') {
            // $this->load->view('SettlementView/Co/Khas/paymentNoticeUrban', $data);
        }
    }


    /// NEW LIST FOR RE_GEOTAG ----------------07092023
    public function reGeoTagCaseList()
    {
        $service_code = $this->input->get('service');
        $status = 'Z'; // in query it is checked as not equal to Z status/////
        $data['select_data'] = $this->SettlementCommonModel->locationSelectReGeotag($service_code, $status);
        $data['_view'] = 'settlement_mb/settlement_mb_re_geotag';
        $this->load->view('layouts/main', $data);
    }


    public function checkWhetherGeoTagorNot()
    {
        $case_no = $this->input->post('case_no');
        $applid = $this->input->post('applid');

        if ($case_no == null && $applid == null) {
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0002: Enable Re-geotag cancelled...!case no missing',
            ]);
            return false;
        }
        $url = API_LINK_MB3 . "requestRegeo";

        $arrayData = array(
            'application' => $applid,

        );
        log_message("error", "MB001: CALLING URL=======" . $url . "===PARAMETER===" . json_encode($arrayData));
        //*****API call again for geotag available */
        $getAvailable = $this->utilityclass->curlPost($url, $arrayData);


        if (isset($getAvailable) && !empty(json_decode($getAvailable)) && trim(json_decode($getAvailable)->status) == 'y') {
            //*****update in settlement_basic */
            $basicArray = [
                're_geotag_status'   => 1
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basicArray);
            if ($this->db->affected_rows() != 1) {
                log_message('error', '#ERRREGEO0001: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 3,
                    'msg' => '#ERRREGEO0001: Enable Re-geotag cancelled...!',
                ]);
                return false;
            }
            if ($this->db->affected_rows() == 1 && trim(json_decode($getAvailable)->status) == 'y') {
                echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Requested for Re-geotag for the case no --' . $case_no,
                ]);
                return false;
            }
        } else {
            log_message('error', '#ERRREGEO0003: Fetching data error');
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0003: Fetching data error',
            ]);
            return false;
        }
    }

    public function getZonalValueBySubclass()
    {
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $zone = $this->input->post('zone');
        $subclass = $this->input->post('subclass');
        if ($case_no == null || $dag_no == null || $zone == null || $subclass == null) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR77412121RRR: Something went wrong please try again...!',
                'data' => null
            ]);
            return false;
        }

        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $sql = "select vz.land_rate,vz.zone_name,vz.subclass_name,vz.zone_code,vz.subclass_code FROM dagwise_zone_info dz LEFT JOIN villagewise_zone_info vz ON dz.unique_village_code = vz.unique_village_code WHERE dz.flag = '1' AND vz.flag ='1' AND vz.zone_code = ? and vz.subclass_code = ? and dz.unique_village_code = ? AND vz.zone_code::int = dz.zone_id::int AND vz.subclass_code::int = dz.subclass_id::int";

        $queryData = $this->db->query($sql, array($zone, $subclass, $get_settlement_basic->uuid));
        log_message('error', '0--------------' . $this->db->last_query());
        if ($queryData->num_rows() > 0) {
            $queryData = $queryData->row();
            echo json_encode([
                'responseType' => 2,
                'msg' => null,
                'land_rate' => $queryData->land_rate
            ]);
            return false;
        } else {
            log_message('error', '#ERR774121RRR--------------' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR774121RRR: Zonal information not found...!',
                'data' => null
            ]);
            return false;
        }
    }


    public function paginationCoFirstBulk()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code             = $this->input->post('service');
        $search_term        = $this->input->post('search_term');
        $remark_cat         = $this->input->post('remark_cat');
        $reverted           = $this->input->post('reverted');
        $user_code          = $this->session->userdata('user_code');
        $payment_status     = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');
        $review_cat         = $this->input->post('review_cat');

        $status             = $this->input->post('status');
        $draw               = intval($this->input->post('draw'));
        $start              = intval($this->input->post('start'));
        $length             = intval($this->input->post('length'));
        $order              = $this->input->post('order');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

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
            0 => 'date_entry',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {
            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {
            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if ($review_cat == '1') {
            $this->db->where('a.old_case_no is null');
            $review_stat = 'Normal Case';
        } else {
            $this->db->where('a.old_case_no is not null');
            $review_stat = 'Review Case';
        }
        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        if (trim($reverted) == 'LM') {
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);
        } else if (trim($reverted) == 'ADC') {
            $this->db->where_not_in('a.pending_officer', array(MB_LOT_MONDOL, MB_CIRCLE_OFFICER));
        } else {
            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER));
        }
        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        } else {
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }

        if (trim($reverted) != 'ADC') {
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        } else {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        $this->db->from('settlement_basic a');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                $khas_link = '<a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/bhoodanCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
              write report</a>';

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',
                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),
                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $lmnoteRemark,
                    $review_stat,
                    $khas_link,
                );
            }

            $this->db->where('a.service_code', $s_code);

            if (!empty($remark_cat)) {
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM') {
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);
            } else if (trim($reverted) == 'ADC') {
                $this->db->where_not_in('a.pending_officer', array(MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER));
            } else {
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
                $this->db->select('(select \'0\') as lm_note');
            } else {
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            }

            if (trim($reverted) != 'ADC') {
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            } else {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );

            echo json_encode($response);
        } else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql = "Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code));
        $lot_array = array();
        if ($data->num_rows() > 1) {
            $sql1 = "Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1 = $this->db->query($sql1, array($dist_code, $subdiv_code, $cir_code, $user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code . '_' . $value->lot_no;
            }
        }
        $lot_string = null;
        if (!empty($lot_array) && $lot_array != null) {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error", "MB: LOT STRING====FOR CIRCLE==D" . $dist_code . "S" . $subdiv_code . "C" . $cir_code . "==" . json_encode($lot_string));
        return $lot_string;
    }



    public function reportSubmitFirsProceedingCo()
    {

        $redirect = base_url() . "index.php/BhoodanControllerCo/bhoodanCo?case=" . $this->input->post('case_no');


        //******disagree and revert to LM */
        if (isset($_POST['co_rejection_disagree'])) {
            if ($_POST['co_rejection_disagree'] == 'co_rejection_disagree') {
                $case_no = $this->input->post('case_no');
                $remark_co = 'Re-verify this case';
                $remark_co_type = '3';

                $this->db->trans_begin();

                $updateArr = [
                    'status' => 'R',
                    'co_code' => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d h:i:s'),
                    'from_office' => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office' => 'CO',

                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArr);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0001: Falied to revert back to LM');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
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
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Reverted Back to LM',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
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
                } else {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk = 'Reverted to LM';
                    $status = 'M';
                    $task = 'CO';
                    $pen = 'LM';
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                }
            }
        }

        // Revert back to LM stats here
        if (isset($_POST['revert_to_lm'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');

            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');
            $circle = $this->input->post('circle');
            $lot_no = $this->input->post('lot_no');
            $mouza = $this->input->post('mouza');
            $village = $this->input->post('village');
            $petitioner_name = $this->input->post('petitioner_name');
            $g_name = $this->input->post('g_name');
            $dag_name = $this->input->post('dag_name');

            $this->db->trans_begin();

            $updateArr = [
                'status' => 'R',
                'co_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'LM',
                'pending_office' => 'CO',

            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0001: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
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
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Reverted Back to LM',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
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
            } else {

                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk = 'Reverted to LM';
                $status = 'M';
                $task = 'CO';
                $pen = 'LM';
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                //var_dump($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
            }
        }


        //forward to DC starts here
        if (isset($_POST['forward_to_dc'])) {
            // $case_no        = $this->input->post('case_no');
            // $remark_co      = $this->input->post('remark_co');
            // $remark_co_type = $this->input->post('remark_co_type');
            // $district       = $this->input->post('district');
            // $sub_division   = $this->input->post('sub_division');

            $case_no        = $this->input->post('case_no');
            $remark_co      = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district       = $this->input->post('district');
            $sub_division   = $this->input->post('sub_division');
            $order_type     = $this->input->post('order_type');
            $adc_dc_code    = $this->input->post('adc_dc_code');

            $this->db->trans_begin();

            if ($adc_dc_code == '' || $adc_dc_code == null) {
                log_message('error', '#ERR3701: ADC selection is required !!!');
                $this->session->set_flashdata('message', "ERR3701: Please select ADC");
                redirect(base_url() . "index.php/home");
            }


            // get detail from settlement_ap_lm_note
            $lm_note = $this->db->query("SELECT lm_note FROM settlement_ap_lmnote WHERE case_no=?", array($case_no))->row()->lm_note;

            if ($lm_note != 2 && $remark_co_type != 2) // skip forward to adc 
            {
                // check area validation
                $area_validation = $this->AreaValidationModel->areaValidation($case_no);
                $area_validation = json_decode($area_validation);

                if ($area_validation->responseType == 3) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', $area_validation->message);
                    redirect($redirect);
                }
            }

            // die;

            $sql = $this->db->query(
                "SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?",
                array($case_no, PRO_CASE_STATUS_REVERTED)
            );
            if ($sql->num_rows() > 0) {
                // update basic data
                $updateArrBasic = [
                    'co_code'         => $this->session->userdata('user_code'),
                    'co_note_yn'      => $remark_co_type,
                    'date_update'     => date('Y-m-d h:i:s'),
                    'status'          => MB_SEND_TO_SDLAC,
                    'pending_office'  => MB_SDLAC,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_proceeding'   => 1,
                    'adc_code'        => $adc_dc_code,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO00032: Failed to forward to DC');
                    $this->session->set_flashdata('error', '#ERRCO00032: Failed to forward to DC. Kindly contact system administrator');
                    redirect($redirect);
                }

                // update proposal case details
                $updatePro = [
                    'status'    => PRO_CASE_STATUS_PENDING,
                    'co_submit' => 1
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('status', PRO_CASE_STATUS_REVERTED);
                $this->db->update('settlement_proposal_cases', $updatePro);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003343: Failed to forward to DC');
                    $this->session->set_flashdata('error', '#ERRCO0003343: Failed to forward to DC. Kindly contact system administrator');
                    redirect($redirect);
                }

                //////proceeding for CO//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no'               => $case_no,
                    'proceeding_id'         => $proceeding_id,
                    'date_of_hearing'       => date('Y-m-d h:i:s'),
                    'next_date_of_hearing'  => date('Y-m-d h:i:s'),
                    'note_type'             => $remark_co_type,
                    'note_on_order'         => $remark_co,
                    'status'                => 'W',
                    'user_code'             => $this->session->userdata('user_code'),
                    'date_entry'            => date('Y-m-d h:i:s'),
                    'operation'             => 'E',
                    'ip'                    => $this->utilityclass->get_client_ip(),
                    'office_from'           => 'CO',
                    'office_to'             => 'DC',
                    'task'                  => 'Forwarded to DC',
                    'co_order'              => $adc_dc_code,
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR3771: Insertion failed in settlement_proceeding');
                    $this->session->set_flashdata('error', '#ERR3771: Failed to forward to DC. Kindly contact system administrator');
                    redirect($redirect);
                }


                //////proceeding for DC//////
                $proceeding_id_dc = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id_dc == null) {
                    $proceeding_id_dc = 1;
                }

                $insertArrDc = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'status' => MB_SEND_TO_SDLAC,
                    'note_on_order' => 'Send to SDLAC',
                    'office_from' => MB_DEPUTY_COMM,
                    'office_to'   => MB_DEPUTY_COMM,
                    'task' => 'Send to SDLAC'
                ];
                $insertProDC = $this->db->insert('settlement_proceeding', $insertArrDc);
                if ($insertProDC != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR3804: Insertion failed in settlement_proceeding');
                    $this->session->set_flashdata('error', '#ERR3804: Failed to forward to DC. Kindly contact system administrator');
                    redirect($redirect);
                }

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', '#ERR3811: Error in submitting. Please try Again');
                    redirect($redirect);
                } else {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk = 'Send to SDLAC';
                    $status = 'M';
                    $task = MB_DEPUTY_COMM;
                    $pen = MB_DEPUTY_COMM;
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) != "y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERR1422: Forward to DC failed case no # $case_no");
                        redirect($redirect);
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                        redirect($redirect);
                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR




            // $applicants_riotee_nok = $this->BhoodanCoModel->getAllApplicantRioteeNok($case_no);
            // if ($applicants_riotee_nok == true) {
            //     foreach ($applicants_riotee_nok as $nok) {

            //         $insertData = [
            //             'dist_code' => $nok->dist_code,
            //             'subdiv_code' => $nok->subdiv_code,
            //             'cir_code' => $nok->cir_code,
            //             'mouza_pargona_code' => $nok->mouza_pargona_code,
            //             'lot_no' => $nok->lot_no,
            //             'vill_townprt_code' => $nok->vill_townprt_code,
            //             'dag_no' => $nok->dag_no,
            //             'tenant_name' => $nok->pdar_name,
            //             'tenants_father' => $nok->pdar_guardian,
            //             'tenants_add1' => 'addr1',
            //             'tenants_add2' => 'addr2',
            //             'type_of_tenant' => '1',
            //             'khatian_no' => $nok->khatian_no,
            //             'user_code' => $this->session->userdata('user_code'),
            //             'date_entry' => date('Y-m-d h:i:s'),
            //             'operation' => 'E',
            //         ];

            //         $insertChithaTenant = $this->db->insert('chitha_tenant', $insertData);
            //         if ($insertChithaTenant != 1) {
            //             $this->db->trans_rollback();
            //             log_message('error', '#ERRCO0045: Insertion failed in chitha_tenant');
            //             $json = [
            //                 'responseType' => 3,
            //                 'message' => '#ERRCO0045: Failed to generate notice. Kindly contact System Administrator',
            //             ];
            //             echo json_encode($json);
            //             return false;
            //         }
            //     }
            // }

            // foward to dc updates

            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if (trim($headQtrCheck) == 'Y') {
                $pending_officer = 'ADC';
                $pending_office  = 'DC';
            } else {
                $pending_officer = 'SDO';
                $pending_office  = 'DC';
            }

            //////proceeding if sk report not submitted//////
            if ($from_office_check == 'LM') {

                $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

                if ($proceeding_sk_check->num_rows() <= 0) {

                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insertArr = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'note_type' => '',
                        'note_on_order' => 'SK Report not submitted',
                        'status' => 'W',
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => 'CO',
                        'office_to' => 'CO',
                        'task' => 'SK Report not submitted.',
                    ];
                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                    if ($insertProc != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO000433: Insertion failed in settlement_proceeding');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO000433: Failed to forward to DC. Kindly contact System Administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }
            //////proceeding if sk report not submitted end//////



            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
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
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to ' . $pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
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
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk = 'Forwarded to ' . $pending_officer;
                $status = 'M';
                $task = 'CO';
                $pen = $pending_officer;
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERR1620: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to " . $pending_officer);
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }
    }


    public function paymentNoticeCo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        // $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_REQUEST);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $data['getPaymentNoticeCo'] = $this->db->get()->result_array();

        // $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }
        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code  and pending_officer = 'CO' AND status in ('VN','M') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $result = $this->db->query($sql)->result();
        } else {
            $result = null;
        }
        $data['select_data'] = $result;

        if ($service_code == 39) {
            if (in_array($dist_code, json_decode(PAYMENT_NOTICE_BULK_REQUEST_DIST))) {
                return $this->paymentNoticeCoNew();
            }
        }
    }

    public function paymentNoticeCoNew()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $status = $this->input->get('s'); //var_dump($status);die;
        $service_code = $this->input->get("service");

        // $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_REQUEST);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $data['getPaymentNoticeCo'] = $this->db->get()->result_array();


        // $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }
        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code  and pending_officer = 'CO' AND status in ('VN','M') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $res = $this->db->query($sql); //->num_rows()>0 ? $this->db->query($sql)->result() :null;

        if ($res->num_rows() > 0) {
            $result = $this->db->query($sql)->result();
        } else {
            $result = null;
        }
        $data['select_data'] = $result; //var_dump($result);die;
        $data['_view'] = 'Bhoodan/CO/payment_notice_co_new';
        $this->load->view('layouts/main', $data);
    }

    public function paymentNoticeCofirmationCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationCo($service_code);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $data['getPaymentConfirmationCo'] = $this->db->get()->result_array();

        // $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['select_data'] = $this->locationSelect($service_code, $status); //var_dump($data['select_data']);die;

        $data['_view'] = 'Bhoodan/CO/paymentConfirmationCases';
        $this->load->view('layouts/main', $data);
    }

    public function getLotsFromMouzaCo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');

        if (!empty($mouza_pargona_code)) {
            $this->db->select('loc_name, lot_no, vill_townprt_code');
            $this->db->from('location');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);

            if (!empty($lot_no)) {
                $this->db->where('lot_no =', $lot_no);
                $this->db->where('vill_townprt_code !=', '00000');
            } else {
                $this->db->where('lot_no !=', '00');
                $this->db->where('vill_townprt_code', '00000');
            }

            $query = $this->db->get();
            $result = $query->result();

            if (!empty($lot_no)) {
                echo json_encode([
                    'responseType' => 2,
                    'lot_details' => '',
                    'village_details' =>  $result


                ]);
            } else {
                echo json_encode([
                    'responseType' => 2,
                    'lot_details' =>  $result,
                    'village_details' => ''

                ]);
            }
        } else {
            echo json_encode([
                'responseType' => 2,
                'lot_details' =>  '',
                'village_details' =>  ''
            ]);
        }
    }

    public function getListofPaymentNoticeCases()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $user_code = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $urban_rural = $this->input->post('urban_rural');
        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

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
            0 => 'date_entry',
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

        // if(!empty($search)){
        //     // $this->db->like($s_terms, $search);
        //     $this->db->like('case_no', $search);
        // }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        // and (from_office='DC' OR from_office='ADC' OR from_office='SDO') and pending_officer='CO'

        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }

        //$premPercentage = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
        //$premRupees = array(7,8,9,10,18,19,20,21,22);

        $this->db->select('distinct(a.case_no), a.applid, a.service_code, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,b.lm_note');

        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.status', $status);
        $this->db->where('p.is_final', 1);
        $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
        //for urban case------------
        if ($urban_rural == 'U') {
            $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
            $this->db->where_in('p.area_name', $checkArea);
        } else if ($urban_rural == 'R') {
            $checkArea = array(7, 8, 9, 10, 18, 19, 20, 21, 22);
            $this->db->where_in('p.area_name', $checkArea);
        } else {
            $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17, 7, 8, 9, 10, 18, 19, 20, 21, 22);
            $this->db->where_in('p.area_name', $checkArea);
        }

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // log_message('error','------------'.$this->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if ($urban_rural == 'U') {
                    $ruralYesNo = 'N';
                    $case_type = 'DEPARTMENT';
                } else if ($urban_rural == 'R') {
                    $ruralYesNo = $rows->case_no;
                    $case_type = 'DC';
                } else {
                    $area_name = $this->getDepartmentDC($rows->case_no);
                    if (in_array($area_name, array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17))) {
                        $ruralYesNo = 'N';
                        $case_type = 'DEPARTMENT';
                    } else if (in_array($area_name, array(7, 8, 9, 10, 18, 19, 20, 21, 22))) {
                        $ruralYesNo = $rows->case_no;
                        $case_type = 'DC';
                    }
                }

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                $urbanLink = '<a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/verifyLandClassZone?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">Payment Notice</a>';

                $ruralLink = '<a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                Payment Notice</a>';

                $area_name = $this->getDepartmentDC($rows->case_no);

                $paymentNoticeLink = 'NA';

                if ($ruralYesNo == 'N' && $case_type == 'DEPARTMENT' && in_array($area_name, array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17))) {
                    $paymentNoticeLink = $urbanLink;
                } else {
                    $paymentNoticeLink = $ruralLink;
                }

                if ($status == MB_PAYMENT_REQUEST) {


                    $link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;
                }
                $json[] = array(
                    $ruralYesNo,
                
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $lmnoteRemark,
                    $case_type,
                    $link,

                );
            }

            $this->db->where('a.service_code', $s_code);
            if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }
            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            //for urban case------------
            if ($urban_rural == 'U') {
                $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
                $this->db->where_in('p.area_name', $checkArea);
            } else if ($urban_rural == 'R') {
                $checkArea = array(7, 8, 9, 10, 18, 19, 20, 21, 22);
                $this->db->where_in('p.area_name', $checkArea);
            } else {
                $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17, 7, 8, 9, 10, 18, 19, 20, 21, 22);
                $this->db->where_in('p.area_name', $checkArea);
            }

            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.status', $status);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('p.is_final', 1);

            $total_records = $this->db->count_all_results('settlement_basic a');
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

    public function verifyLandClassZone()
    {
        if (isset($_GET['case']) && $_GET['case'] != null) {
            $case_no = $this->input->get('case');
            $data['case_no'] = $case_no;
            //settlement basic details------------

            // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
            $get_settlement_basic = $this->db->query($query)->row();
            var_dump($get_settlement_basic);
            die;


            $get_dag_details      = $this->SettlementKhasModel->getSettlementDag($case_no);
            $sqlforzonal = "select zone_code,zone_name from zonal_master";
            $zonaldata = $this->db->query($sqlforzonal)->result();
            $data['zonal_list'] = $zonaldata;

            $sqlforSubclass = "select subclass_code,subclass_name from subclass_master";
            $subclassData = $this->db->query($sqlforSubclass)->result();
            $data['subclassData'] = $subclassData;
            // echo "<pre>";
            // var_dump($get_dag_details);
            // die;
            $selectedArray = array();
            if ((!empty($get_settlement_basic) && $get_settlement_basic != null) ||  (!empty($get_dag_details) && $get_dag_details != null)) {
                //getting land class and zone details-----------
                foreach ($get_dag_details as $key => $value) {

                    $premium_data = $this->db->query("select zonal_valuation,zone_code,subclass_code  FROM settlement_premium  where case_no=? and dag_no = ? and is_final= ?", array($case_no, $value->dag_no, 1))->row();

                    $sql = "select vz.zone_name,vz.subclass_name,vz.zone_code,vz.subclass_code FROM dagwise_zone_info dz LEFT JOIN villagewise_zone_info vz ON dz.unique_village_code = vz.unique_village_code WHERE dz.flag = '1' AND vz.flag ='1' AND dz.unique_village_code = ? AND dz.dag_no = ? AND vz.zone_code::int = dz.zone_id::int AND vz.subclass_code::int = dz.subclass_id::int";
                    $queryData = $this->db->query($sql, array($get_settlement_basic->uuid, $value->dag_no));
                    log_message('error', '---------last=========' . $this->db->last_query());
                    if ($queryData->num_rows() > 0) {

                        $rowData = $queryData->row();
                        $finalZoneCode = $rowData->zone_code;
                        $finalsubclassCode = $rowData->subclass_code;
                        if ($premium_data->zone_code != null) {
                            $finalZoneCode = $premium_data->zone_code;
                        }
                        if ($premium_data->subclass_code != null) {
                            $finalsubclassCode = $premium_data->subclass_code;
                        }
                        $selectedArray[$key]['dag_no']           = $value->dag_no;
                        $selectedArray[$key]['zone_name']        = $rowData->zone_name;
                        $selectedArray[$key]['zone_code']        = $finalZoneCode;
                        $selectedArray[$key]['subclass_name']    = $rowData->subclass_name;
                        $selectedArray[$key]['subclass_code']    = $finalsubclassCode;
                        $selectedArray[$key]['zonal_valuation']  = $premium_data->zonal_valuation;
                    } else {
                        $this->session->set_flashdata('message', "#ERR111: Zonal information not found! Contact admin...");
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                    // $selectedArray[] = $selectedArray;
                }
            } else {
                $this->session->set_flashdata('message', "#ERR110: some error occured! Contact admin...");
                redirect(base_url() . "index.php/home");
                return false;
            }
            // echo "<pre>";
            // var_dump($selectedArray);
            // die;

            $data['selectedArray'] = $selectedArray;


            $data['_view'] = 'SettlementView/include/verifyLandClassZone';
            $this->load->view('layouts/main', $data);
        }
    }

    public function getDepartmentDC($caseNo)
    {
        $sql = 'select area_name from settlement_premium where  case_no = ? and is_final = ?';
        $area_name = $this->db->query($sql, array($caseNo, 1))->row();
        if (isset($area_name) && $area_name != null) {
            return $area_name->area_name;
        } else {
            return null;
        }
    }
    public function coBulkPaymentNoticeGenerateAndSave()
    {
        var_dump($_POST);
        echo '888888888888888888888888888';
        die;
        // generate notice starts here

        $markedApplications = $this->input->post('selectMark');

        if (count($markedApplications) == 0) {
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if (count($markedApplications) > 10) {
            log_message("error", '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $remark_co = $this->input->post('remark_co');
        $completedCases = array();
        foreach ($markedApplications as $key => $value) {

            $case_no = $value;

            // $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);

            $res = array();
            $wetLand = 0;
            $sql = $this->db->query('select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no, (select wet_land from chitha_dag_all_flag_details_final  where dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no) from settlement_dag_details s where case_no = ?', array($case_no));

            $res = $sql->result();

            if (!empty($res)) {
                if (in_array(6, array_column($res, 'wet_land'))) {
                    $wetLand = 1;
                }
            }

            $case_under_wetland = $wetLand;

            //check whether dag in wetland--------------
            if ($case_under_wetland == 1) {
                // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

                $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
                $get_settlement_basic = $this->db->query($query)->row();


                if ($get_settlement_basic->from_office != 'DPT') {
                    log_message('error', '#ERROR990030987: Unable to re calculate premium. Case No ' . $case_no . 'and query is ' . $this->db->last_query());
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERROR990030987: Dag no. under wetland area and not approved by Department this case' . $case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
            }
            $dataPrint = $this->getPremiumNoticeDetailsByCaseNo($case_no);
            if ($dataPrint['pull_request_active'] == 1) {
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987654: Modification request enabled for this case' . $case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            $dataPrint['co_remarks'] = $remark_co;
            if ($dataPrint['isUrban'] == 'Y') {
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO09877: Urban Case premium notice will be available soon',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            $PayloadString = json_encode($dataPrint);

            $htmlString = $this->getPremiumNoticeGenerationString($PayloadString);

            if (isset($htmlString) && $htmlString != null && $htmlString != '') {

                $this->db->trans_begin();

                $this->savePaymentNoticeBulkByCO($case_no, $htmlString, $PayloadString, $completedCases);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    log_message('error', 'Something went wrong...transaction failed for case_no==' . $case_no);

                    return false;
                } else {
                    $this->db->trans_commit();
                    $completedCases[] = $case_no;
                }
            } else {
                log_message('error', "#ERRCO09877: Failed to generate htmlString for the case_no==" . $case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO09877: Failed to generate htmlString for the case_no==' . $case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
        }

        echo json_encode([
            'responseType' => 2,
            'message' => 'Payment Notice successfully generated for the selected cases...',
            'list' => json_encode($completedCases),
        ]);
    }

    public function getPremiumNoticeDetailsByCaseNo($case_no)
    {
        // $applicant_buyer = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
        $applicants = $this->db->select()
            ->where('case_no', $case_no)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');
        $applicant_buyer = $applicants->result();

        // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $get_settlement_basic = $this->db->query($query)->row();

        $data = [
            'case_no' => $case_no,
            // 'remark' => $remark,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if (isset($applicant_buyer)) {
            foreach ($applicant_buyer as $applicant) {
                if ($applicant->is_applicant == 1) {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                }
            }
        }

        // $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $basic = $this->db->select()
            ->where('case_no', $case)
            ->get('settlement_basic');
        $basic = $basic->row_array();

        $data['pull_request_active'] = $basic['pull_request'];

        if (isset($basic)) {
            if ($basic['service_code'] == SETTLEMENT_TENANT_ID) {
                $data['service_name'] = 'Settlement Occupency Tenant';
            } elseif ($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID) {
                $data['service_name'] = 'Settlement AP';
            } elseif ($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
                $data['service_name'] = 'Settlement Tribal Community';
            } elseif ($basic['service_code'] == SETTLEMENT_KHAS_LAND_ID) {
                $data['service_name'] = 'Settlement Khasland';
            } elseif ($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID) {
                $data['service_name'] = 'Settlement PGR/VGR land';
            } elseif ($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
                $data['service_name'] = 'Settlement Special Cultivators';
            }

            $data['case_no'] = $basic['case_no'];
            $data['application_no'] = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));
        }

        // $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
        $sql = $this->db->select()
            ->where('case_no', $case)
            ->get('settlement_dag_details');
        $dags = $sql->result();


        if (isset($dags)) {
            foreach ($dags as $dag_item) {
                $data['isUrban'] = $dag_item->is_urban;
            }
        }

        // $this->load->model('SettlementMb/SettlementCommonDcModel');

        // $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);
        $urbanByLm =  $this->db->select('falls_und_gmc')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if ($premium_data->num_rows() > 0) {

            $caseUrban = null;
            $premium_data_row = $premium_data->row();
            $premium_data_arr = $premium_data->result();

            if (trim($basic['approve_by'] == '') || empty(trim($basic['approve_by']))) {
                if (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES) {
                    $caseUrban = "N";
                } else if (trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES)) {
                    $caseUrban = "Y";
                }
            } else {
                if (trim($basic['approve_by'] == 'DC')) { /////consider as rural case
                    $caseUrban = "N";
                } else if (trim($basic['approve_by'] == 'GOVT')) {
                    $caseUrban = "Y";
                }
            }

            if (isset($basic['is_wed_land']) && $basic['is_wed_land'] == 1) {
                $caseUrban = "N";
            }
            //*******for rural case */
            if ($caseUrban == 'N') {
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach ($premium_data_arr as $premium) {

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if (trim($premium->concession) == 'YES') {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        // $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
                        $data['premium_payable_without_concession'] = ceil($data['net_premium_payable'] / 0.75);
                        $data['concession_amount'] = ceil($data['premium_payable_without_concession'] * 0.25);
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                        $data['actual_premium'] = (float) $data['premium_payable_without_concession'] * 5;
                    } else {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                        $data['actual_premium'] += (float) $premium->amount_dag * 5;
                    }

                    // $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                    } else {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                    $area_all_barak[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                }

                $data['area'] = implode(", ", $area_all);
                $data['area_barak'] = implode(", ", $area_all_barak);
                $data['dag_no'] = implode(", ", $dag_arr);

                if ($data['type_of_concession'] == '-') {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                } else {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
            if ($caseUrban == 'Y') /////consider as urban case
            {
            }
        }

        $data['isUrban'] = $caseUrban;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);

        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date'] . ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        $this->load->helper('qrcode');
        $base_64 = printQR('https://sewasetu.assam.gov.in/');
        $data['qrcode'] = $base_64;
        return $data;
    }

    public function getPremiumNoticeGenerationString($PayloadString)
    {
        $data = json_decode($PayloadString);
        // echo "<pre>";
        // var_dump($data->get_settlement_basic->dist_code);
        // die;
        $html = "";

        $html .= '<div id="printableArea">

           <div class="container bg-white shadow" id="print_direct">
           <style>
            table {
                  width: 100%;
                  max-width: 100%;
                  margin-bottom: 1rem;
            }

            table th,
            table td {
            padding: 0.40rem;
            /* vertical-align: top; */
            border: 1px solid #191919;
            }

         </style>
               <div style="position: absolute; margin-right:100px; right:10px; margin-top: 15px;">'; ?>
        <?php

        $dataqr = explode(",", $data->qrcode);
        $dataqr = $dataqr[1];
        $html .= '<img class="img-fluid" src="data:image/png;base64,' . $dataqr . '" />';
        ?>



        <?php $html .= '</div>
              <div class="row mt-5 text-center">
                 <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                    অসম চৰকাৰ
                    <br>
                    চক্ৰ বিষয়াৰ কাৰ্যালয়,' . $data->circle_name . ' ৰাজহ চক্ৰ
                    <br>
                    জিলা- ' . $data->dist_name . '
                    <br>
                    <br>
                    জাননী
                    <br>
                    ' . $data->date . '
                 </div>



              </div>

              <div class="row mt-4">
                 <div class="col-12 text-justify p-5">
                    প্ৰতি: <b>' . $data->applicant_name . '</b> পিতা/ স্বামী <b>' . $data->guardian_name . '</b>
                    <br>
                    <br>
                    ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ২.০ ৰ অধীনৰ <b>' . $data->service_name . '</b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভূক্ত ভূমিৰ বাবে <b><?=$date_of_application?></b> তাৰিখে আৱেদন নং  <b>' . $data->application_no . '</b>. দাখিল কৰিছে।
                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th>জিলা</th>
                                <th>ৰাজহ চক্ৰ</th>
                                <th>মৌজা</th>
                                <th>লাট নং</th>
                                <th>গাওঁ</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $data->dist_name . '</td>
                                <td>' . $data->circle_name . '</td>
                                <td>' . $data->mouza_name . '</td>
                                <td>' . $data->lot_name . '</td>
                                <td>' . $data->village_name . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                            </tr>
                        </tbody>
                    </table>
                    আৱেদন পৰীক্ষাৰ অন্তত  <b>' . $data->date_of_sldc . '</b> তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ অন্তর্গত ৩২(১) ধাৰা অনুসৰি ওপৰত উল্লেখ কৰা দাগত আপোনাৰ দখলত থকা ভূমিৰ পট্টনৰ বাবে এই জাননীযোগে জনোৱা হ\'ল
                    আৰু আপুনি উক্ত পট্টন গ্ৰহন কৰিবলৈ সন্মত হলে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ জনোৱা হল ।
                    <br><br>
                    সেই অনুসৰি উক্ত ভূমিৰ প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ নামত পট্টনৰ বাবে কতৃপক্ষই বিবেচনা কৰিছে।
                    <br><br>
                    আপুনি আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ-

                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th></th>
                                <th>বৰ্ণনা</th>
                                <th>প্ৰিমিয়াম (per bigha)</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                                <th>মুঠ মূল্য</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>১</td>
                                <td><b>প্ৰকৃত  প্ৰিমিয়াম</b></td>
                                <td>' . $data->premium_per_bigha . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                                <td>' . $data->actual_premium . '</td>
                            </tr>
                            <tr>
                                <td>২</td>
                                <td><b>মিছন বসুন্ধৰা ৰেহাই মূল্য</b></td>
                                <td>' . $data->mission_per_bigha . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                                <td>' . $data->premium_payable_without_concession . '</td>
                            </tr>
                            <tr>
                                <td>৩</td>
                                <td><b>বিশেষ ৰেহাই (২৫%)</b></td>
                                <td>' . $data->type_of_concession . '</td>
                                <td>' . $data->concession_dag_no . '</td>
                                <td>' . $data->concession_area . '</td>
                                <td>' . $data->concession_amount . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center"><b>শুদ্ধ/চূড়ান্ত দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td><b>' . $data->net_premium_payable . '</b></td>
                            </tr>
                        </tbody>
                    </table>
                    সেইমৰ্মে আপোনাক সৰ্বমুঠ <b>' . $data->net_premium_payable . '</b> টকাৰ  প্ৰিমিয়াম অহা   ৩১ ডিচেম্বৰ ২০২৩ ইং তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হ’ল।
                    <br>
                    <br>
                    <u>প্ৰযোজ্য চৰ্তাৱলী</u>
                    <br>
                    ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পাছতহে আৱেদনকাৰীক ভূমিৰ পট্টা প্ৰদান কৰা হ’ব।
                    <br>

                    খ) আবেদনকাৰীয়ে দিবলগীয়া প্ৰিমিয়াম আদায় দিলে লগে লগে পট্টন দিয়া হ’ব। <br>
                    গ) আবেদকাৰীয়ে যদি প্ৰিমিয়াম কিস্তি হিচাপে আদায় দিব বিচাৰে তোনেক্ষেত্ৰত প্ৰথমতে ৩০ শতাংশ আৰু বাকী প্ৰিমিয়ামৰ ধনখিনি ৫ বছৰৰ ভিতৰত আদায় দিব লাগিব। <br>
                    ঘ) কিস্তি হিচাপে আদায় দিব বিচৰা আবেদনকাৰীৰ ক্ষেত্ৰত প্ৰথম ৩০ শতাংশ আদায় দিয়াৰ পাছত ৫ বছৰৰ ভিতৰত যদি আবেদনকাৰীৰ মৃত্যু ঘটে তেন্তে বাকী প্ৰিমিয়ামৰ ধনখিনি আবেদনকাৰীৰ উত্তৰাধিকাৰীয়ে আদায় দিব লাগিব। <br>

                 </div>
              </div>
              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
                <u>চৰকাৰী অধিসূচনা</u> <br>
                ১) No. RSR.9/88/Pt.II/64 Dtd. 25-May-1999 <br>
                   No. RSS.532/2011/Pt/152    Dtd. 21-Feb-2014 <br>
                ২) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)  <br>
                ৩) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)
              </div>
              </div>

              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
              <b>ওপৰত উল্লেখ কৰা প্ৰিমিয়াম আপোনাৰ স্ব-ঘোষণাৰ লগতে সংশ্লিষ্ট চক্ৰ বিষয়াই কৰা  (সম্ভাব্য) মূল্যায়নৰ ওপৰত নিৰ্ধাৰণ কৰি আপোনাৰ দখল/অধীনত থকা মাটিৰ ওপৰত নিৰ্ণয় কৰা হৈছে। আধুনিক পদ্ধতিৰে জৰীপৰ পিছত দখল/অধীনত থকা প্ৰকৃত মাটিৰ পৰিমাণ সাল-সলনি হ’লে আদায় দিবলগীয়া ভূমিৰ প্ৰিমিয়াম সংশোধন কৰা হ’ব পাৰে। </b>
               <br><br>
               <b>*পৰিৱৰ্তিত প্ৰিমিয়াম দখল অনুসৰি সংশোধনযোগ্য হ’ব।  </b>
              </div>
              </div>

              <div class="row mt-5 justify-content-end mb-5">
                 <div class="col-2 text-center"><b>' . $this->utilityclass->getSelectedCOName($data->get_settlement_basic->dist_code, $data->get_settlement_basic->subdiv_code, $data->get_settlement_basic->cir_code, $this->session->userdata('user_code'))->username . '</b><br>
                     চক্ৰ বিষয়া <br>' . $this->utilityclass->getCircleName($data->get_settlement_basic->dist_code, $data->get_settlement_basic->subdiv_code, $data->get_settlement_basic->cir_code) . '
                 </div>
              </div>
              <br>

           </div>
        </div>';

        return base64_encode($html);
    }

    public function savePaymentNoticeBulkByCO($case_no, $htmlString, $PayloadString, $completedCases)
    {

        $PayloadString = json_decode($PayloadString);

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        if (is_dir(PAYMENT_NOTICE_PATH) === false) {
            mkdir(PAYMENT_NOTICE_PATH, 0777);
        }
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        // base64 file
        $htmlstring_text = json_encode($htmlString);
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $amount = $PayloadString->net_premium_payable;
        $payment_notice_gn_date = $PayloadString->pay_notice_date;
        $remark_co = $PayloadString->co_remarks;

        // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $get_settlement_basic = $this->db->query($query)->row();


        $case_user_case = $get_settlement_basic->co_code;

        if ($this->session->userdata('user_desig_code') != 'CO') {
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098770932: Session Time out------ Try Again',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

        // $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $query = "SELECT * FROM settlement_dag_details WHERE case_no = '$case_no'";
        $get_dag_details = $this->db->query($query)->row();



        // $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $applicants = $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_applicant');

        $get_settlement_applicant = $applicants->result();

        // $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM
                           settlement_basic
                           WHERE
                              case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM settlement_applicant
                        WHERE
                           case_no = ?
                        AND
                           pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID' => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME' => $buyers->pdar_guardian,
                ];
        }
        $notice_no = "MB2/PN/" . date('Y') . "/SKCSL/" . $service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no' => $case_no,
            'service_code' => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date' => date('Y-m-d'),
            'total_amount' => $amount,
            'sdlac_proposal_id' => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date' => $service_details->sdlac_date,
            'applicant_details' => json_encode($applicant_buyers_json),
            'payment_completed_date' => date('Y-m-d'),
            'notice_no' => $notice_no,
            'notice_link' => $base_64_file_path,
            'notice_type' => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();

            log_message('error', '#ERRPN0067809: Insertion failed in settlement_notice');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001609 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

        $updateArr = [
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();

            log_message('error', '#ERRPN000109: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001509 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
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
            'task' => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN000209: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001409 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

        // API CALL HERE
        $rtps_case_no = $get_settlement_basic->applid;

        /// check full pay
        $is_full_pay = 'N';
        $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
        if ($premium_tot_data->num_rows() > 0) {
            foreach ($premium_tot_data->result() as $prem_records) {

                if ($prem_records->area_name == '7' || $prem_records->area_name == '8' || $prem_records->area_name == '9' || $prem_records->area_name == '10') {
                    $is_full_pay = 'N'; //// from now all cases partial payment option available
                }
            }
        } else {

            log_message('error', '#BACKUP003277: Premium payment type not found. Case No ' . $case_no);
            $json = [
                'responseType' => 3,
                'message' => '#BACKUP00327709 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }
        /// check full pay end

        //upload notice API
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'encoded_file' => json_decode($htmlstring_text),
            'application_no' => $rtps_case_no,
            'type' => 'PN',
            'amount' => $amount,
            'is_full_pay' => $is_full_pay,
        )));
        $result = curl_exec($curl_handle);

        if (trim($result) != 'y') {
            $this->db->trans_rollback();

            log_message('error', '#KHASPAYAPI001109: Premium payment type not found. Case No ' . $case_no);
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001109 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }
    }

    public function premiumReCalculation($case_no)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) {
            $dagCheck = $dagsCheck->result();
        } else {
            return array('status' => 1, 'message' => 'Dag not found..case no' . $case_no);
        }

        // $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $sql = $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_basic');
        $basic = $sql->row_array();

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) {

                $premData = $findLastPremium->row();
                $lastId = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate = $premData->rate;
                $concession_rate = 25;
                $prem_area = $premData->total_lessa;
                $area_name = $premData->area_name;
                $rate_type = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
            } else {

                return array('status' => 1, 'message' => 'Last premium not available for cases...Case no.' . $case_no);
            }

            $oldArea = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            $premPercentage = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
            $premRupees = array(7, 8, 9, 10, 18, 19, 20, 21, 22);

            if (in_array($area_name, $oldArea) && (($basic['dept_order_no'] == null || $basic['dept_order_no'] == '' || empty($basic['dept_order_no'])) || ($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date'])))) {
                $area_name_check = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);
                if (!in_array($area_name_check, $premRupees)) {
                    return array('status' => 1, 'message' => 'Old dag area flag found for this case, please use modification request...Case no.' . $case_no);
                }
            }

            $oldRupeesArea = array(7, 8, 9, 10);
            $mbLandNullArea = array(7, 8, 9, 10, 18, 20, 22);

            $isRural = 0;

            if (in_array($area_name, $oldArea)) {

                $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

                if ($area_name == false) {
                    return array('status' => 1, 'message' => 'New dag area flag not found!...Case no.' . $case_no);
                }

                if ($prem_rate == 10) {
                    $findrate = 10;
                } elseif ($prem_rate == 30) {
                    $findrate = 30;
                } elseif ($prem_rate == 100) {
                    $findrate = 100;
                }

                if (!in_array($area_name, $mbLandNullArea)) {
                    $getPrid = $this->db->query("SELECT prid FROM settlement_premium_rate WHERE paid = ? and rate= ?", array($area_name, $findrate));

                    if ($getPrid->num_rows() <= 0) {
                        return array('status' => 1, 'message' => '#ERR254144: Something went wrong!' . $case_no);
                    }

                    $prid = $getPrid->row()->prid;

                    $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($prid));

                    $rate_type = $prid;
                } else {
                    $isRural = 1;
                }
            } else {
                $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($rate_type));
            }

            if ($isRural != 1) {

                if ($findLastArea->num_rows() > 0) {
                    $premArea = $findLastArea->row();
                } else {
                    return array('status' => 1, 'message' => 'Max area not available for case no...' . $case_no);
                }

                $mb_land = $premArea->mb_land;
                $max_land = $premArea->max_land != null ? $premArea->max_land : 0;
                if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))) {

                    if ($mb_land == 25) {
                        $mb_land = 1600;
                    } else if ($mb_land == 30) {
                        $mb_land = 1920;
                    } else if ($mb_land == 40) {
                        $mb_land = 2560;
                    }

                    if ($max_land == 40) {
                        $max_land = 2560;
                    } else if ($max_land == 60) {
                        $max_land = 3840;
                    }
                }
            }

            if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))) {
                $area_in_bigha = 6400;
            } else {
                $area_in_bigha = 100;
            }


            if ($isRural != 1) {

                if (in_array($area_name, $premRupees)) {
                    return array('status' => 2, 'message' => null);
                }
            }

            if ($premData->concession == "YES") {
                if (in_array($area_name, $premPercentage)) {
                    if ($prem_area > $mb_land) {
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate - ($prem_rate * $concession_rate / 100);
                        $amount1 = ceil($premium * $discount / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    } else {
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate - ($prem_rate * $concession_rate / 100);
                        $amount = ($premium * $discount / 100);
                        // $finalamount = round($amount,2);
                        $finalamount = ceil($amount);
                    }
                } else if (in_array($area_name, $premRupees)) {
                    $prem_rate = 100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $discount = $prem_rate - $concession_rate;
                    $amount = ($premium * $discount / 100);
                    $finalamount = ceil($amount);
                }
            } else if ($premData->concession == "NO") {

                if (in_array($area_name, $premPercentage)) {
                    if ($prem_area > $mb_land) {
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $amount1 = ceil($premium * $prem_rate / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    } else {
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $amount = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                } else if (in_array($area_name, $premRupees)) {
                    $prem_rate = 100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $amount = ($premium * $prem_rate / 100);
                    $finalamount = ceil($amount);
                }
            }

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (($amount_dag != $finalamount) || ($area_name != $premData->area_name)) {

                $premiumdata = array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    // 'uuid'=>$premdags->uuid,
                    'dag_no' => $premData->dag_no,
                    'zonal_valuation' => $premData->zonal_valuation,
                    'area_name' => $area_name,
                    'land_type' => $premData->land_type,
                    'rate_type' => $rate_type,
                    'rate' => $prem_rate,
                    'concession' => $premData->concession,
                    'amount_dag' => $finalamount,
                    'final_amount' => null,
                    'due_amount' => null,
                    'total_lessa' => $prem_area,
                    'is_full_pay' => $premData->is_full_pay,
                    'is_final' => 1,
                    'date_entry' => date('Y-m-d h:i:s'),
                    'approve_by' => $premData->approve_by,
                    'zone_code' => $premData->zone_code,
                    'subclass_code' => $premData->subclass_code,
                    'old_zonal_valuation' => $premData->old_zonal_valuation,
                );

                $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                if ($reInsPremium != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                }

                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                $updatePrem = $this->db->query($sqlprem);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900311: Something went wrong Case No  ' . $case_no);
                }
            }
        }

        if (!in_array($area_name, $mbLandNullArea)) {
            if ($max_land != 0 && $sumMbArea > $max_land) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET98703161: Max area exceed RTPS Case No ' . $case_no);
                return array('status' => 1, 'message' => '#ERRSET98703161: Max area exceed.. Case No  ' . $case_no);
            }
        }

        if (($due_amount != $sumMbAmount) || ($area_name != $premData->area_name)) {

            $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
            $updatePremium = $this->db->query($sqlPremUpdate);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
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
                'note_on_order' => 'Premium updated due to policy changed',
                'status' => 'M',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Premium updated',
                'note_type' => 'Premium updated due to policy changed',
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP45333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                return array('status' => 1, 'message' => '#ERRORPP45333: Failed to forward the case for Case No : ' . $case_no);
            }
            //////proceeding end//////

        }
    }

    public function finalAreaCheck($case_no)
    {
        //***get settlement_basic data  */
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if ($getBasicSql->num_rows() <= 0) {
            log_message('error', '#ERR1776: No case found in settlement_basic ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1776: Case number not found! ->' . $case_no,
            );
        }

        $getDagDetailsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if ($getDagDetailsSql->num_rows() <= 0) {
            log_message('error', '#ERR1777: No case found in settlement_dag_details ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1777: Case number not found! ->' . $case_no,
            );
        }

        $dagResult = $getDagDetailsSql->result();

        $total_lessa = 0;
        $total_s_dag_area_lessa = 0;
        $total_reservation_lessa = 0;
        $total_premium_lessa = 0;
        $total_chitha_lessa = 0;

        foreach ($dagResult as $dagRow) {
            //****check if chitha_area exceeds */
            //******if AP NR case than consider the new dag */
            if ($getBasicSql->row()->service_code == '14') {
                if ($dagRow->new_dag_no != null || !$dagRow->new_dag_no || $dagRow->new_dag_no != '') {
                    //****new dag_no for NR */
                    $new_dag_no = $dagRow->new_dag_no;

                    if (trim($new_dag_no)) {
                        $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->new_dag_no));
                    } else {
                        $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                    }
                } else {
                    $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                }
            } else {
                $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
            }

            if ($getChithaAreaSql->num_rows() <= 0) {
                log_message('error', '#ERR1797: No dag found in chitha_basic ->' . $case_no);
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1797: No dag found in chitha! ' . $case_no,
                );
            }

            $chithaRow = $getChithaAreaSql->row();

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY))) {
                //******getting the home + agri area */
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $total_home_lessa = $this->utilityclass->Total_ganda($home_b, $home_k, $home_lc, $home_g);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $total_agri_lessa = $this->utilityclass->Total_ganda($agri_b, $agri_k, $agri_lc, $agri_g);

                //****getting the s_dag_area */
                $s_dag_area_b = $dagRow->s_dag_area_b;
                $s_dag_area_k = $dagRow->s_dag_area_k;
                $s_dag_area_lc = $dagRow->s_dag_area_lc;
                $s_dag_area_g = $dagRow->s_dag_area_g;
                $s_dag_area_lessa = $this->utilityclass->Total_ganda($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc, $s_dag_area_g);

                //***getting chitha_lessa */
                $chita_b = $chithaRow->dag_area_b;
                $chita_k = $chithaRow->dag_area_k;
                $chita_lc = $chithaRow->dag_area_lc;
                $chita_g = $chithaRow->dag_area_g;
                $chitha_lessa = $this->utilityclass->Total_ganda($chita_b, $chita_k, $chita_lc, $chita_g);
            } else {
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $total_home_lessa = $this->utilityclass->Total_Lessa($home_b, $home_k, $home_lc);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $total_agri_lessa = $this->utilityclass->Total_Lessa($agri_b, $agri_k, $agri_lc);

                //****getting the s_dag_area */
                $s_dag_area_b = $dagRow->s_dag_area_b;
                $s_dag_area_k = $dagRow->s_dag_area_k;
                $s_dag_area_lc = $dagRow->s_dag_area_lc;
                $s_dag_area_lessa = $this->utilityclass->Total_Lessa($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc);

                //***getting chitha_lessa */
                $chita_b = $chithaRow->dag_area_b;
                $chita_k = $chithaRow->dag_area_k;
                $chita_lc = $chithaRow->dag_area_lc;
                $chitha_lessa = $this->utilityclass->Total_Lessa($chita_b, $chita_k, $chita_lc);
            }

            $total_lessa += $total_home_lessa + $total_agri_lessa;
            $total_s_dag_area_lessa += $s_dag_area_lessa;
            $total_chitha_lessa += $chitha_lessa;
        }

        if ($total_lessa != $total_s_dag_area_lessa) {
            log_message('error', '#ERR1840: s_dag_area and (agri+home) area mis-match ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1840: Something went wrong! Contact Admin...',
            );
        }

        //****check if area exceeds more than chitha area */
        if ($total_lessa > $total_chitha_lessa) {
            log_message('error', '#ERR1878: Applied area exceeds more than chitha area ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1878: Applied area exceeds more than chitha area ' . $case_no,
            );
        }

        //*****getting the nr for AP cases */
        if ($getBasicSql->row()->service_code == '14') {
            $total_nr_lessa = 0;

            foreach ($dagResult as $dagRowNr) {
                if (in_array($dagRowNr->dist_code, json_decode(BARAK_VALLEY))) {
                    $nr_bigha = $dagRowNr->nr_bigha;
                    $nr_katha = $dagRowNr->nr_katha;
                    $nr_lessa = $dagRowNr->nr_lessa;
                    $nr_ganda = $dagRowNr->nr_ganda;
                    $nr_in_lessa = $this->utilityclass->Total_ganda($nr_bigha, $nr_katha, $nr_lessa, $nr_ganda);
                } else {
                    $nr_bigha = $dagRowNr->nr_bigha;
                    $nr_katha = $dagRowNr->nr_katha;
                    $nr_lessa = $dagRowNr->nr_lessa;
                    $nr_in_lessa = $this->utilityclass->Total_Lessa($nr_bigha, $nr_katha, $nr_lessa);
                }

                $total_nr_lessa += $nr_in_lessa;
            }

            if ($total_nr_lessa < $total_lessa) {
                log_message('error', '#ERR1927: Settlement area bigger than NR area ->' . $case_no);
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1927: Please check the NR and settlement area, settlement area should be less than NR area! ' . $case_no,
                );
            }
        }

        //********calculating the roadside reservation if available */
        $getReservationSql = $this->db->query('select * from settlement_reservation where case_no = ? and is_deleted = ? and type = ?', array($case_no, '0', 'R'));

        if ($getReservationSql->num_rows() > 0) {
            $reservationResult = $getReservationSql->result();

            foreach ($reservationResult as $reservationRow) {
                if (in_array($reservationRow->dist_code, json_decode(BARAK_VALLEY))) {
                    $reservation_bigha = $reservationRow->bigha;
                    $reservation_katha = $reservationRow->katha;
                    $reservation_lessa = $reservationRow->lessa;
                    $reservation_ganda = $reservationRow->ganda;

                    $reservation_in_lessa = $this->utilityclass->Total_ganda($reservation_bigha, $reservation_katha, $reservation_lessa, $reservation_ganda);
                } else {
                    $reservation_bigha = $reservationRow->bigha;
                    $reservation_katha = $reservationRow->katha;
                    $reservation_lessa = $reservationRow->lessa;

                    $reservation_in_lessa = $this->utilityclass->Total_Lessa($reservation_bigha, $reservation_katha, $reservation_lessa);
                }

                $total_reservation_lessa += $reservation_in_lessa;
            }
        }

        //******deducting the roadside reservation area */
        if ($total_reservation_lessa != 0) {
            $total_lessa = $total_lessa - $total_reservation_lessa;
        }

        $getPremiumSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no, '1'));

        if ($getPremiumSql->num_rows() <= 0) {
            log_message('error', '#ERR1851: No data found in settlement_premium table ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1851: Premium calculation not available, Please re-calculate the premium! ' . $case_no,
            );
        }

        $premiumResult = $getPremiumSql->result();

        foreach ($premiumResult as $premiumRow) {
            $total_premium_lessa += $premiumRow->total_lessa;
        }

        if ($total_lessa != $total_premium_lessa) {
            log_message('error', '#ERR1869: settlement_dag_details and settlement_premium area mis-match ->' . $case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1869: Something went wrong! Contact Admin...',
            );
        }

        //****if no issues then return success */
        return array(
            'responseType' => 2,
            'msg' => 'Success',
        );
    }

    public function downloadNotice($notice_link)
    {
        if (!file_exists($notice_link)) {
            $parts = explode("uploads" . UPLOAD_SEPARATOR, $notice_link, 2);
            if (count($parts) > 1) {
                $path = BACKUP_DIR_34 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
            } else {
                $path = $notice_link;
            }

            if (!file_exists($path)) {
                $path = BACKUP_DIR_35 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
            }

            if (!file_exists($path)) {
                return false;
            }
        } else {
            $path = $notice_link;
        }
        return $path;
    }


    public function premiumReCalculateCaste()
    {
        $case_no = $this->input->post('case_no');
        $is_concession = $this->input->post('is_concession');

        // $check = $this->SettlementCommonModel->premiumReCalculateInsert($case_no, $is_concession);
        $check = $this->premiumReCalculateInsert($case_no, $is_concession);

        if ($check['status'] != 2) {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => $check['message']
            ]);
            return false;
        }

        echo json_encode([
            'responseType'  => 2,
            'msg'           => $check['message']
        ]);
    }

    public function premiumReCalculateInsert($case_no, $concession)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) {
            $dagCheck = $dagsCheck->result();
        } else {
            return array('status' => 1, 'message' => 'Dag not found..case no' . $case_no);
        }

        // $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $res = $this->db->select()
            ->where('case_no', $case)
            ->get('settlement_basic');
        $basic =  $res->row_array();

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) {
                $premData = $findLastPremium->row();
                $lastId = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate = $premData->rate;
                $concession_rate = 25;
                $prem_area = $premData->total_lessa;
                $area_name = $premData->area_name;
                $rate_type = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
            } else {

                return array('status' => 1, 'message' => 'Last premium not available for cases...Case no.' . $case_no);
            }

            $oldArea = array(1, 2, 3, 4, 5, 6);

            $oldRupeesArea = array(7, 8, 9, 10);

            $isRural = 0;

            if (in_array($area_name, $oldArea)) {

                $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

                if ($area_name == false) {
                    return array('status' => 1, 'message' => 'New dag area flag not found!...Case no.' . $case_no);
                }

                if ($prem_rate == 10) {
                    $findrate = 10;
                } elseif ($prem_rate == 30) {
                    $findrate = 30;
                } elseif ($prem_rate == 100) {
                    $findrate = 100;
                }

                if (!in_array($area_name, $oldRupeesArea)) {
                    $getPrid = $this->db->query("SELECT prid FROM settlement_premium_rate WHERE paid = ? and rate= ?", array($area_name, $findrate));

                    if ($getPrid->num_rows() <= 0) {
                        return array('status' => 1, 'message' => '#ERR254144: Something went wrong!' . $case_no);
                    }

                    $prid = $getPrid->row()->prid;

                    $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($prid));

                    $rate_type = $prid;
                } else {
                    $isRural = 1;
                }
            } else {
                $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($rate_type));
            }

            if ($isRural != 1) {
                if ($findLastArea->num_rows() > 0) {
                    $premArea = $findLastArea->row();
                } else {
                    return array('status' => 1, 'message' => 'Max area not available for case no...' . $case_no);
                }

                $mb_land = $premArea->mb_land;
                $max_land = $premArea->max_land != null ? $premArea->max_land : 0;
                if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))) {

                    if ($mb_land == 25) {
                        $mb_land = 1600;
                    } else if ($mb_land == 30) {
                        $mb_land = 1920;
                    } else if ($mb_land == 40) {
                        $mb_land = 2560;
                    }
                }
            }

            if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))) {
                $area_in_bigha = 6400;
            } else {
                $area_in_bigha = 100;
            }

            $premPercentage = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
            $premRupees = array(7, 8, 9, 10, 18, 19, 20, 21, 22);

            // if(in_array($area_name, $oldArea)){
            //     // return array('status'=>3,'message'=>'Old area flag found for this dag, case no: '.$case_no);

            // }

            if ($isRural != 1 && $concession != 'NO') {

                if (in_array($area_name, $premRupees)) {
                    return array('status' => 1, 'message' => null);
                }
            }

            if ($concession == "YES") {
                if (in_array($area_name, $premPercentage)) {
                    if ($prem_area > $mb_land) {
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate - ($prem_rate * $concession_rate / 100);
                        $amount1 = ceil($premium * $discount / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    } else {
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate - ($prem_rate * $concession_rate / 100);
                        $amount = ($premium * $discount / 100);
                        // $finalamount = round($amount,2);
                        $finalamount = ceil($amount);
                    }
                } else if (in_array($area_name, $premRupees)) {
                    $prem_rate = 100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $discount = $prem_rate - $concession_rate;
                    $amount = ($premium * $discount / 100);
                    $finalamount = ceil($amount);
                }
            } else if ($concession == "NO") {

                if (in_array($area_name, $premPercentage)) {
                    if ($prem_area > $mb_land) {
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $amount1 = ceil($premium * $prem_rate / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    } else {
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $amount = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                } else if (in_array($area_name, $premRupees)) {
                    $prem_rate = 100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $amount = ($premium * $prem_rate / 100);
                    $finalamount = ceil($amount);
                }
            }

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (($amount_dag != $finalamount) || ($area_name != $premData->area_name) || $concession == 'NO') {

                $premiumdata = array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    // 'uuid'=>$premdags->uuid,
                    'dag_no' => $premData->dag_no,
                    'zonal_valuation' => $premData->zonal_valuation,
                    'area_name' => $area_name,
                    'land_type' => $premData->land_type,
                    'rate_type' => $rate_type,
                    'rate' => $prem_rate,
                    'concession' => $concession,
                    'amount_dag' => $finalamount,
                    'final_amount' => null,
                    'due_amount' => null,
                    'total_lessa' => $prem_area,
                    'is_full_pay' => $premData->is_full_pay,
                    'is_final' => 1,
                    'date_entry' => date('Y-m-d h:i:s'),
                    'approve_by' => $premData->approve_by,
                    'zone_code' => $premData->zone_code,
                    'subclass_code' => $premData->subclass_code,
                    'old_zonal_valuation' => $premData->old_zonal_valuation,
                );

                $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                if ($reInsPremium != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                }

                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                $updatePrem = $this->db->query($sqlprem);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900311: Something went wrong Case No  ' . $case_no);
                }
            }
        }

        if ($max_land != 0 && $sumMbArea > $max_land) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET98703161: Max area exceed RTPS Case No ' . $case_no);
            return array('status' => 1, 'message' => '#ERRSET98703161: Max area exceed.. Case No  ' . $case_no);
        }

        if (($due_amount != $sumMbAmount) || ($area_name != $premData->area_name) || $concession == 'NO') {

            $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
            $updatePremium = $this->db->query($sqlPremUpdate);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
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
                'note_on_order' => 'Premium updated due to wrong caste selection',
                'status' => 'M',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Premium updated',
                'note_type' => 'Premium updated due to wrong caste selection',
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP45333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                return array('status' => 1, 'message' => '#ERRORPP45333: Failed to forward the case for Case No : ' . $case_no);
            }
            //////proceeding end//////
            return array('status' => 2, 'message' => 'Premium successfully updated!');
        } else {
            return array('status' => 1, 'message' => '#ERRORPP45465: Something went wrong! Unable to process...');
        }
    }

    public function savePaymentNotice()
    {

        $case_no = $this->input->post('case_no');

        $this->db->trans_begin();

        $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

        $old_notice_link = false;
        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) {
            //******re-generate premium notice first check if payment already done for this case_no */

            // $paymentStatusCheck = $this->SettlementApiModel->paymentStatusCheck($case_no);
            $paymentStatusCheck = $this->paymentStatusCheck($case_no);

            if ($paymentStatusCheck['responseType'] != 2) {
                $this->session->set_flashdata('message', "#ERR18435896: Payment already made by citizen for this application # " . $case_no);
                redirect(base_url() . "index.php/home");
            }

            //***getting the old notice link before deleting it */
            $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;

            //***delete the notice */

            $this->db->query('delete from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1843444: Unable to process! Something went wrong... # " . $case_no);
                redirect(base_url() . "index.php/home");
            }

            // $this->session->set_flashdata('message', "#ERR1843: Premium notice already generated # ".$case_no);
            // redirect(base_url() . "index.php/home");
        }

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp = date('mdYhis', time()) . uniqid();

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no . '_' . $timestamp . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $remark_co = $this->input->post('remark');

        // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $get_settlement_basic = $this->db->query($query)->row();


        $case_user_case = $get_settlement_basic->co_code;

        // if($this->session->userdata('user_code') != $case_user_case)
        // {
        //     $this->session->set_flashdata('message', "#ERR2040: Session timeout! Please login and try again # ".$case_no);
        //     redirect(base_url() . "index.php/home");
        // }

        if ($this->session->userdata('user_desig_code') != 'CO') {
            $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # " . $case_no);
            redirect(base_url() . "index.php/home");
        }

        // $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $query = "SELECT * FROM settlement_dag_details WHERE case_no = '$case_no'";
        $get_dag_details = $this->db->query($query)->row();


        // $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $res = $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_applicant');

        $get_settlement_applicant = $res->result();


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
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM
                           settlement_basic
                           WHERE
                              case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM settlement_applicant
                        WHERE
                           case_no = ?
                        AND
                           pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID' => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME' => $buyers->pdar_guardian,
                ];
        }

        $notice_no = "MB3/PN/" . date('Y') . "/BHDAN/" . $service_details->petition_no;


        $insertIntoSettlementNotice = [
            'case_no' => $case_no,
            'service_code' => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date' => date('Y-m-d'),
            'total_amount' => $amount,
            'sdlac_proposal_id' => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date' => $service_details->sdlac_date,
            'applicant_details' => json_encode($applicant_buyers_json),
            'payment_completed_date' => date('Y-m-d'),
            'notice_no' => $notice_no,
            'notice_link' => $base_64_file_path,
            'notice_type' => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $this->session->set_flashdata('message', "#KHASPAYAPI0016 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        $updateArr = [
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $this->session->set_flashdata('message', "#KHASPAYAPI0015 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        //****if CO aggress with OLD premium calculation */
        // $settlement_premium_insertion = $this->SettlementCommonModel->premiumReCalculation($case_no);
        $settlement_premium_insertion = $this->premiumReCalculation($case_no);

        if ($settlement_premium_insertion != null && $settlement_premium_insertion['status'] == 3) {
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'CO agreed with old dag flag premium calculation',
                'status' => 'N',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'CO agreed with old dag flag premium calculation',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#KHASPAYAPI00145: Insertion failed in settlement_proceeding');
                $this->session->set_flashdata('message', "#KHASPAYAPI00145 Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
                return false;
            }
        }

        //******check if CO aggreed with concession even after caste is general */
        $data['caste'] = $get_settlement_basic->caste;
        // $applicants_buyers   = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
        $res = $this->db->select()
            ->where('case_no', $case_no)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');
        $applicants_buyers = $res->result();

        foreach ($applicants_buyers as $applicant) {
            if ($applicant->is_applicant == 1) {
                $data['if_widow'] = $applicant->marital_status;
            }
        }

        if (!isset($data['if_widow'])) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR151220231026: Marital staus not found! ' . $case_no);
            $this->session->set_flashdata('message', "#ERROR151220231026: Something went wrong! " . $case_no);
            redirect(base_url() . 'index.php/home/index');
        }

        $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', array($case_no, 1));

        if ($concenSql->num_rows() <= 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR151220231155: Something went wrong! Unable to process... ' . $case_no);
            $this->session->set_flashdata('message', "#ERROR151220231155: Something went wrong! Unable to process " . $case_no);
            redirect(base_url() . 'index.php/home/index');
        }

        if ($concenSql->row()->concession == 'YES') {
            if (trim($data['caste']) == '6' && trim($data['if_widow']) != '4') {
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }
                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => 'CO agreed with premium concession',
                    'status' => 'N',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'CO agreed with premium concession',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
                    $this->session->set_flashdata('message', "#ERRPN0002 Payment notice  could not be generated...");
                    redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
                    return false;
                }
            }
        }

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
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
            'task' => 'Payment Notice Generated',
            'old_file_link' => $old_notice_link == false ? null : $old_notice_link,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $this->session->set_flashdata('message', "#ERRPN0002 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#KHASPAYAPI0013 Payment notice  could be generated...");
            redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
            exit;
        } else {
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;

            /// check full pay
            $is_full_pay = 'N';
            $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
            if ($premium_tot_data->num_rows() > 0) {
                foreach ($premium_tot_data->result() as $prem_records) {

                    if ($prem_records->area_name == '7' || $prem_records->area_name == '8' || $prem_records->area_name == '9' || $prem_records->area_name == '10') {
                        $is_full_pay = 'N'; //// from now all cases partial payment option available
                    }
                }
            } else {

                log_message('error', '#BACKUP003277: Premium payment type not found. Case No ' . $case_no);

                $this->session->set_flashdata('error_data', "#BACKUP003277: Premium payment type not found for case no : " . $case_no);
            }
            /// check full pay end


            // upload notice API
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $rtps_case_no,
                'type' => 'PN',
                'amount' => $amount,
                'is_full_pay' => $is_full_pay
            )));
            $result = curl_exec($curl_handle);

            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#KHASPAYAPI0011  Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
                exit;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $case_no);
            }
        }
    }


    public function paymentStatusCheck($case_no)
    {
        $sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is not null', array($case_no, 1));

        if ($sql->num_rows() > 0) {
            return array(
                'responseType'  => 0,
                'msg'           => '#ERR934: Unable to process! Citizen already made payment for this application...'
            );
        }

        // $payment_status_check = $this->SettlementMbModel->paymentConfirmation($this->utilityclass->getApplidFromCaseNo($case_no));
        $payment_status_check = $this->paymentConfirmation($this->utilityclass->getApplidFromCaseNo($case_no));

        $pay_status = $payment_status_check->payment_status;
        if (strtoupper($pay_status) == 'Y') {
            return array(
                'responseType'  => 0,
                'msg'           => '#ERR945: Unable to process! Citizen already made payment for this application...'
            );
        }

        return array(
            'responseType'  => 2,
            'msg'           => 'Payment have not been done yet..'
        );
    }



    function paymentConfirmation($basundhara)
    {
        $caseRtpsBasu = $this->checkRtpsService($basundhara);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "paymentStatus");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $basundhara,
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if ($httpcode != 200) {
            return false;
        }
        return json_decode($result);
    }

    public function pagination()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $nr_cat = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $pagination = $this->input->post('pagination');


        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved = $this->input->post('co_approved');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

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
            0 => 'date_entry',
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


        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if (trim($reverted) == 'LM') {
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);
        } else if (trim($reverted) == 'ADC') {
            $this->db->where_not_in('a.pending_officer', array(MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER));
        } else {

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }



        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        } else {
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }


        if (trim($reverted) != 'ADC') {
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        } else {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
            if (trim($reverted) != 'ADC') {
                if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {
                } else {
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }



        $this->db->from('settlement_basic a');

        if ($status == MB_PAYMENT_NOTICE) {
            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if (!empty($payment_status)) {
                if (trim($payment_status) == 'paid') {
                    $this->db->where('c.grn_no is not null');
                } elseif (trim($payment_status) == 'unpaid') {
                    $this->db->where('c.grn_no is null');
                }
            }

            if (!empty($final_verification_report)) {
                if ($final_verification_report == 'Yes') {
                    $this->db->where_in('a.chitha_processing_details', array(1, 2));
                } else if ($final_verification_report == 'No') {
                    $this->db->where('a.chitha_processing_details', 0);
                } elseif (trim($final_verification_report) == 'land_class_issue') {
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                    // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 

                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
                }
            }


            if (!empty($co_approved)) {
                if ($co_approved == 'Yes') {
                    $this->db->where('a.chitha_processing_details', 2);
                } else if ($co_approved == 'No') {
                    $this->db->where_in('a.chitha_processing_details', array(1, 0));
                }
            }
        }

        $query = $this->db->get();
        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                // if($s_code == 14)
                // {
                //     if($rows->new_dag_no == null)
                //     {
                //         $nr_status = 'No';
                //     }
                //     else
                //     {
                //         $nr_status = 'Yes';
                //     }
                // }

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

                if ($revialSql->num_rows() > 0) {
                    $revival_flg_button = '';
                } else {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\'' . $rows->case_no . '\',\'' . $rows->service_code . '\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="' . base_url() . 'index.php/SettlementCommon/downloadRejectedCases/?service=' . $s_code . '">Download Reject Cases</a>';

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_REQUEST) {
                    $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';

                    $bhoddan_link  = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/BhoodanController/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';

                    $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                } elseif ($status == MB_PAYMENT_NOTICE) {


                    if ($rows->chitha_processing_details == 1) {
                        $lm_chitha_report = 'Yes';
                    } elseif ($rows->chitha_processing_details == 2) {
                        $lm_chitha_report = 'Yes';
                    } elseif ($rows->chitha_processing_details == 0) {
                        $lm_chitha_report = 'No';
                    }


                    if ($rows->chitha_processing_details == 2) {
                        $co_approved_status = 'Yes';
                    } elseif ($rows->chitha_processing_details == 1) {
                        $co_approved_status = 'No';
                    } elseif ($rows->chitha_processing_details == 0) {
                        $co_approved_status = 'No';
                    }


                    $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>


                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';


                    $bhoddan_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>
                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        
                        <br>

                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                } else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    View</a>
                    
                    <a href="' . base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no=' . $rows->case_no . '&dist_code=' . $rows->dist_code . '&subdiv_code=' . $rows->subdiv_code . '&cir_code=' . $rows->cir_code . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you would like to update chitha for this case?\');">Update Chitha</a>
                    
                    ';
                } else if (trim($reverted) == 'ADC' or trim($reverted) == 'LM') {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';

                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                } else if ($status == MB_DISMISS) {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  ' . $revival_flg_button . $download_rejected_cases;
                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  ' . $revival_flg_button . $download_rejected_cases;

                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a> ' . $revival_flg_button . $download_rejected_cases;
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                } else {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/bhoodanCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    $tenant_urban_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCoUrban/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';

                    $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/TeaGrantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

                    $institute_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/settlementInsCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';
                }

                if ($status == MB_PAYMENT_NOTICE) {
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                    if ($sqlgrn->num_rows() <= 0) {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    } else {
                        if (isset($sqlgrn->row()->grn_no)) {
                            if ($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '') {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            } else {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        } else {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }

                    $json[] = array(
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        // date("Y-m-d", strtotime($rows->date_entry)),

                        // $lmnoteRemark,

                        $grn_status,
                        $lm_chitha_report,
                        $co_approved_status,

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : (($s_code == BHODDAN_SERVICE_CODE) ? $bhoddan_link : ''))))))),
                    );
                } else {
                    $json[] = array(
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        date("Y-m-d", strtotime($rows->date_entry)),

                        $lmnoteRemark,

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : (($s_code == SETTLEMENT_TENANT_URBAN_ID) ? $tenant_urban_link : (($s_code == TEA_SERVICE_CODE) ? $tea_grant_link : (($s_code == BHODDAN_SERVICE_CODE) ? $bhoddan_link : (($s_code == SLIJE_ID) ? $institute_link : ''

                        )))))))))),
                    );
                }
            }

            $this->db->where('a.service_code', $s_code);

            if (!empty($remark_cat)) {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM') {
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);
            } else if (trim($reverted) == 'ADC') {
                $this->db->where_not_in('a.pending_officer', array(MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER));
            } else {


                // if ($this->session->userdata('user_desig_code') == 'SK')
                // {
                //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                // else
                // {
                //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
                //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            // $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

            // if($s_code == 14 && $status == 'X')
            // {
            //     $this->db->join('settlement_dag_details c', 'a.case_no = c.case_no');

            //     if(!empty($nr_cat))
            //     {
            //         if(trim($nr_cat) == 'Yes')
            //         {
            //             $this->db->where('c.new_dag_no is not null');
            //         }
            //         else
            //         {
            //             $this->db->where('c.new_dag_no is null');
            //         }
            //     }
            // }

            // if($s_code == 14)
            // {
            //     if(trim($reverted) == 'LM' and $status =='V'){
            //         $this->db->select("distinct(a.case_no),a.service_code, c.new_dag_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry");
            //         $this->db->select('(select \'0\') as lm_note');
            //     }else{
            //         $this->db->select('distinct(a.case_no), c.new_dag_no, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            //     }
            // }
            // else
            // {


            // if(trim($reverted) == 'LM' and $status =='V'){
            //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            //     $this->db->select('(select \'0\') as lm_note');
            // }else{
            //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            // }


            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            } else {
                $this->db->select('distinct(a.case_no)');
            }

            //}


            if (trim($reverted) != 'ADC') {
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            } else {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
                if (trim($reverted) != 'ADC') {
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {
                    } else {
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

            if ($status == MB_PAYMENT_NOTICE) {
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if (!empty($payment_status)) {
                    if (trim($payment_status) == 'paid') {
                        $this->db->where('c.grn_no is not null');
                    } elseif (trim($payment_status) == 'unpaid') {
                        $this->db->where('c.grn_no is null');
                    }
                }


                if (!empty($final_verification_report)) {
                    if ($final_verification_report == 'Yes') {
                        $this->db->where_in('a.chitha_processing_details', array(1, 2));
                    } else if ($final_verification_report == 'No') {
                        $this->db->where('a.chitha_processing_details', 0);
                    } elseif (trim($final_verification_report) == 'land_class_issue') {
                        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                        // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
                    }
                }


                if (!empty($co_approved)) {
                    if ($co_approved == 'Yes') {
                        $this->db->where('a.chitha_processing_details', 2);
                    } else if ($co_approved == 'No') {
                        $this->db->where_in('a.chitha_processing_details', array(1, 0));
                    }
                }
            }


            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data = $this->db->get('settlement_basic a');
            $total_records = $data->num_rows();
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

    public function locationSelect($service_code, $status)
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }
        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code  and pending_officer = 'CO' AND status = 'N' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql); //->num_rows()>0 ? $this->db->query($sql)->result() :null;

        if ($data->num_rows() > 0) {
            $result = $this->db->query($sql)->result();
        } else {
            $result = null;
        }
        return $result;
    }

    public function confirmPaymentCo()
    {

        $case_no = $this->input->get('case');
        // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        // $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        // $get_settlement_basic  = $this->db->query($query)->row();

        $sql = $this->db->select()
            ->where('case_no', $case_no)
            ->get('settlement_basic');
        $get_settlement_basic = $sql->row();

        $case_no_rtps = $get_settlement_basic->applid;

        // payment status check thourgh API
        // $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);
        $payment_status_check = $this->paymentConfirmation($case_no_rtps);




        //var_dump($payment_status_check);
        if ($payment_status_check == null || (
            !isset($payment_status_check->payment_status)
            && !isset($payment_status_check->total_premium)
            && !isset($payment_status_check->paid_amount)
            && !isset($payment_status_check->remaining_amount)
            && !isset($payment_status_check->tenure)
            && !isset($payment_status_check->installment_amount)
        )) {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $pay_status = $payment_status_check->payment_status;
        if (strtoupper($pay_status) == 'Y') {
            $total_premium = $payment_status_check->total_premium;
            $paid_amount = $payment_status_check->paid_amount;
            $remaining_amount = $payment_status_check->remaining_amount;
            $tenure = $payment_status_check->tenure;
            $installment_amount = $payment_status_check->installment_amount;
            $percentage = $payment_status_check->percentage;
            $pay_date = $payment_status_check->payment_date;
        } else {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $data = [
            'case_no' => $case_no,
            'payment_status' => strtolower($pay_status),
            'payment_date' => $pay_date,
            'case_no_rtps' => $case_no_rtps,
            'total_premium' => $total_premium,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => $tenure,
            'installment_amount' => $installment_amount,
            'percentage' => $percentage,
            //'_view' => 'settlement_mb/confirmPaymentView'
        ];

        if (strtoupper($pay_status) == 'Y') {
            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {
                $this->db->trans_begin();

                // $dagsResult = $this->SettlementKhasModel->getSettlementDag($case_no);
                $dags = $this->db->select()
                    ->where('case_no', $case)
                    ->get('settlement_dag_details');
                $dagsResult = $dags->result(); //var_dump($dagsResult);die;


                $isFullPay = 'YES';

                if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
                    $isFullPay = 'NO';
                }

                $insertArr = [
                    'is_full_pay' => $isFullPay,
                    'total_premium' => $payment_status_check->total_premium,
                    'paid_amount' => $payment_status_check->paid_amount,
                    'remaining_amount' => $payment_status_check->remaining_amount,
                    'tenure' => $payment_status_check->tenure,
                    'installment_amount' => $payment_status_check->installment_amount,
                    'payment_date' => $payment_status_check->payment_date,
                    'grn_no' => $payment_status_check->grn_no,
                ];

                $this->db->where('case_no', $case_no);
                $this->db->where('is_final', 1);
                $this->db->update('settlement_premium', $insertArr);

                if ($this->db->affected_rows() != count($dagsResult)) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
                    redirect(base_url() . "index.php/Home/index");
                }
                $this->db->trans_commit();
            }
        }

        $getNomTrasSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));
        if ($getNomTrasSql->num_rows() <= 0) {
            $data['nomTrans'] = false;
        } else {
            $data['nomTrans'] = $getNomTrasSql->result();
        }

        $getNomTrasSql = $this->db->query('select * from settlement_nominee where case_no = ?', array($case_no));
        if ($getNomTrasSql->num_rows() <= 0) {
            $data['nomReal'] = false;
        } else {
            $data['nomReal'] = $getNomTrasSql->result();
        }

        $dist_code = $get_settlement_basic->dist_code;
        $subdiv_code = $get_settlement_basic->subdiv_code;
        $cir_code = $get_settlement_basic->cir_code;
        $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();
        $mouza = $get_settlement_basic->mouza_pargona_code;
        $lot_no = $get_settlement_basic->lot_no;
        $vill = $get_settlement_basic->vill_townprt_code;
        //$patta_type = $alm->patta_type_code;
        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();

        $data['update_land_class'] = false;

        foreach ($data['dagDetails'] as $dagRow) {
            $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->dag_no));

            if ($getPremSql->num_rows() <= 0) {
                $dagRow->final_settlement_area = false;
            } else {
                $premiumRow = $getPremSql->row();
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
                } else {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
                }
            }

            //****getting the roadside reservation area */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->dag_no));

            if ($reservation->num_rows() <= 0) {
                $dagRow->road_side_reservation = false;
            } else {
                $reservation = $reservation->result();

                foreach ($reservation as $reservationRow) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
                    } else {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
                    }
                }
            }

            //*****getting the approval report */

            //******getting the final settlement area */
            if ($get_settlement_basic->service_code == '14') {
                $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            } else {
                $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            }

            if ($getAppTransSql->num_rows() <= 0) {
                $data['approvalRow'] = false;
            } else {
                $appRow = $getAppTransSql->row();

                $dagRow->new_patta_type_code = $appRow->patta_type_code;
                $dagRow->new_possession_from = $appRow->possession_from;
                $dagRow->new_landclass_home = $appRow->landclass_home;
                $dagRow->new_landclass_agri = $appRow->landclass_agri;

                $dagRow->newHomeRevenue = $appRow->new_home_land_revenue;
                $dagRow->newAgriRevenue = $appRow->new_agri_land_revenue;

                $dagRow->newHomeLocalTax = $appRow->new_home_land_local_tax;
                $dagRow->newAgrilocalTax = $appRow->new_agri_land_local_tax;

                $dagRow->new_landmark = json_decode($appRow->landmark);
            }

            $dagRow->landmark = json_decode($dagRow->landmark);

            if ($data['alm']->chitha_processing_details == 2 && (empty($data['alm']->order_passed) || $data['alm']->order_passed == null || $data['alm']->order_passed == '')) {
                $landType = 0;
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $homestead = $home_b + $home_k + $home_lc + $home_g;
                if ($homestead > 0) {
                    $landType = 1;
                }
                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;
                if ($agriculture > 0) {
                    $landType = 2;
                }
                if ($homestead > 0 && $agriculture > 0) {
                    $landType = 3;
                }

                if ($landType == 3) {
                    if (empty($dagRow->new_land_class_home) || empty($dagRow->new_land_class_agri)) {
                        if ($data['update_land_class'] != true) {
                            $data['update_land_class'] = true;
                        }
                    }
                }
            }
        }

        $data['class_code'] = $patta_type_code[0]->new_land_class_code;
        $pattasqll = "SELECT type_code, patta_type FROM patta_code where settlement='y' order by type_code asc";
        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta'] = 0;
        // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        //var_dump($data);
        $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        $data['dag_patta'] = $this->db->query($q)->result();
        $data['dcnote'] = 'Manipulate text';
        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();

        //var_dump($data['newdag']);
        $data['_view'] = 'Bhoodan/confirmPaymentView';
        $this->load->view('layouts/main', $data);
    }

    function checkRtpsService($case)
    {
        $sql = "SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
        $dataFound = $this->db->query($sql, $case)->row();
        if ($dataFound) {
            $data = $dataFound->basundhara;
            $var = explode('/', $data);
            $service = $var['0'];
        } else {
            $service = null;
        }
        return $service;
    }

    public function chithaUpdate()
    {
        $this->load->helper('url');
        // var_dump($_POST);
        // die;
        // $data = $this->SettlementMbModel->updateChitha();
        $data = $this->updateChitha();
        if ($data) {
            if ($data == 1) {
                // redirect(base_url() . 'index.php/SettlementMbCo/redirectForPatta?case_no=' . $this->input->post('case_no'));
                redirect(base_url() . 'index.php/BhoodanControllerCo/redirectForPatta?case_no=' . $this->input->post('case_no'));
            } else {
                $application_no = $this->input->post('case_no');
                $case = $this->input->post('case_no');
                $rmk = 'Final order given but could not generate PATTA/ORDER copy';
                $status = 'F';
                $task = 'CO';
                $pen = 'NA';
                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->session->set_flashdata('message', "Final order given but could not generate PATTA/ORDER copy.There is an error in API Calling");
                    redirect('/home');
                }
                $this->session->set_flashdata('message', "Final order given but could not generate PATTA/ORDER copy");
                redirect('/home');
            }
        } else {
            redirect(base_url() . 'index.php/SettlementMbCo/coFinalPendingCases');
        }
    }


    function updateChitha()
    {
        //var_dump($_POST);
        $case = $this->input->post('case_no');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO')
            redirect('/home');
        $this->db->db_debug = FALSE;
        ////////////////////////
        $this->db->trans_begin();
        try {
            $sql = "Select * from settlement_basic where case_no=? and status!=? ";
            $main = $this->db->query($sql, array($case, 'F'))->row_array();
            if (empty($main))
                redirect('/home');

            $sql1 = "Select * from settlement_dag_details where case_no=?";
            $dagDetails = $this->db->query($sql1, array($case))->result_array();
            if (empty($dagDetails))
                redirect('/home');
            //echo '<pre>';
            //var_dump($dagDetails);
            $sql2 = "Select * from settlement_applicant where case_no=? and pdar_type=?";
            $applicant = $this->db->query($sql2, array($case, 'B'))->result_array();
            if (empty($applicant))
                redirect('/home');
            //var_dump($applicant);
            $sql3 = "Select * from settlement_ap_lmnote where case_no=? order by id desc";
            $lmNote = $this->db->query($sql3, array($case))->row_array();
            //var_dump($lmNote);
            $pdar_id = $this->MaxpdarIdCheck($case, $_POST['new_dag']);
            $converArea = 0;
            ////////////////////////////
            $payment_date = date('Y-m-d', strtotime($this->input->post('payment_date')));
            $this->db->where('case_no', $case);
            $this->db->update('settlement_notice', array('payment_completed_date' => $payment_date));
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message('error', "Error Code(#SLP00023)" . $this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $insertArr = [
                'case_no' => $case,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'Payment Cofirmed/Chitha Update',
                'status' => 'P',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Payment Confirmed'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', "Error Code(#SLP00025)" . $this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////////////////////
            foreach ($_POST['new_dag'] as $key => $newPostedDags) {
                $old_dag = $_POST['old_dag'][$key];
                $partitionType = $_POST['partitionType'][$key];
                $new_land_class = $_POST['land_class'][$key];
                $revenue = $_POST['revenue'][$key];
                $localTax = $_POST['local_tax'][$key];
                $new_dag = $newPostedDags;
                /////////////14-03-23///////////////////
                if ($new_dag == $old_dag)
                    $fullorpartial = 'F';
                else
                    $fullorpartial = null;
                ///////////////////////////////
                if ($_POST['new_patta'] == 0)
                    redirect('/home');
                ////////////Update In dag Details///////////////
                $updateNewdagPatta = array(
                    'new_dag_no' => $new_dag,
                    'new_patta_no' => $_POST['new_patta'],
                    'new_patta_type_code' => $_POST['new_patta_type'],
                    'new_dag_revenue' => $revenue,
                    'new_land_class_code' => $new_land_class,
                    'new_local_tax' => $localTax,
                );
                $this->db->where('case_no', $case);
                $this->db->where('dag_no', $old_dag);
                $this->db->update('settlement_dag_details', $updateNewdagPatta);
                //////////////////////New Query//////////////////////////////////
                $q = "Select max(rmk_type_hist_no)+1 as c from chitha_rmk_gen where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
                $histNo = $this->db->query($q, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $new_dag))->row();
                if ($histNo->c == null) {
                    $rmk_type_hist_no = 1;
                } else {
                    $rmk_type_hist_no = $histNo->c;
                }
                $ord_cron_no = 1;
                $location = array(
                    'dist_code' => $main['dist_code'],
                    'subdiv_code' => $main['subdiv_code'],
                    'cir_code' => $main['cir_code'],
                    'mouza_pargona_code' => $main['mouza_pargona_code'],
                    'lot_no' => $main['lot_no'],
                    'vill_townprt_code' => $main['vill_townprt_code'],
                    'dag_no' => $new_dag
                );
                //////////////////////////
                $sql1 = "Select * from settlement_dag_details where case_no=? and dag_no=?";
                $dagDetails = $this->db->query($sql1, array($case, $old_dag))->row_array();
                if (empty($dagDetails))
                    redirect('/home');

                ///////////For Only HOME/////////////////
                $reserveAreaRoad = 0;
                if ($partitionType == '1') {
                    //////////////Minus land area Both family and road side if reserve exists///////////////
                    $roadside = "SELECT dist_code,
                              CASE
                                WHEN dist_code ='21' THEN (bigha*6400 + katha*320 + lessa *20 +ganda )
                                when dist_code !='21' then (bigha*100 + katha*20 + lessa  )
                              END 
                              AS total_lessa
                            FROM settlement_reservation where case_no=? and dag_no=? 
                            group by dist_code,bigha,katha,lessa,ganda";
                    $roadSideQuery = $this->db->query($roadside, array($main['case_no'], $old_dag));
                    if ($roadSideQuery->num_rows() > 0) {
                        $reserved = $roadSideQuery->row();
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $applied = $dagDetails['home_b'] * 6400 + $dagDetails['home_k'] * 320 + $dagDetails['home_lc'] * 20 + $dagDetails['home_g'];
                            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($applied - $reserved->total_lessa);
                        } else {
                            $applied = $dagDetails['home_b'] * 100 + $dagDetails['home_k'] * 20 + $dagDetails['home_lc'];
                            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($applied - $reserved->total_lessa);
                        }

                        $bigha = $areaSubstract[0];
                        $katha = $areaSubstract[1];
                        $lessa = $areaSubstract[2];
                        $gonda = $areaSubstract[3];
                        $reserveAreaRoad = 1;
                    }
                    ///////////////////////////////                  
                    $dagDetails['s_dag_area_b'] = $reserveAreaRoad != 0 ? $bigha : $dagDetails['home_b'];
                    $dagDetails['s_dag_area_k'] = $reserveAreaRoad != 0 ? $katha : $dagDetails['home_k'];
                    $dagDetails['s_dag_area_lc'] = $reserveAreaRoad != 0 ? $lessa : $dagDetails['home_lc'];
                    $dagDetails['s_dag_area_g'] = $reserveAreaRoad != 0 ? $gonda : $dagDetails['home_g'];
                    $dagDetails['s_dag_area_kr'] = $dagDetails['home_kr'];
                    $cb = array(
                        'dag_no_int' => $new_dag . '00',
                        'old_dag_no' => $old_dag,
                        'patta_type_code' => $_POST['new_patta_type'],
                        'patta_no' => $_POST['new_patta'],
                        'dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $bigha : $dagDetails['s_dag_area_b']),
                        'dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $katha : $dagDetails['s_dag_area_k']),
                        'dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $lessa : $dagDetails['s_dag_area_lc']),
                        'dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $gonda : $dagDetails['s_dag_area_g']),
                        'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'dag_area_are' => 0,
                        'land_class_code' => $new_land_class,
                        'dag_revenue' => $revenue,
                        'dag_local_tax' => $localTax,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => null,
                        'dag_status' => ($this->input->post('total_premium') - $this->input->post('paid_amount')) == 0 ? 'G' : null
                    );

                    $chitha_basic = array_merge($location, $cb);
                    // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);
                    $tstatusChitha = $this->Chitha_basic_model->insert_table('chitha_basic', $chitha_basic);
                    if ($tstatusChitha != 1) {
                        log_message('error', "ErrorInCode(#SLPCB001)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //////////////////////////
                    $r_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $_POST['new_patta']
                    );
                    $rmk_gen = array_merge($location, $r_gen);
                    $tstatusRmk = $this->db->insert('chitha_rmk_gen', $rmk_gen);
                    if ($tstatusRmk != 1) {
                        log_message('error', "ErrorInCode(#SLPCB002)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB002)");
                        redirect(base_url() . "index.php/home");
                    }
                    $o_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $main['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $main['service_code'],
                        'ord_cron_no' => $ord_cron_no,
                        'case_no' => $main['case_no'],
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $user_desig_code,
                        //'lm_code' => $lmNote['user_code'],
                        'lm_sign_yn' => 'Y',
                        //'lm_sign_date' => $lmNote['date_entry'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $bigha : $dagDetails['s_dag_area_b']),
                        'm_dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $katha : $dagDetails['s_dag_area_k']),
                        'm_dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $lessa : $dagDetails['s_dag_area_lc']),
                        'm_dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $gonda : $dagDetails['s_dag_area_g']),
                        'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'rural_urban' => $dagDetails['is_urban'],
                        'full_partial' => $fullorpartial,
                    );
                    $ord_basic = array_merge($location, $o_basic);
                    $tstatusOrd = $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
                    if ($tstatusOrd != 1) {
                        log_message('error', "ErrorInCode(#SLPCB003)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB003)");
                        redirect(base_url() . "index.php/home");
                    }
                    if ($converArea == 0) {
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $converArea = $this->utilityclass->Total_ganda($dagDetails['home_b'], $dagDetails['home_k'], $dagDetails['home_lc'], $dagDetails['home_g']);
                        } else {
                            $converArea = $this->utilityclass->Total_Lessa($dagDetails['home_b'], $dagDetails['home_k'], $dagDetails['home_lc']);
                        }
                    } else {
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $newArea = $this->utilityclass->Total_ganda($dagDetails['home_b'], $dagDetails['home_k'], $dagDetails['home_lc'], $dagDetails['home_g']);
                        } else {
                            $newArea = $this->utilityclass->Total_Lessa($dagDetails['home_b'], $dagDetails['home_k'], $dagDetails['home_lc']);
                        }
                        $converArea = $converArea + $newArea;
                    }
                }
                ///////////For Only AGRI///////////////

                else if ($partitionType == '2') {
                    $reserveAreaRoad = 0;
                    //////////////Minus land area Both family and road side if reserve exists///////////////
                    // $roadside="Select sum(bigha*100 + katha*20 + lessa) total_lessa from settlement_reservation where case_no=? and dag_no=? ";
                    $roadside = "SELECT dist_code,
                              CASE
                                WHEN dist_code ='21' THEN sum(bigha*6400 + katha*320 + lessa *20 +ganda)
                                when dist_code !='21' then sum(bigha*100 + katha*20 + lessa)
                              END 
                              AS total_lessa
                            FROM settlement_reservation where case_no=? and dag_no=? 
                            group by dist_code,bigha,katha,lessa,ganda";
                    $roadSideQuery = $this->db->query($roadside, array($main['case_no'], $old_dag));
                    //echo $this->db->last_query();
                    //echo "<br> ----------------";
                    // $roadside="Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? ";
                    // $roadSideQuery=$this->db->query($roadside,array($main['case_no'])); 
                    if ($roadSideQuery->num_rows() > 0) {
                        $reserved = $roadSideQuery->row();
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $applied = $dagDetails['agri_b'] * 6400 + $dagDetails['agri_k'] * 320 + $dagDetails['agri_lc'] * 20 + $dagDetails['agri_g'];
                            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($applied - $reserved->total_lessa);
                        } else {
                            $applied = $dagDetails['agri_b'] * 100 + $dagDetails['agri_k'] * 20 + $dagDetails['agri_lc'];
                            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($applied - ($reserved->total_lessa));
                        }
                        //var_dump($areaSubstract);
                        $bigha = $areaSubstract[0];
                        $katha = $areaSubstract[1];
                        $lessa = $areaSubstract[2];
                        $gonda = $areaSubstract[3];
                        $reserveAreaRoad = 1;
                    }
                    // echo "<br> ----------------";
                    ///////////////////////////////  
                    $dagDetails['s_dag_area_b'] = $reserveAreaRoad != 0 ? $bigha : $dagDetails['agri_b'];
                    $dagDetails['s_dag_area_k'] = $reserveAreaRoad != 0 ? $katha : $dagDetails['agri_k'];
                    $dagDetails['s_dag_area_lc'] = $reserveAreaRoad != 0 ? $lessa : $dagDetails['agri_lc'];
                    $dagDetails['s_dag_area_g'] = $reserveAreaRoad != 0 ? $gonda : $dagDetails['agri_g'];
                    $dagDetails['s_dag_area_kr'] = $dagDetails['agri_kr'];
                    $cb = array(
                        'dag_no_int' => $new_dag . '00',
                        'old_dag_no' => $old_dag,
                        'patta_type_code' => $_POST['new_patta_type'],
                        'patta_no' => $_POST['new_patta'],
                        'dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $bigha : $dagDetails['s_dag_area_b']),
                        'dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $katha : $dagDetails['s_dag_area_k']),
                        'dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $lessa : $dagDetails['s_dag_area_lc']),
                        'dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $gonda : $dagDetails['s_dag_area_g']),
                        'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'dag_area_are' => 0,
                        'land_class_code' => $new_land_class,
                        'dag_revenue' => $revenue,
                        'dag_local_tax' => $localTax,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => null,
                        'dag_status' => ($this->input->post('total_premium') - $this->input->post('paid_amount')) == 0 ? 'G' : null
                    );
                    $chitha_basic = array_merge($location, $cb);
                    // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);

                    $tstatusChitha = $this->Chitha_basic_model->insert_table('chitha_basic', $chitha_basic);
                    if ($tstatusChitha != 1) {
                        log_message('error', "ErrorInCode(#SLPCB001)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //////////////////////////
                    $r_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $_POST['new_patta']
                    );
                    $rmk_gen = array_merge($location, $r_gen);
                    $tstatusRmk = $this->db->insert('chitha_rmk_gen', $rmk_gen);
                    if ($tstatusRmk != 1) {
                        log_message('error', "ErrorInCode(#SLPCB002)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB002)");
                        redirect(base_url() . "index.php/home");
                    }
                    $o_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $main['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $main['service_code'],
                        'ord_cron_no' => $ord_cron_no,
                        'case_no' => $main['case_no'],
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $user_desig_code,
                        //'lm_code' => $lmNote['user_code'],
                        'lm_sign_yn' => 'Y',
                        //'lm_sign_date' => $lmNote['date_entry'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $bigha : $dagDetails['s_dag_area_b']),
                        'm_dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $katha : $dagDetails['s_dag_area_k']),
                        'm_dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $lessa : $dagDetails['s_dag_area_lc']),
                        'm_dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad != 0 ? $gonda : $dagDetails['s_dag_area_g']),
                        'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'rural_urban' => $dagDetails['is_urban'],
                        'full_partial' => $fullorpartial,
                    );
                    $ord_basic = array_merge($location, $o_basic);
                    $tstatusOrd = $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
                    if ($tstatusOrd != 1) {
                        log_message('error', "ErrorInCode(#SLPCB003)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB003)");
                        redirect(base_url() . "index.php/home");
                    }
                    if ($converArea == 0) {
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $converArea = $this->utilityclass->Total_ganda($dagDetails['agri_b'], $dagDetails['agri_k'], $dagDetails['agri_lc'], $dagDetails['agri_g']);
                        } else {
                            $converArea = $this->utilityclass->Total_Lessa($dagDetails['agri_b'], $dagDetails['agri_k'], $dagDetails['agri_lc']);
                        }
                    } else {
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $newArea = $this->utilityclass->Total_ganda($dagDetails['agri_b'], $dagDetails['agri_k'], $dagDetails['agri_lc'], $dagDetails['agri_g']);
                        } else {
                            $newArea = $this->utilityclass->Total_Lessa($dagDetails['agri_b'], $dagDetails['agri_k'], $dagDetails['agri_lc']);
                        }
                        $converArea = $converArea + $newArea;
                    }
                }

                //////////Substract From Original Dag Land area (Only Road Side) ////////////
                $reserveAreaRoad = 0;
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $roadside = "Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? and (type='R')";
                } else {
                    $roadside = "Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? and dag_no=? and (type='R')";
                }
                $roadSideQuery = $this->db->query($roadside, array($main['case_no'], $old_dag));
                //echo $this->db->last_query();
                if ($roadSideQuery->num_rows() > 0) {
                    $reserveAreaRoad = $roadSideQuery->row()->total_lessa;
                }
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $totalReserve = "Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? ";
                } else {
                    $totalReserve = "Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? and dag_no=? ";
                }
                $totalReserve = $this->db->query($totalReserve, array($main['case_no'], $old_dag));
                //echo $this->db->last_query();
                if ($totalReserve->num_rows() > 0) {
                    $reserveAreaRoadFamily = $totalReserve->row()->total_lessa;
                }
                $cb = "select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $landAreacb = $this->db->query($cb, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $old_dag));
                if ($landAreacb->num_rows() > 0) {
                    $landAreacb = $landAreacb->row();
                }
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $total = $this->utilityclass->Total_ganda($landAreacb->dag_area_b, $landAreacb->dag_area_k, $landAreacb->dag_area_lc, $landAreacb->dag_area_g);
                } else {
                    $total = $this->utilityclass->Total_Lessa($landAreacb->dag_area_b, $landAreacb->dag_area_k, $landAreacb->dag_area_lc);
                }

                if ($reserveAreaRoad) {
                    $total = $total + $reserveAreaRoad;
                    /////////////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $roadSideQuery->row()->bigha . " বিঘা " . $roadSideQuery->row()->katha . " কঠা " . $roadSideQuery->row()->lessa . " চাটক " . $roadSideQuery->row()->ganda . " গোণ্ডা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    } else {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $roadSideQuery->row()->bigha . " বিঘা " . $roadSideQuery->row()->katha . " কঠা " . $roadSideQuery->row()->lessa . " লেচা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }
                    $insert = array(
                        'dist_code' => $main['dist_code'],
                        'subdiv_code' => $main['subdiv_code'],
                        'cir_code' => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no' => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'patta_no' => $dagDetails['patta_no'],
                        'patta_type_code' => $dagDetails['patta_type_code'],
                        'dag_no' => $old_dag,
                        'dag_no_int' => $old_dag . '00',
                        'remark' => addslashes($rmk),
                        'category' => 2,
                        'date_entry' => date('Y-m-d'),
                        'user_code' => $user_code,
                    );
                    $this->db->insert('backlog_orders', $insert);
                    if ($this->db->affected_rows() != 1) {
                        log_message('error', "ErrorInCode(#SLPCB00499)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                        redirect(base_url() . "index.php/home");
                    }
                    /////////////////////
                }
                //echo $total."###".$converArea ."<br>";
                $remanLanArea = $total - $converArea;
                if ($remanLanArea < 0) {
                    $this->db->trans_rollback();
                    log_message('error', "#####CaseNo" . $case . "######TotalArea" . $total . "MinusLandArea" . $converArea . "#reserved" . $reserveAreaRoad);
                    $this->session->set_flashdata('message', "Remaining Land Area less than 0");
                    redirect(base_url() . "index.php/home");
                }
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $remanLanArea = $this->utilityclass->Total_Bigha_Katha_Lessa2($remanLanArea);
                } else {
                    $remanLanArea = $this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
                }
                log_message('error', "#####CaseNo" . $case . "######TotalArea" . $total . "MinusLandArea" . $converArea);
                $bigha = $remanLanArea[0];
                $katha = $remanLanArea[1];
                $lessa = $remanLanArea[2];
                $gonda = $remanLanArea[3];

                $table = 'chitha_basic';

                $params = [
                    'dag_area_b'   => $bigha,
                    'dag_area_k'   => $katha,
                    'dag_area_lc'  => $lessa,
                    'dag_area_g'   => $gonda, // assuming this was intended as 'gonda', not 'ganda'
                    'user_code'    => $user_code,
                    'date_entry'   => date('Y-m-d'),
                    'jama_yn'      => null,
                ];

                $where = [
                    'dist_code'           => $main['dist_code'],
                    'subdiv_code'         => $main['subdiv_code'],
                    'cir_code'            => $main['cir_code'],
                    'mouza_pargona_code'  => $main['mouza_pargona_code'],
                    'lot_no'              => $main['lot_no'],
                    'vill_townprt_code'   => $main['vill_townprt_code'],
                    'dag_no'              => $old_dag,
                ];

                $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($tstatusChithaOld <= 0 || $tstatusChithaOld > 1) {
                    log_message('error', "ErrorInCode(#SLPCB004)" . $this->db->last_query());
                    log_message('error', "ErrorInCode" . $this->db->db_debug);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB004)");
                    redirect(base_url() . "index.php/home");
                }
                $pattdarIdCheck = TRUE;
                foreach ($applicant as $slp) {
                    $allotee = array(
                        'dist_code' => $slp['dist_code'],
                        'subdiv_code' => $slp['subdiv_code'],
                        'cir_code' => $slp['cir_code'],
                        'mouza_pargona_code' => $slp['mouza_pargona_code'],
                        'lot_no' => $slp['lot_no'],
                        'vill_townprt_code' => $slp['vill_townprt_code'],
                        'dag_no' => $new_dag,
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $slp['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_cron_no' => $ord_cron_no,
                        'settlement_id' => $slp['pdar_cron_no'],
                        'settlement_name'  => $slp['pdar_name'],
                        'settlement_guardian' => $slp['pdar_guardian'],
                        'settlement_guar_relation' => $slp['pdar_rel_guar'],
                        'settlement_gender' => $slp['pdar_gender'],
                        'settlement_mother' => $slp['pdar_mother'],
                        'settlement_land_b' => 0,
                        'settlement_land_k' => 0,
                        'settlement_land_lc' => 0,
                        'settlement_land_g' => 0,
                        'settlement_land_kr' => 0,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation' => 'E',
                        'case_no' => $slp['case_no'],
                        'patta_no' => $_POST['new_patta'],
                        'old_patta_no' => $slp['patta_no'],
                        'old_dag' => $old_dag,
                        'new_dag' => $new_dag,
                        'new_patta_type' => $_POST['new_patta_type'],
                        'pdar_type' => $slp['pdar_type'],
                        'lm_code' => $main['lm_code'],
                        'dc_code' => $main['dc_code'],
                        'inplace_along_with' => null
                    );
                    //var_dump($allotee);
                    $tstatusallotee = $this->db->insert('chitha_settlement_allottee', $allotee);
                    if ($tstatusallotee != 1) {
                        log_message('error', "ErrorInCode(#SLPCB005)" . $this->db->last_query());
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB005)");
                        redirect(base_url() . "index.php/home");
                    }
                    //Insert query/////////////////
                    /////////////////////////////////////
                    if ($slp['pdar_type'] == 'B') {
                        $final_pdarId = $pdar_id;
                        $c_d_p = array(
                            'pdar_id' => $final_pdarId,
                            'patta_no' => $_POST['new_patta'],
                            'patta_type_code' => $_POST['new_patta_type'],
                            'dag_por_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                            'dag_por_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                            'dag_por_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                            'dag_por_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                            'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                            'user_code' => $user_code,
                            'date_entry' => date('Y-m-d'),
                            'operation' => 'E',
                            'p_flag' => '0',
                            'jama_yn' => 'N',
                        );
                        $chitha_dag_p = array_merge($location, $c_d_p);
                        //var_dump($chitha_dag_p);
                        // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                        $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_p);
                        //echo $this->db->last_query();
                        if ($tstatus2 != 1) {
                            log_message('error', "Error Code(#SLP001)" . $this->db->last_query());
                            log_message('error', "ErrorInCode" . $this->db->db_debug);
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLP001)");
                            redirect(base_url() . "index.php/home");
                        }
                        /////////////Chitha Pattadar////////////////
                        if ($pattdarIdCheck === TRUE) {
                            $chitha_pattadar = array(
                                'dist_code' => $main['dist_code'],
                                'subdiv_code' => $main['subdiv_code'],
                                'cir_code' => $main['cir_code'],
                                'mouza_pargona_code' => $main['mouza_pargona_code'],
                                'lot_no' => $main['lot_no'],
                                'vill_townprt_code' => $main['vill_townprt_code'],
                                'patta_no' => $_POST['new_patta'],
                                'patta_type_code' => $_POST['new_patta_type'],
                                'pdar_id' => $final_pdarId,
                                'pdar_name' => $slp['pdar_name'],
                                'pdar_father' => $slp['pdar_guardian'],
                                'pdar_add1' => $slp['pdar_add1'],
                                'pdar_add2' => $slp['pdar_add2'],
                                //'pdar_pan_no' => $alp->alotee_pan_card,
                                'user_code' => $user_code,
                                'date_entry' => date('Y-m-d'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'pdar_guard_reln' => $this->utilityclass->relationByID($slp['pdar_rel_guar']),
                                'pdar_gender' => ($slp['pdar_gender'] == 1) ? 'm' : (($slp['pdar_gender'] == 2) ? 'f' : 'o'),
                                'pdar_minor_yn' => null,
                                'pdar_minor_dob' => null,
                                'pdar_mother' => $slp['pdar_mother'],
                                'pdar_aadharno' => null,
                                'pdar_mobile' => $slp['pdar_mobile'],
                                'new_pdar_name' => 'N'
                            );
                            //var_dump($chitha_pattadar);
                            // $tstatusChPat=$this->db->insert('chitha_pattadar', $chitha_pattadar);
                            $chitha_pattadar['f1_case_no'] = $case;
                            $tstatusChPat = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                            if ($tstatusChPat != 1) {
                                log_message('error', "Error Code(#SLPCP005)" . $this->db->last_query());
                                log_message('error', "ErrorInCode" . $this->db->db_debug);
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCP005)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        $pdar_id++;
                    }
                }
                $pattdarIdCheck = FALSE;
            }
            /////////////////////////////////////////
            if ($main['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID) {
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $vgr = "Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, * from settlement_reservation where case_no=? and type='V'";
                } else {
                    $vgr = "Select (bigha*100 + katha*20 + lessa) total_lessa, * from settlement_reservation where case_no=? and type='V'";
                }
                $vgrQuery = $this->db->query($vgr, array($main['case_no']));
                //echo $this->db->last_query();
                if ($vgrQuery->num_rows() > 0) {
                    $reserveforVgr = $vgrQuery->row();
                    //$reserveforVgr=$vgrQuery->row()->total_lessa;
                }
                $cb = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $landAreacb = $this->db->query($cb, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $reserveforVgr->dag_no));
                if ($landAreacb->num_rows() > 0) {
                    $landAreacb = $landAreacb->row();
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $total = $this->utilityclass->Total_ganda($landAreacb->dag_area_b, $landAreacb->dag_area_k, $landAreacb->dag_area_lc, $landAreacb->dag_area_g);
                    } else {
                        $total = $this->utilityclass->Total_Lessa($landAreacb->dag_area_b, $landAreacb->dag_area_k, $landAreacb->dag_area_lc);
                    }
                }
                //////////////////
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $existVgrLand = "select sum(bigha*6400+katha*320+lessa*20+ganda) as applied from chitha_reservation_vgr where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                } else {
                    $existVgrLand = "select sum(bigha*100+katha*20+lessa) as applied from chitha_reservation_vgr where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                }
                $landAreaVgr = $this->db->query($existVgrLand, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $reserveforVgr->dag_no));
                if ($landAreaVgr->num_rows() > 0) {
                    $landAreaVgr = $landAreaVgr->row();
                    $sumArea = $landAreaVgr->applied + $reserveforVgr->total_lessa;
                    if ($sumArea > $total) {
                        $this->db->trans_rollback();
                        log_message('error', "#SLVGR500 ErrorInCode Already Applied##" . $landAreaVgr->applied . "##Present Apply:" . $reserveforVgr->total_lessa . "##Chitha Total:" . $total . "##case" . $case);
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLVGR500)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                if ($reserveforVgr) {
                    /////////////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $reserveforVgr->bigha . " বিঘা " . $reserveforVgr->katha . " কঠা " . $reserveforVgr->lessa . " চাটক " . $reserveforVgr->ganda . " গোণ্ডা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case . " নং ৰ অধীনত ভিজিআৰ/পিজিআৰ ৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    } else {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $reserveforVgr->bigha . " বিঘা " . $reserveforVgr->katha . " কঠা " . $reserveforVgr->lessa . " লেচা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case . " নং ৰ অধীনত ভিজিআৰ/পিজিআৰ ৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }

                    $insert = array(
                        'dist_code' => $reserveforVgr->dist_code,
                        'subdiv_code' => $reserveforVgr->subdiv_code,
                        'cir_code' => $reserveforVgr->cir_code,
                        'mouza_pargona_code' => $reserveforVgr->mouza_pargona_code,
                        'lot_no' => $reserveforVgr->lot_no,
                        'vill_townprt_code' => $reserveforVgr->vill_townprt_code,
                        'patta_no' => $reserveforVgr->patta_no,
                        'patta_type_code' => $reserveforVgr->patta_type_code,
                        'dag_no' => $reserveforVgr->dag_no,
                        'dag_no_int' => $reserveforVgr->dag_no . '00',
                        'remark' => addslashes($rmk),
                        'category' => 2,
                        'date_entry' => date('Y-m-d'),
                        'user_code' => $user_code,
                    );
                    $this->db->insert('backlog_orders', $insert);
                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', "ErrorInCode" . $this->db->db_debug);
                        log_message('error', "ErrorInCode(#SLPCB00499)" . $this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                        redirect(base_url() . "index.php/home");
                    }
                    /////////////////////
                    unset($insert['dag_no_int']);
                    $insert['bigha'] = $reserveforVgr->bigha;
                    $insert['katha'] = $reserveforVgr->katha;
                    $insert['lessa'] = $reserveforVgr->lessa;
                    $insert['ganda'] = $reserveforVgr->ganda;
                    $insert['case_no'] = $main['case_no'];
                    $this->db->insert('chitha_reservation_vgr', $insert);
                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', "ErrorInCode(#SLDVGR00499)" . $this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLDVGR00499)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ////////////////End for VGR //////////////////
            $updateSettlement = array(
                'status' => 'F',
                'from_office' => 'CO',
                'pending_officer' => null,
                'co_chitha_corrected_yn' => 'y',
                'co_chitha_corrected_date' => date('Y-m-d H:i:s')
            );
            $this->db->where('case_no', $case);
            $this->db->update('settlement_basic', $updateSettlement);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', "Error Code(#SLPCDP007)" . $this->db->last_query());
                log_message('error', "ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }

            //Update into settlement_premium table dharitree
            $insertSettlementPremiumArr = [
                'total_premium' => $this->input->post('total_premium'),
                'paid_amount' => $this->input->post('paid_amount'),
                'remaining_amount' => $this->input->post('remaining_amount') == null ? '0' : $this->input->post('remaining_amount'),
                'tenure' => $this->input->post('tenure') == null ? '0' : $this->input->post('tenure'),
                'installment_amount' => $this->input->post('installment_amount') == null ? '0' : $this->input->post('installment_amount'),
                'installment_amount' => $this->input->post('installment_amount') == null ? '0' : $this->input->post('installment_amount'),
                'payment_date' => $this->input->post('payment_date') == null ? '0' : $this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_premium', $insertSettlementPremiumArr);
            ////////////////////////////////////////////
            if ($this->db->affected_rows() == 0) {
                log_message('error', "Error Code(#SLPCDP444007)" . $this->db->last_query());
                //log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////Notice Date update///////////////
            $insertSettlementnotice = [

                'paid_amount' => $this->input->post('paid_amount'),
                'payment_completed_date' => $this->input->post('payment_date') == null ? '0' : $this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_notice', $insertSettlementnotice);
            ////////////////////////////////////////////
            if ($this->db->affected_rows() == 0) {
                log_message('error', "Error Code(#SLPCDP444009)" . $this->db->last_query());
                //log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
                redirect(base_url() . 'index.php/home');
            } else {
                //////////////POST To basundhara/////////////////////
                $rmk = 'Chitha Updated';
                $status = 'F';
                $task = 'CO';
                $pen = 'NA';
                //////////////Generate PATTA-ORDER COPY///////////////////
                if ($this->input->post('total_premium') == $this->input->post('paid_amount')) {
                    $return = 1;
                } else {
                    $return = 2;
                }
                ////////////////////////////////
                $this->db->trans_commit();

                return $return;
            }
        } ////end of try
        catch (error $e) {
            log_message('error', $this->db->db_debug);
        }
    }

    public function redirectForPatta()
    {
        $case = $this->input->get('case_no');
        $this->load->helper('qrcode');
        $base_64 = printQR('https://basundhara.assam.gov.in/vo/id=' . $case);
        $data['qrcode'] = $base_64;
        $data['case_no'] = $case;
        $sql = "Select * from settlement_basic where case_no=? and status='F' ";
        $data['basic'] = $caseDetails = $this->db->query($sql, array($case))->row_array();
        $data['distName'] = $this->utilityclass->getDistrictName($caseDetails['dist_code']);
        $data['cirName'] = $this->utilityclass->getCircleName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code']);
        $data['mouName'] = $this->utilityclass->getMouzaName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code']);
        $data['villName'] = $this->utilityclass->getVillageName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code'], $caseDetails['lot_no'], $caseDetails['vill_townprt_code']);
        $sql1 = "select * from settlement_notice WHERE case_no =  ? ";
        $data['notice'] = $this->db->query($sql1, array($case))->row_array();
        $sql2 = "select array_to_string(ARRAY_AGG (pdar_name),',') as applicant_name,
        array_to_string(ARRAY_AGG (pdar_guardian),',') as father_name from settlement_applicant
        WHERE case_no =  ? and pdar_type='B'";
        $data['applicant'] = $this->db->query($sql2, array($case))->row_array();
        //////////////
        $sql3 = "select array_to_string(ARRAY_AGG (new_dag_no),',') as dags,
                sum(home_b+agri_b) as bigha,sum(home_k+agri_k) as katha,sum(home_lc+agri_lc) as lessa,
                array_to_string(ARRAY_AGG (land_type),',') as types,string_agg(distinct(is_urban),',') as rural_urban
                from settlement_dag_details
                where case_no=?";
        $data['dags'] = $this->db->query($sql3, array($case))->row_array();
        $sql3 = "select new_dag_no,new_patta_no,new_dag_revenue,new_local_tax,new_land_class_code,
            home_b+agri_b as bigha,home_k+agri_k as katha,
            home_lc+agri_lc as lessa,is_urban
                from settlement_dag_details
                where case_no=?";
        $data['patta'] = $this->db->query($sql3, array($case))->result_array();
        //////////////
        $data['_view'] = 'Bhoodan/Bhoodanpatta';
        $this->load->view('layouts/main', $data);
    }
    //End of Class
}
