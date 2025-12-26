<?php
class SettlementTenantCoUrban extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Allowed designations
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
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('UtilsModel');
        $this->dbswitch();

        $method = $this->router->fetch_method();
        if(!in_array($method, VERIFICATION_MODULE_METHODS))
        {
            if(HOLD_All_MB2_CASES_STATUS == 1)
            {
                if(HOLD_All_MB2_CASES_STATUS == 1)
                {
                    if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
                    {
                        $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                        redirect(base_url() . "index.php/Home/index");
                    }
                }
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
        $chithaDagArray = [];
        $lmProcessArea = [];
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

                // SOD/ADC processing application
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

                // SOD/ADC processing application
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
    public function settlementTenantCo(){

        $case_no = $this->input->get('case');

        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == 'SK')
        {
            $this->utilityclass->authCheckCoSk($case_no, 'SK');
            $this->utilityclass->checkUserAuthForCaseForSk($case_no);

        }
        else if ($user_desig_code == 'CO')
        {
            $this->utilityclass->authCheckCoSk($case_no, 'CO');
            $this->utilityclass->checkUserAuthForCaseForCo($case_no);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $basic   = $this->SettlementTenantModel->getSettlementBasic($case_no);
        $applicants_buyers   = $this->SettlementTenantModel->getAllApplicantBuyers($case_no);
        $applicants_owners   = $this->SettlementTenantModel->getAllApplicantOwners($case_no);
        $applicants_encroacher   = $this->SettlementTenantModel->getAllApplicantEncroacher($case_no);
        $applicants_riotee_nok   = $this->SettlementTenantModel->getAllApplicantRioteeNok($case_no);

        $dags   = $this->SettlementTenantModel->getSettlementDag($case_no);
        $lmdata['dagsResult']   = $this->SettlementTenantModel->getSettlementDagResult($case_no);
        $lmnotes   = $this->SettlementTenantModel->getSettlementTenantLmNote($case_no);
        $proceedings   = $this->SettlementTenantModel->getSettlementProceeding($case_no);
        $dhardocuments   = $this->SettlementTenantModel->getDocuments($case_no);

        $lmdata['basic']=$basic;

        $lmdata['applicants_buyers']=$applicants_buyers;
        $lmdata['applicants_owners']=$applicants_owners;
        $lmdata['applicants_encroacher']=$applicants_encroacher;
        $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

        $lmdata['dags']=$dags;
        $lmdata['lmnotes']=$lmnotes;
        $lmdata['proceedings']=$proceedings;
        $lmdata['dhardocuments']=$dhardocuments;

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;
        $lmdata['pattaNo']=$this->utilityclass->getPattaTypeNo($lmdata['basic']["dist_code"],$lmdata['basic']["subdiv_code"],$lmdata['basic']["cir_code"],$lmdata['basic']["mouza_pargona_code"],$lmdata['basic']["lot_no"],$lmdata['basic']["vill_townprt_code"],$lmdata['dags']["dag_no"]);

        $applid = $this->utilityclass->getApplidFromCaseNo($case_no);

        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $applid,
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

        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        $lmdata['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec){
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

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
                            $url = API_LINK_MB3."getApplicantPhoto";
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


        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

        $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($case_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_URBAN_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }
        $lmdata['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($case_no);

        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($case_no)->result();


        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == SETTLEMENT_TENANT_URBAN_ID)
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

        $lmdata['_view'] = 'SettlementView/Co/Tenant/SettlementTenantCoViewUrban';
        $this->load->view('layouts/main',$lmdata);
    }

    public function generateNoticeCo(){
         // generate notice starts here
        if(isset($_POST['generate_notice'])){
            // var_dump("m here"); die();
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_text = $this->input->post('remark_co_text');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark' => $remark_co,
                'notice_hearing_date' => $hearing_date,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'remark_co_text' => $remark_co_text
            ];
            $this->load->view('SettlementView/Co/Tenant/SettlementNotice',$data);
            // var_dump($hearing_date);
            // die();
        }
        // to print notice
        if(isset($_POST['print_notice'])){
            $case_no = $this->input->post('case_no');
            // getting the notice file link
            $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
            // reading the base64 json file and saving it to a variable

            $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_app_notice_link']);
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
            $data['_view'] = 'SettlementView/Co/Tenant/PrintNotice';
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
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
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
                        $this->session->set_flashdata('message', "Case no # $case_no reverted back to LRA");
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

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count = (int)$phase_count+1;
            $backup_array = array(
                'applid' => $applid_backup,
                'case_no' => $case_no,
                'from_office' => 'CO',
                'to_office' => 'LM',
                'status' => 'R',
                'phase' => 'CO_'.$phase_count,
                'data' => json_encode($_POST)
            );

            $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            if($backup_insertion_co != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

                $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : ".$case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

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
                'note_on_order' => $remark_co_text,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Reverted to LM'
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
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status) != "y")
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP2003211: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }
                else
                {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }

                // $this->db->trans_commit();
                // $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                // // redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case='.$case_no);
                // redirect(base_url() . "index.php/home");
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

             //****check if owner details entered in settlement_tenent_beneficary if not enter as untraceable */
             $sqlQuerybene = $this->db->query('SELECT * FROM settlement_tenent_beneficiary WHERE case_no = ?', array($case_no));

             if($sqlQuerybene->num_rows() <= 0)
             {
                 $getOwner = $this->db->query('SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = ?', array($case_no, 'O'));
 
                 if($getOwner->num_rows() > 0)
                 {
 
                     foreach($getOwner->result() as $ownerDetails)
                     {
                         $inserBENEArr = [
                             'owner_living_status' => 'UNT',
                             'case_no' => $case_no,
                             'owner_name' => $ownerDetails->pdar_name,
                             'pdar_id' => $ownerDetails->pdar_id,
                             'owner_father' => $ownerDetails->pdar_guardian,
                         ];
 
                         $insertBen = $this->db->insert('settlement_tenent_beneficiary', $inserBENEArr);
 
                         if($insertBen != 1)
                         {
                             $this->db->trans_rollback();
                             log_message('error', '#BACKUPCO039901: Insertion failed in settlement_tenent_beneficiary RTPS Case No '.$case_no);
 
                             $this->session->set_flashdata('error_data', "#BACKUPCO039901: Registration of Settlement failed for case no : ".$case_no);
                             redirect(base_url() . "index.php/home");
                             return false;
                         }
 
                     }
                 }
                 else
                 {
                     $this->db->trans_rollback();
                     log_message('error', '#BACKUPCO03355301: Owner details not found for '.$case_no);
 
                     $this->session->set_flashdata('error_data', "#BACKUPCO03355301: Registration of Settlement failed for case no : ".$case_no);
                     redirect(base_url() . "index.php/home");
                     return false;
                 }
             }

            $updateArr = [
                'status' => $status,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'SK',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                // 'co_code' => $this->input->post('co_code'),
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
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to CO");
                    // redirect(base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $case_no);
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
            $remark_co_type = $this->input->post('remark_co_type');
            $this->db->trans_begin();

            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count = (int)$phase_count+1;
            $backup_array = array(
                'applid' => $applid_backup,
                'case_no' => $case_no,
                'from_office' => 'CO',
                'to_office' => 'DC',
                'status' => 'W',
                'phase' => 'CO_'.$phase_count,
                'data' => json_encode($_POST)
            );

            $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            if($backup_insertion_co != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

                $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : ".$case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }


            //****check if owner details entered in settlement_tenent_beneficary if not enter as untraceable */
            $sqlQuerybene = $this->db->query('SELECT * FROM settlement_tenent_beneficiary WHERE case_no = ?', array($case_no));

            if($sqlQuerybene->num_rows() <= 0)
            {
                $getOwner = $this->db->query('SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = ?', array($case_no, 'O'));

                if($getOwner->num_rows() > 0)
                {

                    foreach($getOwner->result() as $ownerDetails)
                    {
                        $inserBENEArr = [
                            'owner_living_status' => 'UNT',
                            'case_no' => $case_no,
                            'owner_name' => $ownerDetails->pdar_name,
                            'pdar_id' => $ownerDetails->pdar_id,
                            'owner_father' => $ownerDetails->pdar_guardian,
                        ];

                        $insertBen = $this->db->insert('settlement_tenent_beneficiary', $inserBENEArr);

                        if($insertBen != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#BACKUPCO033301: Insertion failed in settlement_tenent_beneficiary RTPS Case No '.$case_no);

                            $this->session->set_flashdata('error_data', "#BACKUPCO033301: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }

                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUPCO03333301: Owner details not found for '.$case_no);

                    $this->session->set_flashdata('error_data', "#BACKUPCO03333301: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }

       
            // foward to dc updates
            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'DC',
                'pending_office' => 'DC'
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0003: Falied to forward to DC');
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
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co_text,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Forwarded To DC'
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

                $rmk='Forwarded to DC';
                $status='M';
                $task='CO';
                $pen='DC';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                    // redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);
                    redirect(base_url() . "index.php/home");
                }

                // $this->db->trans_commit();
                // $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                // redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case='.$case_no);
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

    }


    public function FirstProceeding()
    {
        $service_code=$this->input->get('service');
        $status = $this->input->get('s');
        // $data['select_range'] = $select_offset = $this->input->post('select_range');
        //$data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending( $service_code);
        
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/first_proceeding_co';
        $this->load->view('layouts/main', $data);
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

    public function caseListUnderMappingLot(){
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

    public function initLanding(){
        $service_code=$this->input->get('service');
        $status = $this->input->get('s');
        // $data['select_range'] = $select_offset = $this->input->post('select_range');
        //$data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending( $service_code);
        
        $data['select_data'] = $this->SettlementCommonModel->locationSelectAll();

        $data['_view'] = 'settlement_mb/first_proceeding_co_landing_urban';
        $this->load->view('layouts/main', $data);
    }

    public function paginationCoFirstBulk()
    {
        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        // $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $nr_cat = $this->input->post('nr_cat');
        // $review_cat = $this->input->post('review_cat');

        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];

        $is_cat = $this->input->post('is_category');


        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "coServicewiseRecords/$s_code/$dist_code/$subdiv_code/$cir_code");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start'                 => $start,
            'length'                => $length,
            'order'                 => $order,
            'application_no'        => $searchByCol_0,
            'mouza_pargona_code'    => $mouza_pargona_code,
            'lot_no'                => $lot_no,
            'vill_townprt_code'     => $is_cat
        )));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        if (isset($results)) 
        {         
            foreach ($results->data_results as $rows) {

                $tenant_urban_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCoUrban/initRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
         
        
                $json[] = array(
                    $rows->application_no,
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),
            
                    $rows->date_submission,
            
                    (($s_code == SETTLEMENT_TENANT_URBAN_ID) ? $tenant_urban_link : ''),
                );
            }
    
            $total_records = $results->total_records;
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        } 
        else 
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function initRegistration($review_flag = false){
        $application_no_encrypted = $this->input->get('app');
        $application_no = $this->utilityclass->decryptJwtCase($application_no_encrypted);

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
        $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);

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
            $case_no['case_no'] = $case_name . $petition_no . "/" . SETTLEMENT_TENANT_URBAN;

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
                'service_code' => SETTLEMENT_TENANT_URBAN_ID,
                'ref_no' => $output->applicants['0']->ref_no,
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F',
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'ZC',
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
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'from_office' => 'API'
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
                            'service_id' => SETTLEMENT_TENANT_URBAN_ID,
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
                                $getRiotee = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=? AND khatian_no=? AND tenant_id=?", array($s, $c, $l, $m, $v, $appl->dag_no, $appl->khatian_no, $appl->encroacher_id));

                                // echo $this->db->last_query(); die;

                                if($getRiotee->num_rows() <= 0)
                                {
                                    // $get_pdar_name = '';
                                    // $get_pdar_guardian = '';
                                    // $get_pdar_add1 = '';
                                    // $get_pdar_add2 = '';

                                    //show err here

                                    $this->db->trans_rollback();
                                    log_message('error', '#ERROR012006: Tenant not found in chitha_tenant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                                    $data = array(
                                        'error' => "#ERROR012006: Registration of Settlement failed for case no : " . $application_no,
                                    );
                                    echo json_encode($data);
                                    return false;
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
                'pending_with' => 'CO',
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
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDeclaration");
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

        //get petition no from basundhar_application

        // $this->utilityclass->lmAuthBasic($case_no);

        // $this->utilityclass->lmAuthFirstProceeding($case_no);

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
                        $url = API_LINK_MB3."getApplicantPhoto";
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

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_URBAN_ID);
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
            $district['_view'] = 'SettlementView/Co/Tenant/SettlementTenantUrbanCo';
            $this->load->view('layouts/main', $district);
        }

        //*************if request method is a post then insert data  */
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $case_no = trim($this->input->post('case_no'));

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

            $this->form_validation->set_rules('co_remark', 'CO Remarks', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {

                if(isset($fileCount)){
                    $district['fileCount'] = $fileCount;
                }
                $district['all_errors'] = validation_errors();
                $district['err_return'] = true;
                $district['_view'] = 'SettlementView/Co/Tenant/SettlementTenantUrbanCo';
                $this->load->view('layouts/main',$district);
            }
            else
            {
                $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='CO' and status != 'ZC'";
                $dataFound=$this->db->query($sqlCheckExist)->row();
                //echo json_encode($dataFound);

                if($dataFound->c >0){

                    $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded from circle office. case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $this->db->trans_begin();

                $co_remark = $this->input->post('co_remark');

                $location = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

                if($location->num_rows() <= 0){
                    $this->session->set_flashdata('error_data', "#ERRC3300299: Something went wrong!. case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $basic_row = $location->row();

                $lm_code_sql = $this->db->query('select * from loginuser_table where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and dis_enb_option = ?', array($basic_row->dist_code, $basic_row->subdiv_code, $basic_row->cir_code, $basic_row->mouza_pargona_code, $basic_row->lot_no, 'E'));

                $lm_code = $lm_code_sql->row();
                
                $basicData = [
                    'status'          => 'Z',
                    'lm_code'         => $lm_code->user_code,
                    'submission_date' => date('Y-m-d H:i:s'),
                    'from_office'     => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office'  => 'CO',
                    'co_code'         => $this->session->userdata('user_code'),
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
                    'note_on_order' => $co_remark,
                    'status' => 'Z',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Forwarded to LM',
                    'note_type' => 'Forwarded to LM',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP3: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    $json = [
                        'errorMessage' => "#ERRORPP3: Failed to forward the case for Case No : " . $case_no,
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
                    $rmk = 'Forwarded to LM';
                    $status = 'M';
                    $task = 'CO';
                    $pen = 'LM';
                    $case = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
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
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to LM With Case No # $case_no");
                    redirect(base_url() . "index.php/home");
                }
            }

        }
      
    }


    public function generatePaymentNoticeCo(){
        if(isset($_POST['generate_notice'])){
            $payment_amount = $this->input->post('payment_amount');
            $case_no = $this->input->post('case_no');
            $remark = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $data = [
                'payment_amount' => $payment_amount,
                'case_no' => $case_no,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark' => $remark,
                'pay_notice_date' => date('Y-m-d')
            ];
            $this->load->view('SettlementView/Co/Tenant/paymentNotice',$data);
        }else{
            $case_no = $this->input->get('case');
            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['_view'] = 'SettlementView/Co/Tenant/generateNoticeView';
            $this->load->view('layouts/main', $data);
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
        $notice_no = "MB2/PN/".date('Y')."/SOT/".$service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no'                     => $case_no,
            'service_code'                => $service_details->service_code,
            'case_registration_date'      => $service_details->submission_date,
            'payment_notice_date'         => date('Y-m-d'),
            'total_amount'                => $amount,
            //'sdlac_proposal_id'           => $service_details->sdlace_proposal_no,
            //'sdlac_proposal_date'         => $service_details->sdlac_date,
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
        }else{
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;
            //   payment request API
            $status = $this->SettlementMbModel->paymentRequest($rtps_case_no,$amount);
            //   USER END STATUS API CALLING
            //   $user_status_api = $this->SettlementApiModel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if(trim($status) != 'y'){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again $case_no"
                );
                echo json_encode($data);
                return false;
            }
            //   API CALL END HERE
            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();

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
             
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."uploadNotice");
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
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case='.$case_no);
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
        $data = [
            'hearing_date' => $hearing_date,
            'case_no' => $case_no,
            'remark_co' => $remark_co,
            'get_settlement_basic' => $get_settlement_basic,
            'get_dag_details' => $get_dag_details,
            'get_settlement_applicant' => $get_settlement_applicant,
        ];
        $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM
                                 settlement_basic
                                 WHERE
                                    case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM
                              settlement_applicant
                           WHERE
                              case_no = ?
                           AND
                              pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach($applicant_buyers as $buyers){
            $applicant_buyers_json[] = [
                'APPLICANT_ID' => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME' => $buyers->pdar_guardian
            ];
        }
        $notice_no = "MB2/GN/".date('Y')."/SOT/".$service_details->petition_no;
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
            'notice_type'                 => 'GN'
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
            'co_hearing_date' => $hearing_date,
            'co_code' => $this->session->userdata('user_code'),
            'status' => 'A',
            'notice_generated_yn' => 'Y',
            'notice_generated_date' => date('Y-m-d h:i:s'),
            'date_update' => date('Y-m-d h:i:s'),
            // 'from_office' => 'CO',
            'pending_officer' => 'CO',
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
            'note_on_order' => $remark_co_text,
            'status' => 'A',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => $remark_co
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
            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type' => 'GN'
            )));
            $result = curl_exec($curl_handle);
            if(trim($result) != 'y'){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case='.$case_no);
            }
        
        }
    }


}