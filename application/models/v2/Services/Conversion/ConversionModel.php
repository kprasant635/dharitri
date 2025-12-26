<?php
    class ConversionModel extends CI_Model {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('v2/ChithaBasicModel');
            $this->load->model('v2/PetitionBasicModel');
            $this->load->model('v2/PetitionDagDetailsModel');
            $this->load->model('v2/MasterOfficeMutationTypeModel');
            $this->load->model('v2/PattacodeModel');
            $this->load->model('v2/PetitionerPartModel');
            $this->load->model('v2/PetitionProceedingModel');
            $this->load->model('v2/BasundharApplicationModel');
            $this->load->model('v2/PetitionLmNoteModel');
            $this->load->model('v2/PremiumChalanReceiptModel');
            $this->load->model('v2/LandclassCodeModel');
            $this->load->model('v2/LmCodeModel');
            $this->load->model('v2/LocationModel');
            $this->load->model('v2/MasterGenderModel');
            $this->load->model('v2/MasterUserDesignationModel');
            $this->load->model('v2/MasterGuardianRelationModel');
            $this->load->model('v2/ChithaDagPattadarModel');
            $this->load->model('v2/ConversionPremiumAreasModel');
            $this->load->model('v2/ConversionPremiumAreaPurposeTypeModel');
            $this->load->model('v2/ConversionPremiumRatesModel');
            $this->load->model('v2/UsersModel');
            $this->load->model('rtps/RtpsModel');
            $this->load->model('v2/SupportiveDocumentModel');
            $this->load->model('validation/AuthorizationModel');
            
        }

        public function getSessionLocation() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
            $lot_no = $this->session->userdata('lot_no1');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
            $user_code=$this->session->userdata('user_code');

            return ['dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 'lot_no'=>$lot_no, 'vill_townprt_code'=>$vill_townprt_code, 'user_code'=>$user_code];
        }

        public function getCoName() {
            $sessionData = $this->getSessionLocation();
            return $this->utilityclass->getSelectedCOName($sessionData['dist_code'],$sessionData['subdiv_code'],$sessionData['cir_code'],$sessionData['user_code']);
        }

        public function getCoNameForAll($dist_code, $subdiv_code, $cir_code) {
            return $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code);
        }

        public function getPetitionBasicData($case_no) {
            $sessionData = $this->getSessionLocation();
            return $this->PetitionBasicModel->get(['case_no'=>$case_no, 'dist_code'=>$sessionData['dist_code'], 'subdiv_code'=>$sessionData['subdiv_code'], 'cir_code'=>$sessionData['cir_code'], 'mouza_pargona_code'=>$sessionData['mouza_pargona_code'], 'lot_no'=>$sessionData['lot_no'], 'vill_townprt_code'=>$sessionData['vill_townprt_code']]);
        }

        public function getLandDetails($case_no) {
            $sessionData = $this->getSessionLocation();
            $petition_basic = $this->getPetitionBasicData($case_no);

            return $this->PetitionDagDetailsModel->get(['dist_code'=>$sessionData['dist_code'], 'subdiv_code'=>$sessionData['subdiv_code'], 'cir_code'=>$sessionData['cir_code'], 'mouza_pargona_code'=>$sessionData['mouza_pargona_code'], 'lot_no'=>$sessionData['lot_no'], 'vill_townprt_code'=>$sessionData['vill_townprt_code'], 'petition_no'=>$petition_basic->petition_no], 'dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code');
        }

        public function getPattadarDetails($case_no) {
            $petition_basic = $this->getPetitionBasicData($case_no);
            $landdetails = $this->getLandDetails($case_no);

            return $this->PetitionerPartModel->get(['dist_code'=>$petition_basic->dist_code, 'subdiv_code'=>$petition_basic->subdiv_code, 'cir_code'=>$petition_basic->cir_code, 'lot_no'=>$petition_basic->lot_no, 'vill_townprt_code'=>$petition_basic->vill_townprt_code, 'mouza_pargona_code'=>$petition_basic->mouza_pargona_code, 'petition_no'=>$petition_basic->petition_no, 'dag_no'=>$landdetails->dag_no, 'TRIM(patta_no)'=>trim($landdetails->patta_no), 'patta_type_code'=>$landdetails->patta_type_code], 'auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2', 'multiple');
        }

        public function getSessionLocationName($case_no) {
            $petition_basic = $this->getPetitionBasicData($case_no);

            $dist_name = $this->utilityclass->getDistrictName($petition_basic->dist_code);
            $subdiv_name = $this->utilityclass->getSubDivName($petition_basic->dist_code, $petition_basic->subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code);
            $mouza_pargona_name = $this->utilityclass->getMouzaName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code);
            $lot_name = $this->utilityclass->getLotName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no);
            $vill_townprt_name = $this->utilityclass->getVillageName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code);

            return ['dist_name'=>$dist_name, 'subdiv_name'=>$subdiv_name, 'cir_name'=>$cir_name, 'mouza_pargona_name'=>$mouza_pargona_name, 'lot_name'=>$lot_name, 'vill_townprt_name'=>$vill_townprt_name];

        }

        public function getConversionType($conversion_code) {
            return $this->MasterOfficeMutationTypeModel->get(['order_type_code'=>$conversion_code], 'order_type')->order_type;
        }

        public function getPattaType($case_no) {
            $landdetails = $this->getLandDetails($case_no);
            return $this->PattacodeModel->get_the_patta(['type_code'=>$landdetails->patta_type_code])->patta_type;
        }

        public function getLmDetails($case_no) {
            $petition_basic = $this->getPetitionBasicData($case_no);
            return $this->PetitionLmNoteModel->getLatest(['dist_code'=>$petition_basic->dist_code, 'subdiv_code'=>$petition_basic->subdiv_code, 'cir_code'=>$petition_basic->cir_code, 'lot_no'=>$petition_basic->lot_no, 'vill_townprt_code'=>$petition_basic->vill_townprt_code, 'mouza_pargona_code'=>$petition_basic->mouza_pargona_code, 'petition_no'=>$petition_basic->petition_no]);
        }

        public function getLandClassType($case_no) {
            $lmDetails = $this->getLmDetails($case_no);
            if(!empty($lmDetails)) {
                return $this->LandclassCodeModel->get_the_land_class(['class_code'=>$lmDetails->land_class_code]);
            }
            else{
                return null;
            }
        }

        public function getLmName($lm_code) {
            $sessionData = $this->getSessionLocation();
            return $this->LmCodeModel->get(['lm_code'=>$lm_code, 'dist_code'=>$sessionData['dist_code'], 'subdiv_code'=>$sessionData['subdiv_code'], 'cir_code'=>$sessionData['cir_code'], 'mouza_pargona_code'=>$sessionData['mouza_pargona_code'], 'lot_no'=>$sessionData['lot_no']]);
        }

        public function checkExistDharitree($application_no){
            $applicationCounts = $this->BasundharApplicationModel->getExistingApplicationsByBasundhara($application_no);
            $dataFound = false;
            if($applicationCounts->app_count > 0) {
                $dataFound = true;
            }
            return $dataFound;
            // $sql="Select count(*) as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
            // $dataFound=$this->db->query($sql)->row();
            // if($dataFound->c >0){
            //     $dataFound=$dataFound->c;
            // }else{
            //     $dataFound=null;
            // }
            // return $dataFound;
        }

        function getBasundharaLink($application_no){
            $linkAvail=$application_no;
            
            $url = API_LINK_MB3."uploadfileName?case=" . $linkAvail;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output = json_decode($output); 
        }

        function searchBasundharaLink($case_no){
            $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
             $linkAvail=$this->db->query($sql)->row();
            if($linkAvail){
                $linkAvail=$linkAvail->basundhara;
                if($linkAvail){
                $url = API_LINK_MB3."uploadfileName?case=" . $linkAvail;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                return $output = json_decode($output); 
                }else {
                    return false;
                }
            }
            
        }

        public function checkTransCode($application_no) {
            $appDetails = $this->RtpsModel->getApplicationDetails($application_no);
            $application = $appDetails->application;
            $chithaBasicDetails = $this->ChithaBasicModel->get([
                'dist_code'=>$application->dist_code,
                'subdiv_code'=>$application->subdiv_code,
                'cir_code'=>$application->cir_code,
                'mouza_pargona_code'=>$application->mouza_code,
                'lot_no'=>$application->lot_no,
                'vill_townprt_code'=>$application->village_code,
                'dag_no_int'=>$application->dag_no
            ]);
            $barak_districts = json_decode(BARAK_VALLEY);

            if(!in_array($chithaBasicDetails->dist_code, $barak_districts)) {
                $chitha_bigha = $chithaBasicDetails->dag_area_b * 5 * 20;
                $chitha_katha = $chithaBasicDetails->dag_area_k * 20;
                $chitha_lessa = $chithaBasicDetails->dag_area_lc;

                $mutated_bigha = $appDetails->mutation[0]->area_b * 5 * 20;
                $mutated_katha = $appDetails->mutation[0]->area_k * 20;
                $mutated_lessa = $appDetails->mutation[0]->area_lc;
    
                // unit in lessa
                $chitha_area = $chitha_bigha + $chitha_katha + $chitha_lessa;
                $mutated_area = $mutated_bigha + $mutated_katha + $mutated_lessa;

            }
            else {
                $chitha_bigha = $chithaBasicDetails->dag_area_b * 6400;
                $chitha_katha = $chithaBasicDetails->dag_area_k * 320;
                $chitha_lessa = $chithaBasicDetails->dag_area_lc * 20;
                $chitha_ganda = $chithaBasicDetails->dag_area_g;

                $mutated_bigha = $appDetails->mutation[0]->area_b * 6400;
                $mutated_katha = $appDetails->mutation[0]->area_k * 320;
                $mutated_lessa = $appDetails->mutation[0]->area_lc * 20;
                $mutated_ganda = $appDetails->mutation[0]->area_g;
                
                //unit in ganda
                $chitha_area = $chitha_bigha + $chitha_katha + $chitha_lessa + $chitha_ganda;
                $mutated_area = $mutated_bigha + $mutated_katha + $mutated_lessa + $mutated_ganda;
            }

            if($mutated_area != $chitha_area) {
                return 'P';
            }
            else {
                return 'F';
            }
            
        }

        public function address($full_address){
            //if less then 100
            if (strlen($full_address)<100) 
            {
              $address[0]= $full_address;
              $address[1] = null;
              return $address;    
            }
            //if more then 100 containing ',' or space separator
            $sub_address = substr($full_address,0,100);
            $pos = strrpos($sub_address,","); 
            if (!$pos)
            {
                $pos = strrpos($sub_address," "); 
            }
            
            $address[1] = substr($full_address,$pos+1,strlen($full_address));
            $address[0]= substr($full_address,0,$pos);            
            return $address;               
        }

        public function getMaxProceedingId($case_no) {
            $max = $this->db->query("SELECT max(proceeding_id) FROM petition_proceeding WHERE case_no=?", [$case_no])->row()->max;
            return $max + 1;
        }

        public function DashboardData($case_no,$penUser,$rmrk){
            //////////////Update Dashboard Database///////////////////////
            $this->dbb = $this->load->database('dash', TRUE);
            $base=array(
                'pending_with_user' => $penUser,
                'date_of_update'=>date("Y-m-d h:i:s")
            );
            $this->dbb->where('case_no',$case_no);
            $this->dbb->update('dashboard_data',$base);
            $action= array(
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date("Y-m-d h:i:s"),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => $rmrk,
                'ip_address'=>$this->utilityclass->get_client_ip()
                    );
            $this->dbb->insert('dashboard_action',$action);


            $this->db->where('case_no',$case_no);

            $this->db->update('dashboard_data',$base);
            /////////////////////////////////////
        }

        public function getSinglePattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id) {
            $pdarDetails = $this->ChithaDagPattadarModel->getSinglePattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $pdar_id);
            // $pdarDetails->pdar_guard_reln_name = "";
            // $pdarDetails->pdar_gender_name = "";
            // if(trim($pdarDetails->pdar_guard_reln) != "" && $pdarDetails->pdar_guard_reln != null) {
            //     $pdarDetails->pdar_guard_reln_name = $this->MasterGuardianRelationModel->getByRelation($pdarDetails->pdar_guard_reln)->guard_rel_desc_as;
            // }
            // if($pdarDetails->pdar_gender != null && trim($pdarDetails->pdar_gender) != "") {
            //     $pdarDetails->pdar_gender_name = $this->MasterGenderModel->getByShortName($pdarDetails->pdar_gender);
            // }

            return $pdarDetails;
        }

       
        // public function getApplicationData($case_no) {
        //     $conversion_code = CONVERSION_CODE;
        //     $coname = $this->getCoName();
        //     $petition_basic = $this->getPetitionBasicData($case_no);
        //     $landdetails = $this->getLandDetails($case_no);
        //     $sessionLocationName = $this->getSessionLocationName($case_no);
        //     $conv_type = $this->getConversionType($conversion_code);
        //     $patta_type = $this->getPattaType($case_no);
        //     $pattadars = $this->getPattadarDetails($case_no);
        //     $m_dag_area_lc = round($landdetails->m_dag_area_lc, 2);

        //     $data['land_details'] = array(
        //         'dag' => $landdetails->dag_no,
        //         'm_dag_area_b' => $landdetails->m_dag_area_b,
        //         'm_dag_area_k' => $landdetails->m_dag_area_k,
        //         'm_dag_area_lc' => $m_dag_area_lc,
        //         'patta_no' => trim($landdetails->patta_no),
        //         'patta_type' => $landdetails->patta_type_code
        //     );
        //     $data['location'] = array(
        //         'dist' => $sessionLocationName['dist_name'],
        //         'sub' => $sessionLocationName['subdiv_name'],
        //         'cir' => $sessionLocationName['cir_name'],
        //         'mouza' => $sessionLocationName['mouza_pargona_name'],
        //         'lot' => $sessionLocationName['lot_name'],
        //         'vill' => $sessionLocationName['vill_townprt_name'],
        //         'case_no' => $case_no,
        //         'date' => $petition_basic->date_entry,
        //         'add_to' => $coname->username,
        //         'next_date' => $petition_basic->next_date_of_hearing,
        //         'sk_comment' => $petition_basic->sk_comment,
        //         'dag' => $landdetails->dag_no,
        //         'm_dag_area_b' => $landdetails->m_dag_area_b,
        //         'm_dag_area_k' => $landdetails->m_dag_area_k,
        //         'm_dag_area_lc' => $m_dag_area_lc,
        //         'patta_no' => trim($landdetails->patta_no),
        //         'patta_type' => $landdetails->patta_type_code,
        //     );
        //     $data['conv_type'] = $conv_type;
        //     $data['patta_type'] = $patta_type;
        //     $data['pattadar'] = $pattadars;
        //     // $data['p_in_order'] = $pattadars;
        //     return $data;
        // }

        public function getLMReportData($case_no) {
            $coname = $this->getCoName();
            $petition_basic = $this->getPetitionBasicData($case_no);
            $landdetails = $this->getLandDetails($case_no);
            $sessionLocationName = $this->getSessionLocationName($case_no);
            $m_dag_area_lc = round($landdetails->m_dag_area_lc, 2);
            $lmDetails = $this->getLmDetails($case_no);
            $data = [];
            if(!empty($lmDetails)) {
                $landType = $this->getLandClassType($case_no);
                $lm_name = $this->getLmName($lmDetails->lm_code);
                $prim_per_bigha = round($lmDetails->prim_per_bigha, 2);
                $prim_tot = round($lmDetails->prim_tot, 2);

                $data['lm_name'] = $lm_name->lm_name;
                $data['lm_details'] = array(
                    //'petition_no' => $lm_details[''],
                    'dag_no' => $lmDetails->dag_no,
                    'note_no' => $lmDetails->note_no,
                    'partition_info' => $lmDetails->partition_info,
                    //'user_code' => $lm_details[''],
                    'date_entry' => $lmDetails->date_entry,
                    //'operation' => $lm_details[''],
                    'applicant_patta_yn' => $lmDetails->applicant_patta_yn,
                    'occupied_yn' => $lmDetails->occupied_yn,
                    'val_tree_yn' => $lmDetails->val_tree_yn,
                    'dist_frm_town' => $lmDetails->dist_frm_town,
                    'inside_outside_town' => $lmDetails->inside_outside_town,
                    'land_class_code' => $landType->land_type,
                    'issuit_forconv_under105' => $lmDetails->issuit_forconv_under105,
                    'roadside_rsv_b' => $lmDetails->roadside_rsv_b,
                    'roadside_rsv_k' => $lmDetails->roadside_rsv_k,
                    'roadside_rsv_lc' => $lmDetails->roadside_rsv_lc,
                    'near_river_yn' => $lmDetails->near_river_yn,
                    'prim_per_bigha' => $prim_per_bigha,
                    'conv_b' => $lmDetails->conv_b,
                    'conv_k' => $lmDetails->conv_k,
                    'conv_lc' => $lmDetails->conv_lc,
                    'prim_tot' => $prim_tot,
                    'lm_sign_yn' => $lmDetails->lm_sign_yn,
                    'case_no' => $case_no,
                    'lm_code' => $lmDetails->lm_code,
                    'sk_note_date' => $lmDetails->sk_note_date,
                    'sk_note' => $lmDetails->sk_note,
                    'sk_sign_yn' => $lmDetails->sk_sign_yn,
                    'sk_name' => $lmDetails->user_code,
                    'jati_janajati_yn' => $lmDetails->jati_janajati_yn,
                    'jati_janajati_upload' => $lmDetails->jati_janajati_upload,
                    'freedom_fighter_yn' => $lmDetails->freedom_fighter_yn,
                    'freedom_fighter_upload' => $lmDetails->freedom_fighter_upload,
                    'widow_yn' => $lmDetails->widow_yn,
                    'widow_upload' => $lmDetails->widow_upload,
                    'premium_assesment' => $lmDetails->premium_assesment
                );
                $data['land_details'] = array(
                    'dag' => $landdetails->dag_no,
                    'm_dag_area_b' => $landdetails->m_dag_area_b,
                    'm_dag_area_k' => $landdetails->m_dag_area_k,
                    'm_dag_area_lc' => $m_dag_area_lc,
                    'patta_no' => trim($landdetails->patta_no),
                    'patta_type' => $landdetails->patta_type_code
                );
                $data['lm_details_final'] = $lmDetails;
                $data['location'] = array(
                    'dist' => $sessionLocationName['dist_name'],
                    'sub' => $sessionLocationName['subdiv_name'],
                    'cir' => $sessionLocationName['cir_name'],
                    'mouza' => $sessionLocationName['mouza_pargona_name'],
                    'lot' => $sessionLocationName['lot_name'],
                    'vill' => $sessionLocationName['vill_townprt_name'],
                    'case_no' => $case_no,
                    'date' => $petition_basic->date_entry,
                    'add_to' => $coname->username,
                    'next_date' => $petition_basic->next_date_of_hearing,
                    'sk_comment' => $petition_basic->sk_comment,
                    'dag' => $landdetails->dag_no,
                    'm_dag_area_b' => $landdetails->m_dag_area_b,
                    'm_dag_area_k' => $landdetails->m_dag_area_k,
                    'm_dag_area_lc' => $m_dag_area_lc,
                    'patta_no' => trim($landdetails->patta_no),
                    'patta_type' => $landdetails->patta_type_code,
                );
            }
            return $data;
        }

        public function getApplicationDataForCOFirst($case_no) {
            $application_no = $case_no;
            $appDetails = $this->RtpsModel->getApplicationDetails($application_no);
            // echo '<pre>';
            // var_dump($appDetails);
            // die();
            
            $data['app'] =  $application = $appDetails->application;
            $selfDeclaration =  null;
            $applicants = null;
            $mutation = null;
            $documents = null;
            $query = null;
            $photo = null;
            $aadharData = null;
            $conversion_code = CONVERSION_CODE;

            if(isset($appDetails->selfDeclaration) && !empty($appDetails->selfDeclaration)) {
                $selfDeclaration = $appDetails->selfDeclaration;
            }
            if(isset($appDetails->mutation) && !empty($appDetails->mutation)) {
                $mutation = $appDetails->mutation;
            }
            if(isset($appDetails->applicants) && !empty($appDetails->applicants)) {
                $applicants = $appDetails->applicants;
            }
            if(isset($appDetails->documents) && !empty($appDetails->documents)) {
                $documents = $appDetails->documents;
            }
            if(isset($appDetails->query) && !empty($appDetails->query)) {
                $query = $appDetails->query;
            }
            if(isset($appDetails->photo) && $appDetails->photo != null) {
                $photo = $appDetails->photo;
            }

            if($selfDeclaration != null) {
                $data['selfDecData'] = json_decode($selfDeclaration[0]->dec_details);
            }

            if($mutation != null) {
                foreach ($mutation as $value) {
                    if(isset($value->auth_type) && $value->auth_type !=null){
                        $aadharData = $value;
                    }
                    continue;
                }
            }
            if($aadharData != null) {
                $data['aadhaarData'] = $aadharData;
            }
            if($photo!=null){
                $data['aadhaarPhoto'] = $photo;
            }
            $coname = $this->getCoName()->username;
            
            $data['add_to'] = $coname;
            $data['conv_type'] = $this->getConversionType($conversion_code);
            $data['pattaNo']=$this->utilityclass->getPattaTypeNoMB3Api($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code,$application->lot_no,$application->village_code,$application->dag_no);
            //var_dump($district['pattaNo']);
            $data['firstParty']=$mutation;
            $data['document']=$documents;
            $data['query']=$query;
            $data['user']=$this->RtpsModel->usersForOffice($application->dist_code,$application->subdiv_code,$application->cir_code);
            $data['chitha_basic'] = $this->ChithaBasicModel->get([
                'dist_code' => $application->dist_code,
                'subdiv_code' => $application->subdiv_code,
                'cir_code' => $application->cir_code,
                'mouza_pargona_code' => $application->mouza_code,
                'lot_no' => $application->lot_no,
                'vill_townprt_code' => $application->village_code,
                'dag_no_int' => $application->dag_no
            ]);

            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $this->load->model('propChain/PropChainModel');
                // checking if chitha data and property chain data mathches
                $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($application->dist_code,  $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no, $application->village_code, $data['pattaNo']->patta_no, $application->dag_no, $data['pattaNo']->dag_area_b, $data['pattaNo']->dag_area_k, $data['pattaNo']->dag_area_lc, $data['pattaNo']->dag_area_g, $data['pattaNo']->patta_type_code);

                // var_dump($pattadars);
                $data['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
                $data['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
                $data['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
                // hidden fields
                $data['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
                $data['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
                $data['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
                $data['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

                // bhunaksha area cmp
                $data['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
                $data['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
                $data['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
                $data['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
            }

            return $data;
        }

        public function getCOReportForCOFirst($case_no) {
            $application_no = $case_no;
            $appDetails = $this->RtpsModel->getApplicationDetails($application_no);
            
            $conversion_code = CONVERSION_CODE;
            $user_code = $this->session->userdata('user_code');

            if(!isset($appDetails) || empty($appDetails) || !isset($appDetails->application) || empty($appDetails->application) || !isset($appDetails->mutation) || empty($appDetails->mutation) || !isset($appDetails->documents) || empty($appDetails->documents) || !isset($appDetails->documents) || empty($appDetails->documents)) {

            }
            $mutation = $appDetails->mutation;
            $application = $appDetails->application;

            // $locationData = [
            //     'dist_code' => $application->dist_code,
            //     'subdiv_code' => $application->subdiv_code,
            //     'cir_code' => $application->cir_code,
            //     'mouza_pargona_code' => $application->mouza_code,
            //     'lot_no' => $application->lot_no,
            //     'vill_code' => $application->village_code
            // ];
            $chithaBasicDetails = $this->ChithaBasicModel->get([
                'dist_code' => $application->dist_code,
                'subdiv_code' => $application->subdiv_code,
                'cir_code' => $application->cir_code,
                'mouza_pargona_code' => $application->mouza_code,
                'lot_no' => $application->lot_no,
                'vill_townprt_code' => $application->village_code,
                'dag_no_int' => $application->dag_no
            ]);

            $data['application_details'] = $application;

            $patta_details = $this->utilityclass->getPattaTypeNoMB3Api($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code,$application->lot_no,$application->village_code,$application->dag_no);
            $data['patta_type'] = $this->db->query("select patta_type from patta_code where type_code=?", [$patta_details->patta_type_code])->row()->patta_type;

            $dist_code_name = $this->utilityclass->getDistrictName($application->dist_code);
            $subdiv_code_name = $this->utilityclass->getSubDivName($application->dist_code, $application->subdiv_code);
            $cir_code_name = $this->utilityclass->getCircleName($application->dist_code, $application->subdiv_code, $application->cir_code);
            $mouza_pargona_code_name = $this->utilityclass->getMouzaName($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code);
            $lot_no_name = $this->utilityclass->getLotName($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no);
            $vill_townprt_code_name = $this->utilityclass->getVillageName($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no, $application->village_code);
            $m_dag_area_lc = round($mutation[0]->area_lc, 2);
            $coName=$this->utilityclass->getSelectedCOName($application->dist_code, $application->subdiv_code, $application->cir_code, $user_code);
            $data['location'] = array(
                'dist_code' => $application->dist_code,
                'subdiv_code' => $application->subdiv_code,
                'cir_code' => $application->cir_code,
                'mouza_pargona_code' => $application->mouza_code,
                'lot_no' => $application->lot_no,
                'vill_code' => $application->village_code,
                'dist' => $dist_code_name,
                'sub' => $subdiv_code_name,
                'cir' => $cir_code_name,
                'mouza' => $mouza_pargona_code_name,
                'lot' => $lot_no_name,
                'vill' => $vill_townprt_code_name,
                // 'case_no' => $case_no,
                'date' => date('Y-m-d'),
                'dag' => $chithaBasicDetails->dag_no,
                'm_dag_area_b' => $mutation[0]->area_b,
                'm_dag_area_k' => $mutation[0]->area_k,
                'm_dag_area_lc' => $m_dag_area_lc,
                'm_dag_area_g' => $mutation[0]->area_g,
                'patta_no' => $patta_details->patta_no,
                'patta_type' => $patta_details->patta_type_code,
                'add_to' => $coName->username
            );

            $data['conv_type'] = $this->db->query("select order_type from master_office_mut_type where order_type_code='$conversion_code'")->row()->order_type;
            
            $pattadar = [];
            foreach($mutation as $mut) {
                $mut->relation = $this->utilityclass->get_relation_from_id($mut->gurdian_relation_id);
                $pattadar[] = $mut;
            }
            $data['pattadar'] = $pattadar;

            $basundharaAttachment = $this->getBasundharaLink($application_no);

            if($basundharaAttachment) {
                $data['basundharaAttachment'] = $basundharaAttachment;
            }

            if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
                $this->load->model('propChain/PropChainModel');

                $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no, $application->village_code);

                $landArea = $this->PropChainModel->getLandArea($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no, $application->village_code, trim($patta_details->patta_no), $application->dag_no);

                $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($application->dist_code, $application->subdiv_code, $application->cir_code, $application->mouza_code,$application->lot_no, $application->village_code, trim($patta_details->patta_no), $application->dag_no, $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $patta_details->patta_type_code);

                // var_dump($chainChithaCheck);
                // die;

                if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
                    $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                    if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                        $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                            $case_no,
                            $application->dist_code,
                            $application->subdiv_code,
                            $application->cir_code,
                            $application->mouza_code,
                            $application->lot_no,
                            $application->village_code,
                            trim($patta_details->patta_no),
                            $application->dag_no,
                            $landArea->dag_area_b,
                            $landArea->dag_area_k,
                            $landArea->dag_area_lc,
                            $landArea->dag_area_g,
                            $patta_details->patta_type_code
                        );
                    }
                }

                $data['ulpinCheck'] = $chainChithaCheck['ulpinCheck'];
                $data['ulpinMsg'] = $chainChithaCheck['ulpinMsg'];

                if ($data['ulpinCheck'] == 1) {
                    $data['ulpin'] = $chainChithaCheck['ulpin'];
                    if (isset($chainChithaCheck['old_ulpin']))
                        $data['old_ulpin'] = $chainChithaCheck['old_ulpin'];
                    else
                        $data['old_ulpin'] = "";
                }

                $data['chithaPropChainCmpFlag'] = $chainChithaCheck['chithaPropChainCmpFlag'];
                $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];
                $data['revenue'] = $chainChithaCheck['revenue'];
                $data['local_tax'] = $chainChithaCheck['local_tax'];

                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')
                    $data['createPropChainBtn'] = $chainChithaCheck['createPropChainBtn'];

                // hidden fields
                $data['ulpin_hidden'] = $chainChithaCheck['ulpin_hidden'];
                $data['uplpin_msg_hidden'] = $chainChithaCheck['uplpin_msg_hidden'];
                $data['compare_hidden'] = $chainChithaCheck['compare_hidden'];
                $data['compare_msg_hidden'] = $chainChithaCheck['compare_msg_hidden'];

                // bhunaksha area cmp
                $data['bhuChithaCmpStatus'] = $chainChithaCheck['bhuChithaCmpStatus'];
                $data['bhuChithaCmpMsg'] = $chainChithaCheck['bhuChithaCmpMsg'];
                $data['bhu_hidden'] = $chainChithaCheck['bhu_hidden'];
                $data['bhu_compare_msg_hidden'] = $chainChithaCheck['bhu_compare_msg_hidden'];
            }
            return $data;
        }

        public function getLMReportForLMFirst($case_no) {
            $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $chithaBasicDetails =  $this->ChithaBasicModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no, 'vill_townprt_code'=>$petitionBasic->vill_townprt_code, 'dag_no'=>$petitionDagDetails->dag_no], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $lmDetails = $this->LmCodeModel->get(['lm_code'=>$user_code, 'dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no], '*');
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);

            
            if($basundharApplication) {
                $appDetails = $this->RtpsModel->getApplicationDetails($basundharApplication);
                $mutation = $appDetails->mutation;
            }
            else {
                $mutation = null;
            }
            

            
            $genders = $this->MasterGenderModel->get();
            $relations = $this->MasterGuardianRelationModel->get();
            $uniquePattadars = $this->PetitionerPartModel->getUniquePattadars([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'patta_no'=>$petitionDagDetails->patta_no,
                'patta_type_code'=>$petitionDagDetails->patta_type_code,
                'dag_no'=>$petitionDagDetails->dag_no,
                'case_no'=>$case_no
            ],
            'dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, patta_no, patta_type_code, pdar_id, COUNT(*)',
            [
                'dist_code',
                'subdiv_code',
                'cir_code',
                'mouza_pargona_code',
                'lot_no',
                'vill_townprt_code',
                'dag_no',
                'patta_no',
                'patta_type_code',
                'pdar_id'
            ]);

            $chithaPattadars = $this->ChithaDagPattadarModel->getOtherPattadars($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code, $petitionDagDetails->dag_no);

            $petitionerPartIds = [];
            $otherPattadars = [];

            foreach ($petitionerParts as $petitionerPart) {
                $petitionerPartIds[] = $petitionerPart->pdar_id;
            }

            foreach ($chithaPattadars as $chithaPattadar) {
                if(!in_array($chithaPattadar->pdar_id, $petitionerPartIds)) {
                    $chithaPattadar->unique_id = $chithaPattadar->dist_code . '_' . $chithaPattadar->subdiv_code . '_' . $chithaPattadar->cir_code . '_' . $chithaPattadar->mouza_pargona_code . '_' . $chithaPattadar->lot_no . '_' . $chithaPattadar->vill_townprt_code . '_' . $chithaPattadar->dag_no . '_' . $chithaPattadar->pdar_id;
                    $otherPattadars[] = $chithaPattadar;
                }
            }

            $conversionPremiumAreas = $this->ConversionPremiumAreasModel->get([], '*', 'multiple');
            $conversionPremiumAreaPurposeType = $this->ConversionPremiumAreaPurposeTypeModel->get([], '*', 'multiple');

            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                    // echo '<pre>';
                    // var_dump($dbasundharaAttachment);
                    // die();
                }
                // $dbasundharaAttachment = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            if(in_array($petitionBasic->dist_code, json_decode(BARAK_VALLEY))) {
                $original_area = ($petitionDagDetails->dag_area_b * 6400) + ($petitionDagDetails->dag_area_k * 320) + ($petitionDagDetails->dag_area_lc * 20) + $petitionDagDetails->dag_area_g;
                $mutated_area = ($petitionDagDetails->m_dag_area_b * 6400) + ($petitionDagDetails->m_dag_area_k * 320) + ($petitionDagDetails->m_dag_area_lc * 20) + $petitionDagDetails->m_dag_area_g;
            }
            else {
                $original_area = ($petitionDagDetails->dag_area_b * 20 * 5) + ($petitionDagDetails->dag_area_k * 20) + $petitionDagDetails->dag_area_lc;
                $mutated_area = ($petitionDagDetails->m_dag_area_b * 20 * 5) + ($petitionDagDetails->m_dag_area_k * 20) + ($petitionDagDetails->m_dag_area_lc);
            }
            
            $isPartial = ($mutated_area < $original_area) ? 1 : 0;

            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            
            //setting all the required data
            $data['conversion_premium_area_purpose'] = $conversionPremiumAreaPurposeType;
            $data['conversion_premium_areas'] = $conversionPremiumAreas;
            $data['location_details'] = $locationDetails;
            $data['unique_pattadars'] = $uniquePattadars;
            $data['other_pattadars'] = $otherPattadars;
            $data['relations'] = $relations;
            $data['genders'] = $genders;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['is_partial'] = $isPartial;
            $data['rtps_tag'] = $rtps_tag;
            $data['supportive_documents'] = $supportiveDocuments;
            if($mutation) {
                $data['applied_area'] = [
                    'bigha' => $mutation[0]->area_b,
                    'katha' => $mutation[0]->area_k,
                    'lessa_chatak' => $mutation[0]->area_lc,
                    'ganda' => $mutation[0]->area_g
                ];
            }
            

            $applid = $this->db->query("select basundhara from basundhar_application where dharitree =?", array($case_no));
            $application_no = $applid->row()->basundhara;

            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0){
                $data['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $data['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            return $data;
        }

        public function getApplicationData($case_no) {
            $application_no = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            if($application_no == null) {
                return null;
            }
            $appDetails = $this->RtpsModel->getApplicationDetails($application_no);
            
            $data['app'] =  $application = $appDetails->application;
            $selfDeclaration =  null;
            $applicants = null;
            $mutation = null;
            $documents = null;
            $query = null;
            $photo = null;
            $aadharData = null;
            $conversion_code = CONVERSION_CODE;

            if(isset($appDetails->selfDeclaration) && !empty($appDetails->selfDeclaration)) {
                $selfDeclaration = $appDetails->selfDeclaration;
            }
            if(isset($appDetails->mutation) && !empty($appDetails->mutation)) {
                $mutation = $appDetails->mutation;
            }
            if(isset($appDetails->applicants) && !empty($appDetails->applicants)) {
                $applicants = $appDetails->applicants;
            }
            if(isset($appDetails->documents) && !empty($appDetails->documents)) {
                $documents = $appDetails->documents;
            }
            if(isset($appDetails->query) && !empty($appDetails->query)) {
                $query = $appDetails->query;
            }
            if(isset($appDetails->photo) && $appDetails->photo != null) {
                $photo = $appDetails->photo;
            }
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                    // echo '<pre>';
                    // var_dump($dbasundharaAttachment);
                    // die();
                }
                // $dbasundharaAttachment = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }


            if($selfDeclaration != null) {
                $data['selfDecData'] = json_decode($selfDeclaration[0]->dec_details);
            }
            if($mutation != null) {
                foreach ($mutation as $value) {
                    if(isset($value->auth_type) && $value->auth_type !=null){
                        $aadharData = $value;
                    }
                    continue;
                }
            }
            if($aadharData != null) {
                $data['aadhaarData'] = $aadharData;
            }
            if($photo!=null){
                $data['aadhaarPhoto'] = $photo;
            }
            $sessionData = $this->getSessionLocation();
            
            $coname = ($this->session->userdata('user_desig_code') == 'CO') ?  $this->getCoName()->username : $this->getCoNameForAll($sessionData['dist_code'], $sessionData['subdiv_code'], $sessionData['cir_code'])->username;
            $data['add_to'] = $coname;
            $data['conv_type'] = $this->getConversionType($conversion_code);
            $data['pattaNo']=$this->utilityclass->getPattaTypeNo($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code,$application->lot_no,$application->village_code,$application->dag_no);
            //var_dump($district['pattaNo']);
            $data['firstParty']=$mutation;
            $data['document']=$documents;
            $data['query']=$query;
            $data['user']=$this->RtpsModel->usersForOffice($application->dist_code,$application->subdiv_code,$application->cir_code);
            $data['chitha_basic'] = $this->ChithaBasicModel->get([
                'dist_code' => $application->dist_code,
                'subdiv_code' => $application->subdiv_code,
                'cir_code' => $application->cir_code,
                'mouza_pargona_code' => $application->mouza_code,
                'lot_no' => $application->lot_no,
                'vill_townprt_code' => $application->village_code,
                'dag_no_int' => $application->dag_no
            ]);

            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['supportive_documents'] = $supportiveDocuments;

            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $this->load->model('propChain/PropChainModel');
                // checking if chitha data and property chain data mathches
                $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($application->dist_code,  $application->subdiv_code, $application->cir_code, $application->mouza_code, $application->lot_no, $application->village_code, $data['pattaNo']->patta_no, $application->dag_no, $data['pattaNo']->dag_area_b, $data['pattaNo']->dag_area_k, $data['pattaNo']->dag_area_lc, $data['pattaNo']->dag_area_g, $data['pattaNo']->patta_type_code);

                // var_dump($pattadars);
                $data['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
                $data['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
                $data['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
                // hidden fields
                $data['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
                $data['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
                $data['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
                $data['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

                // bhunaksha area cmp
                $data['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
                $data['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
                $data['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
                $data['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
            }

            return $data;

        }

        public function getCOReportForLMFirst($case_no) {
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $sessionData = $this->getSessionLocation();
            $coname = $this->getCoNameForAll($sessionData['dist_code'], $sessionData['subdiv_code'], $sessionData['cir_code'])->username;
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            
            $data['add_to'] = $coname;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['location_details'] = $locationDetails;
            $data['patta_type_details'] = $pattaTypeDetails;

            return $data;
        }

        public function getLMHistoryForLMFirst($case_no) {
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionProceedings = $this->PetitionProceedingModel->get(['case_no' => $case_no], '*', 'multiple', ['proceeding_id' => 'DESC']);
            foreach ($petitionProceedings as $petitionProceeding) {
                $isLM = $this->UsersModel->checkIfLM($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionProceeding->user_code);

                if($isLM) {
                    $petitionProceeding->user_name = $this->LmCodeModel->get([
                        'dist_code' => $petitionBasic->dist_code,
                        'subdiv_code' => $petitionBasic->subdiv_code,
                        'cir_code' => $petitionBasic->cir_code,
                        'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                        'lot_no' => $petitionBasic->lot_no,
                        'lm_code' => $petitionProceeding->user_code
                    ], 'lm_name')->lm_name;
                }
                else {
                    $petitionProceeding->user_name = $this->UsersModel->get([
                        'dist_code' => $petitionBasic->dist_code,
                        'subdiv_code' => $petitionBasic->subdiv_code,
                        'cir_code' => $petitionBasic->cir_code,
                        'user_code' => $petitionProceeding->user_code
                    ], 'username', 'single')->username;
                }
            }
            $data['case_no'] = $case_no;
            $data['petition_proceedings'] = $petitionProceedings;
            return $data;
        }

        public function getSKReportForSKFirst($case_no) {
            $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $chithaBasicDetails =  $this->ChithaBasicModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no, 'vill_townprt_code'=>$petitionBasic->vill_townprt_code, 'dag_no'=>$petitionDagDetails->dag_no], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $lmDetails = $this->LmCodeModel->get(['lm_code' => $petitionLmNoteDetails->lm_code, 'dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no], '*');
            $skDetails = $this->UsersModel->get([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'user_desig_code' => 'SK',
                'user_code' => $user_code
            ]);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);

            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);

            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $conversionPremiumAreas = $this->ConversionPremiumAreasModel->get(['id' => $petitionLmNoteDetails->conversion_premium_areas_id]);
            $conversionPremiumAreaPurposeType = $this->ConversionPremiumAreaPurposeTypeModel->get(['id' => $petitionLmNoteDetails->premium_assesment]);
            $conversionPremiumRates = $this->ConversionPremiumRatesModel->get(['id' => $petitionLmNoteDetails->conversion_premium_rates_id]);
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);

            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    // $dbasundharaAttachment = $this->RtpsModel->searchBasundharaLink($case_no);
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            //setting all the required data
            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['sk_details'] = $skDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            $data['conversion_areas'] = $conversionPremiumAreas;
            $data['conversion_area_purpose'] = $conversionPremiumAreaPurposeType;
            $data['conversion_rates'] = $conversionPremiumRates;
            
            return $data;
        }

        public function getCOReportForCOSecond($case_no) {
            $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get([
                'petition_no'=>$petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $user_code);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $chithaBasicDetails =  $this->ChithaBasicModel->get([
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no,
                'vill_townprt_code'=>$petitionBasic->vill_townprt_code,
                'dag_no'=>$petitionDagDetails->dag_no
            ], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $lmDetails = $this->LmCodeModel->get([
                'lm_code' => $petitionLmNoteDetails->lm_code,
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no
            ], '*');
            $skDetails = $this->UsersModel->get([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'user_desig_code' => 'SK',
                'user_code' => $petitionLmNoteDetails->user_code
            ]);
            $petitionProceedings = $this->PetitionProceedingModel->get(['case_no' => $case_no], '*', 'multiple', ['proceeding_id' => 'DESC']);
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'id' => $petitionLmNoteDetails->conversion_premium_rates_id,
                'is_deleted' => 0
            ]);
            $premiumArea = $this->ConversionPremiumAreasModel->get([
                'id' => $premiumRateDetails->premium_area_id,
                'is_deleted' => 0
            ]);
            //retrieving dc and adc details
            $adcDcUsers = $this->UsersModel->adcDcLoginTableJoin($petitionBasic->dist_code);
            $adcUsers = $this->UsersModel->adcLoginTableJoin($petitionBasic->dist_code);
            //basundhar application
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['sk_details'] = $skDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            $data['petition_proceedings'] = $petitionProceedings;
            $data['supportive_documents'] = $supportiveDocuments;
            $data['co_details'] = $coName;
            // $data['adc_dc'] = $adcDcUsers;
            $data['adc_dc'] = $adcUsers;
            $data['adc'] = $adcUsers;
            $data['premium_rate_details'] = $premiumRateDetails;
            $data['premium_area_details'] = $premiumArea;

            return $data;
        }

        public function getSKReportForCOSecond($case_no) {
            // $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $chithaBasicDetails =  $this->ChithaBasicModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no, 'vill_townprt_code'=>$petitionBasic->vill_townprt_code, 'dag_no'=>$petitionDagDetails->dag_no], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $lmDetails = $this->LmCodeModel->get(['lm_code' => $petitionLmNoteDetails->lm_code, 'dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'lot_no'=>$petitionBasic->lot_no], '*');
            $skDetails = $this->UsersModel->get([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'user_desig_code' => 'SK',
                'user_code' => $petitionLmNoteDetails->user_code
            ]);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);

            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);

            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);

            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->RtpsModel->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            //setting all the required data
            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['sk_details'] = $skDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            
            return $data;
        }

        public function getPremiumNoticeDetails($case_no) {
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $petitionDagDetails = $this->PetitionDagDetailsModel->get(['petition_no'=>$petitionBasic->petition_no]);
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'id' => $petitionLmNoteDetails->conversion_premium_rates_id,
                'is_deleted' => 0
            ]);
            $premiumArea = $this->ConversionPremiumAreasModel->get([
                'id' => $premiumRateDetails->premium_area_id,
                'is_deleted' => 0
            ]);
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            $data['location_details'] = $locationDetails;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['rtps_tag'] = $rtps_tag;
            $data['supportive_documents'] = $supportiveDocuments;
            $data['premium_rate_details'] = $premiumRateDetails;
            $data['premium_area_details'] = $premiumArea;

            return $data;
        }

        public function getCOSecondReportForAst($case_no) {
            // $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get([
                'petition_no'=>$petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $chithaBasicDetails =  $this->ChithaBasicModel->get([
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no,
                'vill_townprt_code'=>$petitionBasic->vill_townprt_code,
                'dag_no'=>$petitionDagDetails->dag_no
            ], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $lmDetails = $this->LmCodeModel->get([
                'lm_code' => $petitionLmNoteDetails->lm_code,
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no
            ], '*');
            $skDetails = $this->UsersModel->get([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'user_desig_code' => 'SK',
                'user_code' => $petitionLmNoteDetails->user_code
            ]);
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'id' => $petitionLmNoteDetails->conversion_premium_rates_id,
                'is_deleted' => 0
            ]);
            $premiumArea = $this->ConversionPremiumAreasModel->get([
                'id' => $premiumRateDetails->premium_area_id,
                'is_deleted' => 0
            ]);
            $petitionProceedings = $this->PetitionProceedingModel->get(['case_no' => $case_no], '*', 'multiple', ['proceeding_id' => 'DESC']);
            //retrieving dc and adc details
            $adcDcUsers = $this->UsersModel->adcDcLoginTableJoin($petitionBasic->dist_code);
            $adcUsers = $this->UsersModel->adcLoginTableJoin($petitionBasic->dist_code);
            //basundhar application
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['sk_details'] = $skDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            $data['petition_proceedings'] = $petitionProceedings;
            $data['supportive_documents'] = $supportiveDocuments;
            $data['co_details'] = $coName;
            $data['adc_dc'] = $adcDcUsers;
            $data['adc'] = $adcUsers;
            $data['premium_rate_details'] = $premiumRateDetails;
            $data['premium_area_details'] = $premiumArea;

            return $data;
        }

        public function getConfirmPremiumDetails($case_no) {
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $petitionDagDetails = $this->PetitionDagDetailsModel->get([
                'petition_no'=>$petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $premiumChalanReceipts = $this->PremiumChalanReceiptModel->get();
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'id' => $petitionLmNoteDetails->conversion_premium_rates_id,
                'is_deleted' => 0
            ]);
            $premiumArea = $this->ConversionPremiumAreasModel->get([
                'id' => $premiumRateDetails->premium_area_id,
                'is_deleted' => 0
            ]);
            //basundhar application
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            $paymentConfirmation = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->RtpsModel->searchBasundharaLink($case_no);
                }
                $paymentConfirmation = json_decode($this->BasundharApplicationModel->paymentConfirmation($basundharApplication));
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }
            
            //new addition for premium paid check
            $case_no_rtps = $this->utilityclass->getBasundharaFromCaseNo($case_no);
            $payment_status_check = $this->paymentConfirmationMb3($case_no_rtps);
            // var_dump($payment_status_check); die;
            $data['payment_status_check'] = $payment_status_check;
            //end new addition for premium paid check

            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            $data['supportive_documents'] = $supportiveDocuments;
            $data['premium_chalan_receipts'] = $premiumChalanReceipts;
            $data['payment_confirmation'] = $paymentConfirmation;
            $data['premium_rate_details'] = $premiumRateDetails;
            $data['premium_area_details'] = $premiumArea;

            return $data;
        }

        public function getFirstFormChithaUpdate($case_no) {
            $conversion_code = CONVERSION_CODE;
            $user_code = $this->session->userdata('user_code');

            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get([
                'petition_no'=>$petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $user_code);
            $designationDetails = $this->MasterUserDesignationModel->get(['user_desig_code' => $petitionBasic->add_off_desig]);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            
        }

        public function getCoFinalOrder($case_no) {
            $user_code = $this->session->userdata('user_code');
            $conversion_code = CONVERSION_CODE;
            $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
            $petitionDagDetails = $this->PetitionDagDetailsModel->get([
                'petition_no'=>$petitionBasic->petition_no,
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code
            ]);
            $petitionerParts = $this->PetitionerPartModel->get(['petition_no'=>$petitionBasic->petition_no], '*', 'multiple');
            $pattaTypeDetails = $this->PattacodeModel->get_the_patta(['type_code' => $petitionDagDetails->patta_type_code]);
            $conversionType = $this->MasterOfficeMutationTypeModel->get(['order_type_code' => $conversion_code])->order_type;
            $coName=$this->utilityclass->getSelectedCOName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $user_code);
            $locationDetails = $this->LocationModel->get(['dist_code' => $petitionBasic->dist_code, 'subdiv_code' => $petitionBasic->subdiv_code, 'cir_code' => $petitionBasic->cir_code, 'mouza_pargona_code' => $petitionBasic->mouza_pargona_code, 'lot_no' => $petitionBasic->lot_no, 'vill_townprt_code' => $petitionBasic->vill_townprt_code]);
            $locationDetails->dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
            $locationDetails->subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
            $locationDetails->cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
            $locationDetails->mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
            $locationDetails->lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
            $locationDetails->vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);
            
            $data['pattadar_details'] = $this->db->query("Select * from    petitioner_part where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                        . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' and patta_type_code= '$petitionDagDetails->patta_type_code' and dag_no = '$petitionDagDetails->dag_no' and TRIM(patta_no) = '$petitionDagDetails->patta_no' and petition_no = '$petitionBasic->petition_no'")->result();

            $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' "
                        . "and cir_code='$petitionBasic->cir_code' and lot_no='$petitionBasic->lot_no' and vill_townprt_code='$petitionBasic->vill_townprt_code' and "
                        . "mouza_pargona_code='$petitionBasic->mouza_pargona_code' and petition_no='$petitionBasic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();
            $paymane_details = $this->db->query("Select * from    premium_chalan_receipt where code = '$lm_premium->prem_pay_method'")->row();


             $data['payment_type'] =
                [
                    'type_of_premium' => $lm_premium->prem_pay_method,
                    'premium_reciept' => $lm_premium->recpt_number,
                    'premium_amount' => $lm_premium->prim_tot,
                    'chalan_name' => $paymane_details->chalan_name
                ]
             ;
            
            $petitionLmNoteDetails = $this->PetitionLmNoteModel->getLatest([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
                'lot_no' => $petitionBasic->lot_no,
                'vill_townprt_code' => $petitionBasic->vill_townprt_code,
                'petition_no' => $petitionBasic->petition_no
            ]);
            $chithaBasicDetails =  $this->ChithaBasicModel->get([
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no,
                'vill_townprt_code'=>$petitionBasic->vill_townprt_code,
                'dag_no'=>$petitionDagDetails->dag_no
            ], '*', 'single');
            $landClassCodeDetails = $this->LandclassCodeModel->get_the_land_class(['class_code'=>$chithaBasicDetails->land_class_code]);
            $lmDetails = $this->LmCodeModel->get([
                'lm_code' => $petitionLmNoteDetails->lm_code,
                'dist_code'=>$petitionBasic->dist_code,
                'subdiv_code'=>$petitionBasic->subdiv_code,
                'cir_code'=>$petitionBasic->cir_code,
                'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
                'lot_no'=>$petitionBasic->lot_no
            ], '*');
            $skDetails = $this->UsersModel->get([
                'dist_code' => $petitionBasic->dist_code,
                'subdiv_code' => $petitionBasic->subdiv_code,
                'cir_code' => $petitionBasic->cir_code,
                'user_desig_code' => 'SK',
                'user_code' => $petitionLmNoteDetails->user_code
            ]);
            $petitionProceedings = $this->PetitionProceedingModel->get(['case_no' => $case_no], '*', 'multiple', ['proceeding_id' => 'DESC']);
            $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
                'id' => $petitionLmNoteDetails->conversion_premium_rates_id,
                'is_deleted' => 0
            ]);
            $premiumArea = $this->ConversionPremiumAreasModel->get([
                'id' => $premiumRateDetails->premium_area_id,
                'is_deleted' => 0
            ]);
            //retrieving dc and adc details
            $adcDcUsers = $this->UsersModel->adcDcLoginTableJoin($petitionBasic->dist_code);
            $adcUsers = $this->UsersModel->adcLoginTableJoin($petitionBasic->dist_code);
            //basundhar application
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $dbasundharaAttachment = null;
            $rtps_tag = null;
            $supportiveDocuments = null;
            if($basundharApplication) {
                $rtps = explode('/', $basundharApplication);
                $rtps_tag = $rtps[0];
                if($rtps_tag == 'RTPS') {
                    $dbasundharaAttachment = $this->searchBasundharaLink($case_no);
                }
            }
            else {
                //from supportive docs
                $supportiveDocuments = $this->SupportiveDocumentModel->getDocs($case_no);
            }

            // new dag and patta create start
            $sql = "Select dag_no from    chitha_basic where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' and patta_type_code= '$petitionDagDetails->patta_type_code'";
            $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
            //var_dump($dag_no);
            $newDag = 0;
            foreach ($dag_no as $d) {
                $d = $d->dag_no;
                if ($newDag < $d) {
                    $newDag = $d;
                }
            }

            $sqll = "Select patta_no from    chitha_basic where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' and patta_type_code= '$petitionDagDetails->patta_type_code'";
            $patta = $data['oldPatta'] = $this->db->query($sqll)->result();
            $newpatta = 0;
            foreach ($patta as $p) {
                $p = trim($p->patta_no);
                if ($newpatta < $p) {
                    $newpatta = $p;
                }
            }

            
            $rev_and_tax = "Select * from    chitha_basic where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' and patta_type_code= '$petitionDagDetails->patta_type_code'";
            $rev_and_tax = $this->db->query($rev_and_tax)->row();
            $old_b = $rev_and_tax->dag_area_b;
            $old_k = $rev_and_tax->dag_area_k;
            $old_lc = $rev_and_tax->dag_area_lc;
            $old_dag_revenue = $rev_and_tax->dag_revenue;
            $old_g = 0.0;
            $old_kr = 0.0;
            $converted_to_lessa_old = ($old_b) * 100 + ($old_k) * 20 + ($old_lc);
            $onelessa = ($old_dag_revenue / $converted_to_lessa_old);
            $hundredlessa = $onelessa * 100;

            $converted_b =  $petitionDagDetails->m_dag_area_b;
            $converted_k =  $petitionDagDetails->m_dag_area_k;
            $converted_lc =  $petitionDagDetails->m_dag_area_lc;
            $converted_g = 0.0;
            $converted_kr = 0.0;
            $converted_to_lessa_new = ($converted_b) * 100 + ($converted_k) * 20 + ($converted_lc);


            if ($converted_to_lessa_new < 100) {
                $cal_new_rev = round($hundredlessa, 2);
                $new_dag_local_tax = round($cal_new_rev / 4, 2);
            } else {

                $remaining_lessa = $converted_to_lessa_new;
                $cal_new_rev = round($onelessa * $remaining_lessa, 2);
                $new_dag_local_tax = round($cal_new_rev / 4, 2);
            }

            $data['datas'] = array(
                'new_dag' => $newDag + 1,
                'newpatta' => $newpatta + 1,
                'revenue' => $cal_new_rev,
                'local_tax' => $new_dag_local_tax
            );

            // new dag and patta create end

            $check_dag_no = "Select dag_no from    chitha_basic where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' order by dag_no_int asc";
            //echo $check_dag_no;
            $data['check_dag_no'] = $this->db->query($check_dag_no)->result();

            $check_patta_no = "Select distinct (patta_no) as patta_no from    chitha_basic where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and cir_code='$petitionBasic->cir_code' and mouza_pargona_code='$petitionBasic->mouza_pargona_code'"
                    . "and vill_townprt_code='$petitionBasic->vill_townprt_code' and lot_no='$petitionBasic->lot_no' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by patta_no asc";
            //echo $check_patta_no;
            $data['check_patta_no'] = $this->db->query($check_patta_no)->result();
            $data['type'] = $this->db->query("SELECT * from patta_code where mutation='a' ")->result();
            $data['location_details'] = $locationDetails;
            $data['basundhar_application'] = $basundharApplication;
            $data['basundhara_attachment'] = $dbasundharaAttachment;
            $data['conversion_type'] = $conversionType;
            $data['patta_type_details'] = $pattaTypeDetails;
            $data['lm_details'] = $lmDetails;
            $data['sk_details'] = $skDetails;
            $data['land_class_details'] = $landClassCodeDetails;
            $data['chitha_basic_details'] = $chithaBasicDetails;
            $data['petition_lm_note_details'] = $petitionLmNoteDetails;
            $data['pattadars'] = $petitionerParts;
            $data['petition_dag_details'] = $petitionDagDetails;
            $data['petition_basic'] = $petitionBasic;
            $data['rtps_tag'] = $rtps_tag;
            $data['petition_proceedings'] = $petitionProceedings;
            $data['supportive_documents'] = $supportiveDocuments;
            $data['co_details'] = $coName;
            // $data['adc_dc'] = $adcDcUsers;
            $data['adc_dc'] = $adcUsers;
            $data['adc'] = $adcUsers;
            $data['premium_rate_details'] = $premiumRateDetails;
            $data['premium_area_details'] = $premiumArea;

            return $data;
        }

        function paymentConfirmationMb3($basundhara){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."paymentStatus");
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
            if($httpcode != 200){
                return false;
            }
            return json_decode($result);
        }

        public function getCoAllCases($case_no) {
            $applid = $this->db->query("select basundhara from basundhar_application where dharitree =?", array($case_no));
            $application_no = $applid->row()->basundhara;

            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid=?", [$application_no]);

            if($supportive_document_sql->num_rows() > 0){
                $data['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $data['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            $data['case_no'] = $case_no;

            return $data;
        }
    }

    /*
public function DCPassedSecondProceeding() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $user_code=$this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        
        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment,petition_no "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
        and cir_code='$cir_code' and lot_no='$lot_no' and 
        vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        and petition_no='$petition_no'")->row_array();
        
        $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['l_data']=$locationData;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'add_off_designation' => $designation,
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment'],
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'co_name' => $co->username
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();
        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code'],
                'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
                'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
                'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
                'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
                'widow_yn' => $lm_details['widow_yn'],
                'widow_upload' => $lm_details['widow_upload'],
                'premium_assesment' => $lm_details['premium_assesment'],
                'land_trans_yn' => $lm_details['land_trans_yn']
            );
        }
        
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        $data['lm_name'] = $namelm->lm_name;
        
        $skname = $this->db->query("select * from  users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' ORDER BY note_no DESC LIMIT 1")->result();

        $query = "select * from petition_proceeding where case_no='$case_no' order by proceeding_id desc";
        $data['cases'] = $this->db->query($query)->result();

        // echo '<pre>';
        // var_dump($petition_basic);
        // die();

        if($petition_basic->bo_note_yn == 'Y' && $petition_basic->pay_notice_gen_yn == null) {
            $data['post_url'] = 'index.php/COconversionPartha/Chitha_update_generate';
        }
        else if($petition_basic->bo_note_yn == null && $petition_basic->pay_notice_gen_yn == 'Y') {
            $data['post_url'] = 'index.php/COconversionPartha/Chitha_update_generate_Co';
        }
        
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/co_office_conversion/Pending_chithaUpdate_Second_Proceeding', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'co_office_conversion/Pending_chithaUpdate_Second_Proceeding';
        $this->load->view('layouts/main',$data);
    }
    */



?>