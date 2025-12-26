<?php
class SettlementAutoRegistrationController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('SettlementModel/SettlementAutoRegistrationModel');


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }

    public function dbswitch($dist_code)
    {
        //$CI=&get_instance();
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($dist_code == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function autoRegister()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $distArray = ['02','03','05','06','07','08','11','12','13','14','15','16','17','18','21','24','25','32','33','34','35','36','37','38','39'];
        // $distArray = array('07');


        foreach($distArray as $distAr)
        {
            $this->dbswitch($distAr);
            log_message('error','autoRegister: DB:'.$distAr);
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getUnregisteredCases/".$distAr);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            //     'dist_code' => $distAr,
            // )));
            $output = curl_exec($curl_handle);
            curl_close($curl_handle);
            $sirApiArray = json_decode($output);
        
            foreach($sirApiArray as $apiar)
	        {
		        $st_time = microtime(true);              
                $application_no = $apiar->application_no;
                $service_code = $apiar->service_code;

                $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
                $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
        
                //*******Settlement Khasland */
                if($service_code == '16')
                {
                    $recordExist=$this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        
                    if(!$recordExist)
                    {
                        /// additional property for LM note
                        $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
                        if($additional_property->num_rows() > 0){
                            $totallesaa=0;
                            $totalganda=0;
                            foreach($additional_property->result() as $addprop){
                                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                                    $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                                    $totalganda = $totalganda+$total_g;
                                }else{
                                    $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                                    $totallesaa = $totallesaa+$total_l;
                                }
                
                            }
                            if(!empty($totallesaa)){
                                $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                            }
                            if(!empty($totalganda)){
                                $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                            }
                            $district['additional_property']=$additional_property->result();
                            //var_dump($district['additional_property']); die;
                        }
                
                
                
                        $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application_no' => $application_no,
                            'api_key' => 'DHARITREE_MB2',
                            'token' => $token
                        )));
                
                        $output = curl_exec($curl_handle);
                        if(isset(json_decode($output)->responseType)){
                            if(json_decode($output)->responseType == 3){
                                echo json_decode($output)->data." - Unauthorized access!";
                                continue;
                            }
                        }
                        curl_close($curl_handle);
                        $backup = $output;
                
                        $output = json_decode($output);
                        $district['app']=$output->application;
                        //****************generate case number********************
                        $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
                        if(empty($case_name))
                        {
                            $data=array(
                                'error'=>"Network Issue or Session Out. Please try Again"
                            );
                            echo json_encode($data);
                            continue;
                        }
                        //*******generating petition_no and case_no */
                        $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
                        $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_KHAS_LAND;
                
                        $district['geo_date']=$geo_date;
                        
                        $district['pattaNo']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
                
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
                        
                        $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
                        if ($user_code == null)
                           $user_code = 'AUTO';
                        else 
                            $user_code = $user_code->lm_code;
                        
                        // $pno=$district['pattaNo']->patta_no;
                        // $pc=$district['pattaNo']->patta_type_code;
                        $dag = $district['app']->dag_no;
                
                        $district['co_name']= $this->SettlementAutoRegistrationModel->getCoName($d, $s, $c);
                        $district['s_area'] = $this->SettlementAutoRegistrationModel->getPremiumArea();
                
                        $district['bhumi'] = $output->bhumi;
                
                        // for guardian relation
                        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                
                        $relation_executation = $this->db->query($query_for_guar_rel);
                        $row = $relation_executation->num_rows();
                
                        if ($row != 0) {
                            $district['guar_rel'] = $relation_executation->result();
                        }    
                
                        // fetch riotee noks -js- 05-09-2022
                        if($output->riotee_noks == true){
                            $district['riotee_nok'] = $output->riotee_noks;
                        }
                        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
                        // foreach($output->selfDeclaration as $selfDec){
                        //     $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                        // }
                
                        $vlb_encc=[];
                        if($output->encroachers == true){
                            $district['riotee'] = $output->encroachers;
                            foreach($output->encroachers as $encroacher){
                                $vlb_encroacher = $this->SettlementAutoRegistrationModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                
                                $district['vlb_enc'] = $vlb_encroacher;
                
                                if($vlb_encroacher == true){
                                    // getting the encroacher details
                                    $vlb_encroacher_in_dag = $this->SettlementAutoRegistrationModel->getEncroacherInDag($vlb_encroacher->id);
                                    $vlb_encc[] = $vlb_encroacher_in_dag;
                                }else{
                                    $district['empty_err'] = "No Land Bank Details found!!";
                                }
                            }
                            $district['vlb_enc_details']=$vlb_encc;
                        }
                
                        // aadhaar photo api
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
                
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application_no'             => $application_no,
                
                        )));
                        $get_aadhaar_photo = curl_exec($curl_handle);
                        curl_close($curl_handle);
                
                
                        // if($get_aadhaar_photo != 'n'){
                        //     $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        // }
                
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
                            log_message('error', $this->db->last_query());

                            $this->db->trans_rollback();
                            log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);
            
                            continue;
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
                                        'service_id'          => SETTLEMENT_KHAS_LAND_ID,
                                        'applied_flag'        => CITIZEN,
                                        'dist_name'           => trim($value->dist_name),
                                        'cir_name'            => trim($value->cir_name),
                                        'vill_name'           => trim($value->vill_name),
                                        'applid'              => $application_no,
                                    );
                                    $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);
                
                                    if ($insAddProperty != 1) {
                                        log_message('error', $this->db->last_query());

                                        $this->db->trans_rollback();
                                        log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                                        $data = array(
                                            'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                                        );
                                        echo json_encode($data);
                                        continue;
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
                            'user_code'=>$user_code,
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
                        );
                
                        $insSetBasic = $this->db->insert('settlement_basic', $basic);
                        // echo $this->db->last_query(); die();
                
                        if ($insSetBasic != 1) {
                            $this->db->trans_rollback();
                            log_message('error', $this->db->last_query());

                            log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                
                            $data = array(
                                'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            continue;
                        }
                
                
                        ////settlement_dag_details insert start
                        if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);
                            log_message('error', $this->db->last_query());
                
                            $data = array(
                                'error'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            continue;
                        }
                        foreach ($district['encroachers'] as $dags) {
                            $district['class']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);
                
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
                                'user_code'=>$user_code,
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
                                $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                                $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);
                
                                $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;
                
                                $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                            }
                            else
                            {
                                $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                                $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);
                
                                $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
                
                                $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
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
                            if ($insSetDag != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                                log_message('error', $this->db->last_query());

                                $data = array(
                                    'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                continue;
                            }
                
                            //*******insertion in settlement_area_history**************
                            if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                                //***********actual Encroachment area ***************
                                $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                                $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);
                
                                //***********total Actual Encroachment area*****************
                                $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                                $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                                // **********************************************
                
                
                                //***********Settlement area that applicant will get settlement on***********
                                $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                                $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);
                
                                //*****total Settlement area *************/
                                $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                                $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);
                
                                //*************leftout area homestead**************
                                $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                                $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);
                
                                //**********Ileftout area agriculture**************
                                $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                                $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);
                
                                //**********Total left out area***************
                                $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                                $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
                
                            }
                            else
                            {
                                //********actual Encroachment area********** 
                                $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                                $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);
                
                                //***********total Actual Encroachment area*****************
                                $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                                $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                                // **********************************************
                
                                //*******Settlement area that applicant will get settlement on**********
                                $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                                $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);
                
                                //*************Total settlement area */
                                $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                                $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);
                
                                //****************leftout area homestead**************
                                $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                                $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);
                
                                //*************leftout area agriculture*****************
                                $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                                $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);
                
                                //**********Total left out area***************
                                $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                                $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
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
                                log_message('error', $this->db->last_query());

                                $data = array(
                                    'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                continue;
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
                                // fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                // fclose($aadhaar_file_to_write_base64);
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
                                'user_code'=>$user_code,
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
                                log_message('error', $this->db->last_query());
                                continue;
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
                
                                    'user_code'=>$user_code,
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
                                    log_message('error', $this->db->last_query());

                                    $data = array(
                                        'error'=>"#ERRSET000309: Registration of Settlement failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    continue;
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
                                    log_message('error', $this->db->last_query());

                                    $data = array(
                                        'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    continue;
                                }
                            }
                        }
                        ///// nominee end //////
                
                        //********basundhar_application insertation */
                        $basundhara=array(
                            'dharitree'=>$case_no['case_no'],
                            'basundhara'=>$application_no,
                            'date_reg'=>date('Y-m-d'),
                            'reg_by'=>$user_code,
                            'app_status'=>'M',
                            'pending_with'=>'LM'
                        );
                        $basundhar_app = $this->db->insert('basundhar_application',$basundhara);
                
                        if ($basundhar_app != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                            log_message('error', $this->db->last_query());
                            
                            $data = array(
                                'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            continue;
                        }else{
                            // $this->db->trans_rollback();

                            log_message('error', 'AUTO_REGISTER: Success -> '. $application_no.', dbid=>'.$distAr.', time taken=>'.(microtime(true)-$st_time));
                            var_dump('success-> ' . $application_no);
                            //******commit if no errors */
                            $this->db->trans_commit();
                        }

                       
                
                    }
                }
                
                //******settlement AP Transferred */
                if($service_code = '14')
                {
                    $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);

                    if(!$recordExist) 
                    {
                        $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
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
                        if(isset(json_decode($output)->responseType))
                        {
                            if(json_decode($output)->responseType == 3)
                            {
                                log_message('error', '- Unauthorized access!');
                                continue;
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
                        // if($get_aadhaar_photo != 'n'){
                        //     $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        // }
                
                        $app = $output->application;
                        $d   = $app->dist_code;
                        $s   = $app->subdiv_code;
                        $c   = $app->cir_code;
                        $m   = $app->mouza_code;
                        $l   = $app->lot_no;
                        $v   = $app->village_code;
                        $dag = $app->dag_no;
            
                        $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName($d,$s,$c); // generate case name
                        if(empty($case_name))
                        {
                            log_message('error', '#ERR176: Case name can not be generated for application no '.$application_no);
                            log_message('error', $this->db->last_query());
                            continue;
                        }
            
                        //generate case no
                        $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
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
                            'user_code'                   => 'AUTO',
                            'type_of_transfer'            => $type_of_transfer,
                            'type_of_patta'               => $type_of_patta,
                        ];
                        $settlement_basic_insertion = $this->db->insert('settlement_basic',$settlement_basic);
                        if($settlement_basic_insertion != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERR274: Insertion failed in settlement_basic for RTPS Case No '. $application_no);
                            log_message('error', $this->db->last_query());
                            continue;
                        }
            
                        //insert into ADDITIONAL PROPERTY
                        $checkAdditionalProperty = $this->SettlementAutoRegistrationModel->getAdditionalPropertyDetail($application_no);
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
                                        log_message('error', '#ERR314: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                                        log_message('error', $this->db->last_query());
                                        continue;
                                    }
                                }
                            }
                        }
            
                        //insert into SETTLEMENT DAG DETAILS
                        if(!empty($output->settlements)) {
                            foreach($output->settlements as $dag) {
                                if($dag->is_applicant == 1) {
            
                                    $new_land_class = $this->getPattaTypeNo($d,$s,$c,$m,$l,$v,$dag->dag_no);
            
                                    $insSettlementDagDetails = [
            
                                        'dist_code'           => $d,
                                        'subdiv_code'         => $s,
                                        'cir_code'            => $c,
                                        'mouza_pargona_code'  => $m,
                                        'lot_no'              => $l,
                                        'vill_townprt_code'   => $v,
                                        'user_code'           => 'AUTO',
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
                                        log_message('error', '#ERR386: Insertion failed in settlement_dag_details for RTPS Case No '. $application_no);
                                        log_message('error', $this->db->last_query());
                                        continue;
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
                                        // fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                        // fclose($aadhaar_file_to_write_base64);
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
                                $cron_no = $this->SettlementAutoRegistrationModel->getPdarCronNo($case_no['case_no']);
            
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
                                    'user_code'         => 'AUTO',
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
                                    log_message('error', '#ERR493: Insertion failed in settlement_applicant for RTPS Case No '. $application_no);
                                    log_message('error', $this->db->last_query());
                                    continue;
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
                                    log_message('error', '#ERR517: Insertion failed in settlement_nominee for RTPS Case No '. $application_no);
                                    log_message('error', $this->db->last_query());
                                    continue;
                                }
                            }
                        }
            
                        //insert into BASUNDHAR APPLICATION
                        $basundhara = [
                            'dharitree'    => $case_no['case_no'],
                            'basundhara'   => $application_no,
                            'date_reg'     => date('Y-m-d'),
                            'reg_by'       => 'AUTO',
                            'app_status'   => 'M',
                            'pending_with' => 'CO',
                        ];
                        $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
                        if ($basundhar_app != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERR539: Insertion failed in Basundhara Application for RTPS Case No '. $application_no);
                            log_message('error', $this->db->last_query());
                            continue;
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
                            log_message('error', '#ERR135: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);
                            log_message('error', $this->db->last_query());
                            continue;
                        }
            
                        $this->db->trans_commit(); // transaction ends here
            
                    }
                }
            }
          
        }
    }


    function getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag) {
        $query = "select sum(dag_revenue+dag_local_tax) as sum,dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code from chitha_basic where dist_code= '$d' and subdiv_code='$s' and cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and  trim(dag_no)=trim('$dag') group by dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code  ";
        $sql = $this->db->query($query)->row();
        return $sql;
    }


    public function getReviewNumber($application_no, $is_review){
        $review_number = 0;
        if($is_review == true){
            $sql_get_review_count = $this->db->query('select max(review_flag) as review_flag from settlement_basic where applid = ?', array($application_no));
            if($sql_get_review_count->num_rows() > 0){
                $exiting_review_cnt = $sql_get_review_count->row()->review_flag;
                $review_number = (int)$exiting_review_cnt+1;
            }
        }
        return $review_number;
    }

    public function autoRegTribal($application_no, $is_review = false){

        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        if (!$recordExist || $is_review == true) {

            $review_number = $this->getReviewNumber($application_no, $is_review);

            // get data from basundhara end (API call)
            $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
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
                    echo json_encode([
                        'responseType' => 1,
                        'message' => json_decode($output)->data . - '- Unauthorized access!'
                    ]);
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);

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

            // if ($get_aadhaar_photo != 'n') {
            //     $district['aadhaar_b64_decoded'] = "<img src = data:" . $this->decodeBase64($get_aadhaar_photo) . ";base64," . $get_aadhaar_photo . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            // }

            $app = $output->application;
            $d = $app->dist_code;
            $s = $app->subdiv_code;
            $c = $app->cir_code;
            $m = $app->mouza_code;
            $l = $app->lot_no;
            $v = $app->village_code;
            $dag = $app->dag_no;

            $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
            if ($user_code == null)
               $user_code = 'AUTO';
            else 
                $user_code = $user_code->lm_code;

            $case_name = $this->SettlementAutoRegistrationModel->genearteCaseName(); // generate case name
            if (empty($case_name)) {
                log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                echo json_encode([
                    'responseType'  => 1,
                    'message'           => '#ERROR0002: Network Issue or Session Out. Please try Again!'
                ]);
                return false;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
            $case_no['case_no'] = $case_name . $petition_no . "/" . SETTLEMENT_TRIBAL_COMMUNITY;

            //check for tribal belt
            if ($output->applicants['0']->under_tribe_belts == 1) {
                $tribal_belt = 'YES';
            } else if ($output->applicants['0']->under_tribe_belts == 0) {
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
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#BACKUP001: Registration of Settlement failed for case no : '.$application_no
                ]);
                return false;
            }

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM

            if(isset($output->applicants)){
                foreach($output->applicants as $type_of_lands){
                    if($type_of_lands->is_applicant == 1){
                        $api_free_encroachment = $type_of_lands->free_encrochment;
                        $applicant_occupation = $type_of_lands->applicant_occupation;
                        $applicant_ref_no = $type_of_lands->ref_no;
                        $applicant_caste_category= $type_of_lands->caste_category;
                        $applicant_uuid= $type_of_lands->uuid;
                    }
                }
            }

            $settlement_basic = [
                'dist_code'                     => $d,
                'subdiv_code'                   => $s,
                'cir_code'                      => $c,
                'mouza_pargona_code'            => $m,
                'lot_no'                        => $l,
                'vill_townprt_code'             => $v,
                'service_code'                  => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                'ref_no'                        => $applicant_ref_no,
                'case_no'                       => $case_no['case_no'],
                'trans_code'                    => 'F',
                'petition_no'                   => $case_no['petition_no'],
                'year_no'                       => date('Y'),
                'date_entry'                    => date('Y-m-d G:i:s'),
                'status'                        => 'Z',
                'submission_date'               => date('Y-m-d G:i:s'),
                'period_possession'             => date('Y-m-d'),
                'occupation_applicant'          => $applicant_occupation,
                'applid'                        => $application_no,
                'caste'                         => $applicant_caste_category,
                'uuid'                          => $applicant_uuid,
                'tribal_belt'                   => $tribal_belt,
                'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                'user_code'                     => $user_code,
                'is_occupying_land'             => $api_free_encroachment,
                'review_flag'                   => $review_number,
            ];

            $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);
            if ($settlement_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#ERROR0003: Registration of Settlement failed for RTPS application no : '.$application_no
                ]);
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
                            'service_id' => SETTLEMENT_TRIBAL_COMMUNITY_ID,
                            'applied_flag' => CITIZEN,
                            'dist_name' => trim($value->dist_name),
                            'cir_name' => trim($value->cir_name),
                            'vill_name' => trim($value->vill_name),
                            'applid' => $application_no,
                        ];
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No ' . $application_no . ' and query is ' . $this->db->last_qery());

                            echo json_encode([
                                'responseType' => 1,
                                'msg'   => '#ERROR0004: Registration of Settlement failed for case no : ' . $application_no,
                            ]);
                            return false;
                        }
                    }
                }
            }

            foreach ($output->encroachers as $dags_details) {

                $district['class']=$this->getPattaTypeNo($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code, $dags_details->dag_no);

                $enc_home_bigha = $dags_details->mbigha;
                $enc_home_katha = $dags_details->mkatha;
                $enc_home_lessa = $dags_details->mlessa;
                $enc_home_ganda = $dags_details->mganda;
                $enc_home_kranti = $dags_details->mkranti;

                $enc_agri_bigha = $dags_details->agri_bigha;
                $enc_agri_katha = $dags_details->agri_katha;
                $enc_agri_lessa = $dags_details->agri_lessa;
                $enc_agri_ganda = $dags_details->agri_ganda;
                $enc_agri_kranti = $dags_details->agri_kranti;

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
                    'dist_code'             => $app->dist_code,
                    'subdiv_code'           => $app->subdiv_code,
                    'cir_code'              => $app->cir_code,
                    'mouza_pargona_code'    => $app->mouza_code,
                    'lot_no'                => $app->lot_no,
                    'vill_townprt_code'     => $app->village_code,
                    'user_code'             => $user_code,
                    'date_entry'            => date('Y-m-d'),
                    'case_no'               => $case_no['case_no'],
                    'petition_no'           => $case_no['petition_no'],
                    'year_no'               => date('Y'),
                    'new_land_class_code'   => $district['class']->land_class_code,
                    'dag_no'                => $dags_details->dag_no,
                    'patta_no'              => $dags_details->patta_no,
                    'patta_type_code'       => $dags_details->patta_code,
                    'is_urban'              => $app->is_urban,
                    'land_type'             => $dags_details->land_type,
                    'revenue'               => 0,
                    'operation'             => 'E',
                    'encroachement_area'    => json_encode($encroachment_area)
                );

                $fmd['dag_area_b']=$dags_details->applied_bigha;
                $fmd['dag_area_k']=$dags_details->applied_katha;
                $fmd['dag_area_lc']=$dags_details->applied_lessa;
                $fmd['dag_area_g']=$dags_details->applied_ganda;
                $fmd['dag_area_kr']=$dags_details->applied_kranti;

                $fmd['home_b']=$dags_details->mbigha;
                $fmd['home_k']=$dags_details->mkatha;
                $fmd['home_lc']=$dags_details->mlessa;
                $fmd['home_g']=$dags_details->mganda;
                $fmd['home_kr']=$dags_details->mkranti;

                $fmd['agri_b']=$dags_details->agri_bigha;
                $fmd['agri_k']=$dags_details->agri_katha;
                $fmd['agri_lc']=$dags_details->agri_lessa;
                $fmd['agri_g']=$dags_details->agri_ganda;
                $fmd['agri_kr']=$dags_details->agri_kranti;


                //************Total Area Calculation -js- ******************
                if (in_array($app->dist_code, json_decode(BARAK_VALLEY))){
                    //******for Barak valley */
                    $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
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
                if ($insSetDag != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message' => "#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //*******insertion in settlement_area_history**************
                if (in_array($app->dist_code, json_decode(BARAK_VALLEY))){
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************

                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
                }
                else
                {
                    //********actual Encroachment area********** 
                    $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************

                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                }

                $settlementAreaHistoryArr = [
                    'application_no' => $application_no,
                    'case_no' => $case_no['case_no'],
                    'dag_no' => $dags_details->dag_no,
                    'uuid' => $app->uuid,
                    'created_at' => date('Y-m-d'),
                    'applied_area_home_bigha' => $dags_details->mbigha,
                    'applied_area_home_katha' => $dags_details->mkatha,
                    'applied_area_home_lessa' => $dags_details->mlessa,
                    'applied_area_home_ganda' => $dags_details->mganda,
                    'applied_area_home_kranti' => $dags_details->mkranti,
                    'applied_area_agri_bigha' => $dags_details->agri_bigha,
                    'applied_area_agri_katha' => $dags_details->agri_katha,
                    'applied_area_agri_lessa' => $dags_details->agri_lessa,
                    'applied_area_agri_ganda' => $dags_details->agri_ganda,
                    'applied_area_agri_kranti' => $dags_details->agri_kranti,
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
                        'responseType' => 1,
                        'message'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //**************end of settlement_area_history********************
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

                    if (trim($appl->pdar_type) == 'B'){
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }else{
                        $pdar_rel_guar = 0;
                    }

                    if (trim($appl->pdar_type) == 'EN'){
                        $possession_date = $appl->possession_date;
                    }else{
                        $possession_date = null;
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
                        'user_code' => $user_code,
                        'case_no' => $case_no['case_no'],
                        'petition_no' => $case_no['petition_no'],
                        'operation' => 'E',
                        'dag_no' => $dag_no,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type_code,
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_id' => '-1',
                        'pdar_cron_no' => $cron_no,
                        'pdar_name' => $appl->name_ass,
                        'pdar_guardian' => $appl->gurdian_name_ass,
                        'pdar_rel_guar' => $pdar_rel_guar,
                        'pdar_gender' => $appl->gender,
                        'pdar_add1' => $appl->pre_add,
                        'pdar_add2' => $appl->per_add,
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
                        'enc_id' => $appl->encroacher_id,
                        'period_possession' => $possession_date,

                    ];
                    $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);
                    if ($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERROR0006: Registration of Settlement failed for RTPS application no : ' . $application_no
                        ]);
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

                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERROR0007: Registration of Settlement failed for RTPS application no : '. $application_no
                        ]);
                        return false;
                    }
                }
            }

            //   insert into BASUNDHAR APPLICATION
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

                echo json_encode([
                    'responseType' => 1,
                    'message' => "#ERROR0008: Registration of Settlement failed for RTPS application no : " . $application_no
                ]);
                return false;
            }

            //insert into relation table
            if($is_review == true && $recordExist){
                $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                $old_case_no = $old_case_no_sql->row()->case_no;
                
                $relation_tab_arr = [
                    'case_no' => $case_no['case_no'],
                    'old_case_no' => $old_case_no,
                    'application_no' => $application_no,
                    'review_number' => $review_number,
                    'date_entry' => date('Y-m-d H:i:s'),
                    // 'date_update' => 
                ];

                $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                if($rel_insert != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#ERR2073: Unable to insert into settlement review!'
                    ]);
                    return false;
                }
            }

            $this->db->trans_commit();

            echo json_encode([
                'responseType' => 2,
                'message' => 'Data saved succesfully'
            ]);
        }
    }


    public function autoRegCultivation($application_no, $is_review = false){

        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        if(!$recordExist || $is_review == true){
            $review_number = $this->getReviewNumber($application_no, $is_review);

            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
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
                    echo json_encode([
                        'responseType' => 1,
                        'message' => json_decode($output)->data . - '- Unauthorized access!'
                    ]);
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);

            //****************-js- generate case number********************
            $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName();
            if(empty($case_name))
            {
                echo json_encode([
                    'responseType'  => 1,
                    'message'           => '#ERROR00032: Network Issue or Session Out. Please try Again!'
                ]);
                return false;
            }

            //*******generating petition_no and case_no */
            $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_SPECIAL_CULTIVATORS;

            $district['app']=$output->application;

            $district['pattaNo']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

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
            $dag = $district['app']->dag_no;
            $district['bhumi'] = $output->bhumi;

            // if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
            //     $this->session->set_flashdata('message', "#ERR1002454: Unauthorized access for case no # ".$application_no);
            //     redirect(base_url() . "index.php/home");
            // }

            //**********for fetching the riotees noks */
            if($output->riotee_noks == true){
                $district['riotee_nok'] = $output->riotee_noks;
            }
            //********for fetching self declaration */
            foreach($output->selfDeclaration as $selfDec){
                $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            // aadhaar photo api
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);

            $this->db->trans_begin();

            // insertion in backup table (lm)--mdz
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
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#BACKUP001: Registration of Settlement failed for case no : '.$application_no
                ]);
                return false;
            }

            $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
            if ($user_code == null)
               $user_code = 'AUTO';
            else 
                $user_code = $user_code->lm_code;
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
                            'service_id'          => SETTLEMENT_SPECIAL_CULTIVATORS_ID,
                            'applied_flag'        => CITIZEN,
                            'dist_name'           => trim($value->dist_name),
                            'cir_name'            => trim($value->cir_name),
                            'vill_name'           => trim($value->vill_name),
                            'applid'              => $application_no,
                        );
                        $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                        if ($insAddProperty != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR1585: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);

                            echo json_encode([
                                'responseType' => 1,
                                'message' => "#ERROR1585: Registration of Settlement failed for case no : ".$application_no
                            ]);
                            return false;
                        }
                    }
                }
            }

            //********************-js- case registration in opening from API starts here********* */
            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');

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
            if(isset($output->applicants)){

                foreach($output->applicants as $type_of_lands){
                    if($type_of_lands->is_applicant == 1){
                        $api_free_encroachment = $type_of_lands->free_encrochment;
                        $applicant_occupation = $type_of_lands->applicant_occupation;
                        $applicant_ref_no = $type_of_lands->ref_no;
                        $applicant_caste_category= $type_of_lands->caste_category;
                        $applicant_uuid= $type_of_lands->uuid;
                        $under_tribe_belts = $type_of_lands->under_tribe_belts;
                        $tribe_category = $type_of_lands->tribe_category;
                    }
                }
            }
            $basic=array(
                'dist_code'=> $district['app']->dist_code,
                'subdiv_code'=> $district['app']->subdiv_code,
                'cir_code'=> $district['app']->cir_code,
                'mouza_pargona_code'=> $district['app']->mouza_code,
                'lot_no'=> $district['app']->lot_no,
                'vill_townprt_code'=> $district['app']->village_code,
                'service_code'=> $district['app']->service_code,
                'ref_no'=> $applicant_ref_no,
                'case_no'=> $case_no['case_no'],
                'trans_code'=>'F',/////////full
                'petition_no'=> $case_no['petition_no'],
                'year_no'=> date('Y'),
                'status'=> 'Z',
                'period_possession'=> date('Y-m-d'),
                'occupation_applicant'=> $applicant_occupation,
                'applid'=> $district['app']->application_no,
                'cult_board'=> $district['applicants'][0]->board_name,
                'cultboard_reg_no'=> $district['applicants'][0]->board_register_no,
                'caste' => $applicant_caste_category,
                'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                'uuid' => $applicant_uuid,
                'submission_date' => date('Y-m-d'),
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'is_occupying_land' => $api_free_encroachment,
                'tribal_belt' => $under_tribe_belts,
                'review_flag' => $review_number
            );
            $insSetBasic = $this->db->insert('settlement_basic',$basic);
            if($insSetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                $data = array(
                    'responseType' => 1,
                    'message'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            //********settlement_dag_details insertation */
            if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);
                $data = array(
                    'responseType' => 1,
                    'message' => "#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            foreach($district['encroachers'] as $dags){

                $district['class']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

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

                $update_encroachment_area = [
                    'homestead' => [
                        'bigha' => $dags->mbigha,
                        'katha' => $dags->mkatha,
                        'lessa' => $dags->mlessa,
                        'ganda' => $dags->mganda,
                        'kranti' => $dags->mkranti,
                    ],

                    'agriculture' => [
                        'bigha' => $dags->agri_bigha,
                        'katha' => $dags->agri_katha,
                        'lessa' => $dags->agri_lessa,
                        'ganda' => $dags->agri_ganda,
                        'kranti' => $dags->agri_kranti,
                    ],
                ];

                $fmd=array(
                    'dist_code' => $district['app']->dist_code,
                    'subdiv_code' => $district['app']->subdiv_code,
                    'cir_code' => $district['app']->cir_code,
                    'mouza_pargona_code' => $district['app']->mouza_code,
                    'lot_no' => $district['app']->lot_no,
                    'vill_townprt_code' => $district['app']->village_code,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'case_no' => $case_no['case_no'],
                    'petition_no'=> $case_no['petition_no'],
                    'year_no' => date('Y'),
                    'new_land_class_code' => $district['class']->land_class_code,
                    'dag_no' => $dags->dag_no,
                    'patta_no' => $dags->patta_no,
                    'patta_type_code' => $dags->patta_code,
                    'dag_area_b' => $dags->applied_bigha,
                    'dag_area_k' => $dags->applied_katha,
                    'dag_area_lc' => $dags->applied_lessa,
                    'dag_area_g' => $dags->applied_ganda,
                    'dag_area_kr' => $dags->applied_kranti,
                    'is_urban' => $district['app']->is_urban,
                    'land_type' => $dags->land_type,
                    'revenue' => 0,
                    'operation' => 'E',
                    'encroachement_area' => json_encode($update_encroachment_area)
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


                //************Total Area Calculation ******************
                if (in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))){
                    //******for Barak valley */
                    $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
                }

                $fmd['s_dag_area_b'] = $totalAreaArr[0];
                $fmd['s_dag_area_k'] = $totalAreaArr[1];
                $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                $fmd['s_dag_area_g'] = $totalAreaArr[3];
                $fmd['s_dag_area_kr'] = 0;

                $insSetDag = $this->db->insert('settlement_dag_details',$fmd);

                if($insSetDag != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message' => "#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //*******insertion in settlement_area_history**************
                if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************

                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
                }
                else
                {
                    //********actual Encroachment area********** 
                    $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************

                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
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
                        'responseType' => 1,
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

            //*********aadhar image processing for insertion */
            foreach($district['applicants'] as $setl)
            {
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

                $applicant = array(
                    'dist_code' => $district['app']->dist_code,
                    'subdiv_code' => $district['app']->subdiv_code,
                    'cir_code' => $district['app']->cir_code,
                    'mouza_pargona_code' => $district['app']->mouza_code,
                    'lot_no' => $district['app']->lot_no,
                    'vill_townprt_code' => $district['app']->village_code,

                    'user_code' => $user_code,
                    'case_no' => $case_no['case_no'],
                    'petition_no' => $case_no['petition_no'],
                    'operation' => 'E',
                    'dag_no' => 0,
                    'patta_no' => 0,
                    'patta_type_code' => 0,
                    'year_no' => date('Y'),
                    'date_entry' => date('Y-m-d'),
                    'pdar_id' => '-1',
                    'pdar_cron_no' => (int)$cron_no++,
                    'pdar_name' => $setl->name_ass,
                    'pdar_guardian' => $setl->gurdian_name_ass,

                    'eng_pdar_name' => $setl->name_eng,
                    'eng_pdar_guardian' => $setl->gurdian_name_eng,

                    'pdar_rel_guar' => $setl->gurdian_relation_id,
                    'pdar_gender' => $setl->gender,
                    // //'pdar_add1' => $part->address,
                    'pdar_add1' => $setl->pre_add,
                    'pdar_add2' => $setl->per_add,
                    'pdar_mobile' => $setl->mobile,
                    'pdar_type' => $setl->pdar_type,
                    // 'caste' =>$this->input->post('cast_category'),
                    'bpl' => $setl->bpl,
                    'is_applicant' => $setl->is_applicant,
                    'identity_ref_no' => $identity_ref_no,
                    'identity_type' => $district['aadhar']->type,
                    'identity_doc_link' => $aadhar_path,
                    'marital_status' => $setl->marital_status,
                    'dob' => $setl->dob,
                );

                $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                //    echo $this->db->last_query(); die();
                if ($insSetApplicant != 1) {
                    // var_dump($insSetApplicant);
                    // echo $this->db->last_query(); die();
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No ' . $application_no . "######" . $this->db->last_query());
                    $data = array(
                        'responseType' => 1,
                        'message' => "#ERRSET0003: Registration of Settlement failed for case no : " . $application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }

            //*********settlement_applicant insertion */
            if($output->encroachers == true){

                foreach($output->encroachers as $enc_applicant){
                    $encroacher_app=array(
                        'dist_code' => $district['app']->dist_code,
                        'subdiv_code' => $district['app']->subdiv_code,
                        'cir_code' => $district['app']->cir_code,
                        'mouza_pargona_code' => $district['app']->mouza_code,
                        'lot_no' => $district['app']->lot_no,
                        'vill_townprt_code' => $district['app']->village_code,

                        'user_code'=>$user_code,
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

                    if($insSetEncroacher != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no. "######".$this->db->last_query());
                        $data = array(
                            'responseType' => 1,
                            'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            //********nex_of_kin insertion */
            if ($output->nextKin == true) {
                // foreach($output->nextKin as $nominee){
                foreach ($output->nextKin as $nex_of_kin) {
                    $nominee_data=array(
                        'case_no'=> $case_no['case_no'],
                        'nominee_name' => $nex_of_kin->next_of_kin_name,
                        'address' => $nex_of_kin->address,
                        'mobile_no' => $nex_of_kin->mobile_no,
                        'relation' => $nex_of_kin->relation_with_kin,
                    );
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                    if ($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                        $data = array(
                            'responseType' => 1,
                            'message'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            //********basundhar_application insertation */
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=> $user_code,
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00032: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                $data = array(
                    'responseType' => 1,
                    'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }else{
                //insert into relation table
                if($is_review == true && $recordExist){
                    $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                    $old_case_no = $old_case_no_sql->row()->case_no;
                    
                    $relation_tab_arr = [
                        'case_no' => $case_no['case_no'],
                        'old_case_no' => $old_case_no,
                        'application_no' => $application_no,
                        'review_number' => $review_number,
                        'date_entry' => date('Y-m-d H:i:s'),
                        // 'date_update' => 
                    ];

                    $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                    if($rel_insert != 1){
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERR2073: Unable to insert into settlement review!'
                        ]);
                        return false;
                    }
                }
                //******commit if no errors */
                $this->db->trans_commit();
            }

            echo json_encode([
                'responseType' => 2,
                'message' => 'Data successfully saved...'
            ]);
        }
    }


    public function autoRegTenant($application_no, $is_review=false){
        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        
        if (!$recordExist || $is_review == true) {
            $review_number = $this->getReviewNumber($application_no, $is_review);

            // get data from basundhara end (API call)
            $token = $this->SettlementAutoRegistrationModel->createTokenJwt() ;
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
                    echo json_encode([
                        'responseType' => 1,
                        'message' =>  json_decode($output)->data . " - Unauthorized access!"
                    ]);
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

            $case_name = $this->SettlementAutoRegistrationModel->genearteCaseName(); // generate case name

            if (empty($case_name)) {
                log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                $data = array(
                    'responseType' => 1,
                    'message' => "#ERROR0002: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
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

            $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
            if ($user_code == null)
               $user_code = 'AUTO';
            else 
                $user_code = $user_code->lm_code;

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
                'user_code' => $user_code,
                'review_flag' => $review_number
            ];
            $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);

            if ($settlement_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());

                $data = array(
                    'responseType' => 1,
                    'message' => "#ERROR0003: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }

            //insert into ADDITIONAL PROPERTY
            $checkAdditionalProperty = $this->SettlementAutoRegistrationModel->getAdditionalPropertyDetail($application_no);

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
                                'responseType' => 1,
                                'message' => "#ERROR0004: Registration of Settlement failed for case no : " . $application_no,
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

                        $new_land_class = $this->getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag->dag_no);
                        $insSettlementDagDetails = [

                            'dist_code' => $d,
                            'subdiv_code' => $s,
                            'cir_code' => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no' => $l,
                            'vill_townprt_code' => $v,
                            'user_code' => $user_code,
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

                            $data = array(
                                'responseType' => 1,
                                'message' => "#ERROR0005: Registration of Settlement failed for case no : " . $application_no,
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
                                'responseType' => 1,
                                'message'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                    }
                }
            }

            //insert into SETTLEMENT APPLICANT, main applicant/encrochers details
            // aadhaar photo api
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);

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
                    $cron_no = $this->SettlementAutoRegistrationModel->getPdarCronNo($case_no['case_no']);

                    $insApplicant = [
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $m,
                        'lot_no' => $l,
                        'vill_townprt_code' => $v,
                        'user_code' => $user_code,
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

                        $data = array(
                            'responseType' => 1,
                            'message' => "#ERROR0006: Registration of Settlement failed for case no : " . $application_no,
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

                        echo json_encode([
                            'responseType' => 1,
                            'message' => "#ERROR0007: Registration of Settlement failed for RTPS application no : " . $application_no
                        ]);
                        return false;
                    }
                }
            }

            //insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree' => $case_no['case_no'],
                'basundhara' => $application_no,
                'date_reg' => date('Y-m-d'),
                'reg_by' => $user_code,
                'app_status' => 'M',
                'pending_with' => 'LM',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());

                echo json_encode([
                    'responseType' => 1,
                    'message' =>"#ERROR0008: Registration of Settlement failed for RTPS application no : " . $application_no
                ]);
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

                echo json_encode([
                    'responseType' => 1,
                    'message' =>"#BACKUP001: Registration of Settlement failed for case no :" . $application_no
                ]);
                return false;
            }

            //insert into relation table
            if($is_review == true && $recordExist){
                $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                $old_case_no = $old_case_no_sql->row()->case_no;
                
                $relation_tab_arr = [
                    'case_no' => $case_no['case_no'],
                    'old_case_no' => $old_case_no,
                    'application_no' => $application_no,
                    'review_number' => $review_number,
                    'date_entry' => date('Y-m-d H:i:s'),
                    // 'date_update' => 
                ];

                $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                if($rel_insert != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#ERR2073: Unable to insert into settlement review!'
                    ]);
                    return false;
                }
            }

            $this->db->trans_commit(); // transaction ends here

            echo json_encode([
                'responseType' => 2,
                'message' => 'Data successfully saved...'
            ]);
        }
    }

    public function autoRegKhasland($application_no, $is_review=false){
        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        
        if(!$recordExist || $is_review == true)
        {
            $review_number = $this->getReviewNumber($application_no, $is_review);

            /// additional property for LM note
            $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
            if($additional_property->num_rows() > 0){
                $totallesaa=0;
                $totalganda=0;
                foreach($additional_property->result() as $addprop){
                    if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                        $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                        $totalganda = $totalganda+$total_g;
                    }else{
                        $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                        $totallesaa = $totallesaa+$total_l;
                    }
    
                }
                if(!empty($totallesaa)){
                    $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $district['additional_property']=$additional_property->result();
                //var_dump($district['additional_property']); die;
            }
    
    
    
            $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'api_key' => 'DHARITREE_MB2',
                'token' => $token
            )));
    
            $output = curl_exec($curl_handle);
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType == 3){
                    $msg = json_decode($output)->data." - Unauthorized access!";
                    echo json_encode([
                        'responseType' => 1,
                        'message' => $msg
                    ]);
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
    
            $output = json_decode($output);
            $district['app']=$output->application;
            //****************generate case number********************
            $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
            if(empty($case_name))
            {
                $data=array(
                    'responseType' => 1,
                    'message' => "Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                return false;
            }
            //*******generating petition_no and case_no */
            $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_KHAS_LAND;

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
    
            $district['geo_date']=$geo_date;
            
            $district['pattaNo']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
    
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
            
            $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
            if ($user_code == null)
               $user_code = 'AUTO';
            else 
                $user_code = $user_code->lm_code;
            
            // $pno=$district['pattaNo']->patta_no;
            // $pc=$district['pattaNo']->patta_type_code;
            $dag = $district['app']->dag_no;
    
            $district['co_name']= $this->SettlementAutoRegistrationModel->getCoName($d, $s, $c);
            $district['s_area'] = $this->SettlementAutoRegistrationModel->getPremiumArea();
    
            $district['bhumi'] = $output->bhumi;
    
            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
    
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
    
            if ($row != 0) {
                $district['guar_rel'] = $relation_executation->result();
            }    
    
            // fetch riotee noks -js- 05-09-2022
            if($output->riotee_noks == true){
                $district['riotee_nok'] = $output->riotee_noks;
            }
            // $district['selfDeclarationDetails'] = $output->selfDeclaration;
            // foreach($output->selfDeclaration as $selfDec){
            //     $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            // }
    
            $vlb_encc=[];
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    $vlb_encroacher = $this->SettlementAutoRegistrationModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
    
                    $district['vlb_enc'] = $vlb_encroacher;
    
                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->SettlementAutoRegistrationModel->getEncroacherInDag($vlb_encroacher->id);
                        $vlb_encc[] = $vlb_encroacher_in_dag;
                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;
            }
    
            // aadhaar photo api
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
    
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,
    
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);
    
    
            // if($get_aadhaar_photo != 'n'){
            //     $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            // }
    
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

                echo json_encode([
                    'responseType' => 1,
                    'message' => '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no
                ]);
                return false;
            }
    
            ///////// additional property starts here
            $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($application_no));
    
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
                            'service_id'          => SETTLEMENT_KHAS_LAND_ID,
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
                                'responseType' => 1,
                                'message' => "#ERROR393: Registration of Settlement failed for case no : ".$application_no
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
                'user_code'=>$user_code,
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
                'review_flag' => $review_number
            );
    
            $insSetBasic = $this->db->insert('settlement_basic', $basic);
            // echo $this->db->last_query(); die();
    
            if ($insSetBasic != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                $data = array(
                    'responseType' => 1,
                    'message'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
    
    
            ////settlement_dag_details insert start
            if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);
                $data = array( 
                    'responseType' => 1,
                    'message'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            foreach ($district['encroachers'] as $dags) {
                $district['class']=$this->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);
    
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
                    'user_code'=>$user_code,
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
                    $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);
    
                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;
    
                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);
    
                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
    
                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
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
                if ($insSetDag != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
    
                //*******insertion in settlement_area_history**************
                if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);
    
                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************
    
    
                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);
    
                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);
    
                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);
    
                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);
    
                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
    
                }
                else
                {
                    //********actual Encroachment area********** 
                    $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);
    
                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************
    
                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);
    
                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);
    
                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);
    
                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);
    
                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
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
                        'responseType' => 1,
                        'message'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
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
                    // fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                    // fclose($aadhaar_file_to_write_base64);
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
                    'user_code'=>$user_code,
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
                if ($insSetApplicant != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#ERR4054: Unable to insert into settlement_applicant:' .$application_no
                    ]);
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
    
                        'user_code'=>$user_code,
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
    
                    if ($insSetEncroacher != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000309: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'responseType' => 1,
                            'message'=>"#ERRSET000309: Registration of Settlement failed for case no : ".$application_no
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
                            'responseType' => 1,
                            'message' => "#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
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
                'reg_by'=>$user_code,
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $basundhar_app = $this->db->insert('basundhar_application',$basundhara);
    
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);                
                $data = array(
                    'responseType' => 1,
                    'message'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }else{

                //insert into relation table
                if($is_review == true && $recordExist){
                    $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                    $old_case_no = $old_case_no_sql->row()->case_no;
                    
                    $relation_tab_arr = [
                        'case_no' => $case_no['case_no'],
                        'old_case_no' => $old_case_no,
                        'application_no' => $application_no,
                        'review_number' => $review_number,
                        'date_entry' => date('Y-m-d H:i:s'),
                        // 'date_update' => 
                    ];

                    $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                    if($rel_insert != 1){
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERR2073: Unable to insert into settlement review!'
                        ]);
                        return false;
                    }
                }
                $this->db->trans_commit();

                echo json_encode([
                    'responseType' => 2,
                    'message' => 'Data successfully saved...'
                ]);
            }
        }
    }

    public function autoRegAp($application_no, $is_review=false){
        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        
        if(!$recordExist || $is_review == true) 
        {
            $review_number = $this->getReviewNumber($application_no, $is_review);

            $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
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
            if(isset(json_decode($output)->responseType))
            {
                if(json_decode($output)->responseType == 3)
                {
                    log_message('error', '- Unauthorized access!');
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#ERR4189: - Unauthorized access!' 
                    ]);
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
            // if($get_aadhaar_photo != 'n'){
            //     $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            // }
    
            $app = $output->application;
            $d   = $app->dist_code;
            $s   = $app->subdiv_code;
            $c   = $app->cir_code;
            $m   = $app->mouza_code;
            $l   = $app->lot_no;
            $v   = $app->village_code;
            $dag = $app->dag_no;

            $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName($d,$s,$c); // generate case name
            if(empty($case_name))
            {
                log_message('error', '#ERR176: Case name can not be generated for application no '.$application_no);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#ERR176: Case name can not be generated for application no '.$application_no
                ]);
                return false;
            }

            //generate case no
            $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
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
                'user_code'                   => 'AUTO',
                'type_of_transfer'            => $type_of_transfer,
                'type_of_patta'               => $type_of_patta,
                'review_flag'                 => $review_number
            ];
            $settlement_basic_insertion = $this->db->insert('settlement_basic',$settlement_basic);
            if($settlement_basic_insertion != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR274: Insertion failed in settlement_basic for RTPS Case No '. $application_no);
              
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#ERR274: Insertion failed in settlement_basic for RTPS Case No '. $application_no
                ]);
                return false;
            }

            //insert into ADDITIONAL PROPERTY
            $checkAdditionalProperty = $this->SettlementAutoRegistrationModel->getAdditionalPropertyDetail($application_no);
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
                            log_message('error', '#ERR314: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);

                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#ERR314: Insertion failed in settlement_additional_property RTPS Case No '.$application_no
                            ]);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT DAG DETAILS
            if(!empty($output->settlements)) {
                foreach($output->settlements as $dag) {
                    if($dag->is_applicant == 1) {

                        $new_land_class = $this->getPattaTypeNo($d,$s,$c,$m,$l,$v,$dag->dag_no);

                        $insSettlementDagDetails = [

                            'dist_code'           => $d,
                            'subdiv_code'         => $s,
                            'cir_code'            => $c,
                            'mouza_pargona_code'  => $m,
                            'lot_no'              => $l,
                            'vill_townprt_code'   => $v,
                            'user_code'           => 'AUTO',
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
                            log_message('error', '#ERR386: Insertion failed in settlement_dag_details for RTPS Case No '. $application_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#ERR386: Insertion failed in settlement_dag_details for RTPS Case No '. $application_no
                            ]);
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
                            // fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            // fclose($aadhaar_file_to_write_base64);
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
                    $cron_no = $this->SettlementAutoRegistrationModel->getPdarCronNo($case_no['case_no']);

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
                        'user_code'         => 'AUTO',
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
                        log_message('error', '#ERR493: Insertion failed in settlement_applicant for RTPS Case No '. $application_no);
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERR493: Insertion failed in settlement_applicant for RTPS Case No '. $application_no
                        ]);
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
                        log_message('error', '#ERR517: Insertion failed in settlement_nominee for RTPS Case No '. $application_no);
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERR517: Insertion failed in settlement_nominee for RTPS Case No '. $application_no
                        ]);

                        return false;
                    }
                }
            }

            //insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree'    => $case_no['case_no'],
                'basundhara'   => $application_no,
                'date_reg'     => date('Y-m-d'),
                'reg_by'       => 'AUTO',
                'app_status'   => 'M',
                'pending_with' => 'CO',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERR539: Insertion failed in Basundhara Application for RTPS Case No '. $application_no);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#ERR539: Insertion failed in Basundhara Application for RTPS Case No '. $application_no
                ]);
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
                log_message('error', '#ERR135: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#ERR135: Insertion failed in settlement_backup_json RTPS Case No '.$application_no
                ]);
                return false;
            }

            //insert into relation table
            if($is_review == true && $recordExist){
                $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                $old_case_no = $old_case_no_sql->row()->case_no;
                
                $relation_tab_arr = [
                    'case_no' => $case_no['case_no'],
                    'old_case_no' => $old_case_no,
                    'application_no' => $application_no,
                    'review_number' => $review_number,
                    'date_entry' => date('Y-m-d H:i:s'),
                    // 'date_update' => 
                ];

                $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                if($rel_insert != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#ERR2073: Unable to insert into settlement review!'
                    ]);
                    return false;
                }
            }

            $this->db->trans_commit(); // transaction ends here

            echo json_encode([
                'responseType' => 2,
                'message' => 'Data successfully saved...'
            ]);
        }
    }


    public function autoRegVgr($application_no, $is_review=false){
        $recordExist = $this->SettlementAutoRegistrationModel->checkExistDharitree($application_no);
        
        if(!$recordExist || $is_review==true)
        {
            $review_number = $this->getReviewNumber($application_no, $is_review);

            $token = $this->SettlementAutoRegistrationModel->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
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
                    echo json_encode([
                        'responseType' => 1,
                        'message' => json_decode($output)->data." - Unauthorized access!"
                    ]);
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);

            //******strating the insertation transaction */
            $this->db->trans_begin();

            $case_name=$this->SettlementAutoRegistrationModel->genearteCaseName();
            if(empty($case_name)){
                $data=array(
                    'responseType' => 1,
                    'message'=>"Network Issue or Seesion Out. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

            $d=$output->application->dist_code;
            $s=$output->application->subdiv_code;
            $c=$output->application->cir_code;
            $m=$output->application->mouza_code;
            $l=$output->application->lot_no;
            $v=$output->application->village_code;
            
            $user_code= $this->SettlementAutoRegistrationModel->EnabledMondalName($d, $s, $c,$m,$l);
            if ($user_code == null)
               $user_code = 'AUTO';
            else 
                $user_code = $user_code->lm_code;

            //*******************Creating petition no and case_no */
            $case_no['petition_no']=$petition_no=$this->SettlementAutoRegistrationModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_PGR_VGR_LAND;

            //******************insertion in settlement_json_backup(LM) */
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

                echo json_encode([
                    'responseType' => 1,
                    'message' => "#BACKUP001: Registration of Settlement failed for case no : ".$application_no
                ]);
                return false;
            }

            
            

            //*************insertion into settlement_additional_property */
            $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($application_no));
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
                            'service_id'          => SETTLEMENT_PGR_VGR_LAND_ID,
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
                                'responseType' => 1,
                                'message'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            //*******insertion into settlement_basic */
            foreach($output->settlements as $settlementsInsertion)
            {
                if($settlementsInsertion->is_applicant == 1)
                {
                    //*********protected_category/tribe_category */
                    if(isset($settlementsInsertion->tribe_category))
                    {
                        if($settlementsInsertion->tribe_category || $settlementsInsertion->tribe_category == '' || $settlementsInsertion->tribe_category == 0)
                        {
                            $protected_class = $settlementsInsertion->tribe_category;
                        }
                        else
                        {
                            $protected_class = 0;
                        }
                    }
                    else
                    {
                        $protected_class = 0;
                    }

                    //***********applicant_occupation */
                    $applicant_occupation = $settlementsInsertion->applicant_occupation;
                    $caste_category = $settlementsInsertion->caste_category;
                    $applied_scheme = $settlementsInsertion->applied_scheme;
                    $tribal_belt = $settlementsInsertion->under_tribe_belts;

                }
            }

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
                'dist_code'                     => $output->application->dist_code,
                'subdiv_code'                   => $output->application->subdiv_code,
                'cir_code'                      => $output->application->cir_code,
                'mouza_pargona_code'            => $output->application->mouza_code,
                'lot_no'                        => $output->application->lot_no,
                'vill_townprt_code'             => $output->application->village_code,
                'service_code'                  => $output->application->service_code,
                'ref_no'                        => $output->application->ref_no,
                'case_no'                       => $case_no['case_no'],
                'trans_code'                    => 'F',/////////full
                'petition_no'                   => $case_no['petition_no'],
                'year_no'                       => date('Y'),
                'date_entry'                    => date('Y-m-d G:i:s'),
                'status'                        =>'Z',
                'user_code'                     => $user_code,
                'submission_date'               => date('Y-m-d G:i:s'),
                'from_office'                   => 'API',
                'pending_officer'               => 'LM',
                'pending_office'                => 'CO',
                'tribal_belt'                   => $tribal_belt,
                'occupation_applicant'          => $applicant_occupation,
                'applid'                        => $output->application->application_no,
                'caste'                         => $caste_category,
                'uuid'                          => $output->application->uuid,
                'protected_class'               => $protected_class,
                'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                'applied_scheme'                => $applied_scheme,
                'review_flag'                   => $review_number
            );

            $insSetBasic = $this->db->insert('settlement_basic', $basic);

            if ($insSetBasic != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                $data = array(
                    'responseType' => 1,
                    'message'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            //*********creating the cron number for applicant */
            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '$c_n'";
            $result = $this->db->query($sql)->row();
            if($result == true)
            {
                $cron_no = (int)$result->pdar_cron_no + 1;
            }
            else
            {
                $cron_no = 1;
            }

            //**********fetching aadhaar from API */
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no'             => $application_no,
            )));
            $get_aadhaar_photo = curl_exec($curl_handle);
            curl_close($curl_handle);

            //***********inserting settlement_applicant(Buyers) */
            foreach($output->applicants as $settlementAppInsert){

                if ($get_aadhaar_photo != 'n' && $settlementAppInsert->is_applicant == '1') {
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
                if($output->aadhar->type == 'AADHAAR'){
                    $identity_ref_no = $output->aadhar->aadhaar_no;
                }else{
                    $identity_ref_no = $output->aadhar->pan_no;
                }

                $applicant=array(
                    'dist_code'             => $output->application->dist_code,
                    'subdiv_code'           => $output->application->subdiv_code,
                    'cir_code'              => $output->application->cir_code,
                    'mouza_pargona_code'    => $output->application->mouza_code,
                    'lot_no'                => $output->application->lot_no,
                    'vill_townprt_code'     => $output->application->village_code,
                    'user_code'             => $user_code,
                    'case_no'               => $case_no['case_no'],
                    'petition_no'           => $case_no['petition_no'],
                    'operation'             => 'E',
                    'dag_no'                => 0,
                    'patta_no'              => 0,
                    'patta_type_code'       => 0,
                    'year_no'               => date('Y'),
                    'date_entry'            => date('Y-m-d'),
                    'pdar_id'               => -1,
                    'pdar_cron_no'          => (int) $cron_no++,
                    'pdar_name'             => $settlementAppInsert->name_ass,
                    'eng_pdar_name'         => $settlementAppInsert->name_eng,
                    'pdar_guardian'         => $settlementAppInsert->gurdian_name_ass,
                    'eng_pdar_guardian'     => $settlementAppInsert->gurdian_name_eng,
                    'pdar_rel_guar'         => $settlementAppInsert->gurdian_relation_id,
                    'pdar_gender'           => $settlementAppInsert->gender,
                    'pdar_add1'             => $settlementAppInsert->pre_add,
                    'pdar_add2'             => $settlementAppInsert->per_add,
                    'pdar_mobile'           => $settlementAppInsert->mobile,
                    'pdar_type'             => $settlementAppInsert->pdar_type,
                    'is_applicant'          => $settlementAppInsert->is_applicant,
                    'identity_ref_no'       => $identity_ref_no,
                    'identity_type'         => $output->aadhar->type,
                    'identity_doc_link'     => $aadhar_path,
                    'dob'                   => $settlementAppInsert->dob,
                    'marital_status'        => $settlementAppInsert->marital_status
                );

                $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);

                if($insSetApplicant != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }
          
            //************inserting settlement_applicant(Encroacher) */
            foreach($output->encroachers as $enc_applicant){
                $encroacher_app=array(
                    'dist_code'                => $output->application->dist_code,
                    'subdiv_code'              => $output->application->subdiv_code,
                    'cir_code'                 => $output->application->cir_code,
                    'mouza_pargona_code'       => $output->application->mouza_code,
                    'lot_no'                   => $output->application->lot_no,
                    'vill_townprt_code'        => $output->application->village_code,
                    'user_code'                => $user_code,
                    'case_no'                  => $case_no['case_no'],
                    'petition_no'              => $case_no['petition_no'],
                    'operation'                => 'E',
                    'dag_no'                   => $enc_applicant->dag_no,
                    'patta_no'                 => $enc_applicant->patta_no,
                    'patta_type_code'          => $enc_applicant->patta_code,
                    'period_possession'        => $enc_applicant->possession_date,
                    'year_no'                  => date('Y'),
                    'date_entry'               => date('Y-m-d'),
                    'pdar_name'                => $enc_applicant->name_ass,
                    'pdar_guardian'            => $enc_applicant->gurdian_name_ass,
                    'pdar_rel_guar'            => '0',
                    'pdar_cron_no'             => (int) $cron_no++,
                    'pdar_id'                  => -1,
                    'pdar_type'                => 'EN',
                    'enc_id'                   => $enc_applicant->encroacher_id
                );
                $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                if($insSetEncroacher != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'mesasge'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }

            //********inserting settlement_dag_details */
            foreach ($output->encroachers as $dags) {
                $district['class']=$this->getPattaTypeNo($output->application->dist_code, $output->application->subdiv_code, $output->application->cir_code, $output->application->mouza_code, $output->application->lot_no, $output->application->village_code, $dags->dag_no);

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
                    'dist_code'             => $output->application->dist_code,
                    'subdiv_code'           => $output->application->subdiv_code,
                    'cir_code'              => $output->application->cir_code,
                    'mouza_pargona_code'    => $output->application->mouza_code,
                    'lot_no'                => $output->application->lot_no,
                    'vill_townprt_code'     => $output->application->village_code,
                    'user_code'             => $user_code,
                    'date_entry'            => date('Y-m-d'),
                    'case_no'               => $case_no['case_no'],
                    'petition_no'           => $case_no['petition_no'],
                    'year_no'               => date('Y'),
                    'new_land_class_code'   => $district['class']->land_class_code,
                    'dag_no'                => $dags->dag_no, 
                    'patta_no'              => $dags->patta_no, 
                    'patta_type_code'       => $dags->patta_code,  
                    'is_urban'              => $output->application->is_urban,
                    'land_type'             => $dags->land_type,
                    'revenue'               => 0,
                    'operation'             => 'E',
                    'encroachement_area'    => json_encode($encroachment_area)
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
                if (in_array($output->application->dist_code, json_decode(BARAK_VALLEY))){
                    //******for Barak valley */
                    $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                    $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                    $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                }
                else
                {
                    $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                    $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
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
                if ($insSetDag != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //*******insertion in settlement_area_history**************
                if (in_array($output->application->dist_code, json_decode(BARAK_VALLEY))){
                    //***********actual Encroachment area ***************
                    $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                    $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                    // **********************************************


                    //***********Settlement area that applicant will get settlement on***********
                    $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                    $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                    //*****total Settlement area *************/
                    $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                    //*************leftout area homestead**************
                    $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                    //**********Ileftout area agriculture**************
                    $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                    //**********Total left out area***************
                    $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

                }
                else
                {
                    //********actual Encroachment area********** 
                    $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                    $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                    //***********total Actual Encroachment area*****************
                    $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                    $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                    // **********************************************

                    //*******Settlement area that applicant will get settlement on**********
                    $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                    $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                    //*************Total settlement area */
                    $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                    $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                    //****************leftout area homestead**************
                    $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                    $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                    //*************leftout area agriculture*****************
                    $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                    $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                    //**********Total left out area***************
                    $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                    $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                }

                $settlementAreaHistoryArr = [
                    'application_no'                        => $application_no,
                    'case_no'                               => $case_no['case_no'],
                    'dag_no'                                => $dags->dag_no,
                    'uuid'                                  => $output->application->uuid,
                    'created_at'                            => date('Y-m-d'),
                    'applied_area_home_bigha'               => $dags->mbigha,
                    'applied_area_home_katha'               => $dags->mkatha,
                    'applied_area_home_lessa'               => $dags->mlessa,
                    'applied_area_home_ganda'               => $dags->mganda,
                    'applied_area_home_kranti'              => $dags->mkranti,
                    'applied_area_agri_bigha'               => $dags->agri_bigha,
                    'applied_area_agri_katha'               => $dags->agri_katha,
                    'applied_area_agri_lessa'               => $dags->agri_lessa,
                    'applied_area_agri_ganda'               => $dags->agri_ganda,
                    'applied_area_agri_kranti'              => $dags->agri_kranti,
                    'actual_encroachment_area_home_bigha'   => $enc_home_bigha,
                    'actual_encroachment_area_home_katha'   => $enc_home_katha,
                    'actual_encroachment_area_home_lessa'   => $enc_home_lessa,
                    'actual_encroachment_area_home_ganda'   => $enc_home_ganda,
                    'actual_encroachment_area_home_kranti'  => $enc_home_kranti,
                    'actual_encroachment_area_agri_bigha'   => $enc_agri_bigha,
                    'actual_encroachment_area_agri_katha'   => $enc_agri_katha,
                    'actual_encroachment_area_agri_lessa'   => $enc_agri_lessa,
                    'actual_encroachment_area_agri_ganda'   => $enc_agri_ganda,
                    'actual_encroachment_area_agri_kranti'  => $enc_agri_kranti,
                    'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
                    'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
                    'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
                    'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
                    'total_actual_encroachment_area_kranti' => 0,
                    'settlement_area_home_bigha'            => $fmd['home_b'],
                    'settlement_area_home_katha'            => $fmd['home_k'],
                    'settlement_area_home_lessa'            => $fmd['home_lc'],
                    'settlement_area_home_ganda'            => $fmd['home_g'],
                    'settlement_area_home_kranti'           => $fmd['home_kr'],
                    'settlement_area_agri_bigha'            => $fmd['agri_b'],
                    'settlement_area_agri_katha'            => $fmd['agri_k'],
                    'settlement_area_agri_lessa'            => $fmd['agri_lc'],
                    'settlement_area_agri_ganda'            => $fmd['agri_g'],
                    'settlement_area_agri_kranti'           => $fmd['agri_kr'],
                    'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
                    'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
                    'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
                    'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
                    'total_settlement_area_kranti'          => 0,
                    'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
                    'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
                    'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
                    'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
                    'leftout_area_home_kranti'              => 0,
                    'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
                    'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
                    'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
                    'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
                    'leftout_area_agri_kranti'              => 0,
                    'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0], 
                    'total_leftout_area_katha'              => $totalLeftOutAreaArr[1], 
                    'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2], 
                    'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3], 
                    'total_leftout_area_kranti'             => 0,
                ];

                $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
            
                if ($insertSetlArea != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                    $data = array(
                        'responseType' => 1,
                        'message'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                } 

                //**************end of settlement_area_history********************
            }

            //******insertion in settlement_nominee */
            if ($output->nextKin == true) {
                foreach ($output->nextKin as $nex_of_kin) {
                    $nominee_data=array(
                        'case_no'=> $case_no['case_no'],
                        'nominee_name' => $nex_of_kin->next_of_kin_name,
                        'address' => $nex_of_kin->address,
                        'mobile_no' => $nex_of_kin->mobile_no,
                        'relation' => $nex_of_kin->relation_with_kin
                    );
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                    if ($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                        $data = array(
                            'responseType' => 1,
                            'message'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            //********basundhar_application insertation */
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$user_code,
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                $data = array(
                    'responseType'=>1,
                    'message'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }else{

                //insert into relation table
                if($is_review == true && $recordExist){
                    $old_case_no_sql = $this->db->query('select case_no from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
                    $old_case_no = $old_case_no_sql->row()->case_no;
                    
                    $relation_tab_arr = [
                        'case_no' => $case_no['case_no'],
                        'old_case_no' => $old_case_no,
                        'application_no' => $application_no,
                        'review_number' => $review_number,
                        'date_entry' => date('Y-m-d H:i:s'),
                        // 'date_update' => 
                    ];

                    $rel_insert = $this->db->insert('settlement_review_relation', $relation_tab_arr);
                    if($rel_insert != 1){
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#ERR2073: Unable to insert into settlement review!'
                        ]);
                        return false;
                    }
                }

                //******commit if no errors */
                $this->db->trans_commit();

                echo json_encode([
                    'responseType' => 2,
                    'message' => 'Data successfully saved...'
                ]);
            }
        }
    }


    public function getRejectedReasons($application_no){
        $sql_basic = $this->db->query('select * from settlement_basic where applid = ? and status = ?', array($application_no, 'D'));
        if($sql_basic->num_rows() <= 0){
            echo json_encode([
                'responseType' => 1,
                'message' => '#ERR4635: No rejected case found!'
            ]);
            return false;
        }

        $basic_row = $sql_basic->row();
        $case_no = $basic_row->case_no;

        $sql_rejected_remark = $this->db->query('select * from rejected_remark where case_no = ?', array($case_no));
        if($sql_rejected_remark->num_rows() <= 0){
            echo json_encode([
                'responseType' => 1,
                'message' => '#ERR4647: Rejected reason not found!'
            ]);
            return false;
        }

        $rejected_remark_result = $sql_rejected_remark->result();

        foreach($rejected_remark_result as $rm){
            $reject_code_arr[] = $rm->reject_code;      
        }

        $r_codes = "'" . implode("','", $reject_code_arr) . "'";
        
        $sql_reject_master = $this->db->query("select STRING_AGG(remark, ', ') AS remarks from reject_master where reject_code in ($r_codes)", array($r_codes));

        if($sql_reject_master->num_rows() <= 0){
            echo json_encode([
                'responseType' => 1,
                'message' => '#ERR4665: Rejected reason not found!'
            ]);
            return false;
        }

        $sql_reject_ee = $this->db->query("select remark_head from reject_master where reject_code in ($r_codes) and remark_head is not null", array($r_codes));

        if($sql_reject_ee->num_rows() <= 0){
            echo json_encode([
                'responseType' => 1,
                'message' => '#ERR5560: Rejected reason not found!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'data' =>  $sql_reject_master->row()->remarks,
            'remark_head' =>  $sql_reject_ee->result()->remark_head
        ]);
    }




}
