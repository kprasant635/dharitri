<?php
class SettlementTribalCo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
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

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $lmProcessArea = [];
        $chithaDagArray = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
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
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            //  all lm processing application but  SDO/ADC/DC not proceeded
            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

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
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
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
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }
                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
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
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
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
            'chithaArea'   => $chithaDagArray,
            'reservedArea' => $allApplicationDagArray,
            'appliedDags'  => $appliedDags,
            'areaCheck'    => $areaCheck,
            'lmProcessArea'=> $lmProcessArea,

        );

        return $checkAreaDetail;
    }

    // Settlement AP CO view starts here -js-
    public function settlementTribalCo()
    {
        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        if($_GET['case'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $application_no = $this->input->get('case');

        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == 'SK')
        {
            $this->utilityclass->authCheckCoSk($application_no, 'SK');
            $this->utilityclass->checkUserAuthForCaseForSk($application_no);

        }
        else if ($user_desig_code == 'CO')
        {
            $this->utilityclass->authCheckCoSk($application_no, 'CO');
            $this->utilityclass->checkUserAuthForCaseForCo($application_no);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
        $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
        $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
        $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
        //$lmdata=[];
        foreach($applicants_encroacher as $encroacher)
        {
            // getting the encroacher details
            $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
            $encdata=$this->db->query($query)->result();
            $lmdata[] = $encdata;

        }
        $lmdata['encdata']=$lmdata;

        $dags   = $this->SettlementTribalModel->getSettlementDag($application_no);
        $lmnotes   = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->SettlementTribalModel->getSettlementProceeding($application_no);
        $dhardocuments   = $this->SettlementTribalModel->getDocuments($application_no);
        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($application_no);

        $lmdata['basic']=$basic;

        $lmdata['applicants_buyers']=$applicants_buyers;
        $lmdata['applicants_owners']=$applicants_owners;
        $lmdata['applicants_encroacher']=$applicants_encroacher;

        $lmdata['dags']=$dags;
        $lmdata['lmnotes']=$lmnotes;
        $lmdata['proceedings']=$proceedings;
        $lmdata['dhardocuments']=$dhardocuments;
        $lmdata['nominee'] = $nominee;
        $lmdata['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);
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

        foreach($output->selfDeclaration as $selfDec){
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }
        $lmdata['additional_property'] = $this->SettlementTribalModel->getAdditionalProperty($application_no);
        $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

        // if(isset($applicants_buyers)){

        //     if($applicants_buyers){
        //         foreach($applicants_buyers as $adhar_photo){

        //             if($adhar_photo->is_applicant == 1){
        //                 if(trim($adhar_photo->identity_type) == 'AADHAAR'){
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

        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        //****Directory Change */
                        $parts = explode("uploads/", $adhar_photo_link, 2);
                        if (count($parts) > 1) {
                            $path = BACKUP_DIR."uploads/" . $parts[1];
                        }
                        else
                        {
                            $path = $adhar_photo_link;
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
                        else
                        {
                            $adhar_photo_link = $path;
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


        $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

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

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);

                        $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);

                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);

                        $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }

                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);

                        $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);

                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);

                        $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);

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


        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
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

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == SETTLEMENT_TRIBAL_COMMUNITY_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        
        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

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

        $lmdata['_view'] = 'SettlementView/Co/Tribal/SettlementTribalCoView';
        $this->load->view('layouts/main',$lmdata);
    }

    public function generateNoticeCo(){
        // generate notice starts here
        if(isset($_POST['generate_notice'])){
            // var_dump("m here"); die();
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementTribalModel->getSettlementBasicCo($case_no);
            $get_dag_details = $this->SettlementTribalModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementTribalModel->getAllApplicant($case_no);

            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,

            ];

            $this->load->view('SettlementView/Co/Tribal/SettlementNotice',$data);
            // var_dump($hearing_date);
            // die();
        }
        // to print notice
        if(isset($_POST['print_notice'])){
            $case_no = $this->input->post('case_no');
            $data['print_data'] = $this->SettlementTribalModel->getSettlementBasic($case_no);
            $data['_view'] = 'SettlementView/Co/Tribal/PrintNotice';
            $this->load->view('layouts/main',$data);

        }

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
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
    
                    $rmk='Reverted to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
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
        if(isset($_POST['revert_to_lm'])){
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_text = $this->input->post('remark_co_text');

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
                'pending_office' => 'CO'

            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if($this->db->affected_rows() == 0 ){
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
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Revert back to LM'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
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
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                $rmk='Case reverted back to LM';
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");

                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }

        }

        if(isset($_POST['sk_forward_co']))
        {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co_note');

            $basic_status = $this->SettlementCommonModel->getCurrentBasicStatus($case_no);

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
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Forwarded to CO';
                $status='M';
                $task='SK';
                $pen='CO';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
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
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //forward to DC starts here
        if(isset($_POST['forward_to_dc'])){
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_text = $this->input->post('remark_co_text');
            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $this->db->trans_begin();


            // new code --- MR

            $sql = $this->db->query("SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?", array($case_no, PRO_CASE_STATUS_REVERTED));
            if($sql->num_rows() > 0)
            {
                // update basic data
                $updateArrBasic = [
                    'co_code' => $this->session->userdata('user_code'),
                    'co_note_yn' => $remark_co,
                    'date_update' => date('Y-m-d h:i:s'),
                    'status'          => MB_SEND_TO_SDLAC,
                    'pending_office'  => MB_SDLAC,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_proceeding'   => 1,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003: Failed to forward to DC. Kindly contact system administrator',
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
                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003: Failed to forward to DC. Kindly contact system administrator',
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
                    'note_type' => $remark_co,
                    'note_on_order' => $remark_co_text,
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
                    'task' => 'Send to SDLAC.'
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
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk='Send to SDLAC.';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
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

                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR


            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'ADC';
                $pending_office = 'DC';
            }else{
                $pending_officer = 'SDO';
                $pending_office = 'DC';
            }


            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0003: Falied to forward to'.$pending_officer );
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0003: Falied to forward to DC. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
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
                        'task' => 'SK Report not submitted',
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
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Forwarded to '.$pending_officer,
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

                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                $rmk='Forwarded to '.$pending_officer;
                $status='M';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);

                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to $pending_officer");
                    redirect(base_url() . "index.php/home");
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //Re report geo tag starts here
        if(isset($_POST['re_geo_tag'])){

            $case_no = $this->input->post('case_no');
            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

            $status = $this->SettlementApiModel->reReportGeoTag($application_no);
            // var_dump($status); die;
            if (trim($status) != 'y') {
                log_message('error', '#GEO000942: Unable to request Geo tag update, RTPS Case No '.$application_no);
                $this->session->set_flashdata('message', "Error #GEO000942: Unable to request Geo tag update for case no # $case_no");
                redirect(base_url() . "index.php/home");
                exit;
            }else {

                $this->session->set_flashdata('message', "Re-request for geo tag has been successfully submitted for case no # $case_no");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
    }

    public function saveNotice(){
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));

        $hearing_date = $this->input->post('hearing_date');
        $case_no = $this->input->post('case_no');
        $remark_co = $this->input->post('remark_co');
        $get_settlement_basic = $this->SettlementTribalModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementTribalModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementTribalModel->getAllApplicant($case_no);

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
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $htmlstring_text
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);

        if($this->db->affected_rows() == 0 ){
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
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
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
            'task' => 'Notice Generated'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0006: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0006: Failed to generate notice. Kindly contact System Administrator',
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
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Notice successfully saved...");
            redirect(base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case='.$case_no);
        }
    }


    public function FirstProceeding(){
        $service_code=$this->input->get('service');
        $status=$this->input->get('s');
        // // $data['select_range'] = $select_offset = $this->input->post('select_range');

        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending($service_code);

        // echo "<pre>";
        // var_dump($data['getFirstProceeding']);
        // echo $this->db->last_query();

        // $data['_view'] = 'settlement_mb/first_proceeding_co';

        // $this->load->view('layouts/main', $data);


        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
       
        if(trim($status) == 'W')
        {
            $data['_view'] = 'settlement_mb/first_proceeding_co_bulk';
        }
        else
        {
            $data['_view'] = 'settlement_mb/first_proceeding_co';
        }

        // $data['_view'] = 'settlement_mb/first_proceeding_co';
        $this->load->view('layouts/main', $data);
    }


    public function generatePaymentNoticeCo()
    {
        // if(isset($_POST['generate_notice'])){
        //     $payment_amount = $this->input->post('payment_amount');
        //     $case_no = $this->input->post('case_no');
        //     $remark = $this->input->post('remark_co');
        //     $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        //     //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        //     $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        //     $get_owners = $this->SettlementApModel->getOwners($case_no);
        //     $get_buyers = $this->SettlementApModel->getBuyers($case_no);
        //     $get_dag_details = $this->SettlementApModel->getDags($case_no);
        //     $data = [
        //         'payment_amount' => $payment_amount,
        //         'case_no' => $case_no,
        //         'get_settlement_basic' => $get_settlement_basic,
        //         'get_dag_details' => $get_dag_details,
        //         'get_owners' => $get_owners,
        //         'get_buyers' => $get_buyers,
        //         'get_settlement_applicant' => $get_settlement_applicant,
        //         'remark' => $remark,
        //         'pay_notice_date' => date('Y-m-d')
        //     ];

        //     $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
        //     $data['premium_data'] = $premium_data;
        //     $this->load->view('SettlementView/Co/Tribal/paymentNotice',$data);
        // }else{
            $case_no = $this->input->get('case');

        $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

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
            // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            if($get_settlement_basic->from_office != 'DPT'){
                log_message('error', '#ERROR9930258: Dag no. under wetland area and not approved by Department this Case No '. $case_no. 'and query is '.$this->db->last_query());
                $error_msg_new = array('status'=>1,'message'=>'#ERROR9930258: Dag no. under wetland area and not approved by Department this case no'.$case_no);
                $this->session->set_flashdata('message',"--".$error_msg_new['message']);
                redirect(base_url() . 'index.php/home/index');
            }

        }

        $this->db->trans_begin();
        $settlement_premium_insertion = $this->SettlementCommonModel->premiumReCalculation($case_no);

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

        $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);
        if($finalAreaCheck['responseType'] != 2)
        {
            $this->session->set_flashdata('message',"--".$finalAreaCheck['msg']);
            redirect(base_url() . 'index.php/home/index');
        }

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
        $data['premium_data'] = $premium_data;
        $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
        
        $data['dags'] = $this->db->query("select sd.*,sr.bigha,sr.katha,sr.lessa,sr.ganda,sr.is_deleted,sp.total_lessa from settlement_dag_details sd 
        left join (select * from settlement_reservation where is_deleted=0) sr 
        on sd.case_no = sr.case_no and sr.dag_no = sd.dag_no
        join (select total_lessa,case_no,dag_no from settlement_premium where is_final=1) sp on sp.case_no=sd.case_no and sp.dag_no=sd.dag_no 
        where sd.case_no='$case_no'")->result();

        //*******general caste or reserve caste check */

        $data['caste'] = $get_settlement_basic->caste;

        $applicants_buyers   = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);

        foreach($applicants_buyers as $applicant)
        {
            if($applicant->is_applicant == 1)
            {
                $data['if_widow'] = $applicant->marital_status;
            }
        }

        if(!isset($data['if_widow']))
        {
            log_message('error', '#ERROR151220231026: Marital status not found! Case No '. $case_no);
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


        $data['_view'] = 'SettlementView/Co/Tribal/generateNoticeView';
        $this->load->view('layouts/main', $data);
        // }
    }

    // public function generatePaymentNoticeCoSave(){

    //     $case_no = $this->input->post('case_no');
    //     $remark = $this->input->post('remark_co');
    //     $applicant_buyer = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
    //     $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

    //     $data = [
    //         'case_no' => $case_no,
    //         'remark' => $remark,
    //         'get_settlement_basic' => $get_settlement_basic,
    //         'pay_notice_date' => date('Y-m-d'),
    //     ];

    //     if($get_settlement_basic->pull_request == '1')
    //     {
    //         $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to modification request active # ".$case_no);
    //         redirect(base_url() . "index.php/home");
    //         return;
    //     }

    //     if(isset($applicant_buyer))
    //     {
    //         foreach($applicant_buyer as $applicant)
    //         {
    //             if($applicant->is_applicant == 1)
    //             {
    //                 $data['applicant_name'] = $applicant->pdar_name;
    //                 $data['guardian_name'] = $applicant->pdar_guardian;
    //             }
    //         }
    //     }

    //     $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);

    //     if(isset($basic))
    //     {
    //         if($basic['service_code'] == SETTLEMENT_TENANT_ID){
    //             $data['service_name'] = 'Settlement Occupency Tenant';
    //         }elseif($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID){
    //             $data['service_name'] = 'Settlement AP';
    //         }elseif($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID){
    //             $data['service_name'] = 'Settlement Tribal Community';
    //         }elseif($basic['service_code'] == SETTLEMENT_KHAS_LAND_ID){
    //             $data['service_name'] = 'Settlement Khasland';
    //         }elseif($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID){
    //             $data['service_name'] = 'Settlement PGR/VGR land';
    //         }elseif($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID){
    //             $data['service_name'] = 'Settlement Special Cultivators';
    //         }

    //         $data['case_no']                = $basic['case_no'];
    //         $data['application_no']         = $basic['applid'];

    //         $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
    //         $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
    //         $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

    //         $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

    //         $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

    //         $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

    //     }

    //     $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

    //     if(isset($dags))
    //     {
    //         foreach($dags as $dag_item)
    //         {
    //             $data['isUrban'] = $dag_item->is_urban;
    //         }
    //     }

    //     $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);

    //     $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

    //     if($premium_data->num_rows() > 0)
    //     {
    //         $caseUrban =null;
    //         $premium_data_row = $premium_data->row();
    //         $premium_data_arr = $premium_data->result();


    //         if(trim($basic['approve_by'] == '') || empty(trim($basic['approve_by']))){
    //             if(trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES) {
    //                 $caseUrban="N";
    //             }
    //             else if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES)){
    //                 $caseUrban="Y";
    //             }

    //         }
    //         else {
    //             if(trim($basic['approve_by'] == 'DC')) {/////consider as rural case
    //                 $caseUrban="N";
    //             }
    //             else if(trim($basic['approve_by'] == 'GOVT')){
    //                 $caseUrban="Y";
    //             }

    //         }


    //         if(isset($basic['is_wed_land']) && $basic['is_wed_land'] == 1)
    //         {
    //             $caseUrban="N";
    //         }
    //         //*******for rural case */
    //         if($caseUrban =='N'){
    //             $area_all = array();
    //             $area_all_barak = array();
    //             $dag_arr = array();
    //             $data['actual_premium'] = 0;
    //             foreach($premium_data_arr as $premium)
    //             {

    //                 $dag_arr[] = $premium->dag_no;

    //                 $data['net_premium_payable'] = $premium->final_amount;
    //                 $data['mission_cocession_rate'] = $premium->rate;

    //                 // if(trim($premium->concession) == 'YES')
    //                 // {
    //                 //     $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
    //                 //     $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
    //                 //     $data['concession_amount'] = $data['net_premium_payable'] * 25/100;
    //                 //     $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
    //                 // }
    //                 // else
    //                 // {
    //                 //     $data['type_of_concession'] = '-';
    //                 //     $data['concession_mission_govt_notification_no'] = '-';
    //                 //     $data['concession_amount'] = '-';
    //                 //     $data['premium_payable_without_concession'] = $data['net_premium_payable'];
    //                 // }

    //                 // $data['actual_premium'] += (float)$premium->amount_dag * 5;
                    

    //                 if(trim($premium->concession) == 'YES')
    //                 {
    //                     $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
    //                     // $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
    //                     $data['premium_payable_without_concession'] = ceil($data['net_premium_payable'] / 0.75);
    //                     $data['concession_amount'] = ceil($data['premium_payable_without_concession'] * 0.25);
    //                     $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
    //                     $data['actual_premium'] = (float)$data['premium_payable_without_concession'] * 5;
    //                 }
    //                 else
    //                 {
    //                     $data['type_of_concession'] = '-';
    //                     $data['concession_mission_govt_notification_no'] = '-';
    //                     $data['concession_amount'] = '-';
    //                     $data['premium_payable_without_concession'] = $data['net_premium_payable'];
    //                     $data['actual_premium'] += (float)$premium->amount_dag * 5;
    //                 }

    //                 $total_lessa = $premium->total_lessa;

    //                 if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
    //                 {
    //                     $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
    //                 }
    //                 else
    //                 {
    //                     $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
    //                 }

    //                 $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
    //                 $area_all_barak[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
    //             }

    //             $data['area'] = implode ( ", ", $area_all );
    //             $data['area_barak'] = implode ( ", ", $area_all_barak );
    //             $data['dag_no'] = implode ( ", ", $dag_arr );

    //             if($data['type_of_concession'] == '-')
    //             {
    //                 $data['concession_area'] = '-';
    //                 $data['concession_dag_no'] = '-';
    //             }
    //             else
    //             {
    //                 $data['concession_area'] = $data['area'];
    //                 $data['concession_dag_no'] = $data['dag_no'];
    //             }

    //             $data['premium_per_bigha'] = '500';
    //             $data['mission_per_bigha'] = '100';
    //         }

    //         //*****for urban case */
    //         // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
    //         if($caseUrban =='Y') /////consider as urban case
    //         {

    //         }
    //     }

    //     $curl_handle = curl_init();
    //     curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicationDate");
    //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //         'application_no' => $data['application_no'],
    //     )));
    //     $output = curl_exec($curl_handle);
    //     if(isset(json_decode($output)->responseType)){
    //         if(json_decode($output)->responseType != 'y'){
    //             echo json_decode($output)->data." - Unauthorized access!";
    //             return false;
    //         }
    //     }
    //     curl_close($curl_handle);
    //     $res = json_decode($output);

    //     $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

    //     $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
    //     $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
    //     $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
    //     $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

    //     $this->load->helper('qrcode');
    //     $base_64 = printQR('https://sewasetu.assam.gov.in/');
    //     $data['qrcode'] = $base_64;

    //     // if(trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES)
    //     if($caseUrban =='N') /////consider as rural case
    //     {
    //         $this->load->view('SettlementView/include/rural_notice', $data);
    //         // $this->session->set_flashdata('message', "Rural Payment Notice will be made available soon !!!");
    //         // redirect(base_url().'index.php/home');
    //     }
    //     // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
    //     if($caseUrban =='Y')/////consider as urbam case
    //     {
    //         // $this->load->view('SettlementView/Co/Khas/paymentNoticeUrban', $data);
    //         $this->session->set_flashdata('message', "Urban Payment Notice will be made available soon !!!");
    //         redirect(base_url().'index.php/home');
    //     }



        
    // }

    public function generatePaymentNoticeCoSave()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark_co');
        $applicant_buyer = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

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

        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);

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
            }

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

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

        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);


        $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);

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
                        // $data['actual_premium'] = (float)$data['premium_payable_without_concession'] * 5;
                        $data['actual_premium'] = (float)$data['premium_payable_without_concession'];
                    }
                    else
                    {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                        // $data['actual_premium'] += (float)$premium->amount_dag * 5;
                        $data['actual_premium'] += (float)$premium->amount_dag;
                    }

                    // $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
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
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        

                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];

                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );


                    $total_amount = $premium->amount_dag;

                    $mbAreaLimit = $premium->mb_land;
                    $maxLand = $premium->max_land;

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

                            if($premium->total_lessa > 30)
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($mbAreaLimit);
                                    $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                                }

                                //*****exceed area */
                                if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa - $mbAreaLimit);
                                    $exceed_area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                                }
                                else
                                {
                                    $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa - $mbAreaLimit);
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
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicationDate");
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

        // $this->load->helper('qrcode');
        // $base_64 = printQR('https://sewasetu.assam.gov.in/');
        // $data['qrcode'] = $base_64;
        $this->load->helper('qrcode');
        $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
        $data['qrcode'] = ','.$base_64;

        // if(trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES)
        if($caseUrban =='N') /////consider as rural case
        {
            $this->load->view('SettlementView/include/rural_notice', $data);
            // $this->load->view('SettlementView/include/urban_notice', $data);

            // $this->session->set_flashdata('message', "Rural Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
        }
        // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
        if($caseUrban =='Y')/////consider as urbam case
        {
            $this->load->view('SettlementView/include/urban_notice', $data);

            // $this->session->set_flashdata('message', "Urban Payment Notice will be made available soon !!!");
            // redirect(base_url().'index.php/home');
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

    public function savePaymentNotice(){
        $case_no = $this->input->post('case_no');
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        if(is_dir(PAYMENT_NOTICE_PATH)===false){
            mkdir(PAYMENT_NOTICE_PATH,0777);
        }
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
        foreach($applicant_buyers as $buyers){
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID' => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME' => $buyers->pdar_guardian
                ];
        }
        $notice_no = "MB2/PN/".date('Y')."/".SETTLEMENT_TRIBAL_COMMUNITY."/".$service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                     => $case_no,
            'service_code'                => $service_details->service_code,
            'case_registration_date'      => $service_details->submission_date,
            'payment_notice_date'         => date('Y-m-d'),
            'total_amount'                => $amount,
            'sdlac_proposal_id'           => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date'         => $service_details->sdlac_date,
            'applicant_details'           => json_encode($applicant_buyers_json),
            //'payment_completed_date'      => date('Y-m-d'), 
            'notice_no'                   => $notice_no,
            'notice_link'                 => $base_64_file_path,
            'notice_type'                 => 'PN'
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if($insertIntoSettlementNotice != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN00678: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        $updateArr = [
            'status'             => 'N',
            'co_code'            => $this->session->userdata('user_code'),
            'user_code'          => $this->session->userdata('user_code'),
            'pay_notice_gen_yn'  => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update'        => date('Y-m-d h:i:s'),
            'from_office'        => 'CO',
            'pending_officer'    => 'CO',
            'pending_office'     => 'CO',
            'co_notice_link'     => $base_64_file_path
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
            'case_no'               => $case_no,
            'proceeding_id'         => $proceeding_id,
            'date_of_hearing'       => date('Y-m-d h:i:s'),
            'next_date_of_hearing'  => date('Y-m-d h:i:s'),
            'note_on_order'         => $remark_co,
            'status'                => 'N',
            'user_code'             => $this->session->userdata('user_code'),
            'date_entry'            => date('Y-m-d h:i:s'),
            'operation'             => 'E',
            'ip'                    => $this->utilityclass->get_client_ip(),
            'office_from'           => 'CO',
            'office_to'             => 'CO',
            'task'                  => 'Payment Notice Generated'
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
            echo json_encode($data);
            return false;
        }else{

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();

            /// check full pay 
            $is_full_pay ='N';
            $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
            if($premium_tot_data->num_rows() > 0){
                foreach($premium_tot_data->result() as $prem_records){

                    if($prem_records->area_name =='7' || $prem_records->area_name =='8' || $prem_records->area_name =='9' || $prem_records->area_name =='10'){
                        $is_full_pay ='N'; //// from now all cases partial payment option available
                    }

                }
            }else{

                log_message('error', '#BACKUP003277: Premium payment type not found. Case No '.$case_no);

                $this->session->set_flashdata('error_data', "#BACKUP003277: Premium payment type not found for case no : ".$case_no);
            }
            /// check full pay end

            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type' => 'PN',
                'amount' => $amount,
                'is_full_pay' => $is_full_pay
            )));
            $result = curl_exec($curl_handle);

            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#TRIBALPAYAPI0011  Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $case_no);
                exit;
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $case_no);
            }

        }
    }







}