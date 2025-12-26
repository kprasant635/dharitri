<?php
class NcKhaslandCoController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');

        $this->load->model('NcModel/NcApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('NcModel/NcServiceModel');
        $this->load->model('NcModel/NcCommonModel');

        $this->ncutility->dbSwitchSession();
        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code != 'CO' && $user_desig_code !='SK'){
            $this->session->set_flashdata('message', "#COKHAS2503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
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



    // New area check By Masud Reza
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->NcServiceModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->NcCommonModel->getAppliedSettlementDag($application_no);
        $basic = $this->NcCommonModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {

            $totalAreaInApplication        = 0;
            $totalAreaInLMApplication      = 0;
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


            $chithaDag = $this->NcCommonModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->NcCommonModel->getAllDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            //  all lm processing application but  SDO/ADC/DC not proceeded
            $allLmProcess = $this->NcCommonModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);


            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }

                    }
                }
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }
            }
            else
            {
                // chitha
                $bighaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->NcCommonModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->NcCommonModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->NcCommonModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }
                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->NcCommonModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
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


    // check applied area more than dag area
    public function checkAppliedAreaMoreThanDagArea($application_no)
    {

        $dags                     = $this->NcServiceModel->getSettlementDag($application_no);
        $appDistrict              = $this->session->userdata('dist_code');;
        $appAreaMoreThanDagA      = 0;
        $appAreaMoreThanDagSingle = 0;
        $rezaDagTotal             = 0;
        $rezaAppTotalHome         = 0;
        $rezaAppTotalAgri         = 0;
        $appAreaMoreThanDagArray  = [];
        foreach ($dags as $dag)
        {

            $totalDagArea = 0;
            $totalAppliedInDagHome = 0;
            $totalAppliedInDagAgri = 0;
            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // Dag
                $bighaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_b, 0);
                $kathaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_k, 0);
                $lessaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_lc, 0);
                $gandaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_g, 0);
                $totalDagArea = ($bighaInDag * 6400) + ($kathaInDag * 320) + ($lessaInDag * 20) + $gandaInDag;

                // home
                $bighaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_b, 0);
                $kathaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_k, 0);
                $lessaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_lc, 0);
                $gandaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_g, 0);
                $totalAppliedInDagHome = ($bighaInDagAppliedHome * 6400) + ($kathaInDagAppliedHome * 320) + ($lessaInDagAppliedHome * 20) + $gandaInDagAppliedHome;

                // Agri
                $bighaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_b, 0);
                $kathaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_k, 0);
                $lessaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_lc, 0);
                $gandaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_g, 0);
                $totalAppliedInDagAgri = ($bighaInDagAppliedAgri * 6400) + ($kathaInDagAppliedAgri * 320) + ($lessaInDagAppliedAgri * 20) + $gandaInDagAppliedAgri;

                if ($totalDagArea < $totalAppliedInDagHome + $totalAppliedInDagAgri)
                {
                    $appAreaMoreThanDagArray[] = 1;
                }
                $rezaDagTotal += $totalDagArea;
                $rezaAppTotalHome += $totalAppliedInDagHome;
                $rezaAppTotalAgri += $totalAppliedInDagAgri;

            }
            else
            {
                // Dag
                $bighaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_b, 0);
                $kathaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_k, 0);
                $lessaInDag = $this->NcCommonModel->defaultValue($dag->dag_area_lc, 0);
                $totalDagArea = ($bighaInDag * 100) + ($kathaInDag * 20) + $lessaInDag;

                // home
                $bighaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_b, 0);
                $kathaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_k, 0);
                $lessaInDagAppliedHome = $this->NcCommonModel->defaultValue($dag->home_lc, 0);
                $totalAppliedInDagHome = ($bighaInDagAppliedHome * 100) + ($kathaInDagAppliedHome * 20) + $lessaInDagAppliedHome;

                // Agri
                $bighaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_b, 0);
                $kathaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_k, 0);
                $lessaInDagAppliedAgri = $this->NcCommonModel->defaultValue($dag->agri_lc, 0);
                $totalAppliedInDagAgri = ($bighaInDagAppliedAgri * 100) + ($kathaInDagAppliedAgri * 20) + $lessaInDagAppliedAgri;

                if ($totalDagArea < $totalAppliedInDagHome + $totalAppliedInDagAgri)
                {
                    $appAreaMoreThanDagArray[] = 1;
                }
                $rezaDagTotal += $totalDagArea;
                $rezaAppTotalHome += $totalAppliedInDagHome;
                $rezaAppTotalAgri += $totalAppliedInDagAgri;
            }
        }

        if($rezaDagTotal < $rezaAppTotalHome + $rezaAppTotalAgri)
        {
            $appAreaMoreThanDagA = 1;
        }

        if(in_array(1,$appAreaMoreThanDagArray))
        {
            $appAreaMoreThanDagSingle = 1;
        }

        $dagArea = array(
            'appAreaMoreThanDagA'      => $appAreaMoreThanDagA,
            'appAreaMoreThanDagSingle' => $appAreaMoreThanDagSingle,
        );

        return $dagArea;



    }


    // Settlement Khas CO view starts here -md-
    public function settlementKhasCo()
    {
        $application_no = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == 'SK')
        {
            $this->ncutility->authCheckCoSk($application_no, 'SK');
            $this->ncutility->checkUserAuthForCaseForSk($application_no);

        }
        else if ($user_desig_code == 'CO')
        {
            $this->ncutility->authCheckCoSk($application_no, 'CO');
            $this->ncutility->checkUserAuthForCaseForCo($application_no);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $basic = $this->NcServiceModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->NcServiceModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->NcServiceModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->NcServiceModel->getAllApplicantEncroacher($application_no);
        $lmdata = [];
        $dags = $this->NcServiceModel->getSettlementDag($application_no);
        $lmnotes = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->NcServiceModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->NcServiceModel->getDocuments($application_no);
        $nominee = $this->NcServiceModel->getAllNomineeDetail($application_no);

        $lmdata['basic'] = $basic;
        $lmdata['nominee'] = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;

        $lmdata['checkAdditionalProperty'] = $this->NcCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        // if (isset($applicants_buyers)) {
        //     if ($applicants_buyers) {
        //         foreach ($applicants_buyers as $adhar_photo) {
        //             if ($adhar_photo->is_applicant == 1) {
        //                 if (trim($adhar_photo->identity_type) == 'AADHAAR') {
        //                     $adhar_photo_link = $adhar_photo->identity_doc_link;

        //                     $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
        //                     $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        //                     fclose($open_adhar_file);
        //                     // decoding the base64 encoding file variable

        //                     $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        //                 }
        //             }
        //         }
        //     }
        // }

        $applid = $this->ncutility->getApplidFromCaseNo($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        $url = API_LINK_MB3."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $applid,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->ncutility->curlPost($url, $arrayData);

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


        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->NcServiceModel->getJsonDataFromBackup($application_no);
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

        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;

        // $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        // $basundhara = $this->db->query($sql)->row();
        // $token = $this->ncutility->createTokenJwt();
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
        $lmdata['premium'] = $this->NcCommonModel->getPremium($application_no);
        $lmdata['reservation'] = $this->NcServiceModel->getSettlementReservation($application_no);
        $lmdata['additional_property'] = $this->NcServiceModel->getAdditionalProperty($application_no);

        foreach($lmdata['applicants_encroacher'] as $applicant_enc){
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->ncutility->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

            if($enc_check->num_rows() > 0){
                $added_enc_data[] = $enc_check->row();
            }
        }
        if(isset($added_enc_data)){
            $lmdata['new_added_enc_data'] = $added_enc_data;
        }

        //********check if SDO exist for that area */
        $headQtrCheck = $this->NcCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->NcCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
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

        $areaModificationCheck = $this->NcCommonModel->checkIfAreaModified($application_no);

        if(isset($areaModificationCheck)){
            if($areaModificationCheck){
                foreach($areaModificationCheck as $areaHis){
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

                        $total_applied_area_home_in_ganda = $this->ncutility->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda = $this->ncutility->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->ncutility->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->ncutility->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }

                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->ncutility->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa = $this->ncutility->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->ncutility->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->ncutility->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

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
        $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];


        $checkAppliedArea = $this->checkAppliedAreaMoreThanDagArea($application_no);

        $lmdata['appAreaMoreThanDagArea']   = $checkAppliedArea['appAreaMoreThanDagA'];
        $lmdata['appAreaMoreThanDagSingle'] = $checkAppliedArea['appAreaMoreThanDagSingle'];


        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = $this->NcCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->NcCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->NcCommonModel->getRejectModal(NC_KHAS_LAND_ID);
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
            if($val_bypas->SERVICE_CODE == NC_KHAS_LAND_ID)
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

        $dagRequest = 0;
        if($basic['dag_request'] == 1)
        {
            $dagRequest = 1;
        }


        $lmdata['dagRequest'] = $dagRequest;
        $lmdata['adcUsers'] = $this->NcCommonModel->adcSelect($basic['dist_code']);


        $lmdata['_view'] = 'NcVillageService/Common/SettlementKhasCoView';
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
            $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);
            $get_dag_details = $this->NcServiceModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->NcServiceModel->getAllApplicant($case_no);

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
            $data['print_data'] = $this->NcServiceModel->getSettlementBasic($case_no);
            // reading the base64 json file and saving it to a variable
            $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_app_notice_link']);
            if($path == false){
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
        //         $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;
        //         $rmk = 'Rejected by ' . $designation.': '.$rejectedReasonList;
        //         $status = 'R';
        //         $task = $designation;
        //         $pen  = 'NA';
        //         $task = trim($this->session->userdata('user_desig_code'));
        //         $rtps_status = $this->NcApiModel->postApiBasundharaForRejectedCase2nd($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);
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
        if(isset($_POST['co_rejection_disagree']))
        {
            if($_POST['co_rejection_disagree'] == 'co_rejection_disagree')
            {
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
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
                if ($this->db->trans_status() == false)
                {
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
                    $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;

                    $rmk='Reverted to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status) != "y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
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
                $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Reverted to LM';
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0032114: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
            }

        }

        if(isset($_POST['sk_forward_co']))
        {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co_note');

            $basic_status = $this->NcCommonModel->getCurrentBasicStatus($case_no);

            if($basic_status == 'X')
            {
                $status = 'X';
            }
            else
            {
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

            if($status == 'W')
            {
                $updateArr['co_code'] = $this->input->post('co_code');
            }

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if($this->db->affected_rows() == 0 ){
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
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
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
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to foward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{

                //////////////POST To basundhara////////////////////
                $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Forwarded to CO';
                $status='M';
                $task='SK';
                $pen='CO';
                $case=$case_no;
                $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
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
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $adc_code = $this->input->post('adc_code');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');



            $this->db->trans_begin();


            // new code --- MR

            $sql = $this->db->query("SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?",
                array($case_no, PRO_CASE_STATUS_REVERTED));
            if($sql->num_rows() > 0)
            {

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
                    'adc_code'        => $adc_code
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() == 0)
                {
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

                if ($this->db->affected_rows() == 0)
                {
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
                if ($proceeding_id == null)
                {
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
                if ($insertProc != 1)
                {
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
                if ($proceeding_id_dc == null)
                {
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
                if ($insertProDC != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    echo json_encode($data);
                    return false;
                }
                else
                {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;

                    $rmk='Send to SDLAC';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }else{
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR




            // $applicants_riotee_nok = $this->NcServiceModel->getAllApplicantRioteeNok($case_no);
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

            $get_settlement_basic2 = $this->NcServiceModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->NcCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'ADC';
                $pending_office = 'DC';
            }else{
                $pending_officer = 'SDO';
                $pending_office = 'DC';
            }


            //////proceeding if sk report not submitted//////
            if($from_office_check == 'LM'){

                $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

                if($proceeding_sk_check->num_rows() <= 0) {

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
                'adc_code'        => $adc_code
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
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
                'task' => 'Forwarded to '.$pending_officer,
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

                $application_no = $this->NcServiceModel->getSettlementBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='M';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
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
        $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->NcServiceModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->NcServiceModel->getAllApplicant($case_no);

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
        $data['select_data'] = $this->NcCommonModel->locationSelect($service_code, $status);

        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending($service_code);

        if(trim($status) == 'W')
        {
            $data['_view'] = 'NcVillageService/Common/first_proceeding_co_bulk';
        }
        else
        {
            $data['_view'] = 'NcVillageService/Common/first_proceeding_co';
        }

        $this->load->view('layouts/main', $data);
    }

    public function generatePaymentNoticeCo()
    {
        if(isset($_GET['case'])){
            $case_no = $this->input->get('case');

            $case_under_wetland = $this->NcCommonModel->caseUnderDeptOrDCByWetLand($case_no);

            // $case_under_wetland = $this->NcCommonModel->caseUnderDeptOrDCByWetLand($case_no);
            $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);

            if($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DC')
            {
                log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no '. $case_no. 'and query is '.$this->db->last_query());
                $error_msg_new = array('status'=>1,'message'=>'#ERROR1460: Dag no. found as wetland area please check chitha dag flag for case no'.$case_no);
                $this->session->set_flashdata('message',"--".$error_msg_new['message']);
                redirect(base_url() . 'index.php/home/index');
            }

            if($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 0 && $get_settlement_basic->from_office == 'DC')
            {
                log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no '. $case_no. 'and query is '.$this->db->last_query());
                $error_msg_new = array('status'=>1,'message'=>'#ERROR1460: Dag no.found as wetland area please check chitha dag flag for case no'.$case_no);
                $this->session->set_flashdata('message',"--".$error_msg_new['message']);
                redirect(base_url() . 'index.php/home/index');
            }

            if($case_under_wetland == 0 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DC')
            {
                //   ********** update basic wetland******* and insert into proceeding
                $this->db->trans_begin();

                $basicUpdateArr = [
                    'is_wed_land' => 0,
                    'date_update' => date('Y-m-d H:i:s'),
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicUpdateArr);

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1490: Unable to update settlement_basic '. $case_no. 'and query is '.$this->db->last_query());
                    $error_msg_new = array('status'=>1,'message'=>'#ERROR1490: Unable to process for case no'.$case_no);
                    $this->session->set_flashdata('message',"--".$error_msg_new['message']);
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

                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1523: Unable to update settlement_proceeding '. $case_no. 'and query is '.$this->db->last_query());

                    $error_msg_new = array('status'=>1,'message'=>'#ERROR1523: Unable to process for case no'.$case_no);
                    $this->session->set_flashdata('message',"--".$error_msg_new['message']);
                    redirect(base_url() . 'index.php/home/index');
                }

                $this->db->trans_commit();
            }

            //check whether dag in wetland--------------
            if($case_under_wetland == 1){
                // $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);
                if($get_settlement_basic->from_office != 'DPT'){
                    log_message('error', '#ERROR990039876: Dag no. under wetland area and not approved by Dept Case No '. $case_no);
                    $error_msg_new = array('status'=>1,'message'=>'#ERROR990039876: Dag no. under wetland area and not approved 
                    by Department for case no'.$case_no);
                    $this->session->set_flashdata('message',"--".$error_msg_new['message']);
                    redirect(base_url() . 'index.php/home/index');
                }

            }


            $query2  = "select amount_dag, final_amount, due_amount, case_no from settlement_premium where is_final=1 and case_no ='$case_no'";
            $result2 = $this->db->query($query2)->result_array();
            if (count($result2) > 1)
            {
                $amount_dag = 0;
                foreach ($result2 as $key2 => $values)
                {
                    $amount_dag = $amount_dag + $values['amount_dag'];
                }
                $final_amount = $result2[0]['final_amount'];

                if ($final_amount != $amount_dag)
                {
                    $this->db->query("UPDATE settlement_premium SET due_amount = ?,final_amount = ? 
                        WHERE case_no = ? AND is_final = 1",
                        [$amount_dag,$amount_dag, $case_no]);
                    if ($this->db->affected_rows() == 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR99003: Unable to recalculate premium. Case No ' . $case_no .
                            ' and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('message', "Unable to recalculate premium. Case No: " . $case_no);
                        redirect(base_url() . 'index.php/home/index');
                    }
                }
            }



            $this->db->trans_begin();
            $settlement_premium_insertion = $this->NcCommonModel->premiumReCalculation($case_no);

            $data['old_dag_flag_message'] = false;

            if($settlement_premium_insertion!=null && $settlement_premium_insertion['status'] == 3)
            {
                $data['old_dag_flag_message'] = '<h5 class="alert-danger text-danger text-center">Old dag area flag found for this case, please check premium amount and area, if found accurate then proceed. If you want to update the premium, you can use modification request</h5>';

                $data['old_dag_flag_button'] = '<div class="row justify-content-center">
                                                    <button type="submit" name="generate_notice" id="btnNotice" class="m-2 col-4 btn btn-success btn-sm">Agree with old premium and generate notice</button> 

                                                    <a href="'.base_url().'index.php/SettlementModification/caseListForPullRequest?service=16" type="button" id="disagree" class="m-2 col-4 btn btn-danger btn-sm">Request for modification</a>
                                                </div>';
            }
            else
            {
                if($settlement_premium_insertion!=null && $settlement_premium_insertion['status'] == 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR99003: Unable to re calculate premium. Case No '. $case_no. 'and query is '.$this->db->last_query());
                    $this->session->set_flashdata('message',"--".$settlement_premium_insertion['message']);
                    redirect(base_url() . 'index.php/home/index');

                }
            }

            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }

            $finalAreaCheck = $this->NcCommonModel->finalAreaCheck($case_no);

            if($finalAreaCheck['responseType'] != 2)
            {
                $this->session->set_flashdata('message',"--".$finalAreaCheck['msg']);
                redirect(base_url() . 'index.php/home/index');
            }

            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            $data['basic'] = $this->NcServiceModel->getSettlementBasicCo($case_no);
            $data['dags'] = $this->db->query("select sd.*,sr.bigha,sr.katha,sr.lessa,sr.ganda,sr.is_deleted,sp.total_lessa from settlement_dag_details sd 
            left join (select * from settlement_reservation where is_deleted=0) sr 
            on sd.case_no = sr.case_no and sr.dag_no = sd.dag_no
            join (select total_lessa,case_no,dag_no from settlement_premium where is_final=1) sp on sp.case_no=sd.case_no and sp.dag_no=sd.dag_no 
            where sd.case_no='$case_no'")->result();

            //*******general caste or reserve caste check */

            $data['caste'] = $get_settlement_basic->caste;

            $applicants_buyers   = $this->NcServiceModel->getAllApplicantBuyers($case_no);

            foreach($applicants_buyers as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['if_widow'] = $applicant->marital_status;
                }
            }

            if(!isset($data['if_widow']))
            {
                log_message('error', '#ERROR151220231026: Marital status not found! '. $case_no);
                $this->session->set_flashdata('message',"#ERROR151220231026: Something went wrong! ".$case_no);
                redirect(base_url() . 'index.php/home/index');
            }

            $data['concessionCheck'] = false;
            $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', array($case_no, 1));

            if($concenSql->num_rows() <= 0)
            {
                log_message('error', '#ERROR151220231155: Something went wrong! Unable to process... '. $case_no);
                $this->session->set_flashdata('message',"#ERROR151220231155: Something went wrong! Unable to process ".$case_no);
                redirect(base_url() . 'index.php/home/index');
            }

            if($concenSql->row()->concession == 'YES')
            {
                if(trim($data['caste']) == '6' && trim($data['if_widow']) != '4')
                {
                    $data['concessionCheck'] = '<span class="text-danger text-center"><h5><b>Applicant applied as general caste but LM had done the premium calculation for reserved caste category! Do you want to remove concession and recalculate premium OR Continue with concession?</b></h5></span>';

                    $data['concessionRecalculate'] = '<div class="row justify-content-center">
                                                    <button type="button" onclick="reCalculatePremiumWithOutConcession(\''.$case_no.'\', \'NO\')" class="m-2 col-4 btn btn-success btn-sm">Re-Calculate Premium without Concession</button> 
    
                                                    <button type="submit" name="generate_notice" id="btnNotice" class="m-2 col-4 btn btn-warning btn-sm">Proceed with concession</button>
                                                </div>';
                }
            }

            $data['_view'] = 'NcVillageService/Common/generateNoticeViewNew';
            $this->load->view('layouts/main', $data);
        }

    }

    public function generatePaymentNoticeCoSave()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark_co');
        $applicant_buyer = $this->NcServiceModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);

        $data = [
            'case_no' => $case_no,
            'remark' => $remark,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if($get_settlement_basic->pull_request == '1')
        {
            $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to modification request active # ".$case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        if(isset($applicant_buyer))
        {
            foreach($applicant_buyer as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                    $marital_status = $applicant->marital_status;
                }
            }
        }

        $basic = $this->NcServiceModel->getSettlementBasic($case_no);

        if(isset($basic))
        {
            if($basic['service_code'] == SETTLEMENT_TENANT_ID){
                $data['service_name'] = 'Settlement Occupency Tenant';
            }elseif($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID){
                $data['service_name'] = 'Settlement AP';
            }elseif($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID){
                $data['service_name'] = 'Settlement Tribal Community';
            }elseif($basic['service_code'] == SETTLEMENT_KHAS_LAND_ID){
                $data['service_name'] = 'Settlement Khasland';
            }elseif($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID){
                $data['service_name'] = 'Settlement PGR/VGR land';
            }elseif($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID){
                $data['service_name'] = 'Settlement Special Cultivators';
            }elseif($basic['service_code'] == NC_KHAS_LAND_ID){
                $data['service_name'] = 'Settlement of land in surveyed N.C. village under SVAMITVA';
            }

            $data['case_no']        = $basic['case_no'];
            $data['application_no'] = $basic['applid'];

            $data['dist_name']   = $this->ncutility->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->ncutility->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name']  = $this->ncutility->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->ncutility->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->ncutility->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            if($basic['sdlac_date'] == null || $basic['sdlac_date'] == '' || empty($basic['sdlac_date']))
            {
                $this->session->set_flashdata('message', "#ERR203934: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

            $data['dept_order_no'] = $basic['dept_order_no'];
            $data['dept_order_date'] = date('d/m/Y', strtotime($basic['dept_order_date']));
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR1917: Unable to process! Something went wrong...#".$case_no);
            redirect(base_url().'index.php/home');
        }

        $dags = $this->NcServiceModel->getSettlementDag($case_no);


        $urbanByLm = $this->NcCommonModel->getLandFallsUnderUrban($case_no);

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type, spr.mb_land, spr.max_land FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if($premium_data->num_rows() > 0)
        {
            $caseUrban =null;
            $premium_data_row = $premium_data->row();
            $premium_data_arr = $premium_data->result();

            $oldDagArray = array(1,2,3,4,5,6);

            $urbanArray = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
            $ruralArray = array(7,8,9,10,18,19,20,21,22);


            if(!isset($dags))
            {
                //****show error */
                $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            foreach($dags as $dag_item)
            {
                $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));

                if($premiumSql->num_rows() <= 0)
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $premData = $premiumSql->row();

                if(in_array($premData->area_name, $urbanArray))
                {
                    $caseUrban="Y";
                }
                else if(in_array($premData->area_name, $ruralArray))
                {
                    $caseUrban="N";
                }
                else
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR20466: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }
            }

            //*******for rural case */
            if($caseUrban =='N'){
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach($premium_data_arr as $premium)
                {

                    // if(trim($premium->concession) == 'YES')
                    // {
                    //     if($basic['caste'] == '6' && $marital_status !='4')
                    //     {
                    //         $this->session->set_flashdata('message', "#ERR2047: Applicant applied as general caste but LM had done the premium calculation for special caste category! #".$case_no);
                    //         redirect(base_url().'index.php/home');
                    //     }
                    // }

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if(trim($premium->concession) == 'YES')
                    {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        // $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
                        $data['premium_payable_without_concession'] = ceil($data['net_premium_payable'] / 0.75);
                        $data['concession_amount'] = ceil($data['premium_payable_without_concession'] * 0.25);
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
//                        $data['actual_premium'] = (float)$data['premium_payable_without_concession'] * 5;
                        $data['actual_premium'] = (float)$data['premium_payable_without_concession'];
                    }
                    else
                    {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
//                        $data['actual_premium'] += (float)$premium->amount_dag * 5;
                        $data['actual_premium'] += (float)$premium->amount_dag;
                    }

                    // $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa);
                    }
                    else
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    $area_all_barak[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                }

                $data['area'] = implode ( ", ", $area_all );
                $data['area_barak'] = implode ( ", ", $area_all_barak );
                $data['dag_no'] = implode ( ", ", $dag_arr );

                if($data['type_of_concession'] == '-')
                {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                }
                else
                {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
            if($caseUrban =='Y') /////consider as urban case
            {
                // if($urbanByLm->falls_und_gmc == YES)
                // {
                //     $this->session->set_flashdata('message', "#ERR2033: Case falls under 15km of GMC, unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                // if($basic['is_wed_land'] == null || $basic['is_wed_land'] == '' || empty($basic['is_wed_land']))
                // {
                //     $case_under_wetland = $this->NcCommonModel->caseUnderDeptOrDCByWetLand($case_no);
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


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                // $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {

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

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';


                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];

                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );


                    $total_amount = $premium->amount_dag;

                    $mbAreaLimit = $premium->mb_land;
                    $maxLand = $premium->max_land;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {

                        if($mbAreaLimit == 25){
                            $mbAreaLimit=1600;
                        }else if ($mbAreaLimit == 30){
                            $mbAreaLimit=1920;
                        }else if ($mbAreaLimit == 40){
                            $mbAreaLimit=2560;
                        }

                        if($maxLand == 40){
                            $maxLand=2560;
                        }else if ($maxLand == 60){
                            $maxLand=3840;
                        }

                    }

                    if(in_array($premium->area_name, $oldDagArray))
                    {
                        //******if dist code kamrup metro (told by muzammil da) */
                        if($get_settlement_basic->dist_code == '24')
                        {
                            $mbAreaLimit = 25;

                            if($premium->total_lessa > 25)
                            {
                                $this->session->set_flashdata('message', "#ERR2192: Unable to process due to old dag area flag...#".$case_no);
                                redirect(base_url().'index.php/home');
                            }
                        }
                        else
                        {
                            $mbAreaLimit = 30;
                            if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))){
                                $mbAreaLimit = 1920;
                            }


                            if($premium->total_lessa > $mbAreaLimit)
                            {
                                $this->session->set_flashdata('message', "#ERR2193: Unable to process due to old dag area flag...#".$case_no);
                                redirect(base_url().'index.php/home');
                            }
                        }
                    }

                    //****getting the zonal value in lessa */
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $zonalValue = $premium_per_bigha / 6400;
                    }
                    else
                    {
                        $zonalValue = $premium_per_bigha / 100;
                    }

                    $exceed_area = false;
                    $exceed_premium_per_bigha = false;
                    $exceedPremium = false;

                    if(trim($premium->concession) == 'YES')
                    {
                        if($premium->rate == '100')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //****for 100% premium */ if applied area less than the mb limit area
                                // 30%
                                $limitPremium = $mbAreaLimit * $zonalValue;
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
                                //******if applied area is greather than the mb limit area  */
                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $total_amount = $total_amount / 0.75;
                                $concession_amount = floor($total_amount * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                            }
                        }
                        else if($premium->rate == '30')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = ($mbAreaLimit * ($zonalValue * 30/100));
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
                                //******if applied area is greather than the mb limit area  */

                                $allowedPremium = $total_lessa * ($zonalValue * 30/100);
                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($allowedPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = $allowedPremium;
                            }

                        }
                        else if($premium->rate == '10')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = $mbAreaLimit * ($zonalValue * 10/100);
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
                                //******if applied area is greather than the mb limit area  */

                                $allowedPremium = ($total_lessa * ($zonalValue * 10/100));
                                $type_of_concession = 'ST/SC/Widow/Person with disabilities';
                                $concession_amount = floor($allowedPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = $allowedPremium;
                            }
                        }

                    }
                    else
                    {
                        if($premium->rate == '100')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //****for 100% premium */ if applied area less than the mb limit area
                                // 30%
                                $limitPremium = $mbAreaLimit * $zonalValue;
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
                                //******if applied area is greather than the mb limit area  */
                                // $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $total_amount = $total_amount;
                                // $concession_amount = floor($total_amount * 0.25);
                                // $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                            }
                        }
                        else if($premium->rate == '30')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = ($mbAreaLimit * ($zonalValue * 30/100));
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
                                //******if applied area is greather than the mb limit area  */
                                $total_amount = $total_amount;

                                // $allowedPremium = $total_lessa * ($zonalValue * 30/100);
                                // $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                // $concession_amount = floor($allowedPremium * 0.25);
                                // $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                // $total_amount = $allowedPremium;
                            }

                        }
                        else if($premium->rate == '10')
                        {
                            if($total_lessa  > $mbAreaLimit)
                            {
                                //*****For 30% premium */
                                // 30%
                                $limitPremium = $mbAreaLimit * ($zonalValue * 10/100);
                                // 150% 
                                $exceedPremium = ($total_lessa - $mbAreaLimit) * ($zonalValue * 150/100);

                                $allowedPremium = $limitPremium + $exceedPremium;

                                $type_of_concession = 'ST/SC/Widows/Person with disabilities';
                                $concession_amount = floor($limitPremium * 0.25);
                                $concession_mission_govt_notification_no = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                                $total_amount = ceil($limitPremium);

                                //****area distribution */
                                //***limit area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                $exceed_premium_per_bigha = $premium_per_bigha * 1.5;

                            }
                            else
                            {
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
                    if($exceedPremium != false)
                    {
                        $loloCounter++;

                        $exceed_pre = '<tr>
                                            <td>
                                                <b><u>অতিৰিক্ত ভূমি</u></b> <br>
                                                <p style="line-height: 1.6!important;">
                                                * ('.$exceed_area.') - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No.RDM-12011(17)/15/2022-LR-REV-R&DM/14  dtd 21-Aug-2023  আৰু File No. E-40550/5 dtd.20-Nov2023 মৰ্মে অনুমোদিত অতিৰিক্ত ভূমিৰ প্ৰিমিয়াম হিচাপে মাণ্ডলিক মূল্যৰ ১৫০% 
                                                </p>
                                            </td>
                                            <td>'.$exceed_premium_per_bigha.'</td>
                                            <td>'.$dag_no.'</td>
                                            <td style="white-space: nowrap;">'.$exceed_area.'</td>
                                            <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$exceedPremium.'</td>
                                        </tr>';
                    }

                    $consc = '';
                    if($type_of_concession != false)
                    {
                        $loloCounter++;

                        $consc = '<tr>
                                    <td>
                                        <b><u>বিশেষ শ্ৰেণীৰ বাবে ৰেহাই</u></b> <br>
                                        <p style="line-height: 1.6!important;">
                                            অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 মৰ্মে  প্ৰিমিয়ামৰ ২৫% ৰেহাই '.$area.' লৈকে
                                        </p>
                                    </td>
                                    <td>'.$type_of_concession.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">-₹ '.$concession_amount.'</td>
                                </tr>';
                    }

                    if($premium->rate == '100')
                    {
                        // আৰ.চি.চি. ঘৰ * ১ ক :/২ক:৫লে:/১০লে: লৈকে - মাণ্ডলিক মূল্যৰ ১০০% *অতিৰিক্ত ভূমি - মাণ্ডলিক মূল্যৰ ১৫০%

                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        <b><u>আৰ.চি.চি. ঘৰ</u></b>
                                        <br> 
                                        <p style="line-height: 1.6!important;">
                                        * '.$area.': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়াম হিচাপে মাণ্ডলিক মূল্যৰ ১০০%
                                        </p>
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$total_amount.'</td>
                                </tr>
                                '.$exceed_pre.$consc.'';
                    }

                    if($premium->rate == '30')
                    {
                        $trArr .=  '<tr>
                                        <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                        <td>
                                            <b><u>অসম আৰ্হিৰ ঘৰ/চালি ঘৰ</u></b><br>
                                            
                                            <p style="line-height: 1.6!important;">* '.$area.': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়ামৰ ৰেহাই হাৰ হিচাপে মাণ্ডলিক মূল্যৰ ৩০%
                                            </p>
                                            
                                        </td>
                                        <td>'.$premium_per_bigha.'</td>
                                        <td>'.$dag_no.'</td>
                                        <td style="white-space: nowrap;">'.$area.'</td>
                                        <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$total_amount.'</td>
                                    </tr>    
                                    
                                    '.$exceed_pre.$consc.'';
                    }

                    if($premium->rate == '10')
                    {
                        $trArr .= '<tr>
                                        <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                        <td>
                                            <b><u>চালি ঘৰ</u></b><br>
                                            <p style="line-height: 1.6!important;"> * '.$area.': লৈকে - অসম চৰকাৰৰ ৰাজহ আৰু দুৰ্যোগ ব্যবস্থাপনা বিভাগৰ অধিসূচনা No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 dtd 11-Nov-2022 আৰু No. RSS.532/2011/Pt/152 dtd.21-Feb-2014 মৰ্মে  অনুমোদিত ভূমিৰ প্ৰিমিয়ামৰ ৰেহাই হাৰ হিচাপে মাণ্ডলিক মূল্যৰ ১০%
                                            </p>

                                        </td>
                                        <td>'.$premium_per_bigha.'</td>
                                        <td>'.$dag_no.'</td>
                                        <td style="white-space: nowrap;">'.$area.'</td>
                                        <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$total_amount.'</td>
                                    </tr>

                                    '.$exceed_pre.$consc.'';
                    }
                }

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>প্ৰকৃত /চূড়ান্ত দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['tbody'] = $trArr;

            }
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
            redirect(base_url().'index.php/home');
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType != 'y'){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);

        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

//        $this->load->helper('qrcode');
//        $base_64 = printQR('https://sewasetu.assam.gov.in/');
//        $data['qrcode'] = $base_64;

        $this->load->helper('qrcode');
        //$base_64 = printQR('https://sewasetu.assam.gov.in/');
        $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
        $data['qrcode'] = ','.$base_64;


        // if(trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES)
        if($caseUrban =='N') /////consider as rural case
        {
            $this->load->view('NcVillageService/Common/rural_notice', $data);
            // $this->load->view('SettlementView/include/urban_notice', $data);

            // $this->session->set_flashdata('message', "Rural Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
        }
        // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
        if($caseUrban =='Y')/////consider as urbam case
        {
            $this->load->view('NcVillageService/Common/urban_notice', $data);

            // $this->session->set_flashdata('message', "Urban Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
        }
    }

    public function printNotice()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->NcServiceModel->getSettlementBasic($case_no);

        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_notice_link']);
        if($path == false){
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
        $data['_view'] = 'NcVillageService/Common/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

    public function premiumNotice($case_no=null)
    {
        // $case_no = 'KAM/PAL/2022-23/3257/SKHAS';
        $applicant_buyer = $this->NcServiceModel->getAllApplicantBuyers($case_no);

        if(isset($applicant_buyer))
        {
            foreach($applicant_buyer as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                }
            }
        }

        $basic = $this->NcServiceModel->getSettlementBasic($case_no);

        if(isset($basic))
        {
            if($basic['service_code'] == SETTLEMENT_TENANT_ID){
                $data['service_name'] = 'Settlement Occupency Tenant';
            }elseif($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID){
                $data['service_name'] = 'Settlement AP';
            }elseif($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID){
                $data['service_name'] = 'Settlement Tribal Community';
            }elseif($basic['service_code'] == SETTLEMENT_KHAS_LAND_ID){
                $data['service_name'] = 'Settlement Khasland';
            }elseif($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID){
                $data['service_name'] = 'Settlement PGR/VGR land';
            }elseif($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID){
                $data['service_name'] = 'Settlement Special Cultivators';
            }elseif($basic['service_code'] == NC_KHAS_LAND_ID){
                $data['service_name'] = 'Settlement of land in surveyed N.C. village under SVAMITVA';
            }

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->ncutility->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->ncutility->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->ncutility->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->ncutility->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->ncutility->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

        }

        $dags = $this->NcServiceModel->getSettlementDag($case_no);

        if(isset($dags))
        {
            foreach($dags as $dag_item)
            {
                $data['isUrban'] = $dag_item->is_urban;
            }
        }

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if($premium_data->num_rows() > 0)
        {
            $premium_data_arr = $premium_data->result();

            //*******for rural case */
            // if(trim($data['isUrban']) == 'N')
            if(trim($data['isUrban']) == 'Y')
            {
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach($premium_data_arr as $premium)
                {

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if(trim($premium->concession) == 'YES')
                    {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
                        $data['concession_amount'] = $data['net_premium_payable'] * 25/100;
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                    }
                    else
                    {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                    }

//                    $data['actual_premium'] += (float)$premium->amount_dag * 5;
                    $data['actual_premium'] += (float)$premium->amount_dag;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_lessa);
                    }
                    else
                    {
                        $bklArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    $area_all_barak[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                }

                $data['area'] = implode ( ", ", $area_all );
                $data['area_barak'] = implode ( ", ", $area_all_barak );
                $data['dag_no'] = implode ( ", ", $dag_arr );

                if($data['type_of_concession'] == '-')
                {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                }
                else
                {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            if(trim($data['isUrban']) == 'Y')
            {

            }
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType != 'y'){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);

        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        $this->load->helper('qrcode');
        $base_64 = printQR('https://sewasetu.assam.gov.in/');
        $data['qrcode'] = $base_64;

        if(trim($data['isUrban']) == 'Y')
        {
            $this->load->view('SettlementView/include/rural_notice', $data);
        }
        if(trim($data['isUrban']) == 'Y')
        {
            // $this->load->view('SettlementView/Co/Khas/paymentNoticeUrban', $data);
        }

    }


    /// NEW LIST FOR RE_GEOTAG ----------------07092023
    public function reGeoTagCaseList()
    {
        $service_code = $this->input->get('service');
        $status = 'Z'; // in query it is checked as not equal to Z status/////
        $data['select_data'] = $this->NcCommonModel->locationSelectReGeotag($service_code, $status);
        $data['_view'] = 'NcVillageService/Common/settlement_mb_re_geotag';
        $this->load->view('layouts/main', $data);
    }


    public function checkWhetherGeoTagorNot()
    {
        $case_no = $this->input->post('case_no');
        $applid = $this->input->post('applid');

        if($case_no == null && $applid == null){
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0002: Enable Re-geotag cancelled...!case no missing',
            ]);
            return false;
        }
        $url = API_LINK_MB3."requestRegeo";

        $arrayData =array(
            'application' => $applid,

        );
        log_message("error","MB001: CALLING URL=======".$url."===PARAMETER===".json_encode($arrayData));
        //*****API call again for geotag available */
        $getAvailable = $this->ncutility->curlPost($url, $arrayData);


        if(isset($getAvailable) && !empty(json_decode($getAvailable)) && trim(json_decode($getAvailable)->status) == 'y'){
            //*****update in settlement_basic */
            $basicArray = [
                're_geotag_status'   => 1
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basicArray);
            if($this->db->affected_rows() !=1)
            {
                log_message('error', '#ERRREGEO0001: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 3,
                    'msg' => '#ERRREGEO0001: Enable Re-geotag cancelled...!',
                ]);
                return false;
            }
            if($this->db->affected_rows() == 1 && trim(json_decode($getAvailable)->status) == 'y') {
                echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Requested for Re-geotag for the case no --'.$case_no,
                ]);
                return false;
            }


        }else{
            log_message('error', '#ERRREGEO0003: Fetching data error');
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0003: Fetching data error',
            ]);
            return false;
        }

    }

    public function getZonalValueBySubclass(){
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $zone = $this->input->post('zone');
        $subclass = $this->input->post('subclass');
        if($case_no == null || $dag_no == null || $zone == null || $subclass == null){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR77412121RRR: Something went wrong please try again...!',
                'data' => null
            ]);
            return false;
        }

        $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);

        $sql = "select vz.land_rate,vz.zone_name,vz.subclass_name,vz.zone_code,vz.subclass_code FROM dagwise_zone_info dz LEFT JOIN villagewise_zone_info vz ON dz.unique_village_code = vz.unique_village_code WHERE dz.flag = '1' AND vz.flag ='1' AND vz.zone_code = ? and vz.subclass_code = ? and dz.unique_village_code = ? AND vz.zone_code::int = dz.zone_id::int AND vz.subclass_code::int = dz.subclass_id::int";

        $queryData = $this->db->query($sql,array($zone,$subclass,$get_settlement_basic->uuid));
        log_message('error','0--------------'.$this->db->last_query());
        if($queryData->num_rows() > 0){
            $queryData = $queryData->row();
            echo json_encode([
                'responseType' => 2,
                'msg' => null,
                'land_rate' => $queryData->land_rate
            ]);
            return false;

        }else{
            log_message('error','#ERR774121RRR--------------'.$this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR774121RRR: Zonal information not found...!',
                'data' => null
            ]);
            return false;
        }
    }


}
