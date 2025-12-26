<?php
class NcKhasLand extends CI_Controller
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
        $this->load->library('AES');
        $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
        $this->ncutility->dbSwitchSession();


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }

    public function dbswitch11($dist_code)
    {
        if($dist_code == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($dist_code == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($dist_code == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($dist_code == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($dist_code == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($dist_code == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($dist_code == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($dist_code == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($dist_code == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($dist_code == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($dist_code == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($dist_code == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($dist_code == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($dist_code == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($dist_code == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($dist_code == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($dist_code == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($dist_code == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($dist_code == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($dist_code == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($dist_code == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        }  else if($dist_code == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        }else if($dist_code == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }else if($dist_code == "22"){
            $this->db=$this->load->database('dha41', TRUE);
        }else if($dist_code == "23"){
            $this->db=$this->load->database('dha40', TRUE);
        }
        return $this->db;
    }

    // Settlement AP CO view starts here
    public function settlementApCo()
    {
        $application_no = $this->input->get('app');

        $district['dist_code'] = $this->NcServiceModel->getDistCode($application_no);
        var_dump($district['dist_code']);
        die();

        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
        //   foreach($output->selfDeclaration as $selfDec){
        //       $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        //   }

        // var_dump($district['aadhar']); die();
        if ($this->session->userdata('user_desig_code') == 'ADC') {
            $district['_view'] = 'basundhara/settlementap_updation';
        } else {
            //    $district['_view'] = 'basundhara/settlementap_updation';
            $district['_view'] = 'SettlementView/Co/SettlementApTransferred';
        }
        $this->load->view('layouts/main', $district);
    }


    // call_back/call back functions for applicationKhaslandRegistration validation -js-
    public function reserveMoreThanAppArea(){
        return false;
    }

    public function familyMoreThanAppArea(){
        return false;
    }

    public function totalAppliedAreaZeroCheck(){
        return false;
    }

    public function appAreaMoreThanDagA(){
        return false;
    }

    public function khasMaxHomestead(){
        return false;
    }

    public function khasMaxAgriculture(){
        return false;
    }

    public function khasMaxFishery(){
        return false;
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

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function applicationKhaslandRegistration()
    {

        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();

        $this->ncutility->dbSwitchSession();

        $application_no = $this->input->get('app');
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

        // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

        if($supportive_document_sql->num_rows() > 0)
        {
            $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
        }
        else
        {
            $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }




        //********************case registration from API start ********* */
        //********************check and insert if case not registered */
        $recordExist=$this->NcApiModel->checkExistDharitree($application_no);


        if(!$recordExist)
        {
            /// additional property for LM note
            $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
            if($additional_property->num_rows() > 0){
                $totallesaa=0;
                $totalganda=0;
                foreach($additional_property->result() as $addprop){
                    if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                        $total_g=$this->ncutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                        $totalganda = $totalganda+$total_g;
                    }else{
                        $total_l=$this->ncutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                        $totallesaa = $totallesaa+$total_l;
                    }

                }
                if(!empty($totallesaa)){
                    $district['total_aditional_area']= $this->ncutility->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $district['total_aditional_area_g']= $this->ncutility->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $district['additional_property']=$additional_property->result();
                //var_dump($district['additional_property']); die;
            }



            $token = $this->ncutility->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
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

            // var_dump($output);
            // die;
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType == 3){
                    echo json_decode($output)->data." - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;

            $output = json_decode($output);

            //****************generate case number********************
            $case_name=$this->NcApiModel->genearteCaseName();
            if(empty($case_name))
            {
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                die();
            }
            //*******generating petition_no and case_no */
            $case_no['petition_no']=$petition_no=$this->NcApiModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".NC_KHAS_LAND;

            $district['geo_date']=$geo_date;
            $district['app']=$output->application;
            $district['pattaNo']=$this->ncutility->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

            $district['applicants']=$output->applicants;

            $district['document']=$output->documents;
            $district['query']=$output->query;
            $district['property']=$output->property;
            $district['settlements']=$output->settlements;
            $district['encroachers'] = $output->encroachers;
            $district['owners'] = $output->owners;
            $district['riotee_noks'] = $output->riotee_noks;
            $district['aadhar']=$output->aadhar;

            $district['nextKin'] = $output->nextKin;
            // get khatian number
            $d=$district['app']->dist_code;
            $s=$district['app']->subdiv_code;
            $c=$district['app']->cir_code;
            $m=$district['app']->mouza_code;
            $l=$district['app']->lot_no;
            $v=$district['app']->village_code;
            // $pno=$district['pattaNo']->patta_no;
            // $pc=$district['pattaNo']->patta_type_code;
            $dag = $district['app']->dag_no;

            $district['co_name']= $this->NcCommonModel->getCoName($d, $s, $c);
            $district['s_area'] = $this->NcCommonModel->getPremiumArea();

            $district['bhumi'] = $output->bhumi;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();

            if ($row != 0) {
                $district['guar_rel'] = $relation_executation->result();
            }


            if($this->ncutility->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
                $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
                redirect(base_url() . "index.php/home");
            }


            // fetch riotee noks -js- 05-09-2022
            if($output->riotee_noks == true){
                $district['riotee_nok'] = $output->riotee_noks;
            }
            // $district['selfDeclarationDetails'] = $output->selfDeclaration;
            foreach($output->selfDeclaration as $selfDec){
                $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            $vlb_encc=[];
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                        $vlb_encc[] = $vlb_encroacher_in_dag;
                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;
            }

            // aadhaar photo api
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getApplicantPhoto");

            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,

            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);


            if($get_aadhaar_photo != 'n'){
                $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            }

            $this->db->trans_begin();

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

                $this->session->set_flashdata('message', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            ///////// additional property starts here
            $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property
            WHERE applid=?", array($application_no));

            if($checkAdditionalProperty->num_rows() == 0){
                if(isset($output->property)) {
                    foreach($output->property as $value) {
                        $add_property = array(
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
                            'service_id'          => NC_KHAS_LAND_ID,
                            'applied_flag'        => CITIZEN,
                            'dist_name'           => trim($value->dist_name),
                            'cir_name'            => trim($value->cir_name),
                            'vill_name'           => trim($value->vill_name),
                            'applid'              => $application_no,
                        );
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }
            ///////// additional property ends here


            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

            //****bhumiputra condition prepare for insertation */
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


            //********settlement_basic insertation */

            $basic=array(
                'dist_code'=>$district['app']->dist_code,
                'subdiv_code'=>$district['app']->subdiv_code,
                'cir_code'=>$district['app']->cir_code,
                'mouza_pargona_code'=>$district['app']->mouza_code,
                'lot_no'=>$district['app']->lot_no,
                'vill_townprt_code'=>$district['app']->village_code,
                'service_code'=>$district['app']->service_code,
                'ref_no'=>$district['app']->ref_no,
                'case_no'=>$case_no['case_no'],
                'trans_code'=>'F',/////////full
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status'=>'Z',
                'user_code'=>$this->session->userdata('user_code'),
                // 'lm_code' => $this->session->userdata('user_code'),
                'submission_date' => date('Y-m-d G:i:s'),
                'from_office' => 'API',
                'pending_officer' => 'LM',
                'pending_office' => 'CO',
                'occupation_applicant'=>$district['applicants'][0]->applicant_occupation,
                'applid'=>$district['app']->application_no,
                'caste'=>$district['applicants'][0]->caste_category,
                'uuid'=> $district['app']->uuid,
                'protected_class' => $protected_class_vr,
                'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                // 'co_code' => $this->input->post('co_code')
                'is_tribal' => ($district['app']->service_applied_for == 'NC_KHAS') ? 0 : 1,
            );

            $insSetBasic = $this->db->insert('settlement_basic', $basic);
            // echo $this->db->last_query(); die();

            if ($insSetBasic != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                $data = array(
                    'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }


            ////settlement_dag_details insert start
            if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') 
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                log_message("error", "#ENCROACHER_DETAIL: ".$district['encroachers']);
                log_message('error', '#ENCROACHER_DETAIL: Insertion failed settlement_dag details '.$this->db->last_query);
                log_message('error', '#ENCROACHER_DETAIL: Application_no '.$application_no);
                log_message('error', '#ENCROACHER_DETAIL: API response '.json_encode($output));

                $data = array(
                    'error'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            foreach ($district['encroachers'] as $dags) {
                $district['class']=$this->ncutility->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

                $enc_home_bigha = $dags->mbigha;
                $enc_home_katha = $dags->mkatha;
                $enc_home_lessa = $dags->mlessa;
                $enc_home_ganda = $dags->mganda;
                $enc_home_kranti = $dags->mkranti;

                $enc_agri_bigha = $dags->agri_bigha;
                $enc_agri_katha = $dags->agri_katha;
                $enc_agri_lessa = $dags->agri_lessa;
                $enc_agri_ganda = $dags->agri_ganda;
                $enc_agri_kranti = $dags->agri_kranti;

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
                    'dist_code'=>$district['app']->dist_code,
                    'subdiv_code'=>$district['app']->subdiv_code,
                    'cir_code'=>$district['app']->cir_code,
                    'mouza_pargona_code'=>$district['app']->mouza_code,
                    'lot_no'=>$district['app']->lot_no,
                    'vill_townprt_code'=>$district['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'new_land_class_code' => $district['class']->land_class_code,
                    'dag_no' => $dags->dag_no,
                    'patta_no' => $dags->patta_no,
                    'patta_type_code' => $dags->patta_code,
                    'is_urban' => $district['app']->is_urban,
                    'land_type' => $dags->land_type,
                    'revenue' => 0,
                    'operation' => 'E',
                    // 'landmark' => json_encode($landmark),
                    'encroachement_area' => json_encode($encroachment_area)
                );

                $fmd['dag_area_b']=$dags->applied_bigha;
                $fmd['dag_area_k']=$dags->applied_katha;
                $fmd['dag_area_lc']=$dags->applied_lessa;
                $fmd['dag_area_g']=$dags->applied_ganda;
                $fmd['dag_area_kr']=$dags->applied_kranti;

                $fmd['home_b']=$dags->mbigha;
                $fmd['home_k']=$dags->mkatha;
                $fmd['home_lc']=$dags->mlessa;
                $fmd['home_g']=$dags->mganda;
                $fmd['home_kr']=$dags->mkranti;

                $fmd['agri_b']=$dags->agri_bigha;
                $fmd['agri_k']=$dags->agri_katha;
                $fmd['agri_lc']=$dags->agri_lessa;
                $fmd['agri_g']=$dags->agri_ganda;
                $fmd['agri_kr']=$dags->agri_kranti;


                //************Total Area Calculation -js- ******************
                if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                    //******for Barak valley */
                    $areaHomeLessa = $this->ncutility->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->ncutility->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->ncutility->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->ncutility->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalAreaLessa);
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
                if ($insSetDag != 1) 
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002_1: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    log_message('error', "#ERRSET0002_2: Insertion failed in settlement_dag_details RTPS Case No $application_no == ".$this->db->last_query());
                    $data = array(
                        'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //*******insertion in settlement_area_history**************
                if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))) {
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->ncutility->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->ncutility->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************


                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->ncutility->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->ncutility->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

                }
                else
                {
                    //********actual Encroachment area**********
                    $actual_encroachment_area_home_lessa = $this->ncutility->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->ncutility->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************

                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->ncutility->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->ncutility->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                }

                $settlementAreaHistoryArr = [
                    'application_no' => $application_no,
                    'case_no' => $case_no['case_no'],
                    'dag_no' => $dags->dag_no,
                    'uuid' => $district['app']->uuid,
                    'created_at' => date('Y-m-d'),
                    'applied_area_home_bigha' => $dags->mbigha,
                    'applied_area_home_katha' => $dags->mkatha,
                    'applied_area_home_lessa' => $dags->mlessa,
                    'applied_area_home_ganda' => $dags->mganda,
                    'applied_area_home_kranti' => $dags->mkranti,
                    'applied_area_agri_bigha' => $dags->agri_bigha,
                    'applied_area_agri_katha' => $dags->agri_katha,
                    'applied_area_agri_lessa' => $dags->agri_lessa,
                    'applied_area_agri_ganda' => $dags->agri_ganda,
                    'applied_area_agri_kranti' => $dags->agri_kranti,
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


            //*******pdar_cron number generation */
            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0){
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }

            //*********settlement_applicant insertion */
            foreach ($district['applicants'] as $setl) {

                if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1') {
                    $timestamp = date('mdYhis', time()).uniqid();
                    $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                    // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                    $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                    $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                    $aadhaar_encoded_file = $get_aadhaar_photo;
                    fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                    fclose($aadhaar_file_to_write_base64);
                }else{
                    $aadhar_path = '';
                }

                if($district['aadhar']->type == 'AADHAAR'){
                    $identity_ref_no = $district['aadhar']->aadhaar_no;
                }else{
                    $identity_ref_no = $district['aadhar']->pan_no;
                }

                $applicant=array(
                    'dist_code'=>$district['app']->dist_code,
                    'subdiv_code'=>$district['app']->subdiv_code,
                    'cir_code'=>$district['app']->cir_code,
                    'mouza_pargona_code'=>$district['app']->mouza_code,
                    'lot_no'=>$district['app']->lot_no,
                    'vill_townprt_code'=>$district['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'operation'=>'E',
                    'dag_no' => 0,
                    'patta_no' => 0,
                    'patta_type_code' => 0,
                    'year_no'=>date('Y'),
                    'date_entry'=>date('Y-m-d'),
                    'pdar_id' => '-1',
                    'pdar_cron_no'=>(int) $cron_no++,
                    'pdar_name' =>$setl->name_ass,
                    'pdar_guardian' =>$setl->gurdian_name_ass,
                    'eng_pdar_name' => $setl->name_eng,
                    'eng_pdar_guardian' => $setl->gurdian_name_eng,
                    'pdar_rel_guar' =>$setl->gurdian_relation_id,
                    'pdar_gender'=>$setl->gender,
                    'pdar_add1' => $setl->pre_add,
                    'pdar_add2' => $setl->per_add,
                    'pdar_mobile' => $setl->mobile,

                    'pdar_type' => $setl->pdar_type,
                    'is_applicant' => $setl->is_applicant,
                    'identity_ref_no' => $identity_ref_no,
                    'identity_type' => $district['aadhar']->type,
                    'identity_doc_link' => $aadhar_path,
                    'marital_status' => $setl->marital_status,
                    'dob' => $setl->dob,
                );

                $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                // echo $this->db->last_query(); die();

                if ($insSetApplicant != 1) {
                    // var_dump($insSetApplicant);
                    // echo $this->db->last_query(); die();
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            //*********encroachers insert in applicant table */
            if($output->encroachers == true){

                foreach($output->encroachers as $enc_applicant){
                    $encroacher_app=array(
                        'dist_code' => $district['app']->dist_code,
                        'subdiv_code' => $district['app']->subdiv_code,
                        'cir_code' => $district['app']->cir_code,
                        'mouza_pargona_code' => $district['app']->mouza_code,
                        'lot_no' => $district['app']->lot_no,
                        'vill_townprt_code' => $district['app']->village_code,

                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',

                        'dag_no' => $enc_applicant->dag_no,
                        'patta_no' => $enc_applicant->patta_no,
                        'patta_type_code' => $enc_applicant->patta_code,
                        'period_possession' => $enc_applicant->possession_date,

                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),

                        'pdar_name' => $enc_applicant->name_ass,
                        'pdar_guardian' => $enc_applicant->gurdian_name_ass,
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no'=> (int) $cron_no++,
                        'pdar_id' => -1,
                        'pdar_type' => 'EN',
                        'enc_id' => $enc_applicant->encroacher_id,
                    );
                    $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                    // echo $this->db->last_query();
                    // var_dump($insSetEncroacher); die;

                    if ($insSetEncroacher != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000309: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET000309: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ///// nominee add start /////
            if ($output->nextKin == true) {
                // foreach ($_POST['kin_name'] as $key =>$value) {
                foreach ($output->nextKin as $nex_of_kin) {
                    $nominee_data=array(
                        'case_no'=> $case_no['case_no'],
                        'nominee_name' => $nex_of_kin->next_of_kin_name,
                        'address' => $nex_of_kin->address,
                        'mobile_no' => $nex_of_kin->mobile_no,
                        'relation' => $nex_of_kin->relation_with_kin
                    );
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                    // echo $this->db->last_query();
                    // var_dump($insSetEncroacher); die();

                    if ($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }
            ///// nominee end //////

            //********basundhar_application insertation */
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }else{
                //
                //
                //******commit if no errors */
                $this->db->trans_commit();
            }

        }

        // ********************case registration from API end********* */
        // ************************************************************************************** */
        //******* case data fetch from db for Lm start */

        $startTime = microtime(true);
        try{
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

            //*****LM view auth for this case */
            // $this->ncutility->lmAuthBasic($case_no);
            $this->ncutility->lmAuthFirstProceeding($case_no);
            //  row_array
            $basic   = $this->NcServiceModel->getSettlementBasic($case_no);
            //  result
            $applicants_buyers = $this->NcServiceModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->NcServiceModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->NcServiceModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->NcServiceModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->NcServiceModel->getSettlementDag($case_no);
            $lmnotes = $this->NcServiceModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->NcServiceModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->NcServiceModel->getDocuments($case_no);
            $nominee = $this->NcServiceModel->getAllNomineeDetail($case_no);

            /// premium
            $lmdata['s_area'] = $this->NcCommonModel->getPremiumArea();
            // new premium addition
            // $lmdata['area_category'] = $this->NcCommonModel->getPremiumCategory();


            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $lmdata['premiumData'] = $premiumData;
            /// premium end

            $lmdata['basic']=$basic;
            $lmdata['geo_date']=$geo_date;
            $lmdata['applicants_buyers']=$applicants_buyers;
            $lmdata['applicants_owners']=$applicants_owners;
            $lmdata['applicants_encroacher']=$applicants_encroacher;
            $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

            $lmdata['reservation'] = $this->NcServiceModel->getSettlementReservation($case_no);


            $lmdata['dags']=$dags;
            $lmdata['lmnotes']=$lmnotes;
            $lmdata['proceedings']=$proceedings;
            $lmdata['dhardocuments']=$dhardocuments;
            $lmdata['nominee']=$nominee;

            //for dag not eligible
            $lmdata['dag_count']=count($dags);

            //for encroacher not eligible
            // $lmdata['dag_count']=count($dags);

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $lmdata['deleted_encroacher'] = $deletedEncArray;

            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->NcCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $lmdata['deleted_dags'] = $deletedData;


            if(isset($applicants_encroacher)):
                foreach($applicants_encroacher as $settl_vlb_add_check):
                    $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($application_no, $settl_vlb_add_check->dag_no, $lmdata['basic']['uuid']));

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

            foreach($applicants_encroacher as $encroacher_prem){
                $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                    . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
                $lmdata['revenue']=$revenue;

            }

            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            $token = $this->ncutility->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
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

            $lmdata['document']=$output->documents;
            $lmdata['query']=$output->query;
            $lmdata['property']=$output->property;
            $lmdata['aadhar']=$output->aadhar;
            $lmdata['nextKin']=$output->nextKin;
            foreach($output->selfDeclaration as $selfDec){
                $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            // var_dump($output);
            // die;

            foreach($lmdata['applicants_buyers'] as $adhar_photo):
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

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();

            if ($row != 0) {
                $lmdata['guar_rel'] = $relation_executation->result();
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
                $lmdata['vlb_newly_added'] = $vlb_newly_added;
            }


            /// additional property for LM note
            $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
            if($additional_property->num_rows() > 0){
                $totallesaa=0;
                $totalganda=0;
                foreach($additional_property->result() as $addprop){
                    if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                        $total_g=$this->ncutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                        $totalganda = $totalganda+$total_g;
                    }else{
                        $total_l=$this->ncutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                        $totallesaa = $totallesaa+$total_l;
                    }

                }
                if(!empty($totallesaa)){
                    $lmdata['total_aditional_area']= $this->ncutility->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $lmdata['total_aditional_area_g']= $this->ncutility->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $lmdata['additional_property']=$additional_property->result();
                //var_dump($lmdata['additional_property']); die;
            }

            $lmdata['case_no'] = $case_no;

            $rejected_data = $this->NcCommonModel->getRejectModal(NC_KHAS_LAND_ID);
            if($rejected_data == 'n')
            {
                $lmdata['rejected_list'] = false;
            }
            else
            {
                $lmdata['rejected_list'] = $rejected_data;
            }

        }
        catch (Exception $e)
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

        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->NcServiceModel->getJsonDataFromBackup($case_no);
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


        //************check if SK is available*/
        $lmdata['sk_name']= $this->NcCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        if($lmdata['sk_name'] == 'n')
        {
            //************if SK is not available then load CO */
            $lmdata['sk_availability'] = 'n';

            $lmdata['co_name']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        }
        else
        {
            $lmdata['sk_availability'] = 'y';
        }

        $lmdata['co_name']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        $lmdata['co_name_reject']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        if($lmdata['rejected_list'] != false)
        {
            $lmdata['dagFlagCheckChitha'] = $this->NcCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);
        }
        else
        {
            $lmdata['dagFlagCheckChitha'] = false;
        }


        $applicantsEncroacherCount = $this->NcServiceModel->countAllApplicantEncroacher($case_no);
        $setEncroacherStatus       = 1;
        if($applicantsEncroacherCount == 0)
        {
            $setEncroacherStatus = 1;
        }
        else
        {
            foreach ($applicants_encroacher as $reza)
            {
                if($reza->nc_encroacher == 1)
                {
                    $setEncroacherStatus = 0;
                }
                else
                {
                    $setEncroacherStatus = 1;
                }
            }
        }


        $lmdata['setEncroacherStatus'] = $setEncroacherStatus;


        // initial khasland view through API
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            // $lmdata['_view'] = 'NcVillageService/NcKhas/NcKhaslandFirstProceedingView';
            $lmdata['_view'] = 'NcVillageService/NcKhas/NcKhasLandView';
            $this->load->view('layouts/main',$lmdata);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            if($setEncroacherStatus != 0)
            {
                $data = array(
                    'error' => 'Please Select Occupier to Process (VLB List)',
                );
                echo json_encode($data);
                return false;
            }


            $caseId = trim($this->input->post('case_no'));
            $sql    = $this->db->query('SELECT dharitree,basundhara FROM basundhar_application WHERE dharitree = ?', array($caseId));

            if($sql->num_rows() > 0)
            {
                $case_no = $sql->row()->dharitree;
                $application_no = $sql->row()->basundhara;
            }
            else
            {
                $data = array(
                    'error' => 'Something went wrong! please contact administration!' .$caseId,
                );
                echo json_encode($data);
                return false;
            }

            $this->ncutility->lmAuthFirstProceeding($case_no);

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$case_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';


            $mStat = false;
            foreach($lmdata['applicants_buyers'] as $applicantRow)
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
            $hasSpouse = false;

            if($mStat == true)
            {
                foreach($lmdata['applicants_buyers'] as $applicantRow)
                {
                    if($applicantRow->is_applicant != 1)
                    {
                        // if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
                        // {
                        //     $mStatErr = true;
                        //     break;
                        // }

                        if ($applicantRow->pdar_rel_guar == '3') {
                            $hasSpouse = true;
                        }
                        if ($applicantRow->pdar_rel_guar == '4') {
                            $hasSpouse = true;
                        }
                        
                        // Early exit if both are found
                        if ($hasSpouse) {
                            break;
                        }
                    }
                }
                if (!$hasSpouse) {
                    $mStatErr = true;
                }
            }
            if($mStatErr == true)
            {
                $data = array(
                    'error' => '#ERR14233: Spouse details has to be added if you select applicant as married!!!' .$case_no,
                );
                echo json_encode($data);
                return false;
            }

            //  row_array
            $basic                 = $this->NcServiceModel->getSettlementBasic($case_no);
            $applicants_buyers     = $this->NcServiceModel->getAllApplicantBuyers($case_no);
            $applicants_owners     = $this->NcServiceModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->NcServiceModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->NcServiceModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->NcServiceModel->getSettlementDag($case_no);
            $lmnotes = $this->NcServiceModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->NcServiceModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->NcServiceModel->getDocuments($case_no);

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];

            /// premium
            $lmdata['co_name']= $this->NcCommonModel->getCoName($d, $s, $c);
            $lmdata['s_area'] = $this->NcCommonModel->getPremiumArea();
            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $lmdata['premiumData'] = $premiumData;
            /// premium end

            $lmdata['basic']                 = $basic;
            $lmdata['geo_date']              = $geo_date;
            $lmdata['applicants_buyers']     = $applicants_buyers;
            $lmdata['applicants_owners']     = $applicants_owners;
            $lmdata['applicants_encroacher'] = $applicants_encroacher;
            $lmdata['applicants_riotee_nok'] = $applicants_riotee_nok;
            $lmdata['reservation']           = $this->NcServiceModel->getSettlementReservation($case_no);
            $lmdata['dags']                  = $dags;
            $lmdata['lmnotes']               = $lmnotes;
            $lmdata['proceedings']           = $proceedings;
            $lmdata['dhardocuments']         = $dhardocuments;


            if($applicants_encroacher == true)
            {
                foreach($applicants_encroacher as $encroacher)
                {

                    $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                        //var_dump($vlb_encroacher_in_dag); die();

                        $vlb_enc_details[] = $vlb_encroacher_in_dag;
                    }else{
                        $lmdata['empty_err'] = "No Land Bank Details found!!";
                    }
                }

                $lmdata['vlb_enc_details'] = $vlb_enc_details;

            }

            foreach($applicants_encroacher as $encroacher_prem){
                $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                    . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
                $lmdata['revenue']=$revenue;

            }

            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();

            $token = $this->ncutility->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
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
                        $open_adhar_file  = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                        $read_adhar_file  = fread($open_adhar_file, filesize($adhar_photo_link));
                        fclose($open_adhar_file);
                        // decoding the base64 encoding file variable

                        $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";

                    endif;
                endif;
            endforeach;


            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $lmdata['guar_rel'] = $relation_executation->result();
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
                $lmdata['vlb_newly_added'] = $vlb_newly_added;
            }

            $lmdata['case_no'] = $case_no;


            // For insertion of settlement khasland 
            $distCode = trim($this->input->post('dist_code'));
            if ($distCode == null) {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }
            if ($application_no == null) {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                {

                    $validation_bypass_array = $this->getValidationBypass(NC_KHAS_LAND_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    {

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
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
                foreach($lmdata['dags'] as $geo_tag)
                {
                    $geo_tag_dags[] = $geo_tag->dag_no;
                }

                $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";

                $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                $total_dag_count = count($lmdata['dags']);

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
                $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
                $this->form_validation->set_rules('caste_verified', 'Caste Verified', 'trim|required');
                $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
                if(trim($this->input->post('is_tribal_belt') == 'YES')){
                    $this->form_validation->set_rules('tribal_belt_name', 'Tribal Belt Name', 'trim|required');
                    $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
                }

                $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
                $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');

                // $this->form_validation->set_rules('encroacher_exist_vlb', 'Is Encroacher Exists in VLB ?', 'trim|required');

                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                // $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', 'Whether application is landless', 'trim|required');
                $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
                $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
                $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');
                // $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
                //$this->form_validation->set_rules('field_report', 'Field Report', 'trim|required');
                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
                $this->form_validation->set_rules('roadside_reservation','','');
                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');


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

                foreach ($lmdata['dags'] as $dag_area_cal) {

                    //******NCBTAD check  */
                    $ncBtadCheck = $this->NcCommonModel->ncBtadCheckWithK($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

                    if(NC_BTAD_CHECK_STATUS == 1)
                    {
                        if($ncBtadCheck != 1)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }
                    }

                    $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');

                    if($this->input->post('nature_possession'.$dag_area_cal->dag_no) == 'Others'){
                        $this->form_validation->set_rules('nature_possession_other'.$dag_area_cal->dag_no, 'Nature of possesion', 'required');
                    }
                    // new premium addition
                    // $this->form_validation->set_rules('area'.$dag_area_cal->dag_no, 'Select Area Type', 'trim|required');
                    $this->form_validation->set_rules('area_new'.$dag_area_cal->dag_no, 'Select Area Type', 'trim|required');
                    // for barak valley
                    if (in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        if (empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
                        {
                            $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
                        }

                        $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');


                        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);
                        $gandaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fganda'.$dag_area_cal->dag_no), 0);

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

                            $bighaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                            $kathaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                            $lessaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                            $gandaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                        if ($family_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda_family'.$dag_area_cal->dag_no, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti_family'.$dag_area_cal->dag_no, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                            $kathaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                            $lessaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
                            $gandaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation) {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
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

                        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);

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

                        if ($roadside_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                            $kathaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                            $lessaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }

                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                        if ($family_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                            $kathaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                            $lessaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                            {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                        {
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                        $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        else
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }
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
                        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);
                        $gandaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->ganda, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }
                else
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }

                $checkUrbanCon = trim($this->input->post('is_urban'));

                if ($reserveMoreThanAppArea == 1) {
                    $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
                }

                if ($familyMoreThanAppArea == 1) {

                    $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');

                }

                if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation + $totalFishAreaLessaValidation == 0) {
                    $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
                }

//                if ($appAreaMoreThanDagA == 1) {
//
//                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area (MR001REZA) !', 'required|callback_appAreaMoreThanDagA');
//                }


                $land_exceed =0;
                // for barak valley
                if (in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    if (NC_KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');
                    }
                    if (NC_KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                        $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');
                    }

                    if((NC_KHAS_MAX_HOMESTEAD + NC_KHAS_MAX_AGRICULTURE) * 6400 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed =1;
                    }

                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                        $maxland_ganda ='';
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

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


                    if($checkUrbanCon == 'Y')
                    {
                        // if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation)
                        // {
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //         MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        // }


                        // new premium addition
                        //  $maxland_ganda ='';
                        if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                            if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                                $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

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

                }
                else
                {
                    if (NC_KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');

                    }
                    if (NC_KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');

                    }
                    if((NC_KHAS_MAX_HOMESTEAD + NC_KHAS_MAX_AGRICULTURE) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed =1;
                    }

                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10)
                    {
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no)))
                        {
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                                {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                                        $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        else
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                                $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }

                    if($checkUrbanCon == 'Y')
                    {
                        // if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        // {
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //         MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        // }

                        // new premium addition
                        if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                            if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                                $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                                if(!empty($maxland_check->max_land)){

                                    if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                        $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                                            $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                    }

                                }

                            }else{
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }
                        }
                    }
                }

                if($_POST['lm_note'] == '1' && $land_exceed == 1)
                {
                    $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                }

                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_katha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa','','');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda','','');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti','','');

                // for total applied area set_value in validation error Agriculture
                $this->form_validation->set_rules('total_applied_area_agricultural_bigha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_katha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_lessa','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_ganda','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_kranti','','');

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

            if ($this->form_validation->run() == false)
            {

                $lmdata['all_errors'] = validation_errors();
                if(isset($fileCount)){
                    $lmdata['fileCount'] = $fileCount;
                }
                $lmdata['err_return'] = true;
                $lmdata['_view'] = 'NcVillageService/NcKhas/NcKhasLandView';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {

                $this->db->trans_begin();

                //************update in settlement_applicant */

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

                //new premium condition

                foreach ($lmdata['dags'] as $dag_for_approve) {
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
                // if(trim($lmdata['sk_availability']) == 'y')
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
                if (isset($lmdata['geo_tag_doc'])) {
                    foreach ($lmdata['geo_tag_doc'] as $geo_tag_loop) {
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
                    foreach ($lmdata['dags'] as $dagsland) {
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
                            'nature_possession'=>$this->input->post('nature_possession'.$dagsland->dag_no),
                            'nature_of_possession_other' => ($this->input->post('nature_possession'. $dagsland->dag_no) == 'Others') ? $this->input->post('nature_possession_other'. $dagsland->dag_no) : null,
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
                                    'mut_type'   => NC_KHAS_LAND_ID,
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
                    foreach ($lmdata['dags'] as $dags_doc)
                    {
                        $timestamp = date('mdYhis', time()).uniqid();

                        $trace_map_file = $_FILES['trace_map_copy'.$dags_doc->dag_no];
                        $trace_file_name = 'trace_map_copy'.$timestamp;

                        //upload trace map file by calling API
                        $trace_map_api_file = $this->NcCommonModel->uploadFileByApiBase($trace_map_file, $application_no, API_KEY, $trace_file_name);

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


                    $field_report_api_file = $this->NcCommonModel->uploadFileByApiBase($field_report_file, $application_no, API_KEY, $field_file_name);

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

                    $responseMasterObj = $this->NcCommonModel->lmRejectedValidationBypassFalse(NC_KHAS_LAND_ID);


                    $comment = addslashes($this->input->post('lm_note'));

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

                    $lmnote=array(
                        'user_code'=>$this->session->userdata('user_code'),
                        'chitha_verified'=>$this->input->post('chitha_verified'),
                        'vlb_verified'=>$this->input->post('vlb_verified'),
                        'caste_verified'=>$this->input->post('caste_verified'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'tribal_belt_name' => ($this->input->post('is_tribal_belt') == 'YES') ? $this->input->post('tribal_belt_name') :null,
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
                        'protected_class_lm' => ($this->input->post('is_tribal_belt') == 'YES') ? $protected_class_lm :null,
                        'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );

//                    dd($lmnote);

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
                    $this->NcCommonModel->firstProceedingValidationBypassTrue(
                        NC_KHAS_LAND_ID,
                        $case_no,
                        $application_no,
                        $lmdata['rejected_list']
                    );
                }

                //******do if only validation_bypass 0 */
                if($validation_bypass == 0)
                {
                    ///// road side reserve area start /////
                    if ($roadside_comment_check=='YES') {
                        foreach ($lmdata['dags'] as $dags) {
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
                        foreach ($lmdata['dags'] as $dags) {
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
                    $sumMbAmount=0;
                    $approved_by ='';
                    $count =0;
                    foreach ($lmdata['dags'] as $dag_premium)
                    {
                        $count++;
                        if($count >1){
                            if ($approved_by != $this->input->post('approval'.$dag_premium->dag_no))
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error #ERRAM000199: Settlement Application not submitted case no # $application_no");
                                log_message('error', '#ERRAM000199: Multiple User Approval, RTPS Case No '.$application_no);
                                redirect(base_url() . "index.php/home");
                            }

                        }

                        // premium verify start ******************
                        if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                            $area_in_bigha=6400;
                        }else{
                            $area_in_bigha=100;
                        }
                        $concession_rate=25;
                        $ratetype=$this->input->post('rate_type'.$dag_premium->dag_no);
                        $ratepr2=$this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                        $ratepr = $ratepr2->rate_type;
                        // var_dump($ratepr->rate_type); die;
                        $is_full_pay=$this->input->post('paymode');
                        // $prem_zonal=$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no);
                        $prem_zonal = $this->ncutility->getZonalValue($dag_premium->dist_code,$basic['uuid'],$dag_premium->dag_no);
                        $prem_area = $this->input->post('total_lessa'.$dag_premium->dag_no);
                        $prem_rate = $this->input->post('rate'.$dag_premium->dag_no);
                        $prem_concession =$this->input->post('concession'.$dag_premium->dag_no);
                        $mb_land =$this->input->post('mb_land'.$dag_premium->dag_no);

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
                                    $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                    $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    $amount1 = ceil($premium * $discount / 100);

                                    $access_area = $prem_area - $mb_land;
                                    $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                                    $amount2 = ceil($premium2 * $discount / 100);

                                    // $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    // $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    // $amount = ($premium * $discount / 100);
                                    // $finalamount = ceil($amount);
                                    $finalamount = ceil($amount1 + $amount2);
                                }else{
                                    $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                    $amount = ($premium * $discount / 100);
                                    // $finalamount = round($amount,2);
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
                                    $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                    $amount1 = ceil($premium * $prem_rate / 100);

                                    $access_area = $prem_area - $mb_land;
                                    $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                    $amount2 = ceil($premium2 * $prem_rate / 100);

                                    $finalamount = ceil($amount1 + $amount2);

                                }else{
                                    $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                    $amount = ($premium * $prem_rate / 100);
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

                        $fmd=array(
                            'case_no'=>$case_no,
                            'user_code'=>$this->session->userdata('user_code'),
                            'uuid'=>$basic['uuid'],
                            'dag_no'=>$dag_premium->dag_no,
                            'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                            'area_name'=>$this->input->post('area_new'.$dag_premium->dag_no),
                            'land_type'=>$this->input->post('land_type'.$dag_premium->dag_no),
                            'rate_type'=>$this->input->post('rate_type'.$dag_premium->dag_no),
                            'rate'=>$this->input->post('rate'.$dag_premium->dag_no),
                            'concession'=>$this->input->post('concession'.$dag_premium->dag_no),
                            'amount_dag'=>$this->input->post('amount'.$dag_premium->dag_no),
                            'final_amount'=>$this->input->post('finalamount'),
                            'due_amount'=>$this->input->post('totaldue'),
                            'total_lessa'=>$this->input->post('total_lessa'.$dag_premium->dag_no),
                            'is_full_pay'=>$this->input->post('paymode'),
                            'is_final'=>1,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'approve_by'=>$this->input->post('approval'.$dag_premium->dag_no),

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

                        $approved_by = $this->input->post('approval'.$dag_premium->dag_no);
                    } // foreach end

                    // premium verify 2 start ******************

                    if((float)$sumMbAmount != (float)$this->input->post('finalamount')){
                        // var_dump("Amount mismatch!!!"); die;
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0001: Settlement Application not submitted case no # $application_no");
                        log_message('error', '#ERRAM0001: Premium ghotala by LM, RTPS Case No '.$application_no);
                        redirect(base_url() . "index.php/home");
                    }
                    if ($is_full_pay=="NO"){
                        $discount = 30;
                        $finaldue = ($sumMbAmount * $discount / 100);
                        // $finaldueamount = round($finaldue,2);
                        $finaldueamount = ceil($finaldue);
                    }else if ($is_full_pay=="YES"){
                        $finaldueamount= $sumMbAmount;
                    }

                    if($finaldueamount != $this->input->post('totaldue')){
                        // var_dump("Due Amount mismatch!!!");
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAM0002: Settlement Application not submitted case no # $case_no");
                        log_message('error', '#ERRAM0002: Premium ghotala by LM, RTPS Case No '.$application_no);
                        redirect(base_url() . "index.php/home");
                    }
                    // premium verify 2 end ******************
                }

                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id==null)
                {
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

                ////settlement Khas LM Report insert end

                if ($this->db->trans_status()==false)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to '.$pending_officer;
                    $status='M';
                    $task='LM';
                    $pen='CO';
                    // $pen=$pending_officer;
                    $case=$case_no;
                    $rtps_status=$this->NcApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status=json_decode($rtps_status);
                    if (trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to ".$pending_officer." With Case No # ".$case_no);
                    redirect(base_url() . "index.php/home");
                }

            }

        }

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

    // In case of Revert back from Circle officer CO
    public function secondProceeding()
    {
        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();
        $distCode = $this->session->userdata('dist_code');

        $this->dbswitch11($distCode);

        $application_no = $this->input->get('case');
        $application_no = $this->ncutility->decryptJwtCase($application_no);

        $this->ncutility->lmAuthBasic($application_no);

        $basic = $this->NcServiceModel->getSettlementBasic($application_no);

        if(trim($this->ncutility->checkIfAlreadyUpdatedByLm($application_no)) != 'y'){
            $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
            redirect(base_url() . "index.php/home");
        }


        $applicants_buyers = $this->NcServiceModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->NcServiceModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->NcServiceModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok = $this->NcServiceModel->getAllApplicantRioteeNok($application_no);

        $nominee = $this->NcServiceModel->getAllNomineeDetail($application_no);

        $dags = $this->NcServiceModel->getSettlementDag($application_no);
        $lmnotes = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->NcServiceModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->NcServiceModel->getDocuments($application_no);
        // var_dump($applicants_buyers); die;

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

        $lmdata['application_no'] = $applid = $this->ncutility->getApplidFromCaseNo($application_no);

        $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$applid'");

        if($additional_property->num_rows() > 0){
            $totallesaa=0;
            $totalganda=0;
            foreach($additional_property->result() as $addprop){
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                    $total_g=$this->ncutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }else{
                    $total_l=$this->ncutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }

            }
            if(!empty($totallesaa)){
                $lmdata['total_aditional_area']= $this->ncutility->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda)){
                $lmdata['total_aditional_area_g']= $this->ncutility->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $lmdata['additional_property']=$additional_property->result();
            // var_dump($lmdata['total_aditional_area_g']); die;
        }

        /// premium
        $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
        $lmdata['s_area'] = $s_area;

        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$application_no' and is_final=1")->row();
        $lmdata['premiumData'] = $premiumData;
        // $lmdata['area_category'] = $this->NcCommonModel->getPremiumCategory();
        /// premium end

        $lmdata['basic'] = $basic;
        $lmdata['geo_date'] = $geo_date;

        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;
        $lmdata['applicants_riotee_nok'] = $applicants_riotee_nok;
        $lmdata['nominee']=$nominee;

        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
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

        $d = $basic["dist_code"];
        $s = $basic["subdiv_code"];
        $c = $basic["cir_code"];
        $m = $basic["mouza_pargona_code"];
        $l = $basic["lot_no"];
        $v = $basic["vill_townprt_code"];

        if($applicants_encroacher == true){
            foreach($applicants_encroacher as $encroacher){

                $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                $district['vlb_enc'] = $vlb_encroacher;

                if($vlb_encroacher == true){
                    // getting the encroacher details

                    $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                    //var_dump($vlb_encroacher_in_dag); die();

                    $vlb_encc[] = $vlb_encroacher_in_dag;
                }else{
                    $lmdata['empty_err'] = "No Land Bank Details found!!";
                }
            }
            $lmdata['vlb_enc_details']=$vlb_encc;
        }

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

        $display_old_nature_revert=0;
        foreach ($dags as $dag_nature_check) {
            if (!is_null($dag_nature_check->nature_possession)){
                $display_old_nature_revert=1;

            }else{
                $display_old_nature_revert=0;
            }
        }

        $lmdata['display_old_nature_revert']=$display_old_nature_revert;

        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_NC."serviceResponse?application_no=" . $application_no ;
        $token = $this->ncutility->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
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
        $lmdata['reservation'] = $this->NcServiceModel->getSettlementReservation($application_no);
        $lmdata['document'] = $output->documents;
        $lmdata['query'] = $output->query;
        $lmdata['property'] = $output->property;
        $lmdata['aadhar'] = $output->aadhar;
        // $lmdata['nextKin'] = $output->nextKin;
        foreach ($output->selfDeclaration as $selfDec) {
            $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        // var_dump($output);
        // die;

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $applid_vlb = $this->ncutility->getApplidFromCaseNo($application_no);
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

        foreach($applicants_encroacher as $encroacher_prem){
            $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
            $lmdata['revenue']=$revenue;

        }

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
            $lmdata['vlb_newly_added'] = $vlb_newly_added;
        }
        $lmdata['sk_name']= $this->NcCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        if($lmdata['sk_name'] == 'n')
        {
            //************if SK is not available then load CO */
            $lmdata['sk_availability'] = 'n';

            $lmdata['co_name']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        }
        else
        {
            $lmdata['sk_availability'] = 'y';
        }

        $lmdata['co_name']= $this->NcCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        /// premium
        $lmdata['s_area'] = $this->NcCommonModel->getPremiumArea();

        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$application_no' and is_final=1")->row();
        $lmdata['premiumData'] = $premiumData;
        /// premium end


        //get data from settlement_ap_lmnote
        $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
            case_no='$application_no'")->row()->is_landless;
        $lmdata['apLmNote'] = $apLmNote;

        $rejected_data = $this->NcCommonModel->getRejectModal(NC_KHAS_LAND_ID);

        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }

        $sqlToCheckPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($application_no));
        if($sqlToCheckPremium->num_rows() <= 0)
        {
            $lmdata['premium_not_calculated'] = 1;
        }
        else
        {
            $lmdata['premium_not_calculated'] = 0;
        }

        // $lmdata['dagFlagCheckChitha'] = $this->NcCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);

        if($lmdata['rejected_list'] != false)
        {
            $lmdata['dagFlagCheckChitha'] = $this->NcCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);
        }
        else
        {
            $lmdata['dagFlagCheckChitha'] = false;
        }

        $lmdata['enc_case']= null;
        if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
        {
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



//        dd($lmdata);


        //**************-js- if request_method not an update */
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $lmdata['_view'] = 'NcVillageService/NcKhas/NcKhaslandSecondProceedingView';
            $this->load->view('layouts/main', $lmdata);
        }

        //*******-js- request_method for update */
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // if(isset($_POST['submit']) && $_POST['submit']='ekyc_data' && ENABLE_MODIFY_MAIN_APPLICANT == 1)
            // {
            //     $distCode = $this->input->post('dist_code');
            //     $case_no  = $this->input->post('case_no');

            //     $auth_res       = $this->input->post('response');
            //     $originalString = str_replace("@","/",$auth_res);
            //     $auth_aes       = new AES($originalString, ENCRYPTION_KEY);
            //     $auth_decrypt   = $auth_aes->decrypt();
            //     $auth_decrypt   = json_decode($auth_decrypt);

            //     $lmdata['auth_response'] = $auth_decrypt;
            //     $lmdata['response']      = $auth_res;
            //     $lmdata['ekyc_data']     = 'ekyc_data';
            //     $lmdata['case_no']       = $case_no;

            //     $this->dbswitch11($distCode);
            // }
            // else
            // {
            //     $case_no = $this->input->post('case_no');
            //     $distCode = trim($this->input->post('dist_code'));
            // }

            $case_no = $this->input->post('case_no');
            $distCode = trim($this->input->post('dist_code'));

            $mStat = false;
            foreach($lmdata['applicants_buyers'] as $applicantRow)
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
            $hasSpouse = false;

            if($mStat == true)
            {
                foreach($lmdata['applicants_buyers'] as $applicantRow)
                {
                    if($applicantRow->is_applicant != 1)
                    {
                        // if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
                        // {
                        //     $mStatErr = true;
                        //     break;
                        // }

                        if ($applicantRow->pdar_rel_guar == '3') {
                            $hasSpouse = true;
                        }
                        if ($applicantRow->pdar_rel_guar == '4') {
                            $hasSpouse = true;
                        }
                        
                        // Early exit if both are found
                        if ($hasSpouse) {
                            break;
                        }
                    }
                }
                if (!$hasSpouse) {
                    $mStatErr = true;
                }
            }
            if($mStatErr == true)
            {
                $data = array(
                    'error' => '#ERR14233: Spouse details has to be added if you select applicant as married!!!' .$case_no,
                );
                echo json_encode($data);
                return false;
            }

            $application_no = $this->ncutility->getApplidFromCaseNo($case_no);

            $is_prem_update = $this->input->post('prem_update');
            if($distCode == NULL)
            {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }
            if($case_no == NULL)
            {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }
            $this->load->library('form_validation');
            //  row_array
            $basic   = $this->NcServiceModel->getSettlementBasic($case_no);

            //  result
            $applicants_buyers = $this->NcServiceModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->NcServiceModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->NcServiceModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->NcServiceModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->NcServiceModel->getSettlementDag($case_no);
            $lmnotes = $this->NcServiceModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->NcServiceModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->NcServiceModel->getDocuments($case_no);

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];

            /// premium
            $lmdata['co_name']= $this->NcCommonModel->getCoName($d, $s, $c);
            $lmdata['s_area'] = $this->NcCommonModel->getPremiumArea();

            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $lmdata['premiumData'] = $premiumData;
            /// premium end

            $lmdata['basic']=$basic;
            $lmdata['geo_date']=$geo_date;
            $lmdata['applicants_buyers']=$applicants_buyers;
            $lmdata['applicants_owners']=$applicants_owners;
            $lmdata['applicants_encroacher']=$applicants_encroacher;
            $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

            $reservation = $this->NcServiceModel->getSettlementReservation($case_no);
            $lmdata['reservation'] = $reservation;

            $lmdata['dags']=$dags;
            $lmdata['lmnotes']=$lmnotes;
            $lmdata['proceedings']=$proceedings;
            $lmdata['dhardocuments']=$dhardocuments;


            if($applicants_encroacher == true){
                foreach($applicants_encroacher as $encroacher){

                    $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                        //var_dump($vlb_encroacher_in_dag); die();

                        $vlb_enc_details[] = $vlb_encroacher_in_dag;
                    }else{
                        $lmdata['empty_err'] = "No Land Bank Details found!!";
                    }
                }

                $lmdata['vlb_enc_details'] = $vlb_enc_details;

            }

            foreach($applicants_encroacher as $encroacher_prem){
                $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                    . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
                $lmdata['revenue']=$revenue;

            }

            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();

            $token = $this->ncutility->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
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

                        $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                        fclose($open_adhar_file);
                        // decoding the base64 encoding file variable

                        $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";

                    endif;
                endif;
            endforeach;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $lmdata['guar_rel'] = $relation_executation->result();
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
                $lmdata['vlb_newly_added'] = $vlb_newly_added;
            }

            $lmdata['case_no'] = $case_no;

            // For insertion of settlement khasland
            $distCode = trim($this->input->post('dist_code'));
            if ($distCode == null) {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }
            if ($application_no == null) {
                redirect(base_url(). 'index.php/NcVillageHomeController/ncCases');
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            //********validation bypass */
            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                {

                    $validation_bypass_array = $this->getValidationBypass(NC_KHAS_LAND_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    {

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
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
                $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
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
                $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
                $this->form_validation->set_rules('caste_verified', 'Caste Verified', 'trim|required');
                // $this->form_validation->set_rules('encroacher_exist_vlb', 'Is Encroacher Exists in VLB ?', 'trim|required');
                $this->form_validation->set_rules('bhumiputra_confirmation', 'Bhumiputra Verified', 'trim|required');
                $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
                $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');

                if(trim($this->input->post('is_tribal_belt') == 'YES')){
                    $this->form_validation->set_rules('tribal_belt_name', 'Tribal Belt Name', 'trim|required');
                    $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
                }

                $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
                $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');
                // $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
                $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
                $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');

                $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
                // $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
                $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                $this->form_validation->set_rules('roadside_reservation','','');
                $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

                $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
                $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
                $this->form_validation->set_rules('prem_update', 'Do you want to chnage the premium', 'trim|required');
                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                if($is_prem_update=='YES'){
                    $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                    $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
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

                //***********check for tracemap copy in supportive_document */

                // $supportive_doc = $this->db->query("SELECT * FROM supportive_document WHERE case_no = ? AND file_name = ?", array($case_no, 'Trace Map Copy'))->result();

                // $traceMapSupportiveCount = count($supportive_doc);
                // $dagsCount = count($dags);

                // if($traceMapSupportiveCount != $dagsCount)
                // {
                //     $this->form_validation->set_rules('trance_map_copy_needed', '(Please insert tracemap copy using additional document)', 'required');
                // }

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


                $display_old_nature_check=0;
                foreach ($lmdata['dags'] as $dag_area_cal) {


                    //******NCBTAD check  */
                    $ncBtadCheck = $this->NcCommonModel->ncBtadCheckWithK($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

                    if(NC_BTAD_CHECK_STATUS == 1)
                    {
                        if($ncBtadCheck != 1)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }
                    }


                    $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');

                    if (!is_null($dag_area_cal->nature_possession)){
                        $display_old_nature_check=0;

                    }else{
                        $display_old_nature_check=1;

                    }

                    if($this->input->post('nature_possession'.$dag_area_cal->dag_no) == 'Others'){
                        $this->form_validation->set_rules('nature_possession_other'.$dag_area_cal->dag_no, 'Nature of possesion', 'required');
                    }

                    // for barak valley
                    if (in_array($distCode, json_decode(BARAK_VALLEY))) {

                        $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');


                        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);
                        $gandaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_g'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);
                        $gandaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fganda'.$dag_area_cal->dag_no), 0);

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

                            $bighaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                            $kathaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                            $lessaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                            $gandaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                        if ($family_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda_family'.$dag_area_cal->dag_no, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti_family'.$dag_area_cal->dag_no, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                            $kathaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                            $lessaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
                            $gandaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation) {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                        }
                    }
                    else
                    {

                        $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');


                        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('home_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_b'.$dag_area_cal->dag_no), 0);
                        $kathaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_k'.$dag_area_cal->dag_no), 0);
                        $lessaValidationAgr = $this->NcCommonModel->defaultValue($this->input->post('agri_lc'.$dag_area_cal->dag_no), 0);

                        $bighaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fbigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('fkatha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFish = $this->NcCommonModel->defaultValue($this->input->post('flessa'.$dag_area_cal->dag_no), 0);

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

                        if ($roadside_comment_check=='YES') {

                            $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                            $kathaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                            $lessaValidationRoadside = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }

                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }

                        if ($family_comment_check=='YES') {
                            $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
                            $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                            $kathaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                            $lessaValidationFamily = $this->NcCommonModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation) {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                        }
                    }
                }



                // if ($display_old_nature_check == 1){
                //     $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                // }

                // new additional property calculation
                $singleAdditionalProToLessa = 0;
                $totalAdditionalProToLessa = 0;
                $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();

                if(in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);
                        $gandaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->ganda, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }
                else
                {
                    foreach ($additional_properties as $singleProperty)
                    {
                        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
                        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
                        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);

                        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                    }
                }

                $checkUrbanCon = trim($this->input->post('is_urban'));

                if ($reserveMoreThanAppArea == 1) {
                    $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
                }

                if ($familyMoreThanAppArea == 1) {

                    $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');

                }

                if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation + $totalFishAreaLessaValidation == 0) {
                    $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
                }

                if ($appAreaMoreThanDagA == 1) {

                    $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area  (MR002REZA) !', 'required|callback_appAreaMoreThanDagA');

                }

                $land_exceed =0;
                // for barak valley
                if (in_array($distCode, json_decode(BARAK_VALLEY)))
                {
                    if (KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');
                    }
                    if (KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                        $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');
                    }
                    if (FISHERY_MAX_AREA * 6400 < $totalFishAreaLessaValidation) {
                        $this->form_validation->set_rules('khasMaxFishery','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !', 'required|callback_khasMaxFishery');
                    }
                    if((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 6400 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed =1;
                    }

                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                        $maxland_ganda ='';
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

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

                    if($checkUrbanCon == 'Y')
                    {
                        // if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) -  $totalRoadSideAreaLessaValidation)
                        // {
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //         MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        // }
                        // new premium addition
                        if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                            $maxland_ganda ='';
                            if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                                $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

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

                }
                else
                {
                    if (KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');

                    }
                    if (KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxAgriculture','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !', 'required|callback_khasMaxAgriculture');

                    }
                    if (FISHERY_MAX_AREA * 100 < $totalFishAreaLessaValidation) {

                        $this->form_validation->set_rules('khasMaxFishery','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !', 'required|callback_khasMaxFishery');

                    }
                    if((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa))
                    {
                        // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                        $land_exceed =1;
                    }

                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
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

                    if($checkUrbanCon == 'Y')
                    {
                        // if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation) - $totalRoadSideAreaLessaValidation)
                        // {
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //         MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        // }

                        // new premium addition
                        if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                            if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                                $maxland_check = $this->NcCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
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
                }

                if($_POST['lm_note'] == '1' && $land_exceed == 1)
                {
                    $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                }

                // for total applied area set_value in validation error Homestead
                $this->form_validation->set_rules('total_applied_area_homestead_bigha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_katha','','');
                $this->form_validation->set_rules('total_applied_area_homestead_lessa','','');
                $this->form_validation->set_rules('total_applied_area_homestead_ganda','','');
                $this->form_validation->set_rules('total_applied_area_homestead_kranti','','');

                // for total applied area set_value in validation error Agriculture
                $this->form_validation->set_rules('total_applied_area_agricultural_bigha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_katha','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_lessa','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_ganda','','');
                $this->form_validation->set_rules('total_applied_area_agricultural_kranti','','');

                // additional file upload validation
                // upload additional files
                if(isset($_FILES['fileUpload']['name'])){
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size

                    for($i = 0; $i < $fileCount; $i++)
                    {
                        if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i])
                        {

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

                        if(isset($_FILES['nrc_file_upload']) && $_FILES['nrc_file_upload'.$i]['name'] && $_FILES['nrc_file_upload'.$i]['size'] && $_FILES['nrc_file_upload'.$i]['tmp_name'])
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








                //**********This is for dag Eligible after dag deleted by LM or Reinsert dag in second proceeding */
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


            if ($this->form_validation->run() == FALSE)
            {
                $lmdata['all_errors'] = validation_errors();
                if(isset($fileCount)){
                    $lmdata['fileCount'] = $fileCount;
                }
                $lmdata['err_return'] = true;
                $lmdata['_view'] = 'NcVillageService/NcKhas/NcKhaslandSecondProceedingView';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {
                /////////////////////
                // if($lmdata['sk_availability'] == 'y')
                // {
                //     $pending_officer = 'SK';
                // }
                // else
                // {
                //     $pending_officer = 'CO';
                // }

                $pending_officer = 'CO';

                if($validation_bypass == 1)
                {
                    $pending_officer = 'CO';
                }

                $this->db->trans_begin();

                // insertion in backup table

                $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'LM'")->row()->ct;

                $applid_backup = $this->ncutility->getApplidFromCaseNo($case_no);

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

                    $this->session->set_flashdata('message', "#BACKUP0032: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }


                //************update in settlement_applicant */
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
                            log_message('error', '#ERROR90112: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERROR90112: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }


                //new premium condition

                foreach ($lmdata['dags'] as $dag_for_approve) {
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


                $sql1 = "SELECT petition_no FROM settlement_basic WHERE case_no = '$case_no'";
                $result1 = $this->db->query($sql1);
                if($result1->num_rows() > 0)
                {
                    $petition_no = (int)$result1->row()->petition_no;
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '$case_no'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0)
                {
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $basic = array(
                    'date_update' => date('Y-m-d G:i:s'),
                    'status' => 'X',
                    'user_code' => $this->session->userdata('user_code'),
                    'lm_code' => $this->session->userdata('user_code'),
                    'co_code' => $this->input->post('co_code'),
                    //'period_possession' => $this->input->post('period_possession'),
                    'occupation_applicant' => $this->input->post('occupation_applicant'),
                    'from_office' => 'LM',
                    'pending_officer' => $pending_officer,
                    'pending_office' => $pending_officer,
                    'approve_by' => $approved_by

                    /////////
                );

                if ($is_prem_update=='NO'){
                    unset($basic['approve_by']);
                }

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

                //*******to bypass 1 */
                if($validation_bypass == 0)
                {

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
                        $service_code = NC_KHAS_LAND_ID;

                        $nrcFilesUploadStatus = $this->SettlementNRCFileUploadModel->uploadNrcFiles($case_no,$nrcDesc,$nrcFileArray,$nrcFileName,$service_code);
                        if($nrcFilesUploadStatus['responseType'] == 1)
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "#ERRNRCDOC0001: Registration of Settlement failed for case no : ".$case_no);
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
                                    'mut_type'   => NC_KHAS_LAND_ID,
                                );

                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);

                                    $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }

                            }
                            else
                            {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);

                                $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }

                    //end of additional file upload

                    $nature_entry_single = null;
                    $nature_entry_multiple = null;


                    foreach ($lmdata['dags'] as $dags_landmark) {


                        if ($display_old_nature_check == 1){
                            // $nature_entry_single= $this->input->post('nature_possession');
                            $nature_entry_single= null;
                            $nature_entry_multiple = $this->input->post('nature_possession'.$dags_landmark->dag_no);
                        }else{
                            $nature_entry_multiple = $this->input->post('nature_possession'.$dags_landmark->dag_no);
                        }

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
                            'nature_possession'=>$nature_entry_multiple,
                            'nature_of_possession_other' => ($this->input->post('nature_possession'. $dags_landmark->dag_no) == 'Others') ? $this->input->post('nature_possession_other'. $dags_landmark->dag_no) : null,
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

                    //*********if LM if case of case rejected the rejected remarks */
                    $responseMasterObj = $this->NcCommonModel->lmRejectedValidationBypassFalse(NC_KHAS_LAND_ID);

                    $comment = addslashes($this->input->post('lm_note'));

                    $pro_class_lm = $this->input->post('protected_class_lm');
                    $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');



                    $lmnote=array(
                        'chitha_verified'=>$this->input->post('chitha_verified'),
                        'vlb_verified'=>$this->input->post('vlb_verified'),
                        'caste_verified'=>$this->input->post('caste_verified'),
                        'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                        'tribal_belt_name' => ($this->input->post('is_tribal_belt') == 'YES') ? $this->input->post('tribal_belt_name') :null,
                        'possession_verification'=>$this->input->post('possession_verification'),
                        'period_possession'=>date('Y-m-d'),
                        // 'nature_possession'=>$this->input->post('nature_possession'),
                        'nature_possession'=>$nature_entry_single,
                        'is_landless'=>$this->input->post('is_landless'),
                        'land_falls'=>$this->input->post('land_falls'),
                        'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                        'roadside_reservation'=>$this->input->post('roadside_reservation'),
                        'trace_map_copy'=>'NA',
                        'chitha_copy'=>'NA',
                        'lm_note'=>$comment,
                        'lm_remark_text'=>$this->input->post('lm_remark_text'),
                        'date_update'=>date('Y-m-d h:i:s'),
                        'case_no'=>$case_no,
                        'status'=>'W',
                        'total_bigha'=>$this->input->post('total_bigha'),
                        'total_Katha'=>$this->input->post('total_Katha'),
                        'total_lessa'=>$this->input->post('total_lessa'),
                        'total_ganda'=>$this->input->post('total_ganda'),
                        'total_kranti'=>$this->input->post('total_kranti'),
                        'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                        'landslide'            => $this->input->post('landslide'),
                        'erosion'            => $this->input->post('erosion'),
                        'protected_class_lm' => ($this->input->post('is_tribal_belt') == 'YES') ? $protected_class_lm :null,
                        'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation'),
                        'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks)
                    );

                    $this->db->where('case_no', $case_no);
                    $this->db->update('settlement_ap_lmnote', $lmnote);


                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No ' . $application_no);
                        $data = array(
                            'error' => "#SETUP0004: Registration of settlement_ap_lmnote failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

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
                    //// premium insert lm update start
                    if($is_prem_update=='YES'){
                        $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));
                        if($checkingPremiumExistSql->num_rows() > 0)
                        {
                            $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
                            $resultprem = $this->db->query($sqlprem);

                            if ($this->db->affected_rows() == 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRSET000311: Updation Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }

                        $sumMbAmount=0;
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
                            if (in_array($premdags->dist_code, json_decode(BARAK_VALLEY))){
                                $area_in_bigha=6400;
                            }else{
                                $area_in_bigha=100;
                            }
                            $concession_rate=25;
                            $ratetype=$this->input->post('rate_type'.$premdags->dag_no);
                            $ratepr2=$this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                            $ratepr = $ratepr2->rate_type;
                            $is_full_pay=$this->input->post('paymode');
                            // $prem_zonal=$this->input->post('zonal_valuation_prem'.$premdags->dag_no);
                            $uuid=$this->input->post('uuid');
                            $prem_zonal = $this->ncutility->getZonalValue($premdags->dist_code,$uuid,$premdags->dag_no);
                            $prem_area = $this->input->post('total_lessa'.$premdags->dag_no);
                            $prem_rate = $this->input->post('rate'.$premdags->dag_no);
                            $prem_concession =$this->input->post('concession'.$premdags->dag_no);
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
                                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                        $amount1 = ceil($premium * $discount / 100);

                                        $access_area = $prem_area - $mb_land;
                                        $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                                        $amount2 = ceil($premium2 * $discount / 100);

                                        // $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                        // $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                        // $amount = ($premium * $discount / 100);
                                        // $finalamount = ceil($amount);
                                        $finalamount = ceil($amount1 + $amount2);
                                    }else{
                                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                                        $amount = ($premium * $discount / 100);
                                        // $finalamount = round($amount,2);
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
                                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                                        $amount1 = ceil($premium * $prem_rate / 100);

                                        $access_area = $prem_area - $mb_land;
                                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                        $amount2 = ceil($premium2 * $prem_rate / 100);

                                        $finalamount = ceil($amount1 + $amount2);

                                    }else{
                                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                                        $amount = ($premium * $prem_rate / 100);
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
                            $premdata=array(
                                'case_no'=>$case_no,
                                'user_code'=>$this->session->userdata('user_code'),
                                // 'uuid'=>$premdags->uuid,
                                'dag_no'=>$premdags->dag_no,
                                'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$premdags->dag_no),
                                'area_name'=>$this->input->post('area_new'.$premdags->dag_no),
                                'land_type'=>$this->input->post('land_type'.$premdags->dag_no),
                                'rate_type'=>$this->input->post('rate_type'.$premdags->dag_no),
                                'rate'=>$this->input->post('rate'.$premdags->dag_no),
                                'concession'=>$this->input->post('concession'.$premdags->dag_no),
                                'amount_dag'=>$this->input->post('amount'.$premdags->dag_no),
                                'final_amount'=>$this->input->post('finalamount'),
                                'due_amount'=>$this->input->post('totaldue'),
                                'total_lessa'=>$this->input->post('total_lessa'.$premdags->dag_no),
                                'is_full_pay'=>$this->input->post('paymode'),
                                'is_final'=>1,
                                'date_entry'=>date('Y-m-d h:i:s'),
                                'approve_by'=>$this->input->post('approval'.$premdags->dag_no),
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

                            $approved_by = $this->input->post('approval'.$premdags->dag_no);
                        }

                        // premium verify 2 start ******************
                        // var_dump($sumMbAmount.'-----'.$this->input->post('finalamount')); die;
                        if((float)$sumMbAmount != (float)$this->input->post('finalamount')){
                            // var_dump("Amount mismatch!!!"); die;
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0003: Settlement Application not submitted case no # $case_no");
                            log_message('error', '#ERRAM0003: Premium ghotala by LM, RTPS Case No '.$case_no);
                            redirect(base_url() . "index.php/home");
                        }
                        if ($is_full_pay=="NO"){
                            $discount = 30;
                            $finaldue = ($sumMbAmount * $discount / 100);
                            // $finaldueamount = round($finaldue,2);
                            $finaldueamount = ceil($finaldue);
                        }else if ($is_full_pay=="YES"){
                            $finaldueamount= $sumMbAmount;
                        }

                        if($finaldueamount != $this->input->post('totaldue')){
                            // var_dump("Due Amount mismatch!!!");
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRAM0004: Settlement Application not submitted case no # $case_no");
                            log_message('error', '#ERRAM0004: Premium ghotala by LM, RTPS Case No '.$case_no);
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
                        // var_dump($prem_settleemt_area); die;
                        if ($total_settlement_area != $prem_settleemt_area)
                        {

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
                    //****validation bypass required insertions  */
                    $this->NcCommonModel->secondProceedingValidationBypassTrue(
                        NC_KHAS_LAND_ID,
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
                    'task' => 'LM updated note submitted',
                    'note_type' => $this->input->post('lm_note'),
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
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task = 'LM';
                    $pen = 'CO';
                    // $pen = $pending_officer;
                    $case = $case_no;
                    $rtps_status = $this->NcApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);$rtps_status=json_decode($rtps_status);
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    // $this->DashboardInheritance($case_no['case_no']);
                    //////
                    $this->session->set_flashdata('message', "Settlement Application Updated Successfully with case no # $case_no");
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

            $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_townprt_code, $dag_no);
            $vlb_enc['vlb_enc'] = $vlb_encroacher;
            if ($vlb_encroacher == true) {
                // getting the encroacher details
                $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                $vlb_enc['vlb_enc_details'] = $vlb_encroacher_in_dag;
            } else {
                $vlb_enc['empty_err'] = "No Land Bank Details found!!";
            }
            $vlb_enc['_view'] = 'SettlementView/VlbEncroacherDetails';
            $this->load->view('layouts/main', $vlb_enc);
        }
    }

    // ===================================================================

    // generic file upload

    public function createTokenJwtFileUpload()
    {
        $timestamp = date("Y-m-d H:i:s");
        $jwt = new JWT();
        $key = DHAR_AUTH_KEY;
        $payload = array(
            "timestamp" => $timestamp
        );
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    public function fileUploadApiRawFile($files, $application_no, $service_name, $doc_name) // raw data
    {
        log_message("error",'fileUploadAPI()');
        $_FILES = $files;

        //FETCH THE FILE NAME IN _FILES ARRAY === NECESSARY FOR FILE UPLOADING
        $fileName = array_keys($_FILES);
        $fileName = $fileName[0];

        if(isset($_FILES[$fileName]['name']))
        {
            // create jwt token
            $token = $this->createTokenJwtFileUpload();

            // Create a CURLFile object
            $cfile = curl_file_create($_FILES[$fileName]['tmp_name'],$_FILES[$fileName]['type'],$_FILES[$fileName]['name']);

            $postRequest = array(
                'file'           => $cfile,
                'application_no' => $application_no,
                'service_name'   => API_KEY,
                'token'          => $token,
                'doc_name'       => $doc_name,
            );

            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, API_FOR_UPLOAD_RAW);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);
            $data = curl_exec($cURL);

            $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
            curl_close($cURL);
            if($httpcode != 200) {
                return false;
            }
            return $data;
        }
    }

    public function fileUploadApiBaseFile($files, $application_no, $service_name, $doc_name)
    {
        log_message("error",'fileUploadAPI()');
        $_FILES = $files;

        //FETCH THE FILE NAME IN _FILES ARRAY === NECESSARY FOR FILE UPLOADING
        $fileName = array_keys($_FILES);
        $fileName = $fileName[0];

        $file = file_get_contents($_FILES[$fileName]['tmp_name']);
        $file_upload = base64_encode($file);

        if(isset($_FILES[$fileName]['name']))
        {
            // create jwt token
            $token = $this->createTokenJwtFileUpload();

            // Create a CURLFile object
            $cfile = curl_file_create($file_upload,$_FILES[$fileName]['type'],$_FILES[$fileName]['name']);

            // var_dump($cfile);

            $postRequest = array(
                'file'           => $file_upload,
                'application_no' => $application_no,
                'service_name'   => API_KEY,
                'token'          => $token,
                'doc_name'       => $doc_name,
            );

            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, API_FOR_UPLOAD_BASE);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);
            $data = curl_exec($cURL);

            $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
            curl_close($cURL);
            if($httpcode != 200) {
                return false;
            }
            return $data;
        }
    }


    public function fetchUploadFileApiRawFile()
    {
        $documentID = $_GET['doc_id'];
        $content_type = $_GET['content_type'];
        $postRequest = array(
            'documentID'   => $documentID,
            'service_name' => API_KEY,
            'token'        => $this->createTokenJwtFileUpload(),
        );

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_FOR_FETCH_RAW);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $data = curl_exec($cURL);

        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if($httpcode != 200) {
            return false;
        }
        log_message('error', 'Curl fetch data : '. json_encode($data));
        // $data = json_decode($data);
        ob_clean();
        $data_decoded = $data;
        header("Content-type: ".$content_type);
        echo $data_decoded;
    }


    public function fetchUploadFileApiBaseFile() // base64 encoded data
    {
        $documentID = $_GET['doc_id'];
        $content_type = $_GET['content_type'];
        $postRequest = array(
            'documentID'   => $documentID,
            'service_name' => API_KEY,
            'token'        => $this->createTokenJwtFileUpload(),
        );

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_FOR_FETCH_BASE);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $data = curl_exec($cURL);

        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if($httpcode != 200) {
            return false;
        }
        ob_clean();
        $res= json_decode($data);
        header("Content-type: ".$res->content_type);
        echo base64_decode($res->base64_data);
    }


    public function multipleFileSave()
    {
        // 1: validation
        // 2: file size uploading issue
        // 3: runtime error
        // 4: success

        log_message('error',json_encode($_FILES));
        // header('content-type:application/json');

        $application_no = $_POST['application_no'];
        $doc_name       = $_POST['doc_name'];
        $service_name   = $_POST['service_name'];;

        //for base file uncomment below line
        $multiple_file_upload = $this->fileUploadApiBaseFile($_FILES, $application_no, $service_name, $doc_name);

        //for raw file uncomment below line
        // $multiple_file_upload = $this->fileUploadApiRawFile($_FILES, $application_no, $service_name, $doc_name);

        echo $multiple_file_upload;
    }


    public function test1()
    {
        log_message('error', ' coming from basundhara');
        log_message('error', json_encode($_SESSION));
        echo 'hello';
    }

    public function fetchTribalBelt(){
        $case_no = $this->input->post('case_no');

        $sql = $this->db->query('select * from settlement_ap_lmnote where case_no = ?', array($case_no));
        if($sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5693: Case number not found!'
            ]);
            return false;
        }

        $sqldag = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if($sqldag->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR5702: Case number not found!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'data' => $sql->row(),
            'data1' => $sqldag->result()
        ]);

    }


}
