<?php
class NcLmKhaslandModel extends CI_Model
{
    public function __construct() {
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

    public function createRegistration($application_no, $curlOutput, $service_code, $service_name)
    {

        //****************generating case number********************
        $case_name=$this->NcApiModel->genearteCaseName();
        if(empty($case_name)){
            return $this->ncutility->errorResp('ERRJS81', 'Unable to generate case number!');
        }
        //*******generating petition_no and case_no */
        $petition_no = $this->NcApiModel->genearteSettlementPetitionNo();
        $case_no = $case_name.$petition_no."/".$service_name;

        //********basundhar_application insertation */
        $basuResp = $this->basundharInsert($case_no, $application_no);
        if($basuResp['responseType'] != 2){
            return $basuResp;
        }

        //********** Insertion in settlement_basic*/
        $basicResp = $this->settlementBasicInsert($case_no, $application_no, $petition_no, $curlOutput);
        if($basicResp['responseType'] != 2){
            return $basicResp;
        }

        //********** Insertion in settlement_applicant */
        $appResp = $this->settlementApplicantInsert($case_no, $application_no, $petition_no, $curlOutput);
        if($appResp['responseType'] != 2){
            return $appResp;
        }

        //***********Insertion in settlement_nominee */
        $nomResp = $this->settlementNomineeInsert($case_no, $curlOutput);
        if($nomResp['responseType'] != 2){
            return $nomResp;
        }
        //**********Insertion in settlement_additional_property */
        $addProResp = $this->settlementAdditionalPropertyInsert($case_no, $application_no, $service_code, $curlOutput);
        if($addProResp['responseType'] != 2){
            return $addProResp;
        }

        //*******overall success */
        return $this->ncutility->successResp('SUCSJS091022', 'Application successfully registered...');

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

        if($basundharAppInsert != true){
            return $this->ncutility->errorResp('ERRSET0003202','Something went wrong! Unable to process...', true);
        }
        return $this->ncutility->successResp('SUCSJS091016', 'Dharitree relation created...');
    }

    private function settlementBasicInsert($case_no, $application_no, $petition_no, $curlOutput){
        //****bhumiputra condition prepare for insertation */
        if(!empty($curlOutput->bhumi['0'])) {
            if($curlOutput->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                $bhumiputra_confirmation     = 'YES';
                $bhumiputra_certificate_no   = $curlOutput->bhumi['0']->bhumi_ack_no;
                $bhumiputra_certificate_type = 'CERT';
            }
            else if($curlOutput->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                $bhumiputra_confirmation     = 'YES';
                $bhumiputra_certificate_no   = $curlOutput->bhumi['0']->bhumi_ack_no;
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


        if($curlOutput->application->is_urban == NULL or $curlOutput->application->is_urban == '')
        {
            return $this->ncutility->errorResp('MR0202020', 'Something went wrong ! (Urban/Rural)');
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

        if($resp != true){
            return $this->ncutility->errorResp('ERR080419', 'Something went wrong! Unable to process...#'.$case_no, true);
        }
        return $this->ncutility->successResp('SUCSJS091015', 'Basic data successfully saved...');
    }

    public function settlementApplicantInsert($case_no, $application_no, $petition_no, $curlOutput){
        //*********** */ aadhaar photo api*******
        $url = API_LINK_NC."getApplicantPhoto";
        $aadhaarPhotoApi = $this->ncutility->curlPost($url, array(
            'application_no' => $application_no,
        ));

        if($aadhaarPhotoApi != 'n'){
            $aadhaarPhotoApiPhoto = "<img src = data:".$this->ncutility->decodeBase64($aadhaarPhotoApi).";base64,".$aadhaarPhotoApi." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        $cron_no = $this->settlementApplicantCronNo($case_no);

        foreach ($curlOutput->settlements as $setl) {

            if ($aadhaarPhotoApiPhoto != 'n' && $setl->is_applicant == '1') {
                $timestamp = date('mdYhis', time()).uniqid();
                $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                $aadhaar_encoded_file = $aadhaarPhotoApiPhoto;
                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                fclose($aadhaar_file_to_write_base64);
            }else{
                $aadhar_path = '';
            }

            if($curlOutput->aadhar->type == 'AADHAAR'){
                $identity_ref_no = $curlOutput->aadhar->aadhaar_no;
            }else{
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
                'pdar_rel_guar'             => $setl->gurdian_relation_id == null?0:$setl->gurdian_relation_id,
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
                return $this->ncutility->errorResp('ERRJS020508', 'Something went wrong! Unable to process...#'.$case_no, true);
            }
        }
        return $this->ncutility->successResp('SUCSJS091015', 'Applicant details successfully saved...');
    }

    public function settlementApplicantCronNo($case_no){
        $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no."'";
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return $cron_no = (int)$result->row()->pdar_cron_no + 1;
        }else{
            return $cron_no = 1;
        }
    }

    public function settlementNomineeInsert($case_no, $curlOutput){
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
                    return $this->ncutility->errorResp('ERRJS080522', 'Something went wrong! Unable to process...#'.$case_no, true);
                }
            }
        }
        return $this->ncutility->successResp('SUCSJS091014', 'Nominee successfully saved...');
    }

    public function settlementAdditionalPropertyInsert($case_no, $application_no,$service_code,$curlOutput){
        $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($application_no));

        if($checkAdditionalProperty->num_rows() == 0){
            if(isset($curlOutput->property)) {
                foreach($curlOutput->property as $value) {
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
                        return $this->ncutility->errorResp('ERRORJS080535', 'Something went wrong! Unable to process...#'.$case_no, true);
                    }
                }
            }
        }
        return $this->ncutility->successResp('SUCSJS091013', 'Additional property successfully saved...');
    }

    public function getAadhaarPhoto($application_no){
        $applicants = $this->SettlementApplicantModel->get($application_no);

        if($applicants->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS020209','Applicant data not found!');
        }

        $applicants = $applicants->result();
        foreach($applicants as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        $url = API_LINK_NC."getApplicantPhoto";
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
                            return $this->ncutility->errorResp('ERRJS120209','API response failed!');
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

    public function getSelfDocAPIData($application_no)
    {
        $curlUrl = API_LINK_NC."getAppDetails";
        $token = $this->ncutility->createTokenJwt();
        $curlData = $this->ncutility->curlPost($curlUrl, array(
            'application_no' => $application_no,
            'api_key' => API_KEY,
            'token' => $token
        ));

        if($curlData == false){
            return $this->ncutility->errorResp('ERRJS56', 'Unable to connect to Basundhara API!');

        }

        if(isset(json_decode($curlData)->responseType)){
            if(json_decode($curlData)->responseType == 3){
                return $this->ncutility->errorResp('ERRJS66', 'Unauthorized access!!'.json_decode($curlData)->data, true);
            }
        }
        // return json_decode($curlData);

        return $this->ncutility->successResp('SUCSJS09020257', 'Data successfully fetched...', false, 2, json_decode($curlData));
    }

    public function getJointApplicants($application_no){
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $applicants = $this->SettlementApplicantModel->getJointApplicants($application_no);
        if($applicants->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS1210147', 'No join applicant found!');
        }
        return $this->ncutility->successResp('SUCSJS121049', 'Successfully fetched joint applicants', false, 2, $applicants->result());
    }

    public function getEncroachers($application_no){
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $encr = $this->SettlementApplicantModel->getEncroachers($application_no);
        if($encr->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS1210103', 'No join applicant found!');
        }
        return $this->ncutility->successResp('SUCSJS12124', 'Successfully fetched joint applicants', false, 2, $encr->result());
    }

    public function getIsApplicant($application_no){
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $applic = $this->SettlementApplicantModel->getIsApplicant($application_no);
        if($applic->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS12130103', 'No join applicant found!');
        }

        $applicant_row = $applic->row();
        $applicant_row->guar_rel_name = $this->ncutility->getRelationById56($applicant_row->pdar_rel_guar);
        $applicant_row->gender_name = $applicant_row->pdar_gender == 1 ? 'Male' : ($applicant_row->pdar_gender == 2 ? 'Female' : ($applicant_row->pdar_gender == 3 ? 'Others' : ''));

        foreach(json_decode(MARITAL_STATUS) as $marital_stat){
            if($marital_stat->CODE == $applicant_row->marital_status){
                $applicant_row->marital_status_name = $marital_stat->NAME;
            }
        }
        return $this->ncutility->successResp('SUCSJS182124', 'Successfully fetched joint applicants', false, 2, $applicant_row);
    }

    public function getNcVillagesInLot($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
        $ncVil = $this->LocationModels->getNcVillagesInLot($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        if($ncVil->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS121251', 'No nc village data found!');
        }
        return $this->ncutility->successResp('SUCSJS125212','NC villages successfully fetched...', false, 2, $ncVil->result());
    }

    public function getDagsFromChitha($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code){
        $c_dags = $this->ChithaBasicModel->getDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        if($c_dags->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS12020101', 'No dags data found!');
        }
        return $this->ncutility->successResp('ERRJS12020102','Dags successfully fetched...', false, 2, $c_dags->result());
    }

    public function getEncroachersInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no){
        $encroachers = $this->LandbankModel->getEncroacherInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no);

        if($encroachers->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS12320101', 'No encroachers found in landbank!');
        }
        return $this->ncutility->successResp('ERRJS10620102','Encroachers successfully fetched...', false, 2, $encroachers->result());
    }

    public function dagEncAreaSubm(){
        //*****insert area details into settlement_dag_details and settlement_area_history */

        //*****insert encroacher into settlement_applicant */



    }

    public function insertDagDetails($dagRow){
        ///****a check needs to be done if already dag exist in settlement_dag_details against the case_no if so then we have to validate the existing dag area limit new inserting dag area limit */
        $existing_homeMax = 0;
        $existing_agriMax = 0;
        $existing_is_urban_arr = array();

        $maxExist = $this->settlementDagExistingLimitCheck($dagRow->case_no);
        if($maxExist['responseType'] == 2){
            $existing_homeMax = $maxExist['data']->homeMax;
            $existing_agriMax = $maxExist['data']->agriMax;
            $existing_is_urban_arr = $maxExist['data']->is_urban_arr;
        }

        $appliedMaxHome = 0;
        $appliedMaxAgri = 0;

        $encroachment_area = [
            'homestead' => [
                'bigha'     => $dagRow->applied_home_bigha,
                'katha'     => $dagRow->applied_home_katha,
                'lessa'     => $dagRow->applied_home_lessa,
                'ganda'     => $dagRow->applied_home_ganda,
                'kranti'    => $dagRow->applied_khome_ranti,
            ],

            'agriculture' => [
                'bigha'     => $dagRow->applied_agri_bigha,
                'katha'     => $dagRow->applied_agri_katha,
                'lessa'     => $dagRow->applied_agri_lessa,
                'ganda'     => $dagRow->applied_agri_ganda,
                'kranti'    => $dagRow->aapplied_agri_kranti,
            ],
        ];

        if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY))){
            //******for Barak valley */
            $areaHomeLessa = $this->ncutility->Total_ganda($dagRow->applied_home_bigha, $dagRow->applied_home_katha, $dagRow->applied_home_lessa, $dagRow->applied_home_ganda, $dagRow->applied_khome_ranti);
            $areaAgriLessa = $this->ncutility->Total_ganda($dagRow->applied_agri_bigha, $dagRow->applied_agri_katha, $dagRow->applied_agri_lessa, $dagRow->applied_agri_ganda, $dagRow->aapplied_agri_kranti);

            $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
            $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalAreaLessa);

        }
        else{
            $areaHomeLessa = $this->ncutility->Total_Lessa($dagRow->applied_home_bigha, $dagRow->applied_home_katha, $dagRow->applied_home_lessa);
            $areaAgriLessa = $this->ncutility->Total_Lessa($dagRow->applied_agri_bigha, $dagRow->applied_agri_katha, $dagRow->applied_agri_lessa);

            $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
            $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalAreaLessa);
        }

        $appliedMaxHome += $areaHomeLessa;
        $appliedMaxAgri += $areaAgriLessa;

        $s_dag_area_b = $totalAreaArr[0];
        $s_dag_area_k = $totalAreaArr[1];
        $s_dag_area_lc = $totalAreaArr[2];
        $s_dag_area_g = $totalAreaArr[3];
        $s_dag_area_kr = 0;

        $isUrban = $this->NcLogicModel->isUrban($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_code, $dagRow->lot_no, $dagRow->village_code, $dagRow->dag_no);

        $isUrbanArr[] = $isUrban;

        $updateArray = array(
            'dist_code'             => $dagRow->dist_code,
            'subdiv_code'           => $dagRow->subdiv_code,
            'cir_code'              => $dagRow->cir_code,
            'mouza_pargona_code'    => $dagRow->mouza_code,
            'lot_no'                => $dagRow->lot_no,
            'vill_townprt_code'     => $dagRow->village_code,
            'user_code'             => $this->session->userdata('user_code'),
            'date_entry'            => date('Y-m-d'),
            'case_no'               => $dagRow->case_no,
            'petition_no'           => $dagRow->petition_no,
            'year_no'               => date('Y'),
            'new_land_class_code'   => $dagRow->land_class_code,
            'dag_no'                => $dagRow->dag_no,
            'patta_no'              => $dagRow->patta_no,
            'patta_type_code'       => $dagRow->patta_code,
            'is_urban'              => $isUrban,
            'land_type'             => $dagRow->land_type,
            'revenue'               => 0,
            'operation'             => 'E',
            'encroachement_area'    => json_encode($encroachment_area),
            'dag_area_b'            => $dagRow->chitha_bigha,
            'dag_area_k'            => $dagRow->chitha_katha,
            'dag_area_lc'           => $dagRow->chitha_lessa,
            'dag_area_g'            => $dagRow->chitha_ganda,
            'dag_area_kr'           => $dagRow->chitha_kranti,
            'home_b'                => $dagRow->applied_home_bigha,
            'home_k'                => $dagRow->applied_home_katha,
            'home_lc'               => $dagRow->applied_home_lessa,
            'home_g'                => $dagRow->applied_home_ganda,
            'home_kr'               => $dagRow->applied_home_kranti,
            'agri_b'                => $dagRow->applied_agri_bigha,
            'agri_k'                => $dagRow->applied_agri_katha,
            'agri_lc'               => $dagRow->applied_agri_lessa,
            'agri_g'                => $dagRow->applied_agri_ganda,
            'agri_kr'               => $dagRow->applied_agri_kranti,
            's_dag_area_b'          => $s_dag_area_b,
            's_dag_area_k'          => $s_dag_area_k,
            's_dag_area_lc'         => $s_dag_area_lc,
            's_dag_area_g'          => $s_dag_area_g,
            's_dag_area_kr'         => $s_dag_area_kr,
        );

        //****check if max area exceed in dag limit */
        $this->NcLogicModel->checkMaxLimitInDag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_code, $dagRow->lot_no, $dagRow->village_code, $dagRow->dag_no, $totalAreaLessa);

        $insertDag = $this->SettlementDagDetailsModel->insert($updateArray);
        if($insertDag != true){
            return $this->ncutility->errorResp('ERRJS3131141', 'Unable to insert dag details! Case No #'.$dagRow->case_no);
        }

        //****check if multiple dags are in both rural and urban */
        if (count(array_intersect(['Y', 'N'], array_merge($isUrbanArr, $existing_is_urban_arr))) != 2) {
            return $this->ncutility->errorResp('ERRJS631141', 'Unable to insert dag details! Case No #'.$dagRow->case_no);
        }
        //*****checking the max area limit home 1 bigha and agri 8 bigha */
        $this->NcLogicModel->checkMaxLimit(($appliedMaxHome + $existing_homeMax), ($appliedMaxAgri + $existing_agriMax), KHAS_MAX_HOMESTEAD, KHAS_MAX_AGRICULTURE, $isUrban);
    }

    public function settlementDagExistingLimitCheck($case_no){
        $dagsResult = $this->SettlementDagDetailsModel->get($case_no);
        if($dagsResult->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS6631141', 'No data found in Dag details! Case No #'.$case_no);
        }

        $maxHome = 0;
        $maxAgri = 0;
        foreach($dagsResult as $dagRow){
            $dag_no = $dagRow->dag_no;
            $patta_no = $dagRow->patta_no;
            $is_urban = $dagRow->is_urban;
            $home_b = $dagRow->home_b;
            $home_k = $dagRow->home_k;
            $home_lc = $dagRow->home_lc;
            $home_g = $dagRow->home_g;
            $agri_b = $dagRow->agri_b;
            $agri_k = $dagRow->agri_k;
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY))){
                $maxHome += $this->ncutility->Total_ganda($home_b, $home_k, $home_lc, $home_g);
                $maxAgri += $this->ncutility->Total_ganda($agri_b, $agri_k, $agri_lc, $agri_g);
            }else{
                $maxHome += $this->ncutility->Total_lessa($home_b, $home_k, $home_lc);
                $maxAgri += $this->ncutility->Total_lessa($agri_b, $agri_k, $agri_lc);
            }

            $isUrban_arr[] = $dagRow->is_urban;
        }

        $resArray = (object)[
            'homeMax'   => $maxHome,
            'agriMax'   => $maxAgri,
            'is_urban_arr'  => $isUrban_arr,
        ];

        return $this->ncutility->successResp('SUCSJS01501324', 'Successfully area data fetched...', false, 2, $resArray);
    }

    public function updateApplicantEncroacher($request){
        $insertArray = array(
            'dag_no'                => $request->dag_no,
            'patta_no'              => $request->patta_no,
            'patta_type_code'       => $request->patta_code,
            'period_possession'     => $request->possession_date,
            'year_no'               => date('Y'),
            'date_update'            => date('Y-m-d'),
            'pdar_name'             => $request->name_ass,
            'pdar_guardian'         => $request->gurdian_name_ass,
            'pdar_rel_guar'         => '0',
            'pdar_cron_no'          => (int) $request->pdar_cron_no,
            'pdar_id'               => -1,
            'enc_id'                => $request->encroacher_id,
        );

        // $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
    }

}