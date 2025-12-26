<?php

class NameCorrectionV2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('APCancellation/APCancellationModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('misreport/MisModel');
        $this->load->library('session');
        $this->load->model('NameCorrection/NameCorrectionModel');
        $this->load->model('NameCorrection/NameCorrectionModelV2');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('validation/FormValidationModel');

        if(ENABLED_BLOCKCHAIN == 1)
        {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
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
     }                                                                                                                                                                                                            
}

    

    public function LMEscStep1() 
    {
        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $config['base_url'] = base_url() . '/index.php/NameCorrectionV2/LMEscStep1/';
        $data['countMiscCase'] = $this->NameCorrectionModelV2->getMiscCaseLMEsc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $cases['TotMisc'] = $this->NameCorrectionModelV2->getMiscCaseLM1Esc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)->result();
        $case_array = array();
        //$var_dump($case_array);
        foreach ($cases['TotMisc'] as $c) 
        {
            $q = $this->db->query("select misc_case_type,misc_case_no,submission_date,es_flag,is_escalated, out_of_esc from    misc_case_basic where lm_note_yn is  null and es_flag='1' and fresh_yn='Y'")->row();
            array_push($case_array, $c);
        }
        $data['MisCases'] = $case_array;

        // echo "<pre>";var_dump($data['MisCases']); die;

        if(ESCALATION_ENABLE == 1){
            foreach($data['MisCases'] as $rows) {
                if($rows->es_flag == 1 && $rows->out_of_esc == 0){
                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
                    // log_message('error', '#109: From escalation_detail_table : '.json_encode($escRow));

                    // echo "<pre>";var_dump($escRow); die;
                    
                    if(!empty($escRow) && $escRow != null){
                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
                        log_message('error', '#112: Escalation details : '.json_encode($escData));
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                    
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
        }


        $data['_view'] = 'NameCorrection/v2/LMStep1Esc';
        $this->load->view('layouts/main',$data);
    }

     public function COEscStep1() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->library('pagination');
        $db=  $this->session->userdata('db');
        $case_array = array();
        $searchKeyword=null;
        if($this->input->post('submitSearch')){
              $inputKeywords = $this->input->post('searchKeyword');
              $searchKeyword = strip_tags($inputKeywords);
              if(!empty($searchKeyword)){
                  $this->session->set_userdata('searchKeyword',$searchKeyword);
              }else{
                  $this->session->unset_userdata('searchKeyword');
              }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }

        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        $config['base_url'] = base_url().'index.php/NameCorrectionV2/COEscStep1';        
        $config['total_rows'] = $this->NameCorrectionModelV2->getMiscCases1();        
        $config['per_page'] = 10;        
        $config['uri_segment'] = 3;        
        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li>';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="prev">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li>';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li>';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li>';        
        $config['num_tag_close'] = '</li>';
        //var_dump($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);        
        $cases['links'] = $this->pagination->create_links();        
        $cases['MisCases'] = $this->NameCorrectionModelV2->getMiscCases2($config["per_page"], $page,$searchKeyword); 

        // log_message('error', "#ERR185: ".json_encode($cases['MisCases']));

        $cases['_view'] = 'NameCorrection/v2/COEscStep1';
        $this->load->view('layouts/main',$cases);
    }

    public function LMStep2Esc() 
    {
        $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
            $case_no = $this->input->get('misc_case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
            $lot_no1 = $this->input->get('lot_no');
            $vill_townprt_code1 = $this->input->get('vill_townprt_code');
            $data['case_no'] = $case_no;
            $sql="Select * from misc_case_basic where misc_case_no = '$case_no'";
            $misc=$this->db->query($sql)->row();
           // var_dump($misc);
            $data['app'] = $misc;
            $sql_applicant="Select * from misc_case_first_party where misc_case_no = '$case_no'";
            $data['firstparty']=$firstparty=$this->db->query($sql_applicant)->row();
            //$data['applicant_info'] = $applicant_info;
            $data['applicant_info'] = json_decode($firstparty->applicant_info);

            $data['selfDecData'] = json_decode($firstparty->self_declaration);
            $data['aadhaarData'] = json_decode($firstparty->applicant_info);
            $data['basuCase']=null;
            // $data['app']=$rtps=null;
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $data['application_no'] = $basundharaExist;


            if($firstparty->auth_type !=null){
                $statusAadhar = "<i class='fa fa-check'></i> ".$firstparty->auth_type. " Verified";
                $engName = $data['applicant_info'][0]->pat_name_eng;
            }else{
                $statusAadhar = 'N/A';
                $engName = null;
            }
            $data['status'] = $statusAadhar;
            $data['engName'] = $engName;



            $application_no_sql="select * from basundhar_application where dharitree='$case_no' ";
            $data['application'] = $this->db->query($application_no_sql)->row();

            $data['base64_decoded_adhar_file'] = "";
            if (!empty($data['applicant_info']) && $data['applicant_info'] !=null && trim($firstparty->auth_type) == 'AADHAAR' ):

                    $adhar_photo_link = $firstparty->photo;
                    if($adhar_photo_link == null)
                    {
                        $url = RTPS_API_LINK."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $data['application']->basundhara,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if($aadhaarPhotoReCall != 'n')
                        {
                            $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                            $aadhar_path = AADHAAR_UPLOAD_DIR. $firstparty->id_ref_no . '.json';

                            if($aadhar_path == null || $aadhar_path == '')
                            {
                                $this->load->model('AadhaarPhotoViewModel');
                                $get_aadhaar_photo = $this->AadhaarPhotoViewModel->aadhaarPhotoView($data['application']->basundhara);
                                if($get_aadhaar_photo != 'n'){
                                  $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                                }
                            }
                            else
                            {
                              $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                              $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                              fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                              fclose($aadhaar_file_to_write_base64);
                              $idRefNo = $firstparty->id_ref_no;
                              $query = "update misc_case_first_party set photo = '$aadhar_path' where misc_case_no='$case_no' and id_ref_no = '$idRefNo' and auth_type is not null";
                              $this->db->query($query);
                             
                              $adhar_photo_link = $aadhar_path;
                            }
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }
                    }
                    //**********reopening the updated file */

                    if($adhar_photo_link == null || $adhar_photo_link == '')
                    {
                        $this->load->model('AadhaarPhotoViewModel');
                        $get_aadhaar_photo = $this->AadhaarPhotoViewModel->aadhaarPhotoView($data['application']->basundhara);
                        if($get_aadhaar_photo != 'n'){
                          $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        }
                    }
                    else
                    {
                      $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                      $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                      fclose($open_adhar_file);
                      // decoding the base64 encoding file variable
                      $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
                    }
                    
          
                
            endif;





            $user_code=$this->session->userdata('user_code');

            $data['lm'] = $this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code, $cir_code,$mouza_pargona_code1,$lot_no1,$user_code);

            $data['user'] = $this->rtpsmodel->usersForOfficeMisc($dist_code,$subdiv_code, $cir_code);


            if($basundharaExist){
                $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
                $data['query']=null;
                $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $url = RTPS_API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                }else{
                    $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                }
                //var_dump($data['basundharaAttachment']);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                
            }
        //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $misc->es_flag == 1 && $misc->out_of_esc == 0)
            {
                $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
                $data['remainingTime'] = $remainingTime;
                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS/////////

            $params = [
              'case_no'          => $case_no,
              'service_code'     => 6,
              'remarks'          => 'Name Correction',
              'accessed_entity'  => 'Aadhaar Name, Photo',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $data['_view'] = 'NameCorrection/v2/namecorrection_lm';
        $this->load->view('layouts/main',$data);
    }

    

    public function ViewLMReport() {
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $data['lm_report'] = $this->NameCorrectionModel->getLMReport($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        // $this->load->view('../views/NameCorrection/ViewLMReport', $data);
        // $this->load->view('../views/footer');

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
      $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        $data['_view'] = 'NameCorrection/ViewLMReport';
        $this->load->view('layouts/main',$data);
    }

    public function COFinalOrderMiscCase1() {
        // $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $config['base_url'] = base_url() . '/index.php/NameCorrection/COFinalOrderMiscCase1/';
        $data['countMiscCase'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        $cases['TotMisc'] = $this->NameCorrectionModel->getFinalOrderMisc1($user_code)->result();
        $case_array = array();
        foreach ($cases['TotMisc'] as $c) {
            $q = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code, misc_case_type,misc_case_no,submission_date from    misc_case_basic where status='02' and lm_note_yn='Y' and sk_note_yn='Y'")->row();
            array_push($case_array, $c);
        }
        $data['MisCases'] = $case_array;
        // $this->load->view('../views/NameCorrection/COFinalOrderMiscCase1', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'NameCorrection/COFinalOrderMiscCase1';
        $this->load->view('layouts/main',$data);
    }

    public function COFinalOrderMiscCase2() {
        // $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);

        $sql1 = "select patta_no from    misc_case_basic where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result1 = $this->db->query($sql1);
        $patta_no = $result1->row()->patta_no;

        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        $data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);

        $data['lm_report'] = $this->NameCorrectionModel->getLMReport($misc_case_no, $petition_no);
        $data['sk_report'] = $this->NameCorrectionModel->getSKReport($misc_case_no, $petition_no);

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $this->db->query($application_no)->row();

        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }
        // $this->load->view('../views/NameCorrection/COFinalOrderMiscCase2', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'NameCorrection/COFinalOrderMiscCase2';
        $this->load->view('layouts/main',$data);
    }

    public function COFinalOrderMiscCase2_save() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no');
        $co_report = $this->input->post('co_report');
        $note_date = date('Y-m-d');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
        $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result = $this->db->query($sql);
        $note_no = ($result->row()->note_no) + 1;
        $status = '10';
        $operation = 'c';
        $co_fresh_proceeding = 'Y';

        $application_no = $this->input->POST('application_no');

        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $co_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $this->session->set_userdata($userdata);
        $this->db->insert("misc_case_process_reports", $userdata); //...................
        $updateSqlBasic = "update  misc_case_basic set  date_of_operation='$note_date',  "
                . " status='$status' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        //$this->db->query($updateSqlBasic);//..........................




        redirect(base_url() . "index.php/NameCorrection/OrderBasic");
    }

    public function OrderBasic() {
        // $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $misc_case_no = $this->session->userdata('misc_case_no');
        $petition_no = $this->session->userdata('misc_case_petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        //find the pdar_id
        $pdardata = $this->NameCorrectionModel->getPdarIDMisc($misc_case_no, $petition_no);
        $pdar_id = $pdardata->petition_pdar_id;
        $pdar_name = $pdardata->petition_pdar_name_old;
        //$dag_no=$this->input->post('dag_no');
        $dag_no = $this->NameCorrectionModel->getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);

        if(empty($dag_no))
        {
            $this->session->set_flashdata('message', "Kindly check the Chitha report . The applied dagno or pattadars might not exit in the given patta!");
            redirect(base_url() . "index.php/home");
        }
        
        foreach ($dag_no as $a) {
            $dagnumber = $a->dag_no;
            $userata[] = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dagnumber,
                'year_no' => $year_no,
                'petition_no' => $misc_case_petition_no,
                'case_no' => $misc_case_no,
                'patta_no' => trim($patta_no),
                'patta_type_code' => $patta_type_code,
                'pdar_id' => $pdar_id
            );
            $userdatas['s'] = $userata;
        }

        $this->session->set_userdata($userdatas);

        $data['orderNo'] = $this->NameCorrectionModel->getOrderNo();
        $data['landtype'] = $this->APCancellationModel->getLandType();

        $get_lm = $this->db->query("Select user_code as lm_code from    misc_case_process_reports where "
                        . "misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' and operation='l'")->row()->lm_code;
        $data['LMList_selected'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $get_lm);

        $get_sk = $this->db->query("Select user_code as sk_code from    misc_case_process_reports where "
                        . "misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' and operation='s'")->row()->sk_code;
        $data['SKList'] = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $get_sk);

        $co_user_code = $this->session->userdata('user_code');
        $data['COList'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $co_user_code);

        $data['LmSignDate'] = $this->NameCorrectionModel->getLMSignDate($misc_case_no);
        $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
        $data['COSignDate'] = $this->NameCorrectionModel->getCOSignDate($misc_case_no);
        //var_dump($data);
        //$data['lmcodate'] = $this->APCancellationModel->getLMCODate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);
        //var_dump($data);

        // $this->load->view('../views/NameCorrection/OrderBasic', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCorrection/OrderBasic';
        $this->load->view('layouts/main',$data);
    }

    public function OrderBasic_save() {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $ord_no = $this->input->post('ord_no');
        $ord_date1 = $this->input->post('ord_date');
        $ord_date = date("Y-m-d", strtotime($ord_date1));
        $misc_case_petition_no = $this->input->post('misc_case_petition_no');
        $ord_type_code = $this->input->post('ord_type_code');
        $ord_passby_sign_yn = $this->input->post('ord_passby_sign_yn');
        $case_no=$this->input->post('case_no');
        $ord_on_gl_type = $this->input->post('ord_on_gl_type');
        $ord_passby_desig = $this->input->post('ord_passby_desig');
        $ord_ref_let_no = $this->input->post('ord_ref_let_no');
        $lm_code = $this->input->post('lm_code');
        $lm_sign = $this->input->post('lm_sign');
        $lm_sign_date1 = $this->input->post('lm_sign_date');

        $lm_sign_date = date("Y-m-d", strtotime($lm_sign_date1));


        $sk_code = $this->input->post('sk_code');
        $sk_sign = $this->input->post('sk_sign');
        $sk_sign_date1 = $this->input->post('sk_sign_date');

        $sk_sign_date = date("Y-m-d", strtotime($sk_sign_date1));

        $co_code = $this->input->post('co_code');
        $co_sign = $this->input->post('co_sign');
        $co_sign_date1 = $this->input->post('co_sign_date');

        $co_sign_date = date("Y-m-d", strtotime($co_sign_date1));

        $wrt1 = $this->input->post('wrt1');
        $wrt2 = $this->input->post('wrt2');
        $wrt3 = $this->input->post('wrt3');
        $wrt4 = $this->input->post('wrt4');
        $wrt5 = $this->input->post('wrt5');

        $da = $this->session->userdata('s');
        //var_dump($da);
        $this->db->trans_begin();
        
        foreach ($da as $d) {
        $append = "dist_code = '".$d['dist_code']."' and subdiv_code = '".$d['subdiv_code']."' and cir_code = '".$d['cir_code']."' 
        and mouza_pargona_code = '".$d['mouza_pargona_code']."' and lot_no = '".$d['lot_no']."' and vill_townprt_code = '".$d['vill_townprt_code']."'";
         }
        
        
        $sql="Select * from t_chitha_rmk_ordbasic where  ord_no='$ord_no' and $append";
        $result=$this->db->query($sql)->num_rows();
        if($result>0)
        {
            $del="delete from t_chitha_rmk_ordbasic where  ord_no='$ord_no' and $append";
            
            $res=$this->db->query($del);
        
            
            if($res!=1 or $this->db->affected_rows()<=0)
            {
            $this->db->trans_rollback(); 
            $this->session->set_flashdata('message', "ERRNCOR:001:Case could not be passed");
            log_message('error','Case could not be deleted case_no '.$ord_no);
            redirect(base_url() . 'index.php/home');
            }
            
        }

        
        foreach ($da as $d) {
            //echo $d['dag_no'];
            $dist_code = $d['dist_code'];
            $subdiv_code = $d['subdiv_code'];
            $cir_code = $d['cir_code'];
            $mouza_pargona_code = $d['mouza_pargona_code'];
            $lot_no = $d['lot_no'];
            $vill_code = $d['vill_townprt_code'];
            $dag_no = $d['dag_no'];
            $year_no = $d['year_no'];
            //$petition_no = $d['petition_no'];
            //$case_no = $d['case_no'];
            $case_no = $case_no;
            $petition_no = $misc_case_petition_no;

            $userata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'ord_no' => $ord_no,
                'ord_date' => $ord_date,
                'ord_type_code' => $ord_type_code,
                'case_no' => $case_no,
                //            'ord_on_gl_type'=>$ord_on_gl_type,
                'ord_passby_sign_yn' => $ord_passby_sign_yn,
                'ord_passby_desig' => $ord_passby_desig,
                'ord_ref_let_no' => $ord_ref_let_no,
                'lm_code' => $lm_code,
                'lm_sign_yn' => $lm_sign,
                'lm_sign_date' => $lm_sign_date,
                'sk_code' => $sk_code,
                'sk_sign_yn' => $sk_sign,
                'sk_sign_date' => $sk_sign_date,
                'co_code' => $co_code,
                'co_sign_yn' => $co_sign,
                'co_ord_date' => $co_sign_date,
                'wrt_order1' => $wrt1,
                'wrt_order2' => $wrt2,
                'wrt_order3' => $wrt3,
                'wrt_order4' => $wrt4,
                'wrt_order5' => $wrt5
            );
            //var_dump($userata);
            $alldata[] = $userata;
            $userdatas['s'] = $alldata;
            
            $tstatus1=$this->db->insert("t_chitha_rmk_ordbasic", $userata); //...............
            
            if($tstatus1!=1)
            {
            $this->db->trans_rollback(); 
            $this->session->set_flashdata('message', "ERRNCOR:002:Case could not be passed");
            log_message('error','Case could not be inserted case_no '.$ord_no);
            redirect(base_url() . 'index.php/home');
            }
            
        }
        $this->db->trans_commit();
        $this->session->set_userdata($userdatas);  //............
        redirect(base_url() . "index.php/NameCorrection/InFavorOf"); //..................
    }

    public function InFavorOf() {
        //var_dump($this->session->all_userdata());

        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $misc_case_no = $this->session->userdata('misc_case_no');
        $misc_case_petition_no = $this->session->userdata('misc_case_petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$misc_case_petition_no);
        //var_dump($data);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;

        $data['info'] = $this->NameCorrectionModel->getPdarIDMisc($misc_case_no,$misc_case_petition_no);
        $pdar_id = $data['info']->petition_pdar_id;
        $pdar_name = $data['info']->petition_pdar_name_old;
        $infavor_of_corrected_name = $data['info']->petition_pdar_name_new;

        $data['pdarinfo'] = $this->NameCorrectionModel->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);

        $data['inFavID'] = $this->NameCorrectionModel->getMiscID($misc_case_no);
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no' => $this->session->userdata('dag_no'),
            'year_no' => $year_no,
            'petition_no' => $misc_case_petition_no,
            'infavor_of_id' => 'infavid', //
            'ord_no' => $this->session->userdata('ord_no'),
            'ord_date' => $this->session->userdata('ord_date'),
            'patta_type_code' => $patta_type_code,
            'patta_no' => trim($patta_no),
            'pdar_id' => $pdar_id,
            'infavor_of_name' => $pdar_name,
            'infavor_of_guardian' => $data['pdarinfo']->pdar_father,
            'infav_of_guar_relation' => $data['pdarinfo']->pdar_guard_reln,
            'infavor_of_add1' => $data['pdarinfo']->pdar_add1,
            'infavor_of_add2' => $data['pdarinfo']->pdar_add2,
            'by_right_of' => '06',
            'land_area_b' => 0,
            'land_area_k' => 0,
            'land_area_lc' => 0,
            'land_area_g' => 0,
            'land_area_kr' => 0,
            'infavor_of_corrected_name' => $infavor_of_corrected_name
        );
        //var_dump($data);
        $data['landType'] = $this->APCancellationModel->getPattaName($patta_type_code);

        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        // $this->load->view('../views/NameCorrection/InFavorOf', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCorrection/InFavorOf';
        $this->load->view('layouts/main',$data);
    }

    public function InFavorOf_save() {
        $this->db->trans_begin();
        $misc_case_no = $this->session->userdata('misc_case_no');
        $misc_case_petition_no = $this->session->userdata('misc_case_petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$misc_case_petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;

        $data['info'] = $this->NameCorrectionModel->getPdarIDMisc($misc_case_no,$misc_case_petition_no);
        $pdar_id = $data['info']->petition_pdar_id;
//        $pdar_name=$data['info']->petition_pdar_name_old;
//        $infavor_of_corrected_name=$data['info']->petition_pdar_name_new;
        $data['pdarinfo'] = $this->NameCorrectionModel->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
        $data['inFavID'] = $this->NameCorrectionModel->getMiscID($misc_case_no);


        $application_no=$this->input->post('application_no');

        $da = $this->session->userdata('s');
        foreach ($da as $d) {
            $dag_no = $d['dag_no'];
            $userata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $misc_case_petition_no,
                'infavor_of_id' => $this->input->post('infavor_of_id'),
                'ord_no' => $d['ord_no'],
                'ord_date' => $d['ord_date'],
                'patta_type_code' => $patta_type_code,
                'patta_no' => trim($patta_no),
                'pdar_id' => $pdar_id,
                'infavor_of_name' => $this->input->post('infavor_of_name'),
                'infavor_of_guardian' => $this->input->post('infavor_of_guardian'),
                'infav_of_guar_relation' => $this->input->post('infav_of_guar_relation'),
                'infavor_of_add1' => $this->input->post('infavor_of_add1'),
                'infavor_of_add2' => $this->input->post('infavor_of_add2'),
                'by_right_of' => '06',
                'land_area_b' => 0,
                'land_area_k' => 0,
                'land_area_lc' => 0,
                'land_area_g' => 0,
                'land_area_kr' => 0,
                'revenue' => 0,
                'infavor_of_corrected_name' => $this->input->post('infavor_of_corrected_name')
            );
            $today = date('Y-m-d');
            $user_code = $this->session->userdata('user_code');
            $this->db->insert("t_chitha_rmk_infavor_of", $userata);
        }
        $updateSql = "update  misc_case_first_party set user_code='$user_code', operation='E' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$misc_case_petition_no'";
        //echo $updateSql;
        $this->db->query($updateSql);
        // status 10 is for final chitha update
        $updateSql1 = "update  misc_case_basic set status='10', user_code='$user_code', date_of_operation='$today' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$misc_case_petition_no'";
        //echo $updateSql1;
        $this->db->query($updateSql1);

        //$updateSql2="update misc_case_process_reports set user_code='$user_code' where misc_case_no='$misc_case_no'";
        //$this->db->query($updateSql2);
        $true=$this->updateChitha($misc_case_no,$misc_case_petition_no);
        if($true){
         $this->db->trans_commit();

         ////////////////////
         $this->DashboardDataFinal($misc_case_no);
          //.............
          if($application_no)
          {
             $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
             $curl_handle = curl_init();
             curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
             curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
             curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
              'application' => $application_no,
              'dharitree' => $misc_case_no,
              'rmk' => 'approved by CO',
              'status' => 'F',
              'task' => 'CO',
              'pen'=>'Approved',
              'penat'=>'Circle office'
           )));
             $result = curl_exec($curl_handle);
          }
          redirect(base_url() . "index.php/NameCorrection/NameCorrection_finish");
      }
      else
      {         
         $this->db->trans_rollback(); 
         $this->session->set_flashdata('message', "Case could not be passed");
         redirect(base_url() . 'index.php/home');     
      } 
    }

    public function NameCorrection_finish() {


        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/NameCorrection/NameCorrection_finish');
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCorrection/NameCorrection_finish';
        $this->load->view('layouts/main',$data);
    }

    public function revertToLm_old(){
        if(isset($_POST['application_no']) && $_POST['application_no']!=''){
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0014
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0014');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0014');
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validAppNo = applicationNumberValidation($_POST['application_no']);
            if(!empty($validAppNo)) {
                //ERRNMECORRCORVRT0001
                log_message('error', 'Application no. cant have special characters. Error: ERRNMECORRCORVRT0001');
                $this->session->set_flashdata("message", "Application no. cant have special characters. Error: ERRNMECORRCORVRT0001");
                redirect(base_url('index.php/home'));
            }
            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0002
                log_message('error', 'Required Case no is empty. Error: ERRNMECORRCORVRT0002');
                $this->session->set_flashdata("message", "Required Case no is empty. Error: ERRNMECORRCORVRT0002");
                redirect(base_url('index.php/home'));
            }
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0003
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0003');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0003");
                redirect(base_url('index.php/home'));
            }
    
            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_revert_report']) || $_POST['co_revert_report']=='') {
                //ERRNMECORRCORVRT0004
                log_message('error', 'CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004');
                $this->session->set_flashdata("message", "CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
    
            $validreport = specialCharacterCheckingInInput($_POST['co_revert_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0005
                log_message('error', 'CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005');
                $this->session->set_flashdata("message", "CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'CO', $_POST['misc_case_no'],'NMECORRCORVT');
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0006
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0006');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0006");
                redirect(base_url('index.php/home'));
                exit;
            }
            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0006
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0006');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0006");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code'] || $sessionData['user_desig_code']!='CO'){
            //     //ERRNMECORRCORVRT0007
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0007');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0007");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }
            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $application_no=$this->input->post('application_no');
            $case_no = $this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no = $petitionNo->misc_case_petition_no;
    
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_revert_report');

            $this->db->trans_begin();

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no

            );
            $this->db->insert("misc_case_process_reports", $userdata);

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$note);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#MISCLMR001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MISCLMR001)".$case_no);
                redirect(base_url() . "index.php/home");
            }
            
            $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");

            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no,
                'rmk' => 'forwared to LM',
                'status' => 'M',
                'task' => 'CO',
                'pen'=>'LM',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","LM Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");
            }
        }
        else{
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0015
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0015');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0015');
                redirect(base_url('index.php/home'));
            }
            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0008
                log_message('error', 'Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008');
                $this->session->set_flashdata("message", "Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008");
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0009
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0009');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0009");
                redirect(base_url('index.php/home'));
            }

            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_report1']) || $_POST['co_report1']=='') {
                //ERRNMECORRCORVRT0010
                log_message('error', 'CO Report is a required field. Error: ERRNMECORRCORVRT0010');
                $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECORRCORVRT0010");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            $validreport = specialCharacterCheckingInInput($_POST['co_report1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0011
                log_message('error', 'CO Report has illegal characters. Error: ERRNMECORRCORVRT0011');
                $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECORRCORVRT0011");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'CO', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0012
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0012');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0012");
                redirect(base_url('index.php/home'));
            }

            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0012
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0012');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0012");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code']){
            //     //ERRNMECORRCORVRT0013
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0013');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0013");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }

            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $case_no=$this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no=$petitionNo->misc_case_petition_no;
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_report1');

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no
            );
            $this->db->insert("misc_case_process_reports", $userdata);
            $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");
            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
       }

        $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
        redirect(base_url() . "index.php/home");
    }
    // public function revertToLm(){
    //     if(isset($_POST['application_no']) && $_POST['application_no']!=''){
    //         //syntax validation
    //         $validAppNo = applicationNumberValidation($_POST['application_no']);
    //         if(!empty($validAppNo)) {
    //             //ERRNMECORRCORVRT0001
    //             $this->session->set_flashdata("message", "Application no. cant have special characters. Error: ERRNMECORRCORVRT0001");
    //             redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
    //         }
    //         if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
    //             //ERRNMECORRCORVRT0002
    //             $this->session->set_flashdata("message", "Required Case no is empty. Error: ERRNMECORRCORVRT0002");
    //             redirect(base_url('index.php/home'));
    //         }
    //         $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
    //         if(!empty($validCaseNo)) {
    //             //ERRNMECORRCORVRT0003
    //             $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0003");
    //             redirect(base_url('index.php/home'));
    //         }

    //         if(!isset($_POST['co_report']) || $_POST['co_report']=='') {
    //             //ERRNMECORRCORVRT0004
    //             $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECORRCORVRT0004");
    //             redirect(base_url('index.php/home'));
    //         }

    //         $validreport = specialCharacterCheckingInInput($_POST['co_report'], ['.']);
    //         if($validreport['status']=='n') {
    //             //ERRNMECORRCORVRT0005
    //             $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECORRCORVRT0005");
    //             redirect(base_url('index.php/home'));
    //         }
    //         //authentication
    //         $sessionData = $this->session->all_userdata();
    //         if(empty($sessionData)) {
    //             //ERRNMECORRCORVRT0006
    //             $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0006");
    //             redirect(base_url('index.php/home'));
    //         }
    //         //authorization
    //         $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
    //         $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
    //         if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code'] || $sessionData['user_desig_code']!='CO'){
    //             //ERRNMECORRCORVRT0007
    //             $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0007");
    //             redirect(base_url('index.php/home'));
    //         }

    //         $application_no=$this->input->post('application_no');
    //         $case_no = $this->input->post('misc_case_no');

    //         $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;

    //         $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
    //         $note_date = date('Y-m-d');
    //         $dist_code = $data['miscCaseInfo']->dist_code;
    //         $subdiv_code = $data['miscCaseInfo']->subdiv_code;
    //         $cir_code = $data['miscCaseInfo']->cir_code;
    //         $user_code = $this->session->userdata('user_code');
    //         $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
    //         $result = $this->db->query($sql, array($case_no, $petition_no));
    //         $note_no = ($result->row()->note_no) + 1;
    //         $operation = 'c';
    //         $co_fresh_proceeding = 'N';
    //         $note=$this->input->post('co_report');

    //         $this->db->trans_begin();

    //         $userdata = array(
    //             'dist_code' => $dist_code,
    //             'subdiv_code' => $subdiv_code,
    //             'cir_code' => $cir_code,
    //             'note_no' => $note_no,
    //             'misc_case_no' => $case_no,
    //             'co_fresh_proceeding' => $co_fresh_proceeding,
    //             'process_note' => $note,
    //             'note_date' => $note_date,
    //             'user_code' => $user_code,
    //             'operation' => $operation,
    //             'misc_case_petition_no' => $petition_no

    //         );
    //         $this->db->insert("misc_case_process_reports", $userdata);

    //         $proInsert = $this->mutationmodel->proceeding_order($case_no,$note);


    //        if($proInsert==false || $proInsert===false)
    //         {
    //             log_message('error', "#MISCLMR001:".$this->db->last_query());
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "Updation failed(#MISCLMR001)".$case_no);
    //             redirect(base_url() . "index.php/home");
    //         }
            
    //         $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");

    //         $penUser='LM';
    //         $rmrk='Revert to LM by CO';
    //         $this->DashboardData($case_no,$penUser,$rmrk);
    //         $rtps=$this->rtpsmodel->checkRtpsService($application_no);
    //         if($rtps=='RTPS'){
    //             $apilink=RTPS_API_LINK;
    //         }else{
    //             $apilink=API_LINK;
    //         }
    //         $curl_handle = curl_init();
    //         curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
    //         curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //         curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //             'application' => $application_no,
    //             'dharitree' => $case_no,
    //             'rmk' => 'forwared to LM',
    //             'status' => 'M',
    //             'task' => 'CO',
    //             'pen'=>'LM',
    //             'penat'=>'Circle office'
    //         )));
    //         $result = curl_exec($curl_handle);

    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata("message", "Something went wrong");
    //             redirect(base_url() . "index.php/home");
    //         }else{
    //             $this->db->trans_commit();
    //              $this->session->set_flashdata("message","LM Report Submitted Successfully...");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }
    //     else{
    //         if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
    //             //ERRNMECORRCORVRT0008
    //             $this->session->set_flashdata("message", "Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008");
    //             redirect(base_url('index.php/home'));
    //         }
    //         //syntax validation
    //         $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
    //         if(!empty($validCaseNo)) {
    //             //ERRNMECORRCORVRT0009
    //             $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0009");
    //             redirect(base_url('index.php/home'));
    //         }

    //         if(!isset($_POST['co_report1']) || $_POST['co_report1']=='') {
    //             //ERRNMECORRCORVRT0010
    //             $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECORRCORVRT0010");
    //             redirect(base_url('index.php/home'));
    //         }

    //         $validreport = specialCharacterCheckingInInput($_POST['co_report1'], ['.']);
    //         if($validreport['status']=='n') {
    //             //ERRNMECORRCORVRT0011
    //             $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECORRCORVRT0011");
    //             redirect(base_url('index.php/home'));
    //         }
    //         //authentication
    //         $sessionData = $this->session->all_userdata();
    //         if(empty($sessionData)) {
    //             //ERRNMECORRCORVRT0012
    //             $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0012");
    //             redirect(base_url('index.php/home'));
    //         }
    //         //authorization
    //         $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
    //         $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
    //         if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code']){
    //             //ERRNMECORRCORVRT0013
    //             $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0013");
    //             redirect(base_url('index.php/home'));
    //         }

    //         $case_no=$this->input->post('misc_case_no');
    //         $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
    //         $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
    //         $note_date = date('Y-m-d');
    //         $dist_code = $data['miscCaseInfo']->dist_code;
    //         $subdiv_code = $data['miscCaseInfo']->subdiv_code;
    //         $cir_code = $data['miscCaseInfo']->cir_code;
    //         $user_code = $this->session->userdata('user_code');
    //         $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
    //         $result = $this->db->query($sql, array($case_no, $petition_no));
    //         $note_no = ($result->row()->note_no) + 1;
    //         $operation = 'c';
    //         $co_fresh_proceeding = 'N';
    //         $note=$this->input->post('co_report1');

    //         $userdata = array(
    //             'dist_code' => $dist_code,
    //             'subdiv_code' => $subdiv_code,
    //             'cir_code' => $cir_code,
    //             'note_no' => $note_no,
    //             'misc_case_no' => $case_no,
    //             'co_fresh_proceeding' => $co_fresh_proceeding,
    //             'process_note' => $note,
    //             'note_date' => $note_date,
    //             'user_code' => $user_code,
    //             'operation' => $operation,
    //             'misc_case_petition_no' => $petition_no
    //         );
    //         $this->db->insert("misc_case_process_reports", $userdata);
    //         $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");
    //         $penUser='LM';
    //         $rmrk='Revert to LM by CO';
    //         $this->DashboardData($case_no,$penUser,$rmrk);
    //    }

    //     $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
    //     redirect(base_url() . "index.php/home");
    // }

  //    public function updateChitha($case_no,$misc_case_petition_no) {
  //       //$db=  $this->session->userdata('db');
  //       //echo $case_no;
  //      $q = "select * from misc_case_basic mcb, t_chitha_rmk_infavor_of  c8 where " .
  //      "mcb.dist_code = c8.dist_code and mcb.subdiv_code = c8.subdiv_code and mcb.cir_code= c8.cir_code and " .
  //      "mcb.lot_no = c8.lot_no and mcb.mouza_pargona_code = c8.mouza_pargona_code and mcb.vill_townprt_code = " .
  //      "c8.vill_townprt_code and mcb.misc_case_no=c8.ord_no and TRIM(mcb.patta_no) = TRIM(c8.patta_no) and iscorrected_inco is null and c8.ord_no='$case_no' and c8.petition_no = '$misc_case_petition_no'";

  //      $data = $this->db->query($q)->result();

  //      $ord_cron_no = 1;
  //      foreach ($data as $d) {
  //        $dist_code = $d->dist_code;
  //        $subdiv_code = $d->subdiv_code;
  //        $cir_code = $d->cir_code;
  //        $lot_no = $d->lot_no;
  //        $mouza_pargona_code = $d->mouza_pargona_code;
  //        $vill_townprt_code = $d->vill_townprt_code;
  //        $dag_no = $d->dag_no;
  //        $q = "select max(rmk_type_hist_no)+1 as c2 from chitha_rmk_gen where"
  //        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
  //        . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and  dag_no='$dag_no' ";
  //        $rmk_type_hist_no = $this->db->query($q)->row()->c2;
  //        $rmk_type_hist_no . "<br>";

  //        if ($rmk_type_hist_no == null) {
  //          $rmk_type_hist_no = 1;
  //       }
  //           //echo $d->pdar_id;
  //           //echo $d->infavor_of_corrected_name;
  //           //////////////////
  //           //$this->db->query($query);
  //       $chitha_rmk_gen = array(
  //          'dist_code' => $dist_code,
  //          'subdiv_code' => $subdiv_code,
  //          'cir_code' => $cir_code,
  //          'lot_no' => $lot_no,
  //          'mouza_pargona_code' => $mouza_pargona_code,
  //          'vill_townprt_code' => $vill_townprt_code,
  //          'rmk_type_hist_no' => $rmk_type_hist_no,
  //          'dag_no' => $dag_no,
  //          'rmk_type_code' => '01',
  //          'rmk_type_hist_no' => $rmk_type_hist_no,
  //          'user_code' => $this->session->userdata('user_code'),
  //          'date_entry' => date('Y-m-d'),
  //          'operation' => 'E',
  //       );
  //       $status1 = $this->db->insert("chitha_rmk_gen", $chitha_rmk_gen);
  //       if ($status1 != 1)
  //       {
  //           return false;         
  //       }
  //       ////////////////
  //       $chitha_rmk_ordbasic = array(
  //          'dist_code' => $dist_code,
  //          'subdiv_code' => $subdiv_code,
  //          'cir_code' => $cir_code,
  //          'lot_no' => $lot_no,
  //          'mouza_pargona_code' => $mouza_pargona_code,
  //          'vill_townprt_code' => $vill_townprt_code,
  //          'rmk_type_hist_no' => $rmk_type_hist_no,
  //          'dag_no' => $dag_no,
  //          'ord_no' => $case_no,
  //          'ord_date' => date('Y-m-d'),
  //          'ord_type_code' => '06',
  //          'ord_cron_no' => $ord_cron_no,
  //          'ord_passby_sign_yn' => 'Y',
  //          'ord_passby_desig' => 'CO',
  //          'co_sign_yn' => 'Y',
  //          'user_code' => $this->session->userdata('user_code'),
  //          'date_entry' => date('Y-m-d'),
  //          'operation' => 'E',
  //          'm_dag_area_b' => 0.0,
  //          'm_dag_area_k' => 0.0,
  //          'm_dag_area_lc' => 0.0,
  //          'm_dag_area_g' => 0.0,
  //          'm_dag_area_kr' => 0.0,
  //          'area_left_b' => 0.0,
  //          'area_left_k ' => 0.0,
  //          'area_left_lc' => 0.0,
  //          'area_left_g' => 0.0,
  //          'area_left_kr' => 0.0,
  //       );
  //       $date=date('Y-m-d');
  //       $status2 = $this->db->insert("chitha_rmk_ordbasic", $chitha_rmk_ordbasic);
  //       if ($status2 != 1)
  //       {
  //           return false;         
  //       }
  //       $query = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$date' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
  //       " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and ord_no='$case_no' and petition_no = '$misc_case_petition_no' and dag_no='$dag_no' ";
  //       $status3 = $this->db->query($query);
  //       if ($status3 != 1)
  //       {
  //           return false;         
  //       }
  //           /////////////////////

  //       $query = "select * from  t_chitha_rmk_infavor_of where ord_no='$d->ord_no' and dag_no='$dag_no' ";
  //       $infve = $this->db->query($query)->result();
  //       foreach ($infve as $infv) {
  //          unset($infv->year_no);
  //          unset($infv->petition_no);
  //          unset($infv->pdar_id);
  //          unset($infv->revenue);
  //          unset($infv->iscorrected_inco);
  //          unset($infv->iscorrected_inco_date);
  //          unset($infv->iscorrected_rkg_record);
  //          unset($infv->iscorrected_rkg_date);
  //          unset($infv->infavor_is_copdar);
  //          unset($infv->make_mdb);
  //          unset($infv->new_pattadar);
  //          unset($infv->iscorrected_inco_date);
  //          $infv->rmk_type_hist_no = $rmk_type_hist_no;
  //          $infv->ord_cron_no = $ord_cron_no++;
  //          $infv->user_code = $this->session->userdata('user_code');
  //          $infv->date_entry = date('Y-m-d');
  //          $infv->operation = 'E';
  //          $status4 = $this->db->insert("chitha_rmk_infavor_of", $infv);
  //          if ($status4 != 1)
  //          {
  //             return false;         
  //          }
  //          $query = "update  t_chitha_rmk_infavor_of set iscorrected_inco='Y' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
  //          " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and ord_no='$case_no' and petition_no = '$misc_case_petition_no' and dag_no='$dag_no' ";
  //          $status5 = $this->db->query($query);  
  //          if ($status5 != 1)
  //          {
  //             return false;         
  //          }
  //       }
  //       $query = "update  chitha_pattadar set pdar_name='$d->infavor_of_corrected_name',jama_yn='n' where TRIM(patta_no)=trim('$d->patta_no') and " .
  //       "  pdar_id=$d->pdar_id and dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
  //       " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code'";
  //       $status_final = $this->db->query($query); 
  //       if ($status_final != 1)
  //       {
  //          return false;         
  //       }
  //    }
  //    return true;
  // }


     public function updateChitha($case_no,$misc_case_petition_no) {
        //$db=  $this->session->userdata('db');
        //echo $case_no;
       $q = "select * from misc_case_basic mcb, t_chitha_rmk_infavor_of  c8 where " .
       "mcb.dist_code = c8.dist_code and mcb.subdiv_code = c8.subdiv_code and mcb.cir_code= c8.cir_code and " .
       "mcb.lot_no = c8.lot_no and mcb.mouza_pargona_code = c8.mouza_pargona_code and mcb.vill_townprt_code = " .
       "c8.vill_townprt_code and mcb.misc_case_no=c8.ord_no and TRIM(mcb.patta_no) = TRIM(c8.patta_no) and iscorrected_inco is null and c8.ord_no='$case_no' and c8.petition_no = '$misc_case_petition_no'";

       $data = $this->db->query($q)->result();

       $ord_cron_no = 1;
       foreach ($data as $d) {
         $dist_code = $d->dist_code;
         $subdiv_code = $d->subdiv_code;
         $cir_code = $d->cir_code;
         $lot_no = $d->lot_no;
         $mouza_pargona_code = $d->mouza_pargona_code;
         $vill_townprt_code = $d->vill_townprt_code;
         $dag_no = $d->dag_no;
         $q = "select max(rmk_type_hist_no)+1 as c2 from chitha_rmk_gen where"
         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
         . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and  dag_no='$dag_no' ";
         $rmk_type_hist_no = $this->db->query($q)->row()->c2;
         $rmk_type_hist_no . "<br>";

         if ($rmk_type_hist_no == null) {
           $rmk_type_hist_no = 1;
        }
            //echo $d->pdar_id;
            //echo $d->infavor_of_corrected_name;
            //////////////////
            //$this->db->query($query);
        $chitha_rmk_gen = array(
           'dist_code' => $dist_code,
           'subdiv_code' => $subdiv_code,
           'cir_code' => $cir_code,
           'lot_no' => $lot_no,
           'mouza_pargona_code' => $mouza_pargona_code,
           'vill_townprt_code' => $vill_townprt_code,
           'rmk_type_hist_no' => $rmk_type_hist_no,
           'dag_no' => $dag_no,
           'rmk_type_code' => '01',
           'rmk_type_hist_no' => $rmk_type_hist_no,
           'user_code' => $this->session->userdata('user_code'),
           'date_entry' => date('Y-m-d'),
           'operation' => 'E',
        );
       $status1 = $this->db->insert("chitha_rmk_gen", $chitha_rmk_gen);
        if ($status1 != 1)
        {
            log_message('error','Unable to insert in chitha_rmk_gen');
            echo $this->db->last_query();
            return false;   
        }
        

        ////////////////
        $chitha_rmk_ordbasic = array(
           'dist_code' => $dist_code,
           'subdiv_code' => $subdiv_code,
           'cir_code' => $cir_code,
           'lot_no' => $lot_no,
           'mouza_pargona_code' => $mouza_pargona_code,
           'vill_townprt_code' => $vill_townprt_code,
           'rmk_type_hist_no' => $rmk_type_hist_no,
           'dag_no' => $dag_no,
           'ord_no' => $case_no,
           'ord_date' => date('Y-m-d'),
           'ord_type_code' => '06',
           'ord_cron_no' => $ord_cron_no,
           'ord_passby_sign_yn' => 'Y',
           'ord_passby_desig' => 'CO',
           'co_sign_yn' => 'Y',
           'user_code' => $this->session->userdata('user_code'),
           'date_entry' => date('Y-m-d'),
           'operation' => 'E',
           'm_dag_area_b' => 0.0,
           'm_dag_area_k' => 0.0,
           'm_dag_area_lc' => 0.0,
           'm_dag_area_g' => 0.0,
           'm_dag_area_kr' => 0.0,
           'area_left_b' => 0.0,
           'area_left_k ' => 0.0,
           'area_left_lc' => 0.0,
           'area_left_g' => 0.0,
           'area_left_kr' => 0.0,
        );
        $date=date('Y-m-d');
        $status2 = $this->db->insert("chitha_rmk_ordbasic", $chitha_rmk_ordbasic);
        if ($status2 != 1)
        {
            log_message('error','Unable to insert in chitha_rmk_ordbasic');
            echo $this->db->last_query();
            return false;         
        }
        
        $query = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$date' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
        " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and ord_no='$case_no' and petition_no = '$misc_case_petition_no' and dag_no='$dag_no' ";
        $status3 = $this->db->query($query);
        if ($this->db->affected_rows()<=0)
        {
            log_message('error','Unable to insert in t_chitha_rmk_ordbasic');
            echo $this->db->last_query();
            return false;         
        }
        
            /////////////////////

        $query = "select * from  t_chitha_rmk_infavor_of where ord_no='$d->ord_no' and dag_no='$dag_no' ";
        $infve = $this->db->query($query)->result();
        foreach ($infve as $infv) {
           unset($infv->year_no);
           unset($infv->petition_no);
           unset($infv->pdar_id);
           unset($infv->revenue);
           unset($infv->iscorrected_inco);
           unset($infv->iscorrected_inco_date);
           unset($infv->iscorrected_rkg_record);
           unset($infv->iscorrected_rkg_date);
           unset($infv->infavor_is_copdar);
           unset($infv->make_mdb);
           unset($infv->new_pattadar);
           unset($infv->iscorrected_inco_date);
           $infv->rmk_type_hist_no = $rmk_type_hist_no;
           $infv->ord_cron_no = $ord_cron_no++;
           $infv->user_code = $this->session->userdata('user_code');
           $infv->date_entry = date('Y-m-d');
           $infv->operation = 'E';
           $status4 = $this->db->insert("chitha_rmk_infavor_of", $infv);
           if ($status4 != 1)
           {
            log_message('error','Unable to insert in t_chitha_rmk_infavor_of');
            echo $this->db->last_query();
            return false;         
           }
           
        
           $query = "update  t_chitha_rmk_infavor_of set iscorrected_inco='Y' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
           " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and ord_no='$case_no' and petition_no = '$misc_case_petition_no' and dag_no='$dag_no' ";
           $status5 = $this->db->query($query);  
           if ($this->db->affected_rows()<=0)
           {
            log_message('error','Unable to update in t_chitha_rmk_infavor_of');
            echo $this->db->last_query();
            return false;         
           }
        }
        // $query = "update  chitha_pattadar set pdar_name=?,jama_yn='n' where TRIM(patta_no)=trim(?) and " .
        // "  pdar_id=? and dist_code=? and subdiv_code=? and cir_code=? " .
        // " and lot_no=? and  mouza_pargona_code=? and vill_townprt_code=?";       
        // //$status_final = $this->db->query($query); 
        // $status_final = $this->db->query($query,array($d->infavor_of_corrected_name,$d->patta_no,$d->pdar_id,
        //     $d->dist_code,$d->subdiv_code,$d->cir_code,$d->lot_no,$d->mouza_pargona_code,$d->vill_townprt_code)); 
        $table = 'chitha_pattadar';

        $params = [
            'pdar_name' => $d->infavor_of_corrected_name,
            'jama_yn'   => 'n',
        ];

        $where = [
            'dist_code'          => $d->dist_code,
            'subdiv_code'        => $d->subdiv_code,
            'cir_code'           => $d->cir_code,
            'lot_no'             => $d->lot_no,
            'mouza_pargona_code' => $d->mouza_pargona_code,
            'vill_townprt_code'  => $d->vill_townprt_code,
            'patta_no'           => trim($d->patta_no),
            'pdar_id'            => $d->pdar_id,
        ];

        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

        if ($result <=0)
        {
            log_message('error','Unable to update in chitha_pattadar');
            echo $this->db->last_query();
           return false;         
        }
     }
     return true;
  }

    public function ViewSKReport() {
        // $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);

        $data['sk_report'] = $this->NameCorrectionModel->getSKReport($misc_case_no,$petition_no);
        //var_dump($data['sk_report']);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        // $this->load->view('../views/NameCorrection/ViewSKReport', $data);
        // $this->load->view('../views/footer');

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
         $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['_view'] = 'NameCorrection/ViewSKReport';
        $this->load->view('layouts/main',$data);
    }

    public function getDags($p, $patta_no) {
        //$db=  $this->session->userdata('db');
        $this->load->model('chitha/ChithaModel');

        $dist_code = $this->session->userdata('chitha_dist_code');
        $subdiv_code = $this->session->userdata('chitha_subdiv_code');
        $circle_code = $this->session->userdata('chitha_cir_code');
        $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
        $lot_no = $this->session->userdata('chitha_lot_no');
        $vill_code = $this->session->userdata('chitha_vill_code');

        $daginfo = $this->ChithaModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p);
        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    ///////////////////////////////////
        function Dashboard($case_no){
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
                  'date_of_insert'=>date("Y-m-d h:i:s")
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
            
            $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Registered By Assistant',
            'ip_address'=>$this->utilityclass->get_client_ip()
             );
            $this->dbb->insert('dashboard_action',$action);
            $this->db->insert('dashboard_action',$action);
        }
        function DashboardData($case_no,$penUser,$rmrk){
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
                    $this->db->insert('dashboard_action',$action);

                    $this->db->where('case_no',$case_no);
                    $this->db->update('dashboard_data',$base);
                /////////////////////////////////////
        }
        function DashboardDataFinal($case_no){
            //////////////Update Dashboard Database///////////////////////
                        $this->dbb = $this->load->database('dash', TRUE);
                        $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'F',
                            'remark'=>'Final Order Passed',
                            'date_of_update'=>date("Y-m-d h:i:s")
                        );
                        $this->dbb->where('case_no',$case_no);
                        $this->dbb->update('dashboard_data',$base);

                        $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);
                
                        $action= array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_of_action_taken' => date("Y-m-d h:i:s"),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => 'Final Order Passed',
                            'ip_address'=>$this->utilityclass->get_client_ip()
                             );
                        $this->dbb->insert('dashboard_action',$action);
                        $this->db->insert('dashboard_action',$action);
                /////////////////////////////////////
        }

    public function LMStep2_save() {


        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        if(!isset($_POST['misc_case_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['lm_report']) || $_POST['misc_case_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['lm_report']=='') {
            //ERRNMECORRLM0001
            log_message('error', 'Improper Inputs Error: ERRNMECORRLM0001');
            $this->session->set_flashdata('message', "Improper Inputs Error: ERRNMECORRLM0001");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECORRLM0009
            log_message('error', $validquery['messages'] .'Error: ERRNMECORRLM0009');
            $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRLM0009');
            redirect(base_url('index.php/home'));
        }
        //syntax validation
        // $validAppNo = applicationNumberValidation($_POST['application_no']);
        $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        // if(!empty($validAppNo)) {
        //     //ERRNMECORRLM0002
        //     $this->session->set_flashdata('message', "Application No. cant have special characters. Error: ERRNMECORRLM0002");
        //     redirect(base_url('index.php/NameCorrection/LMStep1'));
        // }
        if(!empty($validCaseNo)) {
            //ERRNMECORRLM0003
            log_message('error', 'Case No. cant have special characters. Error: ERRNMECORRLM0003');
            $this->session->set_flashdata('message', "Case No. cant have special characters. Error: ERRNMECORRLM0003");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        if(!preg_match('/^[0-9]*$/', $_POST['misc_case_petition_no'])) {
            //ERRNMECORRLM0004
            log_message('error', 'Case Petition No. must be numerical. Error: ERRNMECORRLM0004');
            $this->session->set_flashdata('message', "Case Petition No. must be numerical. Error: ERRNMECORRLM0004");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
        $lmrep = preg_replace('/&[a-z]{3,5};/i', '', preg_replace('/\s+/', ' ', strip_tags($_POST['lm_report'], ['script'])));
        $validreport = specialCharacterCheckingInInput($lmrep, ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        // $validreport = specialCharacterCheckingInInput($_POST['lm_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validreport['status']=='n') {
            if($caseInfo->misc_case_type=='07') {
                //ERRNMECANCLM0005
                log_message('error', 'LM Report has illegal characters. Error: ERRNMECANCLM0005');
                $this->session->set_flashdata('message', "LM Report has illegal characters. Error: ERRNMECANCLM0005");
                redirect(base_url('index.php/NameCancellation/LMStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else if($caseInfo->misc_case_type=='06') {
                //ERRNMECORRLM0006
                log_message('error', 'LM Report has illegal characters. Error: ERRNMECORRLM0006');
                $this->session->set_flashdata('message', "LM Report has illegal characters. Error: ERRNMECORRLM0006");
                redirect(base_url('index.php/NameCorrection/LMStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else{
                $this->session->set_flashdata('message', "LM Report has illegal characters.");
                redirect(base_url('index.php/home'));
            }  
        }
        //authorization
        if($caseInfo->misc_case_type=='07') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'LM', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECANCLM0007
                log_message('error', $response['messages'] .'. Error: ERRNMECANCLM0007');
                $this->session->set_flashdata('message', $response['messages'].". Error: ERRNMECANCLM0007");
                redirect(base_url('index.php/home'));
            }
        }
        else if($caseInfo->misc_case_type=='06') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'LM', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRLM0007
                log_message('error', $response['messages'] .'. Error: ERRNMECORRLM0007');
                $this->session->set_flashdata('message', $response['messages'].". Error: ERRNMECORRLM0007");
                redirect(base_url('index.php/home'));
            }
        }
       


        //user authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     //ERRNMECORRLM0007
        //     log_message('error', 'User not logged in. Error: ERRNMECORRLM0007');
        //     $this->session->set_flashdata('message', "User not logged in. Error: ERRNMECORRLM0007");
        //     redirect(base_url('index.php/home'));
        // }

        //user authorization
        // if($sessionData['user_desig_code']!='LM' || $sessionData['dist_code']!=$caseInfo->dist_code || $sessionData['subdiv_code']!=$caseInfo->subdiv_code || $sessionData['cir_code']!=$caseInfo->cir_code || $sessionData['mouza_pargona_code']!=$caseInfo->mouza_pargona_code || $sessionData['lot_no']!=$caseInfo->lot_no) {
        //     //ERRNMECORRLM0008
        //     log_message('error', 'User not authorized. Error: ERRNMECORRLM0008');
        //     $this->session->set_flashdata('message', "User not authorized. Error: ERRNMECORRLM0008");
        //     redirect(base_url('index.php/home'));
        // }

        //$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no');
        $lm_report = addslashes($this->input->post('lm_report'));
        $note_date = date('Y-m-d');
        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $data['miscCaseInfo'] = $caseInfo;
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();
        //$misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        //$year_no = $data['miscCaseInfo']->year_no;
        $sql = "select MAX(note_no)+1 AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($misc_case_no, $petition_no))->row()->note_no;

        $appStatus = false;
        if(isset($_POST['application_no']) && $_POST['application_no']!='') {
            $checkApp = $this->FormValidationModel->formValidationForPost($_POST, [
                'application_no'=>'Application No|required|application_no'
            ]);
            // $checkApp = postParamFormValidation($_POST, [
            //     'application_no'=>'application_no'
            // ]);
            if($checkApp['status']=='y') {
                $appStatus = true;
                $application_no = $this->input->post('application_no');
            }
        }

        $note_no = $result;
        $status = '02';
        $operation = 'l';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $lm_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $ins = $this->db->insert("misc_case_process_reports", $userdata);
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM001: Insertion failed in misc_case_process_reports for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM001: Unable to process misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");   
            return false;
        }

        $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$lm_report);


       if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#MISCLM001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MISCLM001)".$misc_case_no);
            redirect(base_url() . "index.php/home");
        }

        $updateSqlBasic = "update   misc_case_basic set lm_note_yn='Y', operation='$operation', date_of_operation='$note_date',  "
                . " status='$status' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
        $this->db->query($updateSqlBasic);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM002: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM002: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }

        $updateSqlFirstParty = "update   misc_case_first_party set operation='l' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
        $this->db->query($updateSqlFirstParty);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM003: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM003: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }
        //Additional File Upload Integration done ---------02022023----
        //START//------
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // die;
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
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                redirect(base_url() . "index.php/home");
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                redirect(base_url() . "index.php/home");
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
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
                    $replaceCase=str_replace("/","-",$misc_case_no);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT_MISCASE;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = UPLOAD_MAX_SIZE;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $misc_case_no,
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT_MISCASE .$fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'NC',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNCORC0001: Insertion failed in supportive document  Case No '.$misc_case_no);
                            $this->session->set_flashdata('error_data', "#ERRNCORC0001: Uploading Falied of Name Correction case no : ".$misc_case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }else{
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRNCORC0002: Uploading failed in supportive document Case No '.$misc_case_no);
                        $this->session->set_flashdata('error_data', "#ERRNCORC0002: Uploading Failed of Name Correction for case no : ".$misc_case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }
        // $this->db->trans_commit();
         ///////////////////////////////////
        $penUser='SK';
        $rmrk="LM submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////


        if($appStatus)
        {
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'LM report',
                'status' => 'M',
                'task' => 'LM',
                'pen'=>'SK',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }
            $this->db->trans_commit();
            // $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
        if($caseInfo->misc_case_type=='07') {
            $this->session->set_flashdata('message', 'Name Cancellation Report Submitted !!');
        }
        else if($caseInfo->misc_case_type=='06') {
            $this->session->set_flashdata('message', 'Name Correction Report Submitted !!');
        }
       
        redirect(base_url() . "index.php/home/index");
    }

    public function SKStep2_save() {
        
        if(!isset($_POST['misc_case_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['sk_report']) || $_POST['misc_case_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['sk_report']=='') {
            //ERRNMECORRSK0001
            log_message('error', 'Improper Input Error: ERRNMECORRSK0001');
            $this->session->set_flashdata('message', "Improper Input Error: ERRNMECORRSK0001");
            redirect(base_url('index.php/NameCorrection/SKStep1'));
        }
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECORRSK0009
            log_message('error', $validquery['messages'] .'Error: ERRNMECORRSK0009');
            $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRSK0009');
            redirect(base_url('index.php/home'));
        }
        //syntax validation
        // $validAppNo = applicationNumberValidation($_POST['application_no']);
        $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        // if(!empty($validAppNo)) {
        //     //ERRNMECORRSK0002
        //     $this->session->set_flashdata('message', "Application No. cannot have special characters. Error: ERRNMECORRSK0002");
        //     redirect(base_url('index.php/NameCorrection/SKStep1'));
        // }
        if(!empty($validCaseNo)) {
            //ERRNMECORRSK0003
            log_message('error', 'Case No. cant have special characters. Error: ERRNMECORRSK0003');
            $this->session->set_flashdata('message', "Case No. cant have special characters. Error: ERRNMECORRSK0003");
            redirect(base_url('index.php/NameCorrection/SKStep1'));
        }
        if(!preg_match('/^[0-9]*$/', $_POST['misc_case_petition_no'])) {
            //ERRNMECORRSK0004
            log_message('error', 'Case Petition No. must be numerical. Error: ERRNMECORRSK0004');
            $this->session->set_flashdata('message', "Case Petition No. must be numerical. Error: ERRNMECORRSK0004");
            redirect(base_url('index.php/NameCorrection/SKStep1'));
        }
        $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
        $validreport = specialCharacterCheckingInInput($_POST['sk_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validreport['status']=='n') {
            if($caseInfo->misc_case_type=='06') {
                //ERRNMECORRSK0005
                log_message('error', 'SK Report has illegal characters. Error: ERRNMECORRSK0005');
                $this->session->set_flashdata('message', "SK Report has illegal characters. Error: ERRNMECORRSK0005");
                redirect(base_url('index.php/NameCorrection/SKStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else if($caseInfo->misc_case_type=='07') {
                //ERRNMECANCSK0006
                log_message('error', 'SK Report has illegal characters. Error: ERRNMECANCSK0006');
                $this->session->set_flashdata('message', "SK Report has illegal characters. Error: ERRNMECANCSK0006");
                redirect(base_url('index.php/NameCancellation/SKStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else{
                $this->session->set_flashdata('message', "SK Report has illegal characters.");
                redirect(base_url('index.php/home'));
            }
        }

        //authorization
        if($caseInfo->misc_case_type=='06') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'SK', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRSK0007
                log_message('error', $response['messages'] .' Error: ERRNMECORRSK0007');
                $this->session->set_flashdata('message', $response['messages'] ." Error: ERRNMECORRSK0007");
                redirect(base_url('index.php/home'));
            }
        }
        else if($caseInfo->misc_case_type=='07') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'SK', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECANCSK0007
                log_message('error', $response['messages'] .' Error: ERRNMECANCSK0007');
                $this->session->set_flashdata('message', $response['messages'] ." Error: ERRNMECANCSK0007");
                redirect(base_url('index.php/home'));
            }
        }
        

        //user authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     //ERRNMECORRSK0007
        //     log_message('error', 'User not logged in. Error: ERRNMECORRSK0007');
        //     $this->session->set_flashdata('message', "User not logged in. Error: ERRNMECORRSK0007");
        //     redirect(base_url('index.php/home'));
        // }

        //user authorization
        // if($sessionData['user_desig_code']!='SK' || $sessionData['dist_code']!=$caseInfo->dist_code || $sessionData['subdiv_code']!=$caseInfo->subdiv_code || $sessionData['cir_code']!=$caseInfo->cir_code) {
        //     //ERRNMECORRSK0008
        //     log_message('error', 'User not authorized. Error: ERRNMECORRSK0008');
        //     $this->session->set_flashdata('message', "User not authorized. Error: ERRNMECORRSK0008");
        //     redirect(base_url('index.php/NameCorrection/SKStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
        // }

        //$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no');
        $sk_report = addslashes($this->input->post('sk_report'));
        $note_date = date('Y-m-d');
        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $data['miscCaseInfo'] = $caseInfo;
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        $sql = "select MAX(note_no) AS note_no from  misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($misc_case_no, $petition_no));
        $note_no = ($result->row()->note_no) + 1;
        $status = '02';
        $operation = 's';
        $co_fresh_proceeding = 'Y';

        $appStatus = false;
        if(isset($_POST['application_no']) && $_POST['application_no']!='') {
            $checkApp = $this->FormValidationModel->formValidationForPost($_POST, [
                'application_no'=>'Application No|required|application_no'
            ]);
            // $checkApp = postParamFormValidation($_POST, [
            //     'application_no'=>'application_no'
            // ]);
            if($checkApp['status']=='y') {
                $appStatus = true;
                $application_no = $this->input->post('application_no');
            }
        }
        
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $sk_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $ins = $this->db->insert("misc_case_process_reports", $userdata);
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORSK001: Insertion failed in misc_case_process_reports for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORSK001: Unable to process misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }

        $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$sk_report);


       if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#MISCSK001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MISCSK001)".$misc_case_no);
            redirect(base_url() . "index.php/home");
        }

        $updateSqlBasic = "update  misc_case_basic set sk_note_yn='Y', operation=?, date_of_operation=?,  "
                . " status=? where misc_case_no=? and misc_case_petition_no = ? ";
        $this->db->query($updateSqlBasic, array($operation, $note_date, $status, $misc_case_no, $petition_no));
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORSK002: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORSK002: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }

        $updateSqlFirstParty = "update  misc_case_first_party set operation='f' where misc_case_no=? and misc_case_petition_no = ? ";
        $this->db->query($updateSqlFirstParty, array($misc_case_no, $petition_no));
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORSK003: Updation failed in misc_case_first_party for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORSK003: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }

        $this->db->trans_commit();
        ///////////////////////////////////
        $penUser='CO';
        $rmrk="SK submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////

        if($appStatus)
        {
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'Sk report',
                'status' => 'M',
                'task' => 'SK',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }
        if($caseInfo->misc_case_type=='07') {
            $this->session->set_flashdata('message', 'Name Cancellation Report By SK Submitted !!');
        }
        else if($caseInfo->misc_case_type=='06') {
            $this->session->set_flashdata('message', 'Name Correction Report By SK Submitted !!');
        }
        redirect(base_url() . "index.php/home/index");
    }

