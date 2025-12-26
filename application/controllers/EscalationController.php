<?php
class EscalationController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('Escalationmodel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('AutoRegistrationmodel');
        $this->load->model('AutoEscalationmodel');        
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

    public function testAES(){
      $aes_flag = $this->AutoEscalationmodel->autoEscalatePendingCases();
      echo "<pre>";
      var_dump($aes_flag);
      echo "</pre>";
    }
    public function getEscalatedDateNew1()
    {
        $target_days = 7;
        $executionDate = '2024-09-18 10:24:50';

            $Interval = '+' . $target_days . ' days';
            // $escalatedDate =Date('Y-m-d', strtotime($Interval));
            $escalatedDate = date('Y-m-d H:i:s', strtotime($executionDate . $Interval));
            echo  $escalatedDate;
        
    }
    public function dateDiff1()
    {
        $date1 = '2024-09-20 14:28:44';
        $date2 = '2024-09-17 14:28:44';

            $date1_ts = strtotime($date1);
            $date2_ts = strtotime($date2);
            $diff = $date1_ts - $date2_ts;
            echo  round($diff / 86400);
    }

    public function apiForRegistrationInDharitree(){


        // echo "sdfghjkl"; die;

        $application_no = 'RTPS/MUTI/2024/3668';
        $service_code = '1';
        $service_name = 'FMUT';

        switch($service_code){
        case 1: 
            $this->mutationInheritanceRegistration($application_no,$service_code,$service_name);
            break;
        case 2: 
            $this->mutationDeedRegistration($application_no,$service_code,$service_name);
            break;
        case 3: 
            $this->partitionRegistration($application_no,$service_code,$service_name);
            break;
        case 4: 
            $this->reclassRegistration($application_no,$service_code,$service_name);
            break;
        case 5: 
            $this->allotmentRegistration($application_no,$service_code,$service_name);
            break;
        case 6:
            $this->nameCorrectionRegistration($application_no,$service_code,$service_name);
            break;
        case 7: 
            $this->areaCorrectionRegistration($application_no,$service_code,$service_name);
            break;
        case 8: 
            $this->nameDeletionRegistration($application_no,$service_code,$service_name);
            break;
        case 9: 
            $this->conversionRegistration($application_no,$service_code,$service_name);
            break;
        case 10: 
            $this->mobileUpdateRegistration($application_no,$service_code,$service_name);
            break;
        case 11: 
            $this->jamabandiRegistration($application_no,$service_code,$service_name);
            break;
        case 12: 
            $this->tracemapRegistration($application_no,$service_code,$service_name);
            break;
      }

    }

    /////////////////Office Inheritance Mutation/////////////////////////
    public function mutationInheritanceRegistration($application_no,$service_code,$service_name){
      if($service_name == 'OMUT'){
        $this->registrationOMUT($application_no,$service_code,$service_name);
      }else{
        $this->registrationFMUT($application_no,$service_code,$service_name);
      }
    }

    public function registrationOMUT($application_no,$service_code,$service_name){
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error_code' => '#ERROR001',
                'msg'=>"Case have been Registered Already. Please Check",
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
            'trans_code'=>null,/////////for inheritance
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
               $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,$service_name);
              //end escalation==================================  



                $this->db->trans_commit();
                //////////////POST To rtps/////////////////////
                // $rmk='Forwarded to CO';
                // $status='M';
                // $task='AST';
                // $pen='CO';
                // $case=$case_no['case_no'];
                // $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////
                
                // $this->DashboardInheritanceDetails($case_no['case_no'],$pending_officer);
                //////////////////////////////////
                $data=array(
                    'error_code' => null,
                    'msg'=>  "Application Registered",
                    'status' => true,
                    'case_no' => $case_no['case_no']
                );
            }
            echo json_encode($data);
    }


    public function registrationFMUT($application_no,$service_code,$service_name){

        // $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error_code' =>  '#ERROR001',
                'msg'        =>  "Case have been Registered Already. Please Check",
                'status'     =>  false
            );
            echo json_encode($data);
            exit;
        }
        /////////////////////


        $fetchData = $this->getDetailsByCurl($application_no);
        $output = json_decode($fetchData);
        var_dump($output);
        die;

        $data['app']    =$output->application;
        $pending_officer = $this->Escalationmodel->getPendingOfficerLM($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no);

        
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
            'trans_code'=>'01',
            'dispute_yn'=> 0,
            'possession_yn'=>'y',
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
                'error'=>"#ERRFMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
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
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$data['app']->dag_no,$data['pattaNo']->patta_no,$data['pattaNo']->patta_type_code,$pet->chitha_pdar_id);
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
                    'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
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
                    'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
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
              $this->insertIntoEscalationMatrix($petition_no,$case_no['case_no'],$service_code,$pending_officer,$service_name);


              //end escalation================================== 
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

    function DashboardInheritanceDetails($case_no,$pending_officer){
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
              'pending_with_user' =>$pending_officer,
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);  
    }


    public function insertIntoEscalationMatrix($petition_no,$case_no,$service_code,$pending_officer,$service_name){
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
      $timeLineRow = $this->Escalationmodel->getTimeLine($service_code,'FMUT');
      
      $dateCode    = $this->Escalationmodel->generateDateCode();
      $case_type   = 0;
      if($service_code == 1){
        $da_target_days = $timeLineRow->da_allocated_days;
        $lm_target_days = $timeLineRow->lm_allocated_days;
        $co_target_days = $timeLineRow->co_allocated_days;
        $sk_target_days = $timeLineRow->sk_allocated_days;
        $co_date_code_list = $dateCode;
        if($service_name == 'OMUT'){
          $task = json_decode(OMUT_TASK);
          $escalatedDate = $this->Escalationmodel->getEscalatedDate($co_target_days);
        }else{
          $task = json_decode(FMUT_TASK);
          $escalatedDate = $this->Escalationmodel->getEscalatedDate($lm_target_days);
        }
        
      }
      $assignment_type = json_decode(ASSIGNMENT_TYPE);
      $user_allot_code = json_decode(USER_ALLOT_CODE);

      $date = date('Y-m-d H:i:s');
      if($service_code == 1){
        $assigned_to_code = $user_allot_code[5]->CODE;
        $assigned_from_code = $user_allot_code[1]->CODE;
        $assignment_type_other = null;
        $assigned_other = null;
        $assigned_other_date = null;
        $assigned_other_es_date = null;
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
        'assigned_from'   => 'DC',
        'assigned_from_code' => $assigned_from_code,
        'assigned_to'     => $pending_officer,
        'assigned_to_code'=> $assigned_to_code,
        'assigned_date'   => $date,
        'escalated_date'  => $escalatedDate,
        'history_id'      => $dateCode,
        'to_be_completed_within_days' => $this->Escalationmodel->dateDiff($escalatedDate,date('Y-m-d')),
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
      log_message('error',"ESCALATION ==========".$this->db->last_query());



      $insertDateArray = array(
        'petition_no'    => $petition_no,
        'date_code'      => $dateCode,
        'service_code'   =>$service_code,
        'taskid'         =>$task[0]->CODE,
        'action_type'    => $assignment_type[0]->CODE,  
        'pending_officer' => $pending_officer,
        'assigned_user'  => 'DC',
        'assigned_user_code' => $assigned_from_code,
        'assigned_to'    => $pending_officer,
        'assigned_to_code' => $assigned_to_code,
        'registerd_on'   => $date,
        'allocation_date' => $date,
        'target_completion_date' => $escalatedDate,
        'completion_date' => null,
        'date_diff'      => $this->Escalationmodel->dateDiff($escalatedDate,date('Y-m-d')),
        'escalated_status' => null,
        'completion_days' => null,
        'created_date'   => $date,
        'updated_date'   => $date,
      );

      $status = $this->db->insert('escalation_dates_details',$insertDateArray);
      
  }

  public function register(){
    $application_no = $_GET['appno'];
    $service_code = $_GET['service_code'];
    $status = $this->AutoRegistrationmodel->apiForRegistrationInDharitree($application_no,$service_code);
    var_dump($status);
    exit;
  }

  public function searchByEscalationZoneForDa()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $work_type = $this->input->post('work_type');

    $results = $this->Escalationmodel->getPendingMutationCasesDaEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status, $work_type);

    // var_dump($results); die;

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#1068: ==========".json_encode($rows));
    
          if($rows->es_flag == '1'){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            if(!empty($escRow) && $escRow !=null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 

                log_message('error', '#1073: Escalation details : '.json_encode($escData)); 

                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          if($work_type == 'notice_generate') {
            $link = base_url() . "index.php/officemutation/issueNotice?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;  
            $name = 'Print Notice';
          }
          else if($work_type == 'action_taken') {
            $link = base_url() . "index.php/officemutation/writenote?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;  
            $name = 'Write Report';
          }

          $button = "<a href=".$link." class='btn btn-success'> ".$name."</a>";

          $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);

          $hearing_date = '<p class="text-success"><i class="fa fa-calendar"></i> Hearing Date : '.date('M jS, Y',strtotime($rows->next_date_of_hearing)).'</p>';


          $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,

              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $location,

              $hearing_date,
              
              $button
          );
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }


  public function searchByEscalationZoneForLm()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $lot_no = $this->session->userdata('lot_no');
    $mouza = $this->session->userdata('mouza_pargona_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingOfficeMutationCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

    // var_dump($results); die;

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#1068: ==========".json_encode($rows));
    
          if($rows->es_flag == '1'){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            
            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 

            log_message('error', '#1171: Escalation details : '.json_encode($escData)); 

            $rows->escalation_date = $escData->escalation_date;
            $rows->escalation_zone = $escData->escalation_zone;
            $rows->assigned_date   = $escData->assigned_date;
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          // if($rows->mut_type == '03'){
          //   if ($rows->mode_of_registration == 'citizen') {
          //     $link = base_url() . "index.php/serviceplus/writeOfficeReport?case_no=".$rows->case_no;
          //   }
          //   else {
          //     $link = base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$rows->case_no;
          //   }
          // }

          $link = base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$rows->case_no;

          $button = "<a href=".$link." class='btn btn-primary'><i class='fa fa-pencil'></i> Write Report</a>";

          $hearing_date = '<p class="text-success"><i class="fa fa-calendar"></i> Hearing Date : '.date('M jS, Y',strtotime($rows->next_date_of_hearing)).'</p>';


          $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,

              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $location,

              $hearing_date,
              
              $button
          );
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }


  public function searchByEscalationZoneForSK()
  {
    $mut_type = $this->input->post('mut_type');
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $service_title = '';
    $wr_link = '';
    $lm_link = '';

    $results = $this->Escalationmodel->getPendingOfficeMutationCasesForSk($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

    var_dump($results); die;

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#1264: ==========".json_encode($rows));
    
          if($rows->es_flag == '1'){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            
            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->sk_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 

            log_message('error', '#1272: Escalation details : '.json_encode($escData)); 

            $rows->escalation_date = $escData->escalation_date;
            $rows->escalation_zone = $escData->escalation_zone;
            $rows->assigned_date   = $escData->assigned_date;
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          $lm_link = base_url() . "index.php/officemutation/lmreport?case_no=".$rows->case_no;

          if ($mut_type == '01' or $mut_type == '03') {
            $wr_link = base_url() . "index.php/skmutation/writeOfficeReport?case_no=".$rows->case_no;
          }

          if ($mut_type == '01') {
            $service_title = 'Conversion';
          } else if ($mut_type == '03') {
            $service_title = 'Mutation';
          } else if ($mut_type == '04') {
            $service_title = 'Partition';
          }

          $lm_report = "<a href=".$lm_link." class='btn btn-danger btn-xs' target='_blank'> <i class='fa fa-eye'></i> LM Report</a>";

          $write_report = "<a href=".$wr_link." class='btn btn-danger btn-xs' target='_blank'> <i class='fa fa-pencil'></i> Write Report</a>";

          // $write_report = "<a href=".$wr_link." class='btn btn-danger btn-xs'> <i class='fa fa-pencil'></i> Write Report</a>";

          

          $button = $lm_report . ' ' . $write_report;

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          
          $json[] = array(

            $rows->escalation_zone,
            $rows->escalation_date,

            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",

            $service_title,

            date('d-m-Y', strtotime($rows->date_entry)),
            
            $button
          );
        }
      }

      else {
        $json = "";
      }   
      
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }


  public function searchByEscalationZoneFieldMutationCo()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    
    $results = $this->Escalationmodel->getPendingFieldMutationCasesCoEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);

    // var_dump($results); die;

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#1359: ==========".json_encode($rows));
    
          if($rows->es_flag == '1'){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

            log_message('error', '#1365: Data from escalation_details : '.json_encode($escRow));
            log_message("error","#4343".$escRow->assigned_date);
            if($escRow->assigned_date != null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                log_message('error', '#1367: Escalation details : '.json_encode($escData)); 

                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          if($rows->mut_type == '01'){

            $lm_report = base_url()."index.php/skmutation/getLMReport1?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report." class='lmreportmut btn-sm btn btn-success'> LM Report</a>";
          }
          else {
            $lm_report = base_url()."index.php/skmutation/getLMReportPartition?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report." class='lmreportmut btn-sm btn btn-success'  id='myModal'> LM Report</a>"; 
          }



          $sk_report = base_url()."index.php/cofieldmutation/getSkNote?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
          $sk_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$sk_report." class='skreport btn-sm btn btn-success'> SK Report</a>"; 

          $fresh_lm_report = base_url()."index.php/cofieldmutation/freshLmReport?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
          $fresh_lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$fresh_lm_report." class='hide btn btn-sm btn-danger'> Fresh LM Report</a>";

          $reject_appl_btn = "<button type='button' class='btn btn-sm btn-danger' onclick=\"showRejectModal('$rows->case_no','2')\"><i class='fa fa-close'></i> &nbsp;Reject Application</button>";

          if($rows->basundhara) {

            $pass_order = base_url()."index.php/COFieldMutation/onePage?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $pass_order_button = "<a type='button' id='co-order' href=".$pass_order." class='btn btn-sm btn-info'> Pass Order</a>";

            $all_note_link = base_url()."index.php/lmmutation/proreport?case_no=".$rows->case_no;
            $all_note_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$all_note_link." class='skreport btn-sm btn btn-success'><i class='fa fa-envelope-open' aria-hidden='true'></i> All Note(s)</a>";

            $revert_back_link = base_url()."index.php/COFieldMutation/revertback?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $revert_back_button = "<a href=".$revert_back_link." class='text-small font-italic text-danger'>Click Here to Revert Back for Report</a>";

            $button = $lm_report_button.' '.$sk_report_button.' '.$fresh_lm_report_button.' '.$reject_appl_btn.' '.$pass_order_button.' '.$all_note_button.' '.$revert_back_button;

          }
          else {

            $pass_order_link = base_url()."index.php/COFieldMutation/viewcasedetails?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $pass_order_button = "<a id='co-order' href=".$pass_order_link." class='btn btn-sm btn-success'> Pass Order</a>";

            $button = $lm_report_button.' '.$sk_report_button.' '.$fresh_lm_report_button.' '.$reject_appl_btn.' '.$pass_order_button;
          }

          $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);

          $report_date = '<p class="text-success"><i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->report_date)).'</p>';

          $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

          if($rows->escalation_date != 'NA')
          {
            $json[] = array(

                $rows->escalation_zone,
                $rows->escalation_date,

                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                $location,

                $report_date,

                $button
            );
          }
          else
          {
            $json = "";
          }

          
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  // ***********************Added by Utpal**********************02082023


public function searchByEscalationZoneNameCancellationForCo()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingNameCancellationCasesForCo($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);
    log_message('error', '#1487 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#1497: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#1510: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          $link = base_url() . "index.php/NameCancellation/COStep2?misc_case_no=".$rows->misc_case_no;
          if(ESCALATION_ENABLE == 1 && $rows->is_escalated == 1)
          {
            $button = "Escalated to Appellate Authority";
          }
          else
          {
            $button = "<a href=".$link." class='btn btn-primary'><i class='fa fa-pencil'></i> Pass Order</a>";
          }
          
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $case_type = 'নাম কৰ্ত্তন';
          $e = $rows->basundhara;
          if(ESCALATION_ENABLE == 1){
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }






  public function searchByEscalationZoneNameCancellationForLm()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingNameCancellationCasesForLm($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);
    log_message('error', '#1583 == Pending Cases of LM :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#1595: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#1601: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#1605: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06') {
            $misc_case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrection/LMStep2?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else {
            $misc_case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/NameCancellation/LMStep2?misc_case_no=".$rows->misc_case_no."&&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Write Report</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $case_type = 'নাম কৰ্ত্তন';
          $e = $rows->basundhara;
          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

public function searchByEscalationZoneNameCancellationForAst()
  {
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingNameCancellationCasesForAst($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);
    log_message('error', '#1684 == Pending Cases of Ast :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        foreach($data_rows as $rows){
          log_message("error","#1694: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#1700: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->submission_date));
              log_message('error', '#1704: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06') {
            $misc_case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrection/ASTNoticeGenerate1?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else {
            $misc_case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/NameCancellation/ASTNoticeGenerate1?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Notice Generate</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $case_type = 'নাম কৰ্ত্তন';
          $e = $rows->basundhara;
          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
              $misc_case_type,
              $submission_date,
              $button
            );
          }
          else {
            $json[] = array(
              $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
              $misc_case_type,
              $submission_date,
              $button
            );
          }
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }


  public function searchByEscalationZoneNameCancellationForCoFinalProcess()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingNameCancellationCasesForCoFinalOrder($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);
    log_message('error', '#1867 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#1879: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#1889: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06'){
            $case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else if($rows->misc_case_type == '07'){
            $case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Pass Order</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $e = $rows->basundhara;
          if(ESCALATION_ENABLE == 1){
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function getPendingNameCancellationCasesForCoFinalOrder($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
  {
    $curr_date = date('Y-m-d');
    $col = 0;
    $dir = "asc";
    if(!empty($order)){
      foreach($order as $o){
        $col = $o['column'];
        $dir = $o['dir'];
      }
    }
    if($dir != "asc" && $dir != 'desc'){
      $dir = 'desc';
    }
    $valid_columns = array(
      0   => 'misc_case_basic.misc_case_petition_no',
    );
    if(!isset($valid_columns[$col])){
      $order = null;
    }else{
      $order = $valid_columns[$col];
    }
    if($order != null){
      $this->db->order_by($order, $dir);
    }
    if(!empty($searchByCol_0)){
      $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
    }
    $status = array('10', '02');
    $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
    $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
    $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('add_to_officer', $user_code);
    $this->db->where_in('misc_case_basic.status', $status);
    $this->db->where('misc_case_basic.operation !=', 'E');
    $this->db->where('misc_case_basic.misc_case_type', '07');
    $this->db->where('misc_case_basic.lm_note_yn', 'Y');
    $this->db->where('misc_case_basic.sk_note_yn', 'Y');
    $this->db->where('misc_case_basic.submission_date >=', $define_date);
    if($zone_status == 4){
      $this->db->where('misc_case_basic.es_flag', 0);
    }
    else {
      $this->db->where('misc_case_basic.es_flag', 1);
    }
    $this->db->limit($length, $start);
    $query = $this->db->get('misc_case_basic');
    log_message('error',"#4236: misc_case_basic: ".$this->db->last_query());
    if($query->num_rows()>0){
      $data_results = $query->result();
      $final_array = array();
      foreach($data_results as $rr)
      {
        $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->co_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no);
        if(!empty($variable)){
          $final_array[] = $variable;
        }
      }
      $data['data_results'] = $final_array;
      $data['total_records'] = count($final_array);
      if(!empty($searchByCol_0)){
        $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
      }
      $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('add_to_officer', $user_code);
      $this->db->where_in('misc_case_basic.status', $status);
      $this->db->where('misc_case_basic.operation !=', 'E');
      $this->db->where('misc_case_basic.misc_case_type', '07');
      $this->db->where('misc_case_basic.lm_note_yn', 'Y');
      $this->db->where('misc_case_basic.sk_note_yn', 'Y');
      $this->db->where('misc_case_basic.submission_date >=', $define_date);
      if($zone_status == 4){
        $this->db->where('misc_case_basic.es_flag', 0);
      }
      else {
        $this->db->where('misc_case_basic.es_flag', 1);
      }
      $res= $this->db->get('misc_case_basic')->result();
      $cc = array();
      foreach($res as $r) {
        if(!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1))
        {
          $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
          $perct_avail = (100*$remain_days)/$r->co_target_days;
          //green zone
          if(($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
            $cc[] = 1;
          }
          //yellow zone
          else if(($zone_status == 2) && (($perct_avail<YELLOW_ZONE) && ($perct_avail>RED_ZONE))) {
            $cc[] = 1;
          }
          //red zone
          else if(($zone_status == 3) && ($perct_avail<=RED_ZONE)) {
            $cc[] = 1;
          }
          else if($zone_status == 4) {
            $cc[] = 1;
          }
        }
        else {
          $cc[] = 1;
        }
      }
      $data['total_records']= count($cc);
      return $data;
    }
  }



  public function searchByEscalationZoneNameCancellationRevertForLm()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');

    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingNameCancellationRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);
    log_message('error', '#2002 == Pending Cases of LM :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#2009: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#2012: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#2015: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06') {
            $misc_case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrection/LMStep2?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else {
            $misc_case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/index.php/NameCancellation/LMStep2_revert?misc_case_no=".$rows->misc_case_no."&&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Write Report</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));

          $e = $rows->basundhara;
          
          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }



  public function searchByEscalationZoneMobileUpdationForCo()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingMobileUpdationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#2111: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            if(!empty($escRow) && $escRow !=null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_of_reg));
                log_message('error', '#2119: Escalation details : '.json_encode($escData));
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          $link = base_url() . "index.php/LegacyCorrection/coReportMobileUpdation?case_no=".$rows->case_no."&petition_no=".$rows->petition_no;
          $button = "<a href=".$link." class='btn btn-success'> Write Report</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->date_of_reg)).'</p>';
          $e = $rows->basundhara;
          $type = "ম'বাইল আপডেচন";
          if(ESCALATION_ENABLE == 1){
            $json[] = array(
              $i,
              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $type,
              $submission_date,
              $button
            );
          }
          else {
            $json[] = array(
              $i,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $type,
              $submission_date,
              $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneAreaDataCorrectionForLm()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');

    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingAreaDataCorrectionLmEnd($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#2204: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            if(!empty($escRow) && $escRow !=null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_of_reg));
                log_message('error', '#2209: Escalation details : '.json_encode($escData));
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          if($rows->service_type == 'A'){
            $service_type = 'ক্ষেত্ৰ সংশোধন';
            $link = base_url() . "index.php/LegacyCorrection/LMReportAreaNameCorrection?case_no=".$rows->case_no."&petition_no=".$rows->petition_no;
          }
          else if($rows->service_type == 'N'){
            $service_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/LegacyCorrection/LMReportAreaNameCorrection?case_no=".$rows->case_no."&petition_no=".$rows->petition_no;
          }
          
          $button = "<a href=".$link." class='btn btn-success'> Write Report</a>";

          $submission_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->date_of_reg)).'</p>';

          $e = $rows->basundhara;

          if(ESCALATION_ENABLE == 1){
            $json[] = array(
              $i,
              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $service_type,
              $submission_date,
              $button
            );
          }
          else {
            $json[] = array(
              $i,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $service_type,
              $submission_date,
              $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneAreaDataCorrectionForCo()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingAreaDataCorrectionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#2303: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            if(!empty($escRow) && $escRow !=null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_of_reg));
                log_message('error', '#2308: Escalation details : '.json_encode($escData));
                if(!empty($escData) && $escData !=null){
                  $rows->escalation_date = $escData->escalation_date;
                  $rows->escalation_zone = $escData->escalation_zone;
                  $rows->assigned_date   = $escData->assigned_date;
                }else{
                  $rows->escalation_date = 'NA';
                  $rows->escalation_zone = 'NA';
                }
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          if($rows->petition_no == 'A'){
            $service_type = "ক্ষেত্ৰ সংশোধন";
            $link = base_url() . "index.php/LegacyCorrection/COReportAreaNameCorrection?case_no=".$rows->case_no."&petition_no=".$rows->petition_no;
          }
          else if($rows->petition_no == 'A'){
            $service_type = "নাম সংশোধন";
            $link = base_url() . "index.php/LegacyCorrection/COReportAreaNameCorrection?case_no=".$rows->case_no."&petition_no=".$rows->petition_no;
          }
          
          $button = "<a href=".$link." class='btn btn-success'> Write Report</a>";

          $submission_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->date_of_reg)).'</p>';

          $e = $rows->basundhara;

          if(ESCALATION_ENABLE == 1){
            $json[] = array(
              $i,
              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $type,
              $submission_date,
              $button
            );
          }
          else {
            $json[] = array(
              $i,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $type,
              $submission_date,
              $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  //************************** added on 09/08/2023 ****************************
  public function searchByEscalationZoneReclassificationForCo() // co
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingReclassificationCasesCoEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);
    // var_dump($results); die;
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        foreach($data_rows as $rows){
          log_message("error","#2411: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            if(!empty($escRow))
            {
                // log_message('error', '#2417: Data from escalation_details : '.json_encode($escRow));
                // log_message("error","#2418".$escRow->assigned_date);
                if($escRow->assigned_date != null){
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                    log_message('error', '#2422: Escalation details : '.json_encode($escData));
                    $rows->escalation_date = $escData->escalation_date;
                    $rows->escalation_zone = $escData->escalation_zone;
                    $rows->assigned_date   = $escData->assigned_date;
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
            else
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          $prop_link = base_url()."index.php/LandReclassification/FirstCoProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;
          $proposal_no = "<a href=".$prop_link.">".$rows->proposal_no."</a>";
          $submitted_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->lm_date));
          $proceed = "<a href=".$prop_link." class='btn btn-success'>Proceed</a>";
          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $proposal_no,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $rows->dag_no,
              $rows->lm_date,
              $proceed
          );
        }
      }
      else {
        $json = "";
      }
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }

  public function searchByEscalationZoneReclassificationForAdc() // adc
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingReclassificationCasesAdcEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);
    // var_dump($results); die;
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        foreach($data_rows as $rows){
          log_message("error","#2505: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            // log_message('error', '#2511: Data from escalation_details : '.json_encode($escRow));
            // log_message("error","#2512".$escRow->assigned_date);
            if(!empty($escRow))
            {
                if($escRow->assigned_date != null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->adc_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                log_message('error', '#2516: Escalation details : '.json_encode($escData));
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
            else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
            } 
            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          $prop_link = base_url()."index.php/LandReclassification/FirstDCProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;
          $proposal_no = "<a href=".$prop_link.">".$rows->proposal_no."</a>";
          $submitted_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->lm_date));
          $proceed = "<a href=".$prop_link." class='btn btn-success'>Proceed</a>";
          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $proposal_no,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $rows->dag_no,
              $rows->lm_date,
              $proceed
          );
        }
      }
      else {
        $json = "";
      }
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }

  public function searchByEscalationZoneReclassificationForDc() // dc
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingReclassificationCasesDcEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);
    // var_dump($results); die;
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        foreach($data_rows as $rows){
          log_message("error","#2600: ==========".json_encode($rows));
          if($rows->es_flag == '1'){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            log_message('error', '#2606: Data from escalation_details : '.json_encode($escRow));
            log_message("error","#2607".$escRow->assigned_date);
            if($escRow->assigned_date != null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->dc_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                log_message('error', '#2611: Escalation details : '.json_encode($escData));
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }else{
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          $prop_link = base_url()."index.php/LandReclassification/FirstDCProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;
          $proposal_no = "<a href=".$prop_link.">".$rows->proposal_no."</a>";
          $submitted_date = '<i class="fa fa-calendar"></i> Submited On : '.date('d-m-Y',strtotime($rows->lm_date));
          $proceed = "<a href=".$prop_link." class='btn btn-success'>Proceed</a>";
          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $proposal_no,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $rows->dag_no,
              $rows->lm_date,
              $proceed
          );
        }
      }
      else {
        $json = "";
      }
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }








  //*************** added on 18082023

  public function searchByEscalationZoneFieldPartitionCo()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    
    $results = $this->Escalationmodel->getPendingFieldPartitionCasesCoEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);

    // var_dump($results); die;

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#2645: ==========".json_encode($rows));
    
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            log_message('error', '#2650: Data from escalation_details : '.json_encode($escRow));

            if(!empty($escRow) && $escRow != null)
            {
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

              log_message('error', '#2656: Escalation details : '.json_encode($escData)); 

              if(!empty($escData) && $escData != null)
              {
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
              }
              else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
              }              
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }


          if($rows->basundhara && $rows->es_flag == null) 
          {
            $revert_back_report = base_url()."index.php/COFieldMutation/revertback?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $revert_back_button = "<a href=".$revert_back_report." class='text-small font-italic text-danger'> Click Here to Revert Back for Report</a><br>";
          }
          else if($rows->basundhara && $rows->es_flag == 1) 
          {
            $revert_back_report = base_url()."index.php/COFieldMutation/revertbackNew?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $revert_back_button = "<a href=".$revert_back_report." class='text-small font-italic text-danger'> Click Here to Revert Back for Report</a><br>";
          }

          if($rows->mut_type == '01'){

            $lm_report = base_url()."index.php/skmutation/getLMReport1?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report." class='lmreportmut btn-sm btn btn-success'> LM Report</a>";
          }
          else {
            $lm_report = base_url()."index.php/skmutation/getLMReportPartition?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
            $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report." class='lmreportmut btn-sm btn btn-success'  id='myModal'> LM Report</a>"; 
          }



          $sk_report = base_url()."index.php/cofieldmutation/getSkNote?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
          $sk_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$sk_report." class='skreport btn-sm btn btn-success'> SK Report</a>";

          $reject_application = "<button type='button' class='btn btn-sm btn-danger' onclick=\"showRejectModal('".$rows->case_no."','".SERVICE_FIELD_PARTITION."')\"><i class='fa fa-close'></i> &nbsp;Reject Application</button>";

          $pass_order_report = base_url()."index.php/Partition/finalOrderFieldPartitionCO?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
          $pass_order_button = "<a type='button' id='co-order' href=".$pass_order_report." class='btn btn-sm btn-primary'> Pass Order New</a>";
          $propertychainBtn = '';
          if(ENABLED_BLOCKCHAIN == 1 && in_array($rows->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){
                                            
            $propertychainBtn = "<button type='button' data-toggle='modal' data-target='#myModal' case_no=".$rows->case_no." dist_code=".$rows->dist_code." subdiv_code=".$rows->subdiv_code." cir_code=".$rows->cir_code." mouza_pargona_code=".$rows->mouza_pargona_code." lot_no=".$rows->lot_no." vill_townprt_code=".$rows->vill_townprt_code." class='chainReport btn-sm btn btn-success'>View Property Chain</button>";
            }

          $button = $revert_back_button.' '.$lm_report_button.' '.$sk_report_button.' '.$reject_application.' '.$pass_order_button . ' '.$propertychainBtn;

          $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);

          $report_date = '<p class="text-success"><i class="fa fa-calendar"></i> '.date('d-m-Y',strtotime($rows->report_date)).'</p>';

          $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

          $json[] = array(

            $rows->escalation_zone,
            $rows->escalation_date,

            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
            $location,

            $report_date,
            
            $button
          );
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneForLmOfficePartition()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $lot_no = $this->session->userdata('lot_no');
    $mouza = $this->session->userdata('mouza_pargona_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingOfficePartitionCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#2781: ==========".json_encode($rows));
    
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
              log_message('error', '#2789: Escalation details : '.json_encode($escData)); 

              if(!empty($escRow) && $escRow != null){
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
              }
              else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          $link = base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$rows->case_no;

          $button = "<a href=".$link." class='btn btn-primary'><i class='fa fa-pencil'></i> Write Report</a>";

          $submission_date = '<i class="glyphicon glyphicon-calendar"></i> '.date('d/m/Y',strtotime($rows->submission_date)).'</p>';

          if ($rows->mut_type == '04') {
            $rep_link = base_url().'index.php/partition/LmPartitionRpt?petition_no='.$rows->petition_no.'&case_no='.$rows->case_no;
            $button = "<a class='btn btn-danger msg' href='".$rep_link."'>Write Report</a>";
          }
          $title = 'Office Partition';

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,

              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $title,

              $submission_date,
              
              $button
          );
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneForAstOfficePartitionNoticeGenerate()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');

    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingOfficePartitionCasesForAstNoticeGenrate($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#2884: ==========".json_encode($rows));
    
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 
              log_message('error', '#2892: Escalation details : '.json_encode($escData)); 

              if(!empty($escRow) && $escRow != null){
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
              }
              else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          if($rows->comp_serv_yn=='Y') {
            $case_no = $rows->case_no;
          }
          else {
            $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
            $case_no = $rows->case_no."<br><span class='small font-italic red'>".$e."</span>";
          }
          $title = 'Office Partition';

          if ($rows->pay_notice_gen_yn == 'Y') {

            $link = base_url()."index.php/partition/ByayNoticeGenerate?pid=".$rows->petition_no."&case=".$rows->case_no;
            $button = "<a class='btn btn-danger' href='".$link."'>Write Report</a>";
          }
          else {
            $link = base_url()."index.php/partition/NoticeSubmit?id=".$rows->petition_no."&case=".$rows->case_no;
            $button = "<a class='btn btn-danger' href='".$link."'>Write Report</a>";
          }
          $submission_date = date('d/m/Y', strtotime($rows->submission_date));

          $json[] = array(
            $rows->escalation_zone,
            $rows->escalation_date,
            $case_no,
            $title,
            $submission_date,              
            $button
          );
        }
      }
      else {
        $json = "";
      }
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }


  public function searchByEscalationZoneForAstOfficePartitionActionTaken()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingOfficePartitionCasesForAstActionTaken($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);
    
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#2990: ==========".json_encode($rows));
    
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 
              log_message('error', '#2996: Escalation details : '.json_encode($escData)); 

              if(!empty($escRow) && $escRow != null){
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
              }
              else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          
          $title = 'Office Partition';
          $link = base_url()."index.php/partition/AsstActionTaken?case=".$rows->case_no;
          $button = "<a class='btn btn-danger' href='".$link."'>Write Report</a>";          
          $submission_date = date('d/m/Y', strtotime($rows->submission_date));
          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

          $json[] = array(
            $rows->escalation_zone,
            $rows->escalation_date,
            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
            $title,
            $submission_date,              
            $button
          );
        }
      }

      else {
        $json = "";
      }   
      
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }

  public function searchByEscalationZoneForSKOfficePartition()
  {
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $lot_no = $this->session->userdata('lot_no');
    $mouza = $this->session->userdata('mouza_pargona_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');

    $results = $this->Escalationmodel->getPendingOfficePartitionCasesForSK($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);
    $json = '';
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0){
        foreach($data_rows as $rows){
      
          log_message("error","#2781: ==========".json_encode($rows));
    
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
              log_message('error', '#2789: Escalation details : '.json_encode($escData)); 

              if(!empty($escRow) && $escRow != null){
                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
              }
              else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }            
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          $link = base_url() . "index.php/partition/SKPartitionRedirect?case_no=".$rows->case_no."&vill=".$rows->vill_townprt_code."&m=".$rows->mouza_pargona_code."&l=".$rows->lot_no."&p=".$rows->petition_no."&y=".$rows->year_no;

          $button = "<a href=".$link." class='btn btn-primary'><i class='fa fa-pencil'></i> Write Report</a>";

          $submission_date = '<i class="glyphicon glyphicon-calendar"></i> '.date('d/m/Y',strtotime($rows->submission_date)).'</p>';

          // if ($rows->mut_type == '04') {
          //   $rep_link = base_url().'index.php/partition/LmPartitionRpt?petition_no='.$rows->petition_no.'&case_no='.$rows->case_no;
          //   $button = "<a class='btn btn-danger msg' href='".$rep_link."'>Write Report</a>";
          // }
          $title = 'Office Partition';

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
          $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,

              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $title,

              $submission_date,
              
              $button
          );
        }
      }

      else {
          $json = "";
      }   
      
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneNameCorrectionForCoFinalProcess()
  {
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $define_date = define_date;
    $zone_status = $this->input->post('zone_status');
    $results = $this->Escalationmodel->getPendingNameCorrectionCasesForCoFinalOrder($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);
    log_message('error', '#1867 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#1879: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#1889: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06'){
            $case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else if($rows->misc_case_type == '07'){
            $case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Pass Order</a>";
          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $e = $rows->basundhara;
          if(ESCALATION_ENABLE == 1){
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }


  // added on 20/01/2024

  // search by zone for area correction from CO
  public function searchByEscalationZoneAreaCorrectionCo()
  {
    $dist_code     = $this->session->userdata('dist_code');
    $subdiv_code   = $this->session->userdata('subdiv_code');
    $cir_code      = $this->session->userdata('cir_code');
    $draw          = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start         = intval($this->input->post('start'));
    $length        = intval($this->input->post('length'));
    $order         = $this->input->post('order');
    $define_date   = define_date;
    $zone_status   = $this->input->post('zone_status');
    
    $results = $this->Escalationmodel->getPendingAreaCorrectionCasesCoEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);

    // var_dump($results); die;

    if(isset($results))
    {
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0)
      {
        foreach($data_rows as $rows)
        {      
          log_message("error","#1359: ==========".json_encode($rows));
    
          if($rows->es_flag == '1')
          {
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            log_message('error', '#1365: Data from escalation_details : '.json_encode($escRow));
            log_message("error","#4343".$escRow->assigned_date);

            if($escRow->assigned_date != null)
            {
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                log_message('error', '#1367: Escalation details : '.json_encode($escData)); 

                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }
            else
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }            
          }
          else 
          {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          // $proposal_report = base_url()."index.php/LegacyDataUpdation/FirstCoProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;

          $proposal_report = base_url() . "index.php/LegacyDataUpdation/FirstCoProcess?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&proposal_no=" . $rows->proposal_no;

          $proposal_button = "<a href=".$proposal_report."> Proposal no : ".$rows->proposal_no."</a>";

          $dag_patta = $rows->dag_no .' / '.$rows->patta_no;

          $report_date = '<i class="fa fa-calendar"></i> '.date('M jS, Y',strtotime($rows->lm_date));

          $give_order_button = "<a class='btn btn-success' href=".$proposal_report."> Give Order</a>"; 

          if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
          {

            $block_chain_btn = '<button type="button" data-toggle="modal" data-target="#myModal" class="chainReportAC btn btn-primary" case_no="'.$rows->case_no.'" dist_code="'.$rows->dist_code.'" subdiv_code="'.$rows->subdiv_code.'" cir_code="'.$rows->cir_code.'" mouza_pargona_code="'.$rows->mouza_pargona_code.'" lot_no="'.$rows->lot_no.'" vill_townprt_code="'.$rows->vill_townprt_code.'">View Property Chain</button';

            $button = $give_order_button.' '.$block_chain_btn;
          }
          else 
          {
            $button = $give_order_button;
          }

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

          if($rows->escalation_date != 'NA')
          {
            $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $proposal_button,
              $dag_patta,
              $report_date,
              $button
            );
          }
          else
          {
            $json = "";
          }
        }
      }
      else 
      {
        $json = "";
      }   
      
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }

  
  // search by zone for area correction from CO
  public function searchByEscalationZoneAreaCorrectionAdc()
  {
    $dist_code     = $this->session->userdata('dist_code');
    $subdiv_code   = $this->session->userdata('subdiv_code');
    $cir_code      = $this->session->userdata('cir_code');
    $draw          = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start         = intval($this->input->post('start'));
    $length        = intval($this->input->post('length'));
    $order         = $this->input->post('order');
    $define_date   = define_date;
    $zone_status   = $this->input->post('zone_status');
    
    $results = $this->Escalationmodel->getPendingAreaCorrectionCasesAdcEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$define_date,$searchByCol_0, $zone_status);

    // var_dump($results); die;

    if(isset($results))
    {
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];

      if($total_records > 0)
      {
        foreach($data_rows as $rows)
        {      
          log_message("error","#1359: ==========".json_encode($rows));
    
          if($rows->es_flag == '1')
          {
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            log_message('error', '#1365: Data from escalation_details : '.json_encode($escRow));
            log_message("error","#4343".$escRow->assigned_date);

            if($escRow->assigned_date != null)
            {
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                log_message('error', '#1367: Escalation details : '.json_encode($escData)); 

                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }
            else
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }            
          }
          else 
          {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          // $proposal_report = base_url()."index.php/LegacyDataUpdation/FirstCoProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;
          $proposal_report = base_url() . "index.php/LegacyDataUpdation/FirstCoProcess?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&proposal_no=" . $rows->proposal_no;


          $proposal_button = "<a href=".$proposal_report."> Proposal no : ".$rows->proposal_no."</a>";

          $dag_patta = $rows->dag_no .' / '.$rows->patta_no;

          $report_date = '<i class="fa fa-calendar"></i> '.date('M jS, Y',strtotime($rows->lm_date));

          // $give_report = base_url()."index.php/LegacyDataUpdation/FirstDCProcess?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;
          $give_report = base_url() . "index.php/LegacyDataUpdation/FirstDCProcess?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&proposal_no=" . $rows->proposal_no;


          $give_order_button = "<a href=".$give_report." class='btn btn-success'> Give Order</a>";

          $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

          if($rows->escalation_date != 'NA')
          {
            $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $proposal_button,
              $dag_patta,
              $report_date,
              $give_order_button
            );
          }
          else
          {
            $json = "";
          }
        }
      }
      else 
      {
        $json = "";
      }   
      
      $response = array(
        'draw'              => $draw,
        'recordsTotal'      => $total_records,
        'recordsFiltered'   => $total_records,
        'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      echo json_encode($response);
    }
  }

  public function fetchData($petition_no)
  {
    $data =array();
    $output = $this->Escalationmodel->fetchQueryData($petition_no);
    $data['escData'] = $output;
    // var_dump($data['escData']['escalationDetails']);die;
    $this->load->view('escalation/queryView',$data);
  }

  public function autoEscalateCases(){
    $this->db->trans_begin();
    $status1 = $this->AutoEscalationmodel->autoEscalateToRespectiveOfficer();

    if($status1['response'] != 3)
    {
        log_message('error','#ERRORESC3556.=========AutoEscalation Failed');
        $this->db->trans_rollback();
    }
    if($this->db->trans_status() === FALSE)
    {
        $this->db->trans_rollback();
    }
    else
    {

        $this->db->trans_commit();
        echo "Completed";
    }
    echo "---";

    
    // $status2 = $this->AutoEscalationmodel->updateTablesIfHoliday();
    // if($status2['response'] != 3)
    // {
    //     log_message('error','#ERRORESC3562.=========AutoEscalation Failed');
    //     $this->db->trans_rollback();
    // }
    // var_dump($status1);
    // exit;
  }

  //auto escalate case by case no===============
  public function autoEscalateCasesByCaseNo($case_no){
    $caseRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
    $status = $this->AutoEscalationmodel->autoEscalateByCaseNoAndServiceCode($caseRow);
    var_dump($status);
  }



  // added on 05/04/2024
  public function searchByEscalationZoneNameCorrectionForLm()
  {
    $user_code          = $this->session->userdata('user_code');
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no             = $this->session->userdata('lot_no');
    $draw               = intval($this->input->post('draw'));
    $searchByCol_0      = $this->input->post('columns')[0]['search']['value'];
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');
    $define_date        = define_date;
    $zone_status        = $this->input->post('zone_status');

    $results            = $this->Escalationmodel->getPendingNameCorrectionCasesForLm($dist_code, $subdiv_code,
                          $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, 
                          $searchByCol_0, $zone_status, $user_code);

    log_message('error', '#3639 == Pending Cases of LM :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#3646: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#3649: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#3652: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          if($rows->misc_case_type == '06') {
            $misc_case_type = 'নাম সংশোধন';
            $link = base_url() . "index.php/NameCorrectionV2/LMStep2Esc?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;
          }
          else {
            $misc_case_type = 'নাম কৰ্ত্তন';
            $link = base_url() . "index.php/NameCancellation/LMStep2?misc_case_no=".$rows->misc_case_no."&&petition_no=".$rows->misc_case_petition_no;
          }
          $button = "<a href=".$link." class='btn btn-primary'> Write Report</a>";

          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          $case_type = 'নাম কৰ্ত্তন';
          $e = $rows->basundhara;

          $message = 'Escalated to Appellate Authority';

          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $rows->is_escalated == 1 ? $message : $button,
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }


  public function searchByEscalationZoneNameCorrectionForCo()
  {

    $allowed = ['CO'];
    $user_desig_code = $this->session->userdata('user_desig_code');

    // Restrict access if not in allowed list
    if ( ! in_array($user_desig_code, $allowed)) {
        echo json_encode(['error' => 'Unauthorized access']);
        exit; // or die();
    }


    $user_code          = $this->session->userdata('user_code');
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $draw               = intval($this->input->post('draw'));
    $searchByCol_0      = $this->input->post('columns')[0]['search']['value'];
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');
    $define_date        = define_date;
    $zone_status        = $this->input->post('zone_status');

    $results            = $this->Escalationmodel->getPendingNameCorrectionCasesForCo($dist_code, $subdiv_code,
                          $cir_code, $start, $length, $order, $define_date, 
                          $searchByCol_0, $zone_status, $user_code);

    log_message('error', '#3748 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#3755: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#3758: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#3761: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
          
          $misc_case_type = 'নাম সংশোধন';

          $link = base_url() . "index.php/NameCorrectionV2/finalOrderCONameCorrection?misc_case_no=".$rows->misc_case_no."&petition_no=".$rows->misc_case_petition_no;

          $button = "<a href=".$link." class='btn btn-primary'> Pass Order</a>";

          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));

          $e = $rows->basundhara;

          $message = 'Escalated to Appellate Authority';

          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $rows->is_escalated == 1 ? $message : $button,
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",
                $misc_case_type,
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }

  public function searchByEscalationZoneNameCorrectionForAdc()
  {
    $user_code          = $this->session->userdata('user_code');
    $dist_code          = $this->session->userdata('dist_code');
    $draw               = intval($this->input->post('draw'));
    $searchByCol_0      = $this->input->post('columns')[0]['search']['value'];
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');
    $define_date        = define_date;
    $zone_status        = $this->input->post('zone_status');

    $results            = $this->Escalationmodel->getPendingNameCorrectionCasesForAdc($dist_code, $start, 
                          $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code);

    log_message('error', '#3853 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          log_message("error","#3860: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
            log_message('error', '#3863: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->adc_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              log_message('error', '#3866: Escalation details : '.json_encode($escData));
              $rows->escalation_date = $escData->escalation_date;
              $rows->escalation_zone = $escData->escalation_zone;
              $rows->assigned_date   = $escData->assigned_date;
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
          }
          else {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }

          $link = base_url() . "index.php/NameCorrectionV2/finalOrderADCNameCorrection?submission_date=".$rows->submission_date."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code."&year_no=".$rows->year_no."&petition_no=".$rows->misc_case_petition_no."&misc_case_no=".$rows->misc_case_no;

          $button = "<a href=".$link." class='btn btn-primary'> Pass Order</a>";

          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y',strtotime($rows->submission_date));
          
          $e = $rows->basundhara;

          $message = 'Escalated to Appellate Authority';

          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
                $i,
                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",               
                $submission_date,
                $rows->is_escalated == 1 ? $message : $button,
            );
          }
          else {
            $json[] = array(
                $i,
                $rows->misc_case_no."<br><span class='small font-italic red'>".$e."</span>",               
                $submission_date,
                $button
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
          'draw'              => $draw,
          'recordsTotal'      => $total_records,
          'recordsFiltered'   => $total_records,
          'data'              => $json
      );
      echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }
  }
}
?>