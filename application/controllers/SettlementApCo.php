<?php
class SettlementApCo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementAutoRegistrationModel','autoModel');
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
        $newDag = '';

        if($basic->service_code == SETTLEMENT_AP_TRANSFER_ID)
        {
            $allLmProcess = '';
            $newDag = $appliedDags[0]->new_dag_no;
            if($newDag != '')
            {

                foreach ($dags as $dag)
                {
                    $totalReservedAreaInApplication = 0;
                    $totalAppliedAreaInApplication = 0;

                    $appDistrict  = $dag->dist_code;
                    $appSubDiv    = $dag->subdiv_code;
                    $appCircle    = $dag->cir_code;
                    $appMouza     = $dag->mouza_pargona_code;
                    $appLot       = $dag->lot_no;
                    $appVillage   = $dag->vill_townprt_code;
                    $appDag       = $dag->dag_no;

                    // chitha details for new Dag
                    $chithaDag = $this->SettlementCommonDcModel->getNewChithaDagAreaDetails(
                        $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $newDag);

                    $reservation = $this->SettlementCommonDcModel->getSettlementReservationCommon($application_no);

                    if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
                    {

                        // chitha
                        $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                        $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                        $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                        $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                        $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;


                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if($appDag == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                                $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;
                            }
                        }

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $gandaReservedApp = $this->UtilsModel->defaultValue($singleApp->ganda, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 6400) + ($kathaReservedApp * 320) + ($lessaReservedApp * 20) + $gandaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
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

                        // application area
                        foreach ($appliedDags as $singleAppArea)
                        {
                            if($appDag == $singleAppArea->dag_no)
                            {
                                $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                                $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                                $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                                $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                                $totalAppliedAreaInApplication += $appAreaInApplication;
                            }
                        }

                        // Reservation Area
                        foreach ($reservation as $singleApp)
                        {
                            $bighaReservedApp = $this->UtilsModel->defaultValue($singleApp->bigha, 0);
                            $kathaReservedApp = $this->UtilsModel->defaultValue($singleApp->katha, 0);
                            $lessaReservedApp = $this->UtilsModel->defaultValue($singleApp->lessa, 0);
                            $areaReservedInApplication = ($bighaReservedApp * 100) + ($kathaReservedApp * 20) + $lessaReservedApp;

                            $totalReservedAreaInApplication += $areaReservedInApplication;
                        }

                        if($totalAreaInChitha == 0)
                        {
                            $areaCheck = 1;
                        }
                        if(($totalAppliedAreaInApplication - $totalReservedAreaInApplication) == 0)
                        {
                            $areaCheck = 1;
                        }
                        if($totalAreaInChitha < $totalAppliedAreaInApplication - $totalReservedAreaInApplication)
                        {
                            $areaCheck = 1;
                        }
                    }
                    $chithaDagArray[] = $chithaDag;
                }

                $checkAreaDetail = array(
                    'chithaArea'    => $chithaDagArray,
                    'reservedArea'  => $reservation,
                    'appliedDags'   => $appliedDags,
                    'areaCheck'     => $areaCheck,
                    'lmProcessArea' => $allLmProcess,
                    'newDag'        => $newDag
                );

                return $checkAreaDetail;

            }

        }

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
            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmitOnlyApCoCase(
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
                if($totalAreaInChitha < $totalAreaInLMApplication)
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
                if($totalAreaInChitha < $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }
                // if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                // {
                //     $areaCheck = 1;
                // }
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
            'newDag'       =>$newDag
        );


        return $checkAreaDetail;

    }

    // Settlement AP CO view starts here -js-
    public function settlementApCo()
    {
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

        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
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


        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

        $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];
        $lmdata['newDag']= $checkAreaDetails['newDag'];


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

        $lmdata['_view'] = 'SettlementView/Co/SettlementApTransferred';
        $this->load->view('layouts/main',$lmdata);
    }

    public function generateNoticeCo(){
        // generate notice starts here
        if(isset($_POST['generate_notice'])){
            // var_dump("m here"); die();
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');


            $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);

            if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
                $remark_co = "AP Notice";
                $remark_co_text = "Notice Generated";
            }else{
                $remark_co = $this->input->post('remark_co');
                $remark_co_text = $this->input->post('remark_co_text');
            }

            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $get_chitha_owners = $this->SettlementApModel->getAllOwnersChitha($case_no);

            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,
                'get_chitha_owners' => $get_chitha_owners,
                'remark' => $remark_co,
                'notice_hearing_date' => $hearing_date,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'remark_co_text' => $remark_co_text,
                'is_generated' => false
            ];
            $this->load->view('SettlementView/Co/Ap/SettlementNotice',$data);
            // var_dump($hearing_date);
            // die();
        }

        if(isset($_POST['re_generate_notice'])){
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');

            $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);

            if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
                $remark_co = "AP Notice";
                $remark_co_text = "Notice Generated";
            }else{
                $remark_co = $this->input->post('remark_co');
                $remark_co_text = $this->input->post('remark_co_text');
            }

            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $get_chitha_owners = $this->SettlementApModel->getAllOwnersChitha($case_no);
            // var_dump($get_chitha_owners->owners); die;
            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,
                'get_chitha_owners' => $get_chitha_owners,
                'remark' => $remark_co,
                'notice_hearing_date' => $hearing_date,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'remark_co_text' => $remark_co_text,
                'is_generated' => true
            ];
            $this->load->view('SettlementView/Co/Ap/SettlementNotice',$data);
        }

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
        //         'base64_decoded_notice_file' => $base64decoded_notice_file
        //     ];
        //     $data['_view'] = 'SettlementView/Co/Ap/PrintNotice';
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
                'base64_decoded_notice_file' => $base64decoded_notice_file
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
            //             'base64_decoded_notice_file' => $base64decoded_notice_file
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
            //         'base64_decoded_notice_file' => $base64decoded_notice_file
            //     ];
            // }

            $data['_view'] = 'SettlementView/Co/Ap/PrintNotice';
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
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co');

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

            //   $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            //     $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            //     $phase_count = (int)$phase_count+1;
            //     $backup_array = array(
            //         'applid' => $applid_backup,
            //         'case_no' => $case_no,
            //         'from_office' => 'CO',
            //         'to_office' => 'LM',
            //         'status' => 'R',
            //         'phase' => 'CO_'.$phase_count,
            //         'data' => json_encode($_POST)
            //     );

            //     $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            //     if($backup_insertion_co != 1){
            //         $this->db->trans_rollback();
            //         log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

            //         $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : ".$case_no);
            //         redirect(base_url() . "index.php/home");
            //         return false;
            //     }

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
                'task' => "Revert Back to LM"
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
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
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
                    // redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //forward to DC starts here
        if (isset($_POST['forward_to_dc'])) {

            $curr_date = date('Y-m-d');
            $notice_generated_date = $this->input->post('notice_generated_date');

            $case_no = $this->input->post('case_no');


            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co');
            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            // check from settlement dag details if new dag no is exist            
            $check_new_dag = $this->db->query("SELECT new_dag_no FROM settlement_dag_details 
                                WHERE case_no=?",array($case_no));
            if($check_new_dag->num_rows() <= 0)
            {
                log_message('error', "#ERR12356: No new dag no found in settlement_dag_details ".$this->db->last_query());
                $this->session->set_flashdata('message', "#ERR12356: Something went wrong with new dag no for case no ".$case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            if($check_new_dag->row()->new_dag_no != null || $check_new_dag->row()->new_dag_no != '')
            {
                $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);

                if($finalAreaCheck['responseType'] != 2)
                {
                    $this->session->set_flashdata('message',"--".$finalAreaCheck['msg']);
                    redirect(base_url() . 'index.php/home/index');
                }
                //check in premium table where data exist
                $check_premium = $this->db->query("SELECT * FROM settlement_premium 
                                    WHERE case_no=? AND is_final=?",array($case_no, 1));

                if($check_premium->num_rows() <= 0) {
                    log_message('error', "#ERR1235: No detail found in settlement_premium ".$this->db->last_query());
                    $this->session->set_flashdata('message', "#ERR1235: Premium is not available for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }


            $nr_update=$this->db->query("Select nr_update_yn as c from settlement_basic where case_no='$case_no' ")->row()->c;
            if($nr_update=='Y'){
                $status='W';
            }else{
                $status='G';
            }
            $this->db->trans_begin();

            $date1 = date_create($curr_date);
            $date2 = date_create(date('Y-m-d', strtotime($notice_generated_date)));
            $diff  = date_diff($date2,$date1);

            $date_diff = $diff->format("%R%a");

            if($date_diff < 15){
                $this->db->trans_rollback();
                log_message('error', "#ERRCO1247: Unable to forward the case due to notice generated date is less than 15 days for case no ".$case_no);
                $this->session->set_flashdata('message', "#ERRCO1247: Unable to forward the case due to notice generated date is less than 15 days for case no ".$case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

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
                    log_message('error', "#ERRCO1274: Failed to forward to DC for case no ".$case_no);
                    $this->session->set_flashdata('message', "#ERRCO1274: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
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
                    log_message('error', "#ERRCO1291: Failed to forward to DC for case no ".$case_no);
                    $this->session->set_flashdata('message', "#ERRCO1291: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
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
                    log_message('error', "#ERRCO1324: Insertion failed in settlement_proceeding for case no ".$this->db->last_query());
                    $this->session->set_flashdata('message', "#ERRCO1324: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
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
                    log_message('error', "#ERRCO1357: Insertion failed in settlement_proceeding ".$this->db->last_query());
                    $this->session->set_flashdata('message', "#ERRCO1357: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#ERRCO1373: Transaction Status failed : ".$this->db->trans_status());
                    $this->session->set_flashdata('message', "#ERRCO1373: Error in submitting. Please try Again for case no ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return;
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
                        // redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
                        redirect(base_url() . "index.php/home");

                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            $casesStatus = $this->SettlementCommonModel->checkStatusFromBasic($case_no);


            if($nr_update !='Y'){
                $pending_officer = 'DC';
                $pending_office = 'DC';

            }else{

                if(($casesStatus == 'W' || $casesStatus == 'X') && $nr_update !='Y'){
                    $pending_officer = 'DC';
                    $pending_office = 'DC';
                }
                else
                {
                    if(trim($headQtrCheck) == 'Y'){
                        $pending_officer = 'ADC';
                        $pending_office = 'DC';
                    }else{
                        $pending_officer = 'SDO';
                        $pending_office = 'DC';
                    }
                }

            }



            // foward to dc updates
            $updateArr = [
                'status' => $status,
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {

                $this->db->trans_rollback();
                log_message('error', "#ERRCO1447: Failed to forward to DC for case no ".$case_no);
                $this->session->set_flashdata('message', "#ERRCO1447: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                redirect(base_url() . "index.php/home");
                return;
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
                        log_message('error', "#ERRCO1492: Insertion failed in settlement_proceeding ".$this->db->last_query());
                        $this->session->set_flashdata('message', "#ERRCO1492: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
            }
            //////proceeding if sk report not submitted end//////

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
                log_message('error', "#ERRCO1518: Insertion failed in settlement_proceeding ".$this->db->last_query());
                $this->session->set_flashdata('message', "#ERRCO1518: Failed to forward to DC. Kindly contact system administrator for case no ".$case_no);
                redirect(base_url() . "index.php/home");
                return;


            }
            if ($this->db->trans_status() == false) {

                $this->db->trans_rollback();
                log_message('error', "#ERRCO1518: Transaction failed ".$this->db->trans_status());
                $this->session->set_flashdata('message', "#ERRCO1518: Error in submitting. Please try Again for case no ".$case_no);
                redirect(base_url() . "index.php/home");
                return;

            } else {
                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Forwarded to DC';
                $status='M';
                $task='CO';
                $pen=$pending_officer;
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
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
                    // redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
                    redirect(base_url() . "index.php/home");

                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

    }


    public function saveNotice(){
        $case_no = $this->input->post('case_no');
        //$htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        if(is_dir(CO_NOTICE_PATH)===false){
            mkdir(CO_NOTICE_PATH,0777);
        }
        $base_64_file_path = CO_NOTICE_PATH.$new_case_no.".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        // base64 file
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $hearing_date = $this->input->post('hearing_date');
        $case_no = $this->input->post('case_no');
        $remark_co = $this->input->post('remark_co');
        $remark_co_text = $this->input->post('remark_co_text');
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
        $is_generated = $this->input->post('is_generated');
        $data = [
            'hearing_date' => $hearing_date,
            'case_no' => $case_no,
            'remark_co' => $remark_co,
            'get_settlement_basic' => $get_settlement_basic,
            'get_dag_details' => $get_dag_details,
            'get_settlement_applicant' => $get_settlement_applicant,
        ];

        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);

        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
            $lm_report = "no";
        }else{
            $lm_report = "yes";
        }

        $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();

        if ($service_details && $service_details->status == 'D') {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO330005: Updation Failed in settlement_basic table');

            $json = [
                'responseType' => 3,
                'message' => '#ERRCO3300051: Failed to generate notice. Kindly contact system administrator',
            ];
            
            echo json_encode($json);
            return false;
        }

        $sql_buyers = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach($applicant_buyers as $buyers){
            $applicant_buyers_json[] = [
                'APPLICANT_ID' => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME' => $buyers->pdar_guardian
            ];
        }
        $notice_no = "MB2/GN/".date('Y')."/".SETTLEMENT_AP_TRANSFER."/".$service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                     => $case_no,
            'service_code'                => $service_details->service_code,
            'case_registration_date'      => $service_details->submission_date,
            //'payment_notice_date'         => date('Y-m-d'),
            // 'total_amount'                => $amount,
            //'sdlac_proposal_id'           => $service_details->sdlace_proposal_no,
            //'sdlac_proposal_date'         => $service_details->sdlac_date,
            'applicant_details'           => json_encode($applicant_buyers_json),
            //'payment_completed_date'      => date('Y-m-d'),
            'notice_no'                   => $notice_no,
            'notice_link'                 => $base_64_file_path,
            'notice_type'                 => 'GN',
            'hearing_date'                => $hearing_date
        ];

        if($is_generated == true){
            $this->db->where('case_no', $case_no);
            $this->db->where('notice_type', 'GN');
            $this->db->update('settlement_notice', $insertIntoSettlementNotice);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00565605: Updation Failed in settlement_notice table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00565605: Failed to generate notice. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }
            $updateArr = [
                'co_hearing_date' => $hearing_date,
                // 'notice_generated_date' => date('Y-m-d h:i:s'),
                'date_update' => date('Y-m-d h:i:s'),
                'co_app_notice_link' => $base_64_file_path
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO330005: Updation Failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO330005: Failed to generate notice. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

        }else{
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


            if($lm_report =="no"){
                $pending_officer = 'LM';
                $status = 'V';
            }else{
                $pending_officer = 'CO';
                $status = 'W';
            }

            $updateArr = [
                'co_hearing_date' => $hearing_date,
                'co_code' => $this->session->userdata('user_code'),
                'status' =>$status,
                'notice_generated_yn' => 'Y',
                'notice_generated_date' => date('Y-m-d h:i:s'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => 'CO',
                'co_app_notice_link' => $base_64_file_path
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
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        if($is_generated == true){
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'General notice re-generated',
                'status' => 'A',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Notice Re-generated'
            ];
        }else{
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'General notice generated.',
                'status' => 'A',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Notice Generated'
            ];
        }

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
                'type' => 'GN',
                'amount' => 0,
                'is_full_pay' => 'N'
            )));
            $result = curl_exec($curl_handle);

            if(trim($result) != 'y'){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#889ERR778 - Failed to generate notice !");
                redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case='.$case_no);
                return false;
            }else{

                if($lm_report =="no"){
                    //////////////POST To basundhara/////////////////////
                    $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                    $rmk='Forwarded to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP00951: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }else{
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Notice Generated and Application Successfully Forwarded to LM, Case No # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                }else{

                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Notice successfully saved...");
                    redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case='.$case_no."&state=active");
                }


            }

        }
    }

    public function FirstProceeding()
    {
        $service_code=$this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoApFirstPending( $service_code);

        $data['_view'] = 'settlement_mb/first_proceeding_co';

        $this->load->view('layouts/main', $data);
    }


    public function SecondProceeding()
    {
        $service_code=$this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoApSecondPending( $service_code);

        $data['_view'] = 'settlement_mb/second_proceeding_co';

        $this->load->view('layouts/main', $data);
    }

    public function nrToSettlement()
    {
        // $service_code=$this->input->get('service');
        // // $data['select_range'] = $select_offset = $this->input->post('select_range');

        // $data['getFirstProceeding'] = $this->SettlementApModel->getNrToSettlement($service_code);

        // $data['_view'] = 'settlement_mb/nr_proceeding_co';

        // $this->load->view('layouts/main', $data);

        $service_code=$this->input->get('service');
        $status = 'Y';

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        // $data['select_range'] = $select_offset = $this->input->post('select_range');


        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['getFirstProceeding'] = $this->SettlementApModel->getNrToSettlement($service_code);

        // $data['_view'] = 'settlement_mb/nr_proceeding_co';
        $data['_view'] = 'settlement_mb/nr_proceeding_co_new';
        $this->load->view('layouts/main', $data);
    }

    public function generatePaymentNoticeCo()
    {
        if(isset($_GET['case']))
        {
            $case_no = $this->input->get('case');
            $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
            // $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
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
                    log_message('error', '#ERROR990123: Dag no. under wetland area and not approved by Department this Case No '. $case_no. 'and query is '.$this->db->last_query());
                    $error_msg_new = array('status'=>1,'message'=>'#ERROR990123: Dag no. under wetland area and not approved by Department this case no'.$case_no);
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

            $data['_view'] = 'SettlementView/Co/Ap/generateNoticeView';
            $this->load->view('layouts/main', $data);
        }

    }

    // public function generatePaymentNoticeCoSave(){

    //     // $payment_amount = $this->input->post('payment_amount');
    //     // $case_no = $this->input->post('case_no');
    //     // $remark = $this->input->post('remark_co');
    //     // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
    //     // //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
    //     // $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
    //     // $get_owners = $this->SettlementApModel->getOwners($case_no);
    //     // $get_buyers = $this->SettlementApModel->getBuyers($case_no);
    //     // $get_dag_details = $this->SettlementApModel->getDags($case_no);
    //     // $data = [
    //     //     'payment_amount' => $payment_amount,
    //     //     'case_no' => $case_no,
    //     //     'get_settlement_basic' => $get_settlement_basic,
    //     //     'get_dag_details' => $get_dag_details,
    //     //     'get_owners' => $get_owners,
    //     //     'get_buyers' => $get_buyers,
    //     //     'get_settlement_applicant' => $get_settlement_applicant,
    //     //     'remark' => $remark,
    //     //     'pay_notice_date' => date('Y-m-d')
    //     // ];

    //     // $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
    //     // $data['premium_data'] = $premium_data;
    //     // // is rural and urban to be checked in the case of dag
    //     // foreach ($get_dag_details as $dg) {
    //     //     if ($dg->is_urban == 'Y') {
    //     //         $this->load->view('SettlementView/Co/Ap/paymentNoticeUrban', $data);
    //     //     } else {
    //     //         $this->load->view('SettlementView/Co/Ap/paymentNotice',$data);
    //     //     }
    //     //     break;
    //     // }


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

        $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach($applicant_buyers as $buyers){
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID' => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME' => $buyers->pdar_guardian
                ];
        }
        $notice_no = "MB2/PN/" . date('Y') . "/SAPNR/" . $service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date'    => date('Y-m-d'),
            'total_amount'           => $amount,
            'sdlac_proposal_id'      => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date'    => $service_details->sdlac_date,
            'applicant_details'      => json_encode($applicant_buyers_json),
            //'payment_completed_date'   => date('Y-m-d'),
            'notice_no'   => $notice_no,
            'notice_link' => $base_64_file_path,
            'notice_type' => 'PN'
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
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
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
            echo json_encode($data);
            return false;
        }

        // API CALL HERE
        $rtps_case_no = $get_settlement_basic->applid;

        /// check full pay 
        $is_full_pay ='N';
        $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
        if($premium_tot_data->num_rows() > 0){
            foreach($premium_tot_data->result() as $prem_records){

                if($prem_records->area_name =='7' || $prem_records->area_name =='8' || $prem_records->area_name =='9' || $prem_records->area_name =='10'){
                    $is_full_pay ='Y';
                }

            }
        }else{

            log_message('error', '#BACKUP003277: Premium payment type not found. Case No '.$case_no);

            $this->session->set_flashdata('error_data', "#BACKUP003277: Premium payment type not found for case no : ".$case_no);
        }
        /// check full pay end

        // Upload notice API
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
            'type' => 'PN',
            'amount' => $amount,
            'is_full_pay' => $is_full_pay
        )));
        $result = curl_exec($curl_handle);

        if(trim($result) != 'y'){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return false;
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Payment notice successfully saved...");
            redirect(base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case='.$case_no);
        }

        // $rtps_id = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        // $rmk='Payment Notice Generated';
        // $status='N';
        // $task='CO';
        // $pen='DC';
        // $case=$case_no;
        // $rtps_status=$this->SettlementApiModel->postApiBasundhara($rtps_id,$case,$rmk,$status,$task,$pen);
        // $rtps_status=json_decode($rtps_status);
        // //var_dump($rtps_status);
        // if(trim($rtps_status)!="y"){
        //     $this->db->trans_rollback();
        //     $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
        //     redirect(base_url() . "index.php/home");
        // }
        // else
        // {
        //     $this->db->trans_commit();
        //     $this->session->set_flashdata('message', "Payment notice successfully saved...");
        //     redirect(base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case='.$case_no);
        // }
        // //   payment request API
        // $status = $this->SettlementMbModel->paymentRequest($rtps_case_no,$amount);
        // //   USER END STATUS API CALLING
        // if(trim($status) != 'y'){
        //     $this->db->trans_rollback();
        //     $this->session->set_flashdata('message', "#KHASPAYAPI0012 Payment notice  could not be generated...");
        //     redirect(base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $case_no);
        //     exit;
        // }else{
        //     $this->db->trans_commit();
        //     $this->session->set_flashdata('message', "Payment notice successfully saved...");
        //     redirect(base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case='.$case_no);
        // }

    }

    public function printNotice(){
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);


        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_notice_link']);
        if($path == false){
            echo 'No data found!';
            return;
        }
        // reading the base64 json file and saving it to a variable
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

    function apiApCases($service){

        // $curl_handle = curl_init();
        // //curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."coServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code");

        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array()));
        // $result = curl_exec($curl_handle);
        // $results = json_decode($result);

        // $district['selectList'] = $results;

        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%' ";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));

        // $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code));

            if($data1->num_rows()==0){
                echo  json_encode(array('error'=>'CO is not mapped yet. Please map it and then try it again'));
                return;
                die;
            }

            // foreach ($data1->result() as $key => $value) {
            //     $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            // }
            //////////////////
        }

        $district['service'] = $service;
        $district['_view'] = 'basundhara/request_ap';
        $this->load->view('layouts/main',$district);
    }


    public function apPaginationAPI()
    {
        $service = $this->input->post('service');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $occupation = trim($this->input->post('occupation'));


        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);

        $is_cat = $this->input->post('is_category');

        $is_rural = $this->input->post('rural');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null){
            $lot_string = $this->convertLiteral($lot_array);
        }



        $curl_handle = curl_init();
        //curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "coServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start' => $start,
            'length' => $length,
            'order' => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat' => $is_cat,
            'is_rural' => $is_rural,
            'occupation' => $occupation,
            'lot_array' => $lot_string
        )));
        $result = curl_exec($curl_handle);
        $results = json_decode($result);

        // var_dump($results); die;

        if (isset($results)) {
            //==============getting the reject_list
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            if($rejected_data == 'n')
            {
                $rejected_list = false;
            }
            else
            {
                $rejected_list = $rejected_data;
            }

            $data_rows = $results->data_results;
            $total_records = $results->total_records;
            foreach ($data_rows as $key => $rows) {
                // if(!empty($lot_array) || $lot_array != null){
                //     $checkVal = $rows->mouza_code.'_'.$rows->lot_no;
                //     if(!in_array($checkVal,$lot_array)){
                //         $total_records--;
                //         unset($data_rows[$key]);
                //         continue;
                //     }
                // }


                $case_no = $this->utilityclass->getCaseNoByApplId((string)$dist_code, (string)$rows->application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $rejected_list);

                if($chithaRemarks == true)
                {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                }
                else
                {
                    $chithaFlag = 'No';
                }


                $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApplication?app=' . $rows->application_no . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';


                $json[] = array(
                    $rows->application_no,
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->applicant_occupation,
                    $rows->type,
                    '<b>'.$chithaFlag.'</b>',
                    $rows->rurban,

                    $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code),
                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),
                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),

                    $ap_link
                );
            }


            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            // if($total_records == 0){
            //     $response = array();
            //     $response['sEcho'] = 0;
            //     $response['iTotalRecords'] = 0;
            //     $response['iTotalDisplayRecords'] = 0;
            //     $response['aaData'] = [];
            // }
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

    function settlementApplication()
    {
        $application_no = $this->input->get('app'); // get rtps application no


        // get data from basundhara end (API call)
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
            'api_key'        => API_KEY,
            'token'          => $token
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType == 3){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        //   header('content-type:application/json');
        $backup = $output;
        $output = json_decode($output);

        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        if($get_aadhaar_photo != 'n'){
            $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        $app = $output->application;
        $d   = $app->dist_code;
        $s   = $app->subdiv_code;
        $c   = $app->cir_code;
        $m   = $app->mouza_code;
        $l   = $app->lot_no;
        $v   = $app->village_code;
        $dag = $app->dag_no;

        // check if case already registered
        $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);
        if(!$recordExist) {

            $case_name=$this->SettlementApiModel->genearteCaseName(); // generate case name
            if(empty($case_name)){
                log_message('error', '#ERROR0002: Case name can not be generated for application
            no '.$application_no);
                $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                exit;
            }

            //generate case no
            $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_AP_TRANSFER;

            //check for tribal belt
            if($output->applicants['0']->under_tribe_belts == 1){
                $tribal_belt = 'YES';
            }
            else if($output->applicants['0']->under_tribe_belts == 0){
                $tribal_belt = 'NO';
            }
            else {
                $tribal_belt = '';
            }

            //check for bhumiputra certificate starts here
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

            $this->db->trans_begin(); // transaction begins here

            foreach($output->applicants as $type_of_lands) {
                if($type_of_lands->is_applicant == 1) {
                    $type_of_transfer=$type_of_lands->type_of_transfer;
                    $type_of_patta =$type_of_lands->type_of_patta;
                    $applicant_occupation = $type_of_lands->applicant_occupation;
                    $applicant_ref_no = $type_of_lands->ref_no;
                    $applicant_caste_category= $type_of_lands->caste_category;
                    $applicant_uuid= $type_of_lands->uuid;
                }
            }

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM
            $settlement_basic=[
                'dist_code'                   => $d,
                'subdiv_code'                 => $s,
                'cir_code'                    => $c,
                'mouza_pargona_code'          => $m,
                'lot_no'                      => $l,
                'vill_townprt_code'           => $v,
                'service_code'                => SETTLEMENT_AP_TRANSFER_ID,
                'ref_no'                      => $applicant_ref_no,
                'case_no'                     => $case_no['case_no'],
                'trans_code'                  => 'F',
                'petition_no'                 => $case_no['petition_no'],
                'year_no'                     => date('Y'),
                'date_entry'                  => date('Y-m-d G:i:s'),
                'status'                      => 'Z',
                'submission_date'             => date('Y-m-d G:i:s'),
                'period_possession'           => date('Y-m-d'),
                'occupation_applicant'        => $applicant_occupation,
                'applid'                      => $application_no,
                'caste'                       => $applicant_caste_category,
                'uuid'                        => $applicant_uuid,
                'from_office'                 => 'API',
                'pending_officer'             => 'CO',
                'pending_office'              => 'CO',
                'tribal_belt'                 => $tribal_belt,
                'bhumiputra_confirmation'     => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'   => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                'user_code'                   => $this->session->userdata('user_code'),
                'type_of_transfer'            => $type_of_transfer,
                'type_of_patta'               => $type_of_patta,
            ];
            $settlement_basic_insertion = $this->db->insert('settlement_basic',$settlement_basic);
            if($settlement_basic_insertion != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Settlement failed for RTPS application no : ".$application_no);
                return false;
            }

            //insert into ADDITIONAL PROPERTY
            $checkAdditionalProperty = $this->SettlementCommonModel->getAdditionalPropertyDetail($application_no);
            if($checkAdditionalProperty->num_rows() == 0){
                if(isset($output->property)) {
                    foreach($output->property as $value) {
                        $add_property = [
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
                            'service_id'          => SETTLEMENT_AP_TRANSFER_ID,
                            'applied_flag'        => CITIZEN,
                            'dist_name'           => trim($value->dist_name),
                            'cir_name'            => trim($value->cir_name),
                            'vill_name'           => trim($value->vill_name),
                            'applid'              => $application_no,
                        ];
                        $insAddProperty = $this->db->insert('settlement_additional_property',$add_property);

                        if ($insAddProperty != 1) {
                            log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No '.$application_no. ' and 
                  query is '.$this->db->last_qery());
                            $data = array(
                                'error'=>"#ERROR0004: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT DAG DETAILS
            if(!empty($output->settlements)) {
                foreach($output->settlements as $dag) {
                    if($dag->is_applicant == 1) {

                        $new_land_class = $this->utilityclass->getPattaTypeNo($d,$s,$c,$m,$l,$v,$dag->dag_no);

                        $insSettlementDagDetails = [

                            'dist_code'           => $d,
                            'subdiv_code'         => $s,
                            'cir_code'            => $c,
                            'mouza_pargona_code'  => $m,
                            'lot_no'              => $l,
                            'vill_townprt_code'   => $v,
                            'user_code'           => $this->session->userdata('user_code'),
                            'date_entry'          => date('Y-m-d'),
                            'case_no'             => $case_no['case_no'],
                            'petition_no'         => $case_no['petition_no'],
                            'year_no'             => date('Y'),
                            'operation'           => 'E',
                            'new_land_class_code' => $new_land_class->land_class_code,
                            'dag_no'              => $dag->dag_no,
                            'patta_no'            => $dag->patta_no,
                            'patta_type_code'     => $dag->patta_code,
                            'dag_area_b'          => $dag->applied_bigha,
                            'dag_area_k'          => $dag->applied_katha,
                            'dag_area_lc'         => $dag->applied_lessa,
                            'dag_area_g'          => $dag->applied_ganda,
                            'dag_area_kr'         => $dag->applied_kranti,
                            's_dag_area_b'        => $dag->mbigha,
                            's_dag_area_k'        => $dag->mkatha,
                            's_dag_area_lc'       => $dag->mlessa,
                            's_dag_area_g'        => $dag->mganda,
                            's_dag_area_kr'       => $dag->mkranti,
                            'is_urban'            => $dag->is_rural_urban,
                            'revenue'             => 0,
                            'nr_bigha'            => $dag->mbigha,
                            'nr_katha'            => $dag->mkatha,
                            'nr_lessa'            => $dag->mlessa,
                            'nr_ganda'            => $dag->mganda,
                            'nr_kranti'           => $dag->mkranti,
                            'home_b'              => $dag->mbigha,
                            'home_k'              => $dag->mkatha,
                            'home_lc'             => $dag->mlessa,
                            'home_g'              => $dag->mganda,
                            'home_kr'             => $dag->mkranti,

                            'agri_b'              => 0,
                            'agri_k'              => 0,
                            'agri_lc'             => 0,
                            'agri_g'              => 0,
                            'agri_kr'             => 0,
                        ];
                        $settlement_dag_details = $this->db->insert('settlement_dag_details',$insSettlementDagDetails);

                        if($settlement_dag_details != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0005: Insertion failed in settlement_dag_details for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : ".$application_no);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT APPLICANT, main applicant/encrochers details
            if(!empty($output->settlements)) {
                foreach($output->settlements as $appl) {

                    if($appl->dag_no == 0 || $appl->dag_no == null || $appl->dag_no == '') {
                        $dag_no            = 0;
                        $patta_no          = 0;
                        $patta_type_code   = 0;
                    }
                    else {
                        $dag_no            = $appl->dag_no;
                        $patta_no          = $appl->patta_no;
                        $patta_type_code   = $appl->patta_code;
                    }

                    if($appl->is_applicant == 1) { // main applicant, for identity authentication
                        if ($get_aadhaar_photo != 'n') {
                            $timestamp = date('mdYhis', time()).uniqid();
                            $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                            $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";

                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $get_aadhaar_photo;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        } else {
                            $aadhar_path = '';
                        }
                        if($output->aadhar->type == 'AADHAAR'){
                            $identity_ref_no = $output->aadhar->aadhaar_no;
                        }else{
                            $identity_ref_no = $output->aadhar->pan_no;
                        }
                        $identity_type     = $output->aadhar->type;
                        $identity_doc_link = $aadhar_path;
                    }
                    else {
                        $identity_ref_no   = '';
                        $identity_type     = '';
                        $identity_doc_link = '';
                    }


                    if (trim($appl->pdar_type) == 'B'){
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }else{
                        $pdar_rel_guar = 0;
                    }

                    //pdar_cron_no
                    $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no['case_no']);

                    if($appl->pdar_type=='O'){
                        $pdarId=$appl->chitha_pdar_id;
                    }else{
                        $pdarId=-1;
                    }

                    $insApplicant = [
                        'dist_code'         => $d,
                        'subdiv_code'       => $s,
                        'cir_code'          => $c,
                        'mouza_pargona_code'=> $m,
                        'lot_no'            => $l,
                        'vill_townprt_code' => $v,
                        'user_code'         => $this->session->userdata('user_code'),
                        'case_no'           => $case_no['case_no'],
                        'petition_no'       => $case_no['petition_no'],
                        'operation'         => 'E',
                        'dag_no'            => $dag_no,
                        'patta_no'          => $patta_no,
                        'patta_type_code'   => $patta_type_code,
                        'year_no'           => date('Y'),
                        'date_entry'        => date('Y-m-d'),
                        'pdar_id'           => $pdarId,
                        'pdar_cron_no'      => $cron_no,
                        'pdar_name'         => $appl->name_ass,
                        'pdar_guardian'     => $appl->gurdian_name_ass,
                        'pdar_rel_guar'     => $pdar_rel_guar,
                        'pdar_gender'       => $appl->gender,
                        'pdar_add1'         => $appl->pre_add,
                        'pdar_add2'         => $appl->per_add,
                        'pdar_mobile'       => $appl->mobile,
                        'pdar_type'         => $appl->pdar_type,
                        'is_applicant'      => $appl->is_applicant,
                        'marital_status'    => $appl->marital_status,
                        'dob'               => $appl->dob,
                        'eng_pdar_name'     => $appl->name_eng,
                        'eng_pdar_guardian' => $appl->gurdian_name_eng,
                        'identity_ref_no'   => $identity_ref_no,
                        'identity_type'     => $identity_type,
                        'identity_doc_link' => $identity_doc_link,
                        'period_possession' => $appl->possession_date,
                    ];
                    $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);
                    if($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : ".$application_no);
                        return false;
                    }
                }
            }

            // insert into settlement_nominee, NEXT OF KIN
            if(!empty($output->nextKin)) {
                foreach($output->nextKin as $nok) {
                    $nominee_data = [
                        'case_no'      => $case_no['case_no'],
                        'nominee_name' => $nok->next_of_kin_name,
                        'address'      => $nok->address,
                        'mobile_no'    => $nok->mobile_no,
                        'relation'     => $nok->relation_with_kin,
                    ];
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                    if($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0007: Insertion failed in settlement_nominee for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0007: Registration of Settlement failed for RTPS application no : ".$application_no);
                        return false;
                    }
                }
            }

            //insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree'    => $case_no['case_no'],
                'basundhara'   => $application_no,
                'date_reg'     => date('Y-m-d'),
                'reg_by'       => $this->session->userdata('user_code'),
                'app_status'   => 'M',
                'pending_with' => 'CO',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0008: Registration of Settlement failed for RTPS application no : ".$application_no);
                return false;
            }

            //insert into back up file
            $backup_array = [
                'applid'  => $application_no,
                'case_no' => $case_no['case_no'],
                'status'  => 'I',
                'data'    => $backup
            ];
            $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
            if($backup_insertion != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $this->db->trans_commit(); // transaction ends here


        }else{
            $case_no['case_no'] = $this->db->select()
                ->where('basundhara', $application_no)
                ->get('basundhar_application')->row()->dharitree;
        }
        //********************case registration from API end********* */
        //************************************************************************************** */
        ////******* case data fetch from db for Lm start */
        redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case='.$case_no['case_no']);



    }



    //MB : AP CASE BULK NOTICE GENERATE=============19082023

    public function coBulkNoticeGenerateAndForward(){
        // generate notice starts here

        $markedApplications = $this->input->post('selectMark');

        if(count($markedApplications) == 0){
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if(count($markedApplications) > 10){
            log_message("error",'#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $hearing_date = $this->input->post('hearing_date');
        $completedCases = array();
        foreach ($markedApplications as $key => $value) {
            $status = $this->autoModel->apAutoRegisterAtCoByCoDuringBulkNotice($value);
            $status = json_decode($status);

            log_message("error","MB: Auto Registration Status========CASE NO==".json_encode($status));
            //notice w  ll generate if registration complete done=================
            if($status->responseType == 2){

                $case_no =$status->case_no;


                $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);

                if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
                    $remark_co = "AP Notice";
                    $remark_co_text = "Notice Generated";
                }else{
                    $remark_co = $this->input->post('remark_co');
                    $remark_co_text = $this->input->post('remark_co_text');
                }

                $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
                //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
                $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
                $get_owners = $this->SettlementApModel->getOwners($case_no);
                $get_buyers = $this->SettlementApModel->getBuyers($case_no);

                if(empty($get_buyers) || $get_buyers == null){
                    log_message('error',"#ERRCO09877289: Buyers not found for the case_no==".$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO09877289:  Buyers not found for the case_no=='.$case_no,
                        'list' => json_encode($completedCases)
                    ];
                    echo json_encode($json);
                    return;
                }

                $get_dag_details = $this->SettlementApModel->getDags($case_no);
                $get_chitha_owners = $this->SettlementApModel->getAllOwnersChithaBulk($case_no);

                if($get_chitha_owners['responseType'] != 2){
                    log_message('error',"#ERRCO0987721: Pattadars not found for the case_no==".$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0987721:  Pattadars not found for the case_no=='.$case_no,
                        'list' => json_encode($completedCases)
                    ];
                    echo json_encode($json);
                    return;
                }

                $get_chitha_owners = $get_chitha_owners['data'];
                $data = [
                    'hearing_date' => $hearing_date,
                    'case_no' => $case_no,
                    'remark_co' => $remark_co,
                    'get_settlement_basic' => $get_settlement_basic,
                    'get_dag_details' => $get_dag_details,
                    'get_settlement_applicant' => $get_settlement_applicant,
                    'get_chitha_owners' => $get_chitha_owners,
                    'remark' => $remark_co,
                    'notice_hearing_date' => $hearing_date,
                    'get_owners' => $get_owners,
                    'get_buyers' => $get_buyers,
                    'remark_co_text' => $remark_co_text,
                    'is_generated' => false
                ];

                $PayloadString = json_encode($data);


                $htmlString = $this->getNoticeGenerationString($PayloadString);

                if(isset($htmlString) && $htmlString!=null && $htmlString!=''){

                    $this->db->trans_begin();

                    $this->saveNoticeBulk($case_no,$htmlString,$PayloadString,$completedCases);


                    if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        log_message('error','Something went wrong...transaction failed for case_no=='.$case_no);

                        return false;
                    }else{
                        $this->db->trans_commit();
                        $completedCases[] = $case_no;

                    }
                }else{
                    log_message('error',"#ERRCO09877: Failed to generate htmlString for the case_no==".$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO09877: Failed to generate htmlString for the case_no=='.$case_no,
                        'list' => json_encode($completedCases)
                    ];
                    echo json_encode($json);
                    return;

                }

            }else{
                log_message('error',"==Case not registered for the RTPS CASE NO==".$value);
                $json = [
                    'responseType' => 3,
                    'message' => $status->msg. " ==Case not registered for the RTPS CASE NO==".$value,

                ];
                echo json_encode($json);
                return;
            }
        }


        echo json_encode([
            'responseType' => 2,
            'message' => 'Notice successfully generate for the selected cases...',
            'list' => json_encode($completedCases)
        ]);




    }


    public function getNoticeGenerationString($PayloadString){
        $data = json_decode($PayloadString);

        $get_chitha_owners = $data->get_chitha_owners;
        $get_settlement_basic = $data->get_settlement_basic;
        $get_dag_details = $data->get_dag_details;
        $notice_hearing_date = $data->notice_hearing_date;
        $get_buyers = $data->get_buyers;
        $f = null;
        if($get_chitha_owners){
            $f = 'প্ৰতি-';
        }


        $mouza = $this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code);

        $details  = $this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)."</b> নম্বৰ লাটৰ, <b>".$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code);

        $position = 0;
        $length = count($get_buyers);
        $h = null;
        $html = "";

        $html .= '<div id="printableArea">
            <div class="container bg-white shadow pb-3" id="print_direct">
               <div class="row mt-5 text-center">
                  <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                     <u>আবেদনকাৰী আৰু পট্টাদাৰৰ শুনানিৰ বাবে জাননী</u>
                     <br> <span style="font-size: 14px; font-weight:bold;"> জাননী নং- <b>'.$data->case_no.'</span></b>            
                  </div>
               </div>

               <div class="row mt-4 px-5">
                  <div class="col-2">'.$f.'</div>
                  <div class="col-8">
                  </div>
                  
                  <div class="col-2">
                     তাৰিখ- <b>'.date('Y-m-d').'</b>
                  </div>
               </div>
               
               <div class="row mt-4 px-5">
                  <div class="col-1">

                  </div>
                  <div class="col-11"><b>'.$get_chitha_owners->owners.'</b>
                  </div>
               </div>

      
               
               <div class="row mt-4">
                  <div class="col-12 text-justify p-5">
                  ইয়াৰদ্বাৰা আপোনালোকক জনোৱা হয় যে,
                     <b>';
        ?>
        <?php
        foreach($get_buyers as $app){
            if($position == $length - 1){
                $html .=  $app->pdar_name;
            }elseif($position == $length - 2){
                $html .= $app->pdar_name.' আৰু ';
            }else{
                $html .= $app->pdar_name.', ';
            }
            $position++;
        } ?>


        <?php
        $html .= '</b> 
                     য়ে, 

                     <b>'.$mouza.'</b> 
                     মৌজাৰ, 
                     <b>'.$details.'</b>
                     গাঁৱৰ, 
                    ';?>


        <?php
        $dag_position = 0;
        $dag_length = count($get_dag_details);

        foreach($get_dag_details as $dags){
            if($dag_position == $dag_length - 1){
                $html .= '<b>'.$dags->patta_no.'</b> 
                                 নং একচনা পট্টাৰ, <b>'.$dags->dag_no.'</b> 
                                 দাগৰ, মুঠ <b>'.$dags->s_dag_area_b.'</b> 
                                 বিঘা <b>'.$dags->s_dag_area_k.'</b> 
                                 কঠা <b>'.$dags->s_dag_area_lc.'</b> 
                                 লেচা ';

            }elseif($dag_position == ($dag_length - 2)){

                $html .='<b>'.$dags->patta_no.'</b> 
                                 নং পট্টাৰ, <b>'.$dags->dag_n.'</b> 
                                 দাগৰ, মুঠ <b>'.$dags->s_dag_area_b.'</b> 
                                 বিঘা <b>'.$dags->s_dag_area_k.'</b> 
                                 কঠা <b>'.$dags->s_dag_area_lc.'</b> 
                                 লেচা আৰু';
            }else{

                $html .='<b>'.$dags->patta_n.'</b> 
                     নং পট্টাৰ, <b>'.$dags->dag_n.'</b> 
                     দাগৰ, মুঠ <b>'.$dags->s_dag_area_b.'</b> 
                     বিঘা <b>'.$dags->s_dag_area_k.'</b> 
                     কঠা <b>'.$dags->s_dag_area_lc.'</b> 
                     লেচা,';
            }
            $dag_position++;
        } ;

        $html .= 'ভূমিৰ হস্তান্তৰ মমে চৰকাৰীকৰণ ক্ৰমে পট্টনৰ বাবে আৱেদন দাখিল কৰিছে। এই ক্ষেত্ৰত তদন্ত মৰ্মে উক্ত ভূমি হস্তান্তৰ হোৱা বুলি প্ৰতিবেদন পোৱা গৈছে। তেনেক্ষেত্ৰত বন্দোবস্তীৰ নিয়মাৱলীৰ বিধি ২(১)(গ) মমে উক্ত মাটি কিয় চৰকাৰীকৰণ কৰা নহ’ব, তাৰ শুনানীৰ বাবে <b>'.$notice_hearing_date.'</b> তাৰিখ ধাৰ্য কৰা হৈছে। 
                     <br><br>
                     গতিকে আপোনালোকক যাৱতীয় নথিপত্ৰসহ উক্ত দিনত চক্ৰ বিষয়াৰ কাৰ্যালয়ত উপস্থিত থাকিবলৈ অনুৰোধ জনোৱা হল।
                  </div>
               </div>
               <div class="row mt-5 justify-content-end mb-5">
                  <div class="col-5 text-center">
                     <b>'.$this->utilityclass->getSelectedCOName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code, $this->session->userdata('user_code'))->username.'</b><br>
                     চক্ৰ বিষয়া <br> 
                     '.$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code).'
                  </div>
               </div>
            </div>
         </div>';

        return base64_encode($html);



    }


    public function saveNoticeBulk($case_no,$htmlString,$PayloadString,$completedCases){

        $PayloadString = json_decode($PayloadString);


        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        if(is_dir(CO_NOTICE_PATH)===false){
            mkdir(CO_NOTICE_PATH,0777);
        }
        $base_64_file_path = CO_NOTICE_PATH.$new_case_no.".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        // base64 file
        $htmlstring_text = json_encode($htmlString);
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $hearing_date = $PayloadString->hearing_date;
        $remark_co =  $PayloadString->remark_co;
        $remark_co_text =  $PayloadString->remark_co_text;
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);

        $district = $this->utilityclass->getDistrictName($get_settlement_basic->dist_code);
        $sub_division = $this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code);
        $circle = $this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code);

        $lot_no = $this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no);

        $mouza = $this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code);
        $village = $this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code);


        $petitioner_name = null;
        $g_name = null;
        $dag_name = null;
        $form_resub_check = null;
        $is_generated = $PayloadString->is_generated;
        $data = [
            'hearing_date' => $hearing_date,
            'case_no' => $case_no,
            'remark_co' => $remark_co,
            'get_settlement_basic' => $get_settlement_basic,
            'get_dag_details' => $get_dag_details,
            'get_settlement_applicant' => $get_settlement_applicant,
        ];

        $lmnotes = $this->SettlementApModel->getSettlementApLmNote($case_no);

        if($lmnotes ==null || $lmnotes=='' || empty($lmnotes)){
            $lm_report = "no";
        }else{
            $lm_report = "yes";
        }


        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM settlement_basic WHERE case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();

        if ($service_details && $service_details->status == 'D') {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO330005: Updation Failed in settlement_basic table');

            $json = [
                'responseType' => 3,
                'message' => '#ERRCO3300051: Failed to generate notice. Kindly contact system administrator',
            ];
            
            echo json_encode($json);
            return false;
        }

        $sql_buyers = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach($applicant_buyers as $buyers){
            $applicant_buyers_json[] = [
                'APPLICANT_ID' => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME' => $buyers->pdar_guardian
            ];
        }
        $notice_no = "MB2/GN/".date('Y')."/".SETTLEMENT_AP_TRANSFER."/".$service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                     => $case_no,
            'service_code'                => $service_details->service_code,
            'case_registration_date'      => $service_details->submission_date,
            //'payment_notice_date'         => date('Y-m-d'),
            // 'total_amount'                => $amount,
            //'sdlac_proposal_id'           => $service_details->sdlace_proposal_no,
            //'sdlac_proposal_date'         => $service_details->sdlac_date,
            'applicant_details'           => json_encode($applicant_buyers_json),
            //'payment_completed_date'      => date('Y-m-d'),
            'notice_no'                   => $notice_no,
            'notice_link'                 => $base_64_file_path,
            'notice_type'                 => 'GN',
            'hearing_date'                => $hearing_date
        ];

        if($is_generated == true){
            $this->db->where('case_no', $case_no);
            $this->db->where('notice_type', 'GN');
            $this->db->update('settlement_notice', $insertIntoSettlementNotice);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0078988: Updation Failed in settlement_notice table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0078988: Failed to generate notice against case_no =='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return;
            }
            $updateArr = [
                'co_hearing_date' => $hearing_date,
                'notice_generated_date' => date('Y-m-d h:i:s'),
                'date_update' => date('Y-m-d h:i:s'),
                'co_app_notice_link' => $base_64_file_path
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0078989: Updation Failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0078990: Failed to generate notice against case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return;
            }

        }else{
            $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
            if($insertIntoSettlementNotice != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0078991: Insertion failed in settlement_notice');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0078991: Failed to generate notice against case_no =='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return;
            }


            if($lm_report =="no"){
                $pending_officer = 'LM';
                $status = 'V';
            }else{
                $pending_officer = 'CO';
                $status = 'W';
            }

            $updateArr = [
                'co_hearing_date' => $hearing_date,
                'co_code' => $this->session->userdata('user_code'),
                'status' =>$status,
                'notice_generated_yn' => 'Y',
                'notice_generated_date' => date('Y-m-d h:i:s'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => 'CO',
                'co_app_notice_link' => $base_64_file_path
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0078992: Updation Failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0078992: Failed to generate notice against case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return;
            }
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        if($is_generated == true){
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'General notice re-generated',
                'status' => 'A',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Notice Re-generated'
            ];
        }else{
            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'General notice generated.',
                'status' => 'A',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Notice Generated'
            ];
        }

        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0078993: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0078993: Failed to generate notice against case_no=='.$case_no,
                'list' => json_encode($completedCases)
            ];
            echo json_encode($json);
            return;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'responseType' => 3,
                'message' => 'Error in submitting against case_no=='.$case_no,
                'list' => json_encode($completedCases)
            );
            echo json_encode($data);
            return;
        }else{

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
                'type' => 'GN',
                'amount' => 0,
                'is_full_pay' => 'N'
            )));
            $result = curl_exec($curl_handle);

            if(trim($result) != 'y'){
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO007899398: Failed to generate notice against case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return ;

            }else{

                if($lm_report =="no"){
                    //////////////POST To basundhara/////////////////////
                    $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
                    $rmk='Forwarded to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
                        $this->db->trans_rollback();
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO007899399: Failed to generate notice against case_no=='.$case_no,
                            'list' => json_encode($completedCases)
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }


            }

        }
    }



    public function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }


    public function getListofcasesNR()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');

        $user_code = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $nr_cat = $this->input->post('nr_cat');

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



        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }


        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }


        $this->db->select('distinct(a.case_no), b.is_nr_settlement, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

        if(!empty($nr_cat))
        {
            if(trim($nr_cat) == 'nr')
            {
                $this->db->where('b.is_nr_settlement', 'NR');
            }
            else
            {
                $this->db->where('b.is_nr_settlement', 'NR with Settlement');
            }
        }

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where_in('a.status', 'Y');

        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');


        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if($rows->is_nr_settlement == 'NR')
                {
                    $nr_status = 'NR';
                }
                elseif($rows->is_nr_settlement == 'NR with Settlement')
                {
                    $nr_status = 'NR with Settlement';
                }


                $write_report = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',



                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $nr_status,

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $write_report

                );
            }

            $this->db->where('a.service_code', $s_code);

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }



            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            if(!empty($nr_cat))
            {
                if(trim($nr_cat) == 'nr')
                {
                    $this->db->where('b.is_nr_settlement', 'NR');
                }
                else
                {
                    $this->db->where('b.is_nr_settlement', 'NR with Settlement');
                }
            }

            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');

            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where_in('a.status', 'Y');



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

    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null){
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
    }


    //MB : AP CASE BULK FORWARD NR CASES=============11102023

    public function coBulkForwardNR(){

        $markedApplications = $this->input->post('selectMark');


        if(count($markedApplications) == 0){
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if(count($markedApplications) > 10){
            log_message("error",'#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $remark_co = $this->input->post('remark_co_type');
        $remark_co_text = $this->input->post('remark_co');
        $completedCases = array();
        foreach ($markedApplications as $key => $value) {
            $case_no = $value;
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
                log_message('error', '#ERRCO0987728933: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728933:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
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
                'status' => 'R',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => "Revert Back to LM"
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0987728219: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728219:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728219:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return false;
            }else{

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
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    log_message('error','Something went wrong...transaction failed for case_no=='.$case_no);
                }else{
                    $this->db->trans_commit();
                    $completedCases[] = $case_no;

                }
            }

        }


        echo json_encode([
            'responseType' => 2,
            'message' => 'Forwarded successfully for the selected cases...',
            'list' => json_encode($completedCases)
        ]);




    }


    // Pagination for co end 11-10-2023 -js-
    public function getListofcasesDcRevert()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');

        $user_code = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');

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



        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        // and (from_office='DC' OR from_office='ADC' OR from_office='SDO') and pending_officer='CO'


        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }


        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');


        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.status', $status);
        $this->db->where('a.pending_officer',MB_CIRCLE_OFFICER);




        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {


                $write_report = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',



                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $write_report

                );
            }

            $this->db->where('a.service_code', $s_code);

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }



            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }



            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.status', $status);
            $this->db->where('a.pending_officer',MB_CIRCLE_OFFICER);



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

    //MB : AP CASE BULK FORWARD NR CASES=============12102023

    public function coBulkForwardDCRevert(){

        $markedApplications = $this->input->post('selectMark');


        if(count($markedApplications) == 0){
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if(count($markedApplications) > 10){
            log_message("error",'#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $remark_co = $this->input->post('remark_co_type');
        $remark_co_text = $this->input->post('remark_co');
        $completedCases = array();
        foreach ($markedApplications as $key => $value) {
            $case_no = $value;
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
                log_message('error', '#ERRCO0987728933: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728933:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
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
                'status' => 'R',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => "Revert Back to LM"
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0987728219: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728219:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987728219:  Falied to revert back to LM=== case_no=='.$case_no,
                    'list' => json_encode($completedCases)
                ];
                echo json_encode($json);
                return false;
            }else{

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
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    log_message('error','Something went wrong...transaction failed for case_no=='.$case_no);
                }else{
                    $this->db->trans_commit();
                    $completedCases[] = $case_no;

                }
            }

        }


        echo json_encode([
            'responseType' => 2,
            'message' => 'Forwarded successfully for the selected cases...',
            'list' => json_encode($completedCases)
        ]);


    }



}