///// 27-04-22 //// name correction report in basundhara ADC reject list

    function nameCorrReport(){

        $case_no = $this->input->get('app');
        $sql="Select dharitree from basundhar_application where basundhara='$case_no' "; 
        $dh=$this->db->query($sql)->row()->dharitree;
        if($dh){
            // $data['comments_co'] = $this->db->query("SELECT * FROM misc_case_process_reports 
            //     WHERE misc_case_no='$dh' AND user_code like 'CO%'")->result();
            $data['comments_lm'] = $this->db->query("SELECT * FROM misc_case_process_reports 
                WHERE misc_case_no='$dh' AND user_code like 'M%'")->result();
            
            }
        $this->load->view('NameCorrection/viewRejectReport',$data);
    }
////////////////////////
       public function lmNameCorrectionReport()
    {
        $misc_case_no = $this->input->post('case_no');
        $petition_no = $this->input->post('petition_no');
        $json = [
            'success' => 'true',
            'details' => $this->NameCorrectionModelV2->getLMReport($misc_case_no, $petition_no)
        ];
        echo json_encode($json);
        return;
    }

    public function skNameCorrectionReport()
    {
        $misc_case_no = $this->input->post('case_no');
        $petition_no = $this->input->post('petition_no');
        $json = [
            'success' => 'true',
            'details' => $this->NameCorrectionModelV2->getSKReport($misc_case_no, $petition_no)
        ];
        echo json_encode($json);
        return;
    }

    public function coNameCorrectionReport()
    {
        $misc_case_no = $this->input->post('case_no');
        $petition_no = $this->input->post('petition_no');
        $json = [
            'success' => 'true',
            'details' => $this->NameCorrectionModelV2->getCOReport($misc_case_no, $petition_no)
        ];
        echo json_encode($json);
        return;
    }













    public function finalOrderCONameCorrection()
    {
        $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }


        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModelV2->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        // /$dag_no=$data['miscCaseInfo']->dag_no;
        $patta_no=$data['miscCaseInfo']->patta_no;

        $data['supportDoc'] = $this->NameCorrectionModelV2->getSupportedDoc($supported_doc_code);
        $data['petitioner'] = $this->NameCorrectionModelV2->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        //////////////////////////////////////////
        //find the pdar_id
        $pdardata = $this->NameCorrectionModelV2->getPdarIDMisc($misc_case_no, $petition_no);
        $pdar_id = $pdardata->petition_pdar_id;
        $pdar_name = $pdardata->petition_pdar_name_old;
        //$dag_no=$this->input->post('dag_no');
        $dag_no = $this->NameCorrectionModelV2->getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);

        $data['orderNo'] = $this->NameCorrectionModelV2->getOrderNo();
        //$data['landtype'] = $this->APCancellationModel->getLandType();

        $query = "SELECT mc.user_code FROM misc_case_process_reports mc 
        JOIN misc_case_basic mb ON mb.misc_case_no=mc.misc_case_no WHERE 
        mb.misc_case_no=? and mc.operation=?";

        $lmcode = $this->db->query($query, array($misc_case_no, 'l'))->row()->user_code;
       // $skcode = $this->db->query($query, array($misc_case_no, 's'))->row()->user_code;

        $data['lmname'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lmcode);
        //$data['skname'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $skcode);

        $co_user_code = $this->session->userdata('user_code');
        //$data['COList'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $co_user_code);

        $data['LmSignDate'] = $this->NameCorrectionModelV2->getLMSignDate($misc_case_no);
      //  $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
        //$data['COSignDate'] = $this->NameCorrectionModel->getCOSignDate($misc_case_no);

        //////////////////////////////////////////
        //$infavor_of_corrected_name = $data['info']->petition_pdar_name_new;
        $data['pdarinfo'] = $this->NameCorrectionModelV2->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
        $data['inFavID'] = $this->NameCorrectionModelV2->getMiscID($misc_case_no);

        //$data['landType'] = $this->APCancellationModel->getPattaName($patta_type_code);

        //////////////////////////////////////////////

        $application_no="select * from basundhar_application where dharitree=? ";
        $data['app'] = $app_details = $this->db->query($application_no, array($misc_case_no))->row();

        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
        if($data['app']){
            $data['query']=$this->basundharamodel->queryReturn($data['app']->basundhara);
        }
        $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($misc_case_no))->result();


        //AADHAAR DETAIL DISPLAY-------------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //END OF AADHAAR DETAILS------------------------------


        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
        $this->load->model('propChain/PropChainModel');
        // echo "<pre>";
        // var_dump($data['Petitioner']);
        // die;
        // var_dump($propData['dist_code']);

        $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $data['miscCaseInfo']->dag_no);

        $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);


        if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
            $this->PropChainModel->updateCmpFlag($misc_case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
            // if mismatch case get the view mismatch case button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($misc_case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);
        }

        $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
        $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

        if ($data['ulpinCheck'] == 1) {
            $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
            if (isset($checkPropAndChithaAndUlpn['old_ulpin']))
                $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
            else
                $data['old_ulpin'] = "";
        }

        // if property does not exists get create asset button
        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
            $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
        }
        $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
        $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
        $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
        $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];

        // hidden fields
        $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
        $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
        $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
        $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

         // bhunaksha area cmp
         $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
         $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
         $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
         $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }

        // ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1 && $data['miscCaseInfo']->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $adc_revert="select process_note from misc_case_process_reports where user_code like 'ADC%' and operation='a' and misc_case_no='$misc_case_no' and co_fresh_proceeding='N' order by note_no desc ";
        $data['adc_revert'] = $this->db->query($adc_revert)->row();


        $params = [
          'case_no'          => $misc_case_no,
          'service_code'     => 6,
          'remarks'          => 'Name Correction',
          'accessed_entity'  => 'Aadhaar Name, DOB, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $data['_view'] = 'NameCorrection/v2/finalOrderPassCONameCorrect';
        $this->load->view('layouts/main',$data);    
    }


    public function updateChithaNameCorrection($case_no, $misc_case_petition_no) {

        $date=date('Y-m-d');
        $redirectUrl = base_url().'index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$case_no.'&petition_no='.$misc_case_petition_no;

        $q = "SELECT * FROM misc_case_basic mcb, t_chitha_rmk_infavor_of c8 WHERE
        mcb.dist_code = c8.dist_code AND mcb.subdiv_code = c8.subdiv_code AND 
        mcb.cir_code= c8.cir_code AND mcb.lot_no = c8.lot_no AND 
        mcb.mouza_pargona_code = c8.mouza_pargona_code AND 
        mcb.vill_townprt_code = c8.vill_townprt_code AND mcb.misc_case_no=c8.ord_no AND 
        TRIM(mcb.patta_no) = TRIM(c8.patta_no) AND c8.iscorrected_inco IS NULL AND 
        c8.ord_no='$case_no' AND c8.petition_no = '$misc_case_petition_no'";

        $data = $this->db->query($q)->result();
        $ord_cron_no = 1;

        foreach ($data as $d) {
            $dist_code = $d->dist_code;
            $subdiv_code = $d->subdiv_code;
            $cir_code = $d->cir_code;
            $lot_no = $d->lot_no;
            $mouza_pargona_code = $d->mouza_pargona_code;
            $vill_townprt_code = $d->vill_townprt_code;
            $dag_no = $d->dag_no;
            $patta_no = $d->patta_no;
            $patta_type_code = $d->patta_type_code;

            $q = "SELECT max(rmk_type_hist_no)+1 AS c2 FROM chitha_rmk_gen 
            WHERE dist_code=? and subdiv_code=? and cir_code=? AND lot_no=? 
            AND vill_townprt_code=? and mouza_pargona_code=? AND dag_no=?";
            $rmk_type_hist_no = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code,
            $lot_no, $vill_townprt_code, $mouza_pargona_code, $dag_no))->row()->c2;
            
            if ($rmk_type_hist_no == null) {
                $rmk_type_hist_no = 1;
            }
            
            $chitha_rmk_gen = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
            ];
            $status1 = $this->db->insert("chitha_rmk_gen", $chitha_rmk_gen);
            if($status1 != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCRG101: Insertion failed in chitha_rmk_gen for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRCRG101: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }

            $chitha_rmk_ordbasic = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'ord_no' => $case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '06',
                'ord_cron_no' => $ord_cron_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => 'ADC',
                'co_sign_yn' => 'Y',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => 0.0,
                'm_dag_area_k' => 0.0,
                'm_dag_area_lc' => 0.0,
                'm_dag_area_g' => 0.0,
                'm_dag_area_kr' => 0.0,
                'area_left_b' => 0.0,
                'area_left_k ' => 0.0,
                'area_left_lc' => 0.0,
                'area_left_g' => 0.0,
                'area_left_kr' => 0.0,
            ];
            $status2 = $this->db->insert("chitha_rmk_ordbasic", $chitha_rmk_ordbasic);
            if($status2 != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCROB102: Insertion failed in chitha_rmk_ordbasic for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRCROB102: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }
            $upTChithaRmk = "UPDATE t_chitha_rmk_ordbasic SET iscorrected_inco='Y',
            iscorrected_inco_date='$date' WHERE dist_code=? AND subdiv_code=? AND 
            cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? 
            AND ord_no=? AND petition_no=? AND dag_no=? ";
            $this->db->query($upTChithaRmk, array($d->dist_code, 
            $d->subdiv_code, $d->cir_code, $d->lot_no, $d->mouza_pargona_code,
            $d->vill_townprt_code, $case_no, $misc_case_petition_no, $dag_no));
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRTCROB103: Updation failed in t_chitha_rmk_ordbasic for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRTCROB103: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }
            
            $selTChithaRIn = "SELECT * FROM t_chitha_rmk_infavor_of WHERE ord_no=? AND dag_no=?";
            $infve = $this->db->query($selTChithaRIn, array($d->ord_no, $dag_no));
            if($infve->num_rows() <= 0){
                $this->db->trans_rollback();
                log_message('error', '#ERRTCROB104: No data available in t_chitha_rmk_infavor_of for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRTCROB104: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }

            foreach ($infve->result() as $infv) {
                unset($infv->year_no);
                unset($infv->petition_no);
                unset($infv->pdar_id);
                unset($infv->revenue);
                unset($infv->iscorrected_inco);
                unset($infv->iscorrected_inco_date);
                unset($infv->iscorrected_rkg_record);
                unset($infv->iscorrected_rkg_date);
                unset($infv->infavor_is_copdar);
                unset($infv->make_mdb);
                unset($infv->new_pattadar);
                unset($infv->iscorrected_inco_date);
                $infv->rmk_type_hist_no = $rmk_type_hist_no;
                $infv->ord_cron_no = $ord_cron_no++;
                $infv->user_code = $d->add_to_officer;//$this->session->userdata('user_code');
                $infv->date_entry = date('Y-m-d');
                $infv->operation = 'E';

                $status4 = $this->db->insert("chitha_rmk_infavor_of", $infv);
                if($status4 != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCROB105: Insertion failed in chitha_rmk_infavor_of for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRCROB105: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }

                $upTChithaRIn = "UPDATE t_chitha_rmk_infavor_of SET iscorrected_inco='Y' 
                WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND 
                mouza_pargona_code=? AND vill_townprt_code=? AND ord_no=? AND 
                petition_no=? AND dag_no=?";
                $this->db->query($upTChithaRIn, array($d->dist_code, $d->subdiv_code,
                $d->cir_code, $d->lot_no, $d->mouza_pargona_code, $d->vill_townprt_code,
                $case_no, $misc_case_petition_no, $dag_no));  
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRTCRIF106: Updation failed in t_chitha_rmk_infavor_of for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRTCRIF106: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }
            }
            if($d->auth_type == 'AADHAAR'){
                $aadharNo = $d->id_ref_no;
                $panNo = null;
                $photo = $d->photo;
            }else if($d->auth_type == 'PAN'){
                $panNo = $d->id_ref_no;
                $aadharNo =null;
                $photo = null;
            }else{
                $panNo = null;
                $aadharNo =null;
                $photo = null;
            }
            // $upChithaPatta = "UPDATE chitha_pattadar SET 
            // pdar_aadharno = '$aadharNo',pdar_pan_no='$panNo',pdar_photo=null, pdar_name= ?, jama_yn='n'
            // WHERE TRIM(patta_no)=trim(?) AND pdar_id=? AND dist_code=? AND 
            // subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND
            // vill_townprt_code=?";
            // $this->db->query($upChithaPatta, array($d->infavor_of_corrected_name,$d->patta_no, $d->pdar_id, $d->dist_code, 
            // $d->subdiv_code, $d->cir_code, $d->lot_no, $d->mouza_pargona_code, 
            // $d->vill_townprt_code)); 

            $table = 'chitha_pattadar';

            $params = [
                'pdar_aadharno' => $aadharNo,
                'pdar_pan_no'   => $panNo,
                'pdar_photo'    => null,
                'pdar_name'     => $d->infavor_of_corrected_name,
                'jama_yn'       => 'n',
            ];

            $where = [
                'patta_no'           => trim($d->patta_no),
                'pdar_id'            => $d->pdar_id,
                'dist_code'          => $d->dist_code,
                'subdiv_code'        => $d->subdiv_code,
                'cir_code'           => $d->cir_code,
                'lot_no'             => $d->lot_no,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'vill_townprt_code'  => $d->vill_townprt_code,
            ];

            $result = $this->Chitha_basic_model->update_table($table, $params, $where);


            if($result <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRTCRIF107: Updation failed in chitha_pattadar for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRTCRIF107: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {            
            return true;
        }
    }


    //////////////property chain////
    public function finalOrderCONameCorrection_save_ooooo()
    {
        //checking for empty remark field
        $this->form_validation->set_rules('co_report', 'Remarks', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', "CO Remark field is required");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $val = $this->input->post();

            $misc_case_no = $val['misc_case_no'];
            $petition_no = $val['misc_case_petition_no'];

            $old_pet_name = trim($val['infavor_of_old_name']);
            $new_pet_name = trim($val['infavor_of_corrected_name']);

            $redirectUrl = base_url() . 'index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no=' . $misc_case_no . '&petition_no=' . $petition_no;

            $co_report = $val['co_report'];
            $letter_no = $val['ord_ref_let_no'];
            $note_date = date('Y-m-d');

            $miscCaseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
            $dist_code = $miscCaseInfo->dist_code;
            $subdiv_code = $miscCaseInfo->subdiv_code;
            $cir_code = $miscCaseInfo->cir_code;
            $mouza_pargona_code = $miscCaseInfo->mouza_pargona_code;
            $lot_no = $miscCaseInfo->lot_no;
            $vill_code = $miscCaseInfo->vill_townprt_code;
            $patta_type_code = $miscCaseInfo->patta_type_code;
            $pattaType = $this->APCancellationModel->getPattaName($patta_type_code);
            $dag_no = trim($miscCaseInfo->dag_no);
            $patta_no = trim($miscCaseInfo->patta_no);
            $year_no = $miscCaseInfo->year_no;
            $user_code = $this->session->userdata('user_code');

            $data['info'] = $this->NameCorrectionModel->getPdarIDMisc($misc_case_no, $petition_no);
            $pdar_id = $data['info']->petition_pdar_id;

            $inFavID = $this->NameCorrectionModel->getMiscID($misc_case_no);
            $ord_date = date("Y-m-d", strtotime($val['ord_date']));

            $data['pdarinfo'] = $this->NameCorrectionModel->PdarInfo(
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $lot_no,
                $vill_code,
                $patta_no,
                $patta_type_code,
                $pdar_id
            );

            $this->db->trans_begin();

            //check if both old and corrected name are same
            if ($old_pet_name == $new_pet_name) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPET001: Existing Name and Corrected Name are alike 
                        for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#ERRPET001: Both Current Petitioner Name and Corrected name is seems to be alike for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //check dag no is exist or not
            $check_dag_no = $this->NameCorrectionModel->getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
            //$dag_available = array_column($check_dag_no, 'dag_no');

            //if ((!in_array($dag_no, $dag_available))){
            if (empty($check_dag_no)) {
                $this->db->trans_rollback();
                log_message('error', '#ERRDAG001: Dag No does not exist 
                        for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#ERRDAG001: The applied DAG NO or PATTADAR(s) might not exit in the given patta for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //check data if already exist in misc_case_basic
            $misc_case_basic = $this->db->query("SELECT misc_case_no FROM 
                misc_case_basic WHERE status=? AND user_code=? AND operation=?
                AND misc_case_no=? ", array('10', $user_code, 'E', $misc_case_no));
            if ($misc_case_basic->num_rows() > 0) {
                $this->db->trans_rollback();
                log_message('error', '#EXISTMCBOO1: Data alaready exist in 
                    misc_case_basic for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#EXISTMCBOO1: Same detail already available for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //check data if already exist in t_chitha_rmk_ordbasic
            $t_chitha_rmk_ordbasic = $this->db->query(
                "SELECT ord_no FROM 
                t_chitha_rmk_ordbasic WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
                AND ord_no=? AND dag_no=? AND year_no=?",
                array(
                    $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
                    $vill_code, $misc_case_no, $dag_no, $year_no
                )
            );
            //echo $this->db->last_query(); return;


            if ($t_chitha_rmk_ordbasic->num_rows() > 0) {
                $this->db->trans_rollback();
                log_message('error', '#EXISTTCROB3: Data alaready exist in 
                    t_chitha_rmk_ordbasic for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#EXISTTCROB3: Same detail already available for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //check data if already exist in t_chitha_rmk_infavor_of
            $t_chitha_rmk_infavor_of = $this->db->query(
                "SELECT ord_no FROM 
                t_chitha_rmk_infavor_of WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
                AND ord_no=? AND dag_no=? AND year_no=?",
                array(
                    $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
                    $vill_code, $misc_case_no, $dag_no, $year_no
                )
            );

            if ($t_chitha_rmk_infavor_of->num_rows() > 0) {
                $this->db->trans_rollback();
                log_message('error', '#EXISTTCRIFO4: Data alaready exist in 
                    t_chitha_rmk_infavor_of for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#EXISTTCRIFO4: Same detail already available for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $sql = "SELECT max(note_no)+1 AS note_no FROM misc_case_process_reports 
                WHERE misc_case_no = ?";
            $result = $this->db->query($sql, array($misc_case_no))->row();
            $note_no = $result->note_no;

            //insertion in misc_case_process_reports
            $processReport = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $misc_case_no,
                'co_fresh_proceeding' => 'Y',
                'process_note' => $co_report,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => 'c',
                'misc_case_petition_no' => $petition_no
            ];
            $ins = $this->db->insert("misc_case_process_reports", $processReport);
            if ($ins != 1) {
                $this->db->trans_rollback();
                log_message('error', '#NCMCPR001: Insertion failed in misc_case_process_reports 
                    for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#NCMCPR001: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //insertion in t_chitha_rmk_ordbasic
            $tchithaOrdBasic = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'ord_no' => $misc_case_no,
                'ord_type_code' => $val['ord_type_code'],
                'case_no' => $misc_case_no,
                'ord_passby_sign_yn' => $val['ord_passby_sign_yn'],
                'ord_passby_desig' => $val['ord_passby_desig'],
                'ord_ref_let_no' => $letter_no,
                'lm_code' => $val['lm_code'],
                'lm_sign_yn' => $val['lm_sign'],
                'lm_sign_date' => $val['lm_sign_date'],
                'sk_code' => $val['sk_code'],
                'sk_sign_yn' => $val['sk_sign'],
                'sk_sign_date' => $val['sk_sign_date'],
                'co_code' => $user_code,
                'co_sign_yn' => $val['co_sign'],
                'co_ord_date' => date('Y-m-d G:i:s'),
                'ord_date' => $ord_date,
                'wrt_order1' => $val['wrt1'],
                'wrt_order2' => $val['wrt2'],
                'wrt_order3' => $val['wrt3'],
                'wrt_order4' => $val['wrt4']
            ];
            $tchithaIns = $this->db->insert("t_chitha_rmk_ordbasic", $tchithaOrdBasic);
            if ($tchithaIns != 1) {
                $this->db->trans_rollback();
                log_message('error', '#NCTCRO002: Insertion failed in t_chitha_rmk_ordbasic 
                    for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#NCTCRO002: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //insertion in t_chitha_rmk_infavor_of
            $tchithaInfavor = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'infavor_of_id' => $inFavID + 1,
                'ord_no' => $misc_case_no,
                'ord_date' => $ord_date,
                'patta_type_code' => $patta_type_code,
                'patta_no' => $patta_no,
                'pdar_id' =>  $pdar_id,
                'infavor_of_name' => $val['infavor_of_name'],
                'infavor_of_guardian' => $val['infavor_of_guardian'],
                'infav_of_guar_relation' => $val['infav_of_guar_relation'],
                'infavor_of_add1' => $val['infavor_of_add1'],
                'infavor_of_add2' => $val['infavor_of_add2'],
                'infavor_of_corrected_name' => $val['infavor_of_corrected_name'],
                'by_right_of' => '06',
                'land_area_b' => 0,
                'land_area_k' => 0,
                'land_area_lc' => 0,
                'land_area_g' => 0,
                'land_area_kr' => 0,
                'revenue' => 0,
            ];
            $tchithaInfavorIns = $this->db->insert("t_chitha_rmk_infavor_of", $tchithaInfavor);
            if ($tchithaInfavorIns != 1) {
                $this->db->trans_rollback();
                log_message('error', '#NCTCRIO003: Insertion failed in t_chitha_rmk_infavor_of 
                    for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#NCTCRIO003: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //update in misc_case_basic
            $updateBasic = [
                'date_of_operation' => $note_date,
                'status' => '10',
                'user_code' => $user_code,
                'operation' => 'E'
            ];
            $this->db->where('misc_case_no', $misc_case_no);
            $this->db->update('misc_case_basic', $updateBasic);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#NCMCB004: Updation failed in misc_case_basic 
                    for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#NCMCB004: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $updateFirstParty = [
                'user_code' => $user_code,
                'operation' => 'E'
            ];
            $this->db->where('misc_case_no', $misc_case_no);
            $this->db->update('misc_case_first_party', $updateFirstParty);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#NCMCFP005: Updation failed in misc_case_first_party 
                    for misc case no : ' . $misc_case_no);
                $this->session->set_flashdata('message', "#NCMCFP005: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $ok = $this->updateChithaNameCorrection($misc_case_no, $petition_no);
            if ($ok != true) {
                $this->db->trans_rollback();
                log_message("error", " #NCAUC006: Issue occured in updating Chitha for case no: " . $misc_case_no);
                $this->session->set_flashdata('message', "#NCAUC006: Final Submission failed for case no : " . $misc_case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            if ($ok) {
                //autoupdate jamabandi starts here
                $this->load->model('jamabandi/jamabandiAutoUpdateModel');
                $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi(
                    $patta_no,
                    $patta_type_code,
                    $dist_code,
                    $subdiv_code,
                    $cir_code,
                    $mouza_pargona_code,
                    $lot_no,
                    $vill_code,
                    $misc_case_no
                );
                if ($jamaUpdate != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #NCUJ007: Issue occured in updating Jamabandi for case no: " . $misc_case_no);
                    $this->session->set_flashdata('message', "#NCUJ007: Final Submission failed 
                            for case no : " . $misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
                //autoupdate jamabandi ends here

                $success = $this->DashboardDataFinal($misc_case_no);
                $basundhara = $this->db->query("SELECT basundhara FROM basundhar_application 
                    WHERE dharitree=?", array($misc_case_no))->row()->basundhara;

                if ($basundhara) {
                    $rtps = $this->rtpsmodel->checkRtpsService($basundhara);
                    if ($rtps == 'RTPS') {
                        $apilink = RTPS_API_LINK;
                    } else {
                        $apilink = API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink . "applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $basundhara,
                        'dharitree' => $misc_case_no,
                        'rmk' => 'approved by CO',
                        'status' => 'F',
                        'task' => 'CO',
                        'pen' => 'Approved',
                        'penat' => 'Circle office'
                    )));
                    $result = curl_exec($curl_handle);
                }

                //////////////////////////////////////////////////////////////////////////// property chain code /////////////////////////////////////////////////////////////

                $ulpin = $this->input->post('ulpin');
                $revenue = $this->input->post('chain_revenue');
                $local_tax = $this->input->post('chain_local_tax');

                $old_ulpin = $this->input->post('old_ulpin');
                if ($old_ulpin == null)
                    $old_ulpin = "";
                $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_code;

                $certmnemonic = CERTMNEMONIC_NAMECORR;

                $chain_dag = $dag_no;
                $chain_patta = $patta_no;

                $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $chain_patta, $chain_dag, $ulpin);

                $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                $bigha_chain = $land_area->dag_area_b;
                $katha_chain = $land_area->dag_area_k;
                $lessa_chain = $land_area->dag_area_lc;
                $ganda_chain = $land_area->dag_area_g;

                $land_class_code = $this->PropChainModel->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                $property_signature = "base64 encoded signature";
                $property_signer_key = "base64 encoded public key";

                $office_code = $this->session->userdata('cir_code');

                $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                // since below parameters are not applicable sent empty string
                $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";
                // 

                $update_params = array(
                    'pattadar_details' => $pattadar_details,
                    'location_id' => $location_id,
                    'property_id' => $property_id,
                    'reference_id' => $misc_case_no,
                    'dag_no' => $chain_dag,
                    'patta_no' => $chain_patta,
                    'patta_type_code' => $patta_type_code,
                    'land_class_code' => $land_class_code,
                    'bigha_chain' => $bigha_chain,
                    'katha_chain' => $katha_chain,
                    'lessa_chain' => $lessa_chain,
                    'ganda_chain' => $ganda_chain,
                    'certmnemonic' => $certmnemonic,
                    'property_signature' => $property_signature,
                    'property_signer_key' => $property_signer_key,
                    'office_code' => $office_code,
                    'user_code' => $user_code,
                    'ulpin' => $ulpin,
                    'old_ulpin' => $old_ulpin,
                    'revenue' => $revenue,
                    'local_tax' => $local_tax,
                    'new_patta_no' => $new_patta_no,
                    'new_dag_no' => $new_dag_no,
                    'old_revenue' => $old_revenue,
                    'old_local_tax' => $old_local_tax,
                    'old_land_class_code' => $old_land_class,
                    'new_bigha' => $new_bigha,
                    'new_katha' => $new_katha,
                    'new_lessa' => $new_lessa,
                    'new_ganda' => $new_ganda
                );

                $chain_update_data = $this->utilityclass->getUpdateChainArrayN((object)$update_params);
                // echo "<pre>";
                // // var_dump($this->input->post());
                // var_dump($chain_update_data);
                // $this->db->trans_rollback();
                // die;

                $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_update_data), $misc_case_no);

                if ($save_chain_data) {

                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "*Final order for Name Correction for case no : " . $misc_case_no . " has successfuly submitted.");
                    // redirect(base_url() . 'index.php/home');
                    redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($misc_case_no)));
                } elseif (!$save_chain_data) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Name Correction for case no " . $misc_case_no . " is not successfull. Error Code: #CHAINSAVEERROR0001");
                    log_message('error', "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");
                    redirect(base_url() . 'index.php/home');
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Property Chain updation for Case No " . $misc_case_no . " not successfull");
                    log_message('error', $name_corr_chain_update->error . ": " . $name_corr_chain_update->error_msg . ". Property Chain updation for Case No " . $misc_case_no . " not successfull. Error Code(" . $name_corr_chain_update->error_code . ")");
                    redirect(base_url() . 'index.php/home');
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Chitha Could not be updated for case no $misc_case_no. Contact Helpdesk with case no");
                redirect(base_url() . 'index.php/home');
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


        
         public function namecorrectLMPost(){


            $case_no = $this->input->post('case_no');
            ////////////out of escalation for timing out//////////////
            $user_desig_code = $this->session->userdata('user_desig_code');
            $ncorsql = "select * from misc_case_basic where misc_case_no = ?";
            $ncorData = $this->db->query($ncorsql,array($case_no))->row();
            if(ESCALATION_ENABLE == 1 && $ncorData->es_flag == 1)
            {
                $outEscStatus = $this->Escalationmodel->outOfEscServiceWise($case_no,'NCOR',$user_desig_code);
                if($outEscStatus['responseType'] == 1)
                {
                    $data=array(
                        'error'=>"#ERR3478NCORLM : Something went wrong, contact system administrator..."
                    );
                    echo json_encode($data);
                    return false;
                }
            }


            $this->db->trans_begin();  
            
            $add_to_officer =  $this->input->post('official');
            $user_code = $this->session->userdata('user_code');
            $lm_report = $this->input->post('lmremark');
            $executionDate = $this->input->post('executionDate');





            $queryForBasundhara = "select * from basundhar_application where dharitree = ?";
            $dataDhar = $this->db->query($queryForBasundhara,array($case_no))->row();

            $miscDataSql = "select * from misc_case_basic where misc_case_no = ?";
            $miscData = $this->db->query($miscDataSql,array($case_no))->row();

            $dateN = date('Y-m-d H:i:s');

            $q = "update misc_case_basic set user_code = ?, add_to_officer = ?, lm_note_yn = ? ,sk_note_yn= ? where misc_case_no=?";
            $this->db->query($q,array($user_code,$add_to_officer,'Y','Y',$case_no));

            if($this->db->affected_rows() <= 0){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORESCNAMECOR001 : Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }


            $process_note= $lm_report;//'LM gives his report successfuly';
            $sql = "select MAX(note_no)+1 AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $miscData->misc_case_petition_no));
            $note_no = ($result->row()->note_no) + 1;
           // $note_no = $result;
            $operation = 'l';
            $note_date = date('Y-m-d');

            $proceedings = array(
            'dist_code' => $miscData->dist_code,
            'subdiv_code' => $miscData->subdiv_code,
            'cir_code' => $miscData->cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $case_no,
            'co_fresh_proceeding' => '',
            'process_note' => $process_note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $miscData->misc_case_petition_no
            );

            $this->db->insert("misc_case_process_reports", $proceedings);

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$process_note);


            if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#MISCCO001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MISCCO001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            // log_message("error", "#MISC_ES_FLAG3347 :".json_encode($miscData->es_flag));

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $miscData->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $miscData->out_of_esc == 0)
            {
                
                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROR003371 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================



            if($miscData->es_flag == 1 && ESCALATION_ENABLE == 1 && $miscData->out_of_esc == 0)
            {
                $user_code = $this->session->userdata('user_code');
                $serviceChoose = explode('/',$case_no);
                $next_date_of_hearing = $miscData->next_date_of_hearing.date(' H:i:s');

                // log_message("error", "#POSTPARAMS3353 :".json_encode($_POST));

                $escalationUpdateStatus = $this->Escalationmodel->escalationLmNameCorrReport($executionDate, $miscData->dist_code, $miscData->subdiv_code, $miscData->cir_code, $case_no, $user_code);

                log_message("error", "#ESC3356, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                

                if($escalationUpdateStatus['responseType'] == 0)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC3356, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC3356)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }

            // log_message("error", "#ESC3371, transaction-error-STATUS======".json_encode($escalationUpdateStatus));


            if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORRECLASS00216 : Error in submitting in remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{
                
                // echo "I am here";

                $this->db->trans_commit();
                //////////////POST To rtps/////////////////////
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $dataDhar->basundhara,
                    'dharitree'   => $case_no,
                    'rmk'         => 'LM report give Successfully',
                    'status'      => 'M',
                    'task'        => 'LM',
                    'pen'         => 'CO',
                    'penat'       => 'Circle office'
                )));
                $result = curl_exec($curl_handle);
                
                //$this->DashboardReclass($case_no);
                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }

            log_message("error", "#FINALDATA3411 :". json_encode($data));
            echo json_encode($data);
        }


        public function coorderNameCorrection_save()
        {
            $allowed = ['CO'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }

            $case_no = $this->input->post('misc_case_no');

            ////////////out of escalation for timing out//////////////
            $user_desig_code = $this->session->userdata('user_desig_code');
            $ncorsql = "select * from misc_case_basic where misc_case_no = ?";
            $ncorData = $this->db->query($ncorsql,array($case_no))->row();
            if(ESCALATION_ENABLE == 1 && $ncorData->es_flag == 1)
            {
                $outEscStatus = $this->Escalationmodel->outOfEscServiceWise($case_no,'NCOR',$user_desig_code);
                if($outEscStatus['responseType'] == 1)
                {
                    $data=array(
                        'error'=>"#ERR3478NCOR : Something went wrong, contact system administrator..."
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            


            $this->db->trans_begin();  

            
            $user_code = $this->session->userdata('user_code');
            $co_report = $this->input->post('co_report');
            if($co_report == null || $co_report == '' )
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORESCNAMECOR003482 : Enter your remarks"
                );
                echo json_encode($data);
                return false;
            }

            $queryForBasundhara = "select * from basundhar_application where dharitree = ?";
            $dataDhar = $this->db->query($queryForBasundhara,array($case_no))->row();

            $miscDataSql = "select * from misc_case_basic where misc_case_no = ?";
            $miscData = $this->db->query($miscDataSql,array($case_no))->row();

            $dateN = date('Y-m-d H:i:s');

            $q = "update misc_case_basic set status= ? where misc_case_no=?";
            $this->db->query($q,array('A',$case_no));

            if($this->db->affected_rows() <= 0){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORESCNAMECOR001 : Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

            //var_dump($co_report);exit;
            $process_note=$co_report;
            $sql = "select MAX(note_no)+1 AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $miscData->misc_case_petition_no));
            $note_no = ($result->row()->note_no) + 1;
           // $note_no = $result;
            $operation = 'c';
            $note_date = date('Y-m-d');

            $proceedings = array(
            'dist_code' => $miscData->dist_code,
            'subdiv_code' => $miscData->subdiv_code,
            'cir_code' => $miscData->cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $case_no,
            'co_fresh_proceeding' => '',
            'process_note' => $process_note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $miscData->misc_case_petition_no
            );

            $this->db->insert("misc_case_process_reports", $proceedings);

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$process_note);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#MISCCO001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MISCCO001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $miscData->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $miscData->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERRNCORV2ESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================


            if($miscData->es_flag == 1 && ESCALATION_ENABLE == 1 && $miscData->out_of_esc == 0)
            {
                $user_code = $this->session->userdata('user_code');
                $serviceChoose = explode('/',$miscData->misc_case_no);
                $next_date_of_hearing = $miscData->next_date_of_hearing.date(' H:i:s');
                $executionDate = $this->input->post('executionDate');

                // log_message("error", "#POSTPARAMS3353 :".json_encode($_POST));

                $escalationUpdateStatus = $this->Escalationmodel->escalationCoNameCorrReport($executionDate, $miscData->dist_code, $miscData->subdiv_code, $miscData->cir_code, $case_no, $user_code);

                log_message("error", "#ESC3356, transaction-error-STATUS======".json_encode($escalationUpdateStatus['responseType']));

                

                if($escalationUpdateStatus['responseType'] == 0)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC3356, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC3356)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }


            if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORRECLASS00216 : Error in submitting in remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{
                
                $this->db->trans_commit();
                //////////////POST To rtps/////////////////////
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $dataDhar->basundhara,
                    'dharitree' => $case_no,
                    'rmk' => 'CO report give Successfully',
                    'status' => 'M',
                    'task' => 'CO',
                    'pen'=>'ADC',
                    'penat'=>'ADC'
                )));
                $result = curl_exec($curl_handle);
                
                //$this->DashboardReclass($case_no);
                $this->session->set_flashdata('message',"Application Forwarded to ADC Successfully with case no $case_no ");
                 redirect(base_url('index.php/home/index'));
                //////////////////////////////////
                // $data=array(
                //     'success'=>"Application Forwarded to ADC Successfully with case no $case_no",
                //     'redirect_url'=>base_url().'index.php/home'
                // );


            }

           // echo json_encode($data);
        }



    public function adcPending()
    {
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->library('pagination');

        $config['base_url'] = base_url().'/index.php/NameCorrectionV2/adcPending/';
        
        //original link
        //$data['getADCpending']  = $this->NameCorrectionModelV2->getADCpendingcases();
        //var_dump($data);
        
        $cases = $this->NameCorrectionModelV2->getAdcpendingcases1()->result();

        $caseList = $this->Escalationmodel->getMiscellaneousEscaltionViewFormat($cases);

        $case_array = array();

        foreach ($cases as $c) {

            $q = $this->db->query("SELECT * FROM misc_case_basic AS t1 WHERE  t1.status='A' and t1.lm_note_yn='Y' and t1.es_flag='1'")->row();
            
            array_push($case_array, $c);
        }
        
        //var_dump($case_array);
        $cases['getADCpending'] = $case_array;

        $cases['_view'] = 'NameCorrection/v2/adcpending';
        $this->load->view('layouts/main',$cases);
    }


    public function finalOrderADCNameCorrection()
    {
        $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }
        
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModelV2->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $adc_user_code = $this->session->userdata('user_code');
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['adc_name'] = $this->utilityclass->getSelectedADCName($dist_code, $adc_user_code);

        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        // /$dag_no=$data['miscCaseInfo']->dag_no;
        $patta_no=$data['miscCaseInfo']->patta_no;

        $data['supportDoc'] = $this->NameCorrectionModelV2->getSupportedDoc($supported_doc_code);
        $data['petitioner'] = $this->NameCorrectionModelV2->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        //////////////////////////////////////////
        //find the pdar_id
        $pdardata = $this->NameCorrectionModelV2->getPdarIDMisc($misc_case_no, $petition_no);
        $pdar_id = $pdardata->petition_pdar_id;
        $pdar_name = $pdardata->petition_pdar_name_old;
        //$dag_no=$this->input->post('dag_no');
        $dag_no = $this->NameCorrectionModelV2->getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);

        $data['orderNo'] = $this->NameCorrectionModelV2->getOrderNo();
        //$data['landtype'] = $this->APCancellationModel->getLandType();

        $query = "SELECT mc.user_code FROM misc_case_process_reports mc 
        JOIN misc_case_basic mb ON mb.misc_case_no=mc.misc_case_no WHERE 
        mb.misc_case_no=? and mc.operation=?";

        $lmcode = $this->db->query($query, array($misc_case_no, 'l'))->row()->user_code;
        //$skcode = $this->db->query($query, array($misc_case_no, 's'))->row()->user_code;
        $co_user_code = $this->db->query($query, array($misc_case_no, 'c'))->row()->user_code;

        $data['lmname'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lmcode);
        //$data['skname'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $skcode);

       // $co_user_code = $this->session->userdata('user_code');
        $data['COList'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $co_user_code);

        $data['LmSignDate'] = $this->NameCorrectionModelV2->getLMSignDate($misc_case_no);
        //$data['SkSignDate'] = $this->NameCorrectionModelV2->getSKSignDate($misc_case_no);
        $data['COSignDate'] = $this->NameCorrectionModelV2->getCOSignDate($misc_case_no);

        //////////////////////////////////////////
        //$infavor_of_corrected_name = $data['info']->petition_pdar_name_new;
        $data['pdarinfo'] = $this->NameCorrectionModelV2->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
        $data['inFavID'] = $this->NameCorrectionModelV2->getMiscID($misc_case_no);

        //$data['landType'] = $this->APCancellationModel->getPattaName($patta_type_code);

        //////////////////////////////////////////////

        $application_no="select * from basundhar_application where dharitree=? ";
        $data['app'] = $app_details = $this->db->query($application_no, array($misc_case_no))->row();

        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
        if($data['app']){
            $data['query']=$this->basundharamodel->queryReturn($data['app']->basundhara);
        }
        $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($misc_case_no))->result();


        //AADHAAR DETAIL DISPLAY-------------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //END OF AADHAAR DETAILS------------------------------


        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
        $this->load->model('propChain/PropChainModel');
        // echo "<pre>";
        // var_dump($data['Petitioner']);
        // die;
        // var_dump($propData['dist_code']);

        $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $data['miscCaseInfo']->dag_no);

        $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);


        if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
            $this->PropChainModel->updateCmpFlag($misc_case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
            // if mismatch case get the view mismatch case button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($misc_case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);
        }

        $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
        $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

        if ($data['ulpinCheck'] == 1) {
            $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
            if (isset($checkPropAndChithaAndUlpn['old_ulpin']))
                $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
            else
                $data['old_ulpin'] = "";
        }

        // if property does not exists get create asset button
        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
            $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
        }
        $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
        $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
        $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
        $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];

        // hidden fields
        $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
        $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
        $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
        $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

         // bhunaksha area cmp
         $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
         $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
         $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
         $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1 && $data['miscCaseInfo']->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $params = [
          'case_no'          => $misc_case_no,
          'service_code'     => 6,
          'remarks'          => 'Name Correction',
          'accessed_entity'  => 'Aadhaar Name, DOB, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $data['_view'] = 'NameCorrection/v2/finalOrderPassADCNameCorrect';
        $this->load->view('layouts/main',$data);    
    }

        public function finalOrderADCNameCorrection_save()
        {
            // echo "<pre>";
            // var_dump($_POST);die;
            //checking for empty remark field
            $this->form_validation->set_rules('adc_report', 'Remarks', 'required|trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message',"ADC Remark field is required");
                redirect($_SERVER['HTTP_REFERER']);
            }
            else
            {
                if(!isset($_POST['application_no']) || !isset($_POST['ord_type_code']) || !isset($_POST['ord_passby_desig']) || !isset($_POST['dag_no']) || !isset($_POST['lm_code']) || !isset($_POST['lm_sign_date']) || !isset($_POST['adc_report']) || !isset($_POST['misc_case_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['ord_passby_sign_yn']) || !isset($_POST['lm_sign']) || !isset($_POST['co_sign']) || !isset($_POST['ord_date']) || $_POST['application_no']=='' || $_POST['ord_type_code']=='' || $_POST['ord_passby_desig']=='' || $_POST['dag_no']=='' || $_POST['lm_code']=='' || $_POST['lm_sign_date']=='' || $_POST['adc_report']=='' || $_POST['misc_case_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['ord_date']=='') {
                    //ERRNMECORRFOCO0001
                    log_message('error', 'The required fields are empty. Error: ERRNMECORRFOCO0001');
                    $this->session->set_flashdata('message', "The required fields are empty. Error: ERRNMECORRFOCO0001");
                    redirect(base_url('index.php/NameCorrection/COFinalOrderMiscCase1/06'));
                }

                //check for Malicious
                $validquery = checkRequestValidQuery($_POST);
                if($validquery['status']=='n') {
                    //ERRNMECORRFOCO0021
                    log_message('error', $validquery['messages'] .'Error: ERRNMECORRFOCO0021');
                    $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRFOCO0021');
                    redirect(base_url('index.php/home'));
                }

                //syntax validation
                $validAppNo = applicationNumberValidation($_POST['application_no']);
                $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
                if(!empty($validAppNo)) {
                    //ERRNMECORRFOCO0002
                    log_message('error', 'Application No. cant have special characters. Error: ERRNMECORRFOCO0002');
                    $this->session->set_flashdata('message', "Application No. cant have special characters. Error: ERRNMECORRFOCO0002");
                    redirect(base_url('index.php/NameCorrection/COFinalOrderMiscCase1/06'));
                }
                if(!empty($validCaseNo)) {
                    //ERRNMECORRFOCO0003
                    log_message('error', 'Case No. cant have special characters. Error: ERRNMECORRFOCO0003');
                    $this->session->set_flashdata('message', "Case No. cant have special characters. Error: ERRNMECORRFOCO0003");
                    redirect(base_url('index.php/NameCorrection/COFinalOrderMiscCase1/06'));
                }
                if(!preg_match('/^[0-9]*$/', $_POST['misc_case_petition_no'])) {
                    //ERRNMECORRFOCO0004
                    log_message('error', 'Case Petition No. must be numerical. Error: ERRNMECORRFOCO0004');
                    $this->session->set_flashdata('message', "Case Petition No. must be numerical. Error: ERRNMECORRFOCO0004");
                    redirect(base_url('index.php/NameCorrection/COFinalOrderMiscCase1/06'));
                }

                $validreport = specialCharacterCheckingInInput($_POST['adc_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validreport['status']=='n') {
                    //ERRNMECORRFOCO0005
                    log_message('error', 'CO Report has illegal characters. Error: ERRNMECORRFOCO0005');
                    $this->session->set_flashdata('message', "CO Report has illegal characters. Error: ERRNMECORRFOCO0005");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validref = specialCharacterCheckingInInput($_POST['ord_ref_let_no'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validref['status']=='n') {
                    //ERRNMECORRFOCO0006
                    log_message('error', 'Reference No. has illegal characters. Error: ERRNMECORRFOCO0006');
                    $this->session->set_flashdata('message', "Reference No. has illegal characters. Error: ERRNMECORRFOCO0006");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validwrt1 = specialCharacterCheckingInInput($_POST['wrt1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validwrt1['status']=='n') {
                    //ERRNMECORRFOCO0007
                    log_message('error', 'WRT Order 1 has illegal characters. Error: ERRNMECORRFOCO0007');
                    $this->session->set_flashdata('message', "WRT Order 1 has illegal characters. Error: ERRNMECORRFOCO0007");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validwrt2 = specialCharacterCheckingInInput($_POST['wrt2'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validwrt2['status']=='n') {
                    //ERRNMECORRFOCO0008
                    log_message('error', 'WRT Order 2 has illegal characters. Error: ERRNMECORRFOCO0008');
                    $this->session->set_flashdata('message', "WRT Order 2 has illegal characters. Error: ERRNMECORRFOCO0008");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validwrt3 = specialCharacterCheckingInInput($_POST['wrt3'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validwrt3['status']=='n') {
                    //ERRNMECORRFOCO0009
                    log_message('error', 'WRT Order 3 has illegal characters. Error: ERRNMECORRFOCO0009');
                    $this->session->set_flashdata('message', "WRT Order 3 has illegal characters. Error: ERRNMECORRFOCO0009");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validwrt4 = specialCharacterCheckingInInput($_POST['wrt4'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validwrt4['status']=='n') {
                    //ERRNMECORRFOCO0010
                    log_message('error', 'WRT Order 4 has illegal characters. Error: ERRNMECORRFOCO0010');
                    $this->session->set_flashdata('message', "WRT Order 4 has illegal characters. Error: ERRNMECORRFOCO0010");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }
                $pattern = '/&[a-z]{3,5};/i';
                // $str = preg_replace('/\s+/', ' ', strip_tags($reqVal, ['script']));
                $validguard = specialCharacterCheckingInInput(preg_replace($pattern, '', preg_replace('/\s+/', ' ', strip_tags(trim($_POST['infavor_of_guardian']), ['script']))), ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                // $validguard = specialCharacterCheckingInInput($_POST['infavor_of_guardian'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validguard['status']=='n') {
                    //ERRNMECORRFOCO0011
                    log_message('error', 'Infavor Guardian field has illegal characters. Error: ERRNMECORRFOCO0011');
                    $this->session->set_flashdata('message', "Infavor Guardian field has illegal characters. Error: ERRNMECORRFOCO0011");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }
                $validaddr1 = specialCharacterCheckingInInput(preg_replace($pattern, '', preg_replace('/\s+/', ' ', strip_tags($_POST['infavor_of_add1'], ['script']))), ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                // $validaddr1 = specialCharacterCheckingInInput($_POST['infavor_of_add1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validaddr1['status']=='n') {
                    //ERRNMECORRFOCO0012
                    log_message('error', 'Address 1 field has illegal characters. Error: ERRNMECORRFOCO0012');
                    $this->session->set_flashdata('message', "Address 1 field has illegal characters. Error: ERRNMECORRFOCO0012");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }
                $validaddr2 = specialCharacterCheckingInInput(preg_replace($pattern, '', preg_replace('/\s+/', ' ', strip_tags($_POST['infavor_of_add2'], ['script']))), ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                // $validaddr2 = specialCharacterCheckingInInput($_POST['infavor_of_add2'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validaddr2['status']=='n') {
                    //ERRNMECORRFOCO0013
                    log_message('error', 'Address 2 field has illegal characters. Error: ERRNMECORRFOCO0013');
                    $this->session->set_flashdata('message', "Address 2 field has illegal characters. Error: ERRNMECORRFOCO0013");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }
                $validgrel = specialCharacterCheckingInInput(preg_replace($pattern, '', preg_replace('/\s+/', ' ', strip_tags($_POST['infav_of_guar_relation'], ['script']))), ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                // $validgrel = specialCharacterCheckingInInput($_POST['infav_of_guar_relation'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
                if($validgrel['status']=='n') {
                    //ERRNMECORRFOCO0014
                    log_message('error', 'Input has illegal characters. Error: ERRNMECORRFOCO0014');
                    $this->session->set_flashdata('message', "Input has illegal characters. Error: ERRNMECORRFOCO0014");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                $validname = specialCharacterCheckingInInput($_POST['infavor_of_name'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ','@']);
                if($validname['status']=='n') {
                    //ERRNMECORRFOCO0015
                    log_message('error', 'Input has illegal characters. Error: ERRNMECORRFOCO0015');
                    $this->session->set_flashdata('message', "Input has illegal characters. Error: ERRNMECORRFOCO0015");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['lm_sign_date']) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $_POST['lm_sign_date'])) {
                    //ERRNMECORRFOCO0016
                    log_message('error', 'Input Dates not in format. Error: ERRNMECORRFOCO0016');
                    $this->session->set_flashdata('message', "Input Dates not in format. Error: ERRNMECORRFOCO0016");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }
                // if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['sk_sign_date']) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $_POST['sk_sign_date'])) {
                //     //ERRNMECORRFOCO0017
                //     log_message('error', 'Input Dates not in format. Error: ERRNMECORRFOCO0017');
                //     $this->session->set_flashdata('message', "Input Dates not in format. Error: ERRNMECORRFOCO0017");
                //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                // }
                if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['ord_date']) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $_POST['ord_date'])) {
                    //ERRNMECORRFOCO0018
                    log_message('error', 'Input Dates not in format. Error: ERRNMECORRFOCO0018');
                    $this->session->set_flashdata('message', "Input Dates not in format. Error: ERRNMECORRFOCO0018");
                    redirect(base_url('index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
                }

                //authorization
                // $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'ADC', $_POST['misc_case_no']);
                // if($response['status']=='n') {
                //     //ERRNMECORRFOCO0019
                //     log_message('error', $response['messages'] .' Error: ERRNMECORRFOCO0019');
                //     $this->session->set_flashdata('message', $response['messages'] ." Error: ERRNMECORRFOCO0019");
                //     redirect(base_url('index.php/home'));
                // }

                //user authentication
                // $sessionData = $this->session->all_userdata();
                // if(empty($sessionData)) {
                //      //ERRNMECORRFOCO0019
                //      log_message('error', 'User not logged in. Error: ERRNMECORRFOCO0019');
                //     $this->session->set_flashdata('message', "User not logged in. Error: ERRNMECORRFOCO0019");
                //     redirect(base_url('index.php/home'));
                // }

                //user authorization
                // if($sessionData['user_desig_code']!='CO' || $sessionData['dist_code']!=$caseInfo->dist_code || $sessionData['subdiv_code']!=$caseInfo->subdiv_code || $sessionData['cir_code']!=$caseInfo->cir_code) {
                //     //ERRNMECORRFOCO0020
                //     log_message('error', 'User not authorized. Error: ERRNMECORRFOCO0020');
                //     $this->session->set_flashdata('message', "User not authorized. Error: ERRNMECORRFOCO0020");
                //     redirect(base_url('index.php/home'));
                // }
                $caseInfoEsc = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
                if($caseInfoEsc->es_flag == 1 && ESCALATION_ENABLE == 1)
                {
                    $executionDate = date('Y-m-d- H-i-s');
                    $user_code = $this->session->userdata('user_code');
                    $user_desig_code = $this->session->userdata('user_desig_code');
                    $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate,$dist_code,$caseInfoEsc->misc_case_no,$user_code,$user_desig_code,'NCOR');
                    log_message("error", "#ESC2567, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
                    if($escalationUpdateTimeFrame['responseType'] == 1)
                    {
                        log_message("error", "#ESC2567, transaction-error in method 'NameCorrectionV2/adcPending' with case-no :". $caseInfoEsc->misc_case_no);
                        $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC2567)");
                        redirect(base_url() . "index.php/home");
                    }
                    ////////////////////END////////////////////////////
                }



                $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
                $val = $this->input->post();

                $misc_case_no = $val['misc_case_no'];
                $petition_no = $val['misc_case_petition_no'];

                $old_pet_name = trim($val['infavor_of_old_name']);
                $new_pet_name = trim($val['infavor_of_corrected_name']);

                $redirectUrl = base_url().'index.php/NameCorrectionV2/finalOrderADCNameCorrection?misc_case_no='.$misc_case_no.'&petition_no='.$petition_no;

                $adc_report = $val['adc_report'];
                $letter_no = $val['ord_ref_let_no'];
                $note_date = date('Y-m-d');

                // $miscCaseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
                $miscCaseInfo = $caseInfo;
                $dist_code = $miscCaseInfo->dist_code;
                $subdiv_code = $miscCaseInfo->subdiv_code;
                $cir_code = $miscCaseInfo->cir_code;
                $mouza_pargona_code = $miscCaseInfo->mouza_pargona_code;
                $lot_no = $miscCaseInfo->lot_no;
                $vill_code = $miscCaseInfo->vill_townprt_code;
                $patta_type_code = $miscCaseInfo->patta_type_code;
                $pattaType = $this->APCancellationModel->getPattaName($patta_type_code);
                $dag_no = trim($miscCaseInfo->dag_no);
                $patta_no = trim($miscCaseInfo->patta_no);
                $year_no = $miscCaseInfo->year_no;
                $user_code = $this->session->userdata('user_code');
                $co_code=$this->input->post('co_code');

                $data['info'] = $this->NameCorrectionModel->getPdarIDMisc($misc_case_no,$petition_no);
                $pdar_id = $data['info']->petition_pdar_id;

                $inFavID = $this->NameCorrectionModel->getMiscID($misc_case_no);
                $ord_date = date("Y-m-d", strtotime($val['ord_date']));

                $data['pdarinfo'] = $this->NameCorrectionModel->PdarInfo($dist_code, $subdiv_code, 
                $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, 
                $patta_type_code, $pdar_id);



                $this->db->trans_begin();
                ///////////////////START ///////////

                



                if($miscCaseInfo->es_flag == 1 && ESCALATION_ENABLE == 1 && $miscCaseInfo->out_of_esc == 0)
                {
                    $user_code = $this->session->userdata('user_code');
                    $serviceChoose = explode('/',$misc_case_no);
                    $next_date_of_hearing = $miscCaseInfo->next_date_of_hearing.date(' H:i:s');
                    $executionDate = $this->input->post('executionDate');

                    // log_message("error", "#POSTPARAMS3353 :".json_encode($_POST));

                    


                    $escalationUpdateStatus = $this->Escalationmodel->escalationAdcNameCorrReport($executionDate, $dist_code, $misc_case_no, $user_code);

                    log_message("error", "#ESC4008, transaction-error-STATUS======".json_encode($escalationUpdateStatus));                    

                    if($escalationUpdateStatus['responseType'] == 0)
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4008, transaction-error in method 'NameCorrectionV2/adcPending' with case-no :". $misc_case_no);
                        $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC4008)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }


                //==========check dag pending in blockchain or not=================
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                      $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$dag_no);
                      if($checkVal === false)
                      {
                          $this->db->trans_rollback();
                          $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6166 : You cannot procced as dag no is pending for property chain update...");
                          redirect(base_url() . "index.php/home");
                      }
                }
                ///=============end CODE=====================


                //check if both old and corrected name are same
                if($old_pet_name == $new_pet_name){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPET001: Existing Name and Corrected Name are alike 
                        for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#ERRPET001: Both Current Petitioner Name and Corrected name is seems to be alike for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //check dag no is exist or not
                $check_dag_no = $this->NameCorrectionModel->getPdarDAGNOMisc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
                //$dag_available = array_column($check_dag_no, 'dag_no');
                
                //if ((!in_array($dag_no, $dag_available))){
                if (empty($check_dag_no)){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDAG001: Dag No does not exist 
                        for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#ERRDAG001: The applied DAG NO or PATTADAR(s) might not exit in the given patta for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //check data if already exist in misc_case_basic
                $misc_case_basic = $this->db->query("SELECT misc_case_no FROM 
                misc_case_basic WHERE status=? AND user_code=? AND operation=?
                AND misc_case_no=? ", array('10', $user_code, 'E', $misc_case_no));
                if($misc_case_basic->num_rows() > 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#EXISTMCBOO1: Data alaready exist in 
                    misc_case_basic for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#EXISTMCBOO1: Same detail already available for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //check data if already exist in t_chitha_rmk_ordbasic
                $t_chitha_rmk_ordbasic = $this->db->query("SELECT ord_no FROM 
                t_chitha_rmk_ordbasic WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
                AND ord_no=? AND dag_no=? AND year_no=?",
                array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_code, $misc_case_no, $dag_no, $year_no));
                //echo $this->db->last_query(); return;


                if($t_chitha_rmk_ordbasic->num_rows() > 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#EXISTTCROB3: Data alaready exist in 
                    t_chitha_rmk_ordbasic for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#EXISTTCROB3: Same detail already available for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //check data if already exist in t_chitha_rmk_infavor_of
                $t_chitha_rmk_infavor_of = $this->db->query("SELECT ord_no FROM 
                t_chitha_rmk_infavor_of WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
                AND ord_no=? AND dag_no=? AND year_no=?",
                array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_code, $misc_case_no, $dag_no, $year_no));

                if($t_chitha_rmk_infavor_of->num_rows() > 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#EXISTTCRIFO4: Data alaready exist in 
                    t_chitha_rmk_infavor_of for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#EXISTTCRIFO4: Same detail already available for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $sql = "SELECT max(note_no)+1 AS note_no FROM misc_case_process_reports 
                WHERE misc_case_no = ?";
                $result = $this->db->query($sql, array($misc_case_no))->row();
                $note_no = $result->note_no;
                
                //insertion in misc_case_process_reports
                $processReport = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'note_no' => $note_no,
                    'misc_case_no' => $misc_case_no,
                    'co_fresh_proceeding' => 'Y',
                    'process_note' => $adc_report,
                    'note_date' => $note_date,
                    'user_code' => $user_code,
                    'operation' => 'c',
                    'misc_case_petition_no' => $petition_no
                ];
                $ins = $this->db->insert("misc_case_process_reports", $processReport);
                if($ins != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#NCMCPR001: Insertion failed in misc_case_process_reports 
                    for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NCMCPR001: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

               //  $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$adc_report);


               // if($proInsert==false || $proInsert===false)
               //  {
               //      log_message('error', "#MISCCOF001:".$this->db->last_query());
               //      $this->db->trans_rollback();
               //      $this->session->set_flashdata('message', "Updation failed(#MISCCOF001)".$misc_case_no);
               //      redirect(base_url() . "index.php/home");
               //  }

                $proID=$this->rtpsmodel->maxProceedingID($misc_case_no);
                $pro_array=array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'case_no'=>$misc_case_no,
                    'proceeding_id'=>$proID,
                    'status'=>'final',
                    'date_of_hearing'=>date('Y-m-d'),
                    'co_order'=>$adc_report,
                    'user_code'=> $user_code,
                    'date_entry'=>date('Y-m-d G:i:s'),
                    'operation'=>'E',
                    //'ip' => $this->utilityclass->get_client_ip()
                    );
                $proInsert = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
                if($proInsert==false || $proInsert===false)
                {
                    log_message('error', "#MISCCOF001:".$this->db->last_query());
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Updation failed(#MISCCOF001)".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                }

                //insertion in t_chitha_rmk_ordbasic
                $tchithaOrdBasic = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_no,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'ord_no' => $misc_case_no,
                    'ord_type_code' => $val['ord_type_code'],
                    'case_no' => $misc_case_no,
                    'ord_passby_sign_yn' => $val['ord_passby_sign_yn'],
                    'ord_passby_desig' => $val['ord_passby_desig'],
                    'ord_ref_let_no' => $letter_no,
                    'lm_code' => $val['lm_code'],
                    'lm_sign_yn' => $val['lm_sign'],
                    'lm_sign_date' => date('Y-m-d', strtotime($val['lm_sign_date'])),
                    'co_code' => $co_code,
                    'co_sign_yn' => $val['co_sign'],
                    'co_ord_date' => date('Y-m-d', strtotime($val['co_sign_date'])),
                    'ord_date' => $ord_date,
                    'wrt_order1' => $val['wrt1'],
                    'wrt_order2' => $val['wrt2'],
                    'wrt_order3' => $val['wrt3'],
                    'wrt_order4' => $val['wrt4']    
                ];
                $tchithaIns = $this->db->insert("t_chitha_rmk_ordbasic", $tchithaOrdBasic);
                if($tchithaIns != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#NCTCRO002: Insertion failed in t_chitha_rmk_ordbasic 
                    for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NCTCRO002: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //insertion in t_chitha_rmk_infavor_of
                $tchithaInfavor = [
                    'dist_code' => $dist_code,
                    'subdiv_code' =>$subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_no,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'infavor_of_id'=> $inFavID+1,
                    'ord_no' => $misc_case_no,
                    'ord_date' => $ord_date,
                    'patta_type_code' => $patta_type_code,
                    'patta_no' => $patta_no,
                    'pdar_id'=>  $pdar_id,
                    'infavor_of_name' => $val['infavor_of_name'],
                    'infavor_of_guardian' => $val['infavor_of_guardian'],
                    'infav_of_guar_relation' => $val['infav_of_guar_relation'],
                    'infavor_of_add1' => $val['infavor_of_add1'],
                    'infavor_of_add2' => $val['infavor_of_add2'],
                    'infavor_of_corrected_name' => $val['infavor_of_corrected_name'],
                    'by_right_of'=>'06',
                    'land_area_b'=>0,
                    'land_area_k'=>0,
                    'land_area_lc'=>0,
                    'land_area_g'=>0,
                    'land_area_kr'=>0,
                    'revenue'=>0,
                    'self_declaration' => $data['info']->self_declaration,
                    'id_ref_no' => $data['info']->id_ref_no,
                    'auth_type' => $data['info']->auth_type,
                    'photo' => $data['info']->photo
                ];
                $tchithaInfavorIns = $this->db->insert("t_chitha_rmk_infavor_of", $tchithaInfavor);
                if($tchithaInfavorIns != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#NCTCRIO003: Insertion failed in t_chitha_rmk_infavor_of 
                    for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NCTCRIO003: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //update in misc_case_basic
                $updateBasic = [
                    'date_of_operation' => $note_date,
                    'status' => '10',
                    'user_code' => $user_code,
                    'operation' => 'E'
                ];
                $this->db->where('misc_case_no', $misc_case_no);
                $this->db->update('misc_case_basic', $updateBasic);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#NCMCB004: Updation failed in misc_case_basic 
                    for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NCMCB004: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
                //Additional File Upload Integration done ---------02022023----
                //START//------
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
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                    {
                                        // todo error show file allow type not match
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                    if($size > UPLOAD_MAX_SIZE)
                                    {
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                }
                                else
                                {
                                    $this->db->trans_rollback();
                                    $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                                    redirect(base_url() . "index.php/home");
                                }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                }
                    ///////////////////Insert attached file////////////////////////
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
                            $replaceCase=str_replace("/","-",$misc_case_no);
                            $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                            $config['upload_path']   = MANUAL_ATTACHMENT_MISCASE;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']  = UPLOAD_MAX_SIZE;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file'))
                            {
                                $document= array(
                                    'case_no'   => $misc_case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type'  => $_FILES['file']['type'],
                                    'file_path'  => MANUAL_ATTACHMENT_MISCASE. $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type'   => 'NC',
                                );
                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRNCORC0003: Insertion failed in supportive document  Case No '.$misc_case_no);
                                    $this->session->set_flashdata('error_data', "#ERRNCORC0003: Uploading Falied of Name Correction case no : ".$misc_case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRNCORC0004: Uploading failed in supportive document Case No '.$misc_case_no);
                                $this->session->set_flashdata('error_data', "#ERRNCORC0004: Uploading Failed of Name Correction for case no : ".$misc_case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }

                // die;
                $updateFirstParty = [
                    'user_code' => $user_code,
                    'operation' => 'E'
                ];
                $this->db->where('misc_case_no', $misc_case_no);
                $this->db->update('misc_case_first_party', $updateFirstParty);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#NCMCFP005: Updation failed in misc_case_first_party 
                    for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NCMCFP005: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $ok = $this->updateChithaNameCorrection($misc_case_no, $petition_no);
                if ($ok != true)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #NCAUC006: Issue occured in updating Chitha for case no: ". $misc_case_no);            
                    $this->session->set_flashdata('message',"#NCAUC006: Final Submission failed for case no : ".$misc_case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                if($ok){

                    //autoupdate jamabandi starts here
                        $this->load->model('jamabandi/jamabandiAutoUpdateModel');
                        $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi(
                        $patta_no,
                        $patta_type_code,
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $lot_no,
                        $vill_code,
                        $misc_case_no
                        );
                        if ($jamaUpdate != 1) {
                            $this->db->trans_rollback();
                            log_message("error", " #NCUJ007: Issue occured in updating Jamabandi for case no: " . $misc_case_no);
                            $this->session->set_flashdata('message', "#NCUJ007: Final Submission failed 
                                    for case no : " . $misc_case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                        //autoupdate jamabandi ends here

                        $success = $this->DashboardDataFinal($misc_case_no);
                        $basundhara=$this->db->query("SELECT basundhara FROM basundhar_application 
                        WHERE dharitree=?", array($misc_case_no))->row()->basundhara;

                        if($basundhara)
                        {
                            $rtps=$this->rtpsmodel->checkRtpsService($basundhara);
                            if($rtps=='RTPS'){
                                $apilink=RTPS_API_LINK;
                            } else{
                                $apilink=API_LINK;
                            }
                            $curl_handle = curl_init();
                            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                                'application' => $basundhara,
                                'dharitree' => $misc_case_no,
                                'rmk' => 'Approved by ADC',
                                'status' => 'F',
                                'task' => 'ADC',
                                'pen'=>'Approved',
                                'penat'=>'Circle office'
                            )));
                            $result = curl_exec($curl_handle);
                    }
                    $save_chain_data=true;

                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {

                        $ulpinCheckFlag = $this->input->post('ulpinCheckFlag');
                        $compareCheckFlag = $this->input->post('compareCheckFlag');                        

                        if($ulpinCheckFlag==1 && $compareCheckFlag=='Y')
                        {
                            $this->load->model('propChain/PropChainModel');
                            //////////////////////////////////////////////////////////////////////////// property chain code /////////////////////////////////////////////////////////////

                            $ulpin = $this->input->post('ulpin');
                            $revenue = $this->input->post('chain_revenue');
                            $local_tax = $this->input->post('chain_local_tax');

                            $old_ulpin = $this->input->post('old_ulpin');
                            if ($old_ulpin == null)
                                $old_ulpin = "";
                            $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_code;

                            $certmnemonic = CERTMNEMONIC_NAMECORR;

                            $chain_dag = $dag_no;
                            $chain_patta = $patta_no;

                            $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $chain_patta, $chain_dag, $ulpin);

                            $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                            $bigha_chain = $land_area->dag_area_b;
                            $katha_chain = $land_area->dag_area_k;
                            $lessa_chain = $land_area->dag_area_lc;
                            $ganda_chain = $land_area->dag_area_g;

                            $land_class_code = $this->PropChainModel->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                            $property_signature = "base64 encoded signature";
                            $property_signer_key = "base64 encoded public key";

                            $office_code = $this->session->userdata('cir_code');

                            $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                            // since below parameters are not applicable sent empty string
                            $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";
                            // 

                            $update_params = array(
                                'pattadar_details' => $pattadar_details,
                                'location_id' => $location_id,
                                'property_id' => $property_id,
                                'reference_id' => $misc_case_no,
                                'dag_no' => $chain_dag,
                                'patta_no' => $chain_patta,
                                'patta_type_code' => $patta_type_code,
                                'land_class_code' => $land_class_code,
                                'bigha_chain' => $bigha_chain,
                                'katha_chain' => $katha_chain,
                                'lessa_chain' => $lessa_chain,
                                'ganda_chain' => $ganda_chain,
                                'certmnemonic' => $certmnemonic,
                                'property_signature' => $property_signature,
                                'property_signer_key' => $property_signer_key,
                                'office_code' => $office_code,
                                'user_code' => $user_code,
                                'ulpin' => $ulpin,
                                'old_ulpin' => $old_ulpin,
                                'revenue' => $revenue,
                                'local_tax' => $local_tax,
                                'new_patta_no' => $new_patta_no,
                                'new_dag_no' => $new_dag_no,
                                'old_revenue' => $old_revenue,
                                'old_local_tax' => $old_local_tax,
                                'old_land_class_code' => $old_land_class,
                                'new_bigha' => $new_bigha,
                                'new_katha' => $new_katha,
                                'new_lessa' => $new_lessa,
                                'new_ganda' => $new_ganda
                            );

                            $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
                            // echo "<pre>";
                            // // var_dump($this->input->post());
                            // var_dump($chain_update_data);
                            // $this->db->trans_rollback();
                            // die;

                            $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_update_data), $misc_case_no);

                        }
                        
                    }

                    if($save_chain_data)
                    {

                        $this->db->trans_commit();

                        $this->session->set_flashdata('message', "Final order for Name Correction for case no : ".$misc_case_no. " has successfuly submitted !!!");
                        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {

                            if($ulpinCheckFlag==1 && $compareCheckFlag=='Y')
                            {

                            redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($misc_case_no)));
                            }
                        }
                        redirect(base_url() . 'index.php/home');

                    }
                    elseif (!$save_chain_data) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Name Correction for case no " . $misc_case_no . " is not successfull. Error Code: #CHAINSAVENCERROR0001");
                        log_message('error', "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVENCERROR0001");
                        redirect(base_url() . 'index.php/home');
                    }
                    
                }
                else
                {         
                    $this->db->trans_rollback(); 
                    $this->session->set_flashdata('message', "Chitha Could not be updated for case no $misc_case_no. Contact Helpdesk with case no");
                    redirect(base_url() . 'index.php/home');     
                }
            }
        }


        public function LMStepReEsc() 
         {
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $config['base_url'] = base_url() . '/index.php/NameCorrectionV2/LMStepReEsc/';
            $data['countMiscCase'] = $this->NameCorrectionModelV2->getMiscCaseLMEsc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

            $cases['TotMisc'] = $this->NameCorrectionModelV2->getMiscCaseLMReEsc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)->result();
            $case_array = array();
            //$var_dump($case_array);
            foreach ($cases['TotMisc'] as $c) {
                $q = $this->db->query("select misc_case_type,misc_case_no,submission_date,out_of_esc from    misc_case_basic where lm_note_yn is  null and next_date_of_hearing is not null and fresh_yn='Y'")->row();
                array_push($case_array, $c);
            }
            $data['MisCases'] = $case_array;
            // log_message('error', '#109: From escalation_detail_table : '.json_encode($case_array));
            if(ESCALATION_ENABLE == 1){
            foreach($data['MisCases'] as $rows) {

                if($rows->es_flag == 1 && $rows->out_of_esc == 0){
                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);

                    log_message('error', '#109: From escalation_detail_table : '.json_encode($escRow));

                    // echo "<pre>";var_dump($escRow); die;
                    
                    if(!empty($escRow) && $escRow != null){
                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
                        log_message('error', '#112: Escalation details : '.json_encode($escData));
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                    
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
        }
            // $this->load->view('../views/NameCorrection/LMStep1', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'NameCorrection/v2/LMStep1RvtEsc';
            $this->load->view('layouts/main',$data);
        }

        public function revertToLm(){

        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            //escalation implementation================
            $case_no = $this->input->get('misc_case_no');
            $misc_data = $this->db->query("select es_flag, out_of_esc from  misc_case_basic where "
                                        . " misc_case_no='$case_no'")->row()->es_flag;
            $es_flag = $misc_data->es_flag;
            $out_of_esc = $misc_data->out_of_esc;
            $flag =false;
            $remaining_days_CO='';
            if($es_flag == 1 && ESCALATION_ENABLE == 1 && $out_of_esc == 0){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
                if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
                {
                    log_message("error", "#ESCNCOR4710, transaction-error in method 'NameCorrectionv2/revertToLm' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESCNCOR4710)");
                        redirect(base_url() . "index.php/home");
                }
                $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);

                //remaining days of CO==============
                $originalAllocationCO   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_CO= $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocationCO);
                if($remaining_days_LM == 0){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
            $data['es_flag'] = $es_flag;
            $data['flag'] = $flag;
            $data['remainingDaysCO'] = $remaining_days_CO;

            $data['_view'] = 'NameCorrection/v2/revertNCCaseToLM';
            $this->load->view('layouts/main',$data);
        }


        else if ($this->input->server('REQUEST_METHOD') == 'POST') {

        if(isset($_POST['application_no']) && $_POST['application_no']!=''){
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0014
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0014');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0014');
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validAppNo = applicationNumberValidation($_POST['application_no']);
            if(!empty($validAppNo)) {
                //ERRNMECORRCORVRT0001
                log_message('error', 'Application no. cant have special characters. Error: ERRNMECORRCORVRT0001');
                $this->session->set_flashdata("message", "Application no. cant have special characters. Error: ERRNMECORRCORVRT0001");
                redirect(base_url('index.php/home'));
            }

            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0002
                log_message('error', 'Required Case no is empty. Error: ERRNMECORRCORVRT0002');
                $this->session->set_flashdata("message", "Required Case no is empty. Error: ERRNMECORRCORVRT0002");
                redirect(base_url('index.php/home'));
            }
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0003
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0003');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0003");
                redirect(base_url('index.php/home'));
            }
    
            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_revert_report']) || $_POST['co_revert_report']=='') {
                //ERRNMECORRCORVRT0004
                log_message('error', 'CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004');
                $this->session->set_flashdata("message", "CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
    
            $validreport = specialCharacterCheckingInInput($_POST['co_revert_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0005
                log_message('error', 'CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005');
                $this->session->set_flashdata("message", "CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'CO', $_POST['misc_case_no'],'NMECORRCORVT');
         // dd($response);
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0006
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0006');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0006");
                redirect(base_url('index.php/home'));
                exit;
            }
            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0006
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0006');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0006");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code'] || $sessionData['user_desig_code']!='CO'){
            //     //ERRNMECORRCORVRT0007
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0007');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0007");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }
            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $application_no=$this->input->post('application_no');
            $case_no = $this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no = $petitionNo->misc_case_petition_no;
    
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_revert_report');

            $this->db->trans_begin();

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no

            );
            $this->db->insert("misc_case_process_reports", $userdata);

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$note);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#MISCLMR001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MISCLMR001)".$case_no);
                redirect(base_url() . "index.php/home");
            }
            
            $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");

            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no,
                'rmk' => 'forwared to LM',
                'status' => 'M',
                'task' => 'CO',
                'pen'=>'LM',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{

                //ESCALATION CODE INTEGRATION================SANMRI

                $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no,out_of_esc FROM misc_case_basic WHERE misc_case_no=?",array($case_no))->row();
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                if($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0)
                {
                    $allocation_days = null;
                    if($this->input->post('allocate_day') !=null){
                        $allocation_days = $this->input->post('allocate_day');
                    }
                    $service_code = 6;
                    $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLMNCOR($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$query1->mouza_pargona_code,$query1->lot_no,$allocation_days);
                    log_message("error", "#ESCNCOR4904, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){

                        log_message("error", "#ESCNCOR490421, transaction-error in method 'NameCorrectionv2/revertToLm' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESCNCOR490421)");
                        redirect(base_url() . "index.php/home");
                    }
                }


                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Reverted to LM for correction of remark #$case_no ");
                redirect(base_url() . "index.php/home");
            }
        }
        else{
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0015
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0015');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0015');
                redirect(base_url('index.php/home'));
            }
            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0008
                log_message('error', 'Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008');
                $this->session->set_flashdata("message", "Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008");
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0009
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0009');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0009");
                redirect(base_url('index.php/home'));
            }

            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_report1']) || $_POST['co_report1']=='') {
                //ERRNMECORRCORVRT0010
                log_message('error', 'CO Report is a required field. Error: ERRNMECORRCORVRT0010');
                $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECORRCORVRT0010");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            $validreport = specialCharacterCheckingInInput($_POST['co_report1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0011
                log_message('error', 'CO Report has illegal characters. Error: ERRNMECORRCORVRT0011');
                $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECORRCORVRT0011");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'CO', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0012
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0012');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0012");
                redirect(base_url('index.php/home'));
            }

            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0012
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0012');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0012");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code']){
            //     //ERRNMECORRCORVRT0013
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0013');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0013");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }

            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $case_no=$this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no=$petitionNo->misc_case_petition_no;
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_report1');

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no
            );
            $this->db->insert("misc_case_process_reports", $userdata);
            $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");
            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
       }

        $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
        redirect(base_url() . "index.php/home");
    }

    }


    public function LMStep2revert_save() {

        if(!isset($_POST['misc_case_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['lm_report']) || $_POST['misc_case_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['lm_report']=='' || !isset($_POST['official']) || $_POST['official']=='') {
            //ERRNMECORRLM0001
            log_message('error', 'Improper Inputs Error: ERRNMECORRLM0001');
            $this->session->set_flashdata('message', "Improper Inputs Error: ERRNMECORRLM0001");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECORRLM0009
            log_message('error', $validquery['messages'] .'Error: ERRNMECORRLM0009');
            $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRLM0009');
            redirect(base_url('index.php/home'));
        }
        //syntax validation
        // $validAppNo = applicationNumberValidation($_POST['application_no']);
        $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        // if(!empty($validAppNo)) {
        //     //ERRNMECORRLM0002
        //     $this->session->set_flashdata('message', "Application No. cant have special characters. Error: ERRNMECORRLM0002");
        //     redirect(base_url('index.php/NameCorrection/LMStep1'));
        // }
        if(!empty($validCaseNo)) {
            //ERRNMECORRLM0003
            log_message('error', 'Case No. cant have special characters. Error: ERRNMECORRLM0003');
            $this->session->set_flashdata('message', "Case No. cant have special characters. Error: ERRNMECORRLM0003");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        if(!preg_match('/^[0-9]*$/', $_POST['misc_case_petition_no'])) {
            //ERRNMECORRLM0004
            log_message('error', 'Case Petition No. must be numerical. Error: ERRNMECORRLM0004');
            $this->session->set_flashdata('message', "Case Petition No. must be numerical. Error: ERRNMECORRLM0004");
            redirect(base_url('index.php/NameCorrection/LMStep1'));
        }
        $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
        $lmrep = preg_replace('/&[a-z]{3,5};/i', '', preg_replace('/\s+/', ' ', strip_tags($_POST['lm_report'], ['script'])));
        $validreport = specialCharacterCheckingInInput($lmrep, ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        // $validreport = specialCharacterCheckingInInput($_POST['lm_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validreport['status']=='n') {
            if($caseInfo->misc_case_type=='07') {
                //ERRNMECANCLM0005
                log_message('error', 'LM Report has illegal characters. Error: ERRNMECANCLM0005');
                $this->session->set_flashdata('message', "LM Report has illegal characters. Error: ERRNMECANCLM0005");
                redirect(base_url('index.php/NameCancellation/LMStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else if($caseInfo->misc_case_type=='06') {
                //ERRNMECORRLM0006
                log_message('error', 'LM Report has illegal characters. Error: ERRNMECORRLM0006');
                $this->session->set_flashdata('message', "LM Report has illegal characters. Error: ERRNMECORRLM0006");
                redirect(base_url('index.php/NameCorrection/LMStep2?misc_case_no='.$_POST['misc_case_no'].'&petition_no='. $_POST['misc_case_petition_no']));
            }
            else{
                $this->session->set_flashdata('message', "LM Report has illegal characters.");
                redirect(base_url('index.php/home'));
            }  
        }
        //authorization
        if($caseInfo->misc_case_type=='07') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'LM', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECANCLM0007
                log_message('error', $response['messages'] .'. Error: ERRNMECANCLM0007');
                $this->session->set_flashdata('message', $response['messages'].". Error: ERRNMECANCLM0007");
                redirect(base_url('index.php/home'));
            }
        }
        else if($caseInfo->misc_case_type=='06') {
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'LM', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRLM0007
                log_message('error', $response['messages'] .'. Error: ERRNMECORRLM0007');
                $this->session->set_flashdata('message', $response['messages'].". Error: ERRNMECORRLM0007");
                redirect(base_url('index.php/home'));
            }
        }
       


        //user authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     //ERRNMECORRLM0007
        //     log_message('error', 'User not logged in. Error: ERRNMECORRLM0007');
        //     $this->session->set_flashdata('message', "User not logged in. Error: ERRNMECORRLM0007");
        //     redirect(base_url('index.php/home'));
        // }

        //user authorization
        // if($sessionData['user_desig_code']!='LM' || $sessionData['dist_code']!=$caseInfo->dist_code || $sessionData['subdiv_code']!=$caseInfo->subdiv_code || $sessionData['cir_code']!=$caseInfo->cir_code || $sessionData['mouza_pargona_code']!=$caseInfo->mouza_pargona_code || $sessionData['lot_no']!=$caseInfo->lot_no) {
        //     //ERRNMECORRLM0008
        //     log_message('error', 'User not authorized. Error: ERRNMECORRLM0008');
        //     $this->session->set_flashdata('message', "User not authorized. Error: ERRNMECORRLM0008");
        //     redirect(base_url('index.php/home'));
        // }

        //$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no');
        $lm_report = addslashes($this->input->post('lm_report'));
        $note_date = date('Y-m-d');
        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $data['miscCaseInfo'] = $caseInfo;
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');

        $co_user_code = $this->input->post('official');

        $this->db->trans_begin();
        //$misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        //$year_no = $data['miscCaseInfo']->year_no;
        $sql = "select MAX(note_no)+1 AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($misc_case_no, $petition_no))->row()->note_no;

        $appStatus = false;
        if(isset($_POST['application_no']) && $_POST['application_no']!='') {
            $checkApp = $this->FormValidationModel->formValidationForPost($_POST, [
                'application_no'=>'Application No|required|application_no'
            ]);
            // $checkApp = postParamFormValidation($_POST, [
            //     'application_no'=>'application_no'
            // ]);
            if($checkApp['status']=='y') {
                $appStatus = true;
                $application_no = $this->input->post('application_no');
            }
        }

        $note_no = $result;
        $status = '1';
        $operation = 's';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no'  => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $lm_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $ins = $this->db->insert("misc_case_process_reports", $userdata);
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM001: Insertion failed in misc_case_process_reports for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM001: Unable to process misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");   
            return false;
        }

        $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$lm_report);


       if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#MISCLM001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MISCLM001)".$misc_case_no);
            redirect(base_url() . "index.php/home");
        }

        $updateSqlBasic = "update   misc_case_basic set lm_note_yn='Y',sk_note_yn='Y', operation='$operation', date_of_operation='$note_date',  "
                . " status='$status' , add_to_officer='$co_user_code' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
        $this->db->query($updateSqlBasic);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM002: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM002: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }

        $updateSqlFirstParty = "update   misc_case_first_party set operation='s' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
        $this->db->query($updateSqlFirstParty);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLM003: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLM003: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }
        //Additional File Upload Integration done ---------02022023----
        //START//------
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // die;
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
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                redirect(base_url() . "index.php/home");
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                redirect(base_url() . "index.php/home");
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
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
                    $replaceCase=str_replace("/","-",$misc_case_no);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT_MISCASE;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = UPLOAD_MAX_SIZE;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $misc_case_no,
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT_MISCASE .$fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'NC',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNCORC0001: Insertion failed in supportive document  Case No '.$misc_case_no);
                            $this->session->set_flashdata('error_data', "#ERRNCORC0001: Uploading Falied of Name Correction case no : ".$misc_case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }else{
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRNCORC0002: Uploading failed in supportive document Case No '.$misc_case_no);
                        $this->session->set_flashdata('error_data', "#ERRNCORC0002: Uploading Failed of Name Correction for case no : ".$misc_case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }
        // $this->db->trans_commit();
         ///////////////////////////////////
        $penUser='CO';
        $rmrk="LM submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////


        if($appStatus)
        {
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'LM report',
                'status' => 'M',
                'task' => 'LM',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }
         
            //ESCALATION ==============
            $es_flag = $this->db->query("select es_flag,out_of_esc from  misc_case_basic where misc_case_no=?",array($misc_case_no))->row();
            if(ESCALATION_ENABLE == 1 && $es_flag->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $es_flag->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($misc_case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROR005367 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================


            //ESCALATION START//////////
            if($es_flag->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag->out_of_esc == 0)
            {
                $executionDate = date('Y-m-d H:i:s');
                $user_code = $this->session->userdata('user_code');
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                

                $escalationUpdateStatus = $this->Escalationmodel->escalationLmNameCorrReport($executionDate, $dist_code, $subdiv_code, $cir_code, $misc_case_no, $user_code);

                log_message("error", "#ESCNCOR5389, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                if($escalationUpdateStatus['responseType'] == 0)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#ESCNCOR5396, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESCNCOR5396)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }



            $this->db->trans_commit();
            // $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
        if($caseInfo->misc_case_type=='07') {
            $this->session->set_flashdata('message', 'Name Cancellation Report Submitted !!');
        }
        else if($caseInfo->misc_case_type=='06') {
            $this->session->set_flashdata('message', 'Name Correction Report Submitted !!');
        }
       
        redirect(base_url() . "index.php/home/index");
    }

     public function LMStep2_revert() {

        $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);

        $sql1 = "select patta_no from    misc_case_basic where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result1 = $this->db->query($sql1);
        $patta_no = $result1->row()->patta_no;

        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        $data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);


        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $app_details = $this->db->query($application_no)->row();
        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }
        //$data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);

        $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($misc_case_no);
        $co_revert="select process_note from misc_case_process_reports where user_code like 'CO%' and operation='c' and misc_case_no='$misc_case_no' and co_fresh_proceeding='N' order by note_no desc ";
        $data['co_revert'] = $this->db->query($co_revert)->row();

        //FOR AADHAAR DETAILS-----------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //----END OF AADHAR DETAILS----------------


        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1 && $data['miscCaseInfo']->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $data['user'] = $this->rtpsmodel->usersForOfficeMisc($dist_code,$subdiv_code, $cir_code);

        $data['_view'] = 'NameCorrection/v2/LMStep2_revert';
        $this->load->view('layouts/main',$data);
    }


    public function revertToCO(){

        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $case_no = $this->input->get('misc_case_no');
            $misc_data = $this->db->query("select es_flag, out_of_esc from  misc_case_basic where "
                                        . " misc_case_no='$case_no'")->row();
            $es_flag = $misc_data->es_flag;
            $out_of_esc = $misc_data->out_of_esc;
            $flag =false;
            $remaining_days_ADC='';
            if($es_flag == 1 && ESCALATION_ENABLE == 1 && $out_of_esc == 0){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
                if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
                {
                    log_message("error", "#ESCNCOR5531, transaction-error in method 'NameCorrectionv2/revertToCO' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.NCOR- Error Code(#ESCNCOR5531)");
                        redirect(base_url() . "index.php/home");
                }
                $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);

                //remaining days of CO==============
                $originalAllocationADC   = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
                $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
                $remaining_days_ADC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysADC,$originalAllocationADC);
                if($remaining_days_CO == 0){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
            $data['es_flag'] = $es_flag;
            $data['flag'] = $flag;
            $data['remainingDaysCO'] = $remaining_days_ADC;


            $data['_view'] = 'NameCorrection/v2/revertNCCaseToCO';
            $this->load->view('layouts/main',$data);
        }


        else if ($this->input->server('REQUEST_METHOD') == 'POST') {

        if(isset($_POST['application_no']) && $_POST['application_no']!=''){
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0014
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0014');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0014');
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validAppNo = applicationNumberValidation($_POST['application_no']);
            if(!empty($validAppNo)) {
                //ERRNMECORRCORVRT0001
                log_message('error', 'Application no. cant have special characters. Error: ERRNMECORRCORVRT0001');
                $this->session->set_flashdata("message", "Application no. cant have special characters. Error: ERRNMECORRCORVRT0001");
                redirect(base_url('index.php/home'));
            }

            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0002
                log_message('error', 'Required Case no is empty. Error: ERRNMECORRCORVRT0002');
                $this->session->set_flashdata("message", "Required Case no is empty. Error: ERRNMECORRCORVRT0002");
                redirect(base_url('index.php/home'));
            }
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0003
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0003');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0003");
                redirect(base_url('index.php/home'));
            }
    
            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_revert_report']) || $_POST['co_revert_report']=='') {
                //ERRNMECORRCORVRT0004
                log_message('error', 'CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004');
                $this->session->set_flashdata("message", "CO Revert Report is a required field. Error: ERRNMECORRCORVRT0004");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
    
            $validreport = specialCharacterCheckingInInput($_POST['co_revert_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0005
                log_message('error', 'CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005');
                $this->session->set_flashdata("message", "CO Revert Report has illegal characters. Error: ERRNMECORRCORVRT0005");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }
            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'ADC', $_POST['misc_case_no'],'NMECORRCORVT');
         // dd($response);
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0006
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0006');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0006");
                redirect(base_url('index.php/home'));
                exit;
            }
            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0006
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0006');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0006");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code'] || $sessionData['user_desig_code']!='CO'){
            //     //ERRNMECORRCORVRT0007
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0007');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0007");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }
            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $application_no=$this->input->post('application_no');
            $case_no = $this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no = $petitionNo->misc_case_petition_no;
    
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'a';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_revert_report');

            $this->db->trans_begin();

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no

            );
            $this->db->insert("misc_case_process_reports", $userdata);

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$note);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#MISCLMR001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MISCLMR001)".$case_no);
                redirect(base_url() . "index.php/home");
            }
            
            $this->db->query("UPDATE misc_case_basic SET status='C' WHERE misc_case_no = '$case_no'");

            $penUser='CO';
            $rmrk='Revert to CO by ADC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no,
                'rmk' => 'forwared to CO',
                'status' => 'M',
                'task' => 'ADC',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{


                //ESCALATION START//////////
                if($caseInfo->es_flag == 1 && ESCALATION_ENABLE == 1 && $caseInfo->out_of_esc == 0)
                {
                    $executionDate = date('Y-m-d H:i:s');
                    $user_code = $this->session->userdata('user_code');
                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $caseInfo->subdiv_code;
                    $cir_code = $caseInfo->cir_code;
                    

                    $escalationUpdateStatus = $this->Escalationmodel->escalationADCRevertCoNCOR($executionDate,  $allocation_days, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);

                    log_message("error", "#ESCNCOR5389, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0)
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#ESCNCOR5396, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESCNCOR5396)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Reverted to CO for correction of remark #$case_no ");
                redirect(base_url() . "index.php/home");
            }
        }
        else{
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST);
            if($validquery['status']=='n') {
                //ERRNMECORRCORVRT0015
                log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0015');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0015');
                redirect(base_url('index.php/home'));
            }
            if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
                //ERRNMECORRCORVRT0008
                log_message('error', 'Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008');
                $this->session->set_flashdata("message", "Required Case no cannot be empty. Error: ERRNMECORRCORVRT0008");
                redirect(base_url('index.php/home'));
            }
            //syntax validation
            $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
            if(!empty($validCaseNo)) {
                //ERRNMECORRCORVRT0009
                log_message('error', 'Case No. is not valid. Error: ERRNMECORRCORVRT0009');
                $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECORRCORVRT0009");
                redirect(base_url('index.php/home'));
            }

            $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
            if(!isset($_POST['co_report1']) || $_POST['co_report1']=='') {
                //ERRNMECORRCORVRT0010
                log_message('error', 'CO Report is a required field. Error: ERRNMECORRCORVRT0010');
                $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECORRCORVRT0010");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            $validreport = specialCharacterCheckingInInput($_POST['co_report1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
            if($validreport['status']=='n') {
                //ERRNMECORRCORVRT0011
                log_message('error', 'CO Report has illegal characters. Error: ERRNMECORRCORVRT0011');
                $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECORRCORVRT0011");
                redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            }

            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CORRECT, 'CO', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECORRCORVRT0012
                log_message('error', $response['messages'] .' Error: ERRNMECORRCORVRT0012');
                $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECORRCORVRT0012");
                redirect(base_url('index.php/home'));
            }

            //authentication
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     //ERRNMECORRCORVRT0012
            //     log_message('error', 'User not authenticated. Error: ERRNMECORRCORVRT0012');
            //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECORRCORVRT0012");
            //     redirect(base_url('index.php/home'));
            // }
            //authorization
            
            // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code']){
            //     //ERRNMECORRCORVRT0013
            //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0013');
            //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0013");
            //     redirect(base_url('index.php/NameCorrection/finalOrderCONameCorrection?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
            // }

            $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
            $case_no=$this->input->post('misc_case_no');
            // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
            $petition_no=$petitionNo->misc_case_petition_no;
            // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
            $data['miscCaseInfo'] = $caseInfo;
            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
            $result = $this->db->query($sql, array($case_no, $petition_no));
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('co_report1');

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no
            );
            $this->db->insert("misc_case_process_reports", $userdata);
            $this->db->query("UPDATE misc_case_basic SET status='C' WHERE misc_case_no = '$case_no'");
            $penUser='CO';
            $rmrk='Revert to CO by ADC';
            $this->DashboardData($case_no,$penUser,$rmrk);
       }

        $this->session->set_flashdata('message',"Forwared to CO for correction of remark #$case_no ");
        redirect(base_url() . "index.php/home");
    }

    }

     public function COEscStep1Rvt() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->library('pagination');
        $db=  $this->session->userdata('db');
        $case_array = array();
        $searchKeyword=null;
        if($this->input->post('submitSearch')){
              $inputKeywords = $this->input->post('searchKeyword');
              $searchKeyword = strip_tags($inputKeywords);
              if(!empty($searchKeyword)){
                  $this->session->set_userdata('searchKeyword',$searchKeyword);
              }else{
                  $this->session->unset_userdata('searchKeyword');
              }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }

        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        $config['base_url'] = base_url().'index.php/NameCorrectionV2/COEscStep1Rvt';        
        $config['total_rows'] = $this->NameCorrectionModelV2->getMiscCases1();        
        $config['per_page'] = 10;        
        $config['uri_segment'] = 3;        
        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li>';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="prev">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li>';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li>';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li>';        
        $config['num_tag_close'] = '</li>';
        //var_dump($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);        
        $cases['links'] = $this->pagination->create_links();        
        $cases['MisCases'] = $this->NameCorrectionModelV2->getMiscCases2CORvt($config["per_page"], $page,$searchKeyword); 
        $cases['_view'] = 'NameCorrection/v2/COEscStep1Revert';
        $this->load->view('layouts/main',$cases);
    }

    
}
