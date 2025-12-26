<?php
class AutoRegistrationmodel extends CI_Model {
    public function __construct() {
        parent::__construct();

        $this->load->model('rtps/rtpsmodel');
        $this->load->model('Escalationmodel');
        $this->load->model('basundhara/basundharamodel');
        $this->dbswitch();
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


    public function getPendingOfficer($d, $s, $c,$desig_code){
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code 
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E' 
            and u.user_desig_code = '$desig_code' and lt.dist_code='$d' 
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);
        return $data->row();
    }


    public function getPendingOfficerLM($d,$s,$c,$mouza_pargona_code,$lot_no){
        $sql = "select lt.user_code from loginuser_table lt join lm_code u on lt.dist_code=u.dist_code 
            and lt.subdiv_code=u.subdiv_code
            and lt.cir_code=u.cir_code
            and lt.mouza_pargona_code=u.mouza_pargona_code
            and lt.lot_no=u.lot_no
            and u.lm_code=lt.user_code 
            where lt.dis_enb_option='E' 
            and lt.dist_code='$d' 
            and lt.subdiv_code='$s' and lt.cir_code='$c' and lt.mouza_pargona_code='$mouza_pargona_code' and lt.lot_no='$lot_no'";
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function genearteCaseNameEs($dist_code, $subdiv_code, $cir_code){

        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
            {
                $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
                return $case_no;
            }
        return false;
    }


    public function apiForRegistrationInDharitree($application_no,$service_code){
        // $application_no = $_GET['app_no'];
        // $service_code = $_GET['service_code'];


        // var_dump($service_code); die;

        switch($service_code){
            case 1: 
                // $this->mutationInheritanceRegistration($application_no,$service_code);//for old
                // $this->registrationMutationMultigen($application_no,$service_code);
                $this->mutationInheritanceRegistrationCheckingForOLdNew($application_no,$service_code);
                break;
            case 2: 
                $this->mutationDeedRegistration($application_no,$service_code);
                break;
            case 3: 
                $this->partitionRegistration($application_no,$service_code);
                break;
            case 4: 
                $this->reclassRegistration($application_no,$service_code);
                break;
            case 5: 
                $this->allotmentRegistration($application_no,$service_code);
                break;
            case 20:
                $this->nameCorrectionRegistrationNewService($application_no,$service_code);
                break;
            case 9: 
                $this->conversionRegistration($application_no,$service_code);
                break;
            case 8: 
                $this->nameCancellationRegistration($application_no,$service_code);
                break;
            case 7:
                $this->areaCorrectionRegistration($application_no,$service_code);
                break;
            case 6: 
                $this->nameCorrectionRegistration($application_no,$service_code);
                break;
        }
    }

    public function nameCorrectionRegistration_old($application_no,$service_code){

        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check",
                    'status' => false
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);
        // var_dump($output);
        // die;




        $data['app']=$output->application;

        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');



        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        $district['query']=$output->query;

        //var_dump($data['secParty']);
        //var_dump($data);
        $this->db->trans_begin();


        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteMiscPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/MiNC";

        // echo "<pre>"; var_dump($data); die;

        $userdata = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'year_no' => date('Y'),
            'misc_case_petition_no' => $case_no['petition_no'],
            'misc_case_no' => $case_no['case_no'],
            'misc_case_type' => '06',
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'supported_doc_yn' => 'Y',
            'supported_doc_code' => date('Y-m-d G:i:s'),
            'fresh_yn' => 'Y',
            'status' => 1,
            'operation' => 's',
            'proceeding_yn' => 'Y',
            'user_code' => $pending_officer->user_code,
            'date_of_operation' => date('Y-m-d G:i:s'),
            // 'add_to_officer' => $pending_officer->user_code,
            'dag_no' => $data['app']->dag_no,
            'es_flag' => 1
        );
                //var_dump($userdata);
        //$this->session->set_userdata($userdata);
        $insBasicMINC = $this->db->insert("misc_case_basic", $userdata);
        if($insBasicMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR001: Insertion failed in misc_case_basic for RTPS Case No '.$application_no);

            log_message('error', '#ERRNSTR0000001: '. $this->db->last_query());
            $data = array(
                'error'=>"#ERRNSTR001: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        //adding aadhaar information---------
        $file = null;
        if($data['secParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['secParty'][0]->auth_type;
            $id_ref_no = $data['secParty'][0]->id_ref_no;
            if($data['secParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['secParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'petition_pdar_id' =>  $data['secParty'][0]->chitha_pdar_id,
            'misc_case_no' => $case_no['case_no'],
            'petition_pdar_name_old' => $data['secParty'][0]->name_ass,
            'petition_pdar_name_new' => $data['firstParty'][0]->pat_name_ass,
            'submission_date' => date('Y-m-d G:i:s'),
            'user_code' => $pending_officer->user_code,
            'operation' => 'E',
            'misc_case_petition_no' => $case_no['petition_no'],
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo,
            'applicant_info' => json_encode($data['secParty'])
        );
        $insFirstPartyMINC = $this->db->insert("misc_case_first_party", $basic);
        if($insFirstPartyMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRMINC002: Insertion failed in misc_case_first_party for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRMINC002: Registration of Name Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }


        
        
    
       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'LM'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuMINC = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRMINC003: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRMINC003: Registration of Name Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

       //  $remark='Registered by Assistant';

       //  $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'],$remark);


       // if($proInsert==false || $proInsert===false)
       //  {
       //      log_message('error', "#MISCAST001:".$this->db->last_query());
       //      $this->db->trans_rollback();
       //      $this->session->set_flashdata('message', "Updation failed(#MISCAST001)". $application_no);
       //      redirect(base_url() . "index.php/home");
       //  }



        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return;
        }
        else
        {
            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'NCOR',$from_officer_co->user_code);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $this->DashboardNameCorrect($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    }

    function DashboardNameCorrect($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no  where pb.misc_case_no=? ";
            $data=$this->db->query($sql, array($case_no))->row_array();
            $type='MC';
            $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'CO',
                  'case_type' =>$type,
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
            
            // $applicant= array(
            //     'case_no' => $data['case_no'],
            //     'applicant_name' => $data['pet_name'],
            //     'guardian_name' => 'NA',
            //     'gender' => 'NA' );
            // $this->dbb->insert('dashboard_applicant',$applicant);
            // $action= array(
            //     'case_no' =>$data['case_no'],
            //     'user_code' => $this->session->userdata('user_code'),
            //     'date_of_action_taken' => date('Y-m-d'),
            //     'user_designation' => $this->session->userdata('user_desig_code'),
            //     'remark' => 'Registered By Assistant',
            //      );
            //  $this->dbb->insert('dashboard_action',$action);
        }

    /////////////////Office Inheritance Mutation/////////////////////////
    public function mutationInheritanceRegistrationCheckingForOLdNew($application_no,$service_code){
        
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);
        $data['app']=$output->application;

        if($data['app']->is_multigeneration == "M" || $data['app']->is_multigeneration == "S")
        {
            return $this->registrationMutationMultigen($application_no,$service_code);
        }
        else
        {
            return $this->mutationInheritanceRegistration($application_no,$service_code);
        }
    }
    public function mutationInheritanceRegistration($application_no,$service_code){

          $this->registrationFMUT($application_no,$service_code);
    }
    public function registrationOMUT($application_no,$service_code){
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error_code' => '#ERROR001',
                'msg'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        
        $output = json_decode($fetchData);
        $data['app']=$output->application;
        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');
        
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);        
         if(empty($case_name)){
            $data=array(
                'error_code' => '#ERROR002',
                'msg'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";

        

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>$data['secParty']->trans_type,/////////for inheritance
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>'CO',
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $pending_officer->user_code,
            'es_flag' => 1,
            ///////// 
        );
        $insPetBasic = $this->db->insert('petition_basic',$basic);
        if($insPetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR003: Insertion failed in petition_basic RTPS Case No '.$application_no);
            $data=array(
                'error_code' => '#ERROR003',
                'msg'=>"Registration of Office Mutation by Inheritance failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        //////Buyer Insert////////////
        $i=1;
        $file = null;
        foreach($data['firstParty'] as $pet){
            //newly added aadhaar integration in dharitree---------10052023
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type =='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            //end code-------------------------


            $faddress=$this->Escalationmodel->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'pdar_name_eng' => $pet->pat_name_eng,
                'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                // 'guard_rel' => 'f', //////////////////////to be update
                // 'pet_gender'=>$pet->pat_gender,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                'pet_id' => $i++,
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'user_code' => $pending_officer->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                'pdar_mobile' => $pet->pat_mobile_no,
                'applied_b' =>0,
                'applied_k' => 0,
                'applied_lc' => 0,
                'applied_g' => 0,
                'applied_kr' => 0,
                'self_declaration' => $dec,
                'auth_type'        => $auth_type,
                'id_ref_no'        => $id_ref_no,
                'photo'            => $photo,
            );
            $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
            if($insPetitioner != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR004: Insertion failed in petitioner for RTPS Case No '.$application_no);
                $data=array(
                  'error_code' => '#ERROR004',
                  'msg'=>"Registration of Office Mutation by Inheritance failed for case no : ".$application_no,
                  'status' => false
                );
                echo json_encode($data);
                return;
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'pdar_rel_guar' => 'f',
                'striked_out' =>1,/////for inheritance//////
                'dag_no' =>$data['app']->dag_no,
                'patta_no'=>$data['pattaNo']->patta_no ,
                'patta_type_code'  => $data['pattaNo']->patta_type_code,
                'pdar_id' =>  $pet->chitha_pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_gender' => 'm',
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadar != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR005: Insertion failed in petition_pattadar for RTPS Case No '.$application_no);
                $data=array(
                  'error_code' => '#ERROR005',
                  'msg'=>"Registration of Office Mutation by Inheritance failed for case no : ".$application_no,
                  'status' => false
                );
                echo json_encode($data);
                return;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$data['pattaNo']->patta_no ,
            'patta_type_code'  => $data['pattaNo']->patta_type_code,
            'm_dag_area_b'=>$data['app']->area_b,
            'm_dag_area_k' =>$data['app']->area_k,
            'm_dag_area_lc' =>$data['app']->area_l,
            'm_dag_area_g' =>$data['app']->area_g,
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr
            );
            $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
            if($insPetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR006: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                $data=array(
                  'error_code' => '#ERROR006',
                  'msg'=>"Registration of Office Mutation by Inheritance failed for case no : ".$application_no,
                  'status' => false
                );
                echo json_encode($data);
                return;
            }


            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$pending_officer->user_code,
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasu = $this->db->insert('basundhar_application',$basundhara);
            if($insBasu != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR007: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data=array(
                  'error_code' => '#ERROR007',
                  'msg'=>"Registration of Office Mutation by Inheritance failed for case no : ".$application_no,
                  'status' => false
                );
                echo json_encode($data);
                return;
            }

            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                  'error_code' => '#ERROR008',
                  'msg'=>"Error in submitting. Please try Again",
                  'status' => false
                );
                echo json_encode($data);
                return;
            }
            else
            {
              $pending_officer = $pending_officer->user_code;

              //insert on escalation details tables=============
               $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'OMUT',$from_officer_co->user_code);
              //end escalation==================================  
               if($escMatrixStatus['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>$escMatrixStatus['msg']
                    );
                }

              $this->db->trans_commit();
              $this->DashboardInheritance($case_no['case_no']);

              $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
              );
            }
            echo json_encode($data);
    }


    public function registrationFMUT($application_no,$service_code){

        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error_code' =>  '#ERROR001',
                'msg'        =>  "Case have been Registered Already. Please Check",
                'status'     =>  false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////


        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);
       
   


        $data['app']    =$output->application;


        if($data['app']->is_omut == 'Y'  || $data['app']->is_urban == 'Y'){

            $this->registrationOMUT($application_no,$service_code);
            return;
        }

        
        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

        
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']  =$output->applicants;
    

        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code); 
         if(empty($case_name)){
            $data=array(
                'error_code' => '#ERROR002',
                'msg'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>$data['secParty'][0]->trans_type,
            'dispute_yn'=> 0,
            'possession_yn'=>null,
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type'=>'01',                    
            'operation'=>'E',
            'user_code'=>$pending_officer->user_code,
            'es_flag' => 1
        );
     
        $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
        if($insFieldBasicFMUTI != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no,
                'status' => false,
            );
            echo json_encode($data);
            return;
        }
        //////Buyer Insert////////////
        $i=1;
        $file = null;
        foreach($data['firstParty'] as $pet){
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->Escalationmodel->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'guard_rel' =>$pet->pat_gurdian_rel_id <='-1' ? $this->utilityclass->relationRevertBasu($data['app']->dist_code,'7'):$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'pet_id' => $i++,
                'pdar_mobile'=>$pet->pat_mobile_no,
                'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:null,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo,
                'pdar_name_eng'=>$pet->pat_name_eng,
                'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
            );
            $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
            //log_message('error',$buyerInsert);
            if($insFieldPetFMUTI != 1)
            {
                log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.
                    $application_no.$this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no,
                    'status' => false,
                );
                echo json_encode($data);
                return;
            }
        }
        ////////Seller Insert//////////
        foreach($data['secParty'] as $pet){
            //////////////////////////////////
            if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$data['app']->dag_no,$data['pattaNo']->patta_no,$data['pattaNo']->patta_type_code,$pet->chitha_pdar_id);
                if($pet_father_name->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again",
                        'status' => false,
                    ); 
                    echo json_encode($data);
                    return;   
                }else{
                    $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                }

            }else{
                $pet->gurdian_name_ass=$pet->gurdian_name_ass;
            }
            ///////////////////////////
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=> $data['app']->dag_no,
                'patta_no'=> $data['pattaNo']->patta_no ,
                'patta_type_code'  => $data['pattaNo']->patta_type_code,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'striked_out' =>1,/////for inheritance//////
            );
            //var_dump($sellerInsert);
            $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
            if($insFieldPattaFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no,
                    'status' => false,
                );
                echo json_encode($data);
                return;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$data['pattaNo']->patta_no ,
            'patta_type_code'  => $data['pattaNo']->patta_type_code ,
            'm_dag_area_b'  =>$data['app']->area_b,
            'm_dag_area_k'  =>$data['app']->area_k,
            'm_dag_area_lc' =>$data['app']->area_l,
            'm_dag_area_g'  =>$data['app']->area_g,
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr,
            'remark' =>null
            );
            $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
            if($insFiledDagFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no,
                    'status' => false,
                );
                echo json_encode($data);
                return;
            }


            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$pending_officer->user_code,
                'app_status'=>'P',
                'pending_with'=>'LM'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no,
                    'status' => false,
                );
                echo json_encode($data);
                return;
            }
            
            if($this->db->trans_status()==FALSE){

                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again",
                    'status' => false,
                );
                echo json_encode($data);
                return;

            }else{

                $pending_officer = $pending_officer->user_code;

                //insert on escalation details tables=============
                $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'FMUT',$from_officer_co->user_code);
                //end escalation================================== 
                if($escMatrixStatus['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>$escMatrixStatus['msg']
                    );
                }
                $this->db->trans_commit();
            
                $data=array(
                    'error_code' => null,
                    'msg'=>  "Application Registered FMUT",
                    'status' => true,
                    'case_no' => $case_no['case_no']
                );
        }
        echo json_encode($data);
    }


    public function registrationMutationMultigen($application_no,$service_code){

        //////////////////
        // $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        // if($recordExist){
        //     $data=array(
        //         'error_code' =>  '#ERROR001',
        //         'msg'        =>  "Case have been Registered Already. Please Check",
        //         'status'     =>  false
        //     );
        //     echo json_encode($data);
        //     return;
        //     exit;
        // }
        /////////////////////


        $fetchData = $this->getDetailsByCurlMultiGen($application_no);
        $output = json_decode($fetchData);
        // echo "<pre>";
        // var_dump($output);
        // die;
    


        $data['app']    =$output->application;


        if($data['app']->is_omut == 'Y'  || $data['app']->is_urban == 'Y'){

            if($data['app']->is_multigeneration == "M"){
                return $this->inheritancePostOfficeMultiGeneration($application_no,$service_code);
            }
            elseif($data['app']->is_multigeneration == "S")
            {
                return $this->inheritancePostOfficeSingleGeneration($application_no,$service_code);
            }
            else
            {
                //for old service auto register==========
                $this->registrationOMUT($application_no,$service_code);
                return;
            }
        }

        if($data['app']->is_multigeneration == "M"){
            return $this->inheritancePostMultiGeneration($application_no,$service_code);
        }
        elseif($data['app']->is_multigeneration == "S")
        {
            return $this->inheritancePostSingleGeneration($application_no,$service_code);
        }
        else
        {
            //for old service auto register==========
            $this->registrationFMUT($application_no,$service_code);
            return;
        }

    }

    public function getDetailsByCurl($application_no){
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function insertIntoEscalationMatrix($petition_no,$case_no,$service_code,$pending_officer,$service_name,$from_officer_co){

        // var_dump($petition_no,$case_no,$service_code,$pending_officer,$service_name);
      $da_target_days  = 0;
      $da_allocate_days  = 0;
      $da_completed_days = 0;
      $da_date_code_list = null;
      $da_escalate_status = null;
      $lm_target_days  = 0;
      $lm_allocate_days  = 0;
      $lm_completed_days = 0;
      $lm_date_code_list = null;
      $lm_escalate_status = null;
      $sk_target_days  = 0;
      $sk_allocate_days  = 0;
      $sk_completed_days = 0;
      $sk_date_code_list = null;
      $sk_escalate_status = null;
      $co_target_days  = 0;
      $co_allocate_days  = 0;
      $co_completed_days = 0;
      $co_date_code_list = null;
      $co_escalate_status = null;
      $bo_target_days  = 0;
      $bo_allocate_days  = 0;
      $bo_completed_days = 0;
      $bo_date_code_list = null;
      $bo_escalate_status = null;
      $adc_target_days  = 0;
      $adc_allocate_days  = 0;
      $adc_completed_days = 0;
      $adc_date_code_list = null;
      $adc_escalate_status = null;
      $dc_target_days  = 0;
      $dc_allocate_days  = 0;
      $dc_completed_days = 0;
      $dc_date_code_list = null;
      $dc_escalate_status = null;
      $dept_target_days  = 0;
      $dept_allocate_days  = 0;
      $dept_completed_days = 0;
      $dept_date_code_list = null;
      $dept_escalate_status = null;
      $sro_target_days  = 0;
      $sro_allocate_days  = 0;
      $sro_completed_days = 0;
      $sro_date_code_list = null;
      $sro_escalate_status = null;
      $mouzadar_target_days  = 0;
      $mouzadar_allocate_days  = 0;
      $mouzadar_completed_days = 0;
      $mouzadar_date_code_list = null;
      $mouzadar_escalate_status = null;
      $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,$service_name);

      
      $dateCode    = $this->Escalationmodel->generateDateCode();
      $case_type   = 0;
      $user_allot_code = json_decode(USER_ALLOT_CODE);
      if($service_code == 1 || $service_code == 2 || $service_code == 3 || $service_code == 4 || $service_code == 20 || $service_code == 9 || $service_code == 8 || $service_code == 7 || $service_code == 6 || $service_code == 5){

        $da_target_days = $timeLineRow->da_allocated_days;
        $lm_target_days = $timeLineRow->lm_allocated_days;
        $co_target_days = $timeLineRow->co_allocated_days;
        $sk_target_days = $timeLineRow->sk_allocated_days;
        $adc_target_days = $timeLineRow->adc_allocated_days;
        $dc_target_days = $timeLineRow->dc_allocated_days;
        $bo_target_days = $timeLineRow->bo_allocated_days;
        $dept_target_days = $timeLineRow->dept_allocated_days;
        $sro_target_days = $timeLineRow->sro_allocated_days;
        $mouzadar_target_days = $timeLineRow->mouzadar_allocated_days;

        if($service_code == 6)
        {
          $lm_date_code_list = $dateCode;
        }
        else
        {
          $co_date_code_list = null;
        }

        $co_date_code_list = $dateCode;
        if($service_name == 'OMUT' || $service_name =='OPART' || $service_name == 'OMUTD'){
          $task = json_decode(OMUT_TASK);
          $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
          $assigned_to_code = $user_allot_code[5]->CODE;
        }
        if($service_name == 'FMUT' || $service_name =='FPART' || $service_name == 'FMUTD'){
          $task = json_decode(FMUT_TASK);
          $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
          $assigned_to_code = $user_allot_code[8]->CODE;
        }
        if($service_code == 4){
            $task = json_decode(RECLASS);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
            $assigned_to_code = $user_allot_code[8]->CODE;
        }
        if($service_code == 5){
            $task = json_decode(ALLOT);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
            $assigned_to_code = $user_allot_code[5]->CODE;
        }
        if($service_code == 9){
            $task = json_decode(CONV);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
            $assigned_to_code = $user_allot_code[5]->CODE;
        }
        if($service_code == 20){
            $task = json_decode(ANCOR);
            if($service_name == 'MCOR'){
                $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
                $assigned_to_code = $user_allot_code[5]->CODE;
            }else{
                $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
                $assigned_to_code = $user_allot_code[8]->CODE;
            }
            
        }
        if($service_code == 8){
            $task = json_decode(NCAN);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
            $assigned_to_code = $user_allot_code[5]->CODE;
        }
        if($service_code == 7){
            $task = json_decode(ACOR);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
            $assigned_to_code = $user_allot_code[5]->CODE;
        }
        if($service_code == 6){
            $task = json_decode(NCOR);
            $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
            $assigned_to_code = $user_allot_code[8]->CODE;
            // $assigned_to_code = $user_allot_code[5]->CODE;
        }

      }

      $assignment_type = json_decode(ASSIGNMENT_TYPE);
      

      $date = date('Y-m-d H:i:s');
      if($service_code == 1 || $service_code == 2 || $service_code == 3 || $service_code == 20 || $service_code == 9 || $service_code == 8 || $service_code == 7)
      {
        
        $assigned_from_code    = $user_allot_code[5]->CODE; // CO
        $assignment_type_other = null;
        $assigned_other        = null;
        $assigned_other_date   = null;
        $assigned_other_es_date= null;
        $to_be_other_completed_within_days = null;

      }

      else if($service_code == 6) //  name correction for new process
      {
        $assigned_from_code    = $user_allot_code[5]->CODE; // LM
        $assignment_type_other = null;
        $assigned_other        = null;
        $assigned_other_date   = null;
        $assigned_other_es_date= null;
        $to_be_other_completed_within_days = null;
      }

      else if($service_code == 4) // reclassification
      {
        $assigned_from_code    = $user_allot_code[2]->CODE; // ADC
        $assignment_type_other = null;
        $assigned_other        = null;
        $assigned_other_date   = null;
        $assigned_other_es_date= null;
        $to_be_other_completed_within_days = null;
      }

      else if($service_code == 5) // allotment
      {
        $assigned_from_code    = $user_allot_code[1]->CODE; // DC
        $assignment_type_other = null;
        $assigned_other        = null;
        $assigned_other_date   = null;
        $assigned_other_es_date= null;
        $to_be_other_completed_within_days = null;
      }
      
      
      $insertArray = array(
        'case_no'     => $case_no,
        'taskid'      => $task[0]->CODE,
        'petition_no' => $petition_no,
        'service_code'=>$service_code,
        'registerd_on' => $date,
        'total_days'  => $timeLineRow->total_timeline,
        'status'      => 'P',
        'assignment_type' => $assignment_type[0]->CODE,
        'assigned_from'   => $from_officer_co,
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'     => $pending_officer,
        'assigned_to_code'=> $assigned_to_code,
        'assigned_date'   => $date,
        'escalated_date'  => $escalatedDate,
        'history_id'      => $dateCode,
        'to_be_completed_within_days' => $this->Escalationmodel->dateDiff($escalatedDate,date('Y-m-d H:i:s')),
        'assignment_type_other' => $assignment_type_other,
        'assigned_other'   => $assigned_other,
        'assigned_other_date'   => $assigned_other_date,
        'assigned_other_es_date' => $assigned_other_es_date,
        'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
        'da_target_days'  =>$da_target_days,
        'da_allocate_days'=>$da_allocate_days,
        'da_completed_days'=>$da_completed_days,
        'da_date_code_list'=>$da_date_code_list,
        'da_escalate_status'=>$da_escalate_status,
        'lm_target_days'=>$lm_target_days,
        'lm_allocate_days'=>$lm_allocate_days,
        'lm_completed_days'=>$lm_completed_days,
        'lm_date_code_list'=>$lm_date_code_list,
        'lm_escalate_status'=>$lm_escalate_status,
        'sk_target_days'=>$sk_target_days,
        'sk_allocate_days'=>$sk_allocate_days,
        'sk_completed_days'=>$sk_completed_days,
        'sk_date_code_list'=>$sk_date_code_list,
        'sk_escalate_status'=>$sk_escalate_status,
        'co_target_days'=>$co_target_days,
        'co_allocate_days'=>$co_allocate_days,
        'co_completed_days'=>$co_completed_days,
        'co_date_code_list'=>$co_date_code_list,
        'co_escalate_status'=>$co_escalate_status,
        'bo_target_days'=>$bo_target_days,
        'bo_allocate_days'=>$bo_allocate_days,
        'bo_completed_days'=>$bo_completed_days,
        'bo_date_code_list'=>$bo_date_code_list,
        'bo_escalate_status'=>$bo_escalate_status,
        'adc_target_days'=>$adc_target_days,
        'adc_allocate_days'=>$adc_allocate_days,
        'adc_completed_days'=>$adc_completed_days,
        'adc_date_code_list'=>$adc_date_code_list,
        'adc_escalate_status'=>$adc_escalate_status,
        'dc_target_days'=>$dc_target_days,
        'dc_allocate_days'=>$dc_allocate_days,
        'dc_completed_days'=>$dc_completed_days,
        'dc_date_code_list'=>$dc_date_code_list,
        'dc_escalate_status'=>$dc_escalate_status,
        'dept_target_days'=>$dept_target_days,
        'dept_allocate_days'=>$dept_allocate_days,
        'dept_completed_days'=>$dept_completed_days,
        'dept_date_code_list'=>$dept_date_code_list,
        'dept_escalate_status'=>$dept_escalate_status,
        'sro_target_days'=>$sro_target_days,
        'sro_allocate_days'=>$sro_allocate_days,
        'sro_completed_days'=>$sro_completed_days,
        'sro_date_code_list'=>$sro_date_code_list,
        'sro_escalate_status'=>$sro_escalate_status,
        'mouzadar_target_days'=>$mouzadar_target_days,
        'mouzadar_allocate_days'=>$mouzadar_allocate_days,
        'mouzadar_completed_days'=>$mouzadar_completed_days,
        'mouzadar_date_code_list'=>$mouzadar_date_code_list,
        'mouzadar_escalate_status'=>$mouzadar_escalate_status,
        'created_date'=> $date,
        'updated_date'=> $date,
      );

      $status = $this->db->insert('escalation_details',$insertArray);

      if($status != 1){
        $this->db->trans_rollback();
        log_message('error',"INSERTION ERROR IN escalation_details table=========".$this->db->last_query());
        $data=array(
          'responseType' => 1,
          'msg'=>"#ERROR1386 ESCMATRIX : Error in submitting. Please try Again",
          'status' => false
        );
        // echo json_encode($data);
        return $data;

      }



      $insertDateArray = array(
        'sr_no' => $dateCode,
        'petition_no'    => $petition_no,
        'case_no'        =>$case_no,
        'date_code'      => $dateCode,
        'service_code'   =>$service_code,
        'taskid'         =>$task[0]->CODE,
        'action_type'    => $assignment_type[0]->CODE,  
        'pending_officer' => $pending_officer,
        'assigned_user'  => $from_officer_co,
        'assigned_user_code' => $assigned_from_code,
        'assigned_to'    => $pending_officer,
        'assigned_to_code' => $assigned_to_code,
        'registerd_on'   => $date,
        'allocation_date' => $date,
        'target_completion_date' => $escalatedDate,
        'completion_date' => null,
        'date_diff'      => $this->Escalationmodel->dateDiff($escalatedDate,date('Y-m-d H:i:s')),
        'escalated_status' => null,
        'completion_days' => null,
        'created_date'   => $date,
        'updated_date'   => $date,
      );

      $status1 = $this->db->insert('escalation_dates_details',$insertDateArray);
      if($status1 != 1){
        $this->db->trans_rollback();
        log_message('error',"INSERTION ERROR IN escalation_dates_details table=========".$this->db->last_query());
        $data=array(
          'responseType' => 1,
          'msg'=>"#ERROR1425 ESCMATRIX : Error in submitting. Please try Again",
          'status' => false
        );
        // echo json_encode($data);
        return $data;

      }

      $escLocation = $this->insertEscalationLocation($case_no);
      if($escLocation != 1)
      {
        $this->db->trans_rollback();
        log_message('error',"INSERTION ERROR IN escalation_location table=========".$this->db->last_query());
        $data=array(
          'responseType' => 1,
          'msg'=>"#ERROR1531 ESCMATRIX : Error in submitting. Please try Again",
          'status' => false
        );
        // echo json_encode($data);
        return $data;
      }


        $data=array(
          'responseType' => 2,
          'msg'=>"#ERROR1386 ESCMATRIX : Error in submitting. Please try Again",
          'status' => false
        );
      return $data;
      
    }


    public function mutationDeedRegistration($application_no,$service_code){

          $this->registrationDeedFMUT($application_no,$service_code);
    }
    public function registrationDeedFMUT($application_no,$service_code){
        //////////////////
        // $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        // if($recordExist){
        //         $data=array(
        //             'error'=>"Case have been Registered Already. Please Check",
        //             'status' => false
        //         );
        //         echo json_encode($data);
        //         exit;
        // }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);

        $output = json_decode($fetchData);
        // echo "<pre>";
        // var_dump($output);
        // die;

        $data['app']=$output->application;
        if($data['app']->is_omut == 'Y'  || $data['app']->is_urban == 'Y'){

            $this->registrationDeedOMUT($application_no,$service_code);
            return;
        }

        //designed for fetch the registration pending officer===============
        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);

        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        //var_dump($data);
    

        //#START PLB--->
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('01');

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false,
            );
            echo json_encode($data);
            return;
        }

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'03',
            'dispute_yn'=>0,
            'possession_yn'=>null,
            'petition_no'=>$case_no['petition_no'],
            'year_no'  =>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type' =>'01',                    
            'operation'=>'E',
            'noc_no'      => $data['secParty'][0]->noc_no,
            'noc_date'    => $data['secParty'][0]->noc_date,
            'reg_deed_no' => $data['secParty'][0]->deed_no,
            'deed_value'  => $data['secParty'][0]->deed_value,
            'reg_deed_date' =>$data['secParty'][0]->deed_date,
            'es_flag' => 1
        );
        $insFieldBasicFMUTD = $this->db->insert('field_mut_basic',$basic);
        if($insFieldBasicFMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFMUTD001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFMUTD001: Registration of Field Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        foreach($data['firstParty'] as $pet){
            $file = null;
            if($pet->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->Escalationmodel->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'pet_id' => $i++,
                'pdar_mobile'=>$pet->pat_mobile_no,
                'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:null,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo,
                'pdar_name_eng'=>$pet->pat_name_eng,
                'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
            );
            $insFieldPetFMUTD = $this->db->insert('field_mut_petitioner', $buyerInsert);
            if($insFieldPetFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD002: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        ////////Seller Insert//////////
        foreach($data['secParty'] as $pet){
            //////////////////////////////////
            if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$data['app']->dag_no,$data['pattaNo']->patta_no,$data['pattaNo']->patta_type_code,$pet->chitha_pdar_id);
                if($pet_father_name->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again",
                        'status' => false
                    ); 
                    echo json_encode($data);
                    return;   
                }else{
                    $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                }

            }else{
                $pet->gurdian_name_ass=$pet->gurdian_name_ass;
            }
            ///////////////////////////
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$data['pattaNo']->patta_no ,
                'patta_type_code'  =>$data['pattaNo']->patta_type_code ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                // 'striked_out' =>$_POST[$pet->chitha_pdar_id],/////for inheritance//////
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'striked_out' =>null,
            );
            //var_dump($sellerInsert);
            $insFieldMutPattaFMUTD = $this->db->insert('field_mut_pattadar', $sellerInsert);
            if($insFieldMutPattaFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD003: Registration of Field Mutation by Deed failed for case no : ".$application_no,
                    'status'=>false
                );
                echo json_encode($data);
                return false;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>      $data['pattaNo']->patta_no ,
            'patta_type_code'  => $data['pattaNo']->patta_type_code,
            'm_dag_area_b' => $data['secParty'][0]->area_b,
            'm_dag_area_k' => $data['secParty'][0]->area_k,
            'm_dag_area_lc'=> $data['secParty'][0]->area_l,
            'm_dag_area_g' => $data['secParty'][0]->area_go,
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,
            'dag_area_kr' =>$dag_area_kr,
            'remark' =>null,
            'deed_reg_no'=>$data['secParty'][0]->deed_no,
            'deed_date'  =>$data['secParty'][0]->deed_date,
            'deed_value' =>$data['secParty'][0]->deed_value,
            );
            $insFieldMutDagDetFMUTD = $this->db->insert('field_mut_dag_details',$dagDetails);
            if($insFieldMutDagDetFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD004: Registration of Field Mutation by Deed failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return false;
            }
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$pending_officer->user_code,
                'app_status'=>'P',
                'pending_with'=>'LM'
            );

            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuFMUTD = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD005: Registration of Field Mutation by Deed failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return false;
            }
            
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again",
                    'status' => false
                );
                echo json_encode($data);
                return;
            }
            else
            {  
                $pending_officer = $pending_officer->user_code;
                //insert on escalation details tables=============
                $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'FMUTD',$from_officer_co->user_code);
                //end escalation================================== 
                if($escMatrixStatus['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>$escMatrixStatus['msg']
                    );
                }
                $this->db->trans_commit();
            
                $data=array(
                    'error_code' => null,
                    'msg'=>  "Application Registered",
                    'status' => true,
                    'case_no' => $case_no['case_no']
                );              
                
            }
        echo json_encode($data);
    }

    public function registrationDeedOMUT($application_no,$service_code){
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);
        $data['app']=$output->application;


        //designed for fetch the registration pending officer===============
        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');
        

        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');



        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        //var_dump($data);
         $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);

        if(empty($case_name)){
            $data=array(
                'error'  =>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>'03',//////sale deed
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$pending_officer->user_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => null,
            'noc_no'=>$data['secParty'][0]->noc_no,
            'noc_date'=>$data['secParty'][0]->noc_date,
            'deed_no' => $data['secParty'][0]->deed_no,
            'deed_value' => $data['secParty'][0]->deed_value,
            'deed_date' => $data['secParty'][0]->deed_date,
            'es_flag' => 1
        );
        $insPetBasicOMUTD = $this->db->insert('petition_basic',$basic);
        //echo $this->db->last_query();return;
        if($insPetBasicOMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMUTD001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROMUTD001: Registration of Office Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        //////Buyer Insert////////////
        $i=1;
        foreach($data['firstParty'] as $pet){

            //newly added aadhaar integration in dharitree---------10052023
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type =='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            //end code-------------------------


            $faddress=$this->Escalationmodel->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'pdar_name_eng' => $pet->pat_name_eng,
                'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                // 'guard_rel' => 'f', //////////////////////to be update
                // 'pet_gender'=>$pet->pat_gender,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                'pet_id' => $i++,
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'user_code' => $pending_officer->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                'pdar_mobile' => $pet->pat_mobile_no,
                'applied_b' =>0,
                'applied_k' => 0,
                'applied_lc' => 0,
                'self_declaration' => $dec,
                'auth_type'        => $auth_type,
                'id_ref_no'        => $id_ref_no,
                'photo'            => $photo,
            );
            $insPetitionerOMUTD = $this->db->insert('petitioner', $buyerInsert);
            if($insPetitionerOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD002: Insertion failed in petitioner RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD002: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$data['pattaNo']->patta_no,
                'patta_type_code'  => $data['pattaNo']->patta_type_code ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'dag_no' =>$data['app']->dag_no,
                'pdar_id' =>  $pet->chitha_pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $insPetPattadarOMUTD = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadarOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD003: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$data['pattaNo']->patta_no ,
            'patta_type_code'  =>$data['pattaNo']->patta_type_code ,
            'm_dag_area_b'=>floor($data['secParty'][0]->area_b),
            'm_dag_area_k' =>$data['secParty'][0]->area_k,
            'm_dag_area_lc' =>$data['secParty'][0]->area_l,
            'm_dag_area_g' =>$data['secParty'][0]->area_go,
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr
            );
            $insPetDagOMUTD = $this->db->insert('petition_dag_details',$dagDetails);
            if($insPetDagOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD004: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
           $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$pending_officer->user_code,
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuOMUTD = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD005: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
            }
            else
            {


                //////////////////
                
                

                $pending_officer = $pending_officer->user_code;
                //insert on escalation details tables=============
                $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'OMUTD',$from_officer_co->user_code);
                //end escalation==================================
                if($escMatrixStatus['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>$escMatrixStatus['msg']
                    );
                } 
                $this->db->trans_commit();
                $this->DashboardInheritance($case_no['case_no']);
            
                $data=array(
                    'error_code' => null,
                    'msg'=>  "Application Registered",
                    'status' => true,
                    'case_no' => $case_no['case_no']
                );  
            }
        echo json_encode($data);
    }


    public function partitionRegistration($application_no,$service_code){

        $this->registrationFPART($application_no,$service_code);
    }

    public function registrationFPART($application_no,$service_code){
        
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check",
                    'status' => false
                );
                echo json_encode($data);
                return;
                exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);

        $data['app']=$output->application;
        if($data['app']->is_omut == 'Y'  || $data['app']->is_urban == 'Y'){

            $this->registrationOPART($application_no,$service_code);
            return;
        }

        //designed for fetch the registration pending officer===============
        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);


        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
    
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('02');

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/FPART";

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FPART";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'01',
            'dispute_yn'=>0,
            'possession_yn'=>'y',
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type'=>'02',                    
            'operation'=>'E',
            'es_flag' => 1
        );
        $insBasicFPART = $this->db->insert('field_mut_basic', $basic);
        if($insBasicFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART001: Registration of Field Partition failed for case no : ".$application_no,
                'status'    =>false
            );
            echo json_encode($data);
            return;
        }
        $fmd=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;

        $fmd['m_dag_area_b']=$data['firstParty'][0]->area_b;
        $fmd['m_dag_area_k']=$data['firstParty'][0]->area_k;
        $fmd['m_dag_area_lc']=$data['firstParty'][0]->area_l;

        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;



        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
            $fmd['m_dag_area_g']=$data['firstParty'][0]->area_go;
            $fmd['dag_area_g']=$data['pattaNo']->dag_area_g;

        }
        else {
            $fmd['m_dag_area_g']='0.00'; 
            $fmd['dag_area_g']='0';   
        }
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_kr']='0';
        $fmd['remark'] = null;
        $insDagFPART = $this->db->insert('field_mut_dag_details',$fmd);
        if($insDagFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART002: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART002: Registration of Field Partition failed for case no : ".$application_no,
                'status'=>false
            );
            echo json_encode($data);
            return;
        }
        $i=1;
        foreach($data['firstParty'] as $part){
            $file = null;
            if($part->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $part->auth_type;
                $id_ref_no = $part->id_ref_no;
                if($part->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $part->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $petitioner=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'operation'=>'E',
                    'dag_no' =>$data['app']->dag_no,
                    'patta_no' =>$data['pattaNo']->patta_no,
                    'patta_type_code'=>$data['pattaNo']->patta_type_code,
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'date_entry'=>date('Y-m-d'),
                    'pdar_id' =>$part->chitha_pdar_id,
                    'pdar_cron_no'=>$i++,
                    'pdar_name' =>$part->name_ass,
                    'pdar_guardian' =>$part->gurdian_name_ass,
                    // 'pdar_rel_guar' =>'f',
                    // 'pdar_gender'=>'m',
                    'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),/////////////
                    'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gender),
                    'pdar_dag_por_b' =>$part->area_b,
                    'pdar_dag_por_k' =>$part->area_k,
                    'pdar_dag_por_lc' =>$part->area_l,
                    'pdar_dag_por_g' =>$part->area_go,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'=> null,
                    'applicant_info' => json_encode($part)
                );
            $insPetFPART = $this->db->insert('field_part_petitioner',$petitioner);
            if($insPetFPART != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFPART003: Insertion failed in field_part_petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFPART003: Registration of Field Partition failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return;
            }
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'LM'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuFPART = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART004: Registration of Field Partition failed for case no : ".$application_no
            );
            echo json_encode($data);
            return;
        }

        

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again",
                'status' =>false
            );
        }else
        {
            
           

            
            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'FPART',$from_officer_co->user_code);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $this->DashboardPartitionField($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );

            
        }
        echo json_encode($data);
    }


    function DashboardPartitionField($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select * from field_mut_basic fmb left join field_mut_dag_details fmd on fmb.case_no=fmd.case_no where fmb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='01'){
            $type='FM';
        }else{
            $type='FP';
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'SK',
              'case_type' =>$type,
            );
        
            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);
            $this->db->insert('dashboard_data',$base);
            $this->dbb->insert('dashboard_data',$base);
            
    }

    public function registrationOPART($application_no,$service_code){


        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);


        $data['app']=$output->application;


        //designed for fetch the registration pending officer===============
        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');
        

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('04');

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/OPART";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OPART";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'04',                    
            'operation'=>'E',
            'submission_date' => date('Y-m-d G:i:s'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'add_off_name' => $pending_officer->user_code,
            'add_off_desig' => 'CO',
            'co_user_code' => $pending_officer->user_code,
            'complete_partition_yn' => 'Y',
            'es_flag' => 1
        );

        $insBasicOPART = $this->db->insert('petition_basic', $basic);
        if($insBasicOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART001: Registration of Office Partition failed for case no : ".$application_no,
                'status' =>false
            );
            echo json_encode($data);
            return;
        }

        $fmd=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;
        $fmd['m_dag_area_b']=$data['firstParty'][0]->area_b;
        $fmd['m_dag_area_k']=$data['firstParty'][0]->area_k;
        $fmd['m_dag_area_lc']=$data['firstParty'][0]->area_l;
        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
            $fmd['m_dag_area_g']=$data['firstParty'][0]->area_go;
            $fmd['dag_area_g']=$data['pattaNo']->dag_area_g;

        }
        else {
            $fmd['m_dag_area_g']='0.00'; 
            $fmd['dag_area_g']='0';   
        }
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_kr']='0';
        $insDagOPART = $this->db->insert('petition_dag_details',$fmd);
        if($insDagOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART002: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART002: Registration of Office Partition failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return;
        }

        $i=1;
        foreach($data['firstParty'] as $part)
        {

            $file = null;
            if($part->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $part->auth_type;
                $id_ref_no = $part->id_ref_no;
                if($part->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $part->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
                $applicant_info = json_encode($part);
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
                $applicant_info = null;
            }


            $petitioner=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$data['app']->dag_no,
                'patta_no' =>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),

                'pdar_id' =>$part->chitha_pdar_id,
                'pdar_cron_no'=>$i++,
                'pdar_name' =>$part->name_ass,
                'pdar_guardian' =>$part->gurdian_name_ass,
                //'pdar_rel_guar' =>'f',/////////////
                //'pdar_gender'=>$part->gender,
                'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gender),/////////////
                'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),
                //'pdar_add1' => $part->address,
                // 'pdar_add1' => substr($part->address,0,90),
                // 'pdar_add2' => substr($part->address,90,150),
                'pdar_strike' => 'N',
                'is_converted_pattadar' => 'N',
                'pdar_mobile' => $part->mobile,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no' => $id_ref_no,
                'photo'     => null,
                'applicant_info' => $applicant_info
            );
            $insPetitionerOPART = $this->db->insert('petitioner_part',$petitioner);
            if($insPetitionerOPART != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROPART003: Insertion failed in petitioner_part for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROPART003: Registration of Office Partition failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return;
            }
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );

        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuOPART = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART004: Registration of Office Partition failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }
        else
        {
            
            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'OPART',$from_officer_co->user_code);
            //end escalation==================================
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            } 
            $this->db->trans_commit();

            $this->DashboardPartitionofc($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
            
        }
        echo json_encode($data);
    }


    public function reclassRegistration($application_no,$service_code){

        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);


        $data['app']=$output->application;

        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

        $from_officer_co = $this->Escalationmodel->getPendingOfficerADC($data['app']->dist_code,'ADC');


        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        $file = null;
        if(isset($data['secParty'][0]->chitha_pdar_id) && $data['secParty'][0]->chitha_pdar_id != null){
            $pdar_id = $data['secParty'][0]->chitha_pdar_id;
        }else{
            $pdar_id = null;
        }
        $chitha_pdar_id = null;
        if($data['secParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['secParty'][0]->auth_type;
            $id_ref_no = $data['secParty'][0]->id_ref_no;
            if($data['secParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['secParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
                $chitha_pdar_id = $pdar_id;
            }else if($data['secParty'][0]->auth_type=='PAN'){
                $chitha_pdar_id = $pdar_id;
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $year_no = year_no;
        $co_report1 = null;
        $co_report_suffix = null;
        $co_report = null;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['app']->area_g==null?"0":$data['app']->area_g;
            $dag_area_kr = $data['app']->area_kr==null?"0":$data['app']->area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }
        $this->db->trans_begin();

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);

         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session time out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
            die();
        }


        $seq_pet=year_no.'0';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteReclassPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/RECLASS";

        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'proposal_no' => $case_no['petition_no'],
            'dag_no' => $data['app']->dag_no,
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'present_land_class' => $data['firstParty'][0]->old_classification,
            'present_land_revenue' => $data['pattaNo']->dag_revenue,
            'present_land_localtax' => $data['pattaNo']->dag_local_tax,
            'present_total_revenue' => $data['pattaNo']->sum,
            'new_landuse_year' => $data['firstParty'][0]->year_of_use,
            'dag_area_b' => $data['app']->area_b,
            'dag_area_k' => $data['app']->area_k,
            'dag_area_lc' => $data['app']->area_l,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => $dag_area_kr,
            'proposed_land_class' => $data['firstParty'][0]->new_classification,
            'proposed_land_revenue' => null,
            'proposed_land_localtax' => null,
            'revenue_diff' => null,
            'lm_code' => $pending_officer->user_code,
            'lm_yn' => null,
            'lm_date' => null,
            'case_no' => $case_no['case_no'],
            'year_no' => $year_no,
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo,
            'pdar_id' => $chitha_pdar_id,
            'es_flag' => 1,
            'date_entry' => date('Y-m-d H:i:s'),
            'applicant_info' => json_encode($data['secParty']),

        );

        $insTReclass = $this->db->insert('t_reclassification',$basic);
        if($insTReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in t_reclassification for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Reclassification failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return;
        }
       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuRECLASS = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRRECLASS002: Registration of Reclassification failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
    
        //////////////////////////////////
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again",
                'status' => false
            );
        }
        else
        {
            $pending_officer = $pending_officer->user_code;

            // var_dump($petition_no.', '.$case_no['case_no'].', '.$service_code.', '.$pending_officer.', '.'RECLASS'.', '.$from_officer_co->user_code); die;

            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'RECLASS',$from_officer_co->user_code);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();

            
            $this->DashboardReclass($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    
    }

    public function DashboardReclass($case_no)
    {
        //$this->dbb = $this->load->database('dash', TRUE);

        $sql="select * from t_reclassification where case_no='$case_no' ";
        
        $type='RC';
        $data=$this->db->query($sql)->row_array();
        $base= array(
                'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['lm_date'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'LM',
                  'case_type' =>$type,
              );
       // $this->db->insert('dashboard_data',$base);

        unset($base['dag_no']);
        unset($base['patta_type_code']);
        unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);

    }

    public function DashboardPartitionofc($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
            where  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='04'){
            $type='OP';
        }else{
            
        }
        $base= array(
          'dist_code'=> $data['dist_code'],
          'subdiv_code' =>$data['subdiv_code'],
          'cir_code'=>$data['cir_code'],
          'mouza_pargona_code'=>$data['mouza_pargona_code'],
          'lot_no'=>$data['lot_no'],
          'vill_townprt_code'=>$data['vill_townprt_code'],
          'case_no'=>$data['case_no'],
          'date_of_reg'=>$data['date_entry'],
          'dag_no'=>$data['dag_no'],
          'patta_type_code' =>$data['patta_type_code'],
          'patta_no' =>$data['patta_no'],
          'status' =>'P',
          'pending_with_user' =>'CO',
          'case_type' =>$type,
        );
        $this->dbb->insert('dashboard_data',$base);


        unset($base['dag_no']);
        unset($base['patta_type_code']);
        unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);
        
    }

    public function allotmentRegistration($application_no,$service_code)
    {
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);


        $data['app']=$output->application;

        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

        $from_officer_co = $this->Escalationmodel->getPendingOfficerDC($data['app']->dist_code,'DC');


        $data['app']=$output->application;

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        $data['firstParty']=$output->mutation;
        $this->db->trans_begin();


        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteAlotPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/ACPP";

        $allotment_basic = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'year_no'=>date('Y'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'allotment_under' => $data['firstParty'][0]->scheme_id,
            'petition_no' => $case_no['petition_no'],
            'original_alotee' => $data['firstParty'][0]->is_original,
            'name_of_allote' => $data['firstParty'][0]->allotee_name,
            'type_govt_land' => $data['firstParty'][0]->land_type,
            'es_flag' =>1
        );

        $insBasicACPP = $this->db->insert('allotment_cert_basic', $allotment_basic);
        if($insBasicACPP != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACPP001: Insertion failed in allotment_cert_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACPP001: Registration of Land Allotment failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }

            $alotid = 1;
            foreach ($data['firstParty'] as $mp) {
                $aadharNo = null;
                $panNo =null;
                if($mp->is_applicant == '1'){
                    $file =null;
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $mp->auth_type;
                    $id_ref_no = $mp->id_ref_no;
                    if($mp->auth_type=='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $mp->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                        $aadharNo = $mp->id_ref_no;
                        $panNo = null;
                    }else if($mp->auth_type=='PAN'){
                        $aadharNo = null;
                        $panNo = $mp->id_ref_no;
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $allotment_petitioner = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'circle_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'case_no'=>$case_no['case_no'],
                    'year_no'=>date('Y'),
                    'alotee_id' => $alotid,
                    'alotee_name' => $mp->name_ass,
                    //'alotee_gender' => $mp->gender,
                    //'alotee_reln' => $mp->gurdian_relation_id,
                    'alotee_reln' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$mp->gender),/////////////
                    'alotee_gender'=>$mp->gurdian_relation_id,//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$mp->gurdian_relation_id),
                    'alotee_gurdian' => $mp->gurdian_name_ass,
                    'alotee_mobile' => $mp->mobile,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'alotee_pan_card'=> $panNo,
                    'alotee_aadhar' => $aadharNo, 
                    'photo'=> $photo
                );
                $insPetACPP = $this->db->insert('allotment_petitioner', $allotment_petitioner);
                
                if($insPetACPP != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error',$this->db->last_query());
                    log_message('error', '#ERRACPP002: Insertion failed in allotment_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRACPP002: Registration of Land Allotment failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                $alotid = $alotid + 1;
                }
        
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        $allotment_dag = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'case_no'=>$case_no['case_no'],
            'year_no'=>date('Y'),
            'dag_no' =>$data['app']->dag_no,
            'patta_no' =>$data['pattaNo']->patta_no,
            'patta_type_code'=>$data['pattaNo']->patta_type_code,
            'alot_area_b' => $data['app']->area_b,
            'alot_area_k' =>$data['app']->area_k,
            'alot_area_lc' => $data['app']->area_l,
            'alot_area_g' => $data['app']->area_g,
            'tot_area_b' => $data['pattaNo']->dag_area_b,
            'tot_area_k' => $data['pattaNo']->dag_area_k,
            'tot_area_lc' => $data['pattaNo']->dag_area_lc,
            'date_entry' => date('Y-m-d')
        );    
        ///////////// BARAK VALLEY CODE ENDS HERE ////////////////

        $insDagACPP = $this->db->insert('allotment_pet_dag', $allotment_dag);
        if($insDagACPP != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACPP003: Insertion failed in allotment_pet_dag for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACPP003: Registration of Land Allotment failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        $allotment_doc_details = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'case_no'=>$case_no['case_no'],
            'year_no'=>date('Y'),
            'certficate_no' => $data['firstParty'][0]->order_no,
            'date_of_issue' => $data['firstParty'][0]->order_date, //$cert_date,
            'name_of_certificate' => 'Basundhara Allotment',
            'date_of_entry' => date('Y-m-d H:i:s'),
            //'file_name' => $escaped
        );

        $insDocACPP = $this->db->insert('allotment_doc_details', $allotment_doc_details);
        if($insDocACPP != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACPP004: Insertion failed in allotment_doc_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACPP004: Registration of Land Allotment failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d H:i:s'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
            );
        $insBasuACPP = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuACPP != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACPP005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACPP005: Registration of Land Allotment failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        
        if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
        }else{
            

            $pending_officer = $pending_officer->user_code;

            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'ACPP', $from_officer_co->user_code);
            //insert on escalation details tables=============
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $this->DashboardAllot($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
            echo json_encode($data);
            return;
        }

    }

    public function DashboardAllot($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.patta_no,pd.patta_type_code,
                pd.dag_no from allotment_cert_basic pb 
                    join allotment_pet_dag pd on pb.case_no=pd.case_no  where pb.settlement_typ is null and  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        $type='AC';
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['circle_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>'NA',
              'patta_no' =>'NA',
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
    }

    public function conversionRegistration($application_no,$service_code){


        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);

        $data['app']=$output->application;

        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $data['app']=$output->application;
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $this->db->trans_begin();
        
        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/CONV";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'01', /////mut type
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $pending_officer->user_code,
            'add_off_desig' =>'CO',
            'supported_doc' => 'Y',
            'operation' => 'E',
            'co_user_code' =>$pending_officer->user_code,
            'es_flag' => 1
            ///////// 
        );
        $insBasicCONV = $this->db->insert('petition_basic',$basic);
        if($insBasicCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV001: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return;
        }
        $fmd=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$pending_officer->user_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;
        $fmd['m_dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['m_dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['m_dag_area_lc']=$data['pattaNo']->dag_area_lc;
        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;
        $fmd['m_dag_area_g']='0.00';
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_g']='0';
        $fmd['dag_area_kr']='0';
        $fmd['revenue']=0;
        $insDagCONV = $this->db->insert('petition_dag_details',$fmd);
        if($insDagCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV002: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV002: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return;
        }
        $i=1;
        foreach($data['firstParty'] as $part){
            $file = null;
            if($part->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $part->auth_type;
                $id_ref_no = $part->id_ref_no;
                if($part->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $part->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->Escalationmodel->address($part->address);   
            $petitioner=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$data['app']->dag_no,
                'patta_no' =>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),

                'pdar_id' =>$part->chitha_pdar_id,
                'pdar_cron_no'=>$i++,
                'pdar_name' =>$part->name_ass,
                'pdar_guardian' =>$part->gurdian_name_ass,
                'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),/////////////
                'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gender),
                //'pdar_add1' => $part->address,
                'pdar_add1' => $faddress[0],
                'pdar_add2' => $faddress[1],
                'pdar_mobile' => $part->mobile,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo
            );
            $insPetCONV = $this->db->insert('petitioner_part',$petitioner);
            if($insPetCONV != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV003: Insertion failed in petitioner_part for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRCONV003: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return;
            }
        }


        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuCONV = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV004: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }


        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return;
        }
        else
        {
            

            $pending_officer = $pending_officer->user_code;

            $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

            
            //insert on escalation details tables=============
            // $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'CONV');


            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'CONVR',$from_officer_co->user_code);


            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            //////////////////
            $this->DashboardInheritance($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    }

    public  function DashboardInheritance($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
            where  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='03'){
            $type='OM';
        }elseif ($data['mut_type']=='01'){
             $type='CV';
        }
        elseif ($data['mut_type']=='04'){
             $type='OP';
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);
        
    }

    public function nameCorrectionRegistrationNewService($application_no,$service_code){
 

        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);

        $app=$output->application;
        $changeRequestApp=$output->applicants;
        $changeRequestData=$output->mutation;


        //mobile correction assigned to CO else assigned to LM===========****
        if($app->legacy == 'M'){
            $pending_officer = $this->Escalationmodel->getPendingOfficer($app->dist_code,$app->subdiv_code,$app->cir_code,'CO');
        }else{
            $pending_officer = $this->Escalationmodel->getPendingOfficerLM($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no);
        }
        //========END==========*********
        
        
        ///////////
        $case_name=$this->Escalationmodel->genearteCaseNameEs($app->dist_code,$app->subdiv_code,$app->cir_code);
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }

        $seq_pet=year_no.'00';
        $petition_no=$seq_pet.$this->rtpsmodel->genearteLegacyPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/".$app->legacy."LDU";

        $this->db->trans_begin();

        $file = null;
        if($changeRequestApp[0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $changeRequestApp[0]->auth_type;
            $id_ref_no = $changeRequestApp[0]->id_ref_no;
            if($changeRequestApp[0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $changeRequestApp[0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        //////////////
        $insert=[
            'dist_code'=>$app->dist_code,
            'subdiv_code'=>$app->subdiv_code,
            'cir_code'=>$app->cir_code,
            'mouza_pargona_code'=>$app->mouza_code,
            'lot_no'=>$app->lot_no,
            'vill_townprt_code'=>$app->village_code,
            'case_no'=>$case_no['case_no'],
            'user_code'=>$app->pending_with_officer,
            'date_of_reg'=>date('Y-m-d H:i:s'),
            'petition_no' =>$petition_no,
            'service_code' =>$app->service_code,
            'service_type' =>$app->legacy,
            'auth_type' => $auth_type,
            'auth_ref_no' => $id_ref_no,
            'photo' => $photo,
            'dag_no' => $app->legacy=='A' ? $app->dag_no : 'NA',
            'patta_no' => $app->legacy!='A' ? $app->patta_no : 'NA',
            'patta_type_code' => $app->legacy!='A' ? $app->patta_type : 'NA',
            'applied_pdar_id' =>$changeRequestApp[0]->chitha_pdar_id,
            'appl_name_eng' =>$changeRequestApp[0]->pat_name_eng,
            'appl_guard_eng' =>$changeRequestApp[0]->pat_gurdian_name_eng,
            'appl_name' =>$changeRequestApp[0]->name_ass,
            'appl_gurdian_name' =>$changeRequestApp[0]->gurdian_name_ass,
            'app_mobile_no' => $app->legacy != 'M' ? $changeRequestApp[0]->mobile : null,
            'self_declaration' => $dec,
            'status' => 'A',
            'es_flag' => 1,
        ];
        //AREA CORRECTION=================
        if($app->legacy=='A'){
            $type = "ACOR";
            // echo 'A';
            $insert['dag_area_b']=$changeRequestData[0]->new_area_b;
            $insert['dag_area_k']=$changeRequestData[0]->new_area_k;
            $insert['dag_area_lc']=$changeRequestData[0]->new_area_l;
            $insert['dag_ara_g']=$changeRequestData[0]->new_area_g;
        }
        //NAME CORRECTION=================
        if($app->legacy=='N'){
            $type = "NCOR";
            // echo 'N';
            $insert['chitha_pdar_id']=$changeRequestApp[0]->chitha_pdar_id;
            $insert['pdar_name']=$changeRequestData[0]->pat_name_ass;
            $insert['gurdian_name']=$changeRequestData[0]->pat_gurdian_name_ass;
            $insert['guard_eng_name']=$changeRequestData[0]->pat_gurdian_name_eng;
            $insert['eng_name']=$changeRequestData[0]->pat_name_eng;
            $insert['relation']=$changeRequestData[0]->gurdian_relation_id;
            $insert['mobile']=$changeRequestApp[0]->mobile;
            $insert['dob']=$changeRequestApp[0]->dob;
        }
        //MOBILE CORRECTION===============
        if($app->legacy=='M'){
            $type = "MCOR";
            $insert['new_mobile']=$changeRequestData[0]->new_mobile;
        }
        log_message("error","INSERTED ARRAY========".json_encode($insert));

       $status = $this->db->insert('legacy_correction',$insert);
       log_message('error',$this->db->last_query());
       if($status != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRLDU001: Insertion failed in legacy_correction for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRLDU001: Registration of Legacy Correction for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );

        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code);
        ///////////////////////
        $insBasuNSTR = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR004: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }

        if($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }else{
            


            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,$type);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);

    
    }

    public function nameCancellationRegistration($application_no,$service_code){


        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check",
                    'status' => false
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);


        $data['app']=$output->application;

        $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');



        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        $district['query']=$output->query;
        $district['query']=$output->query;

        
        $this->db->trans_begin();
        
        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteMiscPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/MiND";

        $userdata = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'year_no' => date('Y'),
            'misc_case_petition_no' => $case_no['petition_no'],
            'misc_case_no' => $case_no['case_no'],
            'misc_case_type' => '07',
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'supported_doc_yn' => 'Y',
            'supported_doc_code' => date('Y-m-d G:i:s'),
            'fresh_yn' => 'Y',
            'status' => '01',
            'operation' => 'E',
            'proceeding_yn' => 'Y',
            'user_code' => $pending_officer->user_code,
            'date_of_operation' => date('Y-m-d G:i:s'),
            'add_to_officer' => $pending_officer->user_code,
            'dag_no' => $data['app']->dag_no,
            'es_flag' => 1
        );
                //var_dump($userdata);
        //$this->session->set_userdata($userdata);
        $insBasicNSTR = $this->db->insert("misc_case_basic", $userdata);
        if($insBasicNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR001: Insertion failed in misc_case_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR001: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        
        if ( empty($data['firstParty'][0]))
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR005:  First Party Information missingfor RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR005: First Party Information missing for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        //adding aadhaar information---------
        $file = null;
        if($data['firstParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['firstParty'][0]->auth_type;
            $id_ref_no = $data['firstParty'][0]->id_ref_no;
            if($data['firstParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['firstParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'petition_pdar_id' =>  $data['firstParty'][0]->chitha_pdar_id,
            'misc_case_no' => $case_no['case_no'],
            'petition_pdar_name_old' => $data['firstParty'][0]->pat_name_ass,
            'submission_date' => date('Y-m-d G:i:s'),
            'user_code' => $pending_officer->user_code,
            'operation' => 'E',
            'misc_case_petition_no' => $case_no['petition_no'],
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo
        );
        $insFirstPartyNSTR = $this->db->insert("misc_case_first_party", $basic);
        if($insFirstPartyNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR002: Insertion failed in misc_case_first_party for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR002: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        if (empty($data['secParty']))
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR006:  Second Party Information missingfor RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR006: Second Party Information missing for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        foreach($data['secParty'] as $pet){
            $secondparty = array(
                'dist_code' => $data['app']->dist_code,
                'subdiv_code' =>$data['app']->subdiv_code,
                'cir_code' => $data['app']->cir_code,
                'opp_pdar_id' => $pet->chitha_pdar_id,
                'misc_case_no' => $case_no['case_no'],
                'opp_comment' => null,
                'submission_date' => date('Y-m-d G:i:s'),
                'user_code' => $pending_officer->user_code,
                'operation' => 'E'
            );
            $insSecondPartyNSTR = $this->db->insert("misc_case_scnd_party", $secondparty);
            if($insSecondPartyNSTR != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRNSTR003: Insertion failed in misc_case_scnd_party for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRNSTR003: Registration of Name Cancellation failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return false;
            }
        }

       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );

        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuNSTR = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRNSTR004: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }else
        {

            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'NCAN',$from_officer_co->user_code);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $this->DashboardNameCancel($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    }

    public function DashboardNameCancel($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
                as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no  where pb.misc_case_no='$case_no' ";
            $data=$this->db->query($sql)->row_array();
            $type='MC';
            $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'CO',
                  'case_type' =>$type,
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
             
            
        }

    function areaCorrectionRegistration($application_no,$service_code){
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check",
                'status' => false
            );
            echo json_encode($data);
            return;
            exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);

        $data['app']=$output->application;

        // $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');
        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);


        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;

        $data['secParty']=$output->applicants;
        //var_dump($data);
        //#START PLB--->
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['app']->area_g==null?"0":$data['app']->area_g;
            $dag_area_kr = $data['app']->area_kr==null?"0":$data['app']->area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('07');

        // $case_name=$this->rtpsmodel->genearteCaseName();
        //  if(empty($case_name)){
        //     $data=array(
        //         'error'=>"Network Issue or Session Out. Please try Again"
        //     );
        //     echo json_encode($data);
        //     exit;
        //     die();
        // }

        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteLegacyPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/LDU";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteLegacyPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/LDU";

        $file = null;
        if($data['firstParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['firstParty'][0]->auth_type;
            $id_ref_no = $data['firstParty'][0]->id_ref_no;
            if($data['firstParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['firstParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'proposal_no' => $case_no['petition_no'],
            'dag_no' => $data['app']->dag_no,
            'patta_no' => $data['pattaNo']->patta_no ,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'present_land_class' => $data['pattaNo']->land_class_code,
            'present_land_revenue' => $data['pattaNo']->dag_revenue,
            'present_land_localtax' => $data['pattaNo']->dag_local_tax,
            'dag_area_b' => $data['app']->area_b,
            'dag_area_k' => $data['app']->area_k,
            'dag_area_lc' => $data['app']->area_l,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' =>$dag_area_kr,
            'suggested_dag_no' => '',
            'suggested_patta_no' => '',
            'suggested_patta_type' => '',
            'suggested_land_class' =>'',
            'suggested_land_rev' => null,
            'suggested_loc_tax' => null,
            'suggested_dag_area_b' => $data['firstParty'][0]->new_area_b,
            'suggested_dag_area_k' => $data['firstParty'][0]->new_area_k,
            'suggested_dag_area_lc' => $data['firstParty'][0]->new_area_l,
            'suggested_dag_area_g' => $data['firstParty'][0]->new_area_g==null?"0":$data['firstParty'][0]->new_area_g,
            'suggested_dag_area_kr' => $data['firstParty'][0]->new_area_kr==null?"0":$data['firstParty'][0]->new_area_kr,
            'lm_note' => 'y',
            'lm_code' => $pending_officer->user_code,
            'lm_date' => date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],
            'year_no' => date('Y'),
            'file_upload' => '',
            'status' => 'P',
            'rmk_line_no' => 'N/A',
            'suggested_pattadarstrike' => null,
            'p_flag' => '',
            'pdar_id'=> $data['firstParty'][0]->chitha_pdar_id,
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo,
            'es_flag' => 1,

        );

        $insTlegACOR = $this->db->insert('t_legacyupdation',$basic);
        if($insTlegACOR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACOR001: Insertion failed in t_legacyupdation for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACOR001: Registration of Area Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$pending_officer->user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuACOR = $this->db->insert('basundhar_application', $basundhara);
        if($insBasuACOR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACOR002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACOR002: Registration of Area Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return;
        }else
        {
            
            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'ACOR',$from_officer_co->user_code);
            //end escalation==================================
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            } 
            $this->db->trans_commit();
            // $this->DashboardNameCancel($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    }

    public function getDetailsByCurlMultiGen($application_no){
        $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    function inheritancePostSingleGeneration($application_no,$service_code){
        // $allow_lm_part = true;
        // if($allow_lm_part){
        //     $data = array(
        //         'error' => "#ERRORMULTIGEN8580 : Not Allowed..."
        //     );
        //     echo json_encode($data);
        //     exit;
        // }


        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){

            //////////////////
            $recordExist = $this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data = array(
                        'error' => "Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            // echo "<pre>";
            // var_dump($output);
            // die;
            
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;
            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;
            $data['firstParty'] = $output->mutation;
            $data['secParty']   = $output->applicants;

            $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

            $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


            if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
            {
                $data=array(
                    'error'=>"Please reload the page. Session might be Destroyed."
                );
                echo json_encode($data);
                return false;
                exit;
            }

            $dist_code = $data['app']->dist_code;
            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteCaseNo('01');
            $case_name=$this->rtpsmodel->genearteCaseName();
             if(empty($case_name)){
                $data = array(
                    'error' => "Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

            // $case_no['case_no']=$case_name.$petition_no."/FMUT";

            $seq_pet = year_no.'00';
            $case_no['petition_no'] = $petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
            $case_no['case_no'] = $case_name.$petition_no."/FMUT";

            $basic = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>$data['secParty'][0]->trans_type,
                'dispute_yn'=>0,
                'possession_yn'=>null,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'report_date'=>date('Y-m-d'),
                'mut_type'=>'01',                    
                'operation'=>'E',
                'user_code'=>$pending_officer->user_code,
                'es_flag' => 1,
                'is_multigeneration' => $data['app']->is_multigeneration,
            );
            $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
            if($insFieldBasicFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMULMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMULMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            $file = null;
            $onlyForMultiGenPDarId = null;
            foreach($data['firstParty'] as $pet){
                if($data['app']->is_multigeneration == "M"){
                    $onlyForMultiGenPDarId = $pet->pdar_id;
                }else{
                    $onlyForMultiGenPDarId = null;
                }
                
                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $faddress=$this->Escalationmodel->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'guard_rel' =>$pet->pat_gurdian_rel_id <='-1' ? $this->utilityclass->relationRevertBasu($data['app']->dist_code,'7'):$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////

                    'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    'pet_id' => $i++,
                    'pdar_mobile'=>$pet->pat_mobile_no,
                    'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                    'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:$onlyForMultiGenPDarId,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'              => $photo,
                    'pdar_name_eng'=>$pet->pat_name_eng,
                    'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    'next_of_pdar_id' => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if($insFieldPetFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            ////////Seller Insert//////////
            foreach($data['secParty'] as $pet){
                //////////////////////////////////
                if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                    $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$pet->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                    if($pet_father_name->num_rows() <= 0){
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                        ); 
                        echo json_encode($data);
                        return;   
                    }else{
                        $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                    }

                }else{
                    $pet->gurdian_name_ass=$pet->gurdian_name_ass;
                }

                ///////////////////////////
                $sellerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$pet->dag_no,
                    'patta_no'=>$data['app']->patta_no,
                    'patta_type_code'  =>$data['app']->patta_type,
                    'pdar_id' => $pet->chitha_pdar_id,
                    'pdar_cron_no' => $pet->chitha_pdar_id,
                    'pdar_name' => $pet->name_ass,
                    'pdar_guardian'=>$pet->gurdian_name_ass,
                    'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'striked_out' =>1,/////for inheritance//////,
                    'generation_type'    => $pet->gen,
                );
                //var_dump($sellerInsert);
                $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
                if($insFieldPattaFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }


            }


            foreach ($dagArray as $key => $value) 
            {

                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value->dag_no); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                $dagDetails=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$value->dag_no,
                    'patta_no'=>$landArea->patta_no,
                    'patta_type_code'  => $landArea->patta_type_code,

                    'm_dag_area_b' => $value->dag_area_b,
                    'm_dag_area_k' => $value->dag_area_k,
                    'm_dag_area_lc'=> $value->dag_area_lc,
                    'm_dag_area_g' => $value->dag_area_g,
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $value->dag_area_b,
                    'dag_area_k'   => $value->dag_area_k,
                    'dag_area_lc'  => $value->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,
                    'remark' => null,
                );
                $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
                if($insFiledDagFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            $recordExistinFieldMutBasic=$this->rtpsmodel->checkExistCaseInFieldMutBasic($case_no['case_no']);
            if($recordExistinFieldMutBasic){
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'P',
                    'pending_with'=>'CO'
                );
                $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
                if($insBasuFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }  
            }
                
                
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }else{

                    $pending_officer = $pending_officer->user_code;

                    //insert on escalation details tables=============
                    $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'FMUT',$from_officer_co->user_code);
                    //end escalation==================================
                    if($escMatrixStatus['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>$escMatrixStatus['msg']
                        );
                    } 
                    $this->db->trans_commit();
                
                    $data=array(
                        'error_code' => null,
                        'msg'=>  "Application Registered FMUT",
                        'status' => true,
                        'case_no' => $case_no['case_no']
                    );
                       
                    // //////////////POST To rtps/////////////////////
                    // $url = RTPS_API_LINK."applicationStatusUpdate";
                    // $post_array = [
                    //     'application' => $application_no,
                    //     'dharitree' => $case_no['case_no'],
                    //     'rmk' => 'all ok',
                    //     'status' => 'M',
                    //     'task' => 'LM',
                    //     'pen'=>'CO'
                    // ];
                    // $result = sendCurlRequest($url, 'POST', $post_array);

                    // // $curl_handle = curl_init();
                    // // curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                    // // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    // // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    // // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    // // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    // // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    // //     'application' => $application_no,
                    // //     'dharitree' => $case_no['case_no'],
                    // //     'rmk' => 'all ok',
                    // //     'status' => 'M',
                    // //     'task' => 'LM',
                    // //     'pen'=>'CO'
                    // // )));
                    // // $result = curl_exec($curl_handle);
                    // ////////////////////////////////
                    //  if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                    //     $this->db->trans_commit();
                    // }else{
                    //     $this->db->trans_rollback();
                    //     $data=array(
                    //         'error'=>"Error in submitting. Please try Again"
                    //     );
                    //     echo json_encode($data);
                    //     return false;
                    // }            
                    // $this->DashboardPartitionField($case_no['case_no']);

                }
            echo json_encode($data);
        }
    }
    ///end------------

        /////////////////Office Inheritance Mutation/////////////////////////
    function inheritancePostOfficeSingleGeneration($application_no,$service_code){
        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){
            //////////////////
            // $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
            // if($recordExist){
            //         $data=array(
            //             'error'=>"Case have been Registered Already. Please Check"
            //         );
            //         echo json_encode($data);
            //         exit;
            // }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;


            $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


            $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');



            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;




            // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
            
            $data['firstParty']=$output->mutation;
            $data['secParty']=$output->applicants;
            //var_dump($data);
            $dist_code = $data['app']->dist_code;
            // if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            //     $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            //     $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
            // }
            // else{
            //     $dag_area_g = 0;
            //     $dag_area_kr = 0;
            // }

            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');
            $case_name=$this->rtpsmodel->genearteCaseName();        
             if(empty($case_name)){
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
            // $case_no['case_no']=$case_name.$petition_no."/OMUT";

            $seq_pet=year_no.'00';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/OMUT";


            $basic=array(
                'dist_code'         =>$data['app']->dist_code,
                'subdiv_code'       =>$data['app']->subdiv_code,
                'cir_code'          =>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'            =>$data['app']->lot_no,
                'vill_townprt_code' =>$data['app']->village_code,
                'user_code'         =>$pending_officer->user_code,
                'date_entry'        =>date('Y-m-d'),
                'case_no'           =>$case_no['case_no'],
                'mut_type'          =>'03', /////mut type
                'trans_code'        =>'01',/////////for inheritance
                'petition_no'       =>$case_no['petition_no'],
                'year_no'           =>date('Y'),
                'date_entry'        => date('Y-m-d G:i:s'),                 
                'operation'         =>'E',
                'user_code'         =>$pending_officer->user_code,
                'submission_date'   => date('Y-m-d G:i:s'),
                'add_off_name'      => $pending_officer->user_code,
                'is_multigeneration'=> $data['app']->is_multigeneration,
                'es_flag'           => 1, 
                ///////// 
            );
            $insPetBasic = $this->db->insert('petition_basic',$basic);
            if($insPetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIS001: Insertion failed in petition_basic RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $data = array(
                    'error'=>"#ERROMUTIS001: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            foreach($data['firstParty'] as $pet){

                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }


                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'pet_name'          => $pet->pat_name_ass,
                    'guard_name'        => $pet->pat_gurdian_name_ass,
                    'pdar_name_eng'     => $pet->pat_name_eng,
                    'pdar_guard_eng'    => $pet->pat_gurdian_name_eng,
                    // 'guard_rel' => 'f', //////////////////////to be update
                    // 'pet_gender'=>$pet->pat_gender,
                    'guard_rel'         =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'        =>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    'pet_id'            => $i++,
                    //'add1' => $pet->address,
                    'add1'              => $faddress[0],
                    'add2'              => $faddress[1],
                    'user_code'         => $pending_officer->user_code,
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'new_pattadar'      => 'N',
                    'pet_minor_dob'     => date('Y-m-d G:i:s',strtotime($pet->dob)),
                    'pdar_mobile'       => $pet->pat_mobile_no,
                    'applied_b'         =>0,
                    'applied_k'         => 0,
                    'applied_lc'        => 0,
                    'applied_g'         => 0,
                    'applied_kr'        => 0,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    // Added by Abhijit -- 2024-02-29
                    'pdar_id'          => $pet->pdar_id,
                    'next_of_pdar_id'  => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
                if($insPetitioner != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS002: Insertion failed in petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS002: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            $cron_no=1;
            foreach($data['secParty'] as $pet){
                $sellerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'user_code'         =>$pending_officer->user_code,
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'dag_no'            =>$pet->dag_no,
                    'patta_no'          =>$data['app']->patta_no,
                    'patta_type_code'   => $data['app']->patta_type,
                    'pdar_id'           => $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $pet->chitha_pdar_id,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     =>$pet->gurdian_name_ass,
                    'pdar_rel_guar'     => 'f',
                    'striked_out'       =>1,/////for inheritance//////
                    'patta_no'          => $data['app']->patta_no,
                    'patta_type_code'   => $data['app']->patta_type,
                    'pdar_id'           =>  $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $cron_no++,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     => $pet->gurdian_name_ass,
                    //'pdar_gender' => 'm',
                    //'pdar_rel_guar' => 'f',
                    'pdar_rel_guar'     =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'generation_type'   => $pet->gen
                );
                $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
                if($insPetPattadar != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no  . ' Last Query => ' . $this->db->last_query());
                    $data = array(
                        'error'=>"#ERROMUTIS003: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0003: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

            }


            foreach ($dagArray as $key => $value) {


                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value->dag_no); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }


                $dagDetails=array(
                    'dist_code'     =>$data['app']->dist_code,
                    'subdiv_code'   =>$data['app']->subdiv_code,
                    'cir_code'      =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'        =>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'     =>$pending_officer->user_code,
                    'date_entry'    =>date('Y-m-d'),
                    'petition_no'   =>$case_no['petition_no'],
                    'year_no'       =>date('Y'),
                    'operation'     =>'E',
                    'dag_no'        =>$value->dag_no,
                    'patta_no'      =>$landArea->patta_no ,
                    'patta_type_code'  => $landArea->patta_type_code,
                    'm_dag_area_b' => $value->dag_area_b,
                    'm_dag_area_k' => $value->dag_area_k,
                    'm_dag_area_lc'=> $value->dag_area_lc,
                    'm_dag_area_g' => $value->dag_area_g,
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $value->dag_area_b,
                    'dag_area_k'   => $value->dag_area_k,
                    'dag_area_lc'  => $value->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,


                    );
                    $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
                    if($insPetDag != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROMUTIS004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROMUTIS004: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
                $basundhara=array(
                    'dharitree'     =>$case_no['case_no'],
                    'basundhara'    =>$application_no,
                    'date_reg'      =>date('Y-m-d'),
                    'reg_by'        =>$pending_officer->user_code,
                    'app_status'    =>'P',
                    'pending_with'  =>'CO'
                );
                $insBasu = $this->db->insert('basundhar_application',$basundhara);
                if($insBasu != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS005: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                }
                else
                {

                    $pending_officer = $pending_officer->user_code;

                    //insert on escalation details tables=============
                    $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'OMUT',$from_officer_co->user_code);
                    log_message('error','ESCALATION-MATRIX-INSERT---'.json_encode($escMatrixStatus));
                    if($escMatrixStatus['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>$escMatrixStatus['msg']
                        );
                    }
                    //end escalation==================================  

                    $this->db->trans_commit();
                    $this->DashboardInheritance($case_no['case_no']);

                    $data=array(
                        'error_code' => null,
                        'msg'=>  "Application Registered",
                        'status' => true,
                        'case_no' => $case_no['case_no']
                    );
                    // $this->db->trans_commit();
                    // //////////////POST To rtps/////////////////////
                    // $rmk   ='Forwarded to CO';
                    // $status='M';
                    // $task='AST';
                    // $pen='CO';
                    // $case=$case_no['case_no'];
                    // $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    // //////////////////
                    
                    // $this->DashboardInheritance($case_no['case_no']);

                    // $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no ".$case_no['case_no']);
                    // //////////////////////////////////
                    // $data=array(
                    //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    //     'redirect_url'=>base_url().'index.php/home'
                    // );
                }
            echo json_encode($data);
        }
    }

    function inheritancePostMultiGeneration($application_no,$service_code){
        // $allow_lm_part = true;
        // if($allow_lm_part){
        //     $data = array(
        //         'error' => "#ERRORMULTIGEN8580 : Not Allowed..."
        //     );
        //     echo json_encode($data);
        //     exit;
        // }


        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){
            //////////////////
            $recordExist = $this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data = array(
                        'error' => "Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;
            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;
            $data['firstParty'] = $output->mutation;
            $data['secParty']   = $output->applicants;

            $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

            $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


            if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
            {
                $data=array(
                    'error'=>"Please reload the page. Session might be Destroyed."
                );
                echo json_encode($data);
                return false;
                exit;
            }

            $dist_code = $data['app']->dist_code;
            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteCaseNo('01');
            $case_name=$this->rtpsmodel->genearteCaseName();
             if(empty($case_name)){
                $data = array(
                    'error' => "Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

            // $case_no['case_no']=$case_name.$petition_no."/FMUT";

            $seq_pet = year_no.'00';
            $case_no['petition_no'] = $petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
            $case_no['case_no'] = $case_name.$petition_no."/FMUT";

            $basic = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$pending_officer->user_code,
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>$data['secParty'][0]->trans_type,
                'dispute_yn'=>0,
                'possession_yn'=>null,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'report_date'=>date('Y-m-d'),
                'mut_type'=>'01',                    
                'operation'=>'E',
                'user_code'=>$pending_officer->user_code,
                'es_flag' => 1,
                'is_multigeneration' => $data['app']->is_multigeneration,
            );
            $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
            if($insFieldBasicFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMULMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMULMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            $file = null;
            $onlyForMultiGenPDarId = null;
            foreach($data['firstParty'] as $pet){
                if($data['app']->is_multigeneration == "M"){
                    $onlyForMultiGenPDarId = $pet->pdar_id;
                }else{
                    $onlyForMultiGenPDarId = null;
                }
                
                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $faddress=$this->Escalationmodel->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'guard_rel' =>$pet->pat_gurdian_rel_id <='-1' ? $this->utilityclass->relationRevertBasu($data['app']->dist_code,'7'):$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////

                    'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    'pet_id' => $i++,
                    'pdar_mobile'=>$pet->pat_mobile_no,
                    'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                    'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:$onlyForMultiGenPDarId,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'              => $photo,
                    'pdar_name_eng'=>$pet->pat_name_eng,
                    'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    'next_of_pdar_id' => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if($insFieldPetFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            ////////Seller Insert//////////
            foreach($data['secParty'] as $pet){
                //////////////////////////////////
                if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                    $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$pet->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                    if($pet_father_name->num_rows() <= 0){
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                        ); 
                        echo json_encode($data);
                        return;   
                    }else{
                        $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                    }

                }else{
                    $pet->gurdian_name_ass=$pet->gurdian_name_ass;
                }

                ///////////////////////////
                $sellerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$pet->dag_no,
                    'patta_no'=>$data['app']->patta_no,
                    'patta_type_code'  =>$data['app']->patta_type,
                    'pdar_id' => $pet->chitha_pdar_id,
                    'pdar_cron_no' => $pet->chitha_pdar_id,
                    'pdar_name' => $pet->name_ass,
                    'pdar_guardian'=>$pet->gurdian_name_ass,
                    'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'striked_out' =>1,/////for inheritance//////,
                    'generation_type'    => $pet->gen,
                );
                //var_dump($sellerInsert);
                $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
                if($insFieldPattaFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }


            }


            foreach ($dagArray as $key => $value) 
            {

                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value->dag_no); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                $dagDetails=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$pending_officer->user_code,
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$value->dag_no,
                    'patta_no'=>$landArea->patta_no,
                    'patta_type_code'  => $landArea->patta_type,

                    'm_dag_area_b' => $value->dag_area_b,
                    'm_dag_area_k' => $value->dag_area_k,
                    'm_dag_area_lc'=> $value->dag_area_lc,
                    'm_dag_area_g' => $value->dag_area_g,
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $value->dag_area_b,
                    'dag_area_k'   => $value->dag_area_k,
                    'dag_area_lc'  => $value->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,
                    'remark' =>addslashes(trim($_POST['remark']))
                );
                $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
                if($insFiledDagFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            $recordExistinFieldMutBasic=$this->rtpsmodel->checkExistCaseInFieldMutBasic($case_no['case_no']);
            if($recordExistinFieldMutBasic){
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'P',
                    'pending_with'=>'CO'
                );
                $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
                if($insBasuFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }  
            }
                
                
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }else{

                    $pending_officer = $pending_officer->user_code;

                    //insert on escalation details tables=============
                    $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'FMUT',$from_officer_co->user_code);
                    //end escalation================================== 
                    if($escMatrixStatus['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>$escMatrixStatus['msg']
                        );
                    }
                    $this->db->trans_commit();
                
                    $data=array(
                        'error_code' => null,
                        'msg'=>  "Application Registered FMUT",
                        'status' => true,
                        'case_no' => $case_no['case_no']
                    );
                       
                    // //////////////POST To rtps/////////////////////
                    // $url = RTPS_API_LINK."applicationStatusUpdate";
                    // $post_array = [
                    //     'application' => $application_no,
                    //     'dharitree' => $case_no['case_no'],
                    //     'rmk' => 'all ok',
                    //     'status' => 'M',
                    //     'task' => 'LM',
                    //     'pen'=>'CO'
                    // ];
                    // $result = sendCurlRequest($url, 'POST', $post_array);

                    // // $curl_handle = curl_init();
                    // // curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                    // // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    // // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    // // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    // // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    // // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    // //     'application' => $application_no,
                    // //     'dharitree' => $case_no['case_no'],
                    // //     'rmk' => 'all ok',
                    // //     'status' => 'M',
                    // //     'task' => 'LM',
                    // //     'pen'=>'CO'
                    // // )));
                    // // $result = curl_exec($curl_handle);
                    // ////////////////////////////////
                    //  if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                    //     $this->db->trans_commit();
                    // }else{
                    //     $this->db->trans_rollback();
                    //     $data=array(
                    //         'error'=>"Error in submitting. Please try Again"
                    //     );
                    //     echo json_encode($data);
                    //     return false;
                    // }            
                    // $this->DashboardPartitionField($case_no['case_no']);

                }
            echo json_encode($data);
        }
    }
    ///end------------
    function inheritancePostOfficeMultiGeneration($application_no,$service_code){
        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){
            //////////////////
            $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data=array(
                        'error'=>"Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;


            $pending_officer = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');


            $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');



            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;




            // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
            
            $data['firstParty']=$output->mutation;
            $data['secParty']=$output->applicants;
            //var_dump($data);
            $dist_code = $data['app']->dist_code;
            // if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            //     $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            //     $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
            // }
            // else{
            //     $dag_area_g = 0;
            //     $dag_area_kr = 0;
            // }

            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');
            $case_name=$this->rtpsmodel->genearteCaseName();        
             if(empty($case_name)){
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
            // $case_no['case_no']=$case_name.$petition_no."/OMUT";

            $seq_pet=year_no.'00';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/OMUT";


            $basic=array(
                'dist_code'         =>$data['app']->dist_code,
                'subdiv_code'       =>$data['app']->subdiv_code,
                'cir_code'          =>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'            =>$data['app']->lot_no,
                'vill_townprt_code' =>$data['app']->village_code,
                'user_code'         =>$pending_officer->user_code,
                'date_entry'        =>date('Y-m-d'),
                'case_no'           =>$case_no['case_no'],
                'mut_type'          =>'03', /////mut type
                'trans_code'        =>'01',/////////for inheritance
                'petition_no'       =>$case_no['petition_no'],
                'year_no'           =>date('Y'),
                'date_entry'        => date('Y-m-d G:i:s'),                 
                'operation'         =>'E',
                'user_code'         =>$pending_officer->user_code,
                'submission_date'   => date('Y-m-d G:i:s'),
                'add_off_name'      => $pending_officer->user_code,
                'is_multigeneration'=> $data['app']->is_multigeneration,
                'es_flag'           => 1,
                ///////// 
            );
            $insPetBasic = $this->db->insert('petition_basic',$basic);
            if($insPetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIS001: Insertion failed in petition_basic RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $data = array(
                    'error'=>"#ERROMUTIS001: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            foreach($data['firstParty'] as $pet){

                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }


                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'pet_name'          => $pet->pat_name_ass,
                    'guard_name'        => $pet->pat_gurdian_name_ass,
                    'pdar_name_eng'     => $pet->pat_name_eng,
                    'pdar_guard_eng'    => $pet->pat_gurdian_name_eng,
                    // 'guard_rel' => 'f', //////////////////////to be update
                    // 'pet_gender'=>$pet->pat_gender,
                    'guard_rel'         =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'        =>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    'pet_id'            => $i++,
                    //'add1' => $pet->address,
                    'add1'              => $faddress[0],
                    'add2'              => $faddress[1],
                    'user_code'         => $pending_officer->user_code,
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'new_pattadar'      => 'N',
                    'pet_minor_dob'     => date('Y-m-d G:i:s',strtotime($pet->dob)),
                    'pdar_mobile'       => $pet->pat_mobile_no,
                    'applied_b'         =>0,
                    'applied_k'         => 0,
                    'applied_lc'        => 0,
                    'applied_g'         => 0,
                    'applied_kr'        => 0,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    // Added by Abhijit -- 2024-02-29
                    'pdar_id'          => $pet->pdar_id,
                    'next_of_pdar_id'  => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
                if($insPetitioner != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS002: Insertion failed in petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS002: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            $cron_no=1;
            foreach($data['secParty'] as $pet){
                $sellerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'user_code'         =>$pending_officer->user_code,
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'dag_no'            =>$pet->dag_no,
                    'patta_no'          =>$data['app']->patta_no,
                    'patta_type_code'   => $data['app']->patta_type,
                    'pdar_id'           => $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $pet->chitha_pdar_id,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     =>$pet->gurdian_name_ass,
                    'pdar_rel_guar'     => 'f',
                    'striked_out'       =>1,/////for inheritance//////
                    'pdar_id'           =>  $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $cron_no++,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     => $pet->gurdian_name_ass,
                    //'pdar_gender' => 'm',
                    //'pdar_rel_guar' => 'f',
                    'pdar_rel_guar'     =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'generation_type'   => $pet->gen
                );
                $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
                if($insPetPattadar != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no  . ' Last Query => ' . $this->db->last_query());
                    $data = array(
                        'error'=>"#ERROMUTIS003: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0003: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // $this->db->insert_batch('mut_additional_properties', $other_properties); 

                // if ($this->db->affected_rows() <= 0)
                // {
                //     $this->db->trans_rollback();
                //     log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                //     $data = array(
                //         'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
            }

            foreach ($dagArray as $key => $value) {


                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value->dag_no); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }


                $dagDetails=array(
                    'dist_code'     =>$data['app']->dist_code,
                    'subdiv_code'   =>$data['app']->subdiv_code,
                    'cir_code'      =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'        =>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'     =>$pending_officer->user_code,
                    'date_entry'    =>date('Y-m-d'),
                    'petition_no'   =>$case_no['petition_no'],
                    'year_no'       =>date('Y'),
                    'operation'     =>'E',
                    'dag_no'        =>$value->dag_no,
                    'patta_no'      =>$landArea->patta_no ,
                    'patta_type_code'  => $landArea->patta_type_code,
                    'm_dag_area_b' => $value->dag_area_b,
                    'm_dag_area_k' => $value->dag_area_k,
                    'm_dag_area_lc'=> $value->dag_area_lc,
                    'm_dag_area_g' => $value->dag_area_g,
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $value->dag_area_b,
                    'dag_area_k'   => $value->dag_area_k,
                    'dag_area_lc'  => $value->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,


                    );
                    $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
                    if($insPetDag != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROMUTIS004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROMUTIS004: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                $basundhara=array(
                    'dharitree'     =>$case_no['case_no'],
                    'basundhara'    =>$application_no,
                    'date_reg'      =>date('Y-m-d'),
                    'reg_by'        =>$pending_officer->user_code,
                    'app_status'    =>'P',
                    'pending_with'  =>'CO'
                );
                $insBasu = $this->db->insert('basundhar_application',$basundhara);
                if($insBasu != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS005: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                }
                else
                {

                    $pending_officer = $pending_officer->user_code;

                    //insert on escalation details tables=============
                    $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'OMUT',$from_officer_co->user_code);

                    if($escMatrixStatus['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>$escMatrixStatus['msg']
                        );
                    }
                    //end escalation==================================  

                    $this->db->trans_commit();
                    $this->DashboardInheritance($case_no['case_no']);

                    $data=array(
                        'error_code' => null,
                        'msg'=>  "Application Registered",
                        'status' => true,
                        'case_no' => $case_no['case_no']
                    );
                    // $this->db->trans_commit();
                    // //////////////POST To rtps/////////////////////
                    // $rmk   ='Forwarded to CO';
                    // $status='M';
                    // $task='AST';
                    // $pen='CO';
                    // $case=$case_no['case_no'];
                    // $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    // //////////////////
                    
                    // $this->DashboardInheritance($case_no['case_no']);

                    // $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no ".$case_no['case_no']);
                    // //////////////////////////////////
                    // $data=array(
                    //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    //     'redirect_url'=>base_url().'index.php/home'
                    // );
                }
            echo json_encode($data);
        }
    }


    // new name correction process added on 05/04/2024

    public function nameCorrectionRegistration($application_no,$service_code){

        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check",
                    'status' => false
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);

        $data['app']=$output->application;
        

        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

        $from_officer_co = $this->Escalationmodel->getPendingOfficer($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,'CO');

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        $district['query']=$output->query;

        //var_dump($data['secParty']);
        //var_dump($data);
        $this->db->trans_begin();


        $case_name=$this->Escalationmodel->genearteCaseNameEs($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code);
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again",
                'status' => false
            );
            echo json_encode($data);
            return;
        }


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteMiscPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/MiNC";

        // echo "<pre>"; var_dump($data); die;

        $userdata = array(
            'dist_code'             => $data['app']->dist_code,
            'subdiv_code'           => $data['app']->subdiv_code,
            'cir_code'              => $data['app']->cir_code,
            'mouza_pargona_code'    => $data['app']->mouza_code,
            'lot_no'                => $data['app']->lot_no,
            'vill_townprt_code'     => $data['app']->village_code,
            'year_no'               => date('Y'),
            'misc_case_petition_no' => $case_no['petition_no'],
            'misc_case_no'          => $case_no['case_no'],
            'misc_case_type'        => '06',
            'patta_no'              => $data['pattaNo']->patta_no,
            'patta_type_code'       => $data['pattaNo']->patta_type_code,
            'submission_date'       => date('Y-m-d G:i:s'),
            'supported_doc_yn'      => 'Y',
            'supported_doc_code'    => date('Y-m-d G:i:s'),
            'fresh_yn'              => 'Y',
            'status'                => 1,
            'operation'             => 's',
            'proceeding_yn'         => 'Y',
            'user_code'             => $pending_officer->user_code,
            'date_of_operation'     => date('Y-m-d G:i:s'),
            'dag_no'                => $data['app']->dag_no,
            'es_flag'               => 1
        );
                //var_dump($userdata);
        //$this->session->set_userdata($userdata);
        $insBasicMINC = $this->db->insert("misc_case_basic", $userdata);
        if($insBasicMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#NAMECOR6336: Insertion failed in misc_case_basic for RTPS Case No '.$application_no);

            log_message('error', '#NAMECOR6336: '. $this->db->last_query());
            $data = array(
                'error'=>"#NAMECOR6336: Registration of Name Cancellation failed for case no : ".$application_no,
                'status' => false
            );
            echo json_encode($data);
            return false;
        }
        //adding aadhaar information---------
        $file = null;
        if($data['secParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['secParty'][0]->auth_type;
            $id_ref_no = $data['secParty'][0]->id_ref_no;
            if($data['secParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['secParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code'              => $data['app']->dist_code,
            'subdiv_code'            => $data['app']->subdiv_code,
            'cir_code'               => $data['app']->cir_code,
            'petition_pdar_id'       =>  $data['secParty'][0]->chitha_pdar_id,
            'misc_case_no'           => $case_no['case_no'],
            'petition_pdar_name_old' => $data['secParty'][0]->name_ass,
            'petition_pdar_name_new' => $data['firstParty'][0]->pat_name_ass,
            'submission_date'        => date('Y-m-d G:i:s'),
            'user_code'              => $pending_officer->user_code,
            'operation'              => 'E',
            'misc_case_petition_no'  => $case_no['petition_no'],
            'self_declaration'       => $dec,
            'auth_type'              => $auth_type,
            'id_ref_no'              => $id_ref_no,
            'photo'                  => $photo,
            'applicant_info'         => json_encode($data['secParty'])
        );
        $insFirstPartyMINC = $this->db->insert("misc_case_first_party", $basic);
        if($insFirstPartyMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#NAMECOR6391: Insertion failed in misc_case_first_party for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#NAMECOR6391: Registration of Name Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
       
        $basundhara=array(
            'dharitree'    => $case_no['case_no'],
            'basundhara'   => $application_no,
            'date_reg'     => date('Y-m-d'),
            'reg_by'       => $this->session->userdata('user_code'),
            'app_status'   => 'P',
            'pending_with' => 'LM',
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuMINC = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuMINC != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#NAMECOR6414: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#NAMECOR6414: Registration of Name Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return;
        }
        else
        {
            $pending_officer = $pending_officer->user_code;
            //insert on escalation details tables=============
            $escMatrixStatus = $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,'NCOR',$from_officer_co->user_code);
            //end escalation================================== 
            if($escMatrixStatus['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>$escMatrixStatus['msg']
                );
            }
            $this->db->trans_commit();
            $this->DashboardNameCorrect($case_no['case_no']);
            $data=array(
                'error_code' => null,
                'msg'=>  "Application Registered",
                'status' => true,
                'case_no' => $case_no['case_no']
            );
        }
        echo json_encode($data);
    }


    protected function insertEscalationLocation($case_no)
    {
      // check if data already exist in escalation_location table
      $dataExist = $this->db->query("SELECT * FROM escalation_location WHERE case_no=?", array($case_no));

      if($dataExist->num_rows() == 0)
      {
        $service_type = $this->getServiceType($case_no);
        $case_name = ($service_type == 'MiNC' || $service_type == 'MiND') ? 'misc_case_no' : 'case_no';

        $serviceTable = $this->serviceTableName($case_no);
        $r = $this->db->query("SELECT * FROM $serviceTable WHERE $case_name=?", array($case_no))->row();

        $cir_code = ($serviceTable == 'allotment_cert_basic') ? $r->circle_code : $r->cir_code;

        // get rtps application no
        $rtps_no = $this->getBasundharaApplNo($case_no);

        $dist_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                      cir_code=? AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=?", 
                        array($r->dist_code, '00', '00', '00', '00000', '00'))->row();

        $cir_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                      cir_code=? AND mouza_pargona_code=? AND  vill_townprt_code=? AND lot_no=?", 
                        array($r->dist_code, $r->subdiv_code, $cir_code, '00', '00000', '00'))->row();

        $vill_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                      cir_code=? AND mouza_pargona_code=? AND  vill_townprt_code=? AND lot_no=?", 
                        array($r->dist_code, $r->subdiv_code, $cir_code, $r->mouza_pargona_code, $r->vill_townprt_code, 
                          $r->lot_no))->row();

        $ins = [
          'case_no'        => $case_no,
          'application_no' => $rtps_no,
          'service_code'   => $r->service_code,
          'dist_code'      => $r->dist_code,
          'subdiv_code'    => $r->subdiv_code,
          'cir_code'       => $cir_code,
          'mouza_code'     => $r->mouza_pargona_code,
          'lot_no'         => $r->lot_no,
          'vill_code'      => $r->vill_townprt_code,
          'dist_name_asm'  => $dist_name->loc_name,
          'cir_name_asm'   => $cir_name->loc_name,
          'vill_name_asm'  => $vill_name->loc_name,
          'dist_name_eng'  => $dist_name->locname_eng,
          'cir_name_eng'   => $cir_name->locname_eng,
          'vill_name_eng'  => $vill_name->locname_eng,
          'created_date'   => date('Y-m-d H:i:s'),
        ];
        $insert = $this->db->insert('escalation_location', $ins);
        if($insert != 1)
        {
          return 0;
        }
        return 1;
      }        
    }

    // get application no from basundhar_application
    protected function getBasundharaApplNo($case_no)
    {
      return $basundhara = $this->db->query("SELECT basundhara FROM basundhar_application WHERE dharitree=?", 
                              array($case_no))->row()->basundhara;
    }

    protected function getServiceType($case_no)
    {
      $get_case_no = explode('/', $case_no);
      return $get_type = $get_case_no[4];
    }

    // table service wise table
    protected function serviceTableName($case_no)
    {
      $service_type = $this->getServiceType($case_no);

      if($service_type == 'FMUT' || $service_type == 'FPART')
      {
        $table = 'field_mut_basic';
      }
      else if($service_type == 'OMUT' || $service_type == 'OPART' || $service_type == 'CONV')
      {
        $table = 'petition_basic';
      }
      else if($service_type == 'RECLASS')
      {
        $table = 't_reclassification';
      }
      else if($service_type == 'ACPP')
      {
        $table = 'allotment_cert_basic';
      }
      else if($service_type == 'MiNC' || $service_type == 'MiND' || )
      {
        $table = 'misc_case_basic';
      }
      return $table;
    }
  
}