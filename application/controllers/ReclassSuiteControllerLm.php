<?php
class ReclassSuiteControllerLm extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('patta/pattamodel');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('file');
    $this->load->helper('download');
    $this->load->model('basundhara/SettlementApiModel');
    $this->load->model('rtps/rtpsmodel');
    $this->load->model('SettlementModel/SettlementApModel');
    //$this->load->model('TeaGrant/LM/TeaGrantModel');
    $this->load->model('SettlementModel/SettlementVgrModel');
    $this->load->model('SettlementModel/SettlementCommonModel');
    $this->load->library('AES');
    $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
    $this->load->model('UtilsModel');
    $this->load->model('SettlementMb/SettlementCommonDcModel');
    $this->load->model('basundhara3/reclassModel');
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

  protected function dbswitch()
  {
    if ($this->session->userdata('dist_code') == "02") {
      $this->db = $this->load->database('dha3', true);
    } else if ($this->session->userdata('dist_code') == "05") {
      $this->db = $this->load->database('dha1', true);
    } else if ($this->session->userdata('dist_code') == "10") {
      $this->db = $this->load->database('dha24', true);
    } else if ($this->session->userdata('dist_code') == "13") {
      $this->db = $this->load->database('dha2', true);
    } else if ($this->session->userdata('dist_code') == "17") {
      $this->db = $this->load->database('dha4', true);
    } else if ($this->session->userdata('dist_code') == "15") {
      $this->db = $this->load->database('dha5', true);
    } else if ($this->session->userdata('dist_code') == "14") {
      $this->db = $this->load->database('dha6', true);
    } else if ($this->session->userdata('dist_code') == "07") {
      $this->db = $this->load->database('dha7', true);
    } else if ($this->session->userdata('dist_code') == "03") {
      $this->db = $this->load->database('dha8', true);
    } else if ($this->session->userdata('dist_code') == "18") {
      $this->db = $this->load->database('dha9', true);
    } else if ($this->session->userdata('dist_code') == "12") {
      $this->db = $this->load->database('dha13', true);
    } else if ($this->session->userdata('dist_code') == "24") {
      $this->db = $this->load->database('dha10', true);
    } else if ($this->session->userdata('dist_code') == "06") {
      $this->db = $this->load->database('dha11', true);
    } else if ($this->session->userdata('dist_code') == "11") {
      $this->db = $this->load->database('dha12', true);
    } else if ($this->session->userdata('dist_code') == "12") {
      $this->db = $this->load->database('dha13', true);
    } else if ($this->session->userdata('dist_code') == "16") {
      $this->db = $this->load->database('dha14', true);
    } else if ($this->session->userdata('dist_code') == "32") {
      $this->db = $this->load->database('dha15', true);
    } else if ($this->session->userdata('dist_code') == "33") {
      $this->db = $this->load->database('dha16', true);
    } else if ($this->session->userdata('dist_code') == "34") {
      $this->db = $this->load->database('dha17', true);
    } else if ($this->session->userdata('dist_code') == "21") {
      $this->db = $this->load->database('dha18', true);
    } else if ($this->session->userdata('dist_code') == "08") {
      $this->db = $this->load->database('dha19', true);
    } else if ($this->session->userdata('dist_code') == "35") {
      $this->db = $this->load->database('dha20', true);
    } else if ($this->session->userdata('dist_code') == "36") {
      $this->db = $this->load->database('dha21', true);
    } else if ($this->session->userdata('dist_code') == "37") {
      $this->db = $this->load->database('dha22', true);
    } else if ($this->session->userdata('dist_code') == "25") {
      $this->db = $this->load->database('dha23', true);
    } else if ($this->session->userdata('dist_code') == "39") {
      $this->db = $this->load->database('dha39', true);
    } else if ($this->session->userdata('dist_code') == "38") {
      $this->db = $this->load->database('dha25', true);
    }
  }

  protected function decodeBase64($encoded_string){
    $file_data = base64_decode($encoded_string);
    $file      = finfo_open();
    $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
    $file_type = explode('/', $mime_type)[0];
    $extension = explode('/', $mime_type)[1];
    log_message("error","No error occured".json_encode($mime_type));
    return $mime_type;
  }

  public function revertedCases()
  {
    $service_code       = $this->input->get('service');
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no             = $this->session->userdata('lot_no');
    $define_date        = define_date;
    $user_code          = $this->session->userdata('user_code');

    $cases['cases']     = $this->db->query("select *,ba.basundhara from reclass_suite_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date'")->result();

    $cases['_view'] = 'reclass_suite/LM/RevertedReclassSuiteLMList';
    $this->load->view('layouts/main', $cases);
  }

  // In case of Revert back from Circle officer CO
  public function secondProceeding()
  {
    $application_no = $this->input->get('case');
    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    $this->utilityclass->lmAuthBasicReclass($application_no);

    if(trim($this->utilityclass->checkIfAlreadyUpdatedByLmReclass($application_no)) != 'y'){
      $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
      redirect(base_url() . "index.php/home");
    }

    $basic                 = $this->reclassModel->getSettlementBasic($application_no);
    $applicants_buyers     = $this->reclassModel->getAllApplicantBuyers($application_no);
    $applicants_owners     = $this->reclassModel->getAllApplicantOwners($application_no);
    
    $applicants_dag_details= $this->reclassModel->getAllApplicantDagDetails($application_no);

    $lmdata        = [];

    $dags          = $this->reclassModel->getSettlementDag($application_no);
    $lmnotes       = $this->reclassModel->getSettlementTenantLmNote($application_no);
    $proceedings   = $this->reclassModel->getSettlementProceeding($application_no);
    $dhardocuments = $this->reclassModel->getDocuments($application_no);
    $nominee       = $this->reclassModel->getAllNomineeDetail($application_no);
    $existing_pattadar = $this->reclassModel->getAllExistingPattadar($application_no);
    $deed_applicant= '';//$this->reclassModel->getAllDeedPattadar($application_no);
    $family_tree   = '';//$this->reclassModel->getAllFamilyTree($application_no);

    $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    $lmdata['application_no'] = $applid = $this->utilityclass->getApplidFromCaseNoReclass($application_no);

    $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$applid'");

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
        $lmdata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
      }
      if(!empty($totalganda)){
          $lmdata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
      }
      $lmdata['additional_property']=$additional_property->result();
    }

      /// premium
      $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
      $lmdata['s_area'] = $s_area;

      $premiumData = $this->db->query("Select * from settlement_premium where case_no='$application_no' and is_final=1")->row();
      $lmdata['premiumData'] = $premiumData;
      // $lmdata['area_category'] = $this->SettlementCommonModel->getPremiumCategory();
      /// premium end

      $lmdata['basic'] = $basic;
      $lmdata['geo_date'] = $geo_date;

      $lmdata['applicants_buyers']      = $applicants_buyers;
      $lmdata['applicants_owners']      = $applicants_owners;
      $lmdata['nominee']                = $nominee;

      $lmdata['dags']                   = $dags;
      $lmdata['lmnotes']                = $lmnotes;
      $lmdata['proceedings']            = $proceedings;
      $lmdata['dhardocuments']          = $dhardocuments;

      $lmdata['existing_pattadar']      = $existing_pattadar;
      $lmdata['deed_applicant']         = $deed_applicant;
      $lmdata['family_tree']            = $family_tree;
      $lmdata['applicants_dag_details'] = $applicants_dag_details;

      


      //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
      $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
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
      // $url = API_LINK_MB3."serviceResponse?application_no=" . $application_no ;
      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
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
      $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
      $lmdata['document'] = $output->documents;
      $lmdata['query'] = $output->query;
      $lmdata['property'] = $output->property;
      $lmdata['aadhar'] = $output->aadhar;
      // $lmdata['nextKin'] = $output->nextKin;
      foreach ($output->selfDeclaration as $selfDec) {
          $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      // for guardian relation
      $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
      $row = $relation_executation->num_rows();
      if ($row != 0) {
          $lmdata['guar_rel'] = $relation_executation->result();
      }

      $applid_vlb = $this->utilityclass->getApplidFromCaseNoReclass($application_no);
      

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
      $lmdata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
      if($lmdata['sk_name'] == 'n')
      {
          //************if SK is not available then load CO */
          $lmdata['sk_availability'] = 'n';

          $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
      }
      else
      {
          $lmdata['sk_availability'] = 'y';
      }

      $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

      /// premium
      $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

      $premiumData = $this->db->query("Select * from settlement_premium where case_no='$application_no' and is_final=1")->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end


      //get data from settlement_ap_lmnote
      $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
          case_no='$application_no'")->row()->is_landless;
      $lmdata['apLmNote'] = $apLmNote;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
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

      $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);

      $lmdata['enc_case']= null;
      // if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
      // {
      //   $this->load->model('ApplicantChangeModel');
      //   $lmdata['deceased'] = $this->ApplicantChangeModel->getDeceasedData($basic['applid']);
      //   $lmdata['enc_case'] = $this->ApplicantChangeModel->ekycVerify($application_no, $basic['dist_code'], $basic['service_code']);
      // }


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

      //**************-js- if request_method not an update */
      if($_SERVER['REQUEST_METHOD'] != 'POST'){
          $lmdata['_view'] = 'reclass_suite/LM/RevertedReclassSuiteLMView';
          $this->load->view('layouts/main', $lmdata);
      }

      //*******-js- request_method for update */
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
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

          if($mStat == true)
          {
              foreach($lmdata['applicants_buyers'] as $applicantRow)
              {
                  if($applicantRow->is_applicant != 1)
                  {
                      if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
                      {
                          $mStatErr = true;   
                          break;
                      }
                  }
              }
          }
          // if($mStatErr == true)
          // {
          //     $data = array(
          //         'error' => '#ERR14233: Spouse details has to be added if you select applicant as married!!!' .$case_no,
          //     );
          //     echo json_encode($data);
          //     return false;
          // }

          $application_no = $this->utilityclass->getApplidFromCaseNoReclass($case_no);

          $is_prem_update = $this->input->post('prem_update');
          if($distCode == NULL)
          {
              redirect(base_url(). 'index.php/home/ReclassSuiteControllerLm?service='.RECLASS_ID);
          }
          if($case_no == NULL)
          {
              redirect(base_url(). 'index.php/home/ReclassSuiteControllerLm?service='.RECLASS_ID);
          }
          $this->load->library('form_validation');
          //  row_array
          $basic   = $this->reclassModel->getSettlementBasic($case_no);

         // var_dump($basic['uuid']);exit;

          //  result
          $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($case_no);
          $applicants_owners = $this->reclassModel->getAllApplicantOwners($case_no);
          
          $dags = $this->reclassModel->getSettlementDag($case_no);
          $lmnotes = $this->reclassModel->getSettlementTenantLmNote($case_no);
          $proceedings = $this->reclassModel->getSettlementProceeding($case_no);
          $dhardocuments = $this->reclassModel->getDocuments($case_no);

          $d=$basic["dist_code"];
          $s=$basic["subdiv_code"];
          $c=$basic["cir_code"];
          $m=$basic["mouza_pargona_code"];
          $l=$basic["lot_no"];
          $v=$basic["vill_townprt_code"];

          /// premium
          $lmdata['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
          $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

          $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
          $lmdata['premiumData'] = $premiumData;
          /// premium end

          $lmdata['basic']=$basic;
          $lmdata['geo_date']=$geo_date;
          $lmdata['applicants_buyers']=$applicants_buyers;
          $lmdata['applicants_owners']=$applicants_owners;

          $reservation = $this->SettlementVgrModel->getSettlementReservation($case_no);
          $lmdata['reservation'] = $reservation;

          $lmdata['dags']=$dags;
          $lmdata['lmnotes']=$lmnotes;
          $lmdata['proceedings']=$proceedings;
          $lmdata['dhardocuments']=$dhardocuments;



          //   calling API for self declaration data

          $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
          $basundhara = $this->db->query($sql)->row();

          $token = $this->utilityclass->createTokenJwt();
          $curl_handle = curl_init();
          curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
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
              redirect(base_url(). 'index.php/basundhara3/settlementCases');
          }
          if ($application_no == null) {
              redirect(base_url(). 'index.php/basundhara3/settlementCases');
          }

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

          //********validation bypass */
          $validation_bypass = 0;

          if(isset($_POST['lm_note']) && $_POST['lm_note'] == '2')
          {
              if(isset($_POST['rejected_reasons']))
              {

                  $validation_bypass_array = $this->getValidationBypass(RECLASS_ID);

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
              if(isset($_POST['lm_note']) && $_POST['lm_note'] == '2')
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
              //$this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
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
              $this->form_validation->set_rules('applicant_type', 'Applicant type', 'trim|required');
              //$this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
              // $this->form_validation->set_rules('encroacher_exist_vlb', 'Is Encroacher Exists in VLB ?', 'trim|required');
              //$this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
              $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');
             // $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
             // $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
             // $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
             // $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');
              // $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
             // $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
              //$this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
              //$this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');

              //$this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
              // $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
              $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
              $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
              //$this->form_validation->set_rules('roadside_reservation','','');
              $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

              //$this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
              //$this->form_validation->set_rules('caste', 'Caste', 'trim|required');
              $this->form_validation->set_rules('prem_update', 'Do you want to chnage the premium', 'trim|required');
              $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
	      if($is_prem_update=='YES')
	      {
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



              $display_old_nature_check=0;
              $dag_no_array = [];
              foreach ($lmdata['dags'] as $dag_area_cal) {
                  //******NCBTAD check  */
                  $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

                  if($ncBtadCheck > 0)
                  {
                      //*******throw error for NCBTAD */
                      log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                      $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                      redirect(base_url() . "index.php/home");
                  }


                  $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');

                  $this->form_validation->set_rules('reclass_option_'.$dag_area_cal->dag_no, 'Reclass Type', 'trim|required');

                  $this->form_validation->set_rules('wetland_verified_hidden'.$dag_area_cal->dag_no, 'Wetland Verified', 'trim|required');

                  $this->form_validation->set_rules('agritononagri_verified'.$dag_area_cal->dag_no, 'Agri-nonagri  Verified', 'trim|required');

                  $this->form_validation->set_rules('masterplan_notified'.$dag_area_cal->dag_no, 'Master Plan  Verified', 'trim|required');

                  // if (!is_null($dag_area_cal->nature_possession)){
                  //     $display_old_nature_check=0;

                  // }else{
                  //     $display_old_nature_check=1;

                  // }
                  // for barak valley
                  if (in_array($distCode, json_decode(BARAK_VALLEY))) {

                      $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                  }
                  else
                  {

                      $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                      $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                     
                  }

                  $dag_no_array[] = $dag_area_cal->dag_no;
              }

              //validate for geo tag photo incases of review cases
              $application_no_geo = $this->utilityclass->getApplidFromCaseNoReclass($case_no);

              $sql_geo = $this->db->query('select dag_no from supportive_document where applid in (?, ?) and file_name = ?', array($case_no, $application_no_geo, 'Geo Tag Photo'));

              $geo_result = $sql_geo->result();

              $geo_dag_no_array = array_map(function($item) {
                  return $item->dag_no;
              }, $geo_result);

              if(count($dag_no_array) != count($geo_dag_no_array)){
                  $geo_diff = array_diff($dag_no_array, $geo_dag_no_array);
                  $geo_err_dags = implode(", ", $geo_diff);

                 // $this->form_validation->set_rules('get_tag_validation', 'Geo Tag Photo requred for the dag(s) '.$geo_err_dags, 'trim|required');
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
                      $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                      $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                      $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                      $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                      $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                      $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                  }
              }
              else
              {
                  foreach ($additional_properties as $singleProperty)
                  {
                      $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                      $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                      $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                      $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                      $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                  }
              }

              $checkUrbanCon = trim($this->input->post('is_urban'));

              

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

          }


          if ($this->form_validation->run() == FALSE)
          {
              $lmdata['all_errors'] = validation_errors();
              if(isset($fileCount)){
                  $lmdata['fileCount'] = $fileCount;
              }
              $lmdata['err_return'] = true;
              $lmdata['_view'] = 'reclass_suite/Lm/RevertedReclassSuiteLMView';
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

              $applid_backup = $this->utilityclass->getApplidFromCaseNoReclass($case_no);

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


              $sql1 = "SELECT petition_no FROM reclass_suite_basic WHERE case_no = '$case_no'";
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

              // $sql = "SELECT pdar_cron_no FROM reclass_applicant WHERE case_no = '$case_no'";
              // $result = $this->db->query($sql);
              // if($result->num_rows() > 0)
              // {
              //     $cron_no = (int)$result->row()->pdar_cron_no + 1;
              // }
              // else
              // {
              //     $this->db->trans_rollback();
              //     log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
              //     $data = array(
              //         'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
              //     );
              //     echo json_encode($data);
              //     return false;
              // }
              


              $basicdataReclass = array(
                  'date_update' => date('Y-m-d G:i:s'),
                  'status' => 'X',
                  'user_code' => $this->session->userdata('user_code'),
                  'lm_code' => $this->session->userdata('user_code'),
                  'co_code' => $this->input->post('co_code'),
                  //'period_possession' => $this->input->post('period_possession'),
                  //'occupation_applicant' => $this->input->post('occupation_applicant'),
                  'from_office' => 'LM',
                  'pending_officer' => $pending_officer,
                  'pending_office' => $pending_officer,
                  'approve_by' => $approved_by,
                  'co_edit'=>null

                  /////////
              );

              if ($is_prem_update=='NO'){
                  unset($basic['approve_by']);
              }

              $this->db->where('case_no', $case_no);
              $this->db->update('reclass_suite_basic', $basicdataReclass);

              if ($this->db->affected_rows() == 0) {
                  $this->db->trans_rollback();
                  log_message('error', '#SETUP0001: Updation failed in reclass_suite_basic Dharitree Case No ' . $application_no);
                  $data = array(
                      'error' => "#SETUP0001: Registration of Reclassification suite basic failed for case no : " . $application_no,
                  );
                  echo json_encode($data);
                  return false;
              }

              // var_dump($basic['uuid']);exit;


              //*******to bypass 1 */
              if($validation_bypass == 0)
              {

              

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
                                  'mut_type'   => RECLASS_ID,
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


                  foreach ($lmdata['dags'] as $dagsland) {


                      // if ($display_old_nature_check == 1){
                      //     // $nature_entry_single= $this->input->post('nature_possession');
                      //     $nature_entry_single= null;
                      //     $nature_entry_multiple = $this->input->post('nature_possession'.$dags_landmark->dag_no);
                      // }else{
                      //     $nature_entry_multiple = $this->input->post('nature_possession'.$dags_landmark->dag_no);
                      // }

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

                      // $dag_details_update_arr = [
                      //     'landmark' => json_encode($landmark),
                      //     'nature_possession'=>$nature_entry_multiple,
                      // ];

                      ////newly added////
                      $reclass_option = $this->input->post('reclass_option_'.$dagsland->dag_no);

                        $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($lmdata['dags'][0]->dist_code, $lmdata['dags'][0]->subdiv_code, $lmdata['dags'][0]->cir_code, $lmdata['dags'][0]->mouza_pargona_code, $lmdata['dags'][0]->lot_no, $lmdata['dags'][0]->vill_townprt_code, $dagsland->dag_no))->row();
                            
                           //echo "<pre>"; var_dump($dag_area->dag_area_lc);$this->db->trans_rollback();exit;
                        $tot_bigha = $dag_area->dag_area_b;
                        $tot_katha = $dag_area->dag_area_k;
                        $tot_lessa = $dag_area->dag_area_lc;
                        $tot_ganda = $dag_area->dag_area_g;

                        if($reclass_option=="part_yes")
                        {
                            $applied_bigha = $this->input->post('bigha_part'.$dagsland->dag_no);
                            $applied_katha = $this->input->post('katha_part'.$dagsland->dag_no);
                            $applied_lessa = $this->input->post('lessa_part'.$dagsland->dag_no);

                            $dist_code = $this->input->post('dist_code');

                            if(in_array($dist_code, BARAK_VALLEY))
                            { // for barak valley
                              $total_dag_area = ($tot_bigha * 6400) + ($tot_katha * 320) + ($tot_lessa * 20) + $tot_ganda;
                              $total_dag_area_in_lessa = ($total_dag_area/6400);

                               $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                               $total_p_dag_in_lessa = ($total_p_dag_area/100);


                              if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                    $this->session->set_flashdata('message', "#PART0013: For Partial reclass, Applied area and total area of Dag can not be equal..You can choose Full reclass with Partition : ".$case_no);
                                    redirect(base_url() . "index.php/ReclassSuite/reclassSuiteRegistration");
                                    return false;
                                }

                                if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                    $this->session->set_flashdata('message', "#PART0013: For Partial reclass, Applied area can not be more than total area of Dag..You can choose Full reclass with Partition : ".$case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }

                            }

                            else
                            {
                            $total_dag_area = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa; //total area
                            $total_dag_area_in_lessa = ($total_dag_area/100);

                            $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                            $total_p_dag_in_lessa = ($total_p_dag_area/100);

                            if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                $this->session->set_flashdata('message', "#PART0013: For Partial reclass applied area and total area of Dag can not be equal..You can choose Full reclass with Partition : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                            if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                $this->session->set_flashdata('message', "#PART0013: For Partial reclass applied area can not be more than total area of Dag..You can choose Full reclass with Partition : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                            }

                            $lm_area_b = $applied_bigha;
                            $lm_area_k = $applied_katha;
                            $lm_area_lc = $applied_lessa;
                            $lm_area_g = 0;


                            $is_partion = 'Y';
                            $is_full_partition = 'N';

                            foreach ($_POST['pdar_selected_all'] as $selected) 
                            {
                               ///reclass partition//
                                $partition_array_lm = [
                                    'case_no' => $case_no,
                                    'from_office' => 'LM',
                                    'to_office' => $pending_officer,
                                    'status' => 'W',
                                    'dag_no' => $dagsland->dag_no,
                                    'pdar_id' =>$selected,
                                    'retain_old_dag'=>'0'
                                ];

                                $partition_array_lm = $this->db->insert('reclass_partition_info', $partition_array_lm);
                                if($partition_array_lm != 1){
                                    $this->db->trans_rollback();
                                    log_message('error', '#PART001: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                                    $this->session->set_flashdata('message', "#PART001: Registration of Reclassification failed for case no : ".$case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }
                            }  


                            if (isset($_POST['pdar_selected'])) 
                            {
                                foreach ($_POST['pdar_selected'] as $selected_pdar) 
                                {
                                   ///reclass partition//
                                    $chkpdar_array_lm = [
                                        'retain_old_dag'=>'1'
                                    ];

                                    $this->db->where('case_no', $case_no);
                                    $this->db->where('dag_no', $dagsland->dag_no);
                                    $this->db->where('pdar_id', $selected_pdar);
                                    $this->db->update('reclass_partition_info', $chkpdar_array_lm);
                                    if($this->db->affected_rows() <= 0)
                                    {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERROR0012: Updation failed in reclass_partition_info RTPS Case No '.$case_no);
                                        $data = array(
                                            'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                }
                            }
                        }
                        else if($reclass_option=="part_no")
                        {
                            $is_partion = 'N';
                            $is_full_partition = 'N';

                            $lm_area_b = null;
                            $lm_area_k = null;
                            $lm_area_lc = null;
                            $lm_area_g = null;
                        }
                        else if($reclass_option=="part_full_yes")
                        {
                            $is_partion = 'Y';
                            $is_full_partition = 'Y';

                            $lm_area_b = $tot_bigha;
                            $lm_area_k = $tot_katha;
                            $lm_area_lc = $tot_lessa;
                            $lm_area_g = $tot_ganda;
                        }
                        // else
                        // {
                        //     $is_partion = 'N';
                        // }

                        $wetland_verified = $this->input->post('wetland_verified_hidden'.$dagsland->dag_no);

                        if($wetland_verified=="YES")
                        {
                            $is_wet_land = 'Y';
                        }
                        else
                        {
                            $is_wet_land = 'N';
                        }

                        // var_dump($this->input->post('nature_possession'.$dagsland->dag_no));
                        // $this->db->trans_rollback();
                        // exit;

                        $masterplan_notified = $this->input->post('masterplan_notified'.$dagsland->dag_no);

                         $fmddata= [
                            'date_entry' => date('Y-m-d'),
                            'landmark'   => json_encode($landmark),
                            'nature_possession'=>$this->input->post('nature_possession'.$dagsland->dag_no),
                            'is_partition' => $is_partion,
                            'is_wet_land' => $is_wet_land,
                            'is_full_partition' => $is_full_partition,
                            'lm_area_b' =>$lm_area_b,
                            'lm_area_k' =>$lm_area_k,
                            'lm_area_lc'=>$lm_area_lc,
                            'lm_area_g' =>$lm_area_g,
                            'is_master_plan' => $masterplan_notified
                        ];

                      $this->db->where('case_no', $case_no);
                      $this->db->where('dag_no', $dagsland->dag_no);
                      $this->db->update('reclass_dag_details', $fmddata);

                      if ($this->db->affected_rows() == 0) {
                          $this->db->trans_rollback();
                          log_message('error', '#SETUP0333004: Updation failed in reclass_dag_details Dharitree Case No ' . $case_no);
                          $data = array(
                              'error' => "#SETUP0333004: Registration of reclass_dag_details failed for case no : " . $case_no,
                          );
                          echo json_encode($data);
                          return false;
                      }

                      $agritononagri_verified = $this->input->post('agritononagri_verified'.$dagsland->dag_no);

                        if($agritononagri_verified=="YES")
                        {
                            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));
                            if ($sql->num_rows() <= 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORAGRINAGRI0001: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRORAGRINAGRI0001: Registration of Reclassification failed for case no,Fill the agri to non agri column properly : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            else
                            {
                                $status = 1;

                                $fmddata= [
                                    'status' => $status
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->where('status', 0);
                                $this->db->update('reclass_dag_eligibility', $fmddata);

                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRORAGRINAGRI0002: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                                    $data = array(
                                        'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }


                                $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));

                                //var_dump($sql->row()->is_eligible);$this->db->trans_rollback();exit;

                                $is_eligible = $sql->row()->is_eligible;


                                $fmddata= [
                                    'is_agri_to_nonagri' =>'Y',
                                    'is_eligible' =>$is_eligible
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_details', $fmddata);
                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERROR0012: Updation failed in reclass_dag_details RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }
                        }


                        if($agritononagri_verified=="NO")
                        {
                            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));
                            if ($sql->num_rows() <= 0) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORAGRINAGRI0001: Updation failed in reclass_dag_eligibility RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRORAGRINAGRI0001: Registration of Reclassification failed for case no,Fill the agri to non agri column properly : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            else
                            {
                                $status = 1;

                                $fmddata= [
                                    'status' => $status
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->where('status', 0);
                                $this->db->update('reclass_dag_eligibility', $fmddata);

                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRORAGRINAGRI0002: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                                    $data = array(
                                        'error'=>"#ERRORAGRINAGRI0002: Registration of Reclassification failed for case no : ".$case_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }


                                $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility WHERE case_no = ? and dag_no = ?", array($case_no,$dagsland->dag_no));

                                //var_dump($sql->row()->is_eligible);$this->db->trans_rollback();exit;
                                $is_eligible = $sql->row()->is_eligible;


                                $fmddata= [
                                    'is_agri_to_nonagri' =>'N',
                                    'is_eligible' =>$is_eligible
                                ];
                                $this->db->where('case_no', $case_no);
                                $this->db->where('dag_no', $dagsland->dag_no);
                                $this->db->update('reclass_dag_details', $fmddata);
                                if($this->db->affected_rows() <= 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERROR0012: Updation failed in reclass_dag_details RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }
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
                  $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(SETTLEMENT_KHAS_LAND_ID);

                  $comment = addslashes($this->input->post('lm_note'));

                  $pro_class_lm = $this->input->post('protected_class_lm');
                  $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');



                  $lmnote=array(
                      'chitha_verified'=>$this->input->post('chitha_verified'),
        
                     // 'possession_verification'=>$this->input->post('possession_verification'),
                     // 'period_possession'=>date('Y-m-d'),
                      // 'nature_possession'=>$this->input->post('nature_possession'),
                     // 'nature_possession'=>$nature_entry_single,
                     // 'is_landless'=>$this->input->post('is_landless'),
                      //'land_falls'=>$this->input->post('land_falls'),
                     // 'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                     // 'roadside_reservation'=>$this->input->post('roadside_reservation'),
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
                      //'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                      //'landslide'            => $this->input->post('landslide'),
                      'erosion'            => $this->input->post('erosion'),
                      //'protected_class_lm' => $protected_class_lm,
                      //'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
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
                   
		  if($is_prem_update=='NO')
                  {
                    $this->db->trans_rollback();
                      log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No ' . $application_no);
                      $data = array(
                          'error' => "#SETUP0004: The premium should be updated by the LRA and subsequently verified for accuracy. " . $application_no,
                      );
                      echo json_encode($data);
                      return false;
                  }

              
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
                        //$sumMbAmount =0;

                        foreach ($lmdata['dags'] as $dag_premium) 
                        {
                            $ratetype=$this->input->post('rate_type'.$dag_premium->dag_no);
                            $proposed_lc_code=$this->input->post('prop_lc_code'.$dag_premium->dag_no);

                            $is_penalty = $this->input->post('is_penalty'.$dag_premium->dag_no);
                            $exist_lc_type = $this->input->post('rate_type'.$dag_premium->dag_no);

                            $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
                            where id=?",array($proposed_lc_code))->row();
                            $proc_lc_cat_code = $prop_lc_det->landclass_category_id;


                            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_premium->dag_no,'Y','N',0));

                            if ($sql->num_rows()>=1) 
                            {
                            $ratepr = 0;
                            $sum_area = 0;
                            }
                            else
                            {   
                            $ratepr2=$this->db->query("select prid,rate from reclass_premium_rate where exist_code='$ratetype' and prop_code='$proc_lc_cat_code' order by prid ")->row();
                            $ratepr = $ratepr2->rate;


                            $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ?", array($case_no,$dag_premium->dag_no));

                            $data2 = $sql2->row();
                            $sum_area = 0;
                            if($data2->is_partition=='Y' && $data2->is_full_partition=='N')
                            {
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                                {
                                    $dag_area =$this->db->query("SELECT  sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_premium->dag_no,$case_no))->row();
                                }
                                else
                                {
                                    $dag_area =$this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc)  as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_premium->dag_no,$case_no))->row();
                                }

                                $sum_area = $dag_area->sarea;
                            }

                            else
                            {
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                                {
                                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_premium->dag_no))->row();
                                }
                                else
                                {
                                    $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_premium->dag_no))->row();
                                }

                                $sum_area = $dag_area->sarea;

                            }
                            log_message('error','LASTQUERY==========='.$this->db->last_query());
                            if($exist_lc_type==1 && $proc_lc_cat_code==2)
                            {
                                if($sum_area<100)
                                {
                                    $ratepr = 0;
                                }
                            }
                            }

                            $prem_zonal=$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no);
                            $prem_zonal1 = $this->utilityclass->getZonalValue($dag_premium->dist_code,$basic['uuid'],$dag_premium->dag_no);

                            $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                            {
                                $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
                            }
                            else
                            {
                                $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
                            }

			    $sumMbAmount+= $sum_area * $premium_zonal_per_lessa;
			    log_message('error', '#RECLPENALTY001:SUMMB-AREA ' . $sum_area);
			    log_message('error', '#RECLPENALTY001:SUMMB-AMOUNT ' . $sumMbAmount);

                            /////////penalty case////////

                        $dagPenaltyArr = [
                            'is_penalty' => $is_penalty,
                            'exit_lc_by_lm' => $exist_lc_type,
                            'penalty_rate' => null
                        ];
                        

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dag_premium->dag_no);
                        $this->db->update('reclass_dag_details', $dagPenaltyArr);

                        //*******check if data updated */
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                        }

                        //var_dump($sumMbAmount);$this->db->trans_rollback();exit;
                      

                         if($sumMbAmount != $this->input->post('finalamount'))
                        {
                           log_message('error', '#AMOUNTPREM: '.json_encode($sumMbAmount.'-'.$this->input->post('finalamount')));
                            // var_dump("Amount mismatch!!!"); die;
                            // $this->db->trans_rollback();
                            // $this->session->set_flashdata('message', "Error #ERRAM0001: reclass Application not submitted case no # $application_no");
                            // log_message('error', '#ERRAM0001: Premium ghotala by LM, RTPS Case No '.$application_no);
                            // redirect(base_url() . "index.php/home");

                             $this->db->trans_rollback();
                            log_message('error', '#ERRAM0001: Updation failed in reclass_suite_basic RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRAM0001: Registration of Reclassification failed for case no,Fill the premium correctly : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                        foreach ($lmdata['dags'] as $dag_premium) 
                        {

                        $fmd=array(
                            'case_no'=>$case_no,
                            'user_code'=>$this->session->userdata('user_code'),
                            'uuid'=>$basic['uuid'],
                            'dag_no'=>$dag_premium->dag_no,
                            'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                            'land_type'=>$this->input->post('land_type'.$dag_premium->dag_no),
                            'rate_type'=>$this->input->post('rate_type'.$dag_premium->dag_no),
                            'rate'=>$this->input->post('rate'.$dag_premium->dag_no),
                            'amount_dag'=>$this->input->post('amount'.$dag_premium->dag_no),
                            'final_amount'=>$this->input->post('finalamount'),
                            'due_amount'=>$this->input->post('totaldue'),
                            'total_lessa'=>$this->input->post('total_lessa'.$dag_premium->dag_no),
                            //'is_full_pay'=>$this->input->post('paymode'),
                            'is_final'=>1,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            //'approve_by'=>$this->input->post('approval'.$dag_premium->dag_no),
                            'penalty_rate' => null,

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
                        
                    }

                          
                          
                  /// premium insert lm update end
              }
            }

              if($validation_bypass == 1)
              {
                  //****validation bypass required insertions  */
                  $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                      RECLASS_ID,
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

              //////proceeding end//////

                $partition_info = $this->reclassModel->getPartionInfo($case_no);//return
                $wet_land_info = $this->reclassModel->getWetLandInfo($case_no);
                $applicant_type = $this->input->post('applicant_type');

                $basicData = [
                    'partition_enable'=> $partition_info,
                    'wet_land'        => $wet_land_info,
                    'applicant_type'  => $applicant_type
                    
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('reclass_suite_basic', $basicData);

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR1111: Updation failed in reclass_suite_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR1111: Registration of Reclassification failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }


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
                  $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                  $rtps_status = json_decode($rtps_status);
                  //var_dump($rtps_status);
                  if (trim($rtps_status) !="y") {
                      $this->db->trans_rollback();
                      $this->session->set_flashdata('message', "Error #ERRAPP0011: Reclassification Application not submitted case no # $case_no");
                      redirect(base_url() . "index.php/home");
                  } else {
                      $this->db->trans_commit();
                  }

                  // $this->DashboardInheritance($case_no['case_no']);
                  //////
                  $this->session->set_flashdata('message', "Reclassification Application Updated Successfully with case no # $case_no");
                  redirect(base_url() . "index.php/home");

              }
          }
      }
  }


  public function forwardedByCo()
  {
    $service_code       = $this->input->get('service');
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no             = $this->session->userdata('lot_no');
    $define_date        = define_date;
    $user_code          = $this->session->userdata('user_code');

    $cases['cases']     = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM' and date_entry >= '$define_date'")->result();

    $cases['_view'] = 'TeaGrant/LM/ForwardedByCoTeaGrantLMList';
    $this->load->view('layouts/main', $cases);
  }



  public function getValidationBypass($service_code)
  {
    if(!$service_code)
    {
      return false;
    }
    foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $cons_reasons)
    {
      if($cons_reasons->SERVICE_CODE == $service_code)
      {
        $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
      }
    }
    return $validation_bypass_array;
  }



private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

}
